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


if(!empty($_POST['to_submit'])) {
    $db->lock('ship_fleets', 'ships', 'ship_templates');
    $game->init_player();
    
    if(empty($_GET['from'])) {
        message(GENERAL, constant($game->sprache("TEXT0")), '$_GET[\'from\'] = empty');
    }
    
    $from_fleet_id = (int)$_GET['from'];
    
    if(empty($_GET['to'])) {
        message(GENERAL, constant($game->sprache("TEXT0")), '$_GET[\'to\'] = empty');
    }

    $to_fleet_id = (int)$_GET['to'];

    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : 'a=ship_fleets_display&pfleet_details='.$from_fleet_id;

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE fleet_id IN ('.$from_fleet_id.', '.$to_fleet_id.')';

    if(($fleets = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }

    if($fleets[0]['fleet_id'] == $from_fleet_id) {
        $from_fleet = &$fleets[0];
        $to_fleet = &$fleets[1];
    }
    else {
        $from_fleet = &$fleets[1];
        $to_fleet = &$fleets[0];
    }

    if(empty($from_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if($from_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if(empty($to_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }
    
    if($to_fleet['user_id']!=$from_fleet['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    $own_to_fleet = ($to_fleet['user_id'] == $game->player['user_id']) ? true : false;

    $sql = 'SELECT COUNT(ships.ship_id) AS n_transporter
            FROM ships, ship_templates
            WHERE ships.fleet_id = '.$to_fleet_id.' AND
                  ship_templates.id = ships.template_id AND
                  ship_templates.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n2_transporter = $trpt_count['n_transporter'];
    
    if($n2_transporter == 0) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }

    $max2_resources = $n2_transporter * MAX_TRANSPORT_RESOURCES;
    $max2_units = $n2_transporter * MAX_TRANSPORT_UNITS;

    $n2_resources = ($to_fleet['resource_1'] + $to_fleet['resource_2'] + $to_fleet['resource_3']);
    $n2_units = ($to_fleet['resource_4'] + $to_fleet['unit_1'] + $to_fleet['unit_2'] + $to_fleet['unit_3'] + $to_fleet['unit_4'] + $to_fleet['unit_5'] + $to_fleet['unit_6']);
    
    $wares_names = get_wares_names();
    
    /*
     * ?nlich in ship_fleets_loadingp.php
     *
     * $f1wares -> Waren auf $from_fleet
     * $f2wares -> Waren auf $to_fleet
     * $nwares -> Waren, die bewegt werden sollen
     */
     
    foreach($wares_names as $key => $name) {
        $nwares[$key] = (!empty($_POST['add_'.$key])) ? abs((int)$_POST['add_'.$key]) : 0;
        $f1wares[$key] = (int)$from_fleet[$key];
        $f2wares[$key] = (int)$to_fleet[$key];
    }
    
    $fleet_overloaded = false;
    
    foreach($nwares as $key => $value) {
        $o_value = $value;
        
        if($value > $f1wares[$key]) {
            message(NOTICE, constant($game->sprache("TEXT5")).$value.' '.$wares_names[$key]);
        }

        if( ($key == 'resource_1') || ($key == 'resource_2') || ($key == 'resource_3') ) {
            if( ($n2_resources + $value) > $max2_resources) {
                $value = $max2_resources - $n2_resources;
                $fleet_overloaded = true;
            }
            
            $n2_resources += $value;
        }
        else {
            if( ($n2_units + $value) > $max2_units) {
                $value = $max2_units - $n2_units;
                $fleet_overloaded = true;
            }
            
            $n2_units += $value;
        }

        if($own_to_fleet) $f1wares[$key] -= $value;
        else $f1wares[$key] -= $o_value;
        
        $f2wares[$key] += $value;
    }
    
    $sql = 'UPDATE ship_fleets
            SET resource_1 = '.$f1wares['resource_1'].',
                resource_2 = '.$f1wares['resource_2'].',
                resource_3 = '.$f1wares['resource_3'].',
                resource_4 = '.$f1wares['resource_4'].',
                unit_1 = '.$f1wares['unit_1'].',
                unit_2 = '.$f1wares['unit_2'].',
                unit_3 = '.$f1wares['unit_3'].',
                unit_4 = '.$f1wares['unit_4'].',
                unit_5 = '.$f1wares['unit_5'].',
                unit_6 = '.$f1wares['unit_6'].'
            WHERE fleet_id = '.$from_fleet_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update fleets f1 wares data');
    }

    $sql = 'UPDATE ship_fleets
            SET resource_1 = '.$f2wares['resource_1'].',
                resource_2 = '.$f2wares['resource_2'].',
                resource_3 = '.$f2wares['resource_3'].',
                resource_4 = '.$f2wares['resource_4'].',
                unit_1 = '.$f2wares['unit_1'].',
                unit_2 = '.$f2wares['unit_2'].',
                unit_3 = '.$f2wares['unit_3'].',
                unit_4 = '.$f2wares['unit_4'].',
                unit_5 = '.$f2wares['unit_5'].',
                unit_6 = '.$f2wares['unit_6'].'
            WHERE fleet_id = '.$to_fleet_id;

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update fleets f2 wares data');
    }

    $db->unlock();

    if($fleet_overloaded && $own_to_fleet) {
        $game->init_player();
        $game->out('<center><span class="caption">'.constant($game->sprache("TEXT6")).'</span></center>');

        message(NOTICE, constant($game->sprache("TEXT7")).'<br><br><a href="'.parse_link($return_to).'">'.constant($game->sprache("TEXT8")).'</a>');
    }
    else {
        redirect($return_to);
    }
    
}
elseif(isset($_GET['to'])) {
    $game->init_player();
    
    $to_fleet_id = (!empty($_GET['to'])) ? (int)$_GET['to'] : (int)$_POST['to_fleet'];
    
    if(empty($to_fleet_id)) {
        message(GENERAL, constant($game->sprache("TEXT0")), '$to_fleet_id = empty');
    }

    $from_fleet_id = (!empty($_GET['from'])) ? (int)$_GET['from'] : (int)$_POST['fleets'][0];
    
    if(empty($from_fleet_id)) {
        message(GENERAL, constant($game->sprache("TEXT0")), '$from_fleet_id = empty');
    }
    
    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : 'a=ship_fleets_display&pfleet_details='.$from_fleet_id;

    $sql = 'SELECT *
            FROM ship_fleets
            WHERE fleet_id IN ('.$from_fleet_id.', '.$to_fleet_id.')';
            
    if(($fleets = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query fleets data');
    }
    
    if($fleets[0]['fleet_id'] == $from_fleet_id) {
        $from_fleet = &$fleets[0];
        $to_fleet = &$fleets[1];
    }
    else {
        $from_fleet = &$fleets[1];
        $to_fleet = &$fleets[0];
    }
    
    if($to_fleet['user_id']!=$from_fleet['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if(empty($from_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    if($from_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    if(empty($to_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }
    
    $own_to_fleet = ($to_fleet['user_id'] == $game->player['user_id']) ? true : false;
    
    $sql = 'SELECT COUNT(s.ship_id) AS n_transporter
            FROM (ships s, ship_templates st)
            WHERE s.fleet_id = '.$to_fleet_id.' AND
                  st.id = s.template_id AND
                  st.ship_torso = '.SHIP_TYPE_TRANSPORTER;

    if(($trpt_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query ships transporter data');
    }

    $n2_transporter = $trpt_count['n_transporter'];
    
    if($n2_transporter == 0) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }
    
    $max2_resources = $n2_transporter * MAX_TRANSPORT_RESOURCES;
    $max2_units = $n2_transporter * MAX_TRANSPORT_UNITS;
    
    $n2_resources = ($to_fleet['resource_1'] + $to_fleet['resource_2'] + $to_fleet['resource_3']);
    $n2_units = ($to_fleet['resource_4'] + $to_fleet['unit_1'] + $to_fleet['unit_2'] + $to_fleet['unit_3'] + $to_fleet['unit_4'] + $to_fleet['unit_5'] + $to_fleet['unit_6']);

    $game->out('
<script language="JavaScript" type="text/javascript">
<!--
function unload_all() {
    ');

    if($from_fleet['resource_1'] > 0) $game->out('document.load_form.add_resource_1.value = '.$from_fleet['resource_1'].';');
    if($from_fleet['resource_2'] > 0) $game->out('document.load_form.add_resource_2.value = '.$from_fleet['resource_2'].';');
    if($from_fleet['resource_3'] > 0) $game->out('document.load_form.add_resource_3.value = '.$from_fleet['resource_3'].';');
    if($from_fleet['resource_4'] > 0) $game->out('document.load_form.add_resource_4.value = '.$from_fleet['resource_4'].';');
    if($from_fleet['unit_1'] > 0) $game->out('document.load_form.add_unit_1.value = '.$from_fleet['unit_1'].';');
    if($from_fleet['unit_2'] > 0) $game->out('document.load_form.add_unit_2.value = '.$from_fleet['unit_2'].';');
    if($from_fleet['unit_3'] > 0) $game->out('document.load_form.add_unit_3.value = '.$from_fleet['unit_3'].';');
    if($from_fleet['unit_4'] > 0) $game->out('document.load_form.add_unit_4.value = '.$from_fleet['unit_4'].';');
    if($from_fleet['unit_5'] > 0) $game->out('document.load_form.add_unit_5.value = '.$from_fleet['unit_5'].';');
    if($from_fleet['unit_6'] > 0) $game->out('document.load_form.add_unit_6.value = '.$from_fleet['unit_6'].';');

    $game->out('

    return true;
}
//-->
</script>

<span class="caption">'.constant($game->sprache("TEXT6")).'</span><br><br>

<table class="style_outer" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td>
      <table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
        <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingf&from='.$from_fleet_id.'&to='.$to_fleet_id.( ($return_to) ? '&return_to='.urlencode($return_to) : '' ) ).'" onSubmit="return document.load_form.submit_button.disabled = true;">
        <input type="hidden" name="to_submit" value="1">
        <tr>
          <td align="center">
            '.constant($game->sprache("TEXT9")).' <a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$from_fleet_id).'"><b>'.$from_fleet['fleet_name'].'</b></a> '.constant($game->sprache("TEXT10")).' <a'.( ($to_fleet['user_id'] == $game->player['user_id']) ? ' href="'.parse_link('a=ship_fleets_display&pfleet_details='.$to_fleet_id).'"' : '' ).'><b>'.$to_fleet['fleet_name'].'</b></a>
            <br><br>
    ');

    if($own_to_fleet) {
        $game->out('
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td rowspan="5" width="140" valign="top">'.constant($game->sprache("TEXT11")).'</td>
                <td width="260"><i>'.constant($game->sprache("TEXT12")).'</i>: <b>'.($max2_resources - $n2_resources).'</b></td>
              </tr>
              <tr><td><i>'.constant($game->sprache("TEXT13")).'</i>: <b>'.($max2_units - $n2_units).'</b></td></tr>
            </table>
            <br>
        ');
    }

    $game->out('
            <table width="400" border="0" cellpadding="1" cellspacing="0">
              <tr>
                <td width="80">&nbsp;</td>
                <td width="240" align="center"><b>'.constant($game->sprache("TEXT14")).'</b></td>
                <td width="80" align="center">[<a href="javascript:void(0);" onClick="return unload_all();">'.constant($game->sprache("TEXT15")).'</a>]</td>
              </tr>
    ');

    if($from_fleet['resource_1'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT16")).'</td>
                <td align="center">'.$from_fleet['resource_1'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_1" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['resource_2'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT17")).'</td>
                <td align="center">'.$from_fleet['resource_2'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_2" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['resource_3'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT18")).'</td>
                <td align="center">'.$from_fleet['resource_3'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_3" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['resource_4'] > 0) {
        $game->out('
              <tr>
                <td>'.constant($game->sprache("TEXT19")).'</td>
                <td align="center">'.$from_fleet['resource_4'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_resource_4" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_1'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][0].'</td>
                <td align="center">'.$from_fleet['unit_1'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_1" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_2'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][1].'</td>
                <td align="center">'.$from_fleet['unit_2'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_2" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_3'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][2].'</td>
                <td align="center">'.$from_fleet['unit_3'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_3" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_4'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][3].'</td>
                <td align="center">'.$from_fleet['unit_4'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_4" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_5'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][4].'</td>
                <td align="center">'.$from_fleet['unit_5'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_5" value=""></td>
              </tr>
        ');
    }

    if($from_fleet['unit_6'] > 0) {
        $game->out('
              <tr>
                <td>'.$UNIT_NAME[$game->player['user_race']][5].'</td>
                <td align="center">'.$from_fleet['unit_6'].'</td>
                <td align="center"><input style="width: 60px;" class="field" type="text" name="add_unit_6" value=""></td>
              </tr>
        ');
    }

    $game->out('
            </table>
            <br>
            <input class="button" type="button" name="cancel" value="'.constant($game->sprache("TEXT20")).'" onClick="return window.location.href = \''.parse_link($return_to).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="'.constant($game->sprache("TEXT21")).'">
          </td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
elseif(!empty($_GET['to_unit'])) {
    $game->init_player();
    
    $to_user_id = (int)$_GET['to_unit'];
    $to_user_name = $game->uc_get($to_user_id);

    if(!$to_user_name) {
        message(NOTICE, constant($game->sprache("TEXT22")));
    }

    $from_fleet_id = (!empty($_GET['from'])) ? (int)$_GET['from'] : (int)$_POST['fleets'][0];

    if(empty($from_fleet_id)) {
        message(NOTICE, constant($game->sprache("TEXT23")));
    }

    $return_to = (!empty($_GET['return_to'])) ? deparse_sql(urldecode($_GET['return_to'])) : 'a=ship_fleets_display&pfleet_details='.$from_fleet_id;
    
    $sql = 'SELECT fleet_id, fleet_name, user_id, planet_id
            FROM ship_fleets
            WHERE fleet_id = '.$from_fleet_id;
            
    if(($from_fleet = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query from fleets data');
    }
            
    if(empty($from_fleet['fleet_id'])) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }

    if($from_fleet['user_id'] != $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    $planet_id = $from_fleet['planet_id'];
    
    $sql = 'SELECT fleet_id, fleet_name, n_ships
            FROM ship_fleets
            WHERE planet_id = '.$planet_id.' AND
                  user_id = '.$to_user_id;
                  
    if(!$q_fleets = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query to fleets data');
    }
    
    if($db->num_rows($q_fleets) == 0) {
        message(NOTICE, constant($game->sprache("TEXT24")));
    }
    
    $first_fleet = $db->fetchrow($q_fleets);
    
    $game->out('
<span class="caption">'.constant($game->sprache("TEXT6")).'</span><br><br>

<table class="style_outer" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td>
      <table class="style_inner" width="400" align="center" border="0" cellpadding="2" cellspacing="2">
        <form name="load_form" method="post" action="'.parse_link('a=ship_fleets_loadingf&from='.$from_fleet_id.'&to'.( ($return_to) ? '&return_to='.urlencode($return_to) : '' ) ).'">
        <tr>
          <td align="center">
            '.constant($game->sprache("TEXT9")).' <a href="'.parse_link('a=ship_fleets_display&pfleet_details='.$from_fleet_id).'"><b>'.$from_fleet['fleet_name'].'</b></a>
            <br><br>
            '.constant($game->sprache("TEXT25")).' <a href="'.parse_link('a=stats&a2=viewplayer&id='.$to_user_id).'"><b>'.$to_user_name.'</b></a> '.constant($game->sprache("TEXT26")).'
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="30"><input type="radio" name="to_fleet" value="'.$first_fleet['fleet_id'].'" checked="checked"></td>
                <td width="200"><b>'.$first_fleet['fleet_name'].'</b> ('.$first_fleet['n_ships'].' '.constant($game->sprache("TEXT27")).')</td>
              </tr>
    ');
    
    while($fleet = $db->fetchrow($q_fleets)) {
        $game->out('
              <tr>
                <td><input type="radio" name="to_fleet" value="'.$fleet['fleet_id'].'" checked="checked"></td>
                <td><b>'.$fleet['fleet_name'].'</b> ('.$fleet['n_ships'].' '.constant($game->sprache("TEXT27")).')</td>
              </tr>
        ');
    }
    
    $game->out('
            </table>
            <br>
            <input class="button" type="button" name="cancel" value="'.constant($game->sprache("TEXT20")).'" onClick="return window.location.href = \''.parse_link($return_to).'\'">&nbsp;&nbsp;<input class="button" type="submit" name="submit_button" value="'.constant($game->sprache("TEXT28")).'">
          </td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
    ');
}
else {
    redirect('a=ship_fleets_display');
}

?>
