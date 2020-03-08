import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import { Box, Image, Text, Badge, IconButton, Flex } from '@chakra-ui/core'
import Link from 'next/link'

const ProductCard: FC<{
	product: ConsumerProduct
	sale?: boolean
	center?: boolean
}> = ({ product, sale, center }) => {
	return (
		<>
			<Box
				display={center ? 'flex' : 'block'}
				mx={center ? 'auto' : ''}
				justifyContent='center'
				flexWrap='wrap'
				w={['10rem', '5rem', '7rem', '10rem']}
				mb={['10px', '0px']}
				backgroundColor='main.500'
				borderWidth='1px'
				borderColor='main.500'
				rounded='lg'
				overflow='hidden'
			>
				<Box height='7.5rem' bg='#cbcbcb'>
					<Image
						px='0.25rem'
						objectFit='contain'
						width='100%'
						height='100%'
						mx='auto'
						src={product.image_url}
						alt={product.name}
					/>
				</Box>

				<Box width='100%' p='4'>
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
						<Text fontSize='1.20rem' color='white' mt='auto'>
							€ {product.price}
						</Text>

						<Link href={`/product/${product.id}`}>
							<IconButton
								aria-label='Product Toevoegen'
								ml='auto'
								bg='secondary.500'
								icon='info-outline'
								color='white'
							/>
						</Link>
					</Flex>
				</Box>
			</Box>
		</>
	)
}

export default ProductCard
