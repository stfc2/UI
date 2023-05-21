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

include_once('include/libs/world.php');

if(!empty($_GET['sector_id'])) {
    if(empty($_GET['x'])) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }
    
    if(empty($_GET['y'])) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }
    
    $results = array(create_system('slot', $_GET['sector_id'].':'.$_GET['x'].':'.$_GET['y']));
}
else {
    if(empty($_GET['id_type'])) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }

    if(!in_array($_GET['id_type'], array('quadrant', 'sector'))) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }

    if(empty($_GET['id_value'])) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }

    if(empty($_GET['n'])) {
        die('Usage: id_type=[quadrant,sector]&id_value=[integer]&n=[integer] OR sector_id=[integer]&x=[integer]&y=[integer]');
    }
    
    $results = array();

    for($i = 0; $i < $_GET['n']; ++$i) {
        $results[] = create_system($_GET['id_type'], $_GET['id_value']);
    }
}

for($i = 0; $i < count($results); ++$i) {
    $game->out('Created new system with ID <b>'.$results[$i][0].'</b> in sector <b>'.$results[$i][1].'</b><br>');
}

?>
