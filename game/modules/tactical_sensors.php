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

include('include/static/static_components_9.php');
$filename = 'include/static/static_components_9_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);
include('include/libs/moves.php');

global $RACE_DATA;

$torso_id = array(constant($game->sprache("TEXT42")), constant($game->sprache("TEXT43")), constant($game->sprache("TEXT44")), constant($game->sprache("TEXT45")), constant($game->sprache("TEXT45")), constant($game->sprache("TEXT46")), constant($game->sprache("TEXT46")), constant($game->sprache("TEXT47")), constant($game->sprache("TEXT47")), constant($game->sprache("TEXT48")), constant($game->sprache("TEXT48")), constant($game->sprache("TEXT49")), constant($game->sprache("TEXT50")));

$strenght_text = ['Very Weak', 'Weak', 'Average', 'Strong', 'Very Strong'];

$delete_ferengi = $game->option_retr('delete_ferengi', 10);
$view_attack = $game->option_retr('view_attack', 10);

if($delete_ferengi === 10)
{
    $delete_ferengi = false;
    $game->option_store('delete_ferengi', false);    
}
if($view_attack === 10)
{
    $view_attack = false;
    $game->option_store('view_attack', false);        
}

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">'.constant($game->sprache("TEXT1")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">'.constant($game->sprache("TEXT2")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">'.constant($game->sprache("TEXT3")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">'.constant($game->sprache("TEXT4")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_known').'">'.constant($game->sprache("TEXT4a")).'</a>]&nbsp;&nbsp;[<b>'.constant($game->sprache("TEXT5")).'</b>]<br>[<a href="'.parse_link('a=tactical_sensors&view_attack').'">'.($view_attack ?  constant($game->sprache("TEXT34")) : constant($game->sprache("TEXT32"))).'</a>]&nbsp;[<a href="'.parse_link('a=tactical_sensors&delete_ferengi').'">'.($delete_ferengi ? constant($game->sprache("TEXT51")) : constant($game->sprache("TEXT33"))).'</a>]&nbsp;[<a href="'.parse_link('a=tactical_sensors&fleets_sensors').'">'.constant($game->sprache("TEXT37")).'</a>]<br><br>');

if (isset($_GET['delete_ferengi']))
{
    $delete_ferengi = !$delete_ferengi;
    $game->option_store('delete_ferengi', $delete_ferengi);
    redirect('a=tactical_sensors');

}
elseif (isset($_GET['view_attack'])) 
{
    $view_attack = !$view_attack;    
    $game->option_store('view_attack', $view_attack);
    redirect('a=tactical_sensors');    
}


$filter_stream = '(11, 12, 13, 14, 21, 23, 24, 25, 26, 27, 28, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 51, 54, 55)';

// $planets_selection = 'p2.system_id IN (SELECT DISTINCT system_id FROM planets WHERE planet_owner = ' . $game->player['user_id'] . ' ) AND';

$planets_selection = 'p2.planet_owner = ' . $game->player['user_id'] . ' AND';

$fleets_sensors = false;


if ($delete_ferengi)
{
    $filter_stream = '(11, 12, 13, 14, 21, 23, 24, 25, 26, 27, 28, 31, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 51, 54, 55)';
}
elseif ($view_attack)
{
    $filter_stream = '(40, 41, 42, 43, 44, 45, 46, 51, 54, 55)';
}

if (isset($_GET['fleets_sensors']))
{
    $sql = 'SELECT fleet_id, fleet_name, n_ships, ship_fleets.planet_id, system_id
            FROM ship_fleets
            WHERE owner_id = '.$game->player['user_id'].' AND system_id > 0 AND is_civilian <> 1';

    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query moves fleets data!');
    }

    /*
    while($_fl = $db->fetchrow($q_fleets)) {
        $fleet_ids[$_fl['planet_id']] = $_fl['fleet_id'];
        $fleet_planets[] = $_fl['planet_id'];
        $fleet_names[$_fl['planet_id']] = $_fl['fleet_name'];
        //$n_ships[] = $_fl['n_ships'];
    }
     * 
     */

    while($_fl = $db->fetchrow($q_fleets)){
        $fleet_ids[$_fl['system_id']] = $_fl['fleet_id'];
        $fleet_systems[] = $_fl['system_id'];
        $fleet_names[$_fl['system_id']] = $_fl['fleet_name'];
    }
    
    if(count($fleet_ids) == 0) {
        message(NOTICE, constant($game->sprache("TEXT38")));
    }

    // $fleet_planets_str = implode(',', $fleet_planets);

    $planets_selection = 'p2.system_id IN (SELECT sf.system_id FROM (ship_fleets sf) WHERE sf.system_id > 0 AND sf.user_id = '.$game->player['user_id'].') AND';

    $fleets_sensors = true;
}



$start = (!empty($_GET['start'])) ? (int)$_GET['start']:0;

$dest = (!empty($_GET['dest'])) ? (int)$_GET['dest']:0;



$sql = 'SELECT ss.*, 
            p1.system_id AS start_id, p1.planet_name AS start_planet_name, p1.sector_id AS start_sector_id, p1.planet_distance_id AS start_planet_distance_id,
            s1.system_name AS start_system_name, s1.system_x AS start_system_x, s1.system_y AS start_system_y, 
            s1.system_global_x AS start_global_X, s1.system_global_y AS start_global_y,
            u1.user_id AS start_owner_id, 
            u1.user_name AS start_owner_name,
            u2.user_name as owner_name,
            p2.planet_owner AS dest_owner_id,
            u3.user_name AS dest_owner_name,
            u4.user_name AS masked_name,
            p2.system_id AS dest_id, p2.planet_id AS dest_planet_id,
            p2.planet_name AS dest_planet_name, p2.sector_id AS dest_sector_id, p2.planet_distance_id AS dest_planet_distance_id,
            p2.building_7 AS dest_sensors,
            s2.system_name AS dest_system_name, s2.system_x AS dest_system_x, s2.system_y AS dest_system_y,
            s2.system_global_x AS dest_global_X, s2.system_global_y AS dest_global_y
        FROM (scheduler_shipmovement ss, planets p2)
            LEFT JOIN (planets p1) ON p1.planet_id = ss.start
            LEFT JOIN (user u1) ON u1.user_id = p1.planet_owner
            LEFT JOIN (user u2) ON u2.user_id = ss.owner_id
            LEFT JOIN (user u3) ON u3.user_id = p2.planet_owner
            LEFT JOIN (user u4) ON u4.user_id = ss.user_id
            LEFT JOIN (starsystems s1) ON s1.system_id = p1.system_id
            LEFT JOIN (starsystems s2) ON s2.system_id = p2.system_id
        WHERE p2.planet_id = ss.dest AND
              '.$planets_selection.'
              ss.move_begin <= ' . $ACTUAL_TICK . ' AND
              ss.move_finish >= ' . $ACTUAL_TICK . ' AND
              ss.owner_id<>' . $game->player['user_id'] . ' AND
              ss.move_status = 0 AND ss.action_code IN '.$filter_stream.'' . (($start) ?
    ' AND ss.start = ' . $start:'') . (($dest) ? ' AND ss.dest = ' . $dest:'') . '
        ORDER BY ss.move_finish ASC';



if (!$q_moves = $db->query($sql))
{
    message(DATABASE_ERROR, 'Could not query moves data');
}



$n_moves = $db->num_rows($q_moves);



if ($n_moves == 0)
{
    message(NOTICE, constant($game->sprache("TEXT6")));
}



// For the arrival timer

$i = 2;


// DC Lasciamo i codici dei trasporti Ferengi come "visibili"
// DC La mossa di attacco Borg � sempre visibile
$visible_actions = array(32, 33, 46);

// Number of fleets displayed
$fleets_displayed = 0;

while ($move = $db->fetchrow($q_moves))
{
    $visibility = 0;

    if($move['masked_name'] != $move['owner_name']) {
        $move['owner_name'] = $move['masked_name'];
    }    
    
    $ticks_left = $move['move_finish'] - $ACTUAL_TICK;
    if ($ticks_left < 0) {$ticks_left = 0;}
    
    //array('n_ships', 'sum_sensors', 'sum_cloak', 'status', 'torso' => array(0...9) )
    $sensor1 = get_move_ship_details($move['move_id']);
        
    if (!in_array($move['action_code'], $visible_actions))
    {
        // Todo: Fleets queries, calculate values:
        //array('n_ships', 'sum_sensors', 'sum_cloak')
        /* 30/06/08 - AC: Planet sensors depends on target planet NOT on currently active planet!  */
        //$sensor2 = get_friendly_orbit_fleets($move['dest_id']);
        $sensor2['sum_sensors'] = 0;
        $sensor2['sum_cloak'] = 0;
        
        if($fleets_sensors)
            $sensor3['sum_sensors'] = min(get_system_fleet_sensors($move['dest_id']), PLANETARY_SENSOR_VALUE*10);
        else
        {
            $sensor3['sum_sensors'] = ($move['dest_sensors'] + 1) * PLANETARY_SENSOR_VALUE;
            //$sensor3['sum_sensors'] = get_system_planetary_sensors($move['dest_id']) * PLANETARY_SENSOR_VALUE;
            //$sensor3['sum_cloak'] = 0;
        }
        
        if($move['start_id'] == $move['dest_id']) $move_is_intersystem = true; else $move_is_intersystem = false;

        
        // if(MAX_BOUND_RANGE > $sensor3['sum_sensors']) {$sensor_range = $sensor3['sum_sensors'];} else {$sensor_range = MAX_BOUND_RANGE;}
        $sensor_range = min(MAX_BOUND_RANGE, $sensor3['sum_sensors']);

        //$distance = get_distance(array($move['start_global_X'], $move['start_global_y']), array($move['dest_global_X'], $move['dest_global_y']));
        $distance = $move['total_distance'];
        
        /*
        25/11/08 - AC: Spacedock sensors must be added to orbit fleets NOT to incoming fleets... 
        $flight_duration = $move['move_finish'] - $move['move_begin'];        
        if(($move['move_finish'] - $ACTUAL_TICK) <= 6 ) {$visibility = 0;}
        else {
            Vecchia chiamata alla GetVisibility
            $visibility = GetVisibility($sensor1['sum_sensors'], $sensor1['sum_cloak'], $sensor1['n_ships'],
                $sensor2['sum_sensors'], $sensor2['sum_cloak'], $sensor3['sum_sensors'],$flight_duration);            
            
            $visibility = NewGetVisibility($sensor3['sum_sensors'], $move['total_distance'], $move['tick_speed'], $move['n_ships'], $sensor1['sum_cloak'], $sensor1['torso'], $flight_duration);
        }
        $travelled = 100 / $flight_duration * ($ACTUAL_TICK - $move['move_begin']);        
        */

        $visibility = (int)(100 / $distance * $sensor_range);

        if($visibility > 100) {$visibility = 100;}

        $travelled = (int)(100 / $distance * ($distance - $move['remaining_distance']));

        $move_is_bvr = false;

        if($travelled >= $visibility) {$move_is_bvr = true;}
    }
    else
    {
        // Ferengi(NPC) doesn't have ships templates stored in the DB
        if($move['move_id'] != 46) $sensor1['torso'][1] = $move['n_ships'];
    }


    if (in_array($move['action_code'], $visible_actions) || !$move_is_bvr || ($move_is_intersystem && $ticks_left <= ($INTER_SYSTEM_TIME - 1)))
    {
        $game->out('

<table border="0" width="300" align="center" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td>
      <table border="0" width="300" align="center" cellpadding="2" cellspacing="2" class="style_inner">
        <tr>        
          <td>
        ');



        if ($move['start'] == $move['dest'])
        {
            $game->out(constant($game->sprache("TEXT7")).' <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                encode_planet_id($move['start'])) . '"><b>' . $move['start_planet_name'] .
                '</b> ('.$game->get_sector_name($move['start_sector_id']).':'.$game->get_system_cname($move['start_system_x'], $move['start_system_y']).':'.($move['start_planet_distance_id'] + 1).')</a><br>');
        }
        else
        {
            /*
            $game->out(constant($game->sprache("TEXT8")).' ' . (isset($move['owner_name']) ? '<a href="' .
                parse_link('a=stats&a2=viewplayer&id=' . $move['user_id']) . '"><b>' . $move['owner_name'] .
                '</b></a>':'<b>'.constant($game->sprache("TEXT9")).'</b>') . '<br>');

            */

            if (!empty($move['start']))
            {
                if($move['move_hide_start'] == 1) {
                    $start_str = ' <i>'.constant($game->sprache("TEXT13")).'</i><br>';
                }
                else {
                    if (empty($move['start_owner_id']))
                        $start_owner_str = ' <i>'.constant($game->sprache("TEXT10")).'</i>';
                    elseif ($move['start_owner_id'] != $game->player['user_id'])
                        $start_owner_str = ' '.constant($game->sprache("TEXT11")).' <a href="' . parse_link('a=stats&a2=viewplayer&id=' . $move['start_owner_id']) .
                            '"><b>' . $move['start_owner_name'] . '</b></a>';
                    else
                        $start_owner_str = '';

                    if($move['start_owner_id'] == $game->player['user_id'] || $move_is_intersystem)
                    {
                        $start_str = ' <a href="' . parse_link('a=tactical_cartography&planet_id=' . encode_planet_id($move['start'])) . '"><b>' . $move['start_planet_name'] .
                                     '</b> ('.$game->get_sector_name($move['start_sector_id']).':'.$game->get_system_cname($move['start_system_x'], $move['start_system_y']).':'.($move['start_planet_distance_id'] + 1).')</a>' . $start_owner_str . '<br>';
                    }
                    else
                    {
                        $start_str = ' <a href="' . parse_link('a=tactical_cartography&system_id=' . encode_system_id($move['start_id'])) . '"><b>' . $move['start_system_name'] .
                                '</b> ('.$game->get_sector_name($move['start_sector_id']).':'.$game->get_system_cname($move['start_system_x'], $move['start_system_y']).')</a><br>';
                    }
                }
                $game->out(constant($game->sprache("TEXT12")).$start_str);
            }
            else
            {
                $game->out(constant($game->sprache("TEXT12")).' <i>'.constant($game->sprache("TEXT13")).'</i><br>');
            }

            /*
            $game->out(constant($game->sprache("TEXT14")).' <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                encode_planet_id($move['dest'])) . '"><b>' . $move['dest_planet_name'] .
                '</b> ('.$game->get_sector_name($move['dest_sector_id']).':'.$game->get_system_cname($move['dest_system_x'], $move['dest_system_y']).':'.($move['dest_planet_distance_id'] + 1).')</a><br>');
             */
        }


        if(in_array($move['action_code'], $visible_actions) || $move_is_intersystem)
        {
            $game->out(constant($game->sprache("TEXT14")).' <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                encode_planet_id($move['dest'])) . '"><b>' . $move['dest_planet_name'] .
                '</b> ('.$game->get_sector_name($move['dest_sector_id']).':'.$game->get_system_cname($move['dest_system_x'], $move['dest_system_y']).':'.($move['dest_planet_distance_id'] + 1).')</a><br>');            
        }
        else
        {
            $game->out(constant($game->sprache("TEXT14")).' <a href="' . parse_link('a=tactical_cartography&system_id=' .
                encode_system_id($move['dest_id'])) . '"><b>' . $move['dest_system_name'] .
                '</b> ('.$game->get_sector_name($move['dest_sector_id']).':'.$game->get_system_cname($move['dest_system_x'], $move['dest_system_y']).')</a><br>');            
        }

        $game->out('<br>'.constant($game->sprache("TEXT54")).': '.
            ($move['race_trail'] == -1 ? '<i>'.constant($game->sprache("TEXT55")).'</i>' : '<b>'.$RACE_DATA[$move['race_trail']][0].'</b>'));

        $commands = array(11 => constant($game->sprache("TEXT15")), 12 => constant($game->sprache("TEXT16")),
            13 => constant($game->sprache("TEXT16")), 14 => constant($game->sprache("TEXT17")),
            21 => constant($game->sprache("TEXT15")), 22 => constant($game->sprache("TEXT18")),
            23 => constant($game->sprache("TEXT19")), 24 => constant($game->sprache("TEXT20")),
            25 => constant($game->sprache("TEXT20")), 26 => constant($game->sprache("TEXT36")),
            27 => constant($game->sprache("TEXT40")), 28 => constant($game->sprache("TEXT41")),
            31 => constant($game->sprache("TEXT17")),
            32 => constant($game->sprache("TEXT21")), 33 => constant($game->sprache("TEXT22")),
            34 => constant($game->sprache("TEXT23")), 35 => constant($game->sprache("TEXT23")),
            36 => constant($game->sprache("TEXT23")), 37 => constant($game->sprache("TEXT23")),
            38 => constant($game->sprache("TEXT23")), 39 => constant($game->sprache("TEXT23")),
            40 => constant($game->sprache("TEXT24")), 41 => constant($game->sprache("TEXT24")),
            42 => constant($game->sprache("TEXT24")), 43 => constant($game->sprache("TEXT25")),
            44 => constant($game->sprache("TEXT26")), 45 => constant($game->sprache("TEXT20")),
            46 => constant($game->sprache("TEXT35")), 
            51 => constant($game->sprache("TEXT24")), 53 => constant($game->sprache("TEXT25")),
            54 => constant($game->sprache("TEXT26")), 55 => constant($game->sprache("TEXT20")), );

        if (in_array($move['action_code'], $visible_actions) || $move_is_intersystem || $travelled >= $visibility + 2 * ((100 - $visibility) / 4))
        {
            $game->out('<br>'.constant($game->sprache("TEXT8")).' ' . (isset($move['owner_name']) ? '<a href="' .
                parse_link('a=stats&a2=viewplayer&id=' . $move['user_id']) . '"><b>' . $move['owner_name'] .
                '</b></a>':'<b>'.constant($game->sprache("TEXT9")).'</b>'));            
            $game->out('<br>'.constant($game->sprache("TEXT27")).' <b>' . $sensor1['n_ships'] . '</b>');
        }        
        
        if (in_array($move['action_code'], $visible_actions) || $move_is_intersystem  || $travelled >= $visibility + 3 * ((100 - $visibility) / 4))
        {
            $game->out('<br>'.constant($game->sprache("TEXT29")));

            for ($t = 0; $t < 14; $t++)
            {
                if ($sensor1['torso'][$t] > 0)

                    if (!isset($SHIP_TORSO[$game->player['user_race']][$t][0]))
                    {
                        $game->out('<br><b>' . $sensor1['torso'][$t] . 'x</b><i> '.$torso_id[$t].' </i>');
                    }
                    else
                    {
                        $game->out('<br><b>' . $sensor1['torso'][$t] . 'x</b> ' . ($SHIP_TORSO[$game->player['user_race']][$t][29]));
                    }
            }
        }

        if (in_array($move['action_code'], $visible_actions) || $move_is_intersystem || $travelled >= $visibility + 3 * ((100 - $visibility) / 4))
        {
            $game->out('<br>'.constant($game->sprache("TEXT28")).' <b>' . $commands[$move['action_code']] . '</b>');
            
            if($move['move_expedited']) {
                
                $game->out('<br><b style="color:red">'.constant($game->sprache("TEXT53")).'</b>');
                
            }            
            
        }
        
        if (($move['move_rerouted'] || $move['action_code'] == 28 || $ticks_left <= 1) && ($move_is_intersystem || $travelled >= $visibility + 3 * ((100 - $visibility) / 4)))
        {       
                
            $game->out('<br><b style="color:orange">'.constant($game->sprache("TEXT52")).'</b>');
                        
        }

        $game->out('

          <br><br>

          '.constant($game->sprache("TEXT31")).' ' . (($i < 10) ? '<b id="timer' . $i . '" title="time1_' . (($ticks_left *
            TICK_DURATION * 60) + $NEXT_TICK) . '_type2_2">&nbsp;</b>':format_time($ticks_left *
            TICK_DURATION)) . '

        ');

        if($fleets_sensors)
            $game->out('<br><br>'.constant($game->sprache("TEXT39")).' <a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_ids[$move['dest_id']].'').'"><b>'.$fleet_names[$move['dest_id']].'</b></a>');

        $game->out('

          </td>
        </tr>
      </table>
    </td>
  </tr>
</table><br>

        ');


        ++$i;
        $fleets_displayed++;
    }
}

// Some fleets are present, but not revealed by player's sensors
if($fleets_displayed == 0)
    message(NOTICE, constant($game->sprache("TEXT6")));


?>

