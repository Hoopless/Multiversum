import { FC } from 'react'
import Head from 'next/head'
import { Flex, Box, Text } from '@chakra-ui/core'
import { useRouter } from "next/router"
import Header from '../../components/Header'
import Footer from '../../components/Footer'
import Productshow from "../../components/Products/show"



const ProductDetail: FC = () => {
    const router = useRouter()
    const { id } = router.query


  return (
    <>
        <Head>
            <title>Homepage</title>
        </Head>


        <Flex direction='column' minHeight='100vh' justifyContent='space-between'>
            <Header />

            <Productshow />

            <Footer />
        </Flex>

    </>
  )
}

export default ProductDetail
