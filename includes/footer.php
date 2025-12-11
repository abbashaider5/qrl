
	<footer class="bg-[#0C0A2E] text-white pt-14 pb-10">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-10">
			<div class="space-y-3">
				<img src="https://quickluxuryride.com/wp-content/uploads/2024/03/logo.png" alt="Quick Luxury Ride logo" class="h-10 w-auto">
				<p class="text-sm text-slate-300">Based in New York, serving NYC and surrounding areas with premium black car service.</p>
			</div>
			<div>
				<h4 class="font-semibold mb-3">Company</h4>
				<ul class="space-y-2 text-sm text-slate-200">
					<li><a href="about" class="hover:text-white">About</a></li>
					<li><a href="contact" class="hover:text-white">Contact</a></li>
					<li><a href="business" class="hover:text-white">Business</a></li>
					<li><a href="#privacy" class="hover:text-white">Privacy</a></li>
				</ul>
			</div>
			<div>
				<h4 class="font-semibold mb-3">Services</h4>
				<ul class="space-y-2 text-sm text-slate-200">
					<li><a href="services#airport" class="hover:text-white">Airport Transfers</a></li>
					<li><a href="services#hourly" class="hover:text-white">Hourly</a></li>
					<li><a href="services#city" class="hover:text-white">City-to-City</a></li>
					<li><a href="services#corporate" class="hover:text-white">Corporate</a></li>
				</ul>
			</div>
			<div>
				<h4 class="font-semibold mb-3">Support</h4>
				<ul class="space-y-2 text-sm text-slate-200">
					<li><a href="#faq" class="hover:text-white">FAQ</a></li>
					<li><a href="tel:0000000000" class="hover:text-white">(000) 000-0000</a></li>
					<li><a href="mailto:support@quickluxuryride.com" class="hover:text-white">support@quickluxuryride.com</a></li>
				</ul>
			</div>
		</div>
		<div class="mt-10 border-t border-white/15 pt-6 text-center text-sm text-slate-300">© <span id="year"></span> Quick Luxury Ride. All rights reserved.</div>
	</footer>

	<script>
		// Year footer
		document.getElementById('year').textContent = new Date().getFullYear();

		// Mobile toggle
		const mobileToggle = document.getElementById('mobileToggle');
		const mobileMenu = document.getElementById('mobileMenu');
		const mobileClose = document.getElementById('mobileClose');
		if(mobileToggle && mobileMenu) {
			mobileToggle.addEventListener('click', () => {
				mobileMenu.classList.toggle('hidden');
				mobileMenu.classList.toggle('flex');
			});
		}
		if(mobileClose && mobileMenu) {
			mobileClose.addEventListener('click', () => {
				mobileMenu.classList.add('hidden');
				mobileMenu.classList.remove('flex');
			});
		}

		// Book dropdown
		const bookToggle = document.getElementById('bookToggle');
		const bookMenu = document.getElementById('bookMenu');
		if(bookToggle && bookMenu) {
			bookToggle.addEventListener('click', (e) => {
				e.stopPropagation();
				bookMenu.classList.toggle('hidden');
			});
			document.addEventListener('click', () => {
				bookMenu.classList.add('hidden');
			});
		}

		// Service dropdown
		document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.stopPropagation();
				const targetId = btn.getAttribute('data-dropdown-toggle');
				const menu = document.querySelector(`[data-dropdown-menu="${targetId}"]`);
				if(menu) {
					document.querySelectorAll('[data-dropdown-menu]').forEach(m => {
						if(m !== menu) m.classList.add('hidden');
					});
					menu.classList.toggle('hidden');
				}
			});
		});
		document.addEventListener('click', () => {
			document.querySelectorAll('[data-dropdown-menu]').forEach(m => m.classList.add('hidden'));
		});
	</script>
</body>
</html>