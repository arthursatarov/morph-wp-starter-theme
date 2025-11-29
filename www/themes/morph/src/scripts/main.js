/**
 * Main JavaScript Entry Point
 *
 * @package Morph
 * @since 0.0.1
 */

import { initAccordions } from './components/accordion.js';
import { initDrawers } from './components/drawer.js';
import { initDropdowns } from './components/dropdown.js';
import { initModals } from './components/modal.js';
import { initTabs } from './components/tabs.js';
import { initTooltips } from './components/tooltip.js';
import { initTextInputs } from './components/input-text.js';

/**
 * Initialize all components
 */
function init() {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady);
  } else {
    onReady();
  }
}

/**
 * Initialize components when DOM is ready
 */
function onReady() {
  console.log('🚀 Morph theme initialized');

  initAccordions();
  initDrawers();
  initDropdowns();
  initModals();
  initTabs();
  initTooltips();
  initTextInputs();
}

// Auto-initialize
init();
