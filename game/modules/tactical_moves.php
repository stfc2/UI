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
$game->out('<center><span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">'.constant($game->sprache("TEXT1")).'</a>]&nbsp;&nbsp;[<b>'.constant($game->sprache("TEXT2")).'</b>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">'.constant($game->sprache("TEXT3")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">'.constant($game->sprache("TEXT4")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_known').'">'.constant($game->sprache("TEXT4a")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">'.constant($game->sprache("TEXT5")).'</a>]</center><br>');

$move_id = $start = $dest = 0;

$move_id = (!empty($_GET['move_id'])) ? (int)$_GET['move_id'] : 0;
$start = (!empty($_GET['start'])) ? (int)$_GET['start'] : 0;

if(!empty($_GET['dest'])) {
	$dest = (is_numeric($_GET['dest'])) ? (int)$_GET['dest'] : decode_planet_id($_GET['dest']);
}

$sql = 'SELECT ss.*,
			   p1.planet_name AS start_planet_name,
			   u1.user_id AS start_owner_id, u1.user_name AS start_owner_name,
			   p2.planet_name AS dest_planet_name,
			   u2.user_id AS dest_owner_id, u2.user_name AS dest_owner_name
		FROM (scheduler_shipmovement ss)
		INNER JOIN (planets p1) ON p1.planet_id = ss.start
		LEFT JOIN (user u1) ON u1.user_id = p1.planet_owner
		INNER JOIN (planets p2) ON p2.planet_id = ss.dest
		LEFT JOIN (user u2) ON u2.user_id = p2.planet_owner
		WHERE ss.user_id = '.$game->player['user_id'].' AND
			  ss.move_begin <= '.$ACTUAL_TICK.' AND
			  ss.move_status = 0'.
			  ( ($move_id) ? ' AND ss.move_id = '.$move_id : '' ).
              ( ($start) ? ' AND ss.start = '.$start : '' ).
              ( ($dest) ? ' AND ss.dest = '.$dest : '' );
			  
if(!$q_moves = $db->query($sql)) {
	message(DATABASE_ERROR, 'Could not query moves data');
}

$n_moves = $db->num_rows($q_moves);

if($n_moves == 0) {
    if($start && $dest) {
        message(NOTICE, constant($game->sprache("TEXT6")));
    }
    else {
        message(NOTICE, constant($game->sprache("TEXT7")));
    }
}

$sql = 'SELECT *
		FROM ship_fleets
		WHERE user_id = '.$game->player['user_id'].' AND
			  move_id <> 0';
			  
if(!$q_fleets = $db->query($sql)) {
	message(DATABASE_ERROR, 'Could not query fleets data');
}

$fleets_by_move = $wares_by_move = array();

while($fleet = $db->fetchrow($q_fleets)) {
    $move_id = $fleet['move_id'];

	if(!isset($fleets_by_move[$move_id])) $fleets_by_move[$move_id] = array();
	
	$fleets_by_move[$move_id][] = array($fleet['fleet_id'], $fleet['fleet_name'], $fleet['n_ships']);
	
	if($fleet['resource_1'] > 0) {
	    if(!isset($wares_by_move[$move_id][0])) $wares_by_move[$move_id][0] = $fleet['resource_1'];
	    else $wares_by_move[$move_id][0] += $fleet['resource_1'];
    }
    
	if($fleet['resource_2'] > 0) {
	    if(!isset($wares_by_move[$move_id][1])) $wares_by_move[$move_id][1] = $fleet['resource_2'];
	    else $wares_by_move[$move_id][1] += $fleet['resource_2'];
    }
    
	if($fleet['resource_3'] > 0) {
	    if(!isset($wares_by_move[$move_id][2])) $wares_by_move[$move_id][2] = $fleet['resource_3'];
	    else $wares_by_move[$move_id][2] += $fleet['resource_3'];
    }
    
	if($fleet['resource_4'] > 0) {
	    if(!isset($wares_by_move[$move_id][3])) $wares_by_move[$move_id][3] = $fleet['resource_4'];
	    else $wares_by_move[$move_id][3] += $fleet['resource_4'];
    }
    
	if($fleet['unit_1'] > 0) {
	    if(!isset($wares_by_move[$move_id][4])) $wares_by_move[$move_id][4] = $fleet['unit_1'];
	    else $wares_by_move[$move_id][4] += $fleet['unit_1'];
    }
	if($fleet['unit_2'] > 0) {
	    if(!isset($wares_by_move[$move_id][5])) $wares_by_move[$move_id][5] = $fleet['unit_2'];
	    else $wares_by_move[$move_id][5] += $fleet['unit_2'];
    }
    
	if($fleet['unit_3'] > 0) {
	    if(!isset($wares_by_move[$move_id][6])) $wares_by_move[$move_id][6] = $fleet['unit_3'];
	    else $wares_by_move[$move_id][6] += $fleet['unit_3'];
    }

	if($fleet['unit_4'] > 0) {
	    if(!isset($wares_by_move[$move_id][7])) $wares_by_move[$move_id][7] = $fleet['unit_4'];
	    else $wares_by_move[$move_id][7] += $fleet['unit_4'];
    }
    
	if($fleet['unit_5'] > 0) {
	    if(!isset($wares_by_move[$move_id][8])) $wares_by_move[$move_id][8] = $fleet['unit_5'];
	    else $wares_by_move[$move_id][8] += $fleet['unit_5'];
    }
    
	if($fleet['unit_6'] > 0) {
	    if(!isset($wares_by_move[$move_id][9])) $wares_by_move[$move_id][9] = $fleet['unit_6'];
	    else $wares_by_move[$move_id][9] += $fleet['unit_6'];
    }
}

// Fr die Ankunftstimer
$i = 2;

while($move = $db->fetchrow($q_moves)) {
	$move_id = $move['move_id'];
	
	$n_fleets = count($fleets_by_move[$move_id]);
	
	if($n_fleets == 0) {
		message(GENERAL, constant($game->sprache("TEXT8")), '$n_fleets[$move[\'move_id\']] = empty');
	}
	
	$game->out('
<table class="style_inner" width="450" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=ship_fleets_display&mfleet_details').'">
  <tr>
	<td>
	');
	
	if($move['start'] == $move['dest']) {
		if(empty($move['start_owner_id'])) $start_owner_str = ' <i>'.constant($game->sprache("TEXT9")).'</i>';
		elseif($move['start_owner_id'] != $game->player['user_id']) $start_owner_str = ' '.constant($game->sprache("TEXT10")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['start_owner_id']).'"><b>'.$move['start_owner_name'].'</b></a>';
		else $start_owner_str = '';
		
		$game->out(constant($game->sprache("TEXT11")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($move['start'])).'"><b>'.$move['start_planet_name'].'</b></a>'.$start_owner_str.'<br>');
	}
	else {
		if(empty($move['start_owner_id'])) $start_owner_str = ' <i>'.constant($game->sprache("TEXT9")).'</i>';
		elseif($move['start_owner_id'] != $game->player['user_id']) $start_owner_str = ' '.constant($game->sprache("TEXT10")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['start_owner_id']).'"><b>'.$move['start_owner_name'].'</b></a>';
		else $start_owner_str = '';
		
	    if(empty($move['dest_owner_id'])) $dest_owner_str = ' <i>'.constant($game->sprache("TEXT9")).'</i>';
		elseif($move['dest_owner_id'] != $game->player['user_id']) $dest_owner_str = ' '.constant($game->sprache("TEXT10")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['dest_owner_id']).'"><b>'.$move['dest_owner_name'].'</b></a>';
		else $dest_owner_str = '';
		
		$game->out(constant($game->sprache("TEXT12")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($move['start'])).'"><b>'.$move['start_planet_name'].'</b></a>'.$start_owner_str.'<br>
	  '.constant($game->sprache("TEXT13")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($move['dest'])).'"><b>'.$move['dest_planet_name'].'</b></a>'.$dest_owner_str.'<br>
		');
	}
	
	$game->out('
	  <br>
	  <select name="fleets[]" style="width: 200px;">
	');
	
	for($j = 0; $j < $n_fleets; ++$j) {
		$game->out('<option value="'.$fleets_by_move[$move_id][$j][0].'">'.$fleets_by_move[$move_id][$j][1].' ('.$fleets_by_move[$move_id][$j][2].')</option>');
	}
	
	$ticks_left = $move['move_finish'] - $ACTUAL_TICK;
	if($ticks_left < 0) $ticks_left = 0;
	
	$game->out('
	  </select>&nbsp;&nbsp;<input class="button" type="submit" name="fleet_details" value="'.constant($game->sprache("TEXT14")).'">
	  <br><br>
	  '.constant($game->sprache("TEXT15")).' <b>'.get_move_action_str($move['action_code']).'</b><br>
	  '.constant($game->sprache("TEXT16")).' '.( ($i < 10) ? '<b id="timer'.$i.'" title="time1_'.( ($ticks_left * TICK_DURATION * 60) + $NEXT_TICK).'_type2_2">&nbsp;</b>' : format_time( $ticks_left * TICK_DURATION ) ).'
      <br><br>
    ');
    
    switch($move['action_code']) {
        case 51:
            $action_data = unserialize($move['action_data']);
            
            if(empty($action_data[0])) $game->out('Error! $action_data[0] = empty<br><br>');
            
            $user_id = (int)$action_data[0];
            
            if($user_id == $move['start_owner_id']) {
                $game->out(constant($game->sprache("TEXT17")));
            }
            else {
                $game->out(constant($game->sprache("TEXT18")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_id).'"><b>'.$game->uc_get($user_id).'</b></a><br><br>');
            }
        break;
        
        case 44:
        case 54:
            $action_data = unserialize($move['action_data']);
            
            $focus = (int)$action_data[0];
            
            switch($focus) {
                case 1: $game->out(constant($game->sprache("TEXT19"))); break;
                case 2: $game->out(constant($game->sprache("TEXT20"))); break;
                case 3: $game->out(constant($game->sprache("TEXT21"))); break;
            }
        break;
    }

    if($move['action_code'] == 13) {
        $game->out('[<a href="'.parse_link('a=ship_moves_cmd&restore_orders='.$move_id).'">'.constant($game->sprache("TEXT22")).'</a>]&nbsp;');
    }
    if(!in_array($move['action_code'], array(12, 13, 32, 33))) {
        $game->out('[<a href="'.parse_link('a=ship_moves_cmd&call_back='.$move_id).'">'.constant($game->sprache("TEXT23")).'</a>]&nbsp;');
    }
    
    if(!empty($wares_by_move[$move_id])) {
        $game->out('<br>');
        
        if(!empty($wares_by_move[$move_id][0])) $game->out('<br>'.constant($game->sprache("TEXT24")).' <b>'.$wares_by_move[$move_id][0].'</b>');
        if(!empty($wares_by_move[$move_id][1])) $game->out('<br>'.constant($game->sprache("TEXT25")).' <b>'.$wares_by_move[$move_id][1].'</b>');
        if(!empty($wares_by_move[$move_id][2])) $game->out('<br>'.constant($game->sprache("TEXT26")).' <b>'.$wares_by_move[$move_id][2].'</b>');
        if(!empty($wares_by_move[$move_id][3])) $game->out('<br>'.constant($game->sprache("TEXT27")).' <b>'.$wares_by_move[$move_id][3].'</b>');
        if(!empty($wares_by_move[$move_id][4])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$wares_by_move[$move_id][4].'</b>');
        if(!empty($wares_by_move[$move_id][5])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$wares_by_move[$move_id][5].'</b>');
        if(!empty($wares_by_move[$move_id][6])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$wares_by_move[$move_id][6].'</b>');
        if(!empty($wares_by_move[$move_id][7])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$wares_by_move[$move_id][7].'</b>');
        if(!empty($wares_by_move[$move_id][8])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$wares_by_move[$move_id][8].'</b>');
        if(!empty($wares_by_move[$move_id][9])) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$wares_by_move[$move_id][9].'</b>');
    }
    
    $game->out('
    </td>
  </tr>
  </form>
</table>
<br>
	');
	
	++$i;
}

?>
