import { FC } from 'react'
import { Flex, Box } from '@chakra-ui/core'
import Link from 'next/link'

const navigationItems: {
  name: string
  path: string
}[] = [
  {
    name: 'Homepage',
    path: '/',
  },
  // {
  //   name: 'Producten',
  //   path: '/products',
  // },
  {
    name: 'Contact',
    path: '/contact',
  },
]

const Navigation: FC = () => (
  <Flex w='100%' pt="auto" justifyContent={["center", "left"]}>
    {navigationItems.map(navigationItem => (
      <Box key={navigationItem.name} pr={["10px",'40px']} color='gray.500'>
        <Link href={navigationItem.path}>
          <a>{navigationItem.name}</a>
        </Link>
      </Box>
    ))}
  </Flex>
)

export default Navigation
