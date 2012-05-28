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

include('config.inc.php');

define('GENERAL', 1);

define('DATABASE_ERROR', 2);

define('NL', "\n");

define ("GALAXY1_NAME", 'Brown Bobby');
define ("GALAXY2_NAME", 'Fried Egg');
define ("GALAXY3_NAME", 'Forge');

define ("GALAXY1_IMG", 'gfx/ngc7742.jpg');
define ("GALAXY2_IMG", 'gfx/m64.jpg');
define ("GALAXY3_IMG", 'gfx/m64.jpg');

define ("GALAXY1_BG", 'gfx/ngc7742bg.jpg');
define ("GALAXY2_BG", 'gfx/m64bg.jpg');
define ("GALAXY3_BG", 'gfx/m64bg.jpg');


$db_name = '';
$db_user = '';
$db_password = '';

error_reporting(E_ALL);

function message($type, $message) {

	/* Out from the game we have no user name */
	$username = '<i><b>external user</b></i>';
	/* */

	switch($type) {
		case GENERAL:
			echo '
				<html>
				<head>
				<title>Frontline Combat :: System Announcement</title>
				<style type="text/css">
				<!--
				a:link    { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:visited { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }
				a:hover   { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #FFFFFF; }
				a:active  { font-family: Arial,serif; font-size: 10px; text-decoration: none; color: #CCCCCC; }

				td { font-family: Arial,serif; font-size: 12px; color: #FFFFFF; }

				input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
				{ color: #959595; font-family: Verdana; font-size: 10px; background-color: #000000; border: 1px solid #959595; }

				//-->
				</style>
				</head>

				<body bgcolor="#000000" background="../gfx/template_bg.jpg">

				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border: 1px solid #C0C0C0;">
				<tr>
				<td><span style="font-size: 14px; font-weight: bold;">Frontline Combat :: System Announcement</span></td>
				</tr>
				</table>
				<table bgcolor="#000025" width="500" align="center" cellspacing="4" cellpadding="4" style="border-left: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0;">
				<tr>
				<td>'.$message.'</td>
				</tr>
				</table>

				</body>
				</html>
			';
			$fp = fopen(ERROR_LOG_FILE, 'a');
			fwrite($fp, '<hr><br><br><br><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>User:</b>&nbsp;'.$username.'&nbsp;&nbsp;&nbsp;<b>General Error:</b><br>'.$message."\n");
			fclose($fp);
		break;

		case DATABASE_ERROR:
			global $db;

			echo '<span style="font-size: 20px; font-family: Verdana, Arial, Helvetica, sans-serif;"><b>Frontline Combat :: Database Error</b></span><hr>'.
			'<span style="font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif;">'.$message.'<br><br>'.$db->error['message'].' ('.$db->error['number'].')<br><br>'.$db->error['sql'].'</span>';

			$fp = fopen(ERROR_LOG_FILE, 'a');
			fwrite($fp, '<hr><br><br><br><br><i>'.date('d.m.y H:i:s', time()).'</i>&nbsp;&nbsp;&nbsp;<b>User:</b>&nbsp;'.$username.'&nbsp;&nbsp;&nbsp;<b>Database Error:</b><br>'.$message.'<br><br>'.$db->error['message'].' ('.$db->error['number'].')<br><br>'.$db->error['sql']."\n");
			fclose($fp);

		break;
	}

	exit;
}
function parse_link($get_string = '') {
    return $_SERVER['PHP_SELF'].'?'.$get_string;
}

function display_message($header,$message,$bg) {
    global $main_html;
    $main_html .= '
<table align="center" border="0" cellpadding="2" cellspacing="2" width="500" class="border_grey" style=" background-color:#000000; background-position:left; background-repeat:no-repeat;">
  <tr>
    <td width="100%">
      <center><span class="sub_caption">'.$header.'</span></center>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" background-image:url(\''.$bg.'\'); background-position:left; background-repeat:yes;">
        <tr>
          <td width="100%" valign="top"><span class="sub_caption2"><br>'.$message.'<br><br></span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>';
}

class sql {
    var $login = array(
        'server' => 'localhost',
        'database' => '',
        'user' => '',
        'password' => '',
    );
    
    var $error = array(
        'message' => 'No error occured',
        'number' => '0',
        'sql' => ''
    );

    var $link_id = 0;
    var $query_id = 0;

    var $i_query = 0;
    var $t_query = 0;

    var $debug = false;
    var $d_query = array();


    function sql($server, $database, $user, $password = '') {
        $this->login = array(
            'server' => $server,
            'database' => $database,
            'user' => $user,
            'password' => $password
        );
    }

    function raise_error($message = false, $number = false, $sql = '') {
        if($message === false) $message = mysql_error($this->link_id);
        if($number === false) $number = mysql_errno($this->link_id);

        $this->error = array(
            'message' => $message,
            'number' => $number,
            'sql' => $sql
        );

        return false;
    }

    function connect() {
        if(!is_resource($this->link_id)) {
            if(!$this->link_id = @mysql_connect($this->login['server'], $this->login['user'], $this->login['password'])) {
                message(GENERAL, 'Could not connect to mysql server');
            }

            if(!@mysql_select_db($this->login['database'], $this->link_id)) {
                $this->raise_error(false, false, 'USE '.$this->login['database']);

                message(DATABASE_ERROR, 'Could not select database');
            }
        }

        return true;
    }

    function close() {
        if(is_resource($this->link_id)) {
            if(!@mysql_close($this->link_id)) {
                return $this->raise_error();
            }
        }

        return true;
    }
    
    function lock() {
        $tables = func_get_args();
        
        $tables[] = 'planets';
        $tables[] = 'starsystems';
        $tables[] = 'user';
        
        $n_tables = count($tables);
        $table_str = array();
        
        if($n_tables == 0) return;
        
        for($i = 0; $i < $n_tables; ++$i) {
            $table_str[] = $tables[$i].' WRITE';
        }
        
        $sql = 'LOCK TABLES '.implode(',', $table_str);
        
        if(!mysql_query($sql, $this->link_id)) {
            $this->raise_error(false, false, $sql);
            
            message(DATABASE_ERROR, 'Could not lock tables');
        }
        
        return true;
    }
    
    function unlock() {
        if(!mysql_query('UNLOCK TABLES', $this->link_id)) {
            $this->raise_error(false, false, 'UNLOCK TABLES');
            
            message(DATABASE_ERROR, 'Could not unlock tables');
        }
        
        return true;
    }
    
    function query_lowlevel($sql) {
        if(!$this->connect()) return false;
        
        return @mysql_query($sql, $this->link_id);
    }

    function query($query, $unbuffered = false) {
        if(!$this->connect()) return false;

        $query_function = ($unbuffered) ? 'mysql_unbuffered_query' : 'mysql_query';

        $start_time = time() + microtime();

        if(!$this->query_id = @$query_function($query, $this->link_id)) {
            return $this->raise_error(false, false, $query);
        }

        $total_time = (time() + microtime()) - $start_time;

        if($this->debug) {
            $this->d_query[] = array(
                'sql' => $query,
                'time' => $total_time
            );
        }

        $this->t_query += $total_time;
        ++$this->i_query;

        return $this->query_id;
    }

    function fetchrow($query_id = false, $result_type = MYSQL_ASSOC) {
        if($query_id === false) $query_id = $this->query_id;

        if(!$_row = @mysql_fetch_array($query_id, $result_type)) {
            if(($_error = mysql_error()) !== '') {
                return $this->raise_error($_error);
            }
            else {
                return array();
            }
        }

        return $_row;
    }

    function fetchrowset($query_id = false, $result_type = MYSQL_ASSOC) {
        if($query_id === false) $query_id = $this->query_id;

        $_row = $_rowset = array();

        while($_row = @mysql_fetch_array($query_id, $result_type)) {
            $_rowset[] = $_row;
        }

        if(!$_rowset) {
            if(($_error = mysql_error()) !== '') {
                return $this->raise_error();
            }
            else {
                return array();
            }
        }

        return $_rowset;
    }

    function queryrow($query, $result_type = MYSQL_ASSOC) {
        if(!$_qid = $this->query($query)) {
            return false;
        }

        return $this->fetchrow($_qid, $result_type);
    }

    function queryrowset($query, $result_type = MYSQL_ASSOC) {
        if(!$_qid = $this->query($query, true)) {
            return false;
        }

        return $this->fetchrowset($_qid, $result_type);
    }

    function free_result($query_id = false) {
        if($query_id === false) $query_id = $this->query_id;

        if(!@mysql_free_result($query_id)) {
            return $this->raise_error();
        }

        return true;
    }

    function num_rows($query_id = false) {
        if($query_id === false) $query_id = $this->query_id;

        $_num = @mysql_num_rows($query_id);

        if($_num === false) {
            return $this->raise_error();
        }

        return $_num;
    }

    function affected_rows() {
        $_num = @mysql_affected_rows($this->link_id);

        if($_num === false) {
            return $this->raise_error();
        }

        return $_num;
    }

    function insert_id() {
        $_id = @mysql_insert_id($this->link_id);

        if($_id === false) {
            return $this->raise_error();
        }

        return $_id;
    }
    
    function debug_info() {
        echo '
<table bgcolor="#666666" width="100%" cellpadding="5" cellspacing="1">
  <tr>
    <td bgcolor="#CCCCCC" align="center"><b>query</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>execution time</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>table(s)</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>type</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>possible keys</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>key</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>key length</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>ref</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>rows</b></td>
    <td bgcolor="#CCCCCC" align="center"><b>extra</b></td>
  </tr>
        ';

        foreach($this->d_query as $data) {
            $time = round($data['time'], 5);
            $sql = $data['sql'];

            $q_explain = mysql_query('EXPLAIN '.$sql, $this->link_id);
            $data['explain'] = mysql_fetch_array($q_explain, MYSQL_ASSOC);

            $danger = 1;

            $table =         (!empty($data['explain']['table']))         ? $data['explain']['table']         : '';
            $type =          (!empty($data['explain']['type']))          ? $data['explain']['type']          : '';
            $possible_keys = (!empty($data['explain']['possible_keys'])) ? $data['explain']['possible_keys'] : '';
            $key =           (!empty($data['explain']['key']))           ? $data['explain']['key']           : '';
            $key_len =       (!empty($data['explain']['key_len']))       ? $data['explain']['key_len']       : '';
            $ref =           (!empty($data['explain']['ref']))           ? $data['explain']['ref']           : '';
            $rows =          (!empty($data['explain']['rows']))          ? $data['explain']['rows']          : '';
            $extra =         (!empty($data['explain']['Extra']))         ? $data['explain']['Extra']         : '';

            if($time > 0.05) $danger++;
            if($time > 0.1) $danger++;
            if($time > 1) $danger++;
            if($type == 'ALL') $danger++;
            if($type == 'index') $danger++;
            if($type == 'range') $danger++;
            if($type == 'ref') $danger++;
            if($rows >= 200) $danger++;

            if(!empty($possible_keys) && empty($key)) $danger++;
            if((strpos($extra, 'Using filesort') !== false) || (strpos($extra, 'Using temporary') !== false)) $danger++;

            switch($danger) {
                case 1:  $color = '#DADADA'; break;
                case 2:  $color = '#DAD0D0'; break;
                case 3:  $color = '#DACACA'; break;
                case 4:  $color = '#DAC0C0'; break;
                case 5:  $color = '#DABABA'; break;
                case 6:  $color = '#DAB0B0'; break;
                case 7:  $color = '#DAAAAA'; break;
                case 8:  $color = '#DA9090'; break;
                case 9:  $color = '#DA8A8A'; break;

                default: $color = '#FF0000'; break;
            }

            preg_match("/(FROM|UPDATE) (\w+)/i", $sql, $table);

            echo '
	<tr>
		<td bgcolor="'.$color.'"><pre style=" font-size:12px; font-family:courier new">'.wordwrap(trim(str_replace("\t", '', $sql))).'</pre></td>
		<td bgcolor="'.$color.'">'.$time.'</td>
		<td bgcolor="'.$color.'">'.$table[2].'</td>
		<td bgcolor="'.$color.'">'.$type.'</td>
		<td bgcolor="'.$color.'">'.$possible_keys.'</td>
		<td bgcolor="'.$color.'">'.$key.'</td>
		<td bgcolor="'.$color.'">'.$key_len.'</td>
		<td bgcolor="'.$color.'">'.$ref.'</td>
		<td bgcolor="'.$color.'">'.$rows.'</td>
		<td bgcolor="'.$color.'">Intensity '.$danger.(!empty($extra) ? '; '.$extra : '').'</td>
	</tr>
            ';
        }

        echo '
</table><br>
<b>Query Server Intensity</b>:
<span style="background-color:#DADADA">&nbsp;1 </span>
<span style="background-color:#DAD0D0"> 2 </span>
<span style="background-color:#DACACA"> 3 </span>
<span style="background-color:#DAC0C0"> 4 </span>
<span style="background-color:#DABABA"> 5 </span>
<span style="background-color:#DAB0B0"> 6 </span>
<span style="background-color:#DAAAAA"> 7 </span>
<span style="background-color:#DA9090"> 8 </span>
<span style="background-color:#DA8A8A"> 9&nbsp;</span><br>
        ';
        
        return true;
    }
}

function stgc_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
    $headers = 'MIME-Version: 1.0'.NL.
               'Content-type: text/plain; charset=iso-8859-1'.NL.
               'X-Priority: 1'.NL.
               'X-MSMail-Priority: High'.NL.
               'X-Mailer: php'.NL.
               'From: "'.$myname.'" <'.$myemail.'>'.NL;

    return mail('"'.$contactname.'" <'.$contactemail.'>', $subject, $message, $headers);
}


$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection
$db2 = new sql($config['server'].":".$config['port'], $config['game_database2'], $config['user'], $config['password']);
//$db3 = new sql($config['server'].":".$config['port'], $config['game_database3'], $config['user'], $config['password']);

$action = htmlspecialchars((!empty($_GET['a'])) ? $_GET['a'] : 'home');

$title_html = 'Star Trek: Frontline Combat';
$meta_descr = 'ST: Frontline Combat is a free browser based multi-player game by playing the role of different races and peoples of the universe and rewrite history.';
$main_html = '';

if(strstr($action, '.')) {
    $main_html = '<br><br><center><span style="font-size: 20px;">La pagina selezionata "'.$action.'" non esiste.</span></center><br><br>';
}

if(!file_exists('pages/'.$action.'.php')) {
    $main_html = '<br><br><center><span style="font-size: 20px;">La pagina selezionata "'.$action.'" non esiste.</span></center><br><br>';
}
else
    include('pages/'.$action.'.php');


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title><?php echo $title_html; ?></title>
  <meta http-equiv="Content-Language" content="it">
  <meta name="description" content="<?php echo $meta_descr; ?>">
  <meta name="keywords" content="star, trek, game, gratis, multiplayer, onlinegame, browser, klingon, romulan, federation">

  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta name="title" content="Star Trek: Frontline Combat">
  <meta name="author" content="Florian Brede & Philipp Schmidt">
  <meta name="copyright" content="Paramount Pic., Brede, Schmidt">
  <meta name="ROBOTS" content="INDEX,NOFOLLOW">
  <meta name="creation_Date" content="11/14/2008">
  <meta name="revisit-after" content="7 days">
  <meta name="publisher" content="Florian Brede & Philipp Schmidt">
  <meta name="page-topic" content="Star Trek Online Game">
  <meta name="date" content="2008-11-14">
  <meta name="page-type" content="game">
<style type="text/css">
<!-- A:link {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:visited {FONT-SIZE: 11px; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:hover {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A:active {FONT-SIZE: 11px; COLOR: #ffd700; FONT-FAMILY: Arial, "Bitstream Vera Sans"; TEXT-DECORATION: none}
A.nav:link {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:visited {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:hover {FONT-WEIGHT: bold; FONT-SIZE: 10px}
A.nav:active {FONT-WEIGHT: bold; FONT-SIZE: 10px}
TD {FONT-SIZE: 11px; FONT-FAMILY: Arial, "Bitstream Vera Sans"; COLOR: #c0c0c0;  bgcolor=#cccccc}
INPUT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
TEXTAREA {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SELECT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #959595; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: Verdana; BACKGROUND-COLOR: #000000}
SPAN.caption {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"}
SPAN.sub_caption {FONT-WEIGHT: bold; FONT-SIZE: 15pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"}
SPAN.sub_caption2 {FONT-WEIGHT: bold; FONT-SIZE: 13pt; COLOR: #c0c0c0; FONT-FAMILY: Arial, "Bitstream Vera Sans"}
BODY {MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; SCROLLBAR-BASE-COLOR: #131c46; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; }
TEXTAREA {PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; SCROLLBAR-ARROW-COLOR: #ccccff; PADDING-TOP: 0px; SCROLLBAR-BASE-COLOR: #131c46;}

input.button, input.button_nosize, input.field, input.field_nosize, textarea, select
                          { color: #959595; font-family: Arial, "Bitstream Vera Sans", Helvetica, sans-serif; font-size: 11px; background-color: #000000; border: 1px solid #959595; }
body, textarea {
      scrollbar-base-color:#000000;
      scrollbar-3dlight-color:#000000;
      scrollbar-arrow-color:#D8D8D8;
      scrollbar-darkshadow-color:#000000;
      scrollbar-face-color:#000000;
      scrollbar-highlight-color:#000000;
      scrollbar-shadow-color:#000000;
      scrollbar-track-color:#2C2C2C;
  }

table.border_grey         { border: 1px solid #000000; }
table.border_grey2        { border-top: 1px solid 000000; border-right: 1px solid 000000; border-bottom: 1px solid #000000; }
table.border_blue         { border: 1px solid #000000; }

td.home_bar               { background-image:url('gfx/template_bg3.jpg'); }
td.home_logo              { background-image:url('gfx/welcome_logo.jpg'); }

td.desc_row {  }
td.value_row { color: #BOBOBO; font-weight: bold;}


-->

</style>
    <style type="text/css">
    .dropcontent{display:none;}
    </style>
    <script type="text/javascript">

/*
Combo-Box Viewer script- Created by and Copyright Dynamicdrive.com
Visit http://www.dynamicdrive.com/ for this script and more
This notice MUST stay intact for legal use
*/

function contractall(){
if (document.getElementById){
var inc=0
while (document.getElementById("dropmsg"+inc)){
document.getElementById("dropmsg"+inc).style.display="none"
inc++
}
}
}


function expandone(){
if (document.getElementById){
var selectedItem=document.register.user_race.selectedIndex
contractall()
document.getElementById("dropmsg"+selectedItem).style.display="block"
}
}

if (window.addEventListener)
window.addEventListener("load", expandone, false)
else if (window.attachEvent)
window.attachEvent("onload", expandone)

</script>

  <script type="text/JavaScript" src="overlib.js"></script>
</head>

<body text="#c0c0c0" background="gfx/bg_stars1.gif" >
<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
<table cellspacing="0" cellpadding="0" width="750" align="center" border="0" bgcolor="#283359">
<tbody>
  <tr>
    <td width="750"  bgcolor="black"></td>
  </tr>
  <tr>
    <td width="750" height="5" bgcolor="black">&nbsp;</td>
  </tr>
  <tr>
    <td width="750" height="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="750"><!-- Banner -->
      <table width="750" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="gfx/head_01.gif" width="750" height="132" alt=""></td>
        </tr>
        <tr>
          <td><img src="gfx/head_02.gif" width="658" height="18" alt=""></td>
          <td><a href="http://fragzshox.fr.funpic.de/" target="_blank"><img src="gfx/head_03.gif" alt="" width="92" height="18" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="750" height="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="750" height="1" bgcolor="black"></td>
  </tr>
  <tr>
    <td width=750 bgcolor="#131C46">&nbsp;
      <a class="nav" href="<?php echo parse_link() ?>"><img src="gfx/home.jpg" alt="home" border=0 onMouseOver="this.src='gfx/homeh.jpg';" onMouseOut="this.src='gfx/home.jpg';"></a> &nbsp;
      <a class="nav" href="<?php echo parse_link('a=login') ?>"><img src="gfx/login.jpg" alt="login" border=0 onMouseOver="this.src='gfx/loginh.jpg';" onMouseOut="this.src='gfx/login.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="<?php echo parse_link('a=register') ?>"><img src="gfx/register.jpg" alt="register" border=0 onMouseOver="this.src='gfx/registerh.jpg';" onMouseOut="this.src='gfx/register.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="<?php echo parse_link('a=stats') ?>"><img src="gfx/stats.jpg" alt="stats" border=0 onMouseOver="this.src='gfx/statsh.jpg';" onMouseOut="this.src='gfx/stats.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="http://wiki.stgc.de" target=_blank><img src="gfx/faq.jpg" alt="faq" border=0 onMouseOver="this.src='gfx/faqh.jpg';" onMouseOut="this.src='gfx/faq.jpg';"></a>
      <a class="nav" href="http://forum.stfc.it" target=_blank><img src="gfx/forum.jpg" alt="forum" border=0 onMouseOver="this.src='gfx/forumh.jpg';" onMouseOut="this.src='gfx/forum.jpg';"></a>
      <a class="nav" href="<?php echo parse_link('a=imprint') ?>"><img src="gfx/impressum.jpg" alt="impressum" border=0 onMouseOver="this.src='gfx/impressumh.jpg';" onMouseOut="this.src='gfx/impressum.jpg';"></a> &nbsp;&nbsp;
      <a class="nav" href="http://stgcsource.de/" target=_blank><img src="gfx/developer.jpg" alt="Development" border=0 onMouseOver="this.src='gfx/developerh.jpg';" onMouseOut="this.src='gfx/developer.jpg';"></a>
    </td>
  </tr>
  <tr>
    <td width="750" height="1" bgcolor="black"></td>
  </tr>
  <tr>
    <td valign="top" align="center" width="750">
      <table cellspacing="0" cellpadding="0" width="750" align="center" border="0">
      <tbody>
        <tr>
          <td align="center" width="750">
            <!-- Middle -->
            <table cellspacing="0" cellpadding="0" width="650" align="center" border="0">
            <tbody>
              <tr>
                <td width="650"><br>
                  <br>
                  <?php echo $main_html; ?>
                  <br>
                  <br>
                </td>
              </tr>
            </table>
            <!-- Middle End -->
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" align="center" width="750" height="10">
      <table cellspacing="0" cellpadding="0" width="750" align="center" border="0">
      <tbody>
        <tr>
          <td align="center" width="750">
<!--  This copyright notice must never be changed or modified in any way and always be visible!  -->
            <img src="gfx/copyright.png" alt="copyright" border="0">
<!--  End of copyright notice  -->
            <br>
          </td>
        </tr>
        <tr>
          <td width="750" height="1" bgcolor="black">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table><br>
<div align="center">

<script type="text/javascript" src="http://ss.webring.com/navbar?f=j;y=adminstfc;u=defurl"></script>
Powered by <a href="http://dir.webring.com/rw" target="_top">WebRing</a>.</center>

<!--optional-->
<noscript>
<center>
<table bgcolor="gray" cellspacing="0" border="2">
  <tr>
    <td>
      <table cellpadding="2" cellspacing="0" border="0">
        <tr>
          <td align="center">
            <font face="arial" size="-1">
              This site is a member of WebRing.<br>
              To browse visit <a href="http://ss.webring.com/navbar?f=l;y=adminstfc;u=defurl">Here</a>.
            </font>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
</noscript>
</div>
</body>
</html>


