/** @type {import('tailwindcss').Config} */
export default {
  content: [
    // You will probably also need these lines
    "./resources/**/**/*.blade.php",
    "./resources/**/**/*.js",
    "./app/View/Components/**/**/*.php",
    "./app/Livewire/**/**/*.php",

    // Add mary
    "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  safelist: [
    {
      pattern:
        /(!)?bg-(red|green|yellow|blue|indigo|purple|pink|orange|teal|lime|cyan|amber|fuchsia|emerald|rose|sky|violet)-200/,
    },
    "bg-red-300",
    "alert-success",
    "alert-info",
    "alert-warning",
  ],
  theme: {
    extend: {
      colors: {
        beige: "beige",
      },
      fontFamily: {
        comic: ['"Comic Sans MS"', "cursive", "sans-serif"],
        new: ['"Courier new"', "cursive", "sans-serif"],
        shadow: ['"shadow"', "sans-serif"],
      },
      transitionTimingFunction: {
        gentle: "cubic-bezier(0.38, 0, 0.25, 0.99)",
      },
    },
  },
  daisyui: {
    themes: ["light", "dark", "cupcake"],
  },
  corePlugins: {
    backgroundOpacity: false,
  },
  plugins: [require("@tailwindcss/typography"), require("daisyui")],
};

