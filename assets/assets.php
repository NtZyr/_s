<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('codein_theme-style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script('codein_theme-js', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'));
    // wp_localize_script('script-name', 'varName', $varName);
});