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



error_reporting(E_ALL);

// #############################################################################
// Konstanten
define('NOTEPAD_EXE', $_SERVER['PHP_SELF']);
define('IN_SCHEDULER', false);


// #############################################################################
// Includes
include('include/global.php');
include('include/text_races.php');
include('include/text_planets.php');
include('include/ship_data.php');
include('include/race_data.php');
include('include/sql.php');
include('include/functions.php');

// #############################################################################
// SQL-Objekt für Datenbankzugriff
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection

if(isset($_GET['sql_debug'])) $db->debug = true;


// #############################################################################
// Game-Objekt
$game = new game();


// #############################################################################
// Config laden und auswerten
$game->load_config();
$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - $game->TIME;
$LAST_TICK_TIME = $game->config['tick_time'] - 5 * 60;


// #############################################################################
// Session-System
include('include/session.php');

if($game->config['game_stopped'] == 1 && $game->player['user_auth_level'] != STGC_DEVELOPER) message(GENERAL, $game->config['stop_message']);


$game->init_player();


$sql = 'UPDATE user
        SET user_notepad = "'.mysql_real_escape_string($_POST['user_notepad']).'"
        WHERE user_id = '.$game->player['user_id'];

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Could not update notepad data');
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
  <title>Star Trek: Galaxy Conquest</title>

  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

  <meta name="description" content="ST: Galaxy Conquest ist ein kostenloses Browser basiertes Multiplayerspiel, indem Sie in der Rolle verschiedener Rassen und Völker das Universum übernehmen und die Geschichte neu schreiben können.">
  <meta name="keywords" content="star trek, startrek, galaxy, conquest, universe, game, gratis, kostenlos, spiel, multiplayer, strategie, onlinegame, bbg, free, browser, based, galaxie, universum, klingon, klingonen, federation, föderation">
  <meta name="author" content="Florian Brede & Philipp Schmidt">
  <meta name="publisher" content="Florian Brede & Philipp Schmidt">
  <meta name="copyright" content="Paramount Pic., Brede, Schmidt">
  <meta name="page-topic" content="Star Trek Online Spiel">
  <meta name="date" content="2003-06-22">
  <meta name="content-language" content="de">
  <meta name="page-type" content="spiel">
  <meta name="robots" content="index,nofollow">
  <meta name="revisit-after" content="10">

  <style type="text/css">
  <!--
  a:link { font-family: Verdana; font-size:12px; text-decoration:none; color:#cccccc; }
  a:visited { font-family: Verdana; font-size:12px; text-decoration:none; color:#cccccc; }
  a:hover { font-family: Verdana; font-size:12px; text-decoration:none; color:#ffffff; }
  a:active { font-family: Verdana; font-size:12px; text-decoration:none; }

  p, td, div { font-family: Verdana; font-size: 12px; font-style: normal; }
  input, select, textarea { color:#959595; font-family: Verdana; font-size: 12px;font-style: normal; }

  .field { background-color:#000000; border:1px solid #959595; }
  .textfield { background-color:#000000; border:1px solid #959595; }
  .MessageReadField { background-color:#000000; width:350px; border:1px solid #959595; }
  .select { background-color:#000000; border:1px solid #959595; }
  .check, .radio { background-color:#000000; border:2px solid #959595; }
  .button { background-color:#000000; color:#959595; border:1px solid #959595; background="<?php echo $game->PLAIN_GFX_PATH ?>general_bg.jpg"}

  table.border_grey { border:1px solid #c0c0c0; }
  table.border_planet { border-top:1px solid #c0c0c0; border-right:1px solid #c0c0c0; border-bottom:1px solid #c0c0c0; }
  table.border_blue { border:1px solid #33355E; }

  body, textarea {
      background-color:#727272;
      color:#FFFFFF;
      scrollbar-base-color:#000000;
      scrollbar-3dlight-color:#000000;
      scrollbar-arrow-color:#d8d8d8;
      scrollbar-darkshadow-color:#000000;
      scrollbar-face-color:#000000;
      scrollbar-highlight-color:#000000;
      scrollbar-shadow-color:#000000;
      scrollbar-track-color:#2C2C2C;
  }
  //-->
</style>

</head>

<body bgcolor="#000000" text="#CCCCCC" background="<?php echo $game->PLAIN_GFX_PATH ?>general_bg.jpg">

<span style="font-family: Arial,serif; font-size: 14pt; text-decoration: underline;">Submitted new notepad data:</span><br><br><span style="font-family: Arial,serif; font-size: 10pt; font-weight: bold;"><?php echo str_replace("\n", '<br>', $_POST['user_notepad']) ?></span><br><br><br>

<input type="button" class="button" onClick="JavaScript:self.close()" value="Fenster schließen">

</body>

</html>
