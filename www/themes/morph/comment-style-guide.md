# Code Comment Style Guide

A unified comment system for visual code organization across PHP, SCSS, and JavaScript files.

---

## PHP

```php
<?php
/**
 * Brief description of the file's purpose
 *
 * Longer description if needed, explaining the file's
 * role in the project and any important notes.
 *
 * @package     ProjectName
 * @author      Your Name
 * @copyright   2024 Company Name
 * @license     MIT
 * @version     1.0.0
 * @link        https://project-url.com
 * @since       1.0.0
 */


/* ======================================================
Table of Contents (2 breaks before)
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
 1.0 CONFIGURATION
 2.0 INITIALIZATION
 3.0 HELPER FUNCTIONS
 4.0 MAIN LOGIC
====================================================== */


/* ======================================================
  1.0 MAIN LEVEL (uppercase)
====================================================== */

/* 1.1 FIRST SUB-LEVEL
/––––––––––––––––––––––––------------ */
/**
 * Brief description of what this function does.
 *
 * More detailed explanation if needed.
 *
 * @package     ProjectName
 * @since       1.0.0
 *
 * @param string $param Description of parameter.
 * @return void
 */
function example_function( $param ) {
  // Simple inline comment for clarification
  echo 'code goes here';
}
add_action( 'init', 'example_function' );

/* 1.2 ANOTHER SUB-LEVEL
/––––––––––––––––––––––––------------ */
/**
 * Another function with documentation.
 *
 * @package     ProjectName
 * @since       1.0.0
 * @link        https://url-goes-here-if-needed.com
 *
 * @return array
 */
function another_function() {
  return array();
}


/* ======================================================
  2.0 ANOTHER MAIN LEVEL
====================================================== */

/* 2.1 SUB-LEVEL
/––––––––––––––––––––––––------------ */
// Simple comment for non-function code blocks

if ( $condition ) :
  echo 'implementation';
endif;
```

---

## SCSS

```scss
////
/// Brief description of the file's purpose
///
/// Longer description if needed, explaining the stylesheet's
/// role and structure.
///
/// @group ComponentName
/// @author Your Name
/// @since 1.0.0
////


/* ======================================================
Table of Contents (2 breaks before)
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
 1.0 VARIABLES
 2.0 MIXINS
 3.0 BASE STYLES
 4.0 COMPONENTS
====================================================== */


/* ======================================================
  1.0 MAIN LEVEL (uppercase)
====================================================== */

/* 1.1 FIRST SUB-LEVEL
/––––––––––––––––––––––––------------ */
/// Brief description of what this mixin does.
///
/// More detailed explanation if needed.
///
/// @group ComponentName
/// @param {String} $param - Description of parameter
/// @example scss - Usage example
///   @include example-mixin('value');
@mixin example-mixin($param) {
  property: $param;
}

/* 1.2 ANOTHER SUB-LEVEL
/––––––––––––––––––––––––------------ */
/// Function description.
///
/// @group Utilities
/// @param {Number} $value - Input value
/// @return {Number} Calculated result
/// @link https://url-goes-here-if-needed.com
@function calculate($value) {
  @return $value * 2;
}


/* ======================================================
  2.0 ANOTHER MAIN LEVEL
====================================================== */

/* 2.1 SUB-LEVEL
/––––––––––––––––––––––––------------ */
// Simple comment for styles

.component {
  // Inline comment for clarification
  property: value;
}
```

---

## JavaScript

```javascript
/**
 * @fileoverview Brief description of the file's purpose
 *
 * Longer description if needed, explaining the module's
 * functionality and dependencies.
 *
 * @module ModuleName
 * @author Your Name
 * @version 1.0.0
 * @since 1.0.0
 * @see {@link https://project-url.com}
 */


/* ======================================================
Table of Contents (2 breaks before)
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
 1.0 IMPORTS
 2.0 CONFIGURATION
 3.0 UTILITY FUNCTIONS
 4.0 MAIN LOGIC
====================================================== */


/* ======================================================
  1.0 MAIN LEVEL (uppercase)
====================================================== */

/* 1.1 FIRST SUB-LEVEL
/––––––––––––––––––––––––------------ */
/**
 * Brief description of what this function does.
 *
 * More detailed explanation if needed.
 *
 * @param {string} param - Description of parameter.
 * @returns {void}
 * @since 1.0.0
 */
function exampleFunction(param) {
  // Simple inline comment for clarification
  console.log(param);
}

/* 1.2 ANOTHER SUB-LEVEL
/––––––––––––––––––––––––------------ */
/**
 * Another function with documentation.
 *
 * @param {number} value - Input value.
 * @returns {number} Calculated result.
 * @see https://url-goes-here-if-needed.com
 * @since 1.0.0
 */
function anotherFunction(value) {
  return value * 2;
}


/* ======================================================
  2.0 ANOTHER MAIN LEVEL
====================================================== */

/* 2.1 SUB-LEVEL
/––––––––––––––––––––––––------------ */
// Simple comment for code blocks

if (condition) {
  // Inline clarification
  console.log('implementation');
}
```

---

## Comment Hierarchy

1. **File Header** - DocBlock with file description, author, version
2. **Table of Contents** - Optional, for larger files (preceded by 2 line breaks)
3. **Main Level** - Major section headers with equals signs (uppercase text)
4. **First Sub-Level** - Visual subsection dividers with dashes (numbered like 1.1, 1.2)
5. **Documentation Blocks** - Language-specific DocBlocks for functions/mixins:
   - **PHP**: PHPDoc blocks for functions
   - **SCSS**: SassDoc blocks (///) for mixins and functions
   - **JavaScript**: JSDoc blocks for functions and classes
6. **Inline Comments** - Simple `//` comments for code clarification

## Usage Guidelines

- Use **2 line breaks** before Table of Contents
- Use **2 line breaks** before each Main Level section
- Use **1 line break** after First Sub-Level dividers
- Keep Main Level headers in UPPERCASE
- Number First Sub-Level headers (1.1, 1.2, etc.) for easy reference
- Use proper DocBlocks for all functions, mixins, and classes:
  - **PHP**: PHPDoc with @param, @return, @since tags
  - **SCSS**: SassDoc (///) with @param, @return, @group tags
  - **JavaScript**: JSDoc with @param, @returns, @since tags
- Use simple `//` comments for inline code clarification
- Include @link or @see in DocBlocks when referencing external resources
- Maintain consistent indentation and spacing across all file types
