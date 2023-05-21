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



define('CWIN_ATTACKER', 0);
define('CWIN_DEFENDER', 1);

function display_logbook($log) {
    global $game, $db, $SHIP_TORSO, $RACE_DATA;
    
    $ldata = array(
        'action_code' => $log['log_data'][0],
        'user_id' => $log['log_data'][1],
        'start' => $log['log_data'][2],
        'start_planet_name' => $log['log_data'][3],
        'start_owner_id' => $log['log_data'][4],
        'dest' => $log['log_data'][5],
        'dest_planet_name' => $log['log_data'][6],
        'dest_owner_id' => $log['log_data'][7]
    );
    
   $sql = 'SELECT p.sector_id, s.system_x, s.system_y, p.planet_distance_id FROM planets p INNER JOIN starsystems s ON p.system_id = s.system_id WHERE p.planet_id = '.$ldata['start'];

   if(($s_coord = $db->queryrow($sql)) === false) {
      message(DATABASE_ERROR, 'Could not query starsystem data');
   }

   $sql = 'SELECT p.sector_id, s.system_x, s.system_y, p.planet_distance_id FROM planets p INNER JOIN starsystems s ON p.system_id = s.system_id WHERE p.planet_id = '.$ldata['dest'];

   if(($d_coord = $db->queryrow($sql)) === false) {
      message(DATABASE_ERROR, 'Could not query starsystem data');
   }

    $des_owner = $ldata['dest_owner_id'];

    $game->out('
<br>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <tr><td>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="330"><b><u>'.$log['log_title'].'</u></b></td>
        <td width="120"><b><b>'.date('d.m.y H:i:s', $log['log_date']).'</b></td>
      </tr>
    </table>
    <br>
    ');
    
    $inter_planet = false;

    if($ldata['dest'] == 0) {
            if(empty($ldata['start_owner_id'])) $start_owner_str = ' '.constant($game->sprache("TEXT29"));
            elseif($ldata['start_owner_id'] != $game->player['user_id']) {           
            
            $start_owner = $game->uc_get($ldata['start_owner_id']);
            
            if(!$start_owner) {
                $start_owner_str = ' '.constant($game->sprache("TEXT29"));
            }
            else {
                $start_owner_str = ' '.constant($game->sprache("TEXT30")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['start_owner_id']).'"><b>'.$start_owner.'</b></a>';
            }


        }
		else $start_owner_str = '';
		
		$game->out(constant($game->sprache("TEXT31")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.' ('.$game->get_sector_name($s_coord['sector_id']).':'.$game->get_system_cname($s_coord['system_x'], $s_coord['system_y']).':'.($s_coord['planet_distance_id'] + 1).') '.$start_owner_str.'<br><br>');
		
		$inter_planet = true;
	}
	else {
            if($ldata['start'] != 0) {
                    if(empty($ldata['start_owner_id'])) $start_owner_str = ' '.constant($game->sprache("TEXT29"));
                    elseif($ldata['start_owner_id'] != $game->player['user_id']) {

                            $start_owner = $game->uc_get($ldata['start_owner_id']);

                            if(!$start_owner) {
                                $start_owner_str = ' '.constant($game->sprache("TEXT29"));
                            }
                            else {
                                $start_owner_str = ' '.constant($game->sprache("TEXT30")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['start_owner_id']).'"><b>'.$start_owner.'</b></a>';
                            }


                    }		
                    
                    else $start_owner_str = '';
                    
                    $start_str = ' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.' ('.$game->get_sector_name($s_coord['sector_id']).':'.$game->get_system_cname($s_coord['system_x'], $s_coord['system_y']).':'.($s_coord['planet_distance_id'] + 1).') '.$start_owner_str.'<br>';
                    
            }
            else {

                    $start_str = ' <b><i>'.constant($game->sprache("TEXT241")).'</i></b> <br>';
            }
            
	    if(empty($ldata['dest_owner_id'])) $dest_owner_str = ' '.constant($game->sprache("TEXT29"));
		elseif($ldata['dest_owner_id'] != $game->player['user_id']) {

 

		    $dest_owner = $game->uc_get($ldata['dest_owner_id']);

            if(!$dest_owner) {
                $dest_owner_str = ' '.constant($game->sprache("TEXT29"));
            }
            else {
                $dest_owner_str = ' '.constant($game->sprache("TEXT30")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['dest_owner_id']).'"><b>'.$dest_owner.'</b></a>';
            }

        }		
		else $dest_owner_str = '';
		
		$game->out('
	'.constant($game->sprache("TEXT32")).$start_str
	 .constant($game->sprache("TEXT33")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['dest'])).'"><b>'.$ldata['dest_planet_name'].'</b></a>'.' ('.$game->get_sector_name($d_coord['sector_id']).':'.$game->get_system_cname($d_coord['system_x'], $d_coord['system_y']).':'.($d_coord['planet_distance_id'] + 1).') '.$dest_owner_str.'<br>
	<br>
		');
	}
	
	$str = '';

    switch($ldata['action_code']) {
        case 11:
            // nothing to report
        break;
        
        case 12:
            $fleets = &$log['log_data'][8];

            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">'.constant($game->sprache("TEXT35")).'</td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT36")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
            ');

            for($i = 0; $i < count($fleets); ++$i) {
                $game->out('
      <tr>
        <td>'.$fleets[$i][1].'</td>
        <td>'.$fleets[$i][2].'</td>
      </tr>
                ');
            }

            $game->out('</table><br>');
        break;

        case 13:
            $fleets = &$log['log_data'][8];
            
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">'.constant($game->sprache("TEXT38")).'</td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT36")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
            ');

            for($i = 0; $i < count($fleets); ++$i) {
                $game->out('
      <tr>
        <td>'.$fleets[$i][1].'</td>
        <td>'.$fleets[$i][2].'</td>
      </tr>
                ');
            }
            
            $game->out('</table><br>');
        break;
        
        case 21:
            // nothing to report
        break;
        
        case 22:
            if($ldata['user_id'] == $game->player['user_id']) {
                $spy_report = &$log['log_data'][9];
                $n_spyed = count($spy_report[1]) + count($spy_report[2]) + count($spy_report[3]) + count($spy_report[4]) + count($spy_report[5]);
                $dest_race = $log['log_data'][10];
            }

            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
            
            if($ldata['user_id'] == $game->player['user_id']) {
                if($spy_report[0]) $game->out(constant($game->sprache("TEXT39")));
                else $game->out(constant($game->sprache("TEXT40")));
            }
            else {
                $game->out(constant($game->sprache("TEXT41")));
            }
            
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250">'.constant($game->sprache("TEXT42")).'</td>
        <td width="200">'.$log['log_data'][8].'</td>
      </tr>
    </table>
    <br>
            ');
            
            if($n_spyed == 0) {
                $game->out(constant($game->sprache("TEXT43")));
                break;
            }
            
            $wares_names = get_wares_by_id($dest_race);
            
            if(count($spy_report[1]) > 0) {
                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>'.constant($game->sprache("TEXT44")).'</b></td>
        <td width="200"><b>'.constant($game->sprache("TEXT45")).'</b></td>
      </tr>
                ');

                foreach($spy_report[1] as $resource_id => $resorce_amount) {
                    $game->out('
      <tr>
        <td>'.$wares_names[$resource_id].'</td>
        <td>'.$resorce_amount.'</td>
      </tr>
                    ');
                }

                $game->out('</table><br>');
            }
            
            if(count($spy_report[2]) > 0) {
                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="200"><b>'.constant($game->sprache("TEXT45")).'</b></td>
      </tr>
                ');

                foreach($spy_report[2] as $unit_id => $unit_amount) {
                    $game->out('
      <tr>
        <td>'.$wares_names[($unit_id + 4)].'</td>
        <td>'.$unit_amount.'</td>
      </tr>
                    ');
                }

                $game->out('</table><br>');
            }
            
            if(count($spy_report[3]) > 0) {
                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>'.constant($game->sprache("TEXT47")).'</b></td>
        <td width="200"><b>'.constant($game->sprache("TEXT48")).'</b></td>
      </tr>
                ');
                
                global $BUILDING_NAME;

                foreach($spy_report[3] as $building_id => $building_level) {
                    $game->out('
      <tr>
        <td>'.$BUILDING_NAME[$dest_race][$building_id].'</td>
        <td>'.$building_level.'</td>
      </tr>
                    ');
                }
                
                $game->out('</table><br>');
            }
            
            if(count($spy_report[4]) > 0) {
                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>'.constant($game->sprache("TEXT49")).'</b></td>
        <td width="200"><b>'.constant($game->sprache("TEXT48")).'</b></td>
      </tr>
                ');

                global $TECH_NAME;

                foreach($spy_report[4] as $tech_id => $tech_level) {
                    $game->out('
      <tr>
        <td>'.$TECH_NAME[$dest_race][$tech_id].'</td>
        <td>'.$tech_level.'</td>
      </tr>
                    ');
                }

                $game->out('</table><br>');
            }
            
            if(count($spy_report[5]) > 0) {
                $sql = 'SELECT name
                        FROM ship_ccategory
                        WHERE race = '.$dest_race.'
                        ORDER BY id ASC
                        LIMIT 10';
                        
                if(($ship_comps = $db->queryrowset($sql)) === false) {
                    message(DATABASE_ERROR, 'Could not query ship component category data');
                }

                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>'.constant($game->sprache("TEXT50")).'</b></td>
        <td width="200"><b>'.constant($game->sprache("TEXT48")).'</b></td>
      </tr>
                ');

                foreach($spy_report[5] as $scomp_id => $scomp_level) {
                    $game->out('
      <tr>
        <td>'.$ship_comps[$scomp_id]['name'].'</td>
        <td>'.$scomp_level.'</td>
      </tr>
                    ');
                }

                $game->out('</table><br>');
            }
        break;

        case 23:
            $ships = &$log['log_data'][8];

            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
            
            if($inter_planet) {
                $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT52")));
            }
            else {
                if($ldata['user_id'] == $game->player['user_id']) {
                    $game->out(constant($game->sprache("TEXT53")));
                }
                else {
                    $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT52")));
                }
            }
            
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT54")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT55")).'</b></td>
      </tr>
            ');
            
            for($i = 0; $i < count($ships); ++$i) {
                $game->out('
      <tr>
        <td>'.$ships[$i][0].' (<i>'.$SHIP_TORSO[$ships[$i][2]][$ships[$i][1]][29].'</i>, <i>'.$RACE_DATA[$ships[$i][2]][0].'</i>)</td>
        <td>'.$ships[$i][3].'</td>
      </tr>
                ');
            }

            $game->out('</table><br>');
        break;

        case 24:
        case 25:
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');

            switch($log['log_data'][8]) {
                case -1: $game->out(constant($game->sprache("TEXT56"))); break;
                case -2: $game->out(constant($game->sprache("TEXT57"))); break;
                case -3: $game->out(constant($game->sprache("TEXT152"))); break;
                case -4: $game->out(constant($game->sprache("TEXT153"))); break;
                case -5: $game->out(constant($game->sprache("TEXT56b"))); break;
                case 1: $game->out(constant($game->sprache("TEXT58"))); break;
                case 2: $game->out(constant($game->sprache("TEXT154"))); break;
                default: $game->out('Illegal status code - report this as a bug'); break;
            }

            $game->out('
        </td>
      </tr>
    </table>
            ');
            
            if($log['log_data'][8] == 1) {
                $game->out('
    <br>
    <b>'.constant($game->sprache("TEXT54")).':</b><br>
    '.$log['log_data'][9].'</a> (<i>'.$SHIP_TORSO[$log['log_data'][10]][SHIP_TYPE_COLO][29].'</i>, <i>'.$RACE_DATA[$log['log_data'][10]][0].'</i>)
    <br>
                ');
            }
        break;

	case 26:
			switch($log['log_data'][11]) {
				case 0: $text_1 = constant($game->sprache("TEXT149"));
						$color1 = 'red';
				break;
				case 1: $text_1 = constant($game->sprache("TEXT150"));
						$color1 = 'grey';
				break;
				case 2: $text_1 = constant($game->sprache("TEXT151"));
						$color1 = 'green';
				break;
			}
			switch($log['log_data'][12]) {
				case 0: $text_2 = constant($game->sprache("TEXT149"));
						$color2 = 'red';
				break;
				case 1: $text_2 = constant($game->sprache("TEXT150"));
						$color2 = 'grey';
				break;
				case 2: $text_2 = constant($game->sprache("TEXT151"));
						$color2 = 'green';
				break;
			}
			switch($log['log_data'][13]) {
				case 0: $text_3 = constant($game->sprache("TEXT149"));
						$color3 = 'red';
				break;
				case 1: $text_3 = constant($game->sprache("TEXT150"));
						$color3 = 'grey';
				break;
				case 2: $text_3 = constant($game->sprache("TEXT151"));
						$color3 = 'green';
				break;
			}	

			$game->out(
				$log['log_data'][8].'<br><br>'.
				$log['log_data'][9].'<br><br>
				<table border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td align=left width=200>'.constant($game->sprache("TEXT146")).'</td>
					<td align=left><font color='.$color1.'>'.$text_1.'</font></td>
				</tr>
				<tr>
					<td align=left width=200>'.constant($game->sprache("TEXT147")).'</td>
					<td align=left><font color='.$color2.'>'.$text_2.'</font></td>
				</tr>
				<tr>
					<td align=left width=200>'.constant($game->sprache("TEXT148")).'</td>
					<td align=left><font color='.$color3.'>'.$text_3.'</font></td>
				</tr>
				</table>'
			);
		break;
		
        case 27:
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');

            $t_a_data = $log['log_data'][8];
            switch($t_a_data['mission_type']) {
                case 0:
                    switch($t_a_data['mission_result']) {
                        case -1: $game->out(constant($game->sprache("TEXT155"))); break;
                        case -2: $game->out(constant($game->sprache("TEXT157"))); break;
                        case 1: $game->out(constant($game->sprache("TEXT156"))); break;
                        default: $game->out('Illegal status code - report this as a bug'); break;
                    }
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT158")).' '.$t_a_data['user_mood']['value']);
                    if(isset($t_a_data['user_mood']['alliance']) || isset($t_a_data['user_mood']['race']) ) {
                        if(!empty($t_a_data['user_mood']['alliance']))
                            $game->out('<br>.... '.constant($game->sprache("TEXT163")).' '.$t_a_data['user_mood']['alliance'].'.');
                        if(!empty($t_a_data['user_mood']['race']))
                            $game->out('<br>.... '.constant($game->sprache("TEXT164")).' '.$t_a_data['user_mood']['race'].'.');
                    }

                    $game->out('<br><br>');

                    if(isset($t_a_data['toptenlist'][0])) {
                        $game->out(constant($game->sprache("TEXT159")).'<br><br>');
                        foreach($t_a_data['toptenlist'] as $other_user) {
                            $game->out('<b>'.$other_user['user_name'].'</b> '.constant($game->sprache("TEXT160")).' '.$other_user['mood_value'].'.<br>');
                        }
                    }
                break;
            }

            $game->out('
        </td>
      </tr>
    </table>
            ');
        break;


        case 31:
            $ships = &$log['log_data'][8];
            $wares = &$log['log_data'][9];
            $planet_overloaded = $log['log_data'][10];
            $push = $log['log_data'][11];           
 
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
    if(!$push) {
            if($ldata['user_id'] == $game->player['user_id']) {
                $game->out(constant($game->sprache("TEXT59")).( ($planet_overloaded) ? ' '.constant($game->sprache("TEXT60")) : '' ) );
            }
            else {
                $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT61")).( ($planet_overloaded) ? ' '.constant($game->sprache("TEXT62")) : '' ));
            }

            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT54")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT55")).'</b></td>
      </tr>
            ');

            for($i = 0; $i < count($ships); ++$i) {
                $game->out('
      <tr>
        <td>'.$ships[$i][0].' (<i>'.$SHIP_TORSO[$ships[$i][2]][$ships[$i][1]][29].'</i>, <i>'.$RACE_DATA[$ships[$i][2]][0].'</i>)</td>
        <td>'.$ships[$i][3].'</td>
      </tr>
                ');
            }

            $game->out('
	</table>
	<br>
	<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT63")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT64")).'</b></td>
      </tr>
		   ');

		   $wares_names = get_wares_by_id();
		   
		   for($i = 0; $i < count($wares_names); ++$i) {
			   if($wares[$i] > 0) {
				   $game->out('
	  <tr>
		<td>'.$wares_names[$i].'</td>
		<td>'.$wares[$i].'</td>
	  </tr>
				   ');
			   }
		   }
		   
		   $game->out('</table><br>');
 
        }
        else {

            if($ldata['user_id'] == $game->player['user_id']) {
                $game->out(constant($game->sprache("TEXT65")));
            }
            else {
                $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT66")));
            }
  
        $game->out('
            </td>
          </tr>
        </table>
        <br> ');

        }

        break;
        
        case 32:
			message(GENERAL, 'Fake fleets should not report a log entry', 'Entered $action == 32 case');
        break;
        
        case 33:
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">'.constant($game->sprache("TEXT67")).'</td>
      </tr>
    </table>
    <br>
    <b>'.constant($game->sprache("TEXT54")).':</b><br>
    <a href="'.parse_link('a=ship_fleets_ops&ship_details='.$log['log_data'][8]).'">'.$log['log_data'][9].'</a> (<i>'.$SHIP_TORSO[$log['log_data'][11]][$log['log_data'][10]][29].'</i>, <i>'.$RACE_DATA[$log['log_data'][11]][0].'</i>)
    <br>
            ');
        break;

        case 34:
            $ships = &$log['log_data'][8];
            $unloaded_wares = &$log['log_data'][9];
            $loaded_wares = &$log['log_data'][10];
            $planet_overloaded = $log['log_data'][11];

            // Shows communication of the action
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');

            if($ldata['user_id'] == $game->player['user_id']) {
                $game->out(constant($game->sprache("TEXT59")).( ($planet_overloaded) ? ' '.constant($game->sprache("TEXT60")) : '' ) );
            }
            else {
                $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT61")).( ($planet_overloaded) ? ' '.constant($game->sprache("TEXT62")) : '' ));
            }

            // Shows number and type of ships involved
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT54")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT55")).'</b></td>
      </tr>
            ');

            for($i = 0; $i < count($ships); ++$i) {
                $game->out('
      <tr>
        <td>'.$ships[$i][0].' (<i>'.$SHIP_TORSO[$ships[$i][2]][$ships[$i][1]][29].'</i>, <i>'.$RACE_DATA[$ships[$i][2]][0].'</i>)</td>
        <td>'.$ships[$i][3].'</td>
      </tr>
                ');
            }

            // Shows unloaded goods
            $game->out('
	</table>
	<br>
	<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT63")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT64")).'</b></td>
      </tr>
		   ');

		   $wares_names = get_wares_by_id();
		   
		   for($i = 0; $i < count($wares_names); ++$i) {
			   if($unloaded_wares[$i] > 0) {
				   $game->out('
	  <tr>
		<td>'.$wares_names[$i].'</td>
		<td>'.$unloaded_wares[$i].'</td>
	  </tr>
				   ');
			   }
		   }
		   
            // Shows loaded goods
            $game->out('
	</table>
	<br>
	<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT63")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT64a")).'</b></td>
      </tr>
		   ');

		   $wares_names = get_wares_by_id();
		   
		   for($i = 0; $i < count($wares_names); ++$i) {
			   if($loaded_wares[$i] > 0) {
				   $game->out('
	  <tr>
		<td>'.$wares_names[$i].'</td>
		<td>'.$loaded_wares[$i].'</td>
	  </tr>
				   ');
			   }
		   }
		   
		   $game->out('</table><br>');
        break;
        
        case 40:
        case 41:
        case 42:
        case 46:
        case 51:
        case 54:
        case 99:            
        case 55:
            $text = &$log['log_data'][10];
            $a_fleets = &$log['log_data'][12];
            $d_fleets = &$log['log_data'][13];

            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
            if($ldata['action_code']==99)
            {
                if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT68")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT69")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][4]).'"><b>'.$game->uc_get($log['log_data'][4]).'</b></a> '.constant($game->sprache("TEXT70")));
                else $game->out(constant($game->sprache("TEXT68")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT69")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][4]).'"><b>'.$game->uc_get($log['log_data'][4]).'</b></a> '.constant($game->sprache("TEXT71")));
            }
            if(isset($log['log_data'][16]) && $ldata['action_code']!=99) {
                if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT72")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT73")));
                else $game->out(constant($game->sprache("TEXT72")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT74")));
            }
            else {
                switch($ldata['action_code']) {
                    case 40:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT75")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT76")));
                            else $game->out(constant($game->sprache("TEXT75")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT77")));
                        }
                        else {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT78")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][15]).'"><b>'.$game->uc_get($log['log_data'][15]).'</b></a> '.constant($game->sprache("TEXT79")));
                            else $game->out(constant($game->sprache("TEXT78")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][15]).'"><b>'.$game->uc_get($log['log_data'][15]).'</b></a> '.constant($game->sprache("TEXT80")));
                        }
                    break;
                    
                    case 41:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT81")));
                            else $game->out(constant($game->sprache("TEXT82")));
                        }
                        else {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, '.constant($game->sprache("TEXT83")));
                            else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT84")));
                        }
                    break;
                    
                    case 42:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT85")));
                            else $game->out(constant($game->sprache("TEXT82")));
                        }
                        else {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, '.constant($game->sprache("TEXT83")));
                            else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT86")));
                        }
                    break;
                    
                    case 46:
                        if( ($log['log_data'][8] == CWIN_ATTACKER) && (!$log['log_data'][9]) ) {
                            $game->out('lose all');
                        }
                        elseif( ($log['log_data'][8] == CWIN_DEFENDER) && ($log['log_data'][9]) ) {
                            $game->out(constant($game->sprache("TEXT87")));
                        }

                        switch($log['log_data'][17]) {
                            // Colony ship not found
                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('win fight, no colo ship');
                                else $game->out(constant($game->sprache("TEXT88")));
                            break;

                            // Attacker has lost ground battle
                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('win fight, lose infantery');
                                else $game->out(constant($game->sprache("TEXT89")));
                            break;

                            // Colonization was successful
                            case 1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('win all');
                                else $game->out(constant($game->sprache("TEXT90")));
                            break;
                        }
                    break;
                    
                    case 51:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT91")));
                            else $game->out(constant($game->sprache("TEXT92")));
                        }
                        else {
                            if($log['log_data'][9]) $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, '.constant($game->sprache("TEXT83")));
                            else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT93")));
                        }
                    break;

                    case 54:
                        if( ($log['log_data'][8] == CWIN_ATTACKER) && (!$log['log_data'][9]) ) {
                            $game->out(constant($game->sprache("TEXT92")));
                        }
                        elseif( ($log['log_data'][8] == CWIN_DEFENDER) && ($log['log_data'][9]) ) {
                            $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, '.constant($game->sprache("TEXT83")));
                        }

                        switch($log['log_data'][17]) {
                            // No planetary weapons were available
                            case -3:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT94")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT93")));
                            break;

                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT95")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT96")));
                            break;

                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT97")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT93")));
                            break;

                            case 1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT98")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT99")));
                            break;

                            case 2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT100")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT101")));
                            break;
                        }
                    break;

                    case 55:
                        if( ($log['log_data'][8] == CWIN_ATTACKER) && (!$log['log_data'][9]) ) {
                            $game->out(constant($game->sprache("TEXT92")));
                        }
                        elseif( ($log['log_data'][8] == CWIN_DEFENDER) && ($log['log_data'][9]) ) {
                            $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, '.constant($game->sprache("TEXT83")));
                        }
                        
                        switch($log['log_data'][17]) {
                            // Colony ship not found
                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT102")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT93")));
                            break;

                            // Attacker has lost ground battle
                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT103")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT104")));
                            break;

                            // Colonization was successful
                            case 1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT105")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT106")));
                            break;
                        }
                    break;
                }
            }


     $game->out('
        </td>
      </tr>
    </table> <br><br>');


if(count($a_fleets) <= 0) {
                $game->out(constant($game->sprache("TEXT107")));}
            else {
                $game->out('
    <b>'.constant($game->sprache("TEXT108")).'</b><br>
    <table width="350" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>'.constant($game->sprache("TEXT109")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT110")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT226")).'</b></td>
        <td width="50"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
                ');

                for($i = 0; $i < count($a_fleets); $i++) {
                    $game->out('
      <tr>
        <td>'.$a_fleets[$i]['fleet_name'].'</td>
        <td>'.$a_fleets[$i]['owner_name'].'</td>
        <td>'.(isset($a_fleets[$i]['officer_name']) && $a_fleets[$i]['owner_name'] != 'No_ID' ? $a_fleets[$i]['officer_name'] : 'n/a' ).'</td>    
        <td>'.$a_fleets[$i]['n_ships'].'</td>
      </tr>
                    ');
                }

                $game->out('</table><br><br>');
            }

            if(count($d_fleets) <= 0) {
                $game->out(constant($game->sprache("TEXT111")));
            }
            else {
                $game->out('
    <b>'.constant($game->sprache("TEXT112")).'</b><br>
    <table width="350" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>'.constant($game->sprache("TEXT109")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT110")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT226")).'</b></td>
        <td width="50"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
                ');

                for($i = 0; $i < count($d_fleets); ++$i) {
                    $game->out('
      <tr>
        <td>'.$d_fleets[$i]['fleet_name'].'</td>
        <td>'.$d_fleets[$i]['owner_name'].'</td>
        <td>'.(isset($d_fleets[$i]['officer_name']) && $d_fleets[$i]['owner_name'] != 'No_ID' ? $d_fleets[$i]['officer_name'] : 'n/a' ).'</td>
        <td>'.$d_fleets[$i]['n_ships'].'</td>
      </tr>
                    ');
                }
               $game->out('</table><br><br>');
	
				}

                

            /*$game->out('
<br><table border="0" cellpadding="0" cellspacing="0"><tr><td>'.$text.'</td></tr></table>');
            */
            $popuptext = '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'.$text.'</td></tr></table>';
            
            $game->out('<br><a href="javascript:void(0);" onclick="return overlib(\''.htmlentities($popuptext, ENT_QUOTES).'\', CAPTION, \'Dettaglio dello scontro\', WIDTH, 750, '.OVERLIB_CMB_REPORT.');" onmouseout="return nd();"><span class="sub_caption">Dettaglio dello scontro</span></a><br><br>');
            
            switch($ldata['action_code']) {
                case 44:
                case 54:
                    global $BUILDING_NAME, $NUM_BUILDING;

                    if(!isset($log['log_data'][18])) {
                        $game->out(constant($game->sprache("TEXT113")));
                    }
                    elseif(array_sum($log['log_data'][18]) == 0) {
                        $game->out(constant($game->sprache("TEXT113")));
                    }
                    else {

//Beginning troops bombs
 $game->out('<table border="0" cellpadding="2" cellspacing="2">
       <tr><td width="200"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT114")).'</b></td></tr>');
      global $UNIT_NAME;
      $game->out('<tr><td width="200">'.constant($game->sprache("TEXT115")).'</td><td width="150">'.$log['log_data'][18][0].'</td></tr>');
      $truppen_bomben=0;
      for($i =14; $i<20; ++$i) {
        if($log['log_data'][18][$i] >0) 
        {
            $game->out('<tr><td width="200">'.$UNIT_NAME[$game->player['user_race']][$truppen_bomben].'</td>
                        <td width="150">'.$log['log_data'][18][$i].'</td></tr>' );
        }
        $truppen_bomben++;
      } //End troops bombs
 $game->out('
    <tr><td><br></td><td></td></tr>
      <tr>
        <td width="200"><b>'.constant($game->sprache("TEXT116")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT48")).'</b></td>
      </tr>
                         ');                        
    // $NUM_BUILDING = the largest index
    $lines_written = 0;
    for($i = 1; $i <= ($NUM_BUILDING); ++$i) {
        if($log['log_data'][18][$i] > 0) {
            $lines_written++;
            $game->out('
            <tr>
                <td>'.$BUILDING_NAME[$log['log_data'][19]][($i - 1)].'</td>
                <td>-'.$log['log_data'][18][$i].'</td>
            </tr>
            ');
        }
    }
    if($lines_written == 0) {
        $game->out('<tr><td colspan="2"><i>'.constant($game->sprache("TEXT113")).'</i></td></tr>');
    }
 $game->out('</table><br>');
}                   
/*                     
if($log['log_data'][20][0] > 0) // Then we have had an "Antiborgship"...
{
$game->out('
                                    <table border="0" cellpadding="2" cellspacing="2">
                                      <tr>
                                        <td width="200"><b>'.constant($game->sprache("TEXT117")).'</b></td>
                                        <td width="150"><b>'.constant($game->sprache("TEXT55")).'</b></td>
                                      </tr>
 ');
        global $UNIT_NAME;
 for($i = 0; $i < 4; $i++) {
     if($log['log_data'][20][$i] > 0) {
         $game->out('
                                                      <tr>
                                                        <td>'.$UNIT_NAME[6][$i].'</td>
                                                        <td>-'.$log['log_data'][20][$i].'</td>
                                                      </tr>
         ');
     }
 }

 $game->out('</table><br>');
}
*/
if($log['log_data'][20]['sum'] > 0 ) {
    $game->out('
            <table border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td width="200"><b>'.constant($game->sprache("TEXT227")).'</b></td>
                <td width="150"><b>'.constant($game->sprache("TEXT228")).'</b></td>
            </tr>
            <tr>
                <td>'.constant($game->sprache("TEXT229")).'</td>
                <td>'.$log['log_data'][20]['sum'].'</td>
            </tr>');
    if($log['log_Data'][20]['hq'] > 0 ) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT236")).'</td>
                    <td> +'.$log['log_data'][20]['hq'].'</td></tr>');        
    }
    if($log['log_data'][20]['mines'] > 0) {
        $game->out('<tr>
                    <td>'.constant($game->sprache("TEXT230")).'</td>
                    <td> +'.$log['log_data'][20]['mines'].'</td>
                    </tr>');
    }
    if($log['log_data'][20]['academy'] > 0) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT231")).'</td>
                    <td> +'.$log['log_data'][20]['academy'].'</td></tr>');
    }
    if($log['log_data'][20]['spacedock'] > 0) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT232")).'</td>
                    <td> +'.$log['log_data'][20]['spacedock'].'</td></tr>');
    }
    if($log['log_data'][20]['shipyard'] > 0) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT233")).'</td>
                    <td> +'.$log['log_data'][20]['shipyard'].'</td></tr>');
    }
    if($log['log_data'][20]['research'] > 0) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT234")).'</td>
                    <td> +'.$log['log_data'][20]['research'].'</td></tr>');
    }
    if($log['log_data'][20]['silo'] > 0) {
        $game->out('<tr><td>'.constant($game->sprache("TEXT235")).'</td>
                    <td> +'.$log['log_data'][20]['silo'].'</td></tr>');
    }    
    $game->out('</table><br><br>');
    $game->out('<table border="0" cellpadding="2" cellspacing="2">
               <tr>
                  <td width="200"><b>Warscore:</b></td>
                  <td width="150">'.(isset($log['log_data'][21]) ? '<b>'.$log['log_data'][21].'</b>' : '<i>n/a</i>').'</td>
               </tr>
               </table><br>
    ');
}                     
                break;
                
                case 45:
                case 46:
                case 55:
                    if(isset($log['log_data'][18])) {
                        if(array_sum($log['log_data'][18]) == 0) {
                            $game->out(constant($game->sprache("TEXT118")));
                        }
                        else {
                            $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="215"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT119")).'</b></td>
      </tr>
                            ');

                            global $UNIT_NAME;

                            for($i = 0; $i < 4; ++$i) {
                                $game->out('
      <tr>
        <td>'.$UNIT_NAME[$game->player['user_race']][$i].'</td>
        <td>'.$log['log_data'][18][$i].'</td>
      </tr>
                                ');
                            }

                            if(isset($log['log_data'][18][4])) {
                                $game->out('
      <tr>
        <td><i>'.constant($game->sprache("TEXT115")).'</i></td>
        <td>'.$log['log_data'][18][4].'</td>
      </tr>
                                ');
                            }

                            $game->out('</table><br>');
                        }
                    }

                    if(isset($log['log_data'][19])) {
                        if(array_sum($log['log_data'][19]) == 0) {
                            $game->out(constant($game->sprache("TEXT118a")));
                        }
                        else {
                            $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="215"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT119")).'</b></td>
      </tr>
                            ');

                            global $UNIT_NAME;

                            for($i = 0; $i < 4; ++$i) {
                                $game->out('
      <tr>
        <td>'.$UNIT_NAME[$log['log_data'][20]][$i].'</td>
        <td>'.$log['log_data'][19][$i].'</td>
      </tr>
                                ');
                            }

                            if(isset($log['log_data'][19][4])) {
                                $game->out('
      <tr>
        <td><i>'.constant($game->sprache("TEXT115")).'</i></td>
        <td>'.$log['log_data'][19][4].'</td>
      </tr>
                                ');
                            }

                            $game->out('</table><br>');
                        }
                    }
                    $game->out('<br><table border="0" cellpadding="2" cellspacing="2">
                    <tr>
                       <td width="215"><b>Warscore:</b></td>
                       <td width="150">'.(isset($log['log_data'][21]) ? '<b>'.$log['log_data'][21].'</b>' : '<i>n/a</i>').'</td>
                    </tr>
                    </table><br>
         ');                    
                break;
            }
        break;
        case 100: // AY-Fleet Report
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
            
            $game->out(constant($game->sprache("TEXT215")).'<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$log['log_data'][8]).'"> <b>'.$log['log_data'][9].'</b></a> '
                       .constant($game->sprache("TEXT216")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][1]).'">  <b>'.$log['log_data'][12].'</b> </a> '
                       .constant($game->sprache("TEXT217")).'<b>'.$log['log_data'][6].'</b>. '.constant($game->sprache("TEXT218")));
            
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT54")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT55")).'</b></td>
      </tr>
            ');
            
            foreach ($log['log_data'][11] as $ship_report) {
                $game->out('
      <tr>
        <td>'.$ship_report['name'].' (<i>'.$SHIP_TORSO[$ship_report['race']][$ship_report['ship_torso']][29].'</i>, <i>'.$RACE_DATA[$ship_report['race']][0].'</i>)</td>
        <td>'.$ship_report['n_ships'].'</td>
      </tr>
                ');
            }

            $game->out('</table><br>');
            break;
        case 101: // Planetary Alert System
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">
            ');
            
            /*
            $game->out(constant($game->sprache("TEXT220")).'<a href="'.parse_link('a=tactical_cartography&system_id='.encode_system_id($log['log_data'][8])).'"> <b>'.$log['log_data'][9].'</b></a> '
                       .constant($game->sprache("TEXT216")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][1]).'">  <b>'.$log['log_data'][12].'</b> </a> '
                       .constant($game->sprache("TEXT217")).'<b>'.$log['log_data'][6].'</b>. '.constant($game->sprache("TEXT218")));
            */
            $player_link = ($log['log_data'][1] != UNDISCLOSED_USERID ? '<a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][1]).'"> <b>'.$log['log_data'][12].'</b> </a> ' : ' <b><i>'.$log['log_data'][12].'</i></b> ' );

            $game->out(constant($game->sprache("TEXT220")).'<a href="'.parse_link('a=tactical_cartography&system_id='.encode_system_id($log['log_data'][8])).'"> <b>'.$log['log_data'][9].'</b></a> '
                       .constant($game->sprache("TEXT216")).$player_link
                       .constant($game->sprache("TEXT217")).'<b>'.$log['log_data'][6].'</b>. '.constant($game->sprache("TEXT218")));

            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>'.constant($game->sprache("TEXT54")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT55")).'</b></td>
      </tr>
            ');
            
            foreach ($log['log_data'][11] as $ship_report) {
                $game->out('
      <tr>
        <td>'.$ship_report['name'].' (<i>'.$SHIP_TORSO[$ship_report['race']][$ship_report['ship_torso']][29].'</i>, <i>'.$RACE_DATA[$ship_report['race']][0].'</i>)</td>
        <td>'.$ship_report['n_ships'].'</td>
      </tr>
                ');
            }

            $game->out('</table><br>');            
        break;
                
        case 102:
            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
        <td width="385">'.constant($game->sprache("TEXT242")).'<a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$log['log_data'][9]).'"> <b>'.$log['log_data'][8].'</b></a>'.constant($game->sprache("TEXT243")).'</td>
      </tr>
    </table>
    <br>');            
            break;
              
        case 103: // Bounce
          $game->out('
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="65" valign="top"><b>'.constant($game->sprache("TEXT34")).'&nbsp;</b></td>
              <td width="385">'.constant($game->sprache("TEXT38")).'</td>
            </tr>
          </table>
          <br>');        
        break;
                    
        default:
            message(GENERAL, 'Unknown action code in logbook_tactical.php', '$ldata[\'action_data\'] = '.$ldata['action_code']);
        break;        
    }

    $game->out('</td></tr>
</table>
</td>
</tr>
</table>
<br>
    ');
}

?>
