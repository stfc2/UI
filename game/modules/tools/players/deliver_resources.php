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

if(empty($_GET['ticks'])) {
    die('Usage: t=[ticks]');
}

$sql = ' UPDATE planets
         SET resource_1 = resource_1 + (add_1 * '.$_GET['ticks'].'),
             resource_2 = resource_2 + (add_2 * '.$_GET['ticks'].'),
             resource_3 = resource_3 + (add_3 * '.$_GET['ticks'].'),
             resource_4 = resource_4 + (add_4 * '.$_GET['ticks'].')';
             
$db->query($sql);

$sql = 'UPDATE planets
        SET resource_1 = max_resources
        WHERE resource_1 > max_resources';

$db->query($sql);

$sql = 'UPDATE planets
        SET resource_2 = max_resources
        WHERE resource_2 > max_resources';

$db->query($sql);

$sql = 'UPDATE planets
        SET resource_3 = max_resources
        WHERE resource_3 > max_resources';

$db->query($sql);

$sql = 'UPDATE planets
        SET resource_4 = max_worker
        WHERE resource_4 > max_worker';

$db->query($sql);

?>
