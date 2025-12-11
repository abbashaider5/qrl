<?php
require_once __DIR__ . '/includes/db.php';

// Check activity logs count
$stmt = $pdo->query("SELECT COUNT(*) as count FROM activity_logs");
$count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
echo "Total activity logs: $count\n\n";

// Show recent logs
$stmt = $pdo->query("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 10");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($logs) > 0) {
  echo "Recent activity logs:\n";
  foreach ($logs as $log) {
    echo sprintf(
      "[%s] Admin ID: %d, Action: %s, Description: %s\n",
      $log['created_at'],
      $log['admin_id'],
      $log['action'],
      $log['description'] ?? 'N/A'
    );
  }
} else {
  echo "No activity logs found.\n";
}

// Test logActivity function
echo "\n--- Testing logActivity function ---\n";
require_once __DIR__ . '/../includes/activity_logger.php';

try {
  logActivity($pdo, 1, 'test_action', 'Testing activity logger from debug script');
  echo "✓ Test activity logged successfully\n";
  
  // Verify it was inserted
  $stmt = $pdo->query("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 1");
  $latest = $stmt->fetch(PDO::FETCH_ASSOC);
  echo "Latest log: " . json_encode($latest, JSON_PRETTY_PRINT) . "\n";
  
} catch (Exception $e) {
  echo "✗ Error logging activity: " . $e->getMessage() . "\n";
}
