<?PHP
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


// Check which galaxy is selected
$galaxy = (int)$_REQUEST['galaxy'];

switch($galaxy)
{
    case 0:
        $mydb = $db;
        $galaxyname = GALAXY1_NAME;
        $galaxyimg = GALAXY1_BG;
    break;
    case 1:
        $mydb = $db2;
        $galaxyname = GALAXY2_NAME;
        $galaxyimg = GALAXY2_BG;
    break;
    default:
        $mydb = $db;
        $galaxyname = GALAXY1_NAME;
        $galaxyimg = GALAXY2_BG;
    break;
}

$main_html='<center><span class="caption">Registrazione</span>
<br><br>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" height="350" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td align="center">
    <span class="sub_caption">Informazioni sugli account multipli</span><br><br>
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$galaxyimg.'\'); background-position:left; background-repeat:no-repeat;">
<tr><td width=70% valign=top align="justify">
<p>Il multiaccount (ovvero la creazione di pi&ugrave; di un profilo di gioco appartenenti alla stessa persona) non &egrave;
consentito e punito con la cancellazione o l&#146;allontanamento (ban) per un periodo di tempo variabile degli account ridondanti.</p>
<p>Tuttavia lo staff &egrave; a conoscenza di particolari condizioni di utilizzo che potrebbero portare alla creazione di
un "falso" multi account.<br>Ad esempio, due fratelli che si collegano dallo stesso computer o due colleghi che accedono da una LAN.</p>
<p>Per tutti questi casi, &egrave; sufficiente prendere tempestivamente contatti con lo Staff per spiegare loro la situazione.<br>
Per farlo &egrave; possibile avvalersi di diversi metodi quali:
<ul>
<li>dal gioco, con l&#146;invio di un messaggio al Supporto seguendo la sezione "Aiuto"</li>
<li>dal forum, tramite l&#146;invio di un MP (Messaggio Personale) ad uno o pi&ugrave; degli amministratori e/o moderatori<li>
<li>via email, inviando una descrizione dettagliata ad "admin &lt;at&gt; stfc &lt;dot&gt; it".
</ul>
</td>
</tr></table>
</td>
</tr>
</table>
</center>


';
?>
