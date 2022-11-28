const plugin = require('tailwindcss/plugin');


module.exports = {
    purge: {
        content: [
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php'
        ]
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
        themeVariants: ['dark'],
        customForms: (theme) => ({
            default: {
                'input, textarea': {
                    '&::placeholder': {
                        color: theme('colors.gray.400'),
                    },
                },
            },
        }),
    },
    variants: {
        extend: {},
    },
    plugins: [require('@tailwindcss/forms'), ],
}
