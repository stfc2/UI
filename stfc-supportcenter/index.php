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


define ("GALAXY1_NAME", 'Brown Bobby');
define ("GALAXY2_NAME", 'Fried Egg');


define('NL', "\n");



error_reporting(E_ERROR);



function parse_link($get_string = '') {

    return $_SERVER['PHP_SELF'].'?'.$get_string;

}



class sql {

    var $login = array();

    var $error = array();



    var $link_id = 0;

    var $query_id = 0;



    var $i_query = 0;

    var $t_query = 0;





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

            if(!$this->link_id = mysql_connect($this->login['server'], $this->login['user'], $this->login['password'])) {

                return $this->raise_error('Could not connect to server '.$this->login['server'], 0);

            }



            if(!@mysql_select_db($this->login['database'], $this->link_id)) {

                return $this->raise_error();

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



    function query($query) {

        if(!$this->connect()) {

            return false;

        }



        if(!$this->query_id = mysql_query($query, $this->link_id)) {

            return $this->raise_error();

        }



        ++$this->i_query;



        return $this->query_id;

    }



    function fetchrow($query_id = 0, $result_type = MYSQL_ASSOC) {

        if(!is_resource($query_id)) $query_id = $this->query_id;



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



    function fetchrowset($query_id = 0, $result_type = MYSQL_ASSOC) {

        if(!is_resource($query_id)) $query_id = $this->query_id;



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



    function free_result($query_id = 0) {

        if(!is_resource($query_id)) $query_id = $this->query_id;



        if(!@mysql_free_result($query_id)) {

            return $this->raise_error();

        }



        return true;

    }



    function num_rows($query_id = 0) {

        if(!is_resource($query_id)) $query_id = $this->query_id;



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

}





    




$action = htmlspecialchars((!empty($_GET['p'])) ? $_GET['p'] : 'home');
if (empty($_GET['p']) && !empty($_GET['a'])) $action =htmlspecialchars($_GET['a']);
$main_html = '';

include('../game/include/global.php');

$db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']); // create sql-object for db-connection
$db2 = new sql($config['server'].":".$config['port'], $config['game_database2'], $config['user'], $config['password']); // create sql-object for db-connection


include('session.php');





include('account.php');


function log_multiban($message) {
global $user;
        $fp = fopen('multilog', 'a');
        fwrite($fp, '<b>['.date('d.m.y H:i:s', time()).'] '.$user['user_name'].':</b> '.$message."\n");
        fclose($fp);
}

function log_action($message) {
global $user;
        $fp = fopen('actionlog', 'a');
        fwrite($fp, '<b>['.date('d.m.y H:i:s', time()).'] '.$user['user_name'].':</b> '.$message."\n");
        fclose($fp);
}



if (!empty($user))
{

$show_logout = '<br><a href="index.php?logout"><b>Logout</b></a><br>';

// create sql-object for db-connection
switch($user['galaxy'])
{
    case 0:
        $galaxyname = '(Galassia '.GALAXY1_NAME.')';
        $db = new sql($config['server'].":".$config['port'], $config['game_database'], $config['user'], $config['password']);
    break;
    case 1:
        $galaxyname = '(Galassia '.GALAXY2_NAME.')';
        $db = new sql($config['server'].":".$config['port'], $config['game_database2'], $config['user'], $config['password']);
    break;
}

if(strstr($action, '.')) {

    $main_html = '<br><br><center><span class="header">La pagina selezionata non esiste!</span></center><br><br>';

}
else
if(!include('pages/'.$action.'.php')) {

    $main_html = '<br><br><center><span class="header">La pagina selezionata non esiste!</span></center><br><br>';

}

}


?>









<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>

<HEAD>

	<TITLE>STFC Supportcenter</TITLE>

	<META NAME="publisher" CONTENT="Florian Brede">

	<META NAME="copyright" CONTENT="Florian Brede">

	<META NAME="page-topic" CONTENT="supportcenter">

	<META NAME="date" CONTENT="2004-12-11">

</HEAD>





<style type="text/css">



TD {FONT-SIZE: 11px; FONT-FAMILY: Microsoft Sans Serif, Luxi Sans; COLOR: #000000;  bgcolor=#cccccc}

SPAN.header0 {FONT-WEIGHT: bold; FONT-SIZE: 32pt; COLOR: #000000; FONT-FAMILY: Microsoft Sans Serif, Luxi Sans}

SPAN.header {FONT-WEIGHT: bold; FONT-SIZE: 24pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header1 {FONT-WEIGHT: bold; FONT-SIZE: 19pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header2 {FONT-WEIGHT: bold; FONT-SIZE: 14pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}

SPAN.header3 {FONT-WEIGHT: bold; FONT-SIZE: 12pt; COLOR: #000000; FONT-FAMILY: MS Sans Serif, Luxi Sans}



table.border_grey         { border: 1px solid #000000; }

table.border_black_1         { border: 1px solid #000000; }

table.border_black_2         { border: 2px solid #000000; }

table.border_grey2        { border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; }



INPUT {BORDER-RIGHT: #959595 1px solid; BORDER-TOP: #959595 1px solid; FONT-SIZE: 11px; BORDER-LEFT: #959595 1px solid; COLOR: #000000; BORDER-BOTTOM: #959595 1px solid; FONT-FAMILY: MS Sans Serif, Luxi Sans; BACKGROUND-COLOR: #dddddd}



input.button, input.button_nosize, input.field, input.field_nosize, textarea, select

                          { color: #000000; font-family:  MS Sans Serif, Luxi Sans; font-size: 12px; background-color: #bbbbbb; border: 1px solid #959595; }



html, body {

height: 100%;

margin: 0px;

}



div.innen

{

margin-left:auto; margin-right:auto;

text-align:left;

}

</style>


<BODY bgcolor="#107710" onload="start();" >
<div id="overDiv" style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div>
     

<center>

<table border=0 cellpadding=0 cellspacing=0 width=940 bgcolor=#afafafaf>
<tr><td width=20></td>
<td width=900>

<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#bbbbbbb>

<tr><td><span class="header0">STFC Supportcenter</span></td><td align="right"><span class="header3"><?php echo $galaxyname; ?></span></td></tr></table>
<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#cccccc>

<tr valign=top>


<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Generale:</span><br>
<a href="index.php?p=home">Home</a><br>
<a href="index.php?p=stats">Statistiche</a><br>
<a href="index.php?p=log">Log squadre</a><br>
<a href="index.php?p=log2">Log multiban</a><br>
<?php echo $show_logout; ?>
</td>


<td width=25 bgcolor=#bbbbbbb></td>

<td width=150 valign=top bgcolor=#cccccc>
<span class="header3">Strumenti:</span><br>
<a href="index.php?p=news">Scrivi novit&agrave;</a><br>
<a href="index.php?p=polls">Scrivi sondaggi</a><br><br>
<a href="index.php?p=messages">Sistema messaggi</a><br>
<a href="index.php?p=bulkmail">Email di massa</a><br>
</td>

<td width=25 bgcolor=#cccccc></td>

<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Giocatori:</span><br>
<a href="index.php?p=user_stats">Sommario</a><br>
<a href="index.php?p=user">Cerca</a><br>
Es.<br>Cambia dati<br>Blocca<br>Cancella
<br>
</td>
<td width=25 bgcolor=#bbbbbbb></td>
<td width=150 valign=top bgcolor=#cccccc>
<span class="header3">Pianeti:</span><br>
<!-- <a href="index.php?p=planet_overview"><i>Sommario</i></a><br>
<a href="index.php?p=planet_resources"><i>Risorse</i></a><br>
<a href="index.php?p=planet_units"><i>Unit&agrave;</i></a><br>
<a href="index.php?p=planet_ships"><i>Navi</i></a><br> !-->
<br>
</td>

<td width=25 bgcolor=#cccccc></td>
<td width=150 valign=top bgcolor=#bbbbbbb>
<span class="header3">Multi:</span><br>
<a href="index.php?p=multihunt">Multi hunting</a><br>
<br>
</td>
<td width=25 bgcolor=#bbbbbbb></td>

</tr></table>

<table border=0 cellpadding=0 cellspacing=0 width=900 bgcolor=#cccccc>
 <tr>
    <td>
      <br><br>
      <?php echo $main_html; ?>
      <br><br>
    </td>
  </tr>
</table>




</td>
<td width=20></td>
</tr>
<tr height=25><td colspan=3></td></tr>
</table>



</BODY>

</HTML>

