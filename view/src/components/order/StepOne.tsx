import { FC } from 'react'
import OrderProgress from './OrderProgress'
import StepTitle from './StepTitle'
import OrderContext from '../../context/OrderContext/OrderContext'
import { useState } from 'react'
import { useFormik } from 'formik'
import { Box, Text, Input, Flex, Button, Checkbox } from '@chakra-ui/core'
import Router from 'next/router'

const userInfoInputs = [
  ['Voornaam', 'firstName'],
  ['Achternaam', 'lastName'],
  ['E-mail', 'email'],
  ['Telefoonnummer', 'phone'],
]

const userLocationInputs = [
  ['Straat', 'address', 75],
  ['Huisnummer', 'houseNumber', 25],
  ['Postcode', 'postalCode'],
  ['Stad', 'city'],
]

interface FormProps {
  firstName: string
  lastName: string
  email: string
  phone: string
  address: string
  houseNumber: string
  postalCode: string
  city: string
}

const OrderStepOne: FC<{
  next: () => void
  productId: string
}> = ({ productId }) => {
  const [orderSent, setOrderSent] = useState(false)

  const infoForm = useFormik({
    initialValues: {
      firstName: '',
      lastName: '',
      email: '',
      phone: '',
      address: '',
      houseNumber: '',
      postalCode: '',
      city: '',
    },
    onSubmit: async (values)=> {
      console.log(values)
      const formData = new FormData()

      formData.append('product_id', productId)
      formData.append('payment_id', '1')
      formData.append('firstname', infoForm.values.firstName)
      formData.append('lastname', infoForm.values.lastName)
      formData.append('address', infoForm.values.address)
      formData.append('house_number', infoForm.values.houseNumber)
      formData.append('postcode', infoForm.values.postalCode)
      formData.append('city', infoForm.values.city)
      formData.append('email', infoForm.values.email)
      formData.append('phone', infoForm.values.phone)

      const formRes = await fetch(`${process.env.API_URL}/order `, {
        method: 'POST',
        body: formData
      })

      if (formRes.status !== 200) {
        return
      }

      const response = await formRes.json()
      Router.push(`/order/bedankt?orderId=${response.order_id}`)
    },
  })

  return (
    <>
      {/* <OrderProgress step={1} /> */}

      <StepTitle>Bestelling</StepTitle>

      <form onSubmit={infoForm.handleSubmit}>
        <Flex w="70%" wrap="wrap">
          {userInfoInputs.map(([name, id]) => (
            <Box w="50%" px="15px" mb="10px" key={id}>
              <Text mb="2px">{name}</Text>
              <Input
                isRequired
                id={id}
                name={id}
                type="text"
                size="md"
                onChange={infoForm.handleChange}
                value={infoForm.values[id as keyof FormProps]}
              />
            </Box>
          ))}

          <Text mt="10px" w="100%" px="15px" fontWeight="bold">
            Aflever gegevens
          </Text>
          {userLocationInputs.map(([name, id, widthPercentage]) => (
            <Box
              w={widthPercentage ? `${widthPercentage}%` : '50%'}
              px="15px"
              mb="10px"
              key={id}
            >
              <Text mb="2px">{name}</Text>
              <Input
                isRequired
                id={id as string}
                name={id as string}
                type="text"
                size="md"
                onChange={infoForm.handleChange}
                value={infoForm.values[id as keyof FormProps]}
              />
            </Box>
          ))}

        </Flex>

        <Text mt="10px" w="100%" px="15px" fontWeight="bold">
            Betaalmethode
        </Text>

        <Flex w="100%" wrap="wrap" px="15px">
          <Flex w="33.33%" bg="white" py="20px" px="10px" wrap="wrap">
            <Flex w="15%" justifyContent="center" my="auto">
              <input
                id="payment_id"
                name="payment_id"
                value="1"
                type="radio"
                checked
                readOnly
              />
            </Flex>
            <Flex w="35%" justifyContent="center" my="auto" >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="62.857"
                height="55"
                viewBox="0 0 62.857 55"
              >
                <path
                  id="wallet-solid"
                  d="M56.621,43.786H9.821a1.964,1.964,0,0,1,0-3.929H56.964a1.964,1.964,0,0,0,1.964-1.964A5.893,5.893,0,0,0,53.036,32H7.857A7.857,7.857,0,0,0,0,39.857V79.143A7.857,7.857,0,0,0,7.857,87H56.621a6.078,6.078,0,0,0,6.237-5.893V49.679A6.078,6.078,0,0,0,56.621,43.786ZM51.071,69.321A3.929,3.929,0,1,1,55,65.393,3.929,3.929,0,0,1,51.071,69.321Z"
                  transform="translate(0 -32)"
                  fill="#707070"
                />
              </svg>
            </Flex>
            <Box w="50%" bg="white" py="20px" px="10px">
              <Text>Contant</Text>
              <Text>Kosten: € 0,00</Text>
            </Box>
          </Flex>
        </Flex>

        <Box px="15px" py="5px">

          <Box bg="white" p="5px">
            <Checkbox>Hierbij geef ik aan dat de gegevens kloppen die hierboven zijn ingevoerd en dit een geldige afleveradress is.</Checkbox>
          </Box>
           Met het versturen van dit bestelformulier erken je op de hoogte te zijn en akkoord te gaan met de  Algemene Voorwaarden van kabelshop.nl.
        </Box>


        <Flex alignItems="end" w="100%">
            <Button
              ml="auto"
              bg="secondary.500"
              color="white"
              type="submit"
              rightIcon="arrow-forward"
            >
              Bestelling aanmaken
            </Button>
          </Flex>
      </form>
    </>
  )
}

export default OrderStepOne
