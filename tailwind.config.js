/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/typography"), require("daisyui")],
  daisyui: {
    themes: [
      {
        // mytheme: {
        //   "primary": "#FFD369", //warna utama
        //   "secondary": "#EEEEEE",
        //   "accent": "#393E46", //untuk counter dari background
        //   "neutral": "#222831",
        //   "base-100": "#222831", //warna background
        //   "base-content": "#FFFFFF" //warna text
        // }
        mytheme: {
          "primary": "#FFD717", //warna utama
          "secondary": "#EEEEEE", //warna notifikasi
          "accent": "#083358", //untuk counter dari background
          "base-100": "#001F3F", //warna background
          "base-content": "#FFFFFF" //warna text
        }
      }
    ]
  }
}

