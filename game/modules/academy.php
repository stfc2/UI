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
$game->out('<span class="caption">'.$BUILDING_NAME[$game->player['user_race']][5].':</span><br><br>');

function UnitMetRequirements($unit)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
if (($unit==0 && $game->planet['building_6']<1) || ($unit==1 && $game->planet['building_6']<5) || ($unit==2 && ($game->planet['building_6']<9 || $game->planet['building_9']<1)) || ($unit==3 && $game->planet['building_6']<1) || ($unit==4 && $game->planet['building_6']<1) || ($unit==5 && $game->planet['building_6']<1))
return 0;
return 1;
}



function UnitPrice($unit,$resource)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

$price = $UNIT_DATA[$unit][$resource];
$price*= $RACE_DATA[$game->player['user_race']][6];
return round($price,0);
}


function UnitTime($unit)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

$time=$UNIT_DATA[$unit][4];
$time*=$RACE_DATA[$game->player['user_race']][2];
$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));
if ($time<1) $time=1;
$time=round($time,0);
$time*=TICK_DURATION;
return (Zeit($time));
}

function UnitTimeTicks($unit)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

$time=$UNIT_DATA[$unit][4];
$time*=$RACE_DATA[$game->player['user_race']][2];
$time/=100;
$time*=(100-2*($game->planet['research_4']*$RACE_DATA[$game->player['user_race']][20]));

if ($time<1) $time=1;
$time=round($time,0);

return $time;
}

function Stop_Train()
{
global $db;
global $game;
global $UNIT_NAME, $UNIT_DESCRIPTION, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$db->query('UPDATE planets SET unittrainid_nexttime="-1" WHERE planet_id="'.$game->planet['planet_id'].'"');
$game->planet['unittrainid_nexttime']=0;
}

function Start_Train()
{
global $db;
global $game;
global $UNIT_NAME, $UNIT_DESCRIPTION, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
if ($game->planet['unittrainid_nexttime']>0) return 0;

		// 1. Jump to the next unit + new time set:
		// First:
		$started=0;
		$tries=0;
		while ($started==0 && $tries<=10)
		{
			if ($game->planet['unittrain_actual']>10) $game->planet['unittrain_actual']=1;
			if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]<13 && $game->planet['unittrainid_'.($game->planet['unittrain_actual'])]>=0 &&  $game->planet['unittrainnumberleft_'.($game->planet['unittrain_actual'])]>0)
			{
				// If Unit
				if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]<7) {$db->query('UPDATE planets SET unittrain_actual="'.($game->planet['unittrain_actual']).'",unittrainid_nexttime="'.($ACTUAL_TICK+UnitTimeTicks($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]-1)).'" WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1');}
				else // If Break
				{
					if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==10) {$db->query('UPDATE planets SET unittrain_actual="'.($game->planet['unittrain_actual']).'",unittrainid_nexttime="'.($ACTUAL_TICK+1).'" WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1');}
					if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==11) {$db->query('UPDATE planets SET unittrain_actual="'.($game->planet['unittrain_actual']).'",unittrainid_nexttime="'.($ACTUAL_TICK+9).'" WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1');}
					if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==12) {$db->query('UPDATE planets SET unittrain_actual="'.($game->planet['unittrain_actual']).'",unittrainid_nexttime="'.($ACTUAL_TICK+18).'" WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1');}
				}
				$started=1;
			}

			if (!$started)
			{
				$tries++;
				$db->query('UPDATE planets SET unittrain_actual="1" WHERE planet_id="'.$game->planet['planet_id'].'"');
			}

			$game->planet['unittrain_actual']++;
		}


}

function Reset_List()
{
	global $game,$db;

	$db->query('UPDATE planets SET
	                   unittrainid_1  = 0,
	                   unittrainid_2  = 0,
	                   unittrainid_3  = 0,
	                   unittrainid_4  = 0,
	                   unittrainid_5  = 0,
	                   unittrainid_6  = 0,
	                   unittrainid_7  = 0,
	                   unittrainid_8  = 0,
	                   unittrainid_9  = 0,
	                   unittrainid_10 = 0,
	                   unittrainnumber_1  = 0,
	                   unittrainnumber_2  = 0,
	                   unittrainnumber_3  = 0,
	                   unittrainnumber_4  = 0,
	                   unittrainnumber_5  = 0,
	                   unittrainnumber_6  = 0,
	                   unittrainnumber_7  = 0,
	                   unittrainnumber_8  = 0,
	                   unittrainnumber_9  = 0,
	                   unittrainnumber_10 = 0,
	                   unittrainnumberleft_1  = 0,
	                   unittrainnumberleft_2  = 0,
	                   unittrainnumberleft_3  = 0,
	                   unittrainnumberleft_4  = 0,
	                   unittrainnumberleft_5  = 0,
	                   unittrainnumberleft_6  = 0,
	                   unittrainnumberleft_7  = 0,
	                   unittrainnumberleft_8  = 0,
	                   unittrainnumberleft_9  = 0,
	                   unittrainnumberleft_10 = 0,
	                   unittrainendless_1  = 0,
	                   unittrainendless_2  = 0,
	                   unittrainendless_3  = 0,
	                   unittrainendless_4  = 0,
	                   unittrainendless_5  = 0,
	                   unittrainendless_6  = 0,
	                   unittrainendless_7  = 0,
	                   unittrainendless_8  = 0,
	                   unittrainendless_9  = 0,
	                   unittrainendless_10 = 0,
	                   unittrain_actual = 1,
	                   unittrainid_nexttime=-1
	            WHERE planet_id="'.$game->planet['planet_id'].'"');
}

function Save_List()
{
global $db;
global $game;
global $UNIT_NAME, $UNIT_DESCRIPTION, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

for ($t=0; $t<10; $t++)
{
$_POST['listid_'.$t]=(int)$_POST['listid_'.$t];
$_POST['listnumber_'.$t]=(int)$_POST['listnumber_'.$t];
$_POST['listendless_'.$t]=(int)$_POST['listendless_'.$t];
if ($_POST['listid_'.$t]==-1) {$_POST['listnumber_'.$t]=$_POST['listendless_'.$t]=0;}

$db->query('UPDATE planets SET
unittrainid_'.($t+1).'="'.$_POST['listid_'.$t].'",
unittrainnumber_'.($t+1).'="'.$_POST['listnumber_'.$t].'",
unittrainnumberleft_'.($t+1).'="'.$_POST['listnumber_'.$t].'",
unittrainendless_'.($t+1).'="'.$_POST['listendless_'.$t].'"
WHERE planet_id="'.$game->planet['planet_id'].'" LIMIT 1');
}
Stop_Train();
redirect('a=academy&start_list=1');
}



function Show_Main()
{
global $db;
global $game;
global $UNIT_NAME, $UNIT_DESCRIPTION, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
$pow_factor=2;


///////////////////////// 1st Build in Progress
if ($game->planet['unittrainid_nexttime']>0)
{
$game->out('
<table border="0" cellpadding="1" cellspacing="1" width="350" class="style_outer"><tr><td>
<table border="0" cellpadding="1" cellspacing="1" width="350" class="style_inner"><tr><td>');

if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]<=6)
{
$game->out(constant($game->sprache("Text1")).' <b>'.$UNIT_NAME[$game->player['user_race']][$game->planet['unittrainid_'.($game->planet['unittrain_actual'])]-1].'</b><br>
	'.constant($game->sprache("Text2")));

if ($game->planet['unittrain_error']==0)
    $game->out('<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>');
else if ($game->planet['unittrain_error']==1)
    $game->out('<b>'.constant($game->sprache("Text3")).'</b>');
else
    $game->out('<b>'.constant($game->sprache("Text36")).'</b>');
}
else
{
$text=constant($game->sprache("Text26"));
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==11) $text=constant($game->sprache("Text27"));
if ($game->planet['unittrainid_'.($game->planet['unittrain_actual'])]==12) $text=constant($game->sprache("Text28"));
$game->out(constant($game->sprache("Text4")) .'- <b>'.$text.'</b><br>'.
constant($game->sprache("Text5")).'
<b id="timer3" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)).'_type1_1">&nbsp;</b>');
}
$game->out('</td></tr></table></td></tr></table><br>');

$game->set_autorefresh(($NEXT_TICK+TICK_DURATION*60*($game->planet['unittrainid_nexttime']-$ACTUAL_TICK)));
}


//////////////////////// 2nd Buildmenu
$game->out('<table border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer">
  <tr><td width=100%><span class="sub_caption2">'.constant($game->sprache("Text6")).'</span><br>
  <table border=0 cellpadding=1 cellspacing=1 width=398 class="style_inner">');

$game->out(constant($game->sprache("Text7")));
for ($t=0; $t<6; $t++)
{

if (UnitMetRequirements($t))
{
$game->out('<tr height=20><td><img src="'.$game->GFX_PATH.'menu_unit'.($t+1).'_small.gif">&nbsp;<b><a href="javascript:void(0);" onmouseover="return overlib(\''.$UNIT_DESCRIPTION[$game->player['user_race']][$t].constant($game->sprache("Text8")).GetAttackUnit($t).constant($game->sprache("Text9")).$UNIT_DATA[$t][5].constant($game->sprache("Text10")).GetDefenseUnit($t).constant($game->sprache("Text9")).$UNIT_DATA[$t][6].')\', CAPTION, \''.$UNIT_NAME[$game->player['user_race']][$t].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$UNIT_NAME[$game->player['user_race']][$t].' ('.$game->planet['unit_'.($t+1).''].')</a></b></td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.UnitPrice($t,0).'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.UnitPrice($t,1).'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.UnitPrice($t,2).'&nbsp;&nbsp; <img src="'.$game->GFX_PATH.'menu_worker_small.gif"> '.UnitPrice($t,3).'</td><td>'.UnitTime($t).'</td></tr>');
}
}

$game->out('</td></tr></table></td></tr></table>');


$game->out('<br><span class="sub_caption">'.constant($game->sprache("Text11")).HelpPopup('academy_1').' :</span><br><br>
<table border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer"><tr><td width=100%><span class="sub_caption2">');
if ($game->planet['unittrainid_nexttime']>0) $game->out(constant($game->sprache("Text12")));
else $game->out(constant($game->sprache("Text13")));
$game->out('</span>');
$game->out('<table border="0" cellpadding="2" cellspacing="2" width="400" class="style_inner">
<tr><td align="center">
<br>
<form name="academy" method="post" action="'.GAME_EXE.'?a=academy"><input type="submit" name="start_list" class="button_nosize" value="'.constant($game->sprache("Text23")).'">&nbsp;&nbsp;&nbsp;<input type="submit" name="stop_list" class="button_nosize" value="'.constant($game->sprache("Text24")).'"></form>

</td></tr></table></td></tr></table>');


$game->out('<br><span class="sub_caption">'.constant($game->sprache("Text14")).' '.HelpPopup('academy_2').' :</span><br>');
$game->out('<br><table border="0" cellpadding="2" cellspacing="2" width="400" class="style_outer"><tr><td width=100%>
<span class="sub_caption2">'.constant($game->sprache("Text15")).'</span><br>
<table border=0 cellpadding=2 cellspacing=2 width=398 class="style_inner">
<tr><td align="center">
<form name="academy" method="post" action="'.GAME_EXE.'?a=academy">
<table border=0 cellpadding=2 cellspacing=2 width=280><tr><td>&nbsp;</td>'.constant($game->sprache("Text16")).'</tr>');

for ($t=0; $t<10; $t++)
{
if ($game->planet['unittrain_actual']!=($t+1)) $game->out('<tr><td>&nbsp;</td><td width=40>'.($t+1).':</td>');
else $game->out('<tr><td><img src="'.$game->PLAIN_GFX_PATH.'arrow_right.png"></td><td width=40><b><u>'.($t+1).'</u></b>:</td>');
$game->out('<td width=150><select name="listid_'.$t.'" class="Select" size="1"><option value="-1">'.(constant($game->sprache("Text25"))).'</option>');
if ($game->planet['unittrainid_'.($t+1)]==10) $game->out(constant($game->sprache("Text17")));
else $game->out(constant($game->sprache("Text18")));
if ($game->planet['unittrainid_'.($t+1)]==11) $game->out(constant($game->sprache("Text31")));
else $game->out(constant($game->sprache("Text32")));
if ($game->planet['unittrainid_'.($t+1)]==12) $game->out(constant($game->sprache("Text33")));
else $game->out(constant($game->sprache("Text34")));

for ($u=0; $u<6; $u++)
{
if (UnitMetRequirements($u))
{
if ($game->planet['unittrainid_'.($t+1)]==($u+1)) $game->out('<option value="'.($u+1).'" selected>'.$UNIT_NAME[$game->player['user_race']][$u].'</option>');
else $game->out('<option value="'.($u+1).'">'.$UNIT_NAME[$game->player['user_race']][$u].'</option>');
}
}

$number=$game->planet['unittrainnumber_'.($t+1)];
if ($game->planet['unittrainendless_'.($t+1)]!=1) $number=$game->planet['unittrainnumberleft_'.($t+1)];

$game->out('
</select>
</td>
<td>
<input type="text" name="listnumber_'.$t.'" value="'.$number.'" class="Field_nosize" size="10" maxlength="5">
</td>
<td>
<input type="checkbox" name="listendless_'.$t.'" value="1" '.(( $game->planet['unittrainendless_'.($t+1)]) ? 'checked="checked"':'').'>
</select>
</td>

</tr>
');
}
$game->out('</table>'.constant($game->sprache("Text19")).'&nbsp;<img src="'.$game->PLAIN_GFX_PATH.'arrow_right.png">&nbsp;'.constant($game->sprache("Text19a")).'<br>
<input type="submit" name="exec_list" class="button_nosize" value="'.constant($game->sprache("Text22")).'">&nbsp;&nbsp;
<input type="submit" name="reset_list" class="button_nosize" value="'.constant($game->sprache("Text35")).'"></form></td></tr></table></td></tr></table>');
}




if ($game->planet['building_6']<1)
{
//$game->out('.$game->sprache('Text20').$BUILDING_NAME[$game->player['user_race']]['5'].$game->sprache('Text21'));
message(NOTICE, constant($game->sprache("Text20")).' '.$BUILDING_NAME[$game->player['user_race']][5].' '.constant($game->sprache("Text21")));
//$game->out(constant($game->sprache("Text20")).$BUILDING_NAME[$game->player['user_race']]['5'].constant($game->sprache("Text21")));
}
else
{
$sub_action = (!empty($_POST['a2'])) ? $_POST['a2'] : 'main';
if (isset($_POST['exec_list'])) 

if($_POST['listid_0'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}

elseif($_POST['listid_1'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}

elseif($_POST['listid_2'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_3'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}

elseif($_POST['listid_4'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}

elseif($_POST['listid_5'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_6'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_7'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_8'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_9'] == 2 && $game->planet['building_6'] < 5){

echo constant($game->sprache("Text29"));

}
elseif($_POST['listid_0'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}

elseif($_POST['listid_1'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}

elseif($_POST['listid_2'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}
elseif($_POST['listid_3'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}

elseif($_POST['listid_4'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}

elseif($_POST['listid_5'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}
elseif($_POST['listid_6'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}
elseif($_POST['listid_7'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}
elseif($_POST['listid_8'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}
elseif($_POST['listid_9'] == 3 && $game->planet['building_6'] < 9){

echo constant($game->sprache("Text30"));

}


else {
Save_List();
}
if (isset($_REQUEST['start_list']))
{
Start_Train();
redirect('a=academy');
}
if (isset($_POST['stop_list']))
{
Stop_Train();
redirect('a=academy');
}
if (isset($_POST['reset_list']))
{
Reset_List();
redirect('a=academy');
}
Show_Main();
}

?>
