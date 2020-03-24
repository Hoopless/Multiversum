import NextApp from 'next/app'
import MultiversumTheme from '../theme'
import { CSSReset, ThemeProvider } from '@chakra-ui/core'
import OrderProvider from '../context/OrderContext/OrderProvider'

class CustomApp extends NextApp {
  render () {
    const { Component } = this.props

    return (
      <ThemeProvider theme={MultiversumTheme}>
        <OrderProvider>

        <CSSReset />
        <Component />
        </OrderProvider>
      </ThemeProvider>
    )
  }
}

export default CustomApp
