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
      <table align="center" border="0" cellpadding="2" cellspacing="2" class="style_inner">
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
                  <br><br>');
    switch($log['log_data'][4]) 
    {
        case 0:
            $game->out('
                  '.constant($game->sprache("TEXT168")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a>!<br><br>
                  '.constant($game->sprache("TEXT169")).'<i><b><a href="'.parse_link('a=ships&view=ship_details&id='.$log['log_data'][2]).'">'.$log['log_data'][3].'</a></b></i>'.constant($game->sprache("TEXT170")).' 
                  ');
            break;
        case 2:
            // log_data[5] = return code
            // log_data[6] = mood modifier
            switch($log['log_data'][5]) 
            {
                case -2:
                    $game->out(constant($game->sprache("TEXT166")));
                    break;
                case -1:
                    $game->out(constant($game->sprache("TEXT157")));
                    break;
                case  0:
                    $game->out('
                    '.constant($game->sprache("TEXT165")).' '.$log['log_data'][6].'.
                    ');               
                    break;
            }
        break;
        case 3:
            // log_data[5] = return code
            // log_data[6] = mood modifier
            // log_data[7] = text, type of research undergoing
            // log_data[8] = text, research time to finish on planet            

            $game->out(constant($game->sprache("TEXT33")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');
            
            switch($log['log_data'][5])
            {
                case -4:
                    $game->out(constant($game->sprache("TEXT172")));
                break;
                case -3:
                    $game->out(constant($game->sprache("TEXT173")));
                break;
                case -2:
                    $game->out(constant($game->sprache("TEXT174")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT175")));
                    break;
                case 0:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT171")).$log['log_data'][6].'.<br><br>
                    '.constant($game->sprache("TEXT177")).$log['log_data'][8].'.');
                break;
            }
        break;
        case 4:

            $game->out(constant($game->sprache("TEXT33")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');        
            
            switch($log['log_data'][5])
            {
                case -2:
                    $game->out(constant($game->sprache("TEXT178")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT180")));
                break;
                case 0:
                    $game->out(constant($game->sprache("TEXT179")).$log['log_data'][6].'.');
                break;
            }
        break;
        case 100:
            $game->out(constant($game->sprache("TEXT181")));
        break;
        case 101:
            // Settlers sends Troops
            $game->out('
                  '.constant($game->sprache("TEXT168")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a>!<br><br>
                  '.constant($game->sprache("TEXT182")));
        break;
        case 102:
            // Settlers sends Resources        
            $game->out('
                  '.constant($game->sprache("TEXT168")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a>!<br><br>
                  '.constant($game->sprache("TEXT183")));
        break;
    }            

    $game->out('</td>
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
