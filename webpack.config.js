/**
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author    Karlis Suvi
*  @copyright 2022 Karlis Suvi
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/
const TerserPlugin = require('terser-webpack-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const path = require('path');

module.exports = {
  entry: {
    combinationeditor: './_dev/combinationeditor',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, './views/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },
  resolve: {
    extensions: ['.js'],
    alias: {
      '@components': path.resolve(__dirname, '../../admin-dev/themes/new-theme/js/components'),
    },
  },
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin({extractComments: false})],
  },
  stats: {
    colors: true,
  },
  devtool: 'source-map',
  plugins: [
    new CleanWebpackPlugin(),
  ],
};
