import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import ProductCard from './ProductCard'
import { Flex, Box, Text } from '@chakra-ui/core'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'

const ProductList: FC = () => {
  const { data } = useSWR('/products?limit=50&sales=0', swrFetcherJSON, {
		loadingTimeout: 0,
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
  })

  return (
    <>
      <Flex
        direction='column'
        width={['100%', '100%', '100%']}
        mx='auto'
      >
          <Text fontSize='lg' mx='auto' fontWeight='bold' mb='10px'>
            Producten
          </Text>
        {data && (
          <>
            <Flex mx='auto' wrap="wrap"  justifyContent="center">
              {data.slice(0, 5).map((product: ConsumerProduct) => (
                <Box key={product.id} mx='0.75rem'>
                  <ProductCard product={product} />
                </Box>
              ))}
            </Flex>
            <Flex py='2.5rem' mx='auto' justifyContent="center" wrap="wrap">
              {data.slice(5, 10).map((product: ConsumerProduct) => (
                <Box key={product.id} mx='0.75rem'>
                  <ProductCard sale={product.in_sale}  product={product} />
                </Box>
              ))}
            </Flex>
          </>
        )}
      </Flex>
    </>
  )
}

export default ProductList
