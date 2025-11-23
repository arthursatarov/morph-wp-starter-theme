/**
 * Accordion Component
 *
 * Manages accessible accordion functionality with configurable behavior
 *
 * @package Morph
 * @since 0.0.1
 */

class AccordionManager {
  /**
   * Constructor
   *
   * @param {Object} options - Configuration options
   * @param {string} options.selector - Accordion container selector
   * @param {string} options.itemSelector - Accordion item selector
   * @param {string} options.triggerSelector - Accordion trigger selector
   * @param {string} options.contentSelector - Accordion content selector
   * @param {boolean} options.keyboardNav - Enable keyboard navigation
   */
  constructor(options = {}) {
    this.options = {
      selector: '[data-accordion]',
      itemSelector: '.accordion__item',
      triggerSelector: '.accordion__item-trigger',
      contentSelector: '.accordion__item-content',
      keyboardNav: true,
      ...options
    };

    this.accordions = [];
  }

  /**
   * Initialize all accordions
   */
  init() {
    const containers = document.querySelectorAll(this.options.selector);

    containers.forEach(container => {
      this.initAccordion(container);
    });

    console.log(`✅ Initialized ${this.accordions.length} accordion(s)`);
  }

  /**
   * Initialize single accordion
   *
   * @param {HTMLElement} container - Accordion container element
   */
  initAccordion(container) {
    // Get accordion mode: 'collapse' or 'open'
    const mode = container.dataset.accordion || 'open';
    const collapseOthers = mode === 'collapse';

    const items = container.querySelectorAll(this.options.itemSelector);

    if (items.length === 0) {
      console.warn('⚠️ No accordion items found in:', container);
      return;
    }

    const triggers = [];
    const accordionItems = [];

    items.forEach((item, index) => {
      const trigger = item.querySelector(this.options.triggerSelector);
      const content = item.querySelector(this.options.contentSelector);

      if (!trigger || !content) {
        console.warn('⚠️ Incomplete accordion item:', item);
        return;
      }

      // Get initial state from aria-expanded
      const ariaExpanded = trigger.getAttribute('aria-expanded');
      const isInitiallyOpen = ariaExpanded === 'true';

      // Generate unique IDs
      const triggerId = trigger.id || `accordion-trigger-${this.accordions.length}-${index}`;
      const contentId = content.id || `accordion-content-${this.accordions.length}-${index}`;

      trigger.id = triggerId;
      content.id = contentId;

      // Set button type if not present
      if (!trigger.hasAttribute('type') && trigger.tagName === 'BUTTON') {
        trigger.setAttribute('type', 'button');
      }

      // Set ARIA attributes
      trigger.setAttribute('aria-expanded', String(isInitiallyOpen));
      trigger.setAttribute('aria-controls', contentId);
      trigger.setAttribute('data-accordion-target', contentId);
      content.setAttribute('role', 'region');
      content.setAttribute('aria-labelledby', triggerId);
      content.hidden = !isInitiallyOpen;

      triggers.push(trigger);
      accordionItems.push({ item, trigger, content });
    });

    const accordion = {
      container,
      items: accordionItems,
      triggers,
      collapseOthers
    };

    // Bind events
    triggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => this.handleClick(e, accordion));

      if (this.options.keyboardNav) {
        trigger.addEventListener('keydown', (e) => this.handleKeyboard(e, accordion));
      }
    });

    this.accordions.push(accordion);
  }

  /**
   * Handle trigger click
   *
   * @param {Event} event - Click event
   * @param {Object} accordion - Accordion instance
   */
  handleClick(event, accordion) {
    const trigger = event.currentTarget;
    this.togglePanel(trigger, accordion);
  }

  /**
   * Toggle accordion panel
   *
   * @param {HTMLElement} trigger - Trigger element
   * @param {Object} accordion - Accordion instance
   */
  togglePanel(trigger, accordion) {
    const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
    const accordionItem = accordion.items.find(item => item.trigger === trigger);

    if (!accordionItem) return;

    const { item, content } = accordionItem;

    // Close other panels if collapseOthers is true
    if (accordion.collapseOthers && !isExpanded) {
      this.closeOtherPanels(trigger, accordion);
    }

    // Toggle current panel
    trigger.setAttribute('aria-expanded', String(!isExpanded));
    content.hidden = isExpanded;

    // Dispatch custom event
    const eventName = isExpanded ? 'accordion:close' : 'accordion:open';
    this.dispatchEvent(accordion.container, eventName, { trigger, content, item });
  }

  /**
   * Close other panels in accordion
   *
   * @param {HTMLElement} activeTrigger - Currently clicked trigger
   * @param {Object} accordion - Accordion instance
   */
  closeOtherPanels(activeTrigger, accordion) {
    accordion.items.forEach(({ trigger, content }) => {
      if (trigger !== activeTrigger) {
        trigger.setAttribute('aria-expanded', 'false');
        content.hidden = true;
      }
    });
  }

  /**
   * Handle keyboard navigation
   *
   * @param {KeyboardEvent} event - Keyboard event
   * @param {Object} accordion - Accordion instance
   */
  handleKeyboard(event, accordion) {
    const trigger = event.currentTarget;
    const currentIndex = accordion.triggers.indexOf(trigger);

    switch (event.key) {
      case 'ArrowDown':
        event.preventDefault();
        this.focusTrigger(accordion, currentIndex + 1);
        break;

      case 'ArrowUp':
        event.preventDefault();
        this.focusTrigger(accordion, currentIndex - 1);
        break;

      case 'Home':
        event.preventDefault();
        this.focusTrigger(accordion, 0);
        break;

      case 'End':
        event.preventDefault();
        this.focusTrigger(accordion, accordion.triggers.length - 1);
        break;
    }
  }

  /**
   * Focus trigger by index with wrapping
   *
   * @param {Object} accordion - Accordion instance
   * @param {number} index - Trigger index
   */
  focusTrigger(accordion, index) {
    const length = accordion.triggers.length;
    const wrappedIndex = ((index % length) + length) % length;
    accordion.triggers[wrappedIndex].focus();
  }

  /**
   * Dispatch custom event
   *
   * @param {HTMLElement} element - Element to dispatch event from
   * @param {string} eventName - Event name
   * @param {Object} detail - Event detail data
   */
  dispatchEvent(element, eventName, detail = {}) {
    const event = new CustomEvent(eventName, {
      bubbles: true,
      detail
    });
    element.dispatchEvent(event);
  }

  /**
   * Open specific panel by content ID
   *
   * @param {string} contentId - Content ID to open
   */
  openPanel(contentId) {
    const content = document.getElementById(contentId);
    if (!content) return;

    const trigger = document.querySelector(`[aria-controls="${contentId}"]`);

    if (trigger) {
      const accordion = this.accordions.find(acc =>
        acc.container.contains(trigger)
      );
      if (accordion && trigger.getAttribute('aria-expanded') !== 'true') {
        this.togglePanel(trigger, accordion);
      }
    }
  }

  /**
   * Close specific panel by content ID
   *
   * @param {string} contentId - Content ID to close
   */
  closePanel(contentId) {
    const content = document.getElementById(contentId);
    if (!content) return;

    const trigger = document.querySelector(`[aria-controls="${contentId}"]`);

    if (trigger && trigger.getAttribute('aria-expanded') === 'true') {
      const accordion = this.accordions.find(acc =>
        acc.container.contains(trigger)
      );
      if (accordion) {
        this.togglePanel(trigger, accordion);
      }
    }
  }

  /**
   * Toggle specific panel by content ID
   *
   * @param {string} contentId - Content ID to toggle
   */
  togglePanelById(contentId) {
    const content = document.getElementById(contentId);
    if (!content) return;

    const trigger = document.querySelector(`[aria-controls="${contentId}"]`);

    if (trigger) {
      const accordion = this.accordions.find(acc =>
        acc.container.contains(trigger)
      );
      if (accordion) {
        this.togglePanel(trigger, accordion);
      }
    }
  }

  /**
   * Open all panels in accordion
   *
   * @param {HTMLElement|string} accordion - Accordion element or selector
   */
  openAll(accordion) {
    const container = typeof accordion === 'string'
      ? document.querySelector(accordion)
      : accordion;

    const accordionInstance = this.accordions.find(acc => acc.container === container);

    if (accordionInstance) {
      accordionInstance.items.forEach(({ trigger }) => {
        if (trigger.getAttribute('aria-expanded') !== 'true') {
          this.togglePanel(trigger, accordionInstance);
        }
      });
    }
  }

  /**
   * Close all panels in accordion
   *
   * @param {HTMLElement|string} accordion - Accordion element or selector
   */
  closeAll(accordion) {
    const container = typeof accordion === 'string'
      ? document.querySelector(accordion)
      : accordion;

    const accordionInstance = this.accordions.find(acc => acc.container === container);

    if (accordionInstance) {
      accordionInstance.items.forEach(({ trigger }) => {
        if (trigger.getAttribute('aria-expanded') === 'true') {
          this.togglePanel(trigger, accordionInstance);
        }
      });
    }
  }

  /**
   * Get accordion state
   *
   * @param {HTMLElement|string} accordion - Accordion element or selector
   * @returns {Array} Array of panel states
   */
  getState(accordion) {
    const container = typeof accordion === 'string'
      ? document.querySelector(accordion)
      : accordion;

    const accordionInstance = this.accordions.find(acc => acc.container === container);

    if (!accordionInstance) return [];

    return accordionInstance.items.map(({ trigger, content }) => ({
      id: content.id,
      isOpen: trigger.getAttribute('aria-expanded') === 'true'
    }));
  }

  /**
   * Refresh accordions after dynamic content change
   */
  refresh() {
    this.destroy();
    this.init();
    console.log('🔄 Accordions refreshed');
  }

  /**
   * Destroy all accordions
   */
  destroy() {
    this.accordions.forEach(accordion => {
      accordion.triggers.forEach(trigger => {
        // Remove event listeners by cloning
        const newTrigger = trigger.cloneNode(true);
        trigger.parentNode.replaceChild(newTrigger, trigger);

        // Remove ARIA attributes
        newTrigger.removeAttribute('aria-expanded');
        newTrigger.removeAttribute('aria-controls');
        newTrigger.removeAttribute('data-accordion-target');
      });

      accordion.items.forEach(({ content }) => {
        content.removeAttribute('role');
        content.removeAttribute('aria-labelledby');
        content.removeAttribute('hidden');
      });
    });

    this.accordions = [];
    console.log('🗑️ Accordions destroyed');
  }
}

export default AccordionManager;
