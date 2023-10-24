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
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

