/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primaryColor: '#FEFAF2',
        colorGreen: '#C5F280',
        colorBlue: '#94D7F2',
        colorOrange: '#BF5B04',
        colorYellow: '#F2C879',
      },
    },
  },
  plugins: [],
}
