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

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Create Ships</span><br><br>');

if(isset($_POST['submit'])) {
    $template_id = (int)$_POST['template_id'];
    $n_ships = (int)$_POST['n_ships'];
    $units = (int)$_POST['units'];
    $user_id = (int)$_POST['user_id'];
    $add_type = (int)$_POST['add_type'];
    $new_fleet_name = addslashes($_POST['new_fleet_name']);
    $new_fleet_planet = (int)$_POST['new_fleet_planet'];
    $add_fleet_id = (int)$_POST['add_fleet_id'];
    $offduty_planet = (int)$_POST['offduty_planet'];

    $sql = 'SELECT *
            FROM ship_templates
            WHERE id = '.$template_id;

    if(($stpl = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ship template data');
    }

    switch($add_type) {
        case 1:
            $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships)
                    VALUES ("'.$new_fleet_name.'", '.$user_id.', '.$new_fleet_planet.', 0, '.$n_ships.')';
                    
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not insert new fleets data');
            }

            $fleet_id = $db->insert_id();

            if(!$fleet_id) {
                message(GENERAL, 'Error', '$fleet_id = empty');
            }

            $where_created = 'on Planet <b>#'.$new_fleet_planet.'</b>';
        break;
        
        case 2:
            $sql = 'UPDATE ship_fleets
                    SET n_ships = n_ships + '.$n_ships.'
                    WHERE fleet_id = '.$add_fleet_id;
                    
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update fleets n_ships data');
            }

            $fleet_id = $add_fleet_id;
            $where_created = 'in Fleet <b>#'.$add_fleet_id.'</b>';
        break;

        case 3:
            $fleet_id = (-1)*$offduty_planet;
            $where_created = 'in Drydock <b>#'.$offduty_planet.'</b>';
        break;
    }

    if($units == 1) {
        $units_str = $stpl['min_unit_1'].', '.$stpl['min_unit_2'].', '.$stpl['min_unit_3'].', '.$stpl['min_unit_4'];
    }
    else {
        $units_str = $stpl['max_unit_1'].', '.$stpl['max_unit_2'].', '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'];
    }


    $sql = 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time, unit_1, unit_2, unit_3, unit_4, rof, torp, last_refit_time)
            VALUES ('.$fleet_id.', '.$user_id.', '.$template_id.', '.$stpl['value_9'].', '.$stpl['value_5'].', '.$game->TIME.', '.$units_str.', '.$stpl['rof'].', '.$stpl['max_torp'].', '.$game->TIME.')';
            
    for($i = 0; $i < $n_ships; ++$i) {
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new ships #'.$i.' data');
        }
    }

    $sql = 'SELECT * FROM ship_templates WHERE id = '.$template_id;

    if(($template = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query template data');
    }

    $sql = 'SELECT * FROM user WHERE user_id = '.$user_id;

    if(($user = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user data');
    }

    $fp = fopen(ADMIN_LOG_FILE, 'a');
      fwrite($fp, '<hr><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>Action:</b> The User <b>'.$game->player['user_name'].'</b> has generated <b>'.$n_ships.'</b> ships for Player <b>'.$user['user_name'].' (#'.$user_id.')</b> -  from Template <b>'.$template['name'].' (#'.$template_id.')</b> '.$where_created.'<br>');
      fclose($fp);

    redirect('a=tools/ships/create');
}
elseif(!empty($_GET['filter_type'])) {
    $filter_type = addslashes($_GET['filter_type']);

	$order_method = 'ORDER BY st.name ASC';
    if(isset($_GET['order_by_id']))
        $order_method = 'ORDER BY st.id ASC';
    switch($filter_type) {
        case 'ship_torso':
            $filter_id = (int)$_GET['filter_id'];

            $sql = 'SELECT st.id, st.ship_torso, st.race, st.name,
                           u.user_name
                    FROM ship_templates st
                    LEFT JOIN user u ON u.user_id = st.owner
                    WHERE st.ship_torso = '.$filter_id.' AND st.removed = 0
                    '.$order_method;
        break;

        case 'race':
            $filter_id = (int)$_GET['filter_id'];
            
            $sql = 'SELECT st.id, st.ship_torso, st.race, st.name,
                           u.user_name
                    FROM ship_templates st
                    LEFT JOIN user u ON u.user_id = st.owner
                    WHERE st.race = '.$filter_id.' AND st.removed = 0
                    '.$order_method;
        break;

        case 'none':
            $sql = 'SELECT st.id, st.ship_torso, st.race, st.name,
                           u.user_name
                    FROM ship_templates st
                    LEFT JOIN user u ON u.user_id = st.owner
                    WHERE st.removed = 0
                    '.$order_method;
        break;
    }

    if(!$q_stpls = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query ship template data');
    }

    $game->out('
<br><br>
<form method="post" action="'.parse_link('a=tools/ships/create').'">
Template:&nbsp;&nbsp;<select name="template_id">
    ');

    while($stpl = $db->fetchrow($q_stpls)) {
        $game->out('<option value="'.$stpl['id'].'">'.$stpl['name'].' ('.$stpl['id'].', '.$SHIP_TORSO[$stpl['race']][$stpl['ship_torso']][29].', '.$RACE_DATA[$stpl['race']][0].') of '.$stpl['user_name'].'</option>');
    }

    $game->out('
</select><br><br>
Number:&nbsp;&nbsp;<input class="field" type="text" name="n_ships">&nbsp;&nbsp;<select name="units"><option value="1">minimal troop strength</option><option value="2">maximum troop strength</option></select><br><br>
Player (ID):&nbsp;&nbsp;<input class="field" type="text" name="user_id"><br><br>
<input type="radio" name="add_type" value="1" checked="checked">&nbsp;&nbsp;New fleet:&nbsp;&nbsp;<input class="field" type="text" name="new_fleet_name">&nbsp;At planet (ID)&nbsp;<input class="field" type="text" name="new_fleet_planet"><br><br>
<input type="radio" name="add_type" value="2">&nbsp;&nbsp;Add to fleet (ID):&nbsp;&nbsp;<input class="field" type="text" name="add_fleet_id"><br><br>
<input type="radio" name="add_type" value="3">&nbsp;&nbsp;Spacedock:&nbsp;&nbsp;<input class="field" type="text" name="offduty_planet"><br><br><br>
<input class="button" type="submit" name="submit" value="Apply">
</form>
    ');
}
else {
    $game->out('
<br><br>
<center>
Order template by ID: <input type="checkbox" name="order_by_id">
<br><br>
Show Torso:
    ');

    for($i = 0; $i < 13; ++$i) {
        $game->out('[<a href="'.parse_link('a=tools/ships/create&filter_type=ship_torso&filter_id='.$i).'">'.($i+1).'</a>]');
    }
    
    $game->out('
<br><br>
    ');

    for($i = 0; $i < count($RACE_DATA); ++$i) {
        $game->out('[<a href="'.parse_link('a=tools/ships/create&filter_type=race&filter_id='.$i).'">'.$RACE_DATA[$i][0].'</a>]');
    }

    $game->out('
<br><br>
<a href="'.parse_link('a=tools/ships/create&filter_type=none').'">Show all templates</a> (<b>VERY BIG DOCUMENT!!!!</b>)</center>
    ');
}

?>
