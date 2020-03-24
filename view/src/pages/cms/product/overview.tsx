import { FC } from 'react'
import Head from 'next/head'
import useSWR from 'swr'
import CMSHeader from "../../../components/cms/header"
import { Flex, Box, Text, Button } from '@chakra-ui/core'
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
    const { data } = useSWR('/products', swrFetcherJSON, {
		loadingTimeout: 0,
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
		})

		if (!data) {
			return <></>
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
          {data.map((currentProduct: ConsumerProduct) => (
            <tbody key={currentProduct.id}>
              <td># {currentProduct.id}</td>
              <td>{currentProduct.name}</td>
              <td>
                <Link href={`/cms/product/update?id=${currentProduct.id}`}>
                  <Button rightIcon="edit" ml='auto' bg='contrast.500' color='white' size="sm">Bewerken</Button>
                </Link>
              </td>
            </tbody>
          ))}


        </OverviewTable>

      </FlexBox>
    </>

  )
};

export default ProductOverview
