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


// Kurze Erklärung zum Forschungssystem:
// a.) Lokale Forschung, in der Datenbank Forschungsid 0-4
// b.) Komponentenforschung, in der Datenbank cat_id+5, also 5-xx.


$game->init_player();
include('include/static/static_components_'.$game->player['user_race'].'.php');


$game->out('<center><span class="caption">'.$BUILDING_NAME[$game->player['user_race']][8].':</span></center><br><br>');


function CreateInfoText($comp)
{
global $db;
global $game, $SHIP_TORSO;
$text=$comp['description'].'<br><br><u>Kosten:<br></u><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$comp['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$comp['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$comp['resource_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$comp['resource_4'].'<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif> '.$comp['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif> '.$comp['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif> '.$comp['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif> '.$comp['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif> '.$comp['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif> '.$comp['unit_6'].'<br><u>Bauzeit</u>:  +'.($comp['buildtime']*TICK_DURATION).' Minuten<br><br><u>Auswirkungen:</u><br>';
if ($comp['value_1']!=0) $text.='L. Waffen: '.$comp['value_1'].'<br>';
if ($comp['value_2']!=0) $text.='Schw. Waffen: '.$comp['value_2'].'<br>';
if ($comp['value_3']!=0) $text.='Pl. Waffen: '.$comp['value_3'].'<br>';
if ($comp['value_4']!=0) $text.='Schildstärke: '.$comp['value_4'].'<br>';
if ($comp['value_5']!=0) $text.='Hülle (HP): '.$comp['value_5'].'<br>';
if ($comp['value_6']!=0) $text.='Reaktion: '.$comp['value_6'].'<br>';
if ($comp['value_7']!=0) $text.='Bereitschaft: '.$comp['value_7'].'<br>';
if ($comp['value_8']!=0) $text.='Wendigkeit: '.$comp['value_8'].'<br>';
if ($comp['value_9']!=0) $text.='Erfahrung: '.$comp['value_9'].'<br>';
if ($comp['value_10']!=0) $text.='Warp: '.$comp['value_10'].'<br>';
if ($comp['value_11']!=0) $text.='Sensoren: '.$comp['value_11'].'<br>';
if ($comp['value_12']!=0) $text.='Tarnung: '.$comp['value_12'].'<br>';
if ($comp['value_14']!=0) $text.='Verbraucht Energie: '.$comp['value_14'].'<br>';
if ($comp['value_13']!=0) $text.='Liefert Energie: '.$comp['value_13'].'<br>';
$text.='<br><u>Kombinierbar mit folgenden Schiffsklassen:<br></u>';
$first=1;
$num=0;






for ($t=0; $t<13; $t++)
{
if ($comp['torso_'.($t+1)]==1 && $first!=1) { $text.=',&nbsp;'.$SHIP_TORSO[$game->player['user_race']][$t][29].''; $num++;}
if ($comp['torso_'.($t+1)]==1 && $first==1) { $text.=$SHIP_TORSO[$game->player['user_race']][$t][29].''; $first=0; $num++;}

if ($num>4) {$num=0; $text.='<br>';}
}

return $text;
}

function Zeit($minutes)
{
$days=0;
$hours=0;
while($minutes>=60*24) {$days++; $minutes-=60*24;}
while($minutes>=60) {$hours++; $minutes-=60;}

return (''.round($days,0).'d '.round($hours,0).'h '.round($minutes,0).'m');
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

//Ausgenommen durch Taps unnachgiebiges jammern
//if ($price>$game->planet['max_resources']) $price=$game->planet['max_resources'];

return round($price,0);
}

function GetCatResearchTime($level,$cat_id,$comp)
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
if ($db->num_rows()!=0) {$game->out('<center><span class="sub_caption">Fehler: Es wird bereits geforscht</span></center><br>');}
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
if ($db->num_rows()!=0) {$game->out('<center><span class="sub_caption">Fehler: Es wird bereits geforscht</span></center><br>');}
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
<center><table border=0 cellpadding=2 cellspacing=2 width=300 class="style_inner"><tr><td>
Geforscht wird: <b>'.$TECH_NAME[$game->player['user_race']][$scheduler['research_id']].'</b><br>
Verbleibende Zeit bis zur Fertigstellung:<br>
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=researchlabs&a2=abort_research',LINK_CLICKID).'"><b>Abbrechen</b></a>
</td></tr></table></center><br>
');
else
{
$game->out('
<center><center><table border=0 cellpadding=2 cellspacing=2 width=300 class="style_inner"><tr><td>
<tr><td>Geforscht wird: <b>'.$ship_components[$game->player['user_race']][($scheduler['research_id']-5)][$game->planet['catresearch_'.(($scheduler['research_id']-4))]]['name'].'</b><br>
Verbleibende Zeit bis zur Fertigstellung:<br>
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br>
<a href="'.parse_link_ex('a=researchlabs&a2=abort_research',LINK_CLICKID).'"><b>Abbrechen</b></a>
</td></tr></table></center><br>
');
}

$game->set_autorefresh($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK));
}

$game->out('<center>Aufgrund der Tickzeiten müssen noch <b id="timer2" title="time1_'.$NEXT_TICK.'_type1_3">&nbsp;</b> beim Forschungsstart addiert werden.</center><br><br>');



// Schiffskomponenten-Forschung:
$game->out('<center><span class="sub_caption">Schiffskomponentenabteilung '.HelpPopup('research_catresearch').' :</span></center><br>');
$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=498 class="style_outer">');
$game->out('
<tr><td width=550>
<table border=0 cellpadding=2 cellspacing=2 width=550 class="style_inner">
<tr>
<td width=100><b>Kategorie:</b></td><td width=130><b>Komponente:</b></td><td width=170><b>Kosten:</b></td><td width=75><b>Dauer:</b></td><td width=75>&nbsp;
</td></tr>
');


foreach ($ship_components[$game->player['user_race']] as $key => $components)
{
if ($game->planet['catresearch_'.($key+1)]>=$components['num']) continue;
if ($game->planet['catresearch_'.($key+1)]>=$game->planet['building_9']  && $game->planet['building_9']<9) // Wenn man nicht erst Forschungszentrum hochbauen muss
{$comp['name']='Noch unbekannt *';$build_text='<span style="color: red">Forschen</span>';}
elseif ($game->planet['resource_1']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],0) && $game->planet['resource_2']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],1) && $game->planet['resource_3']>=GetCatResearchPrice($game->planet['catresearch_'.($key+1)],2))
{$build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_catresearch&id='.$key,LINK_CLICKID).'"><span style="color: green">Forschen</span></a>';}
else {$build_text='<span style="color: red">Forschen</span>';}

if (strlen($components[$game->planet['catresearch_'.($key+1)]]['name'])>18)
{
$compname=substr($components[$game->planet['catresearch_'.($key+1)]]['name'], 0,16);
$compname=$compname.'...';
}
else {$compname=$components[$game->planet['catresearch_'.($key+1)]]['name'];}

if (strlen($components['name'])>13)
{
if($components['text_category'] !=null)
{
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$components['text_category'].'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($components['name'], 0,11);
$catname=$catname.'...</font></a>';
}else{
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.substr($components['name'], 0,11);
$catname=$catname.'...</font></a>';
}
}
else
{
if($components['text_category'] !=null)
{
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$components['text_category'].'\',CAPTION,\''.$components['name'].'\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color="#FFFFFF">'.$components['name'].'</font></a>';
}else{
$catname=$components['name'];
}
}

if ($game->planet['catresearch_'.($key+1)]>=$game->planet['building_9'] && $game->planet['building_9']<9) // Wenn man nicht erst Forschungszentrum hochbauen muss
$game->out('<tr><td><b>'.$catname.'</b></td><td><b><a href="javascript:void(0);" onmouseover="return overlib(\'Du musst zunächst dein(e) '.$BUILDING_NAME[$game->player['user_race']]['8'].' weiter ausbauen, bevor du in dieser Kategorie weiterforschen darfst.\', CAPTION, \''.$components[$game->planet['catresearch_'.($key+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$compname.'</a></b></td><td>');
else
$game->out('<tr><td><b>'.$catname.'</b></td><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($components[$game->planet['catresearch_'.($key+1)]]).'\', CAPTION, \''.$components[$game->planet['catresearch_'.($key+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$compname.'</a></b></td><td>');

$game->out('<img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.  GetCatResearchPrice($game->planet['catresearch_'.($key+1)],0).'&nbsp;&nbsp;
<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'. GetCatResearchPrice($game->planet['catresearch_'.($key+1)],1).'&nbsp;&nbsp;
<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.GetCatResearchPrice($game->planet['catresearch_'.($key+1)],2).'&nbsp; </td><td>'.GetCatResearchTime($game->planet['catresearch_'.($key+1)],($key+1)).'</td><td>'.$build_text.'</td></tr>');
} // while

$game->out('</table></td></tr></table></center>');
$game->out('<br><br>');
$game->out('<center><span class="sub_caption">Planetare Forschungsabteilung '.HelpPopup('research_localresearch').' :</span></center><br>');
$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=550 class="style_outer">');
$game->out('
<tr>
<td width=550>
<table border=0 cellpadding=2 cellspacing=2 width=600 class="style_inner"><tr><td width=150><b>Technologie:</b></td><td width=175><b>Forschungskosten:</b></td><td width=100><b>Forschungszeit:</b></td><td width=*>&nbsp;</td></tr>');


// Lokale Forschung:
for ($t=0; $t<5; $t++)
{

if (($t==0 && $game->planet['building_9']<1) || ($t==1 && $game->planet['building_9']<1) || ($t==2 && ($game->planet['building_9']<1)) || ($t==3 && ($game->planet['building_9']<1)) || ($t==4 && ($game->planet['building_9']<3 || $game->planet['building_2']<5 || $game->planet['building_3']<5 || $game->planet['building_4']<5))) {}
else
{
if ($game->planet['resource_1']>=GetResearchPrice($t,0) && $game->planet['resource_2']>=GetResearchPrice($t,1) && $game->planet['resource_3']>=GetResearchPrice($t,2))
{
$build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_research&id='.$t,LINK_CLICKID).'"><span style="color: green">Forschen (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' Pkt)</span></a>';
if ($game->planet['research_'.($t+1)]>0) $build_text='<a href="'.parse_link_ex('a=researchlabs&a2=start_research&id='.$t,LINK_CLICKID).'"><span style="color: green">Upgrade auf '.($game->planet['research_'.($t+1)]+1).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' Pkt)</span></a>';
if ($game->planet['research_'.($t+1)]>=$MAX_RESEARCH_LVL[$capital][$t]) $build_text='Erforscht';
}
else
{
$build_text='<span style="color: red">Forschen (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' Pkt)</span>';
if ($game->planet['research_'.($t+1)]>0)
{
$build_text='<span style="color: red">Upgrade auf '.($game->planet['research_'.($t+1)]+1).' (~'.round(pow($game->planet['research_'.($t+1)]+1,1.5)-pow($game->planet['research_'.($t+1)],1.5)).' Pkt)</span>';
}
if ($game->planet['research_'.($t+1)]>=$MAX_RESEARCH_LVL[$capital][$t]) $build_text='Erforscht';
}

$game->out('<tr><td><b><a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][$t].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][$t].'</b></td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.GetResearchPrice($t,0).'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.GetResearchPrice($t,1).'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">'.GetResearchPrice($t,2).'</td><td>&nbsp;'.GetResearchTime($t).'</td><td>'.$build_text.'</td></tr>');
}
}

$game->out('</td></tr></table></td></tr></table></center>');
}


if ($game->planet['building_9']<1)
{
$game->out('<center><center><span class="text_large">Du musst ein(e) '.$BUILDING_NAME[$game->player['user_race']]['8'].' bauen, bevor Technologien erforscht werden können.</span></center><br><br><center>');


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
