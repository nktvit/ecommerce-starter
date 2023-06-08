const defaultTheme = require('tailwindcss/defaultTheme')
const defaultColors = require('tailwindcss/colors')

module.exports = {
    content: [
        './src/**/*.js',
        'node_modules/flowbite-react/**/*.{js,jsx,ts,tsx}',
    ],
    darkMode: 'media',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Palette from
                // https://color.adobe.com/ru/Online-Store-color-theme-ec04591e-eb77-444b-995d-139e8bf16f9b/
                primary: '#8D33F5',
                secondary: '#2AABAD',
                surface: '#DAFAFB',
                element: defaultColors.amber['400'],
            },
        },
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],
}
