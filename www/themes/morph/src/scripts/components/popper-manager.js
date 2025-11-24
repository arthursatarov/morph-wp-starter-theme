/**
 * Popper Manager
 * Базовый класс для компонентов на основе Popper.js
 *
 * @since 1.0.0
 */

import { createPopper } from '@popperjs/core';

class PopperManager {
  /**
   * @param {Object} options - Настройки
   * @param {string} options.triggerSelector - Селектор trigger элементов
   * @param {string} options.placement - Дефолтное расположение
   * @param {Array} options.offset - Отступ [skidding, distance]
   * @param {Array} options.showEvents - События для показа
   * @param {Array} options.hideEvents - События для скрытия
   */
  constructor(options = {}) {
    this.options = {
      triggerSelector: '[data-popper-trigger]',
      placement: 'bottom',
      offset: [0, 8],
      showEvents: ['click'],
      hideEvents: ['click'],
      ...options
    };

    this.instances = new Map();
  }

  /**
   * Инициализация всех элементов
   */
  init() {
    const triggers = document.querySelectorAll(this.options.triggerSelector);
    triggers.forEach(trigger => this.initElement(trigger));
    return this;
  }

  /**
   * Инициализация отдельного элемента
   *
   * @param {HTMLElement} trigger - Элемент-триггер
   */
  initElement(trigger) {
    if (trigger.disabled || trigger.hasAttribute('disabled')) {
      return;
    }

    const targetId = trigger.getAttribute(this.options.triggerSelector.match(/\[(.*?)\]/)[1]);
    if (!targetId) {
      console.warn('Trigger missing target attribute:', trigger);
      return;
    }

    const target = document.getElementById(targetId);
    if (!target) {
      console.warn(`Target element with id "${targetId}" not found`);
      return;
    }

    const placement = trigger.getAttribute('data-popper-placement') || this.options.placement;
    const offset = this.parseOffset(trigger.getAttribute('data-popper-offset')) || this.options.offset;

    const popperInstance = createPopper(trigger, target, {
      placement: placement,
      modifiers: [
        {
          name: 'offset',
          options: { offset }
        },
        {
          name: 'preventOverflow',
          options: {
            padding: 8,
            boundary: 'clippingParents'
          }
        },
        {
          name: 'flip',
          options: {
            fallbackPlacements: ['top', 'bottom', 'left', 'right'],
            padding: 8
          }
        }
      ]
    });

    const show = () => {
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

    // Определить метод взаимодействия
    const interactionMethod = this.options.showEvents.includes('click') ? toggle : show;

    this.options.showEvents.forEach(event => {
      trigger.addEventListener(event, interactionMethod);
    });

    this.options.hideEvents.forEach(event => {
      if (event !== 'click') {
        trigger.addEventListener(event, hide);
      }
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
   * Уничтожить элемент
   */
  destroy(trigger) {
    const instance = this.instances.get(trigger);
    if (!instance) return;

    this.options.showEvents.forEach(event => {
      trigger.removeEventListener(event, instance.toggle || instance.show);
    });

    this.options.hideEvents.forEach(event => {
      trigger.removeEventListener(event, instance.hide);
    });

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
}

export default PopperManager;
