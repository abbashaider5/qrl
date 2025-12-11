-- Add meta fields to blogs table for SEO optimization
ALTER TABLE blogs 
ADD COLUMN IF NOT EXISTS meta_title VARCHAR(255) DEFAULT NULL AFTER content,
ADD COLUMN IF NOT EXISTS meta_description TEXT DEFAULT NULL AFTER meta_title,
ADD COLUMN IF NOT EXISTS meta_keywords VARCHAR(500) DEFAULT NULL AFTER meta_keywords;

-- Add status column to admins table for suspend/block functionality
ALTER TABLE admins
ADD COLUMN IF NOT EXISTS status ENUM('active', 'suspended', 'blocked') DEFAULT 'active' AFTER password;

-- Create settings table for website configuration
CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) UNIQUE NOT NULL,
  setting_value TEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('site_logo', 'https://quickluxuryride.com/wp-content/uploads/2024/03/logo.png'),
('site_name', 'Quick Luxury Ride'),
('site_meta_title', 'Quick Luxury Ride | New York Chauffeur Service'),
('site_meta_description', 'Premium chauffeur service in New York. Executive black car service for airports, hourly, and city-to-city transfers.'),
('site_meta_keywords', 'chauffeur service, black car service, airport transfer, New York limo');
