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
$count=0;
if (($handle = @fopen ('mapcounter.txt', "rt"))!=true) {}
else
{
$count = fread($handle, filesize('mapcounter.txt'));
fclose($handle);
}
$count=(int)$count+1;
if (($handle = @fopen ('mapcounter.txt', "wt"))!=true) {}
else
{
fwrite($handle, $count);
fclose($handle);
}

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

//Remove the query of the user, because we do not want the planets of the user 0 (uninhabited).

/*$sql = 'SELECT user_id FROM user WHERE user_name LIKE "'.addslashes($_GET['user']).'"';
$user = $db->queryrow($sql);
  if(!isset($user['user_id'])) {
  	
			header("Content-type: image/png");
			header("Pragma: no-cache");
			imagepng($im);
			exit;
       }
       */
       
//The path to provide is always 0_0 because the user is the same.
       
//Assign names:
$image_url='maps/tmp/u_0_'.$game->player['user_id'].'_'.$size.'.png';
$map_url='maps/tmp/u_'.$game->player['user_id'].'_0_'.$size.'.html';
       



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
		$title = 'Karte von kolonisierbaren Planeten:';
		$created = 'Erstellt am ';
	break;
	case 'ITA':
		$title = 'Mappa pianeti colonizzabili:';
		$created = 'Creata il ';
	break;
	default:
		$title = 'Map of colonizable planets:';
		$created = 'Created at ';
	break;
}



// Generate new picture?: 
if (($handle = @fopen ($image_url, "rb"))!=true)
{

$map_data='<map name="detail_map">';

$im = imagecreatetruecolor(162*$size, 162*$size);
imagecolorallocatealpha($im, 0, 0, 0,0);
$color[0]=imagecolorallocatealpha($im, 51, 255, 51,0);
$color[1]=imagecolorallocatealpha($im, 0, 128, 255,0);
$color[2]=imagecolorallocatealpha($im, 255, 255, 0,0);
$color[3]=imagecolorallocatealpha($im, 255, 0, 0,0);
$color[4]=imagecolorallocatealpha($im, 255, 0, 255,0);
$color[5]=imagecolorallocatealpha($im, 96, 96, 96,0);

drawMapGrid($im,$size);



$sql = '
SELECT s.system_id, s.system_name, s.sector_id, s.system_x, s.system_y, s.system_orion_alert
 FROM starsystems s
 INNER JOIN starsystems_details USING (system_id)
 WHERE log_code = 0 AND user_id = '.$game->player['user_id'];

if(!$q_systems = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query starsystems data');
}

while($system = $db->fetchrow($q_systems))
$glob_systems[$system['system_id']]=$system;

foreach ($glob_systems AS $system) {
    $px = getSystemCoords($system,$size);
    $px_x = $px[0];
    $px_y = $px[1];

    if ($size>2)
    {
        imagefilledrectangle ($im, $px_x,$px_y, $px_x+$size-2, $px_y+$size-2, $color[$system['system_orion_alert']]);
        $map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.$px_x.','.$px_y.', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$system['system_name'].'">
        ';

    }
    else
    {
        imagefilledrectangle ($im, $px_x-1,$px_y-1, $px_x+$size-2, $px_y+$size-2, $color[$system['system_orion_alert']]);
        $map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.($px_x-1).','.($px_y-1).', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$system['system_name'].'">
        ';
    }
};


if ($size<3) $size2=1;
if ($size==3) $size2=2;
else $size2=$size-2;

if ($size>1)
{
imagestring ($im, $size2,15,162*$size-12-$size,$created.date('d.m.y H:i', time()), $color[5]);
}
else
{
imagestring ($im, $size2,5,162*$size-15,$created, $color[5]);
imagestring ($im, $size2,5,162*$size-8,date('d.m.y H:i', time()), $color[5]);
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

if (($handle = @fopen ($map_url, "rt"))!=true) {}
else
{
$map_data = fread($handle, filesize($map_url));
fclose($handle);
}

}

echo'<html><body bgcolor="#000000" text="#DDDDDD"  background="../gfx/bg_stars1.gif"><center>
<span style="font-family: Verdana; font-size: 15px;"><b>'.$title.'</b></span><br>
<img border=0 usemap="#detail_map" src="'.$image_url.'" >

'.$map_data.'

</body></html>';



}

$db->close();

?>
