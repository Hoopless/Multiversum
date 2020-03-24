import { ContentPage, ContentPageEntry } from './getPageContent';

export default class ContentPageCMS {
	page: ContentPage
	values: {[key: string]: string}

	constructor (page: ContentPage) {
		this.page = page
		this.values = this.getValues()
	}

	getEntryBy (type: keyof ContentPageEntry, value: string) {
		return this.page.content.find(contentEntry => {
			return contentEntry[type] === value
		})
	}

	private getValues () {
		let values: {[key: string]: string} = {}

		this.page.content.forEach(contentEntry => {
			values[contentEntry.id] = contentEntry.value
		})

		return values
	}
}
