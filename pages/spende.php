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


$main_html='<center><span class="caption">Supporta Star Trek: Frontline Combat!</span>
<br><br>
<table border=0 cellpadding=0 cellspacing=0>
<tr><td width=300 valign=top align="justify">
<p>Cari colleghi e giocatori,<br><br>
a seguito di alcune defezioni nello staff tecnico che da a tutti la possibilit&agrave; di divertirci con <b>Star Trek Frontline Combat</b>,
le spese di gestione del server stanno diventando poco gestibili.</p>
<p>Tenteremo per quanto possibile di sostenere la situazione, tuttavia il rischio di chiusura del server &egrave; tristemente concreto.</p>
<p>Dunque ogni contributo spontaneo &egrave; assolutamente benaccetto! Visto il numero di utenti, basterebbe davvero poco da ciascuno per
scongiurare il rischio di chiusura: pensate solo a quanto costano normalmente i videogiochi ed eventuali abbonamenti per giocare online,
credo che di fronte a queste cifre diventi accettabile "<i>offrir da bere</i>" a chi senza aver mai chiesto nulla si &egrave; sempre prodigato a mantenere attivo il sito per il vostro divertimento.<p>
<p>Purtroppo non sempre si pu&ograve; solo donare, per quanto bello, a volte ci si trova nelle condizioni di dover cortesemente chiedere... sperando di avere risposte positive dalle persone presenti dietro ai giocatori che si &egrave; iniziato a stimare nel nostro piccolo spazio virtuale.</p>
<p>Se la generosit&agrave; di tutti dovesse superare le aspettative, ovviamente un eventuale eccesso verrebbe reinvestito nel potenziamento
del server, oppure nel pagamento degli anni successivi.</p>
<p>Grazie a tutti e buon gioco!</p>
</td>
<td width="220" valign="middle" align="center">
<img src="gfx/uncle-sam-wants-you.jpg" width="170">
</td>
</tr>
<tr>
<td colspan="2" align="center">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/x-click-but04.gif" border="0" name="submit" alt="PayPal - Il sistema di pagamento online più facile e sicuro!">
<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form></td>
</tr></table>
</center>


';
?>
