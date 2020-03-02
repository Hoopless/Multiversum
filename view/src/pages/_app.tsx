import NextApp from 'next/app'
import MultiversumTheme from '../theme'
import { CSSReset, ColorModeProvider, ThemeProvider } from '@chakra-ui/core'

import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

class CustomApp extends NextApp {
  render () {
    const { Component } = this.props

    return (
      <ThemeProvider theme={MultiversumTheme}>
        <CSSReset />
        
        <ColorModeProvider>
          <Component />
        </ColorModeProvider>
      </ThemeProvider>
    )
  }
}

export default CustomApp
