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
        'button': '#A6D7D7',
        'input': '#D9D9D9',
        'delete': '#CD5C5CFF',
      },
      fontFamily: {
        'popp': ['Poppins', 'sans-serif'],
      },
      fontSize: {
        'h1': '36px',
        'textp': '24px',
      }
    },
    backgroundImage: {
      'form-gradient': 'linear-gradient(180deg, #6AADBA 0%, rgba(220, 239, 242, 0.00) 60.42%, rgba(202, 235, 242, 0.28) 77.6%)',
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

