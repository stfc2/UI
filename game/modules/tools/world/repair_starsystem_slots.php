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
// Must be commented out because this tool cannot be used otherwise without planet

$game->init_player();

check_auth(STGC_DEVELOPER);

if(!isset($_GET['sure'])) {
	$game->out('<br><center>Really do a repair of the slots?<br><br><b>There MUST not be any slots already!</b><br><br><a href="'.parse_link('a=tools/world/repair_starsystem_slots&sure').'">Create new</a></center>');
	return;
}

$system_slots = array();
$n_slots = 0;

$n_sectors = $game->sectors_per_quadrant * 4;

for($i = 1; $i <= $n_sectors; ++$i) {
    $system_slots[$i] = array();
    
    for($j = 1; $j <= $game->sector_map_split; ++$j) {
        for($k = 1; $k <= $game->sector_map_split; ++$k) {
            $system_slots[$i][] = array($j, $k);
            ++$n_slots;
        }
    }
}

$game->out('Prepared '.$n_slots.' slots<br>');


$sql = 'SELECT sector_id, system_x, system_y
        FROM starsystems';

if(!($q_systems = $db->query($sql))) {
    message(DATABASE_ERROR, 'Could not select starsystems data');
}

while($cur_system = $db->fetchrow($q_systems)) {
    for($i = 0; $i < count($system_slots[$cur_system['sector_id']]); ++$i) {
        if( ($system_slots[$cur_system['sector_id']][$i][0] == $cur_system['system_x']) && ($system_slots[$cur_system['sector_id']][$i][1] == $cur_system['system_y']) ) {
            unset($system_slots[$cur_system['sector_id']][$i]);
            --$n_slots;
        }
    }
}

$game->out('Truncated to '.$n_slots.' through existing systems<br>');



for($i = 0; $i < $n_slots; ++$i) {
    $sector_id = array_rand($system_slots);
    $slot_number = array_rand($system_slots[$sector_id]);
    
    $sql = 'INSERT INTO starsystems_slots (quadrant_id, sector_id, system_x, system_y)
            VALUES ('.$game->get_quadrant($sector_id).', '.$sector_id.', '.$system_slots[$sector_id][$slot_number][0].', '.$system_slots[$sector_id][$slot_number][1].')';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert starsystem slot #'.$i);
    }
    
    unset($system_slots[$sector_id][$slot_number]);
    
    if(count($system_slots[$sector_id]) == 0) {
        unset($system_slots[$sector_id]);
    }
}

?>
