<?php
/*
    This file is part of STFC.it
    Copyright 2008-2013 by Andrea Carolfi (carolfi@stfc.it) and
    Cristiano Delogu (delogu@stfc.it).

    STFC.it is based on STFC,
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

error_reporting(E_ALL);

// include global definitions + functions + game-class + player-class
include_once('include/global.php');
include_once('include/sql.php');
include_once('include/functions.php');
include_once('maps.php');


// Create sql-object for db-connection
$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']);

// Create game hinstance
$game = new game();

$game->load_config();

$ACTUAL_TICK = $NEXT_TICK = 0;

$ACTUAL_TICK = $game->config['tick_id'];
$NEXT_TICK = $game->config['tick_time'] - time();
$LAST_TICK_TIME = $game->config['tick_time'] - TICK_DURATION * 60;

// load player parameters
include('include/session.php');

// Check map size request
if ($_GET['size']<1) $_GET['size']=1;
if ($_GET['size']>8) $_GET['size']=8;
$size=$_GET['size'];

// Name of the generated files:
$image_url='maps/tmp/user_'.$game->player['user_id'].'_fleets_'.$size.'.png';
$map_url='maps/tmp/user_'.$game->player['user_id'].'_fleets_'.$size.'.html';

// Delete old image, if exist
if (file_exists($image_url)) {
    if (filemtime($image_url)<time()-1800) {
        @unlink($image_url);
        @unlink($map_url);
    }
}

// Prepare localized strings
switch($game->player['language'])
{
    case 'GER':
        $updated = 'Aktualisiert am ';
        $lost_image = 'Fehlendes Bild!';
        $fleets_position = 'Flotten Positionen:';
    break;
    case 'ITA':
        $updated = 'Aggiornata il ';
        $lost_image = 'Immagine perduta!';
        $fleets_position = 'Posizione flotte:';
    break;
    default:
        $updated = 'Updated at ';
        $lost_image = 'Lost image!';
        $fleets_position = 'Fleets positions:';
    break;
}

// Generate new image?:
if (($handle = @fopen ($image_url, "rb"))!=true) {
    $map_data='<map name="detail_map">';

    $im = imagecreatetruecolor(162*$size, 162*$size);
    imagecolorallocatealpha($im, 0, 0, 0,0);

    drawMapGrid($im,$size);

    $color[1]=imagecolorallocatealpha($im, 90, 64, 64,0);
    $color[2]=imagecolorallocatealpha($im, 128, 64, 64,0);
    $color[3]=imagecolorallocatealpha($im, 196, 64, 64,0);
    $color[4]=imagecolorallocatealpha($im, 96, 96, 96,0);
    $color[5]=imagecolorallocatealpha($im, 255, 0, 0,20);


    // ######################################################################
    // ######################################################################
    // Select all stationing fleets of the player
    $sql = 'SELECT sf.*, o.officer_name 
            FROM ship_fleets sf
            LEFT JOIN officers o ON (o.fleet_id = sf.fleet_id)
            WHERE sf.user_id = '.$game->player['user_id'].' AND sf.move_id = 0';

    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }

    // If there are some fleets
    if ($db->num_rows() > 0) {

        while($fleet = $db->fetchrow($q_fleets)) {
            $planets_ids[$fleet['planet_id']]=$fleet['planet_id'];
            $fleets[$fleet['fleet_id']]=$fleet;
        }

        // Select all planets that have at least a fleet in the orbit
        $sql = 'SELECT planet_id, system_id, sector_id, planet_name
                FROM planets WHERE planet_id IN ('.implode(',',$planets_ids).')';

        if(!$q_planets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query planets data');
        }

        while($planet = $db->fetchrow($q_planets)) {
            $systems_ids[$planet['system_id']]=$planet['system_id'];
            $planets[$planet['planet_id']]=$planet;
        }

        // Select all starsystems that have at least a fleet in one of their planets
        $sql = 'SELECT system_id, system_name, sector_id, system_x, system_y
                FROM starsystems WHERE system_id IN ('.implode(',',$systems_ids).')';

        if(!$q_systems = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query starsystems data');
        }

        // Create map
        while($system = $db->fetchrow($q_systems))
        {
            $px = getSystemCoords($system,$size);
            $px_x = $px[0];
            $px_y = $px[1];

            // Check for some fleets present in the system
            $useColor = $color[2];
            $useTitle = $system['system_name'];

            // Check all planets in the system
            foreach($planets as $planet) {

                // If planet belong to this system
                if ($planet['system_id'] == $system['system_id']) {

                    $useTitle .= ' : '.$planet['planet_name'].' : ';

                    // Check all fleets orbiting on this planet
                    foreach ($fleets as $fleet)
                    {
                        if($fleet['planet_id'] == $planet['planet_id'])
                        {
                            $useColor = $color[5];
                            $useTitle .= '<'.$fleet['fleet_name'].' ('.$fleet['n_ships'].' unit&agrave;)'.(isset($fleet['officer_name']) ? ':'.$fleet['officer_name'] : '').'> ';
                        }
                    }
                }
            }

            if ($size>2)
            {
                imagefilledrectangle ($im, $px_x,$px_y, $px_x+$size-2, $px_y+$size-2, $useColor);
                $map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.$px_x.','.$px_y.', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$useTitle.'">';
            }
            else
            {
                imagefilledrectangle ($im, $px_x-1,$px_y-1, $px_x+$size-2, $px_y+$size-2, $useColor);
                $map_data.='<area href="index.php?a=tactical_cartography&system_id='.encode_system_id($system['system_id']).'" target=_mapshow shape="rect" coords="'.$px_x.','.$px_y.', '.($px_x+$size-2).', '.($px_y+$size-2).'" title="'.$useTitle.'">';
            }
        }
    }

    if ($size<3) $size2=1;
    if ($size==3) $size2=2;
    else $size2=$size-2;

    if ($size>1)
    {
        imagestring ($im, $size2,15,162*$size-12-$size,$updated.date('d.m.y H:i', time()), $color[4]);
    }
    else
    {
        imagestring ($im, $size2,5,162*$size-15,$updated, $color[4]);
        imagestring ($im, $size2,5,162*$size-8,date('d.m.y H:i', time()), $color[4]);
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

    if (($handle = @fopen ($image_url, "rb"))!=true) echo $lost_image;
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

    echo'<html>
        <body bgcolor="#000000" text="#DDDDDD"  background="/gfx/bg_stars1.gif"><center>
        <span style="font-family: Verdana; font-size: 15px;"><b>'.$fleets_position.'</b></span><br>
        <img border=0 usemap="#detail_map" src="'.$image_url.'" >

        '.$map_data.'
        </center><br>
        </body></html>';
}

$db->close();

?>
