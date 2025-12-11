<?php
session_start();
require __DIR__.'/../includes/db.php';

header('Content-Type: application/json');

// Ensure user is authenticated
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';
$admin_id = intval($_POST['admin_id'] ?? 0);

// Prevent admin from acting on themselves
if ($admin_id === $_SESSION['admin_id']) {
    echo json_encode(['success' => false, 'error' => 'Cannot perform this action on your own account']);
    exit;
}

// Validate admin_id
if ($admin_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid admin ID']);
    exit;
}

try {
    switch ($action) {
        case 'delete':
            // Delete the admin account
            $stmt = $pdo->prepare('DELETE FROM admins WHERE id = ?');
            $stmt->execute([$admin_id]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Admin deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Admin not found']);
            }
            break;
            
        case 'status':
            // Update admin status
            $status = $_POST['status'] ?? '';
            $valid_statuses = ['active', 'suspended', 'blocked'];
            
            if (!in_array($status, $valid_statuses)) {
                echo json_encode(['success' => false, 'error' => 'Invalid status value']);
                exit;
            }
            
            $stmt = $pdo->prepare('UPDATE admins SET status = ? WHERE id = ?');
            $stmt->execute([$status, $admin_id]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully', 'new_status' => $status]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Admin not found or status unchanged']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
