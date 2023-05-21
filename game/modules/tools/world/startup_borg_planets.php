<?php
/*    
    This file is part of STFC.it.
    Copyright 2008-2013 by Andrea Carolfi (info@stfc.it) and Cristiano Delogu

    STFC.it is based on STGC,
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

include_once('include/libs/world.php');

// Borg systems spawn in this list of sectors only
$sectors_id = array(95, 96, 103, 104, 112, 113, 121, 122, 123, 125, 130, 131, 132, 134);
// Borg startup is two five-planets systems fully settled
$fully_systems = 2;

$borg_bot = $db->queryrow('SELECT * FROM borg_bot WHERE id = 1');


for($i = 0; $i < $fully_systems; $i++) {
    // pick a random sector_id from the list
    $picked_sector_id = $sectors_id[array_rand($sectors_id)];
    // Create a new system
    $_system_data = create_system('sector', $picked_sector_id, 1); // System is created with 8 slots but we use 5
    $game->out('.. System '.$_system_data[0].' has been created<br>');
    // Planets Loop
    for($ii = 0; $ii < 5; $ii++){
        $_temp = create_planet(0, 'system', $_system_data[0]); // It's a totally random planet, wish you well, Borg Queen
        $game->out('....  Planet '.$_temp.' has been created<br>');
        $sql = 'UPDATE planets SET npc_last_action = 0,
                                   planet_name = "Unimatrix #'.$_temp.'",
                                   planet_owner = '.BORG_USERID.',
                                   planet_available_points = 677,
                                   planet_owned_date = '.(time() + $i*10 + $ii).',
                                   resource_1 = 50000,
                                   resource_2 = 50000,
                                   resource_3 = 50000,
                                   resource_4 = 1000,
                                   research_3 = 9,
                                   research_4 = 9,
                                   research_5 = 9,
                                   recompute_static = 1,
                                   building_1 = 9,
                                   building_2 = 9,
                                   building_3 = 9,
                                   building_4 = 9,
                                   building_5 = 9,
                                   building_6 = 9,
                                   building_7 = 9,
                                   building_8 = 9,
                                   building_9 = 9,
                                   building_10 = 9,
                                   building_11 = 9,
                                   building_12 = 9,
                                   building_13 = 9,
                                   unit_1 = 200,
                                   unit_2 = 100,
                                   unit_3 = 30,
                                   unit_4 = 9,
                                   unit_5 = 0,
                                   unit_6 = 0,
                                   workermine_1 = 100,
                                   workermine_2 = 100,
                                   workermine_3 = 100 
                               WHERE planet_id = '.$_temp;
        if(!$db->query($sql)) message(DATABASE_ERROR, '<b>Error:</b> Could not update new borg planet');
        
        $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships, alert_phase, homebase)
                                        VALUES ("Fleet Node#'.$_temp.'", '.BORG_USERID.', '.$_temp.', 0, 1, 2, '.$_temp.')';

        if(!$db->query($sql)) {message(DATABASE_ERROR, '<b>Error:</b> Could not create new fleet');}

        $fleet_id = $db->insert_id();
        
        $sql = 'SELECT max_unit_1, max_unit_2, max_unit_3, max_unit_4, rof, max_torp,
                       value_5, value_9
                FROM `ship_templates` WHERE `id` = '.$borg_bot['ship_template2'];
        if(($stpl = $db->queryrow($sql)) === false)
            message(DATABASE_ERROR, '<b>Error:</b> Could not query Borg Tactical Cube template data - '.$sql);

        $sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                                  rof, torp, unit_1, unit_2, unit_3, unit_4)
               VALUES ('.$fleet_id.', '.BORG_USERID.', '.$borg_bot['ship_template2'].', '.$stpl['value_9'].',
                       '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].',
                       '.$stpl['max_unit_1'].', '.$stpl['max_unit_2'].',
                       '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'].')';
        if(!$db->query($sql)) {
                message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Tactical cube data');
        }        
    }
    
}
    
$game->out('Done!!!');

?>

