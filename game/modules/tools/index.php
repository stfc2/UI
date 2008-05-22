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

$dir = (!empty($_GET['dir'])) ? $_GET['dir'] : '';

$dirs = $modules = array();

$w_dir = dir('./modules/tools/'.$dir);

while($entry = $w_dir->read()) {
    if($entry != '.' && $entry != '..') {
    	if(is_dir('./modules/tools/'.$dir.'/'.$entry)) {
    		$dirs[] = $entry;
    	}
    	else {
    		$modules[] = str_replace('.php', '', $entry);
    	}
    }
}

$w_dir->close();

$game->out('<br><table width="80%" align="center"><tr><td>');

for($i = 0; $i < count($dirs); ++$i) {
	$game->out('- <a href="'.parse_link('a=tools/index&dir='.$dirs[$i]).'">'.$dir.' / '.$dirs[$i].'</a><br><br>');
}

for($i = 0; $i < count($modules); ++$i) {
    $game->out('- <a href="'.parse_link('a=tools/'.( (!empty($dir)) ? $dir.'/' : '' ).$modules[$i]).'">'.$modules[$i].'</a><br><br>');
   }

$game->out('</td></tr></table>');

?>
