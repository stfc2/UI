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

include('include/static/static_components.php');
$filename = 'include/static/static_components_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);







function CreateShipInfoText($ship)

{

global $db;

global $game;

$text='<b>'.$ship[31].'</b><br><br><u>'.constant($game->sprache("TEXT0")).'</u><br>';



$text.=constant($game->sprache("TEXT1")).' '.$ship[14].' x '.$ship[32].'<br>';

$text.=constant($game->sprache("TEXT2")).' '.$ship[15].' x '.$ship[33].'<br>';

$text.=constant($game->sprache("TEXT60")).' '.$ship[34].'<br>';

$text.=constant($game->sprache("TEXT3")).' '.$ship[16].'<br>';

$text.=constant($game->sprache("TEXT4")).' '.$ship[17].'<br>';

$text.=constant($game->sprache("TEXT5")).' '.$ship[18].'<br>';

$text.=constant($game->sprache("TEXT6")).' '.$ship[19].'<br>';

$text.=constant($game->sprache("TEXT7")).' '.$ship[20].'<br>';

$text.=constant($game->sprache("TEXT8")).' '.$ship[21].'<br>';

$text.=constant($game->sprache("TEXT9")).' '.$ship[22].'<br>';

$text.=constant($game->sprache("TEXT10")).' '.$ship[23].'<br>';

$text.=constant($game->sprache("TEXT11")).' '.$ship[24].'<br>';

$text.=constant($game->sprache("TEXT12")).' '.$ship[25].'<br>';

$text.=constant($game->sprache("TEXT13")).' '.$ship[27].'<br>';

$text.=constant($game->sprache("TEXT14")).' '.$ship[26].'<br>';





return $text;

}



function CreateCompInfoText($comp)

{

global $db;

global $game;

$text=''.$comp['description'].'<br><br>'.constant($game->sprache("TEXT0")).'</u><br>';



if ($comp['value_1']!=0) $text.=constant($game->sprache("TEXT1")).' '.$comp['value_1'].'<br>';

if ($comp['value_2']!=0) $text.=constant($game->sprache("TEXT2")).' '.$comp['value_2'].'<br>';

if ($comp['value_3']!=0) $text.=constant($game->sprache("TEXT3")).' '.$comp['value_3'].'<br>';

if ($comp['value_4']!=0) $text.=constant($game->sprache("TEXT4")).' '.$comp['value_4'].'<br>';

if ($comp['value_5']!=0) $text.=constant($game->sprache("TEXT5")).' '.$comp['value_5'].'<br>';

if ($comp['value_6']!=0) $text.=constant($game->sprache("TEXT6")).' '.$comp['value_6'].'<br>';

if ($comp['value_7']!=0) $text.=constant($game->sprache("TEXT7")).' '.$comp['value_7'].'<br>';

if ($comp['value_8']!=0) $text.=constant($game->sprache("TEXT8")).' '.$comp['value_8'].'<br>';

if ($comp['value_9']!=0) $text.=constant($game->sprache("TEXT9")).' '.$comp['value_9'].'<br>';

if ($comp['value_10']!=0) $text.=constant($game->sprache("TEXT10")).' '.$comp['value_10'].'<br>';

if ($comp['value_11']!=0) $text.=constant($game->sprache("TEXT11")).' '.$comp['value_11'].'<br>';

if ($comp['value_12']!=0) $text.=constant($game->sprache("TEXT12")).' '.$comp['value_12'].'<br>';

if ($comp['value_14']!=0) $text.=constant($game->sprache("TEXT13")).' '.$comp['value_14'].'<br>';

if ($comp['value_13']!=0) $text.=constant($game->sprache("TEXT14")).' '.$comp['value_13'].'<br>';

if ($comp['value_16']!=0) $text.=constant($game->sprache("TEXT75")).' '.$comp['value_16'].'<br>';

if ($comp['value_17']!=0) $text.=constant($game->sprache("TEXT76")).' '.$comp['value_17'].'<br>';

if ($comp['value_18']!=0) $text.=constant($game->sprache("TEXT60")).' '.$comp['value_18'].'<br>';

return $text;

}



if(!empty($_GET['rename_fleet'])) {

    if(empty($_POST['fleet_name'])) {

        message(NOTICE, constant($game->sprache("TEXT15")));

    }



    $fleet_id = (int)$_GET['rename_fleet'];

    $new_name = htmlspecialchars($_POST['fleet_name']);



    $sql = 'SELECT *

            FROM ship_fleets

            WHERE fleet_id = '.$fleet_id;



    if(($fleet = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query fleets data');

    }



    if(empty($fleet['fleet_id'])) {

        message(NOTICE, constant($game->sprache("TEXT16")));

    }



    if($fleet['user_id'] != $game->player['user_id']) {

        message(NOTICE, constant($game->sprache("TEXT16")));

    }



    $sql = 'UPDATE ship_fleets

            SET fleet_name = "'.$new_name.'"

            WHERE fleet_id = '.$fleet_id;



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleet data');

    }



    redirect('a=ship_fleets_display&'.( (!empty($fleet['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$fleet_id);

}

elseif(isset($_GET['join_fleets'])) {

    if(empty($_POST['fleets'])) {

        message(NOTICE, constant($game->sprache("TEXT17")));

    }



    $n_fleets = count($_POST['fleets']);



    if($n_fleets == 1) {

        message(NOTICE, constant($game->sprache("TEXT18")));

    }



    $fleet_ids = array();



    for($i = 0; $i < $n_fleets; ++$i) {

        $_temp = (int)$_POST['fleets'][$i];



        if(!empty($_temp)) {

            $fleet_ids[] = $_temp;

        }

    }



    if(empty($fleet_ids)) {

        message(NOTICE, constant($game->sprache("TEXT17")));

    }



    $fleet_ids_str = implode(',', $fleet_ids);



    $sql = 'SELECT *

            FROM ship_fleets

            WHERE fleet_id IN ('.$fleet_ids_str.')';



    if(!$q_fleets = $db->query($sql)) {

        message(DATABASE_ERROR, 'Could not query old fleets data');

    }



    $first_fleet = $db->fetchrow($q_fleets);

    $n_fleets = 1; // $first_fleet already!



    $fwares = array(

        'resource_1' => $first_fleet['resource_1'], 'resource_2' => $first_fleet['resource_2'], 'resource_3' => $first_fleet['resource_3'], 'resource_4' => $first_fleet['resource_4'],

        'unit_1' => $first_fleet['unit_1'], 'unit_2' => $first_fleet['unit_2'], 'unit_3' => $first_fleet['unit_3'], 'unit_4' => $first_fleet['unit_4'], 'unit_5' => $first_fleet['unit_5'], 'unit_6' => $first_fleet['unit_6']

    );



    if(!empty($first_fleet['planet_id'])) {

        while($fleet = $db->fetchrow($q_fleets)) {

            if($first_fleet['planet_id'] != $fleet['planet_id']) {

                message(NOTICE, constant($game->sprache("TEXT19")));

            }



            $n_fleets++;



            $fwares['resource_1'] += $fleet['resource_1'];

            $fwares['resource_2'] += $fleet['resource_2'];

            $fwares['resource_3'] += $fleet['resource_3'];

            $fwares['resource_4'] += $fleet['resource_4'];

            $fwares['unit_1'] += $fleet['unit_1'];

            $fwares['unit_2'] += $fleet['unit_2'];

            $fwares['unit_3'] += $fleet['unit_3'];

            $fwares['unit_4'] += $fleet['unit_4'];

            $fwares['unit_5'] += $fleet['unit_5'];

            $fwares['unit_6'] += $fleet['unit_6'];

        }

    }

    elseif(!empty($first_fleet['move_id'])) {

        while($fleet = $db->fetchrow($q_fleets)) {

            if($first_fleet['move_id'] != $fleet['move_id']) {

                message(NOTICE, constant($game->sprache("TEXT20")));

            }



            $n_fleets++;



            $fwares['resource_1'] += $fleet['resource_1'];

            $fwares['resource_2'] += $fleet['resource_2'];

            $fwares['resource_3'] += $fleet['resource_3'];

            $fwares['resource_4'] += $fleet['resource_4'];

            $fwares['unit_1'] += $fleet['unit_1'];

            $fwares['unit_2'] += $fleet['unit_2'];

            $fwares['unit_3'] += $fleet['unit_3'];

            $fwares['unit_4'] += $fleet['unit_4'];

            $fwares['unit_5'] += $fleet['unit_5'];

            $fwares['unit_6'] += $fleet['unit_6'];

        }

    }

    else {

        message(GENERAL, constant($game->sprache("TEXT21")), '$first_fleet[\'planet_id\'] = empty AND $first_fleet[\'move_id\'] = empty');

    }



    if($n_fleets <= 1) {

        message(NOTICE, constant($game->sprache("TEXT22")).' '.$n_fleets.' '.constant($game->sprache("TEXT23")));

    }



    if(empty($_POST['join_fleet_name'])) {

        message(NOTICE, constant($game->sprache("TEXT24")));

    }



    $new_fleet_id = $first_fleet['fleet_id'];

    $new_name = addslashes($_POST['join_fleet_name']);



    $sql = 'SELECT COUNT(ship_id) AS n_ships

            FROM ships

            WHERE fleet_id IN ('.$fleet_ids_str.')';



    if(($_n_ships = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query n_ships data');

    }



    $n_ships = (int)$_n_ships['n_ships'];



    if($n_ships == 0) {

        message(NOTICE, constant($game->sprache("TEXT25")));

    }



    $sql = 'UPDATE ships

            SET fleet_id = '.$new_fleet_id.'

            WHERE fleet_id IN ('.$fleet_ids_str.')';



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update ships fleet data');

    }



    unset($fleet_ids[array_search($new_fleet_id, $fleet_ids)]);



    $sql = 'DELETE FROM ship_fleets

            WHERE fleet_id IN ('.implode(',', $fleet_ids).')';



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not delete old fleets data');

    }



    $sql = 'UPDATE ship_fleets

            SET fleet_name = "'.$new_name.'",

                n_ships = '.$n_ships.',

                resource_1 = '.$fwares['resource_1'].',

                resource_2 = '.$fwares['resource_2'].',

                resource_3 = '.$fwares['resource_3'].',

                resource_4 = '.$fwares['resource_4'].',

                unit_1 = '.$fwares['unit_1'].',

                unit_2 = '.$fwares['unit_2'].',

                unit_3 = '.$fwares['unit_3'].',

                unit_4 = '.$fwares['unit_4'].',

                unit_5 = '.$fwares['unit_5'].',

                unit_6 = '.$fwares['unit_6'].'

            WHERE fleet_id = '.$new_fleet_id;



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleets data');

    }



    redirect('a=ship_fleets_display');

}

elseif(!empty($_GET['set_alert_phase'])) {

    /* 01/07/10 - AC: Sitter cannot change anymore fleets alert phase */
    if($game->SITTING_MODE) {
        message(NOTICE, constant($game->sprache("TEXT59")));
    }

    $fleet_id = (int)$_GET['set_alert_phase'];



    if(!isset($_GET['to'])) {

        message(GENERAL, constant($game->sprache("TEXT26")), '$_GET[\'to\'] = empty');

    }



    $to = (int)$_GET['to'];



    if( ($to != ALERT_PHASE_GREEN) && ($to != ALERT_PHASE_YELLOW) && ($to != ALERT_PHASE_RED) ) {

        message(NOTICE, constant($game->sprache("TEXT27")));

    }



    $sql = 'UPDATE ship_fleets

            SET alert_phase = '.$to.'

            WHERE fleet_id = '.$fleet_id.' AND

                  user_id = '.$game->player['user_id'];



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleets alert phase data');

    }

    // Select which is the page we have to return
    if(isset($_GET['planet']))
        redirect('a=ship_fleets_display&pfleet_details='.$fleet_id);
    elseif(isset($_GET['move']))
        redirect('a=ship_fleets_display&mfleet_details='.$fleet_id);
    else
        redirect('a=ship_fleets_display');
}

elseif(isset($_GET['offduty_ships'])) {

    if(empty($_POST['ships'])) {
       message(NOTICE, constant($game->sprache("TEXT28")));
    }

    $_temp = (int)$_POST['ships'][0];
    if(!empty($_temp)) {

       $sql = 'SELECT p.planet_id, p.planet_owner, p.building_7, 
	              sf.fleet_id, sf.user_id, sf.n_ships,
	              sf.resource_1, sf.resource_2, sf.resource_3, sf.resource_4,
				  sf.unit_1, sf.unit_2, sf.unit_3, sf.unit_4, sf.unit_5, sf.unit_6
	           FROM (ships s, ship_templates st, ship_fleets sf, planets p)
               WHERE s.ship_id = '.$_temp.'
			     AND s.template_id = st.id 
			     AND s.fleet_id = sf.fleet_id
			     AND sf.planet_id = p.planet_id';

       if(!$q_fleetinfo = $db->query($sql)) {
          message(DATABASE_ERROR, 'Could not query ships data');
       }
	   
    } else {
	   message(NOTICE, constant($game->sprache("TEXT29")));
	}

    //Check to see if query returned any results. Needs a better explanation in NOTICE message I think.
    if ($db->num_rows($q_fleetinfo) == 0) {
	   message(NOTICE, constant($game->sprache("TEXT30")));
	}

    $fleetinfo = $db->fetchrow($q_fleetinfo);
	
    //Lots of checking to see if everything is ok
    if($fleetinfo['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT31")));
    }
	
    if($fleetinfo['planet_owner'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT32")));
    }

    if($fleetinfo['building_7'] < 1) {
        message(NOTICE, constant($game->sprache("TEXT33")).' '.$BUILDING_NAME[$game->player['user_race']][6].' '.constant($game->sprache("TEXT34")));
    }

    $ship_ids = array();

    $sql = 'SELECT COUNT(s.ship_id) AS n_spacedockships
            FROM (ships s)
            WHERE s.fleet_id = -'.$fleetinfo['planet_id'].'
            GROUP BY s.fleet_id';

    if(!$q_spacedockships = $db->query($sql)) {
       message(DATABASE_ERROR, 'Could not query spacedockships data');
    }

    $spacedockships = $db->fetchrow($q_spacedockships);

    if (count($_POST['ships']) + $spacedockships['n_spacedockships'] > $MAX_SPACEDOCK_SHIPS[$fleetinfo['building_7']]) {
       $no_ships = $MAX_SPACEDOCK_SHIPS[$fleetinfo['building_7']] - $spacedockships['n_spacedockships'];
       if ($no_ships < 0) {
          $no_ships = 0;
       }
    } else {
       $no_ships = count($_POST['ships']);
    }

    for($i = 0; $i < $no_ships; ++$i) {
        $_temp = (int)$_POST['ships'][$i];
        if(!empty($_temp)) {
            $ship_ids[] = $_temp;
        }
    }

    if(empty($ship_ids)) {
        //print_r($fleetinfo);
	//message(NOTICE, 'None ships selected or space port is full '.count($_POST['ships']).' chosen, '.$no_ships.' approved ('.$MAX_SPACEDOCK_SHIPS[$fleetinfo['building_7']].' max.; '.$spacedockships['n_spacedockships'].' already vebraucht -> Spacedock lvl: '.$fleetinfo['building_7'].')');
	message(NOTICE, constant($game->sprache("TEXT35")));
    }

    $ship_ids_str = implode(',', $ship_ids);

    $sql = 'SELECT s.ship_id, s.user_id, s.fleet_id,
                   st.ship_torso
            FROM (ships s, ship_templates st)
            WHERE st.id = s.template_id
			  AND s.ship_id IN ('.$ship_ids_str.')';

    if(!$q_ships = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query ships data');
    }
	
	if($db->num_rows($q_ships) != $no_ships) {
	   message(DATABASE_ERROR, 'One or more templates of the selected ships does not exist anymore.');
	}
	
    if($no_ships > $fleetinfo['n_ships']) {
        message(NOTICE, constant($game->sprache("TEXT36")));
    }

    $sql = 'SELECT COUNT(s.ship_id) AS n_transporter
            FROM (ships s, ship_templates st)
            WHERE s.fleet_id = '.$fleetinfo['fleet_id'].' AND
                  st.id = s.template_id AND
                  st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(!$tfleet = $db->queryrow($sql)) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    $n_transporter = (int)$tfleet['n_transporter'];

    while($ship = $db->fetchrow($q_ships)) {
	
        if($ship['fleet_id'] != $fleetinfo['fleet_id']) {
            message(NOTICE, constant($game->sprache("TEXT37")));
        }

        if($ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter--;

    }

    $n_resources = $fleetinfo['resource_1'] + $fleetinfo['resource_2'] + $fleetinfo['resource_3'];
    $n_units = $fleetinfo['resource_4'] + $fleetinfo['unit_1'] + $fleetinfo['unit_2'] + $fleetinfo['unit_3'] + $fleetinfo['unit_4'] + $fleetinfo['unit_5'] + $fleetinfo['unit_6'];

    if( ($n_resources > ($n_transporter * MAX_TRANSPORT_RESOURCES) ) || ($n_units > ($n_transporter * MAX_TRANSPORT_UNITS) ) ) {
        message(NOTICE, constant($game->sprache("TEXT38")));
    }

    //Everything checks out ok, update database fields
	
    $sql = 'UPDATE ships
            SET fleet_id = -'.$fleetinfo['planet_id'].', ship_untouchable = '.SHIP_IN_REFIT.', ship_repair='.($ACTUAL_TICK+REFIT_TICK).', last_refit_time = 0
            WHERE ship_id IN ('.$ship_ids_str.') ';

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update ships location data');
    }



    if($fleetinfo['n_ships'] == $no_ships) {
	
        $sql = 'DELETE FROM ship_fleets
                WHERE fleet_id = '.$fleetinfo['fleet_id'];

        if(!$db->query($sql)) {
           
		   //Something went wrong, trying to roll back UPDATE ships
           $sql = 'UPDATE ships
                   SET fleet_id = '.$fleetinfo['planet_id'].'
                   WHERE ship_id IN ('.$ship_ids_str.')';
		   $db->query($sql);
			
           message(DATABASE_ERROR, 'Could not delete fleets data');
        }

        redirect('a=spacedock');
		
    } else {

        $sql = 'UPDATE ship_fleets
                SET n_ships = n_ships - '.$no_ships.'
                WHERE fleet_id = '.$fleetinfo['fleet_id'];

        if(!$db->query($sql)) {
		           
		   //Something went wrong, trying to roll back UPDATE ships
           $sql = 'UPDATE ships
                   SET fleet_id = '.$fleetinfo['planet_id'].'
                   WHERE ship_id IN ('.$ship_ids_str.')';
		   $db->query($sql);
		   
           message(DATABASE_ERROR, 'Could not update fleets n_ships data');
        }

        redirect('a=ship_fleets_display&pfleet_details='.$fleetinfo['fleet_id']);

    }

}

elseif(isset($_GET['ship_details'])) {

    $ship_id = (!empty($_POST['ships'])) ? (int)$_POST['ships'][0] : (int)$_GET['ship_details'];



    if(empty($ship_id)) {

        message(NOTICE, constant($game->sprache("TEXT28")));

    }



    $sql = 'SELECT s.*, st.*,

                   f.fleet_name, f.planet_id, f.move_id,

                   p.planet_name, p2.planet_name AS mission_planet_name

            FROM (ships s)

            INNER JOIN (ship_templates st) ON st.id = s.template_id

            LEFT JOIN (ship_fleets f) ON f.fleet_id = s.fleet_id

            LEFT JOIN (planets p) ON p.planet_id = -s.fleet_id

            LEFT JOIN (planets p2) ON p2.planet_id = s.awayteamplanet_id

            WHERE s.ship_id = '.$ship_id;



    if(($ship = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query ship data');

    }



    if(empty($ship['ship_id'])) {

        message(NOTICE, constant($game->sprache("TEXT39")));

    }



    if($ship['user_id'] != $game->player['user_id']) {

        message(NOTICE, constant($game->sprache("TEXT39")));

    }

        $buff_dmg_redu = 0; // buff to dmg reduction
        $buff_value_1  = 0; // buff to primary weapon
        $buff_value_2  = 0; // buff to secondary weapon
        $buff_value_3  = 0; // buff to planetary weapon
        $buff_value_4  = 0; // buff to shields
        $buff_value_5  = 0; // buff to hull
        $buff_value_6  = 0; // buff to reaction
        $buff_value_8  = 0; // buff to agility
        $buff_value_11 = 0; // buff to sensor
        $buff_value_12 = 0; // buff to cloacking
        $buff_firststrike = 0; // buff to firsstrike
        $buff_rof      = 0; // buff to rof
        $buff_rof2     = 0; // buff to rof2
    
        $dmg_reduction = 5 + floor(1 * ($ship['unit_5']/3));
        
        $racebonustring = '<br><br><span style="color: lightgreen">'.constant($game->sprache("TEXT73")).'</span><br>';
        switch ($ship['race']) {
            case 0:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +15%</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT4")).' +15%</span></b><br>';
                    $buff_value_4 += floor(($ship['value_4'] * 1.15) - $ship['value_4']);
                    $buff_dmg_redu += 15;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +15%</span></b><br>';
                    $buff_dmg_redu += 15;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
            case 1:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +40</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT12")).' +10</span></b><br>';
                    $buff_value_12 += 10;
                    $buff_firststrike += 40;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +40</span></b><br>';
                    $buff_firststrike += 40;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
            case 2:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +40</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT49")).' +15%</span></b><br>';
                    $buff_value_2 += floor(($ship['value_2'] * 1.15) - $ship['value_2']);
                    $buff_firststrike += 40;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +40</span></b><br>';
                    $buff_firststrike += 40;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;                
            case 3:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +15%</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT48")).' +15%</span></b><br>';
                    $buff_value_1 += floor(($ship['value_1'] * 1.15) - $ship['value_1']);
                    $buff_dmg_redu += 15;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +15%</span></b><br>';
                    $buff_dmg_redu += 15;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;                
            case 4:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT48")).' +15%</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT47")).' +15%</span></b><br>';
                    $buff_value_5 += floor(($ship['value_5'] * 1.15) - $ship['value_5']);
                    $buff_value_1 += floor(($ship['value_1'] * 1.15) - $ship['value_1']);
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT48")).' +15%</span></b><br>';
                    $buff_value_1 += floor(($ship['value_1'] * 1.15) - $ship['value_1']);
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;                
            case 9:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +50</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT72")).' +1</span></b><br>';
                    $buff_rof  += 1;
                    $buff_rof2 += 1;
                    $buff_firststrike += 50;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +50</span></b><br>';
                    $buff_firststrike += 50;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;                
            case 11:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +25</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT70")).' +10%</span></b><br>';
                    $buff_value_2 += floor(($ship['value_2'] * 1.10) - $ship['value_2']);
                    $buff_value_1 += floor(($ship['value_1'] * 1.10) - $ship['value_1']);
                    $buff_firststrike += 25;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT61")).' +25</span></b><br>';                    
                    $buff_firststrike += 25;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
            case 13:
                if($ship['experience']>=$ship_ranks[9]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +10</span></b><br>'
                    . '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT47")).' +10%</span></b><br>';
                    $buff_value_5 += floor(($ship['value_5'] * 1.10) - $ship['value_5']);
                    $buff_dmg_redu += 10;
                    break;
                }
                if($ship['experience']>=$ship_ranks[2]) {
                    $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT68")).' +10</span></b><br>';                    
                    $buff_dmg_redu += 10;
                    break;
                }
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;                
            default :
                $racebonustring .= '<b><span style="color: lightgreen">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
        }
        
        $classbonustring = '<br><br><b><span style="color: cyan">'.constant($game->sprache("TEXT74")).'</span></b><br>';
        switch ($ship['ship_class']) {
            case 3:
                if($ship['experience']>=$ship_ranks[7]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +20%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT50")).' +50</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT1")).' +10%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT2")).' +10%</span></b><br>';
                    $buff_value_2 += floor(($ship['value_2'] * 1.10) - $ship['value_2']);
                    $buff_value_1 += floor(($ship['value_1'] * 1.10) - $ship['value_1']);
                    $buff_value_3 += 50;
                    $buff_dmg_redu += 20;
                    break;
                }
                if($ship['experience']>=$ship_ranks[5]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +20%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT50")).' +50</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT1")).' +10%</span></b><br>';
                    $buff_value_1 += floor(($ship['value_1'] * 1.10) - $ship['value_1']);
                    $buff_value_3 += 50;
                    $buff_dmg_redu += 20;
                    break;
                }
                if($ship['experience']>=$ship_ranks[4]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +20%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT50")).' +50</span></b><br>';
                    $buff_value_1 += floor(($ship['value_1'] * 1.10) - $ship['value_1']);
                    $buff_value_3 += 50;
                    $buff_dmg_redu += 20;
                    break;
                }                
                if($ship['experience']>=$ship_ranks[1]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +20%</span></b><br>';
                    $buff_dmg_redu += 20;
                    break;
                }
                $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT71")).'</span></b><br>';                
                break;
            case 2:
                if($ship['experience']>=$ship_ranks[7]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +10%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT61")).' +30</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT4")).' +15%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT50")).' +10</span></b><br>';
                    $buff_value_3 += 10;
                    $buff_value_4 += floor(($ship['value_4'] * 1.15) - $ship['value_4']);
                    $buff_firststrike += 30;
                    $buff_dmg_redu += 10;
                    break;
                }
                if($ship['experience']>=$ship_ranks[5]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +10%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT61")).' +30</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT4")).' +15%</span></b><br>';                    
                    $buff_value_4 += floor(($ship['value_4'] * 1.15) - $ship['value_4']);
                    $buff_firststrike += 30;
                    $buff_dmg_redu += 10;
                    break;
                }
                if($ship['experience']>=$ship_ranks[4]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +10%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT61")).' +30</span></b><br>';                    
                    $buff_firststrike += 30;
                    $buff_dmg_redu += 10;
                    break;
                }
                if($ship['experience']>=$ship_ranks[1]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +10%</span></b><br>';                  
                    $buff_dmg_redu += 10;
                    break;
                }
                $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
            case 1:
                if($ship['experience']>=$ship_ranks[7]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +5%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT8")).' +10</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT11")).' +15</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT6")).' +6</span></b><br>';
                    $buff_value_6 += 6;
                    $buff_value_11 += 15;
                    $buff_value_8 += 10;
                    $buff_dmg_redu += 5;
                    break;
                }
                if($ship['experience']>=$ship_ranks[5]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +5%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT8")).' +10</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT11")).' +15</span></b><br>';                    
                    $buff_value_11 += 15;
                    $buff_value_8 += 10;
                    $buff_dmg_redu += 5;
                    break;
                }                
                if($ship['experience']>=$ship_ranks[4]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +5%</span></b><br>'
                    . '<b><span style="color: cyan">'.constant($game->sprache("TEXT8")).' +10</span></b><br>';
                    $buff_value_8 += 10;
                    $buff_dmg_redu += 5;
                    break;
                }                
                if($ship['experience']>=$ship_ranks[1]) {
                    $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT68")).' +5%</span></b><br>';
                    $buff_dmg_redu += 5;
                    break;
                }                
                $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
            default:
                $classbonustring .= '<b><span style="color: cyan">'.constant($game->sprache("TEXT71")).'</span></b><br>';
                break;
        }

	// Schiffsdaten ausgeben:
	$rank_nr=1;
	if ($ship['experience']>=$ship_ranks[0]) $rank_nr=1;
	if ($ship['experience']>=$ship_ranks[3]) $rank_nr=4;
	if ($ship['experience']>=$ship_ranks[6]) $rank_nr=7;
	if ($ship['experience']>=$ship_ranks[8]) $rank_nr=9;

	$firststrike=(($ship['value_6']+$buff_value_6+round($ship['value_6']*$ship_rank_bonus[$rank_nr-1]))*2
	             +($ship['value_7']+round($ship['value_7']*$ship_rank_bonus[$rank_nr-1]))*3
	             +($ship['value_8']+$buff_value_8+round($ship['value_8']*$ship_rank_bonus[$rank_nr-1]))
	             +($ship['value_11']+$buff_value_11*0.5)
	             +($ship['value_12']+$buff_value_12)
	             );
        
        $base_to_hit = (($ship['value_6']+$buff_value_6+round($ship['value_6']*$ship_rank_bonus[$rank_nr-1])) 
                       +($ship['value_7']+round($ship['value_7']*$ship_rank_bonus[$rank_nr-1])) 
                       +($ship['value_8']+$buff_value_8+round($ship['value_8']*$ship_rank_bonus[$rank_nr-1]))
                       +($ship['value_11'] + $buff_value_11) * 0.1);
                        
        if($base_to_hit > 15) {
            $base_to_hit = 15;
        }
                        
        if($base_to_hit <  1) {
            $base_to_hit =  1;
        }
                        
        $tohit = round(($base_to_hit * 100)/17, 2);
        
        $rof  = $ship['rof'] + $buff_rof;
        $rof2 = $ship['rof2'] + $buff_rof2;
        
        if ($ship['experience']>=$ship_rank_tier[1]) $rof = $rof + 1;
        if ($ship['experience']>=$ship_rank_tier[2]) $rof2 = $rof2 + 1;
        if ($ship['experience']>=$ship_rank_tier[4]) $rof = $rof + 1;
        if ($ship['experience']>=$ship_rank_tier[3]) $rof = $rof + 1;
        if ($ship['experience']>=$ship_rank_tier[5]) $rof2 = $rof2 + 1;        

    $game->out('

<center><span class="caption">'.constant($game->sprache("TEXT40")).'</span></center><br>



<table width="450" align="center" border="0" cellpadding="4" cellspacing="2" class="style_outer">

  <tr>

    <td><span class="sub_caption2">'.constant($game->sprache("TEXT41")).' ('.$ship['name'].')</span><br>

      <table width="450" align="center" cellpadding="0" cellspacing="0" border="0" class="style_inner">

        <tr>

          <td align="left" valign="top" width="120">

            '.( ($ship['fleet_id'] > 0) ? constant($game->sprache("TEXT42")) : constant($game->sprache("TEXT43")) ).'<br><br>

            '.constant($game->sprache("TEXT44")).'<br>

            '.constant($game->sprache("TEXT45")).'<br>

            '.constant($game->sprache("TEXT46")).'<br><br>

            '.constant($game->sprache("TEXT54")).'<br>

            '.constant($game->sprache("TEXT55")).'<br>

            '.constant($game->sprache("TEXT56")).'<br><br>

            '.constant($game->sprache("TEXT57")).'<br>

            '.constant($game->sprache("TEXT47")).'<br>

            '.constant($game->sprache("TEXT4")).'<br><br>

            '.( (intval($ship['awayteam']) == 0) ? constant($game->sprache("TEXT65")) : constant($game->sprache("TEXT63"))).'<br><br>

            '.constant($game->sprache("TEXT9")).'<br><br>

            '.constant($game->sprache("TEXT48")).'<br>

            '.constant($game->sprache("TEXT49")).'<br>

            '.constant($game->sprache("TEXT50")).'<br>

            '.constant($game->sprache("TEXT60")).'<br><br>

            '.constant($game->sprache("TEXT6")).'<br>

            '.constant($game->sprache("TEXT7")).'<br>

            '.constant($game->sprache("TEXT8")).'<br><br>

            '.constant($game->sprache("TEXT10")).'<br>

            '.constant($game->sprache("TEXT11")).'<br>

            '.constant($game->sprache("TEXT12")).'<br><br>

            '.constant($game->sprache("TEXT51")).'<br><br>

            '.constant($game->sprache("TEXT68")).'<br>

            '.constant($game->sprache("TEXT61")).'<br>
                
            '.constant($game->sprache("TEXT66")).'<br><br>

            '.constant($game->sprache("TEXT52")).'

          </td>

          <td align="left" valign="top" width="150">

            ['.( ($ship['fleet_id'] > 0) ? '<a href="'.parse_link('a=ship_fleets_display&'.( (!empty($ship['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$ship['fleet_id']).'">'.$ship['fleet_name'].'</a>' : '<a href="'.parse_link('a=spacedock').'">'.$ship['planet_name'].'</a>' ).']<br><br>

            <b>'.$ship['name'].'</b><br>

            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$ship['race']][$ship['ship_torso']]).'\', CAPTION, \''.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'</a></b><br>

            <b>'.$RACE_DATA[$ship['race']][0].'</b><br><br>

            <b>'.$ship['ship_name'].'</b><br>

            <b>'.$ship['ship_ncc'].'</b><br>

            <b>'.date('d/m/y H:i:s', $ship['construction_time']).'</b><br><br>

            <b>'.( (!empty($ship['last_refit_time'])) ? date('d/m/y H:i:s', $ship['last_refit_time']) : constant($game->sprache("TEXT58"))).'</b><br>

            <b>('.$ship['hitpoints'].'</b> / <b>'.$ship['value_5'].')</b> + <b><span style="color: yellow">'.$buff_value_5.'</span></b><br>

            <b>'.$ship['value_4'].' + <span style="color: yellow">'.$buff_value_4.'</span></b><br><br>

            <b>'.( (intval($ship['awayteam']) == 0) ?  ' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ship['awayteamplanet_id'])).'"><b>'.$ship['mission_planet_name'].'</b></a> ' : intval($ship['awayteam'])).'</b><br><br>

            <b><span style="color: yellow">'.$ship['experience'].'</span></b> <img src="'.$game->GFX_PATH.'rank_'.$rank_nr.'.jpg" width="47" height="12"><br><br>

            <b>('.($ship['value_1']+$buff_value_1).' + <span style="color: yellow">'.round(($ship['value_1']+$buff_value_1)*$ship_rank_bonus[$rank_nr-1],0).'</span>)</b> x<b><span style="color: yellow">'.$rof.'</span></b><br>

            <b>('.($ship['value_2']+$buff_value_2).' + <span style="color: yellow">'.round(($ship['value_2']+$buff_value_2)*$ship_rank_bonus[$rank_nr-1],0).'</span>)</b> x<b><span style="color: yellow">'.$rof2.'</span></b><br>

            <b>'.($ship['value_3']+$buff_value_3).' + <span style="color: yellow">'.round(($ship['value_3']+$buff_value_3)*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['torp'].' / '.$ship['max_torp'].'</b><br><br>

            <b>'.($ship['value_6']+$buff_value_6).' + <span style="color: yellow">'.round(($ship['value_6']+$buff_value_6)*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_7'].' + <span style="color: yellow">'.round($ship['value_7']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.($ship['value_8']+$buff_value_8).' + <span style="color: yellow">'.round(($ship['value_8']+$buff_value_8)*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br><br>

            <b>'.$ship['value_10'].'</b><br>

            <b>'.$ship['value_11'].' + <span style="color: yellow">'.$buff_value_11.'</span></b><br>

            <b>'.$ship['value_12'].' + <span style="color: yellow">'.$buff_value_12.'</span></b><br><br>

            <b>'.$ship['value_14'].'</b> / <b>'.$ship['value_13'].'</b><br><br>
                
            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT69")).'\', CAPTION, \''.constant($game->sprache("TEXT68")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span style="color: cyan">'.($dmg_reduction + $buff_dmg_redu).'%</span></a></b><br>

            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT62")).'\', CAPTION, \''.constant($game->sprache("TEXT61")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span style="color: yellow">'.$firststrike.'</span></a></b><br>
                
            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT67")).'\', CAPTION, \''.constant($game->sprache("TEXT66")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span style="color: yellow">'.$tohit.'&#37;</span></a></b><br><br>
        
            <img src='.$game->GFX_PATH.'menu_unit1_small.gif>'.$ship['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif>'.$ship['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif>'.$ship['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif>'.$ship['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif>'.$ship['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif>'.$ship['unit_6'].'

          </td>

          <td align="center>" valign="top" width="180"><img src="'.FIXED_GFX_PATH.'ship'.$ship['race'].'_'.$ship['ship_torso'].'.jpg"><br><br>

    ');

    for ($t=0; $t<10; $t++)

	{

	if ($ship['component_'.($t+1)]>=0)

	{

	$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateCompInfoText($ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]).'\', CAPTION, \''.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'</a><br>');

	} else $game->out(constant($game->sprache("TEXT53")));

    }

    $game->out($racebonustring);
        
    $game->out($classbonustring);       
            
    $game->out('

          </td>

        </tr>

      </table>

    </td>

  </tr>

</table>

    ');



}

else {

    redirect('a=ship_fleets_display');

}



?>

