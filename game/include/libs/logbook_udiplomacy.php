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



function display_logbook($log) {
    global $game;

    $game->out('
<br>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td width="450">
    ');
    
    switch($log['log_data']['what']) {
        case 'break':
            $game->out(constant($game->sprache("TEXT138")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data']['who_id']).'">'.$log['log_data']['who_name'].'</a> '.constant($game->sprache("TEXT139")));
        break;
    }

    $game->out('
    </td>
  </tr>
</table>
<br>
    ');
}

?>
