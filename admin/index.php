<?php
session_start();
require_once '../config.php';

// Simple admin authentication
$isLoggedIn = false;
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $isLoggedIn = true;
    }
} elseif (isset($_SESSION['admin_logged_in'])) {
    $isLoggedIn = true;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Get dashboard data if logged in
$stats = [];
$recentActivity = [];
if ($isLoggedIn) {
    try {
        $stats = getAdminStats();
        $recentActivity = getRecentActivity(10);
    } catch (Exception $e) {
        $error = 'Database connection error. Please run setup_database.php first.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weeho Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <?php if (!$isLoggedIn): ?>
    <!-- Login Form -->
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Weeho Admin</h1>
                <p>Sign in to access the dashboard</p>
            </div>
            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            <div class="login-info">
                <p><strong>Default Credentials:</strong></p>
                <p>Admin: admin / weeho2024</p>
                <p>Moderator: moderator / weeho123</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Admin Dashboard -->
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Weeho Admin</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#dashboard" class="menu-link active" data-section="dashboard">Dashboard</a></li>
                <li><a href="#events" class="menu-link" data-section="events">Events</a></li>
                <li><a href="#registrations" class="menu-link" data-section="registrations">Registrations</a></li>
                <li><a href="#feedback" class="menu-link" data-section="feedback">Feedback</a></li>
                <li><a href="#memories" class="menu-link" data-section="memories">Memories</a></li>
                <li><a href="#settings" class="menu-link" data-section="settings">Settings</a></li>
            </ul>
            <div class="sidebar-footer">
                <button id="logoutBtn" class="btn btn-secondary">Logout</button>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Dashboard Section -->
            <section id="dashboard-section" class="admin-section active">
                <div class="section-header">
                    <h1>Dashboard</h1>
                    <p>Overview of your Weeho platform</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🎭</div>
                        <div class="stat-content">
                            <h3 id="totalEvents">0</h3>
                            <p>Total Events</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-content">
                            <h3 id="totalRegistrations">0</h3>
                            <p>Registrations</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">💬</div>
                        <div class="stat-content">
                            <h3 id="totalFeedback">0</h3>
                            <p>Feedback</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-content">
                            <h3 id="averageRating">0</h3>
                            <p>Avg Rating</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-content">
                    <div class="recent-activity">
                        <h2>Recent Events</h2>
                        <div id="recentEvents" class="activity-list"></div>
                    </div>
                    <div class="recent-activity">
                        <h2>Recent Registrations</h2>
                        <div id="recentRegistrations" class="activity-list"></div>
                    </div>
                </div>
            </section>

            <!-- Events Section -->
            <section id="events-section" class="admin-section">
                <div class="section-header">
                    <h1>Events Management</h1>
                    <button id="addEventBtn" class="btn btn-primary">Add New Event</button>
                </div>
                <div id="eventsTable" class="data-table"></div>
            </section>

            <!-- Registrations Section -->
            <section id="registrations-section" class="admin-section">
                <div class="section-header">
                    <h1>Registrations Management</h1>
                </div>
                <div id="registrationsTable" class="data-table"></div>
            </section>

            <!-- Feedback Section -->
            <section id="feedback-section" class="admin-section">
                <div class="section-header">
                    <h1>Feedback Management</h1>
                </div>
                <div id="feedbackTable" class="data-table"></div>
            </section>

            <!-- Memories Section -->
            <section id="memories-section" class="admin-section">
                <div class="section-header">
                    <h1>Memories Management</h1>
                    <button id="addMemoryBtn" class="btn btn-primary">Add New Memory</button>
                </div>
                <div id="memoriesTable" class="data-table"></div>
            </section>

            <!-- Settings Section -->
            <section id="settings-section" class="admin-section">
                <div class="section-header">
                    <h1>Settings</h1>
                </div>
                <div class="settings-content">
                    <div class="setting-group">
                        <h3>Data Management</h3>
                        <button id="exportDataBtn" class="btn btn-secondary">Export All Data</button>
                        <button id="backupDataBtn" class="btn btn-secondary">Backup Data</button>
                    </div>
                    <div class="setting-group">
                        <h3>System Information</h3>
                        <p>PHP Version: <?php echo phpversion(); ?></p>
                        <p>Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <?php endif; ?>

    <!-- Modal for Add/Edit Forms -->
    <div id="adminModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Item</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="adminForm"></form>
            </div>
        </div>
    </div>

    <script src="admin-script.js"></script>
</body>
</html>
