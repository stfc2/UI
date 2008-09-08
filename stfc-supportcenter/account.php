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



if (!empty($message)) $message='<font color=red><b>Rilevato il seguente problema:<br>'.$message.'</b></font><br>';



$main_html .= '

<table border=0 cellpadding=0 cellspacing=0><tr><td><span class="header1">&nbsp;Login</span></td></tr></table><br><br>

Al momento non sei autenticato.<br>Per accedere a questa sezione, &egrave; necessario avere accesso al tuo account.<br>

<form name="login" method="post" action="index.php?p=account" onSubmit="return this.submit_b.disabled = true;">


<table border="0" cellpadding="2" cellspacing="2" width="350">

  <tr><td colspan=2>'.$message.'</td></tr>

  <tr><td width="25%">Galassia:</td><td width="45%"><select name="galaxy"><option value="0" selected="selected">'.GALAXY1_NAME.'</option> !--><option value="1">'.GALAXY2_NAME.'</option> !--></select></td><td></td></tr>

  <tr><td width="25%">Nome utente:</td><td width="45%"><input style="width: 125px;" type="text" name="name" value="'.$_POST['name'].'"></td><td></td></tr>

  <tr><td width="25%">Password:</td><td width="45%"><input style="width: 125px;" type="password" name="password" value=""></td><td></td></tr>


  <tr>

  <td colspan=2>

	<input type=hidden name="submit" value="1">

	<input type="submit" name="submit_b" value="Login">

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

global $db,$db2;

    if(!isset($_POST['galaxy']) || empty($_POST['name']) || empty($_POST['password'])) {

        display_login('Per favore compila tutti i campi'); return 1;

    }


    $galaxy = (int)$_POST['galaxy'];
    switch($galaxy)
    {
        case 0:
            $mydb = $db;
        break;
        case 1:
            $mydb = $db2;
        break;
    }


    $pass = md5($_POST['password']);



    $sql = 'SELECT *

            FROM user

            WHERE user_loginname = "'.addslashes($_POST['name']).'"';



    if(($login_user = $mydb->queryrow($sql)) === false) {

        display_login('Impossibile connettersi al database');

    }



    if(empty($login_user['user_id'])) {

        display_login('Utente non esistente'); return 1;

    }



    $cookie_data = array('id' => $login_user['user_id']);

    $cookie_data['galaxy'] = $galaxy;


    if($login_user['user_password'] == $pass) {

        $cookie_data['passwd'] = $pass;

    }

    else {

        display_login('Nome/Password errati'); return 1;

    }

    if($login_user['user_auth_level'] == 3) {

        $cookie_data['auth_level'] = $login_user['user_auth_level'];

    }

    else {

        display_login('Utente non abilitato'); return 1;

    }


    if(!setcookie('stgcsupport_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {

       display_login('Non &egrave; stato possibile impostare alcuna sessione cookie, per favore controlla le impostazioni di sicurezza cookie del browser'); return 1;

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
