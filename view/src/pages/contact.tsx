import Head from 'next/head'
import Header from '../components/Header'
import { Flex } from '@chakra-ui/core'
import Footer from '../components/Footer'
import Contact from '../components/Contact'

const ContactPage = () => (
  <>
    <Head>
      <title>Contact</title>
    </Head>

    <Flex direction='column' minHeight='100vh' justifyContent='space-between'>
      <Header />

      <Contact />
      <Footer />
    </Flex>
  </>
)

export default ContactPage
