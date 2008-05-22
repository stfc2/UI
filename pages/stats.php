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





// loadavg
$loadavg = loadavg();
// uptime
$uptime=uptime();

// free ram
$results=memory();


// game stats
$player_count = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_active=1');
$player_newreg = $db->queryrow('SELECT new_register AS num FROM config');
$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));
$systems_ingame = $db->queryrow('SELECT COUNT(system_id) AS num FROM starsystems');
$planets_ingame = $db->queryrow('SELECT COUNT(planet_id) AS num, SUM(planet_points) AS points_sum FROM planets');
$alliance_ingame = $db->queryrow('SELECT COUNT(alliance_id) AS num FROM alliance');
$pp_ingame = $db->queryrow('SELECT COUNT(ud_id) AS num FROM user_diplomacy WHERE accepted=1');
$pa_ingame = $db->queryrow('SELECT COUNT(ad_id) AS num FROM alliance_diplomacy');




for ($t=0; $t<12; $t++)
{
$r_tmp = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_race='.$t);
$race['racecount_'.$t]=$r_tmp['num'];
}

$t_percent = $db->queryrow('SELECT COUNT(user_id) AS num FROM user');


for ($t=0; $t<12; $t++)
{
$race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
}

// code

//$fp = @fopen('./game/code_summary.txt', 'r');
//$first_line = explode(':', @fgets($fp));
//$second_line = explode(':', @fgets($fp));
//@fclose($fp);


$main_html .= '
<style type="text/css">
<!--
td.desc_row {  }
td.value_row { color: #BOBOBO; font-weight: bold;}
//-->
</style>
<center><span class="caption">Statistiken</span></center><br>

<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
  <tr>
    <td valign="top" align="center" width="300" valign=top>
      <span class="sub_caption">Web/DB Server (Rosi)</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
              <tr>
                <td width="130" class="desc_row">CPUs:</td>
                <td width="140" class="value_row">1x Dual Core AMD Opteron(tm) 265</td>
              </tr>

              <tr>
                <td class="desc_row">Kerne:</td>
                <td class="value_row">2</b></td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td class="desc_row">Auslastung:</td>
                <td class="value_row">'.$loadavg[0].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">RAM gesamt:</td>
                <td class="value_row">512 MB</td>
              </tr>
              <tr>
                <td class="desc_row">RAM frei:</td>
                <td class="value_row">'.round($results['ram']['free']/1024, 2).' MB</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Uptime:</td>
                <td class="value_row">'.$uptime.'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">PHP Version:</td>
                <td class="value_row">'.phpversion().'</td>
              </tr>
            <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">mySQL Version:</td>
                <td class="value_row">4.1.18 amd64</td>
              </tr>

               <tr height="10"><td></td></tr>
               <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>
       
    
      
      
      <br>



    <br>
            <span class="sub_caption">Rassen-Statisktiken</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="130" class="desc_row">Menschen:</td>
                <td width="140" class="value_row">'.$race['racecount_0'].' ('.$race['racepercent_0'].'%)</td>
              </tr>
              <tr>
                <td class="desc_row">Romulaner:</td>
                <td class="value_row">'.$race['racecount_1'].' ('.$race['racepercent_1'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Klingonen:</td>
                <td class="value_row">'.$race['racecount_2'].' ('.$race['racepercent_2'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Cardassianer:</td>
                <td class="value_row">'.$race['racecount_3'].' ('.$race['racepercent_3'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Dominion:</td>
                <td class="value_row">'.$race['racecount_4'].' ('.$race['racepercent_4'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Ferengi:</td>
                <td class="value_row">'.$race['racecount_5'].' ('.$race['racepercent_5'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Spezies 8472:</td>
                <td class="value_row">'.$race['racecount_8'].' ('.$race['racepercent_8'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Hirogen:</td>
                <td class="value_row">'.$race['racecount_9'].' ('.$race['racepercent_9'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Kazon:</td>
                <td class="value_row">'.$race['racecount_11'].' ('.$race['racepercent_11'].'%)</b></td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>

    </td>
    
    <td valign="top" align="center" width="300"  valign=top>
      <span class="sub_caption">Brown Bobby Galaxy</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" class="desc_row">Läuft seit:</td>
                <td width="100" class="value_row">13.01.2007</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Galaxiekarte:</td>
                <td width="100" class="value_row"><a href="|game_url|/game/maps/images/galaxy_detail.png" target=_blank><i>Klick</i></a></td>
              </tr>
              <tr>
                <td width="170" class="desc_row">Userkarte:</td>
                <td width="100" class="value_row"><a href="index.php?a=bb_karte"><i>Klick</i></a></td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Aktive Spieler:</td>
                <td width="100" class="value_row">'.$player_count['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Heutige Neuanmeldungen:</td>
                <td class="value_row">'.$player_newreg['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Spieler online:</td>
                <td class="value_row">'.$player_online['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Private Verträge:</td>
                <td class="value_row">'.$pp_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Gegründete Allianzen:</td>
                <td class="value_row">'.$alliance_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Allianz-Verträge:</td>
                <td class="value_row">'.$pa_ingame['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Sternensysteme:</td>
                <td class="value_row">'.$systems_ingame['num'].'</td>
              <tr>
                <td class="desc_row">Planeten:</td>
                <td class="value_row">'.$planets_ingame['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Summe aller Punkte:</td>
                <td class="value_row">'.$planets_ingame['points_sum'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.chr(248).' pro Spieler:</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $player_count['num']), 2).'</td>
              <tr>
                <td class="desc_row">'.chr(248).' pro Planet:</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $planets_ingame['num']), 2).'</td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
    

      
    </td>
  </tr>
</table>
<br>
';

?>
