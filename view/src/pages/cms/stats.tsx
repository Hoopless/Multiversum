import { FC } from 'react'
import Head from 'next/head'
import useSWR from 'swr'
import CMSHeader from "../../components/cms/header"
import { swrFetcherJSON } from '../../utils/apiClient'
import currencyFormat from '../../utils/priceFormat'
import { Flex, Box, Text, Button } from '@chakra-ui/core'
import { FaPlus, FaListUl, FaEdit } from 'react-icons/fa'
import PreloadFetch from '../../components/Utils/PreloadFetch'
import styled from '@emotion/styled'
import FlexBox from '../../components/shared/FlexBox'
import { ConsumerProduct } from '../../types/product'
import Link from 'next/link'

const OverviewTable = styled.table`
    width: 100%;
  tr, th {
        text-align: left;
    }

    #right-align {
        text-align: right;
    }

`

export interface OrderStatsData {
  id: number
  total_price_inc: number
  total_price_ex: number
  ordered_date: string
  shipped_date: string
  product: string
  payment_name: string
  contact_name: string
}

export interface OrderStats {
    month: string
    amount: string
}


const CMSOverview: FC = () => {

    const { data: orders } = useSWR('/orders/last', swrFetcherJSON, {
		loadingTimeout: 0,
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
        })

    const { data: orderStats } = useSWR('/orders/stats', swrFetcherJSON, {
		loadingTimeout: 0,
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
		})

		if (!orders) {
			return <></>
        }

        if(! orderStats){
            return <></>
        }

  return (

    <>
      <Head>
        <title>Admin Panel - Order Stats</title>
        <PreloadFetch apiPath='/orders/last' />
        <PreloadFetch apiPath='/orders/stats' />
      </Head>

      <CMSHeader />

      <FlexBox>

        <Text fontSize="xl" mb="0.75rem" fontWeight="bold" textAlign="center">Order statieken</Text>

        <Flex wrap="wrap">

        <Box w={["100%", "100%", "50%", "50%"]} px="10px">
            <Box bg="white" p="15px">
            <OverviewTable>
            <thead>
                <th>Maand</th>
                <th>Aantal orders</th>
                <th></th>
            </thead>


            {orderStats.map((currentOrder: OrderStats) => (
            <tbody key={currentOrder.month}>
              <td>{currentOrder.month}</td>
              <td>{currentOrder.amount}</td>
            </tbody>
          ))}

            </OverviewTable>
            </Box>
        </Box>

        <Box w={["100%", "100%", "50%", "50%"]}  px="10px">
            <Box bg="white" p="15px">
            <OverviewTable>
            <thead>
                <th>Order #</th>
                <th>Verkocht product</th>
                <th id="right-align">Totaal prijs inc. BTW</th>
            </thead>
            {orders.map((currentOrder: OrderStatsData) => (
            <tbody key={currentOrder.id}>
              <td># {currentOrder.id}</td>
              <td>{currentOrder.product}</td>
              <td id="right-align"> € {currencyFormat(currentOrder.total_price_inc)}</td>
            </tbody>
          ))}
            </OverviewTable>
            </Box>
        </Box>

        </Flex>

      </FlexBox>
    </>

  )
};

export default CMSOverview
