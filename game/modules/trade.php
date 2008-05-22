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


ini_set ('error_reporting', E_ALL);
    $STRADE_MODULES = array(
        'main' => 'Übersicht', // Show_Main
        'status_offer' => 'Lieferübersicht', //Show_Status();
	'trade_buy_truppen' =>'Söldnermarkt(Kauf)', // Truppenhandel kaufen Trade_Buy_truppen
	'trade_sold_truppen' =>'Söldnermarkt(Verkauf)', // Truppenhandel kaufen Trade_Sold_truppen
	'trade_ress'=>'Ressourcen Handel', //Resshandel
	'create_bidding' => 'Auktion erstellen', //Show_CreateBidding();
	'view_bidding' => 'Auktionen einsehen', //Show_Bidding();
	'view_own_bidding' => 'Eigene Auktionen', //Show_Bidding(1);
	'own_bidding' => 'Laufende Gebote', //Show_Bidding(1);
	'konto_status' => 'Treuhandkonto', //Konto_Status
	'status_bezahlen'=>'Schulden bezahlen',//Show_schulden
	'warteschlange'=>'Schiffe abhohlen', //Ship_warten

    );
function vergleich($wert1,$wert2)
{
	return ($wert1>=$wert2) ? 0 : 1;
}

function CreateShipInfoText($ship)
{
global $db;
global $game;
$text='<b>'.$ship[31].'</b><br><br><u>Fähigkeiten:</u><br>';

$text.='L. Waffen: '.$ship[14].'<br>';
$text.='Schw. Waffen: '.$ship[15].'<br>';
$text.='Pl. Waffen: '.$ship[16].'<br>';
$text.='Schildstärke: '.$ship[17].'<br>';
$text.='Hülle (HP): '.$ship[18].'<br>';
$text.='Reaktion: '.$ship[19].'<br>';
$text.='Bereitschaft: '.$ship[20].'<br>';
$text.='Wendigkeit: '.$ship[21].'<br>';
$text.='Erfahrung: '.$ship[22].'<br>';
$text.='Warp: '.$ship[23].'<br>';
$text.='Sensoren: '.$ship[24].'<br>';
$text.='Tarnung: '.$ship[25].'<br>';
$text.='Verbraucht Energie: '.$ship[27].'<br>';
$text.='Liefert Energie: '.$ship[26].'<br>';


return $text;
}




function CreateRealShipInfoText($ship_data)
{
global $db;
global $game,$SHIPIMAGE_PATH;
$text='<font color=#000000><table widht=500 border=0 cellpadding=0 cellspacing=0><tr><td width=250><table width=* border=0 cellpadding=0 cellspacing=0><tr><td valign=top><u>Name:</u><br><b>'.$ship_data['name'].'</b><br><br></td></tr><tr><td valign=top><u>Beschreibung:</u><br>'.str_replace("\r\n", '<br>',wordwrap($ship_data['description'], 40,"<br>",1 )).'<br><br></td></tr><tr><td valign=top><u>Bild:</u><br><img src='.$SHIPIMAGE_PATH.'ship'.$ship_data['owner_race'].'_'.$ship_data['ship_torso'].'.jpg></td></tr><tr><td valign=top><u>Komponenten:</u><br>';


for ($t=0; $t<10; $t++)
{
	if ($ship['component_'.($t+1)]>=0)
	{
		$text.='-&nbsp;'.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'<br>';
	} 
		else $text.='- Nicht belegt<br>';
}

$text.='<br></td></tr></table></td><td width=250><table width=* border=0 cellpadding=0 cellspacing=0><tr><td valign=top><u>Schiffsdaten:</u><br>';

$text.='<u>L. Waffen:</u> <b>'.$ship_data['value_1'].'</b><br>';
$text.='<u>Schw. Waffen:</u> <b>'.$ship_data['value_2'].'</b><br>';
$text.='<u>Pl. Waffen:</u> <b>'.$ship_data['value_3'].'</b><br>';
$text.='<u>Reaktion:</u> <b>'.$ship_data['value_6'].'</b><br>';
$text.='<u>Bereitschaft:</u> <b>'.$ship_data['value_7'].'</b><br>';
$text.='<u>Wendigkeit:</u> <b>'.$ship_data['value_8'].'</b><br>';
$text.='<u>Erfahrung:</u> <b>'.$ship_data['value_9'].'</b><br>';
$text.='<u>Warp:</u> <b>'.$ship_data['value_10'].'</b><br>';
$text.='<u>Sensoren:</u> <b>'.$ship_data['value_11'].'</b><br>';
$text.='<u>Tarnung:</u> <b>'.$ship_data['value_12'].'</b><br>';
$text.='<u>Energieverbrauch:</u> <b>'.$ship_data['value_14'].'/'.$ship_data['value_13'].'</b><br><br>';
$text.='<u>Schildstärke:</u> <b>'.$ship_data['value_4'].'</b><br>';
$text.='<u>Hlle (HP):</u> <b>'.$ship_data['hitpoints'].'/'.$ship_data['value_5'].'</b><br>';
$text.='<br></td></tr><tr><td valign=top><u>Crew:</u>:<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif>'.$ship_data['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif>'.$ship_data['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif>'.$ship_data['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif>'.$ship_data['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif>'.$ship_data['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif>'.$ship_data['unit_6'].'<br></td></tr></table></td></tr></table>';
$text.='</td></tr></table></td></tr></table><br></font>';

$text=str_replace("'",'',$text);
$text=str_replace('"','',$text);
return $text;
}


function CreateCompInfoText($comp)
{
global $db;
global $game;
$text=''.$comp['description'].'<br><br>Fähigkeiten:</u><br>';

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
return $text;
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

function Zeit($minutes)
{
$days=0;
$hours=0;
while($minutes>=60*24) {$days++; $minutes-=60*24;}
while($minutes>=60) {$hours++; $minutes-=60;}

return (''.$days.'d '.$hours.'h '.$minutes.'m');
}


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
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }
	if (isset($_REQUEST['planets'])) {
    $sql = 'SELECT t.*,p.planet_name,p.planet_owner FROM (scheduler_resourcetrade t)
			LEFT JOIN (planets p) ON p.planet_id=t.planet WHERE p.planet_owner="'.$game->player['user_id'].'" ORDER BY `planet_name` ASC';
    if(($tradedata = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }
	}
	 
    $nr = 0;


	$game->out('<center><span class="sub_caption">Lieferstatus einsehen: '.HelpPopup('trade_viewstatus').' :</span></center><br>');
	$game->out('
	<center>
	<table border=0 cellpadding=1 cellspacing=1 class="style_inner">
	<tr>
	<td width=350><center>
	<b>Folgende Lieferungen zeigen:</b><br>
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view']).'">Alle Planeten</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&active_planet=1').'">Aktiver Planet</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&active_planet=1').'">Planeten</a>
	</center></td></tr></table>
	</center><br>
	');
	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=500 class="style_outer">');
	$game->out('<tr><td width=575>
	    <table border=0 cellpadding=4 cellspacing=0 width=500 class="style_inner">
	<tr><td width=75><b>Ankunftszeit:</b></td><td width=350><b>Ware:</b></td><td width=75><b>Zielplanet:</b></td>');

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

			if ($num>5)
   			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" color:'.$color.';"><a href="javascript:void();"><td><b>'.Zeit(TICK_DURATION*$tradedata[$t]['arrival_time']-TICK_DURATION*$ACTUAL_TICK+round($NEXT_TICK/60,0)).'</b></td><td>'.$ware.'</td><td>'.$tradedata[$t]['planet_name'].'</td></a></tr>');
			else
  			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" color:'.$color.';"><a href="javascript:void();"><td><b id="timer'.($num+4).'" title="time1_'.($NEXT_TICK+TICK_DURATION*60*($tradedata[$t]['arrival_time']-$ACTUAL_TICK)).'_type1_5">&nbsp;</b></td><td>'.$ware.'</td><td>'.$tradedata[$t]['planet_name'].'</td></a></tr>');

			$num++;
	    }

	}


	$game->out('</table></td></tr></table>');

}




function Show_BidDenied()
{
global $db;
global $game,$ACTUAL_TICK,$NEXT_TICK,$SHIPIMAGE_PATH,$SHIP_TORSO;
$game->out('<center><span class="sub_caption">Zugriff verweigert:</span><br>
<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center>Du hast keinen Zugriff auf diese Sektion, bis deine Schulden beglichen sind.<br><br>Oder du deine Sperre aufgrund Verstoße gegen die Regeln abgessesn hast.<br><br>Deine Sperre dauert noch '.(($game->player['trade_tick']-$ACTUAL_TICK)*3).' Minuten an. Eine Beschwerde gegen diese Sperre ist sinnlos.</center></td></tr></table>
</center>
');
}








function Submit_Bid()
{
global $db;
global $game,$ACTUAL_TICK;


$_REQUEST['id']=(int)$_REQUEST['id'];
$_REQUEST['max_bid']=(int)$_REQUEST['max_bid'];

if ($_REQUEST['id']<0) return 0;


    $sql = 'SELECT s.*,u.user_name,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				WHERE s.id= "'.$_REQUEST['id'].'" GROUP BY s.id LIMIT 1
				';

    if(($tradedata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }

	// Will der Verkäufer cheaten?
    if ($tradedata['user']==$game->player['user_id']) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Du kannst nicht für deine eigenen Auktionen bieten<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}
	// Auktion abgelaufen?:
	if ($tradedata['end_time']<$ACTUAL_TICK) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Die Auktion ist beendet<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}

	$min_bieten=-1;     // -1 means that there was NO bid yet
    if ($tradedata['num_bids']==1) $min_bieten=1;

    if ($tradedata['num_bids']<2)
	{
	    $min_resources[0]=$tradedata['resource_1'];
	    $min_resources[1]=$tradedata['resource_2'];
	    $min_resources[2]=$tradedata['resource_3'];
	   	//neu
     	$min_resources[3]=$tradedata['unit_1'];
	    $min_resources[4]=$tradedata['unit_2'];
	    $min_resources[5]=$tradedata['unit_3'];
     	$min_resources[6]=$tradedata['unit_4'];
	    $min_resources[7]=$tradedata['unit_5'];
	    $min_resources[8]=$tradedata['unit_6'];
	    //ende
        if ($tradedata['num_bids']!=0)
		{
	    $min_resources[0]=$tradedata['resource_1']+$tradedata['add_resource_1'];
	    $min_resources[1]=$tradedata['resource_2']+$tradedata['add_resource_2'];
	    $min_resources[2]=$tradedata['resource_3']+$tradedata['add_resource_3'];
	   	$min_resources[3]=$tradedata['unit_1']+$tradedata['add_unit_1'];
	    $min_resources[4]=$tradedata['unit_2']+$tradedata['add_unit_2'];
	    $min_resources[5]=$tradedata['unit_3']+$tradedata['add_unit_3'];
	    $min_resources[6]=$tradedata['unit_4']+$tradedata['add_unit_4'];
	    $min_resources[7]=$tradedata['unit_5']+$tradedata['add_unit_5'];
	    $min_resources[8]=$tradedata['unit_6']+$tradedata['add_unit_6'];

		}
		else $min_price=$actual_price;
	}
	else
	{
        $prelast_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid LIMIT '.($tradedata['num_bids']-2).',1');
		// Um zu testen, ob ein Gleichstand besteht, dann wird ja nicht max_bid +1
		$last_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid DESC LIMIT 1');
		if ($last_bid['max_bid']!=$prelast_bid['max_bid'])
		{
			$min_bieten=$prelast_bid['max_bid']+1+1; // +1 für aktuelles gebot, nochmal +1 für das nächste

		    $min_resources[0]=($tradedata['resource_1']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_1']);
		    $min_resources[1]=($tradedata['resource_2']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_2']);
	    	$min_resources[2]=($tradedata['resource_3']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_3']);
	    	$min_resources[3]=($tradedata['unit_1']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_1']);
		    $min_resources[4]=($tradedata['unit_2']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_2']);
	    	$min_resources[5]=($tradedata['unit_3']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_3']);
	    	$min_resources[6]=($tradedata['unit_4']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_4']);
		    $min_resources[7]=($tradedata['unit_5']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_5']);
	    	$min_resources[8]=($tradedata['unit_6']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_6']);

		}
		else
		{
			$min_bieten=$prelast_bid['max_bid']+1; // +1 für das nächste gebot, weil ja gleichstand war

		    $min_resources[0]=($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']);
		    $min_resources[1]=($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']);
	    	$min_resources[2]=($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']);
			  $min_resources[3]=($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']);
		    $min_resources[4]=($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']);
	    	$min_resources[5]=($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']);
	    	$min_resources[6]=($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']);
		    $min_resources[7]=($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']);
	    	$min_resources[8]=($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']);
		}

	}




	if ($min_bieten==-1)    // Das 1. Gebot abgeben
	{
	    $db->query('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'"');
		if ($db->num_rows()!=0) message(DATABASE_ERROR, 'Interner Datenbank/Handelssystemfehler');
	    $db->lock('bidding');
		$db->query('INSERT INTO bidding (trade_id,user,max_bid) VALUES ('.$tradedata['id'].','.$game->player['user_id'].',0)');
		$db->unlock('bidding');
		$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Dein Gebot wurde abgegeben<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>');
		return 1;

	}


	if ($min_bieten>0)
	{
	    if ($_REQUEST['max_bid']<0 || $_REQUEST['max_bid']>1000000) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Unerlaubter Wertebereich<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}
		if ($_REQUEST['max_bid']<$min_bieten) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Das Mindestgebot liegt bei '.$min_bieten.'<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}
		$prev_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" AND user="'.$game->player['user_id'].'"');
		if ($prev_bid['trade_id']!=0) // Der Spieler hat schonmal mitgeboten:
		{
	        // Wenn man sein Gebot akutalisieren will, darf folgendes NICHT auftreten:
			// Man hat das Einstiegsgebot abgegeben und will erhöhen, ohne dass jemand anderes geboten hat
			if ($tradedata['num_bids']==1) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Du hast das Einstiegsgebot abgegeben.<br>Erst wenn du berboten wurdest, kannst du erhöhen.<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}

			if ($_REQUEST['max_bid']<=$prev_bid['max_bid']) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Du hast bereits '.$prev_bid['max_bid'].' auf dieses Schiff geboten.<br>Du kannst dein Gebot erhöhen, nicht aber zurcknehmen.<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}
	    	$db->lock('bidding','FHB_bid_meldung');
	    $db->query('INSERT INTO FHB_bid_meldung (user_id , bieter , time , tick , trade_id ) VALUES ('.$prelast_bid['user'].','.$game->player['user_id'].',1,'.$ACTUAL_TICK.','.$tradedata['id'].')');	
			$db->query('UPDATE bidding SET max_bid="'.$_REQUEST['max_bid'].'" WHERE trade_id = "'.$tradedata['id'].'" AND user="'.$game->player['user_id'].'"');
			$db->unlock('bidding','FHB_bid_meldung');
			$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Dein Gebot wurde auf '.$_REQUEST['max_bid'].' aktualisiert<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>');
			return 1;
		}
		else
		{

		  $db->lock('bidding','FHB_bid_meldung');
		  	    $db->query('INSERT INTO FHB_bid_meldung (user_id , bieter , time , tick , trade_id ) VALUES ('.$prelast_bid['user'].','.$game->player['user_id'].',1,'.$ACTUAL_TICK.','.$tradedata['id'].')');
			$db->query('INSERT INTO bidding (trade_id,user,max_bid) VALUES ('.$tradedata['id'].','.$game->player['user_id'].','.$_REQUEST['max_bid'].')');
			$db->unlock('bidding','FHB_bid_meldung');
			$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Dein Gebot von '.$_REQUEST['max_bid'].' wurde abgegeben<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>');
		}
	}


}







function Cancel_Bid()
{
global $db;
global $game,$ACTUAL_TICK;


$_REQUEST['id']=(int)$_REQUEST['id'];
$_REQUEST['max_bid']=(int)$_REQUEST['max_bid'];

if ($_REQUEST['id']<0) return 0;


    $sql = 'SELECT s.*,u.user_name,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				WHERE s.id= "'.$_REQUEST['id'].'" GROUP BY s.id LIMIT 1
				';

    if(($tradedata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }

	// Will ein Spieler cheaten?
    if ($tradedata['user']!=$game->player['user_id']) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Du kannst nur deine eigenen Auktionen stornieren<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}
    if ($tradedata['num_bids']!=0) {$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Du kannst nur deine eigenen Auktionen stornieren,<br>wenn noch kein Gebot vorliegt<br><a href="'.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata['id']).'">Zurück zur Auktion</a></span></center></td></tr></table></center><br>'); return 0;}

	if ($db->query('UPDATE ships SET ship_untouchable=0 WHERE ship_id='.$tradedata['ship_id'])==true)
	$db->query('DELETE FROM ship_trade WHERE id="'.$tradedata['id'].'" AND user="'.$game->player['user_id'].'" LIMIT 1');
	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 class="style_inner"><tr><td width=450><center><span class="sub_caption">Deine Auktion wurde storniert<br><a href="'.parse_link('a=trade&view=view_own_bidding').'">Zurück zur Übersicht</a></span></center></td></tr></table></center><br>');
	return 1;
}


function Show_Bidding_Detail()
{
global $db;
global $game,$ACTUAL_TICK,$NEXT_TICK,$SHIPIMAGE_PATH,$SHIP_TORSO, $ship_components,$ship_ranks,$ship_rank_bonus;


$_REQUEST['id']=(int)$_REQUEST['id'];
if ($_REQUEST['id']<0) return 0;


    $sql = 'SELECT s.*,u.user_name,u.num_auctions,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				WHERE s.id= "'.$_REQUEST['id'].'" GROUP BY s.id LIMIT 1
				';

    if(($tradedata = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }

	$ship=$db->queryrow('SELECT s.*,t.*,u.user_race AS owner_race FROM (ships s)
							LEFT JOIN (ship_templates t) ON t.id=s.template_id
                        	LEFT JOIN (user u) ON u.user_id=t.owner
								WHERE s.ship_id="'.$tradedata['ship_id'].'" AND s.ship_untouchable=1 LIMIT 1');


	$game->out('<center><span class="sub_caption">Auktion einsehen '.HelpPopup(($own_only==true ? 'trade_viewownauctiondetail' : 'trade_viewauctiondetail')).' :</span></center><br>');

	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=570 class="style_outer">');
	$game->out('<tr><td width=570>
	<center><span class="sub_caption">'.$tradedata['header'].'</span><br><br>
	<center><span class="text_large">Verkäufer: <a href="'.parse_link('a=stats&a2=viewplayer&id='.$tradedata['user']).'"><span style="font-family:Arial,serif;font-size:11pt">'.$tradedata['user_name'].'</span></a> ('.$tradedata['num_auctions'].')</span><br><br>
	<table border=0 cellspacing=1 cellpadding=1 class="style_inner">
	<tr valign=top>
	<td width=400 align=left>
	<span class="sub_caption2">Beschreibung:</span><br>
	'.$tradedata['description'].'
	</td></tr></table><br>
	');
	// Schiffsdaten ausgeben:

	
	$rank_nr=1;
	if ($ship['experience']>=$ship_ranks[0]) $rank_nr=1;
	if ($ship['experience']>=$ship_ranks[1]) $rank_nr=2;
	if ($ship['experience']>=$ship_ranks[2]) $rank_nr=3;
	if ($ship['experience']>=$ship_ranks[3]) $rank_nr=4;
	if ($ship['experience']>=$ship_ranks[4]) $rank_nr=5;
	if ($ship['experience']>=$ship_ranks[5]) $rank_nr=6;
	if ($ship['experience']>=$ship_ranks[6]) $rank_nr=7;
	if ($ship['experience']>=$ship_ranks[7]) $rank_nr=8;
	if ($ship['experience']>=$ship_ranks[8]) $rank_nr=9;
	if ($ship['experience']>=$ship_ranks[9]) $rank_nr=10;


	if ($tradedata['show_data']==0)
	{
	$game->out('<table border=0 cellspacing=1 cellpadding=1 class="style_inner">
	<tr valign=top>
	<td width=400 align=left>
	<span class="sub_caption2">Schiffsdaten:</span><br>
	<u>Schiffsname:</u>&nbsp;'.$ship['name'].'<br>
	<u>Rumpf:</u>&nbsp;'.($ship['ship_torso']+1).'<br>
       <u>Hüllenzustand:</u>&nbsp;'.(100/$ship['value_5']*$ship['hitpoints']).'%<br>
	<u>Besatzung:</u>&nbsp;'.round(100/($ship['max_unit_1']+$ship['max_unit_2']+$ship['max_unit_3']+$ship['max_unit_4']+$ship['unit_5']+$ship['unit_6'])*($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4']+$ship['unit_5']+$ship['unit_6']) ).'%<br>
	<i>* Der Verkäufer lässt keine weiteren Informationen zu</i>
	</td></tr></table>');
	}
	else
	if ($tradedata['show_data']==1)
	{
	$game->out('<table border=0 cellspacing=1 cellpadding=1 class="style_inner">
	<tr valign=top>
	<td width=400 align=left>
	<span class="sub_caption2">Schiffsdaten:</span><br>

    	<table border=0 cellspacing=1 cellpadding=1>
    	<tr>
	<td width=150 align=left>
	<img src='.FIXED_GFX_PATH.'ship'.$ship['race'].'_'.$ship['ship_torso'].'.jpg>
	</td>
	<td width=10></td>
	<td width=240 align=left valign=top>
	<b><u>Schiffsname:</u>&nbsp;'.$ship['name'].'<br></b>
       <b><u>Rumpf:</u>&nbsp;'.($ship['ship_torso']+1).'</b><br>
	<b><u>Schiffsklasse:</u>&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$ship['race']][$ship['ship_torso']]).'\', CAPTION, \''.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'</a><br>
	<u>Besatzung:</u>&nbsp;'.round(100/($ship['max_unit_1']+$ship['max_unit_2']+$ship['max_unit_3']+$ship['max_unit_4']+$ship['unit_5']+$ship['unit_6'])*($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4']+$ship['unit_5']+$ship['unit_6']) ).'%<br>
	<u>Hüllenzustand:</u>&nbsp;'.$ship['hitpoints'].'/'.$ship['value_5'].'<br>
	<u>L. Waffen:</u> '.$ship['value_1'].' + <span style="color: yellow">'.round($ship['value_1']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Schw. Waffen:</u> '.$ship['value_2'].' + <span style="color: yellow">'.round($ship['value_2']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Pl. Waffen:</u> '.$ship['value_3'].' + <span style="color: yellow">'.round($ship['value_3']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Schildstärke:</u> '.$ship['value_4'].'<br>
	<u>Reaktion:</u> '.$ship['value_6'].' + <span style="color: yellow">'.round($ship['value_6']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Bereitschaft:</u> '.$ship['value_7'].' + <span style="color: yellow">'.round($ship['value_7']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Wendigkeit:</u> '.$ship['value_8'].' + <span style="color: yellow">'.round($ship['value_8']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Erfahrung:</u> <span style="color: yellow">'.$ship['experience'].'</span></b> <img src="'.$game->GFX_PATH.'rank_'.$rank_nr.'.jpg" width="47" height="12"><br>
	<u>Warp:</u> '.$ship['value_10'].'<br>
	<u>Sensoren:</u> '.$ship['value_11'].'<br>
	<u>Tarnung:</u> '.$ship['value_12'].'<br>
	<u>Verbraucht Energie:</u> '.$ship['value_14'].'<br>
	<u>Liefert Energie:</u> '.$ship['value_13'].'<br>
	</td>
	</tr></table>

	</td></tr></table>');
	}
	else
	if ($tradedata['show_data']==2)
	{
	$game->out('<table border=0 cellspacing=1 cellpadding=1 class="style_inner">
	<tr valign=top>
	<td width=400 align=left>
	<span class="sub_caption2">Schiffsdaten:</span><br>

	    <table border=0 cellspacing=1 cellpadding=1>
    	<tr>
	<td width=195 align=left valign=top>
	<b><u>Schiffsname:</u>&nbsp;'.$ship['name'].'<br></b>
       <b><u>Rumpf:</u>&nbsp;'.($ship['ship_torso']+1).'</b><br>
	<b><u>Schiffsklasse:</u>&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$ship['race']][$ship['ship_torso']]).'\', CAPTION, \''.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'</a><br>
	<u>Hüllenzustand:</u>&nbsp;'.$ship['value_5'].'/'.$ship['hitpoints'].'<br>
	<u>L. Waffen:</u> '.$ship['value_1'].' + <span style="color: yellow">'.round($ship['value_1']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Schw. Waffen:</u> '.$ship['value_2'].' + <span style="color: yellow">'.round($ship['value_2']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Pl. Waffen:</u> '.$ship['value_3'].' + <span style="color: yellow">'.round($ship['value_3']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Schildstärke:</u> '.$ship['value_4'].'<br>
	<u>Reaktion:</u> '.$ship['value_6'].' + <span style="color: yellow">'.round($ship['value_6']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Bereitschaft:</u> '.$ship['value_7'].' + <span style="color: yellow">'.round($ship['value_7']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Wendigkeit:</u> '.$ship['value_8'].' + <span style="color: yellow">'.round($ship['value_8']*$ship_rank_bonus[$rank_nr-1],0).'</span><br>
	<u>Erfahrung:</u> <span style="color: yellow">'.$ship['experience'].'</span></b> <img src="'.$game->GFX_PATH.'rank_'.$rank_nr.'.jpg" width="47" height="12"><br>
	<u>Warp:</u> '.$ship['value_10'].'<br>
	<u>Sensoren:</u> '.$ship['value_11'].'<br>
	<u>Tarnung:</u> '.$ship['value_12'].'<br>
	<u>Verbraucht Energie:</u> '.$ship['value_14'].'<br>
	<u>Liefert Energie:</u> '.$ship['value_13'].'<br>
	</td>
	<td width=10></td>
	<td width=195 align=left valign=top><b><u>Komponenten:</b></u><br>');

    for ($t=0; $t<10; $t++)
	{
	if ($ship['component_'.($t+1)]>=0)
	{
	$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateCompInfoText($ship_components[$game->player['race']][$t][$ship['component_'.($t+1)]]).'\', CAPTION, \''.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'</a><br>');
	} else $game->out('- Nicht belegt<br>');
    }


	$game->out('<br>
    	<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.$ship['unit_1'].'/'.$ship['max_unit_1'].'<br>
    	<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.$ship['unit_2'].'/'.$ship['max_unit_2'].'<br>
    	<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.$ship['unit_3'].'/'.$ship['max_unit_3'].'<br>
    	<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.$ship['unit_4'].'/'.$ship['max_unit_4'].'<br>
    	<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.$ship['unit_5'].'<br>
    	<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.$ship['unit_6'].'
	</td>
	</tr></table>
    	<center><img src='.FIXED_GFX_PATH.'ship'.$ship['race'].'_'.$ship['ship_torso'].'.jpg></center>

	</td></tr></table>');
	}

	// Die Preis + Bieten Übersicht:
	$min_bieten=-1;     // -1 means that there was NO bid yet
    	if ($tradedata['num_bids']==1) $min_bieten=1;

    	if ($tradedata['num_bids']<2)
	{
	    $min_resources[0]=$tradedata['resource_1'];
	    $min_resources[1]=$tradedata['resource_2'];
	    $min_resources[2]=$tradedata['resource_3'];
	   	$min_resources[3]=$tradedata['unit_1'];
	    $min_resources[4]=$tradedata['unit_2'];
	    $min_resources[5]=$tradedata['unit_3'];
     	$min_resources[6]=$tradedata['unit_4'];
	    $min_resources[7]=$tradedata['unit_5'];
	    $min_resources[8]=$tradedata['unit_6'];
	    $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($tradedata['resource_1'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format($tradedata['resource_2'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format($tradedata['resource_3'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format($tradedata['unit_1'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format($tradedata['unit_2'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format($tradedata['unit_3'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format($tradedata['unit_4'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format($tradedata['unit_5'], 0, '.', '.');
	    $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format($tradedata['unit_6'], 0, '.', '.');
        if ($tradedata['num_bids']!=0)
	{
	    $min_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+$tradedata['add_resource_1']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+$tradedata['add_resource_2']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+$tradedata['add_resource_3']), 0, '.', '.');
	    $min_resources[0]=$tradedata['resource_1']+$tradedata['add_resource_1'];
	    $min_resources[1]=$tradedata['resource_2']+$tradedata['add_resource_2'];
	    $min_resources[2]=$tradedata['resource_3']+$tradedata['add_resource_3'];
	    $min_resources[3]=$tradedata['unit_1']+$tradedata['add_unit_1'];
	    $min_resources[4]=$tradedata['unit_2']+$tradedata['add_unit_2'];
	    $min_resources[5]=$tradedata['unit_3']+$tradedata['add_unit_3'];
	    $min_resources[6]=$tradedata['unit_4']+$tradedata['add_unit_4'];
	    $min_resources[7]=$tradedata['unit_5']+$tradedata['add_unit_5'];
	    $min_resources[8]=$tradedata['unit_6']+$tradedata['add_unit_6'];
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+$tradedata['add_unit_1']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+$tradedata['add_unit_2']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+$tradedata['add_unit_3']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+$tradedata['add_unit_4']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+$tradedata['add_unit_5']), 0, '.', '.');
	    $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+$tradedata['add_unit_6']), 0, '.', '.');
		}
		else $min_price=$actual_price;
	}
	else
	{
        $prelast_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid DESC LIMIT 1,1');
		// Um zu testen, ob ein Gleichstand besteht, dann wird ja nicht max_bid +1
		$last_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid DESC LIMIT 1');
		if ($last_bid['max_bid']!=$prelast_bid['max_bid'])
		{

			$min_bieten=$prelast_bid['max_bid']+1+1; // +1 fr aktuelles gebot, nochmal +1 für das nächste

		    $min_resources[0]=($tradedata['resource_1']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_1']);
		    $min_resources[1]=($tradedata['resource_2']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_2']);
	    	$min_resources[2]=($tradedata['resource_3']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_3']);
	    	$min_resources[3]=($tradedata['unit_1']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_1']);
		    $min_resources[4]=($tradedata['unit_2']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_2']);
	    	$min_resources[5]=($tradedata['unit_3']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_3']);
	    	$min_resources[6]=($tradedata['unit_4']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_4']);
		    $min_resources[7]=($tradedata['unit_5']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_5']);
	    	$min_resources[8]=($tradedata['unit_6']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_6']);

		    $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']), 0, '.', '.');
		    $min_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_1']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_2']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid']+2)*$tradedata['add_resource_3']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_1']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_2']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_3']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_4']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_5']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid']+2)*$tradedata['add_unit_6']), 0, '.', '.');
		}
		else
		{
			$min_bieten=$prelast_bid['max_bid']+1; // +1 fr das nächste gebot, weil ja "gleichstand" war

		    $min_resources[0]=($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']);
		    $min_resources[1]=($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']);
	    	$min_resources[2]=($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']);
	    		    	$min_resources[3]=($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']);
		    $min_resources[4]=($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']);
	    	$min_resources[5]=($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']);
	    	$min_resources[6]=($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']);
		    $min_resources[7]=($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']);
	    	$min_resources[8]=($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']);

		    $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid'])*$tradedata['add_resource_1']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid'])*$tradedata['add_resource_2']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid'])*$tradedata['add_resource_3']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid'])*$tradedata['add_unit_1']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid'])*$tradedata['add_unit_2']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid'])*$tradedata['add_unit_3']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid'])*$tradedata['add_unit_4']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid'])*$tradedata['add_unit_5']), 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid'])*$tradedata['add_unit_6']), 0, '.', '.');
	    $min_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']), 0, '.', '.');
            $min_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']), 0, '.', '.');
		}

	}






	// Wenn die Auktion noch läuft:
	if ((60*TICK_DURATION*($tradedata['end_time']-$ACTUAL_TICK))+$NEXT_TICK>0)
	{
    $game->set_autorefresh((60*TICK_DURATION*($tradedata['end_time']-$ACTUAL_TICK))+$NEXT_TICK);
    $game->out('<br><table border=0 cellspacing=1 cellpadding=1 class="style_inner">
    <tr><td width=400 align=left>
	<span class="sub_caption2">Auktionsstatus:</span><br>
	Restlaufzeit: <b id="timer3" title="time1_'.(60*TICK_DURATION*($tradedata['end_time']-$ACTUAL_TICK)+$NEXT_TICK).'_type1_1">&nsbp;</b><br>
	Startpreis:&nbsp;<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($tradedata['resource_1'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format($tradedata['resource_2'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format($tradedata['resource_3'], 0, '.', '.').'&nbsp;' .
	'&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format($tradedata['unit_1'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format($tradedata['unit_2'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format($tradedata['unit_3'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format($tradedata['unit_4'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format($tradedata['unit_5'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format($tradedata['unit_6'], 0, '.', '.').'
	<br>Erhöhungsschritt:&nbsp;<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($tradedata['add_resource_1'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format($tradedata['add_resource_2'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format($tradedata['add_resource_3'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format($tradedata['add_unit_1'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format($tradedata['add_unit_2'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format($tradedata['add_unit_3'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format($tradedata['add_unit_4'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format($tradedata['add_unit_5'], 0, '.', '.').'&nbsp;
	&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format($tradedata['add_unit_6'], 0, '.', '.').'&nbsp;
	<br><br>
	Anzahl Gebote:&nbsp;'.$tradedata['num_bids'].'<br>');
	if ($min_bieten==-1)
	{
	// Verkäufer??
	if ($tradedata['user']==$game->player['user_id'])
	$game->out('Aktuelles Gebot:&nbsp;<i>Keine Gebote</i><br>
	Höchstbietender: -<br>
	Minimales Gebot:&nbsp;<i>Einstiegsgebot</i> ('.$min_price.')<br>

    	<form method="post" action="'.parse_link('a=trade&view=cancel_bid&id='.$_REQUEST['id']).'">
	<input type="submit" name="stornieren" class="Button_nosize" value="Stornieren" width=150 onClick="return confirm(\'Willst du diese Auktion wirklich stornieren?\')">
	</form>
	<i>* Da du der Verkäufer bist, kannst du die Auktion stornieren, solange noch kein Gebot abgegeben wurde.</i>
	');
	else
	$game->out('Aktuelles Gebot:&nbsp;<i>Keine Gebote</i><br>
	Höchstbietender: -<br>
	Minimales Gebot:&nbsp;<i>Einstiegsgebot</i> ('.$min_price.')<br>

    	<form method="post" action="'.parse_link('a=trade&view=submit_bid&do_bid=1&id='.$_REQUEST['id']).'">
	<input type="submit" name="bid_form" class="Button_nosize" value="Mitbieten" width=150 onClick="return confirm(\'Willst du wirklich das 1. Gebot fr dieses Schiff abgeben?\')">
	</form>
	<i>* Da du das 1. Gebot abgibst, bietest du auf ('.$min_price.')</i>');
	}
	else
	{
 	$player_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" AND user="'.$game->player['user_id'].'"');
	if (!empty($player_bid['trade_id']))
	{
	    if ($player_bid['max_bid']>0)
	    $own_bid= '<br><b>Du hast bei dieser Auktion bis '.$player_bid['max_bid'].' (';
		else $own_bid= '<br><b>Du hast bei dieser Auktion das Startgebot abgegeben (';
	    $own_bid.='<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($player_bid['max_bid'])*$tradedata['add_resource_1']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($player_bid['max_bid'])*$tradedata['add_resource_2']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($player_bid['max_bid'])*$tradedata['add_resource_3']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($player_bid['max_bid'])*$tradedata['add_unit_1']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($player_bid['max_bid'])*$tradedata['add_unit_2']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($player_bid['max_bid'])*$tradedata['add_unit_3']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($player_bid['max_bid'])*$tradedata['add_unit_4']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($player_bid['max_bid'])*$tradedata['add_unit_5']), 0, '.', '.');
	    $own_bid.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($player_bid['max_bid'])*$tradedata['add_unit_6']), 0, '.', '.');
	    if ($player_bid['max_bid']>0)
		$own_bid.=') geboten.</b><br><br>';
		else
		$own_bid.=').</b><br><br>';
	}


	$hbieter=$db->queryrow('SELECT b.*,u.user_id,u.user_name FROM (bidding b) LEFT JOIN (user u) ON u.user_id=b.user WHERE b.trade_id = "'.$tradedata['id'].'" ORDER BY b.max_bid DESC LIMIT 1');
	$game->out($own_bid.'Aktuelles Gebot:&nbsp;'.(($min_bieten-1)==0 ? 'Einstiegsgebot' : ($min_bieten-1)).' ('.$actual_price.')<br>
    Höchstbietender: <a href="'.parse_link('a=stats&a2=viewplayer&id='.$hbieter['user_id']).'">'.$hbieter['user_name'].'</a><br>
	Minimales Gebot:&nbsp;'.$min_bieten.' ('.$min_price.')<br>

	<script language="JavaScript">
	function UpdateValues()
	{
	    var maxbid=document.maxbidform.max_bid.value;
	    document.getElementById( "res_1" ).firstChild.nodeValue = maxbid*('.$tradedata['add_resource_1'].')+'.$tradedata['resource_1'].';
	    document.getElementById( "res_2" ).firstChild.nodeValue = maxbid*('.$tradedata['add_resource_2'].')+'.$tradedata['resource_2'].';
	    document.getElementById( "res_3" ).firstChild.nodeValue = maxbid*('.$tradedata['add_resource_3'].')+'.$tradedata['resource_3'].';
	    document.getElementById( "res_4" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_1'].')+'.$tradedata['unit_1'].';
	    document.getElementById( "res_5" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_2'].')+'.$tradedata['unit_2'].';
	    document.getElementById( "res_6" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_3'].')+'.$tradedata['unit_3'].';
	    document.getElementById( "res_7" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_4'].')+'.$tradedata['unit_4'].';
	    document.getElementById( "res_8" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_5'].')+'.$tradedata['unit_5'].';
	    document.getElementById( "res_9" ).firstChild.nodeValue = maxbid*('.$tradedata['add_unit_6'].')+'.$tradedata['unit_6'].';
	    window.setTimeout( \'UpdateValues()\', 500 );

	}
	</script>');
   	// Verkäufer??
	if ($tradedata['user']==$game->player['user_id'])
	{
	// Wenn Verkäufer, dann eine Gebotsliste zeigen:
	$liste=$db->query('SELECT b.*,u.user_id,u.user_name FROM (bidding b) LEFT JOIN (user u) ON u.user_id=b.user WHERE b.trade_id = "'.$tradedata['id'].'" ORDER BY b.max_bid DESC');
	$game->out('<br><i>Du bist Verkäufer dieses Schiffes.</i><br><br><u>Folgende Spieler haben geboten:</u><br>
	<table border=0 cellpadding=1 cellspacing=1><tr><td width=100></td><td width=150></td></tr>');

    $nr=0;
	while (($item=$db->fetchrow($liste))==true)
	{
    $game->out('<tr><td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$item['user_id']).'">'.$item['user_name'].'</a></td><td>');

	if ($nr>0)
    {
    if ($item['max_bid']>0)
    $bid_txt= $item['max_bid'].' (';
	else $own_bid= 'Startgebot (';
    $bid_txt.='<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($item['max_bid'])*$tradedata['add_resource_1']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($item['max_bid'])*$tradedata['add_resource_2']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($item['max_bid'])*$tradedata['add_resource_3']), 0, '.', '.');
	$bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($item['max_bid'])*$tradedata['add_unit_1']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($item['max_bid'])*$tradedata['add_unit_2']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($item['max_bid'])*$tradedata['add_unit_3']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($item['max_bid'])*$tradedata['add_unit_4']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($item['max_bid'])*$tradedata['add_unit_5']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($item['max_bid'])*$tradedata['add_unit_6']), 0, '.', '.');
 	$bid_txt.=')</td></tr>';
    }
    else
    {
   if ($item['max_bid']>0)
    $bid_txt= ($prelast_bid['max_bid']+1).' (';
	else $own_bid= 'Startgebot (';
    $bid_txt.='<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']), 0, '.', '.');
    $bid_txt.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']), 0, '.', '.');
 	$bid_txt.=')</td></tr>';
    }
    $game->out($bid_txt);


    $nr++;
    }
    $game->out('</table>');

	}
	else
    $game->out('<form method="post" action="'.parse_link('a=trade&view=submit_bid&do_bid=1&id='.$_REQUEST['id']).'" name="maxbidform">
	Mitbieten bis:&nbsp;<input type="text" name="max_bid" value="'.$min_bieten.'" class="Field_nosize" size="5" maxlength="6" style="width: 75px;" onFocus="UpdateValues();">&nbsp;(<img src="'.$game->GFX_PATH.'menu_metal_small.gif"><b id="res_1">'.number_format($min_resources[0], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif"><b id="res_2">'.number_format($min_resources[1], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif"><b id="res_3">'.number_format($min_resources[2], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif"><b id="res_4">'.number_format($min_resources[3], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif"><b id="res_5">'.number_format($min_resources[4], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif"><b id="res_6">'.number_format($min_resources[5], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif"><b id="res_7">'.number_format($min_resources[6], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif"><b id="res_8">'.number_format($min_resources[7], 0, '.', '.').'</b>&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif"><b id="res_9">'.number_format($min_resources[8], 0, '.', '.').'</b>)<br>
	<input type="submit" name="register" class="Button_nosize" value="Mitbieten" width=150 onClick="return confirm(\'Willst du wirklich auf dieses Schiff bieten?\')">
	</form>
	');
	}

	} /// Wenn das Gebot schon abgelaufen ist:
	else
	{
   $game->out('<br><table border=0 cellspacing=1 cellpadding=1 class="style_inner">
    <td width=400 align=left>
	<span class="sub_caption2">Auktionsstatus:</span><br>
	<b>Diese Auktion ist vor '.Zeit((-1)*(TICK_DURATION*($tradedata['end_time']-$ACTUAL_TICK))).' abgelaufen.<br>');
	if ($tradedata['num_bids']<1) {$game->out('Es wurden keine Gebote abgegeben.');}
	else
	{
	$hbieter=$db->queryrow('SELECT b.*,u.user_id,u.user_name FROM (bidding b) LEFT JOIN (user u) ON u.user_id=b.user WHERE b.trade_id = "'.$tradedata['id'].'" ORDER BY b.max_bid DESC LIMIT 1');
    $game->out('<u>Gewinner der Auktion ist:</u></span> <a href="'.parse_link('a=stats&a2=viewplayer&id='.$hbieter['user_id']).'"><b>'.$hbieter['user_name'].'</a><br>');

        if ($tradedata['num_bids']<2)
		{
            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($tradedata['resource_1'], 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format($tradedata['resource_2'], 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format($tradedata['resource_3'], 0, '.', '.');
            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format($tradedata['unit_1'], 0, '.', '.');
	        $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format($tradedata['unit_2'], 0, '.', '.');
	        $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format($tradedata['unit_3'], 0, '.', '.');
	        $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format($tradedata['unit_4'], 0, '.', '.');
	        $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format($tradedata['unit_5'], 0, '.', '.');
	        $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format($tradedata['unit_6'], 0, '.', '.');
		}
		else
		{
            $prelast_bid=$db->queryrow('SELECT * FROM bidding  WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid DESC LIMIT 1,1');
			// Um zu testen, ob ein Gleichstand besteht, dann wird ja nicht max_bid +1
			$last_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata['id'].'" ORDER BY max_bid DESC LIMIT 1');
			if ($last_bid['max_bid']!=$prelast_bid['max_bid'])
			{
	            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_1']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_2']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid']+1)*$tradedata['add_resource_3']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_1']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_2']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_3']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_4']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_5']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid']+1)*$tradedata['add_unit_6']), 0, '.', '.');
			}
			else
			{
	            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata['resource_1']+($prelast_bid['max_bid'])*$tradedata['add_resource_1']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata['resource_2']+($prelast_bid['max_bid'])*$tradedata['add_resource_2']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata['resource_3']+($prelast_bid['max_bid'])*$tradedata['add_resource_3']), 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata['unit_1']+($prelast_bid['max_bid'])*$tradedata['add_unit_1']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata['unit_2']+($prelast_bid['max_bid'])*$tradedata['add_unit_2']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata['unit_3']+($prelast_bid['max_bid'])*$tradedata['add_unit_3']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata['unit_4']+($prelast_bid['max_bid'])*$tradedata['add_unit_4']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata['unit_5']+($prelast_bid['max_bid'])*$tradedata['add_unit_5']), 0, '.', '.');
              	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata['unit_6']+($prelast_bid['max_bid'])*$tradedata['add_unit_6']), 0, '.', '.');
			}
		}



    	$game->out('<u>Endpreis:</u>&nbsp;'.$actual_price.'</span><br>');
		if ($tradedata['user']==$game->player['user_id'] || $hbieter['user_id']==$game->player['user_id'])
		{
	        $game->out('<br><i>* Weiteres Vorgehen entnehme bitte deinem Logbuch Eintrag</i>');
		}

 	} // Es wurden Gebote abgegeben

	} // End of: wenn die Auktion vorbei ist

	$game->out('</td></tr>');

	$game->out('</table></td></tr></table>');

}







function Show_Bidding($own_only=0)
{
global $db;
global $game,$ACTUAL_TICK,$NEXT_TICK;

$per_page=20;


if (isset($_GET['trigger']) && $_GET['trigger']==1) $game->option_store('type_0',(int)(1-$game->option_retr('type_0',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==2) $game->option_store('type_1',(int)(1-$game->option_retr('type_1',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==3) $game->option_store('type_2',(int)(1-$game->option_retr('type_2',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==4) $game->option_store('type_3',(int)(1-$game->option_retr('type_3',1)));


$_POST['type_0']=$game->option_retr('type_0',1);
$_POST['type_1']=$game->option_retr('type_1',1);
$_POST['type_2']=$game->option_retr('type_2',1);
$_POST['type_3']=$game->option_retr('type_3',1);

if ($_POST['type_0']) $sels[]=0;
if ($_POST['type_1']) $sels[]=1;
if ($_POST['type_2']) $sels[]=2;
if ($_POST['type_3']) $sels[]=3;
if (empty($sels)) $sels[]=4;

$game->out('
<script language="JavaScript">
function ConfirmClick(text,link)
{
	if (confirm(text)==true)
	{
    location.href=link;
	}
}
</script>');

if ($own_only==0) $str_compare='<>';
else {$str_compare='=';}

    $own_system = $db->queryrow('SELECT system_global_x, system_global_y FROM starsystems WHERE system_id = '.$game->planet['planet_system']);

if($own_only==0){    $sql = 'SELECT s.*,u.user_name,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				LEFT JOIN (ships sh) ON sh.ship_id=s.ship_id
				LEFT JOIN (ship_templates t) ON t.id=sh.template_id
				WHERE s.user '.$str_compare.' '.$game->player['user_id'].' AND s.start_time<='.$ACTUAL_TICK.' AND s.end_time>='.$ACTUAL_TICK.' AND t.ship_class IN ('.implode(',', $sels).') GROUP BY s.id ORDER BY s.end_time ASC
				';}else{
$sql = 'SELECT s.*,u.user_name,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				LEFT JOIN (ships sh) ON sh.ship_id=s.ship_id
				LEFT JOIN (ship_templates t) ON t.id=sh.template_id
				WHERE s.user '.$str_compare.' '.$game->player['user_id'].' AND s.end_time>='.$ACTUAL_TICK.' AND t.ship_class IN ('.implode(',', $sels).') GROUP BY s.id ORDER BY s.end_time ASC
				';
}

    if(($tradedata = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }
    $nr = 0;


	$str_firstfield='Entfernung';
	if ($own_only) $str_firstfield='Anzahl';
	$str_lastfield='Verkäufer';
	if ($own_only) $str_lastfield='Optionen';

	$str_own='';
	if ($own_only) $str_own='Eigene ';

	$game->out('<center><span class="sub_caption">'.$str_own.'Auktionen einsehen '.HelpPopup(($own_only==true ? 'trade_viewownauction' : 'trade_viewauction')).' :</span></center><br>');
	// Men << >>
	$game->out('<br><center><table boder=0 cellpadding=2 cellspacing=2 class="style_inner" width=300><tr>
		<td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']-1)).'"><< Zurück</a>
		</td><td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']+1)).'">Vorwärts >></a>
		</td></tr></table><br>');

		
		
		
		$game->out('<center>
	<table border=0 cellpadding=1 cellspacing=1 class="style_outer"><tr><td>
	<span class="sub_caption2">Folgende Schiffsklassen zeigen :</span><br>
	<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width=300>
	<tr>
	<td width=150 valign=top>
	<form name="type0form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=1&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_0" value="1"'.(($_POST['type_0']==1) ? ' checked="checked"' : '' ).'  onChange="document.type0form.submit()">Zivile Schiffe / Scout</form>
	</td><td width=150 valign=top>
	<form name="type1form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=2&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_1" value="1"'.(($_POST['type_1']==1) ? ' checked="checked"' : '' ).'  onChange="document.type1form.submit()">Leichte Schiffe</form>
	</td></tr><td>
	<form name="type2form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=3&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_2" value="1"'.(($_POST['type_2']==1) ? ' checked="checked"' : '' ).'  onChange="document.type2form.submit()">Mittlere Schiffe</form>
	</td><td>
	<form name="type3form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=4&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_3" value="1"'.(($_POST['type_3']==1) ? ' checked="checked"' : '' ).'  onChange="document.type3form.submit()">Schwere Schiffe</form>
        </td>
	</tr></table>
	</td>
	</tr></table>
	</center><br>');

		
		
	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=530 class="style_outer">');
	
	
	if (!isset($_REQUEST['page']) || $_REQUEST['page']<0) $_REQUEST['page']=0;

	$game->out('<tr><td width=530>
	<span class="sub_caption2">Auktionen (Seite '.($_REQUEST['page']+1).' von ~'.round(count($tradedata)/$per_page+1).')</span>');



    $game->out('<table border=0 cellpadding=4 cellspacing=0 width=530 class="style_inner">
	<tr><td width=235><b>Artikel:</u></td><td width=200><b>Preis:</u></td><td width=25><b>#:</b></td><td width=70><b>Restzeit:</b></td>');


	for ($t=$_REQUEST['page']*$per_page; $t<$_REQUEST['page']*$per_page+$per_page; $t++)
	{
	if (isset($tradedata[$t]))
		{
	        if ($tradedata[$t]['num_bids']<2)
			{
	            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($tradedata[$t]['resource_1'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format($tradedata[$t]['resource_2'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format($tradedata[$t]['resource_3'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_1'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_2'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_3'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_4'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_5'], 0, '.', '.');
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format($tradedata[$t]['unit_6'], 0, '.', '.');
			}
			else
			{
	            $prelast_bid=$db->queryrow('SELECT * FROM bidding  WHERE trade_id = "'.$tradedata[$t]['id'].'" ORDER BY max_bid DESC LIMIT 1,1');
				// Um zu testen, ob ein Gleichstand besteht, dann wird ja nicht max_bid +1
				$last_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata[$t]['id'].'" ORDER BY max_bid DESC LIMIT 1');
				if ($last_bid['max_bid']!=$prelast_bid['max_bid'])
				{
		            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_1']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_1']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_2']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_2']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_3']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_3']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_1']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_1']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_2']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_2']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_3']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_3']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_4']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_4']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_5']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_5']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_6']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_6']), 0, '.', '.');
				}
				else
				{
		            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_1']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_1']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_2']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_2']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.number_format(($tradedata[$t]['resource_3']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_3']), 0, '.', '.');
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_1']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_1']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_2']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_2']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_3']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_3']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_4']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_4']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_5']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_5']), 0, '.', '.');
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.number_format(($tradedata[$t]['unit_6']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_6']), 0, '.', '.');
				}
			}
			$font_color='#ffffff';
			$font_bold='';
			if ($tradedata[$t]['font_bold']) $font_bold='<b>';
			if ($tradedata[$t]['font_colored']) $font_color='#ffaaaa';

			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" onClick="location.href=\''.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata[$t]['id']).'\'"  color:'.$font_color.';">
				<td>'.$font_bold.'<font color="'.$font_color.'">'.$tradedata[$t]['header'].'</font></b></td><td>'.$font_bold.$actual_price.'</b></td><td>'.$font_bold.$tradedata[$t]['num_bids'].'</b></td><td>'.$font_bold.Zeit(TICK_DURATION*($tradedata[$t]['end_time']-$ACTUAL_TICK)+round($NEXT_TICK/60,0)).'</b></td></tr>');
	    }

	}


	$game->out('</table></td></tr></table>');
	// Men << >>
	$game->out('<br><center><table boder=0 cellpadding=2 cellspacing=2 class="style_inner" width=300><tr>
		<td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']-1)).'"><< Zurück</a>
		</td><td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']+1)).'">Vorwärts >></a>
		</td></tr></table>');

}







function Show_CreateBidding()
{
global $db;
global $game,$UNIT_NAME,$ACTUAL_TICK;
$text='';

$db->lock('ships','ship_templates','ship_trade');
$game->init_player();
// Get all ships:
$shipqry=$db->query('SELECT ships.*,ship_templates.ship_torso,ship_templates.name,ship_templates.value_5 FROM ships LEFT JOIN ship_templates ON ship_templates.id=ships.template_id WHERE ships.fleet_id="-'.$game->planet['planet_id'].'" AND ships.ship_untouchable=0 ORDER BY ships.template_id ASC, ships.hitpoints, ships.experience DESC');

$shiplist=array();
$actual_class=-1;
$actual_hp=-1;
$actual_exp=-1;
$num=-1;
while (($ship=$db->fetchrow($shipqry))==true)
{
	if ($ship['template_id']!=$actual_class || $ship['hitpoints']!=$actual_hp || $ship['experience']!=$actual_exp)
	{
	$num++;
    	$actual_class=$ship['template_id'];
    	$actual_hp=$ship['hitpoints'];
	$actual_exp=$ship['experience'];
	$shiplist[$num]=$ship;
    	$shiplist[$num]['ship_count']=1;
	}
	else
	{
    	$shiplist[$num]['ship_count']++;
	}
};

$optionfield='';
for ($t=0; $t<count($shiplist); $t++)
{
$optionfield.='<option value="'.$shiplist[$t]['ship_id'].'" '.( ($_REQUEST['ships']==$shiplist[$t]['ship_id']) ? 'selected':'').'>'.$shiplist[$t]['name'].' HP: '.$shiplist[$t]['hitpoints'].'/'.$shiplist[$t]['value_5'].' EXP: '.$shiplist[$t]['experience'].' ('.$shiplist[$t]['ship_count'].'x)</option>';
}









if (isset($_REQUEST['submit_bidding']))
{
if(!($_REQUEST['base_resource_1']==0 && $_REQUEST['base_resource_2']==0 && $_REQUEST['base_resource_3']==0 && $_REQUEST['base_unit_1']==0 && $_REQUEST['base_unit_2']==0 && $_REQUEST['base_unit_3']==0 && $_REQUEST['base_unit_4']==0 && $_REQUEST['base_unit_5']==0 && $_REQUEST['base_unit_6']==0 && $_REQUEST['add_resource_1']==0 && $_REQUEST['add_resource_2']==0 && $_REQUEST['add_resource_3']==0 && $_REQUEST['add_unit_1']==0 && $_REQUEST['add_unit_2']==0 && $_REQUEST['add_unit_3']==0 && $_REQUEST['add_unit_4']==0 && $_REQUEST['add_unit_5']==0 && $_REQUEST['add_unit_6']==0)){
$_REQUEST['base_resource_1']=(int)$_REQUEST['base_resource_1'];
$_REQUEST['base_resource_2']=(int)$_REQUEST['base_resource_2'];
$_REQUEST['base_resource_3']=(int)$_REQUEST['base_resource_3'];
$_REQUEST['base_unit_1']=(int)$_REQUEST['base_unit_1'];
$_REQUEST['base_unit_2']=(int)$_REQUEST['base_unit_2'];
$_REQUEST['base_unit_3']=(int)$_REQUEST['base_unit_3'];
$_REQUEST['base_unit_4']=(int)$_REQUEST['base_unit_4'];
$_REQUEST['base_unit_5']=(int)$_REQUEST['base_unit_5'];
$_REQUEST['base_unit_6']=(int)$_REQUEST['base_unit_6'];
$_REQUEST['add_resource_1']=(int)$_REQUEST['add_resource_1'];
$_REQUEST['add_resource_2']=(int)$_REQUEST['add_resource_2'];
$_REQUEST['add_resource_3']=(int)$_REQUEST['add_resource_3'];
$_REQUEST['add_unit_1']=(int)$_REQUEST['add_unit_1'];
$_REQUEST['add_unit_2']=(int)$_REQUEST['add_unit_2'];
$_REQUEST['add_unit_3']=(int)$_REQUEST['add_unit_3'];
$_REQUEST['add_unit_4']=(int)$_REQUEST['add_unit_4'];
$_REQUEST['add_unit_5']=(int)$_REQUEST['add_unit_5'];
$_REQUEST['add_unit_6']=(int)$_REQUEST['add_unit_6'];

if($_REQUEST['base_resource_1']==null || $_REQUEST['base_resource_1']<0) $_REQUEST['base_resource_1']=0;
if($_REQUEST['base_resource_2']==null || $_REQUEST['base_resource_2']<0) $_REQUEST['base_resource_2']=0;
if($_REQUEST['base_resource_3']==null || $_REQUEST['base_resource_3']<0) $_REQUEST['base_resource_3']=0;
if($_REQUEST['base_unit_1']==null || $_REQUEST['base_unit_1']<0) $_REQUEST['base_unit_1']=0;
if($_REQUEST['base_unit_2']==null || $_REQUEST['base_unit_2']<0) $_REQUEST['base_unit_2']=0;
if($_REQUEST['base_unit_3']==null || $_REQUEST['base_unit_3']<0) $_REQUEST['base_unit_3']=0;
if($_REQUEST['base_unit_4']==null || $_REQUEST['base_unit_4']<0) $_REQUEST['base_unit_4']=0;
if($_REQUEST['base_unit_5']==null || $_REQUEST['base_unit_5']<0) $_REQUEST['base_unit_5']=0;
if($_REQUEST['base_unit_6']==null || $_REQUEST['base_unit_6']<0) $_REQUEST['base_unit_6']=0;

if($_REQUEST['add_resource_1']==null || $_REQUEST['add_resource_1']<0) $_REQUEST['add_resource_1']=0;
if($_REQUEST['add_resource_2']==null || $_REQUEST['add_resource_2']<0) $_REQUEST['add_resource_2']=0;
if($_REQUEST['add_resource_3']==null || $_REQUEST['add_resource_3']<0) $_REQUEST['add_resource_3']=0;

if($_REQUEST['add_unit_1']==null || $_REQUEST['add_unit_1']<0) $_REQUEST['add_unit_1']=0;
if($_REQUEST['add_unit_2']==null || $_REQUEST['add_unit_2']<0) $_REQUEST['add_unit_2']=0;
if($_REQUEST['add_unit_3']==null || $_REQUEST['add_unit_3']<0) $_REQUEST['add_unit_3']=0;
if($_REQUEST['add_unit_4']==null || $_REQUEST['add_unit_4']<0) $_REQUEST['add_unit_4']=0;
if($_REQUEST['add_unit_5']==null || $_REQUEST['add_unit_5']<0) $_REQUEST['add_unit_5']=0;
if($_REQUEST['add_unit_6']==null || $_REQUEST['add_unit_6']<0) $_REQUEST['add_unit_6']=0;

}

$_REQUEST['ship']=(int)$_REQUEST['ship'];
$_REQUEST['ship_count']=(int)$_REQUEST['ship_count'];
$_REQUEST['auction_bold']=(int)$_REQUEST['auction_bold'];
$_REQUEST['auction_colored']=(int)$_REQUEST['auction_colored'];
$_REQUEST['auction_time']=(int)$_REQUEST['auction_time'];
$_REQUEST['auction_starttime']=(int)$_REQUEST['auction_starttime'];
$_REQUEST['ship_vis']=(int)$_REQUEST['ship_vis'];

if($_REQUEST['ship_vis']<1) $_REQUEST['ship_vis']=1;

$_REQUEST['header']=htmlspecialchars($_REQUEST['header']);
$_REQUEST['description']=htmlspecialchars($_REQUEST['description']);

$_REQUEST['number']=(int)$_REQUEST['number'];

$_REQUEST['unowed_only']=(int)$_REQUEST['unowed_only'];

if ($_REQUEST['unowed_only']<0 || $_REQUEST['unowed_only']>1) $_REQUEST['unowed_only']=1;
if ($_REQUEST['ship_count']<1) $_REQUEST['ship_count']=1;
if ($_REQUEST['ship_count']>$game->planet['building_11']) $_REQUEST['ship_count']=$game->planet['building_11'];
if ($_REQUEST['auction_bold']!=0 && $_REQUEST['auction_bold']!=1) $_REQUEST['auction_bold']=0;
if ($_REQUEST['auction_colored']!=0 && $_REQUEST['auction_colored']!=1) $_REQUEST['auction_colored']=0;
if ($_REQUEST['auction_time']<12) $_REQUEST['auction_time']=12;
if ($_REQUEST['auction_time']>72) $_REQUEST['auction_time']=72;
if ($_REQUEST['auction_starttime']<0 || $_REQUEST['auction_starttime']>24) $_REQUEST['auction_starttime']=0;
if ($_REQUEST['ship_vis']<0 || $_REQUEST['ship_vis']>2) $_REQUEST['ship_vis']=2;

$costs=250;
if ($_REQUEST['ship_vis']==1) $costs=500;
if ($_REQUEST['ship_vis']==2) $costs=1000;
if ($_REQUEST['auction_bold']) $costs+=500;
if ($_REQUEST['auction_colored']) $costs+=500;


if ($costs*$_REQUEST['number']>$game->planet['resource_1'])
$text='Du kannst die '.($costs*$_REQUEST['number']).' Metall Gebühren nicht zahlen.';
else
if ($_REQUEST['add_resource_1']==0 && $_REQUEST['add_resource_2']==0 && $_REQUEST['add_resource_3']==0 && $_REQUEST['add_unit_1']==0 && $_REQUEST['add_unit_2']==0 && $_REQUEST['add_unit_3']==0 && $_REQUEST['add_unit_4']==0 && $_REQUEST['add_unit_5']==0 && $_REQUEST['add_unit_6']==0)
$text='Der Erhöungsschritt pro Gebot kann nicht bei 0 liegen.';
else
if (empty($_REQUEST['header']) || strlen($_REQUEST['header'])<6)
$text='Die Überschrift muss min. 6 Zeichen lang sein.';

else
{

$template_ok=0;

// NEW in openBeta:
for ($t=0; $t<count($shiplist); $t++)
{
	if ($shiplist[$t]['ship_id']==$_REQUEST['ship'] && $shiplist[$t]['ship_count']>=$_REQUEST['number'])
     {
	   $ship_data=$shiplist[$t];
     	   $template_ok=1;
     }
}

if (!$template_ok)
{
	$text='Du hast nicht genug Schiffe für alle Auktionen in deinem Raumdock';
}
else   /// Submit the bidding:
{
	$angebot_start_add=0; // Multiple auctions will be sent delayed
	// Select the ship id's to be sold:
	$shipqry=$db->query('SELECT ships.*,ship_templates.ship_torso,ship_templates.name FROM ships LEFT JOIN ship_templates ON ship_templates.id=ships.template_id WHERE ships.fleet_id="-'.$game->planet['planet_id'].'" AND ships.ship_untouchable=0 AND ships.template_id="'.$ship_data['template_id'].'" AND ships.hitpoints="'.$ship_data['hitpoints'].'" LIMIT '.$_REQUEST['number']);
	if ($db->num_rows()!=$_REQUEST['number']) $text='Es ist ein Fehler beim selecten der Schiffe aufgetreten';
	else
	{
	while (($ship=$db->fetchrow($shipqry))==true)
	{
	//<Mojo1987>	Oo das funzt? also bei mir wollte der SQL Instert bei den Truppen immer nimmer
	//<Secius> Er bruacht auch die werte die er speichern soll^^
	$sql='INSERT INTO ship_trade (user,planet,start_time,end_time,ship_id,resource_1,resource_2,resource_3,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,add_resource_1,add_resource_2,add_resource_3,add_unit_1,add_unit_2,add_unit_3,add_unit_4,add_unit_5,add_unit_6,header,description,show_data,font_bold,font_colored,unowed_only)
						VALUES   ('.$game->player['user_id'].','.$game->planet['planet_id'].','.($ACTUAL_TICK+$_REQUEST['auction_starttime']*20+$angebot_start_add).','.($ACTUAL_TICK+$_REQUEST['auction_starttime']*20+$_REQUEST['auction_time']*20+$angebot_start_add).','.$ship['ship_id'].','.$_REQUEST['base_resource_1'].','.$_REQUEST['base_resource_2'].','.$_REQUEST['base_resource_3'].','.$_REQUEST['base_unit_1'].','.$_REQUEST['base_unit_2'].','.$_REQUEST['base_unit_3'].','.$_REQUEST['base_unit_4'].','.$_REQUEST['base_unit_5'].','.$_REQUEST['base_unit_6'].','.$_REQUEST['add_resource_1'].','.$_REQUEST['add_resource_2'].','.$_REQUEST['add_resource_3'].','.$_REQUEST['add_unit_1'].','.$_REQUEST['add_unit_2'].','.$_REQUEST['add_unit_3'].','.$_REQUEST['add_unit_4'].','.$_REQUEST['add_unit_5'].','.$_REQUEST['add_unit_6'].',"'.$_REQUEST['header'].'","'.$_REQUEST['description'].'",'.$_REQUEST['ship_vis'].','.$_REQUEST['auction_bold'].','.$_REQUEST['auction_colored'].','.$_REQUEST['unowed_only'].')';
    $angebot_start_add+=2;
	if (($db->query($sql))==true) {$db->query('UPDATE ships SET ship_untouchable=1 WHERE ship_id='.$ship['ship_id']);}
	} //end: while (($ship=$db->fetchrow($shipqry))==true)
    $db->query('UPDATE planets SET resource_1=resource_1-'.($costs*$_REQUEST['number']).' WHERE planet_id='.$game->planet['planet_id']);
    $db->query('UPDATE user SET num_auctions=num_auctions+'.($_REQUEST['number']).' WHERE user_id='.$game->player['user_id']);

    redirect('a=trade&view=view_own_bidding');
	}


}



}

}


$db->unlock('ships','ship_templates','ship_trade');

///////// Form for new auction
$game->out('<center><span class="sub_caption">Auktion erstellen '.HelpPopup('trade_createauction').' :</span></center><br>');
//TAP|BNC> tobi
//<TAP|BNC> du hattest das gleiche problem
//<TAP|BNC> er speichert den erhöhungsschritt bei lv1,2,3 nich
//<TAP|BNC> [22:10] <Secius> Startpreis:  2    2    2    2    2    2    22    2    2
//<TAP|BNC> [22:10] <Secius> Erhöhungsschritt:  50055    5    5    0    0    0    5    55    5
//<Secius> yep hab den formular felden die namen 4-6 gegeben und net 1-3
function tap_beides(){
global $game;
return $wert = '
<table boder=0 cellpadding=0 cellspacing=0>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_resource_1" value="'.$_REQUEST['base_resource_1'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_resource_2" value="'.$_REQUEST['base_resource_2'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_resource_3" value="'.$_REQUEST['base_resource_3'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_1" value="'.$_REQUEST['base_unit_1'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_2" value="'.$_REQUEST['base_unit_2'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_3" value="'.$_REQUEST['base_unit_3'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_4" value="'.$_REQUEST['base_unit_4'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_5" value="'.$_REQUEST['base_unit_5'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;(Startpreis):</td><td width=20></td><td width=80><input type="text" name="base_unit_6" value="'.$_REQUEST['base_unit_6'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_resource_1" value="'.$_REQUEST['add_resource_1'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_resource_2" value="'.$_REQUEST['add_resource_2'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_resource_3" value="'.$_REQUEST['add_resource_3'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_1" value="'.$_REQUEST['add_unit_1'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_2" value="'.$_REQUEST['add_unit_2'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_3" value="'.$_REQUEST['add_unit_3'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_4" value="'.$_REQUEST['add_unit_4'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_5" value="'.$_REQUEST['add_unit_5'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
<tr><td width=150>&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;(Erhöhungsschritt):</td><td width=20></td><td width=80><input type="text" name="add_unit_6" value="'.$_REQUEST['add_unit_6'].'" class="Field_nosize" size="10" maxlength="6"></td></tr>
</table>';
}


$game->out('
<br>
<center>
<table boder=0 cellpadding=0 cellspacing=0 width="400" class="style_outer"><tr><td>
<center>
<center><span class="text_large">'.$text.'</span></center>
<br>
<form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&submit_bidding=1').'">

<table boder=0 cellpadding=0 cellspacing=0 width="400" class="style_inner">
<tr><td width=400>
<center>
<span class="sub_caption2">Auktionsdaten:</span><br>

<table boder=0 cellpadding=0 cellspacing=0>
<tr><td width=100 valign=top>&nbsp;Schiff wählen:</td><td width=20></td><td width=300>
<select name="ship" class="Select" size="1">'.$optionfield.'</select>
</td></tr>
<tr><td width=100 valign=top>&nbsp;Überschrift:</td><td width=20></td><td width=300><input type="text" name="header" value="'.$_REQUEST['header'].'" class="Field_nosize" size="20" maxlength="40" style="width: 250px;"></td></tr>
<tr><td width=100 valign=top>&nbsp;Beschreibung:</td><td width=20></td><td width=300><textarea name="description" class="textfield" style="width: 290px;" rows="10">'.$_REQUEST['description'].'</textarea><br></td></tr>
</table>
</td></tr>
</table>
<br>
<center>
<table boder=0 cellpadding=0 cellspacing=0 width=500>
<tr><td width=300  valign=top>
<center><table boder=0 cellpadding=0 cellspacing=0 width=250 class="style_inner">
<tr><td width=250>
<center>
<span class="sub_caption2">Optionen:</span><br>
<table boder=0 cellpadding=0 cellspacing=0>
<tr><td width=120 valign=top>&nbsp;Daten zeigen:</td><td width=180>
<input type="radio" name="ship_vis" value="1">&nbsp;Schiffsdaten (500 Metall)<br>
<input type="radio" name="ship_vis" value="2" checked="checked">&nbsp;Komplett (1000 Metall)<br>
</td></tr>

<tr><td width=120 valign=top>&nbsp;Extra: Fettschrift</td><td width=180><input type="checkbox" name="auction_bold" value="1" '.( (!empty($_REQUEST['auction_bold'])) ? 'checked="checked"':'').'> (+500 Metall)</td></tr>
<tr><td width=120 valign=top>&nbsp;Extra: Farbig</td><td width=180><input type="checkbox" name="auction_colored" value="1" '.( (!empty($_REQUEST['auction_colored'])) ? 'checked="checked"':'').'> (+500 Metall)</td></tr>
<tr><td width=120 valign=top>&nbsp;Laufzeit:</td><td width=180>
<select name="auction_time" class="Select" size="1">
<option value="24" '.( ($_REQUEST['auction_time']<2) ? 'selected':'').'>1 Tag</option>
<option value="48" '.( ($_REQUEST['auction_time']==2) ? 'selected':'').'>2 Tage</option>
<option value="72" '.( ($_REQUEST['auction_time']==3) ? 'selected':'').'>3 Tage</option>
<option value="11" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>11h</option>
<option value="12" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>12h</option>
<option value="13" '.( ($_REQUEST['auction_time']==5) ? 'selected':'').'>13h</option>
<option value="14" '.( ($_REQUEST['auction_time']==6) ? 'selected':'').'>14h</option>
<option value="15" '.( ($_REQUEST['auction_time']==5) ? 'selected':'').'>15h</option>
<option value="16" '.( ($_REQUEST['auction_time']==6) ? 'selected':'').'>16h</option>
<option value="17" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>17h</option>
<option value="18" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>18h</option>
<option value="19" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>19h</option>
<option value="20" '.( ($_REQUEST['auction_time']==5) ? 'selected':'').'>20h</option>
<option value="21" '.( ($_REQUEST['auction_time']==4) ? 'selected':'').'>21h</option>
<option value="22" '.( ($_REQUEST['auction_time']==6) ? 'selected':'').'>22h</option>
</select>
</td></tr>
<tr><td width=120 valign=top>&nbsp;Auktionsstart:</td><td width=180>
<select name="auction_starttime" class="Select" size="1">
<option value="0" '.( ($_REQUEST['auction_starttime']<1) ? 'selected':'').'>Sofort</option>
<option value="1" '.( ($_REQUEST['auction_starttime']==1) ? 'selected':'').'>In 1 Stunde</option>
<option value="3" '.( ($_REQUEST['auction_starttime']==3) ? 'selected':'').'>In 3 Stunden</option>
<option value="6" '.( ($_REQUEST['auction_starttime']==6) ? 'selected':'').'>In 6 Stunden</option>
<option value="12" '.( ($_REQUEST['auction_starttime']==12) ? 'selected':'').'>In 12 Stunden</option>
<option value="18" '.( ($_REQUEST['auction_starttime']==18) ? 'selected':'').'>In 18 Stunden</option>
<option value="24" '.( ($_REQUEST['auction_starttime']==24) ? 'selected':'').'>In 24 Stunden</option>
</select>
</td></tr>
</table>
</td></tr>
</table>
<br><br>
<table boder=0 cellpadding=0 cellspacing=0 width=250 class="style_inner">
<tr><td>
<center><span class="sub_caption2">Abschließen:</span><br>

<table boder=0 cellpadding=0 cellspacing=0 width=250>
<tr>
<td width=240>&nbsp;Anzahl der Auktionen:&nbsp;&nbsp;</td>

<td width=50>
<select name="number" class="Select_nosize" size="1">');
 for ($t=1; $t<=$game->planet['building_11']; $t++) $game->out('<option value="'.($t).'">'.$t.'x</option>');
$game->out('</select>
</td></tr>
<!--
<tr>
<td>&nbsp;Verschuldete Spieler ausschließen:</td>
<td>
<input type="checkbox" name="unowed_only" value="1" checked="checked" disabled="disabled">
</td></tr> -->
<tr><td colspan=2><center>
<input type="submit" name="register" class="Button_nosize" value="Erstellen" style="width: 100px">
</center></td></tr></table>
</td></tr>
</table>
</td><td>

<center>
<table boder=0 cellpadding=0 cellspacing=0 width=250 class="style_inner">
<tr><td width=250>
<center>
<span class="sub_caption2">Preis:</span><br>' .
		'<div id="masterdiv">
	<div class="menutitle" onclick="SwitchMenu(\'sub3\')">Truppen und Rohstoffe</div>
	<span class="submenu" id="sub3">');
$wert=tap_beides();
$game->out($wert.'	</span>
		</div>
</td></tr>
</table>

</td></tr>
</table>



</form>
</td></tr></table>
</center>');
}


function Ress_price($nach,$von,$art)
{
global $db;
global $game;
global $RACE_DATA, $UNIT_NAME, $UNIT_DATA, $MAX_BUILDING_LVL,$NEXT_TICK,$ACTUAL_TICK;
if($art==0)$ergebniss=($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von])+(($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von])*20/100);
if($art==1)$ergebniss =($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von]) + (($RACE_DATA[$game->player['user_race'][$nach]]/$RACE_DATA[$game->player['user_race']][$von])*10/100);
if($art==2)$ergebniss = ($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von]);
if($art==3)$ergebniss = ($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von]) -  (($RACE_DATA[$game->player['user_race']][$nach]/$RACE_DATA[$game->player['user_race']][$von])*20/100);
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
$game->out('<center><span class="sub_caption">Ressourcenmarkt: '.HelpPopup('trade_ress').' :</span></center><br>');
if($_POST['menge']<0)$_POST['menge']=0;
$_POST['bezahlungsart']=(int)$_POST['bezahlungsart'];
if($_POST['menge']==null)$_POST['menge']=0;
$_POST['menge']=(int)$_POST['menge'];
$_POST['plani_ziel']=(int)$_POST['plani_ziel'];
$_POST['plani']=(int)$_POST['plani'];

if(isset($_POST['Art']))
if($_POST['Art']!="Metall" && $_POST['Art']!="Latinum" && $_POST['Art']!="Mineral")
{
message(NOTICE,'Cheaten oder?!');
}

$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($_REQUEST['handel']=='trade_ress' && $_POST['plani']!=null && $_REQUEST['step']=='3' && $_POST['menge']!=0)
{ 
$plani_id_a=$db->queryrow('SELECT planet_id,planet_name  FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
{
	$game->out('<br>Ich schätze cheaten, ein Bug wäre eher unwahrscheinlicher<br>');
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

if($_POST['bezahlungsart']==1 && $_POST['Art']=="Metall") // metall zu mineral
{
if($daten['ress_2']<10000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,0));}
if($daten['ress_2']>=10000 && $daten['ress_2']<=100000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,1));}
if($daten['ress_2']>=100001 && $daten['ress_2']<=1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,2));}
if($daten['ress_2']>1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,9,3));}
}
else if($_POST['bezahlungsart']==2 && $_POST['Art']=="Metall") // metall zu latinum
{
if($daten['ress_3']<10000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,0));}
if($daten['ress_3']>=10000 && $daten['ress_3']<=100000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,1));}
if($daten['ress_3']>=100001 && $daten['ress_3']<=1000000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,2));}
if($daten['ress_3']>1000000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,9,3));}
}
else if($_POST['bezahlungsart']==3 && $_POST['Art']=="Mineral") // mineral zu metall
{
if($daten['ress_1']<10000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,0));}
if($daten['ress_1']>=10000 && $daten['ress_1']<=100000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,1));}
if($daten['ress_1']>=100001 && $daten['ress_1']<=1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,2));}
if($daten['ress_1']>1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,10,3));}
}
else if($_POST['bezahlungsart']==4 && $_POST['Art']=="Mineral") // mineral zu latinum
{
if($daten['ress_3']<10000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,0));}
if($daten['ress_3']>=10000 && $daten['ress_3']<=100000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,1));}
if($daten['ress_3']>=100001 && $daten['ress_3']<=1000000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,2));}
if($daten['ress_3']>1000000){$kosten['Latinum']=(int)($_POST['menge']*Ress_price(11,10,3));}
}
else if($_POST['bezahlungsart']==5 && $_POST['Art']=="Latinum") // latinum zu metall
{
if($daten['ress_1']<10000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,0));}
if($daten['ress_1']>=10000 && $daten['ress_1']<=100000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,1));}
if($daten['ress_1']>=100001 && $daten['ress_1']<=1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,2));}
if($daten['ress_1']>1000000){$kosten['Metall']=(int)($_POST['menge']*Ress_price(9,11,3));}
}
else if($_POST['bezahlungsart']==6 && $_POST['Art']=="Latinum") // latinum zu mineral
{
if($daten['ress_2']<10000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,0));}
if($daten['ress_2']>=10000 && $daten['ress_2']<=100000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,1));}
if($daten['ress_2']>=100001 && $daten['ress_2']<=1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,2));}
if($daten['ress_2']>1000000){$kosten['Mineral']=(int)($_POST['menge']*Ress_price(10,11,3));}
}

$db->lock('FHB_Handels_Lager','scheduler_resourcetrade');
$plani_inhalt=$db->queryrow('SELECT resource_2,resource_1,resource_3 FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
if($_POST['bezahlungsart']==1 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_1'])
{ 
	if($transportsatz!=0)
	{$steuern=(int)($kosten['Mineral']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_2']>=$kosten['Mineral']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_1=resource_1-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern).',ress_1=ress_1+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.($kosten['Mineral']-$steuern).',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Mineral das man bekommt:'.($kosten['Mineral']-$steuern).'</td></tr>
			<tr><td>Metall das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');


	
	
}
elseif($_POST['bezahlungsart']==2 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_1'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['Latinum']*$transportsatz);
	}else{$steuern=0;}
	
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_3']>=$kosten['Latinum']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_1=resource_1-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern).',ress_1=ress_1+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.($kosten['Latinum']-$steuern).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Latinum das man bekommt:'.($kosten['Latinum']-$steuern).'</td></tr>
			<tr><td>Metall das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');

	
}
elseif($_POST['bezahlungsart']==3 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_2'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['Metall']*$transportsatz);
	}else{$steuern=0;}
	
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_1']>=$kosten['Metall']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_2=resource_2-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern).',ress_2=ress_2+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']-$steuern).',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Metall das man bekommt:'.($kosten['Metall']-$steuern).'</td></tr>
			<tr><td>Mineralien das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
}
elseif($_POST['bezahlungsart']==4 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_2'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['Latinum']*$transportsatz);
	}else{$steuern=0;}
	
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_3']>=$kosten['Latinum']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_2=resource_2-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern).',ress_2=ress_2+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.($kosten['Latinum']-$steuern).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Latinum das man bekommt:'.($kosten['Latinum']-$steuern).'</td></tr>
			<tr><td>Mineralien das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
}
elseif($_POST['bezahlungsart']==5 && isset($transportsatz) &&  $_POST['menge']<=$plani_inhalt['resource_3'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['Metall']*$transportsatz);
	}else{$steuern=0;}
	
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_1']>=$kosten['Metall']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_3=resource_3-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern).',ress_3=ress_3+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']-$steuern).',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Metall das man bekommt:'.($kosten['Metall']-$steuern).'</td></tr>
			<tr><td>Latinum das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
}
elseif($_POST['bezahlungsart']==6 && isset($transportsatz) && $_POST['menge']<=$plani_inhalt['resource_3'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['Mineral']*$transportsatz);
	}else{$steuern=0;}
	
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_2']>=$kosten['Mineral']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_3=resource_3-'.$_POST['menge'].' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern).',ress_3=ress_3+'.$_POST['menge'].' WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.($kosten['Mineral']-$steuern).',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Mineral das man bekommt:'.($kosten['Mineral']-$steuern).'</td></tr>
			<tr><td>Latinum das man eingetauscht hat:'.$_POST['menge'].'</td></tr>
			<tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
}
else
{
 $game->out('<br><b>Entweder der Bot kann deiner Zahlungsmethode nicht nachkommen weil seine Rohstoffe dafür nicht ausrreichen oder du hast nicht mehr die benötigten Ressourcen auf deinem Planeten</b><br>');
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_res&step=2').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
$game->out('<input type="hidden" name="Art" value="'.$_POST['Art'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
} 
}
elseif($_REQUEST['handel']=='trade_ress' && $_REQUEST['step']=='2'  &&  $_POST['menge']!=0)
{
//K = (n*p) - ((n-1)*0,1) 
if($_POST['Art']=="Metall") // metall zu mineral
{
if($daten['ress_2']<10000){$kosten['Mineral'][1]=(int)($_POST['menge']*Ress_price(10,9,0));}
if($daten['ress_2']>=10000 && $daten['ress_2']<=100000){$kosten['Mineral'][1]=(int)($_POST['menge']*Ress_price(10,9,1));}
if($daten['ress_2']>=100001 && $daten['ress_2']<=1000000){$kosten['Mineral'][1]=(int)($_POST['menge']*Ress_price(10,9,2));}
if($daten['ress_2']>1000000){$kosten['Mineral'][1]=(int)($_POST['menge']*Ress_price(10,9,3));}
}
if($_POST['Art']=="Metall") // metall zu latinum
{
if($daten['ress_3']<10000){$kosten['Latinum'][1]=(int)($_POST['menge']*Ress_price(11,9,0));}
if($daten['ress_3']>=10000 && $daten['ress_3']<=100000){$kosten['Latinum'][1]=(int)($_POST['menge']*Ress_price(11,9,1));}
if($daten['ress_3']>=100001 && $daten['ress_3']<=1000000){$kosten['Latinum'][1]=(int)($_POST['menge']*Ress_price(11,9,2));}
if($daten['ress_3']>1000000){$kosten['Latinum'][1]=(int)($_POST['menge']*Ress_price(11,9,3));}
}
if($_POST['Art']=="Mineral") // mineral zu metall
{
if($daten['ress_1']<10000){$kosten['Metall'][1]=(int)($_POST['menge']*Ress_price(9,10,0));}
if($daten['ress_1']>=10000 && $daten['ress_1']<=100000){$kosten['Metall'][1]=(int)($_POST['menge']*Ress_price(9,10,1));}
if($daten['ress_1']>=100001 && $daten['ress_1']<=1000000){$kosten['Metall'][1]=(int)($_POST['menge']*Ress_price(9,10,2));}
if($daten['ress_1']>1000000){$kosten['Metall'][1]=(int)($_POST['menge']*Ress_price(9,10,3));}

}
if($_POST['Art']=="Mineral") // mineral zu latinum
{
if($daten['ress_3']<10000){$kosten['Latinum'][2]=(int)($_POST['menge']*Ress_price(11,10,0));}
if($daten['ress_3']>=10000 && $daten['ress_3']<=100000){$kosten['Latinum'][2]=(int)($_POST['menge']*Ress_price(11,10,1));}
if($daten['ress_3']>=100001 && $daten['ress_3']<=1000000){$kosten['Latinum'][2]=(int)($_POST['menge']*Ress_price(11,10,2));}
if($daten['ress_3']>1000000){$kosten['Latinum'][2]=(int)($_POST['menge']*Ress_price(11,10,3));}
}
if($_POST['Art']=="Latinum") // latinum zu metall
{
if($daten['ress_1']<10000){$kosten['Metall'][2]=(int)($_POST['menge']*Ress_price(9,11,0));}
if($daten['ress_1']>=10000 && $daten['ress_1']<=100000){$kosten['Metall'][2]=(int)($_POST['menge']*Ress_price(9,11,1));}
if($daten['ress_1']>=100001 && $daten['ress_1']<=1000000){$kosten['Metall'][2]=(int)($_POST['menge']*Ress_price(9,11,2));}
if($daten['ress_1']>1000000){$kosten['Metall'][2]=(int)($_POST['menge']*Ress_price(9,11,3));}

}
if($_POST['Art']=="Latinum") // latinum zu mineral
{
if($daten['ress_2']<10000){$kosten['Mineral'][2]=(int)($_POST['menge']*Ress_price(10,11,0));}
if($daten['ress_2']>=10000 && $daten['ress_2']<=100000){$kosten['Mineral'][2]=(int)($_POST['menge']*Ress_price(10,11,1));}
if($daten['ress_2']>=100001 && $daten['ress_2']<=1000000){$kosten['Mineral'][2]=(int)($_POST['menge']*Ress_price(10,11,2));}
if($daten['ress_2']>1000000){$kosten['Mineral'][2]=(int)($_POST['menge']*Ress_price(10,11,3));}
}
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
$game->out('<table>');
if($_POST['Art']=="Metall")
{$game->out('<tr><td colspan=2><table><tr><td>Umrechnung: '.$_POST['menge'].' Metall</td><td>In Mineral</td><td>In Latinum</td></tr>');
$game->out('<tr><td></td><td>'.$kosten['Mineral'][1].'('.$daten['ress_2'].')</td><td>'.$kosten['Latinum'][1].'('.$daten['ress_3'].')</td></tr>');
$game->out('<tr><td>Steuern 50%</td><td>'.($kosten['Mineral'][1]-$steuern[2]).'</td><td> '.($kosten['Latinum'][1]-$steuern[3]).'</td></tr>');
$game->out('<tr><td>Steuern 35%</td><td>'.($kosten['Mineral'][1]-$steuern[8]).'</td><td> '.($kosten['Latinum'][1]-$steuern[9]).'</td></tr>');
$game->out('<tr><td>Steuern 15%</td><td>'.($kosten['Mineral'][1]-$steuern[14]).'</td><td> '.($kosten['Latinum'][1]-$steuern[15]).'</td></tr>');}
if($_POST['Art']=="Mineral"){
$game->out('<tr><td colspan=2><table><tr><td>Umrechnung: '.$_POST['menge'].' Mineral</td><td>In Metall</td><td>In Latinum</td></tr>');
$game->out('<tr><td></td><td>'.$kosten['Metall'][1].'('.$daten['ress_1'].')</td><td>'.$kosten['Latinum'][2].'('.$daten['ress_3'].')</td></tr>');
$game->out('<tr><td>Steuern 50%</td><td>'.($kosten['Metall'][1]-$steuern[1]).'</td><td> '.($kosten['Latinum'][2]-$steuern[6]).'</td></tr>');
$game->out('<tr><td>Steuern 35%</td><td>'.($kosten['Metall'][1]-$steuern[7]).'</td><td> '.($kosten['Latinum'][2]-$steuern[12]).'</td></tr>');
$game->out('<tr><td>Steuern 15%</td><td>'.($kosten['Metall'][1]-$steuern[13]).'</td><td> '.($kosten['Latinum'][2]-$steuern[18]).'</td></tr>');}
if($_POST['Art']=="Latinum"){
$game->out('<tr><td colspan=2><table><tr><<td>Umrechnung: '.$_POST['menge'].' Latinum</td><td>In Metall</td><td>In Mineral</td></tr>');
$game->out('<tr><<td></td><td>'.$kosten['Metall'][2].'('.$daten['ress_1'].')</td><td>'.$kosten['Mineral'][2].'('.$daten['ress_2'].')</td></tr>');
$game->out('<tr><td>Steuern 50%</td><td>'.($kosten['Metall'][2]-$steuern[4]).'</td><td> '.($kosten['Mineral'][2]-$steuern[5]).'</td></tr>');
$game->out('<tr><td>Steuern 35%</td><td>'.($kosten['Metall'][2]-$steuern[10]).'</td><td> '.($kosten['Mineral'][2]-$steuern[11]).'</td></tr>');
$game->out('<tr><td>Steuern 15%</td><td>'.($kosten['Metall'][2]-$steuern[16]).'</td><td> '.($kosten['Mineral'][2]-$steuern[17]).'</td></tr>');}

$game->out('</table><br>*In Klammer sind die Rohstoffe die der Ferengie NPC Händler zurverfügung hat. Sollten sie niedriger sein als das was du bei einer bestimmten Zahlungsart bekommen solltest, wird der Handel nicht möglich sein.</td></tr>');
$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress&step=3').'" method="post"><tr><td>Art der Bezahlung:</td><td><select size="1" name="bezahlungsart">
   ');
if($_POST['Art']=="Metall")$game->out('<option value="1">Zu Mineral</option>');
if($_POST['Art']=="Metall")$game->out('<option value="2">Zu Latinum</option>');
if($_POST['Art']=="Mineral")$game->out('<option value="3">Zu Metall</option>');
if($_POST['Art']=="Mineral")$game->out('<option value="4">Zu Latinum</option>');
if($_POST['Art']=="Latinum")$game->out('<option value="5">Zu Metall</option>');
if($_POST['Art']=="Latinum")$game->out('<option value="6">Zu Mineral</option>');
$game->out('</select></td></tr>');
$game->out('<tr><td>Transport:</td><td><select size="1" name="transportsart">
   <option value="1">Ferengi Spezialtansport (6h) - 50% Steuern</option>
   <option value="2">Fernegi Transport  (12h) - 35% Steuern</option>
   <option value="3">Galaxy Post (36h) - 15% Steuern</option>
   </select></td></tr><tr><td colspan=2><br>*Die Ferengie Handelsgilde übernimmt keine Haftung für verloren Gegangene Ladung. Bei der Post übernehmen wir nicht mal die Tapianische Sicherheit.</td></tr>');
$sql='SELECT planet_id,planet_name FROM `planets` WHERE planet_owner='.$game->player['user_id'].'';
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet von dem Bezahlt werden soll:</td><td><select size="1" name="plani">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet wo die ware hin soll:</td><td><select size="1" name="plani_ziel">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
$game->out('<tr><td colspan=2>');
$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
$game->out('<input type="hidden" name="Art" value="'.$_POST['Art'].'">');
$game->out('<input type="submit" value="Handel abschließen"  name="submit"></td></tr></form>');
$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="menge" value="'.$_POST['menge'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
else{
if($_REQUEST['handel']=='trade_ress' && $_REQUEST['step']=='2' && $_POST['menge']==0) $game->out('Du musst auch schon wo Zahl eintragen<br>');
	$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
	$game->out('<table align=center><tr><td>Einheiten</td></tr>');
	$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=trade_ress&step=2').'" method="post"><td><input type="text" name="menge" value="'.$_POST['menge'].'"></td></td></tr>');
$game->out('<tr><td>Art des rohstoffes, den man anbieten möchte:</td><td><select size="1" name="Art">
   <option value="Metall">Metall</option>
   <option value="Mineral">Mineral</option>
   <option value="Latinum">Latinum</option>
   </select></td></tr>');
$game->out('<tr><td colspan="3"><input type="submit" value="Tauschen"  name="submit"></td></form></tr></table>');
}
}
function sold_formel_truppen($grundkosten,$anzahl,$art,$x1=0)
{
global $ACTUAL_TICK,$db;
$y1=$grundkosten+(($grundkosten/100)*100);
$y2=$grundkosten-(($grundkosten/100)*10);
$daten=$db->queryrow('SELECT '.$art.' FROM FHB_Handels_Lager WHERE id=1');
$x=$daten[$art];
$q=$ACTUAL_TICK;
$result = ((($y2-$y1)/(((25/216)*$q)-$x1))*$x) + ($y2 - (($y2-$y1)/(((25/216)*$q)-$x1) * (25/216)*$q));
if($result>$y2) $result=$y2;
if($result<$y1) $result=$y1;
$result=$result*$anzahl;
return $ergebniss=(int)$result;
}
function Trade_Sold_truppen() 
{
	global $db;
	global $game,$ACTUAL_TICK;

$game->out('<center><span class="sub_caption">Söldnermarkt - Truppen Verkauf: '.HelpPopup('trade_sold_truppen').' :</span></center><br>');
if($_POST['unit_1']==null || $_POST['unit_1']<0 )$_POST['unit_1']=0;
if($_POST['unit_2']==null || $_POST['unit_2']<0 )$_POST['unit_2']=0;
if($_POST['unit_3']==null || $_POST['unit_3']<0 )$_POST['unit_3']=0;
if($_POST['unit_4']==null || $_POST['unit_4']<0 )$_POST['unit_4']=0;
if($_POST['unit_5']==null || $_POST['unit_5']<0 )$_POST['unit_5']=0;
if($_POST['unit_6']==null || $_POST['unit_6']<0 )$_POST['unit_6']=0;

$_POST['unit_1']=(int)$_POST['unit_1'];
$_POST['unit_2']=(int)$_POST['unit_2'];
$_POST['unit_3']=(int)$_POST['unit_3'];
$_POST['unit_4']=(int)$_POST['unit_4'];
$_POST['unit_5']=(int)$_POST['unit_5'];
$_POST['unit_6']=(int)$_POST['unit_6'];

$_POST['plani_ziel']=(int)$_POST['plani_ziel'];
$_POST['plani']=(int)$_POST['plani'];

$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($_REQUEST['handel']=='sold_truppen' && $_POST['plani']!=null && $_REQUEST['step']=='3' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0))
{ 
$plani_id_a=$db->queryrow('SELECT planet_id,planet_name  FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
{
	$game->out('<br>Ich schätze cheaten, ein Bug wäre eher unwahrscheinlicher<br>');
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
if($_POST['bezahlungsart']==1 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_1']>=$kosten['gesamt'])
{ 
	if($transportsatz!=0)
	{$steuern=(int)($kosten['gesamt']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
	if($daten['ress_1']>=$kosten['gesamt']){

	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_1=resource_1-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['gesamt']).'+'.($steuern).' WHERE id=1'))==true){
$zufall_tick=mt_rand(23,420);
$zufall_tick=$zufall_tick+$ACTUAL_TICK;
if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.$kosten['gesamt'].',0,0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Metall:'.$kosten['gesamt'].'</td></tr>
			<tr><td><b>Verkaufte Truppen:</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
			'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
			'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
			'Lv6:'.$_POST['unit_6'].'</td></tr>' .
			'<tr><td>' .
			'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',0,'.$_POST['transportsart'].','.$kosten['gesamt'].',0,0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');


	
	
}
elseif($_POST['bezahlungsart']==2 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_2']>=$kosten['gesamt'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['gesamt']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
	if($daten['ress_2']>=$kosten['gesamt']){
    if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_2=resource_2-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2-'.($kosten['gesamt']).'+'.($steuern).' WHERE id=1'))==true){
$zufall_tick=mt_rand(23,420);
$zufall_tick=$zufall_tick+$ACTUAL_TICK;
 if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,'.$kosten['gesamt'].',0,"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Mineral:'.$kosten['gesamt'].'</td></tr>
			<tr><td><b>Verkaufte Truppen:</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
			'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
			'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
			'Lv6:'.$_POST['unit_6'].'</td></tr>' .
			'<tr><td>' .
			'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',1,'.$_POST['transportsart'].',0,'.$kosten['gesamt'].',0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');
	
}
elseif($_POST['bezahlungsart']==3 && isset($transportsatz) && $_POST['unit_1']<=$plani_inhalt['unit_1'] && $_POST['unit_2']<=$plani_inhalt['unit_2'] && $_POST['unit_3']<=$plani_inhalt['unit_3'] && $_POST['unit_4']<=$plani_inhalt['unit_4'] && $_POST['unit_5']<=$plani_inhalt['unit_5'] && $_POST['unit_6']<=$plani_inhalt['unit_6'] && $daten['ress_3']>=$kosten['gesamt'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['gesamt']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['ress_3']>=$kosten['gesamt']){
    if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).', resource_3=resource_3-'.($steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem user Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3+'.($steuern-$kosten['gesamt']).'  WHERE id=1'))==true){
$zufall_tick=mt_rand(23,420);
$zufall_tick=$zufall_tick+$ACTUAL_TICK;
if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,'.$kosten['gesamt'].',"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Latinum:'.$kosten['gesamt'].'</td></tr>
			<tr><td><b>Verkaufte Truppen:</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
			'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
			'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
			'Lv6:'.$_POST['unit_6'].'</td></tr>' .
			'<tr><td>' .
			'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',2,'.$_POST['transportsart'].',0,0,'.$kosten['gesamt'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
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
if($daten['ress_1']>=$kosten['Metall'] && $daten['ress_2']>=$kosten['Mineral']  && $daten['ress_3']>=$kosten['Latinum'] ){
    if (($db->query('UPDATE planets SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).',resource_1=resource_1-'.($steuern['1']).' ,resource_2=resource_2-'.($steuern['2']).',resource_3=resource_3-'.($steuern['3']).' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem user Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1-'.($kosten['Metall']).'+'.($steuern['1']).',ress_2=ress_2-'.($kosten['Mineral']).'+'.($steuern['2']).',ress_3=ress_3-'.($kosten['Latinum']).'+'.($steuern['3']).' WHERE id=1'))==true){
$zufall_tick=mt_rand(23,420);
$zufall_tick=$zufall_tick+$ACTUAL_TICK;
if (($db->query('INSERT INTO `FHB_cache_trupp_trade` (`unit_1` , `unit_2` , `unit_3` , `unit_4` , `unit_5` , `unit_6` , `tick` )
VALUES ('.($_POST['unit_1']).','.($_POST['unit_2']).','.($_POST['unit_3']).','.($_POST['unit_4']).','.($_POST['unit_5']).','.($_POST['unit_6']).','.$zufall_tick.')'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",'.($kosten['Metall']).','.($kosten['Mineral']).','.($kosten['Latinum']).',"'.($ACTUAL_TICK+$tickzeit).'")'))==true){
$game->out('<table><tr><td>Die Ressourcen sind unterwegs zu dir</td></tr>
			<tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr>
			<tr><td>Steuerkosten:'.$steuern.'</td></tr>
			<tr><td>Metall:'.$kosten['Metall'].'<br>Mineral:'.$kosten['Mineral'].'<br>Latinum:'.$kosten['Latinum'].'</td></tr>
			<tr><td><b>Verkaufte Truppen:</b><br>Lv1:'.$_POST['unit_1'].'<br>' .
			'Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>' .
			'Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>' .
			'Lv6:'.$_POST['unit_6'].'</td></tr>' .
			'<tr><td>' .
			'<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></form></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',1,'.$game->player['user_id'].','.$ACTUAL_TICK.',3,'.$_POST['transportsart'].','.$kosten['Metall'].','.$kosten['Mineral'].','.$kosten['Latinum'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Die Menge an Ressourcen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log','FHB_cache_trupp_trade');

}
else
{
 $game->out('<br><b>Entweder der Bot kann deiner Zahlungsmethode nicht nachkommen weil seine Rohstoffe dafür nicht ausrreichen oder du hast nicht mehr die Verfügbaren Truppen auf deinem Planeten</b><br>');
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_cache_trupp_trade');
$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=2').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
} 
}
elseif($_REQUEST['handel']=='sold_truppen' && $_REQUEST['step']=='2' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0) && !($_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0))
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
$game->out('<tr><td colspan=2><table><tr><td></td><td>Rohstoff egal</td><td>Metall</td><td>Mineral</td><td>Latinum</td></tr>');
$game->out('<tr><td>Kosten</td><td>'.$kosten['gesamt'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$kosten['Metall'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$kosten['Mineral'].' </td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$kosten['Latinum'].'</td></tr>');
$game->out('<tr><td>Steuern 30%</td><td>'.$steuern['4'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['1'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['2'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['3'].'</td></tr>');
$game->out('<tr><td>Steuern 15%</td><td>'.$steuern['8'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['5'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['6'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['7'].'</td></tr></table></td></tr>');
$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=3').'" method="post"><tr><td>Art der Bezahlung:</td><td><select size="1" name="bezahlungsart">
   <option value="1">Alles als Metall</option>
   <option value="2">Alles als Minralien</option>
   <option value="3">Alles als Latinum</option>
   <option value="4">Jedes für sich</option>
   </select></td></tr>');
$game->out('<tr><td>Transport:</td><td><select size="1" name="transportsart">
   <option value="1">Ferengi Spezialtansport (6h) - 30% Steuern</option>
   <option value="2">Fernegi Transport  (12h) - 15% Steuern</option>
   <option value="3">Galaxy Post (36h) - 0% Steuern</option>
   </select></td></tr><tr><td colspan=2><br>*Die Ferengie Handelsgilde übernimmt keine Haftung für verloren Gegangene Ladung. Bei der Post übernehmen wir nicht mal die Tapianische Sicherheit.</td></tr>');
$sql='SELECT planet_id,planet_name FROM planets WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet von dem Bezahlt werden soll:</td><td><select size="1" name="plani">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet wo die ware hin soll:</td><td><select size="1" name="plani_ziel">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
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
$game->out('<input type="submit" value="Handel abschließen"  name="submit"></td></tr></form>');
$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
else{
if($_REQUEST['handel']=='kaufen_truppen' && $_REQUEST['step']=='2' && $_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0) $game->out('Du musst auch schon wo eine Zahl eintragen<br>');
	$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
	$game->out('<table align=center><tr><td>Art</td><td>Einheiten</td></tr>');
	$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=sold_truppen&step=2').'" method="post"><td><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"></td><td><input type="text" name="unit_1" value="'.$_POST['unit_1'].'"></td></td></tr>');
	$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit2_small.gif"></td><td><input type="text" name="unit_2" value="'.$_POST['unit_2'].'"></td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"></td><td><input type="text" name="unit_3" value="'.$_POST['unit_3'].'"></td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"></td><td><input type="text" name="unit_4" value="'.$_POST['unit_4'].'"></td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"></td><td><input type="text" name="unit_5" value="'.$_POST['unit_5'].'"></td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit6_small.gif"></td><td><input type="text" name="unit_6" value="'.$_POST['unit_6'].'"></td></tr>');
$game->out('<tr><td colspan="3"><input type="submit" value="Verkaufen"  name="submit"></td></form></tr></table>');
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

$game->out('<center><span class="sub_caption">Söldnermarkt - Truppen Kauf: '.HelpPopup('trade_buy_truppen').' :</span></center><br>');

if($_POST['unit_1']==null || $_POST['unit_1']<0 )$_POST['unit_1']=0;
if($_POST['unit_2']==null || $_POST['unit_2']<0 )$_POST['unit_2']=0;
if($_POST['unit_3']==null || $_POST['unit_3']<0 )$_POST['unit_3']=0;
if($_POST['unit_4']==null || $_POST['unit_4']<0 )$_POST['unit_4']=0;
if($_POST['unit_5']==null || $_POST['unit_5']<0 )$_POST['unit_5']=0;
if($_POST['unit_6']==null || $_POST['unit_6']<0 )$_POST['unit_6']=0;

$_POST['unit_1']=(int)$_POST['unit_1'];
$_POST['unit_2']=(int)$_POST['unit_2'];
$_POST['unit_3']=(int)$_POST['unit_3'];
$_POST['unit_4']=(int)$_POST['unit_4'];
$_POST['unit_5']=(int)$_POST['unit_5'];
$_POST['unit_6']=(int)$_POST['unit_6'];

$_POST['plani_ziel']=(int)$_POST['plani_ziel'];
$_POST['plani']=(int)$_POST['plani'];
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($_REQUEST['handel']=='kaufen_truppen' && $_POST['plani']!=null && $_REQUEST['step']=='3' && ($_POST['unit_1']!=0 || $_POST['unit_2']!=0 || $_POST['unit_3']!=0 ||  $_POST['unit_4']!=0 || $_POST['unit_5']!=0 || $_POST['unit_6']!=0))
{ 
$plani_id_a=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
$plani_id_r=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani'].' AND planet_owner='.$game->player['user_id'].'');
if($plani_id_a['planet_id']!=$_POST['plani_ziel'] || $plani_id_r['planet_id']!=$_POST['plani'])
{
	$game->out('<br>Ich schätze cheaten, ein Bug wäre eher unwahrscheinlicher<br>');
}else
{
$kosten['Metall']=0;
$kosten['Mineral']=0;
$kosten['gesamt']=0;
$kosten['Latinum']=0;
if($_POST['unit_1']!=0)
{$kosten['Metall']+=kauf_formel_truppen(280,$_POST['unit_1']);
$kosten['Mineral']+=kauf_formel_truppen(235,$_POST['unit_1']);
$kosten['gesamt']+=kauf_formel_truppen((280+235),$_POST['unit_1']);
}
if($_POST['unit_2']!=0)
{$kosten['Metall']+=kauf_formel_truppen(340,$_POST['unit_2']);
$kosten['Mineral']+=kauf_formel_truppen(225,$_POST['unit_2']);
$kosten['gesamt']+=kauf_formel_truppen((340+225),$_POST['unit_2']);
}
if($_POST['unit_3']!=0)
{$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_3']);
$kosten['Mineral']+=kauf_formel_truppen(450,$_POST['unit_3']);
$kosten['Latinum']+=kauf_formel_truppen(350,$_POST['unit_3']);
$kosten['gesamt']+=kauf_formel_truppen((650+450+350),$_POST['unit_3']);
}
if($_POST['unit_4']!=0)
{$kosten['Metall']+=kauf_formel_truppen(410,$_POST['unit_4']);
$kosten['Mineral']+=kauf_formel_truppen(210,$_POST['unit_4']);
$kosten['Latinum']+=kauf_formel_truppen(115,$_POST['unit_4']);
$kosten['gesamt']+=kauf_formel_truppen((410+210+115),$_POST['unit_4']);
}
if($_POST['unit_5']!=0)
{$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_5']);
$kosten['Mineral']+=kauf_formel_truppen(440,$_POST['unit_5']);
$kosten['Latinum']+=kauf_formel_truppen(250,$_POST['unit_5']);
$kosten['gesamt']+=kauf_formel_truppen((650+440+250),$_POST['unit_5']);
}
if($_POST['unit_6']!=0)
{$kosten['Metall']+=kauf_formel_truppen(1000,$_POST['unit_6']);
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
if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_1=resource_1-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true){
    if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true){
	$game->out('<table><tr><td>Die Söldner sind unterwegs zu dir</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td><tr><td>Steuerkosten:'.$steuern.'</td></tr><tr><td>Ressourcenkosten Metall: '.$kosten['gesamt'].'</td></tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></td></tr></table>');
if(($db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',0,'.$_POST['transportsart'].','.$kosten['gesamt'].',0,0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')'))==false){message(DATABASE_ERROR, 'Interner Datenbankfehler');}
}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Deine Rohstoffe reichen nicht aus um die gewünschten Truppen zu kaufen');}}
else{message(NOTICE, 'Die Menge an Truppen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');


	
	
}
elseif($_POST['bezahlungsart']==2 && isset($transportsatz) && ($kosten['gesamt']+($kosten['gesamt']*$transportsatz))<=$plani_inhalt['resource_2'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['gesamt']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']){
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_2=ress_2+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true){
		// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_2=resource_2-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
	// dem NPC Ressourcen abziehen:
    if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true){
$game->out('<table><tr><td>Die Söldner sind unterwegs zu dir</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td><tr><td>Steuerkosten:'.$steuern.'</td></tr><tr><td>Ressourcenkosten Mineral: '.$kosten['gesamt'].'</td></tr><tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',1,'.$_POST['transportsart'].',0,'.$kosten['gesamt'].',0,'.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Deine Rohstoffe reichen nicht aus um die gewünschten Truppen zu kaufen');}}
else{message(NOTICE, 'Die Menge an Truppen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');
	
}
elseif($_POST['bezahlungsart']==3 && isset($transportsatz) && ($kosten['gesamt']+($kosten['gesamt']*$transportsatz))<=$plani_inhalt['resource_3'])
{
	if($transportsatz!=0)
	{
		$steuern=(int)($kosten['gesamt']*$transportsatz);
	}else{$steuern=0;}
$daten=$db->queryrow('SELECT * FROM FHB_Handels_Lager WHERE id=1');
if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']){
	// dem user Ressourcen abziehen:
    if (($db->query('UPDATE planets SET resource_3=resource_3-'.($kosten['gesamt']+$steuern).' WHERE planet_id='.$_POST['plani'].''))==true){
 if (($db->query('UPDATE FHB_Handels_Lager SET ress_3=ress_3+'.($kosten['gesamt']+$steuern).' WHERE id=1'))==true){
	// dem NPC Ressourcen abziehen:
    if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true){
	// Käuferwaren in den Trade-Scheduler eintragen:
    if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true){
$game->out('<table><tr><td>Die Söldner sind unterwegs zu dir</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td><tr><td>Steuerkosten:'.$steuern.'</td></tr><tr><td>Ressourcenkosten Latinum: '.$kosten['gesamt'].'</td></tr><tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',2,'.$_POST['transportsart'].',0,0,'.$kosten['gesamt'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Deine Rohstoffe reichen nicht aus um die gewünschten Truppen zu kaufen');}}
else{message(NOTICE, 'Die Menge an Truppen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
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
if($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6']){
	if (($db->query('UPDATE planets SET resource_1=resource_1-'.($kosten['Metall']+$steuern['1']).',resource_2=resource_2-'.($kosten['Mineral']+$steuern['2']).',resource_3=resource_3-'.($kosten['Latinum']+$steuern['3']).' WHERE planet_id='.$_POST['plani'].''))==true){
		if (($db->query('UPDATE FHB_Handels_Lager SET ress_1=ress_1+'.($kosten['Metall']+$steuern['1']).',ress_2=ress_2+'.($kosten['Mineral']+$steuern['2']).',ress_3=ress_3+'.($kosten['Latinum']+$steuern['3']).' WHERE id=1'))==true){
				// dem NPC Ressourcen abziehen:
			if (($db->query('UPDATE FHB_Handels_Lager SET unit_1=unit_1-'.($_POST['unit_1']).',unit_2=unit_2-'.($_POST['unit_2']).',unit_3=unit_3-'.($_POST['unit_3']).',unit_4=unit_4-'.($_POST['unit_4']).',unit_5=unit_5-'.($_POST['unit_5']).',unit_6=unit_6-'.($_POST['unit_6']).'  WHERE id=1'))==true){
					// Käuferwaren in den Trade-Scheduler eintragen:
				if (($db->query('INSERT INTO scheduler_resourcetrade (planet,resource_1,resource_2,resource_3,resource_4,unit_1,unit_2,unit_3,unit_4,unit_5,unit_6,arrival_time) VALUES ("'.$_POST['plani_ziel'].'",0,0,0,0,"'.$_POST['unit_1'].'","'.$_POST['unit_2'].'","'.$_POST['unit_3'].'","'.$_POST['unit_4'].'","'.$_POST['unit_5'].'","'.$_POST['unit_6'].'","'.($ACTUAL_TICK+$tickzeit).'")'))==true){
					$game->out('<table><tr><td>Die Söldner sind unterwegs zu dir</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td></tr><tr><td>Steuerkosten-Metall:'.$steuern['1'].'</td></tr><tr><td>Steuerkosten-Mineral: '.$steuern['2'].'</td></tr><tr><td>Steuerkosten-Latinum: '.$steuern['3'].'</td></tr><tr><td>Ressourcenkosten-Metall: '.$kosten['Metall'].'</td></tr><tr><td>Ressourcenkosten-Mineral: '.$kosten['Mineral'].'</td></tr><tr><td>Ressourcenkosten-Latinum: '.$kosten['Latinum'].'</td></tr><tr><td>Lv1:'.$_POST['unit_1'].'<br>Lv2:'.$_POST['unit_2'].'<br>Lv3:'.$_POST['unit_3'].'<br>Lv4:'.$_POST['unit_4'].'<br>Lv5:'.$_POST['unit_5'].'<br>Lv6:'.$_POST['unit_6'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
					<input type="submit" value="Zurück"  name="submit"></td></tr></table>');
$db->query('INSERT INTO FHB_handel_log VALUES (null,'.$game->player['user_race'].',2,'.$game->player['user_id'].','.$ACTUAL_TICK.',3,'.$_POST['transportsart'].','.$kosten['Metall'].','.$kosten['Mineral'].','.$kosten['Latinum'].','.$_POST['unit_1'].','.$_POST['unit_2'].','.$_POST['unit_3'].','.$_POST['unit_4'].','.$_POST['unit_5'].','.$_POST['unit_6'].')');}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}}
else{message(NOTICE, 'Deine Rohstoffe reichen nicht aus um die gewünschten Truppen zu kaufen');}}
else{message(NOTICE, 'Die Menge an Truppen die du einkaufen möchtest steht nicht mehr zur Vefügung');}
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade','FHB_handel_log');

}
else
{
 $game->out('<br><b>Leider reichen deine Rohstoffe nicht aus bei deiner gewählten Zahlungsart</b><br>');
$db->unlock('FHB_Handels_Lager','scheduler_resourcetrade');
$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=2').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
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
{$kosten['Metall']+=kauf_formel_truppen(280,$_POST['unit_1']);
$kosten['Mineral']+=kauf_formel_truppen(235,$_POST['unit_1']);
$kosten['gesamt']+=kauf_formel_truppen((280+235),$_POST['unit_1']);
}
if($_POST['unit_2']!=0)
{$kosten['Metall']+=kauf_formel_truppen(340,$_POST['unit_2']);
$kosten['Mineral']+=kauf_formel_truppen(225,$_POST['unit_2']);
$kosten['gesamt']+=kauf_formel_truppen((340+225),$_POST['unit_2']);
}
if($_POST['unit_3']!=0)
{$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_3']);
$kosten['Mineral']+=kauf_formel_truppen(450,$_POST['unit_3']);
$kosten['Latinum']+=kauf_formel_truppen(350,$_POST['unit_3']);
$kosten['gesamt']+=kauf_formel_truppen((650+450+350),$_POST['unit_3']);
}
if($_POST['unit_4']!=0)
{$kosten['Metall']+=kauf_formel_truppen(410,$_POST['unit_4']);
$kosten['Mineral']+=kauf_formel_truppen(210,$_POST['unit_4']);
$kosten['Latinum']+=kauf_formel_truppen(115,$_POST['unit_4']);
$kosten['gesamt']+=kauf_formel_truppen((410+210+115),$_POST['unit_4']);
}
if($_POST['unit_5']!=0)
{$kosten['Metall']+=kauf_formel_truppen(650,$_POST['unit_5']);
$kosten['Mineral']+=kauf_formel_truppen(440,$_POST['unit_5']);
$kosten['Latinum']+=kauf_formel_truppen(250,$_POST['unit_5']);
$kosten['gesamt']+=kauf_formel_truppen((650+440+250),$_POST['unit_5']);
}
if($_POST['unit_6']!=0)
{$kosten['Metall']+=kauf_formel_truppen(1000,$_POST['unit_6']);
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
$game->out('<tr><td colspan=2><table><tr><td></td><td>Rohstoff egal</td><td>Metall</td><td>Mineral</td><td>Latinum</td></tr>');
$game->out('<tr><td>Kosten</td><td>'.$kosten['gesamt'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$kosten['Metall'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$kosten['Mineral'].' </td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$kosten['Latinum'].'</td></tr>');
$game->out('<tr><td>Steuern 30%</td><td>'.$steuern['4'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['1'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['2'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['3'].'</td></tr>');
$game->out('<tr><td>Steuern 15%</td><td>'.$steuern['8'].'</td><td><img src="'.$game->GFX_PATH.'menu_metal_small.gif">'.$steuern['5'].' </td><td><img src="'.$game->GFX_PATH.'menu_mineral_small.gif">'.$steuern['6'].'</td><td><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.$steuern['7'].'</td></tr></table></td></tr>');
$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=3').'" method="post"><tr><td>Art der Bezahlung:</td><td><select size="1" name="bezahlungsart">
   <option value="1">Alles als Metall</option>
   <option value="2">Alles als Minralien</option>
   <option value="3">Alles als Latinum</option>
   <option value="4">Jedes für sich</option>
   </select></td></tr>');
$game->out('<tr><td>Transport:</td><td><select size="1" name="transportsart">
   <option value="1">Ferengi Spezialtansport (6h) - 30% Steuern</option>
   <option value="2">Fernegi Transport  (12h) - 15% Steuern</option>
   <option value="3">Galaxy Post (36h) - 0% Steuern</option>
   </select></td></tr><tr><td colspan=2><br>*Die Ferengie Handelsgilde übernimmt keine Haftung für verloren Gegangene Ladung. Bei der Post übernehmen wir nicht mal die Tapianische Sicherheit.</td></tr>');
$sql='SELECT planet_id,planet_name FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet von dem Bezahlt werden soll:</td><td><select size="1" name="plani">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Planet wo die Ware hin soll:</td><td><select size="1" name="plani_ziel">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
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
$game->out('<input type="submit" value="Handel abschließen"  name="submit"></td></tr></form>');
$game->out('<tr><td colspan=2><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post"><tr><td colspan=2>');
$game->out('<input type="hidden" name="unit_1" value="'.$_POST['unit_1'].'">');
$game->out('<input type="hidden" name="unit_2" value="'.$_POST['unit_2'].'">');
$game->out('<input type="hidden" name="unit_3" value="'.$_POST['unit_3'].'">');
$game->out('<input type="hidden" name="unit_4" value="'.$_POST['unit_4'].'">');
$game->out('<input type="hidden" name="unit_5" value="'.$_POST['unit_5'].'">');
$game->out('<input type="hidden" name="unit_6" value="'.$_POST['unit_6'].'">');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
else{
if($_REQUEST['handel']=='kaufen_truppen' && $_REQUEST['step']=='2' && $_POST['unit_1']==0 && $_POST['unit_2']==0 && $_POST['unit_3']==0 &&  $_POST['unit_4']==0 && $_POST['unit_5']==0 && $_POST['unit_6']==0) $game->out('Du musst auch schon wo eine Zahl eintragen<br>');
if(!($daten['unit_1']>=$_POST['unit_1'] && $daten['unit_2']>=$_POST['unit_2']  && $daten['unit_3']>=$_POST['unit_3']  && $daten['unit_4']>=$_POST['unit_4'] && $daten['unit_5']>=$_POST['unit_5'] && $daten['unit_6']>=$_POST['unit_6'])) $game->out('Deine Eingaben sind größer als das was es zu kaufen gibt<br>');
	$truppen=$db->queryrow('SELECT * FROM `FHB_Handels_Lager` Limit 1');
	$game->out('<table align="center"><tr><td>Art</td><td>Einheiten</td><td align="left">Zum Verkauf</td></tr>');
	$game->out('<tr><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen&step=2').'" method="post"><td><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"></td><td><input type="text" name="unit_1" value="'.$_POST['unit_1'].'"></td><td>('.$truppen['unit_1'].')<td></td></tr>');
	$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit2_small.gif"></td><td><input type="text" name="unit_2" value="'.$_POST['unit_2'].'"></td><td>('.$truppen['unit_2'].')</td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"></td><td><input type="text" name="unit_3" value="'.$_POST['unit_3'].'"></td><td>('.$truppen['unit_3'].')</td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"></td><td><input type="text" name="unit_4" value="'.$_POST['unit_4'].'"></td><td>('.$truppen['unit_4'].')</td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"></td><td><input type="text" name="unit_5" value="'.$_POST['unit_5'].'"></td><td>('.$truppen['unit_5'].')</td></tr>');
$game->out('<tr><td><img src="'.$game->GFX_PATH.'menu_unit6_small.gif"></td><td><input type="text" name="unit_6" value="'.$_POST['unit_6'].'"></td><td>('.$truppen['unit_6'].')</td></tr>');
$game->out('<tr><td colspan="3"><input type="submit" value="Kaufen"  name="submit"></td></form></tr></table>');
}
}

function Show_Main_a()
{
	global $db,$ACTUAL_TICK;
	global $game,$RACE_DATA,$STRADE_MODULES,$sub_action;
	if($_REQUEST['note']=="sichern")
{
$_POST['hz_notepad']=htmlspecialchars($_POST['hz_notepad']);
if($db->query('UPDATE `trade_settings` SET handel_notepad="'.$_POST['hz_notepad'].'" WHERE user_id='.$game->player['user_id'].'')==false)
		{
		message(DATABASE_ERROR, 'Interner Datenbankfehler');
		}
}

	if(($anzahl=$db->num_rows($db->query('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id'].' ')))<1) 
	{
		if($db->query('INSERT INTO `trade_settings` ( `user_id` , `handel_notepad` ) VALUES ('.$game->player['user_id'].', "")')==false)
		{
		message(DATABASE_ERROR, 'Interner Datenbankfehler');
		}
	}
	if(($trade_settings=$db->query('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id'].''))==false) 
	{
		$game->out('<br><b>ERROR: -Bitte einem Admin melden - deine Trade Settings konnten nicht geladen werden</b><br>');
	}else{ 
	
	$settings=$db->queryrow('SELECT * FROM trade_settings WHERE user_id='.$game->player['user_id']);
	
	$game->out('<table><tr><td>');

	$anzahl_gesperrt=$db->queryrow('SELECT count(*) AS anzahl FROM user WHERE trade_tick!=0');
	 $sql_cv = 'SELECT b.user,b.trade_id FROM (bidding b)
				RIGHT JOIN (ship_trade t) ON b.trade_id=t.id				WHERE b.user='.$game->player['user_id'].' AND t.end_time>='.$ACTUAL_TICK.'';
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
	$ship_anzahl=$db->queryrow('SELECT count(*) AS anzahl FROM ship_trade WHERE scheduler_processed=0 AND start_time<='.$ACTUAL_TICK.' AND end_time>='.$ACTUAL_TICK.'');
	$game->out('<br><br>Truppen zum Verkauf:<br>
<li><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"> '.$anzahl_truppen['unit_1'].'</li><li><img src="'.$game->GFX_PATH.'menu_unit2_small.gif">  '.$anzahl_truppen['unit_2'].'</li><li><img src="'.$game->GFX_PATH.'menu_unit3_small.gif"> '.$anzahl_truppen['unit_3'].'</li><li><img src="'.$game->GFX_PATH.'menu_unit4_small.gif"> '.$anzahl_truppen['unit_4'].'</li><li><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"> '.$anzahl_truppen['unit_5'].'</li><li><img src="'.$game->GFX_PATH.'menu_unit6_small.gif">  '.$anzahl_truppen['unit_6'].'</li>Gesamt: '.($anzahl_truppen['unit_1']+$anzahl_truppen['unit_2']+$anzahl_truppen['unit_3']+$anzahl_truppen['unit_4']+$anzahl_truppen['unit_5']+$anzahl_truppen['unit_6']).'<br><br>Ress zum Verkauf:<br><li><img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.number_format($anzahl_truppen['ress_1'], 0, '.', '.').'</li><li><img src="'.$game->GFX_PATH.'menu_mineral_small.gif"> '.number_format($anzahl_truppen['ress_2'], 0, '.', '.').'</li><li><img src="'.$game->GFX_PATH.'menu_latinum_small.gif">  '.number_format($anzahl_truppen['ress_3'], 0, '.', '.').'</li>
Gesamt: '.number_format(($anzahl_truppen['ress_1']+$anzahl_truppen['ress_2']+$anzahl_truppen['ress_3']), 0, '.', '.').'<br>
<br>Laufende Gebote: '.$zzza.'<br>Laufende Auktionen: '.$ship_anzahl['anzahl'].'<br>Für Auktionen gesperrt: '.$anzahl_gesperrt['anzahl'].'<br><br>');
$t_gesamt = $db->queryrow('SELECT sum(unit_1) AS eins, sum(unit_2) AS zwei, sum(unit_3) AS drei, sum(unit_4) AS vier, sum(unit_5) AS fuenf, sum(unit_6) AS sechs FROM `FHB_handel_log` WHERE art=1');
$zeit=(($ACTUAL_TICK-34149)*3)/60;
$zeit=(int)$zeit;
$link='test<br>';
$catname='';
$game->out('Verkaufte Truppen:'.($t_gesamt['eins']+$t_gesamt['zwei']+$t_gesamt['drei']+$t_gesamt['vier']+$t_gesamt['fuenf']+$t_gesamt['sechs']).' (seit '.$zeit.'h)<br>
<li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_1_.png>\',CAPTION,\'Unit 1\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit1_small.gif">'.$t_gesamt['eins'].' - klicken</a></li><li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_2_.png>\',CAPTION,\'Unit 2\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit2_small.gif">'.$t_gesamt['zwei'].' - klicken</a></li><li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_3_.png>\',CAPTION,\'Unit 3\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit3_small.gif">'.$t_gesamt['drei'].' - klicken</a></li><li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_4_.png>\',CAPTION,\'Unit 4\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit4_small.gif">'.$t_gesamt['vier'].' - klicken</a></li><li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_5_.png>\',CAPTION,\'Unit 5\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit5_small.gif">'.$t_gesamt['fuenf'].' - klicken</a></li><li><a href="javascript:void(0);" onmouseover="return overlib(\'<img src=kurs/unit_6_.png>\',CAPTION,\'Unit 6\', '.OVERLIB_STANDARD.');" onmouseout="return nd();"><img src="'.$game->GFX_PATH.'menu_unit6_small.gif">'.$t_gesamt['sechs'].' - klicken</a></li>
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
$race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
}
$game->out('<br>Anteil der Rassen beim Verkauf von Truppen:<table width="150px" border="0" cellpadding="0" cellspacing="0">
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
                <td class="desc_row">'.$RACE_DATA[5][0].':</td>
                <td class="value_row">'.$race['racepercent_5'].'%</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.$RACE_DATA[8][0].':</td>
                <td class="value_row">'.$race['racepercent_8'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[9][0].':</td>
                <td class="value_row">'.$race['racepercent_9'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[10][0].':</td>
                <td class="value_row">'.$race['racepercent_10'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[11][0].':</td>
                <td class="value_row">'.$race['racepercent_11'].'%</b></td>
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
$race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
}
$game->out('<br>Anteil der Rassen beim Kauf von Truppen:<table width="150px" border="0" cellpadding="0" cellspacing="0">
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
                <td class="desc_row">'.$RACE_DATA[5][0].':</td>
                <td class="value_row">'.$race['racepercent_5'].'%</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.$RACE_DATA[8][0].':</td>
                <td class="value_row">'.$race['racepercent_8'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[9][0].':</td>
                <td class="value_row">'.$race['racepercent_9'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[10][0].':</td>
                <td class="value_row">'.$race['racepercent_10'].'%</b></td>
              </tr>
   <tr>
                <td class="desc_row">'.$RACE_DATA[11][0].':</td>
                <td class="value_row">'.$race['racepercent_11'].'%</b></td>
              </tr>
              <tr height="10"><td></td></tr>
            </table></td><td>');
if(($user_auktionen_offen=$db->query('SELECT st.auktions_id,st.timestep FROM (schulden_table st) WHERE st.status=0 AND st.user_ver='.$game->player['user_id'].''))==false){
       message(DATABASE_ERROR, 'Could not open auktions table list');
}else{
$game->out('<table><tr><td>Eigene Auktion die noch nicht bezahlt wurden:</td></tr>');
$zeahler_open=0;
while($user_auk_open=$db->fetchrow($user_auktionen_offen))
{
$zeahler_open++;
$game->out("<tr><td>Auktiosid: ><a href=".parse_link("a=trade&view=view_bidding_detail&id=".$user_auk_open['auktions_id']).">".$user_auk_open['auktions_id']."</a> -- Zeit:".((($schulden['timestep']+(20*24*6))-$ACTUAL_TICK)*3/60)." Minuten</td></tr>");
}
$game->out("<tr><td>Anzahl Nicht bezahlter eigener Auktionen: ".$zeahler_open."</td></tr></table>");
}
  $game->out('<table>');
$news=$db->query('SELECT MAX(b.tick) ticker, t.header,t.id FROM (FHB_bid_meldung b) LEFT JOIN ship_trade t on t.id=b.trade_id WHERE b.user_id!=(SELECT x.user FROM (bidding x) WHERE x.trade_id=b.trade_id ORDER BY max_bid DESC LIMIT 0,1) AND t.scheduler_processed=0 AND b.user_id='.$game->player['user_id'].' GROUP BY b.trade_id ORDER BY t.id DESC');
$zaehler_cc=0;
while($n_news=$db->fetchrow($news))
{
  $game->out('<tr><td>Vor '.(($ACTUAL_TICK-$n_news['ticker'])*3).'Minuten <br>Du wurdest bei <a href='.parse_link('a=trade&view=view_bidding_detail&id='.$n_news['id']).'>'.$n_news['header'].'</a> überboten<br></td></tr>');
  $zaheler_cc++;
}
$game->out('</table><br>'); 
            
         
            
	$game->out('</td></tr></table><br><center> Handelsnotepad:
<form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&note=sichern').'" target="_blank">
            <table width="270" border="0" cellpadding="0" cellspacing="0">
              <tr height="5"><td></td>
              <tr>
                <td width="100%" colspan="2">
                  <textarea name="hz_notepad" class="textfield" style="width: 270px;" rows="5">'.$settings['handel_notepad'].'</textarea>
                </td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
            <input type="submit" name="Update" class="button_nosize" width=45 value="Sichern">
            </form></center>');
	}
}

function Show_schulden($zustand=0)
{
global $db;
global $game,$UNIT_NAME,$ACTUAL_TICK;
if($_POST['metall']==null)$_POST['metall']=0;
if($_POST['mineralien']==null)$_POST['mineralien']=0;
if($_POST['latinum']==null)$_POST['latinum']=0;
if($_POST['unit1']==null)$_POST['unit1']=0;
if($_POST['unit2']==null)$_POST['unit2']=0;
if($_POST['unit3']==null)$_POST['unit3']=0;
if($_POST['unit4']==null)$_POST['unit4']=0;
if($_POST['unit5']==null)$_POST['unit5']=0;
if($_POST['unit6']==null)$_POST['unit6']=0;

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
if($_REQUEST['status_bezahlen']==2 && !($c_1['unit_1']<$_POST['unit1'] || $c_1['unit_2']<$_POST['unit2'] || $c_1['unit_3']<$_POST['unit3'] || $c_1['unit_4']<$_POST['unit4'] || $c_1['unit_5']<$_POST['unit5'] || $c_1['unit_6']<$_POST['unit6'] || $c_1['resource_1']<$_POST['metall'] || $c_1['resource_2']<$_POST['mineralien'] || $c_1['resource_3']<$_POST['latinum'] ))
	{
		$zustand_b=0;
		$zustand_a=0;
		if(($k_1=$db->queryrow('SELECT * FROM treuhandkonto WHERE code="'.$_REQUEST['auktion'].'"'))==false){message(DATABASE_ERROR, 'Could select konto data data');}
		if(($s_1=$db->queryrow('SELECT * FROM schulden_table WHERE id="'.$_REQUEST['auktion'].'"'))==false){message(DATABASE_ERROR, 'Could select schulden data data');}

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
			$game->out("<center>Einzahlung erfolgreich</center>");			
		}else{
			message(DATABASE_ERROR, 'Could not update konto data');
		}
        //Meldung posten
		if($zustand_a==0)
		{
			$game->out('<center><b>Alle Schulden auf diesem Konto bezahlt</b></center>');
        }
	}else{message(DATABASE_ERROR, 'Could select schulden data data');}
}


$sql_a='SELECT * FROM schulden_table WHERE status=0 AND user_kauf="'.$game->player['user_id'].'"';
$schulden_a=$db->query($sql_a);
$text='<br><center><table boder=0 cellpadding="3" cellspacing="3" class="style_inner"><tr><td>Auktion</td><!--<td>Verkäufer</td>--><td>Metall</td><td>Mineralien</td><td>Latinum</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>Techniker</td><td>Mediziner</td><td>Zeit bis Ende der Frist</td><td></td></tr>
<tr><td colspan="12"><hr></td></tr>';
if($db->num_rows()<=0)
{
	$text.='<tr><td colspan="12"><center>Keine Schulden vorhanden</center></td></tr>';
}else{
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
		$text.="".$timea." Minuten</td>";
		$text.='<td><form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&status_bezahlen=1').'">
<input type="hidden" name="auktion" value="'.$schulden['id'].'">
<input type="submit" name="zahlen" class="Button_nosize" value="Bezahlen" style="width:100px"></form>
</td>';
		$text.="</tr>";
	}
	}
$game->out('<center><span class="sub_caption">Auktionsschulden: <!--'.HelpPopup('trade_viewstatus').'--> :</span></center><br>');
$game->out($text);
$game->out('</table></center>');
if($_REQUEST['status_bezahlen']==1)
	{
	$planet_data=$db->queryrow('SELECT planet_name FROM planets WHERE planet_id='.$game->player['active_planet'].'');
		$game->out('<br><center>Bezahlung für Auktion '.$_REQUEST['auktion'].':</center><br>
		Auf dem Planeten '.$planet_data['planet_name'].' vorhanden: <br>
		<form method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&status_bezahlen=2').'">
		<table boder=0 cellpadding="3" cellspacing="3" class="style_inner" width=300><tr>
<td>Metall</td><td>Mineralien</td><td>Latinum</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>Techniker</td><td>Mediziner</td><td></td></tr>
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
		<input type="submit" name="einzahlen" class="Button_nosize" value="Einzahlen" style="width:100px"></td>
		</tr></table></form>');
	} 

}

function ship_pick()
{
    //[02:05] <Karnickl> [02:04:12] <Exekutor4> hm kein wunder das er unübersichtlich ist^^ <-- 5k zeilen code. 4500 sind müll *duck*
    //[02:14] <Exekutor4> naja wenn ihr die stgc'ler mal bestrafen wollt dann könnt ihr tap den source geben^^
    //[02:17] <Karnickl> @sci. kein wunder, dass nix fertig wird *g* zu tap+source=w.bush+macht
	global $db;
	global $game,$ACTUAL_TICK;

$game->out('<center><span class="sub_caption">Schiffabhohl Stelle: '.HelpPopup('ship_avis').' :</span></center><br>');

$ships=$_POST['ship_auswahl'];

$_POST['plani_ziel']=(int)$_POST['plani_ziel'];

if($_REQUEST['handel']=='ship_send' && $_POST['plani_ziel']!=null && $_REQUEST['step']=='2' && $ships[0]!=null)
{
$plani_id_a=$db->queryrow('SELECT planet_id,planet_name FROM `planets` WHERE planet_id='.$_POST['plani_ziel'].' AND planet_owner='.$game->player['user_id'].'');
if($plani_id_a['planet_id']!=$_POST['plani_ziel'])
{
	$game->out('<br>Ich schätze cheaten, ein Bug wäre eher unwahrscheinlicher<br>');
}else
{
$where_frage="";
$zaehler=0;
for($i=0; $i < count($ships); $i++) {
if($i==0) {$where_frage.="( w.ship_id=".$ships[$i]." ";}else{
$where_frage.=" OR w.ship_id=".$ships[$i]." ";}
$zaehler++;
}

if($_POST['transportsart']!=1 && $_POST['transportsart']!=2 && $_POST['transportsart']!=3)  {$game->out('Cheat'); exit;}
if($_POST['transportsart']==1) {$transportsatz=0.30;$tickzeit=20*6;}
if($_POST['transportsart']==2) {$transportsatz=0.15;$tickzeit=20*12;}
if($_POST['transportsart']==3) {$transportsatz=0;$tickzeit=20*36;}
$Bot = $db->queryrow('SELECT planet_id FROM FHB_Bot');
$db->lock('ships','ship_fleets','FHB_warteschlange w','FHB_logging_ship','scheduler_shipmovement','schulden_table s','FHB_warteschlange');
if(($npc_ships_wait=$db->query('SELECT w.* FROM (FHB_warteschlange w) LEFT JOIN schulden_table s on s.ship_id=w.ship_id WHERE (s.status=1 OR s.status IS NULL) AND user_id='.$game->player['user_id'].' AND '.$where_frage.')'))==true){
if($db->query('INSERT INTO ship_fleets (fleet_name, user_id, planet_id, move_id, n_ships)
                    VALUES ("Auktionsflotte '.((int)($ACTUAL_TICK/2)).'", '.$game->player['user_id'].', '.$Bot['planet_id'].', 0, '.$zaehler.')'))
{

$fleet_id=$db->insert_id();
$xxx=0;
while($npc_ships_wait_t=$db->fetchrow($npc_ships_wait))
{
  if(!$db->query('UPDATE ships SET fleet_id='.$fleet_id.',ship_untouchable=0,user_id='.$game->player['user_id'].' WHERE ship_id='.$npc_ships_wait_t['ship_id'].''))message(DATABASE_ERROR, 'Could not insert new movement data');
  $xxx++;
}
if($xxx!=0){
        if(!$db->query('INSERT INTO scheduler_shipmovement (user_id, move_status, move_exec_started, start, dest, total_distance, remaining_distance, tick_speed, move_begin, move_finish, n_ships, action_code, action_data)
                VALUES ('.$game->player['user_id'].', 0, 0, '.$Bot['planet_id'].', '.$_POST['plani_ziel'].', 0, 0, 0, '.$ACTUAL_TICK.', '.($ACTUAL_TICK + $tickzeit).', '.$zaehler.', 11, "")')) {
            message(DATABASE_ERROR, 'Could not insert new movement data');
        }else{
        $new_move_id = $db->insert_id();
        if(!$db->query('UPDATE ship_fleets
                SET planet_id = 0,
                    move_id = '.$new_move_id.'
                WHERE fleet_id='.$fleet_id.'')) {
            message(DATABASE_ERROR, 'Could not update fleets position data');
        }
        $game->out('<table><tr><td>Das Schiff ist unterwegs zu dir, es wird dringends davon abgeraten das Schiff zurück zum Startplanet zu schicken.</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td><tr><td><!--Steuerkosten:'.$steuern.'--></td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kaufen_truppen').'" method="post">
<input type="submit" value="Zurück"  name="submit"></td></tr></table>');
if(($npc_ships_wait=$db->query('SELECT w.* FROM (FHB_warteschlange w) LEFT JOIN schulden_table s on s.ship_id=w.ship_id WHERE (s.status=1 OR s.status IS NULL) AND user_id='.$game->player['user_id'].' AND '.$where_frage.')'))==false)message(DATABASE_ERROR, 'Could select ships from Bot');
while($npc_ships_wait_t=$db->fetchrow($npc_ships_wait))
{
  if(!$db->query('DELETE FROM FHB_warteschlange WHERE id='.$npc_ships_wait_t['id'].''))message(DATABASE_ERROR, 'Could not Delete from Bot');
  if(!$db->query('INSERT INTO `FHB_logging_ship` (`tick` , `user_id` , `ship_id` ) VALUES ('.$ACTUAL_TICK.','.$game->player['user_id'].','.$npc_ships_wait_t['ship_id'].')'))message(DATABASE_ERROR, 'Could not logging');
}
        }
}else
    {
$game->out('<br><b>Keine Schiffe ausgewählt</b><br>');
$db->unlock('ships','ship_fleets','FHB_warteschlange w','FHB_logging_ship','scheduler_shipmovement','schulden_table s','FHB_warteschlange');
$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=ship_send').'" method="post"><tr><td>');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
}
}else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}
}else{message(DATABASE_ERROR, 'Interner Datenbankfehler');}
$db->unlock('ships','ship_fleets','FHB_warteschlange w','FHB_logging_ship','scheduler_shipmovement','schulden_table s','FHB_warteschlange');
}
}
else
{
if(($npc_ships_wait=$db->query('SELECT w.* FROM (FHB_warteschlange w) LEFT JOIN schulden_table s on s.ship_id=w.ship_id WHERE (s.status=1 OR s.status IS NULL) AND user_id='.$game->player['user_id'].''))==false){
       message(DATABASE_ERROR, 'Could not open ship wait list');
}else{
if($db->num_rows()<=0)
{
	$game->out('<center>Keine Schiffe zum abhohlen vorhanden</center>');
}else{
$game->out('<table>');

$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=ship_send&step=2').'" method="post">');

$game->out('<tr><td>Transport:</td><td><select size="1" name="transportsart">
   <option value="1">Ferengi Spezialtansport (6h) - 0% Steuern</option>
   <!-- <option value="1">Ferengi Spezialtansport (6h) - 30% Steuern</option>-->
   <!--<option value="2">Fernegi Transport  (12h) - 15% Steuern</option>-->
   <!--<option value="3">Galaxy Post (36h) - 0% Steuern</option>-->
   </select></td></tr><tr><td colspan=2><br>*Die Ferengie Handelsgilde übernimmt keine Haftung für verloren Gegangene Ladung. Bei der Post übernehmen wir nicht mal die Tapianische Sicherheit.</td></tr>');
$sql='SELECT planet_id,planet_name FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Ziel Planet für das Schiff/die Schiffe:</td><td><select size="1" name="plani_ziel">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
$game->out('<tr><td colspan=2><br>');
while($npc_ships_wait_t=$db->fetchrow($npc_ships_wait))
{
$ship = $db->queryrow('SELECT s.ship_id, s.hitpoints, s.unit_1,s.unit_2,s.unit_3,s.unit_4,st.max_unit_1,st.max_unit_2,st.max_unit_3,st.max_unit_4,st.name AS template_name, st.value_5 AS max_hitpoints
			FROM (ships s) INNER JOIN (ship_templates st) ON st.id = s.template_id WHERE s.ship_id='.$npc_ships_wait_t['ship_id'].'');

if (($ship['max_unit_1']+$ship['max_unit_2']+$ship['max_unit_3']+$ship['max_unit_4'])*($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4'])>0)

        {

		$besatzung=100/($ship['max_unit_1']+$ship['max_unit_2']+$ship['max_unit_3']+$ship['max_unit_4'])*($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4']);

		if ($besatzung!=100) $b_title=' B='.round($besatzung,0).'%';

        }

$game->out('<input name="ship_auswahl[]" type="checkbox" id="ship_auswahl[]" value="'.$npc_ships_wait_t['ship_id'].'"> '.$ship['template_name'].' ('.$ship['hitpoints'].'/'.$ship['max_hitpoints'].')'.$b_title.'<br>');
}
$game->out('<br><br><input type="submit" value="Schiff schicken"  name="submit"></td></tr></form></table>');
}
}

}
}

function konto_sold()
{
	global $db;
	global $game,$ACTUAL_TICK;

if($_POST['metall']==null)$_POST['metall']=0;
if($_POST['mineralien']==null)$_POST['mineralien']=0;
if($_POST['latinum']==null)$_POST['latinum']=0;
if($_POST['unit1']==null)$_POST['unit1']=0;
if($_POST['unit2']==null)$_POST['unit2']=0;
if($_POST['unit3']==null)$_POST['unit3']=0;
if($_POST['unit4']==null)$_POST['unit4']=0;
if($_POST['unit5']==null)$_POST['unit5']=0;
if($_POST['unit6']==null)$_POST['unit6']=0;

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


$game->out('<center><span class="sub_caption">Konto Auszahlung: '.HelpPopup('konto').' :</span></center><br>');

$_POST['plani_ziel']=(int)$_POST['plani_ziel'];

if($_REQUEST['handel']=='kontoauszahlung' && $_POST['plani_ziel']!=null && $_REQUEST['step']=='2' && ($_POST['unit1']!=0 || $_POST['unit2']!=0 || $_POST['unit3']!=0 ||  $_POST['unit4']!=0 || $_POST['unit5']!=0 || $_POST['unit6']!=0 || $_POST['metall']!=0 || $_POST['mineralien']!=0 || $_POST['latinum']!=0))
{
if(($konto_full=$db->query('SELECT s.status,s.id,t.* FROM (schulden_table s) LEFT JOIN (treuhandkonto t) ON s.id=t.code WHERE status=1 AND user_ver='.$game->player['user_id'].''))==false){
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
	$game->out('<br>Ich schätze cheaten, ein Bug wäre eher unwahrscheinlicher<br>');
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
if (($db->query($sql))==true){$game->out('<table><tr><td>Die Truppen und Rohstoffe sind unterwegs zu dir</td></tr><tr><td>Ziel Planet:'.$plani_id_a['planet_name'].'</td><tr><td><!-- Steuerkosten:'.$steuern.' --></td></tr><tr><td>Lv1:'.$_POST['unit1'].'<br>Lv2:'.$_POST['unit2'].'<br>Lv3:'.$_POST['unit3'].'<br>Lv4:'.$_POST['unit4'].'<br>Lv5:'.$_POST['unit5'].'<br>Lv6:'.$_POST['unit6'].'<br>Metall:'.$_POST['metall'].'<br>Mineral: '.$_POST['mineralien'].'<br>Latinum: '.$_POST['latinum'].'</td></tr><tr><td><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung').'" method="post"><input type="submit" value="Zurück"  name="submit"></td></tr></table>'); //}
$db->unlock('scheduler_resourcetrade','schulden_table s','treuhandkonto t', 'treuhandkonto', 'schulden_table');
}
}else{
message(DATABASE_ERROR, 'Interner Datenbankfehler - X is Null');
}
}else
    {
$db->unlock('scheduler_resourcetrade','schulden_table s','treuhandkonto t', 'treuhandkonto', 'schulden_table');
message(DATABASE_ERROR, 'Could not select data');
$game->out('<table><form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung').'" method="post"><tr><td>');
$game->out('<input type="submit" value="Zurück"  name="submit"></td></tr></form></table>');
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
$game->out('<center>Keine Konten vorhanden</center>');
}else{
$game->out('<table>');

$game->out('<form action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&handel=kontoauszahlung&step=2').'" method="post">');

$game->out('<tr><td>Transport:</td><td><select size="1" name="transportsart">
   <option value="1">Ferengi Spezialtansport (6h) - 0% Steuern</option>
   <!--<option value="1">Ferengi Spezialtansport (6h) - 30% Steuern</option>-->
   <!--<option value="2">Fernegi Transport  (12h) - 15% Steuern</option>-->
   <!--<option value="3">Galaxy Post (36h) - 0% Steuern</option>-->
   </select></td></tr><tr><td colspan=2><br>*Die Ferengie Handelsgilde übernimmt keine Haftung für verloren Gegangene Ladung. Bei der Post übernehmen wir nicht mal die Tapianische Sicherheit.</td></tr>');
$sql='SELECT planet_id,planet_name FROM `planets` WHERE planet_owner='.$game->player['user_id'].' ORDER BY planet_name ASC';
if(($planis=$db->query($sql))==false)
{
	$game->out('<br><br>Hm da gibts ein Fehler - Bug oder Cheat das ist hier die Frage<br><br>');
}else{
$game->out('<tr><td>Ziel Planet für die Ware:</td><td><select size="1" name="plani_ziel">');
while($planeten=$db->fetchrow($planis))
{
	if ($game->planet['building_11']>0)$game->out('<option value="'.$planeten['planet_id'].'">'.$planeten['planet_name'].'</option>');
}
$game->out('</select></td></tr>');
}
$game->out('<tr><td colspan=2><br>');
$game->out('<br><center><table boder=0 cellpadding="3" cellspacing="3" class="style_inner" width=300><tr><td>Metall</td><td>Mineralien</td><td>Latinum</td><td>Lv1</td><td>Lv2</td><td>Lv3</td><td>Lv4</td><td>Techniker</td><td>Mediziner</td><td></td></tr>
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


$game->out('<tr><td colspan="2"><input type="submit" value="Auszahlen"  name="submit"></td></tr></form></table>');
}
}

}
}
function own_bids()
{
global $db;
global $game,$ACTUAL_TICK,$NEXT_TICK;

$per_page=20;


if (isset($_GET['trigger']) && $_GET['trigger']==1) $game->option_store('type_0',(int)(1-$game->option_retr('type_0',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==2) $game->option_store('type_1',(int)(1-$game->option_retr('type_1',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==3) $game->option_store('type_2',(int)(1-$game->option_retr('type_2',1)));
if (isset($_GET['trigger']) && $_GET['trigger']==4) $game->option_store('type_3',(int)(1-$game->option_retr('type_3',1)));


$_POST['type_0']=$game->option_retr('type_0',1);
$_POST['type_1']=$game->option_retr('type_1',1);
$_POST['type_2']=$game->option_retr('type_2',1);
$_POST['type_3']=$game->option_retr('type_3',1);

if ($_POST['type_0']) $sels[]=0;
if ($_POST['type_1']) $sels[]=1;
if ($_POST['type_2']) $sels[]=2;
if ($_POST['type_3']) $sels[]=3;
if (empty($sels)) $sels[]=4;

$game->out('
<script language="JavaScript">
function ConfirmClick(text,link)
{
	if (confirm(text)==true)
	{
    location.href=link;
	}
}
</script>');

if ($own_only==0) $str_compare='<>';
else {$str_compare='=';}

    $own_system = $db->queryrow('SELECT system_global_x, system_global_y FROM starsystems WHERE system_id = '.$game->planet['planet_system']);

    $sql = 'SELECT s.*,u.user_name,COUNT(b.id) AS num_bids FROM (ship_trade s)
				LEFT JOIN (user u) ON u.user_id=s.user
				LEFT JOIN (bidding b) ON b.trade_id=s.id
				LEFT JOIN (ships sh) ON sh.ship_id=s.ship_id
				LEFT JOIN (ship_templates t) ON t.id=sh.template_id
				WHERE s.user '.$str_compare.' '.$game->player['user_id'].' AND b.user='.$game->player['user_id'].' AND s.end_time>='.$ACTUAL_TICK.' AND t.ship_class IN ('.implode(',', $sels).') GROUP BY s.id ORDER BY s.end_time ASC
				';

    if(($tradedata = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Interner Datenbankfehler');
    }
    $nr = 0;


	$str_firstfield='Entfernung';
	if ($own_only) $str_firstfield='Anzahl';
	$str_lastfield='Verkäufer';
	if ($own_only) $str_lastfield='Optionen';

	$str_own='';
	if ($own_only) $str_own='Eigene ';

	$game->out('<center><span class="sub_caption">'.$str_own.' Laufende Gebote '.HelpPopup(($own_only==true ? 'trade_viewownauction' : 'trade_viewauction')).' :</span></center><br>');
	// Men << >>
	$game->out('<br><center><table boder=0 cellpadding=2 cellspacing=2 class="style_inner" width=300><tr>
		<td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']-1)).'"><< Zurück</a>
		</td><td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']+1)).'">Vorwärts >></a>
		</td></tr></table><br>');

		
		
		
		$game->out('<center>
	<table border=0 cellpadding=1 cellspacing=1 class="style_outer"><tr><td>
	<span class="sub_caption2">Folgende Schiffsklassen zeigen :</span><br>
	<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width=300>
	<tr>
	<td width=150 valign=top>
	<form name="type0form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=1&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_0" value="1"'.(($_POST['type_0']==1) ? ' checked="checked"' : '' ).'  onChange="document.type0form.submit()">Zivile Schiffe / Scout</form>
	</td><td width=150 valign=top>
	<form name="type1form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=2&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_1" value="1"'.(($_POST['type_1']==1) ? ' checked="checked"' : '' ).'  onChange="document.type1form.submit()">Leichte Schiffe</form>
	</td></tr><td>
	<form name="type2form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=3&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_2" value="1"'.(($_POST['type_2']==1) ? ' checked="checked"' : '' ).'  onChange="document.type2form.submit()">Mittlere Schiffe</form>
	</td><td>
	<form name="type3form" method="post" action="'.parse_link('a=trade&view='.$_REQUEST['view'].'&trigger=4&page='.($_REQUEST['page'])).'"><input type="checkbox" name="type_3" value="1"'.(($_POST['type_3']==1) ? ' checked="checked"' : '' ).'  onChange="document.type3form.submit()">Schwere Schiffe</form>
        </td>
	</tr></table>
	</td>
	</tr></table>
	</center><br>');

		
		
	$game->out('<center><table border=0 cellpadding=2 cellspacing=2 width=530 class="style_outer">');
	
	
	if (!isset($_REQUEST['page']) || $_REQUEST['page']<0) $_REQUEST['page']=0;

	$game->out('<tr><td width=530>
	<span class="sub_caption2">Auktionen (Seite '.($_REQUEST['page']+1).' von ~'.round(count($tradedata)/$per_page+1).')</span>');



    $game->out('<table border=0 cellpadding=4 cellspacing=0 width=530 class="style_inner">
	<tr><td width=235><b>Artikel:</u></td><td width=200><b>Preis:</u></td><td width=25><b>#:</b></td><td width=70><b>Restzeit:</b></td>');


	for ($t=$_REQUEST['page']*$per_page; $t<$_REQUEST['page']*$per_page+$per_page; $t++)
	{
	if (isset($tradedata[$t]))
		{
	        if ($tradedata[$t]['num_bids']<1)
			{
	            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.$tradedata[$t]['resource_1'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.$tradedata[$t]['resource_2'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.$tradedata[$t]['resource_3'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.$tradedata[$t]['unit_1'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.$tradedata[$t]['unit_2'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.$tradedata[$t]['unit_3'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.$tradedata[$t]['unit_4'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.$tradedata[$t]['unit_5'];
	            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.$tradedata[$t]['unit_6'];
			}
			else
			{
	            $prelast_bid=$db->queryrow('SELECT * FROM bidding  WHERE trade_id = "'.$tradedata[$t]['id'].'" ORDER BY max_bid DESC LIMIT 1,1');
				// Um zu testen, ob ein Gleichstand besteht, dann wird ja nicht max_bid +1
				$last_bid=$db->queryrow('SELECT * FROM bidding WHERE trade_id = "'.$tradedata[$t]['id'].'" ORDER BY max_bid DESC LIMIT 1');
				if ($last_bid['max_bid']!=$prelast_bid['max_bid'])
				{
		            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.($tradedata[$t]['resource_1']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_1']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.($tradedata[$t]['resource_2']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_2']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.($tradedata[$t]['resource_3']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_resource_3']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.($tradedata[$t]['unit_1']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_1']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.($tradedata[$t]['unit_2']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_2']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.($tradedata[$t]['unit_3']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_3']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.($tradedata[$t]['unit_4']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_4']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.($tradedata[$t]['unit_5']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_5']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.($tradedata[$t]['unit_6']+($prelast_bid['max_bid']+1)*$tradedata[$t]['add_unit_6']);
				}
				else
				{
		            $actual_price= '<img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.($tradedata[$t]['resource_1']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_1']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.($tradedata[$t]['resource_2']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_2']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.($tradedata[$t]['resource_3']+($prelast_bid['max_bid'])*$tradedata[$t]['add_resource_3']);
		            $actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.($tradedata[$t]['unit_1']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_1']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.($tradedata[$t]['unit_2']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_2']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.($tradedata[$t]['unit_3']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_3']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.($tradedata[$t]['unit_4']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_4']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.($tradedata[$t]['unit_5']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_5']);
                	$actual_price.='&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.($tradedata[$t]['unit_6']+($prelast_bid['max_bid'])*$tradedata[$t]['add_unit_6']);
				}
			}
			$font_color='#ffffff';
			$font_bold='';
			if ($tradedata[$t]['font_bold']) $font_bold='<b>';
			if ($tradedata[$t]['font_colored']) $font_color='#ffaaaa';

			$game->out('<tr onMouseOver="mOver(this);" onMouseOut="mOut(this);" onClick="location.href=\''.parse_link('a=trade&view=view_bidding_detail&id='.$tradedata[$t]['id']).'\'"  color:'.$font_color.';">
				<td>'.$font_bold.$tradedata[$t]['header'].'</b></td><td>'.$font_bold.$actual_price.'</b></td><td>'.$font_bold.$tradedata[$t]['num_bids'].'</b></td><td>'.$font_bold.Zeit(TICK_DURATION*($tradedata[$t]['end_time']-$ACTUAL_TICK)+round($NEXT_TICK/60,0)).'</b></td></tr>');
	    }

	}


	$game->out('</table></td></tr></table>');
	// Men << >>
	$game->out('<br><center><table boder=0 cellpadding=2 cellspacing=2 class="style_inner" width=300><tr>
		<td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']-1)).'"><< Zurück</a>
		</td><td width=150 align=middle><a href="'.parse_link('a=trade&view='.$_REQUEST['view'].'&page='.($_REQUEST['page']+1)).'">Vorwärts >></a>
		</td></tr></table>');
}



if ($game->planet['building_11']<1)
{
$game->out('<center><span class="caption">'.$BUILDING_NAME[$game->player['user_race']]['10'].'</span><br><br><center><span class="text_large">Du musst ein(e) '.$BUILDING_NAME[$game->player['user_race']]['10'].' bauen, bevor du Handel betreiben kannst.</span></center><br><br>');
} else{
if ($game->player['trade_tick']>0) $game->player['deny_trade']=1;
else $game->player['deny_trade']=0;
$sub_action = (!empty($_GET['view'])) ? $_GET['view'] : 'main';
$game->out('<center><span class="sub_caption">Galaxy Handelszentrum von Ursa Mirror</span></center><br><b>Bereiche des Handelszentrums:</b><br>'.display_view_navigation_extended('trade', $sub_action, $STRADE_MODULES,1).'</center>');
$game->out('	<center><table border=0 cellpadding=1 cellspacing=1 class="style_inner" width="690"><tr><td>');

if($sub_action=='main')
	{		Show_Main_a();	}
elseif($sub_action=='trade_buy_truppen')
	{		if ($game->player['deny_trade'])
Show_BidDenied();
else
Trade_Buy_truppen();	}
elseif($sub_action=='warteschlange')
	{		ship_pick();	}
elseif($sub_action=='konto_status')
	{			konto_sold();	}	
elseif($sub_action=='trade_sold_truppen')
	{		if ($game->player['deny_trade'])
Show_BidDenied();
else
Trade_Sold_truppen();	}
elseif($sub_action=='trade_ress')
	{		if ($game->player['deny_trade'])
Show_BidDenied();
else
Trade_Ress();	}
elseif ($sub_action=='status_offer')
{
Show_Status();
}
else
if ($sub_action=='create_bidding')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
Show_CreateBidding();}
}
else
if ($sub_action=='view_bidding')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
Show_Bidding();}
}
else
if ($sub_action=='own_bidding')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
own_bids();}
}
else
if ($sub_action=='view_own_bidding')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
Show_Bidding(1);}
}
else
if ($sub_action=='view_bidding_detail')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
Show_Bidding_Detail();}
}
else
if ($sub_action=='submit_bid')
{
if ($game->player['deny_trade'])
{Show_BidDenied();}
else
{if ($game->player['user_points']<400 && ($game->player['user_id']>12 && $game->player['user_id']!=62 ) )
$game->out('Auktionen sind erst ab 400Punkte möglich');
else
Submit_Bid();}
}
else
if ($sub_action=='cancel_bid')
{
Cancel_Bid();
}
elseif ($sub_action=='status_bezahlen')
{
Show_schulden();
}
else
	{
		Show_Main_a();
	}
$game->out('</td></tr></table></center>');
}
?>
