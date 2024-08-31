/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
  theme: {
    extend: {
        colors: {
            //main paleta
            "peach": "#f9e4d9",
            "bright-peach": "rgba(255,240,233,0.85)",
            "brighter-peach": "#fff9f6",
            "dark-pink": "#b2247e",
            "blue": "#92b9dd",
            "purple": "#a683c9",
            "green": "#81a282",
            "yellow": "#fece7c",

            //svetlije boje
            "pink": "#F8C8DC",
            "mint": "#c3e4e5",
            "lavender": "#D4B9E6",
            "bright-yellow": "#fde7b8"
        },
        fontFamily: {
            "mulish": ["Mulish", "sans-serif"],
        },
    },
  },
  plugins: [],
}

