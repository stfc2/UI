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


function get_mpid($alliance1_id) {
    global $game;

    return ( ($alliance1_id == $game->player['user_alliance']) ? 1 : 2 );
}

function get_opid($alliance1_id) {
    global $game;
    
    return ( ($alliance1_id == $game->player['user_alliance']) ? 2 : 1 );
}

$game->init_player();
$game->out('<span class="caption">'.constant($game->sprache("TEXT0")).':</span><br><br>');



if(empty($game->player['alliance_name'])) {
    message(NOTICE, constant($game->sprache("TEXT1")));
}

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }


if(!empty($_GET['do'])) {
    if($game->player['user_alliance_rights5'] != 1) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }
    
    if(empty($_GET['ad_id'])) {
        message(GENERAL ,'Invalid call', '$_GET[\'ad_id\'] == empty');
    }
    
    $ad_id = (int)$_GET['ad_id'];

    $sql = 'SELECT *
            FROM alliance_diplomacy
            WHERE ad_id = '.$ad_id;
            
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance diplomacy data');
    }

    if(empty($diplomacy['ad_id'])) {
        message(NOTICE, constant($game->sprache("TEXT3")));
    }

    if( ($diplomacy['alliance1_id'] != $game->player['user_alliance']) && ($diplomacy['alliance2_id'] != $game->player['user_alliance']) ) {
        message(NOTICE, constant($game->sprache("TEXT4")));
    }
    
    $mpid = get_mpid($diplomacy['alliance1_id']);
    $opid = get_opid($diplomacy['alliance1_id']);

    switch($_GET['do']) {
        case 'accept':
            switch($diplomacy['type']) {
                case ALLIANCE_DIPLOMACY_WAR:
                    switch($diplomacy['status']) {
                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT5")));
                        break;

                        case $mpid:
                            message(NOTICE, constant($game->sprache("TEXT6")));
                        break;
                        
                        case $opid:
  $ally_one=$diplomacy['alliance2_id'];
  $ally_two=$diplomacy['alliance1_id'];
  $sql2 = "SELECT user_id FROM user WHERE user_alliance =$ally_one or user_alliance=$ally_two";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	$sender = 0;
	$selected_alliance = $game->player['user_alliance']; 
	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	$sql6 = "SELECT alliance_id,alliance_name FROM alliance WHERE alliance_id =$ally_one or alliance_id=$ally_two";
	if(($alliances = $db->queryrow($sql3))=== false) {
        message(DATABASE_ERROR, 'Alliance name could not be read - Alliance / NAP text');
    	}

	$betreff = constant($game->sprache("TEXT7"));
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
		$text = constant($game->sprache("TEXT8")).' <b>'.$ally_one.'</b>'.constant($game->sprache("TEXT9")).'<b>'.$ally_two.'</b> <b>'.constant($game->sprache("TEXT10")); 
	$act_time = time();
	while ($row = mysql_fetch_assoc($result2)) {
    	  foreach ($row as $key => $reciever) {  
    	$sql4 = "INSERT INTO message (sender, receiver, subject, text, time) VALUES ('$sender', '$reciever', '$betreff', '$text', '$act_time')";
        	$result4 = mysql_query($sql4);
    	$sql5 = "UPDATE user SET unread_messages = 1 WHERE user_id = '$reciever'";
        	$result5 = mysql_query($sql5);
   	  }
	}
                            $sql = 'DELETE FROM alliance_diplomacy
                                    WHERE ad_id = '.$ad_id;
                                    
                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                            }
                            
                            redirect('a=alliance_diplomacy');
                        break;
                        
                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;
                
                case ALLIANCE_DIPLOMACY_NAP:
                    switch($diplomacy['status']) {
                        case -1:
                            if($mpid == 1) {
                                message(NOTICE, constant($game->sprache("TEXT11")));
                            }
                            
 $ally_one=$diplomacy['alliance2_id'];
  $ally_two=$diplomacy['alliance1_id'];
  $sql2 = "SELECT user_id FROM user WHERE user_alliance =$ally_one or user_alliance=$ally_two";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	$sender = 0;
	$selected_alliance = $game->player['user_alliance']; 
	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	$sql6 = "SELECT alliance_id,alliance_name FROM alliance WHERE alliance_id =$ally_one or alliance_id=$ally_two";
	if(($alliances = $db->queryrow($sql3))=== false) {
        message(DATABASE_ERROR, 'Alliance name could not be read - Alliance / NAP text');
    	}

	$betreff = constant($game->sprache("TEXT12"));
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
	$text = constant($game->sprache("TEXT13")).'<b>'.$ally_one.'</b>'.constant($game->sprache("TEXT14")).'<b>'.$ally_two.'</b>'.constant($game->sprache("TEXT15")); 
	$act_time = time();
	while ($row = mysql_fetch_assoc($result2)) {
    	  foreach ($row as $key => $reciever) {  
    	$sql4 = "INSERT INTO message (sender, receiver, subject, text, time) VALUES ('$sender', '$reciever', '$betreff', '$text', '$act_time')";
        	$result4 = mysql_query($sql4);
    	$sql5 = "UPDATE user SET unread_messages = 1 WHERE user_id = '$reciever'";
        	$result5 = mysql_query($sql5);
   	  }
	}                       
                            $sql = 'UPDATE alliance_diplomacy
                                    SET date = '.$game->TIME.',
                                    status = 0
                                    WHERE ad_id = '.$ad_id;
                                    
                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;
                        
                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT16")));
                        break;
                        
                        case $mpid:
                            message(NOTICE, constant($game->sprache("TEXT17")));
                        break;
                        
                        case $opid:
                         $ally_one=$diplomacy['alliance2_id'];



                            $sql = 'UPDATE alliance_diplomacy
                                    SET type = '.ALLIANCE_DIPLOMACY_PACT.',
                                        date = '.$game->TIME.',
                                        status = 0
                                    WHERE ad_id = '.$ad_id;
                                    
                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }
                            
                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;
                        
                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;
                
                case ALLIANCE_DIPLOMACY_PACT:
                    if($diplomacy['status'] =! -1) {
                        message(NOTICE, constant($game->sprache("TEXT18")));
                    }
                    
                    if($mpid == 1) {
                        message(NOTICE, constant($game->sprache("TEXT17")));
                    }
 $ally_one=$diplomacy['alliance2_id'];
  $ally_two=$diplomacy['alliance1_id'];
  $sql2 = "SELECT user_id FROM user WHERE user_alliance =$ally_one or user_alliance=$ally_two";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	$sender = 0;
	$selected_alliance = $game->player['user_alliance']; 
	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	$sql6 = "SELECT alliance_id,alliance_name FROM alliance WHERE alliance_id =$ally_one or alliance_id=$ally_two";
	if(($alliances = $db->queryrow($sql3))=== false) {
        message(DATABASE_ERROR, 'Alliance name could not be read - Alliance / NAP text');
    	}

	$betreff = constant($game->sprache("TEXT19"));
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
	$text = constant($game->sprache("TEXT20")).$ally_one.constant($game->sprache("TEXT21")).$ally_two.constant($game->sprache("TEXT22")); 
	$act_time = time();
	while ($row = mysql_fetch_assoc($result2)) {
    	  foreach ($row as $key => $reciever) {  
    	$sql4 = "INSERT INTO message (sender, receiver, subject, text, time) VALUES ('$sender', '$reciever', '$betreff', '$text', '$act_time')";
        	$result4 = mysql_query($sql4);
    	$sql5 = "UPDATE user SET unread_messages = 1 WHERE user_id = '$reciever'";
        	$result5 = mysql_query($sql5);
   	  }
	}                     
                    $sql = 'UPDATE alliance_diplomacy
                            SET date = '.$game->TIME.',
                                status = 0
                            WHERE ad_id = '.$ad_id;
                            
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                    }
                    
                    redirect('a=alliance_diplomacy&details='.$ad_id);
                break;
                
                default:
                    message(GENERAL, 'Unknown diplomacy type', '$diplomacy[\'type\'] = '.$diplomacy['type']);
                break;
            }
        break;
        
        case 'deny':
            switch($diplomacy['type']) {
                case ALLIANCE_DIPLOMACY_WAR:
                    switch($diplomacy['status']) {
                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT23")));
                        break;

                        case $mpid:
                            message(NOTICE, constant($game->sprache("TEXT24")));
                        break;

                        case $opid:
                            $sql = 'UPDATE alliance_diplomacy
                                    SET status = 0
                                    WHERE ad_id = '.$ad_id;

                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;

                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;

                case ALLIANCE_DIPLOMACY_NAP:
                    switch($diplomacy['status']) {
                        case -1:
                            if($mpid == 1) {
                                message(NOTICE, constant($game->sprache("TEXT25")));
                            }

                            $sql = 'DELETE FROM alliance_diplomacy
                                    WHERE ad_id = '.$ad_id;


                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy');
                        break;

                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT16")));
                        break;

                        case $mpid:
                            message(NOTICE, constant($game->sprache("TEXT17")));
                        break;

                        case $opid:
                            $sql = 'UPDATE alliance_diplomacy
                                    SET status = 0
                                    WHERE ad_id = '.$ad_id;

                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;

                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;

                case ALLIANCE_DIPLOMACY_PACT:
                    if($diplomacy['status'] =! -1) {
                        message(NOTICE, constant($game->sprache("TEXT27")));
                    }

                    if($mpid == 1) {
                        message(NOTICE, constant($game->sprache("TEXT28")));
                    }

                    $sql = 'DELETE FROM alliance_diplomacy
                            WHERE ad_id = '.$ad_id;
                            
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                    }

                    redirect('a=alliance_diplomacy');
                break;

                default:
                    message(GENERAL, 'Unknown diplomacy type', '$diplomacy[\'type\'] = '.$diplomacy['type']);
                break;
            }
        break;
        
        case 'cancel':
            switch($diplomacy['type']) {
                case ALLIANCE_DIPLOMACY_WAR:
                    switch($diplomacy['status']) {
                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT29")));
                        break;

                        case $mpid:
                            $sql = 'UPDATE alliance_diplomacy
                                    SET status = 0
                                    WHERE ad_id = '.$ad_id;
                                    
                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }
                            
                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;

                        case $opid:
                            message(NOTICE, constant($game->sprache("TEXT30")));
                        break;

                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;

                case ALLIANCE_DIPLOMACY_NAP:
                    switch($diplomacy['status']) {
                        case -1:
                            if($mpid == 0) {
                                message(NOTICE, constant($game->sprache("TEXT73")));
                            }

                            $sql = 'DELETE FROM alliance_diplomacy
                                    WHERE ad_id = '.$ad_id;

                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy');
                        break;

                        case 0:
                            message(NOTICE, constant($game->sprache("TEXT16")));
                        break;

                        case $mpid:
                            $sql = 'UPDATE alliance_diplomacy
                                    SET status = 0
                                    WHERE ad_id = '.$ad_id;

                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy&details='.$ad_id);
                        break;

                        case $opid:
                            message(NOTICE, constant($game->sprache("TEXT74")));
                        break;

                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;

                case ALLIANCE_DIPLOMACY_PACT:
                    if($diplomacy['status'] =! -1) {
                        message(NOTICE, constant($game->sprache("TEXT18")));
                    }

                    if($mpid == 0) {
                        message(NOTICE, constant($game->sprache("TEXT74")));
                    }

                    $sql = 'DELETE FROM alliance_diplomacy
                            WHERE ad_id = '.$ad_id;
                            
                    if(!$db->query($sql)) {
                        message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                    }

                    redirect('a=alliance_diplomacy');
                break;

                default:
                    message(GENERAL, 'Unknown diplomacy type', '$diplomacy[\'type\'] = '.$diplomacy['type']);
                break;
            }
        break;
        
        case 'break':
            if($diplomacy['type'] == ALLIANCE_DIPLOMACY_WAR) {
                message(NOTICE, constant($game->sprache("TEXT75")));
            }

            if($diplomacy['status'] == -1) {
                message(NOTICE, constant($game->sprache("TEXT76")));
            }

            $sql = 'DELETE FROM alliance_diplomacy
                    WHERE ad_id = '.$ad_id;

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
            }

            redirect('a=alliance_diplomacy');
        break;
        
        case 'suggest_peace':
            if($diplomacy['type'] != ALLIANCE_DIPLOMACY_WAR) {
                message(NOTICE, constant($game->sprache("TEXT77")));
            }
            
            if($diplomacy['status'] != 0) {
                message(NOTICE, constant($game->sprache("TEXT78")));
            }
            
            $sql = 'UPDATE alliance_diplomacy
                    SET status = '.get_mpid($diplomacy['alliance1_id']).'
                    WHERE ad_id = '.$ad_id;
                    
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
            }
            
            redirect('a=alliance_diplomacy&details='.$ad_id);
        break;

        case 'suggest_pact':
            if($diplomacy['type'] != ALLIANCE_DIPLOMACY_NAP) {
                message(NOTICE, constant($game->sprache("TEXT79")));
            }
            
            if($diplomacy['status'] == -1) {
                message(NOTICE, constant($game->sprache("TEXT80")));
            }
            elseif($diplomacy['status'] != 0) {
                message(NOTICE, constant($game->sprache("TEXT81")));
            }

            $sql = 'UPDATE alliance_diplomacy
                    SET status = '.get_mpid($diplomacy['alliance1_id']).'
                    WHERE ad_id = '.$ad_id;

            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update alliance diplomacy data');
            }

            redirect('a=alliance_diplomacy&details='.$ad_id);
        break;
    }
}
elseif(!empty($_POST['new_submit'])) {
    if($game->player['user_alliance_rights5'] != 1 && $game->player['user_id'] != $alliance['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    if(empty($_POST['alliance2_tag'])) {
        message(NOTICE, constant($game->sprache("TEXT31")));
    }
    
    $alliance2_tag = addslashes($_POST['alliance2_tag']);
    
    $sql = 'SELECT alliance_id
            FROM alliance
            WHERE alliance_tag = "'.$alliance2_tag.'"';
            
    if(($alliance2 = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other party´s alliance data');
    }
    
    if(empty($alliance2['alliance_id'])) {
        message(NOTICE, constant($game->sprache("TEXT32")));
    }
    
    $opid = $alliance2['alliance_id'];

    if($alliance2['alliance_id']==$game->player['user_alliance']) {
        message(NOTICE, constant($game->sprache("TEXT33")));
    }

    $sql = 'SELECT ad_id
            FROM alliance_diplomacy
            WHERE (alliance1_id = '.$opid.' AND alliance2_id = '.$game->player['user_alliance'].') OR
                  (alliance2_id = '.$opid.' AND alliance1_id = '.$game->player['user_alliance'].')';
                  
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy data');
    }
    
    if(!empty($diplomacy['ad_id'])) {
        message(NOTICE, constant($game->sprache("TEXT34")));
    }
    
    $type = (int)$_POST['type'];
    
    if(!in_array($type, array(1, 2, 3))) {
        message(GENERAL, 'Invalid Code-Type', '$type = '.$type);
    }
    
    switch($type) {
        case ALLIANCE_DIPLOMACY_WAR:

       if($alliance['alliance_points']<=500 || $alliance['alliance_member']<=5) {
           message(NOTICE, constant($game->sprache("TEXT82")));
       }

            $sql = 'INSERT INTO alliance_diplomacy (alliance1_id, alliance2_id, type, date, status)
                    VALUES ('.$game->player['user_alliance'].', '.$opid.', '.ALLIANCE_DIPLOMACY_WAR.', '.$game->TIME.', 0)';
                
	$sql2 = "SELECT user_id FROM user WHERE user_alliance = $opid";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	
	$sender = 0;
	$betreff = constant($game->sprache("TEXT35"));
	
	$selected_alliance = $game->player['user_alliance']; 

	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	
	if(($alliances = $db->queryrow($sql3)) === false) {
        message(DATABASE_ERROR, 'Alliance name could not be read - War Declaration text');
    	}	

	$text = constant($game->sprache("TEXT36")).$alliances['alliance_name'].constant($game->sprache("TEXT37")); 

	$act_time = time();

	while ($row = mysql_fetch_assoc($result2)) {
    	  foreach ($row as $key => $reciever) {
 
    
    	$sql4 = "INSERT INTO message (sender, receiver, subject, text, time) VALUES ('$sender', '$reciever', '$betreff', '$text', '$act_time')";
        	$result4 = mysql_query($sql4);

    	$sql5 = "UPDATE user SET unread_messages = 1 WHERE user_id = '$reciever'";
        	$result5 = mysql_query($sql5);

   	  }
	}

	break;	

        case ALLIANCE_DIPLOMACY_NAP:
        case ALLIANCE_DIPLOMACY_PACT:
            $sql = 'INSERT INTO alliance_diplomacy (alliance1_id, alliance2_id, type, date, status)
                    VALUES ('.$game->player['user_alliance'].', '.$opid.', '.$type.', 0, -1)';
	
       $sql2 = "SELECT user_id FROM user WHERE user_alliance = $opid AND user_alliance_status >= 3";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	
	$sender = 0;

	$selected_alliance = $game->player['user_alliance']; 

	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	
	if(($alliances = $db->queryrow($sql3)) === false) {
        message(DATABASE_ERROR, 'Alliance name could not be read - Alliance / NAP text');
    	}

	if($type==ALLIANCE_DIPLOMACY_NAP) {

	$betreff = constant($game->sprache("TEXT38"));

	$text = constant($game->sprache("TEXT36")).$alliances['alliance_name'].constant($game->sprache("TEXT83")).$alliances['alliance_name'].constant($game->sprache("TEXT84")); 

	}

	else {

	$betreff = constant($game->sprache("TEXT85"));

	$text = constant($game->sprache("TEXT36")).$alliances['alliance_name'].constant($game->sprache("TEXT86")).$alliances['alliance_name'].constant($game->sprache("TEXT84")); 

	}

	$act_time = time();

	while ($row = mysql_fetch_assoc($result2)) {
    	  foreach ($row as $key => $reciever) {
 
    
    	$sql4 = "INSERT INTO message (sender, receiver, subject, text, time) VALUES ('$sender', '$reciever', '$betreff', '$text', '$act_time')";
        	$result4 = mysql_query($sql4);

    	$sql5 = "UPDATE user SET unread_messages = 1 WHERE user_id = '$reciever'";
        	$result5 = mysql_query($sql5);

   	  }
	}

        break;
    }
    
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not insert new diplomacy data');
    }
    
    redirect('a=alliance_diplomacy&details='.$db->insert_id());
}
elseif(isset($_GET['new'])) {
    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="430" align="left"><a href="'.parse_link('a=alliance_diplomacy').'">'.constant($game->sprache("TEXT39")).'</a> &raquo; '.constant($game->sprache("TEXT40")).'</td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey">
        <form method="post" action="'.parse_link('a=alliance_diplomacy').'">
        <tr>
          <td align="center">'.constant($game->sprache("TEXT41")).'<input class="field" type="text" name="alliance2_tag" maxlength="6" size="10"></td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td align="center">
            <select name="type">
              <option value="2">'.constant($game->sprache("TEXT42")).'</option>
              <option value="3">'.constant($game->sprache("TEXT43")).'</option>
              <option value="1">'.constant($game->sprache("TEXT44")).'</option>
            </select>
          </td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td align="center">
            <input class="button" type="button" value="'.constant($game->sprache("TEXT45")).'" onClick="return window.history.back();">  
            <input class="button" type="submit" name="new_submit" value="'.constant($game->sprache("TEXT46")).'">
          </td>
        </tr>
      </table>
    </td>
  </form>
</table>
    ');
}
elseif(!empty($_GET['details'])) {
    if($game->player['user_alliance_rights5'] != 1 && $game->player['user_id'] != $alliance['alliance_owner']) {
        message(NOTICE, constant($game->sprache("TEXT2")));
    }

    $ad_id = (int)$_GET['details'];

    $sql = 'SELECT d.*,
                   a1.alliance_name AS alliance1_name,
                   a2.alliance_name AS alliance2_name
            FROM (alliance_diplomacy d)
            INNER JOIN (alliance a1) ON a1.alliance_id = d.alliance1_id
            INNER JOIN (alliance a2) ON a2.alliance_id = d.alliance2_id
            WHERE d.ad_id = '.$ad_id;
            
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance diplomacy data');
    }
    
    if(empty($diplomacy['ad_id'])) {
        message(NOTICE, constant($game->sprache("TEXT47")));
    }

    $mpid = get_mpid($diplomacy['alliance1_id']);
    $opid = get_opid($diplomacy['alliance1_id']);

    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="430" align="left"><a href="'.parse_link('a=alliance_diplomacy').'">'.constant($game->sprache("TEXT39")).'</a> &raquo; <i>'.$diplomacy['alliance'.$opid.'_name'].'</i></td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey"><tr><td>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="150">'.constant($game->sprache("TEXT48")).'</td>
    ');
    
    switch($diplomacy['type']) {
        case ALLIANCE_DIPLOMACY_WAR:
            $game->out('
            <td width="150"><span style="color: #FF0000;">'.constant($game->sprache("TEXT49")).'</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">'.constant($game->sprache("TEXT50")).'</td>
            <td width="150"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance1_id']).'">'.$diplomacy['alliance1_name'].'</a></td>
          </tr>
        </table>
        <br>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            ');
            
            switch($diplomacy['status']) {
                case 0:
                    $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=suggest_peace&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT51")).'</a>]</td></tr>');
                break;
                
                case $mpid:
                    $game->out('
        <tr><td>'.constant($game->sprache("TEXT52")).'</td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT53")).'</a>]</td></tr>
                    ');
                break;

                case $opid:
                    $game->out('
        <tr><td>'.constant($game->sprache("TEXT54")).'<a href="javascript:void(0)">'.$diplomacy['alliance'.$opid.'_name'].'</a></td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT55")).'</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT56")).'</a>]</td></tr>
                    ');
                break;
                
                default:
                    message(GENERAL, 'Invalid Status-Code', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                break;
            }
            
            $game->out('</table>');
        break;
        
        case ALLIANCE_DIPLOMACY_NAP:
            $game->out('
            <td width="150"><span style="color: #FFFF00;">'.constant($game->sprache("TEXT38")).'</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">'.constant($game->sprache("TEXT57")).'</td>
            <td width="150"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance1_id']).'">'.$diplomacy['alliance1_name'].'</a></td>
          </tr>
        </table>
        <br>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            ');

            switch($diplomacy['status']) {
                case -1:
                    if($mpid == 1) {
                        $game->out('
          <tr><td>'.constant($game->sprache("TEXT58")).'</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT53")).'</a>]</td></tr>
                        ');
                    }
                    else {
                        $game->out('
          <tr><td>'.constant($game->sprache("TEXT59")).'</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT55")).'</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT56")).'</a>]</td></tr>
                        ');
                    }
                break;

                case 0:
                    $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=break&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT60")).'</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=suggest_pact&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT61")).'</a>]</td></tr>');
                break;
                
                case $mpid:
                    $game->out('
        <tr><td>'.constant($game->sprache("TEXT62")).'</td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT53")).'</a>]</td></tr>
                    ');
                break;
                
                case $opid:
                    $game->out('
        <tr><td>'.constant($game->sprache("TEXT63")).'<a href="javascript:void(0)">'.$diplomacy['alliance'.$opid.'_name'].'</a></td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT55")).'</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT56")).'</a>]</td></tr>
                    ');
                break;
            }

            $game->out('</table>');
        break;
        
        case ALLIANCE_DIPLOMACY_PACT:
            $game->out('
            <td width="150"><span style="color: #00FF00;">'.constant($game->sprache("TEXT64")).'</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">'.constant($game->sprache("TEXT65")).'</td>
            <td width="150"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance1_id']).'">'.$diplomacy['alliance1_name'].'</a></td>
          </tr>
        </table>
        <br>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            ');
            
            if($diplomacy['status'] == -1) {
                if($mpid == 1) {
                    $game->out('
          <tr><td>'.constant($game->sprache("TEXT58")).'</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT53")).'</a>]</td></tr>
                    ');
                }
                else {
                    $game->out('
          <tr><td>'.constant($game->sprache("TEXT59")).'</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT55")).'</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT56")).'</a>]</td></tr>
                    ');
                }
            }
            else {
                $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=break&ad_id='.$ad_id).'">'.constant($game->sprache("TEXT60")).'</a>]</td></tr>');
            }
            
            $game->out('</table>');
        break;
    }
    
    $game->out('
      </td></tr></table>
    </td>
  </tr>
</table>
    ');
}
else {
    $sql = 'SELECT d.*,
                   a1.alliance_name AS alliance1_name,
                   a2.alliance_name AS alliance2_name
            FROM (alliance_diplomacy d)
            INNER JOIN (alliance a1) ON a1.alliance_id = d.alliance1_id
            INNER JOIN (alliance a2) ON a2.alliance_id = d.alliance2_id
            WHERE d.alliance1_id = '.$game->player['user_alliance'].' OR
                  d.alliance2_id = '.$game->player['user_alliance'].'
            ORDER BY ad_id DESC';
                  
    if(!$q_diplomacy = $db->query($sql)) {
        message(DATABASE_ERROR, 'Could not query alliance diplomacy data');
    }

    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="430" align="left">'.constant($game->sprache("TEXT39")).'</td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey">
        <tr>
    ');
 
   
    if($game->player['user_alliance_rights5'] == 1 || $game->player['user_id'] == $alliance['alliance_owner']) {
        $game->out('
          <td width="20"> </td>
          <td width="210">'.constant($game->sprache("TEXT66")).'</td>
        ');
    }
    else {
        $game->out('<td width="230">'.constant($game->sprache("TEXT66")).'</td>');
    }

    $game->out('
          <td width="90" align="center">'.constant($game->sprache("TEXT67")).'</td>
          <td width="110" align="center">'.constant($game->sprache("TEXT68")).'</td>
        </tr>
    ');
    
    while($diplomacy = $db->fetchrow($q_diplomacy)) {
        $ap = ($diplomacy['alliance1_id'] == $game->player['user_alliance']) ? 2 : 1;
        
        switch($diplomacy['type']) {
            case ALLIANCE_DIPLOMACY_WAR:
                $type_str = '<span style="color: #FF0000;">'.constant($game->sprache("TEXT49")).'</span>';
            break;

            case ALLIANCE_DIPLOMACY_NAP:
                $type_str = '<span style="color: #FFFF00;">'.constant($game->sprache("TEXT69")).'</span>';
            break;

            case ALLIANCE_DIPLOMACY_PACT:
                $type_str = '<span style="color: #00FF00;">'.constant($game->sprache("TEXT64")).'</span>';
            break;
        }
        
        if($game->player['user_alliance_rights5'] == 1 || $game->player['user_id'] == $alliance['alliance_owner']) {
            $game->out('
       <tr>
         <td width="20">[<a href="'.parse_link('a=alliance_diplomacy&details='.$diplomacy['ad_id']).'">D</a>]</td>
         <td width="210"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance'.$ap.'_id']).'">'.$diplomacy['alliance'.$ap.'_name'].'</a></td>
         <td width="90" align="center">'.$type_str.'</td>
         <td width="110" align="center">'.( ($diplomacy['status'] != -1) ? date('d.m.y', $diplomacy['date']) : constant($game->sprache("TEXT70")) ).'</td>
       </tr>
            ');
       }
       else {
            $game->out('
       <tr>
         <td width="230"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance'.$ap.'_id']).'">'.$diplomacy['alliance'.$ap.'_name'].'</a></td>
         <td width="90" align="center">'.$type_str.'</td>
         <td width="110" align="center">'.( ($diplomacy['status'] != -1) ? date('d.m.y', $diplomacy['date']) : constant($game->sprache("TEXT70")) ).'</td>
       </tr>
            ');
       }
    }
    
    $game->out('
    ');
    
    if($game->player['user_alliance_rights5'] == 1 || $game->player['user_id'] == $alliance['alliance_owner']) {
        $game->out('
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="430" align="right">[<a href="'.parse_link('a=alliance_diplomacy&new').'">'.constant($game->sprache("TEXT71")).'</a>]</td></tr>
      </table>
    </td>
  </tr>
</table>
<br>
'.constant($game->sprache("TEXT72")).'
<br>
        ');
    }
    else {
        $game->out('
      </table>
    </td>
  </tr>
</table>
        ');
    }
}

?>
