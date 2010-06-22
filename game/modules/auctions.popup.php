<?
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

include_once('../include/global.php');
include_once('../include/sql.php');
include_once('../include/functions.php');
include_once('auctions.popup.sprache.php');
error_reporting(E_ALL);

// create sql-object for db-connection
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection

$game = new game();

$game->load_config();
$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - time();//$game->TIME;
$LAST_TICK_TIME = $game->config['tick_time'] - TICK_DURATION * 60;


include('../include/session.php');

//$game->init_player();


echo '

<html>
<head>
  <title>Star Trek: Frontline Combat 2 - '.constant($game->sprache("TEXT0")).'</title>
</head>

<style type="text/css">
<!-- A:link {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:visited {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:hover {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:active {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A.nav:link {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:visited {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:hover {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:active {FONT-WEIGHT: bold; FONT-SIZE: 10px}
TD {FONT-SIZE: 11px; FONT-FAMILY: Arial, Luxi Sans; COLOR: #c0c0c0;  bgcolor=#cccccc}
input[type=checkbox] { border-style: none;}
INPUT[type=submit], INPUT[type=text], INPUT[type=password] {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
TEXTAREA {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SELECT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SPAN.caption {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.sub_caption {FONT-WEIGHT: bold; FONT-SIZE: 15pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.sub_caption2 {FONT-WEIGHT: bold; FONT-SIZE: 11pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.text_large {FONT-WEIGHT: bold; FONT-SIZE: 9pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.text_medium {FONT-WEIGHT: bold; FONT-SIZE: 8pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
BODY {MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; SCROLLBAR-BASE-COLOR: #131c46; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; }
TEXTAREA {PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; PADDING-TOP: 0px; SCROLLBAR-BASE-COLOR: #131c46;}

input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
                          { color: #959595; font-family: Arial, Luxi Sans, Helvetica, sans-serif; font-size: 11px; background-color: #000000; border: 1px solid #959595; }
body, textarea {
      scrollbar-base-color:#000000;
      scrollbar-3dlight-color:#000000;
      scrollbar-arrow-color:#D8D8D8;
      scrollbar-darkshadow-color:#000000;
      scrollbar-face-color:#000000;
      scrollbar-highlight-color:#000000;
      scrollbar-shadow-color:#000000;
      scrollbar-track-color:#2C2C2C;
  }

table.border_grey         { border: 1px solid #000000; }
table.border_grey2        { border-top: 1px solid 000000; border-right: 1px solid 000000; border-bottom: 1px solid #000000; }
table.border_blue         { border: 1px solid #000000; }
table.style_inner         { border: 1px solid #000000; background-color:#131c47;}
table.style_outer         { border: 1px solid #000000; background-color:#283359;}

table.style_msgunread         { border: 1px solid #000000; background-color:#ff3359;}
table.style_msgread            { border: 1px solid #000000; background-color:#2833ff;}


-->

</style>

<body bgcolor="#000000" text="#DDDDDD"  background="'.$config['site_url'].'/gfx/bg_stars1.gif">

  <table class="style_outer" width="550" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td>
        <table class="style_inner" width="550" align="center" border="0" cellpadding="2" cellspacing="2">
    
';

if(isset($_GET['user'])) {

  $user_id = (int)$_GET['user'];

  echo '<td>&nbsp;</td><td><font size="3"><b>'.constant($game->sprache("TEXT1")).'</b></font></td><td><font size="3"><b>'.get_username_by_id($user_id).'</b></font></td></tr><tr><td>&nbsp;</td></tr><tr><td></td><td width="235"><b>'.constant($game->sprache("TEXT2")).'</b></td><td width="200"><b>'.constant($game->sprache("TEXT3")).'</b></td><td width="70"><b>'.constant($game->sprache("TEXT4")).'</b></td></tr>';

  $config=$db->queryrow('SELECT * FROM config');

  $sql = 'SELECT * FROM ship_trade WHERE user = '.$user_id.' AND end_time > '.$config['tick_id'].'';

  if(!$q_tradedata = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query tradedata');
  }

  while($tradedata = $db->fetchrow($q_tradedata)) {
  
    echo '<tr><td width="55" align="center">[<a onclick="opener.window.location=this.href;self.close();return false" href="/game/index.php?a=trade&view=view_bidding_detail&id='.$tradedata['id'].'">'.constant($game->sprache("TEXT5")).'</a>]</td><td>'.$tradedata['header'].'</td><td><img src="'.PROXY_GFX_PATH.'/skin1/menu_metal_small.gif">&nbsp;'.$tradedata['resource_1'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_mineral_small.gif">&nbsp;'.$tradedata['resource_2'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_latinum_small.gif">&nbsp;'.$tradedata['resource_3'].'&nbsp;<br><img src="'.PROXY_GFX_PATH.'/skin1/menu_unit1_small.gif">&nbsp;'.$tradedata['unit_1'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_unit2_small.gif">&nbsp;'.$tradedata['unit_2'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_unit3_small.gif">&nbsp;'.$tradedata['unit_3'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_unit4_small.gif">&nbsp;'.$tradedata['unit_4'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_unit5_small.gif">&nbsp;'.$tradedata['unit_5'].'&nbsp;<img src="'.PROXY_GFX_PATH.'/skin1/menu_unit6_small.gif">&nbsp;'.$tradedata['unit_6'].'</td><td>'.Zeit(TICK_DURATION*($tradedata['end_time']-$config['tick_id'])).'</td></tr>';

  }

}

else { echo constant($game->sprache("TEXT6")); }





echo '</table></td></tr></table></body>
</html>';

$db->close();

?>
