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



include_once('/home/taku/public_html/stfc/config2.inc.php');

// Line break

define('NL', "\n");



// Duration of ticks in minutes

define('TICK_DURATION', 3);


// Time offset

define('TIME_OFFSET', 3600); // 3600 = Winter time, 7200 = Summer time - AC: DO NOT USE ANYMORE!



// Capacity of a transporter

define('MAX_TRANSPORT_RESOURCES', 4000);

define('MAX_TRANSPORT_UNITS', 400);



// Min. Troops per Planet

define('MIN_TROOPS_PLANET', 50);



// user_auth_level - Constant values

define('STGC_PLAYER', 1);

define('STGC_SUPPORTER', 2);

define('STGC_DEVELOPER', 3);

define('STGC_BOT', 4);

define('STGC_RACEMAKER', 5);



// UIDs

define('Q_UID', 1);

define('DATA_UID', 2);



// Logbuch - Constant values

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

define('LOGBOOK_SURVEY', 11);

// Ferengi NPC-Dealers:

define('FERENGI_TRADESHIP_ID', 2); // <-- Template, not ship!

define('FERENGI_USERID', 3);


// Independent-NPC:

define('INDEPENDENT_USERID', 4);


// Supportuser-ID:

define('SUPPORTUSER', 5);

// Borg NPC:

define('BORG_USERID', 6);

// Future Humans

define('FUTURE_HUMANS_UID', 7);

// Ship types - Constant values

define('SHIP_TYPE_SCOUT', 0); // If this is changed, STRICTLY update action_22.php!

                              // I have an optimization that requires scouts

                              // has the lowest of all torso IDs

define('SHIP_TYPE_TRANSPORTER', 1);

define('SHIP_TYPE_COLO', 2);

define('SHIP_TYPE_ORB', 12); // Mobile Orbital gun



// Alarm status - Constant values

define('ALERT_PHASE_GREEN', 0);

define('ALERT_PHASE_YELLOW', 1);

define('ALERT_PHASE_RED', 2);



// Alliance status - Constant values

define('ALLIANCE_STATUS_MEMBER', 1);

define('ALLIANCE_STATUS_ADMIN', 2);

define('ALLIANCE_STATUS_OWNER', 3);

define('ALLIANCE_STATUS_DIPLO', 4);


// Alliance diplomacy - Constant values

define('ALLIANCE_DIPLOMACY_WAR', 1);

define('ALLIANCE_DIPLOMACY_NAP', 2);

define('ALLIANCE_DIPLOMACY_PACT', 3);



define('PLANETARY_DEFENSE_ATTACK',100);

define('PLANETARY_DEFENSE_ATTACK2',400);

define('PLANETARY_DEFENSE_DEFENSE',2500);



define('SPLANETARY_DEFENSE_ATTACK',350);

define('SPLANETARY_DEFENSE_ATTACK2',0);

define('SPLANETARY_DEFENSE_DEFENSE',1000);



define('USER_ATTACK_PROTECTION', 2800);

define('USER_MIN_CANCEL_ATKPTC', 1000);



// For parse_link_ex()

define('LINK_CLICKID', 1);



define('GENERAL', 1);

define('DATABASE_ERROR', 2);

define('NOTICE', 3);



// Constants for ships's refit
define('REFIT_TICK', 5);

define('NEXT_REFIT_TICK', 2400);

// Possible values of ship_untouchable
define('SHIP_IS_READY', 0);

define('SHIP_IN_REPAIR', 1);

define('SHIP_IN_REFIT', 2);

// Valore indicativo di controllo decadenza scafo

define('SHIP_RUST_CHECK', 700);


// Planets and colonies names
define ('UNINHABITATED_PLANET', 'Inesplorato');

define ('UNINHABITATED_COLONY', 'Isolato');


// User can choose initial planet's quadrant
define ('USER_CHOOSE_QUADRANT', 1);

// User start with a whole system
define ('USER_WHOLE_SYSTEM', 1);


// Alliances Names
define ('ALLIANCE_UFP_NAME', 'United Federation of Planets');

define ('ALLIANCE_RE_NAME', 'Romulan Star Empire');  // Romulan Empire

define ('ALLIANCE_KE_NAME', 'Klingon Empire');  // Klingon Empire

define ('ALLIANCE_CU_NAME', 'Cardassian Union');  // Cardassian Union

define ('ALLIANCE_D_NAME', 'Dominion');   // Dominion

// Alliances Tags
define ('ALLIANCE_UFP_TAG', 'UFP'); // United Federation of Planets

define ('ALLIANCE_RE_TAG', 'RSE');  // Romulan Empire

define ('ALLIANCE_KE_TAG', 'KE');  // Klingon Empire

define ('ALLIANCE_CU_TAG', 'CU');  // Cardassian Union

define ('ALLIANCE_D_TAG', 'DOM');   // Dominion

// Alliances Logos
define ('ALLIANCE_UFP_LOGO', 'emblems/United_Federation_of_Planets_logo.png'); // United Federation of Planets

define ('ALLIANCE_RE_LOGO', 'emblems/Romulan_Star_Empire_logo.png');  // Romulan Empire

define ('ALLIANCE_KE_LOGO', 'emblems/Klingon_Empire_logo.png');  // Klingon Empire

define ('ALLIANCE_CU_LOGO', 'emblems/Cardassian_Union_logo.png');  // Cardassian Union

define ('ALLIANCE_D_LOGO', 'emblems/Dominion_logo.png');   // Dominion


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



$NUM_BUILDING = 12; // 0-x therefore 12 Buildings == 11


/* Space port expansion stage => number of ships */

$MAX_SPACEDOCK_SHIPS = array(
	0 => 0,
	1 => 10,
	2 => 20,
	3 => 30,
	4 => 40,
	5 => 50,
	6 => 60,
	7 => 70,
	8 => 80,
	9 => 90,
	10 => 100,
	11 => 110,
	12 => 120,
	13 => 130,
	14 => 140,
	15 => 150,
);

/* Non sense version: 
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
*/

$QUADRANT_NAME = array(

    1 => 'Gamma-Quadrant',

    2 => 'Delta-Quadrant',

    3 => 'Alpha-Quadrant',

    4 => 'Beta-Quadrant'

);







/*

 * 0 => Metall

 * 1 => Minerals

 * 2 => Dilithium

 * 3 => Workers

 * 4 => Construction period

 * 5 => Attack

 * 6 => Defence

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

 * 0 => Metal

 * 1 => Minerals

 * 2 => Dilithium

 * 3 => Construction period

 * 4 => Construction period increase per Lev

 */



$BUILDING_DATA = array(

    // Headquarter

    0 => array(

        0 => 5,

        1 => 3.87,

        2 => 0,

        3 => 36,

        4 => 1.25,

    ),



    // Metal mines

    1 => array(

        0 => 5.47,

        1 => 4.47,

        2 => 0,

        3 => 9,

        4 => 1.5,

    ),



    // Minerals mines

    2 => array(

        0 => 5,

        1 => 4.47,

        2 => 0,

        3 => 9,

        4 => 1.6,

    ),



    // Dilithium refinery

    3 => array(

        0 => 7.07,

        1 => 5.47,

        2 => 0,

        3 => 9,

        4 => 1.75,

    ),



    // Power plant

    4 => array(

        0 => 5,

        1 => 3.535,

        2 => 0,

        3 => 36,

        4 => 0,

    ),



    // Academy

    5 => array(

        0 => 5,

        1 => 4.47,

        2 => 2.23,

        3 => 36,

        4 => 1.6,

    ),



    // Space port

    6 => array(

        0 => 5,

        1 => 3.87,

        2 => 3.16,

        3 => 45,

        4 => 1.6,

    ),



    // Shipyard

    7 => array(

        0 => 5.47,

        1 => 4.47,

        2 => 4.47,

        3 => 36,

        4 => 1.65,

    ),



    // Research Center

    8 => array(

        0 => 7.07,

        1 => 7.07,

        2 => 7.07,

        3 => 108,

        4 => 1.7,

    ),



    // Planetary Defense

    9 => array(

        0 => 15000,

        1 => 15000,

        2 => 15000,

        3 => 90,

        4 => 0,

    ),



    // Trade Centre

    10 => array(

        0 => 5,

        1 => 4.47,

        2 => 2.23,

        3 => 8,

        4 => 1.6,

    ),

    // Warehouses

    11 => array(

        0 => 5,

        1 => 4.07,

        2 => 2.03,

        3 => 12,

        4 => 1.45,

    ),





    // Planetary Defense

    12 => array(

        0 => 5000,

        1 => 5000,

        2 => 5000,

        3 => 40,

        4 => 0,

    ),



);







/**

 * 0 => Metal

 * 1 => Minerals

 * 2 => Dilithium

 * 3 => Forschzeit / Vigorous time?

 * 4 => Forschzeitanstieg pro Lv / Vigorous time rise per Lv?

 */



$TECH_DATA = array(

    // Ship weapons

    0 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2.2,

    ),



    // Warp Field

    1 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2,

    ),



    // Shield research

    2 => array(

        0 => 40,

        1 => 40,

        2 => 40,

        3 => 120,

        4 => 2,

    ),



    // Infaterie tactic

    3 => array(

        0 => 37,

        1 => 37,

        2 => 34,

        3 => 80,

        4 => 2.2,

    ),



    // Sensors

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



    // Medical Research

    6 => array(

        0 => 10,

        1 => 10,

        2 => 10,

        3 => 30,

        4 => 1.75,

    ),



    // Planetary Defense

    7 => array(

        0 => 10,

        1 => 10,

        2 => 10,

        3 => 31,

        4 => 1.75,

    ),



    // Automation

    8 => array(

        0 => 30,

        1 => 30,

        2 => 30,

        3 => 24,

        4 => 2.15,

    ),



    // Raw materials processing

    9 => array(

        0 => 32,

        1 => 32,

        2 => 24,

        3 => 30,

        4 => 1.75,

    ),

);





$WARP_FACTOR_BASE = 4;

$SYSTEM_WIDTH = 504; // Light minutes



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

 * 0 => Metal per Tick

 * 1 => Minerals per Tick

 * 2 => Dilithium per Tick

 * 3 => Workers per Tick

 * 4 => Cost

 * 5 => Construction period

 * 6 => Maximum resources

 * 7 => Maximum units

 * 8 => Size

 * 9 => Color

 * 10 => Unit costs

 * 11 => Unit construction period

 * 12 => Research and development expenses

 * 13 => Research duration

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
