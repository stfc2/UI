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
//$game->out('<center><span class="caption">'.constant($game->sprache("TEXT0")).'</span></center><br>');

if(isset($_POST['send_homebase'])) {

    // ########################################################################
    // Some fleets must be passed to ship_send

    if(empty($_POST['fleets'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }


    // ########################################################################
    // The fleets IDs "clean" (cast to integer against SQL exploits)

    $fleet_ids = array();

    for($i = 0; $i < count($_POST['fleets']); ++$i) {
        $_temp = (int)$_POST['fleets'][$i];

        if(!empty($_temp)) {
            $fleet_ids[] = $_temp;
        }
    }


    // #########################################################################
    // Was a valid fleet-ID?

    if(empty($fleet_ids)) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE fleet_id IN ('.implode(',', $fleet_ids).') AND move_id = 0';

    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

//$fleets = array($db->fetchrow($q_fleets));
//$fleet_ids = array($fleets[0]['fleet_id']);

//if(empty($fleets[0])) {
//    message(NOTICE, constant($game->sprache("TEXT4")));
//}

//$start = (int)$fleets[0]['planet_id'];

//if($start == 0) {
//    message(NOTICE, constant($game->sprache("TEXT5")));
//}

    while($fleet = $db->fetchrow($q_fleets)) {

    // We can decide to send only fleets stationing on the same planet
    // or any fleets in the galaxy.
    // For code simplicity leave for the second
    //if($_temp['planet_id'] == $start) {
    //    $fleet_ids[] = $_temp['fleet_id'];
    //    $fleets[] = $_temp;
    //}
//}
//$n_fleets = count($fleets);

//if($n_fleets == 0) {
//    message(NOTICE, constant($game->sprache("TEXT6")));
//}

// #############################################################################
// Target search and retrieve from DB

//$fleetid = $_POST['fleets'][0];

//$sql = 'SELECT homebase FROM ship_fleets WHERE fleet_id = '.$fleetid.' AND user_id = '.$game->player['user_id'];

//if(($homebase = $db->queryrow($sql)) === false) {
//    message(DATABASE_ERROR, 'Could not query homebase data');
//}

        $start = (int)$fleet['planet_id'];

        if($start == 0) {
            message(NOTICE, constant($game->sprache("TEXT5")));
        }

        $dest = (int)$fleet['homebase'];

        if($dest == 0) {
            message(NOTICE, constant($game->sprache("TEXT7")).' - '.$dest);
        }

        // #################################################################
        // Starting planet data fetch

        if($start == $game->planet['planet_id']) {
            $start_planet = $game->planet;
            
            $start_planet['user_id'] = $game->player['user_id'];
            $start_planet['user_name'] = $game->player['user_name'];
            $start_planet['user_attack_protection'] = $game->player['user_attack_protection'];
            $start_planet['user_vacation_start'] = $game->player['user_vacation_start'];
            $start_planet['user_vacation_end'] = $game->player['user_vacation_end'];

            // Player data does not have to be taken, since they are not displayed/used
        }
        else {
            $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                           s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                           u.user_id, u.user_name, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
                    FROM (planets p, starsystems s)
                    LEFT JOIN (user u) ON u.user_id = p.planet_owner
                    WHERE p.planet_id = '.$start.' AND
                          s.system_id = p.system_id';

            if(($start_planet = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'Could not query start planet data');
            }

            if(empty($start_planet['planet_id'])) {
                message(NOTICE, constant($game->sprache("TEXT8")));
            }

            if(empty($start_planet['user_id'])) {
                $start_planet['user_id'] = 0;
                $start_planet['user_name'] = '';
                $start_planet['user_attack_protection'] = 0;
                $start_planet['user_vacation_start'] = 0;
                $start_planet['user_vacation_end'] = 0;
            }
        }

        // #####################################################################
        // Target planet data fetch

        if($dest == $game->planet['planet_id']) {
            $dest_planet = $game->planet;

            $dest_planet['user_id'] = $game->player['user_id'];
            $dest_planet['user_name'] = $game->player['user_name'];
            $dest_planet['user_attack_protection'] = $game->player['user_attack_protection'];
            $dest_planet['user_vacation_start'] = $game->player['user_vacation_start'];
            $dest_planet['user_vacation_end'] = $game->player['user_vacation_end'];

            // Player data does not have to be taken, since they are not displayed/used
        }
        else {
            $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                           s.system_x, s.system_y, s.system_global_x, s.system_global_y,
                           u.user_id, u.user_name, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
                    FROM (planets p, starsystems s)
                    LEFT JOIN (user u) ON u.user_id = p.planet_owner
                    WHERE p.planet_id = '.$dest.' AND
                          s.system_id = p.system_id';

            if(($dest_planet = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'Could not query destination planet data');
            }

            if(empty($dest_planet['planet_id'])) {
                message(NOTICE, constant($game->sprache("TEXT9")));
            }

            if(empty($dest_planet['user_id'])) {
                $dest_planet['user_id'] = 0;
                $dest_planet['user_name'] = '';
                $dest_planet['user_attack_protection'] = 0;
                $dest_planet['user_vacation_start'] = 0;
                $dest_planet['user_vacation_end'] = 0;
            }
        }


        // #####################################################################
        // Inter-orbital flight is not possible, as originally planned,
        // which will be resolved separately

        if($start == $dest) {
            message(NOTICE, constant($game->sprache("TEXT10")));
        }


        // #####################################################################
        // If vacation mode is activated, immediately cancel

        if( ($dest_planet['user_vacation_start'] <= $ACTUAL_TICK) && ($dest_planet['user_vacation_end'] > $ACTUAL_TICK) ) {
            message(NOTICE, constant($game->sprache("TEXT11")));
        }

        // #####################################################################
        // If Noob protection is enabled, just cancel

        if($dest_planet['user_attack_protection']>= $ACTUAL_TICK){
            message(NOTICE, constant($game->sprache("TEXT12")));
        }

        // #####################################################################
        // Which classes to fly with?
        // (for warp speed command + options)

        $sql = 'SELECT st.ship_torso, st.value_10 AS warp_speed
                FROM (ships s, ship_templates st)
                WHERE s.fleet_id = '.$fleet['fleet_id'].' AND
                      st.id = s.template_id';

        if(!$q_stpls = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query ship template data');
        }

        $in_scout = $in_transporter = $in_colo = $in_orb = $in_other_torso = false;
        $max_warp_speed = 9.99; // we don't need much precision

        while($_temp = $db->fetchrow($q_stpls)) {
            if($_temp['warp_speed'] < $max_warp_speed) $max_warp_speed = $_temp['warp_speed'];

            if($_temp['ship_torso'] == SHIP_TYPE_SCOUT) {
                $in_scout = true;
                continue;
            }

            if($_temp['ship_torso'] == SHIP_TYPE_TRANSPORTER) {
                $in_transporter = true;
                continue;
            }

            if($_temp['ship_torso'] == SHIP_TYPE_COLO) {
                $in_colo = true;
                continue;
            }

            if($_temp['ship_torso'] == SHIP_TYPE_ORB) {
                $in_orb = true;
                continue;
            }

            $in_other_torso = true;
        }

        // #####################################################################
        // A few settings set

        $free_planet = ($dest_planet['user_id'] == 0) ? true : false;
        $own_planet = ($game->player['user_id'] == $dest_planet['user_id']) ? true : false;

        $starter_atkptc = ($game->player['user_attack_protection'] > $ACTUAL_TICK) ? true : false;
        $dest_atkptc = ($dest_planet['user_attack_protection'] > $ACTUAL_TICK) ? true : false;

        $atkptc_present = ($starter_atkptc || $dest_atkptc) ? true : false;

        $inter_planet = $inter_system = false;

        if($start_planet['system_id'] == $dest_planet['system_id']) $inter_planet = true;
        else $inter_system = true;

        if($in_orb) {
            message(NOTICE, constant($game->sprache("TEXT13")));
        }

        if($starter_atkptc && $free_planet) {
            message(NOTICE, constant($game->sprache("TEXT14")));
}

//$step = (!empty($_POST['step'])) ? $_POST['step'] : 'basic_setup';

        $distance = $velocity = 0;

        if($game->player['user_auth_level'] == STGC_DEVELOPER) $min_time = 1;
        elseif($inter_planet) $min_time = 6;
        else {
            include_once('include/libs/moves.php');

            $distance = get_distance(array($start_planet['system_global_x'], $start_planet['system_global_y']), array($dest_planet['system_global_x'], $dest_planet['system_global_y']));
            $velocity = warpf($max_warp_speed);
            $min_time = ceil( ( ($distance / $velocity) / TICK_DURATION ) );
        }

        $cur_istardate = (int)str_replace('.', '', $game->config['stardate']);
        $min_istardate = $cur_istardate + $min_time;
        $des_istardate = $min_istardate;
        
        if($des_istardate < $min_istardate) {
            message(NOTICE, constant($game->sprache("TEXT15")).' '.($game->config['stardate'] + ($min_time / 10)));
        }

        $move_time = $des_istardate - $cur_istardate;

        $sql = 'SELECT COUNT(ship_id) AS n_ships
                FROM ships
                WHERE fleet_id = '.$fleet['fleet_id']; //IN ('.implode(',', $fleet_ids).')';

        if(($_nships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query real n_ships data');
        }

        $n_ships = $_nships['n_ships'];

        if($n_ships == 0) {
            message(GENERAL, constant($game->sprache("TEXT16")), 'Unexspected: $n_ships = 0');
        }

        $action = (!empty($_POST['action'])) ? $_POST['action'] : 'stationate';

        $action_code = 0;
        $action_code = ($dest_planet['user_id'] != $game->player['user_id']) ? 21: 11;;
        $action_data = "";

       $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
               VALUES ('.$game->player['user_id'].', 0, 0, '.$start.', '.$dest.', '.$distance.', '.$distance.', '.($velocity * TICK_DURATION).', '.$ACTUAL_TICK.', '.($ACTUAL_TICK + $move_time).', '.$n_ships.', '.$action_code.', "'.$action_data.'")';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }

        $new_move_id = $db->insert_id();

        $sql = 'UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.'
                WHERE fleet_id = '.$fleet['fleet_id']; //IN ('.implode(',', $fleet_ids).')';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets position data');
        }
    }
    redirect('a=ship_fleets_display');
}

?>
