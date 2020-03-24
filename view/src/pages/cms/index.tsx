import { FC } from 'react'
import Head from 'next/head'
import useSWR from 'swr'
import CMSHeader from "../../components/cms/header"
import { Flex, Box, Text, Button } from '@chakra-ui/core'
import { FaEdit } from 'react-icons/fa'
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
          <Box ml='auto'>
            <Link href={'/cms/product/create'}>
              <Button rightIcon="add" bg='secondary.500' color='white' size="sm">Nieuw</Button>
            </Link>
          </Box>
        </Flex>

        <Flex align="center" justifyContent="center" wrap="wrap">

            <Flex w='50%' wrap="wrap" justifyContent="center">
                <Text fontSize="lg" mb="0.75rem">Producten</Text>
                <Box w="100%">
                    Nieuw product aanmaken <br/>
                    <Link href={'/cms/product/create'}>
                        <Button rightIcon="add" bg='secondary.500' color='white' size="sm">Nieuw</Button>
                    </Link>
                </Box>
                <Box w="100%">
                    producten overzicht en bewerken<br/>
                    <Link href={'/cms/product/create'}>
                        <Button rightIcon="add" bg='secondary.500' color='white' size="sm">Nieuw</Button>
                    </Link>
                </Box>

            </Flex>

            <Flex w='50%' wrap="wrap" justifyContent="center">
                <Text fontSize="lg" mb="0.75rem">Pagina's</Text>
                <Box w="100%">
                    <Link href={'/cms/pages/update'}>
                        Pagina's bijwerken
                    </Link>
                </Box>

            </Flex>

        </Flex>

      </FlexBox>
    </>

  )
};

export default CMSOverview
