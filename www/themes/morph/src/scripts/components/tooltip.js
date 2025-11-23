/**
 * Tooltip Manager
 * Управление существующими tooltip элементами через Popper.js
 *
 * @since 1.0.0
 */

import { createPopper } from '@popperjs/core';

class TooltipManager {
  /**
   * Инициализация Tooltip Manager
   *
   * @param {Object} options - Настройки
   * @param {string} options.triggerSelector - Селектор trigger элементов
   * @param {string} options.placement - Дефолтное расположение
   * @param {Array} options.offset - Отступ от элемента [skidding, distance]
   */
  constructor(options = {}) {
    this.options = {
      triggerSelector: '[data-tooltip-trigger]',
      placement: 'top',
      offset: [0, 8],
      ...options
    };

    this.instances = new Map();
  }

  /**
   * Инициализация всех tooltips
   */
  init() {
    const triggers = document.querySelectorAll(this.options.triggerSelector);
    triggers.forEach(trigger => this.initTooltip(trigger));
    return this;
  }

  /**
   * Инициализация отдельного tooltip
   *
   * @param {HTMLElement} trigger - Элемент-триггер
   */
  initTooltip(trigger) {
    // Пропустить disabled элементы
    if (trigger.disabled || trigger.hasAttribute('disabled')) {
      return;
    }

    // Получить ID tooltip элемента
    const tooltipId = trigger.getAttribute('data-tooltip-trigger');
    if (!tooltipId) {
      console.warn('Tooltip trigger missing data-tooltip-trigger attribute:', trigger);
      return;
    }

    // Найти tooltip элемент
    const tooltip = document.getElementById(tooltipId);
    if (!tooltip) {
      console.warn(`Tooltip element with id "${tooltipId}" not found for trigger:`, trigger);
      return;
    }

    // Получить настройки из data-атрибутов
    const placement = trigger.getAttribute('data-tooltip-placement') || this.options.placement;
    const offset = this.parseOffset(trigger.getAttribute('data-tooltip-offset')) || this.options.offset;

    // Создать Popper instance
    const popperInstance = createPopper(trigger, tooltip, {
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

    // Show/Hide функции
    const show = () => {
      tooltip.setAttribute('data-show', '');
      popperInstance.update();
    };

    const hide = () => {
      tooltip.removeAttribute('data-show');
    };

    // Event listeners
    const showEvents = ['mouseenter', 'focus'];
    const hideEvents = ['mouseleave', 'blur'];

    showEvents.forEach(event => trigger.addEventListener(event, show));
    hideEvents.forEach(event => trigger.addEventListener(event, hide));

    // Сохранить instance
    this.instances.set(trigger, {
      popper: popperInstance,
      tooltip: tooltip,
      show: show,
      hide: hide,
      showEvents: showEvents,
      hideEvents: hideEvents
    });
  }

  /**
   * Парсинг offset из строки
   *
   * @param {string} offsetString - Строка типа "0, 16"
   * @returns {Array|null}
   */
  parseOffset(offsetString) {
    if (!offsetString) return null;
    const parts = offsetString.split(',').map(v => parseInt(v.trim()));
    return parts.length === 2 ? parts : null;
  }

  /**
   * Уничтожить конкретный tooltip
   *
   * @param {HTMLElement} trigger - Элемент-триггер
   */
  destroy(trigger) {
    const instance = this.instances.get(trigger);
    if (!instance) return;

    // Удалить event listeners
    instance.showEvents.forEach(event => {
      trigger.removeEventListener(event, instance.show);
    });
    instance.hideEvents.forEach(event => {
      trigger.removeEventListener(event, instance.hide);
    });

    // Уничтожить Popper
    instance.popper.destroy();

    // Удалить из Map
    this.instances.delete(trigger);
  }

  /**
   * Уничтожить все tooltips
   */
  destroyAll() {
    this.instances.forEach((_, trigger) => this.destroy(trigger));
  }

  /**
   * Обновить tooltips (например, после AJAX)
   */
  refresh() {
    this.destroyAll();
    this.init();
  }

  /**
   * Показать конкретный tooltip программно
   *
   * @param {HTMLElement} trigger - Элемент-триггер
   */
  show(trigger) {
    const instance = this.instances.get(trigger);
    if (instance) instance.show();
  }

  /**
   * Скрыть конкретный tooltip программно
   *
   * @param {HTMLElement} trigger - Элемент-триггер
   */
  hide(trigger) {
    const instance = this.instances.get(trigger);
    if (instance) instance.hide();
  }
}

export default TooltipManager;
