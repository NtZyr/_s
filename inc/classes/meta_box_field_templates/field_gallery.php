<?php
/**
 * Field "Gallery"
 * 
 * @version 0.1
 */
    $gallery = ( isset( $meta[$field_id_name][0] ) ) ? $meta[$field_id_name][0] : '';
?>
<p>
	<label><?php echo esc_html_e( $label ); ?></label>
	<div class="separator gallery_images">
		<?php 
			$images = ( isset( $gallery ) && '' !== $gallery ) ? explode( ',', $gallery ) : '';
			if( !empty( $images ) ) : 
		?>
			<?php foreach( $images as $image ) : ?>
				<div class="gallery-item" data-id="<?php esc_attr( $image ); ?>">
					<div class="remove"></div>
					<?php echo wp_get_attachment_image( $image ); ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<p class="separator gallery_buttons">
		<input type="hidden" class="gallery" name="custom_meta[<?php echo $field_id_name; ?>]" value="<?php echo esc_attr( $gallery ); ?>" />
		<input type="button" class="manage_gallery button" value="<?php esc_html_e( 'Manage gallery', 'meat-theme' ); ?>" />
		<input type="button" class="empty_gallery button" value="<?php esc_html_e( 'Empty gallery', 'meat-theme' ); ?>" />
	</p>
</p>