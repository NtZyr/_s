var webpack = require( 'webpack' );

var ExtractTextPlugin = require('extract-text-webpack-plugin');

var extractPlugin = new ExtractTextPlugin({
    filename: '../style.css'
 });

module.exports = function( env ) {
    return {
        entry: ["./js/app.js", "./sass/style.scss"],
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
                },
                {
                    test: /\.scss$/, 
                    loader: "style-loader!css-loader!sass-loader", 
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
                    use: {
                        loader: 'url-loader?limit=1024&name=../fonts/[name].[ext]'
                    }
                }
            ],
        },
        plugins: [
            extractPlugin
        ]
    }
}