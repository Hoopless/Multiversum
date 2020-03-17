import Head from 'next/head'
import { useFormik } from 'formik'
import CMSHeader from '../../../components/cms/header'
import { useState, FC, ChangeEvent } from 'react'
import { FaCheck } from 'react-icons/fa'
import {
	Flex,
	Input,
	Box,
	Text,
	Textarea,
	Button,
	FormControl,
	Tabs,
	TabList,
	Tab,
	TabPanels,
	TabPanel,
} from '@chakra-ui/core'

const CMSCreate: FC = () => {
	return (
		<>
			<Head>
				<title>Admin Panel - Pagina's bewerken</title>
			</Head>

			<CMSHeader />

			<Flex width={['100%', '100%', '992px']} mx='auto' flexDirection='column'>
				{/* <Flex
					pb='15px'
					alignItems='Center'
					justifyContent='center'
					w='100%'
					wrap='wrap'
					bg='green.100'
					px='10px'
					py='5px'
				>
					<Flex w='80%' alignItems='Center' justifyContent='center'>
						<FaCheck size='30px' color='#1ABC9C' />
					</Flex>
					<Text fontSize='sm' color='green.600' w='100%' textAlign='center'>
						Pagina aangemaakt!
					</Text>
					<Box fontSize='sm' color='green.600' w='100%' textAlign='center'>
						Bekijk de pagina voor de veranderingen.
					</Box>
				</Flex> */}

				<Text fontSize='lg' w='100%' mb='0.75rem' fontWeight='bold'>
					Pagina's bijwerken
				</Text>

				<Flex w='100%'>
					<Tabs variant='soft-rounded' variantColor='gray' w='100%' isFitted>
						<TabList>
							<Tab>Homepagina</Tab>
							<Tab>Contact Pagina</Tab>
						</TabList>

						<TabPanels>
							<TabPanel>
								<form>
									<FormControl>


										<Flex alignItems='end' w='100%'>
											<Button
												ml='auto'
												bg='secondary.500'
												color='white'
												type='submit'
											>
												Versturen
											</Button>
										</Flex>
									</FormControl>
								</form>
							</TabPanel>
							<TabPanel>
								<form>
									<FormControl>
										<Flex alignItems='end' w='100%'>
											<Button
												ml='auto'
												bg='secondary.500'
												color='white'
												type='submit'
											>
												Versturen
											</Button>
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
