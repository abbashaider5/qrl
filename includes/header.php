<?php 
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

// Track visitor
trackVisitor($pdo);

// Get site settings for meta data
$siteSettings = getSiteSettings($pdo);

// Determine page name from current file
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

// Get page-specific meta data or use site defaults
$pageMetaTitle = $siteSettings['page_' . $currentPage . '_meta_title'] ?? $siteSettings['site_meta_title'] ?? 'Quick Luxury Ride';
$pageMetaDescription = $siteSettings['page_' . $currentPage . '_meta_description'] ?? $siteSettings['site_meta_description'] ?? 'Premium chauffeur service in New York';
$pageMetaKeywords = $siteSettings['page_' . $currentPage . '_meta_keywords'] ?? $siteSettings['site_meta_keywords'] ?? 'luxury car rental, chauffeur service, New York';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($pageMetaTitle); ?></title>
	<meta name="description" content="<?php echo htmlspecialchars($pageMetaDescription); ?>">
	<meta name="keywords" content="<?php echo htmlspecialchars($pageMetaKeywords); ?>">
	
	<!-- Open Graph Meta Tags -->
	<meta property="og:title" content="<?php echo htmlspecialchars($pageMetaTitle); ?>">
	<meta property="og:description" content="<?php echo htmlspecialchars($pageMetaDescription); ?>">
	<meta property="og:type" content="website">
	
	<!-- Twitter Card Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo htmlspecialchars($pageMetaTitle); ?>">
	<meta name="twitter:description" content="<?php echo htmlspecialchars($pageMetaDescription); ?>">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		body { font-family: "Plus Jakarta Sans", system-ui, sans-serif; }
		.hero-bg { background: #0C0A2E url('https://media.gettyimages.com/id/1167901631/video/chauffeur-opens-back-door-of-black-limousine-with-discretion-senior-vip-businessman-is.jpg?s=640x640&k=20&c=PqRLvzGrU6uTWhd7fXAueV4pODvIyWuXMoWyzy_idic=') center/cover no-repeat; }
		.fade { transition: opacity 300ms ease; }
		.hero-bg-overlay { background: linear-gradient(115deg, rgba(52, 51, 80, 0.85), rgba(12,10,46,0.55), rgba(12,10,46,0.18)); }
	</style>
</head>
<body class="bg-white text-slate-900 scroll-smooth">
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