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

<table align="center" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">

  <tr>

    <td width="450">

      <table border="0" cellpadding="0" cellspacing="0">

        <tr>

          <td width="450">

            <table border=0 cellpadding=0 cellspacing=0>

              <tr>

                <td width="330" align="left"><b><u>'.$log['log_title'].'</u></b></td>

                <td width="120" align="right"><b>'.date('d.m.y H:i:s', $log['log_date']+7200).'</b></td>

              </tr>

            </table>

            <br>

			Bei Aufständen auf dem Planeten <b>'.$log['log_data']['planet_name'].'</b> wurde das Gebäude "<b>'.$BUILDING_NAME[$game->player['user_race']][$log['log_data']['building_id']-1].'</b>" beschädigt und von Stufe <b>'.$log['log_data']['prev_level'].'</b> auf Stufe <b>'.($log['log_data']['prev_level']-1).'</b> gesetzt.<br>Es fehlen <b>'.(100-round($log['log_data']['troops_percent'])).'%</b> der benötigten Truppen, um die Unruhen aufhalten zu können.

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
