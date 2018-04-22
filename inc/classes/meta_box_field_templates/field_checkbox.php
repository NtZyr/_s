<?php
/**
 * Field "Input Text"
 */
    $value = ( isset( $meta[$field_id_name][0] ) ) ? $meta[$field_id_name][0] : '';
?>
<p>
    <label for="<?php echo $field_id_name; ?>"><input id="<?php echo $field_id_name; ?>" name="custom_meta[<?php echo $field_id_name; ?>]" type="checkbox" <?php echo ( $value == 'true' ? 'checked' : '' ); ?> value="true"><?php echo $label ?> </label>
</p>