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


class sql {

    var $login = array(
        'server' => 'localhost',
        'port' => '3306',
        'database' => 'mysql',
        'user' => 'root',
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

    function sql($connection, $database, $user, $password = '') {
    	$server = strtok($connection, ':');
    	$port = strtok(':');
        $this->login = array(
            'server' => $server,
            'port' => $port,
            'database' => $database,
            'user' => $user,
            'password' => $password
        );
    }

    function raise_error($message = false, $number = false, $sql = '') {
        if($message === false) $message = $this->error();
        if($number === false) $number = $this->errno();

        $this->error = array(
            'message' => $message,
            'number' => $number,
            'sql' => $sql
        );

        return false;
    }

    function connect() {
        if(!is_object($this->link_id)) {
            if(!$this->link_id = @mysqli_connect($this->login['server'], $this->login['user'], $this->login['password'], $this->login['database'], $this->login['port'])) {
                message(GENERAL, 'Could not connect to mysql server and select database');
            }
        }

        return true;
    }

    function close() {
        if(is_object($this->link_id)) {
            if(!@mysqli_close($this->link_id)) {
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
        if(!mysqli_query( $this->link_id, $sql)) {
            $this->raise_error(false, false, $sql);
            message(DATABASE_ERROR, 'Could not lock tables');
        }
        return true;
    }

    function unlock() {
        if(!mysqli_query( $this->link_id, 'UNLOCK TABLES')) {
            $this->raise_error(false, false, 'UNLOCK TABLES');
            message(DATABASE_ERROR, 'Could not unlock tables');
        }
        return true;
    }

    function query_lowlevel($sql) {
        if(!$this->connect()) return false;

        return @mysqli_query( $this->link_id, $sql);
    }

    function query($query, $unbuffered = false) {
        if(!$this->connect()) return false;

        $query_mode = ($unbuffered) ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT;

        $start_time = time() + microtime();

        if(!$this->query_id = @mysqli_query($this->link_id, $query, $query_mode)) {
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



    function fetchrow($query_id = false, $result_type = MYSQLI_ASSOC) {
        if($query_id === false) $query_id = $this->query_id;

        if(!$_row = @mysqli_fetch_array($query_id, $result_type)) {
            if(($_error = mysqli_error($this->link_id)) !== '') {
                return $this->raise_error($_error);
            }
            else {
                return array();
            }
        }

        return $_row;
    }

    function fetchrowset($query_id = false, $result_type = MYSQLI_ASSOC) {
        if($query_id === false) $query_id = $this->query_id;

        $_row = $_rowset = array();

        while($_row = @mysqli_fetch_array($query_id, $result_type)) {
            $_rowset[] = $_row;
        }

        if(!$_rowset) {
            if(($_error = mysqli_error($this->link_id)) !== '') {
                return $this->raise_error();
            }
            else {
                return array();
            }
        }

        return $_rowset;
    }

    function queryrow($query, $result_type = MYSQLI_ASSOC) {
        if(!$_qid = $this->query($query)) {
            return false;
        }

        return $this->fetchrow($_qid, $result_type);
    }

    function queryrowset($query, $result_type = MYSQLI_ASSOC) {
        if(!$_qid = $this->query($query, true)) {
            return false;
        }

        return $this->fetchrowset($_qid, $result_type);
    }

    function free_result($query_id = false) {
        if($query_id === false) $query_id = $this->query_id;

        if(!@((mysqli_free_result($query_id) || (is_object($query_id) && (get_class($query_id) == "mysqli_result"))) ? true : false)) {
            return $this->raise_error();
        }

        return true;
    }

    function num_rows($query_id = false) {
        if($query_id === false) $query_id = $this->query_id;

        $_num = @mysqli_num_rows($query_id);

        if($_num === false) {
            return $this->raise_error();
        }

        return $_num;
    }

    function affected_rows() {
        $_num = @mysqli_affected_rows($this->link_id);

        if($_num === false) {
            return $this->raise_error();
        }

        return $_num;
    }

    function insert_id() {
        $_id = mysqli_insert_id($this->link_id);

        if($_id == 0) {
            return $this->raise_error();
        }

        return $_id;
    }

    function error() {
        return (is_object($this->link_id) ? mysqli_error($this->link_id) : mysqli_connect_error());
    }

    function errno() {
        return (is_object($this->link_id) ? mysqli_errno($this->link_id) : mysqli_connect_errno());
    }

    function debug_info() {

        echo '

<table bgcolor="#666666" width="100%" cellpadding="5" cellspacing="1">

  <tr>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>query</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>execution time</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>table(s)</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>type</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>possible keys</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>key</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>key length</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>ref</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>rows</b></td>

    <td bgcolor="#CCCCCC" align="center" style="color:black"><b>extra</b></td>

  </tr>

        ';



        foreach($this->d_query as $data) {

            $time = round($data['time'], 5);

            $sql = $data['sql'];



            $q_explain = mysqli_query( $this->link_id, 'EXPLAIN '.$sql);

            $data['explain'] = mysqli_fetch_array($q_explain,  MYSQLI_ASSOC);



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

		<td bgcolor="'.$color.'"><pre style=" font-size:12px; font-family:courier new; color:black">'.wordwrap(trim(str_replace("\t", '', $sql))).'</pre></td>

		<td bgcolor="'.$color.'" style="color:black">'.$time.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$table[2].'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$type.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$possible_keys.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$key.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$key_len.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$ref.'</td>

		<td bgcolor="'.$color.'" style="color:black">'.$rows.'</td>

		<td bgcolor="'.$color.'" style="color:black">Intensity '.$danger.(!empty($extra) ? '; '.$extra : '').'</td>

	</tr>

            ';

        }



        echo '

</table><br>

<b>Query Server Intensity</b>:

<span style="background-color:#DADADA; color:black">&nbsp;1 </span>

<span style="background-color:#DAD0D0; color:black"> 2 </span>

<span style="background-color:#DACACA; color:black"> 3 </span>

<span style="background-color:#DAC0C0; color:black"> 4 </span>

<span style="background-color:#DABABA; color:black"> 5 </span>

<span style="background-color:#DAB0B0; color:black"> 6 </span>

<span style="background-color:#DAAAAA; color:black"> 7 </span>

<span style="background-color:#DA9090; color:black"> 8 </span>

<span style="background-color:#DA8A8A; color:black"> 9&nbsp;</span><br>

        ';

        

        return true;

    }

}



?>
