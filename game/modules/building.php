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

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');


if ($game->planet['building_queue']==0) unset($game->planet['building_queue']);

function GetBuildingPrice($building,$resource)
{
global $db;
global $game;
global $RACE_DATA, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK,$PLANETS_DATA;
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

function GetFuturePts($t)
{
	/*
	GetBuildingPts ritorna la somma dei punti struttura usati sul pianeta e dei punti struttura impiegati dalla costruzione della struttura,
	di modo che se GetBuildingPts torna un valore maggiore, la costruzione non può essere avviata
	*/
	global $db;
	global $game;

	$_points = round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5));

	$schedulerquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
	if ($db->num_rows()>0)
	{
		$scheduler = $db->fetchrow($schedulerquery);
		$q = $scheduler['installation_type']+1;
		$_points_q = round(pow($game->planet['building_'.($q)]+1,1.5)-pow($game->planet['building_'.($q)],1.5));
	}

	$_total = $_points + $_points_q + $game->planet['planet_points'];

	return($_total); 

}

function GetBuildingTime($building)
{
global $db;
global $game;
global $RACE_DATA, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK,$PLANETS_DATA;

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
global $db;
global $game;
global $RACE_DATA, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK,$PLANETS_DATA;

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



function Start_Queued()
{

global $db;
global $game;
global $NUM_BUILDING, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;
$_REQUEST['id']=(int)$_REQUEST['id'];

$schedulerquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
{
$scheduler = $db->fetchrow($schedulerquery);
// Von nun an steht das Level des momentan ausgebauten Gebäudes auf der endgültigen Stufe:
$game->planet['building_'.($scheduler['installation_type']+1)]++;
}

$done=0;

$capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
if ($game->player['pending_capital_choice']) $capital=0;


if ($game->planet['resource_1']>=GetBuildingPrice($_REQUEST['id'],0) && $game->planet['resource_2']>=GetBuildingPrice($_REQUEST['id'],1) && $game->planet['resource_3']>=GetBuildingPrice($_REQUEST['id'],2) && $game->planet['building_'.($_REQUEST['id']+1)]<$MAX_BUILDING_LVL[$capital][$_REQUEST['id']])
{
$buildings=$game->planet['building_1']+$game->planet['building_2']+$game->planet['building_3']+$game->planet['building_4']+$game->planet['building_10']+$game->planet['building_6']+$game->planet['building_7']+$game->planet['building_8']+$game->planet['building_9']+$game->planet['building_11']+$game->planet['building_12'];
$t=$_REQUEST['id'];
if (($t==11 && $game->planet['building_1']<4) || ($t==10 && $game->planet['building_1']<3) || ($t==6 && $game->planet['building_1']<5) || ($t==8 && $game->planet['building_1']<9) || ($t==7 && $game->planet['building_7']<1) || ($t==9 && ($game->planet['building_6']<5 || $game->planet['building_7']<1))  || ($t==12 && ($game->planet['building_6']<1 || $game->planet['building_7']<1))) {}
else
{
if ($_REQUEST['id']!=4 && $buildings>=($capital==true ? $game->planet['building_5']*11+14 : $game->planet['building_5']*15+3)) {$game->out('<span class="text_large">'.constant($game->sprache("TEXT1")).'<br>'.constant($game->sprache("TEXT2")).'</span><br><span class="text_large">'.constant($game->sprache("TEXT6")).'</span><br>');}
else
if ($db->query('UPDATE planets SET resource_1=resource_1-'.(GetBuildingPrice($_REQUEST['id'],0)).',resource_2=resource_2-'.(GetBuildingPrice($_REQUEST['id'],1)).',resource_3=resource_3-'.(GetBuildingPrice($_REQUEST['id'],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"')==true)
{
  $game->planet['resource_1']-=GetBuildingPrice($_REQUEST['id'],0);
  $game->planet['resource_2']-=GetBuildingPrice($_REQUEST['id'],1);
  $game->planet['resource_3']-=GetBuildingPrice($_REQUEST['id'],2);
  if ($db->query('UPDATE planets SET building_queue='.($t+1).'  WHERE planet_id= "'.$game->planet['planet_id'].'"')==false)  {message(DATABASE_ERROR, 'building_query: Could not call UPDATE in planets (building_queue)'); exit();}
	$done=1;
}
}
}
if ($done) redirect('a=building');
}




function Start_Build()
{
global $db;
global $game;
global $NUM_BUILDING, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;
$_REQUEST['id']=(int)$_REQUEST['id'];
// New: Table locking
$game->init_player(11);
if ($game->planet['building_queue']==0) unset($game->planet['building_queue']);

$done=0;

$capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
if ($game->player['pending_capital_choice']) $capital=0;


$userquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if (isset($game->planet['building_queue'])) {$game->out('<span class="text_large">'.constant($game->sprache("TEXT3")).'</span><br>');}
else if ($db->num_rows()>0) {Start_Queued();}
else if ($game->planet['resource_1']>=GetBuildingPrice($_REQUEST['id'],0) && $game->planet['resource_2']>=GetBuildingPrice($_REQUEST['id'],1) && $game->planet['resource_3']>=GetBuildingPrice($_REQUEST['id'],2) && $game->planet['building_'.($_REQUEST['id']+1)]<$MAX_BUILDING_LVL[$capital][$_REQUEST['id']])
{
$buildings=$game->planet['building_1']+$game->planet['building_2']+$game->planet['building_3']+$game->planet['building_4']+$game->planet['building_10']+$game->planet['building_6']+$game->planet['building_7']+$game->planet['building_8']+$game->planet['building_9']+$game->planet['building_11']+$game->planet['building_12']+$game->planet['building_13'];
$t=$_REQUEST['id'];
if (($t==11 && $game->planet['building_1']<4) || ($t==10 && $game->planet['building_1']<3) || ($t==6 && $game->planet['building_1']<5) || ($t==8 && $game->planet['building_1']<9) || ($t==7 && $game->planet['building_7']<1) || ($t==9 && ($game->planet['building_6']<5 || $game->planet['building_7']<1)) || ($t==12 && ($game->planet['building_6']<1 || $game->planet['building_7']<1)) ) {}
else
{
if ($_REQUEST['id']!=4 && $buildings>=($capital==true ? $game->planet['building_5']*11+14 : $game->planet['building_5']*15+3)) {$game->out('<span class="text_large">'.constant($game->sprache("TEXT1")).'<br>'.constant($game->sprache("TEXT2")).'</span><br>');}
else
if ($db->query('UPDATE planets SET resource_1=resource_1-'.(GetBuildingPrice($_REQUEST['id'],0)).',resource_2=resource_2-'.(GetBuildingPrice($_REQUEST['id'],1)).',resource_3=resource_3-'.(GetBuildingPrice($_REQUEST['id'],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"')==true)
{
  $game->planet['resource_1']-=GetBuildingPrice($_REQUEST['id'],0);
  $game->planet['resource_2']-=GetBuildingPrice($_REQUEST['id'],1);
  $game->planet['resource_3']-=GetBuildingPrice($_REQUEST['id'],2);
  if ($db->query('INSERT INTO scheduler_instbuild (installation_type,planet_id,build_finish)
  			VALUES ("'.($_REQUEST['id']).'","'.$game->planet['planet_id'].'","'.($ACTUAL_TICK+GetBuildingTimeTicks($_REQUEST['id'])).'")')==false)  {message(DATABASE_ERROR, 'building_query: Could not call INSERT INTO in scheduler_instbuild '); exit();}

	$done=1;
}
}
}
if ($done) redirect('a=building');
}




function Abort_Build()
{
global $db;
global $game;
global $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;
$abbruch=0;
// New: Click Ids
$game->init_player(11);
if ($game->planet['building_queue']==0) unset($game->planet['building_queue']);
$capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
$buildings=$game->planet['building_1']+$game->planet['building_2']+$game->planet['building_3']+$game->planet['building_4']+$game->planet['building_10']+$game->planet['building_6']+$game->planet['building_7']+$game->planet['building_8']+$game->planet['building_9']+$game->planet['building_11']+$game->planet['building_12']+$game->planet['building_13'];
$schedulerquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()<1) {$game->out('<class="text_large">'.constant($game->sprache("TEXT4")).'</span><br>');}
else
{
$scheduler = $db->fetchrow($schedulerquery);
if(isset($game->planet['building_queue']))
{
$t=$game->planet['building_queue']-1;
if (($t==11 && $game->planet['building_1']<4) || ($t==10 && $game->planet['building_1']<3) | ($t==6 && $game->planet['building_1']<5) || ($t==8 && $game->planet['building_1']<9) || ($t==7 && $game->planet['building_7']<1) || ($t==9 && ($game->planet['building_6']<5 || $game->planet['building_7']<1)) || ($t==12 && ($game->planet['building_6']<1 || $game->planet['building_7']<1)) ) {
$game->out('<span class="text_large">'.constant($game->sprache("TEXT5")).'</span><br>');
$abbruch=1;
}

if($scheduler['installation_type']==4 && $buildings>=($capital==true ? ($game->planet['building_5']-1)*11+14 : ($game->planet['building_5']-1)*15+3))
{
$game->out('<span class="text_large">'.constant($game->sprache("TEXT6")).'</span><br>');
$abbruch=1;
}
}
if($abbruch==0){
if (!isset($game->planet['building_queue']) || $game->planet['building_queue']-1!=$scheduler['installation_type'])
{
if (($db->query('DELETE FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1'))!=true) {$game->out('<span class="text_large">'.constant($game->sprache("TEXT7")).'<br>'.constant($game->sprache("TEXT8")).' (ID='.$game->planet['planet_id'].') '.constant($game->sprache("TEXT9")).'</span><br>');}
else
{
$db->query('UPDATE planets SET resource_1=resource_1+'.(GetBuildingPrice($scheduler['installation_type'],0)).',resource_2=resource_2+'.(GetBuildingPrice($scheduler['installation_type'],1)).',resource_3=resource_3+'.(GetBuildingPrice($scheduler['installation_type'],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"');
}
}

else if ($game->planet['building_queue']-1==$scheduler['installation_type'])// If the building in queue was the same but +1 lvl (we need to pay back some more)
{
	$game->planet['building_'.($scheduler['installation_type']+1)]++;
		if (($db->query('DELETE FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1'))!=true) {$game->out('<span class="text_large">'.constant($game->sprache("TEXT7")).'<br>'.constant($game->sprache("TEXT8")).' (ID='.$game->planet['planet_id'].') '.constant($game->sprache("TEXT9")).'</span><br>');}
		else
		{
		$db->query('UPDATE planets SET resource_1=resource_1+'.(GetBuildingPrice($scheduler['installation_type'],0)).',resource_2=resource_2+'.(GetBuildingPrice($scheduler['installation_type'],1)).',resource_3=resource_3+'.(GetBuildingPrice($scheduler['installation_type'],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"');
		}
}
}



// Last but not least check for a building in queue and add if neccessary
if (isset($game->planet['building_queue']) && $abbruch==0)
{
if ($db->query('UPDATE planets SET building_queue=0  WHERE planet_id= "'.$game->planet['planet_id'].'"')==false)  {message(DATABASE_ERROR, 'building_query: Could not call UPDATE in planets (building_queue)'); exit();}
if ($db->query('INSERT INTO scheduler_instbuild (installation_type,planet_id,build_finish) VALUES ("'.($game->planet['building_queue']-1).'","'.$game->planet['planet_id'].'","'.($ACTUAL_TICK+GetBuildingTimeTicks($game->planet['building_queue']-1)).'")')==false)  {message(DATABASE_ERROR, 'building_query: Could not call INSERT INTO in scheduler_instbuild '); exit();}
}

} // endof: if there was some build in progress

if($abbruch==0)redirect('a=building');
}






function Abort_Build2()
{
global $db;
global $game;
global $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;

// New: Click Ids
$game->init_player(11);
if ($game->planet['building_queue']==0) unset($game->planet['building_queue']);

$schedulerquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()<1 || !isset($game->planet['building_queue'])) {$game->out('<class="text_large">'.constant($game->sprache("TEXT4")).'</span><br>');}
else
{
$scheduler = $db->fetchrow($schedulerquery);

$game->planet['building_'.($scheduler['installation_type']+1)]++;
if ($db->query('UPDATE planets SET building_queue=0  WHERE planet_id= "'.$game->planet['planet_id'].'"')==false)  {$game->out('<class="text_large">'.constant($game->sprache("TEXT10")).'<br>'.constant($game->sprache("TEXT8")).' (ID='.$game->planet['planet_id'].') '.constant($game->sprache("TEXT9")).'</span><br>');}
else
{
$db->query('UPDATE planets SET resource_1=resource_1+'.(GetBuildingPrice($game->planet['building_queue']-1,0)).',resource_2=resource_2+'.(GetBuildingPrice($game->planet['building_queue']-1,1)).',resource_3=resource_3+'.(GetBuildingPrice($game->planet['building_queue']-1,2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"');
}

} // endof: if there was some build in progress


redirect('a=building');
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

$schedulerquery=$db->query('SELECT * FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
{
$scheduler = $db->fetchrow($schedulerquery);
// Von nun an steht das Level des momentan ausgebauten Gebäudes auf der endgültigen Stufe:
$game->planet['building_'.($scheduler['installation_type']+1)]++;

$game->out('
<table border=0 cellpadding=0 cellspacing=0 width=300 class="style_inner"><tr><td>
<tr><td>'.constant($game->sprache("TEXT11")).' <b>'.$BUILDING_NAME[$game->player['user_race']][$scheduler['installation_type']].' ('.constant($game->sprache("TEXT12")).' '.($game->planet['building_'.($scheduler['installation_type']+1)]).')</b><br>
'.constant($game->sprache("TEXT13")).'<br>
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['build_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=building&a2=abort_build',LINK_CLICKID).'"><b>'.constant($game->sprache("TEXT14")).'</b></a>
</td></tr>
'.(isset($game->planet['building_queue']) ? '<tr><td><br>'.constant($game->sprache("TEXT15")).' <b>'.$BUILDING_NAME[$game->player['user_race']][$game->planet['building_queue']-1].' ('.constant($game->sprache("TEXT12")).' '.($game->planet['building_'.($game->planet['building_queue'])]+1).')</b><br>
'.constant($game->sprache("TEXT13")).'<br>
<b id="timer4" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['build_finish']-$ACTUAL_TICK)+TICK_DURATION*60*GetBuildingTimeTicks($game->planet['building_queue']-1)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=building&a2=abort_build2',LINK_CLICKID).'"><b>'.constant($game->sprache("TEXT14")).'</b></a>
</td></tr>' : '').'

</table><br>
');


$game->set_autorefresh(($NEXT_TICK+TICK_DURATION*60*($scheduler['build_finish']-$ACTUAL_TICK))+TICK_DURATION);
}
else // Test for malfunction of building_queue:
{
if (isset($game->planet['building_queue']))
if ($db->query('UPDATE planets SET building_queue=0  WHERE planet_id= "'.$game->planet['planet_id'].'"')==false)  {$game->out('<span class="text_large"><b>Error in "Queue Malfunction Detected": The Works in the queue could not be removed!<br>'.constant($game->sprache("TEXT8")).' (ID='.$game->planet['planet_id'].') '.constant($game->sprache("TEXT9")).'</b></span><br>');}
}

$avai=($game->planet['building_5'])*11+14;
if (!$capital) $avai=($game->planet['building_5'])*15+3;
$used=$game->planet['building_1']+$game->planet['building_2']+$game->planet['building_3']+$game->planet['building_4']+$game->planet['building_10']+$game->planet['building_6']+$game->planet['building_7']+$game->planet['building_8']+$game->planet['building_9']+$game->planet['building_11']+$game->planet['building_12']+$game->planet['building_13'];
$game->out(constant($game->sprache("TEXT16")).' <b id="timer2" title="time1_'.$NEXT_TICK.'_type1_3">&nbsp;</b> '.constant($game->sprache("TEXT17")).'<br>'.constant($game->sprache("TEXT18")).' '.$used.'/'.$avai.' '.constant($game->sprache("TEXT19")).'<br><br>');

$game->out('<span class="sub_caption">'.(isset($scheduler['installation_type']) ? constant($game->sprache("TEXT20")) : constant($game->sprache("TEXT21")) ).' '.HelpPopup('building_1').' :</span><br><br>');

$game->out('<table border=0 cellpadding=2 cellspacing=2 width=595 class="style_outer">');

$game->out('<tr><td width=595>
<table border=0 cellpadding=2 cellspacing=2 width=595 class="style_inner">
<tr><td width=125><b>'.constant($game->sprache("TEXT29")).'</b></td><td width=250><b>'.constant($game->sprache("TEXT22")).'</b></td><td width=75><b>'.constant($game->sprache("TEXT23")).'</b></td><td width=145><b>'.constant($game->sprache("TEXT24")).'</b></td></tr>
');
for ($tt=0; $tt<=$NUM_BUILDING; $tt++)
{
if ($tt>9) $t=$tt-1;
else $t=$tt;
if ($tt==9) $t=12;

if (($t==11 && $game->planet['building_1']<4) || ($t==10 && $game->planet['building_1']<3) ||  ($t==6 && $game->planet['building_1']<5) || ($t==8 && $game->planet['building_1']<9) || ($t==7 && $game->planet['building_7']<1) || ($t==9 && ($game->planet['building_6']<5 || $game->planet['building_7']<1))  || ($t==12 && ($game->planet['building_6']<1 || $game->planet['building_7']<1))) {}
else
{
if ($game->planet['resource_1']>=GetBuildingPrice($t,0) && $game->planet['resource_2']>=GetBuildingPrice($t,1) && $game->planet['resource_3']>=GetBuildingPrice($t,2) && $game->planet['planet_available_points']>=GetFuturePts($t))
{
$build_text='<a href="'.parse_link_ex('a=building&a2=start_build&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT25")).' (~'.round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT26")).')</span></a>';
if ($game->planet['building_'.($t+1)]>0) $build_text='<a href="'.parse_link_ex('a=building&a2=start_build&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT27")).' '.($game->planet['building_'.($t+1)]+1).' (~'.round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT26")).')</span></a>';
if ($game->planet['building_'.($t+1)]>=$MAX_BUILDING_LVL[$capital][$t]) $build_text=constant($game->sprache("TEXT28"));
}
else
{
$build_text='<span style="color: red">'.constant($game->sprache("TEXT25")).' (~'.round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT26")).')</span>';
if ($game->planet['building_'.($t+1)]>0) $build_text='<span style="color: red">'.constant($game->sprache("TEXT27")).' '.($game->planet['building_'.($t+1)]+1).' (~'.round(pow($game->planet['building_'.($t+1)]+1,1.5)-pow($game->planet['building_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT26")).')</span>';
if ($game->planet['building_'.($t+1)]>=$MAX_BUILDING_LVL[$capital][$t]) $build_text=constant($game->sprache("TEXT28"));
}
$game->out('<tr><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.$BUILDING_DESCRIPTION[$game->player['user_race']][$t].'\', CAPTION, \''.$BUILDING_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$BUILDING_NAME[$game->player['user_race']][$t].'</b></td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.GetBuildingPrice($t,0).'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.GetBuildingPrice($t,1).'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.GetBuildingPrice($t,2).'&nbsp; </td><td>'.GetBuildingTime($t).'</td><td>'.$build_text.'</td></tr>');
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
if ($sub_action=='abort_build2')
{
Abort_Build2(); $sub_action='main';
}
if ($sub_action=='main')
{
if (round(100*round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)/$game->planet['min_troops_required'],0)>=70 || $game->planet['min_troops_required']==0)
Show_Main();
else
{
$game->out('<table width="450" border="0" align="center">
  <tr>
    <td><span class="text_large">'.constant($game->sprache("TEXT30")).' <b>'.round(100*round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)/$game->planet['min_troops_required'],0).'%</b> '.constant($game->sprache("TEXT31")).'</i></span>
    </td>
  </tr>
</table>
<br><br>
');

}
}


?>
