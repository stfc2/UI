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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if($fleet['owner_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }
    
    if(empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    if($fleet['owner_id'] != $fleet['planet_owner']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
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
        message(NOTICE, constant($game->sprache("TEXT3")));
    }
    
    $max_fresources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_funits = $n_transporter * MAX_TRANSPORT_UNITS;
    
    $nwares = $fwares = $pwares = array();
    
    /*
     * This is actually another relic from the time in which the module should be able to load/unload
     * at the same time...perhaps, the once purely appreciable resist... 
     *
     * $pwares -> products on the planet
     * $fwares -> products on the fleet
     * $nwares -> products that should be added to the fleet
     *
     * $max_ -> Maximum value
     * $n_   -> Total Current value
     */
    
    $wares_names = get_wares_names();

    // POST variables parse + SQL data to integer cast
    foreach($wares_names as $key => $name) {
        $nwares[$key] = (!empty($_POST['add_'.$key])) ? abs((float)$_POST['add_'.$key]) : 0;
        $fwares[$key] = (float)$fleet[$key];
        $pwares[$key] = (float)$fleet['avail_'.$key];
    }
    
    $n_presources = $pwares['resource_1'] + $pwares['resource_2'] + $pwares['resource_3'];
    $n_pworker = $pwares['resource_4'];
    $n_punits = $pwares['unit_1'] + $pwares['unit_2'] + $pwares['unit_3'] + $pwares['unit_4'] + $pwares['unit_5'] + $pwares['unit_6'];
    
    $n_fresources = $fwares['resource_1'] + $fwares['resource_2'] + $fwares['resource_3'];
    $n_funits = $fwares['resource_4'] + $fwares['unit_1'] + $fwares['unit_2'] + $fwares['unit_3'] + $fwares['unit_4'] + $fwares['unit_5'] + $fwares['unit_6'];
    
    $fleet_overloaded = false;
    
    foreach($nwares as $key => $value) {
        if($value > $pwares[$key]) {
            message(NOTICE, constant($game->sprache("TEXT4")).' '.$value.' '.$wares_names[$key]);
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
        $game->out('<center><span class="caption">'.constant($game->sprache("TEXT5")).'</span></center>');

        message(NOTICE, constant($game->sprache("TEXT6")).'<br><br><a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'">'.constant($game->sprache("TEXT7")).'</a>');
    }
    else {
        redirect('a=ship_fleets_display&pfleet_details='.$fleet_id);
    }
}
elseif(!empty($_GET['from'])) {
    $game->init_player();

    $fleet_id = (int)$_GET['from'];

    if(empty($fleet_id)) {
        message(NOTICE, constant($game->sprache("TEXT0")));
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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if($fleet['owner_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if(empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if($fleet['planet_owner'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
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
        message(NOTICE, constant($game->sprache("TEXT3")));
    }
    
    $max_resources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_units = $n_transporter * MAX_TRANSPORT_UNITS;

    $game->out('
<span class="caption">'.constant($game->sprache("TEXT5")).'</span><br><br>

<table class="style_outer" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td>
      <table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
        <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingp&from='.$fleet_id).'" onSubmit="return document.load_form.submit_button.disabled = true;">
        <input type="hidden" name="from_submit" value="1">
        <tr>
          <td align="center">
            <table width="400" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="200" align="left"><b>'.$fleet['fleet_name'].'</b></td>
                <td width="200" align="right">'.( ($fleet['n_ships'] == 1) ? '<b>1</b> '.constant($game->sprache("TEXT8")) : '<b>'.$fleet['n_ships'].'</b> '.constant($game->sprache("TEXT9")) ).'</td>
              </tr>
            </table><br>
            '.constant($game->sprache("TEXT10")).' <b>'.$n_transporter.'</b><br>
            '.constant($game->sprache("TEXT11")).' <b>'.$max_resources.'</b> ('.constant($game->sprache("TEXT12")).' <b>'.($max_resources - $fleet['resource_1'] - $fleet['resource_2'] - $fleet['resource_3']).'</b>)<br>
            '.constant($game->sprache("TEXT13")).' <b>'.$max_units.'</b> ('.constant($game->sprache("TEXT12")).' <b>'.($max_units - $fleet['resource_4'] - $fleet['unit_1'] - $fleet['unit_2'] - $fleet['unit_3'] - $fleet['unit_4'] - $fleet['unit_5'] - $fleet['unit_6']).'</b>)<br><br>
            <table width="400" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="80">&nbsp;</td>
                <td width="120" align="center"><b>'.constant($game->sprache("TEXT14")).'</b></td>
                <td width="120" align="center"><b>'.constant($game->sprache("TEXT15")).'</b></td>
                <td width="80" align="center">&nbsp;</td>
              </tr>
    ');
    
    if($fleet['avail_resource_1'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT16")).'</td>
                <td align="center">'.floor($fleet['avail_resource_1']).'</td><td align="center">'.$fleet['resource_1'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_1" value="" maxlength="8"></td>
              </tr>
        ');
    }
    
    if($fleet['avail_resource_2'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT17")).'</td>
                <td align="center">'.floor($fleet['avail_resource_2']).'</td><td align="center">'.$fleet['resource_2'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_2" value="" maxlength="8"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_resource_3'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT18")).'</td>
                <td align="center">'.floor($fleet['avail_resource_3']).'</td><td align="center">'.$fleet['resource_3'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_3" value="" maxlength="8"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_resource_4'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT19")).'</td>
                <td align="center">'.floor($fleet['avail_resource_4']).'</td><td align="center">'.$fleet['resource_4'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_4" value="" maxlength="6"></td>
              </tr>
        ');
    }
    
    if($fleet['avail_unit_1'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].'</td>
                <td align="center">'.$fleet['avail_unit_1'].'</td><td align="center">'.$fleet['unit_1'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_1" value="" maxlength="6"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_unit_2'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].'</td>
                <td align="center">'.$fleet['avail_unit_2'].'</td><td align="center">'.$fleet['unit_2'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_2" value="" maxlength="6"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_unit_3'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].'</td>
                <td align="center">'.$fleet['avail_unit_3'].'</td><td align="center">'.$fleet['unit_3'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_3" value="" maxlength="6"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_unit_4'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].'</td>
                <td align="center">'.$fleet['avail_unit_4'].'</td><td align="center">'.$fleet['unit_4'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_4" value="" maxlength="6"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_unit_5'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].'</td>
                <td align="center">'.$fleet['avail_unit_5'].'</td><td align="center">'.$fleet['unit_5'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_5" value="" maxlength="6"></td>
              </tr>
        ');
    }
        
    if($fleet['avail_unit_6'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].'</td>
                <td align="center">'.$fleet['avail_unit_6'].'</td><td align="center">'.$fleet['unit_6'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_6" value="" maxlength="6"></td>
              </tr>
        ');
    }
    
    $game->out('
            </table>
            <br>
            <input class="button" type="button" name="cancel" value="'.constant($game->sprache("TEXT20")).'" onClick="return window.location.href = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="'.constant($game->sprache("TEXT21")).'">
          </td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
elseif(!empty($_POST['to_submit'])) {
    $db->lock('ship_fleets', 'ships', 'ship_templates', 'bidding_owed');
    $game->init_player();

    $fleet_id = (int)$_GET['to'];
    
    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : 'a=ship_fleets_display&pfleet_details='.$fleet_id;

    $sql = 'SELECT ship_fleets.*,
                   planets.planet_id, planets.planet_owner AS powner_id,
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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if($fleet['owner_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if(empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if($fleet['powner_id'] != $fleet['owner_id']) {
        message(NOTICE, constant($game->sprache("TEXT22")));
    }

    if(empty($fleet['powner_id'])) {
        message(NOTICE, constant($game->sprache("TEXT23")));
    }
    
    $own_planet = ($fleet['powner_id'] == $game->player['user_id']) ? true : false;

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
        message(NOTICE, constant($game->sprache("TEXT3")));
    }
    
    $max_fresources = $n_transporter * MAX_TRANSPORT_RESOURCES;
    $max_funits = $n_transporter * MAX_TRANSPORT_UNITS;

    $max_presources = $fleet['max_presources'];
    $max_pworker = $fleet['max_pworker'];
    $max_punits = $fleet['max_punits'];

    $nwares = $fwares = $pwares = array();

    /*
     * This is actually another relic from the time in which the module should be able to load/unload
     * at the same time...perhaps, the once purely appreciable resist... 
     *
     * $pwares -> products on the planet
     * $fwares -> products on the fleet
     * $nwares -> products that should be added to the planet
     * $twares -> products which were transferred
     *
     * $max_ -> Maximum value
     * $n_   -> Total current value
     */

    $wares_names = get_wares_names();
    
    $units_space = array('unit_1' => 2, 'unit_2' => 3, 'unit_3' => 4, 'unit_4' => 4, 'unit_5' => 4, 'unit_6' => 4);

    // POST variables parse + SQL data to integer cast
    foreach($wares_names as $key => $name) {
        $nwares[$key] = (!empty($_POST['add_'.$key])) ? abs((float)$_POST['add_'.$key]) : 0;
        $fwares[$key] = (float)$fleet[$key];
        $pwares[$key] = (float)$fleet['p'.$key];
    }

    $n_presources = $pwares['resource_1'] + $pwares['resource_2'] + $pwares['resource_3'];
    $n_pworker = $pwares['resource_4'];
    $n_punits = ($pwares['unit_1'] * 2) + ($pwares['unit_2'] * 3) + ($pwares['unit_3'] * 4) + ($pwares['unit_4'] * 4) + ($pwares['unit_5'] * 4) + ($pwares['unit_6'] * 4);

    // A few checks
    if($pwares['resource_1'] > $max_presources) {
        message(NOTICE, constant($game->sprache("TEXT24")));
    }
    
    if($pwares['resource_2'] > $max_presources) {
        message(NOTICE, constant($game->sprache("TEXT25")));
    }
    
    if($pwares['resource_3'] > $max_presources) {
        message(NOTICE, constant($game->sprache("TEXT26")));
    }

    if($n_pworker > $max_pworker) {
        message(NOTICE, constant($game->sprache("TEXT27")));
    }

    if($n_punits > $max_punits) {
        message(NOTICE, constant($game->sprache("TEXT28")));
    }

    $planet_overloaded = false;

    foreach($nwares as $key => $value) {
        $o_value = $value;

        if($value > $fwares[$key]) {
            message(NOTICE, constant($game->sprache("TEXT29")).' '.$value.' '.$wares_names[$key]);
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
    
    // Debts take off
    // (taken from scheduler/moves_31.php)
    if(!$own_planet) {
        // Describe into the format expected by the computation
        
        $rfleets = array(
            'n1' => (!empty($twares['resource_1'])) ? $twares['resource_1'] : 0,
            'n2' => (!empty($twares['resource_2'])) ? $twares['resource_2'] : 0,
            'n3' => (!empty($twares['resource_3'])) ? $twares['resource_3'] : 0
        );

        $sql = 'SELECT id, resource_1, resource_2, resource_3, ship_id
                FROM bidding_owed
                WHERE user = '.$game->player['user_id'].' AND
                      receiver = '.$fleet['powner_id'].'
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
        $game->out('<span class="caption">'.constant($game->sprache("TEXT5")).'</span><br>');

        message(NOTICE, constant($game->sprache("TEXT30")).'<br><br><a href="'.parse_link($return_to).'">'.constant($game->sprache("TEXT31")).'</a>');
    }
    else {
        redirect($return_to);
    }
}
elseif(isset($_GET['to'])) {
    $game->init_player();

    $fleet_id = (!empty($_POST['fleets'])) ? (int)$_POST['fleets'][0] : (int)$_GET['to'];

    if(empty($fleet_id)) {
        message(NOTICE, constant($game->sprache("TEXT32")));
    }
    
    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : '';

    $sql = 'SELECT f.*,
                   p.planet_id, p.planet_name, p.planet_owner AS powner_id,
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
        message(NOTICE, constant($game->sprache("TEXT0")));
    }

    if($fleet['owner_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }
    
    if(empty($fleet['planet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    if(empty($fleet['powner_id'])) {
        message(NOTICE, constant($game->sprache("TEXT23")));
    }
    
    $own_planet = ($fleet['powner_id'] == $game->player['user_id']) ? true : false;

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
        message(NOTICE, constant($game->sprache("TEXT3")));
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

<span class="caption">'.constant($game->sprache("TEXT5")).'</span><br><br>

<table class="style_outer" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td>
      <table class="style_inner" width="400" align="center" border="0" cellpadding="4" cellspacing="2">
        <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingp&to='.$fleet_id.( ($return_to) ? '&return_to='.urlencode($return_to) : '' ) ).'" onSubmit="return document.load_form.submit_button.disabled = true;">
        <input type="hidden" name="to_submit" value="1">
        <tr>
          <td align="center">
            <table width="400" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="200" align="left"><b>'.$fleet['fleet_name'].'</b></td>
                <td width="200" align="right">'.( ($fleet['n_ships'] == 1) ? '<b>1</b> '.constant($game->sprache("TEXT8")) : '<b>'.$fleet['n_ships'].'</b> '.constant($game->sprache("TEXT9")) ).'</td>
              </tr>
            </table><br>
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="140">'.constant($game->sprache("TEXT33")).'</td>
                <td width="260"><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($fleet['planet_id'])).'"><b>'.$fleet['planet_name'].'</b></a>'.( ($fleet['owner_id'] != $game->player['user_id']) ? ' von <a href="'.parse_link('a=stats&a2=viewplayer&id='.$fleet['owner_id']).'"><b>'.$fleet['owner_name'].'</b></a>' : '' ).'</td>
              </tr>
    ');
    
    if($own_planet) {
        $game->out('
              <tr><td height="5"></td></tr>
              <tr>
                <td rowspan="5" width="140" valign="top">'.constant($game->sprache("TEXT34")).'</td>
                <td width="260"><i>'.constant($game->sprache("TEXT16")).'</i>: <b>'.($fleet['max_presources'] - $fleet['presource_1']).'</b></td>
              </tr>
              <tr><td><i>'.constant($game->sprache("TEXT17")).'</i>: <b>'.($fleet['max_presources'] - $fleet['presource_2']).'</b></td></tr>
              <tr><td><i>'.constant($game->sprache("TEXT18")).'</i>: <b>'.($fleet['max_presources'] - $fleet['presource_3']).'</b></td></tr>
              <tr><td><i>'.constant($game->sprache("TEXT19")).'</i>: <b>'.($fleet['max_pworker'] - $fleet['presource_4']).'</b></td></tr>
              <tr><td><i>'.constant($game->sprache("TEXT35")).'</i>: <b>'.($fleet['max_punits'] - ($fleet['punit_1'] * 2)- ($fleet['punit_2'] * 3) - ($fleet['punit_3'] * 4)- ($fleet['punit_4'] * 4) - ($fleet['unit_5'] * 4) - ($fleet['unit_6'] * 4)).'</b></td></tr>
        ');
    }
    
    $game->out('
            </table>
            <br>
            <table width="400" border="0" cellpadding="1" cellspacing="0">
              <tr>
                <td width="80">&nbsp;</td>
                <td width="120" align="center"><b>'.constant($game->sprache("TEXT15")).'</b></td>
                <td width="120" align="center">'.( ($own_planet) ? '<b>'.constant($game->sprache("TEXT14")).'</b>' : '' ).'</td>
                <td width="80" align="center">[<a href="javascript:void(0);" onClick="return unload_all();">'.constant($game->sprache("TEXT36")).'</a>]</td>
              </tr>
    ');

    if($fleet['resource_1'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT16")).'</td>
                <td align="center">'.$fleet['resource_1'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_1'] : '' ).'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_1" value=""></td>
              </tr>
        ');
    }

    if($fleet['resource_2'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT17")).'</td>
                <td align="center">'.$fleet['resource_2'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_2'] : '' ).'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_2" value=""></td>
              </tr>
        ');
    }

    if($fleet['resource_3'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT18")).'</td>
                <td align="center">'.$fleet['resource_3'].'</td><td align="center">'.( ($own_planet) ? $fleet['presource_3'] : '' ).'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_3" value=""></td>
              </tr>
        ');
    }

    if($fleet['resource_4'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT19")).'</td>
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
            <input class="button" type="button" name="cancel" value="'.constant($game->sprache("TEXT20")).'" onClick="return window.location.href = \''.parse_link('a=ship_fleets_display&pfleet_details='.$fleet_id).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="'.constant($game->sprache("TEXT21")).'">
          </td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
else {
    redirect('a=ship_fleets_display');
}

?>
