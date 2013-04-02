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

ini_set('memory_limit', '24M');
include('include/libs/moves.php');
$game->init_player();

include('include/static/static_components.php');
$filename = 'include/static/static_components_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);


ini_set ('error_reporting', E_ALL);
    $STRADE_MODULES = array(
	'main' => constant($game->sprache("TEXT0")), // Show_Main
	'status_offer' => constant($game->sprache("TEXT1")), //Show_Status();
	'trade_buy_truppen' =>constant($game->sprache("TEXT2")), // Truppenhandel kaufen Trade_Buy_truppen
	'trade_sold_truppen' =>constant($game->sprache("TEXT3")), // Truppenhandel kaufen Trade_Sold_truppen
	'trade_ress'=>constant($game->sprache("TEXT4")), //Resshandel
/* 27/08/08 - AC: Auctions are disabled on second galaxy
	'create_bidding' => constant($game->sprache("TEXT5")), //Show_CreateBidding();
	'view_bidding' => constant($game->sprache("TEXT6")), //Show_Bidding();
	'view_own_bidding' => constant($game->sprache("TEXT7")), //Show_Bidding(1);
	'own_bidding' => constant($game->sprache("TEXT8")), //Show_Bidding(1);
	'konto_status' => constant($game->sprache("TEXT9")), //Konto_Status
	'status_bezahlen'=>constant($game->sprache("TEXT10")),//Show_schulden
	'warteschlange'=>constant($game->sprache("TEXT11")), //Ship_warten*/

    );
function vergleich($wert1,$wert2)
{
	return ($wert1>=$wert2) ? 0 : 1;
}

function display_view_navigation_extended($module, $current_view, $views,$break_point=0) {
    $nav_html = array();
	$break_point=5;
	$num=0;
    foreach($views as $link => $name) {
	$num++;
	if ($break_point>0 && $num>$break_point) {$num=1;$break_point=4;$nav_html[] = '<br>';}

        if($current_view == $link) {
            $nav_html[] = '[<b>'.$name.'</b>]&nbsp;&nbsp;';
        }
        else {
            $nav_html[] = '[<a href="'.parse_link('a='.$module.'&view='.$link).'">'.$name.'</a>]&nbsp;&nbsp;';
        }
    }

    return implode('', $nav_html);
}


set_time_limit(100);

function UnitPrice($unit,$resource, $race=-1)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

if ($race=-1) $race=$game->player['user_race'];
$price = $UNIT_DATA[$unit][$resource];
$price*= $RACE_DATA[$race][6];
return round($price,0);
}



function Show_Status()
{
global $db;
global $game, $NEXT_TICK, $ACTUAL_TICK;

	$limit='';
	if (isset($_REQUEST['active_planet'])) {$limit='AND p.planet_id="'.$game->planet['planet_id'].'"';}
    $sql = 'SELECT t.*,p.planet_name,p.planet_owner FROM (scheduler_resourcetrade t)
			LEFT JOIN (planets p) ON p.planet_id=t.planet WHERE p.planet_owner="'.$game->player['user_id'].'" '.$limit.' ORDER BY t.arrival_time ASC';
    if(($tradedata = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Internal database error');
    }
	if (isset($_REQUEST['planets'])) {
    $sql = 'SELECT t.*,p.planet_name,p.planet_owner FROM (scheduler_resourcetrade t)
			LEFT JOIN (planets p) ON p.planet_id=t.planet WHERE p.planet_owner="'.$game->player['user_id'].'" ORDER BY `planet_name` ASC';
    if(($tradedata = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Internal database error');
    }
	}
	 
    $nr = 0;


	$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT35")).' '.HelpPopup('trade_viewstatus').' :</span></center><br>');
	$game->out('
	<center>
	<table border=0 cellpadding=1 cellspacing=1 class="style_inner">
	<tr>
	<td width=350><center>
	<b>'.constant($game->sprache("TEXT36")).'</b><br>
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view']).'">'.constant($game->sprache("TEXT37")).'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&active_planet=1').'">'.constant($game->sprache("TEXT38")).'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&active_planet=1').'">'.constant($game->sprache("TEXT39")).'</a>
	</center></td></tr></table>
	</center><br>
	');
	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=500 class="style_outer">');
	$game->out('<tr><td width=575>
	    <table border=0 cellpadding=4 cellspacing=0 width=500 class="style_inner">
	<tr><td width=75><b>'.constant($game->sprache("TEXT40")).'</b></td><td width=350><b>'.constant($game->sprache("TEXT41")).'</b></td><td width=75><b>'.constant($game->sprache("TEXT42")).'</b></td>');

	$num=0;

	for ($t=0; $t<count($tradedata); $t++)
	{
		if (isset($tradedata[$t]))
		{
			$ware='';
			if ($tradedata[$t]['resource_1']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.$tradedata[$t]['resource_1'].'&nbsp;';
			if ($tradedata[$t]['resource_2']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.$tradedata[$t]['resource_2'].'&nbsp;';
			if ($tradedata[$t]['resource_3']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.$tradedata[$t]['resource_3'].'&nbsp;';
			if ($tradedata[$t]['resource_4']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_worker_small.gif">&nbsp;'.$tradedata[$t]['resource_4'].'&nbsp;';
			if ($tradedata[$t]['unit_1']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.$tradedata[$t]['unit_1'].'&nbsp;';
			if ($tradedata[$t]['unit_2']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.$tradedata[$t]['unit_2'].'&nbsp;';
			if ($tradedata[$t]['unit_3']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.$tradedata[$t]['unit_3'].'&nbsp;';
			if ($tradedata[$t]['unit_4']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.$tradedata[$t]['unit_4'].'&nbsp;';
			if ($tradedata[$t]['unit_5']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.$tradedata[$t]['unit_5'].'&nbsp;';
			if ($tradedata[$t]['unit_6']>0) $ware.='&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.$tradedata[$t]['unit_6'].'&nbsp;';

/* 03/03/08 - AC: Color is not initialized */
$color = 0;
			if ($num>5)
			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" color:'.$color.';"><a href="javascript:void();"><td><b>'.Zeit(TICK_DURATION*$tradedata[$t]['arrival_time']-TICK_DURATION*$ACTUAL_TICK+round($NEXT_TICK/60,0)).'</b></td><td>'.$ware.'</td><td>'.$tradedata[$t]['planet_name'].'</td></a></tr>');
			else
			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" color:'.$color.';"><a href="javascript:void();"><td><b id="timer'.($num+4).'" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($tradedata[$t]['arrival_time']-$ACTUAL_TICK)).'_type1_5">&nbsp;</b></td><td>'.$ware.'</td><td>'.$tradedata[$t]['planet_name'].'</td></a></tr>');

			$num++;
		}

	}


	$game->out('</table></td></tr></table>');

}

function Ress_price($nach,$von,$art)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;

/*
$snach = $RACE_DATA[$game->player['user_race']][$nach];
$svon = $RACE_DATA[$game->player['user_race']][$von];
*/

// Il rateo di scambio viene pesato in base alla razza, penalizzando di fatto lo scambio di risorse tra le razze; usiamo il rateo 2,5:1:0,8 modificato dalle disponibilità
switch($nach) {
	case 1:
	case 9:
		$snach = 1.0;
	break;
	case 10:
		$snach = 1.0;
	break;
	case 11:
		$snach = 0.85;
	break;
}

switch($von) {
	case 1:
	case 9:
		$svon = 1.0;
	break;
	case 10:
		$svon = 1.0;
	break;
	case 11:
		$svon = 0.85;
	break;
}

//echo ('Snach: '.$snach.' Svon: '.$svon);
if($art==0)$ergebniss = ($snach/$svon)- (($snach/$svon)*30/100);
if($art==1)$ergebniss = ($snach/$svon) - (($snach/ $svon)*15/100);
if($art==2)$ergebniss = ($snach/$svon);
if($art==3)$ergebniss = ($snach/$svon) + (($snach/$svon)*15/100);

return $ergebniss;
}

function Trade_Ress()
{
global $db;
global $game,$ACTUAL_TICK;
/*
[22:07:05] <TotesTAP> [02:46] <rmA> 1 : 4 : 3
[22:07:05] <TotesTAP> [02:46] <rmA> Met : Min : Lat
[22:07:08] <TotesTAP> [02:47] <rmA> bei 6h 50% steuern
[22:07:08] <TotesTAP> [02:47] <rmA> bei 12h 35% steuern
[22:07:08] <TotesTAP> [02:48] <rmA> bei 36h 15% steuern
*/
$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT144")).' '.HelpPopup('trade_ress').' :</span></center><br>');
if(!isset($_POST['menge']) || $_POST['menge']<0)$_POST['menge']=0;
if(isset($_POST['bezahlungsart'])) $_POST['bezahlungsart']=(int)$_POST['bezahlungsart'];
$_POST['menge']=(int)$_POST['menge'];
if(isset($_POST['plani_ziel'])) $_POST['plani_ziel']=(int)$_POST['plani_ziel'];
if(isset($_POST['plani'])) $_POST['plani']=(int)$_POST['plani'];

if(isset($_POST['Art']))
if($_POST['Art']!="Metall" && $_POST['Art']!="Latinum" && $_POST['Art']!="Mineral")
{
	message(NOTICE, constant($game->sprache("TEXT145")));
}

$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

/* 27/02/08 - AC: Check DB query */
if($daten == null)
{
	$daten['ress_1'] = 0;
	$daten['ress_2'] = 0;
	$daten['ress_3'] = 0;
}

/* 04/03/08 - AC: If step is not specified, it si frist step */
if(!isset($_REQUEST['step'])) $_REQUEST['step'] = '1';

if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='trade_ress' && isset($_POST['plani']) && $_REQUEST['step']=='3' && $_POST['menge']!=0)
{
	/* 01/03/08 - AC: Check this value */
	if(!isset($_POST['plani_ziel'])) $_POST['plani_ziel'] = 0;

	$plani_id_a=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
	$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
	if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
	{
		$game->out(constant($game->sprache("TEXT146")));
	}else
	{
		$kosten['Metall']=0;
		$kosten['Mineral']=0;
		$kosten['Latinum']=0;

		if($_POST['transportsart']!=1 && $_POST['transportsart']!=2 && $_POST['transportsart']!=3)  {$game->out('Cheat'); exit;}
		if($_POST['transportsart']==1) {$transportsatz=0.50;$tickzeit=20*6;}
		if($_POST['transportsart']==2) {$transportsatz=0.35;$tickzeit=20*12;}
		if($_POST['transportsart']==3) {$transportsatz=0.15;$tickzeit=20*36;}

		$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

		/* 27/02/08 - AC: Check DB query */
		if($daten == null)
		{
			$daten['ress_1'] = 0;
			$daten['ress_2'] = 0;
			$daten['ress_3'] = 0;
		}

		if($_POST['bezahlungsart']==1 && $_POST['Art']=="Metall") // metall zu mineral
		{
			if($daten['ress_2']<1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,0));}
			if($daten['ress_2']>=1000000 && $daten['ress_2']<=8000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,1));}
			if($daten['ress_2']>=8000001 && $daten['ress_2']<=46000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,2));}
			if($daten['ress_2']>46000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,3));}
		}
		else if($_POST['bezahlungsart']==2 && $_POST['Art']=="Metall") // metall zu latinum
		{
			if($daten['ress_3']<800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,0));}
			if($daten['ress_3']>=800000 && $daten['ress_3']<=6400000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,1));}
			if($daten['ress_3']>=6400001 && $daten['ress_3']<=36800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,2));}
			if($daten['ress_3']>36800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,3));}
		}
		else if($_POST['bezahlungsart']==3 && $_POST['Art']=="Mineral") // minerali contro metallo
		{
			if($daten['ress_1']<1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,0));}
			if($daten['ress_1']>=1000000 && $daten['ress_1']<=8000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,1));}
			if($daten['ress_1']>=8000001 && $daten['ress_1']<=46000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,2));}
			if($daten['ress_1']>46000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,3));}
		}
		else if($_POST['bezahlungsart']==4 && $_POST['Art']=="Mineral") // minerali contro latinum
		{
			if($daten['ress_3']<800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,0));}
			if($daten['ress_3']>=800000 && $daten['ress_3']<=6400000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,1));}
			if($daten['ress_3']>=6400001 && $daten['ress_3']<=36800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,2));}
			if($daten['ress_3']>36800000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,3));}
		}
		else if($_POST['bezahlungsart']==5 && $_POST['Art']=="Latinum") // latinum zu metall
		{
			if($daten['ress_1']<1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,0));}
			if($daten['ress_1']>=1000000 && $daten['ress_1']<=8000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,1));}
			if($daten['ress_1']>=8000001 && $daten['ress_1']<=46000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,2));}
			if($daten['ress_1']>46000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,3));}
		}
		else if($_POST['bezahlungsart']==6 && $_POST['Art']=="Latinum") // latinum zu mineral
		{
			if($daten['ress_2']<1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,0));}
			if($daten['ress_2']>=1000000 && $daten['ress_2']<=8000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,1));}
			if($daten['ress_2']>=8000001 && $daten['ress_2']<=46000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,2));}
			if($daten['ress_2']>46000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,3));}
		}

		$db->lock('FHB_Handels_Lager','scheduler_resourcetrade');
		$plani_inhalt=$db->queryrow('SELECT resource_2,resource_1,resource_3 FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
		if($_POST['bezahlungsart']==1 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_1'])
		{ 
			if($transportsatz!=0)
			{$steuern=(int)($kosten['Mineral']*$transportsatz);
			}else{$steuern=0;}
			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
				$daten['ress_1'] = 0;
				$daten['ress_2'] = 0;
				$daten['ress_3'] = 0;
			}

			if($daten['ress_2']>=$kosten['Mineral'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_1=resource_1-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern).',ress_1=ress_1+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.($kosten['Mineral']-$steuern).',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT150")).($kosten['Mineral']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT151")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		elseif($_POST['bezahlungsart']==2 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_1'])
		{
			if($transportsatz!=0)
			{
				$steuern=(int)($kosten['Latinum']*$transportsatz);
			}else{$steuern=0;}
	
			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
				$daten['ress_1'] = 0;
				$daten['ress_2'] = 0;
				$daten['ress_3'] = 0;
			}

			if($daten['ress_3']>=$kosten['Latinum'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_1=resource_1-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern).',ress_1=ress_1+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.($kosten['Latinum']-$steuern).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT156")).($kosten['Latinum']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT151")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		elseif($_POST['bezahlungsart']==3 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_2'])
		{
			if($transportsatz!=0)
			{
				$steuern=(int)($kosten['Metall']*$transportsatz);
			}else{$steuern=0;}

			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
				$daten['ress_1'] = 0;
				$daten['ress_2'] = 0;
				$daten['ress_3'] = 0;
			}

			if($daten['ress_1']>=$kosten['Metall'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_2=resource_2-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern).',ress_2=ress_2+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']-$steuern).',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT154")).($kosten['Metall']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT155")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		elseif($_POST['bezahlungsart']==4 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_2'])
		{
			if($transportsatz!=0)
			{
				$steuern=(int)($kosten['Latinum']*$transportsatz);
			}else{$steuern=0;}

			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
				$daten['ress_1'] = 0;
				$daten['ress_2'] = 0;
				$daten['ress_3'] = 0;
			}

			if($daten['ress_3']>=$kosten['Latinum'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_2=resource_2-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern).',ress_2=ress_2+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.($kosten['Latinum']-$steuern).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT156")).($kosten['Latinum']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT155")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		elseif($_POST['bezahlungsart']==5 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_3'])
		{
			if($transportsatz!=0)
			{
				$steuern=(int)($kosten['Metall']*$transportsatz);
			}else{$steuern=0;}

			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
				$daten['ress_1'] = 0;
				$daten['ress_2'] = 0;
				$daten['ress_3'] = 0;
			}

			if($daten['ress_1']>=$kosten['Metall'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_3=resource_3-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern).',ress_3=ress_3+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']-$steuern).',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT154")).($kosten['Metall']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT157")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		elseif($_POST['bezahlungsart']==6 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_3'])
		{
			if($transportsatz!=0)
			{
				$steuern=(int)($kosten['Mineral']*$transportsatz);
			}else{$steuern=0;}

			$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

			/* 27/02/08 - AC: Check DB query */
			if($daten == null)
			{
			$daten['ress_1'] = 0;
			$daten['ress_2'] = 0;
			$daten['ress_3'] = 0;
			}

			if($daten['ress_2']>=$kosten['Mineral'])
			{
				// dem user Ressourcen abziehen:
				if (($db->query('UPDATE planets SET resource_3=resource_3-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true)
				{
					// dem NPC Ressourcen abziehen:
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern).',ress_3=ress_3+'.$_POST['menge'].' WHERE id=1'))==true)
					{
						// Buyers goods in the Trade Register Scheduler:
						if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.($kosten['Mineral']-$steuern).',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
						{
							$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT150")).($kosten['Mineral']-$steuern).'</td></tr>
								<tr><td>'.constant($game->sprache("TEXT157")).$_POST['menge'].'</td></tr>
								<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
								<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(DATABASE_ERROR, 'Internal database error');}
			}
			else{message(NOTICE, constant($game->sprache("TEXT153")));}
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
		}
		else
		{
			$game->out(constant($game->sprache("TEXT158")));
			$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
			$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress&step=2').'" method="post"><tr><td colspan=2>');
			$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
			$game->out('<input type="hidden" name="Art" value="'.$_POST['Art'].'">');
			$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
		}
	}
}
elseif(isset($_REQUEST['handel']) && $_REQUEST['handel']=='trade_ress' && $_REQUEST['step']=='2'  &&  $_POST['menge']!=0)
{

	/* 28/02/08 - AC: !!! TESTING !!! */
	$kosten['Metall'][1] = 0;
	$kosten['Metall'][2] = 0;
	$kosten['Mineral'][1] = 0;
	$kosten['Mineral'][2] = 0;
	$kosten['Latinum'][1] = 0;
	$kosten['Latinum'][2] = 0;
	/* */

	//K = (n*p) - ((n-1)*0,1) 
	if($_POST['Art']=="Metall") // metall zu mineral
	{
		if($daten['ress_2']<1000000){
			$flag_rateo['Mineral'][1] = 1;
			$rate['Mineral'][1] = Ress_price(10,9,0);
			$kosten['Mineral'][1]=(int)($_POST['menge']*$rate['Mineral'][1]);
			}
		if($daten['ress_2']>=1000000 && $daten['ress_2']<=8000000){
			$flag_rateo['Mineral'][1] = 2;
			$rate['Mineral'][1] = Ress_price(10,9,1);
			$kosten['Mineral'][1]=(int)($_POST['menge']*$rate['Mineral'][1]);
			}
		if($daten['ress_2']>=8000001 && $daten['ress_2']<=46000000){
			$flag_rateo['Mineral'][1] = 3;
			$rate['Mineral'][1] = Ress_price(10,9,2);
			$kosten['Mineral'][1]=(int)($_POST['menge']*$rate['Mineral'][1]);
			}
		if($daten['ress_2']>46000000){
			$flag_rateo['Mineral'][1] = 4;
			$rate['Mineral'][1] = Ress_price(10,9,3);
			$kosten['Mineral'][1]=(int)($_POST['menge']*$rate['Mineral'][1]);
			}
	}
	if($_POST['Art']=="Metall") // metall zu latinum
	{
		if($daten['ress_3']<800000){
			$flag_rateo['Latinum'][1] = 1;
			$rate['Latinum'][1] = Ress_price(11,9,0);
			$kosten['Latinum'][1]=(int)($_POST['menge']*$rate['Latinum'][1]);
			}
		if($daten['ress_3']>=800000 && $daten['ress_3']<=6400000){
			$flag_rateo['Latinum'][1] = 2;
			$rate['Latinum'][1] = Ress_price(11,9,1);
			$kosten['Latinum'][1]=(int)($_POST['menge']*$rate['Latinum'][1]);
			}
		if($daten['ress_3']>=6400001 && $daten['ress_3']<=36800000){
			$flag_rateo['Latinum'][1] = 3;
			$rate['Latinum'][1] = Ress_price(11,9,2);
			$kosten['Latinum'][1]=(int)($_POST['menge']*$rate['Latinum'][1]);
			}
		if($daten['ress_3']>36800000){
			$flag_rateo['Latinum'][1] = 4;
			$rate['Latinum'][1] = Ress_price(11,9,3);
			$kosten['Latinum'][1]=(int)($_POST['menge']*$rate['Latinum'][1]);
			}
	}
	if($_POST['Art']=="Mineral") // mineral zu metall
	{
		if($daten['ress_1']<1000000){
			$flag_rateo['Metall'][1] = 1;
			$rate['Metall'][1] = Ress_price(9,10,0);
			$kosten['Metall'][1]=(int)($_POST['menge']*$rate['Metall'][1]);
			}
		if($daten['ress_1']>=1000000 && $daten['ress_1']<=8000000){
			$flag_rateo['Metall'][1] = 2;
			$rate['Metall'][1] = Ress_price(9,10,1);
			$kosten['Metall'][1]=(int)($_POST['menge']*$rate['Metall'][1]);
			}
		if($daten['ress_1']>=8000001 && $daten['ress_1']<=46000000){
			$flag_rateo['Metall'][1] = 3;
			$rate['Metall'][1] = Ress_price(9,10,2);
			$kosten['Metall'][1]=(int)($_POST['menge']*$rate['Metall'][1]);
			}
		if($daten['ress_1']>46000000){
			$flag_rateo['Metall'][1] = 4;
			$rate['Metall'][1] = Ress_price(9,10,3);
			$kosten['Metall'][1]=(int)($_POST['menge']*$rate['Metall'][1]);
			}
	
	}
	if($_POST['Art']=="Mineral") // mineral zu latinum
	{
		if($daten['ress_3']<800000){
			$flag_rateo['Latinum'][2] = 1;
			$rate['Latinum'][2] = Ress_price(11,10,0);
			$kosten['Latinum'][2]=(int)($_POST['menge']*$rate['Latinum'][2]);
			}
		if($daten['ress_3']>=800000 && $daten['ress_3']<=6400000){
			$flag_rateo['Latinum'][2] = 2;
			$rate['Latinum'][2] = Ress_price(11,10,1);
			$kosten['Latinum'][2]=(int)($_POST['menge']*$rate['Latinum'][2]);
			}
		if($daten['ress_3']>=6400001 && $daten['ress_3']<=36800000){
			$flag_rateo['Latinum'][2] = 3;
			$rate['Latinum'][2] = Ress_price(11,10,2);
			$kosten['Latinum'][2]=(int)($_POST['menge']*$rate['Latinum'][2]);
			}
		if($daten['ress_3']>36800000){
			$flag_rateo['Latinum'][2] = 4;
			$rate['Latinum'][2] = Ress_price(11,10,3);
			$kosten['Latinum'][2]=(int)($_POST['menge']*$rate['Latinum'][2]);
			}
	}
	if($_POST['Art']=="Latinum") // latinum zu metall
	{
		if($daten['ress_1']<1000000){
			$flag_rateo['Metall'][2] = 1;
			$rate['Metall'][2] = Ress_price(9,11,0);
			$kosten['Metall'][2]=(int)($_POST['menge']*$rate['Metall'][2]);
			}
		if($daten['ress_1']>=1000000 && $daten['ress_1']<=8000000){
			$flag_rateo['Metall'][2] = 2;
			$rate['Metall'][2] = Ress_price(9,11,1);
			$kosten['Metall'][2]=(int)($_POST['menge']*$rate['Metall'][2]);
			}
		if($daten['ress_1']>=8000001 && $daten['ress_1']<=46000000){
			$flag_rateo['Metall'][2] = 3;
			$rate['Metall'][2] = Ress_price(9,11,2);
			$kosten['Metall'][2]=(int)($_POST['menge']*$rate['Metall'][2]);
			}
		if($daten['ress_1']>46000000){
			$flag_rateo['Metall'][2] = 4;
			$rate['Metall'][2] = Ress_price(9,11,3);
			$kosten['Metall'][2]=(int)($_POST['menge']*$rate['Metall'][2]);
			}
	
	}
	if($_POST['Art']=="Latinum") // latinum zu mineral
	{
		if($daten['ress_2']<1000000){
			$flag_rateo['Mineral'][2] = 1;
			$rate['Mineral'][2] = Ress_price(10,11,0);
			$kosten['Mineral'][2]=(int)($_POST['menge']*$rate['Mineral'][2]);
			}
		if($daten['ress_2']>=1000000 && $daten['ress_2']<=8000000){
			$flag_rateo['Mineral'][2] = 2;
			$rate['Mineral'][2] = Ress_price(10,11,1);
			$kosten['Mineral'][2]=(int)($_POST['menge']*$rate['Mineral'][2]);
			}
		if($daten['ress_2']>=8000001 && $daten['ress_2']<=46000000){
			$flag_rateo['Mineral'][2] = 3;
			$rate['Mineral'][2] = Ress_price(10,11,2);
			$kosten['Mineral'][2]=(int)($_POST['menge']*$rate['Mineral'][2]);
			}
		if($daten['ress_2']>46000000){
			$flag_rateo['Mineral'][2] = 4;
			$rate['Mineral'][2] = Ress_price(10,11,3);
			$kosten['Mineral'][2]=(int)($_POST['menge']*$rate['Mineral'][2]);
			}
	}
	
	$rateo_color[1] = 'red';
	$rateo_color[2] = 'yellow';
	$rateo_color[3] = 'gray';
	$rateo_color[4] = 'green';
	
	$steuern[1]=(int)($kosten['Metall'][1]*0.50);
	$steuern[2]=(int)($kosten['Mineral'][1]*0.50);
	$steuern[3]=(int)($kosten['Latinum'][1]*0.50);
	$steuern[4]=(int)($kosten['Metall'][2]*0.50);
	$steuern[5]=(int)($kosten['Mineral'][2]*0.50);
	$steuern[6]=(int)($kosten['Latinum'][2]*0.50);
	$steuern[7]=(int)($kosten['Metall'][1]*0.35);
	$steuern[8]=(int)($kosten['Mineral'][1]*0.35);
	$steuern[9]=(int)($kosten['Latinum'][1]*0.35);
	$steuern[10]=(int)($kosten['Metall'][2]*0.35);
	$steuern[11]=(int)($kosten['Mineral'][2]*0.35);
	$steuern[12]=(int)($kosten['Latinum'][2]*0.35);
	$steuern[13]=(int)($kosten['Metall'][1]*0.15);
	$steuern[14]=(int)($kosten['Mineral'][1]*0.15);
	$steuern[15]=(int)($kosten['Latinum'][1]*0.15);
	$steuern[16]=(int)($kosten['Metall'][2]*0.15);
	$steuern[17]=(int)($kosten['Mineral'][2]*0.15);
	$steuern[18]=(int)($kosten['Latinum'][2]*0.15);
	$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

	/* 27/02/08 - AC: Check DB query */
	if($daten == null)
	{
		$daten['ress_1'] = 0;
		$daten['ress_2'] = 0;
		$daten['ress_3'] = 0;
	}

	$game->out('<table>');
	if($_POST['Art']=="Metall")
	{
		$indice1 = $flag_rateo['Mineral'][1];
		$indice2 = $flag_rateo['Latinum'][1];
		$game->out('<tr><td colspan=2><table><tr><td>'.constant($game->sprache("TEXT159")).' '.$_POST['menge'].' '.constant($game->sprache("TEXT123")).'</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT160")).'</td><td>Rateo</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT161")).'</td><td>Rateo</td></tr>');
		$game->out('<tr><td></td><td>&nbsp;</td><td>'.$kosten['Mineral'][1].'('.$daten['ress_2'].')</td><td><font color="'.$rateo_color[$indice1].'">'.round($rate['Mineral'][1], 3).'</font></td><td>&nbsp;</td><td>'.$kosten['Latinum'][1].'('.$daten['ress_3'].')</td><td><font color="'.$rateo_color[$indice2].'">'.round($rate['Latinum'][1], 3).'</font></td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT162")).'</td><td>&nbsp;</td><td>'.($kosten['Mineral'][1]-$steuern[2]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][1]-$steuern[3]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT163")).'</td><td>&nbsp;</td><td>'.($kosten['Mineral'][1]-$steuern[8]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][1]-$steuern[9]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT164")).'</td><td>&nbsp;</td><td>'.($kosten['Mineral'][1]-$steuern[14]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][1]-$steuern[15]).'</td></tr>');
	}
	if($_POST['Art']=="Mineral")
	{
		$indice1 = $flag_rateo['Metall'][1];
		$indice2 = $flag_rateo['Latinum'][2];
		$game->out('<tr><td colspan=2><table><tr><td>'.constant($game->sprache("TEXT159")).' '.$_POST['menge'].' '.constant($game->sprache("TEXT165")).'</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT166")).'</td><td>Rateo</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT161")).'</td><td>Rateo</td></tr>');
		$game->out('<tr><td></td><td>&nbsp;</td><td>'.$kosten['Metall'][1].'('.$daten['ress_1'].')</td><td><font color="'.$rateo_color[$indice1].'">'.round($rate['Metall'][1], 3).'</font></td><td>&nbsp;</td><td>'.$kosten['Latinum'][2].'('.$daten['ress_3'].')</td><td><font color="'.$rateo_color[$indice2].'">'.round($rate['Latinum'][2], 3).'</font></td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT162")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][1]-$steuern[1]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][2]-$steuern[6]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT163")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][1]-$steuern[7]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][2]-$steuern[12]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT164")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][1]-$steuern[13]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Latinum'][2]-$steuern[18]).'</td></tr>');
	}
	if($_POST['Art']=="Latinum")
	{
		$indice1 = $flag_rateo['Metall'][2];
		$indice2 = $flag_rateo['Mineral'][2];
		$game->out('<tr><td colspan=2><table><tr><td>'.constant($game->sprache("TEXT159")).' '.$_POST['menge'].' '.constant($game->sprache("TEXT167")).'</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT166")).'</td><td>Rateo</td><td>&nbsp;</td><td>'.constant($game->sprache("TEXT160")).'</td><td>Rateo</td></tr>');
		$game->out('<tr><td></td><td>&nbsp;</td><td>'.$kosten['Metall'][2].'('.$daten['ress_1'].')</td><td><font color="'.$rateo_color[$indice1].'">'.round($rate['Metall'][2], 3).'</font></td><td>&nbsp;</td><td>'.$kosten['Mineral'][2].'('.$daten['ress_2'].')</td><td><font color="'.$rateo_color[$indice2].'">'.round($rate['Mineral'][2], 3).'</font></td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT162")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][2]-$steuern[4]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Mineral'][2]-$steuern[5]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT163")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][2]-$steuern[10]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Mineral'][2]-$steuern[11]).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT164")).'</td><td>&nbsp;</td><td>'.($kosten['Metall'][2]-$steuern[16]).'</td><td>&nbsp;</td><td>&nbsp;</td><td> '.($kosten['Mineral'][2]-$steuern[17]).'</td></tr>');
	}

	$game->out('</table><br>'.constant($game->sprache("TEXT269")).' <font color="red">'.constant($game->sprache("TEXT270")).'</font> <font color="yellow">'.constant($game->sprache("TEXT271")).'</font>  <font color="gray">'.constant($game->sprache("TEXT272")).'</font>  <font color="green">'.constant($game->sprache("TEXT273")).'</font></td></tr>');
	$game->out('<td>'.constant($game->sprache("TEXT168")).'</td></tr>');
	$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress&step=3').'" method="post"><tr><td>'.constant($game->sprache("TEXT169")).'</td><td><select size="1" name="bezahlungsart">');
	if($_POST['Art']=="Metall")$game->out('<option value="1">'.constant($game->sprache("TEXT170")).'</option>');
	if($_POST['Art']=="Metall")$game->out('<option value="2">'.constant($game->sprache("TEXT171")).'</option>');
	if($_POST['Art']=="Mineral")$game->out('<option value="3">'.constant($game->sprache("TEXT172")).'</option>');
	if($_POST['Art']=="Mineral")$game->out('<option value="4">'.constant($game->sprache("TEXT171")).'</option>');
	if($_POST['Art']=="Latinum")$game->out('<option value="5">'.constant($game->sprache("TEXT172")).'</option>');
	if($_POST['Art']=="Latinum")$game->out('<option value="6">'.constant($game->sprache("TEXT170")).'</option>');
	$game->out('</select></td></tr>');
	$game->out('<tr><td>'.constant($game->sprache("TEXT173")).'</td><td><select size="1" name="transportsart">
		<option value="1">'.constant($game->sprache("TEXT174")).'</option>
		<option value="2">'.constant($game->sprache("TEXT175")).'</option>
		<option value="3">'.constant($game->sprache("TEXT176")).'</option>
		</select></td></tr><tr><td colspan=2><br>'.constant($game->sprache("TEXT177")).'</td></tr>');
	$sql='SELECT planet_id,planet_name,building_11 FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
	if(($planis=$db->query($sql))==false)
	{
		$game->out(constant($game->sprache("TEXT178")));
	}else{
		$game->out('<tr><td>'.constant($game->sprache("TEXT179")).'</td><td><select size="1" name="plani">');
		while($planeten=$db->fetchrow($planis))
		{
			if ($planeten['building_11']>0)
			{
				if ($game->planet['planet_id'] == $planeten['planet_id'])
					$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
				else
					$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
			}
		}
		$game->out('</select></td></tr>');
	}
	if(($planis=$db->query($sql))==false)
	{
		$game->out(constant($game->sprache("TEXT178")));
	}else{
		$game->out('<tr><td>'.constant($game->sprache("TEXT180")).'</td><td><select size="1" name="plani_ziel">');
		while($planeten=$db->fetchrow($planis))
		{
			if ($planeten['building_11']>0)
			{
				if ($game->planet['planet_id'] == $planeten['planet_id'])
					$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
				else
					$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
			}
		}
		$game->out('</select></td></tr>');
	}
	$game->out('<tr><td colspan=2>');
	$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
	$game->out('<input type="hidden" name="Art" value="'.$_POST['Art'].'">');
	$game->out('<input type="submit" value="'.constant($game->sprache("TEXT181")).'"  name="submit"></td></tr></form>');
	$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post"><tr><td colspan=2>');
	$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
	$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
}
else
{
	if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='trade_ress' && $_REQUEST['step']=='2' && $_POST['menge']==0)
		$game->out(constant($game->sprache("TEXT182")));
	$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
	$game->out('<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width="450"><tr><td>'.constant($game->sprache("TEXT183")).'</td></tr>');
	$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress&step=2').'" method="post"><td><input type="text" name="menge" value="'.$_POST['menge'].'"></td></td></tr>');
	$game->out('<tr><td>'.constant($game->sprache("TEXT184")).'</td><td><select size="1" name="Art">
		<option value="Metall">'.constant($game->sprache("TEXT123")).'</option>
		<option value="Mineral">'.constant($game->sprache("TEXT165")).'</option>
		<option value="Latinum">'.constant($game->sprache("TEXT167")).'</option>
		</select></td></tr>');
	$game->out('<tr><td colspan="3"><input type="submit" value="'.constant($game->sprache("TEXT185")).'"  name="submit"></td></form></tr></table>');
}
}

function sold_formel_truppen($grundkosten,$anzahl,$art,$x1=0)
{
	global $ACTUAL_TICK,$db;
	$y1=$grundkosten+(($grundkosten/100)*125);
	$y2=$grundkosten-(($grundkosten/100)*25);
	$daten=$db->queryrow('SELECT '.$art.' FROM FHB_Handels_Lager WHERE id=1');
	/* 27/02/08 - AC: Check DB query...but... I'm not sure that is correct that all this FHB_xxx tables are empty */
	if($daten==null)
	{
		$daten[$art]=0;
	}

	$x=$daten[$art];
	/* No more tick, let's use a fixed parameter
	$q=$ACTUAL_TICK;
	*/
	$q = 500;
	$result = ((($y2-$y1)/(((25/216)*$q)-$x1))*$x) + ($y2 - (($y2-$y1)/(((25/216)*$q)-$x1) * (25/216)*$q));
	if($result<$y2) $result=$y2;
	if($result>$y1) $result=$y1;
	$result=$result*$anzahl;
	return $ergebniss=(int)$result;
}
function Trade_Sold_truppen() 
{
	global $db;
	global $game,$ACTUAL_TICK;

	$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT186")).' '.HelpPopup('trade_sold_truppen').' :</span></center><br>');
	/*if($_POST['unit_1']==null || $_POST['unit_1']<0 )$_POST['unit_1']=0;
	if($_POST['unit_2']==null || $_POST['unit_2']<0 )$_POST['unit_2']=0;
	if($_POST['unit_3']==null || $_POST['unit_3']<0 )$_POST['unit_3']=0;
	if($_POST['unit_4']==null || $_POST['unit_4']<0 )$_POST['unit_4']=0;
	if($_POST['unit_5']==null || $_POST['unit_5']<0 )$_POST['unit_5']=0;
	if($_POST['unit_6']==null || $_POST['unit_6']<0 )$_POST['unit_6']=0;*/

	if(!isset($_POST['unit_1']) || $_POST['unit_1']<0 )$_POST['unit_1']=0;
	if(!isset($_POST['unit_2']) || $_POST['unit_2']<0 )$_POST['unit_2']=0;
	if(!isset($_POST['unit_3']) || $_POST['unit_3']<0 )$_POST['unit_3']=0;
	if(!isset($_POST['unit_4']) || $_POST['unit_4']<0 )$_POST['unit_4']=0;
	if(!isset($_POST['unit_5']) || $_POST['unit_5']<0 )$_POST['unit_5']=0;
	if(!isset($_POST['unit_6']) || $_POST['unit_6']<0 )$_POST['unit_6']=0;

	$_POST['unit_1']=(int)$_POST['unit_1'];
	$_POST['unit_2']=(int)$_POST['unit_2'];
	$_POST['unit_3']=(int)$_POST['unit_3'];
	$_POST['unit_4']=(int)$_POST['unit_4'];
	$_POST['unit_5']=(int)$_POST['unit_5'];
	$_POST['unit_6']=(int)$_POST['unit_6'];

	if(isset($_POST['plani_ziel'])){ $_POST['plani_ziel']=(int)$_POST['plani_ziel']; }
	if(isset($_POST['plani'])){ $_POST['plani']=(int)$_POST['plani']; }

	$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

	/* 27/02/08 - AC: Check DB query... */
	if($daten==null)
	{
		$daten['unit_1'] = 0;
		$daten['unit_2'] = 0;
		$daten['unit_3'] = 0;
		$daten['unit_4'] = 0;
		$daten['unit_5'] = 0;
		$daten['unit_6'] = 0;
		$daten['ress_1'] = 0;
		$daten['ress_2'] = 0;
		$daten['ress_3'] = 0;
	}

	if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='sold_truppen' && isset($_POST['plani']) && $_REQUEST['step']=='3' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0))
	{
		$plani_id_a=$db->queryrow('SELECT planet_id,planet_name  FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
		$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
		if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
		{
			$game->out(constant($game->sprache("TEXT146")));
		}else
		{
			$kosten['Metall']=0;
			$kosten['Mineral']=0;
			$kosten['gesamt']=0;
			$kosten['Latinum']=0;

			if($_POST['unit_1']!=0)
			{
				$unit_1=UnitPrice(0,0);
				$unit_2=UnitPrice(0,1);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_1'],"unit_1");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_1'],"unit_1");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral'];
			}
			if($_POST['unit_2']!=0)
			{
				$unit_1=UnitPrice(1,0);
				$unit_2=UnitPrice(1,1);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_2'],"unit_2");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_2'],"unit_2");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral'];
			}
			if($_POST['unit_3']!=0)
			{
				$unit_1=UnitPrice(2,0);
				$unit_2=UnitPrice(2,1);
				$unit_3=UnitPrice(2,2);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_3'],"unit_3");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_3'],"unit_3");
				$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_3'],"unit_3");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
			}
			if($_POST['unit_4']!=0)
			{
				$unit_1=UnitPrice(3,0);
				$unit_2=UnitPrice(3,1);
				$unit_3=UnitPrice(3,2);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_4'],"unit_4");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_4'],"unit_4");
				$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_4'],"unit_4");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
			}
			if($_POST['unit_5']!=0)
			{
				$unit_1=UnitPrice(4,0);
				$unit_2=UnitPrice(4,1);
				$unit_3=UnitPrice(4,2);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_5'],"unit_5");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_5'],"unit_5");
				$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_5'],"unit_5");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
			}
			if($_POST['unit_6']!=0)
			{
				$unit_1=UnitPrice(5,0);
				$unit_2=UnitPrice(5,1);
				$unit_3=UnitPrice(5,2);
				$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_6'],"unit_6");
				$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_6'],"unit_6");
				$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_6'],"unit_6");
				$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
			}
			$kosten['gesamt']=(int)$kosten['gesamt'];
			$kosten['Metall']=(int)$kosten['Metall'];
			$kosten['Mineral']=(int)$kosten['Mineral'];
			$kosten['Latinum']=(int)$kosten['Latinum'];



			if($_POST['transportsart']!=1 && $_POST['transportsart']!=2 && $_POST['transportsart']!=3)  {$game->out('Cheat'); exit;}
			if($_POST['transportsart']==1) {$transportsatz=0.30;$tickzeit=20*6;}
			if($_POST['transportsart']==2) {$transportsatz=0.15;$tickzeit=20*12;}
			if($_POST['transportsart']==3) {$transportsatz=0;$tickzeit=20*36;}
			$db->lock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
			$plani_inhalt=$db->queryrow('SELECT unit_1,unit_2,unit_3,unit_4,unit_5,unit_6 FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
			if($_POST['bezahlungsart']==1 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] &&
				$_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] &&
				$_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] &&
				$_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_1']>=$kosten['gesamt'])
			{ 
				if($transportsatz!=0)
				{$steuern=(int)($kosten['gesamt']*$transportsatz);
				}else{$steuern=0;}
				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
				if($daten['ress_1']>=$kosten['gesamt'])
				{
					// dem user Ressourcen abziehen:
					if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_1=resource_1-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						// dem NPC Ressourcen abziehen:
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['gesamt']).'+'.($steuern).' WHERE id=1'))==true)
						{
							$zufall_tick=mt_rand(23,420);
							$zufall_tick=$zufall_tick+$ACTUAL_TICK;
							if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
								VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.$kosten['gesamt'].',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT123")).':'.$kosten['gesamt'].'</td></tr>
										<tr><td><b>'.constant($game->sprache("TEXT187")).'</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
										'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
										'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
										'Lv6:'.$_POST['unit_6'].'</td></tr>' .
										'<tr><td>' .
										'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',0,'.$_POST['transportsart'].','.$kosten['gesamt'].',0,0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(NOTICE, constant($game->sprache("TEXT153")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
			}
			elseif($_POST['bezahlungsart']==2 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_2']>=$kosten['gesamt'])
			{
				if($transportsatz!=0)
				{
					$steuern=(int)($kosten['gesamt']*$transportsatz);
				}else{$steuern=0;}
				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
				if($daten['ress_2']>=$kosten['gesamt'])
				{
					if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_2=resource_2-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['gesamt']).'+'.($steuern).' WHERE id=1'))==true)
						{
							$zufall_tick=mt_rand(23,420);
							$zufall_tick=$zufall_tick+$ACTUAL_TICK;
							if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
								VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.$kosten['gesamt'].',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
										<tr><td>Mineral:'.$kosten['gesamt'].'</td></tr>
										<tr><td><b>'.constant($game->sprache("TEXT187")).'</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
										'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
										'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
										'Lv6:'.$_POST['unit_6'].'</td></tr>' .
										'<tr><td>' .
										'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',1,'.$_POST['transportsart'].',0,'.$kosten['gesamt'].',0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(NOTICE, constant($game->sprache("TEXT153")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
			}
			elseif($_POST['bezahlungsart']==3 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_3']>=$kosten['gesamt'])
			{
				if($transportsatz!=0)
				{
					$steuern=(int)($kosten['gesamt']*$transportsatz);
				}else{$steuern=0;}
				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
				if($daten['ress_3']>=$kosten['gesamt'])
				{
					if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_3=resource_3-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						// dem user Ressourcen abziehen:
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3+'.($steuern-$kosten['gesamt']).'  WHERE id=1'))==true)
						{
							$zufall_tick=mt_rand(23,420);
							$zufall_tick=$zufall_tick+$ACTUAL_TICK;
							if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
								VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.$kosten['gesamt'].',"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
										<tr><td>Latinum:'.$kosten['gesamt'].'</td></tr>
										<tr><td><b>'.constant($game->sprache("TEXT187")).'</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
										'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
										'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
										'Lv6:'.$_POST['unit_6'].'</td></tr>' .
										'<tr><td>' .
										'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',2,'.$_POST['transportsart'].',0,0,'.$kosten['gesamt'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(NOTICE, constant($game->sprache("TEXT153")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
			}
			elseif($_POST['bezahlungsart']==4 && isset($transportsatz) && $daten['ress_2']>=$kosten['Mineral'] && $daten['ress_3']>=$kosten['Latinum'] && $daten['ress_1']>=$kosten['Metall'] && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'])
			{
				if($transportsatz!=0)
				{
					$steuern['1']=(int)($kosten['Metall']*$transportsatz);
					$steuern['2']=(int)($kosten['Mineral']*$transportsatz);
					$steuern['3']=(int)($kosten['Latinum']*$transportsatz);
				}else{$steuern['1']=0;$steuern['2']=0;$steuern['3']=0;}

				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
				if($daten['ress_1']>=$kosten['Metall'] && $daten['ress_2']>=$kosten['Mineral']  && $daten['ress_3']>=$kosten['Latinum'] )
				{
					if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).',resource_1=resource_1-'.($steuern['1']).' ,resource_2=resource_2-'.($steuern['2']).',resource_3=resource_3-'.($steuern['3']).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						// dem user Ressourcen abziehen:
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern['1']).',ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern['2']).',ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern['3']).' WHERE id=1'))==true)
						{
							$zufall_tick=mt_rand(23,420);
							$zufall_tick=$zufall_tick+$ACTUAL_TICK;
							if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
								VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']).','.($kosten['Mineral']).','.($kosten['Latinum']).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT147")).'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT123")).':'.$kosten['Metall'].'<br>Mineral:'.$kosten['Mineral'].'<br>Latinum:'.$kosten['Latinum'].'</td></tr>
										<tr><td><b>'.constant($game->sprache("TEXT187")).'</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
										'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
										'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
										'Lv6:'.$_POST['unit_6'].'</td></tr>' .
										'<tr><td>' .
										'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></form></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',3,'.$_POST['transportsart'].','.$kosten['Metall'].','.$kosten['Mineral'].','.$kosten['Latinum'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(DATABASE_ERROR, 'Internal database error');}
				}
				else{message(NOTICE, constant($game->sprache("TEXT153")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
			}
			else
			{
				$game->out(constant($game->sprache("TEXT188")));
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_cache_trupp_trade');
				$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=2').'" method="post"><tr><td colspan=2>');
				$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
				$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
				$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
				$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
				$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
				$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
				$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
			}
		}
	}
	elseif(isset($_REQUEST['handel']) && $_REQUEST['handel']=='sold_truppen' && isset($_REQUEST['step']) && $_REQUEST['step']=='2' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0) && !($_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0))
	{
		$kosten['Metall']=0;
		$kosten['Mineral']=0;
		$kosten['gesamt']=0;
		$kosten['Latinum']=0;
		if($_POST['unit_1']!=0)
		{
			$unit_1=UnitPrice(0,0);
			$unit_2=UnitPrice(0,1);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_1'],"unit_1");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_1'],"unit_1");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral'];
		}
		if($_POST['unit_2']!=0)
		{
			$unit_1=UnitPrice(1,0);
			$unit_2=UnitPrice(1,1);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_2'],"unit_2");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_2'],"unit_2");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral'];
		}
		if($_POST['unit_3']!=0)
		{
			$unit_1=UnitPrice(2,0);
			$unit_2=UnitPrice(2,1);
			$unit_3=UnitPrice(2,2);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_3'],"unit_3");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_3'],"unit_3");
			$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_3'],"unit_3");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
		}
		if($_POST['unit_4']!=0)
		{
			$unit_1=UnitPrice(3,0);
			$unit_2=UnitPrice(3,1);
			$unit_3=UnitPrice(3,2);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_4'],"unit_4");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_4'],"unit_4");
			$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_4'],"unit_4");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
		}
		if($_POST['unit_5']!=0)
		{
			$unit_1=UnitPrice(4,0);
			$unit_2=UnitPrice(4,1);
			$unit_3=UnitPrice(4,2);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_5'],"unit_5");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_5'],"unit_5");
			$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_5'],"unit_5");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
		}
		if($_POST['unit_6']!=0)
		{
			$unit_1=UnitPrice(5,0);
			$unit_2=UnitPrice(5,1);
			$unit_3=UnitPrice(5,2);
			$kosten['Metall'] += sold_formel_truppen($unit_1,$_POST['unit_6'],"unit_6");
			$kosten['Mineral']+=  sold_formel_truppen($unit_2,$_POST['unit_6'],"unit_6");
			$kosten['Latinum']+=sold_formel_truppen($unit_3,$_POST['unit_6'],"unit_6");
			$kosten['gesamt']+=$kosten['Metall'] +$kosten['Mineral']+$kosten['Latinum'];
		}

		$kosten['gesamt']=(int)$kosten['gesamt'];
		$kosten['Metall']=(int)$kosten['Metall'];
		$kosten['Mineral']=(int)$kosten['Mineral'];
		$kosten['Latinum']=(int)$kosten['Latinum'];
		$steuern['1']=(int)($kosten['Metall']*0.30);
		$steuern['2']=(int)($kosten['Mineral']*0.30);
		$steuern['3']=(int)($kosten['Latinum']*0.30);
		$steuern['4']=(int)($kosten['gesamt']*0.30);
		$steuern['5']=(int)($kosten['Metall']*0.15);
		$steuern['6']=(int)($kosten['Mineral']*0.15);
		$steuern['7']=(int)($kosten['Latinum']*0.15);
		$steuern['8']=(int)($kosten['gesamt']*0.15);
		$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
		$game->out('<table>');
		$game->out('<tr><td colspan=2><table><tr><td></td><td>'.constant($game->sprache("TEXT189")).'</td><td>'.constant($game->sprache("TEXT123")).'</td><td>'.constant($game->sprache("TEXT165")).'</td><td>'.constant($game->sprache("TEXT167")).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT190")).'</td><td>'.$kosten['gesamt'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$kosten['Metall'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$kosten['Mineral'].' </td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$kosten['Latinum'].'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT191")).'</td><td>'.$steuern['4'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['1'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['2'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['3'].'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT164")).'</td><td>'.$steuern['8'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['5'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['6'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['7'].'</td></tr></table></td></tr>');
		$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=3').'" method="post"><tr><td>'.constant($game->sprache("TEXT169")).'</td><td><select size="1" name="bezahlungsart">
			<option value="1">'.constant($game->sprache("TEXT192")).'</option>
			<option value="2">'.constant($game->sprache("TEXT193")).'</option>
			<option value="3">'.constant($game->sprache("TEXT194")).'</option>
			<option value="4">'.constant($game->sprache("TEXT195")).'</option>
			</select></td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT173")).'</td><td><select size="1" name="transportsart">
			<option value="1">'.constant($game->sprache("TEXT263")).'</option>
			<option value="2">'.constant($game->sprache("TEXT264")).'</option>
			<option value="3">'.constant($game->sprache("TEXT265")).'</option>
			</select></td></tr><tr><td colspan=2><br>'.constant($game->sprache("TEXT177")).'</td></tr>');
		$sql='SELECT planet_id,planet_name,building_11 FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
		if(($planis=$db->query($sql))==false)
		{
			$game->out(constant($game->sprache("TEXT178")));
		}else{
			$game->out('<tr><td>'.constant($game->sprache("TEXT179")).'</td><td><select size="1" name="plani">');
			while($planeten=$db->fetchrow($planis))
			{
				if ($planeten['building_11']>0)
				{
					if ($game->planet['planet_id'] == $planeten['planet_id'])
						$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
					else
						$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
				}
			}
			$game->out('</select></td></tr>');
		}
		if(($planis=$db->query($sql))==false)
		{
			$game->out(constant($game->sprache("TEXT178")));
		}else{
			$game->out('<tr><td>'.constant($game->sprache("TEXT180")).'</td><td><select size="1" name="plani_ziel">');
			while($planeten=$db->fetchrow($planis))
			{
				if ($planeten['building_11']>0)
				{
					if ($game->planet['planet_id'] == $planeten['planet_id'])
						$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
					else
						$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
				}
			}
			$game->out('</select></td></tr>');
		}
		$game->out('<tr><td colspan=2>');
		$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
		$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
		$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
		$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
		$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
		$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
		$game->out('<input type="submit" value="'.constant($game->sprache("TEXT181")).'"  name="submit"></td></tr></form>');
		$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post"><tr><td colspan=2>');
		$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
		$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
		$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
		$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
		$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
		$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
		$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
	}
	else{
		if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='kaufen_truppen' && $_REQUEST['step']=='2' && $_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0) $game->out('Du musst auch schon wo eine Zahl eintragen<br>');
		$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
		$game->out('<table align=center><tr><td>'.constant($game->sprache("TEXT196")).'</td><td>'.constant($game->sprache("TEXT197")).'</td></tr>');
		$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=2').'" method="post"><td><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"></td><td><input type="text" name="unit_1" value="'.$_POST['unit_1'].'"></td></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit2_small.gif"></td><td><input type="text" name="unit_2" value="'.$_POST['unit_2'].'"></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"></td><td><input type="text" name="unit_3" value="'.$_POST['unit_3'].'"></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"></td><td><input type="text" name="unit_4" value="'.$_POST['unit_4'].'"></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"></td><td><input type="text" name="unit_5" value="'.$_POST['unit_5'].'"></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit6_small.gif"></td><td><input type="text" name="unit_6" value="'.$_POST['unit_6'].'"></td></tr>');
		$game->out('<tr><td colspan="3"><input type="submit" value="'.constant($game->sprache("TEXT198")).'"  name="submit"></td></form></tr></table>');
	}
}

function kauf_formel_truppen($grundkosten,$anzahl)
{
	$berechnung=$anzahl-($anzahl/2);
	$ergebniss=($anzahl*$grundkosten)-((pow($berechnung,2))*0.1);
	return $ergebniss=(int)$ergebniss;
}

function Trade_Buy_truppen()
{
	global $db;
	global $game,$ACTUAL_TICK;

	$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT199")).' '.HelpPopup('trade_buy_truppen').' :</span></center><br>');

	/*if($_POST['unit_1']==null || $_POST['unit_1']<0 )$_POST['unit_1']=0;
	if($_POST['unit_2']==null || $_POST['unit_2']<0 )$_POST['unit_2']=0;
	if($_POST['unit_3']==null || $_POST['unit_3']<0 )$_POST['unit_3']=0;
	if($_POST['unit_4']==null || $_POST['unit_4']<0 )$_POST['unit_4']=0;
	if($_POST['unit_5']==null || $_POST['unit_5']<0 )$_POST['unit_5']=0;
	if($_POST['unit_6']==null || $_POST['unit_6']<0 )$_POST['unit_6']=0;*/

	if(!isset($_POST['unit_1']) || $_POST['unit_1']<0 )$_POST['unit_1']=0;
	if(!isset($_POST['unit_2']) || $_POST['unit_2']<0 )$_POST['unit_2']=0;
	if(!isset($_POST['unit_3']) || $_POST['unit_3']<0 )$_POST['unit_3']=0;
	if(!isset($_POST['unit_4']) || $_POST['unit_4']<0 )$_POST['unit_4']=0;
	if(!isset($_POST['unit_5']) || $_POST['unit_5']<0 )$_POST['unit_5']=0;
	if(!isset($_POST['unit_6']) || $_POST['unit_6']<0 )$_POST['unit_6']=0;

	$_POST['unit_1']=(int)$_POST['unit_1'];
	$_POST['unit_2']=(int)$_POST['unit_2'];
	$_POST['unit_3']=(int)$_POST['unit_3'];
	$_POST['unit_4']=(int)$_POST['unit_4'];
	$_POST['unit_5']=(int)$_POST['unit_5'];
	$_POST['unit_6']=(int)$_POST['unit_6'];

	if(isset($_POST['plani_ziel'])){ $_POST['plani_ziel']=(int)$_POST['plani_ziel']; }
	if(isset($_POST['plani'])){ $_POST['plani']=(int)$_POST['plani']; }else{$_POST['plani']='unknown'; }
	$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

	/**
	  * 27/02/08 - AC: Check DB query...
	  */
	if($daten==null)
	{
		$daten['unit_1'] = 0;
		$daten['unit_2'] = 0;
		$daten['unit_3'] = 0;
		$daten['unit_4'] = 0;
		$daten['unit_5'] = 0;
		$daten['unit_6'] = 0;
		$daten['ress_1'] = 0;
		$daten['ress_2'] = 0;
		$daten['ress_3'] = 0;
	}

	if(!isset($_REQUEST['handel']))
		$_REQUEST['handel'] = 'unknown';
	/* */

	/* 05/03/08 - AC: If step is not specified, it is first step */
	if(!isset($_REQUEST['step'])) $_REQUEST['step'] = '1';


	if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='kaufen_truppen' &&
		$_POST['plani']!=null && $_REQUEST['step']=='3' && ($_POST['unit_1']!=0 ||
		$_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 ||
		$_POST['unit_5']!=0 || $_POST['unit_6']!=0))
	{
		$plani_id_a=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
		$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
		if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
		{
			$game->out(constant($game->sprache("TEXT146")));
		}
		else
		{
			$kosten['Metall']=0;
			$kosten['Mineral']=0;
			$kosten['gesamt']=0;
			$kosten['Latinum']=0;
			if($_POST['unit_1']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(280,$_POST['unit_1']);
				$kosten['Mineral']+=kauf_formel_truppen(235,$_POST['unit_1']);
				$kosten['gesamt']+=kauf_formel_truppen((280+235),$_POST['unit_1']);
			}
			if($_POST['unit_2']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(340,$_POST['unit_2']);
				$kosten['Mineral']+=kauf_formel_truppen(225,$_POST['unit_2']);
				$kosten['gesamt']+=kauf_formel_truppen((340+225),$_POST['unit_2']);
			}
			if($_POST['unit_3']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_3']);
				$kosten['Mineral']+=kauf_formel_truppen(450,$_POST['unit_3']);
				$kosten['Latinum']+=kauf_formel_truppen(350,$_POST['unit_3']);
				$kosten['gesamt']+=kauf_formel_truppen((650+450+350),$_POST['unit_3']);
			}
			if($_POST['unit_4']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(410,$_POST['unit_4']);
				$kosten['Mineral']+=kauf_formel_truppen(210,$_POST['unit_4']);
				$kosten['Latinum']+=kauf_formel_truppen(115,$_POST['unit_4']);
				$kosten['gesamt']+=kauf_formel_truppen((410+210+115),$_POST['unit_4']);
			}
			if($_POST['unit_5']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_5']);
				$kosten['Mineral']+=kauf_formel_truppen(440,$_POST['unit_5']);
				$kosten['Latinum']+=kauf_formel_truppen(250,$_POST['unit_5']);
				$kosten['gesamt']+=kauf_formel_truppen((650+440+250),$_POST['unit_5']);
			}
			if($_POST['unit_6']!=0)
			{
				$kosten['Metall']+=kauf_formel_truppen(1000,$_POST['unit_6']);
				$kosten['Mineral']+=kauf_formel_truppen(500,$_POST['unit_6']);
				$kosten['Latinum']+=kauf_formel_truppen(200,$_POST['unit_6']);
				$kosten['gesamt']+=kauf_formel_truppen((1000+500+200),$_POST['unit_6']);
			}
			if($_POST['transportsart']!=1 && $_POST['transportsart']!=2 && $_POST['transportsart']!=3)  {$game->out('Cheat'); exit;}
			if($_POST['transportsart']==1) {$transportsatz=0.30;$tickzeit=20*6;}
			if($_POST['transportsart']==2) {$transportsatz=0.15;$tickzeit=20*12;}
			if($_POST['transportsart']==3) {$transportsatz=0;$tickzeit=20*36;}
			$db->lock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');
			$plani_inhalt=$db->queryrow('SELECT resource_1,resource_2,resource_3 FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
			if($_POST['bezahlungsart']==1 && isset($transportsatz) && ($kosten['gesamt']+($kosten['gesamt']*$transportsatz))<=$plani_inhalt['resource_1'])
			{ 
				if($transportsatz!=0)
				{$steuern=(int)($kosten['gesamt']*$transportsatz);
				}else{$steuern=0;}

				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
			
				/**
				  * 27/02/08 - AC: Check DB query...
				  */
				if($daten==null)
				{
					$daten['unit_1'] = 0;
					$daten['unit_2'] = 0;
					$daten['unit_3'] = 0;
					$daten['unit_4'] = 0;
					$daten['unit_5'] = 0;
					$daten['unit_6'] = 0;
					$daten['ress_1'] = 0;
					$daten['ress_2'] = 0;
					$daten['ress_3'] = 0;
				}
				/* */
			
				if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6'])
				{
					// dem user Ressourcen abziehen:
					if (($db->query('UPDATE planets SET resource_1=resource_1-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						// dem NPC Ressourcen abziehen:
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true)
						{
							if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT200")).'</td></tr><tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td><tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr><tr><td>'.constant($game->sprache("TEXT201")).' '.$kosten['gesamt'].'</td></tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></table>');
									if(($db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',0,'.$_POST['transportsart'].','.$kosten['gesamt'].',0,0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')'))==false){message(DATABASE_ERROR, 'Interner Datenbankfehler');}
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(NOTICE, constant($game->sprache("TEXT202")));}
				}
				else{message(NOTICE, constant($game->sprache("TEXT203")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');
			}
			elseif($_POST['bezahlungsart']==2 && isset($transportsatz) && ($kosten['gesamt']+($kosten['gesamt']*$transportsatz))<=$plani_inhalt['resource_2'])
			{
				if($transportsatz!=0)
				{
					$steuern=(int)($kosten['gesamt']*$transportsatz);
				}
				else{$steuern=0;}

				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

				/**
				  * 27/02/08 - AC: Check DB query...
				  */
				if($daten==null)
				{
					$daten['unit_1'] = 0;
					$daten['unit_2'] = 0;
					$daten['unit_3'] = 0;
					$daten['unit_4'] = 0;
					$daten['unit_5'] = 0;
					$daten['unit_6'] = 0;
					$daten['ress_1'] = 0;
					$daten['ress_2'] = 0;
					$daten['ress_3'] = 0;
				}
				/* */

				if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2'] &&
				   $daten['unit_3']>=$_POST['unit_3'] && $daten['unit_4']>=$_POST['unit_4'] &&
				   $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6'])
				{
					if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true)
					{
						// dem user Ressourcen abziehen:
						if (($db->query('UPDATE planets SET resource_2=resource_2-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
						{
							// dem NPC Ressourcen abziehen:
							if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT200")).'</td></tr><tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td><tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr><tr><td>'.constant($game->sprache("TEXT204")).' '.$kosten['gesamt'].'</td></tr><tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',1,'.$_POST['transportsart'].',0,'.$kosten['gesamt'].',0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(NOTICE, constant($game->sprache("TEXT202")));}
				}
				else{message(NOTICE, constant($game->sprache("TEXT203")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');

			}
			elseif($_POST['bezahlungsart']==3 && isset($transportsatz) && ($kosten['gesamt']+($kosten['gesamt']*$transportsatz))<=$plani_inhalt['resource_3'])
			{
				if($transportsatz!=0)
				{
					$steuern=(int)($kosten['gesamt']*$transportsatz);
				}else{$steuern=0;}
				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

				/**
				  * 27/02/08 - AC: Check DB query...
				  */
				if($daten==null)
				{
					$daten['unit_1'] = 0;
					$daten['unit_2'] = 0;
					$daten['unit_3'] = 0;
					$daten['unit_4'] = 0;
					$daten['unit_5'] = 0;
					$daten['unit_6'] = 0;
					$daten['ress_1'] = 0;
					$daten['ress_2'] = 0;
					$daten['ress_3'] = 0;
				}
				/* */

				if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2'] &&
				   $daten['unit_3']>=$_POST['unit_3'] && $daten['unit_4']>=$_POST['unit_4'] &&
				   $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6'])
				{
					// dem user Ressourcen abziehen:
					if (($db->query('UPDATE planets SET resource_3=resource_3-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true)
						{
							// dem NPC Ressourcen abziehen:
							if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT200")).'</td></tr><tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td><tr><td>'.constant($game->sprache("TEXT149")).$steuern.'</td></tr><tr><td>'.constant($game->sprache("TEXT205")).' '.$kosten['gesamt'].'</td></tr><tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',2,'.$_POST['transportsart'].',0,0,'.$kosten['gesamt'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(NOTICE, constant($game->sprache("TEXT202")));}
				}
				else{message(NOTICE, constant($game->sprache("TEXT203")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');
			}
			elseif($_POST['bezahlungsart']==4 && isset($transportsatz) && ($kosten['Mineral']+($kosten['Mineral']*$transportsatz))<=$plani_inhalt['resource_2'] && ($kosten['Latinum']+($kosten['Latinum']*$transportsatz))<=$plani_inhalt['resource_3'] && ($kosten['Metall']+($kosten['Metall']*$transportsatz))<=$plani_inhalt['resource_1'])
			{
				if($transportsatz!=0)
				{
					$steuern['1']=(int)($kosten['Metall']*$transportsatz);
					$steuern['2']=(int)($kosten['Mineral']*$transportsatz);
					$steuern['3']=(int)($kosten['Latinum']*$transportsatz);
				}else{$steuern['1']=0;$steuern['2']=0;$steuern['3']=0;}
				// dem user Ressourcen abziehen:
				$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');

				/**
				  * 27/02/08 - AC: Check DB query...
				  */
				if($daten==null)
				{
					$daten['unit_1'] = 0;
					$daten['unit_2'] = 0;
					$daten['unit_3'] = 0;
					$daten['unit_4'] = 0;
					$daten['unit_5'] = 0;
					$daten['unit_6'] = 0;
					$daten['ress_1'] = 0;
					$daten['ress_2'] = 0;
					$daten['ress_3'] = 0;
				}
				/* */

				if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6'])
				{
					if (($db->query('UPDATE planets SET resource_1=resource_1-'.($kosten['Metall']+$steuern['1']).',resource_2=resource_2-'.($kosten['Mineral']+$steuern['2']).',resource_3=resource_3-'.($kosten['Latinum']+$steuern['3']).' WHERE planet_id='.$_POST['plani'].''))==true)
					{
						if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1+'.($kosten['Metall']+$steuern['1']).',ress_2=ress_2+'.($kosten['Mineral']+$steuern['2']).',ress_3=ress_3+'.($kosten['Latinum']+$steuern['3']).' WHERE id=1'))==true)
						{
							// dem NPC Ressourcen abziehen:
							if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true)
							{
								// Buyers goods in the Trade Register Scheduler:
								if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true)
								{
									$game->out('<table><tr><td>'.constant($game->sprache("TEXT200")).'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT206")).' '.$steuern['1'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT207")).' '.$steuern['2'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT208")).' '.$steuern['3'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT201")).' '.$kosten['Metall'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT204")).' '.$kosten['Mineral'].'</td></tr>
										<tr><td>'.constant($game->sprache("TEXT205")).' '.$kosten['Latinum'].'</td></tr>
										<tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr>
										<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
										<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></table>');
									$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',3,'.$_POST['transportsart'].','.$kosten['Metall'].','.$kosten['Mineral'].','.$kosten['Latinum'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');
								}
								else{message(DATABASE_ERROR, 'Internal database error');}
							}
							else{message(DATABASE_ERROR, 'Internal database error');}
						}
						else{message(DATABASE_ERROR, 'Internal database error');}
					}
					else{message(NOTICE, constant($game->sprache("TEXT202")));}
				}
				else{message(NOTICE, constant($game->sprache("TEXT203")));}
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');
			}
			else
			{
				$game->out(constant($game->sprache("TEXT209")));
				$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
				$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=2').'" method="post"><tr><td colspan=2>');
				$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
				$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
				$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
				$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
				$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
				$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
				$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
			}
		}
	}
	elseif(($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']) && $_REQUEST['handel']=='kaufen_truppen' && $_REQUEST['step']=='2' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0) && !($_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0))
	{
		$kosten['Metall']=0;
		$kosten['Mineral']=0;
		$kosten['gesamt']=0;
		$kosten['Latinum']=0;
		if($_POST['unit_1']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(280,$_POST['unit_1']);
			$kosten['Mineral']+=kauf_formel_truppen(235,$_POST['unit_1']);
			$kosten['gesamt']+=kauf_formel_truppen((280+235),$_POST['unit_1']);
		}
		if($_POST['unit_2']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(340,$_POST['unit_2']);
			$kosten['Mineral']+=kauf_formel_truppen(225,$_POST['unit_2']);
			$kosten['gesamt']+=kauf_formel_truppen((340+225),$_POST['unit_2']);
		}
		if($_POST['unit_3']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_3']);
			$kosten['Mineral']+=kauf_formel_truppen(450,$_POST['unit_3']);
			$kosten['Latinum']+=kauf_formel_truppen(350,$_POST['unit_3']);
			$kosten['gesamt']+=kauf_formel_truppen((650+450+350),$_POST['unit_3']);
		}
		if($_POST['unit_4']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(410,$_POST['unit_4']);
			$kosten['Mineral']+=kauf_formel_truppen(210,$_POST['unit_4']);
			$kosten['Latinum']+=kauf_formel_truppen(115,$_POST['unit_4']);
			$kosten['gesamt']+=kauf_formel_truppen((410+210+115),$_POST['unit_4']);
		}
		if($_POST['unit_5']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_5']);
			$kosten['Mineral']+=kauf_formel_truppen(440,$_POST['unit_5']);
			$kosten['Latinum']+=kauf_formel_truppen(250,$_POST['unit_5']);
			$kosten['gesamt']+=kauf_formel_truppen((650+440+250),$_POST['unit_5']);
		}
		if($_POST['unit_6']!=0)
		{
			$kosten['Metall']+=kauf_formel_truppen(1000,$_POST['unit_6']);
			$kosten['Mineral']+=kauf_formel_truppen(500,$_POST['unit_6']);
			$kosten['Latinum']+=kauf_formel_truppen(200,$_POST['unit_6']);
			$kosten['gesamt']+=kauf_formel_truppen((1000+500+200),$_POST['unit_6']);
		}

		$steuern['1']=(int)($kosten['Metall']*0.30);
		$steuern['2']=(int)($kosten['Mineral']*0.30);
		$steuern['3']=(int)($kosten['Latinum']*0.30);
		$steuern['4']=(int)($kosten['gesamt']*0.30);
		$steuern['5']=(int)($kosten['Metall']*0.15);
		$steuern['6']=(int)($kosten['Mineral']*0.15);
		$steuern['7']=(int)($kosten['Latinum']*0.15);
		$steuern['8']=(int)($kosten['gesamt']*0.15);
		$game->out('<table>');
		$game->out('<tr><td colspan=2><table><tr><td></td><td>'.constant($game->sprache("TEXT189")).'</td><td>'.constant($game->sprache("TEXT123")).'</td><td>'.constant($game->sprache("TEXT165")).'</td><td>'.constant($game->sprache("TEXT167")).'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT190")).'</td><td>'.$kosten['gesamt'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$kosten['Metall'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$kosten['Mineral'].' </td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$kosten['Latinum'].'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT191")).'</td><td>'.$steuern['4'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['1'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['2'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['3'].'</td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT164")).'</td><td>'.$steuern['8'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['5'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['6'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['7'].'</td></tr></table></td></tr>');
		$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=3').'" method="post"><tr><td>'.constant($game->sprache("TEXT169")).'</td><td><select size="1" name="bezahlungsart">
			<option value="1">'.constant($game->sprache("TEXT192")).'</option>
			<option value="2">'.constant($game->sprache("TEXT193")).'</option>
			<option value="3">'.constant($game->sprache("TEXT194")).'</option>
			<option value="4">'.constant($game->sprache("TEXT195")).'</option>
			</select></td></tr>');
		$game->out('<tr><td>'.constant($game->sprache("TEXT173")).'</td><td><select size="1" name="transportsart">
			<option value="1">'.constant($game->sprache("TEXT263")).'</option>
			<option value="2">'.constant($game->sprache("TEXT264")).'</option>
			<option value="3">'.constant($game->sprache("TEXT265")).'</option>
			</select></td></tr><tr><td colspan=2><br>'.constant($game->sprache("TEXT177")).'</td></tr>');
		$sql='SELECT planet_id,planet_name,building_11 FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
		if(($planis=$db->query($sql))==false)
		{
			$game->out(constant($game->sprache("TEXT178")));
		}else{
			$game->out('<tr><td>'.constant($game->sprache("TEXT179")).'</td><td><select size="1" name="plani">');
			while($planeten=$db->fetchrow($planis))
			{
				if ($planeten['building_11']>0)
				{
					if ($game->planet['planet_id'] == $planeten['planet_id'])
						$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
					else
						$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
				}
			}
			$game->out('</select></td></tr>');
		}
		if(($planis=$db->query($sql))==false)
		{
			$game->out(constant($game->sprache("TEXT178")));
		}else{
			$game->out('<tr><td>'.constant($game->sprache("TEXT180")).'</td><td><select size="1" name="plani_ziel">');
			while($planeten=$db->fetchrow($planis))
			{
				if ($planeten['building_11']>0)
				{
					if ($game->planet['planet_id'] == $planeten['planet_id'])
						$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
					else
						$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
				}
			}
			$game->out('</select></td></tr>');
		}
		$game->out('<tr><td colspan=2>');
		$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
		$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
		$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
		$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
		$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
		$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
		$game->out('<input type="submit" value="'.constant($game->sprache("TEXT181")).'"  name="submit"></td></tr></form>');
		$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post"><tr><td colspan=2>');
		$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
		$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
		$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
		$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
		$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
		$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
		$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
	}
	else
	{
		if($_REQUEST['handel']=='kaufen_truppen' && $_REQUEST['step']=='2' && $_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0)
			$game->out(constant($game->sprache("TEXT182")));
		if(!($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']))
			$game->out(constant($game->sprache("TEXT210")));
		$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
	
		/**
		  * 27/02/08 - AC: Check DB query...
		  */
		if($truppen==null)
		{
			$truppen['unit_1'] = 0;
			$truppen['unit_2'] = 0;
			$truppen['unit_3'] = 0;
			$truppen['unit_4'] = 0;
			$truppen['unit_5'] = 0;
			$truppen['unit_6'] = 0;
		}
		/* */

		$game->out('<table align="center"><tr><td>'.constant($game->sprache("TEXT196")).'</td><td>'.constant($game->sprache("TEXT197")).'</td><td align="left">'.constant($game->sprache("TEXT211")).'</td></tr>');
		$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=2').'" method="post"><td><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"></td><td><input type="text" name="unit_1" value="'.$_POST['unit_1'].'"></td><td>('.$truppen['unit_1'].')<td></td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit2_small.gif"></td><td><input type="text" name="unit_2" value="'.$_POST['unit_2'].'"></td><td>('.$truppen['unit_2'].')</td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"></td><td><input type="text" name="unit_3" value="'.$_POST['unit_3'].'"></td><td>('.$truppen['unit_3'].')</td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"></td><td><input type="text" name="unit_4" value="'.$_POST['unit_4'].'"></td><td>('.$truppen['unit_4'].')</td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"></td><td><input type="text" name="unit_5" value="'.$_POST['unit_5'].'"></td><td>('.$truppen['unit_5'].')</td></tr>');
		$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit6_small.gif"></td><td><input type="text" name="unit_6" value="'.$_POST['unit_6'].'"></td><td>('.$truppen['unit_6'].')</td></tr>');
		$game->out('<tr><td colspan="3"><input type="submit" value="'.constant($game->sprache("TEXT212")).'"  name="submit"></td></form></tr></table>');
	}
}

function Show_Main_a()
{
	global $db,$ACTUAL_TICK;
	global $game,$RACE_DATA,$STRADE_MODULES,$sub_action;
	if(isset($_REQUEST["note"]) && $_REQUEST['note']=="sichern")
	{
		$_POST['hz_notepad']=htmlspecialchars($_POST['hz_notepad']);
		if($db->query('UPDATE `trade_settings` SET handel_notepad="'.$_POST['hz_notepad'].'" WHERE user_id='.$game->player['user_id'].'')==false)
		{
			message(DATABASE_ERROR, 'Internal database error');
		}
	}

	if(($anzahl=$db->num_rows($db->query('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id'].' ')))<1) 
	{
		if($db->query('INSERT INTO `trade_settings` ( `user_id` , `handel_notepad` ) VALUES ('.$game->player['user_id'].', "")')==false)
		{
		message(DATABASE_ERROR, 'Internal database error');
		}
	}
	if(($trade_settings=$db->query('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id'].''))==false) 
	{
		$game->out('<br><b>ERROR: -Bitte einem Admin melden - deine Trade Settings konnten nicht geladen werden</b><br>');
	}else
	{
		$settings=$db->queryrow('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id']);

		$game->out('<table><tr><td>');

		$anzahl_gesperrt=$db->queryrow('SELECT count(*) AS anzahl FROM user WHERE trade_tick!=0');
		$sql_cv = 'SELECT b.user,b.trade_id FROM (bidding b)
					RIGHT JOIN (ship_trade t) ON b.trade_id=t.id
					WHERE b.user='.$game->player['user_id'].' AND t.end_time>='.$ACTUAL_TICK.'';
		if(($gebote_user=$db->query($sql_cv))==true)
		{
			$array_a=array();
			$zzza=0;
			$pruefer_c=0;
			while($gebote_user_t=$db->fetchrow($gebote_user))
			{
				$pruefer_c=0;
				for($u=0;$u<count($array_a);$u++)
				{
					if($gebote_user_t['trade_id']==$array_a[$u])$pruefer_c==1;
				}
				if($pruefer_c!=1)
				{
					$zzza++;
					$array_a[]=$gebote_user_t['trade_id'];
				}
			}
		}
		$anzahl_truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');

		// 20/02/08 - AC: Check if data is valid!
		if($anzahl_truppen == null)
		{
			$anzahl_truppen['unit_1'] = '0';
			$anzahl_truppen['unit_2'] = '0';
			$anzahl_truppen['unit_3'] = '0';
			$anzahl_truppen['unit_4'] = '0';
			$anzahl_truppen['unit_5'] = '0';
			$anzahl_truppen['unit_6'] = '0';
			$anzahl_truppen['ress_1'] = '0';
			$anzahl_truppen['ress_2'] = '0';
			$anzahl_truppen['ress_3'] = '0';
		}

		$ship_anzahl=$db->queryrow('SELECT count(*) AS anzahl FROM ship_trade WHERE scheduler_processed=0 AND start_time<='.$ACTUAL_TICK.' AND end_time>='.$ACTUAL_TICK.'');
		$game->out('<br><br>'.constant($game->sprache("TEXT213")).'<br>
			<li><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"> '.$anzahl_truppen['unit_1'].'</li>
			<li><img src="'.$game->GFX_PATH.'menu_unit2_small.gif">  '.$anzahl_truppen['unit_2'].'</li>
			<li><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"> '.$anzahl_truppen['unit_3'].'</li>
			<li><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"> '.$anzahl_truppen['unit_4'].'</li>
			<li><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"> '.$anzahl_truppen['unit_5'].'</li>
			<li><img src="'.$game->GFX_PATH.'menu_unit6_small.gif">  '.$anzahl_truppen['unit_6'].'</li>
			'.constant($game->sprache("TEXT214")).' '.($anzahl_truppen['unit_1']+$anzahl_truppen['unit_2']+$anzahl_truppen['unit_3']+$anzahl_truppen['unit_4']+$anzahl_truppen['unit_5']+$anzahl_truppen['unit_6']).'<br><br>
			'.constant($game->sprache("TEXT215")).'<br>
			<li><img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($anzahl_truppen['ress_1'], 0, '.', '.').'</li>
			<li><img src="'.$game->GFX_PATH.'menu_mineral_small.gif"> '.number_format($anzahl_truppen['ress_2'], 0, '.', '.').'</li>
			<li><img src="'.$game->GFX_PATH.'menu_latinum_small.gif">  '.number_format($anzahl_truppen['ress_3'], 0, '.', '.').'</li>
			'.constant($game->sprache("TEXT214")).' '.number_format(($anzahl_truppen['ress_1']+$anzahl_truppen['ress_2']+$anzahl_truppen['ress_3']), 0, '.', '.').'<br><br>');
		$t_gesamt = $db->queryrow('SELECT sum(unit_1) AS eins, sum(unit_2) AS zwei, sum(unit_3) AS drei, sum(unit_4) AS vier, sum(unit_5) AS fuenf, sum(unit_6) AS sechs FROM `FHB_handel_log` WHERE art=1');
		$zeit=(($ACTUAL_TICK-34149)*3)/60;
		$zeit=(int)$zeit;
		$link='test<br>';
		$catname='';
		$game->out(constant($game->sprache("TEXT187")).($t_gesamt['eins']+$t_gesamt['zwei']+$t_gesamt['drei']+$t_gesamt['vier']+$t_gesamt['fuenf']+$t_gesamt['sechs']).' ('.constant($game->sprache("TEXT219")).' '.$zeit.'h)<br>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_1_.png>\',CAPTION,\'Unit 1\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit1_small.gif">'.$t_gesamt['eins'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_2_.png>\',CAPTION,\'Unit 2\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit2_small.gif">'.$t_gesamt['zwei'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_3_.png>\',CAPTION,\'Unit 3\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit3_small.gif">'.$t_gesamt['drei'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_4_.png>\',CAPTION,\'Unit 4\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit4_small.gif">'.$t_gesamt['vier'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_5_.png>\',CAPTION,\'Unit 5\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit5_small.gif">'.$t_gesamt['fuenf'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_6_.png>\',CAPTION,\'Unit 6\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit6_small.gif">'.$t_gesamt['sechs'].' - '.constant($game->sprache("TEXT220")).'</a></li>
			<br>');

		$game->out('</td><td>');
		for ($t=0; $t<12; $t++)
		{
			$r_tmp = $db->queryrow('SELECT COUNT(id) AS num FROM FHB_handel_log WHERE art=1 AND rasse='.$t);
			$race['racecount_'.$t]=$r_tmp['num'];
		}
		$t_percent = $db->queryrow('SELECT count(*) AS num FROM `FHB_handel_log` WHERE art=1');

		for ($t=0; $t<12; $t++)
		{
			// 20/02/08 - AC: Check if data is valid!
			if($t_percent['num'] == 0)
				$t_percent['num'] = 100;

			$race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
		}
		$game->out('<br>'.constant($game->sprache("TEXT221")).'<table width="150px" border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td width="130" class="desc_row">'.$RACE_DATA[0][0].':</td>
			<td width="140" class="value_row">'.$race['racepercent_0'].'%</td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[1][0].':</td>
			<td class="value_row">'.$race['racepercent_1'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[2][0].':</td>
			<td class="value_row">'.$race['racepercent_2'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[3][0].':</td>
			<td class="value_row">'.$race['racepercent_3'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[4][0].':</td>
			<td class="value_row">'.$race['racepercent_4'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[9][0].':</td>
			<td class="value_row">'.$race['racepercent_9'].'%</b></td>
			</tr>
			<tr height="10"><td></td></tr>
			</table><br>');
		for ($t=0; $t<12; $t++)
		{
			$r_tmp = $db->queryrow('SELECT COUNT(id) AS num FROM FHB_handel_log WHERE art=2 AND rasse='.$t);
			$race['racecount_'.$t]=$r_tmp['num'];
		}
		$t_percent = $db->queryrow('SELECT count(*) AS num FROM `FHB_handel_log` WHERE art=2');
		for ($t=0; $t<12; $t++)
		{
			// 20/02/08 - AC: Check if data is valid!
			if($t_percent['num'] == 0)
				$t_percent['num'] = 100;

			$race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
		}
		$game->out('<br>'.constant($game->sprache("TEXT222")).'<table width="150px" border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td width="130" class="desc_row">'.$RACE_DATA[0][0].':</td>
			<td width="140" class="value_row">'.$race['racepercent_0'].'%</td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[1][0].':</td>
			<td class="value_row">'.$race['racepercent_1'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[2][0].':</td>
			<td class="value_row">'.$race['racepercent_2'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[3][0].':</td>
			<td class="value_row">'.$race['racepercent_3'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[4][0].':</td>
			<td class="value_row">'.$race['racepercent_4'].'%</b></td>
			</tr>
			<tr>
			<td class="desc_row">'.$RACE_DATA[9][0].':</td>
			<td class="value_row">'.$race['racepercent_9'].'%</b></td>
			</tr>
			<tr height="10"><td></td></tr>
			</table></td><td>');
	}
}

function Show_schulden($zustand=0)
{
	global $db;
	global $game,$UNIT_NAME,$ACTUAL_TICK;
	/*if($_POST['metall']==null)$_POST['metall']=0;
	if($_POST['mineralien']==null)$_POST['mineralien']=0;
	if($_POST['latinum']==null)$_POST['latinum']=0;
	if($_POST['unit1']==null)$_POST['unit1']=0;
	if($_POST['unit2']==null)$_POST['unit2']=0;
	if($_POST['unit3']==null)$_POST['unit3']=0;
	if($_POST['unit4']==null)$_POST['unit4']=0;
	if($_POST['unit5']==null)$_POST['unit5']=0;
	if($_POST['unit6']==null)$_POST['unit6']=0;*/
	if(!isset($_POST['metall']))$_POST['metall']=0;
	if(!isset($_POST['mineralien']))$_POST['mineralien']=0;
	if(!isset($_POST['latinum']))$_POST['latinum']=0;
	if(!isset($_POST['unit1']))$_POST['unit1']=0;
	if(!isset($_POST['unit2']))$_POST['unit2']=0;
	if(!isset($_POST['unit3']))$_POST['unit3']=0;
	if(!isset($_POST['unit4']))$_POST['unit4']=0;
	if(!isset($_POST['unit5']))$_POST['unit5']=0;
	if(!isset($_POST['unit6']))$_POST['unit6']=0;

	if($_POST['metall']<0)$_POST['metall']=0;
	if($_POST['mineralien']<0)$_POST['mineralien']=0;
	if($_POST['latinum']<0)$_POST['latinum']=0;
	if($_POST['unit1']<0)$_POST['unit1']=0;
	if($_POST['unit2']<0)$_POST['unit2']=0;
	if($_POST['unit3']<0)$_POST['unit3']=0;
	if($_POST['unit4']<0)$_POST['unit4']=0;
	if($_POST['unit5']<0)$_POST['unit5']=0;
	if($_POST['unit6']<0)$_POST['unit6']=0;

	$_POST['unit1']=(int)$_POST['unit1'];
	$_POST['unit2']=(int)$_POST['unit2'];
	$_POST['unit3']=(int)$_POST['unit3'];
	$_POST['unit4']=(int)$_POST['unit4'];
	$_POST['unit5']=(int)$_POST['unit5'];
	$_POST['unit6']=(int)$_POST['unit6'];
	$_POST['metall']=(int)$_POST['metall'];
	$_POST['mineralien']=(int)$_POST['mineralien'];
	$_POST['latinum']=(int)$_POST['latinum'];
	if(($c_1=$db->queryrow('SELECT * FROM planets WHERE planet_id="'.$game->player['active_planet'].'" AND planet_owner="'.$game->player['user_id'].'"'))==false){message(DATABASE_ERROR, 'Could select schulden data data');}
	if(isset($_REQUEST['status_bezahlen']) && $_REQUEST['status_bezahlen']==2 &&
		!($c_1['unit_1']<$_POST['unit1'] || $c_1['unit_2']<$_POST['unit2'] ||
		$c_1['unit_3']<$_POST['unit3'] || $c_1['unit_4']<$_POST['unit4'] ||
		$c_1['unit_5']<$_POST['unit5'] || $c_1['unit_6']<$_POST['unit6'] ||
		$c_1['resource_1']<$_POST['metall'] || $c_1['resource_2']<$_POST['mineralien'] || $c_1['resource_3']<$_POST['latinum'] ))
	{
		$zustand_b=0;
		$zustand_a=0;
		if(($k_1=$db->queryrow('SELECT * FROM treuhandkonto WHERE code="'.$_REQUEST['auktion'].'"'))==false)
		{message(DATABASE_ERROR, 'Could select konto data data');}
		if(($s_1=$db->queryrow('SELECT * FROM schulden_table WHERE id="'.$_REQUEST['auktion'].'"'))==false)
		{message(DATABASE_ERROR, 'Could select schulden data data');}

		//Schauen ob die schulden bezahlt sind
		(($ergebnis=vergleich($k_1['ress_1']+$_POST['metall'],$s_1['ress_1']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['ress_2']+$_POST['mineralien'],$s_1['ress_2']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['ress_3']+$_POST['latinum'],$s_1['ress_3']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_1']+$_POST['unit1'],$s_1['unit_1']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_2']+$_POST['unit2'],$s_1['unit_2']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_3']+$_POST['unit3'],$s_1['unit_3']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_4']+$_POST['unit4'],$s_1['unit_4']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_5']+$_POST['unit5'],$s_1['unit_5']))==0) ? $zustand_b=1 : $zustand_a=1;
		(($ergebnis=vergleich($k_1['unit_6']+$_POST['unit6'],$s_1['unit_6']))==0) ? $zustand_b=1 : $zustand_a=1;

		if($k_1['unit_1']>$s_1['unit_1']) $k_1['unit_1']=$s_1['unit_1'];
		if($k_1['unit_2']>$s_1['unit_2']) $k_1['unit_2']=$s_1['unit_2'];
		if($k_1['unit_3']>$s_1['unit_3']) $k_1['unit_3']=$s_1['unit_3'];
		if($k_1['unit_4']>$s_1['unit_4']) $k_1['unit_4']=$s_1['unit_4'];
		if($k_1['unit_5']>$s_1['unit_5']) $k_1['unit_5']=$s_1['unit_5'];
		if($k_1['unit_6']>$s_1['unit_6']) $k_1['unit_6']=$s_1['unit_6'];
		if($k_1['ress_1']>$s_1['ress_1']) $k_1['ress_1']=$s_1['ress_1'];
		if($k_1['ress_2']>$s_1['ress_2']) $k_1['ress_2']=$s_1['ress_2'];
		if($k_1['ress_3']>$s_1['ress_3']) $k_1['ress_3']=$s_1['ress_3'];

		//Wenn zu groß dann
		if(($k_1['unit_1']+$_POST['unit1'])>$s_1['unit_1']) $_POST['unit1']=$s_1['unit_1']-$k_1['unit_1'];
		if(($k_1['unit_2']+$_POST['unit2'])>$s_1['unit_2']) $_POST['unit2']=$s_1['unit_2']-$k_1['unit_2'];
		if(($k_1['unit_3']+$_POST['unit3'])>$s_1['unit_3']) $_POST['unit3']=$s_1['unit_3']-$k_1['unit_3'];
		if(($k_1['unit_4']+$_POST['unit4'])>$s_1['unit_4']) $_POST['unit4']=$s_1['unit_4']-$k_1['unit_4'];
		if(($k_1['unit_5']+$_POST['unit5'])>$s_1['unit_5']) $_POST['unit5']=$s_1['unit_5']-$k_1['unit_5'];
		if(($k_1['unit_6']+$_POST['unit6'])>$s_1['unit_6']) $_POST['unit6']=$s_1['unit_6']-$k_1['unit_6'];
		if(($k_1['ress_1']+$_POST['metall'])>$s_1['ress_1']) $_POST['metall']=$s_1['ress_1']-$k_1['ress_1'];
		if(($k_1['ress_2']+$_POST['mineralien'])>$s_1['ress_2']) $_POST['mineralien']=$s_1['ress_2']-$k_1['ress_2'];
		if(($k_1['ress_3']+$_POST['latinum'])>$s_1['ress_3']) $_POST['latinum']=$s_1['ress_3']-$k_1['ress_3'];

		if(($c_1=$db->queryrow('SELECT * FROM planets WHERE planet_id="'.$game->player['active_planet'].'" AND planet_owner="'.$game->player['user_id'].'"'))==false){message(DATABASE_ERROR, 'Could select schulden data data');}

		if(!($c_1['unit_1']<$_POST['unit1'] || $c_1['unit_2']<$_POST['unit2'] || $c_1['unit_3']<$_POST['unit3'] || $c_1['unit_4']<$_POST['unit4'] || $c_1['unit_5']<$_POST['unit5'] || $c_1['unit_6']<$_POST['unit6'] || $c_1['resource_1']<$_POST['metall'] || $c_1['resource_2']<$_POST['mineralien'] || $c_1['resource_3']<$_POST['latinum'] )==true){
		if(($db->query('UPDATE planets SET resource_1=resource_1-'.$_POST['metall'].', resource_2=resource_2-'.$_POST['mineralien'].',resource_3=resource_3-'.$_POST['latinum'].',unit_1=unit_1-'.$_POST['unit1'].',unit_2=unit_2-'.$_POST['unit2'].',unit_3=unit_3-'.$_POST['unit3'].',unit_4=unit_4-'.$_POST['unit4'].',unit_5=unit_5-'.$_POST['unit5'].',unit_6=unit_6-'.$_POST['unit6'].' WHERE planet_id="'.$game->player['active_planet'].'" AND planet_owner="'.$game->player['user_id'].'"'))==false){message(DATABASE_ERROR, 'Could not update planet data');}
		if(($db->query('UPDATE treuhandkonto SET ress_1=ress_1+'.$_POST['metall'].', ress_2=ress_2+'.$_POST['mineralien'].',ress_3=ress_3+'.$_POST['latinum'].',unit_1=unit_1+'.$_POST['unit1'].',unit_2=unit_2+'.$_POST['unit2'].',unit_3=unit_3+'.$_POST['unit3'].',unit_4=unit_4+'.$_POST['unit4'].',unit_5=unit_5+'.$_POST['unit5'].',unit_6=unit_6+'.$_POST['unit6'].' WHERE code="'.$_POST['auktion'].'"'))==true)
		{
			$game->out(constant($game->sprache("TEXT233")));
		}else{
			message(DATABASE_ERROR, 'Could not update konto data');
		}
		//Meldung posten
		if($zustand_a==0)
		{
			$game->out(constant($game->sprache("TEXT234")));
		}
		}else{message(DATABASE_ERROR, 'Could select schulden data data');}
	}


	$sql_a='SELECT * FROM schulden_table WHERE status=0 AND user_kauf="'.$game->player['user_id'].'"';
	$schulden_a=$db->query($sql_a);
	$text='<br><center><table border=0 cellpadding="3" cellspacing="3" class="style_inner">
		<tr><td>'.constant($game->sprache("TEXT235")).'</td><!--<td>'.constant($game->sprache("TEXT236")).'</td>--><td>'.constant($game->sprache("TEXT123")).'</td><td>'.constant($game->sprache("TEXT165")).'</td><td>'.constant($game->sprache("TEXT167")).'</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>'.constant($game->sprache("TEXT237")).'</td><td>'.constant($game->sprache("TEXT238")).'</td><td>'.constant($game->sprache("TEXT239")).'</td><td></td></tr>
		<tr><td colspan="12"><hr></td></tr>';
	if($db->num_rows()<=0)
	{
		$text.='<tr><td colspan="12"><center>'.constant($game->sprache("TEXT240")).'</center></td></tr>';
	}else
	{
		while($schulden=$db->fetchrow($schulden_a))
		{
			$sql_b='SELECT t.*,u.user_name AS user_name_1,z.user_name AS user_name_2 FROM (treuhandkonto t ) LEFT JOIN schulden_table s on s.id=t.code LEFT JOIN user u on s.user_ver=u.user_id LEFT JOIN user z on s.user_kauf=z.user_id WHERE code="'.$schulden['id'].'"';
			if(($schulden_gesamt=$db->queryrow($sql_b))==false)message(DATABASE_ERROR, 'Could not select data');

			$schulden_gesamt['ress_1']=$schulden['ress_1']-$schulden_gesamt['ress_1'];
			$schulden_gesamt['ress_2']=$schulden['ress_2']-$schulden_gesamt['ress_2'];
			$schulden_gesamt['ress_3']=$schulden['ress_3']-$schulden_gesamt['ress_3'];
			$schulden_gesamt['unit_1']=$schulden['unit_1']-$schulden_gesamt['unit_1'];
			$schulden_gesamt['unit_2']=$schulden['unit_2']-$schulden_gesamt['unit_2'];
			$schulden_gesamt['unit_3']=$schulden['unit_3']-$schulden_gesamt['unit_3'];
			$schulden_gesamt['unit_4']=$schulden['unit_4']-$schulden_gesamt['unit_4'];
			$schulden_gesamt['unit_5']=$schulden['unit_5']-$schulden_gesamt['unit_5'];
			$schulden_gesamt['unit_6']=$schulden['unit_6']-$schulden_gesamt['unit_6'];
			$text.="<tr>";
			$text.="<td><a href=".parse_link("a=trade&view=view_bidding_detail&id=".$schulden['auktions_id']).">".$schulden['auktions_id']."</a></td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_metal_small.gif'>".$schulden_gesamt['ress_1']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_mineral_small.gif'>".$schulden_gesamt['ress_2']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_latinum_small.gif'> ".$schulden_gesamt['ress_3']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit1_small.gif'>".$schulden_gesamt['unit_1']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit2_small.gif'>".$schulden_gesamt['unit_2']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit3_small.gif'>".$schulden_gesamt['unit_3']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit4_small.gif'>".$schulden_gesamt['unit_4']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit5_small.gif'>".$schulden_gesamt['unit_5']."</td>";
			$text.="<td><img src='".$game->GFX_PATH."menu_unit6_small.gif'>".$schulden_gesamt['unit_6']."</td>";
			$text.="<td>";
			$timea=(($schulden['timestep']+(20*24*6))-$ACTUAL_TICK)*3/60;
			$text.="".$timea." ".constant($game->sprache("TEXT226"))."</td>";
			$text.='<td><form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&status_bezahlen=1').'">
				<input type="hidden" name="auktion" value="'.$schulden['id'].'">
				<input type="submit" name="zahlen" class="Button_nosize" value="'.constant($game->sprache("TEXT241")).'" style="width:100px"></form>
				</td>';
			$text.="</tr>";
		}
	}
	$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT242")).' <!--'.HelpPopup('trade_viewstatus').'--> :</span></center><br>');
	$game->out($text);
	$game->out('</table></center>');
	if(isset($_REQUEST['status_bezahlen']) && $_REQUEST['status_bezahlen']==1)
	{
		$planet_data=$db->queryrow('SELECT planet_name FROM planets WHERE planet_id='.$game->player['active_planet'].'');
		$game->out('<br><center>'.constant($game->sprache("TEXT243")).' '.$_REQUEST['auktion'].':</center><br>
		'.constant($game->sprache("TEXT244")).' '.$planet_data['planet_name'].' '.constant($game->sprache("TEXT245")).' <br>
		<form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&status_bezahlen=2').'">
		<table border=0 cellpadding="3" cellspacing="3" class="style_inner" width=300><tr>
		<td>'.constant($game->sprache("TEXT123")).'</td><td>'.constant($game->sprache("TEXT165")).'</td><td>'.constant($game->sprache("TEXT167")).'</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>'.constant($game->sprache("TEXT237")).'</td><td>'.constant($game->sprache("TEXT238")).'</td><td></td></tr>
		<tr>
		<td><input name="metall" type="text" size="6" maxlength="6">'.$game->planet['resource_1'].'</td>
		<td><input name="mineralien" type="text" size="6" maxlength="6">'.$game->planet['resource_2'].'</td>
		<td><input name="latinum" type="text" size="6" maxlength="6">'.$game->planet['resource_3'].'</td>
		<td><input name="unit1" type="text" size="6" maxlength="6">'.$game->planet['unit_1'].'</td>
		<td><input name="unit2" type="text" size="6" maxlength="6">'.$game->planet['unit_2'].'</td>
		<td><input name="unit3" type="text" size="6" maxlength="6">'.$game->planet['unit_3'].'</td>
		<td><input name="unit4" type="text" size="6" maxlength="6">'.$game->planet['unit_4'].'</td>
		<td><input name="unit5" type="text" size="6" maxlength="6">'.$game->planet['unit_5'].'</td>
		<td><input name="unit6" type="text" size="6" maxlength="6">'.$game->planet['unit_6'].'</td>
		</tr><tr><td colspan="10"><input type="hidden" name="auktion" value="'.$_REQUEST['auktion'].'">
		<input type="submit" name="einzahlen" class="Button_nosize" value="'.constant($game->sprache("TEXT246")).'" style="width:100px"></td>
		</tr></table></form>');
	}
}


function konto_sold()
{
	global $db;
	global $game,$ACTUAL_TICK;

	/*if($_POST['metall']==null)$_POST['metall']=0;
	if($_POST['mineralien']==null)$_POST['mineralien']=0;
	if($_POST['latinum']==null)$_POST['latinum']=0;
	if($_POST['unit1']==null)$_POST['unit1']=0;
	if($_POST['unit2']==null)$_POST['unit2']=0;
	if($_POST['unit3']==null)$_POST['unit3']=0;
	if($_POST['unit4']==null)$_POST['unit4']=0;
	if($_POST['unit5']==null)$_POST['unit5']=0;
	if($_POST['unit6']==null)$_POST['unit6']=0;*/
	if(!isset($_POST['metall']))$_POST['metall']=0;
	if(!isset($_POST['mineralien']))$_POST['mineralien']=0;
	if(!isset($_POST['latinum']))$_POST['latinum']=0;
	if(!isset($_POST['unit1']))$_POST['unit1']=0;
	if(!isset($_POST['unit2']))$_POST['unit2']=0;
	if(!isset($_POST['unit3']))$_POST['unit3']=0;
	if(!isset($_POST['unit4']))$_POST['unit4']=0;
	if(!isset($_POST['unit5']))$_POST['unit5']=0;
	if(!isset($_POST['unit6']))$_POST['unit6']=0;

	$_POST['unit1']=(int)$_POST['unit1'];
	$_POST['unit2']=(int)$_POST['unit2'];
	$_POST['unit3']=(int)$_POST['unit3'];
	$_POST['unit4']=(int)$_POST['unit4'];
	$_POST['unit5']=(int)$_POST['unit5'];
	$_POST['unit6']=(int)$_POST['unit6'];
	$_POST['metall']=(int)$_POST['metall'];
	$_POST['mineralien']=(int)$_POST['mineralien'];
	$_POST['latinum']=(int)$_POST['latinum'];

	if($_POST['metall']<0)$_POST['metall']=0;
	if($_POST['mineralien']<0)$_POST['mineralien']=0;
	if($_POST['latinum']<0)$_POST['latinum']=0;
	if($_POST['unit1']<0)$_POST['unit1']=0;
	if($_POST['unit2']<0)$_POST['unit2']=0;
	if($_POST['unit3']<0)$_POST['unit3']=0;
	if($_POST['unit4']<0)$_POST['unit4']=0;
	if($_POST['unit5']<0)$_POST['unit5']=0;
	if($_POST['unit6']<0)$_POST['unit6']=0;


	$game->out('<center><span class="sub_caption">'.constant($game->sprache("TEXT253")).' '.HelpPopup('konto').' :</span></center><br>');

	if(isset($_POST['plani_ziel']))
		$_POST['plani_ziel']=(int)$_POST['plani_ziel'];
	else
		$_POST['plani_ziel'] = null;

	if(isset($_REQUEST['handel']) && $_REQUEST['handel']=='kontoauszahlung' && $_POST['plani_ziel']!=null && $_REQUEST['step']=='2' && ($_POST['unit1']!=0 || $_POST['unit2']!=0 || $_POST['unit3']!=0 ||  $_POST['unit4']!=0 || $_POST['unit5']!=0 || $_POST['unit6']!=0 || $_POST['metall']!=0 || $_POST['mineralien']!=0 || $_POST['latinum']!=0))
	{
		if(($konto_full=$db->query('SELECT s.status,s.id,t.* FROM (schulden_table s) LEFT JOIN (treuhandkonto t) ON s.id=t.code WHERE status=1 AND user_ver='.$game->player['user_id'].''))==false)
		{
			message(DATABASE_ERROR, 'Could not open Kontos');
		}
		$db_ress_1=$db_ress_2=$db_ress_3=$db_unit_1=$db_unit_2=$db_unit_3=$db_unit_4=$db_unit_5=$db_unit_6=0;
		while($konto_full_t=$db->fetchrow($konto_full))
		{
			$db_ress_1+=$konto_full_t['ress_1'];
			$db_ress_2+=$konto_full_t['ress_2'];
			$db_ress_3+=$konto_full_t['ress_3'];
			$db_unit_1+=$konto_full_t['unit_1'];
			$db_unit_2+=$konto_full_t['unit_2'];
			$db_unit_3+=$konto_full_t['unit_3'];
			$db_unit_4+=$konto_full_t['unit_4'];
			$db_unit_5+=$konto_full_t['unit_5'];
			$db_unit_6+=$konto_full_t['unit_6'];
		}

		if($_POST['metall']>$db_ress_1)$_POST['metall']=$db_ress_1;
		if($_POST['mineralien']>$db_ress_2)$_POST['mineralien']=$db_ress_2;
		if($_POST['latinum']>$db_ress_3)$_POST['latinum']=$db_ress_3;
		if($_POST['unit1']>$db_unit_1)$_POST['unit1']=$db_unit_1;
		if($_POST['unit2']>$db_unit_2)$_POST['unit2']=$db_unit_2;
		if($_POST['unit3']>$db_unit_3)$_POST['unit3']=$db_unit_3;
		if($_POST['unit4']>$db_unit_4)$_POST['unit4']=$db_unit_4;
		if($_POST['unit5']>$db_unit_5)$_POST['unit5']=$db_unit_5;
		if($_POST['unit6']>$db_unit_6)$_POST['unit6']=$db_unit_6;

		$unit_1=$_POST['unit1'];
		$unit_2=$_POST['unit2'];
		$unit_3=$_POST['unit3'];
		$unit_4=$_POST['unit4'];
		$unit_5=$_POST['unit5'];
		$unit_6=$_POST['unit6'];
		$ress_1=$_POST['metall'];
		$ress_2=$_POST['mineralien'];
		$ress_3=$_POST['latinum'];

		$plani_id_a=$db->queryrow('SELECT planet_id,planet_name FROM planets WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
		if($plani_id_a['planet_id']!=$_POST['plani_ziel'])
		{
			$game->out(constant($game->sprache("TEXT146")));
		}else
		{

			if($_POST['transportsart']!=1 && $_POST['transportsart']!=2 && $_POST['transportsart']!=3)  {$game->out('Cheat'); exit;}
			if($_POST['transportsart']==1) {$transportsatz=0.30;$tickzeit=20*6;}
			if($_POST['transportsart']==2) {$transportsatz=0.15;$tickzeit=20*12;}
			if($_POST['transportsart']==3) {$transportsatz=0;$tickzeit=20*36;}

			$db->lock('scheduler_resourcetrade','schulden_table s','treuhandkonto t', 'treuhandkonto', 'schulden_table');
			if(($konto_inhalt=$db->query('SELECT s.status,s.id AS code_id,t.* FROM (schulden_table s) LEFT JOIN (treuhandkonto t) on s.id=t.code WHERE s.status=1 AND s.user_ver='.$game->player['user_id'].''))==true)
			{
 
				$xxx=0;
				while($konto_inhalt_t=$db->fetchrow($konto_inhalt))
				{
					if($ress_1<=0 && $ress_2<=0 && $ress_3<=0 && $unit_1<=0 && $unit_2<=0 && $unit_3<=0 && $unit_4<=0 && $unit_5<=0 && $unit_6<=0) break;

					if($ress_1>=$konto_inhalt_t['ress_1']){ $ress_1=$ress_1-$konto_inhalt_t['ress_1'];$konto_inhalt_t['ress_1']=0; } else { $konto_inhalt_t['ress_1']=$konto_inhalt_t['ress_1']-$ress_1; $ress_1=0; }
					if($ress_2>=$konto_inhalt_t['ress_2']){ $ress_2=$ress_2-$konto_inhalt_t['ress_2'];$konto_inhalt_t['ress_2']=0; } else { $konto_inhalt_t['ress_2']=$konto_inhalt_t['ress_2']-$ress_2; $ress_2=0; }
					if($ress_3>=$konto_inhalt_t['ress_3']){ $ress_3=$ress_3-$konto_inhalt_t['ress_3'];$konto_inhalt_t['ress_3']=0; } else { $konto_inhalt_t['ress_3']=$konto_inhalt_t['ress_3']-$ress_3; $ress_3=0; }
					if($unit_1>=$konto_inhalt_t['unit_1']){ $unit_1=$unit_1-$konto_inhalt_t['unit_1'];$konto_inhalt_t['unit_1']=0; } else { $konto_inhalt_t['unit_1']=$konto_inhalt_t['unit_1']-$unit_1; $unit_1=0; }
					if($unit_2>=$konto_inhalt_t['unit_2']){ $unit_2=$unit_2-$konto_inhalt_t['unit_2'];$konto_inhalt_t['unit_2']=0; } else { $konto_inhalt_t['unit_2']=$konto_inhalt_t['unit_2']-$unit_2; $unit_2=0; }
					if($unit_3>=$konto_inhalt_t['unit_3']){ $unit_3=$unit_3-$konto_inhalt_t['unit_3'];$konto_inhalt_t['unit_3']=0; } else { $konto_inhalt_t['unit_3']=$konto_inhalt_t['unit_3']-$unit_3; $unit_3=0; }
					if($unit_4>=$konto_inhalt_t['unit_4']){ $unit_4=$unit_4-$konto_inhalt_t['unit_4'];$konto_inhalt_t['unit_4']=0; } else { $konto_inhalt_t['unit_4']=$konto_inhalt_t['unit_4']-$unit_4; $unit_4=0; }
					if($unit_5>=$konto_inhalt_t['unit_5']){ $unit_5=$unit_5-$konto_inhalt_t['unit_5'];$konto_inhalt_t['unit_5']=0; } else { $konto_inhalt_t['unit_5']=$konto_inhalt_t['unit_5']-$unit_5; $unit_5=0; }
					if($unit_6>=$konto_inhalt_t['unit_6']){ $unit_6=$unit_6-$konto_inhalt_t['unit_6'];$konto_inhalt_t['unit_6']=0; } else { $konto_inhalt_t['unit_6']=$konto_inhalt_t['unit_6']-$unit_6; $unit_6=0; }
					if(!$db->query('UPDATE treuhandkonto SET ress_1='.($konto_inhalt_t['ress_1']).',ress_2='.($konto_inhalt_t['ress_2']).',ress_3='.($konto_inhalt_t['ress_3']).',unit_1='.($konto_inhalt_t['unit_1']).',unit_2='.($konto_inhalt_t['unit_2']).',unit_3='.($konto_inhalt_t['unit_3']).',unit_4='.($konto_inhalt_t['unit_4']).',unit_5='.($konto_inhalt_t['unit_5']).',unit_6='.($konto_inhalt_t['unit_6']).' WHERE code='.$konto_inhalt_t['code_id'].''))message(DATABASE_ERROR, 'Could not update new konto data');

					if($konto_inhalt_t['ress_1']==0 && $konto_inhalt_t['ress_2']==0 && $konto_inhalt_t['ress_3']==0 && $konto_inhalt_t['unit_1']==0 && $konto_inhalt_t['unit_2']==0 && $konto_inhalt_t['unit_3']==0 && $konto_inhalt_t['unit_4']==0 && $konto_inhalt_t['unit_5']==0 && $konto_inhalt_t['unit_6']==0)
					{
						if(!$db->query('UPDATE schulden_table SET status=2 WHERE id='.$konto_inhalt_t['code_id'].''))message(DATABASE_ERROR, 'Could not update new status');
					}
					$xxx++;
				}

				$sql = 'INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ('.$_POST['plani_ziel'].','.$_POST['metall'].','.$_POST['mineralien'].','.$_POST['latinum'].','.$_POST['unit1'].','.$_POST['unit2'].','.$_POST['unit3'].','.$_POST['unit4'].','.$_POST['unit5'].','.$_POST['unit6'].','.($ACTUAL_TICK+$tickzeit).')';

				if($xxx!=0)
				{
					if (($db->query($sql))==true)
					{
						/* 07/03/08 - AC: There are no taxes here */
						$steuern = 0;

						$game->out('<table><tr><td>'.constant($game->sprache("TEXT254")).'</td></tr>
							<tr><td>'.constant($game->sprache("TEXT148")).$plani_id_a['planet_name'].'</td><tr><td><!-- '.constant($game->sprache("TEXT149")).$steuern.' --></td></tr>
							<tr><td>Lv1:'.$_POST['unit1'].'<br>Lv2:'.$_POST['unit2'].'<br>Lv3:'.$_POST['unit3'].'<br>Lv4:'.$_POST['unit4'].'<br>Lv5:'.$_POST['unit5'].'<br>Lv6:'.$_POST['unit6'].'<br>'.constant($game->sprache("TEXT123")).':'.$_POST['metall'].'<br>'.constant($game->sprache("TEXT165")).': '.$_POST['mineralien'].'<br>'.constant($game->sprache("TEXT167")).': '.$_POST['latinum'].'</td></tr>
							<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung').'" method="post"><input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></table>'); //}
						$db->unlock('scheduler_resourcetrade','schulden_table s','treuhandkonto t', 'treuhandkonto', 'schulden_table');
					}
				}else{
					message(DATABASE_ERROR, 'Internal database error - X is Null');
				}
			}else
			{
				$db->unlock('scheduler_resourcetrade','schulden_table s','treuhandkonto t', 'treuhandkonto', 'schulden_table');
				message(DATABASE_ERROR, 'Could not select data');
				$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung').'" method="post"><tr><td>');
				$game->out('<input type="submit" value="'.constant($game->sprache("TEXT152")).'"  name="submit"></td></tr></form></table>');
			}
		}
	}
	else
	{

		if(($konto_full=$db->query('SELECT s.status,s.id,t.* FROM (schulden_table s) LEFT JOIN treuhandkonto t on s.id=t.code WHERE s.status=1 AND s.user_ver='.$game->player['user_id'].''))==false){
			message(DATABASE_ERROR, 'Could not open Kontos');
		}else{
			if($db->num_rows()<=0)
			{
				$game->out(constant($game->sprache("TEXT255")));
			}else{
				$game->out('<table>');

				$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung&step=2').'" method="post">');

				$game->out('<tr><td>'.constant($game->sprache("TEXT173")).'</td><td><select size="1" name="transportsart">
					<option value="1">'.constant($game->sprache("TEXT266")).'</option>
					<!--<option value="1">'.constant($game->sprache("TEXT174")).'</option>-->
					<!--<option value="2">'.constant($game->sprache("TEXT175")).'</option>-->
					<!--<option value="3">'.constant($game->sprache("TEXT176")).'</option>-->
					</select></td></tr><tr><td colspan=2><br>'.constant($game->sprache("TEXT177")).'</td></tr>');
				$sql='SELECT planet_id,planet_name,building_11 FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
				if(($planis=$db->query($sql))==false)
				{
					$game->out(constant($game->sprache("TEXT178")));
				}else{
					$game->out('<tr><td>'.constant($game->sprache("TEXT256")).'</td><td><select size="1" name="plani_ziel">');
					while($planeten=$db->fetchrow($planis))
					{
						if ($planeten['building_11']>0)
						{
							if ($game->planet['planet_id'] == $planeten['planet_id'])
								$game->out('<option value="'.$planeten['planet_id'].'" selected="selected">'.$planeten['planet_name'].'</option>');
							else
								$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
						}
					}
					$game->out('</select></td></tr>');
				}
				$game->out('<tr><td colspan=2><br>');
				$game->out('<br><center><table border=0 cellpadding="3" cellspacing="3" class="style_inner" width=300>
					<tr><td>'.constant($game->sprache("TEXT123")).'</td><td>'.constant($game->sprache("TEXT165")).'</td><td>'.constant($game->sprache("TEXT167")).'</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>'.constant($game->sprache("TEXT237")).'</td><td>'.constant($game->sprache("TEXT238")).'</td><td></td></tr>
					<tr><td colspan="10"><hr></td></tr>');

				$db_ress_1=$db_ress_2=$db_ress_3=$db_unit_1=$db_unit_2=$db_unit_3=$db_unit_4=$db_unit_5=$db_unit_6=0;
				while($konto_full_t=$db->fetchrow($konto_full))
				{
					$db_ress_1+=$konto_full_t['ress_1'];
					$db_ress_2+=$konto_full_t['ress_2'];
					$db_ress_3+=$konto_full_t['ress_3'];
					$db_unit_1+=$konto_full_t['unit_1'];
					$db_unit_2+=$konto_full_t['unit_2'];
					$db_unit_3+=$konto_full_t['unit_3'];
					$db_unit_4+=$konto_full_t['unit_4'];
					$db_unit_5+=$konto_full_t['unit_5'];
					$db_unit_6+=$konto_full_t['unit_6'];
				}
				$game->out('<td><input name="metall" type="text" size="6" maxlength="6"><br>'.$db_ress_1.'</td>
					<td><input name="mineralien" type="text" size="6" maxlength="6"><br>'.$db_ress_2.'</td>
					<td><input name="latinum" type="text" size="6" maxlength="6"><br>'.$db_ress_3.'</td>
					<td><input name="unit1" type="text" size="6" maxlength="6"><br>'.$db_unit_1.'</td>
					<td><input name="unit2" type="text" size="6" maxlength="6"><br>'.$db_unit_2.'</td>
					<td><input name="unit3" type="text" size="6" maxlength="6"><br>'.$db_unit_3.'</td>
					<td><input name="unit4" type="text" size="6" maxlength="6"><br>'.$db_unit_4.'</td>
					<td><input name="unit5" type="text" size="6" maxlength="6"><br>'.$db_unit_5.'</td>
					<td><input name="unit6" type="text" size="6" maxlength="6"><br>'.$db_unit_6.'</td></tr></table></td></tr>');

				$game->out('<tr><td colspan="2"><input type="submit" value="'.constant($game->sprache("TEXT257")).'"  name="submit"></td></tr></form></table>');
			}
		}
	}
}



/****************************************************************************/
/****************************************************************************/
/**                                                                                                                   **/
/**       M A I N   P R O C E D U R E   O F   T H I S   M O D U L E                      **/
/**                                                                                                                   **/
/****************************************************************************/
/****************************************************************************/
if ($game->planet['building_11']<1)
{
	$game->out('<center><span class="caption">'.$BUILDING_NAME[$game->player['user_race']]['10'].'</span><br><br>');
	message(NOTICE, constant($game->sprache("TEXT258")).' '.$BUILDING_NAME[$game->player['user_race']][10].' '.constant($game->sprache("TEXT259")));
	//$game->out('<center><span class="caption">'.$BUILDING_NAME[$game->player['user_race']]['10'].'</span><br><br><center><span class="text_large">'.constant($game->sprache("TEXT258")).' '.$BUILDING_NAME[$game->player['user_race']]['10'].' '.constant($game->sprache("TEXT259")).'</span></center><br><br>');
}
else
{
	if ($game->player['trade_tick']>0)
		$game->player['deny_trade']=1;
	else
		$game->player['deny_trade']=0;
	$sub_action = (!empty($_GET['view'])) ? $_GET['view'] : 'main';
	$game->out('<span class="sub_caption">'.constant($game->sprache("TEXT260")).'</span><br><b>'.constant($game->sprache("TEXT261")).'</b><br>'.display_view_navigation_extended('trade', $sub_action, $STRADE_MODULES,1));
	$game->out('<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width="650"><tr><td>');

	if($sub_action=='main')
	{
		Show_Main_a();
	}
	elseif($sub_action=='trade_buy_truppen')
	{
		if ($game->player['deny_trade'])
			Show_BidDenied();
		else
			Trade_Buy_truppen();
	}
	elseif($sub_action=='konto_status')
	{
		konto_sold();
	}
	elseif($sub_action=='trade_sold_truppen')
	{
		if ($game->player['deny_trade'])
			Show_BidDenied();
		else
			Trade_Sold_truppen();
	}
	elseif($sub_action=='trade_ress')
	{
		if ($game->player['deny_trade'])
			Show_BidDenied();
		else
			Trade_Ress();
	}
	elseif ($sub_action=='status_offer')
	{
		Show_Status();
	}
	else
	{
		Show_Main_a();
	}
	$game->out('</td></tr></table></table>');
}
?>