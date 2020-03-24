import Head from 'next/head'
import { Flex, Box, Text, Button } from '@chakra-ui/core'
import Header from '../components/Header'
import Footer from '../components/Footer'
import FlexBox from '../components/shared/FlexBox'

const Error404 = () => {
	return (
		<>
			<Head>
				<title>Multiversum - Error 404</title>
			</Head>

			<Flex direction="column" minHeight="100vh" justifyContent="space-between">
				<Header />

				<FlexBox>

					<Flex justifyContent="Center" wrap="wrap" align="center">
            <Text fontSize="2xl" color="contrast.500" my="10px" textAlign="center" w="100%">404</Text>
						<Text fontSize="md" my="10px" textAlign="center"  w="100%">Je bent verwaald. Deze pagina kon niet worden gevonden in het dolhof.</Text>
            <a href="/"><Button bg='secondary.500' color='white'>Ga naar de Homepagina</Button></a>
					</Flex>

				</FlexBox>

        <Footer />
			</Flex>
		</>
	)
}

export default Error404
