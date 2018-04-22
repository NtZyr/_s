jQuery(document).ready(function($){
	$( document ).on( 'click', '.manage_gallery', upload_gallery_button );
	$( document ).on( 'click', '.empty_gallery', empty_gallery_button );
	$( document ).on( 'click', '.gallery-item .remove', empty_single_image );

	function upload_gallery_button(e) {
		var $this = $( e.currentTarget );
		e.preventDefault();
		if ( ! $this.data( 'lockedAt' ) || + new Date() - $this.data( 'lockedAt' ) > 300) { // Doubleclick prevent.
			var $input_field = $(this).parent().find( '.gallery' );
			var ids = $input_field.val();
			var gallerysc = '[gallery ids="' + ids + '"]';
			wp.media.gallery.edit( gallerysc ).on('update', function(g) {
			var id_array = [];
			var url_array = [];
			$.each(g.models, function(id, img){
				url_array.push( img.attributes.url );
				id_array.push( img.id );
			});
			var ids = id_array.join( "," );
			ids = ids.replace( /,\s*$/, "" );
			var urls = url_array.join( "," );
			urls = urls.replace( /,\s*$/, "" );
			$input_field.val( ids );
			var html = '';
			for (var i = 0 ; i < url_array.length; i++) {
				html += '<div class="gallery-item" data-id="' + id_array[i] + '"><div class="remove">x</div><img src="' + url_array[i] + '"></div>';
			}

			$(this).parent().find( '.gallery_images' ).html( '' ).append( html );
			});
		}
		$this.data( 'lockedAt', + new Date() );
	}

	function empty_gallery_button(e){
		e.preventDefault();
		var $input_field = $(this).parent().find( '.gallery' );
		$input_field.val( '' );
		$( '.gallery_images' ).html( '' );
	}


	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
			what = a[--L];
			while ((ax = this.indexOf( what )) !== -1) {
				this.splice( ax, 1 );
			}
		}
		return this;
	};

	function empty_single_image(e){
		e.preventDefault();
		var $this = $( this );
		var value = $this.parent().data( 'id' );
		var $this_image = $this.parent().find( 'img' );
		var $this_image_url = $this_image.attr( 'src' );
		var $input_field = $(this).parent().find( '.gallery' );
		var existing_values_arr = $input_field.val().split( ',' );
		var new_arr = existing_values_arr.remove( value.toString() );
		var replace_str = new_arr.join();
		$input_field.val( '' ).val( replace_str );
		$this.parent().remove();
	}
});