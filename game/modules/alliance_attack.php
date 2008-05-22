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



include('include/libs/moves.php');

$game->init_player();
$game->out('<center><span class="caption">Allianz:</span><br><br>');

 $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance_rights = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }


if(empty($game->player['alliance_name'])) {
    message(NOTICE, 'Du bist nicht Mitglied einer Allianz');
}

if($game->player['user_alliance_rights3']!=1) {
    message(NOTICE, 'Du besitzt nicht die erforderlichen Rechte zum Betrachten der Seite');
}

$game->out('
<table class="style_outer" width="550" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br><br>
      <table width="520" align="center" border="0" cellpadding="0" cellspacing="2">
        <tr><td width="520" align="left"><i>Taktische Übersicht - Feindliche Angriffe</i></td></tr>
      </table>
      <table width="520" align="center" border="0" cellpadding="0" cellspacing="8">
        <tr><td width="520" align="left">Hier werden alle Angriffe auf deine Allianz aufgelistet, die auf den Planeten eines Mitgliedes durchgeführt werden.</td></tr>
      </table>

      <table class="style_inner" width="520" align="center" border="0" cellpadding="2" cellspacing="2">
		<tr><td width=520>
		
			
		<table width="520" align="center" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td width="90">Spieler:</td>
			<td width="95">Planet:</td>
			<td width="140">Angreifer:</td>
			<td width="60">Schiffe:</td>
			<td width="60">Befehl:</td>
			<td width="75">Ankunft:</td>
		</tr>
');

$sql = 'SELECT ss.user_id AS start_user_id, ss.dest, ss.move_begin, ss.move_finish, ss.action_code, ss.n_ships,
               SUM(st.value_11) AS sum_atk_sensors,
               SUM(st.value_12) AS sum_atk_cloak,
               
               u1.user_id AS dest_user_id, u1.user_name AS dest_user_name,
               p1.planet_name AS dest_name, p1.building_7 AS dest_spacedock,
               SUM(st.value_11) AS sum_dfd_sensors,
               SUM(st.value_12) AS sum_dfd_cloak,

               u2.user_name AS start_user_name,
               a.alliance_id AS start_alliance_id, a.alliance_tag AS start_alliance_tag

        FROM (planets p1, user u1, scheduler_shipmovement ss)

        -- für Summe der Sensoren/Tarnung des Angreifers
        INNER JOIN (ship_fleets f) ON f.move_id = ss.move_id
        INNER JOIN (ships s) ON s.fleet_id = f.fleet_id
        INNER JOIN (ship_templates st) ON st.id = s.template_id
        
        -- für Daten des Angreifers
        INNER JOIN (user u2) ON u2.user_id = ss.user_id
        LEFT JOIN (alliance a) ON a.alliance_id = u2.user_alliance
        
        WHERE u1.user_id = p1.planet_owner AND
              u1.user_alliance = '.$game->player['user_alliance'].' AND
              ss.move_status = 0 AND
              ss.dest = p1.planet_id AND
              ss.action_code IN  (24,25,40,41,42,43,44,45,50,51,52,53,54,55)
        GROUP BY ss.move_id
        ORDER BY p1.planet_next_attack ASC';
        
if(!$q_moves = $db->query($sql)){
    message(DATABASE_ERROR, 'Could not query moves data');
}

$commands = array(
    41 => 'Angreifen',
    42 => 'Angreifen',
    51 => 'Angreifen',
    52 => '(error)',
    53 => 'Plündern',
    54 => 'Bombardieren',
    55 => 'Übernehmen'
);

while($move = $db->fetchrow($q_moves)) {
    $dest_fleets = get_friendly_orbit_fleets($move['dest'], $move['dest_user_id']);

    $visibility = GetVisibility($move['sum_atk_sensors'] + ( $move['Dest_spacedock'] + 1) * 200, $move['sum_atk_cloak'], $move['n_ships'], $dest_fleets['sum_sensors'], $dest_fleets['sum_cloak']);
    $travelled = 100 / ($move['move_finish'] - $move['move_begin']) * ($ACTUAL_TICK - $move['move_begin']);
    
	if($travelled >= $visibility)  {
        $n_ships = ($travelled >= $visibility + ((100 - $visibility) / 4)) ? $move['n_ships'] : '-';	
        $command = ($travelled >= $visibility + 2 * ((100 - $visibility) / 4)) ? $commands[$move['action_code']] : '-';
        
	    $game->out('
		<tr>
          <td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['dest_user_id']).'">'.$move['dest_user_name'].'</a></td>
          <td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($move['dest'])).'">'.$move['dest_name'].'</a></td>
          <td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['start_user_id']).'">'.$move['start_user_name'].'</a>'.( (!empty($move['start_alliance_id'])) ? ' [<a href="'.parse_link('a=stats&a2=viewalliance&id='.$move['start_alliance_id']).'">'.$move['start_alliance_tag'].'</a>]' : '' ).'</td>
          <td>'.$n_ships.'</td>
          <td>'.$command.'</td>
          <td>'.format_time( ($move['move_finish'] - $ACTUAL_TICK) * TICK_DURATION ).'</td>
        </tr>
        ');
	}
}

$game->out('
      </table>
    </td>
  </tr>
</table>

<br><br><br><br>

<table width="520" align="center" border="0" cellpadding="0" cellspacing="2">
  <tr><td width="520" align="left"><i>Taktische Übersicht - Eigene Angriffe</i></td></tr>
</table>

<table width="520" align="center" border="0" cellpadding="0" cellspacing="8">
  <tr><td width="520" align="left">Hier werden alle Angriffe deiner Allianz gegen andere Spieler aufgelistet. Hier werden ALLE Angriffe (sowohl auf Planeten wie auf Schiffe) aufgelistet.</td></tr>
</table>

<table class="style_inner" width="520" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr><td width=520>

  <table width="520" align="center" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td width="90">Angreifer:</td>
      <td width="140">Opfer:</td>
      <td width="95">Planet:</td>
      <td width="60">Schiffe:</td>
      <td width="60">Befehl:</td>
      <td width="75">Ankunft:</td>
    </tr>
');

$sql = 'SELECT ss.user_id AS start_user_id, ss.dest, ss.move_begin, ss.move_finish, ss.action_code, ss.action_data, ss.n_ships,
               u1.user_name AS start_user_name,
               
               p2.planet_name AS dest_planet_name,
               u2.user_id AS dest_user_id, u2.user_name AS dest_user_name,
               a.alliance_id AS dest_alliance_id, a.alliance_tag AS dest_alliance_tag
               
        FROM (user u1, scheduler_shipmovement ss)
        
        INNER JOIN (planets p2) ON p2.planet_id = ss.dest
        LEFT JOIN (user u2) ON u2.user_id = p2.planet_owner
        LEFT JOIN (alliance a) ON a.alliance_id = u2.user_alliance
        
        WHERE u1.user_alliance = '.$game->player['user_alliance'].' AND
              ss.user_id = u1.user_id AND
              ss.move_status = 0 AND
              ss.action_code > 40
        GROUP BY ss.move_id
        ORDER BY ss.move_finish ASC';
        
if(($q_moves = $db->query($sql)) === false){
    message(DATABASE_ERROR, 'Could not query moves data');
}

	$commands=array(11=>'Stationieren',12=>'Zurückfliegen',13=>'Zurückfliegen',14=>'Transportieren',

	21=>'Stationieren',22=>'Spionieren',23=>'Übergeben',24=>'Kolonisieren',25=>'Kolonisieren',

	31=>'Transportieren',32=>'Ferengitransport',33=>'Auktionsflotte',

	34=>'Handelsroute',35=>'Handelsroute',36=>'Handelsroute',37=>'Handelsroute',38=>'Handelsroute',39=>'Handelsroute',

	40=>'Angreifen',41=>'Angreifen',42=>'Angreifen',43=>'Plündern',44=>'Bombardieren',45=>'Kolonisieren',

	51=>'Angreifen',53=>'Plündern',54=>'Bombardieren',55=>'Kolonisieren',

	);
	
while($move = $db->fetchrow($q_moves)) {
    $attacked_user = array($move['dest_user_id'], $move['dest_user_name'], $move['dest_alliance_id'], $move['dest_alliance_tag']);

    // Bei 51 könnte auch eine freie Flotte angegriffen werden
    if($move['action_code'] == 51) {
        $action_data = (array)unserialize($move['action_data']);
        
        if(!empty($action_data[0])) {
            $user_id = (int)$action_data[0];

            $sql = 'SELECT u.user_id, u.user_name,
                           a.alliance_id, a.alliance_tag
                    FROM (user u)
                    LEFT JOIN (alliance a) ON a.alliance_id = u.user_alliance
                    WHERE u.user_id = '.$user_id;
                    
            if(($user = $db->queryrow($sql)) === false) {
                message(DATABASE_ERROR, 'Could not query user/alliance data');
            }
            
            if(!empty($user['user_id'])) {
                $attacked_user = array($user_id, $user['user_name'], $user['alliance_id'], $user['alliance_tag']);
            }
        }
    }

    $game->out('
    <tr>
      <td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$move['start_user_id']).'">'.($move['start_user_name']).'</a></td>
      <td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$attacked_user[0]).'">'.$attacked_user[1].'</a>'.( (!empty($attacked_user[2])) ? ' [<a href="'.parse_link('a=stats&a2=viewalliance&id='.$attacked_user[2]).'">'.$attacked_user[3].'</a>]' : '' ).'</td>
      <td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($move['dest'])).'">'.$move['dest_planet_name'].'</a></td>
      <td>'.$move['n_ships'].'</td>
      <td>'.$commands[$move['action_code']].'</td>
      <td>'.format_time( ($move['move_finish'] - $ACTUAL_TICK) * TICK_DURATION ).'</td>
    </tr>
    ');
}

$game->out('</table></td></tr></table><br></td></tr></table>');

?>
