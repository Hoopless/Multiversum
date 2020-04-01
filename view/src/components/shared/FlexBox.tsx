import { Flex } from '@chakra-ui/core'
import { FC } from 'react'

const FlexBox: FC = ({ children }) => (
	<Flex width={['100%', '100%', '992px']} mx='auto' px="40px" minHeight="100vh" flexDirection='column' bg="background">
		{children}
	</Flex>
)

export default FlexBox
