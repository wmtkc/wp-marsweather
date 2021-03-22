<?php // Fires when plugin is installed and activated

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

function marsweather_create_db_table () {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $tbl_name = $wpdb->prefix . 'marsweather_data';
    $sql = 'CREATE TABLE IF NOT EXISTS ' . $tbl_name . ' (
            sol INTEGER NOT NULL ,
            temp_high FLOAT NOT NULL ,
            temp_low FLOAT NOT NULL ,
            temp_avg FLOAT NOT NULL ,
            press_avg FLOAT NOT NULL ,
            wind_spd FLOAT NOT NULL ,
            wind_dir CHAR(3) NOT NULL ,
            PRIMARY KEY (sol)
    ) ' .  $charset_collate . ';';
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

?>