export const swrFetcherJSON = async (path: string | null) => {
	if (!path) {
		return null
	}

	const res = await fetch(`${process.env.API_URL}${path}`)

  return res.json()
}
