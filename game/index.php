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


$start_time = (microtime() + time());
ignore_user_abort(true);


// #############################################################################
// Error-Level bestimmen
if(isset($_GET['debug'])) error_reporting(E_ALL);
else error_reporting(E_ERROR);


// #############################################################################
// Ausgabepuffer
ob_start();
ob_implicit_flush(0);


// #############################################################################
// Konstanten
define('GAME_EXE', 'index.php');
define('IN_SCHEDULER', false);

// #############################################################################

// Game-Objekt
include('include/functions.php');
$game = new game();

// #############################################################################
// SQL-Objekt fï¿½r Datenbankzugriff
include('include/global.php');
include('include/sql.php');
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection

if(isset($_GET['sql_debug'])) $db->debug = true;

// #############################################################################
// Includes
//include('include/text_planets.php');
include('include/ship_data.php');
include('include/race_data.php');


// #############################################################################
// Config laden und auswerten
$game->load_config();
$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - time();//$game->TIME;
$LAST_TICK_TIME = $game->config['tick_time'] - TICK_DURATION * 60;


// #############################################################################
// Session-System
include('include/session.php');

if($game->config['game_stopped'] == 1 && $game->player['user_auth_level'] != STGC_DEVELOPER) message(GENERAL, $game->config['stop_message']);


// Define the Overlib Stylesets:
define('OVERLIB_STANDARD', "FGCOLOR, '#ffffff', TEXTCOLOR, '#ffffff', FGBACKGROUND,'".FIXED_GFX_PATH."skin1/bg_stars1.gif', BGCOLOR, '#335E35', BORDER, 2, CAPTIONFONT, 'Arial', CAPTIONSIZE, 2, TEXTFONT, 'Arial', TEXTSIZE, 2");


// #############################################################################
// Nach PHP/Perl-UserAgent suchen
if( (stristr($_SERVER['HTTP_USER_AGENT'], 'php')) || (stristr($_SERVER['HTTP_USER_AGENT'], 'perl')) ) {
    stgc_log('illegal_user_agent', 'I donï¿½t like the user agent '.$_SERVER['HTTP_USER_AGENT'].' of '.$game->player['user_name']);
}


// #############################################################################
// Notepad-Actions
if(isset($_GET['show_notepad'])) {
    $db->query('UPDATE user SET user_hidenotepad = 0 WHERE user_id = '.$game->player['user_id']);
    $game->player['user_hidenotepad'] = 0;
}

if(isset($_GET['hide_notepad'])) {
    $db->query('UPDATE user SET user_hidenotepad = 1 WHERE user_id = '.$game->player['user_id']);
    $game->player['user_hidenotepad'] = 1;
}

// #############################################################################
// Sicherheitscode
if( ($game->TIME - $game->player['last_secimage'] > 3600 * 1.5) && ($game->player['content_secimage'] == '') ) {
    if($game->player['user_auth_level'] == STGC_DEVELOPER) {
        $sql = 'UPDATE user
                SET last_secimage = '.$game->TIME.',
                    content_secimage = ""
                WHERE user_id = '.$game->player['user_id'];

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update dev content_secimage data');
        }

        echo 'I filled in the security code for you, master';
    } 
    else {
        include('include/libs/secimage.php');
        $data=create_secimage();

        $sql = 'UPDATE user
                SET last_secimage = '.$game->TIME.',
                    timeout_secimage = '.($game->TIME + 180).',
                    content_secimage = "'.$data['center'].'",
                    link_secimage = "'.$data['filename'].'"
                WHERE user_id = '.$game->player['user_id'];

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update user content_secimage data');
        }

        echo "<script language=\"Javascript\" type=\"text/javascript\">window.open('secimage_popup.php', '_secimage', 'HEIGHT=225,resizable=yes,WIDTH=400');</script>";
    }
}

// #############################################################################
// Zu Ladendes Modul überprüfen
if (file_exists('include/text_races_'.$game->player['language'].'.php')) {
	include('include/text_races_'.$game->player['language'].'.php');
}else{
	include('include/text_races.php');
}
if (file_exists('include/text_planets_'.$game->player['language'].'.php')) {
	include('include/text_planets_'.$game->player['language'].'.php');
}else{
	include('include/text_planets.php');
}

// #############################################################################


$action = (!empty($_GET['a'])) ? $_GET['a'] : 'portal';

if($game->SITTING_MODE) {
    $auth_table = array(
        'ship_fleets_distribute' => 1, 'ship_fleets_loadingf' => 1, 'ship_fleets_loadingp' => 1, 'ship_fleets_ops' => 1, 'ship_fleets_display' => 1,
        'ship_send' => 1, 'ship_actions' => 1, 'ship_moves_cmd' => 1,
        'tactical_cartography' => 1, 'tactical_moves' => 1, 'tactical_sensors'  => 1,
        'trade' => 2,
        'messages' => 3,
        'alliance_admin' => 4, 'alliance_board' => 4, 'alliance_diplomacy' => 4, 'alliance_main' => 4, 'alliance_attack' => 4, 'alliance_taxes' => 4, 'alliance_massmail' => 4, 'alliance_rights' => 4,
        'building' => 5,
        'researchlabs' => 6,
        'shipyard' => 7,
        'academy' => 8,
        'mines' => 9,
        'settings' => 10
    );

    if(isset($auth_table[$action])) {
        if($game->player['user_sitting_o'.$auth_table[$action]] != 1 && $auth_table[$action]!=10) $action = 'forbidden';
    }
}


if($game->player['content_secimage'] != '' && $game->TIME >= $game->player['timeout_secimage']) {
	include('modules/security.php');
}
    else 
        {
    	        if( (strstr($action, '..')) && ($game->player['user_auth_level'] != STGC_DEVELOPER) ) 
                {
    		        message(GENERAL, 'Sicherheitsbruch', '$action = \''.$action.'\'');
    	        }
    	
            	$game->current_module = $action;
		if (file_exists('modules/'.$action.'.sprache.php')) include('modules/'.$action.'.sprache.php');
    	        include('modules/'.$action.'.php');
        }


// #############################################################################
// HTML ausgeben
$game->display();

if(isset($_GET['sql_debug'])) $db->debug_info();


// #############################################################################
// Ausgabe-Komprimierung
$gzip_contents = ob_get_contents();
ob_end_clean();

if( (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) && (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ) {
    $start_gtime = (microtime() + time());

    $compression=1;
    if ($game->player['user_id']<12 && isset($_GET['compression'])) 
        $compression=$_GET['compression']; 
    $gzip_size = strlen($gzip_contents);
    $gzip_crc = crc32($gzip_contents);
    $gzip_contents = gzcompress($gzip_contents, $compression);
    $gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

    $total_gtime = (time() + microtime()) - $start_gtime;
    header('Content-Encoding: gzip');

    echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
    echo $gzip_contents;
    echo pack('V', $gzip_crc);
    echo pack('V', $gzip_size);

    if ($game->player['user_id']<12)
    {
    // Ausgabe der Grï¿½ï¿½e vor/nach der Kompression:
    $gzip_result=floor($gzip_size/1024).'kb / '.floor(strlen($gzip_contents)/1024).'kb<br>'.($total_gtime*1000).' msecs';
    $gzip_size = strlen($gzip_result);
    $gzip_crc = crc32($gzip_result);
    $gzip_result = gzcompress($gzip_result, $compression);
    $gzip_result = substr($gzip_result, 0, strlen($gzip_result) - 4);

    header('Content-Encoding: gzip');

    echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
    echo $gzip_result;
    echo pack('V', $gzip_crc);
    echo pack('V', $gzip_size);
    }
	   
    
}
else {
    echo $gzip_contents;
}

?>
