// Admin Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is on login page or dashboard
    const loginForm = document.getElementById('loginForm');
    const adminSections = document.querySelectorAll('.admin-section');
    const menuLinks = document.querySelectorAll('.menu-link');
    const modal = document.getElementById('adminModal');
    const closeModal = document.querySelector('.close');
    
    // Login functionality
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
    
    // Dashboard functionality
    if (adminSections.length > 0) {
        initializeDashboard();
    }
    
    // Menu navigation
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const section = this.getAttribute('data-section');
            showSection(section);
            
            // Update active menu item
            menuLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Modal functionality
    if (modal && closeModal) {
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    // Logout functionality
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }
});

// Login handler
async function handleLogin(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const loginData = {
        username: formData.get('username'),
        password: formData.get('password')
    };
    
    try {
        const response = await fetch('../api/AdminAPI.php?action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(loginData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Login successful!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(result.message || 'Login failed', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        showNotification('Login failed. Please try again.', 'error');
    }
}

// Logout handler
function handleLogout() {
    if (confirm('Are you sure you want to logout?')) {
        // Clear session (in a real app, call logout endpoint)
        fetch('../api/AdminAPI.php?action=logout', {
            method: 'POST'
        }).finally(() => {
            window.location.reload();
        });
    }
}

// Initialize dashboard
function initializeDashboard() {
    loadDashboardStats();
    loadDashboardData();
}

// Load dashboard statistics
async function loadDashboardStats() {
    try {
        const response = await fetch('../api/AdminAPI.php?action=stats');
        const result = await response.json();
        
        if (result.success) {
            const stats = result.stats;
            document.getElementById('totalEvents').textContent = stats.total_events || 0;
            document.getElementById('totalRegistrations').textContent = stats.total_registrations || 0;
            document.getElementById('totalFeedback').textContent = stats.total_feedback || 0;
            document.getElementById('averageRating').textContent = 
                stats.average_rating ? parseFloat(stats.average_rating).toFixed(1) : '0.0';
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// Load dashboard data
async function loadDashboardData() {
    try {
        const response = await fetch('../api/AdminAPI.php?action=dashboard');
        const result = await response.json();
        
        if (result.success) {
            const data = result.data;
            displayRecentEvents(data.events);
            displayRecentRegistrations(data.registrations);
        }
    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }
}

// Display recent events
function displayRecentEvents(events) {
    const container = document.getElementById('recentEvents');
    if (!container) return;
    
    if (!events || events.length === 0) {
        container.innerHTML = '<p class="no-data">No recent events</p>';
        return;
    }
    
    container.innerHTML = events.map(event => `
        <div class="activity-item">
            <div class="activity-info">
                <h4>${escapeHtml(event.title)}</h4>
                <p>${escapeHtml(event.performer)} - ${escapeHtml(event.city)}</p>
            </div>
            <div class="activity-date">${formatDate(event.date)}</div>
        </div>
    `).join('');
}

// Display recent registrations
function displayRecentRegistrations(registrations) {
    const container = document.getElementById('recentRegistrations');
    if (!container) return;
    
    if (!registrations || registrations.length === 0) {
        container.innerHTML = '<p class="no-data">No recent registrations</p>';
        return;
    }
    
    container.innerHTML = registrations.map(reg => `
        <div class="activity-item">
            <div class="activity-info">
                <h4>${escapeHtml(reg.name)}</h4>
                <p>${escapeHtml(reg.email)} - ${escapeHtml(reg.event_title || 'Unknown Event')}</p>
            </div>
            <div class="activity-date">
                <span class="status-badge status-${reg.status || 'pending'}">${reg.status || 'pending'}</span>
            </div>
        </div>
    `).join('');
}

// Show specific section
function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.admin-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show target section
    const targetSection = document.getElementById(`${sectionName}-section`);
    if (targetSection) {
        targetSection.classList.add('active');
        
        // Load section-specific data
        switch (sectionName) {
            case 'events':
                loadEvents();
                break;
            case 'registrations':
                loadRegistrations();
                break;
            case 'feedback':
                loadFeedback();
                break;
            case 'memories':
                loadMemories();
                break;
        }
    }
}

// Load events data
async function loadEvents() {
    const container = document.getElementById('eventsTable');
    if (!container) return;
    
    container.innerHTML = '<div class="loading">Loading events...</div>';
    
    try {
        const response = await fetch('../api/EventsAPI.php');
        const result = await response.json();
        
        if (result.success && result.events) {
            displayEventsTable(result.events);
        } else {
            container.innerHTML = '<p class="no-data">No events found</p>';
        }
    } catch (error) {
        console.error('Error loading events:', error);
        container.innerHTML = '<p class="error">Error loading events</p>';
    }
}

// Display events table
function displayEventsTable(events) {
    const container = document.getElementById('eventsTable');
    
    const tableHTML = `
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Performer</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${events.map(event => `
                        <tr>
                            <td>${escapeHtml(event.title)}</td>
                            <td>${formatDate(event.date)}</td>
                            <td>${escapeHtml(event.performer)}</td>
                            <td>${escapeHtml(event.city)}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-view" onclick="viewEvent('${event.id}')">View</button>
                                    <button class="btn btn-sm btn-edit" onclick="editEvent('${event.id}')">Edit</button>
                                    <button class="btn btn-sm btn-delete" onclick="deleteEvent('${event.id}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = tableHTML;
}

// Load registrations data
async function loadRegistrations() {
    const container = document.getElementById('registrationsTable');
    if (!container) return;
    
    container.innerHTML = '<div class="loading">Loading registrations...</div>';
    
    try {
        const response = await fetch('../api/RegistrationsAPI.php');
        const result = await response.json();
        
        if (result.success && result.registrations) {
            displayRegistrationsTable(result.registrations);
        } else {
            container.innerHTML = '<p class="no-data">No registrations found</p>';
        }
    } catch (error) {
        console.error('Error loading registrations:', error);
        container.innerHTML = '<p class="error">Error loading registrations</p>';
    }
}

// Display registrations table
function displayRegistrationsTable(registrations) {
    const container = document.getElementById('registrationsTable');
    
    const tableHTML = `
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${registrations.map(reg => `
                        <tr>
                            <td>${escapeHtml(reg.name)}</td>
                            <td>${escapeHtml(reg.email)}</td>
                            <td>${escapeHtml(reg.phone)}</td>
                            <td>${escapeHtml(reg.event_title || 'Unknown')}</td>
                            <td><span class="status-badge status-${reg.status}">${reg.status}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-edit" onclick="editRegistration('${reg.id}')">Edit</button>
                                    <button class="btn btn-sm btn-delete" onclick="deleteRegistration('${reg.id}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = tableHTML;
}

// Load feedback data
async function loadFeedback() {
    const container = document.getElementById('feedbackTable');
    if (!container) return;
    
    container.innerHTML = '<div class="loading">Loading feedback...</div>';
    
    try {
        const response = await fetch('../api/FeedbackAPI.php');
        const result = await response.json();
        
        if (result.success && result.feedback) {
            displayFeedbackTable(result.feedback);
        } else {
            container.innerHTML = '<p class="no-data">No feedback found</p>';
        }
    } catch (error) {
        console.error('Error loading feedback:', error);
        container.innerHTML = '<p class="error">Error loading feedback</p>';
    }
}

// Display feedback table
function displayFeedbackTable(feedback) {
    const container = document.getElementById('feedbackTable');
    
    const tableHTML = `
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Event</th>
                        <th>Rating</th>
                        <th>Feedback</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${feedback.map(fb => `
                        <tr>
                            <td>${escapeHtml(fb.name)}</td>
                            <td>${escapeHtml(fb.event_title || 'Unknown')}</td>
                            <td>${'⭐'.repeat(fb.rating)}</td>
                            <td>${escapeHtml(fb.feedback).substring(0, 50)}...</td>
                            <td><span class="status-badge status-${fb.status}">${fb.status}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-view" onclick="viewFeedback('${fb.id}')">View</button>
                                    <button class="btn btn-sm btn-edit" onclick="editFeedback('${fb.id}')">Edit</button>
                                    <button class="btn btn-sm btn-delete" onclick="deleteFeedback('${fb.id}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = tableHTML;
}

// Load memories data
async function loadMemories() {
    const container = document.getElementById('memoriesTable');
    if (!container) return;
    
    container.innerHTML = '<div class="loading">Loading memories...</div>';
    
    try {
        // Load from JSON file for now
        const response = await fetch('../memories.json');
        const memories = await response.json();
        
        if (memories && memories.length > 0) {
            displayMemoriesTable(memories);
        } else {
            container.innerHTML = '<p class="no-data">No memories found</p>';
        }
    } catch (error) {
        console.error('Error loading memories:', error);
        container.innerHTML = '<p class="error">Error loading memories</p>';
    }
}

// Display memories table
function displayMemoriesTable(memories) {
    const container = document.getElementById('memoriesTable');
    
    const tableHTML = `
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Caption</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${memories.map(memory => `
                        <tr>
                            <td><img src="${memory.image}" alt="Memory" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;"></td>
                            <td>${escapeHtml(memory.caption).substring(0, 100)}...</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-view" onclick="viewMemory('${memory.id}')">View</button>
                                    <button class="btn btn-sm btn-edit" onclick="editMemory('${memory.id}')">Edit</button>
                                    <button class="btn btn-sm btn-delete" onclick="deleteMemory('${memory.id}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = tableHTML;
}

// Utility functions
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text ? text.replace(/[&<>"']/g, m => map[m]) : '';
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Action functions (placeholders for now)
function viewEvent(id) {
    showNotification('View event functionality coming soon', 'info');
}

function editEvent(id) {
    showNotification('Edit event functionality coming soon', 'info');
}

function deleteEvent(id) {
    if (confirm('Are you sure you want to delete this event?')) {
        showNotification('Delete event functionality coming soon', 'info');
    }
}

function editRegistration(id) {
    showNotification('Edit registration functionality coming soon', 'info');
}

function deleteRegistration(id) {
    if (confirm('Are you sure you want to delete this registration?')) {
        showNotification('Delete registration functionality coming soon', 'info');
    }
}

function viewFeedback(id) {
    showNotification('View feedback functionality coming soon', 'info');
}

function editFeedback(id) {
    showNotification('Edit feedback functionality coming soon', 'info');
}

function deleteFeedback(id) {
    if (confirm('Are you sure you want to delete this feedback?')) {
        showNotification('Delete feedback functionality coming soon', 'info');
    }
}

function viewMemory(id) {
    showNotification('View memory functionality coming soon', 'info');
}

function editMemory(id) {
    showNotification('Edit memory functionality coming soon', 'info');
}

function deleteMemory(id) {
    if (confirm('Are you sure you want to delete this memory?')) {
        showNotification('Delete memory functionality coming soon', 'info');
    }
}
