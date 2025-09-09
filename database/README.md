# Weeho Database Setup Guide

This directory contains all the database-related files for the Weeho Cultural Events Platform.

## Files Overview

### 1. `weeho_schema.sql`
Complete MySQL database schema with:
- **9 main tables**: events, registrations, feedback, team_feedback, memories, contact_messages, admin_users, admin_sessions, system_settings
- **Activity logging**: activity_log table for audit trail
- **Database views**: Pre-built views for common queries and statistics
- **Indexes**: Optimized indexes for better performance
- **Foreign keys**: Proper relationships between tables

### 2. `sample_data.sql`
Sample data for testing and demonstration:
- 6 sample events (5 upcoming, 1 completed)
- Sample registrations and feedback
- Team feedback entries
- Memory gallery items
- Contact messages
- Default admin users (admin/admin, moderator/moderator)
- System settings

### 3. `database_config.php`
Database configuration and helper classes:
- **DatabaseConnection**: Singleton pattern for MySQL connection
- **DatabaseHelper**: Common database operations (CRUD, transactions)
- **DatabaseMigration**: SQL file execution and migration management
- Connection pooling and error handling

### 4. `setup.php`
Web-based database setup interface:
- Visual setup wizard with status indicators
- Automatic schema and sample data installation
- Configuration validation
- Setup logging and error reporting

## Quick Setup Instructions

### Method 1: Web Interface (Recommended)
1. Navigate to `http://your-domain/database/setup.php`
2. Click "Run Database Setup"
3. Follow the on-screen instructions

### Method 2: Manual Setup
1. Create MySQL database: `CREATE DATABASE weeho_db;`
2. Import schema: `mysql -u root -p weeho_db < weeho_schema.sql`
3. Import sample data: `mysql -u root -p weeho_db < sample_data.sql`

### Method 3: Command Line
```bash
# Navigate to database directory
cd database/

# Run MySQL commands
mysql -u root -p -e "CREATE DATABASE weeho_db;"
mysql -u root -p weeho_db < weeho_schema.sql
mysql -u root -p weeho_db < sample_data.sql
```

## Database Configuration

Update these constants in `database_config.php`:

```php
define('DB_HOST', 'localhost');     // Database host
define('DB_NAME', 'weeho_db');      // Database name
define('DB_USER', 'root');          // Database username
define('DB_PASS', '');              // Database password
define('DB_CHARSET', 'utf8mb4');    // Character set
```

## Database Structure

### Core Tables

#### Events
- Primary table for cultural events
- Fields: id, title, date, performer, city, description, status
- Relationships: One-to-many with registrations, feedback, memories

#### Registrations
- Event registration management
- Fields: id, event_id, name, email, phone, role, city, status
- Unique constraint: event_id + email (prevents duplicates)

#### Feedback
- Event feedback and ratings
- Fields: id, event_id, name, email, rating (1-5), feedback, status
- Average ratings calculated in views

#### Team Feedback
- General platform feedback
- Fields: id, name, email, rating, message, status

#### Memories
- Photo gallery for spotlight page
- Fields: id, title, image, caption, event_id, status, sort_order

### Admin Tables

#### Admin Users
- Admin authentication
- Default users: admin/admin, moderator/moderator
- Password: "password" (change in production!)

#### Admin Sessions
- Session management for admin dashboard
- Automatic cleanup of expired sessions

#### System Settings
- Configurable site settings
- Key-value pairs with type validation

### Utility Tables

#### Contact Messages
- Contact form submissions
- Status tracking: new, read, responded, archived

#### Activity Log
- Audit trail for admin actions
- JSON storage for old/new values

## Database Views

### `events_with_stats`
Events with registration count, average rating, and feedback count

### `recent_activity`
Combined recent activity from all tables

### `dashboard_stats`
Pre-calculated statistics for admin dashboard

## Security Features

- **Prepared statements**: All queries use parameter binding
- **Input validation**: Data sanitization and validation
- **Password hashing**: bcrypt for admin passwords
- **Session management**: Secure session handling
- **SQL injection protection**: PDO with prepared statements
- **XSS protection**: Output escaping

## Performance Optimizations

- **Indexes**: Strategic indexes on frequently queried columns
- **Connection pooling**: Singleton database connection
- **Query optimization**: Efficient joins and subqueries
- **Caching**: Views for complex calculations

## Backup and Maintenance

### Backup Commands
```bash
# Full database backup
mysqldump -u root -p weeho_db > backup_$(date +%Y%m%d).sql

# Structure only
mysqldump -u root -p --no-data weeho_db > structure_backup.sql

# Data only
mysqldump -u root -p --no-create-info weeho_db > data_backup.sql
```

### Maintenance Tasks
- Regular backup of database
- Clean up old admin sessions
- Archive old activity logs
- Monitor database size and performance

## Troubleshooting

### Common Issues

1. **Connection Failed**
   - Check MySQL service is running
   - Verify credentials in `database_config.php`
   - Ensure database exists

2. **Permission Denied**
   - Grant proper MySQL privileges
   - Check file permissions on PHP files

3. **Character Encoding Issues**
   - Ensure utf8mb4 charset is used
   - Check MySQL configuration

4. **Migration Errors**
   - Check SQL syntax in schema file
   - Verify MySQL version compatibility
   - Review error logs

### Error Logs
- PHP errors: Check server error logs
- MySQL errors: Check MySQL error log
- Application logs: Check `activity_log` table

## Development Notes

- All IDs use string format for flexibility
- Timestamps include timezone support (IST +05:30)
- JSON fields for flexible data storage
- Enum fields for status management
- Foreign key constraints maintain data integrity

## Production Deployment

1. **Change default passwords**
2. **Set up regular backups**
3. **Configure proper MySQL user privileges**
4. **Enable MySQL slow query log**
5. **Set up monitoring and alerts**
6. **Use environment variables for sensitive config**

For support or questions, refer to the main project documentation.
