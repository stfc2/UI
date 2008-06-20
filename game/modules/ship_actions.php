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

// Neue Kampfdauern Kolo 12 Ticks Bomben 6 Ticks

$game->init_player();
$game->out('<center><span class="caption">Schiffsbewegungen</span></center><br>');


if(empty($_REQUEST['step'])) {
    message(GENERAL, 'Ungültige Paramterübergabe', '$_REQUEST[\'step\'] = empty');
}

$step = (!empty($_POST['step'])) ? $_POST['step'] : $_GET['step'];

// #############################################################################
// Es müssen Flotten für ship_actions übergeben werden

if(empty($_POST['fleets'])) {
    message(NOTICE, 'Keine Flotten ausgewählt');
}


// #############################################################################
// Die Flotten-IDs "säubern" (zu integer casten gegen SQL-Exploits)

$fleet_ids = array();

for($i = 0; $i < count($_POST['fleets']); ++$i) {
    $_temp = (int)$_POST['fleets'][$i];

    if(!empty($_temp)) {
        $fleet_ids[] = $_temp;
    }
}


// #############################################################################
// War eine gültige Flotten-ID dabei?

if(empty($fleet_ids)) {
    message(NOTICE, 'Keine gültige Flotte wurden übergeben');
}

$sql = 'SELECT *
        FROM ship_fleets
        WHERE fleet_id IN ('.implode(',', $fleet_ids).')';
        
if(!$q_fleets = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query fleet data');
}

$fleets = array($db->fetchrow($q_fleets));
$fleet_ids = array($fleets[0]['fleet_id']);

if(empty($fleets[0])) {
    message(NOTICE, 'Keine der Flotten konnte gefunden werden');
}

$planet_id = (int)$fleets[0]['planet_id'];

if($planet_id == 0) {
    message(NOTICE, 'Mindestens eine der ausgewählten Flotten ist nicht auf einem Planeten stationiert');
}

while($_temp = $db->fetchrow($q_fleets)) {
    if($_temp['planet_id'] == $planet_id) {
        $fleet_ids[] = $_temp['fleet_id'];
        $fleets[] = $_temp;
    }
}

$n_fleets = count($fleets);

if($n_fleets == 0) {
    message(NOTICE, 'Keine der Flotten konnte auf dem Planeten gefunden werden');
}

$fleet_ids_str = implode(',', $fleet_ids);


// #############################################################################
// Planetendaten holen

if($planet_id == $game->planet['planet_id']) {
    $planet = $game->planet;
    
    $planet['user_id'] = $game->player['user_id'];
    $planet['user_name'] = $game->player['user_name'];
    $planet['user_attack_protection'] = $game->player['user_attack_protection'];
    $planet['user_vacation_start'] = $game->player['user_vacation_start'];
    $planet['user_vacation_end'] = $game->player['user_vacation_end'];

    // Spielerdaten müssen nicht übernommen werden, da sie nicht angezeigt/benutzt werden
}
else {
    $sql = 'SELECT p.planet_id, p.planet_name, p.system_id, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y,
                   u.user_id, u.user_name, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
            FROM (planets p, starsystems s)
            LEFT JOIN (user u) ON u.user_id = p.planet_owner
            WHERE p.planet_id = '.$planet_id.' AND
                  s.system_id = p.system_id';
                  
    if(($planet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query start planet data');
    }

    if(empty($planet['planet_id'])) {
        message(NOTICE, 'Der Startplanet existiert nicht');
    }
    
    if(empty($planet['user_id'])) {
        $planet['user_id'] = 0;
        $planet['user_name'] = '';
        $planet['user_attack_protection'] = 0;
        $planet['user_vacation_start'] = 0;
        $planet['user_vacation_end'] = 0;
    }
}


// #############################################################################
// Welche Schiffsklassen sind dabei?
// (für Befehlsmöglichkeiten)

$sql = 'SELECT st.ship_torso, st.value_10 AS warp_speed
        FROM (ships s, ship_templates st)
        WHERE s.fleet_id IN ('.implode(',', $fleet_ids).') AND
              st.id = s.template_id';
        
if(!$q_stpls = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query ship template data');
}

$in_scout = $in_transporter = $in_colo = $in_orb = false;

while($_temp = $db->fetchrow($q_stpls)) {
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

}


// #############################################################################
// Ein paar Einstellungen setzen

$user_id = (!empty($_GET['user_id'])) ? (int)$_GET['user_id'] : 0;

$free_planet = ($planet['user_id'] == 0) ? true : false;
$own_planet = ($game->player['user_id'] == $planet['user_id']) ? true : false;

$planet_vacation = ($planet['user_vacation_start'] <= $ACTUAL_TICK) && ($planet['user_vacation_end'] > $ACTUAL_TICK) ? true : false;

$starter_atkptc = ($game->player['user_attack_protection'] > $ACTUAL_TICK) ? true : false;

if($in_orb){
  message(NOTICE, 'Du darfst Orbs nicht bewegen.');
}

// #############################################################################
// Wenn der Zielspieler nicht Besitzer des Planeten ist (und es einen Zieluser gibt),
// seine Daten holen

if(!empty($user_id)) {
    if($planet['user_id'] != $user_id) {
        $sql = 'SELECT f.fleet_id,
                       u.user_id, u.user_name, u.user_attack_protection, u.user_vacation_start, u.user_vacation_end
                FROM (ship_fleets f)
                INNER JOIN (user u) ON u.user_id = f.user_id
                WHERE f.planet_id = '.$planet_id.' AND
                      f.user_id = '.$user_id;

        if(($fleet = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query dest user fleets data');
        }

        if(empty($fleet['user_id'])) {
            message(NOTICE, 'Der gewählte Spieler hat keine Flotten/Planeten bei den angegeben Koordinaten');
        }
        
        $dest_atkptc = ($fleet['user_attack_protection'] > $ACTUAL_TICK) ? true : false;
        
        $planetary_dest = false;
        
        $other_party = &$fleet;
    }
}

if(!isset($dest_atkptc)) {
    $dest_atkptc = ($planet['user_attack_protection'] > $ACTUAL_TICK) ? true : false;
    $planetary_dest = true;
    
    $other_party = &$planet;
    
    $user_id = $planet['user_id'];
    
    if($planet_vacation) {
        message(NOTICE, 'Der Herrscher des Zielplaneten befindet sich um Urlaubsmodus');
    }
}

$atktpc_present = ($starter_atkptc || $dest_atkptc) ? true : false;



switch($step) {
    case 'surrender_exec':

        if($game->player['user_id']>10){
          message(NOTICE, 'Flottenübergabe - Cheatversuch!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Es dürfen keine Schiffe übergeben werden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }
        
        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die Schiffe schon dir');
        }
        
        if($planetary_dest && $free_planet) {
            message(NOTICE, 'Schiffe können nicht einem unbewohnten Planeten übergeben werden');
        }

        // #############################################################################
        // Schiffe übergeben

        $sql = 'UPDATE ships
                SET user_id = '.$user_id.'
                WHERE fleet_id iN ('.$fleet_ids_str.')';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update ships owner data');
        }

        $sql = 'UPDATE ship_fleets
                SET user_id = '.$user_id.'
                WHERE fleet_id IN ('.$fleet_ids_str.')';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets owner data');
        }

        // #############################################################################
        // Logbuch-Eintrag abschicken (sponsored by action_23.php)

        $sql = 'SELECT st.name, st.ship_torso, st.race,
                       COUNT(s.ship_id) AS n_ships
                FROM (ship_templates st, ship_fleets f, ships s)
                WHERE f.fleet_id IN ('.$fleet_ids_str.') AND
                      s.template_id = st.id AND
                      s.fleet_id = f.fleet_id
                GROUP BY st.id
                ORDER BY st.ship_torso ASC, st.race ASC';
                
        if(!$q_stpls = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query logbook data');
        }

        $log_data = array(23, $game->player['user_id'], $planet_id, $planet['planet_name'], $planet['user_id'], 0, 0, 0, array());

        while($stpl = $db->fetchrow($q_stpls)) {
            $log_data[8][] = array($stpl['name'], $stpl['ship_torso'], $stpl['race'], $stpl['n_ships']);
        }

        add_logbook_entry($user_id, LOGBOOK_TACTICAL, 'Flottenverband von '.$game->player['user_name'].' hat sich ergeben', $log_data);

        redirect('a=tactical_cartography&planet_id='.encode_planet_id($planet_id));
    break;

    case 'surrender_setup':
        if($game->player['user_id']>10){
          message(NOTICE, 'Flottenübergabe - Cheatversuch!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Es dürfen keine Schiffe übergeben werden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }
        
        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die Schiffe schon dir');
        }
    
        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_actions&step=surrender_exec&user_id='.$user_id).'" onSubmit="return document.send_form.submit.disabled = true;">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $game->out('
  <tr>
    <td>
      Standort: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet_id)).'"><b>'.$planet['planet_name'].'</b></a> ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')'.( ($planet['user_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$planet['user_id']).'"><b>'.$planet['user_name'].'</b></a>' : '' ).'<br><br>
      Flotten: <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      <b>Übergeben:</b><br>Die Schiffe werden die Kontrolle '.( ($planetary_dest) ? 'an den Herrscher des Planeten' : 'dem Befehlshaber der Flotte' ).' übergeben<br>
        ');

        if($in_transporter) {
            $resource_1 = $resource_2 = $resource_3 = $resource_4 = $unit_1 = $unit_2 = $unit_3 = $unit_4 = $unit_5 = $unit_6 = 0;

            for($i = 0; $i < $n_fleets; ++$i) {
                $resource_1 += $fleets[$i]['resource_1'];
                $resource_2 += $fleets[$i]['resource_2'];
                $resource_3 += $fleets[$i]['resource_3'];
                $resource_4 += $fleets[$i]['resource_4'];

                $unit_1 += $fleets[$i]['unit_1'];
                $unit_2 += $fleets[$i]['unit_2'];
                $unit_3 += $fleets[$i]['unit_3'];
                $unit_4 += $fleets[$i]['unit_4'];
                $unit_5 += $fleets[$i]['unit_5'];
                $unit_6 += $fleets[$i]['unit_6'];
            }

            $n_resources = $resource_1 + $resource_2 + $resource_3 + $resource_4;
            $n_units = $unit_1 + $unit_2 + $unit_3 + $unit_4 + $unit_5 + $unit_6;

            if($n_resources > 0) {
                if($resource_1 > 0) $game->out('<br>Metall: <b>'.$resource_1.'</b>');
                if($resource_2 > 0) $game->out('<br>Mineralien: <b>'.$resource_2.'</b>');
                if($resource_3 > 0) $game->out('<br>Latinum: <b>'.$resource_3.'</b>');
                if($resource_4 > 0) $game->out('<br>Arbeiter: <b>'.$resource_4.'</b>');
                $game->out('<br>');
            }

            if($n_units > 0) {
                if($unit_1 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$unit_1.'</b>');
                if($unit_2 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$unit_2.'</b>');
                if($unit_3 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$unit_3.'</b>');
                if($unit_4 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$unit_4.'</b>');
                if($unit_5 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$unit_5.'</b>');
                if($unit_6 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$unit_6.'</b>');
                $game->out('<br>');
            }
        }

        $game->out('
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="Durchführen"></center>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
    
    case 'attack_normal_exec':
    case 'attack_bomb_exec':
    case 'attack_invade_exec':
        if($game->SITTING_MODE){
            message(NOTICE, 'Du darfst im Sittingmodus nicht angreifen!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Es darf kein Kampf stattfinden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }

        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die Schiffe schon dir');
        }

        if($planetary_dest && $free_planet) {
            message(NOTICE, 'Lass doch den unbewohnten Planeten in Ruhe');
        }


        // #############################################################################
        // Move starten
        
        $sql = 'SELECT COUNT(ship_id) AS n_ships
                FROM ships
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

        if(($_nships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query real n_ships data');
        }

        $n_ships = $_nships['n_ships'];

        if($n_ships == 0) {
            message(GENERAL, 'Es fliegen keine Schiffe in den Flotten mit', 'Unexspected: $n_ships = 0');
        }
        
	$duration=2;
        switch($step) {
            case 'attack_normal_exec':
                $action_code = 51;
                $action_data = array((int)$user_id);
		$duration=2;
            break;
            
            case 'attack_bomb_exec':
                if(!$planetary_dest) {
                    message(NOTICE, 'Nur Planeten können bombardiert werden');
                }
                
                $focus = (int)$_POST['focus'];
                
                if($focus < 0) $focus = 0;
                if($focus > 3) $focus = 3;
                
                $action_code = 54;
                $action_data = array($focus);
		$duration=6;
            break;
            
            case 'attack_invade_exec':
                if(!$planetary_dest) {
                    message(NOTICE, 'Nur Planeten können übernommen werden');
                }
                
                if(!$in_colo) {
                    message(NOTICE, 'In keiner der Flotten befindet sich ein Kolonisationsschiff');
                }
            
                $action_code = 55;
                
                if(empty($_POST['ship_id'])) {
                    message(GENERAL, 'Ungültige Paramterübergabe', '$_POST[\'ship_id\'] = empty');
                }
                
                $action_data = array((int)$_POST['ship_id']);
		$duration=12;
            break;
        }

        $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
                VALUES ('.$game->player['user_id'].', 0, 0, '.$planet_id.', '.$planet_id.', 0, 0, 0, '.$ACTUAL_TICK.', '.($ACTUAL_TICK + $duration).', '.$n_ships.', '.$action_code.', "'.serialize($action_data).'")';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }
        
        $new_move_id = $db->insert_id();
        
        if(empty($new_move_id)) {
            message(GENERAL, 'Could not obtain new move id', '$new_move_id = empty');
        }
        
        $sql = 'UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.'
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets location data');
        }

        redirect('a=tactical_cartography&planet_id='.encode_planet_id($planet_id));
    break;

    
    case 'attack_setup':
        if($game->SITTING_MODE){
            message(NOTICE, 'Du darfst im Sittingmodus nicht angreifen!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Es darf kein Kampf stattfinden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }

        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die gegnerischen Streitkräfte dir?!');
        }

        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_actions&user_id='.$user_id).'" onSubmit="return document.send_form.submit.disabled = true;">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $game->out('
  <tr>
    <td>
      Standort: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet_id)).'"><b>'.$planet['planet_name'].'</b></a> ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')'.( ($planet['user_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$planet['user_id']).'"><b>'.$planet['user_name'].'</b></a>' : '' ).'<br><br>
      Flotten: <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      <b>Angreifen:</b><br>
        ');
        
        if($planetary_dest) {
            $game->out('
      Die Schiffe werden die planetare Verteidigung angreifen und...<br><br>
      <input type="radio" name="step" value="attack_normal_exec" checked="checked" onClick="return document.send_form.submit.value = \'Durchführen\';">&nbsp;<b>im Orbit bleiben</b><br>
      <input type="radio" name="step" value="attack_bomb_setup" onClick="return document.send_form.submit.value = \'Weiter >>\';">&nbsp;<b>Bombardieren</b><br>
      <input type="radio" name="step" value="attack_invade_setup"'.( (!$in_colo) ? ' disabled="disabled">&nbsp;Übernehmen<br>' : ' onClick="return document.send_form.submit.value = \'Weiter >>\';">&nbsp;<b>Übernehmen</b><br>' )
            );
        }
        else {
            $game->out('Die Schiffe werden die feindliche Flotte angreifen.<br><input type="hidden" name="step" value="attack_normal_exec">');
        }

        if($in_transporter) {
            $resource_1 = $resource_2 = $resource_3 = $resource_4 = $unit_1 = $unit_2 = $unit_3 = $unit_4 = $unit_5 = $unit_6 = 0;

            for($i = 0; $i < $n_fleets; ++$i) {
                $resource_1 += $fleets[$i]['resource_1'];
                $resource_2 += $fleets[$i]['resource_2'];
                $resource_3 += $fleets[$i]['resource_3'];
                $resource_4 += $fleets[$i]['resource_4'];

                $unit_1 += $fleets[$i]['unit_1'];
                $unit_2 += $fleets[$i]['unit_2'];
                $unit_3 += $fleets[$i]['unit_3'];
                $unit_4 += $fleets[$i]['unit_4'];
                $unit_5 += $fleets[$i]['unit_5'];
                $unit_6 += $fleets[$i]['unit_6'];
            }

            $n_resources = $resource_1 + $resource_2 + $resource_3 + $resource_4;
            $n_units = $unit_1 + $unit_2 + $unit_3 + $unit_4 + $unit_5 + $unit_6;

            if($n_resources > 0) {
                if($resource_1 > 0) $game->out('<br>Metall: <b>'.$resource_1.'</b>');
                if($resource_2 > 0) $game->out('<br>Mineralien: <b>'.$resource_2.'</b>');
                if($resource_3 > 0) $game->out('<br>Latinum: <b>'.$resource_3.'</b>');
                if($resource_4 > 0) $game->out('<br>Arbeiter: <b>'.$resource_4.'</b>');
                $game->out('<br>');
            }

            if($n_units > 0) {
                if($unit_1 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$unit_1.'</b>');
                if($unit_2 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$unit_2.'</b>');
                if($unit_3 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$unit_3.'</b>');
                if($unit_4 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$unit_4.'</b>');
                if($unit_5 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$unit_5.'</b>');
                if($unit_6 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$unit_6.'</b>');
                $game->out('<br>');
            }
        }

        $game->out('
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="Durchführen"></center>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
    
    case 'attack_bomb_setup':
        if($atkptc_present) {
            message(NOTICE, 'Es darf kein Kampf stattfinden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }
        
        if(!$planetary_dest) {
            message(NOTICE, 'Nur ein Planet kann bombardiert werden');
        }

        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die gegnerischen Streitkräfte dir?!');
        }

        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_actions&step=attack_bomb_exec&user_id='.$user_id).'" onSubmit="return document.send_form.submit.disabled = true;">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $game->out('
  <tr>
    <td>
      Standort: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet_id)).'"><b>'.$planet['planet_name'].'</b></a> ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')'.( ($planet['user_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$planet['user_id']).'"><b>'.$planet['user_name'].'</b></a>' : '' ).'<br><br>
      Flotten: <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      <b>Bombardieren:</b><br>
      Alle Schiffe mit planetaren Waffen werden nach dem Ausschalten der orbitalen Verteidigung die Planetenoberfläche angreifen. Dadurch können Gebäude zerstört und Arbeiter getötet werden.<br><b>Wenn kein Schiff planetare Waffen besitzt, kann auch kein Bombardement stattfinden!<br>Der planetare Angriff wird solange fortgesetzt, bis er abgebrochen oder alle Gebäude auf dem Planeten zerstört wurden.</b>
      <br><br>
      <input type="radio" name="focus" value="0" checked="checked">&nbsp;alles bombardieren<br>
      <input type="radio" name="focus" value="1">&nbsp;konzentrieren auf Minen<br>
      <input type="radio" name="focus" value="2">&nbsp;konzentrieren auf Produktionsgebäude<br>
      <input type="radio" name="focus" value="3">&nbsp;konzentrieren auf Regierung/Forschung<br><br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="Durchführen"></center>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
    
    case 'attack_invade_setup':
        if($atkptc_present) {
            message(NOTICE, 'Es darf kein Kampf stattfinden, da eine der beiden Parteien noch unter Angriffsschutz steht');
        }

        if($other_party['user_id'] == $game->player['user_id']) {
            message(NOTICE, 'Als ich das letzte Mal nachgesehen habe, gehörten die gegnerischen Streitkräfte dir?!');
        }
        
        if(!$planetary_dest) {
            message(NOTICE, 'Nur ein Planet kann übernommen werden');
        }
        
        if(!$in_colo) {
            message(NOTICE, 'In keiner der Flotten befindet sich ein Kolonisationsschiff');
        }

        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_actions&step=attack_invade_exec&user_id='.$user_id).'" onSubmit="return document.send_form.submit.disabled = true;">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }
        
        $sql = 'SELECT s.ship_id, s.hitpoints, s.experience, s.unit_1, s.unit_2, s.unit_3, s.unit_4,
                       st.name, st.value_5 AS max_hitpoints
                FROM (ships s, ship_templates st)
                WHERE s.fleet_id IN ('.$fleet_ids_str.') AND
                      st.id = s.template_id AND
                      st.ship_torso = '.SHIP_TYPE_COLO;
                      
        if(!$q_cships = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query colonisation ship data');
        }
        
        $first_cship = $db->fetchrow($q_cships);
        
        if(empty($first_cship['ship_id'])) {
            message(GENERAL, 'Unexspected: Second try to find colo ship failed', '$first_cship[\'ship_id\'] = empty');
        }

        $game->out('
  <tr>
    <td>
      Standort: <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet_id)).'"><b>'.$planet['planet_name'].'</b></a> ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')'.( ($planet['user_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$planet['user_id']).'"><b>'.$planet['user_name'].'</b></a>' : '' ).'<br><br>
      Flotten: <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      <b>Angreifen und Übernehmen:</b><br>
      Die Schiffe werden die planetare Verteidigung angreifen. Wenn diese ausgeschaltet wurde, versuchen die auf den Transportern der Flotte befindlichen Bodentruppen sowie die des verwenden Kolonisationsschiff die Kontrolle über den Planeten zu erlangen. Dabei wird das Kolonieschiff benutzt, um auf den Planeten zu laden und das provisorische Hauptquartier zu errichten.<br><br>
      Folgendes Kolonieschiff wird bei dem Übernahmeversuch benutzt:<br><br>
      
      <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="20" align="right"><input type="radio" name="ship_id" value="'.$first_cship['ship_id'].'" checked="checked"></td>
          <td width="350" align="left"><b>'.$first_cship['name'].'</b> ('.$first_cship['hitpoints'].'/'.$first_cship['max_hitpoints'].', Exp: '.$first_cship['experience'].')<br>Besatzung: '.$first_cship['unit_1'].'/'.$first_cship['unit_2'].'/'.$first_cship['unit_3'].'/'.$first_cship['unit_4'].'</td>
        </tr>
        ');

        while($cship = $db->fetchrow($q_cships)) {
            $game->out('
        <tr>
          <td align="right"><input type="radio" name="ship_id" value="'.$cship['ship_id'].'"></td>
          <td align="left"><b>'.$cship['name'].'</b> ('.$cship['hitpoints'].'/'.$cship['max_hitpoints'].', Exp: '.$cship['experience'].')<br>Besatzung: '.$cship['unit_1'].'/'.$cship['unit_2'].'/'.$cship['unit_3'].'/'.$cship['unit_4'].'</td>
        </tr>
            ');
        }
        
        $game->out('</table><br><br>');


        if($in_transporter) {
            $resource_1 = $resource_2 = $resource_3 = $resource_4 = $unit_1 = $unit_2 = $unit_3 = $unit_4 = $unit_5 = $unit_6 = 0;

            for($i = 0; $i < $n_fleets; ++$i) {
                $resource_1 += $fleets[$i]['resource_1'];
                $resource_2 += $fleets[$i]['resource_2'];
                $resource_3 += $fleets[$i]['resource_3'];
                $resource_4 += $fleets[$i]['resource_4'];

                $unit_1 += $fleets[$i]['unit_1'];
                $unit_2 += $fleets[$i]['unit_2'];
                $unit_3 += $fleets[$i]['unit_3'];
                $unit_4 += $fleets[$i]['unit_4'];
                $unit_5 += $fleets[$i]['unit_5'];
                $unit_6 += $fleets[$i]['unit_6'];
            }

            $n_resources = $resource_1 + $resource_2 + $resource_3 + $resource_4;
            $n_units = $unit_1 + $unit_2 + $unit_3 + $unit_4 + $unit_5 + $unit_6;

            if($n_resources > 0) {
                if($resource_1 > 0) $game->out('<br>Metall: <b>'.$resource_1.'</b>');
                if($resource_2 > 0) $game->out('<br>Mineralien: <b>'.$resource_2.'</b>');
                if($resource_3 > 0) $game->out('<br>Latinum: <b>'.$resource_3.'</b>');
                if($resource_4 > 0) $game->out('<br>Arbeiter: <b>'.$resource_4.'</b>');
                $game->out('<br>');
            }

            if($n_units > 0) {
                if($unit_1 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][0].': <b>'.$unit_1.'</b>');
                if($unit_2 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][1].': <b>'.$unit_2.'</b>');
                if($unit_3 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][2].': <b>'.$unit_3.'</b>');
                if($unit_4 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][3].': <b>'.$unit_4.'</b>');
                if($unit_5 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][4].': <b>'.$unit_5.'</b>');
                if($unit_6 > 0) $game->out('<br>'.$UNIT_NAME[$game->player['user_race']][5].': <b>'.$unit_6.'</b>');
                $game->out('<br>');
            }
        }

        $game->out('
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="Durchführen"></center>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
    
    case 'colo_exec':

        if($game->SITTING_MODE){
            message(NOTICE, 'Im Sittingmodus ist das Kolonisieren nicht erlaubt!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Mit aktiviertem Angriffsschutz dürfen keine unbewohnten Planeten kolonisiert werden.');
        }

        if(!$free_planet) {
            message(NOTICE, 'Der Planet ist nicht unbewohnt...');
        }

        if(!$planetary_dest) {
            message(NOTICE, 'Nur ein Planet kann kolonisiert werden');
        }

        if(!$in_colo) {
            message(NOTICE, 'In keiner der Flotten befindet sich ein Kolonisationsschiff');
        }
        
        // #############################################################################
        // Move starten

        $sql = 'SELECT COUNT(ship_id) AS n_ships
                FROM ships
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

        if(($_nships = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query real n_ships data');
        }

        $n_ships = $_nships['n_ships'];

        if($n_ships == 0) {
            message(GENERAL, 'Es fliegen keine Schiffe in den Flotten mit', 'Unexspected: $n_ships = 0');
        }

        if(empty($_POST['ship_id'])) {
            message(GENERAL, 'Ungültige Paramterübergabe', '$_POST[\'ship_id\'] = empty');
        }
        
        $ship_id = (int)$_POST['ship_id'];
        
        $sql = 'INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
                VALUES ('.$game->player['user_id'].', 0, 0, '.$planet_id.', '.$planet_id.', 0, 0, 0, '.$ACTUAL_TICK.', '.($ACTUAL_TICK + 1).', '.$n_ships.', 24, "'.serialize(array($ship_id)).'")';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }

        $new_move_id = $db->insert_id();

        if(empty($new_move_id)) {
            message(GENERAL, 'Could not obtain new move id', '$new_move_id = empty');
        }

        $sql = 'UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.'
                WHERE fleet_id IN ('.implode(',', $fleet_ids).')';

        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update fleets location data');
        }

        redirect('a=tactical_cartography&planet_id='.encode_planet_id($planet_id));
    break;
    
    case 'colo_setup':
        if($game->SITTING_MODE){
            message(NOTICE, 'Im Sittingmodus ist das Kolonisieren nicht erlaubt!');
        }

        if($atkptc_present) {
            message(NOTICE, 'Mit aktiviertem Angriffsschutz dürfen keine unbewohnten Planeten kolonisiert werden.');
        }

        if(!$free_planet) {
            message(NOTICE, 'Der Planet ist nicht unbewohnt...');
        }

        if(!$planetary_dest) {
            message(NOTICE, 'Nur ein Planet kann kolonisiert werden');
        }

        if(!$in_colo) {
            message(NOTICE, 'In keiner der Flotten befindet sich ein Kolonisationsschiff');
        }

        $game->out('
<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
  <form name="send_form" method="post" action="'.parse_link('a=ship_actions&step=colo_exec').'" onSubmit="return document.send_form.submit.disabled = true;">
        ');

        $fleet_option_html = '';

        for($i = 0; $i < $n_fleets; ++$i) {
            $fleet_option_html .= '<option>'.$fleets[$i]['fleet_name'].' ('.$fleets[$i]['n_ships'].')</option>';
            $game->out('<input type="hidden" name="fleets[]" value="'.$fleets[$i]['fleet_id'].'">');
        }

        $sql = 'SELECT s.ship_id, s.hitpoints, s.experience, s.unit_1, s.unit_2, s.unit_3, s.unit_4,
                       st.name, st.value_5 AS max_hitpoints
                FROM (ships s, ship_templates st)
                WHERE s.fleet_id IN ('.$fleet_ids_str.') AND
                      st.id = s.template_id AND
                      st.ship_torso = '.SHIP_TYPE_COLO;

        if(!$q_cships = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query colonisation ship data');
        }

        $first_cship = $db->fetchrow($q_cships);

        if(empty($first_cship['ship_id'])) {
            message(GENERAL, 'Unexspected: Second try to find colo ship failed', '$first_cship[\'ship_id\'] = empty');
        }

        $game->out('
  <tr>
    <td>
      Standort: <i>unbewohnt</i> ('.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y']).':'.($planet['planet_distance_id'] + 1).')
      Flotten: <select style="width: 200px;">'.$fleet_option_html.'</select><br><br>
      <b>Kolonisieren:</b><br>
      Der Zielplanet wird, wenn er unbewohnt ist, von einem Kolonisationsschiff der Flotte kolonisiert. Dabei wird dieses Schiff demontiert und daraus das erste Gebäude gebaut. Seine überschüssige Besatzung wird auf dem Planeten stationiert. Die anderen Schiffe bleiben im Orbit des Planeten.<br><br>
      Folgendes Kolonieschiff wird bei der Kolonisation benutzt:<br><br>

      <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="20" align="right"><input type="radio" name="ship_id" value="'.$first_cship['ship_id'].'" checked="checked"></td>
          <td width="350" align="left"><b>'.$first_cship['name'].'</b> ('.$first_cship['hitpoints'].'/'.$first_cship['max_hitpoints'].', Exp: '.$first_cship['experience'].')<br>Besatzung: '.$first_cship['unit_1'].'/'.$first_cship['unit_2'].'/'.$first_cship['unit_3'].'/'.$first_cship['unit_4'].'</td>
        </tr>
        ');

        while($cship = $db->fetchrow($q_cships)) {
            $game->out('
        <tr>
          <td align="right"><input type="radio" name="ship_id" value="'.$cship['ship_id'].'"></td>
          <td align="left"><b>'.$cship['name'].'</b> ('.$cship['hitpoints'].'/'.$cship['max_hitpoints'].', Exp: '.$cship['experience'].')<br>Besatzung: '.$cship['unit_1'].'/'.$cship['unit_2'].'/'.$cship['unit_3'].'/'.$cship['unit_4'].'</td>
        </tr>
            ');
        }

        $game->out('
      </table><br><br>
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="submit" value="Durchführen"></center>
    </td>
  </tr>
  </form>
</table>
      ');
    break;
    
    default:
        message(GENERAL, 'Ungültige Parameterübergabe', '$step = "'.$step.'"');
    break;
}

1?>
