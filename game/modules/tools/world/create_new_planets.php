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

if(empty($_GET['id_type'])) {
    die('Usage: id_type=[quadrant,sector,system]&id_value=[integer]&n=[integer]<br><br>Optional: user_id=[integer]');
}

if(!in_array($_GET['id_type'], array('quadrant', 'sector', 'system'))) {
    die('Usage: id_type=[quadrant,sector,system]&id_value=[integer]&n=[integer]<br><br>Optional: user_id=[integer]');
}

if(empty($_GET['id_value'])) {
    die('Usage: id_type=[quadrant,sector,system]&id_value=[integer]&n=[integer]<br><br>Optional: user_id=[integer]');
}

if(empty($_GET['n'])) {
    die('Usage: id_type=[quadrant,sector,system]&id_value=[integer]&n=[integer]<br><br>Optional: user_id=[integer]');
}

include_once('include/libs/world.php');

if(!empty($_GET['user_id'])) $user_id = (int)$_GET['user_id'];
else $user_id = false;

$results = array();

for($i = 0; $i < $_GET['n']; ++$i) {
    $results[] = create_planet($user_id, $_GET['id_type'], $_GET['id_value']);
}

for($i = 0; $i < count($results); ++$i) {
    $game->out('Created new planet with ID <b>'.$results[$i].'</b><br>');
}

?>
