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

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Recompute attack protection</span><br><br>');

if(isset($_POST['submit'])) {

    if(empty($_POST['days'])) {
        message(NOTICE, 'Number of days is invalid!');
    }

    $sql = 'SELECT user_id, user_registrationtime, user_attack_protection
            FROM user
            WHERE user_attack_protection = 0';

    $q_user = $db->query($sql);

    $now = time();
    $protec_time = ($_POST['days'] * 24 * 60 * 60);

    while($user = $db->fetchrow($q_user)) {
        $still_registred = ($user['user_registrationtime'] - $now);
        $still_protection = ($protec_time - $still_registred);

        if($still_protection > 0) {
            $protec_ticks = round( ($still_protection / (5 * 60)), 0);

            if($protec_ticks > $USER_ATTACK_PROTECTION) {
                continue;
            }

            $sql = 'UPDATE user
                    SET user_attack_protection = '.($ACTUAL_TICK + $protec_ticks).'
                    WHERE user_id = '.$user['user_id'];

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user <i>'.$user['user_id'].'</i>');
            }
        }
    }

    $game->out('<span class="sub_caption2">Attack protection successfully recomputed to '.$_POST['days'].' days</span><br><br>');

    $fp = fopen(ADMIN_LOG_FILE, 'a');
    fwrite($fp, '<hr><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>Action:</b> The User <b>'.$game->player['user_name'].'</b> has recomputed attack protection to <b>'.$_POST['days'].'</b> days for <b>all players</b><br>');
    fclose($fp);

    $game->out('<br><br><a href="'.parse_link('a=tools/players/recompute_attack_protection').'">Back</a>');
}
else {
    $game->out('
        <form method="post" action="'.parse_link('a=tools/players/recompute_attack_protection').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>Days:</td>
                <td><input class="field" type="text" name="days" value="'.$_POST['days'].'"></td>
            </tr>
            <tr>
                <td colspan=2" align="center"><input class="button" type="submit" name="submit" value="Submit"><td>
            </tr>
            </table>
            </td>
        </tr>
        </table>
        </form>');

}

?>
