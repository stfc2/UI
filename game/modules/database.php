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

function CreateShipInfoText($ship)
{
global $db;
global $game;
$text='<b>'.$ship[31].'</b><br><br><u>'.constant($game->sprache("TEXT156")).'<br></u><img src='.$game->GFX_PATH.'menu_metal_small.gif> '.$ship[0].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_mineral_small.gif> '.$ship[1].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_latinum_small.gif> '.$ship[2].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_worker_small.gif> '.$ship[30].'<br><img src='.$game->GFX_PATH.'menu_unit1_small.gif> '.$ship['3'].'-'.$ship['7'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit2_small.gif> '.$ship['4'].'-'.$ship['8'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit3_small.gif> '.$ship['5'].'-'.$ship['9'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit4_small.gif> '.$ship['6'].'-'.$ship['10'].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit5_small.gif> '.$ship[11].'&nbsp;&nbsp;<img src='.$game->GFX_PATH.'menu_unit6_small.gif> '.$ship[12].'<br><u>'.constant($game->sprache("TEXT157")).'</u>  '.($ship[13]*TICK_DURATION).' '.constant($game->sprache("TEXT158")).'<br><br><u>'.constant($game->sprache("TEXT159")).'</u><br>';

$text.=constant($game->sprache("TEXT141")).' '.$ship[14].' x'.$ship[32].'<br>';
$text.=constant($game->sprache("TEXT142")).' '.$ship[15].' x'.$ship[33].'<br>';
$text.=constant($game->sprache("TEXT143")).' '.$ship[34].'<br>';
$text.=constant($game->sprache("TEXT144")).' '.$ship[16].'<br>';
$text.=constant($game->sprache("TEXT145")).' '.$ship[17].'<br>';
$text.=constant($game->sprache("TEXT146")).' '.$ship[18].'<br>';
$text.=constant($game->sprache("TEXT147")).' '.$ship[19].'<br>';
$text.=constant($game->sprache("TEXT148")).' '.$ship[20].'<br>';
$text.=constant($game->sprache("TEXT149")).' '.$ship[21].'<br>';
$text.=constant($game->sprache("TEXT150")).' '.$ship[22].'<br>';
$text.=constant($game->sprache("TEXT151")).' '.$ship[23].'<br>';
$text.=constant($game->sprache("TEXT152")).' '.$ship[24].'<br>';
$text.=constant($game->sprache("TEXT153")).' '.$ship[25].'<br>';
$text.=constant($game->sprache("TEXT154")).' '.$ship[27].'<br>';
$text.=constant($game->sprache("TEXT155")).' '.$ship[26].'<br>';


return $text;
}

$DATABASE_MODULES = array(
    'planets' => constant($game->sprache("TEXT11")),
    'racedata' => constant($game->sprache("TEXT12")),
    'shipdata' => constant($game->sprache("TEXT12B")),
    'security' => constant($game->sprache("TEXT13")),
    'combatsim' => constant($game->sprache("TEXT14")),
//    'academy' => constant($game->sprache("TEXT15")),
    'guide' => constant($game->sprache("TEXT16")),
    'rangefinder' => constant($game->sprache("TEXT125"))
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
        
        $settlers_text = array(
            'a' => constant($game->sprache("TEXT123")),
            'b' => constant($game->sprache("TEXT123")),
            'c' => constant($game->sprache("TEXT123")),
            'd' => constant($game->sprache("TEXT123")),
            'e' => constant($game->sprache("TEXT119")),
            'f' => constant($game->sprache("TEXT118")),
            'g' => constant($game->sprache("TEXT118")),
            'h' => constant($game->sprache("TEXT119")),
            'i' => constant($game->sprache("TEXT122")),
            'j' => constant($game->sprache("TEXT122")),
            'k' => constant($game->sprache("TEXT119")),
            'l' => constant($game->sprache("TEXT119")),
            'm' => constant($game->sprache("TEXT118")),
            'n' => constant($game->sprache("TEXT119")),
            'o' => constant($game->sprache("TEXT118")),
            'p' => constant($game->sprache("TEXT118")),
            's' => constant($game->sprache("TEXT122")),
            't' => constant($game->sprache("TEXT122")),
            'x' => constant($game->sprache("TEXT123")),
            'y' => constant($game->sprache("TEXT123"))
        );
        
        $settlers_note = array(
            'a' => constant($game->sprache("TEXT123a")),
            'b' => constant($game->sprache("TEXT123a")),
            'c' => constant($game->sprache("TEXT123a")),
            'd' => constant($game->sprache("TEXT123a")),
            'e' => constant($game->sprache("TEXT119a")),
            'f' => constant($game->sprache("TEXT118a")),
            'g' => constant($game->sprache("TEXT118a")),            
            'h' => constant($game->sprache("TEXT119a")),
            'i' => constant($game->sprache("TEXT122c")),
            'j' => constant($game->sprache("TEXT122a")),
            'k' => constant($game->sprache("TEXT119a")),
            'l' => constant($game->sprache("TEXT119a")),
            'm' => constant($game->sprache("TEXT118a")),
            'n' => constant($game->sprache("TEXT119a")),
            'o' => constant($game->sprache("TEXT118a")),
            'p' => constant($game->sprache("TEXT118a")),
            's' => constant($game->sprache("TEXT122b")),
            't' => constant($game->sprache("TEXT122b")),
            'x' => constant($game->sprache("TEXT123a")),
            'y' => constant($game->sprache("TEXT123a"))
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
        <td valign="top"><u>'.constant($game->sprache("TEXT124")).'</u></td>
        <td>'.$settlers_text[$type].'<br><i>'.$settlers_note[$type].'</i></td>
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
        if($i != 6 && $i != 7 && $i != 10 && $i != 12)
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
        if($i != 6 && $i != 7 && $i != 10 && $i != 12)
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
                    case 32:
                    case 33:
                    case 34:
                    case 35:
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
else if($module == 'shipdata'){

    $ship_class = array(constant($game->sprache("TEXT132")), constant($game->sprache("TEXT133")), constant($game->sprache("TEXT134")), constant($game->sprache("TEXT135")), constant($game->sprache("TEXT135")), constant($game->sprache("TEXT136")), constant($game->sprache("TEXT136")), constant($game->sprache("TEXT137")), constant($game->sprache("TEXT137")), constant($game->sprache("TEXT138")), constant($game->sprache("TEXT138")), constant($game->sprache("TEXT139")), constant($game->sprache("TEXT140")));
    
    $sel_race = filter_input(INPUT_GET, 'show_race', FILTER_SANITIZE_NUMBER_INT);
    
    if(!isset($sel_race) || $sel_race == 6 || $sel_race == 7 || $sel_race == 10 || $sel_race == 12 || $sel_race == 13) {
        $sel_race = $game->player['user_race'];
    }
    
    foreach($RACE_DATA as $i => $race) {
        // Skip Borg, Q, 29th Humans races
        if($i != 6 && $i != 7 && $i != 10 && $i != 12 && $i != 13)
        {
            $game->out('[<a href="'.parse_link('a=database&view=shipdata&show_race='.$i.'').'">'.$race[0].'</a>] ');
        }
    }

    $game->out('
    <table width="400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
    <tr>
        <td colspan=5 align="center">'.constant($game->sprache("TEXT126")).$RACE_DATA[$sel_race][0].'</td>
    </tr>
    <tr>
        <td align="center">
        <table border=0 cellpadding=2 cellspacing=2 width=400 class="style_inner">
        <tr>
            <td align="left" width=150><b>'.constant($game->sprache("TEXT127")).'</b></td>
            <td width=100><b>'.constant($game->sprache("TEXT128")).'</b></td>
            <td width=50 align="center"><b>'.constant($game->sprache("TEXT129")).'</b></td>
            <td width=75 align="center"><b>'.constant($game->sprache("TEXT130")).'</b></td>
            <td width=75 align="center"><b>'.constant($game->sprache("TEXT131")).'</b></td>
        </tr>
    ');  
    $torso_num = count($SHIP_TORSO[$sel_race]);
    
    for ($t=0; $t<$torso_num; $t++) {
        if ($sel_race == 0) //Fed
        {
            if($t==12) {
                break;
            }
        }
        if ($sel_race == 1) //Rom
        {
          if ($t==3)
          {
            $t=4;
          }
          if ($t==8)
          {
            $t=9;
          }
          if ($t==12)
          {
            break;
          }
        }        
        if ($sel_race == 2) //Klingonen
        {
          if ($t==3)
          {
            $t=4;
          }
          if ($t==6)
          {
            $t=7;
          }
          if ($t==8)
          {
            $t=9;
          }
          if ($t==10)
          {
            $t=11;
          }
          if ($t==12)
          {
            break;
          }  
        }

        if ($sel_race == 3) //Cardassianer
        {
          if ($t==3)
          {
            $t=4;
          }
          if ($t==5)
          {
            $t=7;
          }
          if ($t==8)
          {
            $t=9;
          }
          if ($t==10)
          {
            break;
          }
        }

        if ($sel_race == 4) //Dominion
        {

          if ($t==3)
          {
            $t=4;
          }
          if ($t==6)
          {
            $t=9;
          }
          if ($t==10)
          {
            $t=11;
          }
          if ($t==12)  
          {
            break;
          }  
        }

        if ($sel_race == 5) //Ferengi
        {
          if ($t==4)
          {
            $t=8;
          }
          if ($t==9)
          {
            break;
          }
        }

        if ($sel_race == 8) // Breen
        {
          if ($t==0)
          {
            $t=1;
          }
          if ($t==6)
          {
            $t=7;
          }
          if ($t==8)
          {
            $t=9;
          }
          if ($t==10)
          {
            $t=11;
          }
          if ($t==12)  
          {
            break;
          }  
        }

        if ($sel_race == 9) // Hiro
        {
          if ($t==4)
          {
            $t=5;
          }
          if ($t==6)
          {
            $t=7;
          }
          if ($t==8)
          {
            $t=9;
          }
        if ($t==10)  
          {
            break;
          }
        }

        if ($sel_race == 11) // Kazon
        {
          if ($t==4)
          {
            $t=5;
          }
          if ($t==6)
          {
            $t=9;
          }
          if ($t==10)  
          {
            break;
          }          
        }

        $te=$t+1;        
        
        $game->out('
        <tr><td><a href="javascript:void(0);" onmouseover="return overlib(\''.CreateShipInfoText($SHIP_TORSO[$sel_race][$t]).'\', CAPTION, \''.$SHIP_TORSO[$sel_race][$t][29].'\', WIDTH, 400, '.OVERLIB_STANDARD.');" onmouseout="return nd();">'.$SHIP_TORSO[$sel_race][$t][29].'</a>&nbsp;</td><td>'.$ship_class[$t].'</td><td align="center">'.$te.'</td><td align="center"><b>'.GlobalTorsoReq($t,$sel_race).'</b></td><td align="center"><b>'.LocalTorsoReq($t,$sel_race).'</b></td><tr>    
        ');
    }
    
    $game->out('</table></td></tr></table>') ;
}
    
else if($module == 'academy')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'rangefinder')
{  
    include('include/libs/moves.php');
    
    $coord_from = filter_input(INPUT_POST, 'coord_from', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $coord_to = filter_input(INPUT_POST, 'coord_to', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $letters = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18);
    $numbers = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18);
    
    $distance_html = ' - ';
    
    if(!empty($coord_from) && !empty($coord_to)) {
        $coord_from_pieces = explode(':', $coord_from);

        $sector_id = $game->get_sector_id($coord_from_pieces[0]);

        if(!isset($letters[$coord_from_pieces[1][0]])) {
            message(NOTICE, 'Coordinate di partenza'.$coord_from_pieces[1][0].' non alfabetiche');
        }

        $system_y = $letters[$coord_from_pieces[1][0]];
        
        if(!isset($numbers[$coord_from_pieces[1][1]])) {
            message(NOTICE, 'Coordinate di partenza'.$coord_from_pieces[1][1].' non numeriche');
        }

        $system_x = $numbers[$coord_from_pieces[1][1]];
        
        $sql = 'SELECT sector_id, system_id, system_name, system_x, system_y, system_global_x, system_global_y FROM starsystems WHERE sector_id = '.$sector_id.' AND system_x = '.$system_x.' AND system_y = '.$system_y;
        
        if(($data_from = $db->queryrow($sql)) === FALSE) {
            message(NOTICE, $coord_from.' non sono coordinate valide');
        }
        
        $coord_to_pieces = explode(':', $coord_to);

        $sector_id = $game->get_sector_id($coord_to_pieces[0]);

        if(!isset($letters[$coord_to_pieces[1][0]])) {
            message(NOTICE, 'Coordinate di arrivo '.$coord_to_pieces[1][0].' non alfabetiche ');
        }

        $system_y = $letters[$coord_to_pieces[1][0]];
        
        if(!isset($numbers[$coord_to_pieces[1][1]])) {
            message(NOTICE, 'Coordinate di arrivo '.$coord_to_pieces[1][1].' non numeriche');
        }

        $system_x = $numbers[$coord_to_pieces[1][1]];
        
        $sql = 'SELECT sector_id, system_id, system_name, system_x, system_y, system_global_x, system_global_y FROM starsystems WHERE sector_id = '.$sector_id.' AND system_x = '.$system_x.' AND system_y = '.$system_y;
        
        if(($data_to = $db->queryrow($sql)) === FALSE) {
            message(NOTICE, $coord_to.' non sono coordinate valide');
        }

        $distance = get_distance(array($data_from['system_global_x'], $data_from['system_global_y']), array($data_to['system_global_x'],$data_to['system_global_y']));
        
        $distance_html = $data_from['system_name'].' <=== '.round($distance,0).' AU ===> '.$data_to['system_name'];
    }
    
    // Preset Value Recall Phase
    
    $cartography_html = $own_planets_html = $tcm_html = '';
    $i = 0;    
    
    if($game->player['last_tcartography_view'] == 3 || $game->player['last_tcartography_view'] == 4) {
        switch($game->player['last_tcartography_view']) {
            case 3:
                $sql = 'SELECT sd.log_code, p.planet_name, p.sector_id, p.planet_distance_id,
                               s.system_x, s.system_y, system_global_x, system_global_y
                        FROM (planets p)
                        INNER JOIN (starsystems s) ON s.system_id = p.system_id
                        LEFT JOIN (starsystems_details sd) ON (sd.system_id = p.system_id AND sd.user_id = '.$game->player['user_id'].' AND log_code = 0)                        
                        WHERE p.system_id = '.$game->player['last_tcartography_id'].'
                        ORDER BY p.planet_distance_id DESC';                
                break;
            case 4:
                $sql = 'SELECT sd.log_code, p.planet_name, p.sector_id, p.planet_distance_id,
                               s.system_x, s.system_y, system_global_x, system_global_y
                        FROM (planets p)
                        INNER JOIN (starsystems s) ON s.system_id = p.system_id
                        LEFT JOIN (starsystems_details sd) ON (sd.system_id = p.system_id AND sd.user_id = '.$game->player['user_id'].' AND log_code = 0)
                        WHERE p.planet_id = '.$game->player['last_tcartography_id'].'
                        ORDER BY p.planet_distance_id DESC';                
                break;
        }
        
        if(!$q_cart = $db->query($sql)) {
            message(DATABASE_ERROR, 'Could not query tactical cartography data');
        }        
        
        while($cart = $db->fetchrow($q_cart)) {
            $from_script_string .= 'case "'.$i.'": document.rangefind.coord_from.value="'.($game->get_sector_name($cart['sector_id']).':'.$game->get_system_cname($cart['system_x'], $cart['system_y'])).'"; break;';
            $to_script_string   .= 'case "'.$i.'": document.rangefind.coord_to.value="'.($game->get_sector_name($cart['sector_id']).':'.$game->get_system_cname($cart['system_x'], $cart['system_y'])).'"; break;';                        
            $cartography_html .= (isset($cart['log_code']) ? '<option value="'.$i.'">'.($cart['planet_distance_id']+1).':'.$cart['planet_name'].'</option>' : '<option value="'.$i.'">'.($cart['planet_distance_id']+1).':'.constant($game->sprache("TEXT160")).'</option>');
            $i++;
        }        
    }    
    
    $sql = 'SELECT p.planet_name, p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y, system_global_x, system_global_y
            FROM (planets p)
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE p.planet_owner = '.$game->player['user_id'].'
            ORDER BY p.planet_name ASC';

    if(!$q_own_planets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query own planets coord data');
    }

    //$i = 0;
    while($planet = $db->fetchrow($q_own_planets)) {
        $from_script_string .= 'case "'.$i.'": document.rangefind.coord_from.value="'.($game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y'])).'"; break;';        
        $to_script_string   .= 'case "'.$i.'": document.rangefind.coord_to.value="'.($game->get_sector_name($planet['sector_id']).':'.$game->get_system_cname($planet['system_x'], $planet['system_y'])).'"; break;';        
        $own_planets_html .= '<option value="'.$i.'">'.$planet['planet_name'].'</option>';
        $i++;
    }
    
    $sql = 'SELECT tcm.memo_name,
                   p.sector_id, p.planet_distance_id,
                   s.system_x, s.system_y
            FROM (tc_coords_memo tcm)
            INNER JOIN (planets p) ON p.planet_id = tcm.memo_id
            INNER JOIN (starsystems s) ON s.system_id = p.system_id
            WHERE tcm.user_id = '.$game->player['user_id'].' AND
                  tcm.memo_view = 4';

    if(!$q_tcm = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query tactical coords memo data');
    }

    //$i = 0;
    while($tcm = $db->fetchrow($q_tcm)) {
        $from_script_string .= 'case "'.$i.'": document.rangefind.coord_from.value="'.($game->get_sector_name($tcm['sector_id']).':'.$game->get_system_cname($tcm['system_x'], $tcm['system_y'])).'"; break;';
        $to_script_string   .= 'case "'.$i.'": document.rangefind.coord_to.value="'.($game->get_sector_name($tcm['sector_id']).':'.$game->get_system_cname($tcm['system_x'], $tcm['system_y'])).'"; break;';        
        $tcm_html .= '<option value="'.$i.'">'.$tcm['memo_name'].'</option>';
        $i++;        
    }
    
    $has_cartography = (!empty($cartography_html));
    $has_own_planets = (!empty($own_planets_html));
    $has_tcm = (!empty($tcm_html));
    
    $game->out('
    <SCRIPT LANGUAGE="JavaScript">
    function SetFrom(destid)
    {
        switch(destid) {
        '.$from_script_string.'
        default:
        }
    }
    function SetTo(destid)
    {
        switch(destid) {
        '.$to_script_string.'
        default:
        }
    }    
    </SCRIPT>
    <form name="rangefind" method="post" action="'.parse_link('a=database&view=rangefinder').'">
    <table width=400" align="center" border="0" cellpadding="2" cellspacing="2" class="style_outer">
      <tr>
         <td align="center"><span class="sub_caption">'.constant($game->sprache("TEXT125")).'</span></td>
       </tr>
       <tr>
         <td>
           <table width="400" align="center" border="0" cellpadding="3" cellspacing="3" class="style_inner">
             <tr>
                <td>
                Sistema: '.((!empty($data_from['system_id'])) ? $game->get_sector_name($data_from['sector_id']).':'.$game->get_system_cname($data_from['system_x'], $data_from['system_y']) : 'Inserire coordinate ==> ').' <input type="text" class="field" name="coord_from" size="10">
                </td>
                <td>
                <select style="width: 130px;"'.( ($has_cartography || $has_own_planets || $has_tcm) ? ' onChange="if(this.value) SetFrom(this.value);"' : ' disabled="disabled"' ).'><option>'.constant($game->sprache("TEXT161")).'</option>'.( ( ($has_cartography) ? '<option>---------------------</option>'.$cartography_html : '' ).( ($has_own_planets) ? '<option>---------------------</option>'.$own_planets_html : '' ).( ($has_tcm) ? '<option>---------------------</option>'.$tcm_html : '' ) ).'</select>
                </td>    
             </tr>
             <tr>
                <td>
                Sistema: '.((!empty($data_to['system_id'])) ? $game->get_sector_name($data_to['sector_id']).':'.$game->get_system_cname($data_to['system_x'], $data_to['system_y']) : 'Inserire coordinate ==> ').' <input type="text" class="field" name="coord_to" size="10">
                </td>
                <td>
                <select style="width: 130px;"'.( ($has_cartography || $has_own_planets || $has_tcm) ? ' onChange="if(this.value) SetTo(this.value);"' : ' disabled="disabled"' ).'><option>'.constant($game->sprache("TEXT161")).'</option>'.( ( ($has_cartography) ? '<option>---------------------</option>'.$cartography_html : '' ).( ($has_own_planets) ? '<option>---------------------</option>'.$own_planets_html : '' ).( ($has_tcm) ? '<option>---------------------</option>'.$tcm_html : '' ) ).'</select>
                </td>                
             </tr>
             <tr>
                <td colspan=2 align="center">
                <input class="button" type="submit" value="Imposta">
                </td>
             </tr>
             <tr>
                <td colspan=2 align="center">'.$distance_html.'</td>
             </tr>
           </table>
         </td>
       </tr>
    </table>
    ');
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
