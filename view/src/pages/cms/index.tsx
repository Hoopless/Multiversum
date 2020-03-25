import { FC } from 'react'
import Head from 'next/head'
import useSWR from 'swr'
import CMSHeader from "../../components/cms/header"
import { Flex, Box, Text, Button } from '@chakra-ui/core'
import { FaPlus, FaListUl, FaEdit, FaChartBar } from 'react-icons/fa'
import PreloadFetch from '../../components/Utils/PreloadFetch'
import styled from '@emotion/styled'
import FlexBox from '../../components/shared/FlexBox'
import { ConsumerProduct } from '../../types/product'
import Link from 'next/link'


const CMSOverview: FC = () => {

  return (

    <>
      <Head>
        <title>Admin Panel - CMS Overzicht</title>
        <PreloadFetch apiPath='/products' />
      </Head>

      <CMSHeader />

      <FlexBox>


        <Flex>
          <Text fontSize="xl" mb="0.75rem" fontWeight="bold">Snel menu</Text>

        </Flex>

        <Flex wrap="wrap">

        <Link href={'/cms/product/create'}>
            <Flex mx="5px" w="20%" h="150px" bg="#bebebe" p="10px" justifyContent="center" align="center" wrap="wrap">
                <Flex w='100%' justifyContent="center">
                    <FaPlus size="4rem" />
                </Flex>
                <Box w="100%" textAlign="center">
                    Nieuw product aanmaken
                </Box>
            </Flex>
        </Link>

        <Link href={'/cms/product/overview'}>
            <Flex mx="5px" w="20%" h="150px" bg="#bebebe" p="10px" justifyContent="center" align="center" wrap="wrap">
                <Flex w='100%' justifyContent="center">
                    <FaListUl size="4rem" />
                </Flex>
                <Box w="100%" textAlign="center">
                    Producten overzicht
                </Box>
            </Flex>
        </Link>



        <Link href={'/cms/pages/update'}>
            <Flex mx="5px" w="20%" h="150px" bg="#bebebe" p="10px" justifyContent="center" align="center" wrap="wrap">
                <Flex w='100%' justifyContent="center">
                    <FaEdit size="4rem" />
                </Flex>
                <Box w="100%" textAlign="center">
                    Pagina's bewerken
                </Box>
            </Flex>
        </Link>

        <Link href={'/cms/stats'}>
            <Flex mx="5px" w="20%" h="150px" bg="#bebebe" p="10px" justifyContent="center" align="center" wrap="wrap">
                <Flex w='100%' justifyContent="center">
                    <FaChartBar size="4rem" />
                </Flex>
                <Box w="100%" textAlign="center">
                    Order statistieken
                </Box>
            </Flex>
        </Link>

        </Flex>

      </FlexBox>
    </>

  )
};

export default CMSOverview
