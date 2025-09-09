<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Debug Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .test-btn { 
            background: #3b82f6; 
            color: white; 
            padding: 12px 24px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            margin: 10px;
            font-size: 16px;
        }
        .test-btn:hover { background: #2563eb; }
        
        /* Copy modal styles from about.php */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        
        .close:hover { color: #000; }
        
        .modal-body { padding: 30px; }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            margin: 5px;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }
    </style>
</head>
<body>
    <h1>🔧 Modal Debug Test</h1>
    
    <div class="debug-section">
        <h2>1. JavaScript Function Test</h2>
        <button class="test-btn" onclick="testJavaScriptWorking()">Test JavaScript</button>
        <div id="jsTest"></div>
    </div>
    
    <div class="debug-section">
        <h2>2. Modal Element Test</h2>
        <button class="test-btn" onclick="testModalElement()">Check Modal Element</button>
        <div id="modalTest"></div>
    </div>
    
    <div class="debug-section">
        <h2>3. Workshop Function Test</h2>
        <button class="test-btn" onclick="testWorkshopFunction()">Test openWorkshopModal</button>
        <div id="workshopTest"></div>
    </div>
    
    <div class="debug-section">
        <h2>4. Direct Modal Show Test</h2>
        <button class="test-btn" onclick="showModalDirectly()">Show Modal Directly</button>
        <button class="test-btn" onclick="hideModalDirectly()">Hide Modal</button>
        <div id="directTest"></div>
    </div>
    
    <div class="debug-section">
        <h2>5. Simulate Workshop Button Click</h2>
        <button class="test-btn" onclick="openWorkshopModal('workshop_music_appreciation')">
            Simulate: Join Music Appreciation
        </button>
        <button class="test-btn" onclick="openWorkshopModal('workshop_folk_arts')">
            Simulate: Join Folk Arts
        </button>
    </div>

    <!-- Workshop Registration Modal -->
    <div id="workshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Workshop Registration</h2>
                <span class="close" onclick="closeWorkshopModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div id="workshopAlert"></div>
                <form id="workshopForm">
                    <input type="hidden" id="workshopId" name="workshop_id">
                    
                    <div class="form-group">
                        <label for="workshopName">Workshop:</label>
                        <input type="text" id="workshopName" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="participantName">Your Name *</label>
                        <input type="text" id="participantName" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="participantEmail">Email Address *</label>
                        <input type="email" id="participantEmail" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="participantPhone">Phone Number</label>
                        <input type="tel" id="participantPhone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="experienceLevel">Experience Level</label>
                        <select id="experienceLevel" name="experience_level">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="preferredSchedule">Preferred Schedule</label>
                        <input type="text" id="preferredSchedule" name="preferred_schedule" placeholder="e.g., Weekends, Evenings">
                    </div>
                    
                    <div class="form-group">
                        <label for="specialRequirements">Special Requirements</label>
                        <textarea id="specialRequirements" name="special_requirements" rows="3" placeholder="Any special requirements or questions..."></textarea>
                    </div>
                    
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="button" class="btn btn-secondary" onclick="closeWorkshopModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Register for Workshop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Workshop names mapping
    const workshopNames = {
        'workshop_music_appreciation': 'Music Appreciation Classes',
        'workshop_folk_arts': 'Folk Arts & Crafts',
        'workshop_performance_skills': 'Performance Skills',
        'workshop_cultural_history': 'Cultural History Sessions',
        'workshop_digital_arts': 'Digital Arts Promotion'
    };
    
    function testJavaScriptWorking() {
        document.getElementById('jsTest').innerHTML = '<p class="success">✓ JavaScript is working!</p>';
        console.log('JavaScript test successful');
    }
    
    function testModalElement() {
        const modal = document.getElementById('workshopModal');
        if (modal) {
            document.getElementById('modalTest').innerHTML = '<p class="success">✓ Modal element found in DOM</p>';
            console.log('Modal element:', modal);
        } else {
            document.getElementById('modalTest').innerHTML = '<p class="error">✗ Modal element NOT found</p>';
        }
    }
    
    function testWorkshopFunction() {
        if (typeof openWorkshopModal === 'function') {
            document.getElementById('workshopTest').innerHTML = '<p class="success">✓ openWorkshopModal function exists</p>';
        } else {
            document.getElementById('workshopTest').innerHTML = '<p class="error">✗ openWorkshopModal function NOT found</p>';
        }
    }
    
    function showModalDirectly() {
        const modal = document.getElementById('workshopModal');
        if (modal) {
            modal.style.display = 'block';
            document.getElementById('directTest').innerHTML = '<p class="success">✓ Modal shown directly</p>';
        } else {
            document.getElementById('directTest').innerHTML = '<p class="error">✗ Cannot show modal - element not found</p>';
        }
    }
    
    function hideModalDirectly() {
        const modal = document.getElementById('workshopModal');
        if (modal) {
            modal.style.display = 'none';
            document.getElementById('directTest').innerHTML = '<p class="success">✓ Modal hidden directly</p>';
        }
    }
    
    function openWorkshopModal(workshopId) {
        console.log('openWorkshopModal called with:', workshopId);
        
        const modal = document.getElementById('workshopModal');
        const workshopIdInput = document.getElementById('workshopId');
        const workshopNameInput = document.getElementById('workshopName');
        
        if (!modal) {
            console.error('Modal element not found!');
            alert('Error: Modal element not found!');
            return;
        }
        
        if (!workshopIdInput || !workshopNameInput) {
            console.error('Form inputs not found!');
            alert('Error: Form inputs not found!');
            return;
        }
        
        // Set workshop ID and name
        workshopIdInput.value = workshopId;
        workshopNameInput.value = workshopNames[workshopId] || 'Unknown Workshop';
        
        // Show modal
        modal.style.display = 'block';
        console.log('Modal should now be visible');
        
        // Focus on first input
        setTimeout(() => {
            const nameInput = document.getElementById('participantName');
            if (nameInput) {
                nameInput.focus();
            }
        }, 100);
    }
    
    function closeWorkshopModal() {
        console.log('closeWorkshopModal called');
        
        const modal = document.getElementById('workshopModal');
        if (modal) {
            modal.style.display = 'none';
            
            // Reset form
            const form = document.getElementById('workshopForm');
            if (form) {
                form.reset();
            }
            
            const alert = document.getElementById('workshopAlert');
            if (alert) {
                alert.innerHTML = '';
            }
        }
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('workshopModal');
        if (event.target == modal) {
            closeWorkshopModal();
        }
    }
    
    // Log when page loads
    console.log('Debug page loaded');
    console.log('Modal element exists:', !!document.getElementById('workshopModal'));
    console.log('openWorkshopModal function exists:', typeof openWorkshopModal === 'function');
    </script>
</body>
</html>
