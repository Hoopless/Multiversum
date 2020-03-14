import { FC } from 'react'
import Navigation from './Navigation'
import Link from 'next/link'
import {
  Flex,
  Box,
  Icon,
  Input,
  InputGroup,
  InputRightElement,
  Image,
} from '@chakra-ui/core'

const Header: FC = () => (
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
			<Link href='/'>
				<Image height={['','40%']} src='/img/logo.png' alt='Multiversum Logo' />
			</Link>
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
        mt='auto'
        pb="10px"
        wrap='wrap'
      >
        <InputGroup w='100%' display="none">
          <Input
            pr='30px'
            borderRadius='20px'
            variant='outline'
            bg='white'
            placeholder='Zoek hier uw product'
            size='sm'
          />
          <InputRightElement
            width='30px'
            children={<Icon name='search' color='gray.500' />}
          />
        </InputGroup>

        <Navigation />
      </Flex>
    </Flex>
  </Flex>
)

export default Header
