<?php
/*    
    This file is part of STFC.it.
    Copyright 2008-2013 by Andrea Carolfi (info@stfc.it) and Cristiano Delogu

    STFC.it is based on STGC,
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


// ########################################################################################
// ########################################################################################
// In questa versione, Unimatrix Zero è una flotta composta da un vascello speciale e dalla
// scorta di questo. La scorta è composta da cubi tattici, cubi e sfere. Viene generato un
// cubo tattico per ogni cinque pianeti controllati dal collettivo. Per ogni cubo tattico
// vengono generati 6 cubi. Per ogni cubo, vengono generate 4 sfere.
//                          ====== ATTENZIONE ======
// La flotta non viene generata in toto in questo momento! Assumerà la sua
// forma completa solo con il passare del tempo! In questa fase, la flotta
// è composta solo da Unimatrix Zero, UN cubo tattico, SEI cubi e
// VENTIQUATTRO sfere!

$game->init_player();

check_auth(STGC_DEVELOPER);

$quadrant_id = 2; // This is usually the Delta quadrant id
$sector_id_min = ( ($quadrant_id - 1) * 81) + 1;
$sector_id_max = $quadrant_id * 81;

$borg_bot = $db->queryrow('SELECT * FROM borg_bot WHERE id = 1');

$sql = 'SELECT planet_id, system_id 
        FROM planets 
        INNER JOIN starsystems USING (system_id)
        WHERE system_closed = 0 
        AND starsystems.sector_id >= '.$sector_id_min.'
        AND starsystems.sector_id <= '.$sector_id_max.' 
        AND system_n_planets > 4';
$spawn_um0 = $db->queryrowset($sql);

// This is risky, we could not find a proper spot for spawning UM0...
$spawn_item = $spawn_um0[array_rand($spawn_um0)];
$spawn_id = $spawn_item['planet_id'];

$sql = 'INSERT INTO ship_fleets (fleet_name, user_id, planet_id, alert_phase, move_id, n_ships)
    VALUES ("Unimatrix Zero", '.BORG_USERID.', '.$spawn_id.', '.ALERT_PHASE_RED.', 0, 1)';
if(!$db->query($sql))
    message(DATABASE_ERROR, '<b>Error:</b> Could not insert new fleet data');
$fleet_id = $db->insert_id();

if(!$fleet_id) message(DATABASE_ERROR, 'Error - '.$fleet_id.' = empty');

// Creating the NEW Unimatrix Zero!

$sql = 'SELECT max_unit_1, max_unit_2, max_unit_3, max_unit_4, rof, max_torp,
               value_5, value_9
        FROM `ship_templates` WHERE `id` = '.$borg_bot['unimatrixzero_tp'];
if(($stpl = $db->queryrow($sql)) === false)
    message(DATABASE_ERROR, '<b>Error:</b> Could not query Unimatrix Zero template data - '.$sql);

$sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                          rof, torp, unit_1, unit_2, unit_3, unit_4)
       VALUES ('.$fleet_id.', '.BORG_USERID.', '.$borg_bot['unimatrixzero_tp'].', '.$stpl['value_9'].',
               '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].',
               '.$stpl['max_unit_1'].', '.$stpl['max_unit_2'].',
               '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'].')';
if(!$db->query($sql)) {
        message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Unimatrix Zero ship data');
}

// We add the FIRST tactical cube

$sql = 'SELECT max_unit_1, max_unit_2, max_unit_3, max_unit_4, rof, max_torp,
               value_5, value_9
        FROM `ship_templates` WHERE `id` = '.$borg_bot['ship_template3'];
if(($stpl = $db->queryrow($sql)) === false)
    message(DATABASE_ERROR, '<b>Error:</b> Could not query Borg Tactical Cube template data - '.$sql);

$sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                          rof, torp, unit_1, unit_2, unit_3, unit_4)
       VALUES ('.$fleet_id.', '.BORG_USERID.', '.$borg_bot['ship_template3'].', '.$stpl['value_9'].',
               '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].',
               '.$stpl['max_unit_1'].', '.$stpl['max_unit_2'].',
               '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'].')';
if(!$db->query($sql)) {
        message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Tactical cube data');
}

// We add SIX cubes

$sql = 'SELECT max_unit_1, max_unit_2, max_unit_3, max_unit_4, rof, max_torp,
               value_5, value_9
        FROM `ship_templates` WHERE `id` = '.$borg_bot['ship_template2'];
if(($stpl = $db->queryrow($sql)) === false)
    message(DATABASE_ERROR, '<b>Error:</b> Could not query Borg Cube template data - '.$sql);

for ($i = 0; $i < 6; $i++) {
    $sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                              rof, torp, unit_1, unit_2, unit_3, unit_4)
           VALUES ('.$fleet_id.', '.BORG_USERID.', '.$borg_bot['ship_template2'].', '.$stpl['value_9'].',
                   '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].',
                   '.$stpl['max_unit_1'].', '.$stpl['max_unit_2'].',
                   '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'].')';
    if(!$db->query($sql)) {
            message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Borg cube data');
    }
}

// We add TWENTYFOUR spheres

$sql = 'SELECT max_unit_1, max_unit_2, max_unit_3, max_unit_4, rof, max_torp,
               value_5, value_9
        FROM `ship_templates` WHERE `id` = '.$borg_bot['ship_template1'];
if(($stpl = $db->queryrow($sql)) === false)
    message(DATABASE_ERROR, '<b>Error:</b> Could not query Borg sphere template data - '.$sql);

for ($i = 0; $i < 24; $i++) {
    $sql= 'INSERT INTO ships (fleet_id, user_id, template_id, experience, hitpoints, construction_time,
                              rof, torp, unit_1, unit_2, unit_3, unit_4)
           VALUES ('.$fleet_id.', '.BORG_USERID.', '.$borg_bot['ship_template1'].', '.$stpl['value_9'].',
                   '.$stpl['value_5'].', '.time().', '.$stpl['rof'].', '.$stpl['max_torp'].',
                   '.$stpl['max_unit_1'].', '.$stpl['max_unit_2'].',
                   '.$stpl['max_unit_3'].', '.$stpl['max_unit_4'].')';
    if(!$db->query($sql)) {
            message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Borg sphere data');
    }
}

$sql = 'UPDATE borg_bot SET system_id = '.$spawn_item['system_id'].', unimatrixzero_id = '.$fleet_id.' WHERE id = 1';
if(!$db->query($sql)) {
            message(DATABASE_ERROR, '<b>Error:</b> Could not insert new Borg sphere data');
}
    
$game->out('Unimatrix Zero Fleet has been created!!!');

?>

