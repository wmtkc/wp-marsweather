<?php // Mars Weather - Widget Display

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

function marsweather_sol_readout($args) {
    $options = get_option('marsweather_options', marsweather_options_default());

    $unit_temp  = isset($options['temp'])  ? $options['temp']  : 'C';
    $unit_press = isset($options['press']) ? $options['press'] : 'pa';
    $unit_speed = isset($options['speed']) ? $options['speed'] : 'mps';

    $high  = isset($args->temp_high) ? $args->temp_high : '';
    $low   = isset($args->temp_low)  ? $args->temp_low  : '';
    $avg   = isset($args->temp_avg)  ? $args->temp_avg  : '';
    $press = isset($args->press_avg) ? $args->press_avg : '';
    $speed = isset($args->wind_spd)  ? $args->wind_spd  : '';
    $dir   = isset($args->wind_dir)  ? $args->wind_dir  : '';

    // Convert units, use proper suffix
    switch ($unit_temp) {
        case 'C':
            $unit_temp = '°C';
            break;
        case 'F':
            isset($high) ? $high = $high * (9/5) + 32 : '';
            isset($low)  ? $low  = $low  * (9/5) + 32 : '';
            isset($avg)  ? $avg  = $avg  * (9/5) + 32 : '';
            $unit_temp = '°F';
            break;
        case 'K':
            isset($high) ? $high += 273.15 : '';
            isset($low)  ? $low  += 273.15 : '';
            isset($avg)  ? $avg  += 273.15 : '';
            break;
        default: 
            $unit_temp = '°C';
    }

    switch ($unit_press) {
        case 'pa':
            $unit_press = 'Pa';
            break;
        case 'bar':
            isset($press) ? $press /= 100000 : '';
            break;
        default:
            $unit_press = 'Pa';
    }

    switch ($unit_speed) {
        case 'mps':
            $unit_speed = 'm/s';
            break;
        case 'fps':
            $unit_speed = 'ft/s';
            isset($speed) ? $speed *= 3.281 : '';
            break;
        case 'kph':
            isset($speed) ? $speed *= 3.6   : '';
            break;
        case 'mph':
            isset($speed) ? $speed *= 2.269 : '';
            break;
        case 'knot':
            $unit_speed = 'knots';
            isset($speed) ? $speed *= 1.943 : '';
            break;
        default:
            $unit_speed = 'm/s';
    }

    // return in DOM structure
    return '<div id="sol_readout">
                <div id="sol_id">Sol '. $args->sol .'</div>
                <div id="readout_data">
                    <div>
                        <div>High: </div>
                        <div>'. round($high) . $unit_temp .'</div>
                    </div>
                    <div>
                        <div>Low: </div>
                        <div>'. round($low) . $unit_temp .'</div>
                    </div>
                    <div>
                        <div>Avg: </div>
                        <div>'. round($avg) . $unit_temp .'</div>
                    </div>
                    <div>
                        <div>Pressure: </div>
                        <div>'. (($unit_press == 'bar') ? $press : round($press)) .' '. $unit_press .'</div>
                    </div>
                    <div>
                        <div>Wind: </div>
                        <div>'. round($speed) .' '. $unit_speed .' '. $dir .'</div>
                    </div>
                </div>
            </div>';
}

function marsweather_widget() {
    global $wpdb;

    // retrieve data from last five sols
    $last_five = $wpdb->get_results(
        "SELECT *
         FROM ". $wpdb->prefix . 'marsweather_data' ."
         ORDER BY sol DESC LIMIT 5;"
    );

    // Reverse output
    // $last_five = array_reverse($last_five);

    $all_sol_readouts = '';
    foreach ($last_five as $current_sol) {
        $all_sol_readouts .= marsweather_sol_readout($current_sol);
    }

    // return DOM structure
    return '<div id="widget_container">
                <div id="widget_title">
                    Mars Weather
                </div>
                <div id="readouts_container">
                    '. $all_sol_readouts .'
                </div>
            </div>';
}

?>