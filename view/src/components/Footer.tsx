import { FC } from 'react'
import { Flex, Image, Box } from '@chakra-ui/core'

const footerItems: {
  name: string
  path: string
}[] = [
  {
    name: 'Algemene voorwaarden',
    path: '/algemene-voorwaarden',
  },
  {
    name: 'Leveringsvoorwaarden',
    path: '/leveringsvoorwaarden',
  },
  {
    name: 'Contact',
    path: '/contact',
  }
]

const Footer: FC = () => (
  <Flex w='100%' bg='main' py='0.4rem'>
    <Flex width={['100%', '100%', '1680px', '1680px']} mx='auto'>
      <Flex
        d={['none', 'flex', 'flex', 'flex']}
        w='100%'
      >
        <Image h='30px' src='./img/logo.png' alt='Je tering moeder' />
        <Box
          fontSize='sm'
          color='white'
          textAlign='center'
          fontWeight='bold'
          my='auto'
          pl='10px'
        >
          Multiversum
        </Box>
      </Flex>

      <Flex direction='row-reverse' w='100%' my='auto' >
        {footerItems.map(footerItem => (
          <Box key={footerItem.name} pr='20px' color='white' fontSize='0.75rem'>
            <a href={footerItem.path}>{footerItem.name}</a>
          </Box>
        ))}
      </Flex>
    </Flex>
  </Flex>
)

export default Footer
