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

check_auth(STGC_DEVELOPER);

$game->out('<span class="caption">Send auctioned</span><br><br>');

if(isset($_POST['submit'])) {

	if(empty($_POST['ship_id'])) message(NOTICE, 'Ship ID is missing');
	if(empty($_POST['dest'])) message(NOTICE, 'Destination is missing');

	include_once('include/libs/moves.php');

	send_auctioned_ship((int)$_POST['ship_id'], (int)$_POST['dest']);

	$game->out('Sent ship ID: '.$_POST['ship_id'].' to: '.$_POST['dest']);

	$game->out('<br><br><a href="'.parse_link('a=tools/ships/send_auctioned').'">Back</a>');
}
else {
	$game->out('
		<form method="post" action="'.parse_link('a=tools/ships/send_auctioned').'">
		<table border="0" cellpadding="2" cellspacing="2" class="style_outer">
		<tr>
			<td>
			<table border="0" cellpadding="2" cellspacing="2" class="style_inner">
			<tr>
				<td>Ship ID:</td>
				<td><input class="field" type="text" name="ship_id" value="'.$_POST['ship_id'].'"></td>
			</tr>
			<tr>
				<td>Dest:</td>
				<td><input class="field" type="text" name="dest" value="'.$_POST['dest'].'"></td>
			</tr>
			<tr>
				<td colspan=2" align="center"><input class="button" type="submit" name="submit" value="Submit"><td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</form>');
}

?>
