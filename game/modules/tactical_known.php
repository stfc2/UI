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

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">'.constant($game->sprache("TEXT1")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">'.constant($game->sprache("TEXT2")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">'.constant($game->sprache("TEXT3")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_kolo').'">'.constant($game->sprache("TEXT4")).'</a>]&nbsp;&nbsp;[<b>'.constant($game->sprache("TEXT5")).'</b>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">'.constant($game->sprache("TEXT6")).'</a>]<br><br>

<table border=0 cellpadding=2 cellspacing=2 class="style_outer"><tr>
<td width=450 align="center">
<a href="knownmap.php?size=6&map" target=_blank><img src="knownmap.php?size=2" border=0></a>
</td></tr></table>');

?>
