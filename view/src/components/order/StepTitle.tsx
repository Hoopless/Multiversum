import { Text } from '@chakra-ui/core'
import { FC } from 'react'

const StepTitle: FC = ({ children }) => (
	<Text mt='20px' mb='20px' px='15px' fontSize='lg' fontWeight='bold'>
		{children}
	</Text>
)

export default StepTitle
