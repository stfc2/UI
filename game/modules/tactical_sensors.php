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

include ('/include/static/static_components_9.php');


$game->out('<center><span class="caption">Taktische Zentrale:</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">Stellare Kartographie</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">Schiffsbewegungen</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">Spieler Info</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">Kolonisierung</a>]&nbsp;&nbsp;[<b>Sensoren</b>]</center><br>[<a href="'.parse_link('a=tactical_sensors&view_attack').'">Nur Angriffe anzeigen</a>]&nbsp;[<a href="'.parse_link('a=tactical_sensors&delete_ferengi').'">Ferengitransporte ausblenden</a>]&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">Alles anzeigen</a>]<br><br>');

$filter_stream = '(11, 12, 13, 14, 21, 23, 24, 25, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 51, 54, 55)';

if (isset($_GET['delete_ferengi']))
{
    $filter_stream = '(11, 12, 13, 14, 21, 23, 24, 25, 31, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 51, 54, 55)';
}
elseif (isset($_GET['view_attack'])) 
{
	$filter_stream = '(40, 41, 42, 43, 44, 45, 51, 54, 55)';	
}
else
{
    $filter_stream = '(11, 12, 13, 14, 21, 23, 24, 25, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 51, 54, 55)';
}




$start = (!empty($_GET['start'])) ? (int)$_GET['start']:0;

$dest = (!empty($_GET['dest'])) ? (int)$_GET['dest']:0;



$sql = 'SELECT ss.*,

			   p1.planet_name AS start_planet_name,

			   u1.user_id AS start_owner_id, u1.user_name AS start_owner_name,

			   u2.user_name as owner_name,

			   p2.planet_name AS dest_planet_name

		FROM (scheduler_shipmovement ss, planets p2)

		LEFT JOIN (planets p1) ON p1.planet_id = ss.start

		LEFT JOIN (user u1) ON u1.user_id = p1.planet_owner

		LEFT JOIN (user u2) ON u2.user_id = ss.user_id

		WHERE p2.planet_id = ss.dest AND

              p2.planet_owner = ' . $game->player['user_id'] . ' AND

              ss.move_begin <= ' . $ACTUAL_TICK . ' AND

              ss.move_finish >= ' . $ACTUAL_TICK . ' AND

              ss.user_id<>' . $game->player['user_id'] . ' AND

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

    if ($start && $dest)
    {

        message(NOTICE, 'Keine Schiffe in Bewegung auf den Sensoren entdeckt');

    }

    else
    {

        message(NOTICE, 'Keine Schiffe in Bewegung auf den Sensoren entdeckt');

    }

}



// Für die Ankunftstimer

$i = 2;



$visible_actions = array(11, 12, 13, 14, 21, 23, 24, 25, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 51, 54, 55);





while ($move = $db->fetchrow($q_moves))
{

    $move_id = $move['move_id'];











    $visibility = 0;

    if (!in_array($move['action_code'], $visible_actions))
    {

        // Todo: Flotten querien, Werte berechnen:

        //array('n_ships', 'sum_sensors', 'sum_cloak')

        $sensor2 = get_friendly_orbit_fleets($game->planet['planet_id']);

        //array('n_ships', 'sum_sensors', 'sum_cloak', 'status', 'torso' => array(0...9) )

        $sensor1 = get_move_ship_details($move['move_id']);



        $visibility = GetVisibility($sensor1['sum_sensors'] + ($game->planet['building_7'] +
            1) * 200, $sensor1['sum_cloak'], $sensor1['n_ships'], $sensor2['sum_sensors'], $sensor2['sum_cloak']);



        $travelled = 100 / ($move['move_finish'] - $move['move_begin']) * ($ACTUAL_TICK -
            $move['move_begin']);

    }

    else
        $sensor1 = get_move_ship_details($move['move_id']);



    if ($move['action_code'] == 32 || $move['action_code'] == 33)
    {

        $sensor1['n_ships'] = $move['n_ships'];

        $sensor1['torso'][1] = $move['n_ships'];

    }




    if ($travelled >= $visibility || in_array($move['action_code'], $visible_actions))
    {



        $game->out('

	<table width="200" align="center" border="0" cellpadding="2" cellspacing="2" background="' .
            $game->GFX_PATH . 'template_bg3.jpg" class="border_grey">

  	<tr>

	<td>

	');



        if ($move['start'] == $move['dest'])
        {

            $game->out('Standort: <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                encode_planet_id($move['start'])) . '"><b>' . $move['start_planet_name'] .
                '</b></a><br>');

        }

        else
        {



            if ($game->player['user_id'] == 11)
                $game->out('Flotte von: ' . (isset($move['user_name']) ? '<a href="' .
                    parse_link('a=stats&a2=viewplayer&id=' . $move['user_id']) . '"><b>' . $move['owner_name'] .
                    '</b></a>':'<b>Ferengi (NPC)</b>') . '<br>');

            if (!empty($move['start']))
            {

                if (empty($move['start_owner_id']))
                    $start_owner_str = ' <i>(unbewohnt)</i>';

                elseif ($move['start_owner_id'] != $game->player['user_id'])
                    $start_owner_str = ' von <a href="' . parse_link('a=stats&a2=viewplayer&id=' . $move['start_owner_id']) .
                        '"><b>' . $move['start_owner_name'] . '</b></a>';

                else
                    $start_owner_str = '';



                $game->out('Start: <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                    encode_planet_id($move['start'])) . '"><b>' . $move['start_planet_name'] .
                    '</b></a>' . $start_owner_str . '<br>');

            }

            else
            {

                $game->out('Start: <i>unbekannt</i><br>');

            }



            $game->out('Ziel: <a href="' . parse_link('a=tactical_cartography&planet_id=' .
                encode_planet_id($move['dest'])) . '"><b>' . $move['dest_planet_name'] .
                '</b></a><br>');

        }



        $commands = array(11 => 'Stationieren', 12 => 'Zurückfliegen', 13 =>
            'Zurückfliegen', 14 => 'Transportieren', 21 => 'Stationieren', 22 =>
            'Spionieren', 23 => 'Übergeben', 24 => 'Kolonisieren', 25 => 'Kolonisieren', 31 =>
            'Transportieren', 32 => 'Ferengitransport', 33 => 'Auktionsflotte', 34 =>
            'Handelsroute', 35 => 'Handelsroute', 36 => 'Handelsroute', 37 => 'Handelsroute',
            38 => 'Handelsroute', 39 => 'Handelsroute', 40 => 'Angreifen', 41 => 'Angreifen',
            42 => 'Angreifen', 43 => 'Pluendern', 44 => 'Bombardieren', 45 => 'Kolonisieren',
            51 => 'Angreifen', 53 => 'Pluendern', 54 => 'Bombardieren', 55 => 'Kolonisieren', );





        if (in_array($move['action_code'], $visible_actions) || $travelled >= $visibility +
            ((100 - $visibility) / 4))
        {
            $game->out('<br>Schiffe: <b>' . $sensor1['n_ships'] . '</b>');
        }

        if (in_array($move['action_code'], $visible_actions) || $travelled >= $visibility +
            2 * ((100 - $visibility) / 4))
        {
            $game->out('<br>Befehl: <b>' . $commands[$move['action_code']] . '</b>');
        }

        if (in_array($move['action_code'], $visible_actions) || $travelled >= $visibility +
            3 * ((100 - $visibility) / 4))
        {

            $game->out('<br>Rumpftypen:');

            for ($t = 0; $t < 14; $t++)
            {

                if (isset($sensor1['torso'][$t]) && $sensor1['torso'][$t] > 0)
                    if (!isset($SHIP_TORSO[$game->player['user_race']][$t][0]))
                        if ($SHIP_TORSO[9][6][0])
                        {

                            $game->out('<br><b>' . $sensor1['torso'][$t] . 'x</b> Decoy Testship (Rumpf: ' .
                                (7) . ')');

                        }
                        else
                        {
                            $game->out('<br><b>' . $sensor1['torso'][$t] . '</b> Typ ' . ($t + 1));
                        }

                    else
                        $game->out('<br><b>' . $sensor1['torso'][$t] . 'x</b> ' . ($SHIP_TORSO[$game->
                            player['user_race']][$t][29]));

            }

        }







        $ticks_left = $move['move_finish'] - $ACTUAL_TICK;

        if ($ticks_left < 0)
            $ticks_left = 0;



        $game->out('

	  <br><br>

	  Ankunft: ' . (($i < 10) ? '<b id="timer' . $i . '" title="time1_' . (($ticks_left *
            TICK_DURATION * 60) + $NEXT_TICK) . '_type2_2">&nbsp;</b>':format_time($ticks_left *
            TICK_DURATION)) . '

    ');

        $game->out('

    </td>

  </tr>

  </form>

</table><br>

	');



        ++$i;

    }



}



?>

