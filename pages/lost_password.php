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
<center><span class="caption">Forgotten password</span></center><br>';

if (isset($_POST['galaxy']) && $_POST['galaxy']==0)
{
$error = false;
$message='The following problems occurred:';
if(($player = $db->queryrow('SELECT user_id, user_email, user_name FROM user WHERE user_name="'.htmlspecialchars($_POST['user_name']).'" AND user_loginname="'.htmlspecialchars($_POST['user_loginname']).'"')) === false) {message(DATABASE_ERROR, 'user_query: Could not query user data'); exit();}

if (!isset($player['user_id'])) {$message.='<br>User name or login name is misspelled'; $error=1;}
else
if (strcmp(strtolower($_POST['user_email']),strtolower($player['user_email']))!=0) {$message.='<br>Email adress is misspelled'; $error=1;}
if (!$error)
{
$newpassword = generate_random_string(10);
$query='UPDATE user SET user_password="'.md5($newpassword).'" WHERE user_name= "'.htmlspecialchars($_REQUEST['user_name']).'"';
if(($db->query($query)) === false) {message(DATABASE_ERROR, 'lostpassword_query: Could not update user data'); exit();}


    $mail_message =$_POST['user_name'].',
You have apparently requested a new password.
To try to login now, please use this password:
'.$newpassword.'

We advise you to change the password after logged in below settings page.

Lebe lang und erfolgreich,
Dein STGC Team.


Impression: http://stfc.nonsolotaku.it/index.php?a=imprint';

send_mail("STFC Mailer","foobar@stgc.de",$_POST['user_name'],$player['user_email'],"STFC2 Password Reminder",$mail_message);

$message='You will soon receive your new password via e-mail.';
}
}

$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

$user_name = (!empty($_POST['user_name'])) ? $_POST['user_name'] : '';
$user_loginname = (!empty($_POST['user_loginname'])) ? $_POST['user_loginname'] : '';
$user_email = (!empty($_POST['user_email'])) ? $_POST['user_email'] : '';

$main_html .= '
<form method="post" action="index.php?a=lost_password">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="380" class="border_grey" style="background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
  <tr>
    <td width="100%">
    <center><b>Caution: You will get a new, randomly generated password.</b></center><br>
    <center>'.(@$message).'</center><br>
    
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="30%"><b>User</b>name:</td>
          <td width="70%"><input type="text" name="user_name" size="30" class="field" value="'.$user_name.'"></td>
        </tr>

        <tr>
          <td width="30%"><b>Login</b>name:</td>
          <td width="70%"><input type="text" name="user_loginname" size="30" class="field" value="'.$user_loginname.'"></td>
        </tr>

        <tr>
          <td>Email adress:</td>
          <td><input type="text" name="user_email" size="30" class="field" value="'.$user_email.'"></td>
        </tr>
	
	<tr>
          <td>Galaxy:</td>
          <td>
            <select name="galaxy">
              <option value="0">Brown Bobby ['.$player_online['num'].' online]</option>
            </select>
          </td>
	  </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<center>
[<a href="index.php?a=login">Back to Login</a>]<br><br>
<input class="button" type="submit" name="stgc_password" value="Request password">
</center>
</form>
';

?>
