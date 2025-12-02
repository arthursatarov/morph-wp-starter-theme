/**
 * Common Form Utilities
 * Shared helper functions for form components
 *
 * @package MORPH
 * @since 0.0.1
 */

/**
 * Get sprite icon base path from use element
 * @param {SVGUseElement} useElement - SVG use element
 * @returns {string} Base path to sprite
 */
export function getIconPath(useElement) {
  const href = useElement.getAttribute('xlink:href') || useElement.getAttribute('href');
  return href ? href.substring(0, href.lastIndexOf('#')) : '';
}

/**
 * Update SVG icon in button
 * @param {HTMLElement} button - Button containing icon
 * @param {string} iconName - New icon ID from sprite
 */
export function updateIcon(button, iconName) {
  const use = button.querySelector('use');
  if (!use) return;

  const basePath = getIconPath(use);
  use.setAttribute('xlink:href', `${basePath}#${iconName}`);
  use.setAttribute('href', `${basePath}#${iconName}`);
}

/**
 * Trigger input event for other listeners (e.g., validation)
 * @param {HTMLElement} element - Input element
 */
export function triggerInputEvent(element) {
  element.dispatchEvent(new Event('input', { bubbles: true }));
}

/**
 * Trigger change event for other listeners (e.g., validation)
 * @param {HTMLElement} element - Form element
 */
export function triggerChangeEvent(element) {
  element.dispatchEvent(new Event('change', { bubbles: true }));
}
