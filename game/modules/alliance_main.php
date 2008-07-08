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

function timeformat($seconds)
{
$days=0;
$hours=0;
while($seconds>=60*60*24) {$days++; $seconds-=60*60*24;}
while($seconds>=60*60) {$hours++; $seconds-=60*60;}
return ($days.'d '.$hours.'h');
}


// Checks whether the player is member or not of an alliance
//   $requirement == true -> the player must be in an alliance
//   $requirement == false -> the player must NOT be in an alliance
function check_membership($requirement) {
    global $game;
    
    $in_alliance = (!empty($game->player['alliance_name'])) ? true : false;
    
    if($in_alliance && !$requirement) {
        message(NOTICE, constant($game->sprache("TEXT0")));
    }
    
    if(!$in_alliance && $requirement) {
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    return true;
}


$game->init_player();
$game->out('<span class="caption">'.constant($game->sprache("TEXT2")).'</span><br><br>');
   
 $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance_rights = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

if(isset($_GET['member_list'])) {
    check_membership(true);

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }
    
    $sql = 'SELECT user_id, user_name, user_race, user_points, user_planets, user_alliance_status, last_active, user_vacation_end
            FROM user
            WHERE user_alliance = '.$game->player['user_alliance'].'
            ORDER BY user_points DESC';
            
    if(!$q_user = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query alliance user data');
    }
    
    if($db->num_rows() == 0) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    $member_status = array(
        ALLIANCE_STATUS_MEMBER => '%s',
        ALLIANCE_STATUS_ADMIN => '<span style="color: #FFFF00; font-weight: bold;">%s</span>',
        ALLIANCE_STATUS_OWNER => '<span style="color: #FF0000; font-weight: bold;">%s</span>',
        ALLIANCE_STATUS_DIPLO => '<span style="color: #FFA500; font-weight: bold;">%s</span>'
    );

    if($_GET['member_list']>0 && $_GET['member_list']<3) $game->option_store('alliance_status_member',(int)$_GET['member_list']);

    // Racial distribution

    for ($t=0; $t<12; $t++)
    {
    $r_tmp = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_race='.$t.' AND user_alliance = '.$game->player['user_alliance']);
    $race['racecount_'.$t]=$r_tmp['num'];
    }

    $t_percent = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE user_alliance = '.$game->player['user_alliance']);


    for ($t=0; $t<12; $t++)
    {
    $race['racepercent_'.$t]=round(100/($t_percent['num'])*$race['racecount_'.$t],0);
    }
    // Racial distribution end


    $game->out('

<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$alliance['alliance_name'].' ['.$alliance['alliance_tag'].']</span><br><br><br>
      <table width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="175" align="left"><i>'.constant($game->sprache("TEXT4")).'</i></td><td width="175" align="right">'.( ($game->player['user_alliance_rights8'] == 1) ? '[<a href="'.( ($game->option_retr('alliance_status_member')==1) ? ''.parse_link('a=alliance_main&member_list=2').'' : ''.parse_link('a=alliance_main&member_list=1').'' ).'">'.constant($game->sprache("TEXT5")).'</a>]</td></tr>' : '' ).'
      </table>
   ');

    if($game->player['user_alliance_rights8'] == 1) {
        $game->out('
      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <form name="mlist_form" method="post" action="'.parse_link('a=alliance_admin').'">
        <tr>
          
          <td width="30">&nbsp;</td>
          <td width="140"><b>'.constant($game->sprache("TEXT6")).'</b></td>
          <td width="70"><b>'.constant($game->sprache("TEXT7")).'</b></td>
          <td width="70"><b>'.constant($game->sprache("TEXT8")).'</b></td>
          <td width="60"><b>'.constant($game->sprache("TEXT9")).'</b></td>
          '.( ($game->option_retr('alliance_status_member')==1) ? '<td width="50"><b>'.constant($game->sprache("TEXT10")).'</b></td>' : '<td width="50"><b>'.constant($game->sprache("TEXT11")).'</b></td>' ).'
        </tr>
        ');
         
        while($user = $db->fetchrow($q_user)) {

        switch($user['user_race']) {
 
        case 0:
        $user_race = constant($game->sprache("TEXT12"));
        break;
 
        case 1:
        $user_race = constant($game->sprache("TEXT13"));
        break;

        case '2':
        $user_race = constant($game->sprache("TEXT14"));
        break;

        case '3':
        $user_race = constant($game->sprache("TEXT15"));
        break;

        case '4':
        $user_race = constant($game->sprache("TEXT16"));
        break;

        case '5':
        $user_race = constant($game->sprache("TEXT17"));
        break;

        case '8':
        $user_race = constant($game->sprache("TEXT18"));
        break;

        case '9':
        $user_race = constant($game->sprache("TEXT19"));
        break;

        case '10':
        $user_race = constant($game->sprache("TEXT20"));
        break;

        case '11':
        $user_race = constant($game->sprache("TEXT21"));
        break;

        default:
        $user_race = constant($game->sprache("TEXT22"));
        break;

        }

        if ($user['last_active']>(time()-60*3)) $stats_str='<span style="color: green">'.constant($game->sprache("TEXT23")).'</span>';
	    else if ($user['last_active']>(time()-60*9)) $stats_str='<span style="color: orange">'.constant($game->sprache("TEXT24")).'</span>';
            else $stats_str='<span style="color: red">'.constant($game->sprache("TEXT25")).'</span>';

            $game->out('
        <tr>
          <td width="30"><input type="radio" name="user_id" value="'.$user['user_id'].'"'.( ($user['user_id'] == $alliance['alliance_owner']) ? ' disabled="disabled"' : '' ).'></td>
          <td width="190"><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user['user_id']).'">'.sprintf($member_status[$user['user_alliance_status']], $user['user_name']).'</a></td>
          <td width="70">'.$user_race.'</td>
          <td width="70">'.$user['user_planets'].'</td>
          <td width="80">'.$user['user_points'].'</td>
          '.( ($game->option_retr('alliance_status_member')==1) ? '<td width="80">'.(($user['user_vacation_end']<$ACTUAL_TICK) ? timeformat(time()-$user['last_active']) : constant($game->sprache("TEXT85"))).'</td>' : '<td width="80"><b>'.$stats_str.'<b></td>' ).'
        </tr>
            ');
        }
         
     $game->out('
      </table>
      <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="5"><td></td></tr>
        <tr><!--<td align="left">
          <input class="button" type="submit" name="status_change_fin" value="'.constant($game->sprache("TEXT26")).'"></td>!-->
	   <td><input class="button" type="submit" name="status_change_diplo" value="'.constant($game->sprache("TEXT27")).'"></td>
          <td align="left">
          <input class="button" type="submit" name="status_change" value="'.constant($game->sprache("TEXT28")).'">

        </td>
       </tr>
        
        <!--<tr height="5"><td></td></tr>
	 <tr><td align="left">
          <input class="button" type="submit" name="status_change" value="'.constant($game->sprache("TEXT28")).'">

        </td></tr>!-->
        ');
        
        if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
            $game->out('
         <tr height="5"><td></td></tr>
         <tr><td align="left">
           <input class="button" type="submit" name="owner_change" value="'.constant($game->sprache("TEXT29")).'">
         </td></tr>
            '); 
        }
        
        $game->out('</form></table>');
    }
    else {
        $game->out('
      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="210"><b>'.constant($game->sprache("TEXT6")).'</b></td>
          <td width="70"><b>'.constant($game->sprache("TEXT7")).'</b></td> 
          <td width="70"><b>'.constant($game->sprache("TEXT8")).'</b></td>
          <td width="60"><b>'.constant($game->sprache("TEXT9")).'</b></td>
          <td width="50"><b>'.constant($game->sprache("TEXT11")).'</b></td>
        </tr>
        ');

        while($user = $db->fetchrow($q_user)) {

        switch($user['user_race']) {
 
        case 0:
        $user_race = constant($game->sprache("TEXT12"));
        break;
 
        case 1:
        $user_race = constant($game->sprache("TEXT13"));
        break;

        case '2':
        $user_race = constant($game->sprache("TEXT14"));
        break;

        case '3':
        $user_race = constant($game->sprache("TEXT15"));
        break;

        case '4':
        $user_race = constant($game->sprache("TEXT16"));
        break;

        case '5':
        $user_race = constant($game->sprache("TEXT17"));
        break;

        case '8':
        $user_race = constant($game->sprache("TEXT18"));
        break;

        case '9':
        $user_race = constant($game->sprache("TEXT19"));
        break;

        case '10':
        $user_race = constant($game->sprache("TEXT20"));
        break;

        case '11':
        $user_race = constant($game->sprache("TEXT21"));
        break;

        default:
        $user_race = constant($game->sprache("TEXT22"));
        break;

        }

        if ($user['last_active']>(time()-60*3)) $stats_str='<span style="color: green">'.constant($game->sprache("TEXT23")).'</span>';
	    else if ($user['last_active']>(time()-60*9)) $stats_str='<span style="color: orange">'.constant($game->sprache("TEXT24")).'</span>';
            else $stats_str='<span style="color: red">'.constant($game->sprache("TEXT25")).'</span>';

            $game->out('
        <tr>
          <td width="210"><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user['user_id']).'">'.sprintf($member_status[$user['user_alliance_status']], $user['user_name']).'</a></td>
          <td width="70">'.$user_race.'</td>
          <td width="70">'.$user['user_planets'].'</td>
          <td width="80">'.$user['user_points'].'</td>
          <td width="50">'.$stats_str.'</td>
        </tr>
            ');
        }

        $game->out('</table>');
    }

    $game->out('<table width="350" align="center" border="0" cellpadding="2" cellspacing="2"><tr><td>&nbsp;</td></tr>
        <tr><td width="350" align="left"><i>'.constant($game->sprache("TEXT30")).'</i></td><td width="175" align="right">&nbsp;</td></tr>
        </table>
        <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">

                <td width="130" class="desc_row">'.constant($game->sprache("TEXT31")).'</td>
                <td width="140" class="value_row">'.$race['racecount_0'].' ('.$race['racepercent_0'].'%)</td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT32")).'</td>
                <td class="value_row">'.$race['racecount_1'].' ('.$race['racepercent_1'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT33")).'</td>
                <td class="value_row">'.$race['racecount_2'].' ('.$race['racepercent_2'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT34")).'</td>
                <td class="value_row">'.$race['racecount_3'].' ('.$race['racepercent_3'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT35")).'</td>
                <td class="value_row">'.$race['racecount_4'].' ('.$race['racepercent_4'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT36")).'</td>
                <td class="value_row">'.$race['racecount_5'].' ('.$race['racepercent_5'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT37")).'</td>
                <td class="value_row">'.$race['racecount_8'].' ('.$race['racepercent_8'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT38")).'</td>
                <td class="value_row">'.$race['racecount_9'].' ('.$race['racepercent_9'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT39")).'</td>
                <td class="value_row">'.$race['racecount_10'].' ('.$race['racepercent_10'].'%)</b></td>
              </tr>
              <tr>
              <tr>
                <td class="desc_row">'.constant($game->sprache("TEXT40")).'</td>
                <td class="value_row">'.$race['racecount_11'].' ('.$race['racepercent_11'].'%)</b></td>
              </tr>
        </table>
    </td>
  </tr> 
</table>
<br>
<i>'.constant($game->sprache("TEXT41")).'</i>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);">'.constant($game->sprache("TEXT42")).'</a>&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_FINANZ], constant($game->sprache("TEXT43"))).'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_DIPLO], constant($game->sprache("TEXT44"))).'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_ADMIN], constant($game->sprache("TEXT45"))).'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_OWNER], constant($game->sprache("TEXT46"))).'
<br>
    ');
}

elseif(!empty($_POST['leave_confirm'])) {
    check_membership(true);
    
    if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT47")));
    }
    
    $sql = 'UPDATE user
            SET user_alliance = 0,
                user_alliance_status = 0,
                user_alliance_rights1 = 0,
                user_alliance_rights2 = 0,
                user_alliance_rights3 = 0,
                user_alliance_rights4 = 0,
                user_alliance_rights5 = 0,
                user_alliance_rights6 = 0,
                user_alliance_rights7 = 0,
                user_alliance_rights8 = 0
            WHERE user_id = '.$game->player['user_id'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance data');
    }
// DC ----
    $sql = 'UPDATE userally_history SET leave_date = '.time().' WHERE user_id = '.$game->player['user_id'].' AND alliance_id = '.$game->player['user_alliance'];
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update userally_history data');
    }
// DC ----
    alliance_log('<font color=green>'.$game->player['user_name'].'</font> '.constant($game->sprache("TEXT48")));
    
    $sql = 'UPDATE alliance
            SET alliance_points = alliance_points - '.$game->player['user_points'].',
                alliance_planets = alliance_planets - '.$game->player['user_planets'].',
                alliance_honor = alliance_honor - '.$game->player['user_honor'].'
            WHERE alliance_id = '.$game->player['user_alliance'];

           
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance data');
    }
	
    redirect('a=alliance_main');
}
elseif(isset($_GET['leave'])) {
    check_membership(true);
    
    if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT47")));
    }

    $game->out('
<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_main').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      '.constant($game->sprache("TEXT49")).'<br><br>
      <input class="button" type="button" value="'.constant($game->sprache("TEXT50")).'" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="leave_confirm" value="'.constant($game->sprache("TEXT51")).'">
    </td>
  </tr>
  <tr height="5"><td></td></tr>
  </form>
</table>
    ');
}
elseif(isset($_GET['new'])) {
    check_membership(false);
    
	$alliance_name = addslashes($_POST['alliance_name']);
	
	if(empty($alliance_name)) {
		message(NOTICE, constant($game->sprache("TEXT52")));
	}
	
	$alliance_tag = addslashes($_POST['alliance_tag']);
	
	if(empty($alliance_tag)) {
		message(NOTICE, constant($game->sprache("TEXT53")));
	}
	
	$sql = 'SELECT alliance_id
	        FROM alliance
	        WHERE alliance_tag = "'.$alliance_tag.'" OR
               alliance_name = "'.$alliance_name.'"';
	              
    if(($ally_exists = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance name/tag data');
    }
    
    if(!empty($ally_exists['alliance_id'])) {
        message(NOTICE, constant($game->sprache("TEXT54")));
    }
	
    // Password entry removed

	$sql = 'INSERT INTO alliance (alliance_name, alliance_tag, alliance_owner, alliance_text, alliance_logo, alliance_homepage, alliance_points, alliance_planets, alliance_honor)
			VALUES ("'.$alliance_name.'", "'.$alliance_tag.'", "'.$game->player['user_id'].'", "", "", "", '.$game->player['user_points'].', '.$game->player['user_planets'].', '.$game->player['user_honor'].')';
			
    if(!$db->query($sql)) {
    	message(DATABASE_ERROR, 'Could not insert new alliance data');
    }
    	
    
	$new_alliance_id = $db->insert_id();
    	alliance_log('<font color=green>'.$game->player['user_name'].'</font> '.constant($game->sprache("TEXT55")).' <font color=red>'.$alliance_name.' ['.$alliance_tag.']</font> '.constant($game->sprache("TEXT56")),0,$new_alliance_id);
    
    $sql = 'UPDATE user
			SET user_alliance = '.$new_alliance_id.',
				user_alliance_status = '.ALLIANCE_STATUS_OWNER.',
                           user_alliance_rights1 = 1,
                user_alliance_rights2 = 1,
                user_alliance_rights3 = 1,
                user_alliance_rights4 = 1,
                user_alliance_rights5 = 1,
                user_alliance_rights6 = 1,
                user_alliance_rights7 = 1,
                user_alliance_rights8 = 1
			WHERE user_id = '.$game->player['user_id'];
			
    if(!$db->query($sql)) {
    	message(DATABASE_ERROR, 'Could not update user alliance data');
    }
    
// DC ---- We have a nice table to use, let's do it
	$sql = 'INSERT INTO userally_history (user_id, alliance_id, join_date)'
		. 'VALUES ('.$game->player['user_id'].', '.$new_alliance_id.', '.time().')';
	if(!$db->query($sql)) {
		message(DATABASE_ERROR, 'Could not update userally_history data');
    }	
// DC ----

    redirect('a=alliance_main');
}

// No action, also examine whether the player is in an alliance or not
elseif(!empty($game->player['alliance_name'])) {
    $sql = 'SELECT a.*,
                   COUNT(u.user_id) AS member_count
            FROM (alliance a), (user u)
            WHERE a.alliance_id = '.$game->player['user_alliance'].' AND
                  u.user_alliance = '.$game->player['user_alliance'].'
            GROUP BY alliance_id';
            
    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

    $member_status = array(
        ALLIANCE_STATUS_MEMBER => '<span style="color: #00FF00;">'.constant($game->sprache("TEXT42")).'</span>',
        ALLIANCE_STATUS_ADMIN => '<span style="color: #FFFF00;">'.constant($game->sprache("TEXT45")).'</span>',
        ALLIANCE_STATUS_OWNER => '<span style="color: #FF0000;">'.constant($game->sprache("TEXT46")).'</span>',
        ALLIANCE_STATUS_DIPLO => '<span style="color: #FFA500;">'.constant($game->sprache("TEXT44")).'</span>'
    );

	/* 21/05/08 - AC: Check alliance homepage URL */
	$http_ok = stripos($alliance['alliance_homepage'], "http://");
	if($http_ok === true)
		$alliance_url = $alliance['alliance_homepage'];
	else
		$alliance_url = 'http://'.$alliance['alliance_homepage'];
	/* */

    $game->out('
<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$alliance['alliance_name'].' ['.$alliance['alliance_tag'].']</span><br><br>
      '.( (!empty($alliance['alliance_logo'])) ? '<img src="'.$alliance['alliance_logo'].'"><br><br>' : '' ).'<br>
      
      <table class="style_inner" width="200" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100">'.constant($game->sprache("TEXT11")).'</td>
          <td width="100">'.$member_status[$game->player['user_alliance_status']].'</td>
        </tr>
      </table>
      <br>
      <table class="style_inner" width="200" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100">'.constant($game->sprache("TEXT57")).'</td>
          <td width="100"><b>'.$alliance['member_count'].'</b></td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT9")).':</td>
          <td width="100"><b>'.$alliance['alliance_points'].'</b></td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT8")).':</td>
          <td width="100"><b>'.$alliance['alliance_planets'].'</b></td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT58")).'</td>
          <td width="100"><b>'.$alliance['alliance_honor'].'</b></td>
        </tr>
        <tr>
          <td width="100">&nbsp;</td>
          <td width="100">&nbsp;</td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT59")).'</td>
          <td width="100"><b>'.$alliance['alliance_rank_points'].'</b></td>
        </tr>
        <tr>
          <td width="100">'.constant($game->sprache("TEXT60")).'</td>
          <td width="100"><b>'.$alliance['alliance_rank_points_avg'].'</b></td>
        </tr>
        <tr>
          <td width="100">&nbsp;</td>
          <td width="100">&nbsp;</td>
        </tr>
        <tr>
          <td width="100">Homepage:</td>
          <td width="100"><a href="'.$alliance_url.'">'.$alliance['alliance_homepage'].'</a></td>
        </tr>
        <tr>
          <td width="100">IRC:</td>
          <td width="100">'.$alliance['alliance_irc'].'</td>
        </tr>  
      </table>
      <br>
      <table class="style_inner" width="200" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="200">
            <a href="'.parse_link('a=alliance_main&member_list').'">'.constant($game->sprache("TEXT4")).'</a><br>
            <a href="'.parse_link('a=alliance_attack').'">'.constant($game->sprache("TEXT61")).'</a><br>
            <a href="alliancemap.php?alliance='.$alliance['alliance_tag'].'&size=6&map" target=_blank>'.constant($game->sprache("TEXT62")).'</a><br>
            <a href="'.parse_link('a=alliance_ships').'">'.constant($game->sprache("TEXT83")).'</a><br>
            <a href="'.parse_link('a=alliance_diplomacy').'">'.constant($game->sprache("TEXT63")).'</a><br>
            <a href="'.parse_link('a=alliance_taxes').'">'.constant($game->sprache("TEXT64")).'</a><br><br>
            <a href="'.parse_link('a=alliance_board').'">'.constant($game->sprache("TEXT65")).'</a><br>
    ');
	
    if($game->player['user_alliance_rights7']==1) { 
        $game->out(' 

            <a href="'.parse_link('a=alliance_chat').'">'.constant($game->sprache("TEXT84")).'</a><br><br> '); 
	}
	else { $game->out('<br>'); }

    if($game->player['user_alliance_rights1']==1) { 
    
    $game->out('

            <a href="'.parse_link('a=alliance_admin&settings').'">'.constant($game->sprache("TEXT66")).'</a><br> '); 
    } 
    //else { $game->out('<br>'); }


    $sql = 'SELECT application_id FROM alliance_application WHERE application_alliance = '.$game->player['user_alliance'];

    if(($new_app = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    } 

    
    if($game->player['user_alliance_rights6']==1) { 

      if(!empty($new_app['application_id'])) {
            $game->out('<a href="'.parse_link('a=alliance_application&application=admin').'"><span style="color: #FFFF00;"><b>'.constant($game->sprache("TEXT67")).'</b></span></a><br>');

      }
      else { $game->out('
            <a href="'.parse_link('a=alliance_application&application=admin').'">'.constant($game->sprache("TEXT67")).'</a><br>
	    
         '); }
    } 
    //else { $game->out('<br>'); }
    
    if($game->player['user_alliance_rights8']==1) {
     
    $game->out('<a href="'.parse_link('a=alliance_rights').'">'.constant($game->sprache("TEXT68")).'</a></br>');
    } 
    //else { $game->out('<br>'); 

    if($game->player['user_alliance_rights4']==1) {   
    $game->out('<a href="'.parse_link('a=alliance_massmail').'">'.constant($game->sprache("TEXT69")).'</a>');
    }
   // else { $game->out('<br>'); }
    
    if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
        $game->out('<br><br><a href="'.parse_link('a=alliance_admin&delete').'">'.constant($game->sprache("TEXT70")).'</a>');
    }
    else {
        $game->out('<br><br><a href="'.parse_link('a=alliance_main&leave').'">'.constant($game->sprache("TEXT71")).'</a>');
    }
    
    $game->out('
          </td>
        </tr>
      </table>
      <br>');
      
      $game->out('<br><table class="style_inner" width="330" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="330"><b>'.constant($game->sprache("TEXT72")).' '.(!isset($_GET['all_logs']) ? '[<a href="'.parse_link('a=alliance_main&all_logs').'">'.constant($game->sprache("TEXT73")).'</a>]' : '').':</b><br><br>');
	  
	  
    $log_qry=$db->query('SELECT * FROM alliance_logs WHERE alliance='.$game->player['user_alliance'].' AND permission<='.$game->player['user_alliance_status'].' ORDER BY id DESC '.(!isset($_GET['all_logs']) ? 'LIMIT 5' : ''));  
    while (($log=$db->fetchrow($log_qry))==true)
    {
    $game->out('<table border=0 cellpadding=0 cellspacing=0><tr><td width=80>'.date('d.m.y H:i',$log['timestamp']).'</td><td width=250>'.stripslashes($log['message']).'</td></tr></table>');
    };
	
	  
    $game->out('	  
	  </td>
        </tr>
      </table>');
      
           
      
$game->out('     
      <br>
      <table class="style_inner" width="330" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="330"><b>'.constant($game->sprache("TEXT74")).'</b><br><br>'.stripslashes($alliance['alliance_text']).'</td>
        </tr>
      </table>

    </td>
  </tr>
</table>
    ');
}
// Seems as if the player does not belong to any alliance
else {
	$game->out('
<table width="520" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="252" align="center" valign="top">
	  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
	    <form method="post" action="'.parse_link('a=alliance_main&new').'">
		<tr>
		  <td colspan="2"><b>'.constant($game->sprache("TEXT75")).'</b><br></td>
		</tr>
		<tr>
		  <td width="120">'.constant($game->sprache("TEXT76")).'</td>
		  <td width="130"><input class="field" type="text" name="alliance_name"></td>
		</tr>
		<tr>
		  <td width="120">'.constant($game->sprache("TEXT77")).'</td>
		  <td width="130"><input class="field" type="text" name="alliance_tag" maxlength="6" size="10"></td>
		</tr>
		<tr>
		  <td colspan="2" align="center"><input class="button" type="submit" name="new_submit" value="'.constant($game->sprache("TEXT51")).'"></td>
		</tr>
		</form>
	  </table>
	</td>
	</tr>
	 
	<tr>
          <td>&nbsp;</td>
        </tr>
	<tr>
          <td align="center"><b>'.constant($game->sprache("TEXT82")).'</b></td>
        </tr>
	<tr>
          <td>&nbsp;</td>
        </tr>
	
	<tr>  
	
       ');


       $sql = 'SELECT * FROM alliance_application WHERE application_user = '.$game->player['user_id'];
   
       if(($application_check = $db->queryrow($sql)) === false) {
         message(DATABASE_ERROR, 'Could not query application_check');
       }


       if(empty($application_check['application_id'])) {


  $game->out('

	<td width="252" align="center" valign="top">
	  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
         <tr>
		  <td colspan="2"><b>'.constant($game->sprache("TEXT78")).'</b><br></td>

	<tr>
	</tr>


	<tr>
	  <td colspan="2" align="center">[<a href="'.parse_link('a=alliance_application&list').'">'.constant($game->sprache("TEXT79")).'</a>]</td>
	</tr>

       ');

        }
        else { 

        $game->out('

	<td width="252" align="center" valign="top">
	  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
         <tr>
		  <td colspan="2"><b>'.constant($game->sprache("TEXT78")).'</b><br></td>

	<tr>
	</tr>

       <tr>
         <td align="center">'.constant($game->sprache("TEXT80")).'<br> <span style="color: green; font-weight: bold;">'.get_alliance_name($application_check['application_alliance']).'</span></td>
       </tr>  

       <tr>
         <td>&nbsp;</td>
       </tr>  

       <tr>
	  <td colspan="2" align="center">[<a href="'.parse_link('a=alliance_application&surdelete=1').'">'.constant($game->sprache("TEXT81")).'</a>]</td>
	</tr> 

       ');

        }

       $game->out('

	 </tr>
	  </table>
	</td>
  </tr>
</table>
	');
}

?>
