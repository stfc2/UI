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

include_once('include/libs/world.php');


$game->init_player();

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Encourage user</span><br><br>');

if(isset($_POST['submit'])) {

    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT *
            FROM user
            WHERE user_id = '.$user_id;
            
    if(($user = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query main user data');
    }

    if(empty($user['user_id'])) {
        message(NOTICE, 'The player doesn&#146;t exist');
    }

    // 1. Home world fully developed
    $sql = 'UPDATE planets SET
                research_1   = '.$MAX_RESEARCH_LVL[1][0].',
                research_2   = '.$MAX_RESEARCH_LVL[1][1].',
                research_3   = '.$MAX_RESEARCH_LVL[1][2].',
                research_4   = '.$MAX_RESEARCH_LVL[1][3].',
                research_5   = '.$MAX_RESEARCH_LVL[1][4].',
                building_1   = '.$MAX_BUILDING_LVL[1][0].',
                building_2   = '.$MAX_BUILDING_LVL[1][1].',
                building_3   = '.$MAX_BUILDING_LVL[1][2].',
                building_4   = '.$MAX_BUILDING_LVL[1][3].',
                building_5   = '.$MAX_BUILDING_LVL[1][4].',
                building_6   = '.$MAX_BUILDING_LVL[1][5].',
                building_7   = '.$MAX_BUILDING_LVL[1][6].',
                building_8   = '.$MAX_BUILDING_LVL[1][7].',
                building_9   = '.$MAX_BUILDING_LVL[1][8].',
                building_10  = '.($MAX_BUILDING_LVL[1][9]+$MAX_RESEARCH_LVL[1][2]).',
                building_11  = '.$MAX_BUILDING_LVL[1][10].',
                building_12  = '.$MAX_BUILDING_LVL[1][11].',
                building_13  = '.($MAX_BUILDING_LVL[1][12]+$MAX_RESEARCH_LVL[1][2]).',
                workermine_1 = 1600,
                workermine_2 = 1600,
                workermine_3 = 1600
            WHERE planet_id = '.$user['user_capital'];

    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user capital data');
    }

    $game->out('Home world '.$user['user_capital'].' of user '.$user_id.' fully developed.<br>');
    //

    // 2. Fleets reconstructed:
    //     - 100 cargos
    //     - 10 colos
    //     - 250 hull 8
    //     - 100 hull 12
    for($t = 0;$t < 4;$t++)
    {
        switch($t)
        {
            // 2.1. One hundred cargos (basic template)
            case 0:
                $num = 100;
                $torso = 1;
            break;
            // 2.2. Ten colo (basic template)
            case 1:
                $num = 10;
                $torso = 2;
            break;
            // 2.3. Two hundred and fifty hull 8 (basic template)
            case 2:
                $num = 250;
                $torso = 7;
            break;
            // 2.3. One hundred hull 12 (basic template)
            case 3:
                $num = 100;
                $torso = 11;
            break;
        }

        $sql= 'SELECT * FROM `ship_templates` WHERE `owner` = 10 AND ship_torso = '.$torso.' AND removed = 0 LiMIT 1';
        if(($stpl = $db->queryrow($sql)) === false)
            message(DATABASE_ERROR, 'Could not query template data');

        // Check if basic template exists
        if(empty($stpl)) {
            message(DATABASE_ERROR, 'Cannot find ship '.$torso.' template!');
        }

        $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships)
                VALUES ("Encouraging_hull'.($torso+1).'", '.$user_id.', '.$user['user_capital'].', 0, '.$num.')';
                    
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new fleets data');
        }

        $fleet_id = $db->insert_id();

        if(!$fleet_id) {
            message(GENERAL, 'Error', '$fleet_id = empty');
        }

        $sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                              rof, torp, unit_1, unit_2, unit_3, unit_4)
           VALUES ('.$fleet_id.', '.$user_id.', '.$stpl['id'].', '.$stpl['value_9'].',
                   '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].', 
                   '.$stpl['min_unit_1'].', '.$stpl['min_unit_2'].',
                   '.$stpl['min_unit_3'].', '.$stpl['min_unit_4'].')';
        for($i = 0; $i < $num; ++$i)
        {
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not insert new ship data');
            }
        }
        $game->out('Created '.$num.' torso '.$torso.' ships for user '.$user_id.'<br>');
    }
    //

    // 3. Trade center account with:
    //     - 5.000.000 units of metal/min/dilithium
    //     - 5000 lv1 
    //     - 3000 lv2 
    //     - 1500 lv3
    //     - 500 lev4
    //     - 5000 lev5 
    //     - 2500 lev6
    $sql = 'INSERT INTO schulden_table (user_ver, user_kauf, status)
            VALUES ('.$user_id.', 10, 1)';

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new debt table');
    }

    $debt_id = $db->insert_id();

    if(!$debt_id) {
        message(GENERAL, 'Error', '$debt_id = empty');
    }

    $sql = 'INSERT INTO treuhandkonto (code, ress_1, ress_2, ress_3, unit_1, unit_2, unit_3, unit_4, unit_5, unit_6)
            VALUES ('.$debt_id.', 5000000, 5000000, 5000000, 5000, 3000, 1500, 500, 5000, 2500)';

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new trade center account');
    }

    $account_id = $db->insert_id();

    $game->out('Created trade center account '.$account_id.' for user '.$user_id.'<br>');
    //
    
    // 4. Give the player 20 planets
    $planets_to_go = 20;

    // #############################################################################
    // We need the number of planets, which owns the colonizer
    // (we want to determine planet_owner_enum surely)

    $sql = 'SELECT COUNT(planet_id) AS n_planets
            FROM planets
            WHERE planet_owner = '.$user_id;

    if(($pcount = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query planets count data! CONTINUE USING INSTABLE VALUE');

        $n_planets = $user['user_planets'];
    }
    else {
        $n_planets = $pcount['n_planets'];
    }

    // Check first in the solar system of the capital
    $sql = 'SELECT system_id,sector_id FROM planets WHERE planet_id = '.$user['user_capital'];
    if(($capital_system = $db->queryrow($sql)) === false)
        message(DATABASE_ERROR, 'Could not query capital solar system data');

    $sql = 'SELECT planet_id FROM `planets` 
            WHERE system_id = '.$capital_system['system_id'].' AND planet_owner = 0';

    if(!$q_planets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query planets data');
    }

    while($planet = $db->fetchrow($q_planets)) {

        $sql = 'UPDATE planets
                SET planet_owner = '.$user_id.',
                    planet_owned_date = '.time().',
                    planet_owner_enum = '.($n_planets - 1).',
                    planet_available_points = '.$MAX_POINTS[0].',
                    research_1 = 0,
                    research_2 = 0,
                    research_3 = 0,
                    research_4 = 0,
                    research_5 = 0,
                    resource_1 = 50,
                    resource_2 = 50,
                    resource_3 = 0,
                    resource_4 = 10,
                    recompute_static = 1,
                    building_1 = 1,
                    building_2 = 0,
                    building_3 = 0,
                    building_4 = 0,
                    building_5 = 0,
                    building_6 = 0,
                    building_7 = 0,
                    building_8 = 0,
                    building_9 = 0,
                    building_10 = 0,
                    building_11 = 0,
                    building_12 = 0,
                    building_13 = 0,
                    unit_1 = ceil(pow(planet_owner_enum*'.MIN_TROOPS_PLANET.',1+planet_owner_enum*0.01)/2),
                    unit_2 = 0,
                    unit_3 = 0,
                    unit_4 = 0,
                    unit_5 = 0,
                    unit_6 = 0,
                    workermine_1 = 100,
                    workermine_2 = 100,
                    workermine_3 = 100,
                    catresearch_1 = 0,
                    catresearch_2 = 0,
                    catresearch_3 = 0,
                    catresearch_4 = 0,
                    catresearch_5 = 0,
                    catresearch_6 = 0,
                    catresearch_7 = 0,
                    catresearch_8 = 0,
                    catresearch_9 = 0,
                    catresearch_10 = 0,
                    unittrainid_1 = 0,
                    unittrainid_2 = 0,
                    unittrainid_3 = 0,
                    unittrainid_4 = 0,
                    unittrainid_5 = 0,
                    unittrainid_6 = 0,
                    unittrainid_7 = 0,
                    unittrainid_8 = 0,
                    unittrainid_9 = 0,
                    unittrainid_10 = 0,
                    unittrainnumber_1 = 0,
                    unittrainnumber_2 = 0,
                    unittrainnumber_3 = 0,
                    unittrainnumber_4 = 0,
                    unittrainnumber_5 = 0,
                    unittrainnumber_6 = 0,
                    unittrainnumber_7 = 0,
                    unittrainnumber_8 = 0,
                    unittrainnumber_9 = 0,
                    unittrainnumber_10 = 0,
                    unittrainnumberleft_1 = 0,
                    unittrainnumberleft_2 = 0,
                    unittrainnumberleft_3 = 0,
                    unittrainnumberleft_4 = 0,
                    unittrainnumberleft_5 = 0,
                    unittrainnumberleft_6 = 0,
                    unittrainnumberleft_7 = 0,
                    unittrainnumberleft_8 = 0,
                    unittrainnumberleft_9 = 0,
                    unittrainnumberleft_10 = 0,
                    unittrain_actual = 0,
                    unittrainid_nexttime=0,
                    planet_surrender=0
                WHERE planet_id = '.$planet['planet_id'];

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update planets data!');
        }

        // #############################################################################
        // Add History Record in planet details; log_code = 25 

        $sql = 'INSERT INTO planet_details (planet_id, user_id, alliance_id, source_uid, source_aid, timestamp, log_code)
                VALUES ('.$planet['planet_id'].', '.$user_id.', '.$user['user_alliance'].', '.$user_id.', '.$user['user_alliance'].', '.time().', 25)';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new planet details data!');
        }

        $n_planets++;
        $planets_to_go--;
    }

    // Then create the others
    while($planets_to_go > 0) {
        // Create the system
        $_temp = create_system('sector', $capital_system['sector_id'], 0);
        $_system_id = $_temp[0];

        $game->out('Created system: '.$_system_id.'<br>');
        
        // Retrieve available slots
        $sql = 'SELECT system_max_planets FROM starsystems WHERE system_id = '.$_system_id;
        if(($new_system = $db->queryrow($sql)) === false)
            message(DATABASE_ERROR, 'Could not query solar system data');

        $game->out('Available slots: '.$new_system['system_max_planets'].'<br>');

        // Fill all the slots available
        for($p = 0;$p < $new_system['system_max_planets'];$p++) {
            $planet_id = create_planet(0, 'system', $_system_id);

            $game->out('Created planet: '.$planet_id.'<br>');
            
            // Update required security forces
            $sql = 'UPDATE planets
                    SET planet_owner = '.$user_id.',
                        planet_owned_date = '.time().',
                        planet_owner_enum = '.($n_planets - 1).',
                        planet_available_points = '.$MAX_POINTS[0].',
                        unit_1 = ceil(pow(planet_owner_enum*'.MIN_TROOPS_PLANET.',1+planet_owner_enum*0.01)/2)
                    WHERE planet_id = '.$planet_id;

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update planets data!');
            }

            $game->out('Updated required security troops of planet: '.$planet_id.'<br>');

            // #############################################################################
            // Add History Record in planet details; log_code = 25 

            $sql = 'INSERT INTO planet_details (planet_id, user_id, alliance_id, source_uid, source_aid, timestamp, log_code)
                    VALUES ('.$planet_id.', '.$user_id.', '.$user['user_alliance'].', '.$user_id.', '.$user['user_alliance'].', '.time().', 25)';

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not insert new planet details data!');
            }

            $game->out('Created planet details.<br>');

            $n_planets++;
            $planets_to_go--;

            $game->out('Owned planets: '.$n_planets.' planets to be created: '.$planets_to_go.'<br>');

            // Check if the last system shouldn't be filled
            if($planets_to_go == 0)
                break;
        }
    }

    $sql = 'UPDATE user
            SET user_planets = '.$n_planets.'
            WHERE user_id = '.$user_id;
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user data!');
    }
    //
}
else {
    $game->out('
        <form method="post" action="'.parse_link('a=tools/players/encourage_user').'">
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td>User ID:</td>
                <td><input class="field" type="text" name="user_id" value=""></td>
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
