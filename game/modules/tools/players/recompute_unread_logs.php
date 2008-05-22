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



$game->init_player();

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Recompute unread logs</span><br><br>');

$sql = 'SELECT user_id
		FROM logbook
		WHERE log_read = 0';

if(!$q_logs = $db->query($sql)) {
	message(DATABASE_ERROR, 'Could not query logbook read data');
}

$logs_by_user = array();

while($log = $db->fetchrow($q_logs)) {
	if(!isset($logs_by_user[$log['user_id']])) $logs_by_user[$log['user_id']] = 0;

	$logs_by_user[$log['user_id']]++;
}

$sql = 'SELECT user_id, unread_log_entries
		FROM user';

if(!$q_user = $db->query($sql)) {
	message(DATABASE_ERROR, 'Could not query user data');
}

$updated = false;

while($user = $db->fetchrow($q_user)) {
	$update_to = -1;
	$old_count = (int)$user['unread_log_entries'];

	if(!isset($logs_by_user[$user['user_id']])) {
		if($old_count != 0) {
			$update_to = 0;
		}
	}
	else {
		if($old_count != $logs_by_user[$user['user_id']]) {
			$update_to = $logs_by_user[$user['user_id']];
		}
	}

	if($update_to != -1) {
		$sql = 'UPDATE user
		        SET unread_log_entries = '.$update_to.'
		        WHERE user_id = '.$user['user_id'];

		if(!$db->query($sql)) {
			message(DATABASE_ERROR, 'Could not update user #'.$user['user_id']);
		}

		$game->out('Updating user #'.$user['user_id'].' from '.$old_count.' to '.$update_to.'<br>');

		$updated = true;
	}
}

if(!$updated)
	$game->out('Nothing to update<br>');

?>
