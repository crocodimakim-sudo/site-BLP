/* 2026-05-07: Legal pages — auto-TOC + scroll spy + smooth scroll */
(function() {
    'use strict';

    function init() {
        var content = document.querySelector('.legal-content');
        var nav = document.querySelector('.legal-toc-nav');
        if (!content || !nav) return;

        var headings = content.querySelectorAll('h2');
        if (!headings.length) return;

        var links = [];

        // Build TOC
        headings.forEach(function(h, i) {
            if (!h.id) h.id = 'sec-' + (i + 1);
            var a = document.createElement('a');
            a.href = '#' + h.id;
            a.className = 'legal-toc-link';
            a.textContent = h.textContent.trim();
            a.dataset.target = h.id;
            nav.appendChild(a);
            links.push(a);
        });

        // Smooth scroll
        nav.addEventListener('click', function(e) {
            var link = e.target.closest('.legal-toc-link');
            if (!link) return;
            e.preventDefault();
            var id = link.dataset.target;
            var el = document.getElementById(id);
            if (!el) return;
            var top = el.getBoundingClientRect().top + window.pageYOffset - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
            history.replaceState(null, '', '#' + id);
            // Close mobile TOC
            var toc = document.querySelector('.legal-toc');
            if (toc && window.innerWidth <= 968) toc.classList.remove('is-open');
        });

        // Mobile toggle
        var toggle = document.querySelector('.legal-toc-mobile-toggle');
        if (toggle) {
            toggle.addEventListener('click', function() {
                var toc = document.querySelector('.legal-toc');
                if (toc) toc.classList.toggle('is-open');
            });
        }

        // Scroll spy via IntersectionObserver
        if ('IntersectionObserver' in window) {
            var current = null;
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var id = entry.target.id;
                        links.forEach(function(l) {
                            l.classList.toggle('is-active', l.dataset.target === id);
                        });
                        current = id;
                    }
                });
            }, { rootMargin: '-100px 0px -65% 0px', threshold: 0 });

            headings.forEach(function(h) { observer.observe(h); });
        }

        // Initial active state from hash
        if (window.location.hash) {
            var initial = nav.querySelector('a[href="' + window.location.hash + '"]');
            if (initial) initial.classList.add('is-active');
        } else if (links[0]) {
            links[0].classList.add('is-active');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
