const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: './src/js/index.js',
    devtool: 'source-map',
    devServer: {
        historyApiFallback: true,
        contentBase: path.resolve(__dirname, './build'),
        open: true,
        compress: true,
        hot: true,
        port: 8080,
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'js/bundle.js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            chunkFilename: "css/chunks/[id].css",
            filename: "css/[name].css",
        }),
        new HtmlWebpackPlugin({
            title: 'Kotofey markup',
            template: path.join(__dirname, './src/index.pug'),
            filename: './index.html'
        })
    ],
    module: {
        rules: [
            {
                test: /\.pug$/i,
                use: ['pug-loader'],
            },
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader'],
            },
            {
                test: /\.scss$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
            },
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    }
};