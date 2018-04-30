<?php
/**
 * Example of register CPT
 */

require get_template_directory() . '/inc/classes/class_custom_post_type.php'; 

add_action( 'after_setup_theme', function() {
    // check out class for create new post types and metaboxes

    $post = new Custom_Post_Type( 'post' );
    $post->add_meta_box( 
        array(
            'id' => 'gal',
            'title' => __( 'Post gallery', 'codein_theme' )
        ),
        array(
            array(
                'id' => 'test',
                'field' => 'gallery',
                'label' => __( 'Gallery of images', 'codein_theme' )
            ),
            array(
                'id' => 'check-test',
                'field' => 'checkbox',
                'label' => __( 'checkbox', 'codein_theme' )
            ),
            array(
                'id' => 'input-test',
                'field' => 'text',
                'label' => __( 'Test', 'codein_theme' )
            ),
        )
    );

    flush_rewrite_rules();  // required for new CPTs
});

add_action( 'switch_theme', function() {
    // unregister_post_type( 'post_type' );

} );