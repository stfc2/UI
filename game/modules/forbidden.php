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

switch($game->player['language'])
{
    case 'GER':
        $title1 = 'Zugriff verweigert';
        $title2 = 'Du hast keinen Zugriff auf die gewählte Sektion,<br>weil der Sitter dir hierfür keine Genehmigung erteilt hat.';
    break;
    case 'ITA':
        $title1 = 'Accesso negato';
        $title2 = 'Non hai accesso alla sezione selezionata,<br>perch&eacute; il sitter non ti ha concesso l&#146;autorizzazione.';
    break;
    default:
        $title1 = 'Access Denied';
        $title2 = 'You do not have access to the selected section,<br>because the sitter has not granted the approval to you.';
    break;
}

$game->out('<span class="caption">'.$title1.'</span><br><br><span class="sub_caption2">'.$title2.'</span><br><br>');

?>
