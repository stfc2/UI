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

0 => Föderation
1 => Romulaner 
2 => Klingonen 
3 => Cardassianer
4 => Dominion
5 => Ferengi 
 6 => Borg
 7 => Q
8 => Breen
9 => Hirogen
10 => Vidiianer ==> Krenim 
11 => Kazon
 12 => Menschen 29th
 13 => Siedler

 * 0 => Name der Rasse 

 * 1 => Bauzeit (Gebäude) 

 * 2 => Bauzeit (Einheiten) 

 * 3 => Bauzeit (Schiffe) 

 * 4 => Forschungszeit 

 * 5 => Baukosten (Gebäude) 

 * 6 => Baukosten (Einheiten) 

 * 7 => Baukosten (Schiffe) 

 * 8 => Forschungskosten 

 * 9 => Metallminenausbeute 

 * 10 => Mineralienminenausbeute 

 * 11 => Latinumraffinerieausbeute 

 * 12 => "Arbeiterausbeute" 

 * 13 => Schiffsangriff 

 * 14 => Einheitenangriff 

 * 15 => Schiffsverteidigung 

 * 16 => Einheitenverteidigung 

 * 17 => Gebäudeverteidigung (gegen planetare Angriffe) 

 * 18 => Schiffsgeschwindigkeit 

 * 19 => Sensorenreichweite 

 * 20 => Technologieausnutzung (Verändert den Wirkungsgrad ALLER Technologien) 

 * 21 => Kampfkraft der Arbeiter 
  
 * 22 => playable 

 * 23 => Metkostenfaktor für Gebäude

 * 24 => Minkostenfaktor für Gebäude

 * 25 => Latkostenfaktor für Gebäude

 */ 



$RACE_DATA = array( 

   0 => array( 

      0 => 'Föderation', 

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

      20 => 1.1, 

      21 => 3, 
       
      22 => true,

      23 => 1.0, 

      24 => 1.0, 

      25 => 0.4,

      26 => 1.1, 

      27 => 1.1, 

      28 => 1.0
   ), 



   1 => array( 

      0 => 'Romulaner', 

      1 => 1.0, 

      2 => 0.95, 

      3 => 0.90, 

      4 => 1.0,

      5 => 1.05, 

      6 => 0.80, 

      7 => 0.95, 

      8 => 1.1, 

      9 => 1.25, 

      10 => 1.25, 

      11 => 0.7, 

      12 => 1.1, 

      13 => 0.9,

      14 => 1.0, 

      15 => 0.95, 

      16 => 0.85, 

      17 => 0.95, 

      18 => 0.75, 

      19 => 0.90, 

      20 => 1.00,

      21 => 3.5, 
       
      22 => true, 

      23 => 1.1, 

      24 => 0.9, 

      25 => 0.8,

      26 => 1.15, 

      27 => 0.8, 

      28 => 1.1

   ), 



    2 => array( 

      0 => 'Klingonen', 

       1 => 1.25, 

       2 => 1.2, 

       3 => 1.1, 

       4 => 1.2, 

       5 => 1.05, 

       6 => 1.05,

      7 => 1.05, 

      8 => 1.35,

       9 => 1.1,

      10 => 1.1, 

      11 => 0.9,

      12 => 0.8,

      13 => 1.4,

      14 => 1.5,

      15 => 1.2,

      16 => 1.2,

      17 => 1.05,

      18 => 0.85,

      19 => 0.7,

      20 => 0.9, 

      21 => 6, 

      22 => true,

      23 => 1.05, 

      24 => 1.05, 

      25 => 0.6,

      26 => 1.35, 

      27 => 1.35, 

      28 => 0.9

   ), 



    3 => array( 

      0 => 'Cardassianer', 

      1 => 1.05, 

      2 => 0.95, 

      3 => 1.05, 

      4 => 1.0, 

      5 => 1.0, 

      6 => 0.9, 

      7 => 0.9, 

      8 => 1.0, 

      9 => 1.1, 

      10 => 1.0, 

      11 => 1.0, 

      12 => 1.15, 

      13 => 1.1, 

      14 => 1.1, 

      15 => 0.95, 

      16 => 1.05, 

      17 => 1.0, 

      18 => 0.9, 

      19 => 1.0, 

      20 => 1.0, 

      21 => 3, 
       
      22 => true, 

      23 => 1.0, 

      24 => 1.0, 

      25 => 0.6,

      26 => 1.35, 

      27 => 1.35, 

      28 => 0.9

    ), 



   4 => array( 

      0 => 'Dominion', 

      1 => 1.20, 

      2 => 0.95, 

      3 => 1.05, 

      4 => 1.2, 

      5 => 1.05, 

      6 => 1.05, 

      7 => 1.15, 

      8 => 1.25, 

      9 => 0.94, 

      10 => 0.94, 

      11 => 0.89, 

      12 => 0.75, 

      13 => 1.35, 

      14 => 1.15, 

      15 => 1.15, 

      16 => 1.25, 

      17 => 0.95, 

      18 => 1.05, 

      19 => 1.0, 

      20 => 0.85, 

      21 => 2, 
       
      22 => true, 

      23 => 1.3, 

      24 => 1.0, 

      25 => 0.2,

      26 => 1.3, 

      27 => 1.3, 

      28 => 0.4

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
       
      22 => true, 

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
       
      22 => true,

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
       
      22 => true,

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
       
      22 => true, 

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
       
      22 => true, 

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
