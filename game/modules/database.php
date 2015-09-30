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



$game->init_player();

function UnitFight($atk_units, $atk_race, $dfd_units, $dfd_race)
{
    global $RACE_DATA;
    $atk_alive=$atk_units;
    $dfd_alive=$dfd_units;


    $total_dmg[0] = $atk_alive[0] * GetAttackUnit(0,$atk_race) +
                    $atk_alive[1] * GetAttackUnit(1,$atk_race) +
                    $atk_alive[2] * GetAttackUnit(2,$atk_race) +
                    $atk_alive[3] * GetAttackUnit(3,$atk_race) +
                    $RACE_DATA[$atk_race][21] * $atk_alive[4] * 0.2;
    $total_dmg[1] = $dfd_alive[0] * GetAttackUnit(0,$dfd_race) +
                    $dfd_alive[1] * GetAttackUnit(1,$dfd_race) +
                    $dfd_alive[2] * GetAttackUnit(2,$dfd_race) +
                    $dfd_alive[3] * GetAttackUnit(3,$dfd_race) +
                    $RACE_DATA[$dfd_race][21] * $dfd_alive[4];

    $total_dfd[0] = $atk_alive[0] * GetDefenseUnit(0,$atk_race) +
                    $atk_alive[1] * GetDefenseUnit(1,$atk_race) +
                    $atk_alive[2] * GetDefenseUnit(2,$atk_race) +
                    $atk_alive[3] * GetDefenseUnit(3,$atk_race) +
                    $RACE_DATA[$atk_race][21] * $atk_alive[4] * 0.25;
    $total_dfd[1] = $dfd_alive[0] * GetDefenseUnit(0,$dfd_race) +
                    $dfd_alive[1] * GetDefenseUnit(1,$dfd_race) +
                    $dfd_alive[2] * GetDefenseUnit(2,$dfd_race) +
                    $dfd_alive[3] * GetDefenseUnit(3,$dfd_race) +
                    $RACE_DATA[$dfd_race][21] * $dfd_alive[4] * 1.3;

    // Defenders and attackers should never be zero, but since
    // it happened one time let's add a little check here...
    if ($total_dfd[1] == 0) $total_dfd[1] = 1;
    if ($total_dfd[0] == 0) $total_dfd[0] = 1;

    if ($total_dmg[0]/$total_dfd[1]>$total_dmg[1]/$total_dfd[0])
    {
        // Attacker Wins:
        $percent=$total_dfd[1]/$total_dmg[0];
        $total_dmg[1]*=$percent;

        // Dfd Dmg on Worker:
        if ($total_dmg[1]>=$RACE_DATA[$atk_race][21]*2*$atk_alive[4]) {
            $total_dmg[1]-=$RACE_DATA[$atk_race][21]*2*$atk_alive[4];
            $atk_alive[4]=0;
        }
        else {
            $atk_alive[4]-=$total_dmg[1]/($RACE_DATA[$atk_race][21]*2);
            $total_dmg[1]=0;
        }

        // Dfd Dmg:
        for ($t=0; $t<4; $t++)
        {
            if ($total_dmg[1]<=0) break;
            if ($total_dmg[1]>=GetDefenseUnit($t,$atk_race)*$atk_alive[$t]) {
                $total_dmg[1]-=GetDefenseUnit($t,$atk_race)*$atk_alive[$t];
                $atk_alive[$t]=0;
            }
            else {
                $atk_alive[$t]-=$total_dmg[1]/GetDefenseUnit($t,$atk_race);
                $total_dmg[1]=0;
                break;
            }
        }

        $dfd_alive=array(0,0,0,0,0);
    }
    else
    {
        // Defender Wins:
        $percent=$total_dmg[0]/$total_dmg[1];
        $total_dmg[0]*=$percent;
        // Atk Dmg on Worker:
        if ($total_dmg[0]>=$RACE_DATA[$dfd_race][21]*2*$dfd_alive[4]) {
            $total_dmg[0]-=$RACE_DATA[$dfd_race][21]*2*$dfd_alive[4];
            $dfd_alive[4]=0;
        }
        else {
            $dfd_alive[4]-=$total_dmg[0]/($RACE_DATA[$dfd_race][21]*2);
            $total_dmg[0]=0;
        }

        // Atk Dmg:
        for ($t=0; $t<4; $t++)
        {
            if ($total_dmg[0]<=0) break;
            if ($total_dmg[0]>=GetDefenseUnit($t,$dfd_race)*$dfd_alive[$t]) {
                $total_dmg[0]-=GetDefenseUnit($t,$dfd_race)*$dfd_alive[$t];
                $dfd_alive[$t]=0;
            }
            else {
                $dfd_alive[$t]-=$total_dmg[0]/GetDefenseUnit($t,$dfd_race);
                $total_dmg[0]=0;
                break;
            }
        }

        $atk_alive=array(0,0,0,0,0);
    }


    for ($t=0; $t<5; $t++)
    {
        if ($dfd_alive[$t]<0) $dfd_alive[$t]=0;
        if ($atk_alive[$t]<0) $atk_alive[$t]=0;
        if ($dfd_alive[$t]>$dfd_units[$t]) $dfd_alive[$t]=$dfd_units[$t];
        if ($atk_alive[$t]>$atk_units[$t]) $atk_alive[$t]=$atk_units[$t];

        $dfd_alive[$t]=round($dfd_alive[$t]);
        $atk_alive[$t]=round($atk_alive[$t]);
    }

    return (array(0=>$atk_alive,1=>$dfd_alive));
}


$DATABASE_MODULES = array(
    'planets' => constant($game->sprache("TEXT11")),
    'racedata' => constant($game->sprache("TEXT12")),
    'security' => constant($game->sprache("TEXT13")),
    'combatsim' => constant($game->sprache("TEXT14")),
//    'academy' => constant($game->sprache("TEXT15")),
    'guide' => constant($game->sprache("TEXT16"))
);

$module = (!empty($_GET['view'])) ? $_GET['view'] : 'planets';
$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).' '.$RACE_DATA[$game->player['user_race']][0].'</span><br><br>'.display_view_navigation('database', $module, $DATABASE_MODULES).'<br><br>');

if($module == 'planets' || isset($_GET['planet_type']))
{

    foreach($PLANETS_TEXT as $type => $data) {
        $type = strtolower($type);

        /* 26/02/09 - AC: Check if it's currently present in the url request */
        if(isset($_GET['planet_type']) && $type == strtolower($_GET['planet_type'])) {
            $high_start = '<span style="color: #FFFF00; font-weight: bold;">';
            $high_end = '</span>';
        }
        else {
            $high_start = $high_end = '';
        }
        
        $shipyard_text = array(
            1 => constant($game->sprache("TEXT114")),
            2 => constant($game->sprache("TEXT115")),
            3 => constant($game->sprache("TEXT116")),
            4 => constant($game->sprache("TEXT117"))
        );
        
        $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td>
    <table width="450" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT1")).'</u></td>
        <td><a name="'.strtoupper($type).'">'.$high_start.strtoupper($type).$high_end.'</a></td>
      </tr>
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT2")).'</u></td>
        <td>'.$high_start.$data[0].$high_end.'</td>
      </tr>
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT3")).'</u></td>
        <td>'.$data[1].'</td>
      </tr>
      <tr>
        <td valign="top"<u>'.constant($game->sprache("TEXT7")).'</u></td>
        <td>'.$PLANETS_DATA[$type][7].'<br><i>'.constant($game->sprache("TEXT8")).'</i></td>
      </tr>
      <tr>
        <td valign="top"<u>'.constant($game->sprache("TEXT9")).'</u></td>
        <td>'.$PLANETS_DATA[$type][6].'<br><i>'.constant($game->sprache("TEXT10")).'</i></td>
      </tr>
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT4")).'</u></td>
        <td>'.$data[2].'</td>
      </tr>
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT113")).'</u></td>
        <td>'.$shipyard_text[$PLANETS_DATA[$type][14]].'</td>
      </tr>      
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT5")).'</u></td>
        <td align="justify">'.$data[3].'</td>
      </tr>
      <tr>
        <td valign="top"><u>'.constant($game->sprache("TEXT6")).'</u></td>
        <td>'.$data[4].'</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><img src="'.FIXED_GFX_PATH.'planet_type_'.$type.'.png" border="0"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<br>
        ');
    }
}
else if($module == 'security')
{
    $game->out('
<table align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td>
      <table align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
        <tr>
          <td align="center">'.constant($game->sprache("TEXT17")).'</td><td align="center">'.constant($game->sprache("TEXT18")).'</td>
          <td align="center">'.constant($game->sprache("TEXT17")).'</td><td align="center">'.constant($game->sprache("TEXT18")).'</td>
        </tr>
    ');

    for($planet = 0;$planet < 20;$planet++)
    {
        $security = round(pow($planet*MIN_TROOPS_PLANET,1+$planet*0.01),0);
        $game->out('
        <tr>
          <td align="center">'.($planet+1).'</td><td align="center">'.$security.'</td>
    ');

        $security = round(pow(($planet+20)*MIN_TROOPS_PLANET,1+($planet+20)*0.01),0);
        $game->out('
          <td align="center">'.($planet+21).'</td><td align="center">'.$security.'</td>
        </tr>');
    }
    $game->out('
        <tr>
          <td></td><td></td><td align="center">41+</td><td align="center">'.constant($game->sprache("TEXT19")).'</td>
        </tr>
      </table>
    </td>
  </tr>
</table>');
}
else if($module == 'combatsim')
{
    $units = array(
        constant($game->sprache("TEXT20")),
        constant($game->sprache("TEXT21")),
        constant($game->sprache("TEXT22")),
        constant($game->sprache("TEXT23")),
        constant($game->sprache("TEXT24")));

    if(empty($_POST['startsim'])) {
        $game->out('
<form name="campsim" method="post" action="'.parse_link('a=database&view=combatsim').'">
<table width=400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
     <td align="center"><span class="sub_caption">'.constant($game->sprache("TEXT25")).'</span></td>
   </tr>
   <tr>
     <td>
       <table width="400" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
         <tr>
          <td colspan="2" align="center">'.constant($game->sprache("TEXT26")).'</td>
          <td colspan="2" align="center">'.constant($game->sprache("TEXT27")).'<td>
        </tr>');

        for($i=1;$i<6;$i++)
        {
            $game->out('
        <tr>
          <td>'.$units[$i-1].'</td>
          <td><input type="text" name="atk_unit_'.$i.'" value="0" class="Field_nosize" size="10" maxlength="5"></td>
          <td>'.$units[$i-1].'</td>
          <td><input type="text" name="dfd_unit_'.$i.'" value="0" class="Field_nosize" size="10" maxlength="5"></td>
        </tr>');
        }

        $game->out('
        <tr>
          <td>'.constant($game->sprache("TEXT28")).'</td>
          <td>
            <select name="atk_race" class="Select" size="1">');

        foreach($RACE_DATA as $i => $race) {
            if($i != 7 && $i != 12) 
                $game->out('
            <option value="'.$i.'">'.$race[0].'</option>');
        }

        $game->out('
            </select>
          </td>
          <td>'.constant($game->sprache("TEXT28")).'</td>
          <td>
            <select name="dfd_race" class="Select" size="1">');

        foreach($RACE_DATA as $i => $race) {
            if($i != 6 && $i != 7 && $i != 12) 
                $game->out('
            <option value="'.$i.'">'.$race[0].'</option>');
        }

        $game->out('
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="4" align="center"><input class="button" type="submit" name="startsim" value="'.constant($game->sprache("TEXT29")).'"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>');
    }
    else
    {
        $atk_units = array();
        $dfd_units = array();

        $atk_units[0] = $_POST['atk_unit_1'];
        $atk_units[1] = $_POST['atk_unit_2'];
        $atk_units[2] = $_POST['atk_unit_3'];
        $atk_units[3] = $_POST['atk_unit_4'];
        $atk_units[4] = $_POST['atk_unit_5'];

        $dfd_units[0] = $_POST['dfd_unit_1'];
        $dfd_units[1] = $_POST['dfd_unit_2'];
        $dfd_units[2] = $_POST['dfd_unit_3'];
        $dfd_units[3] = $_POST['dfd_unit_4'];
        $dfd_units[4] = $_POST['dfd_unit_5'];

        $atk_race = $_POST['atk_race'];
        $dfd_race = $_POST['dfd_race'];

        $res = UnitFight($atk_units, $atk_race, $dfd_units, $dfd_race);

        $atk_alive = $res[0];
        $dfd_alive = $res[1];

        $n_atk_alive = array_sum($atk_alive);
        $n_dfd_alive = array_sum($dfd_alive);

        $game->out('
<table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
  <tr>
    <td align="center"><span class="sub_caption">'.constant($game->sprache("TEXT30")).'</span><br>'.constant($game->sprache("TEXT31")).'</td>
  </tr>
  <tr>
    <td>
      <table width="400" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
        <tr>
          <td colspan="2" align="center">'.constant($game->sprache("TEXT26")).'</td>
          <td colspan="2" align="center">'.constant($game->sprache("TEXT27")).'<td>
        </tr>');

        for($i=1;$i<6;$i++)
        {
            $game->out('
        <tr>
          <td>'.$units[$i-1].'</td>
          <td>'.($atk_units[$i-1]-$atk_alive[$i-1]).'</td>
          <td>'.$units[$i-1].'</td>
          <td>'.($dfd_units[$i-1]-$dfd_alive[$i-1]).'</td>
        </tr>');
        }

        $game->out('
        <tr>
            <td>'.constant($game->sprache("TEXT28")).'</td>
            <td>'.$RACE_DATA[$atk_race][0].'</td>
            <td>'.constant($game->sprache("TEXT28")).'</td>
            <td>'.$RACE_DATA[$dfd_race][0].'</td>
        </tr>
        <tr>
            <td colspan="4" align="center">');

        if($n_dfd_alive >= $n_atk_alive)
            $game->out('<span class="sub_caption">'.constant($game->sprache("TEXT32")).'</span>');
        else
            $game->out('<span class="sub_caption">'.constant($game->sprache("TEXT33")).'</span>');

        $game->out('
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<a href="'.parse_link('a=database&view=combatsim').'">'.constant($game->sprache("TEXT34")).'</a>');

    }
}
else if($module == 'racedata')
{
    foreach($RACE_DATA as $i => $race) {
        // Skip Borg, Q, 29th Humans races
        if($i != 5 && $i != 6 && $i != 7 && $i != 8 && $i != 10 && $i != 12)
        {
            $game->out('[<a href="'.parse_link('a=database&view=racedata&show_race='.$i.'#'.$i.'').'">'.$race[0].'</a>] ');
        }
    }

    $game->out('
    <table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
    <tr>
        <td align="center"><span class="sub_caption">'.constant($game->sprache("TEXT106")).'</span></td>
    </tr>
    ');

    foreach($RACE_DATA as $i => $race) {
        // Skip Borg, Q, 29th Humans races
        if($i != 5 && $i != 6 && $i != 7 && $i != 8 && $i != 10 && $i != 12)
        {
            $game->out('
    <tr><td>
    <table width="400" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">');

            foreach($race as $j => $value) {
                switch($j)
                {
                    // Name of the race and Fighting power of workers
                    case 0:
                        if(isset($_GET['show_race'])) $show = (int)$_GET['show_race']; else $show = -1;

                        if($i == $show) {
                            $data = '<span style="color: #FFFF00; font-weight: bold;">'.$value.'</span>';
                        }
                        else {
                            $data = $value;
                        }
                        $data ='<a name="'.$i.'">'.$data.'</a>';
                    break;
                    // Fighting power of workers
                    case 21:
                        $data = $value;
                    break;
                    // Playable?
                    case 22:
                        $data = ($value ? constant($game->sprache("TEXT100")) : constant($game->sprache("TEXT101")));
                    break;
                    case 29:
                        $data = '';
                        if($value[0]) $data .= constant($game->sprache("TEXT107")).'<br>';
                        if($value[1]) $data .= constant($game->sprache("TEXT108")).'<br>';
                        if($value[2]) $data .= constant($game->sprache("TEXT109")).'<br>';
                        if($value[3]) $data .= constant($game->sprache("TEXT110")).'<br>';
                        if($value[4]) $data .= constant($game->sprache("TEXT111"));
                    break;
                    case 30:
                        $data = ($value ? constant($game->sprache("TEXT100")) : constant($game->sprache("TEXT101")));
                    break;
                    case 31:
                        $data = $value;
                        break;
                    default:
                        $data = ($value * 100).' %';
                    break;
                }

                if(empty($data)) $data = constant($game->sprache("TEXT112"));
                $game->out('
    <tr>
        <td>'.constant($game->sprache("TEXT".($j+35))).'</td><td width="60" align="center">'.$data.'</td>
    </tr>
            ');
            }
            $game->out('
    </table>
    </td></tr>');
        }
    }
    $game->out('</table>');

}
else if($module == 'academy')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'guide')
{
    if(isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    }
    else
        $page = 0;

    $file = 'help/guide/page'.$page.'.php';
    if(!file_exists($file)) {
        $guide_html =  '<span class="caption">'.constant($game->sprache("TEXT102")).'</span></center><br><br>';
    }
    else
        include($file);

    $game->out('
    <table width="450" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
      <tr>
        <td>
          <table width="450" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
            <tr><td>'.$guide_html.'</td></tr>
          </table>
        </td>
      </tr>
    </table><br>');

    $game->out('
        <table width="420" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
            <tr>
    ');

    if($page > 0)
        $game->out('<td width="140">[<a href="'.parse_link('a=database&view=guide&page='.($page-1)).'">'.constant($game->sprache("TEXT103")).'</a>]</td>');
    else
        $game->out('<td width="140"></td>');

    if ($page != 0)
        $game->out('<td width="140" align="center">[<a href="'.parse_link('a=database&view=guide').'">'.constant($game->sprache("TEXT104")).'</a>]</td>');
    else
        $game->out('<td width="140"></td>');

    if($page < 12)
        $game->out('<td width="140" align="right">[<a href="'.parse_link('a=database&view=guide&page='.($page+1)).'">'.constant($game->sprache("TEXT105")).'</a>]</td>');
    else
        $game->out('<td width="140"></td>');

    $game->out('
            </tr>
        </table');

}


?>
