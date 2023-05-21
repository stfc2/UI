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

include('include/libs/moves.php');

$game->init_player();

$order_types = ['template', 'torso', 'experience', 'construction_time', 'warp', 'name'];

function display_fleets_map() {
    global $game;

if ($game->option_retr('show_fleets_map')==0)
    $html_code = '<b>[&nbsp;<a href="'.parse_link('a=ship_fleets_display&sfmap=1').'"><i>'.constant($game->sprache("TEXT102")).'</i></a>&nbsp;]</b>';
else
    $html_code = '<b>[&nbsp;<a href="'.parse_link('a=ship_fleets_display&sfmap=0').'"><i>'.constant($game->sprache("TEXT103")).'</i></a>&nbsp;]</b><br><br>
    <a href="userfleets.php?size=6&map" target=_blank><img src="userfleets.php?size=2" border=0></a><br>';

$game->out('
<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="2" class="style_inner"><tr><td align="center">
'.constant($game->sprache("TEXT101")).' '.$html_code.'
</tr><td></table></tr></td></table><br>');

}

function add_note($note_txt) {
    global $game, $db;
    
    $txt_to_write = $note_txt.$game->player['user_notepad'];
    
    $sql = 'UPDATE user SET user_notepad = "'.$db->escape_string($txt_to_write).'" WHERE user_id = '.$game->player['user_id'];
    
    $db->query($sql);
}
$mask_cmd = filter_input(INPUT_POST, 'masksw', FILTER_SANITIZE_NUMBER_INT);
if(isset($mask_cmd) && !empty($mask_cmd) && $mask_cmd == 1) {

    $game->init_player(21);

    $mask_fleet_id = filter_input(INPUT_POST, 'mask_id', FILTER_SANITIZE_NUMBER_INT);

    $sql = 'SELECT fleet_id, user_id, owner_id FROM ship_fleets WHERE fleet_id = '.$mask_fleet_id.' AND move_id = 0 AND owner_id = '.$game->player['user_id'];

    $res = $db->queryrow($sql);

    if(isset($res['fleet_id']) && $res['fleet_id'] == $mask_fleet_id) {

        $status_mask = ($res['user_id'] == UNDISCLOSED_USERID);

        $sql = 'UPDATE ship_fleets SET user_id = '.($status_mask ? $game->player['user_id'] : UNDISCLOSED_USERID).' WHERE fleet_id = '.$mask_fleet_id.' AND owner_id = '.$game->player['user_id'];

        $db->query($sql);
    }

    unset ($mask_cmd, $mask_fleet_id, $status_mask, $res);
}
$tsw_cmd = filter_input(INPUT_POST, 'tswarp', FILTER_SANITIZE_NUMBER_INT);
if($game->player['user_tsw_timeout'] == 0 && isset($tsw_cmd) && !empty($tsw_cmd) && $tsw_cmd == 1){
    
    $game->init_player(20);
    
    $tsfleet = filter_input(INPUT_POST, 'tsfleet', FILTER_SANITIZE_NUMBER_INT);
    
    $ok_fleet = false; 
    
    $sql = 'SELECT ss.move_id, ss.move_begin, ss.move_finish, p.planet_owner 
            FROM (scheduler_shipmovement ss)
            INNER JOIN (ship_fleets sf) USING (move_id) 
            INNER JOIN (planets p) ON (ss.dest = p.planet_id)
            WHERE sf.fleet_id = '.$tsfleet.' AND sf.user_id = '.$game->player['user_id'].' AND ss.move_status = 0 AND ss.action_code IN (11, 13, 21)';
    
    $res = $db->queryrow($sql);
    
    if(isset($res['move_id']) && !empty($res['move_id'])) {
        $check_fleet = $db->queryrow('SELECT COUNT(fleet_id) AS num_fleet FROM ship_fleets WHERE move_id = '.$res['move_id']);
        
        $ok_fleet = (isset($check_fleet['num_fleet']) && $check_fleet['num_fleet'] == 1);
    }    

    if($ok_fleet && isset($res['move_finish']) && !empty($res['move_finish']) && $res['move_finish'] > ($ACTUAL_TICK + 7)) {
        
        $tw_time = ($res['planet_owner'] == $game->player['user_id'] ? 1 : 7);
        
        $new_finish = max((int)($ACTUAL_TICK + $tw_time), (int)($res['move_finish'] - MAX_TRANSWARP_RANGE));
        
        $new_range = $new_finish - $ACTUAL_TICK;
        
        $sql = 'UPDATE scheduler_shipmovement SET move_rerouted = 1, remaining_distance = tick_speed * '.$new_range.', move_finish = '.$new_finish.' WHERE move_id = '.$res['move_id'].' AND user_id = '.$game->player['user_id'].' AND move_status = 0';
        
        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Transwarp failed!!!');

        }        
        
        $sql = 'UPDATE user SET user_tsw_timeout = 160 WHERE user_id = '.$game->player['user_id'];
        
        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Transwarp timeout setting failed!!!');

        }        
        
        $game->player['user_tsw_timeout'] = TRANSWARP_STD_COOLDOWN;
        
    }
    
}

$dismiss_officer = filter_input(INPUT_POST, 'dismiss_officer', FILTER_SANITIZE_NUMBER_INT);
if(isset($dismiss_officer) && !empty($dismiss_officer)){
    
    $sql = 'UPDATE officers SET fleet_id = 0 WHERE id = '.$dismiss_officer.' AND fleet_id > 0 AND user_id = '.$game->player['user_id'];
    
    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not dismiss fleet officer');

    }
}
$appoint_officer = filter_input(INPUT_POST, 'appoint_officer', FILTER_SANITIZE_NUMBER_INT);
$appoint_fleet = filter_input(INPUT_POST, 'appoint_fleet', FILTER_SANITIZE_NUMBER_INT);
if(isset($appoint_officer) && $appoint_officer != 0){
    
    $sql = 'UPDATE officers SET fleet_id = '.$appoint_fleet.' WHERE id = '.$appoint_officer.' AND fleet_id = 0 AND user_id = '.$game->player['user_id'];
    
    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not appoint fleet officer');

    }
}
$new_combat_lvl = filter_input(INPUT_POST, 'combat_level', FILTER_SANITIZE_NUMBER_INT);
$new_combat_lvl_2 = filter_input(INPUT_POST, 'combat_level_2', FILTER_SANITIZE_NUMBER_INT);
$new_tact_mov_1 = filter_input(INPUT_POST, 'tact_mov_1', FILTER_SANITIZE_NUMBER_INT);
$officer_new_combat_lvl = filter_input(INPUT_POST, 'combat_level_officer', FILTER_SANITIZE_NUMBER_INT);
if(isset($new_combat_lvl)){
    
    $sql = 'UPDATE officers SET combat_lvl = '.$new_combat_lvl.', combat_lvl_2 = '.$new_combat_lvl_2.(isset($new_tact_mov_1) ? ', tact_mov_1 = '.$new_tact_mov_1 : '').'  WHERE id = '.$officer_new_combat_lvl.' AND user_id = '.$game->player['user_id'];
    
    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleet officer combat level');

    }
}

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');
$game->out('<div align="center">[<a href="'.parse_link('a=ship_fleets_display&mass_set_homebase').'">'.constant($game->sprache("TEXT1")).'</a>]<br><br>');

if (isset($_GET['sfmap'])) {
    $game->option_store('show_fleets_map',(int)$_GET['sfmap']);
}

$trip_bell = filter_input(INPUT_POST, 'bell_action', FILTER_SANITIZE_NUMBER_INT);
if(isset($trip_bell) && $trip_bell == 1) {
    
    $fleet = $_POST['fleets'][0];
    $bell = filter_input(INPUT_POST, 'bell_value', FILTER_SANITIZE_NUMBER_INT);
    
    if($bell == 0) {$new_bell = 1;} else {$new_bell = 0;}
    
    $sql = 'UPDATE ship_fleets SET trip_bell = '.$new_bell.'  WHERE fleet_id = '.$fleet.' AND owner_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleet reminder setting');

    }
    
    unset($fleet, $trip_bell, $bell, $new_bell);
}

$officer_lookout_report = filter_input(INPUT_POST, 'report_action', FILTER_SANITIZE_NUMBER_INT);
if(isset($officer_lookout_report) && $officer_lookout_report == 1) {
    
    $fleet = $_POST['fleets'][0];
    $report = filter_input(INPUT_POST, 'report_value', FILTER_SANITIZE_NUMBER_INT);
    
    if($report == 0) {$new_report = 1;} else {$new_report = 0;}
    
    $sql = 'UPDATE officers SET officer_lookout_report = '.$new_report.'  WHERE fleet_id = '.$fleet.' AND user_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update fleet officer lookout setting');

    }
    
    unset($fleet, $officer_lookout_report, $report, $new_report);
}

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

    $sql = 'SELECT p.planet_id, p.system_id, p.planet_owner
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
        message(NOTICE, constant($game->sprache("TEXT7")).' <b>'.$_POST['pos_homebase'].'</b>');
    }
    
    if($game->is_system_allowed($planet['system_id']) === false) {
        message(NOTICE, constant($game->sprache("TEXT104")));
    }

    if($planet['planet_owner'] != $game->player['user_id'] && $planet['planet_owner'] != INDEPENDENT_USERID && $planet['planet_owner'] != ORION_USERID) {
        message(NOTICE, constant($game->sprache("TEXT104")));
    }

    $base = (int)$planet['planet_id'];
    $fleet = $_POST['fleets'][0];

    $sql = 'UPDATE ship_fleets SET homebase = '.$base.' WHERE fleet_id = '.$fleet.' AND owner_id = '.$game->player['user_id'];

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

$set_rallypoint = filter_input(INPUT_POST, 'set_rallypoint', FILTER_SANITIZE_STRING);
if(isset($set_rallypoint)) {
    $coord_pieces = explode(':', $set_rallypoint);
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
    
    $sql = 'SELECT p.planet_id, p.system_id, p.planet_owner
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
        message(NOTICE, constant($game->sprache("TEXT7")).' <b>'.$set_rallypoint.'</b>');
    }
    
    if($game->is_system_allowed($planet['system_id']) === false) {
        message(NOTICE, constant($game->sprache("TEXT104")));
    }
    
    if($planet['planet_owner'] != $game->player['user_id'] && $planet['planet_owner'] != INDEPENDENT_USERID && $planet['planet_owner'] != ORION_USERID) {
        message(NOTICE, constant($game->sprache("TEXT104")));
    }

    $rally = (int)$planet['planet_id'];
    $fleet = $_POST['fleets'][0];

    $sql = 'UPDATE ship_fleets SET rallypoint = '.$rally.' WHERE fleet_id = '.$fleet.' AND user_id = '.$game->player['user_id'];

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

$clear_rallypoint = filter_input(INPUT_POST, 'clear_rallypoint', FILTER_SANITIZE_NUMBER_INT);
if(isset($clear_rallypoint) && $clear_rallypoint === true) {
    $fleet = $_POST['fleets'][0];

    $sql = 'UPDATE ship_fleets SET rallypoint = 0 WHERE fleet_id = '.$fleet.' AND user_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not clear fleets rallypoint data');

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

    $sql = 'SELECT p.planet_id, p.system_id, p.planet_owner
            FROM (planets p, starsystems s)
            WHERE s.sector_id = '.$sector_id.' AND
                  s.system_x = '.$system_x.' AND
                  s.system_y = '.$system_y.' AND
                  p.system_id = s.system_id AND
                  p.planet_distance_id = '.$distance_id;

    if(($planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    if($game->is_system_allowed($planet['system_id']) === false) {
        message(NOTICE, constant($game->sprache("TEXT104")));
    }
    
    if(empty($planet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT7")).' <b>'.$_POST['dest_coord'].'</b>');
    }    
    
    if($planet['planet_owner'] != $game->player['user_id'] && $planet['planet_owner'] != INDEPENDENT_USERID && $planet['planet_owner'] != ORION_USERID) {
        message(NOTICE, constant($game->sprache("TEXT104")));
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
                   o.id AS officer_id, o.officer_name, o.officer_rank, o.officer_level, o.officer_race, 
                   o.combat_lvl, o.combat_lvl_2, o.tact_mov_1, o.officer_lookout_report,
                   o.skill_0, o.skill_1, o.skill_2, o.skill_3, o.skill_4, o.skill_5,
                   o.skill_6, o.skill_7, o.skill_8, o.skill_9,
                   o.battle_victory, o.battle_defeat,
                   o.optimal, o.optm_class_0, o.optm_class_1, o.optm_class_2, o.optm_class_3,
                   o.kill_class_1, o.kill_class_2, o.kill_class_3, 
                   o.lost_class_1, o.lost_class_2, o.lost_class_3,
                   p.planet_name, p.sector_id, p.planet_distance_id, p.building_7 AS spacedock_level,
                   s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                   u.user_id AS stationated_owner_id, u.user_name AS stationated_owner_name
            FROM (ship_fleets f)
            LEFT JOIN (officers o) ON f.fleet_id = o.fleet_id
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

    if($fleet['owner_id'] != $game->player['user_id']) {
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
                  owner_id = '.$game->player['user_id'].' AND
                  fleet_id <> '.$fleet_id.'
            ORDER BY fleet_name DESC';

    if(($q_ofleets = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other fleet data');
    }

    $other_fleets_html = '';

    while($o_fleets = $db->fetchrow($q_ofleets)) {
        $other_fleets_html .= '<option value="'.$o_fleets['fleet_id'].'">'.$o_fleets['fleet_name'].'</option>'.NL;
    }

    //$order_by = (!empty($_GET['order_by'])) ? $_GET['order_by'] : 'template';

    $new_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
    if(isset($new_order_by) && in_array($new_order_by, $order_types) && $new_order_by != $fleet['list_view']) {
        $fleet['list_view'] = $new_order_by;
        $sql = 'UPDATE ship_fleets SET list_view = "'.$new_order_by.'" WHERE fleet_id = '.$fleet['fleet_id'];
        if($db->query($sql) === false) {
            message(DATABASE_ERROR, 'Could not update new sort criteria for fleet');
        }        
    }
    
    $order_by = $fleet['list_view'];    
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
        default :
            $order_by = 'template';
            $order_by_str = 's.template_id ASC';
            break;
    }

    $sql = 'SELECT s.*,
                   st.name AS template_name, st.ship_torso, st.ship_class, st.value_1, st.value_2, st.value_3, st.value_4, st.value_10, st.value_5 AS max_hitpoints, st.max_torp,
                   st.rof AS tp_rof, st.rof2 AS tp_rof2
            FROM (ships s, ship_templates st)
            WHERE s.fleet_id = '.$fleet_id.' AND
                  st.id = s.template_id
            ORDER BY '.$order_by_str;

    if(($q_ships = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships data');
    }

    $game->register_click_id(21);

    $n_ships = $n_transporter = 0;
    $ships_option_html = '';
    $torso_counter = array(0,0,0,0,0,0,0,0,0,0);
    $class_counter = array(0,0,0,0);
    $damage_counter = array(0,0,0,0);
    $depleted_counter = array(0,0,0);
    $thereshold_ammo_ratio = 30;
    $punch_estimate = 0;
    $primary_avg    = 0;
    $secondary_avg  = 0;
    $planetary_estimate = 0;
    $shield_estimate = 0;
    $strenght_estimate = 0;
    $fleet_speed = 10.0;

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

    if(isset($fleet['officer_id']) && !empty($fleet['officer_id'])){$off_flag = true;} else {$off_flag = false;}
    
    while($s_ship = $db->fetchrow($q_ships)) {
        if($s_ship['value_10'] < $fleet_speed) {$fleet_speed = $s_ship['value_10'];}
        // $primary   = (int)((($s_ship['value_1'] + $s_ship['value_1']*($s_ship['experience']/1000)*0.25) / 1.075) * $s_ship['tp_rof']);
        $primary = (((($s_ship['value_1']/2) * (0.85 + ((int)$s_ship['rating_1a'] * 0.005))) + 
                        (($s_ship['value_1']/2) * (0.85 + ((int)$s_ship['rating_1b'] * 0.005))) +
                        $s_ship['value_1']*($s_ship['experience']/1000))*0.25) * $s_ship['tp_rof'];        
        if($s_ship['ship_torso'] > 2 && $s_ship['torp'] > 0) {
            // $secondary = (int)((($s_ship['value_2'] + $s_ship['value_2']*($s_ship['experience']/500)*0.4) / 1.075) * $s_ship['tp_rof2']);
            $secondary = (((($s_ship['value_2']/2) * (0.85 + ((int)$s_ship['rating_2a'] * 0.005))) + 
                              (($s_ship['value_2']/2) * (0.85 + ((int)$s_ship['rating_2b'] * 0.005))) +
                               $s_ship['value_2']*($s_ship['experience']/1000))*0.40) * $s_ship['tp_rof2'];            
        }
        else {
            $secondary = 0;
        }
        
        if($s_ship['ship_torso'] > 2) {
            if($s_ship['value_2'] > 0) {$ammo_ratio = (int)($s_ship['torp']*100/$s_ship['max_torp']);} else {$ammo_ratio = 100;}
        }
        else {
            $ammo_ratio = 100;
        }
            
        $punch_estimate    += $primary + $secondary;
        $primary_avg       += $primary;
        $secondary_avg     += $secondary;
        $planetary_estimate += $s_ship['value_3'];
        $shield_estimate   += $s_ship['value_4'];
        $strenght_estimate += $s_ship['hitpoints'];
        /* 07/04/08 - AC: If present, show also ship's name */
        $id_modifier = 0;
        if($s_ship['ship_torso'] > 2 && $ammo_ratio < $thereshold_ammo_ratio) {
            $id_modifier = 100000;
        }
        elseif($s_ship['ship_torso'] > 2 && $ammo_ratio == 100) {
            $id_modifier = 200000;
        }
        elseif($s_ship['ship_torso'] > 2 && $ammo_ratio > $thereshold_ammo_ratio && $ammo_ratio < 100) {
            $id_modifier = 300000;
        }
        // $id_modifier = (($s_ship['ship_torso'] > 2 && $ammo_ratio < $thereshold_ammo_ratio) ? 100000 : 0);
        $new_id = $s_ship['max_hitpoints']-$s_ship['hitpoints'] + $id_modifier;
        $ships_option_html .= '<option id="'.$new_id.'" value="'.$s_ship['ship_id'].'">'.(($s_ship['ship_name'] != '')? $s_ship['template_name'].' - '.$s_ship['ship_name'] : $s_ship['template_name']).(!empty($s_ship['ship_ncc']) ? ' ['.$s_ship['ship_ncc'].'] ' : '').' ('.$s_ship['hitpoints'].'/'.$s_ship['max_hitpoints'].', Torp: '.($s_ship['ship_torso'] < 3 || $s_ship['value_2'] == 0 ? 'n/a' : $s_ship['torp']).', Exp: '.$s_ship['experience'].', Warp: '.$s_ship['value_10'].', AT: '.($s_ship['awayteam'] == 0 ? 'OnDuty' : intval($s_ship['awayteam'])).')</option>';

        if($s_ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter++;

        $torso_counter[$s_ship['ship_torso']]++;
        $class_counter[$s_ship['ship_class']]++;

        if($s_ship['max_hitpoints'] == $s_ship['hitpoints'])
            $damage_counter[0]++;
        else {
            $damage_counter[1]++;
            $dmg_ratio = (int)($s_ship['hitpoints']*100/$s_ship['max_hitpoints']);
            if($dmg_ratio < 25) $damage_counter[3]++; 
            if($dmg_ratio < 50) $damage_counter[2]++; 
        }

        if($ammo_ratio == 100 || $s_ship['ship_torso'] < 3)
            $depleted_counter[0]++;
        else {
            if($ammo_ratio < $thereshold_ammo_ratio)
                $depleted_counter[2]++;
            else
                $depleted_counter[1]++;
        }

        $n_ships++;
    }

    $primary_avg   = (int)($primary_avg / $n_ships);
    $secondary_avg = (int)($secondary_avg / $n_ships);
    
    $analyze_string  = '<i>'.constant($game->sprache("TEXT111")).':</i> '.(int)$punch_estimate.'<br><i>'.constant($game->sprache("TEXT114")).':</i> '.$primary_avg.'<br><i>'.constant($game->sprache("TEXT115")).':</i> '.$secondary_avg.'<br><i>'.constant($game->sprache("TEXT127")).':</i> '.$planetary_estimate.'<br>';
    $analyze_string .= '<i>'.constant($game->sprache("TEXT112")).':</i> '.$shield_estimate.'<br><i>'.constant($game->sprache("TEXT113")).':</i> '.$strenght_estimate;
    
    $torso_string_counter = '<table>';
    foreach($torso_counter as $key => $torso)
    {
        if($torso == 0) continue;
        // $torso_string_counter .= $SHIP_TORSO[$game->player['user_race']][$key][29].' <b>'.$torso.'</b><br>';
        // $torso_string_counter .= $ship_torso[$key].' <b>'.$torso.'</b><br>';	
        $torso_string_counter .= '<tr><td>'.$ship_torso[$key].'</td><td align=right><b>'.$torso.'</b></td></tr>';
    }
    $torso_string_counter .= '</table>';
    
    
    $damage_string_counter = '<table>';
    //$damage_string_counter .= constant($game->sprache("TEXT92")).' <b>'.$damage_counter[0].'</b>';
    $damage_string_counter .= '<tr><td>'.constant($game->sprache("TEXT92")).'</td><td align=right><b>'.$damage_counter[0].'</b></td></tr>';

    //if($damage_counter[1]>0) $damage_string_counter .= '<br>'.constant($game->sprache("TEXT93")).' <b>'.$damage_counter[1].'</b> '.constant($game->sprache("TEXT94")).' <b>'.$damage_counter[2].'</b><br>'.constant($game->sprache("TEXT95")).' <b>'.$damage_counter[3].'</b>';
    if($damage_counter[1]>0) $damage_string_counter .= '<tr><td>'.constant($game->sprache("TEXT93")).'</td><td align=right><b>'.$damage_counter[1].'</b></td></tr><tr><td>'.constant($game->sprache("TEXT94")).'</td><td align=right><b>'.$damage_counter[2].'</b></td></tr><tr><td>'.constant($game->sprache("TEXT95")).'</td><td align=right><b>'.$damage_counter[3].'</b></td></tr>';
    $damage_string_counter .= '</table>';
    // $depleted_string .= constant($game->sprache("TEXT96")).' <b>'.$depleted_counter[0].'</b><br>'.constant($game->sprache("TEXT97")).' <b>'.$depleted_counter[1].'</b><br>'.constant($game->sprache("TEXT98")).' <b>'.$depleted_counter[2].'</b>';
    
    $depleted_string .= '<table><tr><td>'.constant($game->sprache("TEXT96")).'</td><td align=right><b>'.$depleted_counter[0].'</b></td></tr><tr><td>'.constant($game->sprache("TEXT97")).'</td><td align=right><b>'.$depleted_counter[1].'</b></td></tr><tr><td>'.constant($game->sprache("TEXT98")).'</td><td align=right><b>'.$depleted_counter[2].'</b></td></tr></table>';

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

    if(!$fleet['is_civilian']){
        $ap_green_str = ($fleet['alert_phase'] == ALERT_PHASE_GREEN) ? '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_GREEN.'&planet').'">'.constant($game->sprache("TEXT9")).'</a>]';
        $ap_yellow_str = ($fleet['alert_phase'] == ALERT_PHASE_YELLOW) ? '[<span style="color: #FFFF00;">'.constant($game->sprache("TEXT10")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_YELLOW.'&planet').'">'.constant($game->sprache("TEXT10")).'</a>]';
        $ap_red_str = ($fleet['alert_phase'] == ALERT_PHASE_RED) ? '[<span style="color: #FF0000;">'.constant($game->sprache("TEXT11")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_RED.'&planet').'">'.constant($game->sprache("TEXT11")).'</a>]';
    }
    else{
        $ap_green_str = '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]';
        $ap_yellow_str = '[<i>'.constant($game->sprache("TEXT10")).'</i>]';
        $ap_red_str = '[<i>'.constant($game->sprache("TEXT11")).'</i>]';
    }

    $game->out('
<table width="590px" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="2" class="style_inner">
  <form name="fleet_form" method="post" action="">
  <input type="hidden" name="mode_id" value="2">
  <input type="hidden" name="bell_value" value="'.$fleet['trip_bell'].'">
  <input type="hidden" name="bell_action" value="">
  <input type="hidden" name="report_value" value="'.$fleet['officer_lookout_report'].'">
  <input type="hidden" name="report_action" value="">
  <input type="hidden" name="masksw" value="">
  <input type="hidden" name="mask_id" value="'.$fleet['fleet_id'].'">  
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70%" align="left">[<a href="'.parse_link('a=ship_fleets_display').'">'.constant($game->sprache("TEXT12")).'</a>]&nbsp;&nbsp;&nbsp;<input class="field" type="text" name="fleet_name" value="'.$fleet['fleet_name'].'" maxlength="20" size="25">&nbsp;<input name="rename_fleet_submit" type="submit" class="button" value="'.constant($game->sprache("TEXT13")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&rename_fleet='.$fleet_id).'\'"></td>
          <td width="10%" align="right"><input class="button" style="width: 75px;" type="submit" value="'.($fleet['user_id'] == UNDISCLOSED_USERID ? 'ID: mask' : 'ID: norm').'" onClick="document.fleet_form.masksw.value = 1; return document.fleet_form.action = \''.parse_link_ex('a=ship_fleets_display&pfleet_details='.$fleet_id,LINK_CLICKID).'\'"></td>
          <td width="10%" align="right"><input type="image" src="'.$game->GFX_PATH.'icon_handover.gif" name="surrender_submit" value="1" onmouseover="return overlib(\''.constant($game->sprache("TEXT135")).'\', CAPTION, \''.constant($game->sprache("TEXT134")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();" onClick="return document.fleet_form.action = \''.parse_link('a=ship_actions&step=surrender_setup').'\';"></td>
          <td width="10%" align="right">'.( ($n_ships == 1) ? '<b>1</b> '.constant($game->sprache("TEXT14")) : '<b>'.$n_ships.'</b> '.constant($game->sprache("TEXT15")) ).'</td>
        </tr>
      </table>
      <br>');
      $game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT130")).':</span></legend>');
      
      $game->out(constant($game->sprache("TEXT16")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['planet_id'])).'"><b>'.$fleet['planet_name'].'</b></a> ('.$game->get_sector_name($fleet['sector_id']).':'.$game->get_system_cname($fleet['system_x'], $fleet['system_y']).':'.($fleet['planet_distance_id'] + 1).')'.( ($fleet['stationated_owner_id'] != $game->player['user_id']) ? ' '.constant($game->sprache("TEXT17")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$fleet['stationated_owner_id']).'"><b>'.$fleet['stationated_owner_name'].'</b></a>' : '' ).'<br><br>

       <input type="hidden" name="combat_level_officer" value='.$fleet['officer_id'].'>                         
       <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width=60%>'.constant($game->sprache("TEXT18")).' '.$ap_green_str.'&nbsp;'.$ap_yellow_str.'&nbsp;'.$ap_red_str.'</td>
            <td width=40%></td></tr>');
    if($off_flag){
        $game->out('                                
        <tr>
            <td width=60%>'.constant($game->sprache("TEXT122")).' ('.$fleet['combat_lvl'].'): '.constant($game->sprache("TEXT117_".$fleet['combat_lvl'])).'</td>
            <td width=40%><select name="combat_level">
                                <option'.( ($fleet['combat_lvl'] == 3) ? ' selected="selected"' : '').'>3</option>
                                <option'.( ($fleet['combat_lvl'] == 2) ? ' selected="selected"' : '').'>2</option>
                                <option'.( ($fleet['combat_lvl'] == 1) ? ' selected="selected"' : '').'>1</option>
                                <option'.( ($fleet['combat_lvl'] == 0) ? ' selected="selected"' : '').'>0</option>
                          </select>
                          <input class="button" style="width: 50px;" type="submit" value="'.constant($game->sprache("TEXT118")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">
            </td>
        </tr>
        <tr>
            <td width=60%>'.constant($game->sprache("TEXT122")).' ('.$fleet['combat_lvl_2'].'): '.constant($game->sprache("TEXT123_".$fleet['combat_lvl_2'])).'</td>
            <td width=40%><select name="combat_level_2">
                                <option'.( ($fleet['combat_lvl_2'] == 1) ? ' selected="selected"' : '').'>1</option>
                                <option'.( ($fleet['combat_lvl_2'] == 0) ? ' selected="selected"' : '').'>0</option>
                          </select>
                          <input class="button" style="width: 50px;" type="submit" value="'.constant($game->sprache("TEXT118")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">
            </td>
        </tr>
        <tr> 
            <td width=60%>'.constant($game->sprache("TEXT125")).' ('.$fleet['tact_mov_1'].'): '.constant($game->sprache("TEXT126_".$fleet['tact_mov_1'])).'</td>
            <td width=40%><select name="tact_mov_1">
                                <option'.( ($fleet['tact_mov_1'] == 0) ? ' selected="selected"' : '').'>0</option>
                                <option'.( ($fleet['tact_mov_1'] == 1) ? ' selected="selected"' : '').'>1</option>
                          </select>
                          <input class="button" style="width: 50px;" type="submit" value="'.constant($game->sprache("TEXT118")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">
        </tr>
        <tr>
        <td width=60%>'.constant($game->sprache("TEXT133")).'
        <td width=40%><input class="button" style="width: 130px;" type="submit" name="toggle_report" onClick="document.fleet_form.report_action.value=1;" value="'.($fleet['officer_lookout_report'] ? '&#128276; '.constant($game->sprache("TEXT133_1")).' &#128276;' : '&#128277; '.constant($game->sprache("TEXT133_2")).' &#128277;').'">&nbsp;</td>                   
        </tr>        
        ');
            }
    $game->out('
      </table></fieldset><br>
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

    //DC ... Fleet officier panel
    if($off_flag){
        
        $form_diff = abs($class_counter[0] - $n_ships*($fleet['optm_class_0']/100)) +
                     abs($class_counter[1] - $n_ships*($fleet['optm_class_1']/100)) +
                     abs($class_counter[2] - $n_ships*($fleet['optm_class_2']/100)) +
                     abs($class_counter[3] - $n_ships*($fleet['optm_class_3']/100));
          
        $eff_form= round(0.36 - (0.72 / $n_ships * $form_diff), 2, PHP_ROUND_HALF_DOWN);
            
        if($eff_form < -0.36) {$eff_form = -0.36;}            

        $eff_ratio = round(($eff_form*100 / 0.36), 2);

        if($eff_ratio < -100) {$eff_ratio = -100;}        

        if($fleet['optimal'] != 0) {
            $color = ( ($fleet['optimal'] >= $n_ships) ? '#00FF00' : '#FF0000');
        }
        else {
            $color = '#00FF00';
        }

        
        $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
        $game->out('
            <fieldset>
            <legend><span class="sub_caption2">'.constant($game->sprache("TEXT131")).':</span></legend>
            <div style="width:100%">
                <div style="position:relative; float:left; width:19%; border: 1px solid;">
                    <img src="'.$game->PLAIN_GFX_PATH.'officer_'.$fleet['officer_race'].'.gif" alt="faccione" height="140" width="100">
                </div>
                <div style="position:relative; float:left; width:25%; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td width=20><img src="'.$game->PLAIN_GFX_PATH.'officer_rank_'.$fleet['officer_rank'].'.png" alt="rank" height="20" width="20"></td>
                        <td width=20 align=center><b>'.$fleet['officer_level'].'</b></td>
                        <td align=center>'.$fleet['officer_name'].'</td>
                    </tr>');
        /*
        $game->out('</table>
                    <table width=50% align=left style="border-top-style: dotted; border-top-width: 1px">');
                    for($i=0;$i<5;$i++){
                        if(isset($fleet['skill_'.$i]) && $fleet['skill_'.$i] == true) {
                            $game->out('<tr><td align=center>Label Skill '.($i+1).'</td></tr>');
                        }
                    }
            
        $game->out('</table>
                    <table width=50% align=right style="border-top-style: dotted; border-top-width: 1px">');
                    for($i=5;$i<10;$i++){
                        if(isset($fleet['skill_'.$i]) && $fleet['skill_'.$i] == true) {
                            $game->out('<tr><td align=center>Label Skill '.($i+1).'</td></tr>');
                        }
                    }
         * 
         */
        $game->out('</table>
                </div>
                <div style="position:relative; float:right; width:54%; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td>Battaglie Vinte</td><td width=40px align=right>'.$fleet['battle_victory'].'</td>
                        <td>Battaglie Perse</td><td width=40px align=right>'.$fleet['battle_defeat'].'</td>                    
                    <tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 1:</td>
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_1'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_1'].'</td>
                    </tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 2:</td>
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_2'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_2'].'</td>
                    </tr>
                    </table>                    
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 3:</td>                    
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_3'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_3'].'</td>
                    </tr>
                    </table>
                    <table>
                    <tr>
                        <td width=39px>E.C.:</td>
                        <td width=65px align=right><p style="color:'.$color.'">'.$n_ships.'/'.( ($fleet['optimal'] == 0) ? '&infin;' : $fleet['optimal']).'</td>                    
                        <td width=30px>Fleet:</td>
                        <td width=36px><b>Civ:</b>'.round(($class_counter[0]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>1:</b>'.round(($class_counter[1]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>2:</b>'.round(($class_counter[2]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>3:</b>'.round(($class_counter[3]*100)/$n_ships,0).'&#37;</td>
                    </tr>                    
                    <tr>
                        <td width=39px>E.F.:</td>
                        <td witdh=65px align=right><p style="color:'.($eff_ratio >= 0 ? '#00FF00' : '#FF0000').'">'.$eff_ratio.'&#37;</td>                    
                        <td width=30px>Optm:</td>
                        <td width=36px><b>Civ:</b>'.$fleet['optm_class_0'].'&#37;</td>
                        <td width=36px><b>1:</b>'.$fleet['optm_class_1'].'&#37;</td>
                        <td width=36px><b>2:</b>'.$fleet['optm_class_2'].'&#37;</td>
                        <td width=36px><b>3:</b>'.$fleet['optm_class_3'].'&#37;</td>
                    </tr>
                    </table>
                    <table width=100%>
                    <tr>
                       <td align="center">
                       <input type="hidden" name="dismiss_officer" value=0>
                       <input class="button" style="width: 130px;" type="submit" value="'.constant($game->sprache("TEXT119")).'" onClick="document.fleet_form.dismiss_officer.value='.$fleet['officer_id'].'; return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">
                       </td>
                    </tr>   
                    </table>
                </div>
            </fieldset>
            <br>
        ');
    }
    elseif(!$off_flag && ($class_counter[1]+$class_counter[2]+$class_counter[3] > 0)){
        $sql='SELECT id, officer_name, officer_rank FROM officers WHERE user_id = '.$game->player['user_id'].' AND fleet_id = 0 ORDER BY officer_level DESC, officer_rank DESC';
        $officer_list = $db->queryrowset($sql);
        if($db->num_rows() > 0) {
            $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
            $game->out('
            <div>
                <br>
                <center>
                   <input type="hidden" name="appoint_fleet" value='.$fleet_id.'>
                   <select name="appoint_officer">
                   <option value=0>'.constant($game->sprache("TEXT131_1")).':</option>');
            foreach ($officer_list as $officer_candidate) {
                $game->out('<option value='.$officer_candidate['id'].'>'.constant($game->sprache("TEXT120_".$officer_candidate['officer_rank'])).' '.$officer_candidate['officer_name'].'</option>');
            }                   
            $game->out('
                   </select>
                   <input class="button" style="width: 130px;" type="submit" value="'.constant($game->sprache("TEXT121")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">            
                </center>
                <br>
            </div>
                ');
        }        
    }
    //DC --- Fleet composition panel
    $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
    $game->out('
        <fieldset>
        <legend><a href="javascript:void(0)" onmouseover="return overlib(\''.$analyze_string.'\', CAPTION, \''.constant($game->sprache("TEXT116")).'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span class="sub_caption2">'.constant($game->sprache("TEXT89")).':</span></a>');
        if($game->player['user_auth_level'] == STGC_DEVELOPER) {
            $game->out('<input type="hidden" name="fleet_id" value="'.$fleet_id.'">
                        <input type="image" src="'.$game->GFX_PATH.'tc_analyze.gif" title="'.constant($game->sprache("TEXT116")).'" onClick="document.fleet_form.mode_id.value=2; return document.fleet_form.action = \''.parse_link('a=tactical_analyze').'\';">');
        }    
        $game->out('</legend>
        <div>
            <div style="position:relative; margin:auto; width:450">
            <table width=450 cellpadding=0 cellspacing=0 border=0>
              <tr>
                <td '.$style.' width=33% align=center>'.constant($game->sprache("TEXT31")).'</td>
                <td '.$style.' width=33% align=center>'.constant($game->sprache("TEXT99")).'</td>
                <td '.$style.' width=34% align=center>'.constant($game->sprache("TEXT100")).'</td>
              </tr>
              <tr>
                <td width=33% align=center>'.$torso_string_counter.'</td>
                <td width=33% align=center>'.$damage_string_counter.'</td>
                <td width=34% align=center>'.$depleted_string.'</td>
              </tr>
            </table>
            </div>
        </div>
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
         if ((objShipListBox.options[i].id == 0) || (objShipListBox.options[i].id == 100000) || (objShipListBox.options[i].id == 200000) || (objShipListBox.options[i].id == 300000)) {
            objShipListBox.options[i].selected = false;
         } else {
            objShipListBox.options[i].selected = true;
         }
      } else if (cSelectType == "None") {
         objShipListBox.options[i].selected = false;
      } else if (cSelectType == "Depleted") {
         if (objShipListBox.options[i].id > 99999 && objShipListBox.options[i].id < 200000) {
            objShipListBox.options[i].selected = true;
         } else {
            objShipListBox.options[i].selected = false;
         }
      } else if (cSelectType == "Full") {
         if (objShipListBox.options[i].id > 199999 && objShipListBox.options[i].id < 300000) {
            objShipListBox.options[i].selected = true;
         } else {
            objShipListBox.options[i].selected = false;
         }         
      } else if (cSelectType == "Half") {
         if (objShipListBox.options[i].id > 299999) {
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
           <td  height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_all" value="'.constant($game->sprache("TEXT29")).'" onClick="ShipSelection(\'None\')">
           </td>
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_damaged" value="'.constant($game->sprache("TEXT78B")).'" onClick="ShipSelection(\'Full\')">
           </td>
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_damaged" value="'.constant($game->sprache("TEXT28")).'" onClick="ShipSelection(\'Damaged\')">
           </td>           
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_depleted" value="'.constant($game->sprache("TEXT78C")).'" onClick="ShipSelection(\'Half\')">
           </td>
          </tr>
          <tr valign="middle">
           <td height=25%>
            <input class="button" style="width: 90px;" type="button" name="select_none" value="'.constant($game->sprache("TEXT78")).'" onClick="ShipSelection(\'Depleted\')">
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
      <table width="550" border="0" cellpadding="2" cellspacing="0">



       <tr>

       <td width="250">'.constant($game->sprache("TEXT39")).' <b>'.( ($planet_koords['sector_id']==0) ? '<b>'.constant($game->sprache("TEXT40")).'</b>' : ''.$game->get_sector_name($planet_koords['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($planet_koords['planet_distance_id'] + 1).' ( '.$planet_koords['planet_name'].' )' ).'</b></td>

       <td width="150"><input class="button" style="width: 130px;" type="submit" name="send_homebase" value="'.constant($game->sprache("TEXT41")).'" onClick="return document.fleet_form.action = \''.parse_link('a=send_home').'\'"></td>
           
       <td>&nbsp;</td>

       </tr>

       <tr>

         <td width="250"><input class="field" style="width: 130px;" type="text" name="pos_homebase"></td>

         <td width="150"><input class="button" style="width: 130px;" type="submit" name="set_homebase" value="'.constant($game->sprache("TEXT42")).'">&nbsp;&nbsp;</td>

       </tr>

       <tr>

         <td width="250">&nbsp;&nbsp;</td>
         
         <td width="150"><input class="button" style="width: 130px;" type="submit" name="toggle_bell" onClick="document.fleet_form.bell_action.value=1;" value="'.($fleet['trip_bell'] ? '&#128276; '.constant($game->sprache("TEXT129")).' &#128276;' : '&#128277; '.constant($game->sprache("TEXT129_1")).' &#128277;').'">&nbsp;</td>

       </tr>

       <tr>

         <td>&nbsp;</td>

       </tr>

     

        <tr>
          <td width="250"><input class="field"  style="width: 130px;" type="text" name="new_fleet_name"></td>
          <td width="150"><input class="button" style="width: 130px;" type="submit" name="new_fleet_submit" value="'.constant($game->sprache("TEXT43")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&new_fleet='.$fleet_id).'\'"></td>
          <td>&nbsp;</td>        
        </tr>
    ');

    if(!empty($other_fleets_html)) {
        $game->out('
        <tr><td height="5"></td></tr>
        <tr>
          <td><select style="width: 130px;" name="to_fleet">'.$other_fleets_html.'</select></td>
          <td><input class="button" style="width: 130px;" type="submit" name="change_fleet_submit" value="'.constant($game->sprache("TEXT44")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_distribute&change_fleet='.$fleet_id).'\'">'.( ( ($n_resources > 0) || ($n_units > 0) ) ? '&nbsp;&nbsp;<input class="button" style="width: 130px;" type="submit" name="loadingf_submit" value="'.constant($game->sprache("TEXT45")).'"  onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_loadingf&to').'\'">' : '' ).'</td>
          <td>&nbsp;</td>    
        </tr>
        ');
    }

    $cartography_html = $own_planets_html = $tcm_html = '';
    $i = 0;
    
    if($game->player['last_tcartography_view'] == 3 || $game->player['last_tcartography_view'] == 4) {
        switch($game->player['last_tcartography_view']) {
            case 3:
                $sql = 'SELECT sd.log_code, p.planet_name, p.sector_id, p.planet_distance_id,
                               s.system_x, s.system_y, system_global_x, system_global_y
                        FROM (planets p)
                        INNER JOIN (starsystems s) ON s.system_id = p.system_id
                        LEFT JOIN (starsystems_details sd) ON (sd.system_id = p.system_id AND sd.user_id = '.$game->player['user_id'].' AND log_code = 0)                        
                        WHERE p.system_id = '.$game->player['last_tcartography_id'].'
                        ORDER BY p.planet_distance_id DESC';                
                break;
            case 4:
                $sql = 'SELECT sd.log_code, p.planet_name, p.sector_id, p.planet_distance_id,
                               s.system_x, s.system_y, system_global_x, system_global_y
                        FROM (planets p)
                        INNER JOIN (starsystems s) ON s.system_id = p.system_id
                        LEFT JOIN (starsystems_details sd) ON (sd.system_id = p.system_id AND sd.user_id = '.$game->player['user_id'].' AND log_code = 0)
                        WHERE p.planet_id = '.$game->player['last_tcartography_id'].'
                        ORDER BY p.planet_distance_id DESC';                
                break;
        }
        
        if(!$q_cart = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query tactical cartography data');
        }        
        
        while($cart = $db->fetchrow($q_cart)) {
            $dist = get_distance(array($cart['system_global_x'], $cart['system_global_y']), array($fleet['system_global_x'],$fleet['system_global_y']));
            $velocity = warpf($fleet_speed);
            if($dist > 0) {$timedist = ceil( ( ($dist / $velocity) / TICK_DURATION ) );} elseif($cart['planet_id'] != $fleet['planet_id']) {$timedist = $INTER_SYSTEM_TIME;} else {$timedist = 0;}
            $script_string .= 'case "'.$i.'": document.fleet_form.dest_coord.value="'.($game->get_sector_name($cart['sector_id']).':'.$game->get_system_cname($cart['system_x'], $cart['system_y']).':'.($cart['planet_distance_id'] + 1)).'";';
            $script_string .= 'document.fleet_form.eta.value="ETA '.Zeit($timedist*TICK_DURATION).' @W'.$fleet_speed.'"; break;';
            $cartography_html .= (isset($cart['log_code']) ? '<option value="'.$i.'">'.($cart['planet_distance_id']+1).':'.$cart['planet_name'].'</option>' : '<option value="'.$i.'">'.($cart['planet_distance_id']+1).':'.constant($game->sprache("TEXT56")).'</option>');
            $i++;
        }        
    }

    $sql = 'SELECT p.planet_name, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y, system_global_x, system_global_y
            FROM (planets p)
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE p.planet_owner = '.$game->player['user_id'].'
            ORDER BY p.planet_name ASC';

    if(!$q_own_planets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query own planets coord data');
    }

    //$i = 0;
    while($planet = $db->fetchrow($q_own_planets)) {
        $dist = get_distance(array($planet['system_global_x'], $planet['system_global_y']), array($fleet['system_global_x'],$fleet['system_global_y']));
        $velocity = warpf($fleet_speed);
        if($dist > 0) {$timedist = ceil( ( ($dist / $velocity) / TICK_DURATION ) );} elseif($planet['planet_id'] != $fleet['planet_id']) {$timedist = $INTER_SYSTEM_TIME;} else {$timedist = 0;}
        $script_string .= 'case "'.$i.'": document.fleet_form.dest_coord.value="'.($game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1)).'";';
        $script_string .= 'document.fleet_form.eta.value="ETA '.Zeit($timedist*TICK_DURATION).' @W'.$fleet_speed.'"; break;';
        $own_planets_html .= '<option value="'.$i.'">'.$planet['planet_name'].'</option>';
        $i++;
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

    //$i = 0;
    while($tcm = $db->fetchrow($q_tcm)) {
        $dist = get_distance(array($tcm['system_global_x'], $tcm['system_global_y']), array($fleet['system_global_x'],$fleet['system_global_y']));
        $velocity = warpf($fleet_speed);
        if($dist > 0) {$timedist = ceil( ( ($dist / $velocity) / TICK_DURATION ) );} elseif($tcm['planet_id'] != $fleet['planet_id']) {$timedist = $INTER_SYSTEM_TIME;} else {$timedist = 0;}        
        $script_string .= 'case "'.$i.'": document.fleet_form.dest_coord.value="'.($game->get_sector_name($tcm['sector_id']).':'.$game->get_system_cname($tcm['system_x'], $tcm['system_y']).':'.($tcm['planet_distance_id'] + 1)).'";';
        $script_string .= 'document.fleet_form.eta.value="ETA '.Zeit($timedist*TICK_DURATION).' @W'.$fleet_speed.'"; break;';        
        $tcm_html .= '<option value="'.$i.'">'.$tcm['memo_name'].'</option>';
        $i++;        
    }

    $has_cartography = (!empty($cartography_html));
    $has_own_planets = (!empty($own_planets_html));
    $has_tcm = (!empty($tcm_html));

    $game->out('
        <SCRIPT LANGUAGE="JavaScript">
        function SetDestETA(destid)
        {
            switch(destid) {
            '.$script_string.'
            default:
            }
        }
        </SCRIPT>
        <tr><td height="5"></td></tr>
        <tr>
          <td><select style="width: 130px;"'.( ($has_cartography || $has_own_planets || $has_tcm) ? ' onChange="if(this.value) SetDestETA(this.value);"' : ' disabled="disabled"' ).'><option>'.constant($game->sprache("TEXT46")).'</option>'.( ( ($has_cartography) ? '<option>---------------------</option>'.$cartography_html : '' ).( ($has_own_planets) ? '<option>---------------------</option>'.$own_planets_html : '' ).( ($has_tcm) ? '<option>---------------------</option>'.$tcm_html : '' ) ).'</select>&nbsp;&nbsp;<input type="text" class="field" name="dest_coord" size="10"></td>
          <td><input style="width: 130px;" class="button" type="submit" name="send_fleets" value="'.constant($game->sprache("TEXT47")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_send').'\'"></td>
          <td><input type="text" name="eta" readonly value=""></td>    
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
                   o.id AS officer_id, o.officer_name, o.officer_rank, o.officer_level, o.officer_race, o.combat_lvl, o.combat_lvl_2, o.officer_lookout_report,
                   o.skill_0, o.skill_1, o.skill_2, o.skill_3, o.skill_4, o.skill_5,
                   o.skill_6, o.skill_7, o.skill_8, o.skill_9,
                   o.battle_victory, o.battle_defeat,
                   o.optimal, o.optm_class_0, o.optm_class_1, o.optm_class_2, o.optm_class_3,  
                   o.kill_class_1, o.kill_class_2, o.kill_class_3, 
                   o.lost_class_1, o.lost_class_2, o.lost_class_3,        
                   p1.planet_name AS start_planet_name, p1.system_id AS start_system_id, p1.sector_id AS start_sector, p1.planet_distance_id AS start_distance_id,
                   s1.system_x AS start_system_x, s1.system_y AS start_system_y, sd1.timestamp AS start_tmsmp,
                   p2.planet_name AS dest_planet_name, p2.system_id AS dest_system_id, p2.sector_id as dest_sector, p2.planet_distance_id AS dest_distance_id,
                   s2.system_x AS dest_system_x, s2.system_y AS dest_system_y, sd2.timestamp AS dest_tmsmp
            FROM (ship_fleets f)
            LEFT JOIN (officers o) ON f.fleet_id = o.fleet_id
            INNER JOIN (scheduler_shipmovement ss) ON ss.move_id = f.move_id
            INNER JOIN (planets p1) ON p1.planet_id = ss.start
            INNER JOIN (starsystems s1) ON s1.system_id = p1.system_id
            LEFT JOIN (starsystems_details sd1) ON sd1.system_id = s1.system_id AND sd1.user_id = f.owner_id
            INNER JOIN (planets p2) ON p2.planet_id = ss.dest
            INNER JOIN (starsystems s2) ON s2.system_id = p2.system_id
            LEFT JOIN (starsystems_details sd2) ON sd2.system_id = s2.system_id AND sd2.user_id = f.owner_id
            WHERE f.fleet_id = '.$fleet_id.' AND
                  ss.move_id = f.move_id';

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    if($fleet['owner_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT48")).' '.$fleet['fleet_id'].' '.constant($game->sprache("TEXT49")).' '.$fleet['user_id'].' '.constant($game->sprache("TEXT50")).' '.$game->player['user_id']);
    }

    if(!empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT51")));
    }

    $clip_flag = filter_input(INPUT_GET, 'add_clip', FILTER_SANITIZE_NUMBER_INT);
    
    if($clip_flag){
        $note_txt = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
        add_note($note_txt);
        redirect('a=ship_fleets_display&mfleet_details='.$fleet_id.'');
    }
    
    $sql = 'SELECT fleet_id, fleet_name
            FROM ship_fleets
            WHERE move_id = '.$fleet['move_id'].' AND
                  owner_id = '.$game->player['user_id'].' AND
                  fleet_id <> '.$fleet_id.'
            ORDER BY fleet_name DESC';

    if(($q_ofleets = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other fleet data');
    }

    $other_fleets_html = '';

    while($o_fleets = $db->fetchrow($q_ofleets)) {
        $other_fleets_html .= '<option value="'.$o_fleets['fleet_id'].'">'.$o_fleets['fleet_name'].'</option>'.NL;
    }

    //$order_by = (!empty($_GET['order_by'])) ? $_GET['order_by'] : 'template';
    
    $new_order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
    if(isset($new_order_by) && in_array($new_order_by, $order_types) && $new_order_by != $fleet['list_view']) {
        $fleet['list_view'] = $new_order_by;
        $sql = 'UPDATE ship_fleets SET list_view = "'.$new_order_by.'" WHERE fleet_id = '.$fleet['fleet_id'];
        if($db->query($sql) === false) {
            message(DATABASE_ERROR, 'Could not update new sort criteria for fleet');
        }        
    }
    
    $order_by = $fleet['list_view'];    

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
        default :
            $order_by = 'template';
            $order_by_str = 's.template_id ASC';
            break;
    }
    
    $game->register_click_id(20);
    
    $sql = 'SELECT s.*,
                   st.name AS template_name, st.ship_torso, st.ship_class, st.value_1, st.value_2, st.value_3, st.value_4, st.value_10, st.value_5 AS max_hitpoints, st.max_torp,
                   st.rof AS tp_rof, st.rof2 AS tp_rof2
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
    $punch_estimate = 0;
    $primary_avg    = 0;
    $secondary_avg  = 0;
    $planetary_estimate = 0;
    $shield_estimate = 0;
    $strenght_estimate = 0;
    $fleet_speed = 10.0;

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

    if(isset($fleet['officer_id']) && !empty($fleet['officer_id'])){$off_flag = true;} else {$off_flag = false;}
        
    while($s_ship = $db->fetchrow($q_ships)) {
        if($s_ship['value_10'] < $fleet_speed) {$fleet_speed = $s_ship['value_10'];}
        // $primary   = (int)((($s_ship['value_1'] + $s_ship['value_1']*($s_ship['experience']/1000)*0.25) / 1.075) * $s_ship['tp_rof']);
        $primary = (((($s_ship['value_1']/2) * (0.85 + ((int)$s_ship['rating_1a'] * 0.005))) + 
                        (($s_ship['value_1']/2) * (0.85 + ((int)$s_ship['rating_1b'] * 0.005))) +
                        $s_ship['value_1']*($s_ship['experience']/1000))*0.25) * $s_ship['tp_rof'];        
        if($s_ship['ship_torso'] > 2 && $s_ship['torp'] > 0) {
            // $secondary = (int)((($s_ship['value_2'] + $s_ship['value_2']*($s_ship['experience']/500)*0.4) / 1.075) * $s_ship['tp_rof2']);
            $secondary = (((($s_ship['value_2']/2) * (0.85 + ((int)$s_ship['rating_2a'] * 0.005))) + 
                              (($s_ship['value_2']/2) * (0.85 + ((int)$s_ship['rating_2b'] * 0.005))) +
                               $s_ship['value_2']*($s_ship['experience']/1000))*0.40) * $s_ship['tp_rof2'];            
        }
        else {
            $secondary = 0;
        }
        if($s_ship['ship_torso'] > 2) {
            if($s_ship['value_2'] > 0) {$ammo_ratio = (int)($s_ship['torp']*100/$s_ship['max_torp']);} else {$ammo_ratio = 100;}
        }
        else {
            $ammo_ratio = 100;
        }        
        $punch_estimate    += $primary + $secondary;
        $primary_avg       += $primary;
        $secondary_avg     += $secondary;
        $planetary_estimate += $s_ship['value_3'];
        $shield_estimate   += $s_ship['value_4'];
        $strenght_estimate += $s_ship['hitpoints'];        
        /* 07/04/08 - AC: If present, show also ship's name */
        $new_id = $s_ship['max_hitpoints']-$s_ship['hitpoints'] + (($s_ship['ship_torso'] > 2 && $ammo_ratio < $thereshold_ammo_ratio) ? 100000 : 0);
        $ships_option_html .= '<option id="'.$new_id.'" value="'.$s_ship['ship_id'].'">'.(($s_ship['ship_name'] != '')? $s_ship['template_name'].' - '.$s_ship['ship_name'] : $s_ship['template_name']).(!empty($s_ship['ship_ncc']) ? ' ['.$s_ship['ship_ncc'].'] ' : '').' ('.$s_ship['hitpoints'].'/'.$s_ship['max_hitpoints'].', Torp: '.($s_ship['ship_torso'] < 3 || $s_ship['value_2'] == 0 ? 'n/a' : $s_ship['torp']).', Exp: '.$s_ship['experience'].', Warp: '.$s_ship['value_10'].', AT: '.($s_ship['awayteam'] == 0 ? 'OnDuty' : intval($s_ship['awayteam'])).')</option>';

        if($s_ship['ship_torso'] == SHIP_TYPE_TRANSPORTER) $n_transporter++;

        $torso_counter[$s_ship['ship_torso']]++;
        $class_counter[$s_ship['ship_class']]++;

        if($s_ship['max_hitpoints'] == $s_ship['hitpoints'])
            $damage_counter[0]++;
        else {
            $damage_counter[1]++;
            $dmg_ratio = (int)($s_ship['hitpoints']*100/$s_ship['max_hitpoints']);
            if($dmg_ratio < 25) $damage_counter[3]++; 
            if($dmg_ratio < 50) $damage_counter[2]++; 
        }

        if($ammo_ratio == 100 || $s_ship['ship_torso'] < 3)
            $depleted_counter[0]++;
        else {
            if($ammo_ratio < $thereshold_ammo_ratio)
                $depleted_counter[2]++;
            else
                $depleted_counter[1]++;
        }

        $n_ships++;
    }

    $primary_avg   = (int)($primary_avg / $n_ships);
    $secondary_avg = (int)($secondary_avg / $n_ships);
    
    $analyze_string  = '<i>'.constant($game->sprache("TEXT111")).':</i> '.(int)$punch_estimate.'<br><i>'.constant($game->sprache("TEXT114")).':</i> '.$primary_avg.'<br><i>'.constant($game->sprache("TEXT115")).':</i> '.$secondary_avg.'<br><i>'.constant($game->sprache("TEXT127")).':</i> '.$planetary_estimate.'<br>';
    $analyze_string .= '<i>'.constant($game->sprache("TEXT112")).':</i> '.$shield_estimate.'<br><i>'.constant($game->sprache("TEXT113")).':</i> '.$strenght_estimate;    
    
    foreach($torso_counter as $key => $torso)
    {
        if($torso == 0) continue;
        // $torso_string_counter .= $SHIP_TORSO[$game->player['user_race']][$key][29].' <b>'.$torso.'</b><br>';
        $torso_string_counter .= $ship_torso[$key].' <b>'.$torso.'</b><br>';	
    }

    $damage_string_counter .= constant($game->sprache("TEXT92")).' <b>'.$damage_counter[0].'</b>';

    if($damage_counter[1]>0) $damage_string_counter .= '<br>'.constant($game->sprache("TEXT93")).' <b>'.$damage_counter[1].'</b> '.constant($game->sprache("TEXT94")).' <b>'.$damage_counter[2].'</b><br>'.constant($game->sprache("TEXT95")).' <b>'.$damage_counter[3].'</b>';

    $depleted_string .= constant($game->sprache("TEXT96")).' <b>'.$depleted_counter[0].'</b><br>'.constant($game->sprache("TEXT97")).' <b>'.$depleted_counter[1].'</b><br>'.constant($game->sprache("TEXT98")).' <b>'.$depleted_counter[2].'</b>';    
    
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
    $arrival_sd_str = sprintf('%.1f', ($game->config['stardate'] + $ticks_left / 10));

    if(!$fleet['is_civilian']){
        $ap_green_str = ($fleet['alert_phase'] == ALERT_PHASE_GREEN) ? '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_GREEN.'&move').'">'.constant($game->sprache("TEXT9")).'</a>]';
        $ap_yellow_str = ($fleet['alert_phase'] == ALERT_PHASE_YELLOW) ? '[<span style="color: #FFFF00;">'.constant($game->sprache("TEXT10")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_YELLOW.'&move').'">'.constant($game->sprache("TEXT10")).'</a>]';
        $ap_red_str = ($fleet['alert_phase'] == ALERT_PHASE_RED) ? '[<span style="color: #FF0000;">'.constant($game->sprache("TEXT11")).'</span>]' : '[<a href="'.parse_link('a=ship_fleets_ops&set_alert_phase='.$fleet_id.'&to='.ALERT_PHASE_RED.'&move').'">'.constant($game->sprache("TEXT11")).'</a>]';
    }
    else{
        $ap_green_str = '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]';
        $ap_yellow_str = '[<i>'.constant($game->sprache("TEXT10")).'</i>]';
        $ap_red_str = '[<i>'.constant($game->sprache("TEXT11")).'</i>]';
    }


    // Anfang lesen Homebase Koords

    $planet_id = $fleet['homebase'];

    $sql = 'SELECT * FROM planets WHERE planet_id = '.$planet_id;

    $planet_koords = $db->queryrow($sql);

    $system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$planet_koords['system_id']);

    // Ende lesen Homebasekoords

    $rerouted = ($fleet['move_rerouted'] == 1);

    $divert_text = '';

    if(!$rerouted){
        if($fleet['start_system_id'] != $fleet['dest_system_id']) {
            $sql = 'SELECT p.planet_distance_id , p.planet_id, p.planet_name, p.planet_type
                    FROM (planets p)
                    WHERE p.system_id = '.$fleet['dest_system_id'].' AND p.planet_distance_id > '.$fleet['dest_distance_id'].'
                    ORDER BY p.planet_distance_id ASC LIMIT 0,2';            
        }
        elseif($fleet['start_distance_id'] > $fleet['dest_distance_id']) {
            $sql = 'SELECT p.planet_distance_id , p.planet_id, p.planet_name, p.planet_type
                    FROM (planets p)
                    WHERE p.system_id = '.$fleet['dest_system_id'].' AND p.planet_distance_id < '.$fleet['start_distance_id'].' AND p.planet_distance_id > '.$fleet['dest_distance_id'].'
                    ORDER BY p.planet_distance_id ASC LIMIT 0,2';            
        }
        else {
            $sql = 'SELECT p.planet_distance_id , p.planet_id, p.planet_name, p.planet_type
                    FROM (planets p)
                    WHERE p.system_id = '.$fleet['dest_system_id'].' AND p.planet_distance_id > '.$fleet['start_distance_id'].' AND p.planet_distance_id < '.$fleet['dest_distance_id'].'
                    ORDER BY p.planet_distance_id ASC LIMIT 0,2';            
        }

        $q_divert = $db->queryrowset($sql);

        if($db->num_rows() > 0) {
            foreach ($q_divert AS $divert_item){
                $divert_text .= '<tr><td width="60%">Nuova rotta: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($divert_item['planet_id'])).'"><b>'.( isset($fleet['dest_tmsmp']) ? $divert_item['planet_name'] : constant($game->sprache("TEXT56")) ).'</b></a> ('.$game->get_sector_name($fleet['dest_sector']).':'.$game->get_system_cname($fleet['dest_system_x'], $fleet['dest_system_y']).':'.($divert_item['planet_distance_id'] + 1).') 
                    </td><td width="40%"><input class="button" style="width: 75px;" type="submit" value="ATTIVARE" onClick="document.fleet_form.tswarp.value = 1; return document.fleet_form.action = \''.parse_link_ex('a=ship_fleets_display&mfleet_details='.$fleet_id,LINK_CLICKID).'\'"></td></tr>';
            }
            
        }
    }    

    $game->out('
<table width="590px" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="2" class="style_inner">
  <form name="fleet_form" method="post" action="">
  <input type="hidden" name="user_id"   value="">
  <input type="hidden" name="planet_id" value="'.$fleet['dest'].'">
  <input type="hidden" name="mode_id" value="3">
  <input type="hidden" name="alert_phase" value="">
  <input type="hidden" name="note" value="">
  <input type="hidden" name="fleets[]" value="'.$fleet_id.'">
  <input type="hidden" name="bell_value" value="'.$fleet['trip_bell'].'">
  <input type="hidden" name="bell_action" value="">
  <input type="hidden" name="report_value" value="'.$fleet['officer_lookout_report'].'">
  <input type="hidden" name="report_action" value="">  
  <tr>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70%" align="left">[<a href="'.parse_link('a=ship_fleets_display').'">'.constant($game->sprache("TEXT12")).'</a>]&nbsp;&nbsp;&nbsp;<input class="field" type="text" name="fleet_name" value="'.$fleet['fleet_name'].'" maxlength="20" size="25">&nbsp;<input type="submit" class="button_nosize" name="rename_fleet_submit" value="'.constant($game->sprache("TEXT13")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&rename_fleet='.$fleet_id).'\'"></td>
          <td width="10%" align="right">'.($fleet['user_id'] == UNDISCLOSED_USERID ? 'ID: mask' : 'ID: norm').'</td>
          <td width="10%" align="right">&nbsp;</td>
          <td width="10%" align="right">'.( ($n_ships == 1) ? '<b>1</b> '.constant($game->sprache("TEXT14")) : '<b>'.$n_ships.'</b> '.constant($game->sprache("TEXT15")) ).'</td>
        </tr>
      </table><br>
      <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT105")).':</span></legend>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr><td width="60%">'.constant($game->sprache("TEXT55")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['start'])).'"><b>'.( isset($fleet['start_tmsmp']) ? $fleet['start_planet_name'] : constant($game->sprache("TEXT56")) ).'</b></a> ('.$game->get_sector_name($fleet['start_sector']).':'.$game->get_system_cname($fleet['start_system_x'], $fleet['start_system_y']).':'.($fleet['start_distance_id'] + 1).')</td>
      <td width="40%">'.constant($game->sprache("TEXT57")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['dest'])).'"><b>'.( isset($fleet['dest_tmsmp']) ? $fleet['dest_planet_name'] : constant($game->sprache("TEXT56")) ).'</b></a> ('.$game->get_sector_name($fleet['dest_sector']).':'.$game->get_system_cname($fleet['dest_system_x'], $fleet['dest_system_y']).':'.($fleet['dest_distance_id'] + 1).')</td></tr>
      <tr><td width="60%">&nbsp;</td>
      <td width="40%">'.constant($game->sprache("TEXT132")).': '.($fleet['total_distance'] > 0 ? '<b>'.(int)$fleet['total_distance'].' AU</b>' : constant($game->sprache("TEXT132_2"))).' ('.constant($game->sprache("TEXT132_1")).': '.($fleet['total_distance'] > 0 ? '<b>'.(int)$fleet['remaining_distance'].' AU</b>' : 'n/a').')</td></tr>
      <tr><td width="60%">'.constant($game->sprache("TEXT58")).' <b>'.get_move_action_str($fleet['action_code']).'</td>
      <td width="40%">'.constant($game->sprache("TEXT59")).' <b id="timer2" title="time1_'.( ($ticks_left * TICK_DURATION * 60) + $NEXT_TICK).'_type2_2">&nbsp;</b> ('.$arrival_sd_str.') '.($fleet['total_distance'] > 0 ? '@W.S.<b>'.$fleet['warp_speed'].'</b>' : '@<b>I.S.</b>').'
      </td></tr>');
    if(!empty($divert_text) && $ticks_left == 2) {
        $game->out($divert_text);
    }
      $game->out('
      <tr><td width="60%">'.constant($game->sprache("TEXT18")).' '.$ap_green_str.'&nbsp;'.$ap_yellow_str.'&nbsp;'.$ap_red_str.'</td>
      <td width="40%">[<a href="'.parse_link('a=tactical_moves&move_id='.$fleet['move_id']).'" '.($ticks_left <= 2 ? 'disabled="disabled"' : '').'>'.constant($game->sprache("TEXT60")).'</a>]
            '.($off_flag && $game->player['user_tsw_timeout'] == 0 && $ticks_left > 7 && $ticks_left <= MAX_TRANSWARP_RANGE && ($fleet['action_code'] == 11 || $fleet['action_code'] == 13 || $fleet['action_code'] == 21) ? '<input type="hidden" name="tswarp" value="0"><input type="hidden" name="tsfleet" value="'.$fleet_id.'"><input class="button" style="width: 75px;" type="submit" value="'.constant($game->sprache("TEXT128")).'" onClick="document.fleet_form.tswarp.value = 1; return document.fleet_form.action = \''.parse_link_ex('a=ship_fleets_display&mfleet_details='.$fleet_id,LINK_CLICKID).'\'">' : '').'
      </td></tr></table>');            
    if($off_flag){
        $game->out('<input type="hidden" name="combat_level_officer" value='.$fleet['officer_id'].'>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
                    <td width="60%">'.constant($game->sprache("TEXT122")).' ('.$fleet['combat_lvl'].'): '.constant($game->sprache("TEXT117_".$fleet['combat_lvl'])).'</td>
                    <td width="40%"><select name="combat_level">
                        <option'.( ($fleet['combat_lvl'] == 3) ? ' selected="selected"' : '').'>3</option>
                        <option'.( ($fleet['combat_lvl'] == 2) ? ' selected="selected"' : '').'>2</option>
                        <option'.( ($fleet['combat_lvl'] == 1) ? ' selected="selected"' : '').'>1</option>
                        <option'.( ($fleet['combat_lvl'] == 0) ? ' selected="selected"' : '').'>0</option>
                   </select>
                   <input class="button" style="width: 50px;" type="submit" value="'.constant($game->sprache("TEXT118")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id).'\'"></td>
                   </tr>
                   <tr>
                   <td width=60%>'.constant($game->sprache("TEXT122")).' ('.$fleet['combat_lvl_2'].'): '.constant($game->sprache("TEXT123_".$fleet['combat_lvl_2'])).'</td>
                   <td width=40%><select name="combat_level_2">
                        <option'.( ($fleet['combat_lvl_2'] == 1) ? ' selected="selected"' : '').'>1</option>
                        <option'.( ($fleet['combat_lvl_2'] == 0) ? ' selected="selected"' : '').'>0</option>
                   </select>
                   <input class="button" style="width: 50px;" type="submit" value="'.constant($game->sprache("TEXT118")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id).'\'">
                   </td>
                   </tr>
                   <tr>
                   <td width=60%>'.constant($game->sprache("TEXT133")).'
                   <td width=40%><input class="button" style="width: 130px;" type="submit" name="toggle_report" onClick="document.fleet_form.report_action.value=1;" value="'.($fleet['officer_lookout_report'] ? '&#128276; '.constant($game->sprache("TEXT133_1")).' &#128276;' : '&#128277; '.constant($game->sprache("TEXT133_2")).' &#128277;').'">&nbsp;</td>                   
                   </tr>
                   </table>');
    }          
    $game->out('</fieldset><br><br>');

    if($ticks_left < 7) {
        /*
        $sql = 'SELECT f.user_id, SUM(f.n_ships) AS n_ships, u.user_name, u.user_race
                FROM (ship_fleets f)
                INNER JOIN (user u) ON u.user_id = f.user_id
                WHERE f.planet_id = '.$fleet['dest'].'
                GROUP BY f.user_id';
         * 
         */

        $sql = 'SELECT f.alert_phase,f.user_id, SUM(f.n_ships) AS n_ships, u.user_name, u.user_race
                FROM (ship_fleets f)
                INNER JOIN (user u) ON u.user_id = f.user_id
                WHERE f.planet_id = '.$fleet['dest'].'
                GROUP BY f.alert_phase, f.user_id
                ORDER BY f.alert_phase DESC';
        
        $q_sens = $db->queryrowset($sql);                
        
        if($db->num_rows() == 0) {$sensor_txt = constant($game->sprache("TEXT108"));}
        
        else {
            $sensor_detail = filter_input(INPUT_GET, 'sensor_id', FILTER_SANITIZE_NUMBER_INT);
            $sensor_alert  = filter_input(INPUT_GET, 'ap', FILTER_SANITIZE_NUMBER_INT);
            
            if($sensor_detail === false) {$sensor_detail = 0;}
            if($sensor_alert < 0 || $sensor_alert > 2) {$sensor_alert = 0;}
            
            $sensor_txt = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
            foreach ($q_sens AS $sensor_item) {
                if($sensor_item['user_id'] == $sensor_detail) {
                    $sql = 'SELECT f.alert_phase, st.ship_torso, st.race, COUNT(s.ship_id) AS n_ships
                            FROM (ship_templates st, ship_fleets f, ships s)
                            WHERE f.planet_id = '.$fleet['dest'].' AND
                                  f.user_id = '.$sensor_item['user_id'].' AND
                                  f.alert_phase = '.$sensor_alert.' AND
                                  s.template_id = st.id AND
                                  s.fleet_id = f.fleet_id
                            GROUP BY f.alert_phase, st.ship_torso, st.race
                            ORDER BY st.race ASC';

                    if(!$q_torsos = $db->queryrowset($sql)) {
                        message(DATABASE_ERROR, 'Could not query ship torso data');
                    }

                    $detail_link = '';
                    $detail_symbol = '&lt;';
                }
                else {
                    $detail_link = '&sensor_id='.$sensor_item['user_id'].'&ap='.$sensor_item['alert_phase'];
                    $detail_symbol = '&gt;';
                }
                
                switch($sensor_item['alert_phase']) {
                    case 0: $detail_color = '#00FF00';
                        break;
                    case 1: $detail_color = '#FFFF00';
                        break;
                    case 2: $detail_color = '#FF0000';
                        break;
                }
                $detail_alert = '<span style="color:'.$detail_color.';">&Lambda;</span>';
                $sensor_txt .= '<tr><td colspan=4 align="center"><b>'.constant($game->sprache("TEXT67")).'</b></td></tr>';
                $sensor_txt .= '<tr>
                    <td width="200" align="center"><img src="'.$game->PLAIN_GFX_PATH.'fleet_'.$sensor_item['user_race'].'.gif" border="0"></td>
                    <td width="100">'.$detail_alert.' <i>'.( ($sensor_item['n_ships'] == 1) ? constant($game->sprache("TEXT109")) : $sensor_item['n_ships'].' '.constant($game->sprache("TEXT110")) ).'</i> [<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet['fleet_id'].$detail_link).'">'.$detail_symbol.'</a>] ';
                $memo_to_add_txt = '=== \n('.$game->get_sector_name($fleet['dest_sector']).':'.$game->get_system_cname($fleet['dest_system_x'], $fleet['dest_system_y']).':'.($fleet['dest_distance_id'] + 1).') <i>'.( ($sensor_item['n_ships'] == 1) ? constant($game->sprache("TEXT109")) : $sensor_item['n_ships'].' '.constant($game->sprache("TEXT110")) ).'</i> '.$sensor_item['user_name'].' \n';
                foreach ($q_torsos AS $torso_item) {
                    if($torso_item['alert_phase'] == $sensor_alert) {
                        $memo_to_add_txt .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$torso_item['n_ships'].' '.$SHIP_TORSO[$torso_item['race']][$torso_item['ship_torso']][29].' <i>('.$RACE_DATA[$torso_item['race']][0].'</i>) \n';                        
                    }
                }
                $memo_to_add_txt .= '===\n';                
                $sensor_txt .= '</td><td width="100"><a href="'.parse_link('a=stats&a2=viewplayer&id='.$sensor_item['user_id']).'">'.$sensor_item['user_name'].'</a></td>';
                $sensor_txt .= '<td width="250" align="left">';
                if($sensor_item['alert_phase'] != 2) {
                    $sensor_txt .=  '<input type="image" src="'.$game->GFX_PATH.'tc_analyze.gif" title="'.constant($game->sprache("TEXT124")).'" onClick="document.fleet_form.alert_phase.value = '.$sensor_item['alert_phase'].'; document.fleet_form.user_id.value = '.$sensor_item['user_id'].'; return document.fleet_form.action = \''.parse_link('a=tactical_analyze').'\';"> ';
                }                
                $sensor_txt .= '<input type="image" src="'.$game->GFX_PATH.'tc_takenote.gif" onClick="document.fleet_form.note.value = \''.$memo_to_add_txt.'\'; return document.fleet_form.action = \''.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&add_clip=1').'\';">';                
                $sensor_txt .= '</td></tr>';
                if($sensor_item['user_id'] == $sensor_detail && $sensor_item['alert_phase'] == $sensor_alert) {
                    $sensor_txt .= '<tr><td>&nbsp;</td><td colspan="3">';

                    foreach ($q_torsos AS $torso_item) {
                        if($torso_item['alert_phase'] == $sensor_alert) {
                            $sensor_txt .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$torso_item['n_ships'].' '.$SHIP_TORSO[$torso_item['race']][$torso_item['ship_torso']][29].' <i>('.$RACE_DATA[$torso_item['race']][0].'</i>)<br>';
                        }                        
                    }
                    $sensor_txt .= '</td></tr>';
                }                
            }
            
            $sensor_txt .= '</table>';

        }

    }  
    else {
        $sensor_txt = constant($game->sprache("TEXT107"));
    }
    
   $game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT106")).':</span></legend>
              '.$sensor_txt.'</fieldset><br><br>');
        
    if($n_transporter > 0) {
        $n_resources = $fleet['resource_1'] + $fleet['resource_2'] + $fleet['resource_3'] + $fleet['resource_4'];
        $n_units = $fleet['unit_1'] + $fleet['unit_2'] + $fleet['unit_3'] + $fleet['unit_4'] + $fleet['unit_5'] + $fleet['unit_6'];

        $n_security = 0;
        $n_security = $fleet['unit_1']*2+$fleet['unit_2']*3+$fleet['unit_3']*4+$fleet['unit_4']*4; 

        $game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT88")).':</span></legend>');        
        
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

    if($off_flag) {
        
        $form_diff = abs($class_counter[0] - $n_ships*($fleet['optm_class_0']/100)) +
                     abs($class_counter[1] - $n_ships*($fleet['optm_class_1']/100)) +
                     abs($class_counter[2] - $n_ships*($fleet['optm_class_2']/100)) +
                     abs($class_counter[3] - $n_ships*($fleet['optm_class_3']/100));
        
        $eff_form= round(0.36 - (0.72 / $n_ships * $form_diff), 2, PHP_ROUND_HALF_DOWN);

        if($eff_form < -0.36) {$eff_form = -0.36;}            

        $eff_ratio = round(($eff_form*100 / 0.36), 2);

        if($eff_ratio < -100) {$eff_ratio = -100;}
        
        if($fleet['optimal'] != 0) {
            $color = ( ($fleet['optimal'] >= $n_ships) ? '#00FF00' : '#FF0000');
        }
        else {
            $color = '#00FF00';
        }        
        
        $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
        $game->out('
            <fieldset>
            <legend><span class="sub_caption2">'.constant($game->sprache("TEXT131")).':</span></legend>
            <div style="width:100%">
                <div style="position:relative; float:left; width:19%; border: 1px solid;">
                    <img src="'.$game->PLAIN_GFX_PATH.'officer_'.$fleet['officer_race'].'.gif" alt="faccione" height="140" width="100">
                </div>
                <div style="position:relative; float:left; width:25%; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td width=20><img src="'.$game->PLAIN_GFX_PATH.'officer_rank_'.$fleet['officer_rank'].'.png" alt="rank" height="20" width="20"></td>
                        <td width=20 align=center><b>'.$fleet['officer_level'].'</b></td>
                        <td align=center>'.$fleet['officer_name'].'</td>
                    </tr>');
        /*
        $game->out('</table>
                    <table width=50% align=left style="border-top-style: dotted; border-top-width: 1px">');
                    for($i=0;$i<5;$i++){
                        if(isset($fleet['skill_'.$i]) && $fleet['skill_'.$i] == true) {
                            $game->out('<tr><td align=center>Label Skill '.($i+1).'</td></tr>');
                        }
                    }
            
        $game->out('</table>
                    <table width=50% align=right style="border-top-style: dotted; border-top-width: 1px">');
                    for($i=5;$i<10;$i++){
                        if(isset($fleet['skill_'.$i]) && $fleet['skill_'.$i] == true) {
                            $game->out('<tr><td align=center>Label Skill '.($i+1).'</td></tr>');
                        }
                    }
         * 
         */
        $game->out('</table>
                </div>
                <div style="position:relative; float:right; width:54%; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td>Battaglie Vinte</td><td width=40px align=right>'.$fleet['battle_victory'].'</td>
                        <td>Battaglie Perse</td><td width=40px align=right>'.$fleet['battle_defeat'].'</td>                    
                    <tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 1:</td>
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_1'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_1'].'</td>
                    </tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 2:</td>
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_2'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_2'].'</td>
                    </tr>
                    </table>                    
                    <table width=100%>
                    <tr>
                        <td width=45px>Class 3:</td>                    
                        <td>Distrutte</td><td width=60px align=right>'.$fleet['kill_class_3'].'</td>                                            
                        <td>Perse</td><td width=60px align=right>'.$fleet['lost_class_3'].'</td>
                    </tr>
                    </table>
                    <table>
                    <tr>
                        <td width=39px>E.C.:</td>
                        <td width=65px align=right><p style="color:'.$color.'">'.$n_ships.'/'.( ($fleet['optimal'] == 0) ? '&infin;' : $fleet['optimal']).'</td>                    
                        <td width=30px>Fleet:</td>
                        <td width=36px><b>Civ:</b>'.round(($class_counter[0]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>1:</b>'.round(($class_counter[1]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>2:</b>'.round(($class_counter[2]*100)/$n_ships,0).'&#37;</td>
                        <td width=36px><b>3:</b>'.round(($class_counter[3]*100)/$n_ships,0).'&#37;</td>
                    </tr>                    
                    <tr>
                        <td width=35px>E.F.:</td>
                        <td witdh=65px align=right><p style="color:'.($eff_ratio >= 0 ? '#00FF00' : '#FF0000').'">'.$eff_ratio.'&#37;</td>                    
                        <td width=30px>Optm:</td>
                        <td width=36px><b>Civ:</b>'.$fleet['optm_class_0'].'&#37;</td>
                        <td width=36px><b>1:</b>'.$fleet['optm_class_1'].'&#37;</td>
                        <td width=36px><b>2:</b>'.$fleet['optm_class_2'].'&#37;</td>
                        <td width=36px><b>3:</b>'.$fleet['optm_class_3'].'&#37;</td>
                    </tr>
                    </table>
                </div>
            </fieldset>
            <br><br>
        ');        
    }
    
    //DC --- Fleet composition panel
    $style = 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"';
    $game->out('
        <fieldset>
        <legend><a href="javascript:void(0)" onmouseover="return overlib(\''.$analyze_string.'\', CAPTION, \''.constant($game->sprache("TEXT116")).'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span class="sub_caption2">'.constant($game->sprache("TEXT89")).':</span></a>');
        if($game->player['user_auth_level'] == STGC_DEVELOPER) {
            $game->out('<input type="hidden" name="fleet_id" value="'.$fleet_id.'">
                        <input type="image" src="'.$game->GFX_PATH.'tc_analyze.gif" title="'.constant($game->sprache("TEXT116")).'" onClick="document.fleet_form.mode_id.value=2; return document.fleet_form.action = \''.parse_link('a=tactical_analyze').'\';">');
        }    
        $game->out('</legend>
        <div>
            <div style="position:relative; margin:auto; width:450">
            <table width=450 cellpadding=0 cellspacing=0 border=0>
              <tr>
                <td '.$style.' width=33% align=center>'.constant($game->sprache("TEXT31")).'</td>
                <td '.$style.' width=33% align=center>'.constant($game->sprache("TEXT99")).'</td>
                <td '.$style.' width=34% align=center>'.constant($game->sprache("TEXT100")).'</td>
              </tr>
              <tr>
                <td width=33% align=center>'.$torso_string_counter.'</td>
                <td width=33% align=center>'.$damage_string_counter.'</td>
                <td width=34% align=center>'.$depleted_string.'</td>
              </tr>
            </table>
            </div>
        </div>
      </fieldset>
      <br>');
    //DC ---    
    
    $select_size = ($n_ships < 4) ? ($n_ships + 3) : 8;

    $game->out('
      <br>
      <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT90")).':</span></legend>      
      <select name="ships[]" style="width: 410px;" size="'.$select_size.'" multiple="multiple">
      '.$ships_option_html.'
      </select>
      <br>
      '.constant($game->sprache("TEXT30")).' ['.( ($order_by == 'template') ? '<b>'.constant($game->sprache("TEXT31")).'</b>' : '<a 
href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=template').'">'.constant($game->sprache("TEXT31")).'</a>' ).']&nbsp;['.( ($order_by == 'torso') ? 
'<b>'.constant($game->sprache("TEXT32")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=torso').'">'.constant($game->sprache("TEXT32")).'</a>' ).']&nbsp;['.( ($order_by == 'experience') ? '<b>'.constant($game->sprache("TEXT33")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=experience').'">'.constant($game->sprache("TEXT33")).'</a>' ).']&nbsp;['.( ($order_by == 'construction_time') ? '<b>'.constant($game->sprache("TEXT34")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=construction_time').'">'.constant($game->sprache("TEXT34")).'</a>' ).']&nbsp;['.( ($order_by == 'warp') ? '<b>'.constant($game->sprache("TEXT35")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=warp').'">'.constant($game->sprache("TEXT35")).'</a>' ).']&nbsp;['.( ($order_by == 'name') ? '<b>'.constant($game->sprache("TEXT36")).'</b>' : '<a href="'.parse_link('a=ship_fleets_display&mfleet_details='.$fleet_id.'&order_by=name').'">'.constant($game->sprache("TEXT36")).'</a>' ).']
      <br><br>
      <input class="button" style="width: 220px;" type="submit" name="ship_details" value="'.constant($game->sprache("TEXT37")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&ship_details').'\'">
      </fieldset>          
      <br><br>
      <fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT91")).':</span></legend>      
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

         <td width="250">&nbsp;&nbsp;</td>
         
         <td width="200"><input class="button" style="width: 130px;" type="submit" name="toggle_bell" onClick="document.fleet_form.bell_action.value=1;" value="'.($fleet['trip_bell'] ? '&#128276; '.constant($game->sprache("TEXT129")).' &#128276;' : '&#128277; '.constant($game->sprache("TEXT129_1")).' &#128277;').'">&nbsp;</td>

       <tr>

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
      </fieldset>      
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

        $sql = 'SELECT fleet_id, fleet_name, planet_id, move_id, n_ships, alert_phase, homebase, is_civilian
                FROM ship_fleets
                WHERE owner_id = '.$game->player['user_id'].' AND
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

        $sql = 'SELECT f.fleet_id, f.user_id, f.fleet_name, f.planet_id, f.n_ships, f.alert_phase, f.homebase, f.is_civilian,

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

                WHERE f.owner_id = '.$game->player['user_id'].'
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

        $sql = 'SELECT f.fleet_id, f.user_id, f.fleet_name, f.planet_id, f.move_id, f.n_ships, f.alert_phase, f.homebase, f.is_civilian,
                       p.planet_name, p.sector_id, p.planet_distance_id, p.planet_type,
                       s.system_x, s.system_y,
                       u.user_id, u.user_name
                FROM (ship_fleets f)
                INNER JOIN (planets p) ON p.planet_id = f.planet_id
                INNER JOIN (starsystems s) ON s.system_id = p.system_id
                LEFT JOIN (user u) ON u.user_id = p.planet_owner
                WHERE f.owner_id = '.$game->player['user_id'].' AND
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

        $sql = 'SELECT f.fleet_id, f.user_id, f.fleet_name, f.planet_id, f.n_ships, f.alert_phase, f.homebase, f.is_civilian,
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

                WHERE f.owner_id = '.$game->player['user_id'].' AND
                      f.move_id <> 0
                ORDER BY '.$order_by_str;

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleets data');
        }
    }
    else {
        message(NOTICE, 'Nice try...');
    }

    display_fleets_map();

    $game->out('
<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table class="style_inner" width="100%" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
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
            WHERE f.owner_id = '.$game->player['user_id'].' AND
                  f.planet_id <> 0 AND
                  p.planet_id = f.planet_id
            GROUP BY f.planet_id, f.alert_phase, f.homebase
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
                // 11/11/13 - DC: New FoW Implementation
                $sql = 'SELECT timestamp FROM starsystems_details sd INNER JOIN planets p USING ( system_id )
                        WHERE p.planet_id = '.$fleet['start'].' AND sd.user_id = '.$game->player['user_id'];
                if((($_temp = $db->queryrow($sql)) == true) && (!empty($_temp['timestamp']))) {
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
                // 11/11/13 - DC: New FoW Implementation                
                $sql = 'SELECT timestamp FROM starsystems_details sd INNER JOIN planets p USING ( system_id )
                        WHERE p.planet_id = '.$fleet['dest'].' AND sd.user_id = '.$game->player['user_id'];                        
                if((($_temp = $db->queryrow($sql)) == true) && (!empty($_temp['timestamp']))) {
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

        if($fleet['is_civilian'] == false) {
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
        }
        else {
            $output_phase = '[<span style="color: #00FF00;">'.constant($game->sprache("TEXT9")).'</span>]';
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
      <td><a href="'.parse_link('a=ship_fleets_display&'.( ($fleet['planet_id']) ? 'p' : 'm' ).'fleet_details='.$fleet['fleet_id']).'">'.($fleet['user_id'] != UNDISCLOSED_USERID ? $fleet['fleet_name'] : '<i>'.$fleet['fleet_name'].'</i>').'</a></td>
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
