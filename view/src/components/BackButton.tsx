import { Flex, Button, Box } from '@chakra-ui/core'
import { FC } from 'react'
import Router from 'next/router'
import Link from 'next/link'
import { FaHome } from 'react-icons/fa'

const BackButton: FC = () => (
  <Flex w="100%" mb="4rem" align="center">
    <Button
      leftIcon="arrow-back"
      bg="white"
      size="sm"
      color="main"
      onClick={() => Router.back()}
    >
      Ga Terug
    </Button>
    <Box px="10px">
      <Link href={'/'}>
        <FaHome size="1.2rem" />
      </Link>
    </Box>
  </Flex>
)

export default BackButton
