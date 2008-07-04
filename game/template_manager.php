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



ob_start();

ob_implicit_flush(0);



// #############################################################################
// Konstanten
define('TPL_MGR_EXE', "template_manager.php");
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
include('template_manager.sprache.php');



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




$game->init_player();



$main_html = '';



if( (!empty($_POST['change_skin'])) || (!empty($_GET['change_skin'])) ) {

    $skin_id = intval( (!empty($_POST['change_skin'])) ? $_POST['new_skin'] : $_GET['change_skin'] );

    

    $sql = 'SELECT skin_id, skin_name, gfxpack_link, skin_html

            FROM skins

            WHERE skin_id = '.$skin_id;

            

    if(($skin_data = $db->queryrow($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query skin data');

    }

    

    if(empty($skin_data['skin_id'])) {

        message(GENERAL, constant($game->sprache("TEXT0")));

    }

    

    $sql = 'UPDATE user_templates

            SET user_template = "'.addslashes($skin_data['skin_html']).'"

            WHERE user_id = '.$game->player['user_id'];

            

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update user template data');

    }

    

    $sql = 'UPDATE user

            SET user_skinpath = "skin'.$skin_id.'/",

                user_skin = '.$skin_id.'

            WHERE user_id = '.$game->player['user_id'];
/*$sql = 'UPDATE user

            SET    user_skin = '.$skin_id.'

            WHERE user_id = '.$game->player['user_id'];*/

            

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update user skinpath data');

    }

    

    $main_html .= '

'.constant($game->sprache("TEXT1")).' <b>'.$skin_data['skin_name'].'</b> '.constant($game->sprache("TEXT2")).'<br><br><br>

'.constant($game->sprache("TEXT3")).' <a href="'.$skin_data['gfxpack_link'].'">'.constant($game->sprache("TEXT4")).'

<br><br><br>

<form method="post" action="'.TPL_MGR_EXE.'">

<input type="submit" class="button" name="back_to_index" value="'.constant($game->sprache("TEXT5")).'">

</form>

    ';

}

elseif(!empty($_POST['edit_template'])) {

    $main_html .= '

<form method="post" action="'.TPL_MGR_EXE.'">

<textarea class="textfield" cols="120" rows="30" wrap="off" name="template_html">'.$game->template_html.'</textarea><br><br>

<input class="button" type="submit" name="back_to_index" value="'.constant($game->sprache("TEXT5")).'">&nbsp;<input class="button" type="reset" value="'.constant($game->sprache("TEXT6")).'">&nbsp;<input class="button" type="submit" name="submit_template" value="'.constant($game->sprache("TEXT7")).'">

</form>

    ';

}

elseif(!empty($_POST['submit_template'])) {

    $sql = 'UPDATE user_templates

            SET user_template  = "'.addslashes($_POST['template_html']).'"

            WHERE user_id = '.$game->player['user_id'];

            

    if(!$db->query($sql)) {

        message(DATABASE_ERROR, 'Could not update user template data');

    }

    

    if($game->player['user_skin'] != 0) {

        $sql = 'UPDATE user

                SET user_skin = 0

                WHERE user_id = '.$game->player['user_id'];

                

        if(!$db->query($sql)) {

            message(DATABASE_ERROR, 'Could not update user skin data');

        }

    }

    

    header('Location: '.TPL_MGR_EXE);
    exit;
}

elseif(!empty($_GET['skin_summary'])) {

    $sql = 'SELECT skin_id, skin_name, skin_author, gfxpack_link, skinpreview_link, skin_desc

            FROM skins';

            

    if(($q_skins = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query skin data');

    }

    

    $main_html .= '

<span style="font-size: 14px;">'.constant($game->sprache("TEXT8")).'</span><br><br><br>



<table border="0" width="60%">

    ';

    

    while($cur_skin = $db->fetchrow($q_skins)) {

        $main_html .= '

            <tr>

              <td valign="top">

                <b>'.$cur_skin['skin_name'].'</b> '.constant($game->sprache("TEXT9")).' <i>'.$cur_skin['skin_author'].'</i><br><br>'.$cur_skin['skin_desc'].'<br><br><a href="'.TPL_MGR_EXE.'?change_skin='.$cur_skin['skin_id'].'">'.constant($game->sprache("TEXT10")).'</a><br><a href="'.$cur_skin['gfxpack_link'].'">'.constant($game->sprache("TEXT11")).'</a>

              </td>

              <td width="150">

                <img src="'.$cur_skin['skinpreview_link'].'">

              </td>

            </tr>

            

            <tr height="20"><td></td></tr>

        ';

    }

    

    $main_html .= '

</table>



<form method="post" action="'.TPL_MGR_EXE.'">

<input type="submit" class="button" name="back_to_index" value="'.constant($game->sprache("TEXT5")).'">

</form>

    ';

}

else {

    $sql = 'SELECT skin_id, skin_name

            FROM skins';

            

    if(($q_skins = $db->query($sql)) === false) {

        message(DATABASE_ERROR, 'Could not query skin data');

    }

    

    while($cur_skin = $db->fetchrow($q_skins)) {

        $skins[$cur_skin['skin_id']] = $cur_skin['skin_name'];

    }



    $main_html .= '

<form method="post" action="'.TPL_MGR_EXE.'">



'.constant($game->sprache("TEXT12")).'



'.constant($game->sprache("TEXT13")).' '.( ($game->player['user_skin'] == 0) ? constant($game->sprache("TEXT14")) : '<b>'.$skins[$game->player['user_skin']].'</b>' ).'



<br><br><br>



<table width="80%" align="center">

  <tr>

    <td width="50%">

      '.constant($game->sprache("TEXT15")).'<br><a href="'.TPL_MGR_EXE.'?skin_summary=1">'.constant($game->sprache("TEXT16")).'</a>

    </td>

    <td width="50%" align="center">

      <select class="select" name="new_skin">

    ';

    

    foreach($skins as $skin_id => $skin_name) {

        $main_html .= '<option value="'.$skin_id.'">'.$skin_name.'</option>'.NL;

    }

    

    $main_html .= '

      </select>

      &nbsp;<input type="submit" class="button" name="change_skin" value="OK">

    </td>

  </tr>

  

  <tr height="30"><td colspan="2"></td></tr>

  

  <tr>

    <td width="50%">

      '.constant($game->sprache("TEXT17")).'

    </td>

    <td width="50%" align="center">

      <input type="submit" class="button" name="edit_template" value="'.constant($game->sprache("TEXT18")).'">

    </td>

  </tr>

</table>



</form>

    ';

}



echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">



<html>



<head>

  <title>Star Trek: Frontline Combat - Template Manager</title>



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

  .button { background-color:#000000; color:#959595; border:1px solid #959595; background="'.$game->PLAIN_GFX_PATH.'general_bg.jpg"}



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



<body bgcolor="#000000" text="#CCCCCC" background="'.$game->PLAIN_GFX_PATH.'general_bg.jpg">



<center><span style="font-family: Arial,serif; font-size: 16pt; font-weight: bold; text-decoration: underline;">Star Trek: Frontline Combat - Template Manager</span></center><br><br>



<table align="center" width="90%">

  <tr>

    <td align="center">

      '.$main_html.'

    </td>

  </tr>

</table>



</body>



</html>';



$gzip_contents = ob_get_contents();

ob_end_clean();



if( (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) && (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ) {

    $gzip_size = strlen($gzip_contents);

    $gzip_crc = crc32($gzip_contents);



    $gzip_contents = gzcompress($gzip_contents, 0);

    $gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);



    header('Content-Encoding: gzip');



    echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";

    echo $gzip_contents;

    echo pack('V', $gzip_crc);

    echo pack('V', $gzip_size);

}

else {

    echo $gzip_contents;

}



?>

