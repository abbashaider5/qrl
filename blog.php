<?php require __DIR__.'/includes/db.php'; ?>
<?php include __DIR__.'/includes/header.php'; ?>

<main id="blog">
	<!-- Hero Section -->
	<section class="relative bg-gradient-to-br from-[#0C0A2E] to-[#1a1742] text-white py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="max-w-3xl text-center mx-auto">
				<p class="text-sm uppercase tracking-[0.25em] text-[#EC8123] mb-4">Our Blog</p>
				<h1 class="text-4xl sm:text-5xl font-bold mb-6">Latest Insights</h1>
				<p class="text-xl text-slate-200">Expert advice, industry news, and tips for luxury ground transportation</p>
			</div>
		</div>
	</section>

	<!-- Blog Grid -->
	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<?php $rows = $pdo->query('SELECT id, title, slug, SUBSTRING(content,1,220) AS excerpt, created_at FROM blogs WHERE slug IS NOT NULL AND slug != "" ORDER BY created_at DESC')->fetchAll(); ?>
			<?php if (empty($rows)): ?>
				<div class="text-center py-16">
					<svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
					<h3 class="text-xl font-semibold text-slate-900 mb-2">No blog posts yet</h3>
					<p class="text-slate-600">Check back soon for updates!</p>
				</div>
			<?php else: ?>
				<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
					<?php foreach ($rows as $r): 
						$cleanExcerpt = strip_tags($r['excerpt']);
					?>
						<article class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden">
							<div class="p-6 flex flex-col gap-3 h-full">
								<div class="space-y-1">
									<p class="text-xs uppercase tracking-wide text-[#EC8123] font-semibold"><?php echo date('M d, Y', strtotime($r['created_at'])); ?></p>
									<h2 class="text-xl font-bold text-slate-900 line-clamp-2"><?php echo htmlspecialchars($r['title']); ?></h2>
								</div>
								<p class="text-sm text-slate-600 flex-grow line-clamp-4"><?php echo htmlspecialchars($cleanExcerpt); ?>...</p>
								<a href="/qlr/blog/<?php echo htmlspecialchars($r['slug']); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123] hover:text-[#d67520] transition">
									Read more
									<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php include __DIR__.'/includes/footer.php'; ?>
