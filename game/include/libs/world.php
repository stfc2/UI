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



function create_system($id_type, $id_value, $is_mother) {
    global $db, $game;

    $sector_id = $system_x = $system_y = 0;
    
    $sector_allowed = array(
        1 => '21, 23, 25, 27, 31, 33, 35, 39, 41, 43, 45, 49, 51, 53, 57, 59, 61, 63, 67, 69, 71, 75, 77, 79, 81',
        2 => '100, 102, 104, 106, 110, 112, 114, 118, 120, 122, 124, 128, 130, 132, 136, 138, 140, 142, 146, 148, 150, 154, 156, 158, 160',
        3 => '165, 167, 169, 171, 175, 177, 179, 183, 185, 187, 189, 193, 195, 197, 201, 203, 205, 207, 211, 213, 215, 219, 221, 223, 225',
        4 => '244, 246, 248, 250, 254, 256, 258, 262, 264, 266, 268, 272, 274, 276, 280, 282, 284, 286, 290, 292, 294, 298, 300, 302, 304'
    );

    switch($id_type) {
        case 'quadrant':
            $quadrant_id = $id_value;
            
            /*
            if($is_mother == 0){
                $sql = 'SELECT *
                        FROM starsystems_slots
                        WHERE quadrant_id = '.$quadrant_id.'
                        LIMIT 1';                
            }
            else {
                $sql = 'SELECT *
                        FROM starsystems_slots
                        WHERE quadrant_id = '.$quadrant_id.'  AND
                              sector_id IN ('.$sector_allowed[$quadrant_id].') 
                        LIMIT 1';                
            }
            */

            $sql = 'SELECT * FROM starsystems_slots WHERE quadrant_id = '.$quadrant_id.' LIMIT 1';

            if(($free_slot = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_system(): Could not query starsystem slots');
            }

            if(!empty($free_slot['sector_id'])) extract($free_slot);
        break;

        case 'sector':
            $sql = 'SELECT *
                    FROM starsystems_slots
                    WHERE sector_id = '.$id_value.'
                    LIMIT 1';

            if(($free_slot = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_system(): Could not query starsystem slots');
            }

            if(!empty($free_slot['sector_id'])) extract($free_slot);
        break;

        case 'slot':
            $params = explode(':', $id_value);

            $sql = 'SELECT *
                    FROM starsystems_slots
                    WHERE sector_id = '.(int)$params[0].' AND
                          system_x = '.(int)$params[1].' AND
                          system_y = '.(int)$params[2].'
                    LIMIT 1';

            if(($free_slot = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_system(): Could not query starsystem slots');
            }

            if(!empty($free_slot['sector_id'])) extract($free_slot);
        break;
    }

    if(empty($sector_id)) {
        message(GENERAL, 'System could not be created', 'world::create_system(): $sector_id = empty');
    }

    $star_base_color = mt_rand(0, 11);

    switch($star_base_color) {
        // Blue star
        case 0:
            $low_range = (int)($game->starsize_range[1]-3);
            $high_range = (int)($game->starsize_range[1]);
            $star_color = array(mt_rand(0, 25), mt_rand(0, 25), mt_rand(150, 255));
            $star_type = 'b';
        break;

        // White Star
        case 1:
        case 2:
            $low_range = (int)($game->starsize_range[1]-8);
            $high_range = (int)($game->starsize_range[1]-4);            
            $star_color = array(mt_rand(220, 255), mt_rand(235, 255), mt_rand(245, 255));
            $star_type = 'a';                        
        break;

        // Yellow Star
        case 3:
        case 4:
        case 5:
            $low_range = (int)($game->starsize_range[0]+4);
            $high_range = (int)($game->starsize_range[1]-8);            
            $star_color = array(mt_rand(200, 255), mt_rand(50, 150), mt_rand(0, 25));       
            $star_type = 'g';            
        break;

        // Red Star
        case 6:
        case 7:
        case 8:
        case 9:
        case 10:
            $low_range = (int)($game->starsize_range[0]);
            $high_range = (int)($game->starsize_range[0]+4);            
            $star_color = array(mt_rand(150, 255), mt_rand(0, 25), mt_rand(0, 25));    
            $star_type = 'm';
        break;

        // Brown (old) Star
        case 11:
            $low_range = (int)($game->starsize_range[0]);
            $high_range = (int)($game->starsize_range[0]+4);             
            $star_color = array(mt_rand(100, 150), mt_rand(40, 80), mt_rand(0, 15));      
            $star_type = 'l';            
        break;
    }    

    $star_size = mt_rand($low_range, $high_range);         

    $required_borders = ($game->sector_map_split - 1);
    $px_per_field = ( ($game->sector_map_size - $required_borders) / $game->sector_map_split);

    $root_x = ($px_per_field * ($system_x - 1) ) + ($system_x - 1);
    $root_y = ($px_per_field * ($system_y - 1) ) + ($system_y - 1);

    $border_distance = $px_per_field / 4;
    $border_distance = max($border_distance, ( ($star_size * 0.45) + 3 ) );

    $system_map_x = mt_rand( ($root_x + $border_distance), $root_x + ($px_per_field - $border_distance) );
    $system_map_y = mt_rand( ($root_y + $border_distance), $root_y + ($px_per_field - $border_distance) );

    $system_coords = $game->get_system_gcoords($system_x, $system_y, $sector_id);
    
    $orion_chance = rand(1,100);            
    if($orion_chance >= 96) {
        // AAA
        $orion_alert = 4;
    }elseif($orion_chance >= 91){
        // AA
        $orion_alert = 3;
    }elseif($orion_chance >= 76){
        // A
        $orion_alert = 2;
    }elseif($orion_chance >= 51) {
        // B
        $orion_alert = 1;
    }else {
        // C
        $orion_alert = 0;
    }    
    
    if((int)$is_mother == 1) {
        $max_planets = $game->system_max_planets;
        $orion_alert = 0;
    }
    else {
        $max_planets = 4 + (mt_rand(0,4)); (int)($game->system_max_planets / 2) + (mt_rand(0,(int)($game->system_max_planets / 2)));
    }

    $sql = 'INSERT INTO starsystems (system_name, sector_id, system_x, system_y, system_map_x, system_map_y, system_global_x, system_global_y, system_starcolor_red, system_starcolor_green, system_starcolor_blue, system_starsize, system_startype, system_max_planets, system_orion_alert)
            VALUES ("System '.$game->get_sector_name($sector_id).':'.$game->get_system_cname($system_x, $system_y).'", '.$sector_id.', '.$system_x.', '.$system_y.', '.$system_map_x.', '.$system_map_y.', '.$system_coords[0].', '.$system_coords[1].', '.$star_color[0].', '.$star_color[1].', '.$star_color[2].', '.$star_size.', "'.$star_type.'", '.$max_planets.', '.$orion_alert.')';

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_system(): Could not insert new system data');
    }

    $new_system_id = $db->insert_id();
    $sql = 'DELETE FROM starsystems_slots
            WHERE sector_id = '.$sector_id.' AND
                  system_x = '.$system_x.' AND
                  system_y = '.$system_y;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_system(): Could not delete starsystems slot data');
    }

    return array($new_system_id, $sector_id);
}

function create_home_system($type, $id_value) {
    global $db, $game;

    $race = $game->player['user_race'];
    
    $orion_alert = 0;
    
    $max_planets = $game->system_max_planets;
    
    $sector_id = $system_x = $system_y = 0;

    $quadrant_id = $id_value;

    /*
    $banned_sector_ids[] = $db->queryrowset('SELECT DISTINCT sector_id FROM starsystems WHERE system_closed > 0 ORDER BY sector_id');

    $banned_sectors_list = implode(',', $banned_sector_ids);
    */
    
    $sql = 'SELECT * FROM starsystems_slots WHERE quadrant_id = '.$quadrant_id.' AND sector_id NOT IN (SELECT DISTINCT sector_id FROM starsystems WHERE system_closed > 0 ORDER BY sector_id) LIMIT 1';    

    if(($free_slot = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'world::create_home_system(): Could not query starsystem slots');
    }

    if(!empty($free_slot['sector_id'])) extract($free_slot);

    if(empty($sector_id)) {
        message(GENERAL, 'System could not be created', 'world::create_system(): $sector_id = empty');
    }

    $star_size = mt_rand($game->starsize_range[0], $game->starsize_range[1]-6);            

    $required_borders = ($game->sector_map_split - 1);
    $px_per_field = ( ($game->sector_map_size - $required_borders) / $game->sector_map_split);

    $root_x = ($px_per_field * ($system_x - 1) ) + ($system_x - 1);
    $root_y = ($px_per_field * ($system_y - 1) ) + ($system_y - 1);

    $border_distance = $px_per_field / 4;
    $border_distance = max($border_distance, ( ($star_size * 0.45) + 3 ) );

    $system_map_x = mt_rand( ($root_x + $border_distance), $root_x + ($px_per_field - $border_distance) );
    $system_map_y = mt_rand( ($root_y + $border_distance), $root_y + ($px_per_field - $border_distance) );

    $system_coords = $game->get_system_gcoords($system_x, $system_y, $sector_id);

    $star_color = array(mt_rand(150, 255), mt_rand(0, 25), mt_rand(0, 25));

    $star_type = 'm';    
    
    $sql = 'INSERT INTO starsystems (system_name, sector_id, system_x, system_y, system_map_x, system_map_y, system_global_x, system_global_y, system_starcolor_red, system_starcolor_green, system_starcolor_blue, system_starsize, system_startype, system_max_planets, system_orion_alert)
            VALUES ("System '.$game->get_sector_name($sector_id).':'.$game->get_system_cname($system_x, $system_y).'", '.$sector_id.', '.$system_x.', '.$system_y.', '.$system_map_x.', '.$system_map_y.', '.$system_coords[0].', '.$system_coords[1].', '.$star_color[0].', '.$star_color[1].', '.$star_color[2].', '.$star_size.', "'.$star_type.'", '.$max_planets.', '.$orion_alert.')';

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_system(): Could not insert new system data');
    }

    $new_system_id = $db->insert_id();
    $sql = 'DELETE FROM starsystems_slots
            WHERE sector_id = '.$sector_id.' AND
                  system_x = '.$system_x.' AND
                  system_y = '.$system_y;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_system(): Could not delete starsystems slot data');
    }    
    
    $little_list = ['a', 'b', 'c', 'd'];
    $giant_list = ['i', 'j', 's', 't'];
    $good_hybrid_list = ['e', 'f', 'g', 'l'];
    $bad_hybrid_list = ['e', 'f', 'g', 'l', 'n', 'k', 'h'];
    
    $little_one = $little_list[array_rand($little_list)];
    $giant_one = $giant_list[array_rand($giant_list)];
    $hybrid_one = $good_hybrid_list[array_rand($good_hybrid_list)];
    $hybrid_two = $bad_hybrid_list[array_rand($bad_hybrid_list)];
    
    $to_void = $game->create_planet(0, 'system', $new_system_id, $little_one);
    $to_void = $game->create_planet(0, 'system', $new_system_id, $giant_one);
    $to_void = $game->create_planet(0, 'system', $new_system_id, $hybrid_one);
    $to_void = $game->create_planet(0, 'system', $new_system_id, $hybrid_two);

    $planet_id = $game->create_planet($game->player['user_id'],'system', $new_system_id, $type, $race);
    
    return array($new_system_id,$planet_id);
}

function create_planet($user_id, $id_type, $id_value, $selected_type = 'r', $race = 0) {
    global $db, $game, $PLANETS_DATA;

    // Planet raw materials production according to its type
    $planet_templates = array(
        'bbb' => array(-0.25, -0.25, -0.25), // max penalty -0.25 to all ress
        'bnb' => array(-0.25,     0, -0.25), // metall and latinum penalty
        'nbb' => array(    0, -0.25, -0.25), // mineral and latinum penalty
        'bbn' => array(-0.25, -0.25,     0), // metall and mineral penalty
        'nnb' => array(    0,     0, -0.25),
        'nbn' => array(    0, -0.25,     0),
        'bnn' => array(-0.25,     0,     0),
        'nnn' => array(    0,     0,     0), // neutral
        'gnn' => array( 0.25,     0,     0),
        'ngn' => array(    0,  0.25,     0),
        'nng' => array(    0,     0,  0.25),
        'ggn' => array( 0.25,  0.25,     0), // bonus to metal and mineral
        'ngg' => array(    0,  0.25,  0.25), // bonus to mineral and latinum
        'gng' => array( 0.25,     0,  0.25), // bonus to metal and latinum
        'ggg' => array( 0.25,  0.25,  0.25)  // max bonsu 0.25 to all ress
    );

    // Planet type probability according to its orbit
    $planet_type_probabilities = array(
        // Orbil level 0
        0 => array(
            'a' => 300,
            'b' => 350,
            'c' => 100,
            'd' => 100,
            's' => 50,
            't' => 40,
            'x' => 40,
            'y' => 20
        ),
        // Orbit level 1
        1 => array(
            'a' => 300,
            'b' => 350,
            'c' => 100,
            'd' => 100,
            's' => 50,
            't' => 40,
            'x' => 40,
            'y' => 20
        ),
        // Orbit level 2
        2 => array(
            'a' => 20,
            'c' => 80,
            'd' => 80,
            'e' => 150,
            'f' => 130,
            'g' => 80,
            'h' => 130,
            'k' => 110,
            'l' => 40,
            'm' => 20,
            'n' => 140,
            'o' => 20
        ),
        // Orbit level 3
        3 => array(
            'a' => 10,
            'c' => 50,
            'd' => 50,
            'e' => 120,
            'f' => 150,
            'g' => 150,
            'h' => 90,
            'k' => 80,
            'l' => 90,
            'm' => 45,
            'n' => 100,
            'o' => 45,
            'p' => 30
        ),
        // Orbit level 4
        4 => array(
            'a' => 10,
            'c' => 40,
            'd' => 40,
            'e' => 130,
            'f' => 200,
            'g' => 210,
            'h' => 100,
            'k' => 80,
            'l' => 50,
            'm' => 30,
            'n' => 40,
            'o' => 30,
            'p' => 40
        ),
        // Orbit level 5
        5 => array(
            'a' => 30,
            'c' => 80,
            'd' => 80,
            'e' => 80,
            'f' => 140,
            'g' => 140,
            'h' => 80,
            'i' => 50,
            'j' => 50,            
            'k' => 60,
            'l' => 80,
            'n' => 10,
            'p' => 45,
            's' => 50,
            't' => 15            
        ),
        // Orbit level 6
        6 => array(
            'a' => 60,
            'c' => 100,
            'd' => 100,
            'i' => 220,
            'j' => 230,
            's' => 140,
            't' => 140
        ),
        // Orbit level 7
        7 => array(
            'a' => 60,
            'c' => 220,
            'd' => 230,
            'i' => 140,
            'j' => 140,
            's' => 100,
            't' => 100
        )
    );

    $system_id = $sector_id = 0;

    switch($id_type) {
        case 'quadrant':
            $quadrant_id = $id_value;

            // Verify that a suitable system already exists

            // In one of 5 cases it creates in any case a new system
            if(mt_rand(1, 5) != 3) {
                $sector_id_min = ( ($quadrant_id - 1) * $game->sectors_per_quadrant) + 1; // (id - 1) * 81
                $sector_id_max = $quadrant_id * $game->sectors_per_quadrant; // id * 81

                $sql = 'SELECT system_id, sector_id, system_n_planets
                        FROM starsystems
                        WHERE sector_id >= '.$sector_id_min.' AND
                              sector_id <= '.$sector_id_max.' AND
                              system_closed = 0 AND
                              system_n_planets < system_max_planets';

                if(($q_systems = $db->query($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query systems data');
                }

                $available_systems = array();
                $n_available = 0;

                while($system = $db->fetchrow($q_systems)) {
                    $available_systems[] = array($system['sector_id'], $system['system_id']);

                    //if( ++$n_available > 30) break;
                }

                // Check if there are available systems!
                if (!empty($available_systems)) {
                    $chosen_system = $available_systems[array_rand($available_systems)];

                    $sector_id = $chosen_system[0];
                    $system_id = $chosen_system[1];
                }
            }

            // If a new system must be created ($system_id = 0), then it's orbitals are all free
            // (in the Alpha-2 it has nevertheless searched * roll *) )
            // Otherwise, a free search

            $free_distances = $game->planet_distances;

            if(!$system_id) {
                $_temp = create_system('quadrant', $quadrant_id, 0);

                $system_id = $_temp[0];
                $sector_id = $_temp[1];
            }
            else {
                $sql = 'SELECT planet_distance_id
                        FROM planets
                        WHERE system_id = '.$system_id;

                if(($planet_did = $db->queryrowset($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query planets did data');
                }

                for($i = 0; $i < count($planet_did); ++$i) {
                    unset($free_distances[$planet_did[$i]['planet_distance_id']]);
                }

                if(empty($free_distances)) {
                    message(GENERAL, 'Planet could not be created', 'world::create_planet(): $free_distances[] = empty');
                }
            }
        break;
        
        case 'sector':
            $sector_id = $id_value;

            // Verify that a suitable system already exists

            // In one of 3 cases it creates in any case a new system
            if(mt_rand(1, 3) != 2) {
                $sql = 'SELECT system_id, sector_id, system_n_planets, system_max_planets
                        FROM starsystems
                        WHERE sector_id >= '.$sector_id.' AND
                              system_closed = 0';

                if(($q_systems = $db->query($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query systems data');
                }

                while($system = $db->fetchrow($q_systems)) {
                    if($system['system_n_planets'] > $system['system_max_planets']) {
                        stgc_log('world', 'System '.$system['system_id'].' has '.$system['system_n_planets']);
                    }
                    elseif($system['system_n_planets'] < $system['system_max_planets']) {
                        $system_id = $system['system_id'];
                        $sector_id = $system['sector_id'];
                        break;
                    }
                }
            }

            // If a new system must be created ($system_id = 0), then it's orbitals are all free
            // (in the Alpha-2 it has nevertheless searched * roll *) )
            // Otherwise, a free search

            $free_distances = $game->planet_distances;

            if(!$system_id) {
                $_temp = create_system('sector', $sector_id, 0);

                $system_id = $_temp[0];
                //$sector_id = $_temp[1];
            }
            else {
                $sql = 'SELECT planet_distance_id
                        FROM planets
                        WHERE system_id = '.$system_id;

                if(($planet_did = $db->queryrowset($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query planets did data');
                }

                for($i = 0; $i < count($planet_did); ++$i) {
                    unset($free_distances[$planet_did[$i]['planet_distance_id']]);
                }

                if(empty($free_distances)) {
                    message(GENERAL, 'Planet could not be created', 'world::create_planet(): $free_distances[] = empty');
                }
            }
        break;

        case 'system':
            $free_distances = $game->planet_distances;
            $system_id = $id_value;

            // NOTE: The system chosen must exist
            /*
            $sql = 'SELECT sector_id, planet_distance_id
                    FROM planets
                    WHERE system_id = '.$system_id;
            */

            /* 16/06/08 - AC: First of all, obtain sector ID, starsystem may be empty! */
            $sql = 'SELECT sector_id
                    FROM starsystems
                    WHERE system_id = '.$system_id;

            if(($system = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_planet(): Could not query sector did data');
            }

            $sector_id = $system['sector_id'];

            /* 16/06/08 - AC: then check for already occupied planet slot */
            $sql = 'SELECT planet_distance_id
                    FROM planets
                    WHERE system_id = '.$system_id;

            if(($planet_did = $db->queryrowset($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_planet(): Could not query planet did data');
            }

            for($i = 0; $i < count($planet_did); ++$i) {
                unset($free_distances[$planet_did[$i]['planet_distance_id']]);
            }
        break;
    }

    $planet_distance_id = array_rand($free_distances);
    $planet_distance_px = mt_rand($game->planet_distances[$planet_distance_id][0], $game->planet_distances[$planet_distance_id][1]);

    // Create!

    if($user_id == 0) {
        if($selected_type != 'r') {
            $planet_type = $selected_type; 
        }
        else 
        {
            $type_array = array();

            foreach($planet_type_probabilities[$planet_distance_id] as $type => $probability) {
                for($i = 0; $i < $probability; ++$i) {
                    $type_array[] = $type;
                }
            }
            $planet_type = $type_array[array_rand($type_array)];

            $type_probabilities = array(
                'bbb' => 3,
                'bbn' => 7,
                'bnb' => 7,
                'nbb' => 10,
                'bnn' => 18,
                'nbn' => 18,
                'nnb' => 24,
                'nnn' => 800,
                'gnn' => 28,
                'ngn' => 25,
                'nng' => 18,
                'ggn' => 14,
                'ngg' => 10,
                'gng' => 12,
                'ggg' => 6, 
            );

            $template_array = array();

            foreach($type_probabilities as $type => $probability) {
                for($i = 0; $i < $probability; ++$i) {
                    $template_array[] = $type;
                }
            }

            $planet_template = $template_array[array_rand($template_array)];            
        }

        // Random variance of the constants basis of the planet
        $rateo_1 = round(($PLANETS_DATA[$planet_type][0] + $planet_templates[$planet_template][0]), 2);
        if($rateo_1 < 0.1) $rateo_1 = 0.1;
        $rateo_2 = round(($PLANETS_DATA[$planet_type][1] + $planet_templates[$planet_template][1]), 2);
        if($rateo_2 < 0.1) $rateo_2 = 0.1;
        $rateo_3 = round(($PLANETS_DATA[$planet_type][2] + $planet_templates[$planet_template][2]), 2);
        if($rateo_3 < 0.1) $rateo_3 = 0.1;
        $rateo_4 = $PLANETS_DATA[$planet_type][3];

        $sql = 'INSERT INTO planets (planet_name, system_id, sector_id, planet_type, planet_owner, planet_owned_date, planet_distance_id, planet_distance_px, planet_covered_distance, planet_tick_cdistance, planet_max_cdistance, resource_1, resource_2, resource_3, resource_4, planet_points, rateo_1, rateo_2, rateo_3, rateo_4)
                VALUES ("'.UNINHABITATED_PLANET.'", '.$system_id.', '.$sector_id.', "'.$planet_type.'", 0, '.$game->TIME.', '.$planet_distance_id.', '.$planet_distance_px.', 0, '.( mt_rand(10, 30) ).', '.( 2 * M_PI * $planet_distance_px ).', 0, 0, 0, 0, 0, '.$rateo_1.', '.$rateo_2.', '.$rateo_3.', '.$rateo_4.')';
    }
    else {
        // If player selected a specific planet type
        if ($selected_type != 'r')
            $planet_type = $selected_type;
        else
            $planet_type = (mt_rand(1, 2) == 1) ? 'm' : 'o';

        $rateo_1 = $PLANETS_DATA[$planet_type][0];
        $rateo_2 = $PLANETS_DATA[$planet_type][1];
        $rateo_3 = $PLANETS_DATA[$planet_type][2];
        $rateo_4 = $PLANETS_DATA[$planet_type][3];

        // Ok, let's boost new players a bit
        if(USER_START_BOOST && $game->player['user_first_boost'] == 0) {

            $db->query('UPDATE user SET user_first_boost = 1 WHERE user_id = '.$game->player['user_id']);
            
            global $MAX_BUILDING_LVL,$MAX_RESEARCH_LVL,$RACE_DATA,$MAX_POINTS;
            $sql = 'INSERT INTO planets
                        (planet_name,
                        system_id,
                        sector_id,
                        planet_type,
                        planet_owner,
                        planet_owned_date,
                        planet_distance_id,
                        planet_distance_px,
                        planet_covered_distance,
                        planet_tick_cdistance,
                        planet_max_cdistance,
                        building_1,
                        building_2,
                        building_3,
                        building_4,
                        building_5,
                        building_6,
                        building_7,
                        building_8,
                        building_9,
                        building_10,
                        building_11,
                        building_12,
                        research_1,
                        research_2,
                        research_4,
                        research_5,
                        resource_1,
                        resource_2,
                        resource_3,
                        resource_4,
                        planet_points,
                        planet_available_points,
                        recompute_static,
                        max_resources,
                        max_worker,
                        max_units,
                        workermine_1,workermine_2,workermine_3,
                        unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,
                        rateo_1,rateo_2,rateo_3,rateo_4)
                    VALUES ("'.UNINHABITATED_COLONY.'",
                        '.$system_id.',
                        '.$sector_id.',
                        "'.$planet_type.'",
                        '.$user_id.',
                        '.$game->TIME.',
                        '.$planet_distance_id.',
                        '.$planet_distance_px.',
                        0,
                        '.( mt_rand(10, 30) ).',
                        '.( 2 * M_PI * $planet_distance_px ).',
                        '.$MAX_BUILDING_LVL[1][0].',
                        '.$MAX_BUILDING_LVL[1][1].',
                        '.$MAX_BUILDING_LVL[1][2].',
                        '.$MAX_BUILDING_LVL[1][3].',
                        '.$MAX_BUILDING_LVL[1][4].',
                        '.$MAX_BUILDING_LVL[1][5].',
                        '.$MAX_BUILDING_LVL[1][6].',
                        '.$MAX_BUILDING_LVL[1][7].',
                        '.$MAX_BUILDING_LVL[1][8].',
                        '.$MAX_BUILDING_LVL[1][9].',
                        '.$MAX_BUILDING_LVL[1][10].',
                        '.$MAX_BUILDING_LVL[1][11].',
                        5,
                        4,
                        6,
                        '.$MAX_RESEARCH_LVL[1][4].',
                        '.(150000 * $RACE_DATA[$race][9]).',
                        '.(150000 * $RACE_DATA[$race][10]).',
                        '.(150000 * $RACE_DATA[$race][11]).',
                        '.(10000 * $RACE_DATA[$race][12]).',
                        10,
                        '.$MAX_POINTS[1].',
                        1,
                        '.$PLANETS_DATA[$planet_type][6].',
                        '.$PLANETS_DATA[$planet_type][7].',
                        '.$PLANETS_DATA[$planet_type][7].',
                        1600,1600,1600,
                        4000,2000,500,100,150,100,
                        '.$rateo_1.','.$rateo_2.','.$rateo_3.','.$rateo_4.')';
        }
        else {
            global $MAX_POINTS;
            $sql = 'INSERT INTO planets (planet_name, system_id, sector_id, planet_type, planet_owner, planet_owned_date, planet_distance_id, planet_distance_px, planet_covered_distance, planet_tick_cdistance, planet_max_cdistance, resource_1, resource_2, resource_3, resource_4, planet_points, planet_available_points, recompute_static, max_resources, max_worker, max_units, workermine_1, workermine_2, workermine_3, rateo_1, rateo_2, rateo_3, rateo_4)
                    VALUES ("'.UNINHABITATED_COLONY.'", '.$system_id.', '.$sector_id.', "'.$planet_type.'", '.$user_id.', '.$game->TIME.', '.$planet_distance_id.', '.$planet_distance_px.', 0, '.( mt_rand(10, 30) ).', '.( 2 * M_PI * $planet_distance_px ).', 200, 200, 100, 100, 10, '.$MAX_POINTS[1].', 1, '.$PLANETS_DATA[$planet_type][6].', '.$PLANETS_DATA[$planet_type][7].', '.$PLANETS_DATA[$planet_type][7].', 100, 100, 100, '.$rateo_1.', '.$rateo_2.', '.$rateo_3.', '.$rateo_4.')';
        }
    }

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_planet(): Could not insert new planet data');
    }

    $planet_id = $db->insert_id();

    $sql = 'UPDATE starsystems
            SET system_n_planets = system_n_planets + 1
            WHERE system_id = '.$system_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'world::create_planet(): Could not update starsystem data');
    }

    return $planet_id;
}

?>
