<?PHP
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

$title_html = $locale['donation_title'];
$meta_descr = $locale['donation_descr'];
$main_html='<div class="caption">'.$locale['donation'].'</div>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="520" class="border_grey" style=" background-image:url(\'gfx/template_bg.jpg\'); background-position:left; background-repeat:yes;">
  <tr>
    <td width="300" valign="top" align="justify">
      '.$locale['donation_statement'].'
    </td>
    <td width="220" valign="middle" align="center">
      <img src="gfx/uncle-sam-wants-you.jpg" width="170">
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="170063">
        <input type="image" src="gfx/paypal.gif" border="0" name="submit" alt="">
        <img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
      </form>
    </td>
  </tr>
</table>
';
?>
