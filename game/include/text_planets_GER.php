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
 * 0 => Bezeichnung des Planeten
 * 1 => menschliches Leben
 * 2 => Rohstoffvorkommen
 * 3 => Beschreibung
 * 4 => Beispiele
 */
 
$PLANETS_TEXT = array(
    'a' => array(
        0 => 'Gas-Supergigant',
        1 => 'Ben&ouml;tigt schweren Eingriff durch Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Diese gewaltigen Planeten k&ouml;nnen das tausendfache der Erdmasse erreichen und liegen meist am Rande eines Sternensystems. Die sehr hohe Gravitation verursacht viele Meteoriteneinschl&auml;ge und unter der dichten Wasserstoffatmosph&auml;re sorgen die extremen Temperaturen f&uuml;r starke St&uuml;rme. Leben ist unter diesen Umst&auml;nden nicht m&ouml;glich und beschr&auml;nkt sich auf Orbitalstationen.',
        4 => 'Jupiter'
    ),
    
    'b' => array(
        0 => 'Gas-Giganten',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planeten der Klasse B sind sehr gross, erreichen oft das hundertfache der Erdmasse und liegen meist am Rande eines Sternensystems. Das Zusammenspiel aus geringer Sonneneinstrahlung und hohen Kerntemperaturen bewirkt ein lebensfeindliches Klima. Lebewesen k&ouml;nnen nur auf Orbitalstationen &uuml;berleben.',
        4 => 'Saturn, Neptun'
    ),
    
    'c' => array(
        0 => 'Geo inaktiv',
        1 => 'Ben&ouml;tigt schweren Eingriff durch Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planeten der Klasse C geh&ouml;ren zu den sogenannten terrestrischen Planeten, &auml;hneln also der Erde, wenn es um Masse und Sonnenabstand geht. Die Atmosph&auml;re ist jedoch meist sehr d&uuml;nn. Mit den entsprechenden technischen M&ouml;glichkeiten und regelm&auml;ssiger Versorgung von aussen, k&ouml;nnen diese Welten jedoch dauerhaft besiedelt werden.',
        4 => 'Venus'
    ),
    
    'd' => array(
        0 => 'Zwerg',
        1 => 'Ben&ouml;tigt schweren Eingriff durch Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planeten dieser Klasse gelten meist nur als Planetoiden, da sie je nach Gr&ouml;&szlig;e keine regelm&auml;&szlig;ige Form besitzen, weil ihre Gravitation nicht ausreicht, um eine Kugel zu bilden. Ihre Atmosph&auml;re ist, wenn vorhanden, sehr d&uuml;nn. Die Oberfl&auml;che besteht aus Silikaten und verschiedenen Metallverbindungen. Mit technischer Unterst&uuml;tzung und Versorgung von au&szlig;en ist Leben m&ouml;glich.',
        4 => 'Ceres (Asteroid im Sonnen-System)'
    ),
    
    'e' => array(
        0 => 'Geo Kunststoff',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Mineralien &uuml;berdurchschnittlich',
        3 => 'Klasse E-Planeten sind terrestrische Welten, deren Entwicklung sich noch in einem recht fr&uuml;hen Stadium befindet. Zwar ist der Kern noch fl&uuml;ssig, doch eine d&uuml;nne Sauerstoff-Stickstoff-Atmosph&auml;re ist bereits vorhanden. Mit einem &uuml;berschaubaren Mass an technologischer Unterst&uuml;tzung, k&ouml;nnen sich Lebewesen auf einer Welt der Klasse E ansiedeln.',
        4 => 'Excalbia'
    ),
    
    'f' => array(
        0 => 'Geo metallisch',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Metall &uuml;berdurchschnittlich',
        3 => '&Auml;hnlich wie die Klasse E, sind auch Planeten der Klasse F nach geologischen Massst&auml;ben noch sehr jung (ca. 1 Milliarde Jahre). Die Atmosph&auml;re ist bereits recht dicht, sauerstoffreich und f&uuml;r die meisten Lebewesen atembar. Jedoch hat die Planetenoberfl&auml;che noch nicht ihre endg&uuml;ltige Form erreicht und es gibt starke tektonische Aktivit&auml;t. Mit einem &uuml;berschaubaren Mass an technologischer Unterst&uuml;zung k&ouml;nnen sich Lebewesen auf einer Welt der Klasse F ansiedeln.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Geo kristallin',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Latinum &uuml;berdurchschnittlich',
        3 => 'Planeten dieser Klasse liegen &auml;usserst dicht an ihrer Sonne, was extrem heisse Oberfl&auml;chentemperaturen und eine bestenfalls winzige Flora und Fauna zur Folge hat. Da in der Atmosph&auml;re, die haupts&auml;chlich aus schweren Gasen und gasf&ouml;rmigen Metallen besteht, jedoch auch Sauerstoffverbindungen existieren, k&ouml;nnen sich Lebewesen hier ansiedelen, wenn sie &uuml;ber ausreichende technische Hilfsmittel verf&uuml;gen.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'W&uuml;ste',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Klasse H-Planeten sind junge Himmelsk&ouml;rper in der kalten Zone eines Sternensystems und kommen auf gerade einmal 10% der Erdmasse. Unterhalb der meist auf Wasserstoff basierenden Atmosph&auml;re, liegt eine tektonisch sehr aktive Oberfl&auml;che. Leben ist nur mit massiver technologischer Unterst&uuml;tzung und einer regelm&auml;ssigen Versorgung m&ouml;glich.',
        4 => 'Pluto'
    ),
    
    'i' => array(
        0 => 'Gasf&ouml;rmige &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Gro&szlig;e Pr&auml;senz von Latinum, knappe Anwesenheit von Mineralien',
        3 => 'Welten der Klasse I haben in etwa dieselbe Masse wie die Erde und liegen auch in einer vergleichbaren Entfernung zu ihrer Sonne. Hohe vulkanische Aktivit&auml;t und eine &auml;usserst toxische Atmosph&auml;re machen sie jedoch sehr lebensfeindlich. Nur mit massiver technologischer Unterst&uuml;tzung und einer regelm&auml;ssigen Versorgung ist &uuml;berhaupt Leben m&ouml;glich.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Gasf&ouml;rmige Riesen',
        1 => 'Ben&ouml;tigt schweren Eingriff durch Terraforming',
        2 => 'Knappe Vorhandensein von Latinum, hohe Pr&auml;senz von Metall',
        3 => 'Klasse J-Welten sind atmosph&auml;renlose und geologisch inaktive Himmelsk&ouml;rper. Die Oberfl&auml;che ist meist von Meteorkratern &uuml;bers&auml;t und völlig karg. Ein &Uuml;berleben ist nur mit starker technologischer Hilfe und einer regelm&auml;ssigen Versorgung zu realisieren.',
        4 => '-'
    ),
    
    'k' => array(
        0 => 'Anpassungsf&auml;hig',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Zwar kommen Welten der Klasse K nur auf etwa 10% der Erdmasse, doch ihr h&ouml;heres geologisches Alter und die daraus resultierende Stabilit&auml;t der Oberfl&auml;che verhindern eine Einstufung als Zwergplanet. Ihre Gravitation ist meist nicht stark genug, um eine dichte Atmosph&auml;re zu bilden und Wasser anders als im eisf&ouml;rmigen Zustand zu halten, mit der entsprechenden Unterst&uuml;tzung und einer regelm&auml;ssigen Versorgung ist jedoch Leben m&ouml;glich.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Eiswelt',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Zwar kommen Welten der Klasse L nur auf etwa 10% der Erdmasse, doch ihr h&ouml;heres geologisches Alter, die daraus resultierende Stabilit&auml;t der Oberfl&auml;che und der gefrorene Kern verhindern eine Einsstufung als Zwergplanet. Die Entfernung zur Sonne ist sehr gross, wodurch Klasse L-Planeten ganzj&auml;hrig von Eis und Schnee bedeckt sind. Mit einer regelm&auml;ssigen Versorgung und etwas technologischer Hilfe ist jedoch Leben m&ouml;glich.',
        4 => 'Indri VIII'
    ),
        
        'm' => array(
        0 => 'Terrestrial Welt',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Welten der Klasse M &auml;hneln der Erde in nahezu jeder Hinsicht. Masse, Sonnenabstand, Zusammensetzung der Atmosph&auml;re und Wasservorkommen; all diese Faktoren sind erd&auml;hnlich und erm&ouml;glichen so ideale Lebensbedingungen.',
        4 => 'Terra, Vulcan, Quo&acute;nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Planet im Verfall',
        1 => 'Ben&ouml;tigt schweren Eingriff durch Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Klasse N-Welten sind in Bezug auf Masse, Sonnenabstand und Atmosph&auml;renzusammensetzung &auml;hnlich beschaffen wie die Erde, jedoch ist ihre Oberfl&auml;che zu mehr als 90% mit Wasser bedeckt. Kontinentale Landmassen gibt es meist nicht, nur einige Inselgruppen, die jedoch Leben in jedweder Form beg&uuml;nstigen.',
        4 => 'Venus',
    ),

    'o' => array(
        0 => 'Gasplanet',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Welten der Klasse O sind die kleinsten unter den Gasriesen (etwa das zwanzig- bis f&uuml;nzigfache der Erdmasse) und liegen meist am Rand eines Sternensystems. Geringe Sonneneinstrahlung und hohe Kerntemperaturen machen ein Leben ausserhalb von Orbitalstationen unm&ouml;glich.',
        4 => 'Pacifica',
    ),

    'p' => array(
        0 => 'Eiswelt',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => '&Auml;hnlich wie bei den O-Klasse Planeten, werden sie von niedrigen Temperaturen, die das Wasser in dicken Gletscher erstarren lassen gekennzeichnet. Leben in &auml;usserst streng polaren Bedingungen ist m&ouml;glich.',
        4 => 'Europa, Callisto',
    ),

    'q' => array(
        0 => 'Terrestrial Welt',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Diese Planeten werden von hoch exzentrischen Bahnen, die den Klimawandel auf der Oberfl&auml;che verst&auml;rken gekennzeichnet.',
        4 => '-',
    ),

    's' => array(
        0 => 'Kleine &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Riesige Mengen an Mineralien und Latinium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster werden auch als Brauner Zwerg bekannt, haben einen Durchmesser von zwischen 10 und 50 Millionen Kilometer. Wenn sie gr&ouml;sser sind, w&uuml;rden sie als Sternen klassifiziert werden. Sie generieren enorme Hitze und Schwerkraft. Treiben durch das Sonnensystem wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    't' => array(
        0 => 'Gro&szlig;e &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Immensen Vorhandensein von Mineralien und Dilithium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster werden auch als Brauner Zwerg bekannt, einen Durchmesser im Bereich zwischen 50 und 120 Millionen Kilometer. Wenn sie gr&ouml;sser sind, w&uuml;rden sie als Sternen klassifiziert werden. Sie generieren enorme Hitze und Schwerkraft. Treiben durch das Sonnensystem wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    'x' => array(
        0 => 'Asteroid',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Der Astroid ist kein Planet im herk&ouml;mmlichen Sinn. Er ist eine Masse aus Stein und Eis die durch das Sonnensytem treibt. Da ein Asteroid keine Atmosph&auml;re hatm ist Leben nur in Orbitalstationen m&ouml;glich.',
        4 => '-',
    ),

    'y' => array(
        0 => 'D&auml;monplanet',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'D&auml;monenplaneten sind die Personifizierung des Wortes "lebensfeindlich". Die Atmosph&auml;re ist &uuml;berdurchschnittlich dicht und mit stark toxischen Gasen durchsetzt, die die meisten bekannten Materialien sofort korrodiert. Die sehr h&auml;ufig auftretenden St&uuml;rme erreichen mehrfache Schallgeschwindigkeit und die durchschnittliche Oberfl&auml;chentemperatur betr&auml;gt rund 230° Celsius. Leben ist nur mit &auml;usserst starker technologischer Unterst&uuml;tzung und einer t&auml;glichen Versorgung m&ouml;glich.',
        4 => '-'
    ),
);

?>
