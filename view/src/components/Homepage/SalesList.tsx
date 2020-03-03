import { FC } from 'react'
import { ConsumerProduct } from '../../types/product'
import ProductCard from './ProductCard'
import { Flex, Box } from '@chakra-ui/core'
import Slider, { ResponsiveObject } from 'react-slick'
import useSWR from 'swr'
import { swrFetcherJSON } from '../../utils/apiClient'
import SliderArrow from '../SliderArrows'

const SalesList: FC = () => {
  const { data } = useSWR('/products?sales=true&limit=6', swrFetcherJSON, {
    loadingTimeout: 0
  })

  const sliderBreakpoints: ResponsiveObject[] = [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        infinite: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        dots: true
      }
    }
  ]

  return (
    <Slider slidesToShow={3} responsive={sliderBreakpoints} autoplaySpeed={4000} prevArrow={<SliderArrow to='chevron-left' />} nextArrow={<SliderArrow to='chevron-right' />}>
      {data &&
        data.map((product: ConsumerProduct) => (
          <Flex justifyItems='center'>
            <Box key={product.id}>
              <ProductCard sale center product={product} />
            </Box>
          </Flex>
        ))}
    </Slider>
  )
}

export default SalesList
