// Mobile Navigation
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Close mobile nav when clicking on a link
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});

// Form Submission
const registrationForm = document.getElementById('registration-form');
if (registrationForm) {
    registrationForm.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Thank you for your registration! We will contact you soon.');
        registrationForm.reset();
    });
}

// Map functionality
const markers = document.querySelectorAll('.map-marker');
const mapInfo = document.getElementById('map-info');
const infoCity = document.getElementById('info-city');
const infoEvents = document.getElementById('info-events');
const infoDates = document.getElementById('info-dates');

// Event data for each city
const eventData = {
    Mumbai: { events: 5, nextEvent: 'August 25, 2023' },
    Delhi: { events: 3, nextEvent: 'September 10, 2023' },
    Bangalore: { events: 4, nextEvent: 'September 5, 2023' },
    Chennai: { events: 2, nextEvent: 'October 2, 2023' },
    Hyderabad: { events: 3, nextEvent: 'September 18, 2023' },
    Kochi: { events: 1, nextEvent: 'November 5, 2023' }
};

// Add click events to map markers
markers.forEach(marker => {
    marker.addEventListener('click', () => {
        const city = marker.getAttribute('data-city');
        if (!city || !mapInfo || !infoCity || !infoEvents || !infoDates) return;

        infoCity.textContent = city;
        infoEvents.textContent = `Upcoming Events: ${eventData[city].events}`;
        infoDates.textContent = `Next Event: ${eventData[city].nextEvent}`;

        // Position the info box near the marker with clamping
        const mapContainer = document.querySelector('.map-container');
        if (!mapContainer) return;
        mapInfo.style.display = 'block';

        const rect = marker.getBoundingClientRect();
        const mapRect = mapContainer.getBoundingClientRect();
        let top = rect.top - mapRect.top - 20;
        let left = rect.left - mapRect.left + 30;

        const padding = 10;
        const infoW = mapInfo.offsetWidth;
        const infoH = mapInfo.offsetHeight;
        const maxLeft = mapContainer.clientWidth - infoW - padding;
        const maxTop = mapContainer.clientHeight - infoH - padding;

        if (left < padding) left = padding;
        if (top < padding) top = padding;
        if (left > maxLeft) left = maxLeft;
        if (top > maxTop) top = maxTop;

        mapInfo.style.top = `${top}px`;
        mapInfo.style.left = `${left}px`;
    });
});

// Close map info when clicking elsewhere
const mapContainerEl = document.querySelector('.map-container');
if (mapContainerEl && mapInfo) {
    mapContainerEl.addEventListener('click', (e) => {
        if (!(e.target instanceof Element)) return;
        if (!e.target.classList.contains('map-marker')) {
            mapInfo.style.display = 'none';
        }
    });
}

// Animation on scroll
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.event-card, .testimonial-card');
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        if (elementPosition < screenPosition) {
            element.style.opacity = 1;
            element.style.transform = 'translateY(0)';
        }
    });
};

document.querySelectorAll('.event-card, .testimonial-card').forEach(element => {
    element.style.opacity = 0;
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
});

window.addEventListener('scroll', animateOnScroll);
window.addEventListener('load', animateOnScroll);

// Smooth scrolling with fixed-header offset
const headerEl = document.querySelector('header');
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
        const targetId = anchor.getAttribute('href');
        if (!targetId || targetId === '#') return;
        const target = document.querySelector(targetId);
        if (!target) return;

        e.preventDefault();

        const headerOffset = headerEl ? headerEl.offsetHeight : 0;
        const elementPosition = target.getBoundingClientRect().top + window.pageYOffset;
        const offsetPosition = elementPosition - headerOffset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    });
});

// Highlight active nav link on scroll
const sections = Array.from(document.querySelectorAll('section[id]'));
const navItems = Array.from(document.querySelectorAll('.nav-links a[href^="#"]'));
const setActiveNav = () => {
    const scrollPos = window.scrollY + (headerEl ? headerEl.offsetHeight + 10 : 10);
    let currentId = null;
    for (const sec of sections) {
        if (sec.offsetTop <= scrollPos) currentId = sec.id;
    }
    navItems.forEach(a => {
        if (a.getAttribute('href') === `#${currentId}`) {
            a.classList.add('active');
        } else {
            a.classList.remove('active');
        }
    });
};
window.addEventListener('scroll', setActiveNav);
window.addEventListener('load', setActiveNav);

// Close map info with ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && mapInfo) mapInfo.style.display = 'none';
});

// Accessibility: toggle button aria-expanded
const burgerBtn = document.querySelector('.hamburger');
if (burgerBtn) {
    burgerBtn.setAttribute('aria-label', 'Toggle navigation');
    burgerBtn.setAttribute('aria-expanded', 'false');
    burgerBtn.addEventListener('click', () => {
        const isOpen = navLinks.classList.contains('active');
        burgerBtn.setAttribute('aria-expanded', String(!isOpen));
    });
}


