<?php
require __DIR__.'/../includes/db.php';

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Database Updates</title></head><body>";
echo "<h2>Running Database Updates...</h2><pre>";

try {
    // Add views column to blogs table
    try {
        $pdo->exec("ALTER TABLE blogs ADD COLUMN views INT DEFAULT 0 AFTER meta_keywords");
        echo "✓ Views column added to blogs table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "• Views column already exists in blogs table\n";
        } else {
            throw $e;
        }
    }

    // Add status column to contacts table (if contacts table exists)
    try {
        // First check if contacts table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'contacts'");
        if ($stmt->rowCount() > 0) {
            try {
                $pdo->exec("ALTER TABLE contacts ADD COLUMN status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new' AFTER message");
                echo "✓ Status column added to contacts table\n";
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate column') !== false) {
                    echo "• Status column already exists in contacts table\n";
                } else {
                    throw $e;
                }
            }
        } else {
            // Create contacts table
            $pdo->exec("CREATE TABLE contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255),
                message TEXT NOT NULL,
                status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "✓ Contacts table created\n";
        }
    } catch (PDOException $e) {
        echo "✗ Error with contacts table: " . $e->getMessage() . "\n";
    }

    // Create visitor_stats table
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS visitor_stats (
            id INT AUTO_INCREMENT PRIMARY KEY,
            visit_date DATE NOT NULL,
            page_url VARCHAR(255),
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_visit_date (visit_date),
            INDEX idx_page_url (page_url)
        )");
        echo "✓ Visitor stats table created\n";
    } catch (PDOException $e) {
        echo "✗ Error creating visitor_stats table: " . $e->getMessage() . "\n";
    }

    // Create password_resets table
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            token VARCHAR(255) NOT NULL UNIQUE,
            expires_at DATETIME NOT NULL,
            used TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE,
            INDEX idx_token (token),
            INDEX idx_expires (expires_at)
        )");
        echo "✓ Password resets table created\n";
    } catch (PDOException $e) {
        echo "✗ Error creating password_resets table: " . $e->getMessage() . "\n";
    }

    echo "\n<strong>All updates completed!</strong>\n";
    echo "\n<a href='/qlr/admin'>Go to Admin Dashboard</a>";

} catch (PDOException $e) {
    echo "✗ Fatal error: " . $e->getMessage() . "\n";
}

echo "</pre></body></html>";
