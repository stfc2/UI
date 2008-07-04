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

if($game->player['user_alliance_rights7'] != 1 ) {
    message(NOTICE, constant($game->sprache("TEXT0")));
}

// Check Ende

else {

    $action = (!empty($_GET['do'])) ? $_GET['do'] : 'display';
    switch($action) {
    case 'post_shoutbox':
        if(empty($_POST['ally_shoutbox_msg'])) break;
        if((time() - 15) < $game->player['last_shoutbox_post']) {
            $sql = 'UPDATE user SET last_shoutbox_post = '.time().', shoutbox_flood_error = shoutbox_flood_error + 1
                    WHERE user_id = '.$game->player['user_id'];
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user shoutbox flood protection data');
            }
            message(NOTICE, constant($game->sprache("TEXT1")));
        }
        $sql = 'INSERT INTO alliance_shoutbox (alliance_id, user_id, message, timestamp)
                VALUES ("'.$game->player['user_alliance'].'", "'.$game->player['user_id'].'", "'.htmlspecialchars($_POST['ally_shoutbox_msg']).'", '.time().')';
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert the new message');
        }
        $sql = 'UPDATE user SET shoutbox_posts = shoutbox_posts + 1, last_shoutbox_post = '.time().' WHERE user_id = '.$game->player['user_id'];
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update user shoutbox data');
        }
        redirect('a=alliance_chat&do=display');
    break;
    case 'display':
        $count = 15;
        $sql = 'SELECT a.*, u.user_name FROM alliance_shoutbox a, user u WHERE a.user_id = u.user_id AND a.alliance_id = '.$game->player['user_alliance'].' ORDER BY timestamp DESC'
        . ' LIMIT 0, '.$count;
        if(($sb_posts = $db->queryrowset($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query ally_shoutbox data');
        }
        $game->out('
<table class="style_outer" border="0" cellpadding="2" cellspacing="2" width="500">
  <tr>
    <td align="center">
      <span class="sub_caption">'.constant($game->sprache("TEXT2")).'</span><br><br>
      <table width="450" border="0" cellpadding="2" cellspacing="2" class="style_inner">
        <tr>
          <td width="100%">
    ');
        $count = (count($sb_posts) - 1); 
        for($i = $count; $i >= 0; --$i) {
            $game->out('<i>'.$sb_posts[$i]['user_name'].' ('.date('H:i', $sb_posts[$i]['timestamp']).')</i>:<br>'.wordwrap($sb_posts[$i]['message'], 250, '<br>', 1).'<br>');
        }
        $game->out('
          </td>
        </tr>
      </table>
      <br>
      <table width="300" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <form name="ally_shoutbox" method="post" action="'.parse_link('a=alliance_chat&do=post_shoutbox').'" onSubmit="return this.submit_post.disabled = true;">
          <td width="300">
            <input type="text" name="ally_shoutbox_msg" style="width: 250px;" class="field_nosize" maxlength="250">&nbsp;<input type="submit" name="submit_post" class="button_nosize" width="45" value="'.constant($game->sprache("TEXT3")).'">
          </td>
          </form>
        </tr>
        <tr>
          <td>
            <i>'.constant($game->sprache("TEXT4")).'</i>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
    ');
    }
}
?>
