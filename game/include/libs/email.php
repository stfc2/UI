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


function stgc_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
    $headers = 'MIME-Version: 1.0'.NL.
               'Content-type: text/plain; charset=iso-8859-1'.NL.
               'X-Priority: 1'.NL.
               'X-MSMail-Priority: High'.NL.
               'X-Mailer: php'.NL.
               'From: "'.$myname.'" <'.$myemail.'>'.NL;
               
    return mail('"'.$contactname.'" <'.$contactemail.'>', $subject, $message, $headers);
}

?>
