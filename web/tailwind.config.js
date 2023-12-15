const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
	content: ['./src/**/*.{html,js,svelte,ts}'],
	theme: {
		extend: {
			boxShadow: {
				DEFAULT: '0px 6px 20px 0px rgba( 0, 0, 0, 0.25 )'
			}
		},
		fontFamily: {
			sans: ['"Poppins"', 'system-ui', 'sans-serif']
		},
		colors: {
			transparent: 'transparent',
			current: 'currentColor',
			inherit: 'inherit',
			'near-black': '#111111',
			black: colors.black,
			blue: colors.blue,
			red: colors.red,
			white: colors.white,
			gray: colors.gray,
			green: '#075c20',
			'dark-green': '#05280f',
			'washed-green':'#e8fdf5'
		},
		zIndex: {
			0: '0',
			1: '1',
			2: '2',
			3: '3',
			4: '4',
			5: '5',
			6: '6',
			7: '7',
			8: '8',
			9: '9',
			max: '9999',
			auto: 'auto'
		}
	},
	plugins: []
};
