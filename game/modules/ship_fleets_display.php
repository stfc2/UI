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
$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');
$game->out('<div align="center">[<a href="'.parse_link('a=ship_fleets_display&mass_set_homebase').'">'.constant($game->sprache("TEXT1")).'</a>]<br><br>');

if(isset($_POST['set_homebase'])) {

    $coord_pieces = explode(':', $_POST['pos_homebase']);
    $n_pieces = count($coord_pieces);

    if($n_pieces != 3) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    $sector_id = $game->get_sector_id($coord_pieces[0]);

    $letters = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18);
    $numbers = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18);

    if(!isset($letters[$coord_pieces[1][0]])) {
        message(NOTICE, constant($game->sprache("TEXT3")), $coord_pieces[1][0].' '.constant($game->sprache("TEXT4")));
    }

    $system_y = $letters[$coord_pieces[1][0]];

    if(!isset($numbers[$coord_pieces[1][1]])) {
        message(NOTICE, constant($game->sprache("TEXT5")), $coord_pieces[1][1].' '.constant($game->sprache("TEXT6")));
    }

    $system_x = $numbers[$coord_pieces[1][1]];

    $distance_id = (int)$coord_pieces[2] - 1;

    $sql = 'SELECT p.planet_id
            FROM (planets p, starsystems s)
            WHERE s.sector_id = '.$sector_id.' AND
                  s.system_x = '.$system_x.' AND
                  s.system_y = '.$system_y.' AND
                  p.system_id = s.system_id AND
                  p.planet_distance_id = '.$distance_id;

    if(($planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    if(empty($planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT7")).' <b>'.$_POST['dest_coord'].'</b>');
    }

    $base = (int)$planet['planet_id'];
    $fleet = $_POST['fleets'][0];

    $sql = 'UPDATE ship_fleets SET homebase = '.$base.' WHERE fleet_id = '.$fleet.' AND user_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleets homebase data');

    }

    $sql = 'SELECT * from ship_fleets WHERE fleet_id = '.$fleet;

    if(($check_fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    if($check_fleet['move_id']>0){

        redirect('a=ship_fleets_display&mfleet_details='.$fleet.'');

    }
    else {

        redirect('a=ship_fleets_display&pfleet_details='.$fleet.'');
    }
}

if(isset($_POST['mass_save'])) {

    $coord_pieces = explode(':', $_POST['pos_home_all']);
    $n_pieces = count($coord_pieces);

    if($n_pieces != 3) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    $sector_id = $game->get_sector_id($coord_pieces[0]);

    $letters = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18);
    $numbers = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18);

    if(!isset($letters[$coord_pieces[1][0]])) {
        message(NOTICE, constant($game->sprache("TEXT3")), $coord_pieces[1][0].' '.constant($game->sprache("TEXT4")));
    }

    $system_y = $letters[$coord_pieces[1][0]];

    if(!isset($numbers[$coord_pieces[1][1]])) {
        message(NOTICE, constant($game->sprache("TEXT5")), $coord_pieces[1][1].' '.constant($game->sprache("TEXT6")));
    }

    $system_x = $numbers[$coord_pieces[1][1]];

    $distance_id = (int)$coord_pieces[2] - 1;

    $sql = 'SELECT p.planet_id
            FROM (planets p, starsystems s)
            WHERE s.sector_id = '.$sector_id.' AND
                  s.system_x = '.$system_x.' AND
                  s.system_y = '.$system_y.' AND
                  p.system_id = s.system_id AND
                  p.planet_distance_id = '.$distance_id;

    if(($planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    if(empty($planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT7")).' <b>'.$_POST['dest_coord'].'</b>');
    }

    $base = (int)$planet['planet_id'];

    $sql = 'UPDATE ship_fleets SET homebase = '.$base.' WHERE user_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleets homebase data');

    }
    redirect('a=ship_fleets_display');
}


if(isset($_GET['pfleet_details'])) {
    $fleet_id = (!empty($_POST['fleets'])) ? (int)$_POST['fleets'][0] : (int)$_GET['pfleet_details'];

    if(empty($fleet_id)) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    $sql = 'SELECT f.*,
                   p.planet_name, p.sector_id, p.planet_distance_id, p.building_7 AS spacedock_level,
                   s.system_x, s.system_y,
                   u.user_id AS stationated_owner_id, u.user_name AS stationated_owner_name
            FROM (ship_fleets f)
            INNER JOIN (planets p) ON p.planet_id = f.planet_id
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE f.fleet_id = '.$fleet_id;

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    if(!empty($fleet['move_id'])) {
        $sql = 'UPDATE ship_fleets
                SET move_id = 0
                WHERE fleet_id = '.$fleet_id;
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets location data');
        }
    }

    $sql = 'SELECT fleet_id, fleet_name
            FROM ship_fleets
            WHERE planet_id = '.$fleet['planet_id'].' AND
                  user_id = '.$game->player['user_id'].' AND
                  fleet_id <> '.$fleet_id.'
            ORDER BY fleet_name DESC';

    if(($q_ofleets = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other fleet data');
    }

    $other_fleets_html = '';

    while($o_fleets = $db->fetchrow($q_ofleets)) {
        $other_fleets_html .= '<option value="'.$o_fleets['fleet_id'].'">'.$o_fleets['fleet_name'].'</option>'.NL;
    }

    $order_by = (!empty($_GET['order_by'])) ? $_GET['order_by'] : 'template';

    switch($order_by) {
        case 'template':
            $order_by_str = 's.template_id ASC';
        break;

        case 'torso':
            $order_by_str = 'st.ship_torso ASC';
        break;

        case 'experience':
            $order_by_str = 's.experience DESC';
        break;

        case 'construction_time':
            $order_by_str = 's.construction_time ASC';
        break;

        case 'warp':
            $order_by_str = 'st.value_10 ASC';
        break;

        case 'name':
            /* 04/06/08 - AC: Order by the real name of the ships */
            $order_by_str = 's.ship_name ASC';
        break;
    }

    $sql = 'SELECT s.*,
                   st.name AS template_name, st.ship_torso, st.value_10, st.value_5 AS max_hitpoints, st.max_torp
            FROM (ships s, ship_templates st)
            WHERE s.fleet_id = '.$fleet_id.' AND
                  st.id = s.template_id
            ORDER BY '.$order_by_str;

    if(($q_ships = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships data');
    }

    $n_ships = $n_transporter = 0;
    $ships_option_html = '';
    $torso_counter = array(0,0,0,0,0,0,0,0,0,0);
    $damage_counter = array(0,0,0,0);
    $depleted_counter = array(0,0,0);
    $thereshold_ammo_ratio = 30;

    $ship_torso[0] = constant($game->sprache("TEXT79"));
    $ship_torso[1] = constant($game->sprache("TEXT80"));
    $ship_torso[2] = constant($game->sprache("TEXT81"));
    $ship_torso[3] = constant($game->sprache("TEXT82"));
    $ship_torso[4] = constant($game->sprache("TEXT82"));
    $ship_torso[5] = constant($game->sprache("TEXT83"));
    $ship_torso[6] = constant($game->sprache("TEXT83"));
    $ship_torso[7] = constant($game->sprache("TEXT84"));
    $ship_torso[8] = constant($game->sprache("TEXT84"));
    $ship_torso[9] = constant($game->sprache("TEXT85"));
    $ship_torso[10] = constant($game->sprache("TEXT85"));
    $ship_torso[11] = constant($game->sprache("TEXT86"));
    $ship_torso[12] = constant($game->sprache("TEXT87"));

    while($s_ship = $db->fetchrow($q_ships)) {
        $ammo_ratio = (int)($s_ship['torp']*100/$s_ship['max_torp']);
        /* 07/04/08 - AC: If present, show also ship's name */
        $new_id = $s_ship['max_hitpoints']-$s_ship['hitpoints'] + (($s_ship['ship_torso'] > 2 && $ammo_ratio < $thereshold_ammo_ratio) ? 100000 : 0);
        $ships_option_html .= '<option id="'.$new_id.'" value="'.$s_ship['ship_id'].'">'.(($s_ship['ship_name'] != '')? $s_ship['ship_name'].' - '.$s_ship['template_name'] : $s_ship['template_name']).' ('.$s_ship['hitpoints'].'/'.$s_ship['max_hitpoints'].', Torp: '.($s_ship['ship_torso'] < 5 ? 'n/a' : $s_ship['torp']).', Exp: '.$s_ship['experience'].')</option>';

        if($s_ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter++;

        $torso_counter[$s_ship['ship_torso']]++;

        if($s_ship['max_hitpoints'] == $s_ship['hitpoints'])
            $damage_counter[0]++;
        else {
            $damage_counter[1]++;
            $dmg_ratio = (int)($s_ship['hitpoints']*100/$s_ship['max_hitpoints']);
            if($dmg_ratio < 25) $damage_counter[3]++; 
            if($dmg_ratio < 50) $damage_counter[2]++; 
        }

        if($ammo_ratio == 100 || $s_ship['ship_torso'] < 5)
            $depleted_counter[0]++;
        else {
            if($ammo_ratio < $thereshold_ammo_ratio)
                $depleted_counter[2]++;
            else
                $depleted_counter[1]++;
        }

        $n_ships++;
    }

    foreach($torso_counter as $key => $torso)
    {
        if($torso == 0) continue;
        // $torso_string_counter .= $SHIP_TORSO[$game->player['user_race']][$key][29].' <b>'.$torso.'</b><br>';
        $torso_string_counter .= $ship_torso[$key].' <b>'.$torso.'</b><br>';	
    }

    $damage_string_counter .= constant($game->sprache("TEXT92")).' <b>'.$damage_counter[0].'</b>';

    if($damage_counter[1]>0) $damage_string_counter .= '<br>'.constant($game->sprache("TEXT93")).' <b>'.$damage_counter[1].'</b> '.constant($game->sprache("TEXT94")).' <b>'.$damage_counter[2].'</b><br>'.constant($game->sprache("TEXT95")).' <b>'.$damage_counter[3].'</b>';

    $depleted_string .= constant($game->sprache("TEXT96")).' <b>'.$depleted_counter[0].'</b><br>'.constant($game->sprache("TEXT97")).' <b>'.$depleted_counter[1].'</b><br>'.constant($game->sprache("TEXT98")).' <b>'.$depleted_counter[2].'</b>';

    if($n_ships == 0) {
        $sql = 'DELETE FROM ship_fleets
                WHERE fleet_id = '.$fleet_id;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not delete fleets data');
        }
    }
    elseif($n_ships != $fleet['n_ships']) {
        $sql = 'UPDATE ship_fleets
                SET n_ships = '.$n_ships.'
                WHERE fleet_id = '.$fleet_id;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleet n_ships data');
        }
    }

    $n_resources = $fleet['resource_1'] + $fleet['resource_2'] + $fleet['resource_3'] + $fleet['resource_4'];
    $n_units = $fleet['unit_1'] + $fleet['unit_2'] + $fleet['unit_3'] + $fleet['unit_4'] + $fleet['unit_5'] + $fleet['unit_6'];

    $n_security = 0;
    $n_security = $fleet['unit_1']*2+$fleet['unit_2']*3+$fleet['unit_3']*4+$fleet['unit_4']*4;

    $ap_green_str = ($fleet['alert_phase'] == ALERT_PHASE_GREEN) ? '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_GREEN.'&planet').'">'.constant($game->sprache("TEXT9")).'</a>]';
    $ap_yellow_str = ($fleet['alert_phase'] == ALERT_PHASE_YELLOW) ? '[<span style="color: #FFFF00;">'.constant($game->sprache("TEXT10")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_YELLOW.'&planet').'">'.constant($game->sprache("TEXT10")).'</a>]';
    $ap_red_str = ($fleet['alert_phase'] == ALERT_PHASE_RED) ? '[<span style="color: #FF0000;">'.constant($game->sprache("TEXT11")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_RED.'&planet').'">'.constant($game->sprache("TEXT11")).'</a>]';

    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="4" cellspacing="2" class="style_inner">
  <form name="fleet_form" method="post" action="">
  <tr>
    <td>
      <table width="450" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="350" align="left">[<a href="'.parse_link('a=ship_fleets_display').'">'.constant($game->sprache("TEXT12")).'</a>]&nbsp;&nbsp;&nbsp;<input class="field" type="text" name="fleet_name" value="'.$fleet['fleet_name'].'" maxlength="20" size="25">&nbsp;<input name="rename_fleet_submit" type="submit" class="button" value="'.constant($game->sprache("TEXT13")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&rename_fleet='.$fleet_id).'\'"></td>
          <td width="100" align="right">'.( ($n_ships == 1) ? '<b>1</b> '.constant($game->sprache("TEXT14")) : '<b>'.$n_ships.'</b> '.constant($game->sprache("TEXT15")) ).'</td>
        </tr>
      </table><br>
      '.constant($game->sprache("TEXT16")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['planet_id'])).'"><b>'.$fleet['planet_name'].'</b></a> ('.$game->get_sector_name($fleet['sector_id']).':'.$game->get_system_cname($fleet['system_x'], $fleet['system_y']).':'.($fleet['planet_distance_id'] + 1).')'.( ($fleet['stationated_owner_id'] != $game->player['user_id']) ? ' '.constant($game->sprache("TEXT17")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$fleet['stationated_owner_id']).'"><b>'.$fleet['stationated_owner_name'].'</b></a>' : '' ).'<br><br>

      '.constant($game->sprache("TEXT18")).' '.$ap_green_str.'&nbsp;'.$ap_yellow_str.'&nbsp;'.$ap_red_str.'<br><br>
    ');

    // Anfang lesen Homebase Koords

    $planet_id = $fleet['homebase'];

    $sql = 'SELECT * FROM planets WHERE planet_id = '.$planet_id;

    $planet_koords = $db->queryrow($sql);

    $system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$planet_koords['system_id']);

    // Ende lesen Homebasekoords


    if($n_transporter > 0) {
        $max_resources = $n_transporter * MAX_TRANSPORT_RESOURCES;
        $max_units = $n_transporter * MAX_TRANSPORT_UNITS;

        $game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT88")).':</span></legend>');

        if( ($n_resources < $max_resources) || ($n_units < $max_units) ) $game->out('[<a href="'.parse_link('a=ship_fleets_loadingp&from='.$fleet_id).'">'.constant($game->sprache("TEXT19")).'</a>]&nbsp;');
        if( ($n_resources > 0) || ($n_units > 0) ) $game->out('[<a href="'.parse_link('a=ship_fleets_loadingp&to='.$fleet_id).'">'.constant($game->sprache("TEXT20")).'</a>]');

        $game->out('<br>');

        if($n_resources > 0) {
            if($fleet['resource_1'] > 0) $game->out('<br>'.constant($game->sprache("TEXT21")).' <b>'.$fleet['resource_1'].'</b>');
            if($fleet['resource_2'] > 0) $game->out('<br>'.constant($game->sprache("TEXT22")).' <b>'.$fleet['resource_2'].'</b>');
            if($fleet['resource_3'] > 0) $game->out('<br>'.constant($game->sprache("TEXT23")).' <b>'.$fleet['resource_3'].'</b>');
            if($fleet['resource_4'] > 0) $game->out('<br>'.constant($game->sprache("TEXT24")).' <b>'.$fleet['resource_4'].'</b>');
            $game->out('<br>');
        }

        if($n_units > 0) {
            if($fleet['unit_1'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$fleet['unit_1'].'</b>');
            if($fleet['unit_2'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$fleet['unit_2'].'</b>');
            if($fleet['unit_3'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$fleet['unit_3'].'</b>');
            if($fleet['unit_4'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$fleet['unit_4'].'</b>');
            if($fleet['unit_5'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$fleet['unit_5'].'</b>');
            if($fleet['unit_6'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$fleet['unit_6'].'</b>');
            $game->out('<br><br><i>'.constant($game->sprache("TEXT25")).' <b>'.$n_security.'</b></i>');
            $game->out('<br>');
        }

        $game->out('</fieldset><br><br>');
    }

    //DC --- Fleet composition panel
    $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
    $game->out('
        <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT89")).':</span></legend>
        <table width=450 cellpadding=0 cellspacing=0 border=0>
          <tr>
            <td '.$style.' width=50 align=left>'.constant($game->sprache("TEXT31")).'</td>
            <td '.$style.' width=150 align=left>'.constant($game->sprache("TEXT99")).'</td>
            <td '.$style.' width=150 align=left>'.constant($game->sprache("TEXT100")).'</td>
          </tr>
          <tr>
            <td width=150 align=left>'.$torso_string_counter.'</td>
            <td width=150 align=left>'.$damage_string_counter.'</td>
            <td width=150 align=left>'.$depleted_string.'</td>
          </tr>
        </table>
      </fieldset>
      <br>');
    //DC ---

    $select_size = 8;
    $game->out('
<SCRIPT LANGUAGE="JavaScript"><!--
function ShipSelection(cSelectType) {
   var objShipListBox = document.getElementById("ships[]");
   
   for (var i=0; i<objShipListBox.length; i++) {
	  
      if (cSelectType == "All") {
         objShipListBox.options[i].selected = true;
      } else if (cSelectType == "Damaged") {
         if ((objShipListBox.options[i].id == 0) || (objShipListBox.options[i].id == 100000)) {
            objShipListBox.options[i].selected = false;
         } else {
            objShipListBox.options[i].selected = true;
         }
      } else if (cSelectType == "None") {
         objShipListBox.options[i].selected = false;
      } else if (cSelectType == "Depleted") {
         if (objShipListBox.options[i].id > 99999) {
            objShipListBox.options[i].selected = true;
         } else {
            objShipListBox.options[i].selected = false;
         }
      }
   }
}
//--></SCRIPT>
      <br>
      <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT90")).':</span></legend>
      <table width="450" border="0" cellpadding="2" cellspacing="0">
       <tr>
        <td width="410">
         <select id="ships[]" name="ships[]" style="width: 350px;" size="'.$select_size.'" multiple="multiple">
          '.$ships_option_html.'
         </select>
        </td>
        <td width="40">
         <center><b>'.constant($game->sprache("TEXT26")).'</b></center>
         <table height="115" border="0" cellpadding="2" cellspacing="0">
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_all" value="'.constant($game->sprache("TEXT27")).'" onClick="ShipSelection(\'All\')">
           </td>
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_damaged" value="'.constant($game->sprache("TEXT28")).'" onClick="ShipSelection(\'Damaged\')">
           </td>
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_depleted" value="'.constant($game->sprache("TEXT78")).'" onClick="ShipSelection(\'Depleted\')">
           </td>
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_none" value="'.constant($game->sprache("TEXT29")).'" onClick="ShipSelection(\'None\')">
           </td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
      <br>
      '.constant($game->sprache("TEXT30")).' ['.( ($order_by == 'template') ? '<b>'.constant($game->sprache("TEXT31")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=template').'">'.constant($game->sprache("TEXT31")).'</a>' ).']&nbsp;['.( ($order_by == 'torso') ? '<b>'.constant($game->sprache("TEXT32")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=torso').'">'.constant($game->sprache("TEXT32")).'</a>' ).']&nbsp;['.( ($order_by == 'experience') ? '<b>'.constant($game->sprache("TEXT33")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=experience').'">'.constant($game->sprache("TEXT33")).'</a>' ).']&nbsp;['.( ($order_by == 'construction_time') ? '<b>'.constant($game->sprache("TEXT34")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=construction_time').'">'.constant($game->sprache("TEXT34")).'</a>' ).']&nbsp;['.( ($order_by == 'warp') ? '<b>'.constant($game->sprache("TEXT35")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=warp').'">'.constant($game->sprache("TEXT35")).'</a>' ).']&nbsp;['.( ($order_by == 'name') ? '<b>'.constant($game->sprache("TEXT36")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id.'&order_by=name').'">'.constant($game->sprache("TEXT36")).'</a>' ).']
      <br><br>
      <input class="button" style="width: 220px;" type="submit" name="ship_details" value="'.constant($game->sprache("TEXT37")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&ship_details').'\'">&nbsp;
      <input class="button" type="submit" name="offduty_ship" value="'.constant($game->sprache("TEXT38")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&offduty_ships').'\'"'.( ( ($fleet['stationated_owner_id'] != $game->player['user_id']) || ($fleet['spacedock_level'] == 0) ) ? ' disabled="disabled"' : '' ).'>
      </fieldset>
      <br><br>

      <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT91")).':</span></legend>
      <table width="450" border="0" cellpadding="2" cellspacing="0">



       <tr>

       <td width="250">'.constant($game->sprache("TEXT39")).' <b>'.( ($planet_koords['sector_id']==0) ? '<b>'.constant($game->sprache("TEXT40")).'</b>' : ''.$game->get_sector_name($planet_koords['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($planet_koords['planet_distance_id'] + 1).' ( '.$planet_koords['planet_name'].' )' ).'</b></td>

       <td width="200"><input class="button" style="width: 130px;" type="submit" name="send_homebase" value="'.constant($game->sprache("TEXT41")).'" onClick="return document.fleet_form.action = \''.parse_link('a=send_home').'\'"></td>

       </tr>

       <tr>

         <td width="250"><input class="field" style="width: 130px;" type="text" name="pos_homebase"></td>

         <td width="200"><input class="button" style="width: 130px;" type="submit" name="set_homebase" value="'.constant($game->sprache("TEXT42")).'">&nbsp;&nbsp;</td>

       </tr>

       <tr>

         <td>&nbsp;</td>

       </tr>

     

        <tr>
          <td width="250"><input class="field"  style="width: 130px;" type="text" name="new_fleet_name"></td>
          <td width="200"><input class="button" style="width: 130px;" type="submit" name="new_fleet_submit" value="'.constant($game->sprache("TEXT43")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&new_fleet='.$fleet_id).'\'"></td>
        </tr>
    ');

    if(!empty($other_fleets_html)) {
        $game->out('
        <tr><td height="5"></td></tr>
        <tr>
          <td><select style="width: 130px;" name="to_fleet">'.$other_fleets_html.'</select></td>
          <td><input class="button" style="width: 130px;" type="submit" name="change_fleet_submit" value="'.constant($game->sprache("TEXT44")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&change_fleet='.$fleet_id).'\'">'.( ( ($n_resources > 0) || ($n_units > 0) ) ? '&nbsp;&nbsp;<input class="button" style="width: 130px;" type="submit" name="loadingf_submit" value="'.constant($game->sprache("TEXT45")).'"  onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_loadingf&to').'\'">' : '' ).'</td>
        </tr>
        ');
    }

    $own_planets_html = $tcm_html = '';

    $sql = 'SELECT p.planet_name, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (planets p)
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE p.planet_owner = '.$game->uid.'
            ORDER BY p.planet_name ASC';

    if(!$q_own_planets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query own planets coord data');
    }

    while($planet = $db->fetchrow($q_own_planets)) {
        $own_planets_html .= '<option value="'.($game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1)).'">'.$planet['planet_name'].'</option>';
    }

    $sql = 'SELECT tcm.memo_name,
                   p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (tc_coords_memo tcm)
            INNER JOIN (planets p) ON p.planet_id = tcm.memo_id
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE tcm.user_id = '.$game->player['user_id'].' AND
                  tcm.memo_view = 4';

    if(!$q_tcm = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query tactical coords memo data');
    }

    while($tcm = $db->fetchrow($q_tcm)) {
        $tcm_html .= '<option value="'.($game->get_sector_name($tcm['sector_id']).':'.$game->get_system_cname($tcm['system_x'], $tcm['system_y']).':'.($tcm['planet_distance_id'] + 1)).'">'.$tcm['memo_name'].'</option>';
    }

    $has_own_planets = (!empty($own_planets_html));
    $has_tcm = (!empty($tcm_html));

    $game->out('
        <tr><td height="5"></td></tr>
        <tr>
          <td><select style="width: 130px;"'.( ($has_own_planets || $has_tcm) ? ' onChange="if(this.value) document.fleet_form.dest_coord.value = this.value;"' : ' disabled="disabled"' ).'><option>'.constant($game->sprache("TEXT46")).'</option>'.( ( ($has_own_planets) ? '<option>---------------------</option>'.$own_planets_html : '' ).( ($has_tcm) ? '<option>---------------------</option>'.$tcm_html : '' ) ).'</select>&nbsp;&nbsp;<input type="text" class="field" name="dest_coord" size="10"></td>
          <td><input style="width: 130px;" class="button" type="submit" name="send_fleets" value="'.constant($game->sprache("TEXT47")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_send').'\'"></td>
        </tr>
    ');


    if($n_transporter == $n_ships) {
        $game->out('
        <tr><td height="5"></td></tr>
        <tr><td>&nbsp;</td><td><input style="width: 130px;" class="button" type="submit" name="new_route" value="'.constant($game->sprache("TEXT76")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_traderoute').'\'"></td></tr>
        ');
    }


    $game->out('
      </table>
      </fieldset>
      <br>
    </td>
  </tr>
  <input type="hidden" name="fleets[]" value="'.$fleet_id.'">
  </form>
</table>
</td></tr></table>
    ');
}
elseif(isset($_GET['mfleet_details'])) {
    $fleet_id = (!empty($_POST['fleets'])) ? (int)$_POST['fleets'][0] : (int)$_GET['mfleet_details'];


    if(empty($fleet_id)) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    $sql = 'SELECT f.*, ss.*, f.n_ships,
                   p1.planet_name AS start_planet_name, p1.sector_id AS start_sector, p1.planet_distance_id AS start_distance_id,
                   s1.system_x AS start_system_x, s1.system_y AS start_system_y,
                   p2.planet_name AS dest_planet_name, p2.sector_id as dest_sector, p2.planet_distance_id AS dest_distance_id,
                   s2.system_x AS dest_system_x, s2.system_y AS dest_system_y
            FROM (ship_fleets f)
            INNER JOIN (scheduler_shipmovement ss) ON ss.move_id = f.move_id
            INNER JOIN (planets p1) ON p1.planet_id = ss.start
            INNER JOIN (starsystems s1) ON s1.system_id = p1.system_id
            INNER JOIN (planets p2) ON p2.planet_id = ss.dest
            INNER JOIN (starsystems s2) ON s2.system_id = p2.system_id
            WHERE f.fleet_id = '.$fleet_id.' AND
                  ss.move_id = f.move_id';

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT48")).' '.$fleet['fleet_id'].' '.constant($game->sprache("TEXT49")).' '.$fleet['user_id'].' '.constant($game->sprache("TEXT50")).' '.$game->player['user_id']);
    }

    if(!empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT51")));
    }

    $sql = 'SELECT fleet_id, fleet_name
            FROM ship_fleets
            WHERE move_id = '.$fleet['move_id'].' AND
                  user_id = '.$game->player['user_id'].' AND
                  fleet_id <> '.$fleet_id.'
            ORDER BY fleet_name DESC';

    if(($q_ofleets = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other fleet data');
    }

    $other_fleets_html = '';

    while($o_fleets = $db->fetchrow($q_ofleets)) {
        $other_fleets_html .= '<option value="'.$o_fleets['fleet_id'].'">'.$o_fleets['fleet_name'].'</option>'.NL;
    }

    $order_by = (!empty($_GET['order_by'])) ? $_GET['order_by'] : 'template';

    switch($order_by) {
        case 'template':
            $order_by_str = 's.template_id ASC';
        break;

        case 'torso':
            $order_by_str = 'st.ship_torso ASC';
        break;

        case 'experience':
            $order_by_str = 's.experience DESC';
        break;

        case 'construction_time':
            $order_by_str = 's.construction_time ASC';
        break;

        case 'warp':
            $order_by_str = 'st.value_10 ASC';
        break;

        case 'name':
            $order_by_str = 'st.name ASC';
        break;

    }

    $sql = 'SELECT s.*,
                   st.name AS template_name, st.ship_torso, st.value_10, st.value_5 AS max_hitpoints
            FROM (ships s, ship_templates st)
            WHERE s.fleet_id = '.$fleet_id.' AND
                  st.id = s.template_id
            ORDER BY '.$order_by_str;

    if(($q_ships = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships data');
    }

    $n_ships = $n_transporter = 0;
    $ships_option_html = '';

    while($s_ship = $db->fetchrow($q_ships)) {
        /* 07/04/08 - AC: If present, show also ship's name */
        //$ships_option_html .= '<option value="'.$s_ship['ship_id'].'">'.$s_ship['ship_name'].' ('.$s_ship['hitpoints'].'/'.$s_ship['max_hitpoints'].', Exp: '.$s_ship['experience'].')</option>';
        $ships_option_html .= '<option value="'.$s_ship['ship_id'].'">'.(($s_ship['ship_name'] != '')? $s_ship['ship_name'].' - '.$s_ship['template_name'] : $s_ship['template_name']).' ('.$s_ship['hitpoints'].'/'.$s_ship['max_hitpoints'].', Torp: '.($s_ship['ship_torso'] < 3 ? 'n/a' : $s_ship['torp']).', Exp: '.$s_ship['experience'].')</option>';
        if($s_ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter++;

        $n_ships++;
    }

    if($n_ships != $fleet['n_ships']) {
        $sql = 'UPDATE ship_fleets
                SET n_ships = '.$n_ships.'
                WHERE fleet_id = '.$fleet_id;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleet n_ships data');
        }
    }

    $ticks_left = $fleet['move_finish'] - $ACTUAL_TICK;
    if($ticks_left < 0) $ticks_left = 0;

    $ap_green_str = ($fleet['alert_phase'] == ALERT_PHASE_GREEN) ? '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_GREEN.'&move').'">'.constant($game->sprache("TEXT9")).'</a>]';
    $ap_yellow_str = ($fleet['alert_phase'] == ALERT_PHASE_YELLOW) ? '[<span style="color: #FFFF00;">'.constant($game->sprache("TEXT10")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_YELLOW.'&move').'">'.constant($game->sprache("TEXT10")).'</a>]';
    $ap_red_str = ($fleet['alert_phase'] == ALERT_PHASE_RED) ? '[<span style="color: #FF0000;">'.constant($game->sprache("TEXT11")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_RED.'&move').'">'.constant($game->sprache("TEXT11")).'</a>]';	


    // Anfang lesen Homebase Koords

    $planet_id = $fleet['homebase'];

    $sql = 'SELECT * FROM planets WHERE planet_id = '.$planet_id;

    $planet_koords = $db->queryrow($sql);

    $system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$planet_koords['system_id']);

    // Ende lesen Homebasekoords

    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <form name="fleet_form" method="post" action="">
  <tr>
    <td>
      <table width="450" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="350" align="left">[<a href="'.parse_link('a=ship_fleets_display').'">'.constant($game->sprache("TEXT12")).'</a>]&nbsp;&nbsp;&nbsp;<input class="field" type="text" name="fleet_name" value="'.$fleet['fleet_name'].'" maxlength="20" size="25">&nbsp;<input type="submit" class="button_nosize" name="rename_fleet_submit" value="'.constant($game->sprache("TEXT13")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&rename_fleet='.$fleet_id).'\'"></td>
          <td width="100" align="right">'.( ($n_ships == 1) ? '<b>1</b> '.constant($game->sprache("TEXT14")) : '<b>'.$n_ships.'</b> '.constant($game->sprache("TEXT15")) ).'</td>
        </tr>
      </table><br>
      '.constant($game->sprache("TEXT55")).' '.( (!empty($fleet['start'])) ? '<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['start'])).'"><b>'.$fleet['start_planet_name'].'</b></a> ('.$game->get_sector_name($fleet['start_sector']).':'.$game->get_system_cname($fleet['start_system_x'], $fleet['start_system_y']).':'.($fleet['start_distance_id'] + 1).')' : constant($game->sprache("TEXT56")) ).'<br>
      '.constant($game->sprache("TEXT57")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['dest'])).'"><b>'.$fleet['dest_planet_name'].'</b></a> ('.$game->get_sector_name($fleet['dest_sector']).':'.$game->get_system_cname($fleet['dest_system_x'], $fleet['dest_system_y']).':'.($fleet['dest_distance_id'] + 1).')<br><br>

      '.constant($game->sprache("TEXT58")).' <b>'.get_move_action_str($fleet['action_code']).'</b><br>
      '.constant($game->sprache("TEXT59")).' <b id="timer2" title="time1_'.( ($ticks_left * TICK_DURATION * 60) + $NEXT_TICK).'_type2_2">&nbsp;</b><br><br>

      '.constant($game->sprache("TEXT18")).' '.$ap_green_str.'&nbsp;'.$ap_yellow_str.'&nbsp;'.$ap_red_str.'<br><br>
      [<a href="'.parse_link('a=tactical_moves&move_id='.$fleet['move_id']).'">'.constant($game->sprache("TEXT60")).'</a>]<br>
    ');

    if($n_transporter > 0) {
        $n_resources = $fleet['resource_1'] + $fleet['resource_2'] + $fleet['resource_3'] + $fleet['resource_4'];
        $n_units = $fleet['unit_1'] + $fleet['unit_2'] + $fleet['unit_3'] + $fleet['unit_4'] + $fleet['unit_5'] + $fleet['unit_6'];

        $n_security = 0;
        $n_security = $fleet['unit_1']*2+$fleet['unit_2']*3+$fleet['unit_3']*4+$fleet['unit_4']*4; 

        if($n_resources > 0) {
            if($fleet['resource_1'] > 0) $game->out('<br>'.constant($game->sprache("TEXT21")).' <b>'.$fleet['resource_1'].'</b>');
            if($fleet['resource_2'] > 0) $game->out('<br>'.constant($game->sprache("TEXT22")).' <b>'.$fleet['resource_2'].'</b>');
            if($fleet['resource_3'] > 0) $game->out('<br>'.constant($game->sprache("TEXT23")).' <b>'.$fleet['resource_3'].'</b>');
            if($fleet['resource_4'] > 0) $game->out('<br>'.constant($game->sprache("TEXT24")).' <b>'.$fleet['resource_4'].'</b>');
            $game->out('<br>');
        }

        if($n_units > 0) {
            if($fleet['unit_1'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$fleet['unit_1'].'</b>');
            if($fleet['unit_2'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$fleet['unit_2'].'</b>');
            if($fleet['unit_3'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$fleet['unit_3'].'</b>');
            if($fleet['unit_4'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$fleet['unit_4'].'</b>');
            if($fleet['unit_5'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$fleet['unit_5'].'</b>');
            if($fleet['unit_6'] > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$fleet['unit_6'].'</b>');
            $game->out('<br><br><i>'.constant($game->sprache("TEXT25")).' <b>'.$n_security.'</b></i>');
            $game->out('<br>');
        }
    }

    $select_size = ($n_ships < 4) ? ($n_ships + 3) : 8;

    $game->out('
      <br>
      <select name="ships[]" style="width: 410px;" size="'.$select_size.'" multiple="multiple">
      '.$ships_option_html.'
      </select>
      <br>
      '.constant($game->sprache("TEXT30")).' ['.( ($order_by == 'template') ? '<b>'.constant($game->sprache("TEXT31")).'</b>' : '<a 
href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=template').'">'.constant($game->sprache("TEXT31")).'</a>' ).']&nbsp;['.( ($order_by == 'torso') ? 
'<b>'.constant($game->sprache("TEXT32")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=torso').'">'.constant($game->sprache("TEXT32")).'</a>' ).']&nbsp;['.( ($order_by == 'experience') ? '<b>'.constant($game->sprache("TEXT33")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=experience').'">'.constant($game->sprache("TEXT33")).'</a>' ).']&nbsp;['.( ($order_by == 'construction_time') ? '<b>'.constant($game->sprache("TEXT34")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=construction_time').'">'.constant($game->sprache("TEXT34")).'</a>' ).']&nbsp;['.( ($order_by == 'warp') ? '<b>'.constant($game->sprache("TEXT35")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=warp').'">'.constant($game->sprache("TEXT35")).'</a>' ).']&nbsp;['.( ($order_by == 'name') ? '<b>'.constant($game->sprache("TEXT36")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=name').'">'.constant($game->sprache("TEXT36")).'</a>' ).']
      <br><br>
      <input class="button" style="width: 220px;" type="submit" name="ship_details" value="'.constant($game->sprache("TEXT37")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&ship_details').'\'">
      <br><br>
      <table width="450" border="0" cellpadding="2" cellspacing="0">

       <tr>

       <td width="250">'.constant($game->sprache("TEXT39")).' <b>'.( ($planet_koords['sector_id']==0) ? '<b>'.constant($game->sprache("TEXT40")).'</b>' : ''.$game->get_sector_name($planet_koords['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($planet_koords['planet_distance_id'] + 1).' ( '.$planet_koords['planet_name'].' )' ).'</b></td>

       <td width="200"><input class="button" style="width: 130px;" type="submit" name="send_homebase" value="'.constant($game->sprache("TEXT41")).'" disabled="disabled"></td>

       </tr>

       <tr>

         <td width="250"><input class="field" style="width: 130px;" type="text" name="pos_homebase"></td>

         <td width="200"><input class="button" style="width: 130px;" type="submit" name="set_homebase" value="'.constant($game->sprache("TEXT42")).'">&nbsp;&nbsp;</td>

       </tr>

       <tr>

         <td>&nbsp;</td>

       </tr>
        <tr>
          <td width="250"><input class="field"  style="width: 130px;" type="text" name="new_fleet_name"></td>
          <td width="200"><input class="button" style="width: 130px;" type="submit" name="new_fleet_submit" value="'.constant($game->sprache("TEXT43")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&new_fleet='.$fleet_id).'\'"></td>
        </tr>
    ');

    if(!empty($other_fleets_html)) {
        $game->out('
        <tr><td height="5"></td></tr>
        <tr>
          <td><select style="width: 130px;" name="to_fleet">'.$other_fleets_html.'</select></td>
          <td><input class="button" style="width: 130px;" type="submit" name="change_fleet_submit" value="'.constant($game->sprache("TEXT44")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&change_fleet='.$fleet_id).'\'"></td>
        </tr>
        ');
    }

    $game->out('
      </table>
      <input type="hidden" name="fleets[]" value="'.$fleet_id.'">
      <br>
    </td>
  </tr>
  </form>
</table>
</td></tr></table>
    ');
}
elseif(isset($_GET['mass_set_homebase'])) {

    if($game->player['user_id']>0) {

        $game->out('
  <form action="'.parse_link('a=ship_fleets_display').'" method="post">
  <table class="style_outer" width="250" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>
  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="2">

   <tr>
     <td>'.constant($game->sprache("TEXT61")).'</td>
   </tr>
   <tr><td>
   <table>

   <tr>
     <td><b>'.constant($game->sprache("TEXT62")).'</b></td><td>&nbsp;</td>
   </tr>
   <tr>
     <td><input type="text" name="pos_home_all" class="field"></td><td><input type="submit" name="mass_save" value="'.constant($game->sprache("TEXT63")).'" class="button"></td>
   </tr>

   </table></td></tr>

   </table>
   </td></tr></table>
   </form>
   ');
    }
    else $game->out(constant($game->sprache("TEXT64")));
}
else {


    $only_location = 0;

    if(!empty($_GET['only_location'])) {
        $only_location = (is_numeric($_GET['only_location'])) ? (int)$_GET['only_location'] : decode_planet_id($_GET['only_location']);
    }

    $order_by = (!empty($_GET['order_by'])) ? (int)$_GET['order_by'] : 0;

    if( ($order_by < 0) || ($order_by > 3) ) {
        message(NOTICE, 'No bad attempt...');
    }

    if($only_location > 0) {
        switch($order_by) {
            case 0: $order_by_str = 'fleet_name ASC'; break;
            case 1: $order_by_str = 'fleet_name ASC'; break;
            case 2: $order_by_str = 'n_ships ASC'; break;
            case 3: $order_by_str = 'f.alert_phase ASC'; break;
        }

        $sql = 'SELECT fleet_id, fleet_name, planet_id, move_id, n_ships, alert_phase, homebase
                FROM ship_fleets
                WHERE user_id = '.$game->player['user_id'].' AND
                      planet_id = '.$only_location.'
                ORDER BY '.$order_by_str;

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleets data');
        }

        $sql = 'SELECT p.planet_id, p.planet_name, p.sector_id, p.planet_distance_id, p.planet_type,
                       s.system_x, s.system_y,
                       u.user_id, u.user_name
                FROM (planets p)
                INNER JOIN (starsystems s) ON s.system_id = p.system_id
                LEFT JOIN (user u) ON u.user_id = p.planet_owner
                WHERE p.planet_id = '.$only_location;
                
        if(($ol_planet = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query specified planet data');
        }

        if(empty($ol_planet['planet_id'])) {
            message(NOTICE, 'The planet for the display area does not exist');
        }

        $planet_coord_str = $game->get_sector_name($ol_planet['sector_id']).':'.$game->get_system_cname($ol_planet['system_x'], $ol_planet['system_y']).':'.($ol_planet['planet_distance_id'] + 1);
    }
    elseif($only_location == 0) {
        switch($order_by) {
            case 0: $order_by_str = 'f.fleet_name ASC'; break;
            case 1: $order_by_str = 'f.planet_id ASC, f.fleet_name ASC'; break;
            case 2: $order_by_str = 'f.n_ships ASC'; break;
            case 3: $order_by_str = 'f.alert_phase ASC'; break;
        }

        $sql = 'SELECT f.fleet_id, f.fleet_name, f.planet_id, f.n_ships, f.alert_phase, f.homebase,

                       p.planet_name, p.sector_id, p.planet_distance_id, p.planet_type,
                       s.system_x, s.system_y,
                       u.user_id AS stationated_owner_id, u.user_name AS stationated_owner_name,

                       ss.move_id, ss.start, ss.dest, ss.move_begin, ss.move_finish,

                       p1.planet_name AS start_planet_name, p1.sector_id AS start_sector_id, p1.planet_distance_id AS start_distance_id, p1.planet_type AS start_planet_type,
                       s1.system_x AS start_system_x, s1.system_y AS start_system_y,
                       u1.user_id AS start_owner_id, u1.user_name AS start_owner_name,

                       p2.planet_name AS dest_planet_name, p2.sector_id AS dest_sector_id, p2.planet_distance_id AS dest_distance_id, p2.planet_type AS dest_planet_type,
                       s2.system_x AS dest_system_x, s2.system_y AS dest_system_y,
                       u2.user_id AS dest_owner_id, u2.user_name AS dest_owner_name

                FROM (ship_fleets f)

                LEFT JOIN (scheduler_shipmovement ss) ON ss.move_id = f.move_id

                LEFT JOIN (planets p) ON p.planet_id = f.planet_id
                LEFT JOIN (starsystems s) ON s.system_id = p.system_id
                LEFT JOIN (user u) ON u.user_id = p.planet_owner

                LEFT JOIN (planets p1) ON p1.planet_id = ss.start
                LEFT JOIN (starsystems s1) ON s1.system_id = p1.system_id
                LEFT JOIN (user u1) ON u1.user_id = p1.planet_owner
                LEFT JOIN (planets p2) ON p2.planet_id = ss.dest
                LEFT JOIN (starsystems s2) ON s2.system_id = p2.system_id
                LEFT JOIN (user u2) ON u2.user_id = p2.planet_owner

                WHERE f.user_id = '.$game->player['user_id'].'
                ORDER BY '.$order_by_str;

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleets data');
        }
    }
    elseif($only_location == -1) {
        switch($order_by) {
            case 0: $order_by_str = 'f.fleet_name ASC'; break;
            case 1: $order_by_str = 'p.sector_id ASC, s.system_x ASC, s.system_y ASC, f.fleet_name ASC'; break;
            case 2: $order_by_str = 'f.n_ships ASC'; break;
            case 3: $order_by_str = 'f.alert_phase ASC'; break;
        }

        $sql = 'SELECT f.fleet_id, f.fleet_name, f.planet_id, f.move_id, f.n_ships, f.alert_phase, f.homebase,
                       p.planet_name, p.sector_id, p.planet_distance_id, p.planet_type,
                       s.system_x, s.system_y,
                       u.user_id, u.user_name
                FROM (ship_fleets f)
                INNER JOIN (planets p) ON p.planet_id = f.planet_id
                INNER JOIN (starsystems s) ON s.system_id = p.system_id
                LEFT JOIN (user u) ON u.user_id = p.planet_owner
                WHERE f.user_id = '.$game->player['user_id'].' AND
                      f.planet_id <> 0 AND
                      p.planet_id = f.planet_id
                ORDER BY '.$order_by_str;

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleets data');
        }
    }
    elseif($only_location == -2) {
        switch($order_by) {
            case 0: $order_by_str = 'f.fleet_name ASC'; break;
            case 1: $order_by_str = 'p1.sector_id ASC, s1.system_x ASC, s1.system_y ASC, p2.sector_id ASC, s2.system_x ASC, s2.system_y ASC, f.fleet_name ASC'; break;
            case 2: $order_by_str = 'f.n_ships ASC'; break;
            case 3: $order_by_str = 'f.alert_phase ASC'; break;
        }

        $sql = 'SELECT f.fleet_id, f.fleet_name, f.planet_id, f.n_ships, f.alert_phase, f.homebase,
                       ss.move_id, ss.start, ss.dest, ss.move_begin, ss.move_finish,

                       p1.planet_name AS start_planet_name, p1.sector_id AS start_sector_id, p1.planet_distance_id AS start_distance_id, p1.planet_type AS start_planet_type,
                       s1.system_x AS start_system_x, s1.system_y AS start_system_y,
                       u1.user_name AS start_owner_id, u1.user_name AS start_owner_name,

                       p2.planet_name AS dest_planet_name, p2.sector_id AS dest_sector_id, p2.planet_distance_id AS dest_distance_id, p2.planet_type AS dest_planet_type,
                       s2.system_x AS dest_system_x, s2.system_y AS dest_system_y,
                       u2.user_name AS dest_owner_id, u2.user_name AS dest_owner_name
                FROM (ship_fleets f)

                INNER JOIN (scheduler_shipmovement ss) ON ss.move_id = f.move_id

                INNER JOIN (planets p1) ON p1.planet_id = ss.start
                INNER JOIN (starsystems s1) ON s1.system_id = p1.system_id
                LEFT JOIN (user u1) ON u1.user_id = p1.planet_owner

                INNER JOIN (planets p2) ON p2.planet_id = ss.dest
                INNER JOIN (starsystems s2) ON s2.system_id = p2.system_id
                LEFT JOIN (user u2) ON u2.user_id = p2.planet_owner

                WHERE f.user_id = '.$game->player['user_id'].' AND
                      f.move_id <> 0
                ORDER BY '.$order_by_str;

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleets data');
        }
    }
    else {
        message(NOTICE, 'Nice try...');
    }

    $game->out('
<table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>
  <table width="400" border="0" cellpadding="2" cellspacing="0">
    <form method="get" action="'.parse_link('').'">
    <input type="hidden" name="a" value="ship_fleets_display">
    <tr>
      <td width="130" align="center">'.constant($game->sprache("TEXT65")).'</td>
      <td width="220" align="center">
        <select name="only_location">
          <option value="0"'.( ($only_location == 0) ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT66")).'</option>
          <option value="-1"'.( ($only_location == -1) ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT67")).'</option>
          <option value="-2"'.( ($only_location == -2) ? ' selected="selected"' : '' ).'>'.constant($game->sprache("TEXT68")).'</option>
    ');

    $sql = 'SELECT DISTINCT f.planet_id, f.alert_phase, f.homebase,
                   p.planet_name, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (ship_fleets f, planets p)
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE f.user_id = '.$game->player['user_id'].' AND
                  f.planet_id <> 0 AND
                  p.planet_id = f.planet_id
            GROUP BY f.planet_id
            ORDER BY p.planet_name ASC';

    if(!$q_fplanets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query fleets planet data');
    }

    while($planet = $db->fetchrow($q_fplanets)) {
        $game->out('<option value="'.encode_planet_id($planet['planet_id']).'"'.( ($only_location == $planet['planet_id']) ? ' selected="selected"' : '' ).'>'.$planet['planet_name'].' ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')</option>');
    }

    $game->out('
        </select>
      </td>
      <td width="50" align="center"><input class="button" type="submit" value="OK"></td>
    </tr>
    <input type="hidden" name="order_by" value="'.$order_by.'">
    </form>
  </table>
  <br>
  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="fleets_form" method="post" action="'.parse_link().'">
    <tr><td height="10"></td></tr>
    <tr>
      <td width="25">&nbsp;</td>
      <td width="125"><b>'.( ($order_by == 0) ? constant($game->sprache("TEXT69")) : '<a href="'.parse_link('a=ship_fleets_display&only_location='.$only_location.'&order_by=0').'">'.constant($game->sprache("TEXT69")).'</a>' ).'</b></td>
      <td width="220"><b>'.( ($order_by == 1) ? constant($game->sprache("TEXT70")) : '<a href="'.parse_link('a=ship_fleets_display&only_location='.$only_location.'&order_by=1').'">'.constant($game->sprache("TEXT70")).'</a>' ).'</b></td>
      <td widht="30" align="center"><b>'.( ($order_by == 2) ? '#' : '<a href="'.parse_link('a=ship_fleets_display&only_location='.$only_location.'&order_by=2').'">#</a>' ).'</b></td>
      <td widht="60" align="center"><b>'.( ($order_by == 3) ? constant($game->sprache("TEXT18")) : '&nbsp;&nbsp;<a href="'.parse_link('a=ship_fleets_display&only_location='.$only_location.'&order_by=3').'">'.constant($game->sprache("TEXT18")).'</a>' ).'</b></td>
      <td widht="100" align="center"><b>'.constant($game->sprache("TEXT71")).'</b></td>
    </tr>
    <tr><td height="5"></td></tr>
    ');

    $i = 2;

    $INVALID_FLEET_POSITION = false;

    while($fleet = $db->fetchrow($q_fleets)) {
        $location_str = constant($game->sprache("TEXT56"));

        if(!empty($fleet['planet_id'])) {
            if($only_location > 0) {
                $location_str = overlib(
                    $planet_coord_str,
                    '<b>'.addslashes($ol_planet['planet_name']).'</b><br>'.( (!empty($ol_planet['user_id'])) ? constant($game->sprache("TEXT72")).' <b>'.$ol_planet['user_name'].'</b>' : constant($game->sprache("TEXT73")) ).'<br>'.constant($game->sprache("TEXT74")).' <b>'.strtoupper($ol_planet['planet_type']).'</b>',
                    parse_link('a=tactical_cartography&planet_id='.encode_planet_id($only_location))
                );
            }
            else {
                $location_str = overlib(
                    $game->get_sector_name($fleet['sector_id']).':'.$game->get_system_cname($fleet['system_x'], $fleet['system_y']).':'.($fleet['planet_distance_id'] + 1),
                    '<b>'.addslashes($fleet['planet_name']).'</b><br>'.( (!empty($fleet['stationated_owner_id'])) ? constant($game->sprache("TEXT72")).' <b>'.$fleet['stationated_owner_name'].'</b>' : constant($game->sprache("TEXT73")) ).'<br>'.constant($game->sprache("TEXT74")).' <b>'.strtoupper($fleet['planet_type']).'</b>',
                    parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['planet_id']))
                );
            }
        }
        elseif(!empty($fleet['move_id'])) {
	    // 03/02/13 - DC: Still here, handling FOW for the starting planet
	    $system_known = false;
	    if($fleet['start_owner_id'] == $game->player['user_id'])
                $system_known = true;
            else {
                $sql = 'SELECT pd.log_code FROM (planets p)
                               LEFT JOIN (planet_details pd) ON p.system_id = pd.system_id
                        WHERE p.planet_id = '.$fleet['start'].' AND pd.user_id = '.$game->player['user_id'];
                if((($_temp = $db->queryrow($sql)) == true) && ($_temp['log_code'] > 0)) {
                    $system_known = true;
                }
            }
	    if($system_known) {
                $start_name = addslashes($fleet['start_planet_name']);
                $start_owner = ( (!empty($fleet['start_owner_id'])) ? constant($game->sprache("TEXT72")).' <b>'.$fleet['start_owner_name'].'</b>' : constant($game->sprache("TEXT73")) );
                $start_class = strtoupper($fleet['start_planet_type']);
            }
            else {
                $start_name = '&#171;'.constant($game->sprache("TEXT56")).'&#187;';
                $start_owner = constant($game->sprache("TEXT72")).' <b>&#171;'.constant($game->sprache("TEXT56")).'&#187;</b>';
                $start_class = '&#171;'.constant($game->sprache("TEXT77")).'&#187;';
            }

            $start_planet_str = overlib(
                $game->get_sector_name($fleet['start_sector_id']).':'.$game->get_system_cname($fleet['start_system_x'], $fleet['start_system_y']).':'.($fleet['start_distance_id'] + 1),
                '<b>'.$start_name.'</b><br>'.$start_owner.'<br>'.constant($game->sprache("TEXT74")).' <b>'.$start_class.'</b>',
                parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['start']))
            );

            // 30/09/08 - AC: Added fog of war also in this module
            $system_known = false;
            if($fleet['dest_owner_id'] == $game->player['user_id'])
                $system_known = true;
            else {
                $sql = 'SELECT pd.log_code FROM (planets p)
                               LEFT JOIN (planet_details pd) ON p.system_id = pd.system_id
                        WHERE p.planet_id = '.$fleet['dest'].' AND pd.user_id = '.$game->player['user_id'];
                if((($_temp = $db->queryrow($sql)) == true) && ($_temp['log_code'] > 0)) {
                    $system_known = true;
                }
            }
            if($system_known) {
                $dest_name = addslashes($fleet['dest_planet_name']);
                $dest_owner = ( (!empty($fleet['dest_owner_id'])) ? constant($game->sprache("TEXT72")).' <b>'.$fleet['dest_owner_name'].'</b>' : constant($game->sprache("TEXT73")) );
                $dest_class = strtoupper($fleet['dest_planet_type']);
            }
            else {
                $dest_name = '&#171;'.constant($game->sprache("TEXT56")).'&#187;';
                $dest_owner = constant($game->sprache("TEXT72")).' <b>&#171;'.constant($game->sprache("TEXT56")).'&#187;</b>';
                $dest_class = '&#171;'.constant($game->sprache("TEXT77")).'&#187;';
            }

            $dest_planet_str = overlib(
                $game->get_sector_name($fleet['dest_sector_id']).':'.$game->get_system_cname($fleet['dest_system_x'], $fleet['dest_system_y']).':'.($fleet['dest_distance_id'] + 1),
                '<b>'.$dest_name.'</b><br>'.$dest_owner.'<br>'.constant($game->sprache("TEXT74")).' <b>'.$dest_class.'</b>',
                parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['dest']))
            );

            $ticks_left = $fleet['move_finish'] - $ACTUAL_TICK;
            if($ticks_left < 0) $ticks_left = 0;

            $location_str = $start_planet_str.' -> '.$dest_planet_str.' ('.( ($i < 10) ? '<b id="timer'.$i.'" title="time1_'.( ($ticks_left * TICK_DURATION * 60) + $NEXT_TICK).'_type2_2">&nbsp;</b>' : '<b>'.format_time( $ticks_left * TICK_DURATION ).'</b>' ).')';

            ++$i;
        }
        else {
            $sql = 'UPDATE ship_fleets
                    SET planet_id = '.$game->player['user_capital'].',
                        move_id = 0
                    WHERE fleet_id = '.$fleet['fleet_id'];
                    
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update fleets location data');
            }

            $INVALID_FLEET_POSITION = true;

            continue;
        }

        $output_phase = '&nbsp;&nbsp;&nbsp;[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet['fleet_id'].'&to=');

        if ($fleet['alert_phase']==ALERT_PHASE_GREEN) {
            $output_phase .= '1&main"><span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span></a>]&nbsp;&nbsp;&nbsp;';
        }
        elseif ($fleet['alert_phase']==ALERT_PHASE_YELLOW) {
            $output_phase .= '2&main"><span style="color: #FFFF00;">'.constant($game->sprache("TEXT10")).'</span></a>]&nbsp;&nbsp;&nbsp;';
        }
        else {
            $output_phase .= '0&main"><span style="color: #FF0000;">'.constant($game->sprache("TEXT11")).'</span></a>]&nbsp;&nbsp;&nbsp;';
        }

        // Anfang lesen Homebase Koords
        if($fleet['homebase']!=0) {
            $planet_id = $fleet['homebase'];
            $sql = 'SELECT * FROM planets WHERE planet_id = '.$planet_id;

            $planet_koords = $db->queryrow($sql);

            $system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$planet_koords['system_id']);
        }
        // Ende lesen Homebasekoords


        $game->out('
    <tr><td height="1"></td></tr>
    <tr>
      <td><input type="checkbox" name="fleets[]" value="'.$fleet['fleet_id'].'"></td>
      <td><a href="'.parse_link('a=ship_fleets_display&'.( ($fleet['planet_id']) ? 'p' : 'm' ).'fleet_details='.$fleet['fleet_id']).'">'.$fleet['fleet_name'].'</a></td>
      <td>'.$location_str.'</td>
      <td align="center">'.$fleet['n_ships'].'</td>
      <td align="center">'.$output_phase.'</td>
      <td align="center">'.( ($fleet['homebase']!=0) ? ''.$game->get_sector_name($planet_koords['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($planet_koords['planet_distance_id'] + 1).'' : constant($game->sprache("TEXT40")) ).'</td>
    </tr>
        ');
    }

    if($INVALID_FLEET_POSITION) {
        message(NOTICE, 'At least one of your fleets have no positional data, therefore they were reset to your home planet.');
    }

    $own_planets_html = $tcm_html = '';

    $sql = 'SELECT p.planet_name, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (planets p)
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE p.planet_owner = '.$game->uid.'
            ORDER BY p.planet_name ASC';

    if(!$q_own_planets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query own planets coord data');
    }

    while($planet = $db->fetchrow($q_own_planets)) {
        $own_planets_html .= '<option value="'.($game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1)).'">'.$planet['planet_name'].'</option>';
    }

    $sql = 'SELECT tcm.memo_name,
                   p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (tc_coords_memo tcm)
            INNER JOIN (planets p) ON p.planet_id = tcm.memo_id
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE tcm.user_id = '.$game->player['user_id'].' AND
                  tcm.memo_view = 4';

    if(!$q_tcm = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query tactical coords memo data');
    }

    while($tcm = $db->fetchrow($q_tcm)) {
        $tcm_html .= '<option value="'.($game->get_sector_name($tcm['sector_id']).':'.$game->get_system_cname($tcm['system_x'], $tcm['system_y']).':'.($tcm['planet_distance_id'] + 1)).'">'.$tcm['memo_name'].'</option>';
    }

    $has_own_planets = (!empty($own_planets_html));
    $has_tcm = (!empty($tcm_html));

    $game->out('
  </table>
  <br>
  <table width="380" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><select style="width: 130px;"'.( ($has_own_planets || $has_tcm) ? ' onChange="if(this.value) document.fleets_form.dest_coord.value = this.value;"' : ' disabled="disabled"' ).'><option>'.constant($game->sprache("TEXT46")).'</option>'.( ( ($has_own_planets) ? '<option>---------------------</option>'.$own_planets_html : '' ).( ($has_tcm) ? '<option>---------------------</option>'.$tcm_html : '' ) ).'</select>&nbsp;&nbsp;<input type="text" class="field" name="dest_coord" size="10">&nbsp;&nbsp;<input class="button" type="submit" name="send_fleets" value="'.constant($game->sprache("TEXT47")).'" onClick="return document.fleets_form.action = \''.parse_link('a=ship_send').'\'"></td>
    </tr>

    <tr><td height="5"></td></tr>

    <tr>
      <td><input type="text" class="field" name="join_fleet_name">&nbsp;&nbsp;<input type="submit" class="button" name="join_fleets_submit" value="'.constant($game->sprache("TEXT75")).'" onClick="return document.fleets_form.action = \''.parse_link('a=ship_fleets_ops&join_fleets').'\'"></td>
    </tr>

    <tr><td height="5"></td></tr>

    <tr>
      <td width="200"><input class="button" style="width: 130px;" type="submit" name="send_homebase" value="'.constant($game->sprache("TEXT41")).'" onClick="return document.fleets_form.action = \''.parse_link('a=send_home').'\'"></td>
    </tr>

  </table>
</form>
</td></tr></table></td></tr></table></div>
    ');
}




?>
