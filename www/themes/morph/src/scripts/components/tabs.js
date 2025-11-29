/**
 * Tabs Component
 *
 * Simple tabs initialization with keyboard navigation and accessibility
 *
 * @package Morph
 * @since 0.0.1
 */

/**
 * Initialize all tabs
 */
export function initTabs() {
	const containers = document.querySelectorAll('.tabs');

	containers.forEach((container, containerIndex) => {
		const tabList = container.querySelector('.tabs__list');
		const triggers = Array.from(container.querySelectorAll('.tabs__trigger'));
		const panels = Array.from(container.querySelectorAll('.tabs__panel'));

		if (triggers.length === 0 || panels.length === 0) {
			console.warn('⚠️ No tabs or panels found in:', container);
			return;
		}

		if (triggers.length !== panels.length) {
			console.warn('⚠️ Mismatch between tabs and panels count in:', container);
		}

		// Ensure tablist has proper role
		if (tabList && !tabList.hasAttribute('role')) {
			tabList.setAttribute('role', 'tablist');
		}

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
			const triggerId = trigger.id || `tabs-trigger-${containerIndex}-${index}`;
			const panelId = panel.id || `tabs-panel-${containerIndex}-${index}`;

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
		});

		// Activate tab
		const activateTab = (trigger) => {
			const panel = document.getElementById(trigger.getAttribute('aria-controls'));
			if (!panel) return;

			const wasAlreadyActive = trigger.getAttribute('aria-selected') === 'true';

			// Deactivate all tabs in this group
			triggers.forEach((t) => {
				const p = document.getElementById(t.getAttribute('aria-controls'));
				t.setAttribute('aria-selected', 'false');
				t.setAttribute('tabindex', '-1');
				if (p) p.hidden = true;
			});

			// Activate selected tab
			trigger.setAttribute('aria-selected', 'true');
			trigger.setAttribute('tabindex', '0');
			panel.hidden = false;

			// Dispatch custom event only if tab wasn't already active
			if (!wasAlreadyActive) {
				dispatchEvent(container, 'tabs:change', {
					trigger,
					panel,
					index: triggers.indexOf(trigger),
				});
			}
		};

		// Handle click
		triggers.forEach((trigger) => {
			trigger.addEventListener('click', () => {
				activateTab(trigger);
			});
		});

		// Handle keyboard navigation
		triggers.forEach((trigger, index) => {
			trigger.addEventListener('keydown', (e) => {
				let targetIndex;

				switch (e.key) {
					case 'ArrowLeft':
						e.preventDefault();
						targetIndex = index - 1;
						if (targetIndex < 0) {
							targetIndex = triggers.length - 1;
						}
						break;

					case 'ArrowRight':
						e.preventDefault();
						targetIndex = index + 1;
						if (targetIndex >= triggers.length) {
							targetIndex = 0;
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
					const targetTrigger = triggers[targetIndex];
					activateTab(targetTrigger);
					targetTrigger.focus();
				}
			});
		});

		// Activate first tab if none are active
		const hasActiveTab = triggers.some((t) => t.getAttribute('aria-selected') === 'true');
		if (!hasActiveTab && triggers.length > 0) {
			activateTab(triggers[0]);
		}
	});

	console.log(`✅ Initialized ${containers.length} tabs group(s)`);
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
