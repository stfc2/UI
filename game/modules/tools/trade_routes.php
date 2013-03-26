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

function print_route_info($route)
{
    $output = '<u>Player</u><br>';
    $output .= 'Name: '.(empty($route['user_name'])?'<i>cancelled</i>':$route['user_name']).'<br>';
    $output .= 'ID#: '.$route['user_id'].'<br><br>';
    $output .= '<u>Start Planet</u><br>';
    $output .= 'Name: '.$route['start_name'].'<br>';
    $output .= 'Owner: '.$route['start_owner_name'].'<br>';
    $output .= 'ID#:'.$route['start_owner'].'<br><br>';
    $output .= '<u>Dest Planet</u><br>';
    $output .= 'Name: '.$route['dest_name'].'<br>';
    $output .= 'Owner: '.$route['dest_owner_name'].'<br>';
    $output .= 'ID#:'.$route['dest_owner'].'<br><br>';
    return $output;
}

function print_unloading($actions) {
    global $game;

    $output = '<td>U:</td>';
    $wares = array(201 => 'metal', 202 => 'mineral', 203 => 'latinum', 204 => 'worker', 211 => 'unit1', 212 => 'unit2', 213 => 'unit3', 214 => 'unit4', 215 => 'unit5', 216 => 'unit6');

    foreach($wares as $code => $column) {
        if($actions[$code] == -1) {
            $output .= '<td width=60><img src='.$game->GFX_PATH.'menu_'.$column.'_small.gif><b><u>A</u></b></td>';
        }
        else {
            $output .= '<td width=60><img src='.$game->GFX_PATH.'menu_'.$column.'_small.gif>'.$actions[$code].'</td>';
        }
    }
    return $output;
}

function print_loading($actions) {
    global $game;

    $output = '<td>L:</td>';
    $resources = array(101 => 'metal', 102 => 'mineral', 103 => 'latinum');
    $units = array(104 => 'worker', 111 => 'unit1', 112 => 'unit2', 113 => 'unit3', 114 => 'unit4', 115 => 'unit5', 116 => 'unit6');

    foreach($resources as $code => $column) {
        $output .= '<td width=60><img src='.$game->GFX_PATH.'menu_'.$column.'_small.gif>'.(($actions[$code] == -1) ? '<b><u>A</u></b>' : $actions[$code]).'</td>';
    }

    foreach($units as $code => $column) {
        $output .= '<td width=60><img src='.$game->GFX_PATH.'menu_'.$column.'_small.gif>'.(($actions[$code] == -1) ? '<b><u>A</u></b>' : $actions[$code]).'</td>';
    }

    return $output;
}


$game->init_player();

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Last week&#146;s Trade Routes</span><br><br>');

$game->out('
<table align="center" width=650 border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr><td>
<table align="center" width=650 border=0 cellpadding=2 cellspacing=2 class="style_inner">
  <tr>
    <td><b>Details</b></td>
    <td><b>Operations</b></td> 
  </tr>
');

$sql = 'SELECT u.user_name, ss.user_id, ss.action_data,
               p1.planet_name AS start_name, p1.planet_owner AS start_owner,
               p2.planet_name AS dest_name, p2.planet_owner AS dest_owner,
               u1.user_name AS start_owner_name, u2.user_name AS dest_owner_name
               FROM (scheduler_shipmovement ss)
               LEFT JOIN (user u) ON ss.user_id = u.user_id
               LEFT JOIN (planets p1) ON p1.planet_id = ss.start
               LEFT JOIN (planets p2) ON p2.planet_id = ss.dest
               LEFT JOIN (user u1) ON p1.planet_owner = u1.user_id
               LEFT JOIN (user u2) ON p2.planet_owner = u2.user_id
        WHERE action_code = 34 AND ss.move_finish > '.($ACTUAL_TICK - 3360).' AND
              (p1.planet_owner <> ss.user_id OR p2.planet_owner <> ss.user_id)';

$q_routes = $db->query($sql);
$action_data = array();

while($route = $db->fetchrow($q_routes)) {
    $action_data = (array)unserialize($route['action_data']);

    $game->out('
  <tr>
    <td><a href="javascript:void(0);" onmouseover="return overlib(\''.print_route_info($route).'\',CAPTION,\'Details\', '.OVERLIB_STANDARD.');" onmouseout="return nd();">Detalis</a></td>
    <td>
       <table>
         <tr>
         '.print_unloading(&$action_data[4]).'
         </tr>
         <tr>
         '.print_loading(&$action_data[3]).'
         </tr>
      </table>
    </td>
  </tr>
    ');
}

$game->out('
</table>
</td></tr>
<tr><td>Legend:<ul>U = unload<br>L = load<br><b><u>A</u></b> = un/load All the resource available</ul></td></tr>
</table>
');

?>
