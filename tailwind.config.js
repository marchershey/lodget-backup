const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        './vendor/usernotnull/tall-toasts/config/**/*.php',
        './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            // colors: {
            //     gray: colors.gray,
            //     muted: colors.gray[400],
            //     primary: {
            //         DEFAULT: colors.blue[600],
            //         lighter: colors.blue[500],
            //         lightest: colors.blue[300],
            //         darker: colors.blue[800],
            //         hover: colors.blue[700],
            //         muted: colors.blue[300],
            //     },
            // },
            // fontFamily: {
            //     sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            // },
            // lineClamp: {
            //     7: '7',
            //     8: '8',
            //     9: '9',
            //     10: '10',
            // }
        },
    },

    plugins: [
        // require('@tailwindcss/forms'),
        // require('@tailwindcss/aspect-ratio'),
        // require('@tailwindcss/line-clamp'),
    ],

}