/**
 * Dropdown Component
 *
 * Simple dropdown initialization with Popper.js
 *
 * @package Morph
 * @since 0.0.1
 */

import { createPopper } from '@popperjs/core';

/**
 * Initialize all dropdowns
 */
export function initDropdowns() {
	const triggers = document.querySelectorAll('[data-dropdown-target]');

	triggers.forEach((trigger) => {
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

		// Get placement and offset from data attributes or use defaults
		const placement = trigger.getAttribute('data-dropdown-placement') || 'bottom-start';
		const offsetAttr = trigger.getAttribute('data-dropdown-offset');
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
					name: 'flip',
					enabled: false,
				},
				{
					name: 'sameWidth',
					enabled: true,
					phase: 'beforeWrite',
					requires: ['computeStyles'],
					fn: ({ state }) => {
						state.styles.popper.minWidth = `${state.rects.reference.width}px`;
					},
					effect: ({ state }) => {
						state.elements.popper.style.minWidth = `${state.elements.reference.offsetWidth}px`;
					},
				},
			],
		});

		// Toggle dropdown
		trigger.addEventListener('click', (e) => {
			e.stopPropagation();

			// Close all other dropdowns
			document.querySelectorAll('[data-dropdown-target]').forEach((otherTrigger) => {
				if (otherTrigger !== trigger) {
					const otherId = otherTrigger.getAttribute('data-dropdown-target');
					const otherTarget = document.getElementById(otherId);
					if (otherTarget) {
						otherTarget.removeAttribute('data-show');
					}
				}
			});

			// Toggle current dropdown
			const isOpen = target.hasAttribute('data-show');
			if (isOpen) {
				target.removeAttribute('data-show');
			} else {
				target.setAttribute('data-show', '');
				popperInstance.update();
			}
		});
	});

	// Close all dropdowns on outside click
	document.addEventListener('click', (e) => {
		if (!e.target.closest('[data-dropdown-target]')) {
			document.querySelectorAll('[data-dropdown-target]').forEach((trigger) => {
				const targetId = trigger.getAttribute('data-dropdown-target');
				const target = document.getElementById(targetId);
				if (target) {
					target.removeAttribute('data-show');
				}
			});
		}
	});

	console.log(`✅ Initialized ${triggers.length} dropdown(s)`);
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
