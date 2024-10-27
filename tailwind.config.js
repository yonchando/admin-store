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
        "./resources/js/services/*.ts",
    ],
    darkMode: "selector",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                success: colors.teal["600"],
                info: colors.sky["600"],
                warning: colors.amber["600"],
                error: colors.rose["600"],
            },
        },
    },

    plugins: [forms],
};
