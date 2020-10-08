const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const CopyPlugin = require('copy-webpack-plugin');

module.exports = {
    entry: "./src/index.js",
    output: {
        path: path.join(__dirname, "/dist"),
        filename: "popup.min.js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ["babel-loader"]
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            }
        ]
    },
    plugins: [
        new CopyPlugin([
            {from: './src/manifest.json', to: './manifest.json'},
            {from: './src/assets/', to: './assets/'},
            {from: './src/_locales/', to: './_locales/'},
            // { from: 'other', to: 'public' },
        ]),
        new HtmlWebpackPlugin({
            template: "./src/index.html"
        })
    ]
};