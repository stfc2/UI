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
    global $game,$BUILDING_NAME;

    $game->out('
<br>
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td>
      <table align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
        <tr>
          <td width="450">
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="450">
                  <table border=0 cellpadding=0 cellspacing=0>
                    <tr>
                      <td width="330" align="left"><b><u>'.$log['log_title'].'</u></b></td>
                      <td width="120" align="right"><b>'.date('d.m.y H:i:s', $log['log_date']).'</b></td>
                    </tr>
                  </table>
                  <br>
                  '.constant($game->sprache("TEXT128")).', '.$game->player['user_name'].'!<br>
                  '.constant($game->sprache("TEXT129")).'<br>
                  <img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.$log['log_data']['resource_1'].'
                  &nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.$log['log_data']['resource_2'].'
                  &nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.$log['log_data']['resource_3'].'
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
    ');
}

?>
