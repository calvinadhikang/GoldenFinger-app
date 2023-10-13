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
          "primary-content": "#1a1f3c", //warna text ketika di class primary

          "secondary": "#4a8ff7", //warna notifikasi
          "secondary-content": "#F5F5F5", //warna text ketika di class primary

          "accent": "#1F2937", //untuk counter dari background

          "base-100": "#111827", //warna background
          "base-content": "#F5F5F5", //warna text
        }
      }
    ]
  }
}

