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
 * 0 => Identification of the planet
 * 1 => Human life
 * 2 => Natural resources
 * 3 => Description
 * 4 => Examples
 */
 
$PLANETS_TEXT = array(
    'a' => array(
        0 => 'Geo thermische',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planeten dieser Klasse sind sehr klein und felsig, durch intensive vulkanische Aktivit&auml;t bekannt. Diese Aktivit&auml;t s&auml;ttigt die Atmosph&auml;re mit Treibhausgasen, unter Beibehaltung der hohen Temperatur auf der Oberfl&auml;che. Wenn vulkanische Aktivit&auml;t ist, "stirbt" der Planet und ist solange eine Klasse D.',
        4 => 'Gothos'
    ),
    
    'b' => array(
        0 => 'Geomorteus',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planeten dieser Klasse sind recht klein und nahe zu seinem Stern. Diese Planeten sind ungeeignet f&uuml;r das Leben, haben eine d&uuml;nne Atmosph&auml;re aus Helium und Natrium. Die Oberfl&auml;che ist geschmolzen und sehr instabil. Keine Lebensform wurde je auf einem Planeten dieser Art entdeckt.',
        4 => 'Mercury'
    ),
    
    'c' => array(
        0 => 'Geo inaktiv',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Wenn die vulkanische Aktivit&auml;t auf einem Planeten der Klasse A vor&uuml;ber ist, wird er zu einem Geo inaktivem Planeten. Im Wesentlichen tot, haben diese Planeten eine kalte und felsigen Oberfl&auml;che und haben keine geologische Aktivit&auml;t.',
        4 => 'Pluto, Psi 2000'
    ),
    
    'd' => array(
        0 => 'Zwerg',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Diese Planetenklasse besteht der Regel nur aus Planetoiden mit unregelm&auml;ssiger Form aufgrund der Knappheit der Gravitationskraft. Ihre Atmosph&auml;re, falls vorhanden, ist sehr d&uuml;nn. Die Oberfl&auml;che ist aus Silikaten und verschiedenen Metallverbindungen zusammensetzt. Das Leben ist nur durch eine technische Unterst&uuml;tzung und eine Versorgung mit Ressourcen von aussen m&ouml;glich.',
        4 => 'Ceres (Asteroid im Sonnen-System)'
    ),
    
    'e' => array(
        0 => 'Geo Kunststoff',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Mineralien &uuml;berdurchschnittlich',
        3 => 'Planeten dieser Klasse sind &auml;hnlich in der Masse und Entfernung zu seinem Stern wie die Erde und gelten als die Vorl&auml;ufer der F-Klasse Planeten. Der Kern des Planeten ist geschmolzen und sie haben eine verd&uuml;nnten Atmosph&auml;re mit Spuren von Sauerstoff. Das Leben ist durch bescheidene technologische Unterst&uuml;tzung und Bereitstellung von Ressourcen von aussen m&ouml;glich.',
        4 => 'Excalbia'
    ),
    
    'f' => array(
        0 => 'Geo metallisch',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Metall &uuml;berdurchschnittlich',
        3 => 'Planeten dieser Klasse sind &auml;hnlich wie die Erde, Masse und Entfernung von seinem Stern. Ihre Atmosph&auml;re ist sehr sauerstoffreich, aber die Planeten eher jung sind, ist oft die Oberfl&auml;che nicht vollst&auml;ndig verfestigt. &Uuml;berleben auf dem Planeten ist mit ein wenig technologischer Unterst&uuml;tzung m&ouml;glich.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Geo kristallin',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Dilithium &uuml;berdurchschnittlich',
        3 => 'Planeten dieser Klasse sind &auml;hnlich in der Masse wie die Erde. Die Umlaufbahn ist jedoch n&auml;her an ihre Sonne. Ihre Atmosph&auml;re ist im Wesentlichen aus Schwer giftigen Gasen gebildet. Die N&auml;he der Sonne verursacht eine hohe Oberfl&auml;chentemperatur. Das Leben ist nur durch Unterst&uuml;tzung m&ouml;glich.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'W&uuml;ste',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planeten dieser Klasse erreichen nur 10% der Masse der Erde und haben eine Umlaufbahn weit von ihrer Sonne entfernt. Wegen der bisherigen Bildung ist die Oberfl&aul;che noch im geschmolzenen Zustand. Die Atmosph&auml;re ist in erster Linie aus Wasserstoff. &Uuml;berleben auf dem Planeten ist nur m&ouml;glich dank der Lebenserhaltung und den Lieferungen von lebenswichtigen Ressourcen von aussen.',
        4 => '-'
    ),
    
    'i' => array(
        0 => 'Gasf&ouml;rmige &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Gro&szlig;e Pr&auml;senz von Dilithium, knappe Anwesenheit von Mineralien',
        3 => 'Planeten dieser Klasse sind Cluster von Gas mit einem Durchmesser von mehr als 140.000 Kilometer, mit einem metallischen / kristallinen Kern. &Uuml;berleben auf dem Planeten ist nur m&ouml;glich dank der Lebenserhaltung und den Lieferungen von lebenswichtigen Ressourcen von aussen.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Gasf&ouml;rmige Riesen',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Knappe Vorhandensein von Dilithium, hohe Pr&auml;senz von Metall',
        3 => 'Planeten dieser Klasse sind Cluster von Gas mit einem Durchmesser von weniger als 140.000 km. &Uuml;berleben auf dem Planeten ist nur m&ouml;glich dank der Lebenserhaltung und den Lieferungen von lebenswichtigen Ressourcen von aussen.',
        4 => '-'
    ),
    
    'k' => array(
        0 => 'Anpassungsf&auml;hig',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planeten dieser Klasse haben 10% der Masse und eine &auml;hnliche Umlaufbahn der Erde. Die Oberfl&auml;che ist kompakt, aber aufgrund der geringen Schwerkraft, ist es schwer eine Atmosph&auml;re zu halten oder das Wasser fl&uuml;ssigen zu halten. &Uuml;berleben auf dem Planeten ist nur dank der Lebenserhaltung und den Lieferungen von lebenswichtigen Ressourcen von außen m&ouml;glich.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Begrenzt',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planeten dieser Klasse haben felsige und steile Oberfl&auml;chen. Deren Atmosph&auml;re aus Sauerstoff und Argon mit einem hohen Anteil von Kohlendioxid besteht. Die Lebensformen sind auf Pflanzen beschr&auml;nkt. Planet kann mit geringem Aufwand besiedelt werden.',
        4 => 'Indri VIII'
    ),
        
    
    'm' => array(
        0 => 'Terrestische Welt',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planeten dieser Klasse sind &auml;hnlich in der Masse und Entfernung von der Sonne zur Erde. Ihre Atmosph&auml;re ist reich an Sauerstoff-Molek&uuml;hlen (O2, O3) und die Oberfl&auml;che reich an Wasser ist. Ideal Bedingungen f&uuml;r Leben.',
        4 => 'Terra, Vulcan, Quo&acute;nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Planet im Verfall',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Obwohl sie oft vorhanden sind in der &Ouml;kosph&auml;re, k&ouml;nnen die Planeten dieser Klasse nicht ohne unterst&uuml;tzung Leben. Die Oberfl&auml;che ist felsig und erreicht Temperaturen bis zu 500 Kelvin und einem Druck von mehr als 90 Mal dem auf der Erde. Die Atmosph&auml;re ist sehr dicht und besteht aus Kohlendioxid. Das Wasser ist nur in Form von Dampf in dichten Wolken, die den Planeten umgeben vorhanden.',
        4 => 'Venus',
    ),

    'o' => array(
        0 => 'Pelagische',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planeten dieser Klasse sind sehr &auml;hnlich der Erde. Ihre Atmosph&auml;re ist gleich derjenigen der M-Klasse Planeten. Die Oberfl&auml;che ist mit 90% Wasser bedeckt. Ideal f&uuml;r das Leben.',
        4 => 'Pacifica',
    ),

    'p' => array(
        0 => 'Glazial',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => '&Auml;hnlich wie bei den O-Klasse Planeten, werden sie von niedrigen Temperaturen, die das Wasser in dicken Gletscher erstarren lassen gekennzeichnet. Leben in streng polaren Bedingungen ist hier m&ouml;glich.',
        4 => 'Europa, Callisto',
    ),

    'q' => array(
        0 => 'Variabel',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Diese Planeten haben hoch exzentrischen Bahnen, die den Klimawandel auf der Oberfl&auml;che verst&auml;rken',
        4 => '-',
    ),

    's' => array(
        0 => 'Kleine &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Riesige Mengen an Mineralien und Dilithium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster sind auch als Brauner Zwerg bekannt, sie haben einen Durchmesser von zwischen 10 und 50 Millionen Kilometer. Wenn sie gr&ouml;sser sind, w&uuml;rden sie als Sternen klassifiziert werden. Sie generieren enorme Hitze und Schwerkraft und treiben in der Galaxieherum, wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    't' => array(
        0 => 'Gro&szlig;e &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Immensen Vorhandensein von Mineralien und Dilithium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster sind auch als Brauner Zwerg bekannt, einen Durchmesser im Bereich zwischen 50 und 120 Millionen Km. Wenn sie gr&ouml;sser sind, werden sie als Sterne klassifiziert. Generieren enorme Hitze und Schwerkraftund treiben in der Galaxieherum, wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    'x' => array(
        0 => 'Geringf&uuml;gige brennende planet',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planeten dieser Klasse haben eine extrem giftige Atmosph&auml;re. Die Oberfl&auml;che hat eint Temperatur von unter 500 Kelvin. Die Oberfl&auml;che hat Winde mit hoher Geschwindigkeit. Wenige Substanzen sind best&auml;ndig gegen die korrosiven Gase in der Atmosph&auml;re. Das Leben ist nur durch massive Intervention von Terraforming und die Verwendung von betr&auml;chtlichen Ressourcen m&ouml;glich.',
        4 => '-',
    ),

    'y' => array(
        0 => 'Gro&szlig;e brennende planet',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planeten dieser Klasse haben eine extrem giftige Atmosph&auml;re. Die Oberfl&auml;che hat eint Temperatur von unter 500 Kelvin. Die Oberfl&auml;che hat Winde mit hoher Geschwindigkeit. Wenige Substanzen sind best&auml;ndig gegen die korrosiven Gase in der Atmosph&auml;re. Das Leben ist nur durch massive Intervention von Terraforming und die Verwendung von betr&auml;chtlichen Ressourcen m&ouml;glich.',
        4 => '-'
    ),
);

?>
