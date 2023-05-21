<?php
/*    
    Officers management module, added to STFC by Delogu in 2016
        
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

//German

define ("GER_TEXT0", 'Kommandierende Offiziere:');

define("GER_TEXT1", 'Sie k&ouml;nnen diesen kommandierenden Offizier bis zum Rang eines Flottenadmirals bef&ouml;rdern, damit er eine gr&ouml;&szlig;ere Anzahl von Schiffen kontrollieren kann.<br>Das Level wird an den neuen Rang angepasst.<br>Bedenken Sie, dass h&ouml;here R&aumlnge mehr Erfahrung zum Leveln erfordern.<br><br>WARNUNG:<br>Das Herabstufen eines Offiziers auf einen fr&uuml;heren Rang ist nicht zul&auml;ssig.');

define("GER_TEXT2", 'Promote');

define("GER_TEXT3", 'Kommodore');

define("GER_TEXT4", 'Konteradmiral');

define("GER_TEXT5", 'Admiral');

define("GER_TEXT6", 'Flottenadmiral');

define("GER_TEXT7", 'Rang');

define("GER_TEXT7b", 'Name');

define("GER_TEXT7c", 'Niveau');

define("GER_TEXT8", 'W&auml;hlen Sie den Namen des neuen Kommandanten: ');

define("GER_TEXT9", 'Gewinnen');

define("GER_TEXT10", 'Die Gesamtzahl der Einheiten, &uuml;ber die dieser Offizier effektiv verfügen kann.<br>Wird dieses Limit &uuml;berschritten, erhalten die Schiffe der Flotte keinen Kommandobonus.');

define("GER_TEXT11", 'Combat Eff.');

define("GER_TEXT12", 'Flotte optimale Zusammensetzung');

define("GER_TEXT13", 'Jeder Rang hat seine eigene Kampfstrategie, die auf dem Einsatz verschiedener Schiffstypen in bestimmten Anteilen basiert.<br>Die Bereitstellung des Offiziers, der eine Flotte gem&auml;&szlig; den optimalen Spezifikationen befehligt, gew&auml;hrleistet einen erheblichen Vorteil im Kampf und eine h&ouml;here Geschwindigkeit, um ein hohes Ma&szlig; an Fachwissen zu erreichen.');

define("GER_TEXT14", 'M&ouml;chten Sie diesen Offizier wirklich bef&ouml;rdern? Dieser Vorgang ist NICHT umkehrbar');

define ("GER_TEXT15", 'Sieg');

define ("GER_TEXT16", 'Niederlagen');

define ("GER_TEXT17", 'Klasse');

define ("GER_TEXT18", 'Get&ouml;tet');

define ("GER_TEXT19", 'Hat verloren');

define ("GER_TEXT20", 'Cambia formazione');

define("GER_TEXT90_0_0", 'Speartip');

define("GER_TEXT90_0_1", 'Advanced Warfare');

define("GER_TEXT90_0_2", 'Shock and Awe');

define("GER_TEXT90_1_0", 'Predatory Wing');

define("GER_TEXT90_1_1", 'Relentless');

define("GER_TEXT90_1_2", 'SwordMaster');

define("GER_TEXT90_2_0", 'Predatory Wing');

define("GER_TEXT90_2_1", 'ghor Hub');

define("GER_TEXT90_2_2", 'mup DeSDu&rsquo; tIq');

define("GER_TEXT90_3_0", 'Advanced Formation');

define("GER_TEXT90_3_1", 'Expert Tactician');

define("GER_TEXT90_3_2", 'Master Tactician');

define("GER_TEXT90_4_0", 'Pattern Gamma One');

define("GER_TEXT90_4_1", 'Coordinated shooting');

define("GER_TEXT90_4_2", 'Pattern Gamma Three');

define("GER_TEXT90_5_0", 'Greater Responsabiliy');

define("GER_TEXT90_5_1", 'Versatile');

define("GER_TEXT90_5_2", 'Hit Hard');

define("GER_TEXT90_8_0", 'Coordinated Swarm');

define("GER_TEXT90_8_1", 'Strike the weak side');

define("GER_TEXT90_8_2", 'Strenght by numbers');

define("GER_TEXT90_9_0", 'Legend&auml;re J&auml;ger');

define("GER_TEXT90_9_1", 'Das Beste von hundert');

define("GER_TEXT90_9_2", 'Das Beste von Tausend');

define("GER_TEXT90_11_0", 'Wolfpack');

define("GER_TEXT90_11_1", 'Hit and run');

define("GER_TEXT90_11_2", 'Bullseye');

define("GER_TEXT91_0", 'Spezialist f&uuml;r Man&ouml;ver');

define("GER_TEXT91_1", 'Alle vor Flanke !!!');

define("GER_TEXT91_2", 'Muster Tetha One');

define("GER_TEXT91_3", 'Muster Theta Zwei');

define ("GER_TEXT100_0_0", 'Get experience normally.<br><br>Effect: change of formation and unit cap<br><br>Object: Commodore<br>Raise unit cap by 80<br>Class 1: 50%<br>Class 2: 30%<br>Class 3: 20% ');

define ("GER_TEXT100_0_1", 'Get experience normally.<br><br>Effect: Weapon Bonus Earned<br><br>Object: Every Rank<br>Ship Weaponry: Modulation +20<br>Ship Weaponry: Focus +20');

define ("GER_TEXT100_0_2", 'Get experience normally.<br><br>Effect: Weapon Bonus Earned<br><br>Object: Every Rank<br>Ship Weaponry: Concussion + 30');

define ("GER_TEXT100_2_0", 'Sammeln Sie Erfahrungen von den letzten Schl&auml;gen Ihrer Schiffe der <i>Bird of Prey-Klasse</i>.<br><br>Effekt: formation bearbeiten<br>Objekt: Konteradmiral<br><br>Klasse 1 auf 70% setzen<br>Klasse 2 auf 30% setzen');

define ("GER_TEXT100_2_1", 'Gew&ouml;hnlich Erfahrungen sammeln.<br><br>Effekt: Waffen-Bonus erhalten<br><br>Objekt: Jeder Grad<br>Schiffsbewaffnung: Flugbahn +20<br>Schiffsbewaffnung: Ersch&uuml;tterung +20');

define ("GER_TEXT100_2_2", 'Gew&ouml;hnlich Erfahrungen sammeln.<br><br>Effekt: Waffen-Bonus erhalten<br><br>Objekt: Jeder Grad<br>Schiffsbewaffnung: Modulation +20<br>Schiffsbewaffnung: Fokus +20');

define ("GER_TEXT100_5_0", 'Normale Erfahrung sammeln.<br><br>Auswirkung: Befehlseffizienz &auml;ndern<br><br>Objekt: Commodore<br>Einheitsobergrenze um 40 erh&ouml;hen<br>Objekt: Konteradmiral<br>Einheitsobergrenze um 60 erh&ouml;hen');

define ("GER_TEXT100_5_1", 'Normale Erfahrung sammeln.<br><br>Effekt: Ausbildung &auml;ndern<br><br>Objekt: Jeder Grad<br>Zivilklasse: 5%.');

define ("GER_TEXT100_5_2", 'Normale Erfahrung sammeln.<br><br>Auswirkung: Waffen-Bonus erhalten<br><br>Objekt: Beliebiger Grad<br>Schiffsbewaffnung: Modulation +20<br>Schiffsbewaffnung: Flugbahn +20<br>Schiffsbewaffnung: Ersch&uuml;tterung +20');

define ("GER_TEXT100_9_0", 'Erlebe die Todesst&ouml;&szlig;e deiner Schiffe der Venatic-Klasse.<br><br>Wirkung: Bildung &auml;ndern<br><br>Objekt: Kommodore<br>Klasse 1: 0%<br>Klasse 2: 0%<br>Klasse 3: 100%<br><br>Wirkung: Ger&auml;tedeckel anheben<br><br>Objekt: Kommodore<br>Erh&ouml;hen Sie die Ger&auml;tekappe um 40');

define ("GER_TEXT100_9_1", 'Normalerweise Erfahrung sammeln.<br><br>Effekt: Holen Sie sich einen Waffenbonus<br>Fach: Jeder Abschluss<br><br>Schiffsbewaffnung: Modulation +15 <br> Schiffsbewaffnung: Fokus +15 <br> Schiffsbewaffnung: Ersch&uuml;tterung +20');

define ("GER_TEXT100_9_2", 'Normalerweise Erfahrung sammeln.<br><br>Effekt: Holen Sie sich einen Waffenbonus<br>Fach: Jeder Abschluss<br><br>Schiffsbewaffnung: Modulation +30 <br> Schiffsbewaffnung: Fokus +30 <br> Schiffsbewaffnung: Ersch&uuml;tterung +40');

define ("GER_TEXT101_0", 'Normalerweise Erfahrung sammeln.<br><br>Effect: Intra-system mouvements requires less time.<br><br>Object: Every Rank<br>Flying time lessened by 1 tick');

define ("GER_TEXT101_1", 'Normalerweise Erfahrung sammeln.<br><br>Effect: Fleet top speed is raised.<br>Can not be higher than Warp 9.95.<br><br>Object: Every Rank<br>Speed Bonus of Warp 2.5');

define ("GER_TEXT101_2", 'Normalerweise Erfahrung sammeln.<br><br>Effect: Hitchance cap for all the ships of the fleet is raised.<br>Do not affect target evading chances.<br><br>Object: Every Rank<br>Hitchance cap raised to 94&#37;');

define ("GER_TEXT101_3", 'Normalerweise Erfahrung sammeln.<br><br>Effect: Hitchance cap for all the ships of the fleet is raised.<br>Do not affect target evading chances.<br><br>Object: Every Rank<br>Hitchance cap raised to 100&#37;');

//English

define ("ENG_TEXT0", 'Commanding Officers:');

define("ENG_TEXT1", 'You can promote this Commanding Officer up to the rank of Fleet Admiral to allow him to control a greater number of ships. <br> The level will be adapted to the new rank. <br> Consider that higher ranks require more experience to level.<br><br>WARNING:<br>Demoting an officer to a previous rank is not permitted.');

define("ENG_TEXT2", 'Promote');

define("ENG_TEXT3", 'Commodore');

define("ENG_TEXT4", 'RearAdmiral');

define("ENG_TEXT5", 'Admiral');

define("ENG_TEXT6", 'Fleet Admiral');

define("ENG_TEXT7", 'Rank');

define("ENG_TEXT7b", 'Name');

define("ENG_TEXT7c", 'Level');

define("ENG_TEXT8", 'Choose the name of the new Commanding Officer: ');

define("ENG_TEXT9", 'Enlist');

define("ENG_TEXT10", 'The total number of units that this officer can command effectively.<br> If this limit is exceeded, the ships of the fleet does not get any command bonus.');

define("ENG_TEXT11", 'Combat Eff.');

define("ENG_TEXT12", 'Fleet optimal composition');

define("ENG_TEXT13", 'Each rank has its own combat strategy based on the use of different types of ships in certain proportions. <br>Providing the officer commanding a fleet according to its optimum specifications ensure a significant advantage in combat and a higher speed in achieve high levels of expertise.');

define("ENG_TEXT14", 'Do you really want to promote this officer? This operation is NOT reversible!');

define ("ENG_TEXT15", 'Wins');

define ("ENG_TEXT16", 'Lost');

define ("ENG_TEXT17", 'Class');

define ("ENG_TEXT15", 'Won Battles');

define ("ENG_TEXT16", 'Lost Battles');

define ("ENG_TEXT17", 'Class');

define ("ENG_TEXT18", 'Killed');

define ("ENG_TEXT19", 'Lost');

define ("ENG_TEXT20", 'Cambia formazione');

define("ENG_TEXT90_0_0", 'Speartip');

define("ENG_TEXT90_0_1", 'Advanced Warfare');

define("ENG_TEXT90_0_2", 'Shock and Awe');

define("ENG_TEXT90_1_0", 'Predatory Wing');

define("ENG_TEXT90_1_1", 'Relentless');

define("ENG_TEXT90_1_2", 'SwordMaster');

define("ENG_TEXT90_2_0", 'Predatory Wing');

define("ENG_TEXT90_2_1", 'ghor Hub');

define("ENG_TEXT90_2_2", 'mup DeSDu&rsquo; tIq');

define("ENG_TEXT90_3_0", 'Advanced Formation');

define("ENG_TEXT90_3_1", 'Expert Tactician');

define("ENG_TEXT90_3_2", 'Master Tactician');

define("ENG_TEXT90_4_0", 'Pattern Gamma One');

define("ENG_TEXT90_4_1", 'Coordinated shooting');

define("ENG_TEXT90_4_2", 'Pattern Gamma Three');

define("ENG_TEXT90_5_0", 'Greater Responsabiliy');

define("ENG_TEXT90_5_1", 'Versatile');

define("ENG_TEXT90_5_2", 'Hit Hard');

define("ENG_TEXT90_8_0", 'Coordinated Swarm');

define("ENG_TEXT90_8_1", 'Strike the weak side');

define("ENG_TEXT90_8_2", 'Strenght by numbers');

define("ENG_TEXT90_9_0", 'Legendary Hunters');

define("ENG_TEXT90_9_1", 'Best of hundred');

define("ENG_TEXT90_9_2", 'Best of thousand');

define("ENG_TEXT90_11_0", 'Wolfpack');

define("ENG_TEXT90_11_1", 'Hit and run');

define("ENG_TEXT90_11_2", 'Bullseye');

define("ENG_TEXT91_0", 'Maneuver specialist');

define("ENG_TEXT91_1", 'All ahead flank!!!');

define("ENG_TEXT91_2", 'Pattern Theta One');

define("ENG_TEXT91_3", 'Pattern Theta Two');

define ("ENG_TEXT100_0_0", 'Get experience normally.<br><br>Effect: change of formation and unit cap<br><br>Object: Commodore<br>Raise unit cap by 80<br>Class 1: 50%<br>Class 2: 30%<br>Class 3: 20% ');

define ("ENG_TEXT100_0_1", 'Get experience normally.<br><br>Effect: Weapon Bonus Earned<br><br>Object: Every Rank<br>Ship Weaponry: Modulation +20<br>Ship Weaponry: Focus +20');

define ("ENG_TEXT100_0_2", 'Get experience normally.<br><br>Effect: Weapon Bonus Earned<br><br>Object: Every Rank<br>Ship Weaponry: Concussion + 30');

define ("ENG_TEXT100_9_0", 'Get experience from the deathblows inflicted by your Venatic class ships.<br><br>Effect: change formation<br><br>Object: Commodore<br>Class 1: 0%<br>Class 2: 0%<br>Class 3: 100%<br><br>Effect: Raise unit cap<br><br>Object: Commodore<br>Raise unit cap by 40');

define ("ENG_TEXT100_9_1", 'Get experience normally.<br><br>Effetto: Ottieni Bonus Armi<br>Oggetto: Qualunque grado<br><br>Armamento navale: Modulazione +15<br>Armamento navale: Focalizzazione +15<br>Armamento navale: Concussione +20');

define ("ENG_TEXT100_9_2", 'Get experience normally.<br><br>Effetto: Ottieni Bonus Armi<br>Oggetto: Qualunque grado<br><br>Armamento navale: Modulazione +30<br>Armamento navale: Focalizzazione +30<br>Armamento navale: Concussione +40');

define ("ENG_TEXT101_0", 'Get experience normally.<br><br>Effect: Intra-system mouvements requires less time.<br><br>Object: Every Rank<br>Flying time lessened by 1 tick');

define ("ENG_TEXT101_1", 'Get experience normally.<br><br>Effect: Fleet top speed is raised.<br>Can not be higher than Warp 9.95.<br><br>Object: Every Rank<br>Speed Bonus of Warp 2.5');

define ("ENG_TEXT101_2", 'Get experience normally.<br><br>Effect: Hitchance cap for all fleet&#39;ships is raised.<br>Do not affect target evading chances.<br><br>Object: Every Rank<br>Hitchance cap raised to 94&#37;');

define ("ENG_TEXT101_3", 'Get experience normally.<br><br>Effect: Hitchance cap for all fleet&#39;ships is raised.<br>Do not affect target evading chances.<br><br>Object: Every Rank<br>Hitchance cap raised to 100&#37;');

//Italian

define ("ITA_TEXT0", 'Ufficiali Comandanti:');

define("ITA_TEXT1", 'Puoi promuovere questo Ufficiale Comandante fino al rango di Ammiraglio di Flotta per permettergli di controllare un maggior numero di navi.<br>Il livello verr&agrave; adeguato al nuovo rango.<br><br>Considera che i ranghi superiori richiedono maggior esperienza per avanzare di livello.<br><br>ATTENZIONE:<br>Un ufficiale non pu&ograve; essere retrocesso ad un grado precedente.');

define("ITA_TEXT2", 'Promozione');

define("ITA_TEXT3", 'Commodoro');

define("ITA_TEXT4", 'Contrammiraglio');

define("ITA_TEXT5", 'Ammiraglio');

define("ITA_TEXT6", 'Ammiraglio di Flotta');

define("ITA_TEXT7", 'Rango');

define("ITA_TEXT7b", 'Nome');

define("ITA_TEXT7c", 'Livello');

define("ITA_TEXT8", 'Scegliere il nome del nuovo Ufficiale Comandante: ');

define("ITA_TEXT9", 'Arruola');

define("ITA_TEXT10", 'Efficienza al Comando: Il numero complessivo di unit&agrave; che questo ufficiale pu&ograve; comandare efficacemente.<br><br>Se tale limite viene superato, le navi della flotta non ottengono nessun bonus di comando.');

define("ITA_TEXT11", 'E.C.');

define("ITA_TEXT12", 'Composizione ottimale');

define("ITA_TEXT90_0_0", 'Punta della Lancia');

define("ITA_TEXT90_0_1", 'Combattimento Avanzato');

define("ITA_TEXT90_0_2", 'Shock and Awe');

define("ITA_TEXT90_1_0", 'Stormo Predatore');

define("ITA_TEXT90_1_1", 'Implacabile');

define("ITA_TEXT90_1_2", 'Maestro di Scherma');

define("ITA_TEXT90_2_0", 'Stormo Predatore');

define("ITA_TEXT90_2_1", 'ghor Hub');

define("ITA_TEXT90_2_2", 'mup DeSDu&rsquo; tIq');

define("ITA_TEXT90_3_0", 'Formazione Avanzata');

define("ITA_TEXT90_3_1", 'Esperto in Tattica');

define("ITA_TEXT90_3_2", 'Maestro in Tattica');

define("ITA_TEXT90_4_0", 'Schema Gamma Uno');

define("ITA_TEXT90_4_1", 'Tiro Coordianto');

define("ITA_TEXT90_4_2", 'Schema Gamma Tre');

define("ITA_TEXT90_5_0", 'Responsabilit&agrave; maggiori');

define("ITA_TEXT90_5_1", 'Versatile');

define("ITA_TEXT90_5_2", 'Colpo grosso');

define("ITA_TEXT90_8_0", 'Sciame coordinato');

define("ITA_TEXT90_8_1", 'Colpire il lato debole');

define("ITA_TEXT90_8_2", 'Forza nel numero');

define("ITA_TEXT90_9_0", 'Cacciatori Leggendari');

define("ITA_TEXT90_9_1", 'Il meglio tra cento');

define("ITA_TEXT90_9_2", 'Il meglio tra mille');

define("ITA_TEXT90_11_0", 'Branco di lupi');

define("ITA_TEXT90_11_1", 'Mordi e fuggi');

define("ITA_TEXT90_11_2", 'Occhio di falco');

define("ITA_TEXT91_0", 'Specialista alla manovra');

define("ITA_TEXT91_1", 'A tutta forza!!!');

define("ITA_TEXT91_2", 'Schema Theta Uno');

define("ITA_TEXT91_3", 'Schema Theta Due');

define("ITA_TEXT13", 'Ogni rango possiede una propria strategia di combattimento, basata su l&rsquo;utilizzo di differenti categorie di navi in determinate proporzioni.<br>Fornire all&rsquo;ufficiale comandante una flotta composta secondo le sue specifiche ottimali garantisce un notevole vantaggio in combattimento ed una maggiore velocit&agrave; nel raggiungere i livelli alti di esperienza.');

define ("ITA_TEXT100_0_0", 'Ottieni esperienza normalmente.<br><br>Effetto: Modifica Formazione e Cap Unit&agrave;<br><br>Oggetto: Commodoro<br>Aumenta il Cap di 80<br>Classe 1: 50%<br>Classe 2: 30%<br>Classe 3: 20% ');

define ("ITA_TEXT100_0_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +20<br>Armamento navale: Focalizzazione +20');

define ("ITA_TEXT100_0_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Concussione + 30');

define ("ITA_TEXT100_1_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe T&rsquo;Varo.<br><br>Effetto: Modifica Formazione<br><br>Oggetto: Commodoro<br>Imposta Classe 1 a 60%<br>Imposta Classe 2 a 40%<br>Oggetto: Contrammiraglio<br>Imposta Classe 1 a 0<br>Imposta Classe 2 a 70%<br>Imposta Classe 3 a 30%');

define ("ITA_TEXT100_1_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Traiettoria +15<br>Armamento navale: Concussione +15');

define ("ITA_TEXT100_1_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +15<br>Armamento navale: Focalizzazione +15');

define ("ITA_TEXT100_2_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe Bird Of Prey.<br>Effetto: Modifica Formazione<br>Oggetto:Contrammiraglio<br><br>Imposta Classe 1 a 70%<br>Imposta Classe 2 a 30%');

define ("ITA_TEXT100_2_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Traiettoria +20<br>Armamento navale: Concussione +20');

define ("ITA_TEXT100_2_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +20<br>Armamento navale: Focalizzazione +20');

define ("ITA_TEXT100_3_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe Galor.<br><br>Effetto: Modifica Formazione<br><br>Oggetto:Commodoro<br>Classe 1: 0%<br>Classe 2: 85%<br>Classe 3: 15%<br><br>Oggetto:Contrammiraglio<br>Classe 1: 0%<br>Classe 2: 75%<br>Classe 3: 25%<br><br>Oggetto:Ammiraglio<br>Classe 1: 20%<br>Classe 2: 50%<br>Classe 3: 30%<br><br>Oggetto:Ammiraglio di Flotta<br>Classe 1: 20%<br>Classe 2: 45%<br>Classe 3: 35%');

define ("ITA_TEXT100_3_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Modifica Cap Unit&agrave;<br><br>Oggetto: Commodoro<br>Aumenta il Cap Unità di 80<br>Oggetto: Contrammiraglio<br>Aumenta il Cap Unità di 200');

define ("ITA_TEXT100_3_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +25<br>Armamento navale: Traiettoria +25');

define ("ITA_TEXT100_4_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe V-Type.<br><br>Effetto: Modifica Formazione<br><br>Oggetto:Contrammiraglio<br>Classe 1: 0%<br>Classe 2: 70%<br>Classe 3: 30%');

define ("ITA_TEXT100_4_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +30<br>Armamento navale: Focalizzazione +30');

define ("ITA_TEXT100_4_2", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe BSC o Dreadnaught.<br><br>Effetto: Modifica Formazione<br><br>Oggetto:Ammiraglio<br>Classe 1: 0%<br>Classe 2: 60%<br>Classe 3: 40%');

define ("ITA_TEXT100_5_0", 'Ottieni esperienza normalmente.<br><br>Effetto: Modifica Efficienza Comando<br><br>Oggetto: Commodoro<br>Aumenta il Cap Unità di 40<br>Oggetto: Contrammiraglio<br>Aumenta il Cap Unità di 60');

define ("ITA_TEXT100_5_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Modifica Formazione<br><br>Oggetto: Qualunque grado<br>Classe Civile: 5%');

define ("ITA_TEXT100_5_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +20<br>Armamento navale: Traiettoria +20<br>Armamento navale: Concussione +20');

define ("ITA_TEXT100_8_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi Breen di Classe 1.<br><br>Effetto: Modifica Formazione<br><br>Oggetto:Commodoro<br>Classe 1: 100%<br>Classe 2: 0%<br><br>Oggetto:Contrammiraglio<br>Classe 1: 80%<br>Classe 2: 20%<br>Classe 3: 0%');

define ("ITA_TEXT100_8_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Traiettoria +20<br>Armamento navale: Concussione +20');

define ("ITA_TEXT100_8_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Modifica Cap Unit&agrave;<br><br>Oggetto: Commodoro<br>Aumenta il Cap Unità di 120<br><br>Oggetto: Contrammiraglio<br>Aumenta il Cap Unità di 190');

define ("ITA_TEXT100_9_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi classe Venatic.<br><br>Effetto: Modifica Formazione<br><br>Oggetto: Commodoro<br>Classe 1: 0%<br>Classe 2: 0%<br>Classe 3: 100%<br><br>Effetto: Modifica Cap Unit&agrave;<br><br>Oggetto: Commodoro<br>Aumenta il Cap Unità di 40');

define ("ITA_TEXT100_9_1", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br>Oggetto: Qualunque grado<br><br>Armamento navale: Modulazione +15<br>Armamento navale: Focalizzazione +15<br>Armamento navale: Concussione +20');

define ("ITA_TEXT100_9_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br>Oggetto: Qualunque grado<br><br>Armamento navale: Modulazione +30<br>Armamento navale: Focalizzazione +30<br>Armamento navale: Concussione +40');

define ("ITA_TEXT100_11_0", 'Ottieni esperienza dai colpi finali inferti dalle tue navi Classe 1.<br><br>Effetto: Modifica Cap Unit&agrave;<br><br>Oggetto: Commodoro<br>Aumenta il Cap Unità di 80<br>Oggetto: Contrammiraglio<br>Aumenta il Cap Unità di 200');

define ("ITA_TEXT100_11_1", 'Ottieni esperienza dai colpi finali inferti dalle tue navi Classe 2.<br><br>Effetto: Modifica Formazione<br><br>Oggetto: Commodoro<br>Imposta Classe 1 a 70%<br>Imposta Classe 2 a 30%<br>Oggetto: Contrammiraglio<br>Imposta Classe 1 a 60%<br>Imposta Classe 2 a 40%<br>Imposta Classe 3 a 0');

define ("ITA_TEXT100_11_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Ottieni Bonus Armi<br><br>Oggetto: Qualunque grado<br>Armamento navale: Modulazione +20<br>Armamento navale: Traiettoria +15');

define ("ITA_TEXT101_0", 'Ottieni esperienza normalmente.<br><br>Effetto: I movimenti interplanetari richiedono meno tempo.<br><br>Oggetto: Qualunque grado.<br>Tempo di volo ridotto di 1 tick');

define ("ITA_TEXT101_1", 'Ottieni esperienza normalmente.<br><br>Effetto: La velocit&agrave; massima della flotta &egrave; aumentata.<br>Non pu&ograve; superare mai Warp 9.95.<br><br>Oggetto: Qualunque grado.<br>Bonus di Warp 2.5');

define ("ITA_TEXT101_2", 'Ottieni esperienza normalmente.<br><br>Effetto: Il cap alla precisione massima delle navi nella flotta aumenta.<br>Non influisce sulle capacit&agrave; evasive del bersaglio.<br><br>Oggetto: Qualunque grado.<br>Cap aumenta fino al 94&#37;');

define ("ITA_TEXT101_3", 'Ottieni esperienza normalmente.<br><br>Effetto: Il cap alla precisione massima delle navi nella flotta aumenta.<br>Non influisce sulle capacit&agrave; evasive del bersaglio.<br><br>Oggetto: Qualunque grado.<br>Cap aumenta fino al 100&#37;');

define ("ITA_TEXT14", 'Vuoi davvero promuovere questo ufficiale? Tale operazione NON &egrave; reversibile!');

define ("ITA_TEXT15", 'Battaglie Vinte');

define ("ITA_TEXT16", 'Battaglie Perse');

define ("ITA_TEXT17", 'Classe');

define ("ITA_TEXT18", 'Distrutte');

define ("ITA_TEXT19", 'Perse');

define ("ITA_TEXT20", 'Cambia formazione');

?>
