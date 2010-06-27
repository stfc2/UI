<?PHP
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

if ($user['right']==1) {include('forbidden.php'); return 1;}

$main_html .= '<span class=header>Caccia agli account doppi</span><br>';


if(isset($_REQUEST['name'])) {
    $sql = 'SELECT * FROM user WHERE user_name="'.htmlspecialchars($_REQUEST['name']).'"';
    $player=$db->queryrow($sql);
}


if (!isset($player['user_id']))
{
    $main_html .= '
<span class=header3><font color=green>Cerca giocatore</font></span><br>
<form method="post" action="index.php?p=multihunt">
<input type="text" name="name" value="'.$_POST['name'].'" class="field">
<input class="button" type="submit" name="submit" value="Cerca">
</form>';
    return 1;
}

$status='<font color=green>attivo</font>';
if ($player['user_active']==0) $status='<font color=red>bannato</font>';
if ($player['user_active']==2) $status='<font color=blue>non ancora attivato</font>';

$main_html .= '
<span class=header3><font color=green>Storico degli ultimi accessi all&#146;account del giocatore '.$player['user_name'].' ('.$status.'):</font></span><br><br>
<form method="post" action="index.php?p=user">
<table width="50%" border="1" cellpadding="2" cellspacing="2" class="border_grey">
<tr><td wisth="20%"><b>IP</b></td><td width="40%"><b>Data</b></td><td width="40%"><b>Nome utente / sitter</b></td></tr>';

$sql = 'SELECT * FROM user_iplog ip
        WHERE user_id='.$player['user_id'].' ORDER BY time DESC LIMIT 20';
$qry_user=$db->query($sql);

$sql = 'SELECT l.ip,l.time,u.user_name AS sitter
        FROM (user_sitter_iplog l) LEFT JOIN (user u) ON u.user_id = l.sitter_id
        WHERE l.user_id='.$player['user_id'].' ORDER BY time DESC LIMIT 20';
$qry_sitter=$db->query($sql);

$pick_u = true;
$pick_s = true;

while($pick_u || $pick_s) {
    // Fetch new line from the query only if needed at the moment
    if($pick_u) $iplog_u = $db->fetchrow($qry_user);
    if($pick_s) $iplog_s = $db->fetchrow($qry_sitter);

    // Check if both the list are still popolated
    if($iplog_u && $iplog_s) {
        // Check which one has the greater time
        if($iplog_u['time'] > $iplog_s['time']) {
            // Next look we keep the current sitter to examine
            $pick_s = false;
            $pick_u = true;

            $main_html .= '<tr><td>'.$iplog_u['ip'].'</td><td>'.date('d.m.y H:i', $iplog_u['time']).'</td><td>'.$player['user_name'].'</td></tr>';
        }
        else {
            // Next loop we keep the current user to examine
            $pick_u = false;
            $pick_s = true;

            $main_html .= '<tr bgcolor=yellow><td>'.$iplog_s['ip'].'</td><td>'.date('d.m.y H:i', $iplog_s['time']).'</td><td><u>'.$iplog_s['sitter'].'</u></td></tr>';
        }
    }
    // Probably sitter list is empty earlier
    else if($iplog_u) {
        $pick_s = false;
        $pick_u = true;

        $main_html .= '<tr><td>'.$iplog_u['ip'].'</td><td>'.date('d.m.y H:i', $iplog_u['time']).'</td><td>'.$player['user_name'].'</td></tr>';
    }
    else if($iplog_u) {
        $pick_u = false;
        $pick_s = true;

        $main_html .= '<tr bgcolor=yellow><td>'.$iplog_s['ip'].'</td><td>'.date('d.m.y H:i', $iplog_s['time']).'</td><td></u>'.$iplog_s['sitter'].'</u></td></tr>';
    }
    // Both lists are empty, exit
    else {
        $pick_u = false;
        $pick_s = false;
    }
}


$main_html .= '</table>';

