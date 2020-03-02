import { theme } from '@chakra-ui/core'

const MultiversumTheme = {
  ...theme,
  icons: {
    ...theme.icons,
  },
  fonts: {
    heading: 'Quicksand, sans-serif',
    body   : 'Quicksand, system-ui, sans-serif',
    mono   : 'Quicksand, system-ui, sans-serif'
  },
  colors: {
    ...theme.colors,
    main      : '#2C3E50',
    font      : '#00000',
    secondary : '#1ABC9C',
    contrast  : '#F1C40F',
    errors    : '#F10F3C',
    background: '#E4E4E4'
  },
  fontSizes: {
    xs   : '0.75rem',
    sm   : '0.875rem',
    md   : '1rem',
    lg   : '1.5rem',
    xl   : '2rem',
    '2xl': '3rem',
    '3xl': '1.875rem',
    '4xl': '2.25rem',
    '5xl': '3rem',
    '6xl': '4rem'
  }
}

export default MultiversumTheme
