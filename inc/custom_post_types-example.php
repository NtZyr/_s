<?php
/**
 * Example of register CPT
 */

require get_template_directory() . '/inc/classes/class_custom_post_type.php'; 

add_action( 'after_setup_theme', function() {
    // check out class for create new post types and metaboxes

    flush_rewrite_rules();  // required for new CPTs
});

add_action( 'switch_theme', function() {
    // unregister_post_type( 'post_type' );


} );