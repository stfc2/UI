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
$capital=(($game->player['user_capital']==$game->planet['planet_id']) ? 1 : 0);
if ($game->player['pending_capital_choice']) $capital=0;

include('include/static/static_components_'.$game->player['user_race'].'.php');



function CalculateFreeUnits()
{
global $db;
global $game;
global $PLANETS_DATA, $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$free_units = (($PLANETS_DATA[$game->planet['planet_type']][7])+($game->planet['research_1']*$RACE_DATA[$game->player['user_race']][20]*500));
$free_units -=($game->planet['unit_1']*2+$game->planet['unit_2']*3+$game->planet['unit_3']*4+$game->planet['unit_4']*4+$game->planet['unit_5']*4+$game->planet['unit_6']*4);
return $free_units;
}




$change_error='';
if (isset($_REQUEST['exec_namechange']) && isset($_REQUEST['planet_name']) && !empty($_REQUEST['planet_name']) && isset($_REQUEST['planet_altname']))
{
    for ($count=0; $count < strlen($_REQUEST['planet_name']); $count++) {
       $val=ord( (substr($_REQUEST['planet_name'], $count, 1)) );
       if (($val>21 && $val<28) || ($val>93 && $val<97) || $val>122 || $val==92)
       {
        $change_error='<br><font color=red>* Planetenname enthält unzulässige Zeichen</font>';
	}
    }
    for ($count=0; $count < strlen($_REQUEST['planet_altname']); $count++) {
       $val=ord( (substr($_REQUEST['planet_altname'], $count, 1)) );
       if (($val>21 && $val<28) || ($val>93 && $val<97) || $val>122 || $val==92)
        {
        $change_error='<br><font color=red>* Planetebezeichnung enthält unzulässige Zeichen</font>';
	}
    }
	if (empty($change_error))
	{
	  $db->query('UPDATE planets SET planet_name="'.htmlspecialchars(addslashes($_REQUEST['planet_name'])).'", planet_altname="'.htmlspecialchars(addslashes($_REQUEST['planet_altname'])).'" WHERE planet_id= "'.$game->planet['planet_id'].'"');
  	  redirect('a=headquarter');
	}
}


$game->out('<center><span class="caption">'.$BUILDING_NAME[$game->player['user_race']][0].':</span></center><br>');



$game->out('<center><span class="sub_caption">Statistiken für <u>'.$game->planet['planet_name'].'</u><br></span>');
$game->out('<center>Bezeichnung <u>'.$game->planet['planet_altname'].'</u><br>');
if ($capital) $game->out('<span class="sub_caption">(Heimatplanet)');
$game->out('</span></center><br><br>');


$system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$game->planet['system_id']);
$position=$game->get_sector_name($game->planet['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($game->planet['planet_distance_id'] + 1);
$m_points=$MAX_POINTS[0];
if ($game->player['user_capital']==$game->planet['planet_id']) $m_points=$MAX_POINTS[1];



// "Wird gebaut" Anzeige:
$building='nichts';
$build=$db->queryrow('SELECT installation_type, build_finish FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0) $building=$BUILDING_NAME[$game->player['user_race']][$build['installation_type']].' (Stufe '.($game->planet['building_'.($build['installation_type']+1).'']+1).') <b id="timer2" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($build['build_finish']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';



$research='nichts';
$scheduler=$db->queryrow('SELECT * FROM scheduler_research WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
if ($scheduler['research_id']>=5) 
$research=$ship_components[$game->player['user_race']][($scheduler['research_id']-5)][$game->planet['catresearch_'.(($scheduler['research_id']-4))]]['name'].' <b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';
else $research=$TECH_NAME[$game->player['user_race']][$scheduler['research_id']].' <b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';



$academy='inaktiv';
if ($game->planet['unittrainid_nexttime']>0) {
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]<=6)
{
$academy='aktiv ('.$UNIT_NAME[$game->player['user_race']][$game->planet['unittrainid_'.($game->planet['unittrain_actual'])]-1].') ';
if ($game->planet['unittrain_error']==0)
$academy.='<b id="timer5" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';
else {

if($game->planet['unittrain_error']==1) {
  $academy.='<b>Ressourcenmangel</b>';
}
else {
  $academy.='<br><b>Fertiggestellt - Planetenlimit erreicht</b>';
}
}
}
else
{
$text='3 Min. Pause';
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==11) $text='27 Min. Pause';
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==12) $text='54 Min. Pause';
$academy='aktiv ('.$text.') <b id="timer5" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';
}
}



$shipbuild='nichts';
$schedulerquery=$db->query('SELECT * FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (start_build<='.$ACTUAL_TICK.') ORDER BY start_build ASC LIMIT 1');
if ($db->num_rows()>0)
{
$scheduler = $db->fetchrow($schedulerquery);
$template=$db->queryrow('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$scheduler['ship_type'].'")');
$shipbuild=$template['name'].' <b id="timer4" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['finish_build']-$ACTUAL_TICK)).'_type1_2">&nbsp;</b>';
}



$game->out('
<center>
<table border=0 cellpadding=1 cellspacing=1 class="style_inner">
<tr>
<td width=300>
<u>Gebäude:</u>&nbsp;'.$building.'<br>
<u>Forschung:</u>&nbsp;'.$research.'<br>
<u>'.$BUILDING_NAME[$game->player['user_race']][5].':</u>&nbsp;'.$academy.'<br>
<u>'.$BUILDING_NAME[$game->player['user_race']][7].':</u>&nbsp;'.$shipbuild.'<br>

</td>
</tr>
</table><br>
');





// Hauptanzeige:
$game->out('
<center><table border=0 cellpadding=1 cellaspacing=1 class="style_outer">
<tr>
<td width=450>

<table border=0 cellspacing=0 cellpadding=0 class="style_inner">
<tr>
<td width=250 align=left valign=top>

<table border=0><tr><td width=125>
<span class="sub_caption2">Allgemein:</span><br>
<a href="'.$game->GFX_PATH.'planet_type_'.$game->planet['planet_type'].'.gif" target=_blank ><img src="'.$game->GFX_PATH.'planet_type_'.$game->planet['planet_type'].'.gif" width="80" height="80" border="0"></a><br>
</td>
<td width=125 valign=top>
<form method="post" action="'.parse_link('a=headquarter').'">
<b><u>Namen ändern:</u></b><input type="text" name="planet_name" size="18" class="field_nosize" value="'.$game->planet['planet_name'].'"><br><b><u>Bezeichnung ändern:</u></b><br><input type="text" name="planet_altname" size="18" class="field_nosize" value="'.$game->planet['planet_altname'].'"><br>
<input type="submit" name="exec_namechange" class="button_nosize" width=45 value="Save">'.$change_error.'</form>
</td>
</tr>
</table>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dies gibt die Position in der Galaxie an<br>Sektor-Position : System-Position : Position im Sonnensystem\', CAPTION, \'Position/Koordinaten:\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Koordinaten:</b></a> <u>'.$position.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dieser Wert gibt an, wieviele Rohstoffe von jedem Typ maximal auf dem Planeten gelagert werden können.<br>Dieser Wert ist festgesetzt und lässt sich nur durch Ausbau der '.$BUILDING_NAME[$game->player['user_race']][11].' verändern.\', CAPTION, \'Maximale Ressourcen\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Max. Ressourcen:</b></a> <u>'.$game->planet['max_resources'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dieser Wert gibt an, wieviele der maximalen Kampfeinheiten auf dem Planeten noch unbesetzt sind.<br>Diese Zahl variiert von Planet zu Planet und kann durch Terraforming um bis zu 5000 erhöht werden.<br>Je nach Einheitentyp werden unterschiedlich viele Plätze besetzt:<br>'.$UNIT_NAME[''.$game->player['user_race'].''][0].' benötigt 2 Plätze<br>'.$UNIT_NAME[''.$game->player['user_race'].''][1].' benötigt 3 Plätze<br>'.$UNIT_NAME[''.$game->player['user_race'].''][2].' benötigt 4 Plätze<br>'.$UNIT_NAME[''.$game->player['user_race'].''][3].' benötigt 4 Plätze<br>'.$UNIT_NAME[''.$game->player['user_race'].''][4].' benötigt 4 Plätze<br>'.$UNIT_NAME[''.$game->player['user_race'].''][5].' benötigt 4 Plätze<br>\', CAPTION, \'Freie Einheiten\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Freie Einheiten:</b></a> <u>'.CalculateFreeUnits().'/'.$game->planet['max_units'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dieser Wert gibt an, wieviele der maximalen Arbeiter auf dem Planeten noch unbesetzt sind.<br>Diese Zahl variiert von Planet zu Planet und kann durch Terraforming um bis zu 5000 erhöht werden.\', CAPTION, \'Freie Arbeiter\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Freie Arbeiter:</b></a> <u>'.round(($PLANETS_DATA[$game->planet['planet_type']][7]+($game->planet['research_1']*$RACE_DATA[$game->player['user_race']][20])*500)-$game->planet['resource_4'],0).'/'.$game->planet['max_worker'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dieser Wert gibt an, wie stark Angriffs- und Verteidigungswerte der orbitalen Geschütze sind:<br><br><u><b>'.$game->planet['building_13'].'</b> von <b>'.$MAX_BUILDING_LVL[$capital][12].'</b> Plattformen mit:<br></u>'.SPLANETARY_DEFENSE_ATTACK.' Leichte Waffen<br>'.SPLANETARY_DEFENSE_DEFENSE.' Regenerative Hülle<br><i>* 100% Erstschlagschance</i>\', CAPTION, \'Kl. Orbitale Geschütze\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Kl. Orbit. Geschütze:</b></a> <u>'.$game->planet['building_13'].'x '.SPLANETARY_DEFENSE_ATTACK.' - '.SPLANETARY_DEFENSE_DEFENSE.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dieser Wert gibt an, wie stark Angriffs- und Verteidigungswerte der orbitalen Geschütze sind:<br><br><u><b>'.$game->planet['building_10'].'</b> von <b>'.$MAX_BUILDING_LVL[$capital][9].'</b> Plattformen mit:<br></u>'.PLANETARY_DEFENSE_ATTACK.' Leichte Waffen<br>'.PLANETARY_DEFENSE_ATTACK2.' Schwere Waffen<br>'.PLANETARY_DEFENSE_DEFENSE.' Regenerative Hülle<br><i>* 100% Erstschlagschance</i>\', CAPTION, \'Orbitale Geschütze\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Orbit. Geschütze:</b></a> <u>'.$game->planet['building_10'].'x '.PLANETARY_DEFENSE_ATTACK.' - '.PLANETARY_DEFENSE_DEFENSE.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\'Dies sind die aktuellen Punkte des Planeten. Die Zahlen werden alle 3 Minuten aktualisiert.\', CAPTION, \'Punkte\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>Punkte:</b></a> <u>'.$game->planet['planet_points'].'/'.$m_points.'</u>


</td>
<td width=200>

<table border=0 cellspacing=0 cellpadding=0>
<tr><td valign=top><b><u>Klasse:</b></u><br>'.strtoupper($game->planet['planet_type']).' ('.$PLANETS_TEXT[$game->planet['planet_type']][0].')</td></tr>
<tr><td valign=top><b><u>Leben:</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][1].'</td></tr>
<tr><td valign=top><b><u>Rohstoffe:</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][2].'</td></tr>
<tr><td valign=top><b><u>Beschreibung:</b></u><br><a href="javascript:void(0);" onmouseover="return overlib(\''.$PLANETS_TEXT[$game->planet['planet_type']][3].'\',CAPTION,\'Beschreibung\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.substr($PLANETS_TEXT[$game->planet['planet_type']][3],0,40).'...</a></td></tr>
<tr><td valign=top><b><u>Beispiele:</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][4].'</td></tr>
</table>




</td>
</tr>

<tr height=20>
<td>
</td>
<td>
</td>
</tr>

<tr>
<td valign=top>
<span class="sub_caption2">Gebäude:</span><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][0],$BUILDING_DESCRIPTION[$game->player['user_race']][0]).' <b>('.$game->planet['building_1'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][1],$BUILDING_DESCRIPTION[$game->player['user_race']][1]).' <b>('.$game->planet['building_2'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][2],$BUILDING_DESCRIPTION[$game->player['user_race']][2]).' <b>('.$game->planet['building_3'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][3],$BUILDING_DESCRIPTION[$game->player['user_race']][3]).' <b>('.$game->planet['building_4'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][4],$BUILDING_DESCRIPTION[$game->player['user_race']][4]).' <b>('.$game->planet['building_5'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][5],$BUILDING_DESCRIPTION[$game->player['user_race']][5]).' <b>('.$game->planet['building_6'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][6],$BUILDING_DESCRIPTION[$game->player['user_race']][6]).' <b>('.$game->planet['building_7'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][7],$BUILDING_DESCRIPTION[$game->player['user_race']][7]).' <b>('.$game->planet['building_8'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][8],$BUILDING_DESCRIPTION[$game->player['user_race']][8]).' <b>('.$game->planet['building_9'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][12],$BUILDING_DESCRIPTION[$game->player['user_race']][12]).' <b>('.$game->planet['building_13'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][9],$BUILDING_DESCRIPTION[$game->player['user_race']][9]).' 
<b>('.$game->planet['building_10'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][10],$BUILDING_DESCRIPTION[$game->player['user_race']][10]).' <b>('.$game->planet['building_11'].')</b><br>
'.overlib($BUILDING_NAME[$game->player['user_race']][11],$BUILDING_DESCRIPTION[$game->player['user_race']][11]).' <b>('.$game->planet['building_12'].')</b><br>');

$game->out('<br><span class="sub_caption2">Truppen:</span><br>');

for ($t=0; $t<6; $t++)
$game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>Angriff:</u> '.GetAttackUnit($t).' (Standard: '.$UNIT_DATA[$t][5].')<br><u>Verteidigung:</u> '.GetDefenseUnit($t).' (Standard: '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$UNIT_NAME[$game->player['user_race']][$t].' <b>('.$game->planet['unit_'.($t+1).''].')</a></b><br>');

$game->out('</td>
<td valign=top>
<span class="sub_caption2">Technologien:</span><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][0].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][0].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][0].' <b>('.$game->planet['research_1'].')</b></a><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][1].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][1].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][1].' <b>('.$game->planet['research_2'].')</b></a><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][2].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][2].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][2].' <b>('.$game->planet['research_3'].')</b></a><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][3].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][3].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][3].' <b>('.$game->planet['research_4'].')</b></a><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][4].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][4].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][4].' <b>('.$game->planet['research_5'].')</b></a><br>
<br><span class="sub_caption2">Komponenten:</span><br>
');




foreach ($ship_components[$game->player['user_race']] as $key => $components)
{
$cname=$components['name'];
if (strlen($cname)>13)
{
$cname=substr($cname, 0,11);
$cname.='..';
}
$text='';
for ($t=0; $t<$game->planet['catresearch_'.($key+1)]; $t++)
{
$text.='- '.$components[$t]['name'].'<br>';
}
$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$text.'\',CAPTION,\''.$cat['name'].'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$cname;
$game->out($catname.'&nbsp <b>('.round(100/$components['num']*$game->planet['catresearch_'.($key+1)],0).'%)</a></b><br>');
}




$game->out('
</td>
</tr>
</table>

</td>
</tr>
</table>
');

?>
