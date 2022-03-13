const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./vendor/usernotnull/tall-toasts/config/**/*.php",
        "./vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Proxima\\ Nova", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: colors.blue[600],
                    lighter: colors.blue[500],
                    darker: colors.blue[800],
                },
                muted: {
                    DEFAULT: colors.gray[400],
                    lighter: colors.gray[300],
                },
                dark: colors.gray[800],
                light: colors.white,
                // gray: colors.gray,
                // primary: {
                //     DEFAULT: colors.blue[600],
                //     lighter: colors.blue[500],
                //     lightest: colors.blue[300],
                //     darker: colors.blue[800],
                //     hover: colors.blue[700],
                //     muted: colors.blue[300],
                // },
            },
            // lineClamp: {
            //     7: '7',
            //     8: '8',
            //     9: '9',
            //     10: '10',
            // }
        },
        variants: {
            backgroundColor: ["children-disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/aspect-ratio"),
        // require('@tailwindcss/line-clamp'),
    ],
};
