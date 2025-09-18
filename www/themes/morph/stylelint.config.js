/** @see https://stylelint.io/user-guide/rules */
/** @type {import('stylelint').Config} */

export default {
	extends: [
		'stylelint-config-standard-scss',
		'stylelint-config-recess-order',
	],
	plugins: ['stylelint-order', 'stylelint-prettier'],
	rules: {
		/* Naming / Selectors */
		'selector-class-pattern': null,

		/* Values */
		'value-keyword-case': [
			'lower',
			{ camelCaseSvgKeywords: true },
		],
		'color-function-notation': 'modern',
		'hue-degree-notation': 'number',

		/* Media queries */
		'media-feature-range-notation': 'prefix',

		/* Declarations */
		'declaration-block-single-line-max-declarations': 1,
		'declaration-block-no-redundant-longhand-properties': null,

		/* SCSS */
		'scss/dollar-variable-pattern': null,

		/* Prettier integration */
		'prettier/prettier': true,
	},
	overrides: [
		{
			files: ['**/*.scss'],
			customSyntax: 'postcss-scss',
		},
	],
};
