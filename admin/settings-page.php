<?php // Mars Weather Widget - Settings Page

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

// display the plugin settings page
function marsweather_display_settings_page() {
    if (!current_user_can('manage_options')) return;

    ?>

    <div class='wrap'>
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('marsweather_options');
            do_settings_sections('marsweather');
            submit_button();
            ?>
        </form>
    </div>

    <?php
}

?>