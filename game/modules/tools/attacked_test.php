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

$game->out('<span class="caption">Attacked planets</span><br><br>');

/*$sql = 'UPDATE planets
        SET planet_next_attack = 0';


if(!$db->query($sql)) {
    message(DATABASE_ERROR,'- Warning: Could not zero planet attacked data! CONTINUED');
}*/

$already_processed = array();

$sql = 'SELECT ss.*,
               p.planet_name,
               p.building_7 AS dest_building_7,
               u1.user_id AS dest_user_id, u1.user_alliance AS dest_user_alliance, u1.user_name AS defender,
               u2.user_alliance AS move_user_alliance, u2.user_name AS attacker
        FROM (scheduler_shipmovement ss, planets p)
        INNER JOIN (user u1) ON u1.user_id = p.planet_owner
        INNER JOIN (user u2) ON u2.user_id = ss.user_id
        WHERE p.planet_id = ss.dest AND
              ss.action_code IN (40, 41, 42, 43, 44, 45, 46, 51, 54, 55) AND
              ss.move_status = 0
        ORDER BY ss.move_finish ASC';

if(!$q_moves = $db->query($sql)) {
    message(DATABASE_ERROR,'- Error: Could not select moves data for planet attacked! SKIP');
}
else {

    $game->out('
        <table border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
            <td>
            <table border="0" cellpadding="2" cellspacing="2" class="style_inner">
            <tr>
                <td width="150"><b>Planet Name</b></td><td width="120"><b>Owner</b></td><td width="120"><b>Attacker</b></td><td width="100"><b>Time</b></td><td><b>Action</b></td>
            </tr>
    ');

    while($move = $db->fetchrow($q_moves)) {
        if(isset($already_processed[$move['dest']])) continue;

        $already_processed[$move['dest']] = true;

        // taken from get_move_ship_details() and adapted

        $sql = 'SELECT SUM(st.value_11) AS sum_sensors, SUM(st.value_12) AS sum_cloak
                FROM (scheduler_shipmovement ss)
                INNER JOIN (ship_fleets f) ON f.move_id = ss.move_id
                INNER JOIN (ships s) ON s.fleet_id = f.fleet_id
                INNER JOIN (ship_templates st) ON st.id = s.template_id
                WHERE ss.move_id = '.$move['move_id'].'
                GROUP BY ss.move_id';

        if(($move_ships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR,'- Error: Could not select moves fleet detail data! SKIP');

            break;
        }

        $move_sum_sensors = (!empty($move_ships['sum_sensors'])) ? (int)$move_ships['sum_sensors'] : 0;
        $move_sum_cloak = (!empty($move_ships['sum_cloak'])) ? (int)$move_ships['sum_cloak'] : 0;

        // taken from get_friendly_orbit_fleets()

        $sql = 'SELECT DISTINCT f.user_id,
                       u.user_alliance,
                       ud.ud_id, ud.accepted,
                       ad.ad_id, ad.type, ad.status
                FROM (ship_fleets f)
                INNER JOIN (user u) ON u.user_id = f.user_id
                LEFT JOIN (user_diplomacy ud) ON ( ( ud.user1_id = '.$move['dest_user_id'].' AND ud.user2_id = f.user_id ) OR ( ud.user1_id = f.user_id AND ud.user2_id = '.$move['dest_user_id'].' ) )
                LEFT JOIN (alliance_diplomacy ad) ON ( ( ad.alliance1_id = '.$move['dest_user_alliance'].' AND ad.alliance2_id = u.user_alliance) OR ( ad.alliance1_id = u.user_alliance AND ad.alliance2_id = '.$move['dest_user_alliance'].' ) )
                WHERE f.planet_id = '.$move['dest'].' AND
                      f.user_id <> '.$move['dest_user_id'];

        if(!$q_user = $db->query($sql)) {
            message(DATABASE_ERROR,'- Error: Could not select friendly user data! SKIP');

            break;
        }

        $allied_user = array($move['dest_user_id']);

        while($_user = $db->fetchrow($q_user)) {
            $allied = false;

            if($_user['user_alliance'] == $move['dest_user_alliance']) $allied = true;;

            if(!empty($_user['ud_id'])) {
                if($_user['accepted'] == 1) $allied = true;;
            }

            if(!empty($_user['ad_id'])) {
                if( ($_user['type'] == ALLIANCE_DIPLOMACY_PACT) && ($_user['status'] == 0) ) $allied = true;
            }

            if($allied) $allied_user[] = $_user['user_id'];
        }

        $sql = 'SELECT SUM(st.value_11) AS sum_sensors, SUM(st.value_12) AS sum_cloak
                FROM (ships s, ship_fleets f)
                INNER JOIN (ship_templates st) ON st.id = s.template_id
                WHERE s.user_id IN ('.implode(',', $allied_user).') AND
                      s.fleet_id = f.fleet_id AND
                      f.planet_id = '.$move['dest'];

        if(($friendly_ships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR,'- Error: Could not select friendly fleets data! SKIP');

            break;
        }

        $dest_sum_sensors = (!empty($friendly_ships['sum_sensors'])) ? (int)$friendly_ships['sum_sensors'] : 0;
        $dest_sum_cloak = (!empty($friendly_ships['sum_cloak'])) ? (int)$friendly_ships['sum_cloak'] : 0;

        $visiblity = GetVisibility($move_sum_sensors, $move_sum_cloak, $move['n_ships'], ($dest_sum_sensors + ($move['dest_building_7'] + 1) * 200), $dest_sum_cloak);
        $travelled = 100 / ($move['move_finish'] - $move['move_begin']) * ($ACTUAL_TICK - $move['move_begin']);

        if($travelled < ($visibility +     ( (100 - $visibility) / 4) ) ) $move['n_ships'] = 0;
        if($travelled < ($visibility + 2 * ( (100 - $visibility) / 4) ) ) $move['action_code'] = 0;

        $attack = time() + ($move['move_finish'] - $ACTUAL_TICK) * 300;
  
        $game->out('<tr><td>'.$move['planet_name'].'</td><td>'.$move['defender'].'</td><td>'.$move['attacker'].'</td><td>'.date('d.m.y H:i', ($attack)).'</td><td>'.$move['action_code'].'</td></tr>');

/*        $sql = 'UPDATE planets
                SET planet_next_attack = '.(time() + ($move['move_finish'] - $ACTUAL_TICK) * 300).',
                    planet_attack_ships = '.$move['n_ships'].',
                    planet_attack_type= '.$move['action_code'].'
                WHERE planet_id= '.$move['dest'];

        if(!$db->query($sql)) {
            message(DATABASE_ERROR,'- Warning: Could not update planet attacked data! CONTINUED');
        }*/
    }

    $game->out('
            </table>
            </td>
        </tr>
        </table>');
}

$game->out('<br><br><a href="'.parse_link('a=tools/attacked_test').'"><span class="sub_caption2">Refresh</span></a><br>');


?>
