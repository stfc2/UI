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

$game->out('<span class="caption">Deliver resources</span><br><br>');

if(isset($_POST['submit'])) {

    if(empty($_POST['ticks'])) {
        message(NOTICE, 'Resources per ticks is invalid!');
    }

    $sql = ' UPDATE planets
             SET resource_1 = resource_1 + (add_1 * '.$_POST['ticks'].'),
                 resource_2 = resource_2 + (add_2 * '.$_POST['ticks'].'),
                 resource_3 = resource_3 + (add_3 * '.$_POST['ticks'].'),
                 resource_4 = resource_4 + (add_4 * '.$_POST['ticks'].')';

    $db->query($sql);

    $sql = 'UPDATE planets
            SET resource_1 = max_resources
            WHERE resource_1 > max_resources';

    $db->query($sql);

    $sql = 'UPDATE planets
            SET resource_2 = max_resources
            WHERE resource_2 > max_resources';

    $db->query($sql);

    $sql = 'UPDATE planets
            SET resource_3 = max_resources
            WHERE resource_3 > max_resources';

    $db->query($sql);

    $sql = 'UPDATE planets
            SET resource_4 = max_worker
            WHERE resource_4 > max_worker';

    $db->query($sql);

    $game->out('<span class="sub_caption2">Successfully delivered #'.$_POST['ticks'].' resources of each type for all players</span><br><br>');

    $fp = fopen(ADMIN_LOG_FILE, 'a');
    fwrite($fp, '<hr><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>Action:</b> The User <b>'.$game->player['user_name'].'</b> has delivered <b>'.$_POST['ticks'].'</b> resources of <b>all types</b> for <b>all players</b><br>');
    fclose($fp);

    $game->out('<br><br><a href="'.parse_link('a=tools/players/deliver_resources').'">Back</a>');
}
else {
    $game->out('
        <form method="post" action="'.parse_link('a=tools/players/deliver_resources').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>Ticks:</td>
                <td><input class="field" type="text" name="ticks" value="'.$_POST['ticks'].'"></td>
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
