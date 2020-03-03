import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Box, Text } from '@chakra-ui/core'
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

      <Flex
        direction='column'
        width={['100%', '100%', '100%', '992px']}
        mx='auto'
      >
        <Box px={['20px', '100px', '200px', '100px']} mb='10px'>
          <Text fontSize='lg' fontWeight='bold'>
            Aanbiedingen
          </Text>
          <Text fontSize='md'>
            Zoek jouw favoriete product tussen alle aanbiedingen en je hebt hem
            de volgende dag in huis tegen een scherpe korting. Maar let op: onze
            aanbiedingen gaan als warme broodjes over de toonbank, dus wees er
            snel bij.
          </Text>
        </Box>
        <Box px={['20px', '100px', '200px', '100px']} mb='3rem'>
          <SalesList />
        </Box>

        <ProductList />
      </Flex>
      <Footer />
    </Flex>
  </>
)

export default HomePage
