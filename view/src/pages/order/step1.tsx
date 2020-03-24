import Head from 'next/head'
import Header from '../../components/Header'
import { Flex, Box, Text, Input, Button } from '@chakra-ui/core'
import Footer from '../../components/Footer'
import PreloadFetch from '../../components/Utils/PreloadFetch'
import FlexBox from '../../components/shared/FlexBox'
import OrderProgress from '../../components/order/OrderProgress'


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


          <OrderProgress step={1} />

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
