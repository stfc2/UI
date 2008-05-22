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

if ($log['log_data']['resource_1']>0 || $log['log_data']['resource_2']>0 || $log['log_data']['resource_3']>0 || $log['log_data']['unit_1']>0 || $log['log_data']['unit_2']>0 || $log['log_data']['unit_3']>0 || $log['log_data']['unit_4']>0 || $log['log_data']['unit_5']>0 || $log['log_data']['unit_6']>0)
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
			Herzlichen Glückwunsch, '.$game->player['user_name'].'!<br>
			Deine Auktion "<a href="'.parse_link('&a=trade&view=view_bidding_detail&id='.$log['log_data']['auction_id']).'">'.$log['log_data']['auction_name'].'</a>" wurde  beendet.<br>Das Endgebot lag bei:
	        <img src="'.$game->GFX_PATH.'menu_metal_small.gif">&nbsp;'.$log['log_data']['resource_1'].'
			&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_mineral_small.gif">&nbsp;'.$log['log_data']['resource_2'].'
	        &nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_latinum_small.gif">&nbsp;'.$log['log_data']['resource_3'].'
&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit1_small.gif">&nbsp;'.$log['log_data']['unit_1'].'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit2_small.gif">&nbsp;'.$log['log_data']['unit_2'].'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit3_small.gif">&nbsp;'.$log['log_data']['unit_3'].'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit4_small.gif">&nbsp;'.$log['log_data']['unit_4'].'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit5_small.gif">&nbsp;'.$log['log_data']['unit_5'].'&nbsp;&nbsp;<img src="'.$game->GFX_PATH.'menu_unit6_small.gif">&nbsp;'.$log['log_data']['unit_6'].'<br>
			Käufer ist: <a href="'.parse_link('a=stats&a2=viewplayer&id='.$log['log_data']['player_id']).'">'.$log['log_data']['player_name'].'</a><br><br>
			Zum Steuern des weiteren Ablaufs geh in das Handelszentrum und klick auf "Treuhandkonto".<br><br>Sollte der Käufer nach einer Woche immer noch nicht gezahlt haben, bekommst du dein Schiff zurück.
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
    ');
else
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
                <td width="120" align="right"><b>'.date('d.m.y H:i:s', $log['log_date']).'</b></td>
              </tr>
            </table>
            <br>
			'.$game->player['user_name'].', deine Auktion "<a href="'.parse_link('&a=trade&view=view_bidding_detail&id='.$log['log_data']['auction_id']).'">'.$log['log_data']['auction_name'].'</a>" wurde  beendet.<br>Es wurden keine Gebote abgegeben.
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
