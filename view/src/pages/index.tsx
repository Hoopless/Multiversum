import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Box, Text } from '@chakra-ui/core'
import Footer from '../components/Footer'
import ProductList from '../components/Homepage/ProductsList'
import SalesList from '../components/Homepage/SalesList'
import PreloadFetch from '../components/Utils/PreloadFetch'
import getPageContent from '../utils/getPageContent'
import FlexBox from '../components/shared/FlexBox'
import styled from '@emotion/styled'

const BackgroundImage = styled.div`
	background-image: url('/img/pattern.png');
`;

export interface HomepageData {
	header_title: string
	header_text : string
}

const HomePage = () => {
	const homepageCMS = getPageContent('Homepage')

	if (!homepageCMS) {
		return (<></>)
	}

	const cmsContent = homepageCMS.values

	return (
		<>
			<Head>
				<title>Homepage</title>
				<PreloadFetch apiPath='/products?limit=50' />
				<PreloadFetch apiPath='/products?sales=true&limit=6' />
				<PreloadFetch apiPath='/page?id=1' />
			</Head>

			<BackgroundImage>
			<Flex direction='column'
				minHeight='100vh'
				>
				<Header />

				<FlexBox>

					<Box px={['20px', '100px', '200px', '100px']}
						mb='10px'>
						<Text fontSize='lg'
							fontWeight='bold'>
							{cmsContent.header_title}
						</Text>
						<Text fontSize='md'>
							{cmsContent.header_text}
						</Text>
						<Text fontSize='lg'
							fontWeight='bold'
							mt="15px">
							Aanbiedingen
						</Text>
					</Box>
					<Box px={['20px', '100px', '200px', '100px']}
						mb='3rem'>
						<SalesList />
					</Box>

					<ProductList />

					</FlexBox>

				<Footer />
			</Flex>
			</BackgroundImage>
		</>
	)
}

export default HomePage
