/**
 * Tooltip Manager
 * Управление tooltips на основе Popper.js
 *
 * @since 1.0.0
 */

import PopperManager from './popper-manager.js';

class TooltipManager extends PopperManager {
  constructor(options = {}) {
    super({
      triggerSelector: '[data-tooltip-target]',
      placement: 'bottom',
      offset: [0, 8],
      showEvents: ['mouseenter', 'focus'],
      hideEvents: ['mouseleave', 'blur'],
      ...options
    });
  }
}

export default TooltipManager;
