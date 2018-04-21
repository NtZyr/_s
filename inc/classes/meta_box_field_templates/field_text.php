<?php
/**
 * Field "Input Text"
 */
    $value = ( isset( $meta[$field_id_name][0] ) ) ? $meta[$field_id_name][0] : '';
?>
<p>
    <label for="<?php echo $field_id_name; ?>"><?php echo $label ?>: <input id="<?php echo $field_id_name; ?>" name="custom_meta[<?php echo $field_id_name; ?>]" type="text" value="<?php echo $value; ?>"></label>
</p>