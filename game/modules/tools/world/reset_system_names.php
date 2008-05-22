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

$sql = 'SELECT system_id, system_name, sector_id, system_x, system_y
	    FROM starsystems';
	
if(!$q_systems = $db->query($sql)) {
	message(DATABASE_ERROR, 'Could not query starsystems');
}

while($cur_system = $db->fetchrow($q_systems)) {
	//if($cur_system['system_name'] == 'System '.$cur_system['system_id']) continue;
	
	$sql = 'UPDATE starsystems
			SET system_name = "System '.$game->get_sector_name($cur_system['sector_id']).':'.$game->get_system_cname($cur_system['system_x'], $cur_system['system_y']).'"
			WHERE system_id = '.$cur_system['system_id'];
			
	if(!$db->query($sql)) {
		message(DATABASE_ERROR, 'Could not update starsystem #'.$cur_system['system_id']);
	}
}

?>
