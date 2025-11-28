/**
 * Main JavaScript Entry Point
 *
 * @package Morph
 * @since 1.0.0
 */

import AccordionManager from './components/accordion.js';
import DrawerManager from './components/drawer.js';
import DropdownManager from './components/dropdown.js';
import ModalManager from './components/modal.js';
import TabsManager from './components/tabs.js';
import TooltipManager from './components/tooltip.js';
import { initTextInputs } from './components/input-text.js';

class App {
  constructor() {
    this.accordionManager = null;
		this.drawerManager = null;
    this.dropdownManager = null;
    this.modalManager = null;
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
		this.initDrawers();
    this.initDropdowns();
		this.initModals();
    this.initTabs();
    this.initTooltips();
		initTextInputs();
  }

	initAccordions() {
		this.accordionManager = new AccordionManager();
		this.accordionManager.init();
	}

	initDrawers() {
		this.drawerManager = new DrawerManager();
		this.drawerManager.init();
	}

	initDropdowns() {
    this.dropdownManager = new DropdownManager();
    this.dropdownManager.init();
  }

	initModals() {
		this.modalManager = new ModalManager();
		this.modalManager.init();
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
