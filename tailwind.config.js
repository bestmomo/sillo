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
  theme: {
    extend: {
      colors: {
        beige: "beige",
      },
      transitionTimingFunction: {
        gentle: "cubic-bezier(0.38, 0, 0.25, 0.99)",
      },
    },
  },
  daisyui: {
    themes: ["light", "dark"],
  },

  plugins: [require("@tailwindcss/typography"), require("daisyui")],
};
