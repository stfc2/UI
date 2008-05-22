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



function getimagesize_remote($image_url) {
    if(!$handle = @fopen($image_url, 'rb')) {
        return 0;
    }

    $contents = '';
    $count=0;

    if($handle) {
        do {
            $count += 1;
            $data = fread($handle, 8192);

            if(strlen($data) == 0) break;

            $contents .= $data;

            // Workaround für mehr Speed:
            //  Für die Größe reichen meist die ersten Bytes, er liest
            //  daher nur max. die ersten ~40 Bytes
            //
            // } while(true);
        } while($count <= 5);
    }
    else {
        return 0;
    }

    fclose ($handle);

    if(!$im = imagecreatefromstring($contents)) {
        return 0;
    }

    $gis[0] = Imagesx($im);
    $gis[1] = Imagesy($im);
    
    imagedestroy($im);

    // array member 3 is used below to keep with current getimagesize standards
    $gis[3] = "width={$gis[0]} height={$gis[1]}";

    return $gis;
}


function scale_image($filename, $width = 100, $height = 100) {
    $res[0] = $width;
    $res[1] = $height;

    $size = getimagesize_remote($filename);

    if( ($size[0] < $res[0]) && ($size[1] < $res[1]) ) {
        if( ($res[0] / $size[0]) > ($res[1] / $size[1]) ) {
            $width = $size[0] * ($res[1] / $size[1]);
            $height = $res[1];
        }
        else {
            $width = $res[0];
            $height = $size[1] * ($res[0] / $size[0]);
        }
    }
    elseif($size[0] < $res[0]) {
        $width = $size[0] * ($res[1] / $size[1]);
        $height = $res[1];
    }
    else {
        $width = $res[0];
        $height = $size[1] * ($res[0] / $size[0]);
    }

    $end_size[0] = $width;
    $end_size[1] = $height;

    return $end_size;
}

?>
