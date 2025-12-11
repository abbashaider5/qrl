<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Create New Admin</h1>
    <p class="text-slate-600 mt-1">Add a new administrator account</p>
  </div>
  </div>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = trim($_POST['email'] ?? '');
      $password = $_POST['password'] ?? '';
      $error = '';
      if ($email === '' || $password === '') {
          $error = 'Email and password are required.';
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error = 'Invalid email.';
      } else {
          $hash = password_hash($password, PASSWORD_BCRYPT);
          $stmt = $pdo->prepare('INSERT INTO admins (email, password_hash) VALUES (?, ?)');
          try { $stmt->execute([$email, $hash]); }
          catch (Throwable $e) { $error = 'Email already exists.'; }
      }
      if ($error !== '') echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg"><i class="fas fa-exclamation-circle mr-2"></i>'.htmlspecialchars($error).'</div>';
      else echo '<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg"><i class="fas fa-check-circle mr-2"></i>Admin created successfully.</div>';
  }
  ?>
  <form method="post" class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-5">
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
        <input name="email" type="email" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="admin@example.com" required>
      </div>
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
        <input name="password" type="password" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="••••••••" required>
      </div>
      <div class="flex gap-3">
        <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg shadow-primary/30 transition-all">
          <i class="fas fa-user-plus"></i> Create Admin
        </button>
        <a href="/qlr/admin/users" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold transition-all">
          Cancel
        </a>
      </div>
    </div>
  </form>
</main>
</body>
</html>