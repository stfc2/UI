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

$ship_components_locale=array(
// Race Federation
0=>array(
	// Category Maschinenraum
	0=>array(
		// Component M/ARA Mark I
		0=>array(
			'name'=>'M/ARA Mark I',
			'description'=>'Il propulsore a curvatura Materia/Antimateria M/ARA Mark I basato sul primo reattore Warp di Cochrane, fornisce energia ed incrementa la velocit&agrave; base della nave di un fattore Warp 1.',
			'dev_info'=>'',
	    ), // Endof Component M/ARA Mark I

		// Component M/ARA Mark II
		1=>array(
			'name'=>'M/ARA Mark II',
			'description'=>'Il propulsore a curvatura Materia/Antimateria M/ARA Mark I basato sul primo reattore Warp di Cochrane, fornisce energia ed incrementa la velocit&agrave; base della nave di un fattore Warp 1.8.',
			'dev_info'=>'',
	    ), // Endof Component M/ARA Mark II

		// Component M/ARA Mark III
		2=>array(
			'name'=>'M/ARA Mark III',
			'description'=>'Il propulsore a curvatura Materia/Antimateria M/ARA Mark I basato sul primo reattore Warp di Cochrane, fornisce energia ed incrementa la velocit&agrave; base della nave di un fattore Warp 2.6.',
			'dev_info'=>'',
	    ), // Endof Component M/ARA Mark III

		// Component 1500-P-C-Warpkern
		3=>array(
			'name'=>'1500-P-C-Warpcore',
			'description'=>'Il Warpcore 1500 Pulse Cochrane &egrave; lo stato dell&#146;arte della tecnologia della Federazione, viene normalmente integrato nelle classi Sovereign e Defiant.<br>Incrementa considerevolmente il quantitativo di energia prodotta ed il fattore Warp di 3.4.',
			'dev_info'=>'',
	    ), // Endof Component 1500-P-C-Warpkern

		'name'=>'Sala macchine',
		'num'=>'4',
	), // Endof Category Maschinenraum


	// Category Antrieb
	1=>array(
		// Component Bussardkollektoren Typ I
		0=>array(
			'name'=>'Collettori di Bussard Tipo I',
			'description'=>'Nati da un progetto del 1960 di Robert W. Bussard, i Collettori sono stati costruire per raccogliere il pulviscolo spaziale per tramutarlo in energia. Incrementa il fattore Warp al massimo.',
			'dev_info'=>'',
	    ), // Endof Component Bussardkollektoren Typ I

		// Component Bussardkollektoren Typ II
		1=>array(
			'name'=>'Collettori di Bussard Tipo II',
			'description'=>'Nati da un progetto del 1960 di Robert W. Bussard, i Collettori sono stati costruire per raccogliere il pulviscolo spaziale per tramutarlo in energia. Incrementa il fattore Warp al massimo.',
			'dev_info'=>'',
	    ), // Endof Component Bussardkollektoren Typ II

		// Component Bussardkollektoren Typ III
		2=>array(
			'name'=>'Collettori di Bussard Tipo III',
			'description'=>'Nati da un progetto del 1960 di Robert W. Bussard, i Collettori sono stati costruire per raccogliere il pulviscolo spaziale per tramutarlo in energia. Incrementa il fattore Warp al massimo.',
			'dev_info'=>'',
	    ), // Endof Component Bussardkollektoren Typ III

		// Component Bussardkollektoren Typ IV
		3=>array(
			'name'=>'Collettori di Bussard Tipo IV',
			'description'=>'Nati da un progetto del 1960 di Robert W. Bussard, i Collettori sono stati costruire per raccogliere il pulviscolo spaziale per tramutarlo in energia. Incrementa il fattore Warp al massimo.',
			'dev_info'=>'',
	    ), // Endof Component Bussardkollektoren Typ IV

		// Component Bussardkollektoren Typ V
		4=>array(
			'name'=>'Collettori di Bussard Tipo V',
			'description'=>'Nati da un progetto del 1960 di Robert W. Bussard, i Collettori sono stati costruire per raccogliere il pulviscolo spaziale per tramutarlo in energia. Incrementa il fattore Warp al massimo.',
			'dev_info'=>'',
	    ), // Endof Component Bussardkollektoren Typ V

		'name'=>'Impulso',
		'num'=>'5',
	), // Endof Category Antrieb


	// Category Waffendeck I
	2=>array(
		// Component Phaserbank Typ-III
		0=>array(
			'name'=>'Banchi phaser Tipo-III',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146;energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-III

		// Component Phaserbank Typ-IV
		1=>array(
			'name'=>'Banchi phaser Tipo-IV',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146;energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-IV

		// Component Phaserbank Typ-V
		2=>array(
			'name'=>'Banchi phaser Tipo-V',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146;energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-V

		// Component Phaserbank Typ-X
		3=>array(
			'name'=>'Banchi phaser Tipo-X',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146;energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-X

		// Component Phaserbank Typ-XI
		4=>array(
			'name'=>'Banchi phaser Tipo-XI',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146;energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-XI

		// Component Phaserbank Typ-XII
		5=>array(
			'name'=>'Banchi phaser Tipo-XII',
			'description'=>'Le particelle subatomiche a breve vita (effetto rapido Nadion) possono rilasciare enormi forze nucleari se convogliate in un cristallo superconduttivo (alcune classi). L&#146; energia del sistema EPS di una nave &egrave; usato per produrre questo effetto. L&#146;energia dal sistema EPS viene portata tramite le linee di controllo alla camera di precombustione. Qui viene prodotto un raggio pulsante che viene passato nel cristallo emettitore e libera l&#146;effetto veloce di Nadion. Il raggio lascia il cristallo emettitore e passa al dispositivo di guida. Quindi abbandona la nave diretto verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Phaserbank Typ-XII

		// Component Impulsphaserkanone
		6=>array(
			'name'=>'Cannone phaser ad impulso',
			'description'=>'Questo phaser funziona come un Disgregatore. L&#146;energia viene brevemente immagazzinata e poi rlasciata. Con l&#146;aggiunta diretta di plasma l&#146;effetto &egrave; ulteriormente rafforzato. L&#146;intensificazione usa un enorme quantitativo di energia al plasma e pu&ograve; portare ad un sovraccarico del sistema EPS.',
			'dev_info'=>'',
	    ), // Endof Component Impulsphaserkanone

		'name'=>'Ponte armamenti I',
		'num'=>'7',
	), // Endof Category Waffendeck I


	// Category Waffendeck II
	3=>array(
		// Component Photonentorpedowerfer
		0=>array(
			'name'=>'Siluri fotonici',
			'description'=>'I siluri fotonici sono in servizio sulle navi della Flotta Stellare sin dai primi anni del 23esimo secolo<br>sono indipendenti dalla nave ed hanno un proprio sistema di propulsione e di guida. Un vantaggio &egrave; che possono anche essere usati a velocit&agrave; superiori della luce',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedowerfer

		// Component Photonentorpedowerfer II
		1=>array(
			'name'=>'Siluri fotonici Tipo II',
			'description'=>'I siluri fotonici sono in servizio sulle navi della Flotta Stellare sin dai primi anni del 23esimo secolo<br>sono indipendenti dalla nave ed hanno un proprio sistema di propulsione e di guida. Un vantaggio &egrave; che possono anche essere usati a velocit&agrave; superiori della luce',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedowerfer II

		// Component Quantentorpedowerfer M-X
		2=>array(
			'name'=>'Siluri quantici M-X',
			'description'=>'Nei siluri quantici viene applicata una testata a filamenti quantici. I filamenti interagiscono tra di loro cosicch&eacute; viene rilasciata un enorme quantit&agrave; di energia. L&#146;involucro dei siluri quantici &egrave; differente da quello dei siluri fotonici sebbene ne mantengano la forma. Questi siluri richiedono uno speciale  lanciasiluri e sulle navi moderne viene applicato un lanciasiluri universale con cui poter lanciare anche siluri fotonici.',
			'dev_info'=>'',
	    ), // Endof Component Quantentorpedowerfer M-X

		// Component Quantentorpedowerfer M-XI
		3=>array(
			'name'=>'Siluri quantici M-XI',
			'description'=>'Nei siluri quantici viene applicata una testata a filamenti quantici. I filamenti interagiscono tra di loro cosicch&eacute; viene rilasciata un enorme quantit&agrave; di energia. L&#146;involucro dei siluri quantici &egrave; differente da quello dei siluri fotonici sebbene ne mantengano la forma. Questi siluri richiedono uno speciale  lanciasiluri e sulle navi moderne viene applicato un lanciasiluri universale con cui poter lanciare anche siluri fotonici.',
			'dev_info'=>'',
	    ), // Endof Component Quantentorpedowerfer M-XI

		// Component Quantentorpedowerfer M-XII
		4=>array(
			'name'=>'Siluri quantici M-XII',
			'description'=>'Nei siluri quantici viene applicata una testata a filamenti quantici. I filamenti interagiscono tra di loro cosicch&eacute; viene rilasciata un enorme quantit&agrave; di energia. L&#146;involucro dei siluri quantici &egrave; differente da quello dei siluri fotonici sebbene ne mantengano la forma. Questi siluri richiedono uno speciale  lanciasiluri e sulle navi moderne viene applicato un lanciasiluri universale con cui poter lanciare anche siluri fotonici.',
			'dev_info'=>'',
	    ), // Endof Component Quantentorpedowerfer M-XII

		'name'=>'Ponte armamenti II',
		'num'=>'5',
	), // Endof Category Waffendeck II


	// Category Hülle/Schilde
	4=>array(
		// Component Regenerative Schildgitter
		0=>array(
			'name'=>'Griglia scudi rigenerativi',
			'description'=>'La griglia di scudi rigenerativi sono una tecnologia sviluppata per navi relativamente deboli per le quali l&#146;integrita degli scudi pu&ograve; essere ristabilita pi&ugrave; velocemente ed efficientemente.',
			'dev_info'=>'',
	    ), // Endof Component Regenerative Schildgitter

		// Component Bioneurale Schilde
		1=>array(
			'name'=>'Scudi bioneurali',
			'description'=>'Gli scudi bioneurali diventano necessari quando la performance dei normali scudi non &egrave; pi&ugrave; sufficiente.',
			'dev_info'=>'',
	    ), // Endof Component Bioneurale Schilde

		// Component Multiphasenschilde
		2=>array(
			'name'=>'Scudi multifasici',
			'description'=>'Gli scudi multifasici sono un miglioramento rispetto i normali scudi, perch&eacute; grazie a speciali tecnologie possono essere creati dei campi di forza multi-fase intorno alla nave in grado di assorbire anche l&#146;impatto di un forte bombardamento per un certo periodo.',
			'dev_info'=>'',
	    ), // Endof Component Multiphasenschilde

		// Component Verstärkte Hüllenpanzerung
		3=>array(
			'name'=>'Corazza rinforzata',
			'description'=>'Tramite una corazza rinforzata, usata anche dalle navi di classe incrociatore, gli shock energetici vengono assorbiti meglio.',
			'dev_info'=>'',
	    ), // Endof Component Verstärkte Hüllenpanzerung

		// Component Absorbierende Hüllenpanzerung
		4=>array(
			'name'=>'Corazza assorbente',
			'description'=>'Questa corazza assorbe i colpi delle armi delle navi ostili e li converte in energia, per cui il proprio fabbisogno energetico &egrave; coperto.',
			'dev_info'=>'',
	    ), // Endof Component Absorbierende Hüllenpanzerung

		// Component Hüllenableitpanzerung
		5=>array(
			'name'=>'Corazza ablativa',
			'description'=>'La corazza ablativa &egrave; formata da una serie di scudi con un&#146;alto potenziale assorbente ma richiede un notevole sforzo aggiuntivo da parte degli emettitori degli scudi.',
			'dev_info'=>'',
	    ), // Endof Component Hüllenableitpanzerung

		'name'=>'Scafo/Scudi',
		'num'=>'6',
	), // Endof Category Hülle/Schilde


	// Category Computersystem
	5=>array(
		// Component LCARS Grundsystem
		0=>array(
			'name'=>'Sistema base LCARS',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS Grundsystem

		// Component LCARS 2.0
		1=>array(
			'name'=>'LCARS 2.0',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS 2.0

		// Component LCARS 2.5
		2=>array(
			'name'=>'LCARS 2.5',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS 2.5

		// Component LCARS 2.5 Rev.2
		3=>array(
			'name'=>'LCARS 2.5 Rev.2',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS 2.5 Rev.2

		// Component LCARS 3.0
		4=>array(
			'name'=>'LCARS 3.0',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS 3.0

		// Component LCARS 3.0 (20 MegaQuads/sec)
		5=>array(
			'name'=>'LCARS 3.0 (20 MegaQuads/sec)',
			'description'=>'Il sistema LCARS (Library Computer Access and Retrieval System) &egrave; la superfice e l&#146;interfaccia utente con cui sono equipaggiati i computer della Federazione.',
			'dev_info'=>'',
	    ), // Endof Component LCARS 3.0 (20 MegaQuads/sec)

		'name'=>'Sistema informatico',
		'num'=>'6',
	), // Endof Category Computersystem


	// Category Medizin. Einrichtungen
	6=>array(
		// Component Umweltsysteme
		0=>array(
			'name'=>'Sistemi ambientali',
			'description'=>'Sistemi ambientali migliorati forniscono una risposta pi&ugrave; rapida in caso d&#146;emergenza e aumentano il livello d&#146;esperienza del&#146equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Umweltsysteme

		// Component Ventilationssystem
		1=>array(
			'name'=>'Sistema ventilazione',
			'description'=>'Il sistema di ventilazione automatico fornisce una risposta pi&ugrave; rapida in caso di emergenza ed aumenta la prontezza e l&#146;esperienza del personale di bordo.',
			'dev_info'=>'',
	    ), // Endof Component Ventilationssystem

		// Component Erw. Krankenstation
		2=>array(
			'name'=>'Stazione d&#146;infermeria',
			'description'=>'Una stazione d&#146;infermeria fornisce una rapida reazione in caso d&#146;emergenza, aumenta la prontezza ed incrementa i valori empirici dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Erw. Krankenstation

		// Component MHN
		3=>array(
			'name'=>'MOE',
			'description'=>'Il Medico Olografico d&#146;Emergenza (MOE) viene attivato quando in condizioni impossibili, il regolare supporto medico non pu&ograve; intervenire.',
			'dev_info'=>'',
	    ), // Endof Component MHN

		// Component MHN II
		4=>array(
			'name'=>'MOE II',
			'description'=>'Il Medico Olografico d&#146;Emergenza (MOE II) viene attivato quando in condizioni impossibili, il regolare supporto medico non pu&ograve; intervenire. Questa versione ha una personalt&agrave; maggiormente affabile e meno scorbutica rispetto la precedente .',
			'dev_info'=>'',
	    ), // Endof Component MHN II

		'name'=>'Equipaggiamenti medici',
		'num'=>'5',
	), // Endof Category Medizin. Einrichtungen


	// Category Unterbringung
	7=>array(
		// Component Alloggi equipaggio I
		0=>array(
			'name'=>'Alloggi equipaggio I',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio I

		// Component Alloggi equipaggio II
		1=>array(
			'name'=>'Alloggi equipaggio II',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio II

		// Component Alloggi equipaggio III
		2=>array(
			'name'=>'Alloggi equipaggio III',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio III

		// Component Alloggi equipaggio IV
		3=>array(
			'name'=>'Alloggi equipaggio IV',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio IV

		// Component Alloggi equipaggio V
		4=>array(
			'name'=>'Alloggi equipaggio V',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio V

		// Component Alloggi equipaggio VI
		5=>array(
			'name'=>'Alloggi equipaggio VI',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio VI

		// Component Alloggi equipaggio VII
		6=>array(
			'name'=>'Alloggi equipaggio VII',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio VII

		// Component Alloggi equipaggio VIII
		7=>array(
			'name'=>'Alloggi equipaggio VIII',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio VIII

		// Component Alloggi equipaggio IX
		8=>array(
			'name'=>'Alloggi equipaggio IX',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio IX

		// Component Alloggi equipaggio X
		9=>array(
			'name'=>'Alloggi equipaggio X',
			'description'=>'Viene aumentato lo spazio disponibile per alloggiare le truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio X

		'name'=>'Alloggi',
		'num'=>'10',
	), // Endof Category Unterbringung


	// Category Wissenschaftssektion
	8=>array(
		// Component Hilfsdeflektor
		0=>array(
			'name'=>'Deflettore ausiliario',
			'description'=>'Un deflettore ausiliario non solo migliora i sensori ed il grado di reazione, ma puo essere utilizzato anche al fine di deviare piccoli oggetti (ad esempio un frammento di cometa etc.).',
			'dev_info'=>'',
	    ), // Endof Component Hilfsdeflektor

		// Component Sensorplattform
		1=>array(
			'name'=>'Banco sensori',
			'description'=>'Un banco di sensori aumenta la velocit&agrave; di scansione delle stelle circostanti.',
			'dev_info'=>'',
	    ), // Endof Component Sensorplattform

		// Component Sensorenphalanx
		2=>array(
			'name'=>'Sensori avanzati',
			'description'=>'I sensori avanzati aumentano la velocit&agrave; di scansione delle stelle circostanti.',
			'dev_info'=>'',
	    ), // Endof Component Sensorenphalanx

		// Component Deep Space Sensoren
		3=>array(
			'name'=>'Sensori a lungo raggio',
			'description'=>'I sensori a lungo raggio aumentano la velocit&agrave; di scansione delle stelle lontane.',
			'dev_info'=>'',
	    ), // Endof Component Deep Space Sensoren

		// Component Erw. Astronomie
		4=>array(
			'name'=>'Astronometria estesa',
			'description'=>'L&#146;astronometria estesa migliora la classificazione dei dati dei sensori.',
			'dev_info'=>'',
	    ), // Endof Component Erw. Astronomie

		// Component Stellare Astronomie
		5=>array(
			'name'=>'Laboratorio astronomia stellare',
			'description'=>'Il laboratorio di astronomia stellare migliora enormemente il grado di risoluzione dei sensori.',
			'dev_info'=>'',
	    ), // Endof Component Stellare Astronomie

		// Component Zielerfassungssysteme
		6=>array(
			'name'=>'Sistema acquisizione bersaglio',
			'description'=>'Con un sistema di acquisizione del bersaglio accoppiato a sensori rinforzati non solo il grado di risoluzione la profondit&agrave; di scansione dei sensori vengono migliorati ma anche il consumo degli armamenti &egrave; ridotto al minimo.',
			'dev_info'=>'',
	    ), // Endof Component Zielerfassungssysteme

		'name'=>'Sezione scientifica',
		'num'=>'7',
	), // Endof Category Wissenschaftssektion


	// Category Experimentelles
	9=>array(
		// Component Bioschilde
		0=>array(
			'name'=>'Bioscudi',
			'description'=>'I bio scudi sono una nuova tecnologia che migliorano gli scudi bio neurali.',
			'dev_info'=>'',
	    ), // Endof Component Bioschilde

		// Component Regenerative Hüllenpanzerung
		1=>array(
			'name'=>'Corazza rigenerativa',
			'description'=>'La corazza rigenerativa pu&ograve; replicare le parti danneggiate e preservare in questo modo, per un certo periodo, l&#146;integrita strutturale in caso di perdita degli scudi.',
			'dev_info'=>'',
	    ), // Endof Component Regenerative Hüllenpanzerung

		// Component Zielverfollgungssystem
		2=>array(
			'name'=>'Sistema inseguimento bersaglio',
			'description'=>'Questo sistema migliora drasticamente l&#146;acquisizione del bersaglio delle navi di classe Nebula.',
			'dev_info'=>'',
	    ), // Endof Component Zielverfolgungssystem

		// Component Stufenangriffs Doktrien
		3=>array(
			'name'=>'Analizzatore di attacco',
			'description'=>'Il computer simula manovre d&#146;attacco e le possibili contromanovre.',
			'dev_info'=>'',
	    ), // Endof Component Stufenangriffs Doktrien

		// Component M-X KI- Erfassung
		4=>array(
			'name'=>'Collettori M-X KI',
			'description'=>'Il sistema di collettori M-X KI consente un miglioramento dei sensori ed una ottimizzazione dei tempi di acquisizione del bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component M-X KI- Erfassung

		// Component RemodulationsPhalanx
		5=>array(
			'name'=>'Falange rimodulante',
			'description'=>'Migliora il rendimento dei phaser tramite la rimodulazione del banco phaser con la frequenza armonica degli scudi avversari.',
			'dev_info'=>'',
	    ), // Endof Component RemodulationsPhalanx

		// Component Rapid-Launcher
		6=>array(
			'name'=>'Lanciatore rapido',
			'description'=>'Il lanciatore rapido, &egrave; un lanciasiluri migliorato che permette di lanciare costantemente senza la lunga sequenza di caricamento.',
			'dev_info'=>'',
	    ), // Endof Component Rapid-Launcher

		'name'=>'Sperimentale',
		'num'=>'7',
	), // Endof Category Experimentelles


), // Endof Race Federation



// Race Romulan
1=>array(
	// Category Alloggi
	0=>array(
		// Component Alloggi Equipaggio I
		0=>array(
			'name'=>'Alloggi equipaggio I',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio I

		// Component Alloggi Equipaggio II
		1=>array(
			'name'=>'Alloggi equipaggio II',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio II

		// Component Alloggi Equipaggio III
		2=>array(
			'name'=>'Alloggi equipaggio III',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio III

		// Component Alloggi Equipaggio IV
		3=>array(
			'name'=>'Alloggi equipaggio IV',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio IV

		// Component Alloggi Equipaggio V
		4=>array(
			'name'=>'Alloggi equipaggio V',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio V

		// Component Alloggi Equipaggio VI
		5=>array(
			'name'=>'Alloggi equipaggio VI',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio VI

		// Component Alloggi Equipaggio VII
		6=>array(
			'name'=>'Alloggi equipaggio VII',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio VII

		// Component Alloggi Equipaggio VIII
		7=>array(
			'name'=>'Alloggi equipaggio VIII',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio VIII

		// Component Alloggi Equipaggio IX
		8=>array(
			'name'=>'Alloggi equipaggio IX',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio IX

		// Component Alloggi Equipaggio X
		9=>array(
			'name'=>'Alloggi equipaggio X',
			'description'=>'Incrementa lo spazio abitativo a bordo della nave disponibile per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi Equipaggio X

		'name'=>'Alloggi',
		'num'=>'10',
	), // Endof CategoryAlloggi


	// Category Sala Macchine
	1=>array(
		// Component Propulsore Warp
		0=>array(
			'name'=>'Nucleo curvatura I',
			'description'=>'Il primo modello di nucleo a curvatura. L&#146;energia viene prodotta attraverso una singolarit&agrave; quantica artificiale. Incrementa la velocit&agrave; massima di fattore warp 1.2.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo Curvatura

		// Component Nucleo Curvatura
		1=>array(
			'name'=>'Nucleo curvatura II',
			'description'=>'Secondo stadio di sviluppo del nucleo a curvatura. L&#146;energia viene prodotta attraverso una singolarit&agrave; quantica artificiale. Incrementa la velocit&agrave; della nave di fattore warp 1.6.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo CurvaturaI

		// Component Nucleo CurvaturaII
		2=>array(
			'name'=>'Nucleo curvatura III',
			'description'=>'Terzo stadio di sviluppo del nucleo a curvatura. L&#146;energia viene prodotta attraverso una singolarit&agrave; quantica artificiale. Incrementa la velocit&agrave; della nave di fattore warp 2.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo CurvaturaII

		// Component Nucleo CurvaturaV
		3=>array(
			'name'=>'Nucleo curvatura IV',
			'description'=>'Stadio finale dello sviluppo del nucleo a curvatura. L&#146;energia viene prodotta attraverso una singolarit&agrave; quantica artificiale. Incrementa la velocit&agrave; della nave di fattore warp 2.6 e fornisce una grande quantit&agrave; di energia.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo CurvaturaV

		'name'=>'Sala macchine',
		'num'=>'4',
	), // Endof Category Maschinenraum


	// Category Primäre Waffen
	2=>array(
		// Component Disgregatore MK IV
		0=>array(
			'name'=>'Disgregatore MK IV',
			'description'=>'Il modello base di disgregatore romulano',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK IV

		// Component Disgregatore MK VI
		1=>array(
			'name'=>'Disgregatore MK VI',
			'description'=>'Modello di disgregatore potenziato rispetto al IV ma decisamente ancora debole.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK VI

		// Component Disgregatore MK VIII
		2=>array(
			'name'=>'Disgregatore MK VIII',
			'description'=>'Il Disgregatore MK VIII raggiunge un livello di potenza discreto rispetto ai suoi predecessori.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK VIII

		// Component Disgregatore MK X
		3=>array(
			'name'=>'Disgregatore MK X',
			'description'=>'Elevato potere distruttivo, decisamente fatale se impiegato contro vascelli piccoli.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK X

		// Component Disgregatore MK XII
		4=>array(
			'name'=>'Disgregatore MK XII',
			'description'=>'Il ragguardevole potere distruttivo risulta efficace anche su navi di medie dimensioni.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK XII

		// Component Disgregatore  MK XIV
		5=>array(
			'name'=>'Disgregatore MK XIV',
			'description'=>'Questo modello si rivela particolarmente micidiale e viene solitamente impiegato sulle principali navi da guerra.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore  MK XIV

		// Component Disgregatore MK XXI
		6=>array(
			'name'=>'Disgregatore MK XXI',
			'description'=>'Potere distruttivo enorme. Solitamente non rimane traccia alcuna della nave colpita dai Disgregatori MK XXI.',
			'dev_info'=>'',
	    ), // Endof Component Disgregatore MK XXI

		'name'=>'Armi primarie',
		'num'=>'7',
	), // Endof Category Primäre Waffen


	// Category Sekundäre Waffen
	3=>array(
		// Component Ionentorpedos
		0=>array(
			'name'=>'Siluri ionici',
			'description'=>'I Siluri Ionici hanno un potere distruttivo ridotto per la scarsa reazione delle particelle accelerate e consolidate elettromagneticamente, tuttavia risultano fatali contro vascelli di ridotte dimensioni.',
			'dev_info'=>'',
	    ), // Endof Component Ionentorpedos

		// Component Plasmawerfer
		1=>array(
			'name'=>'Cannoni al plasma',
			'description'=>'I cannoni al plasma rappresentano il prototipo dei siluri al plasma. Quest&#146;arma in realt&agrave; lancia delle sfere di plasma di gas ionizzato ad altissime temperature che perdono parte della loro energia a causa della mancanza di un contenimento durante la traettoria verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Plasmawerfer

		// Component Plasmatorpedos MKI
		2=>array(
			'name'=>'Siluri al plasma MK I',
			'description'=>'I siluri al plasma sono costituiti da gas ionizzati ad altissima temperatura, racchiusi in un contenimento magnetico impiegato come involucro. A contatto con una superficie non protetta l&#146;involucro si dissipa liberando la forza distruttrice del plasma.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos MKI

		// Component Plasmatorpedos MK II
		3=>array(
			'name'=>'Siluri al plasma MK II',
			'description'=>'I siluri al plasma MK II sono basati sulla stessa tecnologia del modello precedente, caratterizzati da un migliore involucro elettromagnetico.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos MK II

		// Component Plasmatorpedos MK  V
		4=>array(
			'name'=>'Siluri al plasma MK V',
			'description'=>'I siluri al plasma MK V rappresentano lo stadio finale dello sviluppo di questa tecnologia. L&#146;enorme consumo di energia di questo sistema d&#146;arma ne rende possibile l&#146;impiego solo sulle navi da guerra maggiori, svolgendo anche il compito di armi planetarie.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos MK  V

		'name'=>'Armi secondarie',
		'num'=>'5',
	), // Endof Category Sekundäre Waffen


	// Category Hülle / Schilde
	4=>array(
		// Component Duraniumpanzerung
		0=>array(
			'name'=>'Corazza in duranio',
			'description'=>'La corazzatura standard delle navi. Il duranio &egrave; un acciaio particolarmente resistente e leggero.',
			'dev_info'=>'',
	    ), // Endof Component Duraniumpanzerung

		// Component Schildemitter
		1=>array(
			'name'=>'Generatori di scudi',
			'description'=>'Gli scudi generati da questo sistema consistono in un campo di forze antigravitazionale intorno alla nave. Se qualcosa viene a contatto dello scafo, gli scudi invertono la spinta gravitazionale in quel punto, rilfettendo ad esempio la forza d&#146;urto di un siluro.',
			'dev_info'=>'',
	    ), // Endof Component Schildemitter

		// Component Regenerative Schilde
		2=>array(
			'name'=>'Scudo rigenerante',
			'description'=>'Questo sistema automatico &egrave; capace di individuare rapidamente falle nello scafo e proiettare un campo di contenimento, capace di limitare la perdita di integrit&agrave; nella struttura dello scafo stesso.',
			'dev_info'=>'',
	    ), // Endof Component Regenerative Schilde

		// Component Duranium- Tritanium- Panzerung
		3=>array(
			'name'=>'Corazza duranio-tritanio',
			'description'=>'La corazza di duranio-tritanio rappresenta il massimo nella tecnologia di protezione degli scafi e consiste in un wafer di strati di Duranio e Tritanio sovrapposti.',
			'dev_info'=>'',
	    ), // Endof Component Duranium- Tritanium- Panzerung

		// Component Primär- und Sekundärschilde
		4=>array(
			'name'=>'Scudi primari e secondari',
			'description'=>'Attraverso un sistema di scudi doppi ed indipendenti, si raggiunge un livello di protezione mai visto a vantaggio delle navi di classe Scimitar.',
			'dev_info'=>'',
	    ), // Endof Component Primär- und Sekundärschilde

		'name'=>'Scafo/Scudi',
		'num'=>'5',
	), // Endof Category Hülle / Schilde


	// Category Computersystem
	5=>array(
		// Component Standardrechner
		0=>array(
			'name'=>'Computer standard',
			'description'=>'Modello basico del calcolatore di bordo.',
			'dev_info'=>'',
	    ), // Endof Component Standardrechner

		// Component Boardcomputer
		1=>array(
			'name'=>'Computer tattico',
			'description'=>'Designazione per la nuova generazione di calcolatori disponibili per i vascelli romulani.',
			'dev_info'=>'',
	    ), // Endof Component Boardcomputer

		// Component Telemetrie-Auswertungs-System
		2=>array(
			'name'=>'Sistema di analisi telemetrico',
			'description'=>'Un enorme passo avanti nella tecnologia dei computer di bordo. La potenza di calcolo e la velocit&agrave; di comunicazione tra le varie componenti del sistema &egrave; vistosamente migliorato rispetto ai vecchi modelli.',
			'dev_info'=>'',
	    ), // Endof Component Telemetrie-Auswertungs-System

		// Component Simultanrechensystem
		3=>array(
			'name'=>'Computer simultronico',
			'description'=>'Attraverso la simultaneit&agrave; delle operazioni aritmetiche e degli altri processi, possibile attraverso componenti in bio-gel, le capacit&agrave; dei computer di bordo sono ulteriormente potenziate.',
			'dev_info'=>'',
	    ), // Endof Component Simultanrechensystem

		// Component Angriffs-System
		4=>array(
			'name'=>'Sistemi d&#146;attacco',
			'description'=>'La migliore rappresentazione dei computer di bordo. Le funzioni di questo sistema sono nettamente pi&ugrave; potenti rispetto ai modelli precedenti, ma le richieste di spazio e di energia ne permettono l&#146;impiego solo sulle maggiori navi da guerra.',
			'dev_info'=>'',
	    ), // Endof Component Angriffs-System

		'name'=>'Computer',
		'num'=>'5',
	), // Endof Category Computersystem


	// Category Medizin. Einrichtungen
	6=>array(
		// Component Lebenserhaltungs-System
		0=>array(
			'name'=>'Supporto vitale',
			'description'=>'Il supporto vitale garantisce una costante riserva di aria respirabile all&#146;interno della nave.',
			'dev_info'=>'',
	    ), // Endof Component Lebenserhaltungs-System

		// Component Krankenstation
		1=>array(
			'name'=>'Infermeria',
			'description'=>'In questa struttura vengono curati i feriti gravi o conservati i cadaveri.',
			'dev_info'=>'',
	    ), // Endof Component Krankenstation

		// Component Umweltregulatoren
		2=>array(
			'name'=>'Regolatore ambientale',
			'description'=>'Questo sistema mantiene un clima confortevole su tutti i ponti della nave.',
			'dev_info'=>'',
	    ), // Endof Component Umweltregulatoren

		// Component Notfallprozedere
		3=>array(
			'name'=>'Procedure di emergenza',
			'description'=>'Una serie di regole e addestramenti impartiti all&#146;equipaggio per prepararlo ad ogni possibile evenienza.',
			'dev_info'=>'',
	    ), // Endof Component Notfallprozedere

		// Component Notsystem
		4=>array(
			'name'=>'Sistema di emergenza',
			'description'=>'Il sistema di emergenza provvede alle funzioni base di supporto vitale e gravit&agrave; artificiale con sottosistemi ridondanti, cos&igrave; da mantenere l&#146;equipaggio in sicurezza anche in caso di gravi danni alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Notsystem

		'name'=>'Supporto',
		'num'=>'5',
	), // Endof Category Medizin. Einrichtungen


	// Category Antrieb
	7=>array(
		// Component Warpspulen
		0=>array(
			'name'=>'Bobine di curvatura',
			'description'=>'Le bobine di curvatura standard rappresentano i sistemi di base per raggiungere velocit&agrave; trans-luce.',
			'dev_info'=>'',
	    ), // Endof Component Warpspulen

		// Component Plasmaspulen
		1=>array(
			'name'=>'Bobine al plasma',
			'description'=>'Le bobine al plasma permettono alla nave di raggiungere velocit&agrave; maggiori rispetto alle bobine di vecchia generazione.',
			'dev_info'=>'',
	    ), // Endof Component Plasmaspulen

		// Component RS Leiter
		2=>array(
			'name'=>'Superconduttori',
			'description'=>'Questa tecnologia permette di migliorare il funzionamento delle bobine di curvatura riducendo la dispersione di energia, aumentando la velocit&agrave; massima raggiungibile.',
			'dev_info'=>'',
	    ), // Endof Component RS Leiter

		// Component RS Kollektoren
		3=>array(
			'name'=>'Collettore RS',
			'description'=>'Questi collettori realizzati con superconduttori catturano una maggiore quantit&agrave; di energia dal nucleo e la portano direttamente alle bobine senza perdite rilevanti. Questo incremento di energia aumenta la velocit&agrave; massima raggiungibile.',
			'dev_info'=>'',
	    ), // Endof Component RS Kollektoren

		'name'=>'Propulsori',
		'num'=>'4',
	), // Endof Category Antrieb


	// Category Wissenschaftsstation
	8=>array(
		// Component Deflektor
		0=>array(
			'name'=>'Deflettore',
			'description'=>'Il deflettore funziona sullo stesso principio del generatore di scudi.',
			'dev_info'=>'',
	    ), // Endof Component Deflektor

		// Component Sensorenphalanx
		1=>array(
			'name'=>'Rilevatore',
			'description'=>'Questo sistema ha come scopo la scansione dello spazio a corto raggio intorno alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Sensorenphalanx

		// Component Sensorabtastung
		2=>array(
			'name'=>'Scanner',
			'description'=>'Lo scanner &egrave; il risultato dello sviluppo del Rilevatore, rispetto al quale offre maggiore precisione e portata.',
			'dev_info'=>'',
	    ), // Endof Component Sensorabtastung

		// Component Sensorgitter
		3=>array(
			'name'=>'Griglia sensoriale',
			'description'=>'La griglia di sensori rappresenta un ulteriore sviluppo degli Scanner. L&#146;equipaggio viene supportato con un costante afflusso di dati da un numero maggiore di sensori, permettendo di reagire con pi&ugrave; prontezza nelle situazioni di emergenza.',
			'dev_info'=>'',
	    ), // Endof Component Sensorgitter

		// Component Longrange Sensoren
		4=>array(
			'name'=>'Sensori a lungo raggio',
			'description'=>'Questo sistema permette di raccogliere informazioni dettagliate su lunghe distanze.',
			'dev_info'=>'',
	    ), // Endof Component Longrange Sensoren

		// Component Zielerfassung
		5=>array(
			'name'=>'Puntamento bersaglio',
			'description'=>'Questo sistema offre una migliore capacit&agrave; di acquisire, inseguire e colpire il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Zielerfassung

		// Component Tarnvorrichtung
		6=>array(
			'name'=>'Sistema di occultamento',
			'description'=>'Il sistema di occultamento rappresenta una tecnologia tipicamente romulana. Esso rende molto difficile rilevare la presenza della nave o colpirla in combattimento.',
			'dev_info'=>'',
	    ), // Endof Component Tarnvorrichtung

		'name'=>'Postazione scientifica',
		'num'=>'7',
	), // Endof Category Wissenschaftsstation


	// Category Experimentelles
	9=>array(
		// Component Talaron Radiation Emitter
		0=>array(
			'name'=>'Matrice talaronica',
			'description'=>'La matrice talaronica &egrave; una nuova e pericolosa arma. &Egrave; stata sviluppata dai Remani e permette lo sterminio di un intero pianeta. Pu&ograve; distruggere l&#146;equipaggio di una nave con un solo colpo. Questo sistema &egrave; applicabile alla sola classe Scimitar.',
			'dev_info'=>'',
	    ), // Endof Component Talaron Radiation Emitter

		// Component Talarontarnung
		1=>array(
			'name'=>'Occultamento talaronico',
			'description'=>'Questo sistema funziona sul principio della matrice talaronica. A differenza dell&#146;occultamento tradizionale, questo sistema permette di fare fuoco anche se la nave ha l&#146;occultamento attivato.',
			'dev_info'=>'',
	    ), // Endof Component Talarontarnung

		// Component Haluzinogene
		2=>array(
			'name'=>'Allucinogeni',
			'description'=>'Droghe sintetiche che aumentano prontezza e reazione dell&#146;equipaggio della nave.',
			'dev_info'=>'',
	    ), // Endof Component Haluzinogene

		// Component Neuroemitter
		3=>array(
			'name'=>'Emettitore neuronico',
			'description'=>'Prontezza e reazione dell&#146;equipaggio sono potenziate attraverso l&#146;uso di questi innesti.',
			'dev_info'=>'',
	    ), // Endof Component Neuroemitter

		// Component Subraumsonden
		4=>array(
			'name'=>'Sonda subspaziale',
			'description'=>'La sonda subspaziale rappresenta uno sviluppo eccezionale dei sensori. Le prestazioni in portata e precisione raggiungono livelli mai sognati.',
			'dev_info'=>'',
	    ), // Endof Component Subraumsonden

		'name'=>'Sperimentazione',
		'num'=>'5',
	), // Endof Category Experimentelles


), // Endof Race Romulaner



// Race Klingonen
2=>array(
	// Category Sala Macchine
	0=>array(
		// Component Warpkern
		0=>array(
			'name'=>'Warpcore',
			'description'=>'Questo reattore a curvatura &egrave; il primo modello base sviluppato, fornisce energia ed incrementa la velocit&agrave; della nave.',
			'dev_info'=>'',
	    ), // Endof Component Warpkern

		// Component Warpkern MK I
		1=>array(
			'name'=>'Warpcore MK I',
			'description'=>'Il nucleo di curvatura MK I, risulta significativamente pi&ugrave; prestante rispetto al suo predecessore, permette infatti di aumentare il fattore warp di 1.2.',
			'dev_info'=>'',
	    ), // Endof Component Warpkern MK I

		// Component Warpkern MKII
		2=>array(
			'name'=>'Warpcore MKII',
			'description'=>'Il nucleo di curvatura MK II permette di aumentare significativamente l&#146;apporto energetico alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Warpkern MKII

		// Component Warpkern MKIII
		3=>array(
			'name'=>'Warpcore MKIII',
			'description'=>'La terza revisione del nucleo di curvatura (MK III) &egrave; stata sviluppata per la navi di grosse dimensioni.',
			'dev_info'=>'',
	    ), // Endof Component Warpkern MKIII

		'name'=>'Sala macchine',
		'num'=>'4',
	), // Endof Category Sala Macchine


	// Category Antrieb
	1=>array(
		// Component QuQmey MK I
		0=>array(
			'name'=>'QuQmey MK I',
			'description'=>'&acute;QuQmey&acute; tradotto dal klingon significa sistema di propulsione, termine che ben si adatta a questo componente. Questa prima revisione aumenta il fattore Warp di 1.6.',
			'dev_info'=>'',
	    ), // Endof Component QuQmey MK I

		// Component QuQmey MKII
		1=>array(
			'name'=>'QuQmey MKII',
			'description'=>'La seconda versione del QuQmey compensa alle mancanze del suo predecessore, implementando un sistema pi&ugrave efficente, permettendo un aumento del fattore warp di 1.9.',
			'dev_info'=>'',
	    ), // Endof Component QuQmey MKII

		// Component QuQmey MKIII
		2=>array(
			'name'=>'QuQmey MKIII',
			'description'=>'Il continuo aggiornamento di questo sistema permette un ulteriore miglioramento, aumentandone l&#146;efficienza e migliorando il fattore warp di 2.2.',
			'dev_info'=>'',
	    ), // Endof Component QuQmey MKIII

		// Component QuQmey MK IV
		3=>array(
			'name'=>'QuQmey MK IV',
			'description'=>'L&#146;ultima revisione di questo sistema incrementa ulteriormente il fattore warp, portandolo a quota 3.2.',
			'dev_info'=>'',
	    ), // Endof Component QuQmey MK IV

		'name'=>'Propulsione',
		'num'=>'4',
	), // Endof Category Antrieb


	// Category Strahlenwaffen
	2=>array(
		// Component Disruptorbeam
		0=>array(
			'name'=>'Raggio disgregatore',
			'description'=>'Il raggio disgregatore &egrave; un fascio di ioni accellerato, tuttavia produce un forte campo di dispersione che ne limita i danni all&#146;impatto.',
			'dev_info'=>'',
	    ), // Endof Component Disruptorbeam

		// Component Disruptor
		1=>array(
			'name'=>'Disgregatore',
			'description'=>'Il disgregatore &egrave; un&#146;evoluzione del raggio disgregatore, tuttavia grazie ad un miglior indirizzamento ne aumenta l&#146; efficienza del 40%.',
			'dev_info'=>'',
	    ), // Endof Component Disruptor

		// Component Puls Disruptoren
		2=>array(
			'name'=>'Disgregatore a impulsi',
			'description'=>'Il disgregatore a impulsi &egrave; simile al suo predecessore, la sua differenza consiste nella maggior resistenza dei suoi componenti e nel fatto che gli ioni accellerati non vengono pi&ugrave; emessi a raggio ma bens&igrave; ad impulsi.',
			'dev_info'=>'',
	    ), // Endof Component Puls Disruptoren

		// Component Disruptorbeam MK2
		3=>array(
			'name'=>'Raggio disgregatore MK2',
			'description'=>'&acute;Ritorno alle origini&acute; &egrave; il motto di questa tecnologia. Spesso lo sviluppo di nuove tecnologie per aumentare l&#146;apporto energetico ha sempre condotto a nuovi problemi per gli ingegneri. Per ovviare alla richiesta energetica di questo nuovo disgregatore &egrave; stata recuperata energia addizionale dal nucleo di curvatura.',
			'dev_info'=>'',
	    ), // Endof Component Disruptorbeam MK2

		// Component Gravimetrischer Disruptor
		4=>array(
			'name'=>'Disgregatore gravimetrico',
			'description'=>'Il disgregatore gravimetrico non &egrave; una particolare invenzione, l&#146;approvvigionamento energetico potrebbe essere migliorato, migliorando in definitiva l&#146;effetto distruttivo.',
			'dev_info'=>'',
	    ), // Endof Component Gravimetrischer Disruptor

		// Component Gravimetrischer Pulsdisruptor
		5=>array(
			'name'=>'Disgregatore gravimetrico a impulso',
			'description'=>'Il disgregatore gravimetrico ad impulso diviene possibile grazie ad un sostanziale miglioramento della tecnologia bellica dei disgregatori, offrendo una maggior potenza di fuoco alle navi.',
			'dev_info'=>'',
	    ), // Endof Component Gravimetrischer Pulsdisruptor

		// Component Gravimetrischer Disruptorbeam
		6=>array(
			'name'=>'Raggio disgregatore gravimetrico',
			'description'=>'La ricerca tecnologica sui disgregatori ha raggiunto la sua massima espressione con l&#146;introduzione del raggio disgregatore gravimetrico, tra le caratteristiche vi &egrave; un significativo aumento dell&#146;effetto distruttivo.',
			'dev_info'=>'',
	    ), // Endof Component Gravimetrischer Disruptorbeam

		'name'=>'Armi primarie',
		'num'=>'7',
	), // Endof Category Strahlenwaffen


	// Category Schwere Waffen
	3=>array(
		// Component Ionentorpedos
		0=>array(
			'name'=>'Siluri ionici',
			'description'=>'I siluri ionici risultano costosi e relativamente deboli. L&#146;unico loro punto forte &egrave; la possibilit&agrave; di introdurli sui cargo e sulle navi leggere.',
			'dev_info'=>'',
	    ), // Endof Component Ionentorpedos

		// Component Photonentorpedos
		1=>array(
			'name'=>'Siluri fotonici',
			'description'=>'I siluri fotonici hanno il grande vantaggio di essere indipendenti dalla nave che li lancia, infatti hanno un loro sistema di propulsione e navigazione verso il bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedos

		// Component Photonentorpedos MKVI
		2=>array(
			'name'=>'Siluri fotonici MKVI',
			'description'=>'I siluri fotonici hanno il grande vantaggio di essere indipendenti dalla nave che li lancia, infatti hanno un loro sistema di propulsione e navigazione verso il bersaglio. Rispetto al suo predecessore questo modello risulta avere una maggior forza d&#146;impatto ed un miglior sistema di aggancio del bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedos MKVI

		// Component Triple Launcher
		3=>array(
			'name'=>'Triplo sistema di lancio',
			'description'=>'I siluri fotonici hanno il grande vantaggio di essere indipendenti dalla nave che li lancia, infatti hanno un loro sistema di propulsione e navigazione verso il bersaglio. Questo nuovo sistema permette il lancio simultaneo di 3 siluri fotonici e ad intervalli molto rapidi.',
			'dev_info'=>'',
	    ), // Endof Component Triple Launcher

		// Component Gk´tag Sprengköpfe
		4=>array(
			'name'=>'Testata tattica Gk&acute;tag',
			'description'=>'Le testate tattiche Gk&acute;tag, sono simili ai siluri fotonici, ma sono in grado di superare senza problemi l&#146;atmosfera di un pianeta e di colpire bersagli al suolo.',
			'dev_info'=>'',
	    ), // Endof Component Gk´tag Sprengköpfe

		'name'=>'Armi secondarie',
		'num'=>'5',
	), // Endof Category Schwere Waffen


	// Category Kriegerunterkunft
	4=>array(
		// Component NughI
		0=>array(
			'name'=>'NughI',
			'description'=>'Comprende gli alloggi e le aree sociali del personale di bordo.',
			'dev_info'=>'',
	    ), // Endof Component NughI

		// Component Mangghom nughI
		1=>array(
			'name'=>'Mangghom nughI',
			'description'=>'Alloggi dei soldati, possono contenere 60 guerrieri.',
			'dev_info'=>'',
	    ), // Endof Component Mangghom nughI

		// Component SuwvI` nughI
		2=>array(
			'name'=>'SuwvI&acute; nughI',
			'description'=>'Alloggi dei soldati, possono contenere 70 guerrieri.',
			'dev_info'=>'',
	    ), // Endof Component SuwvI` nughI

		// Component Da´ nughI
		3=>array(
			'name'=>'Da&acute; nughI',
			'description'=>'All&#146;interno di un Da&acute; nughI vi si trova un ambiente migliore anche per i guerrieri stessi.',
			'dev_info'=>'',
	    ), // Endof Component Da´ nughI

		// Component HoD nughI
		4=>array(
			'name'=>'HoD nughI',
			'description'=>'Hod &egrave; il termine per capitano, queste zone della nave sono ben attrezzate, ma anche relativamente costose.',
			'dev_info'=>'',
	    ), // Endof Component HoD nughI

		// Component Sa´ nughI
		5=>array(
			'name'=>'Sa&acute; nughI',
			'description'=>'Sa &egrave; il termine per `generale` - Queste aree sono piuttosto confortevoli e molto piu efficenti rispetto alle HoD nughI.',
			'dev_info'=>'',
	    ), // Endof Component Sa´ nughI

		// Component VaS tIn
		6=>array(
			'name'=>'VaS tIn',
			'description'=>'&acute;VaS tIn&acute; &egrave; una sala molto grande, utile per radunare tutti i guerrieri.',
			'dev_info'=>'',
	    ), // Endof Component VaS tIn

		'name'=>'Alloggi guerrieri',
		'num'=>'7',
	), // Endof Category Kriegerunterkunft


	// Category Computer
	5=>array(
		// Component De´wI´
		0=>array(
			'name'=>'De&acute;wI&acute;',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component De´wI´

		// Component De´wI´ MKII
		1=>array(
			'name'=>'De&acute;wI&acute; MKII',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component De´wI´ MKII

		// Component De´wI´ MKIII
		2=>array(
			'name'=>'De&acute;wI&acute; MKIII',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component De´wI´ MKIII

		// Component De´wI´ MK IV
		3=>array(
			'name'=>'De&acute;wI&acute; MK IV',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component De´wI´ MK IV

		// Component De´wI´ V
		4=>array(
			'name'=>'De&acute;wI&acute; V',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component De´wI´ V

		// Component Ngoq De´wI´
		5=>array(
			'name'=>'Ngoq De&acute;wI&acute;',
			'description'=>'I sistemi informatici Klingon servono unicamente di supporto ai sistemi, essendo dei guerrieri fanno a meno di determinate comodit&agrave;.',
			'dev_info'=>'',
	    ), // Endof Component Ngoq De´wI´

		'name'=>'Computer',
		'num'=>'6',
	), // Endof Category Computer


	// Category Sensoren
	6=>array(
		// Component Nochmey
		0=>array(
			'name'=>'Nochmey',
			'description'=>'I sensori di classe Nochmey non sono particolarmente adatti nelle battaglie.',
			'dev_info'=>'',
	    ), // Endof Component Nochmey

		// Component SIbDoH
		1=>array(
			'name'=>'SIbDoH',
			'description'=>'SIbDoH &egrave; un primo tipo di sonda, viene lanciata come un siluro fotonico dalle rampe di lancio e viene guidata dalla nave per eseguire determinate scansioni.',
			'dev_info'=>'',
	    ), // Endof Component SIbDoH

		// Component HotlhwI´
		2=>array(
			'name'=>'HotlhwI´',
			'description'=>'HotlhwI Sono un tipo di sensori, con l&#146;aiuto di questi sensori il pilota automatico &egrave; in grado di poter pilotare la nave.',
			'dev_info'=>'',
	    ), // Endof Component HotlhwI´

		// Component DoS nochmey
		3=>array(
			'name'=>'DoS nochmey',
			'description'=>'DoS nochmey sono sensori per la scansione diretta di un oggetto o nave, disegnati specificatamente per la battaglia permettono di migliorare i tempi di risposta dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component DoS nochmey

		// Component Ghoch nochmey
		4=>array(
			'name'=>'Ghoch nochmey',
			'description'=>'Ghoch nochmey &egrave; un sistema di puntamento (in Klingon Ghoch significa anche destino), offre una miglior prestazione dei sensori per aumentare il potenziale della nave.',
			'dev_info'=>'',
	    ), // Endof Component Ghoch nochmey

		// Component NgoQ nochmey
		5=>array(
			'name'=>'NgoQ nochmey',
			'description'=>'Questo &egrave; il penultimo sistema per l&#146;acquisizione del bersaglio e viene implementato unicamente sulle navi di grosse dimensioni, ne aumenta l&#146; efficienza dei sensori ed il sistema di occultamento.',
			'dev_info'=>'',
	    ), // Endof Component NgoQ nochmey

		// Component Ray´ nochmey
		6=>array(
			'name'=>'Ray&acute; nochmey',
			'description'=>'Il Ray&acute; nochmey &egrave; la fase finale dei sistemi d&#146;acquisizione del bersaglio. Unicamente installabile sull&#146;ultima classe di nave, questo sistema permette un aggancio multiplo dei bersagli, consentendo di aprire il fuoco in simultanea su pi&ugrave; bersagli.',
			'dev_info'=>'',
	    ), // Endof Component Ray´ nochmey

		'name'=>'Sensori',
		'num'=>'7',
	), // Endof Category Sensoren


	// Category Experimentelles
	7=>array(
		// Component Phasenkonverter
		0=>array(
			'name'=>'Convertitore di fase',
			'description'=>'Il convertitore di fase &egrave; un sistema sperimentale, implementato per trovare un sistema affidabile che permetta di penetrare gli scudi di una nave nemica.',
			'dev_info'=>'',
	    ), // Endof Component Phasenkonverter

		// Component G. Disruptorkanone MK XVIII
		1=>array(
			'name'=>'Cannone disgregatore MK XVIII',
			'description'=>'Il cannone disgregatore &egrave; un&#146;evoluzione di un normale disgregatore, migliore sia in potenza che in frequenza di fuoco.',
			'dev_info'=>'',
	    ), // Endof Component G. Disruptorkanone MK XVIII

		// Component So´wI´
		2=>array(
			'name'=>'So&acute;wI&acute;',
			'description'=>'So&acute;wI&acute; &egrave; uno degli aggiornamenti klingon relativi al sistema di occultamento. Esso migliora il potenziale offensivo della nave.',
			'dev_info'=>'',
	    ), // Endof Component So´wI´

		// Component Yob
		3=>array(
			'name'=>'Yob',
			'description'=>'Yob &egrave; uno scudo deflettore che pu&ograve; essere installato addizionalmente sulle navi, questo porta un incremento dell&#146; efficienza degli scudi di 90.',
			'dev_info'=>'',
	    ), // Endof Component Yob

		// Component K´d´B Ausbildung
		4=>array(
			'name'=>'Istruzione K&acute;d&acute;B',
			'description'=>'Il sistema di istruzione K&acute;d&acute;B &egrave; stato pensato come programma di istruzione speciale per aumentare l&#146; efficienza dell&#146;equipaggio in battaglia.',
			'dev_info'=>'',
	    ), // Endof Component K´d´B Ausbildung

		// Component Da´ Meister
		5=>array(
			'name'=>'Istruzione Da&acute;',
			'description'=>'Questo programma di addestramento &egrave; stato ideato specificatamente per il capitano della nave, in modo da migliorarne le abilit&agrave; in situazioni d&#146;emergenza.',
			'dev_info'=>'',
	    ), // Endof Component Da´ Meister

		// Component Wabenstruktur Hülle
		6=>array(
			'name'=>'Scafo potenziato',
			'description'=>'Gli scienziati Klingon, hanno scoperto un sistema per sviluppare una corazzatura dello scafo pi&ugrave; efficente, la quale permette una maggior dissipazione del calore causata dalle armi a raggio nemiche. Questa tecnologia &egrave; sperimentale ed &egrave; utilizzabile unicamente sulle navi di classe Brel.',
			'dev_info'=>'',
	    ), // Endof Component Wabenstruktur Hülle

		'name'=>'Sperimentale',
		'num'=>'7',
	), // Endof Category Experimentelles


	// Category Hülle/Schilde
	8=>array(
		// Component -Yob
		0=>array(
			'name'=>'-Yob',
			'description'=>'Gli scudi dei klingon sono tra i pi&ugrave; semplici, poco costosi e non molto efficaci.',
			'dev_info'=>'',
	    ), // Endof Component -Yob

		// Component Duraniumpanzerung
		1=>array(
			'name'=>'Corazza in Duranio',
			'description'=>'La corazzatura in duranio &egrave; una conseguenza dell&#146;inefficacia degli scudi, purtroppo risulta piuttosto costosa.',
			'dev_info'=>'',
	    ), // Endof Component Duraniumpanzerung

		// Component -Targh
		2=>array(
			'name'=>'-Targh',
			'description'=>'Targh aumenta relativamente l&#146;energia erogata agli scudi. Questo sistema viene utilizzato per lo pi&ugrave; sulle navi di classe media.',
			'dev_info'=>'',
	    ), // Endof Component -Targh

		// Component Duranium- Tritaniumpanzerung
		3=>array(
			'name'=>'Corazza in duranio/tritanio',
			'description'=>'Questa corazza &egrave; stata sviluppata da una lega di duranio e tritanio, questa combinazione aumenta i punti scafo di 500.',
			'dev_info'=>'',
	    ), // Endof Component Duranium- Tritaniumpanzerung

		// Component Hüllen-/Schildverstärker
		4=>array(
			'name'=>'Scafo / Amplificatore scudi',
			'description'=>'Scafo / amplificatore scudi, &egrave; l&#146;ultimo stadio dei sistemi di difesa. Viene implementato solo sulle navi pi&ugrave; grandi.',
			'dev_info'=>'',
	    ), // Endof Component Hüllen-/Schildverstärker

		'name'=>'Scafo/Scudi',
		'num'=>'5',
	), // Endof Category Hülle/Schilde


	// Category Trainingsraum
	9=>array(
		// Component Kadettentraining
		0=>array(
			'name'=>'Addestramento cadetti',
			'description'=>'L&#146;addestramento dei cadetti migliora l&#146; efficienza dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Kadettentraining

		// Component Ausbildung zu Kriegern
		1=>array(
			'name'=>'Addestramento guerrieri',
			'description'=>'L&#146;addestramento dei guerrieri, migliora ulteriormente l&#146; efficienza dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Ausbildung zu Kriegern

		// Component Sinnesschärfung
		2=>array(
			'name'=>'Addestramento sensoriale',
			'description'=>'L&#146;addestramento nelle capacit&agrave; sensoriali, migliora il rendimento dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Sinnesschärfung

		// Component Offiziere
		3=>array(
			'name'=>'Ufficiali',
			'description'=>'L&#146;addestramento degli ufficiali, permette di migliorare la scala gerarchica all&#146;interno dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Offiziere

		// Component Reaktionsschärfung
		4=>array(
			'name'=>'Tempo di reazione',
			'description'=>'Migliorando il tempo di reazione dell&#146;equipaggio, si migliora le capacit&agrave; in battaglia.',
			'dev_info'=>'',
	    ), // Endof Component Reaktionsschärfung

		'name'=>'Accademia',
		'num'=>'5',
	), // Endof Category Trainingsraum


), // Endof Race Klingonen



// Race Cardassianer
3=>array(
	// Category Sala Macchine
	0=>array(
		// Component Motori a curvatura
		0=>array(
			'name'=>'Motori a curvatura',
			'description'=>'Il motore a curvatura &egrave; soprattutto responsabile della produzione di energia per la nave. Dalle reazioni materia/antimateria viene raggiunta un&#146;efficienza del 100%.',
			'dev_info'=>'',
	    ), // Endof Component Motori a curvatura

		// Component Motori a curvatura MKII
		1=>array(
			'name'=>'Motori a curvatura MKII',
			'description'=>'Il motore a curvatura &egrave; soprattutto responsabile della produzione di energia per la nave. Dalle reazioni materia/antimateria viene raggiunta un&#146;efficienza del 100%.',
			'dev_info'=>'',
	    ), // Endof Component Motori a curvatura MKII

		// Component Plasmaleiter
		2=>array(
			'name'=>'Conduttori al plasma',
			'description'=>'I conduttori al plasma vengono inseriti addizionalmente ad un nucleo a curvatura come refrigeratori, in questo modo le alte temperature nucleari non svolgono un ruolo cos&igrave; predominante nelle reazioni materia/antimateria.',
			'dev_info'=>'',
	    ), // Endof Component Plasmaleiter

		// Component Materie-Antimaterie Verdichtung
		3=>array(
			'name'=>'Compressore materia-antimateria',
			'description'=>'Con il compressore materia-antimateria la materia viene consolidata all&#146;antimateria in modo da incrementare la produzione di energia.',
			'dev_info'=>'',
	    ), // Endof Component Materie-Antimaterie Verdichtung

		'name'=>'Sala macchine',
		'num'=>'4',
	), // Endof Category Sala Macchine


	// Category Antriebssektion
	1=>array(
		// Component Feldmanipulation
		0=>array(
			'name'=>'Manipolatore di campo',
			'description'=>'Il manipolatore di campo pu&ograve; produrre un campo di curvatura stabile, che rende possibili i viaggi a velocit&agrave; transluce.',
			'dev_info'=>'',
	    ), // Endof Component Feldmanipulation

		// Component Supraleiter
		1=>array(
			'name'=>'Superconduttori',
			'description'=>'Superconduttori applicati alle gondole di curvatura delle navi rinforzano il campo di curvatura in modo tale che sia possibile superare la velocit&agrave; Warp 2.',
			'dev_info'=>'',
	    ), // Endof Component Supraleiter

		// Component Materieumwandlung
		2=>array(
			'name'=>'Convertitore di materia',
			'description'=>'La conversione di materia avviene nel motore a curvatura e conduce direttamente l&#146;energia supplementare nel campo di curvatura, per mantenere ancora stabile la bolla alle velocit&agrave; pi&ugrave; alte.',
			'dev_info'=>'',
	    ), // Endof Component Materieumwandlung

		// Component Antimaterie-Fusion
		3=>array(
			'name'=>'Fusione-antimateria',
			'description'=>'La fusione dell&#146;antimateria avviene esattamente come la conversione di materia nel motore a curvatura e stabilizza il campo di curvatura, al fine di rendere possibili velocit&agrave; pi&ugrave; elevate.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie-Fusion

		// Component Quanten-Determinismus
		4=>array(
			'name'=>'Determinismo quantistico',
			'description'=>'Il determinismo quantistico &egrave; una nuova tecnologia ancora in fase sperimentale.<br>Si sta cercando, attraverso metodi matematici, di determinare in anticipo il movimento dei quanti nel flusso quantistico durante la curvatura e modellare il campo di conseguenza in modo che diventi possibile raggiungere velocit&agrave; pi&ugrave; alte con meno dispendio energetico.',
			'dev_info'=>'',
	    ), // Endof Component Quanten-Determinismus

		'name'=>'Sezione motori',
		'num'=>'5',
	), // Endof Category Antriebssektion


	// Category Waffendeck
	2=>array(
		// Component Phaser
		0=>array(
			'name'=>'Phaser',
			'description'=>'Phaser sind die Standardwaffe auf cardassianischen Scouts und Transportern, sie sind langsam im Bau und nicht sonderlich effektiv.',
			'dev_info'=>'',
	    ), // Endof Component Phaser

		// Component Strahlenemitter
		1=>array(
			'name'=>'Strahlenemitter',
			'description'=>'Strahlenemitter sind eine Weiterentwicklung des Standardphasers, hier werden in der Regel die Strahlen mehrerer Emitter gebündelt auf ein Ziel gelenkt.',
			'dev_info'=>'',
	    ), // Endof Component Strahlenemitter

		// Component Phasendisruptoren
		2=>array(
			'name'=>'Phasendisruptoren',
			'description'=>'Phasendisruptoren sind eine - für Scouts und Transporter - durchaus sinnvolle Technologie. Sie haben eine eingebaute Phasenmodulation, ändern also die Abstrahlungsfrequenz durchgängig, was eine Bedrohung für schwach gepanzerte Schiffe darstellt.',
			'dev_info'=>'',
	    ), // Endof Component Phasendisruptoren

		// Component Disruptorkanone
		3=>array(
			'name'=>'Disruptorkanone',
			'description'=>'Die Disruptorkanone ist der große Bruder der Phasendisruptoren. Sein teuerer Preis und seine rel. lange Bauzeit vereinigen sich mit einer moderaten Schadenswirkung.',
			'dev_info'=>'',
	    ), // Endof Component Disruptorkanone

		// Component Kompressionsphaser
		4=>array(
			'name'=>'Kompressionsphaser',
			'description'=>'Der Kompressionsphaser ist eine schlagkräftige Waffe. Im Gegensatz zu normalen Phaserwaffen laden sich die Emitter über einen bestimmten Zeitraum auf, bevor die Energie gebündelt auf das betreffende Ziel gelenkt wird.',
			'dev_info'=>'',
	    ), // Endof Component Kompressionsphaser

		// Component Spiralwellendisruptoren
		5=>array(
			'name'=>'Spiralwellendisruptoren',
			'description'=>'Die Spiralwellendisruptoren spiegeln den technologischen Stand der Cardassianer wieder. Sie sind durchschlagskräftig gegen alle kleineren Schiffe und für die Oberklasse wie geschaffen.',
			'dev_info'=>'',
	    ), // Endof Component Spiralwellendisruptoren

		'name'=>'Waffendeck',
		'num'=>'6',
	), // Endof Category Waffendeck


	// Category Waffenarsenal
	3=>array(
		// Component Microtorpedos
		0=>array(
			'name'=>'Microtorpedos',
			'description'=>'Microtorpedos sind kleine, selbstgetriebene Geschosse, die einen ´Warhead´ mit einer Sprengkraft von ca. 4 Isotonnen beherbergen.',
			'dev_info'=>'',
	    ), // Endof Component Microtorpedos

		// Component Torpedos
		1=>array(
			'name'=>'Torpedos',
			'description'=>'Torpedos sind selbstgetriebene Geschosse, die einen ´Warhead´ mit einer Sprengkraft von ca. 12 Isotonnen beherbergen.',
			'dev_info'=>'',
	    ), // Endof Component Torpedos

		// Component Photonentorpedos
		2=>array(
			'name'=>'Photonentorpedos',
			'description'=>'Photonentorpedos selbstgetriebene Geschosse mit einem eigenen Zielleitsystem (also schiffscomputerunabhängig), die einen ´Warhead´ mit einer Sprengkraft von ca. 25 Isotonnen beherbergen.',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedos

		// Component Micro-Quantentorpedos
		3=>array(
			'name'=>'Micro-Quantentorpedos',
			'description'=>'In Quantum Torpedos werden Quantumfillamente im Sprengkopf verwendet. Interagieren diese Fillamente miteinander, so wird enorm viel Energie freigesetzt. Quantumtorpedos besitzen ein anderes Gehäuse sowie Gehäuseform als Photonentorpedos. Diese Torpedos erfordern eine spezielle Startvorrichtung, wobei auf modernen Schiffen universelle Startrampen verwendet werden, mit denen auch Photonentorpedos abgefeuert werden können.',
			'dev_info'=>'',
	    ), // Endof Component Micro-Quantentorpedos

		// Component Biokinetische Ladungen
		4=>array(
			'name'=>'Biokinetische Ladungen',
			'description'=>'Biokinetische Ladungen sind eine Art Parasiten, die besonders widerstandsfähig sind und daher mit Hilfe eines Sprengsatzes abgefeuert und zerstäubt werden können.<br>Bei Schiffen versuchen sie die Hülle zu durchdringen und die Crew zu infizieren, bei planetaren Angriffen wird der Sprengsatz in ca. 10km Höhe gezündet und bei günstigen Winden kann man Gebiete von mehreren 1000 km² auslöschen.',
			'dev_info'=>'',
	    ), // Endof Component Biokinetische Ladungen

		'name'=>'Waffenarsenal',
		'num'=>'5',
	), // Endof Category Waffenarsenal


	// Category Hülle/Schilde
	4=>array(
		// Component Schilde
		0=>array(
			'name'=>'Schilde',
			'description'=>'Einfache Schilde sind ausschließlich für den Einsatz auf den Schiffsklassen ´Gul Vystan´, ´Transporter´ und ´Kolonieschiff´ konzipiert und können in der Regel nicht mehr als einen Treffer wegstecken.',
			'dev_info'=>'',
	    ), // Endof Component Schilde

		// Component Diffusions-Banding
		1=>array(
			'name'=>'Diffusions-Banding',
			'description'=>'Diffusions-Banding ist eine neuartige Technologie, bei der ankommende Energiesalven und Torpedos mit Gegenenergie beschossen werden. Dies soll eine Diffusion auslösen, also die Flugbahn in eine andere Ricktung ablenken.',
			'dev_info'=>'',
	    ), // Endof Component Diffusions-Banding

		// Component Quanten Epitaxi
		2=>array(
			'name'=>'Quanten Epitaxi',
			'description'=>'Quanten Epitaxi sind eine verstärkte Schiffshülle, die 650 Punkte mehr in der Verteidigung bringt.',
			'dev_info'=>'',
	    ), // Endof Component Quanten Epitaxi

		// Component Phasenschilde
		3=>array(
			'name'=>'Phasenschilde',
			'description'=>'Phasenschilde sind so konstruiert, dass sie ihre Phasen modulieren und immer min. 2 ´Schichten´ übereinanderliegen, um das Durchdringen von Geschossen zu verhindern.',
			'dev_info'=>'',
	    ), // Endof Component Phasenschilde

		// Component Quantenschilde
		4=>array(
			'name'=>'Quantenschilde',
			'description'=>'Quantenschilde sind eine Weiterentwicklung der herkömmlichen Schildtechnik, hier werden Quanten durch Energiebarrieren gezielt von der Schiffshülle abgelenkt und sollen die engegenkommenden Partikel daran hindern, das Feld zu durchqueren.',
			'dev_info'=>'',
	    ), // Endof Component Quantenschilde

		'name'=>'Hülle/Schilde',
		'num'=>'5',
	), // Endof Category Hülle/Schilde


	// Category Computersysteme
	5=>array(
		// Component Computersystem
		0=>array(
			'name'=>'Computersystem',
			'description'=>'Computersysteme spielen auf cardassianischen Schiffen eine große Rolle, ihnen werden viele routinemäßige Aufgaben anvertraut.',
			'dev_info'=>'',
	    ), // Endof Component Computersystem

		// Component Daten-Imaging
		1=>array(
			'name'=>'Daten-Imaging',
			'description'=>'Computersysteme spielen auf cardassianischen Schiffen eine große Rolle, ihnen werden viele routinemäßige Aufgaben anvertraut.',
			'dev_info'=>'',
	    ), // Endof Component Daten-Imaging

		// Component Kristallspeicher
		2=>array(
			'name'=>'Kristallspeicher',
			'description'=>'Computersysteme spielen auf cardassianischen Schiffen eine große Rolle, ihnen werden viele routinemäßige Aufgaben anvertraut.',
			'dev_info'=>'',
	    ), // Endof Component Kristallspeicher

		// Component Quadritronik
		3=>array(
			'name'=>'Quadritronik',
			'description'=>'Computersysteme spielen auf cardassianischen Schiffen eine große Rolle, ihnen werden viele routinemäßige Aufgaben anvertraut.',
			'dev_info'=>'',
	    ), // Endof Component Quadritronik

		// Component Positronik
		4=>array(
			'name'=>'Positronik',
			'description'=>'Computersysteme spielen auf cardassianischen Schiffen eine große Rolle, ihnen werden viele routinemäßige Aufgaben anvertraut.',
			'dev_info'=>'',
	    ), // Endof Component Positronik

		'name'=>'Computersysteme',
		'num'=>'5',
	), // Endof Category Computersysteme


	// Category Medizinische Sektion
	6=>array(
		// Component Lebenserhaltung
		0=>array(
			'name'=>'Lebenserhaltung',
			'description'=>'Eine verbesserte Lebenserhaltung wirkt sich positiv auf die Leistungen der Crew aus.',
			'dev_info'=>'',
	    ), // Endof Component Lebenserhaltung

		// Component Krankenstation
		1=>array(
			'name'=>'Krankenstation',
			'description'=>'Eine Krankenstation bringt eine bessere Bereitschaft und Reaktion in Krisensituationen mit sich.',
			'dev_info'=>'',
	    ), // Endof Component Krankenstation

		// Component Bioneurale-Implantate
		2=>array(
			'name'=>'Bioneurale-Implantate',
			'description'=>'Bioneurale-Implantate werden den Besatzungsmitgliedern implantiert und erlauben das direkte Kommunizieren untereinander und mit dem Schiffsrechner.',
			'dev_info'=>'',
	    ), // Endof Component Bioneurale-Implantate

		// Component Xenobiologe
		3=>array(
			'name'=>'Xenobiologe',
			'description'=>'Bei Xenobiologe werden die Truppen auf den Schiffen mit fremden Zellen infiziert, also praktisch genmanipuliert.<br>Dies steigert die Leistungsfähigkeit und die Erfahrung.',
			'dev_info'=>'',
	    ), // Endof Component Xenobiologe

		'name'=>'Medizinische Sektion',
		'num'=>'4',
	), // Endof Category Medizinische Sektion


	// Category Forschungseinrichtungen
	7=>array(
		// Component Deflektoren
		0=>array(
			'name'=>'Deflektoren',
			'description'=>'Deflektoren verstärken die Sensorleistung der Schiffe und lenken bei Überlichtgheschwindigkeit Meteoritensplitter u.ä. von der Hülle ab.',
			'dev_info'=>'',
	    ), // Endof Component Deflektoren

		// Component Sensorenplattform
		1=>array(
			'name'=>'Sensorenplattform',
			'description'=>'Sensorenplattformen erhöhen die Abtastgeschwindigkeit der näheren Umgebung und wirken sich positiv auf die Wendigkeit des Schiffes aus.',
			'dev_info'=>'',
	    ), // Endof Component Sensorenplattform

		// Component Sensorphalanx
		2=>array(
			'name'=>'Sensorphalanx',
			'description'=>'Sensorenphalanxen erhöhen die Sensorauflösung und werden mit schiffsinternen Systemen wie dem Autopiloten gekoppelt.',
			'dev_info'=>'',
	    ), // Endof Component Sensorphalanx

		// Component Gammaabtastung
		3=>array(
			'name'=>'Gammaabtastung',
			'description'=>'Die Gammaabtastung erhöht die Genauigkeit der Sensoren noch weiter.',
			'dev_info'=>'',
	    ), // Endof Component Gammaabtastung

		// Component Auswertungssystem
		4=>array(
			'name'=>'Auswertungssystem',
			'description'=>'Durch ein Auswertungssystem werden die Sensordaten in der Telemetrie optimal aufbereitet.',
			'dev_info'=>'',
	    ), // Endof Component Auswertungssystem

		'name'=>'Forschungseinrichtungen',
		'num'=>'5',
	), // Endof Category Forschungseinrichtungen


	// Category Obsidianischer Orden
	8=>array(
		// Component Verhöre
		0=>array(
			'name'=>'Verhöre',
			'description'=>'Neue Verhöhrtechniken sorgen dafür, dass die Crewmitglieder loyaler werden und besser arbeiten.',
			'dev_info'=>'',
	    ), // Endof Component Verhöre

		// Component Spionage
		1=>array(
			'name'=>'Spionage',
			'description'=>'Spionagetechniken des Obsidianischen Ordens verbessern Reaktion, Bereitschaft und die Sensoren des Schiffes.',
			'dev_info'=>'',
	    ), // Endof Component Spionage

		// Component Spiralwellendisruptoren MK II
		2=>array(
			'name'=>'Spiralwellendisruptoren MK II',
			'description'=>'Spiralwellendisruptoren MK II sind die letzte Stufe der Disruptoren, sie senden die Energiewellen in sich ausbreitenden Spiralen aus. Dadurch kommt es natürlich zu einer größeren Streunung und Schwächung der Entladungen, aber die Waffe ist so ausbalanciert, dass sie trotzdem maximalen Schaden anrichtet.',
			'dev_info'=>'',
	    ), // Endof Component Spiralwellendisruptoren MK II

		// Component Doppelte Tritanidpanzerung
		3=>array(
			'name'=>'Doppelte Tritanidpanzerung',
			'description'=>'Die doppelte Tritanidpanzerung verstärkt die Hülle zusätzlich um 1450 Punkte.',
			'dev_info'=>'',
	    ), // Endof Component Doppelte Tritanidpanzerung

		// Component Obsidianische Schilde
		4=>array(
			'name'=>'Obsidianische Schilde',
			'description'=>'Die obsidianischen Schilde sind in ihrer Funktionsweise genauso sagenumwoben und geheimnisvoll wie der Orden selbst.',
			'dev_info'=>'',
	    ), // Endof Component Obsidianische Schilde

		'name'=>'Obsidianischer Orden',
		'num'=>'5',
	), // Endof Category Obsidianischer Orden


	// Category Manschaftsräume
	9=>array(
		// Component Unterkunftsräume
		0=>array(
			'name'=>'Unterkunftsräume',
			'description'=>'Die verschiedenen Typen von Unterkünften ermöglichen es, eine größere Anzahl von Einheiten auf den Schiffen unterzubringen.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunftsräume

		// Component Komfortausstattung
		1=>array(
			'name'=>'Komfortausstattung',
			'description'=>'Die verschiedenen Typen von Unterkünften ermöglichen es, eine größere Anzahl von Einheiten auf den Schiffen unterzubringen.',
			'dev_info'=>'',
	    ), // Endof Component Komfortausstattung

		// Component Verhörräume
		2=>array(
			'name'=>'Verhörräume',
			'description'=>'Die verschiedenen Typen von Unterkünften ermöglichen es, eine größere Anzahl von Einheiten auf den Schiffen unterzubringen.',
			'dev_info'=>'',
	    ), // Endof Component Verhörräume

		// Component Legatenunterkunft
		3=>array(
			'name'=>'Legatenunterkunft',
			'description'=>'Die verschiedenen Typen von Unterkünften ermöglichen es, eine größere Anzahl von Einheiten auf den Schiffen unterzubringen.',
			'dev_info'=>'',
	    ), // Endof Component Legatenunterkunft

		// Component Frachtraumnutzung
		4=>array(
			'name'=>'Frachtraumnutzung',
			'description'=>'Die verschiedenen Typen von Unterkünften ermöglichen es, eine größere Anzahl von Einheiten auf den Schiffen unterzubringen.',
			'dev_info'=>'',
	    ), // Endof Component Frachtraumnutzung

		'name'=>'Manschaftsräume',
		'num'=>'5',
	), // Endof Category Manschaftsräume


), // Endof Race Cardassianer



// Race Dominion
4=>array(
	// Categoria Nucleo Curvatura
	0=>array(
		// Component Level 1 Warpkern
		0=>array(
			'name'=>'Warpcore livello 1',
			'description'=>'Modello basico di fonte energetica per le astronavi. Pu&ograve; essere montato su tutte le navi e innalza la curvatura massima di Warp 1.0',
			'dev_info'=>'',
	    ), // Endof Component Level 1 Warpkern

		// Component Level 2 Warpkern
		1=>array(
			'name'=>'Warpcore livello 2',
			'description'=>'Modello avanzato che fornisce maggiore energia rispetto al livello precedente di sviluppo, il miglior Warpcore installabile su una nave civile.',
			'dev_info'=>'',
	    ), // Endof Component Level 2 Warpkern

		// Component Level 3 Warpkern
		2=>array(
			'name'=>'Warpcore livello 3',
			'description'=>'Modello di sviluppo intermedio. Il rendimento energetico &grave; ulteriormente migliorato. Questo &grave; il primo step di sviluppo del WarpCore dedicato esclusivamente alle navi militari.',
			'dev_info'=>'',
	    ), // Endof Component Level 3 Warpkern

		// Component Dilithiumschmelze I
		3=>array(
			'name'=>'Fusione del dilitio liv. 1',
			'description'=>'Per migliorare la resa dei Warpcore in termini di massima curvatura &egrave; stata sviluppata una tecnica di fusione del Dilitio. La curvatura massima della nave aumenta di Warp 2.0',
			'dev_info'=>'',
	    ), // Endof Component Dilithiumschmelze I

		// Component Dilithiumschmelze II
		4=>array(
			'name'=>'Fusione del dilitio liv. 2',
			'description'=>'Lo sviluppo della tecnologia di fusione del dilitio ha permesso la realizzazione di un Warpcore in grado di fornire l&#146;energia necessaria alla propulsione delle navi maggiori della flotta.',
			'dev_info'=>'',
	    ), // Endof Component Dilithiumschmelze II

		'name'=>'Warpcore',
		'num'=>'5',
	), // Endof Category Warpkerne


	// Category Antriebe
	1=>array(
		// Component Tachyonengondeln
		0=>array(
			'name'=>'Gondole tachioniche Mk I',
			'description'=>'Le gondole tachioniche rappresentano il sistema basico di propulsione a curvatura, efficace solo per le navi civili.',
			'dev_info'=>'',
	    ), // Endof Component Tachyonengondeln

		// Component Verbesserte Tachyonengondel
		1=>array(
			'name'=>'Gondole tachioniche Mk II',
			'description'=>'Sviluppo della tecnologia di base che aumenta la potenza del campo di curvatura, aumentando la velocit&agrave; massima della nave al costo di un maggior consumo energetico.',
			'dev_info'=>'',
	    ), // Endof Component Verbesserte Tachyonengondel

		// Component Gaußgondeln
		2=>array(
			'name'=>'Gondole Gauss',
			'description'=>'Le gondole Gauss sono un progetto dedicato esclusivamente alle navi militari. La resa in termini di campo di curvatura e consumo energetico sono assolutamente superiori rispetto ai sistemi di curvatura precedenti.',
			'dev_info'=>'',
	    ), // Endof Component Gaußgondeln

		// Component Phasenkomprimierer
		3=>array(
			'name'=>'Compressore di fase',
			'description'=>'Il compressore di fase applicato alle gondole Gauss realizzano il miglior sistema di curvatura esistente per la propulsione delle navi nello spazio.',
			'dev_info'=>'',
	    ), // Endof Component Phasenkomprimierer

		'name'=>'Motori',
		'num'=>'4',
	), // Endof Category Antriebe


	// Category Strahlenwaffen
	2=>array(
		// Component Polaronstrahler
		0=>array(
			'name'=>'Emettitore polaronico',
			'description'=>'Tecnologia di base per le armi del Dominio.',
			'dev_info'=>'',
	    ), // Endof Component Polaronstrahler

		// Component Polaronstrahl
		1=>array(
			'name'=>'Concentratore polaronico',
			'description'=>'Perfezionamento della tecnologia polaronica che ne aumenta notevolmente la capacit&agrave; distruttiva. Questa tecnologia &egrave; rappresenta il meglio impiegabile su navi civili.',
			'dev_info'=>'',
	    ), // Endof Component Polaronstrahl

		// Component Impulspoleronkannone
		2=>array(
			'name'=>'Impulsi polaronici liv. 1',
			'description'=>'La tecnologia degli Impulsi Polaronici permette la creazione di un cannone basato sull&#146;impiego delle onde polaroniche.',
			'dev_info'=>'',
	    ), // Endof Component Impulspoleronkannone

		// Component Massebeschleuniger
		3=>array(
			'name'=>'Acceleratore di massa',
			'description'=>'Tecnologia basata sull&#146;accelerazione delle particelle della materia, impiegabile tanto contro navi ostili che come arma planetaria economica.',
			'dev_info'=>'',
	    ), // Endof Component Massebeschleuniger

		// Component Impulspolarondisruptor
		4=>array(
			'name'=>'Impulsi polaronici liv. 2',
			'description'=>'Il top della tecnologia polaronica del Dominio permette la realizzazione di un disgregatore impiegabile sulle maggiori navi della flotta. La sua potenza &egrave; incomparabile rispetto ai sistemi d&#146;arma precedenti.',
			'dev_info'=>'',
	    ), // Endof Component Impulspolarondisruptor

		'name'=>'Armi energetiche',
		'num'=>'5',
	), // Endof Category Strahlenwaffen


	// Category Torpedos
	3=>array(
		// Component Polarontorpedos
		0=>array(
			'name'=>'Siluri polaronici',
			'description'=>'I siluri polaronici sono l&#146;armamento pesante di base per le navi del Dominio in uso anche su navi civili come sistemi di autodifesa.',
			'dev_info'=>'',
	    ), // Endof Component Polarontorpedos

		// Component Photonentorpedos
		1=>array(
			'name'=>'Siluri fotonici',
			'description'=>'I siluri fotonici sono un tipo di armamento basato su una tecnologia standard delle razze del quadrante Alfa.',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedos

		// Component Quantentorpedos
		2=>array(
			'name'=>'Siluri quantici',
			'description'=>'I Siluri Quantici sono una tecnologia peculiare del Dominio, di enorme potenza ed efficacia.',
			'dev_info'=>'',
	    ), // Endof Component Quantentorpedos

		// Component Breentorpedos
		3=>array(
			'name'=>'Siluri Breen',
			'description'=>'I siluri Breen sono armi molto potenti, ottenuti grazie ad uno scambio di tecnologia con gli scenziati Breen.',
			'dev_info'=>'',
	    ), // Endof Component Breentorpedos

		'name'=>'Siluri',
		'num'=>'4',
	), // Endof Category Torpedos


	// Category Defensive Einrichtungen
	4=>array(
		// Component Regenerativer Schild
		0=>array(
			'name'=>'Scudo rigenerante',
			'description'=>'Gli scudi rigeneranti sono un sistema economico e relativamente efficace per la difesa degli scafi.',
			'dev_info'=>'',
	    ), // Endof Component Regenerativer Schild

		// Component Phasenvariationsschild
		1=>array(
			'name'=>'Variatore di fase',
			'description'=>'Questa nuova tecnologia di scudi &egrave; ottenuta attraverso la combinazione di una matrice di scudi con la dipolarit&agrave; di fase.',
			'dev_info'=>'',
	    ), // Endof Component Phasenvariationsschild

		// Component Mehrphasenpanzerung
		2=>array(
			'name'=>'Corazza multifasica',
			'description'=>'Tecnologia che muta la fase della struttura dello scafo con lo scopo di aumentarne la resistenza.',
			'dev_info'=>'',
	    ), // Endof Component Mehrphasenpanzerung

		// Component Neutrinoknotenverstärkung
		3=>array(
			'name'=>'Corazza neutrinica',
			'description'=>'La struttura atomica della lega impiegata per le corazze viene riorganizzata per aumentarne la robustezza strutturale.',
			'dev_info'=>'',
	    ), // Endof Component Neutrinoknotenverstärkung

		// Component Creonspule
		4=>array(
			'name'=>'Bobine Creon',
			'description'=>'La prima bobina Creon fu ritrovata decadi fa sul pianeta morto Creon e successivamente venne migliorata dagli scienziati Dominion. Il suo impiego &egrave; possibile solo sulle navi pi&grave; grandi della flotta.',
			'dev_info'=>'',
	    ), // Endof Component Creonspule

		'name'=>'Sistemi difensivi',
		'num'=>'5',
	), // Endof Category Defensive Einrichtungen


	// Category AI-Kern
	5=>array(
		// Component Siliciumprozessoren
		0=>array(
			'name'=>'Processori in silicio',
			'description'=>'I nuovi processori in silicio garantiscono un miglioramento delle prestazioni della componente I.A.',
			'dev_info'=>'',
	    ), // Endof Component Siliciumprozessoren

		// Component Dualkopplung
		1=>array(
			'name'=>'Accoppiamento strutturale',
			'description'=>'L&#146;accoppiamento strutturale dei processori garantisce un netto miglioramento nei tempi di risposta delle interfacce.',
			'dev_info'=>'',
	    ), // Endof Component Dualkopplung

		// Component Kubriksystem
		2=>array(
			'name'=>'Sistema Kubrik',
			'description'=>'I processori vengono interlacciati con la nuova tecnologia Kubrik, radoppiandone di fatto la capacit&agrave; elaborativa.',
			'dev_info'=>'',
	    ), // Endof Component Kubriksystem

		// Component Leitstand I
		3=>array(
			'name'=>'Posto di controllo liv. 1',
			'description'=>'La nuova organizzazione delle postazioni di controllo di tiro aumentano la coordinazione tra i sistemi e la resa delle armi stesse.',
			'dev_info'=>'',
	    ), // Endof Component Leitstand I

		// Component Leitstand II
		4=>array(
			'name'=>'Posto di controllo liv. 2',
			'description'=>'Questa versione permette di controllare efficacemente anche le armi pesanti della nave.',
			'dev_info'=>'',
	    ), // Endof Component Leitstand II

		// Component Gammarechner
		5=>array(
			'name'=>'Gamma elaboratore',
			'description'=>'Con l&#146;impiego delle particelle gamma viene creata una connessione neurale con i sistemi di elaborazione dati.',
			'dev_info'=>'',
	    ), // Endof Component Gammarechner

		'name'=>'Componenti I.A.',
		'num'=>'6',
	), // Endof Category AI-Kern


	// Category Trainingseinheiten
	6=>array(
		// Component Kampfzentrum I
		0=>array(
			'name'=>'Centro addestramento I',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum I

		// Component Kampfzentrum II
		1=>array(
			'name'=>'Centro addestramento II',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum II

		// Component Kampfzentrum III
		2=>array(
			'name'=>'Centro addestramento III',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum III

		// Component Kampfzentrum IV
		3=>array(
			'name'=>'Centro addestramento IV',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum IV

		// Component Kampfzentrum V
		4=>array(
			'name'=>'Centro addestramento V',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum V

		// Component Kampfzentrum VI
		5=>array(
			'name'=>'Centro addestramento VI',
			'description'=>'Il continuo addestramento in condizioni estreme permette di ottenere la miglior efficacia in combattimento possibile.',
			'dev_info'=>'',
	    ), // Endof Component Kampfzentrum VI

		'name'=>'Zone addestramento',
		'num'=>'6',
	), // Endof Category Trainingseinheiten


	// Category Quartiere
	7=>array(
		// Component Unterkunft I
		0=>array(
			'name'=>'Sistemazione I',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft I

		// Component Unterkunft II
		1=>array(
			'name'=>'Sistemazione II',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft II

		// Component Unterkunft III
		2=>array(
			'name'=>'Sistemazione III',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft III

		// Component Unterkunft IV
		3=>array(
			'name'=>'Sistemazione IV',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft IV

		// Component Unterkunft V
		4=>array(
			'name'=>'Sistemazione V',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft V

		// Component Unterkunft VI
		5=>array(
			'name'=>'Sistemazione VI',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft VI

		// Component Unterkunft VII
		6=>array(
			'name'=>'Sistemazione VII',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft VII

		// Component Unterkunft VIII
		7=>array(
			'name'=>'Sistemazione VIII',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Unterkunft VIII

		// Component Truppendepot
		8=>array(
			'name'=>'Deposito Truppe',
			'description'=>'Questa soluzione progettuale permette di aumentare il numero di truppe presenti a bordo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Truppendepot

		'name'=>'Alloggi',
		'num'=>'9',
	), // Endof Category Quartiere


	// Category Kampfsysteme
	8=>array(
		// Component Sensorischer Scout
		0=>array(
			'name'=>'Scanner micronico',
			'description'=>'Gli scanner micronici sono studiati per equipaggiare le navi spia del Dominio, fornendo un ottimo supporto alla scansione di un pianeta e fornendo dati utili per sfuggire alle difese orbitali.',
			'dev_info'=>'',
	    ), // Endof Component Sensorischer Scout

		// Component Simultane Ortung
		1=>array(
			'name'=>'Sensori guida',
			'description'=>'I sensori guida sono particolarmente adatti a non perdere il controllo di quanto accade sul campo di battaglia.',
			'dev_info'=>'',
	    ), // Endof Component Simultane Ortung

// Component Simultane Ortung
		2=>array(
			'name'=>'Rilevatore simultaneo',
			'description'=>'Il rivelatore simultaneo permette la scansione parallela di pi&ugrave; bersagli.',
			'dev_info'=>'',
	    ), // Endof Component Simultane Ortung
	    
		// Component Ungestörte Ortung
		3=>array(
			'name'=>'Rilevatore asincrono',
			'description'=>'Il miglior sistema basato su tecnologie tradizionali permette la scansione di aree mediante impiego di sonde camuffate.',
			'dev_info'=>'',
	    ), // Endof Component Ungestörte Ortung

		// Component Gefechtsstand
		4=>array(
			'name'=>'Posto di comando',
			'description'=>'Il posto di comando &egrave; una postazione extra situata sul ponte di comando della nave che si occupa della coordinazione tra le varie sezioni.',
			'dev_info'=>'',
	    ), // Endof Component Gefechtsstand

		// Component Sekundärbrücke
		5=>array(
			'name'=>'Ponte secondario',
			'description'=>'Il ponte secondario &egrave; una sottosezione usata unicamente durante gli scontri.',
			'dev_info'=>'',
	    ), // Endof Component Sekundärbrücke

		// Component Gefechtsbrücke I
		6=>array(
			'name'=>'Ponte di combattimento I',
			'description'=>'Soluzione progettuale che enfatizza funzionalit&agrave; ed efficacia del ponte secondario.',
			'dev_info'=>'',
	    ), // Endof Component Gefechtsbrücke I

		// Component Gefechtsbrücke II
		7=>array(
			'name'=>'Ponte di combattimento II',
			'description'=>'Questa soluzione progettuale &egrave; il centro di comando definitivo per ogni tipo di conflitto ed &egrave; il risultato di decadi di studio.',
			'dev_info'=>'',
	    ), // Endof Component Gefechtsbrücke II

		'name'=>'Sistemi di combattimento',
		'num'=>'8',
	), // Endof Category Kampfsysteme


	// Category Geheime Entwicklungen
	9=>array(
		// Component Verbesserte Headsets
		0=>array(
			'name'=>'Intercom migliorato',
			'description'=>'Sistemi di intercomunicazione di bordo migliorato.',
			'dev_info'=>'',
	    ), // Endof Component Verbesserte Headsets

		// Component Waffenaufrüstung
		1=>array(
			'name'=>'Sistema offensivo integrato',
			'description'=>'Sistema di integrazione degli armamenti per le navi militari del Dominio.',
			'dev_info'=>'',
	    ), // Endof Component Waffenaufrüstung

		// Component Doppelschilde
		2=>array(
			'name'=>'Scudi secondari',
			'description'=>'Ottimi per contrastare armi ad altissima energia, entrano in funzione non appena cedono gli scudi primari.',
			'dev_info'=>'',
	    ), // Endof Component Doppelschilde

		// Component Hochenergiehülle
		3=>array(
			'name'=>'Rivestimento antienergetico',
			'description'=>'Questo sistema riflette parte dell&#146;enegia che entra in contatto con lo scafo, deviandone una parte verso i sistemi energetici interni della nave stessa.',
			'dev_info'=>'',
	    ), // Endof Component Hochenergiehülle

		// Component Multiphasentarnung
		4=>array(
			'name'=>'Occultamento multifasico',
			'description'=>'L&#146;occultamento fornisce un grande vantaggio in combattimento e permette di avvicinarsi a pianeti con una debole rete di sensori senza destare allarme.',
			'dev_info'=>'',
	    ), // Endof Component Multiphasentarnung

		// Component Kompletterweiterung
		5=>array(
			'name'=>'Estensione completa',
			'description'=>'Questo pacchetto di migliorie &egrave; disponibile solo a poche navi della Flotta ma fornisce un incremento completo a tutte le caratteristiche della nave stessa.',
			'dev_info'=>'',
	    ), // Endof Component Kompletterweiterung

		'name'=>'Sviluppi segreti',
		'num'=>'6',
	), // Endof Category Geheime Entwicklungen


), // Endof Race Dominion


// Race Ferengi
5=>array(
	// Category Sala Macchine
	0=>array(
		// Component Motori a curvatura
		0=>array(
			'name'=>'Motori a curvatura',
			'description'=>'Il nucleo a curvatura semplice genera energia a sufficienza per Scout e Trasporti. Le prestazioni fornite non sono adatte per navi superiori come il Marauder.',
			'dev_info'=>'',
	    ), // Endof Component Motori a curvatura

		// Component Warp MKII
		1=>array(
			'name'=>'Warp MKII',
			'description'=>'Il nucleo a curvatura MK II genera energia a sufficienza per Scout e Trasporti. Le prestazioni fornite non sono adatte per navi superiori come il Marauder.',
			'dev_info'=>'',
	    ), // Endof Component Warp MKII

		// Component Warp MKIII
		2=>array(
			'name'=>'Warp MKIII',
			'description'=>'Il nucleo a curvatura MK III fornisce gi&agrave; energia a sufficienza per navi superiori come il Marauder.',
			'dev_info'=>'',
	    ), // Endof Component Warp MKIII

		// Component Warp MKIV
		3=>array(
			'name'=>'Warp MKIV',
			'description'=>'Il nucleo a curvatura MK IV &egrave; la fonte di energia definitiva per i Ferengi, fornendo 37 punti di energia.',
			'dev_info'=>'',
	    ), // Endof Component Warp MKIV

		'name'=>'Sala macchine',
		'num'=>'4',
	), // Endof Category Sala Macchine


	// Category Antriebssection
	1=>array(
		// Component Fusionsantrieb
		0=>array(
			'name'=>'Motore a fusione',
			'description'=>'Il motore a fusione permette ai Ferengi di raggiungere velocit&agrave; superiore a quella della luce.',
			'dev_info'=>'',
	    ), // Endof Component Fusionsantrieb

		// Component Feldgeometrie
		1=>array(
			'name'=>'Geometria di campo',
			'description'=>'Grazie alla geometria di campo il motore a fusione pu&ograve; raggiungere la velocit&agrave; di curvatura 2.',
			'dev_info'=>'',
	    ), // Endof Component Feldgeometrie

		// Component Feldkompression
		2=>array(
			'name'=>'Compressione di campo',
			'description'=>'Grazie alla compressione di campo il motore a fusione pu&ograve; raggiungere la velocit&agrave; di curvatura 3.',
			'dev_info'=>'',
	    ), // Endof Component Feldkompression

		// Component Plasma-Injektion
		3=>array(
			'name'=>'Iniezione di plasma',
			'description'=>'Il motore a fusione viene migliorato grazie ai moderni iniettori di plasma, permettendogli di raggiungere curvatura 4.',
			'dev_info'=>'',
	    ), // Endof Component Plasma-Injektion

		'name'=>'Sezione motori',
		'num'=>'4',
	), // Endof Category Antriebssection


	// Category Strahlenwaffen
	2=>array(
		// Component Strahlenemitter
		0=>array(
			'name'=>'Lanciaraggi',
			'description'=>'Il lanciaraggi &egrave; una forma primitiva di phaser che cerca di danneggiare la materia con salve di energia concentrata. Sono inaffidabili e deboli se confrontati con la tecnologia delle altre specie.',
			'dev_info'=>'',
	    ), // Endof Component Strahlenemitter

		// Component Materiepakete
		1=>array(
			'name'=>'Pacchetti di materia',
			'description'=>'I pacchetti di materia sono scagliati dalle bocche di fuoco manualmente ed esplodono al contatto. Causano un danno maggiore rispetto ai lanciaraggi, ma non sono utilizzabili su Trasporti e Colonizzatrici.',
			'dev_info'=>'',
	    ), // Endof Component Materiepakete

		// Component Multifrequenz Strahlen
		2=>array(
			'name'=>'Raggi multifrequenza',
			'description'=>'I raggi multifrequenza sono disgregatori sparati contemporaneamente su diverse frequenze migliorandone efficienza e danno inflitto.',
			'dev_info'=>'',
	    ), // Endof Component Multifrequenz Strahlen

		// Component Subraumleitsystem
		3=>array(
			'name'=>'Condottura subspaziale',
			'description'=>'La condottura subspaziale &egrave; una forma di disgregatore. Colpisce con precisione e infligge danni moderati.',
			'dev_info'=>'',
	    ), // Endof Component Subraumleitsystem

		// Component Micropuls-Strahlen
		4=>array(
			'name'=>'Raggi a micropulsazione',
			'description'=>'I raggi a micropulsazione non riuniscono i singoli impulsi, ma li sparano con un&#146;enorme frequenza in modo da ottenere un ottimo rapporto di precisione sul bersaglio.',
			'dev_info'=>'',
	    ), // Endof Component Micropuls-Strahlen

		// Component Verdichtung
		5=>array(
			'name'=>'Compressione',
			'description'=>'Con questa tecnologia gli ioni sono compressi e pertanto si migliora il grado di efficienza rispetto ai normali disgregatori.',
			'dev_info'=>'',
	    ), // Endof Component Verdichtung

		// Component Ultraemitter
		6=>array(
			'name'=>'Ultraemettitore',
			'description'=>'L&#146;Ultraemettitore &egrave; l&#146;arma pi&ugrave; potente che i Ferengi siano mai riusciti in qualche modo a procurarsi dalle altre culture.',
			'dev_info'=>'',
	    ), // Endof Component Ultraemitter

		'name'=>'Armi leggere',
		'num'=>'7',
	), // Endof Category Strahlenwaffen


	// Category Schwere Waffen
	3=>array(
		// Component Torpedos
		0=>array(
			'name'=>'Siluri',
			'description'=>'I siluri sono semplici armi autopropulse.',
			'dev_info'=>'',
	    ), // Endof Component Torpedos

		// Component Torpedo-Härtung
		1=>array(
			'name'=>'TSiluri rinforzati',
			'description'=>'I siluri rinforzati migliorano le prestazioni dei siluri; di conseguenza sono pi&ugrave; lenti e hanno effetto contro le navi pesanti.',
			'dev_info'=>'',
	    ), // Endof Component Torpedo-Härtung

		// Component Plasmatorpedos
		2=>array(
			'name'=>'Siluri al plasma',
			'description'=>'I siluri al plasma sono una tecnologia rubata ad altre specie; per le prestazioni dei Ferengi sono armi gi&agrave; piuttosto buone.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos

		// Component Plasmatorpedos MKII
		3=>array(
			'name'=>'Siluri al plasma MKII',
			'description'=>'I siluri al plasma sono una tecnologia rubata ad altre specie; per le prestazioni dei Ferengi sono armi gi&agrave; piuttosto buone. La seconda versione &egrave; significativamente pi&ugrave; forte e non ancora obsoleta.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos MKII

		// Component Plasmatorpedos MKIII
		4=>array(
			'name'=>'Siluri al plasma MKIII',
			'description'=>'I siluri al plasma sono una tecnologia rubata ad altre specie; per le prestazioni dei Ferengi sono armi gi&agrave; piuttosto buone.<br>La terza versione permette, tra le altre cose, di bombardare le installazioni sui pianeti.',
			'dev_info'=>'',
	    ), // Endof Component Plasmatorpedos MKIII

		'name'=>'Armi pesanti',
		'num'=>'5',
	), // Endof Category Schwere Waffen


	// Category Verteidigungssysteme
	4=>array(
		// Component Schildemitter
		0=>array(
			'name'=>'Emettitori di scudi',
			'description'=>'Gli emettitori di scudi sono i precursori dei pi&ugrave; noti schermi deflettori; non sono particolarmente affidabili e resistono solo ad alcuni colpi.',
			'dev_info'=>'',
	    ), // Endof Component Schildemitter

		// Component Duranidpanzerung
		1=>array(
			'name'=>'Corazzatura in duranio',
			'description'=>'Corazzatura in duranio rinforza l&#146;integrit&agrave; delle navi Ferengi, in modo da poter resistere pi&ugrave; a lungo in battaglia.',
			'dev_info'=>'',
	    ), // Endof Component Duranidpanzerung

		// Component Integritätsfeld
		2=>array(
			'name'=>'Campo di contenimento',
			'description'=>'Un campo di contenimento non &egrave; nient&#146;altro che il campo utilizzato all&#146;interno delle navi della Federazione. I Ferengi lo usano al posto degli schermi deflettori.',
			'dev_info'=>'',
	    ), // Endof Component Integritätsfeld

		// Component Schildgenerator
		3=>array(
			'name'=>'Generatore di scudo',
			'description'=>'I generatori di scudo sono un po&#146; una variante degli scudi deflettori standard della Federazione.<br>I Ferengi sono riusciti a procurarsi i piani di costruzione dai mercandi del Quadrante Alfa.',
			'dev_info'=>'',
	    ), // Endof Component Schildgenerator

		// Component Phasen-Schilde
		4=>array(
			'name'=>'Scudi a fase',
			'description'=>'Gli scudi a fase sono una tecnologia trafugata dalle navi della Federazione di classe Intrepid.',
			'dev_info'=>'',
	    ), // Endof Component Phasen-Schilde

		'name'=>'Sistemi di difesa',
		'num'=>'5',
	), // Endof Category Verteidigungssysteme


	// Category Computer
	5=>array(
		// Component Zentralrechensystem
		0=>array(
			'name'=>'Computer Centrale',
			'description'=>'Il computer centrale migliora le funzionalit&agrave; del nucleo del computer.',
			'dev_info'=>'',
	    ), // Endof Component Zentralrechensystem

		// Component Linguistik
		1=>array(
			'name'=>'Linguistica',
			'description'=>'La linguistica migliora le funzionalit&agrave; del nucleo del computer.',
			'dev_info'=>'',
	    ), // Endof Component Linguistik

		// Component Duotronik
		2=>array(
			'name'=>'Duotronica',
			'description'=>'La duotronica migliora le funzionalit&agrave; del nucleo del computer.',
			'dev_info'=>'',
	    ), // Endof Component Duotronik

		// Component Isolineare Optik
		3=>array(
			'name'=>'Ottica Isolineare',
			'description'=>'I chip ottici isolineari migliorano le funzionalit&agrave; del nucleo del computer.',
			'dev_info'=>'',
	    ), // Endof Component Isolineare Optik

		// Component Positronik
		4=>array(
			'name'=>'Positronica',
			'description'=>'La positronica  migliora le funzionalit&agrave; del nucleo del computer.',
			'dev_info'=>'',
	    ), // Endof Component Positronik

		'name'=>'Computer',
		'num'=>'5',
	), // Endof Category Computer


	// Category Med-Systeme
	6=>array(
		// Component Metagenik
		0=>array(
			'name'=>'Metagenica',
			'description'=>'La metagenica migliora la situazione igienica a bordo delle navi Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Metagenik

		// Component Klimakontrolle
		1=>array(
			'name'=>'Controllo ambientale',
			'description'=>'Il controllo ambientale controlla la temperatura a bordo delle navi Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Klimakontrolle

		// Component Co² Konverter
		2=>array(
			'name'=>'Convertitore CO&#178;',
			'description'=>'Il convertitore di CO&#178; fa s&igrave; che non ci sia mai carenza di ossigeno.',
			'dev_info'=>'',
	    ), // Endof Component Co² Konverter

		// Component Biofiltration
		3=>array(
			'name'=>'Biofiltri',
			'description'=>'Grazie ai biofiltri si eliminano i virus e i batteri pericolosi.',
			'dev_info'=>'',
	    ), // Endof Component Biofiltration

		'name'=>'Sistemi medici',
		'num'=>'4',
	), // Endof Category Med-Systeme


	// Category Festival-Räume
	7=>array(
		// Component Kleiner Raum
		0=>array(
			'name'=>'Stanza piccola',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Kleiner Raum

		// Component Clubhalle
		1=>array(
			'name'=>'Club',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Clubhalle

		// Component Partyraum
		2=>array(
			'name'=>'Sala per feste',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Partyraum

		// Component Festivalraum
		3=>array(
			'name'=>'Stanza conferenze',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Festivalraum

		// Component Große Halle
		4=>array(
			'name'=>'Grande sala',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Große Halle

		// Component Spielhölle
		5=>array(
			'name'=>'Sala giochi',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Spielhölle

		// Component Kasino
		6=>array(
			'name'=>'Casin&oacute;',
			'description'=>'Le varie stanze per le feste permettono di alloggiare pi&ugrave; Ferengi.',
			'dev_info'=>'',
	    ), // Endof Component Kasino

		'name'=>'Stanze per le feste',
		'num'=>'7',
	), // Endof Category Festival-Räume


	// Category Forschungseinrichtungen
	8=>array(
		// Component Scanner
		0=>array(
			'name'=>'Scanner',
			'description'=>'Semplici scanner che migliorano, di poco, le prestazioni dei sensori.',
			'dev_info'=>'',
	    ), // Endof Component Scanner

		// Component Sensoren
		1=>array(
			'name'=>'Sensori',
			'description'=>'I sensori migliorano la reazione dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Sensoren

		// Component Suchphalanx
		2=>array(
			'name'=>'Falange sensoriale',
			'description'=>'Una falange sensoriale migliora le prestazioni dei sensori e lo stato di allerta della nave.',
			'dev_info'=>'',
	    ), // Endof Component Suchphalanx

		// Component Optronisches Relais
		3=>array(
			'name'=>'Rel&eacute; optronici',
			'description'=>'Un rel&eacute; optronico migliora le prestazioni dei sensori e lo stato di allerta della nave.',
			'dev_info'=>'',
	    ), // Endof Component Optronisches Relais

		// Component Tachionabtastung
		4=>array(
			'name'=>'Campionatore tachionico',
			'description'=>'Il campionatore tachionico &egrave; una tecnoologia rubata dai Ferengi; migliora i sistemi della navi a vari livelli.',
			'dev_info'=>'',
	    ), // Endof Component Tachionabtastung

		// Component Frühwarnphalanx
		5=>array(
			'name'=>'Falange di preavvertimento',
			'description'=>'La falange di preavvertimento &egrave; una tecnologia rubata dai Ferengi; migliora i sistemi della navi a vari livelli.',
			'dev_info'=>'',
	    ), // Endof Component Frühwarnphalanx

		'name'=>'Laboratori di ricerca',
		'num'=>'6',
	), // Endof Category Forschungseinrichtungen


	// Category Verhandlungstisch
	9=>array(
		// Component Prototypen
		0=>array(
			'name'=>'Prototipi',
			'description'=>'I prototipi sono un pacchetto completo di prototipi non testati che forniscono non solo una maggiore velocit&agrave; a curvatura ma anche una migliore capacit&agrave; di reazione.',
			'dev_info'=>'',
	    ), // Endof Component Prototypen

		// Component Subraumspalter
		1=>array(
			'name'=>'Separatore subspaziale',
			'description'=>'Il separatore subspaziale supporta in piccola parte le capacit&agrave; offensive della nave.',
			'dev_info'=>'',
	    ), // Endof Component Subraumspalter

		// Component Biokinetische Ladungen
		2=>array(
			'name'=>'Proiettili biochinetici',
			'description'=>'I proiettili biochinetici sono armi biologiche rubate dai Ferengi ai Cardassiani.',
			'dev_info'=>'',
	    ), // Endof Component Biokinetische Ladungen

		// Component Erwerbsregel 34
		3=>array(
			'name'=>'Regola di acquisizione 34',
			'description'=>'La regola di acquisizione 34 dice: la guerra fa bene agli affari.',
			'dev_info'=>'',
	    ), // Endof Component Erwerbsregel 34

		// Component Schildgitter
		4=>array(
			'name'=>'Emettitori di schermi',
			'description'=>'Gli emettitori di schermi costruiti sulle navi ferengi non sono efficienti come quelli delle altre specie, perch&ecute; agli scienziati mancano le conoscenze per ottimizzarli.',
			'dev_info'=>'',
	    ), // Endof Component Schildgitter

		// Component Schnell wie der Wind
		5=>array(
			'name'=>'Veloce come il vento',
			'description'=>'´&quot;Veloce come il vento&quot; &egrave; una libera traduzione di questo componente. Gli effetti sono diversi, ma il pi&ugrave; interessante &egrave; il miglioramento del fattore curvatura di 2.',
			'dev_info'=>'',
	    ), // Endof Component Schnell wie der Wind

		'name'=>'Tavolo dei negoziati',
		'num'=>'6',
	), // Endof Category Verhandlungstisch


), // Endof Race Ferengi


// Race Borg
6=>array(
), // Endof Race Borg



// Race Q
7=>array(
), // Endof Race Q



// Race Breen
8=>array(
	// Category Waffen
	0=>array(
		// Component Bio-Konverter MK I
		0=>array(
			'name'=>'Bioconvertitore MK I',
			'description'=>'Il bioconvertitore di base consente di produrre energia a costi contenuti, grazie all&#146;insostitubile contributo volontario del nostro popolo.',
			'dev_info'=>'',
	    ), // Endof Component Bio-Konverter MK I

		// Component Bio-Konverter MK II
		1=>array(
			'name'=>'Bioconvertitore MK II',
			'description'=>'Progettata per le navi da guerra, la versione potenziata del bioconvertitore permette di far fronte a fabbisogni energetici pi&ugrave; consistenti, sebbene richieda costi di produzione e impegni volontari leggermente maggiori.',
			'dev_info'=>'',
	    ), // Endof Component Bio-Konverter MK II

		// Component Bio-Konverter MK III
		2=>array(
			'name'=>'Bioconvertitore MK III',
			'description'=>'La versione definitiva del bioconvertitore &egrave; un componente insostituibile della Gor&acute;Taan, l&#146;orgoglio delle nostre navi, poich&eacute; fornisce un discreto contributo al nucleo di curvatura, oltre a sopperire al suo elevato fabbisogno energetico. Non vi &egrave; alcun dubbio che ci&ograve; ne giustifichi sia gli alti costi di produzione che uno spirito di abnegazione ampiamente diffuso.',
			'dev_info'=>'',
	    ), // Endof Component Bio-Konverter MK III

		// Component Parasiten
	   /**  3=>array(
			'name'=>'Parassiti',
			'description'=>'I parassiti sono un&#146;arma di medio livello. In primo luogo i parassiti vengono raccolti in un piccolo contenitore, il quale viene scagliato sulla nave bersaglio. Di conseguenza i piccoli parassiti vengono liberati e iniziano a divorare lo scudo e/o lo scafo dell&#146;avversario.',
			'dev_info'=>'Evtl. ein KLEINER permanenter Schaden, so 1 Punkt alle 5 Minuten oder so...

Bei Treffer Senkung von Geschwindigkeit und Wendigkeit des Geners 

(sagt mir bitte was davon möglich ist!!)',
	    ), // Endof Component Parasiten

		// Component Genänderungsimpuls
		4=>array(
			'name'=>'Impulso a mutazione genetica',
			'description'=>'L&#146;impulso a mutazione genetica &egrave; abbastanza costoso, sebbene possa essere utilizzato a fianco delle navi contro i pianeti. Esso modifica la struttura genetica del DNA o semplicemente la composizione atomica dell&#146;obiettivo, al fine di trasformarlo in qualsiasi prodotto finale (tutto &egrave; possibile, dall&#146;ectoplasma alla dissoluzione completa).',
			'dev_info'=>'Atomare Sensoren müssen installiert sein',
	    ), // Endof Component Genänderungsimpuls

		// Component Fluidgeschützphalanx
		5=>array(
			'name'=>'Cannone liquido a falange',
			'description'=>'Una combinazione di vari cannoni a falange migliora chiaramente l'efficacia del cannone liquido.',
			'dev_info'=>'',
	    ), // Endof Component Fluidgeschützphalanx
*/
		'name'=>'Bioconvertitore',
		'num'=>'3',
	), // Endof Category Waffen


	// Category Außenhaut
	1=>array(
		// Component Nucleo Curvatura MK I
		0=>array(
			'name'=>'Bionucleo di curvatura MK I',
			'description'=>'Il bionucleo di curvatura di base consente a tutte le nostre navi di rendere nota a tutta la galassia la nostra potenza con maggiore alacrit&agrave; e costi irrisori.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo Curvatura MK I

		// Component Nucleo Curvatura MK II
		1=>array(
			'name'=>'Bionucleo di curvatura MK II',
			'description'=>'La versione superiore del bionucleo di curvatura viene utilizzata dalle nostre navi da guerra allo scopo di diffondere la presenza della Confederazione tra le razze imbelli pi&ugrave; velocemente, anche se la sua composizione a base prevalentemente organica prevede l&#146;utilizzo di entusiasti volontari.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo Curvatura MK II

		// Component Nucleo Curvatura MK III
		2=>array(
			'name'=>'Bionucleo di curvatura MK III',
			'description'=>'Questa versione del bionucleo di curvatura viene utilizzata esclusivamente dalle possenti Gor&acute;Taan, allo scopo di compensarne l&#146;eccessiva lentezza. I costi di produzione sono elevati, ma la Confederazione richiede doverosi sacrifici al nostro popolo.',
			'dev_info'=>'',
	    ), // Endof Component Nucleo Curvatura MK III

		'name'=>'Bionucleo di curvatura',
		'num'=>'3',
	), // Endof Category Außenhaut


	// Category Waffendeck I
	2=>array(
		// Component Energiedissipator
		0=>array(
			'name'=>'Dissipatore di energia',
			'description'=>'Il dissipatore di energia &eacute; un componente standard della Gor&acute;Taan, il quale ha sempre avuto un ruolo determinante per l&#146;egemonia della Confederazione sulle razze vili e codarde. Esso sottrae direttamente energia al nucleo di curvatura delle navi nemiche al fine di potenziare gli armamenti della nave sulla quale viene installato.',
			'dev_info'=>'',
	    ), // Endof Component Energiedissipator

		'name'=>'Ponte armi I',
		'num'=>'1',
	), // Endof Category Defensivelemente


	// Category Waffendeck II
	3=>array(
		// Component Basic Launcher
		0=>array(
			'name'=>'Lanciagranate di base',
			'description'=>'Potenziamento elementare per le nostre navi, dagli effetti assai limitati sugli scudi nemici.',
			'dev_info'=>'',
	    ), // Endof Component Basic Launcher

		// Component Verbesserter Launcher
		1=>array(
			'name'=>'Lanciagranate migliorato',
			'description'=>'Miglioramento tecnologico del lanciagranate di base, dagli effetti pi&ugrave; rilevanti.',
			'dev_info'=>'',
	    ), // Endof Component Verbesserter Laucher

		// Component Frequenz Launcher
		2=>array(
			'name'=>'Lanciagranate a frequenza',
			'description'=>'Sviluppo a base organica del lanciagranate, destinato alle agili e veloci Gled Kraan. Gli elevati costi, sia in termini di risorse che di valorosi Breen, sono giustificati dalla notevole potenza di fuoco che esso permette.',
			'dev_info'=>'',
	    ), // Endof Component Frequenz Launcher

		// Component Dual-Frequenz Launcher
		3=>array(
			'name'=>'Doppio lanciagranate a frequenza',
			'description'=>'Sviluppo a base organica del lanciagranate, destinato alle possenti Gor&#acute;Taan. Gli enormi costi, sia in termini di risorse che di valorosi Breen, sono giustificati dalla notevole potenza di fuoco che esso permette.',
			'dev_info'=>'',
	    ), // Endof Component Dual-Frequenz Launcher

		'name'=>'Ponte armi II',
		'num'=>'4',
	), // Endof Category Waffendeck II


	// Category Hülle/Schilde
	4=>array(
		// Component Schilde
		0=>array(
			'name'=>'Scudo',
			'description'=>'Questa &egrave; la forma pi&ugrave; semplice di protezione disponibile per le nostre navi da guerra, richiede costi minimi con risultati relativamente soddisfacenti.',
			'dev_info'=>'',
	    ), // Endof Component Fluidraum-Navigationssystem

		// Component KSA
		1=>array(
			'name'=>'Scudo di fase',
			'description'=>'Kurzsprungantrieb: Diese Technologie ermöglicht es dem Scout Warpsprünge innerhalb eines sehr begrenzten Raumes durchzuführen, wodurch er in der Lage ist, gegnerischen Langstreckengeschossen auszuweichen und sich selbst immer in die günstigste Feuerposition zu bringen.',
			'dev_info'=>'',
	    ), // Endof Component KSA

		// Component Biomassenaustausch
		2=>array(
			'name'=>'Scudo quantico',
			'description'=>'Con lo scambio di biomassa, &egrave; possibile distruggere le navi nemiche.',
			'dev_info'=>'',
	    ), // Endof Component Biomassenaustausch
	    
		3=>array(
			'name'=>'Corazza organica MK I',
			'description'=>'Con lo scambio di biomassa, &egrave; possibile distruggere le navi nemiche.',
			'dev_info'=>'',
		 ),
			
		 4=>array(
			'name'=>'Corazza organica MK II',
			'description'=>'Con lo scambio di biomassa, &egrave; possibile distruggere le navi nemiche.',
			'dev_info'=>'',
		 ),
		 
		 5=>array(
			'name'=>'Corazza organica MK III',
			'description'=>'Con lo scambio di biomassa, &egrave; possibile distruggere le navi nemiche.',
			'dev_info'=>'',
		 ),
			
		'name'=>'Scafo/Scudo',
		'num'=>'6',
	), // Endof Category Hülle/Schilde


	// Category Computersystem
	5=>array(
		// Component Interfaccia Biogenetica MK I
		0=>array(
			'name'=>'Interfaccia Biogenetica MK I',
			'description'=>'Die Fluidraum-Sensoren arbeiten ähnlich wie die Fluidraum-Navigation. Sie können somit effizienter und mit größerer Reichweite scannen, was enorme Vorteile mit sich bringt.',
			'dev_info'=>'',
	    ), // Endof Component Fluidraum-Sensoren

		// Component Atomare Sensoren
		1=>array(
			'name'=>'Interfaccia Biogenetica MK II',
			'description'=>'Die atomaren Sensoren wurden für den Kampf entwickelt. Sie erfassen den genauen Aufbau der Ziele und können somit die verwundbaren Stellen aufzeigen. Aber auch beim Forschen sind sie nützlich um die genaue Zusammensetzung eines Objektes zu bestimmen.',
			'dev_info'=>'',
	    ), // Endof Component Atomare Sensoren

		// Component Erweiterte Schiffsdatenbank
		2=>array(
			'name'=>'Interfaccia Biogenetica MK III',
			'description'=>'Die erweiterte Schiffsdatenbank optimiert die Datenübertragung <i>innerhalb</i> des Schiffes. Auch sind erweiterte und aktuelle Infos über Feindschiffe u.ä. verfügbar.',
			'dev_info'=>'',
	    ), // Endof Component Erweiterte Schiffsdatenbank

		 3=>array(
			'name'=>'Interfaccia Biogenetica MK IV',
			'description'=>'Die erweiterte Schiffsdatenbank optimiert die Datenübertragung <i>innerhalb</i> des Schiffes. Auch sind erweiterte und aktuelle Infos über Feindschiffe u.ä. verfügbar.',
			'dev_info'=>'',
	    ),

		'name'=>'Computersystem',
		'num'=>'4',
	), // Endof Category Informationstechnisches


	// Category Trainingsraum
	6=>array(
		// Component Kampfsimulator MKI
		0=>array(
			'name'=>'Kampfsimulator MKI',
			'description'=>'Der Kortikalalarm ist ein Implantat, welches den Piloten eingesetzt wird und sie mit den Schiffssystemen verbindet. Somit werden Sensoreninfos sofort an den Piloten geleitet und die Aktionen laufen schneller ab.',
			'dev_info'=>'',
	    ), // Endof Component Kortikalalarm

		// Component Kampfsimulator MKII
		1=>array(
			'name'=>'Kampfsimulator MKII',
			'description'=>'Die telepatische Kommunikation wird durch ein spezielles Feld verstärkt, sodass auch Kommunikation zwischen Schiffen in weiterer Entfernung ermöglicht wird. Diese Technik dient zur Verfeinerung von Taktiken sowie zur Aufklärung.',
			'dev_info'=>'',
	    ), // Endof Component Kortikaler Hypertransiver

		// Component Kampfsimulator MKIII
		2=>array(
			'name'=>'Kampfsimulator MKIII',
			'description'=>'Die neurale Regeneration ist ein neu entwickeltes Gerät, dass mit äußerst komplexen Methoden Nervenschäden bei Piloten repariert.  ',
			'dev_info'=>'',
	    ), // Endof Component Neurale Regeneration

		 3=>array(
			'name'=>'Kampfsimulator MKIV',
			'description'=>'Die neurale Regeneration ist ein neu entwickeltes Gerät, dass mit äußerst komplexen Methoden Nervenschäden bei Piloten repariert.  ',
			'dev_info'=>'',
	    ),
	    
	    4=>array(
			'name'=>'Kampfsimulator MKV',
			'description'=>'Die neurale Regeneration ist ein neu entwickeltes Gerät, dass mit äußerst komplexen Methoden Nervenschäden bei Piloten repariert.  ',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Trainingsraum',
		'num'=>'5',
	), // Endof Category Trainingsraum


	// Category Wissenschaftssektion
	7=>array(
		// Component Fluider Torpedo
		0=>array(
			'name'=>'Sensorenstation',
			'description'=>'Diese Waffe ist besonders effektiv gegen schwere Schiffe.',
			'dev_info'=>'',
	    ), // Endof Component Fluider Torpedo

		// Component Erweiterte Sensoren
		1=>array(
			'name'=>'Erweiterte Sensoren',
			'description'=>'Diese Waffe ist besonders effektiv gegen schwere Schiffe.',
			'dev_info'=>'',
	    ), // Endof Component Fluider Torpedo II

		// Component Dual Sensorenstation
		2=>array(
			'name'=>'Dual Sensorenstation',
			'description'=>'Dieses Geschütz feuert einen Strom fluider Plasmateilchen auf das Gegnerschiff. Diese Technologie ist experimentell und kann nur auf den drei Eliteschiffen installiert werden.',
			'dev_info'=>'',
	    ), // Endof Component Fluid-Plasma Geschütz

		// Component TiefenraumScaner
		3=>array(
			'name'=>'TiefenraumScaner',
			'description'=>'Extreme Feuerkraft kombiniert mit dem besten verfügbaren Kühlaggregat ergibt diese zerstörerische Waffe.',
			'dev_info'=>'',
	    ), // Endof Component B-Geschützphalanx

	 /**    // Component Fluidisierungsbombe
		4=>array(
			'name'=>'Fluidisierungsbombe',
			'description'=>'Diese Waffe wurde entwickelt, um Planeten zu zerstören. Sie kann nur auf einem Behemoth eingesetzt werden, da sie eine Menge Energie verbraucht und sehr groß ist.',
			'dev_info'=>'',
	    ), // Endof Component Fluidisierungsbombe
*/
		'name'=>'Wissenschaftssektion',
		'num'=>'4',
	), // Endof Category Schwere Waffen


	// Category  Experimentelles
	8=>array(
		// Component Energieschild
		0=>array(
			'name'=>'Energieschild',
			'description'=>'Die Trägheitsdämpfer verbessern die Flugstabilität durch Generierung eines Trägheitsfeldes, welches die Einwirkung der Gravitationskräfte bei Manövern vermindert.',
			'dev_info'=>'',
	    ), // Endof Component Trägheitsdämpfer

		// Component  Mehrphasen EdS
		1=>array(
			'name'=>'Mehrphasen EdS',
			'description'=>'Speziell auf die Eliteklasse abgestimmte Felder maximieren die Wendigkeit und Reaktion für optimale Ergebnisse.',
			'dev_info'=>'',
	    ), // Endof Component Tinoide Dämpfer

		// Component Bionisches Waffensystem MKI
		2=>array(
			'name'=>'Bionisches Waffensystem MKI',
			'description'=>'Die taktischen Nervenbahnen verbessern die Wahrnehmung der Piloten unserer Schiffe. Somit ist es ein leichtes, Gefahren frühzeitig zu entdecken.',
			'dev_info'=>'',
	    ), // Endof Component Taktische Nervenbahnen

		// Component Bionisches Waffensystem MKII
		3=>array(
			'name'=>'Bionisches Waffensystem MKII',
			'description'=>'Die Bioneurale Symbiose verbindet die Nervenbahnen der Piloten 1:1 mit denen des Schiffs. Dadurch wird leichteres Navigieren ermöglicht, jedoch besteht auf Dauer die Gefahr von Nervenschäden beim Piloten.',
			'dev_info'=>'',
	    ), // Endof Component Bioneurale Symbiose

		// Component  Energidämpfungslauncher
		4=>array(
			'name'=>'Energidämpfungslauncher',
			'description'=>'Durch Verwendung bioneuraler Leitkomponenten konnte die Effektivität erneut verbessert werden, ohne den Energieverbrauch zu erhöhen. Sie sind speziell für die mittelklasse konzipiert.',
			'dev_info'=>'',
	    ), // Endof Component Bioneurale Trägheitsdämpfer

		// Component Erw.Tarnvorrichtung
		5=>array(
			'name'=>'Erw.Tarnvorrichtung',
			'description'=>'Das taktische Nebensystem ist eigentlich eine einfache Zielerweiterung. Jedoch greift es auf Daten aus der Datenbank zurück, was eine gewaltige Steigerung der Feuerkraft zur Folge hat.<br><tt>Benötigt: Erweiterte Schiffsdatenbank</tt>',
			'dev_info'=>'',
	    ), // Endof Component Taktisches Nebensystem

	    
		'name'=>' Experimentelles',
		'num'=>'6',
	), // Endof Category  Experimentelles


	/**  // Category Computerkomponenten
	9=>array(
		// Component Standardinterface
		0=>array(
			'name'=>'Standardinterface',
			'description'=>'Das Interface steuert den Energiefluss im Schiff und ermöglicht die Umverteilung der Energie durch den Piloten.',
			'dev_info'=>'',
	    ), // Endof Component Standardinterface

		// Component Bilineares Interface
		1=>array(
			'name'=>'Bilineares Interface',
			'description'=>'Das bilineare Interface ermöglicht eine höhere Energietransferrate.',
			'dev_info'=>'',
	    ), // Endof Component Bilineares Interface

		// Component Trilineares Interface
		2=>array(
			'name'=>'Trilineares Interface',
			'description'=>'Speziell für den Behemoth und das Kriegsschiff entwickelt, ist dieses Interface extrem günstig und effektiv.',
			'dev_info'=>'',
	    ), // Endof Component Trilineares Interface

		// Component Atomares Interface
		3=>array(
			'name'=>'Atomares Interface',
			'description'=>'Dem Behemoth allein vorbehalten ist das atomare Interface, welches die Schlagkraft des Behemoth stark anhebt und ihn damit in die eindeutige Königsklasse der Schiffe hebt. Dadurch, dass viele Anschlüsse und Komponenten bereits im Schiff installiert sind, konnte die Bauzeit extrem gesenkt werden.',
			'dev_info'=>'',
	    ), // Endof Component Atomares Interface

		// Component Erw. Bilineares Interface
		4=>array(
			'name'=>'Erw. Bilineares Interface',
			'description'=>'Durch Verwendung modifizierter Latinumleiter konnte die Effektivität gesteigert werden.',
			'dev_info'=>'',
	    ), // Endof Component Erw. Bilineares Interface

		'name'=>'Computerkomponenten',
		'num'=>'5',
	), // Endof Category Computerkomponenten
*/

), // Endof Race Breen


// Race Hirogen
9=>array(
	// Category Offensivtechniken
	0=>array(
		// Component Hochenergie Kanonentürme
		0=>array(
			'name'=>'Torrette energetiche ad alto rendimento',
			'description'=>'Questo miglioramento delle torrette energetiche provoca maggiori danni, rispetto alle torrette standard.',
			'dev_info'=>'',
	    ), // Endof Component Hochenergie Kanonentürme

		// Component Plasma-Phaser
		1=>array(
			'name'=>'Phaser al plasma',
			'description'=>'I phaser al plasma migliorano drasticamente i comuni phaser ad impulso. L&#146;unico inconveniente di quest&#146;arma &egrave; l&#146;alto consumo di energia.',
			'dev_info'=>'',
	    ), // Endof Component Plasma-Phaser

		// Component Hochgeschwindigkeits Kanonenturm
		2=>array(
			'name'=>'Torrette ad alta velocit&agrave;',
			'description'=>'Quest&#146;arma &egrave; il sunto delle ricerche precedenti. Questa torre unisce l&#146;alto potere di fuoco all&#146;alta velocit&agrave;, finendo per incrementare considerevolmente gli effetti distruttivi.',
			'dev_info'=>'',
	    ), // Endof Component Hochgeschwindigkeits Kanonenturm

		'name'=>'Tecniche offensive',
		'num'=>'3',
	), // Endof Category Offensivtechniken


	// Category Defensivtechniken
	1=>array(
		// Component Monotanium-Panzerung I
		0=>array(
			'name'=>'Corazza di monotanium I',
			'description'=>'La sostanza di cui &egrave; composta questa corazza incrementa notevolmente la resistenza della nave. Questo metallo &egrave; leggero, resistente ed estremamente economico in termini di consumo energetico.',
			'dev_info'=>'',
	    ), // Endof Component Monotanium-Panzerung I

		// Component Monotanium-Panzerung II
		1=>array(
			'name'=>'Corazza di monotanium II',
			'description'=>'Quest&#146;avanzamento del monotanium incrementa ulteriormente la resistenza dello scafo, oltre che incrementare il costo della nave.',
			'dev_info'=>'',
	    ), // Endof Component Monotanium-Panzerung II

		// Component Monotanium-Panzerung III
		2=>array(
			'name'=>'Corazza di monotanium III',
			'description'=>'Questa &egrave; la versione definitiva della corazza di monotanium. Non solo incrementa l&#146;efficienza delle ricerche precedenti, ma anche il peso dell&#146;armatura. Per questo motivo questa ricerca non pu&ograve; essere installata sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Monotanium-Panzerung III

		// Component Inversionsschilde
		3=>array(
			'name'=>'Scudi a inversione',
			'description'=>'Questi speciali scudi non solo migliorano gli scudi standard, ma rendono la nave difficilmente localizzabile.',
			'dev_info'=>'',
	    ), // Endof Component Inversionsschilde

		// Component Gravitationsschild
		4=>array(
			'name'=>'Scudo gravitazionale',
			'description'=>'Questo scudo a sistema gravitazionale ha un nucleo interno che emette un campo di forza lungo il perimetro di tutta la nave. Questo campo di forza &egrave; in grado di respingere ogni tipo di proiettile.',
			'dev_info'=>'',
	    ), // Endof Component Gravitationsschild

		'name'=>'Tecniche difensive',
		'num'=>'5',
	), // Endof Category Defensivtechniken


	// Category Technik
	2=>array(
		// Component Subnukleonen-Sensoren
		0=>array(
			'name'=>'Sensori subnucleari',
			'description'=>'Questo scanner &egrave; un miglioramento dell&#146;equipaggiamento standard hirogeni.',
			'dev_info'=>'',
	    ), // Endof Component Subnukleonen-Sensoren

		// Component Pirsch-Modus
		1=>array(
			'name'=>'Modalit&agrave; occultamento',
			'description'=>'In modalit&agrave; occultamento le navi hirogeni migliorano la possibilit&agrave; di trovare navi occultate e riducono la probabilit&agrave; di essere scovate.',
			'dev_info'=>'',
	    ), // Endof Component Pirsch-Modus

		// Component Relais-Netz-Verbindung
		2=>array(
			'name'=>'Sniffer di rete',
			'description'=>'Questo dispositivo serve per rintracciare le navi vicine durante una qualsiasi trasmissione dati.',
			'dev_info'=>'',
	    ), // Endof Component Relais-Netz-Verbindung

		// Component Holographischer Sanitäter
		3=>array(
			'name'=>'Medico olografico',
			'description'=>'Questo programma, frutto della tecnologia hirogena, non &egrave; avanzato come quello della federazione, ma adempie alle sue funzioni in modo soddisfacente. Del resto un hirogeni non &egrave; delicato come un federale.',
			'dev_info'=>'',
	    ), // Endof Component Holographischer Sanitäter

		'name'=>'Tecnologie',
		'num'=>'4',
	), // Endof Category Technik


	// Category Decoy-Masken (leicht)
	3=>array(
		// Component Sovereign-Maske
		0=>array(
			'name'=>'Maschera classe Sovereign',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Sovereign-Maske

		// Component Valdore Class
		1=>array(
			'name'=>'Maschera classe Norexan',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Valdore Class

		// Component Vocha-Maske
		2=>array(
			'name'=>'Maschera classe Vorcha',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Vocha-Maske

		// Component Ravekas-Maske
		3=>array(
			'name'=>'Maschera classe Ravekas',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Ravekas-Maske

		// Component Attackship-Maske
		4=>array(
			'name'=>'Maschera nave d&#146;attacco',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Attackship-Maske

		// Component Schw. Verteidiger Maske
		5=>array(
			'name'=>'Maschera difensore pesante',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Schw. Verteidiger Maske

		// Component Raider-Maske
		6=>array(
			'name'=>'Maschera classe Raider',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Raider-Maske

		// Component Hunter-Ship-Maske
		7=>array(
			'name'=>'Maschera nave Hunter',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Hunter-Ship-Maske

		'name'=>'Maschere decoy (leggere)',
		'num'=>'8',
	), // Endof Category Decoy-Masken (leicht)


	// Category Energie
	4=>array(
		// Component Monozyklischer Warp-Kern
		0=>array(
			'name'=>'Nucleo Warp monociclico',
			'description'=>'Questo &egrave; il pi&ugrave; semplice ed economico nucleo energetico.',
			'dev_info'=>'',
	    ), // Endof Component Monozyklischer Warp-Kern

		// Component Dizyklischer Warp-Kern
		1=>array(
			'name'=>'Nucleo Warp biciclico',
			'description'=>'Il nucleo standard degli hirogeni lavora con una matrice biciclica e per questo produce una quantit&agrave; di energia doppia a spese di un maggior consumo delle risorse.',
			'dev_info'=>'',
	    ), // Endof Component Dizyklischer Warp-Kern

		// Component Singularitätskern
		2=>array(
			'name'=>'Nucleo a singolarit&agrave;',
			'description'=>'Questo nucleo di energia &egrave; basato sulla tecnologia dei tunnel spaziali. La spinta avviene come all&#146;interno di un microscopico buco nero. L&#146;energia fornita &egrave; di conseguenza molto alta.',
			'dev_info'=>'',
	    ), // Endof Component Singularitätskern

		'name'=>'Energia',
		'num'=>'3',
	), // Endof Category Energie


	// Category Computersysteme
	5=>array(
		// Component Globe-Standard-Controlsystem
		0=>array(
			'name'=>'Sistema controllo globale I',
			'description'=>'Quasi tutti i processi che servono per governare le navi hirogeni sono pilotati dal sistema di controllo globale.',
			'dev_info'=>'',
	    ), // Endof Component Globe-Standard-Controlsystem

		// Component Globe-Controlsystem v2
		1=>array(
			'name'=>'Sistema controllo globale II',
			'description'=>'Quasi tutti i processi che servono per governare le navi hirogeni sono pilotati dal sistema di controllo globale.',
			'dev_info'=>'',
	    ), // Endof Component Globe-Controlsystem v2

		// Component Globe-Controlsystem v3
		2=>array(
			'name'=>'Sistema controllo globale III',
			'description'=>'Quasi tutti i processi che servono per governare le navi hirogeni sono pilotati dal sistema di controllo globale.',
			'dev_info'=>'',
	    ), // Endof Component Globe-Controlsystem v3

		// Component Globe-Redundant-Control
		3=>array(
			'name'=>'Sistema controllo globale ridondante',
			'description'=>'Quasi tutti i processi che servono per governare le navi hirogeni sono pilotati dal sistema di controllo globale. Il sistema ridondante pu&ograve; persino intervenire sui danni allo scafo della nave e rimodulare gli scudi.',
			'dev_info'=>'',
	    ), // Endof Component Globe-Redundant-Control

		'name'=>'Computer',
		'num'=>'4',
	), // Endof Category Computersysteme


	// Category Experimentelle Holotechnik
	6=>array(
		// Component Holographischer Trainingsraum
		0=>array(
			'name'=>'Palestra olografica',
			'description'=>'Equipaggiando una nave con la palestra olografica &egrave; possibile mantenere l&#146;equipaggio sempre allenato in modo che reagiscono prontamente e con precisione nelle situazioni di pericolo.',
			'dev_info'=>'',
	    ), // Endof Component Holographischer Trainingsraum

		// Component Holographische Tarnung
		1=>array(
			'name'=>'Mimetizzatore olografico',
			'description'=>'Questo mimetizzatore sperimentale consente, alle navi dotate di oloproiettori, di occultarsi. Tuttavia questo consuma una quantit&agrave; ingente di energia.',
			'dev_info'=>'',
	    ), // Endof Component Holographische Tarnung

		// Component Holographisches Reperatursystem
		2=>array(
			'name'=>'Sistema di riparazione olografico',
			'description'=>'Questa applicazione consente, agli oloproiettori esistenti sulla nave, di riparare le crepe che si sono formate nello scafo. Tuttavia questa tecnologia pu&ograve; essere installata solo su navi che gi&agerave dispongano di oloproiettori standard.',
			'dev_info'=>'',
	    ), // Endof Component Holographisches Reperatursystem

		// Component Verb. Holographische Tarnung
		3=>array(
			'name'=>'Mimetizzatore olografico ridondante',
			'description'=>'Questo &egrave; un miglioramento del mimetizzatore olografico. Migliora l&#146;occultamento della nave dimezzandone il consumo energetico.',
			'dev_info'=>'',
	    ), // Endof Component Verb. Holographische Tarnung

		'name'=>'Tecnologie olografiche sperimentali',
		'num'=>'4',
	), // Endof Category Experimentelle Holotechnik


	// Category Schwere Waffensysteme
	7=>array(
		// Component Jäger-Typ Photonentorpedos
		0=>array(
			'name'=>'Siluri fotonici predatori',
			'description'=>'Questi siluri particolari dispongono di pi&ugrave; energia e possiedono due tipi differenti di fuoco. Il primo dirige parte dell&#146;energia ai motori, in modo da poter prendere anche le navi pi&ugrave; veloci; il secondo invece ha maggiori effetto verso le grosse navi.',
			'dev_info'=>'',
	    ), // Endof Component Jäger-Typ Photonentorpedos

		// Component Schläfer-Typ Plasmagranaten
		1=>array(
			'name'=>'Granate stordenti al plasma',
			'description'=>'Queste granate riempite con plasma si possono montare su quasi tutte le navi. Per&ograve; il consumo energetico di tali armi &egrave; notevole.',
			'dev_info'=>'',
	    ), // Endof Component Schläfer-Typ Plasmagranaten

		// Component Reißer-Typ M-A-Granaten
		2=>array(
			'name'=>'Granate Materia-Antimateria',
			'description'=>'Si tratta di un&#146;arma composta da proiettili di materia e proiettili di antimateria. Costoro sono sparati separati (per motivi di sicurezza) dalle torrette sul bersaglio. Quando vanno a segno insieme, reagiscono e sviluppano un effetto esplosivo devastante. Tuttavia per utilizzare quest&#146;arma servono tiratori scelti.',
			'dev_info'=>'',
	    ), // Endof Component Reißer-Typ M-A-Granaten

		// Component PS-Bomben
		3=>array(
			'name'=>'Bomba PS',
			'description'=>'Quest&#146;arma &egrave; molto complessa. Un forte campo di forza viene generato per creare un microscopico buco nero per alcuni istanti sulla griglia. Solo poche navi dispongono dell&#146;energia sufficiente per generare questi campi.<br>Tuttavia la potenza di quest&#146;arma &egrave; incomparabile.',
			'dev_info'=>'',
	    ), // Endof Component PS-Bomben

		'name'=>'Sistemi d&#146;arma pesanti',
		'num'=>'4',
	), // Endof Category Schwere Waffensysteme


	// Category Decoy-Masken (schwer)
	8=>array(
		// Component Prometheus-Maske
		0=>array(
			'name'=>'Maschera classe Prometheus',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Prometheus-Maske

		// Component Scimitar Class-Maske
		1=>array(
			'name'=>'Maschera classe Scimitar',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Scimitar Class-Maske

		// Component QI´yaH-Maske
		2=>array(
			'name'=>'Maschera classe QI&acute;yaH',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component QI´yaH-Maske

		// Component Netel-Maske
		3=>array(
			'name'=>'Maschera classe Netel',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Netel-Maske

		// Component Dreadnought-Maske
		4=>array(
			'name'=>'Maschera classe Dreadnought',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Dreadnought-Maske

		// Component D´Kora-Class-Maske
		5=>array(
			'name'=>'Maschera classe D&acute;Kora',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component D´Kora-Class-Maske

		// Component Behemoth Maske
		6=>array(
			'name'=>'Maschera classe Behemoth',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Behemoth Maske

		// Component Warship-Maske
		7=>array(
			'name'=>'Maschera nave da guerra',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Warship-Maske

		// Component Venatic-Class-Maske
		8=>array(
			'name'=>'Maschera classe Venatic',
			'description'=>'La maschera fornir&agrave; le informazioni della rispettiva classe di navi e ne prender&agrave; la forma. Dal momento che le attrezzature necessarie sono disponibili a bordo della nave, questo aggiornamento richiede soltanto tempo, energia e lavoratori. ATTENZIONE: Questa procedura pu&ograve; essere applicata soltanto una volta.',
			'dev_info'=>'',
	    ), // Endof Component Venatic-Class-Maske

		'name'=>'Maschere decoy (pesanti)',
		'num'=>'9',
	), // Endof Category Decoy-Masken (schwer)


	// Category Antrieb
	9=>array(
		// Component Warpgondeln I
		0=>array(
			'name'=>'Gondole di curvatura I',
			'description'=>'Questi miglioramenti tecnici alle gondole di curvatura migliorano leggermente la velocit&agrave; warp massima.',
			'dev_info'=>'',
	    ), // Endof Component Warpgondeln I

		// Component Warpgondeln II
		1=>array(
			'name'=>'Gondole di curvatura II',
			'description'=>'Questi miglioramenti tecnici alle gondole di curvatura migliorano significativamente la velocit&agrave; warp massima.',
			'dev_info'=>'',
	    ), // Endof Component Warpgondeln II

		// Component Warpgondeln III
		2=>array(
			'name'=>'Gondole di curvatura III',
			'description'=>'Questi miglioramenti tecnici alle gondole di curvatura migliorano decisamente la velocit&agrave; warp massima. Anche la rapidit&agrave; di evasione migliora con queste gondole.',
			'dev_info'=>'',
	    ), // Endof Component Warpgondeln III

		'name'=>'Impulso',
		'num'=>'3',
	), // Endof Category Antrieb


), // Endof Race Hirogen



// Race Krenim
10=>array(
	// Category Energiesysteme
	0=>array(
		// Component  Energiekern
		0=>array(
			'name'=>'Nucleo energetico',
			'description'=>'Il nucleo energetico &egrave; un semplice nucleo di curvatura, basato sulla reazione materia-antimateria, produce una quantit&agrave; limitata di energia.',
			'dev_info'=>'',
	    ), // Endof Component Verb. Standardreaktor

		// Component Quantenmatrix
		1=>array(
			'name'=>'Matrice quantica',
			'description'=>'La matrice quantica &egrave; una tecnologia innovativa sviluppata dagli scenziati Krenim e produce abbastanza energia per un vascello da guerra.',
			'dev_info'=>'',
	    ), // Endof Component Stufe II Verb. Standardreaktor

		// Component Zwillings-Quantenkern
		2=>array(
			'name'=>'Matrice quantica seriale',
			'description'=>'La matrice quantica seriale rappresenta uno sviluppo della precedente tecnologia, capace di migliorare la resa unendo svariati elementi base in una matrice complessa',
			'dev_info'=>'',
	    ), // Endof Component Stufe III Verb.Standardreaktor

		// Component Temporaler Kern
		3=>array(
			'name'=>'Nucleo temporale',
			'description'=>'Questo nucleo energetico &egrave; stato sviluppato dallo scenziato Annorax allo scopo di fornire energia al vascello Gunship per operare il Manipolatore di Flusso.',
			'dev_info'=>'',
	    ), // Endof Component Tetrionreaktor

		'name'=>'Sistemi energetici',
		'num'=>'4',
	), // Endof Category Sala Macchine


	// Category Antriebssysteme
	1=>array(
		// Component Nachbrenner
		0=>array(
			'name'=>'Postbruciatori',
			'description'=>'I postbruciatori non sono il mezzo migliore per la propulsione, inoltre consumano grandi quantit&agrave; di energia.',
			'dev_info'=>'',
	    ), // Endof Component TRX1

		// Component Warpspulen
		1=>array(
			'name'=>'Gondola di curvatura',
			'description'=>'Le gondole di curvatura generano un campo Warp attorno alla nave, permettendo di viaggiare nel subspazio.',
			'dev_info'=>'',
	    ), // Endof Component Warpspulen

		// Component Verb. Plasmaeinspritzung
		2=>array(
			'name'=>'Iniettori di plasma potenziati',
			'description'=>'Gli iniettori di plasma potenziati aumentano la resa delle gondole di curvatura.',
			'dev_info'=>'',
	    ), // Endof Component Verb. Plasmaeinspritzung

		// Component Phasenmodulationsspule
		3=>array(
			'name'=>'Bobine a modulazione di fase',
			'description'=>'Le bobine a modulazione di fase sono un progetto nato per equipaggiare le pi&ugrave; grandi navi da guerra, in sostituzione delle meno efficenti gondole di curvatura.',
			'dev_info'=>'',
	    ), // Endof Component Phasenmodulationsspule
		'name'=>'Sala Macchine',
		'num'=>'4',
	), // Endof Category Antrieb


	// Category Konventionelle Waffen
	2=>array(
		// Component Phaserkanone
		0=>array(
			'name'=>'Cannone phaser',
			'description'=>'Il cannone phaser &egrave; un&#146;arma economica ma dalle scarse capacit&agrave;, basato sul principio del Phased Energy Rectification. Utilizzabile su tutte le navi di basso livello.',
			'dev_info'=>'',
	    ), // Endof Component Phaserkanone

		// Component Phaserphalanx
		1=>array(
			'name'=>'Banchi phaser',
			'description'=>'Il banco phaser &egrave; lo sviluppo del cannone phaser. Una serie di emettitori vengono accoppiati per migliorare precisione e potenza ed ottimizzare il consumo di energia.',
			'dev_info'=>'',
	    ), // Endof Component Phaserphalanx

		// Component Erweitertes Phasergeschütz
		2=>array(
			'name'=>'Estensione phaser',
			'description'=>'Un miglioramento nella tecnologia del cannone phaser, pi&ugrave; potente della precedente versione ma con qualche problema di surriscaldamento, tale da necessitare una maggiore opera di manutenzione.',
			'dev_info'=>'',
	    ), // Endof Component Erweitertes Phasergeschütz

		// Component Disruptorgeschütz
		3=>array(
			'name'=>'Disgregatore',
			'description'=>'Il disgregatore rappresenta un balzo in avanti rispetto alla tecnologia phaser che andr&agrave; a sostituire gradualmente.',
			'dev_info'=>'',
	    ), // Endof Component Disruptorgeschütz

		// Component Schw. Pulsdisruptoren
		4=>array(
			'name'=>'Disgregatore ad impulsi',
			'description'=>'Il disgregatori ad impulsi aumenta il potere distruttivo della prima tecnologia sviluppata in questo campo, aumentando costi di costruzione e consumo di energia.',
			'dev_info'=>'',
	    ), // Endof Component Schw. Pulsdisruptoren

	    5=>array(
			'name'=>'Compressore di particelle',
			'description'=>'Il compressore di particelle si basa sullo stesso principio del disgregatore, con la differenza che il plasma viene ultracompresso prima di essere lanciato sul bersaglio, causando danni ragguardevoli sia allo scafo che agli scudi. Spesso &egrave; sufficente un solo colpo per abbattere le navi minori.',
			'dev_info'=>'',
	    ),
	    
	    6=>array(
			'name'=>'Ultraemettitore',
			'description'=>'Tecnologia ibrida tra il compressore di plasma e il banco phaser: molti compressori vengono accoppiati in serie per moltiplicare il potere distruttivo, a discapito di un enorme impiego di energia.',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Armamento convenzionale',
		'num'=>'7',
	), // Endof Category Leichte Waffen


	// Category Schwere Waffen
	3=>array(
		// Component Fusionstorpedos
		0=>array(
			'name'=>'Siluri a fusione',
			'description'=>'I siluri a fusione sono semplici proiettili con una testata nucleare a fusione. Economici ma poco potenti.',
			'dev_info'=>'',
	    ), // Endof Component Fusionstorpedos

		// Component Photonentorpedos
		1=>array(
			'name'=>'Siluri fotonici',
			'description'=>'Evoluzione nel campo dei siluri, la testata impiegata si basa su una reazione materia-antimateria.',
			'dev_info'=>'',
	    ), // Endof Component Photonentorpedos

		// Component Phasenverschobene Torpedos
		2=>array(
			'name'=>'Siluri transfasici',
			'description'=>'Sviluppo recente della tecnologia Krenim, sono in grado di infliggere danni ingenti alle navi nemiche.',
			'dev_info'=>'',
	    ), // Endof Component Phasenverschobene Torpedos

		// Component Chronotonentorpedos
		3=>array(
			'name'=>'Cronosiluri Mk I',
			'description'=>'I cronosiluri sono basati sulla tecnologia temporale e sono in grado di causare danni devastanti agli scudi e alle corazze delle navi nemiche.',
			'dev_info'=>'',
	    ), // Endof Component Chronotonentorpedos

		 4=>array(
			'name'=>'Cronosiluri Mk II',
			'description'=>'Secondo stadio di sviluppo dei cronosiluri.',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Armamento pesante',
		'num'=>'5',
	), // Endof Category Schwere Waffen


	// Category Defensivmaßnahmen
	4=>array(
		 0=>array(
			'name'=>'Corazza Duranid MK1',
			'description'=>'La corazza Duranid &egrave; una efficace tecnologia di rivestimento per gli scafi delle navi spaziali, che consiste in una lega flessibile ma resistente.',
			'dev_info'=>'',
	    ),
	    
	    1=>array(
			'name'=>'Corazza Duranid MK2',
			'description'=>'La corazza Duranid &egrave; una efficace tecnologia di rivestimento per gli scafi delle navi spaziali, che consiste in una lega flessibile ma resistente.',
			'dev_info'=>'',
	    ),
	    
	    2=>array(
			'name'=>'Corazza a cristalli quantici',
			'description'=>'La corazza a cristalli quantici &egrave; una nuova invenzione dei fisici Krenim, composta da cristalli che si rigenerano automaticamente dopo l&#146;impatto.',
			'dev_info'=>'',
	    ),
	    
	    3=>array(
			'name'=>'Scudi multifrequenza',
			'description'=>'Gli scudi multifrequenza si basano sullo stesso principio dei siluri transfasici, applicato in senso difensivo.',
			'dev_info'=>'',
	    ),
	    
	    4=>array(
			'name'=>'Scudi temporali',
			'description'=>'Questi sono gli scudi pi&ugrave; potenti dei Krenim, basati sulla tecnologia Cronitron.',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Sistemi difensivi',
		'num'=>'5',
	), // Endof Category Hülle/Schilde


	// Category Computerkomponenten
	5=>array(
		// Component Isolineare Systeme
		0=>array(
			'name'=>'Sistema isolineare',
			'description'=>'Il sistema isolineare &egrave; una superata tecnologia Krenim molto semplice ed economica.',
			'dev_info'=>'',
	    ), // Endof Component Isolineare Systeme

		// Component Datenverarbeitung
		1=>array(
			'name'=>'Data processing',
			'description'=>'Le tecnologie di data processing hanno reso possibile una migliore interpretazione delle informazioni ricevute dai sensori, con notevoli vantaggi per l&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Datenverarbeitung

		// Component Quantum-Subsysteme
		2=>array(
			'name'=>'Sottosistemi quantici',
			'description'=>'Parti vitali dei computer di bordo sono state potenziate attraverso l&#146;uso di cristalli quantici.',
			'dev_info'=>'',
	    ), // Endof Component Quantum-Subsysteme

		// Component Quadcore-Prozessoreinheit
		3=>array(
			'name'=>'Processori Multicore',
			'description'=>'Unit&agrave; di calcolo multicore rendono i tempi di elaborazione rapidissimi, a vantaggio della nave stessa.',
			'dev_info'=>'',
	    ), // Endof Component Computersystem Typ IV

		// Component Biotronische Komponenten
		4=>array(
			'name'=>'Componenti biotroniche',
			'description'=>'Le componenti biotroniche impiegano hardware parzialmente biologico, con caratteristiche di velocit&agrave; di calcolo mai sperimentate prima.',
			'dev_info'=>'',
	    ), // Endof Component Biotronische Komponenten
		
		'name'=>'Componenti elettroniche',
		'num'=>'5',
	), // Endof Category Computerkomponenten


	// Category Medizinische Komponenten
	6=>array(
		// Component Sanitäterausbildung
		0=>array(
			'name'=>'Addestramento medico',
			'description'=>'Addestramento di base per tutti i membri dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Sanitäterausbildung
	    
	    1=>array(
			'name'=>'Infermeria di bordo',
			'description'=>'Questa parte della nave viene attrezzata per fornire le necessarie cure mediche per i feriti durante gli scontri.',
			'dev_info'=>'',
	    ),
	    
	    2=>array(
			'name'=>'Postazioni biomediche',
			'description'=>'Le postazioni biomediche sono letti attrezzati con moderne apparecchiature di trattamento che permettono ogni tipo di trattamento necessario senza ricorrere al ricovero su navi ospedali o su strutture planetarie.',
			'dev_info'=>'',
	    ),
	    
	    3=>array(
			'name'=>'Stimolatori neuroattivi',
			'description'=>'Questi stimolatori possono essere applicati a feriti gravi in caso di necessit&agrave; per permettergli di rimanere in azione.',
			'dev_info'=>'',
	    ),
	    
	    4=>array(
			'name'=>'Sezione xenobiologica',
			'description'=>'Questa struttura permette di analizzare e verificare l&#146;adattamento di agenti genetici stranieri alla fisiologia Krenim allo scopo di aumentare le capacit&agrave; dell&#146;equipaggio.',
			'dev_info'=>'',
	    ),

		'name'=>'Componenti mediche',
		'num'=>'5',
	), // Endof Category Medizinische Einrichtungen


	// Category Sekundärkomponenten
	7=>array(
		// Component Vidiianischer Harvester
		0=>array(
			'name'=>'Compartimenti equipaggio migliorati',
			'description'=>'I compartimenti equipaggio sono pi&ugrave; confortevoli e forniscono un supporto al morale dell&#146;equipaggio.',
			'dev_info'=>'',
	    ), // Endof Component Vidiianischer Harvester

		// Component Metaschilde
		1=>array(
			'name'=>'Metascudo',
			'description'=>'Variante degli scudi che aumenta leggermente le caratteristiche difensive della nave.',
			'dev_info'=>'',
	    ), // Endof Component Metaschilde
	    
	    2=>array(
			'name'=>'Area addestramento',
			'description'=>'Le aree addestrative sono fornite di oloemettitori e generatori di gravit&agrave; che permettono all&#146;equipaggio di mantenersi in allenamento.',
			'dev_info'=>'',
	    ),
	    
	    3=>array(
			'name'=>'Disgregatore ad alta frequenza',
			'description'=>'Sviluppo della tecnologia dei Disgregatori, sono tuttavia suscettibili di surriscaldamento.',
			'dev_info'=>'',
	    ),
	    
	    4=>array(
			'name'=>'Laboratorio di bordo',
			'description'=>'Il laboratorio di bordo &egrave; fornito di equipaggiamento di altissimo livello, permettendo maggiore rapidit&agrave; nei compiti di ricerca ed elaborazione dati.',
			'dev_info'=>'',
	    ),
	    
	    5=>array(
			'name'=>'Sistemi per armi pesanti',
			'description'=>'Questo sistema integra le armi pesanti della nave con ulteriori sistemi d&#146;arma di vario tipo ed impiego.',
			'dev_info'=>'',
	    ),

		'name'=>'Componenti secondarie',
		'num'=>'6',
	), // Endof Category Sekundärkomponenten


	// Category Sensorik
	8=>array(
	    0=>array(
			'name'=>'Aggiornamento sensori',
			'description'=>'La portata dei sensori viene aumentata grazie al potenziamento dei sistemi di controllo.',
			'dev_info'=>'',
	    ),
	    
	    1=>array(
			'name'=>'Sensori optronici',
			'description'=>'Tecnologia sensoriale impiegata da una civilt&agrave; soggiogata tempo fa dai Krenim.',
			'dev_info'=>'',
	    ),
	    
	    2=>array(
			'name'=>'Microsonde',
			'description'=>'Microsonde autoreplicanti che viaggiano per la nave aumentando le capacit&agrave; di diagnostica delle anomalie e potenziando la capacit&agrave; di scansione dello spazio profondo.',
			'dev_info'=>'',
	    ),
	    
	    3=>array(
			'name'=>'Cartografia temporale',
			'description'=>'Questo sistema tattico si basa su un database esteso che permette di verificare l&#146;esito delle tattiche impiegabili in una battaglia.',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Sensori',
		'num'=>'4',
	), // Endof Category Sensorik


	// Category Temporale Experimentalkomponenten
	9=>array(
	    0=>array(
			'name'=>'Manipolatore di flusso temporale',
			'description'=>'Questo sistema d&#146;arma viene impiegato solo sulle maggiori navi Krenim, pensata principalmente per il bombardamento dei pianeti.',
			'dev_info'=>'',
	    ),
	    
	    1=>array(
			'name'=>'Mascheramento Croniton',
			'description'=>'Il mascheramento Croniton occulta l&#146;immagine della nave attraverso un cambiamento di fase. Molto efficace e poco costoso in termini di energia impiegata.',
			'dev_info'=>'',
	    ),
	    
	    2=>array(
			'name'=>'Corazzatura transfasica',
			'description'=>'La corazzatura transfasica aumenta notevolmente la resistenza dello scafo.',
			'dev_info'=>'',
	    ),
	    
		'name'=>'Componenti temporali sperimentali',
		'num'=>'3',
	), // Endof Category Temporale Experimentalkomponenten


), // Endof Race Krenim



// Race Kazon
11=>array(
	// Category Waffensysteme I
	0=>array(
		// Component Ionen Kanone Mk II
		0=>array(
			'name'=>'Cannone ionico Mk II',
			'description'=>'Il cannone ionico &egrave; un sistema d&#146;arma sviluppato dai Kazon piuttosto primitivo paragonato ai sistemi costruiti da altre razze. Tuttavia, esso &egrave molto semplice da impiegare e usabile anche sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Kanone Mk II

		// Component Ionen Kanone Mk III
		1=>array(
			'name'=>'Cannone ionico Mk III',
			'description'=>'Il cannone ionico &egrave; un sistema d&#146;arma sviluppato dai Kazon piuttosto primitivo paragonato ai sistemi costruiti da altre razze. Tuttavia, esso &egrave molto semplice da impiegare e usabile anche sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Kanone Mk III

		// Component Ionen Kanone Mk IV
		2=>array(
			'name'=>'Cannone ionico Mk IV',
			'description'=>'Il cannone ionico &egrave; un sistema d&#146;arma sviluppato dai Kazon piuttosto primitivo paragonato ai sistemi costruiti da altre razze. Tuttavia, esso &egrave molto semplice da impiegare e usabile anche sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Kanone Mk IV

		// Component Ionen Kanone Mk V
		3=>array(
			'name'=>'Cannone ionico Mk V',
			'description'=>'Il cannone ionico &egrave; un sistema d&#146;arma sviluppato dai Kazon piuttosto primitivo paragonato ai sistemi costruiti da altre razze. Tuttavia, esso &egrave molto semplice da impiegare e usabile anche sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Kanone Mk V

		// Component Ionen Kanone Mk VI
		4=>array(
			'name'=>'Cannone ionico Mk VI',
			'description'=>'Il cannone ionico &egrave; un sistema d&#146;arma sviluppato dai Kazon piuttosto primitivo paragonato ai sistemi costruiti da altre razze. Tuttavia, esso &egrave molto semplice da impiegare e usabile anche sulle navi pi&ugrave; piccole.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Kanone Mk VI

		'name'=>'Sistemi d&#146;arma I',
		'num'=>'5',
	), // Endof Category Waffensysteme I


	// Category Waffensysteme II
	1=>array(
		// Component Kobalt Sprengköpfe
		0=>array(
			'name'=>'Testate al cobalto',
			'description'=>'Le testate al cobalto sono una variante Kazon dei siluri fotonici. Questo sistema &egrave; piuttosto primitivo e necessita di ulteriori sviluppi.',
			'dev_info'=>'',
	    ), // Endof Component Kobalt Sprengköpfe

		// Component Photonen Torpedos Mk I
		1=>array(
			'name'=>'Siluri fotonici Mk I',
			'description'=>'I siluri fotonici sono stati sviluppati dagli scenziati di molte trib&ugrave; Kazon. Sono molto simili a quelli installati sulla nave della Federazione &quot;Voyager&quot;, del Comandante Janeway, dei quali hanno sperimentato il grande potere distruttivo sulla propria pelle.',
			'dev_info'=>'',
	    ), // Endof Component Photonen Torpedos Mk I

		// Component Photonen Torpedos Mk II
		2=>array(
			'name'=>'Siluri fotonici Mk II',
			'description'=>'I siluri fotonici sono stati sviluppati dagli scenziati di molte trib&ugrave; Kazon. Sono molto simili a quelli installati sulla nave della Federazione &quot;Voyager&quot;, del Comandante Janeway, dei quali hanno sperimentato il grande potere distruttivo sulla propria pelle.',
			'dev_info'=>'',
	    ), // Endof Component Photonen Torpedos Mk II

		'name'=>'Sistemi d&#146;arma II',
		'num'=>'3',
	), // Endof Category Waffensysteme II


	// Category Defensivsysteme
	2=>array(
		// Component Elektrom. Gegenmaßnahmen Mk I
		0=>array(
			'name'=>'Disturbatori elettronici Mk I',
			'description'=>'I distrubatori elettronici riescono a migliorare la resa degli scudi e dei sensori oltre che a garantire una maggiore reattivit&agrave; della nave.',
			'dev_info'=>'',
	    ), // Endof Component Elektrom. Gegenmaßnahmen Mk I

		// Component Elektrom. Gegenmaßnahmen Mk II
		1=>array(
			'name'=>'Disturbatori elettronici Mk II',
			'description'=>'I distrubatori elettronici riescono a migliorare la resa degli scudi e dei sensori oltre che a garantire una maggiore reattivit&agrave; della nave.',
			'dev_info'=>'',
	    ), // Endof Component Elektrom. Gegenmaßnahmen Mk II

		// Component Elektrom. Gegenmaßnahmen Mk III
		2=>array(
			'name'=>'Disturbatori elettronici Mk III',
			'description'=>'Questa versione potenziata dei disturbatori elettronici migliorano la resa degli scudi e dei sensori, conferendo maggiore agilit&agrave;, prontezza e reazione alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Elektrom. Gegenmaßnahmen Mk III

		// Component Kristalline Hüllenlegierung MkI
		3=>array(
			'name'=>'Lega protettiva cristallina MkI',
			'description'=>'Questa lega cristallina viene usata come rivestimento delle corazze standard delle navi e offre una maggiore protezione contro le armi ad energia.',
			'dev_info'=>'Solo contro armi ad energia',
	    ), // Endof Component Kristalline Hüllenlegierung MkI

		// Component Kristalline Hüllenlegierung MkII
		4=>array(
			'name'=>'Lega protettiva cristallina MkII',
			'description'=>'Questa lega cristallina viene usata come rivestimento delle corazze standard delle navi e offre una maggiore protezione contro le armi ad energia.',
			'dev_info'=>'',
	    ), // Endof Component Kristalline Hüllenlegierung MkII

		// Component Abwehr Geschütze
		5=>array(
			'name'=>'Difesa anti-cannone',
			'description'=>'Queste torrette mobili offrono protezione contro siluri e razzi. Inoltre, viene rinforzata l&#146;armatura principale della nave.',
			'dev_info'=>'',
	    ), // Endof Component Abwehr Geschütze

		'name'=>'Sistemi difensivi',
		'num'=>'6',
	), // Endof Category Defensivsysteme


	// Category Kampfunterstützung
	3=>array(
		// Component Multiplex Scanner
		0=>array(
			'name'=>'Scanner multiplex',
			'description'=>'Lo scanner multiplex aumenta la reazione della nave nelle situazioni critiche, migliorando anche la resa dei Sensori.',
			'dev_info'=>'',
	    ), // Endof Component Multiplex Scanner

		// Component Sensorphalanx
		1=>array(
			'name'=>'Falange sensoriale',
			'description'=>'La falange sensoriale aumenta la reazione della nave nelle situazioni critiche, migliorando anche la resa dei sensori.',
			'dev_info'=>'',
	    ), // Endof Component Sensorphalanx

		// Component Sensor Matrix Mk I
		2=>array(
			'name'=>'Matrice sensoriale Mk I',
			'description'=>'Con la matrice sensoriale tutte le azioni di una flotta vengono coordinate da un unico sistema centrale. I sensori delle navi vengono collegati ai sensori delle Warships.',
			'dev_info'=>'',
	    ), // Endof Component Sensor Matrix Mk I

		// Component Sensor Matrix Mk II
		3=>array(
			'name'=>'Matrice sensoriale Mk II',
			'description'=>'Con la matrice sensoriale tutte le azioni di una flotta vengono coordinate da un unico sistema centrale. I sensori delle navi vengono collegati ai sensori delle Predators.',
			'dev_info'=>'',
	    ), // Endof Component Sensor Matrix Mk II

		'name'=>'Supporto tattico',
		'num'=>'4',
	), // Endof Category Kampfunterstützung


	// Category Schilde
	4=>array(
		// Component Schildgenerator MK I
		0=>array(
			'name'=>'Generatore di scudi MK I',
			'description'=>'I generatori di scudi sono una tecnologia nuova per i Kazon. I progetti sono derivati da quelli Ferengi, dopo che per lungo tempo i Kazon hanno tentato di impadronirsi dei progetti Federali.',
			'dev_info'=>'',
	    ), // Endof Component Schildgenerator MK I

		// Component Schildgenerator MK II
		1=>array(
			'name'=>'Generatore di scudi MK II',
			'description'=>'I generatori di scudi sono una tecnologia nuova per i Kazon. I progetti sono derivati da quelli Ferengi, dopo che per lungo tempo i Kazon hanno tentato di impadronirsi dei progetti Federali.',
			'dev_info'=>'',
	    ), // Endof Component Schildgenerator MK II

		// Component Schildgenerator MK III
		2=>array(
			'name'=>'Generatori di scudi MK III',
			'description'=>'I generatori di scudi sono una tecnologia nuova per i Kazon. I progetti sono derivati da quelli Ferengi, dopo che per lungo tempo i Kazon hanno tentato di impadronirsi dei progetti Federali.',
			'dev_info'=>'',
	    ), // Endof Component Schildgenerator MK III

		// Component Schildgenerator MK IV
		3=>array(
			'name'=>'Generatori di scudi MK IV',
			'description'=>'I generatori di scudi sono una tecnologia nuova per i Kazon. I progetti sono derivati da quelli Ferengi, dopo che per lungo tempo i Kazon hanno tentato di impadronirsi dei progetti Federali.',
			'dev_info'=>'',
	    ), // Endof Component Schildgenerator MK IV

		// Component Regenerative Schilde
		4=>array(
			'name'=>'Scudi rigeneranti',
			'description'=>'Gli scudi rigeneranti sono una tecnologia nuova per i Kazon. I progetti sono derivati da quelli Ferengi, dopo che per lungo tempo i Kazon hanno tentato di impadronirsi dei progetti Federali.',
			'dev_info'=>'',
	    ), // Endof Component Regenerative Schilde

		'name'=>'Scudi',
		'num'=>'5',
	), // Endof Category Schilde


	// Category Computersysteme
	5=>array(
		// Component Computerkern MK I
		0=>array(
			'name'=>'Computer primario MK I',
			'description'=>'Un moderno computer primario generalmente aumenta reazione, agilit&agrave; e prontezza di una nave.',
			'dev_info'=>'',
	    ), // Endof Component Computerkern MK I

		// Component Computerkern MK II
		1=>array(
			'name'=>'Computer primario MK II',
			'description'=>'Un moderno computer primario generalmente aumenta reazione, agilit&agrave; e prontezza di una nave. Questa versione inoltre aumenta l&#146;efficenza dei sistemi d&#146;arma.',
			'dev_info'=>'',
	    ), // Endof Component Computerkern MK II

		// Component Computerkern MK III
		2=>array(
			'name'=>'Computer primario MK III',
			'description'=>'Un moderno computer primario generalmente aumenta reazione, agilit&agrave; e prontezza di una nave. Questo modello inoltre ha una gestione potenziata degli stabilizzatori inerziali, aumentando drasticamente l&#146;agilit&agrave; della nave.',
			'dev_info'=>'',
	    ), // Endof Component Computerkern MK III

		// Component Matrix Computersystem MK I
		3=>array(
			'name'=>'Controllo matrice MK I',
			'description'=>'Un moderno computer primario generalmente aumenta reazione, agilit&agrave; e prontezza di una nave.',
			'dev_info'=>'',
	    ), // Endof Component Matrix Computersystem MK I

		// Component Matrix Computersystem MK II
		4=>array(
			'name'=>'Controllo matrice MK II',
			'description'=>'Un moderno computer primario generalmente aumenta reazione, agilit&agrave; e prontezza di una nave.',
			'dev_info'=>'',
	    ), // Endof Component Matrix Computersystem MK II

		'name'=>'Computer di bordo',
		'num'=>'5',
	), // Endof Category Computersysteme


	// Category Antrieb
	6=>array(
		// Component Antimaterie Antrieb Mk I
		0=>array(
			'name'=>'Motore antimateria Mk I',
			'description'=>'Il motore antimateria &egrave; una nuova tecnologia Kazon, sviluppata per aumentare la rapidit&agrave; negli spostamenti alla ricerca di acqua e altre risorse importanti.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie Antrieb Mk I

		// Component Antimaterie Antrieb Mk II
		1=>array(
			'name'=>'Motore antimateria Mk II',
			'description'=>'Il motore antimateria &egrave; una nuova tecnologia Kazon, sviluppata per aumentare la rapidit&agrave; negli spostamenti alla ricerca di acqua e altre risorse importanti.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie Antrieb Mk II

		// Component Antimaterie Antrieb Mk III
		2=>array(
			'name'=>'Motore antimateria Mk III',
			'description'=>'Il motore antimateria &egrave; una nuova tecnologia Kazon, sviluppata per aumentare la rapidit&agrave; negli spostamenti alla ricerca di acqua e altre risorse importanti.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie Antrieb Mk III

		// Component Antimaterie Antrieb Mk IV
		3=>array(
			'name'=>'Motore antimateria Mk IV',
			'description'=>'Il motore antimateria &egrave; una nuova tecnologia Kazon, sviluppata per aumentare la rapidit&agrave; negli spostamenti alla ricerca di acqua e altre risorse importanti.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie Antrieb Mk IV

		// Component Antimaterie Antrieb Mk V
		4=>array(
			'name'=>'Motore antimateria Mk V',
			'description'=>'Il motore antimateria &egrave; una nuova tecnologia Kazon, sviluppata per aumentare la rapidit&agrave; negli spostamenti alla ricerca di acqua e altre risorse importanti.',
			'dev_info'=>'',
	    ), // Endof Component Antimaterie Antrieb Mk V

		'name'=>'Motori',
		'num'=>'5',
	), // Endof Category Antrieb


	// Category Sala Macchine
	7=>array(
		// Component Warpgenerator LM MK I
		0=>array(
			'name'=>'Generatore Warp LM MK I',
			'description'=>'Il generatore Warp fornisce energia alla nave ed &egrave; piuttosto economico.',
			'dev_info'=>'',
	    ), // Endof Component Warpgenerator LM MK I

		// Component Warpgenerator LM MK II
		1=>array(
			'name'=>'Generatore Warp LM MK II',
			'description'=>'Questa evoluzione del generatore Warp ha una maggiore spinta e fornisce una maggiore quantit&agrave; di energia alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Warpgenerator LM MK II

		// Component Warpgenerator LM MK III
		2=>array(
			'name'=>'Generatore Warp LM MK III',
			'description'=>'Questo &egrave; un ulteriore sviluppo del generatore Warp e fornisce una quantit&agrave; di energia molto superiore alle due precedenti versioni.',
			'dev_info'=>'',
	    ), // Endof Component Warpgenerator LM MK III

		// Component Warpgenerator LM MK IV
		3=>array(
			'name'=>'Generatore Warp LM MK IV',
			'description'=>'Questo stadio di evoluzione del generatore Warp vede incrementare ulteriormente la spinta fornita alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Warpgenerator LM MK IV

		// Component Warpgenerator LM MK V
		4=>array(
			'name'=>'Generatore Warp LM MK V',
			'description'=>'Lo stadio finale di sviluppo del generatore Warp fornisce la maggiore quantit&agrave; possibile di energia e di spinta alla nave.',
			'dev_info'=>'',
	    ), // Endof Component Warpgenerator LM MK V

		'name'=>'Sala macchine',
		'num'=>'5',
	), // Endof Category Sala Macchine


	// Category Ladekapazitäten
	8=>array(
		// Component Alloggi equipaggio I
		0=>array(
			'name'=>'Alloggi equipaggio I',
			'description'=>'Gli alloggi equipaggio permettono di ospitare un maggior numero di truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio I

		// Component Alloggi equipaggio II
		1=>array(
			'name'=>'Alloggi equipaggio II',
			'description'=>'Gli alloggi equipaggio permettono di ospitare un maggior numero di truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio II

		// Component Alloggi equipaggio III
		2=>array(
			'name'=>'Alloggi equipaggio III',
			'description'=>'Gli alloggi equipaggio permettono di ospitare un maggior numero di truppe sulla nave.',
			'dev_info'=>'',
	    ), // Endof Component Alloggi equipaggio III

		// Component Reparatur Roboter Mk I
		3=>array(
			'name'=>'Manutentore robotico Mk I',
			'description'=>'I manutentori robotici riducono il personale essenziale sulla nave, liberando posto per truppe supplementari.',
			'dev_info'=>'',
	    ), // Endof Component Reparatur Roboter Mk I

		// Component Reparatur Roboter MK II
		4=>array(
			'name'=>'Manutentore robotico MK II',
			'description'=>'I manutentori robotici riducono il personale essenziale sulla nave, liberando posto per truppe supplementari.',
			'dev_info'=>'',
	    ), // Endof Component Reparatur Roboter MK II

		// Component Reparatur Roboter MK III
		5=>array(
			'name'=>'Manutentore robotico MK III',
			'description'=>'I manutentori robotici riducono il personale essenziale sulla nave, liberando posto per truppe supplementari.',
			'dev_info'=>'',
	    ), // Endof Component Reparatur Roboter MK III

		// Component Leichte Truppentransporter
		6=>array(
			'name'=>'Trasporto truppe leggero',
			'description'=>'Il trasporto truppe leggero permette di trasportare una quantit&agrave; di truppe superiore.',
			'dev_info'=>'',
	    ), // Endof Component Leichte Truppentransporter

		// Component Mittlere Truppentransporter
		7=>array(
			'name'=>'Trasporto truppe medio',
			'description'=>'Il trasporto truppe medio permette di trasportare una quantit&agrave; di truppe superiore.',
			'dev_info'=>'',
	    ), // Endof Component Mittlere Truppentransporter

		// Component Schwere Truppentransporter
		8=>array(
			'name'=>'Trasporto rruppe pesante',
			'description'=>'Il trasporto truppe pesante permette di trasportare una quantit&agrave; di truppe superiore.',
			'dev_info'=>'',
	    ), // Endof Component Schwere Truppentransporter

		// Component Erweiterter Frachtraum
		9=>array(
			'name'=>'Ampliamento stiva',
			'description'=>'Questa &egrave; la soluzione finale nell&#146;ampliamento delle zone di ricovero per le truppe sulle Warship.',
			'dev_info'=>'',
	    ), // Endof Component Erweiterter Frachtraum

		'name'=>'Capacit&agrave; di carico',
		'num'=>'10',
	), // Endof Category Ladekapazitäten


	// Category Experimentelles
	9=>array(
		// Component Tachyon Sensor
		0=>array(
			'name'=>'Sensori tachionici',
			'description'=>'Il sensore tachionico permette al Predator di diventare parzialmente invisibile.',
			'dev_info'=>'',
	    ), // Endof Component Tachyon Sensor

		// Component Ionen Disperser
		1=>array(
			'name'=>'Proiettore ionico',
			'description'=>'Questo sistema d&#146;arma viene usato efficacemente sulle navi Predator.',
			'dev_info'=>'',
	    ), // Endof Component Ionen Disperser

		// Component Shield Dissector
		2=>array(
			'name'=>'Riduttore di scudi',
			'description'=>'La radiazione gamma di quest&#146;arma scarica gli scudi delle navi avversarie. Normalmente non causa danni allo scafo.',
			'dev_info'=>'',
	    ), // Endof Component Shield Dissector

		'name'=>'Sperimentali',
		'num'=>'3',
	), // Endof Category Experimentelles


), // Endof Race Kazon


); // End of static-components


// Load localized names and descriptions

foreach ($ship_components as $race => $foo1)
{
	foreach ($ship_components[$race] as $category => $foo2)
	{
		$ship_components[$race][$category]['name'] = $ship_components_locale[$race][$category]['name'];

		foreach ($ship_components[$race][$category] as $component => $foo3) 
		{
			$ship_components[$race][$category][$component]['name'] = $ship_components_locale[$race][$category][$component]['name'];
			$ship_components[$race][$category][$component]['description'] = $ship_components_locale[$race][$category][$component]['description'];
		}
	}
}


?>
