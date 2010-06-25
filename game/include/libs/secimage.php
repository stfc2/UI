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
$image=0;

function imageblend($x,$y,$filename,$image)
{
	$image2 = ImageCreateFromPNG($filename);
	imageAlphaBlending($image2, true);
	imageSaveAlpha($image2, true);
	$w = imagesx($image2);
	$h = imagesy($image2);
	imagecopy($image,$image2,$x,$y,0,0,$w,$h);
	imageAlphaBlending($image, true);
	imageSaveAlpha($image, true);
}


function circle($x,$y,$radius,$color)
{
	global $image;
	for ($rad=$radius-4; $rad<=$radius; $rad++)
		imagearc ( $image, $x,$y,$rad,$rad,0,360,$color);
}


function circle_sectioned($x,$y,$radius,$color)
{
	global $image;
	for ($rad=$radius-4; $rad<=$radius; $rad++)
		for ($sections=0; $sections<6; $sections++)
			imagearc ( $image, $x,$y,$rad,$rad,$sections*60,($sections)*60+40,$color);
}



function create_secimage()
{
	global $image;
	$ret=array();

	$width=250;
	$height=100;

	$image = imagecreatetruecolor($width, $height);
	imageAlphaBlending($image, true);
	imageSaveAlpha($image, true);
	$color_1=imagecolorallocate($image,150,150,250);
	$color_2=imagecolorallocate($image,80,80,80);


	imageblend(0,0,FIXED_GFX_PATH."sec-gfx/bg.png",$image);

	/* 25/06/10 - AC: Disabled races logos for readability
	$thumbs=array(FIXED_GFX_PATH."sec-gfx/cardassian.png",
		FIXED_GFX_PATH."sec-gfx/dominion.png",
		FIXED_GFX_PATH."sec-gfx/federation.png",
		FIXED_GFX_PATH."sec-gfx/ferengi.png",
	FIXED_GFX_PATH."sec-gfx/klingon.png",
		FIXED_GFX_PATH."sec-gfx/romlulan.png");
	shuffle($thumbs);

	$t=0;
	foreach ($thumbs as $value) 
	{
		imageblend($t*50,rand(0,$height-60),$value,$image);
		$t++;
	}*/


	for ($t=0; $t<6; $t++)
	{
		$color=imagecolorallocate($image,rand(40,255),rand(40,255),rand(40,255));
		circle(rand(25,$width-25),rand(25,$height-25),50,$color);
	}



	$color=imagecolorallocate($image,rand(40,255),rand(40,255),rand(40,255));
	$pos[0]=rand(25,$width-25);
	$pos[1]=rand(25,$height-25);

	circle_sectioned($pos[0],$pos[1],50,$color);

	$ret['center'] = implode(":", $pos);

	$md5=md5(rand(0,1000000));
	$ret['filename']='tmpsec/sec'.$md5.'.jpg';
	imagejpeg($image,$ret['filename'],20);

	return $ret;
}
?>
