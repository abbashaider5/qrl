<?php
// Helper function to track visitor statistics
function trackVisitor($pdo) {
    if (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
        return; // Don't track admin pages
    }
    
    try {
        $page_url = $_SERVER['REQUEST_URI'];
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        $stmt = $pdo->prepare("INSERT INTO visitor_stats (visit_date, page_url, ip_address, user_agent) VALUES (CURDATE(), ?, ?, ?)");
        $stmt->execute([$page_url, $ip_address, $user_agent]);
    } catch (PDOException $e) {
        // Silently fail to not disrupt user experience
        error_log("Visitor tracking error: " . $e->getMessage());
    }
}

// Helper function to get site settings
function getSiteSettings($pdo) {
    static $settings = null;
    
    if ($settings === null) {
        $settings = [];
        try {
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
            while ($row = $stmt->fetch()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (PDOException $e) {
            error_log("Settings fetch error: " . $e->getMessage());
        }
    }
    
    return $settings;
}

// Helper function to increment blog post views
function incrementBlogViews($pdo, $blog_id) {
    try {
        $stmt = $pdo->prepare("UPDATE blogs SET views = views + 1 WHERE id = ?");
        $stmt->execute([$blog_id]);
    } catch (PDOException $e) {
        error_log("Blog view increment error: " . $e->getMessage());
    }
}
