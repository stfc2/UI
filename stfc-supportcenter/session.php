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



    if(empty($_COOKIE['stgcsupport_session'])) {

     return ;

    }


    $cookie_data = unserialize(base64_decode($_COOKIE['stgcsupport_session']));



    if(!is_array($cookie_data)) {

       return;

    }



    if(empty($cookie_data['id'])) {

       return;

    }



    $user_id = (int)$cookie_data['id'];



    if(empty($cookie_data['passwd'])) {

       return;

    }



    $user_password = stripslashes($cookie_data['passwd']);



    $sql = 'SELECT *

            FROM user

            WHERE user_id = '.$user_id;



    if(($player_data = $db->queryrow($sql)) === false) {

       return;

    }



    if(empty($player_data['user_id'])) {

       return;

    }



    if($user_password != $player_data['user_password']) {

       return;

    }



    $user=$player_data;

    unset($player_data);
?>

