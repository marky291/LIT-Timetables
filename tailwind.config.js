const colors = require('tailwindcss/colors')

module.exports = {
    important: true,
    purge: [
        './resources/views/**/*.blade.php',
        './resources/css/**/*.css',
    ],
    theme: {
        extend: {
            colors: {
                orange: colors.orange,
                'panel-gray': '#f7f8fc',
                'lit-red': '#d71d1e',
            }
        },
        theme: {
            fontFamily: {
                'sans': ['Inter var', 'Helvetica', 'Arial', 'sans-serif'],
            }
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
    ]
}
