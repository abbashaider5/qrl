<?php
include __DIR__.'/includes/db.php';
require_once __DIR__ . '/../includes/activity_logger.php';
session_start();

function too_many_attempts(PDO $pdo, string $ip): bool {
    $stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM login_attempts WHERE ip_address = ? AND attempted_at > (NOW() - INTERVAL 15 MINUTE)');
    $stmt->execute([$ip]);
    $c = (int)$stmt->fetch()['c'];
    return $c >= 5;
}

function record_attempt(PDO $pdo, string $ip, string $email, bool $success): void {
    $stmt = $pdo->prepare('INSERT INTO login_attempts (ip_address, email, success, attempted_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$ip, $email, $success ? 1 : 0]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    if ($email === '' || $password === '') {
        header('Location: /qlr/admin/signin?error='.urlencode('Email and password are required.'));
        exit;
    }

    if (too_many_attempts($pdo, $ip)) {
        header('Location: /qlr/admin/signin?error='.urlencode('Too many attempts. Try again later.'));
        exit;
    }

    $stmt = $pdo->prepare('SELECT id, email, password_hash, status FROM admins WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Check if admin exists
    if (!$admin) {
        record_attempt($pdo, $ip, $email, false);
        header('Location: /qlr/admin/signin?error='.urlencode('Invalid credentials.'));
        exit;
    }

    // Check admin status
    if ($admin['status'] === 'suspended') {
        record_attempt($pdo, $ip, $email, false);
        logActivity($pdo, $admin['id'], 'login_blocked', 'Suspended account attempted login');
        header('Location: /qlr/admin/signin?error='.urlencode('Your account has been suspended. Please contact the administrator.'));
        exit;
    }

    if ($admin['status'] === 'blocked') {
        record_attempt($pdo, $ip, $email, false);
        logActivity($pdo, $admin['id'], 'login_blocked', 'Blocked account attempted login');
        header('Location: /qlr/admin/signin?error='.urlencode('Your account has been blocked. Please contact the administrator.'));
        exit;
    }

    $ok = password_verify($password, $admin['password_hash']);
    record_attempt($pdo, $ip, $email, $ok);

    if ($ok) {
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        session_regenerate_id(true);
        logActivity($pdo, $admin['id'], 'login', 'Successfully logged in');
        header('Location: /qlr/admin/index');
        exit;
    }

    header('Location: /qlr/admin/signin?error='.urlencode('Invalid credentials.'));
    exit;
}
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<style>
  .no-rounded, .no-rounded * { border-radius: 0 !important; }
  .signin-bg {
    background: linear-gradient(rgba(12, 10, 46, 0.85), rgba(12, 10, 46, 0.85)), 
                url('https://private-driver-paris-airport-transfer.com/wp-content/uploads/2025/10/mercedes-v-class-fleet-paris.jpeg') center/cover no-repeat;
  }
</style>
<main class="min-h-screen flex items-center justify-center px-4 text-white no-rounded signin-bg">
  <div class="max-w-md w-full bg-white/5 border border-white/10 p-8 space-y-6">
    <div class="space-y-2">
      <p class="text-xs uppercase tracking-[0.3em] text-[#F6B530]">Admin Access</p>
      <h1 class="text-2xl font-semibold">Sign in to QLR Console</h1>
      <!-- <p class="text-sm text-slate-200">Use your admin credentials to manage blogs and contact queries.</p> -->
    </div>
    <form method="post" class="space-y-4">
      <div class="space-y-2">
        <label for="email" class="text-sm text-slate-200">Work email</label>
        <input id="email" name="email" type="email" required class="w-full bg-white/10 border border-white/20 text-white placeholder:text-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#F6B530]" placeholder="Enter email address">
      </div>
      <div class="space-y-2">
        <label for="password" class="text-sm text-slate-200">Password</label>
        <div class="relative">
          <input id="password" name="password" type="password" required class="w-full bg-white/10 border border-white/20 text-white placeholder:text-slate-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-[#F6B530]" placeholder="••••••••">
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-white transition">
            <i id="toggleIcon" class="fas fa-eye"></i>
          </button>
        </div>
      </div>
      <div class="flex items-center justify-between text-xs text-slate-200">
        <label class="inline-flex items-center gap-2"><input type="checkbox" class="accent-[#F6B530]">Remember me</label>
        <a href="/qlr/admin/forgot-password" class="hover:text-[#F6B530]">Forgot password?</a>
      </div>
      <button type="submit" class="w-full bg-[#F6B530] text-black font-semibold py-3 uppercase tracking-wide">Sign in</button>
      <?php if (!empty($_GET['error'])): ?>
        <p class="text-sm text-red-200"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php endif; ?>
    </form>
    <p class="text-xs text-slate-300">After sign in, you will be redirected to the admin panel.</p>
  </div>
</main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleIcon.classList.remove('fa-eye');
      toggleIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      toggleIcon.classList.remove('fa-eye-slash');
      toggleIcon.classList.add('fa-eye');
    }
  }
</script>