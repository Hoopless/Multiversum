import { FC } from 'react'
import Navigation from '../Navigation';
import { Flex, Box, Image, Text } from '@chakra-ui/core'

const CMSHeader: FC = () => (
	<Flex
		width={['100%', '100%', '100%', '992px']}
		mx='auto'
		wrap='wrap'
		mt='10px'
	>
		<Flex
			direction='column'
			w={['100%', '20%', '20%', '20%']}
			alignItems='center'
			justifyContent='center'
		>
			<Image height={['', '40%']} src='../../img/logo.png' alt='Multiversum Logo' />
			<Box
				fontSize='md'
				color='gray.500'
				w='100%'
				textAlign='center'
				fontWeight='bold'
			>
				Multiversum
      </Box>
		</Flex>

		<Flex w={['100%', '80%', '80%', '80%']}>
			<Flex
				w='100%'
				alignItems='center'
				justifyContent='center'
				mx='auto'
				wrap='wrap'
			>
				<Text fontSize='lg'>Beheerders paneel</Text>
			</Flex>
		</Flex>
	</Flex>
)

export default CMSHeader
