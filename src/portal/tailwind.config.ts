// eslint-disable-next-line @typescript-eslint/no-var-requires
const colors = require('tailwindcss/colors')
const {
    toRGB,
    withOpacityValue,
    // eslint-disable-next-line @typescript-eslint/no-var-requires
} = require('@left4code/tw-starter/dist/js/tailwind-config-helper')

/** @type {import('tailwindcss').Config} */
module.exports = {
    mode: 'jit',
    content: [
        './resources/**/*.{php,html,js,jsx,ts,tsx,vue}',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                rgb: toRGB(colors),
                primary: '#5A6EC8',
                secondary: withOpacityValue('--color-secondary'),
                success: withOpacityValue('--color-success'),
                info: withOpacityValue('--color-info'),
                warning: withOpacityValue('--color-warning'),
                pending: withOpacityValue('--color-pending'),
                danger: withOpacityValue('--color-danger'),
                light: withOpacityValue('--color-light'),
                dark: withOpacityValue('--color-dark'),
                slate: {
                    50: withOpacityValue('--color-slate-50'),
                    100: withOpacityValue('--color-slate-100'),
                    200: withOpacityValue('--color-slate-200'),
                    300: withOpacityValue('--color-slate-300'),
                    400: withOpacityValue('--color-slate-400'),
                    500: withOpacityValue('--color-slate-500'),
                    600: withOpacityValue('--color-slate-600'),
                    700: withOpacityValue('--color-slate-700'),
                    800: withOpacityValue('--color-slate-800'),
                    900: withOpacityValue('--color-slate-900'),
                },
            },
            fontFamily: {
                roboto: ['Roboto'],
            },
            container: {
                center: true,
            },
            maxWidth: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
            },
            strokeWidth: {
                0.5: 0.5,
                1.5: 1.5,
                2.5: 2.5,
            },
            opacity: {
                '60': 0.6,
                '80': 0.8,
                '85': 0.85,
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
    variants: {
        extend: {
            boxShadow: ['dark'],
        },
    },
}
