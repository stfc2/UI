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




$BUILDING_NAME = array(
/*
	0	-	Comando
	1	-	Metalli
	2	-	Minerali
	3	-	Dilitio
	4	-	Energia
	5	-	Soldati
	6	-	Spazioporto
	7	-	Cantiere
	8	-	Ricerche
	9	-	Cannone Orbitale
	10	-	Commercio
	11	-	Silos
	12	-	Cannone Orbitale LEGGERO
*/
	// Federazione

	0 => array(

		0 => 'Quartier Generale',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Accademia',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Centro Ricerche',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',

	),



	// Romulani

	1 => array(

		0 => 'Senato',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Caserma',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Centro Ricerche',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',

),





	// Klingon

	2 => array(

		0 => 'Alto Consiglio',

 		1 => 'Miniera di Metalli',

 		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

 		5 => 'Sala dei Guerrieri',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale Imperiale',

		8 => 'Strutture di Ricerca',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Bunker',

		12 => 'Cannone Orb. Leggero',

	),



	// Cardassiani

	3 => array(

		0 => 'Centro Politico',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Caserma',

		6 => 'Spazioporto',

		7 => 'Arsenale Navale',

		8 => 'Centro Ricerca',

		9 => 'Cannone Orbitale',

		10 => 'Commercio Mercantile',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',



	),

	// Dominion

	4 => array(

		0 => 'Tempio dei Fondatorio',

		1 => 'Campo Estrazione Metalli',

		2 => 'Campo Estrazione Minerali',

		3 => 'Impianto di Dilitio',

		4 => 'Collettore di Energia',

		5 => 'Fabbrica dei Cloni',

		6 => 'Base Navale',

		7 => 'Ormeggio Spaziale',

		8 => 'Associazione per lo Sviluppo',

		9 => 'Piattaforma Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Borsa Materiali Grezzi',

		12 => 'Piattaforma Orb. Leggera',



	),



	// Ferengi

	5 => array(

		0 => 'Torre del Commercio',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Accademia',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Centro Ricerche',

		9 => 'Cannone Orbitale',

		10 => 'Camera di Commercio',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',



	),

	// Borg

	6 => array(

	),

	// Q

	7 => array(

	),

	// Breen

	8 => array(

		0 => 'Camera di Raffreddamento',

		1 => 'Estrattore di Metalli',

		2 => 'Estrattore di Minerali',

		3 => 'Estrattore di Dilitio',

		4 => 'Sorgente di Energia',

		5 => 'Caserma Breen',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale Breen',

		8 => 'Centro Ricerche',

		9 => 'Cannone Orbitale',

		10 => 'Centro per il Commercio',

		11 => 'Silo',

		12 => 'Cannone Orb. Leggero',

	),

	// Hirogen

	9 => array(

		0 => 'Sala dei Cacciatori',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Centro di Addestramento',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Centro Ricerche',

		9 => 'Piattaforma Orbitale',

		10 => 'Centro per il Commercio',

		11 => 'Stoccaggio Materie Prime',

		12 => 'Piattaforma Orb. Leggera',

	),

	// Krenim

	10 => array(

		0 => 'Krenim Imperium',

		1 => 'Minatori di Metallo',

		2 => 'Estrattori di Minerali',

		3 => 'Estrattori di Dilitio',

		4 => 'Reattore Nucleare',

		5 => 'Accademia della Guerra',

		6 => 'Porto Orbitale',

		7 => 'Arsenale Militare',

		8 => 'Laboratori',

		9 => 'Stazione Orbitale Pesante',

		10 => 'Borsa Mercantile',

		11 => 'Silos',

		12 => 'Stazione Orbitale', 

	),



	// Kazon

	11 => array(

		0 => 'Tempio di Kazon',

		1 => 'Estrattore di Metalli',

		2 => 'Estrattore di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale a Fusione',

		5 => 'Santuario della Guerra',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Santuario della Dottrina',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Magazzino Risorse',

		12 => 'Cannone Orb. Leggero',

	),



	// Mensch 29th

	12 => array(

		0 => 'Quartier Generale',

		1 => 'Miniera di Metalli',

		2 => 'Miniera di Minerali',

		3 => 'Raffineria di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Accademia',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Ricerca & Sviluppo',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',

	),


	// Siedler

	13 => array(

		0 => 'Quartier Generale',

		1 => 'Miniere di Metallo',

		2 => 'Miniere di Minerali',

		3 => 'Raffinerie di Dilitio',

		4 => 'Centrale Energetica',

		5 => 'Accademia',

		6 => 'Spazioporto',

		7 => 'Cantiere Navale',

		8 => 'Centro Ricerche',

		9 => 'Cannone Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',

	),

);



$UNIT_NAME = array(

	// Föderation

	0 => array(

		0 => 'Fante Leggero',

		1 => 'Fante d&#146;Assalto',

		2 => 'Squadra Speciale',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Romulaner

	1 => array(

		0 => 'Centurione',

		1 => 'Decurione',

		2 => 'Tal Shiar',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Klingonen

	2 => array(

		0 => 'Combattente',

		1 => 'Combattente Esperto',

		2 => 'Combattente Bat&acute;leth',

		3 => 'Generale',

		4 => 'Tecnico',

		5 => 'Guaritore',

	),



	// Cardassianer

	3 => array(

		0 => 'Miliziano',

		1 => 'Miliziano Scelto',

		2 => 'Ordine Ossidiano',

		3 => 'Gul',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Dominion

	4 => array(

		0 => 'Jem&acute;Hadar',

		1 => 'Jem&acute;Hadar Scelto',

		2 => 'Elder',

		3 => 'Vorta',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Ferengi

	5 => array(

		0 => 'Mercenario',

		1 => 'Mercenario Scelto',

		2 => 'Mercenario Esperto',

		3 => 'DaiMon',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Borg

	6 => array(

	),



	// Q

	7 => array(

	),



	// Breen

	8 => array(

		0 => 'Soldato',

		1 => 'BreeMok',

		2 => 'Breen',

		3 => 'OmakBreen',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Hirogen

	9 => array(

		0 => 'Cacciatore',

		1 => 'Beta',

		2 => 'Alfa',

		3 => 'Guida',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Krenim

	10 => array(

		0 => 'Soldato',

		1 => 'Guardia Imperiale',

		2 => 'Fante d&#146;Elite',

		3 => 'Ufficiale',

		4 => 'Ingegnere',

		5 => 'Dottore', 



	),



	// Kazon

	11 => array(
		0 => 'Esecutore',

		1 => 'Assassino',

		2 => 'Templare',

		3 => 'Alto Kazon',

		4 => 'Tecnico',

		5 => 'Medico',

	),

	

	// Menschen 29th

	12 => array(

		0 => 'Fante Leggero',

		1 => 'Fante d&#146;Assalto',

		2 => 'Squadra Speciale',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),


	// Siedler
	13 => array(

		0 => 'Siedler',

		1 => 'Miliziano',

		2 => 'Soldato',

		3 => 'Leader',

		4 => 'Ingegnere',

		5 => 'Dottore',

	),

);



$TECH_NAME = array(



	// Federazione

	0 => array(

		0 => 'Terraforming',	// pro level +1 zu arbeitern/tick; +500 zu max. Bev.

		1 => 'Ricerca Medica', // pro level +2 zu arbeitern

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),





	//Romulan Empire

	1 => array(

		0 => 'Riassetto Climatico',

		1 => 'Schiavismo',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Motivazione Schiavi',

),



	// Klingon Empire

	2 => array(

 		0 => 'Terraforming',

 		1 => 'Ricerca Medica',

 		2 => 'Difesa Orbitale',

		3 => 'Automazione',

 		4 => 'Lavorazione Materiali',

	),



	//Cardassian Union

	3 => array(

		0 => 'Riassetto Climatico',

		1 => 'Schiavismo',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Motivazione Schiavi',

	),



	//Dominion

	4 => array(

		0 => 'Terraforming',

		1 => 'Sviluppo Cloni',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),



	// Ferengi

	5 => array(

		0 => 'Terraforming',

		1 => 'Ricerca Medica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),



	// Borg

	6 => array(

	),



	// Q

	7 => array(

	),



	// Breen

	8 => array(

		0 => 'Adattamento Planetario',

		1 => 'Ricerca Biogenetica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),



	// Hirogen

	9 => array(

		0 => 'Terraforming',

		1 => 'Ricerca Medica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),



	// Krenim

	10 => array(

		0 => 'Adattamento Ecologico',

		1 => 'Ricerca Bioscentifica',

		2 => 'Strutture Difensive Orbitali',

		3 => 'Meccanizzazione',

		4 => 'Robotica Estrattiva', 

	),



	// Kazon

	11 => array(

		0 => 'Terraforming',

		1 => 'Ricerca Medica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),

	

	// Menschen 29th

	12 => array(

		0 => 'Terraforming',

		1 => 'Ricerca Medica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),




	// Siedler

	13 => array(

		0 => 'Terraforming',	// pro level +1 zu arbeitern/tick; +500 zu max. Bev.

		1 => 'Ricerca Medica', // pro level +2 zu arbeitern

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),
);



$UNIT_DESCRIPTION = array (



	// Federazione
	/*
		0	-	Fante Leggero
		1	-	Fante d'Assalto
		2	-	Special Team
		3	-	Comandante
		4	-	Tecnico
		5	-	Medico
	*/
	0 => array(

		0 => 'La Fanteria Leggera &egrave; relativamente economica e facilmente impiegabile ad inizio gioco.<br>In fase avanzata, viene impiegata come equipaggio per la maggior parte dei vascelli, anche se non molto performante.',

		1 => 'La Fanteria d&#146;Assalto rappresenta un pi&ugrave; elevato standard qualitativo rispetto alla Fanteria Leggera.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto alla loro controparte leggera.',

		2 => 'I fanti dello Special Team rappresentano il top della fanteria della Federazione. Sono addestrati unicamente per combattere e non conoscono paura. Nonostante il loro valore difensivo sia relativamente basso',

		3 => 'Il Comandate &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agrave; in battaglia sono paragonabili a quelle della Fanteria Leggera.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

	),
	// Romulani
	/*
		0	-	Centurione
		1	-	Decurione
		2	-	Tal Shiar
		3	-	Comandante
		4	-	Tecnico
		5	-	Medico
	*/
	1 => array(

		0 => 'I Centurioni sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Decurioni rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Centurioni.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Centurioni.',

		2 => 'I Tal Shiar sono agenti segreti, addestrati per essere precisi ed efficaci assassini.<br>Nonostante la loro capacit&agrave; difensiva sia relativamente debole, le truppe ostili farebbero bene a rimanere fuori dal loro settore operativo.',

		3 => 'Il Comandate &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Centurioni.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

	),
	// Klingon
	/*
		0	-	Combattente
		1	-	Combattente Esperto
		2	-	BetleH
		3	-	Generale
		4	-	Tecnico
		5	-	Guaritore	
	*/
	2 => array(

		0 => 'I Combattenti sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Combattenti Esperti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Combattenti.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Combattenti.',

		2 => 'I BetleH vivono con l&#146;unico scopo di morire in modo onorevole sul campo di battaglia.<br>Si gettano in ogni battaglia senza trattenersi, sapendo che non vi &egrave; onore pi&ugrave; grande di quello di morire per la gloria del proprio regno.',

		3 => 'Il Generale &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Combattenti.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il guaritore non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari, anche se, generalmente, i Klingon sconfitti preferiscono morire piuttosto che farsi curare.',

	),
	// Cardassiani
	/*
		0	-	Miliziano
		1	-	Miliziano Scelto
		2	-	Ordine Ossidiano
		3	-	Gul
		4	-	Tecnico
		5	-	Medico
	*/
	3 => array(

		0 => 'I Miliziani sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Miliziani Scelti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Miliziani.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Miliziani.',

		2 => 'I Commandos dell&#146;Ordine Ossidiano sono esperti di combattimento in grado di sopravvivere a qualsiasi scontro. Sono addestrati unicamente alla battaglia e non conoscono la paura. Anche se le loro capacit&agrave; difensive sono relativamente deboli, gli avversari farebbero bene a tenersi lontani dal loro mirino.',

		3 => 'Il Gul &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Miliziani.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

	),
	// Dominion
	/*
		0	-	Jem'Hadar
		1	-	Jem'Hadar Scelto
		2	-	Elder
		3	-	Vorta
		4	-	Tecnico
		5	-	Medico
	*/
	4 => array(

		0 => 'I Jem&#146;Hadar sono facilmente clonabili e assolvono efficacemente alla difesa del pianeta.<br>In fase di gioco avanzata essi dimostrano tuttavia parecchi limiti, anche se trovano posto come equipaggio sulla maggior parte delle navi.',

		1 => 'I Jem&#146;Hadar Scelti sono cloni pi&ugrave; costosi rispetto ai sempliciJem&#146;Hadar e si dimostrano migliori sul campo di battaglia e sulle navi stellari.',

		2 => 'Il corpo degli Elders rappresenta quei Jem&#146;Hadar che hanno raggiunto una ragguardevole esperienza sul campo di battaglia.<br>Essi rappresentano la migliore scelta possibile sia per l&#146;attacco che per la difesa.',

		3 => 'Per le loro qualit&agrave; di comando, i Vorta svolgono ottimamente la funzione di comandanti delle navi stellari. Tuttavia, sul campo di battaglia, il loro rendimento &egrave; piuttosto basso, paragonabile a quello di un Jem&#146;Hadar semplice.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

	),
	// Ferengi
	/*
		0	-	Mercenario
		1	-	Mercenario Scelto
		2	-	Mercenario Esperto
		3	-	DaiMon
		4	-	Tecnico
		5	-	Medico
	*/
	5 => array(

		0 => 'I Mercenari sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Mercenari Scelti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Mercenari.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro reclutamento risulta pi&ugrave; costoso rispetto a quello dei Mercenari.',

		2 => 'Dato che gli interessi Ferengi sono indirizzati al profitto e non alla guerra, il ruolo di truppe di punta viene affidato alle migliori truppe mercenarie assoldabili sul mercato.',

		3 => 'Il DaiMon &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Mercenari.',

		4 => 'Il tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

	),
	// Borg
	/*
	*/
	6 => array(

	),
	// Q
	/*
	*/
	7 => array(

	),
	// Breen
	/*
		0	-	Soldato
		1	-	BreeMok
		2	-	Breen
		3	-	OmakBreen
		4	-	Tecnico
		5	-	Medico
	*/
	8 => array(

		0 => 'I Soldati sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I BreeMok rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Soldati.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro reclutamento risulta pi&ugrave; costoso rispetto a quello dei Soldati.',

		2 => 'Il Breen &egrave; per i suoi avversari un nemico letale, in quanto egli pu&ograve; modificare la sua forma fisica per qualche minuto.',

		3 => 'L&#146;OmakBreen una innata capacit&agrave; per il comando di una nave stellare, inoltre viene addestrato al combattimento come un Soldato. Viene impiegato principalmente per la guida delle nostre bio-astronavi.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle bio-astronavi piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

	),



	// Hirogen
	/*
		0	-	Cacciatore
		1	-	Beta
		2	-	Alfa
		3	-	Guida
		4	-	Tecnico
		5	-	Medico
	*/
	9 => array(

		0 => 'I Cacciatori sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'Il Beta &egrave; particolarmente efficace nel combattimento a distanza e, anche grazie alla sua robusta difesa, pu&ògrave; essere virtualmente impiegato in qualsiasi ruolo, anche se il suo addestramento, paragonato a quello dei Cacciatori, risulta particolarmente dispendioso.',

		2 => 'Gli Alfa sono combattenti esperti e guide infallibili, in grado di sopravvivere in qualsiasi situazione. Sono dei cacciatori veterani e non conoscono paura. Ogni preda viene inseguita fino alla morte.',

		3 => 'Le Guide non vengono addestrate al combattimento ma al comando delle navi stellari. Il loro addestramento &egrave; dispendioso ma sono figure necessarie per ogni vascello.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle navi stellari piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

	),



	// Krenim
	/*
		0	-	Soldato
		1	-	Guardia Imperiale
		2	-	Elite
		3	-	Ufficiale
		4	-	Ingegnere
		5	-	Dottore
	*/
	10 => array(

		0 => 'I Soldati sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'Die Imperialen Gardisten werden lange und sorgfältig für ihre Aufgaben trainiert und verfügt über ausgezeichnete Bewaffnung und Ausbildung. Allerdings ist ihre Ausbildung ein gutes Stück teurer als die von einfachen Kämpfern.',

		2 => 'Die Eliteinfanteristen sind besonders hart trainierte Kämpfer des Imperiums, die sich voll und ganz ihrem Dienst widmen. Sie sind teuer in der Ausbildung, aber auch entsprechend stark.',

		3 => 'Offiziere dienen als Kommandeure von Kampftrupps und Kriegsschiffen des Krenim-Imperiums. Ihre Kampfausbildung ist nicht so intensiv wie die anderer Kämpfer, dafür werden sie aber in Strategie und Taktik geschult.',

		4 => 'Ingenieure werden benötigt, um Schiffe instand zu halten und die komplexe Technik der Krenimschiffe zu bedienen. Sie werden speziell für ihre Aufgabe ausgebildet und nehmen nicht direkt an Kampfhandlungen teil.',

		5 => 'Ärzte sind für das Wohlergehen und die Einsatzbereitschaft der Schiffsbesatzung zuständig. Ebenso wenig wie Ingenieure beteiligen sich Ärzte an Kampfhandlungen, sie kümmern sich lediglich um die Verwundeten.', 

	),



	// Kazon
	/*
		0	-	Esecutore
		1	-	Assassino
		2	-	Templare
		3	-	Alto Kazon
		4	-	Tecnico
		5	-	Medico
	*/

	11 => array(

		0 => 'Gli Esecutori sono relativamente economici e facilmente accessibili ad inizio gioco.<br>per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'Gli Assassini sono particolarmente efficaci nel combattimento a corto raggio; data la loro alta capacit&agrave; difensiva possono essere impiegati in qualsiasi situazione. Il loro addestramento risulta pi&ugrave; costoso di quello degli Esecutori.',

		2 => 'I Templari sono esperti in combattimento in grado di sopravvivere ad ogni situazione e non conoscono paura. Anche se la loro difesa &egrave; relativamente debole, gli avversari farebbero bene a stare alla larga dalla loro zona di operazioni.',

		3 => 'Gli Alti Kazon non vengono addestrati al combattimento ma al comando delle navi stellari. Il loro addestramento &egrave; dispendioso ma sono figure necessarie per ogni vascello. In combattimento la loro efficacia &grave; paragonabile a quella degli Esecutori.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle navi stellari piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

	),

	

	// Menschen 29th

	12 => array(

		0 => 'Leichte Infanterie',

		1 => 'Sturmtruppen',

		2 => 'Hazard Teams',

		3 => 'Commander',

		4 => 'Techniker',

		5 => 'Mediziner',

	),	

	// Siedler

	13 => array(

	),


);



$BUILDING_DESCRIPTION = array (

	// Federazione
	0 => array(

		0 => 'Con l&#180;alzarsi del livello di questa costruzione<br>si accede ad un numero maggiore di strutture realizzabili.',

		1 => 'Potenziare questa struttura permette,<br>di estrarre una maggiore quantit&agrave; di metalli per tick.',

		2 => 'Potenziare questa struttura permette,<br>di estrarre una maggiore quantit&agrave; di minerali per tick.',

		3 => 'Potenziare questa struttura permette,<br>di estrarre una maggiore quantit&agrave; di dilitio per tick.',

		4 => 'Ogni livello di questa struttura,<br>fornisce energia ad altre 10 costruzioni.',

		5 => 'A seconda del livello di questa struttura,<br>i tuoi lavoratori vengono convertiti in una maggiore variet&agrave; di truppe.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Potenziare questa struttura permette di ridurre il tempo di costruzione delle navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura ti permette di stringere accordi commerciali con altri giocatori.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta  di 50000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassare i loro costi',

	),



	// Romulaner

	1 => array(

		0 => 'Questa struttura &egrave; il nucleo di ogni pianeta dell&#146;impero: maggiore il suo livello, maggiore il numero di strutture realizzabili.',

		1 => 'In questa struttura lavorano gli schiavi remani. Sviluppare questa struttura permette di estrarre maggiori quantit&agrave; di metalli per il pianeta.',

		2 => 'In questa struttura lavorano gli schiavi remani. Sviluppare questa struttura permette di estrarre maggiori quantit&agrave; di minerali per il pianeta.',

		3 => 'In questa struttura lavorano gli schiavi remani. Sviluppare questa struttura permette di estrarre maggiori quantit&agrave; di dilitio per il pianeta.',

		4 => 'Le centrali romulane producono energia per 10 livelli di strutture sul pianeta per livello. Sono fondamentali per la crescita dell&#146;Impero.',

		5 => 'Nella caserma i remani vengono addestrati come Centurioni o Decurioni. I romulani invece vengono addestrati come Tal Shiar, oppure specializzati per l&#146;impiego sulle navi stellari.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Una pietra miliare nella storia dell&#146;Impero, questa struttura permette di costruire navi stellari per le flotte del Pretore. Maggiore il livello della struttura, maggiore la velocit&agrave; di costruzione delle navi.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura ti permette di stringere accordi commerciali con altri giocatori.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta di 50000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Klingonen

	2 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'A seconda del livello di questa struttura, i lavoratori vengono addestrati in diversi tipi di unit&agrave;.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Maggiore il livello di questa struttura, maggiore la velocit&agrave; con cui vengono costruite le navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura permette gli scambi commerciali tra pianeti. A seconda del livello, &eacute possibile raggiungere pianeti molto distanti.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta di 45000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Cardassianer

	3 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'A seconda del livello di questa struttura, i lavoratori vengono addestrati in diversi tipi di unit&agrave;.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Maggiore il livello di questa struttura, maggiore la velocit&agrave; con cui vengono costruite le navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura permette gli scambi commerciali tra pianeti. A seconda del livello, &eacute possibile raggiungere pianeti molto distanti.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta di 50000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Dominion

	4 => array(

		0 => 'Je weiter der Gründertempel ausgebaut ist, umso mehr Gebäudepläne geben die Gründer frei.',

		1 => 'Je größer das Metallabbaulager ist, um so mehr Sklaven können darin arbeiten und mehr Metall steht pro Tick zur Verfügung.',

		2 => 'Je größer das Mineralienabbaulager ist, umso mehr Sklaven können darin arbeiten und mehr Mineralien steht pro Tick zur Verfügung.',

		3 => 'Je größer das Latinumwerk ist, umso mehr Barren Latinum werden Sklaven pro Tick gießen.',

		4 => 'Pro Energiekollektor können 10 Gebäude mit Energie versorgt werden.',

		5 => 'Je höher die Klonfabrik ausgebaut ist, umso komplexere Genome können reproduziert werden.',

		6 => 'Das Raumdock dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet eine Verbesserung der Sensorenstärke.',

		7 => 'Je höher das Gebäude ausgebaut ist,<br>desto schneller können Schiffe gebaut werden.',

		8 => 'Je effektiver die Erkenntnisvereinigung ist, umso mehr Technologien werden erkannt.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Dieses Gebäude dient zur automatischen Handelsabwicklung mit anderen Spielern.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 42.500 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Ferengi

	5 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'Je nach Liv. der Akademie können Arbeiter zu verschiedenen Einheiten-typen ausgebildet werden.',

		6 => 'Der Raumhafen dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet eine Verbesserung der Sensorenstärke.',

		7 => 'Je höher das Gebäude ausgebaut ist,<br>desto schneller können Schiffe gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Diese Einrichtung ermöglicht es, mit anderen Spielern Geschäftsbeziehungen zu schließen, die automatisiert abgewickelt werden.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 35.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Borg

	6 => array(

	),



	// Q

	7 => array(

	),



	// Breen

	8 => array(

		0 => 'Je höher die Kältekammer entwickelt ist, desto höher entwickelte Gebäude können erzeugt werden.',

		1 => 'Je höher der Metallextraktor entwickelt ist, desto mehr Metall wird pro Tick abgebaut.',

		2 => 'Je höher der Mineralienextraktor entwickelt ist,desto mehr Mineralien werden pro Tick abgebaut.',

		3 => 'Je höher der Latinumextraktor entwickelt ist, desto mehr Latinum kann pro Tick produziert werden.',

		4 => 'Alle 10 Einrichtungsorganismen muss eine neue Kraftquelle erzeugt werden, um diese mit Energie zu versorgen.',

		5 => 'Je besser die Breen Kaserne entwickelt ist, desto bessere Kämpfer können Ausgebildet werden.',

		6 => 'Der Raumhafen dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet eine Verbesserung der Sensorenstärke.',

		7 => 'Je höher die Breenwerft entwickelt ist,<br>desto schneller können Schiffe gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Diese Einrichtung ermöglicht es, mit anderen Spielern Geschäftsbeziehungen zu schließen, die automatisiert abgewickelt werden.',

		11 => 'Der Bio-Lagerkern dient dazu, je nach entwicklungsstufe, die Anzahl der maximal lagerbaren Ressourcen zu erhöhen. Zusätzlich Lagerbar pro Tick und Entwicklungsstufe: 50.000.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Hirogen

	9 => array(

		0 => 'Je höher das Gebäude ausgebaut ist, desto mehr neue Gebäude können gebaut werden.',

		1 => 'Je höher das Gebäude ausgebaut ist, desto mehr Metall wird pro Tick abgebaut.',

		2 => 'Je höher das Gebäude ausgebaut ist, desto mehr Mineralien werden pro Tick abgebaut.',

		3 => 'Je höher das Gebäude ausgebaut ist, desto mehr Latinum kann pro Tick produziert werden.',

		4 => 'Man muss ein Kraftwerk pro 10 Gebäude bauen, damit diese noch mit ausreichend Energie versorgt werden.',

		5 => 'Je nach Liv. des Trainingscenter können Arbeiter zu verschiedenen Einheiten-typen ausgebildet werden.',

		6 => 'Der Raumhafen dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet eine Verbesserung der Sensorenstärke.',

		7 => 'Je höher das Gebäude ausgebaut ist,<br>desto schneller können Schiffe gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Diese Einrichtung ermöglicht es, mit anderen Spielern Geschäftsbeziehungen zu schließen, die automatisiert abgewickelt werden.',

		11 => 'Das Commodity stock dient dazu, die maximal lagerbaren Ressourcen zu erhöhen. Zusätzlich lagerbare Ressourcen pro Liv. pro Typ: 50.000',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Krenim

	10 => array(

		 0 => 'Je weiter das Imperiale Hauptquartier der Kolonie ausgebaut ist, desto mehr und unterschiedliche Gebäude können gebaut werden.',

		1 => 'Je höher die Metal Miner ausgebaut ist, desto mehr Metall wird pro Tick gefördert.',

		2 => 'Je höher die Mineral Extraction ausgebaut ist, desto mehr Mineral wird pro Tick gefördert.',

		3 => 'Je höher die Latinumraffination ausgebaut ist, desto mehr Latinum wird pro Tick gefördert.',

		4 => 'Um eine wachsende Kolonie zu versorgen, müssen Nuclear Reactore gebaut werden. Jeder Nuclear Reactor kann zehn zusätzliche Gebäude versorgen.',

		5 => 'Die War Academy dient der Ausbildung von Kämpfern und Spezialisten. Je höher die War Academy ausgebaut ist, desto bessere Einheiten können ausgebildet werden.',

		6 => 'Der Orbital Harbour dient der Beherbergung und Reparatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet eine Verbesserung der Sensorenstärke.',

		7 => 'Die War Shipyard dient dem Bau neuer Schiffe. Je höher die Werft ausgebaut ist, desto schneller können Schiffe fertiggestellt werden.',

		8 => 'Das Laboratory dient der Erforschung neuer Technologien. Je höher das Laboratory ausgebaut ist, desto mehr neue Technologien können entwickelt werden.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Die Handelsbörse ermöglicht die Teilnahme am galaktischen Handel mit anderen Spielern und Allianzen.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 50.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.', 

	),



	// Kazon

	11 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'Dal livello del Santuario della Guerra dipende il livello delle unit&agrave; che possono essere addestrate.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Maggiore il livello di questa struttura, maggiore la velocit&agrave; con cui vengono costruite le navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura ti permette di stringere accordi commerciali con altri giocatori.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 45.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Menschen 29th

	12 => array(

		0 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr neue Gebäude können gebaut werden.',

		1 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Metall wird pro Tick abgebaut.',

		2 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Mineralien werden pro Tick abgebaut.',

		3 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Latinum kann pro Tick produziert werden.',

		4 => 'Man muss ein Kraftwerk pro 10 Gebäude bauen,<br>damit diese noch mit ausreichend Energie versorgt werden.',

		5 => 'Je nach Liv. der Akademie können Arbeiter zu veschiedenen Einheiten-<br>typen ausgebildet werden.',

		6 => 'Der Raumhafen dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet +200 Sensorenstärke.',

		7 => 'Je höher das Gebäude ausgebaut ist,<br>desto schneller können Schiffe gebaut werden.<br>Pro 50 Punkte des Planeten kann der jeweils nächsthöhere Rumpftyp gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Diese Einrichtung ermöglicht es, mit anderen Spielern Geschäftsbeziehungen zu schließen, die automatisiert abgewickelt werden.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 10.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Siedler
	13 => array(

		0 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr neue Gebäude können gebaut werden.',

		1 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Metall wird pro Tick abgebaut.',

		2 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Mineralien werden pro Tick abgebaut.',

		3 => 'Je höher das Gebäude ausgebaut ist,<br>desto mehr Latinum kann pro Tick produziert werden.',

		4 => 'Man muss ein Kraftwerk pro 10 Gebäude bauen,<br>damit diese noch mit ausreichend Energie versorgt werden.',

		5 => 'Je nach Liv. der Akademie können Arbeiter zu veschiedenen Einheiten-<br>typen ausgebildet werden.',

		6 => 'Der Raumhafen dient der Reperatur beschädigter Schiffe. Durch jede Ausbaustufe erhält der Planet +200 Sensorenstärke.',

		7 => 'Je höher das Gebäude ausgebaut ist,<br>desto schneller können Schiffe gebaut werden.<br>Pro 50 Punkte des Planeten kann der jeweils nächsthöhere Rumpftyp gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Diese Einrichtung ermöglicht es, mit anderen Spielern Geschäftsbeziehungen zu schließen, die automatisiert abgewickelt werden.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 10.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),


);





$TECH_DESCRIPTION = array (

	// Federazione
	/*
		0	-	Terraforming
		1	-	Ricerca Medica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/
	0 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 550 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',
	),



	// Romulani
	/*
		0	-	Riassetto Climatico
		1	-	Schiavismo
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Motivazione Schiavi
	*/

	1 => array(

		0 => 'Grazie al <b>Riassetto Climatico</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello sviluppato. Inoltre, per ogni livello, viene innalzato il limite di popolazione del pianeta di circa 500 unit&agrave;.',

		1 => 'Studiando l&#146;attitudine di ogni schiavo alle mansioni da svolgere &egrave; possibile abbassarne la mortalit&agrave; ed incrementare il numero di schiavi impiegabili. Ad ogni livello di <b>Schiavismo</b> corrisponde un beneficio di uno schiavo extra ogni 5 cicli di tick.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Motivazione degli Schiavi</b> addetti al funzionamento delle strutture estrattive, aumentano la quantit&agrave; di risorse ottenute dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),



	// Klingon
	/*
		0	-	Terraforming
		1	-	Ricerca Medica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/

	2 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 450 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;</b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),



	// Cardassiani
	/*
		0	-	Riassetto Climatico
		1	-	Schiavismo
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Motivazione Schiavi
	*/

	3 => array(

		0 => 'Grazie al <b>Riassetto Climatico</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello sviluppato. Inoltre, per ogni livello, viene innalzato il limite di popolazione del pianeta di circa 500 unit&agrave;.',

		1 => 'Studiando l&#146;attitudine di ogni schiavo alle mansioni da svolgere &egrave; possibile abbassarne la mortalit&agrave; ed incrementare il numero di schiavi impiegabili. Ad ogni livello di <b>Schiavismo</b> corrisponde un beneficio di uno schiavo extra ogni 5 cicli di tick.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Motivazione degli Schiavi</b> addetti al funzionamento delle strutture estrattive, aumentano la quantit&agrave; di risorse ottenute dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

		),

	//Dominion
	/*
		0	-	Terraforming
		1	-	Sviluppo Cloni
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/

	4 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 425 unit&agrave;.',

			1 => 'Grazie agli studi sullo <b>Sviluppo dei Cloni</b> &egrave; possibile ottenere un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

			2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

			3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

			4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),



	// Ferengi
	/*
		0	-	Terraforming
		1	-	Ricerca Medica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/

	5 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 350 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',
	),



	// Borg

	6 => array(

	),



	// Q

	7 => array(

	),



	// Breen
	/*
		0	-	Adattamento Planetario
		1	-	Ricerca Biogenetica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/

	8 => array(

		0 => 'Per mezzo dell&#146;<b>Adattamento Planetario</b>, si ottiene un lavoratore extra ogni 10 cicli di tick. Inoltre, si ottiene un innalzamento del limite di popolazione sul pianeta di 500 unit&agrave; per livello.',

		1 => 'Attraverso le <b>Ricerche Biogenetiche</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),



	// Hirogen
	/*
		0	-	Terraforming
		1	-	Ricerca Medica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/


	9 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 550 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),



	// Krenim

	10 => array(

		 0 => 'Durch ökologische Anpassung eines Planeten bekommt man pro 10 Ticks einen zusätzlichen Arbeiter, außerdem vergrößert es den Wohnraum der Bevölkerung um 575.',

		1 => 'Die biochemische Forschung verbessert die Gesundheit der Bevölkerung und führt zu einem höheren Bevölkerungswachstum: In jedem 5. Tick gibt es einen zusätzlichen Arbeiter.',

		2 => 'Durch das Erforschen von orbitalen Defensivmaßnahmen verändern sich die Kosten und die maximale Anzahl an orbitalen Large Orbital Battlestationen wie folgt: Kosten -3,5% / Liv., Anzahl +2 / Liv.',

		3 => 'Durch Mechanisierung laufen sämtliche Entwicklungs- und Produktionsvorgänge um 2% pro Liv. schneller ab. Eine Einsparung von fast 1/5 der Entwicklungszeiten auf dem Planeten rechtfertigt den hohen Forschungspreis.',

		4 => 'Bergbaurobotik erhöht den Rohstoffoutput aller Minen auf dem Planeten wie folgt:<br>Liv. 1: +4,5%<br>Liv. 2: 8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%', 

	),



	// Kazon
	/*
		0	-	Terraforming
		1	-	Ricerca Medica
		2	-	Difesa Orbitale
		3	-	Automazione
		4	-	Lavorazione Materiali
	*/

	11 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 450 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),

	

	

	// Menschen 29th

	12 => array(

		0 => 'Terraforming',

		1 => 'Medizinische Forschung',

		2 => 'Orbitalabwehr',

		3 => 'Automatisierung',

		4 => 'Rohstoffverarbeitung'

	),


	// Siedler

	13 => array(

		0 => 'Durch Terraforming bekommen Sie pro 10 Ticks und Liv. einen zusätzlichen Arbeiter.<br>Außerdem erhöht sich das max. Bevölkerungslimit auf dem Planeten pro Liv. um 500.',

		1 => 'Durch medizinische Forschung bekommen Sie pro 5 Ticks und Liv. einen zusätzlichen Arbeiter.',

		2 => 'Durch das Erforschen der Orbitalabwehr verändern sich die Kosten / max. Anzahl der Verteidigungsplattformen pro Liv. wie folgt:<br>Kosten -3.5% / Liv.<br>Anzahl: +2 / Liv.',

		3 => 'Durch Automatisierung laufen <b>sämtliche</b> Bau- Ausbildungsvorgänge auf Ihrem Planeten 2% pro Liv. schneller ab.<br>Eine Einsparung von fast 1/5 der Bau- und Ausbildungszeiten auf dem jeweiligen Planeten rechtfertigen den hohen Forschungspreis.',

		4 => 'Rohstoffverarbeitung erhöht den Ressourcenoutput sämtlicher Minen/Raffinerien:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),

);



?>
