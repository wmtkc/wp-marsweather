<?php // Mars Weather Widget - HTTP GET Request, return body only as array

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// construct and execute GET request
function marsweather_http_get_request($url) {
    $url = esc_url_raw($url);
    $args = array('timeout' => '5');

    return wp_safe_remote_get($url, $args);
}

// process API response
function marsweather_http_get_response($url) {
    $response = marsweather_http_get_request($url);
    $body = wp_remote_retrieve_body($response);
    $body_arr = json_decode($body, true);

    return $body_arr;
}

?>