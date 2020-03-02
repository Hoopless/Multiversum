const envVariables = require('dotenv').config()

module.exports = {
  env: {
    API_URL: envVariables.API_URL || 'http://localhost/api/v1'
  }
}
