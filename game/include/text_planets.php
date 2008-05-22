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
        1 => 'unmöglich',
        2 => 'hohe Vorkommen metallischer Elemente, kaum Mineralien',
        3 => 'Planeten dieser Klasse sind sehr groß, meistens eine 300 bis 1000fache Masse der Erde, und liegen in der kalten Zone ihrer Sonne (hohe Entfernung). Durch die geringe Sonneneinstrahlung und hohe Gravitation bilden sie dichte Atmosphären aus Wasserstoff. Die hohen Kerntemperaturen verursachen eine Wärmeabstrahlung und eine hohe Oberflächentemperatur. Leben ist nur auf orbitalen Stationen möglich.',
        4 => 'Jupiter'
    ),
    
    'b' => array(
        0 => 'Gas-Giganten',
        1 => 'unmöglich',
        2 => 'hohe Vorkommen metallischer Elemente, kaum Mineralien',
        3 => 'Planeten dieser Klasse sind sehr groß, meistens eine 10 bis 100fache Masse der Erde, und liegen in der kalten Zone ihrer Sonne (hohe Entfernung). Durch die geringe Sonneneinstrahlung und hohe Gravitation bilden sie dichte Atmosphären aus Wasserstoff. Die hohen Kerntemperaturen verursachen eine Wärmeabstrahlung und eine hohe Oberflächentemperatur. Leben ist nur auf orbitalen Stationen möglich.',
        4 => 'Saturn, Neptun'
    ),
    
    'c' => array(
        0 => 'Klasse-C-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffen',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde, ihre Atmosphäre und Oberfläche ist jedoch durch starke Treibhauseffekte aufgeheizt, so dass Wasser z.B. nur im gasförmigen Zustand vorhanden ist. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich',
        4 => 'Venus'
    ),
    
    'd' => array(
        0 => 'Klasse-D-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse gelten meist nur als Planetoiden, da sie je nach Größe keine regelmäßige Form besitzen, weil ihre Gravitation nicht ausreicht, um eine Kugel zu bilden. Ihre Atmosphäre ist, wenn vorhanden, sehr dünn. Die Oberfläche besteht aus Silikaten und verschiedenen Metallverbindungen. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => 'Ceres (Asteroid im Sol-System)'
    ),
    
    'e' => array(
        0 => 'Klasse-E-Welt',
        1 => 'mit technischer Hilfe möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde und werden als Vorläufer der verschiedenen Klassen nach F gesehen. Ihr Kern ist noch geschmolzen, sie besitzen jedoch bereits eine dünne Atmosphäre mit Sauerstoff-Bestandteilen. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => '-'
    ),
    
    'f' => array(
        0 => 'Klasse-F-Welt',
        1 => 'mit technischer Hilfe möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde. Ihre Atmosphäre ist bereits sehr sauerstoffreich, doch durch ihr geringes Alter (ca. 1 Mrd. Jahre) ist ihre Oberfläche oft noch nicht vollkommen erstarrt. Mit geringer technischer Unterstützung ist Leben möglich.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Klasse-G-Welt',
        1 => 'mit technischer Hilfe möglich',
        2 => 'hohe Vorkommen metallischer Elemente',
        3 => 'Planeten dieser Klasse haben ungefähr die Masse der Erde, befinden sich aber in der heißesten Zone der Sonne (geringe Entfernung). Ihre Atmosphäre besteht aus schweren Gasen und gasförmigen Metallen, meistens existieren aber auch noch Sauerstoff-Verbindungen. Die starke Sonneneinstrahlung führt zu einer hohen Oberflächentemperatur. Mit technischer Hilfe ist Leben möglich',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Klasse-H-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planten dieser Klasse kommen auf ungefähr 10% der Erdmasse und liegen in einer großen Entfernung zur Sonne (kalte Zone). Durch ihr geringes Alter ist die Oberfläche noch geschmolzen oder ist immer noch geologisch sehr aktiv. Die Atmosphäre besteht vornehmlich aus Wasserstoff. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => 'Gothos'
    ),
    
    'i' => array(
        0 => 'Klasse-I-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'hohe Vorkommen mineralischer Elemente und Latinum, kaum Metalle',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde. Sie haben eine sehr aktive Oberfläche voller Vulkane und ihre Atmosphäre ist stark toxisch. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Klasse-J-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'enorme Vorkommen mineralischer Elemente, kaum Latinum und Metalle',
        3 => 'Planeten dieser Klasse kommen auf ungefähr 10%-100% der Erdmasse. Ihre aus Edelgasen bestehende Atmosphäre ist dünn und das gesamte Erscheinungsbild ist eher mondartig. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => 'Luna (Erdmond)'
    ),
    
    'k' => array(
        0 => 'Klasse-K-Welt',
        1 => 'aufwändig, aber möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse kommen auf ungefähr 10% der Erdmasse und liegen in derselben Zone wie die Erde. Sie haben eine feste Oberfläche, doch durch ihre geringe Größe reicht die Gravitation nicht aus, um eine dichte Atmosphäre zu bilden und Wasser im flüssigen Zustand zu halten. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Eis-Planet',
        1 => 'mit technischer Hilfe möglch',
        2 => 'enorme Vorkommen mineralischer Rohstoffe, kaum Metalle und Latinum',
        3 => 'Planeten dieser Klasse kommen auf ungefähr 10% der Erdmasse und liegen in der kalten Zone. Durch die geringe Sonneneintrahlung und den festen, kalten Kern ist ihre Oberfläche und die gesamte Atmosphäre permanent gefroren. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => '-'
    ),
        
    
    'm' => array(
        0 => 'Terranische Welt',
        1 => 'möglich',
        2 => 'mittlere Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde. Ihre Atmosphäre ist reich an Sauerstoff-Molekühlen (O2, O3) und die Oberfläche ist reichhaltig mit Wasser bedeckt. Ideale Lebensbedigungen.',
        4 => 'Terra, Vulkan, Quo´nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Wasser-Planet',
        1 => 'möglich',
        2 => 'mäßige Vorkommen aller wichtigen Rohstoffe',
        3 => 'Planeten dieser Klasse ähneln in Masse und Entfernung zur Sonne der Erde. Ihre Atmosphäre ist gleich der eines Klasse-M-Planeten beschaffen, die Oberfläche ist zu weit mehr als 90% mit Wasser bedeckt. Ideale Lebensbedingungen.',
        4 => '-',
    ),
    
    'y' => array(
        0 => 'Dämon-Planet',
        1 => 'sehr aufwändig, aber möglich',
        2 => 'unermeßliche Vorkommen aller Rohstoffe',
        3 => 'Planeten dieser Klasse sind Planeten bzw. Planetoiden haben eine extrem toxische Atmosphäre und ihre sehr aktive Oberfläche kühlt selten unter 500 Kelvin ab. Die Oberflächenwinde erreichen mehrfache Schallgeschwindigkeit und den aggresiven Atmosphären-Gasen können nur wenige Stoffe widerstehen. Mit massiver technischer Unterstützung und Versorgung von außen ist Leben möglich',
        4 => '-'
    ),
);

?>
