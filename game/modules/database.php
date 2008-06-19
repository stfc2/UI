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

$DATABASE_MODULES = array(
    'planets' => constant($game->sprache("TEXT11")),
    'security' => constant($game->sprache("TEXT12")),
//    'combatsim' => constant($game->sprache("TEXT13")),
//    'academy' => constant($game->sprache("TEXT14")),
    'faq' =>  constant($game->sprache("TEXT15")),
    'guide' => constant($game->sprache("TEXT16"))
);

$module = (!empty($_GET['view'])) ? $_GET['view'] : 'planets';
$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).' '.$RACE_DATA[$game->player['user_race']][0].'</span><br><br>'.display_view_navigation('database', $module, $DATABASE_MODULES).'<br><br>');

if($module == 'planets' || isset($_GET['planet_type']))
{

    foreach($PLANETS_TEXT as $type => $data) {
        $type = strtolower($type);

        if($type == strtolower($_GET['planet_type'])) {
            $high_start = '<span style="color: #FFFF00; font-weight: bold;">';
            $high_end = '</span>';
        }
        else {
            $high_start = $high_end = '';
        }

        $game->out('
<table width="450" align="center" border="0" cellpadding="3" cellspacing="3" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
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
    <td>'.$PLANETS_DATA[$type][7].'<br>'.constant($game->sprache("TEXT8")).'</td>
  </tr>
  <tr>
    <td valign="top"<u>'.constant($game->sprache("TEXT9")).'</u></td>
    <td>'.$PLANETS_DATA[$type][6].'<br>'.constant($game->sprache("TEXT10")).'</td>
  </tr>
  <tr>
    <td valign="top"><u>'.constant($game->sprache("TEXT4")).'</u></td>
    <td>'.$data[2].'</td>
  </tr>
  <tr>
    <td valign="top"><u>'.constant($game->sprache("TEXT5")).'</u></td>
    <td>'.$data[3].'</td>
  </tr>
  <tr>
    <td valign="top"><u>'.constant($game->sprache("TEXT6")).'</u></td>
    <td>'.$data[4].'</td>
  </tr>
  <tr>
  <td colspan="2" valign="top"><img src="'.FIXED_GFX_PATH.'planet_type_'.$type.'.png" border="0"></td>
  </tr>
  
</table>
<br>
        ');
    }
}
else if($module == 'security')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'combatsim')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'academy')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'faq')
{
    $game->out('<span class="caption">Working / In lavorazione');
}
else if($module == 'guide')
{
    $game->out('<span class="caption">Working / In lavorazione');
}


?>
