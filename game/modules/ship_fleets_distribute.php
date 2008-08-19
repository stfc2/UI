<?php
/*    
	This file is part of STFC.
	Copyright 2006-2007 by Michael Krauss (info@stfc2.de) and Tobias Gafner
		
	STFC is based on STGC,
	Copyright 2003-2007 by Florian Brede (florian_brede@hotmail.com) and Philipp Schmidt
	
    STFC is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    STFC is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



$game->init_player();

if(!empty($_GET['new_fleet'])) {
    if(empty($_POST['ships'])) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if(empty($_POST['new_fleet_name'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    $old_fleet_id = (int)$_GET['new_fleet'];
    $new_fleet_name = addslashes(htmlspecialchars($_POST['new_fleet_name']));

    // #############################################################################
    // Fleet data query

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE fleet_id = '.$old_fleet_id;

    if(($old_fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($old_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if($old_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    // #############################################################################
    // Parse $_POST['ships']

    $ship_ids = array();

    for($i = 0; $i < count($_POST['ships']); ++$i) {
        $_temp = (int)$_POST['ships'][$i];

        if(!empty($_temp)) {
            $ship_ids[] = $_temp;
        }
    }

    if(empty($ship_ids)) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    $changed_ships = count($ship_ids);

    $sql = 'SELECT COUNT(ship_id) AS num FROM ships WHERE ship_id IN ('.implode(',', $ship_ids).') AND fleet_id='.$old_fleet_id;
    if(!($get_row=$db->queryrow($sql))) {message(DATABASE_ERROR, 'Could not query ships fleet data');}
    if($get_row['num']!=$changed_ships) {message(NOTICE, constant($game->sprache("TEXT3")));}


    if($changed_ships > $old_fleet['n_ships']) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }
    elseif($changed_ships == $old_fleet['n_ships']) {
        message(NOTICE, constant($game->sprache("TEXT5")));
    }

    // #############################################################################
    // Check load of the fleet

    $n_oresources = $old_fleet['resource_1'] + $old_fleet['resource_2'] + $old_fleet['resource_3'];
    $n_ounits = $old_fleet['resource_4'] + $old_fleet['unit_1'] + $old_fleet['unit_2'] + $old_fleet['unit_3'] + $old_fleet['unit_4'] + $old_fleet['unit_5'] + $old_fleet['unit_6'];

    // Only if the old fleet cannot carry the past load any longer, parts are shifted
    // on the new fleet to the maximum of their capacity
    // (is substantially simpler to program) 
    $wares_loaded = ( ($n_oresources > 0) || ($n_ounits) );

    // Here the load, which is loaded to the new fleet, are stored
    $nwares = array();

    // Controls the SQL behavior when Update
    $distribute_wares = false;


    // #############################################################################
    // Determine redistribution of cargo

    if($wares_loaded) {
        $sql = 'SELECT s.ship_id
                FROM (ships s, ship_templates st)
                WHERE s.fleet_id  = '.$old_fleet_id.' AND
                      st.id = s.template_id AND
                      st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

        if(!$q_transporter = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query ships data');
        }

        // $_o -> old, unver???derte fleet
        // $_n -> new, reduced fleet
        // $_c -> new, separated fleet
        //        (c comes from change, since this code is a modified change_fleet)

        $n_ntransporter = $n_ctransporter = 0;

        while($_ship = $db->fetchrow($q_transporter)) {
            if(in_array($_ship['ship_id'], $ship_ids)) $n_ctransporter++;
            else $n_ntransporter++;
        }

        $max_nresources = $n_ntransporter * MAX_TRANSPORT_RESOURCES;
        $max_nunits = $n_ntransporter * MAX_TRANSPORT_UNITS;

        // Adjust raw materials
        $n_nresources = $n_oresources;
        $r_type = 1;

        while($n_nresources > $max_nresources) {
            if($r_type == 4) {
                message(GENERAL, constant($game->sprache("TEXT6")), 'Unexspected: $r_type = 4');
            }

            $to_move = $n_nresources - $max_nresources;

            if($old_fleet['resource_'.$r_type] < $to_move) $to_move = $old_fleet['resource_'.$r_type];

            $nwares['resource_'.$r_type] = $to_move;
            $n_nresources -= $to_move;

            ++$r_type;
        }

        // Adjust units
        // NOTICE: Etwas komplizierter, da es nicht linear verl???ft, sondern
        //         resource_4 -> unit_1 vorkommt, daher werden wir resource_4
        //         zuerst gesondert bearbeiten und dann ggf. noch in einem
	    //         while() die unit_1 - unit_6
        $n_nunits = $n_ounits;

        if($n_nunits > $max_nunits) {
            $to_move = $n_nunits - $max_nunits;

            if($old_fleet['resource_4'] < $to_move) $to_move = $old_fleet['resource_4'];

            $nwares['resource_4'] = $to_move;
            $n_nunits -= $to_move;
        }

        $u_type = 1;

        while($n_nunits > $max_nunits) {
            if($u_type == 7) {
                message(GENERAL, constant($game->sprache("TEXT7")), 'Unexspected: $u_type = 7');
            }

            $to_move = $n_nunits - $max_nunits;

            if($old_fleet['unit_'.$u_type] < $to_move) $to_move = $old_fleet['unit_'.$u_type];

            $nwares['unit_'.$u_type] = $to_move;
            $n_nunits -= $to_move;

            ++$u_type;
        }

        // ???erprfung, ob Waren getauscht wurden
        // IMPORTANT: If, absolutely sure, that ALL values exist into
        //            $nwares, since there are otherwise SQL syntax errors 

        if(!empty($nwares)) {
            $distribute_wares = true;

            // Theoretically had to be always set the first value, but 
            // is safe reliably
            if(empty($nwares['resource_1'])) $nwares['resource_1'] = 0;
            if(empty($nwares['resource_2'])) $nwares['resource_2'] = 0;
            if(empty($nwares['resource_3'])) $nwares['resource_3'] = 0;
            if(empty($nwares['resource_4'])) $nwares['resource_4'] = 0;
            if(empty($nwares['unit_1'])) $nwares['unit_1'] = 0;
            if(empty($nwares['unit_2'])) $nwares['unit_2'] = 0;
            if(empty($nwares['unit_3'])) $nwares['unit_3'] = 0;
            if(empty($nwares['unit_4'])) $nwares['unit_4'] = 0;
            if(empty($nwares['unit_5'])) $nwares['unit_5'] = 0;
            if(empty($nwares['unit_6'])) $nwares['unit_6'] = 0;
        }
    }
    
    // #############################################################################
    // Update data of the old fleet

    if($distribute_wares) {
        $sql = 'UPDATE ship_fleets
                SET resource_1 = resource_1 - '.$nwares['resource_1'].',
                    resource_2 = resource_2 - '.$nwares['resource_2'].',
                    resource_3 = resource_3 - '.$nwares['resource_3'].',
                    resource_4 = resource_4 - '.$nwares['resource_4'].',
                    unit_1 = unit_1 - '.$nwares['unit_1'].',
                    unit_2 = unit_2 - '.$nwares['unit_2'].',
                    unit_3 = unit_3 - '.$nwares['unit_3'].',
                    unit_4 = unit_4 - '.$nwares['unit_4'].',
                    unit_5 = unit_5 - '.$nwares['unit_5'].',
                    unit_6 = unit_6 - '.$nwares['unit_6'].',
                    n_ships = n_ships - '.$changed_ships.'
                WHERE fleet_id = '.$old_fleet_id;
    }
    else {
        $sql = 'UPDATE ship_fleets
                SET n_ships = n_ships - '.$changed_ships.'
                WHERE fleet_id = '.$old_fleet_id;
    }

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update old fleet data');
    }
    
    // #############################################################################
    // Create new fleet
    
    if($distribute_wares) {
        $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships, resource_1, resource_2, resource_3, resource_4, unit_1, unit_2, unit_3, unit_4, unit_5, unit_6)
                VALUES ("'.$new_fleet_name.'", '.$game->player['user_id'].', '.( (!empty($old_fleet['planet_id'])) ? $old_fleet['planet_id'].', 0' : '0, '.$old_fleet['move_id'] ).', '.$changed_ships.', '.$nwares['resource_1'].', '.$nwares['resource_2'].', '.$nwares['resource_3'].', '.$nwares['resource_4'].', '.$nwares['unit_1'].', '.$nwares['unit_2'].', '.$nwares['unit_3'].', '.$nwares['unit_4'].', '.$nwares['unit_5'].', '.$nwares['unit_6'].')';
    }
    else {
        $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships, resource_1, resource_2, resource_3, resource_4, unit_1, unit_2, unit_3, unit_4, unit_5, unit_6)
                VALUES ("'.$new_fleet_name.'", '.$game->player['user_id'].', '.( (!empty($old_fleet['planet_id'])) ? $old_fleet['planet_id'].', 0' : '0, '.$old_fleet['move_id'] ).', '.$changed_ships.', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)';
    }
    
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new fleet data');
    }
    
    $new_fleet_id = $db->insert_id();
    
    if(empty($new_fleet_id)) {
        message(GENERAL, constant($game->sprache("TEXT8")), '$new_fleet_id = empty');
    }

    // #############################################################################
    // Update data of the ships

    $sql = 'UPDATE ships
            SET fleet_id = '.$new_fleet_id.'
            WHERE ship_id IN ('.implode(',', $ship_ids).') AND fleet_id='.$old_fleet_id;
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update ships fleet data');
    }
    
    // #############################################################################
    // Redirect and/or Redistribute message

    if($distribute_wares) {
        $game->out('<center><span class="caption">'.constant($game->sprache("TEXT9")).'</span></center>');

        $str = constant($game->sprache("TEXT10"));

        $wares_names = get_wares_names();

        foreach($nwares as $key => $value) {
            if($value > 0) $str .= $wares_names[$key].': <b>'.$value.'</b><br>';
        }

        $str .= '<br><a href="'.parse_link('a=ship_fleets_display&'.( (!empty($old_fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$old_fleet_id).'">'.constant($game->sprache("TEXT11")).'</a><br><a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$new_fleet_id).'">'.constant($game->sprache("TEXT12")).'</a>';

        message(NOTICE, $str);
    }
    else {
        redirect('a=ship_fleets_display&'.( (!empty($old_fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$new_fleet_id);
    }
}
elseif(!empty($_GET['change_fleet'])) {
    if(empty($_POST['ships'])) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if(empty($_POST['to_fleet'])) {
        message(NOTICE, constant($game->sprache("TEXT13")));
    }

    $old_fleet_id = (int)$_GET['change_fleet'];
    $new_fleet_id = (int)$_POST['to_fleet'];

    // #############################################################################
    // Fleet data query

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE fleet_id IN ('.$old_fleet_id.', '.$new_fleet_id.')';

    if(($fleets = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }

    if($fleets[0]['fleet_id'] == $old_fleet_id) {
        $old_fleet = &$fleets[0];
        $new_fleet = &$fleets[1];
    }
    else {
        $old_fleet = &$fleets[1];
        $new_fleet = &$fleets[0];
    }

    if(empty($old_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if($old_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if(empty($new_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT14")));
    }

    if($new_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT14")));
    }

    // Ships can only change the fleet when they are on the same site
    if(!empty($old_fleet['planet_id'])) {
        if($old_fleet['planet_id'] != $new_fleet['planet_id']) {
            message(NOTICE, constant($game->sprache("TEXT15")));
        }
    }
    else {
        if($old_fleet['move_id'] != $new_fleet['move_id']) {
            message(NOTICE, constant($game->sprache("TEXT16")));
        }
    }

    // #############################################################################
    // Parse $_POST['ships']

    $ship_ids = array();

    for($i = 0; $i < count($_POST['ships']); ++$i) {
        $_temp = (int)$_POST['ships'][$i];

        if(!empty($_temp)) {
            $ship_ids[] = $_temp;
        }
    }


    if(empty($ship_ids)) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    $changed_ships = count($ship_ids);

    $sql = 'SELECT COUNT(ship_id) AS num FROM ships WHERE ship_id IN ('.implode(',', $ship_ids).') AND fleet_id='.$old_fleet_id;
    if(!($get_row=$db->queryrow($sql))) {message(DATABASE_ERROR, 'Could not query ships fleet data');}
    if($get_row['num']!=$changed_ships) {message(NOTICE, constant($game->sprache("TEXT3")));}



    if($changed_ships > $old_fleet['n_ships']) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }

    $all_ship_change = ($changed_ships == $old_fleet['n_ships']);

    // #############################################################################
    // Check load of the fleet

    $n_oresources = $old_fleet['resource_1'] + $old_fleet['resource_2'] + $old_fleet['resource_3'];
    $n_ounits = $old_fleet['resource_4'] + $old_fleet['unit_1'] + $old_fleet['unit_2'] + $old_fleet['unit_3'] + $old_fleet['unit_4'] + $old_fleet['unit_5'] + $old_fleet['unit_6'];

    // Only if the old fleet cannot carry the past load any longer, parts are shifted
    // on the new fleet to the maximum of their capacity
    // (is substantially simpler to program) 
    $wares_loaded = ( ($n_oresources > 0) || ($n_ounits) );

    // Here the load, which is loaded to the new fleet, are stored
    $nwares = array();

    // Controls the SQL behavior when Update
    $distribute_wares = false;


    // #############################################################################
    // Determine redistribution of cargo

    if($wares_loaded && $all_ship_change) {
        $nwares['resource_1'] = $old_fleet['resource_1'];
        $nwares['resource_2'] = $old_fleet['resource_2'];
        $nwares['resource_3'] = $old_fleet['resource_3'];
        $nwares['resource_4'] = $old_fleet['resource_4'];
        $nwares['unit_1'] = $old_fleet['unit_1'];
        $nwares['unit_2'] = $old_fleet['unit_2'];
        $nwares['unit_3'] = $old_fleet['unit_3'];
        $nwares['unit_4'] = $old_fleet['unit_4'];
        $nwares['unit_5'] = $old_fleet['unit_5'];
        $nwares['unit_6'] = $old_fleet['unit_6'];

        $distribute_wares = true;
    }
    elseif($wares_loaded) {
        $sql = 'SELECT s.ship_id
                FROM (ships s, ship_templates st)
                WHERE s.fleet_id  = '.$old_fleet_id.' AND
                      st.id = s.template_id AND
                      st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

        if(!$q_transporter = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query ships data');
        }

        // $_o -> old, unver???derte fleet
        // $_n -> new, reduced fleet
        // $_c -> changing ships

        $n_ntransporter = $n_ctransporter = 0;

        while($_ship = $db->fetchrow($q_transporter)) {
            if(in_array($_ship['ship_id'], $ship_ids)) $n_ctransporter++;
            else $n_ntransporter++;
        }

        $max_nresources = $n_ntransporter * MAX_TRANSPORT_RESOURCES;
        $max_nunits = $n_ntransporter * MAX_TRANSPORT_UNITS;

        // Adjust raw materials
        $n_nresources = $n_oresources;
        $r_type = 1;

        while($n_nresources > $max_nresources) {
            if($r_type == 4) {
                message(GENERAL, constant($game->sprache("TEXT6")), 'Unexspected: $r_type = 4');
            }

            $to_move = $n_nresources - $max_nresources;

            if($old_fleet['resource_'.$r_type] < $to_move) $to_move = $old_fleet['resource_'.$r_type];

            $nwares['resource_'.$r_type] = $to_move;
            $n_nresources -= $to_move;

            ++$r_type;
        }

        // Adjust units
        // NOTICE: Etwas komplizierter, da es nicht linear verl???ft, sondern
        //         resource_4 -> unit_1 vorkommt, daher werden wir resource_4
        //         zuerst gesondert bearbeiten und dann ggf. noch in ein while()
        $n_nunits = $n_ounits;

        if($n_nunits > $max_nunits) {
            $to_move = $n_nunits - $max_nunits;

            if($old_fleet['resource_4'] < $to_move) $to_move = $old_fleet['resource_4'];

            $nwares['resource_4'] = $to_move;
            $n_nunits -= $to_move;
        }

        $u_type = 1;

        while($n_nunits > $max_nunits) {
            if($u_type == 7) {
                message(GENERAL, constant($game->sprache("TEXT7")), 'Unexspected: $u_type = 7');
            }

            $to_move = $n_nunits - $max_nunits;

            if($old_fleet['unit_'.$u_type] < $to_move) $to_move = $old_fleet['unit_'.$u_type];

            $nwares['unit_'.$u_type] = $to_move;
            $n_nunits -= $to_move;

            ++$u_type;
        }

        // ???erprfung, ob Waren getauscht wurden
        // IMPORTANT: If, absolutely sure, that ALL values exist into
        //            $nwares, since there are otherwise SQL syntax errors 

        if(!empty($nwares)) {
            $distribute_wares = true;

            // Theoretically had to be always set the first value, but 
            // is safe reliably
            if(empty($nwares['resource_1'])) $nwares['resource_1'] = 0;
            if(empty($nwares['resource_2'])) $nwares['resource_2'] = 0;
            if(empty($nwares['resource_3'])) $nwares['resource_3'] = 0;
            if(empty($nwares['resource_4'])) $nwares['resource_4'] = 0;
            if(empty($nwares['unit_1'])) $nwares['unit_1'] = 0;
            if(empty($nwares['unit_2'])) $nwares['unit_2'] = 0;
            if(empty($nwares['unit_3'])) $nwares['unit_3'] = 0;
            if(empty($nwares['unit_4'])) $nwares['unit_4'] = 0;
            if(empty($nwares['unit_5'])) $nwares['unit_5'] = 0;
            if(empty($nwares['unit_6'])) $nwares['unit_6'] = 0;
        }
    }

    // #############################################################################
    // Update data of the ships

    $sql = 'UPDATE ships
            SET fleet_id = '.$new_fleet_id.'
            WHERE ship_id IN ('.implode(',', $ship_ids).') AND fleet_id='.$old_fleet_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update ships fleet data');
    }

    // #############################################################################
    // Update data of the old fleet

    if($all_ship_change) {
        $sql = 'DELETE FROM ship_fleets
                WHERE fleet_id = '.$old_fleet_id;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not delete old fleets data');
        }
    }
    else {
        if($distribute_wares) {
            $sql = 'UPDATE ship_fleets
                    SET resource_1 = resource_1 - '.$nwares['resource_1'].',
                        resource_2 = resource_2 - '.$nwares['resource_2'].',
                        resource_3 = resource_3 - '.$nwares['resource_3'].',
                        resource_4 = resource_4 - '.$nwares['resource_4'].',
                        unit_1 = unit_1 - '.$nwares['unit_1'].',
                        unit_2 = unit_2 - '.$nwares['unit_2'].',
                        unit_3 = unit_3 - '.$nwares['unit_3'].',
                        unit_4 = unit_4 - '.$nwares['unit_4'].',
                        unit_5 = unit_5 - '.$nwares['unit_5'].',
                        unit_6 = unit_6 - '.$nwares['unit_6'].',
                        n_ships = n_ships - '.$changed_ships.'
                    WHERE fleet_id = '.$old_fleet_id;
        }
        else {
            $sql = 'UPDATE ship_fleets
                    SET n_ships = n_ships - '.$changed_ships.'
                    WHERE fleet_id = '.$old_fleet_id;
        }

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update old fleet data');
        }
    }

    // #############################################################################
    // Update data of the new fleet

    if($distribute_wares) {
        $sql = 'UPDATE ship_fleets
                SET resource_1 = resource_1 + '.$nwares['resource_1'].',
                    resource_2 = resource_2 + '.$nwares['resource_2'].',
                    resource_3 = resource_3 + '.$nwares['resource_3'].',
                    resource_4 = resource_4 + '.$nwares['resource_4'].',
                    unit_1 = unit_1 + '.$nwares['unit_1'].',
                    unit_2 = unit_2 + '.$nwares['unit_2'].',
                    unit_3 = unit_3 + '.$nwares['unit_3'].',
                    unit_4 = unit_4 + '.$nwares['unit_4'].',
                    unit_5 = unit_5 + '.$nwares['unit_5'].',
                    unit_6 = unit_6 + '.$nwares['unit_6'].',
                    n_ships = n_ships + '.$changed_ships.'
                WHERE fleet_id = '.$new_fleet_id;
    }
    else {
        $sql = 'UPDATE ship_fleets
                SET n_ships = n_ships + '.$changed_ships.'
                WHERE fleet_id = '.$new_fleet_id;
    }

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update new fleet data');
    }
    
    // #############################################################################
    // Redirect and/or Redistribute message

    if($distribute_wares && !$all_ship_change) {
        $game->out('<center><span class="caption">'.constant($game->sprache("TEXT9")).'</span></center>');

        $str = constant($game->sprache("TEXT10"));

        $wares_names = get_wares_names();

        foreach($nwares as $key => $value) {
            if($value > 0) $str .= $wares_names[$key].': <b>'.$value.'</b><br>';
        }

        $str .= '<br><a href="'.parse_link('a=ship_fleets_display&'.( (!empty($old_fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$old_fleet_id).'">'.constant($game->sprache("TEXT11")).'</a><br><a href="'.parse_link('a=ship_fleets_display&'.( (!empty($new_fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$new_fleet_id).'">'.constant($game->sprache("TEXT12")).'</a>';

        message(NOTICE, $str);
    }
    else {
        redirect('a=ship_fleets_display&'.( (!empty($new_fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$new_fleet_id);
    }
}
else {
    redirect('a=ship_fleets_display');
}

?>
