/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.{html,js,php}',
    './tools/*.{html,js,php}',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
  ],
}
