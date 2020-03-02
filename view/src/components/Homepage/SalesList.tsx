import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import ProductCard from './ProductCard'
import { Flex, Box } from '@chakra-ui/core'
import Slider from 'react-slick'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'
import SliderArrow from '../SliderArrows'

const SalesList: FC = () => {
  const { data } = useSWR('/products?sales=true&limit=6', swrFetcherJSON)

  return (
    <Slider autoplay autoplaySpeed={4000} prevArrow={<SliderArrow to='chevron-left' />} nextArrow={<SliderArrow to='chevron-right' />} infinite={true} slidesToShow={3}>
      {data &&
        data.map((product: ConsumerProduct) => (
          <Flex justifyItems='center'>
            <Box key={product.id}>
              <ProductCard sale product={product} />
            </Box>
          </Flex>
        ))}
    </Slider>
  )
}

export default SalesList
