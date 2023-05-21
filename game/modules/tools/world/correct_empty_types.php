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

$type_probabilities = array(
    'a' => 5, 'b' => 5, 'c' => 5, 'd' => 8, 'e' => 12,
    'f' => 12, 'g' => 12, 'h' => 7, 'i' => 7, 'j' => 7,
    'k' => 7, 'l' => 8, 'm' => 1, 'n' => 1, 'y' => 3,
);

$type_array = array();

foreach($type_probabilities as $type => $probability) {
    for($i = 0; $i < $probability; ++$i) {
        $type_array[] = $type;
    }
}

$sql = 'SELECT planet_id
        FROM planets
        WHERE planet_type = ""';
        
if(!$q_eplanets = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query empty planets type data');
}

while($eplanet = $db->fetchrow($q_eplanets)) {
    $sql = 'UPDATE planets
            SET planet_type = "'.$type_array[array_rand($type_array)].'"
            WHERE planet_id = '.$eplanet['planet_id'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update planets type data #'.$eplanet['planet_id']);
    }
}

?>


