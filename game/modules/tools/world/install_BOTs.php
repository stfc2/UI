<?php
/*    
    This file is part of STFC.it.
    Copyright 2008-2013 by Andrea Carolfi (info@stfc.it) and Cristiano Delogu

    STFC.it is based on STGC,
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


// ########################################################################################
// ########################################################################################
// Startup Config

// include functions and classes needed by the installation
include_once('include/global.php');
include_once('include/functions.php');
include_once('include/libs/world.php');
include_once('include/sql.php');

// include BOTs classes definitions
include($config['scheduler_path'].'/NPC_BOT.php');
include($config['scheduler_path'].'/ferengi.php');
include($config['scheduler_path'].'/memory_alpha.php');
include($config['scheduler_path'].'/settlers.php');
include($config['scheduler_path'].'/orion.php');

// Unfortunately we cannot include commons.php file here...
class scheduler {
	var $start_values = array();

	function log($message,$file = '') {
		if($file=='')
			$fp = fopen(TICK_LOG_FILE, 'a');
		else
			$fp = fopen($file, 'a');
		fwrite($fp, $message."<br>\n");
		fclose($fp);
	}

	function start_job($name,$file = '') {
		global $db;

		$this->log('<font color=#0000ff>Starting <b>'.$name.'</b>...</font>',$file);

		$this->start_values[$name] = array( time() + microtime() , $db->i_query );
	}

	function finish_job($name,$file = '') {
		global $db;

		$this->log('<font color=#0000ff>Executed <b>'.$name.'</b> (</font><font color=#ff0000>queries: '.($db->i_query - $this->start_values[$name][1]).'</font><font color=#0000ff>) in </font><font color=#009900>'.round( (time() + microtime()) - $this->start_values[$name][0] , 4).' secs</font><br>',$file);

	}
}

error_reporting(E_ERROR);

$game->init_player();

$game->out('<span class="caption">Install BOTs</span><br><br>');

check_auth(STGC_DEVELOPER);

if(!isset($_GET['sure'])) {
    $game->out('<br><center>Do you really want to install Ferengi, Borg and Settlers BOTs in the system?<br><br><a href="'.parse_link('a=tools/world/install_BOTs&sure').'">Install BOTs</a></center>');
    return;
}

// ########################################################################################
// ########################################################################################
// Init

$starttime = ( microtime() + time() );

$sdl = new scheduler();

$sdl->log('<br><b>-------------------------------------------------------------</b><br>'.
          '<b>Starting Install BOTs at '.date('d.m.y H:i:s', time()).'</b>',
    INSTALL_LOG_FILE_NPC);

$game->out('Installing Ramona BOT...');

// Install Quark BOT
$quark = new Ferengi($db,$sdl);
$quark->Install();

$game->out('done.<br>Installing Memory Alpha BOT...');

// Install SevenOfNine BOT
$borg = new MemoryAlpha($db,$sdl);
$borg->Install();

$game->out('done.<br>Installing Mayflower BOT...');

// Install Settlers BOT
$settlers = new Settlers($db,$sdl);
$settlers->Install();

$game->out('done.<br>Installing Orion Syndicate BOT...');

// Install Orion Syindicate BOT
$orion = new Orion($db,$sdl);
$orion->Install();

$game->out('done.<br><br><b>All BOTs installed, please check <a href="'.$config['site_url'].'/game/logs/view_log.php?file=NPC_installation">NPC_installation log</a> for further datails.<b>');


// ########################################################################################
// ########################################################################################
// Quit and close log

$sdl->log('<b>Finished Install BOTs in <font color=#009900>'.round((microtime()+time())-$starttime, 4).' secs</font><br>Executed Queries: <font color=#ff0000>'.$db->i_query.'</font></b>',
    INSTALL_LOG_FILE_NPC);

?>

