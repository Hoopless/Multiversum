import Head from 'next/head'
import Header from '../components/Header'
import { Flex } from '@chakra-ui/core'
import Footer from '../components/Footer'
import Contact from '../components/Contact'
import styled from "@emotion/styled";

const BackgroundImage = styled.div`
	background-image: url('/img/pattern.png');
`;

const ContactPage = () => (
  <>
    <Head>
      <title>Contact</title>
    </Head>

    <Flex direction='column' minHeight='100vh' >
		<BackgroundImage>
			<Header />

      <Contact />
		</BackgroundImage>
	<Footer />
    </Flex>
  </>
)

export default ContactPage
