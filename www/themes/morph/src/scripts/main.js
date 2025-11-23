/**
 * Main JavaScript Entry Point
 *
 * @package Morph
 * @since 0.0.1
 */

// Import components
import TooltipManager from './components/tooltip.js';
import AccordionManager from './components/accordion.js';

/**
 * Initialize Application
 */
class App {
	constructor() {
		this.tooltipManager = null;
		this.accordionManager = null;
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

		// Initialize components
		this.initTooltips();
		this.initAccordions();
	}

	/**
	 * Initialize Tooltips
	 */
	initTooltips() {
		this.tooltipManager = new TooltipManager({
			selector: '[data-tooltip]',
			placement: 'bottom',
			offset: [0, 4],
		});
		this.tooltipManager.init();

		// Expose globally for debugging
		if (process.env.NODE_ENV !== 'production') {
			window.tooltipManager = this.tooltipManager;
		}
	}

	/**
	 * Initialize Accordions
	 */
	initAccordions() {
		this.accordionManager = new AccordionManager({
			selector: '[data-accordion]',
			itemSelector: '.accordion__item',
			triggerSelector: '.accordion__item-trigger',
			contentSelector: '.accordion__item-content',
			keyboardNav: true,
		});
		this.accordionManager.init();

		// Listen to accordion events
		document.addEventListener('accordion:open', (e) => {
			console.log('📂 Accordion opened:', e.detail.content.id);
		});

		document.addEventListener('accordion:close', (e) => {
			console.log('📁 Accordion closed:', e.detail.content.id);
		});

		// Expose globally for debugging
		if (process.env.NODE_ENV !== 'production') {
			window.accordionManager = this.accordionManager;
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

	/**
	 * Refresh accordions after dynamic content load
	 */
	refreshAccordions() {
		if (this.accordionManager) {
			this.accordionManager.refresh();
		}
	}

	/**
	 * Refresh all components
	 */
	refreshAll() {
		this.refreshTooltips();
		this.refreshAccordions();
	}
}

// Initialize App
const app = new App();

// Expose app globally for external access
window.morphApp = app;

// Export for modules
export default app;
