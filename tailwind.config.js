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
          light: '#5EEAD4', // teal-300
          soft: '#A7F3D0', // emerald-200
          DEFAULT: '#0D9488', // teal-600
          dark: '#0F766E', // teal-700
          hover: '#0F766E', // teal-700
        },
        secondary: {
          light: '#A7F3D0', // emerald-200
          DEFAULT: '#2DD4BF', // teal-400
          dark: '#14B8A6', // teal-500
        },
        accent: {
          light: '#FDBA74', // orange-300
          DEFAULT: '#F97316', // orange-500 (CTA)
          dark: '#EA580C', // orange-600
        },
        surface: {
          50: '#F0FDFA', // teal-50 (Background)
          100: '#CCFBF1', // teal-100
          200: '#FFFFFF', // pure white
          300: '#f1f1ef',
          400: '#e9e9e6',
          500: '#e3e3e0',
          600: '#c7c7c4',
        },
        dark: {
          bg: '#0a0a0f',
          surface: '#12121a',
          surface2: '#1a1a26',
          surface3: '#222233',
          border: '#2a2a3d',
          borderHover: '#3a3a50',
        },
        text: {
          main: '#134E4A', // teal-900
          secondary: '#115E59', // teal-800
          muted: '#0F766E', // teal-700
          darkMain: '#eaeaeb',
          darkSecondary: '#a1a1aa',
          darkMuted: '#71717a',
        },
        clay: {
          bg: '#F0FDFA',
          base: '#CCFBF1',
          highlight: '#FFFFFF',
          shadow: '#99F6E4',
          accentBase: '#FFEDD5', // orange-50
          accentHighlight: '#FFFFFF',
          accentShadow: '#FDBA74', // orange-300
        }
      },
      fontFamily: {
        sans: ['"Baloo 2"', 'system-ui', 'sans-serif'],
        display: ['"Baloo 2"', 'system-ui', 'sans-serif'],
        body: ['"Comic Neue"', 'cursive', 'sans-serif'],
      },
      boxShadow: {
        'clay': '8px 8px 16px rgba(13, 148, 136, 0.1), -8px -8px 16px rgba(255, 255, 255, 1), inset 2px 2px 4px rgba(255, 255, 255, 0.8), inset -2px -2px 4px rgba(13, 148, 136, 0.1)',
        'clay-sm': '4px 4px 8px rgba(13, 148, 136, 0.1), -4px -4px 8px rgba(255, 255, 255, 1), inset 1px 1px 2px rgba(255, 255, 255, 0.8), inset -1px -1px 2px rgba(13, 148, 136, 0.1)',
        'clay-lg': '12px 12px 24px rgba(13, 148, 136, 0.1), -12px -12px 24px rgba(255, 255, 255, 1), inset 3px 3px 6px rgba(255, 255, 255, 0.8), inset -3px -3px 6px rgba(13, 148, 136, 0.1)',
        'clay-active': 'inset 4px 4px 8px rgba(13, 148, 136, 0.15), inset -4px -4px 8px rgba(255, 255, 255, 0.8)',
        'clay-accent': '8px 8px 16px rgba(249, 115, 22, 0.2), -8px -8px 16px rgba(255, 255, 255, 0.9), inset 2px 2px 4px rgba(255, 255, 255, 0.9), inset -2px -2px 4px rgba(249, 115, 22, 0.2)',
        'clay-accent-active': 'inset 4px 4px 8px rgba(249, 115, 22, 0.25), inset -4px -4px 8px rgba(255, 255, 255, 0.9)',
        'sm': '0 1px 4px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04)',
        'md': '0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04)',
        'dark-sm': '0 1px 4px rgba(0,0,0,.5)',
        'dark-md': '0 4px 12px rgba(0,0,0,.5)',
      },
      borderRadius: {
        '4xl': '2rem',
        '5xl': '2.5rem',
        'clay': '1.5rem', // 24px
      },
      animation: {
        'bounce-soft': 'bounceSoft 2s infinite',
        'float': 'float 6s ease-in-out infinite',
        'wobble': 'wobble 4s ease-in-out infinite',
      },
      keyframes: {
        bounceSoft: {
          '0%, 100%': { transform: 'translateY(-5%)' },
          '50%': { transform: 'translateY(0)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-15px)' },
        },
        wobble: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        },
      }
    },
  },
  plugins: [],
}
