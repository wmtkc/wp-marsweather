<?php // Fires when plugin is uninstalled from Plugins menu

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// delete plugin options
delete_option('marsweather_options');

// drop plugin database table
global $wpdb;
$table_name = $wpdb->prefix . 'marsweather_data';
$wpdb->query("DROP TABLE IF EXISTS {$table_name}");

?>