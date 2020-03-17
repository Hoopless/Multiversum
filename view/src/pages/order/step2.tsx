import Head from 'next/head'
import Header from '../../components/Header'
import { Flex, Box, Text, Input, Button } from '@chakra-ui/core'
import Footer from '../../components/Footer'
import PreloadFetch from '../../components/Utils/PreloadFetch'



const OrderConfirmStep2 = () => {

	return (
		<>
			<Head>
				<title>Homepage</title>
				<PreloadFetch apiPath='/products?limit=50' />
				<PreloadFetch apiPath='/products?sales=true&limit=6' />
			</Head>

			<Flex direction='column'
				  minHeight='100vh'
				  justifyContent='space-between'>
				<Header />

				<Flex
					direction='column'
					width={['100%', '100%', '100%', '992px']}
					mx='auto'
				>


					<Flex align='center' wrap='wrap' justifyContent="center">
						<svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 0 1041.65 44.41">
							<g id="Steps" transform="translate(-433.35 -237.59)">
								<path id="Path_3" data-name="Path 3" d="M0,0H382.65V44.41H0Z" transform="translate(1092.351 237.59)" fill="#2c3e50"/>
								<a href=''><path id="Path_4" data-name="Path 4" d="M0,0H321.73l38.85,23.895L321.73,44.41H0Z" transform="translate(788.351 237.59)" fill="#f1c42c"/></a>
								<path id="Path_1" data-name="Path 1" d="M0,0H350.2l42.287,23.895L350.2,44.41H0Z" transform="translate(433.35 237.59)" fill="#1dbc9c"/>
								<text id="Stap_1:_Informatie" data-name="Stap 1: Informatie" transform="translate(544 267)" fill="#fff" font-size="20" font-family="Ubuntu"><tspan x="0" y="0">Stap 1: Informatie</tspan></text>
								<text id="Stap_2:_Betaling" data-name="Stap 2: Betaling" transform="translate(885 267)" fill="#fff" font-size="20" font-family="Ubuntu"><tspan x="0" y="0">Stap 2: Betaling</tspan></text>
								<text id="Stap_3:_Confirmatie" data-name="Stap 3: Confirmatie" transform="translate(1217 267)" fill="#fff" font-size="20" font-family="Ubuntu"><tspan x="0" y="0">Stap 3: Confirmatie</tspan></text>
							</g>
						</svg>
					</Flex>

					<Text mt="20px" mb="10px" px="15px" fontSize="lg" fontWeight="bold">Stap 2: Betaling</Text>

					<Flex w="100%" wrap='wrap'>

						<Flex w="33.33%" bg="white" py="20px" px="10px" wrap="wrap" >
							<Flex w="15%" justifyContent="center"my="auto">
								<input type="radio"/>
							</Flex>
							<Flex w="35%" justifyContent="center"my="auto" >
								<svg xmlns="http://www.w3.org/2000/svg" width="62.857" height="55" viewBox="0 0 62.857 55">
									<path id="wallet-solid" d="M56.621,43.786H9.821a1.964,1.964,0,0,1,0-3.929H56.964a1.964,1.964,0,0,0,1.964-1.964A5.893,5.893,0,0,0,53.036,32H7.857A7.857,7.857,0,0,0,0,39.857V79.143A7.857,7.857,0,0,0,7.857,87H56.621a6.078,6.078,0,0,0,6.237-5.893V49.679A6.078,6.078,0,0,0,56.621,43.786ZM51.071,69.321A3.929,3.929,0,1,1,55,65.393,3.929,3.929,0,0,1,51.071,69.321Z" transform="translate(0 -32)" fill="#707070"/>
								</svg>
							</Flex>
								<Box w="50%" bg="white" py="20px" px="10px">
									<Text>Contant</Text>
									<Text>Kosten: € 0,00</Text>
								</Box>
						</Flex>



					</Flex>

					<Flex alignItems='end' w='100%'>
						<Button ml='auto' bg='secondary.500' color='white' type='submit' rightIcon="arrow-forward" >Volgende stap</Button>
					</Flex>
				</Flex>
				<Footer />
			</Flex>
		</>
	)
};

export default OrderConfirmStep2
