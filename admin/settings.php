<?php require __DIR__.'/includes/middleware.php'; ensure_authenticated(); ?>
<?php require __DIR__.'/includes/db.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?php

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updates = [];
    
    // Handle text fields (including all page-specific meta fields)
    $fields = [
        'site_name', 'site_meta_title', 'site_meta_description', 'site_meta_keywords',
        'page_home_meta_title', 'page_home_meta_description', 'page_home_meta_keywords',
        'page_about_meta_title', 'page_about_meta_description', 'page_about_meta_keywords',
        'page_services_meta_title', 'page_services_meta_description', 'page_services_meta_keywords',
        'page_fleet_meta_title', 'page_fleet_meta_description', 'page_fleet_meta_keywords',
        'page_contact_meta_title', 'page_contact_meta_description', 'page_contact_meta_keywords',
        'page_business_meta_title', 'page_business_meta_description', 'page_business_meta_keywords',
        'page_blog_meta_title', 'page_blog_meta_description', 'page_blog_meta_keywords',
    ];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = trim($_POST[$field]);
            $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = NOW()');
            $stmt->execute([$field, $value, $value]);
            $updates[] = $field;
        }
    }
    
    // Handle logo upload
    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $filename = $_FILES['site_logo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $new_filename = 'logo-' . time() . '.' . $ext;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $upload_path)) {
                $logo_url = '/qlr/uploads/' . $new_filename;
                $stmt = $pdo->prepare('UPDATE settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?');
                $stmt->execute([$logo_url, 'site_logo']);
                $updates[] = 'site_logo';
            }
        }
    }
    
    $success = count($updates) > 0;
    $message = $success ? 'Settings saved successfully!' : 'No changes were made.';
}

// Fetch current settings
$settings = [];
$stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<?php include __DIR__.'/includes/common-header.php'; ?>
<?php include __DIR__.'/includes/common-sidebar.php'; ?>
<?php include __DIR__.'/includes/common-navbar.php'; ?>
<main class="lg:ml-[260px] mt-16 p-6 lg:p-8">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Settings</h1>
    <p class="text-slate-600 mt-1">Manage website configuration and SEO settings</p>
  </div>

  <?php if (isset($success)): ?>
    <div id="alertBox" class="mb-6 p-4 rounded-lg border <?php echo $success ? 'bg-green-50 border-green-200 text-green-700' : 'bg-yellow-50 border-yellow-200 text-yellow-700'; ?>">
      <i class="fas fa-<?php echo $success ? 'check-circle' : 'info-circle'; ?> mr-2"></i>
      <?php echo htmlspecialchars($message); ?>
    </div>
  <?php endif; ?>

  <!-- Tabs Navigation -->
  <div class="mb-6 border-b border-slate-200">
    <div class="flex gap-4">
      <button type="button" class="tab-btn px-4 py-3 font-semibold text-slate-600 border-b-2 border-transparent hover:text-primary hover:border-primary transition active" data-tab="general">
        <i class="fas fa-cog mr-2"></i>General
      </button>
      <button type="button" class="tab-btn px-4 py-3 font-semibold text-slate-600 border-b-2 border-transparent hover:text-primary hover:border-primary transition" data-tab="seo">
        <i class="fas fa-search mr-2"></i>Site SEO
      </button>
      <button type="button" class="tab-btn px-4 py-3 font-semibold text-slate-600 border-b-2 border-transparent hover:text-primary hover:border-primary transition" data-tab="pages">
        <i class="fas fa-file-alt mr-2"></i>Page SEO
      </button>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- General Tab -->
    <div class="tab-content" data-tab-content="general">
    <!-- Website Logo Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
        <i class="fas fa-image text-primary"></i> Website Logo
      </h2>
      
      <div class="mb-4">
        <?php if (!empty($settings['site_logo'])): ?>
          <div class="mb-4 p-4 bg-slate-50 rounded-lg inline-block">
            <p class="text-sm text-slate-600 mb-2">Current Logo:</p>
            <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Current Logo" class="max-h-24 object-contain">
          </div>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Upload New Logo</label>
        <input type="file" name="site_logo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 file:cursor-pointer border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50">
        <p class="mt-2 text-xs text-slate-500">Accepted formats: JPG, PNG, GIF, SVG. Max size: 2MB</p>
      </div>
    </div>

    <!-- Website Information -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
        <i class="fas fa-globe text-primary"></i> Website Information
      </h2>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Site Name</label>
          <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900" placeholder="QLR">
          <p class="mt-1 text-xs text-slate-500">The name of your website</p>
        </div>
      </div>
    </div>
    </div>

    <!-- Site SEO Tab -->
    <div class="tab-content hidden" data-tab-content="seo">

    <!-- SEO Meta Data -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
      <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
        <i class="fas fa-search text-primary"></i> Default SEO Meta Data
      </h2>
      <p class="text-sm text-slate-600 mb-4">These are the default meta tags used across your website. Page-specific settings can override these.</p>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
          <input type="text" name="site_meta_title" id="meta_title" value="<?php echo htmlspecialchars($settings['site_meta_title'] ?? ''); ?>" maxlength="60" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900" placeholder="QLR - Quality Luxury Rentals">
          <div class="flex justify-between mt-1">
            <p class="text-xs text-slate-500">Recommended: 50-60 characters</p>
            <p class="text-xs text-slate-500"><span id="meta_title_count">0</span>/60</p>
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
          <textarea name="site_meta_description" id="meta_description" maxlength="160" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900 resize-none" placeholder="Premium car rental services..."><?php echo htmlspecialchars($settings['site_meta_description'] ?? ''); ?></textarea>
          <div class="flex justify-between mt-1">
            <p class="text-xs text-slate-500">Recommended: 150-160 characters</p>
            <p class="text-xs text-slate-500"><span id="meta_description_count">0</span>/160</p>
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
          <input type="text" name="site_meta_keywords" value="<?php echo htmlspecialchars($settings['site_meta_keywords'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900" placeholder="car rental, luxury cars, vehicle hire">
          <p class="mt-1 text-xs text-slate-500">Separate keywords with commas</p>
        </div>
      </div>
    </div>
    </div>

    <!-- Page SEO Tab -->
    <div class="tab-content hidden" data-tab-content="pages">
    <?php
    $pages = [
      'home' => ['Home Page', 'Main landing page SEO'],
      'about' => ['About Page', 'About us page SEO'],
      'services' => ['Services Page', 'Services listing page SEO'],
      'fleet' => ['Fleet Page', 'Fleet showcase page SEO'],
      'contact' => ['Contact Page', 'Contact form page SEO'],
      'business' => ['Business Page', 'Corporate solutions page SEO'],
      'blog' => ['Blog Page', 'Blog listing page SEO'],
    ];
    
    foreach ($pages as $page => $info):
    ?>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-4">
      <h2 class="text-xl font-bold text-slate-900 mb-2 flex items-center gap-2">
        <i class="fas fa-file-alt text-primary"></i> <?php echo $info[0]; ?>
      </h2>
      <p class="text-sm text-slate-600 mb-4"><?php echo $info[1]; ?></p>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
          <input type="text" name="page_<?php echo $page; ?>_meta_title" value="<?php echo htmlspecialchars($settings['page_' . $page . '_meta_title'] ?? ''); ?>" maxlength="60" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900" placeholder="Page Title | QLR">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
          <textarea name="page_<?php echo $page; ?>_meta_description" maxlength="160" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900 resize-none" placeholder="Brief description..."><?php echo htmlspecialchars($settings['page_' . $page . '_meta_description'] ?? ''); ?></textarea>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
          <input type="text" name="page_<?php echo $page; ?>_meta_keywords" value="<?php echo htmlspecialchars($settings['page_' . $page . '_meta_keywords'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-slate-900" placeholder="keyword1, keyword2, keyword3">
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 justify-end">
      <a href="/qlr/admin" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
        Cancel
      </a>
      <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg shadow-lg shadow-primary/30 transition">
        <i class="fas fa-save mr-2"></i> Save Settings
      </button>
    </div>
  </form>
</main>

<script>
// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const tabName = btn.dataset.tab;
    
    // Update button states
    document.querySelectorAll('.tab-btn').forEach(b => {
      b.classList.remove('active', 'text-primary', 'border-primary');
      b.classList.add('text-slate-600', 'border-transparent');
    });
    btn.classList.add('active', 'text-primary', 'border-primary');
    btn.classList.remove('text-slate-600', 'border-transparent');
    
    // Update content visibility
    document.querySelectorAll('.tab-content').forEach(content => {
      content.classList.add('hidden');
    });
    document.querySelector(`[data-tab-content="${tabName}"]`).classList.remove('hidden');
  });
});

// Character counters
function updateCounter(inputId, counterId) {
  const input = document.getElementById(inputId);
  const counter = document.getElementById(counterId);
  if (input && counter) {
    counter.textContent = input.value.length;
    input.addEventListener('input', () => {
      counter.textContent = input.value.length;
    });
  }
}

updateCounter('meta_title', 'meta_title_count');
updateCounter('meta_description', 'meta_description_count');

// Auto-hide alert
setTimeout(() => {
  const alertBox = document.getElementById('alertBox');
  if (alertBox) {
    alertBox.style.transition = 'opacity 0.5s';
    alertBox.style.opacity = '0';
    setTimeout(() => alertBox.remove(), 500);
  }
}, 5000);
</script>
</body>
</html>