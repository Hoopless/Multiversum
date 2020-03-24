import { Flex } from '@chakra-ui/core'
import { FC } from 'react'

const FlexBox: FC = ({ children }) => (
	<Flex width={['100%', '100%', '992px']} mx='auto' flexDirection='column'>
		{children}
	</Flex>
)

export default FlexBox
