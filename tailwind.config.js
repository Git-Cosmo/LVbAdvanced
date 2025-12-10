/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        // GitHub Copilot inspired dark theme
        dark: {
          bg: {
            primary: '#0d1117',    // Main background
            secondary: '#161b22',  // Cards/blocks background
            tertiary: '#21262d',   // Hover states
            elevated: '#1c2128',   // Elevated elements
          },
          border: {
            primary: '#30363d',    // Main borders
            secondary: '#21262d',  // Subtle borders
            accent: '#58a6ff',     // Accent borders
          },
          text: {
            primary: '#c9d1d9',    // Main text
            secondary: '#8b949e',  // Secondary text
            tertiary: '#6e7681',   // Muted text
            bright: '#f0f6fc',     // Headings
            accent: '#58a6ff',     // Links/accent
          },
        },
        // Light theme (not pure white, softer)
        light: {
          bg: {
            primary: '#f6f8fa',    // Main background
            secondary: '#ffffff',  // Cards/blocks background
            tertiary: '#f3f4f6',   // Hover states
            elevated: '#ffffff',   // Elevated elements
          },
          border: {
            primary: '#d0d7de',    // Main borders
            secondary: '#e5e7eb',  // Subtle borders
            accent: '#0969da',     // Accent borders
          },
          text: {
            primary: '#24292f',    // Main text
            secondary: '#57606a',  // Secondary text
            tertiary: '#6e7781',   // Muted text
            bright: '#1f2328',     // Headings
            accent: '#0969da',     // Links/accent
          },
        },
        // Accent colors
        accent: {
          purple: '#a371f7',
          blue: '#58a6ff',
          green: '#3fb950',
          orange: '#f78166',
          yellow: '#d29922',
          red: '#f85149',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
      },
      boxShadow: {
        'dark-sm': '0 1px 2px 0 rgba(0, 0, 0, 0.3)',
        'dark-md': '0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2)',
        'dark-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2)',
        'dark-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2)',
      },
    },
  },
  plugins: [],
}
