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

include('include/static/static_components_'.$game->player['user_race'].'.php');
$filename = 'include/static/static_components_'.$game->player['user_race'].'_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);


error_reporting(E_ERROR);
    $STEMPLATE_MODULES = array(
        'view' => constant($game->sprache("TEXT0")),
        'create' => constant($game->sprache("TEXT1")),
        'compare' => constant($game->sprache("TEXT2")),
    );

$module = (!empty($_GET['view'])) ? $_GET['view'] : 'view';
$game->out('<span class="caption">'.constant($game->sprache("TEXT3")).'</span><br><br>'.display_view_navigation('ship_template', $module, $STEMPLATE_MODULES).'<br><br>');

/* 

function RoundsFire($race, $torso)
{
	// DC ---
	// Brown Bobby Version ROF = 1
	
	$rof = 1;
	
	return $rof;
}

function Torpedoes($race, $torso)
{
	// DC ---
	// Brown Bobby Version
	
	if($torso < 3) return 0; 
	
	$max_torp = 15;
	
	if($torso == 5)  $max_torp += 15;
	if($torso == 6)  $max_torp += 30; 
	if($torso == 7)  $max_torp += 60; 
	if($torso == 8)  $max_torp += 130;
	if($torso == 9)  $max_torp += 180;
	if($torso == 10) $max_torp += 220;
	if($torso == 11) $max_torp += 260;
	if($torso == 12) $max_torp += 400;
	
	return $max_torp;
}
 
 */

function CreateShipInfoText($ship)
{
global $db;
global $game;
$text='<b>'.$ship[31].'</b><br><br><u>'.constant($game->sprache("TEXT4")).'<br></u><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$ship[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$ship[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$ship[2].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$ship[30].'<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif> '.$ship['3'].'-'.$ship['7'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif> '.$ship['4'].'-'.$ship['8'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif> '.$ship['5'].'-'.$ship['9'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif> '.$ship['6'].'-'.$ship['10'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif> '.$ship[11].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif> '.$ship[12].'<br><u>'.constant($game->sprache("TEXT5")).'</u>  '.($ship[13]*TICK_DURATION).' '.constant($game->sprache("TEXT6")).'<br><br><u>'.constant($game->sprache("TEXT7")).'</u><br>';

$text.=constant($game->sprache("TEXT8")).' '.$ship[14].'<br>';
$text.=constant($game->sprache("TEXT9")).' '.$ship[15].'<br>';
$text.=constant($game->sprache("TEXT10")).' '.$ship[16].'<br>';
$text.=constant($game->sprache("TEXT11")).' '.$ship[17].'<br>';
$text.=constant($game->sprache("TEXT12")).' '.$ship[18].'<br>';
$text.=constant($game->sprache("TEXT13")).' '.$ship[19].'<br>';
$text.=constant($game->sprache("TEXT14")).' '.$ship[20].'<br>';
$text.=constant($game->sprache("TEXT15")).' '.$ship[21].'<br>';
$text.=constant($game->sprache("TEXT16")).' '.$ship[22].'<br>';
$text.=constant($game->sprache("TEXT17")).' '.$ship[23].'<br>';
$text.=constant($game->sprache("TEXT18")).' '.$ship[24].'<br>';
$text.=constant($game->sprache("TEXT19")).' '.$ship[25].'<br>';
$text.=constant($game->sprache("TEXT20")).' '.$ship[27].'<br>';
$text.=constant($game->sprache("TEXT21")).' '.$ship[26].'<br>';


return $text;
}

function CreateInfoText($comp)
{
global $db;
global $game;
$text=$comp['description'].'<br><br><u>'.constant($game->sprache("TEXT4")).'<br></u><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$comp['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$comp['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$comp['resource_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$comp['resource_4'].'<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif> '.$comp['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif> '.$comp['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif> '.$comp['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif> '.$comp['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif> '.$comp['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif> '.$comp['unit_6'].'<br><u>'.constant($game->sprache("TEXT5")).'</u>  +'.($comp['buildtime']*TICK_DURATION).' '.constant($game->sprache("TEXT6")).'<br><br><u>'.constant($game->sprache("TEXT22")).'</u><br>';

if ($comp['value_1']!=0) $text.=constant($game->sprache("TEXT8")).' '.$comp['value_1'].'<br>';
if ($comp['value_2']!=0) $text.=constant($game->sprache("TEXT9")).' '.$comp['value_2'].'<br>';
if ($comp['value_3']!=0) $text.=constant($game->sprache("TEXT10")).' '.$comp['value_3'].'<br>';
if ($comp['value_4']!=0) $text.=constant($game->sprache("TEXT11")).' '.$comp['value_4'].'<br>';
if ($comp['value_5']!=0) $text.=constant($game->sprache("TEXT12")).' '.$comp['value_5'].'<br>';
if ($comp['value_6']!=0) $text.=constant($game->sprache("TEXT13")).' '.$comp['value_6'].'<br>';
if ($comp['value_7']!=0) $text.=constant($game->sprache("TEXT14")).' '.$comp['value_7'].'<br>';
if ($comp['value_8']!=0) $text.=constant($game->sprache("TEXT15")).' '.$comp['value_8'].'<br>';
if ($comp['value_9']!=0) $text.=constant($game->sprache("TEXT16")).' '.$comp['value_9'].'<br>';
if ($comp['value_10']!=0) $text.=constant($game->sprache("TEXT17")).' '.$comp['value_10'].'<br>';
if ($comp['value_11']!=0) $text.=constant($game->sprache("TEXT18")).' '.$comp['value_11'].'<br>';
if ($comp['value_12']!=0) $text.=constant($game->sprache("TEXT19")).' '.$comp['value_12'].'<br>';
if ($comp['value_14']!=0) $text.=constant($game->sprache("TEXT20")).' '.$comp['value_14'].'<br>';
if ($comp['value_13']!=0) $text.=constant($game->sprache("TEXT21")).' '.$comp['value_13'].'<br>';
if ($comp['value_16']!=0) $text.=constant($game->sprache("TEXT94")).' '.$comp['value_16'].'<br>';
if ($comp['value_17']!=0) $text.=constant($game->sprache("TEXT95")).' '.$comp['value_17'].'<br>';
if ($comp['value_18']!=0) $text.=constant($game->sprache("TEXT85")).' '.$comp['value_18'].'<br>';



return $text;
}

function GetShipClass($race,$torso)
{
global $SHIP_TORSO;

if ($torso<=2) return 0;

if (count($SHIP_TORSO[$race])==5)
{
if ($torso==3) return 1;
return 2;
}
elseif (count($SHIP_TORSO[$race])==6)
{
if ($torso==3) return 1;
if ($torso==4) return 2;
return 3;
}
elseif (count($SHIP_TORSO[$race])==8)
{
if ($torso<5) return 1;
if ($torso<7) return 2;
return 3;
}
if ($torso<5) return 1;
if ($torso<8) return 2;
return 3;
}

function ComponentMetRequirements($cat_id,$comp_id,$comp, $ship)
{
global $db,$game;
if ($comp_id<0) return 1;
if ($comp['torso_'.($ship+1)]!=1) return 0;
$number=$db->queryrow('SELECT MAX(catresearch_'.($cat_id+1).') as nr FROM planets WHERE planet_owner = "'.$game->player['user_id'].'"');
if ($number['nr']<=$comp_id) return 0;
return 1;
}

function SpecialRequirements()
{
global $db,$game;
//	if ($game->player['user_race']==8)	// 8472
//		{
//			if (($_POST[0]==4) && ($_POST[5]!=1)) return 0;
//		}


return 1;
}


function PutValue($template_array,$value1,$t)
{
	if ($template_array[$t][$value1]== max($template_array[0][$value1],$template_array[1][$value1],$template_array[2][$value1]))
		return '<font color="green">'.$template_array[$t][$value1].'</font>';
	if ($template_array[$t][$value1]== min($template_array[0][$value1],$template_array[1][$value1],$template_array[2][$value1]))
		if ( ($t==0 && $template_array[0][$value1] != $template_array[1][$value1] && $template_array[0][$value1] != $template_array[2][$value1]) || ($t==1 && $template_array[1][$value1] != $template_array[0][$value1] && $template_array[1][$value1] != $template_array[2][$value1]) || ($t==2 && $template_array[2][$value1] != $template_array[0][$value1] && $template_array[2][$value1] != $template_array[1][$value1]))
		return '<font color="red">'.$template_array[$t][$value1].'</font>';

    return '<font color="yellow">'.$template_array[$t][$value1].'</font>';
}



function Show_Compare()
{
global $db;
global $game;
global $SHIP_TORSO,$SHIP_TORSO_DATA, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK, $ship_components;



$shiplist[0]='<option value="0" selected="selected">'.constant($game->sprache("TEXT24")).'</option>';
$shiplist[1]='<option value="0" selected="selected">'.constant($game->sprache("TEXT24")).'</option>';
$shiplist[2]='<option value="0" selected="selected">'.constant($game->sprache("TEXT24")).'</option>';
$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) ORDER BY ship_torso ASC, name ASC');
while (($template=$db->fetchrow($templatequery))==true)
{
	$shiplist[0].='<option value="'.$template['id'].'"'.( ($_REQUEST['ship0'] == $template['id']) ? ' selected="selected"' : '' ).'>'.substr($template['name'].' ('.$SHIP_TORSO[$game->player['user_race']][$template['ship_torso']][29].')',0,18).'</option>';
	$shiplist[1].='<option value="'.$template['id'].'"'.( ($_REQUEST['ship1'] == $template['id']) ? ' selected="selected"' : '' ).'>'.substr($template['name'].' ('.$SHIP_TORSO[$game->player['user_race']][$template['ship_torso']][29].')',0,18).'</option>';
	$shiplist[2].='<option value="'.$template['id'].'"'.( ($_REQUEST['ship2'] == $template['id']) ? ' selected="selected"' : '' ).'>'.substr($template['name'].' ('.$SHIP_TORSO[$game->player['user_race']][$template['ship_torso']][29].')',0,18).'</option>';
}

$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=600 class="style_outer"><tr><td>
'.constant($game->sprache("TEXT2")).':<br>
<table border=0 cellpadding=2 cellspacing=2 wisth=600 class="style_inner">
<form method="post" action="'.parse_link('a=ship_template&view=compare').'">
<tr valign=top>
');

for ($t=0; $t<3; $t++)
	if (isset($_REQUEST['ship'.$t]))
	{
		$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) AND (id='.(int)$_REQUEST['ship'.$t].')ORDER BY ship_torso ASC, name ASC');
		$template_array[$t]=$db->fetchrow($templatequery);
	}

for ($t=0; $t<3; $t++)
{

	if (!isset($_REQUEST['ship'.$t])) $game->out('<td width=200 align="center"><span class="sub_caption">'.constant($game->sprache("TEXT24")).'</span><br><select name="ship'.$t.'">'.$shiplist[$t].'</select></td>');
	else
	{
		$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) AND (id='.(int)$_POST['ship'.$t].')ORDER BY ship_torso ASC, name ASC');
		if ($db->num_rows()!=0 && ($template=$db->fetchrow($templatequery))==true)
		{
			$game->out('<td width=200>
			<table border=0 cellpadding=0 cellspacing=0 class="border_grey"><tr><td width=200>
			<center>
			<span class="sub_caption2">'.$template['name'].'</span><br><select name="ship'.$t.'">'.$shiplist[$t].'</select></center><br>
			<u>'.constant($game->sprache("TEXT25")).'</u><br>
			<i>'.$SHIP_TORSO[$game->player['user_race']][$template['ship_torso']][29].'</i>
			<br><br><u>'.constant($game->sprache("TEXT26")).'</u><br>');



			for ($tt=0; $tt<10; $tt++)
			{
	if ($template['component_'.($tt+1)]>=0)
	{
		$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($ship_components[$game->player['user_race']][$tt][$template['component_'.($tt+1)]]).'\', CAPTION, \''.$ship_components[$game->player['user_race']][$tt][$template['component_'.($tt+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$ship_components[$game->player['user_race']][$tt][$template['component_'.($tt+1)]]['name'].'</a><br>');
	} else $game->out(constant($game->sprache("TEXT27")));
			}
			/* Alt das Problem war das nur > gemacht wurde aber man >= machen muss
			for ($tt=0; $tt<10; $tt++)
			{
				if ($template['component_'.($tt+1)]>=0)
					$game->out('-&nbsp;'.$ship_components[$game->player['user_race']][$tt][$template['component_'.($tt+1)]]['name'].'<br>');
				else 
					$game->out('- Nicht belegt<br>');
			} */

			$template_array[$t]['firststrike'] = $template['value_6']*2
			              +$template['value_7']*3
			              +$template['value_8']
			              +$template['value_11']*0.5
			              +$template['value_12'];
                        
                        $base_to_hit = ($template['value_6'] + $template['value_7'] + $template['value_8'] + $template['value_11']) * 0.1;
                        
                        if($base_to_hit > 15) {
                            $base_to_hit = 15;
                        }
                        
                        if($base_to_hit <  1) {
                            $base_to_hit =  1;
                        }
                        
                        $template_array[$t]['tohit'] = round(($base_to_hit * 100)/17, 2);

			$game->out('<br><u>'.constant($game->sprache("TEXT28")).'</u><br>');

			$game->out('<u>'.constant($game->sprache("TEXT8")).'</u> <b>'.PutValue($template_array,'value_1',$t).'</b> x<b>'.PutValue($template_array,'rof',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT9")).'</u> <b>'.PutValue($template_array,'value_2',$t).'</b> x<b>'.PutValue($template_array,'rof2',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT10")).'</u> <b>'.PutValue($template_array,'value_3',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT85")).'</u> <b>'.PutValue($template_array,'max_torp',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT11")).'</u> <b>'.PutValue($template_array,'value_4',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT12")).'</u> <b>'.PutValue($template_array,'value_5',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT13")).'</u> <b>'.PutValue($template_array,'value_6',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT14")).'</u> <b>'.PutValue($template_array,'value_7',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT15")).'</u> <b>'.PutValue($template_array,'value_8',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT16")).'</u> <b>'.PutValue($template_array,'value_9',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT17")).'</u> <b>'.PutValue($template_array,'value_10',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT18")).'</u> <b>'.PutValue($template_array,'value_11',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT19")).'</u> <b>'.PutValue($template_array,'value_12',$t).'</b><br>');
			$game->out('<u>'.constant($game->sprache("TEXT29")).'</u> <b>'.PutValue($template_array,'value_14',$t).'/'.PutValue($template_array,'value_13',$t).'</b><br>');

			$game->out('<br>');
			$game->out('<u>'.constant($game->sprache("TEXT92")).'</u> <b>'.$template_array[$t]['firststrike'].'</b><br>');
                        $game->out('<u>'.constant($game->sprache("TEXT93")).'</u> <b>'.$template_array[$t]['tohit'].'&#37;</b><br>');
			$game->out('<br><br>
			<u>'.constant($game->sprache("TEXT30")).'</u><br>
			<img src="'.$game->GFX_PATH.'menu_metal_small.gif"><b id="price1">'.$template['resource_1'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif"><b id="price2">'.$template['resource_2'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"><b id="price3">'.$template['resource_3'].'</b><br>
			<img src="'.$game->GFX_PATH.'menu_worker_small.gif"><b id="price4">'.$template['resource_4'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif"><b id="price10">'.$template['unit_5'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif"><b id="price11">'.$template['unit_6'].'</b><br><br>
			<u>'.constant($game->sprache("TEXT5")).'</u><br><b id="price5">'.($template['buildtime']*TICK_DURATION).'</b> '.constant($game->sprache("TEXT6")).'<br><br>
			<u>'.constant($game->sprache("TEXT31")).'</u><br>
			<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6">'.$template['min_unit_1'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7">'.$template['min_unit_2'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8">'.$template['min_unit_3'].'</b>
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9">'.$template['min_unit_4'].'</b>
			<br><u>'.constant($game->sprache("TEXT32")).'</u><br>
			'.wordwrap($template['description'], 40,"<br>",1 ).'<br>

			</td></tr></table>
			</td>
			');
		}
		else $game->out('<td width=200 align="center"><span class="sub_caption">'.constant($game->sprache("TEXT24")).'</span><br><select name="ship'.$t.'">'.$shiplist[$t].'</select></td>');
	}

}

$game->out('
</tr>
<tr>
  <td colspan="3" align="center">
  <input class="button_nosize" type="submit" name="none" value="'.constant($game->sprache("TEXT23")).'">
  </form>
</td>
</tr></table>
</td></tr></table>');
}



function Show_Torso()
{
global $db;
global $game;
global $SHIP_TORSO,$SHIP_TORSO_DATA, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;

$ship_class = array(constant($game->sprache("TEXT33")), constant($game->sprache("TEXT34")), constant($game->sprache("TEXT35")), constant($game->sprache("TEXT36")), constant($game->sprache("TEXT36")), constant($game->sprache("TEXT37")), constant($game->sprache("TEXT37")), constant($game->sprache("TEXT38")), constant($game->sprache("TEXT38")), constant($game->sprache("TEXT39")), constant($game->sprache("TEXT39")), constant($game->sprache("TEXT40")), constant($game->sprache("TEXT41"))); 

$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=475 class="style_outer"><tr><td align="center">

<span class="sub_caption">'.constant($game->sprache("TEXT1")).':</span>
<br><span class="sub_caption2">(1/3) '.constant($game->sprache("TEXT42")).'</span><br>
<br><table border=0 cellpadding=2 cellspacing=2 width=475 class="style_inner"><tr><td>
<form method="post" action="'.parse_link('a=ship_template&view=create').'">');

$game->out('<table border=0 cellpadding=2 cellspacing=2><tr><td>&nbsp;</td><td align="left" width=150><b>'.constant($game->sprache("TEXT43")).'</b></td><td width=100><b>'.constant($game->sprache("TEXT44")).'</b></td><td width=50 align="center"><b>'.constant($game->sprache("TEXT45")).'</b></td><td width=75 align="center"><b>'.constant($game->sprache("TEXT46")).'</b></td><td width=75 align="center"><b>'.constant($game->sprache("TEXT47")).'</b></td><td width=50 align="center"><b>'.constant($game->sprache("TEXT48")).'</b></td></tr>');

for ($t=0; $t<count($SHIP_TORSO[$game->player['user_race']]); $t++)
{

//Funktion Rumpfklassen ausblenden
//by Mojo1987

if ($game->player['user_race']==1) //Rom
{
  if ($t==3)
  {
    $t=4;
  }
  if ($t==6)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=11;
  }
}

if ($game->player['user_race']==2) //Klingonen
{
  if ($t==3)
  {
    $t=4;
  }
  if ($t==6)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=11;
  }
}

if ($game->player['user_race']==3) //Cardassianer
{
  if ($t==3)
  {
    $t=4;
  }
  if ($t==5)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=12;
  }
}

if ($game->player['user_race']==4) //Dominion
{

  if ($t==3)
  {
    $t=4;
  }
  if ($t==6)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=11;
  }
}

if ($game->player['user_race']==5) //Ferengi
{
  if ($t==3)
  {
    $t=4;
  }
  if ($t==5)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=12;
  }
}

if ($game->player['user_race']==8) // Breen
{
  if ($t==0)
  {
    $t=1;
  }
  if ($t==3)
  {
    $t=4;
  }
  if ($t==5)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=11;
  }
}

if ($game->player['user_race']==9) // Hiro
{
  if ($t==3)
  {
    $t=5;
  }
  if ($t==6)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=11;
  }
}

if ($game->player['user_race']==10) // Krenim
{
  if ($t==3)
  {
    $t=4;
  }
  if ($t==5)
  {
    $t=7;
  }
  if ($t==8)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=12;
  }
}

if ($game->player['user_race']==11) // Kazon

{
  if ($t==4)
  {
    $t=5;
  }
  if ($t==6)
  {
    $t=9;
  }
  if ($t==10)
  {
    $t=12;
  }
}

$te=$t+1; //Ausgabe Variable f�r den Rumpf

//Funktion Ende

$game->out('
<tr><td>'.( (GlobalTorsoReq($t)<=$game->player['user_points']) ? '<input type="radio" name="ship_torso" value="'.$t.'">' : '<input type="radio" name="ship_torso" value="-1" disabled="disabled">' ).'</td><td><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$game->player['user_race']][$t]).'\', CAPTION, \''.$SHIP_TORSO[$game->player['user_race']][$t][29].'\', 
WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$game->player['user_race']][$t][29].'</a>&nbsp;</td><td>'.$ship_class[$t].'</td><td align="center">'.$te.'</td><td align="center">'.( (GlobalTorsoReq($t)<=$game->player['user_points']) ? '<span style="color: #00FF00;"><b>'.GlobalTorsoReq($t).'</b></span>' : '<span style="color: #FF0000;"><b>'.GlobalTorsoReq($t).'</b></span>' ).'</td><td align="center">'.( ($game->planet['planet_points']<LocalTorsoReq($t)) ? '<span style="color: #FF0000;"><b>'.LocalTorsoReq($t).'</b></span>' : '<span style="color: #00FF00;"><b>'.LocalTorsoReq($t).'</b></span>' ).'</td><td align="center">'.( (GlobalTorsoReq($t)<=$game->player['user_points'] && $game->planet['planet_points']>=LocalTorsoReq($t)) ? '<span style="color: #00FF00;"><b>'.constant($game->sprache("TEXT49")).'</b></span>' : '<span style="color: #FF0000;"><b>'.constant($game->sprache("TEXT50")).'</b></span>' ).'</td></tr>

');


}

$game->out('</table></select>
<center><br>
<input class="button_nosize" type="submit" name="step1" value="(1/3) '.constant($game->sprache("TEXT51")).'" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input class="button_nosize" type="submit" name="step2" value="(2/3) '.constant($game->sprache("TEXT52")).'"></center>
</form></td></tr></table></td></tr></table>');

}


function Show_Components()
{
global $db;
global $game;
global $SHIP_TORSO, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;
global $ship_components;
// res1,res2,res3,res4,unit1,unit2,unit3,unit4,unit5,unit6
//$game->out('<br><b>Debuggen: Diese Meldung m�sst ihr nicht melden - Secius // Torso:'.$_POST['ship_torso']);
if((!isset($_POST['ship_torso'])) || (empty($_POST['ship_torso'])  && $game->player['user_race']==8))
{
$game->out('<br><b>'.constant($game->sprache("TEXT53")).'</b><br>'.Show_Torso());
return;
}
$game->out('
<script language="JavaScript">

function RoundNum(num)
{
return Math.round(num*Math.pow(10,2))/Math.pow(10,2);	
}


var Cat1 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat2 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat3 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat4 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat5 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat6 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat7 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat8=  new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat9 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat10 = new Array(0,0,0,0,0,0,0,0,0,0,0);
var Cat1S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat2S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat3S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat4S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat5S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat6S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat7S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat8S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat9S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var Cat10S = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var CatName = new Array("-","-","-","-","-","-","-","-","-","-");

function Change()
{
var i=0;
var price = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
var skill = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
for (i=0;i<11;i++)
{ 
 if ((i==5 || i==6 ||i==7 || i==8) && Cat1S[14]!=1) {price[i+6]+=Cat1[i]; price[i]=Cat1[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat1[i];} else {price[i]+=Cat1[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat2S[14]!=1) {price[i+6]+=Cat2[i]; price[i]+=Cat2[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat2[i];} else {price[i]+=Cat2[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat3S[14]!=1) {price[i+6]+=Cat3[i]; price[i]+=Cat3[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat3[i];} else {price[i]+=Cat3[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat4S[14]!=1) {price[i+6]+=Cat4[i]; price[i]+=Cat4[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat4[i];} else {price[i]+=Cat4[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat5S[14]!=1) {price[i+6]+=Cat5[i]; price[i]+=Cat5[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat5[i];} else {price[i]+=Cat5[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat6S[14]!=1) {price[i+6]+=Cat6[i]; price[i]+=Cat6[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat6[i];} else {price[i]+=Cat6[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat7S[14]!=1) {price[i+6]+=Cat7[i]; price[i]+=Cat7[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat7[i];} else {price[i]+=Cat7[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat8S[14]!=1) {price[i+6]+=Cat8[i]; price[i]+=Cat8[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat8[i];} else {price[i]+=Cat8[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat9S[14]!=1) {price[i+6]+=Cat9[i]; price[i]+=Cat9[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat9[i];} else {price[i]+=Cat9[i];}
 if ((i==5 || i==6 ||i==7 || i==8) && Cat10S[14]!=1) {price[i+6]+=Cat10[i]; price[i]+=Cat10[i];} else if ((i==5 || i==6 ||i==7 || i==8)) {price[i+6]+=Cat10[i];} else {price[i]+=Cat10[i];}
 
 }
for (i=0;i<18;i++)
{
 skill[i]=Cat1S[i];
 skill[i]+=Cat2S[i];
 skill[i]+=Cat3S[i];
 skill[i]+=Cat4S[i];
 skill[i]+=Cat5S[i];
 skill[i]+=Cat6S[i];
 skill[i]+=Cat7S[i];
 skill[i]+=Cat8S[i];
 skill[i]+=Cat9S[i];
 skill[i]+=Cat10S[i];
}


document.getElementById( "price1" ).firstChild.nodeValue = price[0]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][0].';
document.getElementById( "price2" ).firstChild.nodeValue = price[1]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][1].';
document.getElementById( "price3" ).firstChild.nodeValue = price[2]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][2].';
document.getElementById( "price4" ).firstChild.nodeValue = price[3]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][30].';
document.getElementById( "price5" ).firstChild.nodeValue = price[4]+'.($SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][13]*TICK_DURATION).';

document.getElementById( "price6" ).firstChild.nodeValue = price[5]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][3].';
document.getElementById( "price7" ).firstChild.nodeValue = price[6]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][4].';
document.getElementById( "price8" ).firstChild.nodeValue = price[7]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][5].';
document.getElementById( "price9" ).firstChild.nodeValue = price[8]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][6].';

document.getElementById( "price6a" ).firstChild.nodeValue = price[11]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][7].';
document.getElementById( "price7a" ).firstChild.nodeValue = price[12]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][8].';
document.getElementById( "price8a" ).firstChild.nodeValue = price[13]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][9].';
document.getElementById( "price9a" ).firstChild.nodeValue = price[14]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][10].';

document.getElementById( "price10" ).firstChild.nodeValue = price[9]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][11].';
document.getElementById( "price11" ).firstChild.nodeValue = price[10]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][12].';
document.getElementById( "comp1" ).firstChild.nodeValue = CatName[0];
document.getElementById( "comp2" ).firstChild.nodeValue = CatName[1];
document.getElementById( "comp3" ).firstChild.nodeValue = CatName[2];
document.getElementById( "comp4" ).firstChild.nodeValue = CatName[3];
document.getElementById( "comp5" ).firstChild.nodeValue = CatName[4];
document.getElementById( "comp6" ).firstChild.nodeValue = CatName[5];
document.getElementById( "comp7" ).firstChild.nodeValue = CatName[6];
document.getElementById( "comp8" ).firstChild.nodeValue = CatName[7];
document.getElementById( "comp9" ).firstChild.nodeValue = CatName[8];
document.getElementById( "comp10" ).firstChild.nodeValue = CatName[9];

document.getElementById( "skill1" ).firstChild.nodeValue = skill[0]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][14].';
document.getElementById( "skill2" ).firstChild.nodeValue = skill[1]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][15].';
document.getElementById( "skill3" ).firstChild.nodeValue = skill[2]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][16].';
document.getElementById( "skill4" ).firstChild.nodeValue = skill[3]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][17].';
document.getElementById( "skill5" ).firstChild.nodeValue = skill[4]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][18].';
document.getElementById( "skill6" ).firstChild.nodeValue = skill[5]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][19].';
document.getElementById( "skill7" ).firstChild.nodeValue = skill[6]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][20].';
document.getElementById( "skill8" ).firstChild.nodeValue = skill[7]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][21].';
document.getElementById( "skill9" ).firstChild.nodeValue = skill[8]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][22].';
document.getElementById( "skill10" ).firstChild.nodeValue =RoundNum(skill[9]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][23].');
if (skill[9]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][23].' > 9.99) document.getElementById( "skill10" ).firstChild.nodeValue=9.99;
document.getElementById( "skilla1" ).firstChild.nodeValue = skill[10]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][24].';
document.getElementById( "skilla2" ).firstChild.nodeValue = skill[11]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][25].';
document.getElementById( "skilla3" ).firstChild.nodeValue = skill[12]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][26].';
document.getElementById( "skilla4" ).firstChild.nodeValue = skill[13]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][27].';
document.getElementById( "skilla6" ).firstChild.nodeValue = skill[15]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][32].';
document.getElementById( "skilla7" ).firstChild.nodeValue = skill[16]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][33].';    
document.getElementById( "skilla8" ).firstChild.nodeValue = skill[17]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][34].';    
//document.getElementById( "skilla5" ).firstChild.nodeValue = skill[14]+'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][28].';



}

function UpdateCategory1(svalue, id)  {Cat1[id]=svalue; }
function UpdateCategory2(svalue, id)  {Cat2[id]=svalue; }
function UpdateCategory3(svalue, id)  {Cat3[id]=svalue; }
function UpdateCategory4(svalue, id)  {Cat4[id]=svalue; }
function UpdateCategory5(svalue, id)  {Cat5[id]=svalue; }
function UpdateCategory6(svalue, id)  {Cat6[id]=svalue; }
function UpdateCategory7(svalue, id)  {Cat7[id]=svalue; }
function UpdateCategory8(svalue, id)  {Cat8[id]=svalue; }
function UpdateCategory9(svalue, id)  {Cat9[id]=svalue; }
function UpdateCategory10(svalue, id) {Cat10[id]=svalue; }
function UpdateCategory1S(svalue, id)  {Cat1S[id]=svalue; }
function UpdateCategory2S(svalue, id)  {Cat2S[id]=svalue; }
function UpdateCategory3S(svalue, id)  {Cat3S[id]=svalue; }
function UpdateCategory4S(svalue, id)  {Cat4S[id]=svalue; }
function UpdateCategory5S(svalue, id)  {Cat5S[id]=svalue; }
function UpdateCategory6S(svalue, id)  {Cat6S[id]=svalue; }
function UpdateCategory7S(svalue, id)  {Cat7S[id]=svalue; }
function UpdateCategory8S(svalue, id)  {Cat8S[id]=svalue; }
function UpdateCategory9S(svalue, id)  {Cat9S[id]=svalue; }
function UpdateCategory10S(svalue, id) {Cat10S[id]=svalue; }


function UpdateCompleteCategory1(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[0]=name;
UpdateCategory1(val1,0);
UpdateCategory1(val2,1);
UpdateCategory1(val3,2);
UpdateCategory1(val4,3);
UpdateCategory1(val5,4);
UpdateCategory1(val6,5);
UpdateCategory1(val7,6);
UpdateCategory1(val8,7);
UpdateCategory1(val9,8);
UpdateCategory1(val10,9);
UpdateCategory1(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory1S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory2(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[1]=name;
UpdateCategory2(val1,0);
UpdateCategory2(val2,1);
UpdateCategory2(val3,2);
UpdateCategory2(val4,3);
UpdateCategory2(val5,4);
UpdateCategory2(val6,5);
UpdateCategory2(val7,6);
UpdateCategory2(val8,7);
UpdateCategory2(val9,8);
UpdateCategory2(val10,9);
UpdateCategory2(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory2S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory3(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[2]=name;
UpdateCategory3(val1,0);
UpdateCategory3(val2,1);
UpdateCategory3(val3,2);
UpdateCategory3(val4,3);
UpdateCategory3(val5,4);
UpdateCategory3(val6,5);
UpdateCategory3(val7,6);
UpdateCategory3(val8,7);
UpdateCategory3(val9,8);
UpdateCategory3(val10,9);
UpdateCategory3(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory3S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory4(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[3]=name;
UpdateCategory4(val1,0);
UpdateCategory4(val2,1);
UpdateCategory4(val3,2);
UpdateCategory4(val4,3);
UpdateCategory4(val5,4);
UpdateCategory4(val6,5);
UpdateCategory4(val7,6);
UpdateCategory4(val8,7);
UpdateCategory4(val9,8);
UpdateCategory4(val10,9);
UpdateCategory4(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory4S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory5(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[4]=name;
UpdateCategory5(val1,0);
UpdateCategory5(val2,1);
UpdateCategory5(val3,2);
UpdateCategory5(val4,3);
UpdateCategory5(val5,4);
UpdateCategory5(val6,5);
UpdateCategory5(val7,6);
UpdateCategory5(val8,7);
UpdateCategory5(val9,8);
UpdateCategory5(val10,9);
UpdateCategory5(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory5S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory6(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[5]=name;
UpdateCategory6(val1,0);
UpdateCategory6(val2,1);
UpdateCategory6(val3,2);
UpdateCategory6(val4,3);
UpdateCategory6(val5,4);
UpdateCategory6(val6,5);
UpdateCategory6(val7,6);
UpdateCategory6(val8,7);
UpdateCategory6(val9,8);
UpdateCategory6(val10,9);
UpdateCategory6(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory6S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory7(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[6]=name;
UpdateCategory7(val1,0);
UpdateCategory7(val2,1);
UpdateCategory7(val3,2);
UpdateCategory7(val4,3);
UpdateCategory7(val5,4);
UpdateCategory7(val6,5);
UpdateCategory7(val7,6);
UpdateCategory7(val8,7);
UpdateCategory7(val9,8);
UpdateCategory7(val10,9);
UpdateCategory7(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory7S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory8(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[7]=name;
UpdateCategory8(val1,0);
UpdateCategory8(val2,1);
UpdateCategory8(val3,2);
UpdateCategory8(val4,3);
UpdateCategory8(val5,4);
UpdateCategory8(val6,5);
UpdateCategory8(val7,6);
UpdateCategory8(val8,7);
UpdateCategory8(val9,8);
UpdateCategory8(val10,9);
UpdateCategory8(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory8S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory9(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[8]=name;
UpdateCategory9(val1,0);
UpdateCategory9(val2,1);
UpdateCategory9(val3,2);
UpdateCategory9(val4,3);
UpdateCategory9(val5,4);
UpdateCategory9(val6,5);
UpdateCategory9(val7,6);
UpdateCategory9(val8,7);
UpdateCategory9(val9,8);
UpdateCategory9(val10,9);
UpdateCategory9(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory9S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}
function UpdateCompleteCategory10(val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,skill1,skill2,skill3,skill4,skill5,skill6,skill7,skill8,skill9,skill10,skill11,skill12,skill13,skill14,skill15,skill16,skill17,skill18,name)
{
CatName[9]=name;
UpdateCategory10(val1,0);
UpdateCategory10(val2,1);
UpdateCategory10(val3,2);
UpdateCategory10(val4,3);
UpdateCategory10(val5,4);
UpdateCategory10(val6,5);
UpdateCategory10(val7,6);
UpdateCategory10(val8,7);
UpdateCategory10(val9,8);
UpdateCategory10(val10,9);
UpdateCategory10(val11,10);
'); for ($t=0; $t<18; $t++) $game->out('UpdateCategory10S(skill'.($t+1).','.$t.');'); $game->out('
Change();
}


function getRadioByValue (radioButtonOrGroup, value) {
  if (!radioButtonOrGroup.length) { // single button
    if (radioButtonOrGroup.value == value)
      return radioButtonOrGroup;
    else
      return null;
  }
  else {
    for (var b = 0; b < radioButtonOrGroup.length; b++)
      if (radioButtonOrGroup[b].value == value)
        return radioButtonOrGroup[b];
    return null;
  }
}


function CheckEnergy()
{
var skill = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

for (i=0;i<18;i++)
{
 skill[i]=Cat1S[i];
 skill[i]+=Cat2S[i];
 skill[i]+=Cat3S[i];
 skill[i]+=Cat4S[i];
 skill[i]+=Cat5S[i];
 skill[i]+=Cat6S[i];
 skill[i]+=Cat7S[i];
 skill[i]+=Cat8S[i];
 skill[i]+=Cat9S[i];
 skill[i]+=Cat10S[i];
}
skill[13]+='.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][27].';
skill[12]+='.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][26].';
if (skill[13]>skill[12])
{
alert("'.constant($game->sprache("TEXT54")).' ("+skill[13]+"/"+skill[12]+")!");
return false;
}


if (getRadioByValue(document.build_2.c1,91).checked)
if (!getRadioByValue(document.build_2.c6,98).checked)
{
alert("'.constant($game->sprache("TEXT55")).'");
return false;
}


return true;
}

</script>

<table border=0 cellpadding=2 cellspacing=2 width=500 class="style_outer">
<tr><td align="center">

<span class="sub_caption">'.constant($game->sprache("TEXT1")).':</span>
<br><span class="sub_caption2">(2/3) '.constant($game->sprache("TEXT56")).'</span><br><br>

');

$game->out('
<table boder=0 cellpadding=1 cellspacing=1>
<tr><td width=250 valign=top>

');


$game->out('
<form name="build_2" method="post" action="'.parse_link('a=ship_template&view=create').'">');

foreach ($ship_components[$game->player['user_race']] as $key => $components)
{
$game->out('
<table boder=0 cellpadding=0 cellspacing=0 class="style_inner">
<tr><td width=300>
<span class="text_large">'.$components['name'].'</span><br>
');
$part1='<input type="radio" name="c'.($key+1).'" value="-1" checked="checked"';
$part2='onClick ="return UpdateCompleteCategory'.($key+1).'(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,\'-\');">'.constant($game->sprache("TEXT57"));
$game->out($part1.' '.$part2.' [<a href="javascript:void(0);" onclick="return overlib(\'\', CAPTION, \''.constant($game->sprache("TEXT57")).'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.constant($game->sprache("TEXT58")).'</a>]<br>');

for ($t=0; $t<count($components)-1; $t++)
{

if (ComponentMetRequirements($key,$t,$components[$t],$_POST['ship_torso']))
{
$comp=$components[$t];
$part1='<input type="radio" name="c'.($key+1).'" value="'.$t.'"';
$part2='onClick ="return UpdateCompleteCategory'.($key+1).'('.$comp['resource_1'].','.$comp['resource_2'].','.$comp['resource_3'].','.$comp['resource_4'].','.($comp['buildtime']*TICK_DURATION).','.$comp['unit_1'].','.$comp['unit_2'].','.$comp['unit_3'].','.$comp['unit_4'].','.$comp['unit_5'].','.$comp['unit_6'].','.$comp['value_1'].','.$comp['value_2'].','.$comp['value_3'].','.$comp['value_4'].','.$comp['value_5'].','.$comp['value_6'].','.$comp['value_7'].','.$comp['value_8'].','.$comp['value_9'].','.$comp['value_10'].','.$comp['value_11'].','.$comp['value_12'].','.$comp['value_13'].','.$comp['value_14'].','.$comp['value_15'].','.$comp['value_16'].','.$comp['value_17'].','.$comp['value_18'].',\''.$comp['name'].'\');">'.$comp['name'];
$game->out($part1.' '.$part2.' [<a href="javascript:void(0);" onclick="return overlib(\''.CreateInfoText($comp).'\', CAPTION, \''.$comp['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.constant($game->sprache("TEXT58")).'</a>]<br>');
}

}
$game->out('<br></td></tr></table>');
}


$game->out('
</td>
<td valign=top>

<table border=0 cellpadding=0 cellspacing=0 class="style_inner">
<tr valign=top>
<td width=240>
<u><span class="sub_caption2">'.constant($game->sprache("TEXT25")).'</u>&nbsp;'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][29].'</span><br>
<img src="'.FIXED_GFX_PATH.'ship'.$game->player['user_race'].'_'.$_POST['ship_torso'].'.jpg"><br><br>
<span class="text_large">'.constant($game->sprache("TEXT26")).'</span><br>
<i id="comp1">-</i><br>
<i id="comp2">-</i><br>
<i id="comp3">-</i><br>
<i id="comp4">-</i><br>
<i id="comp5">-</i><br>
<i id="comp6">-</i><br>
<i id="comp7">-</i><br>
<i id="comp8">-</i><br>
<i id="comp9">-</i><br>
<i id="comp10">-</i>

<br><br>
<span class="text_large">'.constant($game->sprache("TEXT4")).'</span><br>
<u>'.constant($game->sprache("TEXT30")).'</u><br><img src="'.$game->GFX_PATH.'menu_metal_small.gif"><b id="price1">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][0].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif"><b id="price2">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][1].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"><b id="price3">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][2].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_worker_small.gif"><b id="price4">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][30].'</b><br>
<img src="'.$game->GFX_PATH.'menu_unit5_small.gif"><b id="price10">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][11].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif"><b id="price11">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][12].'</b><br>
<u>'.constant($game->sprache("TEXT5")).'</u><b id="price5">'.($SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][13]*TICK_DURATION).'</b> '.constant($game->sprache("TEXT6")).'<br>
<u>'.constant($game->sprache("TEXT31")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][3].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][4].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][5].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][6].'</b><br><br>
<u>'.constant($game->sprache("TEXT59")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6a">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][7].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7a">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][8].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8a">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][9].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9a">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][10].'</b>
<br><br>
<span class="text_large">'.constant($game->sprache("TEXT60")).'</span><br>
<table border=0 cellpadding=0 cellspacing=0><tr valign=top><td width=125>
<u>'.constant($game->sprache("TEXT8")).'</u> <b id="skill1">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][14].'</b><br>
<u>'.constant($game->sprache("TEXT9")).'</u> <b id="skill2">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][15].'</b><br>
<u>'.constant($game->sprache("TEXT10")).'</u> <b id="skill3">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][16].'</b><br>
<u>'.constant($game->sprache("TEXT11")).'</u> <b id="skill4">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][17].'</b><br>
<u>'.constant($game->sprache("TEXT12")).'</u> <b id="skill5">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][18].'</b><br>
</td><td width=125>
<u>'.constant($game->sprache("TEXT13")).'</u> <b id="skill6">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][19].'</b><br>
<u>'.constant($game->sprache("TEXT14")).'</u> <b id="skill7">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][20].'</b><br>
<u>'.constant($game->sprache("TEXT15")).'</u> <b id="skill8">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][21].'</b><br>
<u>'.constant($game->sprache("TEXT16")).'</u> <b id="skill9">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][22].'</b><br>
<u>'.constant($game->sprache("TEXT94")).'</u> <b id="skilla6">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][32].'</b><br>    
<u>'.constant($game->sprache("TEXT95")).'</u> <b id="skilla7">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][33].'</b><br>    
</td></tr>
<tr valign=top><td width=100>
<u>'.constant($game->sprache("TEXT17")).'</u> <b id="skill10">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][23].'</b><br>
<u>'.constant($game->sprache("TEXT18")).'</u> <b id="skilla1">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][24].'</b><br>
<u>'.constant($game->sprache("TEXT19")).'</u> <b id="skilla2">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][25].'</b><br>
</td><td width=100>
<u>'.constant($game->sprache("TEXT85")).'</u> <b id="skilla8">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][34].'</b><br>
<u>'.constant($game->sprache("TEXT61")).'</u><br><b id="skilla4">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][27].'</b>/<b id="skilla3">'.$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][26].'</b></td></tr></table>
</td>
</tr></table>

</td></tr></table>
<input type=hidden name="ship_torso" value="'.$_POST['ship_torso'].'">
<br>
<br>
<input class="button_nosize" type="submit" name="step1" value="(1/3) '.constant($game->sprache("TEXT51")).'">&nbsp;&nbsp;&nbsp;
<input class="button_nosize" onClick="return CheckEnergy()" type="submit" name="step3" value="(3/3) '.constant($game->sprache("TEXT52")).'">
</form></td></tr></table>');


}




function Show_Final()
{
global $db;
global $game;
global $SHIP_TORSO,$SHIP_TORSO_DATA, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;
global $ship_components;

for ($t=0; $t<15; $t++)
if (isset($_POST['c'.($t+1)]))
$_POST[($t)]=(int)$_POST['c'.($t+1)];
else
$_POST[($t)]=-1;

$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=450 class="style_outer"><tr><td align="center">

<span class="sub_caption">'.constant($game->sprache("TEXT1")).':</span>
<br><span class="sub_caption2">(3/3) '.constant($game->sprache("TEXT62")).'</span><br>
<br><table border=0 cellpadding=2 cellspacing=2 width=450 class="style_inner"><tr><td>
<form method="post" action="'.parse_link('a=ship_template&view=create').'">');


//if ($game->player['user_race']==9) // Test for the decoy ship:
//{
//if (($_POST[3])>=0 && ($_POST[8])>=0)
//{
//	$game->out('<span class="sub_caption2">'.constant($game->sprache("TEXT63")).' '.$ship_components[$game->player['user_race']][3][$_POST[3]]['name'].' '.constant($game->sprache("TEXT64")).'<br><br></span>');
//	$_POST[3]=0;
//}
//}

$game->out('
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width=25%><span class="text_large">'.constant($game->sprache("TEXT65")).'</span></td>
<td width=75%><input style="width: 200px;" class="field" type="text" name="ship_name" value="'.constant($game->sprache("TEXT66")).'" maxlength="16"></td>
</tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT67")).'</td>
<td><textarea name="ship_description" class="textfield" rows="5" cols="40 style="width: 300px;""></textarea></td>
</tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT68")).'</td>
<td width=75%><img src='.FIXED_GFX_PATH.'ship'.$game->player['user_race'].'_'.$_POST['ship_torso'].'.jpg><br></td>
</tr>

<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT26")).'</td>
<td width=75%>');

for ($x=0; $x<15; $x++)
{
$value[$x]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][14+$x];
}

$value[15] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][32]; // Primary RoF
$value[16] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][33]; // Secondary RoF
$value[17] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][34];


$price[0]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][0];
$price[1]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][1];
$price[2]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][2];
$price[4]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][13];
$price[5]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][3];
$price[6]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][4];
$price[7]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][5];
$price[8]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][6];
$price[9]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][11];
$price[10]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][12];
$price[3]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][30];

$price[11]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][7];
$price[12]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][8];
$price[13]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][9];
$price[14]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][10];


for ($t=0; $t<10; $t++)
{
    if ($_POST[($t)]>=0 && isset($ship_components[$game->player['user_race']][$t][$_POST[($t)]]['name']))
    {
        $comp=$ship_components[$game->player['user_race']][$t][$_POST[($t)]];

        $game->out('<input type=hidden name="'.($t).'" value="'.$_POST[($t)].'">-&nbsp;'.$comp['name'].'<br>');

        // Calculate the "values":
        for ($x=0; $x<18; $x++)
        {
            $value[$x]+=$comp['value_'.($x+1)];
        }


        $price[0]+=$comp['resource_1'];
        $price[1]+=$comp['resource_2'];
        $price[2]+=$comp['resource_3'];
        $price[3]+=$comp['resource_4'];
        $price[4]+=$comp['buildtime'];

        if ($comp['value_15']!=1)
        {
            $price[5]+=$comp['unit_1'];
            $price[6]+=$comp['unit_2'];
            $price[7]+=$comp['unit_3'];
            $price[8]+=$comp['unit_4'];
            $price[11]+=$comp['unit_1'];
            $price[12]+=$comp['unit_2'];
            $price[13]+=$comp['unit_3'];
            $price[14]+=$comp['unit_4'];
        }
        else
        {
            $price[11]+=$comp['unit_1'];
            $price[12]+=$comp['unit_2'];
            $price[13]+=$comp['unit_3'];
            $price[14]+=$comp['unit_4'];	
        }

        $price[9]+=$comp['unit_5'];
        $price[10]+=$comp['unit_6'];

    } else $game->out(constant($game->sprache("TEXT27")));
}

if ($value[9]>9.99) $value[9]=9.99;

//$value[15] = RoundsFire($game->player['user_race'], $_POST['ship_torso']); // this is rof on ship_templates DB
//$value[16] = Torpedoes($game->player['user_race'], $_POST['ship_torso']); // this is max_torp on ship_templates DB

$game->out('<br></td></tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT28")).'</td>
<td width=75%>');


$game->out('<u>'.constant($game->sprache("TEXT8")).'</u> <b>'.$value[0].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT9")).'</u> <b>'.$value[1].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT94")).'</u> <b>'.$value[15].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT95")).'</u> <b>'.$value[16].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT10")).'</u> <b>'.$value[2].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT85")).'</u> <b>'.($_POST['ship_torso'] < 4 ? 'N/A' : $value[17]).'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT11")).'</u> <b>'.$value[3].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT12")).'</u> <b>'.$value[4].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT13")).'</u> <b>'.$value[5].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT14")).'</u> <b>'.$value[6].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT15")).'</u> <b>'.$value[7].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT16")).'</u> <b>'.$value[8].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT17")).'</u> <b>'.$value[9].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT18")).'</u> <b>'.$value[10].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT19")).'</u> <b>'.$value[11].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT29")).'</u> <b>'.$value[13].'/'.$value[12].'</b><br>');

$game->out('<br></td></tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT69")).'</td>
<td width=75%>
<u>'.constant($game->sprache("TEXT30")).'</u><br><img src="'.$game->GFX_PATH.'menu_metal_small.gif"><b id="price1">'.$price[0].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif"><b id="price2">'.$price[1].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"><b id="price3">'.$price[2].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_worker_small.gif"><b id="price4">'.$price[3].'</b><br>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif"><b id="price10">'.$price[9].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif"><b id="price11">'.$price[10].'</b><br><br>
<u>'.constant($game->sprache("TEXT5")).'</u><br><b id="price5">'.($price[4]*TICK_DURATION).'</b> '.constant($game->sprache("TEXT6")).'<br><br>
<u>'.constant($game->sprache("TEXT31")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6">'.$price[5].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7">'.$price[6].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8">'.$price[7].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9">'.$price[8].'</b>
<br><br>
<u>'.constant($game->sprache("TEXT59")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6a">'.$price[11].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7a">'.$price[12].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8a">'.$price[13].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9a">'.$price[14].'</b>

</td>
</tr>
</table>

<input type=hidden name="ship_torso" value="'.$_POST['ship_torso'].'">

<br><center>
<input class="button_nosize" type="submit" name="step2" value="(2/3) '.constant($game->sprache("TEXT51")).'">&nbsp;&nbsp;&nbsp;
<input class="button_nosize" type="submit" name="step4" value="'.constant($game->sprache("TEXT62")).'"></center>
</form></td></tr></table><br>');
$game->out('</td></tr></table>');
}


function Show_Save()
{
global $db;
global $game;
global $SHIP_TORSO,$SHIP_TORSO_DATA, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;
global $ship_components;

if (!isset($_POST['0'])) $_POST['0']=-1;
if (!isset($_POST['1'])) $_POST['1']=-1;
if (!isset($_POST['2'])) $_POST['2']=-1;
if (!isset($_POST['3'])) $_POST['3']=-1;
if (!isset($_POST['4'])) $_POST['4']=-1;
if (!isset($_POST['5'])) $_POST['5']=-1;
if (!isset($_POST['6'])) $_POST['6']=-1;
if (!isset($_POST['7'])) $_POST['7']=-1;
if (!isset($_POST['8'])) $_POST['8']=-1;
if (!isset($_POST['9'])) $_POST['9']=-1;


$_POST[0]=$_POST['0']=(int)$_POST['0'];
$_POST[1]=$_POST['1']=(int)$_POST['1'];
$_POST[2]=$_POST['2']=(int)$_POST['2'];
$_POST[3]=$_POST['3']=(int)$_POST['3'];
$_POST[4]=$_POST['4']=(int)$_POST['4'];
$_POST[5]=$_POST['5']=(int)$_POST['5'];
$_POST[6]=$_POST['6']=(int)$_POST['6'];
$_POST[7]=$_POST['7']=(int)$_POST['7'];
$_POST[8]=$_POST['8']=(int)$_POST['8'];
$_POST[9]=$_POST['9']=(int)$_POST['9'];

$_POST['ship_name']=htmlspecialchars($_POST['ship_name']);
$_POST['ship_description']=htmlspecialchars($_POST['ship_description']);

$_POST['ship_torso']=(int)$_POST['ship_torso'];
if (GlobalTorsoReq($_POST['ship_torso'])>$game->player['user_points']) exit(0);
if (SpecialRequirements()!=1) {echo constant($game->sprache("TEXT70"));exit(0);}



$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=450 class="style_outer"><tr><td>

<span class="sub_caption">'.constant($game->sprache("TEXT1")).':</span>
<br><span class="sub_caption2">'.constant($game->sprache("TEXT71")).'</span>
<br><table border=0 cellpadding=2 cellspacing=2 width=450 class="style_inner"><tr><td>
');


$game->out('
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT72")).'</td>
<td width=75%><b>'.$_POST['ship_name'].'</b><br><br></td>
</tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT32")).'</td>
<td>'.wordwrap(nl2br(stripslashes($_POST['ship_description'])), 40,"<br>",1 ).'<br><br></td>
</tr>
<tr>
<td width=25% valign=top><span class="text_large">'.constant($game->sprache("TEXT68")).'</td>
<td width=75%><img src='.FIXED_GFX_PATH.'ship'.$game->player['user_race'].'_'.$_POST['ship_torso'].'.jpg></td>
</tr>
');

for ($x=0; $x<15; $x++)
{
$value[$x]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][14+$x];
}

$value[15] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][32];
$value[16] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][33];
$value[17] = $SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][34];
        
$price[0]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][0];
$price[1]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][1];
$price[2]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][2];
$price[4]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][13];
$price[5]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][3];
$price[6]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][4];
$price[7]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][5];
$price[8]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][6];
$price[9]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][11];
$price[10]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][12];
$price[3]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][30];

$price[11]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][7];
$price[12]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][8];
$price[13]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][9];
$price[14]=$SHIP_TORSO[$game->player['user_race']][$_POST['ship_torso']][10];


for ($t=0; $t<10; $t++)
{
    if ($_POST[($t)]>=0 && isset($ship_components[$game->player['user_race']][$t][$_POST[($t)]]['name']))
    {
        $comp=$ship_components[$game->player['user_race']][$t][$_POST[($t)]];


        // Calculate the "values":
        for ($x=0; $x<18; $x++)
        {
            $value[$x]+=$comp['value_'.($x+1)];
        }


        $price[0]+=$comp['resource_1'];
        $price[1]+=$comp['resource_2'];
        $price[2]+=$comp['resource_3'];
        $price[3]+=$comp['resource_4'];
        $price[4]+=$comp['buildtime'];

        if ($comp['value_15']!=1)
        {
            $price[5]+=$comp['unit_1'];
            $price[6]+=$comp['unit_2'];
            $price[7]+=$comp['unit_3'];
            $price[8]+=$comp['unit_4'];
            $price[11]+=$comp['unit_1'];
            $price[12]+=$comp['unit_2'];
            $price[13]+=$comp['unit_3'];
            $price[14]+=$comp['unit_4'];
        }
        else
        {
            $price[11]+=$comp['unit_1'];
            $price[12]+=$comp['unit_2'];
            $price[13]+=$comp['unit_3'];
            $price[14]+=$comp['unit_4'];	
        }

        $price[9]+=$comp['unit_5'];
        $price[10]+=$comp['unit_6'];

    }
}

if ($value[4]==0 || $price[4]==0) {echo constant($game->sprache("TEXT73"));exit(0);}

// Energieverbrauch checken:
if ($value[13]>$value[12]) exit(0);

if ($value[9]>9.99) $value[9]=9.99;

//$value[15] = RoundsFire($game->player['user_race'], $_POST['ship_torso']); // this is rof on ship_templates DB
//$value[16] = Torpedoes($game->player['user_race'], $_POST['ship_torso']); // this is max_torp on ship_templates DB

$game->out('
</table>
<br>
<span class="sub_caption2">'.constant($game->sprache("TEXT74")).'</span>
</td></tr></table><br>');

$game->out('</td></tr></table>');

// Insert:
$db->query('INSERT INTO ship_templates
(owner, timestamp, name, description, race, ship_torso, ship_class, component_1, component_2, component_3, component_4, component_5, component_6, component_7, component_8, component_9, component_10,
value_1, value_2, value_3, value_4, value_5, value_6, value_7, value_8, value_9, value_10, value_11, value_12, value_13, value_14, value_15,
resource_1, resource_2, resource_3, resource_4, unit_5, unit_6, min_unit_1, min_unit_2, min_unit_3, min_unit_4, max_unit_1, max_unit_2, max_unit_3, max_unit_4, buildtime, rof, rof2, max_torp) VALUES
("'.$game->player['user_id'].'","'.time().'","'.$_POST['ship_name'].'","'.$_POST['ship_description'].'","'.$game->player['user_race'].'","'.$_POST['ship_torso'].'","'.GetShipClass($game->player['user_race'],$_POST['ship_torso']).'","'.$_POST[0].'","'.$_POST[1].'","'.$_POST[2].'","'.$_POST[3].'","'.$_POST[4].'","'.$_POST[5].'","'.$_POST[6].'","'.$_POST[7].'","'.$_POST[8].'","'.$_POST[9].'",
"'.$value[0].'","'.$value[1].'","'.$value[2].'","'.$value[3].'","'.$value[4].'","'.$value[5].'","'.$value[6].'","'.$value[7].'","'.$value[8].'","'.$value[9].'","'.$value[10].'","'.$value[11].'","'.$value[12].'","'.$value[13].'","'.$value[14].'",
"'.$price[0].'","'.$price[1].'","'.$price[2].'","'.$price[3].'","'.$price[9].'","'.$price[10].'","'.$price[5].'","'.$price[6].'","'.$price[7].'","'.$price[8].'","'.$price[11].'","'.$price[12].'","'.$price[13].'","'.$price[14].'","'.$price[4].'","'.$value[15].'","'.$value[16].'","'.$value[17].'")
');
}



function Show_Overview()
{
global $db;
global $game;
global $SHIP_TORSO,$SHIP_TORSO_DATA, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;
global $ship_components;


if (isset($_GET['delete']))
{
$_GET['template']=(int)$_GET['template'];
$db->query('UPDATE ship_templates SET removed=1 WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$_GET['template'].'") LIMIT 1');
redirect('a=ship_template');
}
if (isset($_GET['template'])) 
{
$_GET['template']=(int)$_GET['template'];
$template=$db->queryrow('SELECT * FROM ship_templates WHERE (id="'.$_GET['template'].'") AND (owner="'.$game->player['user_id'].'") AND (removed=0) ORDER BY ship_torso ASC, name ASC');
}

$templatequery=$db->query('SELECT id,name,ship_torso FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) ORDER BY ship_torso ASC, name ASC');
$number=$db->num_rows();

$game->out('
<table border=0 cellpadding=2 cellspacing=2 width=600 class="style_outer"><tr><td>
<span class="sub_caption2">'.((isset($template['name'])) ? $template['name'].':' : constant($game->sprache("TEXT0")).':').'</span><br>');

$game->out('<table border=0 cellpadding=0 cellspacing=0 width="600" class="style_inner">
<tr><td valign=top width="500">');

if (isset($template['id']))
{

$game->out('
<table width="175" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign=top ><u>'.constant($game->sprache("TEXT72")).'</u><br>
<b>'.$template['name'].'</b><br><br></td>
</tr>
<tr>
<td valign=top><u>'.constant($game->sprache("TEXT32")).'</u><br>
'.wordwrap(stripslashes(nl2br($template['description'])), 40,"<br>",1 ).'<br><br></td>
</tr>
<tr>
<td valign=top><u>'.constant($game->sprache("TEXT68")).'</u><br><img src='.FIXED_GFX_PATH.'ship'.$game->player['user_race'].'_'.$template['ship_torso'].'.jpg></td>
</tr>
<tr>
<td valign=top><u>'.constant($game->sprache("TEXT26")).'</u><br>');

    
for ($t=0; $t<10; $t++)
{
	if ($template['component_'.($t+1)]>=0)
	{
		$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]).'\', CAPTION, \''.$ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.( ($game->planet['catresearch_'.($t+1)]<=$template['component_'.($t+1)]) ? '<b><span style="color: red;">'.$ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]['name'].'</span>' : '<b><span style="color: green;">'.$ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]['name'].'</span>' ).'</b></a><br>');
	} else $game->out(constant($game->sprache("TEXT27")));
}

$game->out('<br></td></tr></table></td><td width="50%">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign=top><u>'.constant($game->sprache("TEXT28")).'</u><br>');


$game->out('<u>'.constant($game->sprache("TEXT8")).'</u> <b>'.$template['value_1'].'</b> x<b>'.$template['rof'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT9")).'</u> <b>'.$template['value_2'].'</b> x<b>'.$template['rof2'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT10")).'</u> <b>'.$template['value_3'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT85")).'</u> <b>'.($template['ship_torso'] < 4 ? 'N/A' : $template['max_torp']).'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT11")).'</u> <b>'.$template['value_4'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT12")).'</u> <b>'.$template['value_5'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT13")).'</u> <b>'.$template['value_6'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT14")).'</u> <b>'.$template['value_7'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT15")).'</u> <b>'.$template['value_8'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT16")).'</u> <b>'.$template['value_9'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT17")).'</u> <b>'.$template['value_10'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT18")).'</u> <b>'.$template['value_11'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT19")).'</u> <b>'.$template['value_12'].'</b><br>');
$game->out('<u>'.constant($game->sprache("TEXT29")).'</u> <b>'.$template['value_14'].'/'.$template['value_13'].'</b><br>');

$game->out('<br></td></tr>
<tr>
<td valign=top><u>'.constant($game->sprache("TEXT30")).'</u><br>
			<img src="'.$game->GFX_PATH.'menu_metal_small.gif"><b id="price1">'.$template['resource_1'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif"><b id="price2">'.$template['resource_2'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"><b id="price3">'.$template['resource_3'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_worker_small.gif"><b id="price4">'.$template['resource_4'].'</b><br>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif"><b id="price10">'.$template['unit_5'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif"><b id="price11">'.$template['unit_6'].'</b><br><br>
<u>'.constant($game->sprache("TEXT5")).'</u><br><b id="price5">'.($template['buildtime']*TICK_DURATION).'</b> '.constant($game->sprache("TEXT6")).'<br><br>
<u>'.constant($game->sprache("TEXT31")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6">'.$template['min_unit_1'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7">'.$template['min_unit_2'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8">'.$template['min_unit_3'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9">'.$template['min_unit_4'].'</b><br><br>

<u>'.constant($game->sprache("TEXT59")).'</u><br>
<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="price6a">'.$template['max_unit_1'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="price7a">'.$template['max_unit_2'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="price8a">'.$template['max_unit_3'].'</b>
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="price9a">'.$template['max_unit_4'].'</b>

</td>
</tr>
</table>');

}
$game->out('</td>


<td width="230" valign="top" align="center">
<span class="sub_caption2">'.constant($game->sprache("TEXT75")).' ('.$number.' '.(($number > 1) ? constant($game->sprache("TEXT83")) : constant($game->sprache("TEXT43"))).')</span>
<form action="'.parse_link('a=ship_template').'" name="shipselect">
<input type="hidden" name="a" value="ship_template">

<select name="template" size="20" style="width: 200px;" onChange="document.shipselect.submit()">>');

while (($tmplate=$db->fetchrow($templatequery))==true)
$game->out('<option value="'.$tmplate['id'].'" '.(($tmplate['id']==$_GET['template']) ? 'selected="selected"' : '').'>'.$tmplate['name'].' ('.$SHIP_TORSO[$game->player['user_race']][$tmplate['ship_torso']][29].')</option>');

$game->out('
</select><br><br>

'.(isset($template['name']) ? '<input class="button_nosize" type="submit" name="delete" value="'.constant($game->sprache("TEXT76")).' '.$template['name'].'" onClick="return confirm(\''.constant($game->sprache("TEXT77")).'\')">' : '').'
</form>
</td>
</tr></table>');


$game->out('</td></tr><tr><td align="left">'.constant($game->sprache("TEXT78")).'<br><b><font color=red>'.constant($game->sprache("TEXT79")).'</font><br><font color=green>'.constant($game->sprache("TEXT80")).'</font></b></td></tr></table><br><br>');
}











/*

if ($game->player['user_id']>13)
{
$game->out('<span class="caption">Momentan deaktiviert.<br><br>');
}

*/

if ($game->planet['building_8']<1)
{
message(NOTICE, constant($game->sprache("TEXT81")).' '.$BUILDING_NAME[$game->player['user_race']]['7'].' '.constant($game->sprache("TEXT82")));
//$game->out('<span class="text_large">'.constant($game->sprache("TEXT81")).' '.$BUILDING_NAME[$game->player['user_race']]['7'].' '.constant($game->sprache("TEXT82")).'</span><br><br>');


}
else
{

if (!isset($_REQUEST['view']) || $_REQUEST['view']=='view') Show_Overview();
else if ($_REQUEST['view']=='compare') Show_Compare();
else if ($_REQUEST['view']=='create')
if (isset($_POST['step4']))
{
Show_Save();
}
else if (isset($_POST['step3']))
{
Show_Final();
}
else if (isset($_POST['step2']))
{
Show_Components();
}
else
{
Show_Torso(); //Show_Main();
}

else if ($_REQUEST['view']=='statistics') {}



}

?>
