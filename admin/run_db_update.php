<?php
// Database update script - Run this once to add new fields
require __DIR__.'/includes/db.php';

try {
    // Add meta fields to blogs table
    $pdo->exec("ALTER TABLE blogs ADD COLUMN meta_title VARCHAR(255) DEFAULT NULL");
    echo "✓ meta_title added\n";
} catch (Exception $e) { echo "meta_title exists\n"; }

try {
    $pdo->exec("ALTER TABLE blogs ADD COLUMN meta_description TEXT DEFAULT NULL");
    echo "✓ meta_description added\n";
} catch (Exception $e) { echo "meta_description exists\n"; }

try {
    $pdo->exec("ALTER TABLE blogs ADD COLUMN meta_keywords VARCHAR(500) DEFAULT NULL");
    echo "✓ meta_keywords added\n";
} catch (Exception $e) { echo "meta_keywords exists\n"; }

try {
    // Add status to admins table
    $pdo->exec("ALTER TABLE admins ADD COLUMN status ENUM('active', 'suspended', 'blocked') DEFAULT 'active'");
    echo "✓ Status field added to admins table\n";
} catch (Exception $e) { echo "Status field exists\n"; }

try {
    // Create settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
      id INT AUTO_INCREMENT PRIMARY KEY,
      setting_key VARCHAR(100) UNIQUE NOT NULL,
      setting_value TEXT,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ Settings table created\n";
} catch (Exception $e) { echo "Settings table exists\n"; }

try {
    // Insert default settings
    $pdo->exec("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
    ('site_logo', 'https://quickluxuryride.com/wp-content/uploads/2024/03/logo.png'),
    ('site_name', 'Quick Luxury Ride'),
    ('site_meta_title', 'Quick Luxury Ride | New York Chauffeur Service'),
    ('site_meta_description', 'Premium chauffeur service in New York. Executive black car service for airports, hourly, and city-to-city transfers.'),
    ('site_meta_keywords', 'chauffeur service, black car service, airport transfer, New York limo')");
    echo "✓ Default settings inserted\n";
} catch (Exception $e) { echo "Settings exist: " . $e->getMessage() . "\n"; }

echo "\n✅ Database updated successfully!\n";
echo "You can delete this file now.\n";
