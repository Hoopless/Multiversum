import { FC } from 'react'

const PreloadFetch: FC<{apiPath: string}> = ({apiPath}) => (
	<link rel='preload' href={`${process.env.API_URL}${apiPath}`} as='fetch' crossOrigin='anonymous' />
)

export default PreloadFetch
