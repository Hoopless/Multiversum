import Head from 'next/head'
import { useFormik } from 'formik'
import { useState, FC, ChangeEvent } from 'react'
import FlexBox from '../components/shared/FlexBox'
import { Box, Input, Text, Flex, Image, Button } from '@chakra-ui/core'
import Router from 'next/router'

interface FormValues {
  password: string
  email: string
}

const CMSLogin: FC = () => {
  const [errorMessage, setErrrorMessage] = useState<String>()
  const loginForm = useFormik({
    initialValues: {
      email: "",
      password: "",
    },
    onSubmit: async (values, helpers) => {
      const formData = new FormData()
      formData.append('email', values.email)
      formData.append('password', values.password)

      const formRes = await fetch(`${process.env.API_URL}/login`, {
        method: 'POST',
        body: formData
      })

      const testSession = await fetch(`${process.env.API_URL}/session`, {
        method: 'GET',
      })

      const responseMessage = await formRes.json()



      helpers.setSubmitting(false)
      if (!responseMessage.logged_in) {
        setErrrorMessage(responseMessage.error)
        return
      } else {
        const responseMessagetest = await testSession.json()
        console.log(responseMessagetest);
      }

      setErrrorMessage('')
      Router.push('/cms')
    }
  })


  return (

    <>
      <Head>
        <title>CMS Login - Multiversum CP</title>
      </Head>

      <FlexBox>

        <Flex h="100vh" justifyContent="center" align="center">

          <Box mx="auto" my="auto" bg="white" px="15px" py="20px">
            <form onSubmit={loginForm.handleSubmit}>

              <Box>
                <Flex justifyContent="center">
                  <Image height={['', '40%']} src='/img/logo.png' alt='Multiversum Logo' />
                </Flex>
                <Box
                  fontSize='md'
                  color='gray.500'
                  w='100%'
                  textAlign='center'
                  fontWeight='bold'
                >
                  Multiversum CMS
              </Box>
              </Box>
              <Box w='100%' px='15px' mb='30px'>
                <Text mb='2px'>E-mail</Text>
                <Input
                  isRequired
                  id='email'
                  name='email'
                  value={loginForm.values.email}
                  onChange={loginForm.handleChange}
                  type='text'
                  size='md'
                />
              </Box>

              <Box w='100%' px='15px' mb='25px'>
                <Text mb='2px'>Password</Text>
                <Input
                  isRequired
                  id='password'
                  name='password'
                  value={loginForm.values.password}
                  onChange={loginForm.handleChange}
                  type='password'
                  size='md'
                />
              </Box>
              {errorMessage && (
                <Box>
                  <Text color="red.500" mb='20px' px='15px'>{errorMessage}</Text>
                </Box>
              )}
              <Flex alignItems='end' w='100%'>
                <Button ml='auto' bg='secondary.500' isLoading={loginForm.isSubmitting} color='white' type='submit'>Inloggen</Button>
              </Flex>
            </form>
          </Box>

        </Flex>

      </FlexBox>

    </>
  )
}

export default CMSLogin
