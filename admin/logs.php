<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?php

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 50;
$offset = ($page - 1) * $perPage;

// Filters
$filterAction = isset($_GET['action']) && $_GET['action'] !== '' ? $_GET['action'] : null;
$filterAdminId = isset($_GET['admin_id']) && $_GET['admin_id'] !== '' ? intval($_GET['admin_id']) : null;

// Build query
$where = [];
$params = [];

if ($filterAction) {
    $where[] = 'action = ?';
    $params[] = $filterAction;
}

if ($filterAdminId) {
    $where[] = 'activity_logs.admin_id = ?';
    $params[] = $filterAdminId;
}

$whereClause = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// Get total count
$countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM activity_logs $whereClause");
$countStmt->execute($params);
$totalLogs = $countStmt->fetch()['total'];
$totalPages = ceil($totalLogs / $perPage);

// Get logs - build query with direct LIMIT/OFFSET
$stmt = $pdo->prepare("
    SELECT activity_logs.*, admins.email as admin_email 
    FROM activity_logs 
    LEFT JOIN admins ON activity_logs.admin_id = admins.id 
    $whereClause 
    ORDER BY activity_logs.created_at DESC 
    LIMIT $perPage OFFSET $offset
");
$stmt->execute($params);
$logs = $stmt->fetchAll();

// Get unique actions for filter
$actionsStmt = $pdo->query("SELECT DISTINCT action FROM activity_logs ORDER BY action");
$actions = $actionsStmt->fetchAll(PDO::FETCH_COLUMN);

// Get all admins for filter
$adminsStmt = $pdo->query("SELECT id, email FROM admins ORDER BY email");
$admins = $adminsStmt->fetchAll();
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>

<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Activity Logs</h1>
    <p class="text-slate-600 mt-1">Monitor all admin activities and actions</p>
  </div>

  <!-- Filters -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Filter by Action</label>
        <select name="action" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50">
          <option value="">All Actions</option>
          <?php foreach ($actions as $action): ?>
            <option value="<?php echo htmlspecialchars($action); ?>" <?php echo $filterAction === $action ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $action))); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Filter by Admin</label>
        <select name="admin_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50">
          <option value="">All Admins</option>
          <?php foreach ($admins as $admin): ?>
            <option value="<?php echo $admin['id']; ?>" <?php echo $filterAdminId === $admin['id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($admin['email']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="flex items-end gap-2">
        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition">
          <i class="fas fa-filter mr-2"></i> Apply Filters
        </button>
        <a href="/qlr/admin/logs" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
          <i class="fas fa-times mr-2"></i> Clear
        </a>
      </div>
    </form>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-600 font-medium">Total Logs</p>
          <p class="text-2xl font-bold text-slate-900 mt-1"><?php echo number_format($totalLogs); ?></p>
        </div>
        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-list text-orange-600 text-xl"></i>
        </div>
      </div>
    </div>
    
    <?php
    $todayCount = $pdo->query("SELECT COUNT(*) as c FROM activity_logs WHERE DATE(created_at) = CURDATE()")->fetch()['c'];
    $loginCount = $pdo->query("SELECT COUNT(*) as c FROM activity_logs WHERE action = 'login' AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch()['c'];
    $blockedCount = $pdo->query("SELECT COUNT(*) as c FROM activity_logs WHERE action = 'login_blocked'")->fetch()['c'];
    ?>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-600 font-medium">Today's Activity</p>
          <p class="text-2xl font-bold text-slate-900 mt-1"><?php echo number_format($todayCount); ?></p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-calendar-day text-green-600 text-xl"></i>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-600 font-medium">Logins (7 days)</p>
          <p class="text-2xl font-bold text-slate-900 mt-1"><?php echo number_format($loginCount); ?></p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-sign-in-alt text-green-600 text-xl"></i>
        </div>
      </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-600 font-medium">Blocked Attempts</p>
          <p class="text-2xl font-bold text-slate-900 mt-1"><?php echo number_format($blockedCount); ?></p>
        </div>
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-shield-alt text-red-600 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Logs Table -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
          <tr>
            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">Timestamp</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">Admin</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">Action</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">Description</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-700">IP Address</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          <?php if (empty($logs)): ?>
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                <p>No activity logs found</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($logs as $log): ?>
              <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 text-sm text-slate-600">
                  <?php echo date('M d, Y H:i:s', strtotime($log['created_at'])); ?>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span class="text-slate-900 font-medium"><?php echo htmlspecialchars($log['admin_email'] ?? 'Unknown'); ?></span>
                </td>
                <td class="px-6 py-4 text-sm">
                  <?php
                  $actionColors = [
                    'login' => 'bg-green-100 text-green-700',
                    'logout' => 'bg-slate-100 text-slate-700',
                    'login_blocked' => 'bg-red-100 text-red-700',
                    'blog_created' => 'bg-orange-100 text-orange-700',
                    'blog_updated' => 'bg-yellow-100 text-yellow-700',
                    'blog_deleted' => 'bg-red-100 text-red-700',
                    'admin_created' => 'bg-slate-100 text-slate-700',
                    'admin_updated' => 'bg-yellow-100 text-yellow-700',
                    'admin_deleted' => 'bg-red-100 text-red-700',
                    'settings_updated' => 'bg-orange-100 text-orange-700',
                    'contact_status_changed' => 'bg-slate-100 text-slate-700',
                    'password_changed' => 'bg-orange-100 text-orange-700',
                  ];
                  $colorClass = $actionColors[$log['action']] ?? 'bg-slate-100 text-slate-700';
                  ?>
                  <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo $colorClass; ?>">
                    <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $log['action']))); ?>
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600 max-w-md truncate">
                  <?php echo htmlspecialchars($log['description'] ?? '-'); ?>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600 font-mono">
                  <?php echo htmlspecialchars($log['ip_address']); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
      <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
        <p class="text-sm text-slate-600">
          Showing <?php echo number_format($offset + 1); ?> to <?php echo number_format(min($offset + $perPage, $totalLogs)); ?> of <?php echo number_format($totalLogs); ?> logs
        </p>
        <div class="flex gap-2">
          <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?><?php echo $filterAction ? '&action=' . urlencode($filterAction) : ''; ?><?php echo $filterAdminId ? '&admin_id=' . $filterAdminId : ''; ?>" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-semibold transition">
              Previous
            </a>
          <?php endif; ?>
          
          <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <a href="?page=<?php echo $i; ?><?php echo $filterAction ? '&action=' . urlencode($filterAction) : ''; ?><?php echo $filterAdminId ? '&admin_id=' . $filterAdminId : ''; ?>" class="px-4 py-2 <?php echo $i === $page ? 'bg-primary text-white' : 'bg-slate-100 hover:bg-slate-200'; ?> rounded-lg text-sm font-semibold transition">
              <?php echo $i; ?>
            </a>
          <?php endfor; ?>
          
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?><?php echo $filterAction ? '&action=' . urlencode($filterAction) : ''; ?><?php echo $filterAdminId ? '&admin_id=' . $filterAdminId : ''; ?>" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-semibold transition">
              Next
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
