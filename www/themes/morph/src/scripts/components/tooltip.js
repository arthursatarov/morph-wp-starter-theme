/**
 * Tooltip Component
 *
 * Simple tooltip initialization with Popper.js
 *
 * @package Morph
 * @since 0.0.1
 */

import { createPopper } from '@popperjs/core';

/**
 * Initialize all tooltips
 */
export function initTooltips() {
	const triggers = document.querySelectorAll('[data-tooltip-target]');

	triggers.forEach((trigger) => {
		if (trigger.disabled || trigger.hasAttribute('disabled')) {
			return;
		}

		const targetId = trigger.getAttribute('data-tooltip-target');
		if (!targetId) {
			console.warn('Tooltip trigger missing data-tooltip-target attribute:', trigger);
			return;
		}

		const target = document.getElementById(targetId);
		if (!target) {
			console.warn(`Tooltip element with id "${targetId}" not found`);
			return;
		}

		// Get placement and offset from data attributes or use defaults
		const placement = trigger.getAttribute('data-tooltip-placement') || 'top';
		const offsetAttr = trigger.getAttribute('data-tooltip-offset');
		const offset = offsetAttr ? parseOffset(offsetAttr) : [0, 8];

		// Create Popper instance
		const popperInstance = createPopper(trigger, target, {
			placement: placement,
			modifiers: [
				{
					name: 'offset',
					options: { offset },
				},
				{
					name: 'preventOverflow',
					options: {
						padding: 8,
						boundary: 'clippingParents',
					},
				},
				{
					name: 'flip',
					options: {
						fallbackPlacements: ['top', 'bottom', 'left', 'right'],
						padding: 8,
					},
				},
			],
		});

		// Show tooltip
		const show = () => {
			target.setAttribute('data-show', '');
			popperInstance.update();
		};

		// Hide tooltip
		const hide = () => {
			target.removeAttribute('data-show');
		};

		// Bind events
		trigger.addEventListener('mouseenter', show);
		trigger.addEventListener('focus', show);
		trigger.addEventListener('mouseleave', hide);
		trigger.addEventListener('blur', hide);
	});

	console.log(`✅ Initialized ${triggers.length} tooltip(s)`);
}

/**
 * Parse offset from string "x,y"
 *
 * @param {string} offsetString - Offset string like "0,8"
 * @returns {Array|null} Offset array [x, y] or null
 */
function parseOffset(offsetString) {
	if (!offsetString) return null;
	const parts = offsetString.split(',').map((v) => parseInt(v.trim()));
	return parts.length === 2 ? parts : null;
}
