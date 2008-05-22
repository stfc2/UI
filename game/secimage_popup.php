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


// start timer
$start_time = (microtime() + time());
// Unkommentieren sobald PREBETA startet
ignore_user_abort(true);
// nothing to show
if(isset($_GET['debug'])) error_reporting(E_ALL);
else error_reporting(E_ERROR);
// Start output buffering

// main game-path
define('GAME_EXE', 'index.php');
define('IN_SCHEDULER', false);


// include files
include('include/global.php');
include('include/text_races.php');
include('include/text_planets.php');
include('include/ship_data.php');
include('include/race_data.php');
include('include/sql.php');
include('include/functions.php');


// create sql-object for db-connection
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection


// create main game-object
$game = new game();


// load config
$game->load_config();

$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - $game->TIME;
$LAST_TICK_TIME = $game->config['tick_time'] - 5 * 60;


// session code
include('include/session.php');


// check for php/perl user-agent
if( (stristr($_SERVER['HTTP_USER_AGENT'], 'php')) || (stristr($_SERVER['HTTP_USER_AGENT'], 'perl')) ) {
    stgc_log('illegal_user_agent', 'I don´t like the user agent '.$_SERVER['HTTP_USER_AGENT'].' of '.$game->player['user_name']);
}



$GFX_PATH=FIXED_GFX_PATH.'skin1/';

echo'
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
  a:link, a:hover, a:active { font-family: Verdana; font-size: 10px; text-decoration: none; color: #CCCCCC; }
  a:visited { font-family: Verdana; font-size: 10px; text-decoration: none; color: #CCCCCC; }

  td { font-family: Verdana; font-size: 10px; }

  input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
        { color: #959595; font-family: Verdana; font-size: 10px; background-color: #000000; border: 1px solid #959595; }

  span.caption { font-family: Arial, serif; font-size: 16pt; font-weight: bold; text-decoration: underline; }
  span.sub_caption { font-family: Arial,serif;font-size: 13pt; font-weight: bold; text-decoration: underline; }

  table.border_grey { border: 1px solid #C0C0C0; }
  table.border_grey2 { border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0; }
  table.border_blue { border: 1px solid #4B8ED3; }

  body, textarea {
      scrollbar-base-color:#000000;
      scrollbar-3dlight-color:#000000;
      scrollbar-arrow-color:#D8D8D8;
      scrollbar-darkshadow-color:#000000;
      scrollbar-face-color:#000000;
      scrollbar-highlight-color:#000000;
      scrollbar-shadow-color:#000000;
      scrollbar-track-color:#2C2C2C;
      margin: 0; padding: 0;
  }
  //-->
</style>

</head>
<body bgcolor="#727272" text="#FFFFFF" background="'.$GFX_PATH.'template_bg.jpg">
<center><span style="font-family: Verdana; font-size: 18px;">STGC Sicherheitscode:<br></span>
<span style="font-family: Verdana; font-size: 12px;">
';

if ($game->player['content_secimage']!="" && time()<$game->player['timeout_secimage'])
{
if (isset($_POST['click_x']))
{
	$arr=explode(":",$game->player['content_secimage']);
		

	if (sqrt(pow($_POST['click_x']-$arr[0],2)+pow($_POST['click_x']-$arr[0],2))<25)
	{
		echo 'Der angegebene Sicherheitscode war korrekt.<br><form><input type=button value="Schließen" class="button_nosize" onClick="JavaScript:self.close()"></form><script>self.close();</script>';
		$db->query('UPDATE user SET content_secimage="" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
	}
	else
	{
		echo 'Du hast den falschen Kreis angeklickt, es erfolgt nun eine erzwungene Eingabe.<br><form><input type=button value="Schließen" class="button_nosize" onClick="JavaScript:self.close()"> </form>';
		$db->query('UPDATE user SET timeout_secimage="'.(time()-1).'" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
	}
	
}
else
echo 'Bitte klicke den Kreis an, der nicht vollständig geschlossen ist:<br>
<form name="secimage" method="post" action="secimage_popup.php">
<input type="image" name="click" src="'.$game->player['link_secimage'].'">
</form>
';
}
else
{
echo 'Ungültiger Aufruf!';
}

echo '</body></html>';
?>
