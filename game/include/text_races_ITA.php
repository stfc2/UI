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

		0 => 'Tempio dei Fondatori',

		1 => 'Campo Estrazione Metalli',

		2 => 'Campo Estrazione Minerali',

		3 => 'Impianto di Dilitio',

		4 => 'Collettore di Energia',

		5 => 'Fabbrica dei Cloni',

		6 => 'Base Navale',

		7 => 'Darsena Spaziale',

		8 => 'Centro di Sviluppo',

		9 => 'Piattaforma Orbitale',

		10 => 'Centro Commerciale',

		11 => 'Deposito Risorse',

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

		11 => 'Silos',

		12 => 'Cannone Orb. Leggero',

	),

	// Hirogeni

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



	// Umani 29o

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


	// Coloni

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

	// Federazione

	0 => array(

		0 => 'Fante Leggero',

		1 => 'Fante d&#146;Assalto',

		2 => 'Squadra Speciale',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Romulani

	1 => array(

		0 => 'Centurione',

		1 => 'Decurione',

		2 => 'Tal Shiar',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Klingon

	2 => array(

		0 => 'Combattente',

		1 => 'Combattente Esperto',

		2 => 'Combattente Bat&acute;leth',

		3 => 'Generale',

		4 => 'Tecnico',

		5 => 'Guaritore',

	),



	// Cardassiani

	3 => array(

		0 => 'Miliziano',

		1 => 'Miliziano Scelto',

		2 => 'Ordine Ossidiano',

		3 => 'Gul',

		4 => 'Tecnico',

		5 => 'Medico',

	),



	// Dominio

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

		0 => 'Drone',

		1 => 'Drone d&#146;Assalto',

		2 => 'Drone d&#146;Elite',

		3 => 'Drone comandante',

		4 => 'Drone tecnico',

		5 => 'Drone medico',

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

		4 => 'Riparatore',

		5 => 'Medico',

	),



	// Hirogeni

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

		2 => 'Elite',

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

	

	// Umani 29o

	12 => array(

		0 => 'Fante Leggero',

		1 => 'Fante d&#146;Assalto',

		2 => 'Squadra Speciale',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),


	// Coloni
	13 => array(

		0 => 'Colono',

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

		0 => 'Terraforming',	// 1 per level to employees / tick; +500 max. Pop

		1 => 'Ricerca Medica', // +2 per level to employees

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),





	// Romulan Empire

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

		1 => 'Ricerca Bioscientifica',

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

	

	// Umani 29o

	12 => array(

		0 => 'Terraforming',

		1 => 'Ricerca Medica',

		2 => 'Difesa Orbitale',

		3 => 'Automazione',

		4 => 'Lavorazione Materiali',

	),




	// Coloni

	13 => array(

		0 => 'Terraforming',	// 1 per level to employees / tick; +500 max. Pop

		1 => 'Ricerca Medica', // +2 per level to employees

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

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

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

		0 => 'I Centurioni sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Decurioni rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Centurioni.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Centurioni.',

		2 => 'I Tal Shiar sono agenti segreti, addestrati per essere precisi ed efficaci assassini.<br>Nonostante la loro capacit&agrave; difensiva sia relativamente debole, le truppe ostili farebbero bene a rimanere fuori dal loro settore operativo.',

		3 => 'Il Comandate &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Centurioni.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

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

		0 => 'I Combattenti sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Combattenti Esperti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Combattenti.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Combattenti.',

		2 => 'I BetleH vivono con l&#146;unico scopo di morire in modo onorevole sul campo di battaglia.<br>Si gettano in ogni battaglia senza trattenersi, sapendo che non vi &egrave; onore pi&ugrave; grande di quello di morire per la gloria del proprio regno.',

		3 => 'Il Generale &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Combattenti.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Guaritore non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari, anche se, generalmente, i Klingon sconfitti preferiscono morire piuttosto che farsi curare.',

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

		0 => 'I Miliziani sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Miliziani Scelti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Miliziani.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro addestramento risulta pi&ugrave; costoso rispetto a quello dei Miliziani.',

		2 => 'I Commandos dell&#146;Ordine Ossidiano sono esperti di combattimento in grado di sopravvivere a qualsiasi scontro. Sono addestrati unicamente alla battaglia e non conoscono la paura. Anche se le loro capacit&agrave; difensive sono relativamente deboli, gli avversari farebbero bene a tenersi lontani dal loro mirino.',

		3 => 'Il Gul &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Miliziani.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

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

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

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

		0 => 'I Mercenari sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I Mercenari Scelti rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Mercenari.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro reclutamento risulta pi&ugrave; costoso rispetto a quello dei Mercenari.',

		2 => 'Dato che gli interessi Ferengi sono indirizzati al profitto e non alla guerra, il ruolo di truppe di punta viene affidato alle migliori truppe mercenarie assoldabili sul mercato.',

		3 => 'Il DaiMon &egrave; addestrato per il governo delle navi stellari.<br>Sono costosi come addestramento, ma necessari su ogni nave.<br>Le loro capacit&agave; in battaglia sono paragonabili a quelle dei Mercenari.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere compiti di manutenzione sulle navi stellari.<br>Il loro addestramento &egrave; molto costoso, ma sono richiesti sulla maggior parte delle navi stellari.',

		5 => 'Il Medico non &egrave; addestrato al combattimento ma solo per fornire assistenza medica sulle navi stellari.',

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
		4	-	Riparatore
		5	-	Medico
	*/
	8 => array(

		0 => 'I Soldati sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I BreeMok rappresentano un pi&ugrave; elevato standard qualitativo rispetto ai Soldati.<br>Possono essere impiegati per qualsiasi scopo, anche se il loro reclutamento risulta pi&ugrave; costoso rispetto a quello dei Soldati.',

		2 => 'Il Breen &egrave; per i suoi avversari un nemico letale, in quanto egli pu&ograve; modificare la sua forma fisica per qualche minuto.',

		3 => 'L&#146;OmakBreen una innata capacit&agrave; per il comando di una nave stellare, inoltre viene addestrato al combattimento come un Soldato. Viene impiegato principalmente per la guida delle nostre bio-astronavi.',

		4 => 'Il Riparatore &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle bio-astronavi piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il Medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

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

		0 => 'I Cacciatori sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'Il Beta &egrave; particolarmente efficace nel combattimento a distanza e, anche grazie alla sua robusta difesa, pu&ògrave; essere virtualmente impiegato in qualsiasi ruolo, anche se il suo addestramento, paragonato a quello dei Cacciatori, risulta particolarmente dispendioso.',

		2 => 'Gli Alfa sono combattenti esperti e guide infallibili, in grado di sopravvivere in qualsiasi situazione. Sono dei cacciatori veterani e non conoscono paura. Ogni preda viene inseguita fino alla morte.',

		3 => 'Le Guide non vengono addestrate al combattimento ma al comando delle navi stellari. Il loro addestramento &egrave; dispendioso ma sono figure necessarie per ogni vascello.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle navi stellari piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il Medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

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

		0 => 'I Soldati sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'I membri della Guardia Imperiale saranno addestrati lungamente e con attenzione alle loro mansioni ed all&#146;uso eccellente delle armi. Tuttavia, la loro formazione &egrave; un po&#146; pi&ugrave; costosa rispetto ai combattenti semplici.',

		2 => 'I corpi d&#146;&Eacute;lite sono speciali combattenti dell&#146;impero addestrati duramente, che si dedicano pienamente al loro servizio. Essi sono costosi in materia di formazione, ma anche forti di conseguenza.',

		3 => 'Gli ufficiali servono da comandanti delle truppe da combattimento e delle navi da guerra dell&#146;Impero Krenim.<br>La loro formazione non &egrave; principalmente orientata allo scontro fisico quanto gli altri combattenti, ma nelle strategie e nelle tattiche militari.',

		4 => 'Gli Ingegneri sono necessari per manutenere e far funzionare la complessa tecnologia delle navi Krenim. Sono formati specialmente per le loro competenze e non prendono parte diretta nelle ostilit&agrave;.',

		5 => 'I Dottori sono responsabili del benessere e della prontezza dell&#146;equipaggio. Come per gli Ingegneri non partecipano ai combattimenti, si prendono cura dei feriti.', 

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

		0 => 'Gli Esecutori sono relativamente economici e facilmente accessibili ad inizio gioco per la difesa del pianeta.<br>In fase avanzata &egrave; possibile impiegarli come equipaggio per le navi stellari.',

		1 => 'Gli Assassini sono particolarmente efficaci nel combattimento a corto raggio; data la loro alta capacit&agrave; difensiva possono essere impiegati in qualsiasi situazione. Il loro addestramento risulta pi&ugrave; costoso di quello degli Esecutori.',

		2 => 'I Templari sono esperti in combattimento in grado di sopravvivere ad ogni situazione e non conoscono paura. Anche se la loro difesa &egrave; relativamente debole, gli avversari farebbero bene a stare alla larga dalla loro zona di operazioni.',

		3 => 'Gli Alti Kazon non vengono addestrati al combattimento ma al comando delle navi stellari. Il loro addestramento &egrave; dispendioso ma sono figure necessarie per ogni vascello. In combattimento la loro efficacia &grave; paragonabile a quella degli Esecutori.',

		4 => 'Il Tecnico &egrave; addestrato per svolgere operazioni di manutenzione a bordo delle navi stellari piuttosto che a portare a termine missioni di combattimento. &Eacute; praticamente indispensabile tra i membri dell&#146;equipaggio.',

		5 => 'Il Medico non viene addestrato per svolgere missioni di guerra ma per fornire supporto medico sulle navi stellari.',

	),

	

	// Umani 29p

	12 => array(

		0 => 'Fanteria leggera',

		1 => 'Sturmtruppen',

		2 => 'Hazard Teams',

		3 => 'Comandante',

		4 => 'Tecnico',

		5 => 'Medico',

	),

	// Coloni

	13 => array(

	),


);



$BUILDING_DESCRIPTION = array (

	// Federazione
	0 => array(

		0 => 'Con l&#180;alzarsi del livello di questa costruzione si accede ad un numero maggiore di strutture realizzabili.',

		1 => 'Potenziare questa struttura permette, di estrarre una maggiore quantit&agrave; di metalli per tick.',

		2 => 'Potenziare questa struttura permette, di estrarre una maggiore quantit&agrave; di minerali per tick.',

		3 => 'Potenziare questa struttura permette, di estrarre una maggiore quantit&agrave; di dilitio per tick.',

		4 => 'Ogni livello di questa struttura, fornisce energia ad altre 10 costruzioni.',

		5 => 'A seconda del livello di questa struttura, i tuoi lavoratori vengono convertiti in una maggiore variet&agrave; di truppe.',

		6 => 'Potenziare questa struttura aumenta la portata dei sensori installati sul pianeta. Inoltre, ti permette di riparare le navi danneggiate e di gestire gli equipaggi.',

		7 => 'Potenziare questa struttura permette di ridurre il tempo di costruzione delle navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura ti permette di stringere accordi commerciali con altri giocatori.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta  di 50000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassare i loro costi',

	),



	// Romulani

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



	// Klingon

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



	// Cardassiani

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



	// Dominio

	4 => array(

		0 => 'Il livello del Tempio dei Fondatori influenza il numero di strutture edificabili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore &egrave; il numero di schiavi impiegati al suo interno e la quantit&agrave; di metallo prodotto.',

		2 => 'Maggiore il livello di questa struttura, maggiore &egrave; il numero di schiavi impiegati al suo interno e la quantit&agrave; di minerale prodotto.',

		3 => 'Maggiore il livello di questa struttura, maggiore &egrave; il numero di schiavi impiegati al suo interno e la quantit&agrave; di dilitio prodotto.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'Sviluppando questa struttura possono essere generati un maggior numero di cloni con genomi differenti e specifici.',

		6 => 'Questa struttura permette il ricovero e la manutenzione delle navi. Potenziare questa struttura aumenta la potenza dei sensori sul pianeta e diminuisce il rischio di spionaggio da parte di navi ostili.',

		7 => 'Lo sviluppo di questa struttura permette di accelerare la costruzione delle navi.',

		8 => 'Il potenziamento di questa struttura rende possibile l&#146;accesso ad un maggior numero di tecnologie.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura permette gli scambi commerciali tra pianeti. A seconda del livello, &eacute possibile raggiungere pianeti molto distanti.',

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

		5 => 'A seconda del livello di Accademia i lavoratori possano essere addestrati come diversi tipi di unit&agrave;.',

		6 => 'Lo Spazioporto serve per la riparazione delle navi danneggiate. Con ogni stadio di sviluppo il pianeta riceve un miglioramento della forza dei sensori.',

		7 => 'Maggiore &egrave; il livello di questa struttura, maggiore sar&agrave; la velocit&agrave; di costruzione delle navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura rende possibile concludere rapporti commerciali con gli altri giocatori che saranno completati in modo automatico.',

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

		0 => 'Maggiore &egrave; il livello della Camera di Raffreddamento, maggiore sar&agrave; il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore &egrave; il livello dell&#146;Estrattore di Metalli, maggiore sar&agrave; la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore &egrave; il livello dell&#146;Estrattore di Minerali, maggiore sar&agrave; la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore &egrave; il livello dell&#146;Estrattore di Dilitio, maggiore sar&agrave; la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Alle 10 Einrichtungsorganismen muss eine neue Kraftquelle erzeugt werden, um diese mit Energie zu versorgen.',

		5 => 'Meglio sar&agrave; sviluppata la Caserma Breen, migliore saranno i combattenti che possono essere addestrati.',

		6 => 'Lo Spazioporto serve per la riparazione delle navi danneggiate. Con ogni stadio di sviluppo il pianeta riceve un miglioramento della forza dei sensori.',

		7 => 'Pi&ugrave; il Cantiere Navale Breen sar&agrave; sviluppato, pi&ugrave; velocemente le navi saranno costruite.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura rende possibile concludere rapporti commerciali con gli altri giocatori che saranno completati in modo automatico.',

		11 => 'Questa struttura ti permette di aumentare la capacit&agrave; di stoccaggio di risorse sul tuo pianeta di 50000 unit&agrave;.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Hirogeni

	9 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'A seconda del livello di Centro di Addestramento i lavoratori possono essere addestrati in diversi tipi di unit&agrave;.',

		6 => 'Lo Spazioporto serve per la riparazione delle navi danneggiate. Con ogni stadio di sviluppo il pianeta riceve un miglioramento della forza dei sensori.',

		7 => 'Maggiore il livello di questa struttura, maggiore sar&agrave; la velocit&agrave; di costruzione delle navi stellari.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura rende possibile concludere rapporti commerciali con gli altri giocatori che saranno completati in modo automatico.',

		11 => 'Stoccaggio Materie Prime consente di aumentare il numero di risorse accumulabili. Ad ogni livello la quantit&agrave; di risorsa stoccabile viene incrementata di 50000 per tipo.',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Krenim

	10 => array(

		 0 => 'Pi&ugrave; il Krenim Imperium viene ampliato, pi&ugrave; costruzioni differenti possono essere costruite.',

		1 => 'Maggiore il livello di Minatori di Metallo, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di Estrattori di Minerali, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di Estrattori di Dilitio, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Al fine di poter alimentare una colonia in crescita, &egrave; necessario costruire un Reattore Nucleare. Ogni reattore nucleare &egrave; in grado di fornire energia ad ulteriori dieci edifici.',

		5 => 'L&#146;Accademia della Guerra serve per la formazione di combattenti e specialisti. Pi&ugrave; l&#146;Accademia &egrave; stata sviluppata, migliore &egrave; il tipo di unit&agrave; che possono essere addestrate.',

		6 => 'Il Porto Orbitale serve per l&#146;ormeggio e la riparazione delle navi danneggiate. Attraverso ogni fase di sviluppo, i sensori del pianeta migliorano la loro portata.',

		7 => 'L&#146;Arsenale Militare serve per la costruzione di nuove navi. Pi&ugrave; il cantiere navale viene ampliato, pi&ugrave; velocemente saranno completate le navi.',

		8 => 'I Laboratori servono per ricercare nuove tecnologie. Pi&ugrave; i Laboratori sono estesi, pi&ugrave; nuove tecnologie possono essere sviluppate.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'La Borsa Mercantile rende possibile partecipare a scambi commerciali con altri giocatori e alleanze.',

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



	// Umani 29o

	12 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'A seconda del livello di Accademia i lavoratori possano essere addestrati come diversi tipi di unit&agrave;.',

		6 => 'Lo Spazioporto serve per la riparazione delle navi danneggiate. Con ogni stadio di sviluppo il pianeta riceve un miglioramento della forza dei sensori.',

		7 => 'Maggiore il livello di questa struttura, maggiore la velocit&agrave; con cui vengono costruite le navi stellari.<br>Per 50 point of the planet the next higher in each case type of trunk can be built.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura rende possibile concludere rapporti commerciali con gli altri giocatori che saranno completati in modo automatico.',

		11 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di materie prime stoccabili (circa 10.000 per livello).',

		12 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali potenziate a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

	),



	// Coloni
	13 => array(

		0 => 'Maggiore il livello di questa struttura, maggiore il numero di strutture costruibili sul pianeta.',

		1 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di metalli ottenuta ad ogni tick.',

		2 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di minerali ottenuta ad ogni tick.',

		3 => 'Maggiore il livello di questa struttura, maggiore la quantit&agrave; di dilitio ottenuta ad ogni tick.',

		4 => 'Costruire un livello di questa struttura permette di alimentare 10 livelli di altre strutture presenti sul pianeta.',

		5 => 'A seconda del livello di Accademia i lavoratori possano essere addestrati come diversi tipi di unit&agrave;.',

		6 => 'Lo Spazioporto serve per la riparazione delle navi danneggiate. Con ogni stadio di sviluppo il pianeta riceve un miglioramento della forza dei sensori.',

		7 => 'Maggiore il livello di questa struttura, maggiore la velocit&agrave; con cui vengono costruite le navi stellari.<br>Pro 50 Punkte des Planeten kann der jeweils nächsthöhere Rumpftyp gebaut werden.',

		8 => 'Potenziare questa struttura permette di ricercare un maggior numero di tecnologie.<br>Alcune tecnologie sono necessarie per produrre soldati o navi.',

		9 => 'Il livello di questa struttura indica il numero di strutture difensive orbitali a difesa del pianeta. Alcune tecnologie permettono di costruire un maggior numero di tali strutture o di abbassarne i loro costi.',

		10 => 'Questa struttura rende possibile concludere rapporti commerciali con gli altri giocatori che saranno completati in modo automatico.',

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

		0 => 'Tramite l&#146;<b>Adattamento Ecologico</b> di un pianeta ottieni un lavoratore extra per ogni 10 cicli di tick, esso inoltre aumenta lo spazio abitativo di 575.',

		1 => 'La <b>Ricerca Bioscientifica</b> migliora la salute della popolazione e e conduce ad una crescita demografica maggiore: ad ogni 5 cicli di tick viene prodotto un operaio supplementare.',

		2 => 'L&#146;esplorazione delle <b>Strutture Difensive Orbitali</b> modifica i costi ed il numero massimo di grandi stazioni di battaglia orbitali come segue: Costi -3.5%/Liv., Quantit&agrave; +2/Liv.',

		3 => 'La <b>Meccanizzazione</b> consente di ridurre i tempi di produzione e di sviluppo del 2% ad ogni livello.<br>Un risparmio di quasi 1/5 del tempo nello sviluppo del pianeta giustifica il prezzo elevato.',

		4 => 'La <b>Robotica Estrattiva</b> incrementa la produzione di risorse nel modo seguente:<br>Liv. 1: +4.5%<br>Liv. 2: 8.75%<br>Liv. 3: +12.75%<br>Liv. 4: +16.5%<br>Liv. 5: +20%<br>Liv. 6: +23.25%<br>Liv. 7: +26.25%<br>Liv. 8: +29%<br>Liv. 9: +31.5%',

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





	// Umani 29o

	12 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 450 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),


	// Coloni

	13 => array(

		0 => 'Grazie al <b>Terraforming</b> guadagni un lavoratore extra per ogni 10 cicli di tick per ogni livello di Terraforming sviluppato. Inoltre, per ogni livello viene innalzato il limite di popolazione del pianeta di circa 450 unit&agrave;.',

		1 => 'Grazie alla <b>Ricerca Medica</b> guadagni un lavoratore extra ogni 5 cicli di tick per ogni livello sviluppato.',

		2 => 'Miglioramenti nella tecnologia della <b>Difesa Orbitale</b> ti permettono di potenziare le difese planetarie. Per ogni livello di sviluppo vengono applicate le seguenti modifiche:<br>Costi di realizzazione -3.5% / Liv.<br>Difese basiche: +1 / Liv.<br>Difese avanzate: +1 / Liv.',

		3 => 'Attraverso l&#146;<b>Automazione</b> dei processi costruttivi delle strutture di questo pianeta, viene risparmiato circa il 20% del tempo di costruzione per livello.<br>Un risparmio di circa 1/5 del tempo di costruzione di ogni struttura giustifica l&#146;elevato costo in risorse per affrontare lo sviluppo.',

		4 => 'Miglioramenti nella <b>Lavorazione dei Materiali</b> aumentano la quantit&agrave; di risorse estratte dalle miniere/raffinerie:<br>Liv. 1: +4,5%<br>Liv. 2: +8,75%<br>Liv. 3: +12,75%<br>Liv. 4: +16,5%<br>Liv. 5: +20%<br>Liv. 6: +23,25%<br>Liv. 7: +26,25%<br>Liv. 8: +29%<br>Liv. 9: +31,5%',

	),

);



?>
