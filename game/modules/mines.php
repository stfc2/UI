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

function ResourcesPerTickMetal() {
	$rid=0;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.25*(3*((pow(((3*$game->planet['rateo_1'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
   
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4));
	if($result < 10) $round = 1;
    else $round = 0;
    return round($result, $round);
}

function ResourcesPerTickMineral() {
	$rid=1;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.25*(3*((pow(((3*$game->planet['rateo_2'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*(round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)));
    if($result < 10) $round = 1;
    else $round = 0;
    return round($result, $round);
}

function ResourcesPerTickLatinum() {
	$rid=2;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.2*(3*((pow(((3*$game->planet['rateo_3'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*(round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)));
    if($result < 10) $round = 1;
    else $round = 0;
    return round($result, $round);
}

function ResourcesPerHourMetal() {
	$rid=0;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.25*(3*((pow(((3*$game->planet['rateo_1'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
   
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4));
	if($result < 10) $round = 1;
    else $round = 0;
    $result=$result*20;
    return round($result, $round);
}

function ResourcesPerHourMineral() {
	$rid=1;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.25*(3*((pow(((3*$game->planet['rateo_2'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*(round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)));
    if($result < 10) $round = 1;
    else $round = 0;
    $result=$result*20;
    return round($result, $round);
}

function ResourcesPerHourLatinum() {
	$rid=2;
    global $RACE_DATA,$PLANETS_DATA, $addres, $game;
    $result = 0.2*(3*((pow(((3*$game->planet['rateo_3'])*(1+$game->planet['building_'.($rid+2)])),1.35))/100*(50+ (50*(1/($game->planet['building_'.($rid+2)]*100+100))*($game->planet['workermine_'.($rid+1)]+100))))*($RACE_DATA[$game->player['user_race']][9+$rid]*($addres[$game->planet['research_5']]*$RACE_DATA[$game->player['user_race']][20])));
    if (round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required'])
    	$result=$result* (1/$game->planet['min_troops_required']*(round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)));
    if($result < 10) $round = 1;
    else $round = 0;
    $result=$result*20;
    return round($result, $round);
}

if(!empty($_POST['type'])) {
    $type = (int)$_POST['type'];

    if(!in_array((int)$type, array(1, 2, 3))) {
        message(GENERAL, constant($game->sprache("TEXT1")), '$_POST[\'type\'] = '.$type);
    }

    $worker = (int)$_POST['worker'];

    $db->lock();
    $game->init_player();

    if($game->planet['planet_id'] == $game->player['user_capital']) {
        $valid_workers = array(100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 1600);
    }
    else {
        $valid_workers = array(100, 200, 300, 400, 500, 600, 700, 800, 900, 1000);
    }

    if(!in_array($worker, $valid_workers)) {
        message(GENERAL, constant($game->sprache("TEXT2")), '$_POST[\'worker\'] = '.$worker);
    }

    if($worker > ($game->planet['building_'.($type + 1)] * 100 + 100) ) {
        message(NOTICE, constant($game->sprache("TEXT3")) );
    }

    $required_worker = ($worker - $game->planet['workermine_'.$type]);

    if($required_worker > 0) {
        if($required_worker > $game->planet['resource_4']) {
            message(NOTICE, constant($game->sprache("TEXT4")) );
        }

        $new_worker = $game->planet['resource_4'] - $required_worker;
    }
    else {
        $required_worker *= -1;

        if( ($game->planet['resource_4'] + $required_worker ) > $game->planet['max_worker']) {
            $new_worker = $game->planet['max_worker'];
        }
        else {
            $new_worker = $game->planet['resource_4'] + $required_worker;
        }
    }

    $sql = 'UPDATE planets
            SET resource_4 = '.$new_worker.',
                workermine_'.$type.' = '.$worker.',
                recompute_static = 1
            WHERE planet_id = '.$game->planet['planet_id'];

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update planets mines data');
    }

    $db->unlock();

    redirect('a=mines');
}
else {
    $game->init_player();

    $metal_option_html = $minerals_option_html = $latinum_option_html = '';

    $max_metal_worker = $game->planet['building_2'] * 100 + 100;
	$max_minerals_worker = $game->planet['building_3'] * 100 + 100;
    $max_latinum_worker = $game->planet['building_4'] * 100 + 100;

    // 24/02/09 - AC: This check was misplaced (no init_player() called yet) but.. it's really needed?
    if ($game->planet['workermine_1']<100) $game->planet['workermine_1']=100;
    if ($game->planet['workermine_2']<100) $game->planet['workermine_2']=100;
    if ($game->planet['workermine_3']<100) $game->planet['workermine_3']=100;
    //

    if( ($game->planet['workermine_1'] + $game->planet['resource_4']) < $max_metal_worker) $max_metal_worker = $game->planet['workermine_1'] + $game->planet['resource_4'];
    if( ($game->planet['workermine_2'] + $game->planet['resource_4']) < $max_minerals_worker) $max_minerals_worker = $game->planet['workermine_2'] + $game->planet['resource_4'];
    if( ($game->planet['workermine_3'] + $game->planet['resource_4']) < $max_latinum_worker) $max_latinum_worker = $game->planet['workermine_3'] + $game->planet['resource_4'];

    for($i = 100; $i <= $max_metal_worker; $i += 100) {
        $metal_option_html .= '<option value="'.$i.'"'.( ($game->planet['workermine_1'] == $i) ? ' selected="selected"' : '' ).'>'.$i.'</option>';
	}

	for($i = 100; $i <= $max_minerals_worker; $i += 100) {
        $minerals_option_html .= '<option value="'.$i.'"'.( ($game->planet['workermine_2'] == $i) ? ' selected="selected"' : '' ).'>'.$i.'</option>';
	}


	for($i = 100; $i <= $max_latinum_worker; $i += 100) {
		$latinum_option_html .= '<option value="'.$i.'"'.( ($game->planet['workermine_3'] == $i) ? ' selected="selected"' : '' ).'>'.$i.'</option>';
	}

     //Function Allianzsteuer von Output abziehen
     //Rewrite by Mojo1987

     $sql = 'SELECT taxes FROM alliance WHERE alliance_id = '.$game->player['user_alliance'];

      if(($alliance_taxes = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance_taxes data');
      }

     if($alliance_taxes['taxes']!=0) {

     $ress_tax = 1-$alliance_taxes['taxes']/100;

     }
     else {
     $ress_tax = 0;

     }
     //Debugfunction for Allytax by Mojo1987
     //echo $ress_tax;

    //Function Ende

    $game->out('
<script type="text/javascript" language="JavaScript">
<!--
function deactivate_buttons() {
    document.metal_form.submit.disabled = true;
    document.minerals_form.submit.disabled = true;
    document.latinum_form.submit.disabled = true;

    return true;
}
//-->
</script>

<span class="caption">'.constant($game->sprache("TEXT5")).'</span><br><br>

<table width="450" border="0" align="center">
  <tr>
    <td>'.constant($game->sprache("TEXT6")).'<br>'.constant($game->sprache("TEXT7")).'<br>'.constant($game->sprache("TEXT8")).'
    '.((round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)<$game->planet['min_troops_required']) ? '<br><u>'.constant($game->sprache("TEXT9")).round(100*round($game->planet['unit_1'] * 2 + $game->planet['unit_2'] * 3 + $game->planet['unit_3'] * 4 + $game->planet['unit_4'] * 4, 0)/$game->planet['min_troops_required'],0).'%</b> '.constant($game->sprache("TEXT10")).'</u>' : '' ).'
    </td>
  </tr>
</table>
<br><br>
<table width="450" align="center" border="0" cellpadding="1" cellspacing="1" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <form name="metal_form" method="post" action="'.parse_link('a=mines').'" onSubmit="return deactivate_buttons();">
  <tr>
    <td width="350"><b>'.$BUILDING_NAME[$game->player['user_race']][1].'</b> (<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;<b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerTickMetal().'' : ''.ResourcesPerTickMetal().'' ).'</b> <i>'.constant($game->sprache("TEXT11")).'</i> / <b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerHourMetal().'' : ''.ResourcesPerHourMetal().'' ).'</b> <i>'.constant($game->sprache("TEXT12")).'</i>)</td>
    <td width="100" rowspan="2" align="center" valign="middle"><input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT13")).'"></td>
  </tr>
  <tr>
    <td width="300">'.constant($game->sprache("TEXT14")).' <select name="worker">'.$metal_option_html.'</select></td>
  </tr>
  <input type="hidden" name="type" value="1">
  </form>
</table>
</td></tr></table>
<br><br>
<table width="450" align="center" border="0" cellpadding="1" cellspacing="1" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <form name="minerals_form" method="post" action="'.parse_link('a=mines').'" onSubmit="return deactivate_buttons();">
  <tr>
    <td width="350"><b>'.$BUILDING_NAME[$game->player['user_race']][2].'</b> (<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;<b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerTickMineral().'' : ''.ResourcesPerTickMineral().'' ).'</b> <i>'.constant($game->sprache("TEXT11")).'</i> / <b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerHourMineral().'' : ''.ResourcesPerHourMineral().'' ).'</b> <i>'.constant($game->sprache("TEXT12")).'</i>)</td>
    <td width="100" rowspan="2" align="center" valign="middle"><input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT13")).'"></td>
  </tr>
  <tr>
    <td width="300">'.constant($game->sprache("TEXT14")).' <select name="worker">'.$minerals_option_html.'</select></td>
  </tr>
  <input type="hidden" name="type" value="2">
  </form>
</table>
</td></tr></table>
<br><br>
<table width="450" align="center" border="0" cellpadding="1" cellspacing="1" class="style_outer"><tr><td>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
  <form name="latinum_form" method="post" action="'.parse_link('a=mines').'" onSubmit="return deactivate_buttons();">
  <tr>
    <td width="350"><b>'.$BUILDING_NAME[$game->player['user_race']][3].'</b> (<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;<b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerTickLatinum().'' : ''.ResourcesPerTickLatinum().'' ).'</b> <i>'.constant($game->sprache("TEXT11")).'</i> / <b>'.( ($ress_tax!=0) ? ''.$ress_tax*ResourcesPerHourLatinum().'' : ''.ResourcesPerHourLatinum().'' ).'</b> <i>'.constant($game->sprache("TEXT12")).'</i>)</td>
    <td width="100" rowspan="2" align="center" valign="middle"><input class="button" type="submit" name="submit" value="'.constant($game->sprache("TEXT13")).'"></td>
  </tr>
  <tr>
    <td width="300">'.constant($game->sprache("TEXT14")).' <select name="worker">'.$latinum_option_html.'</select></td>
  </tr>
  <input type="hidden" name="type" value="3">
  </form>
</table>
</td></tr></table>
    ');
}

?>
