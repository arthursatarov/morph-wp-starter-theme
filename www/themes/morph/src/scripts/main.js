/**
 * Main JavaScript Entry Point
 *
 * @package Morph
 * @since 1.0.0
 */

import AccordionManager from './components/accordion.js';
import DropdownManager from './components/dropdown.js';
import TabsManager from './components/tabs.js';
import TooltipManager from './components/tooltip.js';

class App {
  constructor() {
    this.accordionManager = null;
    this.dropdownManager = null;
		this.tabsManager = null;
    this.tooltipManager = null;
    this.init();
  }

  init() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.onReady());
    } else {
      this.onReady();
    }
  }

  onReady() {
    console.log('🚀 Morph theme initialized');

    this.initAccordions();
    this.initDropdowns();
    this.initTabs();
    this.initTooltips();
  }

	initAccordions() {
		this.accordionManager = new AccordionManager();
		this.accordionManager.init();
	}

	initDropdowns() {
    this.dropdownManager = new DropdownManager();
    this.dropdownManager.init();
  }

	initTabs() {
		this.tabsManager = new TabsManager();
		this.tabsManager.init();
	}

  initTooltips() {
    this.tooltipManager = new TooltipManager();
    this.tooltipManager.init();
  }
}

const app = new App();
window.morphApp = app;

export default app;
