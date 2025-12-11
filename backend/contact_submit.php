<?php
header('Content-Type: application/json');

try {
    // Basic validation
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name === '' || $email === '' || $message === '') {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
        exit;
    }

    // DB insert
    $dsn = 'mysql:host=localhost;dbname=qlr;charset=utf8mb4';
    $pdo = new PDO($dsn, 'root', 'Abbas@123', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message, created_at, ip_address) VALUES (?, ?, ?, NOW(), ?)');
    $stmt->execute([$name, $email, $message, $_SERVER['REMOTE_ADDR'] ?? null]);

    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    // Do not leak server internals
    echo json_encode(['success' => false, 'error' => 'Server error. Please try later.']);
}
