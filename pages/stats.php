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

$title_html = 'Star Trek: Frontline Combat - Statistiche';
$meta_descr = 'STFC: Pagina in cui vengono mostrate alcune statistiche di uptime del server e ed informazioni sulle galassie di gioco, i punti accumulati, i pianeti presenti, le alleanze e via dicendo.';
$main_html .= '
<style type="text/css">
<!--
td.desc_row {  }
td.value_row { color: #BOBOBO; font-weight: bold;}
//-->
</style>
<center><span class="caption">Statistiche</span></center><br>

<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
  <tr>
    <td valign="top" align="center" width="300" valign=top>
      <span class="sub_caption">Server Web/DB (STFC)</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
              <tr>
                <td width="130" class="desc_row">CPUs:</td>
                <td width="140" class="value_row">1x Intel Xeon E5320</td>
              </tr>

              <tr>
                <td class="desc_row">Core:</td>
                <td class="value_row">4</b></td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td class="desc_row">Utilizzo:</td>
                <td class="value_row">'.$loadavg[0].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">RAM totale:</td>
                <td class="value_row">'.round($results['ram']['total']/1024, 2).' MB</td>
              </tr>
              <tr>
                <td class="desc_row">RAM libera:</td>
                <td class="value_row">'.round($results['ram']['free']/1024, 2).' MB</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Uptime:</td>
                <td class="value_row">'.$uptime.'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Versione PHP:</td>
                <td class="value_row">'.phpversion().'</td>
              </tr>
            <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Versione mySQL:</td>
                <td class="value_row">'.$mysqlinfo.'</td>
              </tr>

               <tr height="10"><td></td></tr>
               <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>

      <br>
      <br>

      <span class="sub_caption">Statistiche razziali<br>Brown Bobby</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="130" class="desc_row">Federazione:</td>
                <td width="140" class="value_row">'.$race['racecount_0'].' ('.$race['racepercent_0'].'%)</td>
              </tr>
              <tr>
                <td class="desc_row">Romulani:</td>
                <td class="value_row">'.$race['racecount_1'].' ('.$race['racepercent_1'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Klingon:</td>
                <td class="value_row">'.$race['racecount_2'].' ('.$race['racepercent_2'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Cardassiani:</td>
                <td class="value_row">'.$race['racecount_3'].' ('.$race['racepercent_3'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Dominio:</td>
                <td class="value_row">'.$race['racecount_4'].' ('.$race['racepercent_4'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Ferengi:</td>
                <td class="value_row">'.$race['racecount_5'].' ('.$race['racepercent_5'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Breen:</td>
                <td class="value_row">'.$race['racecount_8'].' ('.$race['racepercent_8'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Hirogeni:</td>
                <td class="value_row">'.$race['racecount_9'].' ('.$race['racepercent_9'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Krenim:</td>
                <td class="value_row">'.$race['racecount_10'].' ('.$race['racepercent_10'].'%)</b></td>
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

      <br>

      <span class="sub_caption">Affiliazione pianeti<br>Brown Bobby</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="130" class="desc_row">Federazione:</td>
                <td width="140" class="value_row">'.$planet['planetcount_0'].' ('.$planet['planetpercent_0'].'%)</td>
              </tr>
                <td class="desc_row">Romulani:</td>
                <td class="value_row">'.$planet['planetcount_1'].' ('.$planet['planetpercent_1'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Klingon:</td>
                <td class="value_row">'.$planet['planetcount_2'].' ('.$planet['planetpercent_2'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Cardassiani:</td>
                <td class="value_row">'.$planet['planetcount_3'].' ('.$planet['planetpercent_3'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Dominio:</td>
                <td class="value_row">'.$planet['planetcount_4'].' ('.$planet['planetpercent_4'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Ferengi:</td>
                <td class="value_row">'.$planet['planetcount_5'].' ('.$planet['planetpercent_5'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Breen:</td>
                <td class="value_row">'.$planet['planetcount_8'].' ('.$planet['planetpercent_8'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Hirogeni:</td>
                <td class="value_row">'.$planet['planetcount_9'].' ('.$planet['planetpercent_9'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Krenim:</td>
                <td class="value_row">'.$planet['planetcount_10'].' ('.$planet['planetpercent_10'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Kazon:</td>
                <td class="value_row">'.$planet['planetcount_11'].' ('.$planet['planetpercent_11'].'%)</b></td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>

    <td valign="top" align="center" width="300"  valign=top>
      <span class="sub_caption">Galassia Brown Bobby</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" class="desc_row">In esecuzione dal:</td>
                <td width="100" class="value_row">19.02.2008</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Visualizza galassia:</td>
                <td width="100" class="value_row"><a href="http://www.stfc.it/game/maps/images/galaxy_detail.png" target=_blank><i>Clicca</i></a></td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Giocatori attivi:</td>
                <td width="100" class="value_row">'.$player_count['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Iscritti oggi:</td>
                <td class="value_row">'.$player_newreg['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Giocatori online:</td>
                <td class="value_row">'.$player_online['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Trattati privati:</td>
                <td class="value_row">'.$pp_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Alleanze fondate:</td>
                <td class="value_row">'.$alliance_ingame['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Trattati alleanze:</td>
                <td class="value_row">'.$pa_ingame['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">sistemi solari:</td>
                <td class="value_row">'.$systems_ingame['num'].'</td>
              <tr>
                <td class="desc_row">Pianeti:</td>
                <td class="value_row">'.$planets_ingame['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Somma di tutti i punti:</td>
                <td class="value_row">'.$planets_ingame['points_sum'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.chr(248).' per giocatore:</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $player_count['num']), 2).'</td>
              <tr>
                <td class="desc_row">'.chr(248).' per pianeta:</td>
                <td class="value_row">'.round( ($planets_ingame['points_sum'] / $planets_ingame['num']), 2).'</td>
              </tr>
              <tr height="10"><td></td></tr>
            </table>
          </td>
        </tr>
      </table>
      <br>

      <span class="sub_caption">Galassia Fried Egg</span><br><br>

      <table border="0" cellpadding="2" cellspacing="2" width="270" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" class="desc_row">In esecuzione dal:</td>
                <td width="100" class="value_row">08.06.2009</td>
              </tr>
              <tr>
                <td width="170" class="desc_row">Termine turno il:</td>
                <td width="100" class="value_row">08.12.2009</td>   
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Visualizza galassia:</td>
                <td width="100" class="value_row"><a href="http://www.stfc.it/game2/maps/images/galaxy_detail.png" target=_blank><i>Clicca</i></a></td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td width="170" class="desc_row">Giocatori attivi:</td>
                <td width="100" class="value_row">'.$player_count2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Iscritti oggi:</td>
                <td class="value_row">'.$player_newreg2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Giocatori online:</td>
                <td class="value_row">'.$player_online2['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Trattati privati:</td>
                <td class="value_row">'.$pp_ingame2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Alleanze fondate:</td>
                <td class="value_row">'.$alliance_ingame2['num'].'</td>
              </tr>
              <tr>
                <td class="desc_row">Trattati alleanze:</td>
                <td class="value_row">'.$pa_ingame2['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Sistemi solari:</td>
                <td class="value_row">'.$systems_ingame2['num'].'</td>
              <tr>
                <td class="desc_row">Pianeti:</td>
                <td class="value_row">'.$planets_ingame2['num'].'</td>
              </tr>
              <tr height="10"><td></td></tr>
              <tr>
                <td class="desc_row">Somma di tutti i punti:</td>
                <td class="value_row">'.$planets_ingame2['points_sum'].'</td>
              </tr>
              <tr>
                <td class="desc_row">'.chr(248).' per giocatore:</td>
                <td class="value_row">'.round( ($planets_ingame2['points_sum'] / $player_count2['num']), 2).'</td>
              <tr>
                <td class="desc_row">'.chr(248).' per pianeta:</td>
                <td class="value_row">'.round( ($planets_ingame2['points_sum'] / $planets_ingame2['num']), 2).'</td>
              </tr>
              <tr height="10"><td></td></tr>
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
