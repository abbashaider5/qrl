<?php
// Modern sidebar with icons and gradient
$current = basename($_SERVER['PHP_SELF']);
?>
<aside id="sidebar" class="fixed top-0 left-0 h-full w-[260px] bg-gradient-to-b from-slate-900 to-slate-800 text-white z-40 transition-transform duration-300 -translate-x-full lg:translate-x-0 overflow-y-auto">
  <div class="h-14 flex items-center px-6 border-b border-slate-700">
    <h1 class="text-lg font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">QLR Console</h1>
  </div>
  <nav class="p-3 space-y-0.5">
    <a href="/qlr/admin/index" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'index.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-chart-line w-4 text-center"></i>
      <span class="font-medium">Dashboard</span>
    </a>
    <div class="pt-3 pb-1 px-3">
      <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Content</p>
    </div>
    <a href="/qlr/admin/blogs" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'blogs.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-newspaper w-4 text-center"></i>
      <span class="font-medium">Blogs</span>
    </a>
    <a href="/qlr/admin/create-blog" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'create-blog.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-plus-circle w-4 text-center"></i>
      <span class="font-medium">Create Blog</span>
    </a>
    <div class="pt-3 pb-1 px-3">
      <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Management</p>
    </div>
    <a href="/qlr/admin/contacts" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'contacts.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-envelope w-4 text-center"></i>
      <span class="font-medium">Contacts</span>
    </a>
    <a href="/qlr/admin/users" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'users.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-users w-4 text-center"></i>
      <span class="font-medium">Admins</span>
    </a>
    <a href="/qlr/admin/new-admin" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'new-admin.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-user-plus w-4 text-center"></i>
      <span class="font-medium">New Admin</span>
    </a>
    <div class="pt-3 pb-1 px-3">
      <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">System</p>
    </div>
    <a href="/qlr/admin/settings" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'settings.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-cog w-4 text-center"></i>
      <span class="font-medium">Settings</span>
    </a>
    <a href="/qlr/admin/logs" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'logs.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-history w-4 text-center"></i>
      <span class="font-medium">Activity Logs</span>
    </a>
    <a href="/qlr/admin/change-password" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm <?php echo $current === 'change-password.php' ? 'bg-primary text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white'; ?>">
      <i class="fas fa-key w-4 text-center"></i>
      <span class="font-medium">Change Password</span>
    </a>
    <a href="/qlr/admin/logout" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300">
      <i class="fas fa-sign-out-alt w-4 text-center"></i>
      <span class="font-medium">Logout</span>
    </a>
  </nav>
</aside>