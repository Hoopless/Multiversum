import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import ProductCard from './ProductCard'
import { Flex, Box, Text } from '@chakra-ui/core'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'

const ProductList: FC = () => {
  const { data } = useSWR('/products?limit=50', swrFetcherJSON)

  return (
    <>
      <Flex
        direction='column'
        width={['100%', '100%', '100%', '1680px']}
        mx='auto'
      >
          <Text fontSize='lg' mx='auto' fontWeight='bold' mb='10px'>
              Producten
          </Text>
        {data && (
          <>
            <Flex mx='auto'>
              {data.slice(0, 5).map((product: ConsumerProduct) => (
                <Box key={product.id} mx='1.5rem'>
                  <ProductCard product={product} />
                </Box>
              ))}
            </Flex>
            <Flex py='2.5rem' mx='auto'>
              {data.slice(5, 10).map((product: ConsumerProduct) => (
                <Box key={product.id} mx='1.5rem'>
                  <ProductCard product={product} />
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
