/**
 * Drawer Component
 *
 * Simple off-canvas drawer/sidebar initialization with accessibility support
 *
 * @package Morph
 * @since 0.0.1
 */

/**
 * Initialize all drawers
 */
export function initDrawers() {
	const drawers = document.querySelectorAll('.drawer');
	let activeDrawers = [];
	let focusedElementBeforeDrawer = null;

	drawers.forEach((drawer) => {
		const id = drawer.id;

		if (!id) {
			console.warn('⚠️ Drawer missing ID attribute:', drawer);
			return;
		}

		// Set ARIA attributes
		drawer.setAttribute('aria-hidden', 'true');

		// Set initial state
		if (!drawer.hasAttribute('data-drawer-state')) {
			drawer.setAttribute('data-drawer-state', 'hidden');
		}

		// Warn if missing aria-label or aria-labelledby
		if (!drawer.hasAttribute('aria-label') && !drawer.hasAttribute('aria-labelledby')) {
			console.warn(`⚠️ Drawer "${id}" missing aria-label or aria-labelledby attribute`);
		}
	});

	// Show drawer
	const show = (drawerId, triggerElement = null) => {
		const drawer = document.getElementById(drawerId);
		if (!drawer) {
			console.warn(`⚠️ Drawer not found: ${drawerId}`);
			return;
		}

		const isAlreadyOpen = drawer.getAttribute('data-drawer-state') === 'open';
		if (isAlreadyOpen) return;

		// Store previously focused element
		if (triggerElement) {
			focusedElementBeforeDrawer = triggerElement;
		} else if (!focusedElementBeforeDrawer) {
			focusedElementBeforeDrawer = document.activeElement;
		}

		// Update trigger button aria-expanded
		if (triggerElement && triggerElement.hasAttribute('aria-expanded')) {
			triggerElement.setAttribute('aria-expanded', 'true');
		}

		// Show drawer
		drawer.setAttribute('data-drawer-state', 'open');
		drawer.setAttribute('aria-hidden', 'false');
		activeDrawers.push(drawerId);

		// Lock body scroll
		lockBodyScroll();

		// Dispatch custom event
		dispatchEvent(drawer, 'drawer:show', { drawerId, triggerElement });
	};

	// Hide drawer
	const hide = (drawerId) => {
		const drawer = document.getElementById(drawerId);
		if (!drawer) {
			console.warn(`⚠️ Drawer not found: ${drawerId}`);
			return;
		}

		const isOpen = drawer.getAttribute('data-drawer-state') === 'open';
		if (!isOpen) return;

		// Hide drawer
		drawer.setAttribute('data-drawer-state', 'hidden');
		drawer.setAttribute('aria-hidden', 'true');

		// Remove from active drawers
		activeDrawers = activeDrawers.filter((id) => id !== drawerId);

		// Update trigger button aria-expanded
		const triggerButton = document.querySelector(
			`[data-drawer-target="${drawerId}"], [data-drawer-toggle="${drawerId}"]`
		);
		if (triggerButton && triggerButton.hasAttribute('aria-expanded')) {
			triggerButton.setAttribute('aria-expanded', 'false');
		}

		// Unlock body scroll if no drawers are open
		if (activeDrawers.length === 0) {
			unlockBodyScroll();

			// Return focus to trigger element
			if (focusedElementBeforeDrawer) {
				focusedElementBeforeDrawer.focus();
				focusedElementBeforeDrawer = null;
			}
		}

		// Dispatch custom event
		dispatchEvent(drawer, 'drawer:hide', { drawerId });
	};

	// Toggle drawer
	const toggle = (drawerId, triggerElement = null) => {
		const drawer = document.getElementById(drawerId);
		if (!drawer) return;

		const isOpen = drawer.getAttribute('data-drawer-state') === 'open';
		isOpen ? hide(drawerId) : show(drawerId, triggerElement);
	};

	// Target buttons (show drawer)
	document.addEventListener('click', (e) => {
		const targetBtn = e.target.closest('[data-drawer-target]');
		if (targetBtn) {
			e.preventDefault();
			const drawerId = targetBtn.getAttribute('data-drawer-target');
			show(drawerId, targetBtn);
		}
	});

	// Toggle buttons
	document.addEventListener('click', (e) => {
		const toggleBtn = e.target.closest('[data-drawer-toggle]');
		if (toggleBtn) {
			e.preventDefault();
			const drawerId = toggleBtn.getAttribute('data-drawer-toggle');
			toggle(drawerId, toggleBtn);
		}
	});

	// Show buttons
	document.addEventListener('click', (e) => {
		const showBtn = e.target.closest('[data-drawer-show]');
		if (showBtn) {
			e.preventDefault();
			const drawerId = showBtn.getAttribute('data-drawer-show');
			show(drawerId, showBtn);
		}
	});

	// Hide buttons
	document.addEventListener('click', (e) => {
		const hideBtn = e.target.closest('[data-drawer-hide]');
		if (hideBtn) {
			e.preventDefault();
			const drawerId = hideBtn.getAttribute('data-drawer-hide');
			hide(drawerId);
		}
	});

	// Backdrop click
	document.addEventListener('click', (e) => {
		const backdrop = e.target.closest('.drawer__backdrop');
		if (backdrop) {
			const drawer = backdrop.closest('.drawer');
			if (drawer && drawer.id) {
				const backdropBehavior = drawer.getAttribute('data-drawer-backdrop');
				if (backdropBehavior !== 'static') {
					e.preventDefault();
					hide(drawer.id);
				} else {
					// Shake effect for static backdrop
					drawer.classList.add('drawer--shake');
					setTimeout(() => {
						drawer.classList.remove('drawer--shake');
					}, 500);
				}
			}
		}
	});

	// Escape key
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && activeDrawers.length > 0) {
			const lastDrawerId = activeDrawers[activeDrawers.length - 1];
			hide(lastDrawerId);
		}
	});

	// Close on resize to desktop (optional)
	let resizeTimer;
	window.addEventListener('resize', () => {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(() => {
			if (window.innerWidth >= 768 && activeDrawers.length > 0) {
				activeDrawers.forEach((drawerId) => hide(drawerId));
			}
		}, 250);
	});

	console.log(`✅ Initialized ${drawers.length} drawer(s)`);
}

/**
 * Lock body scroll
 */
function lockBodyScroll() {
	const scrollY = window.scrollY;
	document.body.style.position = 'fixed';
	document.body.style.top = `-${scrollY}px`;
	document.body.style.width = '100%';
}

/**
 * Unlock body scroll
 */
function unlockBodyScroll() {
	const scrollY = document.body.style.top;
	document.body.style.position = '';
	document.body.style.top = '';
	document.body.style.width = '';

	if (scrollY) {
		window.scrollTo(0, parseInt(scrollY || '0') * -1);
	}
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
