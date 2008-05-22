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
$game->out('

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function flevToggleCheckboxes() { // v1.1
	// Copyright 2002, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
	var sF = arguments[0], bT = arguments[1], bC = arguments[2], oF = MM_findObj(sF);
    for (var i=0; i<oF.length; i++) {
		if (oF[i].type == "checkbox") {if (bT) {oF[i].checked = !oF[i].checked;} else {oF[i].checked = bC;}}} 
}
//-->

</script>


');
function logbook_pagination($start, $n_count, $n_per_page) {
    $page_html = '';

    $n_pages = ceil($n_count / $n_per_page);
    $current_page = ($start > 0) ? ( ($start / $n_per_page) + 1) : 1;
    $next_start = 0;

    if($current_page > 1) {
        $page_html .= '[<a href="'.parse_link('a=logbook').'">Erste Seite</a>]&nbsp;';
        $page_html .= '[<a href="'.parse_link('a=logbook&start='.($start - $n_per_page) ).'">Vorherige Seite</a>]&nbsp;';
    }

    for($i = 1; $i <= $n_pages; ++$i) {
        if($i == $current_page) {
            $page_html .= '['.$i.']&nbsp;';
        }
        else {
            $page_html .= '[<a href="'.parse_link('a=logbook&start='.$next_start).'">'.$i.'</a>]&nbsp;';
        }

        $_div = ($i / 10);

        if($_div == (int)$_div) {
            $page_html .= '<br>';
        }

        $next_start = ($next_start + $n_per_page);
    }

    if($current_page < $n_pages) {
        $page_html .= '[<a href="'.parse_link('a=logbook&start='.($start + $n_per_page) ).'">Nächste Seite</a>]&nbsp;';
        $page_html .= '[<a href="'.parse_link('a=logbook&start='.(($n_pages - 1) * $n_per_page) ).'">Letzte Seite</a>]';
    }

    return $page_html;
}

function update_unread_count() {
    global $game, $db;

    if($game->player['unread_log_entries'] == 0) return true;

    $sql = 'SELECT COUNT(log_id) AS n_logs
            FROM logbook
            WHERE user_id = '.$game->player['user_id'].' AND
                  log_read = 0';
                  
    if(($unread_count = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query unread log data');
    }

    $unread_logs = (int)$unread_count['n_logs'];

    if($unread_logs != $game->player['unread_log_entries']) {
        $sql = 'UPDATE user
                SET unread_log_entries = '.$unread_logs.'
                WHERE user_id = '.$game->player['user_id'];
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update user unread log entries data');
        }
    }
    
    return true;
}

$LOGS_PER_PAGE = 15;

$game->out('<center><span class="caption">Logbuch:</span><br>');

if(isset($_GET['show_log'])) {
    $log_id = (int)$_GET['show_log'];

    $sql = 'SELECT *
            FROM logbook
            WHERE log_id = '.$log_id;

    if(($log = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query logbook data');
    }

    if(empty($log['log_id'])) {
        message(NOTICE, 'Der gewählte Logeintrag existiert nicht');
    }

    if($log['user_id'] != $game->player['user_id']) {
        message(NOTICE, 'Der gewählte Logeintrag existiert nicht');
    }

    if($log['log_read'] == 0) {
        $sql = 'UPDATE logbook
                SET log_read = 1
                WHERE log_id = '.$log_id;
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not mark log entry as read');
        }
        
        $sql = 'UPDATE user
                SET unread_log_entries = unread_log_entries - 1
                WHERE user_id = '.$game->player['user_id'];
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update user unread log entries data');
        }
    }

    $sql = 'SELECT log_id
            FROM logbook
            WHERE user_id = '.$game->player['user_id'].'
            ORDER BY log_date DESC';
            
    if(($all_logs = $db->queryrowset($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query all log data');
    }

    $n_logs = count($all_logs);

    for($i = 0; $i < $n_logs; ++$i) {
        if($all_logs[$i]['log_id'] == $log['log_id']) {
            $on_i = $i;
            $previous_log = ($i == ($n_logs - 1)) ? 0 : $all_logs[($i + 1)]['log_id'];
            $next_log = ($i == 0) ? 0 : $all_logs[($i - 1)]['log_id'];
        }
    }

    if(!isset($on_i)) {
        message(GENERAL, 'Fehler bei der Seitenberechnung des Logbuchs', 'Unexspected: could not determine $on_i');
    }

    $on_page = ceil( ( ($on_i + 1) / $LOGS_PER_PAGE) );
    $on_page_start = ( ($on_page - 1) * $LOGS_PER_PAGE);
    
    $logbook_libs = array(
        LOGBOOK_TACTICAL => 'logbook_tactical',
        LOGBOOK_TACTICAL_2 => 'logbook_tactical',
        LOGBOOK_TACTICAL_SHIPFIGHT => 'logbook_shipfight',
        LOGBOOK_UDIPLOMACY => 'logbook_udiplomacy',
        LOGBOOK_ALLIANCE => 'logbook_alliance',
        LOGBOOK_GOVERNMENT => 'logbook_government',
        LOGBOOK_AUCTION_VENDOR => 'logbook_auction_vendor',
        LOGBOOK_AUCTION_PURCHASER => 'logbook_auction_purchaser',
        LOGBOOK_FERENGITAX => 'logbook_ferengitax',
        LOGBOOK_REVOLUTION => 'logbook_revolution',
        LOGBOOK_TACTICAL_SHIPFIGHT => 'logbook_shipfight'
    );
    //echo'include/libs/'.$logbook_libs[$log['log_type']].'.php';
    include('include/libs/'.$logbook_libs[$log['log_type']].'.php');
    
    //echo $logbook_libs[$log['log_type']];

    $log['log_data'] = unserialize($log['log_data']);
    display_logbook($log);

    if(!empty($previous_log)) {
        $game->out('<a href="'.parse_link('a=logbook&show_log='.$previous_log).'">[vorheriger Eintrag]</a>');
    }

    $game->out('<a href="'.parse_link('a=logbook&start='.$on_page_start).'">['.$on_page.']</a>');

    if(!empty($next_log)) {
        $game->out('<a href="'.parse_link('a=logbook&show_log='.$next_log).'">[nächster Eintrag]</a>');
    }

    $game->out('<br><br><center><a href="'.parse_link('a=logbook&delete_log='.$log_id).'">Eintrag löschen</a></center>');
}
elseif(!empty($_POST['read_submit'])) {
    if(empty($_POST['log_id'])) {
        message(NOTICE, 'Es wurde kein Logbuch-Eintrag ausgewählt');
    }

    $n_logs = count($_POST['log_id']);

    if($n_logs == 0) {
        message(NOTICE, 'Kein Eintrag ausgewählt');
    }
    elseif($n_logs == 1) {
        $id_where_string = '= '.(int)$_POST['log_id'][0];
    }
    else {
    	for($i = 0; $i < $n_logs; ++$i) {
    		$_POST['log_id'][$i] = (int)$_POST['log_id'][$i];
    	}
    	
        $id_where_string = 'IN('.implode(',', $_POST['log_id']).')';
    }

    $sql = 'UPDATE logbook
            SET log_read = 1
            WHERE log_id '.$id_where_string.' AND
                  user_id = '.$game->player['user_id'];

    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not update logbook data');
    }

    update_unread_count();

    redirect('a=logbook');
}
elseif(!empty($_POST['delete_submit'])) {
    if(empty($_POST['log_id'])) {
        message(NOTICE, 'Es wurde kein Logbuch-Eintrag ausgewählt');
    }

    $n_logs = count($_POST['log_id']);

    if($n_logs == 0) {
        message(NOTICE, 'Kein Eintrag ausgewählt');
    }
    elseif($n_logs == 1) {
        $id_where_string = '= '.(int)$_POST['log_id'][0];
    }
    else {
        $id_where_string = 'IN('.addslashes(implode(',', $_POST['log_id'])).')';
    }

    $sql = 'DELETE FROM logbook
            WHERE log_id '.$id_where_string.' AND
                  user_id = '.$game->player['user_id'];
                  
    if(!$db->query($sql)) {
        message(DATABASE_ERROR, 'Could not delete logbook data');
    }
    
    update_unread_count();

    redirect('a=logbook');
}
elseif(isset($_GET['delete_log'])) {
    if($_GET['delete_log'] == 'all') {
        $sql = 'DELETE FROM logbook
                WHERE user_id = '.$game->player['user_id'];
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not delete logbook data');
        }
        
        update_unread_count();

        redirect('a=logbook');
    }
    else {
        $log_id = (int)$_GET['delete_log'];

        $sql = 'SELECT log_id, user_id, log_read
                FROM logbook
                WHERE log_id = '.$log_id;
                
        if(($log_entry = $db->queryrow($sql)) === false) {
            message(DATABASE_ERROR, 'Could not query logbook data');
        }
        
        if(empty($log_entry['log_id'])) {
            message(NOTICE, 'Der gewählte Logeintrag existiert nicht');
        }

        if($log_entry['user_id'] != $game->player['user_id']) {
            message(NOTICE, 'Der gewählte Logeintrag existiert nicht');
        }

        $sql = 'DELETE FROM logbook
                WHERE log_id = '.$log_id;
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not delete logbook data');
        }
        
        if($log_entry['log_read'] == 0) {
            $sql = 'UPDATE user
                    SET unread_log_entries = unread_log_entries - 1
                    WHERE user_id = '.$game->player['user_id'];
                    
            if(!$db->query($sql)) {
                message(DATABASE_ERROR, 'Could not update user unread log entries data');
            }
        }

        $to_start = (isset($_GET['start'])) ? '&start='.$_GET['start'] : '';

        redirect('a=logbook'.$to_start);
    }
}
elseif(isset($_GET['read_all_logs'])) {
    if($game->player['unread_log_entries'] > 0) {
        $sql = 'UPDATE logbook
                SET log_read = 1
                WHERE user_id = '.$game->player['user_id'];
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update logbook data');
        }
        
        $sql = 'UPDATE user
                SET unread_log_entries = 0
                WHERE user_id = '.$game->player['user_id'];
                
        if(!$db->query($sql)) {
            message(DATABASE_ERROR, 'Could not update user unread log entries data');
        }
    }

    redirect('a=logbook');
}
else {
    $start = (isset($_GET['start'])) ? $_GET['start'] : 0;
    settype($start, 'int');

    $sql = 'SELECT COUNT(log_id) AS log_id_count
            FROM logbook
            WHERE user_id = '.$game->player['user_id'];
            
    if(($_n_logs = $db->queryrow($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query logbook count data');
    }

    $n_logs = $_n_logs['log_id_count'];

    if($n_logs == 0) {
        message(NOTICE, 'Keine Logbucheinträge vorhanden');
    }

    $sql = 'SELECT log_id, log_type, log_date, log_read, log_title
            FROM logbook
            WHERE user_id = '.$game->player['user_id'].'
            ORDER BY log_id DESC
            LIMIT '.$start.', '.$LOGS_PER_PAGE;
            
    if(($q_logs = $db->query($sql)) === false) {
        message(DATABASE_ERROR, 'Could not query logbook data');
    }

    if($start >= $n_logs) {
        $start = ($n_logs - $LOGS_PER_PAGE);
    }
    
    $log_types = array(
        LOGBOOK_TACTICAL => 'Takt.',
        LOGBOOK_TACTICAL_SHIPFIGHT => 'Takt.',
        LOGBOOK_UDIPLOMACY => 'Dipl.',
        LOGBOOK_ALLIANCE => 'Ally.',
        LOGBOOK_GOVERNMENT => 'Reg.',
        LOGBOOK_AUCTION_VENDOR => 'Auk.',
        LOGBOOK_AUCTION_PURCHASER => 'Auk.',
        LOGBOOK_FERENGITAX => 'Steuer',
		  LOGBOOK_TACTICAL_2 => 'Takt',
    );

    $game->out('
<br>
<table width="450" align="center" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <form method="post" action="'.parse_link('a=logbook').'" name="logbook">
  <tr>
    <td width="280"><b>Eintrag</b></td>
    <td width="40"><b>Typ</b></td>
    <td width="115"><b>Zeit</b></td>
    <td width="15"><input name="check1" type="checkbox" onClick="flevToggleCheckboxes(\'logbook\',true,false)" value="Check All"></td>
  </tr>
  <tr height="2"><td></td></tr>
    ');

    while($log_entry = $db->fetchrow($q_logs)) {
        if($log_entry['log_read'] == 1) {
            $read_start = $read_end = '';
        }
        else {
            $read_start = '<span style="color: #FFFF00; font-weight: bold;">';
            $read_end = '</span>';
        }

        $game->out('
  <tr>
    <td><a href="'.parse_link('a=logbook&show_log='.$log_entry['log_id']).'">'.$read_start.$log_entry['log_title'].$read_end.'</a></td>
    <td>'.$log_types[$log_entry['log_type']].'</td>
    <td>'.date('d.m.y H:i:s', $log_entry['log_date']+TIME_OFFSET).'</td>
    <td align="center"><input type="checkbox" name="log_id[]" value="'.$log_entry['log_id'].'"></td>
  </tr>
        ');
    }

    $game->out('
</table>
<br>
<table align="center" width="450" border="0" cellpadding="2" cellspacing="2" background="'.$game->GFX_PATH.'template_bg3.jpg" class="border_grey">
  <tr>
    <td width="120" align="left"><b>gewählte Einträge</b></td>
    <td width="330" align="right"><input class="button" type="submit" name="read_submit" value="als gelesen markieren">&nbsp;&nbsp;<input class="button" type="submit" name="delete_submit" value="Löschen"></td>
  </tr>
  </form>
</table>
<br>
    '.logbook_pagination($start, $n_logs, $LOGS_PER_PAGE)).'</form>';

    $game->out('<br><br><a href="'.parse_link('a=logbook&delete_log=all').'">Alle Einträge löschen</a>');

    if($game->player['unread_log_entries'] > 0) {
        $game->out('<br><a href="'.parse_link('a=logbook&read_all_logs=1').'">Alle Einträge als gelesen markieren</a>');
    }
}

?>
