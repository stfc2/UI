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



// Stores the RACE_DATA_LOCALE: 




/* 

0 => Federation
1 => Romulan 
2 => Klingon 
3 => Cardassian
4 => Dominion
5 => Ferengi 
 6 => Borg
 7 => Orion Sydicate
8 => Breen
9 => Hirogen
10 => Vidiianer ==> Krenim 
11 => Kazon
 12 => Men 29th
 13 => Settler

 */ 



$RACE_DATA_LOCALE = array( 

      0 => 'Federation', 

      1 => 'Romulan', 

      2 => 'Klingon', 

      3 => 'Cardassian', 

      4 => 'Dominio', 

      5 => 'Ferengi', 

      6 => 'Borg', 

      7 => 'Orion Syndicate', 

      8 => 'Breen', 

      9 => 'Hirogeni',

      10 => 'Krenim', 

      11 => 'Kazon', 

      12 => '29th sec Mens', 

      13 => 'Settlers', 
);

foreach($RACE_DATA as $i => $race) {
	$RACE_DATA[$i][0] = $RACE_DATA_LOCALE[$i];
}

?> 
