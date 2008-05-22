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

$game->out('<center><span class="caption">Taktische Zentrale:</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">Stellare Kartographie</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">Schiffsbewegungen</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">Spieler Info</a>]&nbsp;&nbsp;[<b>Kolonisierung</b>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">Sensoren</a>]</center><br>

<table border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr>
<td width=450>
<center><a href="kolomap.php?size=6&map" target=_blank><img src="kolomap.php?size=2" border=0></a>
</center>
</td></tr></table>');

?>
