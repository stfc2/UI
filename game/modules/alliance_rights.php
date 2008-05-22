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
$game->out('<center><span class="caption">Allianz-Rechteverwaltung:</span><br><br>');



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

check_membership(true);

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }

if($game->player['user_alliance_rights8'] != 1 && $game->player['user_id'] != $alliance['alliance_owner']) {
    message(NOTICE, 'Du bestitzt nicht die erforderlichen Berechtigungen um diesen Vorgang auszuführen.');
}

if(isset($_POST['save'])) {

  $user_id = $_POST['user_id'];

  $sql = 'SELECT user_id, user_alliance FROM user WHERE user_id = '.$user_id;
  
  if(($user_data = $db->queryrow($sql)) === false) {
      message(DATABASE_ERROR, 'Could not query user alliance data');
  }

  if($user_data['user_alliance'] != $game->player['user_alliance']) {
    message(NOTICE, 'Der Spieler ist nicht in deiner Allianz');
  }

  if($user_id == $alliance['alliance_owner']) {
    message(NOTICE, 'Die Rechte des Präsidenten können nicht geändert werden!');
  }

  if($user_id == $game->player['user_id']) {
    message(NOTICE, 'Du kannst deine eigenen Rechte nicht ändern!');
  }

  if(empty($_POST['rights1'])) $_POST['rights1'] = 0;
  if(empty($_POST['rights2'])) $_POST['rights2'] = 0;
  if(empty($_POST['rights3'])) $_POST['rights3'] = 0;
  if(empty($_POST['rights4'])) $_POST['rights4'] = 0;
  if(empty($_POST['rights5'])) $_POST['rights5'] = 0;
  if(empty($_POST['rights6'])) $_POST['rights6'] = 0;
  if(empty($_POST['rights7'])) $_POST['rights7'] = 0;
  if(empty($_POST['rights8'])) $_POST['rights8'] = 0;


  $sql = 'UPDATE user SET user_alliance_rights1 = '.$_POST['rights1'].',  user_alliance_rights2 = '.$_POST['rights2'].', user_alliance_rights3 = '.$_POST['rights3'].', user_alliance_rights4 = '.$_POST['rights4'].', user_alliance_rights5 = '.$_POST['rights5'].', user_alliance_rights6 = '.$_POST['rights6'].', user_alliance_rights7 = '.$_POST['rights7'].', user_alliance_rights8 = '.$_POST['rights8'].' WHERE user_id = '.$user_id.' AND user_alliance = '.$game->player['user_alliance'];

  if($db->queryrow($sql)) {
    message(DATABASE_ERROR, 'Could not query rights data'); 
  }

  redirect('a=alliance_rights');

}

if(!empty($_POST['kick_confirm'])) {
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }
    
    $user_id = (int)$_POST['user_id'];

    $sql = 'SELECT user_id, user_alliance, user_alliance_status, user_points, user_planets, user_honor, user_name
            FROM user
            WHERE user_id = '.$user_id;

    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }
    
    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, 'Der gewählte Spieler ist nicht in deiner Allianz');
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, 'Der Präsident kann nicht gekickt werden!');
    }

    if($user_data['user_id'] == $game->player['user_id']) {
        message(NOTICE, 'Du kannst dich nicht selbst kicken!');
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
                user_alliance_rights8 = 0,
                last_alliance_kick = '.$ACTUAL_TICK.'
            WHERE user_id = '.$user_id;
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update user alliance data');
    }
    alliance_log('<font color=green>'.$user_data['user_name'].'</font> wurde von <font color=green>'.$game->player['user_name'].'</font> <b>gekickt</b>');

    
    $sql = 'UPDATE alliance
            SET alliance_points = alliance_points - '.$user_data['user_points'].',
                alliance_planets = alliance_planets - '.$user_data['user_planets'].',
                alliance_honor = alliance_honor - '.$user_data['user_honor'].'
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance data');
    }
    
    SystemMessage($user_id, 'Aus Allianz gekickt', 'Du wurdest aus deiner Allianz <b>'.$game->player['alliance_name'].'</b> gekickt.');
    
    redirect('a=alliance_rights');
}

elseif(!empty($_POST['kick'])) {
    if(empty($_POST['user_id'])) {
        message(GENERAL, 'Invalid request', '$_POST[\'user_id\'] was empty');
    }
    
    $user_id = (int)$_POST['user_id'];
    
    $sql = 'SELECT user_id, user_name
            FROM user
            WHERE user_id = '.$user_id;
            
    if(($user_data = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query user alliance data');
    }

    if(empty($user_data['user_id'])) {
        message(NOTICE, 'Der gewählte Spieler existiert nicht');
    }
    $game->out('
<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_rights').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      Willst du <a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_id).'">'.$user_data['user_name'].'</a> wirklich KICKEN?<br><br>
      <input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="kick_confirm" value="Bestätigen">
    </td>
  </tr>
  <tr height="5"><td></td></tr>
  <input type="hidden" name="user_id" value="'.$user_id.'">
  </form>
</table><br>
    ');
}


$listquery=$db->query('SELECT * FROM user WHERE user_alliance = '.$game->player['user_alliance'].' ORDER by user_name ASC');

$game->out('

<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="4">
  <tr>
    <td><b>Name</b></td><td align="center"><b>AE</b></td><td align="center"><b>AK</b></td><td align="center"><b>TÜ</b></td><td align="center"><b>M</b></td><td align="center"><b>D</b></td><td align="center"><b>B</b></td><td align="center"><b>C</b></td><td align="center"><b>R</b></td><td><b>Aktionen</b></td>
  </tr>

');

while (($user_rights = $db->fetchrow($listquery)) != false) {

if($user_rights['user_id']==$alliance['alliance_owner']) {

$game->out('

<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_rights['user_id'].'').'">'.$user_rights['user_name'].'</a></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td>Präsident</td>

');

}
else {

$game->out(' <form action="'.parse_link('a=alliance_rights').'" method="post"><input type="hidden" name="user_id" value="'.$user_rights['user_id'].'"><tr><td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_rights['user_id'].'').'">'.$user_rights['user_name'].'</a></td> ');

  if($user_rights['user_alliance_rights1']==1) {
  
  $game->out('<td><input type="checkbox" name="rights1" size="1" value="1" checked></td>');  

  }
  else { $game->out('<td><input type="checkbox" name="rights1" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights2']==1) {
  
  $game->out('<td><input type="checkbox" name="rights2" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights2" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights3']==1) {
  
  $game->out('<td><input type="checkbox" name="rights3" size="1" value="1" checked></td>');  

  }
  else { $game->out('<td><input type="checkbox" name="rights3" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights4']==1) {
  
  $game->out('<td><input type="checkbox" name="rights4" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights4" size="1" value="1" ></td>'); }

  if($user_rights['user_alliance_rights5']==1) {
  
  $game->out('<td><input type="checkbox" name="rights5" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights5" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights6']==1) {
  
  $game->out('<td><input type="checkbox" name="rights6" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights6" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights7']==1) {
  
  $game->out('<td><input type="checkbox" name="rights7" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights7" size="1" value="1"></td>'); }

  if($user_rights['user_alliance_rights8']==1) {
  
  $game->out('<td><input type="checkbox" name="rights8" size="1" value="1" checked></td>'); 

  }
  else { $game->out('<td><input type="checkbox" name="rights8" size="1" value="1"></td>'); }

  $game->out('<td><input type="submit" name="save" value="Speichern"></td>');
  $game->out('<td><input type="submit" name="kick" value="Member kicken"></td></tr></form>');
  }
}


$game->out('
</table><br><br>
<table>

<tr>
  <td>AE = Allgemeine Einstellungen</td><td>AK = Allianzkasse</td>
</tr>
<tr>
  <td>TÜ = Takt. Übersicht</td><td>M = Massmail</td>
</tr>
<tr>
  <td>D = Diplomatie</td><td>B = Bewerbungssystem</td>
</tr>
<tr>
  <td>C = Allianz Chat</td><td>R = Membermanagement</td>
</tr>

</table>

');


?>
