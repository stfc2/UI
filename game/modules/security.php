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

include('include/libs/secimage.php');

$game->out('<center><span class="caption">STGC Sicherheitscode:<br><br></span>
<span class="sub_caption2">');

if ($game->player['content_secimage']!="" && time()>=$game->player['timeout_secimage'])
{

	$arr=explode(":",$game->player['content_secimage']);
		

	if (sqrt(pow($_POST['click_x']-$arr[0],2)+pow($_POST['click_x']-$arr[0],2))<25)
	{
		$game->out('Der angegebene Sicherheitscode war korrekt.<br>');
		$db->query('UPDATE user SET content_secimage="" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
		$db->query('UPDATE user SET timeout_secimage="'.(time()-1).'" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
		if (!isset($_REQUEST['a']) || $_REQUEST['a']=="security") $_REQUEST['a']=$_POST['command'];
		redirect('a='.$_REQUEST['a']);
	}
	else if (!isset($_REQUEST['a']) || $_REQUEST['a']=="security")
	{
		$db->query('UPDATE user SET error_secimage=error_secimage+1 WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');
		$game->out('Das ist deine '.($game->player['error_secimage']+1).'. falsche Eingabe.<br>');
	}


	if (!isset($_REQUEST['a']) || $_REQUEST['a']=="security") $_REQUEST['a']=$_POST['command'];
	$data=create_secimage();
	$db->query('UPDATE user SET timeout_secimage="'.(time()-1).'", content_secimage="'.$data['center'].'", link_secimage="'.$data['filename'].'" WHERE user_id="'.$game->player['user_id'].'" LIMIT 1');

	$game->out('<form name="secimage" method="post" action="'.parse_link('a=security').'">
		<input type="image" name="click" src="'.$data['filename'].'">
		<input type="hidden" name="command" value="'.$_REQUEST['a'].'">
		</form>Bitte klicke den Kreis an, der nicht vollständig geschlossen ist.<br><br>
		Tipp: Wenn du Popups aktivierst, erscheinen die Abfragen in einem seperaten Fenster
	');

}
else $game->out('Ungültiger Aufruf.<br>');

?>
