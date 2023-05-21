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
        0 => 'Geotermico',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono molto piccoli e rocciosi, caratterizzati da una intensa attivit&agrave; vulcanica. Tale attivit&agrave; satura l&#146;atmosfera con gas serra, mantenendo alta la temperatura in superfice anche se ad elevata distanza dalla stella. Quando l&#146;attivit&agrave; vulcanica si esaurisce, il pianeta "muore", trasformandosi in un classe C.',
        4 => 'Gothos'
    ),
    
    'b' => array(
        0 => 'Geomorteus',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono piuttosto piccoli e localizzati in prossimit&agrave; della propria stella. Pianeti inadatti alla vita, hanno atmosfere rarefatte di elio e sodio. La superficie &egrave; fusa e altamente instabile. Nessuna forma di vita &egrave; mai stata scoperta su questo tipo di pianeta.',
        4 => 'Mercurio'
    ),
    
    'c' => array(
        0 => 'Geoinattivo',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Quando cessano le attivit&agrave; vulcaniche su un pianeta di classe A, questo diventa un pianeta geoinattivo. Essenzialmente morti, questi pianeti hanno una superficie fredda e rocciosa e non hanno attivit&agrave; geologica.',
        4 => 'Plutone, Psi 2000'
    ),
    
    'd' => array(
        0 => 'Nano',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Questa classe planetaria normalmente si applica solo a planetoidi di forma non regolare, dovuta alla scarsit&agrave; della propria forza gravitazionale. La loro atmosfera, se presente, &egrave molto rarefatta. La superficie &egrave; composta di silicati e vari composti metallici. La vita &egrave; possibile solo attraverso un supporto tecnologico ed un rifornimento di risorse dall&#146;esterno.',
        4 => 'Ceres'
    ),
    
    'e' => array(
        0 => 'Geoplastico',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Presenza di metalli e minerali sopra la media',
        3 => 'I pianeti di questa classe sono simili in massa e distanza dalla propria stella alla Terra e vengono considerati i precursori dei pianeti di classe F conosciuti. Il nucleo del pianeta &egrave; fuso e possiedono una rarefatta atmosfera con tracce di ossigeno. La vita &egrave; possibile attraverso modesti supporto tecnologico e rifornimento di risorse dall&#146;esterno.',
        4 => 'Excalbia'
    ),
    
    'f' => array(
        0 => 'Geometallico',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Presenza di metallo e dilitio sopra la media',
        3 => 'I pianeti di questa classe sono simili alla Terra come massa e distanza dalla propria stella. La loro atmosfera &egrave; molto ricca di ossigeno, ma dato che sono pianeti piuttosto giovani, spesso la superficie non si &egrave; completamente solidificata. La sopravvivenza sul pianeta &egrave; possibile con un piccolo supporto tecnologico.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Geocristallino',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Presenza di minerali e dilitio sopra la media',
        3 => 'I pianeti di questa classe sono simili alla Terra come massa ma hanno un&#146;orbita pi&ugrave; vicina al proprio sole. La loro atmosfera &egrave; essenzialmente costituita da gas pesanti tossici. La vicinanza del sole provoca un&#146;elevata temperatura in superficie. La vita &egrave; possibile solo mediante supporto vitale.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Desertico',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Presenza standard di tutte le risorse',
        3 => 'I pianeti di questa classe raggiungono solo il 10% della massa della Terra e hanno un&#146;orbita molto distante dal proprio sole. A causa della loro recente formazione, la superficie risulta ancora fusa o caratterizzata da intensi fenomeni geologici. L&#146;atmosfera &egrave; caratterizzata principalmente da idrogeno. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => 'Gothos'
    ),
    
    'i' => array(
        0 => 'Supergigante gassoso',
        1 => 'Impossibile',
        2 => 'Enorme presenza di dilitio',
        3 => 'I pianeti di questa classe sono ammassi di gas del diametro superiore ai 140.000 km, contenenti un nucleo metallico/cristallino. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Gigante gassoso',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Scarsa presenza di dilitio, alta presenza di metallo',
        3 => 'I pianeti di questa classe sono ammassi di gas del diametro inferiore ai 140.000 km. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => '-'
    ),
    
    'k' => array(
        0 => 'Adattabile',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Presenza standard di tutte le risorse',
        3 => 'I pianeti di questa classe hanno il 10% della massa terrestre e un&#146;orbita analoga. La superfice &egrave; compatta ma, a causa della bassa forza gravitazionale, non riescono a trattenere un&#146;atmosfera o a mantenere l&#146;acqua allo stato liquido. La sopravvivenza sul pianeta &egrave; possibile solo grazie al supporto vitale e rifornimenti di risorse dall&#146;esterno.',
        4 => 'Marte'
    ),
    
    'l' => array(
        0 => 'Marginale',
        1 => 'Richiede minimo intervento di terraforming',
        2 => 'Presenza standard di tutte le risorse',
        3 => 'I pianeti di questa classe hanno superfici rocciose e sterili. La loro atmosfera &egrave; costituita da ossigeno e argon con elevate percentuali di anidride carbonica. Le forme di vita indigene sono limitate a vegetali. Possono essere colonizzati con poco sforzo.',
        4 => 'Indri VIII'
    ),
        
    
    'm' => array(
        0 => 'Pianeta terrestre',
        1 => 'Possibile',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono in tutto simili alla Terra. La loro atmosfera &egrave; ricca di ossigeno e la superfice ha abbondanti riserve d&#146;acqua. Ideale per la vita.',
        4 => 'Terra, Vulcan, Qo&acute;noS, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Pianeta in decadimento',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Nonostante siano spesso presenti nella Ecosfera, i pianeti di questa classe non possono ospitare la vita. La superficie &egrave; rocciosa e raggiunge temperature superiori ai 500 C° e una pressione superiore di 90 volte a quella terrestre. L&#146;atmosfera &egrave; molto densa e composta di diossido di carbonio. L&#146;acqua esiste solo in forma di vapore raccolto in dense nubi che avvolgono il pianeta.',
        4 => 'Venere',
    ),

    'o' => array(
        0 => 'Pelagico',
        1 => 'Possibile',
        2 => 'Media presenza di tutte le risorse',
        3 => 'I pianeti di questa classe sono molto simili alla Terra. La loro atmosfera &egrave; uguale a quella dei pianeti di Classe M, la superficie &egrave; coperta per il 90% dall&#146;acqua. Ideale per la vita.',
        4 => 'Pacifica',
    ),

    'p' => array(
        0 => 'Glaciale',
        1 => 'Possibile',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Simili ai pianeti di classe O, sono caratterizzati da basse temperature che solidificano l&#146;acqua in spessi ghiacciai. La vita acquatica, se presente, &egrave; adattata alla vita in rigidissime condizioni polari estreme.',
        4 => 'Europa, Callisto',
    ),

    'q' => array(
        0 => 'Variabile',
        1 => 'Possibile',
        2 => 'Media presenza di tutte le risorse',
        3 => 'Questi pianeti sono caratterizzati da orbite molto eccentriche che amplificano i cambiamenti climatici sulla superficie.',
        4 => '-',
    ),

    's' => array(
        0 => 'Ultragigante minore',
        1 => 'Impossibile',
        2 => 'Enorme quantit&agrave; di minerali',
        3 => 'Questi enormi ammassi gassosi sono anche noti come nana marrone, hanno un diametro che varia tra i 10 e i 50 milioni di km. Se fossero pi&ugrave; grandi, sarebbero classificati come stelle. Generano calore e forze gravitazionali enormi, capaci di attirare intorno a se un gran numero di satelliti.',
        4 => '-',
    ),

    't' => array(
        0 => 'Ultragigante maggiore',
        1 => 'Impossibile',
        2 => 'Immensa presenza di minerali',
        3 => 'Questi enormi ammassi gassosi sono anche noti come nana marrone, hanno un diametro che varia tra i 50 e i 120 milioni di km. Se fossero pi&ugrave; grandi, sarebbero classificati come stelle. Generano calore e forze gravitazionali enormi, capaci di attirare intorno a se un gran numero di satelliti.',
        4 => '-',
    ),

    'x' => array(
        0 => 'Pianeta infuocato minore',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Enormi riserve di metalli, minerali e dilitio',
        3 => 'I pianeti di questa classe hanno un&#146;atmosfera estremamente tossica e la temperatura in superfice raramente scendo sotto i 500 gradi Kelvin. I venti di superfice soffiano ad altissima velocit&agrave; e ben poche sostanze resistono ai gas corrosivi in atmosfera. La vita &egrave; possibile solo attraverso massicci interventi di terraforming e l&#146;impiego di ingenti risorse.',
        4 => '-',
    ),
    
    'y' => array(
        0 => 'Pianeta infuocato maggiore',
        1 => 'Richiede pesante intervento di terraforming',
        2 => 'Enormi riserve di metalli, minerali e dilitio',
        3 => 'I pianeti di questa classe hanno un&#146;atmosfera estremamente tossica e la temperatura in superfice raramente scendo sotto i 500 gradi Kelvin. I venti di superfice soffiano ad altissima velocit&agrave; e ben poche sostanze resistono ai gas corrosivi in atmosfera. La vita &egrave; possibile solo attraverso massicci interventi di terraforming e l&#146;impiego di ingenti risorse.',
        4 => '-'
    ),
);

?>
