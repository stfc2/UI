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

$systems_per_quadrant = $planets_per_quadrant = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);

$sql = 'SELECT system_id, sector_id
        FROM starsystems';
        
if(!$q_systems = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query starsystems data');
    
}

while($_system = $db->fetchrow($q_systems)) {
    $systems_per_quadrant[$game->get_quadrant($_system['sector_id'])]++;
}

$sql = 'SELECT planet_id, sector_id
        FROM planets';
        
if(!$q_planets = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query planets data');
}

while($_planet = $db->fetchrow($q_planets)) {
    $planets_per_quadrant[$game->get_quadrant($_planet['sector_id'])]++;
}

$game->out('
<table cellpadding="2" cellspacing="2">
  <tr>
    <td width="150">&nbsp;</td>
    <td width="150">Systems</td>
    <td width="150">Planets</td>
  </tr>
  <tr>
    <td>Alpha</td>
    <td><b>'.$systems_per_quadrant[3].'</td>
    <td><b>'.$planets_per_quadrant[3].'</td>
  </tr>
  <tr>
    <td>Beta</td>
    <td><b>'.$systems_per_quadrant[4].'</td>
    <td><b>'.$planets_per_quadrant[4].'</td>
  </tr>
  <tr>
    <td>Gamma</td>
    <td><b>'.$systems_per_quadrant[1].'</td>
    <td><b>'.$planets_per_quadrant[1].'</td>
  </tr>
  <tr>
    <td>Delta</td>
    <td><b>'.$systems_per_quadrant[2].'</td>
    <td><b>'.$planets_per_quadrant[2].'</td>
  </tr>
  <tr><td height="10" colspan="3"></td></tr>
  <tr>
    <td>&nbsp;</td>
    <td><b><i>'.($systems_per_quadrant[1] + $systems_per_quadrant[2] + $systems_per_quadrant[3] + $systems_per_quadrant[4]).'</i></b></td>
    <td><b><i>'.($planets_per_quadrant[1] + $planets_per_quadrant[2] + $planets_per_quadrant[3] + $planets_per_quadrant[4]).'</i></b></td>
  </tr>
</table>
');

?>
