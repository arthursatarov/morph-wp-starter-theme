/**
 * Main JavaScript Entry Point
 *
 * @package Morph
 * @since 0.0.1
 */

// Import components
import TooltipManager from './components/tooltip.js';

// Import vendor initializations (если есть)
// import './vendors/swiper-init.js';

/**
 * Initialize Application
 */
class App {
  constructor() {
    this.tooltipManager = null;
    this.init();
  }

  /**
   * Initialize all components
   */
  init() {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.onReady());
    } else {
      this.onReady();
    }
  }

  /**
   * DOM Ready handler
   */
  onReady() {
    console.log('🚀 Morph theme initialized');

    // Initialize Tooltip Manager
    this.initTooltips();

    // Initialize other components
    // this.initModals();
    // this.initAccordions();
  }

  /**
   * Initialize Tooltips
   */
  initTooltips() {
    this.tooltipManager = new TooltipManager({
      selector: '[data-tooltip]',
      placement: 'bottom',
      offset: [0, 4]
    });

    this.tooltipManager.init();

    // Expose globally for debugging
    if (process.env.NODE_ENV !== 'production') {
      window.tooltipManager = this.tooltipManager;
    }
  }

  /**
   * Refresh tooltips after dynamic content load
   */
  refreshTooltips() {
    if (this.tooltipManager) {
      this.tooltipManager.refresh();
    }
  }
}

// Initialize App
const app = new App();

// Expose app globally for external access
window.morphApp = app;

// Export for modules
export default app;
