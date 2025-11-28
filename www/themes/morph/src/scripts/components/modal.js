/**
 * Modal Component
 *
 * Manages accessible modal functionality with full ARIA support
 *
 * @package Morph
 * @since 0.0.1
 */

class ModalManager {
  /**
   * Constructor
   *
   * @param {Object} options - Configuration options
   * @param {string} options.modalSelector - Modal element selector
   * @param {string} options.backdropSelector - Backdrop element selector
   * @param {string} options.targetAttr - Data attribute for trigger buttons
   * @param {string} options.toggleAttr - Data attribute for toggle buttons
   * @param {string} options.showAttr - Data attribute for show buttons
   * @param {string} options.hideAttr - Data attribute for hide buttons
   * @param {string} options.stateAttr - Data attribute for modal state
   * @param {string} options.backdropAttr - Data attribute for backdrop behavior
   * @param {boolean} options.closeOnBackdrop - Close on backdrop click
   * @param {boolean} options.closeOnEscape - Close on Escape key
   * @param {boolean} options.lockScroll - Lock body scroll when open
   * @param {boolean} options.returnFocus - Return focus to trigger on close
   */
  constructor(options = {}) {
    this.options = {
      modalSelector: '.modal',
      backdropSelector: '.modal__backdrop',
      targetAttr: 'data-modal-target',
      toggleAttr: 'data-modal-toggle',
      showAttr: 'data-modal-show',
      hideAttr: 'data-modal-hide',
      stateAttr: 'data-modal-state',
      backdropAttr: 'data-modal-backdrop',
      closeOnBackdrop: true,
      closeOnEscape: true,
      lockScroll: true,
      returnFocus: true,
      ...options
    };

    this.modals = new Map();
    this.activeModals = new Set();
    this.focusedElementBeforeModal = null;
  }

  /**
   * Initialize all modals
   */
  init() {
    this.registerModals();
    this.bindEvents();

    console.log(`✅ Initialized ${this.modals.size} modal(s)`);
  }

  /**
   * Register all modals in the DOM
   */
  registerModals() {
    const modalElements = document.querySelectorAll(this.options.modalSelector);

    modalElements.forEach(modal => {
      const id = modal.id;

      if (!id) {
        console.warn('⚠️ Modal missing ID attribute:', modal);
        return;
      }

      // Set required ARIA attributes
      if (!modal.hasAttribute('role')) {
        modal.setAttribute('role', 'dialog');
      }
      if (!modal.hasAttribute('aria-modal')) {
        modal.setAttribute('aria-modal', 'true');
      }
      modal.setAttribute('aria-hidden', 'true');

      // Set initial state
      if (!modal.hasAttribute(this.options.stateAttr)) {
        modal.setAttribute(this.options.stateAttr, 'hidden');
      }

      // Warn if missing aria-labelledby
      if (!modal.hasAttribute('aria-labelledby')) {
        console.warn(`⚠️ Modal "${id}" missing aria-labelledby attribute`);
      }

      this.modals.set(id, {
        element: modal,
        id,
        isOpen: false
      });
    });
  }

  /**
   * Bind all event listeners
   */
  bindEvents() {
    // Target buttons (show modal)
    document.addEventListener('click', (e) => {
      const targetBtn = e.target.closest(`[${this.options.targetAttr}]`);
      if (targetBtn) {
        e.preventDefault();
        const modalId = targetBtn.getAttribute(this.options.targetAttr);
        this.show(modalId, targetBtn);
      }
    });

    // Toggle buttons
    document.addEventListener('click', (e) => {
      const toggleBtn = e.target.closest(`[${this.options.toggleAttr}]`);
      if (toggleBtn) {
        e.preventDefault();
        const modalId = toggleBtn.getAttribute(this.options.toggleAttr);
        this.toggle(modalId, toggleBtn);
      }
    });

    // Show buttons
    document.addEventListener('click', (e) => {
      const showBtn = e.target.closest(`[${this.options.showAttr}]`);
      if (showBtn) {
        e.preventDefault();
        const modalId = showBtn.getAttribute(this.options.showAttr);
        this.show(modalId, showBtn);
      }
    });

    // Hide buttons
    document.addEventListener('click', (e) => {
      const hideBtn = e.target.closest(`[${this.options.hideAttr}]`);
      if (hideBtn) {
        e.preventDefault();
        const modalId = hideBtn.getAttribute(this.options.hideAttr);
        this.hide(modalId);
      }
    });

    // Backdrop click
    if (this.options.closeOnBackdrop) {
      document.addEventListener('click', (e) => {
        // Check if click is on backdrop element
        const backdrop = e.target.closest(this.options.backdropSelector);
        if (backdrop) {
          // Find parent modal
          const modal = backdrop.closest(this.options.modalSelector);
          if (modal && modal.id) {
            // Check if backdrop is static
            const backdropBehavior = modal.getAttribute(this.options.backdropAttr);
            if (backdropBehavior !== 'static') {
              e.preventDefault();
              this.hide(modal.id);
            }
          }
        }
      });
    }

    // Escape key
    if (this.options.closeOnEscape) {
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.activeModals.size > 0) {
          // Close the most recently opened modal
          const lastModalId = Array.from(this.activeModals).pop();
          this.hide(lastModalId);
        }
      });
    }
  }

  /**
   * Toggle modal visibility
   *
   * @param {string} modalId - Modal ID to toggle
   * @param {HTMLElement} triggerElement - Element that triggered the action
   */
  toggle(modalId, triggerElement = null) {
    const modal = this.modals.get(modalId);

    if (!modal) {
      console.warn(`⚠️ Modal not found: ${modalId}`);
      return;
    }

    modal.isOpen ? this.hide(modalId) : this.show(modalId, triggerElement);
  }

  /**
   * Show modal
   *
   * @param {string} modalId - Modal ID to show
   * @param {HTMLElement} triggerElement - Element that triggered the action
   */
  show(modalId, triggerElement = null) {
    const modal = this.modals.get(modalId);

    if (!modal) {
      console.warn(`⚠️ Modal not found: ${modalId}`);
      return;
    }

    if (modal.isOpen) return;

    // Store previously focused element for return focus
    if (this.options.returnFocus) {
      if (triggerElement) {
        this.focusedElementBeforeModal = triggerElement;
      } else if (!this.focusedElementBeforeModal) {
        this.focusedElementBeforeModal = document.activeElement;
      }
    }

    // Show modal
    modal.element.setAttribute(this.options.stateAttr, 'open');
    modal.element.setAttribute('aria-hidden', 'false');
    modal.isOpen = true;

    this.activeModals.add(modalId);

    // Lock body scroll
    if (this.options.lockScroll) {
      this.lockBodyScroll();
    }

    // Set focus trap and move focus to modal
    this.setupFocusTrap(modal.element);

    // Dispatch custom event
    this.dispatchEvent(modal.element, 'modal:show', {
      modalId,
      triggerElement
    });
  }

  /**
   * Hide modal
   *
   * @param {string} modalId - Modal ID to hide
   */
  hide(modalId) {
    const modal = this.modals.get(modalId);

    if (!modal) {
      console.warn(`⚠️ Modal not found: ${modalId}`);
      return;
    }

    if (!modal.isOpen) return;

    // Hide modal
    modal.element.setAttribute(this.options.stateAttr, 'hidden');
    modal.element.setAttribute('aria-hidden', 'true');
    modal.isOpen = false;

    this.activeModals.delete(modalId);

    // Unlock body scroll if no modals are open
    if (this.options.lockScroll && this.activeModals.size === 0) {
      this.unlockBodyScroll();
    }

    // Return focus to previously focused element
    if (this.options.returnFocus &&
        this.focusedElementBeforeModal &&
        this.activeModals.size === 0) {
      this.focusedElementBeforeModal.focus();
      this.focusedElementBeforeModal = null;
    }

    // Dispatch custom event
    this.dispatchEvent(modal.element, 'modal:hide', { modalId });
  }

  /**
   * Hide all open modals
   */
  hideAll() {
    // Create array copy to avoid modification during iteration
    const modalsToClose = Array.from(this.activeModals);
    modalsToClose.forEach(modalId => {
      this.hide(modalId);
    });
  }

  /**
   * Setup focus trap for modal
   *
   * @param {HTMLElement} modalElement - Modal element
   */
  setupFocusTrap(modalElement) {
    const focusableSelectors = [
      'a[href]',
      'button:not([disabled])',
      'textarea:not([disabled])',
      'input:not([disabled])',
      'select:not([disabled])',
      '[tabindex]:not([tabindex="-1"])'
    ].join(', ');

    const focusableElements = modalElement.querySelectorAll(focusableSelectors);

    if (focusableElements.length === 0) {
      console.warn('⚠️ No focusable elements in modal');
      return;
    }

    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];

    // Focus first element
    firstFocusable.focus();

    // Trap focus within modal
    const handleTabKey = (e) => {
      if (e.key !== 'Tab') return;

      // Shift + Tab
      if (e.shiftKey) {
        if (document.activeElement === firstFocusable) {
          e.preventDefault();
          lastFocusable.focus();
        }
      }
      // Tab
      else {
        if (document.activeElement === lastFocusable) {
          e.preventDefault();
          firstFocusable.focus();
        }
      }
    };

    // Remove old listener if exists
    modalElement.removeEventListener('keydown', handleTabKey);
    // Add new listener
    modalElement.addEventListener('keydown', handleTabKey);
  }

  /**
   * Lock body scroll
   */
  lockBodyScroll() {
    // Store current scroll position
    const scrollY = window.scrollY;

    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollY}px`;
    document.body.style.width = '100%';
  }

  /**
   * Unlock body scroll
   */
  unlockBodyScroll() {
    // Restore scroll position
    const scrollY = document.body.style.top;

    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';

    if (scrollY) {
      window.scrollTo(0, parseInt(scrollY || '0') * -1);
    }
  }

  /**
   * Check if modal is open
   *
   * @param {string} modalId - Modal ID to check
   * @returns {boolean} True if modal is open
   */
  isOpen(modalId) {
    const modal = this.modals.get(modalId);
    return modal ? modal.isOpen : false;
  }

  /**
   * Get all open modals
   *
   * @returns {Array} Array of open modal IDs
   */
  getOpenModals() {
    return Array.from(this.activeModals);
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
   * Refresh modals after dynamic content change
   */
  refresh() {
    this.destroy();
    this.init();
    console.log('🔄 Modals refreshed');
  }

  /**
   * Destroy all modals
   */
  destroy() {
    // Hide all open modals
    this.hideAll();

    // Clear maps and sets
    this.modals.clear();
    this.activeModals.clear();
    this.focusedElementBeforeModal = null;

    console.log('🗑️ Modals destroyed');
  }
}

export default ModalManager;
