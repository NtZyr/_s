var webpack = require( 'webpack' );

var ExtractTextPlugin = require('extract-text-webpack-plugin');

var extractPlugin = new ExtractTextPlugin({
    filename: '../style.css'
 });

module.exports = function( env ) {
    return {
        entry: ["./js/app.js", "./scss/style.scss"],
        output: {
            path: __dirname + "/dist",
            filename: "bundle.js"
        },
        module: {
            rules: [
                {
                    test: /\.(scss|sass)$/,
                    use: extractPlugin.extract({
                        use: [ 'css-loader', 'sass-loader' ],
                        fallback: [ 'style-loader' ]
                    })
                },
                {
                    test: /\.css$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: ['css-loader']
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
            new ExtractTextPlugin(
                {filename: 'style.css'}
            )
        ]
    }
}