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

function stgc_nf($int) {
    return number_format($int, 0, '.', '.');
}

$game->out('<span class="caption">Unit Stats</span><br><br>');

$game->out('
<table align="center" width=450 border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr><td>
<table align="center" width=450 border=0 cellpadding=2 cellspacing=2 class="style_inner">
  <tr>
    <td width=150><b>Unit class</b></td>
    <td width=100><b>Stationed</b></td>
    <td width=100><b>On journey</b></td>
    <td width=100><b>Total</b></td>
  </tr>
');

$n_on_planets = $n_on_travel = 0;

for($i = 1; $i <= 6; ++$i) {
    $sql = 'SELECT SUM(unit_'.$i.') AS sum
            FROM planets';

    $units_on_planets = $db->queryrow($sql);

    $sql = 'SELECT SUM(unit_'.$i.') AS sum
            FROM ship_fleets
            WHERE planet_id = 0';

    $units_on_travel = $db->queryrow($sql);
    
    $game->out('
  <tr>
    <td>'.$UNIT_NAME[0][($i - 1)].'</td>
    <td>'.stgc_nf($units_on_planets['sum']).'</td>
    <td>'.stgc_nf($units_on_travel['sum']).'</td>
    <td>'.stgc_nf(($units_on_planets['sum'] + $units_on_travel['sum'])).'</td>
  </tr>
    ');
    
    $n_on_planets += $units_on_planets['sum'];
    $n_on_travel += $units_on_travel['sum'];
}

$game->out('
  <tr height=15><td></td></tr>
  <tr>
    <td><i><u>Total</u></i></td>
    <td>'.stgc_nf($n_on_planets).'</td>
    <td>'.stgc_nf($n_on_travel).'</td>
    <td>'.stgc_nf(($n_on_planets + $n_on_travel)).'</td>
  <tr>
</table>
</td></tr></table>
');

?>
