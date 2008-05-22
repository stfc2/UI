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



$game->init_player();
$game->out('<center><span class="caption">Allianz:</span><br><br>');

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

if(empty($game->player['alliance_name'])) {
    message(NOTICE, 'Du bist nicht Mitglied einer Allianz');
}

if($game->player['user_alliance_rights1'] != 1) {
    message(NOTICE, 'Du hast nicht die erforderlichen Rechte zum Betrachten/Bearbeiten der Seite');
}

if(isset($_GET['application'])) {

  if($_GET['application']==0) {

    $sql = 'UPDATE alliance SET alliance_application = 1 WHERE alliance_id = '.$game->player['user_alliance'];

  }
  else {

    $sql = 'UPDATE alliance SET alliance_application = 0 WHERE alliance_id = '.$game->player['user_alliance'];

  }

  if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance application data');
  }     
  
  redirect('a=alliance_admin&settings');

}
elseif(!empty($_POST['status_change_fin'])) {
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }
    if($game->player['user_alliance_rights8'] != 1) {
        message(NOTICE, 'Du hast nicht die erforderlichen Rechte!');
    }
    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, 'Der gewählte Spieler ist nicht in deiner Allianz');
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
       message(NOTICE, 'Du kannst den Status des Präsidenten nicht ändern');
    }
        
    $sql = 'UPDATE user
            SET user_alliance_status = '.( ($user_data['user_alliance_status'] == ALLIANCE_STATUS_MEMBER) ? ALLIANCE_STATUS_FINANZ : ALLIANCE_STATUS_MEMBER ).'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance status data');
    }
    
    redirect('a=alliance_main&member_list');
}
elseif(!empty($_POST['status_change'])) {
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }
    if($game->player['user_alliance_rights8'] != 1) {
        message(NOTICE, 'Du hast nicht die erforderlichen Rechte!');
    }
    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, 'Der gewählte Spieler ist nicht in deiner Allianz');
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, 'Der Status des Präsidenten kann nicht von einem Admin geändert werden');
    }
    
    $sql = 'UPDATE user
            SET user_alliance_status = '.( ($user_data['user_alliance_status'] == ALLIANCE_STATUS_MEMBER) ? ALLIANCE_STATUS_ADMIN : ALLIANCE_STATUS_MEMBER ).'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance status data');
    }
    
    redirect('a=alliance_main&member_list');
}
elseif(!empty($_POST['status_change_diplo'])) {
    if($game->player['user_alliance_rights8'] != 1) {
        message(NOTICE, 'Du hast nicht die erforderlichen Rechte!');
    }

    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }

    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, 'Der gewählte Spieler ist nicht in deiner Allianz');
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, 'Der Status des Präsidenten kann nicht von einem Admin geändert werden');
    }
    
    $sql = 'UPDATE user
            SET user_alliance_status = '.( ($user_data['user_alliance_status'] == ALLIANCE_STATUS_MEMBER) ? ALLIANCE_STATUS_DIPLO : ALLIANCE_STATUS_MEMBER ).'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance status data');
    }
    
    redirect('a=alliance_main&member_list');
}
elseif(!empty($_POST['owner_change_confirm'])) {
    if($game->player['user_id'] != $alliance['alliance_owner']) {
        message(NOTICE, 'Nur der Präsident selber kann das Amt übergeben!');
    }
    
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }

    $user_id = (int)$_POST['user_id'];

    if($user_id == $alliance['alliance_owner']) {
       message(NOTICE, 'Shizophren?');
    }

    $sql = 'SELECT user_id, user_alliance
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, 'Der gewählte Spieler ist nicht in deiner Allianz');
    }
    

    $sql = 'UPDATE user, alliance
            SET user_alliance_status = '.ALLIANCE_STATUS_OWNER.', alliance_owner = '.$user_id.',
            user_alliance_rights1 = 1,
            user_alliance_rights2 = 1,
            user_alliance_rights3 = 1,
            user_alliance_rights4 = 1,
            user_alliance_rights5 = 1,
            user_alliance_rights6 = 1,
            user_alliance_rights7 = 1,
            user_alliance_rights8 = 1
            WHERE user_id = '.$user_id.' AND alliance_id = '.$game->player['user_alliance'];

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update others user alliance data');
    }


    $sql = 'UPDATE user
            SET user_alliance_status = '.ALLIANCE_STATUS_MEMBER.',
            user_alliance_rights1 = 0,
            user_alliance_rights2 = 0,
            user_alliance_rights3 = 0,
            user_alliance_rights4 = 0,
            user_alliance_rights5 = 0,
            user_alliance_rights6 = 0,
            user_alliance_rights7 = 0,
            user_alliance_rights8 = 0
            WHERE user_id = '.$game->player['user_id'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update own user alliance data');
    }


    redirect('a=alliance_main');
}
elseif(!empty($_POST['owner_change'])) {
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }

    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_name
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    $game->out('
<table style="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_admin').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      Willst du <a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_id).'">'.$user_data['user_name'].'</a> wirklich das Präsidentenamt übergeben?<br><br>
      <input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="owner_change_confirm" value="Bestätigen">
    </td>
  </tr>
  <tr height="5"><td></td></tr>
  <input type="hidden" name="user_id" value="'.$user_id.'">
  </form>
</table>
    ');
}
elseif(!empty($_POST['settings_submit'])) {

    if($game->player['user_alliance_rights1'] != 1) {
        message(NOTICE, 'Du hast nicht die erforderlichen Rechte zum Betrachten/Bearbeiten der Seite');
    }

    $sql = 'SELECT alliance_tag FROM alliance WHERE alliance_id = '.$game->player['user_alliance'];
 
    if(($ally_tag = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance name/tag data');
    }

    if(empty($_POST['alliance_name'])) {
        message(NOTICE, 'Es wurde kein Allianz-Name angegeben');
    }

    if($game->player['user_alliance_status'] < ALLIANCE_STATUS_OWNER) {
        $alliance_tag = '"'.htmlspecialchars($ally_tag['alliance_tag']).'"';
    }
    else {
        $alliance_tag = '"'.htmlspecialchars($_POST['alliance_tag']).'"';
    }

    if($_POST['alliance_tag']!=$ally_tag['alliance_tag']) {
       
	$sql = 'SELECT alliance_id
	        FROM alliance
	        WHERE alliance_tag = "'.$_POST['alliance_tag'].'"';
	              
      if(($ally_exists = $db->queryrow($sql)) === false) {
          message(DATABASE_ERROR, 'Could not query alliance name/tag data');
      }
    
      if(!empty($ally_exists['alliance_id'])) {
          message(NOTICE, 'Es gibt schon eine Allianz mit diesem Tag');
      }

    }

    // Entfernt da unnötig by Mojo1987
    //'.( (!empty($_POST['alliance_password'])) ? 'alliance_password = "'.md5($_POST['alliance_password']).'",' : '' ).' entfernt da wegen Bewerbung unnötig

    $sql = 'UPDATE alliance
            SET 
                alliance_name = "'.htmlspecialchars($_POST['alliance_name']).'",
                alliance_tag = '.$alliance_tag.',
                alliance_text = "'.str_replace("\n", '<br>', htmlspecialchars($_POST['alliance_text'])).'",
                alliance_logo = "'.addslashes($_POST['alliance_logo']).'",
                alliance_homepage = "'.addslashes($_POST['alliance_homepage']).'",
                alliance_irc = "'.addslashes($_POST['alliance_irc']).'",
		  alliance_application_text = "'.str_replace("\n", '<br>', htmlspecialchars($_POST['alliance_application_text'])).'"
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance data');
    }
    
    redirect('a=alliance_main');
}
elseif(isset($_GET['settings'])) {
    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(($adata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

    $game->out('
<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$adata['alliance_name'].' ['.$adata['alliance_tag'].']</span><br><br><br>
      
      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <form method="post" action="'.parse_link('a=alliance_admin').'">
        <tr>
          <td colspan="2" width="350"><b>Allianz-Einstellungen</b></td>
        </tr>
        <tr><td height="10"></td></tr>
        <tr>
          <td width="50">Name:</td>
          <td width="300"><input class="field" type="text" name="alliance_name" value="'.$adata['alliance_name'].'"></td>
        </tr>
        <tr>
          <td>Tag:</td>
          <td><input class="field" type="text" name="alliance_tag" maxlength="6" size="30" value="'.$adata['alliance_tag'].'"'.( ($game->player['user_alliance_status'] < ALLIANCE_STATUS_OWNER) ? ' disabled="disabled"' : '' ).'></td>
        </tr>
        <tr>
          <td>Text:</td>
          <td><textarea name="alliance_text" cols="45" rows="8">'.stripslashes(str_replace('<br>', "\n", $adata['alliance_text'])).'</textarea></td>
        </tr>
        <tr>
          <td>Allianz-Bewerbungsvorlage:</td>
          <td><textarea name="alliance_application_text" cols="45" rows="8">'.stripslashes(str_replace('<br>', "\n", $adata['alliance_application_text'])).'</textarea></td>
        </tr>
        <tr><td height="5"></td></tr>
        <tr>
          <td>Logo:</td>
          <td><input style="width: 200px;" class="field" type="text" name="alliance_logo" 
value="'.$adata['alliance_logo'].'"><br><b>Achte beim Linken von externen Seiten darauf, ob sie das Anzeigen eines Bildes von außen 
erlauben!<br><font color="yellow">Sollte euer Allianzlogo aus der Rangliste raus nicht anzeigt werden, so macht es kleiner (max. 
Breite 350px, max. Höhe 280px)</font></b></td>
        </tr>
        <tr>
          <td>Homepage:</td>
          <td><input style="width: 200px;" class="field" type="text" name="alliance_homepage" value="'.$adata['alliance_homepage'].'"></td>
        </tr>
        <tr>
          <td>IRC:</td>
          <td><input style="width: 200px;" class="field" type="text" name="alliance_irc" value="'.$adata['alliance_irc'].'"></td>
        </tr>
         <tr>
          <td>Bewerbungen erlauben?:</td>
');
if($adata['alliance_application']==1) { $game->out('<td>[<span style="color: #00FF00;">Ja</span>]&nbsp;&nbsp;[<a href="'.parse_link('a=alliance_admin&application=1').'">Nein</a>]</td>'); }
else { $game->out('<td>[<a href="'.parse_link('a=alliance_admin&application=0').'">Ja</a>]&nbsp;&nbsp;[<span style="color: #FF0000;">Nein</span>]</td>'); }

$game->out('

        </tr>
        <tr><td height="5"></td></tr>
        <tr>
          <td colspan="2" width="350" align="center"><input class="button" type="submit" name="settings_submit" value="Übernehmen"></td>
        </tr>
        <tr><td height="5"></td></tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
elseif(!empty($_POST['delete_confirm'])) {
    if($game->player['user_id'] != $alliance['alliance_owner']) {
        message(NOTICE, 'Nur der Präsident kann die Allianz auflösen');
    }
    
    $sql = 'UPDATE user
            SET user_alliance = 0,
                user_alliance_status = 0,
                user_alliance_rights1 = 0,
                user_alliance_rights2 = 0,
                user_alliance_rights3 = 0,
                user_alliance_rights4 = 0,
                user_alliance_rights5 = 0,
                user_alliance_rights6 = 0,
                user_alliance_rights7 = 0,
                user_alliance_rights8 = 0
            WHERE user_alliance = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance data');
    }
    
    $sql = 'DELETE FROM alliance_diplomacy
            WHERE alliance1_id = '.$game->player['user_alliance'].' OR
                  alliance2_id = '.$game->player['user_alliance'];
                  
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
    }
    
    $sql = 'UPDATE alliance_bposts
            SET post_deleted = 2
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance bposts data');
    }
    
    $sql = 'DELETE FROM alliance_bthreads
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete alliance bthreads data');
    }
    
    $sql = 'DELETE FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete alliance data');
    }
    
    redirect('a=alliance_main');
}
elseif(isset($_GET['delete'])) {
    $game->out('
<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_admin').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      Willst du die Allianz wirklich endgültig AUFLÖSEN?<br><br>
      <input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="delete_confirm" value="Bestätigen">
    </td>
  </tr>
  <tr height="5"><td></td></tr>
  </form>
</table>
    ');
}

?>
