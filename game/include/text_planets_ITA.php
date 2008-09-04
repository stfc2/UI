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


/*
 * 0 => Heading the planet
 * 1 => Human life
 * 2 => Raw materials
 * 3 => Description
 * 4 => Examples
 */
 
$PLANETS_TEXT = array(
    'a' => array(
        0 => 'Supergigante gassoso',
        1 => 'Impossibile',
        2 => 'Alta presenza di metalli, scarsit&agrave; di minerali',
        3 => 'I pianeti di questa classe sono molto grandi, normalmente tra le 300 e le 1000 volte la massa della Terra, sono situati nella zona fredda della propria stella (a grande distanza da essa). A causa della bassa radiazione solare ed elevata gravit&agrave;, si forma una densa atmosfera di idrogeno.  Le elevate temperature causano il dissiparsi del calore del nucleo ed elevate temperature in superficie. La vita &egrave; possibile solo su stazioni orbitali.',
        4 => 'Giove'
    ),
    
    'b' => array(
        0 => 'Gigante gassoso',
        1 => 'Impossibile',
        2 => 'Alta presenza di metalli, scarsit&agrave; di minerali',
        3 => 'I pianeti di questa classe sono molto grandi, normalmente tra le 10 e le 100 volte la massa della Terra, sono situati nella zona fredda della propria stella (a grande distanza da essa). A causa della bassa radiazione solare ed elevata gravit&agrave;, si forma una densa atmosfera di idrogeno.  Le elevate temperature causano il dissiparsi del calore del nucleo ed elevate temperature in superficie. La vita &egrave; possibile solo su stazioni orbitali.',
        4 => 'Saturno, Nettuno'
    ),
    
    'c' => array(
        0 => 'Pianeta di Classe C',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono simili in massa e distanza dalla propria stella alla Terra, tuttavia a causa di un pesante effetto serra, l&#146;atmosfera e la superficie sono notevolmente caldi, il che rende la presenza dell&#146;acqua possibile al solo stato gassoso. La vita &egrave; possibile solo attraverso un supporto tecnologico ed un rifornimento di risorse dall&#146;esterno.',
        4 => 'Venere'
    ),
    
    'd' => array(
        0 => 'Pianeta di Classe D',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Questa classe planetaria normalmente si applica solo a planetoidi di forma non regolare, dovuta alla scarsit&agrave; della propria forza gravitazionale. La loro atmosfera, se presente, &egrave molto rarefatta. La superficie &egrave; composta di silicati e vari composti metallici. La vita &egrave; possibile solo attraverso un supporto tecnologico ed un rifornimento di risorse dall&#146;esterno.',
        4 => 'Ceres (Asteroide del Sistema Solare)'
    ),
    
    'e' => array(
        0 => 'Pianeta di Classe E',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono simili in massa e distanza dalla propria stella alla Terra e vengono considerati i precursori dei pianeti di classe F conosciuti. Il nucleo del pianeta &egrave; fuso e possiedono una rarefatta atmosfera con tracce di ossigeno. La vita &egrave; possibile attraverso modesti supporto tecnologico e rifornimento di risorse dall&#146;esterno.',
        4 => '-'
    ),
    
    'f' => array(
        0 => 'Pianeta di Classe F',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono simili alla Terra come massa e distanza dalla propria stella. La loro atmosfera &egrave; molto ricca di ossigeno, ma dato che sono pianeti piuttosto giovani, spesso la superficie non si &egrave; completamente solidificata. La sopravvivenza sul pianeta &egrave; possibile con un piccolo supporto tecnologico.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Pianeta di Classe G',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Alta presenza di elementi metallici',
        3 => 'I pianeti di questa classe sono simili alla Terra come massa ma hanno un&#146;orbita pi&ugrave; vicina al proprio sole. La loro atmosfera &egrave; essenzialmente costituita da gas pesanti tossici. La vicinanza del sole provoca un&#146;elevata temperatura in superficie. La vita &egrave; possibile solo mediante supporto vitale.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Pianeta di classe H',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe raggiungono solo il 10% della massa della Terra e hanno un&#146;orbita molto distante dal proprio sole. A causa della loro recente formazione, la superficie risulta ancora fusa o caratterizzata da intensi fenomeni geologici. L&#146;atmosfera &egrave; caratterizzata principalmente da idrogeno. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => 'Gothos'
    ),
    
    'i' => array(
        0 => 'Pianeta di Classe I',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Elevata presenza di dilitio e minerali, scarsit&agrave; di metalli',
        3 => 'I pianeti di questa classe somigliano alla Terra in massa e orbita. La superfice &egrave; costellata di vulcani attivi e l&#146;atmosfera &egrave; ricca di gas tossici. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Pianeta di Classe J',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Enormi depositi di minerali, scarsit&agrave; di metalli e dilitio',
        3 => 'I pianeti di questa classe raggiungono il 10%-100% della massa terrestre. La loro atmosfera composta da gas nobili &egrave; molto rarefatta e la superfice ha un aspetto lunare. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => 'Luna'
    ),
    
    'k' => array(
        0 => 'Pianeta di Classe K',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe hanno il 10% della massa terrestre e un&#146;orbita analoga. La superfice &egrave; compatta ma, a causa della bassa forza gravitazionale, non riescono a trattenere un&#146;atmosfera o a mantenere l&#146;acqua allo stato liquido. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => 'Marte'
    ),
    
    'l' => array(
        0 => 'Pianeta ghiacciato',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Enormi depositi di minerali, scarsit&agrave; di metalli e dilitio',
        3 => 'I pianeti di questa classe hanno il 10% della massa terrestre e un&#146;orbita molto distante dal sole. A causa della distanza dal sole e del nucleo interno compatto e freddo, la superfice e l&#146;intera atmosfera sono perennemente ghiacciati. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => '-'
    ),
        
    
    'm' => array(
        0 => 'Pianeta terrestre',
        1 => 'Possibile',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono in tutto simili alla Terra. La loro atmosfera &egrave; ricca di ossigeno e la superfice ha abbondanti riserve d&#146;acqua. Ideale per la vita.',
        4 => 'Terra, Vulcan, Qo&acute;noS, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Pianeta acquatico',
        1 => 'Possibile',
        2 => 'Moderata presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono molto simili alla Terra. La loro atmosfera &egrave; uguale a quella dei pianeti di Classe M, la superficie &egrave; coperta per il 90% dall&#146;acqua. Ideale per la vita.',
        4 => '-',
    ),
    
    'y' => array(
        0 => 'Pianeta infuocato',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Immense riserve di metalli, minerali e dilitio',
        3 => 'I pianeti di questa classe hanno un&#146;atmosfera estremamente tossica e la temperatura in superfice raramente scendo sotto i 500 gradi Kelvin. I venti di superfice soffiano ad altissima velocit&agrave; e ben poche sostanze resistono ai gas corrosivi in atmosfera. La vita &egrave; possibile solo attraverso massicci interventi di terraforming e l&#146;impiego di ingenti risorse.',
        4 => '-'
    ),
);

?>
