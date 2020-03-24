import { FC, useState, ReactElement, ChangeEvent } from 'react'
import CMSHeader from '../../../components/cms/header'
import Head from 'next/head'
import PreloadFetch from '../../../components/Utils/PreloadFetch'
import { swrFetcherJSON } from '../../../utils/apiClient'
import useSWR from 'swr'
import { useRouter } from 'next/router'
import FlexBox from '../../../components/shared/FlexBox'
import GeneralTitle from '../../../components/shared/GeneralTitle'
import { useFormik } from 'formik'
import { ConsumerProduct, ProductValueTypes } from '../../../types/product'
import {
  Flex,
  Input,
  Switch,
  Textarea,
  Text,
  Box,
  Button,
} from '@chakra-ui/core'

const ProductUpdate: FC = () => {
  const router = useRouter()
  const { id } = router.query
  const [isSubmitting, setIsSubmitting] = useState(false)

  const product: ConsumerProduct = useSWR(
    id ? `/product?id=${id}` : null,
    swrFetcherJSON,
    {
      onError: err => console.error('Error SWR', err),
      onLoadingSlow: () => console.log('Loading slow SWR'),
    }
  ).data
  const productForm = useFormik({
    initialValues: product,
    onSubmit: async values => {
      console.log(values)
    },
  })

  const submitForm = async (formValues: ConsumerProduct) => {
    if (isSubmitting || !formValues) {
      return
    }

    setIsSubmitting(true)

    let updatedValues: Partial<ConsumerProduct> = {}
    for (const objectEntry of Object.entries(formValues)) {
      const valueName = objectEntry[0] as keyof ConsumerProduct
      const updatedValue = objectEntry[1]
      const valueType = ProductValueTypes.find(type => type.id === valueName)

      if (!valueType) {
        continue
      }

      if (valueType.type === 'image') {
        if (updatedValue.size) {
          updatedValues[valueName] = updatedValue
        }
        continue
      }

      const oldValue = product[valueName]
      if (updatedValue !== oldValue) {
        updatedValues[valueName] = updatedValue
      }
    }

    if (Object.values(updatedValues).length === 0) {
      setIsSubmitting(false)
      return
    }

    const formData = new FormData()
    formData.append('id', String(product.id))
    Object.entries(updatedValues).forEach(([valueName, updatedValue]) => {
      formData.append(valueName, updatedValue as string | Blob)
    })

    const formRes = await fetch(`${process.env.API_URL}/product`, {
      method: 'PATCH',
      body: formData,
    })

    console.log(await formRes.json())

    setIsSubmitting(false)
  }

  if (!product) {
    return <></>
  }

  return (
    <>
      <Head>
        <title>Admin Panel - Product Updaten</title>
        {id && <PreloadFetch apiPath={`/product?id=${id}`} />}
      </Head>

      <CMSHeader />

      <FlexBox>
        <form onSubmit={productForm.handleSubmit}>
          <GeneralTitle>Product Updaten</GeneralTitle>

          <Flex w="100%" flexDirection="column" mb="4rem">
            {id &&
              product &&
              ProductValueTypes.map(productValueType => {
                const productValue = productForm?.values[productValueType.id] || product[productValueType.id]
                if (productValue === undefined) {
                  return
                }

                let valueTypeComponent: ReactElement
                switch (productValueType.type) {
                  case 'string': {
                    valueTypeComponent = (
                      <Input
                        isRequired={productValueType.required}
                        id={productValueType.id}
                        name={productValueType.id}
                        type="text"
                        value={(productValue as string) || undefined}
                        onChange={productForm.handleChange}
                        size="md"
                      />
                    )
                    break
                  }

                  case 'number': {
                    valueTypeComponent = (
                      <Input
                        isRequired={productValueType.required}
                        id={productValueType.id}
                        name={productValueType.id}
                        type="number"
                        value={productValue as number}
                        onChange={productForm.handleChange}
                        size="md"
                      />
                    )
                    break
                  }

                  case 'image': {
                    valueTypeComponent = (
                      <Input
                        id={productValueType.id}
                        name={productValueType.id}
                        type="file"
                        accept="image/*"
                        onChange={(event: ChangeEvent<HTMLInputElement>) => {
                          productForm.setFieldValue(
                            productValueType.id,
                            event.currentTarget.files![0]
                          )
                        }}
                        size="md"
                      />
                    )
                    break
                  }

                  case 'boolean': {
                    valueTypeComponent = (
                      <Switch
                        id={productValueType.id}
                        name={productValueType.id}
                        value={(productValue as boolean) || undefined}
                        onChange={productForm.handleChange}
                        size="md"
                      />
                    )
                    break
                  }

                  case 'longText': {
                    valueTypeComponent = (
                      <Textarea
                        isRequired={productValueType.required}
                        id={productValueType.id}
                        name={productValueType.id}
                        value={productValue as string}
                        onChange={productForm.handleChange}
                      />
                    )
                    break
                  }
                }

                return (
                  <Box key={productValueType.id} w="100%" px="15px" mb="10px">
                    <Text mb="2px">{productValueType.name}</Text>
                    {valueTypeComponent}
                  </Box>
                )
              })}

            <Button
              ml="auto"
              bg="secondary.500"
              isLoading={isSubmitting}
              onClickCapture={() => {
                submitForm(productForm.values)
              }}
            >
              Update
            </Button>
          </Flex>
        </form>
      </FlexBox>
    </>
  )
}

export default ProductUpdate
