import { Text } from '@chakra-ui/core'
import { FC } from 'react'

const GeneralTitle: FC = ({ children }) => (
	<Text fontSize='lg' w='100%' mb='0.75rem' fontWeight='bold'>
		{children}
	</Text>
)

export default GeneralTitle
