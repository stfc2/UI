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
include_once('include/global.php');
include_once('include/sql.php');
include_once('include/functions.php');

$game->init_player();

global $game;

$game->out('<center><span class="caption">Taktische Zentrale:</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">Stellare Kartographie</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">Schiffsbewegungen</a>]&nbsp;&nbsp;[<b>Spieler Info</b>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">Kolonisierung</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">Sensoren</a>]</center><br>

<table border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr>
<td width=450>
<center><a href="usermap.php?user='.$game->player['user_name'].'&size=6&map" target=_blank><img src="usermap.php?user='.$game->player['user_name'].'&size=2" border=0></a>
</center>
</td></tr></table>');

?>
