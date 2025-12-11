<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All fields are required.';
    } elseif (strlen($newPassword) < 8) {
        $error = 'New password must be at least 8 characters long.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match.';
    } else {
        // Verify current password
        $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($currentPassword, $admin['password_hash'])) {
            // Update password
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
            $stmt->execute([$newHash, $_SESSION['admin_id']]);
            $success = true;
        } else {
            $error = 'Current password is incorrect.';
        }
    }
}
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Change Password</h1>
    <p class="text-slate-600 mt-1">Update your account password</p>
  </div>

  <?php if ($success): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
      <div class="flex items-center gap-3">
        <i class="fas fa-check-circle text-green-600 text-xl"></i>
        <div>
          <p class="font-semibold text-green-800">Password Changed Successfully!</p>
          <p class="text-sm text-green-700 mt-1">Your password has been updated.</p>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
      <div class="flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-600"></i>
        <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
      </div>
    </div>
  <?php endif; ?>

  <div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form method="POST" class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Current Password</label>
            <input type="password" name="current_password" required 
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                   placeholder="Enter current password">
          </div>

          <div class="border-t border-slate-200 pt-6">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                <input type="password" name="new_password" required minlength="8"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                       placeholder="Enter new password">
                <p class="text-xs text-slate-500 mt-1">Minimum 8 characters</p>
              </div>

              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm New Password</label>
                <input type="password" name="confirm_password" required minlength="8"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                       placeholder="Confirm new password">
              </div>
            </div>
          </div>

          <div class="flex gap-3 justify-end pt-4 border-t border-slate-200">
            <a href="/qlr/admin" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
              Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
              <i class="fas fa-save mr-2"></i> Update Password
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Security Tips -->
    <div class="lg:col-span-1">
      <div class="bg-orange-50 border border-orange-200 rounded-lg p-5 sticky top-20">
        <h3 class="font-semibold text-orange-900 mb-3 flex items-center gap-2">
          <i class="fas fa-shield-alt"></i> Password Security Tips
        </h3>
        <ul class="text-sm text-orange-800 space-y-2 ml-5 list-disc">
          <li>Use at least 8 characters</li>
          <li>Include uppercase and lowercase letters</li>
          <li>Add numbers and special characters</li>
          <li>Avoid common words or personal information</li>
          <li>Don't reuse passwords from other accounts</li>
        </ul>
      </div>
    </div>
  </div>
</main>
</body>
</html>
