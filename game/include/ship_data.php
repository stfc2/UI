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

$SHIP_TORSO = array(

		// Föderation

    0 => array(

    	// Scout

	    0 => array(

			0 => 2150,  // Metal

			1 => 1338,  // Minerals

			2 => 2960,  // Latinum

			3 => 15,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 15,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 20,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 10,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 10,   // Value8 (Wendigkeit)

			22 => 16,   // Value9 (Erfahrung)

			23 => 6.9,   // Value10 (Warp)

			24 => 12,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 15,  // Benötige Arbeiter zum Bau

			31 => 'Bei der Danube Klasse handelt es sich um Kurzstrecken Aufklärer. Da hier alle Energie für die Sensoren benötigt wird, sind diese Schiffe unbewaffnet.',

	    ),

    	// Transporter

	    1 => array(

			0 => 4250,  // Metal

			1 => 5800,  // Minerals

			2 => 4640,  // Latinum

			3 => 56,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 56,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 2,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 40,  // Buildtime (in 5 Minuten Schritten)

			14 => 15,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 20,   // Value5 (Hülle bzw. Hitpoins)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 3.4,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 10,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 105,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder 4000 Rohstoffe bzw. 400 Einheiten transportieren, oder sie mit auf einen Angriff schicken. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',



	    ),

    	// Koloschiff

	    2 => array(

			0 => 59900,  // Metal

			1 => 19450,  // Minerals

			2 => 32360,  // Latinum

			3 => 104,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 3,  // Max Unit 4 (Commander)

			11 => 16,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 170,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 50,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 5.4,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 15,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisationsschiff',  // Name

			30 => 1955,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren (da seine Holoemitter zur Simulation erster Einrichtungen demontiert werden) und der Planet steht unter deinem Kommando.',

	    ),

        // Sabre

	    3 => array(

			0 => 13320,  // Metal

			1 => 19410,  // Minerals

			2 => 6528,  // Latinum

			3 => 25,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (L. Infanterie)

			8 => 10,  // Max Unit 2 (Sturmtruppe)

			9 => 4,  // Max Unit 3 (Hazard Team)

			10 => 2,  // Max Unit 4 (Commander)

			11 => 5,  // Unit 5 (Offizier)

			12 => 3,  // Unit 6 (Medizinisches Personal)

			13 => 119,  // Buildtime (in 5 Minuten Schritten)

			14 => 70,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 200,   // Value5 (Hülle bzw. Hitpoins)

			19 => 7,   // Value6 (Reaktionsgeschw.)

			20 => 11,   // Value7 (Bereitschaft)

			21 => 34,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 7,   // Value10 (Warp)

			24 => 10,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 17,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Saber',  // Name

			30 => 168,  // Benötige Arbeiter zum Bau

			31 => 'Die Sabre ist eine der neusten Entwicklungen der Förderation im Bereich der Fregatten. Die modulare Bauweise gestattet eine höhere Aufrüstfähigkeit als der Miranda. Ihre Vielseitigkeit sollte sie in keiner Flotte fehlen.',

	    ),

    	// Steamrunner

	    4 => array(

			0 => 23842,  // Metal

			1 => 14064,  // Minerals

			2 => 7680,  // Latinum

			3 => 20,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 14,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 119,  // Buildtime (in 5 Minuten Schritten)

			14 => 64,   // Value1 (Leichte Waffen)

			15 => 115,   // Value2 (Schwere Waffen)

			16 => 18,   // Value3 (Planetare Waffen)

			17 => 360,   // Value4 (Schildstärke)

			18 => 15,   // Value5 (Hülle bzw. Hitpoins)

			19 => 10,   // Value6 (Reaktionsgeschw.)

			20 => 8,   // Value7 (Bereitschaft)

			21 => 28,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 4.6,   // Value10 (Warp)

			24 => 10,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 18,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Steamrunner',  // Name

			30 => 175,  // Benötige Arbeiter zum Bau

			31 => 'Die Steamrunner Klasse wurde ursprünglich als schnell baubares Aushilfsschiff dienen doch ihre hohe Manövrierbarkeit und moderate Bewaffnung ließen sie schnell die ältere Elite verdrängen.',

	    ),

       	// Intrepid

	    5 => array(

			0 => 34800,  // Metal

			1 => 29800,  // Minerals

			2 => 25450,  // Latinum

			3 => 40,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 90,  // Max Unit 1 (L. Infanterie)

			8 => 25,  // Max Unit 2 (Sturmtruppe)

			9 => 10,  // Max Unit 3 (Hazard Team)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 11,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 195,  // Buildtime (in 5 Minuten Schritten)

			14 => 180,   // Value1 (Leichte Waffen)

			15 => 75,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 460,   // Value4 (Schildstärke)

			18 => 380,   // Value5 (Hülle bzw. Hitpoins)

			19 => 16,   // Value6 (Reaktionsgeschw.)

			20 => 24,   // Value7 (Bereitschaft)

			21 => 32,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 8.15,   // Value10 (Warp)

			24 => 18,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 61,   // Value13 (Energy Available)

			27 => 11,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Intrepid',  // Name

			30 => 380,  // Benötige Arbeiter zum Bau

			31 => 'Light Cruiser letzten Generation, mit einzigartigen Technologien von denen auf Schiffen des Bundes. Geboren zu reisen bei sehr hohen Reisegeschwindigkeit, hat ein Rüstung je gesehen Sondierungsgespräche über ein Schiff von dieser Tonnage.',

		    ),



    	// Defiant

	    6 => array(

			0 => 30800,  // Metal

			1 => 26915,  // Minerals

			2 => 10650,  // Latinum

			3 => 25,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 20,  // Max Unit 2 (Sturmtruppe)

			9 => 5,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 6,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 146,  // Buildtime (in 5 Minuten Schritten)

			14 => 145,   // Value1 (Leichte Waffen)

			15 => 95,   // Value2 (Schwere Waffen)

			16 => 15,   // Value3 (Planetare Waffen)

			17 => 480,   // Value4 (Schildstärke)

			18 => 120,   // Value5 (Hülle bzw. Hitpoins)

			19 => 15,   // Value6 (Reaktionsgeschw.)

			20 => 26,   // Value7 (Bereitschaft)

			21 => 38,   // Value8 (Wendigkeit)

			22 => 18,   // Value9 (Erfahrung)

			23 => 6.5,   // Value10 (Warp)

			24 => 11,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 17,   // Value13 (Energy Available)

			27 => 15,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Defiant',  // Name

			30 => 245,  // Benötige Arbeiter zum Bau

			31 => 'Der kompakteste leichte Kreuzer der Sternenflotte. Ausgestattet mit Quantentorpedos besitzt sie eine für ihre Verhältnisse enorme Feuerkraft. Jedoch schränken Schildkapazität und Crewgröße den Einsatzradius ein. Als leichtes Angriffsschiff mit vorinstallierter Tarnvorrichtung ist sie die beste Wahl.',

	    ),

    	// Excelsior

	    7 => array(

			0 => 51390,  // Metal

			1 => 37445,  // Minerals

			2 => 20956,  // Latinum

			3 => 80,  // Min. Unit 1(L. Infanterie)

			4 => 20,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 75,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 13,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 265,  // Buildtime (in 5 Minuten Schritten)

			14 => 190,   // Value1 (Leichte Waffen)

			15 => 110,   // Value2 (Schwere Waffen)

			16 => 10,   // Value3 (Planetare Waffen)

			17 => 520,   // Value4 (Schildstärke)

			18 => 300,   // Value5 (Hülle bzw. Hitpoins)

			19 => 9,   // Value6 (Reaktionsgeschw.)

			20 => 5,   // Value7 (Bereitschaft)

			21 => 24,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 3.6,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 30,   // Value13 (Energy Available)

			27 => 25,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Excelsior',  // Name

			30 => 550,  // Benötige Arbeiter zum Bau

			31 => 'Die Exelsior gehört zur Klasse der Kreuzer und bietet ein sehr wirtschaftliches Verhältnis. Aufgrund zahlreicher Weiterentwicklungen durch die Sternenflotte gibt es sie in mehreren Ausführungen. Die aktuellste Version besitzt sogar mehrphasige, regenerierende Schilde.',

	    ),

    	// Nebula

	    8 => array(

			0 => 55740,  // Metal

			1 => 50370,  // Minerals

			2 => 21296,  // Latinum

			3 => 120,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 10,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 125,  // Max Unit 2 (Sturmtruppe)

			9 => 100,  // Max Unit 3 (Hazard Team)

			10 => 10,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 272,  // Buildtime (in 5 Minuten Schritten)

			14 => 145,   // Value1 (Leichte Waffen)

			15 => 140,   // Value2 (Schwere Waffen)

			16 => 25,   // Value3 (Planetare Waffen)

			17 => 700,   // Value4 (Schildstärke)

			18 => 300,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 5,   // Value7 (Bereitschaft)

			21 => 17,   // Value8 (Wendigkeit)

			22 => 13,   // Value9 (Erfahrung)

			23 => 4,   // Value10 (Warp)

			24 => 13,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 38,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Nebula',  // Name

			30 => 790,  // Benötige Arbeiter zum Bau

			31 => 'Die Nebula ist zwar ein Ableger der Galaxie-Klasse, sollte jedoch als eigener Schiffstyp mit eigenen Fähigkeiten gesehen werden. Ihre Größe macht sie zwar behäbiger als leichte Kreuzer, in Punkto Feuerkraft und Schildstärke steht sie jedoch über ihnen.',

	    ),

    	// Galaxy

	    9 => array(

			0 => 67340,  // Metal

			1 => 53920,  // Minerals

			2 => 35236,  // Latinum

			3 => 200,  // Min. Unit 1(L. Infanterie)

			4 => 5,  // Min. Unit 2 (Sturmtruppe)

			5 => 10,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 500,  // Max Unit 1 (L. Infanterie)

			8 => 200,  // Max Unit 2 (Sturmtruppe)

			9 => 150,  // Max Unit 3 (Hazard Team)

			10 => 12,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 354,  // Buildtime (in 5 Minuten Schritten)

			14 => 280,   // Value1 (Leichte Waffen)

			15 => 40,   // Value2 (Schwere Waffen)

			16 => 45,   // Value3 (Planetare Waffen)

			17 => 600,   // Value4 (Schildstärke)

			18 => 1100,   // Value5 (Hülle bzw. Hitpoins)

			19 => 10,   // Value6 (Reaktionsgeschw.)

			20 => 4,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 20,   // Value9 (Erfahrung)

			23 => 3.4,   // Value10 (Warp)

			24 => 11,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 54,   // Value13 (Energy Available)

			27 => 50,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Galaxy',  // Name

			30 => 965,  // Benötige Arbeiter zum Bau

			31 => 'Die Galaxy zeichnet sich durch beeindruckende Kampfkraft aus. Obwohl als Forschungsschiff klassifiziert konnte diese Schiffsklasse ihr Kampfgeschick in jeder größeren Schlacht der Föderation unter Beweis stellen. Was ihr an offensiver Bewaffnung fehlt macht sie locker duch ihre schweren Schilde und Panzerung wett. Einer Galaxy sollte man nur in Gruppen auf den Leib rücken.',

	    ),

		// Akira

	    10 => array(

			0 => 56180,  // Metal

			1 => 43590,  // Minerals

			2 => 39272,  // Latinum

			3 => 55,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 55,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 12,  // Max Unit 4 (Commander)

			11 => 5,  // Unit 5 (Offizier)

			12 => 3,  // Unit 6 (Medizinisches Personal)

			13 => 326,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 280,   // Value2 (Schwere Waffen)

			16 => 60,   // Value3 (Planetare Waffen)

			17 => 200,   // Value4 (Schildstärke)

			18 => 900,   // Value5 (Hülle bzw. Hitpoins)

			19 => 18,   // Value6 (Reaktionsgeschw.)

			20 => 6,   // Value7 (Bereitschaft)

			21 => 21,   // Value8 (Wendigkeit)

			22 => 18,   // Value9 (Erfahrung)

			23 => 3,   // Value10 (Warp)

			24 => 3,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 70,   // Value13 (Energy Available)

			27 => 62,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Akira',  // Name

			30 => 181,  // Benötige Arbeiter zum Bau

			31 => 'Das erste für die Schlacht entwickelte Schiff der Föderation, Ausgestattet mit mehreren Torpedowerfern kann es ein wahres Inferno auf Feindflotten beschwören. Regenerative Schilde sorgen für ausreichenden Schutz. Diese Schiffsklasse wurde mit dem Augenmerk auf höchste Überlebensfähigkeit, Schnelligkeit und Angriffskraft entwickelt.',

	    ),

    	// Sovereign

	    11 => array(

			0 => 129800,  // Metal

			1 => 78150,  // Minerals

			2 => 64920,  // Latinum

			3 => 250,  // Min. Unit 1(L. Infanterie)

			4 => 100,  // Min. Unit 2 (Sturmtruppe)

			5 => 50,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 500,  // Max Unit 1 (L. Infanterie)

			8 => 200,  // Max Unit 2 (Sturmtruppe)

			9 => 100,  // Max Unit 3 (Hazard Team)

			10 => 12,  // Max Unit 4 (Commander)

			11 => 18,  // Unit 5 (Offizier)

			12 => 7,  // Unit 6 (Medizinisches Personal)

			13 => 499,  // Buildtime (in 5 Minuten Schritten)

			14 => 400,   // Value1 (Leichte Waffen)

			15 => 80,   // Value2 (Schwere Waffen)

			16 => 50,   // Value3 (Planetare Waffen)

			17 => 980,   // Value4 (Schildstärke)

			18 => 1050,   // Value5 (Hülle bzw. Hitpoins)

			19 => 11,   // Value6 (Reaktionsgeschw.)

			20 => 3,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 20,   // Value9 (Erfahrung)

			23 => 3.7,   // Value10 (Warp)

			24 => 9,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 77,   // Value13 (Energy Available)

			27 => 71,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Sovereign',  // Name

			30 => 1951,  // Benötige Arbeiter zum Bau

			31 => 'Die Sovereign Klasse ist die modernste Schiffklasse der Föderation. Sie ist zwar offiziell ein Allround Schiff entfaltet aber ihr wahres Potential im Kampf. Starke Waffen und Schilde sowie eine gute Manövrierfähigkeit machen sie zu einem Gegner dem ein Schiff nicht alleine gegenübertreten sollte. Es kann eine verloren schienende Schlacht ohne Probleme wenden.',

	    ),

    	// Orbitalgeschütz

	    12 => array(

			0 => 50400,  // Metal

			1 => 50400,  // Minerals

			2 => 40320,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 240,  // Buildtime (in 5 Minuten Schritten)

			14 => 250,   // Value1 (Leichte Waffen)

			15 => 250,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 700,   // Value4 (Schildstärke)

			18 => 100,   // Value5 (Hülle bzw. Hitpoins)

			19 => 35,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 35,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 425,  // Benötige Arbeiter zum Bau

			31 => 'Aufgrund der Angreifbarkeit vieler Welten der Föderation sahen sich die Techniker zur Konstruktion dieser automatisierten Waffenplattform genötigt. Ausgestattet mit Phaserbänken und schnell feuernden Photonentorpedorampen bildet es eine wichtige Komponente in der Verteidigungsstrategie der Föderierten.',

	    ),

    ),

    

    



    

		// Romulaner

    1 => array(

    	// Scout

	    0 => array(

		    0 => 950,  // Metal

			1 => 772.5,  // Minerals

			2 => 983.33,  // Latinum

			3 => 12,  // Min. Unit 1(Centurion)

			4 => 0,  // Min. Unit 2 (Rem. Truppen)

			5 => 0,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 15,  // Max Unit 1 (Centurion)

			8 => 0,  // Max Unit 2 (Rem. Truppen)

			9 => 0,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 15,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 10,   // Value5 (Hülle bzw. Hitpoints)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 10,   // Value8 (Wendigkeit)

			22 => 15,   // Value9 (Erfahrung)

			23 => 4.4,   // Value10 (Warp)

			24 => 7,   // Value11 (Sensoren)

			25 => 3,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 5,  // Benötige Arbeiter zum Bau

			31 => 'Das Scoutschiff ist zum Spionieren gedacht und nicht als Angriffsschiff geeignet.',

			),

    	// Transporter

	    1 => array(

			0 => 4520,  // Metal

			1 => 7020,  // Minerals

			2 => 2573.33,  // Latinum

			3 => 48,  // Min. Unit 1(Centurion)

			4 => 0,  // Min. Unit 2 (Rem. Truppen)

			5 => 0,  // Min. Unit 3 (Tal Shiar)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (Centurion)

			8 => 0,  // Max Unit 2 (Rem. Truppen)

			9 => 0,  // Max Unit 3 (Tal Shiar)

			10 => 3,  // Max Unit 4 (Commander)

			11 => 3,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 45,  // Buildtime (in 5 Minuten Schritten)

			14 => 15,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 20,   // Value5 (Hülle bzw. Hitpoints)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 4.9,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 10,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 85,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder Rohstoffe bzw. Einheiten transportieren, oder sie mit auf einen Angriff schicken. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',

			),

    	// Kolonisationsschiff

	    2 => array(

			0 => 80680,  // Metal

			1 => 26060,  // Minerals

			2 => 23773.33,  // Latinum

			3 => 110,  // Min. Unit 1(Centurion)

			4 => 0,  // Min. Unit 2 (Rem. Truppen)

			5 => 0,  // Min. Unit 3 (Tal Shiar)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (Centurion)

			8 => 0,  // Max Unit 2 (Rem. Truppen)

			9 => 0,  // Max Unit 3 (Tal Shiar)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 14,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 205,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 50,   // Value5 (Hülle bzw. Hitpoints)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 4.5,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 15,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonieschiff',  // Name

			30 => 1855,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren (da seine Schiffshülle zur Errichtung erster Einrichtungen demontiert wird) und der Planet steht unter deinem Kommando.',

			),

    	// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Talon Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Talon

	    4 => array(

			0 => 21448,  // Metal

			1 => 17524,  // Minerals

			2 => 4983,  // Latinum

			3 => 25,  // Min. Unit 1(Centurion)

			4 => 0,  // Min. Unit 2 (Rem. Truppen)

			5 => 0,  // Min. Unit 3 (Tal Shiar)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (Centurion)

			8 => 10,  // Max Unit 2 (Rem. Truppen)

			9 => 0,  // Max Unit 3 (Tal Shiar)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 9,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 126,  // Buildtime (in 5 Minuten Schritten)

			14 => 28,   // Value1 (Leichte Waffen)

			15 => 30,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 180,   // Value4 (Schildstärke)

			18 => 160,   // Value5 (Hülle bzw. Hitpoints)

			19 => 5,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 30,   // Value8 (Wendigkeit)

			22 => 7,   // Value9 (Erfahrung)

			23 => 5.4,   // Value10 (Warp)

			24 => 3,   // Value11 (Sensoren)

			25 => 10,   // Value12 (Tarnung)

			26 => 20,   // Value13 (Energy Available)

			27 => 8,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Talon Class',  // Name

			30 => 94,  // Benötige Arbeiter zum Bau

			31 => 'Die Talon Class ist eines der 2 Mittelklasse-Schiffe. Sie hat keinerlei besondere Fertigkeiten und ihre Kampfstärke ist dem Preis angemessen.',

			),

    	// Sience

	    5 => array(

			0 => 32794,  // Metal

			1 => 23397,  // Minerals

			2 => 6598,  // Latinum

			3 => 60,  // Min. Unit 1(Centurion)

			4 => 10,  // Min. Unit 2 (Rem. Truppen)

			5 => 0,  // Min. Unit 3 (Tal Shiar)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 75,  // Max Unit 1 (Centurion)

			8 => 25,  // Max Unit 2 (Rem. Truppen)

			9 => 0,  // Max Unit 3 (Tal Shiar)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 10,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 163,  // Buildtime (in 5 Minuten Schritten)

			14 => 109,   // Value1 (Leichte Waffen)

			15 => 90,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 140,   // Value4 (Schildstärke)

			18 => 360,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 26,   // Value8 (Wendigkeit)

			22 => 7,   // Value9 (Erfahrung)

			23 => 5.8,   // Value10 (Warp)

			24 => 16,   // Value11 (Sensoren)

			25 => 8,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Sience Class',  // Name

			30 => 231,  // Benötige Arbeiter zum Bau

			31 => 'Die Sience Class ist eines der 2 Mittelklasse-Schiffe. Sie hat keinerlei besondere Fertigkeiten und ihre Kampfstärke ist dem Preis angemessen.',

			),

    	// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Sience Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),			

    	// Norexan

	    7 => array(

			0 => 51338,  // Metal

			1 => 33419,  // Minerals

			2 => 17696,  // Latinum

			3 => 120,  // Min. Unit 1(Centurion)

			4 => 20,  // Min. Unit 2 (Rem. Truppen)

			5 => 5,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 130,  // Max Unit 1 (Centurion)

			8 => 25,  // Max Unit 2 (Rem. Truppen)

			9 => 5,  // Max Unit 3 (Tal Shiar)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 11,  // Unit 5 (Offizier)

			12 => 7,  // Unit 6 (Medizinisches Personal)

			13 => 267,  // Buildtime (in 5 Minuten Schritten)

			14 => 185,   // Value1 (Leichte Waffen)

			15 => 155,   // Value2 (Schwere Waffen)

			16 => 10,   // Value3 (Planetare Waffen)

			17 => 590,   // Value4 (Schildstärke)

			18 => 480,   // Value5 (Hülle bzw. Hitpoints)

			19 => 6,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 11,   // Value9 (Erfahrung)

			23 => 5.2,   // Value10 (Warp)

			24 => 17,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 15,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Norexan Class',  // Name

			30 => 436,  // Benötige Arbeiter zum Bau

			31 => 'Die Norexan Class gehört zur Oberklasse, sie besitzt als erstes Schiff Quantentorpedos und kann dadurch immense Schäden anrichten.',

			),

    	// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Norexan Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Warbird

	    9 => array(

			0 => 81953,  // Metal

			1 => 43477,  // Minerals

			2 => 26151,  // Latinum

			3 => 200,  // Min. Unit 1(Centurion)

			4 => 50,  // Min. Unit 2 (Rem. Truppen)

			5 => 30,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 210,  // Max Unit 1 (Centurion)

			8 => 50,  // Max Unit 2 (Rem. Truppen)

			9 => 35,  // Max Unit 3 (Tal Shiar)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 3,  // Unit 6 (Medizinisches Personal)

			13 => 352,  // Buildtime (in 5 Minuten Schritten)

			14 => 245,   // Value1 (Leichte Waffen)

			15 => 250,   // Value2 (Schwere Waffen)

			16 => 5,   // Value3 (Planetare Waffen)

			17 => 250,   // Value4 (Schildstärke)

			18 => 600,   // Value5 (Hülle bzw. Hitpoints)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 10,   // Value8 (Wendigkeit)

			22 => 9,   // Value9 (Erfahrung)

			23 => 4.0,   // Value10 (Warp)

			24 => 23,   // Value11 (Sensoren)

			25 => 8,   // Value12 (Tarnung)

			26 => 35,   // Value13 (Energy Available)

			27 => 18,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'D´deridex Class',  // Name

			30 => 947,  // Benötige Arbeiter zum Bau

			31 => 'Die D´deridex Class gehört zu den behäbigen aber erfahrenen Schiffen. Mit den richtigen Upgrades versehen kann sie einige Kratzer auf den Schiffen deiner Gegner hinterlassen.',

			),

    	// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'D´deridex Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Scimitar

	    11 => array(

			0 => 178210,  // Metal

			1 => 64105,  // Minerals

			2 => 74737,  // Latinum

			3 => 300,  // Min. Unit 1(Centurion)

			4 => 100,  // Min. Unit 2 (Rem. Truppen)

			5 => 100,  // Min. Unit 3 (Tal Shiar)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 300,  // Max Unit 1 (Centurion)

			8 => 100,  // Max Unit 2 (Rem. Truppen)

			9 => 100,  // Max Unit 3 (Tal Shiar)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 21,  // Unit 5 (Offizier)

			12 => 8,  // Unit 6 (Medizinisches Personal)

			13 => 576,  // Buildtime (in 5 Minuten Schritten)

			14 => 115,   // Value1 (Leichte Waffen)

			15 => 150,   // Value2 (Schwere Waffen)

			16 => 50,   // Value3 (Planetare Waffen)

			17 => 100,   // Value4 (Schildstärke)

			18 => 800,   // Value5 (Hülle bzw. Hitpoints)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 4,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 6,   // Value9 (Erfahrung)

			23 => 3.7,   // Value10 (Warp)

			24 => 25,   // Value11 (Sensoren)

			25 => 2,   // Value12 (Tarnung)

			26 => 154,   // Value13 (Energy Available)

			27 => 125,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scimitar Class',  // Name

			30 => 1873,  // Benötige Arbeiter zum Bau

			31 => 'Die Scimitar Class gehört zur Eliteklasse, sie besitzt die größte Manövrierbarkeit der Romulanischen Flotte.',

			),

    	// Orbitalgeschütz

	    12 => array(

			0 => 51408,  // Metal

			1 => 51408,  // Minerals

			2 => 22896,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 216,  // Buildtime (in 5 Minuten Schritten)

			14 => 25,   // Value1 (Leichte Waffen)

			15 => 375,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 700,   // Value4 (Schildstärke)

			18 => 200,   // Value5 (Hülle bzw. Hitpoins)

			19 => 32,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 27,   // Value11 (Sensoren)

			25 => 22,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 325,  // Benötige Arbeiter zum Bau

			31 => 'Seid dem Sturz Shinzons erheben sich vermehrt verschiedene Fraktionen gegen das romulanische Sternenimperium und bedrohen offen die romulanischen Welten. Als Schutzmaßnahme wurden diese Orbitalplattformen entwickelt, welche, ausgestattet mit Disruptoren und Plasmatorpedos, eine effektive Verteidigung gewährleisten.',

	    ),

), //Romulaner











	// Klingonen

    2 => array(



    	// Scout

	    0 => array(

			0 => 2880,  // Metal

			1 => 3696,  // Minerals

			2 => 4630,  // Latinum

			3 => 10,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 10,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 55,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 15,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 3,   // Value7 (Bereitschaft)

			21 => 12,   // Value8 (Wendigkeit)

			22 => 13,   // Value9 (Erfahrung)

			23 => 3.9,   // Value10 (Warp)

			24 => 6,   // Value11 (Sensoren)

			25 => 4,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 5,  // Benötige Arbeiter zum Bau

			31 => 'Der Scout ist zum ausspionieren von Flotten und Planeten gedacht. Auch wenn der Dienst auf ihm keine Ehre bringt erfüllt er doch seinen Zweck.',

			),



    	// Transporter

	    1 => array(

			0 => 8520,  // Metal

			1 => 8960,  // Minerals

			2 => 5870,  // Latinum

			3 => 50,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 2,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 75,  // Buildtime (in 5 Minuten Schritten)

			14 => 18,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 25,   // Value5 (Hülle bzw. Hitpoins)

			19 => 3,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 4.4,   // Value10 (Warp)

			24 => 4,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 10,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 117,  // Benötige Arbeiter zum Bau

			31 => 'Mit einem Transporter kann man entweder 4000 Rohstoffe bzw. 400 Krieger transportieren, oder sie mit in eine Schlacht schicken. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',

			),



    	// Kolonisationsschiff

	    2 => array(

			0 => 78080,  // Metal

			1 => 25880,  // Minerals

			2 => 34390,  // Latinum

			3 => 100,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 20,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 255,  // Buildtime (in 5 Minuten Schritten)

			14 => 12,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 55,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 5.4,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 15,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisationsschiff',  // Name

			30 => 1470,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du einen Planeten kolonisieren. Sobald du die Planetare Verteidigung beseitigt und feindlichen Truppen ausgeschaltet hast, geht das Kolonieschiff verloren (da seine Holoemitter zur Simulation erster Einrichtungen demontiert werden) und der Planet steht unter deinem Kommando.',

			),

// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'B´rel (Bird of Prey)',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Bird of Prey

	    4 => array(

			0 => 16365,  // Metal

			1 => 8433,  // Minerals

			2 => 1801,  // Latinum

			3 => 12,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 24,  // Max Unit 1 (L. Infanterie)

			8 => 10,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 9,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 68,  // Buildtime (in 5 Minuten Schritten)

			14 => 50,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 160,   // Value4 (Schildstärke)

			18 => 100,   // Value5 (Hülle bzw. Hitpoins)

			19 => 16,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 28,   // Value8 (Wendigkeit)

			22 => 16,   // Value9 (Erfahrung)

			23 => 4.1,   // Value10 (Warp)

			24 => 2,   // Value11 (Sensoren)

			25 => 8,   // Value12 (Tarnung)

			26 => 20,   // Value13 (Energy Available)

			27 => 8,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'B´rel (Bird of Prey)',  // Name

			30 => 103,  // Benötige Arbeiter zum Bau

			31 => 'Die B´rel-Klasse ist eines der 2 Mittelklasse-Schiffe. Als die alten Bird of Preys den Schiffen der noch jungen Föderation immer öfter unterlegen waren, wurde diese Klasse komplett neu entworfen. Heraus kam ein starker, wendiger Angriffsjäger.',

			),



    	// K´T´Inga

	    5 => array(

			0 => 26548,  // Metal

			1 => 14199,  // Minerals

			2 => 3324,  // Latinum

			3 => 100,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 175,  // Max Unit 1 (L. Infanterie)

			8 => 30,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 9,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 111,  // Buildtime (in 5 Minuten Schritten)

			14 => 160,   // Value1 (Leichte Waffen)

			15 => 20,   // Value2 (Schwere Waffen)

			16 => 10,   // Value3 (Planetare Waffen)

			17 => 120,   // Value4 (Schildstärke)

			18 => 560,   // Value5 (Hülle bzw. Hitpoins)

			19 => 16,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 22,   // Value8 (Wendigkeit)

			22 => 18,   // Value9 (Erfahrung)

			23 => 5.0,   // Value10 (Warp)

			24 => 2,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'K´T´Inga',  // Name

			30 => 204,  // Benötige Arbeiter zum Bau

			31 => 'Die K´T´Inga ist das zweite der 2 Mittelklasse-Schiffe. Sie ersetzt die alte D7 Klasse deren Hüllenmodell sie auch verwendet. Jedoch hat sie weitaus bessere Waffen und Schilde.',

			),

// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'K´T´Inga',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Kvort

	    7 => array(

			0 => 54164,  // Metal

			1 => 36782,  // Minerals

			2 => 18087,  // Latinum

			3 => 40,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 20,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 90,  // Max Unit 1 (L. Infanterie)

			8 => 25,  // Max Unit 2 (Sturmtruppe)

			9 => 20,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 21,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 289,  // Buildtime (in 5 Minuten Schritten)

			14 => 270,   // Value1 (Leichte Waffen)

			15 => 80,   // Value2 (Schwere Waffen)

			16 => 25,   // Value3 (Planetare Waffen)

			17 => 480,   // Value4 (Schildstärke)

			18 => 300,   // Value5 (Hülle bzw. Hitpoins)

			19 => 8,   // Value6 (Reaktionsgeschw.)

			20 => 11,   // Value7 (Bereitschaft)

			21 => 16,   // Value8 (Wendigkeit)

			22 => 11,   // Value9 (Erfahrung)

			23 => 5.0,   // Value10 (Warp)

			24 => 2,   // Value11 (Sensoren)

			25 => 15,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 15,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'K´vort',  // Name

			30 => 438,  // Benötige Arbeiter zum Bau

			31 => 'Die Kvort wurde entwickelt als man feststellte dass die B´rel zwar sehr schnell und wendig war jedoch nur im Schwarm größere Schäden verursacht. Die K´vort Klasse wurde daher mit stärkeren Waffen und Schilden ausgestattet.',

			),

// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'K´vort',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Vorcha

	    9 => array(

			0 => 70460,  // Metal

			1 => 47230,  // Minerals

			2 => 26423,  // Latinum

			3 => 200,  // Min. Unit 1(L. Infanterie)

			4 => 20,  // Min. Unit 2 (Sturmtruppe)

			5 => 25,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 12,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 348,  // Buildtime (in 5 Minuten Schritten)

			14 => 250,   // Value1 (Leichte Waffen)

			15 => 90,   // Value2 (Schwere Waffen)

			16 => 45,   // Value3 (Planetare Waffen)

			17 => 160,   // Value4 (Schildstärke)

			18 => 500,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 11,   // Value7 (Bereitschaft)

			21 => 15,   // Value8 (Wendigkeit)

			22 => 9,   // Value9 (Erfahrung)

			23 => 3.8,   // Value10 (Warp)

			24 => 2,   // Value11 (Sensoren)

			25 => 12,   // Value12 (Tarnung)

			26 => 55,   // Value13 (Energy Available)

			27 => 38,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Vorcha',  // Name

			30 => 902,  // Benötige Arbeiter zum Bau

			31 => 'Die Vorcha wurde entwickelt als man feststellte, dass die K´T´Inga von unten leicht anzugreifen war. Bei ihr wurden Offensiv- und Defensivpotentiial noch einmal verstärkt. Durch ihre verhältnissmäßig geringe Bauzeit stellt sie nach der K´T´Inga das neue Rückrat der Flotte dar.',

			),

// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Vorcha',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Negh

	    11 => array(

			0 => 114257,  // Metal

			1 => 49629,  // Minerals

			2 => 52971,  // Latinum

			3 => 150,  // Min. Unit 1(L. Infanterie)

			4 => 150,  // Min. Unit 2 (Sturmtruppe)

			5 => 60,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 150,  // Max Unit 2 (Sturmtruppe)

			9 => 150,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 6,  // Unit 6 (Medizinisches Personal)

			13 => 450,  // Buildtime (in 5 Minuten Schritten)

			14 => 350,   // Value1 (Leichte Waffen)

			15 => 180,   // Value2 (Schwere Waffen)

			16 => 45,   // Value3 (Planetare Waffen)

			17 => 300,   // Value4 (Schildstärke)

			18 => 600,   // Value5 (Hülle bzw. Hitpoins)

			19 => 6,   // Value6 (Reaktionsgeschw.)

			20 => 12,   // Value7 (Bereitschaft)

			21 => 12,   // Value8 (Wendigkeit)

			22 => 15,   // Value9 (Erfahrung)

			23 => 4.2,   // Value10 (Warp)

			24 => 24,   // Value11 (Sensoren)

			25 => 8,   // Value12 (Tarnung)

			26 => 134,   // Value13 (Energy Available)

			27 => 125,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Negh´Var',  // Name

			30 => 1873,  // Benötige Arbeiter zum Bau

			31 => 'Die Negh´Var wurde als Pendant zur Keldon Klasse der Cardassianer entwickelt und ist eines der stärksten Schiffe der Galaxie. In diesem Schiff wurden die modernsten Waffen eingebaut über die das Reich verfügt und die stärksten Schilde und Panzerung machen es zu einer harten Nuss für jeden Gegner. Der Rumpf ist von Disrupturbänken geradezu bedeckt und ein Toter Winkel wurde völlig verhindert.',

			),

    	// Orbitalgeschütz

	    12 => array(

			0 => 49632,  // Metal

			1 => 49632,  // Minerals

			2 => 32736,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 264,  // Buildtime (in 5 Minuten Schritten)

			14 => 250,   // Value1 (Leichte Waffen)

			15 => 250,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 350,   // Value4 (Schildstärke)

			18 => 500,   // Value5 (Hülle bzw. Hitpoins)

			19 => 25,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 18,   // Value11 (Sensoren)

			25 => 15,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 325,  // Benötige Arbeiter zum Bau

			31 => 'Viele Feinde wollen von dem Reichtum und der Glorie des klingonischen Reiches zehren, und manchmal reicht der Stolz und die Kraft der Krieger nicht aus, um die Welten des Reiches zu schützen. Aus diesem Grunde schufen die begabten Wissenschaftler des Hauses Korath dieses mit drei Superdisruptoren und Photonentorpedos bewaffnete Orbitalgeschütz.',

	    ),

	),

 

 

 

	// Cardassianer

    3 => array(

    	// Scout

	    0 => array(

		    0 => 5125,  // Metal

			1 => 1760,  // Minerals

			2 => 3529,  // Latinum

			3 => 1,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 9,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 32,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 9,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 11,   // Value8 (Wendigkeit)

			22 => 22,   // Value9 (Erfahrung)

			23 => 3.8,   // Value10 (Warp)

			24 => 15,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 3,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gul Vystan',  // Name

			30 => 5,  // Benötige Arbeiter zum Bau

			31 => 'Die Gul Vystan ist zum Spionieren gedacht und nicht als Angriffsschiff geeignet. Alle zur Verfügung stehenden Kapazitäten wurden für die Sensortechnik an Board verwendet. Somit blieb für sonstige Ausrüstung kein Platz mehr.',



			),

			

    	// Transporter

	    1 => array(

			0 => 5650,  // Metal

			1 => 6225,  // Minerals

			2 => 11129,  // Latinum

			3 => 30,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 52,  // Buildtime (in 5 Minuten Schritten)

			14 => 17,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 19,   // Value5 (Hülle bzw. Hitpoins)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 6,   // Value9 (Erfahrung)

			23 => 2,   // Value10 (Warp)

			24 => 4,5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 6,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 30,  // Benötige Arbeiter zum Bau

			31 => 'Mit Transportern kann man entweder Rohstoffe bzw. Einheiten transportieren, oder sie mit auf einen Angriff schicken.',

			),



    	// Koloschiff

	    2 => array(

			0 => 85450,  // Metal

			1 => 25225,  // Minerals

			2 => 41529,  // Latinum

			3 => 100,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 4,  // Min. Unit 4 (Commander)

			7 => 250,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 5,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			14 => 11,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 48,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 2.8,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 6,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonieschiff',  // Name

			30 => 1180,  // Benötige Arbeiter zum Bau

			31 => 'Mit Kolonieschiffen können Planeten erobert werden. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren, da es zur Konstruktion erster Einrichtungen demontiert wird, und der Planet steht unter deinem Kommando.',

		),

    	// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Hideki',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Hideki

	    4 => array(

			0 => 15090,  // Metal

			1 => 22960,  // Minerals

			2 => 7815,  // Latinum

			3 => 20,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (L. Infanterie)

			8 => 10,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 7,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 157,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 115,   // Value4 (Schildstärke)

			18 => 110,   // Value5 (Hülle bzw. Hitpoins)

			19 => 10,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 30,   // Value8 (Wendigkeit)

			22 => 8,   // Value9 (Erfahrung)

			23 => 3.2,   // Value10 (Warp)

			24 => 10,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 8,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Hideki',  // Name

			30 => 86,  // Benötige Arbeiter zum Bau

			31 => 'Die Hideki-Klasse wurde als kleines, wendiges Eskortschiff konzipiert. Doch aufgrund aktueller Ereignisse und fehlender Vorrichtungen wird sie in letzter Zeit allerdings hauptsächlich als Kampfschiff produziert; wodurch die Geschwindigkeit in den Hintergrund tritt.',

		),



        	// Totes Temp

	    5 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

		// Galor

	    7 => array(

			0 => 43075,  // Metal

			1 => 22950,  // Minerals

			2 => 17373,  // Latinum

			3 => 60,  // Min. Unit 1(L. Infanterie)

			4 => 30,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 75,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 310,  // Buildtime (in 5 Minuten Schritten)

			14 => 25,   // Value1 (Leichte Waffen)

			15 => 40,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 150,   // Value4 (Schildstärke)

			18 => 250,   // Value5 (Hülle bzw. Hitpoins)

			19 => 12,   // Value6 (Reaktionsgeschw.)

			20 => 16,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 15,   // Value9 (Erfahrung)

			23 => 3.8,   // Value10 (Warp)

			24 => 24,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 41,   // Value13 (Energy Available)

			27 => 25,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Galor',  // Name

			30 => 169,  // Benötige Arbeiter zum Bau

			31 => 'Die Schiffe der Galor III-Klasse sind Angriffskreuzer und gehören zu den meistbenutzten Schiffen der Cardassianer. Galor’s  sind durch ihre maximale Wandlungsfähigkeit hochgefährlich; man weiß nie welche Waffen eingebaut wurden...',

		),
		
    	// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Galor',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			

    	// Keldon

	    9 => array(

			0 => 45150,  // Metal

			1 => 39400,  // Minerals

			2 => 22700,  // Latinum

			3 => 140,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 25,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 125,  // Max Unit 2 (Sturmtruppe)

			9 => 100,  // Max Unit 3 (Hazard Team)

			10 => 10,  // Max Unit 4 (Commander)

			11 => 29,  // Unit 5 (Offizier)

			12 => 3,  // Unit 6 (Medizinisches Personal)

			13 => 395,  // Buildtime (in 5 Minuten Schritten)

			14 => 50,   // Value1 (Leichte Waffen)

			15 => 60,   // Value2 (Schwere Waffen)

			16 => 10,   // Value3 (Planetare Waffen)

			17 => 200,   // Value4 (Schildstärke)

			18 => 350,   // Value5 (Hülle bzw. Hitpoins)

			19 => 14,   // Value6 (Reaktionsgeschw.)

			20 => 13,   // Value7 (Bereitschaft)

			21 => 13,   // Value8 (Wendigkeit)

			22 => 14,   // Value9 (Erfahrung)

			23 => 3.2,   // Value10 (Warp)

			24 => 20,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 72,   // Value13 (Energy Available)

			27 => 60,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Keldon',  // Name

			30 => 1130,  // Benötige Arbeiter zum Bau

			31 => 'Die Keldon-Klasse ist eine modifizierte und stark aufgerüstete Version der Galor-Klasse, die jedoch weniger schnell und wendig ist. Sie wurden von den Cardassianern speziell ausgerüstet, um gegen ihr Pendant der Föderation, die Schiffe der Sovereign-Klasse, zu kämpfen und zu siegen.',

		),
		
					// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Keldon',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
						// Totes Temp

	    11 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schlachtschiff',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Orbitalgeschütz

	    12 => array(

			0 => 52920,  // Metal

			1 => 47880,  // Minerals

			2 => 38304,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			14 => 400,   // Value1 (Leichte Waffen)

			15 => 50,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 400,   // Value4 (Schildstärke)

			18 => 400,   // Value5 (Hülle bzw. Hitpoins)

			19 => 26,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 25,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 350,  // Benötige Arbeiter zum Bau

			31 => 'Diese orbitale Waffenplattform wurde während des Dominionkrieges entwickelt und seitdem immer weiter verbessert. Sie ist ausgestattet mit 3 Disruptorkanonen und einem schnell feuernden Torpedorohr, geladen mit 400 Plasmatorpedos, bestückt. Damit stellt es eine mächtige Defensive der Cardassianischen Union dar.',

	    ),

	),



	// Dominion

    4 => array(



		// Scout

	    0 => array(

			0 => 5865,  // Metal

			1 => 2173,  // Minerals

			2 => 3550,  // Latinum

			3 => 5,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 10,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 65,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 10,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 10,   // Value8 (Wendigkeit)

			22 => 20,   // Value9 (Erfahrung)

			23 => 7,   // Value10 (Warp)

			24 => 12,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Obsid. Scout',  // Name

			30 => 15,  // Benötige Arbeiter zum Bau

			31 => 'Zuerst war es nur ein Nichtangriffspakt, später sahen die Cardassianer die Größe des Dominions, und stellten uns daher ihre Scoutschiffe zur Verfügung. Obwohl sie nicht vom Dominion gebaut worden sind, könnten sie von den Vorta entworfen worden sein: Sie sind schnell, wendig, und schlecht mit den Sensoren zu erfassen.'

	    ),



    	// Karemma

	    1 => array(

			0 => 4395,  // Metal

			1 => 5745,  // Minerals

			2 => 4575,  // Latinum

			3 => 5,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 85,  // Buildtime (in 5 Minuten Schritten)

			14 => 15,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 20,   // Value5 (Hülle bzw. Hitpoins)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 3.9,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transportschiff',  // Name

			30 => 8,  // Benötige Arbeiter zum Bau

			31 => 'Durch unser Bündnisse mit den Cardassianern (das inzwischen wieder aufgehoben worden ist) haben wir dieses Schiff kennen gelernt, übernommen und verbessert. Es stellt einen guten Frachter dar und wir werden ihn von nun an einsetzten, nachdem die Hauptlieferanten unserer Frachtschiffe, die Karemma, eine kleine Lektion ihn Treue lernen mussten. Sie können momentan nicht die gewünschte Menge bereitstellen, also wird das diese Klasse übernehmen.',

	    ),

	    

    	// Kolonieschiff

	    2 => array(

			0 => 67905,  // Metal

			1 => 22535,  // Minerals

			2 => 34825,  // Latinum

			3 => 100,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 4,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 13,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 315,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 50,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 4.1,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 9,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Karemma Kolonieschiffe',  // Name

			30 => 1555,  // Benötige Arbeiter zum Bau

			31 => 'Mit dieser Klasse können sie einen Planeten zum richtigen Weg bekehren. Sobald Sie bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört haben, geht das Karemma Schiff verloren (da es für die ersten Einrichtungen demontiert wird) und der Planet steht unter Ihrem Kommando. Durch den Aufstand der Karemma, hat sich die Produktion verlangsamt, daher der hohe Preis.',

	    ),

	     	// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Attackship',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


    	// Attackship

	    4 => array(

			0 => 1825,  // Metal

			1 => 12137.5,  // Minerals

			2 => 360,  // Latinum

			3 => 20,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 10,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 7,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 146,  // Buildtime (in 5 Minuten Schritten)

			14 => 65,   // Value1 (Leichte Waffen)

			15 => 25,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 90,   // Value4 (Schildstärke)

			18 => 320,   // Value5 (Hülle bzw. Hitpoins)

			19 => 13,   // Value6 (Reaktionsgeschw.)

			20 => 20,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 11,   // Value9 (Erfahrung)

			23 => 3,   // Value10 (Warp)

			24 => 14,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 20,   // Value13 (Energy Available)

			27 => 8,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Attackship',  // Name

			30 => 96,  // Benötige Arbeiter zum Bau

			31 => 'Von unseren Feinden manchmal ´Battlebug´ genannt, stellt dieses Schiff unsere Rückrad dar und es ist inzwischen DAS Symbol unserer glorreichen Gründer und hat dem Dominion schon gute Dienste geleistet.',

	    ),

	    

    	// V-Klasse

	    5 => array(

			0 => 2850,  // Metal

			1 => 7325,  // Minerals

			2 => 10590,  // Latinum

			3 => 50,  // Min. Unit 1(L. Infanterie)

			4 => 15,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 75,  // Max Unit 1 (L. Infanterie)

			8 => 15,  // Max Unit 2 (Sturmtruppe)

			9 => 5,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 8,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 172,  // Buildtime (in 5 Minuten Schritten)

			14 => 165,   // Value1 (Leichte Waffen)

			15 => 85,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 210,   // Value4 (Schildstärke)

			18 => 360,   // Value5 (Hülle bzw. Hitpoins)

			19 => 16,   // Value6 (Reaktionsgeschw.)

			20 => 20,   // Value7 (Bereitschaft)

			21 => 7,   // Value8 (Wendigkeit)

			22 => 12,   // Value9 (Erfahrung)

			23 => 3,   // Value10 (Warp)

			24 => 16,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'V-Klasse',  // Name

			30 => 356,  // Benötige Arbeiter zum Bau

			31 => 'Obgleich unsere Jem Hadar Attack Fighter, mit Freude ihre fehlende Feuerkraft mit Suizidangriffen kompensieren, hatten die Götter die Weißheit, das dies auf lange Sicht gesehen, unserer Ressourcen zu stark beanspruchen würde. So wurde die Mischung zwischen Feuerkraft und Beweglichkeit, von den Vorta entworfen und in der V-Klasse vereint, damit der Suizid, so glorreich er auch sein mag, nicht immer die letzte Option sein muss.',

	),

 	// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'V-Klasse',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

 	// Totes Temp

	    7 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

 	// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


    	// BSC

	    9 => array(

			0 => 4700,  // Metal

			1 => 44725,  // Minerals

			2 => 23975,  // Latinum

			3 => 250,  // Min. Unit 1(L. Infanterie)

			4 => 40,  // Min. Unit 2 (Sturmtruppe)

			5 => 20,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 250,  // Max Unit 1 (L. Infanterie)

			8 => 40,  // Max Unit 2 (Sturmtruppe)

			9 => 20,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 6,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 446,  // Buildtime (in 5 Minuten Schritten)

			14 => 185,   // Value1 (Leichte Waffen)

			15 => 135,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 270,   // Value4 (Schildstärke)

			18 => 400,   // Value5 (Hülle bzw. Hitpoins)

			19 => 14,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 3,   // Value10 (Warp)

			24 => 20,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'BSC',  // Name

			30 => 867,  // Benötige Arbeiter zum Bau

			31 => 'Einer der mächtigsten Waffen des Dominions. Das Kampfschiff ist ein sehr wichtiger Bestandteil einer jeden Flotte. Seine Bewaffnung macht es zu einem mehr als gefährlichen Kriegschiff und ist oft mehr als genug, um das Wort der Gründer in die entferntesten Winkel der Galaxie zu bringen...',

	    ),


 	// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'BSC',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),



    	// Dread

	    11 => array(

			0 => 80900,  // Metal

			1 => 59275,  // Minerals

			2 => 68550,  // Latinum

			3 => 300,  // Min. Unit 1(L. Infanterie)

			4 => 150,  // Min. Unit 2 (Sturmtruppe)

			5 => 100,  // Min. Unit 3 (Hazard Team)

			6 => 7,  // Min. Unit 4 (Commander)

			7 => 300,  // Max Unit 1 (L. Infanterie)

			8 => 150,  // Max Unit 2 (Sturmtruppe)

			9 => 100,  // Max Unit 3 (Hazard Team)

			10 => 7,  // Max Unit 4 (Commander)

			11 => 21,  // Unit 5 (Offizier)

			12 => 16,  // Unit 6 (Medizinisches Personal)

			13 => 589,  // Buildtime (in 5 Minuten Schritten)

			14 => 395,   // Value1 (Leichte Waffen)

			15 => 235,   // Value2 (Schwere Waffen)

			16 => 38,   // Value3 (Planetare Waffen)

			17 => 290,   // Value4 (Schildstärke)

			18 => 490,   // Value5 (Hülle bzw. Hitpoins)

			19 => 12,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 22,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 70,   // Value13 (Energy Available)

			27 => 58,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Dread',  // Name

			30 => 2532,  // Benötige Arbeiter zum Bau

			31 => 'Dieses Schiff ist die letzte Linie des Gefechts, sollten die Gegner es je dorthin schaffen. Nur die treuesten und erfahrensten Jem Hadar bzw. Vorta dürfen dieses Schiff überhaupt betreten. Seine Grösse ist gewaltig und seine Feuerkraft noch größer: Jeder der sich ihm in den Wegs stellt ist Staub: Sei es ein Schiff oder ein Planet...',

	    ),

    	// Orbitalgeschütz

	    12 => array(

			0 => 29784,  // Metal

			1 => 29784,  // Minerals

			2 => 22440,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 204,  // Buildtime (in 5 Minuten Schritten)

			14 => 350,   // Value1 (Leichte Waffen)

			15 => 85,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 250,   // Value4 (Schildstärke)

			18 => 250,   // Value5 (Hülle bzw. Hitpoins)

			19 => 31,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 33,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 300,  // Benötige Arbeiter zum Bau

			31 => 'Um der zunehmenden Bedrohung der Welten des Dominion von außen entgegenzutreten, haben die Wissenschaftler diese effiziente Kampfstation entwickelt. Ausgestattet mit Polarongeschützen und einem Torpedowerfer stellt es eine effektive Gegenmaßnahme gegen jeden Angreifer dar.',

	    ),


	),

    

   	// Ferengi

    5 => array(

    	// Scout

	    0 => array(

			0 => 4425, // Metal

			1 => 3300, // Minerals

			2 => 4900, // Latinum 

			3 => 2, // Min. Unit 1(L. Infanterie)

			4 => 0, // Min. Unit 2 (Sturmtruppe)

			5 => 0, // Min. Unit 3 (Hazard Team)

			6 => 0, // Min. Unit 4 (Commander)

			7 => 10, // Max Unit 1 (L. Infanterie)

			8 => 0, // Max Unit 2 (Sturmtruppe)

			9 => 0, // Max Unit 3 (Hazard Team)

			10 => 1, // Max Unit 4 (Commander)

			11 => 0, // Unit 5 (Offizier)

			12 => 0, // Unit 6 (Medizinisches Personal)

			13 => 43, // Buildtime (in 5 Minuten Schritten)

			14 => 0, // Value1 (Leichte Waffen)

			15 => 0, // Value2 (Schwere Waffen)

			16 => 0, // Value3 (Planetare Waffen)

			17 => 0, // Value4 (Schildstärke)

			18 => 9.5, // Value5 (Hülle bzw. Hitpoins)

			19 => 4, // Value6 (Reaktionsgeschw.)

			20 => 2, // Value7 (Bereitschaft)

			21 => 10, // Value8 (Wendigkeit)

			22 => 8, // Value9 (Erfahrung)

			23 => 5.8, // Value10 (Warp)

			24 => 8, // Value11 (Sensoren)

			25 => 0, // Value12 (Tarnung)

			26 => 7, // Value13 (Energy Available)

			27 => 2, // Value14 (Used Energy)

			28 => 0, // Auf 0 lassen

			29 => 'Scout', // Name

			30 => 22, // Benötige Arbeiter zum Bau

			31 => 'Das Scout Schiff ist zum Spionieren gedacht und nicht als Angriffsschiff geeignet.',

			),



    	// Transporter

	    1 => array(

			0 => 5175, // Metal

			1 => 8663, // Minerals

			2 => 7630, // Latinum

			3 => 10, // Min. Unit 1(L. Infanterie)

			4 => 0, // Min. Unit 2 (Sturmtruppe)

			5 => 0, // Min. Unit 3 (Hazard Team)

			6 => 1, // Min. Unit 4 (Commander)

			7 => 20, // Max Unit 1 (L. Infanterie)

			8 => 0, // Max Unit 2 (Sturmtruppe)

			9 => 0, // Max Unit 3 (Hazard Team)

			10 => 1, // Max Unit 4 (Commander)

			11 => 0, // Unit 5 (Offizier)

			12 => 1, // Unit 6 (Medizinisches Personal)

			13 => 67, // Buildtime (in 5 Minuten Schritten)

			14 => 15, // Value1 (Leichte Waffen)

			15 => 0, // Value2 (Schwere Waffen)

			16 => 0, // Value3 (Planetare Waffen)

			17 => 4.5, // Value4 (Schildstärke)

			18 => 18, // Value5 (Hülle bzw. Hitpoins)

			19 => 2, // Value6 (Reaktionsgeschw.)

			20 => 1, // Value7 (Bereitschaft)

			21 => 5, // Value8 (Wendigkeit)

			22 => 5, // Value9 (Erfahrung)

			23 => 4.2, // Value10 (Warp)

			24 => 4, // Value11 (Sensoren)

			25 => 0, // Value12 (Tarnung)

			26 => 8, // Value13 (Energy Available)

			27 => 4, // Value14 (Used Energy)

			28 => 0, // Auf 0 lassen

			29 => 'Transporter', // Name

			30 => 77, // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder Rohstoffe bzw. Einheiten transportieren, oder sie mit auf einen Angriff schicken und Rohstoffe vom angegriffenen Planeten mitnehmen lassen.',

			),



    	// Kolonisationsschiff

	    2 => array(

			0 => 67575, // Metal

			1 => 35063, // Minerals

			2 => 60150, // Latinum

			3 => 150, // Min. Unit 1(L. Infanterie)

			4 => 0, // Min. Unit 2 (Sturmtruppe)

			5 => 0, // Min. Unit 3 (Hazard Team)

			6 => 4, // Min. Unit 4 (Commander)

			7 => 200, // Max Unit 1 (L. Infanterie)

			8 => 0, // Max Unit 2 (Sturmtruppe)

			9 => 0, // Max Unit 3 (Hazard Team)

			10 => 6, // Max Unit 4 (Commander)

			11 => 6, // Unit 5 (Offizier)

			12 => 5, // Unit 6 (Medizinisches Personal)

			13 => 287, // Buildtime (in 5 Minuten Schritten)

			14 => 10, // Value1 (Leichte Waffen)

			15 => 0, // Value2 (Schwere Waffen)

			16 => 0, // Value3 (Planetare Waffen)

			17 => 9.5, // Value4 (Schildstärke)

			18 => 47.5, // Value5 (Hülle bzw. Hitpoins)

			19 => 0, // Value6 (Reaktionsgeschw.)

			20 => 0, // Value7 (Bereitschaft)

			21 => 0, // Value8 (Wendigkeit)

			22 => 0, // Value9 (Erfahrung)

			23 => 4, // Value10 (Warp)

			24 => 0, // Value11 (Sensoren)

			25 => 0, // Value12 (Tarnung)

			26 => 12, // Value13 (Energy Available)

			27 => 5, // Value14 (Used Energy)

			28 => 0, // Auf 0 lassen

			29 => 'Kolonisationsschiff', // Name

			30 => 1197, // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren (da seine Holoemitter zur Simulation erster Einrichtungen demontiert werden) und der Planet steht unter deinem Kommando.',

			),


	 	// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scavenger',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


    	// Marauder

	    4 => array(

			0 => 800, // Metal

			1 => 9300, // Minerals

			2 => 11752.5, // Latinum

			3 => 25, // Min. Unit 1(L. Infanterie)

			4 => 5, // Min. Unit 2 (Sturmtruppe)

			5 => 3, // Min. Unit 3 (Hazard Team)

			6 => 2, // Min. Unit 4 (Commander)

			7 => 75, // Max Unit 1 (L. Infanterie)

			8 => 25, // Max Unit 2 (Sturmtruppe)

			9 => 3, // Max Unit 3 (Hazard Team)

			10 => 5, // Max Unit 4 (Commander)

			11 => 12, // Unit 5 (Offizier)

			12 => 6, // Unit 6 (Medizinisches Personal)

			13 => 191, // Buildtime (in 5 Minuten Schritten)

			14 => 11, // Value1 (Leichte Waffen)

			15 => 85, // Value2 (Schwere Waffen)

			16 => 0, // Value3 (Planetare Waffen)

			17 => 44, // Value4 (Schildstärke)

			18 => 200, // Value5 (Hülle bzw. Hitpoins)

			19 => 3, // Value6 (Reaktionsgeschw.)

			20 => 9, // Value7 (Bereitschaft)

			21 => 11, // Value8 (Wendigkeit)

			22 => 7, // Value9 (Erfahrung)

			23 => 2.2, // Value10 (Warp)

			24 => 9, // Value11 (Sensoren)

			25 => 0, // Value12 (Tarnung)

			26 => 25, // Value13 (Energy Available)

			27 => 10, // Value14 (Used Energy)

			28 => 0, // Auf 0 lassen

			29 => 'Scavenger', // Name

			30 => 461, // Benötige Arbeiter zum Bau

			31 => 'Das Mittelklasse-Schiff der Ferengi Allianz. Es besitzt keinerlei besondere Fertigkeiten und seine Kampfstärke ist dem Preis angemessen.',

			),


	 	// Totes Temp

	    5 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


	 	// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


    	// D´Kora-Class

	    7 => array(

			0 => 10825, // Metal

			1 => 19712.5, // Minerals

			2 => 50625, // Latinum

			3 => 120, // Min. Unit 1(L. Infanterie)

			4 => 55, // Min. Unit 2 (Sturmtruppe)

			5 => 20, // Min. Unit 3 (Hazard Team)

			6 => 5, // Min. Unit 4 (Commander)

			7 => 125, // Max Unit 1 (L. Infanterie)

			8 => 100, // Max Unit 2 (Sturmtruppe)

			9 => 80, // Max Unit 3 (Hazard Team)

			10 => 5, // Max Unit 4 (Commander)

			11 => 22, // Unit 5 (Offizier)

			12 => 8, // Unit 6 (Medizinisches Personal)

			13 => 359, // Buildtime (in 5 Minuten Schritten)

			14 => 55, // Value1 (Leichte Waffen)

			15 => 90, // Value2 (Schwere Waffen)

			16 => 0, // Value3 (Planetare Waffen)

			17 => 280, // Value4 (Schildstärke)

			18 => 250, // Value5 (Hülle bzw. Hitpoins)

			19 => 4, // Value6 (Reaktionsgeschw.)

			20 => 10, // Value7 (Bereitschaft)

			21 => 4, // Value8 (Wendigkeit)

			22 => 8, // Value9 (Erfahrung)

			23 => 0.4, // Value10 (Warp)

			24 => 9, // Value11 (Sensoren)

			25 => 0, // Value12 (Tarnung)

			26 => 54, // Value13 (Energy Available)

			27 => 45, // Value14 (Used Energy)

			28 => 0, // Auf 0 lassen

			29 => 'D´Kora-Class', // Name

			30 => 1841, // Benötige Arbeiter zum Bau

			31 => 'Das bekannteste aller Ferengi Schiffe mit gutem Offensiv- und Defensivpotential. Da sich jeder Ferengi sein Schiff selbst kauft variiert die Bewaffnung der D´Koras sehr stark.',

			),

	 	// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'D´Kora-Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Totes Temp

	    9 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schw.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schw.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Totes Temp

	    11 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schlachtschiff',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Orbitalgeschütz

	    12 => array(

			0 => 60480,  // Metal

			1 => 60480,  // Minerals

			2 => 50904,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			14 => 125,   // Value1 (Leichte Waffen)

			15 => 125,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 450,   // Value4 (Schildstärke)

			18 => 500,   // Value5 (Hülle bzw. Hitpoins)

			19 => 20,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 12,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 300,  // Benötige Arbeiter zum Bau

			31 => 'Immer häufiger überfallen Piraten die Kolonien und Handelshäfen der Ferengi-Allianz. Damit die Profite nicht länger darunter zu leiden haben, entwickelte ein findiger Wissenschaftler dieses teure, aber hocheffiziente Orbitalgeschütz, das mit Phasern und Plasmatorpedos bestückt ist.',

	    ),

	),



	// Borg

	6 => array(
		6 => array(
			0 => 50000,  // Metal

			1 => 50000,  // Minerals

			2 => 50000,  // Latinum

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			29 => 'Borg sphere',  // Name

			30 => 500,  // Benötige Arbeiter zum Bau
		),

		11 => array(
			0 => 500000,  // Metal

			1 => 500000,  // Minerals

			2 => 500000,  // Latinum

			13 => 552,  // Buildtime (in 5 Minuten Schritten)

			29 => 'Borg cube',  // Name

			30 => 50000,  // Benötige Arbeiter zum Bau
		),
	),



	// Q

    7 => array(),



	// Breen

    8 => array(



    	// Scout

	    0 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

		),



    	// Transporter

	    1 => array(

			0 => 4280,  // Metal

			1 => 7363,  // Minerals

			2 => 5220,  // Latinum

			3 => 15,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 2,  // Max Unit 4 (Commander)

			11 => 4,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 65,  // Buildtime (in 5 Minuten Schritten)

			14 => 19,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 22,   // Value5 (Hülle bzw. Hitpoins)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 4,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 5.8,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 185,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder 4000 Rohstoffe bzw. 400 Einheiten transportieren, oder sie mit auf einen Angriff schicken und Rohstoffe vom angegriffenen Planeten mitnehmen lassen. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',

	 	),

	 	

	 	// Kolonisierer

	    2 => array(

	        0 => 66600,  // Metal

			1 => 29363,  // Minerals

			2 => 41100,  // Latinum

			3 => 105,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 10,  // Max Unit 4 (Commander)

			11 => 12,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 285,  // Buildtime (in 5 Minuten Schritten)

			14 => 14,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 11,   // Value4 (Schildstärke)

			18 => 46,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 6.6,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 11,   // Value13 (Energy Available)

			27 => 7,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisierer',  // Name

			30 => 1575,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du entweder einen unbewohnten Planeten kolonisieren, oder einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren (da seine Holoemitter zur Simulation erster Einrichtungen demontiert werden) und der Planet steht unter deinem Kommando.',

	 	),

	 	// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gled Kraan',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Gled Kraan

	    4 => array(

	   	 	0 => 4625,  // Metal

			1 => 28987.5,  // Minerals

			2 => 4190,  // Latinum

			3 => 30,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 4,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 40,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 4,  // Max Unit 4 (Commander)

			11 => 10,  // Unit 5 (Offizier)

			12 => 6,  // Unit 6 (Medizinisches Personal)

			13 => 206,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 90,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 110,   // Value4 (Schildstärke)

			18 => 130,   // Value5 (Hülle bzw. Hitpoins)

			19 => 3,   // Value6 (Reaktionsgeschw.)

			20 => 5,   // Value7 (Bereitschaft)

			21 => 17,   // Value8 (Wendigkeit)

			22 => 2,   // Value9 (Erfahrung)

			23 => 3.8,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 7,   // Value12 (Tarnung)

			26 => 21,   // Value13 (Energy Available)

			27 => 10,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gled Kraan',  // Name

			30 => 235,  // Benötige Arbeiter zum Bau

			31 => 'Die Schiffe der Gled Kraan-Klasse sind die besten Fregaten. Wendig, robust und mit den tödlichen Energiedämpfungswaffen ausgestattet. Die Fregaten der Gled Kraan-Klasse sind, wie alle Schiffe der Breen, auf organischer Basis konstruiert.',

	 	),

	 	// Totes Temp

	    5 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Gor’Taan

	    7 => array(

	    	0 => 16375,  // Metal

			1 => 52488,  // Minerals

			2 => 38413,  // Latinum

			3 => 200,  // Min. Unit 1(L. Infanterie)

			4 => 5,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 200,  // Max Unit 1 (L. Infanterie)

			8 => 75,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 20,  // Unit 5 (Offizier)

			12 => 9,  // Unit 6 (Medizinisches Personal)

			13 => 378,  // Buildtime (in 5 Minuten Schritten)

			14 => 40,   // Value1 (Leichte Waffen)

			15 => 90,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 140,   // Value4 (Schildstärke)

			18 => 190,   // Value5 (Hülle bzw. Hitpoins)

			19 => 15,   // Value6 (Reaktionsgeschw.)

			20 => 17,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 7,   // Value9 (Erfahrung)

			23 => 1.6,   // Value10 (Warp)

			24 => 9,   // Value11 (Sensoren)

			25 => 5,   // Value12 (Tarnung)

			26 => 29,   // Value13 (Energy Available)

			27 => 15,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gor’Taan',  // Name

			30 => 865,  // Benötige Arbeiter zum Bau

			31 => 'Die Schiffe der Gor Taan-Klasse sind wendige Kampfschiffe, die meistens in großen Flotten eingesetzt werden. Sie sind ausgestattet mit den tödlichen Energiedämpfungswaffen der Breen. Die Kreuzer der Gor Taan-Klasse sind, wie alle Schiffe der Breen, auf organischer Basis konstruiert.',

	 	),

	 	// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gor’Taan',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Totes Temp

	    9 => array(

			0 => 40400,  // Metal

			1 => 80856,  // Minerals

			2 => 35236,  // Latinum

			3 => 210,  // Min. Unit 1(Centurion)

			4 => 30,  // Min. Unit 2 (Rem. Truppen)

			5 => 10,  // Min. Unit 3 (Tal Shiar)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 210,  // Max Unit 1 (Centurion)

			8 => 150,  // Max Unit 2 (Rem. Truppen)

			9 => 50,  // Max Unit 3 (Tal Shiar)

			10 => 8,  // Max Unit 4 (Commander)

			11 => 15,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 407,  // Buildtime (in 5 Minuten Schritten)

			14 => 108,   // Value1 (Leichte Waffen)

			15 => 163,   // Value2 (Schwere Waffen)

			16 => 38,   // Value3 (Planetare Waffen)

			17 => 660,   // Value4 (Schildstärke)

			18 => 980,   // Value5 (Hülle bzw. Hitpoints)

			19 => 16,   // Value6 (Reaktionsgeschw.)

			20 => 18,   // Value7 (Bereitschaft)

			21 => 15,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 1.6,   // Value10 (Warp)

			24 => 12,   // Value11 (Sensoren)

			25 => 5,   // Value12 (Tarnung)

			26 => 46,   // Value13 (Energy Available)

			27 => 35,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Chel Grett',  // Name

			30 => 772,  // Benötige Arbeiter zum Bau

			31 => 'Chel Gretta Schiffe dieser Klasse sind schwere Kreuzer, entworfen, um eine Schutzmauer gegen die feindlichen Schiffe schnell zu bauen.',

			),

	 	// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schw.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

	 	// Totes Temp

	    11 => array(

			0 => 77800,  // Metal

			1 => 130070,  // Minerals

			2 => 64920,  // Latinum

			3 => 250,  // Min. Unit 1(Centurion)

			4 => 100,  // Min. Unit 2 (Rem. Truppen)

			5 => 50,  // Min. Unit 3 (Tal Shiar)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 250,  // Max Unit 1 (Centurion)

			8 => 200,  // Max Unit 2 (Rem. Truppen)

			9 => 100,  // Max Unit 3 (Tal Shiar)

			10 => 12,  // Max Unit 4 (Commander)

			11 => 18,  // Unit 5 (Offizier)

			12 => 7,  // Unit 6 (Medizinisches Personal)

			13 => 573,  // Buildtime (in 5 Minuten Schritten)

			14 => 163,   // Value1 (Leichte Waffen)

			15 => 246,   // Value2 (Schwere Waffen)

			16 => 50,   // Value3 (Planetare Waffen)

			17 => 980,   // Value4 (Schildstärke)

			18 => 1050,   // Value5 (Hülle bzw. Hitpoints)

			19 => 18,   // Value6 (Reaktionsgeschw.)

			20 => 20,   // Value7 (Bereitschaft)

			21 => 12,   // Value8 (Wendigkeit)

			22 => 8,   // Value9 (Erfahrung)

			23 => 1.6,   // Value10 (Warp)

			24 => 9,   // Value11 (Sensoren)

			25 => 5,   // Value12 (Tarnung)

			26 => 55,   // Value13 (Energy Available)

			27 => 41,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Gel Chak',  // Name

			30 => 1560,  // Benötige Arbeiter zum Bau

			31 => 'Das Gel Chak-Klasse Schlachtschiffe sind das Flaggschiff der Flotte Breen. Räumen außerhalb selten engagierte Freunde, bilden sie den höchstmöglichen Abschreckung gegen Versuche der Invasion.',

			),

    	// Orbitalgeschütz

	    12 => array(

			0 => 41952,  // Metal

			1 => 55200,  // Minerals

			2 => 38088,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 276,  // Buildtime (in 5 Minuten Schritten)

			14 => 250,   // Value1 (Leichte Waffen)

			15 => 550,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 600,   // Value4 (Schildstärke)

			18 => 300,   // Value5 (Hülle bzw. Hitpoins)

			19 => 25,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 20,   // Value11 (Sensoren)

			25 => 9,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 425,  // Benötige Arbeiter zum Bau

			31 => 'Diese Kampfplattform wurde für defensive Zwecke entwickelt, um die Kolonien der Breen zu schützen. Ausgestattet mit einem Energiedissipator und vier Torpedowerfern verspricht es einen effektiven Schutz der Welten der Breen-Konföderation vor seinen Feinden.',

	    ),

    ),



	// Hirogen

    9 => array(



    	// Scout

	    0 => array(

			0 => 1350,  // Metal

			1 => 3392.5,  // Minerals

			2 => 5220,  // Latinum

			3 => 3,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 6,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 57,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 15,   // Value5 (Hülle bzw. Hitpoins)

			19 => 4,   // Value6 (Reaktionsgeschw.)

			20 => 2,   // Value7 (Bereitschaft)

			21 => 10,   // Value8 (Wendigkeit)

			22 => 25,   // Value9 (Erfahrung)

			23 => 4.3,   // Value10 (Warp)

			24 => 15,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 6,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 0,  // Benötige Arbeiter zum Bau

			31 => 'Das Scout Schiff ist zum Spionieren gedacht und nicht als Angriffsschiff geeignet.',

		),

		

    	// Transporter

	    1 => array(

			0 => 8325,  // Metal

			1 => 10388,  // Minerals

			2 => 7980,  // Latinum

			3 => 25,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 40,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 105,  // Buildtime (in 5 Minuten Schritten)

			14 => 20,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 5,   // Value4 (Schildstärke)

			18 => 35,   // Value5 (Hülle bzw. Hitpoins)

			19 => 2,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 2.5,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 8,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 12,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder Rohstoffe bzw. Einheiten transportieren, oder sie mit auf einen Angriff schicken und Rohstoffe vom angegriffenen Planeten mitnehmen lassen. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',

		),

		

    	// Koloschiff

	    2 => array(

			0 => 61875,  // Metal

			1 => 18938,  // Minerals

			2 => 28680,  // Latinum

			3 => 90,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 175,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 3,  // Max Unit 4 (Commander)

			11 => 7,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Medizinisches Personal)

			13 => 195,  // Buildtime (in 5 Minuten Schritten)

			14 => 20,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 10,   // Value4 (Schildstärke)

			18 => 70,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 4.1,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 13,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisationsschiff',  // Name

			30 => 502,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren und der Planet steht unter deinem Kommando.',

		),

		// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Fregatte',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
			// Totes Temp

	    4 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Fregatte',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Hunter Class

	    5 => array(

		    0 => 34275,  // Metal

			1 => 17700,  // Minerals

			2 => 7175,  // Latinum

			3 => 50,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 5,  // Min. Unit 3 (Hazard Team)

			6 => 3,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 55,  // Max Unit 2 (Sturmtruppe)

			9 => 35,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 7,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 291,  // Buildtime (in 5 Minuten Schritten)

			14 => 28,   // Value1 (Leichte Waffen)

			15 => 84,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 225,   // Value4 (Schildstärke)

			18 => 150,   // Value5 (Hülle bzw. Hitpoins)

			19 => 17,   // Value6 (Reaktionsgeschw.)

			20 => 12,   // Value7 (Bereitschaft)

			21 => 18,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 2.1,   // Value10 (Warp)

			24 => 18,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 35,   // Value13 (Energy Available)

			27 => 18,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Hunter-Class',  // Name

			30 => 27,  // Benötige Arbeiter zum Bau

			31 => 'Die Hunter-Class ist das Standard Schiff der Hirogen. Seit Jahrtausenden durchqueren sie in diesen Schiffen den Weltraum. Sie sind hervorragend für die Jagt geeignet, einem wichtigen Bestandteil ihrer Gesellschaft.',

		),

		// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Hunter-Class',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Holoship

	    7 => array(

			0 => 47450,  // Metal

			1 => 36350,  // Minerals

			2 => 23025,  // Latinum

			3 => 80,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 10,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 75,  // Max Unit 2 (Sturmtruppe)

			9 => 85,  // Max Unit 3 (Hazard Team)

			10 => 5,  // Max Unit 4 (Commander)

			11 => 10,  // Unit 5 (Offizier)

			12 => 6,  // Unit 6 (Medizinisches Personal)

			13 => 385,  // Buildtime (in 5 Minuten Schritten)

			14 => 8,   // Value1 (Leichte Waffen)

			15 => 54,   // Value2 (Schwere Waffen)

			16 => 5,   // Value3 (Planetare Waffen)

			17 => 50,   // Value4 (Schildstärke)

			18 => 520,   // Value5 (Hülle bzw. Hitpoins)

			19 => 9,   // Value6 (Reaktionsgeschw.)

			20 => 5,   // Value7 (Bereitschaft)

			21 => 3,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 2.2,   // Value10 (Warp)

			24 => 15,   // Value11 (Sensoren)

			25 => 2,   // Value12 (Tarnung)

			26 => 36,   // Value13 (Energy Available)

			27 => 25,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Holoship',  // Name

			30 => 199,  // Benötige Arbeiter zum Bau

			31 => 'Das Holoship ist eine Weiterentwicklung der gewöhnlichen Hunter-Class. Die Holoprojektoren in seinem Inneren ermöglichen es der Crew ihre Kampffähigkeiten ständig zu erweitern und sorgen so für ständige Kampfbereitschaft.',

		),

		
// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Holoship',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
			// Totes Temp

	    9 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schw.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
			// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schw.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
    	// Venatic Class

	    11 => array(

		    0 => 172250,  // Metal

			1 => 92300,  // Minerals

			2 => 74175,  // Latinum

			3 => 225,  // Min. Unit 1(L. Infanterie)

			4 => 125,  // Min. Unit 2 (Sturmtruppe)

			5 => 50,  // Min. Unit 3 (Hazard Team)

			6 => 8,  // Min. Unit 4 (Commander)

			7 => 400,  // Max Unit 1 (L. Infanterie)

			8 => 200,  // Max Unit 2 (Sturmtruppe)

			9 => 175,  // Max Unit 3 (Hazard Team)

			10 => 10,  // Max Unit 4 (Commander)

			11 => 20,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 543,  // Buildtime (in 5 Minuten Schritten)

			14 => 145,   // Value1 (Leichte Waffen)

			15 => 390,   // Value2 (Schwere Waffen)

			16 => 80,   // Value3 (Planetare Waffen)

			17 => 350,   // Value4 (Schildstärke)

			18 => 470,   // Value5 (Hülle bzw. Hitpoins)

			19 => 12,   // Value6 (Reaktionsgeschw.)

			20 => 10,   // Value7 (Bereitschaft)

			21 => 7,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 2.5,   // Value10 (Warp)

			24 => 22,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 84,   // Value13 (Energy Available)

			27 => 50,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Venatic-Class',  // Name

			30 => 1484,  // Benötige Arbeiter zum Bau

			31 => 'Die Vanatic-Class ist das mit abstand schwerste Hirogen Kriegsschiff. Allein durch ihre Größe von knapp 600m hebt sie sich deutlich von jedem anderen Hirogen Schiff ab. Die extrem schwere Panzerung ist problemlos in der Lage, die vergleichsweise schwachen Schilde auszugleichen. Die starke Bewaffnung macht dieses Schiff zu einem harten Brocken für jeden Gegner. Sie ist in der Lage problemlos auch größere Beute zur Strecke zu bringen.',

		),


    	// Orbitalgeschütz

	    12 => array(

			0 => 55440,  // Metal

			1 => 50160,  // Minerals

			2 => 36432,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 264,  // Buildtime (in 5 Minuten Schritten)

			14 => 350,   // Value1 (Leichte Waffen)

			15 => 115,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 650,   // Value4 (Schildstärke)

			18 => 150,   // Value5 (Hülle bzw. Hitpoins)

			19 => 29,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 36,   // Value11 (Sensoren)

			25 => 8,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 400,  // Benötige Arbeiter zum Bau

			31 => 'Feinde bedrohen immer häufiger die Welten, die den Stämmen der Hirogen als Jagdgründe dienen. Um diese lästige Bedrohung loszuwerden, wurde dieses mächtige raumgestützte Geschütz geschaffen, das mit seinen schweren Plasmakanonen schwere Schäden anrichten kann und durch die Monotaniumpanzerung kaum aufgespürt werden kann.',

	    ),

	),




	// Krenim

    10 => array(

    	// Scout

	    0 => array(

			0 => 450,  // Metal

			1 => 29,  // Minerals

			2 => 2186,  // Latinum

			3 => 5,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 10,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 5,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 12,   // Value5 (Hülle bzw. Hitpoins)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 3,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 5.5,   // Value10 (Warp)

			24 => 7,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 30,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Scout',  // Name

			30 => 0,  // Benötige Arbeiter zum Bau

			31 => 'Das Scoutschiff ist ein kleines, unbewaffnetes Schiff, dass mit einer geringen Besatzung bemannt ist und zum Ausspionieren von Planeten konzipiert ist.',

	    ),





		// Transporter

	    1 => array(

			0 => 5050,  // Metal

			1 => 5365,  // Minerals

			2 => 5706.67,  // Latinum

			3 => 5,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 50,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 45,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 13,   // Value4 (Schildstärke)

			18 => 29,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 6.1,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 30,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Transporter',  // Name

			30 => 82,  // Benötige Arbeiter zum Bau

			31 => 'Das Standard-Transportschiff des Krenim-Imperiums kann 4000 Einheiten Rohstoffe oder 400 Soldaten transportieren. Sein Kampfpotential ist sehr gering und ist ohne Begleitschutz sehr leicht angreifbar.',

		 ),





		// Kolonisationsschiff

	    2 => array(

			0 => 71750,  // Metal

			1 => 18385,  // Minerals

			2 => 37386.67,  // Latinum

			3 => 150,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 150,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 8,  // Max Unit 4 (Commander)

			11 => 3,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 185,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 11,   // Value4 (Schildstärke)

			18 => 44,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 4.5,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 40,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisationsschiff',  // Name

			30 => 1903,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du entweder einen unbewohnten Planeten kolonisieren, oder einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren und der Planet steht unter deinem Kommando.',

		 ),


// Totes Temp

	    3 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Patrol',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


		// Patrol

	    4 => array(

			0 => 17500,  // Metal

			1 => 20225,  // Minerals

			2 => 10291.67,  // Latinum

			3 => 35,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 8,  // Max Unit 4 (Commander)

			11 => 12,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 150,  // Buildtime (in 5 Minuten Schritten)

			14 => 5,   // Value1 (Leichte Waffen)

			15 => 60,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 55,   // Value4 (Schildstärke)

			18 => 85,   // Value5 (Hülle bzw. Hitpoins)

			19 => 12,   // Value6 (Reaktionsgeschw.)

			20 => 20,   // Value7 (Bereitschaft)

			21 => 25,   // Value8 (Wendigkeit)

			22 => 2,   // Value9 (Erfahrung)

			23 => 3.8,   // Value10 (Warp)

			24 => 4,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 40,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Patrol',  // Name

			30 => 353,  // Benötige Arbeiter zum Bau

			31 => 'Das Patrol Ship ist eine ältere Schiffsklasse der Krenim. Obwohl es bereits seid längerer Zeit durch effizientere Designs abgelöst worden ist, wird es aufgrund der kostengünstigen Produktion immer noch vom Imperium gebaut und verwendet.',

		 ),


// Totes Temp

	    5 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'L.Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

		// Cruiser

	    7 => array(

			0 => 9200,  // Metal

			1 => 36112.5,  // Minerals

			2 => 45908.33,  // Latinum

			3 => 100,  // Min. Unit 1(L. Infanterie)

			4 => 10,  // Min. Unit 2 (Sturmtruppe)

			5 => 10,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 100,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 8,  // Max Unit 4 (Commander)

			11 => 9,  // Unit 5 (Offizier)

			12 => 7,  // Unit 6 (Medizinisches Personal)

			13 => 303,  // Buildtime (in 5 Minuten Schritten)

			14 => 25,   // Value1 (Leichte Waffen)

			15 => 95,   // Value2 (Schwere Waffen)

			16 => 15,   // Value3 (Planetare Waffen)

			17 => 50,   // Value4 (Schildstärke)

			18 => 350,   // Value5 (Hülle bzw. Hitpoins)

			19 => 17,   // Value6 (Reaktionsgeschw.)

			20 => 15,   // Value7 (Bereitschaft)

			21 => 19,   // Value8 (Wendigkeit)

			22 => 14,   // Value9 (Erfahrung)

			23 => 4.1,   // Value10 (Warp)
			
			24 => 14,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 40,   // Value13 (Energy Available)

			27 => 30,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Cruiser',  // Name

			30 => 1072,  // Benötige Arbeiter zum Bau

			31 => 'Der schwere Kreuzer gehört zu den hochentwickelten Schiffsklassen der Krenim. Ausgestattet mit besonderen neuen Technologien ist der Kreuzer eine enorm schlagkräftige Waffe des Imperiums gegen seine Feinde.',

		 ),


// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Cruiser',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


		// Waffenschiff

	    9 => array(

			0 => 49850,  // Metal

			1 => 62175,  // Minerals

			2 => 29854.17,  // Latinum

			3 => 110,  // Min. Unit 1(L. Infanterie)

			4 => 50,  // Min. Unit 2 (Sturmtruppe)

			5 => 15,  // Min. Unit 3 (Hazard Team)

			6 => 5,  // Min. Unit 4 (Commander)

			7 => 110,  // Max Unit 1 (L. Infanterie)

			8 => 50,  // Max Unit 2 (Sturmtruppe)

			9 => 25,  // Max Unit 3 (Hazard Team)

			10 => 8,  // Max Unit 4 (Commander)

			11 => 16,  // Unit 5 (Offizier)

			12 => 4,  // Unit 6 (Medizinisches Personal)

			13 => 371,  // Buildtime (in 5 Minuten Schritten)

			14 => 200,   // Value1 (Leichte Waffen)

			15 => 20,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 350,   // Value4 (Schildstärke)

			18 => 700,   // Value5 (Hülle bzw. Hitpoins)

			19 => 10,   // Value6 (Reaktionsgeschw.)

			20 => 19,   // Value7 (Bereitschaft)

			21 => 9,   // Value8 (Wendigkeit)

			22 => 26,   // Value9 (Erfahrung)

			23 => 2,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 178,   // Value13 (Energy Available)

			27 => 160,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Waffenschiff',  // Name

			30 => 1476,  // Benötige Arbeiter zum Bau

			31 => 'Das Waffenschiff ist eine gewaltige, mobile Geschützplattform, welche mit zahlreichen Waffen bestückt ist. Es ist ein Symbol für den brutalen Imperialismus der Krenim und ihrer unbarmherzigen Haltung gegenüber ihren Feinden. Schon wenige dieser Schiffe können eine ganze Kolonie auslöschen.',

		 ),


// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Waffenschiff',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


// Totes Temp

	    11 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schlachtschiff',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
			
    	// Orbitalgeschütz

	    12 => array(

			0 => 57960,  // Metal

			1 => 46872,  // Minerals

			2 => 44352,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			14 => 75,   // Value1 (Leichte Waffen)

			15 => 300,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 500,   // Value4 (Schildstärke)

			18 => 250,   // Value5 (Hülle bzw. Hitpoins)

			19 => 35,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 25,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 575,  // Benötige Arbeiter zum Bau

			31 => 'Um die am äußersten Rand gelegenen Kolonien des gewaltigen Krenim-Imperiums effektiv verteidigen zu können, entwickelten Wissenschaftler im Auftrag des Verteidigungsministeriums diese Orbitalplattformen. Dabei handelt es sich im Prinzip um große Massebeschleuniger, die hohe Stückzahlen von Chronotonentorpedos in kurzer Zeit auf feindliche Flotten schleudern.',

	    ),

	),





	// Kazon

    11 => array(



    	// Torpedo

	    0 => array(

			0 => 7740,  // Metal

			1 => 2541,  // Minerals

			2 => 4920,  // Latinum

			3 => 15,  // Min. Unit 1(Exekutor)

			4 => 0,  // Min. Unit 2 (Assasine)

			5 => 0,  // Min. Unit 3 (Templar)

			6 => 0,  // Min. Unit 4 (High Kazon)

			7 => 15,  // Max Unit 1 (Exekutor)

			8 => 15,  // Max Unit 2 (Assasine)

			9 => 0, 	 // Max Unit 3 (Templar)

			10 => 0,  // Max Unit 4 (High Kazon)

			11 => 2,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Priester)

			13 => 55,  // Buildtime (in 5 Minuten Schritten)

			14 => 0,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 0,   // Value4 (Schildstärke)

			18 => 8,   // Value5 (Hülle bzw. Hitpoins)

			19 => 6,   // Value6 (Reaktionsgeschw.)

			20 => 4,   // Value7 (Bereitschaft)

			21 => 12,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 4.5,   // Value10 (Warp)

			24 => 10,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 2,   // Value13 (Energy Available)

			27 => 2,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Torpedo',  // Name

			30 => 8,  // Benötige Arbeiter zum Bau

			31 => 'Der Torpedo ist zum Spionieren gedacht und nicht als Angriffsschiff geeignet.',

		),

    	// Medium Transport

	    1 => array(

			0 => 4020,  // Metal

			1 => 7965,  // Minerals

			2 => 9390,  // Latinum

			3 => 60,  // Min. Unit 1(Exekutor)

			4 => 0,  // Min. Unit 2 (Assasine)

			5 => 0,  // Min. Unit 3 (Templar)

			6 => 1,  // Min. Unit 4 (High Kazon)

			7 => 100,  // Max Unit 1 (Exekutor)

			8 => 1,  // Max Unit 2 (Assasine)

			9 => 0,  // Max Unit 3 (Templar)

			10 => 1,  // Max Unit 4 (High Kazon)

			11 => 1,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Priester)

			13 => 111,  // Buildtime (in 5 Minuten Schritten)

			14 => 25,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 15,   // Value4 (Schildstärke)

			18 => 50,   // Value5 (Hülle bzw. Hitpoins)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 5,   // Value8 (Wendigkeit)

			22 => 5,   // Value9 (Erfahrung)

			23 => 3,   // Value10 (Warp)

			24 => 5,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 15,   // Value13 (Energy Available)

			27 => 4,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Medium Transport',  // Name

			30 => 128,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Transporter kann man entweder 4000 Rohstoffe bzw. 400 Einheiten transportieren, oder sie mit auf einen Angriff schicken. Sie sind relativ langsam, dafür ist ihre Verteidigung akzeptabel.',

		),



		// Kolonisationsschiff

	    2 => array(

			0 => 52180,  // Metal

			1 => 24905,  // Minerals

			2 => 55310,  // Latinum

			3 => 105,  // Min. Unit 1(Exekutor)

			4 => 0,  // Min. Unit 2 (Assasine)

			5 => 0,  // Min. Unit 3 (Templar)

			6 => 4,  // Min. Unit 4 (High Kazon)

			7 => 115,  // Max Unit 1 (Exekutor)

			8 => 0,  // Max Unit 2 (Assasine)

			9 => 0,  // Max Unit 3 (Templar)

			10 => 4,  // Max Unit 4 (High Kazon)

			11 => 19,  // Unit 5 (Offizier)

			12 => 5,  // Unit 6 (Priester)

			13 => 231,  // Buildtime (in 5 Minuten Schritten)

			14 => 10,   // Value1 (Leichte Waffen)

			15 => 0,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 20,   // Value4 (Schildstärke)

			18 => 60,   // Value5 (Hülle bzw. Hitpoins)

			19 => 0,   // Value6 (Reaktionsgeschw.)

			20 => 0,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 3.2,   // Value10 (Warp)

			24 => 0,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 15,   // Value13 (Energy Available)

			27 => 5,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kolonisationsschiff',  // Name

			30 => 2073,  // Benötige Arbeiter zum Bau

			31 => 'Mit dem Kolonieschiff kannst du entweder einen unbewohnten Planeten kolonisieren, oder einen Planeten erobern. Sobald du bei einem Planeten die komplette planetare Verteidigung sowie alle Einheiten und Schiffe zerstört hast, geht das Kolonieschiff verloren (da seine Holoemitter zur Simulation erster Einrichtungen demontiert werden) und der Planet steht unter deinem Kommando.'

		),





    	// Raptor

	    3 => array(

			0 => 28000,  // Metal

			1 => 25000,  // Minerals

			2 => 8500,  // Latinum

			3 => 35,  // Min. Unit 1(Exekutor)

			4 => 0,  // Min. Unit 2 (Assasine)

			5 => 5,  // Min. Unit 3 (Templar)

			6 => 3,  // Min. Unit 4 (High Kazon)

			7 => 70,  // Max Unit 1 (Exekutor)

			8 => 0,  // Max Unit 2 (Assasine)

			9 => 25,  // Max Unit 3 (Templar)

			10 => 5,  // Max Unit 4 (High Kazon)

			11 => 15,  // Unit 5 (Offizier)

			12 => 6,  // Unit 6 (Priester)

			13 => 140,  // Buildtime (in 5 Minuten Schritten)

			14 => 60,   // Value1 (Leichte Waffen)

			15 => 80,   // Value2 (Schwere Waffen)

			16 => 5,   // Value3 (Planetare Waffen)

			17 => 150,   // Value4 (Schildstärke)

			18 => 350,   // Value5 (Hülle bzw. Hitpoins)

			19 => 25,   // Value6 (Reaktionsgeschw.)

			20 => 15,   // Value7 (Bereitschaft)

			21 => 35,   // Value8 (Wendigkeit)

			22 => 10,   // Value9 (Erfahrung)

			23 => 6.5,   // Value10 (Warp)

			24 => 8,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 25,   // Value13 (Energy Available)

			27 => 25,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Raptor',  // Name

			30 => 210,  // Benötige Arbeiter zum Bau

			31 => 'Der Raptor ist ein hocheffizentes Angriffsschiff, das über ausgzeichnete Waffensysteme verfügt. Seine Einschränkung ist, dass er mit keinerlei Upgrades ausgestattet werden kann.',

		),

// Totes Temp

	    4 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Mojo1987 - erwischt',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Raider

	    5 => array(

			0 => 35475,  // Metal

			1 => 19075,  // Minerals

			2 => 11475,  // Latinum

			3 => 120,  // Min. Unit 1(Exekutor)

			4 => 15,  // Min. Unit 2 (Assasine)

			5 => 0,  // Min. Unit 3 (Templar)

			6 => 1,  // Min. Unit 4 (High Kazon)

			7 => 150,  // Max Unit 1 (Exekutor)

			8 => 150,  // Max Unit 2 (Assasine)

			9 => 25,  // Max Unit 3 (Templar)

			10 => 4,  // Max Unit 4 (High Kazon)

			11 => 17,  // Unit 5 (Offizier)

			12 => 3,  // Unit 6 (Priester)

			13 => 261,  // Buildtime (in 5 Minuten Schritten)

			14 => 175,   // Value1 (Leichte Waffen)

			15 => 25,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 150,   // Value4 (Schildstärke)

			18 => 80,   // Value5 (Hülle bzw. Hitpoins)

			19 => 15,   // Value6 (Reaktionsgeschw.)

			20 => 19,   // Value7 (Bereitschaft)

			21 => 15,   // Value8 (Wendigkeit)

			22 => 13,   // Value9 (Erfahrung)

			23 => 2,   // Value10 (Warp)

			24 => 4,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 50,   // Value13 (Energy Available)

			27 => 45,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Raider',  // Name

			30 => 171,  // Benötige Arbeiter zum Bau

			31 => 'Der Raider ist ein hocheffizentes Angriffsschiff, das über ausgzeichnete Waffensysteme verfügt; darüber hinaus ist der Raider extrem wendig für seine Rumpfklasse und ist daher für spezielle Einsätze geeignet.',

		),

// Totes Temp

	    6 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Raider',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

// Totes Temp

	    7 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

// Totes Temp

	    8 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Kreuzer',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),

    	// Warship

	    9 => array(

			0 => 99875,  // Metal

			1 => 26163,  // Minerals

			2 => 37628,  // Latinum

			3 => 110,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 50,  // Min. Unit 3 (Hazard Team)

			6 => 2,  // Min. Unit 4 (Commander)

			7 => 250,  // Max Unit 1 (L. Infanterie)

			8 => 100,  // Max Unit 2 (Sturmtruppe)

			9 => 75,  // Max Unit 3 (Hazard Team)

			10 => 6,  // Max Unit 4 (Commander)

			11 => 26,  // Unit 5 (Offizier)

			12 => 2,  // Unit 6 (Medizinisches Personal)

			13 => 387,  // Buildtime (in 5 Minuten Schritten)

			14 => 150,   // Value1 (Leichte Waffen)

			15 => 100,   // Value2 (Schwere Waffen)

			16 => 20,   // Value3 (Planetare Waffen)

			17 => 115,   // Value4 (Schildstärke)

			18 => 700,   // Value5 (Hülle bzw. Hitpoins)

			19 => 15,   // Value6 (Reaktionsgeschw.)

			20 => 13,   // Value7 (Bereitschaft)

			21 => 11,   // Value8 (Wendigkeit)

			22 => 7,   // Value9 (Erfahrung)

			23 => 2.2,   // Value10 (Warp)

			24 => 11,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 99,   // Value13 (Energy Available)

			27 => 84,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Predator',  // Name

			30 => 301,  // Benötige Arbeiter zum Bau

			31 => 'Der Stolz der Kazon, der Predator, ist teuer aber verhältnismäßig stark. Schon wenige dieser Schiffe vernichten komplette feinliche Flotten wenn nötig. Besonders seine gute Upgradefähigkeit rechtfertigen den Preis und die Bauzeit.',

	    ),

	    
		
					// Totes Temp

	    10 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Predator',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),
			
						// Totes Temp

	    11 => array(

			0 => 100000000,  // Metal

			1 => 1,  // Minerals

			2 => 1,  // Latinum

			3 => 1,  // Min. Unit 1(Centurion)

			4 => 1,  // Min. Unit 2 (Rem. Truppen)

			5 => 1,  // Min. Unit 3 (Tal Shiar)

			6 => 1,  // Min. Unit 4 (Commander)

			7 => 1,  // Max Unit 1 (Centurion)

			8 => 1,  // Max Unit 2 (Rem. Truppen)

			9 => 1,  // Max Unit 3 (Tal Shiar)

			10 => 1,  // Max Unit 4 (Commander)

			11 => 1,  // Unit 5 (Offizier)

			12 => 1,  // Unit 6 (Medizinisches Personal)

			13 => 1,  // Buildtime (in 5 Minuten Schritten)

			14 => 1,   // Value1 (Leichte Waffen)

			15 => 1,   // Value2 (Schwere Waffen)

			16 => 1,   // Value3 (Planetare Waffen)

			17 => 1,   // Value4 (Schildstärke)

			18 => 1,   // Value5 (Hülle bzw. Hitpoints)

			19 => 1,   // Value6 (Reaktionsgeschw.)

			20 => 1,   // Value7 (Bereitschaft)

			21 => 1,   // Value8 (Wendigkeit)

			22 => 1,   // Value9 (Erfahrung)

			23 => 1,   // Value10 (Warp)

			24 => 1,   // Value11 (Sensoren)

			25 => 1,   // Value12 (Tarnung)

			26 => 1,   // Value13 (Energy Available)

			27 => 1,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Schlachtschiff',  // Name

			30 => 1,  // Benötige Arbeiter zum Bau

			31 => 'Ich bin nicht da. Aber du musst mich lieb haben, pflegen, füttern und ganz oft drücken.',

			),


    	// Orbitalgeschütz

	    12 => array(

			0 => 43344,  // Metal

			1 => 38808,  // Minerals

			2 => 41328,  // Latinum

			3 => 0,  // Min. Unit 1(L. Infanterie)

			4 => 0,  // Min. Unit 2 (Sturmtruppe)

			5 => 0,  // Min. Unit 3 (Hazard Team)

			6 => 0,  // Min. Unit 4 (Commander)

			7 => 0,  // Max Unit 1 (L. Infanterie)

			8 => 0,  // Max Unit 2 (Sturmtruppe)

			9 => 0,  // Max Unit 3 (Hazard Team)

			10 => 0,  // Max Unit 4 (Commander)

			11 => 0,  // Unit 5 (Offizier)

			12 => 0,  // Unit 6 (Medizinisches Personal)

			13 => 252,  // Buildtime (in 5 Minuten Schritten)

			14 => 550,   // Value1 (Leichte Waffen)

			15 => 50,   // Value2 (Schwere Waffen)

			16 => 0,   // Value3 (Planetare Waffen)

			17 => 300,   // Value4 (Schildstärke)

			18 => 500,   // Value5 (Hülle bzw. Hitpoins)

			19 => 45,   // Value6 (Reaktionsgeschw.)

			20 => 25,   // Value7 (Bereitschaft)

			21 => 0,   // Value8 (Wendigkeit)

			22 => 0,   // Value9 (Erfahrung)

			23 => 0,   // Value10 (Warp)

			24 => 12,   // Value11 (Sensoren)

			25 => 0,   // Value12 (Tarnung)

			26 => 33,   // Value13 (Energy Available)

			27 => 33,   // Value14 (Used Energy)

			28 => 0,   // Auf 0 lassen

			29 => 'Orbitalgeschütz',  // Name

			30 => 275,  // Benötige Arbeiter zum Bau

			31 => 'In den sich ausweitenden Gefechten um die Vorherrschaft einzelner Kazonsekten kommt es immer öfter zu Kämpfen, die um ganze Planeten geführt werden. Zum Schutz ihrer Welten haben verschiedene Sekten unabhängig voneinander dieses mit sechs Partikelgeschützen bewaffnete orbitale Gerät entwickelt.',

	    ),
	    

	),




    // Menschen 29th

    12 => array(

	    0 => array(

			0 => 500,

			1 => 100,

			2 => 0,

			3 => 5,

			4 => 0,

			5 => 0,

			6 => 0,

			7 => 10,

			8 => 0,

			9 => 0,

			10 => 1,

			11 => 0,

			12 => 0,

			13 => 2,

			14 => 10,

			15 => 0,

			16 => 0,

			17 => 0,

			18 => 10,

			19 => 4,

			20 => 2,

			21 => 10,

			22 => 0,

			23 => 4,

			24 => 5,

			25 => 0,

			26 => 8,

			27 => 2,

			28 => 0,

			29 => 'Scout 29th',

			30 => 10,

			31 => 'Forschrittlichere Version des seit mehreren Jahrhunderten eingesetzen Scout.',

	    ),

	    

	    1 => array(

			0 => 650,

			1 => 500,

			2 => 600,

			3 => 30,

			4 => 0,

			5 => 0,

			6 => 1,

			7 => 40,

			8 => 0,

			9 => 0,

			10 => 1,

			11 => 2,

			12 => 1,

			13 => 1,

			14 => 15,

			15 => 0,

			16 => 0,

			17 => 5,

			18 => 20,

			19 => 2,

			20 => 1,

			21 => 5,

			22 => 5,

			23 => 3,

			24 => 5,

			25 => 0,

			26 => 10,

			27 => 4,

			28 => 0,

			29 => 'Transporter 29th',

			30 => 50,

			31 => 'Fortschrittlichere Version des seit mehreren Jahrhunderten eingesetzen Transporters.',



	    ),



	    2 => array(

			0 => 30000,

			1 => 15000,

			2 => 7500,

			3 => 100,

			4 => 0,

			5 => 0,

			6 => 4,

			7 => 200,

			8 => 0,

			9 => 0,

			10 => 6,

			11 => 10,

			12 => 5,

			13 => 120,

			14 => 10,

			15 => 0,

			16 => 0,

			17 => 10,

			18 => 50,

			19 => 0,

			20 => 0,

			21 => 0,

			22 => 0,

			23 => 3,

			24 => 0,

			25 => 0,

			26 => 15,

			27 => 5,

			28 => 0,

			29 => 'Kolonisationsschiff 29th',

			30 => 500,

			31 => 'Fortschrittlichere Version des seit Jahrhunderten eingesetzten Kolonisationsschiff.',

	    ),

    	

	    3 => array(

			0 => 15000,

			1 => 1000,

			2 => 2500,

			3 => 100,

			4 => 50,

			5 => 25,

			6 => 10,

			7 => 500,

			8 => 200,

			9 => 150,

			10 => 12,

			11 => 40,

			12 => 20,

			13 => 150,

			14 => 50,

			15 => 70,

			16 => 20,

			17 => 100,

			18 => 300,

			19 => 6,

			20 => 6,

			21 => 6,

			22 => 6,

			23 => 5,

			24 => 6,

			25 => 0,

			26 => 75,

			27 => 50,

			28 => 0,

			29 => 'Prometheus-Klasse',

			30 => 450,

			31 => 'Vor knapp 300 Jahren wurde die Prometheus außer Dienst, wurde aber aufgrund der Einsätze in der Vergangenheit wieder reaktiviert.',

	    ),	

	    

	    4 => array(

			0 => 20000,

			1 => 1000,

			2 => 2000,

			3 => 100,

			4 => 20,

			5 => 10,

			6 => 10,

			7 => 600,

			8 => 400,

			9 => 350,

			10 => 20,

			11 => 10,

			12 => 10,

			13 => 70,

			14 => 0,

			15 => 0,

			16 => 0,

			17 => 0,

			18 => 1000,

			19 => 20,

			20 => 20,

			21 => 10,

			22 => 10,

			23 => 9,

			24 => 20,

			25 => 20,

			26 => 120,

			27 => 20,

			28 => 0,

			29 => 'Wells-Klasse',

			30 => 200,

			31 => 'Das Rückgrat der Flotte bilden die Zeitschiffe der Wells-Klasse, die für die unterschiedlichsten Aufgaben benutzt werden können.',

	    ),

                    5 => array(

			0 => 20000,

			1 => 1000,

			2 => 2000,

			3 => 100,

			4 => 20,

			5 => 10,

			6 => 10,

			7 => 600,

			8 => 400,

			9 => 350,

			10 => 20,

			11 => 10,

			12 => 10,

			13 => 70,

			14 => 0,

			15 => 0,

			16 => 0,

			17 => 0,

			18 => 10,

			19 => 20,

			20 => 20,

			21 => 10,

			22 => 10,

			23 => 9,

			24 => 20,

			25 => 20,

			26 => 120,

			27 => 20,

			28 => 0,

			29 => 'Flecki Knuddel-Eskorte',

			30 => 200,

			31 => 'Das Rückgrat der Flotte bilden die Zeitschiffe der Wells-Klasse, die für die unterschiedlichsten Aufgaben benutzt werden können.',

	    ),


    ),

);

	



// Preise der Schiffe anpassen

foreach ($SHIP_TORSO as $key1 => $foo) 

foreach ($SHIP_TORSO[$key1] as $key2 => $foo) 

{

$SHIP_TORSO[$key1][$key2][0]*=1;

$SHIP_TORSO[$key1][$key2][1]*=1;

$SHIP_TORSO[$key1][$key2][2]*=1;

$SHIP_TORSO[$key1][$key2][13]*=1;

$SHIP_TORSO[$key1][$key2][30]*=1;

}

?>



