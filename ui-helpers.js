/* UI ENHANCEMENT — Do not change backend logic */

(function() {
  'use strict';

  // Respect user's motion preferences
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Toast notification system
  class ToastManager {
    constructor() {
      this.toasts = [];
      this.container = null;
      this.init();
    }

    init() {
      // Create toast container if it doesn't exist
      if (!document.querySelector('.toast-container')) {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        this.container.style.cssText = `
          position: fixed;
          top: 100px;
          right: 20px;
          z-index: 9999;
          pointer-events: none;
        `;
        document.body.appendChild(this.container);
      }
    }

    show(message, type = 'info', duration = 3500) {
      const toast = this.createToast(message, type);
      this.container.appendChild(toast);
      this.toasts.push(toast);

      // Trigger show animation
      requestAnimationFrame(() => {
        toast.classList.add('show');
      });

      // Auto-hide after duration
      setTimeout(() => {
        this.hide(toast);
      }, duration);

      return toast;
    }

    createToast(message, type) {
      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      toast.style.pointerEvents = 'auto';

      const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
      };

      const titles = {
        success: 'Success',
        error: 'Error',
        warning: 'Warning',
        info: 'Info'
      };

      toast.innerHTML = `
        <div class="toast-icon">${icons[type] || icons.info}</div>
        <div class="toast-content">
          <div class="toast-title">${titles[type] || titles.info}</div>
          <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close" aria-label="Close notification">×</button>
      `;

      // Add close functionality
      const closeBtn = toast.querySelector('.toast-close');
      closeBtn.addEventListener('click', () => {
        this.hide(toast);
      });

      return toast;
    }

    hide(toast) {
      toast.classList.remove('show');
      setTimeout(() => {
        if (toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
        const index = this.toasts.indexOf(toast);
        if (index > -1) {
          this.toasts.splice(index, 1);
        }
      }, 300);
    }

    success(message) {
      return this.show(message, 'success');
    }

    error(message) {
      return this.show(message, 'error');
    }

    warning(message) {
      return this.show(message, 'warning');
    }

    info(message) {
      return this.show(message, 'info');
    }
  }

  // Initialize toast manager
  const toast = new ToastManager();

  // Make toast available globally
  window.showToast = toast.show.bind(toast);
  window.toast = toast;

  // Intersection Observer for entrance animations
  class AnimationObserver {
    constructor() {
      this.observer = null;
      this.init();
    }

    init() {
      if (prefersReducedMotion) return;

      this.observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            this.observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      });
    }

    observe(elements) {
      if (!this.observer || prefersReducedMotion) return;

      elements.forEach((element, index) => {
        // Add initial hidden state
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        
        // Add delay class for staggered animation
        if (index > 0) {
          element.classList.add(`animate-delay-${Math.min(index, 3)}`);
        }
        
        this.observer.observe(element);
      });
    }
  }

  // Initialize animation observer
  const animationObserver = new AnimationObserver();

  // Enhanced navbar scroll behavior
  function initNavbarEnhancements() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    function updateNavbar() {
      const scrollY = window.scrollY;
      
      if (scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }

      lastScrollY = scrollY;
      ticking = false;
    }

    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(updateNavbar);
        ticking = true;
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Enhanced form interactions
  function initFormEnhancements() {
    // Add floating labels effect
    const formControls = document.querySelectorAll('.form-control');
    
    formControls.forEach(input => {
      const label = input.previousElementSibling;
      
      if (label && label.tagName === 'LABEL') {
        // Add focus/blur handlers for enhanced UX
        input.addEventListener('focus', () => {
          label.style.transform = 'translateY(-8px) scale(0.85)';
          label.style.color = 'var(--accent-mid)';
        });

        input.addEventListener('blur', () => {
          if (!input.value) {
            label.style.transform = '';
            label.style.color = '';
          }
        });

        // Check initial state
        if (input.value) {
          label.style.transform = 'translateY(-8px) scale(0.85)';
        }
      }
    });
  }

  // Enhanced button interactions
  function initButtonEnhancements() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
      // Add ripple effect on click
      button.addEventListener('click', function(e) {
        if (prefersReducedMotion) return;

        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
          position: absolute;
          width: ${size}px;
          height: ${size}px;
          left: ${x}px;
          top: ${y}px;
          background: rgba(255, 255, 255, 0.3);
          border-radius: 50%;
          transform: scale(0);
          animation: ripple 0.6s ease-out;
          pointer-events: none;
        `;
        
        this.appendChild(ripple);
        
        setTimeout(() => {
          ripple.remove();
        }, 600);
      });
    });

    // Add ripple animation
    if (!document.querySelector('#ripple-styles')) {
      const style = document.createElement('style');
      style.id = 'ripple-styles';
      style.textContent = `
        @keyframes ripple {
          to {
            transform: scale(2);
            opacity: 0;
          }
        }
      `;
      document.head.appendChild(style);
    }
  }

  // Hook into existing form submissions for toast notifications
  function initFormSubmissionHooks() {
    // Listen for successful form submissions
    document.addEventListener('DOMContentLoaded', () => {
      // Hook into registration form
      const regForm = document.getElementById('registrationForm');
      if (regForm) {
        const originalSubmit = regForm.onsubmit;
        regForm.addEventListener('submit', function(e) {
          // Add loading state
          const submitBtn = this.querySelector('button[type="submit"]');
          if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
          }
        });
      }

      // Hook into feedback form
      const feedbackForm = document.getElementById('feedbackForm');
      if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
          const submitBtn = this.querySelector('button[type="submit"]');
          if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
          }
        });
      }
    });

    // Listen for existing showNotification calls and enhance them
    const originalShowNotification = window.showNotification;
    if (originalShowNotification) {
      window.showNotification = function(message, type) {
        // Call original function
        originalShowNotification(message, type);
        
        // Also show our enhanced toast
        const toastType = type === 'success' ? 'success' : 
                         type === 'error' ? 'error' : 'info';
        toast.show(message, toastType);
      };
    }
  }

  // Initialize page transitions
  function initPageTransitions() {
    if (prefersReducedMotion) return;

    document.body.classList.add('page-transition');
    
    // Animate page entrance
    setTimeout(() => {
      document.body.style.opacity = '1';
      document.body.style.transform = 'translateY(0)';
    }, 100);
  }

  // Initialize all enhancements when DOM is ready
  function init() {
    // Add entrance animations to key elements
    const animatedElements = document.querySelectorAll(`
      .event-card,
      .mission-card,
      .testimonial,
      .card,
      .section-header,
      .hero-content > *
    `);
    
    if (animatedElements.length > 0) {
      animationObserver.observe(Array.from(animatedElements));
    }

    // Initialize all enhancements
    initNavbarEnhancements();
    initFormEnhancements();
    initButtonEnhancements();
    initFormSubmissionHooks();
    initPageTransitions();

    // Add ARIA labels for better accessibility
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      if (!link.getAttribute('aria-label')) {
        link.setAttribute('aria-label', `Navigate to ${link.textContent.trim()}`);
      }
    });

    // Add role attributes
    const navbar = document.querySelector('.navbar');
    if (navbar && !navbar.getAttribute('role')) {
      navbar.setAttribute('role', 'navigation');
      navbar.setAttribute('aria-label', 'Main navigation');
    }

    const main = document.querySelector('.main-content');
    if (main && !main.getAttribute('role')) {
      main.setAttribute('role', 'main');
    }

    // Enhance modal accessibility
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
      if (!modal.getAttribute('role')) {
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
      }
      
      const title = modal.querySelector('.modal-title');
      if (title && !modal.getAttribute('aria-labelledby')) {
        if (!title.id) {
          title.id = 'modal-title-' + Math.random().toString(36).substr(2, 9);
        }
        modal.setAttribute('aria-labelledby', title.id);
      }
    });
  }

  // Dark Mode Toggle System
  
  // Initialize theme manager
  const themeManager = new ThemeManager();

  // Global initialization
  document.addEventListener('DOMContentLoaded', function() {
    // UI initialization - can be expanded as needed
    console.log('UI helpers loaded');
  });

  // Global APIs
  window.showToast = function(message, type = 'info', duration = 5000) {
    toastManager.show(message, type, duration);
  };

  window.toggleTheme = function() {
    themeManager.toggleTheme();
  };

})();
