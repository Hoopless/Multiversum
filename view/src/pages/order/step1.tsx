import Head from 'next/head'
import Header from '../../components/Header'
import { Flex, Box, Text, Input, Button } from '@chakra-ui/core'
import Footer from '../../components/Footer'
import PreloadFetch from '../../components/Utils/PreloadFetch'
import FlexBox from '../../components/shared/FlexBox'


const OrderConfirmStep1 = () => {

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

				<FlexBox>


					<Flex align='center' wrap='wrap' justifyContent="center">
					<svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 0 1041.65 44.41">
						<g id="Steps" transform="translate(-433.35 -237.59)">
						<path id="Path_3" data-name="Path 3" d="M0,0H382.65V44.41H0Z" transform="translate(1079.351 237.59)" fill="#2c3e50"/>
						<path id="Path_4" data-name="Path 4" d="M0,0H321.73l38.85,23.895L321.73,44.41H0Z" transform="translate(775.351 237.59)" fill="#f1c42c"/>
						<path id="Path_1" data-name="Path 1" d="M0,0H350.2l42.287,23.895L350.2,44.41H0Z" transform="translate(433.35 237.59)" fill="#1dbc9c"/>
						<text id="Stap_1:_Informatie" data-name="Stap 1: Informatie" transform="translate(544 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 1: Informatie</tspan></text>
						<text id="Stap_2:_Betaling" data-name="Stap 2: Betaling" transform="translate(872 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 2: Betaling</tspan></text>
						<text id="Stap_3:_Confirmatie" data-name="Stap 3: Confirmatie" transform="translate(1204 267)" fill="#fff" font-size="20" font-weight="bold"><tspan x="0" y="0">Stap 3: Confirmatie</tspan></text>
						</g>
					</svg>
					</Flex>

					<Text mt="20px" mb="10px" px="15px" fontSize="lg" fontWeight="bold">Stap 1: Informatie</Text>

					<Flex w="100%" wrap='wrap'>

						<Flex w="70%" wrap="wrap">
							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">Voornaam</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">Achternaam</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">E-mail</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">Telefoonnummer</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Text mt="10px" w="100%" px="15px" fontWeight="bold">Aflever gegevens</Text>
							<Box w="75%" px="15px" mb="10px">
								<Text mb="2px">Straat</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Box w="25%" px="15px" mb="10px">
								<Text mb="2px">Huisnummer</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>

							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">Postcode</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
							<Box w="50%" px="15px" mb="10px">
								<Text mb="2px">Stad</Text>
								<Input
									isRequired
									id="name"
									name="name"
									type="text"
									size="md"
								/>
							</Box>
						</Flex>

					</Flex>

					<Flex alignItems='end' w='100%'>
						<Button ml='auto' bg='secondary.500' color='white' type='submit' rightIcon="arrow-forward" >Volgende stap</Button>
					</Flex>
				</FlexBox>
				<Footer />
			</Flex>
		</>
	)
};

export default OrderConfirmStep1
