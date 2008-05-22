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


$magic_split = 9;


// Muss auskommentiert sein, da dieses Tool sonst nicht ohne Planet benutzt werden kann
//$game->init_player();

check_auth(STGC_DEVELOPER);

if(!isset($_GET['sure'])) {
	$game->out('<br><center>Wirklich alle Slots für Sternensysteme neu erstellen?<br><br><b>Die alten müssen vorher gelöscht sein!</b><br><br><a href="'.parse_link('a=tools/world/create_starsystem_slots&sure').'">Neu erstellen</a></center>');
	return;
}

$system_slots = $processed_sector_slots = array();
$n_slots = 0;

$n_sectors = pow( ($magic_split * 2), 2);
$systems_per_sector = pow($magic_split, 2);

for($i = 1; $i <= $n_sectors; ++$i) {
    $system_slots[$i] = array();
    $processed_sector_slots[$i] = 0;
    
    for($j = 1; $j <= $magic_split; ++$j) {
        for($k = 1; $k <= $magic_split; ++$k) {
            $system_slots[$i][] = array($j, $k);
            ++$n_slots;
        }
    }
}


for($i = 0; $i < $n_slots; ++$i) {
    $sector_id = array_rand($system_slots);
    $slot_number = array_rand($system_slots[$sector_id]);
    
    $sql = 'INSERT INTO starsystems_slots (quadrant_id, sector_id, system_x, system_y)
            VALUES ('.$game->get_quadrant($sector_id).', '.$sector_id.', '.$system_slots[$sector_id][$slot_number][0].', '.$system_slots[$sector_id][$slot_number][1].')';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert starsystem slot #'.$i);
    }
    
    unset($system_slots[$sector_id][$slot_number]);
    
    $processed_sector_slots[$sector_id]++;
    
    if($processed_sector_slots[$sector_id] == $systems_per_sector) unset($system_slots[$sector_id]);
}

?>
