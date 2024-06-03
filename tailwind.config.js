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
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
    ],
    theme: {
        extend: {},
    },
    daisyui: {
        themes: ["light", "dark", "cupcake", "dracula"],
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}
