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

/*
include('include/static/static_components.php');
$filename = 'include/static/static_components_'.$game->player['language'].'.php';
if (file_exists($filename)) include($filename);
*/

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');

function TimeDetailShort($seconds)
{
	$minutes=0;
	while($seconds >= 60) {
		$minutes++;
		$seconds -= 60;
	}
	return round($minutes, 0).'m '.round($seconds, 0).'s';
}


function Ships_List($focus=0,$search_name="")
{
	global $db,$game,$UNIT_NAME,$NEXT_TICK,$ACTUAL_TICK;

	/* AC: Get search name */
	$search_name=htmlspecialchars($_REQUEST['search']);

	/* AC: Check query focus */
	if (isset($_REQUEST['start'])) {$focus=$_REQUEST['start'];}

	/* AC: Check chosen ordering method */
	if (!isset($_REQUEST['order']) || empty($_REQUEST['order'])) $_REQUEST['order']=1;

	/* Filter ship's type */ 
	if (isset($_GET['filter']) && $_GET['filter']==1)
		$game->option_store('stype_0',(int)(1-$game->option_retr('stype_0',1)));
	if (isset($_GET['filter']) && $_GET['filter']==2)
		$game->option_store('stype_1',(int)(1-$game->option_retr('stype_1',1)));
	if (isset($_GET['filter']) && $_GET['filter']==3)
		$game->option_store('stype_2',(int)(1-$game->option_retr('stype_2',1)));
	if (isset($_GET['filter']) && $_GET['filter']==4)
		$game->option_store('stype_3',(int)(1-$game->option_retr('stype_3',1)));

	$_POST['stype_0']=$game->option_retr('stype_0',1);
	$_POST['stype_1']=$game->option_retr('stype_1',1);
	$_POST['stype_2']=$game->option_retr('stype_2',1);
	$_POST['stype_3']=$game->option_retr('stype_3',1);

	if ($_POST['stype_0']) $sels[]=0;
	if ($_POST['stype_1']) $sels[]=1;
	if ($_POST['stype_2']) $sels[]=2;
	if ($_POST['stype_3']) $sels[]=3;
	if (empty($sels)) $sels[]=4;
	/* */

	$queryfocus=$focus;

	/* AC: Query user ships ordered by shiptorso */
	$ordermethod = 'st.ship_torso DESC,s.ship_name, fl.fleet_name, pl.planet_name, s.ship_scrap,s.ship_repair,st.name ASC';

	/* AC: Query user ships ordered by name */
	if ($_REQUEST['order']==2)
	{
		$ordermethod = 's.ship_name ASC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* AC: Query user ships ordered by position */
	else if ($_REQUEST['order']==3)
	{
		$ordermethod = 'pl.planet_name, fl.fleet_name ASC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* AC: Query user ships ordered by hitpoints */
	else if ($_REQUEST['order']==4)
	{
		$ordermethod = 's.hitpoints DESC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* AC: Query user ships ordered by AwayTeam Level */
	else if ($_REQUEST['order']==5)
	{
		$ordermethod = 's.awayteam ASC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* Ordered by shiptorso reversed */
	else if ($_REQUEST['order']==-1)
	{
		$ordermethod = 'st.ship_torso ASC,s.ship_name, fl.fleet_name, pl.planet_name, s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* Ordered by name reversed */
	else if ($_REQUEST['order']==-2)
	{
		$ordermethod = 's.ship_name DESC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* Ordered by position reversed */
	else if ($_REQUEST['order']==-3)
	{
		$ordermethod = 'pl.planet_name, fl.fleet_name DESC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* Ordered by hitpoints reversed */
	else if ($_REQUEST['order']==-4)
	{
		$ordermethod = 's.hitpoints ASC,s.ship_scrap,s.ship_repair,st.name ASC';
	}
	/* Ordered by Away Team Level reversed */
	else if ($_REQUEST['order']==-5)
	{
		$ordermethod = 's.awayteam DESC,s.ship_scrap,s.ship_repair,st.name ASC';
	}

	$shipsxpage = 20;

	/* Vary number of displayable ships per page according max number of ships owned */
	$sql = 'SELECT COUNT(ship_id) AS n_ships
			FROM (ships s)
			INNER JOIN (ship_templates st) ON st.id = s.template_id
			WHERE user_id = '.$game->player['user_id'].' AND st.ship_class IN ('.implode(',', $sels).')';
	$n_ships = $db->queryrow($sql);
	if($n_ships['n_ships'] > 500)
		$shipsxpage = 100;


	$sql = 'SELECT s.ship_id, s.hitpoints, s.ship_repair, s.ship_scrap, s.ship_untouchable, s.awayteam, s.awayteamplanet_id,
			s.unit_1,s.unit_2,s.unit_3,s.unit_4, s.ship_name, s.ship_ncc, s.fleet_id,
			s.construction_time, st.max_unit_1,st.max_unit_2,st.max_unit_3,st.max_unit_4,
			st.name AS template_name, st.value_5 AS max_hitpoints, fl.fleet_name,
			fl.planet_id AS fleet_target, pl.planet_name, pl2.planet_name AS mission_planet
			FROM (ships s)
			INNER JOIN (ship_templates st) ON st.id = s.template_id
			LEFT JOIN (ship_fleets fl) ON fl.fleet_id = s.fleet_id
			LEFT JOIN (planets pl) ON pl.planet_id = ABS(s.fleet_id)
                        LEFT JOIN (planets pl2) ON pl2.planet_id = s.awayteamplanet_id
			WHERE s.user_id = '.$game->player['user_id'].'
			AND st.ship_class IN ('.implode(',', $sels).') ORDER BY '.$ordermethod.' LIMIT '.$queryfocus.','.$shipsxpage;

	$shipquery = $db->query($sql);

	$game->out(constant($game->sprache("TEXT1")).'<br><br>');


	/* AC: Searching ship */
	$game->out('<br><table border=0 cellpadding=1 cellspacing=1  class="style_outer" width=300><tr><td>
		<table border=0 cellpadding=2 cellspacing=2  class="style_inner" width=300>
		<tr>
			<td align="center" valign="middle">
				<form method="post" action="'.parse_link('a=ships&view=ships_list&order='.$_REQUEST['order']).'">
				<input type="text" name="search" size="16" class="field" value="'.htmlspecialchars($_REQUEST['search']).'">
			</td>
			<td align="center" valign="middle">
				<input type="submit" name="exec_search" class="button" width=100 value="'.constant($game->sprache("TEXT2")).'">
				</form>
			</td>
		</tr>
		</table>
	</td></tr>
	</table>');

	/* AC: If we have to search ships */
	if($search_name!="" && $focus==0)
	{
		$game->out('<br><table border=0 cellpadding=1 cellspacing=1  class="style_outer" width=300><tr><td>
		<table border=0 cellpadding=2 cellspacing=2 class="style_inner" width=300>
			<tr>
				<td width=150>
					<b>'.constant($game->sprache("TEXT3")).'</b>
				</td>
				<td>
					<b>'.constant($game->sprache("TEXT5")).'</b>
				</td>
			</tr>');

		$search_ships=$db->query('SELECT ship_name, ship_id, st.name AS template_name
					FROM (ships s) INNER JOIN (ship_templates st) ON st.id = s.template_id
					WHERE ship_name LIKE "%'.$_REQUEST['search'].'%" AND user_id = '.$game->player['user_id'].' ORDER by ship_name ASC');
		while (($ship = $db->fetchrow($search_ships)) != false)
		{
			$game->out('
				<tr>
					<td width=150>
						<a href="'.parse_link('a=ship_fleets_ops&ship_details='.$ship['ship_id']).'">'.$ship['ship_name'].'</a>
					</td>
					<td>
						'.$ship['template_name'].'
					</td>
				</tr>
			');
		}

		$game->out('</table></td></tr></table>');
	}

	$game->out('<br><br><span class="sub_caption">'.constant($game->sprache("TEXT4")).' '.HelpPopup('ships').' :</span><br>');

	/**
	 * AC: Create main table
	 */
	switch($_REQUEST['order'])
	{
		case 1:
		case -1:
			$header1 = '<a href="'.parse_link('a=ships&view=ships_list&order='.($_REQUEST['order']*-1).'&search='.$search_name).'"><b><u>'.constant($game->sprache("TEXT5")).'</u></b></a>';
			$header2 = '<a href="'.parse_link('a=ships&view=ships_list&order=2&search='.$search_name).'"><b>'.constant($game->sprache("TEXT6")).'</b></a>';
			$header3 = '<a href="'.parse_link('a=ships&view=ships_list&order=3&search='.$search_name).'"><b>'.constant($game->sprache("TEXT7")).'</b></a>';
			$header4 = '<a href="'.parse_link('a=ships&view=ships_list&order=4&search='.$search_name).'"><b>'.constant($game->sprache("TEXT8")).'</b></a>';
			$header5 = '<a href="'.parse_link('a=ships&view=ships_list&order=5&search='.$search_name).'"><b>'.constant($game->sprache("TEXT11")).'</b></a>';
		break;
		case 2:
		case -2:
			$header1 = '<a href="'.parse_link('a=ships&view=ships_list&order=1&search='.$search_name).'"><b>'.constant($game->sprache("TEXT5")).'</b></a>';
			$header2 = '<a href="'.parse_link('a=ships&view=ships_list&order='.($_REQUEST['order']*-1).'&search='.$search_name).'"><b><u>'.constant($game->sprache("TEXT6")).'</u></b></a>';
			$header3 = '<a href="'.parse_link('a=ships&view=ships_list&order=3&search='.$search_name).'"><b>'.constant($game->sprache("TEXT7")).'</b></a>';
			$header4 = '<a href="'.parse_link('a=ships&view=ships_list&order=4&search='.$search_name).'"><b>'.constant($game->sprache("TEXT8")).'</b></a>';
			$header5 = '<a href="'.parse_link('a=ships&view=ships_list&order=5&search='.$search_name).'"><b>'.constant($game->sprache("TEXT11")).'</b></a>';
		break;
		case 3:
		case -3:
			$header1 = '<a href="'.parse_link('a=ships&view=ships_list&order=1&search='.$search_name).'"><b>'.constant($game->sprache("TEXT5")).'</b></a>';
			$header2 = '<a href="'.parse_link('a=ships&view=ships_list&order=2&search='.$search_name).'"><b>'.constant($game->sprache("TEXT6")).'</b></a>';
			$header3 = '<a href="'.parse_link('a=ships&view=ships_list&order='.($_REQUEST['order']*-1).'&search='.$search_name).'"><b><u>'.constant($game->sprache("TEXT7")).'</u></b></a>';
			$header4 = '<a href="'.parse_link('a=ships&view=ships_list&order=4&search='.$search_name).'"><b>'.constant($game->sprache("TEXT8")).'</b></a>';
			$header5 = '<a href="'.parse_link('a=ships&view=ships_list&order=5&search='.$search_name).'"><b>'.constant($game->sprache("TEXT11")).'</b></a>';
		break;
		case 4:
		case -4:
			$header1 = '<a href="'.parse_link('a=ships&view=ships_list&order=1&search='.$search_name).'"><b>'.constant($game->sprache("TEXT5")).'</b></a>';
			$header2 = '<a href="'.parse_link('a=ships&view=ships_list&order=2&search='.$search_name).'"><b>'.constant($game->sprache("TEXT6")).'</b></a>';
			$header3 = '<a href="'.parse_link('a=ships&view=ships_list&order=3&search='.$search_name).'"><b>'.constant($game->sprache("TEXT7")).'</b></a>';
			$header4 = '<a href="'.parse_link('a=ships&view=ships_list&order='.($_REQUEST['order']*-1).'&search='.$search_name).'"><b><u>'.constant($game->sprache("TEXT8")).'</u></b></a>';
			$header5 = '<a href="'.parse_link('a=ships&view=ships_list&order=5&search='.$search_name).'"><b>'.constant($game->sprache("TEXT11")).'</b></a>';
		break;
		case 5:
		case -5:
			$header1 = '<a href="'.parse_link('a=ships&view=ships_list&order=1&search='.$search_name).'"><b>'.constant($game->sprache("TEXT5")).'</b></a>';
			$header2 = '<a href="'.parse_link('a=ships&view=ships_list&order=2&search='.$search_name).'"><b>'.constant($game->sprache("TEXT6")).'</b></a>';
			$header3 = '<a href="'.parse_link('a=ships&view=ships_list&order=3&search='.$search_name).'"><b>'.constant($game->sprache("TEXT7")).'</b></a>';
			$header4 = '<a href="'.parse_link('a=ships&view=ships_list&order=4&search='.$search_name).'"><b>'.constant($game->sprache("TEXT8")).'</b></a>';
			$header5 = '<a href="'.parse_link('a=ships&view=ships_list&order='.($_REQUEST['order']*-1).'&search='.$search_name).'"><b><u>'.constant($game->sprache("TEXT11")).'</u></b></a>';
		break;
	}

	$game->out('<br><table border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr><td>
	<table border=0 cellpadding=2 cellspacing=2 class="style_inner">
		<tr>
		<td><b>#</b></td>
		<td width=160>'.$header1.'</td>
		<td width=200>'.$header2.'</td>
		<td width=100>'.$header3.'</td>
		<td width=100 align="center">'.$header4.'</td>
		<td width=75 align="center"><b>'.constant($game->sprache("TEXT9")).'</b></td>
		<td width=75 align="center"><b>'.constant($game->sprache("TEXT10")).'</b></td>
		<td width=150 align="center">'.$header5.'</td></tr>');

	$name_title = constant($game->sprache("TEXT13"));
	$position_title = constant($game->sprache("TEXT14"));
	$condition_title = constant($game->sprache("TEXT15"));
	$status_title = constant($game->sprache("TEXT16"));
	$crew_title = constant($game->sprache("TEXT17"));

	$n = $queryfocus + 1;
	while (($ship = $db->fetchrow($shipquery)) != false)
	{
		/* Check ship Naval Construction Code */
		$name_desc = constant($game->sprache("TEXT19")).' '.(($ship['ship_ncc'] != '') ? $ship['ship_ncc'] : '<i>'.constant($game->sprache("TEXT20")).'</i>');

		/* Check ship current position */
		$position = '';
		$position_desc = '';
		if($ship['fleet_id'] > 0) // Ship is in a fleet
		{
			$position = $ship['fleet_name'];

			/* Check il fleet is moving */ 
			if($ship['fleet_target'] != 0)
			{
				$planet = $db->queryrow('SELECT planet_name FROM planets WHERE planet_id = '.$ship['fleet_target']);
				$position_desc = constant($game->sprache("TEXT21")).' '.$planet['planet_name'];
				$pos_link = parse_link('a=ship_fleets_display&pfleet_details='.$ship['fleet_id']);
			}
			else
			{
				$position_desc = constant($game->sprache("TEXT22"));
				$pos_link = parse_link('a=ship_fleets_display&mfleet_details='.$ship['fleet_id']);
			}

			/* Check ship current status */
			$status='<font color=#80ff80>O</font>';
			$status_desc = constant($game->sprache("TEXT23"));
		}
		else // Ship is a spacedock
		{
			$position = $ship['planet_name'];
			$position_desc = constant($game->sprache("TEXT24"));
			/* Check ship current status */

			$status='<font color=#ffff80>S</font>';
			$status_desc = constant($game->sprache("TEXT25"));

			$pos_link = 'javascript:void(0);';
		}

		/* Check ship conditions */
		$per_damage = round(($ship['hitpoints']/$ship['max_hitpoints'])*100,0);
		if($per_damage > 75)
			$condition=$ship['hitpoints'].' / '.$ship['max_hitpoints'];
		else if($per_damage > 50)
		{
			$condition='<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT26")).'\', CAPTION, \''.$condition_title.'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color=#ffff80>'.$ship['hitpoints'].'</font></a> / '.$ship['max_hitpoints'];
		}
		else
			$condition='<a href="javascript:void(0);" onmouseover="return overlib(\''.constant($game->sprache("TEXT27")).'\', CAPTION, \''.$condition_title.'\', WIDTH, 250, '.OVERLIB_STANDARD.');" onmouseout="return nd();"><font color=#ff8080>'.$ship['hitpoints'].'</font></a> / '.$ship['max_hitpoints'];

		/* Check ship status */
		if ($ship['ship_repair']>0) {
			$status='<font color=#ff8080>R</font>';
			$status_desc = constant($game->sprache("TEXT28")).'<br>'.TimeDetailShort($NEXT_TICK+3*60*($ship['ship_repair']-$ACTUAL_TICK)).'.';
		}

		if ($ship['ship_scrap']>0) {
			$status='<font color=#ff8080>D</font>';
			$status_desc = constant($game->sprache("TEXT29")).'<br>'.TimeDetailShort($NEXT_TICK+3*60*($ship['ship_scrap']-$ACTUAL_TICK)).'.';
		}

		if ($ship['ship_untouchable']>0 && $ship['ship_repair']<=0 && $ship['ship_scrap']<=0) {
			$status='U';
			$status_desc = constant($game->sprache("TEXT30"));
		}

		/* Check ship crew aboard */
		$crew = '';
		$crew_desc = constant($game->sprache("TEXT31"));

		if (($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4'])>0)
		{
			$ncrew=100/($ship['max_unit_1']+$ship['max_unit_2']+$ship['max_unit_3']+$ship['max_unit_4'])*($ship['unit_1']+$ship['unit_2']+$ship['unit_3']+$ship['unit_4']);
			$ncrew = round($ncrew,0);

			// Critical condition
			if($ncrew > 0 && $ncrew <= 25)
				$crew = '<font color=#ff8080>'.$ncrew.'%';
			// Warning condition
			else if($ncrew > 25 && $ncrew <= 50)
				$crew = '<font color=#ffff80>'.$ncrew.'%';
			// Medium condition
			else if($ncrew > 50 && $ncrew <= 75)
				$crew = '<font color=#80ff80>'.$ncrew.'%';
			// Normal condition
			else if($ncrew >= 75)
				$crew = $ncrew.'%';

			$crew_desc = '<img src='.$game->GFX_PATH.'menu_unit1_small.gif>&nbsp;'.$ship['unit_1'].'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$game->player['user_race']][0]).'<br>';
			$crew_desc .='<img src='.$game->GFX_PATH.'menu_unit2_small.gif>&nbsp;'.$ship['unit_2'].'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$game->player['user_race']][1]).'<br>';
			$crew_desc .='<img src='.$game->GFX_PATH.'menu_unit3_small.gif>&nbsp;'.$ship['unit_3'].'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$game->player['user_race']][2]).'<br>';
			$crew_desc .='<img src='.$game->GFX_PATH.'menu_unit4_small.gif>&nbsp;'.$ship['unit_4'].'&nbsp;&nbsp;'.addslashes($UNIT_NAME[$game->player['user_race']][3]);
		}

		$game->out('
			<tr>
			<td>'.$n.'</td>
			<td>'.$ship['template_name'].'</td>
			<td>
				<a href="'.parse_link('a=ship_fleets_ops&ship_details='.$ship['ship_id'].'').'" onmouseover="return overlib(\''.$name_desc.'\', CAPTION, \''.$name_title.'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.(($ship['ship_name'] != '') ? $ship['ship_name'] : '<i>'.constant($game->sprache("TEXT67")).'</i>').'</a>
			</td>
			<td>
				<a href="'.$pos_link.'" onmouseover="return overlib(\''.$position_desc.'\', CAPTION, \''.$position_title.'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$position.'</a>
			</td>
			<td align="center">'.$condition.'</td>
			<td align="center">
				<a href="javascript:void(0);" onmouseover="return overlib(\''.$status_desc.'\', CAPTION, \''.$status_title.'\', WIDTH, 200, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$status.'</a>
			</td>
			<td align="center">
				<a href="javascript:void(0);" onmouseover="return overlib(\''.$crew_desc.'\', CAPTION, \''.$crew_title.'\', WIDTH, 200, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$crew.'</a>
			</td>
			<td align="center">'.($ship['awayteam'] == 0 ? constant($game->sprache("TEXT76")).'<a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($ship['awayteamplanet_id'])).'">'.$ship['mission_planet'].'</a>' : intval($ship['awayteam'])).'</td>
			</tr>');

		$n++;
	}

	$game->out('</table></td></tr></table>');

	/* AC: Pages browsing */
	$sql = 'SELECT COUNT(ship_id) AS n_ships
			FROM (ships s)
			INNER JOIN (ship_templates st) ON st.id = s.template_id
			WHERE user_id = '.$game->player['user_id'].' AND st.ship_class IN ('.implode(',', $sels).')';
	$n_ships = $db->queryrow($sql);
	$max_pages = ceil($n_ships['n_ships'] / $shipsxpage);
	$game->out('<br><table border=0 cellpadding=1 cellspacing=1 class="style_outer" width=400><tr><td>
		<table border=0 cellpadding=2 cellspacing=2 class="style_inner" width=400><tr>
		<td width=50 align=middle>
			'.(($queryfocus>0) ? '<a href="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start=0').'"><span class="text_large">[1]</a>' : '[1]').'
		</td>
		<td width=150 align=middle>
			'.(($queryfocus>0) ? '<a href="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.($queryfocus-$shipsxpage)).'"><span class="text_large">'.constant($game->sprache("TEXT32")).'</a>' : '').'
		</td>
		<td width=150 align=middle>
			'.(($queryfocus < $n_ships['n_ships']-$shipsxpage) ? '<a href="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.($queryfocus+$shipsxpage)).'"><span class="text_large">'.constant($game->sprache("TEXT33")).'</a>' : '').'
		</td>
		<td width=50 align=middle>
			'.(($queryfocus < $n_ships['n_ships']-$shipsxpage) ? '<a href="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.($n_ships['n_ships']-$shipsxpage)).'"><span class="text_large">['.$max_pages.']</a>' : '['.$max_pages.']').'
		</td>
		</tr></table></td></tr></table>');

	/* Show up ship's filter */
	$game->out('<br>
		<table border=0 cellpadding=1 cellspacing=1 class="style_outer" width=300><tr><td>
		<table border=0 cellpadding=1 cellspacing=1 class="style_inner" width=300>
		<tr>
		<td>
			<fieldset><legend>'.constant($game->sprache("TEXT68")).'</legend>
			<table><tr>
			<td>
			<form name="stype0form" method="post" action="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.$queryfocus.'&filter=1').'">
			<input type="checkbox" name="stype_0" value="1"'.(($_POST['stype_0']==1) ? ' checked="checked"' : '' ).'  onChange="document.stype0form.submit()">'.constant($game->sprache("TEXT69")).'
			</form>
			</td>
			<td>
			<form name="stype1form" method="post" action="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.$queryfocus.'&filter=2').'">
			<input type="checkbox" name="stype_1" value="1"'.(($_POST['stype_1']==1) ? ' checked="checked"' : '' ).'  onChange="document.stype1form.submit()">'.constant($game->sprache("TEXT70")).'
			</form>
			</td>
			<td>
			<form name="stype2form" method="post" action="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.$queryfocus.'&filter=3').'">
			<input type="checkbox" name="stype_2" value="1"'.(($_POST['stype_2']==1) ? ' checked="checked"' : '' ).'  onChange="document.stype2form.submit()">'.constant($game->sprache("TEXT71")).'
			</form>
			</td>
			<td>
			<form name="stype3form" method="post" action="'.parse_link('a=ships&order='.$_REQUEST['order'].'&start='.$queryfocus.'&filter=4').'">
			<input type="checkbox" name="stype_3" value="1"'.(($_POST['stype_3']==1) ? ' checked="checked"' : '' ).'  onChange="document.stype3form.submit()">'.constant($game->sprache("TEXT72")).'
			</form>
			</td></tr></table>
			</fieldset>
		</td>
		</tr></table></td></tr></table>');
}

function CreateShipInfoText($ship)
{
	global $game;

	$text='<b>'.$ship[31].'</b><br><br><u>'.constant($game->sprache("TEXT40")).'</u><br>';

	$text.=constant($game->sprache("TEXT41")).' '.$ship[14].'<br>';
	$text.=constant($game->sprache("TEXT42")).' '.$ship[15].'<br>';
	$text.=constant($game->sprache("TEXT43")).' '.$ship[16].'<br>';
	$text.=constant($game->sprache("TEXT44")).' '.$ship[17].'<br>';
	$text.=constant($game->sprache("TEXT45")).' '.$ship[18].'<br>';
	$text.=constant($game->sprache("TEXT46")).' '.$ship[19].'<br>';
	$text.=constant($game->sprache("TEXT47")).' '.$ship[20].'<br>';
	$text.=constant($game->sprache("TEXT48")).' '.$ship[21].'<br>';
	$text.=constant($game->sprache("TEXT49")).' '.$ship[22].'<br>';
	$text.=constant($game->sprache("TEXT50")).' '.$ship[23].'<br>';
	$text.=constant($game->sprache("TEXT51")).' '.$ship[24].'<br>';
	$text.=constant($game->sprache("TEXT52")).' '.$ship[25].'<br>';
	$text.=constant($game->sprache("TEXT53")).' '.$ship[27].'<br>';
	$text.=constant($game->sprache("TEXT54")).' '.$ship[26].'<br>';
	return $text;
}

function CreateCompInfoText($comp)
{
	global $game;

	$text=''.$comp['description'].'<br><br>'.constant($game->sprache("TEXT40")).'</u><br>';

	if ($comp['value_1']!=0) $text.=constant($game->sprache("TEXT41")).' '.$comp['value_1'].'<br>';
	if ($comp['value_2']!=0) $text.=constant($game->sprache("TEXT42")).' '.$comp['value_2'].'<br>';
	if ($comp['value_3']!=0) $text.=constant($game->sprache("TEXT43")).' '.$comp['value_3'].'<br>';
	if ($comp['value_4']!=0) $text.=constant($game->sprache("TEXT44")).' '.$comp['value_4'].'<br>';
	if ($comp['value_5']!=0) $text.=constant($game->sprache("TEXT45")).' '.$comp['value_5'].'<br>';
	if ($comp['value_6']!=0) $text.=constant($game->sprache("TEXT46")).' '.$comp['value_6'].'<br>';
	if ($comp['value_7']!=0) $text.=constant($game->sprache("TEXT47")).' '.$comp['value_7'].'<br>';
	if ($comp['value_8']!=0) $text.=constant($game->sprache("TEXT48")).' '.$comp['value_8'].'<br>';
	if ($comp['value_9']!=0) $text.=constant($game->sprache("TEXT49")).' '.$comp['value_9'].'<br>';
	if ($comp['value_10']!=0) $text.=constant($game->sprache("TEXT50")).' '.$comp['value_10'].'<br>';
	if ($comp['value_11']!=0) $text.=constant($game->sprache("TEXT51")).' '.$comp['value_11'].'<br>';
	if ($comp['value_12']!=0) $text.=constant($game->sprache("TEXT52")).' '.$comp['value_12'].'<br>';
	if ($comp['value_14']!=0) $text.=constant($game->sprache("TEXT53")).' '.$comp['value_14'].'<br>';
	if ($comp['value_13']!=0) $text.=constant($game->sprache("TEXT54")).' '.$comp['value_13'].'<br>';

	return $text;
}

function Ship_Details()
{
	global $db,$game,$SHIP_TORSO,$RACE_DATA,$ship_rank_bonus,$ship_ranks,$ship_components;

	$sql = 'SELECT s.*, st.*,
	               f.fleet_name, f.planet_id, f.move_id,
	               p.planet_name
	        FROM (ships s)
	        INNER JOIN (ship_templates st) ON st.id = s.template_id
	        LEFT JOIN (ship_fleets f) ON f.fleet_id = s.fleet_id
	        LEFT JOIN (planets p) ON p.planet_id = -s.fleet_id
	        WHERE s.ship_id = '.$_REQUEST['id'];

	if(($ship = $db->queryrow($sql)) === false) {
		message(DATABASE_ERROR, 'Could not query ship data');
	}

	if(empty($ship['ship_id'])) {
		message(NOTICE, constant($game->sprache("TEXT55")));
	}

	if($ship['user_id'] != $game->player['user_id']) {
		message(NOTICE, constant($game->sprache("TEXT55")));
	}

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
	

    $game->out('

<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">

  <tr>

    <td><span class="sub_caption2">'.constant($game->sprache("TEXT56")).' ('.$ship['name'].')</span><br>

      <table width="450" align="center" cellpadding="0" cellspacing="0" border="0" class="style_inner">

        <tr>

          <td align="left" valign="top" width="120">

            '.( ($ship['fleet_id'] > 0) ? constant($game->sprache("TEXT57")) : constant($game->sprache("TEXT58")) ).'<br><br>

            '.constant($game->sprache("TEXT59")).'<br>

            '.constant($game->sprache("TEXT60")).'<br>

            '.constant($game->sprache("TEXT61")).'<br><br>

            '.constant($game->sprache("TEXT6")).'<br>

            '.constant($game->sprache("TEXT62")).'<br>

            '.constant($game->sprache("TEXT63")).'<br><br>

            '.constant($game->sprache("TEXT73")).'<br>

            '.constant($game->sprache("TEXT64")).'<br>

            '.constant($game->sprache("TEXT44")).'<br><br>

            '.constant($game->sprache("TEXT49")).'<br><br>

            '.constant($game->sprache("TEXT41")).'<br>

            '.constant($game->sprache("TEXT42")).'<br>

            '.constant($game->sprache("TEXT43")).'<br><br>

            '.constant($game->sprache("TEXT46")).'<br>

            '.constant($game->sprache("TEXT47")).'<br>

            '.constant($game->sprache("TEXT48")).'<br><br>

            '.constant($game->sprache("TEXT50")).'<br>

            '.constant($game->sprache("TEXT51")).'<br>

            '.constant($game->sprache("TEXT52")).'<br><br>

            '.constant($game->sprache("TEXT65")).'<br><br>

            '.constant($game->sprache("TEXT10")).'

          </td>

          <td align="left" valign="top" width="160">

            ['.( ($ship['fleet_id'] > 0) ? '<a href="'.parse_link('a=ship_fleets_display&'.( (!empty($ship['planet_id'])) ? 'p' : 'm' ).'fleet_details='.$ship['fleet_id']).'">'.$ship['fleet_name'].'</a>' : '<a href="'.parse_link('a=spacedock').'">'.$ship['planet_name'].'</a>' ).']<br><br>

            <b>'.$ship['name'].'</b><br>

            <b><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$ship['race']][$ship['ship_torso']]).'\', CAPTION, \''.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$ship['race']][$ship['ship_torso']][29].'</a></b><br>

            <b>'.$RACE_DATA[$ship['race']][0].'</b><br><br>

            <b>'.$ship['ship_name'].'</b><br>

            <b>'.$ship['ship_ncc'].'</b><br>

            <b>'.date('d/m/y H:i:s', $ship['construction_time']).'</b><br><br>

            <b>'.( (!empty($ship['last_refit_time'])) ? date('d/m/y H:i:s', $ship['last_refit_time']) : constant($game->sprache("TEXT74"))).'</b><br>

            <b>'.$ship['hitpoints'].'</b> / <b>'.$ship['value_5'].'</b><br>

            <b>'.$ship['value_4'].'</b><br><br>

            <b><span style="color: yellow">'.$ship['experience'].'</span></b> <img src="'.$game->GFX_PATH.'rank_'.$rank_nr.'.jpg" width="47" height="12"><br><br>

            <b>'.$ship['value_1'].' + <span style="color: yellow">'.round($ship['value_1']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_2'].' + <span style="color: yellow">'.round($ship['value_2']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_3'].' + <span style="color: yellow">'.round($ship['value_3']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br><br>

            <b>'.$ship['value_6'].' + <span style="color: yellow">'.round($ship['value_6']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_7'].' + <span style="color: yellow">'.round($ship['value_7']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br>

            <b>'.$ship['value_8'].' + <span style="color: yellow">'.round($ship['value_8']*$ship_rank_bonus[$rank_nr-1],0).'</span></b><br><br>

            <b>'.$ship['value_10'].'</b><br>

            <b>'.$ship['value_11'].'</b><br>

            <b>'.$ship['value_12'].'</b><br><br>

            <b>'.$ship['value_14'].'</b> / <b>'.$ship['value_13'].'</b><br><br>

            <img src='.$game->GFX_PATH.'menu_unit1_small.gif>'.$ship['unit_1'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif>'.$ship['unit_2'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif>'.$ship['unit_3'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif>'.$ship['unit_4'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif>'.$ship['unit_5'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif>'.$ship['unit_6'].'

          </td>

          <td align="center>" valign="top" width="170"><img src="'.FIXED_GFX_PATH.'ship'.$ship['race'].'_'.$ship['ship_torso'].'.jpg"><br><br>

    ');

    for ($t=0; $t<10; $t++)

	{

	if ($ship['component_'.($t+1)]>=0)

	{

	$game->out('-&nbsp;<a href="javascript:void(0);" onmouseover="return overlib(\''.CreateCompInfoText($ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]).'\', CAPTION, \''.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$ship_components[$ship['race']][$t][$ship['component_'.($t+1)]]['name'].'</a><br>');

	} else $game->out(constant($game->sprache("TEXT66")));

    }



    $game->out('

          </td>

        </tr>

      </table>

    </td>

  </tr>

</table>

    ');


}



/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////

$sub_action = (!empty($_GET['view'])) ? $_GET['view'] : 'ships_list';

if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) $_REQUEST['search']=htmlspecialchars($db->escape_string($_REQUEST['search']));
if (isset($_REQUEST['start'])) $_REQUEST['start']=(int)$_REQUEST['start'];
if (isset($_REQUEST['id'])) $_REQUEST['id']=(int)$_REQUEST['id'];

if (!isset($_REQUEST['order']) || empty($_REQUEST['order'])) $_REQUEST['order']=1;


if ($sub_action == 'ships_list')
{
	if (!isset($_REQUEST['search'])) {$_REQUEST['search']='';}
/*	if ($_REQUEST['order']!=2 && $_REQUEST['order']!=3) {$nr=$db->queryrow('SELECT user_rank_points AS focus FROM user WHERE user_name LIKE "'.$_REQUEST['search'].'" LIMIT 1');}
	if ($_REQUEST['order']==2) $nr=$db->queryrow('SELECT user_rank_planets AS focus FROM user WHERE user_name LIKE "'.$_REQUEST['search'].'" LIMIT 1');
	if ($_REQUEST['order']==3) $nr=$db->queryrow('SELECT user_rank_honor AS focus FROM user WHERE user_name LIKE "'.$_REQUEST['search'].'" LIMIT 1');
	$focus=$nr['focus'];*/
	$focus = 0;

	Ships_List($focus,$_REQUEST['search']);
}
/*
else if ($sub_action == 'ship_details')
{
	Ship_Details();
}
*/
?>
