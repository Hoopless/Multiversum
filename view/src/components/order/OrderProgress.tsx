import { FC } from 'react'
import { Flex } from '@chakra-ui/core'

const OrderProgress: FC<{
  step: 1 | 2 | 3
}> = ({ step }) => (
  <Flex align='center' wrap='wrap' justifyContent='center'>
    <svg
      xmlns='http://www.w3.org/2000/svg'
      height='40'
      viewBox='0 0 1041.65 44.41'
    >
      <g id='Steps' transform='translate(-433.35 -237.59)'>
        <path
          id='Path_3'
          data-name='Path 3'
          d='M0,0H382.65V44.41H0Z'
          transform='translate(1079.351 237.59)'
          fill='#2c3e50'
        />
        <path
          id='Path_4'
          data-name='Path 4'
          d='M0,0H321.73l38.85,23.895L321.73,44.41H0Z'
          transform='translate(775.351 237.59)'
          fill='#f1c42c'
        />
        <path
          id='Path_1'
          data-name='Path 1'
          d='M0,0H350.2l42.287,23.895L350.2,44.41H0Z'
          transform='translate(433.35 237.59)'
          fill='#1dbc9c'
        />
        <text
          id='Stap_1:_Informatie'
          data-name='Stap 1: Informatie'
          transform='translate(544 267)'
          fill={step === 1 ? 'white' : 'black'}
          fontSize='20'
          fontWeight='bold'
        >
          <tspan x='0' y='0'>
            Stap 1: Informatie
          </tspan>
        </text>
        <text
          id='Stap_2:_Betaling'
          data-name='Stap 2: Betaling'
          transform='translate(872 267)'
          fill={step === 2 ? 'white' : 'black'}
          fontSize='20'
          fontWeight='bold'
        >
          <tspan x='0' y='0'>
            Stap 2: Betaling
          </tspan>
        </text>
        <text
          id='Stap_3:_Confirmatie'
          data-name='Stap 3: Confirmatie'
          transform='translate(1204 267)'
          fill={step === 3 ? 'white' : 'black'}
          fontSize='20'
          fontWeight='bold'
        >
          <tspan x='0' y='0'>
            Stap 3: Confirmatie
          </tspan>
        </text>
      </g>
    </svg>
  </Flex>
)

export default OrderProgress
