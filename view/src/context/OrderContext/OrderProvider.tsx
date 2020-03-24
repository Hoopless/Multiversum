import { FC, useState } from 'react';
import { OrderState } from '../../types/order';
import OrderContext, { OrderContextType } from './OrderContext';

const OrderProvider: FC = ({ children }) => {
  const updateOrder = (updatedValues: Partial<OrderState>) => {
    updateOrderState({
      ...orderState,
      ...updatedValues
    })

    return
  }

  const [orderState, updateOrderState] = useState<OrderContextType>({
    update: updateOrder,
    context: {}
  })

  return (
    <OrderContext.Provider value={orderState}>
      {children}
    </OrderContext.Provider>
  )
}

export default OrderProvider
