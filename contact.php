<?php include 'includes/header.php'; ?>

<main id="contact">
	<!-- Hero Section -->
	<section class="relative bg-gradient-to-br from-[#0C0A2E] to-[#1a1742] text-white py-20">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="max-w-3xl">
				<p class="text-sm uppercase tracking-[0.25em] text-[#EC8123] mb-4">Contact Us</p>
				<h1 class="text-4xl sm:text-5xl font-bold mb-6">Get in touch with our team</h1>
				<p class="text-xl text-slate-200">Have questions about our chauffeur service? Need a custom quote? We're here to help.</p>
			</div>
		</div>
	</section>

	<!-- Contact Form Section -->
	<section class="py-16 bg-white">
		<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="grid lg:grid-cols-2 gap-12">
				
				<!-- Contact Form -->
				<div>
					<h2 class="text-2xl font-bold text-slate-900 mb-6">Send us a message</h2>
					<form id="contactForm" class="space-y-6">
						<div>
							<label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
							<input 
								type="text" 
								id="name" 
								name="name" 
								required 
								class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#EC8123] focus:border-transparent outline-none transition"
								placeholder="John Doe"
							/>
						</div>
						<div>
							<label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
							<input 
								type="email" 
								id="email" 
								name="email" 
								required 
								class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#EC8123] focus:border-transparent outline-none transition"
								placeholder="john@company.com"
							/>
						</div>
						<div>
							<label for="message" class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
							<textarea 
								id="message" 
								name="message" 
								required 
								rows="6"
								class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#EC8123] focus:border-transparent outline-none transition resize-none"
								placeholder="Tell us about your transportation needs..."
							></textarea>
						</div>
						<button 
							type="submit" 
							class="w-full bg-[#EC8123] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#d67520] transition disabled:opacity-50 disabled:cursor-not-allowed"
						>
							Send Message
						</button>
					</form>
					<div id="contactStatus" class="mt-4 text-sm font-medium"></div>
				</div>

				<!-- Contact Information -->
				<div>
					<h2 class="text-2xl font-bold text-slate-900 mb-6">Contact Information</h2>
					<div class="space-y-6">
						<div class="flex items-start gap-4">
							<div class="w-12 h-12 bg-[#EC8123]/10 rounded-lg flex items-center justify-center flex-shrink-0">
								<svg class="w-6 h-6 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
							</div>
							<div>
								<h3 class="font-semibold text-slate-900 mb-1">Phone</h3>
								<a href="tel:0000000000" class="text-slate-600 hover:text-[#EC8123]">(000) 000-0000</a>
								<p class="text-sm text-slate-500 mt-1">Available 24/7 for bookings and support</p>
							</div>
						</div>
						<div class="flex items-start gap-4">
							<div class="w-12 h-12 bg-[#EC8123]/10 rounded-lg flex items-center justify-center flex-shrink-0">
								<svg class="w-6 h-6 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
							</div>
							<div>
								<h3 class="font-semibold text-slate-900 mb-1">Email</h3>
								<a href="mailto:support@quickluxuryride.com" class="text-slate-600 hover:text-[#EC8123]">support@quickluxuryride.com</a>
								<p class="text-sm text-slate-500 mt-1">We respond within 2 hours during business hours</p>
							</div>
						</div>
						<div class="flex items-start gap-4">
							<div class="w-12 h-12 bg-[#EC8123]/10 rounded-lg flex items-center justify-center flex-shrink-0">
								<svg class="w-6 h-6 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
							</div>
							<div>
								<h3 class="font-semibold text-slate-900 mb-1">Location</h3>
								<p class="text-slate-600">New York, NY</p>
								<p class="text-sm text-slate-500 mt-1">Serving NYC and all major airports</p>
							</div>
						</div>
					</div>

					<div class="mt-10 p-6 bg-slate-50 rounded-xl">
						<h3 class="font-semibold text-slate-900 mb-3">Business Hours</h3>
						<div class="space-y-2 text-sm">
							<div class="flex justify-between">
								<span class="text-slate-600">Booking Support</span>
								<span class="font-semibold text-slate-900">24/7</span>
							</div>
							<div class="flex justify-between">
								<span class="text-slate-600">Office Hours</span>
								<span class="font-semibold text-slate-900">Mon-Fri 9AM-6PM</span>
							</div>
							<div class="flex justify-between">
								<span class="text-slate-600">Weekend Support</span>
								<span class="font-semibold text-slate-900">Sat-Sun 10AM-4PM</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function(){
  $('#contactForm').on('submit', function(e){
    e.preventDefault();
    const $btn = $(this).find('button[type="submit"]');
    $btn.prop('disabled', true).text('Sending...');
    $('#contactStatus').removeClass('text-green-600 text-red-600').text('');
    $.ajax({
      url: 'backend/contact_submit.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json'
    }).done(function(res){
      if(res.success){
        $('#contactStatus').addClass('text-green-600').text('✓ Thanks! We\'ll get back to you soon.');
        $('#contactForm')[0].reset();
      } else {
        $('#contactStatus').addClass('text-red-600').text('✗ ' + (res.error || 'Submission failed.'));
      }
    }).fail(function(){
      $('#contactStatus').addClass('text-red-600').text('✗ Network error. Please try again.');
    }).always(function(){
      $btn.prop('disabled', false).text('Send Message');
    });
  });
});
</script>

<?php include 'includes/footer.php'; ?>
