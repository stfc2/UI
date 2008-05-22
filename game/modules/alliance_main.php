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


// Überprüft, ob der Spieler Mitglied/kein Mitglied einer Allianz ist
//   $requirement == true -> der Spieler muss in einer Allianz sein
//   $requirement == false -> der Spieler darf NICHT in einer Allianz sein
function check_membership($requirement) {
    global $game;
    
    $in_alliance = (!empty($game->player['alliance_name'])) ? true : false;
    
    if($in_alliance && !$requirement) {
        message(NOTICE, 'Du bist bereits Mitglied in einer Allianz');
    }
    
    if(!$in_alliance && $requirement) {
        message(NOTICE, 'Du bist nicht Mitglied einer Allianz');
    }
    
    return true;
}


$game->init_player();
$game->out('<center><span class="caption">Allianz:</span><br><br>');
   
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
        message(NOTICE, 'Es konnten keine Allianz-Mitglieder gefunden werden (das sollte eigentlich NICHT passieren!)');
    }

    $member_status = array(
        ALLIANCE_STATUS_MEMBER => '%s',
        ALLIANCE_STATUS_ADMIN => '<span style="color: #FFFF00; font-weight: bold;">%s</span>',
        ALLIANCE_STATUS_OWNER => '<span style="color: #FF0000; font-weight: bold;">%s</span>',
        ALLIANCE_STATUS_DIPLO => '<span style="color: #FFA500; font-weight: bold;">%s</span>'
    );

    if($_GET['member_list']>0 && $_GET['member_list']<3) $game->option_store('alliance_status_member',(int)$_GET['member_list']);

    // Rassenverteilung

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
    // Rassenverteilung Ende


    $game->out('

<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$alliance['alliance_name'].' ['.$alliance['alliance_tag'].']</span><br><br><br>
      <table width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="175" align="left"><i>Mitgliederliste</i></td><td width="175" align="right">'.( ($game->player['user_alliance_rights8'] == 1) ? '[<a href="'.( ($game->option_retr('alliance_status_member')==1) ? ''.parse_link('a=alliance_main&member_list=2').'' : ''.parse_link('a=alliance_main&member_list=1').'' ).'">Statusanzeige switchen</a>]</td></tr>' : '' ).'
      </table>
   ');

    if($game->player['user_alliance_rights8'] == 1) {
        $game->out('
      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <form name="mlist_form" method="post" action="'.parse_link('a=alliance_admin').'">
        <tr>
          
          <td width="30">&nbsp;</td>
          <td width="140"><b>Name</b></td>
          <td width="70"><b>Rasse</b></td>
          <td width="70"><b>Planeten</b></td>
          <td width="60"><b>Punkte</b></td>
          '.( ($game->option_retr('alliance_status_member')==1) ? '<td width="50"><b>Inaktiv</b></td>' : '<td width="50"><b>Status</b></td>' ).'
        </tr>
        ');
         
        while($user = $db->fetchrow($q_user)) {

        switch($user['user_race']) {
 
        case 0:
        $user_race = 'Föd';
        break;       
 
        case 1:
        $user_race = 'Rom';
        break;  

        case '2':
        $user_race = 'Kli';
        break;  

        case '3':
        $user_race = 'Car';
        break;  

        case '4':
        $user_race = 'Dom';
        break;  

        case '5':
        $user_race = 'Fer';
        break;  

        case '8':
        $user_race = 'Bre';
        break;  

        case '9':
        $user_race = 'Hir';
        break;  

        case '10':
        $user_race = 'Kre';
        break; 

        case '11':
        $user_race = 'Kaz';
        break;  

        default:
        $user_race = 'Unknown';
        break;  

        }

        if ($user['last_active']>(time()-60*3)) $stats_str='<span style="color: green">online</span>';
	    else if ($user['last_active']>(time()-60*9)) $stats_str='<span style="color: orange">abwesend</span>';
            else $stats_str='<span style="color: red">offline</span>';

            $game->out('
        <tr>
          <td width="30"><input type="radio" name="user_id" value="'.$user['user_id'].'"'.( ($user['user_id'] == $alliance['alliance_owner']) ? ' disabled="disabled"' : '' ).'></td>
          <td width="190"><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user['user_id']).'">'.sprintf($member_status[$user['user_alliance_status']], $user['user_name']).'</a></td>
          <td width="70">'.$user_race.'</td>         
          <td width="70">'.$user['user_planets'].'</td>
          <td width="80">'.$user['user_points'].'</td>
          '.( ($game->option_retr('alliance_status_member')==1) ? '<td width="80">'.(($user['user_vacation_end']<$ACTUAL_TICK) ? timeformat(time()-$user['last_active']) : 'urlaub').'</td>' : '<td width="80"><b>'.$stats_str.'<b></td>' ).'
        </tr>
            ');
        }
         
     $game->out('
      </table>
      <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="5"><td></td></tr>
        <tr><!--<td align="left">
          <input class="button" type="submit" name="status_change_fin" value="Markierung Kasse/Standart"></td>!-->
	   <td><input class="button" type="submit" name="status_change_diplo" value="Markierung Diplomat/Standart"></td>
          <td align="left">
          <input class="button" type="submit" name="status_change" value="Markierung Admin/Standart">

        </td>
       </tr>
        
        <!--<tr height="5"><td></td></tr>
	 <tr><td align="left">
          <input class="button" type="submit" name="status_change" value="Markierung Admin/Standart">

        </td></tr>!-->
        ');
        
        if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
            $game->out('
         <tr height="5"><td></td></tr>
         <tr><td align="left">
           <input class="button" type="submit" name="owner_change" value="Präsidentenamt übergeben">
         </td></tr>
            '); 
        }
        
        $game->out('</form></table>');
    }
    else {
        $game->out('
      <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="210"><b>Name</b></td>
          <td width="70"><b>Rasse</b></td> 
          <td width="70"><b>Planeten</b></td>
          <td width="60"><b>Punkte</b></td>
          <td width="50"><b>Status</b></td>
        </tr>
        ');

        while($user = $db->fetchrow($q_user)) {

        switch($user['user_race']) {
 
        case 0:
        $user_race = 'Föd';
        break;       
 
        case 1:
        $user_race = 'Rom';
        break;  

        case '2':
        $user_race = 'Kli';
        break;  

        case '3':
        $user_race = 'Car';
        break;  

        case '4':
        $user_race = 'Dom';
        break;  

        case '5':
        $user_race = 'Fer';
        break;  

        case '8':
        $user_race = 'Bre';
        break;  

        case '9':
        $user_race = 'Hir';
        break;  

        case '10':
        $user_race = 'Kre';
        break;  

        case '11':
        $user_race = 'Kaz';
        break;  

        default:
        $user_race = 'Unknown';
        break;  

        }

        if ($user['last_active']>(time()-60*3)) $stats_str='<span style="color: green">online</span>';
	    else if ($user['last_active']>(time()-60*9)) $stats_str='<span style="color: orange">abwesend</span>';
            else $stats_str='<span style="color: red">offline</span>';

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
        <tr><td width="350" align="left"><i>Rassenverteilung innerhalb der Allianz</i></td><td width="175" align="right">&nbsp;</td></tr>
        </table>
        <table class="style_inner" width="350" align="center" border="0" cellpadding="2" cellspacing="2">

                <td width="130" class="desc_row">Föderation (Föd):</td>
                <td width="140" class="value_row">'.$race['racecount_0'].' ('.$race['racepercent_0'].'%)</td>
              </tr>
              <tr>
                <td class="desc_row">Romulaner (Rom):</td>
                <td class="value_row">'.$race['racecount_1'].' ('.$race['racepercent_1'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Klingonen (Kli):</td>
                <td class="value_row">'.$race['racecount_2'].' ('.$race['racepercent_2'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Cardassianer (Car):</td>
                <td class="value_row">'.$race['racecount_3'].' ('.$race['racepercent_3'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Dominion (Dom):</td>
                <td class="value_row">'.$race['racecount_4'].' ('.$race['racepercent_4'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Ferengi (Fer):</td>
                <td class="value_row">'.$race['racecount_5'].' ('.$race['racepercent_5'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Breen (Bre):</td>
                <td class="value_row">'.$race['racecount_8'].' ('.$race['racepercent_8'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Hirogen (Hir):</td>
                <td class="value_row">'.$race['racecount_9'].' ('.$race['racepercent_9'].'%)</b></td>
              </tr>
              <tr>
                <td class="desc_row">Krenim (Kre):</td>
                <td class="value_row">'.$race['racecount_10'].' ('.$race['racepercent_10'].'%)</b></td>
              </tr>
              <tr>
              <tr>
                <td class="desc_row">Kazon (Kaz):</td>
                <td class="value_row">'.$race['racecount_11'].' ('.$race['racepercent_11'].'%)</b></td>
              </tr>
        </table>
    </td>
  </tr> 
</table>
<br>
<center>
<i>Legende:</i>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);">Mitglied</a>&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_FINANZ], 'Kassenzugriff').'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_DIPLO], 'Diplomat').'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_ADMIN], 'Admin').'&nbsp;&nbsp;&nbsp;'.sprintf($member_status[ALLIANCE_STATUS_OWNER], 'Präsident').'
</center>
    ');
}

elseif(!empty($_POST['leave_confirm'])) {
    check_membership(true);
    
    if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
        message(NOTICE, 'Der Präsident kann seine Allianz nicht verlassen');
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
    alliance_log('<font color=green>'.$game->player['user_name'].'</font> hat die Allianz <b>verlassen</b>');
    
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
        message(NOTICE, 'Der Präsident kann seine Allianz nicht verlassen');
    }

    $game->out('
<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_main').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      Willst du wirklich deine Allianz verlassen?<br><br>
      <input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="leave_confirm" value="Bestätigen">
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
		message(NOTICE, 'Kein Allianz-Name angegeben');
	}
	
	$alliance_tag = addslashes($_POST['alliance_tag']);
	
	if(empty($alliance_tag)) {
		message(NOTICE, 'Kein Allianz-Tag angegeben');
	}
	
	$sql = 'SELECT alliance_id
	        FROM alliance
	        WHERE alliance_tag = "'.$alliance_tag.'" OR
               alliance_name = "'.$alliance_name.'"';
	              
    if(($ally_exists = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance name/tag data');
    }
    
    if(!empty($ally_exists['alliance_id'])) {
        message(NOTICE, 'Es gibt schon eine Allianz mit diesem Namen/Tag');
    }
	
    // Passwort Eintrag entfernt	

	$sql = 'INSERT INTO alliance (alliance_name, alliance_tag, alliance_owner, alliance_text, alliance_logo, alliance_homepage, alliance_points, alliance_planets, alliance_honor)
			VALUES ("'.$alliance_name.'", "'.$alliance_tag.'", "'.$game->player['user_id'].'", "", "", "", '.$game->player['user_points'].', '.$game->player['user_planets'].', '.$game->player['user_honor'].')';
			
    if(!$db->query($sql)) {
    	message(DATABASE_ERROR, 'Could not insert new alliance data');
    }
    	
    
	$new_alliance_id = $db->insert_id();
    	alliance_log('<font color=green>'.$game->player['user_name'].'</font> hat die Allianz <font color=red>'.$alliance_name.' ['.$alliance_tag.']</font> gegründet',0,$new_alliance_id);
    
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
    
    redirect('a=alliance_main');
}

// Keine Aktion gegegeben, also prüfen, ob der Spieler in einer Allianz ist oder nicht
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
        ALLIANCE_STATUS_MEMBER => '<span style="color: #00FF00;">Mitglied</span>',
        ALLIANCE_STATUS_ADMIN => '<span style="color: #FFFF00;">Admin</span>',
        ALLIANCE_STATUS_OWNER => '<span style="color: #FF0000;">Präsident</span>',
        ALLIANCE_STATUS_DIPLO => '<span style="color: #FFA500;">Diplomat</span>'
    );

    $game->out('
<table class="style_outer" width="380" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$alliance['alliance_name'].' ['.$alliance['alliance_tag'].']</span><br><br>
      '.( (!empty($alliance['alliance_logo'])) ? '<img src="'.$alliance['alliance_logo'].'"><br><br>' : '' ).'<br>
      
      <table class="style_inner" width="200" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100">Status:</td>
          <td width="100">'.$member_status[$game->player['user_alliance_status']].'</td>
        </tr>
      </table>
      <br>
      <table class="style_inner" width="200" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="100">Mitglieder:</td>
          <td width="100"><b>'.$alliance['member_count'].'</b></td>
        </tr>
        <tr>
          <td width="100">Punkte:</td>
          <td width="100"><b>'.$alliance['alliance_points'].'</b></td>
        </tr>
        <tr>
          <td width="100">Planeten:</td>
          <td width="100"><b>'.$alliance['alliance_planets'].'</b></td>
        </tr>
        <tr>
          <td width="100">Verdienst:</td>
          <td width="100"><b>'.$alliance['alliance_honor'].'</b></td>
        </tr>
        <tr>
          <td width="100">&nbsp;</td>
          <td width="100">&nbsp;</td>
        </tr>
        <tr>
          <td width="100">Rang:</td>
          <td width="100"><b>'.$alliance['alliance_rank_points'].'</b></td>
        </tr>
        <tr>
          <td width="100">Rang &empty;:</td>
          <td width="100"><b>'.$alliance['alliance_rank_points_avg'].'</b></td>
        </tr>
        <tr>
          <td width="100">&nbsp;</td>
          <td width="100">&nbsp;</td>
        </tr>
        <tr>
          <td width="100">Homepage:</td>
          <td width="100"><a href="'.$alliance['alliance_homepage'].'">'.$alliance['alliance_homepage'].'</a></td>
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
            <a href="'.parse_link('a=alliance_main&member_list').'">Mitgliederliste</a><br>
            <a href="'.parse_link('a=alliance_attack').'">Taktische Übersicht</a><br>
            <a href="alliancemap.php?alliance='.$alliance['alliance_tag'].'&size=6&map" target=_blank>Allianzkarte</a><br>
            <a href="'.parse_link('a=alliance_diplomacy').'">Diplomatie</a><br>
            <a href="'.parse_link('a=alliance_taxes').'">Allianzkasse</a><br><br>
            <a href="'.parse_link('a=alliance_board').'">Allianzforum</a><br><br>
    ');
    

    if($game->player['user_alliance_rights1']==1) { 
    
    $game->out('
            
            <a href="'.parse_link('a=alliance_admin&settings').'">Allianz-Einstellungen</a><br> '); 
    } 
    //else { $game->out('<br>'); }


    $sql = 'SELECT application_id FROM alliance_application WHERE application_alliance = '.$game->player['user_alliance'];

    if(($new_app = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    } 

    
    if($game->player['user_alliance_rights6']==1) { 

      if(!empty($new_app['application_id'])) {
            $game->out('<a href="'.parse_link('a=alliance_application&application=admin').'"><span style="color: #FFFF00;"><b>Allianz-Bewerbungen</b></span></a><br>');

      }
      else { $game->out('
            <a href="'.parse_link('a=alliance_application&application=admin').'">Allianz-Bewerbungen</a><br>
	    
         '); }
    } 
    //else { $game->out('<br>'); }
    
    if($game->player['user_alliance_rights8']==1) {
     
    $game->out('<a href="'.parse_link('a=alliance_rights').'">Allianz-Rechteverwaltung</a></br>');
    } 
    //else { $game->out('<br>'); 

    if($game->player['user_alliance_rights4']==1) {   
    $game->out('<a href="'.parse_link('a=alliance_massmail').'">Massenmail verfassen</a>');
    }
   // else { $game->out('<br>'); }
    
    if($game->player['user_id'] == $alliance_rights['alliance_owner']) {
        $game->out('<br><br><a href="'.parse_link('a=alliance_admin&delete').'">Allianz auflösen</a>');
    }
    else {
        $game->out('<br><br><a href="'.parse_link('a=alliance_main&leave').'">Allianz verlassen</a>');
    }
    
    $game->out('
          </td>
        </tr>
      </table>
      <br>');
      
      $game->out('<br><table class="style_inner" width="330" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="330"><b>Allianzmeldungen '.(!isset($_GET['all_logs']) ? '[<a href="'.parse_link('a=alliance_main&all_logs').'">Alle zeigen</a>]' : '').':</b><br><br>');
	  
	  
    $log_qry=$db->query('SELECT * FROM alliance_logs WHERE alliance='.$game->player['user_alliance'].' AND permission<='.$game->player['user_alliance_status'].' ORDER BY id DESC '.(!isset($_GET['all_logs']) ? 'LIMIT 5' : ''));  
    while (($log=$db->fetchrow($log_qry))==true)
    {
    $game->out('<table border=0 cellpadding=0 cellspacing=0><tr><td width=80>'.date('d.m.y H:i',$log['timestamp']+7200).'</td><td width=250>'.stripslashes($log['message']).'</td></tr></table>');   
    };
	
	  
    $game->out('	  
	  </td>
        </tr>
      </table>');
      
           
      
$game->out('     
      <br>
      <table class="style_inner" width="330" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="330"><b>Allianztext:</b><br><br>'.stripslashes($alliance['alliance_text']).'</td>
        </tr>
      </table>

    </td>
  </tr>
</table>
    ');
}
// Scheint als wär der Spieler in keiner Allianz
else {
	$game->out('
<table width="520" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="252" align="center" valign="top">
	  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
	    <form method="post" action="'.parse_link('a=alliance_main&new').'">
		<tr>
		  <td colspan="2"><b>Neue Allianz gründen</b><br></td>
		</tr>
		<tr>
		  <td width="120">Allianz-Name:</td>
		  <td width="130"><input class="field" type="text" name="alliance_name"></td>
		</tr>
		<tr>
		  <td width="120">Allianz-Tag:</td>
		  <td width="130"><input class="field" type="text" name="alliance_tag" maxlength="6" size="10"></td>
		</tr>
		<tr>
		  <td colspan="2" align="center"><input class="button" type="submit" name="new_submit" value="Bestätigen"></td>
		</tr>
		</form>
	  </table>
	</td>
	</tr>
	 
	<tr>
          <td>&nbsp;</td>
        </tr>
	<tr>
          <td align="center"><b>oder</b></td>
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
		  <td colspan="2"><b>Bei einer Allianz bewerben</b><br></td>

	<tr>
	</tr>


	<tr>
	  <td colspan="2" align="center">[<a href="'.parse_link('a=alliance_application&list').'">Bewerbung schreiben</a>]</td>
	</tr>

       ');

        }
        else { 

        $game->out('

	<td width="252" align="center" valign="top">
	  <table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
         <tr>
		  <td colspan="2"><b>Bei einer Allianz bewerben</b><br></td>

	<tr>
	</tr>

       <tr>
         <td align="center">Aktuell beworben bei:<br> <span style="color: green; font-weight: bold;">'.get_alliance_name($application_check['application_alliance']).'</span></td>
       </tr>  

       <tr>
         <td>&nbsp;</td>
       </tr>  

       <tr>
	  <td colspan="2" align="center">[<a href="'.parse_link('a=alliance_application&surdelete=1').'">Bewerbung zurückziehen</a>]</td>
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
