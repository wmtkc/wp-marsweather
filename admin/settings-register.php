<?php // Mars Weather Widget - Register Settings

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// register plugin settings
function marsweather_register_settings() {
    register_setting(
        'marsweather_options',
        'marsweather_options',
        'marsweather_callback_validate_options'
    );

    add_settings_section(
        'marsweather_section_units',
        'Units',
        'marsweather_callback_section_units',
        'marsweather'
    );

    add_settings_field(
        'temp',
        'Temperature Units',
        'marsweather_callback_field_radio',
        'marsweather',
        'marsweather_section_units',
        [ 'id' => 'temp', 'label' => 'Temperature Units' ]
    );

    add_settings_field(
        'press',
        'Pressure Units',
        'marsweather_callback_field_radio',
        'marsweather',
        'marsweather_section_units',
        [ 'id' => 'press', 'label' => 'Pressure Units' ]
    );

    add_settings_field(
        'speed',
        'Wind Speed Units',
        'marsweather_callback_field_radio',
        'marsweather',
        'marsweather_section_units',
        [ 'id' => 'speed', 'label' => 'Wind Speed Units' ]
    );
}
add_action('admin_init', 'marsweather_register_settings');

?>