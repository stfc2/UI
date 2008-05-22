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


if(!empty($_POST['from_submit'])) {
    $db->lock('ship_fleets', 'ships', 'ship_templates');
    $game->init_player();

    $fleet_id = (int)$_GET['from'];
    
    $sql = 'SELECT ship_fleets.*,
                   planets.planet_id, planets.planet_owner,
                   planets.resource_1 AS avail_resource_1, planets.resource_2 AS avail_resource_2, planets.resource_3 AS avail_resource_3, planets.resource_4 AS avail_resource_4,
                   planets.unit_1 AS avail_unit_1, planets.unit_2 AS avail_unit_2, planets.unit_3 AS avail_unit_3, planets.unit_4 AS avail_unit_4, planets.unit_5 AS avail_unit_5, planets.unit_6 AS avail_unit_6
            FROM ship_fleets
            INNER JOIN planets ON planets.planet_id = ship_fleets.planet_id
            WHERE ship_fleets.fleet_id = '.$fleet_id;

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }
    
    if(empty($fleet['planet_id'])) {
        message(NOTICE, 'Der Planet der Flotte konnte nicht gefunden werden');
    }
    
    if($fleet['user_id'] != $fleet['planet_owner']) {
        message(NOTICE, 'Es dürfen nur Ressourcen von einem eigenen Planeten transportiert werden');
    }

    $sql = 'SELECT COUNT(ships.ship_id) AS n_transporter
            FROM ships, ship_templates
            WHERE ships.fleet_id = '.$fleet_id.' AND
                  ship_templates.id = ships.template_id AND
                  ship_templates.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n_transporter = $trpt_count['n_transporter'];
    
    if($n_transporter == 0) {
        message(NOTICE, 'In der Flotte befinden sich keine Transporter');
    }
    
    $max_fresources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_funits = $n_transporter * MAX_TRANSPORT_UNITS;
    
    $nwares = $fwares = $pwares = array();
    
    /*
     * Dies ist eigentlich noch ein Relikt aus der Zeit, in der das Modul gleichzeitig be-/entladen
     * kï¿½nen sollte...vielleicht kommt das spï¿½er wider einmal rein...
     *
     * $pwares -> Waren auf dem Planeten
     * $fwares -> Waren auf der Flotte
     * $nwares -> Waren, die der Flotte hinzugefgt werden soll
     *
     * $max_ -> Maximal-Wert
     * $n_   -> Aktueller Gesamt-Wert
     */
    
    $wares_names = get_wares_names();

    // POST-variablen parsen + SQL-daten auf integer casten
    foreach($wares_names as $key => $name) {
        $nwares[$key] = (!empty($_POST['add_'.$key])) ? abs((int)$_POST['add_'.$key]) : 0;
        $fwares[$key] = (int)$fleet[$key];
        $pwares[$key] = (int)$fleet['avail_'.$key];
    }
    
    $n_presources = $pwares['resource_1'] + $pwares['resource_2'] + $pwares['resource_3'];
    $n_pworker = $pwares['resource_4'];
    $n_punits = $pwares['unit_1'] + $pwares['unit_2'] + $pwares['unit_3'] + $pwares['unit_4'] + $pwares['unit_5'] + $pwares['unit_6'];
    
    $n_fresources = $fwares['resource_1'] + $fwares['resource_2'] + $fwares['resource_3'];
    $n_funits = $fwares['resource_4'] + $fwares['unit_1'] + $fwares['unit_2'] + $fwares['unit_3'] + $fwares['unit_4'] + $fwares['unit_5'] + $fwares['unit_6'];
    
    $fleet_overloaded = false;
    
    foreach($nwares as $key => $value) {
        if($value > $pwares[$key]) {
            message(NOTICE, 'Auf dem Planeten fehlen: '.$value.' '.$wares_names[$key]);
        }
        
        if( ($key == 'resource_1') || ($key == 'resource_2') || ($key == 'resource_3') ) {
            if( ($n_fresources + $value) > $max_fresources) {
                $value = $max_fresources - $n_fresources;
                $fleet_overloaded = true;
            }
            
            $n_fresources += $value;
        }
        else {
            if( ($n_funits + $value) > $max_funits) {
                $value = $max_funits - $n_funits;
                $fleet_overloaded = true;
            }
            
            $n_funits += $value;
        }

        $fwares[$key] += $value;
        $pwares[$key] -= $value;
        
        if($fleet_overloaded) break;
    }
    
    $sql = 'UPDATE planets
            SET resource_1 = '.$pwares['resource_1'].',
                resource_2 = '.$pwares['resource_2'].',
                resource_3 = '.$pwares['resource_3'].',
                resource_4 = '.$pwares['resource_4'].',
                unit_1 = '.$pwares['unit_1'].',
                unit_2 = '.$pwares['unit_2'].',
                unit_3 = '.$pwares['unit_3'].',
                unit_4 = '.$pwares['unit_4'].',
                unit_5 = '.$pwares['unit_5'].',
                unit_6 = '.$pwares['unit_6'].'
            WHERE planet_id = '.$fleet['planet_id'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update planets wares data');
    }
    
    $sql = 'UPDATE ship_fleets
            SET resource_1 = '.$fwares['resource_1'].',
                resource_2 = '.$fwares['resource_2'].',
                resource_3 = '.$fwares['resource_3'].',
                resource_4 = '.$fwares['resource_4'].',
                unit_1 = '.$fwares['unit_1'].',
                unit_2 = '.$fwares['unit_2'].',
                unit_3 = '.$fwares['unit_3'].',
                unit_4 = '.$fwares['unit_4'].',
                unit_5 = '.$fwares['unit_5'].',
                unit_6 = '.$fwares['unit_6'].'
            WHERE fleet_id = '.$fleet_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update fleets wares data');
    }
    
    $db->unlock();

    if($fleet_overloaded) {
        $game->out('<center><span class="caption">Flotten:</span></center>');

        message(NOTICE, 'Nicht alle Rohstoffe/Arbeiter/Einheiten konnten beladen werden,<br>da das Maximum der Flotte erreicht wurde.<br><br><a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'">zurck zur ï¿½ersicht</a>');
    }
    else {
        redirect('a=ship_fleets_display&pfleet_details='.$fleet_id);
    }
}
elseif(!empty($_GET['from'])) {
    $game->init_player();

    $fleet_id = (int)$_GET['from'];

    if(empty($fleet_id)) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }

    $sql = 'SELECT f.*,
                   p.planet_id, p.planet_owner,
                   p.resource_1 AS avail_resource_1, p.resource_2 AS avail_resource_2, p.resource_3 AS avail_resource_3, p.resource_4 AS avail_resource_4,
                   p.unit_1 AS avail_unit_1, p.unit_2 AS avail_unit_2, p.unit_3 AS avail_unit_3, p.unit_4 AS avail_unit_4, p.unit_5 AS avail_unit_5, p.unit_6 AS avail_unit_6
            FROM (ship_fleets f)
            INNER JOIN (planets p) ON p.planet_id = f.planet_id
            WHERE f.fleet_id = '.$fleet_id;

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, 'Die gewï¿½lte Flotte existiert nicht');
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }

    if(empty($fleet['planet_id'])) {
        message(NOTICE, 'Der Planet der Flotte konnte nicht gefunden werden');
    }

    if($fleet['planet_owner'] != $game->player['user_id']) {
        message(NOTICE, 'Es dürfen nur Ressourcen von einem eigenen Planeten transportiert werden');
    }

    $sql = 'SELECT COUNT(s.ship_id) AS n_transporter
            FROM (ships s), (ship_templates st)
            WHERE s.fleet_id = '.$fleet_id.' AND
                  st.id = s.template_id AND
                  st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n_transporter = $trpt_count['n_transporter'];
    

    if($n_transporter == 0) {
        message(NOTICE, 'In der Flotte befinden sich keine Transporter');
    }
    
    $max_resources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_units = $n_transporter * MAX_TRANSPORT_UNITS;

    $game->out('
<center><span class="caption">Flotten:</span></center><br>

<table class="style_inner" width="400" align="center" border="0" cellpadding="4" cellspacing="2">
  <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingp&from='.$fleet_id).'" onSubmit="return document.load_form.submit_button.disabled = true;">
  <input type="hidden" name="from_submit" value="1">
  <tr>
    <td>
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="200" align="left"><b>'.$fleet['fleet_name'].'</b></td>
          <td width="200" align="right">'.( ($fleet['n_ships'] == 1) ? '<b>1</b> Schiff' : '<b>'.$fleet['n_ships'].'</b> Schiffe' ).'</td>
        </tr>
      </table><br>
      Transporter in der Flotte: <b>'.$n_transporter.'</b><br>
      Maximal transportierbare Rohstoffe: <b>'.$max_resources.'</b> (frei: <b>'.($max_resources - $fleet['resource_1'] - $fleet['resource_2'] - $fleet['resource_3']).'</b>)<br>
      Maximal transportierbare Personen: <b>'.$max_units.'</b> (frei: <b>'.($max_units - $fleet['resource_4'] - $fleet['unit_1'] - $fleet['unit_2'] - $fleet['unit_3'] - $fleet['unit_4'] - $fleet['unit_5'] - $fleet['unit_6']).'</b>)<br><br>
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="80">&nbsp;</td>
          <td width="120" align="center"><b>auf Planet</b></td>
          <td width="120" align="center"><b>auf Flotte</b></td>
          <td width="80" align="center">&nbsp;</td>
        </tr>
    ');
    
    if($fleet['avail_resource_1'] > 0) {
        $game->out('
        <tr>
          <td>Metall</td>
          <td align="center">'.floor($fleet['avail_resource_1']).'</td><td align="center">'.$fleet['resource_1'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_1" value=""></td>
        </tr>
        ');
    }
    
    if($fleet['avail_resource_2'] > 0) {
        $game->out('
        <tr>
          <td>Mineralien</td>
          <td align="center">'.floor($fleet['avail_resource_2']).'</td><td align="center">'.$fleet['resource_2'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_2" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_resource_3'] > 0) {
        $game->out('
        <tr>
          <td>Latinum</td>
          <td align="center">'.floor($fleet['avail_resource_3']).'</td><td align="center">'.$fleet['resource_3'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_3" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_resource_4'] > 0) {
        $game->out('
        <tr>
          <td>Arbeiter</td>
          <td align="center">'.floor($fleet['avail_resource_4']).'</td><td align="center">'.$fleet['resource_4'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_4" value=""></td>
        </tr>
        ');
    }
    
    if($fleet['avail_unit_1'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][0].'</td>
          <td align="center">'.$fleet['avail_unit_1'].'</td><td align="center">'.$fleet['unit_1'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_1" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_unit_2'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][1].'</td>
          <td align="center">'.$fleet['avail_unit_2'].'</td><td align="center">'.$fleet['unit_2'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_2" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_unit_3'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][2].'</td>
          <td align="center">'.$fleet['avail_unit_3'].'</td><td align="center">'.$fleet['unit_3'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_3" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_unit_4'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][3].'</td>
          <td align="center">'.$fleet['avail_unit_4'].'</td><td align="center">'.$fleet['unit_4'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_4" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_unit_5'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][4].'</td>
          <td align="center">'.$fleet['avail_unit_5'].'</td><td align="center">'.$fleet['unit_5'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_5" value=""></td>
        </tr>
        ');
    }
        
    if($fleet['avail_unit_6'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][5].'</td>
          <td align="center">'.$fleet['avail_unit_6'].'</td><td align="center">'.$fleet['unit_6'].'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_6" value=""></td>
        </tr>
        ');
    }
    
    $game->out('
      </table>
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" onClick="return window.location.href = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="Übernehmen"></center>
    </td>
  </tr>
  </form>
</table>
    ');
}
elseif(!empty($_POST['to_submit'])) {
    $db->lock('ship_fleets', 'ships', 'ship_templates', 'bidding_owed');
    $game->init_player();

    $fleet_id = (int)$_GET['to'];
    
    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : 'a=ship_fleets_display&pfleet_details='.$fleet_id;

    $sql = 'SELECT ship_fleets.*,
                   planets.planet_id, planets.planet_owner AS owner_id,
                   planets.resource_1 AS presource_1, planets.resource_2 AS presource_2, planets.resource_3 AS presource_3, planets.resource_4 AS presource_4,
                   planets.unit_1 AS punit_1, planets.unit_2 AS punit_2, planets.unit_3 AS punit_3, planets.unit_4 AS punit_4, planets.unit_5 AS punit_5, planets.unit_6 AS punit_6,
                   planets.max_resources AS max_presources, planets.max_worker AS max_pworker, planets.max_units AS max_punits
            FROM ship_fleets
            INNER JOIN planets ON planets.planet_id = ship_fleets.planet_id
            WHERE ship_fleets.fleet_id = '.$fleet_id;

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht');
    }

    if(empty($fleet['planet_id'])) {
        message(NOTICE, 'Der Planet der Flotte konnte nicht gefunden werden');
    }

    if($fleet['owner_id'] != $fleet['user_id']) {
        message(NOTICE, 'Es dürfen Ressourcen von eigenen Schiffen transferiert werden.');
    }

    if(empty($fleet['owner_id'])) {
        message(NOTICE, 'Auf unbewohnte Planeten kann nicht entladen werden');
    }
    
    $own_planet = ($fleet['owner_id'] == $game->player['user_id']) ? true : false;

    $sql = 'SELECT COUNT(ships.ship_id) AS n_transporter
            FROM ships, ship_templates
            WHERE ships.fleet_id = '.$fleet_id.' AND
                  ship_templates.id = ships.template_id AND
                  ship_templates.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n_transporter = $trpt_count['n_transporter'];

    if($n_transporter == 0) {
        message(NOTICE, 'In der Flotte befinden sich keine Transporter');
    }
    
    $max_fresources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_funits = $n_transporter * MAX_TRANSPORT_UNITS;

    $max_presources = $fleet['max_presources'];
    $max_pworker = $fleet['max_pworker'];
    $max_punits = $fleet['max_punits'];

    $nwares = $fwares = $pwares = array();

    /*
     * Dies ist eigentlich noch ein Relikt aus der Zeit, in der das Modul gleichzeitig be-/entladen
     * kï¿½nen sollte...vielleicht kommt das spï¿½er wider einmal rein...
     *
     * $pwares -> Waren auf dem Planeten
     * $fwares -> Waren auf der Flotte
     * $nwares -> Waren, die dem Planeten hinzugefgt werden soll
     * $twares -> Waren, die tatsï¿½hlich transferiert wurden
     *
     * $max_ -> Maximal-Wert
     * $n_   -> Aktueller Gesamt-Wert
     */

    $wares_names = get_wares_names();
    
    $units_space = array('unit_1' => 2, 'unit_2' => 3, 'unit_3' => 4, 'unit_4' => 4, 'unit_5' => 4, 'unit_6' => 4);

    // POST-variablen parsen + SQL-daten auf integer casten
    foreach($wares_names as $key => $name) {
        $nwares[$key] = (!empty($_POST['add_'.$key])) ? abs((int)$_POST['add_'.$key]) : 0;
        $fwares[$key] = (int)$fleet[$key];
        $pwares[$key] = (int)$fleet['p'.$key];
    }

    $n_presources = $pwares['resource_1'] + $pwares['resource_2'] + $pwares['resource_3'];
    $n_pworker = $pwares['resource_4'];
    $n_punits = ($pwares['unit_1'] * 2) + ($pwares['unit_2'] * 3) + ($pwares['unit_3'] * 4) + ($pwares['unit_4'] * 4) + ($pwares['unit_5'] * 4) + ($pwares['unit_6'] * 4);

    // Ein paar Kontrollen
    if($pwares['resource_1'] > $max_presources) {
        message(NOTICE, 'Auf dem Planeten ist zuviel Metall');
    }
    
    if($pwares['resource_2'] > $max_presources) {
        message(NOTICE, 'Auf dem Planeten sind zuviel Mineralien');
    }
    
    if($pwares['resource_3'] > $max_presources) {
        message(NOTICE, 'Auf dem Planeten ist zuviel Latinum');
    }

    if($n_pworker > $max_pworker) {
        message(NOTICE, 'Auf dem Planeten sind zuviel Arbeiter');
    }

    if($n_punits > $max_punits) {
        message(NOTICE, 'Auf dem Planeten sind zuviel Einheiten');
    }

    $planet_overloaded = false;

    foreach($nwares as $key => $value) {
        $o_value = $value;

        if($value > $fwares[$key]) {
            message(NOTICE, 'Auf der Flotte fehlen: '.$value.' '.$wares_names[$key]);
        }

        if($key == 'resource_4') {
            if( ($n_pworker + $value) > $max_pworker) {
                $value = $max_pworker - $n_pworker;
                $planet_overloaded = true;
            }
        }
        elseif( ($key == 'resource_1') || ($key == 'resource_2') || ($key == 'resource_3') ) {
            if( ($pwares[$key] + $value) > $max_presources) {
                $value = $max_presources - $pwares[$key];
                $planet_overloaded = true;
            }
        }
        else {
            $space = $value * $units_space[$key];

            if( ($n_punits + $space) > $max_punits) {
                $space = $max_punits - $n_punits;
                $value = floor( ($space / $units_space[$key]) );
                
                $planet_overloaded = true;
            }
            
            $n_punits += $space;
        }

        if($own_planet) $fwares[$key] -= $value;
        else $fwares[$key] -= $o_value;
        
        $pwares[$key] += $value;
        $twares[$key] = $value;
    }
    
    // Schulden abziehen
    // (bernommen aus scheduler/moves_31.php)
    if(!$own_planet) {
        // Umschreiben in das von der Berechnung erwartete Format
        
        $rfleets = array(
            'n1' => (!empty($twares['resource_1'])) ? $twares['resource_1'] : 0,
            'n2' => (!empty($twares['resource_2'])) ? $twares['resource_2'] : 0,
            'n3' => (!empty($twares['resource_3'])) ? $twares['resource_3'] : 0
        );

        $sql = 'SELECT id, resource_1, resource_2, resource_3, ship_id
                FROM bidding_owed
                WHERE user = '.$game->player['user_id'].' AND
                      receiver = '.$fleet['owner_id'].'
                ORDER BY id ASC';
                
        if(!$q_debts = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query bidding owed data');
        }

        $n_debts = $db->num_rows($q_debts);

        if($n_debts > 0) {
            while($debt = $db->fetchrow($q_debts)) {
                if($debt['resource_1'] > 0) {
                    if($debt['resource_1'] >= $rfleets['n1']) {
                        $debt['resource_1'] -= $rfleets['n1'];
                        $rfleets['n1'] = 0;
                    }
                    else {
                        $rfleets['n1'] -= $debt['resource_1'];
                        $debt['resource_1'] = 0;
                    }
                }

                if($debt['resource_2'] > 0) {
                    if($debt['resource_2'] >= $rfleets['n2']) {
                        $debt['resource_2'] -= $rfleets['n2'];
                        $rfleets['n2'] = 0;
                    }
                    else {
                        $rfleets['n2'] -= $debt['resource_2'];
                        $debt['resource_2'] = 0;
                    }
                }

                if($debt['resource_3'] > 0) {
                    if($debt['resource_3'] >= $rfleets['n3']) {
                        $debt['resource_3'] -= $rfleets['n3'];
                        $rfleets['n3'] = 0;
                    }
                    else {
                        $rfleets['n3'] -= $debt['resource_3'];
                        $debt['resource_3'] = 0;
                    }
                }

                if( ($debt['resource_1'] <= 0) && ($debt['resource_2'] <= 0) && ($debt['resource_3'] <= 0) && ($debt['ship_id'] <= 0) ) {
                    $sql = 'DELETE FROM bidding_owed
                            WHERE id = '.$debt['id'];
                            
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Could not delete bidding owed data');
                    }
                }
                else {
                    $sql = 'UPDATE bidding_owed
                            SET resource_1 = '.$debt['resource_1'].',
                                resource_2 = '.$debt['resource_2'].',
                                resource_3 = '.$debt['resource_3'].'
                            WHERE id = '.$debt['id'];
                            
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Could not update bidding owed data');
                    }
                }
            }
        }
    }

    $sql = 'UPDATE planets
            SET resource_1 = '.$pwares['resource_1'].',
                resource_2 = '.$pwares['resource_2'].',
                resource_3 = '.$pwares['resource_3'].',
                resource_4 = '.$pwares['resource_4'].',
                unit_1 = '.$pwares['unit_1'].',
                unit_2 = '.$pwares['unit_2'].',
                unit_3 = '.$pwares['unit_3'].',
                unit_4 = '.$pwares['unit_4'].',
                unit_5 = '.$pwares['unit_5'].',
                unit_6 = '.$pwares['unit_6'].'
            WHERE planet_id = '.$fleet['planet_id'];

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update planets wares data');
    }

    $sql = 'UPDATE ship_fleets
            SET resource_1 = '.$fwares['resource_1'].',
                resource_2 = '.$fwares['resource_2'].',
                resource_3 = '.$fwares['resource_3'].',
                resource_4 = '.$fwares['resource_4'].',
                unit_1 = '.$fwares['unit_1'].',
                unit_2 = '.$fwares['unit_2'].',
                unit_3 = '.$fwares['unit_3'].',
                unit_4 = '.$fwares['unit_4'].',
                unit_5 = '.$fwares['unit_5'].',
                unit_6 = '.$fwares['unit_6'].'
            WHERE fleet_id = '.$fleet_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update fleets wares data');
    }

    $db->unlock();

    if($planet_overloaded && $own_planet) {
        $game->init_player();
        $game->out('<center><span class="caption">Flotten:</span></center>');

        message(NOTICE, 'Nicht alle Rohstoffe/Arbeiter/Einheiten konnten entladen werden,<br>da das Maximum des Planeten erreicht wurde.<br><br><a href="'.parse_link($return_to).'">zurck</a>');
    }
    else {
        redirect($return_to);
    }
}
elseif(isset($_GET['to'])) {
    $game->init_player();

    $fleet_id = (!empty($_POST['fleets'])) ? (int)$_POST['fleets'][0] : (int)$_GET['to'];

    if(empty($fleet_id)) {
        message(NOTICE, 'Die gewählte Flotte existiert nicht / Es wurde keine Flotte zum Entladen ausgewählt');
    }
    
    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : '';

    $sql = 'SELECT f.*,
                   p.planet_id, p.planet_name, p.planet_owner AS owner_id,
                   p.resource_1 AS presource_1, p.resource_2 AS presource_2, p.resource_3 AS presource_3, p.resource_4 AS presource_4,
                   p.unit_1 AS punit_1, p.unit_2 AS punit_2, p.unit_3 AS punit_3, p.unit_4 AS punit_4, p.unit_5 AS punit_5, p.unit_6 AS punit_6,
                   p.max_resources AS max_presources, p.max_worker AS max_pworker, p.max_units AS max_punits,
                   u.user_name AS owner_name
            FROM (ship_fleets f)
            INNER JOIN (planets p) ON p.planet_id = f.planet_id
            LEFT JOIN user u ON u.user_id = p.planet_owner
            WHERE f.fleet_id = '.$fleet_id;

    if(($fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleet data');
    }

    if(empty($fleet['fleet_id'])) {
        message(NOTICE, 'Die gewï¿½lte Flotte existiert nicht');
    }

    if($fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Die gewï¿½lte Flotte existiert nicht');
    }
    
    if(empty($fleet['planet_id'])) {
        message(NOTICE, 'Der Planet der Flotte konnte nicht gefunden werden');
    }
    
    if(empty($fleet['owner_id'])) {
        message(NOTICE, 'Auf unbewohnte Planeten kann nicht entladen werden');
    }
    
    $own_planet = ($fleet['owner_id'] == $game->player['user_id']) ? true : false;

    $sql = 'SELECT COUNT(s.ship_id) AS n_transporter
            FROM (ships s), (ship_templates st)
            WHERE s.fleet_id = '.$fleet_id.' AND
                  st.id = s.template_id AND
                  st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n_transporter = $trpt_count['n_transporter'];

    if($n_transporter == 0) {
        message(NOTICE, 'In der Flotte befinden sich keine Transporter');
    }
    
    $max_resources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_units = $n_transporter * MAX_TRANSPORT_UNITS;

    $game->out('
<script language="JavaScript" type="text/javascript">
<!--
function unload_all() {
    ');

    if($fleet['resource_1'] > 0) $game->out('document.load_form.add_resource_1.value = '.$fleet['resource_1'].';');
    if($fleet['resource_2'] > 0) $game->out('document.load_form.add_resource_2.value = '.$fleet['resource_2'].';');
    if($fleet['resource_3'] > 0) $game->out('document.load_form.add_resource_3.value = '.$fleet['resource_3'].';');
    if($fleet['resource_4'] > 0) $game->out('document.load_form.add_resource_4.value = '.$fleet['resource_4'].';');
    if($fleet['unit_1'] > 0) $game->out('document.load_form.add_unit_1.value = '.$fleet['unit_1'].';');
    if($fleet['unit_2'] > 0) $game->out('document.load_form.add_unit_2.value = '.$fleet['unit_2'].';');
    if($fleet['unit_3'] > 0) $game->out('document.load_form.add_unit_3.value = '.$fleet['unit_3'].';');
    if($fleet['unit_4'] > 0) $game->out('document.load_form.add_unit_4.value = '.$fleet['unit_4'].';');
    if($fleet['unit_5'] > 0) $game->out('document.load_form.add_unit_5.value = '.$fleet['unit_5'].';');
    if($fleet['unit_6'] > 0) $game->out('document.load_form.add_unit_6.value = '.$fleet['unit_6'].';');
    
    $game->out('
    
    return true;
}
//-->
</script>

<center><span class="caption">Flotten:</span></center><br>

<table class="style_inner" width="400" align="center" border="0" cellpadding="4" cellspacing="2">
  <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingp&to='.$fleet_id.( ($return_to) ? '&return_to='.urlencode($return_to) : '' ) ).'" onSubmit="return document.load_form.submit_button.disabled = true;">
  <input type="hidden" name="to_submit" value="1">
  <tr>
    <td>
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="200" align="left"><b>'.$fleet['fleet_name'].'</b></td>
          <td width="200" align="right">'.( ($fleet['n_ships'] == 1) ? '<b>1</b> Schiff' : '<b>'.$fleet['n_ships'].'</b> Schiffe' ).'</td>
        </tr>
      </table><br>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="140">Entladen nach:</td>
          <td width="260"><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['planet_id'])).'"><b>'.$fleet['planet_name'].'</b></a>'.( ($fleet['owner_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$fleet['owner_id']).'"><b>'.$fleet['owner_name'].'</b></a>' : '' ).'</td>
        </tr>
    ');
    
    if($own_planet) {
        $game->out('
        <tr><td height="5"></td></tr>
        <tr>
          <td rowspan="5" width="140" valign="top">Auf Planet noch frei:</td>
          <td width="260"><i>Metall</i>: <b>'.($fleet['max_presources'] - $fleet['presource_1']).'</b></td>
        </tr>
        <tr><td><i>Mineralien</i>: <b>'.($fleet['max_presources'] - $fleet['presource_2']).'</b></td></tr>
        <tr><td><i>Latinum</i>: <b>'.($fleet['max_presources'] - $fleet['presource_3']).'</b></td></tr>
        <tr><td><i>Arbeiter</i>: <b>'.($fleet['max_pworker'] - $fleet['presource_4']).'</b></td></tr>
        <tr><td><i>Einheitenplï¿½ze</i>: <b>'.($fleet['max_punits'] - ($fleet['punit_1'] * 2)- ($fleet['punit_2'] * 3) - ($fleet['punit_3'] * 4)- ($fleet['punit_4'] * 4) - ($fleet['unit_5'] * 4) - ($fleet['unit_6'] * 4)).'</b></td></tr>
        ');
    }
    
    $game->out('
      </table>
      <br>
      <table width="400" border="0" cellpadding="1" cellspacing="0">
        <tr>
          <td width="80">&nbsp;</td>
          <td width="120" align="center"><b>auf Flotte</b></td>
          <td width="120" align="center">'.( ($own_planet) ? '<b>auf Planet</b>' : '' ).'</td>
          <td width="80" align="center">[<a href="javascript:void(0);" onClick="return unload_all();">alles</a>]</td>
        </tr>
    ');

    if($fleet['resource_1'] > 0) {
        $game->out('
        <tr>
          <td>Metall</td>
          <td align="center">'.$fleet['resource_1'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_1'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_1" value=""></td>
        </tr>
        ');
    }

    if($fleet['resource_2'] > 0) {
        $game->out('
        <tr>
          <td>Mineralien</td>
          <td align="center">'.$fleet['resource_2'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_2'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_2" value=""></td>
        </tr>
        ');
    }

    if($fleet['resource_3'] > 0) {
        $game->out('
        <tr>
          <td>Latinum</td>
          <td align="center">'.$fleet['resource_3'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_3'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_3" value=""></td>
        </tr>
        ');
    }

    if($fleet['resource_4'] > 0) {
        $game->out('
        <tr>
          <td>Arbeiter</td>
          <td align="center">'.$fleet['resource_4'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_4'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_4" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_1'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][0].'</td>
          <td align="center">'.$fleet['unit_1'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_1'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_1" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_2'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][1].'</td>
          <td align="center">'.$fleet['unit_2'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_2'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_2" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_3'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][2].'</td>
          <td align="center">'.$fleet['unit_3'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_3'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_3" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_4'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][3].'</td>
          <td align="center">'.$fleet['unit_4'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_4'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_4" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_5'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][4].'</td>
          <td align="center">'.$fleet['unit_5'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_5'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_5" value=""></td>
        </tr>
        ');
    }

    if($fleet['unit_6'] > 0) {
        $game->out('
        <tr>
          <td>'.$UNIT_NAME[$game->player['user_race']][5].'</td>
          <td align="center">'.$fleet['unit_6'].'</td><td align="center">'.( ($own_planet) ? $fleet['punit_6'] : '' ).'</td>
          <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_6" value=""></td>
        </tr>
        ');
    }

    $game->out('
      </table>
      <br>
      <center><input class="button" type="button" name="cancel" value="<< Zurück" onClick="return window.location.href = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="Übernehmen"></center>
    </td>
  </tr>
  </form>
</table>
    ');
}
else {
    redirect('a=ship_fleets_display');
}

?>
