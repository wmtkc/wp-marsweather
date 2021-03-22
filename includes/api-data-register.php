<?php // Mars Weather Widget - Register API Data

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

function marsweather_register_api_data($api_data) {
    
    global $wpdb;
    
    if (isset($api_data['sol_keys'])) {
       foreach ($api_data['sol_keys'] as $key => $value) {

           //check if sol data already exists in table
           $already_exists = $wpdb->get_results(
                "SELECT sol 
                 FROM ". $wpdb->prefix . 'marsweather_data' ."
                 WHERE sol = ". intval($value) .";"
            );
                                            
                                            
           if (empty($already_exists) && isset($api_data[$value])) {
               $current_sol = $api_data[$value];

               // set atmospheric variables
               $sol_id    = intval($value);
               $temp_high = isset($current_sol['AT']['mx'])  ? $current_sol['AT']['mx']  : 0;
               $temp_low  = isset($current_sol['AT']['mn'])  ? $current_sol['AT']['mn']  : 0;
               $temp_avg  = isset($current_sol['AT']['av'])  ? $current_sol['AT']['av']  : 0;
               $press_avg = isset($current_sol['PRE']['av']) ? $current_sol['PRE']['av'] : 0;
               $wind_spd  = isset($current_sol['HWS']['av']) ? $current_sol['HWS']['av'] : 0;
               $wind_dir  = isset($current_sol['WD']['most_common']['compass_point']) ? $current_sol['WD']['most_common']['compass_point'] : '';

               // add table row
               $wpdb->insert($wpdb->prefix . 'marsweather_data', array(
                   'sol'       => $sol_id,
                   'temp_high' => $temp_high,
                   'temp_low'  => $temp_low,
                   'temp_avg'  => $temp_avg,
                   'press_avg' => $press_avg,
                   'wind_spd'  => $wind_spd,
                   'wind_dir'  => $wind_dir
               ));
           }
       }
}
}

?>