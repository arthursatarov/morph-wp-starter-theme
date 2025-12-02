/**
 * Modal Component
 *
 * Simple modal initialization with accessibility support
 *
 * @package Morph
 * @since 0.0.1
 */

/**
 * Initialize all modals
 */
export function initModals() {
	const modals = document.querySelectorAll('.modal');
	let activeModals = [];
	let focusedElementBeforeModal = null;

	modals.forEach((modal) => {
		const id = modal.id;

		if (!id) {
			console.warn('⚠️ Modal missing ID attribute:', modal);
			return;
		}

		// Set required ARIA attributes
		if (!modal.hasAttribute('role')) {
			modal.setAttribute('role', 'dialog');
		}
		if (!modal.hasAttribute('aria-modal')) {
			modal.setAttribute('aria-modal', 'true');
		}
		modal.setAttribute('aria-hidden', 'true');

		// Set initial state
		if (!modal.hasAttribute('data-modal-state')) {
			modal.setAttribute('data-modal-state', 'hidden');
		}

		// Warn if missing aria-labelledby
		if (!modal.hasAttribute('aria-labelledby')) {
			console.warn(`⚠️ Modal "${id}" missing aria-labelledby attribute`);
		}
	});

	// Show modal
	const show = (modalId, triggerElement = null) => {
		const modal = document.getElementById(modalId);
		if (!modal) {
			console.warn(`⚠️ Modal not found: ${modalId}`);
			return;
		}

		const isAlreadyOpen = modal.getAttribute('data-modal-state') === 'open';
		if (isAlreadyOpen) return;

		// Store previously focused element
		if (triggerElement) {
			focusedElementBeforeModal = triggerElement;
		} else if (!focusedElementBeforeModal) {
			focusedElementBeforeModal = document.activeElement;
		}

		// Show modal
		modal.setAttribute('data-modal-state', 'open');
		modal.setAttribute('aria-hidden', 'false');
		activeModals.push(modalId);

		// Lock body scroll
		lockBodyScroll();

		// Setup focus trap
		setupFocusTrap(modal);

		// Dispatch custom event
		dispatchEvent(modal, 'modal:show', { modalId, triggerElement });
	};

	// Hide modal
	const hide = (modalId) => {
		const modal = document.getElementById(modalId);
		if (!modal) {
			console.warn(`⚠️ Modal not found: ${modalId}`);
			return;
		}

		const isOpen = modal.getAttribute('data-modal-state') === 'open';
		if (!isOpen) return;

		// Hide modal
		modal.setAttribute('data-modal-state', 'hidden');
		modal.setAttribute('aria-hidden', 'true');

		// Remove from active modals
		activeModals = activeModals.filter((id) => id !== modalId);

		// Unlock body scroll if no modals are open
		if (activeModals.length === 0) {
			unlockBodyScroll();

			// Return focus to trigger element
			if (focusedElementBeforeModal) {
				focusedElementBeforeModal.focus();
				focusedElementBeforeModal = null;
			}
		}

		// Dispatch custom event
		dispatchEvent(modal, 'modal:hide', { modalId });
	};

	// Toggle modal
	const toggle = (modalId, triggerElement = null) => {
		const modal = document.getElementById(modalId);
		if (!modal) return;

		const isOpen = modal.getAttribute('data-modal-state') === 'open';
		isOpen ? hide(modalId) : show(modalId, triggerElement);
	};

	// Target buttons (show modal)
	document.addEventListener('click', (e) => {
		const targetBtn = e.target.closest('[data-modal-target]');
		if (targetBtn) {
			e.preventDefault();
			const modalId = targetBtn.getAttribute('data-modal-target');
			show(modalId, targetBtn);
		}
	});

	// Toggle buttons
	document.addEventListener('click', (e) => {
		const toggleBtn = e.target.closest('[data-modal-toggle]');
		if (toggleBtn) {
			e.preventDefault();
			const modalId = toggleBtn.getAttribute('data-modal-toggle');
			toggle(modalId, toggleBtn);
		}
	});

	// Show buttons
	document.addEventListener('click', (e) => {
		const showBtn = e.target.closest('[data-modal-show]');
		if (showBtn) {
			e.preventDefault();
			const modalId = showBtn.getAttribute('data-modal-show');
			show(modalId, showBtn);
		}
	});

	// Hide buttons
	document.addEventListener('click', (e) => {
		const hideBtn = e.target.closest('[data-modal-hide]');
		if (hideBtn) {
			e.preventDefault();
			const modalId = hideBtn.getAttribute('data-modal-hide');
			hide(modalId);
		}
	});

	// Backdrop click
	document.addEventListener('click', (e) => {
		const backdrop = e.target.closest('.modal__backdrop');
		if (backdrop) {
			const modal = backdrop.closest('.modal');
			if (modal && modal.id) {
				const backdropBehavior = modal.getAttribute('data-modal-backdrop');
				if (backdropBehavior !== 'static') {
					e.preventDefault();
					hide(modal.id);
				}
			}
		}
	});

	// Escape key
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && activeModals.length > 0) {
			const lastModalId = activeModals[activeModals.length - 1];
			hide(lastModalId);
		}
	});

	console.log(`✅ Initialized ${modals.length} modal(s)`);
}

/**
 * Setup focus trap for modal
 *
 * @param {HTMLElement} modal - Modal element
 */
function setupFocusTrap(modal) {
	const focusableSelectors = [
		'a[href]',
		'button:not([disabled])',
		'textarea:not([disabled])',
		'input:not([disabled])',
		'select:not([disabled])',
		'[tabindex]:not([tabindex="-1"])',
	].join(', ');

	const focusableElements = modal.querySelectorAll(focusableSelectors);

	if (focusableElements.length === 0) {
		console.warn('⚠️ No focusable elements in modal');
		return;
	}

	const firstFocusable = focusableElements[0];
	const lastFocusable = focusableElements[focusableElements.length - 1];

	// Focus first element
	firstFocusable.focus();

	// Trap focus within modal
	const handleTabKey = (e) => {
		if (e.key !== 'Tab') return;

		// Shift + Tab
		if (e.shiftKey) {
			if (document.activeElement === firstFocusable) {
				e.preventDefault();
				lastFocusable.focus();
			}
		}
		// Tab
		else {
			if (document.activeElement === lastFocusable) {
				e.preventDefault();
				firstFocusable.focus();
			}
		}
	};

	// Remove old listener if exists
	modal.removeEventListener('keydown', handleTabKey);
	// Add new listener
	modal.addEventListener('keydown', handleTabKey);
}

/**
 * Lock body scroll
 */
function lockBodyScroll() {
	document.documentElement.style.overflow = 'hidden';
}

/**
 * Unlock body scroll
 */
function unlockBodyScroll() {
	document.documentElement.style.overflow = '';
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
