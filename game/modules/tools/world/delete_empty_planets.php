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

/**
  * First of all, select all star systems with at lease one player in it.
  */
$sql = 'SELECT system_id FROM planets
			WHERE planet_owner <> 0';
			//GROUP BY system_id';

//$q_count = $db->queryrow($sql);
$q_count = $db->query($sql);

$i=0;
while($system = $db->fetchrow($q_count))
{
//echo('Populated systems: '.$system['system_id']);
$text[$i]=$system['system_id'];
$i++;
}

/**
  * Record future empty system ID before removing planets
  */
$sql = 'SELECT system_id FROM planets
		WHERE planet_owner = 0
		AND system_id NOT IN ('.implode(',',$text).')';

$empty_systems = $db->query($sql);

$sql = 'SELECT sector_id,system_x,system_y FROM starsystems
		WHERE system_id NOT IN ('.implode(',',$text).')';

$coords_empty_systems = $db->query($sql);


/**
 * Now remove all the planets without owner and that they are not in a 
 * populated system
 */
$sql = 'DELETE FROM planets
		WHERE planet_owner = 0
		AND system_id NOT IN ('.implode(',', $text).')';

echo('SQL query: '.$sql);

$del_pl = $db->query($sql);

echo('Result of deletion: '.$del_pl);

/**
 * Now set to empty freed star systems
 */
while($system = $db->fetchrow($empty_systems)) {
	//echo('Empty system: '.$system['system_id']);
    $sql = 'UPDATE starsystems
            SET system_n_planets = 0
            WHERE system_id = '.$system['system_id'];

    $db->query($sql);
}

/* Now delete starsystem without planets */
$sql = 'DELETE FROM starsystems WHERE system_n_planets = 0';

$del_sys = $db->queryrow($sql);

echo('Removed empty systems: '.$del_sys);

/* Optimize tables */
$db->query('OPTIMIZE planets');
$db->query('OPTIMIZE starsystems');

/**
 * Now free up previously occupied slot
 */
$i=0;
while($system = $db->fetchrow($coords_empty_systems)) {
	/* Free up occupied slot */
    $sql = 'INSERT INTO starsystems_slots (quadrant_id, sector_id, system_x, system_y)
            VALUES ('.$game->get_quadrant($system['sector_id']).', '.$system['sector_id'].', '.$system['system_x'].', '.$system['system_y'].')';
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert starsystem slot #'.$i);
    }

	$i++;
}


/**
 * Update Tactical view for all players
 */
$sql = 'UPDATE user SET last_tcartography_view = 0,last_tcartography_id = 0 WHERE 1';
if(!$db->query($sql)) {
	message(DATABASE_ERROR, 'Could not update tactical view!');
}


/*
 * For safety, replace all ships 
 */

$sql = 'SELECT user_id,user_capital FROM user WHERE 1';

$players = $db->query($sql);

while($player = $db->fetchrow($players)) {
	$sql = 'UPDATE ship_fleets
		SET planet_id = '.$player['user_capital'].'
		WHERE user_id = '.$player['user_id'];

	if(!$db->query($sql)) {
		message(DATABASE_ERROR, 'Could not update planet_id of '.$player['user_id'].'\'s fleet!');
	}

}



/*while($system = $db->fetchrow($q_count)) {
    $sql = 'UPDATE starsystems
            SET system_n_planets = '.$system['n_planets'].'
            WHERE system_id = '.$system['system_id'];
            
    $db->query($sql);
}*/

?>
