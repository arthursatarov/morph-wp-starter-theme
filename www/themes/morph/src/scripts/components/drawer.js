/**
 * Drawer Component
 *
 * Manages accessible off-canvas drawer/sidebar functionality
 *
 * @package Morph
 * @since 0.0.1
 */

class DrawerManager {
  /**
   * Constructor
   *
   * @param {Object} options - Configuration options
   * @param {string} options.drawerSelector - Drawer element selector
   * @param {string} options.backdropSelector - Backdrop element selector
   * @param {string} options.targetAttr - Data attribute for trigger buttons
   * @param {string} options.toggleAttr - Data attribute for toggle buttons
   * @param {string} options.showAttr - Data attribute for show buttons
   * @param {string} options.hideAttr - Data attribute for hide buttons
   * @param {string} options.stateAttr - Data attribute for drawer state
   * @param {string} options.backdropAttr - Data attribute for backdrop behavior
   * @param {boolean} options.closeOnBackdrop - Close on backdrop click
   * @param {boolean} options.closeOnEscape - Close on Escape key
   * @param {boolean} options.lockScroll - Lock body scroll when open
   * @param {boolean} options.returnFocus - Return focus to trigger on close
   * @param {boolean} options.trapFocus - Trap focus within drawer (usually false for drawers)
   */
  constructor(options = {}) {
    this.options = {
      drawerSelector: '.drawer',
      backdropSelector: '.drawer__backdrop',
      targetAttr: 'data-drawer-target',
      toggleAttr: 'data-drawer-toggle',
      showAttr: 'data-drawer-show',
      hideAttr: 'data-drawer-hide',
      stateAttr: 'data-drawer-state',
      backdropAttr: 'data-drawer-backdrop',
      closeOnBackdrop: true,
      closeOnEscape: true,
      lockScroll: true,
      returnFocus: true,
      trapFocus: false, // Обычно для drawer не нужен жесткий focus trap
      ...options
    };

    this.drawers = new Map();
    this.activeDrawers = new Set();
    this.focusedElementBeforeDrawer = null;
  }

  /**
   * Initialize all drawers
   */
  init() {
    this.registerDrawers();
    this.bindEvents();

    console.log(`✅ Initialized ${this.drawers.size} drawer(s)`);
  }

  /**
   * Register all drawers in the DOM
   */
  registerDrawers() {
    const drawerElements = document.querySelectorAll(this.options.drawerSelector);

    drawerElements.forEach(drawer => {
      const id = drawer.id;

      if (!id) {
        console.warn('⚠️ Drawer missing ID attribute:', drawer);
        return;
      }

      // Set ARIA attributes (drawer не является dialog)
      drawer.setAttribute('aria-hidden', 'true');

      // Set initial state
      if (!drawer.hasAttribute(this.options.stateAttr)) {
        drawer.setAttribute(this.options.stateAttr, 'hidden');
      }

      // Warn if missing aria-label or aria-labelledby
      if (!drawer.hasAttribute('aria-label') && !drawer.hasAttribute('aria-labelledby')) {
        console.warn(`⚠️ Drawer "${id}" missing aria-label or aria-labelledby attribute`);
      }

      this.drawers.set(id, {
        element: drawer,
        id,
        isOpen: false
      });
    });
  }

  /**
   * Bind all event listeners
   */
  bindEvents() {
    // Target buttons (show drawer)
    document.addEventListener('click', (e) => {
      const targetBtn = e.target.closest(`[${this.options.targetAttr}]`);
      if (targetBtn) {
        e.preventDefault();
        const drawerId = targetBtn.getAttribute(this.options.targetAttr);
        this.show(drawerId, targetBtn);
      }
    });

    // Toggle buttons
    document.addEventListener('click', (e) => {
      const toggleBtn = e.target.closest(`[${this.options.toggleAttr}]`);
      if (toggleBtn) {
        e.preventDefault();
        const drawerId = toggleBtn.getAttribute(this.options.toggleAttr);
        this.toggle(drawerId, toggleBtn);
      }
    });

    // Show buttons
    document.addEventListener('click', (e) => {
      const showBtn = e.target.closest(`[${this.options.showAttr}]`);
      if (showBtn) {
        e.preventDefault();
        const drawerId = showBtn.getAttribute(this.options.showAttr);
        this.show(drawerId, showBtn);
      }
    });

    // Hide buttons
    document.addEventListener('click', (e) => {
      const hideBtn = e.target.closest(`[${this.options.hideAttr}]`);
      if (hideBtn) {
        e.preventDefault();
        const drawerId = hideBtn.getAttribute(this.options.hideAttr);
        this.hide(drawerId);
      }
    });

    // Backdrop click
    if (this.options.closeOnBackdrop) {
      document.addEventListener('click', (e) => {
        const backdrop = e.target.closest(this.options.backdropSelector);
        if (backdrop) {
          const drawer = backdrop.closest(this.options.drawerSelector);
          if (drawer && drawer.id) {
            const backdropBehavior = drawer.getAttribute(this.options.backdropAttr);
            if (backdropBehavior !== 'static') {
              e.preventDefault();
              this.hide(drawer.id);
            } else {
              // Shake effect for static backdrop
              this.shakeDrawer(drawer);
            }
          }
        }
      });
    }

    // Escape key
    if (this.options.closeOnEscape) {
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.activeDrawers.size > 0) {
          const lastDrawerId = Array.from(this.activeDrawers).pop();
          this.hide(lastDrawerId);
        }
      });
    }

    // Close on resize to desktop (optional, можно настроить breakpoint)
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        // Закрываем drawer если ширина экрана больше 768px (настраиваемо)
        if (window.innerWidth >= 768 && this.activeDrawers.size > 0) {
          this.hideAll();
        }
      }, 250);
    });
  }

  /**
   * Toggle drawer visibility
   *
   * @param {string} drawerId - Drawer ID to toggle
   * @param {HTMLElement} triggerElement - Element that triggered the action
   */
  toggle(drawerId, triggerElement = null) {
    const drawer = this.drawers.get(drawerId);

    if (!drawer) {
      console.warn(`⚠️ Drawer not found: ${drawerId}`);
      return;
    }

    drawer.isOpen ? this.hide(drawerId) : this.show(drawerId, triggerElement);
  }

  /**
   * Show drawer
   *
   * @param {string} drawerId - Drawer ID to show
   * @param {HTMLElement} triggerElement - Element that triggered the action
   */
  show(drawerId, triggerElement = null) {
    const drawer = this.drawers.get(drawerId);

    if (!drawer) {
      console.warn(`⚠️ Drawer not found: ${drawerId}`);
      return;
    }

    if (drawer.isOpen) return;

    // Store previously focused element
    if (this.options.returnFocus) {
      if (triggerElement) {
        this.focusedElementBeforeDrawer = triggerElement;
      } else if (!this.focusedElementBeforeDrawer) {
        this.focusedElementBeforeDrawer = document.activeElement;
      }
    }

    // Update trigger button aria-expanded
    if (triggerElement && triggerElement.hasAttribute('aria-expanded')) {
      triggerElement.setAttribute('aria-expanded', 'true');
    }

    // Show drawer
    drawer.element.setAttribute(this.options.stateAttr, 'open');
    drawer.element.setAttribute('aria-hidden', 'false');
    drawer.isOpen = true;

    this.activeDrawers.add(drawerId);

    // Lock body scroll
    if (this.options.lockScroll) {
      this.lockBodyScroll();
    }

    // Optional: set initial focus (soft, not trapped)
    if (this.options.trapFocus) {
      this.setInitialFocus(drawer.element);
    }

    // Dispatch custom event
    this.dispatchEvent(drawer.element, 'drawer:show', {
      drawerId,
      triggerElement
    });
  }

  /**
   * Hide drawer
   *
   * @param {string} drawerId - Drawer ID to hide
   */
  hide(drawerId) {
    const drawer = this.drawers.get(drawerId);

    if (!drawer) {
      console.warn(`⚠️ Drawer not found: ${drawerId}`);
      return;
    }

    if (!drawer.isOpen) return;

    // Hide drawer
    drawer.element.setAttribute(this.options.stateAttr, 'hidden');
    drawer.element.setAttribute('aria-hidden', 'true');
    drawer.isOpen = false;

    this.activeDrawers.delete(drawerId);

    // Update trigger button aria-expanded
    const triggerButton = document.querySelector(
      `[${this.options.targetAttr}="${drawerId}"], [${this.options.toggleAttr}="${drawerId}"]`
    );
    if (triggerButton && triggerButton.hasAttribute('aria-expanded')) {
      triggerButton.setAttribute('aria-expanded', 'false');
    }

    // Unlock body scroll if no drawers are open
    if (this.options.lockScroll && this.activeDrawers.size === 0) {
      this.unlockBodyScroll();
    }

    // Return focus to trigger element
    if (this.options.returnFocus &&
        this.focusedElementBeforeDrawer &&
        this.activeDrawers.size === 0) {
      this.focusedElementBeforeDrawer.focus();
      this.focusedElementBeforeDrawer = null;
    }

    // Dispatch custom event
    this.dispatchEvent(drawer.element, 'drawer:hide', { drawerId });
  }

  /**
   * Hide all open drawers
   */
  hideAll() {
    const drawersToClose = Array.from(this.activeDrawers);
    drawersToClose.forEach(drawerId => {
      this.hide(drawerId);
    });
  }

  /**
   * Set initial focus (soft, not trapped)
   *
   * @param {HTMLElement} drawerElement - Drawer element
   */
  setInitialFocus(drawerElement) {
    const firstFocusable = drawerElement.querySelector(
      'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );

    if (firstFocusable) {
      firstFocusable.focus();
    }
  }

  /**
   * Shake drawer to indicate it can't be closed
   *
   * @param {HTMLElement} drawerElement - Drawer element to shake
   */
  shakeDrawer(drawerElement) {
    drawerElement.classList.add('drawer--shake');

    setTimeout(() => {
      drawerElement.classList.remove('drawer--shake');
    }, 500);
  }

  /**
   * Lock body scroll
   */
  lockBodyScroll() {
    const scrollY = window.scrollY;

    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollY}px`;
    document.body.style.width = '100%';
  }

  /**
   * Unlock body scroll
   */
  unlockBodyScroll() {
    const scrollY = document.body.style.top;

    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width = '';

    if (scrollY) {
      window.scrollTo(0, parseInt(scrollY || '0') * -1);
    }
  }

  /**
   * Check if drawer is open
   *
   * @param {string} drawerId - Drawer ID to check
   * @returns {boolean} True if drawer is open
   */
  isOpen(drawerId) {
    const drawer = this.drawers.get(drawerId);
    return drawer ? drawer.isOpen : false;
  }

  /**
   * Get all open drawers
   *
   * @returns {Array} Array of open drawer IDs
   */
  getOpenDrawers() {
    return Array.from(this.activeDrawers);
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
   * Refresh drawers after dynamic content change
   */
  refresh() {
    this.destroy();
    this.init();
    console.log('🔄 Drawers refreshed');
  }

  /**
   * Destroy all drawers
   */
  destroy() {
    this.hideAll();
    this.drawers.clear();
    this.activeDrawers.clear();
    this.focusedElementBeforeDrawer = null;

    console.log('🗑️ Drawers destroyed');
  }
}

export default DrawerManager;
