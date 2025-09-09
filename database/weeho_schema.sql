-- Weeho Cultural Events Platform Database Schema
-- MySQL Database Creation and Table Structure

-- Create Database
CREATE DATABASE IF NOT EXISTS weeho_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE weeho_db;

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    id VARCHAR(50) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    performer VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(500) DEFAULT NULL,
    status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (date),
    INDEX idx_city (city),
    INDEX idx_status (status)
);

-- Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    id VARCHAR(50) PRIMARY KEY,
    event_id VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    role VARCHAR(100) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    INDEX idx_event_id (event_id),
    INDEX idx_email (email),
    INDEX idx_status (status),
    UNIQUE KEY unique_event_email (event_id, email)
);

-- Event Feedback Table
CREATE TABLE IF NOT EXISTS feedback (
    id VARCHAR(50) PRIMARY KEY,
    event_id VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    feedback TEXT NOT NULL,
    status ENUM('active', 'hidden', 'flagged') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    INDEX idx_event_id (event_id),
    INDEX idx_rating (rating),
    INDEX idx_status (status)
);

-- Team Feedback Table
CREATE TABLE IF NOT EXISTS team_feedback (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    message TEXT NOT NULL,
    status ENUM('active', 'hidden', 'responded') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_rating (rating),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Memories Table
CREATE TABLE IF NOT EXISTS memories (
    id VARCHAR(50) PRIMARY KEY,
    title VARCHAR(255) DEFAULT NULL,
    image VARCHAR(500) NOT NULL,
    caption TEXT NOT NULL,
    event_id VARCHAR(50) DEFAULT NULL,
    status ENUM('active', 'hidden', 'featured') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_sort_order (sort_order),
    INDEX idx_event_id (event_id)
);

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'responded', 'archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'moderator', 'editor') DEFAULT 'moderator',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
);

-- Admin Sessions Table
CREATE TABLE IF NOT EXISTS admin_sessions (
    id VARCHAR(128) PRIMARY KEY,
    user_id INT NOT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_expires_at (expires_at)
);

-- System Settings Table
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT DEFAULT NULL,
    setting_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
);

-- Activity Log Table
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50) DEFAULT NULL,
    record_id VARCHAR(50) DEFAULT NULL,
    old_values JSON DEFAULT NULL,
    new_values JSON DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_table_name (table_name),
    INDEX idx_created_at (created_at)
);

-- Create Views for Common Queries

-- Events with Registration Count
CREATE VIEW events_with_stats AS
SELECT 
    e.*,
    COUNT(DISTINCT r.id) as registration_count,
    AVG(f.rating) as average_rating,
    COUNT(DISTINCT f.id) as feedback_count
FROM events e
LEFT JOIN registrations r ON e.id = r.event_id AND r.status = 'confirmed'
LEFT JOIN feedback f ON e.id = f.event_id AND f.status = 'active'
GROUP BY e.id;

-- Recent Activity View
CREATE VIEW recent_activity AS
SELECT 
    'event' as type,
    id,
    title as name,
    created_at,
    'New event created' as description
FROM events
UNION ALL
SELECT 
    'registration' as type,
    id,
    name,
    created_at,
    CONCAT('Registration for event: ', event_id) as description
FROM registrations
UNION ALL
SELECT 
    'feedback' as type,
    id,
    name,
    created_at,
    CONCAT('Feedback for event: ', event_id, ' (Rating: ', rating, '/5)') as description
FROM feedback
UNION ALL
SELECT 
    'team_feedback' as type,
    id,
    name,
    created_at,
    CONCAT('Team feedback (Rating: ', rating, '/5)') as description
FROM team_feedback
ORDER BY created_at DESC;

-- Dashboard Statistics View
CREATE VIEW dashboard_stats AS
SELECT 
    (SELECT COUNT(*) FROM events WHERE status = 'upcoming') as upcoming_events,
    (SELECT COUNT(*) FROM events WHERE status = 'completed') as completed_events,
    (SELECT COUNT(*) FROM registrations WHERE status = 'confirmed') as total_registrations,
    (SELECT COUNT(*) FROM feedback WHERE status = 'active') as total_feedback,
    (SELECT ROUND(AVG(rating), 2) FROM feedback WHERE status = 'active') as average_rating,
    (SELECT COUNT(*) FROM team_feedback WHERE status = 'active') as team_feedback_count,
    (SELECT COUNT(*) FROM contact_messages WHERE status = 'new') as unread_messages;
