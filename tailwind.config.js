import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],
    darkMode: "selector",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    700: colors.gray[700],
                    800: colors.gray[800],
                    900: colors.gray[900],
                },
                light: {
                    100: colors.gray[100],
                    200: colors.gray[200],
                    300: colors.gray[300],
                    400: colors.gray[400],
                },
            },
        },
    },

    plugins: [forms],
};
