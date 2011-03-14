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


$value='';



$sql = ' SELECT *
         FROM page_news
         ORDER BY date DESC
         LIMIT 0, 2';
        
if(($q_news = $db->query($sql)) === false) {
    $news_html = 'No news available<br><br><img src="./gfx/header_newsitem.jpg"><br><br>';
}
else {
    $news_html = '';

    while($news = $db->fetchrow($q_news)) {
        $news_day = (int)gmdate('d', $news['date']);
        $today = (int)gmdate('d', time());
        
        if($news_day == $today) {
            $date_str = 'Today, '.gmdate('H:i', $news['date']);
        }
        elseif($news_day == ($today - 1)) {
            $date_str = 'Yesterday, '.gmdate('H:i', $news['date']);
        }
        else {
            $date_str = gmdate('d.m.y', $news['date']);
        }

        $news_html .= '<span style="font-size: 10px;">'.$date_str.'</span><br><a href="index.php?a=news&show='.$news['id'].'"><b>'.$news['header'].'</b></a><br><br><img src="./gfx/header_newsitem.jpg"><br><br>';
    }
}

$sql = ' SELECT *
         FROM journal
         ORDER BY date DESC
         LIMIT 0, 2';

if(($q_journal = $db->query($sql)) === false) {
    $journal_html = 'No newspaper reports available<br><br><img src="./gfx/header_newsitem.jpg"><br><br>';
}
else {
    $journal_html = '';

    while($journal = $db->fetchrow($q_journal)) {
        $journal_day = (int)gmdate('d', $journal['date']);
        $today = (int)gmdate('d', time());

        if($journal_day == $today) {
            $date_str = 'Today, '.gmdate('H:i', $journal['date']);
        }
        elseif($journal_day == ($today - 1)) {
            $date_str = 'Yesterday, '.gmdate('H:i', $journal['date']);
        }
        else {
            $date_str = gmdate('d.m.y', $journal['date']);
        }

        $journal_html .= '<span style="font-size: 10px;">'.$date_str.'</span><br><a href="index.php?a=journal&show='.$journal['id'].'"><b>'.$journal['header'].'</b></a><br><br><img src="./gfx/header_newsitem.jpg"><br><br>';
    }
}

$main_html .= '
<table width="660" border="0" cellpadding="2" cellspacing="2">
  <tr valign="top">
    <td width="250" valign="top">
      <table width="250" border="0" cellpadding="2" cellspacing="2" valign="top">
        <tr height="30"><td width="250"></td></tr>
        <tr>
          <td width="250" align="left" background="./gfx/template_bg3.jpg"><img src="./gfx/bar.jpg" alt="empty" border=0></td>
        </tr>
        <tr>
          <td width="250" align="left"><img src="./gfx/defiant.jpg" alt="defiant" border=0></td>
        </tr>
      </table>
    </td>
    <td width="380" "height=320">
      <table border="0">
        <tr>
          <td width="380" height="60" background="./gfx/welcome_logo.jpg"></td>
        </tr>
        <tr>
          <td><span style="color: #6D87AC; font-size:12px"><br>
          Questo &egrave; un gioco multiplayer ambientato nell&#146;universo di Star Trek&trade;
          per il quale non &egrave; necessario altro che un semplice browser web ed una connessione
          ad Internet.<br><br>
          STFC2 &egrave; un gioco strategico e tattico che gira in tempo reale per dare ai giocatori
          la massima esperienza di gioco possibile.<br><br>
          Scegli la tua specie tra Federali, Klingon, Romulani e tanti altri, fonda le tue colonie,
          costruisci la tua flotta ed espandi la tua rete commerciale per arrivare l&agrave; dove
          nessun &egrave; mai giunto prima!</span>
          </td>
        </tr>
        <tr valign="bottom" align="right">
          <td><br><br><br>
           <!-- a href="http://www.sititrek.it/" target="new"><img src="./gfx/fist100x35.jpg" alt="Sito membro della Federazione Italiana Siti Trek" border="0"></a> -->
           <!-- a href="http://www.sititrek.it/" target="new"><img src="./gfx/fist100x100.jpg" alt="Sito membro della Federazione Italiana Siti Trek" border="0" width="50" height="50"></a> -->
<a href="http://www.topwebgames.it/"><img src="http://www.topwebgames.it/button.php?u=stfc" alt="Top Web Games Italia" border="0" /></a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
';

?>
