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
    'bg-red-300',
    'bg-red-200',
    'bg-green-200',
    'bg-yellow-200',
    'bg-blue-200',
    'bg-indigo-200',
    'bg-purple-200',
    'bg-pink-200',
    'bg-orange-200',
    'bg-teal-200',
    'bg-lime-200',
    'bg-cyan-200',
    'bg-amber-200',
    'bg-fuchsia-200',
    'bg-emerald-200',
    'bg-rose-200',
    'bg-sky-200',
    'bg-violet-200', 
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
