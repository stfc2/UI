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



include_once('/home/admin/config.inc.php');

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

// Logbook - Constant values

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

define('LOGBOOK_SETTLERS', 12);

// UIDs

define('Q_UID', 1);

define('DATA_UID', 2);

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

// Orion NPC:

define('ORION_USERID', 8);

// Non-disclosed USERID

define('UNDISCLOSED_USERID', 9);

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


// Alliance setup
// false = player alliances are not allowed
// true = player alliances are allowed

define('ALLIANCE_ALLOWED', false);

// Alliance status - Constant values

define('ALLIANCE_STATUS_MEMBER', 1);

define('ALLIANCE_STATUS_ADMIN', 2);

define('ALLIANCE_STATUS_OWNER', 3);

define('ALLIANCE_STATUS_DIPLO', 4);


// Alliance diplomacy - Constant values

define('ALLIANCE_DIPLOMACY_WAR', 1);

define('ALLIANCE_DIPLOMACY_NAP', 2);

define('ALLIANCE_DIPLOMACY_PACT', 3);



define('PLANETARY_DEFENSE_ATTACK',700);

define('PLANETARY_DEFENSE_ATTACK2',700);

define('PLANETARY_DEFENSE_DEFENSE',5000);



define('SPLANETARY_DEFENSE_ATTACK',350);

define('SPLANETARY_DEFENSE_ATTACK2',350);

define('SPLANETARY_DEFENSE_DEFENSE',3000);



define('USER_ATTACK_PROTECTION', 2800);

define('USER_MIN_CANCEL_ATKPTC', 1000);



// For parse_link_ex()

define('LINK_CLICKID', 1);



define('GENERAL', 1);

define('DATABASE_ERROR', 2);

define('NOTICE', 3);



// Constants for ships's refit
define('REFIT_TICK', 1);

define('NEXT_REFIT_TICK', 2400);

// Possible values of ship_untouchable
define('SHIP_IS_READY', 0);

define('SHIP_IN_REPAIR', 1);

define('SHIP_IN_REFIT', 2);

// Indicative value of hull loss

define('SHIP_RUST_CHECK', 700);

// Indicative value of the sensor's power, reference value = 200

define ('PLANETARY_SENSOR_VALUE', 800);

// Maximum range for transwarp in ticks
define('MAX_TRANSWARP_RANGE', 120);

// Transwarp cooldown timer
define('TRANSWARP_STD_COOLDOWN', 160);

// Optimum distance from the capital system to gain maximum structure points
define('MAX_BOUND_RANGE', 8000);

// Planets and colonies names
define ('UNINHABITATED_PLANET', 'Inesplorato');

define ('UNINHABITATED_COLONY', 'Isolato');

// Settlers maximum number of planets
define ('SETTLERS_MAX_COLONY', 100);

// User can choose initial planet's quadrant
define ('USER_CHOOSE_QUADRANT', 1);

// User start with a whole system
define ('USER_WHOLE_SYSTEM', 1);

// User start with a boosted capital planet
define ('USER_START_BOOST', 1);

// User maximum number of planets - OBSOLETE
// define ('USER_MAX_PLANETS', 400);
 
// User building queue length
define ('BUILDING_QUEUE_LEN', 6);

// Min. points to create auctions
define ('MIN_POINTS_AUCTIONS', USER_START_BOOST ? 1500 : 400);

//Home Systems Management
// 0 - Home Systems are public
// 1 - Home Systems are private
// 2 - Home Systems are explorable, no action allowed on planets
define ('HOME_SYSTEM_PRIVATE', 1);

//Claim System Management
// 0 - Claims are not allowed
// 1 - Claims are allowed
define ('CLAIM_SYSTEM_PERMITTED', 1);

//Claim System Management
//If used, valid range for claim
define ('CLAIM_SYSTEM_RANGE', 4500);

//Claim System Management
//If used, %cap
define ('CLAIM_SYSTEM_CAP_PERC', 0.50);

//GlobalPointsRequirements 
// false - Not in use
// true - In use
define ('GLOBAL_POINTS_REQUIRED', false);

//Type of movement for tactical map
// 0 - Warp IN
// 1 - Warp OUT
define ('WARP_IN', 0);
define ('WARP_OUT',1);

// Accelerates the Scheduler

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

0=>25,

1=>40,

2=>50,

3=>60,

4=>70,

5=>80,

6=>90,

7=>100,

8=>110,

9=>120,

);



$ship_rank_bonus = array(

0=>0,

1=>0,

2=>0,

3=>.08,

4=>0,

5=>0,

6=>0,

7=>0,

8=>.25,

9=>0,

);

$ship_rank_tier = array(
    
 1=> 140,
 
 2=> 155,
    
 3=> 170,
 
 4=> 185,
    
 5=> 200,
    
);

$officer_rank_bonus = array(
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
    
    10=>.36
);

$ACADEMY_MAJOR_LIST = ['f', 'g', 'm', 'o', 'p'];

$ACADEMY_MINOR_LIST = ['e', 'h', 'k', 'l', 'n'];

$MINE_MAJOR_LIST = ['a', 'b', 'c', 'd', 'x', 'y'];

$MINE_MINOR_LIST = ['i', 'j', 's', 't'];

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

    2 => 320,

);



$NUM_BUILDING = 12; // 0-x therefore 12 Buildings == 11


/* Space port expansion stage => number of ships */

$MAX_SPACEDOCK_SHIPS = array(
	0 => 0,
	1 => 30,
	2 => 60,
	3 => 90,
	4 => 120,
	5 => 150,
	6 => 180,
	7 => 210,
	8 => 240,
	9 => 270,
	10 => 300,
	11 => 330,
	12 => 360,
	13 => 390,
	14 => 420,
	15 => 450,
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

 * 0 => Metal

 * 1 => Minerals

 * 2 => Dilithium

 * 3 => Workers

 * 4 => Construction period

 * 5 => Attack

 * 6 => Defence

 */



$UNIT_DATA = array( 

    0 => array( 

        0 => 89, 

        1 => 34, 

        2 => 0, 

        3 => 1.65, 

        4 => 2, 

        5 => 50, 

        6 => 40, 

    ), 



    1 => array( 

        0 => 191, 

        1 => 159, 

        2 => 0, 

        3 => 2.80, 

        4 => 3, 

        5 => 100, 

        6 => 140, 

    ), 



    2 => array( 

        0 => 728, 

        1 => 744, 

        2 => 592, 

        3 => 9, 

        4 => 8, 

        5 => 400, 

        6 => 400, 

    ), 



    3 => array( 

        0 => 400, 

        1 => 477, 

        2 => 480, 

        3 => 4, 

        4 => 9, 

        5 => 50, 

        6 => 25, 

    ), 



    4 => array( 

        0 => 65, 

        1 => 265, 

        2 => 143, 

        3 => 10, 

        4 => 5, 

        5 => 0, 

        6 => 0, 

    ), 



    5 => array( 

        0 => 46, 

        1 => 224, 

        2 => 373, 

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

        0 => 5.27,

        1 => 4.37,

        2 => 0,

        3 => 9,

        4 => 1.35,

    ),



    // Minerals mines

    2 => array(

        0 => 5.47,

        1 => 4.47,

        2 => 0,

        3 => 9,

        4 => 1.44,

    ),



    // Dilithium refinery

    3 => array(

        0 => 7.07,

        1 => 5.47,

        2 => 0,

        3 => 9,

        4 => 1.575,

    ),



    // Power plant

    4 => array(

        0 => 4,

        1 => 3.535,

        2 => 1.135,

        3 => 36,

        4 => 0,

    ),



    // Academy

    5 => array(

        0 => 4.47,

        1 => 4.47,

        2 => 2.23,

        3 => 36,

        4 => 1.6,

    ),



    // Space port

    6 => array(

        0 => 3.87,

        1 => 5,

        2 => 3.16,

        3 => 45,

        4 => 1.6,

    ),



    // Shipyard

    7 => array(

        0 => 4.47,

        1 => 5.47,

        2 => 4.47,

        3 => 36,

        4 => 1.65,

    ),



    // Research Center

    8 => array(

        0 => 5.656,

        1 => 5.656,

        2 => 7.07,

        3 => 108,

        4 => 1.7,

    ),



    // Planetary Defense

    9 => array(

        0 => 12500,

        1 => 12500,

        2 => 9375,

        3 => 90,

        4 => 0,

    ),



    // Trade Centre

    10 => array(

        0 => 4.47,

        1 => 4.47,

        2 => 2.23,

        3 => 8,

        4 => 1.6,

    ),

    // Warehouses

    11 => array(

        0 => 4.07,

        1 => 4.07,

        2 => 2.03,

        3 => 12,

        4 => 1.45,

    ),





    // Planetary Defense

    12 => array(

        0 => 4000,

        1 => 4000,

        2 => 3000,

        3 => 40,

        4 => 0,

    ),



);







/**

 * 0 => Metal

 * 1 => Minerals

 * 2 => Dilithium

 * 3 => Research time

 * 4 => Research time increase per Lv

 */



$TECH_DATA = array(

    // Ship weapons

    0 => array(

        0 => 39,

        1 => 42,

        2 => 44,

        3 => 120,

        4 => 2.2,

    ),



    // Warp Field

    1 => array(

        0 => 29,

        1 => 32,

        2 => 29,

        3 => 80,

        4 => 1.7,

    ),



    // Shield research

    2 => array(

        0 => 32,

        1 => 39,

        2 => 42,

        3 => 95,

        4 => 1.9,

    ),



    // Infaterie tactic

    3 => array(

        0 => 29,

        1 => 39,

        2 => 42,

        3 => 70,

        4 => 2.0,

    ),



    // Sensors

    4 => array(

        0 => 44,

        1 => 44,

        2 => 54,

        3 => 90,

        4 => 2.1,

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

        0 => 49,

        1 => 49,

        2 => 39,

        3 => 30,

        4 => 1.75,

    ),



    // Planetary Defense

    7 => array(

        0 => 49,

        1 => 49,

        2 => 39,

        3 => 31,

        4 => 1.75,

    ),



    // Automation

    8 => array(

        0 => 49,

        1 => 49,

        2 => 59,

        3 => 18,

        4 => 2.15,

    ),



    // Raw materials processing

    9 => array(

        0 => 49,

        1 => 49,

        2 => 59,

        3 => 20,

        4 => 1.75,

    ),

);





$SYSTEM_WIDTH = 258; // Light minutes, standard value = 508

$INTER_SYSTEM_TIME = 3; // Tick for intersystem movements, standard value = 6



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
 
 * 14 => Number of production lines in shipyard 

 */



$PLANETS_DATA = array(

    'a' => array(

         0 => 1.5,

         1 => 1.5,

         2 => 1.5,

         3 => 0.3,

         4 => 1.0,

         5 => 0.9,

         6 => 15000,

         7 => 2500,

         8 => 5,

         9 => array(241, 15, 58),

         10 => 1.0,

         11 => 2.2,

         12 => 1.1,

         13 => 1.0,
        
         14 => 2

    ),



    'b' => array(

         0 => 1.6,

         1 => 1.6,

         2 => 1.6,

         3 => 0.4,

         4 => 1.1,

         5 => 0.95,

         6 => 15000,

         7 => 3000,

         8 => 5,

         9 => array(193, 10, 10),

         10 => 1.0,

         11 => 2.1,

         12 => 1.15,

         13 => 1.0,
         
         14 => 2

    ),



    'c' => array(

        0 => 1.5,

        1 => 1.5,

        2 => 1.5,

        3 => 0.4,

        4 => 1.0,

        5 => 0.75,

        6 => 15000,

        7 => 4500,

        8 => 5,

        9 => array(129, 110, 64),

        10 => 1.0,

        11 => 2.0,

        12 => 0.9,

        13 => 0.95,
        
        14 => 2

    ),



    'd' => array(

        0 => 1.65,

        1 => 1.65,

        2 => 1.65,

        3 => 0.3,

        4 => 1.05,

        5 => 0.8,

        6 => 15000,

        7 => 2500,

        8 => 4,

        9 => array(146, 146, 142),

        10 => 1.2,

        11 => 2.0,

        12 => 0.95,

        13 => 0.9,
        
        14 => 2

    ),



    'e' => array(

        0 => 1.45,

        1 => 1.45,

        2 => 1.0,

        3 => 1.0,

        4 => 1.2,

        5 => 1.3,

        6 => 160000,

        7 => 15000,

        8 => 7,

        9 => array(252, 176, 77),

        10 => 1.3,

        11 => 1.2,

        12 => 1.25,

        13 => 1.5,
        
        14 => 4

    ),



    'f' => array(

        0 => 1.45,

        1 => 1.0,

        2 => 1.45,

        3 => 1.0,

        4 => 1.2,

        5 => 1.3,

        6 => 160000,

        7 => 15000,

        8 => 7,

        9 => array(75, 166, 75),

         10 => 1.3,

         11 => 1.2,

         12 => 1.25,

         13 => 1.5,
        
        14 => 4

    ),



    'g' => array(

        0 => 1,

        1 => 1.45,

        2 => 1.45,

        3 => 1.0,

        4 => 1.2,

        5 => 1.3,

        6 => 160000,

        7 => 15000,

        8 => 7,

        9 => array(35, 148, 7),

        10 => 1.3,

        11 => 1.2,

        12 => 1.25,

        13 => 1.5,
        
        14 => 4

    ),



    'h' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 0.85,

        4 => 1.2,

        5 => 1.15,

        6 => 60000,

        7 => 6000,

        8 => 7,

        9 => array(230, 230, 120),

        10 => 1.3,

        11 => 1.3,

        12 => 1.3,

        13 => 1.4,
        
        14 => 3

    ),



    'i' => array(

        0 => 0.5,

        1 => 0.5,

        2 => 3.0,

        3 => 0.1,

        4 => 2.0,

        5 => 2.0,

        6 => 100000,

        7 => 1500,

        8 => 10,

        9 => array(68, 107, 183),

        10 => 3.0,

        11 => 5.0,

        12 => 2.5,

        13 => 2.5,
        
        14 => 1

    ),



    'j' => array(

        0 => 2.8,

        1 => 1.5,

        2 => 0.5,

        3 => 0.1,

        4 => 2.0,

        5 => 2.0,

        6 => 100000,

        7 => 1500,

        8 => 9,

        9 => array(187, 101, 50),

        10 => 2.0,

        11 => 5.0,

        12 => 2.0,

        13 => 2.5,
        
        14 => 1

    ),



    'k' => array(

        0 => 1.4,

        1 => 1.4,

        2 => 1.4,

        3 => 0.95,

        4 => 1.15,

        5 => 1.15,

        6 => 40000,

        7 => 6000,

        8 => 6,

        9 => array(180, 75, 50),

        10 => 1.2,

        11 => 1.2,

        12 => 1.2,

        13 => 1.1,
        
        14 => 4

    ),



    'l' => array(

        0 => 1.2,

        1 => 1.2,

        2 => 1.2,

        3 => 1.1,

        4 => 1.05,

        5 => 1.1,

        6 => 270000,

        7 => 30000,

        8 => 7,

        9 => array(10, 140, 30),

        10 => 1.2,

        11 => 1.2,

        12 => 1.0,

        13 => 1.0,
        
        14 => 4

    ),



    'm' => array(

        0 => 1.1,

        1 => 1.1,

        2 => 1.1,

        3 => 1.4,

        4 => 0.9,

        5 => 1.0,

        6 => 300000,

        7 => 30000,

        8 => 7,

        9 => array(50, 50, 180),

        10 => 0.8,

        11 => 0.9,

        12 => 1.0,

        13 => 1.0,
        
        14 => 4

    ),



    'n' => array(

        0 => 1.2,

        1 => 1.2,

        2 => 1.2,

        3 => 0.75,

        4 => 1.4,

        5 => 1.25,

        6 => 80000,

        7 => 6000,

        8 => 7,

        9 => array(200, 157, 106),

        10 => 1.4,

        11 => 1.4,

        12 => 1.4,

        13 => 1.6,
        
        14 => 3

    ),


    'o' => array(

        0 => 1.0,

        1 => 1.0,

        2 => 1.0,

        3 => 1.55,

        4 => 1.0,

        5 => 1.1,

        6 => 270000,

        7 => 30000,

        8 => 7,

        9 => array(0, 0, 180),

        10 => 0.8,

        11 => 0.95,

        12 => 1.05,

        13 => 1.05,
        
        14 => 4

    ),


    'p' => array(

        0 => 1.4,

        1 => 1.4,

        2 => 1.4,

        3 => 1.1,

        4 => 1.0,

        5 => 1.1,

        6 => 270000,

        7 => 30000,

        8 => 7,

        9 => array(180, 250, 250),

        10 => 1,

        11 => 1,

        12 => 1.1,

        13 => 1,
        
        14 => 4

    ),

   'q' => array(

        0 => 1.1,

        1 => 1.2,

        2 => 1.4,

        3 => 0.6,

        4 => 1.15,

        5 => 1.4,

        6 => 290000,

        7 => 25000,

        8 => 7,

        9 => array(0, 102, 0),

        10 => 1.1,

        11 => 1,

        12 => 1.1,

        13 => 1,
        
        14 => 4

    ),

    's' => array(

        0 => 0.5,

        1 => 2.8,

        2 => 0.5,

        3 => 0.1,

        4 => 2.0,

        5 => 2.0,

        6 => 100000,

        7 => 1500,

        8 => 11,

        9 => array(187, 100, 50),

        10 => 3.0,

        11 => 5.0,

        12 => 2.5,

        13 => 3.5,
        
        14 => 1

    ),


    't' => array(

        0 => 0.5,

        1 => 3.4,

        2 => 0.5,

        3 => 0.1,

        4 => 2.0,

        5 => 2.0,

        6 => 100000,

        7 => 1500,

        8 => 13,

        9 => array(240, 100, 240),

        10 => 3.0,

        11 => 5.0,

        12 => 2.5,

        13 => 3.5,
        
        14 => 1

    ),


    'x' => array(

        0 => 2.0,

        1 => 2.0,

        2 => 2.0,

        3 => 0.1,

        4 => 3.0,

        5 => 2.5,

        6 => 80000,

        7 => 2000,

        8 => 5,

        9 => array(180, 60, 10),

        10 => 3.0,

        11 => 4.0,

        12 => 3.0,

        13 => 3.5,
        
        14 => 1

    ),


    'y' => array(

        0 => 2.5,

        1 => 2.5,

        2 => 2.5,

        3 => 0.1,

        4 => 3.0,

        5 => 2.5,

        6 => 120000,

        7 => 2500,

        8 => 6,

        9 => array(125, 0 , 0),

        10 => 3.0,

        11 => 4.0,

        12 => 3.0,

        13 => 3.5,
        
        14 => 1

    )

);

// codice ->  testo descrittivo, flag nascosto vero/falso, razza
$SETL_EVENTS = array(

    100  => array('Territorio di Caccia', true, 9),

    101  => array('Territorio di Caccia', false, 9),
    
    102  => array('Razziatori in attesa', true, 11),
    
    103  => array('Razziatori in attesa', false, 11),
    
    104  => array('Cartello Ferengi', true, 5),
    
    105  => array('Cartello Ferengi', false, 5),
    
    107  => array('Cartello Oroniano', false, 7),
    
    120  => array('Presidio: Multiculturalismo', 0),
    
    121  => array('Presidio: Supremazia Tecnologica', false, 1),
    
    122  => array('Presidio: Sfida del Coraggio', false, 2),
    
    123  => array('Presidio: Xenofobia', false, 3),
    
    124  => array('Presidio: Difesa del mercato', false, 5),
    
    130  => array('Delegazione: Pluralismo', false, 0),
    
    131  => array('Delegazione: Onore del Pretore', false, 1),
    
    132  => array('Delegazione: Promuovere Autodifesa', false, 2),
    
    133  => array('Delegazione: Propaganda Sovversiva', false, 3),
    
    134  => array('Delegazione: Denunciare Incompetenza', false, 4),
    
    135  => array('Delegazione: Corrompere i locali', false, 5),
    
    150  => array('Addestramento Avanzato', false, -1)

);

?>
