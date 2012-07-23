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

$sql = 'SELECT *
        FROM starsystems_slots';
        
if(!$q_slots = $db->query($sql)) {
    message(DATABASE_ERROR, 'Could not query starsystem slots data');
}

$errors = array();
$sector_slots = array();
$n_slots = 0;

while($slot = $db->fetchrow($q_slots)) {
    if(!empty($sector_slots[$slot['sector_id']][$slot['system_x']][$slot['system_y']])) {
        $errors[] = array($slot['sector_id'], $slot['system_x'], $slot['system_y']);
    }
    else {
        $sector_slots[$slot['sector_id']][$slot['system_x']][$slot['system_y']] = true;
    }
    
    ++$n_slots;
}

$n_errors = count($errors);

$game->out('
<br>
<table width="400" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200">Checked slots:</td>
    <td width="200"><b>'.$n_slots.'</td>
  </tr>
  <tr>
    <td>Faulty slots:</td>
    <td><b>'.$n_errors.'</b></td>
  </tr>
  <tr height="10"><td></td></tr>
  <tr>
    <td colspan="2" width="400">
');

for($i = 0; $i < $n_errors; ++$i) {
    $game->out('- In sector <b>'.$errors[$i][0].'</b> position <b>'.$errors[$i][1].'</b>|<b>'.$errors[$i][2].'</b> is used twice<br>');
}

$game->out('
</table>
');

?>
