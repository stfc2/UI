<?php
/*
    This file is part of STFC.it
    Copyright 2008-2013 by Andrea Carolfi (carolfi@stfc.it) and
    Cristiano Delogu (delogu@stfc.it).

    STFC.it is based on STFC,
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



$game->init_player();

$game->out('<span class="caption">Reset galaxy</span><br><br>');

check_auth(STGC_DEVELOPER);

if(!isset($_GET['sure'])) {
    $game->out('<br><center>Do you really want to reset the galaxy COMPLETELY?<br><b><h3>All the data will be LOST FOREVER!</h3></b><br><a href="'.parse_link('a=tools/world/reset_galaxy&sure').'">Reset galaxy</a></center>');
    return;
}

if(!isset($_GET['supersure'])) {
    $game->out('<br><center>Let me ask you a second time: do you really, <B>REALLY</b> want to reset the galaxy COMPLETELY?<br><b><h2>All the data will be LOST FOREVER!</h2></b><br><a href="'.parse_link('a=tools/world/reset_galaxy&sure&supersure').'">Reset galaxy</a></center>');
    return;
}

if(!isset($_GET['hypersure'])) {
    $game->out('<br><center>Just to be sure, a third time: do you really, <b>REALLY</b>, <b><u>R E A L L Y</u></b> want to reset the galaxy COMPLETELY?<br><b><H1>ALL THE DATA WILL BE LOST FOREVER!</H1></b><br><a href="'.parse_link('a=tools/world/reset_galaxy&sure&supersure&hypersure').'">Reset galaxy</a></center>');
    return;
}

// ###########################################################################
// ###########################################################################
// Ok, let's nuke the galaxy!

$game->out('<b>Beginning galaxy big crunch...</b><br>');

// First of all stop the tick execution and the game:
$sql = 'UPDATE config SET tick_stopped = 1,game_stopped = 1';

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot stop tick execution!');
}

$game->out('Tick stopped<br>');

// Then truncate all the existing tables except for config, FHB_debug, and skins:

$game->out('Truncating DB tables...');

$tables = array(
    'account_observe',
    'alliance',
    'alliance_application',
    'alliance_bposts',
    'alliance_bthreads',
    'alliance_diplomacy',
    'alliance_logs',
    'alliance_shoutbox',
    'alliance_taxes',
    'bidding',
    'bidding_owed',
    'borg_bot',
    'borg_target',
    `borg_npc_target`,
    'click_ids',
    'FHB_bid_meldung',
    'FHB_Bot',
    'FHB_cache_trupp_trade',
    'FHB_Handels_Lager',
    'FHB_handel_log',
    'FHB_logging_ship',
    'FHB_news',
    'FHB_ship_Lager',
    'FHB_ship_templates',
    'FHB_sperr_list',
    'FHB_stats',
    'FHB_temp_grundpreis',
    'FHB_truppen_lib',
    'FHB_warteschlange',
    'future_human_reward',
    'ip_link',
    'logbook',
    'message',
    'message_archiv',
    'message_removed',
    'planets',
    'planet_details',
    'portal_news',
    'portal_poll',
    'portal_poll_voted',
    'resource_trade',
    'scheduler_instbuild',
    'scheduler_research',
    'scheduler_resourcetrade',
    'scheduler_shipbuild',
    'scheduler_shipmovement',
    'schulden_table',
    'settlers_relations',
    'ships',
    'ship_ccategory',
    'ship_components',
    'ship_fleets',
    'ship_templates',
    'ship_trade',
    'shoutbox',
    'spenden',
    'starsystems',
    'starsystems_details',
    'starsystems_slots',
    'stations',
    'tc_coords_memo',
    'trade_settings',
    'transport_logs',
    'treuhandkonto',
    'user',
    'userally_history',
    'user_diplomacy',
    'user_iplog',
    'user_logs',
    'user_sitter_iplog',
    'user_templates');

foreach($tables as $table) {
    if(!$db->query('TRUNCATE '.$table)) {
        message(DATABASE_ERROR, 'Cannot truncate DB table '.$table.'!');
    }
}

$game->out('done.<br>');

// ###########################################################################
// ###########################################################################
// Recreate admin user's stuff

$game->out('Creating STFC admin user...');

// We could use some default values here...
$sql = "INSERT INTO `user` (`user_id`, `user_active`, `user_name`, `user_loginname`, `user_password`,
                            `user_email`, `user_auth_level`, `user_rank`, `user_override_uid`, `user_race`,
                            `user_gfxpath`, `user_skinpath`, `user_jspath`, `user_skin`, `user_notepad`,
                            `user_registration_time`, `user_registration_ip`, `user_attack_protection`, `user_max_colo`,
                            `user_alliance`,`user_alliance_rights1`, `user_alliance_rights2`, `user_alliance_rights3`,
                            `user_alliance_rights4`, `user_alliance_rights5`, `user_alliance_rights6`, `user_alliance_rights7`,
                            `user_alliance_rights8`, `user_alliance_status`, `last_active`, `last_ip`, `user_points`,
                            `user_planets`, `user_honor`, `user_capital`, `pending_capital_choice`, `active_planet`,
                            `user_hidenotepad`, `globalresearch_1`, `globalresearch_2`, `globalresearch_3`, `globalresearch_4`,
                            `globalresearch_5`, `user_last_emergency_call`, `user_vacation_start`, `user_vacation_end`,
                            `user_last_vacation`, `user_last_vacation_duration`, `user_sitting_active`,
                            `user_sitting_password`, `user_sitting_o1`, `user_sitting_o2`, `user_sitting_o3`,
                            `user_sitting_o4`, `user_sitting_o5`, `user_sitting_o6`, `user_sitting_o7`, `user_sitting_o8`,
                            `user_sitting_o9`, `user_sitting_o10`, `user_sitting_id1`, `user_sitting_id2`, `user_sitting_id3`,
                            `user_sitting_id4`, `user_sitting_id5`, `last_tcartography_view`, `last_tcartography_id`,
                            `last_stationatedf_dmode`, `last_movef_dmode`, `unread_messages`, `unread_log_entries`, 
                            `unread_support_tickets`, `shoutbox_posts`, `last_shoutbox_post`, `shoutbox_flood_error`,
                            `user_avatar`, `user_signature`, `user_icq`, `user_birthday`, `user_gender`, `user_enable_sig`,
                            `user_rank_points`, `user_rank_planets`, `user_rank_honor`, `user_gallery_name_1`,
                            `user_gallery_name_2`, `user_gallery_name_3`, `user_gallery_name_4`, `user_gallery_name_5`,
                            `user_gallery_description_1`, `user_gallery_description_2`, `user_gallery_description_3`,
                            `user_gallery_description_4`, `user_gallery_description_5`, `last_secimage`, `timeout_secimage`,
                            `content_secimage`, `link_secimage`, `error_secimage`, `num_auctions`, `user_message_sig`,
                            `user_options`, `plz`, `country`, `num_hits`, `num_sitting`, `language`, `tutorial`,
                            `last_alliance_kick`, `user_trade`, `message_basement`, `trade_tick`, `notepad_width`,
                            `notepad_cols`, `skin_farbe`) VALUES
                           (10, 1, 'STFC-Admin', 'admin', '20de672d58473de036b873080afab62a', 'admin@stfc.it', 3, 'Developer', 0, 0,
                           '/stfc_gfx/', 'skin1/', '', 1, '', 0, '', 3557,
                           0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1343032585, '10.1.8.37',
                           9, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '',
                           0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3,
                           1489, 0, 0, 0, 0, 0, 273, 1335786338, 9, '', '', '', '', '-', 0, 2, 2, 1,
                           'Spazio libero', 'Spazio libero', 'Spazio libero', 'Spazio libero', 'Spazio libero', '', '', '', '', '',
                           1343028872, 1276633833, '', 'tmpsec/sec0558eba1efd5812e49a30c7f75acb37e.gif', 0, 1, '',
                           'a:9:{s:15:\"planetlist_show\";i:0;s:16:\"planetlist_order\";i:0;s:22:\"alliance_status_member\";i:2;s:16:\"redalert_options\";i:0;s:10:\"show_trade\";i:1;s:6:\"type_2\";i:1;s:6:\"type_0\";i:1;s:6:\"type_3\";i:1;s:6:\"type_1\";i:1;}',
                           '74586', 'IT', 114, 0, 'ITA', 0, 8566, 3, '', 0, 200, 13, '')";

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot create STFC-Admin user!');
}

$game->out('done.<br>Creating STFC admin star system...');

$sql = 'INSERT INTO `starsystems` (
            `system_id`, `system_name`, `sector_id`,
            `system_x`, `system_y`,
            `system_map_x`, `system_map_y`,
            `system_global_x`, `system_global_y`,
            `system_starcolor_red`, `system_starcolor_green`, `system_starcolor_blue`,
            `system_starsize`,
            `system_n_planets`,
            `system_max_planets`,
            `system_closed`)
        VALUES (
            1, "System E14:F2", 122,
            2, 6,
            52, 229,
            119, 42,
            18, 21, 165,
            12,
            1,
            6,
            1)';

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot create STFC-Admin starsystem!');
}

$game->out('done.<br>Creating STFC admin planet...');

$sql = 'INSERT INTO `planets` (
            `planet_id`, `planet_name`, `system_id`, `sector_id`,
            `planet_owner`, `planet_owned_date`, `planet_distance_id`,
            `planet_distance_px`, `planet_covered_distance`, `planet_tick_cdistance`,
            `planet_max_cdistance`, `planet_current_x`, `planet_current_y`,
            `planet_points`, `planet_available_points`,`planet_thumb`,
            `resource_1`, `resource_2`, `resource_3`, `resource_4`,
            `rateo_1`, `rateo_2`, `rateo_3`, `rateo_4`, `recompute_static`,
            `max_resources`, `max_worker`, `max_units`,
            `workermine_1`, `workermine_2`, `workermine_3`,
            `planet_altname`)
        VALUES (
            1, "Admin Home", 1, 122,
            10, '.$game->TIME.', 4,
            146, 0, 19,
            917, 0, 0,
            10, 1173, "",
            200, 200, 100, 100,
            1, 1, 1, 1, 1,
            38000, 65000, 65000,
            100, 100, 100,
            "")';

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot create STFC-Admin planet!');
}

$game->out('done.<br>Creating STFC admin user template...');

$file = $config['game_url'].'/modules/tools/world/default_template.html';
if(($template = file_get_contents($file)) === false) {
    message(GENERAL, 'Cannot open default template file: '.$file);
}

$template = utf8_decode($template);
$sql =  'INSERT INTO `user_templates` (`user_id`, `user_template`) VALUES
                                     (10, "'.addslashes($template).'")';

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot create STFC-Admin user template!');
}

// This templates are needed by tool encourage_user
$game->out('done.<br>Creating STFC admin ship templates...');

$sql = "INSERT INTO ship_templates (
            `id`, `owner`, `timestamp`, `name`,
            `description`, `race`, `ship_torso`, `ship_class`,
            `component_1`, `component_2`, `component_3`, `component_4`, `component_5`,
            `component_6`, `component_7`, `component_8`, `component_9`, `component_10`,
            `value_1`, `value_2`, `value_3`, `value_4`, `value_5`,
            `value_6`, `value_7`, `value_8`, `value_9`, `value_10`,
            `value_11`, `value_12`, `value_13`, `value_14`, `value_15`,
            `rof`, `max_torp`,
            `resource_1`, `resource_2`, `resource_3`, `resource_4`,
            `unit_5`, `unit_6`,
            `min_unit_1`, `min_unit_2`, `min_unit_3`, `min_unit_4`,
            `max_unit_1`, `max_unit_2`, `max_unit_3`, `max_unit_4`,
            `buildtime`, `removed`)
        VALUES
            (1, 10, ".$game->TIME.", 'Cargo',
            'Encouraging cargo', 0, 1, 0,
            -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1,
            15, 0, 0, 5, 20,
            2, 1, 5, 5, 3.4,
            5, 0, 10, 4, 0,
            1, 0,
            4250, 5800, 4640, 105,
            2, 1,
            56, 0, 0, 1,
            56, 0, 0, 1,
            40, 0),
            (2, 10, ".$game->TIME.", 'Coloship',
            'Encouraging colony ship', 0, 2, 0,
            -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1,
            10, 0, 0, 10, 50,
            0, 0, 0, 0, 5.4,
            0, 0, 15, 5, 0,
            1, 0,
            59900, 19450, 32360, 1955,
            16, 2,
            104, 0, 0, 3,
            200, 0, 0, 3,
            170, 0),
            (3, 10, ".$game->TIME.", 'Corvette',
            'Encouraging hull 8', 0, 7, 2,
            -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1,
            190, 110, 10, 670, 300,
            9, 5, 24, 10, 4.2,
            5, 0, 30, 25, 0,
            1, 75,
            41212, 37445, 20956, 550,
            15, 5,
            85, 25, 10, 0,
            100, 50, 75, 5,
            265, 0),
            (4, 10, ".$game->TIME.", 'Frigate',
            'Encouraging hull 12', 0, 11, 3,
            -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1,
            500, 200, 5, 1180, 1050,
            12, 14, 35, 25, 3.7,
            19, 0, 77, 71, 0,
            1, 275,
            84370, 66427, 61674, 1400,
            16, 5,
            250, 75, 50, 3,
            500, 200, 100, 12,
            439, 0);";

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot create STFC-Admin ship templates!');
}

// ###########################################################################
// ###########################################################################
// Recreate free starsystems slots

$game->out('done.<br>Recreate free starsystems slots...');

$_GET['sure'] = 1;
include('repair_starsystem_slots.php');

$game->out('done.<br>Reset config table to initial status...');

$sql = 'UPDATE config
        SET tick_id = 1,
            tick_time = '.time().',
            stardate = 21000.0,
            ferengitax_1 = 0,
            ferengitax_2 = 0,
            ferengitax_3 = 0,
            last_paytime = 0,
            future_ship = 0,
            settler_tmp_1 = 0,
            settler_tmp_2 = 0,
            settler_tmp_3 = 0,
            settler_tmp_4 = 0';

            if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot reset config table to initial status!');
}

// ###########################################################################
// ###########################################################################
// Clean all the temporary directories.

$game->out('done.<br>Clean temporary directories...');

$files = array_merge_recursive(glob($config['game_path']."gallery/img_*.img"),
        glob($config['game_path']."logs/*tick*"),
        glob($config['game_path']."logs/fixall/tick*"),
        glob($config['game_path']."logs/sixhours/tick*"),
        glob($config['game_path']."maps/images/cache/*.png"),
        glob($config['game_path']."maps/tmp/*.png"),
        glob($config['game_path']."maps/tmp/*.html"),
        glob($config['game_path']."sig_tmp/*.jpg"),
        glob($config['game_path']."tmpsec/*.jpg"));

array_walk($files,function ($file) { unlink($file); });

$game->out('done.<br><b>Galaxy has been successfully reset.</b>');

// ###########################################################################
// ###########################################################################
// Install the BOTs.

$game->out('<br><br>');

$_GET['sure'] = 1;
include('install_BOTs.php');

/* Restart the tick execution and the game:
$sql = 'UPDATE config SET tick_stopped = 0,game_stopped = 0';

if(!$db->query($sql)) {
    message(DATABASE_ERROR, 'Cannot restart tick execution!');
}

$game->out('Tick restarted<br>');*/

?>
