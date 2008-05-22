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
    <center><span class="sub_caption">Anmeldung für "Brown Bobby Galaxie" erfolgreich:</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/ngc7742bg.jpg\'); background-position:left; background-repeat:no-repeat;">
        <tr height="300">
          <td width="100%" valign=top><span class="sub_caption2"><br><br>Die Registrierung war erfolgreich!<br><br>Eine Email wurde an deine Adresse 
gesandt, mit der du deinen Account aktivieren kannst.<br><b>Die Mail wird vermutlich im Spamordner landen, bitte dort 
nachsehen.</span></td>
        </tr>
	</table>
	</td>
	</tr>
	</table>';
}
	

function display_registration($data = array(), $message = '') {
    global $main_html;

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
    
    if(!isset($data['country'])) $data['country'] = 'XX';
    if ($data['country']!='DE' && $data['country']!='AT' && $data['country']!='CH') $data['country']='XX';
    

    $main_html .= '
<form name="register" method="post" action="index.php?a=register" onSubmit="return this.submit_b.disabled = true;">
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">(2/2) Anmeldung "Brown Bobby Galaxie":</span></center>
    <center><span class="sub_caption2">'.$message.'</span></center><center>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/ngc7742bg.jpg\'); background-position:left; background-repeat:no-repeat;">
        <tr>
          <td colspan="2"><span class="sub_caption2">Spiel-Informationen (benötigt)</span></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td width="15%">Spielername *:</td>
          <td width="85%"><input style="width: 200px;" type="text" name="user_name" value="'.$data['user_name'].'"></td>
        </tr>

        <tr>
          <td width="15%">Loginname **:</td>
          <td width="85%"><input style="width: 200px;" type="text" name="login_name" value="'.$data['login_name'].'"></td>
        </tr>

        <tr>
          <td>Passwort:</td>
          <td><input style="width: 200px;" type="password" name="user_password" value="'.$data['user_password'].'"></td>
        </tr>

        <tr>
          <td>Wdh. Passwort:</td>
          <td><input style="width: 200px;" type="password" name="user_password2" value="'.$data['user_password2'].'"></td>
        </tr>

        <tr>
          <td>Email:</td>
          <td><input style="width: 200px;" type="text" name="user_email" value="'.$data['user_email'].'"></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Rasse:</td>
          <td>
            <select style="width: 150px;" name="user_race" onChange="expandone();">
              <option value="0"'.( ($race_selected == 0) ? ' selected="selected"' : '' ).'>Föderation</option>
              <option value="1"'.( ($race_selected == 1) ? ' selected="selected"' : '' ).'>Romulaner</option>
              <option value="2"'.( ($race_selected == 2) ? ' selected="selected"' : '' ).'>Klingonen</option>
              <option value="3"'.( ($race_selected == 3) ? ' selected="selected"' : '' ).'>Cardassianer</option>
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
<br>Die Föderation. Es wird dem Spieler die größtmögliche Auswahl an verschiedenen Schiffstypen angeboten. Schiffe der Föderation besitzen die stärksten Schilde der Galaxy. Die Resföderungsmengen sind Durchschnitt, ebensowie die Truppen. Im Vergleich zu anderen Rassen besitzt die Föderation über gute Forschungswerte.
</div>

<div id="dropmsg1" class="dropcontent">
<br>Die Romulaner haben ihre Stärken im schnellen und günstigen Bau von Schiffen und Einheiten, jedoch macht die geringe Latinumausbeute und die Vergleichsweise schwachen Truppen ziemlich zu schaffen. Sie verfügen über Schiffe mit starker Tarnfähigkeit.
</div>

<div id="dropmsg2" class="dropcontent">
<br>Die Klingonen sind eine kriegerische Rasse mit großen Boni im Schiffs- und Einheitenkampf. Als Malus sind die Bauzeiten von Truppen und Gebäuden extrem hoch. Desweiteren ist Forschung kein günstiges Verngügen als Klingone. 
</div>

<div id="dropmsg3" class="dropcontent">
<br>Die Cardassianer, die Unterdrücker und Plünderer zahlreicher Völker, Betrüger und Lügner in jeder Lebenssituation. Sie besitzen etwas aggressiver ausgelegte Bodentruppen und jedoch weniger Schiffstypen. Ihre Schiffe sind denen anderer Rassen ebenbürdig. Zusammenfassend gesagt eine etwas aggressivere Allorunderrasse.
</div>

<div id="dropmsg4" class="dropcontent">
<br>Das Dominion bietet schnelle und starke Schiffe. Die Ressourcen Ausbeute ist äußerst gering. Die Bauzeit der Gebäude im Vergleich zu anderen Rassen recht hoch.
</div>

<div id="dropmsg5" class="dropcontent">
<br>Die Ferengi sind die Händlerrasse in Star Trek. Im internen Handelssystem werden sie bevorzugt, sie bauen die schnellsten Transporter und sehr schnelle Kolonieschiffe, die gute Ressourcenausbeute und die enorm schnellen Bauzeiten von Truppen und Gebäuden, all das ermöglicht es einem Ferengi sein Imperium schneller auszuweiten als jeder anderen Rasse. Das Manko ist das Ferengi nur sehr schwache Kampfschiffe haben weshalb sie ihr ganzen Handelsgeschick auf das Einkaufen von Schiffen fokusieren sollten. 
</div>

<div id="dropmsg6" class="dropcontent">
<br>Die Breen sind eine Rasse mit starken Schiffen und Truppen. Allerdings sind diese recht teuer. Eine (etwas) geringere Rohstoffausbeute könnte somit zu gewissen wirtschaftlichen Problemen führen. Ein weiteres Manko der Breen sind die wenigen Schiffsklassen, jedoch sind diese wenigen Schiffe nicht zu unterschätzen. Die Gebäudebauzeit ist jedoch relativ hoch.
</div>

<div id="dropmsg7" class="dropcontent">
<br>Hirogen ist eine sehr schwer zu spielende Rasse, deswegen wird sie nur erfahrenen Spielern empfohlen. Der Vorteil der Hirogen liegt im späteren Spielverlauf, da ihnen angfänglich Kampfschiffe fehlen, dies gleicht sich erst später aus. Die Hirogen verfügen über hervoragende Angriffswerte und die besten Verteidigungswerte im Bodenkampf. 
</div>

<div id="dropmsg8" class="dropcontent">
<br>Die Krenim besitzen durchschnittlich starke Truppen, ihre großen Vorteile haben die Krenim in der Ausnutzung von Technologie und sind im Forschungsbereich anderen Rassen weit voraus, auch der Truppenbau ist minimal schneller.
</div>

<div id="dropmsg9" class="dropcontent">
<br>Die Kazon gehören zu den Kriegerrassen, die sich primär auf den Bodenkampf konzentrieren und dort, neben der schnellen Truppenproduktion, ihre Stärken besitzen. Die kleineren Kazon Schiffe sind keine ernste Bedrohung für andere Rassen, erst später schöpfen die Kazon ihr gesamtes Potential aus. 
</div>

</td></tr>




        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><span class="sub_caption2">persönliche Informationen (optional)</span>
</td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Geburtstag:</td>
          <td><input type="text" style="width: 30px;" name="user_birthday_day" maxlength="2" value="'.$data['user_birthday_day'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 30px;" name="user_birthday_month" maxlength="2" value="'.$data['user_birthday_month'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 50px;" name="user_birthday_year" maxlength="4" value="'.$data['user_birthday_year'].'"> (Tag.Monat.Jahr)</td>
        </tr>

        <tr height="5"><td></tr></tr>

        <tr>
          <td>Geschlecht:</td>
          <td>
            <select name="user_gender">
              <option value="-"'.( ($gender_selected == '-') ? ' selected="selected"' : '' ).'>keine Angabe</option>
              <option value="m"'.( ($gender_selected == 'm') ? ' selected="selected"' : '' ).'>männlich</option>
              <option value="f"'.( ($gender_selected == 'f') ? ' selected="selected"' : '' ).'>weiblich</option>
            </select>
          </td>
	  </tr>
	        <tr height="12"><td></td></tr>  
	  <tr>
          <td>PLZ ***:</td>
          <td><input style="width: 90px;" class="field" type="text" name="plz" value="'.$data['plz'].'"> </td>
        </tr>
        <tr>
          <td>Land:</td>
          <td>
          <select name="country">
              <option value="XX"'.( ($data['country'] == 'XX') ? ' selected="selected"' : '' ).'>Keine Angabe</option>
              <option value="DE"'.( ($data['country'] == 'DE') ? ' selected="selected"' : '' ).'>Deutschland</option>
              <option value="AT"'.( ($data['country'] == 'AT') ? ' selected="selected"' : '' ).'>Österreich</option>
              <option value="CH"'.( ($data['country'] == 'CH') ? ' selected="selected"' : '' ).'>Schweiz</option>
          </select>
        	</td>
		</tr>
	  
        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><input style="border: none;" type="checkbox" name="confirm_agb" value="1"'.( ($agb_checked) ? ' checked="checked"' : '' ).'>&nbsp;Ich erkläre hiermit, die <a href="agb.html" target=_blank><b>AGB</b></a> gelesen und akzeptiert zu haben.<br>
          <br><b>Es gilt 1 Account pro IP [<a href="javascript: void;" onmouseover="return overlib(\'Diese Einschränkung bedeutet, dass jeder Spieler, der länger als 4 Tage nach seiner Registrierung mit mehr als einem Account auf seiner IP spielt, gebannt bzw. gelöscht wird.<br>Wenn es aufgrund eines Routers o.ä. technisch nicht möglich ist, können die Personen durch Einsendung von Personalausweiskopien verifiziert werden.<br><u><b>Bitte dazu auf den Link klicken!\', CAPTION, \'1 Account pro IP:\', WIDTH, 400, FGCOLOR, \'#ffffff\', TEXTCOLOR, \'#ffffff\', FGBACKGROUND,\'|game_url|/stgc4_gfx/skin1/bg_stars1.gif\', BGCOLOR, \'#33355E\', BORDER, 2, CAPTIONFONT, \'Arial\', CAPTIONSIZE, 2, TEXTFONT, \'Arial\', TEXTSIZE, 2);" onmouseout="return nd();">Info</a>]<br><a href=index.php?a=multis><u>Komplette Beschreibung</u></a></b></td>          	
        </tr>

        <tr height="20"><td></td></tr>
	<tr>
          <td colspan="2">
	<input type=hidden name="submit" value="1">
	<input type=hidden name="galaxy" value="0">
	<input type="submit" name="submit_b" value="Registrierung abschließen">
	<br><br>
	<i>* Der Spielername erscheint im Spiel<br>** Der Loginname wird ausschließlich für den Login verwendet<br>*** Bei Angabe der PLZ erscheinst du in der <a href="|game_url|/index.php?a='.(($galaxy) ? 'fe' : 'be').'_karte" target=_blank><u>Userkarte</u></a></i>
	</td>
	</tr>

      </table>
    </td>
  </tr>
</table>
<br>

   ';
}


$main_html = '<center><span class="caption">Anmeldung</span></center><br>';
if (!isset($_REQUEST['galaxy']))
{
$config=$db->queryrow('SELECT * FROM config');
$playercount=$db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1 AND user_active>0');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

$main_html.='<center>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="750" class="border_grey" style=" background-color:#000000; background-position:left;
  <tr>
    <td width="700">
<center><span class="sub_caption">(1/2) Wähle deine Galaxie:</span><br>

<table border=0 cellpadding=2 cellspacing=2 style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
<td width="350">
<center><span class="sub_caption">Brown Bobby Galaxy (Speed)</span></center><br>
<a href="index.php?a=register&galaxy=0"><img src="gfx/ngc7742.jpg" border=0></a><br>
<u>Version:</u> STFC2<br>
<u>Läuft seit:</u> ?? Tagen<br>
<u>Freie Pl&auml;tze:</u> '.($config['max_player']-$playercount['num']).'/'.$config['max_player'].'<br>
<u>Spieler online:</u> '.$player_online['num'].'<br><br>
Die Brown Bobby Galaxie entspricht von der Codebasis der aktuellen Version des CVS, hat aber einen 3 Minuten Tick.<br>
<a href=http://wiki.stgc.de/index.php?title=STFC2 target=_blank><u>Weitere Informationen</u></a>
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

if ($config['register_blocked']) {display_registration(NULL,'Eine Anmeldung ist momentan leider nicht möglich'); return true;}
else if ($config['max_player']<=$playercount['num']) {display_registration(NULL,'Eine Anmeldung ist momentan leider nicht möglich<br>('.$playercount['num'].' von '.$config['max_player'].' Plätzen belegt)');return true;}
else
if(isset($_POST['submit'])) {
    if(empty($_POST['user_name'])) {
        display_registration($_POST, '(Spielername nicht angegeben)');
        return true;
    }

    if(empty($_POST['login_name'])) {
        display_registration($_POST, '(Loginname nicht angegeben)');
        return true;
    }
    
    if(strstr($_POST['user_name'], ' ')) {
        display_registration($_POST, '(Spielername enthält ein Leerzeichen)');
        return true;
    }
    
    for ($count=0; $count < strlen($_POST['user_name']); $count++) {
       $val=ord( (substr($_POST['user_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Spielername enthält unzulässige Zeichen [nur 0-9,a-z,A-Z])');
        return true;
       }
   }

    for ($count=0; $count < strlen($_POST['login_name']); $count++) {
       $val=ord( (substr($_POST['login_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Loginname enthält unzulässige Zeichen [nur 0-9,a-z,A-Z])');
        return true;
       }
   }


    if($_POST['user_name'] == $_POST['login_name']) {
        display_registration($_POST, '(Spielername und Loginname stimmen überein)');
        return true;
    }


    if(empty($_POST['user_password'])) {
        display_registration($_POST, '(Passwort nicht angegeben)');
        return true;
    }

    if($_POST['user_password'] != $_POST['user_password2']) {
        display_registration($_POST, '(Passwörter stimmen nicht überein)');
        return true;
    }

    if(empty($_POST['user_email'])) {
        display_registration($_POST, '(Email nicht angegeben)');
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_email = "'.$_POST['user_email'].'"';
    

    unset($user_exists);



    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Datenbankfehler aufgetreten - Konnte Email nicht überprüfen');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(Die Email-Adresse wird in dieser Galaxie bereits genutzt)');
        return true;
    }
    
    $sql = 'SELECT user_id
            FROM user
            WHERE user_loginname = "'.$_POST['login_name'].'"';
    

    unset($user_exists);


    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Datenbankfehler aufgetreten - Konnte Email nicht überprüfen');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(Der Loginname wird in dieser Galaxie bereits genutzt)');
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_name = "'.$_POST['user_name'].'"';
    unset($user_exists);

    if(($user_exists = $db->queryrow($sql)) === false) {
        die('Datenbankfehler aufgetreten - Konnte Namen nicht überprüfen');
    }
    
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(Der Username wird in dieser Galaxie bereits genutzt)');
        return true;
    }
    
    
    
    if(!in_array($_POST['user_race'], array(0, 1, 2, 3, 4, 5, 8, 9, 10, 11))) {
        display_registration($_POST, '(Diese Rasse gibt es nicht)');
        return true;
    }

    if(empty($_POST['confirm_agb'])) {
        display_registration($_POST, '(Die AGB wurden nicht akzeptiert)');
        return true;
    }

    if( (!empty($_POST['user_birthday_day'])) && (!empty($_POST['user_birthday_month'])) && (!empty($_POST['user_birthday_year'])) ) {
        $day = abs((int)$_POST['user_birthday_day']);
        $month = abs((int)$_POST['user_birthday_month']);
        $year = abs((int)$_POST['user_birthday_year']);

        if($day > 31) {
            display_registration($_POST, '(Der Tag des Geburtsdatum ist ungültig)');
            return true;
        }

        if($month > 12) {
            display_registration($_POST, '(Der Monat des Geburtsdatum ist ungültig)');
            return true;
        }

        if(strlen($year) != 4) $year = 1900 + $year;

        if($year < 1904) {
            display_registration($_POST, '(Das Jahr des Geburtsdatum ist zu niedrig)');
            return true;
        }

        if($year > 1999) {
            display_registration($_POST, '(Das Jahr des Geburtsdatum ist zu hoch)');
            return true;
        }

        $birthday_str = $day.'.'.$month.'.'.$year;
    }
    else {
        $birthday_str = '';
    }

    if(!in_array($_POST['user_gender'], array('-', 'm', 'f'))) {
        display_registration($_POST, '(Was bist <b>du</b> denn?)');
        return true;
    }
    
    
	if ($_POST['country']!='DE' && $_POST['country']!='AT' && $_POST['country']!='CH') $_POST['country']='XX';
	$_POST['plz']=(int)$_POST['plz'];
	



        	$sql = 'SELECT skin_id, skin_html
            	FROM skins
            	ORDER BY skin_id ASC
	            LIMIT 0,1';

    	if(($skin_data = $db->queryrow($sql)) === false) {
	        die('Datenbankfehler aufgetreten - Konnte Skin-Daten nicht laden');
    	}

        $gfxpath='http://|game_url|/stgc5_gfx/';

    	$sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country)
        	    VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'")';

    	if(!$db->query($sql)) {
	        die('Datenbankfehler aufgetreten - Konnte Benutzerdaten nicht einfügen');
    	}
    	// Bietet größere Sicherheit bei hoher Last
    	$sql = 'SELECT user_id
            	FROM user
            	WHERE user_name = "'.$_POST['user_name'].'"';

    	if(($new_id = $db->queryrow($sql)) === false) {
	        die('Datenbankfehler aufgetreten - Konnte neue Benutzer-ID nicht bestimmen');
    	}

    	$user_id = (int)$new_id['user_id'];

    	$sql = 'INSERT INTO user_templates (user_id, user_template)
        	    VALUES ('.$user_id.', "'.addslashes($skin_data['skin_html']).'")';

    	if(!$db->query($sql)) {
	        die('Datenbankfehler aufgetreten - Konnte Skin-Daten nicht einfügen');
    	}

    	$activation_key = md5( pow($user_id,2) );
    	$activation_link = '|game_url|/index.php?a=activate&user_id='.$user_id.'&key='.$activation_key;
        define('EXT_NL', "\r\n");
		$mail_message = 'Herzlichen Glueckwunsch '.$_POST['user_name'].','."\n".'Deine Registrierung bei Star Trek: Frontline Combat II (Brown Bobby-Galaxie) war erfolgreich!'."\n".'Um Deinen Account zu aktivieren, musst Du auf den folgenden Link klicken:'."\n".$activation_link."\n\n".'Falls Du dich nicht registiert hast, beachte diese Mail einfach nicht.'."\n".'Nach 48 Stunden wird Deine Emailadresse dann automatisch aus unseren Datenbanken entfernt.'."\n\n".'Lebe lang und erfolgreich,'."\n".'Dein STGC Team.'."\n\n".'Impressum: |game_url|/index.php?a=imprint';
		send_mail("STFC2 Mailer","info@stgc.de",$_POST['user_name'],$_REQUEST['user_email'],"Star Trek: Frontline Combat Anmeldung",$mail_message);
	
       // Update NewRegister
	
       $sql = 'UPDATE config SET new_register = new_register + 1';

    	if(!$db->query($sql)) {
	        die('Datenbankfehler aufgetreten - Konnte New_Register nicht updaten');
    	}



    
    display_success();
    return true;

}

display_registration(NULL,'(Es sind '.$playercount['num'].' von '.$config['max_player'].' Plätzen belegt)');

}

?>
