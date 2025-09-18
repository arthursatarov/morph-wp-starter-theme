/** @see https://eslint.org/docs/latest/use/configure/ */
/** @type {import('eslint').Linter.Config} */

export default {
	env: {
		browser: true,
		es2020: true,
		node: true,
	},

	extends: [
		'eslint:recommended',
		'plugin:import/recommended',
		'plugin:prettier/recommended', // включает prettier и отключает конфликтующие правила
	],

	parserOptions: {
		ecmaVersion: 'latest',
		sourceType: 'module',
	},

	plugins: ['import', 'prettier'],

	rules: {
		/* General */
		'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',

		/* Prettier */
		'prettier/prettier': 'error',
	},

	settings: {
		'import/resolver': {
			node: {
				extensions: ['.js'],
			},
		},
	},
};
