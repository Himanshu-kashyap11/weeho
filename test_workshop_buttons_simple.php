<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Workshop Button Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .workshop-btn { 
            background: #3b82f6; 
            color: white; 
            padding: 12px 24px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            margin: 10px;
            font-size: 16px;
        }
        .workshop-btn:hover { background: #2563eb; }
        
        /* Modal Styles */
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
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }
        
        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        
        .close:hover { color: #000; }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
    </style>
</head>
<body>
    <h1>🔧 Simple Workshop Button Test</h1>
    
    <div style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9;">
        <h2>Test Workshop Buttons</h2>
        <p>Click any button below to test the workshop modal:</p>
        
        <button class="workshop-btn" onclick="openWorkshopModal('workshop_music_appreciation')">
            Join Music Appreciation Classes
        </button>
        
        <button class="workshop-btn" onclick="openWorkshopModal('workshop_folk_arts')">
            Join Folk Arts & Crafts
        </button>
        
        <button class="workshop-btn" onclick="openWorkshopModal('workshop_performance_skills')">
            Join Performance Skills
        </button>
        
        <button class="workshop-btn" onclick="openWorkshopModal('workshop_cultural_history')">
            Join Cultural History Sessions
        </button>
        
        <button class="workshop-btn" onclick="openWorkshopModal('workshop_digital_arts')">
            Join Digital Arts Promotion
        </button>
    </div>
    
    <div style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f0f8ff;">
        <h2>Debug Information</h2>
        <button onclick="testJavaScript()" style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Test JavaScript</button>
        <div id="debugInfo"></div>
    </div>

    <!-- Workshop Registration Modal -->
    <div id="workshopModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeWorkshopModal()">&times;</span>
            <h2>Workshop Registration</h2>
            
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

    <script>
    // Workshop names mapping
    const workshopNames = {
        'workshop_music_appreciation': 'Music Appreciation Classes',
        'workshop_folk_arts': 'Folk Arts & Crafts',
        'workshop_performance_skills': 'Performance Skills',
        'workshop_cultural_history': 'Cultural History Sessions',
        'workshop_digital_arts': 'Digital Arts Promotion'
    };
    
    function openWorkshopModal(workshopId) {
        console.log('Opening workshop modal for:', workshopId);
        
        const modal = document.getElementById('workshopModal');
        const workshopIdInput = document.getElementById('workshopId');
        const workshopNameInput = document.getElementById('workshopName');
        
        // Set workshop ID and name
        workshopIdInput.value = workshopId;
        workshopNameInput.value = workshopNames[workshopId] || 'Unknown Workshop';
        
        // Show modal
        modal.style.display = 'block';
        
        // Focus on first input
        setTimeout(() => {
            document.getElementById('participantName').focus();
        }, 100);
        
        // Debug info
        document.getElementById('debugInfo').innerHTML = '<p style="color: green;">✓ Modal opened successfully for: ' + workshopNames[workshopId] + '</p>';
    }
    
    function closeWorkshopModal() {
        console.log('Closing workshop modal');
        
        const modal = document.getElementById('workshopModal');
        modal.style.display = 'none';
        
        // Reset form
        document.getElementById('workshopForm').reset();
        document.getElementById('workshopAlert').innerHTML = '';
        
        // Debug info
        document.getElementById('debugInfo').innerHTML = '<p style="color: blue;">✓ Modal closed successfully</p>';
    }
    
    function testJavaScript() {
        document.getElementById('debugInfo').innerHTML = '<p style="color: green;">✓ JavaScript is working perfectly!</p>';
        console.log('JavaScript test successful');
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('workshopModal');
        if (event.target == modal) {
            closeWorkshopModal();
        }
    }
    
    // Handle form submission
    document.getElementById('workshopForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const alertDiv = document.getElementById('workshopAlert');
        const submitBtn = e.target.querySelector('button[type="submit"]');
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Registering...';
        
        try {
            const formData = new FormData(this);
            
            const response = await fetch('workshop_registration.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alertDiv.innerHTML = '<div class="alert alert-success">' + result.message + '</div>';
                
                // Reset form after success
                setTimeout(() => {
                    this.reset();
                    closeWorkshopModal();
                }, 3000);
            } else {
                alertDiv.innerHTML = '<div class="alert alert-error">' + result.message + '</div>';
            }
        } catch (error) {
            console.error('Registration error:', error);
            alertDiv.innerHTML = '<div class="alert alert-error">An error occurred. Please try again.</div>';
        }
        
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.textContent = 'Register for Workshop';
    });
    
    // Log when page loads
    console.log('Workshop test page loaded successfully');
    console.log('Available functions:', typeof openWorkshopModal, typeof closeWorkshopModal);
    </script>
</body>
</html>
