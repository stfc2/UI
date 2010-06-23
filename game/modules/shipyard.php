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

$game->out('<span class="caption">'.$BUILDING_NAME[$game->player['user_race']][7].':</span><br><br>');





function ComponentMetRequirements($cat_id,$comp_id, $ship)

{

global $db,$game,$ship_components;

if ($comp_id<0) return 1;

$comp = $ship_components[$game->player['user_race']][$cat_id][$comp_id];

if ($comp['torso_'.($ship+1)]!=1) return 0;

//$number=$db->queryrow('SELECT MAX(catresearch_'.($cat_id+1).') as nr FROM planets WHERE planet_owner = "'.$game->player['user_id'].'"');

if ($game->planet['catresearch_'.($cat_id+1)]<=$comp_id) return 0;

return 1;

}

function ColoMetRestriction($template) // Verification of the uniqueness of the colony ship
{
	global $game,$db;

	if(!($template['ship_torso'] == 2 && $template['ship_class'] == 0))
		return 1;

	if($game->player['user_max_colo'] == 0) return 1;

	$sql = 'SELECT COUNT(*) AS conteggio FROM ship_templates, ships WHERE ship_templates.id = ships.template_id
				AND ship_templates.ship_torso = 2 AND ship_templates.ship_class = 0
				AND ships.user_id = '.$game->player['user_id'];

	$_temp = $db->queryrow($sql);
	$risultato = $_temp['conteggio'];

	$sql = 'SELECT COUNT(*) AS conteggio FROM scheduler_shipbuild, ship_templates, planets WHERE scheduler_shipbuild.ship_type = ship_templates.id
				AND scheduler_shipbuild.planet_id = planets.planet_id
				AND ship_templates.ship_torso = 2
				AND ship_class = 0
				AND planets.planet_owner = '.$game->player['user_id'];

	$_temp = $db->queryrow($sql);
	$risultato += $_temp['conteggio'];

	if($risultato >= $game->player['user_max_colo']) return 0;

	return 1;
}


function TemplateMetRequirements($template)

{

global $game;

//global $ship_components;

if ($game->player['user_points']<GlobalTorsoReq($template['ship_torso'])) { return 0; }

if ($game->planet['planet_points']<LocalTorsoReq($template['ship_torso'])) { return 0; }

if(!ColoMetRestriction($template)) return 0;

if (!ComponentMetRequirements(0,$template['component_1'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(1,$template['component_2'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(2,$template['component_3'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(3,$template['component_4'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(4,$template['component_5'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(5,$template['component_6'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(6,$template['component_7'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(7,$template['component_8'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(8,$template['component_9'],$template['ship_torso'])) return 0;

if (!ComponentMetRequirements(9,$template['component_10'],$template['ship_torso'])) return 0;


//if ($game->planet['planet_points']<TorsoRequirements($template['ship_torso'],0) || $game->player['user_points']<TorsoRequirements($template['ship_torso'],0)) return 0;

//echo $template['ship_torso'];

return 1;

}


function TemplateMetRequirementsText($template)

{

global $game;

//global $ship_components;

if ($game->player['user_points']<GlobalTorsoReq($template['ship_torso'])) { $game->out('<tr><td>'.constant($game->sprache("TEXT0")).' '.GlobalTorsoReq($template['ship_torso']).' '.constant($game->sprache("TEXT1")).'</td></tr>'); }

if ($game->planet['planet_points']<LocalTorsoReq($template['ship_torso'])) { $game->out('<tr><td>'.constant($game->sprache("TEXT0")).' '.LocalTorsoReq($template['ship_torso']).' '.constant($game->sprache("TEXT2")).'</td></tr>'); }

if (!ComponentMetRequirements(0,$template['component_1'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(1,$template['component_2'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(2,$template['component_3'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(3,$template['component_4'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(4,$template['component_5'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(5,$template['component_6'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(6,$template['component_7'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(7,$template['component_8'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(8,$template['component_9'],$template['ship_torso'])) { }

if (!ComponentMetRequirements(9,$template['component_10'],$template['ship_torso'])) { }


//if ($game->planet['planet_points']<TorsoRequirements($template['ship_torso'],0) || $game->player['user_points']<TorsoRequirements($template['ship_torso'],0)) return 0;

//echo $template['ship_torso'];

//return 1;

}


function CanAffordTemplateUnits($unit0,$unit1,$unit2,$unit3,$count,$template,$planet)

{

$unit[0]=$unit0;

$unit[1]=$unit1;

$unit[2]=$unit2;

$unit[3]=$unit3;

if ($unit[0]<$template['min_unit_1']) return 0;

if ($unit[1]<$template['min_unit_2']) return 0;

if ($unit[2]<$template['min_unit_3']) return 0;

if ($unit[3]<$template['min_unit_4']) return 0;

if ($unit[0]>$template['max_unit_1']) return 0;

if ($unit[1]>$template['max_unit_2']) return 0;

if ($unit[2]>$template['max_unit_3']) return 0;

if ($unit[3]>$template['max_unit_4']) return 0;

if ($planet['unit_1']<$unit[0]*$count) return 0;

if ($planet['unit_2']<$unit[1]*$count) return 0;

if ($planet['unit_3']<$unit[2]*$count) return 0;

if ($planet['unit_4']<$unit[3]*$count) return 0;



return 1;

}



function CanAffordTemplate($template,$player,$planet)

{

global $game;

// Calculate how many types of the template could be build:

if ($template['resource_1']!=0) $num[0]=floor($planet['resource_1']/$template['resource_1']); else $num[0]=9999;

if ($template['resource_2']!=0) $num[1]=floor($planet['resource_2']/$template['resource_2']); else $num[1]=9999;

if ($template['resource_3']!=0) $num[2]=floor($planet['resource_3']/$template['resource_3']); else $num[2]=9999;

if ($template['resource_4']!=0) $num[3]=floor($planet['resource_4']/$template['resource_4']); else $num[3]=9999;

if ($template['unit_5']!=0) $num[4]=floor($planet['unit_5']/$template['unit_5']); else $num[4]=9999;

if ($template['unit_6']!=0) $num[5]=floor($planet['unit_6']/$template['unit_6']); else $num[5]=9999;

if ($template['min_unit_1']!=0) $num[6]=floor($planet['unit_1']/$template['min_unit_1']); else $num[6]=9999;

if ($template['min_unit_2']!=0) $num[7]=floor($planet['unit_2']/$template['min_unit_2']); else $num[7]=9999;

if ($template['min_unit_3']!=0) $num[8]=floor($planet['unit_3']/$template['min_unit_3']); else $num[8]=9999;

if ($template['min_unit_4']!=0) $num[9]=floor($planet['unit_4']/$template['min_unit_4']); else $num[9]=9999;

// You cannot have more than user_max_colo colony ship at same time
if($template['ship_torso'] == 2 && $template['ship_class'] == 0) {
	if (($game->player['user_max_colo'] != 0) && (min($num) > $game->player['user_max_colo']))
		return (int)$game->player['user_max_colo'];
}
return min($num);

}

function CreateResourceRequestedText($template,$player,$planet)
{
	global $game,$UNIT_NAME;

	$text = '';
	// Create popup text with needed resources:

	$req = floor($planet['resource_1']-$template['resource_1']);
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_metal_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.constant($game->sprache("TEXT63")).'<br>';

	$req = floor($planet['resource_2']-$template['resource_2']);
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_mineral_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.constant($game->sprache("TEXT64")).'<br>';

	$req = floor($planet['resource_3']-$template['resource_3']);
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_latinum_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.constant($game->sprache("TEXT65")).'<br>';

	$req = floor($planet['resource_4']-$template['resource_4']);
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_worker_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.constant($game->sprache("TEXT66")).'<br>';

	$req = $planet['unit_5']-$template['unit_5'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit5_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][4]).'<br>';

	$req = $planet['unit_6']-$template['unit_6'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit6_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][5]).'<br>';

	$req = $planet['unit_1']-$template['min_unit_1'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit1_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][0]).'<br>';

	$req = $planet['unit_2']-$template['min_unit_2'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit2_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][1]).'<br>';

	$req = $planet['unit_3']-$template['min_unit_3'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit3_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][2]).'<br>';

	$req = $planet['unit_4']-$template['min_unit_4'];
	if ($req < 0)
		$text .= '<img src='.$game->GFX_PATH.'menu_unit4_small.gif>&nbsp;'.abs($req).'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$player['user_race']][3]).'<br>';

	return $text;
}


function CreateInfoText($template)

{

global $db;

global $game;

global $ship_components;

$text='<table width=500 border=0 cellpadding=0 cellspacing=0><tr><td width=250><table width=* border=0 cellpadding=0 cellspacing=0><tr><td valign=top><u>'.constant($game->sprache("TEXT3")).'</u><br><b>'.$template['name'].'</b><br><br></td></tr><tr><td valign=top><u>'.constant($game->sprache("TEXT4")).'</u><br>'.str_replace("\r\n", '<br>',wordwrap($template['description'], 40,"<br>",1 )).'<br><br></td></tr><tr><td valign=top><u>'.constant($game->sprache("TEXT5")).'</u><br><img src='.FIXED_GFX_PATH.'ship'.$game->player['user_race'].'_'.$template['ship_torso'].'.jpg></td></tr><tr><td valign=top><u>'.constant($game->sprache("TEXT6")).'</u><br>';



for ($t=0; $t<10; $t++)

{

if ($template['component_'.($t+1)]>=0)

{

$text.='-&nbsp;'.( ($game->planet['catresearch_'.($t+1).'']<=$template['component_'.($t+1).'']) ? '<b><font color=red>'.$ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]['name'].'</font></b>' : '<b><font color=green>'.$ship_components[$game->player['user_race']][$t][$template['component_'.($t+1)]]['name'].'</font></b>' ).'<br>';

} else $text.=constant($game->sprache("TEXT7"));

}

$text.='<br></td></tr></table></td><td width=250><table width=* border=0 cellpadding=0 cellspacing=0><tr><td valign=top><u>'.constant($game->sprache("TEXT8")).'</u><br>';



$text.='<u>'.constant($game->sprache("TEXT9")).'</u> <b>'.$template['value_1'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT10")).'</u> <b>'.$template['value_2'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT11")).'</u> <b>'.$template['value_3'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT12")).'</u> <b>'.$template['value_4'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT13")).'</u> <b>'.$template['value_5'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT14")).'</u> <b>'.$template['value_6'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT15")).'</u> <b>'.$template['value_7'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT16")).'</u> <b>'.$template['value_8'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT17")).'</u> <b>'.$template['value_9'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT18")).'</u> <b>'.$template['value_10'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT19")).'</u> <b>'.$template['value_11'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT20")).'</u> <b>'.$template['value_12'].'</b><br>';

$text.='<u>'.constant($game->sprache("TEXT21")).'</u> <b>'.$template['value_14'].'/'.$template['value_13'].'</b><br>';



$text.='<br></td></tr><tr><td valign=top><u>'.constant($game->sprache("TEXT22")).'</u><br><img src='.$game->GFX_PATH.'menu_metal_small.gif>'.$template['resource_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif>'.$template['resource_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif>'.$template['resource_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif>'.$template['resource_4'].'<br>&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif>'.$template['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif>'.$template['unit_6'].'<br><br><u>'.constant($game->sprache("TEXT23")).'</u><br>'.(Zeit($template['buildtime']*TICK_DURATION)).'<br><br><u>'.constant($game->sprache("TEXT24")).'</u><br><img src='.$game->GFX_PATH.'menu_unit1_small.gif>'.$template['min_unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif>'.$template['min_unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif>'.$template['min_unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif>'.$template['min_unit_4'].'</td></tr></table></td></tr></table>';
$text.='</td></tr></table></td></tr></table>';



//$text=str_replace("'",'&acute;',$text);

$text=addslashes($text);

$text=str_replace('"','&quot;',$text);

return $text;

}




function Abort_Build()

{

global $db;

global $game;

global $SHIP_NAME, $UNIT_NAME, $SHIP_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

// New: Table locking

$db->lock('scheduler_shipbuild', 'ship_templates');

$game->init_player();



$schedulerquery=$db->query('SELECT * FROM scheduler_shipbuild WHERE planet_id="'.$game->planet['planet_id'].'"');

$addplanet['resource_1']=0;

$addplanet['resource_2']=0;

$addplanet['resource_3']=0;

$addplanet['resource_4']=0;

$addplanet['unit_5']=0;

$addplanet['unit_6']=0;

$addplanet['unit_1']=0;

$addplanet['unit_2']=0;

$addplanet['unit_3']=0;

$addplanet['unit_4']=0;



while (($scheduler = $db->fetchrow($schedulerquery))==true)

	{



        if (($db->query('DELETE FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (finish_build="'.$scheduler['finish_build'].'") LIMIT 1'))==true)

        {

       	$template=$db->queryrow('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$scheduler['ship_type'].'")');

  		$addplanet['resource_1']+=$template['resource_1'];

		$addplanet['resource_2']+=$template['resource_2'];

		$addplanet['resource_3']+=$template['resource_3'];

		$addplanet['resource_4']+=$template['resource_4'];

		$addplanet['unit_5']+=$template['unit_5'];

		$addplanet['unit_6']+=$template['unit_6'];

		$addplanet['unit_1']+=$scheduler['unit_1'];

		$addplanet['unit_2']+=$scheduler['unit_2'];

		$addplanet['unit_3']+=$scheduler['unit_3'];

		$addplanet['unit_4']+=$scheduler['unit_4'];

        }

        else

        {

        $game->out('<span style="font-family:Arial,serif;font-size:11pt"><b>'.constant($game->sprache("TEXT25")).'</b></span><br>');

        }



    }

    $db->query('UPDATE planets SET resource_1=resource_1+'.$addplanet['resource_1'].', resource_2=resource_2+'.$addplanet['resource_2'].', resource_3=resource_3+'.$addplanet['resource_3'].', resource_4=resource_4+'.$addplanet['resource_4'].', unit_1=unit_1+'.$addplanet['unit_1'].', unit_2=unit_2+'.$addplanet['unit_2'].', unit_3=unit_3+'.$addplanet['unit_3'].', unit_4=unit_4+'.$addplanet['unit_4'].', unit_5=unit_5+'.$addplanet['unit_5'].', unit_6=unit_6+'.$addplanet['unit_6'].' WHERE planet_id= "'.$game->planet['planet_id'].'"');

   // New: Table locking

	$db->unlock();

	$game->init_player();

}



function Start_Build()

{

global $db;

global $game;

global $SHIP_NAME, $UNIT_NAME, $SHIP_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

$_REQUEST['count']=(int)$_REQUEST['count'];

$_REQUEST['count1']=(int)$_REQUEST['count1'];

$_REQUEST['count2']=(int)$_REQUEST['count2'];

$_REQUEST['count3']=(int)$_REQUEST['count3'];

$_REQUEST['count4']=(int)$_REQUEST['count4'];

$_REQUEST['id']=(int)$_REQUEST['id'];



if ($_REQUEST['count']<=0) exit(0);

$t=$_REQUEST['id'];



if (!isset($_REQUEST['count1']) || empty($_REQUEST['count1'])) $_REQUEST['count1']=0;

if (!isset($_REQUEST['count2']) || empty($_REQUEST['count2'])) $_REQUEST['count2']=0;

if (!isset($_REQUEST['count3']) || empty($_REQUEST['count3'])) $_REQUEST['count3']=0;

if (!isset($_REQUEST['count4']) || empty($_REQUEST['count4'])) $_REQUEST['count4']=0;



$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) AND (id="'.$t.'")');

if (($template=$db->fetchrow($templatequery))!=true) exit(0);



$template['buildtime']=$template['buildtime']+round($template['buildtime']*0.3*(0.9-(0.1*$game->planet['building_8'])),0);



// New: Table locking

$db->lock('scheduler_shipbuild', 'ship_templates', 'ship_ccategory', 'ship_components');

$game->init_player();


// You cannot have more than user_max_colo colony ship at same time
if($template['ship_torso'] == 2 && $template['ship_class'] == 0) {
	if (($game->player['user_max_colo'] != 0) && ($_REQUEST['count'] > $game->player['user_max_colo']))	$_REQUEST['count'] = $game->player['user_max_colo'];
}

if (CanAffordTemplate($template,$game->player,$game->planet)>=$_REQUEST['count'] && CanAffordTemplateUnits($_REQUEST['count1'],$_REQUEST['count2'],$_REQUEST['count3'],$_REQUEST['count4'],$_REQUEST['count'],$template,$game->planet) && TemplateMetRequirements($template))

{

if ($game->planet['building_8']<1) {exit();}

else

{

	if (($db->query('UPDATE planets SET resource_1=resource_1-'.($template['resource_1']*$_REQUEST['count']).', resource_2=resource_2-'.($template['resource_2']*$_REQUEST['count']).', resource_3=resource_3-'.($template['resource_3']*$_REQUEST['count']).', resource_4=resource_4-'.($template['resource_4']*$_REQUEST['count']).', unit_5=unit_5-'.($template['unit_5']*$_REQUEST['count']).', unit_6=unit_6-'.($template['unit_6']*$_REQUEST['count']).', unit_1=unit_1-'.($_REQUEST['count1']*$_REQUEST['count']).', unit_2=unit_2-'.($_REQUEST['count2']*$_REQUEST['count']).', unit_3=unit_3-'.($_REQUEST['count3']*$_REQUEST['count']).', unit_4=unit_4-'.($_REQUEST['count4']*$_REQUEST['count']).' WHERE planet_id= "'.$game->planet['planet_id'].'"'))==true)

	{

		$schedulerquery=$db->query('SELECT * FROM scheduler_shipbuild WHERE planet_id= "'.$game->planet['planet_id'].'" ORDER BY finish_build DESC LIMIT 1');

		$start_time=$ACTUAL_TICK;

		if ($db->num_rows()>0) {$scheduler = $db->fetchrow($schedulerquery); $start_time=$scheduler['finish_build'];}

		for ($x=0; $x<$_REQUEST['count']; $x++)

		{

			if ($db->query('INSERT INTO scheduler_shipbuild (ship_type,planet_id,start_build,finish_build,unit_1,unit_2,unit_3,unit_4)

					VALUES ("'.($_REQUEST['id']).'","'.$game->planet['planet_id'].'","'.$start_time.'","'.($start_time+$template['buildtime']).'","'.$_REQUEST['count1'].'","'.$_REQUEST['count2'].'","'.$_REQUEST['count3'].'","'.$_REQUEST['count4'].'")')==false)  {message(DATABASE_ERROR, 'ship_query: Could not call INSERT INTO in scheduler_shipbuild'); exit();}



			$start_time+=$template['buildtime'];

		}



	}

}



}

else  // Not enough resources

{

$text='';

if (CanAffordTemplate($template,$game->player,$game->planet)<$_REQUEST['count']) $text.=constant($game->sprache("TEXT26"));

if (!CanAffordTemplateUnits($_REQUEST['count1'],$_REQUEST['count2'],$_REQUEST['count3'],$_REQUEST['count4'],$_REQUEST['count'],$template,$game->planet)) $text.=constant($game->sprache("TEXT27"));

if (!TemplateMetRequirements($template)) $text.=constant($game->sprache("TEXT28"));

$game->out('<span style="font-family:Arial,serif;font-size:11pt"><b>'.constant($game->sprache("TEXT29")).'<br>'.$text.'</b></span><br>');

}



// New: Table locking

$db->unlock();

$game->init_player();

}

















function Show_Common_Menues()

{

global $db;

global $game;

global $SHIP_NAME, $SHIP_DESCRIPTION, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME, $SHIP_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK, $LAST_TICK_TIME;





///////////////////////// 1st Build in Progress & Queue

$schedulerquery=$db->query('SELECT * FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (start_build<='.$ACTUAL_TICK.') ORDER BY start_build ASC');

$display=0;

if ($db->num_rows()>0)

{

$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT30")).' '.HelpPopup('shipyard_3').':</span><br><br>');

$scheduler = $db->fetchrow($schedulerquery);

$template=$db->queryrow('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$scheduler['ship_type'].'")');

$game->out('

<table border=0 cellpadding=1 cellspacing=1 width=300 class="style_outer"><tr><td>
<table border=0 cellpadding=1 cellspacing=1 width=300 class="style_inner"><tr><td>

<span class="sub_caption2">'.constant($game->sprache("TEXT31")).' <a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($template).'\', CAPTION, \''.addslashes($template['name']).'\', WIDTH, 500, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span class="sub_caption2">'.$template['name'].'</span></a></span><br>

'.constant($game->sprache("TEXT32")).'

<b id="timer2" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($scheduler['finish_build']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b><br><br>


<center>
<form name="abort" method="post" action="index.php?a=shipyard&a2=abort_build" onSubmit="return document.abort.submita.disabled = true;">

<input type="hidden" name="correct_abort" value="1">

<input type="submit" name="submita" class="button" style="width: 200px;" value ="'.constant($game->sprache("TEXT33")).'">

</form>
</center>
');

$display=1;

}



if (isset($_REQUEST['show_queue']))

{

$schedulerquery=$db->query('SELECT ship_type, finish_build FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (start_build>='.$ACTUAL_TICK.') ORDER BY start_build ASC');

if ($db->num_rows()>0)

{

$game->out('<br><span class="sub_caption2">'.constant($game->sprache("TEXT34")).'</span><br>(<a href="'.parse_link('a=shipyard').'">'.constant($game->sprache("TEXT35")).'</a>)<br>');



while(($scheduler = $db->fetchrow($schedulerquery))==true)

{

$template=$db->queryrow('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (id="'.$scheduler['ship_type'].'")');

$game->out('-&nbsp; <a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($template).'\', CAPTION, \''.addslashes($template['name']).'\', WIDTH, 
500, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$template['name'].'</a> ('.constant($game->sprache("TEXT36")).' '.date("d.M H:i",time()+$NEXT_TICK+(($scheduler['finish_build']-$ACTUAL_TICK)*TICK_DURATION*60)).' '.constant($game->sprache("TEXT37")).')<br>');}

} // End of: "if ($db->num_rows()>0)"

} // End of "if (isset($_REQUEST['show_queue']))"

else

{

$schedulerquery=$db->queryrow('SELECT COUNT(ship_type) AS num FROM scheduler_shipbuild WHERE (planet_id="'.$game->planet['planet_id'].'") AND (start_build>='.$ACTUAL_TICK.')');

if ($schedulerquery['num']>0)

{

$game->out('<br><span class="sub_caption2">'.constant($game->sprache("TEXT34")).' '.$schedulerquery['num'].' '.constant($game->sprache("TEXT38")).'</span><br>(<a href="'.parse_link('a=shipyard&show_queue=1').'">'.constant($game->sprache("TEXT39")).'</a>)<br>');

}

}



if ($display) $game->out('</td></tr></table></td></tr></table><br>');







///////////////////////// 2nd Unit Menu



$game->out(constant($game->sprache("TEXT40")).'<br><br>');


/* 19/10/08 - AC: Vediam che succede se lo disattivo...
$game->out('



<table border=0 cellpadding=0 cellspacing=0 width=200 class="style_outer">

<tr><td width=200 align="center">

<span class="sub_caption2">'.constant($game->sprache("TEXT41")).'</span><br><br>

<table border=0 cellpadding=0 cellspacing=0 width=200 class="style_inner">

<tr><td width=200>

');



$t=0; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][0].' (1)</b></a>: '.$game->planet['unit_1'].'<br>');

$t=1; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][1].' (2)</b></a>: '.$game->planet['unit_2'].'<br>');

$t=2; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][2].' (3)</b></a>: '.$game->planet['unit_3'].'<br>');

$t=3; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][3].' (4)</b></a>: '.$game->planet['unit_4'].'<br>');

$t=4; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][4].' (5)</b></a>: '.$game->planet['unit_5'].'<br>');

$t=5; $game->out('<img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit($t).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][5].' (6)</b></a>: '.$game->planet['unit_6'].'<br>');

$game->out('</td></tr></table></td></tr></table><br>



');*/

}









function Show_Build()

{

global $db;

global $game;

global $SHIP_NAME, $SHIP_DESCRIPTION, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME, $SHIP_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;



if ($_REQUEST['count']<=0) exit();



Show_Common_Menues();



///////////////////////// 3rd Ship template menu

$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT45")).' '.HelpPopup('shipyard_2').':</span><br><br>');

$game->out('<table border=0 cellpadding=2 cellspacing=2 width=400 class="style_outer"><tr><td>');





$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0) AND (id="'.$_REQUEST['id'].'")');

if (($template=$db->fetchrow($templatequery))!=true) exit(0);





$maxunit[0]=$maxunit[1]=$maxunit[2]=$maxunit[3]=0;

if ($game->planet['unit_1']>0) $maxunit[0]=floor($game->planet['unit_1']/$_REQUEST['count']); else $maxunit[0]=0;

if ($game->planet['unit_2']>0) $maxunit[1]=floor($game->planet['unit_2']/$_REQUEST['count']); else $maxunit[1]=0;

if ($game->planet['unit_3']>0) $maxunit[2]=floor($game->planet['unit_3']/$_REQUEST['count']); else $maxunit[2]=0;

if ($game->planet['unit_4']>0) $maxunit[3]=floor($game->planet['unit_4']/$_REQUEST['count']); else $maxunit[3]=0;

if ($maxunit[0]>$template['max_unit_1']) $maxunit[0]=$template['max_unit_1'];

if ($maxunit[1]>$template['max_unit_2']) $maxunit[1]=$template['max_unit_2'];

if ($maxunit[2]>$template['max_unit_3']) $maxunit[2]=$template['max_unit_3'];

if ($maxunit[3]>$template['max_unit_4']) $maxunit[3]=$template['max_unit_4'];





$game->out('<span class="sub_caption2">'.constant($game->sprache("TEXT46")).' "'.$_REQUEST['count'].'x <a href="javascript:void(0);" onmouseover="return overlib(\''.CreateInfoText($template).'\', CAPTION, \''.addslashes($template['name']).'\', WIDTH, 500, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span class="sub_caption2">'.$template['name'].'</span></a>" '.constant($game->sprache("TEXT47")).'</span><br>

<form name="send" method="post" action="index.php?a=shipyard&a2=start_build&id='.$template['id'].'" onSubmit="return document.send.submit.disabled = true;">
<script type="text/javascript" language="JavaScript">
function maximum()
{
document.getElementsByName("count1")[0].value='.$maxunit[0].';
document.getElementsByName("count2")[0].value='.$maxunit[1].';
document.getElementsByName("count3")[0].value='.$maxunit[2].';
document.getElementsByName("count4")[0].value='.$maxunit[3].';
}
</script>

<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width=400>

<tr>

<td width=200><img src="'.$game->GFX_PATH.'menu_unit'.(1).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][0].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit(0).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[0][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit(0).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[0][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][0].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][0].' </b></a>

&nbsp;('.$template['min_unit_1'].'-'.$template['max_unit_1'].')

</td>

<td width=200><input type="text" name="count1" size="6" class="field_nosize" value="'.$template['min_unit_1'].'"></td>

</tr>



<tr>

<td><img src="'.$game->GFX_PATH.'menu_unit'.(2).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][1].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit(1).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[1][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit(1).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[1][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][1].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][1].' </b></a>

&nbsp;('.$template['min_unit_2'].'-'.$template['max_unit_2'].')

</td>

<td><input type="text" name="count2" size="6" class="field_nosize" value="'.$template['min_unit_2'].'"></td>

</tr>



<tr>

<td><img src="'.$game->GFX_PATH.'menu_unit'.(3).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][2].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit(2).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[2][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit(2).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[2][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][2].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][2].' </b></a>

&nbsp;('.$template['min_unit_3'].'-'.$template['max_unit_3'].')

</td>

<td><input type="text" name="count3" size="6" class="field_nosize" value="'.$template['min_unit_3'].'"></td>

</tr>



<tr>

<td><img src="'.$game->GFX_PATH.'menu_unit'.(4).'_small.gif">&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][3].'<br><u>'.constant($game->sprache("TEXT42")).'</u> '.GetAttackUnit(3).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[3][5].')<br><u>'.constant($game->sprache("TEXT44")).'</u> '.GetDefenseUnit(3).' ('.constant($game->sprache("TEXT43")).' '.$UNIT_DATA[3][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][3].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><b>'.$UNIT_NAME[$game->player['user_race']][3].' </b></a>

&nbsp;('.$template['min_unit_4'].'-'.$template['max_unit_4'].')

</td>

<td><input type="text" name="count4" size="6" class="field_nosize" value="'.$template['min_unit_4'].'"></td>

</tr><tr>

<td colspan=2 align="center">

</b><i>'.constant($game->sprache("TEXT48")).'</i>
<br>
<br><a href="javascript:maximum();"><u>'.constant($game->sprache("TEXT49")).'</u></a>
<br>



<input type="hidden" name="correct_start" value="1">

<input type="hidden" name="count" value="'.$_REQUEST['count'].'">

<input type="hidden" name="id" value="'.$_REQUEST['id'].'"><br>

<input type="submit" name="submit" class="button" value ="'.constant($game->sprache("TEXT50")).'">

</form>

</td>

</tr>

</table>

</td></tr></table>');

}





function Show_Main()

{

global $db;

global $game;

global $SHIP_TORSO, $SHIP_DESCRIPTION, $UNIT_DESCRIPTION, $UNIT_DATA, $UNIT_NAME, $SHIP_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;



Show_Common_Menues();



///////////////////////// 3rd Ship template menu

$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT45")).' '.HelpPopup('shipyard_1').' :</span><br><br>');

$game->out('<table border=0 cellpadding=2 cellspacing=2 width=500 class="style_outer"><tr><td width=500>');





$game->out('<table border=0 cellpadding=2 cellspacing=2 width=500 class="style_inner"><tr><td width=200><span class="sub_caption2">'.constant($game->sprache("TEXT51")).'</b></td><td width=175><span class="sub_caption2">'.constant($game->sprache("TEXT52")).'</span></td><td width=120><span class="sub_caption2">'.constant($game->sprache("TEXT53")).'</span></td></tr>');

$templatequery=$db->query('SELECT * FROM ship_templates WHERE (owner="'.$game->player['user_id'].'") AND (removed=0)  ORDER BY ship_torso ASC, name ASC');

$number=$db->num_rows();

if ($number>0)

{

$torso_num=-1;

while (($template=$db->fetchrow($templatequery))==true)

{

if ($template['ship_torso']!=$torso_num)

{

	$game->out('<tr height=8><td></td><td></td><td></td></tr>');

	$torso_num=$template['ship_torso'];

	$game->out('<tr height=10><td width=200><b><u>'.$SHIP_TORSO[$game->player['user_race']][$template['ship_torso']][29].':<br></b></u></td><td></td><td></td></tr>');



}





$template['buildtime']=$template['buildtime']+round($template['buildtime']*0.3*(0.9-(0.1*$game->planet['building_8'])),0);

$maxnum = 0;

if (!TemplateMetRequirements($template))

{

$build_text='&nbsp;&nbsp;<span style="color: red">'.constant($game->sprache("TEXT54")).'</span>';

}

else if (($maxnum=CanAffordTemplate($template,$game->player,$game->planet)))

{

$build_text='<input type="hidden" name="correct" value="1"><input type="submit" name="submit" class="button" style="width: 60px;" value ="'.constant($game->sprache("TEXT54")).'">';

}

else

{


$build_text='&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateResourceRequestedText($template,$game->player,$game->planet).'\', CAPTION, \''.constant($game->sprache("TEXT67")).'\', WIDTH, 170, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><span style="color: yellow">'.constant($game->sprache("TEXT54")).'</span></a>';

}


$game->out('<tr height=15><td width=200><b><a href="'.parse_link('a=ship_template&view=compare&ship0='.$template['id']).'" onmouseover="return overlib(\''.CreateInfoText($template).'\', CAPTION, \''.addslashes($template['name']).'\', WIDTH, 500, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$template['name'].'</a></b></td><td>'.(Zeit($template['buildtime']*TICK_DURATION)).'</td><td>');


$game->out('<form name="send'.$template['id'].'" method="post" action="index.php?a=shipyard&a2=start_build&id='.$template['id'].'" onSubmit="return document.send'.$template['id'].'.submit.disabled = true;"><input type="text" name="count" size="4" class="field_nosize" value="'.$maxnum.'">&nbsp;&nbsp;&nbsp;'.$build_text.'</td></tr></form>');

}

$game->out('<tr><td colspan=4><br><i>'.constant($game->sprache("TEXT55")).'<br><b><font color=red>'.constant($game->sprache("TEXT56")).'</font><br><font color=green>'.constant($game->sprache("TEXT57")).'</font></b></i></td></tr></table>');

}

else

{

$game->out('</table><br><br><b>'.constant($game->sprache("TEXT58")).'</b></u><br><br>');



}

$game->out('</td></tr></table>');

}











if ($game->planet['building_8']<1)

{

message(NOTICE, constant($game->sprache("TEXT59")).' '.$BUILDING_NAME[$game->player['user_race']][7].' '.constant($game->sprache("TEXT60")));
//$game->out('<span class="text_large">'.constant($game->sprache("TEXT59")).' '.$BUILDING_NAME[$game->player['user_race']]['7'].' '.constant($game->sprache("TEXT60")).'</span><br><br>');

}

else

{



$sub_action = (!empty($_GET['a2'])) ? $_GET['a2'] : 'main';



if ($sub_action=='start_build' && isset($_POST['correct']) )

{

Show_Build();

}

if ($sub_action=='start_build' && isset($_POST['correct_start']) )

{

Start_Build(); $sub_action='main';

}

if ($sub_action=='abort_build' && isset($_POST['correct_abort']))

{

Abort_Build(); $sub_action='main';

}

if ($sub_action=='main')

{

if ($game->planet['min_troops_required']<=0 || 70<round(100*round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)/$game->planet['min_troops_required'],0))

Show_Main();

else

$game->out('<table width="450" border="0" align="center">

  <tr>

    <td>'.constant($game->sprache("TEXT61")).' <b>'.round(100*round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)/$game->planet['min_troops_required'],0).'%</b> '.constant($game->sprache("TEXT62")).'

    </td>

  </tr>

</table>

<br><br>

');


}

}

?>
