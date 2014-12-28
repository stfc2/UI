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


$player_online = $db->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));
$player_online2 = $db2->queryrow('SELECT COUNT(user_id) AS num FROM user WHERE last_active > '.(time() - 60 * 20));

$title_html = $locale['login_title'];
$meta_descr = $locale['login_descr'];
$main_html .= '
<form name="login_form" method="post" action="" onSubmit="return document.login_form.action = document.login_form.galaxy[document.login_form.galaxy.selectedIndex].value;">
<div class="caption">'.$locale['login'].'</div>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="320" class="border_grey">
  <tr>
    <td width="100%">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="30%">'.$locale['user_login'].'</td>
          <td width="70%"><input type="text" name="user_name" size="30" class="field"></td>
        </tr>
        <tr>
          <td>'.$locale['password'].'</td>
          <td><input type="password" name="user_password" size="30" class="field" autocomplete="off"></td>
        </tr>
        <tr>
          <td>'.$locale['galaxy'].'</td>
          <td>
            <select name="galaxy">
              <option value="./game/index.php" selected="selected">'.GALAXY1_NAME.' ['.$player_online['num'].' online]</option>
              <option value="./game2/index.php">'.GALAXY2_NAME.' ['.$player_online2['num'].' online]</option>
            </select>
          </td>
        </tr>
        <tr><td height="5">&nbsp;</td></tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="checkbox" name="proxy_mode" value="1">&nbsp;'.$locale['using_proxy'].' *</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan=2>
      * <i>'.$locale['proxy_note'].'</i>
    </td>
  </tr>
</table>

<br>
<center>
[ <a href="index.php?a=lost_password">'.$locale['lost_password'].'</a> ]<br><br>
<input class="button" type="submit" name="stgc_login" value="'.$locale['submit'].'">
</center>
</form>
';

?>
