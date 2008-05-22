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

//check_auth(STGC_DEVELOPER);


$used_slots = array();


$sql = 'SELECT sector_id, system_x, system_y
        FROM starsystems';
        
if(!$q_systems = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query systems data');
}

while($cur_system = $db->fetchrow($q_systems)) {
    if(empty($used_slots[$cur_system['sector_id']])) $used_slots[$cur_system['sector_id']] = array();
    if(empty($used_slots[$cur_system['sector_id']][$cur_system['system_x']])) $used_slots[$cur_system['sector_id']][$cur_system['system_x']] = array();
    
    $used_slots[$cur_system['sector_id']][$cur_system['system_x']][$cur_system['system_y']] = true;
}

$sql = 'SELECT sector_id, system_x, system_y
        FROM starsystems_slots';
        
if(!$q_slots = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query starsystems slots data');
}

$n_collisions = 0;

while($cur_slot = $db->fetchrow($q_slots)) {
    if(!empty($used_slots[$cur_slot['sector_id']][$cur_slot['system_x']][$cur_slot['system_y']])) {
        echo 'Collision detected in sector '.$cur_slot['sector_id'].' at '.$cur_slot['system_x'].':'.$cur_slot['system_y'].'<br>'.NL;
        
        $sql = 'DELETE FROM starsystems_slots
                WHERE sector_id = '.$cur_slot['sector_id'].' AND
                      system_x = '.$cur_slot['system_x'].' AND
                      system_y = '.$cur_slot['system_y'];
                      
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not delete slot data');
        }
        
        ++$n_collisions;
    }
}

echo $n_collisions.' in total';

?>
