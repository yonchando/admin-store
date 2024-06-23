/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                "light-200": "#ddd",
                "light-400": "#fafafa",
                "dark-200": "#324148",
                "dark-400": "#263238",
                "dark-600": "#1e272c",
                danger: "#F44336",
                primary: "#2196F3",
                warning: "#FF7043",
                info: "#00BCD4",
                success: "#4caf50",
                active: "#26a69a",
            },
        },
    },
};
