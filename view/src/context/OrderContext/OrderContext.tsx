import { createContext } from 'react'
import { OrderState } from '../../types/order'

export interface OrderContextType {
  update: (updatedValues: any) => any
  context: Partial<OrderState>
}

export const OrderContext = createContext({
  update: (_updatedValues: Partial<OrderState>) => {},
  context: {}
})

export default OrderContext
