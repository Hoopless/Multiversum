import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Box } from '@chakra-ui/core'
import Footer from '../components/Footer'
import ProductList from '../components/Homepage/ProductsList'
import SalesList from '../components/Homepage/SalesList'

const HomePage = () => (
  <>
    <Head>
      <title>Homepage</title>
    </Head>

    <Flex direction='column' minHeight='100vh' justifyContent='space-between'>
      <Header />

      <Flex direction='column' width={['100%', '100%', '1680px', '1680px']} mx='auto'>
        <Box px='400px'>
            <SalesList />
        </Box>

        <ProductList />
      </Flex>
      <Footer />
    </Flex>
  </>
)

export default HomePage
