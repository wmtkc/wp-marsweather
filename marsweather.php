<?php
/*

Plugin Name: Mars Weather
Description: Plugin to display weather data from the NASA InSight lander
Plugin URI: https://domain.ext/marsweather
Author: William Casey
Version: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/

*/

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/install.php';
require_once plugin_dir_path(__FILE__) . 'includes/http-get-request.php';
require_once plugin_dir_path(__FILE__) . 'includes/api-data-register.php';
require_once plugin_dir_path(__FILE__) . 'public/widget.php';

// if in admin
if (is_admin()) {
    // include dependencies
    require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php';
    require_once plugin_dir_path(__FILE__) . 'admin/settings-validate.php';
}

// activation hook function
function marsweather_activate() {
    marsweather_create_db_table();
}
register_activation_hook(__FILE__, 'marsweather_activate');

// enqueue styles
function marsweather_enqueue_styles() {
    $src = plugin_dir_url(__FILE__) .'public/css/marsweather.css';
    wp_enqueue_style('marsweather-style', $src, array(), null, 'all');
}
add_action('wp_enqueue_scripts', 'marsweather_enqueue_styles');

// define widget
class MarsWeather extends WP_Widget {

    // set up widget
    public function __construct() {
        $options = array(
            'classname' => 'marsweather',
            'description' => 'Mars Weather Widget'
        );
        parent::__construct('marsweather', 'Mars Weather', $options);
    }

    // output widget content
    public function widget($args, $instance) {
        echo marsweather_widget();
    }

    // output widget admin form fields
    public function form($instance) {
        // Widget forms if needed
    }

    // process widget options
    public function update($new_instance, $old_instance) {
        // Live update settings
    }
}

// register widget
function marsweather_register_widget() {
    register_widget('MarsWeather');
}
add_action('widgets_init', 'marsweather_register_widget');

// default city option
function marsweather_options_default() {
    return array(
        'temp' => 'C',     // C | F | K
        'press' => 'pa',   // pa | bar
        'speed' => 'mps'   // mps | fps | kph | mph | knot
    );
}

// get and process api data
function marsweather_api_request() {
    $api_key = 'VjPrfB0vNbUADYcWarhhxhOr43fckEe7xfbcbAlw';
    $url = 'https://api.nasa.gov/insight_weather/?api_key=' . $api_key . '&feedtype=json&ver=1.0';

    $api_data = marsweather_http_get_response($url);
    marsweather_register_api_data($api_data);
}
add_action('init', 'marsweather_api_request');

?>
