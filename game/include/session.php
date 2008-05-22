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


if(isset($_POST['stgc_login'])) {
    if(empty($_POST['user_name']) || empty($_POST['user_password'])) {
        $game->print_login_error('Bitte alle Felder ausfüllen');
    }

    $pass = md5($_POST['user_password']);

    $sql = 'SELECT user_id, user_password, user_auth_level
            FROM user
            WHERE user_loginname = "'.addslashes($_POST['user_name']).'" AND user_password = "'.$pass.'"';

    if(($login_user = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user data to create new session');
    }

    if(empty($login_user['user_id'])) {
        $game->print_login_error('Benutzer existiert nicht oder das Passwort ist falsch');
    }

    if($login_user['user_auth_level'] == STGC_BOT) {
        $game->print_login_error('Versuch´s erst garnicht');
    }

    $cookie_data = array('user_id' => $login_user['user_id']);

    $cookie_data['user_password'] = $pass;

    if(!setcookie('stgc5_session', base64_encode(serialize($cookie_data)), (time() + (60 * 60 * 24 * 30)) )) {
        message(GENERAL, '<br>Es konnte kein Session-Cookie gesetzt werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
    }
    
    if(!empty($_POST['proxy_mode'])) {
        if(!setcookie('stgc5_proxy_mode', '1', (time() + (60 * 60 * 24 * 30)) )) {
            message(GENERAL, '<br>Der Proxy-Modus konnte nicht aktiviert werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
        }
    }
    else {
        if(!empty($_COOKIE['stgc5_proxy_mode'])) setcookie('stgc5_proxy_mode');
    }


    redirect(GAME_EXE);
}
elseif(isset($_REQUEST['stgc_logout'])) {
    if(!setcookie('stgc5_session')) {
        message(GENERAL, '<br>Der Session-Cookie konnte nicht gelöscht werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
    }
    
    if(!setcookie('stgc5_session_ext')) {
        message(GENERAL, '<br>Ein Teil des Session-Cookie konnte nicht gelöscht werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
    }

    if(!empty($_COOKIE['stgc5_proxy_mode'])) {
        if(!setcookie('stgc5_proxy_mode')) {
            message(GENERAL, '<br>Der Proxy-Modus konnte nicht deaktiviert werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
        }
    }

    redirect('../index.php');
}
else {
    if(empty($_COOKIE['stgc5_session'])) {
        redirect('../index.php?a=login');
    }

    $cookie_data = unserialize(base64_decode($_COOKIE['stgc5_session']));

    if(!is_array($cookie_data)) {
        $game->print_login_error('Autologin-Cookie ist ungültig (Cookies löschen und neu einloggen)');
    }

    if(empty($cookie_data['user_id'])) {
        $game->print_login_error('Ungültiges Cookie-Format (Cookies löschen und neu einloggen)');
    }

    $user_id = (int)$cookie_data['user_id'];

    if(empty($cookie_data['user_password'])) {
        $game->print_login_error('Ungületiges Cookie-Format (Cookies löschen und neu einloggen)');
    }

    $user_password = stripslashes($cookie_data['user_password']);

    $sql = 'SELECT *
            FROM user
            WHERE user_id = '.$user_id;

    if(($player_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user data');
    }

    if(empty($player_data['user_id'])) {
        $game->print_login_error('Autologin-Benutzer existiert nicht (Cookies löschen und neu einloggen)');
    }

    if($player_data['user_auth_level'] == STGC_BOT) {
        $game->print_login_error('Versuch´s erst garnicht');
    }

    if($user_password != $player_data['user_password']) {
        $game->print_login_error('Autologin-Passwort ist ungültig (Cookies löschen und neu einloggen)');
    }

    $sitting_mode = 0;
    
    $template_user_id = $player_data['user_id'];

    if(!empty($cookie_data['sitting_user_id'])) {
        $sitting_user_id = (int)$cookie_data['sitting_user_id'];
        $sql = 'SELECT *
                FROM user
                WHERE user_id = '.$sitting_user_id;

        if(($st_player_data = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query sitting user data');
        }

        if( ($st_player_data['user_sitting_id1'] == $user_id) || ($st_player_data['user_sitting_id2'] == $user_id) || ($st_player_data['user_sitting_id3'] == $user_id) || ($st_player_data['user_sitting_id4'] == $user_id) || ($st_player_data['user_sitting_id5'] == $user_id) ) {

            if ($st_player_data['user_active']==0) 
			{
			$sitting_mode = 0;
            echo 'Der Spieler '.$st_player_data['user_name'].' ist gebannt<br>Bitte log dich neu ein.';
            }
            else
            if ($st_player_data['user_active']==2) 
			{
			$sitting_mode = 0;
            echo 'Der Spieler '.$st_player_data['user_name'].' ist nicht aktiviert<br>Bitte log dich neu ein.';
            }
            else
            if ($st_player_data['user_active']==3) 
			{
			$sitting_mode = 0;
            echo 'Der Spieler '.$st_player_data['user_name'].' wird gelöscht<br>Bitte log dich neu ein.';
            }
            else
            if ($st_player_data['user_active']==4) 
			{
			$sitting_mode = 0;
            echo 'Der Spieler '.$st_player_data['user_name'].' wird gelöscht<br>Bitte log dich neu ein.';
            }
            else
			{            
            $sitting_mode = $user_id;

            unset($st_player_data['user_skinpath']);
            unset($st_player_data['user_gfxpath']);
            unset($st_player_data['user_jspath']);
			$player_data['sitting_user_id'] = $player_data['user_id'];
			$player_data['sitting_user_password'] = $player_data['user_password'];
            $player_data = array_merge($player_data, $st_player_data);
			}
        }
        else {
            $sitting_mode = 0;
            echo 'Der Spieler '.$st_player_data['user_name'].' hat dir nicht die Berechtigung gegeben, seinen Account zu sitten.<br>Bitte log dich neu ein, um diese Meldung nicht mehr zu sehen.';
        }
    }

    if($player_data['user_active'] != 1) {
        switch($player_data['user_active']) {
              case 0:
                $game->print_login_error('Benutzer ist gebannt<br><br>'.$player_data['message_basement'].'');
            break;

            case 2:
                $game->print_login_error('Benutzer ist noch nicht aktiviert');
            break;

            case 3:
                $game->print_login_error('Benutzer hat Löschung beantragt');
            break;

            case 4:
                $game->print_login_error('Benutzer hat Löschung beantragt');
            break;
        }
    }

    if( ($player_data['user_vacation_start'] < $ACTUAL_TICK) && ($player_data['user_vacation_end'] > $ACTUAL_TICK) ) {
        $game->print_login_error('Urlaubsmodus läuft noch '.format_time( 3 * ($player_data['user_vacation_end'] - $ACTUAL_TICK)));
    }

    if($player_data['user_override_uid'] != 0) {
        if($player_data['user_auth_level'] != STGC_DEVELOPER) {
            stgc_log('override_error', $player_data['user_name'].' tried to override user '.$player_data['user_override_uid']);

            $sql = 'UPDATE user
                    SET user_active = 0
                    WHERE user_id = '.$player_data['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user ban data');
            }

            message(GENERAL, 'Schutzverletzung aufgetreten');
        }

        $sql = 'SELECT *
                FROM user
                WHERE user_id = '.$player_data['user_override_uid'];

        if(($override_data = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query user override data');
        }

        if(empty($override_data['user_id'])) {
            echo 'Could not find override-user <b>'.$player_data['user_override_uid'].'</b>';
        }
        else {
            define('OVERRIDE_UID_MODE', $player_data['user_id']);

            $player_data = $override_data;
            $sitting_mode = 0;
        }
    }
    if( ($sitting_mode == 0) && (!defined('OVERRIDE_UID_MODE'))) {
        if(empty($_COOKIE['stgc5_session_ext'])) {
            if(!setcookie('stgc5_session_ext', (string)$user_id, (time() + (60 * 60 * 24)) )) {
                message(GENERAL, '<br>Es konnte ein Teil des Session-Cookie nicht gesetzt werden, bitte überprüfen sie ihre Browser-Einstellungen bezüglich Cookie-Sicherheit<br>');
            }
        }
        else {
            $cookie_user_id = (int)$_COOKIE['stgc5_session_ext'];

        }
    }

    $player_data['alliance_id'] = 0;
    $player_data['alliance_name'] = '';
    $player_data['alliance_tag'] = '';
    
    if(!empty($player_data['user_alliance'])) {
        $sql = 'SELECT alliance_id, alliance_name, alliance_tag
                FROM alliance
                WHERE alliance_id = '.$player_data['user_alliance'];
                
        if(($alliance_data = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query user alliance data');
        }

        if(!empty($alliance_data['alliance_id'])) {
            $player_data['alliance_id'] = (int)$alliance_data['alliance_id'];
            $player_data['alliance_name'] = $alliance_data['alliance_name'];
            $player_data['alliance_tag'] = $alliance_data['alliance_tag'];
        }
    }
    
    $sql = 'SELECT user_template
            FROM user_templates
            WHERE user_id = '.$template_user_id;
            
    if(($template_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user template user data');
    }
    
    $game->template_html = stripslashes($template_data['user_template']);


    if( (!empty($_COOKIE['stgc5_proxy_mode'])) || (!empty($_GET['proxy_mode'])) ) {
        $game->PROXY_MODE = true;
        
        define('FIXED_GFX_PATH', PROXY_GFX_PATH);
    }
    else {
        define('FIXED_GFX_PATH', DEFAULT_GFX_PATH);
    }
    
    $game->prepare_player($player_data, $sitting_mode);
    
    unset($player_data);

}

?>
