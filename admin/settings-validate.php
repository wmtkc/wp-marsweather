<?php // Mars Weather Widget - Settings Validation

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// validate plugin settings
function marsweather_validate_options($input) {

    // Validate temp unit input
    $temp_options = array(
        'C' => 'Celsius',
        'F' => 'Fahrenheit',
        'K' => 'Kelvin'
    );

    if (!isset($input['temp'])) {
        $input['temp'] = null;
    }

    if (!array_key_exists($input['temp'], $temp_options)) {
        $input['temp'] = null;
    }

    // validate press unit input
    $press_options = array(
        'pa' => 'Pa',
        'bar' => 'bar'
    );

    if (!isset($input['press'])) {
        $input['press'] = null;
    }

    if (!array_key_exists($input['press'], $temp_options)) {
        $input['press'] = null;
    }

    // validade wind speed unit input
    $speed_options = array(
        'mps'  => 'm/s',
        'fps'  => 'ft/s',
        'kph'  => 'kph',
        'mph'  => 'mph',
        'knot' => 'knots'
    );

    if (!isset($input['speed'])) {
        $input['speed'] = null;
    }

    if (!array_key_exists($input['speed'], $temp_options)) {
        $input['speed'] = null;
    }

    return $input;
}

?>