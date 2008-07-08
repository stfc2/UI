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







function display_success() {
    global $main_html;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">Registration for "Brown Bobby Galaxy" successfull:</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/ngc7742bg.jpg\'); background-position:left; background-repeat:no-repeat;">
        <tr height="300">
          <td width="100%" valign=top><span class="sub_caption2"><br><br>The registration was successful!<br><br>An email was sent to your email address,
          which you can activate your account. <br> <b> The mail will probably land in the spam folder, then please verify.</span></td>
        </tr>
	</table>
	</td>
	</tr>
	</table>';
}
	

function display_registration($data = array(), $message = '') {
    global $main_html;

    /* 28/01/08 - AC: Added initialization of this fields */
    if(!isset($data['login_name'])) $data['login_name'] = '';
    if(!isset($data['plz'])) $data['plz'] = '';
    if(!isset($galaxy)) $galaxy = '';

    if(!isset($data['user_name'])) $data['user_name'] = '';
    if(!isset($data['user_password'])) $data['user_password'] = '';
    if(!isset($data['user_password2'])) $data['user_password2'] = '';
    if(!isset($data['user_email'])) $data['user_email'] = '';
    $race_selected = (isset($data['user_race'])) ? $data['user_race'] : 0;
    $agb_checked = (!empty($data['confirm_agb'])) ? true : false;
    if(!isset($data['user_birthday_day'])) $data['user_birthday_day'] = '';
    if(!isset($data['user_birthday_month'])) $data['user_birthday_month'] = '';
    if(!isset($data['user_birthday_year'])) $data['user_birthday_year'] = '';
    $gender_selected = (isset($data['user_gender'])) ? $data['user_gender'] : '-';
    
	/* 13/03/08 - AC: Default country is Italy */
    if(!isset($data['country'])) $data['country'] = 'IT';
    if ($data['country']!='DE' && $data['country']!='AT' && $data['country']!='CH' &&
		$data['country']!='IT' && $data['country']!='UK' && $data['country']!='US' &&
		$data['country']!='FR') $data['country']='XX';
    

    $main_html .= '
<form name="register" method="post" action="index.php?a=register" onSubmit="return this.submit_b.disabled = true;">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">(2/2) Registration "Brown Bobby Galaxy":</span></center>
    <center><span class="sub_caption2">'.$message.'</span></center><center>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/ngc7742bg.jpg\'); background-position:left; background-repeat:no-repeat;">
        <tr>
          <td colspan="2"><span class="sub_caption2">Game information (required)</span></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td width="15%">Player name *:</td>
          <td width="85%"><input style="width: 200px;" type="text" name="user_name" value="'.$data['user_name'].'"></td>
        </tr>

        <tr>
          <td width="15%">Login **:</td>
          <td width="85%"><input style="width: 200px;" type="text" name="login_name" value="'.$data['login_name'].'"></td>
        </tr>

        <tr>
          <td>Password:</td>
          <td><input style="width: 200px;" type="password" name="user_password" value="'.$data['user_password'].'"></td>
        </tr>

        <tr>
          <td>Rept. Password:</td>
          <td><input style="width: 200px;" type="password" name="user_password2" value="'.$data['user_password2'].'"></td>
        </tr>

        <tr>
          <td>Email:</td>
          <td><input style="width: 200px;" type="text" name="user_email" value="'.$data['user_email'].'"></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Race:</td>
          <td>
            <select style="width: 150px;" name="user_race" onChange="expandone();">
              <option value="0"'.( ($race_selected == 0) ? ' selected="selected"' : '' ).'>Federation</option>
              <option value="1"'.( ($race_selected == 1) ? ' selected="selected"' : '' ).'>Romulans</option>
              <option value="2"'.( ($race_selected == 2) ? ' selected="selected"' : '' ).'>Klingons</option>
              <option value="3"'.( ($race_selected == 3) ? ' selected="selected"' : '' ).'>Cardassians</option>
              <option value="4"'.( ($race_selected == 4) ? ' selected="selected"' : '' ).'>Dominion</option>
              <option value="5"'.( ($race_selected == 5) ? ' selected="selected"' : '' ).'>Ferengi</option>
              <option value="8"'.( ($race_selected == 8) ? ' selected="selected"' : '' ).'>Breen</option>
              <option value="9"'.( ($race_selected == 9) ? ' selected="selected"' : '' ).'>Hirogen</option>
              <option value="10"'.( ($race_selected == 10) ? ' selected="selected"' : '' ).'>Krenim</option>
             <option value="11"'.( ($race_selected == 11) ? ' selected="selected"' : '' ).'>Kazon</option>
            </select>
        </td>
        </tr>

       <tr>
        <td align="center">&nbsp;

        </td>
        <td>

<div id="dropmsg0" class="dropcontent">
<br>The Federation. It is the player with the maximum range of different vessel types. Ships of the Federation have the strongest shields of the Galaxy. The rates of resource production are average, likewise the troops. In comparison to other breeds, the Federation has good research values.
</div>

<div id="dropmsg1" class="dropcontent">
<br>The Romulans have their strength in fast and cheap construction of ships and units, but makes incredible low dilithium and the comparison of relatively weak forces to create. They have ships with a strong ability to camouflage.
</div>

<div id="dropmsg2" class="dropcontent">
<br>The Klingons are a warlike race with big bonuses in the ship and unit combat. As a penalty, the construction times of troops and buildings are extremely high. Moreover, research is not as favourable Verngügen Klingons.
</div>

<div id="dropmsg3" class="dropcontent">
<br>The Cardassians, the oppressors and looters of many peoples, cheaters and liars in every life situation. They have designed something aggressive ground troops and less vessel types. Their ships are ebenbürdig those of other races. To sum Allorunderrasse a little more aggressive.
</div>

<div id="dropmsg4" class="dropcontent">
<br>The Dominion provides fast and powerful ships. The resources yield is extremely low. The construction of the building in comparison to other breeds is quite high.
</div>

<div id="dropmsg5" class="dropcontent">
<br>The Ferengi are the dealer race in Star Trek. They prefer the internal trading system, they can build the fastest transporter and very fast colony ships, the good yield and the resources enormously fast construction times of troops and buildings, all of this allows a Ferengi empire to expand faster than any other race. That shortcoming is the Ferengi very weak battle ships which is why they have their whole trade skill on the shopping ships should focus.
</div>

<div id="dropmsg6" class="dropcontent">
<br>Breen is a strong race with ships and troops. However, they are quite expensive. A (slightly) lower commodity thus could yield some economic problems. Another shortcoming of the rare Breen ship classes, but these are few ships not to be underestimated. The building construction period is relatively high.
</div>

<div id="dropmsg7" class="dropcontent">
<br>Hirogen is a very difficult race to play, so it is only experienced players. The advantage of the Hirogen is in the later game, as they struggle angfänglich boats missing, it is like until later. The Hirogen have excellent attacking values and the best defence assets in the ground battle.
</div>

<div id="dropmsg8" class="dropcontent">
<br>The average Krenim possess strong troops, their great advantages, the Krenim in the utilization of technology and research in the field is far ahead of other races, including the troops is minimal faster.
</div>

<div id="dropmsg9" class="dropcontent">
<br>The Kazon belong to the warrior races, which are primarily on the ground and concentrate fight there, in addition to the rapid production troops, their strengths. The Kazon smaller vessels are no serious threat to other races, only later draw the Kazon their full potential.
</div>

</td></tr>




        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><span class="sub_caption2">Personal information (optional)</span></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Birthday:</td>
          <td><input type="text" style="width: 30px;" name="user_birthday_day" maxlength="2" value="'.$data['user_birthday_day'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 30px;" name="user_birthday_month" maxlength="2" value="'.$data['user_birthday_month'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 50px;" name="user_birthday_year" maxlength="4" value="'.$data['user_birthday_year'].'"> (Day.Month.Year)</td>
        </tr>

        <tr height="5"><td></tr></tr>

        <tr>
          <td>Gender:</td>
          <td>
            <select name="user_gender">
              <option value="-"'.( ($gender_selected == '-') ? ' selected="selected"' : '' ).'>Undisclosed</option>
              <option value="m"'.( ($gender_selected == 'm') ? ' selected="selected"' : '' ).'>Male</option>
              <option value="f"'.( ($gender_selected == 'f') ? ' selected="selected"' : '' ).'>Female</option>
            </select>
          </td>
        </tr>
        <tr height="12"><td></td></tr>  
        <tr>
          <td>Zip ***:</td>
          <td><input style="width: 90px;" class="field" type="text" name="plz" value="'.$data['plz'].'"> </td>
        </tr>
        <tr>
          <td>Country:</td>
          <td>
          <select name="country">
              <option value="XX"'.( ($data['country'] == 'XX') ? ' selected="selected"' : '' ).'>Undisclosed</option>
              <option value="IT"'.( ($data['country'] == 'IT') ? ' selected="selected"' : '' ).'>Italy</option>
              <option value="UK"'.( ($data['country'] == 'UK') ? ' selected="selected"' : '' ).'>United Kingdom</option>
              <option value="US"'.( ($data['country'] == 'US') ? ' selected="selected"' : '' ).'>United States of America</option>
              <option value="DE"'.( ($data['country'] == 'DE') ? ' selected="selected"' : '' ).'>Deutschland</option>
              <option value="AT"'.( ($data['country'] == 'AT') ? ' selected="selected"' : '' ).'>&Ouml;sterreich</option>
              <option value="CH"'.( ($data['country'] == 'CH') ? ' selected="selected"' : '' ).'>Schweiz</option>
              <option value="FR"'.( ($data['country'] == 'FR') ? ' selected="selected"' : '' ).'>France</option>
          </select>
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><input style="border: none;" type="checkbox" name="confirm_agb" value="1"'.( ($agb_checked) ? ' checked="checked"' : '' ).'>&nbsp;I hereby declare that, read the <a href="agb.html" target=_blank><b>terms and conditions</b></a> and accepted them.<br>
          <br><b>It is 1 per account IP [<a href="javascript: void;" onmouseover="return overlib(\'This limitation means that every player who for more than 4 days after his registration with more than one account on its IP plays banned or deleted. <br> If it is due to a router, etc. Technically not possible, can the people by sending copies of ID card verification. <br> <u> To <b> Please click on the link!\', CAPTION, \'1 Account pro IP:\', WIDTH, 400, FGCOLOR, \'#ffffff\', TEXTCOLOR, \'#ffffff\', FGBACKGROUND,\'http://stfc.nonsolotaku.it/stfc_gfx/skin1/bg_stars1.gif\', BGCOLOR, \'#33355E\', BORDER, 2, CAPTIONFONT, \'Arial\', CAPTIONSIZE, 2, TEXTFONT, \'Arial\', TEXTSIZE, 2);" onmouseout="return nd();">Info</a>]<br><a href=index.php?a=multis><u>Full Description</u></a></b></td>          	
        </tr>

        <tr height="20"><td></td></tr>
        <tr>
          <td colspan="2">
             <input type=hidden name="submit" value="1">
             <input type=hidden name="galaxy" value="0">
             <input type="submit" name="submit_b" value="Registration">
             <br><br>
             <i>* The player name will appear in the game<br>** The login name will be exclusively used for the login<br>*** When entered, the Zip will appear in the <a href="http://stfc.nonsolotaku.it/index.php?a='.(($galaxy) ? 'fe' : 'be').'_karte" target=_blank><u>User card</u></a></i>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
</form>
   ';
}


$main_html = '<center><span class="caption">Registration</span></center><br>';
if (!isset($_REQUEST['galaxy']))
{
$config=$db->queryrow('SELECT * FROM config');
$playercount=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

$main_html.='<center>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="750" class="border_grey" style=" background-color:#000000; background-position:left;
  <tr>
    <td width="700">
<center><span class="sub_caption">(1/2) Pick your galaxy:</span><br>

<table border=0 cellpadding=2 cellspacing=2 style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
<td width="350">
<center><span class="sub_caption">Brown Bobby Galaxy (Speed)</span></center><br>
<a href="index.php?a=register&galaxy=0"><img src="gfx/ngc7742.jpg" border=0></a><br>
<u>Version:</u> STFC2<br>
<u>Runs:</u> ?? Days<br>
<u>Free seats:</u> '.($config['max_player']-$playercount['num']).'/'.$config['max_player'].'<br>
<u>Online players:</u> '.$player_online['num'].'<br><br>
Brown Bobby Galaxy corresponds to the code base of the current version of the CVS, but has a 3 minute tick.<br>
<a href=http://wiki.stgc.de/index.php?title=STFC2 target=_blank><u>Further information</u></a>
</td>

</tr>
</table>


</td></tr></table>';
}
else
{

$config=$db->queryrow('SELECT * FROM config');
$playercount=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

if ($config['register_blocked']) {display_registration(NULL,'Registration is currently not possible'); return true;}
else if ($config['max_player']<=$playercount['num']) {display_registration(NULL,'Registration is currently not possible<br>('.$playercount['num'].' of '.$config['max_player'].' Plätzen belegt)');return true;}
else
if(isset($_POST['submit'])) {
    if(empty($_POST['user_name'])) {
        display_registration($_POST, '(Player name not listed)');
        return true;
    }

    if(empty($_POST['login_name'])) {
        display_registration($_POST, '(Login name not given)');
        return true;
    }
    
    if(strstr($_POST['user_name'], ' ')) {
        display_registration($_POST, '(Player name contains a space)');
        return true;
    }
    
    for ($count=0; $count < strlen($_POST['user_name']); $count++) {
       $val=ord( (substr($_POST['user_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Player name contains illegal characters [only 0-9, a-z, A-Z])');
        return true;
       }
   }

    for ($count=0; $count < strlen($_POST['login_name']); $count++) {
       $val=ord( (substr($_POST['login_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Login name contains illegal characters [only 0-9, a-z, A-Z])');
        return true;
       }
   }


    if($_POST['user_name'] == $_POST['login_name']) {
        display_registration($_POST, '(Players name and login name matches)');
        return true;
    }


    if(empty($_POST['user_password'])) {
        display_registration($_POST, '(Password not specified)');
        return true;
    }

    if($_POST['user_password'] != $_POST['user_password2']) {
        display_registration($_POST, '(Passwords do not match)');
        return true;
    }

    if(empty($_POST['user_email'])) {
        display_registration($_POST, '(Email not specified)');
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_email = "'.$_POST['user_email'].'"';
    

    unset($user_exists);



    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Database error - Could not verify email');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(The email address is already used in this galaxy)');
        return true;
    }
    
    $sql = 'SELECT user_id
            FROM user
            WHERE user_loginname = "'.$_POST['login_name'].'"';
    

    unset($user_exists);


    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Database error - Could not verify login name');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(The login name is already used in this galaxy)');
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_name = "'.$_POST['user_name'].'"';
    unset($user_exists);

    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Database error - Could not verify user name');
    }
    
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(The user name is already used in this galaxy)');
        return true;
    }
    
    
    
    if(!in_array($_POST['user_race'], array(0, 1, 2, 3, 4, 5, 8, 9, 10, 11))) {
        display_registration($_POST, '(The race does not exist)');
        return true;
    }

    if(empty($_POST['confirm_agb'])) {
        display_registration($_POST, '(The terms were not accepted)');
        return true;
    }

    if( (!empty($_POST['user_birthday_day'])) && (!empty($_POST['user_birthday_month'])) && (!empty($_POST['user_birthday_year'])) ) {
        $day = abs((int)$_POST['user_birthday_day']);
        $month = abs((int)$_POST['user_birthday_month']);
        $year = abs((int)$_POST['user_birthday_year']);

        if($day > 31) {
            display_registration($_POST, '(The day of the birthdate is invalid)');
            return true;
        }

        if($month > 12) {
            display_registration($_POST, '(The month of the birthdate is invalid)');
            return true;
        }

        if(strlen($year) != 4) $year = 1900 + $year;

        if($year < 1904) {
            display_registration($_POST, '(The year of the birthdate is invalid)');
            return true;
        }

        if($year > 1999) {
            display_registration($_POST, '(The year of the birthdate is invalid)');
            return true;
        }

        $birthday_str = $day.'.'.$month.'.'.$year;
    }
    else {
        $birthday_str = '';
    }

    if(!in_array($_POST['user_gender'], array('-', 'm', 'f'))) {
        display_registration($_POST, '(What <b>are</b> you then?)');
        return true;
    }
    
    
	if ($_POST['country']!='DE' && $_POST['country']!='AT' && $_POST['country']!='CH' &&
		$_POST['country']!='IT' && $_POST['country']!='UK' && $_POST['country']!='US' &&
		$_POST['country']!='FR') $_POST['country']='XX';

	/* 13/03/08 - AC: Select user language */
	$lang = ''; // Default is english
	if($_POST['country']!='XX')
	{
		switch($_POST['country'])
		{
			case 'DE':
			case 'AT':
			case 'CH':
				$lang = 'GER';
			break;
			case 'UK':
			case 'US':
				$lang = 'ENG';
			break;
			case 'IT':
				$lang = 'ITA';
			break;
		}
	}

	$_POST['plz']=(int)$_POST['plz'];
	



        	$sql = 'SELECT skin_id, skin_html
            	FROM skins
            	ORDER BY skin_id ASC
	            LIMIT 0,1';

    	if(($skin_data = $db->queryrow($sql)) === false) {
	        die('Database error - Could not load skin data');
    	}

        $gfxpath='http://stfc.nonsolotaku.it/stfc_gfx/';

/*    	$sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country)
        	    VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'")';*/

    	$sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country, language)
        	    VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'", "'.$lang.'")';

    	if(!$db->query($sql)) {
	        die('Database error - Could not insert user data');
    	}
    	// Bietet größere Sicherheit bei hoher Last
    	$sql = 'SELECT user_id
            	FROM user
            	WHERE user_name = "'.$_POST['user_name'].'"';

    	if(($new_id = $db->queryrow($sql)) === false) {
	        die('Database error - Could not determine new user ID');
    	}

    	$user_id = (int)$new_id['user_id'];

    	$sql = 'INSERT INTO user_templates (user_id, user_template)
        	    VALUES ('.$user_id.', "'.addslashes($skin_data['skin_html']).'")';

    	if(!$db->query($sql)) {
	        die('Database error - Could not insert skin data');
    	}

    	$activation_key = md5( pow($user_id,2) );
    	$activation_link = 'http://stfc.nonsolotaku.it/index.php?a=activate&user_id='.$user_id.'&key='.$activation_key;
        define('EXT_NL', "\r\n");
		$mail_message = 'Congratulations '.$_POST['user_name'].','."\n".'Your registration with Star Trek: Frontline Combat II (Brown Bobby Galaxy) was successful!'."\n".'To activate your account, you need to click on the following link:'."\n".$activation_link."\n\n".'If you have not registered, simply ignore this mail.'."\n".'After 48 hours, your email address will be automatically removed from our databases.'."\n\n".'Live long and prosper,'."\n".'The STFC Team.'."\n\n".'Credits: http://stfc.nonsolotaku.it/index.php?a=imprint';
		send_mail("STFC2 Mailer","admin@nonsolotaku.it",$_POST['user_name'],$_REQUEST['user_email'],"Star Trek: Frontline Combat Registration",$mail_message);

       // Update NewRegister

       $sql = 'UPDATE config SET new_register = new_register + 1';

    	if(!$db->query($sql)) {
	        die('Database error - Could not update new_register');
    	}



    
    display_success();
    return true;

}

display_registration(NULL,'(There are '.$playercount['num'].' of '.$config['max_player'].' seats occupied)');

}

?>
