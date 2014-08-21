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

global $RACE_DATA, $SETL_EVENTS;

$game->init_player();

$operator1 = filter_input(INPUT_POST, 'link_planet', FILTER_SANITIZE_STRING);

$operator2 = filter_input(INPUT_POST, 'operation', FILTER_SANITIZE_STRING);

if((isset($operator1) && !empty($operator1)) && (isset($operator2) && !empty($operator2)))
{
    $sql = 'SELECT best_mood_user FROM planets WHERE planet_id = '.(int)decode_planet_id($operator1);
    if(!($cnt_q = $db->queryrow($sql))) {
        message(DATABASE_ERROR, 'Could not read linked planet data');
    }
    
    if($cnt_q['best_mood_user'] == $game->player['user_id']) {
        // Easy task: we grab the active planet and write it into the planets DB as linked player planet for settlers shipments
        if($operator2 == constant($game->sprache("TEXT16")))
        {
            $sql = 'UPDATE planets SET best_mood_planet = '.$game->player['active_planet'].' WHERE planet_owner = '.INDEPENDENT_USERID.' AND planet_id = '.(int)decode_planet_id($operator1);
        }
        else
        {
            $sql = 'UPDATE planets SET best_mood_planet = NULL WHERE planet_owner = '.INDEPENDENT_USERID.' AND planet_id = '.(int)decode_planet_id($operator1);
        }
    
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update settlers linked planet data');
        }
    }
    
    //redirect('a=settlers');
}

$operator3 = filter_input(INPUT_POST, 'selection', FILTER_SANITIZE_STRING);

if(isset($operator3)) {
    switch ($operator3) {
        case 1:
            $selection = 1;
            break;
        case 2:
            $selection = 2;
            break;
        case 3:
            $selection = 3;
            break;
        case 4:
            $selection = 4;
            break;
        default :
            $selection = 1;
    }
}
 else {
     $selection = 1;
}

$sub_action = filter_input(INPUT_POST, 'step', FILTER_SANITIZE_STRING);

if(!isset($sub_action) || empty($sub_action))
{
    $sub_action = constant($game->sprache("TEXT1"));
}

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');

$game->out('
    <table class="style_outer" width="400" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>
    <table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
    <form method="post" action="'.parse_link('a=settlers').'">
    <tr> 
    <td><input class="Button_nosize" type="submit" name="step" value="'.constant($game->sprache("TEXT1")).'"></td>
    <td><input class="Button_nosize" type="submit" name="step" value="'.constant($game->sprache("TEXT2")).'" '.($RACE_DATA[$game->player['user_race']][30] ? '' : 'disabled="disabled"').'></td>
    <td><input class="Button_nosize" type="submit" name="step" value="'.constant($game->sprache("TEXT3")).'"></td>
    <td><input class="Button_nosize" type="submit" name="step" value="'.constant($game->sprache("TEXT4")).'"></td>
    </tr>
    </form></table>
    </td></tr></table>');

if($sub_action == constant($game->sprache("TEXT2"))) {
    $game->out('
    <br><br><br>
    <center><span class="caption">'.(constant($game->sprache("TEXT2"))).':</span><br><br>
    <table class="style_outer" width="50%" align="center" border="0" cellpadding="2" cellspacing="2">
    <form name="controller" method="post" action="'.parse_link('a=settlers').'">
    <input type="hidden" name="link_planet">
    <input type="hidden" name="operation">
    <input type="hidden" name="selection" value="'.$selection.'">
    <tr><td>
    <table class="style_inner" width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <td width="60"><b>'.(constant($game->sprache("TEXT10"))).'</b></td>
    <td width="60"><b>'.(constant($game->sprache("TEXT11"))).'</b></td>
    <td width="30"><b>'.(constant($game->sprache("TEXT12"))).'</b></td>
    <td width="60"><b>'.(constant($game->sprache("TEXT23"))).'</b></td>
    <td width="60"><b>'.(constant($game->sprache("TEXT24"))).'</b></td>    
  </tr>');
    $sql = 'SELECT sr.planet_id, p.planet_name, p.planet_type, sr.mood_modifier, best_mood_user, user_name,
                   p.sector_id, ss.system_x, ss.system_y, p.planet_distance_id
            FROM settlers_relations sr 
            INNER JOIN planets p USING (planet_id)
            INNER JOIN starsystems ss on p.system_id = ss.system_id
            INNER JOIN user u ON p.best_mood_user = u.user_id 
            WHERE log_code = 30 AND sr.user_id = '.$game->player['user_id'];
    $q_p_setdiplo = $db->query($sql);
    $rows = $db->num_rows($q_p_setdiplo);
    if($rows > 0) {
        $sett_diplo = $db->fetchrowset($q_p_setdiplo);
        foreach ($sett_diplo as $founder_list) {
            $game->out('<tr>');
            // Name
            $game->out('<td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($founder_list['planet_id'])).'">'.$founder_list['planet_name'].'</a></td>');
            // Position
            $game->out('<td>'.$game->get_sector_name($founder_list['sector_id']).':'.$game->get_system_cname($founder_list['system_x'],$founder_list['system_y']).':'.($founder_list['planet_distance_id'] + 1).'</td>');
            // Class
            $game->out('<td>'.strtoupper($founder_list['planet_type']).'</td>');
            // Mood
            $game->out('<td><span style="color: '.($founder_list['mood_modifier'] == '80' ? 'green' : 'red').'">'.$founder_list['mood_modifier'].'</span></td>');
            // Controllore
            $game->out('<td>'.$founder_list['user_name'].'</td>');
            $game->out('</tr>');            
        }
    }
    $game->out('</table></td></tr></form></table>');        
}
elseif($sub_action == constant($game->sprache("TEXT3"))) {
    $game->out('
    <br><br><br>
    <center><span class="caption">'.(constant($game->sprache("TEXT3"))).':</span><br><br>
    <table class="style_outer" width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
    <form name="controller" method="post" action="'.parse_link('a=settlers').'">
    <input type="hidden" name="link_planet">
    <input type="hidden" name="operation">
    <input type="hidden" name="selection" value="'.$selection.'">
    <tr><td>
    <table class="style_inner" width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <td width="60"><b>'.(constant($game->sprache("TEXT10"))).'</b></td>
    <td width="30" align="center"><b>'.(constant($game->sprache("TEXT12"))).'</b></td>
    <td width="100"><b>'.(constant($game->sprache("TEXT19"))).'</b></td>
    <td width="160"><b>'.(constant($game->sprache("TEXT18"))).'</b></td>
    <td width="40"><b>'.(constant($game->sprache("TEXT25"))).'</b></td>
    <td width="40"><b>'.(constant($game->sprache("TEXT20"))).'</b></td>
    <td width="40"><b>'.(constant($game->sprache("TEXT21"))).'</b></td>
    <td width="80"><b>'.(constant($game->sprache("TEXT22"))).'</b></td>
  </tr>');
    $sql = 'SELECT se.event_code, se.awayteam_startlevel, se.planet_id, 
                   p.planet_name, p.best_mood_user, u.user_name, p.planet_type, 
                   se.awayteamship_id, ships.ship_name, ship_templates.name, se.awayteam_alive, se.event_status, se.event_result, se.count_ok, se.count_ko, se.count_crit_ok, se.count_crit_ko 
            FROM settlers_events se
            LEFT JOIN ships ON awayteamship_id = ships.ship_id
            LEFT JOIN ship_templates ON ships.template_id = ship_templates.id
            INNER JOIN planets p USING (planet_id) 
            INNER JOIN user u ON p.best_mood_user = u.user_id 
            WHERE se.user_id = '.$game->player['user_id'];
    $q_p_setdiplo = $db->query($sql);
    $rows = $db->num_rows($q_p_setdiplo);
    if($rows > 0) 
    {
        $sett_diplo = $db->fetchrowset($q_p_setdiplo);
        foreach($sett_diplo as $event_item)
        {
            if(isset($event_item['ship_name'])) {
                $ship_text = '<a href="'.parse_link('a=ship_fleets_ops&ship_details='.$event_item['awayteamship_id']).'">';
                $ship_text .= (empty($event_item['ship_name']) ? '<i><b>&#171;'.$event_item['name'].'&#187;</b></i>' : $event_item['ship_name']);
                $ship_text .= '</a>';
            }
            else {
                // I think the ship is down                
                $ship_text = 'N/A';
            }
            $game->out('<tr>');
            // Planet name
            $game->out('<td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($event_item['planet_id'])).'">'.$event_item['planet_name'].'</a></td>');
            // Class
            $game->out('<td align="center">'.strtoupper($event_item['planet_type']).'</td>');
            // Link to the ship owning the party landed
            //$game->out('<input class="button" style="width: 220px;" type="submit" name="ship_details" value="'.constant($game->sprache("TEXT37")).'" onClick="return document.fleet_form.action = \''.parse_link('a=ship_fleets_ops&ship_details').'\'">&nbsp;');
            $game->out('<td>'.$ship_text.'</td>');
            // tipo missione
            $game->out('<td>'.$SETL_EVENTS[$event_item['event_code']][0].'</td>');
            // livello squadra
            $game->out('<td>'.intval($event_item['awayteam_startlevel']).'</td>');
            // Squadra Viva
            $game->out('<td>'.($event_item['awayteam_alive'] ? 'Si' : 'No').'</td>');
            // Evento Attivo
            $game->out('<td>'.($event_item['event_status'] ? 'Si' : 'No').'</td>');
            // Riepilogo Evento
            $game->out('<td>('.$event_item['count_crit_ok'].' / '.$event_item['count_ok'].' / '.$event_item['count_ko'].' / '.$event_item['count_crit_ko'].')</td>');
            $game->out('</tr>');
        }
    }
    $game->out('</table></td></tr></form></table>');    
}
elseif($sub_action == constant($game->sprache("TEXT4"))) {
    $game->out('
    <br><br><br>
    <center><span class="caption">'.(constant($game->sprache("TEXT4"))).':</span><br><br>
    <table class="style_outer" width="70%" align="center" border="0" cellpadding="2" cellspacing="2">
    <form name="controller" method="post" action="'.parse_link('a=settlers').'">
    <input type="hidden" name="link_planet">
    <input type="hidden" name="operation">
    <input type="hidden" name="selection" value="'.$selection.'">
    <tr><td>
    <table class="style_inner" width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <td width="60"><b>'.(constant($game->sprache("TEXT10"))).'</b></td>
    <td width="30"><b>'.(constant($game->sprache("TEXT12"))).'</b></td>
    <td width="160"><b>'.(constant($game->sprache("TEXT4"))).'</b></td>
    <td width="60"><b>'.(constant($game->sprache("TEXT13"))).'</b></td>
  </tr>');
    $sql = 'SELECT event_code, p.planet_id, p.planet_name, p.planet_type, p.best_mood 
            FROM settlers_events se 
            INNER JOIN planets p USING (planet_id) 
            WHERE best_mood_user = '.$game->player['user_id'].'
            AND se.user_id <> '.$game->player['user_id'].'
            AND event_code NOT IN (100)
            ORDER BY p.planet_id, event_code';
    $q_p_setdiplo = $db->query($sql);
    $rows = $db->num_rows($q_p_setdiplo);
    if($rows > 0) {
        $sett_diplo = $db->fetchrowset($q_p_setdiplo);
        $pre_item['planet_id'] = $sett_diplo[0]['planet_id'];
        $pre_item['planet_name'] = $sett_diplo[0]['planet_name'];
        $pre_item['planet_type'] = $sett_diplo[0]['planet_type'];
        $pre_item['best_mood'] = $sett_diplo[0]['best_mood'];        
        $event_text = '';
        foreach ($sett_diplo as $event_item) {
            if($event_item['planet_id'] <> $pre_item['planet_id']) {
                $game->out('<tr>');
                // Name
                $game->out('<td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($pre_item['planet_id'])).'">'.$pre_item['planet_name'].'</a></td>');
                // Class
                $game->out('<td>'.strtoupper($pre_item['planet_type']).'</td>');
                // tipo missione
                $game->out('<td>'.$event_text.'</td>');
                // Mood
                $game->out('<td>'.$pre_item['best_mood'].'</td>');
                $event_text = '';
            }
            $event_text .= $SETL_EVENTS[$event_item['event_code']][0].'<br>';
            $pre_item['planet_id'] = $event_item['planet_id'];
            $pre_item['planet_name'] = $event_item['planet_name'];
            $pre_item['planet_type'] = $event_item['planet_type'];
            $pre_item['best_mood'] = $event_item['best_mood'];                    
        }
        $game->out('<tr>');
        // Name
        $game->out('<td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($pre_item['planet_id'])).'">'.$pre_item['planet_name'].'</a></td>');
        // Class
        $game->out('<td>'.strtoupper($pre_item['planet_type']).'</td>');
        // tipo missione
        $game->out('<td>'.$event_text.'</td>');
        // Mood
        $game->out('<td>'.$pre_item['best_mood'].'</td>');        
    }
    $game->out('
  </table></td></tr></form></table>
    ');    
}
elseif($sub_action == constant($game->sprache("TEXT1")))
{
// New Settlers Diplomacy Panel
    $game->out('
    <br><br><br>
    <center><span class="caption">'.(constant($game->sprache("TEXT1"))).':</span><br><br>
    <table class="style_outer" width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
    <form name="controller" method="post" action="'.parse_link('a=settlers').'">
    <input type="hidden" id = "data1" name = "link_planet" value="0">
    <input type="hidden" id = "data2" name = "operation" value="0">
    <input type="hidden" id = "data3" name = "selection" value="'.$selection.'">
    <tr><td>
    <table class="style_inner" width="75%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <td width="25%" align="center"><button type="submit" onclick="document.controller.data3.value=1">'.($selection == 1 ? '<b>'.constant($game->sprache("TEXT26")).'</b>' : constant($game->sprache("TEXT26"))).'</button></td>
    <td width="25%" align="center"><button type="submit" onclick="document.controller.data3.value=2">'.($selection == 2 ? '<b>'.constant($game->sprache("TEXT27")).'</b>' : constant($game->sprache("TEXT27"))).'</button></td>
    <td width="25%" align="center"><button type="submit" onclick="document.controller.data3.value=3">'.($selection == 3 ? '<b>'.constant($game->sprache("TEXT28")).'</b>' : constant($game->sprache("TEXT28"))).'</button></td>
    <td width="25%" align="center"><button type="submit" onclick="document.controller.data3.value=4">'.($selection == 4 ? '<b>'.constant($game->sprache("TEXT29")).'</b>' : constant($game->sprache("TEXT29"))).'</button></td>
    </tr>
    </table>
    </td></tr>
    <tr><td>
    <table class="style_inner" width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <td width="100"><b>'.(constant($game->sprache("TEXT10"))).'</b></td>
    <td width="80"><b>'.(constant($game->sprache("TEXT11"))).'</b></td>
    <td width="40"><b>'.(constant($game->sprache("TEXT12"))).'</b></td>
    <td width="60"><b>'.(constant($game->sprache("TEXT13"))).'</b></td>
    <td width="110"><b>'.(constant($game->sprache("TEXT14"))).'</b></td>
  </tr>');
    switch ($selection) {
        case 1:
            $selection_string = '';
            break;
        case 2:
            $selection_string = ' AND p.planet_type IN("a", "b", "c", "d", "m", "o", "p") ';
            break;
        case 3:
            $selection_string = ' AND p.planet_type IN("e", "f", "g", "h", "k", "l", "n") ';
            break;
        case 4:
            $selection_string = ' AND p.planet_type IN("i", "j", "s", "t", "x", "y") ';
            break;
    }
    $sql = 'SELECT sr.planet_id, p.planet_name, p.best_mood, p.best_mood_user, p.best_mood_planet,
                   p.sector_id, ss.system_x, ss.system_y, p.planet_distance_id,
                   p.planet_type, p2.planet_name AS target_planet_name,
                   MAX(timestamp) AS last_time, SUM(mood_modifier) AS mood
            FROM settlers_relations sr
            INNER JOIN planets p on sr.planet_id = p.planet_id
            LEFT  JOIN planets p2 on p.best_mood_planet = p2.planet_id
            INNER JOIN starsystems ss on p.system_id = ss.system_id
            WHERE sr.user_id = '.$game->player['user_id'].$selection_string.'
            GROUP BY sr.planet_id';
    $q_p_setdiplo = $db->query($sql);
    $rows = $db->num_rows($q_p_setdiplo);
    $sett_diplo = $db->fetchrowset($q_p_setdiplo);
    for($i=0; $i < $rows; $i++)
    {
        $game->out('<tr>');
        // Name
        $game->out('<td width="100"><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($sett_diplo[$i]['planet_id'])).'">'.$sett_diplo[$i]['planet_name'].'</a></td>');
        // Position
        $game->out('<td width="80">'.$game->get_sector_name($sett_diplo[$i]['sector_id']).':'.$game->get_system_cname($sett_diplo[$i]['system_x'],$sett_diplo[$i]['system_y']).':'.($sett_diplo[$i]['planet_distance_id'] + 1).'</td>');
        // Class
        $game->out('<td width="40">'.strtoupper($sett_diplo[$i]['planet_type']).'</td>');
        // Mood
        $game->out('<td width="60"><span style="color: '.(($game->player['user_id'] == $sett_diplo[$i]['best_mood_user']) || ($sett_diplo[$i]['mood'] > $sett_diplo[$i]['best_mood']) ? 'green' : 'red').'">'.$sett_diplo[$i]['mood'].'</span></td>');
        // Linked planet
        if($sett_diplo[$i]['best_mood_user'] == $game->player['user_id']) {
            $game->out('<td><table width="110" border="0" cellpadding="0" cellspacing="1"><tr>');
            (is_null($sett_diplo[$i]['best_mood_planet']) ? $_linked_planet = constant($game->sprache("TEXT15")) : $_linked_planet = $sett_diplo[$i]['target_planet_name']);
            (is_null($sett_diplo[$i]['best_mood_planet']) ? $txt_button = constant($game->sprache("TEXT16")) : $txt_button = constant($game->sprache("TEXT17")));
            $game->out('<td width="60" align="left">'.$_linked_planet.'</td><td width="40" align="right"><input class="Button_nosize" onclick="document.controller.data1.value=\''.encode_planet_id($sett_diplo[$i]['planet_id']).'\'; document.controller.data2.value=\''.$txt_button.'\'" type="submit" name="switch_button" value="'.$txt_button.'"></td>');
            $game->out('</tr></table>');
        }
        else {
            $game->out('<td align="left">------------</td>');
        }
        $game->out('</tr>');
    }
    $game->out('
  </table></td></tr></form></table>
    ');
}

?>