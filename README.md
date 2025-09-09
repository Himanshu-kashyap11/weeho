# Weeho - Cultural Events Platform

A complete cultural events platform built with PHP, featuring event management, user registration, feedback system, and modern responsive design.

## 🚀 How to Run This Project

### Method 1: PHP Built-in Server (Recommended)
```bash
# Navigate to project directory
cd "C:\Users\Himanshu Kashyap\Desktop\weeeewwwooo"

# Start PHP development server
php -S localhost:8000

# Open browser and visit:
# http://localhost:8000
```

### Method 2: XAMPP/WAMP
1. Install XAMPP or WAMP
2. Copy project folder to `htdocs` directory
3. Start Apache server
4. Visit: `http://localhost/weeeewwwooo`

### Method 3: Live Server (VS Code)
1. Install "Live Server" extension
2. Right-click on `index.php`
3. Select "Open with Live Server"

## 📁 Project Structure

```
weeeewwwooo/
├── index.php           # Homepage
├── events.php          # Events page with registration/feedback
├── contact.php         # Contact page
├── about.php           # About page
├── blogs.php           # Blogs page
├── spotlight.php       # Artist spotlight page
├── register.php        # Registration backend API
├── feedback.php        # Feedback backend API
├── config.php          # Site configuration
├── events.json         # Events data
├── registrations.json  # User registrations (auto-created)
├── feedback.json       # Feedback data (auto-created)
├── styles.css          # All CSS styles
├── script.js           # JavaScript functionality
└── README.md           # This file
```

## ✨ Features

### Frontend Features
- **Responsive Design**: Works on all devices
- **Modern UI**: Orange-yellow-red theme with smooth animations
- **Dynamic Content**: Events loaded from JSON
- **Modal Forms**: Registration and feedback forms
- **AJAX Submissions**: No page reloads
- **Toast Notifications**: Success/error messages with animations

### Backend Features
- **Event Management**: Dynamic event loading from JSON
- **User Registration**: Complete registration system with validation
- **Feedback System**: Event feedback and contact form handling
- **Data Storage**: JSON-based data persistence
- **API Endpoints**: RESTful PHP APIs for forms
- **Security**: Input sanitization and validation

## File Structure

```
weeeewwwooo/
├── index.php          # Main website file
├── styles.css         # All CSS styles and responsive design
├── script.js          # JavaScript functionality
├── contact.php        # Contact form handler
├── config.php         # PHP configuration and helper functions
├── contacts.log       # Contact form submissions log
└── README.md          # This documentation
```

## Setup Instructions

1. **Web Server**: Ensure you have a web server with PHP support (Apache, Nginx, XAMPP, etc.)
2. **PHP Version**: Requires PHP 7.0 or higher
3. **File Permissions**: Ensure write permissions for `contacts.log` file

### Local Development
```bash
# Using PHP built-in server
php -S localhost:8000

# Or place files in your web server directory
# Example: C:\xampp\htdocs\weeho\
```

## Configuration

Edit `config.php` to customize:
- Site name and tagline
- Contact information
- Social media URLs
- Event and blog content

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Responsive Breakpoints

- **Desktop**: 1200px and above
- **Tablet**: 768px - 1199px
- **Mobile**: 480px - 767px
- **Small Mobile**: Below 480px

## Color Palette

- **Primary Orange**: #FF6B35
- **Secondary Yellow**: #F7931E
- **Accent Red**: #DC2626
- **Light Orange**: #FFB499
- **Dark Orange**: #E55A2B
- **White**: #FFFFFF
- **Light Gray**: #F8F9FA
- **Dark Gray**: #2D3748

## Contact Form Features

- Client-side validation
- Server-side PHP validation
- Spam protection
- Success/error notifications
- Data logging to file

## Customization

### Adding New Sections
1. Add HTML structure in `index.php`
2. Add corresponding CSS in `styles.css`
3. Update navigation links
4. Add smooth scrolling support in `script.js`

### Modifying Content
- Events: Edit `getEvents()` function in `config.php`
- Blogs: Edit `getBlogs()` function in `config.php`
- Contact Info: Update constants in `config.php`

### Styling Changes
- Colors: Modify CSS custom properties in `:root`
- Fonts: Update font imports and font-family declarations
- Layout: Adjust grid and flexbox properties

## Performance Features

- Optimized images and graphics
- Efficient CSS with custom properties
- Minimal JavaScript for core functionality
- Lazy loading animations
- Compressed and minified assets ready

## Security Features

- Input sanitization and validation
- XSS protection
- CSRF protection ready
- Secure file handling

## Future Enhancements

- Database integration for dynamic content
- User authentication system
- Content management system
- Blog post detail pages
- Event registration functionality
- Newsletter signup
- Advanced SEO optimization
- PWA capabilities

## License

This project is open source and available under the MIT License.

## Support

For questions or support, contact: hello@weeho.com
