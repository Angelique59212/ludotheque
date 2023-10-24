/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'header': "#1C5D99",
        'link': "#BBCDE5",
        'h1Home': '#1C5D99',
        'pColor' : '#222222',
        'footer' : '#222222',
      },
      fontFamily: {
        'popp': ['Poppins', 'sans-serif'],
      },
      fontSize: {
        'h1': '36px',
        'textp': '24px',
      }
    },
    // screens: {
    //
    //   '2xl': {'max': '1535px'},
    //   // => @media (max-width: 1535px) { ... }
    // }
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

