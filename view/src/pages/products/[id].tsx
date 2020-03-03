import { FC } from 'react'
import { useRouter } from "next/router"


const ProductDetail: FC = () => {
    const router = useRouter()
    const { id } = router.query


  return (
    <>
      {id}
    </>
  )
}

export default ProductDetail
