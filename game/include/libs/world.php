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

    switch($id_type) {
        case 'quadrant':
            $quadrant_id = $id_value;

            $sql = 'SELECT *
                    FROM starsystems_slots
                    WHERE quadrant_id = '.$quadrant_id.'
                    LIMIT 1';

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

    $star_size = mt_rand($game->starsize_range[0], $game->starsize_range[1]);

    $required_borders = ($game->sector_map_split - 1);
    $px_per_field = ( ($game->sector_map_size - $required_borders) / $game->sector_map_split);

    $root_x = ($px_per_field * ($system_x - 1) ) + ($system_x - 1);
    $root_y = ($px_per_field * ($system_y - 1) ) + ($system_y - 1);

    $border_distance = $px_per_field / 4;
    $border_distance = max($border_distance, ( ($star_size * 0.45) + 3 ) );

    $system_map_x = mt_rand( ($root_x + $border_distance), $root_x + ($px_per_field - $border_distance) );
    $system_map_y = mt_rand( ($root_y + $border_distance), $root_y + ($px_per_field - $border_distance) );

    $system_coords = $game->get_system_gcoords($system_x, $system_y, $sector_id);

    $star_base_color = mt_rand(0, 3);

    switch($star_base_color) {
        // Blue (young) star
        case 0:
            $star_color = array(mt_rand(0, 25), mt_rand(0, 25), mt_rand(150, 255));
        break;

        // White Star
        case 1:
            $star_color = array(mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255));
        break;

        // Yellow Star
        case 2:
            $star_color = array(mt_rand(200, 255), mt_rand(50, 150), mt_rand(0, 25));
        break;

        // Red Star
        case 3:
            $star_color = array(mt_rand(150, 255), mt_rand(0, 25), mt_rand(0, 25));
        break;

        // Brown (old) Star
        case 4:
            $star_color = array(mt_rand(100, 150), mt_rand(40, 80), mt_rand(0, 15));
        break;
    }
    
    
    if((int)$is_mother == 1) {
        $max_planets = 8;
    }
    else {
        $max_planets = 4 + (mt_rand(0,4));
    }

    $sql = 'INSERT INTO starsystems (system_name, sector_id, system_x, system_y, system_map_x, system_map_y, system_global_x, system_global_y, system_starcolor_red, system_starcolor_green, system_starcolor_blue, system_starsize, system_max_planets)
            VALUES ("System '.$game->get_sector_name($sector_id).':'.$game->get_system_cname($system_x, $system_y).'", '.$sector_id.', '.$system_x.', '.$system_y.', '.$system_map_x.', '.$system_map_y.', '.$system_coords[0].', '.$system_coords[1].', '.$star_color[0].', '.$star_color[1].', '.$star_color[2].', '.$star_size.', '.$max_planets.')';

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

function create_planet($user_id, $id_type, $id_value) {
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
            'a' => 30,
            'b' => 35,
            'c' => 10,
            'd' => 10,
            's' => 5,
            't' => 4,
            'x' => 4,
            'y' => 2
        ),
        // Orbit level 1
        1 => array(
            'a' => 30,
            'b' => 35,
            'c' => 10,
            'd' => 10,
            's' => 5,
            't' => 4,
            'x' => 4,
            'y' => 2
        ),
        // Orbit level 2
        2 => array(
            'a' => 2,
            'c' => 8,
            'd' => 8,
            'e' => 15,
            'f' => 13,
            'g' => 8,
            'h' => 13,
            'k' => 10,
            'l' => 4,
            'm' => 2,
            'n' => 14,
            'o' => 2,
            'p' => 1
        ),
        // Orbit level 3
        3 => array(
            'a' => 1,
            'c' => 8,
            'd' => 8,
            'e' => 12,
            'f' => 13,
            'g' => 13,
            'h' => 8,
            'k' => 8,
            'l' => 8,
            'm' => 4,
            'n' => 10,
            'o' => 4,
            'p' => 3
        ),
        // Orbit level 4
        4 => array(
            'a' => 1,
            'c' => 8,
            'd' => 8,
            'e' => 12,
            'f' => 18,
            'g' => 19,
            'h' => 10,
            'k' => 6,
            'l' => 4,
            'm' => 3,
            'n' => 4,
            'o' => 3,
            'p' => 4
        ),
        // Orbit level 5
        5 => array(
            'a' => 3,
            'c' => 8,
            'd' => 8,
            'e' => 12,
            'f' => 18,
            'g' => 18,
            'h' => 8,
            'k' => 6,
            'l' => 8,
            'm' => 2,
            'n' => 1,
            'o' => 2,
            'p' => 6
        ),
        // Orbit level 6
        6 => array(
            'a' => 6,
            'c' => 10,
            'd' => 10,
            'i' => 22,
            'j' => 23,
            's' => 14,
            't' => 14
        ),
        // Orbit level 7
        7 => array(
            'a' => 6,
            'c' => 22,
            'd' => 23,
            'i' => 14,
            'j' => 14,
            's' => 10,
            't' => 10
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

    if(!$user_id) {
        $type_array = array();

        foreach($planet_type_probabilities[$planet_distance_id] as $type => $probability) {
            for($i = 0; $i < $probability; ++$i) {
                $type_array[] = $type;
            }
        }

        $planet_type = $type_array[array_rand($type_array)];

        $type_probabilities = array(
            'bbb' => 1,
            'bbn' => 3,
            'bnb' => 3,
            'nbb' => 3,
            'bnn' => 5,
            'nbn' => 5,
            'nnb' => 5,
            'nnn' => 50,
            'gnn' => 5,
            'ngn' => 5,
            'nng' => 5,
            'ggn' => 3,
            'ngg' => 3,
            'gng' => 3,
            'ggg' => 1, 
        );

        $template_array = array();

        foreach($type_probabilities as $type => $probability) {
            for($i = 0; $i < $probability; ++$i) {
                $template_array[] = $type;
            }
        }

        $planet_template = $template_array[array_rand($template_array)];

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
        $planet_type = (mt_rand(1, 2) == 1) ? 'm' : 'n';

        $rateo_1 = $PLANETS_DATA[$planet_type][0];
        $rateo_2 = $PLANETS_DATA[$planet_type][1];
        $rateo_3 = $PLANETS_DATA[$planet_type][2];
        $rateo_4 = $PLANETS_DATA[$planet_type][3];

        $sql = 'INSERT INTO planets (planet_name, system_id, sector_id, planet_type, planet_owner, planet_owned_date, planet_distance_id, planet_distance_px, planet_covered_distance, planet_tick_cdistance, planet_max_cdistance, resource_1, resource_2, resource_3, resource_4, planet_points, recompute_static, max_resources, max_worker, max_units, workermine_1, workermine_2, workermine_3, rateo_1, rateo_2, rateo_3, rateo_4)
                VALUES ("'.UNINHABITATED_COLONY.'", '.$system_id.', '.$sector_id.', "'.$planet_type.'", '.$user_id.', '.$game->TIME.', '.$planet_distance_id.', '.$planet_distance_px.', 0, '.( mt_rand(10, 30) ).', '.( 2 * M_PI * $planet_distance_px ).', 200, 200, 100, 100, 10, 1, '.$PLANETS_DATA[$planet_type][6].', '.$PLANETS_DATA[$planet_type][7].', '.$PLANETS_DATA[$planet_type][7].', 100, 100, 100, '.$rateo_1.', '.$rateo_2.', '.$rateo_3.', '.$rateo_4.')';
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
