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
        0 => 'Gas-Supergiant',
        1 => 'Impossible',
        2 => 'High occurrences of metallic elements, hardly Minerals',
        3 => 'Planets in this class are very large, usually a 300 to 1000 times the mass of the Earth, and are in the cold zone of its Sun (high range). Due to the low sunlight and high gravity, they form dense atmospheres of hydrogen. The high temperatures cause a nuclear heat dissipation and high surface temperature. Life is only possible orbital stations.',
        4 => 'Jupiter'
    ),
    
    'b' => array(
        0 => 'Gas-Giant',
        1 => 'Impossible',
        2 => 'High occurrences of metallic elements, hardly Minerals',
        3 => 'Planets in this class are very large, usually a 10 to 100x mass of the Earth, and are in the cold zone of its Sun (high range). Due to the low sunlight and high gravity, they form dense atmospheres of hydrogen. The high temperatures cause a nuclear heat dissipation and high surface temperature. Life is only possible orbital stations.',
        4 => 'Saturn, Neptun'
    ),
    
    'c' => array(
        0 => 'Class-C-World',
        1 => 'Expensive, but possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planets in this class are similar mass and distance to the sun, the earth, its atmosphere and surface, however, by strong greenhouse heated up, so that water eg Only in the gaseous state exists. With technical support and supplies from the outside is life possible.',
        4 => 'Venus'
    ),
    
    'd' => array(
        0 => 'Class-D-World',
        1 => 'Expensive, but possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'This planetary class usually is applied only on planetoid, as they no depending on the size of a regular shape, because their gravity is not sufficient to form a ball. Their atmosphere is, if available, very thin. The surface is composed of silicates and various metal compounds. With technical support and supplies from the outside is life.',
        4 => 'Ceres (Asteroid im Sol-System)'
    ),
    
    'e' => array(
        0 => 'Class-E-World',
        1 => 'Possible with technical assistance',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planets in this class are similar mass and distance to the sun and the Earth are considered precursors of the various Class F seen. The heart is melted, but they already have a thin atmosphere with oxygen components. With technical support and supplies from the outside is life.',
        4 => '-'
    ),
    
    'f' => array(
        0 => 'Class-F-World',
        1 => 'Possible with technical assistance',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planeten dieser Class ähneln in Masse und Entfernung zur Sonne der Erde. Ihre Atmosphäre ist bereits sehr sauerstoffreich, doch durch ihr geringes Alter (ca. 1 Mrd. Jahre) ist ihre Oberfläche oft noch nicht vollkommen erstarrt. Mit geringer technischer Unterstützung ist Leben möglich.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Class-G-World',
        1 => 'Possible with technical assistance',
        2 => 'High occurrences of metallic elements',
        3 => 'Planeten dieser Class haben ungefähr die Masse der Erde, befinden sich aber in der heißesten Zone der Sonne (geringe Entfernung). Ihre Atmosphäre besteht aus schweren Gasen und gasförmigen Metallen, meistens existieren aber auch noch Sauerstoff-Verbindungen. Die starke Sonneneinstrahlung führt zu einer hohen Oberflächentemperatur. Mit technischer Hilfe ist Leben möglich',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Class-H-World',
        1 => 'Expensive, but possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planten dieser Class kommen auf ungefähr 10% der Erdmasse und liegen in einer großen Entfernung zur Sonne (kalte Zone). Durch ihr geringes Alter ist die Oberfläche noch geschmolzen oder ist immer noch geologisch sehr aktiv. Die Atmosphäre besteht vornehmlich aus Wasserstoff. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => 'Gothos'
    ),
    
    'i' => array(
        0 => 'Class-I-World',
        1 => 'Expensive, but possible',
        2 => 'High occurrences of mineral elements and deutherium, hardly metals',
        3 => 'Planeten dieser Class ähneln in Masse und Entfernung zur Sonne der Erde. Sie haben eine sehr aktive Oberfläche voller Vulkane und ihre Atmosphäre ist stark toxisch. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Class-J-World',
        1 => 'Expensive, but possible',
        2 => 'Huge deposits of mineral elements, metals and hardly dilithium',
        3 => 'Planeten dieser Class kommen auf ungefähr 10%-100% der Erdmasse. Ihre aus Edelgasen bestehende Atmosphäre ist dünn und das gesamte Erscheinungsbild ist eher mondartig. Mit technischer Hilfe und Versorgung von außen ist Leben möglich.',
        4 => 'Luna (Erdmond)'
    ),
    
    'k' => array(
        0 => 'Class-K-World',
        1 => 'Expensive, but possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planeten dieser Class kommen auf ungefähr 10% der Erdmasse und liegen in derselben Zone wie die Erde. Sie haben eine feste Oberfläche, doch durch ihre geringe Größe reicht die Gravitation nicht aus, um eine dichte Atmosphäre zu bilden und Wasser im flüssigen Zustand zu halten. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Eis-Planet',
        1 => 'Possible with technical assistance',
        2 => 'Huge deposits of mineral raw materials, metals and hardly dilithium',
        3 => 'Planeten dieser Class kommen auf ungefähr 10% der Erdmasse und liegen in der kalten Zone. Durch die geringe Sonneneintrahlung und den festen, kalten Kern ist ihre Oberfläche und die gesamte Atmosphäre permanent gefroren. Mit technischer Unterstützung und Versorgung von außen ist Leben möglich.',
        4 => '-'
    ),
        
    
    'm' => array(
        0 => 'Terrestrial World',
        1 => 'Possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planets in this class are similar mass and distance from the sun of the Earth. Their atmosphere is rich in oxygen-Mole Cooling (O2, O3) and the surface is rich with water. Lebensbedigungen ideals.',
        4 => 'Terra, Vulcan, Quo´nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Wasser-Planet',
        1 => 'Possible',
        2 => 'Moderate incidence of all major commodities',
        3 => 'Planets in this class are similar mass and distance from the sun of the Earth. Their atmosphere is equal to that of a Class M planet procure, the surface is about far more than 90% with water. An ideal living conditions.',
        4 => '-',
    ),
    
    'y' => array(
        0 => 'Dämon-Planet',
        1 => 'Very expensive, but possible',
        2 => 'Immense resources of all commodities',
        3 => 'Class of this planet are planets or planetoids have an extremely toxic atmosphere and its surface cools very active rarely below 500 Kelvin. The surface winds reach multiple sonic speed and aggressive atmospheric gases can only resist a few substances. With solid technical support and supplies from the outside is life possible.',
        4 => '-'
    ),
);

?>
