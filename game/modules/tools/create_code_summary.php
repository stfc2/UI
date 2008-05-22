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
$game->init_player();

check_auth(STGC_DEVELOPER);


$code_dirs = array(
    '.',
    './include',
    './include/libs',
    './modules',
    './modules/tools',
    './modules/tools/players',
    './modules/tools/ships',
    './modules/tools/test',
    './modules/tools/world',
    './scheduler',
);

 /*
$code_dirs = array(
    '../../alpha-2/game',
    '../../alpha-2/game/include',
    '../../alpha-2/game/modules',
    '../../alpha-2/game/modules/tools',
    '../../alpha-2/game/scheduler',
    '../../alpha-2/game/scheduler/actions',
);*/


$n_bytes = $n_lines = 0;

for($i = 0; $i < count($code_dirs); ++$i) {
    $dp = dir($code_dirs[$i]);
    
    while($entry = $dp->read()) {
        if( ($entry == '.') || ($entry == '..') ) continue;
        
        $path = $code_dirs[$i].'/'.$entry;
        
        if(!is_file($path)) continue;
        
        $n_bytes += filesize($path);
        $n_lines += count(file($path));
    }
    
    $dp->close();
}

$fp = fopen('./docs/code_summary.txt', 'w');
fputs($fp, 'Lines:'.$n_lines."\r\n".'Bytes:'.$n_bytes);
fclose($fp);

?>
