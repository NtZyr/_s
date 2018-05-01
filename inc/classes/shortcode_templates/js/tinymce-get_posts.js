(function() {
    tinymce.PluginManager.add( 'get_posts', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('get_posts', {
            title: 'Get Posts',
            cmd: 'get_posts',
            image: url + '/icons/get_posts.png',
        });
 
        editor.addCommand('get_posts', function() {
            var win = editor.windowManager.open({
                title: 'Get Posts Shortcode',
                body: [
                    {
                        type: 'textbox',
                        name: 'posttype',
                        label: 'Post Type',
                        minWidth: 500,
                        value: ''
                    },
                    {
                        type: 'textbox',
                        name: 'count',
                        label: 'Posts Count',
                        minWidth: 500,
                        value: ''
                    },
                    {
                        type: 'textbox',
                        name: 'title',
                        label: 'Shortcode Title',
                        minWidth: 500,
                        value: ''
                    }
                ],
                buttons: [
                    {
                        text: 'Submit',
                        subtype: "primary",
                        onclick: function() {
                            win.submit();
                        }
                    },
                    {
                        text: 'Cancel',
                        onclick: function() {
                            win.close();
                        }
                    }
                ],
                onsubmit: function( e ) {
                    var params = [];

                    if( e.data.posttype.length > 0 ) {
                        params.push('posttype="' + e.data.posttype + '"');
                    }
                    if( e.data.count.length > 0 ) {
                        params.push('count="' + e.data.count + '"');
                    }
                    if( e.data.title.length > 0 ) {
                        params.push('title="' + e.data.title + '"');
                    }
                    if( params.length > 0 ) {
                        var paramsString = ' ' + params.join(' ');
                        var return_text = '[get_posts' + paramsString + ']';
                        editor.execCommand('mceInsertContent', false, return_text);
                    }
                }
            });
            // var shortcode = '<div class="column">';
            // return_text = shortcode;
            return;
        });
 
    });
})();