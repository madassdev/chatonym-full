const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                "cha-primary": "#6A50D3",
                "cha-secondary": "#F9F8FF",
                // "cha-secondary": "#c6c2e0",
                "cha-light": "#F9F8FF",
                "cha-accent": "#A7D2F1"
            },
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },

            margin:{
                "1/4p" : "25%",
                "1/2p" : "50%",
                "3/4p" : "75%"
            }
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
