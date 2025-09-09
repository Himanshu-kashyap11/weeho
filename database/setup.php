<?php
/**
 * Database Setup Script for Weeho Cultural Events Platform
 * This script handles database creation, migration, and initial setup
 */

require_once 'database_config.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session for status messages
session_start();

$setupLog = [];
$setupStatus = 'pending';

function logSetupMessage($message, $type = 'info') {
    global $setupLog;
    $setupLog[] = [
        'message' => $message,
        'type' => $type,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

function runDatabaseSetup() {
    global $setupStatus;
    
    try {
        logSetupMessage('Starting database setup...', 'info');
        
        // Test database connection
        if (!testDatabaseConnection()) {
            throw new Exception('Cannot connect to database. Please check your configuration.');
        }
        
        logSetupMessage('Database connection successful', 'success');
        
        // Initialize migration helper
        $migration = new DatabaseMigration();
        
        // Check current status
        $status = $migration->getMigrationStatus();
        
        if ($status['tables_created']) {
            logSetupMessage('Database tables already exist', 'warning');
        } else {
            // Run schema migration
            logSetupMessage('Creating database tables...', 'info');
            $schemaFile = __DIR__ . '/weeho_schema.sql';
            
            if (!file_exists($schemaFile)) {
                throw new Exception('Schema file not found: ' . $schemaFile);
            }
            
            $migration->runMigration($schemaFile);
            logSetupMessage('Database tables created successfully', 'success');
        }
        
        // Load sample data if not already loaded
        if (!$status['sample_data_loaded']) {
            logSetupMessage('Loading sample data...', 'info');
            $sampleDataFile = __DIR__ . '/sample_data.sql';
            
            if (file_exists($sampleDataFile)) {
                $migration->runMigration($sampleDataFile);
                logSetupMessage('Sample data loaded successfully', 'success');
            } else {
                logSetupMessage('Sample data file not found, skipping...', 'warning');
            }
        } else {
            logSetupMessage('Sample data already exists', 'warning');
        }
        
        // Verify setup
        $finalStatus = $migration->getMigrationStatus();
        if ($finalStatus['ready']) {
            logSetupMessage('Database setup completed successfully!', 'success');
            $setupStatus = 'success';
        } else {
            throw new Exception('Database setup verification failed');
        }
        
    } catch (Exception $e) {
        logSetupMessage('Setup failed: ' . $e->getMessage(), 'error');
        $setupStatus = 'error';
    }
}

// Handle setup request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'setup') {
    runDatabaseSetup();
}

// Get current database status
$currentStatus = null;
try {
    $migration = new DatabaseMigration();
    $currentStatus = $migration->getMigrationStatus();
} catch (Exception $e) {
    // Database connection failed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weeho Database Setup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #FF6B35, #F7931E);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .setup-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 700px;
        }
        
        .setup-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .setup-header h1 {
            color: #1a202c;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .setup-header p {
            color: #718096;
            font-size: 1.1rem;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .status-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .status-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-error {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-pending {
            background: #e0e7ff;
            color: #3730a3;
        }
        
        .status-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .btn {
            background: linear-gradient(135deg, #FF6B35, #F7931E);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .log-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 20px;
        }
        
        .log-item {
            padding: 8px 12px;
            margin: 5px 0;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .log-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .log-error {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .log-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .log-info {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .config-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .config-info h3 {
            margin-bottom: 15px;
            color: #1a202c;
        }
        
        .config-item {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        
        .actions a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        
        .actions a:hover {
            background: #4f46e5;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1>🎭 Weeho Database Setup</h1>
            <p>Configure your database for the cultural events platform</p>
        </div>
        
        <?php if ($currentStatus): ?>
        <div class="status-grid">
            <div class="status-card <?php echo $currentStatus['database_exists'] ? 'status-success' : 'status-error'; ?>">
                <div class="status-icon"><?php echo $currentStatus['database_exists'] ? '✅' : '❌'; ?></div>
                <h4>Database Connection</h4>
                <p><?php echo $currentStatus['database_exists'] ? 'Connected' : 'Failed'; ?></p>
            </div>
            
            <div class="status-card <?php echo $currentStatus['tables_created'] ? 'status-success' : 'status-pending'; ?>">
                <div class="status-icon"><?php echo $currentStatus['tables_created'] ? '✅' : '⏳'; ?></div>
                <h4>Tables Created</h4>
                <p><?php echo $currentStatus['tables_created'] ? 'Complete' : 'Pending'; ?></p>
            </div>
            
            <div class="status-card <?php echo $currentStatus['sample_data_loaded'] ? 'status-success' : 'status-pending'; ?>">
                <div class="status-icon"><?php echo $currentStatus['sample_data_loaded'] ? '✅' : '⏳'; ?></div>
                <h4>Sample Data</h4>
                <p><?php echo $currentStatus['sample_data_loaded'] ? 'Loaded' : 'Pending'; ?></p>
            </div>
            
            <div class="status-card <?php echo $currentStatus['ready'] ? 'status-success' : 'status-warning'; ?>">
                <div class="status-icon"><?php echo $currentStatus['ready'] ? '🚀' : '⚠️'; ?></div>
                <h4>System Status</h4>
                <p><?php echo $currentStatus['ready'] ? 'Ready' : 'Setup Required'; ?></p>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="config-info">
            <h3>Database Configuration</h3>
            <div class="config-item">
                <span>Host:</span>
                <span><?php echo DB_HOST; ?></span>
            </div>
            <div class="config-item">
                <span>Database:</span>
                <span><?php echo DB_NAME; ?></span>
            </div>
            <div class="config-item">
                <span>Username:</span>
                <span><?php echo DB_USER; ?></span>
            </div>
            <div class="config-item">
                <span>Charset:</span>
                <span><?php echo DB_CHARSET; ?></span>
            </div>
            <?php 
            $dbInfo = getDatabaseInfo();
            if ($dbInfo): 
            ?>
            <div class="config-item">
                <span>MySQL Version:</span>
                <span><?php echo $dbInfo['version']; ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if (!$currentStatus || !$currentStatus['ready']): ?>
        <form method="POST">
            <button type="submit" name="action" value="setup" class="btn">
                🔧 Run Database Setup
            </button>
        </form>
        <?php endif; ?>
        
        <?php if (!empty($setupLog)): ?>
        <div class="log-container">
            <h3>Setup Log</h3>
            <?php foreach ($setupLog as $log): ?>
                <div class="log-item log-<?php echo $log['type']; ?>">
                    [<?php echo $log['timestamp']; ?>] <?php echo htmlspecialchars($log['message']); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($setupStatus === 'success' || ($currentStatus && $currentStatus['ready'])): ?>
        <div class="actions">
            <a href="../index.php">🏠 Go to Website</a>
            <a href="../admin/">⚙️ Admin Dashboard</a>
            <a href="../install.php">📋 Installation Guide</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
