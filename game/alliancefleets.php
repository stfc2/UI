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


// Prepare localized strings
switch($game->player['language'])
{
    case 'GER':
        $not_member = 'You aren&#146;t a member of this alliance!';
        $not_allowed = 'You aren&#146;t allowed to use this function!';
        $fleets_position = 'Fleets position:';
    break;
    case 'ITA':
        $not_member = 'Non sei un membro di quest&#146;alleanza!';
        $not_allowed = 'Non hai i permessi per utilizzare questa funzione!';
        $not_allowed = 'Immagine perduta!';
        $fleets_position = 'Posizione flotte:';
    break;
    default:
        $not_member = 'You aren&#146;t a member of this alliance!';
        $not_allowed = 'You aren&#146;t allowed to use this function!';
        $not_allowed = 'Lost image!';
        $fleets_position = 'Fleets positions:';
    break;
}

// Read alliance ID from DB
$sql = 'SELECT alliance_id FROM alliance WHERE alliance_tag LIKE "'.addslashes($_GET['alliance']).'"';
$alliance = $db->queryrow($sql);
if(!isset($alliance['alliance_id']))
{
    exit;
}

// Name of the generated files:
$image_url='maps/tmp/alliance_'.$alliance['alliance_id'].'_fleets_'.$size.'.png';
$map_url='maps/tmp/alliance_'.$alliance['alliance_id'].'_fleets_'.$size.'.html';

// Check if player is currently member of this ally
if($game->player['user_alliance'] != $alliance['alliance_id'])
{
    echo'<html><body bgcolor="#000000" text="#DDDDDD"  background="/gfx/bg_stars1.gif"><center>
        <span style="font-family: Verdana; font-size: 32px;"><b>'.$not_member.'</b></span><br>
        </body></html>';
    exit;
}


// Check if player has permissions to see this
if($game->player['user_alliance_rights3'] != 1)
{
    echo'<html><body bgcolor="#000000" text="#DDDDDD"  background="/gfx/bg_stars1.gif"><center>
        <span style="font-family: Verdana; font-size: 32px;"><b>'.$not_allowed.'</b></span><br>
        </body></html>';
    exit;
}




// Delete old image, if exist
if (file_exists($image_url))
{
    if (filemtime($image_url)<time()-3600)
    {
        @unlink($image_url);
        @unlink($map_url);
    }
}


// Generate new image?:
if (($handle = @fopen ($image_url, "rb"))!=true)
{
    $map_data='<map name="detail_map">';

    $im = imagecreatetruecolor(162*$size, 162*$size);
    imagecolorallocatealpha($im, 0, 0, 0,0);
    $color[1]=imagecolorallocatealpha($im, 90, 64, 64,0);
    $color[2]=imagecolorallocatealpha($im, 128, 64, 64,0);
    $color[3]=imagecolorallocatealpha($im, 196, 64, 64,0);
    $color[4]=imagecolorallocatealpha($im, 96, 96, 96,0);
    $color[5]=imagecolorallocatealpha($im, 255, 0, 0,20);

    $grid=imagecolorallocatealpha($im, 64, 64, 64,0);
    $grid2=imagecolorallocatealpha($im, 128, 128, 128,0);
    $grid3=imagecolorallocatealpha($im, 96, 96, 96,0);

    if ($size>2)
    {
        for ($t=0; $t<=162;$t++)
        {
            // Systems grid
            if($t == 0 || $t % 9)
            {
                imageline($im,0,$t*$size,162*$size,$t*$size,$grid);
                imageline($im,$t*$size,0,$t*$size,162*$size,$grid);
            }
            // Sectors grid is a little brighter
            else
            {
                imageline($im,0,$t*$size,162*$size,$t*$size,$grid3);
                imageline($im,$t*$size,0,$t*$size,162*$size,$grid3);
            }
        }
    }

    // Quadrant grid
    imageline($im,0,81*$size,162*$size,81*$size,$grid2);
    imageline($im,81*$size,0,81*$size,162*$size,$grid2);


    // Read ALL starsystems from the DB
    $sql = 'SELECT s.system_id, s.system_name, s.sector_id, s.system_x, s.system_y FROM starsystems s';
    if(!$q_systems = $db->query($sql))
    {
        message(DATABASE_ERROR, 'Could not query starsystems data');
    }

    while($system = $db->fetchrow($q_systems))
        $glob_systems[$system['system_id']]=$system;

    // Select all members of the alliance
    $q_members = $db->query('SELECT user_id,user_name FROM user WHERE user_alliance='.$alliance['alliance_id']);
    $i = 0;
    while($member = $db->fetchrow($q_members)) {
        $members[$i]=$member['user_id'];
        $names[$members[$i]] = $member['user_name'];
        $i++;
    }

    // Select all starsystems of the alliance
    $q_planets = $db->query('SELECT system_id FROM planets WHERE planet_owner IN ('.implode(',',$members).') GROUP BY system_id');

    // Select all planets of the alliance that have at least a fleet in the orbit
    // NOTE: Here we can do some optimization, SELECTing fleets before doing this one
    $q_planets1 = $db->query('SELECT system_id, planet_id, planet_name FROM planets WHERE planet_owner IN ('.implode(',',$members).') AND planet_id IN (SELECT planet_id FROM ship_fleets WHERE user_id IN ('.implode(',',$members).'))');
    while($planet = $db->fetchrow($q_planets1))
        $planets[$planet['planet_id']]=$planet;

    // Select all fleets of the alliance
    $q_fleets = $db->query('SELECT * FROM ship_fleets WHERE user_id IN ('.implode(',',$members).')');
    while($fleet = $db->fetchrow($q_fleets))
        $fleets[$fleet['fleet_id']]=$fleet;

    // Create map
    while($planet = $db->fetchrow($q_planets))
    {
        $system=$glob_systems[$planet['system_id']];
        // Quadrant coordinates
        $system['sector_id']--;

        $px_x=81*$size;
        $px_y=81*$size;
        $tmp=$system['sector_id']-243;

        if ($system['sector_id']<243)
        {
            $px_x=0;
            $px_y=81*$size;
            $tmp=$system['sector_id']-162;
        }

        if ($system['sector_id']<162)
        {
            $px_x=81*$size;
            $px_y=0;
            $tmp=$system['sector_id']-81;
        }


        if ($system['sector_id']<81)
        {
            $px_x=0;
            $px_y=0;
            $tmp=$system['sector_id']-0;
        }


        // Sector coordinates
        $pos_x=0;
        $pos_y=0;

        while ($tmp>=9)
        {
            $tmp-=9;
            $pos_y++;
        };
        $pos_x=$tmp;


        $px_x+=$pos_x*$size*9;
        $px_y+=$pos_y*$size*9;


        // System coordinates
        $px_x+=($system['system_x'] - 1)*$size+1;
        $px_y+=($system['system_y'] - 1)*$size+1;

        // Check for some fleets present in the system
        $useColor = $color[2];
        $useTitle = $system['system_name'];
        $fleetsFound = false;
        $tmp_data = '';
        $firstSys = true;
        foreach ($planets as $key => $planet)
        {
            $firstPla = true;

            // If planet belong to this system
            if($planet['system_id'] == $system['system_id'])
            {
                $useTitle .= ' : '.$planet['planet_name'].' : ';

                if($firstSys) {
                    $firstSys = false;
                    $tmp_data .= '<tr><td>'.$system['system_name'].'</td><td>'.$planet['planet_name'].'</td>';
                }
                else
                    $tmp_data .= '<tr><td></td><td>'.$planet['planet_name'].'</td>';

                // Check all fleets orbiting on this planet
                foreach ($fleets as $key => $fleet)
                {
                    if($fleet['planet_id'] == $planet['planet_id'])
                    {
                        $useColor = $color[5];
                        $useTitle .= $fleet['fleet_name'].' ';
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
    };


    if ($size<3) $size2=1;
    if ($size==3) $size2=2;
    else $size2=$size-2;

    if ($size>1)
    {
        imagestring ($im, $size2,15,162*$size-12-$size,'Updated at '.date('d.m.y H:i', time()), $color[4]);
    }
    else
    {
        imagestring ($im, $size2,5,162*$size-15,'Updated at', $color[4]);
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

    echo'<html>
        <body bgcolor="#000000" text="#DDDDDD"  background="/gfx/bg_stars1.gif"><center>
        <span style="font-family: Verdana; font-size: 15px;"><b>Fleets of Alliance ['.$_GET['alliance'].']:</b></span><br>
        <img border=0 usemap="#detail_map" src="'.$image_url.'" >
        '.$map_data.'
        </center><br>
        </body></html>';
}

$db->close();

?>
