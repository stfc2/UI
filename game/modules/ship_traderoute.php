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
$game->out('<center><span class="caption">'.constant($game->sprache("TEXT0")).'</span></center><br>');


// #############################################################################
// Input-Checking
//
// Although we only need fleet_id, we use arrays also here to
// have compatibility with ship_send (such as ship_fleets_display required)

if(empty($_POST['fleets'])) {
    message(NOTICE, constant($game->sprache("TEXT1")));
}

$fleet_id = (int)$_POST['fleets'][0];


// #############################################################################
// Load data fleet

if(empty($fleet_id)) {
    message(NOTICE, constant($game->sprache("TEXT1")));
}

$sql = 'SELECT *
        FROM ship_fleets
        WHERE fleet_id = '.$fleet_id;

if(($fleet = $db->queryrow($sql)) === false) {
    message(DATABASE_ERROR, 'Could not query fleet data');
}


// #############################################################################
// Load start planet data

$start = (int)$fleet['planet_id'];

if($start == 0) {
    message(NOTICE, constant($game->sprache("TEXT2")));
}

if($start == $game->planet['planet_id']) {
    $start_planet = $game->planet;

    $start_planet['user_id'] = $game->player['user_id'];
    $start_planet['user_name'] = $game->player['user_name'];

    // Player data can not be fetched, because they are not displayed / used
}
else {
    $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                   p.resource_1, p.resource_2, p.resource_3, p.resource_4,
                   p.unit_1, p.unit_2, p.unit_3, p.unit_4, p.unit_5, p.unit_6,
                   s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                   u.user_id, u.user_name
            FROM (starsystems s), (planets p)
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE p.planet_id = '.$start.' AND
                  s.system_id = p.system_id';

    if(($start_planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query start planet data');
    }

    if(empty($start_planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if(empty($start_planet['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }

    // 02/05/09 - AC: Player does own the planet?
    if($start_planet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT40")));
    }
}


// #############################################################################
// Search target

if(!empty($_POST['dest_coord'])) {
    $coord_pieces = explode(':', $_POST['dest_coord']);
    $n_pieces = count($coord_pieces);
    
    if($n_pieces != 3) {
        message(NOTICE, constant($game->sprache("TEXT5")));
    }

    $sector_id = $game->get_sector_id($coord_pieces[0]);

    $letters = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18);
    $numbers = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18);

    if(!isset($letters[$coord_pieces[1][0]])) {
        message(NOTICE, constant($game->sprache("TEXT5a")), $coord_pieces[1][0].' '.constant($game->sprache("TEXT5b")));
    }

    $system_y = $letters[$coord_pieces[1][0]];

    if(!isset($numbers[$coord_pieces[1][1]])) {
        message(NOTICE, constant($game->sprache("TEXT5c")), $coord_pieces[1][1].' '.constant($game->sprache("TEXT5d")));
    }

    $system_x = $numbers[$coord_pieces[1][1]];

    $distance_id = (int)$coord_pieces[2] - 1;

    $sql = 'SELECT p.planet_id,
                   u.user_id
            FROM (starsystems s), (planets p)
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE s.sector_id = '.$sector_id.' AND
                  s.system_x = '.$system_x.' AND
                  s.system_y = '.$system_y.' AND
                  p.system_id = s.system_id AND
                  p.planet_distance_id = '.$distance_id;

    if(($planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    if(empty($planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT6")).'<b>'.$_POST['dest_coord'].'</b>');
    }

    if(empty($planet['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }

    $dest = (int)$planet['planet_id'];
}
else {
    $dest = (!empty($_POST['dest'])) ? (int)$_POST['dest'] : 0;
}

if(empty($dest)) {
    message(NOTICE, constant($game->sprache("TEXT7")));
}


// #############################################################################
// <lost comment>

if($start == $dest) {
    message(NOTICE, constant($game->sprache("TEXT8")));
}


// #############################################################################
// Load target planet data

if($dest == $game->planet['planet_id']) {
    $dest_planet = $game->planet;

    $dest_planet['user_id'] = $game->player['user_id'];
    $dest_planet['user_name'] = $game->player['user_name'];

    // Player data can not be fetched, because they are not displayed / used
}
else {
    $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                   p.resource_1, p.resource_2, p.resource_3, p.resource_4,
                   p.unit_1, p.unit_2, p.unit_3, p.unit_4, p.unit_5, p.unit_6,
                   s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                   u.user_id, u.user_name
            FROM (starsystems s), (planets p)
            LEFT JOIN user u ON u.user_id = p.planet_owner
            WHERE p.planet_id = '.$dest.' AND
                  s.system_id = p.system_id';

    if(($dest_planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query destination planet data');
    }

    if(empty($dest_planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT9")));
    }

    if(empty($dest_planet['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }
}


// #############################################################################
// Which ship's classes fly also?
// (Only transport are allowed + speed)

$sql = 'SELECT st.ship_torso, st.value_10 AS warp_speed
        FROM (ships s), (ship_templates st)
        WHERE s.fleet_id = '.$fleet_id.' AND
              st.id = s.template_id';

if(!$q_stpls = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query ship template data');
}

$max_warp_speed = 9.99; // not interested in precision

while($_temp = $db->fetchrow($q_stpls)) {
    if($_temp['warp_speed'] < $max_warp_speed) $max_warp_speed = $_temp['warp_speed'];

    if($_temp['ship_torso'] != SHIP_TYPE_TRANSPORTER) {
        message(NOTICE, constant($game->sprache("TEXT10")));
    }

}

// #############################################################################
// A few settings set
$own_planet = ($game->player['user_id'] == $dest_planet['user_id']) ? true : false;

$inter_planet = $inter_system = false;

if($start_planet['system_id'] == $dest_planet['system_id']) $inter_planet = true;
else $inter_system = true;

$step = (!empty($_POST['step'])) ? $_POST['step'] : 'basic_setup';

switch($step) {
    case 'summary':
        $distance = $velocity = 0;

        if($game->player['user_auth_level'] == STGC_DEVELOPER) $min_time = 1;
        elseif($inter_planet) $min_time = 6;
        else {
            include_once('include/libs/moves.php');

            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION ) );
        }

        $_start_actions = unserialize(gzuncompress(base64_decode($_POST['start_setup_post'])));

        if(!is_array($_start_actions)) {
            message(GENERAL, 'Ungltiger Parameter', '$_start_actions = !is_array');
        }

        $start_actions = array(
            101 => ($_start_actions['start_load_r1_all']) ? -1 : (int)$_start_actions['start_load_r1'],
            102 => ($_start_actions['start_load_r2_all']) ? -1 : (int)$_start_actions['start_load_r2'],
            103 => ($_start_actions['start_load_r3_all']) ? -1 : (int)$_start_actions['start_load_r3'],
            104 => ($_start_actions['start_load_r4_all']) ? -1 : (int)$_start_actions['start_load_r4'],
            111 => ($_start_actions['start_load_u1_all']) ? -1 : (int)$_start_actions['start_load_u1'],
            112 => ($_start_actions['start_load_u2_all']) ? -1 : (int)$_start_actions['start_load_u2'],
            113 => ($_start_actions['start_load_u3_all']) ? -1 : (int)$_start_actions['start_load_u3'],
            114 => ($_start_actions['start_load_u4_all']) ? -1 : (int)$_start_actions['start_load_u4'],
            115 => ($_start_actions['start_load_u5_all']) ? -1 : (int)$_start_actions['start_load_u5'],
            116 => ($_start_actions['start_load_u6_all']) ? -1 : (int)$_start_actions['start_load_u6'],

            201 => ($_start_actions['start_unload_r1_all']) ? -1 : (int)$_start_actions['start_unload_r1'],
            202 => ($_start_actions['start_unload_r2_all']) ? -1 : (int)$_start_actions['start_unload_r2'],
            203 => ($_start_actions['start_unload_r3_all']) ? -1 : (int)$_start_actions['start_unload_r3'],
            204 => ($_start_actions['start_unload_r4_all']) ? -1 : (int)$_start_actions['start_unload_r4'],
            211 => ($_start_actions['start_unload_u1_all']) ? -1 : (int)$_start_actions['start_unload_u1'],
            212 => ($_start_actions['start_unload_u2_all']) ? -1 : (int)$_start_actions['start_unload_u2'],
            213 => ($_start_actions['start_unload_u3_all']) ? -1 : (int)$_start_actions['start_unload_u3'],
            214 => ($_start_actions['start_unload_u4_all']) ? -1 : (int)$_start_actions['start_unload_u4'],
            215 => ($_start_actions['start_unload_u5_all']) ? -1 : (int)$_start_actions['start_unload_u5'],
            216 => ($_start_actions['start_unload_u6_all']) ? -1 : (int)$_start_actions['start_unload_u6']
        );

        $dest_actions = array(
            101 => ($_POST['dest_load_r1_all']) ? -1 : (int)$_POST['dest_load_r1'],
            102 => ($_POST['dest_load_r2_all']) ? -1 : (int)$_POST['dest_load_r2'],
            103 => ($_POST['dest_load_r3_all']) ? -1 : (int)$_POST['dest_load_r3'],
            104 => ($_POST['dest_load_r4_all']) ? -1 : (int)$_POST['dest_load_r4'],
            111 => ($_POST['dest_load_u1_all']) ? -1 : (int)$_POST['dest_load_u1'],
            112 => ($_POST['dest_load_u2_all']) ? -1 : (int)$_POST['dest_load_u2'],
            113 => ($_POST['dest_load_u3_all']) ? -1 : (int)$_POST['dest_load_u3'],
            114 => ($_POST['dest_load_u4_all']) ? -1 : (int)$_POST['dest_load_u4'],
            115 => ($_POST['dest_load_u5_all']) ? -1 : (int)$_POST['dest_load_u5'],
            116 => ($_POST['dest_load_u6_all']) ? -1 : (int)$_POST['dest_load_u6'],

            201 => ($_POST['dest_unload_r1_all']) ? -1 : (int)$_POST['dest_unload_r1'],
            202 => ($_POST['dest_unload_r2_all']) ? -1 : (int)$_POST['dest_unload_r2'],
            203 => ($_POST['dest_unload_r3_all']) ? -1 : (int)$_POST['dest_unload_r3'],
            204 => ($_POST['dest_unload_r4_all']) ? -1 : (int)$_POST['dest_unload_r4'],
            211 => ($_POST['dest_unload_u1_all']) ? -1 : (int)$_POST['dest_unload_u1'],
            212 => ($_POST['dest_unload_u2_all']) ? -1 : (int)$_POST['dest_unload_u2'],
            213 => ($_POST['dest_unload_u3_all']) ? -1 : (int)$_POST['dest_unload_u3'],
            214 => ($_POST['dest_unload_u4_all']) ? -1 : (int)$_POST['dest_unload_u4'],
            215 => ($_POST['dest_unload_u5_all']) ? -1 : (int)$_POST['dest_unload_u5'],
            216 => ($_POST['dest_unload_u6_all']) ? -1 : (int)$_POST['dest_unload_u6']
        );

        $load_sum = ($start_actions[101] + $start_actions[102] + $start_actions[103] + $start_actions[104] +
                     $start_actions[111] + $start_actions[112] + $start_actions[113] + $start_actions[114] + $start_actions[115] + $start_actions[116] +
                     $dest_actions[101] + $dest_actions[102] + $dest_actions[103] + $dest_actions[104] +
                     $dest_actions[111] + $dest_actions[112] + $dest_actions[113] + $dest_actions[114] + $dest_actions[115] + $dest_actions[116]);

        // This COULD also happen, if several times everything (-1) was selected and
        // likewise the appropriate equivalent in fixed loading (thus e.g. 5 * -1 + 5 * +1)
        // That is however... improbable...

        if($load_sum == 0) {
            message(NOTICE, constant($game->sprache("TEXT11")));
        }

        $max_resources = $fleet['n_ships'] * MAX_TRANSPORT_RESOURCES;
        $max_units = $fleet['n_ships'] * MAX_TRANSPORT_UNITS;

        $n_resources = $fleet['resource_1'] + $fleet['resource_2'] + $fleet['resource_3'];
        $n_units = $fleet['resource_4'] + $fleet['unit_1'] + $fleet['unit_2'] + $fleet['unit_3'] + $fleet['unit_4'] + $fleet['unit_5'] + $fleet['unit_6'];

        $resources = array(101 => 'resource_1', 102 => 'resource_2', 103 => 'resource_3');
        $units = array(104 => 'resource_4', 111 => 'unit_1', 112 => 'unit_2', 113 => 'unit_3', 114 => 'unit_4', 115 => 'unit_5', 116 => 'unit_6');

        $fwares = $pwares = array();

        foreach($resources as $code => $column) {
            $fwares[$column] = $fleet[$column];
            $pwares[$column] = $start_planet[$column];

            $value = ($start_actions[$code] == -1) ? $pwares[$column] : $start_actions[$code];

            if($value > $pwares[$column]) {
                $value = $pwares[$column];
            }

            if( ($n_resources + $value) > $max_resources ) {
                $value = $max_resources - $n_resources;
            }

            $fwares[$column] += $value;
            $pwares[$column] -= $value;

            $n_resources += $value;
        }

        foreach($units as $code => $column) {
            $fwares[$column] = $fleet[$column];
            $pwares[$column] = $start_planet[$column];

            $value = ($start_actions[$code] == -1) ? $pwares[$column] : $start_actions[$code];

            if($value > $pwares[$column]) {
                $value = $pwares[$column];
            }

            if( ($n_units + $value) > $max_units ) {
                $value = $max_units - $n_units;
            }

            $fwares[$column] += $value;
            $pwares[$column] -= $value;

            $n_units += $value;
        }

        $route_mode = (!empty($_POST['n_run'])) ? $_POST['n_run'] : 'one';

        $_mode = ($route_mode == 'one') ? 2 : -1;

        // Player wants report?
        if(empty($_POST['do_report'])) $_POST['do_report'] = 'no';
        $report = ($_POST['do_report'] == 'yes'? true : false);

        $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
                VALUES ('.$game->player['user_id'].', 0, 0, '.$start.', '.$dest.', '.$distance.', '.$distance.', '.($velocity * TICK_DURATION).', '.$ACTUAL_TICK.', '.($ACTUAL_TICK + max((int)$_POST['move_time'], $min_time)).', '.$fleet['n_ships'].', 34, "'.serialize(array(0, $start, $dest, $start_actions, $dest_actions, $_mode, $report)).'")';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }

        $new_move_id = $db->insert_id();

        $sql = 'UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.',
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
                WHERE fleet_id = '.$fleet_id;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleet data');
        }

        $sql = 'UPDATE planets
                SET resource_1 = '.$pwares['resource_1'].',
                    resource_2 = '.$pwares['resource_2'].',
                    resource_3 = '.$pwares['resource_3'].',
                    resource_4 = '.$pwares['resource_4'].',
                    unit_1 = '.$pwares['unit_1'].',
                    unit_2 = '.$pwares['unit_2'].',
                    unit_3 = '.$pwares['unit_3'].',
                    unit_4 = '.$pwares['unit_4'].',
                    unit_5 = '.$pwares['unit_5'].',
                    unit_6 = '.$pwares['unit_6'].'
                WHERE planet_id = '.$start;

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update planet data');
        }

        redirect('a=ship_fleets_display&mfleet_details='.$fleet_id);
    break;

    case 'start_setup':
        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="traderoute_form" method="post" action="'.parse_link('a=ship_traderoute').'" onSubmit="return document.send_form.submit.disabled = true;">
  <input type="hidden" name="dest" value="'.$dest.'">
  <input type="hidden" name="fleets[0]" value="'.$fleet_id.'">
  <input type="hidden" name="step" value="dest_setup">
  <input type="hidden" name="n_run" value="'.$_POST['n_run'].'">
  <input type="hidden" name="do_report" value="'.$_POST['do_report'].'">
  <tr>
    <td>
      '.constant($game->sprache("TEXT12")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($start)).'"><b>'.$start_planet['planet_name'].'</b></a> ('.$game->get_sector_name($start_planet['sector_id']).':'.$game->get_system_cname($start_planet['system_x'], $start_planet['system_y']).':'.($start_planet['planet_distance_id'] + 1).')'.( ($start_planet['user_id'] != $game->player['user_id']) ? constant($game->sprache("TEXT13")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$start_planet['user_id']).'"><b>'.$start_planet['user_name'].'</b></a>' : '' ).'<br>
      '.constant($game->sprache("TEXT14")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($dest)).'"><b>'.$dest_planet['planet_name'].'</b></a> ('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')'.( ($dest_planet['user_id'] != $game->player['user_id']) ? constant($game->sprache("TEXT13")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$dest_planet['user_id']).'"><b>'.$dest_planet['user_name'].'</b></a>' : '' ).'<br><br>      '.constant($game->sprache("TEXT15")).'<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'"><b>'.$fleet['fleet_name'].'</b></a><br><br>
      '.constant($game->sprache("TEXT16")).'<b>'.($fleet['n_ships'] * MAX_TRANSPORT_RESOURCES).' '.constant($game->sprache("TEXT17")).($fleet['n_ships'] * MAX_TRANSPORT_UNITS).constant($game->sprache("TEXT18")).'</b><br><br>
      <b>'.constant($game->sprache("TEXT19")).'</b><br><br>
      <table border="0">
        <tr>
          <td width="10">&nbsp;</td>
          <td>
            <table border="0">
              <tr>
                <td colspan="2"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                <td>'.constant($game->sprache("TEXT21")).'</td>
              </tr>
              <tr>
                <td width="80">'.constant($game->sprache("TEXT22")).'</td>
                <td width="160"><input class="field" type="text" name="start_load_r1" value=""></td>
                <td><input type="checkbox" name="start_load_r1_all" value="1" onClick="document.traderoute_form.start_load_r1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT23")).'</td>
                <td><input class="field" type="text" name="start_load_r2" value=""></td>
                <td><input type="checkbox" name="start_load_r2_all" value="1" onClick="document.traderoute_form.start_load_r2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT24")).'</td>
                <td><input class="field" type="text" name="start_load_r3" value=""></td>
                <td><input type="checkbox" name="start_load_r3_all" value="1" onClick="document.traderoute_form.start_load_r3.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.constant($game->sprache("TEXT25")).'</td>
                <td><input class="field" type="text" name="start_load_r4" value=""></td>
                <td><input type="checkbox" name="start_load_r4_all" value="1" onClick="document.traderoute_form.start_load_r4.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].':</td>
                <td><input class="field" type="text" name="start_load_u1" value=""></td>
                <td><input type="checkbox" name="start_load_u1_all" value="1" onClick="document.traderoute_form.start_load_u1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].':</td>
                <td><input class="field" type="text" name="start_load_u2" value=""></td>
                <td><input type="checkbox" name="start_load_u2_all" value="1" onClick="document.traderoute_form.start_load_u2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].':</td>
                <td><input class="field" type="text" name="start_load_u3" value=""></td>
                <td><input type="checkbox" name="start_load_u3_all" value="1" onClick="document.traderoute_form.start_load_u3.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].':</td>
                <td><input class="field" type="text" name="start_load_u4" value=""></td>
                <td><input type="checkbox" name="start_load_u4_all" value="1" onClick="document.traderoute_form.start_load_u4.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].':</td>
                <td><input class="field" type="text" name="start_load_u5" value=""></td>
                <td><input type="checkbox" name="start_load_u5_all" value="1" onClick="document.traderoute_form.start_load_u5.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].':</td>
                <td><input class="field" type="text" name="start_load_u6" value=""></td>
                <td><input type="checkbox" name="start_load_u6_all" value="1" onClick="document.traderoute_form.start_load_u6.disabled = this.checked;"></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td height="15"></td></tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td>
            <table border="0">
              <tr>
                <td colspan="3"><b>'.constant($game->sprache("TEXT26")).'</b></td>
              </tr>
              <tr>
                <td width="80">'.constant($game->sprache("TEXT22")).'</td>
                <td width="160"><input class="field" type="text" name="start_unload_r1" value=""></td>
                <td><input type="checkbox" name="start_unload_r1_all" value="1" onClick="document.traderoute_form.start_unload_r1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT23")).'</td>
                <td><input class="field" type="text" name="start_unload_r2" value=""></td>
                <td><input type="checkbox" name="start_unload_r2_all" value="1" onClick="document.traderoute_form.start_unload_r2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT24")).'</td>
                <td><input class="field" type="text" name="start_unload_r3" value=""></td>
                <td><input type="checkbox" name="start_unload_r3_all" value="1" onClick="document.traderoute_form.start_unload_r3.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.constant($game->sprache("TEXT25")).'</td>
                <td><input class="field" type="text" name="start_unload_r4" value=""></td>
                <td><input type="checkbox" name="start_unload_r4_all" value="1" onClick="document.traderoute_form.start_unload_r4.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].':</td>
                <td><input class="field" type="text" name="start_unload_u1" value=""></td>
                <td><input type="checkbox" name="start_unload_u1_all" value="1" onClick="document.traderoute_form.start_unload_u1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].':</td>
                <td><input class="field" type="text" name="start_unload_u2" value=""></td>
                <td><input type="checkbox" name="start_unload_u2_all" value="1" onClick="document.traderoute_form.start_unload_u2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].':</td>
                <td><input class="field" type="text" name="start_unload_u3" value=""></td>
                <td><input type="checkbox" name="start_unload_u3_all" value="1" onClick="document.traderoute_form.start_unload_u3.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].':</td>
                <td><input class="field" type="text" name="start_unload_u4" value=""></td>
                <td><input type="checkbox" name="start_unload_u4_all" value="1" onClick="document.traderoute_form.start_unload_u4.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].':</td>
                <td><input class="field" type="text" name="start_unload_u5" value=""></td>
                <td><input type="checkbox" name="start_unload_u5_all" value="1" onClick="document.traderoute_form.start_unload_u5.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].':</td>
                <td><input class="field" type="text" name="start_unload_u6" value=""></td>
                <td><input type="checkbox" name="start_unload_u6_all" value="1" onClick="document.traderoute_form.start_unload_u6.disabled = this.checked;"></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="440" align="center" border="0" cellpadding="0" cellspacing="0"><tr><td width="220">
      </td>
      <td width="220" valign="middle">
        <input class="button" type="button" value="'.constant($game->sprache("TEXT27")).'" onClick="return window.history.back();">&nbsp;&nbsp;
        <input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT28")).'">
      </td></tr></table>
    </td>
  </tr>
  </form>
</table>
      ');
    break;

    case 'dest_setup':
        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="traderoute_form" method="post" action="'.parse_link('a=ship_traderoute').'" onSubmit="return document.send_form.submit.disabled = true;">
  <input type="hidden" name="dest" value="'.$dest.'">
  <input type="hidden" name="fleets[0]" value="'.$fleet_id.'">
  <input type="hidden" name="step" value="summary">
  <input type="hidden" name="move_time" value="'.$_POST['move_time'].'">
  <input type="hidden" name="start_setup_post" value="'.base64_encode(gzcompress(serialize($_POST), 9)).'">
  <input type="hidden" name="n_run" value="'.$_POST['n_run'].'">
  <input type="hidden" name="do_report" value="'.$_POST['do_report'].'">
  <tr>
    <td>
      '.constant($game->sprache("TEXT12")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($start)).'"><b>'.$start_planet['planet_name'].'</b></a> ('.$game->get_sector_name($start_planet['sector_id']).':'.$game->get_system_cname($start_planet['system_x'], $start_planet['system_y']).':'.($start_planet['planet_distance_id'] + 1).')'.( ($start_planet['user_id'] != $game->player['user_id']) ? constant($game->sprache("TEXT13")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$start_planet['user_id']).'"><b>'.$start_planet['user_name'].'</b></a>' : '' ).'<br>
      '.constant($game->sprache("TEXT14")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($dest)).'"><b>'.$dest_planet['planet_name'].'</b></a> ('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')'.( ($dest_planet['user_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$dest_planet['user_id']).'"><b>'.$dest_planet['user_name'].'</b></a>' : '' ).'<br><br>      Flotte: <a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'"><b>'.$fleet['fleet_name'].'</b></a><br><br>
      '.constant($game->sprache("TEXT16")).'<b>'.($fleet['n_ships'] * MAX_TRANSPORT_RESOURCES).' '.constant($game->sprache("TEXT17")).($fleet['n_ships'] * MAX_TRANSPORT_UNITS).constant($game->sprache("TEXT18")).'</b><br><br>
      <b>'.constant($game->sprache("TEXT29")).'</b><br><br>
      <table border="0">
        <tr>
          <td width="10">&nbsp;</td>
          <td>
            <table border="0">
              <tr>
                <td colspan="2"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                <td>'.constant($game->sprache("TEXT21")).'</td>
              </tr>
              <tr>
                <td width="80">'.constant($game->sprache("TEXT22")).'</td>
                <td width="160"><input class="field" type="text" name="dest_load_r1" value=""></td>
                <td><input type="checkbox" name="dest_load_r1_all" value="1" onClick="document.traderoute_form.dest_load_r1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT23")).'</td>
                <td><input class="field" type="text" name="dest_load_r2" value=""></td>
                <td><input type="checkbox" name="dest_load_r2_all" value="1" onClick="document.traderoute_form.dest_load_r2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT24")).'</td>
                <td><input class="field" type="text" name="dest_load_r3" value=""></td>
                <td><input type="checkbox" name="dest_load_r3_all" value="1" onClick="document.traderoute_form.dest_load_r3.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.constant($game->sprache("TEXT25")).'</td>
                <td><input class="field" type="text" name="dest_load_r4" value=""></td>
                <td><input type="checkbox" name="dest_load_r4_all" value="1" onClick="document.traderoute_form.dest_load_r4.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].':</td>
                <td><input class="field" type="text" name="dest_load_u1" value=""></td>
                <td><input type="checkbox" name="dest_load_u1_all" value="1" onClick="document.traderoute_form.dest_load_u1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].':</td>
                <td><input class="field" type="text" name="dest_load_u2" value=""></td>
                <td><input type="checkbox" name="dest_load_u2_all" value="1" onClick="document.traderoute_form.dest_load_u2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].':</td>
                <td><input class="field" type="text" name="dest_load_u3" value=""></td>
                <td><input type="checkbox" name="dest_load_u3_all" value="1" onClick="document.traderoute_form.dest_load_u3.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].':</td>
                <td><input class="field" type="text" name="dest_load_u4" value=""></td>
                <td><input type="checkbox" name="dest_load_u4_all" value="1" onClick="document.traderoute_form.dest_load_u4.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].':</td>
                <td><input class="field" type="text" name="dest_load_u5" value=""></td>
                <td><input type="checkbox" name="dest_load_u5_all" value="1" onClick="document.traderoute_form.dest_load_u5.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].':</td>
                <td><input class="field" type="text" name="dest_load_u6" value=""></td>
                <td><input type="checkbox" name="dest_load_u6_all" value="1" onClick="document.traderoute_form.dest_load_u6.disabled = this.checked;"></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td height="15"></td></tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td>
            <table border="0">
              <tr>
                <td colspan="3"><b>'.constant($game->sprache("TEXT26")).'</b></td>
              </tr>
              <tr>
                <td width="80">'.constant($game->sprache("TEXT22")).'</td>
                <td width="160"><input class="field" type="text" name="dest_unload_r1" value=""></td>
                <td><input type="checkbox" name="dest_unload_r1_all" value="1" onClick="document.traderoute_form.dest_unload_r1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT23")).'</td>
                <td><input class="field" type="text" name="dest_unload_r2" value=""></td>
                <td><input type="checkbox" name="dest_unload_r2_all" value="1" onClick="document.traderoute_form.dest_unload_r2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.constant($game->sprache("TEXT24")).'</td>
                <td><input class="field" type="text" name="dest_unload_r3" value=""></td>
                <td><input type="checkbox" name="dest_unload_r3_all" value="1" onClick="document.traderoute_form.dest_unload_r3.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.constant($game->sprache("TEXT25")).'</td>
                <td><input class="field" type="text" name="dest_unload_r4" value=""></td>
                <td><input type="checkbox" name="dest_unload_r4_all" value="1" onClick="document.traderoute_form.dest_unload_r4.disabled = this.checked;"></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].':</td>
                <td><input class="field" type="text" name="dest_unload_u1" value=""></td>
                <td><input type="checkbox" name="dest_unload_u1_all" value="1" onClick="document.traderoute_form.dest_unload_u1.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].':</td>
                <td><input class="field" type="text" name="dest_unload_u2" value=""></td>
                <td><input type="checkbox" name="dest_unload_u2_all" value="1" onClick="document.traderoute_form.dest_unload_u2.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].':</td>
                <td><input class="field" type="text" name="dest_unload_u3" value=""></td>
                <td><input type="checkbox" name="dest_unload_u3_all" value="1" onClick="document.traderoute_form.dest_unload_u3.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].':</td>
                <td><input class="field" type="text" name="dest_unload_u4" value=""></td>
                <td><input type="checkbox" name="dest_unload_u4_all" value="1" onClick="document.traderoute_form.dest_unload_u4.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].':</td>
                <td><input class="field" type="text" name="dest_unload_u5" value=""></td>
                <td><input type="checkbox" name="dest_unload_u5_all" value="1" onClick="document.traderoute_form.dest_unload_u5.disabled = this.checked;"></td>
              </tr>
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].':</td>
                <td><input class="field" type="text" name="dest_unload_u6" value=""></td>
                <td><input type="checkbox" name="dest_unload_u6_all" value="1" onClick="document.traderoute_form.dest_unload_u6.disabled = this.checked;"></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="440" align="center" border="0" cellpadding="0" cellspacing="0"><tr><td width="220">
      </td>
      <td width="220" valign="middle">
        <input class="button" type="button" value="'.constant($game->sprache("TEXT27")).'" onClick="return window.history.back();">&nbsp;&nbsp;
        <input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT28")).'">
      </td></tr></table>
    </td>
  </tr>
  </form>
</table>
      ');
    break;

    case 'basic_setup':
    default:
        if($game->player['user_auth_level'] == STGC_DEVELOPER) {
            $min_time = 1;
            $max_speed_str = 'Warp 10/Transwarp';
        }
        elseif($inter_planet) {
            $min_time = 6;
            $max_speed_str = constant($game->sprache("TEXT30"));
        }
        else {
            include_once('include/libs/moves.php');

            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION) );

            $max_speed_str = 'Warp '.round($max_warp_speed, 2);
        }

        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="traderoute_form" method="post" action="'.parse_link('a=ship_traderoute').'" onSubmit="return document.send_form.submit.disabled = true;">
  <input type="hidden" name="dest" value="'.$dest.'">
  <input type="hidden" name="fleets[0]" value="'.$fleet_id.'">
  <input type="hidden" name="step" value="start_setup">
  <tr>
    <td>
      '.constant($game->sprache("TEXT12")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($start)).'"><b>'.$start_planet['planet_name'].'</b></a> ('.$game->get_sector_name($start_planet['sector_id']).':'.$game->get_system_cname($start_planet['system_x'], $start_planet['system_y']).':'.($start_planet['planet_distance_id'] + 1).')'.( ($start_planet['user_id'] != $game->player['user_id']) ? constant($game->sprache("TEXT13")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$start_planet['user_id']).'"><b>'.$start_planet['user_name'].'</b></a>' : '' ).'<br>
      '.constant($game->sprache("TEXT14")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($dest)).'"><b>'.$dest_planet['planet_name'].'</b></a> ('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')'.( ($dest_planet['user_id'] != $game->player['user_id']) ? constant($game->sprache("TEXT13")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$dest_planet['user_id']).'"><b>'.$dest_planet['user_name'].'</b></a>' : '' ).'<br><br>
      '.constant($game->sprache("TEXT15")).'<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'"><b>'.$fleet['fleet_name'].'</b></a><br><br>
      '.constant($game->sprache("TEXT31")).'<b>'.$max_speed_str.'</b><br>
      '.constant($game->sprache("TEXT32")).'<b>'.$min_time.' Ticks</b><br><br>
      '.constant($game->sprache("TEXT33")).'<input class="field" style="width: 40px;" type="text" name="move_time" value="'.$min_time.'"> <i>+</i>&nbsp;<i id="timer2" title="time1_'.$NEXT_TICK.'_type1_4">&nbsp;</i><br><br>
      '.constant($game->sprache("TEXT34")).'<br>
      <input type="radio" name="n_run" checked="checked" value="one">'.constant($game->sprache("TEXT35")).'<br>
      <input type="radio" name="n_run" value="many">'.constant($game->sprache("TEXT36")).'<br><br>
      '.constant($game->sprache("TEXT37")).'<br>
      <input type="radio" name="do_report" checked="checked" value="yes">'.constant($game->sprache("TEXT38")).'<br>
      <input type="radio" name="do_report" value="no">'.constant($game->sprache("TEXT39")).'<br><br><br>
      <table width="440" align="center" border="0" cellpadding="0" cellspacing="0"><tr><td width="220">
       </td>
       <td width="220" valign="middle">
        <input class="button" type="button" value="'.constant($game->sprache("TEXT27")).'" onClick="return window.history.back();">&nbsp;&nbsp;
        <input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT28")).'">
       </td></tr></table>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
}

?>
