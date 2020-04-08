import { FC } from 'react'
import Head from 'next/head'
import useSWR from 'swr'
import CMSHeader from "../../../components/cms/header"
import { Flex, Box, Text, Button, useToast } from '@chakra-ui/core'
import { swrFetcherJSON } from '../../../utils/apiClient'
import { FaEdit } from 'react-icons/fa'
import PreloadFetch from '../../../components/Utils/PreloadFetch'
import styled from '@emotion/styled'
import FlexBox from '../../../components/shared/FlexBox'
import { ConsumerProduct } from '../../../types/product'
import Link from 'next/link'

const OverviewTable = styled.table`
  tr th {
    text-align: left;
  }
`

const ProductOverview: FC = () => {
  const toast = useToast()
  const swr = useSWR('/products', swrFetcherJSON, {
    loadingTimeout: 0,
    onError: (err) => console.error('Error SWR', err),
    onLoadingSlow: () => console.log('Loading slow SWR')
  })

  if (!swr.data) {
    return <></>
  }

  const deleteProduct = async (id: number) => {
    const res = await fetch(`${process.env.API_URL}/product?id=${id}`, {
      method: 'DELETE'
    })

    if (res.status !== 200) {
      return toast({
        title      : 'Er is iets fout gegaan..',
        description: 'Probeer later opnieuw',
        duration   : 10000,
        isClosable : true,
        status     : 'error'
      })
    }
    toast({
      title     : 'Product is verwijderd',
      duration  : 10000,
      isClosable: true,
      status    : 'success'
    })
    await swr.revalidate()
  }

  return (

    <>
      <Head>
        <title>Admin Panel - Product Overzicht</title>
        <PreloadFetch apiPath='/orders/stats' />
        <PreloadFetch apiPath='/orders/last' />
      </Head>

      <CMSHeader />

      <FlexBox>


        <Flex>
          <Text fontSize="lg" mb="0.75rem" fontWeight="bold">Product Overzicht</Text>
          <Box ml='auto'>
            <Link href={'/cms/product/create'}>
              <Button rightIcon="add" bg='secondary.500' color='white' size="sm">Nieuw</Button>
            </Link>
          </Box>
        </Flex>

        <OverviewTable>
          <thead>
            <th># ID</th>
            <th>Naam</th>
            <th></th>
          </thead>
          {swr.data.map((currentProduct: ConsumerProduct) => (
            <tbody key={currentProduct.id}>
              <td># {currentProduct.id}</td>
              <td>{currentProduct.name}</td>
              <td>
                <Link href={`/cms/product/update?id=${currentProduct.id}`}>
                  <>
                    <Flex>
                      <Button marginLeft='1rem' rightIcon="edit" ml='auto' bg='contrast.500' color='white' size="sm">
                        Bewerken
                      </Button>
                      <Box marginLeft='1rem'>
                        <Button onClick={() => deleteProduct(currentProduct.id)} rightIcon="edit" ml='auto' bg='red.500' color='white' size="sm">
                          Verwijderen
                        </Button>
                      </Box>
                    </Flex>
                  </>
                </Link>
              </td>
            </tbody>
          ))}


        </OverviewTable>

      </FlexBox>
    </>

  )
}

export default ProductOverview
