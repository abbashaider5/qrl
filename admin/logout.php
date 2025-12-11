<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/../includes/activity_logger.php';
session_start();

// Log the logout activity before destroying session
if (isset($_SESSION['admin_id'])) {
    logActivity($pdo, $_SESSION['admin_id'], 'logout', 'Logged out');
}

session_unset();
session_destroy();
header('Location: /qlr/admin/signin');
