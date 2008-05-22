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

if ($user['right']==1) {include('forbidden.php'); return 1;}

$main_html .= '<span class=header>Spieler bearbeiten</span><br>';


if (isset($_POST['remove']) && $_POST['confirm1']==1)
{
	$sql='UPDATE user SET user_active=4 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);
	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Spieler '.$name['user_name'].' gelöscht');	
	$main_html .= '<span class=header3><font color=green>Spieler gelöscht</font></span><br>';	
}

if (isset($_POST['ban']) && $_POST['confirm2']==1)
{
	$sql='UPDATE user SET user_active=0 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);
	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Spieler '.$name['user_name'].' gebannt');	
	$main_html .= '<span class=header3><font color=green>Spieler gebannt</font></span><br>';	
}

if (isset($_POST['unban']) && $_POST['confirm2']==1)
{
	$sql='UPDATE user SET user_active=1 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Spieler '.$name['user_name'].' unbanned');	
	$main_html .= '<span class=header3><font color=green>Spieler unbanned</font></span><br>';	
}

if (isset($_POST['deactivate']) && $_POST['confirm3']==1)
{
	$sql='UPDATE user SET user_active=2 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Spieler '.$name['user_name'].' deaktiviert');	
	$main_html .= '<span class=header3><font color=green>Spieler deaktiviert</font></span><br>';	
}

if (isset($_POST['activate']) && $_POST['confirm3']==1)
{
	$sql='UPDATE user SET user_active=1 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Spieler '.$name['user_name'].' aktiviert');	
	$main_html .= '<span class=header3><font color=green>Spieler aktiviert</font></span><br>';	
}

if (isset($_POST['submitdata']))
{
	
    if(empty($_POST['name'])) {
       	$main_html .= '<span class=header3><font color=red>Kein Spielername angegeben</font></span><br>';
        return true;
    }
    
    if(strstr($_POST['name'], ' ')) {
       	$main_html .= '<span class=header3><font color=red>Spielername enthält ein Leerzeichen</font></span><br>';
        return true;
    }
    
    for ($count=0; $count < strlen($_POST['name']); $count++) {
       $val=ord( (substr($_POST['name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
       	$main_html .= '<span class=header3><font color=red>Spielername enthält unzulässige Zeichen [nur 0-9,a-z,A-Z]</font></span><br>';
        return true;
       }
   }

    for ($count=0; $count < strlen($_POST['loginname']); $count++) {
       $val=ord( (substr($_POST['loginname'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
       	$main_html .= '<span class=header3><font color=red>Loginname enthält unzulässige Zeichen [nur 0-9,a-z,A-Z]</font></span><br>';
        return true;
       }
   }

    if(!in_array($_POST['race'], array(0, 1, 2, 3, 4, 5, 8, 9, 11))) {
       	$main_html .= '<span class=header3><font color=red>Rasse existiert nicht</font></span><br>';
        return true;
    }

	$sql='UPDATE user SET user_name="'.$_POST['name'].'", user_loginname="'.$_POST['loginname'].'", user_race="'.$_POST['race'].'", user_alliance_status="'.$_POST['alliance_status'].'", user_email="'.$_POST['email'].'" WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);
	$main_html .= '<span class=header3><font color=green>Spielerdaten übernommen</font></span><br>';
	log_action('Spielerdaten bei Spieler '.$_POST['name'].' geändert');	
}


if(isset($_REQUEST['name'])) {
$sql = 'SELECT u.*,a.alliance_tag,a.alliance_name FROM user u LEFT JOIN alliance a ON a.alliance_id=u.user_alliance WHERE u.user_name="'.htmlspecialchars($_REQUEST['name']).'"';
$player=$db->queryrow($sql);
}


if (!isset($player['user_id']))
{
$main_html .= '
<span class=header3><font color=green>Spieler suchen</font></span><br>
<form method="post" action="index.php?p=user">
<input type="text" name="name" value="'.$_POST['name'].'" class="field">
<input class="button" type="submit" name="submit" value="Spieler suchen">
</form>';
return 1;
}

$status='<font color=green>aktiv</font>';
if ($player['user_active']==0) $status='<font color=red>gebannt</font>';
if ($player['user_active']==2) $status='<font color=blue>noch nicht aktiviert</font>';

$main_html .= '
<span class=header3><font color=green>Spieler '.$player['user_name'].' ('.$status.') bearbeiten:</font></span><br>
<form method="post" action="index.php?p=user">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td width=100>Allianz:</td><td>'.$player['alliance_name'].'</td></tr>
<tr><td width=100>Spielername:</td><td><input type="text" name="name" value="'.$player['user_name'].'" class="field"></td></tr>
<tr><td width=100>Loginname:</td><td><input type="text" name="loginname" value="'.$player['user_loginname'].'" class="field"></td></tr>
<tr><td width=100>Emailadresse:</td><td><input type="text" name="email" value="'.$player['user_email'].'" class="field"></td></tr>
<tr><td width=100>Allianzstatus:</td><td>
            <select style="width: 150px;" name="alliance_status">
              <option value="1"'.( ($player['user_alliance_status'] == 1) ? ' selected="selected"' : '' ).'>Mitglied</option>
              <option value="2"'.( ($player['user_alliance_status'] == 2) ? ' selected="selected"' : '' ).'>Admin</option>
              <option value="3"'.( ($player['user_alliance_status'] == 3) ? ' selected="selected"' : '' ).'>Präsident</option>
            </select>
            </td>
            </tr>
<tr><td width=100>Rasse *:</td><td>
            <select style="width: 150px;" name="race">
              <option value="0"'.( ($player['user_race'] == 0) ? ' selected="selected"' : '' ).'>Menschen</option>
              <option value="1"'.( ($player['user_race'] == 1) ? ' selected="selected"' : '' ).'>Romulaner</option>
              <option value="2"'.( ($player['user_race'] == 2) ? ' selected="selected"' : '' ).'>Klingonen</option>
              <option value="3"'.( ($player['user_race'] == 3) ? ' selected="selected"' : '' ).'>Cardassianer</option>
              <option value="4"'.( ($player['user_race'] == 4) ? ' selected="selected"' : '' ).'>Dominion</option>
              <option value="5"'.( ($player['user_race'] == 5) ? ' selected="selected"' : '' ).'>Ferengi</option>
			  <option value="8"'.( ($player['user_race'] == 8) ? ' selected="selected"' : '' ).'>Spezies 8472</option>
			  <option value="9"'.( ($player['user_race'] == 9) ? ' selected="selected"' : '' ).'>Hirogen</option>
			  <option value="11"'.( ($player['user_race'] == 11) ? ' selected="selected"' : '' ).'>Kazon</option>
            </select>
            </td>
            </tr>
</table><br>
* Achtung: Die Rasse kann IMMER geändert werden, aber ab ~100 Punkte auf min. einem Planeten ist es nicht empfehlenswert (Probleme mit der Komponentenforschung).
<br>
<input type=hidden name="id" value="'.$player['user_id'].'">
<input class="button" type="submit" name="submitdata" value="Daten übernehmen">
<br><br>

<input style="border: none;" type="checkbox" name="confirm1" value="1"> Sicherheitsbestätigung (Löschen)&nbsp;&nbsp;
<input class="button" type="submit" name="remove" value="Spieler löschen">
<br><br>
'.($player['user_active']==1 ?
'<input style="border: none;" type="checkbox" name="confirm2" value="1"> Sicherheitsbestätigung (Bannen)&nbsp;&nbsp;
<input class="button" type="submit" name="ban" value="Spieler bannen">
'
:
'<input style="border: none;" type="checkbox" name="confirm2" value="1"> Sicherheitsbestätigung (Unbannen)&nbsp;&nbsp;
<input class="button" type="submit" name="unban" value="Spieler unbannen">
').'
<br><br>
'.($player['user_active']==1 ?
'<input style="border: none;" type="checkbox" name="confirm3" value="1"> Sicherheitsbestätigung (Deaktivieren)&nbsp;&nbsp;
<input class="button" type="submit" name="deactivate" value="Spieler deaktivieren">
'
:
'<input style="border: none;" type="checkbox" name="confirm3" value="1"> Sicherheitsbestätigung (Aktivieren)&nbsp;&nbsp;
<input class="button" type="submit" name="activate" value="Spieler aktivieren">
').'
</form>
';

