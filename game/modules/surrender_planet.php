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

if(isset($_POST['exec_surrender_planet'])){

$game->out('

<span class="caption">'.constant($game->sprache("TEXT0")).'</span><br><br>

<form action="'.parse_link('a=surrender_planet').'" method="post">

<table class="style_inner" align="center" border="0" cellpadding="2" cellspacing="2" width="450">
<tr>
  <td>'.constant($game->sprache("TEXT1")).' <b><a href="'.parse_link('a=tactical_cartography&planet_id='.$game->planet['planet_id']).'">'.$game->planet['planet_name'].'</a></b> '.constant($game->sprache("TEXT2")).' <b>'.$game->player['user_name'].'
</tr>

<tr>
  <td>&nbsp;</td>
</tr>

<tr>
  <td>'.constant($game->sprache("TEXT3")).' <b><a href="'.parse_link('a=tactical_cartography&planet_id='.$game->planet['planet_id']).'">'.$game->planet['planet_name'].'</a></b> '.constant($game->sprache("TEXT4")).'</td>
</tr>

<tr>
  <td>&nbsp;</td>
</tr>

<tr>
  <td align="center"><input class="button" name="cancel" value="'.constant($game->sprache("TEXT5")).'" onclick="return window.history.back();" type="button">&nbsp;&nbsp;<input class="button" name="do_surrender_planet" value="'.constant($game->sprache("TEXT6")).'" type="submit"><td>
</tr>
<table>

</form>

');

}

if(isset($_POST['do_surrender_planet'])) {

        // message(NOTICE, ''.$game->config['tick_id'].'');

       if($game->planet['planet_surrender']!=0){

           message(NOTICE, constant($game->sprache("TEXT7")));

       }

        if($game->SITTING_MODE) {

            message(NOTICE, constant($game->sprache("TEXT8")));

        }
/*
        if($game->player['user_capital']==$game->planet['planet_id']) {

            message(NOTICE, constant($game->sprache("TEXT9")));

        }
*/

        $sql = 'UPDATE planets
                SET planet_surrender = ('.$game->config['tick_id'].' + 120)
                WHERE planet_id = '.$game->planet['planet_id'];

        if(!$db->query($sql)) {
            $sdl->log('<b>Error:</b> Could not perform surrender planet <b>'.$game->planet['planet_id'].'</b>! CONTINUED');
        }


    redirect('a=headquarter');

}

?>
