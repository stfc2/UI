<?php
/*
    This file is part of STFC.it
    Copyright 2008-2013 by Andrea Carolfi (carolfi@stfc.it) and
    Cristiano Delogu (delogu@stfc.it).

	STFC.it is based on STFC,
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

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');


function GetBuildingPrice($building,$resource)
{
    global $game;
    global $RACE_DATA, $BUILDING_DATA, $PLANETS_DATA;

    $pow_factor=2;

    $price=round(pow($BUILDING_DATA[$building][$resource]*($game->planet['building_'.($building+1)]+1),$pow_factor),0);


    if ($building==9)
	    $price=$BUILDING_DATA[$building][$resource]/100*(100-2.5*$game->planet['research_3']);

    if ($building==12)
	    $price=$BUILDING_DATA[$building][$resource]/100*(100-2.5*$game->planet['research_3']);

    $price*=$RACE_DATA[$game->player['user_race']][5];
    $price*=$PLANETS_DATA[$game->planet['planet_type']][4];

    if($resource==0) {
        $price*=$RACE_DATA[$game->player['user_race']][23];
    }
    elseif($resource==1) {
        $price*=$RACE_DATA[$game->player['user_race']][24];
    }
    elseif($resource==2) {
        $price*=$RACE_DATA[$game->player['user_race']][25];
    }

    return round($price,0);
}

function GetFuturePts($q,$t)
{
	/*
	This function sum the structure points used on the planet and by the
	construction of the building, so that if it returns	a value of structure
	point higher of the amount available, the construction can not be started
	*/
	global $game;

	$_points = round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5));

	if ($q>0) {
		$_points_q = round(pow($game->planet['building_'.($q)]+1,1.5)-pow($game->planet['building_'.($q)],1.5));
	}

	$_total = $_points + $_points_q + $game->planet['planet_points'];

	return($_total); 

}

function GetBuildingTime($building)
{
    global $game;
    global $RACE_DATA, $BUILDING_DATA, $PLANETS_DATA;

    $time=($BUILDING_DATA[$building][3] + 3*pow($game->planet['building_'.($building+1)],$BUILDING_DATA[$building][4]));
    if ($building==9)
	    $time=$BUILDING_DATA[$building][3];
    if ($building==12)
	    $time=$BUILDING_DATA[$building][3];
    $time*=$RACE_DATA[$game->player['user_race']][1];
    $time/=100;
    $time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
    $time*=$PLANETS_DATA[$game->planet['planet_type']][5];
    $time=TICK_DURATION*round($time,0);

    return (Zeit($time));
}

function GetBuildingTimeTicks($building)
{
    global $game;
    global $RACE_DATA, $BUILDING_DATA, $PLANETS_DATA;

    $time=($BUILDING_DATA[$building][3] + 3*pow($game->planet['building_'.($building+1)],$BUILDING_DATA[$building][4]));
    if ($building==9)
	    $time=$BUILDING_DATA[$building][3];
    if ($building==12)
	    $time=$BUILDING_DATA[$building][3];
    $time*=$RACE_DATA[$game->player['user_race']][1];
    $time/=100;
    $time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
    $time*=$PLANETS_DATA[$game->planet['planet_type']][5];
    $time=round($time,0);

    return $time;
}

// Check if there is available power
// true = power overloaded
// false = power available
function isPowerOverloaded()
{
    global $game;

    // Calculate buildings energy consumption
    $buildings = $game->planet['building_1'] +
                 $game->planet['building_2'] + 
                 $game->planet['building_3'] + 
                 $game->planet['building_4'] + 
                 $game->planet['building_10'] + 
                 $game->planet['building_6'] + 
                 $game->planet['building_7'] + 
                 $game->planet['building_8'] +
                 $game->planet['building_9'] + 
                 $game->planet['building_11'] + 
                 $game->planet['building_12'] +
                 $game->planet['building_13'];

    // Check if the active planet is the user's capital
    if ($game->player['user_capital']==$game->planet['planet_id'])
        $available_power = $game->planet['building_5']*11+14;
    else
        $available_power = $game->planet['building_5']*15+3;

    return ($buildings >= $available_power);
}

// Check if requirements needed by the selected building are met
// true = all requirements present
// false = one or more requirements missing
function areRequirementsMet($building)
{
    global $game;

    $res = true;

    if (($building==11 && $game->planet['building_1']<4) ||
        ($building==10 && $game->planet['building_1']<3) ||
        ($building==6 && $game->planet['building_1']<5) ||
        ($building==8 && $game->planet['building_1']<9) ||
        ($building==7 && $game->planet['building_7']<1) ||
        ($building==9 && ($game->planet['building_6']<5 || $game->planet['building_7']<1)) ||
        ($building==12 && ($game->planet['building_6']<1 || $game->planet['building_7']<1)))
        $res = false;

    return ($res);
}



function Start_Queued()
{
    global $db,$game,$MAX_BUILDING_LVL,$ACTUAL_TICK;

    $toConstruct = (int)$_REQUEST['id'];

    $done=0;

    // Retrieve construction queue for the planet ordered by ascending time
    $sql = 'SELECT * FROM scheduler_instbuild
            WHERE planet_id="'.$game->planet['planet_id'].'"
            ORDER BY build_finish ASC';
    $schedulerquery=$db->queryrowset($sql);

    if ($db->num_rows()>0)
    {
        foreach ($schedulerquery as $scheduler) {
            // From now on consider the level of the buildings that are
            // currently under construction as if they were at the built level.
            $game->planet['building_'.($scheduler['installation_type']+1)]++;
        }
    }

    // Check if the active planet is the user's capital
    $capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
    if ($game->player['pending_capital_choice']) $capital=0;

    // Calculate the raw materials needed
    //
    // NOTE: this has to be done after loaded the queue because
    // GetBuildingPrice() function needs updated planet data
    $metNeeded = GetBuildingPrice($toConstruct,0);
    $minNeeded = GetBuildingPrice($toConstruct,1);
    $latNeeded = GetBuildingPrice($toConstruct,2);

    // Check if the planet has the resources needed
    // and the building hasn't reached maximum level
    if ($game->planet['resource_1']>=$metNeeded &&
        $game->planet['resource_2']>=$minNeeded &&
        $game->planet['resource_3']>=$latNeeded &&
        $game->planet['building_'.($toConstruct+1)]<$MAX_BUILDING_LVL[$capital][$toConstruct])
    {

        // Check if the planet matches the requirements needed
        if (areRequirementsMet($toConstruct))
        {
            // Check the required energy if we aren't building a power plant
            if ($toConstruct!=4 && isPowerOverloaded())
            {
                $game->out('<span class="text_large">'.constant($game->sprache("TEXT1")).'<br>'.constant($game->sprache("TEXT2")).'</span><br><span class="text_large">'.constant($game->sprache("TEXT6")).'</span><br>');
            }
            else
            {
                $sql = 'UPDATE planets SET resource_1=resource_1-'.$metNeeded.',
                                           resource_2=resource_2-'.$minNeeded.',
                                           resource_3=resource_3-'.$latNeeded.'
                        WHERE planet_id= "'.$game->planet['planet_id'].'"';
                if ($db->query($sql)==true)
                {
                    $game->planet['resource_1']-=$metNeeded;
                    $game->planet['resource_2']-=$minNeeded;
                    $game->planet['resource_3']-=$latNeeded;

                    // Calculate start/finish time for the queued building
                    $start_time = $scheduler['build_finish'];
                    $finish_time = $start_time + GetBuildingTimeTicks($toConstruct);

                    // Queue new construction in the scheduler
                    $sql = 'INSERT INTO scheduler_instbuild (installation_type,planet_id,build_start,build_finish)
                            VALUES ('.($toConstruct).',
                                    '.$game->planet['planet_id'].',
                                    '.$start_time.',
                                    '.$finish_time.')';
                    if ($db->query($sql)==false)
                    {
                        message(DATABASE_ERROR, 'building_query: Could not insert new queue in the scheduler');
                        exit();
                    }
                    $done=1;
                }
            }
        }
    }
    if ($done) redirect('a=building');
}




function Start_Build()
{
    global $db,$game,$MAX_BUILDING_LVL,$ACTUAL_TICK;

    $toConstruct = (int)$_REQUEST['id'];

    $done=0;

    // New: Table locking
    $game->init_player(11);

    // Calculate the raw materials needed
    $metNeeded = GetBuildingPrice($toConstruct,0);
    $minNeeded = GetBuildingPrice($toConstruct,1);
    $latNeeded = GetBuildingPrice($toConstruct,2);
   
    // Check if the active planet is the user's capital
    $capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
    if ($game->player['pending_capital_choice']) $capital=0;

    // Retrieve construction queue for the planet
    $userquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');

    // If queue max length
    if ($db->num_rows() == BUILDING_QUEUE_LEN) {
        $game->out('<span class="text_large">'.constant($game->sprache("TEXT3")).'</span><br>');
    }
    else if ($db->num_rows()>0) {
        Start_Queued();
    }
    else if ($game->planet['resource_1']>=$metNeeded &&
             $game->planet['resource_2']>=$minNeeded &&
             $game->planet['resource_3']>=$latNeeded &&
             $game->planet['building_'.($toConstruct+1)]<$MAX_BUILDING_LVL[$capital][$toConstruct])
    {
        // Check if the planet matches the requirements needed
        //
        // NOTE: maybe this is redundant since Show_Main() has already
        // built the list of available buildings performing this check
        if (areRequirementsMet($toConstruct))
        {
            // Check the required energy if we aren't building a power plant
            if ($toConstruct!=4 && isPowerOverloaded())
            {
                $game->out('<span class="text_large">'.constant($game->sprache("TEXT1")).'<br>'.constant($game->sprache("TEXT2")).'</span><br>');
            }
            else {
                // Remove required raw materials from the planet
                $sql = 'UPDATE planets SET resource_1=resource_1-'.$metNeeded.',
                                           resource_2=resource_2-'.$minNeeded.',
                                           resource_3=resource_3-'.$latNeeded.'
                        WHERE planet_id= "'.$game->planet['planet_id'].'"';

                if ($db->query($sql)==true)
                {
                    $game->planet['resource_1']-=$metNeeded;
                    $game->planet['resource_2']-=$minNeeded;
                    $game->planet['resource_3']-=$latNeeded;

                    // Calculate start/finish time for the building
                    $start_time = $ACTUAL_TICK;
                    $finish_time = $ACTUAL_TICK + GetBuildingTimeTicks($toConstruct);

                    // Insert new construction in the scheduler
                    $sql = 'INSERT INTO scheduler_instbuild (installation_type,planet_id,build_start,build_finish)
                            VALUES ('.($toConstruct).',
                                    '.$game->planet['planet_id'].',
                                    '.$start_time.',
                                    '.$finish_time.')';

                    if ($db->query($sql)==false) {
                        message(DATABASE_ERROR, 'building_query: Could not call INSERT INTO in scheduler_instbuild ');
                        exit();
                    }

                    $done=1;
                }
            }
        }
    }
    if ($done) redirect('a=building');
}




function Abort_Build()
{
    global $db,$game,$ACTUAL_TICK;

    $abort=0;

    $toAbort = (int)$_REQUEST['id'];

    // New: Click Ids
    $game->init_player(11);

    // Retrieve construction queue for the planet ordered by ascending time
    $sql = 'SELECT * FROM scheduler_instbuild
            WHERE planet_id="'.$game->planet['planet_id'].'"
            ORDER BY build_finish ASC';
    $schedulerquery=$db->queryrowset($sql);

    if (($num = $db->num_rows())<1) {
        $game->out('<class="text_large">'.constant($game->sprache("TEXT4")).'</span><br>');
    }
    else {
        $finish_time = 0;
        $id_to_remove = 0;

        foreach($schedulerquery as $id => $scheduler) {
            // From now on consider the level of the buildings that are
            // currently under construction as if they were at the built level.
            //$game->planet['building_'.($scheduler['installation_type']+1)]++;
        
            if($toAbort == $scheduler['installation_type']) {
                $finish_time = $scheduler['build_finish'];
                $id_to_remove = $id;
            }
        }

        // Remove from the queue the building (the last element found)
        // unset($schedulerquery[$id_to_remove]); <-- Damn'it! It doesn't update the key in the array...
        array_splice($schedulerquery,$id_to_remove,1);

        // If the building to remove is not the last one...
        if (($id_to_remove+1) < $num) {
            foreach($schedulerquery as $scheduler) {
                // Check if player wants to delete a building required by one queued
                if (!areRequirementsMet($scheduler['installation_type'])) {
                    $game->out('<span class="text_large">'.constant($game->sprache("TEXT5")).'</span><br>');
                    $abort=1;
                    break;
                }

                // Check if player wants to remove a power plant that it's needed by future buildings
                if ($toAbort == 4 && $scheduler['installation_type'] != 4 && isPowerOverloaded()) {
                    $game->out('<span class="text_large">'.constant($game->sprache("TEXT6")).'</span><br>');
                    $abort=1;
                    break;
                }
            }
        }

        // Do we have ok to proceed?
        if($abort==0) {
            $sql = 'DELETE FROM scheduler_instbuild
                    WHERE planet_id="'.$game->planet['planet_id'].'" AND
                          installation_type='.$toAbort.' AND
                          build_finish='.$finish_time;

            if (($db->query($sql))!=true) {
                $game->out('<span class="text_large">'.constant($game->sprache("TEXT7")).'<br>'.constant($game->sprache("TEXT8")).' (ID='.$game->planet['planet_id'].') '.constant($game->sprache("TEXT9")).'</span><br>');
                $abort=1;
            }
            else {            
                // Temporarily adjust building level by one if there was more
                // then one of the same type being built
                foreach($schedulerquery as $scheduler)
                    if($toAbort == $scheduler['installation_type']) {
                        $game->planet['building_'.($toAbort+1)]++;
                    }

                $sql = 'UPDATE planets SET resource_1=resource_1+'.(GetBuildingPrice($toAbort,0)).',
                                           resource_2=resource_2+'.(GetBuildingPrice($toAbort,1)).',
                                           resource_3=resource_3+'.(GetBuildingPrice($toAbort,2)).'
                        WHERE planet_id= "'.$game->planet['planet_id'].'"';
                $db->query($sql);

                // Update building times for queued buildings
                foreach($schedulerquery as $id => $scheduler) {
                    $doUpdate = false;

                    // Store initial building times
                    $start_time = $scheduler['build_start'];
                    $finish_time = $scheduler['build_finish'];
                    $constr_time = $finish_time - $start_time;

                    if ($id == 0 ) {
                        if ($scheduler['build_start'] > $ACTUAL_TICK) {
                            $scheduler['build_start'] = $ACTUAL_TICK;
                            $scheduler['build_finish'] = $scheduler['build_start'] + $constr_time;
                            $doUpdate = true;
                        }
                    }
                    else {
                        if ($scheduler['build_start'] != $old_scheduler['build_finish']) {
                            $scheduler['build_start'] = $old_scheduler['build_finish'];
                            $scheduler['build_finish'] = $scheduler['build_start'] + $constr_time;
                            $doUpdate = true;
                        }
                    }

                    // If we need to update the queue
                    if($doUpdate) {
                        $sql = 'UPDATE scheduler_instbuild
                                SET build_start  = '.$scheduler['build_start'].',
                                    build_finish = '.$scheduler['build_finish'].'
                                WHERE planet_id = "'.$game->planet['planet_id'].'" AND
                                      build_start = '.$start_time.' AND
                                      build_finish = '.$finish_time;

                        if ($db->query($sql)!=true) {
                            $game->out('<span class="text_large">CANNOT UPDATE BUILDING QUEUE!</span><br>');
                            $abort=1;
                            break;
                        }
                    }
                    
                    $old_scheduler = $scheduler;
                }
            }
        }
    } // endif: if there was some build in progress

    if($abort==0)redirect('a=building');
}




function Show_Main()
{
    global $db;
    global $game;
    global $NUM_BUILDING, $BUILDING_DESCRIPTION, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

    $capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
    if ($game->player['pending_capital_choice']) $capital=0;

    // Clickids:
    $game->register_click_id(11);

    // Future structure points calculation
    $future_building = 0;

    // Retrieve construction queue for the planet ordered by time
    $sql = 'SELECT * FROM scheduler_instbuild
            WHERE planet_id="'.$game->planet['planet_id'].'"
            ORDER by build_start ASC';
    $schedulerquery=$db->query($sql);
    if (($queued = $db->num_rows())>0)
    {
        // Timer ID
        $t=3;

        while($scheduler = $db->fetchrow($schedulerquery))
        {
            // From now on the level of the building is currently developed at the final stage:
            $game->planet['building_'.($scheduler['installation_type']+1)]++;

            $game->out('<table border=0 cellpadding=1 cellspacing=1 width=330 class="style_outer"><tr><td>
<table border=0 cellpadding=1 cellspacing=1 width=330 class="style_inner"><tr><td>
'.constant($game->sprache("TEXT11")).' <b>'.$BUILDING_NAME[$game->player['user_race']][$scheduler['installation_type']].' ('.constant($game->sprache("TEXT12")).' '.($game->planet['building_'.($scheduler['installation_type']+1)]).')</b><br>
'.constant($game->sprache("TEXT13")).'
<b id="timer'.$t.'" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['build_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=building&a2=abort_build&id='.$scheduler['installation_type'],LINK_CLICKID).'"><b>'.constant($game->sprache("TEXT14")).'</b></a>
</td></tr></table>
</td></tr></table><br>');

            // Prepare another timer
            $t++;

            $game->set_autorefresh(($NEXT_TICK+TICK_DURATION*60*($scheduler['build_finish']-$ACTUAL_TICK))+TICK_DURATION);

            // Future structure points calculation
            $future_building += $scheduler['installation_type']+1;
        }
    }

    // Calculate available energy power
    $avail=$game->planet['building_5']*11+14;
    if (!$capital) $avail=$game->planet['building_5']*15+3;

    // Calculate energy power consumption
    $used = $game->planet['building_1'] +
            $game->planet['building_2'] + 
            $game->planet['building_3'] + 
            $game->planet['building_4'] + 
            $game->planet['building_10'] + 
            $game->planet['building_6'] + 
            $game->planet['building_7'] + 
            $game->planet['building_8'] +
            $game->planet['building_9'] + 
            $game->planet['building_11'] + 
            $game->planet['building_12'] + 
            $game->planet['building_13'];

    $game->out(constant($game->sprache("TEXT16")).' <b id="timer2" title="time1_'.$NEXT_TICK.'_type1_3">&nbsp;</b> '.constant($game->sprache("TEXT17")).'<br>'.constant($game->sprache("TEXT18")).' '.$used.'/'.$avail.' '.constant($game->sprache("TEXT19")).'<br><br>');

    $game->out('<span class="sub_caption">'.constant($game->sprache(($queued ? "TEXT21":"TEXT20"))).' '.HelpPopup('building_1').' :</span><br><br>');

    $game->out('<table border=0 cellpadding=2 cellspacing=2 width=595 class="style_outer">
<tr><td width=595>
<table border=0 cellpadding=2 cellspacing=2 width=595 class="style_inner">
<tr>
    <td width=130><b>'.constant($game->sprache("TEXT29")).'</b></td>
    <td width=155><b>'.constant($game->sprache("TEXT22")).'</b></td>
    <td width=75><b>'.constant($game->sprache("TEXT23")).'</b></td>
    <td width=130><b>'.constant($game->sprache("TEXT24")).'</b></td>
</tr>');
    for ($tt=0; $tt<=$NUM_BUILDING; $tt++)
    {
        if ($tt>9) $t=$tt-1;
        else $t=$tt;
        if ($tt==9) $t=12;

        if (areRequirementsMet($t))
        {
            // Calculate required resources for next building level
            $met = GetBuildingPrice($t,0);
            $min = GetBuildingPrice($t,1);
            $lat = GetBuildingPrice($t,2);
            $fut = GetFuturePts($future_building,$t);

            // Calculate points gained for this building
            $points = round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5));

            if ($game->planet['resource_1']>=$met &&
                $game->planet['resource_2']>=$min &&
                $game->planet['resource_3']>=$lat &&
                $game->planet['planet_available_points']>=$fut)
            {
                $build_text='<a href="'.parse_link_ex('a=building&a2=start_build&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT25")).' (~'.$points.' '.constant($game->sprache("TEXT26")).')</span></a>';
                if ($game->planet['building_'.($t+1)]>0) $build_text='<a href="'.parse_link_ex('a=building&a2=start_build&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT27")).' '.($game->planet['building_'.($t+1)]+1).' (~'.$points.' '.constant($game->sprache("TEXT26")).')</span></a>';
            }
            else
            {
                $build_text='<span style="color: red">'.constant($game->sprache("TEXT25")).' (~'.$points.' '.constant($game->sprache("TEXT26")).')</span>';
                if ($game->planet['building_'.($t+1)]>0) $build_text='<span style="color: red">'.constant($game->sprache("TEXT27")).' '.($game->planet['building_'.($t+1)]+1).' (~'.$points.' '.constant($game->sprache("TEXT26")).')</span>';
            }

            // Check if building has reached maximum level
            if ($game->planet['building_'.($t+1)]>=$MAX_BUILDING_LVL[$capital][$t])
                $build_text=constant($game->sprache("TEXT28"));

            $game->out('
<tr>
    <td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.$BUILDING_DESCRIPTION[$game->player['user_race']][$t].'\', CAPTION, \''.$BUILDING_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$BUILDING_NAME[$game->player['user_race']][$t].'</b></td>
    <td><img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.$met.'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$min.'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$lat.'&nbsp; </td>
    <td>'.GetBuildingTime($t).'</td>
    <td>'.$build_text.'</td>
</tr>');
        }
    }

    $game->out('</table></td></tr></table>');
}









$sub_action = (!empty($_GET['a2'])) ? $_GET['a2'] : 'main';

if ($sub_action=='start_build')
{
    Start_Build(); $sub_action='main';
}
if ($sub_action=='abort_build')
{
    Abort_Build(); $sub_action='main';
}
if ($sub_action=='main')
{
    // Calculate percentage of required security troops on the planet
    $troops_perc = round(100*round($game->planet['unit_1'] * 2 +
                                   $game->planet['unit_2'] * 3 +
                                   $game->planet['unit_3'] * 4 +
                                   $game->planet['unit_4'] * 4, 0) /
                              $game->planet['min_troops_required']);

    if ($troops_perc>=70 || $game->planet['min_troops_required']==0)
        Show_Main();
    else
    {
        $game->out('<table border=0 cellpadding=1 cellspacing=1 width=450 class="style_outer"><tr><td>
<table border=0 cellpadding=1 cellspacing=1 width=450 class="style_inner"><tr><td>
<span class="text_large">'.constant($game->sprache("TEXT30")).' <b>'.$troops_perc.'%</b> '.constant($game->sprache("TEXT31")).'</span>
</td></tr>
</table>
</td></tr>
</table>');
    }
}


?>
