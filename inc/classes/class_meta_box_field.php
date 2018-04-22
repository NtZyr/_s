<?php 
/**
 * Custom Field Class
 * 
 * @version 0.1
 */

class Custom_Meta_Box_Field {
    public function __construct( $id, $field, $label, $data, $meta, $custom_fields, $optional = null ) {
		$field_id_name  = strtolower( str_replace( ' ', '_', $data['id'] ) ) . '_' . strtolower( str_replace( ' ', '_', $id ) );
			
		require 'meta_box_field_templates/field_' . $field . '.php';
    }
}