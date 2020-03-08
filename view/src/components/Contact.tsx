import { FC, useState } from 'react'
import { useFormik } from 'formik'
import { Flex, Box, Text, Input, Textarea, Button, FormControl } from '@chakra-ui/core'
import { FaCheck } from 'react-icons/fa'


const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i

interface FormValues {
	name: string
	email: string
	subject: string
}

const Contact: FC = () => {
	const [formSent, setFormSent] = useState(false)
	const contactForm = useFormik({
		initialValues: {
			name: '',
			email: '',
			subject: ''
		},
		validate: values => {
			let errors: Partial<FormValues> = {}

			if (values.email && !emailRegex.test(values.email)) {
				errors.email = 'Ongeldig email'
			}

			return errors
		},
		onSubmit: async (values, helpers) => {
			const formData = new FormData()
			formData.append('name', values.name)
			formData.append('email', values.email)
			formData.append('subject', values.subject)

			const formRes = await fetch(`${process.env.API_URL}/mail`, {
				method: 'POST',
				body: formData
			})

			console.log(await formRes.text(), formRes.status)
			helpers.setSubmitting(false)
			helpers.resetForm()
			setFormSent(true)
		}
	})

	return (
		<Box pb='10px'>
			<Flex width={['100%', '100%', '100%', '992px']} mx='auto' wrap='wrap'>
				<Box w={['100%', '100%', '50%', '50%']} pr='20px' mb="30px">
					<form onSubmit={contactForm.handleSubmit}>
						<FormControl isRequired>
              <Text fontSize='lg' w='100%' mb='5px' pl="20px">Contact formulier</Text>
							<Box bg='white' w='100%' p='15px' px='20px'>
								<Box pb='15px'>
									<Text fontSize='md' w='100%' fontWeight='semibold'>Naam</Text>
									<Input isRequired id='name' bg="background" name='name' type='text' onChange={contactForm.handleChange} />
									{contactForm.errors.name && (
										<Text fontSize='sm' color='tomato'>
											{contactForm.errors.name}
										</Text>
									)}
								</Box>


								<Box pb='15px'>
									<Text fontSize='md' w='100%' fontWeight='semibold'>E-mail</Text>
									<Input isRequired id='email' bg="background" name='email' type='email' onChange={contactForm.handleChange} />
									{contactForm.errors.email && (
										<Text fontSize='sm' color='tomato'>
											{contactForm.errors.email}
										</Text>
									)}
								</Box>

								<Box pb='15px'>
									<Text fontSize='md' w='100%' fontWeight='semibold'>Bericht</Text>
									<Textarea isRequired id='subject' name='subject' onChange={contactForm.handleChange} bg='background' resize='none' />
									{contactForm.errors.subject && (
										<Text fontSize='md' color='tomato'>
											{contactForm.errors.subject}
										</Text>
									)}
								</Box>

								{formSent && (
									<Flex pb='15px' alignItems="Center" justifyContent="center" w="100%" wrap="wrap">
                    <Flex w="100%" alignItems="Center" justifyContent="center">
                      <FaCheck size="30px" color="#1ABC9C" />
                    </Flex>
										<Text fontSize='sm' color='green.600' w="100%" textAlign="center">Verstuurd!</Text>
                    <Text fontSize='sm' color='green.600' w="100%" textAlign="center">Wij nemen zo snel mogelijk contact op!</Text>
									</Flex>
								)}

								<Flex alignItems='end' w='100%'>
									<Button ml='auto' variantColor='teal' isDisabled={formSent} isLoading={contactForm.isSubmitting} type='submit'>Versturen</Button>
								</Flex>
							</Box>
						</FormControl>
					</form>
				</Box>

				<Box w={['100%', '100%', '50%', '50%']} pl='20px'>
					<Text fontSize='lg' w='100%'>Contact informatie</Text>
					<Box w='100%'>

					</Box>

					<Box >
						<Text fontSize='md' w='100%' fontWeight='semibold'>Bedrijfgegevens</Text>

						<Box fontSize='md' pr="10px">
							Multiversum<br />
							1861 Jan Pieterszoon Coenstraat<br />
							69217 Maasdriel<br />
							Zeeland<br />
							<br />

							Routebeschrijving? Klik <a href=''>hier</a> voor de routebeschrijving naar Multiversum.<br />
							<br />

							KvK: 12345678<br />
							BTW-Nummer: NummerBTW<br />
						</Box>

					</Box>
				</Box>
			</Flex>
		</Box>
	)
};

export default Contact
