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


function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \"".$myname."\" <".$myemail.">\n";
  return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));
}



function generate_random_string($n_chars) {
    $chars = range('a', 'z');

    list($usec, $sec) = explode(' ', microtime());
    mt_srand($sec * $usec);

    $max_chars = count($chars) - 1;
    $rand_str = '';

    for($i = 0; $i < $n_chars; ++$i) {
        $rand_str .= $chars[mt_rand(0, $max_chars)];
    }

    return $rand_str;
}


$main_html .= '
<center><span class="caption">Recupero password</span></center><br>';

if (isset($_POST['galaxy']))
{
    $error = false;
    $message='Si &egrave; verificato il seguente problema:';

    $sql = 'SELECT user_id, user_email, user_name FROM user WHERE user_name="'.htmlspecialchars($_POST['user_name']).'" AND user_loginname="'.htmlspecialchars($_POST['user_loginname']).'"';

    /* 26/08/08 - AC: Check which galaxy the user has selected */
    if($_POST['galaxy'] == 0)
        $player = $db->queryrow($sql);
    else if($_POST['galaxy'] == 1)
        $player = $db2->queryrow($sql);
    /* */

    if($player === false)
    {
        message(DATABASE_ERROR, 'user_query: Could not query user data');
        exit();
    }

    if (!isset($player['user_id'])) {$message.='<br>Il nome utente o il nome login &egrave; errato'; $error=1;}
    else
        if (strcmp(strtolower($_POST['user_email']),strtolower($player['user_email']))!=0) {$message.='<br>L&#146;indirizzo email &egrave; errato'; $error=1;}

    if (!$error)
    {
        $newpassword = generate_random_string(10);
        $query='UPDATE user SET user_password="'.md5($newpassword).'" WHERE user_name= "'.htmlspecialchars($_REQUEST['user_name']).'"';

        /* 26/08/08 - AC: Check which galaxy the user has selected */
        if($_POST['galaxy'] == 0)
            if(($db->query($query)) === false) {message(DATABASE_ERROR, 'lostpassword_query: Could not update user data'); exit();}
        else if($_POST['galaxy'] == 1)
            if(($db2->query($query)) === false) {message(DATABASE_ERROR, 'lostpassword_query: Could not update user data'); exit();}
        /* */

    $mail_message =$_POST['user_name'].',
Apparentemente avete richiesto una nuova password.
Per cercare di effettuare il login adesso, si prega di utilizzare questa password:
'.$newpassword.'

Vi consigliamo di cambiare la password dopo aver effettuato l\'accesso nella pagina delle impostazioni.

Lunga vita e prosperità,
il team STFC.


Credits: http://www.stfc.it/index.php?a=imprint';

        send_mail("STFC Mailer","admin@stfc.it",$_POST['user_name'],$player['user_email'],"STFC2 Password Reminder",$mail_message);

        $message='Presto riceverai la nuova password via e-mail.';
    }
}

$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));
$player_online2 = $db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

$user_name = (!empty($_POST['user_name'])) ? $_POST['user_name'] : '';
$user_loginname = (!empty($_POST['user_loginname'])) ? $_POST['user_loginname'] : '';
$user_email = (!empty($_POST['user_email'])) ? $_POST['user_email'] : '';

$main_html .= '
<form method="post" action="index.php?a=lost_password">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="380" class="border_grey" style="background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
  <tr>
    <td width="100%">
    <center><b>Attenzione: riceverai una nuova password generata in automatico.</b></center><br>
    <center>'.(@$message).'</center><br>

      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="30%">Nome <b>utente</b>:</td>
          <td width="70%"><input type="text" name="user_name" size="30" class="field" value="'.$user_name.'"></td>
        </tr>

        <tr>
          <td width="30%">Nome <b>login</b>:</td>
          <td width="70%"><input type="text" name="user_loginname" size="30" class="field" value="'.$user_loginname.'"></td>
        </tr>

        <tr>
          <td>Indirizzo email:</td>
          <td><input type="text" name="user_email" size="30" class="field" value="'.$user_email.'"></td>
        </tr>

        <tr>
          <td>Galassia:</td>
          <td>
            <select name="galaxy">
              <option value="0">'.GALAXY1_NAME.' ['.$player_online['num'].' online]</option>
              <option value="1">'.GALAXY2_NAME.' ['.$player_online2['num'].' online]</option>
            </select>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<center>
[ <a href="index.php?a=login">Indietro alla Login</a> ]<br><br>
<input class="button" type="submit" name="stgc_password" value="Richiedi password">
</center>
</form>
';

?>
