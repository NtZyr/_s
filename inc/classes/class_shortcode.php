<?php
/**
 * Shortcode Class (with integration with TinyMCE)
 * 
 * @version 0.5
 */
class Custom_Shortcode {
    public $shortcode_name;
    public $shortcode_settings;
    public $shortcode_labels;

    public function __construct( $name, $settings = array(), $labels = array() ) {
        $this->shortcode_name = $name;
        $this->shortcode_settings = $settings;
        $this->shortcode_labels = $labels;

        add_shortcode( $name, array( &$this, 'shortcode_view' ) );
        add_filter( 'mce_buttons', array( $this, 'register_tinymce_button' ) );
        add_filter( 'mce_external_plugins', array( $this, 'register_tinymce_js' ) );
    }

    public function shortcode_view( $atts, $content = null ) {
        $name = $this->shortcode_name;

        require 'shortcode_templates/' . $name . '.php';
    }

    public function register_tinymce_button( $buttons ) {
        $name = $this->shortcode_name;

        array_push( $buttons, 'separator', $name );
        return $buttons;
    }

    public function register_tinymce_js( $plugin_array ) {
        $name = $this->shortcode_name;

        $plugin_array[ $name ] = get_template_directory_uri() . '/inc/classes/shortcode_templates/js/tinymce-' . $name . '.js';
        return $plugin_array;
    }

    public function tinymce_buttons_2() { // add button to 2 row
        $name = $this->shortcode_name;

        add_filter( 'mce_buttons_2', function( $buttons ) use( $name ) {
            $buttons[] = $name;
            return $buttons;
        } );
    }
    
    public function tinymce_buttons_3() { // add button to 3 row
        $name = $this->shortcode_name;

        add_filter( 'mce_buttons_3', function( $buttons ) use( $name ) {
            $buttons[] = $name;
            return $buttons;
        } );
    }
    
}