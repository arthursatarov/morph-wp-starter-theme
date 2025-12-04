/**
 * Accordion Component
 *
 * Simple accordion initialization with keyboard navigation and accessibility
 *
 * @package Morph
 * @since 0.0.1
 */

/**
 * Initialize all accordions
 */
export function initAccordions() {
	const containers = document.querySelectorAll('.accordion');

	containers.forEach((container, containerIndex) => {
		// Get accordion mode: 'single' or 'multiple'
		const mode = container.dataset.accordionType || 'multiple';
		const collapseOthers = mode === 'single';

		const items = container.querySelectorAll('.accordion__item');

		if (items.length === 0) {
			console.warn('⚠️ No accordion items found in:', container);
			return;
		}

		const triggers = [];

		items.forEach((item, index) => {
			const trigger = item.querySelector('.accordion__item-trigger');
			const content = item.querySelector('.accordion__item-content');

			if (!trigger || !content) {
				console.warn('⚠️ Incomplete accordion item:', item);
				return;
			}

			// Get initial state from aria-expanded
			const ariaExpanded = trigger.getAttribute('aria-expanded');
			const isInitiallyOpen = ariaExpanded === 'true';

			// Generate unique IDs
			const triggerId = trigger.id || `accordion-trigger-${containerIndex}-${index}`;
			const contentId = content.id || `accordion-content-${containerIndex}-${index}`;

			trigger.id = triggerId;
			content.id = contentId;

			// Set button type if not present
			if (!trigger.hasAttribute('type') && trigger.tagName === 'BUTTON') {
				trigger.setAttribute('type', 'button');
			}

			// Set ARIA attributes
			trigger.setAttribute('aria-expanded', String(isInitiallyOpen));
			trigger.setAttribute('aria-controls', contentId);
			content.setAttribute('role', 'region');
			content.setAttribute('aria-labelledby', triggerId);
			content.hidden = !isInitiallyOpen;

			triggers.push(trigger);
		});

		// Toggle panel
		const togglePanel = (trigger) => {
			const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
			const content = document.getElementById(trigger.getAttribute('aria-controls'));
			const item = trigger.closest('.accordion__item');

			if (!content) return;

			// Close other panels if collapseOthers is true
			if (collapseOthers && !isExpanded) {
				triggers.forEach((t) => {
					if (t !== trigger) {
						const c = document.getElementById(t.getAttribute('aria-controls'));
						t.setAttribute('aria-expanded', 'false');
						if (c) c.hidden = true;
					}
				});
			}

			// Toggle current panel
			trigger.setAttribute('aria-expanded', String(!isExpanded));
			content.hidden = isExpanded;

			// Dispatch custom event
			const eventName = isExpanded ? 'accordion:close' : 'accordion:open';
			dispatchEvent(container, eventName, { trigger, content, item });
		};

		// Handle click
		triggers.forEach((trigger) => {
			trigger.addEventListener('click', () => {
				togglePanel(trigger);
			});
		});

		// Handle keyboard navigation
		triggers.forEach((trigger, index) => {
			trigger.addEventListener('keydown', (e) => {
				let targetIndex;

				switch (e.key) {
					case 'ArrowDown':
						e.preventDefault();
						targetIndex = index + 1;
						if (targetIndex >= triggers.length) {
							targetIndex = 0;
						}
						break;

					case 'ArrowUp':
						e.preventDefault();
						targetIndex = index - 1;
						if (targetIndex < 0) {
							targetIndex = triggers.length - 1;
						}
						break;

					case 'Home':
						e.preventDefault();
						targetIndex = 0;
						break;

					case 'End':
						e.preventDefault();
						targetIndex = triggers.length - 1;
						break;

					default:
						return;
				}

				if (targetIndex !== undefined) {
					triggers[targetIndex].focus();
				}
			});
		});
	});

	console.log(`✅ Initialized ${containers.length} accordion(s)`);
}

/**
 * Dispatch custom event
 *
 * @param {HTMLElement} element - Element to dispatch event from
 * @param {string} eventName - Event name
 * @param {Object} detail - Event detail data
 */
function dispatchEvent(element, eventName, detail = {}) {
	const event = new CustomEvent(eventName, {
		bubbles: true,
		detail,
	});
	element.dispatchEvent(event);
}
