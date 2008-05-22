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



function warpf($warp_factor) {
    if($warp_factor < 1) message(GENERAL, 'Ungültiger Warp-Faktor '.$warp_factor, 'warpf(): factor too low');
    if($warp_factor >= 10) message(GENERAL, 'Ungültige Warp-Faktor '.$warp_factor, 'warpf(): factor too high');
    
//    return pow($warp_factor, 1.69897);

    return ( 24 * (1 / (1 + (23 * exp((-0.65 * $warp_factor))) ) ) );
}

function get_distance($s_system, $d_system) {
    global $SYSTEM_WIDTH;

    /*
     $s_system[0] -> globale X-Koordinate
     $s_system[1] -> globale Y-Koordinate
     */

    if($s_system[0] == $d_system[0]) {
        $distance = abs( ( ($s_system[1] - $d_system[1]) * $SYSTEM_WIDTH) );
    }
    elseif($s_system[1] == $d_system[1]) {
        $distance = abs( ( ($s_system[0] - $d_system[0]) * $SYSTEM_WIDTH) );
    }
    else {
        $triangle_a = ($s_system[1] - $d_system[1]);
        $triangle_b = ($s_system[0] - $d_system[0]);

        $distance = ( sqrt( ( ($triangle_a * $triangle_a) + ($triangle_b * $triangle_b) ) ) * $SYSTEM_WIDTH );
    }
    
    return $distance;
}

function send_fake_transporter($ships, $user, $start, $dest, $arrival = 0) {
    /*
     * $ships = array, in dem alle templates aufgezählt werden,
     *          die mitfliegen mit ihrer Anzahl
     *
     *    z.B. $ships = array( 4 => 2, // 2mal das Template 4
     *                         15 => 1, // 1mal das template 15
     *                         84 => 3 // 3mal das Template 84
     *          );
     *
     * $user = ID des Users (bei Handel so ne Art Ferengi-Handelsbehörde)
     *
     * $start = Startplanet (bei 0 wird Startpunkt unbekannt angezeigt)
     *
     * $dest = Zielplanet
     *
     * $arrival = Ankunftstick (muss bei $start = 0 angegeben werden!)
     *
     */

     
    global $db, $ACTUAL_TICK;

    $n_ships = 0;
     
    foreach($ships as $ship_id => $n) {
        $n_ships += $n;
    }
     
    if($n_ships == 0) {
        message(GENERAL, 'Ungültiger Funktions-Aufruf', 'send_fake_transporter(): $n_ships = 0');
    }
     
    // Das SELECTen der Planeten-Daten könnte man noch optmieren, aber
    // das würde nur den Code vergrößern und nicht wirklich viel bringen
    // bei dieser Funktion...
     
    if($start != 0) {
        $sql = 'SELECT p.planet_id, p.system_id,
                       s.system_global_x, s.system_global_y
                FROM (planets p)
                INNER JOIN (starsystems s) ON s.system_id = p.system_id
                WHERE p.planet_id = '.$start;
                 
        if(($start_planet = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query start planets data');
        }
         
        if(empty($start_planet['planet_id'])) {
            message(GENERAL, 'Ungültiger Funktions-Aufruf', 'send_fake_transporter(): $start_planet[\'planet_id\'] = empty');
        }

        $sql = 'SELECT p.planet_id, p.system_id,
                       s.system_global_x, s.system_global_y
                FROM (planets p)
                INNER JOIN (starsystems s) ON s.system_id = p.system_id
                WHERE p.planet_id = '.$dest;
                 
        if(($dest_planet = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query dest planet data');
        }
         
        if(empty($dest_planet['planet_id'])) {
            message(GENERAL, 'Ungültiger Funktionsaufruf', 'send_fake_transporter(): $dest_planet[\'planet_id\'] = empty');
        }
        
        $velocity = $distance = 0;
        
        if($start_planet['system_id'] == $dest_planet['system_id']) {
            $arrival = $ACTUAL_TICK + 6;
        }
        else {
            // JA, ich weiß, das ist HARD-CODED
            // Aber da brauch ja jemand unbedingt seine Fake-Transporter ^^
            $max_warp_speed = 6;
            
            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION ) );

            if($min_time < 1) $min_time = 1;
            
            $arrival = $ACTUAL_TICK + $min_time;
        }
    }
    else {
        if(empty($arrival)) {
            message(GENERAL, 'Ungültiger Funktionsaufruf', 'send_fake_transporter(): $arrival = empty AND $start = 0');
        }

        if($arrival <= $ACTUAL_TICK) {
            message(GENERAL, 'Ungültiger Funktionsaufruf', 'send_fake_transporter(): $arrival <= $ACTUAL_TICK');
        }
        
        $distance = $velocity = 0;
    }
     
    $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
            VALUES ('.$user.', 0, '.$start.', '.$dest.', '.$distance.', '.$distance.', '.$velocity.', '.$ACTUAL_TICK.', '.$arrival.', '.$n_ships.', 32, "")';

 echo $sql;
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could insert new fake moves data');
    }

    return true;
}

function send_auctioned_ship($ship_id, $dest) {
    global $db, $ACTUAL_TICK;
    
    $sql = 'SELECT s.ship_id, s.user_id, -s.fleet_id AS start,
                   st.value_10 AS max_warp_speed,
                   s1.system_id AS start_system_id, s1.system_global_x AS start_x, s1.system_global_y AS start_y,
                   s2.system_id AS dest_system_id, s2.system_global_x AS dest_x, s2.system_global_y AS dest_y
            FROM (ships s)
            INNER JOIN (ship_templates st) ON st.id = s.template_id
            INNER JOIN (planets p1) ON p1.planet_id = -s.fleet_id
            INNER JOIN (starsystems s1) ON s1.system_id = p1.system_id
            INNER JOIN (planets p2) ON p2.planet_id = '.$dest.'
            INNER JOIN (starsystems s2) ON s2.system_id = p2.system_id
            WHERE s.ship_id = '.$ship_id;
            
    if(($ship = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ship data');
    }
    
    if(empty($ship['ship_id'])) {
        message(GENERAL, 'Schiff für Auktion existiert nicht', '$ship[\'ship_id\'] = empty');
    }
    
    if($ship['max_warp_speed'] > 9.99) $ship['max_warp_speed'] = 9.99;
    
    if($ship['start_system_id'] == $ship['dest_system_id']) {
        $distance = $velocity = 0;
        $min_time = 6;
    }
    else {
        $distance = get_distance(array($ship['start_x'], $ship['start_y']), array($ship['dest_x'], $ship['dest_y']));
        $velocity = warpf($ship['max_warp_speed']);
        $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION ) );
    }
    
    if($min_time < 1) $min_time = 1;
    
    $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
            VALUES ('.$ship['user_id'].', 0, 0, '.$ship['start'].', '.$dest.', '.$distance.', '.$distance.', '.($velocity * TICK_DURATION).', '.$ACTUAL_TICK.', '.($ACTUAL_TICK + $min_time).', 1, 33, "")';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new movement data');
    }
    
    $new_move_id = $db->insert_id();
    
    if(empty($new_move_id)) {
        message(GENERAL, 'Konnte Auktionsflotte nicht losschicken', '$new_move_id = empty');
    }
    
    $sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships)
            VALUES ("Auktion '.$ship_id.'", '.$ship['user_id'].', 0, '.$new_move_id.', 1)';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new auction fleet data');
    }
    
    $new_fleet_id = $db->insert_id();
    
    if(empty($new_fleet_id)) {
        message(GENERAL, 'Konnte neue Auktionsflotte nicht finden', '$new_fleet_id = empty');
    }
    
    $sql = 'UPDATE ships
            SET fleet_id = '.$new_fleet_id.'
            WHERE ship_id = '.$ship_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update ships data');
    }
    
    return true;
}

?>
