/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'bangers': ['Bangers', 'cursive'],
        'mansalva': ['Mansalva', 'cursive'],
      }
    }
  },
  plugins: [],
}