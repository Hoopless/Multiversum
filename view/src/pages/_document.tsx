import Document, { Html, Head, Main, NextScript } from 'next/document'

class CustomDocument extends Document {
  render() {
    return (
      <Html>
        <Head>
          <link rel='icon' type='image/png' href='/img/logo.png' />
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
