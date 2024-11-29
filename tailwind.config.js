/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            fontFamily: {
                'base': ['Plus Jakarta Sans', 'Helvetica', 'system-ui', 'sans-serif'],
                'theme': ['Ledger', 'Courgette', 'Helvetica', 'system-ui', 'sans-serif'],
            },
            colors: {
                "primary-dark": "hsl( var(--color-primary-dark) / <alpha-value> )",
                "primary-light": "hsl( var(--color-primary-light) / <alpha-value> )",
                "accent": "hsl( var(--color-accent) / <alpha-value> )",
                "text": "hsl( var(--color-text  ) / <alpha-value> )",
                "background": "hsl( var(--color-background) / <alpha-value> )",
                "background-accent": "hsl( var(--color-background-accent) / <alpha-value> )"
            },
        },
    },
    plugins: [],
}

