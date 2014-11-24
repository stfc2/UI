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




/*function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \"".$myname."\" <".$myemail.">\n";
  return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));
}*/







function display_success($galaxy,$bg) {
    global $main_html,$locale;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">'.$locale['registration_ok1'].' "'.$galaxy.'" '.$locale['registration_ok2'].'</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$bg.'\'); background-position:left; background-repeat:no-repeat;">
        <tr height="300">
          <td width="100%" valign=top><span class="sub_caption2"><br><br>'.$locale['registration_successfully'].'</span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>';
}


function display_registration($data = array(), $message = '', $galaxy) {
    global $main_html,$locale;

    /* 28/01/08 - AC: Added initialization of this fields */
    if(!isset($data['login_name'])) $data['login_name'] = '';
    if(!isset($data['plz'])) $data['plz'] = '';
    //if(!isset($galaxy)) $galaxy = 0;

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

    switch($galaxy)
    {
        case 0:
            $galaxyname = GALAXY1_NAME;
            $galaxyimg = GALAXY1_BG;
        break;
        case 1:
            $galaxyname = GALAXY2_NAME;
            $galaxyimg = GALAXY2_BG;
        break;
    }

    $main_html .= '
<form name="register" method="post" action="index.php?a=register" onSubmit="return this.submit_b.disabled = true;">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey">
  <tr>
    <td width="100%" align="center">
    <center><span class="sub_caption">'.$locale['galaxy_registration'].' "'.$galaxyname.'":</span><br>
    <span class="sub_caption2">'.$message.'</span></center>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$galaxyimg.'\'); background-position:left; background-repeat:no-repeat;">
        <tr>
          <td colspan="2"><span class="sub_caption2">'.$locale['player_info'].'</span></td>
        </tr>

        <tr><td height="10"></td></tr>

        <tr>
          <td width="15%">'.$locale['player_name'].' *</td>
          <td width="85%"><input style="width: 200px;" type="text" name="user_name" value="'.$data['user_name'].'"></td>
        </tr>

        <tr>
          <td width="15%">'.$locale['login'].' **</td>
          <td width="85%"><input style="width: 200px;" type="text" name="login_name" value="'.$data['login_name'].'"></td>
        </tr>

        <tr>
          <td>'.$locale['password'].'</td>
          <td><input style="width: 200px;" type="password" name="user_password" value="'.$data['user_password'].'"></td>
        </tr>

        <tr>
          <td>'.$locale['password_verify'].'</td>
          <td><input style="width: 200px;" type="password" name="user_password2" value="'.$data['user_password2'].'"></td>
        </tr>

        <tr>
          <td>'.$locale['email'].'</td>
          <td><input style="width: 200px;" type="text" name="user_email" value="'.$data['user_email'].'"></td>
        </tr>

        <tr><td height="10"></td></tr>

        <tr>
          <td>'.$locale['race_selection'].'</td>
          <td>
            <select style="width: 150px;" name="user_race" onChange="expandone();">';
    $races = $galaxy == 0 ? 12 : 5;
    for($race = 0; $race < $races;$race++)
    {
        // Skip Borg and Q
        if($race > 5 && $race < 8) continue;
        
        $main_html .= NL.'            <option value="'.$race.'"'.( ($race_selected == $race) ? ' selected="selected"' : '' ).'>'.$locale['race'.$race].'</option>';
    }       

    $main_html .= '
            </select>
        </td>
        </tr>

       <tr>
        <td align="center">&nbsp;</td>
        <td>';

    $dropnum = 0;
    for($race = 0; $race < $races;$race++)
    {
        // Skip Borg and Q
        if($race > 5 && $race < 8) continue;
        
        $main_html .= NL.'          <div id="dropmsg'.$dropnum.'" class="dropcontent"><br>'.$locale['race'.$race.'_desc'].NL.'          </div>';
        $dropnum++;
    }       

    $main_html .= '</td></tr>

        <tr><td height="20"></td></tr>

        <tr>
          <td colspan="2"><span class="sub_caption2">'.$locale['personal_info'].'</span></td>
        </tr>

        <tr><td height="10"></td></tr>

        <tr>
          <td>'.$locale['birthdate'].'</td>
          <td><input type="text" style="width: 30px;" name="user_birthday_day" maxlength="2" value="'.$data['user_birthday_day'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 30px;" name="user_birthday_month" maxlength="2" value="'.$data['user_birthday_month'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 50px;" name="user_birthday_year" maxlength="4" value="'.$data['user_birthday_year'].'"> ('.$locale['birthdate_format'].')</td>
        </tr>

        <tr><td height="5"></td></tr>

        <tr>
          <td>'.$locale['gender'].'</td>
          <td>
            <select name="user_gender">
              <option value="-"'.( ($gender_selected == '-') ? ' selected="selected"' : '' ).'>'.$locale['not_indicated'].'</option>
              <option value="m"'.( ($gender_selected == 'm') ? ' selected="selected"' : '' ).'>'.$locale['male'].'</option>
              <option value="f"'.( ($gender_selected == 'f') ? ' selected="selected"' : '' ).'>'.$locale['female'].'</option>
            </select>
          </td>
        </tr>
        <tr><td height="12"></td></tr>  
        <tr>
          <td>'.$locale['zipcode'].'</td>
          <td><input style="width: 90px;" class="field" type="text" name="plz" value="'.$data['plz'].'"> </td>
        </tr>
        <tr>
          <td>'.$locale['country'].'</td>
          <td>
          <select name="country">
              <option value="XX"'.( ($data['country'] == 'XX') ? ' selected="selected"' : '' ).'>'.$locale['not_indicated'].'</option>
              <option value="IT"'.( ($data['country'] == 'IT') ? ' selected="selected"' : '' ).'>'.$locale['country_it'].'</option>
              <option value="UK"'.( ($data['country'] == 'UK') ? ' selected="selected"' : '' ).'>'.$locale['country_en'].'</option>
              <option value="US"'.( ($data['country'] == 'US') ? ' selected="selected"' : '' ).'>'.$locale['country_us'].'</option>
              <option value="DE"'.( ($data['country'] == 'DE') ? ' selected="selected"' : '' ).'>'.$locale['country_de'].'</option>
              <option value="AT"'.( ($data['country'] == 'AT') ? ' selected="selected"' : '' ).'>'.$locale['country_at'].'</option>
              <option value="CH"'.( ($data['country'] == 'CH') ? ' selected="selected"' : '' ).'>'.$locale['country_ch'].'</option>
              <option value="FR"'.( ($data['country'] == 'FR') ? ' selected="selected"' : '' ).'>'.$locale['country_fr'].'</option>
          </select>
          </td>
        </tr>

        <tr><td height="20"></td></tr>

        <tr>
          <td colspan="2"><input style="border: none;" type="checkbox" name="confirm_agb" value="1"'.( ($agb_checked) ? ' checked="checked"' : '' ).'>&nbsp;'.$locale['term_of_use'].'<br>
          <br><b>'.$locale['no_multiaccount'].' [<a href="javascript: void;" onmouseover="return overlib(\''.$locale['multiaccount_desc'].'\', CAPTION, \''.$locale['no_multiaccount'].':\', WIDTH, 400, FGCOLOR, \'#ffffff\', TEXTCOLOR, \'#ffffff\', FGBACKGROUND,\'http://www.stfc.it/stfc_gfx/skin1/bg_stars1.gif\', BGCOLOR, \'#33355E\', BORDER, 2, CAPTIONFONT, \'Arial\', CAPTIONSIZE, 2, TEXTFONT, \'Arial\', TEXTSIZE, 2);" onmouseout="return nd();">Info</a>]<br><a href=index.php?a=multis&galaxy='.$galaxy.'><u>'.$locale['multiaccount_title'].'</u></a></b></td>
        </tr>

        <tr><td height="20"></td></tr>
        <tr>
          <td colspan="2">
             <input type=hidden name="submit" value="1">
             <input type=hidden name="galaxy" value="'.$galaxy.'">
             <input type="submit" name="submit_b" value="'.$locale['register'].'">
             <br><br>
             <i>'.$locale['stars_explanations'].'</i>
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

$title_html = $locale['register_title'];
$meta_descr = $locale['register_descr'];

if (!isset($_REQUEST['galaxy']))
{
/* First galaxy */
$config=$db->queryrow('SELECT * FROM config');
$playercount=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

/* Second galaxy */
$config2=$db2->queryrow('SELECT * FROM config');
$playercount2=$db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online2 = $db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));


$main_html.='
<div class="caption">'.$locale['registration'].'</div>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey">
  <tr>
    <td width="100%" align="center">
      <span class="sub_caption">'.$locale['galaxy_selection'].'</span><br>

      <table border=0 cellpadding=2 cellspacing=2>
        <tr>
          <td width="350" align="center">
            <span class="sub_caption">'.GALAXY1_NAME.'</span><br>
            <a href="index.php?a=register&galaxy=0"><img src="'.GALAXY1_IMG.'" border="0" alt="'.GALAXY1_NAME.'"></a><br>
            <u>'.$locale['version'].'</u> STFC2<br>
            <u>'.$locale['running_since'].'</u> '.round($config['tick_id']/480,0).' '.$locale['days'].'<br>
            <u>'.$locale['available_places'].'</u> '.($config['max_player']-$playercount['num']).'/'.$config['max_player'].'<br>
            <u>'.$locale['online_players'].'</u> '.$player_online['num'].'<br><br>
            '.$locale['galaxy1_desc'].'<br>
          </td>
          <td width="350" align="center">
            <span class="sub_caption">'.GALAXY2_NAME.'</span><br>
            <a href="index.php?a=register&galaxy=1"><img src="'.GALAXY2_IMG.'" border="0" alt="'.GALAXY2_NAME.'"></a><br>
            <u>'.$locale['version'].'</u> STFC2<br>
            <u>'.$locale['running_since'].'</u> '.round($config2['tick_id']/480,0).' '.$locale['days'].'<br>
            <u>'.$locale['available_places'].'</u> '.($config2['max_player']-$playercount2['num']).'/'.$config2['max_player'].'<br>
            <u>'.$locale['online_players'].'</u> '.$player_online2['num'].'<br><br>
            '.$locale['galaxy2_desc'].'<br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>';
}
else
{

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


$config=$mydb->queryrow('SELECT * FROM config');
$playercount=$mydb->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online = $mydb->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

if ($config['register_blocked']) {
    display_registration(NULL,$locale['registration_disabled'],$galaxy);
    return true;
}
else if ($config['max_player']<=$playercount['num']) {
    display_registration(NULL,$locale['registration_impossible'].'<br>('.$playercount['num'].' '.$locale['of'].' '.$config['max_player'].' '.$locale['occupied_places'].')',$galaxy);
    return true;
}
else
if(isset($_POST['submit'])) {
    //
    // Check validity of inserted data
    //
    if(empty($_POST['user_name'])) {
        display_registration($_POST, $locale['error_missing_name'],$galaxy);
        return true;
    }

    if(empty($_POST['login_name'])) {
        display_registration($_POST, $locale['error_missing_login'],$galaxy);
        return true;
    }

    if(strstr($_POST['user_name'], ' ')) {
        display_registration($_POST, $locale['error_blank_in_name'],$galaxy);
        return true;
    }

    for ($count=0; $count < strlen($_POST['user_name']); $count++) {
        $val=ord( (substr($_POST['user_name'], $count, 1)) );
        if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
        {
            display_registration($_POST, $locale['error_inv_char_in_name'],$galaxy);
            return true;
        }
    }

    for ($count=0; $count < strlen($_POST['login_name']); $count++) {
        $val=ord( (substr($_POST['login_name'], $count, 1)) );
        if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
        {
            display_registration($_POST, $locale['error_inv_char_in_login'],$galaxy);
            return true;
        }
    }

    if($_POST['user_name'] == $_POST['login_name']) {
        display_registration($_POST, $locale['error_matching_name_login'],$galaxy);
        return true;
    }

    if(empty($_POST['user_password'])) {
        display_registration($_POST, $locale['error_missing_password'],$galaxy);
        return true;
    }

    if($_POST['user_password'] != $_POST['user_password2']) {
        display_registration($_POST, $locale['error_mismatching_password'],$galaxy);
        return true;
    }

    if(empty($_POST['user_email'])) {
        display_registration($_POST, $locale['error_missing_email'],$galaxy);
        return true;
    }

    // Check email presence in the DB
    $sql = 'SELECT user_id
            FROM user
            WHERE user_email = "'.$_POST['user_email'].'"';

    unset($user_exists);

    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify email');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, $locale['error_existing_email'],$galaxy);
        return true;
    }


    // Check login presence in the DB
    $sql = 'SELECT user_id
            FROM user
            WHERE user_loginname = "'.$_POST['login_name'].'"';

    unset($user_exists);

    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify login name');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, $locale['error_existing_login'],$galaxy);
        return true;
    }


    // Check name presence in the DB
    $sql = 'SELECT user_id
            FROM user
            WHERE user_name = "'.$_POST['user_name'].'"';

    unset($user_exists);

    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify user name');
    }
    
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, $locale['error_existing_name'],$galaxy);
        return true;
    }



    if(!in_array($_POST['user_race'], array(0, 1, 2, 3, 4, 5, 8, 9, 10, 11))) {
        display_registration($_POST, $locale['error_invalid_race'],$galaxy);
        return true;
    }

    if(empty($_POST['confirm_agb'])) {
        display_registration($_POST, $locale['error_unaccepted_tou'],$galaxy);
        return true;
    }

    if( (!empty($_POST['user_birthday_day'])) && (!empty($_POST['user_birthday_month'])) && (!empty($_POST['user_birthday_year'])) ) {
        $day = abs((int)$_POST['user_birthday_day']);
        $month = abs((int)$_POST['user_birthday_month']);
        $year = abs((int)$_POST['user_birthday_year']);

        if($day > 31) {
            display_registration($_POST, $locale['error_invalid_birthday'],$galaxy);
            return true;
        }

        if($month > 12) {
            display_registration($_POST, $locale['error_invalid_birthmonth'],$galaxy);
            return true;
        }

        if(strlen($year) != 4) $year = 1900 + $year;

        if($year < 1904) {
            display_registration($_POST, $locale['error_invalid_birthyear'],$galaxy);
            return true;
        }

        if($year > 1999) {
            display_registration($_POST, $locale['error_invalid_birthyear'],$galaxy);
            return true;
        }

        $birthday_str = $day.'.'.$month.'.'.$year;
    }
    else {
        $birthday_str = '';
    }

    if(!in_array($_POST['user_gender'], array('-', 'm', 'f'))) {
        display_registration($_POST, $locale['error_invalid_gender'],$galaxy);
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



    //
    // Everything went fine, create the new user
    //
    $sql = 'SELECT skin_id, skin_html
            FROM skins
            ORDER BY skin_id ASC
            LIMIT 0,1';

    if(($skin_data = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not load skin data');
    }

    $gfxpath=DEFAULT_GFX_PATH;

    $sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country, language,user_signature, user_notepad, user_message_sig, user_options, message_basement)
            VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'", "'.$lang.'","","","","","")';

    if(!$mydb->query($sql)) {
        die('Database error - Could not insert user data');
    }

    // Provides greater safety at high load
    $sql = 'SELECT user_id
            FROM user
            WHERE user_name = "'.$_POST['user_name'].'"';

    if(($new_id = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not determine new user ID');
    }

    $user_id = (int)$new_id['user_id'];

    $sql = 'INSERT INTO user_templates (user_id, user_template)
            VALUES ('.$user_id.', "'.addslashes($skin_data['skin_html']).'")';

    if(!$mydb->query($sql)) {
        die('Database error - Could not insert skin data');
    }

    $activation_key = md5( pow($user_id,2) );
    $activation_link = 'http://www.stfc.it/index.php?a=activate&galaxy='.$galaxy.'&user_id='.$user_id.'&key='.$activation_key;
    $mail_message  = $locale['mail_message_congrats'].' '.$_POST['user_name'].'!'.NL;
    $mail_message .= $locale['mail_message_reg1a'].' '.$galaxyname.' '.$locale['mail_message_reg1b'].NL;
    $mail_message .= $locale['mail_message_reg2'].NL.$activation_link."\n\n".$locale['mail_message_reg3'].NL;
    $mail_message .= $locale['mail_message_reg4'].NL.NL.$locale['mail_message_sig_line1'].NL;
    $mail_message .= $locale['mail_message_sig_line2'].NL.NL.'Credits: http://www.stfc.it/index.php?a=imprint';
    send_mail("STFC2 Mailer","admin@stfc.it",$_POST['user_name'],$_REQUEST['user_email'],$locale['mail_subject_reg'],$mail_message);

    // Update NewRegister

    $sql = 'UPDATE config SET new_register = new_register + 1';

    if(!$mydb->query($sql)) {
        die('Database error - Could not update new_register');
    }


    display_success($galaxyname,$galaxyimg);
    return true;

}

display_registration(NULL,'('.$locale['there_are'].' '.$playercount['num'].' '.$locale['on'].' '.$config['max_player'].' '.$locale['occupied_places'].')',$galaxy);

}

?>
