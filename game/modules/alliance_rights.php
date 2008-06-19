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
$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>');



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
        message(NOTICE, constant($game->sprache("TEXT1")));
    }
    
    if(!$in_alliance && $requirement) {
        message(NOTICE, constant($game->sprache("TEXT2")));
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
    message(NOTICE, constant($game->sprache("TEXT3")));
}

if(isset($_POST['save'])) {

  $user_id = $_POST['user_id'];

  $sql = 'SELECT user_id, user_alliance FROM user WHERE user_id = '.$user_id;
  
  if(($user_data = $db->queryrow($sql)) === false) {
      message(DATABASE_ERROR, 'Could not query user alliance data');
  }

  if($user_data['user_alliance'] != $game->player['user_alliance']) {
    message(NOTICE, constant($game->sprache("TEXT4")));
  }

  if($user_id == $alliance['alliance_owner']) {
    message(NOTICE, constant($game->sprache("TEXT5")));
  }

  if($user_id == $game->player['user_id']) {
    message(NOTICE, constant($game->sprache("TEXT6")));
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
        message(NOTICE, constant($game->sprache("TEXT7")));
    }

    if($user_data['user_alliance'] != $game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT8")));
    }

    if($user_data['user_id'] == $alliance['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT9")));
    }

    if($user_data['user_id'] == $game->player['user_id']) {
        message(NOTICE, constant($game->sprache("TEXT10")));
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
    alliance_log('<font color=green>'.$user_data['user_name'].'</font> '.constant($game->sprache("TEXT11")).' <font color=green>'.$game->player['user_name'].'</font>'.constant($game->sprache("TEXT12")));

    
    $sql = 'UPDATE alliance
            SET alliance_points = alliance_points - '.$user_data['user_points'].',
                alliance_planets = alliance_planets - '.$user_data['user_planets'].',
                alliance_honor = alliance_honor - '.$user_data['user_honor'].'
            WHERE alliance_id = '.$game->player['user_alliance'];
            
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update alliance data');
    }

    SystemMessage($user_id, constant($game->sprache("TEXT13")), constant($game->sprache("TEXT14")).' <b>'.$game->player['alliance_name'].'</b>'.constant($game->sprache("TEXT15")));

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
        message(NOTICE, constant($game->sprache("TEXT7")));
    }
    $game->out('
<table class="style_inner" width="300" align="center" border="0" cellpadding="2" cellspacing="2">
  <form method="post" action="'.parse_link('a=alliance_rights').'">
  <tr height="5"><td></td></tr>
  <tr>
    <td align="center">
      '.constant($game->sprache("TEXT16")).'<a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_id).'">'.$user_data['user_name'].'</a>'.constant($game->sprache("TEXT17")).'<br><br>
      <input class="button" type="button" value="'.constant($game->sprache("TEXT18")).'" onClick="return window.history.back();">&nbsp;&nbsp;
      <input class="button" type="submit" name="kick_confirm" value="'.constant($game->sprache("TEXT19")).'">
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
    <td><b>'.constant($game->sprache("TEXT20")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT21")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT22")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT23")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT24")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT25")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT26")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT27")).'</b></td><td align="center"><b>'.constant($game->sprache("TEXT28")).'</b></td><td><b>'.constant($game->sprache("TEXT29")).'</b></td>
  </tr>

');

while (($user_rights = $db->fetchrow($listquery)) != false) {

if($user_rights['user_id']==$alliance['alliance_owner']) {

$game->out('

<td><a href="'.parse_link('a=stats&a2=viewplayer&id='.$user_rights['user_id'].'').'">'.$user_rights['user_name'].'</a></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td>'.constant($game->sprache("TEXT30")).'</td>

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

  $game->out('<td><input type="submit" name="save" value="'.constant($game->sprache("TEXT31")).'"></td>');
  $game->out('<td><input type="submit" name="kick" value="'.constant($game->sprache("TEXT32")).'"></td></tr></form>');
  }
}


$game->out('
</table><br><br>
<table>

<tr>
  <td>'.constant($game->sprache("TEXT33")).'</td><td>'.constant($game->sprache("TEXT34")).'</td>
</tr>
<tr>
  <td>'.constant($game->sprache("TEXT35")).'</td><td>'.constant($game->sprache("TEXT36")).'</td>
</tr>
<tr>
  <td>'.constant($game->sprache("TEXT37")).'</td><td>'.constant($game->sprache("TEXT38")).'</td>
</tr>
<tr>
  <td>'.constant($game->sprache("TEXT39")).'</td><td>'.constant($game->sprache("TEXT40")).'</td>
</tr>

</table>

');


?>
