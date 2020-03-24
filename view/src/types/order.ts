export interface OrderState {
  productID: number
  paymentID: number
  user: {
    firstName: string
    lastName : string
    email    : string
    phone    : string
  },
  location: {
    address    : string
    houseNumber: string
    postalCode : string
    city       : string
  }
}
