<?php
/**
 * Custom Shortcode
 * 
 * There are a basical shortcodes you will need
 */

 require 'classes/class_shortcode.php';

 $get_posts = new Custom_Shortcode( 'get_posts' );
 $get_posts->tinymce_buttons_2();