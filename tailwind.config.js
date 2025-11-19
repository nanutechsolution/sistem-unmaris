import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import aspectRatio from "@tailwindcss/aspect-ratio";
import lineClamp from "@tailwindcss/line-clamp";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.jsx",
        "./resources/js/**/*.tsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },

            // Brand palette (derived from your logo)
            colors: {
                // Primary blue family for headings, nav, CTAs
                "unmaris-blue": {
                    DEFAULT: "#003A70", // primary
                    900: "#00274A",
                    800: "#00335E",
                    700: "#005BBB",
                    600: "#1E5AA8",
                    500: "#2A6FB2",
                    300: "#6AA0E0",
                    100: "#EAF4FF",
                },

                // Secondary yellow family for accents / CTA highlight
                "unmaris-yellow": {
                    DEFAULT: "#F4C400",
                    600: "#E0AB00",
                    500: "#F4C400",
                    400: "#FFD84B",
                    200: "#FFF3D1",
                },

                // Accent green (for success badges, highlights)
                "unmaris-green": {
                    DEFAULT: "#27AE60",
                    600: "#219653",
                    400: "#66D187",
                    100: "#ECFFF2",
                },

                // Accent orange for warnings / subtle accents
                "unmaris-orange": {
                    DEFAULT: "#F57C00",
                    600: "#D36A00",
                    400: "#FF9A3C",
                },

                // Neutral tokens (semantic)
                "brand-bg": "#F8FAFC",
                "brand-surface": "#FFFFFF",
                "brand-muted": "#6B7280", // tailwind gray-500 like
                "brand-border": "#E6E9EE",
                "brand-ring": "#CDE6FF",
            },

            // Custom shadows & radii if needed
            boxShadow: {
                "brand-sm": "0 4px 14px rgba(2,6,23,0.06)",
                "brand-md": "0 10px 30px rgba(2,6,23,0.08)",
                "brand-lg": "0 30px 70px rgba(2,6,23,0.12)",
            },

            borderRadius: {
                "xl-2": "1rem",
            },

            // Useful sizes for hero / image accents
            spacing: {
                128: "32rem",
                144: "36rem",
            },

            // Typography defaults for prose (Tailwind Typography)
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme("colors.gray.800"),
                        a: {
                            color: theme("colors.unmaris-blue.DEFAULT"),
                            "&:hover": {
                                color: theme("colors.unmaris-yellow.DEFAULT"),
                            },
                        },
                        h1: { color: theme("colors.unmaris-blue.DEFAULT") },
                        h2: { color: theme("colors.unmaris-blue.DEFAULT") },
                        h3: { color: theme("colors.unmaris-blue.800") },
                        code: { backgroundColor: theme("colors.gray.100") },
                        "blockquote p:first-of-type::before": false,
                        "blockquote p:last-of-type::after": false,
                    },
                },
            }),
        },
    },

    plugins: [forms, typography, aspectRatio, lineClamp],
};
