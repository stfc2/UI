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


// A brief explanation of the research system:
// a.) Local research, research_id 0-4 in the database
// b.) Components research, in the database cat_id+5, ie 5-xx.


$game->init_player();
include('include/static/static_components_'.$game->player['user_race'].'.php');
$filename = 'include/static/static_components_'.$game->player['user_race'].'_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);


$game->out('<span class="caption">'.$BUILDING_NAME[$game->player['user_race']][8].':</span><br><br>');


function CreateInfoText($comp)
{
global $db;
global $game, $SHIP_TORSO;
$text=$comp['description'].'<br><br><u>'.constant($game->sprache("TEXT0")).'<br></u><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$comp['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$comp['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$comp['resource_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$comp['resource_4'].'<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif> '.$comp['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif> '.$comp['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif> '.$comp['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif> '.$comp['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif> '.$comp['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif> '.$comp['unit_6'].'<br><u>'.constant($game->sprache("TEXT1")).'</u>  +'.($comp['buildtime']*TICK_DURATION).' '.constant($game->sprache("TEXT2")).'<br><br><u>'.constant($game->sprache("TEXT3")).'</u><br>';
if ($comp['value_1']!=0) $text.=constant($game->sprache("TEXT4")).' '.$comp['value_1'].'<br>';
if ($comp['value_2']!=0) $text.=constant($game->sprache("TEXT5")).' '.$comp['value_2'].'<br>';
if ($comp['value_3']!=0) $text.=constant($game->sprache("TEXT6")).' '.$comp['value_3'].'<br>';
if ($comp['value_4']!=0) $text.=constant($game->sprache("TEXT7")).' '.$comp['value_4'].'<br>';
if ($comp['value_5']!=0) $text.=constant($game->sprache("TEXT8")).' '.$comp['value_5'].'<br>';
if ($comp['value_6']!=0) $text.=constant($game->sprache("TEXT9")).' '.$comp['value_6'].'<br>';
if ($comp['value_7']!=0) $text.=constant($game->sprache("TEXT10")).' '.$comp['value_7'].'<br>';
if ($comp['value_8']!=0) $text.=constant($game->sprache("TEXT11")).' '.$comp['value_8'].'<br>';
if ($comp['value_9']!=0) $text.=constant($game->sprache("TEXT12")).' '.$comp['value_9'].'<br>';
if ($comp['value_10']!=0) $text.=constant($game->sprache("TEXT13")).' '.$comp['value_10'].'<br>';
if ($comp['value_11']!=0) $text.=constant($game->sprache("TEXT14")).' '.$comp['value_11'].'<br>';
if ($comp['value_12']!=0) $text.=constant($game->sprache("TEXT15")).' '.$comp['value_12'].'<br>';
if ($comp['value_14']!=0) $text.=constant($game->sprache("TEXT16")).' '.$comp['value_14'].'<br>';
if ($comp['value_13']!=0) $text.=constant($game->sprache("TEXT17")).' '.$comp['value_13'].'<br>';
$text.='<br><u>'.constant($game->sprache("TEXT18")).'<br></u>';
$first=1;
$num=0;






for ($t=0; $t<12; $t++)
{
if ($comp['torso_'.($t+1)]==1 && $first!=1) { $text.=',&nbsp;'.$SHIP_TORSO[$game->player['user_race']][$t][29].''; $num++;}
if ($comp['torso_'.($t+1)]==1 && $first==1) { $text.=$SHIP_TORSO[$game->player['user_race']][$t][29].''; $first=0; $num++;}

if ($num>4) {$num=0; $text.='<br>';}
}

return $text;
}

function GetCatResearchPrice($level,$resource)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;

$price=0;
if ($resource==0) $price=pow($level*25,2.12)+500;
if ($resource==1) $price=pow($level*25,2.05)+350;
if ($resource==2) $price=pow($level*25,1.95)+200;
$price*=$RACE_DATA[$game->player['user_race']][8];

if($resource==0) {
 $price*=$RACE_DATA[$game->player['user_race']][26];
}
elseif($resource==1) {
 $price*=$RACE_DATA[$game->player['user_race']][27];
}
elseif($resource==2) {
 $price*=$RACE_DATA[$game->player['user_race']][28];
}

//Excluded by Taps unyielding whine
//if ($price>$game->planet['max_resources']) $price=$game->planet['max_resources'];

return round($price,0);
}

function GetCatResearchTime($level,$cat_id)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$time=0;

$time=pow($level*4,2)+3;
$time*=$RACE_DATA[$game->player['user_race']][4];

$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));

// Test wheter this has already been researched:
$rs=$db->queryrow('SELECT MAX(catresearch_'.$cat_id.') as mx_lvl FROM planets WHERE planet_owner='.$game->player['user_id']);
if ($level<$rs['mx_lvl']) $time*=0.4;

if ($time<1) $time=1;
$time=TICK_DURATION*round($time,0);
return (format_time($time));
}

function GetCatResearchTimeTicks($level,$cat_id)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$time=0;
$time=pow($level*4,2)+3;
$time*=$RACE_DATA[$game->player['user_race']][4];
$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));

// Test wheter this has already been researched:
$rs=$db->queryrow('SELECT MAX(catresearch_'.$cat_id.') as mx_lvl FROM planets WHERE planet_owner='.$game->player['user_id']);
if ($level<$rs['mx_lvl']) $time*=0.4;
if ($time<1) $time=1;
$time=round($time,0);
return $time;
}


function GetResearchPrice($tech,$resource)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;


$price=round(pow($TECH_DATA[$tech][$resource]*($game->planet['research_'.($tech+1)]+1),2),0);
$price*=$RACE_DATA[$game->player['user_race']][8];
//if ($price>$game->planet['max_resources']) $price=$game->planet['max_resources'];

if($resource==0) {
 $price*=$RACE_DATA[$game->player['user_race']][26];
}
elseif($resource==1) {
 $price*=$RACE_DATA[$game->player['user_race']][27];
}
elseif($resource==2) {
 $price*=$RACE_DATA[$game->player['user_race']][28];
}

return round($price,0);
}




function GetResearchTime($tech)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$time=0;

$time=$TECH_DATA[$tech][3]+ pow($game->planet['research_'.($tech+1)],$TECH_DATA[$tech][4]);
$time*=$RACE_DATA[$game->player['user_race']][4];

$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
if ($time<1) $time=1;
$time=TICK_DURATION*round($time,0);

return (format_time($time));
}


function GetResearchTimeTicks($tech)
{
global $db;
global $game;
global $RACE_DATA, $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$time=0;

$time=$TECH_DATA[$tech][3]+ pow($game->planet['research_'.($tech+1)],$TECH_DATA[$tech][4]);
$time*=$RACE_DATA[$game->player['user_race']][4];

$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
if ($time<1) $time=1;
$time=round($time,0);

return $time;
}


function Abort_Research()
{
global $db;
global $game;
global $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;

// New: Table locking
$game->init_player(12);

$schedulerquery=$db->query('SELECT * FROM scheduler_research WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
{
$scheduler=$db->fetchrow($schedulerquery);
$scheduler['research_id'];
$t=$scheduler['research_id'];


if ($t<5)
{
// Abort Local Research:
if (($db->query('DELETE FROM scheduler_research WHERE (planet_id='.$scheduler['planet_id'].') LIMIT 1'))==true)
{
  if (($db->query('UPDATE planets SET resource_1=resource_1+'.(GetResearchPrice($t,0)).',resource_2=resource_2+'.(GetResearchPrice($t,1)).',resource_3=resource_3+'.(GetResearchPrice($t,2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))!=true) {message(DATABASE_ERROR, 'research_query: Could not call DELETE FROM in scheduler_research '); exit();}
} //end: if (($db->query('DELETE FROM scheduler_research WHERE (planet_id='.$scheduler['planet_id'].') LIMIT 1'))==true)
}
else
{
// Abort Cat-Research:

// a.) Get the comp:
$t-=5;

if (($db->query('DELETE FROM scheduler_research WHERE (planet_id='.$scheduler['planet_id'].') LIMIT 1'))==true)
{
  if (($db->query('UPDATE planets SET resource_1=resource_1+'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],0)).',resource_2=resource_2+'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],1)).',resource_3=resource_3+'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))!=true) {message(DATABASE_ERROR, 'research_query: Could not call DELETE FROM in scheduler_research '); exit();}
} //end: if (($db->query('DELETE FROM scheduler_research WHERE (planet_id='.$scheduler['planet_id'].') LIMIT 1'))==true)

} //end: else

} // end: if ($db->num_rows()>0)

redirect('a=researchlabs');
}



function Start_Research()
{
global $db;
global $game;
global $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;
$t=(int)$_REQUEST['id'];

// Clickids:
$game->init_player(12);
$done=0;

$userquery=$db->query('SELECT * FROM scheduler_research WHERE (planet_id="'.$game->planet['planet_id'].'")');
if ($db->num_rows()!=0) {$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT19")).'</span><br>');}
else
{
// Start Local Research:
if ($game->planet['resource_1']>=GetResearchPrice($t,0) && $game->planet['resource_2']>=GetResearchPrice($t,1) && $game->planet['resource_3']>=GetResearchPrice($t,2))
{
if (($t==0 && $game->planet['building_9']<1) || ($t==1 && $game->planet['building_9']<1) || ($t==2 && ($game->planet['building_9']<1)) || ($t==3 && ($game->planet['building_9']<1)) || ($t==4 && ($game->planet['building_9']<3 || $game->planet['building_2']<5 || $game->planet['building_3']<5 || $game->planet['building_4']<5))) {}
else
{
if (($db->query('UPDATE planets SET resource_1=resource_1-'.(GetResearchPrice($t,0)).',resource_2=resource_2-'.(GetResearchPrice($t,1)).',resource_3=resource_3-'.(GetResearchPrice($t,2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))==true)
{
  $game->planet['resource_1']-=GetResearchPrice($t,0);
  $game->planet['resource_2']-=GetResearchPrice($t,1);
  $game->planet['resource_3']-=GetResearchPrice($t,2);
  if ($db->query('INSERT INTO scheduler_research (research_id,planet_id,player_id,research_finish,research_start)
  			VALUES ("'.($_REQUEST['id']).'","'.$game->planet['planet_id'].'","'.$game->player['user_id'].'","'.($ACTUAL_TICK+GetResearchTimeTicks($t)).'","'.(GetResearchTimeTicks($t)).'")')==false)  {message(DATABASE_ERROR, 'research_query: Could not call INSERT INTO in scheduler_research '); $db->unlock(); exit();}
  $done=1;
} // end: if (($db->query('UPDATE planets SET resource_1=resource_1-'.(GetResearchPrice($t,0)).',resource_2=resource_2-'.(GetResearchPrice($t,1)).',resource_3=resource_3-'.(GetResearchPrice($t,2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))==true)
} // end: else
} // end: if ($game->planet['resource_1']>=GetResearchPrice($t,0) && $game->planet['resource_2']>=GetResearchPrice($t,1) && $game->planet['resource_3']>=GetResearchPrice($t,2))
// End of Local Research


}  //end: else

if ($done) redirect('a=researchlabs');
}



function Start_CatResearch()
{
global $db;
global $game;
global $TECH_DATA, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;
$t=(int)$_REQUEST['id'];

// Clickids:
$game->init_player(12);

$done=0;

$userquery=$db->query('SELECT * FROM scheduler_research WHERE (planet_id="'.$game->planet['planet_id'].'")');
if ($db->num_rows()!=0) {$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT19")).'</span><br>');}
else
{
// Start Cat-Research:

if ($game->planet['catresearch_'.($t+1)]<$game->planet['building_9'] || $game->planet['building_9']>=9)
if ($game->planet['resource_1']>=GetCatResearchPrice($game->planet['catresearch_'.($t+1)],0) && $game->planet['resource_2']>=GetCatResearchPrice($game->planet['catresearch_'.($t+1)],1) && $game->planet['resource_3']>=GetCatResearchPrice($game->planet['catresearch_'.($t+1)],2))
{
	if ($game->planet['catresearch_'.$r_id]<$game->planet['building_9']  || $game->planet['building_9']>=9) // Wenn man nicht erst Forschungszentrum hochbauen muss
	if (($db->query('UPDATE planets SET resource_1=resource_1-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],0)).',resource_2=resource_2-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],1)).',resource_3=resource_3-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))==true)
	{
	if ($db->query('INSERT INTO scheduler_research (research_id,planet_id,player_id,research_finish,research_start)
	  			VALUES ("'.($t+5).'","'.$game->planet['planet_id'].'","'.$game->player['user_id'].'","'.($ACTUAL_TICK+GetCatResearchTimeTicks($game->planet['catresearch_'.($t+1)],$t+1)).'","'.$ACTUAL_TICK.'")')==false)  {message(DATABASE_ERROR, 'research_query: Could not call INSERT INTO in scheduler_research '); exit();}
  	$done=1;

	} // end: if (($db->query('UPDATE planets SET resource_1=resource_1-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],0)).',resource_2=resource_2-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],1)).',resource_3=resource_3-'.(GetCatResearchPrice($game->planet['catresearch_'.($t+1)],2)).'  WHERE planet_id= "'.$game->planet['planet_id'].'"'))==true)
} // end: if ($game->planet['resource_1']>=GetCatResearchPrice($game->planet['catresearch_'.$_REQUEST['id']],$comp,0) && $game->planet['resource_2']>=GetCatResearchPrice($game->planet['catresearch_'.$_REQUEST['id']],$comp,1) && $game->planet['resource_3']>=GetCatResearchPrice($game->planet['catresearch_'.$_REQUEST['id']],$comp,2))
// End of Cat-Research


}  //end: else


if ($done) redirect('a=researchlabs');
}



function Show_Main()
{
global $db;
global $game;
global $ship_components;
global $TECH_DATA, $TECH_DESCRIPTION, $TECH_NAME, $MAX_RESEARCH_LVL,$NEXT_TICK,$ACTUAL_TICK,$BUILDING_NAME;
$pow_factor=2;



// Clickids:
$game->register_click_id(12);

$capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
if ($game->player['pending_capital_choice']) $capital=0;


$schedulerquery=$db->query('SELECT * FROM scheduler_research WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
{
$scheduler = $db->fetchrow($schedulerquery);

if ($scheduler['research_id']<5)
$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=300 class="style_inner"><tr><td>
'.constant($game->sprache("TEXT20")).' <b>'.$TECH_NAME[$game->player['user_race']][$scheduler['research_id']].'</b><br>
'.constant($game->sprache("TEXT21")).'<br>
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=researchlabs&a2=abort_research',LINK_CLICKID).'"><b>'.constant($game->sprache("TEXT22")).'</b></a>
</td></tr></table><br>
');
else
{
$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=300 class="style_inner"><tr><td>
'.constant($game->sprache("TEXT20")).' <b>'.$ship_components[$game->player['user_race']][($scheduler['research_id']-5)][$game->planet['catresearch_'.(($scheduler['research_id']-4))]]['name'].'</b><br>
'.constant($game->sprache("TEXT21")).'<br>
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=researchlabs&a2=abort_research',LINK_CLICKID).'"><b>'.constant($game->sprache("TEXT22")).'</b></a>
</td></tr></table><br>
');
}

$game->set_autorefresh($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK));
}

$game->out(''.constant($game->sprache("TEXT23")).' <b id="timer2" title="time1_'.$NEXT_TICK.'_type1_3">&nbsp;</b> '.constant($game->sprache("TEXT24")).'<br><br><br>');



// Ship components research:
$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT25")).' '.HelpPopup('research_catresearch').' :</span><br><br>');
$game->out('<table border=0 cellpadding=2 cellspacing=2 width=498 class="style_outer">');
$game->out('
<tr><td width=550>
<table border=0 cellpadding=2 cellspacing=2 width=550 class="style_inner">
<tr>
<td width=100><b>'.constant($game->sprache("TEXT26")).'</b></td><td width=130><b>'.constant($game->sprache("TEXT27")).'</b></td><td width=170><b>'.constant($game->sprache("TEXT0")).'</b></td><td width=75><b>'.constant($game->sprache("TEXT28")).'</b></td><td width=75>&nbsp;
</td></tr>
');


foreach ($ship_components[$game->player['user_race']] as $key => $components)
{
//if ($game->planet['catresearch_'.($key+1)]>=$components['num']) continue;
if ($game->planet['catresearch_'.($key+1)]>=$game->planet['building_9']  && $game->planet['building_9']<9) // Wenn man nicht erst Forschungszentrum hochbauen muss
{$comp['name']=constant($game->sprache("TEXT29"));$build_text='<span style="color: red">'.constant($game->sprache("TEXT30")).'</span>';}
elseif ($game->planet['resource_1']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],0) && $game->planet['resource_2']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],1) && $game->planet['resource_3']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],2))
{$build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_catresearch&id='.$key,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT30")).'</span></a>';}
else {$build_text='<span style="color: red">'.constant($game->sprache("TEXT30")).'</span>';}
// 03/04/08 - AC: Show "Completed" instead of remove completely the line
if ($game->planet['catresearch_'.($key+1)]>=$components['num']) $build_text=constant($game->sprache("TEXT39"));

/* 22/04/08 - AC: Translate HTML code into plain char */
$trans = array("&#146;" => "'");
$tmp = strtr(html_entity_decode($components[$game->planet['catresearch_'.($key+1)]]['name']), $trans);
/* */
if (strlen($tmp)>18)
{
//$compname=substr($components[$game->planet['catresearch_'.($key+1)]]['name'], 0,16);
$compname=substr($tmp,0,16);
$compname=$compname.'...';
}
else {$compname=$components[$game->planet['catresearch_'.($key+1)]]['name'];}

/* 22/04/08 - AC: Translate HTML code into plain char */
$trans = array("&#146;" => "'");
$tmp = strtr(html_entity_decode($components['name']), $trans);
/* */
if (strlen($tmp)>13)
{

/*if($components['text_category'] !=null)
{

//$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$components['text_category'].'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($components['name'], 0,11);
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$components['text_category'].'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($tmp, 0,11);
$catname=$catname.'...</font></a>';
}else{*/
//$catname='<a href="javascript:void(0);" onmouseover="return overlib(\'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($components['name'], 0,11);
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($tmp, 0,11);
$catname=$catname.'...</font></a>';
/*}*/
}
else
{
/*if($components['text_category'] !=null)
{
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$components['text_category'].'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.$components['name'].'</font></a>';
}else{*/
$catname=$components['name'];
/*}*/
}

if ($game->planet['catresearch_'.($key+1)]>=$game->planet['building_9'] && $game->planet['building_9']<9) // Wenn man nicht erst Forschungszentrum hochbauen muss
$game->out('<tr><td><b>'.$catname.'</b></td><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT31")).' '.$BUILDING_NAME[$game->player['user_race']]['8'].' '.constant($game->sprache("TEXT32")).'\', CAPTION, \''.$components[$game->planet['catresearch_'.($key+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$compname.'</a></b></td><td>');
else
$game->out('<tr><td><b>'.$catname.'</b></td><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($components[$game->planet['catresearch_'.($key+1)]]).'\', CAPTION, \''.$components[$game->planet['catresearch_'.($key+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$compname.'</a></b></td><td>');

$game->out('<img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.  GetCatResearchPrice($game->planet['catresearch_'.($key+1)],0).'&nbsp;&nbsp;
<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'. GetCatResearchPrice($game->planet['catresearch_'.($key+1)],1).'&nbsp;&nbsp;
<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.GetCatResearchPrice($game->planet['catresearch_'.($key+1)],2).'&nbsp; </td><td>'.GetCatResearchTime($game->planet['catresearch_'.($key+1)],($key+1)).'</td><td>'.$build_text.'</td></tr>');
} // while

$game->out('</table></td></tr></table>');
$game->out('<br><br>');
$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT33")).' '.HelpPopup('research_localresearch').' :</span><br><br>');
$game->out('<table border=0 cellpadding=2 cellspacing=2 width=550 class="style_outer">');
$game->out('
<tr>
<td width=550>
<table border=0 cellpadding=2 cellspacing=2 width=600 class="style_inner"><tr><td width=150><b>'.constant($game->sprache("TEXT34")).'</b></td><td width=175><b>'.constant($game->sprache("TEXT35")).'</b></td><td width=100><b>'.constant($game->sprache("TEXT36")).'</b></td><td width=*>&nbsp;</td></tr>');


// Local research:
for ($t=0; $t<5; $t++)
{

if (($t==0 && $game->planet['building_9']<1) || ($t==1 && $game->planet['building_9']<1) || ($t==2 && ($game->planet['building_9']<1)) || ($t==3 && ($game->planet['building_9']<1)) || ($t==4 && ($game->planet['building_9']<3 || $game->planet['building_2']<5 || $game->planet['building_3']<5 || $game->planet['building_4']<5))) {}
else
{
if ($game->planet['resource_1']>=GetResearchPrice($t,0) && $game->planet['resource_2']>=GetResearchPrice($t,1) && $game->planet['resource_3']>=GetResearchPrice($t,2))
{
$build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_research&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT30")).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT37")).')</span></a>';
if ($game->planet['research_'.($t+1)]>0) $build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_research&id='.$t,LINK_CLICKID).'"><span style="color: green">'.constant($game->sprache("TEXT38")).' '.($game->planet['research_'.($t+1)]+1).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT37")).')</span></a>';
if ($game->planet['research_'.($t+1)]>=$MAX_RESEARCH_LVL[$capital][$t]) $build_text=constant($game->sprache("TEXT39"));
}
else
{
$build_text='<span style="color: red">'.constant($game->sprache("TEXT30")).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT30")).')</span>';
if ($game->planet['research_'.($t+1)]>0)
{
$build_text='<span style="color: red">'.constant($game->sprache("TEXT38")).' '.($game->planet['research_'.($t+1)]+1).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' '.constant($game->sprache("TEXT37")).')</span>';
}
if ($game->planet['research_'.($t+1)]>=$MAX_RESEARCH_LVL[$capital][$t]) $build_text=constant($game->sprache("TEXT39"));
}

$game->out('<tr><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][$t].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][$t].'</b></td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.GetResearchPrice($t,0).'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.GetResearchPrice($t,1).'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">'.GetResearchPrice($t,2).'</td><td>&nbsp;'.GetResearchTime($t).'</td><td>'.$build_text.'</td></tr>');
}
}

$game->out('</td></tr></table></td></tr></table>');
}


if ($game->planet['building_9']<1)
{
message(NOTICE, constant($game->sprache("TEXT40")).' '.$BUILDING_NAME[$game->player['user_race']][8].' '.constant($game->sprache("TEXT41")));
//$game->out('<span class="text_large">'.constant($game->sprache("TEXT40")).' '.$BUILDING_NAME[$game->player['user_race']]['8'].' '.constant($game->sprache("TEXT41")).'</span><br><br>');


}
else
{

$sub_action = (!empty($_GET['a2'])) ? $_GET['a2'] : 'main';

if ($sub_action=='start_research')
{
Start_Research(); $sub_action='main';
}
if ($sub_action=='start_catresearch')
{
Start_CatResearch(); $sub_action='main';
}
if ($sub_action=='abort_research')
{
Abort_Research(); $sub_action='main';
}
if ($sub_action=='main')
{
Show_Main();
}

}
?>
