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


// include global definitions + functions + game-class + player-class
include_once('include/global.php');
include_once('include/sql.php');
include_once('include/functions.php');
include_once('maps.php');
error_reporting(E_ALL);

// create sql-object for db-connection
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']);

// Load player parameters 
$game = new game();

$game->load_config();
$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - time();//$game->TIME;
$LAST_TICK_TIME = $game->config['tick_time'] - TICK_DURATION * 60;

include('include/session.php');
// load player parameters

// Check map size request
if ($_GET['size']<1) $_GET['size']=1;
if ($_GET['size']>8) $_GET['size']=8;

$size=$_GET['size'];


//Assign names:
$image_url='maps/tmp/k_'.$game->player['user_id'].'_'.$size.'.png';
$map_url='maps/tmp/k_'.$game->player['user_id'].'_'.$size.'.html';


//Delete old picture
if (file_exists($image_url))
{
	if (filemtime($image_url)<time()-3600*6)
	{
		@unlink($image_url);
		@unlink($map_url);
	}
}


// Localize strings
switch($game->player['language'])
{
	case 'GER':
		$title = 'Karte von Bekannten Systemen:';
		$created = 'Erstellt am ';
		$legend = 'Legende';
		$tmy_systems = 'Meine Systeme:';
		$thome_systems = 'Home-system';
		$treserved_systems = 'Private Systeme';
		$tcolo_systems = 'Kolonisierten System';
		$tother_systems = 'Andere Spieler:';
		$tother_home_systems = 'Home-system';
		$tother_reserved_systems = 'Private Systeme';				
		$tother_colo_systems = 'Kolonisierten System';
		$texplored_systems = 'Exploration:';						
		$tknown_systems = 'Erkundete Systeme';
		$tunknown_systems = 'Unbekannte Systeme';
	break;
	case 'ITA':
		$title = 'Mappa dei sistemi conosciuti:';
		$created = 'Creata il ';
		$legend = 'Legenda';
		$tmy_systems = 'Miei sistemi:';
		$thome_systems = 'Sistema madre';
		$treserved_systems = 'Sistemi privati';
		$tcolo_systems = 'Sistemi colonizzati';				
		$tother_systems = 'Altri giocatori:';
		$tother_home_systems = 'Sistemi madre';
		$tother_reserved_systems = 'Sistemi privati';				
		$tother_colo_systems = 'Sistemi colonizzati';                		                
		$texplored_systems = 'Esplorazione:';
		$tknown_systems = 'Sistemi esplorati';
		$tunknown_systems = 'Sistemi inesplorati';
	break;
	default:
		$title = 'Known systems map:';
		$created = 'Created at ';
		$legend = 'Legend';
		$tmy_systems = 'My own systems:';
                $thome_systems = 'Home system';
                $tcolo_systems = 'Colonized system';
		$tknown_systems = 'Explored systems';
		$tunknown_systems = 'Unknown systems';
	break;
}


// Generate new picture?: 
if (($handle = @fopen ($image_url, "rb"))!=true)
{
	$map_data='<map name="detail_map">';
	
	$im = imagecreatetruecolor(162*$size, 162*$size);
	imagecolorallocatealpha($im, 0, 0, 0,0);
	$color[1]=imagecolorallocatealpha($im, 90, 64, 64,0);  // Inesplorato
        $color[2]=imagecolorallocatealpha($im, 155, 135, 135,0);  // Esplorato

        $color[3]=imagecolorallocatealpha($im,   0,255,255, 0);  // Sistema Madre
        $color[4]=imagecolorallocatealpha($im,  51,255, 51, 0);  // Privato
        $color[5]=imagecolorallocatealpha($im, 255,255,  0, 0);  // Privato, challenged
        $color[6]=imagecolorallocatealpha($im,   0,153,  0, 0);  // Colonizzato

        $color[7]=imagecolorallocatealpha($im, 255,153, 51, 0);  // Sistema Madre
        $color[8]=imagecolorallocatealpha($im, 255, 51, 51, 0);  // Privato
        $color[9]=imagecolorallocatealpha($im, 255,153, 51, 0);  // Privato, challenged
        $color[10]=imagecolorallocatealpha($im, 153,  0,  0, 0);  // Colonizzato

        drawMapGrid($im,$size);

	// Obtain ALL the starsystems
	$sql = 'SELECT s.system_id, s.system_name, s.sector_id, s.system_x, s.system_y FROM starsystems s';
	if(!$q_systems = $db->query($sql)) {
		message(DATABASE_ERROR, 'Could not query starsystems data');
	}
	while($system = $db->fetchrow($q_systems))
		$glob_systems[$system['system_id']]=$system;


	// Select known systems
	/*$sql = 'SELECT pl.system_id FROM (planets pl)
	                 LEFT JOIN (planet_details pd) ON pl.system_id = pd.system_id
	                 LEFT JOIN (user u) ON pl.planet_owner = u.user_id
	          WHERE pd.user_id = "'.$game->player['user_id'].'" AND pd.log_code = 500 OR
	                u.user_alliance = '.$game->player['user_alliance'].' 
	          GROUP BY pl.system_id';*/

	$sql = 'SELECT system_id FROM `starsystems_details`
	        WHERE log_code = 0 AND user_id = '.$game->player['user_id'];
	$systems = $db->query($sql);
	while($system = $db->fetchrow($systems)) {
		$known_systems[$system['system_id']]=$system;
        }

	/* Select systems of alliance's members
	if($game->player['user_alliance'] != 0 AND $game->player['user_alliance_rights3'] == 1) {
		$sql = 'SELECT pl.system_id FROM (planets pl)
		               LEFT JOIN (user u) ON pl.planet_owner = u.user_id
		        WHERE u.user_alliance = '.$game->player['user_alliance'].'
		        GROUP BY pl.system_id';
		$systems = $db->query($sql);
		while($system = $db->fetchrow($systems))
			$allied_systems[$system['system_id']]=$system;
	}
        */
        
        $sql = 'SELECT system_id FROM planets WHERE planet_owner_enum = 0 AND planet_owner = '.$game->player['user_id'];
        $system = $db->queryrow($sql);
        $home_system[$system['system_id']]=$system;
        $home_id = $system['system_id'];
        
        $sql = 'SELECT system_id FROM starsystems WHERE system_closed = 2 AND system_owner = '.$game->player['user_id'].' AND system_id <> '.$home_id;
        $systems = $db->queryrowset($sql);
        foreach ($systems as $system) {
            $private_systems[$system['system_id']]=$system;
        }
        
        $sql = 'SELECT system_id FROM starsystems INNER JOIN starsystems_details USING (system_id) WHERE starsystems_details.user_id = '.$game->player['user_id'].' AND log_code = 0 AND system_closed = 1 AND system_owner <> '.$game->player['user_id'];
        $systems = $db->queryrowset($sql);
        foreach ($systems as $system) {
            $other_homes_systems[$system['system_id']]=$system;        
        }
        
        $sql = 'SELECT system_id FROM starsystems INNER JOIN starsystems_details USING (system_id) WHERE starsystems_details.user_id = '.$game->player['user_id'].' AND log_code = 0 AND system_closed = 2 AND system_owner <> '.$game->player['user_id'];
        $systems = $db->queryrowset($sql);
        foreach ($systems as $system) {
            $other_private_systems[$system['system_id']]=$system;        
        }        
        
        $own_system_lst = array();
        $other_system_lst = array();
        
        $sql = 'SELECT DISTINCT system_id FROM planets WHERE planet_owner = '.$game->player['user_id'];
        $systems = $db->queryrowset($sql);
        foreach ($systems as $system) {
            $colonized_systems[$system['system_id']]=$system;
            $own_system_lst[] = $system['system_id'];
        }
        
        $sql = 'SELECT DISTINCT system_id FROM planets INNER JOIN starsystems_details USING (system_id) WHERE starsystems_details.user_id = '.$game->player['user_id'].' AND log_code = 0 AND planet_owner NOT IN (0, '.$game->player['user_id'].')';
        $systems = $db->queryrowset($sql);
        foreach ($systems as $system) {
            $other_colonized_systems[$system['system_id']]=$system;
            $other_system_lst[] = $system['system_id'];
        }
        
	// Select all systems
	//$q_planets = $db->query('SELECT system_id FROM planets GROUP BY system_id');

	//while($planet = $db->fetchrow($q_planets)) {
		//$system=$glob_systems[$planet['system_id']];
	foreach ($glob_systems as $key => $system) {
                if(!isset($known_systems[$system['system_id']]['system_id'])) {continue;}
                $px = getSystemCoords($system,$size);
                $px_x = $px[0];
                $px_y = $px[1];

                // Change color if it's the home system
                if(isset($home_system[$system['system_id']]['system_id']))
                        $useColor = $color[3];
                // Change color if it's an own private system
                else if(isset($private_systems[$system['system_id']]['system_id']))
                        $useColor = $color[4];
                else if(isset($other_homes_systems[$system['system_id']]['system_id']))
                        $useColor = $color[7];                
                else if(isset($other_private_systems[$system['system_id']]['system_id']))
                        $useColor = $color[8];                
                // Change color if it's a colonized system
                else if(isset($colonized_systems[$system['system_id']]['system_id']))
                        $useColor = $color[6];
                                // Change color if it's a colonized system
                else if(isset($other_colonized_systems[$system['system_id']]['system_id']))
                        $useColor = $color[10];
                // Change color if it's a known system
                else if(isset($known_systems[$system['system_id']]['system_id']))
			$useColor = $color[2];
		else
			$useColor = $color[1];

		if ($size>2)
		{
			imagefilledrectangle ($im, $px_x,$px_y, $px_x+$size-2, $px_y+$size-2, $useColor);
			$map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.$px_x.','.$px_y.', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$system['system_name'].'">';
		}
		else
		{
			imagefilledrectangle ($im, $px_x-1,$px_y-1, $px_x+$size-2, $px_y+$size-2, $useColor);
			$map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.($px_x-1).','.($px_y-1).', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$system['system_name'].'">';
		}
	};


	if ($size<3) $size2=1;
	if ($size==3) $size2=2;
	else $size2=$size-2;

	if ($size>1)
	{
		imagestring ($im, $size2,15,162*$size-12-$size,$created.date('d.m.y H:i', time()), $color[2]);
	}
	else
	{
		imagestring ($im, $size2,5,162*$size-15,$created, $color[2]);
		imagestring ($im, $size2,5,162*$size-8,date('d.m.y H:i', time()), $color[2]);
	}


	$map_data.='</map>';

	imagepng($im,$image_url);

	if (($handle = @fopen ($map_url, "wt")))
	{
		fwrite($handle,$map_data);
	}
	fclose($handle);

}


if (!isset($_GET['map']))
{
	header("Content-type: image/png");
	header("Pragma: no-cache");

	if (($handle = @fopen ($image_url, "rb"))!=true) echo 'Lost image!';
	else
	{
		$img = fread($handle, filesize($image_url));
		fclose($handle);
	}
	// Print image to web browser.
	print $img;
}
else
{
	if (!isset($map_data))
	{
		if (($handle = @fopen ($map_url, "rt"))==true)
		{
			$map_data = fread($handle, filesize($map_url));
			fclose($handle);
		}
	}

echo'<html><body bgcolor="#000000" text="#DDDDDD"  background="../gfx/bg_stars1.gif"><center>
<span style="font-family: Verdana; font-size: 15px;"><b>'.$title.'</b></span><br>
<img border=0 usemap="#detail_map" src="'.$image_url.'" >

'.$map_data.'
</center><br>
<table>
<caption>'.$legend.'</caption>
<tr>
	<td align="center">'.$tmy_systems.'</td>
	<td align="center"><span style="color: #00FFFF">'.$thome_systems.'</span></td>
	<td align="center"><span style="color: #33FF33">'.$treserved_systems.'</span></td>
	<td align="center"><span style="color: #009900">'.$tcolo_systems.'</span></td>
</tr>
<tr>
	<td align="center">'.$tother_systems.'</td>
	<td align="center"><span style="color: #FF9933">'.$tother_home_systems.'</span></td>
	<td align="center"><span style="color: #FF3333">'.$tother_reserved_systems.'</span></td>
	<td align="center"><span style="color: #990000">'.$tother_colo_systems.'</span></td>
</tr>
<tr>
	<td align="center" colspan="2">'.$texplored_systems.'</td>
	<td align="center"><span style="color: #9B8787">'.$tknown_systems.'</span></td>
	<td align="center"><span style="color: #5A4040">'.$tunknown_systems.'</span></td>
</tr>
</table>  
</body></html>';
}

$db->close();

?>
