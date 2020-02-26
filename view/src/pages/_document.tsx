import Document, { Html, Head, Main, NextScript } from 'next/document'
import { ThemeProvider, CSSReset } from '@chakra-ui/core'
import MultiversumTheme from '../theme'

class CustomDocument extends Document {
  render() {
    return (
      <ThemeProvider theme={MultiversumTheme}>
        <CSSReset />

        <Html>
        <Head>
          <link href="https://fonts.googleapis.com/css?family=Quicksand:300&display=swap" rel="stylesheet" />
          <link rel='icon' type='image/png' href='/img/logo.png' />
        </Head>
        <body>
          <Main />
          <NextScript />
        </body>
      </Html>
      </ThemeProvider>
    )
  }
}

export default CustomDocument
