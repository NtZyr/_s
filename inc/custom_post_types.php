<?php
/**
 * Example of register CPT
 */

require get_template_directory() . '/inc/classes/class_custom_post_type.php';

/**
 * New home post type
 */
add_action( 'admin_init', function() {
    register_setting(
        'reading',             // Options group
        'home-post-type'      // Option name/database
        // 'home_post_type_sanitize' // sanitize callback function
    );
 
    /* Create settings section */
    add_settings_section(
        'custom-post-type-id',                   // Section ID
        __( 'Post Types Settings', 'codein_theme'),  // Section title
        'custom_post_type_description', // Section callback function
        'reading'                          // Settings page slug
    );
 
    /* Create settings field */
    add_settings_field(
        'home-post-type-field',       // Field ID
        __( 'Home Post Type', 'codein_theme'),       // Field title 
        'home_post_type_field_callback', // Field callback function
        'reading',                    // Settings page slug
        'custom-post-type-id'               // Section ID
    );
} );

function custom_post_type_description(){
    echo wpautop( __( 'Additional settings for custom post types', 'codein_theme' ) );
}

function home_post_type_field_callback(){
    $posttypes = get_post_types(
        array(
            'public' => true
        )
    );
    unset( $posttypes[ 'page' ] );
    unset( $posttypes[ 'attachment' ] );

    ?>
    <label>
        <select name="home-post-type">
            <?php foreach( $posttypes as $type => $name ) : ?>
                <option <?php echo ( get_option( 'home-post-type' ) == $type ? 'selected' : '' ); ?> value="<?php echo $type; ?>"><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php
}

add_action( 'pre_get_posts', function( $wp_query ) {
    if(is_admin()) {
        return;
    }

    if( $wp_query->is_main_query() && $wp_query->get('page_id') == get_option('page_on_front') ):

        $wp_query->set('post_type', get_option( 'home-post-type' ));
        $wp_query->set('page_id', ''); //Empty

        //Set properties that describe the page to reflect that
        //we aren't really displaying a static page
        $wp_query->is_page = 0;
        $wp_query->is_singular = 0;
        $wp_query->is_post_type_archive = 1;
        $wp_query->is_archive = 1;

    endif;
} );

/**
 * CPTs & Metaboxes
 */
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