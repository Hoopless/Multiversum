import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Box, Text } from '@chakra-ui/core'
import Footer from '../components/Footer'
import ProductList from '../components/Homepage/ProductsList'
import SalesList from '../components/Homepage/SalesList'
import PreloadFetch from '../components/Utils/PreloadFetch'

const HomePage = () => (
  <>
    <Head>
      <title>Homepage</title>
			<PreloadFetch apiPath='/products?limit=50' />
			<PreloadFetch apiPath='/products?sales=true&limit=6' />
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
            Welkom bij Multiversum!
          </Text>
          <Text fontSize='md'>
            Zoek jouw favoriete VR-Bril bij Multiversum tegen scherpe prijzen. Maar let op: onze
            aanbiedingen gaan als warme broodjes over de toonbank, dus wees er
            snel bij.
          </Text>
			<Text fontSize='lg' fontWeight='bold' mt="15px">
				Aanbiedingen
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
