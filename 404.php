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


define('NL', "\n");


error_reporting(E_ALL);

function parse_link($get_string = '') {
    return $_SERVER['PHP_SELF'].'?'.$get_string;
}

$action = '404';

$main_html = '';

if(!include('pages/'.$action.'.php')) {
    $main_html = '<br><br><br><br><center><span style="font-size: 20px;">The selected page "'.$action.'" does not exists</span></center>';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
  <title>Star Trek: Galaxy Conquest</title>

  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

  <meta name="description" content="ST: Frontline Combat is a free browser based multiplayer game, take the role of different races and peoples of the universe and rewrite history.">
  <meta name="keywords" content="star trek, startrek, galaxy, conquest, universe, game, gratis, kostenlos, spiel, multiplayer, strategy, strategie, onlinegame, bbg, free, browser, based, galaxie, universum, klingon, klingonen, federation, f&ouml;deration">
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
<!-- A:link {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:visited {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:hover {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A:active {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, Luxi Sans; TEXT-DECORATION: none}
A.nav:link {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:visited {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:hover {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:active {FONT-WEIGHT: bold; FONT-SIZE: 10px}
TD {FONT-SIZE: 11px; FONT-FAMILY: Arial, Luxi Sans; COLOR: #c0c0c0;  bgcolor=#cccccc}
INPUT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
TEXTAREA {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SELECT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SPAN.caption {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.sub_caption {FONT-WEIGHT: bold; FONT-SIZE: 15pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
SPAN.sub_caption2 {FONT-WEIGHT: bold; FONT-SIZE: 13pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, Luxi Sans}
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
-->

</style>


  <script language="JavaScript" src="overlib.js"></script>
</head>

<body text="#c0c0c0" background="http://www.stfc.it/gfx/bg_stars1.gif" >
<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
<table cellspacing="0" cellpadding="0" width="750" align="center" valign="top" border="0" bgcolor="#283359">
<tbody>
<tr>
<td width="750"  bgcolor="black">
<center><A href="http://www.go2gameserver.net/" 
      target=_blank><img src="http://www.stfc.it/gfx/stgcbanner.jpg" border="0" valign="top"></A></center>

        </td>
    </tr>
    <tr>
    
<td width="750" height="5" bgcolor="black">&nbsp;
        </td>
    </tr>
    
    <tr>
<td width="750" height="10">&nbsp;
        </td>
    </tr>

<tr>
<td width="750"><!-- Banner -->
<img alt="Star Trek: Galaxy Conquest" src="http://www.stfc.it/gfx/template_banner.jpg" border="0">
</td></tr>


    <tr>
<td width="750" height="10">&nbsp;
        </td>
    </tr>

<tr>
<td width="750" height="1" bgcolor="black">

        </td>
    </tr>
<tr>
<td height="20" bgcolor="#131C46">&nbsp;&nbsp;
<a class="nav" href="<?php echo parse_link() ?>"><img src="http://www.stfc.it/gfx/home.jpg" alt="home" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/homeh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/home.jpg';"></a> &nbsp;&nbsp;
<a class="nav" href="<?php echo parse_link('a=login') ?>"><img src="http://www.stfc.it/gfx/login.jpg" alt="login" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/loginh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/login.jpg';"></a> &nbsp;&nbsp;
<a class="nav" href="<?php echo parse_link('a=register') ?>"><img src="http://www.stfc.it/gfx/register.jpg" alt="register" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/registerh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/register.jpg';"></a> &nbsp;&nbsp;
<a class="nav" href="<?php echo parse_link('a=stats') ?>"><img src="http://www.stfc.it/gfx/stats.jpg" alt="stats" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/statsh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/stats.jpg';"></a> &nbsp;&nbsp;
<a class="nav" href="http://wiki.stgc.de" target=_blank><img src="http://www.stfc.it/gfx/faq.jpg" alt="faq" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/faqh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/faq.jpg';"></a> &nbsp;&nbsp;
<a class="nav" href="http://stgcforum.de/" target=_blank><img src="http://www.stfc.it/gfx/forum.jpg" alt="forum" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/forumh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/forum.jpg';"></a> &nbsp;
<a class="nav" href="<?php echo parse_link('a=spende') ?>"><img src="http://www.stfc.it/gfx/spenden.jpg" alt="spenden" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/spendenh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/spenden.jpg';"></a> &nbsp;
<a class="nav" href="<?php echo parse_link('a=imprint') ?>"><img src="http://www.stfc.it/gfx/impressum.jpg" alt="impressum" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/impressumh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/impressum.jpg';"></a> &nbsp;&nbsp;
<!--<a class="nav" href="<?php echo parse_link('a=spende') ?>"><img src="http://www.stfc.it/gfx/spenden.jpg" alt="spenden" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/spendenh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/spenden.jpg';"></a></td>!-->
<a class="nav" href="http://stgcsource.net/" target=_blank><img src="http://www.stfc.it/gfx/developer.jpg" alt="Development" border=0 onMouseOver="this.src='http://www.stfc.it/gfx/developerh.jpg';" onMouseOut="this.src='http://www.stfc.it/gfx/developer.jpg';"></a></td>
 </td>
    </tr>
 

<tr><td width="750" height="1" bgcolor="black">

        </td>
    </tr>
<tr>
<td valign="top" align="center" width="750">
<table cellspacing="0" cellpadding="0" width="750" align="center" border="0">
<tbody>
<tr>
<td align="center" width="750"><!-- Middle -->
<table cellspacing="0" cellpadding="0" width="650" align="center" border="0">
<tbody>
<tr>
<td width="650"><br>
<br>

            <?php echo $main_html; ?>
           <br>
<br></td>
                            </tr>




</table>
<!-- Middle End --></td>
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
<!--  This copyright notice must never be changed or modified in any way and always be visible!  --!>
<img src="http://www.stfc.it/gfx/copyright.png" alt="copyright" border=0>
<!--  End of copyright notice  --!>

<br />
</td>
                </tr>
 

<tr>
<td width="750" height="1" bgcolor="black">


                    </td>
                </tr>
</table>



        </td>
    </tr>
</table><br />
</body>
</html>


