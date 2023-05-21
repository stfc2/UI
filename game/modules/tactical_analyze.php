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

function fs_bonus_by_race ($race)
{
    $result = 0;
    
    switch($race) {
        case 0:         // Fed
            $result = 25;
            break;
        case 1:         // Romulan
            $result = 0;
            break;
        case 2:         // Klingon
            $result = 25;
            break;
        case 3:         // Cardassian
            $result = 25;
            break;
        case 4:         // Dominion
            $result = 0;
            break;
        case 5:         // Ferengi
            $result = 0;
            break;            
        case 8:         // Breen
            $result = 25;
            break;
        case 9:         // Hirogeni
            $result = 25;
            break;
        case 11:        // Kazon
            $result = 0;
            break;
        default:
            $result = 0;
    }
        
    return $result;
    
}

$game->init_player();

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>
                        [<a href="'.parse_link('a=tactical_cartography').'">'.constant($game->sprache("TEXT1")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">'.constant($game->sprache("TEXT2")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">'.constant($game->sprache("TEXT3")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">'.constant($game->sprache("TEXT4")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_known').'">'.constant($game->sprache("TEXT4a")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">'.constant($game->sprache("TEXT5")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_search').'">'.constant($game->sprache("TEXT5a")).'</a>]<br><br>');                



$mode_id   = filter_input(INPUT_POST, 'mode_id', FILTER_SANITIZE_NUMBER_INT);

if(empty($mode_id)) {
    message(NOTICE, 'No mode selected');
}



switch($mode_id) {
    case 0:
    case 1:
        $user_id   = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $planet_id = filter_input(INPUT_POST, 'planet_id', FILTER_SANITIZE_NUMBER_INT);        

        //Input Data check

        if(empty($_POST['fleets'])) {
            message(NOTICE, constant($game->sprache("TEXT11")));
        }

        $fleets = array();

        for($i = 0; $i < count($_POST['fleets']); ++$i) {
            $_temp = (int)$_POST['fleets'][$i];

            if(!empty($_temp)) {
                $fleets[] = $_temp;
            }
        }

        if(empty($user_id)) {
            message(NOTICE, constant($game->sprache("TEXT12")));
        }

        if(empty($planet_id)) {
            message(NOTICE, constant($game->sprache("TEXT13")));
        }



        //Input Data validation

        $sql = 'SELECT fleet_id, planet_id
                FROM ship_fleets
                WHERE fleet_id IN ('.implode(',', $fleets).')';

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleet data');
        }

        $n_fleets = $db->num_rows();

        if($n_fleets == 0) {
            message(NOTICE, constant($game->sprache("TEXT14")));
        }

        $_temp = $db->fetchrowset($q_fleets);

        foreach ($_temp AS $_temp_item) {
            if($_temp_item['planet_id'] == $planet_id) {
                $fleet_ids[] = $_temp_item['fleet_id'];
            }
        }

        $fleet_ids_str = implode(',', $fleet_ids);        
        //Data Gathering - Analyzer

        $sql = 'SELECT s.ship_id, s.hitpoints, st.race, st.rof, st.rof2, s.torp, s.rating_1a, s.rating_1b, s.rating_2a, s.rating_2b,
                       st.ship_class, st.ship_torso, st.value_1, st.value_2, st.value_4, st.value_5,
                       st.value_6, st.value_7, st.value_8, st.value_11, st.value_12
                FROM ship_fleets f
                INNER JOIN ships s USING (fleet_id)
                INNER JOIN ship_templates st on st.id = s.template_id
                WHERE f.fleet_id IN ('.$fleet_ids_str.')';


        $fleeta_data = $db->queryrowset($sql);

        $n_ships_a = $db->num_rows();

        $n_civili_a = $n_trasporti_a = $n_class1_a = $n_class2_a = $n_class3_a = 0;

        $punch_estimate_a    = 0;
        $punch_estimate_civili_a = $punch_estimate_class1_a = $punch_estimate_class2_a = $punch_estimate_class3_a = 0;
        $primary_avg_a       = 0;
        $secondary_avg_a     = 0;
        $shield_estimate_a   = 0;
        $shield_estimate_civili_a = $shield_estimate_class1_a = $shield_estimate_class2_a = $shield_estimate_class3_a = 0;        
        $strenght_estimate_a = 0;
        $strenght_estimate_tp_a = 0;
        $strenght_estimate_civili_a = $strenght_estimate_class1_a = $strenght_estimate_class2_a = $strenght_estimate_class3_a = 0;
        $strenght_estimate_tp_civili_a = $strenght_estimate_tp_class1_a = $strenght_estimate_tp_class2_a = $strenght_estimate_tp_class3_a = 0;

        foreach ($fleeta_data AS $fleeta_item) {
            $primary = (((($fleeta_item['value_1']/2) * (0.85 + ((int)$fleeta_item['rating_1a'] * 0.005))) + 
                        (($fleeta_item['value_1']/2) * (0.85 + ((int)$fleeta_item['rating_1b'] * 0.005))) +
                        $fleeta_item['value_1']*($fleeta_item['experience']/1000))*0.25) * $fleeta_item['rof'];
            if($fleeta_item['ship_torso'] > 2 && $fleeta_item['torp'] > 0) {
                $secondary = (((($fleeta_item['value_2']/2) * (0.85 + ((int)$fleeta_item['rating_2a'] * 0.005))) + 
                              (($fleeta_item['value_2']/2) * (0.85 + ((int)$fleeta_item['rating_2b'] * 0.005))) +
                               $fleeta_item['value_2']*($fleeta_item['experience']/1000))*0.40) * $fleeta_item['rof2'];                
            }
            else {
                $secondary = 0;
            }
            $punch_estimate_a       += ($primary + $secondary);
            $primary_avg_a          += $primary;
            $secondary_avg_a        += $secondary;
            $shield_estimate_a      += $fleeta_item['value_4'];
            $strenght_estimate_a    += $fleeta_item['hitpoints'];
            $strenght_estimate_tp_a += $fleeta_item['value_5'];
            
            $first_strike = fs_bonus_by_race($fleeta_item['race']) + ($fleeta_item['value_11']*0.5) + ($fleeta_item['value_6']*2) + ($fleeta_item['value_7']*3) + $fleeta_item['value_8'] + ($fleeta_item['value_12']*2.5);
            if($first_strike < 1) $first_strike = 1;
            
            $all_ship_list[$fleeta_item['ship_id']]['side'] = 'a';
            $all_ship_list[$fleeta_item['ship_id']]['primary'] = $primary;
            $all_ship_list[$fleeta_item['ship_id']]['secondary'] = $secondary;
            $all_ship_list[$fleeta_item['ship_id']]['shield'] = $fleeta_item['value_4'];
            $all_ship_list[$fleeta_item['ship_id']]['strenght'] = $fleeta_item['hitpoints'];
            $all_ship_list[$fleeta_item['ship_id']]['torso'] = $fleeta_item['ship_torso'];
            $all_ship_list[$fleeta_item['ship_id']]['class'] = $fleeta_item['ship_class'];            
            
            $combat_list_estimate[$fleeta_item['ship_id']] = $first_strike;

            switch($fleeta_item['ship_class']){
                case 0:
                case 1:
                    if($fleeta_item['ship_torso'] > 2) {
                        $n_class1_a++;
                        $punch_estimate_class1_a += ($primary + $secondary);
                        $shield_estimate_class1_a += $fleeta_item['value_4'];
                        $strenght_estimate_class1_a += $fleeta_item['hitpoints'];
                        $strenght_estimate_class1_tp_a += $fleeta_item['value_5'];                        
                    } 
                    else { 
                        $n_civili_a++;
                        $punch_estimate_civili_a += ($primary + $secondary);
                        $shield_estimate_civili_a += $fleeta_item['value_4'];
                        $strenght_estimate_civili_a += $fleeta_item['hitpoints'];
                        $strenght_estimate_civili_tp_a += $fleeta_item['value_5'];
                        if($fleeta_item['ship_torso'] == SHIP_TYPE_TRANSPORTER) {$n_trasporti_a++;}
                    }
                    break;
                case 2:
                    $n_class2_a++;
                    $punch_estimate_class2_a += ($primary + $secondary);
                    $shield_estimate_class2_a += $fleeta_item['value_4'];
                    $strenght_estimate_class2_a += $fleeta_item['hitpoints'];
                    $strenght_estimate_class2_tp_a += $fleeta_item['value_5'];
                    break;
                case 3:
                    $n_class3_a++;
                    $punch_estimate_class3_a += ($primary + $secondary);
                    $shield_estimate_class3_a += $fleeta_item['value_4'];
                    $strenght_estimate_class3_a += $fleeta_item['hitpoints'];
                    $strenght_estimate_class3_tp_a += $fleeta_item['value_5'];                    
                    break;
            }            
        }

        //Data Gathering - Analyzed
        $player_b = $db->queryrow('SELECT user_name FROM user WHERE user_id = '.$user_id);

        $sql = 'SELECT s.ship_id, s.hitpoints, st.race, st.rof, st.rof2, s.torp, s.rating_1a, s.rating_1b, s.rating_2a, s.rating_2b,
                       st.ship_class, st.ship_torso, st.value_1, st.value_2, st.value_4, st.value_5,
                       st.value_6, st.value_7, st.value_8, st.value_11, st.value_12
                FROM ship_fleets f
                INNER JOIN ships s USING (fleet_id)
                INNER JOIN ship_templates st on st.id = s.template_id
                WHERE f.user_id = '.$user_id.' AND f.alert_phase <> '.ALERT_PHASE_RED.' AND f.planet_id = '.$planet_id;


        $fleetb_data = $db->queryrowset($sql);

        $n_ships_b = $db->num_rows();

        $n_civili_b = $n_trasporti_b = $n_class1_b = $n_class2_b = $n_class3_b = 0;

        $punch_estimate_b    = 0;
        $punch_estimate_civili_b = $punch_estimate_class1_b = $punch_estimate_class2_b = $punch_estimate_class3_b = 0;        
        $primary_avg_b       = 0;
        $secondary_avg_b     = 0;
        $shield_estimate_b   = 0;
        $shield_estimate_civili_b = $shield_estimate_class1_b = $shield_estimate_class2_b = $shield_estimate_class3_b = 0;                
        $strenght_estimate_b = 0;
        $strenght_estimate_tp_b = 0;
        $strenght_estimate_civili_b = $strenght_estimate_class1_b = $strenght_estimate_class2_b = $strenght_estimate_class3_b = 0;
        $strenght_estimate_civili_tp_b = $strenght_estimate_class1_tp_b = $strenght_estimate_class2_tp_b = $strenght_estimate_class3_tp_b = 0;        

        foreach ($fleetb_data AS $fleetb_item) {
            $primary = (((($fleetb_item['value_1']/2) * (0.85 + ((int)$fleetb_item['rating_1a'] * 0.005))) + 
                        (($fleetb_item['value_1']/2) * (0.85 + ((int)$fleetb_item['rating_1b'] * 0.005))) +
                        $fleetb_item['value_1']*($fleetb_item['experience']/1000))*0.25) * $fleetb_item['rof'];            
            if($fleetb_item['ship_torso'] > 2 && $fleetb_item['torp'] > 0) {
                $secondary = (((($fleetb_item['value_2']/2) * (0.85 + ((int)$fleetb_item['rating_2a'] * 0.005))) + 
                              (($fleetb_item['value_2']/2) * (0.85 + ((int)$fleetb_item['rating_2b'] * 0.005))) +
                               $fleetb_item['value_2']*($fleetb_item['experience']/1000))*0.40) * $fleetb_item['rof2'];
            }
            else {
                $secondary = 0;
            }
            $punch_estimate_b       += ($primary + $secondary);
            $primary_avg_b          += $primary;
            $secondary_avg_b        += $secondary;
            $shield_estimate_b      += $fleetb_item['value_4'];
            $strenght_estimate_b    += $fleetb_item['hitpoints'];
            $strenght_estimate_tp_b += $fleetb_item['value_5'];
            
            $first_strike = fs_bonus_by_race($fleetb_item['race']) + ($fleetb_item['value_11']*0.5) + ($fleetb_item['value_6']*2) + ($fleetb_item['value_7']*3) + $fleetb_item['value_8'] + ($fleetb_item['value_12']*2.5);
            if($first_strike < 1) $first_strike = 1;
            
            $all_ship_list[$fleetb_item['ship_id']]['side'] = 'b';
            $all_ship_list[$fleetb_item['ship_id']]['primary'] = $primary;
            $all_ship_list[$fleetb_item['ship_id']]['secondary'] = $secondary;
            $all_ship_list[$fleetb_item['ship_id']]['shield'] = $fleetb_item['value_4'];
            $all_ship_list[$fleetb_item['ship_id']]['strenght'] = $fleetb_item['hitpoints'];
            $all_ship_list[$fleetb_item['ship_id']]['torso'] = $fleetb_item['ship_torso'];
            $all_ship_list[$fleetb_item['ship_id']]['class'] = $fleetb_item['ship_class'];
            
            $combat_list_estimate[$fleetb_item['ship_id']] = $first_strike;
            
            switch($fleetb_item['ship_class']){
                case 0:
                case 1:
                    if($fleetb_item['ship_torso'] > 2) {
                        $n_class1_b++;
                        $punch_estimate_class1_b += ($primary + $secondary);
                        $shield_estimate_class1_b += $fleetb_item['value_4'];
                        $strenght_estimate_class1_b += $fleetb_item['hitpoints'];
                        $strenght_estimate_class1_tp_b += $fleetb_item['value_5'];
                    } 
                    else { 
                        $n_civili_b++;
                        $punch_estimate_civili_b += ($primary + $secondary);
                        $shield_estimate_civili_b += $fleetb_item['value_4'];
                        $strenght_estimate_civili_b += $fleetb_item['hitpoints'];
                        $strenght_estimate_civili_tp_b += $fleetb_item['value_5'];                        
                        if($fleetb_item['ship_torso'] == SHIP_TYPE_TRANSPORTER) {$n_trasporti_b++;}
                    }
                    break;
                case 2:
                    $n_class2_b++;
                    $punch_estimate_class2_b += ($primary + $secondary);
                    $shield_estimate_class2_b += $fleetb_item['value_4'];
                    $strenght_estimate_class2_b += $fleetb_item['hitpoints'];
                    $strenght_estimate_class2_tp_b += $fleetb_item['value_5'];                    
                    break;
                case 3:
                    $n_class3_b++;
                    $punch_estimate_class3_b += ($primary + $secondary);
                    $shield_estimate_class3_b += $fleetb_item['value_4'];
                    $strenght_estimate_class3_b += $fleetb_item['hitpoints'];
                    $strenght_estimate_class3_tp_b += $fleetb_item['value_5'];                    
                    break;
            }            
        }

        if($n_trasporti_b > 0) {
            $sql = 'SELECT SUM(resource_1) AS resource_1, SUM(resource_2) AS resource_2, SUM(resource_3) AS resource_3, SUM(resource_4) AS resource_4, 
                           SUM(unit_1) AS unit_1, SUM(unit_2) AS unit_2, SUM(unit_3) AS unit_3, SUM(unit_4) AS unit_4, SUM(unit_5) AS unit_5, SUM(unit_6) AS unit_6
                    FROM ship_fleets
                    WHERE alert_phase <> '.ALERT_PHASE_RED.' AND user_id = '.$user_id.' AND planet_id = '.$planet_id; 
            $goods = $db->queryrow($sql);
        }

        $primary_avg_a   = (int)($primary_avg_a / $n_ships_a);
        $secondary_avg_a = (int)($secondary_avg_a / $n_ships_a);
        $strenght_ratio_a = (int)($strenght_estimate_a*100/$strenght_estimate_tp_a);
        $primary_avg_b   = (int)($primary_avg_b / $n_ships_b);
        $secondary_avg_b = (int)($secondary_avg_b / $n_ships_b);
        $strenght_ratio_b = (int)($strenght_estimate_b*100/$strenght_estimate_tp_b);
        
        arsort($combat_list_estimate);
        
        $first_run = true; 
        
        foreach ($combat_list_estimate AS $key => $sorted_combat_ship) {
            if($first_run) {
                $side = $all_ship_list[$key]['side'];
                $first_run = false;
            }
            
            if($all_ship_list[$key]['side'] != $side) {break;}
            
            $fast_punch[$side] = $fast_punch[$side] + $all_ship_list[$key]['primary'] + $all_ship_list[$key]['secondary'];
            
            $fast_n_ships[$side]++;
            
            switch($all_ship_list[$key]['class']){
                            case 0:
                            case 1:
                                if($all_ship_list[$key]['torso'] > 2) {$fast_n_class1[$side]++;} else {$fast_n_civili[$side]++;}
                                break;
                            case 2:
                                $fast_n_class2[$side]++;
                                break;
                            case 3:
                                $fast_n_class3[$side]++;
                                break;
            }            
        }        

        $game->out('<table border="0" cellpadding="4" cellspacing="4" width="450" class="style_outer">
          <tr>
            <td align="center">
              <span class="sub_caption">'.constant($game->sprache("TEXT10")).'</span>
              <table border="0" cellpadding="2" cellspacing="2" width="450" class="style_inner">
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$game->player['user_name'].'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT15")).'</b></td>
                  <td width="115px" align="center">'.$player_b['user_name'].'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_ships_a.(isset($fast_n_ships['a']) ? '('.$fast_n_ships['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT16")).'</b></td>
                  <td width="115px" align="center">'.$n_ships_b.(isset($fast_n_ships['b']) ? '('.$fast_n_ships['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>');
        if($n_civili_a > 0 || $n_civili_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_civili_a.(isset($fast_n_civili['a']) ? '('.$fast_n_civili['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT17")).'</b></td>
                  <td width="115px" align="center">'.$n_civili_b.(isset($fast_n_civili['b']) ? '('.$fast_n_civili['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_trasporti_a > 0 || $n_trasporti_b > 0) {
            $cargo_str = '';
            for ($i=1; $i < 7; $i++ ) {
                if($goods['unit_'.$i] > 0) {
                    $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_unit'.$i.'_small.gif> '.$goods['unit_'.$i];
                }
            }
            if($goods['resource_1'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$goods['resource_1'];
            }
            if($goods['resource_2'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$goods['resource_2'];
            }
            if($goods['resource_3'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$goods['resource_3'];
            }
            if($goods['resource_4'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$goods['resource_4'];
            }    
            $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_trasporti_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT18")).'</b></td>
                  <td width="115px" align="center">'.$n_trasporti_b.'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
            if(!empty($cargo_str)) {
                $game->out('
                    <tr>
                      <td width="60px">&nbsp;</td>
                      <td width="115px" align="center">&nbsp;</td>
                      <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT29")).'</b></td>
                      <td width="115px" align="center">'.$cargo_str.'</td>          
                      <td width="60px">&nbsp;</td>
                    </tr>
                ');        
            }
        }
        if($n_class1_a > 0 || $n_class1_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class1_a.(isset($fast_n_class1['a']) ? '('.$fast_n_class1['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT19")).'</b></td>
                  <td width="115px" align="center">'.$n_class1_b.(isset($fast_n_class1['b']) ? '('.$fast_n_class1['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_class2_a > 0 || $n_class2_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class2_a.(isset($fast_n_class2['a']) ? '('.$fast_n_class2['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                  <td width="115px" align="center">'.$n_class2_b.(isset($fast_n_class2['b']) ? '('.$fast_n_class2['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_class3_a > 0 || $n_class3_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class3_a.(isset($fast_n_class3['a']) ? '('.$fast_n_class3['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td>
                  <td width="115px" align="center">'.$n_class3_b.(isset($fast_n_class3['b']) ? '('.$fast_n_class3['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT22")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        if($punch_estimate_civili_a > 0 || $punch_estimate_civili_b > 0) {
            $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_civili_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT17")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_civili_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($punch_estimate_class1_a > 0 || $punch_estimate_class1_b > 0) {
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class1_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT19")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class1_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }            
        if($punch_estimate_class2_a > 0 || $punch_estimate_class2_b > 0) {
            $game->out('            
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class2_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class2_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($punch_estimate_class3_a > 0 || $punch_estimate_class3_b > 0) {
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class3_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_class3_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }            
        $game->out('                
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$fast_punch['a'].'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT33")).'</b></td>
                  <td width="115px" align="center">'.(int)$fast_punch['b'].'</td>
                  <td width="60px">&nbsp;</td>
                </tr>                
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$primary_avg_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT23")).'</b></td>
                  <td width="115px" align="center">'.(int)$primary_avg_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$secondary_avg_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT24")).'</b></td>
                  <td width="115px" align="center">'.(int)$secondary_avg_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT25")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        if($shield_estimate_civili_a > 0 || $shield_estimate_civili_b > 0) {
            $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_civili_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT17")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_civili_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($shield_estimate_class1_a > 0 || $shield_estimate_class1_b > 0) {
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_class1_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT19")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_class1_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }            
        if($shield_estimate_class2_a > 0 || $shield_estimate_class2_b > 0) {
            $game->out('            
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_class2_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_class2_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($shield_estimate_class3_a > 0 || $shield_estimate_class3_b > 0) {
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_class3_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_class3_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        $game->out('                
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_a.' ['.$strenght_ratio_a.'%]'.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT26")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_b.' ['.$strenght_ratio_b.'%]'.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        if($strenght_estimate_civili_a > 0 || $strenght_estimate_civili_b > 0) {
            $strenght_estimate_civili_a > 0 ? $strenght_ratio_civili_a = (int)($strenght_estimate_civili_a*100/$strenght_estimate_civili_tp_a) : '';
            $strenght_estimate_civili_b > 0 ? $strenght_ratio_civili_b = (int)($strenght_estimate_civili_b*100/$strenght_estimate_civili_tp_b) : '';
            $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_civili_a.' ['.$strenght_ratio_civili_a.'%]'.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT17")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_civili_b.' ['.$strenght_ratio_civili_b.'%]'.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($strenght_estimate_class1_a > 0 || $strenght_estimate_class1_b > 0) {
            $strenght_estimate_class1_a > 0 ? $strenght_ratio_class1_a = (int)($strenght_estimate_class1_a*100/$strenght_estimate_class1_tp_a) : '';
            $strenght_estimate_class1_b > 0 ? $strenght_ratio_class1_b = (int)($strenght_estimate_class1_b*100/$strenght_estimate_class1_tp_b) : '';            
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_class1_a.' ['.$strenght_ratio_class1_a.'%]'.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT19")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_class1_b.' ['.$strenght_ratio_class1_b.'%]'.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }            
        if($strenght_estimate_class2_a > 0 || $strenght_estimate_class2_b > 0) {
            $strenght_estimate_class2_a > 0 ? $strenght_ratio_class2_a = (int)($strenght_estimate_class2_a*100/$strenght_estimate_class2_tp_a) : '';
            $strenght_estimate_class2_b > 0 ? $strenght_ratio_class2_b = (int)($strenght_estimate_class2_b*100/$strenght_estimate_class2_tp_b) : '';            
            $game->out('            
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_class2_a.' ['.$strenght_ratio_class2_a.'%]'.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_class2_b.' ['.$strenght_ratio_class2_b.'%]'.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }
        if($strenght_estimate_class3_a > 0 || $strenght_estimate_class3_b > 0) {
            $strenght_estimate_class3_a > 0 ? $strenght_ratio_class3_a = (int)($strenght_estimate_class3_a*100/$strenght_estimate_class3_tp_a) : '';
            $strenght_estimate_class3_b > 0 ? $strenght_ratio_class3_b = (int)($strenght_estimate_class3_b*100/$strenght_estimate_class3_tp_b) : '';            
            $game->out('        
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_class3_a.' ['.$strenght_ratio_class3_a.'%]'.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_class3_b.' ['.$strenght_ratio_class3_b.'%]'.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>');
        }        
        $game->out('                
              </table>
            </td>
          </tr>
        </table><br><br><center>'.constant($game->sprache("TEXT27")).'</center><br>
        <center>'.constant($game->sprache("TEXT33_NOTE")).'</center><br><br>
       <center>'.constant($game->sprache("TEXT28")).'</center><br>         
        <center>'.constant($game->sprache("TEXT28_B")).'</center>');        
        break;
    case 2:
        $off_level_multi = [0, 0.005, 0.01, 0.015, 0.02];
        $fleet_id   = filter_input(INPUT_POST, 'fleet_id', FILTER_SANITIZE_NUMBER_INT);
        
        //Input Data check

        $sql = 'SELECT * FROM ship_fleets WHERE fleet_id = '.$fleet_id.' AND owner_id = '.$game->player['user_id'];
        
        if(($q_fleet = $db->queryrow($sql)) === false) {
            message(NOTICE, constant($game->sprache("TEXT11")));
        }
        
        // Fetch fleet data for analysis
        $sql = 'SELECT officer_name, officer_rank, officer_level, optimal, optm_class_0, optm_class_1, optm_class_2, optm_class_3, mod_1a, mod_1b, mod_2a, mod_2b 
                FROM officers 
                WHERE user_id = '.$game->player['user_id'].' AND fleet_id = '.$fleet_id;
        
        if(($q_offi = $db->queryrow($sql)) === false) {
            $off_lvl_bonus = 1;
            $flag_off = false;
        }
        elseif(isset($q_offi['optimal']) && $q_offi['optimal'] == 0) {
            // off_lvl_bonus + over bonus
            $flag_off = true;            
            $off_lvl_bonus = $officer_rank_bonus[min(10, $q_offi['officer_level'])];
            if($q_offi['officer_level'] > 10) {
                // over bonus
                $off_lvl_bonus +=  ($q_offi['officer_level'] - 10)*$off_level_multi[$q_offi['officer_rank']];
            }
            $off_lvl_bonus = round($off_lvl_bonus, 2, PHP_ROUND_HALF_DOWN);            
            $off_lvl_bonus += 1;
        }
        elseif(isset($q_offi['optimal']) && $q_offi['optimal'] != 0 && $q_offi['optimal'] >= $q_fleet['n_ships']) {
            // off_lvl_bonus + over bonus
            $flag_off = true;            
            $off_lvl_bonus = $officer_rank_bonus[min(10, $q_offi['officer_level'])];
            if($q_offi['officer_level'] > 10) {
                // over bonus
                $off_lvl_bonus +=  ($q_offi['officer_level'] - 10)*$off_level_multi[$q_offi['officer_rank']];
            }
            $off_lvl_bonus = round($off_lvl_bonus, 2, PHP_ROUND_HALF_DOWN);            
            $off_lvl_bonus += 1;            
        }
        else {
            $off_lvl_bonus = 1;
            $flag_off = false;
        }
        
        $sql = 'SELECT s.ship_id, tp.ship_class AS form_class, s.experience, s.template_id, rating_1a, rating_1b, rating_2a, rating_2b, s.rof, s.rof2
                FROM ships s
                INNER JOIN ship_templates tp ON (s.template_id = tp.id)
                WHERE s.fleet_id = '.$fleet_id;
        
        $raw_ships = $db->queryrowset($sql);
        
        $class_counter = [0,0,0,0];
        
        if($flag_off) {
            //formation bonus
            foreach ($raw_ships AS $ship) {
                $class_counter[$ship['form_class']]++;
            }
            $form_diff = abs($class_counter[0] - ($q_fleet['n_ships']*($q_offi['optm_class_0']/100))) +
                         abs($class_counter[1] - ($q_fleet['n_ships']*($q_offi['optm_class_1']/100))) +
                         abs($class_counter[2] - ($q_fleet['n_ships']*($q_offi['optm_class_2']/100))) +
                         abs($class_counter[3] - ($q_fleet['n_ships']*($q_offi['optm_class_3']/100)));

            $off_form_bonus = round(0.36 - (0.72 / $q_fleet['n_ships'] * $form_diff), 2);
            
            if($off_form_bonus < -0.36) {$off_form_bonus = -0.36;}            

            $eff_ratio = round(($off_form_bonus*100 / 0.36), 2);

            if($eff_ratio < -100) {$eff_ratio = -100;}            
            
            $off_form_bonus += 1;            
        }
        else {
            $off_form_bonus = 1;
        }
        
        $sql = 'SELECT DISTINCT id, name, race, ship_class AS class, ship_torso AS torso, value_6, value_7, value_8, value_11, value_12, value_1, value_2, value_4, value_5, 
                                ship_templates.rof, ship_templates.rof2
                FROM ship_templates 
                INNER JOIN ships ON ship_templates.id = ships.template_id 
                WHERE ships.fleet_id = '.$fleet_id;
        
        $raw_tp = $db->queryrowset($sql);
        
        foreach ($raw_tp as $raw_item) {
            $tp_list[$raw_item['id']]['name'] = $raw_item['name'];
            $tp_list[$raw_item['id']]['race'] = $raw_item['race'];
            $tp_list[$raw_item['id']]['class'] = $raw_item['class'];            
            $tp_list[$raw_item['id']]['torso'] = $raw_item['torso'];
            $tp_list[$raw_item['id']]['value_1'] = $raw_item['value_1'];
            $tp_list[$raw_item['id']]['value_2'] = $raw_item['value_2'];
            $tp_list[$raw_item['id']]['value_4'] = $raw_item['value_4'];
            $tp_list[$raw_item['id']]['value_5'] = $raw_item['value_5'];
            $tp_list[$raw_item['id']]['value_6'] = $raw_item['value_6'];
            $tp_list[$raw_item['id']]['value_7'] = $raw_item['value_7'];
            $tp_list[$raw_item['id']]['value_8'] = $raw_item['value_8'];
            $tp_list[$raw_item['id']]['value_11'] = $raw_item['value_11'];
            $tp_list[$raw_item['id']]['value_12'] = $raw_item['value_12'];            
            
        }
        
        foreach ($raw_ships as $ship_item) {
            // ship_list creation and RAW FirstStrike Value computation
            $ship_list[$ship_item['ship_id']]['experience'] = $ship_item['experience'];
            $ship_list[$ship_item['ship_id']]['rating_1a'] = $ship_item['rating_1a'];
            $ship_list[$ship_item['ship_id']]['rating_1b'] = $ship_item['rating_1b'];
            $ship_list[$ship_item['ship_id']]['rating_2a'] = $ship_item['rating_2a'];            
            $ship_list[$ship_item['ship_id']]['rating_2b'] = $ship_item['rating_2b'];                        
            $ship_list[$ship_item['ship_id']]['template_id'] = $ship_item['template_id'];
            
            // Weapon bonus
            if($ship_item['experience'] >= 110) {$ship_list[$ship_item['ship_id']]['weap_bonus'] = 0.32;}
            elseif($ship_item['experience'] >= 60) {$ship_list[$ship_item['ship_id']]['weap_bonus'] = 0.20;}
            else $ship_list[$ship_item['ship_id']]['weap_bonus'] = 0;
            
            // Rof & Rof2 bonuses
            if($ship_item['experience'] >= 200) {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'] + 3;
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'] + 2;
            } 
            elseif($ship_item['experience'] >= 185) {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'] + 3;
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'] + 1;                
            }
            elseif($ship_item['experience'] >= 170) {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'] + 2;
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'] + 1;                
            }
            elseif($ship_item['experience'] >= 155) {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'] + 1;
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'] + 1;                
            }
            elseif($ship_item['experience'] >= 140) {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'] + 1;
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'];                
            }
            else {
                $ship_list[$ship_item['ship_id']]['rof'] = $ship_item['rof'];
                $ship_list[$ship_item['ship_id']]['rof2'] = $ship_item['rof2'];                
            }            
            
            $buff_value_6 = $buff_value_7 = $buff_value_8 = $buff_value_11 = $buff_value_12 = $buff_firststrike = 0;
            $flag_race = $flag_class = false;
            
            // Add Race Bonuses
            switch($tp_list[$ship_item['template_id']]['race']){
                case 0:
                    break;
                case 1:
                    if($ship_item['experience']>=$ship_ranks[9]) {
                        $buff_value_12 += 10;
                        $flag_race = true;
                        break;
                    }
                case 2:
                case 3:
                case 4:        
                case 5:
                    break;
                case 8:
                    if($ship_item['experience']>=$ship_ranks[2]) {
                        $buff_value_8 += 15;
                        $flag_race = true;
                        break;
                    }                                        
                    break;
                case 9:                  
                case 11:
                    break;                    
            }
            
            // Add Class Bonuses
            switch($tp_list[$ship_item['template_id']]['class']) {
                case 3:                    
                case 2:
                    break;
                case 1:
                    if($ship_item['experience']>=$ship_ranks[7]) {
                        $buff_value_11 += 15;
                        $buff_value_8 += 10;
                        $flag_class = true;
                        break;
                    }
                    if($ship_item['experience']>=$ship_ranks[5]) {
                        $buff_value_11 += 15;
                        $buff_value_8 += 10;
                        $flag_class = true;
                        break;
                    }
                    if($ship_item['experience']>=$ship_ranks[4]) {
                        $buff_value_8 += 10;
                        $flag_class = true;
                        break;
                    }                    
                    break;
                case 0:
                    break;
            }
            
            $official_composite_bonus = round(($off_form_bonus + $off_lvl_bonus)/2, 2);
            // $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['primary'] += $tp_list[$ship_item['template_id']]['value_1']*$tp_list[$ship_item['template_id']]['rof'];
            $_primary_bonus = $ship_list[$ship_item['ship_id']]['weap_bonus'] + $official_composite_bonus;
            if($_primary_bonus < 0) {$_primary_bonus = 0;}
            $_value_1 = (int)($tp_list[$ship_item['template_id']]['value_1'] * $_primary_bonus);
            $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['primary'] += (int)(((($_value_1/2) * (0.85 + ((int)$ship_item['rating_1a'] * 0.005))) + 
                                                                                                 (($_value_1/2) * (0.85 + ((int)$ship_item['rating_1b'] * 0.005))) +
                                                                                                   $_value_1*($ship_item['experience']/1000))*0.25) * $ship_list[$ship_item['ship_id']]['rof'];
            
            // $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['secondary'] += $tp_list[$ship_item['template_id']]['value_2']*$tp_list[$ship_item['template_id']]['rof2'];
            $_secondary_bonus = $ship_list[$ship_item['ship_id']]['weap_bonus'] + $official_composite_bonus;
            if($_secondary_bonus < 0) {$_secondary_bonus = 0;}
            $_value_2 = (int)($tp_list[$ship_item['template_id']]['value_2'] * $_secondary_bonus);            
            $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['secondary'] += (int)(((($_value_2/2) * (0.85 + ((int)$ship_item['rating_2a'] * 0.005))) + 
                                                                                                   (($_value_2/2) * (0.85 + ((int)$ship_item['rating_2b'] * 0.005))) +
                                                                                                     $_value_2*($ship_item['experience']/1000))*0.40) * $ship_list[$ship_item['ship_id']]['rof2'];            
            $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['shields'] += $tp_list[$ship_item['template_id']]['value_4'];
            $fleet_value_per_class[$tp_list[$ship_item['template_id']]['class']]['hulls'] += $tp_list[$ship_item['template_id']]['value_5'];
            
            $ship_list[$ship_item['ship_id']]['fs'] = (($tp_list[$ship_item['template_id']]['value_6'] * $official_composite_bonus) * 2) +
                                                      (($tp_list[$ship_item['template_id']]['value_7'] * $official_composite_bonus) * 3) +
                                                      ($tp_list[$ship_item['template_id']]['value_8'] + $buff_value_8)  +
                                                      (($tp_list[$ship_item['template_id']]['value_11'] + $buff_value_11)* 0.5) +
                                                      ($tp_list[$ship_item['template_id']]['value_12'] + $buff_value_12) +
                                                      $buff_firststrike + 
                                                      fs_bonus_by_race($tp_list[$ship_item['template_id']]['race']);
            
            $ship_list[$ship_item['ship_id']]['flags'] = '&nbsp;'.($flag_class ? 'C' : '').($flag_race ? 'R' : '');
            
            switch($tp_list[$ship_item['template_id']]['class']) {
                case 0:
                    break;
                case 1:
                    $order_list_1[$ship_item['ship_id']] = $ship_list[$ship_item['ship_id']]['fs'];
                    break;
                case 2:
                    $order_list_2[$ship_item['ship_id']] = $ship_list[$ship_item['ship_id']]['fs'];
                    break;
                case 3:
                    $order_list_3[$ship_item['ship_id']] = $ship_list[$ship_item['ship_id']]['fs'];
                    break;
            }
        }
        
        arsort($order_list_1);
        arsort($order_list_2);
        arsort($order_list_3);

        // Class Lists creations, FS Ordered
        foreach ($order_list_1 as $key => $order_item) {
            $class_1_html .= '<option id="'.$order_item.'" value="'.$key.'">'.$tp_list[$ship_list[$key]['template_id']]['name'].' (FS:'.$order_item.', Exp: '.$ship_list[$key]['experience'].$ship_list[$key]['flags'].')</option>';
        }
        foreach ($order_list_2 as $key => $order_item) {
            $class_2_html .= '<option id="'.$order_item.'" value="'.$key.'">'.$tp_list[$ship_list[$key]['template_id']]['name'].' (FS:'.$order_item.', Exp: '.$ship_list[$key]['experience'].$ship_list[$key]['flags'].')</option>';
        }
        foreach ($order_list_3 as $key => $order_item) {
            $class_3_html .= '<option id="'.$order_item.'" value="'.$key.'">'.$tp_list[$ship_list[$key]['template_id']]['name'].' (FS:'.$order_item.', Exp: '.$ship_list[$key]['experience'].$ship_list[$key]['flags'].')</option>';
        }        

        $game->out('<table border="0" cellpadding="4" cellspacing="4" width="100%" class="style_outer">
            <tr>
            <td align="center">
            <span class="sub_caption">'.constant($game->sprache("TEXT10")).'</span>
            <br>
            <div style="position:relative; float:left;">
            <p>Ufficiale: '.($flag_off ? $q_offi['officer_name'] : 'Nessuno').' - Grado: '.($flag_off ? $q_offi['officer_rank'] : ' n/d ').' - Livello: '.($flag_off ? $q_offi['officer_level'] : ' n/d ').'<br>
               Formazione ottimale: Civili '.($flag_off ? $q_offi['optm_class_0'] : 'Nessuno').' - Classe 1 '.($flag_off ? $q_offi['optm_class_1'] : ' n/d ').' - Classe 2 '.($flag_off ? $q_offi['optm_class_2'] : ' n/d ').' Classe 3 '.($flag_off ? $q_offi['optm_class_3'] : ' n/d ').'<br>
               Flotta: Navi: '.$q_fleet['n_ships'].'; Civili: '.$class_counter[0].', Classe 1: '.$class_counter[1].', Classe 2: '.$class_counter[2].', Classe 3: '.$class_counter[3].' - Efficienza: '.($flag_off ? $eff_ratio : ' n/d ').'<br>    
               Bonus Livello:'.($flag_off ? $off_lvl_bonus : ' n/d ').' - Bonus Formazione:'.($flag_off ? $off_form_bonus : ' n/d ').' - Bonus Ufficiale:'.($flag_off ? $official_composite_bonus : ' n/d ').'
            </p>
            </div>
            
            <table border="0" cellpadding="2" cellspacing="2" width="99%" class="style_inner">
            <tr>
            <td align="center">Navi di Classe 1<br>Unit&agrave; presenti: '.(count($order_list_1)).'</td>
            <td align="center">Navi di Classe 2<br>Unit&agrave; presenti: '.(count($order_list_2)).'</td>
            <td align="center">Navi di Classe 3<br>Unit&agrave; presenti: '.(count($order_list_3)).'</td>
            </tr>');
            /*
            <tr>
            <td align="center">Primario: '.($fleet_value_per_class[1]['primary'] > 0 ? $fleet_value_per_class[1]['primary'] : 'n/a').'</td>
            <td align="center">Primario: '.($fleet_value_per_class[2]['primary'] > 0 ? $fleet_value_per_class[2]['primary'] : 'n/a').'</td>
            <td align="center">Primario: '.($fleet_value_per_class[3]['primary'] > 0 ? $fleet_value_per_class[3]['primary'] : 'n/a').'</td>            
            </tr>
            <tr>
            <td align="center">Secondario: '.($fleet_value_per_class[1]['secondary'] > 0 ? $fleet_value_per_class[1]['secondary'] : 'n/a').'</td>
            <td align="center">Secondario: '.($fleet_value_per_class[2]['secondary'] > 0 ? $fleet_value_per_class[2]['secondary'] : 'n/a').'</td>
            <td align="center">Secondario: '.($fleet_value_per_class[3]['secondary'] > 0 ? $fleet_value_per_class[3]['secondary'] : 'n/a').'</td>            
            </tr>
             * 
             */
        $game->out('
            <tr>
            <td align="center">Scudi: '.($fleet_value_per_class[1]['shields'] > 0 ? $fleet_value_per_class[1]['shields'] : 'n/a').'</td>
            <td align="center">Scudi: '.($fleet_value_per_class[2]['shields'] > 0 ? $fleet_value_per_class[2]['shields'] : 'n/a').'</td>
            <td align="center">Scudi: '.($fleet_value_per_class[3]['shields'] > 0 ? $fleet_value_per_class[3]['shields'] : 'n/a').'</td>            
            </tr>
            <tr>
            <td align="center">Scafo: '.($fleet_value_per_class[1]['hulls'] > 0 ? $fleet_value_per_class[1]['hulls'] : 'n/a').'</td>
            <td align="center">Scafo: '.($fleet_value_per_class[2]['hulls'] > 0 ? $fleet_value_per_class[2]['hulls'] : 'n/a').'</td>
            <td align="center">Scafo: '.($fleet_value_per_class[3]['hulls'] > 0 ? $fleet_value_per_class[3]['hulls'] : 'n/a').'</td>            
            </tr>            
            <tr>
            <td width=33%>
                <select name="class_1" style="width: 100%;" size="20" multiple="multiple">
                '.(!empty($class_1_html) ? $class_1_html : '<option>Nessuna ====== </option>').'
                </select>            
            </td>
            <td width 34%>
                <select name="class_2" style="width: 100%;" size="20" multiple="multiple">
                '.(!empty($class_2_html) ? $class_2_html : '<option>Nessuna ====== </option>').'
                </select>
            </td>
            <td width 33%>
                <select name="class_3" style="width: 100%;" size="20" multiple="multiple">
                '.(!empty($class_3_html) ? $class_3_html : '<option>Nessuna ====== </option>').'
                </select>
            </td>
            </tr>
            </table></td></tr></table>');
        break;
    case 3:
        $user_id   = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $planet_id = filter_input(INPUT_POST, 'planet_id', FILTER_SANITIZE_NUMBER_INT);
        $alert_phase = filter_input(INPUT_POST, 'alert_phase', FILTER_SANITIZE_NUMBER_INT);
        
        //Input Data check

        if(empty($_POST['fleets'])) {
            message(NOTICE, constant($game->sprache("TEXT11")));
        }

        $fleets = array();

        for($i = 0; $i < count($_POST['fleets']); ++$i) {
            $_temp = (int)$_POST['fleets'][$i];

            if(!empty($_temp)) {
                $fleets[] = $_temp;
            }
        }

        if(empty($user_id)) {
            message(NOTICE, constant($game->sprache("TEXT12")));
        }

        if(empty($planet_id)) {
            message(NOTICE, constant($game->sprache("TEXT13")));
        }

        if(!isset($alert_phase)) {
            message(NOTICE, constant($game->sprache("TEXT31")));
        }
        
        if($alert_phase == ALERT_PHASE_RED) {
            message(NOTICE, constant($game->sprache("TEXT32")));
        }
        
        //Input Data validation

        $sql = 'SELECT fleet_id FROM ship_fleets WHERE fleet_id IN ('.implode(',', $fleets).')';

        if(!$q_fleets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query fleet data');
        }

        $n_fleets = $db->num_rows();

        if($n_fleets == 0) {
            message(NOTICE, constant($game->sprache("TEXT14")));
        }

        $_temp = $db->fetchrowset($q_fleets);

        foreach ($_temp AS $_temp_item) {
            $fleet_ids[] = $_temp_item['fleet_id'];
        }

        $fleet_ids_str = implode(',', $fleet_ids);        
        //Data Gathering - Analyzer

        $sql = 'SELECT s.ship_id, s.hitpoints, st.race, st.rof, st.rof2, s.torp, s.rating_1a, s.rating_1b, s.rating_2a, s.rating_2b,
                       st.ship_class, st.ship_torso, st.value_1, st.value_2, st.value_4,
                       st.value_6, st.value_7, st.value_8, st.value_11, st.value_12
                FROM ship_fleets f
                INNER JOIN ships s USING (fleet_id)
                INNER JOIN ship_templates st on st.id = s.template_id
                WHERE f.fleet_id IN ('.$fleet_ids_str.')';


        $fleeta_data = $db->queryrowset($sql);

        $n_ships_a = $db->num_rows();

        $n_civili_a = $n_trasporti_a = $n_class1_a = $n_class2_a = $n_class3_a = 0;

        $punch_estimate_a    = 0;
        $primary_avg_a       = 0;
        $secondary_avg_a     = 0;
        $shield_estimate_a   = 0;
        $strenght_estimate_a = 0;

        foreach ($fleeta_data AS $fleeta_item) {
            switch($fleeta_item['ship_class']){
                case 0:
                case 1:
                    if($fleeta_item['ship_torso'] > 2) {$n_class1_a++;} 
                    else { 
                        $n_civili_a++;
                        if($fleeta_item['ship_torso'] == SHIP_TYPE_TRANSPORTER) {$n_trasporti_a++;}
                    }
                    break;
                case 2:
                    $n_class2_a++;
                    break;
                case 3:
                    $n_class3_a++;
                    break;
            }

            $primary = (((($fleeta_item['value_1']/2) * (0.85 + ((int)$fleeta_item['rating_1a'] * 0.005))) + 
                        (($fleeta_item['value_1']/2) * (0.85 + ((int)$fleeta_item['rating_1b'] * 0.005))) +
                        $fleeta_item['value_1']*($fleeta_item['experience']/1000))*0.25) * $fleeta_item['rof'];            
            
            if($fleeta_item['ship_torso'] > 2 && $fleeta_item['torp'] > 0) {
                $secondary = (((($fleeta_item['value_2']/2) * (0.85 + ((int)$fleeta_item['rating_2a'] * 0.005))) + 
                              (($fleeta_item['value_2']/2) * (0.85 + ((int)$fleeta_item['rating_2b'] * 0.005))) +
                               $fleeta_item['value_2']*($fleeta_item['experience']/1000))*0.40) * $fleeta_item['rof2'];                
            }
            else {
                $secondary = 0;
            }
            $punch_estimate_a    += ($primary + $secondary);
            $primary_avg_a       += $primary;
            $secondary_avg_a     += $secondary;
            $shield_estimate_a   += $fleeta_item['value_4'];
            $strenght_estimate_a += $fleeta_item['hitpoints'];
            
            $first_strike = fs_bonus_by_race($fleeta_item['race']) + ($fleeta_item['value_11']*0.5) + ($fleeta_item['value_6']*2) + ($fleeta_item['value_7']*3) + $fleeta_item['value_8'] + ($fleeta_item['value_12']*2.5);
            if($first_strike < 1) $first_strike = 1;
            
            $all_ship_list[$fleeta_item['ship_id']]['side'] = 'a';
            $all_ship_list[$fleeta_item['ship_id']]['primary'] = $primary;
            $all_ship_list[$fleeta_item['ship_id']]['secondary'] = $secondary;
            $all_ship_list[$fleeta_item['ship_id']]['shield'] = $fleeta_item['value_4'];
            $all_ship_list[$fleeta_item['ship_id']]['strenght'] = $fleeta_item['hitpoints'];
            $all_ship_list[$fleeta_item['ship_id']]['torso'] = $fleeta_item['ship_torso'];
            $all_ship_list[$fleeta_item['ship_id']]['class'] = $fleeta_item['ship_class'];                        
            
            $combat_list_estimate[$fleeta_item['ship_id']] = $first_strike;
        }

        //Data Gathering - Analyzed
        $player_b = $db->queryrow('SELECT user_name FROM user WHERE user_id = '.$user_id);

        $sql = 'SELECT s.ship_id, s.hitpoints, st.race, st.rof, st.rof2, s.torp, s.rating_1a, s.rating_1b, s.rating_2a, s.rating_2b,
                       st.ship_class, st.ship_torso, st.value_1, st.value_2, st.value_4,
                       st.value_6, st.value_7, st.value_8, st.value_11, st.value_12
                FROM ship_fleets f
                INNER JOIN ships s USING (fleet_id)
                INNER JOIN ship_templates st on st.id = s.template_id
                WHERE f.alert_phase = '.$alert_phase.' AND f.user_id = '.$user_id.' AND f.planet_id = '.$planet_id;


        $fleetb_data = $db->queryrowset($sql);

        $n_ships_b = $db->num_rows();

        $n_civili_b = $n_trasporti_b = $n_class1_b = $n_class2_b = $n_class3_b = 0;

        $punch_estimate_b    = 0;
        $primary_avg_b       = 0;
        $secondary_avg_b     = 0;
        $shield_estimate_b   = 0;
        $strenght_estimate_b = 0;

        foreach ($fleetb_data AS $fleetb_item) {
            switch($fleetb_item['ship_class']){
                case 0:
                case 1:
                    if($fleetb_item['ship_torso'] > 2) {$n_class1_b++;} 
                    else { 
                        $n_civili_b++;
                        if($fleetb_item['ship_torso'] == SHIP_TYPE_TRANSPORTER) {$n_trasporti_b++;}
                    }
                    break;
                case 2:
                    $n_class2_b++;
                    break;
                case 3:
                    $n_class3_b++;
                    break;
            }


            $primary = (((($fleetb_item['value_1']/2) * (0.85 + ((int)$fleetb_item['rating_1a'] * 0.005))) + 
                        (($fleetb_item['value_1']/2) * (0.85 + ((int)$fleetb_item['rating_1b'] * 0.005))) +
                        $fleetb_item['value_1']*($fleetb_item['experience']/1000))*0.25) * $fleetb_item['rof'];
            
            if($fleetb_item['ship_torso'] > 2 && $fleetb_item['torp'] > 0) {
                $secondary = (((($fleetb_item['value_2']/2) * (0.85 + ((int)$fleetb_item['rating_2a'] * 0.005))) + 
                              (($fleetb_item['value_2']/2) * (0.85 + ((int)$fleetb_item['rating_2b'] * 0.005))) +
                               $fleetb_item['value_2']*($fleetb_item['experience']/1000))*0.40) * $fleetb_item['rof2'];                
            }
            else {
                $secondary = 0;
            }
            $punch_estimate_b    += ($primary + $secondary);
            $primary_avg_b       += $primary;
            $secondary_avg_b     += $secondary;
            $shield_estimate_b   += $fleetb_item['value_4'];
            $strenght_estimate_b += $fleetb_item['hitpoints'];
            
            $first_strike = fs_bonus_by_race($fleetb_item['race']) + ($fleetb_item['value_11']*0.5) + ($fleetb_item['value_6']*2) + ($fleetb_item['value_7']*3) + $fleetb_item['value_8'] + ($fleetb_item['value_12']*2.5);
            if($first_strike < 1) $first_strike = 1;

            
            $all_ship_list[$fleetb_item['ship_id']]['side'] = 'b';
            $all_ship_list[$fleetb_item['ship_id']]['primary'] = $primary;
            $all_ship_list[$fleetb_item['ship_id']]['secondary'] = $secondary;
            $all_ship_list[$fleetb_item['ship_id']]['shield'] = $fleetb_item['value_4'];
            $all_ship_list[$fleetb_item['ship_id']]['strenght'] = $fleetb_item['hitpoints'];
            $all_ship_list[$fleetb_item['ship_id']]['torso'] = $fleetb_item['ship_torso'];
            $all_ship_list[$fleetb_item['ship_id']]['class'] = $fleetb_item['ship_class'];                        
            
            $combat_list_estimate[$fleetb_item['ship_id']] = $first_strike;            
        }

        if($n_trasporti_b > 0) {
            $sql = 'SELECT SUM(resource_1) AS resource_1, SUM(resource_2) AS resource_2, SUM(resource_3) AS resource_3, SUM(resource_4) AS resource_4, 
                           SUM(unit_1) AS unit_1, SUM(unit_2) AS unit_2, SUM(unit_3) AS unit_3, SUM(unit_4) AS unit_4, SUM(unit_5) AS unit_5, SUM(unit_6) AS unit_6
                    FROM ship_fleets
                    WHERE f.alert_phase = '.$alert_phase.' AND user_id = '.$user_id.' AND planet_id = '.$planet_id; 
            $goods = $db->queryrow($sql);
        }

        $primary_avg_a   = (int)($primary_avg_a / $n_ships_a);
        $secondary_avg_a = (int)($secondary_avg_a / $n_ships_a);
        $primary_avg_b   = (int)($primary_avg_b / $n_ships_b);
        $secondary_avg_b = (int)($secondary_avg_b / $n_ships_b);

        arsort($combat_list_estimate);
        
        $first_run = true;
              
        foreach ($combat_list_estimate AS $key => $sorted_combat_ship) {
            if($first_run) {
                $side = $all_ship_list[$key]['side'];
                $first_run = false;
            }
            
            if($all_ship_list[$key]['side'] != $side) break;
            
            $fast_punch[$side] = $fast_punch[$side] + $all_ship_list[$key]['primary'] + $all_ship_list[$key]['secondary'];
            
            $fast_n_ships[$side]++;
            
            switch($all_ship_list[$key]['class']){
                            case 0:
                            case 1:
                                if($all_ship_list[$key]['torso'] > 2) {$fast_n_class1[$side]++;} else {$fast_n_civili[$side]++;}
                                break;
                            case 2:
                                $fast_n_class2[$side]++;
                                break;
                            case 3:
                                $fast_n_class3[$side]++;
                                break;
            }            
        }
        
        $game->out('<table border="0" cellpadding="4" cellspacing="4" width="450" class="style_outer">
          <tr>
            <td align="center">
              <span class="sub_caption">'.constant($game->sprache("TEXT10")).'</span>
              <table border="0" cellpadding="2" cellspacing="2" width="450" class="style_inner">
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$game->player['user_name'].'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT15")).'</b></td>
                  <td width="115px" align="center">'.$player_b['user_name'].'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_ships_a.(isset($fast_n_ships['a']) ? '('.$fast_n_ships['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT16")).'</b></td>
                  <td width="115px" align="center">'.$n_ships_b.(isset($fast_n_ships['b']) ? '('.$fast_n_ships['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>');
        if($n_civili_a > 0 || $n_civili_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_civili_a.(isset($fast_n_civili['a']) ? '('.$fast_n_civili['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT17")).'</b></td>
                  <td width="115px" align="center">'.$n_civili_b.(isset($fast_n_civili['b']) ? '('.$fast_n_civili['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_trasporti_a > 0 || $n_trasporti_b > 0) {
            $cargo_str = '';
            for ($i=1; $i < 7; $i++ ) {
                if($goods['unit_'.$i] > 0) {
                    $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_unit'.$i.'_small.gif> '.$goods['unit_'.$i];
                }
            }
            if($goods['resource_1'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$goods['resource_1'];
            }
            if($goods['resource_2'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$goods['resource_2'];
            }
            if($goods['resource_3'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$goods['resource_3'];
            }
            if($goods['resource_4'] > 0) {
                $cargo_str .= '<br><img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$goods['resource_4'];
            }    
            $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_trasporti_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT18")).'</b></td>
                  <td width="115px" align="center">'.$n_trasporti_b.'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
            if(!empty($cargo_str)) {
                $game->out('
                    <tr>
                      <td width="60px">&nbsp;</td>
                      <td width="115px" align="center">&nbsp;</td>
                      <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT29")).'</b></td>
                      <td width="115px" align="center">'.$cargo_str.'</td>          
                      <td width="60px">&nbsp;</td>
                    </tr>
                ');        
            }
        }
        if($n_class1_a > 0 || $n_class1_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class1_a.(isset($fast_n_class1['a']) ? '('.$fast_n_class1['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT19")).'</b></td>
                  <td width="115px" align="center">'.$n_class1_b.(isset($fast_n_class1['b']) ? '('.$fast_n_class1['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_class2_a > 0 || $n_class2_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class2_a.(isset($fast_n_class2['a']) ? '('.$fast_n_class2['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT20")).'</b></td>
                  <td width="115px" align="center">'.$n_class2_b.(isset($fast_n_class2['b']) ? '('.$fast_n_class2['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        if($n_class3_a > 0 || $n_class3_b > 0) {
            $game->out('
                    <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$n_class3_a.(isset($fast_n_class3['a']) ? '('.$fast_n_class3['a'].')' : '').'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td>
                  <td width="115px" align="center">'.$n_class3_b.(isset($fast_n_class3['b']) ? '('.$fast_n_class3['b'].')' : '').'</td>          
                  <td width="60px">&nbsp;</td>
                </tr>
            ');
        }
        $game->out('
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$punch_estimate_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT22")).'</b></td>
                  <td width="115px" align="center">'.(int)$punch_estimate_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$fast_punch['a'].'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT33")).'</b></td>
                  <td width="115px" align="center">'.(int)$fast_punch['b'].'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$primary_avg_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT23")).'</b></td>
                  <td width="115px" align="center">'.(int)$primary_avg_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.(int)$secondary_avg_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT24")).'</b></td>
                  <td width="115px" align="center">'.(int)$secondary_avg_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$shield_estimate_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT25")).'</b></td>
                  <td width="115px" align="center">'.$shield_estimate_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
                <tr>
                  <td width="60px">&nbsp;</td>
                  <td width="115px" align="center">'.$strenght_estimate_a.'</td>
                  <td width="100px"  align="center"><b>'.constant($game->sprache("TEXT26")).'</b></td>
                  <td width="115px" align="center">'.$strenght_estimate_b.'</td>
                  <td width="60px">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table><br><br><center>'.constant($game->sprache("TEXT27")).'</center><br>
        <center>'.constant($game->sprache("TEXT33_NOTE")).'</center><br><br>
        <center>'.constant($game->sprache("TEXT28")).'</center><br>    
        <center>'.constant($game->sprache("TEXT28_B")).'</center>');        
        
        break;
        
    default :
        break;
}
?>