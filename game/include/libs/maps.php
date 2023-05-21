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

        $this->font = 'trek.ttf';

        $this->orion_alert_str = ['C', 'B', 'A', 'AA', 'AAA'];

        /* 27/06/08 - AC: This module can also be called when $game->player is NOT inizialized */
        if(isset($game->player['language']))
        {
		/* 29/02/08 - AC: Localize this strings */
		switch($game->player['language'])
		{
			case 'GER':
				$this->str_sector = 'Sektor';
				$this->str_details = 'Details';
                $this->str_infobox = 'Info';
				$this->str_planets = 'Planeten:';
				$this->str_owner = 'Herrscher:';
				$this->str_alliance = 'Allianz:';
				$this->str_points = 'Punkte:';
				$this->str_name = 'Name:';
				$this->str_class = 'Klasse:';
				$this->str_range = 'Range:';
				$this->str_outrange = 'Outside optimal range';
				$this->str_uninhabited = 'unbewohnt';
                $this->str_fleet_player = 'Fleet ';
                $this->str_ships = 'ship/s';
                $this->str_res = 'Resources: ';
                $this->str_met = 'Metals';
                $this->str_mins = 'Minerals';
                $this->str_dilh = 'Dilithium';
                $this->str_unch = 'Unexplored';
                $this->str_priv = 'Private';
                $this->str_explo = 'First explorer: ';
                $this->str_disc  = 'Explored in ';
                $this->str_ctrl_1 = ' controls ';
                $this->str_ctrl_2 = ' planet(s)';
                $this->str_sys_avail = 'Punkte Systementwicklung: ';
                $this->str_owned_pts = ' punkte';
                $this->str_is_patrolled = 'vor kurzem Patrouille';
                $this->str_orion_level = 'Orion Alert:';
                $this->str_activity = 'Last movement ';
                $this->str_activity_mixed = 'mixed';
                $this->str_activity_warp_in = 'warping in';
                $this->str_activity_warp_out = 'warping out';                
			break;
			case 'ENG':
				$this->str_sector = 'Sector';
				$this->str_details = 'Details';
                $this->str_infobox = 'Info';
				$this->str_planets = 'Planets:';
				$this->str_owner = 'Owner:';
				$this->str_alliance = 'Alliance:';
				$this->str_points = 'Points:';
				$this->str_name = 'Name:';
				$this->str_class = 'Class:';
				$this->str_range = 'Range:';
				$this->str_outrange = 'Outside optimal range';
				$this->str_uninhabited = 'uninhabited';
                $this->str_fleet_player = 'Fleet ';
                $this->str_ships = 'ship/s';
                $this->str_res = 'Resources: ';
                $this->str_met = 'Metals';
                $this->str_mins = 'Minerals';
                $this->str_dilh = 'Dilithium';
                $this->str_unch = 'Unexplored';
                $this->str_priv = 'Private';
                $this->str_explo = 'First explorer: ';
                $this->str_disc  = 'Explored in ';
                $this->str_ctrl_1 = ' controls ';
                $this->str_ctrl_2 = ' planet(s)';
                $this->str_sys_avail = 'System Points: ';
                $this->str_owned_pts = ' points';
                $this->str_is_patrolled = 'Recently patrolled';
                $this->str_orion_level = 'Orion Alert:';
                $this->str_activity = 'Last movement ';
                $this->str_activity_mixed = 'mixed';
                $this->str_activity_warp_in = 'warping in';
                $this->str_activity_warp_out = 'warping out';                                
			break;
			case 'ITA':
				$this->str_sector = 'Settore';
				$this->str_details = 'Dettagli';
                $this->str_infobox = 'Informazioni';
				$this->str_planets = 'Pianeti:';
				$this->str_owner = 'Proprietario:';
				$this->str_alliance = 'Alleanza:';
				$this->str_points = 'Punti:';
				$this->str_name = 'Nome:';
				$this->str_class = 'Classe:';
				$this->str_range = 'Distanza:';
				$this->str_outrange = 'Fuori portata ottimale';
				$this->str_uninhabited = 'disabitato';
                $this->str_fleet_player = 'Flotta ';
                $this->str_ships = 'unit&agrave;';
                $this->str_res = 'Risorse: ';
                $this->str_met = 'Metalli';
                $this->str_mins = 'Minerali';
                $this->str_dilh = 'Dilitio';
                $this->str_unch = 'Inesplorato';
                $this->str_priv = 'Privato';
                $this->str_explo = 'Primo esploratore: ';
                $this->str_disc  = 'Scoperto in data ';
                $this->str_ctrl_1 = ' controlla ';
                $this->str_ctrl_2 = ' pianeta&#47;i';
                $this->str_sys_avail = 'Punti Sviluppo Sistema: ';
                $this->str_owned_pts = ' punti';
                $this->str_is_patrolled = 'Pattugliato di recente';
                $this->str_orion_level = 'Allerta Orione: ';
                $this->str_activity = 'Ultimo movimento ';
                $this->str_activity_mixed = 'confuso';
                $this->str_activity_warp_in = 'in arrivo';
                $this->str_activity_warp_out = 'in partenza';                
            break;
		}
        }
        else
        {
            /* AC: They should not be used, but for safety... */
            $this->str_sector = 'Sector';
            $this->str_details = 'Details';
            $this->str_infobox = 'Info';
            $this->str_planets = 'Planets:';
            $this->str_owner = 'Owner:';
            $this->str_alliance = 'Alliance:';
            $this->str_points = 'Points:';
            $this->str_name = 'Name:';
            $this->str_class = 'Class:';
            $this->str_range = 'Range:';
            $this->str_outrange = 'Outside optimal range';
            $this->str_uninhabited = 'uninhabited';
            $this->str_unch = 'Unexplored';
            $this->str_priv = 'Private';
        }
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
                return message(GENERAL, 'Bad angle '.$angle.'&deg; of planet distance '.$radius);
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
        global $game, $QUADRANT_NAME;

        if( ($quadrant_id < 1) || ($quadrant_id > 4) ) {
            message(GENERAL, 'Where the hell is quadrant '.$quadrant_id.' !?');
        }

        $im = imagecreatefromjpeg('maps/templates/quadrant_'.$quadrant_id.'.jpg');

        $this->draw_split_borders($im, $this->quadrant_map_size, $this->quadrant_map_split, 4);
        $this->draw_stars($im, $this->quadrant_map_size, 1200);

        $textcolor = imagecolorexact($im, 180, 180, 180);

        $bbox = imagettfbbox(18, 0, 'trek.ttf', $QUADRANT_NAME[$quadrant_id]);

        $x = (imagesx($im) / 2) - $bbox[0];
        $y = (imagesy($im) / 2) - $bbox[1];

        imagettftext($im, 18, 0, $x, $y, $textcolor, 'trek.ttf', $QUADRANT_NAME[$quadrant_id]);

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
                $map_html .= ' onmouseover="return overlib(\''.$this->str_sector.' '.$current_letter.$numbers[($j - 1)].'<br>ID: '.$sector_id.'\', CAPTION, \''.$this->str_details.'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';



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

        include_once('include/libs/moves.php');

        global $db, $game, $RACE_DATA;

        if( ($sector_id < 1) || ($sector_id > $this->max_sectors) ) {
            message(GENERAL, 'Invalid sector id '.$sector_id);
        }

        //$g_coords = $game->get_sector_global_coords($game->get_sector_name($sector_id));

        $im = imagecreate($this->sector_map_size, $this->sector_map_size);
        //$im = imagecreatefrompng('maps/templates/sector_'.$g_coords[0].'_'.$g_coords[1].'.jpg');
        imagecolorallocate($im, 0, 0, 0);
        
        $star_attack_protection = imagecolorallocate($im, 180, 180, 180);

        $star_attack_unprotection = imagecolorallocate($im, 250, 0, 0);        

        $star_this_protection = imagecolorallocate($im, 51, 255, 51);

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

            $fleet_sensor = false;
            $fleet_officer = false;
            //Any fleet here?
            $sql = 'SELECT sf.fleet_name, sf.n_ships, sf.planet_id, o.id 
                    FROM (ship_fleets sf)
                    LEFT JOIN (officers o) ON sf.fleet_id = o.fleet_id
                    WHERE system_id = '.$system['system_id'].' AND sf.owner_id = '.$game->player['user_id'];
            if($fleet_details = $db->queryrowset($sql)) {
                $fleet_sensor = true;
                foreach ($fleet_details AS $fleet_item) {
                    if(isset($fleet_item['id']) && $fleet_item['id'] > 0 ) {
                        $fleet_officer = true;
                    }
                }
            }
            
            ////////////////// Calculate the distance in A.U. between the capital system and the target one

            if ($game->capital_system_id != $system['system_id']) {
                $distance = get_distance(array($game->capital_global_x, $game->capital_global_y),
                                array($system['system_global_x'], $system['system_global_y']));
                $distance = round($distance, 2);
            }
            else
            {
                $distance = 0;
            }

            if($distance > MAX_BOUND_RANGE) {
                $distance_str = '<br>'.$this->str_range.$distance.' A.U.<br>'.$this->str_outrange;
            }
            else
            {
                $distance_str = '<br>'.$this->str_range.$distance.' A.U.';
            }

            // DC Try to give more information, just for fun
            $unpatrolled = true;
            $explored_str = '';

            $sql = 'SELECT count(*) as explored FROM starsystems_details
                    WHERE system_id = '.$system['system_id'].'
                    AND user_id = '.$game->player['user_id'];

            if($res = $db->queryrow($sql))
            {
                if($res['explored'] == 0) $explored_str = '<br><i>'.$this->str_unch.'</i>';
            }

            // DC Stringa Pianeti
            $planets_str = $orion_str = $patrol_str = $activity_str = '';

            if($res['explored'] == 0) {
                $planets_str = '<br>'.$this->str_planets.' '.$system['system_n_planets'];
            }
            else {
                $orion_str = '<br><b>'.$this->str_orion_level.$this->orion_alert_str[$system['system_orion_alert']].'</b>';

                $sql = 'SELECT log_code_tick FROM starsystems_details WHERE system_id = '.$system['system_id'].' AND user_id = '.$game->player['user_id'].' AND log_code = 1';

                if(($q_patrol = $db->queryrow($sql)) === false) {
                    message(DATABASE_ERROR, 'Could not query planet details data');
                }

                if(isset($q_patrol['log_code_tick'])) {
                    $patrol_str = '<br><b>'.$this->str_is_patrolled.'</b>';
                    $unpatrolled = false;
                }

                $sql = 'SELECT p.planet_id, p.planet_distance_id, p.planet_name, p.planet_type, p.planet_owner, u.user_name, p.planet_points, p.building_7, pd.survey_1, pd.survey_2, pd.survey_3
                        FROM (planets p)
                        LEFT JOIN (user u) ON (u.user_id = p.planet_owner AND p.planet_owner > 0)
                        LEFT JOIN (planet_details pd) ON (pd.planet_id = p.planet_id AND pd.log_code = 100 AND pd.user_id = '.$game->player['user_id'].')
                        WHERE p.system_id = '.$system['system_id'].'
                        ORDER BY p.planet_distance_id ASC';

                if($plist = $db->queryrowset($sql)) {
                    $player_sensor = false;
                    foreach ($plist as $pitem) {
                        if($pitem['planet_owner'] == $this->player['user_id'] && $pitem['building_7'] > 0) {$player_sensor = true;}
                    }
                    $planets_str .= '<br>'.$this->str_planets;
                    foreach ($plist AS $pitem) {
                        $planets_str .= '<br>'.($pitem['planet_distance_id'] + 1).': '.strtoupper($pitem['planet_type']);
                        if(isset($pitem['survey_1'])) {
                            $planets_str .= ' (';
                            switch ($pitem['survey_1']) {
                                case 0:
                                    $planets_str .= '<font color=red>-</font>|';
                                    break;
                                case 1:
                                    $planets_str .= '<font color=grey>=</font>|';
                                    break;
                                case 2:
                                    $planets_str .= '<font color=green>+</font>|';
                                    break;
                            }
                            switch ($pitem['survey_2']) {
                                case 0:
                                    $planets_str .= '<font color=red>-</font>|';
                                    break;
                                case 1:
                                    $planets_str .= '<font color=grey>=</font>|';
                                    break;
                                case 2:
                                    $planets_str .= '<font color=green>+</font>|';
                                    break;
                            }
                            switch ($pitem['survey_3']) {
                                case 0:
                                    $planets_str .= '<font color=red>-</font>';
                                    break;
                                case 1:
                                    $planets_str .= '<font color=grey>=</font>';
                                    break;
                                case 2:
                                    $planets_str .= '<font color=green>+</font>';
                                    break;
                            }
                            $planets_str .= ')';
                        }
                        $planets_str .= (!empty($pitem['planet_owner']) ? ' &#34;'.str_replace("'","\'",$pitem['planet_name']).'&#34;' : ' <i>'.str_replace("'","\'",$pitem['planet_name']).'</i>');
                        if(!empty($pitem['planet_owner'])) {$planets_str .= ' '.htmlentities($pitem['user_name']). ' ('.$pitem['planet_points'].' pt.)';}

                        if($player_sensor || $fleet_sensor) {
                            foreach($fleet_details as $f_i) {
                                if($f_i['planet_id'] == $pitem['planet_id']) {
                                    $planets_str .='<br>&nbsp;&nbsp;&nbsp;&nbsp;&#187;&nbsp;'.$this->str_fleet_player.' <b>'.htmlentities($f_i['fleet_name']).'</b>, '.$f_i['n_ships'].' '.$this->str_ships;
                                }                                
                            }
                        }

                        //Anu OTHER fleets here?
                        if((!empty($pitem['planet_owner']) && $pitem['planet_owner'] == $game->player['user_id']) || $player_sensor || $fleet_sensor) {
                            $sql = 'SELECT user_name, SUM(n_ships) AS n_ships FROM ship_fleets INNER JOIN user USING (user_id) WHERE planet_id = '.$pitem['planet_id'].' AND user_id <> '.$game->player['user_id'].' GROUP BY user_id';

                            if($flist = $db->queryrowset($sql)) {
                                foreach ($flist AS $fitem) {
                                    $planets_str .='<br>&nbsp;&nbsp;&nbsp;&#183;&#183;&#183;<b>'.$fitem['user_name'].'</b>, '.$fitem['n_ships'].' '.$this->str_ships;
                                }
                            }
                        }
                    }
                }
            }

            if($res['explored'] > 0 && $system['system_closed']) {

                $sql = 'SELECT COUNT(log_code) as counter FROM starsystems_details WHERE system_id = '.$system['system_id'].' AND user_id <> '.$system['system_owner'].' AND log_code = 100';

                $q_challengers = $db->queryrow($sql);

                /*
                imagearc($im, $system['system_map_x'], $system['system_map_y'], ($star_size + 10), ($star_size + 10), (180 - 35), (180 + 35), ($q_challengers['counter'] == 0 ? $star_attack_protection : $star_attack_unprotection));

                imagearc($im, $system['system_map_x'], $system['system_map_y'], ($star_size + 10), ($star_size + 10), (360 - 35), (0 + 35), ($q_challengers['counter'] == 0 ? $star_attack_protection : $star_attack_unprotection));
                 * 
                 */

                $rect_color = $star_attack_protection;

                if($q_challengers['counter'] > 0) {
                    $rect_color = $star_attack_protection;
                }
                elseif($system['system_owner'] == $game->player['user_id']) {
                    $rect_color = $star_this_protection;
                }

                imagerectangle($im, ($system['system_map_x'] - 10), ($system['system_map_y'] - 10), ($system['system_map_x'] + 10), ($system['system_map_y'] + 10), $rect_color);

                unset($rect_color, $q_challengers);

            }
            elseif($res['explored'] > 0 && !$system['system_closed']) {

                switch ($system['system_orion_alert']) {
                    case 0:
                        $star_orion_color = imagecolorallocate($im, 51, 255, 51);
                        break;                    
                    case 1:
                        $star_orion_color = imagecolorallocate($im, 0, 128, 255);
                        break;
                    case 2:
                        $star_orion_color = imagecolorallocate($im, 255, 255, 0);
                        break;
                    case 3:
                        $star_orion_color = imagecolorallocate($im, 255, 0, 0);
                        break;
                    case 4:
                        $star_orion_color = imagecolorallocate($im, 255, 0, 255);
                        break;
                    default : break;
                }
                
                $basex = $system['system_map_x'] + 10;
                $basey = $system['system_map_y'] - 10;
                $vertices = array($basex, $basey, $basex, ($basey + 7), ($basex - 7), $basey);
                
                if($unpatrolled){
                    //imageellipse($im, $system['system_map_x'], $system['system_map_y'], ($star_size + 15), ($star_size + 15), $star_orion_color);
                    imagepolygon($im, $vertices, 3, $star_orion_color);                    
                }
                else {
                  //imagerectangle($im, ($system['system_map_x'] - 25), ($system['system_map_y'] - 25), ($system['system_map_x'] + 25), ($system['system_map_y'] + 25) , $star_orion_color);
                    imagefilledpolygon($im, $vertices, 3, $star_orion_color);
                }

                unset ($star_orion_color);
                
                $basex = $system['system_map_x'] - 10;
                $basey = $system['system_map_y'] + 10;
                $vertices = array($basex, $basey, ($basex + 7), $basey, $basex, ($basey - 7));                
                
                $sql = 'SELECT log_code_tick, timestamp, info_1, info_2 FROM starsystems_details WHERE system_id = '.$system['system_id'].' AND user_id <> '.$game->player['user_id'].' AND log_code = 2 ORDER BY timestamp DESC LIMIT 0,1';

                $q_activity = $db->queryrow($sql);

                if(($distance <= MAX_BOUND_RANGE || $fleet_officer) && isset($q_activity['log_code_tick']) && $q_activity['log_code_tick'] > 0) {
                    imagefilledpolygon($im, $vertices, 3, $star_attack_protection);
                    $sub_str_direction = '';
                    if(!is_null($q_activity['info_2'])) {
                        $sub_str_direction = ', '.($q_activity['info_2'] == 0 ? $this->str_activity_warp_in : $this->str_activity_warp_out);
                    }
                    $activity_str = '<br><b>'.$this->str_activity.'</b>: <i>'.($q_activity['info_1'] == -1 ? $this->str_activity_mixed : $RACE_DATA[$q_activity['info_1']][0]).$sub_str_direction.'</i>, '.date("d.m.y H:i", $q_activity['timestamp']);
                }
                else if($distance <= MAX_BOUND_RANGE || $fleet_officer){
                    imagepolygon($im, $vertices, 3, $star_attack_protection);
                    $activity_str = '';
                }                
            }

            $private_str = '';

            if($res['explored'] > 0 && !empty($system['system_owner']) && $system['system_owner'] != $game->player['user_id'])
            {
                $private_str = '<br><i>'.$this->str_priv.'</i>';
            }
            // ----

            /////////////////

            $map_html .= '<area href="'.parse_link('a=tactical_cartography&system_id='.encode_system_id($system['system_id'])).'" shape="circle" coords="'.$system['system_map_x'].', '.$system['system_map_y'].', '.$star_size.'" onmouseover="return overlib(\''.$system['system_name'].' Star Class: '.(strtoupper($system['system_startype'])).$distance_str.$activity_str.$orion_str.$patrol_str.$planets_str.$explored_str.$private_str.'\', CAPTION, \''.$this->str_details.'\', WIDTH, 350, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';

            $used_fields[$coord_id] = $system['system_id'];
        }

        imagepng($im, 'maps/images/cache/'.md5($game->player['user_id']).'.png');
        imagedestroy($im);

        $map_html .= '</map>';

        return $map_html;
    }

    function create_system_map($system_id = 0) {

        include_once('include/libs/moves.php');

        global $db, $game, $ACTUAL_TICK, $PLANETS_DATA, $RACE_DATA;

        $system_is_known = false;
        $system_is_patrolled = false;
        $system_is_controlled = false;
        $system_is_challenged = false;
        $my_fleet_in_orbit = false;
        $other_fleet_in_orbit = false;
        $system_owner = '';
        $system_owner_name = '';
        $player_sensor = false;
        $system_settled_planets_count = 0;
        $system_home_distance = 0;
        $system_orion_alert = 0;
        $system_challengers = array();

        $sql = 'SELECT system_id,
                       system_name,
                       system_n_planets,
                       system_starcolor_red,
                       system_starcolor_green,
                       system_starcolor_blue,
                       system_starsize,
                       system_global_x,
                       system_global_y,
                       system_closed,
                       system_owner,
                       system_orion_alert,
                       user_name
                FROM starsystems
                LEFT JOIN user ON (starsystems.system_owner = user.user_id)
                WHERE system_id = "'.$system_id.'"';

        if(($system = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query starsystem data');
        }

        if(empty($system['system_id'])) {
            message(GENERAL, 'Could not find system '.$system_id);
        }

// Own fleet in the system for details purpose
        $fleet_sensor = false;
        $fleet_officer = false;

        $sql = 'SELECT sf.planet_id, sf.fleet_name, sf.n_ships, sf.fleet_id, o.id 
                FROM (ship_fleets sf)
                INNER JOIN (planets pl) ON pl.system_id = sf.system_id
                LEFT JOIN (officers o) ON sf.fleet_id = o.fleet_id
                WHERE pl.system_id = '.$system_id.' AND sf.owner_id = '.$game->player['user_id'].'
                GROUP BY sf.fleet_id ORDER BY sf.planet_id';
        
        $rows_fleets = $db->queryrowset($sql);
        
        $n_rows = $db->num_rows();
        
        if($n_rows > 0) {
            $fleet_sensor = true;
            foreach ($rows_fleets AS $item_fleets) {
                $fleet_list[$item_fleets['fleet_id']]['planet_id'] = $item_fleets['planet_id'];
                $fleet_list[$item_fleets['fleet_id']]['fleet_name'] = $item_fleets['fleet_name'];                
                $fleet_list[$item_fleets['fleet_id']]['n_ships'] = $item_fleets['n_ships'];
                if(isset($item_fleets['id']) && $item_fleets['id'] > 0) {
                    $fleet_officer = true;
                }
            }
        }
                        
        ////////////////// Calculate the distance in A.U. between the capital system and the target one

        if ($game->capital_system_id != $system['system_id']) {
            $system_home_distance = get_distance(array($game->capital_global_x, $game->capital_global_y),
                                    array($system['system_global_x'], $system['system_global_y']));
            $system_home_distance = round($system_home_distance, 2);
        }
        else
        {
            $system_home_distance = 0;
        }

        if($system['system_closed']) {
                $system_is_controlled = true;
                $system_owner = $system['system_owner'];
                $system_owner_name = $system['user_name'];
        }

        $system_orion_alert = $system['system_orion_alert'];

// DC ---- Fog of war is coming!!!
        $sql = 'SELECT p.planet_id, p.planet_name, p.planet_type, p.planet_distance_px, p.planet_covered_distance, p.planet_current_x, p.planet_current_y, p.planet_points, p.planet_available_points, p.building_7,
                       u.user_id, u.user_name, u.user_attack_protection, u.user_points,
                       a.alliance_id, a.alliance_tag, a.alliance_name
                FROM (planets p)
                LEFT JOIN (user u) ON u.user_id = p.planet_owner
                LEFT JOIN (alliance a) ON a.alliance_id = u.user_alliance
                WHERE p.system_id = '.$system_id.' ORDER BY p.planet_id';

        if(!$q_planets = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query planets data');
        }

// DC ----
        $sql = 'SELECT log_code FROM starsystems_details WHERE system_id = '.$system_id.' AND user_id = '.$game->player['user_id'];
        if(($q_details = $db->queryrowset($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query planet details data');
        }

        foreach($q_details AS $q_item) {
            switch ($q_item['log_code']) {
                case 0:
                    $system_is_known = true;
                    break;
                case 1:
                    $system_is_patrolled = true;
                    break;
            }
        }

        $sql = 'SELECT timestamp, user_id, user_name FROM starsystems_details INNER JOIN user USING (user_id) WHERE system_id = '.$system_id.' AND log_code = 100 ORDER BY timestamp ASC';
        if(($q_details2 = $db->queryrowset($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query planet details data');
        }
        
        foreach ($q_details2 as $q_item2) {
            if($system_is_controlled && $q_item2['user_id'] != $system_owner) {                    
                $system_is_challenged = true;
                $challenger = array('user_id' => $q_item2['user_id'], 'user_name' => $q_item2['user_name']);
                $system_challengers[] =  $challenger;
                unset($challenger);
            }
        }

        $sql = 'SELECT log_code_tick, timestamp, info_1, info_2 FROM starsystems_details WHERE system_id = '.$system_id.' AND user_id <> '.$game->player['user_id'].' AND log_code = 2 ORDER BY timestamp DESC LIMIT 0,1';
        if(($q_details3 = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query planet details data');
        }        

        $activity_str = '';
        
        if((isset($q_details3['timestamp']) && !empty($q_details3['timestamp'])) && ($system_home_distance <= MAX_BOUND_RANGE || $fleet_officer)) {
            $sub_str_direction = '';
            if(!is_null($q_details3['info_2'])) {
                $sub_str_direction = ', '.($q_details3['info_2'] == 0 ? $this->str_activity_warp_in : $this->str_activity_warp_out);
            }
            $activity_str = '<b>'.$this->str_activity.'</b>: <i>'.($q_details3['info_1'] == -1 ? $this->str_activity_mixed : $RACE_DATA[$q_details3['info_1']][0]).$sub_str_direction.'</i>, '.date("d.m.y H:i", $q_details3['timestamp']).'<br>';                        
        }        

        if($game->player['user_auth_level'] == STGC_DEVELOPER) {$system_is_known = true;}
// ----

        // $n_planets = $db->num_rows($q_planets);


        $im = imagecreate($this->system_map_size, $this->system_map_size);
        imagecolorallocate($im, 0, 0, 0);

        $this->draw_stars($im, $this->system_map_size, 800);

        $center_coord = ($this->system_map_size / 2);

        $star_color = imagecolorallocate($im, $system['system_starcolor_red'], $system['system_starcolor_green'], $system['system_starcolor_blue']);
        $star_size = $system['system_starsize'];

        imagefilledellipse($im, $center_coord, $center_coord, $star_size, $star_size, $star_color);

        $orbit_color = imagecolorallocate($im, 50, 50, 50);

        $cl_own_planet = imagecolorallocate($im, 0, 255, 0); // green
        $cl_active_planet = imagecolorallocate($im, 255, 255, 0); // yellow
        $cl_alliance_planet = imagecolorallocate($im, 0, 0, 255); // blue
        $cl_settlers_planet = imagecolorallocate($im, 204, 102, 0); // orange
        $cl_orion_planet = imagecolorallocate($im, 128, 0, 128); // purple
        $cl_attack_protection = imagecolorallocate($im, 180, 180, 180); // gray
        $cl_attack_unprotection = imagecolorallocate($im, 255, 0, 0); // red
        $cl_alliance_war = imagecolorallocate($im, 255, 0, 0); // red
        $cl_alliance_bnd_pbnd = imagecolorallocate($im, 137, 202, 239); // lightblue

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

        $rows_planets = $db->fetchrowset($q_planets);

        $headtxt = 'Info';
        $infotxt = '';
        $src_db_base_color = imagecolorallocate($im, 128, 128, 128);

        if($system_home_distance > MAX_BOUND_RANGE) {
            $infotxt .= $this->str_range.$system_home_distance.' A.U.<br>'.$this->str_outrange.'<br>';
        }
        else
        {
            $infotxt .= $this->str_range.$system_home_distance.' A.U.'.'<br>';
        }

        if($system_is_known) {

            $infotxt .= $this->str_orion_level.'<b>'.$this->orion_alert_str[$system_orion_alert].'</b><br>';

            $sql = 'SELECT timestamp, u1.user_name AS explo_name, system_closed, u2.user_name AS owner_name
                FROM starsystems
                INNER JOIN starsystems_details USING (system_id)
                LEFT JOIN user u1 USING (user_id)
                LEFT JOIN user u2 ON system_owner = u2.user_id
                WHERE system_id = '.$system_id.' AND starsystems_details.user_id > 0 ORDER BY timestamp ASC LIMIT 0,1';

            if($res = $db->queryrow($sql))
            {
                $infotxt .= $this->str_disc.date("d.m.Y", $res['timestamp']).'.<br>';
                $infotxt .= $this->str_explo.'<b>'.$res['explo_name'].'</b>.<br>';
            }

            if($system_is_controlled) {
                $infotxt .= 'Controllato da: <b>'.$system_owner_name.'</b>.<br>';
                if($system_is_challenged) {
                    foreach ($system_challengers AS $challenger_id) {
                        $infotxt .= 'Sfidato da: <b>'.$challenger_id['user_name'].'</b>.<br>';
                    }
                }
            }
            elseif($system_is_patrolled) {
                $infotxt .= $this->str_is_patrolled.'.<br>';
            }

            $owners_list = array();

            foreach($rows_planets as $planet) {

                if(empty($planet['user_id'])) {continue;}

                $owners_list[$planet['user_id']]['name'] = $planet['user_name'];
                $owners_list[$planet['user_id']]['count']++;
                $owners_list[$planet['user_id']]['points'] += $planet['planet_points'];
                $system_available_points += $planet['planet_available_points'];
                $system_settled_planets_count++;
                if($planet['user_id'] == $game->player['user_id'] && $planet['building_7'] > 0) {$player_sensor = true;}

            }

            if(!$res['system_closed'] && $system_available_points > 0) {
                $infotxt .=  $this->str_sys_avail.'<b>'.$system_available_points.'</b><br>';
            }

            foreach ($owners_list as $owner) {
                $font_color_1 = ( $system['system_n_planets'] >= 3 && $owner['count'] >= round($system['system_n_planets']/2) ? '#00FF00' : '#808080' );
                $font_color_2 = ( $owner['points'] >= 3*320 ? '#00FF00' : '#808080' );
                $infotxt .=  '<b>'.$owner['name'].'</b>'.$this->str_ctrl_1.'<font color='.$font_color_1.'>'.$owner['count'].'</font>'.$this->str_ctrl_2.' (<font color='.$font_color_2.'>'.$owner['points'].'</font>'.$this->str_owned_pts.')<br>';
            }

            if($system_is_controlled) {
                imagesetthickness ($im, 5);

                imagearc($im, $center_coord, $center_coord, 450, 450, (180 - 35), (180 + 35), ($system_is_challenged ? $cl_attack_unprotection : $cl_attack_protection));

                imagearc($im, $center_coord, $center_coord, 450, 450, (360 - 35), (0 + 35), ($system_is_challenged ? $cl_attack_unprotection : $cl_attack_protection));

                imagesetthickness ($im, 1);
            }

        }

        $infotxt .= $activity_str;
        $txtname = imagettfbbox(14, 0, $this->font, $system['system_name']);
        $x1 = $txtname[2];
        $x2 = $txtname[0];
        $len = ($x1 - $x2) + 10;
        $x = $this->system_map_size - $len;
        $y = $txtname[1] + 30;
        imagettftext($im, 14, 0, $x, $y, $src_db_base_color, $this->font, $system['system_name']);
        $txtbox = imagettfbbox(14, 0, $this->font, $headtxt);
        $x = $txtbox[0] + 10;
        $y = $txtbox[1] + 30;
        imagettftext($im, 14, 0, $x, $y, $src_db_base_color, $this->font, $headtxt);
        $map_html .= '<area href="javascript:void(0);" shape="rect" coords="'.($txtbox[6]+10).' , '.($txtbox[7]+30).' , '.($txtbox[2]+10).' , '.($txtbox[3]+30).'"';
        $map_html .= ' onmouseover="return overlib(\'<font color=gray>'.$infotxt.'</font>';
        $map_html .= '\', CAPTION, \''.$this->str_infobox.'\', WIDTH, 380, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';

        foreach($rows_planets as $planet) {

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

            if(($planet['user_id'] == $game->player['user_id']) || ($planet['alliance_id'] == $game->player['user_alliance']) || $system_is_known) {
                imagefilledellipse($im, $planet_x, $planet_y, $PLANETS_DATA[$current_type][8], $PLANETS_DATA[$current_type][8], $planet_colors[$current_type]);
            }
            else {
                $fake_colors = imagecolorallocate($im, 255, 255, 255);
                imagefilledellipse($im, $planet_x, $planet_y, 5, 5, $fake_colors);
            }

// DC ---- Fog of War: here we go!
            if(($planet['user_id'] == $game->player['user_id']) || ($planet['alliance_id'] == $game->player['user_alliance']) || $system_is_known) {
                $map_html .= '<area href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet['planet_id'])).'" shape="circle" coords="'.(int)$planet_x.', '.(int)$planet_y.', '.$PLANETS_DATA[$current_type][8].'"';
                $map_html .= ' onmouseover="return overlib(\'<font color=gray><b>'.$this->str_name.'</b> '.str_replace("'","\'",$planet['planet_name']).'</font><br><font color=gray><b>'.$this->str_class.'</b> '.strtoupper($planet['planet_type']).'</font>';
                if(empty($planet['user_id'])) {
                    $map_html .= '<br><i>'.$this->str_uninhabited.'</i>';
                }
                else {
                    $map_html .= '<br><b>'.$this->str_owner.'</b> '.$planet['user_name'];
                    $map_html .= ((!empty($planet['alliance_name'])) ? '<br><font color=gray><b>'.$this->str_alliance.'</b> '.str_replace("'","\'",$planet['alliance_name']).' ['.$planet['alliance_tag'].']</font>' : '' ).'<br><b>'.$this->str_points.'</b> '.$planet['planet_points'].' ('.$planet['user_points'].' ges.)';
                }
// DC Try to give more information, just for fun
                $my_fleet_in_orbit = false;
                $other_fleet_in_orbit = false;

                foreach($fleet_list as $fleet_item)
                {
                    if($fleet_item['planet_id'] == $planet['planet_id']) {
                        $my_fleet_in_orbit = true;
                        $map_html .='<br>&nbsp;&nbsp;&nbsp;&nbsp;&#187;&nbsp;'.$this->str_fleet_player.' <b>'.htmlentities($fleet_item['fleet_name']).'</b>, '.$fleet_item['n_ships'].' '.$this->str_ships;                        
                    }
                }

//Any OTHER fleets here?
                if(($planet['user_id'] == $game->player['user_id']) || $player_sensor || $fleet_sensor) {

                    $sql = 'SELECT user_name, SUM(n_ships) AS n_ships FROM ship_fleets INNER JOIN user ON (ship_fleets.user_id = user.user_id) WHERE planet_id = '.$planet['planet_id'].' AND ship_fleets.owner_id <> '.$game->player['user_id'].' AND ship_fleets.user_id <> '.$game->player['user_id'].' GROUP BY ship_fleets.user_id';

                    if($flist = $db->queryrowset($sql)) {

                        $other_fleet_in_orbit = true;

                        foreach ($flist AS $fitem) {
                            $map_html .='<br>&nbsp;&nbsp;&nbsp;&#183;&#183;&#183;<b>'.$fitem['user_name'].'</b>, '.$fitem['n_ships'].' '.$this->str_ships;
                        }
                    }
                }


// DC More info! Let's push mysql

                $sql = 'SELECT survey_1, survey_2, survey_3 FROM planet_details
                        WHERE log_code = 100 AND planet_id = '.$planet['planet_id'].'
                        AND user_id = '.$game->player['user_id'];

                if($survey_details = $db->queryrow($sql))
                {
                    $map_html .='<br>'.$this->str_res;
                    switch($survey_details['survey_1'])
                    {
                        case 0:
                            $map_html .='<font color=red>'.$this->str_met.'</font> ';
                            break;
                        case 1:
                            $map_html .='<font color=gray>'.$this->str_met.'</font> ';
                            break;
                        case 2:
                            $map_html .='<font color=green>'.$this->str_met.'</font> ';
                            break;
                    }
                    switch($survey_details['survey_2'])
                    {
                        case 0:
                            $map_html .='<font color=red>'.$this->str_mins.'</font> ';
                            break;
                        case 1:
                            $map_html .='<font color=gray>'.$this->str_mins.'</font> ';
                            break;
                        case 2:
                            $map_html .='<font color=green>'.$this->str_mins.'</font> ';
                            break;
                    }
                    switch($survey_details['survey_3'])
                    {
                        case 0:
                            $map_html .='<font color=red>'.$this->str_dilh.'</font>';
                            break;
                        case 1:
                            $map_html .='<font color=gray>'.$this->str_dilh.'</font>';
                            break;
                        case 2:
                            $map_html .='<font color=green>'.$this->str_dilh.'</font>';
                            break;
                    }
                }
// ----
                $map_html .= '\', CAPTION, \''.$this->str_details.'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';
            }
            else {
                $map_html .= '<area href="'.parse_link('a=tactical_cartography&planet_id='.encode_planet_id($planet['planet_id'])).'" shape="circle" coords="'.(int)$planet_x.', '.(int)$planet_y.', '.$PLANETS_DATA[$current_type][8].'"';
                $map_html .= ' onmouseover="return overlib(\'<b><i>&#171;Nessuna Informazione&#187;</i></b>\', CAPTION, \''.$this->str_details.'\', WIDTH, 300, '.OVERLIB_STANDARD.');" onmouseout="return nd();">';
            }

            $rect_colors = array();

            if(($planet['user_id'] == $game->player['user_id']) || ($planet['alliance_id'] == $game->player['user_alliance']) || $system_is_known) {
                if($planet['planet_id'] == $game->planet['planet_id']) {
                    $rect_colors[] = $cl_active_planet;
                }

                if($planet['user_attack_protection'] > $ACTUAL_TICK) {
                    $rect_colors[] = $cl_attack_protection;
                }

                /* Per ora non serve più
                $rotz = 0;

                $rotz = $planet['alliance_id'];

                if(empty($rotz)) $rotz = 0;

                $sql = 'SELECT ad_id, alliance1_id, alliance2_id, type, status
                        FROM alliance_diplomacy
                        WHERE (alliance1_id = '.$rotz.' OR
                               alliance2_id = '.$rotz.') AND (alliance1_id = '.$game->player['user_alliance'].' OR
                               alliance2_id = '.$game->player['user_alliance'].') AND ((status = 0) OR (type=1 AND status=2))';

                if(($alliance_1 = $db->queryrow($sql)) === false) {
                    message(DATABASE_ERROR, 'Could not query alliance data');
                }

                if(!empty($alliance_1['ad_id'])){

                    $sql = 'SELECT alliance_id
                            FROM alliance
                            WHERE alliance_id != '.$game->player['user_alliance'].' AND
                                 (alliance_id = '.$alliance_1['alliance1_id'].' OR
                                  alliance_id = '.$alliance_1['alliance2_id'].')';

                    if(($alliance_2 = $db->queryrow($sql)) === false) {
                        message(DATABASE_ERROR, 'Could not query alliance data');
                    }
                }
                */

                if($planet['user_id'] == $game->player['user_id']) {
                   $rect_colors[] = $cl_own_planet;
                }
                elseif($planet['user_id'] == INDEPENDENT_USERID) {
                    $rect_colors[] = $cl_settlers_planet;
                }
                elseif($planet['user_id'] == ORION_USERID) {
                    $rect_colors[] = $cl_orion_planet;
                }

                if($my_fleet_in_orbit) {
                    $rect_colors[] = $cl_alliance_bnd_pbnd; // azzurro = nostre flotte in orbita
                }

                if($other_fleet_in_orbit) {
                    $rect_colors[] = $cl_alliance_war;    // rosso = altre flotte in orbita
                }

                /*
                elseif($planet['alliance_id'] == $game->player['user_alliance']) {
                   $rect_colors[] = $cl_alliance_planet;
                }
                elseif($planet['alliance_id']==$alliance_2['alliance_id'] && $alliance_1['type'] == 1){
                  $rect_colors[] = $cl_alliance_war;
                }
                elseif($planet['alliance_id']==$alliance_2['alliance_id'] && $alliance_1['type'] == 3){
                  $rect_colors[] = $cl_alliance_bnd_pbnd;
                }
                */
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
        global $game, $db,$game_path;

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
            imagecolorallocate($im, 0, 0, 255), // blue
            imagecolorallocate($im, 255, 255, 255), // white
            imagecolorallocate($im, 200, 100, 0), // yellow
            imagecolorallocate($im, 255, 0, 0), // red
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

        imagepng($im, $game_path.'maps/images/galaxy_detail.png');
        imagedestroy($im);
    }
}

?>
