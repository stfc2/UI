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



/*
        $template_vars = array(
            'GFX_PATH' => $this->GFX_PATH,

            'U_LOGOUT' => parse_link('stgc_logout=1'),

            'STARDATE' => $this->config['stardate'],

            'U_HEADQUARTER' => parse_link('a=headquarter'),
            'L_HEADQUARTER' => $BUILDING_NAME[$this->player['user_race']][0],
            'U_BUILDINGS' => parse_link('a=building'),
            'L_BUILDINGS' => 'Gebäude',
            'U_RESEARCH' => parse_link('a=researchlabs'),
            'L_RESEARCH' => $BUILDING_NAME[$this->player['user_race']][8],
            'U_SPACEDOCK' => parse_link('a=spacedock'),
            'L_SPACEDOCK' => $BUILDING_NAME[$this->player['user_race']][6],
            'U_SHIPYARD' => parse_link('a=shipyard'),
            'L_SHIPYARD' => $BUILDING_NAME[$this->player['user_race']][7],
            'U_SHIPTEMPLATE' => parse_link('a=ship_template'),
            'L_SHIPTEMPLATE' => 'Schiffstemplates',
            'U_ACADEMY' => parse_link('a=academy'),
            'L_ACADEMY' => $BUILDING_NAME[$this->player['user_race']][5],
            'U_MINES' => parse_link('a=mines'),
            'L_MINES' => 'Minen',
            'U_TRADE' => parse_link('a=trade'),
            'L_TRADE' => $BUILDING_NAME[$this->player['user_race']][10],
            'U_PLANETLIST' => parse_link('a=planetlist'),
            'L_PLANETLIST' => 'Planeten',
            'U_FLEETS' => parse_link('a=ship_fleets_display'),
            'L_FLEETS' => 'Flotten',
            'U_TACTICAL' => parse_link('a=tactical_cartography'),
            'L_TACTICAL' => 'Taktik',
            'U_DIPLOMACY' => parse_link('a=user_diplomacy'),
            'L_DIPLOMACY' => 'Diplomatie',
            'U_ALLIANCE' => parse_link('a=alliance_main'),
            'L_ALLIANCE' => 'Allianz',
            'U_DATABASE' => parse_link('a=database'),
            'L_DATABASE' => 'Allgemein',
            'U_LOGBOOK' => parse_link('a=logbook'),
            'L_LOGBOOK' => ($this->player['unread_log_entries'] > 0) ? '<span style="color: #FFFF00; font-weight: bold;">Logbuch</span>' : 'Logbuch',
            'U_MESSAGES' => parse_link('a=messages'),
            'L_MESSAGES' => ($this->player['unread_messages'] > 0) ? '<span style="color: #FFFF00; font-weight: bold;">Nachrichten</span>' : 'Nachrichten',
            'U_PORTAL' => parse_link('a=portal'),
            'L_PORTAL' => 'Portal',
            'U_STATS' => parse_link('a=stats'),
            'L_STATS' => 'Rangliste',
            'U_SETTINGS' => parse_link('a=settings'),
            'L_SETTINGS' => 'Einstellungen',
            'U_HELP' => '../help.php',
            'L_HELP' => 'Hilfe',
            'U_SUPPORT' => parse_link('a=support'),
            'L_SUPPORT' => ($this->player['unread_support_tickets'] > 0) ? '<span style="color: #FFFF00; font-weight: bold;">Support</span>' : 'Support',
            'U_SUPPORTCENTER' => parse_link('a=supportcenter'),
            'L_SUPPORTCENTER' => 'Supportcenter',
            'U_ADMINPANEL' => parse_link('a=tools/index'),
            'L_ADMINPANEL' => 'Admin Panel',
            'U_PLANETSWITCH' => parse_link('a='.$this->current_module),
            'PLANET_SWITCH_HTML' => $planets_option_html,

            'NEXT_TICK_HTML' => '<b id="timer1" title="time1_'.$NEXT_TICK.'_type1_4">&nbsp;</b>',


            'USER_NAME' => $this->player['user_name'],
            'USER_POINTS' => $this->player['user_points'],
            'USER_RANKPOS' => $this->player['user_rank_points'],
            'USER_RANK' => 0,


            'ALLIANCE_NAME' => $this->player['alliance_name'],
            'ALLIANCE_TAG' => $this->player['alliance_tag'],

            'ACTIVE_PLANET_NAME' => $this->planet['planet_name'],
            'ACTIVE_PLANET_TYPE' => strtoupper($this->planet['planet_type']),
            'ACTIVE_PLANET_POINTS' => $this->planet['planet_points'],
            'ACTIVE_PLANET_MAXRES' => $this->planet['max_resources'],
            'ACTIVE_PLANET_METAL' => round($this->planet['resource_1'], 0),
            'ACTIVE_PLANET_MINERALS' => round($this->planet['resource_2'], 0),
            'ACTIVE_PLANET_LATINUM' => round($this->planet['resource_3'], 0),
            'ACTIVE_PLANET_WORKER' => round($this->planet['resource_4'], 0).' (+'.round($this->planet['add_4'], 1).')',
            'ACTIVE_PLANET_MAXTROOPS' => $this->planet['max_units'],
            'ACTIVE_PLANET_UNIT1' => $this->planet['unit_1'],
            'ACTIVE_PLANET_UNIT2' => $this->planet['unit_2'],
            'ACTIVE_PLANET_UNIT3' => $this->planet['unit_3'],
            'ACTIVE_PLANET_UNIT4' => $this->planet['unit_4'],
            'ACTIVE_PLANET_UNIT5' => $this->planet['unit_5'],
            'ACTIVE_PLANET_UNIT6' => $this->planet['unit_6'],

            'ACTIVE_PLANET_TROOPS' => $this->planet['unit_1'] * 2 + $this->planet['unit_2'] * 3 + $this->planet['unit_3'] * 4 + $this->planet['unit_4'] * 4 + $this->planet['unit_5'] * 4 + $this->planet['unit_6'] * 4,
            'ACTIVE_PLANET_STRENGTH' => $this->planet['unit_1'] * 2 + $this->planet['unit_2'] * 3 + $this->planet['unit_3'] * 4 + $this->planet['unit_4'] * 4,
            'ACTIVE_PLANET_STRENGTH_REQUIRED' => $this->planet['min_troops_required'],
            'ACTIVE_PLANET_TROOPS_REQUIRED' => $this->planet['min_troops_required'],

            'ACTIVE_PLANET_ORBITALDEFENSE' => $this->planet['building_10'],


            'ACTIVE_PLANET_ATTACKED' => (is_planet_attacked($this->planet['planet_id'])==true ? '<a href="index.php?a=tactical_sensors"><img src="'.$this->GFX_PATH.'menu_attack_small.gif" border=0></a>' : ''),

            'GAME_HTML' => &$this->game_html,
            'NOTEPAD_HTML' => &$notepad_html
        );
        */

define('GCT2_TAG_START', '<%');
define('GCT2_TAG_END', '%>');

define('GCT2_VAR_START', '{');
define('GCT2_VAR_END', '}');


function gct_compile_s($skin_id) {
    $tpl_file = 'templates/skins/'.$skin_id.'.tpl';

    if(!@is_file($tpl_file)) {
        message(GENERAL, 'Could not load skin template', $tpl_file.' does not exist');
    }
    
    $code = implode('', file($tpl_file));
    
    $gct2_tag = GCT2_TAG_START.' COMPILE_AS_GCT2 '.GCT2_TAG_END;
    
    if(substr($code, 0, strlen($gct2_tag)) == $gct2_tag) {
        $code = gct2_compile($code);
    }
    else {
        $code = gct1_compile($code);
    }
    
    $fp = fopen($tpl_file.'c', 'w');
    fputs($fp, $code);
    fclose($fp);
    
    return true;
}

function gct_compile_u($user_id) {
}


function gct1_compile($code) {
    $template_vars = array(
        'GFX_PATH' => '\'.$this->GFX_PATH.\'',

        'U_LOGOUT' => '\'.parse_link(\'stgc_logout=1\').\'',

        'STARDATE' => '\'.$this->config[\'stardate\'].\'',

        'U_HEADQUARTER' => '\'.parse_link(\'a=headquarter\').\'',
        'L_HEADQUARTER' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][0].\'',
        'U_BUILDINGS' => '\'.parse_link(\'a=building\').\'',
        'L_BUILDINGS' => 'Gebäude',
        'U_RESEARCH' => '\'.parse_link(\'a=researchlabs\').\'',
        'L_RESEARCH' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][8].\'',
        'U_SPACEDOCK' => '\'.parse_link(\'a=spacedock\').\'',
        'L_SPACEDOCK' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][6].\'',
        'U_SHIPYARD' => '\'.parse_link(\'a=shipyard\').\'',
        'L_SHIPYARD' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][7].\'',
        'U_SHIPTEMPLATE' => '\'.parse_link(\'a=ship_template\').\'',
        'L_SHIPTEMPLATE' => 'Schiffstemplates',
        'U_ACADEMY' => '\'.parse_link(\'a=academy\').\'',
        'L_ACADEMY' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][5].\'',
        'U_MINES' => '\'.parse_link(\'a=mines\').\'',
        'L_MINES' => 'Minen',
        'U_TRADE' => '\'.parse_link(\'a=trade\').\'',
        'L_TRADE' => '\'.$BUILDING_NAME[$this->player[\'user_race\']][10].\'',
        'U_PLANETLIST' => '\'.parse_link(\'a=planetlist\').\'',
        'L_PLANETLIST' => 'Planeten',
        'U_FLEETS' => '\'.parse_link(\'a=ship_fleets_display\').\'',
        'L_FLEETS' => 'Flotten',
        'U_TACTICAL' => '\'.parse_link(\'a=tactical_cartography\').\'',
        'L_TACTICAL' => 'Taktik',
        'U_DIPLOMACY' => '\'.parse_link(\'a=user_diplomacy\').\'',
        'L_DIPLOMACY' => 'Diplomatie',
        'U_ALLIANCE' => '\'.parse_link(\'a=alliance_main\').\'',
        'L_ALLIANCE' => 'Allianz',
        'U_DATABASE' => '\'.parse_link(\'a=database\').\'',
        'L_DATABASE' => 'Allgemein',
        'U_LOGBOOK' => '\'.parse_link(\'a=logbook\').\'',
        'L_LOGBOOK' => '\'.( ($this->player[\'unread_log_entries\'] > 0) ?  \'<span style="color: #FFFF00; font-weight: bold;">Logbuch</span>\' : \'Logbuch\' ).\'',
        'U_MESSAGES' => '\'.parse_link(\'a=messages\').\'',
        'L_MESSAGES' => '\'.( ($this->player[\'unread_messages\'] > 0) ? \'<span style="color: #FFFF00; font-weight: bold;">Nachrichten</span>\' : \'Nachrichten\' ).\'',
        'U_PORTAL' => '\'.parse_link(\'a=portal\').\'',
        'L_PORTAL' => 'Portal',
        'U_STATS' => '\'.parse_link(\'a=stats\').\'',
        'L_STATS' => 'Rangliste',
        'U_SETTINGS' => '\'.parse_link(\'a=settings\').\'',
        'L_SETTINGS' => 'Einstellungen',
        'U_HELP' => '../help.php',
        'L_HELP' => 'Hilfe',
        'U_SUPPORT' => '\'.parse_link(\'a=support\').\'',
        'L_SUPPORT' => '\'.( ($this->player[\'unread_support_tickets\'] > 0) ? \'<span style="color: #FFFF00; font-weight: bold;">Support</span>\' : \'Support\' ).\'',
        'U_SUPPORTCENTER' => '\'.( ($this->player[\'user_auth_level\'] == STGC_DEVELOPER || $this->player[\'user_auth_level\'] == STGC_SUPPORTER) ? parse_link(\'a=supportcenter\') : \'\' ).\'',
        'L_SUPPORTCENTER' => '\'.( ($this->player[\'user_auth_level\'] == STGC_DEVELOPER || $this->player[\'user_auth_level\'] == STGC_SUPPORTER) ? \'Supportcenter\' : \'\' ).\'',
        'U_ADMINPANEL' => '\'.( ($this->player[\'user_auth_level\'] == STGC_DEVELOPER ) ? parse_link(\'a=tools/index\') : \'\' ).\'',
        'L_ADMINPANEL' => '\'.( ($this->player[\'user_auth_level\'] == STGC_DEVELOPER ) ? \'Admin Panel\' : \'\' ).\'',
        'U_PLANETSWITCH' => '\'.parse_link(\'a=\'.$this->current_module).\'',
        'PLANET_SWITCH_HTML' => '\'.$planets_option_html.\'',

        'NEXT_TICK_HTML' => '<b id="timer1" title="time1_\'.$NEXT_TICK.\'_type1_4">&nbsp;</b>',

        'USER_NAME' => '\'.$this->player[\'user_name\'].\'',
        'USER_POINTS' => '\'.$this->player[\'user_points\'].\'',
        'USER_RANKPOS' => '\'.$this->player[\'user_rank_points\'].\'',
        'USER_RANK' => '\'.$RANK_STR.\'',

        'ALLIANCE_NAME' => '\'.$this->player[\'alliance_name\'].\'',
        'ALLIANCE_TAG' => '\'.$this->player[\'alliance_tag\'].\'',

        'ACTIVE_PLANET_NAME' => '\'.$this->planet[\'planet_name\'].\'',
        'ACTIVE_PLANET_TYPE' => '\'.strtoupper($this->planet[\'planet_type\']).\'',
        'ACTIVE_PLANET_POINTS' => '\'.$this->planet[\'planet_points\'].\'',
        'ACTIVE_PLANET_MAXRES' => '\'.$this->planet[\'max_resources\'].\'',
        'ACTIVE_PLANET_METAL' => '\'.round($this->planet[\'resource_1\'], 0).\'',
        'ACTIVE_PLANET_MINERALS' => '\'.round($this->planet[\'resource_2\'], 0).\'',
        'ACTIVE_PLANET_LATINUM' => '\'.round($this->planet[\'resource_3\'], 0).\'',
        'ACTIVE_PLANET_WORKER' => '\'.round($this->planet[\'resource_4\'], 0).\' (+\'.round($this->planet[\'add_4\'], 1).\')\'.\'',
        'ACTIVE_PLANET_MAXTROOPS' => '\'.$this->planet[\'max_units\'].\'',
        'ACTIVE_PLANET_UNIT1' => '\'.$this->planet[\'unit_1\'].\'',
        'ACTIVE_PLANET_UNIT2' => '\'.$this->planet[\'unit_2\'].\'',
        'ACTIVE_PLANET_UNIT3' => '\'.$this->planet[\'unit_3\'].\'',
        'ACTIVE_PLANET_UNIT4' => '\'.$this->planet[\'unit_4\'].\'',
        'ACTIVE_PLANET_UNIT5' => '\'.$this->planet[\'unit_5\'].\'',
        'ACTIVE_PLANET_UNIT6' => '\'.$this->planet[\'unit_6\'].\'',

        'ACTIVE_PLANET_TROOPS' => '\'.( $this->planet[\'unit_1\'] * 2 + $this->planet[\'unit_2\'] * 3 + $this->planet[\'unit_3\'] * 4 + $this->planet[\'unit_4\'] * 4 + $this->planet[\'unit_5\'] * 4 + $this->planet[\'unit_6\'] * 4 ).\'',
        'ACTIVE_PLANET_STRENGTH' => '\'.( $this->planet[\'unit_1\'] * 2 + $this->planet[\'unit_2\'] * 3 + $this->planet[\'unit_3\'] * 4 + $this->planet[\'unit_4\'] * 4 ).\'',
        'ACTIVE_PLANET_STRENGTH_REQUIRED' => '\'.$this->planet[\'min_troops_required\'].\'',
        'ACTIVE_PLANET_TROOPS_REQUIRED' => '\'.$this->planet[\'min_troops_required\'].\'',

        'ACTIVE_PLANET_ORBITALDEFENSE' => '\'.$this->planet[\'building_10\'].\'',

        'ACTIVE_PLANET_ATTACKED' => '\'.( (is_planet_attacked($this->planet[\'planet_id\'])==true ? \'<a href="index.php?a=tactical_sensors"><img src="\'.$this->GFX_PATH.\'menu_attack_small.gif" border=0></a>\' : \'\') ).\'',

        'GAME_HTML' => '\'.$this->game_html.\'',
        'NOTEPAD_HTML' => '\'.$notepad_html.\''
    );
    
    foreach($template_vars as $name => $content) {
        $code = str_replace('{'.$name.'}', $content, $code);
    }
    
    $code = '<'.'?php'.NL.NL.
            '// GCT1 Executable Code'.NL.
            '// Compiled on '.date('d.m.Y - H:i:s').NL.NL.
            'echo \''.$code.'\';'.NL.
            '?'.'>';
            
    return $code;
}


function gct2_compile($code) {
    $tag_blocks   = array();
    $c_tag_blocks = array();
    $plain_blocks = array();

    preg_match_all('/'.GCT2_TAG_START.' (.*?) (.*?)?[ ]?'.GCT2_TAG_END.'/si', $code, $tag_blocks);
    $plain_blocks = preg_split('/'.GCT2_TAG_START.' (.*?) (.*?)?[ ]?'.GCT2_TAG_END.'/si', $code);

    for($i = 0; $i < count($plain_blocks); ++$i) {
        $plain_blocks[$i] = gct2_compile_var_tags(str_replace("'", "\'", $plain_blocks[$i]));
    }

    for($i = 0; $i < count($tag_blocks[1]); ++$i) {
        $cmd = strtoupper($tag_blocks[1][$i]);
        $arguments = $tag_blocks[2][$i];

        switch($cmd) {
            case 'COMPILE_AS_GCT2':
                // nichts tun
            break;
            
            case 'IF':
                $c_tag_blocks[] = '//! (conditional) BEGIN ->'.NL.
                                   gct2_compile_conditional_tag($arguments, false);
            break;

            case 'ELSEIF':
                $c_tag_blocks[] = gct2_compile_conditional_tag($arguments, true);
            break;

            case 'ELSE':
                $c_tag_blocks[] = '}'.NL.
                                  'else {';
            break;

            case 'ENDIF':
                $c_tag_blocks[] = '}'.NL.
                                  '//! (conditional) END <-';
            break;
        }
    }

    $compiled_code = '<'.'?php'.NL.NL.
                     '// GCT2 Executable Code'.NL.
                     '// Compiled on '.date('d.m.Y - H:i:s').NL;
                     
    for($i = 0; $i < count($plain_blocks); $i++) {
        $trim_plain = trim($plain_blocks[$i]);
        $cur_tags = current($c_tag_blocks);

        if(!empty($trim_plain)) {
            $compiled_code .= NL.'//! HTML'.NL.
                              'echo \''.$trim_plain.'\';'.
                              NL.'//! HTML'.NL;
        }

        if(!empty($act_tags)) $compiled_code .= NL.$cur_tags.NL;

        next($c_tag_blocks);
    }
    
    $compiled_code .= NL.'?'.'>';

    return $compiled_code;
}

function gct2_compile_var_tags($code, $dequote = true) {
    preg_match_all('/'.GCT2_VAR_START.'(.*?)'.GCT2_VAR_END.'/si', $code, $matches);

    if(count($matches[0]) > 0) {
        for($i = 0; $i < count($matches[0]); ++$i) {
            if(!empty($matches[1][$i])) {
                $c_var_tag = '$this->tpl_vars';
                $split_var_tag = explode('.', $matches[1][$i]);

                for($j = 0; $j < count($split_var_tag); ++$j) {
                    $c_var_tag .= '[\''.$split_var_tag[$j].'\']';
                }

                $code = ($dequote) ? str_replace($matches[0][$i], '\'.'.$c_var_tag.'.\'', $code) : str_replace($matches[0][$i], $c_var_tag, $code);
            }
        }
    }

    return $code;
}

function gct2_compile_conditional_tag($tag_args, $else_if = false) {
    preg_match_all('/(?:
                     "[^"\\\\]*(?:\\\\.[^"\\\\]*)*"         |
                     \'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'     |
                     [(),]                                  |
                     [^\s(),]+
                    )/x', $tag_args, $matches);
    $tags = array();

    for($i = 0; $i < count($matches[0]); ++$i) {
        $tags[$i] = $this->compile_var_tags($matches[0][$i], false);
    }

    $condition_string = ( ($else_if) ? '}'.NL.'elseif(' : 'if(' ) . implode(' ', $tags) .') {';

    return $condition_string;
}

?>
