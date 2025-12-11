<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php

// Get statistics
$totalBlogs = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$totalContacts = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$newContacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE status = 'new'")->fetchColumn();
$totalViews = $pdo->query("SELECT SUM(views) FROM blogs")->fetchColumn() ?: 0;

// Visitor statistics
$todayVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitor_stats WHERE visit_date = CURDATE()")->fetchColumn();
$weekVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitor_stats WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetchColumn();
$monthVisitors = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitor_stats WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetchColumn();
$totalVisits = $pdo->query("SELECT COUNT(*) FROM visitor_stats")->fetchColumn();

// Recent blogs
$recentBlogs = $pdo->query("SELECT id, title, created_at FROM blogs ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Recent contacts
$recentContacts = $pdo->query("SELECT name, email, message, created_at FROM contacts ORDER BY created_at DESC LIMIT 3")->fetchAll();

// Top visited pages
$topPages = $pdo->query("SELECT page_url, COUNT(*) as visits FROM visitor_stats GROUP BY page_url ORDER BY visits DESC LIMIT 5")->fetchAll();
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
    <p class="text-slate-600 mt-1">Overview of your website statistics</p>
  </div>

  <!-- STATS GRID -->
  <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-8">
    <!-- Total Blogs -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Blogs</p>
          <p class="mt-2 text-3xl font-bold text-slate-900"><?php echo number_format($totalBlogs); ?></p>
        </div>
        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-blog text-blue-600 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Total Views -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Views</p>
          <p class="mt-2 text-3xl font-bold text-slate-900"><?php echo number_format($totalViews); ?></p>
        </div>
        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-eye text-green-600 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Contact Queries -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Contact Queries</p>
          <p class="mt-2 text-3xl font-bold text-slate-900"><?php echo number_format($totalContacts); ?></p>
          <?php if ($newContacts > 0): ?>
            <p class="mt-1 text-xs text-amber-600 font-semibold"><?php echo $newContacts; ?> new</p>
          <?php endif; ?>
        </div>
        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-envelope text-purple-600 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Month Visitors -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Monthly Visitors</p>
          <p class="mt-2 text-3xl font-bold text-slate-900"><?php echo number_format($monthVisitors); ?></p>
          <p class="mt-1 text-xs text-slate-500"><?php echo number_format($weekVisitors); ?> this week</p>
        </div>
        <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-clock text-orange-600 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- VISITOR STATISTICS -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
      <i class="fas fa-chart-line text-primary"></i> Visitor Statistics
    </h2>
    
    <div class="grid gap-6 md:grid-cols-3 mb-6">
      <div class="text-center p-4 bg-slate-50 rounded-lg">
        <p class="text-sm text-slate-600 font-semibold mb-1">Today</p>
        <p class="text-2xl font-bold text-primary"><?php echo number_format($todayVisitors); ?></p>
        <p class="text-xs text-slate-500 mt-1">unique visitors</p>
      </div>
      <div class="text-center p-4 bg-slate-50 rounded-lg">
        <p class="text-sm text-slate-600 font-semibold mb-1">Last 7 Days</p>
        <p class="text-2xl font-bold text-primary"><?php echo number_format($weekVisitors); ?></p>
        <p class="text-xs text-slate-500 mt-1">unique visitors</p>
      </div>
      <div class="text-center p-4 bg-slate-50 rounded-lg">
        <p class="text-sm text-slate-600 font-semibold mb-1">Last 30 Days</p>
        <p class="text-2xl font-bold text-primary"><?php echo number_format($monthVisitors); ?></p>
        <p class="text-xs text-slate-500 mt-1">unique visitors</p>
      </div>
    </div>

    <div class="border-t border-slate-200 pt-4">
      <h3 class="font-semibold text-slate-900 mb-3">Top Visited Pages</h3>
      <div class="space-y-2">
        <?php foreach ($topPages as $page): ?>
          <div class="flex items-center justify-between py-2 px-3 bg-slate-50 rounded-lg">
            <span class="text-sm text-slate-700 truncate flex-1 mr-4"><?php echo htmlspecialchars($page['page_url']); ?></span>
            <span class="text-sm font-semibold text-slate-900"><?php echo number_format($page['visits']); ?> visits</span>
          </div>
        <?php endforeach; ?>
        <?php if (empty($topPages)): ?>
          <p class="text-sm text-slate-500 text-center py-4">No visitor data yet</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- RECENT ACTIVITY -->
  <div class="grid gap-6 xl:grid-cols-2 mb-8">
    <!-- Recent Blogs -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
          <i class="fas fa-blog text-primary"></i> Recent Blogs
        </h2>
        <a href="/qlr/admin/blogs" class="text-sm text-primary hover:text-primary/80 font-semibold">View All</a>
      </div>
      
      <div class="space-y-3">
        <?php foreach ($recentBlogs as $blog): ?>
          <div class="border border-slate-200 rounded-lg p-4 hover:bg-slate-50 transition">
            <div class="flex items-start justify-between gap-4">
              <div class="flex-1">
                <h3 class="font-semibold text-slate-900 mb-1"><?php echo htmlspecialchars($blog['title']); ?></h3>
                <p class="text-xs text-slate-500"><?php echo date('M d, Y · h:i A', strtotime($blog['created_at'])); ?></p>
              </div>
              <a href="/qlr/admin/edit-blog?id=<?php echo $blog['id']; ?>" class="text-sm text-primary hover:text-primary/80 whitespace-nowrap">
                <i class="fas fa-edit mr-1"></i> Edit
              </a>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if (empty($recentBlogs)): ?>
          <p class="text-sm text-slate-500 text-center py-8">No blogs yet. <a href="/qlr/admin/create-blog" class="text-primary hover:underline">Create your first blog</a></p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Recent Contacts -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
          <i class="fas fa-envelope text-primary"></i> Recent Contacts
        </h2>
        <a href="/qlr/admin/contacts" class="text-sm text-primary hover:text-primary/80 font-semibold">View All</a>
      </div>
      
      <div class="space-y-3">
        <?php foreach ($recentContacts as $contact): ?>
          <div class="border border-slate-200 rounded-lg p-4 hover:bg-slate-50 transition">
            <h3 class="font-semibold text-slate-900 mb-1"><?php echo htmlspecialchars($contact['name']); ?></h3>
            <p class="text-sm text-slate-600 mb-2"><?php echo htmlspecialchars(substr($contact['message'], 0, 100)) . (strlen($contact['message']) > 100 ? '...' : ''); ?></p>
            <p class="text-xs text-slate-500">Email: <?php echo htmlspecialchars($contact['email']); ?> • <?php echo date('M d, Y · h:i A', strtotime($contact['created_at'])); ?></p>
          </div>
        <?php endforeach; ?>
        <?php if (empty($recentContacts)): ?>
          <p class="text-sm text-slate-500 text-center py-8">No contact queries yet</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- QUICK ACTIONS -->
  <div class="bg-gradient-to-r from-primary to-primary/80 rounded-xl shadow-lg p-8 text-white">
    <h2 class="text-2xl font-bold mb-2">Quick Actions</h2>
    <p class="text-white/90 mb-6">Manage your website content efficiently</p>
    
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <a href="/qlr/admin/create-blog" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-lg p-4 transition text-center">
        <i class="fas fa-plus-circle text-3xl mb-2"></i>
        <p class="font-semibold">New Blog Post</p>
      </a>
      <a href="/qlr/admin/contacts" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-lg p-4 transition text-center">
        <i class="fas fa-envelope-open text-3xl mb-2"></i>
        <p class="font-semibold">View Contacts</p>
      </a>
      <a href="/qlr/admin/settings" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-lg p-4 transition text-center">
        <i class="fas fa-cog text-3xl mb-2"></i>
        <p class="font-semibold">Settings</p>
      </a>
      <a href="/qlr/admin/users" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-lg p-4 transition text-center">
        <i class="fas fa-users-cog text-3xl mb-2"></i>
        <p class="font-semibold">Manage Admins</p>
      </a>
    </div>
  </div>
</main>
</body>
</html>
