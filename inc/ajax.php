<?php
/**
 * AJAX 
 */
add_action( 'wp_enqueue_scripts', function () { // scripts for ajax pages
    $ajax_url = admin_url('admin-ajax.php');
    // wp_localize_script( 'script-name', 'ajax_url', $ajax_url );
} );

// require 'ajax/file.php';