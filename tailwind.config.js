/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,js,php}"],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        "primary": "#845af6",
        "background-light": "#f6f5f8",
        "background-dark": "#151022",
      },
      fontFamily: {
        "display": ["Outfit", "sans-serif"],
        "sans": ["Outfit", "sans-serif"],
      },
      borderRadius: {
        "DEFAULT": "0.25rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "full": "9999px"
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/container-queries'),
  ],
}
