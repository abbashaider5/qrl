<?php
require __DIR__.'/includes/db.php';

$token = $_GET['token'] ?? '';
$success = false;
$error = '';
$validToken = false;

// Verify token
if (!empty($token)) {
    $stmt = $pdo->prepare("
        SELECT pr.*, a.email 
        FROM password_resets pr 
        JOIN admins a ON pr.admin_id = a.id 
        WHERE pr.token = ? AND pr.used = 0 AND pr.expires_at > NOW()
    ");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();
    
    if ($reset) {
        $validToken = true;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($password)) {
                $error = 'Please enter a new password.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } else {
                // Update password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
                $stmt->execute([$hashedPassword, $reset['admin_id']]);
                
                // Mark token as used
                $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?");
                $stmt->execute([$reset['id']]);
                
                $success = true;
            }
        }
    } else {
        $error = 'Invalid or expired reset link.';
    }
} else {
    $error = 'No reset token provided.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | QLR Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: "Plus Jakarta Sans", system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                    <i class="fas fa-lock text-primary text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Reset Password</h1>
                <p class="text-slate-600 mt-2">Choose a new password for your account</p>
            </div>

            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-green-800">Password Reset Successful!</p>
                            <p class="text-sm text-green-700 mt-1">
                                You can now sign in with your new password.
                            </p>
                        </div>
                    </div>
                </div>
                <a href="/qlr/admin/signin" class="block w-full text-center px-4 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
                    Go to Sign In
                </a>
            <?php elseif ($validToken): ?>
                <?php if ($error): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                        <input type="password" name="password" required minlength="8"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                               placeholder="Enter new password">
                        <p class="text-xs text-slate-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                        <input type="password" name="confirm_password" required minlength="8"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                               placeholder="Confirm new password">
                    </div>

                    <button type="submit" 
                            class="w-full px-4 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
                        <i class="fas fa-check mr-2"></i> Reset Password
                    </button>
                </form>
            <?php else: ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-red-800">Invalid Reset Link</p>
                            <p class="text-sm text-red-700 mt-1"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
                <a href="/qlr/admin/forgot-password" class="block w-full text-center px-4 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
                    Request New Link
                </a>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <a href="/qlr/admin/signin" class="text-sm text-primary hover:text-primary/80 font-semibold">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Sign In
                </a>
            </div>
        </div>

        <p class="text-center text-sm text-slate-600 mt-6">
            © <?php echo date('Y'); ?> Quick Luxury Ride. All rights reserved.
        </p>
    </div>
</body>
</html>
