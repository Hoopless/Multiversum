import { Icon } from '@chakra-ui/core'
// import { Icons } from '@chakra-ui/core/dist/theme/icons'

const SliderArrow: (options: {
  className?: string
  to       : string
  onClick?  : any
}) => JSX.Element = ({className, to, onClick}) => (
  <button type='button' onClick={onClick} className={`button button--text button--icon ${className}`}>
    {/* 
    //@ts-ignore */}
    <Icon className='icon' name={to} />
  </button>
)

export default SliderArrow
