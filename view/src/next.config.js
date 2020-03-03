require('dotenv').config()
const withCSS = require('@zeit/next-css')

module.exports = withCSS({
  env: {
    API_URL: process.env.API_URL || 'http://localhost:8080/api/v1'
  },
  cssLoaderOptions: {
    importLoaders: 1,
    localIdentName: '[local]___[hash:base64:5]',
  }
})
