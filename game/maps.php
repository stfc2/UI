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
    $rows = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R'];
    $cols = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18'];
    
    // Allocate grid colors
    $grid  = imagecolorallocatealpha($image, 64, 64, 64,0);
    $grid2 = imagecolorallocatealpha($image, 128, 128, 128,0);
    $grid3 = imagecolorallocatealpha($image, 96, 96, 96,0);
    $grid4 = imagecolorallocatealpha($image, 204, 229, 255,40);

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
    
    /*
    $n_row = $n_col = 0;
    if ($size>2)
    {   
        for ($axe_x=3; $axe_x <= 158;$axe_x+=9)
        {
            $n_row = 0;
            for ($axe_y=3; $axe_y <= 158;$axe_y+=9)
            {
                $string = $rows[$n_row].$cols[$n_col];
                imagestring ($image, 5, $axe_x*$size, $axe_y*$size, $string, $grid4);
                $n_row++;
            }
            $n_col++;
        }
    }
    */
    // Chart rulers
    if ($size>2)
    {
        // X Axis
        $n_col = 0;        
        $axe_y = 75;
        for ($axe_x=3; $axe_x <= 158;$axe_x+=9)
        {
            if($n_col == 9) {
                $n_col++;
                continue;
            }
            imagestring ($image, 4, $axe_x*$size, $axe_y*$size, $cols[$n_col], $grid4);            
            $n_col++;
        }
        // Y Axis        
        $n_row = 0;        
        $axe_x = 85;
        for ($axe_y=3; $axe_y <= 158;$axe_y+=9)
        {
            if($n_row != 8) {
                imagestring ($image, 4, $axe_x*$size, $axe_y*$size, $rows[$n_row], $grid4);                            
            }
            else {
                imagestring ($image, 4, ($axe_x*$size)-8, $axe_y*$size, $rows[$n_row].'10', $grid4);                
            }
            $n_row++;
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