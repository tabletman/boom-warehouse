/**
 * Boom Warehouse — Main JS
 */
(function () {
  'use strict';

  // Mobile menu toggle
  var toggle = document.querySelector('.bw-menu-toggle');
  var mobileNav = document.getElementById('bw-mobile-nav');

  if (toggle && mobileNav) {
    toggle.addEventListener('click', function () {
      var expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      mobileNav.classList.toggle('is-open');
      toggle.innerHTML = mobileNav.classList.contains('is-open') ? '&#10005;' : '&#9776;';
    });
  }

  // Sticky Add to Cart (mobile product pages)
  var stickyATC = document.getElementById('bw-sticky-atc');
  if (stickyATC) {
    var addToCartBtn = document.querySelector('.single_add_to_cart_button');
    if (addToCartBtn) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              stickyATC.classList.remove('is-visible');
            } else {
              stickyATC.classList.add('is-visible');
            }
          });
        },
        { threshold: 0 }
      );
      observer.observe(addToCartBtn);
    }
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
})();
