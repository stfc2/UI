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







function CreateShipInfoText($ship)

{

global $db;

global $game;

$text='<b>'.$ship[31].'</b><br><br><u>Fähigkeiten:</u><br>';



$text.='L. Waffen: '.$ship[14].'<br>';

$text.='Schw. Waffen: '.$ship[15].'<br>';

$text.='Pl. Waffen: '.$ship[16].'<br>';

$text.='Schildstärke: '.$ship[17].'<br>';

$text.='Hlle (HP): '.$ship[18].'<br>';

$text.='Reaktion: '.$ship[19].'<br>';

$text.='Bereitschaft: '.$ship[20].'<br>';

$text.='Wendigkeit: '.$ship[21].'<br>';

$text.='Erfahrung: '.$ship[22].'<br>';

$text.='Warp: '.$ship[23].'<br>';

$text.='Sensoren: '.$ship[24].'<br>';

$text.='Tarnung: '.$ship[25].'<br>';

$text.='Verbraucht Energie: '.$ship[27].'<br>';

$text.='Liefert Energie: '.$ship[26].'<br>';





return $text;

}



function CreateCompInfoText($comp)

{

global $db;

global $game;

$text=''.$comp['description'].'<br><br>Fähigkeiten:</u><br>';



if ($comp['value_1']!=0) $text.='L. Waffen: '.$comp['value_1'].'<br>';

if ($comp['value_2']!=0) $text.='Schw. Waffen: '.$comp['value_2'].'<br>';

if ($comp['value_3']!=0) $text.='Pl. Waffen: '.$comp['value_3'].'<br>';

if ($comp['value_4']!=0) $text.='Schildstärke: '.$comp['value_4'].'<br>';

if ($comp['value_5']!=0) $text.='Hlle (HP): '.$comp['value_5'].'<br>';

if ($comp['value_6']!=0) $text.='Reaktion: '.$comp['value_6'].'<br>';

if ($comp['value_7']!=0) $text.='Bereitschaft: '.$comp['value_7'].'<br>';

if ($comp['value_8']!=0) $text.='Wendigkeit: '.$comp['value_8'].'<br>';

if ($comp['value_9']!=0) $text.='Erfahrung: '.$comp['value_9'].'<br>';

if ($comp['value_10']!=0) $text.='Warp: '.$comp['value_10'].'<br>';

if ($comp['value_11']!=0) $text.='Sensoren: '.$comp['value_11'].'<br>';

if ($comp['value_12']!=0) $text.='Tarnung: '.$comp['value_12'].'<br>';

if ($comp['value_14']!=0) $text.='Verbraucht Energie: '.$comp['value_14'].'<br>';

if ($comp['value_13']!=0) $text.='Liefert Energie: '.$comp['value_13'].'<br>';

return $text;

}



if(!empty($_GET['rename_fleet'])) {

    if(empty($_POST['fleet_name'])) {

        message(NOTICE, 'Es wurde kein neuer Name angegeben');

    }



    $fleet_id = (int)$_GET['rename_fleet'];

    $new_name = addslashes($_POST['fleet_name']);



    $sql = 'SELECT *

            FROM ship_fleets

            WHERE fleet_id = '.$fleet_id;



    if(($fleet = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query fleets data');

    }



    if(empty($fleet['fleet_id'])) {

        message(NOTICE, 'Gewählte Flotte existiert nicht');

    }



    if($fleet['user_id'] != $game->player['user_id']) {

        message(NOTICE, 'Gewählte Flotte existiert nicht');

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

        message(NOTICE, 'Keine Flotten ausgewählt');

    }



    $n_fleets = count($_POST['fleets']);



    if($n_fleets == 1) {

        message(NOTICE, 'Es muss mehr als eine Flotte ausgewählt werden');

    }



    $fleet_ids = array();



    for($i = 0; $i < $n_fleets; ++$i) {

        $_temp = (int)$_POST['fleets'][$i];



        if(!empty($_temp)) {

            $fleet_ids[] = $_temp;

        }

    }



    if(empty($fleet_ids)) {

        message(NOTICE, 'Keine Flotten ausgewählt');

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

                message(NOTICE, 'Mindestens eine der ausgewählten Flotten befindet sich nicht auf dem selben Planeten wie die anderen');

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

                message(NOTICE, 'Mindestens eine der ausgewählten Flotten ist nicht gemeinsam mit den anderen unterwegs');

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

        message(GENERAL, 'Eine der ausgewählten Flotte befindet sich weder im Orbit um einen Planeten noch auf Reise', '$first_fleet[\'planet_id\'] = empty AND $first_fleet[\'move_id\'] = empty');

    }



    if($n_fleets <= 1) {

        message(NOTICE, 'Von den ausgewählten Flotten wurden nur '.$n_fleets.' in der Datenbank gefunden');

    }



    if(empty($_POST['join_fleet_name'])) {

        message(NOTICE, 'Es wurde kein Name fr die zusammengesetzte Flotte angegeben');

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

        message(NOTICE, 'Keine der ausgewählten Flotte enthielt Schiffe');

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

    $fleet_id = (int)$_GET['set_alert_phase'];



    if(!isset($_GET['to'])) {

        message(GENERAL, 'Ungültige Parameter-Übergabe', '$_GET[\'to\'] = empty');

    }



    $to = (int)$_GET['to'];



    if( ($to != ALERT_PHASE_GREEN) && ($to != ALERT_PHASE_YELLOW) && ($to != ALERT_PHASE_RED) ) {

        message(NOTICE, 'Ungltige Alarmstufe angegeben');

    }



    $sql = 'UPDATE ship_fleets

            SET alert_phase = '.$to.'

            WHERE fleet_id = '.$fleet_id.' AND

                  user_id = '.$game->player['user_id'];



    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleets alert phase data');

    }



    redirect('a=ship_fleets_display&'.( (isset($_GET['planet'])) ? 'p' : 'm' ).'fleet_details='.$fleet_id);

}

elseif(isset($_GET['offduty_ships'])) {

    if(empty($_POST['ships'])) {
       message(NOTICE, 'Keine Schiffe ausgewählt');
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
	   message(NOTICE, 'Die ausgewählten Schiffe existieren nicht');
	}

    //Check to see if query returned any results. Needs a better explanation in NOTICE message I think.
    if ($db->num_rows($q_fleetinfo) == 0) {
	   message(NOTICE, 'Die ausgewählten Schiffe existieren nicht oder die Schiffe sind keiner gltigen Flotte zugewiesen oder die Flotte befindet sich nicht auf einem Planeten');
	}

    $fleetinfo = $db->fetchrow($q_fleetinfo);
	
    //Lots of checking to see if everything is ok
    if($fleetinfo['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Die Schiffe sind keiner gltigen Flotte zugewiesen');
    }
	
    if($fleetinfo['planet_owner'] != $game->player['user_id']) {
        message(NOTICE, 'Du kannst nur Schiffe in das Trockendock eines deiner Planeten setzen');
    }

    if($fleetinfo['building_7'] < 1) {
        message(NOTICE, 'Du besitzt noch keine(n) '.$BUILDING_NAME[$game->player['user_race']][6].' auf dem Stationierungsplaneten der Flotte');
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
	//message(NOTICE, 'Keine Schiffe ausgewählt oder Raumhafen ist voll '.count($_POST['ships']).' gewaehlt, '.$no_ships.' zugelassen ('.$MAX_SPACEDOCK_SHIPS[$fleetinfo['building_7']].' max.; '.$spacedockships['n_spacedockships'].' schon vebraucht -> Raumhafenlvl: '.$fleetinfo['building_7'].')');
	message(NOTICE, 'Keine Schiffe ausgewaehlt oder Raumhafen ist voll');
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
        message(NOTICE, 'Es wurden mehr Schiffe außer Dienst gestellt, als die Flotte besaß');
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
            message(NOTICE, 'Eines der Schiffe befindet sich nicht in derselben Flotte wie die anderen');
        }

        if($ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter--;

    }

    $n_resources = $fleetinfo['resource_1'] + $fleetinfo['resource_2'] + $fleetinfo['resource_3'];
    $n_units = $fleetinfo['resource_4'] + $fleetinfo['unit_1'] + $fleetinfo['unit_2'] + $fleetinfo['unit_3'] + $fleetinfo['unit_4'] + $fleetinfo['unit_5'] + $fleetinfo['unit_6'];

    if( ($n_resources > ($n_transporter * MAX_TRANSPORT_RESOURCES) ) || ($n_units > ($n_transporter * MAX_TRANSPORT_UNITS) ) ) {
        message(NOTICE, 'Die Schiffe konnten nicht außer Dienst gestellt werden, da dadurch die Ladung der Flotte die maximale Transporterkapazität überschritten hätte');
    }

    //Everything checks out ok, update database fields
	
    $sql = 'UPDATE ships
            SET fleet_id = -'.$fleetinfo['planet_id'].'
            WHERE ship_id IN ('.$ship_ids_str.')';

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

        message(NOTICE, 'Kein Schiff ausgewählt');

    }



    $sql = 'SELECT s.*, st.*,

                   f.fleet_name, f.planet_id, f.move_id,

                   p.planet_name

            FROM (ships s)

            INNER JOIN (ship_templates st) ON st.id = s.template_id

            LEFT JOIN (ship_fleets f) ON f.fleet_id = s.fleet_id

            LEFT JOIN (planets p) ON p.planet_id = -s.fleet_id

            WHERE s.ship_id = '.$ship_id;



    if(($ship = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query ship data');

    }



    if(empty($ship['ship_id'])) {

        message(NOTICE, 'Das gewählte Schiff existiert nicht');

    }



    if($ship['user_id'] != $game->player['user_id']) {

        message(NOTICE, 'Das gewählte Schiff existiert nicht');

    }



	// Schiffsdaten ausgeben:
	$rank_nr=1;
	if ($ship['experience']>=$ship_ranks[0]) $rank_nr=1;
	if ($ship['experience']>=$ship_ranks[1]) $rank_nr=2;
	if ($ship['experience']>=$ship_ranks[2]) $rank_nr=3;
	if ($ship['experience']>=$ship_ranks[3]) $rank_nr=4;
	if ($ship['experience']>=$ship_ranks[4]) $rank_nr=5;
	if ($ship['experience']>=$ship_ranks[5]) $rank_nr=6;
	if ($ship['experience']>=$ship_ranks[6]) $rank_nr=7;
	if ($ship['experience']>=$ship_ranks[7]) $rank_nr=8;
	if ($ship['experience']>=$ship_ranks[8]) $rank_nr=9;
	if ($ship['experience']>=$ship_ranks[9]) $rank_nr=10;
	

    $game->out('

<center><span class="caption">Flottenbersicht:</span></center><br>



<table width="450" align="center" border="0" cellpadding="4" cellspacing="2" class="style_outer">

  <tr>

    <td><span class="sub_caption2">Detailansicht des gewählten Schiffs ('.$ship['name'].')</span><br><br>

      <table width="450" align="center" cellpadding="0" cellspacing="0" border="0" class="style_inner">

        <tr>

          <td align="left" valign="top" width="120">

            '.( ($ship['fleet_id'] > 0) ? 'Flotte:' : 'Trockendock:' ).'<br><br>

            Schiffsklasse:<br>

            Rumpftyp:<br>

            Rasse:<br><br>

            Hüllenzustand:<br>

            Schildstärke:<br><br>

            Erfahrung:<br><br>

            Leichte Waffen:<br>

            Schwere Waffen:<br>

            Planetare Waffen:<br><br>

            Reaktion:<br>

            Bereitschaft:<br>

            Wendigkeit:<br><br>

            Warp:<br>

            Sensoren:<br>

            Tarnung:<br><br>

            Energieverbrauch:<br><br>

            Crew:

          </td>

          <td align="left" valign="top" width="130">

            '.( ($ship['fleet_id'] > 0) ? '<a href="'.parse_link('a=ship_fleets_display&'.( (!empty($ship['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$ship['fleet_id']).'">'.$ship['fleet_name'].'</a>' : '<a href="'.parse_link('a=spacedock').'">'.$ship['planet_name'].'</a>' ).'<br><br>

            <b>'.$ship['name'].'</b><br>

            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$ship['race']][$ship['ship_torso']]).'\', CAPTION, \''.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'</a></b><br>

            <b>'.$RACE_DATA[$ship['race']][0].'</b><br><br>

            <b>'.$ship['hitpoints'].'</b> / <b>'.$ship['value_5'].'</b><br>

            <b>'.$ship['value_4'].'</b><br><br>

            <b><span style="color: yellow">'.$ship['experience'].'</span></b> <img src="'.$game->GFX_PATH.'rank_'.$rank_nr.'.jpg" width="47" height="12"><br><br>

            <b>'.$ship['value_1'].' + <span style="color: yellow">'.round($ship['value_1']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_2'].' + <span style="color: yellow">'.round($ship['value_2']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_3'].' + <span style="color: yellow">'.round($ship['value_3']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br><br>

            <b>'.$ship['value_6'].' + <span style="color: yellow">'.round($ship['value_6']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_7'].' + <span style="color: yellow">'.round($ship['value_7']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_8'].' + <span style="color: yellow">'.round($ship['value_8']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br><br>

            <b>'.$ship['value_10'].'</b><br>

            <b>'.$ship['value_11'].'</b><br>

            <b>'.$ship['value_12'].'</b><br><br>

            <b>'.$ship['value_14'].'</b> / <b>'.$ship['value_13'].'</b><br><br>

            <img src='.$game->GFX_PATH.'menu_unit1_small.gif>'.$ship['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif>'.$ship['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif>'.$ship['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif>'.$ship['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif>'.$ship['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif>'.$ship['unit_6'].'

          </td>

          <td align="center>" valign="top" width="200"><img src="'.FIXED_GFX_PATH.'ship'.$ship['race'].'_'.$ship['ship_torso'].'.jpg"><br><br>

    ');

    for ($t=0; $t<10; $t++)

	{

	if ($ship['component_'.($t+1)]>=0)

	{

	$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateCompInfoText($ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]).'\', CAPTION, \''.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'</a><br>');

	} else $game->out('- Nicht belegt<br>');

    }



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

