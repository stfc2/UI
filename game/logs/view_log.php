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
if(!empty($_GET['file'])) {
    $filename = $_GET['file'].'.log';
    if (file_exists($filename))
    {
        $gzip_contents = '<table border=0>'.implode('', file($filename)).'</table>';

        $gzip_size = strlen($gzip_contents);
        $gzip_crc = crc32($gzip_contents);

        $gzip_contents = gzcompress($gzip_contents, 9);
        $gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

        header('Content-Encoding: gzip');

        echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        echo $gzip_contents;
        echo pack('V', $gzip_crc);
        echo pack('V', $gzip_size);
    }
    else {
        $gzip_contents = implode('',file($filename.'.gz'));

        header('Content-Encoding: gzip');

        echo $gzip_contents;
    }
}
else {
    header('Location: view_log.php?file=tick_'.date('d-m-Y', time()));
}

?>
