import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Box, Text } from '@chakra-ui/core'
import Footer from '../components/Footer'
import ProductList from '../components/Homepage/ProductsList'
import SalesList from '../components/Homepage/SalesList'
import PreloadFetch from '../components/Utils/PreloadFetch'
import useSWR from "swr";
import {swrFetcherJSON} from "../utils/apiClient";

interface homepageData{
	homepage_title: string
	homepage_text: string
}

const HomePage = () => {

	const { data } = useSWR('/pages?id=1', swrFetcherJSON, {
		loadingTimeout: 0,
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
	})


	return (
		<>
			<Head>
				<title>Homepage</title>
				<PreloadFetch apiPath='/products?limit=50'/>
				<PreloadFetch apiPath='/products?sales=true&limit=6'/>
				<PreloadFetch apiPath='/pages?id=1'/>
			</Head>

			<Flex direction='column'
				  minHeight='100vh'
				  justifyContent='space-between'>
				<Header/>

				<Flex
					direction='column'
					width={['100%', '100%', '100%', '992px']}
					mx='auto'
				>
					<Box px={['20px', '100px', '200px', '100px']}
						 mb='10px'>
						<Text fontSize='lg'
							  fontWeight='bold'>
							{data.homepage_title}
						</Text>
						<Text fontSize='md'>
							{data.homepage_text}
						</Text>
						<Text fontSize='lg'
							  fontWeight='bold'
							  mt="15px">
							Aanbiedingen
						</Text>
					</Box>
					<Box px={['20px', '100px', '200px', '100px']}
						 mb='3rem'>
						<SalesList/>
					</Box>

					<ProductList/>
				</Flex>
				<Footer/>
			</Flex>
		</>
	)
}

export default HomePage
