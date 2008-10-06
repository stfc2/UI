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







function display_success($galaxy,$bg) {
    global $main_html;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">Registrazione per la galassia "'.$galaxy.'" avvenuta con successo:</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$bg.'\'); background-position:left; background-repeat:no-repeat;">
        <tr height="300">
          <td width="100%" valign=top><span class="sub_caption2"><br><br>La tua registrazione ha avuto successo!<br><br>Una email &egrave; stata inviata al tuo indirizzo,
          con la quale potrai attivare il tuo account. <br> <b> Il messaggio potrebbe venire marcato come spam, ti preghiamo di verificare in caso di ritardo.</span></td>
        </tr>
	</table>
	</td>
	</tr>
	</table>';
}


function display_registration($data = array(), $message = '', $galaxy) {
    global $main_html;

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
<table align="center" border="0" cellpadding="2" cellspacing="2" width="700" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
    <center><span class="sub_caption">(2/2) Registrazione per la galassia "'.$galaxyname.'":</span></center>
    <center><span class="sub_caption2">'.$message.'</span></center><center>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$galaxyimg.'\'); background-position:left; background-repeat:no-repeat;">
        <tr>
          <td colspan="2"><span class="sub_caption2">Informazioni di gioco (necessarie)</span></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td width="15%">Nome giocatore *:</td>
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
          <td>Verifica Password:</td>
          <td><input style="width: 200px;" type="password" name="user_password2" value="'.$data['user_password2'].'"></td>
        </tr>

        <tr>
          <td>Email:</td>
          <td><input style="width: 200px;" type="text" name="user_email" value="'.$data['user_email'].'"></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Scelta della razza:</td>
          <td>
            <select style="width: 150px;" name="user_race" onChange="expandone();">
              <option value="0"'.( ($race_selected == 0) ? ' selected="selected"' : '' ).'>Federazione</option>
              <option value="1"'.( ($race_selected == 1) ? ' selected="selected"' : '' ).'>Romulani</option>
              <option value="2"'.( ($race_selected == 2) ? ' selected="selected"' : '' ).'>Klingon</option>
              <option value="3"'.( ($race_selected == 3) ? ' selected="selected"' : '' ).'>Cardassiani</option>
              <option value="4"'.( ($race_selected == 4) ? ' selected="selected"' : '' ).'>Dominio</option>';

    switch($galaxy)
    {
        case 0:
            $main_html .= '
              <option value="5"'.( ($race_selected == 5) ? ' selected="selected"' : '' ).'>Ferengi</option>
              <option value="8"'.( ($race_selected == 8) ? ' selected="selected"' : '' ).'>Breen</option>
              <option value="9"'.( ($race_selected == 9) ? ' selected="selected"' : '' ).'>Hirogeni</option>
              <option value="10"'.( ($race_selected == 10) ? ' selected="selected"' : '' ).'>Krenim</option>
              <option value="11"'.( ($race_selected == 11) ? ' selected="selected"' : '' ).'>Kazon</option>';
        break;
    }

    $main_html .= '
            </select>
        </td>
        </tr>

       <tr>
        <td align="center">&nbsp;

        </td>
        <td>

<div id="dropmsg0" class="dropcontent">
<br>Federazione. Questa &egrave; la razza con la maggiore variet&agrave; di navi. Le navi della Federazione hanno gli scudi pi&ugrave; resistenti tra tutte le navi della Galassia. Il tasso di produzione delle risorse &egrave; nella media, cosi come quello delle truppe. In paragone alle altre specie, la Federazione gode di buoni strumenti di ricerca tecnologica.<br>I giocatori di questa specie partono con pari probabilit&agrave; dal Quadrante Alfa, Beta e Gamma, difficilmente dal Delta.<br>
<i>Consigliata ai giocatori alle prime armi.</i>
</div>

<div id="dropmsg1" class="dropcontent">
<br>I Romulani hanno un punto di forza nel poter costruire navi e fanti velocemente e a basso costo. Hanno un tasso di produzione di dilitio bassissimo e dispongono di vascelli e soldati relativamente deboli. Tuttavia, le navi Romulane dispongono di un ottima capacità di occultamento.<br>I giocatori di questa specie partono con maggior probabilit&agrave; dal Quadrante Beta piuttosto che dal Gamma ed Alfa.<br>
<i>Consigliata ai giocatori alle prime armi.</i>
</div>

<div id="dropmsg2" class="dropcontent">
<br>I Klingon sono una razza guerriera con ottime navi e soldati. Tuttavia sono penalizzati da tempi di costruzione per le truppe e per le strutture planetarie molto alti. Inoltre, la ricerca tecnologica non rappresenta un punto a favore dei Klingon.<br>I giocatori di questa razza partono con buone probabilit&agrave; dal Quadrante Alfa, in misura minore dal Beta e Gamma.<br>
<i>Consigliata ai giocatori alle prime armi.</i>
</div>

<div id="dropmsg3" class="dropcontent">
<br>I Cardassiani, gli oppressori e sfruttatori di tanti popoli, sleali e falsi in ogni situazione. Possiedono soldati aggressivi ma non dispongono di una grande variet&agrave; di navi. Le loro navi sono piuttosto deboli in rapporto a quelle delle altre razze. Tra tutte, &egrave; la razza pi&ugrave; aggressiva.<br>I giocatori di questa razza iniziano a giocare con maggior probabilit&agrave; dal quadrante Alfa e Gamma.<br>
<i>I Cardassiani necessitano di buona applicazione ed aggressivit&agrave; per essere giocati con successo.</i>
</div>

<div id="dropmsg4" class="dropcontent">
<br>Il Dominio dispone di navi veloci e potenti. La loro capacit&agrave; estrattiva &egrave; la pi&ugrave; bassa tra tutte le razze. I tempi di costruzione delle strutture planetarie, in paragone alle altre specie, &egrave; piuttosto alto.<br>I giocatori di questa razza partono principalmente dal Quadrante Gamma.<br>
<i>Una delle razze pi&ugrave; dure da giocare, decisamente sconsigliata ai giocatori alle prime armi.</i>
</div>

<div id="dropmsg5" class="dropcontent">
<br>I Ferengi sono la razza commerciante per eccellenza in Star Trek. Preferiscono fare commercio, dispongono dei trasporti pi&ugrave; veloci e navi colonia molto rapide, hanno il miglior tasso di estrazione di risorse e sono velocissimi nel costruire truppe e strutture planetarie, tutto questo permette al Ferengi di espandersi pi&ugrave; velocemente di qualsiasi altra razza. La loro debolezza consiste nelle loro scadenti navi da battaglia, motivo per cui il giocatore dovrebbe concentrare tutta la sua capacit&agrave; affaristica nel comprare navi alle aste.<br>I giocatori di questa razza hanno pari possibilità di parte da un qualsiasi dei quattro quadranti.<br>
<i>Una razza estremamente facile da giocare in termini di gestione. Occorre senso per gli affari per sfruttare a fondo i Ferengi.</i>
</div>

<div id="dropmsg6" class="dropcontent">
<br>I Breen sono una specie molto forte, con navi e soldati potenti ma piuttosto costosi. Il loro tasso di estrazione risorse &egrave; piuttosto basso e questo pu&ograve; portare a qualche problema economico. Dispongono anche della minor variet&agrave; di navi a disposizione, tuttavia le poche esistenti non vanno assolutamente sottovalutate. Il tempo di costruzione delle strutture planetarie &egrave; relativamente alto.<br>I giocatori di questa razza partono con prevalenza dal Quadrante Gamma.<br>
<i>Una razza piuttosto difficile da giocare e con poca varietà di navi. Indicata per i giocatori con molto senso pratico.</i>
</div>

<div id="dropmsg7" class="dropcontent">
<br>Gli Hirogeni sono una razza molto difficile da giocare. Il loro vantaggio arriva a gioco avanzato, ma devono lottare con la poca variet&agrave; di navi. Gli Hirogeni dispongono di eccellenti truppe di terra con la migliore capacit&agrave; difensiva delle proprie strutture.<br>I giocatori di questa razza possono iniziare con pari probabilit&agrave; da qualsiasi quadrante della galassia.<br>
<i>Razza complessa da giocare, indicata per i pi&ugrave; esperti o per chi vuole affrontare la sfida pi&ugrave; difficile.</i>
</div>

<div id="dropmsg8" class="dropcontent">
<br>I Krenim non possiedono truppe particolarmente forti ma hanno come enorme vantaggio lo sfruttamento della tecnologia. Nel campo della ricerca tecnologica i Krenim sono al di sopra di tutte le altre razze e anche la creazione delle truppe &egrave; piuttosto rapida.<br>I giocatori di questa razza iniziano principalmente dal Quadrante Delta.<br>
<i>Razza semplice da giocare ma non semplicissima. Una sfida di livello medio.</i>
</div>

<div id="dropmsg9" class="dropcontent">
<br>I Kazon appartengono alle razze guerriere, specialmente sul campo di battaglia a terra. Sono molto rapidi nel produrre truppe, il loro punto di forza. Le navi Kazon pi&ugrave; piccole non sono una minaccia per le altre razze, solo successivamente giungono al loro pieno potenziale.<br>I giocatori di questa razza iniziano principalmente dal Quadrante Delta.<br>
<i>Consigliata ai giocatori di livello medio.</i>
</div>

</td></tr>




        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><span class="sub_caption2">Informazioni personali (opzionali)</span></td>
        </tr>

        <tr height="10"><td></td></tr>

        <tr>
          <td>Data di nascita:</td>
          <td><input type="text" style="width: 30px;" name="user_birthday_day" maxlength="2" value="'.$data['user_birthday_day'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 30px;" name="user_birthday_month" maxlength="2" value="'.$data['user_birthday_month'].'">&nbsp;.&nbsp;<input type="text" class="field" style="width: 50px;" name="user_birthday_year" maxlength="4" value="'.$data['user_birthday_year'].'"> (Giorno.Mese.Anno)</td>
        </tr>

        <tr height="5"><td></tr></tr>

        <tr>
          <td>Sesso:</td>
          <td>
            <select name="user_gender">
              <option value="-"'.( ($gender_selected == '-') ? ' selected="selected"' : '' ).'>Non indicato</option>
              <option value="m"'.( ($gender_selected == 'm') ? ' selected="selected"' : '' ).'>Maschio</option>
              <option value="f"'.( ($gender_selected == 'f') ? ' selected="selected"' : '' ).'>Femmina</option>
            </select>
          </td>
        </tr>
        <tr height="12"><td></td></tr>  
        <tr>
          <td>Cap ***:</td>
          <td><input style="width: 90px;" class="field" type="text" name="plz" value="'.$data['plz'].'"> </td>
        </tr>
        <tr>
          <td>Paese:</td>
          <td>
          <select name="country">
              <option value="XX"'.( ($data['country'] == 'XX') ? ' selected="selected"' : '' ).'>Non indicato</option>
              <option value="IT"'.( ($data['country'] == 'IT') ? ' selected="selected"' : '' ).'>Italia</option>
              <option value="UK"'.( ($data['country'] == 'UK') ? ' selected="selected"' : '' ).'>Inghilterra</option>
              <option value="US"'.( ($data['country'] == 'US') ? ' selected="selected"' : '' ).'>Stati Uniti</option>
              <option value="DE"'.( ($data['country'] == 'DE') ? ' selected="selected"' : '' ).'>Germania</option>
              <option value="AT"'.( ($data['country'] == 'AT') ? ' selected="selected"' : '' ).'>Austria</option>
              <option value="CH"'.( ($data['country'] == 'CH') ? ' selected="selected"' : '' ).'>Svizzera</option>
              <option value="FR"'.( ($data['country'] == 'FR') ? ' selected="selected"' : '' ).'>Francia</option>
          </select>
          </td>
        </tr>

        <tr height="20"><td></td></tr>

        <tr>
          <td colspan="2"><input style="border: none;" type="checkbox" name="confirm_agb" value="1"'.( ($agb_checked) ? ' checked="checked"' : '' ).'>&nbsp;Dichiaro in questa sede di aver preso visione dei <a href="agb.html" target=_blank><b>termini e condizioni per il gioco</b></a> e di accettarli.<br>
          <br><b>Solo un account per IP [<a href="javascript: void;" onmouseover="return overlib(\'Questa limitazione significa che ogni giocatore che per pi&ugrave; di 4 giorni successivi alla registrazione avr&agrave; pi&ugrave; di un account in funzione sul proprio IP, se li vedr&agrave; bannati o cancellati!<br>Se ci&ograve; &egrave; dovuto a motivi tecnici quali router o altro, deve subito comunicare al Supporto le ragione dei diversi account loggati dallo stesso IP. <br> <u> <b> Seguite il link in basso!(Non ancora attivo...)\', CAPTION, \'Solo un Account per IP:\', WIDTH, 400, FGCOLOR, \'#ffffff\', TEXTCOLOR, \'#ffffff\', FGBACKGROUND,\'http://www.stfc.it/stfc_gfx/skin1/bg_stars1.gif\', BGCOLOR, \'#33355E\', BORDER, 2, CAPTIONFONT, \'Arial\', CAPTIONSIZE, 2, TEXTFONT, \'Arial\', TEXTSIZE, 2);" onmouseout="return nd();">Info</a>]<br><a href=index.php?a=multis><u>Dettagli sulla limitazione</u></a></b></td>          	
        </tr>

        <tr height="20"><td></td></tr>
        <tr>
          <td colspan="2">
             <input type=hidden name="submit" value="1">
             <input type=hidden name="galaxy" value="'.$galaxy.'">
             <input type="submit" name="submit_b" value="Registrami">
             <br><br>
             <i>* Il nome scelto apparir&agrave; in gioco<br>** Il Login verr&agrave; usato esclusivamente per accedere al gioco<br>*** Se indicato, il codice apparir&agrave; nella <a href="http://www.stfc.it/index.php?a='.(($galaxy) ? 'fe' : 'be').'_karte" target=_blank><u>mappa degli Utenti</u></a>. (Non ancora attivo!)</i>
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


$main_html = '<center><span class="caption">Registrazione</span></center><br>';
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


$main_html.='<center>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="750" class="border_grey" style=" background-color:#000000; background-position:left;
  <tr>
    <td width="700" align="center">
      <span class="sub_caption">(1/2) Scegli la galassia:</span><br>

      <table border=0 cellpadding=2 cellspacing=2 style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="350">
            <center><span class="sub_caption">'.GALAXY1_NAME.'</span></center><br>
            <a href="index.php?a=register&galaxy=0"><img src="'.GALAXY1_IMG.'" border=0></a><br>
            <u>Versione:</u> STFC2<br>
            <u>In gioco da:</u> '.round($config['tick_id']/480,0).' giorni<br>
            <u>Posti disponibili:</u> '.($config['max_player']-$playercount['num']).'/'.$config['max_player'].'<br>
            <u>Giocatori online:</u> '.$player_online['num'].'<br><br>
            La Galassia "'.GALAXY1_NAME.'" &egrave; il setup base con un tempo di tick di 3 minuti.<br>
          </td>
          <td width="350">
            <center><span class="sub_caption">'.GALAXY2_NAME.'</span></center><br>
            <a href="index.php?a=register&galaxy=1"><img src="'.GALAXY2_IMG.'" border=0></a><br>
            <u>Versione:</u> STFC2<br>
            <u>In gioco da:</u> '.round($config2['tick_id']/480,0).' giorni<br>
            <u>Posti disponibili:</u> '.($config2['max_player']-$playercount2['num']).'/'.$config2['max_player'].'<br>
            <u>Giocatori online:</u> '.$player_online2['num'].'<br><br>
            La Galassia "'.GALAXY2_NAME.'" &egrave; il setup in cui ci sono meno razze a disposizione e la diplomazia &egrave; solo un sogno.<br>
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

if ($config['register_blocked']) {display_registration(NULL,'La registrazione attualmente &egrave; disabilitata',$galaxy); return true;}
else if ($config['max_player']<=$playercount['num']) {display_registration(NULL,'La registrazione attualmente non &egrave; possibile<br>('.$playercount['num'].' di '.$config['max_player'].' posti occupati)',$galaxy);return true;}
else
if(isset($_POST['submit'])) {
    if(empty($_POST['user_name'])) {
        display_registration($_POST, '(Nome del giocatore non specificato)',$galaxy);
        return true;
    }

    if(empty($_POST['login_name'])) {
        display_registration($_POST, '(Login non specificato)',$galaxy);
        return true;
    }
    
    if(strstr($_POST['user_name'], ' ')) {
        display_registration($_POST, '(Nome del giocatore contenente spazi)',$galaxy);
        return true;
    }
    
    for ($count=0; $count < strlen($_POST['user_name']); $count++) {
       $val=ord( (substr($_POST['user_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Il nome scelto contiene caratteri non consentiti [solo 0-9, a-z, A-Z])',$galaxy);
        return true;
       }
   }

    for ($count=0; $count < strlen($_POST['login_name']); $count++) {
       $val=ord( (substr($_POST['login_name'], $count, 1)) );
       if ($val<48 || ($val>57 && $val<65) || ($val>90 && $val<97) || $val>122)
       {
        display_registration($_POST, '(Il Login scelto contiene caratteri non consentiti [solo 0-9, a-z, A-Z])',$galaxy);
        return true;
       }
   }


    if($_POST['user_name'] == $_POST['login_name']) {
        display_registration($_POST, '(Il nome giocatore e il Login coincidono!)',$galaxy);
        return true;
    }


    if(empty($_POST['user_password'])) {
        display_registration($_POST, '(Password non specificata)',$galaxy);
        return true;
    }

    if($_POST['user_password'] != $_POST['user_password2']) {
        display_registration($_POST, '(Le Password non coincidono)',$galaxy);
        return true;
    }

    if(empty($_POST['user_email'])) {
        display_registration($_POST, '(Indirizzo Email non specificato!)',$galaxy);
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_email = "'.$_POST['user_email'].'"';
    

    unset($user_exists);



    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify email');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(La Email specificata &egrave; gi&agrave; in uso nella Galassia!)',$galaxy);
        return true;
    }
    
    $sql = 'SELECT user_id
            FROM user
            WHERE user_loginname = "'.$_POST['login_name'].'"';
    

    unset($user_exists);


    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify login name');
    }
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(Il Login &egrave; gi&agrave; in uso nella Galassia!)',$galaxy);
        return true;
    }

    $sql = 'SELECT user_id
            FROM user
            WHERE user_name = "'.$_POST['user_name'].'"';
    unset($user_exists);

    if(($user_exists = $mydb->queryrow($sql)) === false) {
        die('Database error - Could not verify user name');
    }
    
    if(!empty($user_exists['user_id'])) {
        display_registration($_POST, '(Il nome del giocatore &egrave; gi&agrave; in uso nella Galassia!)',$galaxy);
        return true;
    }
    
    
    
    if(!in_array($_POST['user_race'], array(0, 1, 2, 3, 4, 5, 8, 9, 10, 11))) {
        display_registration($_POST, '(La razza non esiste)',$galaxy);
        return true;
    }

    if(empty($_POST['confirm_agb'])) {
        display_registration($_POST, '(I termini non sono stati accettati)',$galaxy);
        return true;
    }

    if( (!empty($_POST['user_birthday_day'])) && (!empty($_POST['user_birthday_month'])) && (!empty($_POST['user_birthday_year'])) ) {
        $day = abs((int)$_POST['user_birthday_day']);
        $month = abs((int)$_POST['user_birthday_month']);
        $year = abs((int)$_POST['user_birthday_year']);

        if($day > 31) {
            display_registration($_POST, '(La data di nascita non &egrave; valida)',$galaxy);
            return true;
        }

        if($month > 12) {
            display_registration($_POST, '(Il mese di nascita non &egrave; valido)',$galaxy);
            return true;
        }

        if(strlen($year) != 4) $year = 1900 + $year;

        if($year < 1904) {
            display_registration($_POST, '(Anno di nascita non valido)',$galaxy);
            return true;
        }

        if($year > 1999) {
            display_registration($_POST, '(Anno di nascita non valido)',$galaxy);
            return true;
        }

        $birthday_str = $day.'.'.$month.'.'.$year;
    }
    else {
        $birthday_str = '';
    }

    if(!in_array($_POST['user_gender'], array('-', 'm', 'f'))) {
        display_registration($_POST, '(What <b>are</b> you then?)',$galaxy);
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

    	if(($skin_data = $mydb->queryrow($sql)) === false) {
	        die('Database error - Could not load skin data');
    	}

        $gfxpath='http://www.stfc.it/stfc_gfx/';

/*    	$sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country)
        	    VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'")';*/

    	$sql = 'INSERT INTO user (user_active, user_name, user_loginname, user_password, user_email, user_auth_level, user_race, user_gfxpath, user_skinpath, user_registration_time, user_registration_ip, user_birthday, user_gender, plz, country, language)
        	    VALUES (2, "'.$_POST['user_name'].'", "'.$_POST['login_name'].'", "'.md5($_POST['user_password']).'", "'.$_POST['user_email'].'", 1, '.$_POST['user_race'].', "'.$gfxpath.'", "skin'.$skin_data['skin_id'].'/", '.time().', "'.$_SERVER['REMOTE_ADDR'].'", "'.$birthday_str.'", "'.$_POST['user_gender'].'", '.$_POST['plz'].', "'.$_POST['country'].'", "'.$lang.'")';

    	if(!$mydb->query($sql)) {
	        die('Database error - Could not insert user data');
    	}
    	// Bietet größere Sicherheit bei hoher Last
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
        define('EXT_NL', "\r\n");
		$mail_message = 'Congratulazioni '.$_POST['user_name'].'!'."\n".'La tua registrazione a Star Trek: Frontline Combat II (Galassia '.$galaxyname.') ha avuto successo!'."\n".'Per attivare il tuo account devi cliccare sul link seguente:'."\n".$activation_link."\n\n".'Se non hai eseguito la registrazione, ignora questa email.'."\n".'Dopo 48 ore, il tuo indirizzo email verrà automaticamente rimosso dal nostro database.'."\n\n".'Lunga vita e prosperità,'."\n".'Il team STFC.'."\n\n".'Credits: http://www.stfc.it/index.php?a=imprint';
		send_mail("STFC2 Mailer","admin@stfc.it",$_POST['user_name'],$_REQUEST['user_email'],"Registrazione Star Trek: Frontline Combat",$mail_message);

       // Update NewRegister

       $sql = 'UPDATE config SET new_register = new_register + 1';

    	if(!$mydb->query($sql)) {
	        die('Database error - Could not update new_register');
    	}



    
    display_success($galaxyname,$galaxyimg);
    return true;

}

display_registration(NULL,'(Ci sono '.$playercount['num'].' su '.$config['max_player'].' posti occupati)',$galaxy);

}

?>
