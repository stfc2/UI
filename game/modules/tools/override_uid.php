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

$game->out('<span class="caption">Override User ID</span><br><br>');


if( ($game->player['user_auth_level'] != STGC_DEVELOPER) && (!defined('OVERRIDE_UID_MODE')) ) {
    exit;
}

if(!empty($_POST['submit'])) {
    $user_id = (defined('OVERRIDE_UID_MODE')) ? OVERRIDE_UID_MODE : $game->player['user_id'];
    
    
    $user=$db->queryrow('SELECT user_id FROM user WHERE user_name="'.$_POST['override_uid'].'"');
    if (isset($user['user_id']))
    {
    $sql = 'UPDATE user
            SET user_override_uid = '.(int)$user['user_id'].'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user override data');
    }
    
    }
    else
    {
    $sql = 'UPDATE user
            SET user_override_uid = '.(int)$_POST['override_uid'].'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user override data');
    }
    }
    
    redirect('a=tools/override_uid');
}

$overridden_id = (defined('OVERRIDE_UID_MODE')) ? $game->player['user_id'] : $game->player['user_override_uid'];

$game->out('
        <form method="post" action="'.parse_link('a=tools/override_uid').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>Login as:</td>
                <td><input class="field" type="text" name="override_uid" size="5" value="'.$overridden_id.'"></td>
            </tr>
            <tr>
                <td colspan=2" align="center"><input class="button" type="submit" name="submit" value="Apply"><td>
            </tr>
            </table>
            </td>
        </tr>
        </table>
        </form>');

?>
