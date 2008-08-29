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


if( (empty($_GET['galaxy'])) || (empty($_GET['user_id'])) || (empty($_GET['key'])) ) {
    $main_html = '<br><br><br><br><center><span class="caption">Impossibile cancellare l&#146;account (Chiamata invalida)</span></center>';
    return 1;
}

$galaxy = (int)$_GET['galaxy'];

$user_id = (int)$_GET['user_id'];

switch($galaxy)
{
    case 0:
        $mydb = $db;
    break;
    case 1:
        $mydb = $db2;
    break;
}

$sql = 'SELECT user_id, user_registration_ip, last_ip
        FROM user
        WHERE user_id = '.$user_id;

if(($user = $mydb->queryrow($sql)) === false) {
    $main_html = '<br><br><br><br><center><span class="caption">Impossibile cancellare l&#146;account (Chiamata invalida)</span></center>';
    return 1;
}

$reg_ip_split = explode('.', $user['user_registration_ip']);
$last_ip_split = explode('.', $user['last_ip']);
$confirm_key = md5( ((int)$reg_ip_split[0] + (int)$reg_ip_split[1] + (int)$reg_ip_split[2] + (int)$reg_ip_split[3]) * ((int)$last_ip_split[0] + (int)$last_ip_split[1] + (int)$last_ip_split[2] + (int)$last_ip_split[3]) - (int)$user_id );

if($_GET['key'] != $confirm_key) {
    $main_html = '<br><br><br><br><center><span class="caption">Il codice di conferma &egrave; invalido</span></center>';
    return 1;
}

$sql = 'UPDATE user
        SET user_active = 4
        WHERE user_id = '.$user_id;
        
if(!$db->query($sql)) {
    die('Database error - Could not delete registered user');
}


$main_html = '<center><span class="caption">Account deletion:</span></center><br>
</center><br>La cancellazione del tuo account &egrave; stata confermata.</b><br><br>Sar&agrave; definitivamente cancellato con il calcolo del prossimo tick (massimo in 3 minuti).<br><br><br>';


?>
