const withCSS = require('@zeit/next-css')
const envVariables = require('dotenv').config()

module.exports = withCSS({
  env: {
    API_URL: envVariables.API_URL || '/api/v1'
  },
  cssLoaderOptions: {
    importLoaders: 1,
    localIdentName: '[local]___[hash:base64:5]',
  }
})
