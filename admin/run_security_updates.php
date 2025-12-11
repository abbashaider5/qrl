<?php
require_once __DIR__ . '/../includes/db.php';

echo "Running security and activity log updates...\n\n";

try {
    // 1. Add created_by to blogs table
    echo "1. Adding created_by to blogs table...\n";
    $pdo->exec("ALTER TABLE blogs ADD COLUMN created_by INT AFTER meta_keywords");
    $pdo->exec("ALTER TABLE blogs ADD FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL");
    echo "   ✓ Added created_by column to blogs\n\n";
    
    // 2. Create activity_logs table
    echo "2. Creating activity_logs table...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS activity_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admin_id INT,
        action VARCHAR(100) NOT NULL,
        description TEXT,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL,
        INDEX idx_admin_id (admin_id),
        INDEX idx_created_at (created_at),
        INDEX idx_action (action)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "   ✓ Created activity_logs table\n\n";
    
    echo "✓ All security updates completed successfully!\n";
    echo "\nNext steps:\n";
    echo "- Login system will now check admin status\n";
    echo "- Activity logs will track all admin actions\n";
    echo "- Blogs will show who created them\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
