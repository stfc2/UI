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


define('NL', "\n");



error_reporting(E_ERROR);


?>









<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>

<HEAD>

	<TITLE>STFC Supportcenter</TITLE>

	<META NAME="publisher" CONTENT="Florian Brede">

	<META NAME="copyright" CONTENT="Florian Brede">

	<META NAME="page-topic" CONTENT="supportcenter">

	<META NAME="date" CONTENT="2004-12-11">

</HEAD>





<style type="text/css">



TD {FONT-SIZE: 11px; FONT-FAMILY: Microsoft Sans Serif, Luxi Sans; COLOR: #000000;  bgcolor=#cccccc}

SPAN.header0 {FONT-WEIGHT: bold; FONT-SIZE: 32pt; COLOR: #000000; FONT-FAMILY: Microsoft Sans Serif, Luxi Sans}

SPAN.header {FONT-WEIGHT: bold; FONT-SIZE: 24pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header1 {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header2 {FONT-WEIGHT: bold; FONT-SIZE: 14pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header3 {FONT-WEIGHT: bold; FONT-SIZE: 12pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}



table.border_grey         { border: 1px solid #000000; }

table.border_black_1         { border: 1px solid #000000; }

table.border_black_2         { border: 2px solid #000000; }

table.border_grey2        { border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; }



INPUT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #000000; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: MS Sans Serif, Luxi Sans; BACKGROUND-COLOR: #dddddd}



input.button, input.button_nosize, input.field, input.field_nosize, textarea, select

                          { color: #000000; font-family:  MS Sans Serif, Luxi Sans; font-size: 12px; background-color: #bbbbbb; border: 1px solid #959595; }



html, body {

height: 100%;

margin: 0px;

}



div.innen

{

margin-left:auto; margin-right:auto;

text-align:left;

}

</style>


<BODY bgcolor="#107710" onload="start();" >
<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
     

<center>

<table border=0 cellpadding=0 cellspacing=0 width=940 bgcolor=#afafafaf>
<tr><td width=20></td>
<td width=900>

<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#bbbbbbb>

<tr><td><span class="header0">STFC Supportcenter</span></td><td align="right"><span class="header3"><?php echo $galaxyname; ?></span></td></tr></table>
<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#cccccc>

<tr valign=top>


<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Generale:</span><br>
<a href="index.php?p=home">Home</a><br>
<a href="index.php?p=stats">Statistiche</a><br>
<a href="index.php?p=log">Log squadre</a><br>
<a href="index.php?p=log2">Log multiban</a><br>
</td>


<td width=25 bgcolor=#bbbbbbb></td>

<td width=150 valign=top bgcolor=#cccccc>
<span class="header3">Strumenti:</span><br>
<a href="index.php?p=news">Scrivi novit&agrave;</a><br>
<a href="index.php?p=polls">Scrivi sondaggi</a><br><br>
<a href="index.php?p=messages">Sistema messaggi</a><br>
</td>

<td width=25 bgcolor=#cccccc></td>

<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Giocatori:</span><br>
<a href="index.php?p=user_stats">Sommario</a><br>
<a href="index.php?p=user">Cerca</a><br>
Es.<br>Cambia dati<br>Blocca<br>Cancella
<br>
</td>
<td width=25 bgcolor=#bbbbbbb></td>
<td width=150 valign=top bgcolor=#cccccc>
<span class="header3">Pianeti:</span><br>
<!-- <a href="index.php?p=planet_overview"><i>Sommario</i></a><br>
<a href="index.php?p=planet_resources"><i>Risorse</i></a><br>
<a href="index.php?p=planet_units"><i>Unit&agrave;</i></a><br>
<a href="index.php?p=planet_ships"><i>Navi</i></a><br> !-->
<br>
</td>

<td width=25 bgcolor=#cccccc></td>
<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Multi:</span><br>
<a href="index.php?p=multihunt">Multi hunting</a><br>
<br>
</td>
<td width=25 bgcolor=#bbbbbbb></td>

</tr></table>

<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#cccccc>

<tr><td>


<br><br>

Logout effettuato con successo!


</center>
</td></tr>
</table>




</td>
<td width=20></td>
</tr>
<tr height=25><td colspan=3></td></tr>
</table>



</BODY>

</HTML>

