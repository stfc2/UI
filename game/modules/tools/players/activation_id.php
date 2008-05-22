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

$game->out('<span class="caption">Activation ID</span><br><br>');

if(isset($_POST['submit'])) {
/*    $game->out('Activation ID: <b>'.md5( sqrt( (int)$_POST['user_id'] ) ).'</b>');*/

    $game->out('Activation ID: <b>'.md5( pow( (int)$_POST['user_id'],2) ).'</b>');

    $game->out('<br><br><a href="'.parse_link('a=tools/players/activation_id').'">Back</a>');
}

else {
    $game->out('
        <form method="post" action="'.parse_link('a=tools/players/activation_id').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>User ID:</td>
                <td><input class="field" type="text" name="user_id" value="'.$_POST['user_id'].'"></td>
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
