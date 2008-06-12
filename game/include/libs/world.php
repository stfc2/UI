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



function create_system($id_type, $id_value) {
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

    $sql = 'INSERT INTO starsystems (system_name, sector_id, system_x, system_y, system_map_x, system_map_y, system_global_x, system_global_y, system_starcolor_red, system_starcolor_green, system_starcolor_blue, system_starsize)
            VALUES ("System '.$game->get_sector_name($sector_id).':'.$game->get_system_cname($system_x, $system_y).'", '.$sector_id.', '.$system_x.', '.$system_y.', '.$system_map_x.', '.$system_map_y.', '.$system_coords[0].', '.$system_coords[1].', '.$star_color[0].', '.$star_color[1].', '.$star_color[2].', '.$star_size.')';

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
                              system_n_planets < '.$game->system_max_planets;

                if(($q_systems = $db->query($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query systems data');
                }

                $available_systems = array();
                $n_available = 0;

                while($system = $db->fetchrow($q_systems)) {
                    $available_systems[] = array($system['sector_id'], $system['system_id']);

                    //if( ++$n_available > 30) break;
                }

                $chosen_system = $available_systems[array_rand($available_systems)];

                $sector_id = $chosen_system[0];
                $system_id = $chosen_system[1];
            }

            // If a new system must be created ($system_id = 0), then it's orbitals are all free
            // (in the Alpha-2 it has nevertheless searched * roll *) )
            // Otherwise, a free search

            $free_distances = $game->planet_distances;

            if(!$system_id) {
                $_temp = create_system('quadrant', $quadrant_id);

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
                $sql = 'SELECT system_id, sector_id, system_n_planets
                        FROM starsystems
                        WHERE sector_id >= '.$sector_id.' AND
                              system_closed = 0';

                if(($q_systems = $db->query($sql)) === false) {
                    message(DATABASE_ERROR, 'world::create_planet(): Could not query systems data');
                }

                while($system = $db->fetchrow($q_systems)) {
                    if($system['system_n_planets'] > $game->system_max_planets) {
                        stgc_log('world', 'System '.$system['system_id'].' has '.$system['system_n_planets']);
                    }
                    elseif($system['system_n_planets'] < $game->system_max_planets) {
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
                $_temp = create_system('sector', $sector_id);

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
            
            $sql = 'SELECT sector_id, planet_distance_id
                    FROM planets
                    WHERE system_id = '.$system_id;

            if(($planet_did = $db->queryrowset($sql)) === false) {
                message(DATABASE_ERROR, 'world::create_planet(): Could not query planet did data');
            }

            for($i = 0; $i < count($planet_did); ++$i) {
                unset($free_distances[$planet_did[$i]['planet_distance_id']]);
            }

            $sector_id = $planet_did[0]['sector_id'];
        break;
    }

    $planet_distance_id = array_rand($free_distances);
    $planet_distance_px = mt_rand($game->planet_distances[$planet_distance_id][0], $game->planet_distances[$planet_distance_id][1]);

    // Create!

    if(!$user_id) {
        $type_probabilities = array(
            // a lot of metal, little minerals, little dilithium (15%)
            'a' => 7,  // 3.0  0.1  0.8  0.1
            'b' => 8,  // 3.0  0.1  0.8  0.1

            // medium metals, minerals, dilithium (60%)
            'c' => 10,  // 1.0  1.0  1.0  0.6
            'd' => 12,  // 1.0  1.0  1.0  0.5
            'e' => 8,   // 1.0  1.0  1.0  0.7
            'f' => 6,   // 1.0  1.0  1.0  0.8
            'h' => 13,  // 1.0  1.0  1.0  0.5
            'k' => 11,  // 1.0  1.0  1.0  0.4

            // a lot of metal, medium minerals, medium dilithium (10%)
            'g' => 10, // 1.5  1.0  1.0  0.8

            // little metal, lots of minerals, much dilithium (5%)
            'i' => 5,  // 0.3  1.6  1.6  0.5

            // little metal, a lot of minerals, little dilithium (5%)
            'j' => 2,  // 0.3  2.0  0.4  0.6
            'l' => 3,  // 0.4  1.9  0.5  0.7

            // M/N/Y (5%)
            'm' => 1,  // 1.0  1.0  1.0  1.0
            'n' => 1,  // 0.95 0.95 0.95 1.1
            'y' => 3,  // 2.5  2.5  2.5  0.2
        );

        $type_array = array();

        foreach($type_probabilities as $type => $probability) {
            for($i = 0; $i < $probability; ++$i) {
                $type_array[] = $type;
            }
        }
        
        $planet_type = $type_array[array_rand($type_array)];

        // Varianza randomica delle costanti base del pianeta
        $rateo_1 = round(($PLANETS_DATA[$planet_type][0] + ((250 - mt_rand(0, 500))*0.001)), 2);
		if($rateo_1 < 0) $rateo_1 = 0.1;
        $rateo_2 = round(($PLANETS_DATA[$planet_type][1] + ((250 - mt_rand(0, 500))*0.001)), 2);
		if($rateo_2 < 0) $rateo_2 = 0.1;
        $rateo_3 = round(($PLANETS_DATA[$planet_type][2] + ((250 - mt_rand(0, 500))*0.001)), 2);
		if($rateo_3 < 0) $rateo_3 = 0.1;
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
