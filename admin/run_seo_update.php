<?php
require_once __DIR__ . '/../includes/db.php';

echo "Adding page-specific SEO meta data...\n\n";

try {
    // Check if we need to add page-specific settings
    $pageSettings = [
        // Home Page
        ['page_home_meta_title', 'Quick Luxury Ride | Premium NYC Chauffeur Service'],
        ['page_home_meta_description', 'Professional black car service in New York. Airport transfers, hourly chauffeur, and corporate transportation with licensed drivers and premium vehicles.'],
        ['page_home_meta_keywords', 'NYC chauffeur service, black car service NYC, airport transfer, corporate transportation, luxury car service'],
        
        // About Page
        ['page_about_meta_title', 'About Us | Quick Luxury Ride - NYC Chauffeur Service'],
        ['page_about_meta_description', 'Learn about Quick Luxury Ride - New York\'s trusted chauffeur service provider. Professional drivers, premium fleet, and exceptional service since day one.'],
        ['page_about_meta_keywords', 'about QLR, chauffeur company NYC, professional drivers, luxury transportation'],
        
        // Services Page
        ['page_services_meta_title', 'Our Services | Airport Transfers & Corporate Transportation'],
        ['page_services_meta_description', 'Comprehensive chauffeur services including airport transfers, hourly rentals, city-to-city transportation, and corporate travel solutions in NYC.'],
        ['page_services_meta_keywords', 'airport transfer NYC, corporate transportation, hourly chauffeur, city transfer, JFK transfer, LGA transfer'],
        
        // Fleet Page
        ['page_fleet_meta_title', 'Our Fleet | Premium Vehicles & Luxury Cars - QLR'],
        ['page_fleet_meta_description', 'Explore our premium fleet of luxury sedans, SUVs, and executive vehicles. All vehicles are meticulously maintained and equipped for your comfort.'],
        ['page_fleet_meta_keywords', 'luxury car fleet, premium vehicles NYC, executive cars, luxury SUV, black car fleet'],
        
        // Contact Page
        ['page_contact_meta_title', 'Contact Us | Get a Quote - Quick Luxury Ride'],
        ['page_contact_meta_description', 'Contact Quick Luxury Ride for bookings, quotes, or inquiries. Available 24/7 for all your chauffeur service needs in New York.'],
        ['page_contact_meta_keywords', 'contact chauffeur service, book car service NYC, get quote, 24/7 transportation'],
        
        // Business Page
        ['page_business_meta_title', 'Corporate Solutions | Business Transportation Services'],
        ['page_business_meta_description', 'Tailored corporate transportation solutions for businesses, travel agencies, and strategic partners. Account management and priority service.'],
        ['page_business_meta_keywords', 'corporate transportation, business travel, travel agency partner, executive transportation'],
        
        // Blog Page
        ['page_blog_meta_title', 'Blog | Travel Tips & Industry Insights - QLR'],
        ['page_blog_meta_description', 'Expert insights on luxury ground transportation, travel tips, airport logistics, and corporate mobility solutions from Quick Luxury Ride.'],
        ['page_blog_meta_keywords', 'transportation blog, travel tips, airport guide, luxury travel, NYC travel'],
    ];
    
    $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()');
    
    foreach ($pageSettings as $setting) {
        $stmt->execute($setting);
        echo "✓ Added/Updated: {$setting[0]}\n";
    }
    
    echo "\n✓ All page SEO settings have been added successfully!\n";
    echo "\nYou can now update these values from the Admin Settings page.\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
