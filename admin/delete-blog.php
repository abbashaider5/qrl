<?php
session_start();
header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['admin_id'])) {
  echo json_encode(['success' => false, 'message' => 'Unauthorized']);
  exit;
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/../includes/activity_logger.php';

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$blogId = isset($input['id']) ? (int)$input['id'] : 0;

if ($blogId <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid blog ID']);
  exit;
}

try {
  // Get blog details before deleting
  $stmt = $pdo->prepare("SELECT title FROM blogs WHERE id = ?");
  $stmt->execute([$blogId]);
  $blog = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$blog) {
    echo json_encode(['success' => false, 'message' => 'Blog not found']);
    exit;
  }
  
  // Delete the blog
  $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
  $stmt->execute([$blogId]);
  
  // Log the activity
  logActivity($pdo, $_SESSION['admin_id'], 'blog_deleted', "Deleted blog: {$blog['title']} (ID: $blogId)");
  
  echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
  
} catch (PDOException $e) {
  error_log("Delete blog error: " . $e->getMessage());
  echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
