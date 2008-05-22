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



$num_words = $db->queryrow('SELECT COUNT(word) AS num FROM wordlist');
$word = $db->queryrow('SELECT * FROM wordlist LIMIT '.rand(0, ($num_words['num'] - 1)).', 1');

$image = imagecreate(144,50);
$color_bg = imagecolorallocate($image, rand(0,20), rand(0,20), rand(0,20));

$xpos[0] = rand(5,12);

for($t = 1; $t < strlen($word['word']); $t++) {
    $xpos[$t] = $xpos[$t-1] + rand(8,12);
}

$x = 72 - $xpos[strlen($word['word']) - 1] / 2 - $xpos[0] / 2;

$ytot = rand(5,20);

$vert = 0;

while($vert < 90) {
    $color_line = imagecolorallocate($image, rand(0, 50) + 100, rand(0, 50) + 100, rand(0, 50) + 100);

    imageline($image, 0, $vert, 144, $vert, $color_line);

    $vert += rand(7, 10);
}

$hor = 0;

while($hor < 144) {
    $color_line = imagecolorallocate($image, rand(0, 50) + 100, rand(0, 50) + 100, rand(0, 50) + 100);

    $hor += rand(7, 10);

    imageline($image, $hor, 0, $hor, 49, $color_line);
}

for($t = 0; $t < strlen($word['word']); $t++) {
    $color_font = imagecolorallocate($image, rand(0, 50) + 205, rand(0, 50) + 205, rand(0, 50) + 205);

    $y = rand(0, 7);

    imagestring($image, 6, $x + $xpos[$t], $y + $ytot + 1, $word['word'][$t], $color_font);
}

$color_line = imagecolorallocate($image, rand(0, 50) + 100, rand(0, 50) + 100, rand(0, 50) + 100);

imageline($image, 0, 0, 143, 0, $color_line);
imageline($image, 0, 49, 143, 49, $color_line);
imageline($image, 0, 0, 0, 49, $color_line);
imageline($image, 143, 0, 143, 49, $color_line);

$md5 = md5(rand(0, 1000000));

imagepng($image, 'tmpsec/sec'.$md5.'.png');

?>
