import defaultTheme from "tailwindcss/defaultTheme";
import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./node_modules/flowbite/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/services/*.ts",
    ],
    darkMode: "selector",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xxs: "0.65rem",
            },
            colors: {
                primary: "#0d6efd",
                secondary: "#212529bf",
                success: colors.teal["600"],
                info: colors.sky["600"],
                warning: colors.amber["600"],
                error: colors.rose["600"],
                dark: colors.zinc["600"],
            },
            maxWidth: {
                xxs: "12rem",
            },
        },
    },

    plugins: [require("flowbite/plugin")],
};
