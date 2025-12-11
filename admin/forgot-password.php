<?php
require __DIR__.'/includes/db.php';
require __DIR__.'/includes/mailer.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = 'Please enter your email address.';
    } else {
        // Check if admin exists
        $stmt = $pdo->prepare("SELECT id, email FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token
            $stmt = $pdo->prepare("INSERT INTO password_resets (admin_id, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$admin['id'], $token, $expires]);
            
            // Send reset email
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/qlr/admin/reset-password?token=" . $token;
            
            $emailContent = '
                <h2 style="color: #1f2937; margin-bottom: 20px;">Reset Your Password</h2>
                <p style="color: #4b5563; line-height: 1.6; margin-bottom: 20px;">
                    We received a request to reset your password. Click the button below to create a new password:
                </p>
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . $resetLink . '" style="background-color: #F6B530; color: #000000; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; display: inline-block;">
                        Reset Password
                    </a>
                </div>
                <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin-top: 20px;">
                    This link will expire in 1 hour. If you didn\'t request a password reset, you can safely ignore this email.
                </p>
                <p style="color: #9ca3af; font-size: 12px; margin-top: 20px;">
                    Or copy and paste this link: <br>
                    <span style="color: #3b82f6;">' . $resetLink . '</span>
                </p>
            ';
            
            $emailHTML = getEmailTemplate($emailContent, 'Reset Your Password');
            
            if (sendEmail($email, 'Reset Your Password - QLR Admin', $emailHTML)) {
                $success = true;
            } else {
                $error = 'Failed to send reset email. Please try again later.';
            }
        } else {
            // Don't reveal if email exists or not (security best practice)
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | QLR Admin</title>
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
                    <i class="fas fa-key text-primary text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Forgot Password?</h1>
                <p class="text-slate-600 mt-2">Enter your email to receive a reset link</p>
            </div>

            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-green-800">Email Sent!</p>
                            <p class="text-sm text-green-700 mt-1">
                                Check your inbox for password reset instructions.
                            </p>
                        </div>
                    </div>
                </div>
                <a href="/qlr/admin/signin" class="block w-full text-center px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
                    Back to Sign In
                </a>
            <?php else: ?>
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
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                               placeholder="admin@example.com">
                    </div>

                    <button type="submit" 
                            class="w-full px-4 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
                        <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="/qlr/admin/signin" class="text-sm text-primary hover:text-primary/80 font-semibold">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Sign In
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <p class="text-center text-sm text-slate-600 mt-6">
            © <?php echo date('Y'); ?> Quick Luxury Ride. All rights reserved.
        </p>
    </div>
</body>
</html>
