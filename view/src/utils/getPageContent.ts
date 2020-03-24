import useSWR, { responseInterface } from 'swr'
import { swrFetcherJSON } from './apiClient'
import ContentPageCMS from './ContentPage'

export interface ContentPageEntry {
	id   : string
	name : string
	value: string
}

export interface ContentPage {
	id               : number
	name             : string
	meta_title?      : string
	meta_description?: string
	content          : ContentPageEntry[]
}

export function getPageContents (): ContentPage[] | null {
	const cmsResponse = useSWR('/pages', swrFetcherJSON, {
		onError      : (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
	})

	if (cmsResponse.data) {
		return cmsResponse.data
	}

	return null
}

export function getPageContent (contentName: string): ContentPageCMS | null {
	const cmsResponse = useSWR(`/page?name=${contentName}`, swrFetcherJSON, {
		onError      : (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
	})

	if (cmsResponse.data) {
		return new ContentPageCMS(cmsResponse.data)
	}

	return null
}

export default getPageContent
