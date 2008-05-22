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
        <td width="330"><b>'.$log['log_title'].'</b></td>
        <td width="120"><b><b>'.date('d.m.y H:i:s', $log['log_date']+7200).'</b></td>
      </tr>
    </table>
    <br>
    ');
    
    $inter_planet = false;

    if($ldata['dest'] == 0) {
		if(empty($ldata['start_owner_id'])) $start_owner_str = ' <i>(unbewohnt)</i>';
		elseif($ldata['start_owner_id'] != $game->player['user_id']) {
            $start_owner = $game->uc_get($ldata['start_owner_id']);
            
            if(!$start_owner) {
                $start_owner_str = ' <i>(unbewohnt)</i>';
            }
            else {
                $start_owner_str = ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['start_owner_id']).'"><b>'.$start_owner.'</b></a>';
            }
        }
		else $start_owner_str = '';
		
		$game->out('Standort: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.$start_owner_str.'<br><br>');
		
		$inter_planet = true;
	}
	else {
		if(empty($ldata['start_owner_id'])) $start_owner_str = ' <i>(unbewohnt)</i>';
		elseif($ldata['start_owner_id'] != $game->player['user_id']) {
            $start_owner = $game->uc_get($ldata['start_owner_id']);

            if(!$start_owner) {
                $start_owner_str = ' <i>(unbewohnt)</i>';
            }
            else {
                $start_owner_str = ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['start_owner_id']).'"><b>'.$start_owner.'</b></a>';
            }
        }		
		else $start_owner_str = '';
		
	    if(empty($ldata['dest_owner_id'])) $dest_owner_str = ' <i>(unbewohnt)</i>';
		elseif($ldata['dest_owner_id'] != $game->player['user_id']) {
		    $dest_owner = $game->uc_get($ldata['dest_owner_id']);

            if(!$dest_owner) {
                $dest_owner_str = ' <i>(unbewohnt)</i>';
            }
            else {
                $dest_owner_str = ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['dest_owner_id']).'"><b>'.$dest_owner.'</b></a>';
            }
        }		
		else $dest_owner_str = '';
		
		$game->out('
	Start: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['start'])).'"><b>'.$ldata['start_planet_name'].'</b></a>'.$start_owner_str.'<br>
	Ziel: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ldata['dest'])).'"><b>'.$ldata['dest_planet_name'].'</b></a>'.$dest_owner_str.'<br>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">Dein Flottenverband hat die Mission abgeschlossen und ist zurückgekehrt.</td>
      </tr>
    </table>
    <br> $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
       <tr>
        <td width="200"><b>Einheitentyp</b></td>
        <td width="150"><b>Opfer</b></td>
      </tr>
      ');
      global $UNIT_NAME;
                        $game->out('
       <tr>
        <td width="200">Worker</td>
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
        <td width="350"><b>Name der Flotte</b></td>
        <td width="100"><b>Schiffe</b></td>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">Dein Flottenverband hat die ursprüngliche Mission aufgegeben und ist zurückgekehrt.</td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>Name der Flotte</b></td>
        <td width="100"><b>Schiffe</b></td>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">
            ');
            
            if($ldata['user_id'] == $game->player['user_id']) {
                if($spy_report[0]) $game->out('Die Spionageflotte wurde wï¿½hrend des Scannens des Planeten entdeckt und alle Schiffe wurden zerstï¿½rt.');
                else $game->out('Die Spionageflotte hat den Planeten unentdeckt scannen können und ist wieder auf dem Rückflug.');
            }
            else {
                $game->out('Es wurde eine Spionageflotte aus Aufklärungsschiffen in der Nähe des Planeten entdeckt, die die Oberfläche deines Planeten scannten. Sie wurde komplett zerstört, jedoch ist unbekannt, welche Daten sie bereits übermitteln konnte.');
            }
            
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250">Anzahl der Schiffe</td>
        <td width="200">'.$log['log_data'][8].'</td>
      </tr>
    </table>
    <br>
            ');
            
            if($n_spyed == 0) {
                $game->out('<b>Die Flotte hat keine genauen Daten über den Planeten übermittelt.</b>');
                break;
            }
            
            $wares_names = get_wares_by_id($dest_race);
            
            if(count($spy_report[1]) > 0) {
                $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="250"><b>Rohstoff</b></td>
        <td width="200"><b>Menge</b></td>
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
        <td width="250"><b>Einheitentyp</b></td>
        <td width="200"><b>Menge</b></td>
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
        <td width="250"><b>Gebï¿½ude</b></td>
        <td width="200"><b>Ausbaustufe</b></td>
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
        <td width="250"><b>Lokale Forschung</b></td>
        <td width="200"><b>Ausbaustufe</b></td>
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
        <td width="250"><b>Schiffskomponenten-Forschung</b></td>
        <td width="200"><b>Ausbaustufe</b></td>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">
            ');
            
            if($inter_planet) {
                $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat sich deinen Streitkräften ergeben.');
            }
            else {
                if($ldata['user_id'] == $game->player['user_id']) {
                    $game->out('Dein Flottenverband hat den Zielplaneten erreicht und die Kontrolle über die Schiffe der dortigen Regierung übergeben.');
                }
                else {
                    $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat sich deinen Streitkräften ergeben.');
                }
            }
            
            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>Schiffstyp</b></td>
        <td width="100"><b>Anzahl</b></td>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">
            ');
            
            switch($log['log_data'][8]) {
                case -1: $game->out('Der Planet konnte nicht kolonisiert, da er nicht unbewohnt war.'); break;
                case -2: $game->out('Der Planet konnte nicht kolonisiert werden, da das beim Start gewählte Kolonisationsschiff nicht mehr verfügbar war.'); break;
                case 1: $game->out('Der Planet wurde erfolgreich kolonisiert.'); break;
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
    <b>Schiffstyp:</b><br>
    '.$log['log_data'][9].'</a> (<i>'.$SHIP_TORSO[$log['log_data'][10]][SHIP_TYPE_COLO][29].'</i>, <i>'.$RACE_DATA[$log['log_data'][10]][0].'</i>)
    <br>
                ');
            }
        break;
        
        case 31:
            $ships = &$log['log_data'][8];
            $wares = &$log['log_data'][9];
            $planet_overloaded = $log['log_data'][10];

            $game->out('
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">
            ');

            if($ldata['user_id'] == $game->player['user_id']) {
                $game->out('Dein Flottenverband hat den Zielplaneten erreicht, die Ladung auf den Planeten gebeamt und befindet sich wieder auf dem Rückflug.'.( ($planet_overloaded) ? ' Alle Waren/Einheiten konnten nicht transferiert werden, da das Maximum des Planeten erreicht wurden.' : '' ) );
            }
            else {
                $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat auf die Oberfläche der Kolonie Waren/Einheiten gebeamt und befindet sich wieder auf dem Rückflug.'.( ($planet_overloaded) ? ' Dabei konnte nicht alles transferiert werden, da das Maximum des Planeten erreicht wurde' : '' ));
            }

            $game->out('
        </td>
      </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="350"><b>Schiffstyp</b></td>
        <td width="100"><b>Anzahl</b></td>
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
        <td width="350"><b>Ware/Einheit</b></td>
        <td width="100"><b>Übergeben</b></td>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">Das ersteigerte Schiff ist im Trockendock deines Planeten angekommen.</td>
      </tr>
    </table>
    <br>
    <b>Schiffstyp:</b><br>
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
        <td width="65" valign="top"><b>Mitteilung:</b></td>
        <td width="385">
            ');
            
            if(isset($log['log_data'][16])) {
                if($log['log_data'][9]) $game->out('Deine Flotte hat einen Verbündeten gegen den Angriff von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> verteidigt und hat dabei die Angreifer mit zerstört.');
                else $game->out('Deine Flotte hat einen Verbündeten gegen den Angriff von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> verteidigt, wurde dabei jedoch mit zerstört.');
            }
            else {
                switch($ldata['action_code']) {
                    case 40:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out('Deine auf Alarmstufe Rot operierende Flotte hat eine einfliegende Flotte von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> angegriffen und zerstört.');
                            else $game->out('Deine auf Alarmstufe Rot operierende Flotte hat eine einfliegende Flotte von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> angegriffen , wurde von dieser jedoch zerstört.');
                        }
                        else {
                            if($log['log_data'][9]) $game->out('Deine Flotte wurde beim Einflug in den Orbit von Schiffen von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][15]).'"><b>'.$game->uc_get($log['log_data'][15]).'</b></a> angriffen, konnte diese aber zerstï¿½ren.');
                            else $game->out('Deine Flotte wurde beim Einflug in den Orbit von Schiffen von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data'][15]).'"><b>'.$game->uc_get($log['log_data'][15]).'</b></a> angriffen und wurde zerstört.');
                        }
                    break;
                    
                    case 41:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out('Dein Flottenverband hat den Zielplaneten erreicht und alle gegnerische Schiffe sowie orbitale Verteidigungseinrichtungen zerstï¿½rt. Alle ï¿½berlebenden Schiffe sind in der Umlaufbahn des Planeten.');
                            else $game->out('Dein Flottenverband hat den Zielplaneten erreicht und wurde durch die gegnerischen Streitkräfte komplett zerstört.');
                        }
                        else {
                            if($log['log_data'][9]) $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, der deine Streitkräfte im Orbit angegriffen hat, wurde komplett zerstört.');
                            else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört und ist nun im Orbit des Planeten.');
                        }
                    break;
                    
                    case 42:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out('Dein Flottenverband hat den Zielplaneten erreicht und alle gegnerische Schiffe sowie orbitale Verteidigungseinrichtungen zerstört. Alle überlebenden Schiffe sind wieder auf dem Rï¿½ckflug.');
                            else $game->out('Dein Flottenverband hat den Zielplaneten erreicht und wurde durch die gegnerischen Streitkräfte komplett zerstört.');
                        }
                        else {
                            if($log['log_data'][9]) $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, der deine Streitkräfte im Orbit angegriffen hat, wurde komplett zerstört.');
                            else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört und ist wieder auf dem Rückflug.');
                        }
                    break;
                    
                    case 51:
                        if($log['log_data'][8] == CWIN_ATTACKER) {
                            if($log['log_data'][9]) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört.');
                            else $game->out('Dein Flottenverband wurde bei dem Angriff komplett zerstört.');
                        }
                        else {
                            if($log['log_data'][9]) $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, der deine Streitkräfte im Orbit angegriffen hat, wurde komplett zerstört.');
                            else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört.');
                        }
                    break;
                    
                    case 54:
                        if( ($log['log_data'][8] == CWIN_ATTACKER) && (!$log['log_data'][9]) ) {
                            $game->out('Dein Flottenverband wurde bei dem Angriff komplett zerstört.');
                        }
                        elseif( ($log['log_data'][8] == CWIN_DEFENDER) && ($log['log_data'][9]) ) {
                            $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, der deine Streitkräfte im Orbit angegriffen hat, wurde komplett zerstört.');
                        }
                        
                        switch($log['log_data'][17]) {
                            // Keine planetaren Waffen waren verfï¿½gbar
                            case -3:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört. Der Planet konnte jedoch nicht bombardiert werden, da kein Schiff über planetare Waffen verfügte.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört.');
                            break;
                            
                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die Bombardierung der Planetenoberfläche beendet.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat die Bombardierung der Planetenoberfläche beendet.');
                            break;
                            
                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstï¿½rt. Der Planet konnte jedoch nicht bombardiert werden, da kein Gebäude auf der Oberfläche zu finden war.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört.');
                            break;
                            
                            case 1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört. Danach begann er mit der Bombardierung der Planetenoberfläche.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört. Danach begann er mit der Bombardierung der Planetenoberfläche.');
                            break;
                            
                            case 2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die Bombardierung der Planetenoberfläche fortgesetzt.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat die Bombardierung der Planetenoberfläche fortgesetzt.');
                            break;
                        }
                    break;
                    
                    case 55:
                        if( ($log['log_data'][8] == CWIN_ATTACKER) && (!$log['log_data'][9]) ) {
                            $game->out('Dein Flottenverband wurde bei dem Angriff komplett zerstört.');
                        }
                        elseif( ($log['log_data'][8] == CWIN_DEFENDER) && ($log['log_data'][9]) ) {
                            $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a>, der deine Streitkräfte im Orbit angegriffen hat, wurde komplett zerstört.');
                        }
                        
                        switch($log['log_data'][17]) {
                            // Kolonieschiff nicht gefunden
                            case -2:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört. Das Kolonieschiff, das für die Invasion vorgesehen war, konnte jedoch nicht mehr gefunden werden - eventuell wurde es bei dem Kampf zerstört.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört.');
                            break;
                            
                            // Angreifer hat Bodenkampf verloren
                            case -1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört. In dem darauffolgenden Bodenkampf konnten die gegnerischen Streitkräfte jedoch nicht überwältigt werden.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört. In dem darauffolgenden Bodenkampf konnten deine Einheiten eine Übernahme durch feindliche Truppen verhindern.');
                            break;
                            
                            // Kolonisation war erfolgreich
                            case 1:
                                if($log['log_data'][8] == CWIN_ATTACKER) $game->out('Dein Flottenverband hat die gegnerischen Streitkräfte angegriffen und komplett zerstört. In dem darauffolgenden Bodenkampf haben deine Streitkröfte die Kontrolle über alle planetaren Einrichtungen gewinnen können, so dass der Planet nun unter deiner Kontrolle steht.');
                                else $game->out('Ein Flottenverband von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a> hat deine Streitkräfte im Orbit komplett zerstört. In dem darauffolgenden Bodenkampf wurden deine Einheiten von den feindlichen Truppen vernichtet, so dass diese nun die Kontrolle über den Planeten haben.');
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
                $game->out('<b>Angreifende Flotten</b><br><i>Keine angreifenden Flotten -- Bug, bitte melden</i><br><br>');}
            else {
                $game->out('
    <b>Angreifende Flotten</b><br>
    <table border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>Name</b></td>
        <td width="100"><b>Spieler</b></td>
        <td width="50"><b>Schiffe</b></td>
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
                $game->out('<b>Verteidigende Flotten</b><br><i>Keine verteidigenden Flotten</i><br><br>');
            }
            else {
                $game->out('
    <b>Verteidigende Flotten</b><br>
    <table border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="100"><b>Name</b></td>
        <td width="100"><b>Spieler</b></td>
        <td width="50"><b>Schiffe</b></td>
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
                        $game->out('<b>Es wurden keine Gebäude beschädigt.</b><br><br>');
                    }
                    elseif(array_sum($log['log_data'][18]) == 0) {
                        $game->out('<b>Es wurden keine Gebäude beschädigt.</b><br><br>');
                    }
                    else {
//Start Truppenbomben
 $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
       <tr>
        <td width="200"><b>Einheitentyp</b></td>
        <td width="150"><b>Opfer</b></td>
      </tr>
      ');
      global $UNIT_NAME;
                        $game->out('
       <tr>
        <td width="200">Worker</td>
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
        <td width="200"><b>Gebäudetyp</b></td>
        <td width="150"><b>Ausbaustufe</b></td>
      </tr>
                         ');
                         
                         global $BUILDING_NAME, $NUM_BUILDING;
                         
                         // $NUM_BUILDING = grï¿½ï¿½ter index
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
                            $game->out('<b>Es gab keine Verluste an Bodentruppen auf deiner Seite.</b><br><br>');
                        }
                        else {
                            $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="215"><b>Verteidiger: <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a></b></td>
      </tr>
      <tr>
        <td width="215"><b>&nbsp;</b></td>>
      </tr>
      <tr>
        <td width="215"><b>Einheitentyp</b></td>
        <td width="150"><b># Verluste</b></td>
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
        <td><i>Arbeiter</i></td>
        <td>'.$log['log_data'][18][4].'</td>
      </tr>
                                ');
                            }

                            $game->out('</table><br>');
                        }
                    }

                    if(isset($log['log_data'][19])) {
                        if(array_sum($log['log_data'][19]) == 0) {
                            $game->out('<b>Es gab keine Verluste an Bodentruppen auf der gegnerischen Seite.</b><br><br>');
                        }
                        else {
                            $game->out('
    <table border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="215"><b>Angreifer: <a href="'.parse_link('a=stats&a2=viewplayer&id='.$ldata['user_id']).'"><b>'.$game->uc_get($ldata['user_id']).'</b></a></b></td>
      </tr>
      <tr>
        <td width="215"><b>Einheitentyp</b></td>
        <td width="150"><b># Verluste</b></td>
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
        <td><i>Arbeiter</i></td>
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

    $game->out('* Achtung, das neue Kampfsystem ist experimentell installiert, bei groben Abweichungen bitte über das Forum melden!
  </td></tr>
</table>
<br>
    ');
}

?>
