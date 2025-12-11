<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<?php require_once __DIR__ . '/../includes/activity_logger.php'; ?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Create Blog</h1>
    <p class="text-slate-600 mt-1">Add a new blog post with SEO optimization</p>
  </div>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $title = trim($_POST['title'] ?? '');
      $slug = trim($_POST['slug'] ?? '');
      $content = trim($_POST['content'] ?? '');
      $meta_title = trim($_POST['meta_title'] ?? '');
      $meta_description = trim($_POST['meta_description'] ?? '');
      $meta_keywords = trim($_POST['meta_keywords'] ?? '');
      $created_by = $_SESSION['admin_id'];
      $error = '';
      if ($title === '' || $slug === '' || $content === '') {
          $error = 'Title, slug, and content are required.';
      } else {
          // Check if meta fields are empty, use defaults
          if ($meta_title === '') $meta_title = $title;
          if ($meta_description === '') $meta_description = substr(strip_tags($content), 0, 160);
          
          $stmt = $pdo->prepare('INSERT INTO blogs (title, slug, content, meta_title, meta_description, meta_keywords, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
          try { 
              $stmt->execute([$title, $slug, $content, $meta_title, $meta_description, $meta_keywords, $created_by]); 
              $blogId = $pdo->lastInsertId();
              logActivity($pdo, $created_by, 'blog_created', "Created blog: $title (ID: $blogId)");
          } catch (Throwable $e) { 
              $error = 'Slug must be unique or database error occurred.'; 
          }
      }
      if ($error !== '') echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg"><i class="fas fa-exclamation-circle mr-2"></i>'.htmlspecialchars($error).'</div>';
      else echo '<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg"><i class="fas fa-check-circle mr-2"></i>Blog created successfully.</div>';
  }
  ?>
  <form method="post" class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-5">
      <div class="grid md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
          <input name="title" id="blogTitle" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter blog title" required>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2">Slug <span class="text-red-500">*</span></label>
          <input name="slug" id="blogSlug" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="url-friendly-slug" required>
          <p class="text-xs text-slate-500 mt-1">Will be used in URL. Auto-generated from title if left blank.</p>
        </div>
      </div>

      <div class="border-t pt-5">
        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
          <i class="fas fa-edit text-primary"></i> Content <span class="text-red-500">*</span>
        </h3>
        <textarea name="content" id="blogContent" rows="12" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg" placeholder="Write your blog content here..." required></textarea>
      </div>

      <div class="border-t pt-5">
        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
          <i class="fas fa-search text-primary"></i> SEO Meta Tags
          <span class="text-xs font-normal text-slate-500 ml-2">(Optional - auto-generated if empty)</span>
        </h3>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
            <input name="meta_title" maxlength="60" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="SEO title (defaults to blog title)">
            <p class="text-xs text-slate-500 mt-1">Recommended: 50-60 characters</p>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
            <textarea name="meta_description" maxlength="160" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Brief description for search engines (defaults to content excerpt)"></textarea>
            <p class="text-xs text-slate-500 mt-1">Recommended: 150-160 characters</p>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
            <input name="meta_keywords" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="keyword1, keyword2, keyword3">
            <p class="text-xs text-slate-500 mt-1">Comma-separated keywords</p>
          </div>
        </div>
      </div>

      <div class="flex gap-3 pt-4">
        <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg shadow-primary/30 transition-all">
          <i class="fas fa-save"></i> Create Blog
        </button>
        <a href="/qlr/admin/blogs" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold transition-all">
          <i class="fas fa-times"></i> Cancel
        </a>
      </div>
    </div>
  </form>
</main>

<script>
  // Initialize CKEditor
  CKEDITOR.replace('blogContent', {
    height: 400,
    toolbar: [
      { name: 'document', items: ['Source', '-', 'Preview'] },
      { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
      { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
      '/',
      { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
      { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
      { name: 'links', items: ['Link', 'Unlink'] },
      { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
      '/',
      { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
      { name: 'colors', items: ['TextColor', 'BGColor'] },
      { name: 'tools', items: ['Maximize'] }
    ]
  });

  // Auto-generate slug from title
  document.getElementById('blogTitle').addEventListener('input', function() {
    const slug = this.value
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
    document.getElementById('blogSlug').value = slug;
  });
</script>
</body>
</html>