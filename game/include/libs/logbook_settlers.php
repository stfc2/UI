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
        case 1:
            $game->out('
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>');
            $game->out('<td width="65" valign="top">'.constant($game->sprache("TEXT33")).'&nbsp;</td> <td width="385"><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');

            $game->out(constant($game->sprache("TEXT158")).' '.$log['log_data'][5]['user_mood']);

            $game->out('<br><br>');

            if(isset($log['log_data'][5]['toptenlist'][0])) {
                $game->out(constant($game->sprache("TEXT159")).'<br><br>');
                foreach($log['log_data'][5]['toptenlist'] as $other_user) {
                    $game->out('<b>'.$other_user['user_name'].'</b> '.constant($game->sprache("TEXT160")).' '.$other_user['mood_value'].'.<br>');
                }
            }

            $game->out('<br><br>');

            if(isset($log['log_data'][6]['research_1']))
            {
                $game->out('Modifica Ambientale <b>aggiornabile</b>');
                if(isset($log['log_data'][6]['time_1']))
                {
                    $game->out(', coda di lavoro disponibile tra: '.$log['log_data'][6]['time_1']);
                }
                $game->out('<br>');
            }

             if(isset($log['log_data'][6]['research_2']))
             {
                 $game->out('Ricerche Mediche <b>aggiornabili</b>');
                 if(isset($log['log_data'][6]['time_2']))
                 {
                     $game->out(', coda di lavoro disponibile tra: '.$log['log_data'][6]['time_2']);
                 }
                 $game->out('<br>');
             }

             if(isset($log['log_data'][6]['research_3']))
             {
                 $game->out('Strutture Difensive <b>aggiornabili</b>');
                 if(isset($log['log_data'][6]['time_3']))
                 {
                     $game->out(', coda di lavoro disponibile tra: '.$log['log_data'][6]['time_3']);
                 }
                 $game->out('<br>');
             }

             if(isset($log['log_data'][6]['research_4']))
             {
                 $game->out('Automazione <b>aggiornabile</b>');
                 if(isset($log['log_data'][6]['time_4']))
                 {
                     $game->out(', coda di lavoro disponibile tra: '.$log['log_data'][6]['time_4']);
                 }
                 $game->out('<br>');
             }

             if(isset($log['log_data'][6]['research_5']))
             {
                 $game->out('Estrazione Risorse <b>aggiornabile</b>');
                 if(isset($log['log_data'][6]['time_5']))
                 {
                     $game->out(', coda di lavoro disponibile tra: '.$log['log_data'][6]['time_5']);
                 }
                 $game->out('<br>');
             }
            $game->out('</td></tr></table>');
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
                case -6:
                    $game->out(constant($game->sprache("TEXT202")));
                break;
                case -5:
                    $game->out(constant($game->sprache("TEXT178")));
                break;                
                case -4:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT172")));
                break;
                case -3:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT173")));
                break;
                case -2:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT174")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT175")));
                    break;
                case 0:
                    $game->out(constant($game->sprache("TEXT176")).$log['log_data'][7].'.<br><br>');
                    $game->out(constant($game->sprache("TEXT171")).$log['log_data'][6].'.<br><br>
                    '.constant($game->sprache("TEXT177")).$log['log_data'][8].'.');
                break;
            }
            if(isset($log['log_data'][9][0]))
            {
                $game->out('<br><br>'.constant($game->sprache("TEXT201")).'<br><table border=0 cellpadding=0 cellspacing=0>');
                foreach($log['log_data'][9] as $text_string) $game->out($text_string);
                $game->out('</table>');
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
            
            if(isset($log['log_data'][7][0]))
            {
                $game->out('<br><br>'.constant($game->sprache("TEXT201")).'<br><table border=0 cellpadding=0 cellspacing=0>');
                foreach($log['log_data'][7] as $text_string) $game->out($text_string);
                $game->out('</table>');
            }
        break;
        case 5:

            $game->out(constant($game->sprache("TEXT33")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');

            switch($log['log_data'][5])
            {
                case -5:
                    $game->out(constant($game->sprache("TEXT219")));
                    break;
                case -4:
                    $game->out(constant($game->sprache("TEXT200")));
                break;
                case -3:
                    $game->out(constant($game->sprache("TEXT189")));
                break;
                case -2:
                    $game->out(constant($game->sprache("TEXT190")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT191")));
                break;
                case 0:
                    $game->out(constant($game->sprache("TEXT192")));
                break;
            }
            
        break;
        case 10:
            switch($log['log_data'][5])
            {
                case -7:
                    $game->out(constant($game->sprache("TEXT178")));
                    break;
                case -6:
                    $game->out(constant($game->sprache("TEXT210")));
                break;
                case -5:
                    $game->out(constant($game->sprache("TEXT175")));
                break;
                case -4:
                    $game->out(constant($game->sprache("TEXT193")));
                break;
                case -3:
                    $game->out(constant($game->sprache("TEXT194")));
                break;
                case -2:
                    $game->out(constant($game->sprache("TEXT195")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT199")));
                break;
                case 0:
                    $game->out(constant($game->sprache("TEXT196")));
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT196")));
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
            switch ($log['log_data'][5]) {
                case 0:
                    $game->out('<br><br>'.constant($game->sprache("TEXT211")));
                break;
                case 1:
                    $game->out('<br><br>'.constant($game->sprache("TEXT212")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][6])).'"><b>'.$log['log_data'][7].'</b>.</a>');
                break;
            }
            $game->out('<ul>');
            if(isset($log['log_data'][8]['ress_4']) && !empty($log['log_data'][8]['ress_4'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_worker_small.gif"> '.$log['log_data'][8]['ress_4'].'</li>');
            }
            if(isset($log['log_data'][8]['unit_1']) && !empty($log['log_data'][8]['unit_1'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_unit1_small.gif"> '.$log['log_data'][8]['unit_1'].'</li>');
            }
            if(isset($log['log_data'][8]['unit_2']) && !empty($log['log_data'][8]['unit_2'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_unit2_small.gif"> '.$log['log_data'][8]['unit_2'].'</li>');                
            }
            if(isset($log['log_data'][8]['unit_5']) && !empty($log['log_data'][8]['unit_5'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_unit5_small.gif"> '.$log['log_data'][8]['unit_5'].'</li>');                
            }
            if(isset($log['log_data'][8]['unit_6']) && !empty($log['log_data'][8]['unit_6'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_unit6_small.gif"> '.$log['log_data'][8]['unit_6'].'</li>');                
            }            
            $game->out('</ul>');            
        break;
        case 102:
            // Settlers sends Resources        
            $game->out('
                  '.constant($game->sprache("TEXT168")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a>!<br><br>
                  '.constant($game->sprache("TEXT183")));
            switch ($log['log_data'][5]) {
                case 0:
                    $game->out('<br><br>'.constant($game->sprache("TEXT213")).'<br><br>');
                break;
                case 1:
                    $game->out('<br><br>'.constant($game->sprache("TEXT214")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][6])).'"><b>'.$log['log_data'][7].'</b>.</a><br><br>');
                break;
            }
            $game->out('<ul>');
            if(isset($log['log_data'][8]['ress_1']) && !empty($log['log_data'][8]['ress_1'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_metal_small.gif"> '.number_format($log['log_data'][8]['ress_1'], 0, ',', '.').'</li>');
            }
            if(isset($log['log_data'][8]['ress_2']) && !empty($log['log_data'][8]['ress_2'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_mineral_small.gif"> '.number_format($log['log_data'][8]['ress_2'], 0, ',', '.').'</li>');
            }
            if(isset($log['log_data'][8]['ress_3']) && !empty($log['log_data'][8]['ress_3'])) {
                $game->out('<li><img src="'.$game->GFX_PATH.'menu_latinum_small.gif"> '.number_format($log['log_data'][8]['ress_3'], 0, ',', '.').'</li>');
            }
            $game->out('</ul>');
        break;
        case 103:
            // Automatic distress call for Borg attack
            $game->out('
                  '.constant($game->sprache("TEXT184")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>
                  '.constant($game->sprache("TEXT185")));
        break;
        case 104:
            // Distress call for Borg attack
            $game->out('
                  '.constant($game->sprache("TEXT186")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>
                  '.constant($game->sprache("TEXT187")));
        break;
        case 105:
            // Player conquer Settlers colony
            $game->out('
                  '.constant($game->sprache("TEXT184")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>
                  '.constant($game->sprache("TEXT188")).$log['log_data'][6].'.');
        break;
        case 106:
            // Player mission ambushed by Hirogen Hunters

            $game->out(constant($game->sprache("TEXT209")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');
                        
            switch($log['log_data'][5])
            {
                case -2:
                    $game->out(constant($game->sprache("TEXT208")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT207")));
                break;            
                case 0:
                    $game->out(constant($game->sprache("TEXT197")));
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT198")));
                break;
            }                
        break;
        case 107:
            // Hirogeni Hunters reporting in

            $game->out(constant($game->sprache("TEXT209")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');
            
            switch($log['log_data'][5])
            {            
                case -2:
                    $game->out(constant($game->sprache("TEXT203")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT204")));
                break;            
                case 0:
                    $game->out(constant($game->sprache("TEXT205")));
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT206")));
                break;
            }
        break;
        case 108:
            // Player mission ambushed by Kazon Raiders

            $game->out(constant($game->sprache("TEXT209")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');
                        
            switch($log['log_data'][5])
            {
                case -2:
                    $game->out(constant($game->sprache("TEXT208")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT207")));
                break;            
                case 0:
                    $game->out(constant($game->sprache("TEXT197")));
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT225")));
                break;
            }                
        break;
        case 109:
            // Kazon Raiders reporting in

            $game->out(constant($game->sprache("TEXT209")).' <a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($log['log_data'][0])).'"><b>'.$log['log_data'][1].'</b></a><br><br>');
            
            switch($log['log_data'][5])
            {            
                case -2:
                    $game->out(constant($game->sprache("TEXT221")));
                break;
                case -1:
                    $game->out(constant($game->sprache("TEXT222")));
                break;            
                case 0:
                    $game->out(constant($game->sprache("TEXT223")));
                break;
                case 1:
                    $game->out(constant($game->sprache("TEXT224")));
                break;
            }
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
