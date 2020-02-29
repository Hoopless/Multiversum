import { FC } from 'react'
import { Flex, Box } from '@chakra-ui/core'

const navigationItems: {
  name: string
  path: string
}[] = [
  {
    name: 'Homepage',
    path: '/',
  },
  {
    name: 'Producten',
    path: '/products',
  },
  {
    name: 'Contact',
    path: '/contact',
  },
]

const Navigation: FC = () => (
  <Flex w='100%' pt='1rem'>
    {navigationItems.map(navigationItem => (
      <Box pr='40px' color='gray.500'>
        <a href={navigationItem.path}>{navigationItem.name}</a>
      </Box>
    ))}
  </Flex>
)

export default Navigation
