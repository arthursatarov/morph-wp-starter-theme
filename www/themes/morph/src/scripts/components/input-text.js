/**
 * Text Input Component
 * Handles text input interactions: focus, clear, password toggle
 *
 * @package MORPH
 * @since 0.0.1
 */

import { updateIcon, triggerInputEvent } from '../utils/form-helpers.js';

/* ======================================================
  FEATURE HANDLERS
====================================================== */

/**
 * Focus management - click wrapper to focus input
 * @param {HTMLElement} wrapper - Input wrapper element
 * @param {HTMLInputElement} input - Input element
 */
function initFocusHandling(wrapper, input) {
  wrapper.addEventListener('click', (e) => {
    // Don't focus if clicking on action button
    if (e.target !== input && !e.target.closest('.input-text__action')) {
      input.focus();
    }
  });
}

/**
 * Clear input action
 * @param {HTMLElement} button - Clear button
 * @param {HTMLElement} wrapper - Input wrapper element
 */
function initClearAction(button, wrapper) {
  const input = wrapper.querySelector('.input-text__input');
  if (!input) return;

  // Show/hide button based on input value
  const toggleButton = () => {
    button.hidden = input.value.length === 0;
  };

  input.addEventListener('input', toggleButton);

  button.addEventListener('click', (e) => {
    e.preventDefault();
    input.value = '';
    input.focus();
    button.hidden = true;
    triggerInputEvent(input);
  });

  // Set initial state
  toggleButton();
}

/**
 * Password visibility toggle
 * @param {HTMLElement} button - Toggle button
 * @param {HTMLElement} wrapper - Input wrapper element
 */
function initPasswordToggle(button, wrapper) {
  const input = wrapper.querySelector('.input-text__input');
  if (!input) return;

  button.addEventListener('click', (e) => {
    e.preventDefault();

    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';

    // Update aria-label for accessibility
    button.setAttribute(
      'aria-label',
      isPassword ? 'Скрыть пароль' : 'Показать пароль'
    );

    // Update icon
    const iconName = isPassword ? 'icon-eye-off-regular' : 'icon-eye-regular';
    updateIcon(button, iconName);
  });
}

/* ======================================================
  MAIN INITIALIZATION
====================================================== */

/**
 * Initialize all text input features
 * Searches for .input-text wrappers and attaches event listeners
 */
export function initTextInputs() {
  const wrappers = document.querySelectorAll('.input-text');

  if (wrappers.length === 0) {
    return;
  }

  wrappers.forEach(wrapper => {
    const input = wrapper.querySelector('.input-text__input');

    if (!input) {
      console.warn('TextInput: input field not found', wrapper);
      return;
    }

    // Core: Focus handling
    initFocusHandling(wrapper, input);

    // Actions: Clear button
    const clearButton = wrapper.querySelector('[data-clear-input]');
    if (clearButton) {
      initClearAction(clearButton, wrapper);
    }

    // Actions: Password toggle
    const toggleButton = wrapper.querySelector('[data-toggle-password]');
    if (toggleButton) {
      initPasswordToggle(toggleButton, wrapper);
    }
  });

  console.log(`✅ Initialized ${wrappers.length} text input(s)`);
}
