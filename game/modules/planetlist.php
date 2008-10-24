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
include_once('include/libs/moves.php');


//Day ne globale Klasse ist nett, aber nicht immer passt ihr inhalt
$game->init_player();
include('include/static/static_components_'.$game->player['user_race'].'.php');
$filename = 'include/static/static_components_'.$game->player['user_race'].'_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);

error_reporting(E_ERROR);
function GetBuildingTimeTicks($building,$stufe=0,$planet_t,$player_race,$planet_prob,$plani_forsch=1)
{
global $db;
global $game;
global $RACE_DATA, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK,$PLANETS_DATA;
if($stufe==1)
{
$time=($BUILDING_DATA[$building][3] + 3*pow($planet_prob['building_'.($planet_prob['building_queue']-1)]+1,$BUILDING_DATA[$building][4]));
}else{
$time=($BUILDING_DATA[$building][3] + 3*pow($planet_prob['building_'.($building+1)],$BUILDING_DATA[$building][4]));
}
if ($building==9)
	$time=$BUILDING_DATA[$building][3];
if ($building==12)
	$time=$BUILDING_DATA[$building][3];
$time*=$RACE_DATA[$player_race][1];
$time/=100;
$time*=(100-2*($plani_forsch*$RACE_DATA[$player_race][20]));
$time*=$PLANETS_DATA[$planet_t][5];
$time=round($time,0);
return $time;
}

/* ($game->planet['building_'.($game->planet['building_queue'])]+1).
function GetBuildingTimeTicks($building,$planet_t,$player_race)
{
if($stufe==1)
{
$time=($BUILDING_DATA[$building][3] + 3*pow($game->planet['building_'.($game->planet['building_queue'])]+1,$BUILDING_DATA[$building][4]));
$game->out('TAPSI 03 Build:'.$game->planet['building_queue'].'<br>');
$game->out('TAPSI 04:Build data 4'.$BUILDING_DATA[$building][4].'<br>');
}else{
$time=($BUILDING_DATA[$building][3] + 3*pow($game->planet['building_'.($building+1)],$BUILDING_DATA[$building][4]));
$game->out('TAPSI 03 Build:'.$game->planet['building_'.($building+1)].'<br>');
$game->out('TAPSI 04:Build data 4'.$BUILDING_DATA[$building][4].'<br>');
}
global $db;
global $game;
global $RACE_DATA, $BUILDING_NAME, $BUILDING_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK,$PLANETS_DATA;

$time=($BUILDING_DATA[$building][3] + 3*pow($game->planet['building_'.($building+1)],$BUILDING_DATA[$building][4]));
$game->out("TTTTTTTTTTTTTTTtt<br>".$time);
if ($building==9)
	$time=$BUILDING_DATA[$building][3];
if ($building==12)
	$time=$BUILDING_DATA[$building][3];
$time*=$RACE_DATA[$game->player['user_race']][1];
$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
$time*=$PLANETS_DATA[$game->planet['planet_type']][5];
$game->out("HUHUUUUUUUUUUUUUU<br>".$planet_t);
$game->out("TTTTTTTTTTTTTTTtt<br>".$time);
$time=round($time,0);

return $time;

}
/*
function GetBuildingTimeTicks($building,$planet_t,$player_race)
{
$time*=$RACE_DATA[$player_race][1];
$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$player_race][20]));
$time*=$PLANETS_DATA[$planet_t][5];
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
*/


if (isset($_GET['s_o']) && $_GET['s_o']>=0 && $_GET['s_o']<=6) $game->option_store('planetlist_order',(int)$_GET['s_o']);
if (isset($_GET['s_s']) && $_GET['s_s']>=0 && $_GET['s_s']<=3) $game->option_store('planetlist_show',(int)$_GET['s_s']);

if (!$game->SITTING_MODE && isset($_GET['s_op']) && $_GET['s_op']>=0 && $_GET['s_op']<=2) $game->option_store('redalert_options',(int)$_GET['s_op']);

if (isset($_REQUEST['a2']) && $_REQUEST['a2']>=0)
{
 $game->player->active_planet($_REQUEST['a2']);
}


$game->out('<span class="caption">'.constant($game->sprache("TEXT1")).'</span><br><br>');
$game->out(constant($game->sprache("TEXT2")).'<br>'.constant($game->sprache("TEXT3")).'<br>
'.constant($game->sprache("TEXT4")).'<font color=#80ff80>'.constant($game->sprache("TEXT5")).'</font>'.constant($game->sprache("TEXT6")).'<br>
'.constant($game->sprache("TEXT7")).'<font color=#ffff80>'.constant($game->sprache("TEXT8")).'</font> '.constant($game->sprache("TEXT9")).' <font color=#ff8080>'.constant($game->sprache("TEXT10")).'</font>.<br><br>');

$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT12")).' '.HelpPopup('planetlist').' :</span><br><br>');
$game->out('
<table border=0 cellpadding=1 cellaspacing=1 class="style_outer">
<tr>
<td>
<table border=0 cellpadding=1 cellspacing=1 class="style_inner">
<tr><td width=90 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT13")).'</span></td><td width=20 valign="top"></td><td width=80 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT14")).'</span></td><td width=130 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT57")).'</span><br>@ Warp 6</td><td width=310 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT15")).'</span></td><td width=100 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT16")).'</span></td><td width=60 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT17")).'</span></td><td width=60 valign="top"><span class="sub_caption2">'.constant($game->sprache("TEXT18")).'</span></td></tr>
');

$order[0]=' pl.planet_name ASC';
$order[1]=' pl.planet_points DESC';
$order[2]=' pl.planet_owned_date ASC';
$order[3]=' pl.sector_id ASC, pl.system_id ASC';
$order[4]=' ((pl.unit_1*2+pl.unit_2*3+pl.unit_3*4+pl.unit_4*4)/pl.min_security_troops) ASC';
$order[5]=' pl.planet_type ASC';
$order[6]=' pl.planet_altname ASC';

$planets=array();
$planet_ids=array();
$spacedock_planets = array();
$spacedock_ids = array();


// 1. Den Planet und das Starsystem holen
$planetquery=$db->query('SELECT pl. * , sys.system_x, sys.system_y FROM (planets pl)
LEFT JOIN (starsystems sys) ON sys.system_id = pl.system_id WHERE pl.planet_owner = '.$game->player['user_id'].'
GROUP BY pl.planet_id
ORDER BY '.$order[$game->option_retr('planetlist_order')]);

$numerate=0;
while(($planet = $db->fetchrow($planetquery)))
{
	$planet['numerate']=$numerate;
	$planets[$planet['planet_id']]=$planet;
	$planet_ids[]=$planet['planet_id'];
	$numerate++;
}

// 1.1 Den Planet und das Starsystem holen für Spacedock
/*$planetquery=$db->query('SELECT pl. * , sys.system_x, sys.system_y FROM (planets pl)
LEFT JOIN (starsystems sys) ON sys.system_id = pl.system_id WHERE pl.planet_owner = '.$game->player['user_id'].'
GROUP BY pl.planet_id
ORDER BY '.$order[$game->option_retr('planetlist_order')]);

$numerate_space=0;
while(($spacedock_planet = $db->fetchrow($planetquery)))
{
	$spacedock_planet['numerate']=$numerate_space;
	$spacedock_planets[$planet['planet_id']]=$spacedock_planet;
	$spacedock_ids[]=(-$spacedock_planet['planet_id']);
	$numerate_space++;
}*/

// 2. Forschung holen
$planetquery=$db->query('SELECT r.planet_id AS tmp1, r.research_id, r.research_start, r.research_finish
FROM (scheduler_research r)
WHERE r.planet_id IN ('.implode(', ',$planet_ids).')');
while(($research = $db->fetchrow($planetquery)))
{
	$planets[$research['tmp1']]['research_id']=$research['research_id'];
	$planets[$research['tmp1']]['research_start']=$research['research_start'];
	$planets[$research['tmp1']]['research_finish']=$research['research_finish'];
}


// 3. Gebäudebau holen
$planetquery=$db->query('SELECT b.planet_id AS tmp2, b.installation_type AS build_active, b.build_finish AS building_finish
FROM (scheduler_instbuild b)
WHERE b.planet_id IN ('.implode(', ',$planet_ids).')');
while(($building = $db->fetchrow($planetquery)))
{
	$planets[$building['tmp2']]['build_active']=$building['build_active'];
	$planets[$building['tmp2']]['building_finish']=$building['building_finish'];
}


// 4. Schiffsbau holen
$planetquery=$db->query('SELECT s.planet_id AS tmp3, MAX(s.finish_build) AS shipyard_active
FROM (scheduler_shipbuild s)
WHERE s.planet_id IN ('.implode(', ',$planet_ids).') GROUP BY s.planet_id');
while(($shipyard = $db->fetchrow($planetquery)))
{
	$planets[$shipyard['tmp3']]['shipyard_active']=$shipyard['shipyard_active'];
}

// 4.1 Holen des RH Inhalts
// Ja ich weis falsche Stelle und unsauber gecodet, aber funzen tuts dennoch^^
/*
$planetquery=$db->query('SELECT s.fleet_id AS tmp4, COUNT(s.ship_id) AS spacedock_full
FROM (ships s)
WHERE s.fleet_id IN ('.implode(', ',$spacedock_ids).') GROUP BY s.fleet_id');
while(($spacedock = $db->fetchrow($planetquery)))
{
	$spacedock_planets[$spacedock['tmp4']]['spacedock_full']=$spacedock['spacedock_full'];
}*/

// 21/03/08 - AC: Read planet positions from DB
// 4.2 Add distance from currently selected planet.
$planetquery = $db->query('SELECT p.planet_id AS tmp4, p.system_id,s.system_global_x, s.system_global_y
        FROM (planets p, starsystems s)
        WHERE p.planet_id IN ('.implode(', ',$planet_ids).') AND
              s.system_id = p.system_id');
while(($coordinates = $db->fetchrow($planetquery)))
{
	$planets[$coordinates['tmp4']]['system_global_x']=$coordinates['system_global_x'];
	$planets[$coordinates['tmp4']]['system_global_y']=$coordinates['system_global_y'];
}

// 5. Das Array sortieren:
foreach ($planets as $key => $row) {
   $sort[$key]  = $row['numerate'];
}
array_multisort($sort, SORT_ASC, $planets);
unset($sort);


// 6. Daten ausgeben:
foreach ($planets as $key => $planet) {

	/* 21/03/08 - AC: Add distance from currently selected planet */
	if($planet['planet_id'] != $game->planet['planet_id'])
	{
		$distance = get_distance(array($game->planet['system_global_x'], $game->planet['system_global_y']),
			array($planet['system_global_x'], $planet['system_global_y']));
		$min_time = ceil( ( ($distance / warpf(6)) / TICK_DURATION) );
		$min_stardate = sprintf('%.1f', ($game->config['stardate'] + ($min_time / 10)));
		$min_stardate_int = str_replace('.', '', $min_stardate);

		if($distance > 0)
		{
			$arrival_minutes = ($min_stardate_int - (int)str_replace('.', '', $game->config['stardate'])) * TICK_DURATION;
			$arrival_hours = 0;
			$arrival_days = floor($arrival_minutes / 1440);

			$arrival_minutes -= $arrival_days * 1440;
			while($arrival_minutes > 59) {
				$arrival_hours++;
				$arrival_minutes -= 60;
			}
		}
		else
		{
			$arrival_minutes = 20;
			$arrival_hours = 0;
			$arrival_days = 0;
		}

		//echo('Distance from '.$planet['planet_name'].': '.($distance/600).' Giorni: '.$arrival_days.' Ore: '.$arrival_hours.' Minuti: '.$arrival_minutes.'<br>');

		if($arrival_days > 0)
			$distance_str = $arrival_days.' gg ';
		else
			$distance_str = '';
		if($arrival_hours > 0)
			$distance_str .= $arrival_hours.' hh ';
		if($arrival_minutes > 0)
			$distance_str .= $arrival_minutes.' mm ';
	}
	/* */

	if ($planet['building_queue']==0) unset($planet['building_queue']);

	// Gebäude-Anzeige:
	$building=constant($game->sprache("TEXT18a"));
	$stufendreck=0;
	if (isset($planet['build_active'])) 
	{
		if($planet['build_active']==$planet['building_queue']-1) $stufendreck=1;
		$planet['building_'.($planet['build_active']+1)]++;
		$building=$BUILDING_NAME[$game->player['user_race']][$planet['build_active']].' ('.constant($game->sprache("TEXT18b")).' '.($planet['building_'.($planet['build_active']+1)]).') <b>'.Zeit(TICK_DURATION*($planet['building_finish']-$ACTUAL_TICK)).'</b><br>';
	if(isset($planet['building_queue']))
	{
		$planet_notactive=$db->query('SELECT building_1,building_2,building_3,building_4,building_5,building_queue,building_6,building_7,building_8,building_10,building_11,building_13 FROM planets WHERE planet_id='.$planet['planet_id']);
		$planet_notactive=$db->fetchrow($planet_notactive);
		$building.=$BUILDING_NAME[$game->player['user_race']][$planet['building_queue']-1].' ('.constant($game->sprache("TEXT18b")).' '.($planet['building_'.($planet['building_queue'])]+1).') <b>'.Zeit(TICK_DURATION*($planet['building_finish']-$ACTUAL_TICK+GetBuildingTimeTicks($planet['building_queue']-1,$stufendreck,$planet['planet_type'],$game->player['user_race'],$planet_notactive,$planet['research_4'])));
	}
	}
	//GetBuildingTimeTicks($planet['building_queue']-1,$planet['planet_type'],$game->player['user_race'])

	// Forschungs-Anzeige:
	$research=constant($game->sprache("TEXT18a"));
	if (isset($planet['research_id']))
	{
		if ($planet['research_id']>=5)
			$research=$ship_components[$game->player['user_race']][($planet['research_id']-5)][$planet['catresearch_'.(($planet['research_id']-4))]]['name'].' <b>'.Zeit(TICK_DURATION*($planet['research_finish']-$ACTUAL_TICK)).'</b>';
		else
		{
			$research=$TECH_NAME[$game->player['user_race']][$planet['research_id']].' <b>'.Zeit(TICK_DURATION*($planet['research_finish']-$ACTUAL_TICK)).'</b>';
		}
	}


	$outofresources=0;
	$outofspace=0;
	$academy=constant($game->sprache("TEXT18c"));
	if ($planet['unittrainid_nexttime']>0) 
	{
		if ($planet['unittrainid_'.($planet['unittrain_actual'])]<=6)
		{
			$academy=constant($game->sprache("TEXT22")).' ('.$UNIT_NAME[$game->player['user_race']][$planet['unittrainid_'.($planet['unittrain_actual'])]-1].' ';
			if ($planet['unittrain_error']==0)
			$academy.='<b>'.( ($NEXT_TICK+TICK_DURATION*60*($planet['unittrainid_nexttime']-$ACTUAL_TICK)>$NEXT_TICK+TICK_DURATION*60-ACTUAL_TICK) ? Zeit(TICK_DURATION*($planet['unittrainid_nexttime']-$ACTUAL_TICK)) : constant($game->sprache("TEXT20")) ).'</b>)';
			else
			{
				if($planet['unittrain_error']==2){
					$academy.='<br><b>'.constant($game->sprache("TEXT23")).'</b>';
					$outofspace=1;
				}
				else {
					$academy.='<b>'.constant($game->sprache("TEXT19")).'</b>)';
					$outofresources=1;
				}
				
			}

		}
		else
		{
			$text=(TICK_DURATION).constant($game->sprache("TEXT21"));
			if ($planet['unittrainid_'.($planet['unittrain_actual'])]==11) $text=(TICK_DURATION).constant($game->sprache("TEXT21"));
			if ($planet['unittrainid_'.($planet['unittrain_actual'])]==12) $text=(TICK_DURATION).constant($game->sprache("TEXT21"));
			$academy= constant($game->sprache("TEXT22")).' ('.$text.' <b>'.Zeit(TICK_DURATION*($planet['unittrainid_nexttime']-$ACTUAL_TICK)).'</b>)';
		}

		// ALT, habs mal geändert, sollte nun besser passen. Gruß Mojo ;)
		/*$unitcount=($planet['unit_1']*2+$planet['unit_2']*3+$planet['unit_3']*4+$planet['unit_4']*4+$planet['unit_5']*4+$planet['unit_6']*4);
		if ($unitcount>$planet['max_units']-4)
		{
			
		}*/

	}

	if (isset($planet['shipyard_active']))
	{
		$shipbuild=constant($game->sprache("TEXT24")).'<br><b>'.Zeit(TICK_DURATION*($planet['shipyard_active']-$ACTUAL_TICK)).'</b>';
	}
	// Farben für die Symbole festlegen
	if(isset($planet['building_queue'])){ $building_color=(($planet['building_finish']-$ACTUAL_TICK+GetBuildingTimeTicks($planet['building_queue']-1,$stufendreck,$planet,$game->player['user_race'],$planet_notactive,$planet['research_4'])))/12;
	}else{
	$building_color=($planet['building_finish']-$ACTUAL_TICK)/12;
	}
	if ($building_color>8) $building_color=8;
	if ($building_color<0) $building_color=0;
	$building_color='#80'.dechex(128+16*$building_color-1).'80';

	$research_color=($planet['research_finish']-$ACTUAL_TICK)/12;
	if ($research_color>8) $research_color=8;
	if ($research_color<0) $research_color=0;
	$research_color='#80'.dechex(128+16*$research_color-1).'80';

	$shipyard_color=($planet['shipyard_active']-$ACTUAL_TICK)/12;
	if ($shipyard_color>8) $shipyard_color=8;
	if ($shipyard_color<0) $shipyard_color=0;
	$shipyard_color='#80'.dechex(128+16*$shipyard_color-1).'80';


	// Ausgabe von Baustatus, etc:
	$status='<table border=0 cellpadding=0 cellspacing=0><tr>';
	if (isset($planet['build_active'])) $status.='<td width=12><a href="javascript:void(0);" onmouseover="return overlib(\''.$building.'\', CAPTION, \''.constant($game->sprache("TEXT25")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color='.$building_color.'>'.constant($game->sprache("TEXT29")).'</font></a></td>'; else $status.='<td width=12>&nbsp;</td>';
	if (isset($planet['research_id'])) $status.='<td width=12><a href="javascript:void(0);" onmouseover="return overlib(\''.$research.'\', CAPTION, \''.constant($game->sprache("TEXT26")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color='.$research_color.'>'.constant($game->sprache("TEXT30")).'</font></a></td>'; else $status.='<td width=12>&nbsp;</td>';
	if ($planet['unittrainid_nexttime']>0) $status.='<td width=12><a href="javascript:void(0);" onmouseover="return overlib(\''.$academy.'\', CAPTION, \''.constant($game->sprache("TEXT27")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.($outofresources ? (($outofspace==1) ? '<font color=#ff8080>'.constant($game->sprache("TEXT31")).'</font>' : '<font color=#ffff80>'.constant($game->sprache("TEXT31")).'</font>') : (($outofspace==1) ? '<font color=#ff8080>'.constant($game->sprache("TEXT31")).'</font>' : '<font color=#80ff80>'.constant($game->sprache("TEXT31")).'</font>') ).'</a></td>'; else $status.='<td width=12>&nbsp;</td>';
	if (isset($planet['shipyard_active'])) $status.='<td width=12><a href="javascript:void(0);" onmouseover="return overlib(\''.$shipbuild.'\', CAPTION, \''.constant($game->sprache("TEXT28")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color='.$shipyard_color.'>'.constant($game->sprache("TEXT32")).'</font></a></td>'; else $status.='<td width=12>&nbsp;</td>';
	

	// Ausgabe der Sicherheitstruppenanzeige
	if (round($planet['unit_1'] * 2 + $planet['unit_2'] * 3 + $planet['unit_3'] * 4 + $planet['unit_4'] * 4, 0)<$planet['min_security_troops']) 
	{
		$percent=round($planet['unit_1'] * 2 + $planet['unit_2'] * 3 + $planet['unit_3'] * 4 + $planet['unit_4'] * 4, 0)/$planet['min_security_troops'];
		if ($planet['planet_insurrection_time']-time()>3600*48 && ( $percent<0.3 || ($percent<0.7 && $planet['planet_points']<30) ) )
			$status.='<td width=21><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT33")).' '.round($planet['unit_1'] * 2 + $planet['unit_2'] * 3 + $planet['unit_3'] * 4 + $planet['unit_4'] * 4, 0).'<br>'.constant($game->sprache("TEXT34")).' '.$planet['min_security_troops'].'\', CAPTION, \''.constant($game->sprache("TEXT35")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_revolution_small.gif" border=0></a></td>';
		else
			$status.='<td width=21><a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT33")).' '.round($planet['unit_1'] * 2 + $planet['unit_2'] * 3 + $planet['unit_3'] * 4 + $planet['unit_4'] * 4, 0).'<br>'.constant($game->sprache("TEXT34")).' '.$planet['min_security_troops'].'\', CAPTION, \''.constant($game->sprache("TEXT36")).'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_fight_small.gif" border=0></a></td>';
	}
	$status.='</tr></table>';

	$tax=$db->queryrow('SELECT taxes FROM alliance WHERE alliance_id = '.$game->player['user_alliance'].'');


	// Anzeige der Ressourcen
	if ($game->option_retr('planetlist_show')==0){ 
		$stat_out='<img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.(($planet['resource_1']>=100000) ? round($planet['resource_1']/1000).'k' : round($planet['resource_1'],0)).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.(($planet['resource_2']>=100000) ? round($planet['resource_2']/1000).'k' : round($planet['resource_2'],0)).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">'.(($planet['resource_3']>=100000) ? round($planet['resource_3']/1000).'k' : round($planet['resource_3'],0)).'
		<img src="'.$game->GFX_PATH.'menu_worker_small.gif">'.round($planet['resource_4'],0).'';
	}
	// Anzeige des Truppenstatus
	elseif($game->option_retr('planetlist_show')==1){
		$stat_out='<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">'.round($planet['unit_1'],0).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">'.round($planet['unit_2'],0).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">'.round($planet['unit_3'],0).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">'.round($planet['unit_4'],0).'&nbsp;&nbsp;
		<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">'.round($planet['unit_5'],0).'&nbsp;
		<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">'.round($planet['unit_6'],0);
	}
	elseif($game->option_retr('planetlist_show')==2){
		$stat_out='<b>'.$planet['planet_altname'].'</b>&nbsp';
	}
	else {
		$stat_out='<b><img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.$planet['add_1']*((100-$tax['taxes'])/100).'&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.$planet['add_2']*((100-$tax['taxes'])/100).'&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.$planet['add_3']*((100-$tax['taxes'])/100).'&nbsp;<img src="'.$game->GFX_PATH.'menu_worker_small.gif">&nbsp;'.$planet['add_4'].'</b>&nbsp';
	}

	$metallo  = $metallo + $planet['resource_1'];
	$minerali = $minerali  + $planet['resource_2'];
	$dilitio = $dilitio + $planet['resource_3'];
	$lavoratori = $lavoratori + $planet['resource_4'];

	$unita1 = $unita1 + round($planet['unit_1'],0);
	$unita2 = $unita2 + round($planet['unit_2'],0);
	$unita3 = $unita3 + round($planet['unit_3'],0);
	$unita4 = $unita4 + round($planet['unit_4'],0);
	$unita5 = $unita5 + round($planet['unit_5'],0);
	$unita6 = $unita6 + round($planet['unit_6'],0);

	// Anzeige der Koordinaten und des Wechselsymbols:
	if ($game->planet['planet_id']==$planet['planet_id'])
	{
		$game->out('
			<tr><td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet['planet_id'])).'"><b>'.$planet['planet_name'].'</b></a></td><td></td>
			<td>'.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'],$planet['system_y']).':'.($planet['planet_distance_id'] + 1).'</td>
			<td></td>
			<td>'.$stat_out.'&nbsp;&nbsp;');
	}
	else
	{
		$game->out('
			<tr height=20><td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet['planet_id'])).'">'.$planet['planet_name'].'</a></td><td>[<a href="'.parse_link('a=headquarter&switch_active_planet='.$planet['planet_id']).'" title="'.constant($game->sprache("TEXT37")).'">'.constant($game->sprache("TEXT38")).'</a>]</td>
			<td>'.$game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'],$planet['system_y']).':'.($planet['planet_distance_id'] + 1).'</td>
			<td>'.$distance_str.'</td>
			<td>'.$stat_out.'&nbsp;&nbsp;');
	}

	// Ausgabe des Baustatus von oben etc. sowie die Anzeige bei drohendem Angriff (wird im Scheduler gesetzt):
	$attack=$planet['planet_next_attack'];
	if ($game->option_retr('redalert_options')==2) $attack=0;
	if ($game->option_retr('redalert_options')==1 && $attack-date()>3600*24*7) $attack=0;
	$game->out('</td><td>'.( $attack>0 ? '<font color=red><b>'.constant($game->sprache("TEXT39")).' </b>'.date('d.m.y H:i', ($attack)).'</font></b><br>' : '').$status.'</td><td>'.$planet['planet_points'].'</td><td>'.strtoupper($planet['planet_type']).'</td></tr>');

} // Ende der Planetentabelle

function conversione ($risorsa) {
if ($risorsa >= 1000000) $risorsa = round($risorsa/1000000,2).' Mio.';
elseif ($risorsa >= 1000) $risorsa= round($risorsa/1000,0).'k';
else $risorsa= round($risorsa,0);
return ($risorsa);
}


$metallo = conversione($metallo);
$minerali = conversione($minerali);
$dilitio = conversione($dilitio);

$game->out('<tr><td colspan=8><hr color=#FFFFFF size=1>

<tr>
<td colspan=8><fieldset><legend>'.constant($game->sprache("TEXT40")).'</legend>
<table border=0 cellpadding=0 cellspacing=0 widtH=500>
<tr>
<td align=center><img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;<b>'.$metallo.'</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;<b>'.$minerali.'</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;<b>'.$dilitio.'</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_worker_small.gif">&nbsp;<b>'.round($lavoratori,0).'</td>
</tr>
</table>
<table border=0 cellpadding=0 cellspacing=0 widtH=500>
<tr>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;<b>'.round($unita1,0).'&nbsp;</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;<b>'.round($unita2,0).'&nbsp;</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;<b>'.round($unita3,0).'&nbsp;</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;<b>'.round($unita4,0).'&nbsp;&nbsp;</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;<b>'.round($unita5,0).'&nbsp;</td>
<td align=center><img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;<b>'.round($unita6,0).'</td>
</tr>
</table>

</fieldset></tr>');

// Optionen zur Sortierung etc.:
$game->out('</table></td></tr></table><br><br>
<table border=0 cellpadding=1 cellspacing=1 class="style_outer"><tr><td>
<table border=0 cellpadding=1 cellspacing=1 class="style_inner">
<tr valign=top><td width=120><b>'.constant($game->sprache("TEXT41")).'</b><br>
<a href="'.parse_link('a=planetlist&s_o=0').'">'.($game->option_retr('planetlist_order')==0 ? '<u>' : '').''.constant($game->sprache("TEXT42")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=1').'">'.($game->option_retr('planetlist_order')==1 ? '<u>' : '').''.constant($game->sprache("TEXT43")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=2').'">'.($game->option_retr('planetlist_order')==2 ? '<u>' : '').''.constant($game->sprache("TEXT44")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=3').'">'.($game->option_retr('planetlist_order')==3 ? '<u>' : '').''.constant($game->sprache("TEXT45")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=4').'">'.($game->option_retr('planetlist_order')==4 ? '<u>' : '').''.constant($game->sprache("TEXT46")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=5').'">'.($game->option_retr('planetlist_order')==5 ? '<u>' : '').''.constant($game->sprache("TEXT47")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_o=6').'">'.($game->option_retr('planetlist_order')==6 ? '<u>' : '').''.constant($game->sprache("TEXT48")).'</u></a><br>

</td><td width=120><b>'.constant($game->sprache("TEXT49")).'</b><br>
<a href="'.parse_link('a=planetlist&s_s=0').'">'.($game->option_retr('planetlist_show')==0 ? '<u>' : '').''.constant($game->sprache("TEXT50")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_s=1').'">'.($game->option_retr('planetlist_show')==1 ? '<u>' : '').''.constant($game->sprache("TEXT51")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_s=2').'">'.($game->option_retr('planetlist_show')==2 ? '<u>' : '').''.constant($game->sprache("TEXT48")).'</u></a><br>
<a href="'.parse_link('a=planetlist&s_s=3').'">'.($game->option_retr('planetlist_show')==3 ? '<u>' : '').''.constant($game->sprache("TEXT52")).'</u></a><br>
</td>
</td><td width=120><b>'.constant($game->sprache("TEXT53")).'</b><br>
'.(($game->SITTING_MODE) ? '' :'<a href="'.parse_link('a=planetlist&s_op=0').'">').($game->option_retr('redalert_options')==0 ? '<u>' : '').''.constant($game->sprache("TEXT54")).'</u>'.(($game->SITTING_MODE) ? '' :'</a>').'<br>
'.(($game->SITTING_MODE) ? '' :'<a href="'.parse_link('a=planetlist&s_op=1').'">').($game->option_retr('redalert_options')==1 ? '<u>' : '').''.constant($game->sprache("TEXT55")).'</u>'.(($game->SITTING_MODE) ? '' :'</a>').'<br>
'.(($game->SITTING_MODE) ? '' :'<a href="'.parse_link('a=planetlist&s_op=2').'">').($game->option_retr('redalert_options')==2 ? '<u>' : '').''.constant($game->sprache("TEXT56")).'</u>'.(($game->SITTING_MODE) ? '' :'</a>').'
</td>
</tr>
</table>
</td>
</tr>
</table>
');

?>
