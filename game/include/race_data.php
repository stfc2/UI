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



// Stores the RACE_DATA: 




/* 

0 => Federation
1 => Romulan
2 => Klingon
3 => Cardassian
4 => Dominion
5 => Ferengi
 6 => Borg
 7 => Q
8 => Breen
9 => Hirogen
10 => Vidiianer ==> Krenim
11 => Kazon
 12 => Men 29th
 13 => Settler

 * 0 => Name of Race

 * 1 => Construction period (buildings)

 * 2 => Construction period (units)

 * 3 => Construction period (ships)

 * 4 => Research Time

 * 5 => Cost (buildings)

 * 6 => Cost (units)

 * 7 => Cost (ships)

 * 8 => Research and development expenses

 * 9 => Metal mine yield

 * 10 => Mineral mine yield

 * 11 => Latinum refinery yield

 * 12 => "Workers yield"

 * 13 => Ship attack

 * 14 => Unit attack

 * 15 => Ship defense

 * 16 => Unit defense

 * 17 => Building defense (against planetary attacks)

 * 18 => Ship speed

 * 19 => Sensors range

 * 20 => Technology Exploitation (Modifies the efficiency of ALL technologies)

 * 21 => Fighting power of workers
  
 * 22 => Playable

 * 23 => Metal cost factor for buildings

 * 24 => Mineral cost factor for buildings

 * 25 => Latinum cost factor for buildings

 * 26 => Metal cost factor for research

 * 27 => Mineral cost factor for research

 * 28 => Latinum cost factor for research

 */ 



$RACE_DATA = array( 

   0 => array( 

      0 => 'Föderation', 

      1 => 0.50, 

      2 => 1.0, 

      3 => 1.0, 

      4 => 1.0, 

      5 => 1.25, 

      6 => 1.0, 

      7 => 1.0, 

      8 => 1.0, 

      9 => 5.0, 

      10 => 5.0, 

      11 => 5.0, 

      12 => 5.0, 

      13 => 1.0, 

      14 => 1.0, 

      15 => 1.0, 

      16 => 1.0, 

      17 => 1.0, 

      18 => 1.0, 

      19 => 1.0, 

      20 => 1.1, 

      21 => 3, 
       
      22 => true,

      23 => 1.25, 

      24 => 1.25, 

      25 => 1.25,

      26 => 1.50, 

      27 => 1.50, 

      28 => 1.50
   ), 



   1 => array( 

      0 => 'Romulaner', 

      1 => 0.48, 

      2 => 1.05, 

      3 => 0.90, 

      4 => 1.05,

      5 => 1.50, 

      6 => 1.20, 

      7 => 0.95, 

      8 => 1.20, 

      9 => 6.25, 

      10 => 6.25, 

      11 => 3.50, 

      12 => 5.75, 

      13 => 0.9,

      14 => 1.1, 

      15 => 0.95, 

      16 => 1.10, 

      17 => 0.95, 

      18 => 0.75, 

      19 => 0.90, 

      20 => 1.10,

      21 => 4.0, 
       
      22 => true, 

      23 => 1.5, 

      24 => 1.5, 

      25 => 0.5,

      26 => 1.50, 

      27 => 1.50, 

      28 => 0.5

   ), 



    2 => array( 

      0 => 'Klingonen', 

       1 => 0.60, 

       2 => 1.35, 

       3 => 1.10, 

       4 => 1.2, 

       5 => 1.30, 

       6 => 1.05,

       7 => 1.05, 

       8 => 1.55,

       9 => 5.50,

      10 => 5.00, 

      11 => 4.50,

      12 => 4.8,

      13 => 1.4,

      14 => 1.6,

      15 => 1.2,

      16 => 1.3,

      17 => 1.05,

      18 => 0.85,

      19 => 0.7,

      20 => 0.9, 

      21 => 6, 

      22 => true,

      23 => 1.30, 

      24 => 1.30, 

      25 => 1.30,

      26 => 1.80, 

      27 => 1.80, 

      28 => 1.80

   ), 



    3 => array( 

      0 => 'Cardassianer', 

      1 => 0.53, 

      2 => 0.95, 

      3 => 1.00, 

      4 => 1.00, 

      5 => 1.20, 

      6 => 0.9, 

      7 => 0.9, 

      8 => 1.10, 

      9 => 5.50, 

      10 => 5.00, 

      11 => 5.00, 

      12 => 5.25, 

      13 => 1.10, 

      14 => 1.20, 

      15 => 0.95, 

      16 => 1.10, 

      17 => 1.00, 

      18 => 0.90, 

      19 => 1.00, 

      20 => 1.00, 

      21 => 3, 
       
      22 => true, 

      23 => 1.20, 

      24 => 1.20, 

      25 => 1.20,

      26 => 1.20, 

      27 => 1.20, 

      28 => 1.20

    ), 



   4 => array( 

      0 => 'Dominion', 

      1 => 0.63, 

      2 => 1.15, 

      3 => 1.05, 

      4 => 1.15, 

      5 => 1.05, 

      6 => 0.95, 

      7 => 1.15, 

      8 => 1.25, 

      9 => 4.50, 

      10 => 4.50, 

      11 => 4.25, 

      12 => 4.00, 

      13 => 1.20, 

      14 => 1.20, 

      15 => 1.15, 

      16 => 1.40, 

      17 => 0.95, 

      18 => 1.05, 

      19 => 1.05, 

      20 => 1.00, 

      21 => 7, 
       
      22 => true, 

      23 => 1.05, 

      24 => 1.05, 

      25 => 1.05,

      26 => 1.05, 

      27 => 1.05, 

      28 => 1.05

   ), 



   5 => array( 

      0 => 'Ferengi', 

      1 => 0.8, 

      2 => 0.75, 

      3 => 0.85, 

      4 => 0.9, 

      5 => 0.85, 

      6 => 0.80, 

      7 => 1.05, 

      8 => 0.9, 

      9 => 1.8, 

      10 => 1.8, 

      11 => 1.9, 

      12 => 1.2, 

      13 => 0.6, 

      14 => 0.9, 

      15 => 0.95, 

      16 => 0.95, 

      17 => 1.0, 

      18 => 1.0, 

      19 => 1.0, 

      20 => 0.7, 

      21 => 2.5, 
       
      22 => false, 

      23 => 0.8, 

      24 => 0.9, 

      25 => 1.2,

      26 => 0.8, 

      27 => 1.0, 

      28 => 1.2

), 



    6 => array( 

       0 => 'Borg', 

       1 => 1.0, 

       2 => 1.0, 

       3 => 1.0, 

       4 => 1.0, 

       5 => 1.0, 

       6 => 1.0, 

       7 => 1.0, 

       8 => 1.0, 

       9 => 1.0, 

       10 => 1.0, 

       11 => 1.0, 

       12 => 1.0, 

       13 => 1.0, 

       14 => 1.0, 

       15 => 1.0, 

       16 => 1.0, 

       17 => 1.0, 

        18 => 1.0, 

        19 => 1.0, 

        20 => 1.0, 

        21 => 1, 
       
      22 => false,

      23 => 1.0, 

      24 => 1.0, 

      25 => 1.0,

      26 => 1.0, 

      27 => 1.0, 

      28 => 1.0

    ), 



    7 => array( 

        0 => 'Q', 

       1 => 1.0, 

       2 => 1.0, 

       3 => 1.0, 

       4 => 1.0, 

       5 => 1.0, 

       6 => 1.0, 

       7 => 1.0, 

       8 => 1.0, 

       9 => 1.0, 

       10 => 1.0, 

       11 => 1.0, 

       12 => 1.0, 

       13 => 1.0, 

       14 => 1.0, 

       15 => 1.0, 

       16 => 1.0, 

       17 => 1.0, 

        18 => 1.0, 

        19 => 1.0, 

        20 => 1.0, 

        21 => 1, 
       
      22 => false, 

      23 => 1.0, 

      24 => 1.0, 

      25 => 1.0,

      26 => 1.0, 

      27 => 1.0, 

      28 => 1.0

     ), 



    8 => array( 

      0 => 'Breen', 

       1 => 1.15, 

       2 => 1.05, 

       3 => 1.15, 

       4 => 1.2, 

       5 => 1.1, 

      6 => 1.1, 

      7 => 1.0, 

      8 => 1.15, 

      9 => 0.8, 

      10 => 1.05, 

      11 => 0.9, 

       12 => 0.8, 

       13 => 0.85, 

       14 => 1.2, 

       15 => 1.05, 

      16 => 1.0, 

      17 => 1.0, 

      18 => 1.1, 

       19 => 1.0, 

      20 => 1.0, 

      21 => 5, 
       
      22 => false,

      23 => 0.7, 

      24 => 1.1, 

      25 => 0.8,

      26 => 0.5, 

      27 => 1.2, 

      28 => 0.9

   ), 



    9 => array( 

      0 => 'Hirogen',

      1 => 1.2,

      2 => 1.1,

      3 => 1.1,

      4 => 1.1,

      5 => 0.95,

      6 => 1.2,

      7 => 1.05,

      8 => 1.2,

      9 => 1.1,

      10 => 1.0,

      11 => 0.9,

      12 => 0.8,

      13 => 1.2,

      14 => 1.2,

      15 => 1.2,

      16 => 1.3,

      17 => 0.8,

      18 => 0.95,

      19 => 1.15,

      20 => 1.0,

      21 => 5, 
       
      22 => false,

      23 => 0.95, 

      24 => 1.0, 

      25 => 1.0,

      26 => 1.15, 

      27 => 1.15, 

      28 => 1.2

   ), 



    10 => array( 

      0 => 'Krenim', 

      1 => 1.05, 

      2 => 0.9, 

      3 => 1.05, 

      4 => 1.05, 

      5 => 1.0, 

      6 => 1.05, 

      7 => 1.05, 

      8 => 0.8, 

      9 => 1.05, 

      10 => 0.85, 

      11 => 1.0, 

      12 => 1.25, 

      13 => 1.0, 

      14 => 0.85, 

      15 => 0.85, 

      16 => 0.9, 

      17 => 1.1, 

      18 => 1.05, 

      19 => 1.1, 

      20 => 1.15, 

      21 => 3, 
       
      22 => false, 

      23 => 0.9, 

      24 => 0.9, 

      25 => 0.9,

      26 => 0.9, 

      27 => 0.9, 

      28 => 0.9

   ), 

    

    

    11 => array( 

      0 => 'Kazon', 

       1 => 1.15, 

      2 => 0.6, 

       3 => 1.05, 

       4 => 1.2, 

      5 => 1.0, 

       6 => 0.95, 

       7 => 1.0, 

      8 => 0.9, 

       9 => 1.0, 

      10 => 0.9, 

       11 => 1.2, 

      12 => 0.8, 

      13 => 1.1, 

      14 => 1.35, 

      15 => 0.9, 

      16 => 1.15, 

      17 => 0.8, 

      18 => 1.2, 

      19 => 0.7, 

      20 => 0.9, 

      21 => 4, 
       
      22 => false, 

      23 => 1.1, 

      24 => 1.0, 

      25 => 1.1,

      26 => 1.0, 

      27 => 1.0, 

      28 => 1.0

    ), 





   12 => array( 

      0 => 'Menschen 29th', 

      1 => 1.0, 

      2 => 0.8, 

      3 => 1.0, 

      4 => 1.0, 

      5 => 1.0, 

      6 => 1.0, 

      7 => 1.0, 

      8 => 1.0, 

      9 => 1.0, 

      10 => 1.0, 

      11 => 1.0, 

      12 => 1.0, 

      13 => 1.0, 

      14 => 1.0, 

      15 => 1.0, 

      16 => 1.0, 

      17 => 1.0, 

      18 => 1.0, 

      19 => 0.75, 

      20 => 1.1, 

      21 => 3, 
       
      22 => false, 

      23 => 1.0, 

      24 => 1.0, 

      25 => 1.0,

      26 => 1.0, 

      27 => 1.0, 

      28 => 1.0

   ), 




   13 => array( 

      0 => 'Siedler', 

      1 => 1.0, 

      2 => 0.8, 

      3 => 1.0, 

      4 => 1.0, 

      5 => 1.0, 

      6 => 1.0, 

      7 => 1.0, 

      8 => 1.0, 

      9 => 1.0, 

      10 => 1.0, 

      11 => 1.0, 

      12 => 1.0, 

      13 => 1.0, 

      14 => 1.0, 

      15 => 1.0, 

      16 => 1.0, 

      17 => 1.0, 

      18 => 1.0, 

      19 => 0.75, 

      20 => 1.1, 

      21 => 3, 
       
      22 => false, 

      23 => 1.0, 

      24 => 1.0, 

      25 => 1.0,

      26 => 1.0, 

      27 => 1.0, 

      28 => 1.0

   ), 
); 

?> 
