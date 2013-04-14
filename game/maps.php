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

function drawMapGrid($image,$size)
{
    // Allocate grid colors
    $grid  = imagecolorallocatealpha($image, 64, 64, 64,0);
    $grid2 = imagecolorallocatealpha($image, 128, 128, 128,0);
    $grid3 = imagecolorallocatealpha($image, 96, 96, 96,0);

    if ($size>2)
    {
        for ($t=0; $t<=162;$t++)
        {
            // Systems grid
            if($t == 0 || $t % 9)
            {
                imageline($image,0,$t*$size,162*$size,$t*$size,$grid);
                imageline($image,$t*$size,0,$t*$size,162*$size,$grid);
            }
            // Sectors grid is a little brighter
            else
            {
                imageline($image,0,$t*$size,162*$size,$t*$size,$grid3);
                imageline($image,$t*$size,0,$t*$size,162*$size,$grid3);
            }
        }
    }

    // Quadrant grid
    imageline($image,0,81*$size,162*$size,81*$size,$grid2);
    imageline($image,81*$size,0,81*$size,162*$size,$grid2);
}

function getSystemCoords($system,$size)
{
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

    return array($px_x,$px_y);
}

?>