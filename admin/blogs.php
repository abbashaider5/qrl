<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
    <div>
      <h1 class="text-3xl font-bold text-slate-900">Blogs</h1>
      <p class="text-slate-600 mt-1">Manage your blog posts</p>
    </div>
    <a href="/qlr/admin/create-blog" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-lg shadow-primary/30 transition-all">
      <i class="fas fa-plus"></i> Create Blog
    </a>
  </div>
  </div>
  <?php 
  $stmt = $pdo->query('
    SELECT b.id, b.title, b.slug, b.views, b.created_at, b.created_by, a.email as creator_email 
    FROM blogs b 
    LEFT JOIN admins a ON b.created_by = a.id 
    ORDER BY b.created_at DESC
  ');
  $rows = $stmt->fetchAll();
  ?>
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Slug</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Created By</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Views</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Created</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
        <?php foreach ($rows as $r): ?>
          <tr class="hover:bg-slate-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-slate-900"><?php echo htmlspecialchars($r['title']); ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo htmlspecialchars($r['slug']); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
              <?php echo $r['creator_email'] ? htmlspecialchars($r['creator_email']) : '<span class="text-slate-400">Unknown</span>'; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
              <span class="inline-flex items-center gap-1">
                <i class="fas fa-eye text-slate-400"></i>
                <?php echo number_format($r['views'] ?? 0); ?>
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?php echo date('M d, Y', strtotime($r['created_at'])); ?></td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center gap-3">
                <a class="text-primary hover:text-primary/80 font-medium text-sm" href="/qlr/admin/edit-blog?id=<?php echo (int)$r['id']; ?>">
                  <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a class="text-slate-600 hover:text-slate-800 font-medium text-sm" href="/qlr/blog/<?php echo htmlspecialchars($r['slug']); ?>" target="_blank">
                  <i class="fas fa-external-link-alt mr-1"></i> View
                </a>
                <button onclick="deleteBlog(<?php echo (int)$r['id']; ?>, '<?php echo htmlspecialchars(addslashes($r['title'])); ?>')" class="text-red-600 hover:text-red-800 font-medium text-sm">
                  <i class="fas fa-trash mr-1"></i> Delete
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php if (count($rows) === 0): ?>
      <div class="p-12 text-center">
        <i class="fas fa-newspaper text-4xl text-slate-300 mb-3"></i>
        <p class="text-slate-600">No blogs yet. Create your first blog post.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
          <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold text-slate-900">Delete Blog Post</h3>
        </div>
      </div>
      <p class="text-slate-600 mb-6">Are you sure you want to delete "<span id="deleteBlogTitle" class="font-semibold"></span>"? This action cannot be undone.</p>
      <div class="flex justify-end gap-3">
        <button onclick="closeDeleteModal()" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg font-medium">Cancel</button>
        <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
let deleteBlogId = null;

function deleteBlog(id, title) {
  deleteBlogId = id;
  document.getElementById('deleteBlogTitle').textContent = title;
  document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
  document.getElementById('deleteModal').classList.add('hidden');
  deleteBlogId = null;
}

function confirmDelete() {
  if (!deleteBlogId) return;
  
  fetch('/qlr/admin/delete-blog.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ id: deleteBlogId })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      closeDeleteModal();
      location.reload();
    } else {
      alert(data.message || 'Failed to delete blog');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while deleting the blog');
  });
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeDeleteModal();
  }
});
</script>

</body>
</html>