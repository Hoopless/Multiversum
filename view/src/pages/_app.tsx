import NextApp from 'next/app'
import MultiversumTheme from '../theme'
import { CSSReset, ThemeProvider } from '@chakra-ui/core'

class CustomApp extends NextApp {
  render () {
    const { Component } = this.props

    return (
      <ThemeProvider theme={MultiversumTheme}>
        <CSSReset />
        <Component />
      </ThemeProvider>
    )
  }
}

export default CustomApp
