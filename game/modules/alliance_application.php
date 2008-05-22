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

function get_owner_name($owner_id) {
  global $db;

  $sql = 'SELECT user_name FROM user WHERE user_id = '.$owner_id;

  if(($owner_name = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

  return $owner_name['user_name'];
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
$game->out('<center><span class="caption">Allianz-Bewerbungen:</span><br><br>');

 $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance_rights = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }


if(isset($_GET['application'])) {

  if($_GET['application']=='new') {

      check_membership(false);

      $sql = 'SELECT * FROM alliance_application WHERE application_user = '.$game->player['user_id'];

      if(($app_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
      }

      if(!empty($app_data['application_user'])){
         message(NOTICE, 'Du hast dich bereits bei einer Allianz beworben.');
      }

      $sql = 'SELECT * FROM alliance WHERE alliance_id = '.$_GET['alliance'];

      if(($alliance_name = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
      }

      if($alliance_name['alliance_application']!=1) {
         message(NOTICE, 'Die Allianz hat das Bewerben nicht erlaubt');
      }
      if((($game->player['last_alliance_kick']+480)>=$ACTUAL_TICK) && $game->player['last_alliance_kick']!=0){
         message(NOTICE, 'Du darfst erst 24 Stunden nach Kick aus deiner letzten Allianz wieder einer neuen Beitreten.');
      }

	          $game->out('
<script language="JavaScript" type="text/javascript">
<!-- 
function text() {
   

    document.load_form.application_text.value = "'.$alliance_name['alliance_application_text'].'";

    return true;
}
//-->
</script> ');
if(isset($_GET['vorlage']) && $_GET['vorlage']==1) {$text=$alliance_name['alliance_application_text'];}else{$text='';}
      $game->out('

        <table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="4">

          <form name="load_form" action="'.parse_link('a=alliance_application').'" method="post">
          <input type="hidden" name="alliance_id" value="'.$_GET['alliance'].'">
            <tr>
              <td colspan="2" align="center">Bewerben bei <b>'.$alliance_name['alliance_name'].'</b></td>
            </tr>
             <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
             <tr>
              ');
//old von mojo<td colspan="2" align="center">[<a href="javascript:void(0);" onClick="return text();">Allianz Vorlage</a>]</td>
            $game->out('<td colspan="2" align="center">[<a href="'.parse_link('a=alliance_application&application=new&alliance='.$_GET['alliance'].'&vorlage=1').'">Allianz Vorlage</a>]</td></tr>
	     <tr>
              <td colspan="2" align="center">Bewerbungstext:</td>
            </tr>
             <tr>
              <td colspan="2" align="center"><textarea name="application_text" cols="45" rows="8" value="">'.$text.'</textarea></td>
            </tr>
             <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
             <tr>
             </tr>
            <tr>
              <td colspan="2" align="center"><input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;<input class="button" type="submit" name="application_submit" value="Bestätigen"></td>
            </tr>

            </form>

        </table>

      ');
  }

  if($_GET['application']=='admin') {
  
  check_membership(true);

// Rechtecheck
    
$sql = 'SELECT *
      FROM alliance
      WHERE alliance_id = '.$game->player['user_alliance'];

if(($alliance = $db->queryrow($sql)) === false) {
   message(DATABASE_ERROR, 'Could not query alliance data');
}

if($game->player['user_alliance_rights6'] != 1) {
    message(NOTICE, 'Du bestitzt nicht die erforderlichen Berechtigungen um diesen Vorgang auszuführen.');
}

// Check Ende


  $game->out('

  <table class="style_inner" width="450" align="center" border="0" cellpadding="2" cellspacing="4">

  <tr>
    <td width="10">&nbsp;</td><td>Name</td><td>Punkte</td><td>Beworben am:</td><td>Aktionen</td>
  <tr>
  	
  

  ');

  $listquery=$db->query('SELECT * FROM alliance_application, user WHERE application_alliance = '.$game->player['user_alliance'].' AND user_id = application_user ORDER by application_id ASC');

  while (($application = $db->fetchrow($listquery)) != false)
  {

   if($application['application_read']==0) {

      $game->out(' 
   
   <tr><td><img src="http://88.84.142.96/stgc5_gfx/new.png" alt="New"></img></td>
   <td>'.$application['application_username'].'</td>
   <td>'.$application['user_points'].'</td>
   <td>'.date('d.m.y H:i', $application['application_timestamp']).'</td>
   <td>[<a href="'.parse_link('a=alliance_application&application=accept&app_id='.$application['application_id'].'').'"><span style="color: #00FF00;">Annehmen</span></a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=deny&app_id='.$application['application_id'].'').'"><span style="color: #FF0000;">Ablehnen</span></a>]&nbsp;&nbsp;[<a href="'.parse_link('a=alliance_application&application=details&app_id='.$application['application_id'].'').'">Details</a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=wing&app_id='.$application['application_id'].'').'">Wing</a>]</td></tr>      

  ');

   }
   else {

   $game->out(' 
   
   <tr><td></td>
   <td>'.$application['application_username'].'</td>
   <td>'.$application['user_points'].'</td>
   <td>'.date('d.m.y H:i', $application['application_timestamp']).'</td>
   <td>[<a href="'.parse_link('a=alliance_application&application=accept&app_id='.$application['application_id'].'').'"><span style="color: #00FF00;">Annehmen</span></a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=deny&app_id='.$application['application_id'].'').'"><span style="color: #FF0000;">Ablehnen</span></a>]&nbsp;&nbsp;[<a href="'.parse_link('a=alliance_application&application=details&app_id='.$application['application_id'].'').'">Details</a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=wing&app_id='.$application['application_id'].'').'">Wing</a>]</td></tr>      

  ');
   }
  }

  $game->out('</table>');


  }

}

  if($_GET['application']=='details') {

  check_membership(true);

if($game->player['user_alliance_rights6'] != 1) {
    message(NOTICE, 'Du bestitzt nicht die erforderlichen Berechtigungen um diesen Vorgang auszuführen.');
}  


  // Wird nur gesetzt wen nicht schon gelesen, da sonst Minuswerte entstehen können.

  $sql = 'UPDATE alliance_application SET application_read = 1 WHERE application_id = '.$_GET['app_id'];

  if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Could not Update application READ');
  }


  $sql = 'SELECT * FROM alliance_application, user WHERE application_id = '.$_GET['app_id'].' AND user_id = application_user';
      
    if(($application_data = $db->queryrow($sql)) === false) {
      message(DATABASE_ERROR, 'Could not query app data');
    }

/*  if($application_data['application_read']!=1) {
  
    $sql = 'UPDATE alliance SET alliance_application_new = (alliance_application_new - 1) WHERE alliance_id = '.$game->player['user_alliance'];

    if(!$db->query($sql)) {
      message(DATABASE_ERROR, 'Could not Update alliance application READ');
    }

  } */

    if($application_data['application_alliance'] != $game->player['user_alliance']) {
      message(NOTICE, 'Du bist nicht in dieser Allianz');
    }

  

  $game->out('

  <table class="style_inner" width="450" align="center" border="0" cellpadding="2" cellspacing="4">

    <tr>
      <td align="center" width="67">&nbsp;</td><td align="center" width="200"><font size="4"><b>Details</b></font></td><td align="center" width="67">&nbsp;</td>
    </tr>

    <tr><td>&nbsp;</td><td>
  <table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="4">


  <tr>
    <td align="left">Name:&nbsp;</td><td align="left">'.$application_data['application_username'].'</td>
  </tr>

  <tr>
    <td align="left">Punkte:</td><td align="left">'.$application_data['user_points'].'</td>
  </tr>
    
  <tr>
    <td align="left">Planeten:</td><td align="left">'.$application_data['user_planets'].'</td>
  </tr>

  </table></td></tr>

  <tr>
    <td align="left">&nbsp;</td><td align="left">&nbsp</td>
  </tr>


  <tr>
    <td align="center" width="67">&nbsp;</td><td align="center" width="200">Bewerbungstext:<br></td>
  </tr>

  <tr>
    <td align="left" width="67">&nbsp;</td><td align="left" width="200">'.stripslashes($application_data['application_text']).'</td>
  </tr>

  <tr>
    <td align="left">&nbsp;</td><td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="left" width="67"></td>&nbsp;<td align="left" width="200">Aktionen:</td><td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="left" width="67"></td>&nbsp;<td align="left" width="200">[<a href="'.parse_link('a=alliance_application&application=accept&app_id='.$application_data['application_id'].'').'"><span style="color: #00FF00;">Annehmen</span></a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=deny&app_id='.$application_data['application_id'].'').'"><span style="color: #FF0000;">Ablehnen</span></a>]&nbsp;[<a href="'.parse_link('a=alliance_application&application=wing&app_id='.$application_data['application_id'].'').'">Wing</a>]&nbsp;<br>[<a href="'.parse_link('a=alliance_application&application=admin').'">Zurück zur Übersicht</a>]</td><td align="left">&nbsp;</td>
  </tr>


  </table>

  ');

  }
  
  if($_GET['application']=='accept') {

  check_membership(true);

if($game->player['user_alliance_rights6'] != 1) {
    message(NOTICE, 'Du bestitzt nicht die erforderlichen Berechtigungen um diesen Vorgang auszuführen.');
}

 
  $sql = 'SELECT * FROM alliance_application, user, alliance WHERE application_id = '.$_GET['app_id'].' AND user_id = application_user AND alliance_id = application_alliance';
      
  if(($application_data = $db->queryrow($sql)) === false) {
    message(DATABASE_ERROR, 'Could not query app data');
  }

  if($application_data['application_alliance'] != $game->player['user_alliance']) {
    message(NOTICE, 'Du bist nicht in der Allianz an die dieses Angebot ging!');
  }

  SystemMessage($application_data['application_user'], 'Bewerbung angenommen', 'Deine Bewerbung bei '.$application_data['alliance_name'].' wurde angenommen.<br>Du bist der Allianz beigetreten.');

  $sql = 'UPDATE user SET user_alliance = '.$application_data['application_alliance'].', user_alliance_status = '.ALLIANCE_STATUS_MEMBER.' WHERE user_id = '.$application_data['application_user'];

  alliance_log('<font color=green>'.$application_data['application_username'].'</font> hat die Allianz <b>betreten</b> ('.$game->player['user_name'].')',0,$application_data['application_alliance']);

  if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Could not add user to alliance');
  }

 /* if($application_data['application_read']!=1) {
  
    $sql = 'UPDATE alliance SET alliance_application_new = (alliance_application_new - 1) WHERE alliance_id = '.$game->player['user_alliance'];

    if(!$db->query($sql)) {
      message(DATABASE_ERROR, 'Could not Update alliance application READ');
    }
  } */

  $sql = 'DELETE FROM alliance_application WHERE application_id = '.$_GET['app_id'];

  if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Could not delete application Data');
  }

  
  redirect('a=alliance_application&application=admin');


  }

  if($_GET['application']=='deny') {

  check_membership(true);

if($game->player['user_alliance_rights6'] != 1) {
    message(NOTICE, 'Du bestitzt nicht die erforderlichen Berechtigungen um diesen Vorgang auszuführen.');
}
 
  $sql = 'SELECT * FROM alliance_application, user, alliance WHERE application_id = '.$_GET['app_id'].' AND user_id = application_user AND alliance_id = application_alliance';
      
  if(($application_data = $db->queryrow($sql)) === false) {
    message(DATABASE_ERROR, 'Could not query app data');
  }

  if($application_data['application_alliance'] != $game->player['user_alliance']) {
    message(NOTICE, 'Du bist nicht in der Allianz an die dieses Angebot ging!');
  }

  SystemMessage($application_data['application_user'], 'Bewerbung abgelehnt', 'Deine Bewerbung bei '.$application_data['alliance_name'].' wurde abgelehnt.');

 /* // Wird nur gesetzt wen nicht schon gelesen, da sonst Minuswerte entstehen können.

    if($application_data['application_read']!=1) {
  
      $sql = 'UPDATE alliance SET alliance_application_new = (alliance_application_new - 1) WHERE alliance_id = '.$game->player['user_alliance'];

    if(!$db->query($sql)) {
      message(DATABASE_ERROR, 'Could not Update alliance application READ');
    }
  } */

  $sql = 'DELETE FROM alliance_application WHERE application_id = '.$_GET['app_id'];

  if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Could not delete application Data');
  }

  redirect('a=alliance_application&application=admin');

  }

  if($_GET['application']=='wing') {

  // Tot bis Wingsystem fertig

  }

if(isset($_GET['list'])) {

check_membership(false);

  $order_str = 'alliance_name ASC';

  if($_GET['list']<0 || $_GET['list']>5) $_GET['list']==0;

  
if($_GET['list']==0) $order_str = 'alliance_name ASC';
if($_GET['list']==1) $order_str = 'alliance_tag ASC';
if($_GET['list']==2) $order_str = 'alliance_member DESC';
if($_GET['list']==3) $order_str = 'alliance_points DESC';
if($_GET['list']==4) $order_str = 'alliance_rank_points DESC';
if($_GET['list']==5) $order_str = 'alliance_application DESC';


$listquery=$db->query('SELECT * FROM alliance ORDER BY '.$order_str.'');
            

$game->out(' <table class="style_inner" width="650" align="center" border="0" cellpadding="2" cellspacing="4"> 

	<tr>
	  <td ><a href="'.parse_link('a=alliance_application&list=0').'"><span class="sub_caption2">Name</span></a></td><td ><a href="'.parse_link('a=alliance_application&list=1').'"><span class="sub_caption2">Tag</span></a></td><td><span class="sub_caption2">Präsident</span></td><td ><a href="'.parse_link('a=alliance_application&list=3').'"><span class="sub_caption2">Member</span></a></td ><td><a href="'.parse_link('a=alliance_application&list=4').'"><span class="sub_caption2">Punkte</span></a></td><td ><a href="'.parse_link('a=alliance_application&list=5').'"><span class="sub_caption2">Rang</span></td><td ><span class="sub_caption2">Status</span></a></td>
	</tr>
	
');



while (($alliance = $db->fetchrow($listquery)) != false)
{


  $game->out(' 
	<tr>
	  <td >'.$alliance['alliance_name'].'</td>
	  <td >'.$alliance['alliance_tag'].'</td>
         <td >'.get_owner_name($alliance['alliance_owner']).'</td>
	  <td  align="center">'.$alliance['alliance_member'].'</td>
	  <td >'.$alliance['alliance_points'].'</td>
	  <td >'.$alliance['alliance_rank_points'].'</td>
	
  
  ');

if($alliance['alliance_application']==1) {

   $game->out('<td >[<a href="'.parse_link('a=alliance_application&application=new&alliance='.$alliance['alliance_id'].'').'"><span style="color: #00FF00;">Bewerben</span></a>]</td></tr>');

}
else { $game->out(' <td ><span style="color: #FF0000;">Bewerben nicht möglich</span></td></tr>'); }

}

$game->out(' </table> ');

}

if(isset($_POST['application_submit'])) {

check_membership(false);

  $sql = 'SELECT * FROM alliance WHERE alliance_id = '.$_POST['alliance_id'];
      
  if(($alliance_check = $db->queryrow($sql)) === false) {
    message(DATABASE_ERROR, 'Could not query app data');
  }

      if($alliance_check['alliance_application']!=1) {
         message(NOTICE, 'Die Allianz hat das Bewerben nicht erlaubt');
      }

      $sql = 'SELECT * FROM alliance_application WHERE application_user = '.$game->player['user_id'];

      if(($app_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
      }

      if(!empty($app_data['application_user'])){
         message(NOTICE, 'Du hast dich bereits bei einer Allianz beworben.');
      }


      if((($game->player['last_alliance_kick']+480)>=$ACTUAL_TICK) && $game->player['last_alliance_kick']!=0){
         message(NOTICE, 'Du darfst erst 24 Stunden nach Kick aus deiner letzten Allianz wieder einer neuen Beitreten.');
      }

$sql = 'INSERT INTO alliance_application (application_user, application_username, application_alliance, application_text, application_read, application_timestamp)
	VALUES ('.$game->player['user_id'].', "'.$game->player['user_name'].'", '.$_POST['alliance_id'].', "'.mysql_real_escape_string($_POST['application_text']).'", 0, '.time().')';

   if(!$db->query($sql)) {
     message(DATABASE_ERROR, 'Could not insert application Data');
   }

/* $sql = 'UPDATE alliance SET alliance_application_new = alliance_application_new + 1 WHERE alliance_id = '.$_POST['alliance_id'];

   if(!$db->query($sql)) {
     message(DATABASE_ERROR, 'Could not update alliance read Data');
   } */

// Messageing einbauen!!!

$game->out('Sie haben sich erfolgreich beworben.');


}

if(isset($_GET['surdelete'])) {

if($_GET['surdelete']!=1) {

  message(NOTICE, 'Cheatversuch');

}
else {

$game->out('<table class="style_inner" width="250" align="center" border="0" cellpadding="2" cellspacing="4">
<tr>
<td align="center">Sicher das du deine Bewerbung zurückziehen möchtest?<br><br>[<a href="'.parse_link('a=alliance_application&delete=1').'">Ja</a>]&nbsp;&nbsp;[<a href="'.parse_link('a=alliance_main').'">Nein</a>]</td>
</tr>

</table>

');

}
}

if(isset($_GET['delete'])) {

if($_GET['delete']!=1) {

  message(NOTICE, 'Cheatversuch');

}
else {

$sql = 'SELECT * FROM alliance_application WHERE application_user = '.$game->player['user_id'];

  if(($empty_check = $db->queryrow($sql)) === false) {
    message(DATABASE_ERROR, 'Could not query empty check data');
  }

if(empty($empty_check['application_id'])) message(NOTICE, 'Du kannst nur Bewerbungen löschen, wenn du auch welche gestellt hast.');

$sql = 'DELETE FROM alliance_application WHERE application_user = '.$game->player['user_id'];

   if(!$db->query($sql)) {
     message(DATABASE_ERROR, 'Could not update application Data');
   }

redirect('a=alliance_main');

}
}



?>
