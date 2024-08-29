/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            keyframes: {
                wiggle: {
                    '0%, 100%': { 
                        transform: 'rotate(-3deg) scale(97%)'
                    },
                    '50%': { transform: 'rotate(3deg) scale(103%)',
                        "-moz-box-shadow": "drop-shadow(5px 6px 8px rgba(0,0,0,0.3))",
                        "-webkit-filter": "drop-shadow(5px 6px 8px rgba(0,0,0,0.3))",
                        filter: "drop-shadow(5px 6px 8px rgba(0,0,0,0.3))",
                    },
                }
            },
            animation: {
                wiggle: 'wiggle 5s ease-in-out infinite',
            }
        },
    },
    plugins: [
        "prettier-plugin-tailwindcss",
    ],
}

