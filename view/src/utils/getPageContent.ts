import useSWR, { responseInterface } from 'swr'
import { swrFetcherJSON } from './apiClient'

function getPageContent<T> (contentName: string): responseInterface<T, any> {
	return useSWR(`/page?name=${contentName}`, swrFetcherJSON, {
		onError: (err) => console.error('Error SWR', err),
		onLoadingSlow: () => console.log('Loading slow SWR')
	})
}

export default getPageContent
