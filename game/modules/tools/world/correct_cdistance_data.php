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

$sql = 'SELECT planet_id, planet_distance_px
        FROM planets
        WHERE planet_tick_cdistance = 0 OR
              planet_max_cdistance = 0';
              
if(!$q_planets = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query planets data');
}

while($planet = $db->fetchrow($q_planets)) {
    $sql = 'UPDATE planets
            SET planet_tick_cdistance = '.mt_rand(10, 30).',
                planet_max_cdistance = '.(2 * M_PI * $planet['planet_distance_px']).'
            WHERE planet_id = '.$planet['planet_id'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update planet #'.$planet['planet_id'].' cdistance data');
    }
}

?>
