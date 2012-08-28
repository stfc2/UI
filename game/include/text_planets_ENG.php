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
        2 => 'Huge occurrences of metallic elements, hardly minerals',
        3 => 'Planets in this class are very large, usually from 300 to 1000 times the mass of the Earth, and are in the cold zone of its Sun (high range). Due to the low sunlight and high gravity, they form dense atmospheres of hydrogen. The high temperatures cause a nuclear heat dissipation and high surface temperature. Life is possible only in orbital stations.',
        4 => 'Jupiter'
    ),
    
    'b' => array(
        0 => 'Gas-Giant',
        1 => 'Impossible',
        2 => 'High occurrences of metallic elements, hardly dilithium',
        3 => 'Planets in this class are very large, usually from 10 to 100 times the mass of the Earth, and are in the cold zone of its Sun (high range). Due to the low sunlight and high gravity, they form dense atmospheres of hydrogen. The high temperatures cause a nuclear heat dissipation and high surface temperature. Life is possible only in orbital stations.',
        4 => 'Saturn'
    ),
    
    'c' => array(
        0 => 'Class-C-World',
        1 => 'Expensive, but possible',
        2 => 'Low occurrences of metallic elements',
        3 => 'Planets in this class are similar in mass and distance to the Sun to the Earth, its atmosphere and surface, however, is heated up by strong greenhouse so that water for example exists only in the gaseous state. With technical support and supplies from the outside life is possible.',
        4 => 'Venus'
    ),
    
    'd' => array(
        0 => 'Class-D-World',
        1 => 'Expensive, but possible',
        2 => 'High occurrences of metallic elements, hardly dilithium',
        3 => 'This planetary class usually is applied only on planetoid, as they no depending on the size of a regular shape, because their gravity is not sufficient to form a ball. Their atmosphere is, if available, very thin. The surface is composed of silicates and various metal compounds. With technical support and supplies from the outside life is possible.',
        4 => 'Ceres (Asteroid im Sol-System)'
    ),
    
    'e' => array(
        0 => 'Class-E-World',
        1 => 'Possible with technical assistance',
        2 => 'High occurrences of minerals',
        3 => 'Planets of this class are similar in mass and distance from the Sun to the Earth and they are seen as precursors of the various classes according to F. Their core is still molten, they have, however, already a thin atmosphere with oxygen components. With technical support and supplies from the outside life is possible.',
        4 => '-'
    ),
    
    'f' => array(
        0 => 'Class-F-World',
        1 => 'Possible with technical assistance',
        2 => 'High occurrences of dilithium',
        3 => 'Planets of this class are similar in mass and distance from the Sun to the Earth. Their atmosphere is already very rich in oxygen, but due to their low age (about 1 billion years), their surface often is not yet perfectly solidified. Minor technical assistance support life.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Class-G-World',
        1 => 'Possible with technical assistance',
        2 => 'High occurrences of metallic elements',
        3 => 'Planets of this class are about the mass of the Earth, but they are in the hottest zone of the Sun (short distance). Their atmosphere mostly exist but consists of gases and gaseous heavy metals, also oxygen compounds. Strong solar radiation leads to a high surface temperature. With technical assistance life is possible.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Class-H-World',
        1 => 'Expensive, but possible',
        2 => 'High occurrences of dilithium, hardly minerals',
        3 => 'Planets of this class come to about 10% of Earth&grave;s mass and are at a great distance from the Sun (cold zone). Due to their low age, the surface is still molten or is still geologically active. The atmosphere is primarily composed by hydrogen. With technical assistance and supplies from the outside life is possible.',
        4 => 'Gothos'
    ),
    
    'i' => array(
        0 => 'Class-I-World',
        1 => 'Expensive, but possible',
        2 => 'Huge occurrences of dilithium, hardly metals',
        3 => 'Planets of this class are similar in mass and distance from the Sun to the Earth. They have a very active surface full of volcanoes and their atmosphere is very toxic. With technical assistance and supplies from the outside life is possible.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Class-J-World',
        1 => 'Expensive, but possible',
        2 => 'High deposits of mineral elements, hardly metals',
        3 => 'Planets of this class comes about to 10% - 100% of Earth&grave;s mass. Their atmosphere is thin and consists of noble gases the overall appearance is more like a moon. With technical assistance and supplies from the outside life is possible.',
        4 => 'Luna (Earth&grave;s Moon)'
    ),
    
    'k' => array(
        0 => 'Class-K-World',
        1 => 'Possible with technical assistance',
        2 => 'Low occurrences of minerals elements',
        3 => 'Planets of this class comes about to 10% of Earth&grave;s mass and are in the same zone as the Earth. They have a solid surface, but due to their small size, the gravity is not sufficient to form a dense atmosphere, and water to maintain the liquid state. With technical support and supplies from outside life is possible.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Iced-Giant',
        1 => 'Impossible',
        2 => 'Huge deposits of mineral raw materials and hardly dilithium',
        3 => 'Planets of this class comes about to 10% of Earth&grave;s mass, lying in the cold zone. Due to the low power of sun rays and the solid core, the surface is cold and the entire atmosphere is permanently frozen. With huge technical support and heavy supplies from the outside life is possible.',
        4 => 'Uranus, Neptun'
    ),
        
    
    'm' => array(
        0 => 'Terrestrial World',
        1 => 'Possible',
        2 => 'Medium occurrences of all major commodities',
        3 => 'Planets in this class are similar mass and distance from the sun of the Earth. Their atmosphere is rich in oxygen-Mole Cooling (O2, O3) and the surface is rich with water. Lebensbedigungen ideals.',
        4 => 'Terra, Vulcan, Quo&acute;nos, Romulus, Bajor, Cardassia, ...'
    ),
    
    'n' => array(
        0 => 'Water-Planet',
        1 => 'Possible',
        2 => 'Moderate incidence of all major commodities',
        3 => 'Planets in this class are similar mass and distance from the sun of the Earth. Their atmosphere is equal to that of a Class M planet procure, the surface is about far more than 90% with water. An ideal living conditions.',
        4 => '-',
    ),
    
    'y' => array(
        0 => 'Daemon-Planet',
        1 => 'Very expensive, but possible',
        2 => 'Very high resources of all commodities',
        3 => 'Class of this planet are planets or planetoids have an extremely toxic atmosphere and its surface cools very active rarely below 500 Kelvin. The surface winds reach multiple sonic speed and aggressive atmospheric gases can only resist a few substances. With solid technical support and supplies from the outside is life possible.',
        4 => '-'
    ),
);

?>
