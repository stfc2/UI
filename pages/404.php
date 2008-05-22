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

error_reporting(E_ERROR);

$mimetype='Data';
if(strpos($_SERVER['REQUEST_URI'], ".mp3")) $mimetype='Music data';
if(strpos($_SERVER['REQUEST_URI'], ".txt")) $mimetype='Text data';
if(strpos($_SERVER['REQUEST_URI'], ".php")) $mimetype='Site';
if(strpos($_SERVER['REQUEST_URI'], ".htm")) $mimetype='Site';
if(strpos($_SERVER['REQUEST_URI'], ".js")) $mimetype='Javascript-Data';
if(strpos($_SERVER['REQUEST_URI'], ".swf")) $mimetype='Flash data';
if(strpos($_SERVER['REQUEST_URI'], ".pdf")) $mimetype='PDF-Data';

$main_html .= '
<style type="text/css">
<!--
td.desc_row {  }
td.value_row { color: #BOBOBO; font-weight: bold;}
//-->
</style>
<center><span class="caption">404 Error</span></center><br>

<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
  <tr>
    <td valign="top" align="center" width="600" valign=top>
      <span class="sub_caption">The requested '.$mimetype.'<br>"'.$_SERVER['REQUEST_URI'].'"<br>doesn&#146;t exist.</span><br><br>
    </td>
  </tr>
</table>
<br>
';

//print_r($_SERVER);
?>
