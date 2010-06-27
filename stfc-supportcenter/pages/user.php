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

$main_html .= '<span class=header>Modifica giocatore</span><br>';


if (isset($_POST['remove']) && $_POST['confirm1']==1)
{
	$sql='UPDATE user SET user_active=4 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);
	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Giocatore '.$name['user_name'].' cancellato');
	$main_html .= '<span class=header3><font color=green>Giocatore cancellato</font></span><br>';
}

if (isset($_POST['ban']) && $_POST['confirm2']==1)
{
	$sql='UPDATE user SET user_active=0 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);
	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Giocatore '.$name['user_name'].' bannato');
	$main_html .= '<span class=header3><font color=green>Giocatore bannato</font></span><br>';
}

if (isset($_POST['unban']) && $_POST['confirm2']==1)
{
	$sql='UPDATE user SET user_active=1 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Giocatore '.$name['user_name'].' non bannato');
	$main_html .= '<span class=header3><font color=green>Giocatore non bannato</font></span><br>';
}

if (isset($_POST['deactivate']) && $_POST['confirm3']==1)
{
	$sql='UPDATE user SET user_active=2 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Giocatore '.$name['user_name'].' disattivato');
	$main_html .= '<span class=header3><font color=green>Giocatore disattivato</font></span><br>';
}

if (isset($_POST['activate']) && $_POST['confirm3']==1)
{
	$sql='UPDATE user SET user_active=1 WHERE user_id="'.$_POST['id'].'"';
	$db->query($sql);

	$name=$db->queryrow('SELECT user_name FROM user WHERE user_id="'.$_POST['id'].'"');
	log_action('Giocatore '.$name['user_name'].' attivato');
	$main_html .= '<span class=header3><font color=green>Giocatore attivato</font></span><br>';
}

if (isset($_POST['submitdata']))
{

    if(empty($_POST['name'])) {
       	$main_html .= '<span class=header3><font color=red>Nessun nome giocatore</font></span><br>';
        return true;
    }
    
    if(strstr($_POST['name'], ' ')) {
       	$main_html .= '<span class=header3><font color=red>Il nome del giocatore contiene spazi</font></span><br>';
        return true;
    }
    
    for ($count=0; $count < strlen($_POST['name']); $count++) {
       $val=ord( (substr($_POST['name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
       	$main_html .= '<span class=header3><font color=red>Il nome del giocatore contiene caratteri non permessi [solo 0-9,a-z,A-Z]</font></span><br>';
        return true;
       }
   }

    for ($count=0; $count < strlen($_POST['loginname']); $count++) {
       $val=ord( (substr($_POST['loginname'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
       	$main_html .= '<span class=header3><font color=red>La login contiene caratteri non permessi [solo 0-9,a-z,A-Z]</font></span><br>';
        return true;
       }
   }

    if(!in_array($_POST['race'], array(0, 1, 2, 3, 4, 5, 8, 9, 11, 12))) {
       	$main_html .= '<span class=header3><font color=red>La specie non esiste</font></span><br>';
        return true;
    }

    $sql='UPDATE user SET user_name="'.$_POST['name'].'", user_loginname="'.$_POST['loginname'].'", user_race="'.$_POST['race'].'", user_alliance_status="'.$_POST['alliance_status'].'", user_email="'.$_POST['email'].'" WHERE user_id="'.$_POST['id'].'"';
    $db->query($sql);

    /* 21/05/08 - AC: Aggiunta possibilita' cambio specie anche per giocatori con piu' di 100pt */
    $sql='UPDATE ship_templates SET race="'.$_POST['race'].'" WHERE owner="'.$_POST['id'].'"';
    $db->query($sql);
    /* */

    /* 27/04/09 - AC: Added code check to assign correct rights to a new alliance president */
    if($_POST['alliance_status'] == 3)
    {
        // Retrive alliance ID
        $sql = 'SELECT user_alliance FROM user WHERE user_id = '.$_POST['id'];
        $user=$db->queryrow($sql);

        // If set, change alliance owner
        if (isset($user['user_alliance']))
        {
            $sql = 'UPDATE user, alliance
                    SET alliance_owner = '.$_POST['id'].',
                        user_alliance_rights1 = 1,
                        user_alliance_rights2 = 1,
                        user_alliance_rights3 = 1,
                        user_alliance_rights4 = 1,
                        user_alliance_rights5 = 1,
                        user_alliance_rights6 = 1,
                        user_alliance_rights7 = 1,
                        user_alliance_rights8 = 1
                    WHERE user_id = '.$_POST['id'].' AND alliance_id = '.$user['user_alliance'];

            $db->query($sql);
        }
    }
    /* */

    $main_html .= '<span class=header3><font color=green>Dati giocatori ripresi</font></span><br>';
    log_action('Dati giocatori '.$_POST['name'].' modificati');
}


if(isset($_REQUEST['name'])) {
$sql = 'SELECT u.*,a.alliance_tag,a.alliance_name FROM user u LEFT JOIN alliance a ON a.alliance_id=u.user_alliance WHERE u.user_name="'.htmlspecialchars($_REQUEST['name']).'"';
$player=$db->queryrow($sql);
}


if (!isset($player['user_id']))
{
$main_html .= '
<span class=header3><font color=green>Cerca giocatore</font></span><br>
<form method="post" action="index.php?p=user">
<input type="text" name="name" value="'.$_POST['name'].'" class="field">
<input class="button" type="submit" name="submit" value="Cerca">
</form>';
return 1;
}

$status='<font color=green>attivo</font>';
if ($player['user_active']==0) $status='<font color=red>bannato</font>';
if ($player['user_active']==2) $status='<font color=blue>non ancora attivato</font>';

$main_html .= '
<span class=header3><font color=green>Informazioni per il giocatore '.$player['user_name'].' ('.$status.'):</font></span><br>
<form method="post" action="index.php?p=user">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td width=100>Alleanza:</td><td>'.$player['alliance_name'].'</td></tr>
<tr><td width=100>Nome giocatore:</td><td><input type="text" name="name" value="'.$player['user_name'].'" class="field"></td></tr>
<tr><td width=100>Nome login:</td><td><input type="text" name="loginname" value="'.$player['user_loginname'].'" class="field"></td></tr>
<tr><td width=100>Indirizzo email:</td><td><input type="text" name="email" value="'.$player['user_email'].'" class="field"></td></tr>
<tr><td width=100>Stato alleanza:</td><td>
            <select style="width: 150px;" name="alliance_status">
              <option value="1"'.( ($player['user_alliance_status'] == 1) ? ' selected="selected"' : '' ).'>Membro</option>
              <option value="2"'.( ($player['user_alliance_status'] == 2) ? ' selected="selected"' : '' ).'>Admin</option>
              <option value="3"'.( ($player['user_alliance_status'] == 3) ? ' selected="selected"' : '' ).'>Presidente</option>
            </select>
            </td>
            </tr>
<tr><td width=100>Specie *:</td><td>
            <select style="width: 150px;" name="race">
              <option value="0"'.( ($player['user_race'] == 0) ? ' selected="selected"' : '' ).'>Federazione</option>
              <option value="1"'.( ($player['user_race'] == 1) ? ' selected="selected"' : '' ).'>Romulani</option>
              <option value="2"'.( ($player['user_race'] == 2) ? ' selected="selected"' : '' ).'>Klingon</option>
              <option value="3"'.( ($player['user_race'] == 3) ? ' selected="selected"' : '' ).'>Cardassiani</option>
              <option value="4"'.( ($player['user_race'] == 4) ? ' selected="selected"' : '' ).'>Dominio</option>
              <option value="5"'.( ($player['user_race'] == 5) ? ' selected="selected"' : '' ).'>Ferengi</option>
              <option value="8"'.( ($player['user_race'] == 8) ? ' selected="selected"' : '' ).'>Breen</option>
              <option value="9"'.( ($player['user_race'] == 9) ? ' selected="selected"' : '' ).'>Hirogeni</option>
              <option value="11"'.( ($player['user_race'] == 11) ? ' selected="selected"' : '' ).'>Kazon</option>
              <option value="12"'.( ($player['user_race'] == 12) ? ' selected="selected"' : '' ).'>Krenim</option>
            </select>
            </td>
            </tr>
</table><br>
* Attenzione: La specie solitamente pu&ograve; essere modificata, ma a partire da almeno ~100 punti sul pianeta non &egrave; raccomandabile (problemi con la ricerca dei componenti).
<br>
<input type=hidden name="id" value="'.$player['user_id'].'">
<input class="button" type="submit" name="submitdata" value="Aggiorna dati">
<br><br>

<input style="border: none;" type="checkbox" name="confirm1" value="1"> Conferma di sicurezza (cancella)&nbsp;&nbsp;
<input class="button" type="submit" name="remove" value="Cancella giocatore">
<br><br>
'.($player['user_active']==1 ?
'<input style="border: none;" type="checkbox" name="confirm2" value="1"> Conferma di sicurezza (sospendi)&nbsp;&nbsp;
<input class="button" type="submit" name="ban" value="Sospendi giocatore">
'
:
'<input style="border: none;" type="checkbox" name="confirm2" value="1"> Conferma di sicurezza (riabilita)&nbsp;&nbsp;
<input class="button" type="submit" name="unban" value="Riabilita giocatore">
').'
<br><br>
'.($player['user_active']==1 ?
'<input style="border: none;" type="checkbox" name="confirm3" value="1"> Conferma di sicurezza (disattiva)&nbsp;&nbsp;
<input class="button" type="submit" name="deactivate" value="Disattiva giocatore">
'
:
'<input style="border: none;" type="checkbox" name="confirm3" value="1"> Conferma di sicurezza (attiva)&nbsp;&nbsp;
<input class="button" type="submit" name="activate" value="Attiva giocatore">
').'
</form>
';

