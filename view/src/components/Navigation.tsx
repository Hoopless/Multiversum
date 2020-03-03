import { FC } from 'react'
import { Flex, Box, Link } from '@chakra-ui/core'

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
      <Box key={navigationItem.name} pr='40px' color='gray.500'>
        <Link href={navigationItem.path} >{navigationItem.name}</Link>
      </Box>
    ))}
  </Flex>
)

export default Navigation
