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



include_once('|script_dir|/config.inc.php');

// Zeilenumbruch

define('NL', "\n");



// Dauer eines Ticks in Minuten

define('TICK_DURATION', 3);


// Time offset

define('TIME_OFFSET', 7200); // 3600 = Winterzeit, 7200 = Sommerzeit



// Kapazitäten eines Transporters

define('MAX_TRANSPORT_RESOURCES', 4000);

define('MAX_TRANSPORT_UNITS', 400);



// Min. Truppen pro Planet

define('MIN_TROOPS_PLANET', 50);



// user_auth_level-Konstantwerte

define('STGC_PLAYER', 1);

define('STGC_SUPPORTER', 2);

define('STGC_DEVELOPER', 3);

define('STGC_BOT', 4);

define('STGC_RACEMAKER', 5);



// UIDs

define('Q_UID', 1);

define('DATA_UID', 2);



// Logbuch-Konstantwerte

define('LOGBOOK_TACTICAL', 1);

define('LOGBOOK_UDIPLOMACY', 2);

define('LOGBOOK_ALLIANCE', 3);

define('LOGBOOK_GOVERNMENT', 4);

define('LOGBOOK_AUCTION_VENDOR', 5);

define('LOGBOOK_AUCTION_PURCHASER', 6);

define('LOGBOOK_TACTICAL_SHIPFIGHT', 7);

define('LOGBOOK_FERENGITAX', 8);

define('LOGBOOK_REVOLUTION', 9);

define('LOGBOOK_TACTICAL_2', 10);

// Ferengi NPC-Händler:

define('FERENGI_TRADESHIP_ID', 2); // <-- Template, not ship!

define('FERENGI_USERID', 3);


// Unabhängigen-NPC:

define('INDEPENDENT_USERID', 4);


// Supportuser-ID:

define('SUPPORTUSER', 5);


// Schiffstypen-Konstantwerte

define('SHIP_TYPE_SCOUT', 0); // Wenn dies geändert wird, UNBEDINGT action_22.php updaten!

                              // Ich hab dort eine Optimierung, die erfordert, dass Scouts

                              // die niedrigste aller torso-IDs haben

define('SHIP_TYPE_TRANSPORTER', 1);

define('SHIP_TYPE_COLO', 2);

define('SHIP_TYPE_ORB', 12); // Mobile Orbitalgeschütze



// Alarmstufe-Konstantwerte

define('ALERT_PHASE_GREEN', 0);

define('ALERT_PHASE_YELLOW', 1);

define('ALERT_PHASE_RED', 2);



// Allianzstatus-Konstantwerte

define('ALLIANCE_STATUS_MEMBER', 1);

define('ALLIANCE_STATUS_ADMIN', 2);

define('ALLIANCE_STATUS_OWNER', 3);

define('ALLIANCE_STATUS_DIPLO', 4);


// Allianzdiplomatie-Konstantwerte

define('ALLIANCE_DIPLOMACY_WAR', 1);

define('ALLIANCE_DIPLOMACY_NAP', 2);

define('ALLIANCE_DIPLOMACY_PACT', 3);



define('PLANETARY_DEFENSE_ATTACK',50);

define('PLANETARY_DEFENSE_ATTACK2',175);

define('PLANETARY_DEFENSE_DEFENSE',250);



define('SPLANETARY_DEFENSE_ATTACK',150);

define('SPLANETARY_DEFENSE_ATTACK2',0);

define('SPLANETARY_DEFENSE_DEFENSE',200);



define('USER_ATTACK_PROTECTION', 2800);

define('USER_MIN_CANCEL_ATKPTC', 1000);



// Für parse_link_ex()

define('LINK_CLICKID', 1);



define('GENERAL', 1);

define('DATABASE_ERROR', 2);

define('NOTICE', 3);





// Beschleuningt den Scheduler

$addres = array(

    0 => 1,

    1 => 1.045,

    2 => 1.0875,

    3 => 1.1225,

    4 => 1.165,

    5 => 1.2,

    6 => 1.2325,

    7 => 1.2625,

    8 => 1.29,

    9 => 1.315,

    10 => 1.315, // Override "bug" buildings

    11 => 1.315, // Override "bug" buildings

    12 => 1.315, // Override "bug" buildings

    13 => 1.315, // Override "bug" buildings

    14 => 1.315, // Override "bug" buildings

    15 => 1.315, // Override "bug" buildings

);











// Ship-rank informations:

$ship_ranks = array(

0=>0,

1=>10,

2=>50,

3=>60,

4=>70,

5=>80,

6=>90,

7=>99,

8=>100,

9=>101,

);



$ship_rank_bonus = array(

0=>0,

1=>.02,

2=>.05,

3=>.08,

4=>.12,

5=>.16,

6=>.20,

7=>.24,

8=>.28,

9=>.32,

);







// Tick informations:

$MAX_RESEARCH_LVL = array(

     0 => array( // No capital planet

        0 => 9,

        1 => 9,

        2 => 9,

        3 => 9,

        4 => 9,

    ),

    1 => array( // Capital planet

        0 => 15,

        1 => 15,

        2 => 15,

        3 => 15,

        4 => 9,

    ),

);

$MAX_BUILDING_LVL = array(

     0 => array( // No capital planet

        0 => 9,

        1 => 9,

        2 => 9,

        3 => 9,

        4 => 9,

        5 => 9,

        6 => 9,

        7 => 9,

        8 => 9,

        9 => 15,

        10 => 9,

        11 => 9,

        12 => 15,

    ),

     1 => array( // Capital planet

        0 => 9,

        1 => 15,

        2 => 15,

        3 => 15,

        4 => 16,

        5 => 9,

        6 => 15,

        7 => 9,

        8 => 9,

        9 => 20,

        10 => 9,

        11 => 15,

        12 => 20,

    )

);



$MAX_POINTS = array(

    0 => 677,

    1 => 1173,

);



$NUM_BUILDING = 12; // 0-x von daher bei 12 Gebäuden == 11


/* Raumhafen Ausbaustufe => nummber of ships

Original version: 
$MAX_SPACEDOCK_SHIPS = array(
    0 => 0,
    1 => 5,
	2 => 10,
	3 => 20,
	4 => 35,
	5 => 55,
	6 => 100,
	7 => 300,
	8 => 600,
	9 => 1000,
);
*/

$MAX_SPACEDOCK_SHIPS = array(

    0 => 0,

    1 => 1000000,
	
	2 => 1000000,
	
	3 => 1000000,
	
	4 => 1000000,
	
	5 => 1000000,
	
	6 => 1000000,
	
	7 => 1000000,
	
	8 => 1000000,
	
	9 => 1000000,
        10 => 1000000,
        11 => 1000000,
        12 => 1000000,
        13 => 1000000,
        14 => 1000000,
        15 => 1000000,
     
);


$QUADRANT_NAME = array(

    1 => 'Gamma-Quadrant',

    2 => 'Delta-Quadrant',

    3 => 'Alpha-Quadrant',

    4 => 'Beta-Quadrant'

);







/*

 * 0 => Metall

 * 1 => Mineralien

 * 2 => Latinum

 * 3 => Arbeiter

 * 4 => Bauzeit

 * 5 => Angriff

 * 6 => Verteidigung

 */



$UNIT_DATA = array( 

    0 => array( 

        0 => 80, 

        1 => 35, 

        2 => 0, 

        3 => 2, 

        4 => 2, 

        5 => 50, 

        6 => 40, 

    ), 



    1 => array( 

        0 => 120, 

        1 => 55, 

        2 => 0, 

        3 => 3, 

        4 => 3, 

        5 => 100, 

        6 => 140, 

    ), 



    2 => array( 

        0 => 450, 

        1 => 280, 

        2 => 230, 

        3 => 6, 

        4 => 8, 

        5 => 400, 

        6 => 400, 

    ), 



    3 => array( 

        0 => 300, 

        1 => 150, 

        2 => 75, 

        3 => 4, 

        4 => 9, 

        5 => 50, 

        6 => 25, 

    ), 



    4 => array( 

        0 => 450, 

        1 => 270, 

        2 => 125, 

        3 => 10, 

        4 => 5, 

        5 => 0, 

        6 => 0, 

    ), 



    5 => array( 

        0 => 750, 

        1 => 400, 

        2 => 150, 

        3 => 12, 

        4 => 7, 

        5 => 0, 

        6 => 0, 

    ), 

); 




/*

 * 0 => Metall

 * 1 => Mineralien

 * 2 => Latinum

 * 3 => Bauzeit

 * 4 => Bauzeitanstieg pro Lv

 */



$BUILDING_DATA = array(

    // Hauptquartier

    0 => array(

        0 => 5,

        1 => 3.87,

        2 => 0,

        3 => 36,

        4 => 1.25,

    ),



    // Metallminen

    1 => array(

        0 => 5.47,

        1 => 4.47,

        2 => 0,

        3 => 9,

        4 => 1.5,

    ),



    // Mineralienminen

    2 => array(

        0 => 5,

        1 => 4.47,

        2 => 0,

        3 => 9,

        4 => 1.6,

    ),



    // Latinumraffinerie

    3 => array(

        0 => 7.07,

        1 => 5.47,

        2 => 0,

        3 => 9,

        4 => 1.75,

    ),



    // Kraftwerk

    4 => array(

        0 => 5,

        1 => 3.535,

        2 => 0,

        3 => 36,

        4 => 0,

    ),



    // Akademie

    5 => array(

        0 => 5,

        1 => 4.47,

        2 => 2.23,

        3 => 36,

        4 => 1.6,

    ),



    // Raumhafen

    6 => array(

        0 => 5,

        1 => 3.87,

        2 => 3.16,

        3 => 45,

        4 => 1.6,

    ),



    // Schiffswerft

    7 => array(

        0 => 5.47,

        1 => 4.47,

        2 => 4.47,

        3 => 36,

        4 => 1.65,

    ),



    // Forschungszentrum

    8 => array(

        0 => 7.07,

        1 => 7.07,

        2 => 7.07,

        3 => 108,

        4 => 1.7,

    ),



    // Planetare Verteidigung

    9 => array(

        0 => 15000,

        1 => 15000,

        2 => 15000,

        3 => 90,

        4 => 0,

    ),



    // Handelszentrum

    10 => array(

        0 => 5,

        1 => 4.47,

        2 => 2.23,

        3 => 8,

        4 => 1.6,

    ),

    // Lagerhallen

    11 => array(

        0 => 5,

        1 => 4.07,

        2 => 2.03,

        3 => 12,

        4 => 1.45,

    ),





    // Planetare Verteidigung

    12 => array(

        0 => 5000,

        1 => 5000,

        2 => 5000,

        3 => 40,

        4 => 0,

    ),



);







/**

 * 0 => Metall

 * 1 => Mineralien

 * 2 => Latinum

 * 3 => Forschzeit

 * 4 => Forschzeitanstieg pro Lv

 */



$TECH_DATA = array(

    // Schiffswaffen

    0 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2.2,

    ),



    // Warpfeld

    1 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2,

    ),



    // Schildforschung

    2 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2,

    ),



    // Infaterietaktik

    3 => array(

        0 => 37,

        1 => 37,

        2 => 34,

        3 => 80,

        4 => 2.2,

    ),



    // Sensoren

    4 => array(

        0 => 35,

        1 => 35,

        2 => 35,

        3 => 90,

        4 => 2,

    ),



    // Terraforming

    5 => array(

        0 => 10,

        1 => 10,

        2 => 10,

        3 => 24,

        4 => 1.75,

    ),



    // Medizinische Forschung

    6 => array(

        0 => 10,

        1 => 10,

        2 => 10,

        3 => 30,

        4 => 1.75,

    ),



    // Planetare Verteidigung

    7 => array(

        0 => 10,

        1 => 10,

        2 => 10,

        3 => 31,

        4 => 1.75,

    ),



    // Automatisierung

    8 => array(

        0 => 30,

        1 => 30,

        2 => 30,

        3 => 24,

        4 => 2.15,

    ),



    // Rohstoffverarbeitung

    9 => array(

        0 => 32,

        1 => 32,

        2 => 24,

        3 => 30,

        4 => 1.75,

    ),

);





$WARP_FACTOR_BASE = 4;

$SYSTEM_WIDTH = 504; // Lichtminuten



$ENGINE_RESEARCH_LEVEL = array(

    0 => 4.3,

    1 => 4.9,

    2 => 5.5,

    3 => 6.1,

    4 => 6.7,

    5 => 7.3,

    6 => 7.8, // + 5

    7 => 8.3, // + 4

    8 => 8.7, // + 3

    9 => 9.0,

);









/*

 * 0 => Metall pro Tick

 * 1 => Mineralien pro Tick

 * 2 => Latinum pro Tick

 * 3 => Arbeiter pro Tick

 * 4 => Baukosten

 * 5 => Bauzeit

 * 6 => maximale Ressourcen

 * 7 => maximale Einheiten

 * 8 => Größe

 * 9 => Farbe

 * 10 => Einheitenkosten

 * 11 => Einheitenbauzeit

 * 12 => Forschungskosten

 * 13 => Forschungsdauer

 */



$PLANETS_DATA = array(

    'a' => array(

         0 => 3.0,

         1 => 0.1,

         2 => 0.8,

         3 => 0.1,

         4 => 3.0,

         5 => 2.5,

         6 => 20000,
//         6 => 200000,
         7 => 3000,

         8 => 10,

         9 => array(187, 101, 50),

	 10 => 1.0,

	 11 => 1.0,

	 12 => 1.0,

	 13 => 1.0,

    ),



    'b' => array(

         0 => 3.0,

         1 => 0.1,

         2 => 0.8,

         3 => 0.1,

         4 => 3.0,

         5 => 2.5,

         6 => 12000,
//         6 => 120000,
         7 => 2000,

         8 => 9,

         9 => array(206, 187, 85),

	 10 => 1.0,

	 11 => 1.0,

	 12 => 1.0,

	 13 => 1.0,

    ),



    'c' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.6,

        4 => 1.5,

        5 => 2.0,

        6 => 28000,
//        6 => 280000,
        7 => 15000,

        8 => 7,

        9 => array(200, 157, 106),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'd' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.5,

        4 => 1.5,

        5 => 2.0,

        6 => 24000,
//        6 => 240000,
        7 => 10000,

        8 => 5,

        9 => array(80, 80, 80),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'e' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.7,

        4 => 1.2,

        5 => 1.6,

        6 => 32000,
//        6 => 320000,
        7 => 20000,

        8 => 7,

        9 => array(43, 56, 163),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'f' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.8,

        4 => 1.0,

        5 => 1.4,

        6 => 36000,
//        6 => 360000,
        7 => 22000,

        8 => 7,

        9 => array(75, 166, 75),

	 10 => 1.0

    ),



    'g' => array(

        0 => 1.5,

        1 => 1.0,

        2 => 1.0,

        3 => 0.8,

        4 => 1.2,

        5 => 1.2,

        6 => 36000,
//        6 => 360000,
        7 => 20000,

        8 => 7,

        9 => array(154, 39, 17),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'h' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.5,

        4 => 1.2,

        5 => 1.5,

        6 => 20000,
//        6 => 200000,
        7 => 10000,

        8 => 4,

        9 => array(193, 10, 10),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'i' => array(

        0 => 0.3,

        1 => 1.6,

        2 => 1.6,

        3 => 0.5,

        4 => 1.2,

        5 => 1.6,

        6 => 32000,
//        6 => 320000,
        7 => 1300,

        8 => 7,

        9 => array(212, 149, 11),

	10 => 2.0,

	11 => 2.0,

	12 => 2.0,

	13 => 2.0,
/*
	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,
*/
    ),



    'j' => array(

        0 => 0.3,

        1 => 2.0,

        2 => 0.4,

        3 => 0.6,

        4 => 1.1,

        5 => 1.5,

        6 => 26000,
//        6 => 260000,
        7 => 12000,

        8 => 6,

        9 => array(116, 104, 116),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'k' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.4,

        4 => 1.1,

        5 => 1.5,

        6 => 24000,
//        6 => 240000,
        7 => 11000,

        8 => 5,

        9 => array(150, 111, 83),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'l' => array(

        0 => 0.4,

        1 => 1.9,

        2 => 0.5,

        3 => 0.7,

        4 => 1.0,

        5 => 1.1,

        6 => 22000,
//        6 => 220000,
        7 => 10000,

        8 => 5,

        9 => array(68, 107, 183),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'm' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 1.0,

        4 => 1.0,

        5 => 1.0,

        6 => 40000,
//	    6 => 400000,
        7 => 36000,

        8 => 7,

        9 => array(50, 50, 180),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'n' => array(

        0 => 0.95,

        1 => 0.95,

        2 => 0.95,

        3 => 1.1,

        4 => 1.0,

        5 => 1.0,

        6 => 50000,
//	    6 => 500000,
        7 => 40000,

        8 => 7,

        9 => array(0, 0, 180),

	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,

    ),



    'y' => array(

        0 => 2.5,

        1 => 2.5,

        2 => 2.5,

        3 => 0.2,

        4 => 4.0,

        5 => 3.0,

        6 => 20000,
//        6 => 200000,
        7 => 7000,

        8 => 6,

        9 => array(125, 0 , 0),

	10 => 2.0,

	11 => 2.0,

	12 => 2.0,

	13 => 2.0,
/*
	10 => 1.0,

	11 => 1.0,

	12 => 1.0,

	13 => 1.0,
*/
    )

);


?>
