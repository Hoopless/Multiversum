import Head from 'next/head'
import Header from '../components/Header'
import { Flex } from '@chakra-ui/core'
import Footer from '../components/Footer'

const HomePage = () => (
  <>
    <Head>
      <title>Homepage</title>
    </Head>

      <Header />

      <Footer />
  </>
)

export default HomePage