-- Weeho Cultural Events Platform Sample Data
-- Insert sample data for testing and demonstration

USE weeho_db;

-- Insert Sample Events
INSERT INTO events (id, title, date, performer, city, description, status) VALUES
('event_1704067200_1001', 'Classical Dance Extravaganza', '2024-12-15', 'Priya Sharma & Troupe', 'Mumbai', 'Experience the grace and beauty of classical Indian dance forms including Bharatanatyam, Kathak, and Odissi performed by renowned artists.', 'upcoming'),
('event_1704067200_1002', 'Folk Music Festival', '2024-12-20', 'Rajesh Kumar', 'Delhi', 'A mesmerizing evening of traditional folk music from different regions of India, featuring authentic instruments and soulful melodies.', 'upcoming'),
('event_1704067200_1003', 'Cultural Heritage Showcase', '2025-01-05', 'Various Artists', 'Bangalore', 'A grand celebration showcasing the diverse cultural heritage of India through dance, music, art, and storytelling.', 'upcoming'),
('event_1704067200_1004', 'Traditional Puppet Show', '2024-12-25', 'Ramesh Puppeteers', 'Jaipur', 'Discover the ancient art of puppetry with colorful Rajasthani string puppets telling tales of valor and romance.', 'upcoming'),
('event_1704067200_1005', 'Sufi Music Night', '2025-01-10', 'Arif Khan Qawwali Group', 'Hyderabad', 'An enchanting evening of Sufi music and qawwali that will touch your soul and elevate your spirit.', 'upcoming'),
('event_1704067200_1006', 'Contemporary Fusion Performance', '2024-11-30', 'Modern Arts Collective', 'Chennai', 'A unique blend of traditional Indian arts with contemporary expressions, creating a mesmerizing fusion performance.', 'completed');

-- Insert Sample Registrations
INSERT INTO registrations (id, event_id, name, email, phone, role, city, status) VALUES
('reg_1704067200_2001', 'event_1704067200_1001', 'Anita Desai', 'anita.desai@email.com', '+91-9876543210', 'Audience', 'Mumbai', 'confirmed'),
('reg_1704067200_2002', 'event_1704067200_1001', 'Vikram Singh', 'vikram.singh@email.com', '+91-9876543211', 'Photographer', 'Mumbai', 'confirmed'),
('reg_1704067200_2003', 'event_1704067200_1002', 'Meera Patel', 'meera.patel@email.com', '+91-9876543212', 'Audience', 'Delhi', 'pending'),
('reg_1704067200_2004', 'event_1704067200_1003', 'Arjun Reddy', 'arjun.reddy@email.com', '+91-9876543213', 'Volunteer', 'Bangalore', 'confirmed'),
('reg_1704067200_2005', 'event_1704067200_1004', 'Kavya Sharma', 'kavya.sharma@email.com', '+91-9876543214', 'Audience', 'Jaipur', 'confirmed');

-- Insert Sample Event Feedback
INSERT INTO feedback (id, event_id, name, email, rating, feedback, status) VALUES
('feedback_1704067200_3001', 'event_1704067200_1006', 'Rajesh Kumar', 'rajesh.kumar@email.com', 5, 'Absolutely mesmerizing performance! The fusion of traditional and contemporary elements was beautifully executed. Would love to see more such events.', 'active'),
('feedback_1704067200_3002', 'event_1704067200_1006', 'Sunita Agarwal', 'sunita.agarwal@email.com', 4, 'Great event with talented performers. The venue was perfect and the organization was smooth. Looking forward to more cultural events.', 'active'),
('feedback_1704067200_3003', 'event_1704067200_1006', 'Amit Joshi', 'amit.joshi@email.com', 5, 'Outstanding showcase of Indian culture! The artists were incredibly skilled and the entire evening was magical. Highly recommend Weeho events.', 'active'),
('feedback_1704067200_3004', 'event_1704067200_1006', 'Priya Nair', 'priya.nair@email.com', 4, 'Wonderful experience! The blend of different art forms was refreshing. The sound quality could be improved, but overall it was fantastic.', 'active');

-- Insert Sample Team Feedback
INSERT INTO team_feedback (id, name, email, rating, message, status) VALUES
('team_feedback_1704067200_4001', 'Deepak Mehta', 'deepak.mehta@email.com', 5, 'Weeho is doing an incredible job promoting Indian culture. The team is passionate and dedicated. Keep up the excellent work!', 'active'),
('team_feedback_1704067200_4002', 'Lakshmi Iyer', 'lakshmi.iyer@email.com', 4, 'Love the mission of making arts accessible to everyone. The free workshops are a great initiative. Would love to see more regional coverage.', 'active'),
('team_feedback_1704067200_4003', 'Rohit Gupta', 'rohit.gupta@email.com', 5, 'As a performer, I appreciate the platform Weeho provides to showcase traditional arts. The support and organization is top-notch.', 'active'),
('team_feedback_1704067200_4004', 'Neha Kapoor', 'neha.kapoor@email.com', 4, 'Great work in preserving and promoting Indian cultural heritage. The events are well-organized and the community response is amazing.', 'active');

-- Insert Sample Memories
INSERT INTO memories (id, title, image, caption, event_id, status, sort_order) VALUES
('memory_1704067200_5001', 'Classical Grace', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500', 'A magical evening of classical dance that transported the audience to ancient India with graceful movements and traditional costumes.', 'event_1704067200_1006', 'active', 1),
('memory_1704067200_5002', 'Rhythmic Beats', 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500', 'The rhythmic beats of traditional drums echoing through the cultural center, creating an atmosphere of celebration and joy.', 'event_1704067200_1006', 'active', 2),
('memory_1704067200_5003', 'Colorful Heritage', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500', 'Colorful costumes and graceful movements telling stories of our rich heritage, preserving traditions for future generations.', 'event_1704067200_1006', 'active', 3),
('memory_1704067200_5004', 'Artistic Expression', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500', 'Artists expressing the depth of Indian culture through their passionate performances, connecting hearts across generations.', NULL, 'active', 4),
('memory_1704067200_5005', 'Community Celebration', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500', 'The joy of community coming together to celebrate arts and culture, creating memories that last a lifetime.', NULL, 'active', 5),
('memory_1704067200_5006', 'Traditional Instruments', 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500', 'The melodious sounds of traditional instruments filling the air with enchanting music that speaks to the soul.', NULL, 'active', 6),
('memory_1704067200_5007', 'Cultural Fusion', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500', 'A beautiful fusion of traditional and contemporary elements, showing how culture evolves while maintaining its essence.', NULL, 'active', 7),
('memory_1704067200_5008', 'Audience Engagement', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500', 'The engaged audience experiencing the magic of live cultural performances, creating a bond between artists and spectators.', NULL, 'active', 8),
('memory_1704067200_5009', 'Artistic Mastery', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500', 'Master artists demonstrating their incredible skills and dedication to preserving the authentic forms of Indian classical arts.', NULL, 'active', 9);

-- Insert Sample Contact Messages
INSERT INTO contact_messages (id, name, email, subject, message, status) VALUES
('contact_1704067200_6001', 'Ravi Sharma', 'ravi.sharma@email.com', 'Collaboration Opportunity', 'Hello, I am a classical musician and would like to collaborate with Weeho for upcoming events. Please let me know how I can get involved.', 'new'),
('contact_1704067200_6002', 'Maya Singh', 'maya.singh@email.com', 'Workshop Inquiry', 'I am interested in attending your free workshops. Could you please provide more information about upcoming sessions?', 'read'),
('contact_1704067200_6003', 'Karan Patel', 'karan.patel@email.com', 'Event Sponsorship', 'Our company would like to sponsor cultural events. Please share details about sponsorship opportunities.', 'responded');

-- Insert Default Admin Users
INSERT INTO admin_users (username, email, password_hash, full_name, role, status) VALUES
('admin', 'admin@weeho.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin', 'active'),
('moderator', 'moderator@weeho.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Content Moderator', 'moderator', 'active');

-- Insert System Settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'Weeho', 'string', 'Website name displayed in header'),
('site_tagline', 'Celebrate Arts Across India', 'string', 'Website tagline'),
('contact_email', 'info@weeho.com', 'string', 'Primary contact email'),
('contact_phone', '+91-98765-43210', 'string', 'Primary contact phone'),
('contact_address', 'Cultural Arts District, Mumbai, Maharashtra, India', 'string', 'Primary contact address'),
('events_per_page', '12', 'integer', 'Number of events to display per page'),
('enable_registrations', 'true', 'boolean', 'Allow event registrations'),
('enable_feedback', 'true', 'boolean', 'Allow event feedback'),
('maintenance_mode', 'false', 'boolean', 'Enable maintenance mode'),
('social_twitter', 'https://twitter.com/weeho', 'string', 'Twitter profile URL'),
('social_linkedin', 'https://linkedin.com/company/weeho', 'string', 'LinkedIn profile URL'),
('social_github', 'https://github.com/weeho', 'string', 'GitHub profile URL');

-- Create some sample activity log entries
INSERT INTO activity_log (user_id, action, table_name, record_id, new_values, ip_address) VALUES
(1, 'CREATE', 'events', 'event_1704067200_1001', '{"title": "Classical Dance Extravaganza", "status": "upcoming"}', '127.0.0.1'),
(1, 'CREATE', 'events', 'event_1704067200_1002', '{"title": "Folk Music Festival", "status": "upcoming"}', '127.0.0.1'),
(2, 'CREATE', 'memories', 'memory_1704067200_5001', '{"title": "Classical Grace", "status": "active"}', '127.0.0.1');
