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
$game->out('<span class="caption">'.constant($game->sprache("TEXT28")).':</span><br><br>');

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

if(empty($game->player['alliance_name'])) {
    message(NOTICE, constant($game->sprache("TEXT1")));
}

if($game->player['user_alliance_rights1'] != 1) {
    message(NOTICE, constant($game->sprache("TEXT10")));
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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }
    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
       message(NOTICE, constant($game->sprache("TEXT4")));
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
        message(NOTICE, constant($game->sprache("TEXT5")));
    }
    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, constant($game->sprache("TEXT6")));
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT7")));
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
        message(NOTICE, constant($game->sprache("TEXT5")));
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
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT7")));
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
        message(NOTICE, constant($game->sprache("TEXT8")));
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
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
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
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    $game->out('
<table style="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_admin').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      '.constant($game->sprache("TEXT9")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_id).'">'.$user_data['user_name'].'</a>'.constant($game->sprache("TEXT11")).'<br><br>
      <input class="button" type="button" value="'.constant($game->sprache("TEXT12")).'" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="owner_change_confirm" value="'.constant($game->sprache("TEXT13")).'">
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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    $sql = 'SELECT alliance_tag FROM alliance WHERE alliance_id = '.$game->player['user_alliance'];
 
    if(($ally_tag = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance name/tag data');
    }

    if(empty($_POST['alliance_name'])) {
        message(NOTICE, constant($game->sprache("TEXT14")));
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
          message(NOTICE, costant($game->sprache("TEXT15")));
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
          <td colspan="2" width="350"><b>'.constant($game->sprache("TEXT16")).'</b></td>
        </tr>
        <tr><td height="10"></td></tr>
        <tr>
          <td width="50">'.constant($game->sprache("TEXT17")).':</td>
          <td width="300"><input class="field" type="text" name="alliance_name" style="width: 290px;" value="'.$adata['alliance_name'].'"></td>
        </tr>
        <tr>
          <td>Tag:</td>
          <td><input class="field" type="text" name="alliance_tag" maxlength="6" size="30" style="width: 290px;" value="'.$adata['alliance_tag'].'"'.( ($game->player['user_alliance_status'] < ALLIANCE_STATUS_OWNER) ? ' disabled="disabled"' : '' ).'></td>
        </tr>
        <tr>
          <td>'.constant($game->sprache("TEXT18")).':</td>
          <td><textarea name="alliance_text" cols="45" rows="8" style="width: 290px;">'.stripslashes(str_replace('<br>', "\n", $adata['alliance_text'])).'</textarea></td>
        </tr>
        <tr>
          <td>'.constant($game->sprache("TEXT19")).':</td>
          <td><textarea name="alliance_application_text" cols="45" rows="8" style="width: 290px;">'.stripslashes(str_replace('<br>', "\n", $adata['alliance_application_text'])).'</textarea></td>
        </tr>
        <tr><td height="5"></td></tr>
        <tr>
          <td>Logo:</td>
          <td><input style="width: 290px;" class="field" type="text" name="alliance_logo" value="'.$adata['alliance_logo'].'"><br><b>'.constant($game->sprache("TEXT20")).'<br><font color="yellow">'.constant($game->sprache("TEXT21")).'</font></b></td>
        </tr>
        <tr>
          <td>Homepage:</td>
          <td><input style="width: 290px;" class="field" type="text" name="alliance_homepage" value="'.$adata['alliance_homepage'].'"></td>
        </tr>
        <tr>
          <td>IRC:</td>
          <td><input style="width: 290px;" class="field" type="text" name="alliance_irc" value="'.$adata['alliance_irc'].'"></td>
        </tr>
         <tr>
          <td>'.constant($game->sprache("TEXT22")).':</td>
');
if($adata['alliance_application']==1) { $game->out('<td>[<span style="color: #00FF00;">'.constant($game->sprache("TEXT23")).'</span>]&nbsp;&nbsp;[<a href="'.parse_link('a=alliance_admin&application=1').'">'.constant($game->sprache("TEXT24")).'</a>]</td>'); }
else { $game->out('<td>[<a href="'.parse_link('a=alliance_admin&application=0').'">'.constant($game->sprache("TEXT23")).'</a>]&nbsp;&nbsp;[<span style="color: #FF0000;">'.constant($game->sprache("TEXT24")).'</span>]</td>'); }

$game->out('

        </tr>
        <tr><td height="5"></td></tr>
        <tr>
          <td colspan="2" width="350" align="center"><input class="button" type="submit" name="settings_submit" value="'.constant($game->sprache("TEXT25")).'"></td>
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
        message(NOTICE, constant($game->sprache("TEXT26")));
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
      '.constant($game->sprache("TEXT27")).'<br><br>
      <input class="button" type="button" value="'.constant($game->sprache("TEXT12")).'" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="delete_confirm" value="'.constant($game->sprache("TEXT13")).'">
    </td>
  </tr>
  <tr height="5"><td></td></tr>
  </form>
</table>
    ');
}

?>
