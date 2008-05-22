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
$game->out('<center><span class="caption">Allianz:</span><br><br>');



if(empty($game->player['alliance_name'])) {
    message(NOTICE, 'Du bist nicht Mitglied einer Allianz');
}

    $sql = 'SELECT *
            FROM alliance
            WHERE alliance_id = '.$game->player['user_alliance'];

    if(($alliance = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance data');
    }


if(!empty($_GET['do'])) {
    if($game->player['user_alliance_rights5'] != 1) {
        message(NOTICE, 'Du besitzt nicht die erforderlichen Rechte für diese Aktion.');
    }
    
    if(empty($_GET['ad_id'])) {
        message(GENERAL ,'Ungültiger Aufruf', '$_GET[\'ad_id\'] == empty');
    }
    
    $ad_id = (int)$_GET['ad_id'];

    $sql = 'SELECT *
            FROM alliance_diplomacy
            WHERE ad_id = '.$ad_id;
            
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query alliance diplomacy data');
    }

    if(empty($diplomacy['ad_id'])) {
        message(NOTICE, 'Deine Allianz ist nicht Teil dieses Vertrages');
    }

    if( ($diplomacy['alliance1_id'] != $game->player['user_alliance']) && ($diplomacy['alliance2_id'] != $game->player['user_alliance']) ) {
        message(NOTICE, 'Deine Allianz hat mit der Allianz keine diplomatische Beziehung');
    }
    
    $mpid = get_mpid($diplomacy['alliance1_id']);
    $opid = get_opid($diplomacy['alliance1_id']);

    switch($_GET['do']) {
        case 'accept':
            switch($diplomacy['type']) {
                case ALLIANCE_DIPLOMACY_WAR:
                    switch($diplomacy['status']) {
                        case 0:
                            message(NOTICE, 'Ein Krieg kann nicht "akzeptiert" werden');
                        break;

                        case $mpid:
                            message(NOTICE, 'Deine Allianz kann nicht akzeptieren, da sie das Friedensangebot gestellt hat');
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
        message(DATABASE_ERROR, 'Alliance Name konnte nicht gelesen werden - Bündnis/NAP Text');
    	}

	$betreff = 'Friedensvertrag unterzeichnet';
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
		$text = 'Die Allianz <b>'.$ally_one.'</b> hat soeben mit der Allianz <b>'.$ally_two.'</b> <b><font color="white">Frieden</font></b> geschlossen. Näheres bei der Führung deiner Allianz.'; 
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
                                message(NOTICE, 'Deine Allianz kann nicht akzeptieren, da sie den Nichtangriffspakt angeboten hat');
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
        message(DATABASE_ERROR, 'Alliance Name konnte nicht gelesen werden - Bündnis/NAP Text');
    	}

	$betreff = 'Nichtangriffspakt unterzeichnet';
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
	$text = 'Es wurde zwischen der Allianz <b>'.$ally_one.'</b> und der Allianz <b>'.$ally_two.'</b> ein <b><font color="yellow">Nichtsangriffpakt</font></b> geschlossen. Näheres bei der Führung deiner Allianz.'; 
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
                            message(NOTICE, 'Der Nichtangriffspakt wurde schon unterzeichnet');
                        break;
                        
                        case $mpid:
                            message(NOTICE, 'Deine Allianz kann nicht akzeptieren, da sie das Bündnis vorgeschlagen hat');
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
                        message(NOTICE, 'Das Bündnis wurde schon unterzeichnet');
                    }
                    
                    if($mpid == 1) {
                        message(NOTICE, 'Deine Allianz kann nicht akzeptieren, da sie das Bündnis vorgeschlagen hat');
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
        message(DATABASE_ERROR, 'Alliance Name konnte nicht gelesen werden - Bündnis/NAP Text');
    	}

	$betreff = 'Bündnisvertrag unterzeichnet';
	$sql6=mysql_query($sql6);
	while ($werte=mysql_fetch_assoc($sql6)) {
	if($ally_one==$werte['alliance_id'])$ally_one=$werte['alliance_name'];
	if($ally_two==$werte['alliance_id'])$ally_two=$werte['alliance_name'];
	}
	$text = 'Es wurde zwischen der Allianz <b>'.$ally_one.'</b> und der Allianz <b>'.$ally_two.'</b> ein <b><font color="green">Bündnis</font></b> geschlossen. Näheres bei der Führung deiner Allianz.'; 
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
                            message(NOTICE, 'Ein Krieg kann nicht "abgelehnt" werden');
                        break;

                        case $mpid:
                            message(NOTICE, 'Deine Allianz kann nicht ablehnen, da sie das Friedensangebot gestellt hat');
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
                                message(NOTICE, 'Deine Allianz kann nicht ablehnen, da sie den Nichtangriffspakt angeboten hat');
                            }

                            $sql = 'DELETE FROM alliance_diplomacy
                                    WHERE ad_id = '.$ad_id;


                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy');
                        break;

                        case 0:
                            message(NOTICE, 'Der Nichtangriffspakt wurde schon unterzeichnet');
                        break;

                        case $mpid:
                            message(NOTICE, 'Deine Allianz kann nicht ablehnen, da sie das Bündnis vorgeschlagen hat');
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
                        message(NOTICE, 'Das Bündnis wurde schon unterzeichnet');
                    }

                    if($mpid == 1) {
                        message(NOTICE, 'Deine Allianz kann nicht ablehnen, da sie das Bündnis vorgeschlagen hat');
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
                            message(NOTICE, 'Es existiert kein Friedensagebot');
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
                            message(NOTICE, 'Deine Allianz kann nicht zurückziehen, da ihr das Angebot gestellt wurde');
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
                                message(NOTICE, 'Deine Allianz kann nicht zurückziehen, da ihr der Nichtangriffspakt angeboten wurde');
                            }

                            $sql = 'DELETE FROM alliance_diplomacy
                                    WHERE ad_id = '.$ad_id;

                            if(!$db->query($sql)) {
                                message(DATABASE_ERROR, 'Could not delete alliance diplomacy data');
                            }

                            redirect('a=alliance_diplomacy');
                        break;

                        case 0:
                            message(NOTICE, 'Der Nichtangriffspakt wurde schon unterzeichnet');
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
                            message(NOTICE, 'Deine Allianz kann nicht zurückziehen, da ihr das Bündnis vorgeschlagen wurde');
                        break;

                        default:
                            message(GENERAL, 'Unknown diplomacy status', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                        break;
                    }
                break;

                case ALLIANCE_DIPLOMACY_PACT:
                    if($diplomacy['status'] =! -1) {
                        message(NOTICE, 'Das Bündnis wurde schon unterzeichnet');
                    }

                    if($mpid == 0) {
                        message(NOTICE, 'Deine Allianz kann nicht zurückziehen, da ihr das Bündnis vorgeschlagen wurde');
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
                message(NOTICE, 'Ein Krieg kann nicht "gebrochen" werden');
            }

            if($diplomacy['status'] == -1) {
                message(NOTICE, 'Der Vertrag wurde noch nicht unterzeichnet');
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
                message(NOTICE, 'Deine Allianz befindet sich nicht im Krieg mit der Allianz');
            }
            
            if($diplomacy['status'] != 0) {
                message(NOTICE, 'Es existiert bereits ein Friedensangebot');
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
                message(NOTICE, 'Deine Allianz hat keinen Nichtangriffspakt mit der anderen Allianz geschlossen');
            }
            
            if($diplomacy['status'] == -1) {
                message(NOTICE, 'Der Nichtangriffspakt wurde noch nicht unterzeichnet');
            }
            elseif($diplomacy['status'] != 0) {
                message(NOTICE, 'Es existiert bereits ein Bündnisangebot');
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
        message(NOTICE, 'Du besitzt nicht die erforderlichen Rechte für diese Aktion.');
    }

    if(empty($_POST['alliance2_tag'])) {
        message(NOTICE, 'Keine Allianz angegeben');
    }
    
    $alliance2_tag = addslashes($_POST['alliance2_tag']);
    
    $sql = 'SELECT alliance_id
            FROM alliance
            WHERE alliance_tag = "'.$alliance2_tag.'"';
            
    if(($alliance2 = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query other party´s alliance data');
    }
    
    if(empty($alliance2['alliance_id'])) {
        message(NOTICE, 'Die andere Allianz konnte nicht gefunden werden');
    }
    
    $opid = $alliance2['alliance_id'];

    if($alliance2['alliance_id']==$game->player['user_alliance']) {
        message(NOTICE, 'Du kannst keine Verträge mit deiner eigenen Ally schließen.');
    }

    $sql = 'SELECT ad_id
            FROM alliance_diplomacy
            WHERE (alliance1_id = '.$opid.' AND alliance2_id = '.$game->player['user_alliance'].') OR
                  (alliance2_id = '.$opid.' AND alliance1_id = '.$game->player['user_alliance'].')';
                  
    if(($diplomacy = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query diplomacy data');
    }
    
    if(!empty($diplomacy['ad_id'])) {
        message(NOTICE, 'Deine Allianz steht bereits in Kontakt mit dieser Allianz');
    }
    
    $type = (int)$_POST['type'];
    
    if(!in_array($type, array(1, 2, 3))) {
        message(GENERAL, 'Ungültiger Typ-Code', '$type = '.$type);
    }
    
    switch($type) {
        case ALLIANCE_DIPLOMACY_WAR:

       if($alliance['alliance_points']<=500 || $alliance['alliance_member']<=5) {
           message(NOTICE, '1. Mann Allianzen die Kriegserklärungen spamen sind doof!');
       }

            $sql = 'INSERT INTO alliance_diplomacy (alliance1_id, alliance2_id, type, date, status)
                    VALUES ('.$game->player['user_alliance'].', '.$opid.', '.ALLIANCE_DIPLOMACY_WAR.', '.$game->TIME.', 0)';
                
	$sql2 = "SELECT user_id FROM user WHERE user_alliance = $opid";
	$result2 = mysql_query($sql2) OR die(mysql_error());
	
	$sender = 0;
	$betreff = 'Kriegserklärung';
	
	$selected_alliance = $game->player['user_alliance']; 

	$sql3 = "SELECT alliance_name FROM alliance WHERE alliance_id = $selected_alliance";
	
	if(($alliances = $db->queryrow($sql3)) === false) {
        message(DATABASE_ERROR, 'Alliance Name konnte nicht gelesen werden - Kriegserklärung Text');
    	}	

	$text = 'Die Allianz <b>'.$alliances['alliance_name'].'</b> hat ihnen soeben den <b><font color="red">Krieg</font></b> erklärt.'; 

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
        message(DATABASE_ERROR, 'Alliance Name konnte nicht gelesen werden - Bündnis/NAP Text');
    	}

	if($type==ALLIANCE_DIPLOMACY_NAP) {

	$betreff = 'Nichtangriffspakt';

	$text = 'Die Allianz <b>'.$alliances['alliance_name'].'</b> hat ihnen soeben ein Angebot über einen <b><font color="yellow">Nichtangriffspakt</font></b> vorgelegt.<br>Näheres Erfahren sie in ihrer Diplomatie oder bei der Führung der <b>'.$alliances['alliance_name'].'</b> selbst.'; 

	}

	else {

	$betreff = 'Bündnisvorschlag';

	$text = 'Die Allianz <b>'.$alliances['alliance_name'].'</b> hat ihnen soeben ein Angebot über ein <b><font color="green">Bündnis</font></b> vorgelegt.<br>Näheres Erfahren sie in ihrer Diplomatie oder bei der Führung der <b>'.$alliances['alliance_name'].'</b> selbst.'; 

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
        <tr><td width="430" align="left"><a href="'.parse_link('a=alliance_diplomacy').'"><i>Diplomatie</i></a> » <i>In Kontakt treten</i></td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey">
        <form method="post" action="'.parse_link('a=alliance_diplomacy').'">
        <tr>
          <td align="center">Allianz-Tag:  <input class="field" type="text" name="alliance2_tag" maxlength="6" size="10"></td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td align="center">
            <select name="type">
              <option value="2">Nichtangriffspakt vorschlagen</option>
              <option value="3">Bündnis vorschlagen</option>
              <option value="1">Krieg erklären</option>
            </select>
          </td>
        </tr>
        <tr height="5"><td></td></tr>
        <tr>
          <td align="center">
            <input class="button" type="button" value="<< Zurück" onClick="return window.history.back();">  
            <input class="button" type="submit" name="new_submit" value="Bestätigen">
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
        message(NOTICE, 'Du besitzt nicht die erforderlichen Rechte für diese Aktion.');
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
        message(NOTICE, 'Deine Allianz hat mit der gewählten Allianz keine diplomatische Beziehung');
    }

    $mpid = get_mpid($diplomacy['alliance1_id']);
    $opid = get_opid($diplomacy['alliance1_id']);

    $game->out('
<table width="450" align="center" border="0" cellpadding="2" cellspacing="4" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td align="center">
      <span style="font-size: 12pt; font-weight: bold;">'.$game->player['alliance_name'].' ['.$game->player['alliance_tag'].']</span><br><br>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2">
        <tr><td width="430" align="left"><a href="'.parse_link('a=alliance_diplomacy').'"><i>Diplomatie</i></a> »  <i>'.$diplomacy['alliance'.$opid.'_name'].'</i></td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey"><tr><td>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="150" >aktueller Status:</td>
    ');
    
    switch($diplomacy['type']) {
        case ALLIANCE_DIPLOMACY_WAR:
            $game->out('
            <td width="150"><span style="color: #FF0000;">Krieg</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">angefangen von:</td>
            <td width="150"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance1_id']).'">'.$diplomacy['alliance1_name'].'</a></td>
          </tr>
        </table>
        <br>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            ');
            
            switch($diplomacy['status']) {
                case 0:
                    $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=suggest_peace&ad_id='.$ad_id).'">Frieden anbieten</a>]</td></tr>');
                break;
                
                case $mpid:
                    $game->out('
        <tr><td>Friedensangebot von deiner Allianz</td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">Zurückziehen</a>]</td></tr>
                    ');
                break;

                case $opid:
                    $game->out('
        <tr><td>Friedensangebot von <a href="javascript:void(0)">'.$diplomacy['alliance'.$opid.'_name'].'</a></td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">Annehmen</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">Ablehnen</a>]</td></tr>
                    ');
                break;
                
                default:
                    message(GENERAL, 'Ungültiger Status-Code', '$diplomacy[\'status\'] = '.$diplomacy['status']);
                break;
            }
            
            $game->out('</table>');
        break;
        
        case ALLIANCE_DIPLOMACY_NAP:
            $game->out('
            <td width="150"><span style="color: #FFFF00;">Nichtangriffspakt</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">vorgeschlagen von:</td>
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
          <tr><td>Angebot von deiner Allianz</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">Zurückziehen</a>]</td></tr>
                        ');
                    }
                    else {
                        $game->out('
          <tr><td>Angebot der anderen Allianz</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">Annehmen</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">Ablehnen</a>]</td></tr>
                        ');
                    }
                break;

                case 0:
                    $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=break&ad_id='.$ad_id).'">Vertrag brechen</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=suggest_pact&ad_id='.$ad_id).'">Bündnis anbieten</a>]</td></tr>');
                break;
                
                case $mpid:
                    $game->out('
        <tr><td>Bündnisangebot von deiner Allianz</td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">Zurückziehen</a>]</td></tr>
                    ');
                break;
                
                case $opid:
                    $game->out('
        <tr><td>Bündnisangebot von <a href="javascript:void(0)">'.$diplomacy['alliance'.$opid.'_name'].'</a></td></tr>
        <tr height="5"><td></td></tr>
        <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">Annehmen</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">Ablehnen</a>]</td></tr>
                    ');
                break;
            }

            $game->out('</table>');
        break;
        
        case ALLIANCE_DIPLOMACY_PACT:
            $game->out('
            <td width="150"><span style="color: #00FF00;">Bündnis</span></td>
          </tr>
          <tr height="5"><td colspan="2"></td></tr>
          <tr>
            <td width="150">vorgeschlagen von:</td>
            <td width="150"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance1_id']).'">'.$diplomacy['alliance1_name'].'</a></td>
          </tr>
        </table>
        <br>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            ');
            
            if($diplomacy['status'] == -1) {
                if($mpid == 1) {
                    $game->out('
          <tr><td>Angebot von deiner Allianz</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=cancel&ad_id='.$ad_id).'">Zurückziehen</a>]</td></tr>
                    ');
                }
                else {
                    $game->out('
          <tr><td>Angebot der anderen Allianz</td></tr>
          <tr height="5"><td></td></tr>
          <tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=accept&ad_id='.$ad_id).'">Annehmen</a>]  [<a href="'.parse_link('a=alliance_diplomacy&do=deny&ad_id='.$ad_id).'">Ablehnen</a>]</td></tr>
                    ');
                }
            }
            else {
                $game->out('<tr><td>[<a href="'.parse_link('a=alliance_diplomacy&do=break&ad_id='.$ad_id).'">Vertrag brechen</a>]</td></tr>');
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
        <tr><td width="430" align="left"><i>Diplomatie</i></td></tr>
      </table>
      <table width="430" align="center" border="0" cellpadding="2" cellspacing="2" class="border_grey">
        <tr>
    ');
 
   
    if($game->player['user_alliance_rights5'] == 1 || $game->player['user_id'] == $alliance['alliance_owner']) {
        $game->out('
          <td width="20"> </td>
          <td width="210"><b>andere Partei</b></td>
        ');
    }
    else {
        $game->out('<td width="230"><b>andere Partei</b></td>');
    }

    $game->out('
          <td width="90" align="center"><b>Vertrag</b></td>
          <td width="110" align="center"><b>besteht seit</b></td>
        </tr>
    ');
    
    while($diplomacy = $db->fetchrow($q_diplomacy)) {
        $ap = ($diplomacy['alliance1_id'] == $game->player['user_alliance']) ? 2 : 1;
        
        switch($diplomacy['type']) {
            case ALLIANCE_DIPLOMACY_WAR:
                $type_str = '<span style="color: #FF0000;">Krieg</span>';
            break;

            case ALLIANCE_DIPLOMACY_NAP:
                $type_str = '<span style="color: #FFFF00;">NAP</span>';
            break;

            case ALLIANCE_DIPLOMACY_PACT:
                $type_str = '<span style="color: #00FF00;">Bündnis</span>';
            break;
        }
        
        if($game->player['user_alliance_rights5'] == 1 || $game->player['user_id'] == $alliance['alliance_owner']) {
            $game->out('
       <tr>
         <td width="20">[<a href="'.parse_link('a=alliance_diplomacy&details='.$diplomacy['ad_id']).'">D</a>]</td>
         <td width="210"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance'.$ap.'_id']).'">'.$diplomacy['alliance'.$ap.'_name'].'</a></td>
         <td width="90" align="center">'.$type_str.'</td>
         <td width="110" align="center">'.( ($diplomacy['status'] != -1) ? date('d.m.y', $diplomacy['date']) : '<i>nicht unterzeichnet</i>' ).'</td>
       </tr>
            ');
       }
       else {
            $game->out('
       <tr>
         <td width="230"><a href="'.parse_link('a=stats&a2=viewalliance&id='.$diplomacy['alliance'.$ap.'_id']).'">'.$diplomacy['alliance'.$ap.'_name'].'</a></td>
         <td width="90" align="center">'.$type_str.'</td>
         <td width="110" align="center">'.( ($diplomacy['status'] != -1) ? date('d.m.y', $diplomacy['date']) : '<i>nicht unterzeichnet</i>' ).'</td>
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
        <tr><td width="430" align="right">[<a href="'.parse_link('a=alliance_diplomacy&new').'">Kontakt mit Allianz aufnehmen</a>]</td></tr>
      </table>
    </td>
  </tr>
</table>
<br>
<center>
<i>Legende:</i>   D = Details
</center>
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
