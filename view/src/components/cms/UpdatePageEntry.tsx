import { ContentPageEntry, ContentPage } from '../../utils/getPageContent'
import { FC, useState } from 'react'
import { useFormik } from 'formik'
import ContentPageCMS from '../../utils/ContentPage'
import { TabPanel, Flex, Button, Box, Text, Textarea } from '@chakra-ui/core'

const UpdateEntry: FC<{
	cmsPage: ContentPage
}> = ({ cmsPage }) => {
	const [formSent, setFormSent] = useState(false)
	const parsedCMS = new ContentPageCMS(cmsPage)

	const updateEntryForm = useFormik({
		initialValues: parsedCMS.values,
		onSubmit: async values => {
			let contentPageEntries: ContentPageEntry[] = []
			Object.entries(values).forEach(([entryID, entryValue]) => {
				const contentPageEntry = parsedCMS.getEntryBy('id', entryID)!

				contentPageEntries.push({
					id: entryID,
					value: entryValue,
					name: contentPageEntry.name,
				})
			})

			const formData = new FormData()
			formData.append('id', String(cmsPage.id))
			formData.append('json_content', JSON.stringify(contentPageEntries))

			const formRes = await fetch(`${process.env.API_URL}/page`, {
				method: 'PATCH',
				body: formData,
			})

			console.log(await formRes.text(), formRes.status)
			setFormSent(true)
		},
	})

	return (
		<form onSubmit={updateEntryForm.handleSubmit}>
			<Flex mt='2rem' flexDir='column' alignItems='end' w='100%'>
				{cmsPage.content.map(contentEntry => (
					<Box key={contentEntry.id} w='100%' pr='10rem' mb='10px'>
						<Text mb='2px'>{contentEntry.name}</Text>
						<Textarea
							id={contentEntry.id}
							name={contentEntry.id}
							value={updateEntryForm.values[contentEntry.id]}
							resize='none'
							onChange={updateEntryForm.handleChange}
						/>
					</Box>
				))}

				<>
					{formSent && (
						<Text color='secondary.500'>Pagina is geüpdate</Text>
					)}

				<Button
					isLoading={updateEntryForm.isSubmitting}
					ml='auto'
					bg='secondary.500'
					color='white'
					type='submit'
				>
					Update pagina
				</Button>
				</>

			</Flex>
		</form>
	)
}

export default UpdateEntry
