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
$filename = 'include/static/static_components_'.$game->player['user_race'].'_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);



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
/*    for ($count=0; $count < strlen($_REQUEST['planet_name']); $count++) {
        $val=ord( (substr($_REQUEST['planet_name'], $count, 1)) );
        if (($val>21 && $val<28) || ($val>93 && $val<97) || $val>122 || $val==92)
        {
            $change_error='<br><font color=red>'.constant($game->sprache("TEXT1")).'</font>';
        }
    }
    for ($count=0; $count < strlen($_REQUEST['planet_altname']); $count++) {
        $val=ord( (substr($_REQUEST['planet_altname'], $count, 1)) );
        if (($val>21 && $val<28) || ($val>93 && $val<97) || $val>122 || $val==92)
        {
            $change_error='<br><font color=red>'.constant($game->sprache("TEXT2")).'</font>';
        }
    }*/
    if (empty($change_error))
    {
        $db->query('UPDATE planets SET planet_name="'.htmlspecialchars($_REQUEST['planet_name']).'", planet_altname="'.htmlspecialchars($_REQUEST['planet_altname']).'" WHERE planet_id= "'.$game->planet['planet_id'].'"');
        redirect('a=headquarter');
    }
}


$game->out('<span class="caption">'.$BUILDING_NAME[$game->player['user_race']][0].':</span><br><br>');



$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT3")).' <u>'.$game->planet['planet_name'].'</u><br></span>');
$game->out(constant($game->sprache("TEXT4")).' <u>'.$game->planet['planet_altname'].'</u><br>');
if ($capital) $game->out('<span class="sub_caption">('.constant($game->sprache("TEXT5")).')');
$game->out('</span><br><br>');


$system=$db->queryrow('SELECT system_x, system_y FROM starsystems WHERE system_id = '.$game->planet['system_id']);
$position=$game->get_sector_name($game->planet['sector_id']).':'.$game->get_system_cname($system['system_x'],$system['system_y']).':'.($game->planet['planet_distance_id'] + 1);
$m_points=$MAX_POINTS[0];
if ($game->player['user_capital']==$game->planet['planet_id']) $m_points=$MAX_POINTS[1];



// "If built" display:
$building=constant($game->sprache("TEXT6"));
$build=$db->queryrow('SELECT installation_type, build_finish FROM scheduler_instbuild WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0) $building=$BUILDING_NAME[$game->player['user_race']][$build['installation_type']].' ('.constant($game->sprache("TEXT6a")).' '.($game->planet['building_'.($build['installation_type']+1).'']+1).')</td><td><b id="timer2" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($build['build_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';



$research=constant($game->sprache("TEXT6"));
$scheduler=$db->queryrow('SELECT * FROM scheduler_research WHERE planet_id="'.$game->planet['planet_id'].'"');
if ($db->num_rows()>0)
if ($scheduler['research_id']>=5) 
$research=$ship_components[$game->player['user_race']][($scheduler['research_id']-5)][$game->planet['catresearch_'.(($scheduler['research_id']-4))]]['name'].'</td><td><b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';
else $research=$TECH_NAME[$game->player['user_race']][$scheduler['research_id']].'</td><td><b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['research_finish']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';



$academy=constant($game->sprache("TEXT7"));
if ($game->planet['unittrainid_nexttime']>0) {
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]<=6)
{
$academy=constant($game->sprache("TEXT8")).' ('.$UNIT_NAME[$game->player['user_race']][$game->planet['unittrainid_'.($game->planet['unittrain_actual'])]-1].') ';
if ($game->planet['unittrain_error']==0)
$academy.='</td><td><b id="timer5" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';
else {

if($game->planet['unittrain_error']==1) {
  $academy.='<b>'.constant($game->sprache("TEXT9")).'</b>';
}
else {
  $academy.='<br><b>'.constant($game->sprache("TEXT10")).'</b>';
}
}
}
else
{
$text='3 Min. Pause';
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==11) $text='27 Min. Pause';
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==12) $text='54 Min. Pause';
$academy=constant($game->sprache("TEXT8")).' ('.$text.')</td><td><b id="timer5" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';
}
}



$shipbuild=constant($game->sprache("TEXT7"));
$schedulerquery=$db->query('SELECT * FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (start_build<='.$ACTUAL_TICK.') ORDER BY start_build ASC LIMIT 1');
if ($db->num_rows()>0)
{
$scheduler = $db->fetchrow($schedulerquery);
$template=$db->queryrow('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$scheduler['ship_type'].'")');
$shipbuild=$template['name'].'</td><td><b id="timer4" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['finish_build']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>';
}






// Main Display:
$game->out('
<table border=0 cellpadding=1 cellaspacing=1 class="style_outer">
<tr>
<td width=450>

<table border=0 cellspacing=0 cellpadding=0 class="style_inner">
<tr>
<td width=250 align=left valign=top>

<table border=0><tr><td width=125>
<span class="sub_caption2">'.constant($game->sprache("TEXT12")).':</span><br>
<a href="'.$game->PLAIN_GFX_PATH.'planet_type_'.$game->planet['planet_type'].'.png" target=_blank ><img src="'.$game->PLAIN_GFX_PATH.'planet_type_'.$game->planet['planet_type'].'.png" width="80" height="80" border="0"></a><br>
</td>
<td width=125 valign=top>
<form method="post" action="'.parse_link('a=headquarter').'">
<b><u>'.constant($game->sprache("TEXT13")).':</u></b><input type="text" name="planet_name" size="18" class="field_nosize" value="'.$game->planet['planet_name'].'"><br><b><u>'.constant($game->sprache("TEXT14")).':</u></b><br><input type="text" name="planet_altname" size="18" class="field_nosize" value="'.$game->planet['planet_altname'].'"><br>
<input type="submit" name="exec_namechange" class="button_nosize" width=45 value="'.constant($game->sprache("TEXT15")).'">'.$change_error.'</form>
</td>
</tr>
</table>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT23")).'\', CAPTION, \''.constant($game->sprache("TEXT24")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT16")).':</b></a> <u>'.$position.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT25")).' '.$BUILDING_NAME[$game->player['user_race']][11].'.\', CAPTION, \''.constant($game->sprache("TEXT26")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT17")).':</b></a> <u>'.$game->planet['max_resources'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT27")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][0].' '.constant($game->sprache("TEXT28")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][1].' '.constant($game->sprache("TEXT29")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][2].' '.constant($game->sprache("TEXT30")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][3].' '.constant($game->sprache("TEXT30")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][4].' '.constant($game->sprache("TEXT30")).'<br>'.$UNIT_NAME[''.$game->player['user_race'].''][5].' '.constant($game->sprache("TEXT30")).'<br>\', CAPTION, \''.constant($game->sprache("TEXT31")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT18")).':</b></a> <u>'.CalculateFreeUnits().'/'.$game->planet['max_units'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT32")).'\', CAPTION, \''.constant($game->sprache("TEXT33")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT19")).':</b></a> <u>'.round(($PLANETS_DATA[$game->planet['planet_type']][7]+($game->planet['research_1']*$RACE_DATA[$game->player['user_race']][20])*500)-$game->planet['resource_4'],0).'/'.$game->planet['max_worker'].'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT34")).'<br><br><u><b>'.$game->planet['building_13'].'</b> '.constant($game->sprache("TEXT35")).' <b>'.$MAX_BUILDING_LVL[$capital][12].'</b> '.constant($game->sprache("TEXT36")).'<br></u>'.SPLANETARY_DEFENSE_ATTACK.' '.constant($game->sprache("TEXT37")).'<br>'.SPLANETARY_DEFENSE_DEFENSE.' '.constant($game->sprache("TEXT38")).'<br><i>'.constant($game->sprache("TEXT39")).'</i>\', CAPTION, \''.constant($game->sprache("TEXT40")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT20")).':</b></a> <u>'.$game->planet['building_13'].'x '.SPLANETARY_DEFENSE_ATTACK.' - '.SPLANETARY_DEFENSE_DEFENSE.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT34")).'<br><br><u><b>'.$game->planet['building_10'].'</b> '.constant($game->sprache("TEXT35")).' <b>'.$MAX_BUILDING_LVL[$capital][9].'</b> '.constant($game->sprache("TEXT36")).'<br></u>'.PLANETARY_DEFENSE_ATTACK.' '.constant($game->sprache("TEXT37")).'<br>'.PLANETARY_DEFENSE_ATTACK2.' '.constant($game->sprache("TEXT41")).'<br>'.PLANETARY_DEFENSE_DEFENSE.' '.constant($game->sprache("TEXT38")).'<br><i>'.constant($game->sprache("TEXT39")).'</i>\', CAPTION, \''.constant($game->sprache("TEXT42")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT21")).':</b></a> <u>'.$game->planet['building_10'].'x '.PLANETARY_DEFENSE_ATTACK.' - '.PLANETARY_DEFENSE_DEFENSE.'</u><br>
<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT43")).'\', CAPTION, \''.constant($game->sprache("TEXT44")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.constant($game->sprache("TEXT22")).':</b></a> <u>'.$game->planet['planet_points'].'/'.$m_points.'</u>


</td>
<td width=200>

<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT54")).':</span></legend>
<table border=0 cellspacing=0 cellpadding=0>
<tr><td valign=top><b><u>'.constant($game->sprache("TEXT45")).':</b></u><br>'.strtoupper($game->planet['planet_type']).' ('.$PLANETS_TEXT[$game->planet['planet_type']][0].')</td></tr>
<tr><td valign=top><b><u>'.constant($game->sprache("TEXT46")).':</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][1].'</td></tr>
<tr><td valign=top><b><u>'.constant($game->sprache("TEXT47")).':</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][2].'</td></tr>
<tr><td valign=top><b><u>'.constant($game->sprache("TEXT48")).':</b></u><br><a href="javascript:void(0);" onmouseover="return overlib(\''.$PLANETS_TEXT[$game->planet['planet_type']][3].'\',CAPTION,\''.constant($game->sprache("TEXT48")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.substr($PLANETS_TEXT[$game->planet['planet_type']][3],0,40).'...</a></td></tr>
<tr><td valign=top><b><u>'.constant($game->sprache("TEXT49")).':</b></u><br>'.$PLANETS_TEXT[$game->planet['planet_type']][4].'</td></tr>
</table>
</fieldset>



</td>
</tr>

<tr height=20>
<td>
</td>
<td>
</td>
</tr>


<tr>
<td colspan=2>
<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT55")).':</span></legend>
<table border=0 cellpadding=1 cellspacing=1>
<tr><td align=right><u>'.constant($game->sprache("TEXT11")).':</u><td><td width=160>'.$building.'</td></tr>
<tr><td align=right><u>'.$BUILDING_NAME[$game->player['user_race']][8].':</u><td><td>'.$research.'</td></tr>
<tr><td align=right><u>'.$BUILDING_NAME[$game->player['user_race']][5].':</u><td><td>'.$academy.'</td></tr>
<tr><td align=right><u>'.$BUILDING_NAME[$game->player['user_race']][7].':</u><td><td>'.$shipbuild.'</td></tr>
</table></fieldset>
</td>
</tr>


<tr>
<td valign=top>
<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT50")).':</span></legend>
<table border=0 width=210>');
for($blt = 0;$blt < 13;$blt++)
{
	$style = ($blt < 12) ? 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"' : '';

	if($blt < 9)
	{
		$game->out('
			<tr>
				<td '.$style.'>
					'.overlib($BUILDING_NAME[$game->player['user_race']][$blt],$BUILDING_DESCRIPTION[$game->player['user_race']][$blt]).'
				</td>
				<td align=center '.$style.'>
					<b>('.$game->planet['building_'.($blt+1).''].')</b>
				</td>
			</tr>');
	}
	else if ($blt == 9)
	{
		$game->out('
			<tr>
				<td '.$style.'>
					'.overlib($BUILDING_NAME[$game->player['user_race']][12],$BUILDING_DESCRIPTION[$game->player['user_race']][12]).'
				</td>
				<td align=center '.$style.'>
					<b>('.$game->planet['building_13'].')</b>
				</td>
			</tr>');
	}
	else
	{
		$game->out('
			<tr>
				<td '.$style.'>
					'.overlib($BUILDING_NAME[$game->player['user_race']][$blt-1],$BUILDING_DESCRIPTION[$game->player['user_race']][$blt-1]).'
				</td>
				<td align=center '.$style.'>
					<b>('.$game->planet['building_'.($blt).''].')</b>
				</td>
			</tr>');
	}
}

$game->out('</table></fieldset>');

$game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT51")).':</span></legend>
<table border=0 width=210>');

for ($t=0; $t<6; $t++)
{
	$style = ($t < 5) ? 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"' : '';

	$game->out('
		<tr>
			<td '.$style.'>
				<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT56")).'</u> '.GetAttackUnit($t).' (Standard: '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT57")).'</u> '.GetDefenseUnit($t).' (Standard: '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$UNIT_NAME[$game->player['user_race']][$t].'</a>
			</td>
			<td align=center '.$style.'>
				<b>('.$game->planet['unit_'.($t+1).''].')</b>
			</td>
		</tr>');
}

$game->out('</table></fieldset>');

$game->out('</td>
<td valign=top>
<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT52")).':</span></legend>
<table border=0 width=210>');

for ($tech=0; $tech<5; $tech++)
{
	$style = ($tech < 4) ? 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"' : '';

	$game->out('
		<tr>
			<td '.$style.'>
			<a href="javascript:void(0);" onmouseover="return overlib(\''.$TECH_DESCRIPTION[$game->player['user_race']][$tech].'\', CAPTION, \''.$TECH_NAME[$game->player['user_race']][$tech].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$TECH_NAME[$game->player['user_race']][$tech].'</a>
			</td>
			<td align=center '.$style.'>
			<b>('.$game->planet['research_'.($tech+1).''].')</b>
			</td>
		</tr>');
}
$game->out('</table></fieldset>');

$game->out('<fieldset><legend><span class="sub_caption2">'.constant($game->sprache("TEXT53")).':</span></legend>
<table border=0 width=210>');

$n = count($ship_components[$game->player['user_race']]);
foreach ($ship_components[$game->player['user_race']] as $key => $components)
{

	$style = ($key < $n-1) ? 'style="border-bottom-color:A0A0A0; border-bottom-style:dotted; border-bottom-width:1px"' : '';
	$cname=$components['name'];
	/*if (strlen($cname)>13)
	{
		$cname=substr($cname, 0,11);
		$cname.='..';
	}*/
	$text='';
	for ($t=0; $t<$game->planet['catresearch_'.($key+1)]; $t++)
	{
		$text.='- '.$components[$t]['name'].'<br>';
	}
	$catname='<a href="javascript:void(0);" onmouseover="return overlib(\''.$text.'\',CAPTION,\''.$components['name'].'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$cname;
	$game->out('
		<tr>
			<td '.$style.'>
				'.$catname.'</a>
			</td>
			<td align=center '.$style.'>
				<b>('.round(100/$components['num']*$game->planet['catresearch_'.($key+1)],0).'%)</b>
			</td>
		</tr>');
}
$game->out('</table></fieldset>');



$game->out('
</td>
</tr>
</table>

</td>
</tr>
</table>
');

?>
