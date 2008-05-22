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

// Rechtecheck

$game->init_player();
    
$sql = 'SELECT *
      FROM alliance
      WHERE alliance_id = '.$game->player['user_alliance'];

if(($alliance = $db->queryrow($sql)) === false) {
   message(DATABASE_ERROR, 'Could not query alliance data');
}

if($game->player['user_alliance_rights4'] != 1 && $game->player['user_id'] != $alliance['alliance_owner']) {
    message(NOTICE, constant($game->sprache("TEXT0")));
}

// Check Ende

else {
if(!empty($_POST['mass_mail_submit'])) {
    
    if($alliance['alliance_member']<=1) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if(empty($_POST['mail_subject'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }
    
    if(empty($_POST['mail_text'])) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }
    
    $sql = 'SELECT user_id
            FROM user
            WHERE user_alliance = '.$game->player['user_alliance'];
            
    if(!$q_members = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query alliance user data');
    }

 	$result = $db->query('UPDATE user SET user_message_sig="'.htmlspecialchars($_POST['message_sig']).'" WHERE user_id='.$game->player['user_id']);
 	$game->player['user_message_sig']=htmlspecialchars($_POST['message_sig']);
	if($result == false)
	{
		message(DATABASE_ERROR, 'message_query: Could not call INSERT INTO in message');
		exit();
	}

    $mail_subject = htmlspecialchars($_POST['mail_subject']);
    $mail_text = htmlspecialchars($_POST['mail_text']);
    
    $i = 0;
    $user_ids = array();
    
    while($member = $db->fetchrow($q_members)) {
        if($member['user_id'] == $game->player['user_id']) continue;

        $sql = 'INSERT INTO message (sender, receiver, subject, text, rread, time)
                VALUES ('.$game->player['user_id'].', '.$member['user_id'].', "'.$mail_subject.'", "'.$mail_text.'\n\n'.$game->player['user_message_sig'].'", 0, '.time().')';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert message data #'.$i);
        }
        
        ++$i;
        $user_ids[] = $member['user_id'];
    }
    
    $sql = 'UPDATE user
            SET unread_messages = unread_messages + 1
            WHERE user_id IN ('.implode(',', $user_ids).')';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user unread messages');
    }
    
    redirect('a=alliance_main');
}
    $game->out('
<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br><br>

      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <form method="post" action="'.parse_link('a=alliance_massmail').'">
        <tr>
          <td colspan="2" width="350">'.constant($game->sprache("TEXT4")).'</td>
        </tr>
        <tr height="10"><td></td></tr>
        <tr>
          <td width="50">'.constant($game->sprache("TEXT5")).'</td>
          <td width="300"><input class="field" type="text" name="mail_subject" maxlength="32" style="width: 280px;"></td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td width="50">'.constant($game->sprache("TEXT6")).'</td>
          <td width="300"><textarea name="mail_text" cols="45" rows="8" style="width: 280px;"></textarea>
        </tr>
        <tr>
          <td width="50">'.constant($game->sprache("TEXT7")).'</td>
          <td width="300"><textarea name="message_sig" cols="45" rows="3" style="width: 280px;">'.$game->player['user_message_sig'].'</textarea>
        </tr>

        <tr height="5"><td></td></tr>
        <tr>
          <td colspan="2" width="350" align="center"><input class="button" type="submit" name="mass_mail_submit" value="'.constant($game->sprache("TEXT8")).'"></td>
        </tr>
        <tr height="5"><td></td></tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
?>
