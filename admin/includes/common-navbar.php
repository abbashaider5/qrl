<?php
// Modern admin navbar with search and profile
?>
<nav class="bg-white border-b border-slate-200 h-16 fixed top-0 right-0 left-0 lg:left-[260px] z-30 flex items-center justify-between px-6">
  <div class="flex items-center gap-4 flex-1">
    <button id="mobileSidebarToggle" class="lg:hidden text-slate-600 hover:text-slate-900">
      <i class="fas fa-bars text-xl"></i>
    </button>
    <div class="relative max-w-md w-full">
      <input type="search" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-100 border-0 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary">
      <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
    </div>
  </div>
  <div class="flex items-center gap-4">
    <button class="relative text-slate-600 hover:text-slate-900">
      <i class="far fa-bell text-xl"></i>
      <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
    </button>
    <div class="flex items-center gap-3">
      <div class="text-right hidden sm:block">
        <p class="text-sm font-semibold"><?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'Admin'); ?></p>
        <p class="text-xs text-slate-500">Administrator</p>
      </div>
      <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-semibold">
        <?php echo strtoupper(substr($_SESSION['admin_email'] ?? 'A', 0, 1)); ?>
      </div>
    </div>
  </div>
</nav>
<script>
  document.getElementById('mobileSidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar')?.classList.toggle('-translate-x-full');
  });
</script>