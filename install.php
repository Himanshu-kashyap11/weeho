<?php
// Weeho Installation Script
// This script sets up the database and creates initial data

require_once 'api/Database.php';

$installation_log = [];

function logMessage($message, $type = 'info') {
    global $installation_log;
    $installation_log[] = [
        'message' => $message,
        'type' => $type,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

function createInitialData() {
    // Create sample events
    $events = [
        [
            'id' => 'event_' . time() . '_1001',
            'title' => 'Classical Dance Performance',
            'date' => '2024-10-15',
            'performer' => 'Priya Sharma',
            'city' => 'Mumbai',
            'description' => 'A mesmerizing classical dance performance showcasing traditional Indian art forms.'
        ],
        [
            'id' => 'event_' . time() . '_1002',
            'title' => 'Folk Music Concert',
            'date' => '2024-10-20',
            'performer' => 'Rajesh Kumar',
            'city' => 'Delhi',
            'description' => 'Experience the rich heritage of Indian folk music with renowned artist Rajesh Kumar.'
        ],
        [
            'id' => 'event_' . time() . '_1003',
            'title' => 'Cultural Festival',
            'date' => '2024-11-05',
            'performer' => 'Various Artists',
            'city' => 'Bangalore',
            'description' => 'A grand celebration of Indian culture featuring multiple art forms and performances.'
        ]
    ];

    // Create sample memories
    $memories = [
        [
            'id' => 'memory_' . time() . '_1001',
            'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500',
            'caption' => 'A magical evening of classical dance that transported the audience to ancient India'
        ],
        [
            'id' => 'memory_' . time() . '_1002',
            'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500',
            'caption' => 'The rhythmic beats of traditional drums echoing through the cultural center'
        ],
        [
            'id' => 'memory_' . time() . '_1003',
            'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500',
            'caption' => 'Colorful costumes and graceful movements telling stories of our heritage'
        ]
    ];

    // Save to JSON files
    file_put_contents('events.json', json_encode($events, JSON_PRETTY_PRINT));
    file_put_contents('memories.json', json_encode($memories, JSON_PRETTY_PRINT));
    file_put_contents('registrations.json', json_encode([], JSON_PRETTY_PRINT));
    file_put_contents('feedback.json', json_encode([], JSON_PRETTY_PRINT));
    file_put_contents('teamFeedback.json', json_encode([], JSON_PRETTY_PRINT));

    logMessage('Initial JSON data files created successfully', 'success');
}

// Handle installation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'install') {
        try {
            // Create database connection
            $db = new Database();
            $conn = $db->getConnection();
            
            if ($conn) {
                // Create tables
                if ($db->createTables()) {
                    logMessage('Database tables created successfully', 'success');
                } else {
                    logMessage('Failed to create database tables', 'error');
                }
            } else {
                logMessage('Database connection failed, using JSON file storage', 'warning');
            }
            
            // Create initial data
            createInitialData();
            
            logMessage('Installation completed successfully!', 'success');
            
        } catch (Exception $e) {
            logMessage('Installation failed: ' . $e->getMessage(), 'error');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weeho Installation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FF6B35, #F7931E);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .install-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
        }
        
        .install-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .install-header h1 {
            color: #1a202c;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .install-header p {
            color: #718096;
            font-size: 1.1rem;
        }
        
        .install-form {
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1a202c;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 16px;
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
        
        .log-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            max-height: 300px;
            overflow-y: auto;
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
        
        .requirements {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .requirements h3 {
            margin-bottom: 15px;
            color: #1a202c;
        }
        
        .req-item {
            display: flex;
            align-items: center;
            margin: 8px 0;
        }
        
        .req-status {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        .req-pass {
            background: #10b981;
            color: white;
        }
        
        .req-fail {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-header">
            <h1>🎭 Weeho Setup</h1>
            <p>Welcome to Weeho Cultural Events Platform Installation</p>
        </div>
        
        <?php if (empty($installation_log)): ?>
        <div class="requirements">
            <h3>System Requirements</h3>
            <div class="req-item">
                <div class="req-status <?php echo version_compare(PHP_VERSION, '7.0.0', '>=') ? 'req-pass' : 'req-fail'; ?>">
                    <?php echo version_compare(PHP_VERSION, '7.0.0', '>=') ? '✓' : '✗'; ?>
                </div>
                <span>PHP 7.0+ (Current: <?php echo PHP_VERSION; ?>)</span>
            </div>
            <div class="req-item">
                <div class="req-status <?php echo extension_loaded('json') ? 'req-pass' : 'req-fail'; ?>">
                    <?php echo extension_loaded('json') ? '✓' : '✗'; ?>
                </div>
                <span>JSON Extension</span>
            </div>
            <div class="req-item">
                <div class="req-status <?php echo is_writable('.') ? 'req-pass' : 'req-fail'; ?>">
                    <?php echo is_writable('.') ? '✓' : '✗'; ?>
                </div>
                <span>Write Permissions</span>
            </div>
            <div class="req-item">
                <div class="req-status <?php echo extension_loaded('pdo') ? 'req-pass' : 'req-fail'; ?>">
                    <?php echo extension_loaded('pdo') ? '✓' : '✗'; ?>
                </div>
                <span>PDO Extension (Optional for MySQL)</span>
            </div>
        </div>
        
        <form method="POST" class="install-form">
            <div class="form-group">
                <label>Installation Type</label>
                <select name="install_type" class="form-control">
                    <option value="json">JSON File Storage (Recommended)</option>
                    <option value="mysql">MySQL Database</option>
                </select>
            </div>
            
            <button type="submit" name="action" value="install" class="btn">
                🚀 Install Weeho Platform
            </button>
        </form>
        <?php endif; ?>
        
        <?php if (!empty($installation_log)): ?>
        <div class="log-container">
            <h3>Installation Log</h3>
            <?php foreach ($installation_log as $log): ?>
                <div class="log-item log-<?php echo $log['type']; ?>">
                    [<?php echo $log['timestamp']; ?>] <?php echo htmlspecialchars($log['message']); ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="index.php" class="btn" style="display: inline-block; text-decoration: none;">
                🏠 Go to Website
            </a>
            <a href="admin/" class="btn" style="display: inline-block; text-decoration: none; margin-left: 10px;">
                ⚙️ Admin Dashboard
            </a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
