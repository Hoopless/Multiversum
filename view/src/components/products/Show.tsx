import { FC } from 'react'
import { FaMobileAlt, FaDesktop, FaPlaystation, FaHome } from 'react-icons/fa'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'
import { ConsumerProduct } from '../../types/product'
import currencyFormat from '../../utils/priceFormat'
import BackButton from '../../components/BackButton'
import { FaCartPlus } from 'react-icons/fa'
import Link from 'next/link'

import {
	Flex,
	Box,
	Image,
	Text,
	Tabs,
	TabList,
	TabPanels,
	Button,
	Tab,
	TabPanel,
} from '@chakra-ui/core'

const ProductShow: FC<{ id: number | string }> = ({ id }) => {
	const productInfo: ConsumerProduct = useSWR(
		`/product?id=${id}`,
		swrFetcherJSON,
		{
			loadingTimeout: 0,
			onError: err => console.error('Error SWR', err),
			onLoadingSlow: () => console.log('Loading slow SWR'),
		}
	).data

	if (!productInfo) {
		return <></>
	} else {
		console.log('Product', productInfo)
	}

	const infoEntries = [
		['Beschrijving', productInfo.description],
		['Platform', productInfo.platform],
		['Resolution', productInfo.resolution],
		['Refresh Rate', productInfo.refresh_rate],
		['Audio Type', productInfo.audio_type],
		['Kleur', productInfo.colour],
		['Merk', productInfo.brand],
		['EAN', productInfo.ean],
		['SKU', productInfo.sku],
		['Meegeleverd', productInfo.included_info],
		['Garantie', productInfo.warranty],
	]

	return (
		<>
			<Flex wrap='wrap' width={['100%', '100%', '100%', '992px']} mx='auto'>

				<BackButton />

				<Box width={['100%', 4 / 12, 4 / 12, 4 / 12]}>
					<Image src={productInfo.image_url} alt='Product logo' />
				</Box>

				<Box
					pl={['0px', '0px', '3rem']}
					width={['100%', 8 / 12, 8 / 12, 8 / 12]}
				>
					<Flex>
						<Box w='50%'>
							<Text fontSize='xl' mb='30px'>
								{productInfo.name}
							</Text>
						</Box>
						<Flex w='50%'>
							<Box mx='10px'>
								<FaMobileAlt size='3rem' color='#F1C40F' />
							</Box>
							<Box mx='10px'>
								<FaDesktop size='3rem' color='#1ABC9C' />
							</Box>
							<Box mx='10px'>
								<FaPlaystation size='3rem' color='#F1C40F' />
							</Box>
						</Flex>
					</Flex>
					<Tabs variant='soft-rounded' variantColor='gray' isFitted>
						<TabList>
							<Tab>Specificaties</Tab>
						</TabList>

						<TabPanels>
							<TabPanel minHeight='4rem'>
								<Box mt='0.75rem'>
									<table>
										<tbody>
											{infoEntries.map(([entryName, entryValue]) => {
												console.log(entryName, entryValue)
												if (entryValue) {
													return (
														<tr key={entryName}>
															<td>{entryName}</td>
															<td>{entryValue}</td>
														</tr>
													)
												}
											})}
										</tbody>
									</table>
								</Box>
							</TabPanel>
						</TabPanels>
					</Tabs>

					<Flex justifyContent='end'>
						<Text textAlign='right' fontSize='xl' pr='0.5rem' w="100%">
							€ {currencyFormat(productInfo.price)}
						</Text>

						<Flex w="100%">
						<Link href={`/order?productId=${productInfo.id}`}>
							<Button
								aria-label='Product Toevoegen'
								ml='auto'
								bg='secondary.500'
								rightIcon={FaCartPlus}
								color='white'
							>Koop Nu!</Button>

						</Link>
					</Flex>
					</Flex>

				</Box>
			</Flex>
		</>
	)
}

export default ProductShow
