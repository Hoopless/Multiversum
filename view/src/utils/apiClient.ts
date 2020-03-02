// import got, { ExtendOptions } from 'got'

// const apiClient = got.extend({
//   prefixUrl: process.env.API_URL
// })

export const swrFetcherJSON = async (path: string) => {
  const res = await fetch(`${process.env.API_URL}${path}`)

  return res.json()
}
