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



// #############################################################################

function xss_clean($var) {
	static $find, $replace;

	if(empty($find)) {
		$find = array('"', '<', '>');
		$replace = array('&quot;', '&lt;', '&gt;');
	}

	$var = preg_replace('/javascript/i', 'java script', $var);

	return str_replace($find, $replace, $var);
}

// #############################################################################

function parse_link($get_string = '') {
	return GAME_EXE.'?'.$get_string;
}

// #############################################################################

function parse_link_ex($get_string = '', $flags = 0) {
	$str = GAME_EXE.'?'.$get_string;

	if($flags & LINK_CLICKID) {
		global $game;

		if(!empty($game->CLICK_ID)) $str .= '&c='.$game->CLICK_ID;
	}

	return $str;
}

// #############################################################################

function deparse_sql($str) {
	$sql_cmds = array('select', 'update', 'insert', 'delete', 'replace', 'create');

	for($i = 0; $i < count($sql_cmds); ++$i) {
		if(stristr($str, $sql_cmds[$i])) {
			stgc_log('deparse_sql', 'Found '.$sql_cmds[$i].' in '.$str);

			message(GENERAL, 'Found illegal cmd in string', $sql_cmds[$i].' in '.$str);
		}
	}

	return $str;
}

// #############################################################################

function GetTabbyAction($tab) {

	global $game, $BUILDING_NAME;

	$actionText=array(

		'headquarter' => ''.$BUILDING_NAME[$game->player['user_race']][0].'',
		'building' => constant($game->sprache("BUILDINGS")),
		'researchlabs' => ''.$BUILDING_NAME[$game->player['user_race']][8].'',
		'spacedock' => ''.$BUILDING_NAME[$game->player['user_race']][6].'',
		'shipyard' => ''.$BUILDING_NAME[$game->player['user_race']][7].'',
		'ship_template' => constant($game->sprache("SHIPTEMPLATES")),
		'academy' => ''.$BUILDING_NAME[$game->player['user_race']][5].'',
		'mines' => constant($game->sprache("MINES")),
		'trade' => ''.$BUILDING_NAME[$game->player['user_race']][10].'',
		'planetlist' => constant($game->sprache("PLANETARYLIST")),
		'ship_fleets_display' => constant($game->sprache("FLEETS")),
		'tactical_cartography' => constant($game->sprache("CARTOGRAPHY")),
		'tactical_moves' => constant($game->sprache("SHIPMOVES")),
		'tactical_player' => constant($game->sprache("PLAYERINFO")),
		'tactical_kolo' => constant($game->sprache("COLONIZATION")),
		'tactical_known' => constant($game->sprache("KNOWNSYSTEMS")),
		'tactical_sensors' => constant($game->sprache("SENSORS")),
		'user_diplomacy' => constant($game->sprache("USERDIPLOMACY")),
		'alliance_main' => constant($game->sprache("ALLYMAIN")),
		'database' => constant($game->sprache("DATABASE")),
		'logbook' => constant($game->sprache("LOGBOOK")),
		'messages' => constant($game->sprache("MESSAGES")),
		'portal' => constant($game->sprache("PORTAL")),
		'stats' => constant($game->sprache("RANKINGS")),
		'settings' => constant($game->sprache("SETTINGS")),
		'alliance_attack' => constant($game->sprache("ALLYATTACK")),
		'alliance_diplomacy' => constant($game->sprache("ALLYDIPLOMACY")),
		'alliance_admin' => constant($game->sprache("ALLYADMIN")),
		'alliance_application' => constant($game->sprache("ALLYAPPS")),
		'alliance_rights' => constant($game->sprache("ALLYRIGHTS")),
		'alliance_massmail' => constant($game->sprache("ALLYMASSMAIL")),
		'alliance_taxes' => constant($game->sprache("ALLYTAXES")),
		'alliance_board' => constant($game->sprache("ALLYFORUM")),
		'alliance_ships' => constant($game->sprache("ALLYSHIPS")),
		'alliance_chat' => constant($game->sprache("ALLYCHAT")),
		'ships' => constant($game->sprache("SHIPS"))

	);

	return $actionText[$tab];
}

// #############################################################################

function message($type, $message, $add = false) {
	global $game;

	/* 29/04/08 - AC: If present, add user name to the log file */
	if(isset($game->player['user_name']))
		$username = $game->player['user_name'];
	else
		$username = '<i><b>unknown</b></i>';
	/* */

	switch($type) {
		case GENERAL:
			$is_dev = false;

			if(isset($game->player['user_auth_level'])) {
				if($game->player['user_auth_level'] == STGC_DEVELOPER) $is_dev = true;
			}

			echo '
				<html>
				<head>
				<title>Frontline Combat :: System Announcement</title>
				<style type="text/css">
				<!--
				a:link    { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:visited { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:hover   { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #FFFFFF; }
				a:active  { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }

				td { font-family: Arial,serif; font-size: 12px; color: #FFFFFF; }

				input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
				{ color: #959595; font-family: Verdana; font-size: 10px; background-color: #000000; border: 1px solid #959595; }

				//-->
				</style>
				</head>

				<body bgcolor="#000000" background="../gfx/template_bg.jpg">

				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border: 1px solid #C0C0C0;">
				<tr>
				<td><span style="font-size: 14px; font-weight: bold;">Frontline Combat :: System Announcement</span></td>
				</tr>
				</table>
				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border-left: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0;">
				<tr>
				<td>'.$message.( ($is_dev && !empty($add)) ? '<br><br>'.$add : '' ).'</td>
				</tr>
				</table>

				</body>
				</html>
			';
			$fp = fopen(ERROR_LOG_FILE, 'a');
			if($fp) {
			    fwrite($fp, '<hr><br><br><br><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>User:</b>&nbsp;'.$username.'&nbsp;&nbsp;&nbsp;<b>General Error:</b><br>'.$message.((!empty($add)) ? '<br>'.$add : '')."\n");
			    fclose($fp);
			}
		break;

		case DATABASE_ERROR:
			if(!is_object($add)) {
				global $db;

				$add = &$db;
			}

			echo '<span style="font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif;"><b>Frontline Combat :: Database Error</b></span><hr>'.
			'<span style="font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif;">'.$message.'<br><br>'.$add->error['message'].' ('.$add->error['number'].')<br><br>'.$add->error['sql'].'</span>';

			$fp = fopen(ERROR_LOG_FILE, 'a');
			if($fp) {
			    fwrite($fp, '<hr><br><br><br><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>User:</b>&nbsp;'.$username.'&nbsp;&nbsp;&nbsp;<b>Database Error:</b><br>'.$message.'<br><br>'.$add->error['message'].' ('.$add->error['number'].')<br><br>'.$add->error['sql']."\n");
			    fclose($fp);
			}
		break;

		case NOTICE:
			//$game->out('<br><center><font color="red">'.$message.'</font></center><br>');
			$game->out('<br><center><span class="text_large">'.$message.'</span></center><br>');
			$game->display();

			$fp = fopen(ERROR_LOG_FILE, 'a');
			if($fp) {
			    fwrite($fp, '<hr><br><br><br><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>User:</b>&nbsp;'.$username.'&nbsp;&nbsp;&nbsp;<b>Notice:</b><br>'.$message."\n");
			    fclose($fp);
			}
		break;

		default:
			message(GENERAL, 'Invalid function call', 'message(): Unknown error type '.$type);
		break;
	}

	exit;
}

// #############################################################################

function check_auth($required_level) {
	global $game;

	if($game->player['user_auth_level'] != $required_level) exit;

	return true;
}

// #############################################################################

function display_view_navigation($module, $current_view, $views) {
	$nav_html = array();

	foreach($views as $link => $name) {
		if($current_view == $link) {
			$nav_html[] = '[<b>'.$name.'</b>]';
		}
		else {
			$nav_html[] = '[<a href="'.parse_link('a='.$module.'&view='.$link).'">'.$name.'</a>]';
		}
	}

	return implode('&nbsp;&nbsp;', $nav_html);
}

// #############################################################################

function HelpPopup($name) {
	global $game;

	return '[<a href="JavaScript:void(window.open(\'help/'.$name.'.htm\',\'STFC\',\'toolbar=no,width=600,height=400,resizable=no,scrollbars=yes\'));">'.constant($game->sprache("HELP")).'</a>]';
}

// #############################################################################

function stgc_log($file, $entry) {
	$fp = fopen('./logs/'.$file.'.log', 'ab');
	fputs($fp, $_SERVER['REMOTE_ADDR'].' ['.date('d.m.y H:i:s', time()).'] '.$entry.NL);
	fclose($fp);
}

// #############################################################################

function add_logbook_entry($user_id, $log_type, $log_title, $log_data) {
	global $game, $db;
	if (!isset($user_id) || !isset($log_type) ||!isset($log_title) ||!isset($log_data)) return;
	if (empty($user_id) || empty($log_type) ||empty($log_title) ||empty($log_data)) return;
	// BOT users doesn't read their logbooks
	if(($user_id == FERENGI_USERID) || ($user_id == INDEPENDENT_USERID) || ($user_id == BORG_USERID)) return true;

	$sql = 'INSERT INTO logbook (user_id, log_type, log_date, log_read, log_title, log_data)
		VALUES ('.$user_id.', '.$log_type.', '.$game->TIME.', 0, "'.$log_title.'", "'.addslashes(serialize($log_data)).'")';

	if(!$db->query($sql)) {
		message(DATABASE_ERROR, 'Could not insert new logbook data');
	}

	$sql = 'UPDATE user
		SET unread_log_entries = unread_log_entries + 1
		WHERE user_id = '.$user_id;

	if(!$db->query($sql)) {
		message(DATABASE_ERROR, 'Could not update user unread log entries data');
	}

	return true;
}

// #############################################################################

function format_time($minutes) {
	$days = $hours = 0;

	// 60 * 24 = 1440
	while($minutes >= 1440) {
		$days++;
		$minutes -= 1440;
	}

	while($minutes >= 60) {
		$hours++;
		$minutes -= 60;
	}

	return round($days, 0).'d '.round($hours, 0).'h '.round($minutes, 0).'m';
}

// #############################################################################

function ZeitDetail($seconds) {
	global $game;
	$minutes=0;

	while($seconds >= 60) {
		$minutes++;
		$seconds -= 60;
	}

	return round($minutes, 0).' '.constant($game->sprache("MINS")).' '.round($seconds, 0).' '.constant($game->sprache("SECS")).'';
}

// #############################################################################

function Zeit($minutes)
{
	$days=0;
	$hours=0;

	while($minutes>=60*24) {$days++; $minutes-=60*24;}

	while($minutes>=60) {$hours++; $minutes-=60;}

	return ($days.'d '.$hours.'h '.$minutes.'m');
}

// #############################################################################

function redirect($get = '') {
	if ((strpos($get,'.php'))===false) header('Location: '.parse_link($get));
	else header('Location: '.$get);
	exit;
}

// #############################################################################

function check_forbidden_url($string) {
	$urls = array('www.sf-planet.de', 'www.sfplanet.de', 'www.stargate-planet.de', 'www.roswell-planet.de');

	for($i = 0; $i < count($urls); ++$i) {
		if(strstr($string, $urls[$i])) {
			return true;
		}
	}

	return false;
}

// #############################################################################

function get_move_action_str($code, $unexspected = array()) {
	global $game;
	if(in_array($code, $unexspected)) return 'Unexspected action at this point';

	$str = '';

	settype($code, 'int');

	/* 29/02/08 - AC: Localize this strings */
	switch($code) {
		case 11: $str = constant($game->sprache("MOVEWAIT")); break;

		case 12: $str = constant($game->sprache("MOVERETURN")); break;
		case 13: $str = constant($game->sprache("MOVERECALL")); break;

		case 14: $str = constant($game->sprache("MOVEAPPRET")); break;

		case 21: $str = constant($game->sprache("MOVEWAIT")); break;
		case 22: $str = constant($game->sprache("MOVESPY")); break;
		case 23: $str = constant($game->sprache("MOVEHAND")); break;
		case 24: $str = constant($game->sprache("MOVECOLONIZE")); break;
		case 25: $str = constant($game->sprache("MOVECOLONIZE")); break;
		case 26: $str = constant($game->sprache("MOVESURVEY")); break;
		case 27: $str = constant($game->sprache("TEAMAWAY")); break;

		case 31: $str = constant($game->sprache("MOVECARGO")); break;
		case 32: $str = 'You should not see this'; break; // Ferengifake Transport
		case 33: $str = constant($game->sprache("MOVEAUCTION")); break;
		case 34: $str = constant($game->sprache("MOVEROUTE")); break;

		case 40: $str = 'You should not see this'; break;
		case 41: $str = constant($game->sprache("MOVEATTACK")); break;
		case 42: $str = constant($game->sprache("MOVEATTACKRET")); break;
		case 43: $str = constant($game->sprache("MOVEATTACKPLUN")); break;
		case 44: $str = constant($game->sprache("MOVEATTACKBOMB")); break;
		case 45: $str = constant($game->sprache("MOVEATTACKTAKE")); break;

		case 51: $str = constant($game->sprache("MOVEATTACK")); break;
		case 52: $str = 'You should not see this'; break;
		case 53: $str = constant($game->sprache("MOVEATTACKPLUN")); break;
		case 54: $str = constant($game->sprache("MOVEATTACKBOMB")); break;
		case 55: $str = constant($game->sprache("MOVEATTACKTAKE")); break;

		default: $str = 'Unknown action code'; break;
	}

	return $str;
}

// #############################################################################

function GetAttackUnit($unit_id, $race = false) {
	global $UNIT_DATA, $RACE_DATA, $game;

	if($race === false) $race = $game->player['user_race'];

	return ( $UNIT_DATA[$unit_id][5] * $RACE_DATA[$race][14]  );
}

// #############################################################################

function GetDefenseUnit($unit_id, $race = false) {
	global $UNIT_DATA, $RACE_DATA, $game;

	if($race === false) $race = $game->player['user_race'];

	return ( $UNIT_DATA[$unit_id][6] * $RACE_DATA[$race][16]);
}
// #############################################################################


function SystemMessage($receiver, $header, $message) {
	global $db,$game;

	if ($db->query('INSERT INTO message (sender, receiver, subject, text, time)
		VALUES (0,"'.$receiver.'","'.addslashes($header).'","'.addslashes($message).'", '.$game->TIME.')')==false)  {message(DATABASE_ERROR, 'systemmessage_query: Could not call INSERT INTO in message'); exit();}
	if (($num=$db->queryrow('SELECT COUNT(id) as unread FROM message WHERE (receiver="'.$receiver.'") AND (rread=0)'))!=false)
	{
		$db->query('UPDATE user SET unread_messages="'.$num['unread'].'" WHERE user_id="'.$receiver.'"');
        // Update player only if it has been loaded
        if (isset($game->player['user_id']) && $game->player['user_id']==$receiver)
            $game->player['unread_messages']=$num['unread'];
	}

	return true;
}

// #############################################################################

function overlib($title, $body, $link = 'javascript:void(0);') {
	return '<a href="'.$link.'" onmouseover="return overlib(\''.$body.'\', CAPTION, \''.$title.'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$title.'</a>';
}

// #############################################################################

// veraltet, muss noch aus einigen Modulen entfernt werden
function get_wares_names() {
	return get_wares_by_key();
}

function get_wares_by_id($user_race = 0) {
	global $UNIT_NAME,$game;
	
	if(!$user_race) {

		$user_race = $game->player['user_race'];
	}

	return array(
		constant($game->sprache("METAL")),
		constant($game->sprache("MINERALS")),
		constant($game->sprache("DILITHIUM")),
		constant($game->sprache("WORKERS2")),
		$UNIT_NAME[$user_race][0],
		$UNIT_NAME[$user_race][1],
		$UNIT_NAME[$user_race][2],
		$UNIT_NAME[$user_race][3],
		$UNIT_NAME[$user_race][4],
		$UNIT_NAME[$user_race][5],
	);
}

function get_wares_by_key($user_race = 0) {
	global $UNIT_NAME, $game;

	if(!$user_race) {

		$user_race = $game->player['user_race'];
	}

	return array(
		'resource_1' => constant($game->sprache("METAL")),
		'resource_2' => constant($game->sprache("MINERALS")),
		'resource_3' => constant($game->sprache("DILITHIUM")),
		'resource_4' => constant($game->sprache("WORKERS2")),
		'unit_1' => $UNIT_NAME[$user_race][0],
		'unit_2' => $UNIT_NAME[$user_race][1],
		'unit_3' => $UNIT_NAME[$user_race][2],
		'unit_4' => $UNIT_NAME[$user_race][3],
		'unit_5' => $UNIT_NAME[$user_race][4],
		'unit_6' => $UNIT_NAME[$user_race][5]
	);
}

// #############################################################################

function is_planet_attacked($planet_id) {
	global $db;

	$sql = 'SELECT ss.move_id
		FROM (scheduler_shipmovement ss, planets p)
		WHERE ss.dest = '.(int)$planet_id.' AND
			p.planet_id = ss.dest AND
			p.planet_owner <> ss.user_id AND
			ss.action_code >= 40 AND
			ss.move_status = 0';

	if(($amove = $db->queryrow($sql)) === false){
		message(DATABASE_ERROR, 'Could not query planets attacked data');
	}

	return (!empty($amove['move_id']));
}

// #############################################################################


// This function returns at which point the fleet (with id 1) is visible when fleet 2 is in orbit.
// The values range from 0-100 (percent)
function GetVisibility($sensor1,$cloak1,$ships1,$sensor2,$cloak2,$sensor3,$flight_duration)
{
	// Calculate fleet visibility only for outer system flights
	if($flight_duration > 6) {
		// Larger the fleet, easier the detection on sensor; cap to 300 incoming ships
		$fleet_signature = 1300-($ships1/2.12)-pow($ships1/8.803,2);
		if ($fleet_signature < 1) $fleet_signature = 1;
		if ($fleet_signature > 1300) $fleet_signature = 1300;
		// Cloaking of fleet, based on average fleet cloaking capabilites, cap to 3200
		$fleet_cloak = ($cloak1/$ships1)*(38+pow($cloak1/$ships1,0.899));
		if ($fleet_cloak < 1) $fleet_cloak = 1;
		if ($fleet_cloak > 3200) $fleet_cloak = 3200;

		$cloak = $fleet_signature + $fleet_cloak;

		// We can see incoming fleet using the spacedock sensors (200 points per structure level), 
		// our orbiting fleet sensors and the help of allied fleets
		$sensor=$sensor2+($cloak2*0.05)+$sensor3;


		/* The previous version start here
		$cloak=(($sensor1/$ships1)*5+($cloak1/$ships1)*125)*10;
		$sensor=$sensor2+$cloak2*0.05+2000; // 2000 is planet-standard
		and ends here */

		if ($cloak==0) $cloak=1;
		if ($sensor==0) $sensor=1;

		$visibility=round(($cloak/$sensor)*100);
		if ($visibility<20) $visibility=20;
		if ($visibility>100) $visibility=100;
	}
	else
		// Standard visibility for inter planet flights
		$visibility = 20;

	return $visibility;
}

// #############################################################################

function get_friendly_orbit_fleets($planet_id, $user_id = 0, $user_alliance = 0) {
	global $db;

	if(!$user_id) {
		global $game;

		$user_id = (int)$game->uid;
		$user_alliance = (int)$game->player['user_alliance'];
	}

	$sql = 'SELECT DISTINCT f.user_id,
		u.user_alliance,
		ud.ud_id, ud.accepted,
		ad.ad_id, ad.type, ad.status
		FROM (ship_fleets f)
		INNER JOIN (user u) ON u.user_id = f.user_id
		LEFT JOIN (user_diplomacy ud) ON ( ( ud.user1_id = '.$user_id.' AND ud.user2_id = f.user_id ) OR ( ud.user1_id = f.user_id AND ud.user2_id = '.$user_id.' ) )
		LEFT JOIN (alliance_diplomacy ad) ON ( ( ad.alliance1_id = '.$user_alliance.' AND ad.alliance2_id = u.user_alliance) OR ( ad.alliance1_id = u.user_alliance AND ad.alliance2_id = '.$user_alliance.' ) )
		WHERE f.planet_id = '.$planet_id.' AND
		f.user_id <> '.$user_id;

	if(!$q_user = $db->query($sql)) {
		message(DATABASE_ERROR, 'Could not query user orbit data');
	}

	$allied_user = array($user_id);

	while($_user = $db->fetchrow($q_user)) {
		$allied = false;

		if($_user['user_alliance'] == $user_alliance) $allied = true;;

		if(!empty($_user['ud_id'])) {
			if($_user['accepted'] == 1) $allied = true;;
		}

		if(!empty($_user['ad_id'])) {
			if( ($_user['type'] == ALLIANCE_DIPLOMACY_PACT) && ($_user['status'] == 0) ) $allied = true;
		}

		if($allied) $allied_user[] = $_user['user_id'];
	}

	$sql = 'SELECT COUNT(s.ship_id) AS n_ships,
		SUM(st.value_11) AS sum_sensors,
		SUM(st.value_12) AS sum_cloak
		FROM (ships s, ship_fleets f)
		INNER JOIN (ship_templates st) ON st.id = s.template_id
		WHERE s.user_id IN ('.implode(',', $allied_user).') AND
		s.fleet_id = f.fleet_id AND
		f.planet_id = '.$planet_id;

	if(!$q_ships = $db->query($sql)) {
		message(DATABASE_ERROR, 'Could not query ships data');
	}

	$ships = $db->fetchrow($q_ships);

	return array('n_ships' => (int)$ships['n_ships'], 'sum_sensors' => (int)$ships['sum_sensors'], 'sum_cloak' => (int)$ships['sum_cloak']);
}

// #############################################################################

function get_fleet_details($fleet_id) {
    global $db;
    
    $sql = 'SELECT f.fleet_id,
                   COUNT(s.ship_id) AS n_ships,
                   SUM(st.value_11) AS sum_sensors,
                   SUM(st.value_12) AS sum_cloak,
                   ss.action_code
            FROM (ship_fleets f)
            INNER JOIN (ships s) ON s.fleet_id = f.fleet_id
            INNER JOIN (ship_templates st) ON st.id = s.template_id
            LEFT JOIN (scheduler_shipmovement ss) ON ss.move_id = f.move_id
            WHERE f.fleet_id = '.$fleet_id.'
            GROUP BY f.fleet_id';
            
    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }
    
    if(empty($fleet['fleet_id'])) return false;
    
    switch((int)$fleet['action_code']) {
        case 31: $fleet['status'] = 1; break;
        case 23: $fleet['status'] = 2; break;
        
        case 43: case 53: $fleet['status'] = 3; break;
        case 41: case 51: $fleet['status'] = 4; break;
        case 44: case 54: $fleet['status'] = 5; break;
        case 45: case 55: $fleet['status'] = 6; break;
        
        default: $fleet['status'] = 0; break;
    }
    
    $sql = 'SELECT st.ship_torso,
                   COUNT(s.ship_id) AS n_ships
            FROM (ship_fleets f, ships s, ship_templates st)
            WHERE f.fleet_id = '.$fleet_id.' AND
                  s.fleet_id = f.fleet_id AND
                  st.id = s.template_id
            GROUP BY st.ship_torso';
             
    if(($_sql_torso = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query torso data');
    }
     
    $fleet['torso'] = array();
     
    for($i = 0; $i < count($_sql_torso); ++$i) {
        $fleet['torso'][$_sql_torso[$i]['ship_torso']] = $_sql_torso[$i]['n_ships'];
    }
     
    return $fleet;
}

// #############################################################################

function get_move_ship_details($move_id) {
    global $db;

    $sql = 'SELECT ss.move_id, ss.action_code,
                   COUNT(s.ship_id) AS n_ships,
                   SUM(st.value_11) AS sum_sensors,
                   SUM(st.value_12) AS sum_cloak
            FROM (scheduler_shipmovement ss)
            INNER JOIN (ship_fleets f) ON f.move_id = ss.move_id
            INNER JOIN (ships s) ON s.fleet_id = f.fleet_id
            INNER JOIN (ship_templates st) ON st.id = s.template_id
            WHERE ss.move_id = '.$move_id.'
            GROUP BY ss.move_id';

    if(($move_ships = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }


    if(empty($move_ships['move_id'])) return false;

    switch((int)$move_ships['action_code']) {
        case 31: $move_ships['status'] = 1; break;
        case 23: $move_ships['status'] = 2; break;

        case 43: case 53: $move_ships['status'] = 3; break;
        case 41: case 51: $move_ships['status'] = 4; break;
        case 44: case 54: $move_ships['status'] = 5; break;
        case 45: case 55: $move_ships['status'] = 6; break;

        default: $move_ships['status'] = 0; break;
    }

    $sql = 'SELECT st.ship_torso,
                   COUNT(s.ship_id) AS n_ships
            FROM (ship_fleets f, ships s, ship_templates st)
            WHERE f.move_id = '.$move_id.' AND
                  s.fleet_id = f.fleet_id AND
                  s.template_id = st.id
            GROUP BY st.ship_torso';

    if(($_sql_torso = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query torso data');
    }

    $move_ships['torso'] = array();

    for($i = 0; $i < count($_sql_torso); ++$i) {
        $move_ships['torso'][$_sql_torso[$i]['ship_torso']] = $_sql_torso[$i]['n_ships'];
    }


	 // die leichten decoymasken mit einberechnen
    $sql = 'SELECT COUNT(s.ship_id) AS n_ships
            FROM (ship_fleets f, ships s, ship_templates st)
            WHERE f.move_id = '.$move_id.' AND
                  s.fleet_id = f.fleet_id AND
                  s.template_id = st.id AND 
                  st.race=9 AND
                  st.ship_torso=6 AND
                  st.component_4>-1
            GROUP BY st.ship_torso';
    $big_decoy = $db->queryrow($sql);
    $move_ships['torso'][6]-=$big_decoy['n_ships'];
    $move_ships['torso'][8]+=$big_decoy['n_ships'];
    
	 // die schweren decoymasken mit einberechnen
    $sql = 'SELECT COUNT(s.ship_id) AS n_ships
            FROM (ship_fleets f, ships s, ship_templates st)
            WHERE f.move_id = '.$move_id.' AND
                  s.fleet_id = f.fleet_id AND
                  s.template_id = st.id AND 
                  st.race=9 AND
                  st.ship_torso=6 AND
                  st.component_9>-1
            GROUP BY st.ship_torso';
    $big_decoy = $db->queryrow($sql);
    $move_ships['torso'][6]-=$big_decoy['n_ships'];
    $move_ships['torso'][9]+=$big_decoy['n_ships'];


    return $move_ships;
}

// #############################################################################

function account_log($user_1,$user_2,$action) {
	global $game, $db;

	$sql = 'SELECT u1.last_active AS useractive_1, u1.last_ip AS userip_1,
		u2.last_active AS useractive_2, u2.last_ip AS userip_2
		FROM (user u1)
		INNER JOIN (user u2) ON u2.user_id = '.(int)$user_2.'
		WHERE u1.user_id = '.(int)$user_1;

	$userdata = $db->queryrow($sql);

	if(empty($userdata['useractive_2'])) return;

	$sql = 'INSERT INTO account_observe (user_1, user_2, action, last_online_1, last_online_2, last_ip_1, last_ip_2, timestamp)
		VALUES ('.(int)$user_1.', '.(int)$user_2.', '.(int)$action.', '.(int)$userdata['useractive_1'].', '.(int)$userdata['useractive_2'].', "'.$userdata['userip_1'].'", "'.$userdata['userip_2'].'", '.$game->TIME.')';

	$db->query($sql);

	return;
}

// #############################################################################

function encode_system_id($real_system_id) {
	$f = ( $real_system_id + ($real_system_id % 3));

	$s  = ($f % 2) * ($f % 3) * ($f % 5);

	$t = ( ($s == 0) || ($s % 2) ) ? ($f * (-1)) : $f;

	return base64_encode($t);
}

function decode_system_id($fake_system_id) {
	$fake_system_id = (int)base64_decode($fake_system_id);
	$abs_f = abs($fake_system_id);

	$f = $abs_f % 3;

	if($f == 0) $s = $abs_f;
	elseif($f == 1) $s = ($abs_f - 2);
	elseif($f == 2) $s = ($abs_f - 1);

	$t = ($abs_f % 2) * ($abs_f % 3) * ($abs_f % 5);

	if( ($t == 0) || ($t % 2) ) {
		if($fake_system_id > 0) return 0;
	}

	return $s;
}

function encode_planet_id($real_planet_id) {
	$f = ( $real_planet_id + ($real_planet_id % 3));

//	$f += abs( ((pow($f, 7) % 13 ) * 0.01) );
	$f += abs( ( ( (int)bcmod(bcpow($f, 7), 13) ) * 0.01) );

	$s  = ($f % 4) * ($f % 5) * ($f % 7);

	$t = ( ($s == 0) || ($s % 2) ) ? ($f * (-1)) : $f;	

	return base64_encode($t);
}

function decode_planet_id($fake_planet_id) {
	$fake_planet_id = (float)base64_decode($fake_planet_id);

	$n_f = (int)abs($fake_planet_id);

	$f = $n_f % 3;

	if($f == 0) $s = $n_f;
	elseif($f == 1) $s = ($n_f - 2);
	elseif($f == 2) $s = ($n_f - 1);

	$t = ($n_f % 4) * ($n_f % 5) * ($n_f % 7);

	if( ($t == 0) || ($t % 2) ) {
		if($fake_planet_id > 0) return 0;
	}

//	$l = $n_f + abs( ((pow($n_f, 7) % 13 ) * 0.01) );
	$l = $n_f + abs( ( ( (int)bcmod(bcpow($n_f, 7), 13) ) * 0.01) );

	if($l != abs($fake_planet_id)) {
		return 0;
	}

	return $s;
}

// #############################################################################


function alliance_log($message,$permission=0,$alliance=-10) {
	global $game, $db;
	if ($alliance==-10) $alliance=$game->player['user_alliance'];

	$sql = 'INSERT INTO alliance_logs (alliance, message, timestamp, permission) VALUES ('.$alliance.',"'.addslashes($message).'",'.time().','.$permission.')';
	$db->query($sql);
	return;
}

// #############################################################################


class game {
	var $TIME = 0;

	var $PROXY_MODE = false;

	var $GFX_PATH = '';
	var $PLAIN_GFX_PATH = '';

	var $SITTING_MODE = false;

	var $CLICK_ID = 0;

	var $current_module = '';
	var $config = array();

	var $options = array();

	var $auto_refresh = 0;

	var $uid = 0;
	var $player = array();
	var $planet = array();

	var $template_html = '';
	var $game_html = '';

	var $galaxy_map_size = 368;
	var $quadrant_map_size = 368;
	var $sector_map_size = 368;
	var $system_map_size = 472;

	var $galaxy_detail_map_size = 503;

	var $quadrant_map_split = 9;
	var $sector_map_split = 9;
	var $system_max_planets = 5;
	var $starsize_range = array(10, 20);
	var $planet_distances = array( array(43, 53), array(68, 78), array(93, 103), array(118, 128), array(143, 155), array(170, 180), array(195, 205), array(220, 230) );

	// Store player's capital planet coordinates in order to calculate
	// distances from it in libs\maps.php:create_sector_map() function.
	var $capital_system_id;
	var $capital_global_x;
	var $capital_global_y;

	var $uid_cache = array();

	function game() {
		$this->TIME = time();

		$this->sectors_per_quadrant     = $this->quadrant_map_split * $this->quadrant_map_split;
		$this->max_sectors              = $this->sectors_per_quadrant * 4;
		$this->max_systems_per_sector   = $this->sector_map_split * $this->sector_map_split;
	}

	function sprache($nummer){
		if(!defined($this->player['language']."_".$nummer) || ($this->player['language']."_".$nummer)== " "){
			// 11/02/08 - AC: Fallback language is now english
			//return "GER_".$nummer;
			return "ENG_".$nummer;
		}else{
			return $this->player['language']."_".$nummer;
		}
	}

	function load_config() {
		global $db;

		if(($this->config = $db->queryrow('SELECT * FROM config')) === false) {
			message(DATABASE_ERROR, 'Could not query config data');
		}

		return true;
	}

	function out($html) {
		$this->game_html .= $html.NL;
	}

	function display() {
		global $db, $NEXT_TICK, $BUILDING_NAME, $RACE_DATA, $UNIT_NAME, $TECH_NAME, $SHIP_NAME,$MAX_POINTS;

		/* 01/02/08 - AC: Initialize this ALSO if user is not STGC_DEVELOPER... */
		$banner = '';
		if($this->player['user_auth_level'] != STGC_DEVELOPER) $banner = '<center><img border="0" src="'.FIXED_GFX_PATH.'../stgcbanner2.jpg" valign="top"></center>';


		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>'.GetTabbyAction($_GET['a']).' - Star Trek: Frontline Combat 2</title>
  <meta name="Content-Language" content="'.$this->player['language'].'">
  <meta name="description" content="ST: Frontline Combat is a free browser based multiplayer game, take the role of different races and peoples of the universe and rewrite history.">
  <meta name="keywords" content="star trek, startrek, galaxy, conquest, universe, game, gratis, kostenlos, spiel, multiplayer, strategy, strategie, onlinegame, bbg, free, browser, based, galaxie, universum, klingon, klingonen, federation, f&ouml;deration">

  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta name="author" content="Florian Brede & Philipp Schmidt">
  <meta name="publisher" content="Florian Brede & Philipp Schmidt">
  <meta name="copyright" content="Paramount Pic., Brede, Schmidt">
  <meta name="page-topic" content="Star Trek Online Game">
  <meta name="date" content="2008-11-27">
  <meta name="page-type" content="game">
  <meta name="robots" content="index,nofollow">
  <meta name="revisit-after" content="10">
        ';

		if($this->auto_refresh > 0) echo '<meta http-equiv="refresh" content="'.$this->auto_refresh.'; URL=index.php?a='.$this->current_module.'">';

		// Check presence of localized javascript
		if (file_exists('stgc2_'.$this->player['language'].'.js'))
			$stgcjs = 'stgc2_'.$this->player['language'].'.js';
		else
			$stgcjs = 'stgc2_ENG.js';

		echo '
  <script type="text/javascript" language="JavaScript" src="'.$this->player['user_jspath'].$stgcjs.'"></script>
  <script type="text/javascript" language="JavaScript" src="'.$this->player['user_jspath'].'overlib.js"></script>
  <script type="text/javascript" language="JavaScript" src="'.$this->player['user_jspath'].'popup.js"></script>

       '.NL.NL;

		if(!strpos($this->game_html, 'function mOver(')) {
			echo '
  <script type="text/javascript" language="JavaScript">
  <!--
  function mOver(Item) {
      Item.style.backgroundColor="#33355E";
      Item.style.cursor="hand";
      Item.style.cursor="pointer";
  }

  function mOut(Item) {
      Item.style.backgroundColor="#121536";
  }
  //-->
  </script>

            ';
		}


		if($this->player['user_hidenotepad'] == 0) {
			$notepad_html = '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="'.( ($this->player['notepad_width']!=0) ? ''.($this->player['notepad_width']+35).'px' : '335px' ).'" class="border_grey">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="'.( ($this->player['notepad_width']!=0) ? ''.($this->player['notepad_width']+30).'px' : '330px' ).'">
        <tr>
                 <td align="center" width="'.( ($this->player['notepad_width']!=0) ? ''.($this->player['notepad_width']+30).'px' : '330px' ).'">
            <form method="post" action="submit_notepad.php" target="_blank">

            <table width="'.( ($this->player['notepad_width']!=0) ? ''.$this->player['notepad_width'].'px' : '300px' ).'" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" align="left">'.constant($this->sprache("NOTEPAD")).'</td>
                <td width="50%" align="right"><a href="index.php?hide_notepad=1"><b>'.constant($this->sprache("NOTEHIDE")).'</b></a></td>
              </tr>
              <tr height="5"><td></td>
              <tr>
                <td width="100%" colspan="2">
                  <textarea name="user_notepad" class="textfield" style="width: '.( ($this->player['notepad_width']!=0) ? ''.$this->player['notepad_width'].'px' : '300px' ).';" rows="'.( ($this->player['notepad_cols']!=0) ? ''.$this->player['notepad_cols'].'' : '13' ).'">'.$this->player['user_notepad'].'</textarea>
                </td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
            <input type="submit" name="Update" class="button_nosize" width=45 value="'.constant($this->sprache("NOTESAVE")).'">

            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
';
		}
		else {
			$notepad_html = '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="305" background="'.$this->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="300">
        <tr>
          <td align="center">
            <a href="index.php?show_notepad=1"><b>'.constant($this->sprache("NOTESHOW")).'</b></a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
            ';
		}

		$planets_option_html = '';

		for($i = 0; $i < count($this->player['planets']); ++$i) {
			$planets_option_html .= '<option value="'.$this->player['planets'][$i]['planet_id'].'"'.( ($this->player['planets'][$i]['planet_id'] == $this->planet['planet_id']) ? ' selected="selected"' : '' ).'>'.( ($this->player['planets'][$i]['planet_id'] == $this->planet['planet_id']) ? '->' : '' ).' '.$this->player['planets'][$i]['planet_name'].'</option>'.NL;

		}

		$anzahl_truppen=$db->queryrow('SELECT unit_1, unit_2, unit_3, unit_4, unit_5, unit_6 FROM `FHB_Handels_Lager` LIMIT 1');
        // Retrieve alliance information only if an alliance exists
        if ($this->player['user_alliance'] != 0)
        {
            $alliance_hp=$db->queryrow('SELECT alliance_homepage AS hp FROM alliance WHERE alliance_id='.$this->player['user_alliance']);

            // 21/02/08 - AC: Check if alliance homepage is empty
            if($alliance_hp['hp'] == '')
                $alliance_hp_var='<a href="'.parse_link('a=alliance_board').'">'.constant($this->sprache("ALLYFORUM")).'</a><br>';
            else {
                if(stripos($alliance_hp['hp'], "http://") == false) {
                    $alliance_hp['hp'] ='http://'.$alliance_hp['hp'];
                }
                $alliance_hp_var='<a href="'.$alliance_hp['hp'].'" target="_blank">'.constant($this->sprache("ALLYFORUM")).'</a><br>';
            }
        }
        else
        {
            // 27/08/12 - AC: These variables must be initialized for some skins.
            $alliance_hp_var = '';
            $alliance_hp['hp'] = '';
        }

		// 01/02/08 - AC: Check if data is valid!
		if($anzahl_truppen == null)
		{
			$anzahl_truppen['unit_1'] = '0';
			$anzahl_truppen['unit_2'] = '0';
			$anzahl_truppen['unit_3'] = '0';
			$anzahl_truppen['unit_4'] = '0';
			$anzahl_truppen['unit_5'] = '0';
			$anzahl_truppen['unit_6'] = '0';
		}

		$truppen_hz='Truppen zum Verkauf:<br>
<li>Lv1: '.$anzahl_truppen['unit_1'].'</li><li>Lv2: '.$anzahl_truppen['unit_2'].'</li><li>Lv3: '.$anzahl_truppen['unit_3'].'</li><li>Lv4: '.$anzahl_truppen['unit_4'].'</li><li>Lv5: '.$anzahl_truppen['unit_5'].'</li><li>Lv6: '.$anzahl_truppen['unit_6'].'</li>';

		if($this->player['skin_farbe']==null)$this->player['skin_farbe']="#283359";

		/* 17/03/08 - AC: Add Trade Center link highlighting if auctions are presents */
		global $ACTUAL_TICK;
		$highlight_trade = false;
		$num_auctions=$db->queryrow('SELECT count(*) AS anzahl FROM ship_trade WHERE scheduler_processed=0 AND start_time<='.$ACTUAL_TICK.' AND end_time>='.$ACTUAL_TICK.'');
		if($num_auctions['anzahl']>0 && $this->player['user_points']>=400)
			$highlight_trade = true;


		$template_vars = array(
			'GFX_PATH' => $this->GFX_PATH,
'Lv1_Handel'=>$anzahl_truppen['unit_1'],
'Lv2_Handel'=>$anzahl_truppen['unit_2'],
'Lv3_Handel'=>$anzahl_truppen['unit_3'],
'Lv4_Handel'=>$anzahl_truppen['unit_4'],
'Lv5_Handel'=>$anzahl_truppen['unit_5'],
'Lv6_Handel'=>$anzahl_truppen['unit_6'],
			'U_LOGOUT' => parse_link('stgc_logout=1'),

			/* 25/02/08 - AC: Added some strings that was forgotten and written directly in the template*/
			// Main link bar
			'B_STATS' => constant($this->sprache("STATS")),
			'B_FAQ' => constant($this->sprache("FAQ")),
			'B_IMPRINT' => constant($this->sprache("IMPRINT")),
			'B_DONATIONS' => constant($this->sprache("DONATIONS")),
			// Left panel main title
			'B_COMMAND' => constant($this->sprache("BCOMMAND")),
			'T_COLONY' => constant($this->sprache("TCOLONY")),
			'T_COMMAND' => constant($this->sprache("TCOMMAND")),
			'T_DATABASE' => constant($this->sprache("TDATABASE")),
			'T_GENERAL' => constant($this->sprache("TGENERAL")),
			'T_NEXTTICK' => constant($this->sprache("TNEXTTICK")),
			'T_SITTING' => constant($this->sprache("TSITTING")),
			// Right panel main title
			'B_OVERVIEW' => constant($this->sprache("BOVERVIEW")),
			'T_HELLO' => constant($this->sprache("THELLO")),
			'T_ALLIANCE' => constant($this->sprache("TALLIANCE")),
			'T_POINTS' => constant($this->sprache("TPOINTS")),
			'T_RANK' => constant($this->sprache("TRANK")),
			'T_CLASS' => constant($this->sprache("TCLASS")),
			'T_POSITION' => constant($this->sprache("TPOSITION")),
			'T_PL_POINTS' => constant($this->sprache("TPL_POINTS")),
			'T_TROOPSXSEC' => constant($this->sprache("TTROOPSXSEC")),
			'T_AVOIDREBEL' => constant($this->sprache("TAVOIDREBEL")),
			'T_TROOPS' => constant($this->sprache("TTROOPS")),
			'T_FLEETS' => constant($this->sprache("TFLEETS")),
			/* */

			'STARDATE' => $this->config['stardate'],
			'skin_farbe'=>$this->player['skin_farbe'],
			'U_HEADQUARTER' => parse_link('a=headquarter'),
			'L_HEADQUARTER' => $BUILDING_NAME[$this->player['user_race']][0],
			'U_BUILDINGS' => parse_link('a=building'),
			'L_BUILDINGS' => constant($this->sprache("BUILDINGS")),
			'U_RESEARCH' => parse_link('a=researchlabs'),
			'L_RESEARCH' => $BUILDING_NAME[$this->player['user_race']][8],
			'U_SPACEDOCK' => parse_link('a=spacedock'),
			'L_SPACEDOCK' => $BUILDING_NAME[$this->player['user_race']][6],
			'U_SHIPYARD' => parse_link('a=shipyard'),
			'L_SHIPYARD' => $BUILDING_NAME[$this->player['user_race']][7],
			'U_SHIPTEMPLATE' => parse_link('a=ship_template'),
			'L_SHIPTEMPLATE' => constant($this->sprache("SHIPTEMPLATES")),
			'U_ACADEMY' => parse_link('a=academy'),
			'L_ACADEMY' => $BUILDING_NAME[$this->player['user_race']][5],
			'U_MINES' => parse_link('a=mines'),
			'L_MINES' => constant($this->sprache("MINES")),
			'U_TRADE' => parse_link('a=trade'),
/*			'L_TRADE' => $BUILDING_NAME[$this->player['user_race']][10],*/
			'L_TRADE' => ($highlight_trade) ? '<span style="color: #FFFF00; font-weight: bold;">'.$BUILDING_NAME[$this->player['user_race']][10].'</span>' : ''.$BUILDING_NAME[$this->player['user_race']][10].'',
			'U_PLANETLIST' => parse_link('a=planetlist'),
			'L_PLANETLIST' => constant($this->sprache("PLANETS")),
			'U_FLEETS' => parse_link('a=ship_fleets_display'),
			'L_FLEETS' => constant($this->sprache("FLEETS")),
			'U_TACTICAL' => parse_link('a=tactical_cartography'),
			'L_TACTICAL' => constant($this->sprache("TACTIC")),

			/* 25/02/08 - AC: Added some link that was forgotten and written directly in the template*/
			'U_SENSORS' => parse_link('a=tactical_sensors'),
			'L_SENSORS' => constant($this->sprache("SENSORS")),
			'U_SHIPMOVES' => parse_link('a=tactical_moves'),
			'L_SHIPMOVES' => constant($this->sprache("SHIPMOVES")),
			'U_BUYTROOPS' => parse_link('a=trade&view=trade_buy_truppen'),
			'L_BUYTROOPS' => constant($this->sprache("BUYTROOPS")),
			'U_ALLYTACTIC' => parse_link('a=alliance_attack'),
			'L_ALLYTACTIC' => constant($this->sprache("ALLYTACTIC")),
			'U_ALLYTAXES' => parse_link('a=alliance_taxes'),
			'L_ALLYTAXES' => constant($this->sprache("ALLYTAXES")),
			/* */

			'U_DIPLOMACY' => parse_link('a=user_diplomacy'),
			'L_DIPLOMACY' => constant($this->sprache("DIPLOMACY")),
			'U_ALLIANCE' => parse_link('a=alliance_main'),
			'L_ALLIANCE' => constant($this->sprache("ALLIANCE")),
			'HP_Alliance'=>$alliance_hp['hp'],
			'HP_Alliance_z'=>$alliance_hp_var,
			'U_DATABASE' => parse_link('a=database'),
			'L_DATABASE' => constant($this->sprache("GENERAL")),
			'U_LOGBOOK' => parse_link('a=logbook'),
			'L_LOGBOOK' => ($this->player['unread_log_entries'] > 0) ? '<span style="color: #FFFF00; font-weight: bold;">'.constant($this->sprache("LOGBOOK")).'</span>' : ''.constant($this->sprache("LOGBOOK")).'',
			'U_MESSAGES' => parse_link('a=messages'),
			'L_MESSAGES' => ($this->player['unread_messages'] > 0) ? '<span style="color: #FFFF00; font-weight: bold;">'.constant($this->sprache("MESSAGES")).'</span>' : ''.constant($this->sprache("MESSAGES")).'',
			'U_PORTAL' => parse_link('a=portal'),
			'L_PORTAL' => constant($this->sprache("PORTAL")),
			'U_STATS' => parse_link('a=stats'),
			'L_STATS' => constant($this->sprache("RANKINGS")),
			'U_SETTINGS' => parse_link('a=settings'),
			'L_SETTINGS' => constant($this->sprache("SETTINGS")),
			'U_HELP' => parse_link('a=help'),
			'L_HELP' => constant($this->sprache("HELP")),
			'HZ_Truppen'=>$truppen_hz,
			'U_SUPPORT' => '', // Dummies for old Skins
			'L_SUPPORT' => '', // Dummies for old Skins
			'U_SUPPORTCENTER' => '', // Dummies for old Skins
			'L_SUPPORTCENTER' => '', // Dummies for old Skins
			'U_ADMINPANEL' => ($this->player['user_auth_level']==STGC_SUPPORTER) ? parse_link('a=modcenter') : parse_link('a=tools/index'),
			'L_ADMINPANEL' => ($this->player['user_auth_level']==STGC_SUPPORTER) ? 'Modcenter' : 'Admin Panel',
			'U_PLANETSWITCH' => parse_link('a='.$this->current_module),
			'PLANET_SWITCH_HTML' => $planets_option_html,

			'NEXT_TICK_HTML' => '<b id="timer1" title="time1_'.$NEXT_TICK.'_type1_4">&nbsp;</b>',


			'USER_NAME' => $this->player['user_name'],
			'USER_RACE' => $this->player['user_race'],
			'USER_POINTS' => $this->player['user_points'],
			'USER_RANKPOS' => $this->player['user_rank_points'],
			'USER_RANK' => 0,
			'USER_PLANETS' => $this->player['user_planets'],
			'USER_HONOR' => $this->player['user_honor'],
			'USER_RANKPOS_PLANETS' => $this->player['user_rank_planets'],
			'USER_RANKPOS_HONOR' => $this->player['user_rank_honor'],


			'ALLIANCE_NAME' => $this->player['alliance_name'],
			'ALLIANCE_TAG' => $this->player['alliance_tag'],

			'ACTIVE_PLANET_NAME' => $this->planet['planet_name'],
			'ACTIVE_PLANET_ALTNAME' => $this->planet['planet_altname'],
			'ACTIVE_PLANET_TYPE' => strtoupper($this->planet['planet_type']),
			'ACTIVE_PLANET_POINTS' => $this->planet['planet_points'],
			'ACTIVE_PLANET_POSITION' => '',
			'ACTIVE_PLANET_ID' => encode_planet_id($this->planet['planet_id']),
			'ACTIVE_PLANET_MAXRES' => (($this->planet['max_resources']>=100000) ? round($this->planet['max_resources']/1000).'k' : round($this->planet['max_resources'],0)),
			'ACTIVE_PLANET_MAXWORKER' => (($this->planet['max_worker']>=100000) ? round($this->planet['max_worker']/1000).'k' : round($this->planet['max_worker'],0)),
			'ACTIVE_PLANET_METAL' => (($this->planet['resource_1']>=100000) ? round($this->planet['resource_1']/1000).'k' : round($this->planet['resource_1'],0)),
			'ACTIVE_PLANET_MINERALS' => (($this->planet['resource_2']>=100000) ? round($this->planet['resource_2']/1000).'k' : round($this->planet['resource_2'],0)),
			'ACTIVE_PLANET_LATINUM' => (($this->planet['resource_3']>=100000) ? round($this->planet['resource_3']/1000).'k' : round($this->planet['resource_3'],0)),
			'ACTIVE_PLANET_WORKER' => round($this->planet['resource_4'], 0).' (+'.round($this->planet['add_4'], 1).')',
			'ACTIVE_PLANET_MAXTROOPS' => $this->planet['max_units'],
			'ACTIVE_PLANET_MAXUNITS' => $this->planet['max_units'],
			'ACTIVE_PLANET_UNIT1' => $this->planet['unit_1'],
			'ACTIVE_PLANET_UNIT2' => $this->planet['unit_2'],
			'ACTIVE_PLANET_UNIT3' => $this->planet['unit_3'],
			'ACTIVE_PLANET_UNIT4' => $this->planet['unit_4'],
			'ACTIVE_PLANET_UNIT5' => $this->planet['unit_5'],
			'ACTIVE_PLANET_UNIT6' => $this->planet['unit_6'],

			'ACTIVE_PLANET_UNITS' => $this->planet['unit_1'] * 2 + $this->planet['unit_2'] * 3 + $this->planet['unit_3'] * 4 + $this->planet['unit_4'] * 4 + $this->planet['unit_5'] * 4 + $this->planet['unit_6'] * 4,
			'ACTIVE_PLANET_STRENGTH' => $this->planet['unit_1'] * 2 + $this->planet['unit_2'] * 3 + $this->planet['unit_3'] * 4 + $this->planet['unit_4'] * 4,
			'ACTIVE_PLANET_TROOPS' => $this->planet['unit_1'] * 2 + $this->planet['unit_2'] * 3 + $this->planet['unit_3'] * 4 + $this->planet['unit_4'] * 4,
			'ACTIVE_PLANET_STRENGTH_REQUIRED' => $this->planet['min_troops_required'],
			'ACTIVE_PLANET_TROOPS_REQUIRED' => $this->planet['min_troops_required'],

			'ACTIVE_PLANET_ORBITALDEFENSE' => $this->planet['building_10'],


			'ACTIVE_PLANET_ATTACKED' => ($this->planet['planet_next_attack'] > 0) ? '<a href="index.php?a=tactical_sensors"><img src="'.$this->GFX_PATH.'menu_attack_small.gif" border=0></a>' : '',
			'ACTIVE_PLANET_GFX' => FIXED_GFX_PATH.'planet_type_'.$this->planet['planet_type'].'.png',

			'ACTIVE_PLANET_MAXPOINTS' => (($this->player['user_capital']==$this->planet['planet_id']) ? $MAX_POINTS[1] : $MAX_POINTS[0]),
			'GAME_HTML' => &$this->game_html,
			'NOTEPAD_HTML' => &$notepad_html,

			/* 07/03/08 - AC: New additions */
			'B_REGISTRATION' => constant($this->sprache("BREGISTRATION")),
			'T_WELCOME' => constant($this->sprache("TWELCOME")),
			'T_STARDATE' => constant($this->sprache("TSTARDATE")),
			'T_RESOURCES' => constant($this->sprache("TRESOURCES")),
			'T_TACTIC' => constant($this->sprache("TACTIC")),
			'T_SECURITY' => constant($this->sprache("TSECURITY")),
			'T_REQUIRED' => constant($this->sprache("TREQUIRED")),
			'T_DEFENSE' => constant($this->sprache("TDEFENSE")),
			'T_LEVEL1' => constant($this->sprache("TLEVEL1")),
			'T_LEVEL2' => constant($this->sprache("TLEVEL2")),
			'T_LEVEL3' => constant($this->sprache("TLEVEL3")),
			'T_COMMANDERS' => constant($this->sprache("TCOMMANDERS")),
			'T_TECHNICIANS' => constant($this->sprache("TTECHNICIANS")),
			'T_PHYSICIANS' => constant($this->sprache("TPHYSICIANS")),
			'T_WORKERS' => constant($this->sprache("TWORKERS")),
			/* Capitalized strings */
			'T_CAP_ADMIRAL' => constant($this->sprache("TCAP_ADMIRAL")),
			'T_CAP_ALLIANCE' => constant($this->sprache("TCAP_ALLIANCE")),
			'T_CAP_RANK' => constant($this->sprache("TCAP_RANK")),
			/* */

			/* 10/04/08 - AC: New menus addition */
			'L_SHIPS' => constant($this->sprache("SHIPS")),
			'U_SHIPS' => parse_link('a=ships'),

            // 18/02/11 - AC: New entry, used to setup the correct URL of the game in 
            //            the attribute 'oCMenu.onlineUrl' of the skins that have 
            //            coolmenus in them.
            'GAME_URL' => JSCRIPT_PATH,
		);



	$template_vars['ACTIVE_PLANET_FLEETS']='<form action="'.parse_link('a=ship_fleets_display').'" name="fleetselect" type="GET">
	<input type="hidden" name="a" value="ship_fleets_display">
	<select name="pfleet_details" size="4" style="width: 100px;" onChange="document.fleetselect.submit()">';

	$fleetquery=$db->query('SELECT fleet_id, fleet_name, n_ships FROM ship_fleets WHERE planet_id = '.$this->planet['planet_id'].' AND user_id='.$this->player['user_id']);

	$select_size = ($db->num_rows($fleetquery) + 1);
	if($select_size==1) $template_vars['ACTIVE_PLANET_FLEETS'].='<option></option>';

	while (($fleet=$db->fetchrow($fleetquery))==true)
		$template_vars['ACTIVE_PLANET_FLEETS'].='<option value="'.$fleet['fleet_id'].'">'.$fleet['fleet_name'].' ('.$fleet['n_ships'].')</option>';

	$template_vars['ACTIVE_PLANET_FLEETS'].='</select></form>';







	if (!$this->SITTING_MODE)
	{
		$sql = 'SELECT tick_id FROM config';
		$tickqry = $db->query($sql);

		$sql = 'SELECT user_id,user_name FROM user WHERE user_active=1 AND user_auth_level<>'.STGC_BOT.' AND (user_sitting_id1='.$this->player['user_id'].' OR user_sitting_id2='.$this->player['user_id'].' OR user_sitting_id3='.$this->player['user_id'].' OR user_sitting_id4='.$this->player['user_id'].' OR user_sitting_id5='.$this->player['user_id'].')AND num_sitting>=0 AND (user_vacation_start <= '.$this->config['tick_id'].' OR user_vacation_end >= '.$this->config['tick_id'].') ORDER by user_name ASC'; 
		$susr = $db->query($sql);



		$template_vars['USER_SITTING']='<form action="'.parse_link('a=settings').'" name="sittingselect" type="GET">
		<input type="hidden" name="a" value="settings">
		<input type="hidden" name="view" value="sitting">
		<select name="login_sitting" size="4" style="width: 100px;" onChange="document.sittingselect.submit()">';

		$select_size = ($db->num_rows($susr) + 1);
		if($select_size==1) $template_vars['USER_SITTING'].='<option></option>';

		while($sittinguser = $db->fetchrow($susr)) 
			$template_vars['USER_SITTING'].='<option value="'.$sittinguser['user_id'].'">'.$sittinguser['user_name'].'</option>';
		$template_vars['USER_SITTING'].='</select></form>';

		//$template_vars['USER_SITTING']='<i>Wegen Lags deaktiviert</i><br>Bitte unter Einstellungen zugreifen.';
	}
	else $template_vars['USER_SITTING']='<a href='.parse_link('a=settings&view=sitting&login_sitting=-1').'><i>'.constant($this->sprache("LOGOUT")).'</i></a>';



	$system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$this->planet['system_id']);
	$template_vars['ACTIVE_PLANET_POSITION']=$this->get_sector_name($this->planet['sector_id']).':'.$this->get_system_cname($system['system_x'],$system['system_y']).':'.($this->planet['planet_distance_id'] + 1);




        $rank_honor = array(0, 200, 500, 1000, 1750, 2500, 3500, 5000, 7000, 10000);
        $rank_nr = 1;

		if($this->player['user_honor'] >= $rank_honor[9]) $rank_nr = 10;
        elseif($this->player['user_honor'] >= $rank_honor[8]) $rank_nr = 9;
        elseif($this->player['user_honor'] >= $rank_honor[7]) $rank_nr = 8;
        elseif($this->player['user_honor'] >= $rank_honor[6]) $rank_nr = 7;
        elseif($this->player['user_honor'] >= $rank_honor[5]) $rank_nr = 6;
        elseif($this->player['user_honor'] >= $rank_honor[4]) $rank_nr = 5;
        elseif($this->player['user_honor'] >= $rank_honor[3]) $rank_nr = 4;
        elseif($this->player['user_honor'] >= $rank_honor[2]) $rank_nr = 3;
        elseif($this->player['user_honor'] >= $rank_honor[1]) $rank_nr = 2;
        elseif($this->player['user_honor'] >= $rank_honor[0]) $rank_nr = 1;
        
        $template_vars['USER_RANK']='<img src="'.$this->GFX_PATH.'rank_'.$rank_nr.'.jpg" border=0>';

        if($this->player['user_auth_level'] != STGC_DEVELOPER && $this->player['user_auth_level'] != STGC_SUPPORTER) {
            $template_vars['U_SUPPORTCENTER'] = $template_vars['L_SUPPORTCENTER'] = '';
        }

        if($this->player['user_auth_level'] != STGC_DEVELOPER && $this->player['user_auth_level'] != STGC_SUPPORTER) {
            $template_vars['U_ADMINPANEL'] = $template_vars['L_ADMINPANEL'] = '';
        }

        foreach($template_vars as $name => $content) {
            $this->template_html = str_replace('{'.$name.'}', $content, $this->template_html);
        }

        echo $this->template_html;

        global $start_time;

        $total_time = (time() + microtime()) - $start_time;
echo '<center>';


echo'<div style="font-family: verdana; font-size: 11px;">'.round($total_time, 4).' secs&nbsp;&nbsp;-&nbsp;&nbsp;'.$db->i_query.' queries<br></div>';

// The following line is a copyright mark and must not be altered, removed or hidden in any way:
echo'<div style="font-family: verdana; font-size: 10px;">based on stgc.de</div>';

echo'

<!-- PHP Exec Time:    '.($total_time - $db->t_query).' secs -->
<!-- MySQL Query Time: '.$db->t_query.' secs -->
<br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>

</html>
        ';

        //stgc_log('performance', $_SERVER['QUERY_STRING'].'|'.($total_time - $db->t_query).'|'.$db->t_query);
	}

	function set_autorefresh($seconds) {
		if($seconds > 30) $this->auto_refresh = $seconds;

		return true;
	}

	function print_login_error($message) {
		$message .= '<br><br><a href="../index.php?a=login">Login</a>';

		message(GENERAL, $message);
	}

	function prepare_player($player_data, $sitting_mode = false) {
		$this->player = $player_data;
		$this->SITTING_MODE = $sitting_mode;

		$this->PLAIN_GFX_PATH = ($this->PROXY_MODE) ? PROXY_GFX_PATH : $this->player['user_gfxpath'];
		$this->GFX_PATH = $this->PLAIN_GFX_PATH.$this->player['user_skinpath'];

		// Workaround, bis die Links angepasst sind
		//$this->PLAIN_GFX_PATH = 'http://web11.h1220.serverkompetenz.net/';

		if(empty($this->player['user_jspath'])) $this->player['user_jspath'] = JSCRIPT_PATH;

		$this->uid = $this->player['user_id'];

		$this->options = unserialize(stripslashes($this->player['user_options']));
	}

	function init_player($awaiting_click = 0) {
		global $db, $RACE_DATA, $MAX_POINTS;

		if(empty($this->player)) {
			message(GENERAL, 'Invalid call of game->init_player(): game::$player is empty');
		}

		// NO message(NOTICE) in this function, since the planets data will not be loaded

		if(!empty($awaiting_click)) {
			if(empty($_GET['c'])) {
				message(GENERAL, constant($this->sprache("INVCALL1")));
			}

			$click_id = substr(addslashes($_GET['c']), 0, 32);

			$db->query_lowlevel('LOCK TABLES click_id WRITE');

			$sql = 'SELECT user_id, class
			        FROM click_ids
			        WHERE click_id = "'.$click_id.'" AND
			              user_id = '.$this->uid.' AND
			              class = '.$awaiting_click;

			if(($click_data = $db->queryrow($sql)) === false) {
				message(DATABASE_ERROR, 'Could not query click id data');
			}

			if(empty($click_data['user_id'])) {
				message(GENERAL, constant($this->sprache("INVCALL2")));
			}

			if( ((int)$click_data['user_id'] != $this->uid) || ((int)$click_data['class'] != $awaiting_click) ) {
				message(GENERAL, constant($this->sprache("INVCALL3")));
			}

			$sql = 'DELETE FROM click_ids
			        WHERE click_id = "'.$click_id.'" AND
			              user_id = '.$this->uid.' AND
			              class = '.$awaiting_click;

			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not delete click id data');
			}

			$db->query_lowlevel('UNLOCK TABLES');
		}

		if(!empty($_REQUEST['switch_active_planet'])) {
			$planet_id = (int)$_REQUEST['switch_active_planet'];

			$sql = 'SELECT planet_id, planet_owner
			        FROM planets
			        WHERE planet_id = '.$planet_id;

			if(($switch_planet = $db->queryrow($sql)) === false) {
				message(DATABASE_ERROR, 'Could not query planet data');
			}

			if(empty($switch_planet['planet_id'])) {
				message(GENERAL, constant($this->sprache("NOPLANETFND")));
			}

			if($switch_planet['planet_owner'] != $this->uid) {
				message(GENERAL, constant($this->sprache("NOPLANETOWN")));
			}

			$sql = 'UPDATE user
			        SET active_planet = '.$planet_id.'
			        WHERE user_id = '.$this->uid;

			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not update planet active data');
			}

			$this->player['active_planet'] = $planet_id;
		}
		else {
			if(!$this->SITTING_MODE && !defined('OVERRIDE_UID_MODE')) {

				$sql = 'UPDATE user
				            SET last_active = '.$this->TIME.',
				                last_ip = "'.$_SERVER["REMOTE_ADDR"].'", 
				                num_hits=num_hits+1
				                WHERE user_id = '.$this->uid;

				$db->query($sql);

				$db->lock('user_iplog');

				$sql = 'SELECT id,ip FROM user_iplog WHERE user_id = '.$this->uid.' ORDER BY id DESC LIMIT 1';

				if(($user_iplog = $db->queryrow($sql)) === false) {
					message(DATABASE_ERROR, 'Could not query iplog data');
				}

				if($user_iplog['ip']!=$_SERVER["REMOTE_ADDR"] || empty($user_iplog['id'])) {

					$sql = 'INSERT INTO user_iplog (user_id, ip, time) VALUES ('.$this->uid.',"'.$_SERVER["REMOTE_ADDR"].'",'.time().')';

					$db->query($sql);
				}

				$db->unlock('user_iplog');

			}

			if($this->SITTING_MODE) {
				if ($this->player['num_sitting']>=0)
				{
					/* 13/05/10 - AC: Removed update field last_active with sitting */
					$sql = 'UPDATE user
					        SET num_sitting=num_sitting+1
					        WHERE user_id = '.$this->uid;
					$db->query($sql);
				}
				else
				{
						echo constant($this->sprache("SITBLOCKED"));
						$cookie_data = array(
						'user_id' => $game->player['sitting_user_id'],
						'user_password' => $game->player['sitting_user_password']);

						if(!setcookie('stgc5_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {
						message(GENERAL, constant($this->sprache("NOCOOKIE")), 'setcookie() = false');}
						exit;
				}

				/* 14/06/10 - AC: Now we store in a separate table the sitter's IP */
				$db->lock('user_sitter_iplog');

				$sql = 'SELECT id,ip FROM user_sitter_iplog WHERE user_id = '.$this->uid.' ORDER BY id DESC LIMIT 1';

				if(($user_sitter_iplog = $db->queryrow($sql)) === false) {
					message(DATABASE_ERROR, 'Could not query sitter_iplog data');
				}

				if($user_sitter_iplog['ip']!=$_SERVER["REMOTE_ADDR"] || empty($user_sitter_iplog['id'])) {

					$sql = 'INSERT INTO user_sitter_iplog (user_id, sitter_id, ip, time)
					        VALUES ('.$this->uid.','.$this->player['sitting_user_id'].',"'.$_SERVER["REMOTE_ADDR"].'",'.time().')';

					$db->query($sql);
				}

				$db->unlock('user_sitter_iplog');
			}

		}

		$this->load_active_planet();

		if($this->player['pending_capital_choice'] && !$this->SITTING_MODE) {
			if(!empty($_POST['new_capital'])) {
				$planet_id = (int)$_POST['new_capital'];

				$sql = 'SELECT planet_id, planet_owner, system_id
				        FROM planets
				        WHERE planet_id = '.$planet_id;

				if(($new_capital = $db->queryrow($sql)) === false) {
					message(DATABASE_ERROR, 'Could not query planet data');
				}

				if(empty($new_capital['planet_id'])) {
					message(GENERAL, constant($this->sprache("NOPLANETFND")));
				}

				if($new_capital['planet_owner'] != $this->uid) {
					message(GENERAL, constant($this->sprache("NOPLANETOWN")));
				}

				$sql = 'UPDATE user
				        SET user_capital = '.$planet_id.',
				            pending_capital_choice = 0
				        WHERE user_id = '.$this->uid;

				if(!$db->query($sql)) {
					message(DATABASE_ERROR, 'Could not update user capital data');
				}

				$sql = 'UPDATE planets
				        SET planet_available_points = '.$MAX_POINTS[1].'
				        WHERE planet_id = '.$planet_id;

				if(!$db->query($sql)) {
					message(DATABASE_ERROR, 'Could not update capital planet structure points');
				}

				if(!$db->query('SET @i=0')) {
					message(DATABASE_ERROR, 'Could not set sql iterator variable for planet owner enum! SKIP');
				}

				$sql = 'UPDATE planets
				        SET planet_owner_enum = (@i := (@i + 1))-1
				        WHERE planet_owner = '.$this->uid.'
				        ORDER BY planet_owned_date ASC';

				if(!$db->query($sql)) {
					message(DATABASE_ERROR, 'Could not update planet owner enum data! SKIP');
				}

				$this->refactor_structure_points($planet_id, $this->uid);

				$this->player['user_capital'] = $planet_id;
				$this->player['pending_capital_choice'] = 0;

				// Mark the new home system as private
				if(HOME_SYSTEM_PRIVATE) {
					$sql = 'UPDATE starsystems SET system_closed = 1,
					                               system_owner = '.$this->uid.'
					        WHERE system_id = '.$new_capital['system_id'];

					if(!$db->query($sql)) {
						message(DATABASE_ERROR, 'Could not update system owner data! SKIP');
					}
				}
			}
			else {
				$sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_type, p.planet_distance_id, p.planet_points, p.planet_next_attack,
				               s.system_x, s.system_y
				        FROM (planets p)
				        INNER JOIN (starsystems s) ON s.system_id = p.system_id
				        WHERE planet_owner='.$this->uid.'
				        ORDER BY p.planet_owned_date ASC';

				if(!$q_planets = $db->query($sql)) {
					message(DATABASE_ERROR, 'Could not query whole planets data for capital choice');
				}

				$msg_html = constant($this->sprache("HOMELOST")).'<br><br><table border="0"><form method="post" action="'.parse_link().'">';

				$i = 0;

				while($planet = $db->fetchrow($q_planets)) {
					$msg_html .= '<tr><td valign="top"><input type="radio" name="new_capital" value="'.$planet['planet_id'].'"'.( ($i == 0) ? ' checked="checked"' : '' ).'></td><td><u>'.$planet['planet_name'].'</u> ('.$this->get_sector_name($planet['sector_id']).':'.$this->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')<br>'.constant($this->sprache("TCLASS")).' <i>'.strtoupper($planet['planet_type']).'</i><br>'.constant($this->sprache("TPOINTS")).' <i>'.$planet['planet_points'].'</i>';

					if($planet['planet_attacked']) $msg_html .= '<br><span style="color: #FF0000;">'.constant($this->sprache("REDALARM")).'</span>';

					$msg_html .= '</td><tr><td height="3"></td></tr>';
				}

				$msg_html .= '<tr><td colspan="2" align="center"><input class="button" type="submit" value="'.constant($this->sprache("APPLY")).'"></td></tr></form></table>';

				message(GENERAL, $msg_html);
			}
		}

		// Check whether it is a race for players allowed to play

		if( ($this->player['user_auth_level'] == STGC_PLAYER) && (!$RACE_DATA[$this->player['user_race']][22]) && ($this->player['user_id']!=7103)  && ($this->player['user_id']!=4)) {
			message(GENERAL, constant($this->sprache("INVRACE")), 'user_race = '.$this->player['user_race']);
		}

		// Retrieve coordinates of the user planet capital

		$sql = 'SELECT system_id FROM planets WHERE planet_id = '.$this->player['user_capital'];
		if(!$capitalsystem = $db->queryrow($sql)) {
			message(DATABASE_ERROR, 'Could not query user capital data');
		}

		$sql = 'SELECT system_id, system_global_x, system_global_y FROM starsystems WHERE system_id = '.$capitalsystem['system_id'];
		if(!$capitalcoord = $db->queryrow($sql)) {
			message(DATABASE_ERROR, 'Could not query user capital starsystem data');
		}
		else {
			$this->capital_system_id = $capitalcoord['system_id'];
			$this->capital_global_x  = $capitalcoord['system_global_x'];
			$this->capital_global_y  = $capitalcoord['system_global_y'];
		}
	}

	function init_planet($data) {
		global $PLANETS_DATA, $MAX_BUILDING_LVL;

		$this->planet = $data;

		$this->planet['min_troops_required'] = $this->planet['min_security_troops'];


		$MAX_BUILDING_LVL[0][9] += $this->planet['research_3'];
		$MAX_BUILDING_LVL[1][9] += $this->planet['research_3'];
		$MAX_BUILDING_LVL[0][12] += $this->planet['research_3'];
		$MAX_BUILDING_LVL[1][12] += $this->planet['research_3'];
	}

	function load_active_planet() {
		global $db;

		if($this->player['user_auth_level'] == STGC_BOT) {
			$this->planet = array(
				'planet_id' => 99999, 'planet_name' => $game->player['user_name'].'&acute;s Home',
				'system_id' => 99999, 'system_name' => 'Bot-Land', 'system_x' => -1, 'system_y' => -1, 'system_global_x' => -1, 'system_global_y' => -1,
				'sector_id' => 999,
				'planet_type' => 'x',
				'planet_owner' => $game->player['user_id'], 'planet_owned_date' => 0,
				'planet_distance_id' => -1, 'planet_distance_px' => -1, 'planet_covered_distance' => 0, 'planet_current_x' => -1, 'planet_current_y' => -1,
				'planet_points' => 99999,
				'planet_thumb' => '',
				'research_1' => 999, 'research_2' => 999, 'research_3' => 999, 'research_4' => 999, 'research_5' => 999,
				'resource_1' => -1, 'resource_2' => -1, 'resource_3' => -1, 'resource_4' => -1,
				'add_1' => -1, 'add_2' => -1, 'add_3' => -1, 'add_4' => -1, 'recompute_static' => 0, 'max_resources' => -1, 'max_worker' => -1, 'max_units' => -1,
				'building_1' => 999, 'building_2' => 999, 'building_3' => 999, 'building_4' => 999, 'building_5' => 999, 'building_6' => 999, 'building_7' => 999, 'building_8' => 999, 'building_9' => 999, 'building_10' => 999, 'building_11' => 999, 'building_12' => 999,
				'unit_1' => -1, 'unit_2' => -1, 'unit_3' => -1, 'unit_4' => -1, 'unit_5' => -1, 'unit_6' => -1,
				'workermine_1' => 0, 'workermine_2' => 0, 'workermine_3' => 0,
				'catresearch_1' => 0, 'catresearch_2' => 0, 'catresearch_3' => 0, 'catresearch_4' => 0, 'catresearch_5' => 0, 'catresearch_6' => 0, 'catresearch_7' => 0, 'catresearch_8' => 0, 'catresearch_9' => 0, 'catresearch_10' => 0,
				'unittrainid_1' => -1, 'unittrainid_2' => -1, 'unittrainid_3' => -1, 'unittrainid_4' => -1, 'unittrainid_5' => -1, 'unittrainid_6' => -1, 'unittrainid_7' => -1, 'unittrainid_8' => -1, 'unittrainid_9' => -1, 'unittrainid_10' => -1, 'unittrain_actual' => -1, 'unittrainid_nexttime' => -1
			);
		}


		$order[0]=' planet_name ASC';
		$order[1]=' planet_points DESC';
		$order[2]=' planet_owned_date ASC';
		$order[3]=' sector_id ASC, system_id ASC';
		$order[4]=' ((unit_1*2+unit_2*3+unit_3*4+unit_4*4)/min_security_troops) ASC';
		$order[5]=' planet_type ASC';
		$order[6]=' planet_altname ASC';

		$sql = 'SELECT planet_id, planet_name, planet_owner
		        FROM planets
		        WHERE planet_owner = '.$this->player['user_id'].' ORDER BY '.$order[$this->option_retr('planetlist_order')];

		unset($this->player['planets']);

		if(!$q_planets = $db->query($sql)) {
			message(DATABASE_ERROR, 'Could not query users planet data');
		}

		while($_planet = $db->fetchrow($q_planets)) {
			$this->player['planets'][] = $_planet;
		}

		if(empty($this->player['planets'])) {
			// User cannot choose quadrant
			if(USER_CHOOSE_QUADRANT == 0) {
				// Random quadrant and no type selection
				$this->set_planet(0,'');
				message(GENERAL, constant($this->sprache("NEWPLANET1")).' <i>'.$this->player['user_name'].'</i> '.constant($this->sprache("NEWPLANET2")));
			}
			else {
				global $RACE_DATA;

				$race=$RACE_DATA[$this->player['user_race']][0];

				// Count players of player's race on each quadrant
				$tips = array();
				for ($quad = 1; $quad < 5; $quad++)
				{
					$text = '';
					for ($race = 0; $race < 13; $race++)
					{
						// Skip Borg, Q and 29th Humans races
						if($race == 6 || $race == 7 || $race == 12)
							continue;

						$sql = 'SELECT user_id FROM planets, user
						        WHERE planet_owner = user_id AND
						              user_race='.$race.' AND
						              user_auth_level < '.STGC_DEVELOPER.' AND
						              CEIL(sector_id / 81) = '.$quad.'
						              GROUP BY user_id';

						if(!$q_players = $db->query($sql)) {
							message(DATABASE_ERROR, 'Could not query users data');
						}

						$players = 0;
						while($_player = $db->fetchrow($q_players)) {
							$players++;
						}
						$text .= $RACE_DATA[$race][0].': '.$players.'<br>';
					}
					$tips[$quad] = overlib(constant($this->sprache("NUM_PLAYERS")),$text);
				}

				echo '
				<html>
				<head>
				<title>Frontline Combat :: Choosing Quadrant</title>
				<style type="text/css">
				<!--
				a:link    { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:visited { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:hover   { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #FFFFFF; }
				a:active  { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }

				td { font-family: Arial,serif; font-size: 12px; color: #FFFFFF; }

				input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
				{ color: #959595; font-family: Verdana; font-size: 10px; background-color: #000000; border: 1px solid #959595; }

				//-->
				</style>

				<script type="text/javascript" language="JavaScript" src="'.$this->player['user_jspath'].'overlib.js"></script>

				</head>

				<body bgcolor="#000000" background="../gfx/template_bg.jpg">
				<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border: 1px solid #C0C0C0;">
				<tr>
					<td><span style="font-size: 14px; font-weight: bold;">Frontline Combat :: System-Announcement</span></td>
				</tr>
				</table>
				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border-left: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0;">
				<tr>
					<td>'.constant($this->sprache("NEWPLANET1")).' <i>'.$this->player['user_name'].'</i>.<br>
					'.constant($this->sprache("NEWPLANET3")).'<br><br>
					<form action="index.php" method="POST">
					<table>
					<tr>
						<td>'.constant($this->sprache("TCLASS")).'</td>
						<td>&nbsp;</td>
						<td><input type="radio" name="type" value="m"> M</td>
					</tr>
					<tr>
						<td></td>
						<td>&nbsp;</td>
						<td><input type="radio" name="type" value="o"> O</td>
					</tr>
					</table><br>
					<table>
					<tr><td>'.constant($this->sprache("STARTPOINT")).'</td><td>&nbsp;</td><td><input type="radio" name="quadrant" value="0"> '.constant($this->sprache("RANDOM")).'</td></tr>
					<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="radio" name="quadrant" value="1"> '.constant($this->sprache("GAMMAQ")).'</td><td>'.$tips[1].'</td></tr>
					<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="radio" name="quadrant" value="2"> '.constant($this->sprache("DELTAQ")).'</td><td>'.$tips[2].'</td></tr>
					<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="radio" name="quadrant" value="3"> '.constant($this->sprache("ALPHAQ")).'</td><td>'.$tips[3].'</td></tr>
					<tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="radio" name="quadrant" value="4"> '.constant($this->sprache("BETAQ")).'</td><td>'.$tips[4].'</td></tr>
					</table>
					<br><center>
					<input type="submit" name="set_planet" value="'.constant($this->sprache("COLONIZE")).'" class="button">
					</center>
					</form></td>
				</tr>
				</table>
				</body>
				</html>
				';
				exit;
			}
		}

		$sql = 'SELECT planets.*,
		               starsystems.system_name, starsystems.system_x, starsystems.system_y, starsystems.system_global_x, starsystems.system_global_y
		        FROM planets, starsystems
		        WHERE planets.planet_id = '.$this->player['active_planet'].' AND
		              starsystems.system_id = planets.system_id';

		if(($active_planet = $db->queryrow($sql)) === false) {
			message(DATABASE_ERROR, 'Could not query active planet data');
		}

		if( (empty($active_planet)) || ($active_planet['planet_owner'] != $this->player['user_id']) ) {
			$sql = 'SELECT planets.*,
			               starsystems.system_name, starsystems.system_x, starsystems.system_y, starsystems.system_global_x, starsystems.system_global_y
			        FROM planets, starsystems
			        WHERE planets.planet_owner = '.$this->player['user_id'].' AND
			              starsystems.system_id = planets.system_id
			        ORDER BY planets.planet_owned_date
			        LIMIT 0, 1';

			if(($active_planet = $db->queryrow($sql)) === false) {
				message(DATABASE_ERROR, 'Could not query users first planet data');
			}

			$sql = 'UPDATE user
			        SET active_planet = '.$active_planet['planet_id'].'
			        WHERE user_id = '.$this->player['user_id'];

			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not update user active data');
			}
		}

		$this->player['user_planets'] = count($this->player['planets']);

		$this->init_planet($active_planet);
	}

	function set_active_planet($id) {
		global $db;

		$sql = 'SELECT planet_id
		        FROM planets
		        WHERE planet_id = '.$id.' AND
		              planet_owner = '.$this->player['user_id'];

		if(($planet = $db->queryrow($sql)) === false) {
			message(DATABASE_ERROR, 'Could not query planet data');
		}

		if(!empty($planet['planet_id'])) {
			$db->query('UPDATE user SET active_planet = '.$id.' WHERE user_id = '.$this->player['user_id']);
			$this->player['active_planet'] = $id;
		}

		$this->load_active_planet();
	}

	function register_click_id($class) {
		global $db;

		if(!empty($this->CLICK_ID)) return;

		$db->query_lowlevel('LOCK TABLES click_ids WRITE');

		$sql = 'SELECT click_id
		        FROM click_ids
		        WHERE user_id = '.$this->uid.' AND
		              class = '.$class;

		if(($click_id_exist = $db->queryrow($sql)) === false) {
			message(DATABASE_ERROR, 'Could not query click id data');
		}

		if(!empty($click_id_exist['click_id'])) {
			$this->CLICK_ID = $click_id_exist['click_id'];
		}
		else {
			$this->CLICK_ID = md5( (mt_rand(1, 100) / 100) * (mt_rand(1, 100) / 100) * (mt_rand(1, 100) / 100) );

			$sql = 'INSERT INTO click_ids (click_id, user_id, class)
			    VALUES ("'.$this->CLICK_ID.'", '.$this->uid.', '.$class.')';

			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not insert new click id data');
			}
		}

		$db->query_lowlevel('UNLOCK TABLES');

		return true;
	}

	function get_quadrant_id($sector_id) {
		return ceil( ( $sector_id / $this->sectors_per_quadrant) );
	}

	function get_quadrant($sector_id) {
		return $this->get_quadrant_id($sector_id);
	}

	function get_quadrant_range($quadrant_id) {
		switch($quadrant_id) {
			case 1:
				$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
				$numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
			break;

			case 2:
				$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
				$numbers = array('10', '11', '12', '13', '14', '15', '16', '17', '18');
			break;

			case 3:
				$letters = array('J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R');
				$numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
			break;

			case 4:
				$letters = array('J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R');
				$numbers = array('10', '11', '12', '13', '14', '15', '16', '17', '18');
			break;
		}

		return array(
			'letters' => $letters,
			'numbers' => $numbers
		);
	}

	function getc_sector_name($sector_id) {
		// No longer needed, since dynamic calculation is now fast enough

		return $this->get_sector_name($sector_id);
	}

	function get_sector_name($sector_id) {
		$quadrant_id = $this->get_quadrant_id($sector_id);
		$sector_id -= ( ($quadrant_id - 1) * $this->sectors_per_quadrant );

		extract($this->get_quadrant_range($quadrant_id));

		$div = (int) ($sector_id / $this->quadrant_map_split);
		$mod = ($sector_id % $this->quadrant_map_split);

		if($mod == 0) {
			$div--;
			$mod = 8;
		}
		else $mod--;

		return $letters[$div].$numbers[$mod];
	}

		function get_sector_id($sector_name) {
			$letters = array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17);

		$y = $letters[$sector_name[0]];
		$x = (int)substr($sector_name, 1) - 1;

		if($y < $this->quadrant_map_split) {
			$quadrant_id = ($x < $this->quadrant_map_split) ? 1 : 2;
		}
		else {
			$quadrant_id = ($x < $this->quadrant_map_split) ? 3 : 4;
		}

		$y++; $x++;

		if($y > $this->quadrant_map_split) $y -= $this->quadrant_map_split;
		if($x > $this->quadrant_map_split) $x -= $this->quadrant_map_split;

		$sector_id = ($quadrant_id - 1) * $this->sectors_per_quadrant;
		$sector_id += ($y - 1) * $this->quadrant_map_split;
		$sector_id += $x;

		return $sector_id;
	}

	function get_sector_coords($sector_id) {
		$quadrant_id = $this->get_quadrant($sector_id);
		$sector_id -= ( ($quadrant_id - 1) * ($this->sectors_per_quadrant) );

		$_div = floor( ($sector_id / $this->quadrant_map_split) );
		if( ($_div * $this->quadrant_map_split) == $sector_id ) $_div--;

		$sector_x = ( $sector_id - ($_div * $this->sector_map_split) );
		$sector_y = ($_div + 1);

		return array($sector_x, $sector_y);
	}

	function get_system_cname($system_x, $system_y) {
		if(empty($system_y)) return; // Workaround, damit noch ohne Planet gebootet werden kann...irgendwer musste diese Methode ja bei jedem Klick benutzen -.-

		$letters = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I');
		$numbers = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9');

		if(!isset($letters[$system_y])) {
			message(GENERAL, constant($this->sprache("INVYCOORD")), 'game->get_system_cname(): Could not find letter for y-coord '.$system_y);
		}

		if(!isset($numbers[$system_x])) {
			message(GENERAL, constant($this->sprache("INVXCOORD")), 'game->get_system_cname(): Could not find number for x-coord '.$system_x);
		}

		return $letters[$system_y].$numbers[$system_x];
	}

	function get_system_gcoords($system_x, $system_y, $sector_id) {
		$quadrant_id = $this->get_quadrant($sector_id);
		$sector_coords = $this->get_sector_coords($sector_id);

		$system_global_x = ( ( ( ($quadrant_id == 2) || ($quadrant_id == 4) ) ? ($this->quadrant_map_split * $this->sector_map_split) : 0 ) + // If there is any quadrant before
		                     ( ($sector_coords[0] - 1) * $this->sector_map_split) + // If there is any sector before
		                     ( $system_x ) ); // And the systems...

		$system_global_y = ( ( ( ($quadrant_id == 3) || ($quadrant_id == 4) ) ? ($this->quadrant_map_split * $this->sector_map_split) : 0 ) + // If there is any quadrant before
		                     ( ($sector_coords[1] - 1) * $this->sector_map_split) + // If there is any sector before
		                     ( $system_y ) ); // And the systems...

		return array($system_global_x, $system_global_y);
	}

    function is_ally_explored($system_id)
    {
        global $db;

        if($this->player['user_auth_level'] == STGC_DEVELOPER) return true;

        $sql = 'SELECT timestamp FROM starsystems_details
                WHERE system_id = '.$system_id.' AND
                      alliance_id = '.$this->player['user_alliance'];
        if(($res = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query starsystem details');
        }

        if(!empty($res['timestamp'])) return true;
        else return false;
    }

    function is_user_explored($system_id)
    {
        global $db;

        if($this->player['user_auth_level'] == STGC_DEVELOPER) return true;        

        $sql = 'SELECT timestamp FROM starsystems_details
                WHERE system_id = '.$system_id.' AND
                      user_id = '.$this->player['user_id'];
        if(($res = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query starsystem details');
        }

        if(!empty($res['timestamp'])) return true;
        else return false;
    }

    function is_system_allowed($system_id)
    {
        global $db;
        // We return true for a system where we can go freely

        if($this->player['user_auth_level'] == STGC_DEVELOPER) return true;

        $sql = 'SELECT system_owner FROM starsystems
                WHERE system_id = '.$system_id;

        if(($res = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query starsystem details');
        }

        if($res['system_owner'] == 0) return true;

        if($res['system_owner'] == $this->player['user_id']) return true;

        return false;
    }

	// Veraltet, besser direkter Zugriff durch world.php
	function create_system($id_type, $id_value) {
		include_once('include/libs/world.php');

		return create_system($id_type, $id_value);
	}

	// Obsolete, better direct access by world.php
	function create_planet($user_id, $id_type, $id_value, $selected_type = 'r', $race = 0) {
		include_once('include/libs/world.php');

		return create_planet($user_id, $id_type, $id_value, $selected_type, $race);
	}

	// Return the distance between two systems
	function get_distance($s_system, $d_system){
		include_once('include/libs/moves.php');

		return get_distance($s_system, $d_system);
	}

	function uc_get($uid) {
		if( isset($uid) && ( (!isset($this->uid_cache[$uid])) || (empty($this->uid_cache[$uid]))) ) {
			global $db;

			$sql = 'SELECT user_id, user_name
			        FROM user
			        WHERE user_id = '.$uid;

			if(($user = $db->queryrow($sql)) === false) {
				message(DATABASE_ERROR, 'Could not query uc-user data');
			}

			if(empty($user['user_id'])) {
				$this->uid_cache[$uid] = false;
			}
			else {
				$this->uid_cache[$uid] = $user['user_name'];
			}
		}

		return $this->uid_cache[$uid];
	}

    // Old uc_get replaced by new KS.
    /*

    function uc_get($uid) {
        if( (!isset($this->uid_cache[$uid])) || (empty($this->uid_cache[$uid])) ) {
            global $db;

            $sql = 'SELECT user_id, user_name
                    FROM user
                    WHERE user_id = '.$uid;

            if(($user = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'Could not query uc-user data');
            }

            if(empty($user['user_id'])) {
                $this->uid_cache[$uid] = false;
            }
            else {
                $this->uid_cache[$uid] = $user['user_name'];
            }
        }

        return $this->uid_cache[$uid];
    }

    */

	function uc_store($uid, $user_name) {
		$this->uid_cache[$uid] = $user_name;

		return true;
	}


	function option_store($name,$content)
	{
		global $db;
		if (!isset($this->player['user_id'])) message(GENERAL, 'Option_Store(...) failed. User not defined!');
		$this->options[$name]=$content;
		$sql = 'UPDATE user
		        SET user_options = "'.addslashes(serialize($this->options)).'" WHERE user_id = '.$this->player['user_id'];

		if(!$db->query($sql)) {
			message(DATABASE_ERROR, 'Could not update options');
		}
	}

	function option_retr($name, $std=0)
	{
		if (isset($this->options[$name]))
		return $this->options[$name];
		else return $std;
	}

	/* 12/03/08: CD - Add quadrant selection based on user's race */
	function pick_quadrant()
	{
		$picked_quadrant = 0;

		switch($this->player['user_race']) {
		case 0:		// Federazione
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 15)
				$picked_quadrant--;
			if ($magic_number < 85)
				$picked_quadrant--;
			break;
		case 1:		// Romulani
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 15)
				$picked_quadrant--;
			if ($magic_number < 50)
				$picked_quadrant--;
			break;
		case 2:		// Klingon
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 15)
				$picked_quadrant--;
			if ($magic_number < 85)
				$picked_quadrant--;
			break;
		case 3:		// Cardassiani
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 70)
				$picked_quadrant--;
			if ($magic_number < 75)
				$picked_quadrant--;
			if ($magic_number < 95)
				$picked_quadrant--;
			break;
		case 4:		// Dominion
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 5)
				$picked_quadrant--;
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 40)
				$picked_quadrant--;
			break;
		case 5:		// Ferengi
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 20)
				$picked_quadrant--;
			if ($magic_number < 25)
				$picked_quadrant--;
			if ($magic_number < 95)
				$picked_quadrant--;
			break;
		case 8:		// Breen
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 75)
				$picked_quadrant--;
			if ($magic_number < 80)
				$picked_quadrant--;
			if ($magic_number < 95)
				$picked_quadrant--;
			break;
		case 9:		// Hirogeni
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 80)
				$picked_quadrant--;
			if ($magic_number < 90)
				$picked_quadrant--;
			break;
		case 10:	// Krenim
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 80)
				$picked_quadrant--;
			if ($magic_number < 90)
				$picked_quadrant--;
			break;
		case 11:	// Kazon
			$picked_quadrant = 4;
			$magic_number = mt_rand(1, 100);
			if ($magic_number < 10)
				$picked_quadrant--;
			if ($magic_number < 80)
				$picked_quadrant--;
			if ($magic_number < 90)
				$picked_quadrant--;
			break;
		default: 
			$picked_quadrant = mt_rand(1 ,4);
		}

		return($picked_quadrant);
	}

	function refactor_structure_points($capital, $user_id)
	{
		global $db, $MAX_POINTS;

		////////// Recupero le coordinate del pianeta capitale del giocatore

		$sql = 'SELECT system_id FROM planets WHERE planet_id = '.$capital;
		if(!$capitalsystem = $db->queryrow($sql)) {
			message(DATABASE_ERROR, 'Could not query planets data');
		}

		$sql = 'SELECT system_id, system_global_x, system_global_y FROM starsystems WHERE system_id = '.$capitalsystem['system_id'];
		if(!$capitalcoord = $db->queryrow($sql)) {
			message(DATABASE_ERROR, 'Could not query starsystems data');
		}

		///////////

		$sql = "SELECT p.planet_id, p.system_id, ss.system_global_x, ss.system_global_y
		        FROM planets p INNER JOIN starsystems ss ON p.system_id = ss.system_id
		        WHERE p.planet_owner = ".$user_id." AND p.planet_id != ".$capital;

		if(!$q_planets = $db->query($sql)) {
			message(DATABASE_ERROR, 'Could not query user planets data');
		}

		// DC: In God we trust
		while($_temp = $db->fetchrow($q_planets)) {
			if ($capitalcoord['system_id'] != $_temp['system_id']) {
				$distance = $this->get_distance(array($capitalcoord['system_global_x'], $capitalcoord['system_global_y']),
				array($_temp['system_global_x'], $_temp['system_global_y']));
				$distance = round($distance, 2);
			}
			else {
				$distance = 0;
			}

			if($distance > MAX_BOUND_RANGE) {
				$sql = 'UPDATE planets SET planet_available_points = '.$MAX_POINTS[2].'
				        WHERE planet_id = '.$_temp['planet_id'];
			}
			else {
				$sql = 'UPDATE planets SET planet_available_points = '.$MAX_POINTS[0].'
				        WHERE planet_id = '.$_temp['planet_id'];
			}
			$db->query($sql);
		}
	}

	function set_planet($quadrant,$type)
	{
		global $ACTUAL_TICK,$db;

		// Check if player REALLY doesn't have already a planet
		$sql = 'SELECT planet_id FROM planets WHERE planet_owner = '.$this->player['user_id'];

		if(!$db->query($sql)) {
			message(DATABASE_ERROR, 'Could not query user planets data');
		}

		if($db->num_rows() != 0)
			return 0;

		// Random quadrant
		if(!$quadrant)
			$quadrant = $this->pick_quadrant();

		$db->lock('starsystems_slots');
		// Give a whole system to the new player
		if(USER_WHOLE_SYSTEM) {
			$_temp = $this->create_system('quadrant', $quadrant, 1);
			$_system_id = $_temp[0];
			$_temp = $this->create_planet(0, 'system', $_system_id);
			$_temp = $this->create_planet(0, 'system', $_system_id);
			$_temp = $this->create_planet(0, 'system', $_system_id);
			$_temp = $this->create_planet(0, 'system', $_system_id);
			$planet_id = $this->create_planet($this->player['user_id'],'system', $_system_id,$type,$this->player['user_race']);
		}
		else
			$planet_id = $this->create_planet($this->player['user_id'],'quadrant', $quadrant,$type,$this->player['user_race']);
		$db->unlock();

		if(empty($planet_id)) {
			message(GENERAL, constant($this->sprache("NONEWPLANET")), '$planet_id = empty');
		}
		else {
			$sql = 'INSERT INTO planet_details (planet_id, user_id, alliance_id, source_uid, source_aid, timestamp, log_code) '
			. ' VALUES ('.$planet_id.', '.$this->player['user_id'].', 0, '.$this->player['user_id'].', 0, '.time().', 0)';
			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not update planet details data');
			}

			//DC FoW 2.0
			$sql = 'INSERT INTO starsystems_details (system_id, user_id, timestamp)
			        VALUES ('.$_system_id.', '.$this->player['user_id'].', '.time().')';

			if(!$db->query($sql)) {
				message(DATABASE_ERROR, 'Could not update starsystem details data');
			}
			//DC ----

			// Mark the newly created home system as private
			if(HOME_SYSTEM_PRIVATE) {
				$sql = 'UPDATE starsystems SET system_closed = 1,
				                               system_owner = '.$this->player['user_id'].'
				        WHERE system_id = '.$_system_id;

				if(!$db->query($sql)) {
					message(DATABASE_ERROR, 'Could not update system owner data');
				}
			}
		}

		$sql = 'UPDATE user
		        SET user_points = 10,
		            user_planets = 1,
		            user_attack_protection = '.($ACTUAL_TICK + USER_ATTACK_PROTECTION).',
		            user_capital = '.$planet_id.',
		            active_planet = '.$planet_id.'
		        WHERE user_id = '.$this->player['user_id'];

		if(!$db->query($sql)) {
			message(DATABASE_ERROR, 'Could not update user rest time');
		}

        // Update actual data with freshly created capital planet
        $this->player['user_capital'] = $this->player['active_planet'] = $planet_id;
	}

}

// #############################################################################

function get_alliance_name($alliance_id) {
	global $db, $game;

	$sql = 'SELECT alliance_name FROM alliance WHERE alliance_id = '.$alliance_id;

	if(($name_a = $db->queryrow($sql)) === false) {
		message(DATABASE_ERROR, 'Could not query uc-user data');
	}

	if($name_a['alliance_name']=='') {
		$name_a['alliance_name'] = constant($game->sprache("DELETED"));
	}

	return $name_a['alliance_name'];
}

// #############################################################################

function get_userid_by_planet($planet_id) {
	global $db;

	$sql = 'SELECT planet_owner AS user_id FROM planets WHERE planet_id = '.$planet_id;

	if(($user_id_a = $db->queryrow($sql)) === false) {
		message(DATABASE_ERROR, 'Could not get user_id');
	}

	return $user_id_a['user_id'];

}

// #############################################################################

function get_username_by_id($user_id) {
	global $db;

	$sql = 'SELECT user_name AS nickname FROM user WHERE user_id = '.$user_id;

	if(($user_id_a = $db->queryrow($sql)) === false) {
		message(DATABASE_ERROR, 'Could not get user_id');
	}

	return $user_id_a['nickname'];

}

// #############################################################################
// Neue Torsofunktion

function GlobalTorsoReq($ship)
{
	global $SHIP_TORSO, $game;

	$dat=array();

	if ($game->player['user_race']==0) // Fed
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=200;
		$dat[4]=400;
		$dat[5]=1000;
		$dat[6]=1500;
		$dat[7]=2500;
		$dat[8]=3500;
		$dat[9]=6000;
		$dat[10]=6500;
		$dat[11]=12000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==1) // Rom
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=1000;
		$dat[6]=0; //none ship
		$dat[7]=3500;
		$dat[8]=0; //none ship
		$dat[9]=6500;
		$dat[10]=0; //none ship
		$dat[11]=15000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==2) // Kling
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=1000;
		$dat[6]=0;
		$dat[7]=3500;
		$dat[8]=0; //none ship
		$dat[9]=6500;
		$dat[10]=0;
		$dat[11]=15000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==3) // Card
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=3000;
		$dat[8]=0;
		$dat[9]=6500;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==4) // Dom
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=1000;
		$dat[6]=0;
		$dat[7]=0;
		$dat[8]=0;
		$dat[9]=6000;
		$dat[10]=0;
		$dat[11]=15000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==5) // Ferg
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=250;
		$dat[3]=0; //none ship
		$dat[4]=250;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=3500;
		$dat[8]=0;
		$dat[9]=0;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==8) //Breen
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=225;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=3000;
		$dat[8]=0;
		$dat[9]=6000;
		$dat[10]=0;
		$dat[11]=15000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==9) //Hiro
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=0;
		$dat[5]=1000;
		$dat[6]=0;
		$dat[7]=3000;
		$dat[8]=0;
		$dat[9]=0;
		$dat[10]=0;
		$dat[11]=15000;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==11) // Kazon
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=400; 
		$dat[4]=0;
		$dat[5]=1000;
		$dat[6]=0;
		$dat[7]=0;
		$dat[8]=0;
		$dat[9]=6000;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=500;
	}
	elseif ($game->player['user_race']==10) // Krenim
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=3000;
		$dat[8]=0;
		$dat[9]=6000;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=500;
	}
	else
	{
		$dat[0]=0;
		$dat[1]=50;
		$dat[2]=200;
		$dat[3]=175;
		$dat[4]=500;
		$dat[5]=2000;
		$dat[6]=4000;
		$dat[7]=7000;
		$dat[8]=12000;
		$dat[9]=20000;
		$dat[10]=20000;
		$dat[11]=20000;
		$dat[12]=20000;
	}
	$points=$dat[$ship];

	return $points;

}

// #############################################################################

function LocalTorsoReq($ship)
{
	global $SHIP_TORSO, $game;

	$dat=array();

	if ($game->player['user_race']==0) // Fed
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=200;
		$dat[4]=300;
		$dat[5]=400;
		$dat[6]=400;
		$dat[7]=420;
		$dat[8]=420;
		$dat[9]=450;
		$dat[10]=450;
		$dat[11]=505;
		$dat[12]=400;
	}
	elseif ($game->player['user_race']==1) // Rom
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=400;
		$dat[6]=0; //none ship
		$dat[7]=420;
		$dat[8]=0; //none ship
		$dat[9]=450;
		$dat[10]=0; //none ship
		$dat[11]=505;
		$dat[12]=400;
	}
	elseif ($game->player['user_race']==2) // Kling
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=400;
		$dat[6]=0;
		$dat[7]=420;
		$dat[8]=0; //none ship
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=500;
		$dat[12]=300;
	}
	elseif ($game->player['user_race']==3) // Card
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=420;
		$dat[8]=0;
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=380;
	}
	elseif ($game->player['user_race']==4) // Dom
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=400;
		$dat[6]=0;
		$dat[7]=0;
		$dat[8]=0;
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=500;
		$dat[12]=320;
	}
	elseif ($game->player['user_race']==5) // Ferg
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=250;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=420;
		$dat[8]=0;
		$dat[9]=0;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=480;
	}
	elseif ($game->player['user_race']==8) //Breen
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=225;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=400;
		$dat[8]=0;
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=500;
		$dat[12]=340;
	}
	elseif ($game->player['user_race']==9) //Hiro
	{
		$dat[0]=50;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=0;
		$dat[5]=400;
		$dat[6]=0;
		$dat[7]=400;
		$dat[8]=0;
		$dat[9]=0;
		$dat[10]=0;
		$dat[11]=500;
		$dat[12]=320;
	}
	elseif ($game->player['user_race']==11) // Kazon
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=350; 
		$dat[4]=0;
		$dat[5]=400;
		$dat[6]=0;
		$dat[7]=0;
		$dat[8]=0;
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=380;
	}
	elseif ($game->player['user_race']==10) // Krenim
	{
		$dat[0]=0;
		$dat[1]=100;
		$dat[2]=200;
		$dat[3]=0; //none ship
		$dat[4]=200;
		$dat[5]=0;
		$dat[6]=0;
		$dat[7]=400;
		$dat[8]=0;
		$dat[9]=450;
		$dat[10]=0;
		$dat[11]=0;
		$dat[12]=340;
	}
	else
	{
		$dat[0]=0;
		$dat[1]=50;
		$dat[2]=200;
		$dat[3]=175;
		$dat[4]=500;
		$dat[5]=2000;
		$dat[6]=4000;
		$dat[7]=7000;
		$dat[8]=12000;
		$dat[9]=20000;
		$dat[10]=20000;
		$dat[11]=20000;
		$dat[12]=20000;
	}
	$points=$dat[$ship];

	return $points;

}

?>
