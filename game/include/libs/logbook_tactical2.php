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
    
    $game->out('
<br>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
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
		
		$game->out(constant($game->sprache("TEXT31")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.$start_owner_str.'<br><br>');
		
		$inter_planet = true;
	}
	else {
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
	'.constant($game->sprache("TEXT32")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.$start_owner_str.'<br>
	'.constant($game->sprache("TEXT33")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['dest'])).'"><b>'.$ldata['dest_planet_name'].'</b></a>'.$dest_owner_str.'<br>
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
	
	$game->out('
    <table border="0" cellpadding="2" cellspacing="2">
       <tr>
        <td width="200"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT114")).'</b></td>
      </tr>
      ');
      global $UNIT_NAME;
                        $game->out('
       <tr>
        <td width="200">'.constant($game->sprache("TEXT115")).'</td>
        <td width="150">'.$log['log_data'][18][0].'</td>
      </tr>'
      );
      $truppen_bomben=0;
      for($i = 13; $i < 19; ++$i) {
                             if($log['log_data'][18][$i] > 0) {
                                 $game->out('
                                        <tr>
        <td width="200">'.$UNIT_NAME[$game->player['user_race']][$truppen_bomben].'</td>
        <td width="150">'.$log['log_data'][18][$i].'</td>
      </tr>'
      );
      $truppen_bomben++;
      }
      }
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
                case 1: $game->out(constant($game->sprache("TEXT58"))); break;
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
				case 0: $text_1 = constant($game->sprache("TEXT149")); $color1 = 'red';
				case 1: $text_1 = constant($game->sprache("TEXT150")); $color1 = 'grey';
				case 2: $text_1 = constant($game->sprache("TEXT151")); $color1 = 'green';
			}
			switch($log['log_data'][12]) {
				case 0: $text_2 = constant($game->sprache("TEXT149")); $color1 = 'red';
				case 1: $text_2 = constant($game->sprache("TEXT150")); $color1 = 'grey';
				case 2: $text_2 = constant($game->sprache("TEXT151")); $color1 = 'green';
			}
			switch($log['log_data'][13]) {
				case 0: $text_3 = constant($game->sprache("TEXT149")); $color1 = 'red';
				case 1: $text_3 = constant($game->sprache("TEXT150")); $color1 = 'grey';
				case 2: $text_3 = constant($game->sprache("TEXT151")); $color1 = 'green';
			}	
			
			$game->out('
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td width="450">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
			<td width="450">
				<table border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td width="330" align="left">'.$log['log_data'][9].'</td>
					</tr>
				</table>
            <br>
			'.constant($game->sprache("TEXT144")).'<br>
			'.constant($game->sprache("TEXT145")).'<br><br><br><br>
				<table border=0 cellpadding="0" cellspacing="0">
					<tr>
						<td width="200" align="left">'.constant($game->sprache("TEXT_146")).'</td>
						<td width="150" align="left"><font color='.$color1.'>'.$text_1.'</font></td>
					</tr>
					<tr>
						<td width="200" align="left">'.constant($game->sprache("TEXT_147")).'</td>
						<td width="150" align="left"><font color='.$color2.'>'.$text_2.'</font></td>
					</tr>
					<tr>
						<td width="200" align="left">'.constant($game->sprache("TEXT_148")).'</td>
						<td width="150" align="left"><font color='.$color3.'>'.$text_3.'</font></td>
					</tr>
				</table>
			</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
			');
		break;
		
        
        case 31:
            $ships = &$log['log_data'][8];
            $wares = &$log['log_data'][9];
            $planet_overloaded = $log['log_data'][10];

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
                $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat auf die Oberfläche der Kolonie Waren/Einheiten gebeamt und befindet sich wieder auf dem Rückflug.'.( ($planet_overloaded) ? ' '.constant($game->sprache("TEXT61")) : '' ));
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
        
        case 40:
        case 41:
        case 42:
        case 51:
        case 54:
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
            
            if(isset($log['log_data'][16])) {
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
                            // Keine planetaren Waffen waren verf�gbar
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
                            // Kolonieschiff nicht gefunden
                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT102")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT93")));
                            break;
                            
                            // Angreifer hat Bodenkampf verloren
                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out(constant($game->sprache("TEXT103")));
                                else $game->out(constant($game->sprache("TEXT51")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> '.constant($game->sprache("TEXT104")));
                            break;
                            
                            // Kolonisation war erfolgreich
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
    <table border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>'.constant($game->sprache("TEXT109")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT110")).'</b></td>
        <td width="50"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
                ');

                for($i = 0; $i < count($a_fleets); $i++) {
                    $game->out('
      <tr>
        <td>'.$a_fleets[$i]['fleet_name'].'</td>
        <td>'.$a_fleets[$i]['owner_name'].'</td>
        <td>'.$a_fleets[$i]['n_ships'].'</td>
      </tr>
                    ');
                }

                $game->out('</table><br>');
            }

            if(count($d_fleets) <= 0) {
                $game->out(constant($game->sprache("TEXT111")));
            }
            else {
                $game->out('
    <b>'.constant($game->sprache("TEXT112")).'</b><br>
    <table border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>'.constant($game->sprache("TEXT109")).'</b></td>
        <td width="100"><b>'.constant($game->sprache("TEXT110")).'</b></td>
        <td width="50"><b>'.constant($game->sprache("TEXT37")).'</b></td>
      </tr>
                ');

                for($i = 0; $i < count($d_fleets); ++$i) {
                    $game->out('
      <tr>
        <td>'.$d_fleets[$i]['fleet_name'].'</td>
        <td>'.$d_fleets[$i]['owner_name'].'</td>
        <td>'.$d_fleets[$i]['n_ships'].'</td>
      </tr>
                    ');
                }
	}

                

            $game->out('
<br><table border="0" cellpadding="0" cellspacing="0"><tr><td>'.$text.'</td></tr></table>');

            
            switch($ldata['action_code']) {
                case 44:
                case 54:
                    if(!isset($log['log_data'][18])) {
                        $game->out(constant($game->sprache("TEXT113")));
                    }
                    elseif(array_sum($log['log_data'][18]) == 0) {
                        $game->out(constant($game->sprache("TEXT113")));
                    }
                    else {
//Start Truppenbomben
 $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
       <tr>
        <td width="200"><b>'.constant($game->sprache("TEXT46")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT114")).'</b></td>
      </tr>
      ');
      global $UNIT_NAME;
                        $game->out('
       <tr>
        <td width="200">'.constant($game->sprache("TEXT115")).'</td>
        <td width="150">'.$log['log_data'][18][0].'</td>
      </tr>'
      );
      $truppen_bomben=0;
      for($i = 13; $i < 19; ++$i) {
                             if($log['log_data'][18][$i] >= 0) {
                                 $game->out('
                                        <tr>
        <td width="200">'.$UNIT_NAME[$game->player['user_race']][$truppen_bomben].'</td>
        <td width="150">'.$log['log_data'][18][$i].'</td>
      </tr>'
      );
      $truppen_bomben++;
      }
      } //Ende Truppenbomben
                        $game->out('<br>
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="200"><b>'.constant($game->sprache("TEXT116")).'</b></td>
        <td width="150"><b>'.constant($game->sprache("TEXT48")).'</b></td>
      </tr>
                         ');
                         
                         global $BUILDING_NAME, $NUM_BUILDING;
                         
                         // $NUM_BUILDING = gr��ter index
                         for($i = 1; $i <= ($NUM_BUILDING + 1); ++$i) {
                             if($log['log_data'][18][$i] > 0) {
                                 $game->out('
      <tr>
        <td>'.$BUILDING_NAME[$log['log_data'][19]][($i - 1)].'</td>
        <td>-'.$log['log_data'][18][$i].'</td>
      </tr>
                                 ');
                             }
                         }
                         
                         $game->out('</table><br>');
                     }
                break;
                
                case 45:
                case 55:
                    if(isset($log['log_data'][18])) {
                        if(array_sum($log['log_data'][18]) == 0) {
                            $game->out(constant($game->sprache("TEXT118")));
                        }
                        else {
                            $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="215"><b>'.constant($game->sprache("TEXT140")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a></b></td>
      </tr>
      <tr>
        <td width="215"><b>&nbsp;</b></td>>
      </tr>
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
        <td width="215"><b>'.constant($game->sprache("TEXT141")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a></b></td>
      </tr>
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
                break;
            }
        break;

        default:
            message(GENERAL, 'Unknown action code', '$ldata[\'action_data\'] = '.$ldata['action_code']);
        break;
    }

    $game->out(constant($game->sprache("TEXT142")).'
  </td></tr>
</table>
<br>
    ');
}

?>
