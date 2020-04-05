import Head from 'next/head'
import Header from '../../components/Header'
import { Flex, Box, Text } from '@chakra-ui/core'
import Footer from '../../components/Footer'
import PreloadFetch from '../../components/Utils/PreloadFetch'
import FlexBox from '../../components/shared/FlexBox'
import { useRouter } from 'next/router'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'

const OrderProcessing = ({ }) => {
  const router = useRouter()
  const { orderId } = router.query

  const { data: orderStatus } = useSWR(`/order/status/?id=${orderId}`, swrFetcherJSON)

  if (!orderId || !orderStatus?.id) {
    return <></>
  }

  return (
    <>
      <Head>
        <title>Order geplaatst - Bedankt voor uw bestelling!</title>
      </Head>

      <Flex direction='column'
        minHeight='100vh'
        justifyContent='space-between'>
        <Header />

        <FlexBox>


          <Flex w="100%" justifyContent="center" align="center">
            <svg xmlns="http://www.w3.org/2000/svg" width="250.271" height="187.703" viewBox="0 0 250.271 187.703">
              <path id="envelope-regular" d="M226.808,64H23.463A23.463,23.463,0,0,0,0,87.463V228.24A23.463,23.463,0,0,0,23.463,251.7H226.808a23.463,23.463,0,0,0,23.463-23.463V87.463A23.463,23.463,0,0,0,226.808,64Zm0,23.463v19.946c-10.96,8.925-28.433,22.8-65.788,52.053-8.232,6.475-24.539,22.032-35.885,21.85-11.344.183-27.656-15.377-35.885-21.85C51.9,130.217,34.424,116.335,23.463,107.409V87.463ZM23.463,228.24V137.516c11.2,8.921,27.084,21.44,51.295,40.4,10.684,8.41,29.394,26.976,50.378,26.863,20.881.113,39.354-18.183,50.373-26.859,24.21-18.958,40.1-31.48,51.3-40.4V228.24Z" transform="translate(0 -64)" fill="#1dbc9c" />
            </svg>
          </Flex>
          <Box w="100%" textAlign="center">
            <Text fontSize="lg" fontWeight="bold" my="20px" mt="30px">Alles is volgens planning gegaan!  Order nummer: #{orderId}</Text>
            <Text fontSize="md" my="10px">U krijgt nu een e-mail met informatie over de bestelling en levering.</Text>
            <Text fontSize="md" my="10px">Heeft u vragen of opmerkingen over uw bestelling? neem contact met ons op.</Text>

          </Box>

        </FlexBox>
        <Footer />
      </Flex>
    </>
  )
}

export default OrderProcessing
