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
        3 => 'Planets of this class are very small and rocky, marked by intense volcanic activity. This activity saturated the atmosphere with greenhouse gases, while maintaining high temperature on the surface, even if great distance from the star. When volcanic activity is out, the planet "dies", becoming a class D.',
        4 => 'Gothos'
    ),
    
    'b' => array(
        0 => 'Geomorteus',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'Planets of this class are quite small and located in proximity to its star. Planets unfit for life, have a rarefied atmosphere of helium and sodium. The surface is molten and highly unstable. No life form has ever been discovered on this type of planet.',
        4 => 'Mercury'
    ),
    
    'c' => array(
        0 => 'Geo inaktive',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'When volcanic activity on a planet Class A cease, this becomes a planet geo inactive. Essentially dead, these planets have a cold and rocky surface and have no geological activity.',
        4 => 'Pluto, Psi 2000'
    ),
    
    'd' => array(
        0 => 'Zwerg',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Ausgewogene Ressourcen, m&auml&szlig;ge Menge',
        3 => 'This planetary class normally applies only to planetoids with irregular shape due to the scarcity of their gravitational force. Their atmosphere, if present, is very thin. The surface is composed of silicates and various metal compounds. Life is possible only through a technological support and a supply of resources from outside.',
        4 => 'Ceres (Asteroid in Sol-System)'
    ),
    
    'e' => array(
        0 => 'Geo Kunststoff',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Mineralien &uuml;berdurchschnittlich',
        3 => 'Planets of this class are similar in mass and distance from its star to Earth and are considered the precursors of the F class planets known. The core of the planet is molten and have a rarefied atmosphere with traces of oxygen. Life is possible through modest technological support and supply of resources from outside.',
        4 => 'Excalbia'
    ),
    
    'f' => array(
        0 => 'Geo metallisch',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Metall &uuml;berdurchschnittlich',
        3 => 'Planets of this class are similar to the Earth as mass and distance from its star. Their atmosphere is very rich in oxygen, but since they are planets rather young, often the surface is not completely solidified. Survival on the planet is possible with a little technological support.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Geo kristallin',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Anwesenheit von Dilithium &uuml;berdurchschnittlich',
        3 => 'Planets of this class are similar to the Earth as mass but orbit closer to their sun. Their atmosphere is essentially made of heavy toxic gas. The proximity of the sun causes a high surface temperature. Life is possible only through life support.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'W&uuml;ste',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planets of this class only reach 10% of the mass of the Earth and have an orbit far from their sun. Because of their recent formation, the surface is still molten or characterized by intense geological phenomena. The atmosphere is characterized primarily of hydrogen. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => '-'
    ),
    
    'i' => array(
        0 => 'Gasf&ouml;rmige &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Gro&szlig;e Pr&auml;senz von Dilithium, knappe Anwesenheit von Mineralien',
        3 => 'Planets of this class are clusters of gas with a diameter of more than 140,000 kilometers, containing a metallic/crystalline core. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Gasf&ouml;rmige Riesen',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Knappe Vorhandensein von Dilithium, hohe Pr&auml;senz von Metall',
        3 => 'Planets of this class are clusters of gas with a diameter of less than 140,000 km. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => '-'
    ),
    
    'k' => array(
        0 => 'Anpassungsf&auml;hig',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planets of this class have 10% of the Earth&grave;s mass and a similar orbit. The surface is compact but, due to the low gravitational force, fail to retain an atmosphere or to maintain the water in liquid state. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Begrenzt',
        1 => 'Ben&ouml;tigt minimale Intervention von Terraforming',
        2 => 'Handels&uuml;bliche aller Ressourcen',
        3 => 'Planets of this class have rocky and sterile surfaces. Their atmosphere consists of oxygen and argon with high percentages of carbon dioxide. The life forms indigenous are limited to plants. Can be colonized with little effort.',
        4 => 'Indri VIII'
    ),
        
    
    'm' => array(
        0 => 'Terrestrial Welt',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planets of this class are similar in mass and distance from the sun to the Earth. Their atmosphere is rich in oxygen-Mole Cooling (O2, O3) and the surface is rich with water. Ideal settings for Life.',
        4 => 'Terra, Vulcan, Quo&acute;nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Planet im Verfall',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Although they are often present in the Ecosphere, the planets of this class cannot support life. The surface is rocky and reaches temperatures up to 500 C° and a pressure of more than 90 times that on Earth. The atmosphere is very dense and composed of carbon dioxide. The water exists only in the form of vapor collected in dense clouds that surround the planet.',
        4 => 'Venus',
    ),

    'o' => array(
        0 => 'Pelagische',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planets of this class are very similar to Earth. Their atmosphere is equal to that of the M class planets, the surface is covered for 90% by water. Ideal for life.',
        4 => 'Pacifica',
    ),

    'p' => array(
        0 => 'Glazial',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planets similar to the O class, they are characterized by low temperatures that solidify the water in thick glaciers. Aquatic life, if present, is adapted to live in extremely strict polar conditions.',
        4 => 'Europa, Callisto',
    ),

    'q' => array(
        0 => 'Variabel',
        1 => 'm&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'These planets are characterized by highly eccentric orbits that amplify climate change on the surface.',
        4 => '-',
    ),

    's' => array(
        0 => 'Kleine &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Riesige Mengen an Mineralien und Dilithium',
        3 => 'These huge gaseous clusters are also known as brown dwarf, have a diameter of between 10 and 50 million km. If they were larger, would be classified as stars. Generate enormous heat and gravitational forces, capable of attracting around if a large number of satellites.',
        4 => '-',
    ),

    't' => array(
        0 => 'Gro&szlig;e &Uuml;berriesen',
        1 => 'unm&ouml;glich',
        2 => 'Immensen Vorhandensein von Mineralien und Dilithium',
        3 => 'These huge gaseous clusters are also known as brown dwarf, have a diameter ranging between 50 and 120 million km. If they were larger, would be classified as stars. Generate enormous heat and gravitational forces, capable of attracting around if a large number of satellites.',
        4 => '-',
    ),

    'x' => array(
        0 => 'Geringf&uuml;gige brennende planet',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planets of this class have an extremely toxic atmosphere and the surface rarely descend to temperature below 500 Kelvin  degrees. The surface winds blow at high speed and very few substances are resistant to corrosive gases in the atmosphere. Life is possible only through massive intervention of terraforming and the use of considerable resources.',
        4 => '-',
    ),

    'y' => array(
        0 => 'Gro&szlig;e brennende planet',
        1 => 'Ben&ouml;tigt schweren Eingriff Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planets of this class have an extremely toxic atmosphere and the surface rarely descend to temperature below 500 Kelvin  degrees. The surface winds blow at high speed and very few substances are resistant to corrosive gases in the atmosphere. Life is possible only through massive intervention of terraforming and the use of considerable resources.',
        4 => '-'
    ),
);

?>
