# Weeho Website Testing Checklist

## 🚀 Pre-Testing Setup
- [ ] XAMPP Apache service is running
- [ ] Project copied to `C:\xampp\htdocs\weeeewwwooo\`
- [ ] All file permissions set correctly

## 🌐 Basic Website Access
- [ ] Homepage loads: `http://localhost/weeeewwwooo/`
- [ ] No PHP fatal errors displayed
- [ ] CSS styles loading properly
- [ ] Navigation menu functional
- [ ] Responsive design works on mobile

## 📄 Page Navigation Testing
- [ ] **Home Page** (`index.php`) - Events display, hero section
- [ ] **Events Page** (`events.php`) - Event grid, upload form
- [ ] **About Page** (`about.php`) - Mission, team, workshops
- [ ] **Spotlight Page** (`spotlight.php`) - Memories gallery, performances
- [ ] **Team Feedback Page** (`teamFeedback.php`) - Feedback form and list
- [ ] **Contact Page** (`contact.php`) - Contact form and info

## 📝 Form Functionality Testing

### Event Registration Forms
- [ ] Click "Register" on any event card
- [ ] Fill out registration modal form
- [ ] Submit form successfully
- [ ] Success message displays
- [ ] Data saved to `registrations.json`
- [ ] Modal closes after submission

### Event Feedback Forms
- [ ] Click "Give Feedback" on any event card
- [ ] Fill out feedback modal form with rating
- [ ] Submit form successfully
- [ ] Success message displays
- [ ] Data saved to `feedback.json`
- [ ] Modal closes after submission

### Event Upload Form
- [ ] Navigate to Events page
- [ ] Fill out "Upload New Event" form
- [ ] Submit form successfully
- [ ] New event appears in event grid
- [ ] Data saved to `events.json`

### Contact Form
- [ ] Navigate to Contact page
- [ ] Fill out contact form
- [ ] Submit form successfully
- [ ] Success message displays
- [ ] Data saved to `contacts.json`

### Team Feedback Form
- [ ] Navigate to Team Feedback page
- [ ] Fill out feedback form with rating
- [ ] Submit form successfully
- [ ] Feedback appears in feedback list
- [ ] Data saved to `teamFeedback.json`

## 🔧 Admin Panel Testing
- [ ] Access admin panel: `http://localhost/weeeewwwooo/admin/`
- [ ] Login with credentials: `admin` / `admin123`
- [ ] Dashboard displays statistics correctly
- [ ] Recent registrations table shows data
- [ ] Recent feedback table shows data
- [ ] Recent contacts table shows data
- [ ] Recent team feedback table shows data
- [ ] Logout functionality works

## 📊 Data Persistence Testing
- [ ] Check `registrations.json` for new entries
- [ ] Check `feedback.json` for new entries
- [ ] Check `events.json` for uploaded events
- [ ] Check `contacts.json` for contact messages
- [ ] Check `teamFeedback.json` for team feedback
- [ ] Verify JSON structure is valid

## 🎨 UI/UX Testing
- [ ] All buttons have hover effects
- [ ] Modal forms open/close properly
- [ ] Form validation works (required fields)
- [ ] Success/error messages display correctly
- [ ] Images load properly
- [ ] Testimonials slider works
- [ ] Memories gallery modal works
- [ ] Mobile hamburger menu functions

## 🔍 Error Handling Testing
- [ ] Submit empty forms (validation should prevent)
- [ ] Submit invalid email addresses
- [ ] Test with JavaScript disabled
- [ ] Check browser console for errors
- [ ] Test form submissions with special characters

## 🌍 Cross-Browser Testing
- [ ] Test in Chrome
- [ ] Test in Firefox
- [ ] Test in Edge
- [ ] Test on mobile devices

## 📱 Mobile Responsiveness
- [ ] Navigation collapses to hamburger menu
- [ ] Forms are usable on mobile
- [ ] Text is readable without zooming
- [ ] Buttons are tap-friendly
- [ ] Images scale properly

## 🔧 Diagnostic Tools
- [ ] Run diagnostic: `http://localhost/weeeewwwooo/test.php`
- [ ] Check PHP configuration
- [ ] Verify all JSON files exist and are writable
- [ ] Check Apache error logs if issues occur

## ✅ Final Verification
- [ ] All forms submit data successfully
- [ ] Admin panel shows all submitted data
- [ ] No PHP errors in browser or logs
- [ ] Website is fully functional
- [ ] Ready for production deployment

---

## 🚨 Common Issues & Solutions

**If forms don't submit:**
- Check XAMPP Apache is running
- Verify file permissions (755 for folders, 644 for files)
- Check browser console for JavaScript errors

**If admin panel doesn't work:**
- Clear browser cache
- Check session configuration in PHP
- Verify admin credentials: admin/admin123

**If JSON files don't update:**
- Check file permissions
- Ensure JSON files are writable
- Verify PHP has write access to project directory

**If CSS doesn't load:**
- Check file paths in HTML
- Clear browser cache
- Verify CSS files exist in project directory
