var webpack = require( 'webpack' );

var ExtractTextPlugin = require('extract-text-webpack-plugin');

var extractPlugin = new ExtractTextPlugin({
    filename: '../style.css'
 });

module.exports = function( env ) {
    return {
        entry: {
            js: "./src/js/app.js", 
            sass: "./src/sass/style.scss"
        },
        output: {
            path: __dirname + "/dist",
            filename: "bundle.js"
        },
        module: {
            loaders: [
                {
                    test: /\.html$/, 
                    loader: 'raw-loader', 
                    exclude: /node_modules/
                },
                {
                    test: /\.css$/, 
                    loader: "style-loader!css-loader", 
                    exclude: /node_modules/
                }
            ],
            rules: [
                {
                    test: /\.(scss|sass)$/,
                    use: extractPlugin.extract({
                        use: [ 'css-loader', 'sass-loader' ],
                        fallback: [ 'style-loader' ]
                    })
                },
                {
                    test: /\.(woff|woff2|eot|ttf|svg)$/,
                    exclude: /node_modules/,
                    loader: 'url-loader'
                }
            ],
        },
        plugins: [
            extractPlugin
        ]
    }
}