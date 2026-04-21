// 2026-04-20: Stage 3 Group 3.B — FAQ accordion interaction
(function () {
    'use strict';

    function initFaqAccordion() {
        var questions = document.querySelectorAll('.faq-question');
        if (!questions.length) return;

        questions.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var expanded = this.getAttribute('aria-expanded') === 'true';
                var answer = this.nextElementSibling;

                // Collapse all in the same accordion group
                var group = this.closest('.faq-accordion');
                if (group) {
                    group.querySelectorAll('.faq-question').forEach(function (q) {
                        q.setAttribute('aria-expanded', 'false');
                        var a = q.nextElementSibling;
                        if (a) a.classList.remove('is-open');
                    });
                }

                // Toggle current
                if (!expanded) {
                    this.setAttribute('aria-expanded', 'true');
                    if (answer) answer.classList.add('is-open');
                }
            });
        });

        // Open first item in each accordion by default
        document.querySelectorAll('.faq-accordion').forEach(function (acc) {
            var firstBtn = acc.querySelector('.faq-question');
            var firstAns = acc.querySelector('.faq-answer');
            if (firstBtn && firstAns) {
                firstBtn.setAttribute('aria-expanded', 'true');
                firstAns.classList.add('is-open');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFaqAccordion);
    } else {
        initFaqAccordion();
    }
})();
