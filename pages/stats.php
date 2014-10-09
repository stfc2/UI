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

error_reporting(E_ERROR);


function format_filesize($value, $limes = 6, $comma = 0) {
    $byte_units   = array('Byte', 'KB', 'MB');

    $dh           = pow(10, $comma);
    $li           = pow(10, $limes);
    $return_value = $value;
    $unit         = $byte_units[0];

    if($value >= ($li * 1000000)) {
        $value = round($value / (1073741824 / $dh))/$dh;
        $unit  = $byte_units[3];
    }
    elseif ($value >= ($li * 1000)) {
        $value = round($value / (1048576 / $dh))/$dh;
        $unit  = $byte_units[2];
    }
    elseif ($value >= $li) {
        $value = round($value / (1024 / $dh) ) /$dh;
        $unit  = $byte_units[1];
    }

    if($unit != $byte_units[0]) {
        $return_value = number_format($value, $comma, ',', '.');
    }
    else {
        $return_value = number_format($value, 0, ',', '.');
    }

    return $return_value.' '.$unit;
}

  function uptime () {
    global $text;
    $fd = fopen('/proc/uptime', 'r');
    $ar_buf = split(' ', fgets($fd, 4096));
    fclose($fd);

    $sys_ticks = trim($ar_buf[0]);

    $min = $sys_ticks / 60;
    $hours = $min / 60;
    $days = floor($hours / 24);
    $hours = floor($hours - ($days * 24));
    $min = floor($min - ($days * 60 * 24) - ($hours * 60));

    if ($days != 0) {
      $result = "$days d ";
    }

    if ($hours != 0) {
      $result .= "$hours h ";
    }
    $result .= "$min m";

    return $result;
  }

  function loadavg () {
    if ($fd = fopen('/proc/loadavg', 'r')) {
      $results = split(' ', fgets($fd, 4096));
      fclose($fd);
    } else {
      $results = array('N.A.', 'N.A.', 'N.A.');
    }
    return $results;
  }





  function memory () {
    if ($fd = fopen('/proc/meminfo', 'r')) {
      $results['ram'] = array();
      $results['swap'] = array();
      $results['devswap'] = array();

      while ($buf = fgets($fd, 512)) {
        if (preg_match('/^MemTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['ram']['total'] = $ar_buf[1];
        } else if (preg_match('/^MemFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['ram']['free'] = $ar_buf[1];
        } else if (preg_match('/^Cached:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['ram']['cached'] = $ar_buf[1];
        } else if (preg_match('/^Buffers:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['ram']['buffers'] = $ar_buf[1];
        } else if (preg_match('/^SwapTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['swap']['total'] = $ar_buf[1];
        } else if (preg_match('/^SwapFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
          $results['swap']['free'] = $ar_buf[1];
        } 
      } 
      $results['ram']['shared'] = 0;
      $results['ram']['used'] = $results['ram']['total'] - $results['ram']['free'];
      $results['swap']['used'] = $results['swap']['total'] - $results['swap']['free'];
      fclose($fd);
      $swaps = file ('/proc/swaps');
      $swapdevs = split("\n", $swaps);

      for ($i = 1; $i < (sizeof($swapdevs) - 1); $i++) {
        $ar_buf = preg_split('/\s+/', $swapdevs[$i], 6);

        $results['devswap'][$i - 1] = array();
        $results['devswap'][$i - 1]['dev'] = $ar_buf[0];
        $results['devswap'][$i - 1]['total'] = $ar_buf[2];
        $results['devswap'][$i - 1]['used'] = $ar_buf[3];
        $results['devswap'][$i - 1]['free'] = ($results['devswap'][$i - 1]['total'] - $results['devswap'][$i - 1]['used']);
        $results['devswap'][$i - 1]['percent'] = round(($ar_buf[3] * 100) / $ar_buf[2]);
      } 
      // I don't like this since buffers and cache really aren't
      // 'used' per say, but I get too many emails about it.
      $results['ram']['t_used'] = $results['ram']['used'];
      $results['ram']['t_free'] = $results['ram']['total'] - $results['ram']['t_used'];
      $results['ram']['percent'] = round(($results['ram']['t_used'] * 100) / $results['ram']['total']);
      $results['swap']['percent'] = round(($results['swap']['used'] * 100) / $results['swap']['total']);
    } else {
      $results['ram'] = array();
      $results['swap'] = array();
      $results['devswap'] = array();
    } 
    return $results;
  } 

  function cpu () {
    if($fd = fopen('/proc/cpuinfo', 'r')) {
      $results = array();
      $results['cores'] = 0;

      while($buf = fgets($fd, 512)) {
        if(stristr($buf,"model name")) {
          strtok($buf,':');
          $results['model'] = strtok(':');
          $results['cores']++;
        }
      }
      fclose($fd);
    }
    return $results;
  } 




// loadavg
$loadavg = loadavg();
// uptime
$uptime=uptime();

// free ram
$results=memory();

// cpu type
$cpu=cpu();

for ($t=0; $t<13; $t++)
{
    $r_tmp = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_race='.$t.' AND user_auth_level=1');
    $race['racecount_'.$t]=$r_tmp['num'];
}

$t_percent = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_auth_level=1');


for ($t=0; $t<13; $t++)
{
    $race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
}

for ($t=0; $t<13; $t++)
{
    $p_tmp = $db->queryrow('SELECT COUNT(planet_id) AS num FROM planets, user WHERE planets.planet_owner = user.user_id AND user.user_auth_level = 1 AND user.user_race='.$t);
    $planet['planetcount_'.$t]=$p_tmp['num'];
}

$p_percent = $db->queryrow('SELECT COUNT(planet_id) AS num FROM planets, user WHERE planet_owner <> 0 AND planets.planet_owner = user.user_id AND user.user_auth_level = 1');

for ($t=0; $t<13; $t++)
{
    $planet['planetpercent_'.$t]=round(100/($p_percent['num'])*$planet['planetcount_'.$t],0);
}



// game stats
$player_count = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=1 AND user_auth_level=1');
$player_newreg = $db->queryrow('SELECT new_register AS num FROM config');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20).' AND user_auth_level=1');
$systems_ingame = $db->queryrow('SELECT COUNT(system_id) AS num FROM starsystems');
$planets_ingame = $db->queryrow('SELECT COUNT(planet_id) AS num, SUM(planet_points) AS points_sum FROM planets');
$alliance_ingame = $db->queryrow('SELECT COUNT(alliance_id) AS num FROM alliance');
$pp_ingame = $db->queryrow('SELECT COUNT(ud_id) AS num FROM user_diplomacy WHERE accepted=1');
$pa_ingame = $db->queryrow('SELECT COUNT(ad_id) AS num FROM alliance_diplomacy');

// 2nd galaxy game stats
$player_count2 = $db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=1 AND user_auth_level=1');
$player_newreg2 = $db2->queryrow('SELECT new_register AS num FROM config');
$player_online2 = $db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20).' AND user_auth_level=1');
$systems_ingame2 = $db2->queryrow('SELECT COUNT(system_id) AS num FROM starsystems');
$planets_ingame2 = $db2->queryrow('SELECT COUNT(planet_id) AS num, SUM(planet_points) AS points_sum FROM planets');
$alliance_ingame2 = $db2->queryrow('SELECT COUNT(alliance_id) AS num FROM alliance');
$pp_ingame2 = $db2->queryrow('SELECT COUNT(ud_id) AS num FROM user_diplomacy WHERE accepted=1');
$pa_ingame2 = $db2->queryrow('SELECT COUNT(ad_id) AS num FROM alliance_diplomacy');




// code

//$fp = @fopen('./game/code_summary.txt', 'r');
//$first_line = explode(':', @fgets($fp));
//$second_line = explode(':', @fgets($fp));
//@fclose($fp);

//mySQL version info
$tmp = mysql_get_server_info();
$mysqlinfo = $tmp /*substr($tmp, 0, strpos($tmp, "-"))*/;

$title_html = $locale['stats_title'];
$meta_descr = $locale['stats_descr'];
$main_html .= '
<div class="caption">'.$locale['stats'].'</div>

<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
  <tr>
    <td valign="top" align="center" width="300">
      <span class="sub_caption">Server Web/DB (STFC)</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="130" class="desc_row">CPUs:</td>
                <td width="140" class="value_row">'.$cpu['model'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Core:</td>
                <td class="value_row">'.$cpu['cores'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['cpu_usage'].'</td>
                <td class="value_row">'.$loadavg[0].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['total_ram'].'</td>
                <td class="value_row">'.round($results['ram']['total']/1024, 2).' MB</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['free_ram'].'</td>
                <td class="value_row">'.round($results['ram']['free']/1024, 2).' MB</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">Uptime:</td>
                <td class="value_row">'.$uptime.'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['php_version'].'</td>
                <td class="value_row">'.phpversion().'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['sql_version'].'</td>
                <td class="value_row">'.$mysqlinfo.'</td>
              </tr>
               <tr><td height="10"></td></tr>
               <tr><td height="10"></td></tr>
            </table>
          </td>
        </tr>
      </table>

      <br>
      <br>

      <span class="sub_caption">'.$locale['racial_statistics'].'<br>'.GALAXY1_NAME.'</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">';

for($r = 0; $r < 12;$r++)
{
    // Skip Borg and Q
    if($r > 5 && $r < 8) continue;
    
    $main_html .= NL.'              <tr>';
    $main_html .= NL.'                <td width="130" class="desc_row">'.$locale['race'.$r].':</td>';
    $main_html .= NL.'                <td width="140" class="value_row">'.$race['racecount_'.$r].' ('.$race['racepercent_'.$r].'%)</td>';
    $main_html .= NL.'              </tr>';
}       
$main_html .= '
              <tr><td height="10"></td></tr>
            </table>
          </td>
        </tr>
      </table>

      <br>

      <span class="sub_caption">'.$locale['affiliate_planets'].'<br>'.GALAXY1_NAME.'</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">';

for($r = 0; $r < 12;$r++)
{
    // Skip Borg and Q
    if($r > 5 && $r < 8) continue;
    
    $main_html .= NL.'              <tr>';
    $main_html .= NL.'                <td width="130" class="desc_row">'.$locale['race'.$r].':</td>';
    $main_html .= NL.'                <td width="140" class="value_row">'.$planet['planetcount_'.$r].' ('.$planet['planetpercent_'.$r].'%)</td>';
    $main_html .= NL.'              </tr>';
}       

$main_html .= '
              <tr><td height="10"></td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>

    <td valign="top" align="center" width="300">
      <span class="sub_caption">'.$locale['galaxy'].' '.GALAXY1_NAME.'</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" class="desc_row">'.$locale['round_start'].'</td>
                <td width="100" class="value_row">--.--.----</td>
              </tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['round_end'].'</td>
                <td width="100" class="value_row">--.--.----</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['view_galaxy'].'</td>
                <td width="100" class="value_row"><a href="http://www.stfc.it/game/maps/images/galaxy_detail.png" target=_blank><i>'.$locale['click'].'</i></a></td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['active_players'].'</td>
                <td width="100" class="value_row">'.$player_count['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['registered_today'].'</td>
                <td class="value_row">'.$player_newreg['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['online_players'].'</td>
                <td class="value_row">'.$player_online['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['players_treaties'].'</td>
                <td class="value_row">'.$pp_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['founded_alliances'].'</td>
                <td class="value_row">'.$alliance_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['alliances_treaties'].'</td>
                <td class="value_row">'.$pa_ingame['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['solar_systems'].'</td>
                <td class="value_row">'.$systems_ingame['num'].'</td>
              <tr>
                <td class="desc_row">'.$locale['planets'].'</td>
                <td class="value_row">'.$planets_ingame['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['sum_of_all_points'].'</td>
                <td class="value_row">'.$planets_ingame['points_sum'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['points_by_player'].'</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $player_count['num']), 2).'</td>
              <tr>
                <td class="desc_row">'.$locale['points_by_planet'].'</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $planets_ingame['num']), 2).'</td>
              </tr>
              <tr><td height="10"></td></tr>
            </table>
          </td>
        </tr>
      </table>
      <br>

      <span class="sub_caption">'.$locale['galaxy'].' '.GALAXY2_NAME.'</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" class="desc_row">'.$locale['round_start'].'</td>
                <td width="100" class="value_row">--.--.----</td>
              </tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['round_end'].'</td>
                <td width="100" class="value_row">--.--.----</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['view_galaxy'].'</td>
                <td width="100" class="value_row"><a href="http://www.stfc.it/game2/maps/images/galaxy_detail.png" target=_blank><i>'.$locale['click'].'</i></a></td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td width="170" class="desc_row">'.$locale['active_players'].'</td>
                <td width="100" class="value_row">'.$player_count2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['registered_today'].'</td>
                <td class="value_row">'.$player_newreg2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['online_players'].'</td>
                <td class="value_row">'.$player_online2['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['players_treaties'].'</td>
                <td class="value_row">'.$pp_ingame2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['founded_alliances'].'</td>
                <td class="value_row">'.$alliance_ingame2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['alliances_treaties'].'</td>
                <td class="value_row">'.$pa_ingame2['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['solar_systems'].'</td>
                <td class="value_row">'.$systems_ingame2['num'].'</td>
              <tr>
                <td class="desc_row">'.$locale['planets'].'</td>
                <td class="value_row">'.$planets_ingame2['num'].'</td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td class="desc_row">'.$locale['sum_of_all_points'].'</td>
                <td class="value_row">'.$planets_ingame2['points_sum'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.$locale['points_by_player'].'</td>
                <td class="value_row">'.round( ($planets_ingame2['points_sum'] / $player_count2['num']), 2).'</td>
              <tr>
                <td class="desc_row">'.$locale['points_by_planet'].'</td>
                <td class="value_row">'.round( ($planets_ingame2['points_sum'] / $planets_ingame2['num']), 2).'</td>
              </tr>
              <tr><td height="10"></td></tr>
            </table>
          </td>
        </tr>
      </table>

    </td>
  </tr>
</table>
<br>
';

?>
