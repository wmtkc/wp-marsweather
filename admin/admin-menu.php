<?php // Mars Weather Widget - Admin Menu

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// create a menu entry for marsweather admin settings
function marsweather_add_toplevel_menu() {
    add_menu_page(
        'Mars Weather Widget Settings',
        'Mars Weather Widget',
        'manage_options',
        'marsweather',
        'marsweather_display_settings_page',
        'dashicons-admin-generic',
        null
    );
}
add_action('admin_menu', 'marsweather_add_toplevel_menu');

?>