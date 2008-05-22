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

$proverbs = array(
    'Unter den Waffen schweigen die Gesetze.',
    'Die Wahrheit ist üblicherweise nur eine Entschuldigung für mangelnde Phantasie.',
    'Verrat liegt wie die Schönheit im Auge des Betrachters.',
    'Aus Feinden können sehr gefährliche Freunde werden.',
    'Ein wahrer Sieg besteht darin,<br>dass dem Feind klar wird,<br>wie falsch es war,<br>überhaupt Widerstand zu leisten.',
    'Das Glück begünstigt den Mutigen.',
    'Wenn wir die Starken sind,<br>ist das nicht das Signal zum Krieg?',
    'Diejenigen, die nichts aus der Geschichte lernen,<br>sind dazu verdammt, sie zu wiederholen.<br><br>Diejenigen, die nicht richtig aus der Geschichte lernen,<br>sind einfach nur verdammt.',
    'Das ist alles, was ich über den Krieg weiß:<br>Einer gewinnt, einer verliert<br>und nichts ist nachher so,<br>wie es vorher war.',
    'Reichtum ist zu wertvoll,<br>um ihn den Reichen zu überlassen.',
    'Leben?<br>Das Leben ist wie eine Messerstecherei in einer völlig verdreckten Bar:<br>Wenn man auf dem Boden gezwungen wird,<br>steht am besten schnell wieder auf.',
    'Absolute Macht korrumpiert absolut.<br>Was ein Problem ist.<br>Wenn man keine Macht hat.',
    'Man kann dem Tod nicht für immer entrinnen.<br>Aber man kann es dem Schweinehund sehr schwer machen.',
    'Vor dem Wissen kommen das Verstehen.<br>Vor dem Verstehen kommt das Sehen.<br>Vor dem Sehen kommt das Erkennen.<br>Vor dem Erkennen kommt das Wissen.',
    'Erfolg ist die Summe richtiger Entscheidungen.',
    'Der ungerechteste Frieden ist immer noch besser als der gerechteste Krieg.',
    'Was für niemanden einen Nutzen zu haben scheint,<br>das wird auch nicht zum Ziel für Wünsche anderer.',
    'Freiheit ist nicht das Abwerfen von Ketten - dies ist lediglich ihre Voraussetzung.<br>Freiheit ist das Vermögen, sich für einen Weg zu entscheiden und diesen zu gehen.<br><br>Doch sollte sich dieser Weg als falsch erweisen, so ist erneut eine Wahl zu treffen.<br>Wer ihn dennoch weitergeht, legt sich selbst in neue Ketten.',
    'Der Anfänger einer Kampfkunst kann nicht kämpfen,<br>tut es aber oft.<br><br>Der Meister kann kämpfen,<br>tut es aber nur selten.',
    'Es ist besser, unvollkommene Entscheidungen durchzuführen,<br>als immerzu nach vollkommenen Entscheidungen zu suchen,<br>die es niemals geben wird.',
    'Wenn ein Löwe von rechts kommt,<br>sollte man nach links laufen.<br><br>In dieser Situation hilft es nicht kreativ zu sein,<br>es wird dich umbringen.',
    'Der Sieger in einem Kampf Mann gegen Mann ist der derjeninge,<br>der eine Kugel mehr im Magazin hat.',
    'Man verliert die meiste Zeit damit, dass man Zeit gewinnen will...',
    'Wer Krieg führt, will nur Frieden nach seinen Bedingungen'
);

$n_proverbs = count($proverbs);





function display_message($header,$message,$bg) {
    global $main_html;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="500" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">'.$header.'</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/'.$bg.'.jpg\'); background-position:left; background-repeat:yes;">
        <tr height="300">
          <td width="100%" valign=top><span class="sub_caption2"><br>'.$message.'<br><br></span></td>
        </tr>
	</table>
	</td>
	</tr>
	</table>';
}



$main_html = '<center><span class="caption">Accountaktivierung</span></center><br>';


if( (empty($_GET['user_id'])) || (empty($_GET['key'])) ) {
display_message('Fehler bei der Accountaktivierung (Ungültiger Aufruf)','','ngc7742bg');
    return 1;
}

$user_id = (int)$_GET['user_id'];

$gkey=$_GET['key'];
$key = md5( pow( $user_id ,2) );
$bg='ngc7742bg';

if($gkey != $key) {
display_message('Fehler bei der Accountaktivierung (Ungültiger Aktivierungscode #1)','',$bg);
return 1;
}

$sql = 'SELECT user_active
        FROM user
        WHERE user_id = '.$user_id;

	 
if(($user_data = $db->queryrow($sql)) === false) {
    die('Datenbankfehler - Konnte Benutzer nicht überprüfen');
}

if(empty($user_data['user_active'])) {
	display_message('Fehler bei der Accountaktivierung (Ungültiger Aktivierungscode #2)','',$bg);
    return 1;
}

if($user_data['user_active'] != 2) {
	display_message('Fehler bei der Accountaktivierung (Spieler bereits aktiviert)','',$bg);
    return 1;
}

$sql = 'UPDATE user
        SET user_active = 1, last_active='.time().'
        WHERE user_id = '.$user_id;
$db->query($sql);  


mt_srand((double)microtime()*1000000);

$current_proverb = $proverbs[mt_rand(0, ($n_proverbs - 1))];

display_message('Dein Account wurde erfolgreich aktiviert!','Du kannst dich nun mit deinem Loginnamen und Passwort einloggen.<br><br>Bevor du dich nun in die Welt von STGC stürzt, noch eine Weisheit für ein erfolgreiches Spiel:<br><br><table width="100%" border="0" align="center"><tr><td width="10%">&nbsp;</td><td width="90%"><i>'.$current_proverb.'</i></td></tr></table>',$bg);

?>
