/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                dark: "#263238",
                danger: "#F44336",
                primary: "#2196F3",
                warning: "#FF7043",
                info: "#00BCD4",
            },
        },
    },
};
