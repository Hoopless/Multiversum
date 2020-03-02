import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import { Box, Image, Text, Badge, IconButton, Flex } from '@chakra-ui/core'
import { FaCartPlus } from 'react-icons/fa'

const ProductCard: FC<{ product: ConsumerProduct; sale?: boolean }> = ({
  product,
  sale,
}) => {
  return (
    <Flex justifyContent='center'>
      <Box>
        <Box
          w='12.5rem'
          backgroundColor='main'
          borderWidth='1px'
          borderColor='main'
          rounded='lg'
          overflow='hidden'
        >
          <Box height='7.5rem' bg='#cbcbcb'>
            <Image
              px='0.25rem'
              py='0.75rem'
              objectFit='contain'
              height='100%'
              mx='auto'
              src={product.image_url}
              alt={product.name}
            />
          </Box>

          <Box p='4'>
            <Box d='flex' alignItems='baseline'>
              <Badge rounded='full' px='2' variantColor={sale ? 'red' : 'teal'}>
                {sale ? 'Aanbieding' : 'Nieuw'}
              </Badge>
            </Box>

            <Box
              color='white'
              mt='1'
              fontWeight='semibold'
              fontSize='md'
              lineHeight='tight'
              isTruncated
            >
              {product.name}
            </Box>

            <Flex>
              <Text fontSize='1.25rem' color='white' mt='auto'>
                € {product.price}
              </Text>
              <IconButton
                aria-label='Product Toevoegen'
                ml='auto'
                bg='secondary'
                icon={FaCartPlus}
                color='white'
              />
            </Flex>
          </Box>
        </Box>
      </Box>
    </Flex>
  )
}

export default ProductCard
