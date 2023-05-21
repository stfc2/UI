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
        0 => 'Geothermal',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planets of this class are very small and rocky, marked by intense volcanic activity. This activity saturated the atmosphere with greenhouse gases, while maintaining high temperature on the surface, even if great distance from the star. When volcanic activity is out, the planet "dies", becoming a class C.',
        4 => 'Gothos'
    ),
    
    'b' => array(
        0 => 'Geomorteus',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Planets of this class are quite small and located in proximity to its star. Planets unfit for life, have a rarefied atmosphere of helium and sodium. The surface is molten and highly unstable. No life form has ever been discovered on this type of planet.',
        4 => 'Mercury'
    ),
    
    'c' => array(
        0 => 'Geo inaktiv',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'When volcanic activity on a planet Class A cease, this becomes a planet geo inactive. Essentially dead, these planets have a cold and rocky surface and have no geological activity.',
        4 => 'Pluto, Psi 2000'
    ),
    
    'd' => array(
        0 => 'Zwerg',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'This planetary class normally applies only to planetoids with irregular shape due to the scarcity of their gravitational force. Their atmosphere, if present, is very thin. The surface is composed of silicates and various metal compounds. Life is possible only through a technological support and a supply of resources from outside.',
        4 => 'Ceres (Asteroid im Sonnen-System)'
    ),
    
    'e' => array(
        0 => 'Geoplastik',
        1 => 'Erforderliches Mindestma&szlig; an Terraforming',
        2 => 'Anwesenheit von Mineralien &uuml;ber dem Durchschnitt',
        3 => 'Planets of this class are similar in mass and distance from its star to Earth and are considered the precursors of the F class planets known. The core of the planet is molten and have a rarefied atmosphere with traces of oxygen. Life is possible through modest technological support and supply of resources from outside.',
        4 => 'Excalbia'
    ),
    
    'f' => array(
        0 => 'Geo metallisch',
        1 => 'Erforderliches Mindestma&szlig; an Terraforming',
        2 => 'Anwesenheit von Metall &uuml;ber dem Durchschnitt',
        3 => 'Planets of this class are similar to the Earth as mass and distance from its star. Their atmosphere is very rich in oxygen, but since they are planets rather young, often the surface is not completely solidified. Survival on the planet is possible with a little technological support.',
        4 => '-'
    ),
    
    'g' => array(
        0 => 'Geo kristallin',
        1 => 'Erforderliches Mindestma&szlig; an Terraforming',
        2 => 'Anwesenheit von Dilithium &uuml;ber dem Durchschnitt',
        3 => 'Planets of this class are similar to the Earth as mass but orbit closer to their sun. Their atmosphere is essentially made of heavy toxic gas. The proximity of the sun causes a high surface temperature. Life is possible only through life support.',
        4 => 'Ceti Alpha V'
    ),
    
    'h' => array(
        0 => 'Verlassen',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Planets of this class only reach 10% of the mass of the Earth and have an orbit far from their sun. Because of their recent formation, the surface is still molten or characterized by intense geological phenomena. The atmosphere is characterized primarily of hydrogen. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => '-'
    ),
    
    'i' => array(
        0 => 'Gasf&ouml;rmiger Supergiant',
        1 => 'unm&ouml;glich',
        2 => 'Riesige Pr&auml;senz von Dilithium, seltene Anwesenheit von Mineralien',
        3 => 'Planets of this class are clusters of gas with a diameter of more than 140,000 kilometers, containing a metallic/crystalline core. Survival on the planet is only possible thanks to life support and supplies of vital resources from the outside.',
        4 => '-'
    ),
    
    'j' => array(
        0 => 'Gasf&ouml;rmige Riesen',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Seltene Anwesenheit von Lithium, hohe Anwesenheit von Metall',
        3 => 'Planeten dieser Klasse sind der Durchmesser Gascluster von weniger als 140.000 Kilometer. &Uuml;berleben auf dem Planeten ist nur m&ouml;glich dank der Lebenserhaltung und Lieferungen von externen Ressourcen.',
        4 => '-'
    ),
    
    'k' => array(
        0 => 'Anpassungsf&auml;hig',
        1 => 'Erforderliches Mindestma&szlig; an Terraforming',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Zwar kommen Welten der Klasse K nur auf etwa 10% der Erdmasse, doch ihr h&ouml;heres geologisches Alter und die daraus resultierende Stabilit&auml;t der Oberfl&auml;che verhindern eine Einstufung als Zwergplanet. Ihre Gravitation ist meist nicht stark genug, um eine dichte Atmosph&auml;re zu bilden und Wasser anders als im eisf&ouml;rmigen Zustand zu halten, mit der entsprechenden Unterst&uuml;tzung und einer regelm&auml;ssigen Versorgung ist jedoch Leben m&ouml;glich.',
        4 => 'Mars'
    ),
    
    'l' => array(
        0 => 'Marginal',
        1 => 'Erforderliches Mindestma&szlig; an Terraforming',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Planeten dieser Klasse haben felsige und sterile Oberfl&auml;chen. Ihre Atmosph&auml;re besteht aus Sauerstoff und Argon mit hohen Prozents&auml;tzen an Kohlendioxid. Die Lebensformen indigenen sind auf Pflanzen beschr&auml;nkt. Kann mit wenig Aufwand kolonisiert werden.',
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
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Obwohl sie oft in der &Ouml;kosph&auml;re pr&auml;sent sind, k&ouml;nnen die Planeten dieser Klasse das Leben nicht unterstützen. Die Oberfl&auml;che ist steinig und erreicht Temperaturen bis zu 500 ° C und einen Druck von mehr als 90 Mal so hoch wie auf der Erde. Die Atmosph&auml;re ist sehr dicht und besteht aus Kohlendioxid. Das Wasser existiert nur in Form von Dampf, der in dichten Wolken gesammelt wird, die den Planeten umgeben.',
        4 => 'Venus',
    ),

    'o' => array(
        0 => 'Pelagisch',
        1 => 'm&ouml;glich',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Planeten dieser Klasse sind der Erde sehr &auml;hnlich. Die Atmosph&auml;re ist gleich der der M-Planeten, die Oberfl&auml;che wird zu 90% mit Wasser bedeckt. Ideal f&uuml;r das Leben.',
        4 => 'Pacifica',
    ),

    'p' => array(
        0 => 'Glazial',
        1 => 'M&ouml;glich',
        2 => 'Standardpr&auml;senz aller Ressourcen',
        3 => 'Planeten &auml;hnlich der O-Klasse, sind sie gekennzeichnet durch niedrige Temperaturen, die das Wasser in dicken Gletschern zu verfestigen. Das Wasserleben, wenn vorhanden, ist angepasst, um in extrem strengen polaren Bedingungen zu leben.',
        4 => 'Europa, Callisto',
    ),

    'q' => array(
        0 => 'Terrestrial Welt',
        1 => 'M&ouml;glich',
        2 => 'Durchschnittliche Anzahl aller Ressourcen',
        3 => 'Diese Planeten werden von hoch exzentrischen Bahnen, die den Klimawandel auf der Oberfl&auml;che verst&auml;rken gekennzeichnet.',
        4 => '-',
    ),

    's' => array(
        0 => 'Kleinst ultragiant',
        1 => 'Unm&ouml;glich',
        2 => 'Riesige Mengen an Mineralien und Dilithium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster werden auch als Brauner Zwerg bekannt, haben einen Durchmesser von zwischen 10 und 50 Millionen Kilometer. Wenn sie gr&ouml;sser sind, w&uuml;rden sie als Sternen klassifiziert werden. Sie generieren enorme Hitze und Schwerkraft. Treiben durch das Sonnensystem wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    't' => array(
        0 => 'Gro&szlig;e ultragiant',
        1 => 'Unm&ouml;glich',
        2 => 'Immensen Vorhandensein von Mineralien und Dilithium',
        3 => 'Diese riesigen gasf&ouml;rmigen Cluster werden auch als Brauner Zwerg bekannt, einen Durchmesser im Bereich zwischen 50 und 120 Millionen Kilometer. Wenn sie gr&ouml;sser sind, w&uuml;rden sie als Sternen klassifiziert werden. Sie generieren enorme Hitze und Schwerkraft. Treiben durch das Sonnensystem wie eine grosse Anzahl von Satelliten.',
        4 => '-',
    ),

    'x' => array(
        0 => 'Kleiner brennender Planet',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planeten dieser Klasse haben eine extrem toxische Atmosph&auml;re und die Oberfl&auml;che selten auf Temperatur unter 500 Kelvin Grad absteigen. Die Oberfl&auml;chenwinde blasen mit hoher Geschwindigkeit und sehr wenige Substanzen sind resistent gegen korrosive Gase in der Atmosph&auml;re. Das Leben ist nur durch massive Intervention von Terraforming und den Einsatz von erheblichen Ressourcen m&ouml;glich.',
        4 => '-',
    ),

    'y' => array(
        0 => 'D&auml;monplanet',
        1 => 'Erfordert starkes Eingreifen der Terraforming',
        2 => 'Enormen Reserven von Metallen, Mineralien und Dilithium',
        3 => 'Planeten dieser Klasse haben eine extrem toxische Atmosph&auml;re und die Oberfl&auml;che selten auf Temperatur unter 500 Kelvin Grad absteigen. Die Oberfl&auml;chenwinde blasen mit hoher Geschwindigkeit und sehr wenige Substanzen sind resistent gegen korrosive Gase in der Atmosph&auml;re. Das Leben ist nur durch massive Intervention von Terraforming und den Einsatz von erheblichen Ressourcen m&ouml;glich.',
        4 => '-'
    ),
);

?>
