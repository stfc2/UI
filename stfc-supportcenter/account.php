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


function display_login($message='')

{

global $main_html;



if (!empty($message)) $message='<font color=red><b>Folgende Probleme sind aufgetreten:<br>'.$message.'</b></font><br>';



$main_html .= '

<table border=0 cellpadding=0 cellspacing=0><tr><td><span class="header1">&nbsp;Login</span></td></tr></table><br><br>

Du bist momentan nicht eingeloggt.<br>Um auf diesen Bereich zugreifen zu können musst du in deinen Account eingeloggt sein.<br>

<form name="login" method="post" action="index.php?p=account" onSubmit="return this.submit_b.disabled = true;">


<table border="0" cellpadding="2" cellspacing="2" width="350">

  <tr><td colspan=2>'.$message.'</td></tr>

  <tr><td width="25%">Benutzername:</td><td width="45%"><input style="width: 125px;" type="text" name="name" value="'.$_POST['name'].'"></td><td></td></tr>

  <tr><td width="25%">Passwort:</td><td width="45%"><input style="width: 125px;" type="password" name="password" value=""></td><td></td></tr>


  <tr>

  <td colspan=2>

	<input type=hidden name="submit" value="1">

	<input type="submit" name="submit_b" value="Einloggen">

	</td>

	</tr>





      </table>


</form>



<br><br>





</td>

<td width=40></td></tr>

</table>

';

}




function do_login()

{

global $db;

    if(empty($_POST['name']) || empty($_POST['password'])) {

        display_login('Bitte alle Felder ausfüllen'); return 1;

    }



    $pass = md5($_POST['password']);



    $sql = 'SELECT *

            FROM user

            WHERE name = "'.addslashes($_POST['name']).'"';



    if(($login_user = $db->queryrow($sql)) === false) {

        display_login('Konnte keine Verbindung zur Datenbank herstellen');

    }



    if(empty($login_user['id'])) {

        display_login('Benutzer existiert nicht'); return 1;

    }



    $cookie_data = array('id' => $login_user['id']);



    if($login_user['passwd'] == $pass) {

        $cookie_data['passwd'] = $pass;

    }

    else {

        display_login('Falscher Name/Passwort'); return 1;

    }



    if(!setcookie('stgcsupport_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {

       display_login('Es konnte kein Session-Cookie gesetzt werden, bitte überprüf deine Browser-Einstellungen bezüglich Cookie-Sicherheit'); return 1;

    }




    header('Location: index.php?p=home'); return 1;

}



function do_logout()

{    if(!setcookie('stgcsupport_session')) {

    }



    header('Location: index.php?p=home'); return 1;

}





if (empty($user) && isset($_POST['submit'])) {do_login(); return 1;}

if (empty($user)) {display_login(); return 1;}

if (isset($_GET['logout'])) {do_logout(); return 1;}

?>
