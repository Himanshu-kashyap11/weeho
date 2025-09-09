# XAMPP Setup Guide for Weeho Project

## Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP with Apache and PHP enabled
3. Start Apache from XAMPP Control Panel

## Step 2: Copy Project Files
1. Copy the entire `weeeewwwooo` folder to `C:\xampp\htdocs\`
2. Your project path should be: `C:\xampp\htdocs\weeeewwwooo\`

## Step 3: Set File Permissions
1. Right-click on the `weeeewwwooo` folder
2. Go to Properties → Security
3. Give "Full Control" to "Users" group
4. This allows PHP to read/write JSON files

## Step 4: Access the Website
Open your browser and go to:
```
http://localhost/weeeewwwooo/
```

## Step 5: Test Form Submissions

### Event Registration:
1. Go to Events page
2. Click "Register" on any event
3. Fill the form and submit
4. Data will be saved to `registrations.json`

### Event Feedback:
1. Click "Give Feedback" on any event
2. Fill the form and submit
3. Data will be saved to `feedback.json`

### Team Feedback:
1. Go to Team Feedback page
2. Fill and submit the form
3. Data will be saved to `teamFeedback.json`

### Contact Form:
1. Go to Contact page
2. Fill and submit the form
3. Data will be saved to `contacts.json`

## Step 6: View Submitted Data

### Method 1: Check JSON Files Directly
Navigate to your project folder and open these files in a text editor:
- `registrations.json` - Event registrations
- `feedback.json` - Event feedback
- `teamFeedback.json` - Team feedback
- `contacts.json` - Contact messages

### Method 2: Create Admin Panel (Optional)
Access the admin panel at:
```
http://localhost/weeeewwwooo/admin/
```

## Troubleshooting

### If forms don't submit:
1. Check XAMPP Apache is running
2. Check browser console for JavaScript errors
3. Verify file permissions on project folder

### If data doesn't save:
1. Check if JSON files exist and are writable
2. Look at Apache error logs in XAMPP
3. Ensure PHP has write permissions

### Common Issues:
- **403 Forbidden**: Check file permissions
- **500 Internal Error**: Check PHP syntax in files
- **AJAX errors**: Ensure all PHP files are accessible

## File Structure
```
weeeewwwooo/
├── index.php (Homepage)
├── events.php (Events page)
├── about.php (About page)
├── spotlight.php (Spotlight page)
├── teamFeedback.php (Team Feedback page)
├── contact.php (Contact page)
├── config.php (Configuration)
├── main.css (Styles)
├── script.js (JavaScript)
├── register.php (Registration handler)
├── feedback.php (Feedback handler)
├── uploadEvent.php (Event upload handler)
├── teamFeedbackAPI.php (Team feedback handler)
├── contact_handler.php (Contact handler)
├── events.json (Events data)
├── memories.json (Gallery images)
├── registrations.json (Registration data)
├── feedback.json (Feedback data)
├── teamFeedback.json (Team feedback data)
├── contacts.json (Contact messages)
└── admin/ (Admin panel)
```

## Success Indicators
- Forms submit without errors
- Success messages appear after submission
- JSON files contain new data entries
- Pages load correctly without PHP errors
