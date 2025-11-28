/**
 * Tabs Component
 *
 * Manages accessible tabs functionality with keyboard navigation
 *
 * @package Morph
 * @since 0.0.1
 */

class TabsManager {
  /**
   * Constructor
   *
   * @param {Object} options - Configuration options
   * @param {string} options.selector - Tabs container selector
   * @param {string} options.listSelector - Tabs list selector
   * @param {string} options.triggerSelector - Tab trigger selector
   * @param {string} options.panelSelector - Tab panel selector
   * @param {boolean} options.keyboardNav - Enable keyboard navigation
   */
  constructor(options = {}) {
    this.options = {
      selector: '.tabs',
      listSelector: '.tabs__list',
      triggerSelector: '.tabs__trigger',
      panelSelector: '.tabs__panel',
      keyboardNav: true,
      ...options
    };

    this.tabGroups = [];
  }

  /**
   * Initialize all tabs
   */
  init() {
    const containers = document.querySelectorAll(this.options.selector);

    containers.forEach(container => {
      this.initTabs(container);
    });

    console.log(`✅ Initialized ${this.tabGroups.length} tabs group(s)`);
  }

  /**
   * Initialize single tabs group
   *
   * @param {HTMLElement} container - Tabs container element
   */
  initTabs(container) {
    const tabList = container.querySelector(this.options.listSelector);
    const triggers = Array.from(container.querySelectorAll(this.options.triggerSelector));
    const panels = Array.from(container.querySelectorAll(this.options.panelSelector));

    if (triggers.length === 0 || panels.length === 0) {
      console.warn('⚠️ No tabs or panels found in:', container);
      return;
    }

    if (triggers.length !== panels.length) {
      console.warn('⚠️ Mismatch between tabs and panels count in:', container);
    }

    const tabItems = [];

    triggers.forEach((trigger, index) => {
      const panel = panels[index];

      if (!panel) {
        console.warn('⚠️ No matching panel for trigger:', trigger);
        return;
      }

      // Get initial state from aria-selected
      const ariaSelected = trigger.getAttribute('aria-selected');
      const isInitiallyActive = ariaSelected === 'true';

      // Generate unique IDs if not present
      const triggerId = trigger.id || `tabs-trigger-${this.tabGroups.length}-${index}`;
      const panelId = panel.id || `tabs-panel-${this.tabGroups.length}-${index}`;

      trigger.id = triggerId;
      panel.id = panelId;

      // Set button type if not present
      if (!trigger.hasAttribute('type') && trigger.tagName === 'BUTTON') {
        trigger.setAttribute('type', 'button');
      }

      // Set ARIA attributes
      trigger.setAttribute('role', 'tab');
      trigger.setAttribute('aria-selected', String(isInitiallyActive));
      trigger.setAttribute('aria-controls', panelId);
      trigger.setAttribute('tabindex', isInitiallyActive ? '0' : '-1');

      panel.setAttribute('role', 'tabpanel');
      panel.setAttribute('aria-labelledby', triggerId);
      panel.hidden = !isInitiallyActive;

      tabItems.push({ trigger, panel });
    });

    // Ensure tablist has proper role
    if (tabList && !tabList.hasAttribute('role')) {
      tabList.setAttribute('role', 'tablist');
    }

    const tabGroup = {
      container,
      tabList,
      items: tabItems,
      triggers
    };

    // Bind events
    triggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => this.handleClick(e, tabGroup));

      if (this.options.keyboardNav) {
        trigger.addEventListener('keydown', (e) => this.handleKeyboard(e, tabGroup));
      }
    });

    this.tabGroups.push(tabGroup);

    // Activate first tab if none are active
    const hasActiveTab = tabItems.some(item =>
      item.trigger.getAttribute('aria-selected') === 'true'
    );

    if (!hasActiveTab && tabItems.length > 0) {
      this.activateTab(tabItems[0].trigger, tabGroup);
    }
  }

  /**
   * Handle trigger click
   *
   * @param {Event} event - Click event
   * @param {Object} tabGroup - Tabs group instance
   */
  handleClick(event, tabGroup) {
    const trigger = event.currentTarget;
    this.activateTab(trigger, tabGroup);
  }

  /**
   * Activate tab
   *
   * @param {HTMLElement} trigger - Trigger element to activate
   * @param {Object} tabGroup - Tabs group instance
   */
  activateTab(trigger, tabGroup) {
    const tabItem = tabGroup.items.find(item => item.trigger === trigger);

    if (!tabItem) return;

    const wasAlreadyActive = trigger.getAttribute('aria-selected') === 'true';

    // Deactivate all tabs
    tabGroup.items.forEach(({ trigger: t, panel: p }) => {
      t.setAttribute('aria-selected', 'false');
      t.setAttribute('tabindex', '-1');
      p.hidden = true;
    });

    // Activate selected tab
    trigger.setAttribute('aria-selected', 'true');
    trigger.setAttribute('tabindex', '0');
    tabItem.panel.hidden = false;

    // Dispatch custom event only if tab wasn't already active
    if (!wasAlreadyActive) {
      this.dispatchEvent(tabGroup.container, 'tabs:change', {
        trigger,
        panel: tabItem.panel,
        index: tabGroup.triggers.indexOf(trigger)
      });
    }
  }

  /**
   * Handle keyboard navigation
   *
   * @param {KeyboardEvent} event - Keyboard event
   * @param {Object} tabGroup - Tabs group instance
   */
  handleKeyboard(event, tabGroup) {
    const trigger = event.currentTarget;
    const currentIndex = tabGroup.triggers.indexOf(trigger);
    let targetIndex;

    switch (event.key) {
      case 'ArrowLeft':
        event.preventDefault();
        targetIndex = currentIndex - 1;
        if (targetIndex < 0) {
          targetIndex = tabGroup.triggers.length - 1;
        }
        break;

      case 'ArrowRight':
        event.preventDefault();
        targetIndex = currentIndex + 1;
        if (targetIndex >= tabGroup.triggers.length) {
          targetIndex = 0;
        }
        break;

      case 'Home':
        event.preventDefault();
        targetIndex = 0;
        break;

      case 'End':
        event.preventDefault();
        targetIndex = tabGroup.triggers.length - 1;
        break;

      default:
        return;
    }

    if (targetIndex !== undefined) {
      const targetTrigger = tabGroup.triggers[targetIndex];
      this.activateTab(targetTrigger, tabGroup);
      targetTrigger.focus();
    }
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
   * Activate tab by panel ID
   *
   * @param {string} panelId - Panel ID to activate
   */
  activateTabById(panelId) {
    const panel = document.getElementById(panelId);
    if (!panel) return;

    const trigger = document.querySelector(`[aria-controls="${panelId}"]`);

    if (trigger) {
      const tabGroup = this.tabGroups.find(group =>
        group.container.contains(trigger)
      );
      if (tabGroup) {
        this.activateTab(trigger, tabGroup);
      }
    }
  }

  /**
   * Activate tab by index
   *
   * @param {HTMLElement|string} tabsContainer - Tabs container element or selector
   * @param {number} index - Tab index to activate
   */
  activateTabByIndex(tabsContainer, index) {
    const container = typeof tabsContainer === 'string'
      ? document.querySelector(tabsContainer)
      : tabsContainer;

    const tabGroup = this.tabGroups.find(group => group.container === container);

    if (tabGroup && tabGroup.triggers[index]) {
      this.activateTab(tabGroup.triggers[index], tabGroup);
    }
  }

  /**
   * Get active tab index
   *
   * @param {HTMLElement|string} tabsContainer - Tabs container element or selector
   * @returns {number} Active tab index or -1 if not found
   */
  getActiveIndex(tabsContainer) {
    const container = typeof tabsContainer === 'string'
      ? document.querySelector(tabsContainer)
      : tabsContainer;

    const tabGroup = this.tabGroups.find(group => group.container === container);

    if (!tabGroup) return -1;

    return tabGroup.triggers.findIndex(trigger =>
      trigger.getAttribute('aria-selected') === 'true'
    );
  }

  /**
   * Get tabs state
   *
   * @param {HTMLElement|string} tabsContainer - Tabs container element or selector
   * @returns {Array} Array of tab states
   */
  getState(tabsContainer) {
    const container = typeof tabsContainer === 'string'
      ? document.querySelector(tabsContainer)
      : tabsContainer;

    const tabGroup = this.tabGroups.find(group => group.container === container);

    if (!tabGroup) return [];

    return tabGroup.items.map(({ trigger, panel }) => ({
      id: panel.id,
      triggerId: trigger.id,
      isActive: trigger.getAttribute('aria-selected') === 'true'
    }));
  }

  /**
   * Refresh tabs after dynamic content change
   */
  refresh() {
    this.destroy();
    this.init();
    console.log('🔄 Tabs refreshed');
  }

  /**
   * Destroy all tabs
   */
  destroy() {
    this.tabGroups.forEach(tabGroup => {
      tabGroup.triggers.forEach(trigger => {
        // Remove event listeners by cloning
        const newTrigger = trigger.cloneNode(true);
        trigger.parentNode.replaceChild(newTrigger, trigger);

        // Remove ARIA attributes
        newTrigger.removeAttribute('aria-selected');
        newTrigger.removeAttribute('aria-controls');
        newTrigger.removeAttribute('tabindex');
      });

      tabGroup.items.forEach(({ panel }) => {
        panel.removeAttribute('aria-labelledby');
        panel.removeAttribute('hidden');
      });

      if (tabGroup.tabList) {
        tabGroup.tabList.removeAttribute('role');
      }
    });

    this.tabGroups = [];
    console.log('🗑️ Tabs destroyed');
  }
}

export default TabsManager;
