(function() {
    tinymce.PluginManager.add( 'get_posts', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('get_posts', {
            title: 'Get Posts',
            cmd: 'get_posts',
            image: url + '/get_posts.jpg',
        });
 
        editor.addCommand('get_posts', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if ( selected_text.length === 0 ) {
                alert( 'Please select some text.' );
                return;
            }
            var open_column = '<div class="column">';
            var close_column = '</div>';
            var return_text = '';
            return_text = open_column + selected_text + close_column;
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
 
    });
})();