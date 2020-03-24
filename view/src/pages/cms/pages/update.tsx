import Head from 'next/head'
import CMSHeader from '../../../components/cms/header'
import { FC } from 'react'
import { getPageContents } from '../../../utils/getPageContent'
import UpdateEntry from '../../../components/cms/UpdatePageEntry'
import {
	Flex,
	Text,
	Tabs,
	TabList,
	Tab,
	TabPanels,
	TabPanel,
} from '@chakra-ui/core'

const ContentPageUpdate: FC = () => {
	const cmsPages = getPageContents()

	if (!cmsPages) {
		return <></>
	}

	return (
		<>
			<Head>
				<title>Admin Panel - Pagina's bewerken</title>
			</Head>

			<CMSHeader />

			<Flex width={['100%', '100%', '992px']} mx='auto' flexDirection='column'>
				<Text fontSize='lg' w='100%' mb='0.75rem' fontWeight='bold'>
					Pagina's bijwerken
				</Text>

				<Flex w='100%'>
					<Tabs variant='soft-rounded' variantColor='gray' w='100%' isFitted>
						<TabList>
							{cmsPages.map(cmsPage => (
								<Tab key={cmsPage.id}>{cmsPage.name}</Tab>
							))}
						</TabList>

						<TabPanels>
							{cmsPages.map(cmsPage => (
								<TabPanel key={cmsPage.id}>
									<UpdateEntry cmsPage={cmsPage} />
								</TabPanel>
							))}
						</TabPanels>
					</Tabs>
				</Flex>
			</Flex>
		</>
	)
}

export default ContentPageUpdate
