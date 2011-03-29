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



function make_query_str($table, &$data) {
    $fields_array = $values_array = array();
    
    foreach($data as $column => $row) {
        $fields_array[] = $column;
        $values_array[] = '"'.$row.'"';
    }

    return '
INSERT INTO '.$table.' ('.implode(',', $fields_array).')
VALUES ('.implode(',', $values_array).')
    ';
}

$game->init_player();

check_auth(STGC_DEVELOPER);

if(isset($_POST['submit'])) {

    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT *
            FROM user
            WHERE user_id = '.$user_id;
            
    if(($user = $db->queryrow($sql, MYSQL_ASSOC)) === false) {
        message(DATABASE_ERROR, 'Could not query main user data');
    }

    if(empty($user['user_id'])) {
        message(NOTICE, 'The player doesn&#146;t exist');
    }

    echo make_query_str('user', $user).'

    UPDATE ship_templates
    SET removed = 0
    WHERE owner = '.$user_id.'

    INSERT INTO user_templates (user_id, user_template)
    SELECT 1, skin_html FROM skins ORDER BY skin_id ASC LIMIT 1;
    ';

    unset($user);

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE user_id = '.$user_id;

    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }

    while($fleet = $db->fetchrow($q_fleets, MYSQL_ASSOC)) {
        echo make_query_str('ship_fleets', $fleet);
    }

    unset($fleet);

    $sql = 'SELECT *
            FROM ships
            WHERE user_id = '.$user_id;

    if(!$q_ships = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query ships data');
    }

    while($ship = $db->fetchrow($q_ships, MYSQL_ASSOC)) {
        echo make_query_str('ships', $ship);
    }

    unset($ship);

    $sql = 'SELECT *
            FROM user_diplomacy
            WHERE user1_id = '.$user_id.' OR
                  user2_id = '.$user_id;

    if(!$q_udiplomacy = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query user diplomacy data');
    }

    while($udiplomacy = $db->fetchrow($q_udiplomacy, MYSQL_ASSOC)) {
        echo make_query_str('user_diplomacy', $udiplomacy);
    }

    $sql = 'SELECT *
            FROM tc_coords_memo
            WHERE user_id = '.$user_id;

    if(!$q_tcm = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query tc coords memo');
    }

    while($tcm = $db->fetchrow($q_tcm, MYSQL_ASSOC)) {
        echo make_query_str('tc_coords_memo', $tcm);
    }

    echo "\n\n";
}
else {
    $game->out('
        <form method="post" action="'.parse_link('a=tools/players/dump_user').'">
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
