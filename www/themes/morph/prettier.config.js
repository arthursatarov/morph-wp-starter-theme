/** @see https://prettier.io/docs/en/options.html */
/** @type {import("prettier").Config} */

export default {
	/* General */
	semi: true,
	singleQuote: true, // одинарные кавычки в JS
	printWidth: 100,
	tabWidth: 2,
	useTabs: true, // WP Core предпочитает tabs для JS/PHP
	bracketSpacing: true,
	trailingComma: 'es5',

	/* JSX */
	jsxSingleQuote: false,
	arrowParens: 'always',

	overrides: [
		{
			files: '*.scss',
			options: {
				singleQuote: false, // в SCSS WP обычно использует двойные кавычки
			},
		},
		{
			files: '*.php',
			options: {
				// работает, если добавить prettier-plugin-php
				parser: 'php',
			},
		},
	],
};
