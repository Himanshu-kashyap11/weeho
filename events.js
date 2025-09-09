// Events page JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    let eventsData = [];
    let filteredEvents = [];
    let currentFilter = 'all';

    // Initialize events page
    initializeEventsPage();

    async function initializeEventsPage() {
        try {
            await loadEvents();
            setupFilters();
            setupModals();
            renderEvents();
        } catch (error) {
            console.error('Error initializing events page:', error);
            showError('Failed to load events. Please try again later.');
        }
    }

    // Load events from database API
    async function loadEvents() {
        try {
            console.log('Loading events from database API...');
            const response = await fetch('api/EventsAPI.php');
            if (!response.ok) {
                throw new Error(`Failed to fetch events: ${response.status}`);
            }
            const result = await response.json();
            console.log('Events API response:', result);
            
            if (result.success && result.data) {
                eventsData = result.data;
                filteredEvents = [...eventsData];
                console.log('Events loaded successfully:', eventsData.length, 'events');
            } else {
                throw new Error(result.message || 'Failed to load events from database');
            }
        } catch (error) {
            console.error('Error loading events:', error);
            // Fallback to JSON file if database fails
            try {
                console.log('Falling back to JSON file...');
                const jsonResponse = await fetch('events.json');
                if (jsonResponse.ok) {
                    eventsData = await jsonResponse.json();
                    filteredEvents = [...eventsData];
                    console.log('Loaded events from JSON fallback');
                } else {
                    throw error;
                }
            } catch (fallbackError) {
                console.error('Fallback also failed:', fallbackError);
                throw error;
            }
        }
    }

    // Setup filter functionality
    function setupFilters() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                currentFilter = this.getAttribute('data-filter');
                
                // Filter and render events
                filterEvents(currentFilter);
                renderEvents();
            });
        });
    }

    // Filter events based on category
    function filterEvents(filter) {
        if (filter === 'all') {
            filteredEvents = [...eventsData];
        } else if (filter === 'upcoming') {
            filteredEvents = eventsData.filter(event => event.status === 'upcoming');
        } else {
            filteredEvents = eventsData.filter(event => event.category === filter);
        }
    }

    // Render events to the page
    function renderEvents() {
        const eventsGrid = document.getElementById('eventsGrid');
        const loadingState = document.getElementById('loadingState');
        const noEventsState = document.getElementById('noEventsState');

        // Hide loading state
        loadingState.style.display = 'none';

        if (filteredEvents.length === 0) {
            eventsGrid.innerHTML = '';
            noEventsState.style.display = 'block';
            return;
        }

        noEventsState.style.display = 'none';
        
        eventsGrid.innerHTML = filteredEvents.map(event => createEventCard(event)).join('');
        
        // Add event listeners to buttons
        setupEventButtons();
    }

    // Create HTML for event card
    function createEventCard(event) {
        const eventDate = new Date(event.date);
        const formattedDate = eventDate.toLocaleDateString('en-US', {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });

        const categoryIcons = {
            music: '🎵',
            dance: '💃',
            art: '🎨',
            theater: '🎭',
            literature: '📚',
            fusion: '✨'
        };

        const statusClass = event.status === 'upcoming' ? 'status-upcoming' : 'status-completed';
        const registrationProgress = Math.round((event.registered / event.capacity) * 100);

        return `
            <div class="event-card" data-aos="fade-up">
                <div class="event-image">
                    <div class="event-category">${categoryIcons[event.category] || '🎭'} ${event.category}</div>
                    <div class="event-status ${statusClass}">${event.status}</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">${event.title}</h3>
                    <p class="event-performer">by ${event.performer}</p>
                    
                    <div class="event-details">
                        <div class="event-detail">
                            <span class="event-detail-icon">📅</span>
                            <span>${formattedDate}</span>
                        </div>
                        <div class="event-detail">
                            <span class="event-detail-icon">🕐</span>
                            <span>${event.time}</span>
                        </div>
                        <div class="event-detail">
                            <span class="event-detail-icon">📍</span>
                            <span>${event.city}</span>
                        </div>
                        <div class="event-detail">
                            <span class="event-detail-icon">🎫</span>
                            <span>${event.price}</span>
                        </div>
                    </div>
                    
                    <p class="event-description">${event.description}</p>
                    
                    <div class="event-progress" style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: var(--text-light); margin-bottom: 5px;">
                            <span>${event.registered} registered</span>
                            <span>${registrationProgress}% full</span>
                        </div>
                        <div style="background: #e2e8f0; height: 4px; border-radius: 2px; overflow: hidden;">
                            <div style="background: var(--primary-orange); height: 100%; width: ${registrationProgress}%; transition: width 0.3s ease;"></div>
                        </div>
                    </div>
                    
                    <div class="event-actions">
                        <button class="btn-register" data-event-id="${event.id}">
                            ${event.status === 'upcoming' ? 'Register' : 'View Details'}
                        </button>
                        <button class="btn-feedback" data-event-id="${event.id}">Feedback</button>
                    </div>
                </div>
            </div>
        `;
    }

    // Setup event buttons
    function setupEventButtons() {
        const registerButtons = document.querySelectorAll('.btn-register');
        const feedbackButtons = document.querySelectorAll('.btn-feedback');

        registerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event-id');
                console.log('Register button clicked for eventId:', eventId);
                
                // Find event by string comparison (database IDs might be strings)
                const event = eventsData.find(e => e.id == eventId);
                console.log('Found event:', event);
                
                if (event) {
                    openRegistrationModal(event);
                } else {
                    console.error('Event not found for ID:', eventId);
                    showNotification('Event not found. Please refresh the page and try again.', 'error');
                }
            });
        });

        feedbackButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event-id');
                console.log('Feedback button clicked for eventId:', eventId);
                
                // Find event by string comparison (database IDs might be strings)
                const event = eventsData.find(e => e.id == eventId);
                console.log('Found event for feedback:', event);
                
                if (event) {
                    openFeedbackModal(event);
                } else {
                    console.error('Event not found for feedback ID:', eventId);
                    showNotification('Event not found. Please refresh the page and try again.', 'error');
                }
            });
        });
    }

    // Setup modal functionality
    function setupModals() {
        // Registration form
        const registrationForm = document.getElementById('registrationForm');
        if (registrationForm) {
            registrationForm.addEventListener('submit', handleRegistration);
        }

        // Feedback form
        const feedbackForm = document.getElementById('feedbackForm');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', handleFeedback);
        }

        // Rating stars
        setupRatingStars();

        // Close modals on outside click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal(e.target.id);
            }
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    }

    // Setup rating stars functionality
    function setupRatingStars() {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;

                // Update star display
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.style.color = 'var(--secondary-yellow)';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });

        // Reset on mouse leave
        document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value) || 0;
            stars.forEach((s, i) => {
                if (i < currentRating) {
                    s.style.color = 'var(--secondary-yellow)';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    }

    // Open registration modal
    function openRegistrationModal(event) {
        console.log('Opening registration modal for event:', event);
        
        const modal = document.getElementById('registrationModal');
        const eventInfo = document.getElementById('modalEventInfo');
        const eventIdInput = document.getElementById('regEventId');
        
        if (!modal || !eventInfo || !eventIdInput) {
            console.error('Modal elements not found');
            showNotification('Registration form not available. Please try again.', 'error');
            return;
        }
        
        // Validate event data
        if (!event || !event.id) {
            console.error('Invalid event data:', event);
            showNotification('Event information not available. Please try again.', 'error');
            return;
        }

        // Populate event info
        eventInfo.innerHTML = `
            <h3>${event.title}</h3>
            <p><strong>Date:</strong> ${new Date(event.date).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            })} at ${event.time}</p>
            <p><strong>Venue:</strong> ${event.venue}, ${event.city}</p>
            <p><strong>Price:</strong> ${event.price}</p>
        `;

        // Set event ID with validation
        console.log('Setting eventId to:', event.id);
        eventIdInput.value = event.id;
        
        // Verify the value was set
        console.log('EventId input value after setting:', eventIdInput.value);
        
        showModal('registrationModal');
    }

    // Open feedback modal
    function openFeedbackModal(event) {
        const modal = document.getElementById('feedbackModal');
        const eventInfo = document.getElementById('feedbackEventInfo');
        const eventIdInput = document.getElementById('feedbackEventId');

        // Populate event info
        eventInfo.innerHTML = `
            <h3>${event.title}</h3>
            <p><strong>Performer:</strong> ${event.performer}</p>
            <p><strong>Date:</strong> ${new Date(event.date).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            })}</p>
            <p><strong>Venue:</strong> ${event.venue}, ${event.city}</p>
        `;

        eventIdInput.value = event.id;
        showModal('feedbackModal');
    }

    // Handle registration form submission
    async function handleRegistration(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const eventId = formData.get('eventId');
        
        // Validate required fields
        const requiredFields = ['name', 'email', 'phone', 'eventId'];
        const missingFields = [];
        
        requiredFields.forEach(field => {
            if (!formData.get(field)) {
                missingFields.push(field);
            }
        });
        
        if (missingFields.length > 0) {
            showNotification(`Please fill in all required fields: ${missingFields.join(', ')}`, 'error');
            return;
        }
        
        // Validate email format
        const email = formData.get('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showNotification('Please enter a valid email address.', 'error');
            return;
        }
        
        // Validate event ID
        if (!eventId || eventId === '') {
            console.error('Event ID is missing or empty');
            showNotification('Event selection error. Please try again.', 'error');
            return;
        }
        
        console.log('Submitting registration with eventId:', eventId);
        console.log('Form data:', Object.fromEntries(formData.entries()));
        
        try {
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });
            
            console.log('Registration response status:', response.status);
            const result = await response.json();
            console.log('Registration result:', result);
            
            if (result.success) {
                showNotification('Registration successful! You will receive a confirmation email shortly.', 'success');
                closeModal('registrationModal');
                e.target.reset();
                
                // Reload events to update registration count
                await loadEvents();
                renderEvents();
            } else {
                showNotification(result.message || 'Registration failed. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Registration error:', error);
            showNotification('Registration failed. Please check your connection and try again.', 'error');
        }
    }

    // Handle feedback form submission
    async function handleFeedback(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const feedbackData = Object.fromEntries(formData.entries());

        // Validate rating
        if (!feedbackData.rating) {
            showNotification('Please provide a rating.', 'error');
            return;
        }

        try {
            const response = await fetch('feedback.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification('Thank you for your feedback! Your input helps us improve.', 'success');
                closeModal('feedbackModal');
                e.target.reset();
                
                // Reset rating stars
                document.querySelectorAll('.star').forEach(star => {
                    star.classList.remove('active');
                    star.style.color = '#ddd';
                });
                document.getElementById('ratingValue').value = '';
            } else {
                showNotification(result.message || 'Failed to submit feedback. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Feedback error:', error);
            showNotification('Failed to submit feedback. Please try again.', 'error');
        }
    }

    // Utility functions
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    function simulateApiCall() {
        return new Promise((resolve) => {
            setTimeout(resolve, 1000);
        });
    }

    function showError(message) {
        const eventsGrid = document.getElementById('eventsGrid');
        const loadingState = document.getElementById('loadingState');
        
        loadingState.style.display = 'none';
        eventsGrid.innerHTML = `
            <div style="text-align: center; padding: 60px 20px; color: var(--text-light);">
                <div style="font-size: 4rem; margin-bottom: 20px;">⚠️</div>
                <h3 style="color: var(--text-dark); margin-bottom: 10px;">Error Loading Events</h3>
                <p>${message}</p>
                <button onclick="location.reload()" class="btn btn-primary" style="margin-top: 20px;">
                    Try Again
                </button>
            </div>
        `;
    }

    // Make functions globally available
    window.closeModal = closeModal;
});

// Notification function (reuse from main script.js)
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Add styles
    Object.assign(notification.style, {
        position: 'fixed',
        top: '90px',
        right: '20px',
        padding: '15px 20px',
        borderRadius: '8px',
        color: 'white',
        fontWeight: '500',
        zIndex: '1002',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease',
        maxWidth: '300px',
        wordWrap: 'break-word'
    });

    // Set background color based on type
    switch (type) {
        case 'success':
            notification.style.backgroundColor = '#10B981';
            break;
        case 'error':
            notification.style.backgroundColor = '#EF4444';
            break;
        default:
            notification.style.backgroundColor = '#3B82F6';
    }

    // Add to DOM
    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}
