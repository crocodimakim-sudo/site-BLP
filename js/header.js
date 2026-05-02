/**
 * Header Navigation Scripts
 * Handles mobile menu toggle and dropdown functionality
 */

(function() {
    'use strict';

    const mobileToggle = document.querySelector('.header .mobile-toggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavLinks = document.querySelectorAll('.header .mobile-nav-link');

    /**
     * Toggle mobile menu visibility
     */
    function toggleMobileMenu() {
        if (!mobileToggle || !mobileNav) return;

        const isActive = mobileToggle.classList.contains('active');
        mobileToggle.classList.toggle('active');
        mobileNav.classList.toggle('active');
        mobileToggle.setAttribute('aria-expanded', !isActive);
        document.body.style.overflow = isActive ? '' : 'hidden';
    }

    /**
     * Toggle dropdown in mobile menu
     */
    function toggleDropdown(button) {
        if (!button) return;

        const dropdown = button.nextElementSibling;
        const arrow = button.querySelector('svg');

        if (!dropdown || !dropdown.classList.contains('mobile-dropdown')) return;

        const isActive = dropdown.classList.contains('active');

        // Close all dropdowns
        document.querySelectorAll('.header .mobile-dropdown').forEach(d => {
            d.classList.remove('active');
        });
        document.querySelectorAll('.header .mobile-nav-link svg').forEach(s => {
            s.style.transform = 'rotate(0deg)';
        });

        // Open clicked dropdown
        if (!isActive) {
            dropdown.classList.add('active');
            arrow.style.transform = 'rotate(180deg)';
            button.setAttribute('aria-expanded', 'true');
        } else {
            button.setAttribute('aria-expanded', 'false');
        }
    }

    /**
     * Close mobile menu when link is clicked
     */
    function closeMobileMenuOnLinkClick() {
        const links = document.querySelectorAll('.header .mobile-dropdown-item, .header .mobile-nav-item > a');
        links.forEach(link => {
            link.addEventListener('click', toggleMobileMenu);
        });
    }

    /**
     * Handle desktop dropdown with keyboard
     */
    function setupDesktopDropdowns() {
        const navLinks = document.querySelectorAll('.header .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    /**
     * Initialize event listeners
     */
    function init() {
        // Mobile menu toggle
        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleMobileMenu);
        }

        // Mobile dropdown toggles
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Only prevent default if it's a button with dropdown
                if (this.tagName === 'BUTTON' && this.hasAttribute('aria-haspopup')) {
                    e.preventDefault();
                    toggleDropdown(this);
                }
            });
        });

        // Close menu when clicking on links
        closeMobileMenuOnLinkClick();

        // Setup desktop dropdown keyboard support
        setupDesktopDropdowns();

        // Close mobile menu when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                toggleMobileMenu();
                mobileToggle.focus();
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
