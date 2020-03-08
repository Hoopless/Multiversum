import Head from 'next/head'
import { useFormik } from 'formik'
import CMSHeader from "../../components/cms/header";
import { Flex, Input, Box, Text, Textarea, Checkbox, Stack, Button, FormControl, CheckboxGroup, Switch } from '@chakra-ui/core'
import { useState, FC, ChangeEvent } from 'react'
import { FaCheck } from 'react-icons/fa'


interface FormValues {
	name: string
	description: string
	platform: string
	price: string
	resolution: string
	audio_type: string
	refresh_rate: string
	included_info: string
	colour: string
	warranty: string
	ean: string
	sku: string
	brand: string
	image: string
	in_sale: boolean
}

const CMSCreate: FC = () => {
	const [formSent, setFormSent] = useState(false)
	const productForm = useFormik({
		initialValues: {
			name: '',
			description: '',
			platform: '',
			price: '0',
			resolution: '',
			audio_type: '',
			refresh_rate: '',
			included_info: '',
			colour: '',
			warranty: '',
			ean: '',
			sku: '',
			brand: '',
			image: '',
			in_sale: false
		},
		validate: values => {
			console.log(2)
			let errors: Partial<FormValues> = {}

			if (values.image !== '' && !values.image) {
				errors.image = "Geen foto Geselecteerd!"
			}

			return errors
		},
		onSubmit: async (values, helpers) => {
			console.log(1)
			const formData = new FormData()
			formData.append('name', values.name)
			formData.append('description', values.description)
			formData.append('platform', values.platform)
			formData.append('price', values.price)
			formData.append('resolution', values.resolution)
			formData.append('audio_type', values.audio_type)
			formData.append('refresh_rate', values.refresh_rate)
			formData.append('included_info', values.included_info)
			formData.append('colour', values.colour)
			formData.append('warranty', values.warranty)
			formData.append('ean', values.ean)
			formData.append('sku', values.sku)
			formData.append('brand', values.brand)
			formData.append('image', values.image)
			formData.append('in_sale', String(values.in_sale))

			const formRes = await fetch(`${process.env.API_URL}/product`, {
				method: 'POST',
				body: formData
			})

			console.log(await formRes.text(), formRes.status)
			helpers.setSubmitting(false)
			setFormSent(true)
		}
	})

	return (
		<>
			<Head>
				<title>Admin Panel - Product toevoegen</title>
			</Head>

			<CMSHeader />

			<Flex width={['100%', '100%', '992px']} mx='auto' flexDirection="column">

				{formSent && (
					<Flex pb='15px' alignItems="Center" justifyContent="center" w="100%" wrap="wrap">
						<Flex w="80%" alignItems="Center" justifyContent="center">
							<FaCheck size="30px" color="#1ABC9C" />
						</Flex>
						<Text fontSize='sm' color='green.600' w="100%" textAlign="center">Verstuurd!</Text>
						<Text fontSize='sm' color='green.600' w="100%" textAlign="center">Wij nemen zo snel mogelijk contact op!</Text>
					</Flex>
				)}
				<form onSubmit={productForm.handleSubmit}>
					<FormControl >

						<Text fontSize="lg" w="100%" mb="0.75rem" fontWeight="bold">Product toevoegen</Text>


						<Flex w="100%">

							<Flex w="50%" flexDirection="column">
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Naam</Text>
									<Input
										isRequired
										id="name"
										name="name"
										type="text"
										value={productForm.values.name}
										onChange={productForm.handleChange}
										size="md"
									/>
								</Box>

								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Beschrijving</Text>
									<Textarea
										isRequired
										id='description'
										name='description'
										value={productForm.values.description}
										onChange={productForm.handleChange}

									/>
								</Box>

								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Platform</Text>
									<Box bg="white" w="100%" px="10px" py="5px">
										<Stack spacing={2} isInline >
											<Checkbox name="platform" id="platform" value="PC" variantColor="green">
												PC
                      </Checkbox>
											<Checkbox name="platform" id="platform" value="Playsation 4" variantColor="green">
												Playstation 4
                       </Checkbox>
											<Checkbox name="platform" id="platform" value="Standalone" variantColor="green">
												Standalone
                       </Checkbox>
											<Checkbox name="platform" id="platform" value="Mobiel" variantColor="green">
												Mobiel
                       </Checkbox>
										</Stack>
									</Box>
								</Box>

								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Included info</Text>
									<Textarea

										id='included_info'
										name='included_info'
										value={productForm.values.included_info}
										onChange={productForm.handleChange}
									/>
								</Box>

								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Image</Text>
									<Text mb="2px">Let op! foto die transpirant is </Text>
									<Input
										isRequired
										id='image'
										name='image'
										onChange={(event: ChangeEvent<HTMLInputElement>) => {
											productForm.setFieldValue('image', event.currentTarget.files![0])
										}}
										type="file"
										size="md"
									/>
								</Box>
							</Flex>

							<Flex w="50%" flexDirection="column">
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Resolutie</Text>
									<Input
										id='resolution'
										name='resolution'
										type="text"
										value={productForm.values.resolution}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Refresh Rate</Text>
									<Input
										id='refresh_rate'
										name='refresh_rate'
										type="text"
										value={productForm.values.refresh_rate}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Audio Type</Text>
									<Input
										id='audio_type'
										name='audio_type'
										type="text"
										value={productForm.values.audio_type}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Colour</Text>
									<Input
										id='colour'
										name='colour'
										type="text"
										value={productForm.values.colour}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Earn</Text>
									<Input
										id='ean'
										name='ean'
										type="text"
										value={productForm.values.ean}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">Brand</Text>
									<Input
										id='brand'
										name='brand'
										type="text"
										value={productForm.values.brand}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>
								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">SKU</Text>
									<Input
										id='sku'
										name='sku'
										type="text"
										value={productForm.values.sku}
										onChange={productForm.handleChange}
										placeholder=""
										size="md"
									/>
								</Box>

								<Box w="100%" px="15px" mb="10px">
									<Text mb="2px">In de aanbieding?</Text>
									<Switch
										id='in_sale'
										name='in_sale'
										value={productForm.values.in_sale}
										onChange={productForm.handleChange}
										size="md"
									/>
								</Box>
							</Flex>

						</Flex>
						<Flex alignItems='end' w='100%'>
							<Button ml='auto' bg='secondary.500' color='white' isLoading={productForm.isSubmitting} type='submit'>Versturen</Button>
						</Flex>
					</FormControl>
				</form>

			</Flex>
		</>
	)
}

export default CMSCreate
