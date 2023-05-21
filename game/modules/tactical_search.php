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

global $QUADRANT_NAME;

$game->init_player();

$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>[<a href="'.parse_link('a=tactical_cartography').'">'.constant($game->sprache("TEXT1")).'</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=tactical_moves').'">'.constant($game->sprache("TEXT2")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_player').'">'.constant($game->sprache("TEXT3")).'</a>]&nbsp;&nbsp;[<b>'.constant($game->sprache("TEXT4")).'</b>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_known').'">'.constant($game->sprache("TEXT4a")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">'.constant($game->sprache("TEXT5")).'</a>]
            &nbsp;&nbsp;[<a href="'.parse_link('a=tactical_sensors').'">'.constant($game->sprache("TEXT5a")).'</a>]<br><br>');                

$action = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$planet_type_filter = filter_input(INPUT_POST, 'f_t_p', FILTER_SANITIZE_NUMBER_INT);
$planet_typ_filter_det = filter_input(INPUT_POST, 'f_t_p_det', FILTER_SANITIZE_NUMBER_INT);
$planet_type_filter_area = filter_input(INPUT_POST, 'f_t_p_a', FILTER_SANITIZE_NUMBER_INT);

if(isset($action)) {
    $html_result = '';
    $type_string = '';
    if($action == 'uno') {
        $html_result .= constant($game->sprache("TEXT12"));
    }
    elseif ($action == 'due') {
        $html_result .= constant($game->sprache("TEXT12"));
    }
    elseif ($action == 'tre') {
        $html_result .= constant($game->sprache("TEXT12"));
    }
    elseif ($action == 'quattro') {
        switch($planet_type_filter) {
            case 1:
                switch($planet_typ_filter_det){
                    case 1:
                        $type_string = '"m", "o", "p"';
                        break;
                    case 2:
                        $type_string = '"m"';
                        break;
                    case 3:
                        $type_string = '"o"';
                        break;
                    case 4:
                        $type_string = '"p"';
                        break;
                }
                break;
            case 2:
                switch($planet_typ_filter_det){
                    case 1:
                        $type_string = '"e", "f", "g", "l", "k"';                        
                        break;
                    case 2:
                        $type_string = '"e"';
                        break;
                    case 3:
                        $type_string = '"f"';
                        break;
                    case 4:
                        $type_string = '"g"';
                        break;
                    case 5:
                        $type_string = '"l"';
                        break;
                    case 6:
                        $type_string = '"k"';
                        break;                    
                }                
                break;
            case 3:
                switch($planet_typ_filter_det){
                    case 1: 
                        $type_string = '"x", "y"';
                        break;
                    case 2:
                        $type_string = '"x"';
                        break;
                    case 3:
                        $type_string = '"y"';
                        break;
                }
                break;
            case 4:
                switch($planet_typ_filter_det){
                    case 1:
                        $type_string = '"i", "j", "s", "t"';
                        break;
                    case 2:
                        $type_string = '"i"';
                        break;
                    case 3:
                        $type_string = '"j"';
                        break;
                    case 4:
                        $type_string = '"s"';
                        break;
                    case 5:
                        $type_string = '"t"';
                        break;
                }                
                break;
            case 5:
                switch($planet_typ_filter_det){
                    case 1:
                        $type_string = '"a", "b", "c", "d"';
                        break;
                    case 2:
                        $type_string = '"a"';
                        break;
                    case 3:
                        $type_string = '"b"';
                        break;
                    case 4:
                        $type_string = '"c"';
                        break;
                    case 5:
                        $type_string = '"d"';
                        break;
                }                
                break;
            case 6:
                switch($planet_typ_filter_det){
                    case 1:
                        $type_string = '"h", "n';
                        break;
                    case 2:
                        $type_string = '"h"';
                        break;
                    case 3:
                        $type_string = '"n"';
                        break;
                }                
                        
        }
        
        switch($planet_type_filter_area) {
            case 1:
                $area_search = '';
                break;
            case 2:
                // Alfa
                $sector_id_min = ( 2 * 81) + 1;
                $sector_id_max = 3 * 81;
                $area_search = ' AND p.sector_id >= '.$sector_id_min.' AND p.sector_id <= '.$sector_id_max.' ';
                break;
            case 3:
                // Beta
                $sector_id_min = ( 3 * 81) + 1;
                $sector_id_max = 4 * 81;                
                $area_search = ' AND p.sector_id >= '.$sector_id_min.' AND p.sector_id <= '.$sector_id_max.' ';
                break;
            case 4:
                // Gamma
                $sector_id_min = 1;
                $sector_id_max = 1 * 81;                
                $area_search = ' AND p.sector_id >= '.$sector_id_min.' AND p.sector_id <= '.$sector_id_max.' ';
                break;
            case 5:
                // Delta
                $sector_id_min = ( 1 * 81) + 1;
                $sector_id_max = 2 * 81;                                
                $area_search = ' AND p.sector_id >= '.$sector_id_min.' AND p.sector_id <= '.$sector_id_max.' ';
                break;
        }
        
        $sql = 'SELECT p.planet_id, p.system_id, p.sector_id, ss.system_name, p.planet_name, p.planet_type, p.planet_owner, u.user_name, pd.survey_1, pd.survey_2, pd.survey_3
                FROM (planets p)
                INNER JOIN (starsystems ss) USING (system_id)
                LEFT JOIN (user u) ON (p.planet_owner = u.user_id)
                LEFT JOIN (starsystems_details sd) USING (system_id)
                LEFT JOIN (planet_details pd) ON (p.planet_id = pd.planet_id AND pd.log_code = 100 AND pd.user_id = '.$game->player['user_id'].')
                WHERE p.planet_type IN ('.$type_string.') '.$area_search.'  
                  AND sd.user_id = '.$game->player['user_id'].' AND sd.log_code = 0';
        $res = $db->queryrowset($sql);
        foreach ($res AS $res_item) {
            $quadrant_id = ceil( ( $res_item['sector_id'] / 81) );
            $planet_type = strtoupper($res_item['planet_type']);
            $html_result .= '<tr><td><a href="'.parse_link('a=tactical_cartography&system_id='.encode_system_id($res_item['system_id'])).'">'.$res_item['system_name'].'</a></td><td>'.$QUADRANT_NAME[$quadrant_id].'</td><td><a href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($res_item['planet_id'])).'">'.$res_item['planet_name'].'</a></td><td>&nbsp;<a href="'.parse_link('a=database&planet_type='.$planet_type.'#'.$planet_type).'">'.$planet_type.'</a></td>';
            if(isset($res_item['survey_1'])) {
                $html_result .= '<td> (';
                switch ($res_item['survey_1']) {
                    case 0:
                        $html_result .= '<font color=red>-</font>|';
                        break;
                    case 1:
                        $html_result .= '<font color=grey>=</font>|';
                        break;
                    case 2:
                        $html_result .= '<font color=green>+</font>|';
                        break;                                
                }
                switch ($res_item['survey_2']) {
                    case 0:
                        $html_result .= '<font color=red>-</font>|';
                        break;
                    case 1:
                        $html_result .= '<font color=grey>=</font>|';
                        break;
                    case 2:
                        $html_result .= '<font color=green>+</font>|';
                        break;                                
                }                            
                switch ($res_item['survey_3']) {
                    case 0:
                        $html_result .= '<font color=red>-</font>';
                        break;
                    case 1:
                        $html_result .= '<font color=grey>=</font>';
                        break;
                    case 2:
                        $html_result .= '<font color=green>+</font>';
                        break;                                
                }
                $html_result .= ') </td>';
            }
            else {
                $html_result .= '<td>'.constant($game->sprache("TEXT13")).'</td>';
            }
    
            $html_result .= '</td><td>'.(isset($res_item['user_name']) ? $res_item['user_name'] : '<i>disabitato</i>').'</td></tr>';
        }
    }
}

if(!empty($html_result)) {
    $game->out('<table border="0" cellpadding="2" cellspacing="2" width="450" class="style_outer"><tr><td><table border="0" cellpadding="2" cellspacing="2" width="400" class="style_inner">'.$html_result.'</table></td></tr></table>');
}
$game->out('
<table border="0" cellpadding="2" cellspacing="2" width="450" class="style_outer">
  <tr>
    <td>
      <form name="ricerca" action="'.parse_link('a=tactical_search').'" method="post">
      <script src="search.js"></script>          
      <table border="0" cellpadding="2" cellspacing="2" width="440" class="style_inner">
	<tr>
          <td align="center">
            '.constant($game->sprache("TEXT6")).'          
          </td>
          <td align="center">
            '.constant($game->sprache("TEXT6A")).'          
          </td>
        </tr>
        <tr>
          <td align="center" rowspan="3">
            <select size="1" name="tipo">
            <option value="uno" '.($action == 'uno' ? 'selected' : '').'>'.constant($game->sprache("TEXT7")).'</option>
            <option value="due" '.($action == 'due' ? 'selected' : '').'>'.constant($game->sprache("TEXT8")).'</option>
            <option value="tre" '.($action == 'tre' ? 'selected' : '').'>'.constant($game->sprache("TEXT9")).'</option>
            <option value="quattro"  '.($action == 'quattro' ? 'selected' : '').'>'.constant($game->sprache("TEXT10")).'</option>    
            </select>
          </td>
          <td align="left">
            Gruppi&nbsp;=>&nbsp;<select size="1" name="f_t_p" onChange="set_f_t_p_det();">
            <option value="1" '.($planet_type_filter == 1 ? 'selected' : '').'> Abitabili (M/O/P) </option>
            <option value="2" '.($planet_type_filter == 2 ? 'selected' : '').'> Semi abitabili (E/F/G/L/K) </option>
            <option value="3" '.($planet_type_filter == 3 ? 'selected' : '').'> Pianeti infuocati (X/Y) </option>
            <option value="4" '.($planet_type_filter == 4 ? 'selected' : '').'> Giganti gassosi (I/J/S/T) </option>
            <option value="5" '.($planet_type_filter == 5 ? 'selected' : '').'> Planetoidi (A/B/C/D) </option>
            <option value="6" '.($planet_type_filter == 6 ? 'selected' : '').'> Desertici (H/N) </option>                
            </select>
          </td>
        </tr>
        <tr>
          <td align="left">
            Tipo&nbsp;&nbsp;&nbsp;&nbsp;=>&nbsp;<select size="1" name="f_t_p_det">
            <option value="1" selected> Tutti </option>
            <option value="2"> M </option>
            <option value="3"> O </option>
            <option value="4"> P </option>            
          </td>
        </tr>        
        <tr>
          <td align="left">
            Area&nbsp;&nbsp;&nbsp;=>&nbsp;<select size="1" name="f_t_p_a">
            <option value="1" '.($planet_type_filter_area == 1 ? 'selected' : '').'> Tutta la galassia </option>
            <option value="2" '.($planet_type_filter_area == 2 ? 'selected' : '').'> Quadrante Alfa </option>
            <option value="3" '.($planet_type_filter_area == 3 ? 'selected' : '').'> Quadrante Beta </option>
            <option value="4" '.($planet_type_filter_area == 4 ? 'selected' : '').'> Quadrante Gamma </option>
            <option value="5" '.($planet_type_filter_area == 5 ? 'selected' : '').'> Quadrante Delta </option>
            </select>          
          </td>        
        </tr>
        <tr>
          <td align="center" colspan="2">
            <input class="button" type="submit" value="'.constant($game->sprache("TEXT11")).'">
          </td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table');

?>