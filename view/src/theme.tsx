import { theme } from '@chakra-ui/core'

const MultiversumTheme = {
  ...theme,
  icons: {
    ...theme.icons,
  },
  fonts: {
    heading: 'Roboto, sans-serif',
    body   : 'Roboto, system-ui, sans-serif',
    mono   : 'Quicksand, system-ui, sans-serif'
  },
  colors: {
    ...theme.colors,
    main      : {
			50 : '#2C3E50',
      100: '#2C3E50',
      200: '#2C3E50',
      300: '#2C3E50',
      400: '#2C3E50',
      500: '#2C3E50',
      600: '#2C3E50',
      700: '#2C3E50',
      800: '#2C3E50',
      900: '#2C3E50'
    },
    font      : {
      500: '#00000'
    },
    secondary : {
      500: '#1ABC9C'
    },
    contrast  : {
      500:'#F1C40F'
    },
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
