<?php
$config=array();
$config['server']="<database server, usually localhost>";
$config['port']="<database port, usually 3306>";
$config['user']="<database username>";
$config['password']=">database password>";
$config['game_database']="<database name>";
$config['game_url']="<www url to game folder, for example: http://mysite.com/game>";
$config['site_url']="<www url of the server, for example: http://mysite.com>";
$config['game_path']="<path to game folder on the server, for example: /usr/share/game/ >";
$config['scheduler_path']="<path to scheduler folder on ther server, for example: /home/stfc/scheduler/ >";
$config['galaxy']=0;
$config['uploaddir'] = '<path to gallery folder of the game, for example: /usr/share/game/gallery/ >';

define ('ERROR_LOG_FILE', '<path to error log file, for example: /usr/share/game/logs/error_log.htm');
define ('ADMIN_LOG_FILE', '<path to admin log file, for example: /usr/share/game/logs/admin_log.htm');
define('DEFAULT_GFX_PATH', '<path to game graphics>');
define('PROXY_GFX_PATH', '<path to game graphics>');
define('JSCRIPT_PATH', '<path to game javascripts>');
?>
