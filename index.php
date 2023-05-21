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

define ("GALAXY1_NAME", 'Brown Bobby');
define ("GALAXY2_NAME", 'Fried Egg');
define ("GALAXY3_NAME", 'Forge');

define ("GALAXY1_IMG", 'gfx/ngc7742.jpg');
define ("GALAXY2_IMG", 'gfx/m64.jpg');
define ("GALAXY3_IMG", 'gfx/m64.jpg');

define ("GALAXY1_BG", 'gfx/ngc7742bg.jpg');
define ("GALAXY2_BG", 'gfx/m64bg.jpg');
define ("GALAXY3_BG", 'gfx/m64bg.jpg');

define('GAME_EXE', 'index.php');

include('locale.php');
include('game/include/global.php');
include('game/include/sql.php');
include('game/include/functions.php');

$db_name = '';
$db_user = '';
$db_password = '';

error_reporting(E_ALL);

function display_message($header,$message,$bg) {
    global $main_html;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="500" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
      <center><span class="sub_caption">'.$header.'</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$bg.'\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%" valign="top"><span class="sub_caption2"><br>'.$message.'<br><br></span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>';
}

function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
    $headers = 'MIME-Version: 1.0'.NL.
               'Content-type: text/plain; charset=iso-8859-1'.NL.
               'X-Priority: 1'.NL.
               'X-MSMail-Priority: High'.NL.
               'X-Mailer: php'.NL.
               'From: "'.$myname.'" <'.$myemail.'>'.NL;

    return mail('"'.$contactname.'" <'.$contactemail.'>', $subject, $message, $headers);
}


$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection
$db2 = new sql($config['server'].":".$config['port'], $config['game_database2'], $config['user'], $config['password']);
//$db3 = new sql($config['server'].":".$config['port'], $config['game_database3'], $config['user'], $config['password']);

$action = htmlspecialchars((!empty($_GET['a'])) ? $_GET['a'] : 'home');

$title_html = 'Star Trek: Frontline Combat';
$meta_descr = 'ST: Frontline Combat is a free browser based multi-player game by playing the role of different races and peoples of the universe and rewrite history.';
$main_html = '';

if(strstr($action, '.')) {
    $main_html = '<br><br><center><span style="font-size: 20px;">La pagina selezionata "'.$action.'" non esiste.</span></center><br><br>';
}

if(!file_exists('pages/'.$action.'.php')) {
    $main_html = '<br><br><center><span style="font-size: 20px;">La pagina selezionata "'.$action.'" non esiste.</span></center><br><br>';
}
else
    include('pages/'.$action.'.php');


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title><?php echo $title_html; ?></title>
  <meta http-equiv="Content-Language" content="it">
  <meta name="description" content="<?php echo $meta_descr; ?>">
  <meta name="keywords" content="star, trek, game, gratis, multiplayer, onlinegame, browser, klingon, romulan, federation">

  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta name="title" content="Star Trek: Frontline Combat">
  <meta name="author" content="Florian Brede & Philipp Schmidt">
  <meta name="copyright" content="Paramount Pic., Brede, Schmidt">
  <meta name="ROBOTS" content="INDEX,NOFOLLOW">
  <meta name="creation_Date" content="11/14/2008">
  <meta name="revisit-after" content="7 days">
  <meta name="publisher" content="Florian Brede & Philipp Schmidt">
  <meta name="page-topic" content="Star Trek Online Game">
  <meta name="date" content="2008-11-14">
  <meta name="page-type" content="game">
<style type="text/css">
<!-- A:link {FONT-SIZE: 12px; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:visited {FONT-SIZE: 12px; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:hover {FONT-SIZE: 12px; COLOR: #ffd700; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:active {FONT-SIZE: 12px; COLOR: #ffd700; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A.nav:link {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:visited {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:hover {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:active {FONT-WEIGHT: bold; FONT-SIZE: 10px}
TD {FONT-SIZE: 12px; FONT-FAMILY: Arial, "Bitstream Vera Sans"; COLOR: #c0c0c0;  bgcolor: #cccccc}
INPUT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 12px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
TEXTAREA {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 12px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SELECT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 12px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
div.caption {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"; text-align: center; padding-bottom: 15px;}
SPAN.sub_caption {FONT-WEIGHT: bold; FONT-SIZE: 15pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"}
SPAN.sub_caption2 {FONT-WEIGHT: bold; FONT-SIZE: 13pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"}
BODY {MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; SCROLLBAR-BASE-COLOR: #131c46; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; }
TEXTAREA {PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; PADDING-TOP: 0px; SCROLLBAR-BASE-COLOR: #131c46;}

input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
                          { color: #959595; font-family: Arial, "Bitstream Vera Sans", Helvetica, sans-serif; font-size: 12px; background-color: #000000; border: 1px solid #959595; }
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

table.border_grey         { border: 1px solid #000000; background-image:url('gfx/template_bg.jpg'); background-position:left; background-repeat:yes; }
table.border_grey2        { border-top: 1px solid 000000; border-right: 1px solid 000000; border-bottom: 1px solid #000000; }
table.border_blue         { border: 1px solid #000000; }

td.home_bar               { background-image:url('gfx/template_bg3.jpg'); }
td.home_logo              { background-image:url('gfx/welcome_logo.jpg'); }

td.desc_row {  }
td.value_row { color: #BOBOBO; font-weight: bold;}


-->

</style>
    <style type="text/css">
    .dropcontent{display:none;}
    </style>
    <script type="text/javascript">

/*
Combo-Box Viewer script- Created by and Copyright Dynamicdrive.com
Visit http://www.dynamicdrive.com/ for this script and more
This notice MUST stay intact for legal use
*/

function contractall(){
if (document.getElementById){
var inc=0
while (document.getElementById("dropmsg"+inc)){
document.getElementById("dropmsg"+inc).style.display="none"
inc++
}
}
}


function expandone(){
if (document.getElementById){
var selectedItem=document.register.user_race.selectedIndex
contractall()
document.getElementById("dropmsg"+selectedItem).style.display="block"
}
}

if (window.addEventListener)
window.addEventListener("load", expandone, false)
else if (window.attachEvent)
window.attachEvent("onload", expandone)

</script>

  <script type="text/JavaScript" src="overlibmws.js"></script>
</head>

<body text="#c0c0c0" background="gfx/bg_stars1.gif" >
<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
<table cellspacing="0" cellpadding="0" width="750" align="center" border="0" bgcolor="#283359">
<tbody>
  <tr>
    <td width="750"  bgcolor="black"></td>
  </tr>
  <tr>
    <td width="750" height="5" bgcolor="black">&nbsp;</td>
  </tr>
  <tr>
    <td width="750" height="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="750"><!-- Banner -->
      <table width="750" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="gfx/head_01.gif" width="750" height="132" alt=""></td>
        </tr>
        <tr>
          <td><img src="gfx/head_02.gif" width="658" height="18" alt=""></td>
          <td><a href="http://fragzshox.fr.funpic.de/" target="_blank"><img src="gfx/head_03.gif" alt="" width="92" height="18" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="750" height="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="750" height="1" bgcolor="black"></td>
  </tr>
  <tr>
    <td width=750 bgcolor="#131C46">&nbsp;
      <a class="nav" href="<?php echo parse_link() ?>"><img src="gfx/home.jpg" alt="home" border=0 onMouseOver="this.src='gfx/homeh.jpg';" onMouseOut="this.src='gfx/home.jpg';"></a> &nbsp;
      <a class="nav" href="<?php echo parse_link('a=login') ?>"><img src="gfx/login.jpg" alt="login" border=0 onMouseOver="this.src='gfx/loginh.jpg';" onMouseOut="this.src='gfx/login.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="<?php echo parse_link('a=register') ?>"><img src="gfx/register.jpg" alt="register" border=0 onMouseOver="this.src='gfx/registerh.jpg';" onMouseOut="this.src='gfx/register.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="<?php echo parse_link('a=stats') ?>"><img src="gfx/stats.jpg" alt="stats" border=0 onMouseOver="this.src='gfx/statsh.jpg';" onMouseOut="this.src='gfx/stats.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="http://wiki.stfc.it" target=_blank><img src="gfx/faq.jpg" alt="faq" border=0 onMouseOver="this.src='gfx/faqh.jpg';" onMouseOut="this.src='gfx/faq.jpg';"></a>
      <a class="nav" href="http://forum.stfc.it" target=_blank><img src="gfx/forum.jpg" alt="forum" border=0 onMouseOver="this.src='gfx/forumh.jpg';" onMouseOut="this.src='gfx/forum.jpg';"></a>
      <a class="nav" href="<?php echo parse_link('a=imprint') ?>"><img src="gfx/impressum.jpg" alt="impressum" border=0 onMouseOver="this.src='gfx/impressumh.jpg';" onMouseOut="this.src='gfx/impressum.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="https://github.com/stfc2" target=_blank><img src="gfx/developer.jpg" alt="Development" border=0 onMouseOver="this.src='gfx/developerh.jpg';" onMouseOut="this.src='gfx/developer.jpg';"></a>
    </td>
  </tr>
  <tr>
    <td width="750" height="1" bgcolor="black"></td>
  </tr>
  <tr>
    <td valign="top" align="center" width="750">
      <table cellspacing="0" cellpadding="0" width="750" align="center" border="0">
      <tbody>
        <tr>
          <td align="center" width="750">
            <!-- Middle -->
            <table cellspacing="0" cellpadding="0" width="650" align="center" border="0">
            <tbody>
              <tr>
                <td width="650"><br>
                  <br>
                  <?php echo $main_html; ?>
                  <br>
                  <br>
                </td>
              </tr>
            </table>
            <!-- Middle End -->
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" align="center" width="750" height="10">
      <table cellspacing="0" cellpadding="0" width="750" align="center" border="0">
      <tbody>
        <tr>
          <td align="center" width="750">
<!--  This copyright notice must never be changed or modified in any way and always be visible!  -->
            <img src="gfx/copyright.png" alt="copyright" border="0">
<!--  End of copyright notice  -->
            <br>
          </td>
        </tr>
        <tr>
          <td width="750" height="1" bgcolor="black">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>


