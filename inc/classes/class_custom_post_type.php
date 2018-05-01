<?php
/**
 * Custom Post Type Class
 * 
 * @version 0.8
 */
require get_template_directory() . '/inc/classes/class_meta_box_field.php'; 

class Custom_Post_Type {
    public $post_type_name;
    public $post_type_args;
    public $post_type_labels;

    public function __construct( $name, $args = array(), $labels = array() ) {
        $this->post_type_name = strtolower( str_replace( ' ', '_', $name ) );
        $this->post_type_args = $args;
        $this->post_type_labels  = $labels;

        if( ! post_type_exists( $this->post_type_name ) ) {
            add_action( 'init', array( &$this, 'register_post_type' ) );
        }

        $this->save();

        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
    }

    public function register_post_type() {
        $name       = ucwords( str_replace( '_', ' ', $this->post_type_name ) );
        $plural     = $name . 's';

        $labels = array_merge(
            array(
                'name'                  => _x( $plural, 'post type general name' ),
                'singular_name'         => _x( $name, 'post type singular name' ),
                'add_new'               => _x( 'Add New', strtolower( $name ) ),
                'add_new_item'          => __( 'Add New ' . $name ),
                'edit_item'             => __( 'Edit ' . $name ),
                'new_item'              => __( 'New ' . $name ),
                'all_items'             => __( 'All ' . $plural ),
                'view_item'             => __( 'View ' . $name ),
                'search_items'          => __( 'Search ' . $plural ),
                'not_found'             => __( 'No ' . strtolower( $plural ) . ' found'),
                'not_found_in_trash'    => __( 'No ' . strtolower( $plural ) . ' found in Trash'),
                'parent_item_colon'     => '',
                'menu_name'             => $plural
            ),

            $this->post_type_labels
        );

        $args = array_merge(
            array(
                'label'                 => $plural,
                'labels'                => $labels,
                'public'                => true,
                'publicly_queryable'    => true,
                'show_ui'               => true,
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'show_in_nav_menus'     => true,
                '_builtin'              => false,
                'has_archive'           => true
            ),

            $this->post_type_args
        );

        register_post_type( $this->post_type_name, $args );
    } 

    public function add_taxonomy( $name, $args = array(), $labels = array() ) {
        if( ! empty( $name ) ) {
            $post_type_name = $this->post_type_name;

            $taxonomy_name      = strtolower( str_replace( ' ', '_', $name ) );
            $taxonomy_labels    = $labels;
            $taxonomy_args      = $args;

            if( ! taxonomy_exists( $taxonomy_name ) ) {
                //Capitilize the words and make it plural
                $name       = ucwords( str_replace( '_', ' ', $name ) );
                $plural     = $name . 's';

                // Default labels, overwrite them with the given labels.
                $labels = array_merge(

                    // Default
                    array(
                        'name'                  => _x( $plural, 'taxonomy general name' ),
                        'singular_name'         => _x( $name, 'taxonomy singular name' ),
                        'search_items'          => __( 'Search ' . $plural ),
                        'all_items'             => __( 'All ' . $plural ),
                        'parent_item'           => __( 'Parent ' . $name ),
                        'parent_item_colon'     => __( 'Parent ' . $name . ':' ),
                        'edit_item'             => __( 'Edit ' . $name ),
                        'update_item'           => __( 'Update ' . $name ),
                        'add_new_item'          => __( 'Add New ' . $name ),
                        'new_item_name'         => __( 'New ' . $name . ' Name' ),
                        'menu_name'             => __( $name ),
                    ),

                    // Given labels
                    $taxonomy_labels

                );

                // Default arguments, overwritten with the given arguments
                $args = array_merge(

                    // Default
                    array(
                        'label'                 => $plural,
                        'labels'                => $labels,
                        'public'                => true,
                        'publicly_queryable'    => true,
                        'show_ui'               => true,
                        'show_in_nav_menus'     => true,
                        '_builtin'              => false
                    ),

                    // Given    
                    $taxonomy_args
                );

                // Add the taxonomy to the post type
                add_action( 'init',
                    function() use( $taxonomy_name, $post_type_name, $args ) {
                        register_taxonomy( $taxonomy_name, $post_type_name, $args );
                    }
                );
            } else {
                add_action( 'init',
                    function() use( $taxonomy_name, $post_type_name ) {
                        register_taxonomy_for_object_type( $taxonomy_name, $post_type_name );
                    }
                );
            }
        }
    }

    public function add_meta_box( $box_meta = array(), $fields = array(), $visible = array(), $context = 'normal', $priority = 'default' ) {
        if( !empty( $box_meta['id'] ) ) {
            // We need to know the Post Type name again
            $post_type_name = $this->post_type_name;

            // Meta variables
            $box_id         = $box_meta['id'];
            $box_title      = $box_meta['title'];
            $box_context    = $context;
            $box_priority   = $priority;

            $this->box_id = $box_id;

            // Make the fields global
            global $custom_fields;
            $custom_fields[ $box_meta['id'] ] = $fields;

            add_action( 'admin_init',
                function() use( $box_id, $box_title, $post_type_name, $box_context, $box_priority, $fields ) {
                    add_meta_box(
                        $box_id,
                        $box_title,
                        function( $post, $data ) {
                            global $post;

                            // Nonce field for some validation
                            wp_nonce_field( plugin_basename( __FILE__ ), 'custom_post_type' );

                            // Get all inputs from $data
                            $custom_fields = $data['args'][0];

                            // Get the saved values
                            $meta = get_post_custom( $post->ID );

                            // Check the array and loop through it
                            if( !empty( $custom_fields ) ) {
                                /* Loop through $custom_fields */
                                foreach( $custom_fields as $field_array ) {
                      
                                    $field = new Custom_Meta_Box_Field( $field_array['id'], $field_array['field'], $field_array['label'], $data, $meta, $custom_fields, $field_array['optional'] );

                                }
                            }
                        },
                        $post_type_name,
                        $box_context,
                        $box_priority,
                        array( $fields )
                    );
                }
            );
        }
    }

    public function save() {
        // Need the post type name again
        $post_type_name = $this->post_type_name;

        add_action( 'save_post',
            function() use( $post_type_name ) {
                // Deny the WordPress autosave function
                if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

                if ( ! wp_verify_nonce( $_POST['custom_post_type'], plugin_basename(__FILE__) ) ) return;

                global $post;

                if( isset( $_POST ) && isset( $post->ID ) && get_post_type( $post->ID ) == $post_type_name ) {
                    global $custom_fields;

                    // Loop through each meta box
                    foreach( $custom_fields as $title => $fields ) {
                        // Loop through all fields
                        foreach( $fields as $field_array ) {
                            $field_id_name  = strtolower( str_replace( ' ', '_', $title ) ) . '_' . strtolower( str_replace( ' ', '_', $field_array['id'] ) );

                            update_post_meta( $post->ID, $field_id_name, (string)$_POST['custom_meta'][$field_id_name] );
                        }
                    }
                }
            }
        );
    }

    public function assets( $hook ) {
        // var_dump( $hook ); // check $hook
        switch( $hook ) {
            case 'post-new.php':
            case 'post.php':
                wp_enqueue_script( 'field-gallery', get_template_directory_uri() . '/js/admin/gallery.js' );
                break;
        }
    }
}
