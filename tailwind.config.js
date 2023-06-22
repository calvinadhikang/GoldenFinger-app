/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      typography: {
        DEFAULT: {
          css: {
            maxWidth: '100ch', // add required value here
          }
        }
      }
    },
  },
  plugins: [require("@tailwindcss/typography"), require("daisyui")],
  daisyui: {
    themes: [
      {
        mytheme: {
          "primary": "#FFD717", //warna utama
          "secondary": "#EEEEEE", //warna notifikasi
          "accent": "#f3cb45", //untuk counter dari background
          "base-100": "#0d0b08", //warna background
          "base-content": "#0d0b08", //warna text
        }
      }
    ]
  }
}

