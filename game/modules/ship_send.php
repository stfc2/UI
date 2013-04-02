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


// #############################################################################
// Fleets must be selected for ship_send

if(empty($_POST['fleets'])) {
    message(NOTICE, constant($game->sprache("TEXT1")));
}


// #############################################################################
// The fleets IDs "pure" (cast to integer against SQL exploits)

$fleet_ids = array();

for($i = 0; $i < count($_POST['fleets']); ++$i) {
    $_temp = (int)$_POST['fleets'][$i];

    if(!empty($_temp)) {
        $fleet_ids[] = $_temp;
    }
}


// #############################################################################
// Was a valid ID fleets this?

if(empty($fleet_ids)) {
    message(NOTICE, constant($game->sprache("TEXT2")));
}

$sql = 'SELECT *
        FROM ship_fleets
        WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

if(!$q_fleets = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query fleet data');
}

$fleets = array($db->fetchrow($q_fleets));
$fleet_ids = array($fleets[0]['fleet_id']);

if(empty($fleets[0])) {
    message(NOTICE, constant($game->sprache("TEXT3")));
}

$start = (int)$fleets[0]['planet_id'];

if($start == 0) {
    message(NOTICE, constant($game->sprache("TEXT4")));
}

while($_temp = $db->fetchrow($q_fleets)) {
    if($_temp['planet_id'] == $start) {
        $fleet_ids[] = $_temp['fleet_id'];
        $fleets[] = $_temp;
    }
}

$n_fleets = count($fleets);

if($n_fleets == 0) {
    message(NOTICE, constant($game->sprache("TEXT5")));
}

// #############################################################################
// Search target

if(!empty($_POST['dest_coord'])) {
    $coord_pieces = explode(':', $_POST['dest_coord']);
    $n_pieces = count($coord_pieces);
    
    if($n_pieces != 3) {
        message(NOTICE, constant($game->sprache("TEXT6")));
    }

    $sector_id = $game->get_sector_id($coord_pieces[0]);

    $letters = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18);
    $numbers = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18);

    if(!isset($letters[$coord_pieces[1][0]])) {
        message(NOTICE, constant($game->sprache("TEXT7")), $coord_pieces[1][0].' '.constant($game->sprache("TEXT8")));
    }

    $system_y = $letters[$coord_pieces[1][0]];

    if(!isset($numbers[$coord_pieces[1][1]])) {
        message(NOTICE, constant($game->sprache("TEXT9")), $coord_pieces[1][1].' '.constant($game->sprache("TEXT10")));
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
        message(NOTICE, constant($game->sprache("TEXT11")).' <b>'.$_POST['dest_coord'].'</b>');
    }

    $dest = (int)$planet['planet_id'];
}
else {
    if(!empty($_POST['dest'])) {
        $dest = (is_numeric($_POST['dest'])) ? (int)$_POST['dest'] : decode_planet_id($_POST['dest']);
    }
}

if(empty($dest)) {
    message(NOTICE, constant($game->sprache("TEXT12")));
}


// #############################################################################
// Fetch start planet data

if($start == $game->planet['planet_id']) {
    $start_planet = $game->planet;

    $start_planet['user_id'] = $game->player['user_id'];
    $start_planet['user_name'] = $game->player['user_name'];
    $start_planet['user_attack_protection'] = $game->player['user_attack_protection'];
    $start_planet['user_vacation_start'] = $game->player['user_vacation_start'];
    $start_planet['user_vacation_end'] = $game->player['user_vacation_end'];

    // Player data can not be fetched, because they are not displayed / used
}
else {
    $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                   u.user_id, u.user_name, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
            FROM (planets p, starsystems s)
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE p.planet_id = '.$start.' AND
                  s.system_id = p.system_id';

    if(($start_planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query start planet data');
    }

    if(empty($start_planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT13")));
    }

    if(empty($start_planet['user_id'])) {
        $start_planet['user_id'] = 0;
        $start_planet['user_name'] = '';
        $start_planet['user_attack_protection'] = 0;
        $start_planet['user_vacation_start'] = 0;
        $start_planet['user_vacation_end'] = 0;
    }
}



// #############################################################################
// Fetch target planet data

if($dest == $game->planet['planet_id']) {
    $dest_planet = $game->planet;

    $dest_planet['user_id'] = $game->player['user_id'];
    $dest_planet['user_name'] = $game->player['user_name'];
    $dest_planet['user_attack_protection'] = $game->player['user_attack_protection'];
    $dest_planet['user_vacation_start'] = $game->player['user_vacation_start'];
    $dest_planet['user_vacation_end'] = $game->player['user_vacation_end'];
    $dest_planet['system_is_visible'] = true;
    $dest_planet['enemy_planet'] = false;

    // Player data can not be fetched, because they are not displayed / used
}
else {
    $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                   u.user_id, u.user_name, u.user_race, u.user_alliance, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
            FROM (planets p, starsystems s)
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE p.planet_id = '.$dest.' AND
                  s.system_id = p.system_id';

    if(($dest_planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query destination planet data');
    }

    if(empty($dest_planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT14")));
    }

    if(empty($dest_planet['user_id'])) {
        $dest_planet['user_id'] = 0;
        $dest_planet['user_name'] = '';
        $dest_planet['user_attack_protection'] = 0;
        $dest_planet['user_vacation_start'] = 0;
        $dest_planet['user_vacation_end'] = 0;
    }

    $dest_planet['system_is_visible'] = false;
    if(($game->player['user_alliance'] != 0) && ($game->player['user_alliance_rights3'] == 1))
    	$sql = 'SELECT COUNT(*) AS system_is_visible FROM planet_details WHERE log_code = 500 AND system_id = '.$dest_planet['system_id'].' AND alliance_id = '.$game->player['user_alliance'];
    else
    	$sql = 'SELECT COUNT(*) AS system_is_visible FROM planet_details WHERE log_code = 500 AND system_id = '.$dest_planet['system_id'].' AND user_id = '.$game->player['user_id'];
    
    if(($_temp = $db->queryrow($sql)) == true) {
        if($_temp['system_is_visible'] > 0 || ($game->player['user_auth_level'] == STGC_DEVELOPER)) $dest_planet['system_is_visible'] = true;
    }
    else {
       message(DATABASE_ERROR, 'Could not query destination planet details data');
    }
    
    // Really easy setup for G2: if user_alliance does not match, they are at war :)
    $dest_planet['enemy_planet'] = false;
    if(!empty($dest_planet['user_id']) && ($dest_planet['user_alliance'] != 0) && ($game->player['user_alliance'] != $dest_planet['user_alliance']))
    	$dest_planet['enemy_planet'] = true;
    
}


// #############################################################################
// Inter-orbital flight is not possible, as originally planned,
// which will be resolved separately
 
if($start == $dest) {
    message(NOTICE, constant($game->sprache("TEXT15")));
}


// #############################################################################
// When vacation mode is activated immediately cancel

if( ($dest_planet['user_vacation_start'] <= $ACTUAL_TICK) && ($dest_planet['user_vacation_end'] > $ACTUAL_TICK) ) {
    message(NOTICE, constant($game->sprache("TEXT16")));
}


// #############################################################################
// Which ship's classes fly also?
// (for warp speed + command possibilities)

$sql = 'SELECT st.ship_torso, st.value_10 AS warp_speed
        FROM (ships s, ship_templates st)
        WHERE s.fleet_id IN ('.implode(',', $fleet_ids).') AND
              st.id = s.template_id';

if(!$q_stpls = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query ship template data');
}

$in_scout = $in_transporter = $in_colo = $in_orb = $in_other_torso = false;
$max_warp_speed = 9.99; // not interested in precision

while($_temp = $db->fetchrow($q_stpls)) {
    if($_temp['warp_speed'] < $max_warp_speed) $max_warp_speed = $_temp['warp_speed'];

    if($_temp['ship_torso'] == SHIP_TYPE_SCOUT) {
        $in_scout = true;
        continue;
    }

    if($_temp['ship_torso'] == SHIP_TYPE_TRANSPORTER) {
        $in_transporter = true;
        continue;
    }

    if($_temp['ship_torso'] == SHIP_TYPE_COLO) {
        $in_colo = true;
        continue;
    }

    if($_temp['ship_torso'] == SHIP_TYPE_ORB) {
        $in_orb = true;
        continue;
    }

    $in_other_torso = true;
}

$sql = 'SELECT n_ships AS ship_count'
        . ' FROM ship_fleets'
        . ' WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

if(!$q_snbr = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query ship template data');
}

while($_temp = $db->fetchrow($q_snbr)) {
	$ship_number += $_temp['ship_count'];
	$explore_fleet = ($ship_number == 1) ? true : false;
}

// #############################################################################
// A few settings set

$free_planet = ($dest_planet['user_id'] == 0) ? true : false;
$own_planet = ($game->player['user_id'] == $dest_planet['user_id']) ? true : false;
$planet_not_visible = ($dest_planet['system_is_visible']) ? false : true;

$starter_atkptc = ($game->player['user_attack_protection'] > $ACTUAL_TICK) ? true : false;
$dest_atkptc = ($dest_planet['user_attack_protection'] > $ACTUAL_TICK) ? true : false;

$atkptc_present = ($starter_atkptc || $dest_atkptc) ? true : false;

$inter_planet = $inter_system = false;

if($start_planet['system_id'] == $dest_planet['system_id']) $inter_planet = true;
else $inter_system = true;

if($in_orb){
  message(NOTICE, constant($game->sprache("TEXT17")));
}

if($starter_atkptc && $free_planet) {
    message(NOTICE, constant($game->sprache("TEXT18")));
}


$know_dest_str = ' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($dest)).'"><b>'.$dest_planet['planet_name'].'</b></a> ('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')'.( ($dest_planet['user_id'] != $game->player['user_id']) ? ' '.constant($game->sprache("TEXT26")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$dest_planet['user_id']).'"><b>'.$dest_planet['user_name'].'</b></a>' : '' );
$unknow_dest_str = ' <b><i>&#171;'.constant($game->sprache("TEXT68")).'&#187;</i></b>'.'('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')';
$dest_str = $dest_planet['system_is_visible'] ? $know_dest_str : $unknow_dest_str;

$step = (!empty($_POST['step'])) ? $_POST['step'] : 'basic_setup';

switch($step) {
    case 'stationate_exec':
    case 'comeback_exec':
    case 'attack_normal_exec':
    case 'attack_comeback_exec':
    //case 'surrender_exec':
    case 'transport_exec':
    case 'spy_exec':
    case 'survey_normal_exec':
    case 'survey_recon_exec':
    case 'colo_exec':
        $distance = $velocity = 0;

        if($game->player['user_auth_level'] == STGC_DEVELOPER) $min_time = 1;
        elseif($inter_planet) $min_time = 6;
        else {
            include_once('include/libs/moves.php');

            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION ) );
        }

        $cur_istardate = (int)str_replace('.', '', $game->config['stardate']);
        $min_istardate = $cur_istardate + $min_time;
        $des_istardate = (int)$_POST['arrival'];

        if($des_istardate < $min_istardate) {
            message(NOTICE, constant($game->sprache("TEXT19")).' '.($game->config['stardate'] + ($min_time / 10)));
        }

        $move_time = $des_istardate - $cur_istardate;

        $sql = 'SELECT COUNT(ship_id) AS n_ships
                FROM ships
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

        if(($_nships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query real n_ships data');
        }

        $n_ships = $_nships['n_ships'];

        if($n_ships == 0) {
            message(GENERAL, constant($game->sprache("TEXT20")), 'Unexspected: $n_ships = 0');
        }

        $action = (!empty($_POST['action'])) ? $_POST['action'] : 'stationate';

        $action_code = 0;
        $action_data = "";

        switch($step) {
            case 'stationate_exec':
                if($atkptc_present && !$own_planet) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                $action_code = ($dest_planet['user_id'] != $game->player['user_id']) ? 21: 11;
            break;

            case 'comeback_exec':
                if(!$own_planet) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                $action_code = 14;
            break;

            case 'attack_normal_exec':
                if($own_planet || $free_planet || $atkptc_present) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }
                if($game->SITTING_MODE) {
                    message(NOTICE, constant($game->sprache("TEXT22")));
                }

                $action_code = 41;
            break;

            case 'attack_comeback_exec':
                if($own_planet || $free_planet || $atkptc_present) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                $action_code = 42;
            break;

            case 'surrender_exec':
                if($game->player['user_id']>10){
                  message(NOTICE, constant($game->sprache("TEXT23")));
                }
                if($own_planet || $free_planet || $atkptc_present) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                $action_code = 23;
            break;

            case 'transport_exec':
                if($own_planet || $free_planet || !$in_transporter) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                if($game->player['user_id'] != $dest_planet['user_id']) {
                   message(NOTICE, constant($game->sprache("TEXT24")));
                }

                $action_code = 31;
            break;

            case 'spy_exec':
                if(!$in_scout || $in_other_torso || $in_transporter || $in_colo) {
                    message(NOTICE, constant($game->sprache("TEXT25")));
                }

                $action_code = 22;
            break;

            case 'survey_normal_exec':
                if(explore_fleet == false) {
                    message(NOTICE, constant($game->sprache("TEXT25")));
                }

                $action_code = 26;
            break;
            
            case 'survey_recon_exec':
                if(explore_fleet == false) {
                    message(NOTICE, constant($game->sprache("TEXT25")));
                }
					
                $action_data = serialize(array('is_recon_mission' => true, 'target_owner' => $dest_planet['user_id'], 'target_race' => $dest_planet['user_race'], 'target_alliance' => $dest_planet['user_alliance']));
                $action_code = 26;
            break;
            

            case 'colo_exec':
                if(!$in_colo || !$free_planet) {
                    message(NOTICE, constant($game->sprache("TEXT21")));
                }

                if($game->SITTING_MODE) {
                    message(NOTICE, constant($game->sprache("TEXT22")));
                }

                if(empty($_POST['ship_id'])) {
                    message(GENERAL, constant($game->sprache("TEXT27")), '$_POST[\'ship_id\'] = empty');
                }

                $action_code = 24;
                $action_data = serialize(array((int)$_POST['ship_id']));
            break;
        }

        $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
                VALUES ('.$game->player['user_id'].', 0, 0, '.$start.', '.$dest.', '.$distance.', '.$distance.', '.($velocity * TICK_DURATION).', '.$ACTUAL_TICK.', '.($ACTUAL_TICK + $move_time).', '.$n_ships.', '.$action_code.', "'.$action_data.'")';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }

        $new_move_id = $db->insert_id();

        $sql = 'UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.'
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets position data');
        }

        redirect('a=tactical_moves&dest='.$dest);
    break;

    case 'stationate_setup':
    case 'comeback_setup':
    case 'attack_setup':
    //case 'surrender_setup':
    case 'transport_setup':
    case 'spy_setup':
    case 'survey_setup':
    case 'colo_setup':
        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_send').'" onSubmit="return document.send_form.submit.disabled = true;">
  <input type="hidden" name="dest" value="'.encode_planet_id($dest).'">
  <input type="hidden" name="arrival" value="'.( (int)$_POST['higher_arrival_stardate'].$_POST['lower_arrival_stardate']).'">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $game->out('
  <tr>
    <td>
      '.constant($game->sprache("TEXT28")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($start)).'"><b>'.$start_planet['planet_name'].'</b></a> ('.$game->get_sector_name($start_planet['sector_id']).':'.$game->get_system_cname($start_planet['system_x'], $start_planet['system_y']).':'.($start_planet['planet_distance_id'] + 1).')'.( ($start_planet['user_id'] != $game->player['user_id']) ? ' '.constant($game->sprache("TEXT26")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$start_planet['user_id']).'"><b>'.$start_planet['user_name'].'</b></a>' : '' ).'<br>
      '.constant($game->sprache("TEXT29")).$dest_str.'<br><br>
      '.constant($game->sprache("TEXT30")).' <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      '.constant($game->sprache("TEXT31")).' <b>'.($_POST['higher_arrival_stardate'].'.'.$_POST['lower_arrival_stardate']).'</b><br><br>
        ');

        switch($step) {
            case 'stationate_setup':
                $game->out(constant($game->sprache("TEXT32")).'<br><input type="hidden" name="step" value="stationate_exec">');
            break;

            case 'comeback_setup':
                $game->out(constant($game->sprache("TEXT33")).'<br><input type="hidden" name="step" value="comeback_exec">');
            break;

            case 'attack_setup':
                if($game->SITTING_MODE) {
                    message(NOTICE, constant($game->sprache("TEXT22")));
                }
                $game->out(constant($game->sprache("TEXT34")).'<br><br>
      <input type="radio" name="step" value="attack_normal_exec" checked="checked" onClick="return document.send_form.submit.value = \''.constant($game->sprache("TEXT35")).'\';">&nbsp;<b>'.constant($game->sprache("TEXT36")).'</b><br>
      <input type="radio" name="step" value="attack_comeback_exec" onClick="return document.send_form.submit.value = \''.constant($game->sprache("TEXT35")).'\';">&nbsp;<b>'.constant($game->sprache("TEXT37")).'</b><br><br>
                ');
            break;

            case 'transport_setup':
                $game->out(constant($game->sprache("TEXT38")).'<br><input type="hidden" name="step" value="transport_exec">');
            break;

            case 'spy_setup':
                if(!$in_scout || $in_other_torso || $in_transporter || $in_colo) {
                    message(NOTICE, constant($game->sprache("TEXT25")));
                }

                $game->out(constant($game->sprache("TEXT39")).'<br><input type="hidden" name="step" value="spy_exec">');
            break;

            case 'survey_setup':
                $game->out(constant($game->sprache("TEXT67")).'<br>');
                if($game->player['user_auth_level'] == STGC_DEVELOPER) {
	                if($planet_not_visible == false && $dest_planet['enemy_planet'] == true){
		                $game->out('<br>'.constant($game->sprache("TEXT69")).'<br>
		                <input type="radio" name="step" value="survey_normal_exec" checked="checked" onClick="return document.send_form.submit.value = \''.constant($game->sprache("TEXT35")).'\';">&nbsp;'.constant($game->sprache("TEXT70")).'<br>
		                <input type="radio" name="step" value="survey_recon_exec" onClick="return document.send_form.submit.value = \''.constant($game->sprache("TEXT35")).'\';">&nbsp;'.constant($game->sprache("TEXT71")).'<br>
		                ');
		            }
	               
                }
                $game->out('<input type="hidden" name="step" value="survey_normal_exec">');
            break;

            case 'colo_setup':
                if($game->SITTING_MODE) {
                    message(NOTICE, constant($game->sprache("TEXT22")));
                }
                $sql = 'SELECT s.ship_id, s.hitpoints, s.experience, s.unit_1, s.unit_2, s.unit_3, s.unit_4,
                               st.name, st.value_5 AS max_hitpoints
                        FROM (ships s, ship_templates st)
                        WHERE s.fleet_id IN ('.implode(',', $fleet_ids).') AND
                              st.id = s.template_id AND
                              st.ship_torso = '.SHIP_TYPE_COLO;

                if(!$q_cships = $db->query($sql)) {
                    message(DATABASE_ERROR, 'Could not query colonisation ship data');
                }

                $first_cship = $db->fetchrow($q_cships);

                if(empty($first_cship['ship_id'])) {
                    message(GENERAL, 'Unexspected: Second try to find colo ship failed', '$first_cship[\'ship_id\'] = empty');
                }

                $game->out(constant($game->sprache("TEXT40")).'<br><br>

      <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="20" align="right"><input type="radio" name="ship_id" value="'.$first_cship['ship_id'].'" checked="checked"></td>
          <td width="350" align="left"><b>'.$first_cship['name'].'</b> ('.$first_cship['hitpoints'].'/'.$first_cship['max_hitpoints'].', Exp: '.$first_cship['experience'].')<br>'.constant($game->sprache("TEXT41")).' '.$first_cship['unit_1'].'/'.$first_cship['unit_2'].'/'.$first_cship['unit_3'].'/'.$first_cship['unit_4'].'</td>
        </tr>
                ');

                while($cship = $db->fetchrow($q_cships)) {
                    $game->out('
        <tr>
          <td align="right"><input type="radio" name="ship_id" value="'.$cship['ship_id'].'"></td>
          <td align="left"><b>'.$cship['name'].'</b> ('.$cship['hitpoints'].'/'.$cship['max_hitpoints'].', Exp: '.$cship['experience'].')<br>'.constant($game->sprache("TEXT41")).' '.$cship['unit_1'].'/'.$cship['unit_2'].'/'.$cship['unit_3'].'/'.$cship['unit_4'].'</td>
        </tr>
                    ');
                }

                $game->out('</table><br><input type="hidden" name="step" value="colo_exec">');
            break;
        }

        if($in_transporter) {
            $resource_1 = $resource_2 = $resource_3 = $resource_4 = $unit_1 = $unit_2 = $unit_3 = $unit_4 = $unit_5 = $unit_6 = 0;

            for($i = 0; $i < $n_fleets; ++$i) {
                $resource_1 += $fleets[$i]['resource_1'];
                $resource_2 += $fleets[$i]['resource_2'];
                $resource_3 += $fleets[$i]['resource_3'];
                $resource_4 += $fleets[$i]['resource_4'];

                $unit_1 += $fleets[$i]['unit_1'];
                $unit_2 += $fleets[$i]['unit_2'];
                $unit_3 += $fleets[$i]['unit_3'];
                $unit_4 += $fleets[$i]['unit_4'];
                $unit_5 += $fleets[$i]['unit_5'];
                $unit_6 += $fleets[$i]['unit_6'];
            }

            $n_resources = $resource_1 + $resource_2 + $resource_3 + $resource_4;
            $n_units = $unit_1 + $unit_2 + $unit_3 + $unit_4 + $unit_5 + $unit_6;

            if($n_resources > 0) {
                if($resource_1 > 0) $game->out('<br>'.constant($game->sprache("TEXT42")).' <b>'.$resource_1.'</b>');
                if($resource_2 > 0) $game->out('<br>'.constant($game->sprache("TEXT43")).' <b>'.$resource_2.'</b>');
                if($resource_3 > 0) $game->out('<br>'.constant($game->sprache("TEXT44")).' <b>'.$resource_3.'</b>');
                if($resource_4 > 0) $game->out('<br>'.constant($game->sprache("TEXT45")).' <b>'.$resource_4.'</b>');
                $game->out('<br>');
            }

            if($n_units > 0) {
                if($unit_1 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$unit_1.'</b>');
                if($unit_2 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$unit_2.'</b>');
                if($unit_3 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$unit_3.'</b>');
                if($unit_4 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$unit_4.'</b>');
                if($unit_5 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$unit_5.'</b>');
                if($unit_6 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$unit_6.'</b>');
                $game->out('<br>');
            }
        }

        $game->out('
      <br>
      <center><input class="button" type="button" name="cancel" value="'.constant($game->sprache("TEXT46")).'" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT35")).'"></center>
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
            $max_speed_str = constant($game->sprache("TEXT47"));
        }
        elseif($inter_planet) {
            $min_time = 6;
            $max_speed_str = constant($game->sprache("TEXT48"));
        }
        else {
            include_once('include/libs/moves.php');

            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION) );

            $max_speed_str = constant($game->sprache("TEXT49")).' '.round($max_warp_speed, 2);
        }

        $min_stardate = sprintf('%.1f', ($game->config['stardate'] + ($min_time / 10)));
        $min_stardate_split = explode('.', (string)$min_stardate);
        $min_stardate_int = str_replace('.', '', $min_stardate);

        $game->out('
<script type="text/javascript" language="JavaScript">
<!--
function increment_arrival() {
    if(parseInt(document.send_form.lower_arrival_stardate.value) < 9) {
        document.send_form.lower_arrival_stardate.value++;
    }
    else {
        document.send_form.lower_arrival_stardate.value = \'0\';
        document.send_form.higher_arrival_stardate.value++;
    }

    return update_times();
}

function decrement_arrival() {
    if(parseInt(document.send_form.lower_arrival_stardate.value) > 0) {
        document.send_form.lower_arrival_stardate.value--;
    }
    else {
        document.send_form.lower_arrival_stardate.value = \'9\';
        document.send_form.higher_arrival_stardate.value--;
    }

    return update_times();
}

function update_times() {
    if(isNaN(document.send_form.higher_arrival_stardate.value)) {
        alert(\''.constant($game->sprache("TEXT50")).'\');

        document.send_form.higher_arrival_stardate.value = \''.$min_stardate_split[0].'\';
        document.send_form.lower_arrival_stardate.value = \''.$min_stardate_split[1].'\';
    }

    var int_stardate = parseInt(document.send_form.higher_arrival_stardate.value + document.send_form.lower_arrival_stardate.value);

    if(int_stardate < '.$min_stardate_int.') {
        alert(\''.constant($game->sprache("TEXT19")).' '.$min_stardate.'\');

        document.send_form.higher_arrival_stardate.value = \''.$min_stardate_split[0].'\';
        document.send_form.lower_arrival_stardate.value = \''.$min_stardate_split[1].'\';

        int_stardate = '.$min_stardate_int.';
    }

    var arrival_minutes = (int_stardate - '.(int)str_replace('.', '', $game->config['stardate']).') * '.TICK_DURATION.';
    var arrival_hours = 0;
    var arrival_days = Math.floor(arrival_minutes / 1440);

    arrival_minutes -= arrival_days * 1440;

    while(arrival_minutes > 59) {
        arrival_hours++;
        arrival_minutes -= 60;
    }

    document.send_form.arrival_days.value = arrival_days;
    document.send_form.arrival_hours.value = arrival_hours;
    document.send_form.arrival_minutes.value = arrival_minutes;

    return true;
}
//-->
</script>

<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_send').'">
  <input type="hidden" name="dest" value="'.encode_planet_id($dest).'">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $game->out('
  <tr>
    <td>
      '.constant($game->sprache("TEXT28")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($start)).'"><b>'.$start_planet['planet_name'].'</b></a> ('.$game->get_sector_name($start_planet['sector_id']).':'.$game->get_system_cname($start_planet['system_x'], $start_planet['system_y']).':'.($start_planet['planet_distance_id'] + 1).')'.( ($start_planet['user_id'] != $game->player['user_id']) ? ' '.constant($game->sprache("TEXT26")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$start_planet['user_id']).'"><b>'.$start_planet['user_name'].'</b></a>' : '' ).'<br>
        ');

        if($free_planet) {
            $game->out(constant($game->sprache("TEXT29")).' <i>'.constant($game->sprache("TEXT51")).'</i> ('.$game->get_sector_name($dest_planet['sector_id']).':'.$game->get_system_cname($dest_planet['system_x'], $dest_planet['system_y']).':'.($dest_planet['planet_distance_id'] + 1).')<br><br>');
        }
        else {
            $game->out(constant($game->sprache("TEXT29")).$dest_str.'<br><br>');
        }

        $game->out('
      '.constant($game->sprache("TEXT30")).' <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      '.constant($game->sprache("TEXT52")).' <b>'.$max_speed_str.'</b><br>
      '.constant($game->sprache("TEXT53")).' '.$min_stardate.'</b><br><br>
      '.constant($game->sprache("TEXT31")).' <input class="field" style="width: 45px;" type="text" name="higher_arrival_stardate" value="'.$min_stardate_split[0].'" maxlength="5" onBlur="return update_times();">&nbsp;.&nbsp;<input class="field" style="width: 15px;" type="text" name="lower_arrival_stardate" value="'.$min_stardate_split[1].'" maxlength="1" onBlur="return update_times();">&nbsp;&nbsp;<input class="button" style="width: 20px;" type="button" value="+" onClick="return increment_arrival();"">&nbsp;<input class="button" style="width: 20px;" type="button" value="-" onClick="return decrement_arrival();"><br><br>
      '.constant($game->sprache("TEXT54")).' <input class="field" style="width: 25px;" type="text" name="arrival_days" value="" disabled="disabled">&nbsp;<i>'.constant($game->sprache("TEXT55")).'</i>&nbsp;&nbsp;<input class="field" style="width: 25px;" name="arrival_hours" value="" disabled="disabled">&nbsp;<i>'.constant($game->sprache("TEXT56")).'</i>&nbsp;&nbsp;<input class="field" style="width: 25px;" name="arrival_minutes" value="" disabled="disabled">&nbsp;<i>'.constant($game->sprache("TEXT57")).' +</i>&nbsp;<i id="timer2" title="time1_'.$NEXT_TICK.'_type1_4">&nbsp;</i><br><br>

      <table width="440" align="center" border="0" cellpadding="0" cellspacing="0"><tr><td width="220">
        ');
		if($planet_not_visible){
            $game->out('
        <input type="radio" name="step" value="stationate_setup" checked="checked">&nbsp;<b>'.constant($game->sprache("TEXT58")).'</b><br>
        <input type="radio" name="step" value="survey_setup"'.( (!$explore_fleet) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT65")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT65")).'</b><br>').'
        <input type="radio" name="step" value="attack_setup"'.( ($atkptc_present) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT61")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT61")).'</b><br>' ).'
            ');
        }
        elseif($free_planet) {
            // $atkptc_present is not used here, because uninhabited planet
            // Attack protection not to be approached know

            $game->out('
        <input type="radio" name="step" value="stationate_setup" checked="checked">&nbsp;<b>'.constant($game->sprache("TEXT58")).'</b><br>
        <input type="radio" name="step" value="survey_setup"'.( (!$explore_fleet) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT65")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT65")).'</b><br>').'
        <input type="radio" name="step" value="colo_setup"'.( (!$in_colo) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT59")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT59")).'</b><br>' )
            );
        }
        elseif($own_planet) {
            $game->out('
        <input type="radio" name="step" value="stationate_setup" checked="checked">&nbsp;<b>'.constant($game->sprache("TEXT58")).'</b><br>
        <input type="radio" name="step" value="survey_setup"'.( (!$explore_fleet) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT65")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT65")).'</b><br>').'
        <input type="radio" name="step" value="comeback_setup">&nbsp;<b>'.constant($game->sprache("TEXT60")).'</b><br>
            ');
        }
        else {
            $game->out('
        <input type="radio" name="step" value="stationate_setup"'.( ($atkptc_present) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT58")).'<br>' : ' checked="checked">&nbsp;<b>'.constant($game->sprache("TEXT58")).'</b><br>' ).'
        <input type="radio" name="step" value="survey_setup"'.( ($atkptc_present || !$explore_fleet) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT65")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT65")).'</b><br>' ).'
        <input type="radio" name="step" value="attack_setup"'.( ($atkptc_present) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT61")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT61")).'</b><br>' ).'
        <input type="radio" name="step" value="transport_setup"'.( (!$in_transporter) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT62")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT62")).'</b><br>' ).'
        <input type="radio" name="step" value="spy_setup"'.( (!$in_scout || $atkptc_present) ? ' disabled="disabled">&nbsp;'.constant($game->sprache("TEXT63")).'<br>' : '>&nbsp;<b>'.constant($game->sprache("TEXT63")).'</b><br>' ).'
            ');
        }

        $game->out('
      </td>
      <td width="220" valign="middle">
        <input class="button" type="button" value="'.constant($game->sprache("TEXT46")).'" onClick="return window.history.back();">&nbsp;&nbsp;
        <input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT64")).'">
      </td></tr></table>
    </td>
  </tr>
  </form>
</table>

<script type="text/javascript" language="JavaScript">
<!--
update_times();
//-->
</script>
      ');
    break;
}

?>
