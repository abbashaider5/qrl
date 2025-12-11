<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';

// Get blog slug from URL path
$requestUri = $_SERVER['REQUEST_URI'];
$slug = basename(parse_url($requestUri, PHP_URL_PATH));

// Fallback to ID parameter if slug not found (backward compatibility)
if (empty($slug) || $slug === 'blog-post.php' || $slug === 'blog-post') {
    if (isset($_GET['id'])) {
        $blog_id = intval($_GET['id']);
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->execute([$blog_id]);
        $blog = $stmt->fetch();
        
        // Redirect to SEO-friendly URL if slug exists
        if ($blog && !empty($blog['slug'])) {
            header('Location: /qlr/blog/' . $blog['slug']);
            exit;
        }
    } else {
        header('Location: /qlr/blog');
        exit;
    }
} else {
    // Fetch blog post by slug
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ?");
    $stmt->execute([$slug]);
    $blog = $stmt->fetch();
}

if (!$blog) {
    header('Location: /qlr/blog');
    exit;
}

// Increment view count
incrementBlogViews($pdo, $blog['id']);

// Track visitor
trackVisitor($pdo);

// Get site settings
$siteSettings = getSiteSettings($pdo);

// Use blog meta or fallback to site meta
$pageTitle = !empty($blog['meta_title']) ? $blog['meta_title'] : $blog['title'] . ' | ' . ($siteSettings['site_name'] ?? 'QLR');
$metaDescription = !empty($blog['meta_description']) ? $blog['meta_description'] : substr(strip_tags($blog['content']), 0, 160);
$metaKeywords = !empty($blog['meta_keywords']) ? $blog['meta_keywords'] : ($siteSettings['site_meta_keywords'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($metaKeywords); ?>">
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
  <meta property="og:type" content="article">
  
  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: "Plus Jakarta Sans", system-ui, sans-serif; }
    .blog-content { color: #334155; line-height: 1.8; }
    .blog-content img { max-width: 100%; height: auto; margin: 1.5rem 0; }
    .blog-content h1 { font-size: 2rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; }
    .blog-content h2 { font-size: 1.75rem; font-weight: 600; margin-top: 2rem; margin-bottom: 1rem; color: #1e293b; }
    .blog-content h3 { font-size: 1.5rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #334155; }
    .blog-content h4 { font-size: 1.25rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.75rem; color: #475569; }
    .blog-content p { margin-bottom: 1.25rem; }
    .blog-content ul, .blog-content ol { margin-bottom: 1.25rem; padding-left: 2rem; }
    .blog-content ul { list-style-type: disc; }
    .blog-content ol { list-style-type: decimal; }
    .blog-content li { margin-bottom: 0.5rem; line-height: 1.7; }
    .blog-content a { color: #e65a0a; text-decoration: underline; }
    .blog-content a:hover { color: #c54e08; }
    .blog-content blockquote { border-left: 4px solid #F6B530; padding-left: 1rem; margin: 1.5rem 0; font-style: italic; color: #64748b; }
    .blog-content pre { background: #f1f5f9; padding: 1rem; overflow-x: auto; margin: 1.5rem 0; border-radius: 0.5rem; }
    .blog-content code { background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.9em; }
    .blog-content pre code { background: none; padding: 0; }
    .blog-content table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
    .blog-content th, .blog-content td { border: 1px solid #e2e8f0; padding: 0.75rem; text-align: left; }
    .blog-content th { background: #f8fafc; font-weight: 600; }
    .blog-content strong { font-weight: 600; color: #1e293b; }
    .blog-content em { font-style: italic; }
  </style>
</head>
<body class="bg-white text-slate-900">
	<header class="bg-[#FFF8F2] border-b border-slate-200 relative z-30">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between py-3">
				<a href="/qlr/" class="flex items-center gap-3">
					<img src="https://quickluxuryride.com/wp-content/uploads/2024/03/logo.png" alt="Quick Luxury Ride logo" class="h-10 w-auto">
				</a>
				<nav class="hidden lg:flex items-center gap-8 text-[13px] font-semibold uppercase tracking-wide text-slate-900">
					<div class="relative" data-dropdown="services">
						<button class="flex items-center gap-1 px-2 py-1 rounded-md hover:bg-[#FFF8F2]" data-dropdown-toggle="services">Our Services
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-slate-500"><path d="M12 15.5 7.5 11h9L12 15.5Z"/></svg>
						</button>
					<div class="absolute left-0 mt-3 w-56 bg-white border border-slate-200 shadow-xl hidden rounded-lg p-2 space-y-1" data-dropdown-menu="services">
						<a href="services" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Overview</a>
						<a href="services#corporate" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Corporate Mobility</a>
						<a href="services#airport" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Airport Transfers</a>
						<a href="business" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Strategic partnerships</a>
						</div>
					</div>
					<div class="relative" data-dropdown="business">
						<button class="flex items-center gap-1 px-2 py-1 rounded-md hover:bg-[#FFF8F2]" data-dropdown-toggle="business">For business
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-slate-500"><path d="M12 15.5 7.5 11h9L12 15.5Z"/></svg>
						</button>
					<div class="absolute left-0 mt-3 w-56 bg-white border border-slate-200 shadow-xl hidden rounded-lg p-2 space-y-1" data-dropdown-menu="business">
						<a href="business" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Corporations</a>
						<a href="business" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Travel agencies</a>
						<a href="business" class="block px-3 py-2 rounded-md hover:bg-[#FFF8F2]">Strategic partners</a>
					</div>
				</div>
				<a href="fleet" class="hover:text-[#e65a0a]">Fleet</a>
				<a href="about" class="hover:text-[#e65a0a]">About</a>
				<a href="contact" class="hover:text-[#e65a0a]">Contact</a>
				<a href="blog" class="hover:text-[#e65a0a]">Blog</a>
			</nav>
		<div class="hidden lg:flex items-center gap-6 text-[13px] font-semibold uppercase tracking-wide text-slate-900">
			<div class="relative" id="bookNav">
				<button id="bookToggle" class="flex items-center gap-1 px-5 py-2.5 bg-[#0C0A2E] text-white rounded-lg hover:bg-[#15133B] transition-all duration-300">Book Now
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
						<path d="M12 15.5 7.5 11h9L12 15.5Z"/>
					</svg>
				</button>
				<div id="bookMenu" class="absolute left-0 mt-2 w-56 bg-white text-slate-900 border border-slate-200 shadow-lg rounded-lg hidden z-40 p-2 space-y-1">
					<a href="#" class="block px-4 py-2 text-xs uppercase tracking-wide rounded-md hover:bg-[#FFF8F2] transition">Ground Transportation</a>
					<a href="#" class="block px-4 py-2 text-xs uppercase tracking-wide rounded-md hover:bg-[#FFF8F2] transition">Private Jet</a>
				</div>
			</div>
			<div class="flex items-center gap-2 pl-5 border-l border-slate-300">
						<a href="#signin" class="flex items-center gap-2 hover:text-[#e65a0a]">Sign In
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-slate-500">
								<path d="M9.47 5.47a.75.75 0 0 1 1.06 0l6 6a.75.75 0 0 1 0 1.06l-6 6a.75.75 0 1 1-1.06-1.06L14.94 12 9.47 6.53a.75.75 0 0 1 0-1.06Z"/>
							</svg>
						</a>
					</div>
				</div>
				<button id="mobileToggle" class="lg:hidden p-2 rounded-md border border-slate-200 text-slate-800" aria-label="Open navigation">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
					</svg>
				</button>
			</div>
			<div id="mobileMenu" class="lg:hidden origin-top hidden flex-col gap-4 pb-4 text-sm font-semibold uppercase tracking-wide">
				<div class="flex justify-between items-center border-b border-slate-200 pb-3">
					<span class="text-slate-900 font-bold">Menu</span>
					<button id="mobileClose" class="p-2 rounded-md hover:bg-slate-100" aria-label="Close navigation">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
				<a href="services" class="py-2 border-b border-slate-200">Services</a>
				<a href="services#airport" class="py-2 border-b border-slate-200">Airport Transfers</a>
				<a href="fleet" class="py-2 border-b border-slate-200">Fleet</a>
				<a href="business" class="py-2 border-b border-slate-200">Business Travel</a>
				<a href="about" class="py-2 border-b border-slate-200">About</a>
				<a href="blog" class="py-2 border-b border-slate-200">Blog</a>
				<a href="contact" class="py-2 border-b border-slate-200">Contact</a>
				<div class="border-b border-slate-200 pb-2">
					<p class="text-slate-500 text-xs mb-1">Book Now</p>
					<div class="pl-2 space-y-2">
						<a href="#" class="block text-slate-800">Ground Transportation</a>
						<a href="#" class="block text-slate-800">Private Jet</a>
					</div>
				</div>
				<div class="flex items-center justify-between pt-2">
					<a href="#signin" class="flex items-center gap-2 text-slate-800">Sign In
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-slate-500">
							<path d="M9.47 5.47a.75.75 0 0 1 1.06 0l6 6a.75.75 0 0 1 0 1.06l-6 6a.75.75 0 1 1-1.06-1.06L14.94 12 9.47 6.53a.75.75 0 0 1 0-1.06Z"/>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</header>

  <main>
    <section class="bg-gradient-to-r from-[#0C0A2E] via-[#15133B] to-[#0C0A2E] text-white py-16 sm:py-20">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h1 class="text-4xl sm:text-5xl font-semibold leading-tight"><?php echo htmlspecialchars($blog['title']); ?></h1>
        <div class="flex flex-wrap gap-4 text-sm text-slate-200">
          <span>By <?php echo htmlspecialchars($siteSettings['site_name'] ?? 'QLR'); ?></span>
          <span aria-hidden="true" class="text-slate-500">•</span>
          <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
          <span aria-hidden="true" class="text-slate-500">•</span>
          <span><i class="fas fa-eye mr-1"></i><?php echo number_format($blog['views'] + 1); ?> views</span>
        </div>
      </div>
    </section>

    <article class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
      <div class="blog-content">
        <?php echo $blog['content']; ?>
      </div>
      
      <div class="mt-12 pt-8 border-t border-slate-200">
        <a href="/qlr/blog" class="inline-flex items-center gap-2 text-[#e65a0a] hover:text-[#c54e08] font-semibold">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Blog
        </a>
      </div>
    </article>
  </main>

  <footer class="bg-[#0C0A2E] text-white pt-14 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-10">
      <div class="space-y-3">
        <?php if (!empty($siteSettings['site_logo'])): ?>
          <img src="<?php echo htmlspecialchars($siteSettings['site_logo']); ?>" alt="<?php echo htmlspecialchars($siteSettings['site_name'] ?? 'QLR'); ?> logo" class="h-10 w-auto">
        <?php else: ?>
          <img src="https://quickluxuryride.com/wp-content/uploads/2024/03/logo.png" alt="Quick Luxury Ride logo" class="h-10 w-auto">
        <?php endif; ?>
        <p class="text-sm text-slate-300"><?php echo htmlspecialchars($metaDescription); ?></p>
      </div>
      <div>
        <h4 class="font-semibold mb-3">Company</h4>
        <ul class="space-y-2 text-sm text-slate-200">
          <li><a href="/qlr/about" class="hover:text-white">About</a></li>
          <li><a href="/qlr/contact" class="hover:text-white">Contact</a></li>
          <li><a href="/qlr/business" class="hover:text-white">Business</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-3">Services</h4>
        <ul class="space-y-2 text-sm text-slate-200">
          <li><a href="/qlr/services" class="hover:text-white">Services</a></li>
          <li><a href="/qlr/fleet" class="hover:text-white">Fleet</a></li>
          <li><a href="/qlr/blog" class="hover:text-white">Blog</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold mb-3">Support</h4>
        <ul class="space-y-2 text-sm text-slate-200">
          <li><a href="tel:0000000000" class="hover:text-white">(000) 000-0000</a></li>
          <li><a href="mailto:support@quickluxuryride.com" class="hover:text-white">support@quickluxuryride.com</a></li>
        </ul>
      </div>
    </div>
    <div class="mt-10 border-t border-white/15 pt-6 text-center text-sm text-slate-300">© <span id="year"></span> <?php echo htmlspecialchars($siteSettings['site_name'] ?? 'Quick Luxury Ride'); ?>. All rights reserved.</div>
  </footer>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
    
    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileClose');
    if (mobileToggle && mobileMenu) {
      mobileToggle.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
    }
    if (mobileClose && mobileMenu) {
      mobileClose.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    }
    
    // Desktop dropdown menus
    document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const menuName = btn.getAttribute('data-dropdown-toggle');
        const menu = document.querySelector(`[data-dropdown-menu="${menuName}"]`);
        const allMenus = document.querySelectorAll('[data-dropdown-menu]');
        allMenus.forEach(m => {
          if (m !== menu) m.classList.add('hidden');
        });
        if (menu) menu.classList.toggle('hidden');
      });
    });
    
    // Book Now dropdown
    const bookToggle = document.getElementById('bookToggle');
    const bookMenu = document.getElementById('bookMenu');
    if (bookToggle && bookMenu) {
      bookToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        bookMenu.classList.toggle('hidden');
      });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
      document.querySelectorAll('[data-dropdown-menu]').forEach(m => m.classList.add('hidden'));
      if (bookMenu) bookMenu.classList.add('hidden');
    });
  </script>
</body>
</html>
