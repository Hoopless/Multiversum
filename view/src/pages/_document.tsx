import Document, { Html, Head, Main, NextScript } from 'next/document'
import theme from '../theme'

class CustomDocument extends Document {
  render() {
    return (
      <Html>
        <Head>
          <link
            href='https://fonts.googleapis.com/css?family=Quicksand:300&display=swap'
            rel='stylesheet'
          />
          <link rel='icon' type='image/png' href='/img/logo.png' />
          <style>
            {`
              html, body {
                background-color: ${theme.colors.background}
              }
            `}
          </style>
        </Head>
        <body>
          <Main />
          <NextScript />
        </body>
      </Html>
    )
  }
}

export default CustomDocument
