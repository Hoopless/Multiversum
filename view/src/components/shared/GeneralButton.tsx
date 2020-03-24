import { Flex } from '@chakra-ui/core'
import { FC } from 'react'
import styled from '@emotion/styled'
import theme from '../../theme'

const HoverButton = styled.table`
	button:hover {

	}
`
const GeneralButton: FC<{ bg?: string }> = ({ children, bg }) => {
	const CustomButton = styled(HoverButton)`
		background-color: ${bg || theme.colors.secondary};
	`

	return <CustomButton>{children}</CustomButton>
}

export default GeneralButton
