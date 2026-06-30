/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          light: '#eef0fd',
          soft: '#dde0fb',
          DEFAULT: '#5b6af0',
          hover: '#4a58e0',
        },
        surface: {
          50: '#fbfbf9', // sidebar bg
          100: '#f7f7f5', // body bg
          200: '#ffffff', // card bg
          300: '#f1f1ef', // hover
          400: '#e9e9e6', // active
          500: '#e3e3e0', // border
          600: '#c7c7c4', // border hover
        },
        dark: {
          bg: '#191919',
          surface: '#202020',
          surface2: '#2a2a2a',
          surface3: '#333333',
          border: '#3a3a3a',
          borderHover: '#4a4a4a',
        },
        text: {
          main: '#1a1a18',
          secondary: '#6b6b68',
          muted: '#9b9b98',
          darkMain: '#eaeaeb',
          darkSecondary: '#a1a1aa',
          darkMuted: '#71717a',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'sm': '0 1px 4px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04)',
        'md': '0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04)',
        'lg': '0 12px 32px rgba(0,0,0,.10), 0 4px 8px rgba(0,0,0,.04)',
        'dark-sm': '0 1px 4px rgba(0,0,0,.4)',
        'dark-md': '0 4px 12px rgba(0,0,0,.4)',
        'dark-lg': '0 12px 32px rgba(0,0,0,.4)',
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.3s ease-out forwards',
        'fade-in': 'fadeIn 0.2s ease-out forwards',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      }
    },
  },
  plugins: [],
}
