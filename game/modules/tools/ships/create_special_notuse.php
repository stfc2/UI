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

if(isset($_POST['submit'])) {

    $template = $_POST['template_id'];

    $n_ships = (int)$_POST['n_ships'];

    $user_id = (int)$_POST['user_id'];

  
    $sql = 'SELECT *

            FROM ship_templates

            WHERE name="'.$template.'" AND owner = '.$user_id;
echo $sql.'<br>';
            

    if(($stpl = $db->queryrow($sql)) === false || !isset($stpl['id'])) {

        message(DATABASE_ERROR, 'Could not query ship template data');

    }

    
   $units_str = $stpl['max_unit_1'].', '.$stpl['max_unit_2'].', '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'];
   


            
	$qry=$db->query('SELECT * FROM planets WHERE planet_owner='.$user_id);
echo 'SELECT * FROM planets WHERE planet_owner='.$user_id;
	while (($planet = $db->fetchrow($qry)) != false)
	{
    $sql = 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time, unit_1, unit_2, unit_3, unit_4)
            VALUES ('.((-1)*$planet['planet_id']).', '.$user_id.', '.$stpl['id'].', '.$stpl['value_9'].', '.$stpl['value_5'].', '.$game->TIME.', '.$units_str.')';


    for($i = 0; $i < $n_ships; ++$i) {

//echo $sql.'<br>';
        if(!$db->query($sql)) {message(DATABASE_ERROR, 'Could not insert new ships #'.$i.' data');}

    }
    
	}



//    redirect('a=tools/ships/create_special_notuse');

}

else {

  

    

    $game->out('
<form method="post" action="'.parse_link('a=tools/ships/create_special_notuse').'">

Template Name:&nbsp;&nbsp;<input class="field" type="text" name="template_id" value="'.$_POST['template_id'].'"><br>
Anzahl:&nbsp;&nbsp;<input class="field" type="text" name="n_ships"><br>
Spieler:&nbsp;&nbsp;<input class="field" type="text" name="user_id"><br><br>
<input class="button" type="submit" name="submit" value="Erstellen">


</form>
    ');

}

/*Template Name:&nbsp;&nbsp;<input class="field" type="text" name="template_id"><br>
Anzahl:&nbsp;&nbsp;<input class="field" type="text" name="n_ships"><br>
Spieler:&nbsp;&nbsp;<input class="field" type="text" name="user_id"><br><br>

*/


?>

