<?php // Mars Weather Widget - Settings Callbacks

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// callback: city section
function marsweather_callback_section_units() {
    echo '<p>Customize units for weather information</p>';
}

function marsweather_callback_field_radio($args) {
    $options = get_option('marsweather_options', marsweather_options_default());

    $id    = isset($args['id'])    ? $args['id']    : '';
    $label = isset($args['label']) ? $args['label'] : '';

    $selected_option = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

    $radio_options;
    switch($id) {
        case 'temp': 
            $radio_options = array(
                'C' => 'Celsius',
                'F' => 'Fahrenheit',
                'K' => 'Kelvin',
            ); 
            break;
        case 'press': 
            $radio_options = array(
                'pa'  => 'Pa',
                'bar' => 'bar'
            ); 
            break;
        case 'speed': 
            $radio_options = array(
                'mps'  => 'm/s',
                'fps'  => 'ft/s',
                'kph'  => 'kph',
                'mph'  => 'mph',
                'knot' => 'knots'
            ); 
            break;
        default: 
            $radio_options = array(
                'err' => 'Error'
            );
    }

    foreach ($radio_options as $value => $label) {
        $checked = checked($selected_option === $value, true, false);
        echo   '<label>
                    <input name="marsweather_options['. $id .']" 
                            type="radio" 
                            value="'. $value .'"'. 
                            $checked .'>
                    <span>'. $label .'</span>
                </label>
                <br />';    
    }
}

?>