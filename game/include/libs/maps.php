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



class math {
    function pythagoras_hc($hypotenuse, $cathetus) {
        return sqrt( ( ($hypotenuse * $hypotenuse) - ($cathetus * $cathetus) ) );
    }

    function pythagoras_cc($cathetus1, $cathetus2) {
        return sqrt( ( ($cathetus1 * $cathetus1) + ($cathetus2 * $cathetus2) ) );
    }
}


class maps {
    function maps() {
        global $game;
        
        $this->galaxy_map_size = $game->galaxy_map_size;
        $this->quadrant_map_size = $game->quadrant_map_size;
        $this->sector_map_size = $game->sector_map_size;
        $this->system_map_size = $game->system_map_size;
        
        $this->galaxy_detail_map_size = $game->galaxy_detail_map_size;

        $this->quadrant_map_split = $game->quadrant_map_split;
        $this->sector_map_split = $game->sector_map_split;
        $this->system_max_planets = $game->system_max_planets;
        $this->starsize_range = $game->starsize_range;
        $this->planet_distances = $game->planet_distances;

        $this->sectors_per_quadrant = $game->sectors_per_quadrant;
        $this->max_sectors = $game->max_sectors;
        $this->max_systems_per_sector = $game->max_systems_per_sector;
    }

    function draw_horizontal_dotline($im, $x1, $x2, $y, $color, $dot_distance = 2) {
        $x_cur = $x1;

        while ($x_cur <= $x2) {
            imagesetpixel($im, $x_cur, $y, $color);
            $x_cur += $dot_distance;
        }

        return true;
    }

    function draw_vertical_dotline($im, $y1, $y2, $x, $color, $dot_distance = 2) {
        $y_cur = $y1;

        while ($y_cur <= $y2) {
            imagesetpixel($im, $x, $y_cur, $color);
            $y_cur += $dot_distance;
        }

        return true;
    }

    function draw_stars($im, $map_size, $number) {
        $cl_white = imagecolorallocate($im, 140, 140, 140);

        for($i = 0; $i < $number; ++$i) {
            imagesetpixel($im, mt_rand(3, ($map_size - 3)), mt_rand(3, ($map_size - 3)), $cl_white);
        }

        return true;
    }

    function draw_split_borders($im, $map_size, $n_split, $dot_distance) {
        //$cl_border = imagecolorallocate($im, 255, 90, 10);
        $cl_border = imagecolorallocate($im, 200, 150, 150);

        $required_borders = ($n_split - 1);
        $px_per_field = ($map_size - $required_borders) / $n_split;

        for($i = 1; $i <= $required_borders; ++$i) {
            $this->draw_vertical_dotline($im, 0, $map_size, ($i * $px_per_field) + $i, $cl_border, $dot_distance);
        }

        for($i = 1; $i <= $required_borders; ++$i) {
            $this->draw_horizontal_dotline($im, 0, $map_size, ($i * $px_per_field) + $i, $cl_border, $dot_distance);
        }

        return true;
    }

    function draw_outer_border($im, $map_size, $dot_distance) {
        $cl_border = imagecolorallocate($im, 200, 150, 150);

        $map_size -= 1;

        $this->draw_vertical_dotline($im, 0, $map_size, 0, $cl_border, $dot_distance);
        $this->draw_vertical_dotline($im, 0, $map_size, $map_size, $cl_border, $dot_distance);

        $this->draw_horizontal_dotline($im, 0, $map_size, 0, $cl_border, $dot_distance);
        $this->draw_horizontal_dotline($im, 0, $map_size, $map_size, $cl_border, $dot_distance);

        return true;
    }

    function calculate_planet_position($radius, $covered) {
        $outline = 2 * $radius * M_PI;

        $planet_x = $planet_y = ($this->system_map_size / 2);

        if($covered < 1) {
            $planet_y -= $radius;
        }
        else {
            if($covered > $outline) {
                $covered = 0;
            }

            $angle = (360 * $covered ) / $outline;
            
            /*
            $quadrant = ceil($angle / 90);
            $angle -= ($quadrant - 1) * 90;
            */

            if($angle <= 90) {
                $quadrant = 1;
            }
            elseif($angle > 90 && $angle <= 180) {
                $quadrant = 2;
                $angle -= 90;
            }
            elseif($angle > 180 && $angle <= 270) {
                $quadrant = 3;
                $angle -= 180;
            }
            elseif($angle > 270 && $angle <= 360) {
                $quadrant = 4;
                $angle -= 270;
            }
            else {
                return message(GENERAL, 'Bad angle '.$angle.'° of planet distance '.$radius);
            }

            $tri_a = sin( ($angle * M_PI ) / 180 ) * $radius;
            $tri_b = math::pythagoras_hc($radius, $tri_a);

            switch($quadrant) {
                case 1:
                    $planet_x += $tri_a;
                    $planet_y -= $tri_b;
                break;

                case 2:
                    $planet_x += $tri_b;
                    $planet_y += $tri_a;
                break;

                case 3:
                    $planet_x -= $tri_a;
                    $planet_y += $tri_b;
                break;

                case 4:
                    $planet_x -= $tri_b;
                    $planet_y -= $tri_a;
                break;
            }
        }

        return array($planet_x, $planet_y);
    }

    function create_galaxy_map() {
        global $QUADRANT_NAME;

        $im = imagecreatefromjpeg('maps/templates/galaxy.jpg');

        $this->draw_split_borders($im, $this->galaxy_map_size, 2, 4);
        $this->draw_stars($im, $this->galaxy_map_size, 1200);

        imagejpeg($im, 'maps/images/galaxy.jpg', 30);
        imagedestroy($im);

        $center_coord = ($this->galaxy_map_size / 2);

        $map_html = '<map name="galaxy_map">'.NL.
                    '<area href="'.parse_link('a=tactical_cartography&quadrant_id=1').'" shape="rect" coords="0, 0, '.$center_coord.', '.$center_coord.'" title="'.$QUADRANT_NAME[1].'">'.NL.
                    '<area href="'.parse_link('a=tactical_cartography&quadrant_id=2').'" shape="rect" coords="'.$center_coord.', 0, '.$this->galaxy_map_size.', '.$center_coord.'" title="'.$QUADRANT_NAME[2].'">'.NL.
                    '<area href="'.parse_link('a=tactical_cartography&quadrant_id=3').'" shape="rect" coords="0, '.$center_coord.', '.$center_coord.', '.$this->galaxy_map_size.'" title="'.$QUADRANT_NAME[3].'">'.NL.
                    '<area href="'.parse_link('a=tactical_cartography&quadrant_id=4').'" shape="rect" coords="'.$center_coord.', '.$center_coord.', '.$this->galaxy_map_size.', '.$this->galaxy_map_size.'" title="'.$QUADRANT_NAME[4].'">'.NL.
                    '</map>';

        $fp = fopen('maps/area/galaxy.html', 'w');
        fputs($fp, $map_html);
        fclose($fp);

        return true;
    }

    function create_quadrant_map($quadrant_id) {
        global $game;

        if( ($quadrant_id < 1) || ($quadrant_id > 4) ) {
            message(GENERAL, 'Where the hell is quadrant '.$quadrant_id.' !?');
        }

        $im = imagecreatefromjpeg('maps/templates/quadrant_'.$quadrant_id.'.jpg');

        $this->draw_split_borders($im, $this->quadrant_map_size, $this->quadrant_map_split, 4);
        $this->draw_stars($im, $this->quadrant_map_size, 1200);

        //imagepng($im, 'maps/images/quadrant_'.$quadrant_id.'.png');
        imagejpeg($im, 'maps/images/quadrant_'.$quadrant_id.'.jpg', 30);
        imagedestroy($im);

        $required_borders = ($this->quadrant_map_split - 1);
        $px_per_sector = ($this->quadrant_map_size - $required_borders) / $this->quadrant_map_split;
        $previous_sectors = ( ($quadrant_id - 1) * ($this->quadrant_map_split * $this->quadrant_map_split));

        $map_html = '<map name="quadrant_map">'.NL;

        $current_y = 0;

        extract($game->get_quadrant_range($quadrant_id));

        for($i = 1; $i <= $this->quadrant_map_split; ++$i) {
            $current_x = 0;

            $current_letter = $letters[($i - 1)];

            for($j = 1; $j <= $this->quadrant_map_split; ++$j) {
                $sector_id = ( $previous_sectors + ( $j + ( ($i - 1) * $this->quadrant_map_split) ) );
                $map_html .= '<area href="'.parse_link('a=tactical_cartography&sector_id='.$sector_id).'" shape="rect" coords="'.$current_x.', '.$current_y.', '.($current_x + $px_per_sector).', '.($current_y + $px_per_sector).'"';
                $map_html .= ' onmouseover="return overlib(\'Sektor '.$current_letter.$numbers[($j - 1)].'<br>ID: '.$sector_id.'\', CAPTION, \'Details:\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';



                $current_x += ($px_per_sector + 1);
            }

            $current_y += ($px_per_sector + 1);
        }

        $map_html .= '</map>';

        $fp = fopen('maps/area/quadrant_'.$quadrant_id.'.html', 'w');
        fputs($fp, $map_html);
        fclose($fp);

        return true;

    }

    function create_sector_map($sector_id) {
        global $db, $game;

        if( ($sector_id < 1) || ($sector_id > $this->max_sectors) ) {
            message(GENERAL, 'Invalid sector id '.$sector_id);
        }
        
        //$g_coords = $game->get_sector_global_coords($game->get_sector_name($sector_id));
        
        $im = imagecreate($this->sector_map_size, $this->sector_map_size);
        //$im = imagecreatefrompng('maps/templates/sector_'.$g_coords[0].'_'.$g_coords[1].'.jpg');
        imagecolorallocate($im, 0, 0, 0);

        $this->draw_stars($im, $this->sector_map_size, 600);
        $this->draw_outer_border($im, $this->sector_map_size, 10);

        $sql = 'SELECT *
                FROM starsystems
                WHERE sector_id = '.$sector_id;

        if(!$q_systems = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query starsystems data');
        }

        $n_systems = $db->num_rows($q_systems);

        if($n_systems > $this->max_systems_per_sector) {
            message(GENERAL, 'Too many starsystems found in sector '.$sector_id);
        }

        $map_html = '<map name="sector_map">'.NL;
        $used_fields = array();

        while($system = $db->fetchrow($q_systems)) {
            $coord_id = $system['system_x'].$system['system_y'];

            if(isset($used_fields[$coord_id])) {
                message(GENERAL, 'Sector field '.$system['system_x'].'|'.$system['system_y'].' is used twice [by system '.$used_fields[$coord_id].' and '.$system['system_id'].' in sector '.$sector_id.']');
            }

            if( ($system['system_x'] > $this->sector_map_split) || ($system['system_y'] > $this->sector_map_split)) {
                message(GENERAL, 'Invalid starsystem coordinates '.$system['system_x'].' | '.$system['system_y'].' by system <i>'.$system['system_id'].'</i> in sector <i>'.$sector_id.'</i>');
            }

            $star_color = imagecolorallocate($im, $system['system_starcolor_red'], $system['system_starcolor_green'], $system['system_starcolor_blue']);

            $star_size = (float)$system['system_starsize'];

            if( ($star_size < $this->starsize_range[0]) || ($star_size > $this->starsize_range[1])) {
                message(GENERAL, 'Invalid starsize '.$star_size.' by system '.$system['system_id'].' in sector '.$sector_id);
            }

            $star_size *= 0.45;

            imagefilledellipse($im, $system['system_map_x'], $system['system_map_y'], $star_size, $star_size, $star_color);

            $map_html .= '<area href="'.parse_link('a=tactical_cartography&system_id='.encode_system_id($system['system_id'])).'" shape="circle" coords="'.$system['system_map_x'].', '.$system['system_map_y'].', '.$star_size.'" onmouseover="return overlib(\''.$system['system_name'].'<br>Planeten: '.$system['system_n_planets'].'\', CAPTION, \'Details:\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';

            $used_fields[$coord_id] = $system['system_id'];
        }

        imagepng($im, 'maps/images/cache/'.md5($game->player['user_id']).'.png');
        imagedestroy($im);

        $map_html .= '</map>';

        return $map_html;
    }

    function create_system_map($system_id = 0) {
        global $db, $game, $ACTUAL_TICK, $PLANETS_DATA;

        $sql = 'SELECT *
                FROM starsystems
                WHERE system_id = "'.$system_id.'"';

        if(($system = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query starsystem data');
        }

        if(empty($system['system_id'])) {
            message(GENERAL, 'Could not find system '.$system_id);
        }

        $sql = 'SELECT p.planet_id, p.planet_name, p.planet_type, p.planet_distance_px, p.planet_covered_distance, p.planet_current_x, p.planet_current_y, p.planet_points,
                       u.user_id, u.user_name, u.user_attack_protection, u.user_points,
                       a.alliance_id, a.alliance_tag, a.alliance_name
                FROM (planets p)
                LEFT JOIN (user u) ON u.user_id = p.planet_owner
                LEFT JOIN (alliance a) ON a.alliance_id = u.user_alliance
                WHERE p.system_id = '.$system_id;

        if(!$q_planets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query planets data');
        }
        

        $n_planets = $db->num_rows($q_planets);

        $im = imagecreate($this->system_map_size, $this->system_map_size);
        imagecolorallocate($im, 0, 0, 0);

        $this->draw_stars($im, $this->system_map_size, 800);

        $center_coord = ($this->system_map_size / 2);

        $star_color = imagecolorallocate($im, $system['system_starcolor_red'], $system['system_starcolor_green'], $system['system_starcolor_blue']);
        $star_size = $system['system_starsize'];

        imagefilledellipse($im, $center_coord, $center_coord, $star_size, $star_size, $star_color);

        $orbit_color = imagecolorallocate($im, 50, 50, 50);

        $cl_own_planet = imagecolorallocate($im, 0, 255, 0); // grün
        $cl_active_planet = imagecolorallocate($im, 255, 255, 0); // gelb
        $cl_alliance_planet = imagecolorallocate($im, 0, 0, 255); // blau
        $cl_attack_protection = imagecolorallocate($im, 180, 180, 180); // grau
        $cl_alliance_war = imagecolorallocate($im, 255, 0, 0); // rot
        $cl_alliance_bnd_pbnd = imagecolorallocate($im, 137, 202, 239); // hellblau

        $map_html = '<map name="system_map">'.NL;
        $used_distances = array();
        $planet_images = array();

        for($i = 1; $i <= ($star_size + 10); ++$i) {
            $used_distances[$i] = true;
        }
        
        $rect_coords = array(
		    array(3, 5, 1, 3),
			array(7, 5, 5, 3),
			array(3, 1, 1, -1),
			array(7, 1, 5, -1),
		);

        while($planet = $db->fetchrow($q_planets)) {
            $radius = $planet['planet_distance_px'];

            imageellipse($im, $center_coord, $center_coord, $radius * 2, $radius * 2, $orbit_color);

            if($planet['planet_current_x'] == 0) {
                $coords = $this->calculate_planet_position($radius, $planet['planet_covered_distance']);

                $planet_x = $coords[0];
                $planet_y = $coords[1];

                $sql = 'UPDATE planets
                        SET planet_current_x = '.$planet_x.',
                            planet_current_y = '.$planet_y.'
                        WHERE planet_id = '.$planet['planet_id'];

                if(!$db->query($sql)) {
                    message(DATABASE_ERROR, 'Could not update planet position data');
                }
            }
            else {
                $planet_x = $planet['planet_current_x'];
                $planet_y = $planet['planet_current_y'];
            }
            
            $current_type = $planet['planet_type'];
            $planet_width = $PLANETS_DATA[$current_type][8];

            if(empty($planet_colors[$current_type])) {
                $planet_colors[$current_type] = imagecolorallocate($im, $PLANETS_DATA[$current_type][9][0], $PLANETS_DATA[$current_type][9][1], $PLANETS_DATA[$current_type][9][2]);
            }

            imagefilledellipse($im, $planet_x, $planet_y, $PLANETS_DATA[$current_type][8], $PLANETS_DATA[$current_type][8], $planet_colors[$current_type]);

            $map_html .= '<area href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet['planet_id'])).'" shape="circle" coords="'.(int)$planet_x.', '.(int)$planet_y.', '.$PLANETS_DATA[$current_type][8].'"';
            $map_html .= ' onmouseover="return overlib(\'<font color=gray><b>Name:</b> '.str_replace("'","\'",$planet['planet_name']).'</font><br><font color=gray><b>Klasse:</b> '.strtoupper($planet['planet_type']).'</font>';
            if(empty($planet['user_id'])) {
			    $map_html .= '<br><i>unbewohnt</i>';
            }
            else {
                $map_html .= '<br><b>Herrscher:</b> '.$planet['user_name'];
                $map_html .= ((!empty($planet['alliance_name'])) ? '<br><font color=gray><b>Allianz:</b> '.str_replace("'","\'",$planet['alliance_name']).' ['.$planet['alliance_tag'].']</font>' : '' ).'<br><b>Punkte:</b> '.$planet['planet_points'].' ('.$planet['user_points'].' ges.)';
            }
            $map_html .= '\', CAPTION, \'Details:\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';

            $rect_colors = array();

      
            if($planet['planet_id'] == $game->planet['planet_id']) {
                $rect_colors[] = $cl_active_planet;
            }
            
            if($planet['user_attack_protection'] > $ACTUAL_TICK) {
            	$rect_colors[] = $cl_attack_protection;
            }
 
            $rotz = 0;   
 
            $rotz = $planet['alliance_id'];
 
            if(empty($rotz)) $rotz = 0;

            $sql = 'SELECT * FROM alliance_diplomacy WHERE (alliance1_id = '.$rotz.' OR alliance2_id = '.$rotz.') AND (alliance1_id = '.$game->player['user_alliance'].' OR alliance2_id = '.$game->player['user_alliance'].') AND ((status = 0) OR (type=1 AND status=2))';

            if(($alliance_1 = $db->queryrow($sql)) === false) {
               message(DATABASE_ERROR, 'Could not query alliance data');
            }

            if(!empty($alliance_1['ad_id'])){

            $sql = 'SELECT * from alliance WHERE alliance_id != '.$game->player['user_alliance'].' AND (alliance_id = '.$alliance_1['alliance1_id'].' OR alliance_id = '.$alliance_1['alliance2_id'].')';

            if(($alliance_2 = $db->queryrow($sql)) === false) {
               message(DATABASE_ERROR, 'Could not query alliance data');
            }

            }
                if($planet['user_id'] == $game->player['user_id']) {
                   $rect_colors[] = $cl_own_planet;
                }
                elseif($planet['alliance_id'] == $game->player['user_alliance']) {
                   $rect_colors[] = $cl_alliance_planet;
                }
                elseif($planet['alliance_id']==$alliance_2['alliance_id'] && $alliance_1['type'] == 1){
                  $rect_colors[] = $cl_alliance_war;
                }
                elseif($planet['alliance_id']==$alliance_2['alliance_id'] && $alliance_1['type'] == 3){
                  $rect_colors[] = $cl_alliance_bnd_pbnd;
                }


            if(!empty($rect_colors)) {
                for($i = 0; $i < count($rect_colors); ++$i) {
				    imagefilledrectangle($im,
				        ($planet_x - $planet_width - $rect_coords[$i][0]), ($planet_y - $rect_coords[$i][1]),
				        ($planet_x - $planet_width - $rect_coords[$i][2]), ($planet_y - $rect_coords[$i][3]),
				                                    
				    $rect_colors[$i]);
				}
            }

        }

        imagepng($im, 'maps/images/cache/'.md5($game->player['user_id']).'.png');
        imagedestroy($im);

        $map_html .= '</map>';

        return $map_html;
    }
    
    function create_galaxy_detail_map() {
        global $game, $db;

        $im = imagecreate($this->galaxy_detail_map_size, $this->galaxy_detail_map_size);
        imagecolorallocate($im, 0, 0, 0);

        $this->draw_split_borders($im, $this->galaxy_detail_map_size, (2 * $this->quadrant_map_split), 6);
        $this->draw_split_borders($im, $this->galaxy_detail_map_size, 2, 3);

        $sql = 'SELECT system_id, sector_id, system_x, system_y, system_starcolor_red, system_starcolor_green, system_starcolor_blue
                FROM starsystems';
                
        if(!$q_systems = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query starsystems data');
        }
        
        $px_per_sector = ($this->galaxy_detail_map_size - ((2 * $this->quadrant_map_split) - 1)) / (2 * $this->quadrant_map_split);
        $px_per_system = $px_per_sector / $this->sector_map_split;
        
        $next_quadrant_start = ( (9 * $px_per_sector) + $this->quadrant_map_split );
        
        $quadrant_start_coords = array(
            1 => array(0, 0),
            2 => array($next_quadrant_start, 0),
            3 => array(0, $next_quadrant_start),
            4 => array($next_quadrant_start, $next_quadrant_start)

        );
        
        $star_colors = array(
            imagecolorallocate($im, 0, 0, 255), // blau
            imagecolorallocate($im, 255, 255, 255), // weiß
            imagecolorallocate($im, 200, 100, 0), // gelb
            imagecolorallocate($im, 255, 0, 0), // rot
        );
        
        while($system = $db->fetchrow($q_systems)) {
            $quadrant_id = $game->get_quadrant($system['sector_id']);

            $start_x = $quadrant_start_coords[$quadrant_id][0];
            $start_y = $quadrant_start_coords[$quadrant_id][1];
            
            $sector_lcoords = $game->get_sector_coords($system['sector_id']);
            
            // Eigentlich:
            // $start_x += ( ($sector_lcoords[0] - 1) * $px_per_sector ) + ($sector_lcoords[0] - 1)
            $start_x += ($sector_lcoords[0] - 1) * ($px_per_sector + 1);
            $start_y += ($sector_lcoords[1] - 1) * ($px_per_sector + 1);
            
            $start_x += ($system['system_x'] - 1) * $px_per_system;
            $start_y += ($system['system_y'] - 1) * $px_per_system;
            
            $cl = $star_colors[3];
            
            if($system['system_starcolor_red'] <= 25) {
                $cl = $star_colors[0];
            }
            else {
                if($system['system_starcolor_green'] >= 220) {
                    $cl = $star_colors[1];
                }
                elseif($system['system_starcolor_green'] >= 50) {
                    $cl = $star_colors[2];
                }
            }
            
            imagefilledellipse($im, ($start_x + 2), ($start_y + 2), 3, 3, $cl);
        }

        imagepng($im, '|script_dir|/game/maps/images/galaxy_detail.png');
        imagedestroy($im);
    }
}

?>
