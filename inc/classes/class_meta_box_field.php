<?php 

    class Custom_Meta_Box_Field {
        
        public function __construct( $label, $type, $data, $meta, $custom_fields ) {
			$field_id_name  = strtolower( str_replace( ' ', '_', $data['id'] ) ) . '_' . strtolower( str_replace( ' ', '_', $label ) );
			
			require 'meta_box_field_templates/field_' . $type;
        }
    }