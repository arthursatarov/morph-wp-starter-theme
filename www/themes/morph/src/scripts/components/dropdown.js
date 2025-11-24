/**
 * Dropdown Manager
 * Управление dropdown меню на основе Popper.js
 *
 * @since 1.0.0
 */

import { createPopper } from '@popperjs/core';

class DropdownManager {
  /**
   * @param {Object} options - Настройки
   */
  constructor(options = {}) {
    this.options = {
      triggerSelector: '[data-dropdown-target]',
      placement: 'bottom-start',
      offset: [0, 8],
      ...options
    };

    this.instances = new Map();
  }

  /**
   * Инициализация всех dropdowns
   */
  init() {
    const triggers = document.querySelectorAll(this.options.triggerSelector);
    triggers.forEach(trigger => this.initDropdown(trigger));

    // Закрывать dropdown при клике вне
    document.addEventListener('click', (e) => {
      this.instances.forEach((instance, trigger) => {
        if (!trigger.contains(e.target) && !instance.target.contains(e.target)) {
          instance.hide();
        }
      });
    });

    return this;
  }

  /**
   * Инициализация отдельного dropdown
   */
  initDropdown(trigger) {
    if (trigger.disabled || trigger.hasAttribute('disabled')) {
      return;
    }

    const targetId = trigger.getAttribute('data-dropdown-target');
    if (!targetId) {
      console.warn('Dropdown trigger missing data-dropdown-target attribute:', trigger);
      return;
    }

    const target = document.getElementById(targetId);
    if (!target) {
      console.warn(`Dropdown element with id "${targetId}" not found`);
      return;
    }

    const placement = trigger.getAttribute('data-dropdown-placement') || this.options.placement;
    const offset = this.parseOffset(trigger.getAttribute('data-dropdown-offset')) || this.options.offset;

    // Создать Popper instance с настройками для dropdown
    const popperInstance = createPopper(trigger, target, {
      placement: placement,
      modifiers: [
        {
          name: 'offset',
          options: { offset }
        },
        {
          name: 'flip',
          enabled: false  // ← Отключить flip
        },
      ]
    });

    const show = () => {
      // Закрыть все другие dropdowns
      this.instances.forEach((instance) => {
        instance.hide();
      });

      target.setAttribute('data-show', '');
      popperInstance.update();
    };

    const hide = () => {
      target.removeAttribute('data-show');
    };

    const toggle = () => {
      if (target.hasAttribute('data-show')) {
        hide();
      } else {
        show();
      }
    };

    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      toggle();
    });

    this.instances.set(trigger, {
      popper: popperInstance,
      target: target,
      show: show,
      hide: hide,
      toggle: toggle
    });
  }

  /**
   * Парсинг offset из строки
   */
  parseOffset(offsetString) {
    if (!offsetString) return null;
    const parts = offsetString.split(',').map(v => parseInt(v.trim()));
    return parts.length === 2 ? parts : null;
  }

  /**
   * Уничтожить dropdown
   */
  destroy(trigger) {
    const instance = this.instances.get(trigger);
    if (!instance) return;

    trigger.removeEventListener('click', instance.toggle);
    instance.popper.destroy();
    this.instances.delete(trigger);
  }

  /**
   * Уничтожить все
   */
  destroyAll() {
    this.instances.forEach((_, trigger) => this.destroy(trigger));
  }

  /**
   * Обновить
   */
  refresh() {
    this.destroyAll();
    this.init();
  }

  /**
   * Закрыть все dropdowns
   */
  closeAll() {
    this.instances.forEach((instance) => {
      instance.hide();
    });
  }
}

export default DropdownManager;

