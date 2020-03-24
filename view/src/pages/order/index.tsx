import { FC, useState, useContext } from 'react'
import { OrderState } from '../../types/order'
import Head from 'next/head'
import OrderContext from '../../context/OrderContext/OrderContext'
import FlexBox from '../../components/shared/FlexBox'
import Header from '../../components/Header'
import { useRouter } from 'next/router'

import StepOne from '../../components/order/StepOne'

const ProductOrder: FC = () => {
  const router = useRouter()
  const { productId } = router.query
  const hm = useContext(OrderContext)

  const nextStep = () => {
    console.log('test', hm)
  }

  if (!productId) {
    return <></>
  }

  return (
    <>
      <Head>
        <title>Product bestelling</title>
      </Head>

      <FlexBox>
        <Header />
        <StepOne next={nextStep} productId={productId as string} />
      </FlexBox>
    </>
  )
}

export default ProductOrder
