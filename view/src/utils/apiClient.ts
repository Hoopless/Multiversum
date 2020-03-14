export const swrFetcherJSON = async (path: string) => {
	const res = await fetch(`${process.env.API_URL}${path}`)

  return res.json()
}
