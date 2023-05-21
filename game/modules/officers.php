<?php
/*      
    Officers management module, added to STFC by Delogu in 2016
 
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

function officers_adapt_formation($race, $rank, $num, &$formation, &$optimal) {
    
    switch ($race) {
        case 0:
            break;
        case 1:
            if($rank == 2 && $num == 0) {
                $formation[1] -= 75;
                $formation[2] += 50;
                $formation[3] += 25;
            }
            break;
        case 2:
            if($rank == 2 && $num == 0) {
                $formation[1] += 5;
                $formation[3] -= 5;
            }            
            break;
        case 3:
            if($rank == 2 && $num == 0) {
                $formation[1] -= 75;
                $formation[2] += 55;
                $formation[3] += 20;
            }
            elseif($rank == 3 && $num == 0) {
                $formation[1] -= 40;
                $formation[2] += 20;
                $formation[3] += 20;                
            }
            elseif($rank == 4 && $num == 0) {
                $formation[1] -= 40;
                $formation[2] += 15;
                $formation[3] += 25;                
            }
            if($rank == 2 && $num == 1) {
                $optimal[1] += 200;
            }
            break;
        case 4:
            if($rank == 2 && $num == 0) {
                $formation[1] -= 75;
                $formation[2] += 50;
                $formation[3] += 25;
            }
            elseif($rank == 3 && $num == 2) {
                $formation[1] -= 60;
                $formation[2] += 30;
                $formation[3] += 30;                
            }
            break;
        case 5:
            if($rank == 2 && $num == 0) {
                $optimal[1] += 60;
            }
            if($rank > 1 && $num == 1) {
                $formation[0] += 5;
            }            
            break;
        case 8:
            if($rank == 2 && $num == 0) {
                $formation[1] += 5;
                $formation[3] -= 5;
            }
            elseif($rank == 2 && $num == 2) {
                $optimal[1] += 190;                
            }
            break;
        case 9:
            break;
        case 11:
            if($rank == 2 && $num == 0) {
                $optimal[1] += 200;
            }            
            if($rank == 2 && $num == 1) {
                $formation[1] -= 15;
                $formation[2] += 20;
                $formation[3] -= 5;
            }            
        default :
            break;
    }
}

function change_formation($id_form, $rank, $race, $racial0, $racial1, $racial2, &$formation)
{
    $rv = false;
    switch($id_form)
    {
        case 0:
        break;
        case 1: // Alfa 1
            $formation[$rank][0] = 0;
            $formation[$rank][1] = 85;
            $formation[$rank][2] = 15;
            $formation[$rank][3] = 0;
            $rv = true;
        break;
        case 2: // Alfa 2
            $formation[$rank][0] = 0;
            $formation[$rank][1] = 75;
            $formation[$rank][2] = 20;
            $formation[$rank][3] = 5;            
            $rv = true;
        break;
        case 3: // Alfa 3
            $formation[$rank][0] = 0;
            $formation[$rank][1] = 60;
            $formation[$rank][2] = 30;
            $formation[$rank][3] = 10;
            $rv = true;
        break;
        case 4: // Alfa 4 - Federation
            if($race == 0 && $rank == 1 && $racial0) {
                $formation[$rank][0] = 0; 
                $formation[$rank][1] = 50;
                $formation[$rank][2] = 30;
                $formation[$rank][3] = 20;
                $rv = true;
            }
        break;
        case 5: // Beta 1 - Romulan
            if($race == 1 && $rank == 1 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 60;
                $formation[$rank][2] = 40;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 6: // Beta 2 - Romulan #2             
            if($race == 1 && $rank == 2 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 70;
                $formation[$rank][3] = 30;
                $rv = true;
            }            
        break;
        case 7: // Alfa 5 - Klingon
            if($race == 2 && $rank == 2 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 80;
                $formation[$rank][2] = 20;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 8: // Gamma 1 - Cardassia 
            if($race == 3 && $rank == 1 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 85;
                $formation[$rank][3] = 15;
                $rv = true;
            }           
        break;
        case 9: // Gamma 2 - Cardassia
            if($race == 3 && $rank == 2 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 75;
                $formation[$rank][3] = 25;
                $rv = true;                
            }
        break;
        case 10: // Gamma 3 - Cardassia
            if($race == 3 && $rank == 3 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 20;
                $formation[$rank][2] = 50;
                $formation[$rank][3] = 30;
                $rv = true;                
            }
        break;
        case 11: // Gamma 4 - Cardassia
            if($race == 3 && $rank == 4 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 20;
                $formation[$rank][2] = 45;
                $formation[$rank][3] = 35;
                $rv = true;                
            }
        break;
        case 12: // Gamma 5 - Dominion
            if($race == 4 && $rank == 2 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 70;
                $formation[$rank][3] = 30;
                $rv = true;
            }
        break;
        case 13: // Gamma 6 - Dominion
            if($race == 4 && $rank == 3 && $racial3) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 60;
                $formation[$rank][3] = 40;
                $rv = true;
            }
        break;
        case 14: // Alfa Beta 1 - Ferengi
            if($race == 5 && $rank == 1 && $racial1) {
                $formation[$rank][0] = 5;
                $formation[$rank][1] = 85;
                $formation[$rank][2] = 15;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 15: // Alfa Beta 2 - Ferengi
            if($race == 5 && $rank == 2 && $racial1) {
                $formation[$rank][0] = 5;
                $formation[$rank][1] = 75;
                $formation[$rank][2] = 20;
                $formation[$rank][3] = 5;
                $rv = true;
            }
        break;
        case 16: // Alfa Beta 3 - Ferengi
            if($race == 5 && ($rank == 3 || $rank == 4) && $racial1) {
                $formation[$rank][0] = 5;
                $formation[$rank][1] = 60;
                $formation[$rank][2] = 30;
                $formation[$rank][3] = 10;
                $rv = true;
            }
        break;
        case 17: // Beta 3 - Breen
            if($race == 8 && $rank == 1 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 100;
                $formation[$rank][2] = 0;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 18: // Beta 4 - Breen
            if($race == 8 && $rank == 2 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 80;
                $formation[$rank][2] = 20;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 19: // Delta 1 - Hirogeni
            if($race == 9 && $rank == 1 && $racial0) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 0;
                $formation[$rank][2] = 0;
                $formation[$rank][3] = 100;
                $rv = true;
            }
        break;
        case 20: // Delta 2 - Kazon
            if($race == 11 && $rank == 1 && $racial1) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 70;
                $formation[$rank][2] = 30;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        case 21: // Delta 3 - Kazon
            if($race == 11 && $rank == 2 && $racial1) {
                $formation[$rank][0] = 0;
                $formation[$rank][1] = 60;
                $formation[$rank][2] = 40;
                $formation[$rank][3] = 0;
                $rv = true;
            }
        break;
        default:
            message(NOTICE, 'Formazione non trovata');
        break;

    }
    return $rv;
}

function formation_list($rank, $race, $racial0, $racial1, $racial2)
{
    $list_string = '';

    if($race == 0 && $rank == 1 && $racial0) {
        $list_string .= '<option value=4>Alfa 4: Civ: 0&#37; 1: 50&#37; 2: 30&#37; 3: 20&#37; </option>';
    }
    if($race == 1 && $rank == 1 && $racial0) {
        $list_string .= '<option value=5>Beta 1: Civ: 0&#37; 1: 60&#37; 2: 40&#37; 3: 0&#37; </option>';
    }
    if($race == 1 && $rank == 2 && $racial0) {
        $list_string .= '<option value=6>Beta 2: Civ: 0&#37; 1: 0&#37; 2: 70&#37; 3: 30&#37; </option>';
    }            
    if($race == 2 && $rank == 2 && $racial0) {
        $list_string .= '<option value=7>Alfa 5: Civ: 0&#37; 1: 80&#37; 2: 20&#37; 3: 0&#37; </option>';
    }
    if($race == 3 && $rank == 1 && $racial0) {
        $list_string .= '<option value=8>Gamma 1: Civ: 0&#37; 1: 0&#37; 2: 85&#37; 3: 15&#37; </option>';
    }                       
    if($race == 3 && $rank == 2 && $racial0) {
        $list_string .= '<option value=9>Gamma 2: Civ: 0&#37; 1: 0&#37; 2: 75&#37; 3: 25&#37; </option>';
    }
    if($race == 3 && $rank == 3 && $racial0) {
        $list_string .= '<option value=10>Gamma 3: Civ: 0&#37; 1: 20&#37; 2: 50&#37; 3: 30&#37; </option>';
    }
    if($race == 3 && $rank == 4 && $racial0) {
        $list_string .= '<option value=11>Gamma 4: Civ: 0&#37; 1: 20&#37; 2: 45&#37; 3: 35&#37; </option>';
    }
    if($race == 4 && $rank == 2 && $racial0) {
        $list_string .= '<option value=12>Gamma 5: Civ: 0&#37; 1: 0&#37; 2: 70&#37; 3: 30&#37; </option>';
    }
    if($race == 4 && $rank == 3 && $racial3) {
        $list_string .= '<option value=13>Gamma 6: Civ: 0&#37; 1: 0&#37; 2: 60&#37; 3: 40&#37; </option>';
    }
    if($race == 5 && $rank == 1 && $racial1) {
        $list_string .= '<option value=14>Alfa Beta 1: Civ: 5&#37; 1: 85&#37; 2: 15&#37; 3: 0&#37; </option>';
    }
    if($race == 5 && $rank == 2 && $racial1) {
        $list_string .= '<option value=15>Alfa Beta 2: Civ: 5&#37; 1: 75&#37; 2: 20&#37; 3: 5&#37; </option>';
    }
    if($race == 5 && ($rank == 3 || $rank == 4) && $racial1) {
        $list_string .= '<option value=16>Alfa Beta 3: Civ: 5&#37; 1: 60&#37; 2: 30&#37; 3: 10&#37; </option>';
    }
    if($race == 8 && $rank == 1 && $racial0) {
        $list_string .= '<option value=17>Beta 3: Civ: 0&#37; 1: 100&#37; 2: 0&#37; 3: 0&#37; </option>';
    }
    if($race == 8 && $rank == 2 && $racial0) {
        $list_string .= '<option value=18>Beta 4: Civ: 0&#37; 1: 80&#37; 2: 20&#37; 3: 0&#37; </option>';
    }
    if($race == 9 && $rank == 1 && $racial0) {
        $list_string .= '<option value=19>Delta 1: Civ: 0&#37; 1: 0&#37; 2: 0&#37; 3: 100&#37; </option>';
    }
    if($race == 11 && $rank == 1 && $racial1) {
        $list_string .= '<option value=20>Delta 2: Civ: 0&#37; 1: 70&#37; 2: 30&#37; 3: 0&#37; </option>';
    }
    if($race == 11 && $rank == 2 && $racial1) {
        $list_string .= '<option value=21>Delta 3: Civ: 0&#37; 1: 60&#37; 2: 40&#37; 3: 0&#37; </option>';
    }

    return $list_string;
}

function officers_xp_next_level($rank, &$level, $xp)
{
    global $xpbase, $xpexp;
    
    switch($rank){
        case 1:
        case 2:
        case 3:            
            do {
                
                if($level >= 10) {
                    // Epic levels!!!
                    $xp_next_level = ($xpbase[$rank]*$level)+(pow(($level-1), 2)*$xpexp[$rank]);
                }
                else if($level > 0 && $level < 10) {
                    // Standard levels!!!
                    $xp_next_level = ($xpbase[$rank]*($level+1));                    
                } 
                else {
                    $xp_next_level = $xpbase[$rank];
                }
                               
                if($xp > $xp_next_level) {$level++;}
                
            }
            while($xp > $xp_next_level);            
            break;

        case 4:
            do {
                if($level > 0) {
                    $xp_next_level = ($xpbase[$rank]*$level)+(pow(($level-1), 2)*$xpexp[$rank]);
                }
                else {
                    $xp_next_level = $xpbase[$rank];
                }
                
                if($xp > $xp_next_level) {$level++;}
                
            }
            while($xp > $xp_next_level);
            
            break;
    }
    
    return $xp_next_level;
}

function officers_cap($type, $item, $race) {
    $value = 0;
    
    switch($type) {
        case 0:
            // Racial
            switch ($race) {
                case 0:
                    // Fed
                    switch($item) {
                        case 0:
                            $value = 2500;
                            break;
                        case 1:
                            $value = 3000;
                            break;
                        case 2:
                            $value = 5000;
                            break;
                    }
                    break;                    
                case 1:
                    // Romulan
                    switch($item) {
                        case 0:
                            $value = 1500;
                            break;
                        case 1:
                            $value = 3000;
                            break;
                        case 2:
                            $value = 3000;
                            break;
                    }
                    break;
                case 2:
                    // Klingon
                    switch($item) {
                        case 0:
                            $value = 2500;
                            break;
                        case 1:
                            $value = 3000;
                            break;
                        case 2:
                            $value = 3000;
                            break;
                    }
                    break;
                case 3:
                    // Cardassian
                    switch($item) {
                        case 0:
                            $value = 1500;
                            break;
                        case 1:
                            $value = 3500;
                            break;
                        case 2:
                            $value = 3500;
                            break;
                    }
                    break;
                case 4:
                    // Dominion
                    switch($item) {
                        case 0:
                            $value = 4750;
                            break;
                        case 1:
                            $value = 3500;
                            break;
                        case 2:
                            $value = 8500;
                            break;
                    }
                    break;
                case 5:
                    // Ferengi
                    switch($item) {
                        case 0:
                            $value = 2000;
                            break;
                        case 1:
                            $value = 2000;
                            break;
                        case 2:
                            $value = 4500;
                            break;
                    }
                    break;                
                case 8:
                    // Breen
                    switch ($item) {
                    case 0:
                        $value = 3000;
                        break;
                    case 1:
                        $value = 3000;
                        break;
                    case 2:
                        $value = 4500;
                        break;
                    }
                    break;
                case 9:
                    // Hirogeni
                    switch ($item) {
                    case 0:
                        $value = 2500;
                        break;
                    case 1:
                        $value = 3000;
                        break;
                    case 2:
                        $value = 6000;
                        break;
                    }
                    break;                
                case 11:
                    // Kazon
                    switch($item){
                        case 0:
                            $value = 2000;
                            break;
                        case 1:
                            $value = 1500;
                            break;
                        case 2:
                            $value = 3000;
                            break;
                    }
                    break;
            }
            break;
        case 1:
            switch($item) {
            case 0:
                $value = 7500;
                break;
            case 1:
                $value = 15000;
                break;
            case 2:
                $value = 15000;
                break;
            case 3:
                $value = 30000;
                break;
            }            
            break;
                            
    }
    
    return $value;
}

function officers_txt($type, $item, $race) {
    global $game;
    
    switch ($type) {
        case 0:
            // Racial
            switch ($race) {
            case 0:
                // Fed
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_0_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_0_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_0_2"));
                    break;
                }
                break;            
            case 1:
                // Romulan
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_1_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_1_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_1_2"));
                    break;
                }                
            case 2:
                // Klingon
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_2_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_2_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_2_2"));
                    break;
                }
                break;
            case 3:
                // Cardassian
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_3_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_3_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_3_2"));
                    break;
                }
                break;
            case 4:
                // Dominion
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_4_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_4_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_4_2"));
                    break;
                }
                break;            
            case 5:
                // Ferengi
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_5_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_5_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_5_2"));
                    break;
                }
                break;            
            case 8:
                // Breen
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_8_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_8_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_8_2"));
                    break;
                }
                break;
            case 9:
                // Hirogeni
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_9_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_9_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_9_2"));
                    break;
                }
                break;            
            case 11:
                // Kazon
                switch ($item) {
                case 0:
                    $txt = constant($game->sprache("TEXT90_11_0"));
                    break;
                case 1:
                    $txt = constant($game->sprache("TEXT90_11_1"));
                    break;
                case 2:
                    $txt = constant($game->sprache("TEXT90_11_2"));
                    break;
                }
                break;
            }
        break;
        case 1:
            switch($item) {
            case 0:
                $txt = constant($game->sprache("TEXT91_0"));
                break;
            case 1:
                $txt = constant($game->sprache("TEXT91_1"));
                break;
            case 2:
                $txt = constant($game->sprache("TEXT91_2"));
                break;
            case 3:
                $txt = constant($game->sprache("TEXT91_3"));
                break;
            }
        break;      
    }
    
    return $txt;
}

function officers_tooltip ($type, $item, $race, $exp) {
    
    global $game;
 
    $caption = officers_txt($type, $item, $race);
    
    if($type == 0) {
        $flavor = constant($game->sprache("TEXT100_".$race."_".$item)).'<br><br>';
    }
    else if($type == 1) {
        $flavor = constant($game->sprache("TEXT101_".$item)).'<br><br>';
    }
    
    $lvl = '('.$exp.'/'.officers_cap($type, $item, $race).')';
    
    $desc = $flavor.$lvl;
    
    $string = 'onmouseover="return overlib(\''.$desc.'\',CAPTION, \''.$caption.'\',WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"';
    
    return $string;
}

global $RACE_DATA, $SETL_EVENTS, $TECH_NAME, $ACTUAL_TICK, $cfg_data;

$max_slots = 5;

$optimal = array (80,380,880,0);

$xpdata = array (
    1=> array(63,125,188,250,313,375,438,500,563,625),
    2=> array(250,500,750,1000,1250,1500,1750,2000,2250,2500),
    3=> array(750,1500,2300,3150,4050,5000,6000,7050,8150,9300),
    4=> array(1500,3000,4875,7125,9750,12750,16125,19875,24000,28500),
);

$xpbase = array (
    1 => 185,
    2 => 375,
    3 => 750,
    4 => 1500
);

$xpexp = array (
    1 => 4,
    2 => 6,
    3 => 8,
    4 => 165
);

$formation = array(
    1=> array(0,85,15,0),
    2=> array(0,75,20,5),
    3=> array(0,60,30,10),
    4=> array(0,60,30,10)
);

$game->init_player();

$op1 = filter_input(INPUT_POST, 'op1', FILTER_SANITIZE_NUMBER_INT);

$op2 = filter_input(INPUT_POST, 'op2', FILTER_SANITIZE_NUMBER_INT);

$op3 = filter_input(INPUT_POST, 'op3', FILTER_SANITIZE_STRING);

if((isset($op1) && !empty($op1)) && (isset($op2) && !empty($op2))) {
        
    switch ($op1) {
        case 1:
            if($officer = $db->queryrow('SELECT officer_rank, officer_level, officer_xp, officer_race, racial_0, racial_1, racial_2 FROM officers WHERE id = '.$op2.' AND user_id = '.$game->player['user_id'])) {

                if($officer['officer_rank'] == 4) continue; // Max rank attained, we go out
                
                switch ($officer['officer_rank']) {
                    case 1:
                        $new_rank = 2;
                        $new_level = 0;
                        $new_xp_next_level = officers_xp_next_level($new_rank, $new_level, $officer['officer_xp']);
                        /*
                        if($officer['officer_xp'] < $xpdata[2][0]) { } // do nothing
                        else if($officer['officer_xp'] >= $xpdata[2][9]) $new_level = 10;
                        else if($officer['officer_xp'] >= $xpdata[2][8]) $new_level = 9;
                        else if($officer['officer_xp'] >= $xpdata[2][7]) $new_level = 8;
                        else if($officer['officer_xp'] >= $xpdata[2][6]) $new_level = 7;
                        else if($officer['officer_xp'] >= $xpdata[2][5]) $new_level = 6;
                        else if($officer['officer_xp'] >= $xpdata[2][4]) $new_level = 5;
                        else if($officer['officer_xp'] >= $xpdata[2][3]) $new_level = 4;
                        else if($officer['officer_xp'] >= $xpdata[2][2]) $new_level = 3;            
                        else if($officer['officer_xp'] >= $xpdata[2][1]) $new_level = 2;            
                        else if($officer['officer_xp'] >= $xpdata[2][0]) $new_level = 1;                        
                        else $new_level = 0;
                         * 
                         */
                        break;
                    case 2:
                        $new_rank = 3;
                        $new_level = 0;
                        $new_xp_next_level = officers_xp_next_level($new_rank, $new_level, $officer['officer_xp']);
                        /*
                        if($officer['officer_xp'] < $xpdata[3][0]) { } // do nothing
                        else if($officer['officer_xp'] >= $xpdata[3][9]) $new_level = 10;
                        else if($officer['officer_xp'] >= $xpdata[3][8]) $new_level = 9;
                        else if($officer['officer_xp'] >= $xpdata[3][7]) $new_level = 8;
                        else if($officer['officer_xp'] >= $xpdata[3][6]) $new_level = 7;
                        else if($officer['officer_xp'] >= $xpdata[3][5]) $new_level = 6;
                        else if($officer['officer_xp'] >= $xpdata[3][4]) $new_level = 5;
                        else if($officer['officer_xp'] >= $xpdata[3][3]) $new_level = 4;
                        else if($officer['officer_xp'] >= $xpdata[3][2]) $new_level = 3;            
                        else if($officer['officer_xp'] >= $xpdata[3][1]) $new_level = 2;            
                        else if($officer['officer_xp'] >= $xpdata[3][0]) $new_level = 1;                        
                        else $new_level = 0;                        
                         * 
                         */
                        break;
                    case 3:
                        $new_rank = 4;
                        $new_level = 0;
                        $new_xp_next_level = officers_xp_next_level($new_rank, $new_level, $officer['officer_xp']);
                        /*
                        if($officer['officer_xp'] < $xpdata[4][0]) { } // do nothing
                        else if($officer['officer_xp'] >= $xpdata[4][9]) $new_level = 10;
                        else if($officer['officer_xp'] >= $xpdata[4][8]) $new_level = 9;
                        else if($officer['officer_xp'] >= $xpdata[4][7]) $new_level = 8;
                        else if($officer['officer_xp'] >= $xpdata[4][6]) $new_level = 7;
                        else if($officer['officer_xp'] >= $xpdata[4][5]) $new_level = 6;
                        else if($officer['officer_xp'] >= $xpdata[4][4]) $new_level = 5;
                        else if($officer['officer_xp'] >= $xpdata[4][3]) $new_level = 4;
                        else if($officer['officer_xp'] >= $xpdata[4][2]) $new_level = 3;            
                        else if($officer['officer_xp'] >= $xpdata[4][1]) $new_level = 2;            
                        else if($officer['officer_xp'] >= $xpdata[4][0]) $new_level = 1;                        
                        else $new_level = 0;                        
                         * 
                         */
                        break;
                    default :
                        break;
                }

                for ($i=0; $i<3; $i++) {
                        if($officer['racial_'.$i] == 1) {officers_adapt_formation($officer['officer_race'], $new_rank, $i, $formation[$new_rank], $optimal[$new_rank - 1]);}
                }
                        
                $sql='UPDATE officers SET officer_rank = '.$new_rank.',
                                          officer_level = '.$new_level.',
                                          officer_xp_next_level = '.$new_xp_next_level.',    
                                          optimal = '.$optimal[$new_rank - 1].', 
                                          optm_class_0 = '.$formation[$new_rank][0].',
                                          optm_class_1 = '.$formation[$new_rank][1].',
                                          optm_class_2 = '.$formation[$new_rank][2].',
                                          optm_class_3 = '.$formation[$new_rank][3].'                                              
                                      WHERE id = '.$op2.' AND user_id = '.$game->player['user_id'];

                $db->query($sql);                    

            }                

            break;
        case 2:
            $sql='INSERT INTO officers SET user_id = '.$game->player['user_id'].', 
                                           timestamp = '.time().', 
                                           officer_name = "'.$op3.'",
                                           officer_xp_next_level = '.$xpbase[1].',
                                           optimal = '.$optimal[0].', 
                                           optm_class_0 = '.$formation[1][0].',
                                           optm_class_1 = '.$formation[1][1].',
                                           optm_class_2 = '.$formation[1][2].',
                                           optm_class_3 = '.$formation[1][3].',
                                           officer_race = '.$game->player['user_race'];
            $db->query($sql);                    
            break;
        case 3:
            if($officer = $db->queryrow('SELECT officer_rank, officer_level, officer_race, racial_0, racial_1, racial_2 FROM officers WHERE id = '.$op2.' AND user_id = '.$game->player['user_id']))
            {
                if(change_formation($op3, $officer['officer_rank'], $officer['officer_race'], $officer['racial_0'], $officer['racial_1'], $officer['racial_2'], $formation)){
                    $sql = 'UPDATE officers SET optm_class_0 = '.$formation[$officer['officer_rank']][0].',
                                                      optm_class_1 = '.$formation[$officer['officer_rank']][1].',
                                                      optm_class_2 = '.$formation[$officer['officer_rank']][2].',
                                                      optm_class_3 = '.$formation[$officer['officer_rank']][3].'
                            WHERE id = '.$op2.' AND user_id = '.$game->player['user_id'];
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Non riesco ad aggiornare la formazione');
                    }                                        
                }
                else{
                    message(GENERAL, 'Non riesco ad aggiornare la formazione');
                }

            }
            break;
        default :
            break;
    }
}

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');

$sql = 'SELECT o.*, 
               sf.fleet_id, sf.planet_id, sf.fleet_name, sf.n_ships,
               p.sector_id, p.system_id, p.planet_distance_id,
               ss.system_x, ss.system_y 
        FROM officers o 
        LEFT JOIN (ship_fleets sf) ON o.fleet_id = sf.fleet_id 
        LEFT JOIN (planets p) ON sf.planet_id = p.planet_id
        LEFT JOIN (starsystems ss) on p.system_id = ss.system_id
        WHERE o.user_id = '.$game->player['user_id'].' LIMIT 0,'.$max_slots;

$rank_string = array (constant($game->sprache("TEXT3")), constant($game->sprache("TEXT4")), constant($game->sprache("TEXT5")), constant($game->sprache("TEXT6")));

$off_data = $db->queryrowset($sql);

$used_slots = $db->num_rows();

foreach ($off_data as $i => $off_item) {
    $string_list .= '<fieldset><legend><span class="sub_caption2">Slot # '.($i+1).'</span></legend><div style="position:relative; float:left; width:100%;">'; // DIV header
    $string_list .= '<div style="position:relative; float:left; width:100px; border: 1px solid;">
                     <img src="'.$game->PLAIN_GFX_PATH.'officer_'.$off_item['officer_race'].'.gif" alt="faccione" height="140" width="100">
                     <br><br>
                     <form method="post" action="'.parse_link('a=officers').'">
                     <input type="hidden" name="op1" value=1>
                     <input type="hidden" name="op2" value='.$off_item['id'].'>
                     <center><input class="button_nosize" type="submit" onmouseover="return overlib(\''.constant($game->sprache("TEXT1")).'\', CAPTION, \''.constant($game->sprache("TEXT2")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();" onClick="return confirm(\''.constant($game->sprache("TEXT14")).'\')" style="width: 100px;" name="promote" value="'.constant($game->sprache("TEXT2")).'" '.($off_item['officer_rank'] == 4 ? 'disabled="disabled"' : '').'></center>
                     </form>
                     <br>
                     </div>'; // Officer Pic
    $string_list .= '<div style="position:relative; float:left; width:160px; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td width=30>'.constant($game->sprache("TEXT7b")).':</td>
                        <td>'.$off_item['officer_name'].'</td>
                    </tr>
                    <tr>
                        <td width=30>'.constant($game->sprache("TEXT7")).':</td>
                        <td><img onmouseover="return overlib(\''.$rank_string[$off_item['officer_rank'] - 1].'\', CAPTION, \''.constant($game->sprache("TEXT7")).'\', WIDTH, 150, '.OVERLIB_STANDARD.');" onmouseout="return nd();" src="'.$game->PLAIN_GFX_PATH.'officer_rank_'.$off_item['officer_rank'].'.png" alt="rank" height="20" width="20"></td>                        
                    </tr>
                    <tr>
                        <td width=30>'.constant($game->sprache("TEXT7c")).':</td>
                        <td><b>'.$off_item['officer_level'].'</b>   (Exp:'.$off_item['officer_xp'].' / '.$off_item['officer_xp_next_level'].')</td>                        
                    </tr>                    
                    </table>
                    <table width=100% style="border-top-style: dotted; border-top-width: 1px">';
    // Skill Razziali
    for($i=0;$i<3;$i++) {
        if(isset($off_item['racial_'.$i]) && $off_item['racial_'.$i]) {
            $string_list .= '<tr><td align=left><p '.officers_tooltip(0, $i, $off_item['officer_race'], $off_item['racial_xp_'.$i]).'><b>'.(officers_txt(0, $i, $off_item['officer_race'])).'</b></td></tr>';
        }
        elseif(isset($off_item['racial_'.$i]) && !$off_item['racial_'.$i]){
            $string_list .= '<tr><td align=left><p '.officers_tooltip(0, $i, $off_item['officer_race'], $off_item['racial_xp_'.$i]).'>'.(officers_txt(0, $i, $off_item['officer_race'])).'</td></tr>';
        }
    }
    // Skill Generiche
    for($i=0;$i<4;$i++){
        if(isset($off_item['skill_'.$i]) && $off_item['skill_'.$i]) {
            $string_list .= '<tr><td align=left><p '.officers_tooltip(1, $i, $off_item['officer_race'], $off_item['skill_xp_'.$i]).'><b>'.(officers_txt(1, $i, $off_item['officer_race'])).'</b></td></tr>';
        }
        elseif(isset($off_item['skill_'.$i]) && !$off_item['skill_'.$i]){
            $string_list .= '<tr><td align=left><p '.officers_tooltip(1, $i, $off_item['officer_race'], $off_item['skill_xp_'.$i]).'>'.(officers_txt(1, $i, $off_item['officer_race'])).'</td></tr>';
        }        
    }    

    $string_list .= '</table></div>';
    $string_list .= '<div style="position:relative; float:right; width:297px; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td>'.constant($game->sprache("TEXT15")).'</td><td width=40px align=right>'.$off_item['battle_victory'].'</td>
                        <td>'.constant($game->sprache("TEXT16")).'</td><td width=40px align=right>'.$off_item['battle_defeat'].'</td>                    
                    <tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=50px>'.constant($game->sprache("TEXT17")).' 1:</td>
                        <td>'.constant($game->sprache("TEXT18")).'</td><td width=50px align=right>'.$off_item['kill_class_1'].'</td>                                            
                        <td>'.constant($game->sprache("TEXT19")).'</td><td width=50px align=right>'.$off_item['lost_class_1'].'</td>
                    </tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td width=50px>'.constant($game->sprache("TEXT17")).' 2:</td>
                        <td>'.constant($game->sprache("TEXT18")).'</td><td width=50px align=right>'.$off_item['kill_class_2'].'</td>                                            
                        <td>'.constant($game->sprache("TEXT19")).'</td><td width=50px align=right>'.$off_item['lost_class_2'].'</td>
                    </tr>
                    </table>                    
                    <table width=100%>
                    <tr>
                        <td width=50px>'.constant($game->sprache("TEXT17")).' 3:</td>                    
                        <td>'.constant($game->sprache("TEXT18")).'</td><td width=50px align=right>'.$off_item['kill_class_3'].'</td>                                            
                        <td>'.constant($game->sprache("TEXT19")).'</td><td width=50px align=right>'.$off_item['lost_class_3'].'</td>
                    </tr>
                    </table>
                    <table width=100%>
                    <tr>
                        <td onmouseover="return overlib(\''.constant($game->sprache("TEXT10")).'\', CAPTION, \''.constant($game->sprache("TEXT11")).'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();" width=35px>'.constant($game->sprache("TEXT11")).':</td>
                        <td width=65px align=right><b>'.($off_item['optimal'] != 0 ? $off_item['optimal'] : '&infin;').'</b></td>
                        <td onmouseover="return overlib(\''.constant($game->sprache("TEXT13")).'\', CAPTION, \''.constant($game->sprache("TEXT12")).'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();" width=30px>Optm:</td>
                        <td width=36px><b>Civ:</b>'.$off_item['optm_class_0'].'&#37;</td>
                        <td width=36px><b>1:</b>'.$off_item['optm_class_1'].'&#37;</td>
                        <td width=36px><b>2:</b>'.$off_item['optm_class_2'].'&#37;</td>
                        <td width=36px><b>3:</b>'.$off_item['optm_class_3'].'&#37;</td>
                    </tr>
                    <tr>
                    </tr>
                    </table>
                    </div>';
    $string_list .= '<div style="position:relative; float:right; width:297px; border: 1px solid;">
                    <table width=100%>
                    <tr>
                        <td width=100% align=center>
                        <form method="post" action="'.parse_link('a=officers').'">
                        <input type="hidden" name="op1" value=3>
                        <input type="hidden" name="op2" value='.$off_item['id'].'>
                        <select name="op3">
                            <option value=0 selected>Selezionare una formazione...</option>
                            <option value=1>Alfa 1: Civ: '.$formation[1][0].'&#37; 1: '.$formation[1][1].'&#37; 2: '.$formation[1][2].'&#37; 3: '.$formation[1][3].'&#37; </option>
                            <option value=2>Alfa 2: Civ: '.$formation[2][0].'&#37; 1: '.$formation[2][1].'&#37; 2: '.$formation[2][2].'&#37; 3: '.$formation[2][3].'&#37; </option>
                            <option value=3>Alfa 3: Civ: '.$formation[3][0].'&#37; 1: '.$formation[3][1].'&#37; 2: '.$formation[3][2].'&#37; 3: '.$formation[3][3].'&#37; </option>
                            '.(formation_list($off_item['officer_rank'], $off_item['officer_race'], $off_item['racial_0'], $off_item['racial_1'], $off_item['racial_2'])).'
                        </select>
                        <br><br>
                        <center><input class="button_nosize" type="submit" style="width: 140px;" name="update_formation" value="'.constant($game->sprache("TEXT20")).'"></center>                        
                        </form>
                        </td>
                    </tr>
                    </table>
                     </div>';
    $string_list .= '</div>'; // DIV footer
    $string_list .= '<div style="position:relative; clear:both; width:100%; border:1px solid;">'; // bottom DIV
    if(isset($off_item['fleet_id']) && !empty($off_item['fleet_id'])) {
        $string_list .= '<br><center>Flotta assegnata: <a '.( empty($off_item['planet_id']) ? 'href="'.parse_link('a=ship_fleets_display&mfleet_details='.$off_item['fleet_id']).'"' : 'href="'.parse_link('a=ship_fleets_display&pfleet_details='.$off_item['fleet_id']).'"' ).'>'.$off_item['fleet_name'].'</a> ['.$off_item['n_ships'].' navi]'.( (!empty($off_item['planet_id'])) ? ' - ['.$game->fast_link_string($off_item['sector_id'], encode_system_id($off_item['system_id']), $off_item['system_x'], $off_item['system_y'], encode_planet_id($off_item['planet_id']), $off_item['planet_distance_id']).']' : '').'</center><br>';
    }
    else {
        $string_list .= '<br><center>Flotta assegnata: <i>nessuna</i></center><br>';
    }
    $string_list .= '</div></fieldset>'; // bottom DIV footer

}

if($max_slots > $used_slots){
    $string_list .= '<fieldset><legend><span class="sub_caption2">Slot # '.($used_slots + 1).'</span></legend><div style="position:relative; width:100%;">'; // DIV header
    $string_list .= '<br><br>';
    $string_list .= '<form method="post" action="'.parse_link('a=officers').'"><center>
                     <input type="hidden" name="op1" value=2>
                     <input type="hidden" name="op2" value=777>
                     '.constant($game->sprache("TEXT8")).'<input type="text" class="field" style="width: 150px;" name="op3"> <input class="button" style="width: 70px;" type="submit" name="enlist" value="'.constant($game->sprache("TEXT9")).'">
                     </center></form>';
    $string_list .= '<br><br>';
    $string_list .= '</div>'; // DIV footer
}


$game->out('
    <table class="style_outer" width="100%" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>
    <table class="style_inner" width="98%" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
        <td>'.$string_list.'</td>
    </tr>
    </table>
    </table>
    ');
?>
