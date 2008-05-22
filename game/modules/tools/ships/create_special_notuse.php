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

$game->out('<span class="caption">Create Ships Special</span><br><span class="sub_caption2">(Use with caution)</span><br><br>');


if(isset($_POST['submit'])) {

    $template = $_POST['template'];

    $n_ships = (int)$_POST['n_ships'];

    $user_name = $_POST['user_name'];


    if(empty($template))
        message(NOTICE, 'Ship template name is missing!');

    if($n_ships <= 0)
        message(NOTICE, 'Number of ships is invalid!');

    if(empty($user_name))
        message(NOTICE, 'Player user name is missing!');


    /**
     * Retrieve user id
     */
    $sql = 'SELECT user_id
            FROM user
            WHERE user_name="'.$user_name.'"';

    $game->out($sql.'<br>');

    if(($user = $db->queryrow($sql)) === false || !isset($user['user_id'])) {
        message(DATABASE_ERROR, 'Could not query user data');
    }

    $user_id = $user['user_id'];

    /**
     * Retreive ship template
     */
    $sql = 'SELECT *
            FROM ship_templates
            WHERE name="'.$template.'" AND owner = '.$user_id;

    $game->out($sql.'<br>');

    if(($stpl = $db->queryrow($sql)) === false || !isset($stpl['id'])) {
        message(DATABASE_ERROR, 'Could not query ship template data');
    }

    /**
     * Set crew to maximum values
     */
    $units_str = $stpl['max_unit_1'].', '.$stpl['max_unit_2'].', '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'];


    /**
     * Retreive user planets
     */
    $sql = 'SELECT planet_id FROM planets WHERE planet_owner='.$user_id;

    $game->out($sql.'<br><br>');

    $qry=$db->query($sql);

    while (($planet = $db->fetchrow($qry)) != false)
    {
        $sql = 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time, unit_1, unit_2, unit_3, unit_4)
                VALUES ('.((-1)*$planet['planet_id']).', '.$user_id.', '.$stpl['id'].', '.$stpl['value_9'].', '.$stpl['value_5'].', '.$game->TIME.', '.$units_str.')';

        /**
         * Add requested number of ships
         */
        for($i = 0; $i < $n_ships; ++$i) {
            if(!$db->query($sql)) {message(DATABASE_ERROR, 'Could not insert new ships #'.$i.' data');}
        }
    }

	$game->out('<span class="sub_caption2">Successfully created #'.$n_ships.' ships of type "'.$template.'" for each planet of user "'.$user_name.'"</span><br><br>');

    $fp = fopen(ADMIN_LOG_FILE, 'a');
    fwrite($fp, '<hr><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>Action:</b> The User <b>'.$game->player['user_name'].'</b> has generated <b>'.$n_ships.'</b> ships for Player <b>'.$user_name.' (#'.$user_id.')</b> -  from Template <b>'.$template.' (#'.$stpl['id'].')</b> on <b>all planets</b><br>');
    fclose($fp);

    $game->out('<a href="'.parse_link('a=tools/ships/create_special_notuse').'">Back</a>');
//    redirect('a=tools/ships/create_special_notuse');

}

else {




    $game->out('
        <form method="post" action="'.parse_link('a=tools/ships/create_special_notuse').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>Template Name:</td>
                <td><input class="field" type="text" name="template" value="'.$_POST['template'].'"></td>
            </tr>
            <tr>
                <td>Number:</td>
                <td><input class="field" type="text" name="n_ships"></td>
            </tr>
            <tr>
                <td>Player Name:</td>
                <td><input class="field" type="text" name="user_name"></td>
            </tr>
            <tr>
                <td colspan=2" align="center"><input class="button" type="submit" name="submit" value="Create"><td>
            </tr>
            </table>
            </td>
        </tr>
        </table>
        </form>');

}

/*Template Name:&nbsp;&nbsp;<input class="field" type="text" name="template_id"><br>
Anzahl:&nbsp;&nbsp;<input class="field" type="text" name="n_ships"><br>
Spieler:&nbsp;&nbsp;<input class="field" type="text" name="user_id"><br><br>

*/


?>

