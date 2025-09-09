<?php
/**
 * Debug workshop button functionality on live site
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Workshop Button Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .debug-btn{background:#007bff;color:white;padding:10px 15px;border:none;cursor:pointer;margin:5px;}</style>";
echo "</head><body>";

echo "<h1>🔧 Workshop Button Debug</h1>";

// Check if about.php exists and is readable
echo "<div class='test-section'>";
echo "<h2>1. File Check</h2>";

if (file_exists('about.php')) {
    echo "<p class='success'>✓ about.php exists</p>";
    
    $content = file_get_contents('about.php');
    if ($content) {
        echo "<p class='success'>✓ about.php is readable</p>";
        
        // Check for workshop buttons
        $button_count = substr_count($content, 'onclick="openWorkshopModal');
        echo "<p class='success'>✓ Found {$button_count} workshop buttons with onclick handlers</p>";
        
        // Check for modal
        if (strpos($content, 'id="workshopModal"') !== false) {
            echo "<p class='success'>✓ Workshop modal found</p>";
        } else {
            echo "<p class='error'>✗ Workshop modal missing</p>";
        }
        
        // Check for JavaScript functions
        if (strpos($content, 'function openWorkshopModal') !== false) {
            echo "<p class='success'>✓ openWorkshopModal function found</p>";
        } else {
            echo "<p class='error'>✗ openWorkshopModal function missing</p>";
        }
        
    } else {
        echo "<p class='error'>✗ Cannot read about.php</p>";
    }
} else {
    echo "<p class='error'>✗ about.php not found</p>";
}

echo "</div>";

// Test JavaScript console errors
echo "<div class='test-section'>";
echo "<h2>2. JavaScript Test</h2>";
echo "<p>Click the button below to test if JavaScript is working:</p>";
echo "<button class='debug-btn' onclick='testJavaScript()'>Test JavaScript</button>";
echo "<div id='jsResult'></div>";

echo "<script>";
echo "function testJavaScript() {";
echo "  document.getElementById('jsResult').innerHTML = '<p class=\"success\">✓ JavaScript is working!</p>';";
echo "}";
echo "</script>";

echo "</div>";

// Test modal functionality
echo "<div class='test-section'>";
echo "<h2>3. Modal Test</h2>";
echo "<p>Test the workshop modal directly:</p>";
echo "<button class='debug-btn' onclick='testModal()'>Test Modal</button>";
echo "<div id='modalResult'></div>";

echo "<script>";
echo "function testModal() {";
echo "  try {";
echo "    // Try to find modal";
echo "    const modal = document.getElementById('workshopModal');";
echo "    if (modal) {";
echo "      document.getElementById('modalResult').innerHTML = '<p class=\"success\">✓ Modal element found</p>';";
echo "      // Try to show modal";
echo "      modal.style.display = 'block';";
echo "      setTimeout(() => { modal.style.display = 'none'; }, 2000);";
echo "    } else {";
echo "      document.getElementById('modalResult').innerHTML = '<p class=\"error\">✗ Modal element not found</p>';";
echo "    }";
echo "  } catch (error) {";
echo "    document.getElementById('modalResult').innerHTML = '<p class=\"error\">✗ Error: ' + error.message + '</p>';";
echo "  }";
echo "}";
echo "</script>";

echo "</div>";

// Test workshop function
echo "<div class='test-section'>";
echo "<h2>4. Workshop Function Test</h2>";
echo "<p>Test the openWorkshopModal function:</p>";
echo "<button class='debug-btn' onclick='testWorkshopFunction()'>Test Workshop Function</button>";
echo "<div id='workshopResult'></div>";

echo "<script>";
echo "function testWorkshopFunction() {";
echo "  try {";
echo "    if (typeof openWorkshopModal === 'function') {";
echo "      document.getElementById('workshopResult').innerHTML = '<p class=\"success\">✓ openWorkshopModal function exists</p>';";
echo "      // Try to call it";
echo "      openWorkshopModal('workshop_music_appreciation');";
echo "    } else {";
echo "      document.getElementById('workshopResult').innerHTML = '<p class=\"error\">✗ openWorkshopModal function not found</p>';";
echo "    }";
echo "  } catch (error) {";
echo "    document.getElementById('workshopResult').innerHTML = '<p class=\"error\">✗ Error calling function: ' + error.message + '</p>';";
echo "  }";
echo "}";
echo "</script>";

echo "</div>";

// Live about.php test
echo "<div class='test-section'>";
echo "<h2>5. Live About.php Test</h2>";
echo "<p>Open about.php in a new tab to test the actual buttons:</p>";
echo "<p><a href='about.php' target='_blank' style='background:#28a745;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;font-weight:bold;'>🔗 Open About.php</a></p>";
echo "<p><small>Look for JavaScript console errors in browser developer tools (F12)</small></p>";
echo "</div>";

// Browser console check instructions
echo "<div class='test-section'>";
echo "<h2>6. Browser Console Check</h2>";
echo "<p>To check for JavaScript errors:</p>";
echo "<ol>";
echo "<li>Open about.php in your browser</li>";
echo "<li>Press F12 to open Developer Tools</li>";
echo "<li>Go to the 'Console' tab</li>";
echo "<li>Click a 'Join Workshop' button</li>";
echo "<li>Check for any red error messages</li>";
echo "</ol>";

echo "<h3>Common Issues:</h3>";
echo "<ul>";
echo "<li><strong>Function not defined:</strong> JavaScript not loaded properly</li>";
echo "<li><strong>Modal not found:</strong> HTML structure issue</li>";
echo "<li><strong>Click not working:</strong> CSS z-index or positioning issue</li>";
echo "<li><strong>Form pending:</strong> AJAX request failing</li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";
?>
