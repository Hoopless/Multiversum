import Head from 'next/head'
import {useFormik} from 'formik'
import CMSHeader from "../../../components/cms/header";
import {
	Flex,
	Input,
	Box,
	Text,
	Textarea,
	Checkbox,
	Stack,
	Button,
	FormControl,
	CheckboxGroup,
	Switch,
	Tabs,
	TabList,
	Tab,
	TabPanels,
	TabPanel
} from '@chakra-ui/core'
import {useState, FC, ChangeEvent} from 'react'
import {FaCheck} from 'react-icons/fa'


interface FormValues {

}

const CMSCreate: FC = () => {
	const [lastProductID, setLastProductID] = useState(false)
	// const productForm = useFormik({
	// 	initialValues: {
	//
	// 	},
	// 	validate: values => {
	// 		console.log(2)
	// 		values
	// 	},
	// 	onSubmit: console.log(1)
	//
	// })

	return (
		<>
			<Head>
				<title>Admin Panel - Pagina's bewerken</title>
			</Head>

			<CMSHeader/>

			<Flex width={['100%', '100%', '992px']}
				  mx='auto'
				  flexDirection="column">

				{lastProductID && (
					<Flex pb='15px'
						  alignItems="Center"
						  justifyContent="center"
						  w="100%"
						  wrap="wrap"
						  bg="green.100"
						  px="10px"
						  py="5px">
						<Flex w="80%"
							  alignItems="Center"
							  justifyContent="center">
							<FaCheck size="30px"
									 color="#1ABC9C"/>
						</Flex>
						<Text fontSize='sm'
							  color='green.600'
							  w="100%"
							  textAlign="center">Pagina aangemaakt!</Text>
						<Box fontSize='sm'
							 color='green.600'
							 w="100%"
							 textAlign="center">Bekijk de pagina voor de veranderingen.</Box>
					</Flex>
				)}

						<Text fontSize="lg"
							  w="100%"
							  mb="0.75rem"
							  fontWeight="bold">Pagina's bijwerken</Text>


						<Flex w="100%">
							<Tabs variant='soft-rounded'
								  variantColor='gray'
								  w="100%"
								  isFitted>
								<TabList>
									<Tab>Homepagina</Tab>
									<Tab>Contact Pagina</Tab>
									<Tab>Algemeene voorwaarden</Tab>
									<Tab>Leverings voorwaarden</Tab>
								</TabList>

								<TabPanels>
									<TabPanel>

										<form>
											<FormControl>

												<Text mt='10px'
													  fontSize="md"
													  fontWeight="bold">SEO - Google kenmerken.</Text>

												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Meta Title</Text>
													<Input
														isRequired
														id="meta_title"
														name="meta_title"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Meta beschrijving</Text>
													<Text mb="2px"
														  fontSize="sm">Optimaal lengte aantaal karakters is 160</Text>
													<Input
														isRequired
														id="meta_description"
														name="meta_description"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Homepagina titel</Text>
													<Input
														isRequired
														id="homepage_title"
														name="homepage_title"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Homepagina tekst</Text>
													<Textarea
														id='homepage_text'
														name='homepage_text'
													/>
												</Box>

												<Flex alignItems='end'
													  w='100%'>
													<Button ml='auto'
															bg='secondary.500'
															color='white'
															type='submit'>Versturen</Button>
												</Flex>
											</FormControl>
										</form>
									</TabPanel>
									<TabPanel>

										<form>
											<FormControl>

												<Text mt='10px'
													  fontSize="md"
													  fontWeight="bold">SEO - Google kenmerken.</Text>

												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Meta Title</Text>
													<Input
														isRequired
														id="meta_title"
														name="meta_title"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Meta beschrijving</Text>
													<Text mb="2px"
														  fontSize="sm">Optimaal lengte aantaal karakters is 160</Text>
													<Input
														isRequired
														id="meta_description"
														name="meta_description"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">Bedrijfsinformatie</Text>
													<Input
														isRequired
														id="contact_content"
														name="homepage_title"
														type="text"
														size="md"
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">KVK Nummer</Text>
													<Textarea
														id='kvk_number'
														name='kvk_number'
													/>
												</Box>
												<Box w="100%"
													 pr="10rem"
													 mb="10px">
													<Text mb="2px">BTW Nummer</Text>
													<Textarea
														id='btw_number'
														name='btw_number'
													/>
												</Box>

												<Flex alignItems='end'
													  w='100%'>
													<Button ml='auto'
															bg='secondary.500'
															color='white'
															type='submit'>Versturen</Button>
												</Flex>

											</FormControl>
										</form>
									</TabPanel>

								</TabPanels>
							</Tabs>
						</Flex>
			</Flex>
		</>
)
}

export default CMSCreate
