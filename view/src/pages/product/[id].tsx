import { FC, useEffect } from 'react'
import Head from 'next/head'
import Router from 'next/router'
import { Flex } from '@chakra-ui/core'
import { useRouter } from 'next/router'
import Header from '../../components/Header'
import Footer from '../../components/Footer'
import ProductShow from '../../components/Products/Show'
import PreloadFetch from '../../components/Utils/PreloadFetch'

const ProductDetail: FC = () => {
	const router = useRouter()
	const { id } = router.query

	return (
		<>
			<Head>
				<title>Product</title>
				<style>
					{`
						td {
							padding-right: 2rem;
						}
					`}
				</style>
				{id && <PreloadFetch apiPath={`/product?id=${id}`} />}
			</Head>

			<Flex direction='column' minHeight='100vh' justifyContent='space-between'>
				<Header />

				{id && <ProductShow id={id as string} />}

				<Footer />
			</Flex>
		</>
	)
}

export default ProductDetail
