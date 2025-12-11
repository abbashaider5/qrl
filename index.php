<?php include 'includes/header.php'; ?>

	<main id="top">
		<section class="relative hero-bg text-white" id="booking">
			<div class="absolute inset-0 hero-bg-overlay"></div>
			<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12">
				<div class="space-y-6 lg:pr-8">
					<p class="text-sm uppercase tracking-[0.25em] text-[#EC8123]">New York chauffeur service</p>
					<h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold leading-tight">Executive black car service across New York and every airport</h1>
					<p class="text-lg text-slate-100/90 max-w-2xl">Discreet, licensed chauffeurs for JFK, LaGuardia, Newark, and city routes—priced transparently and managed by coordinators who track flights and adjust in real time.</p>
					<div class="grid sm:grid-cols-3 gap-4">
						<div class="flex items-center gap-2 text-sm text-slate-100">
							<svg class="w-4 h-4 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
							<span>Uniformed, vetted chauffeurs with local expertise</span>
						</div>
						<div class="flex items-center gap-2 text-sm text-slate-100">
							<svg class="w-4 h-4 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
							<span>All-in pricing shared upfront—no surprises at pickup</span>
						</div>
						<div class="flex items-center gap-2 text-sm text-slate-100">
							<svg class="w-4 h-4 text-[#EC8123]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
							<span>24/7 coordinators who monitor flights and adjust plans</span>
						</div>
					</div>
				</div>

				<div class="bg-white text-slate-900 rounded-2xl shadow-lg border border-slate-200 p-5 lg:p-6 max-w-xl ml-auto">
					<div class="flex items-center text-sm font-semibold mb-3 border-b border-slate-200">
						<button class="tab-btn px-3 py-2 border-b-2 border-[#EC8123] text-black" data-tab="airport">One way</button>
						<button class="tab-btn px-3 py-2 text-slate-600" data-tab="hourly">By the hour</button>
						<button class="tab-btn px-3 py-2 text-slate-600" data-tab="city">City-to-City</button>
					</div>
					<form id="bookingForm" class="space-y-3">
						<div class="bg-slate-50 border border-slate-200 p-3">
							<label class="text-sm font-semibold text-slate-700">From</label>
							<div class="mt-1 flex items-center gap-3">
								<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-5.2-6-10a6 6 0 1 1 12 0c0 4.8-6 10-6 10Z"/><circle cx="12" cy="11" r="2.5" /></svg>
								<input id="pickupInput" type="text" name="pickup" class="w-full bg-transparent focus:outline-none" placeholder="Address, airport, hotel, ..." required>
							</div>
							<p class="hidden text-red-500 text-xs mt-1" data-error="pickup">Pickup is required.</p>
						</div>
						<div class="bg-slate-50 border border-slate-200 p-3">
							<label class="text-sm font-semibold text-slate-700">To</label>
							<div class="mt-1 flex items-center gap-3">
								<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 12 8-7 8 7v7a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-4H10v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z" /></svg>
								<input id="dropoffInput" type="text" name="dropoff" class="w-full bg-transparent focus:outline-none" placeholder="Address, airport, hotel, ...">
							</div>
						</div>
						<div class="grid grid-cols-2 gap-3">
							<div class="bg-slate-50 border border-slate-200 p-3">
								<label class="text-sm font-semibold text-slate-700">Date</label>
								<div class="mt-1 flex items-center gap-3">
									<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h10m-9 4h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" /></svg>
									<input type="date" name="date" class="w-full bg-transparent focus:outline-none" required>
								</div>
								<p class="hidden text-red-500 text-xs mt-1" data-error="date">Date is required.</p>
							</div>
							<div class="bg-slate-50 border border-slate-200 p-3">
								<label class="text-sm font-semibold text-slate-700">Pickup time</label>
								<div class="mt-1 flex items-center gap-3">
									<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="7" /><path stroke-linecap="round" stroke-linejoin="round" d="m12 9 0 3 2 1" /></svg>
									<input type="time" name="time" class="w-full bg-transparent focus:outline-none" required>
								</div>
								<p class="hidden text-red-500 text-xs mt-1" data-error="time">Time is required.</p>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-3">
							<div class="bg-slate-50 border border-slate-200 p-3">
								<label class="text-sm font-semibold text-slate-700">Passengers</label>
								<select name="passengers" class="mt-1 w-full bg-transparent focus:outline-none">
									<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
								</select>
							</div>
							<div class="bg-slate-50 border border-slate-200 p-3">
								<label class="text-sm font-semibold text-slate-700">Service class</label>
								<select name="service" class="mt-1 w-full bg-transparent focus:outline-none">
									<option>Business</option><option>Business Van/SUV</option><option>First Class</option>
								</select>
							</div>
						</div>
						<p class="text-xs text-slate-600">Chauffeur will wait 15 minutes free of charge.</p>
						<button type="submit" class="w-full bg-[#EC8123] text-white font-semibold py-3 shadow-md">Search</button>
					</form>
				</div>
			</div>
		</section>

		<section id="services" class="bg-[#F6F1EB] py-16">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center space-y-3">
					<p class="text-sm uppercase tracking-[0.2em] text-[#EC8123]">Our services</p>
					<h2 class="text-3xl sm:text-4xl font-semibold text-slate-900">Service options for any itinerary</h2>
				</div>
				<div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
					<div class="space-y-4">
						<img src="https://images.pexels.com/photos/4141958/pexels-photo-4141958.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Family preparing for a city to city ride" class="w-full h-48 rounded-2xl object-cover">
						<div class="space-y-2">
							<h3 class="text-2xl font-semibold text-slate-900">City-to-city rides</h3>
							<p class="text-slate-700 text-base leading-relaxed">Comfortable long-distance travel with professional chauffeurs, precise routing, and reliable arrival times.</p>
							<a href="#booking" class="inline-flex items-center gap-1 text-sm font-semibold text-[#EC8123]">Learn more</a>
						</div>
					</div>

					<div class="space-y-4">
						<img src="https://media.istockphoto.com/id/1152954653/photo/cadillac-escalade-a-luxury-limon-suv.jpg?s=612x612&w=0&k=20&c=jMmzF7PtC5zhvYQl071CSBUpy6FfV7zvbLjAwpKLFEs=" alt="Chauffeur hailing vehicle" class="w-full h-48 rounded-2xl object-cover">
						<div class="space-y-2">
							<div class="flex items-center gap-3">
								<h3 class="text-2xl font-semibold text-slate-900">Chauffeur hailing</h3>
								<span class="text-[11px] font-semibold uppercase tracking-wide text-[#EC8123] bg-[#FFF8F2] px-2 py-1 rounded-full">New</span>
							</div>
							<p class="text-slate-700 text-base leading-relaxed">Traditional chauffeur quality delivered quickly, so you can roll within minutes when plans change.</p>
							<a href="#booking" class="inline-flex items-center gap-1 text-sm font-semibold text-[#EC8123]">Learn more</a>
						</div>
					</div>

					<div class="space-y-4">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-9MNGZ47edaR7-UmEkITauO3C81gU5Ezpgw&s" alt="Chauffeur for airport transfers" class="w-full h-48 rounded-2xl object-cover">
						<div class="space-y-2">
							<h3 class="text-2xl font-semibold text-slate-900">Airport transfers</h3>
							<p class="text-slate-700 text-base leading-relaxed">Built-in wait time, proactive flight tracking, and discreet meet-and-greet options make every airport transfer smooth.</p>
							<a href="#booking" class="inline-flex items-center gap-1 text-sm font-semibold text-[#EC8123]">Learn more</a>
						</div>
					</div>

					<div class="space-y-4">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMhEyloQ_pRBkbhgNJDtqi-XFt5_P2YKUuYA&s" alt="Business travelers using chauffeur service" class="w-full h-48 rounded-2xl object-cover">
						<div class="space-y-2">
							<h3 class="text-2xl font-semibold text-slate-900">Hourly and full day hire</h3>
							<p class="text-slate-700 text-base leading-relaxed">Hourly or full-day coverage with the same chauffeur, consistent vehicle, and attentive support.</p>
							<a href="#booking" class="inline-flex items-center gap-1 text-sm font-semibold text-[#EC8123]">Learn more</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="premium-mobility" class="py-16 bg-[#0C0A2E] text-white">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
				<div class="text-center space-y-3">
					<p class="text-[11px] uppercase tracking-[0.3em] text-[#EC8123]">For teams and executives</p>
					<h2 class="text-3xl sm:text-4xl font-semibold">Corporate mobility you can hand off with confidence</h2>
					<p class="max-w-3xl mx-auto text-sm sm:text-base text-slate-200 leading-relaxed">Concierge-level coordination with vetted chauffeurs and consistent vehicles for board meetings, investor visits, and client hosting across the city and all airports.</p>
				</div>

				<div class="grid gap-6 lg:grid-cols-3">
					<div class="bg-white text-slate-900 shadow-sm border border-slate-200 rounded-xl overflow-hidden">
						<img src="https://t3.ftcdn.net/jpg/01/28/64/34/360_F_128643483_jFFpJrwkk4O7ku94e1ulWQwfYz2fNWXw.jpg" alt="Corporate mobility" class="w-full h-48 object-cover">
						<div class="p-6 space-y-3">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Corporate mobility</p>
							<h3 class="text-xl font-semibold">Executive travel desk</h3>
							<p class="text-sm text-slate-700 leading-relaxed">Centralized ride management with real-time updates for leadership, assistants, and traveling teams.</p>
							<a href="#booking" class="inline-flex items-center justify-center px-5 py-3 bg-[#EC8123] text-white text-xs font-semibold uppercase tracking-wide rounded-full">Plan a ride</a>
						</div>
					</div>

					<div class="bg-white text-slate-900 shadow-sm border border-slate-200 rounded-xl overflow-hidden">
						<img src="https://media.istockphoto.com/id/91502745/photo/multiple-limos.jpg?s=612x612&w=0&k=20&c=Sl1mYwWmboHcSXIBvXtsiRKqKOuTPGyENHeNqrbeKmQ=" alt="Events mobility" class="w-full h-48 object-cover">
						<div class="p-6 space-y-3">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Events mobility</p>
							<h3 class="text-xl font-semibold">Roadshows & events</h3>
							<p class="text-sm text-slate-700 leading-relaxed">Route planning, staging areas, and guest coordination handled by a dedicated event lead.</p>
							<a href="#booking" class="inline-flex items-center justify-center px-5 py-3 bg-[#EC8123] text-white text-xs font-semibold uppercase tracking-wide rounded-full">Plan a ride</a>
						</div>
					</div>

					<div class="bg-white text-slate-900 shadow-sm border border-slate-200 rounded-xl overflow-hidden">
						<img src="https://img.freepik.com/premium-photo/female-chauffeur-helps-businessman-get-out-car_506452-23625.jpg" alt="Executive car" class="w-full h-48 object-cover">
						<div class="p-6 space-y-3">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Executive car</p>
							<h3 class="text-xl font-semibold">Day-to-day support</h3>
							<p class="text-sm text-slate-700 leading-relaxed">Consistent chauffeurs, confidentiality, and vehicle standards aligned to executive preferences.</p>
							<a href="#booking" class="inline-flex items-center justify-center px-5 py-3 bg-[#EC8123] text-white text-xs font-semibold uppercase tracking-wide rounded-full">Plan a ride</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="mobility-stats" class="py-14 bg-[#F9F5F0] text-slate-900">
			<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
				<div class="text-center space-y-2">
					<p class="text-[11px] uppercase tracking-[0.3em] text-[#EC8123]">Get access to the best mobility service</p>
					<h2 class="text-3xl font-semibold">Experience and reliability</h2>
					<p class="text-sm sm:text-base text-slate-600 max-w-3xl mx-auto leading-relaxed">Digital-first coordination with human service: transparent pricing, vetted chauffeurs, and reliable vehicles for corporate travel, everyday mobility, and events.</p>
				</div>
				<div class="grid gap-6 sm:grid-cols-3">
					<div class="bg-white text-slate-900 p-6 sm:p-8 shadow-sm border border-slate-200 rounded-xl">
						<p class="text-xs uppercase tracking-[0.25em] text-[#EC8123]">Drivers</p>
						<p class="mt-2 text-4xl font-semibold">10,000+</p>
						<p class="text-sm text-slate-600 mt-2">Screened, licensed, and trained for premium service delivery.</p>
					</div>
					<div class="bg-white text-slate-900 p-6 sm:p-8 shadow-sm border border-slate-200 rounded-xl">
						<p class="text-xs uppercase tracking-[0.25em] text-[#EC8123]">Top cities</p>
						<p class="mt-2 text-4xl font-semibold">500+</p>
						<p class="text-sm text-slate-600 mt-2">Global coverage with centralized coordination.</p>
					</div>
					<div class="bg-white text-slate-900 p-6 sm:p-8 shadow-sm border border-slate-200 rounded-xl">
						<p class="text-xs uppercase tracking-[0.25em] text-[#EC8123]">Clients</p>
						<p class="mt-2 text-4xl font-semibold">2,000+</p>
						<p class="text-sm text-slate-600 mt-2">Enterprises, agencies, and VIP travelers worldwide.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="py-14 sm:py-16 bg-[#FDFBF8]" id="assurance">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid gap-6 lg:grid-cols-3">
					<div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm flex flex-col gap-4">
						<div class="w-12 h-12 rounded-xl bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5 4.5 7.5v6c0 3.5 2.7 5.9 7.5 6 4.8-.1 7.5-2.5 7.5-6v-6L12 4.5Zm0 0v13" />
								<path stroke-linecap="round" stroke-linejoin="round" d="m8.8 12.1 1.8 1.8 3.6-3.6" />
							</svg>
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">Safety first</h3>
							<p class="text-slate-700 leading-relaxed">Travel confidently knowing your safety is our top priority. Every ride is monitored and every chauffeur is vetted.</p>
						</div>
					</div>
					<div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm flex flex-col gap-4">
						<div class="w-12 h-12 rounded-xl bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1.5A1.5 1.5 0 0 0 5.5 19h13a1.5 1.5 0 0 0 1.5-1.5V16" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M4 9.5h16V16H4zM7.5 9.5l1.5-4h6l1.5 4" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 12.25h4.5m-2.25-2v4" />
							</svg>
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">Private travel solutions</h3>
							<p class="text-slate-700 leading-relaxed">Your one-stop travel desk for long-distance rides, airport transfers, by-the-hour support, and multileg itineraries.</p>
						</div>
					</div>
					<div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm flex flex-col gap-4">
						<div class="w-12 h-12 rounded-xl bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25c0 3.75 3.75 6.75 4.5 6.75s4.5-3 4.5-6.75a4.5 4.5 0 1 0-9 0Z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="m9.5 12 1.5 1.5 3.5-3.5" />
							</svg>
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">Sustainable travel</h3>
							<p class="text-slate-700 leading-relaxed">All rides include carbon offsetting as part of our global sustainability program for corporate travel.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Brands and global coverage sections removed per request -->

		<section id="airports" class="py-16 bg-[#F1EEE9]">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 flex-end">
				<div class="text-center space-y-3 max-w-3xl mx-auto">
					<p class="text-sm uppercase tracking-[0.2em] text-[#EC8123]">Services</p>
					<h2 class="text-3xl sm:text-4xl font-semibold text-slate-900">Rides matched to any trip plan</h2>
					<p class="text-slate-600 text-base leading-relaxed">Pair a vetted chauffeur with the exact service format you need—from private aviation arrivals to multi-stop roadshows.</p>
				</div>
				<div class="grid gap-6 lg:grid-cols-3">
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-44 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1200&q=80&sat=-10" alt="Airport transfer sedan" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">Airport transfers</h3>
							<p class="text-sm text-slate-600 leading-relaxed">Dedicated JFK, LGA, and Newark coordinators handle flight monitoring, buffer time, and meet-and-greet signage.</p>
						</div>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Flight tracking with alert updates</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Extra wait time built in</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Meet-and-greet or curbside options</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Plan a ride</a>
					</article>
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-44 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1200&q=80&sat=-15" alt="City to city ride" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">City-to-city rides</h3>
							<p class="text-sm text-slate-600 leading-relaxed">Set itineraries for the Hamptons, Connecticut, New Jersey, Philadelphia, and beyond with transparent, all-in pricing.</p>
						</div>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Door-to-door scheduling</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Always-on chauffeur standby</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Flexible routing for stops</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Plan a ride</a>
					</article>
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-44 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80" alt="Corporate transport" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-2">
							<h3 class="text-xl font-semibold text-slate-900">Corporate &amp; events</h3>
							<p class="text-sm text-slate-600 leading-relaxed">Roadshows, premieres, and investor meetings backed by staging plans, coordinator radio support, and manifest tracking.</p>
						</div>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Manifest-driven dispatching</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>On-site coordinator available</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Venue and security liaison</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Plan a ride</a>
					</article>
				</div>
				
			</div>
		</section>

		<section id="fleet" class="py-16 bg-[#FDF8F2] text-slate-900">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
				<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
					<div class="space-y-3 max-w-2xl">
						<p class="text-sm uppercase tracking-[0.2em] text-[#EC8123]">Fleet</p>
						<h2 class="text-3xl sm:text-4xl font-semibold">Our Premium Fleet</h2>
						<p class="text-slate-600 text-base leading-relaxed">Late-model vehicles maintained to executive standards, prepared for every itinerary, and always paired with vetted chauffeurs.</p>
					</div>
					<div class="flex flex-wrap gap-3">
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-[#EC8123] px-5 py-3 rounded-full">View availability</a>
						
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-48 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1400&q=80&sat=-25" alt="Luxury sedan" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-1">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Flagship sedans</p>
							<h3 class="text-xl font-semibold">Mercedes S-Class &amp; BMW 7</h3>
						</div>
						<p class="text-sm text-slate-600 leading-relaxed">Executive interiors, Wi-Fi on request, and discreet chauffeurs for board meetings and airport transfers.</p>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Seats 3 passengers comfortably</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Privacy glass and bottled water</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Luggage: 2 suitcases + 2 carry-ons</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Reserve now</a>
					</article>
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-48 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&w=1200&q=80&sat=-20" alt="Luxury SUV" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-1">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Business SUVs</p>
							<h3 class="text-xl font-semibold">Escalade &amp; Navigator</h3>
						</div>
						<p class="text-sm text-slate-600 leading-relaxed">Spacious, premium SUVs for up to six travelers with climate-controlled cabins and luggage capacity for extended stays.</p>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Seats 6 with captain-chair comfort</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Power outlets and bottled water</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Ideal for families and VIP crews</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Reserve now</a>
					</article>
					<article class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4 overflow-hidden">
						<div class="-mx-6 -mt-6 h-48 overflow-hidden rounded-t-2xl">
							<img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80" alt="Luxury sprinter" class="w-full h-full object-cover object-center">
						</div>
						<div class="space-y-1">
							<p class="text-[11px] uppercase tracking-[0.25em] text-[#EC8123]">Sprinters &amp; vans</p>
							<h3 class="text-xl font-semibold">Premium 10–14 passenger</h3>
						</div>
						<p class="text-sm text-slate-600 leading-relaxed">Conference seating or forward-facing layouts with chargers, tables, and dedicated staging support.</p>
						<ul class="space-y-2 text-sm text-slate-600">
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Ideal for roadshows and teams</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Overhead and rear luggage space</li>
							<li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>Custom branding available</li>
						</ul>
						<a href="#booking" class="inline-flex items-center gap-2 text-sm font-semibold text-[#EC8123]">Reserve now</a>
					</article>
				</div>
			</div>
		</section>

		<section id="about" class="py-14 sm:py-16 bg-[#F6F1EB]">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-10 lg:items-center">
				<div class="space-y-4">
					<p class="text-sm uppercase tracking-[0.2em] text-[#EC8123]">About Us</p>
					<h2 class="text-3xl font-semibold">Luxury Ride NYC since 2017</h2>
					<p class="text-slate-600">Quick Luxury Ride has provided executive transportation since 2017. We select seasoned chauffeurs who bring punctuality, discretion, and road safety to every ride.</p>
					<p class="text-slate-600">Our goal is simple: deliver a consistently polished New York luxury ride experience on every trip.</p>
				</div>
				<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
					<img src="https://t3.ftcdn.net/jpg/06/32/23/68/360_F_632236811_9EAV0c08lQ8SUcyQwmWEq7MRBES5YvLo.jpg" alt="NYC skyline at night" class="w-full h-72 object-cover">
					<div class="p-6 text-slate-900 space-y-2">
						<h3 class="font-semibold text-lg">Coverage</h3>
						<p class="text-sm text-slate-600">Serving Manhattan, Brooklyn, Queens, Bronx, Staten Island, JFK, LGA, EWR, and the Tri-State area.</p>
					</div>
				</div>
			</div>
		</section>

		<section id="business" class="bg-white py-14 sm:py-16">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center space-y-3 max-w-2xl mx-auto">
					<p class="text-sm uppercase tracking-[0.2em] text-[#EC8123]">How It Works</p>
					<h2 class="text-3xl font-semibold">Three steps to a seamless ride</h2>
				</div>
				<div class="mt-12 grid gap-6 lg:grid-cols-3">
					<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
						<div class="w-10 h-10 rounded-full bg-[#EC8123] text-white flex items-center justify-center font-bold">1</div>
						<h3 class="font-semibold text-lg mt-4">Plan your ride</h3>
						<p class="text-slate-600 text-sm mt-2">Set pickup time, date, and destinations. Choose your vehicle class.</p>
					</div>
					<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
						<div class="w-10 h-10 rounded-full bg-[#EC8123] text-white flex items-center justify-center font-bold">2</div>
						<h3 class="font-semibold text-lg mt-4">Meet your chauffeur</h3>
						<p class="text-slate-600 text-sm mt-2">Receive driver details in advance. Enjoy door-to-door service.</p>
					</div>
					<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
						<div class="w-10 h-10 rounded-full bg-[#EC8123] text-white flex items-center justify-center font-bold">3</div>
						<h3 class="font-semibold text-lg mt-4">Arrive relaxed</h3>
						<p class="text-slate-600 text-sm mt-2">Track timing, stay informed, and arrive on schedule without surprises.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="py-16 bg-[#F7F0E8] border-b border-white/15" id="business-cta">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-[1.1fr,0.9fr] gap-12 lg:items-center border-b border-white/15">
				<div class="space-y-6">
					<p class="text-sm font-semibold uppercase tracking-[0.25em] text-[#EC8123]">Get started with QLR</p>
					<h2 class="text-4xl sm:text-5xl font-semibold text-slate-900 leading-tight">Ready to upgrade your business travel?</h2>
					<p class="text-lg text-slate-700 max-w-2xl">Simplify planning with our corporate ride platform—vetted chauffeurs, live visibility, and pricing that scales with your teams.</p>
					<a href="#booking" class="inline-flex items-center gap-3 bg-[#EC8123] text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-full font-semibold text-base ">Try QLR for Corporate Travel</a>
				</div>
				<div class="space-y-4">
					<div class="flex items-start gap-3">
						<div class="mt-1 w-9 h-9 rounded-full bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
							</svg>
						</div>
						<p class="text-base text-slate-800">Put comfort, safety, and punctuality first for every professional trip.</p>
					</div>
					<div class="flex items-start gap-3">
						<div class="mt-1 w-9 h-9 rounded-full bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
							</svg>
						</div>
						<p class="text-base text-slate-800">Manage, organize, and track rides for teams and guests in one place.</p>
					</div>
					<div class="flex items-start gap-3">
						<div class="mt-1 w-9 h-9 rounded-full bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
							</svg>
						</div>
						<p class="text-base text-slate-800">See transparent, competitive black car pricing nationwide.</p>
					</div>
					<div class="flex items-start gap-3">
						<div class="mt-1 w-9 h-9 rounded-full bg-[#FFF8F2] text-[#EC8123] flex items-center justify-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
							</svg>
						</div>
						<p class="text-base text-slate-800">Offer sustainable corporate transport with built-in carbon offsets.</p>
					</div>
				</div>
			</div>
		</section>

		<section id="why-choose" class="py-14 sm:py-16 bg-[#F6F1EB] border-t border-4 border-dark">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
				<div class="text-center space-y-2">
					<p class="text-xs uppercase tracking-[0.25em] text-[#EC8123]">Making a difference</p>
					<h2 class="text-3xl sm:text-4xl font-semibold text-slate-900">Why passengers choose Quick Luxury Ride</h2>
				</div>

				<div class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
					<div class="bg-white border border-slate-200 overflow-hidden shadow-sm rounded-2xl flex flex-col lg:flex-row">
						<img src="https://images.unsplash.com/photo-1521790945508-bf2a36314e85?auto=format&fit=crop&w=1600&q=80" alt="Passenger testimonial" class="w-full lg:w-1/2 h-64 lg:h-auto object-cover">
						<div class="p-6 sm:p-8 space-y-3 flex-1">
							<p class="text-[10px] uppercase tracking-[0.25em] text-[#EC8123]">Customer testimonial</p>
							<p class="text-xl sm:text-2xl font-semibold leading-snug text-slate-900">“The QLR experience is a step up from the rest. These drivers go above and beyond to impress, and that makes all the difference.”</p>
							<p class="text-xs text-slate-600">Shawn McAteer, Hilton VP</p>
						</div>
					</div>

					<div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8 flex flex-col gap-3">
						<div class="flex items-center gap-2">
							<span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>
							<p class="text-[10px] uppercase tracking-[0.25em] text-[#EC8123]">The numbers</p>
						</div>
						<div class="flex flex-col gap-6 justify-end flex-1">
                          <p class="text-5xl font-extrabold text-slate-900 leading-tight">400+</p>
						<p class="text-sm leading-relaxed text-slate-700">Companies rely on Quick Luxury Ride for executive travel and events.</p>
						</div>
						
					</div>
				</div>

				<div class="grid gap-6 lg:grid-cols-[0.9fr,1.1fr]">
					<div class="bg-white border border-slate-200 p-6 sm:p-7 shadow-sm rounded-2xl flex flex-col gap-4">
						<div>
							<p class="text-[10px] uppercase tracking-[0.25em] text-[#EC8123]">Passenger safety</p>
							<p class="text-base font-semibold mt-2 text-slate-900">Safety PIN verification keeps every ride secure.</p>
						</div>
						<img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=900&q=80" alt="Passenger entering vehicle" class="w-full h-48 object-cover rounded-xl">
					</div>

					<div class="bg-white border border-slate-200 p-6 sm:p-8 text-slate-900 shadow-sm rounded-2xl flex flex-col gap-4">
						<div class="flex items-center justify-between">
							<p class="text-[10px] uppercase tracking-[0.25em] text-[#EC8123]">Ride review</p>
							<div class="flex items-center gap-2 text-xs text-slate-500">
								<span class="h-2 w-2 rounded-full bg-[#EC8123]"></span>
								<span>Verified passenger</span>
							</div>
						</div>
						<p class="text-xl font-semibold leading-relaxed">“This was my first experience riding with Quick Luxury Ride. They were professional, on time, and friendly drivers. This will be my go-to for all my many flights across the country.”</p>
						<p class="text-xs text-slate-600">Anonymous Passenger · May 2024</p>
					</div>
				</div>
			</div>
		</section>

		<section class="bg-[#0C0A2E] text-white py-14 border-b border-white/15"  id="cta">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
				<div>
					<h2 class="text-2xl sm:text-3xl font-semibold">Ready for your next ride in New York?</h2>
					<p class="text-slate-200 mt-2">Book a professional chauffeur in just a few clicks.</p>
				</div>
				<a href="#booking" class="inline-flex items-center gap-2 bg-[#EC8123] text-white px-6 py-3 rounded-full font-semibold ">Book Your Ride Now</a>
			</div>
		</section>
	</main>

	<div id="toast" class="fixed bottom-6 right-6 bg-white text-slate-900 shadow-2xl border border-slate-200 px-5 py-4 rounded-xl hidden">
		<p class="font-semibold">Thank you!</p>
		<p class="text-sm text-slate-600">We will share your quote shortly.</p>
	</div>

	<script>
		const mobileToggle = document.getElementById('mobileToggle');
		const mobileMenu = document.getElementById('mobileMenu');
		mobileToggle.addEventListener('click', () => {
			mobileMenu.classList.toggle('hidden');
		});

		// Dropdowns: click to toggle, close on outside click
		const dropdowns = document.querySelectorAll('[data-dropdown]');
		function closeAllDropdowns() {
			dropdowns.forEach(wrapper => {
				const menu = wrapper.querySelector('[data-dropdown-menu]');
				menu?.classList.add('hidden');
			});
		}

		dropdowns.forEach(wrapper => {
			const toggle = wrapper.querySelector('[data-dropdown-toggle]');
			const menu = wrapper.querySelector('[data-dropdown-menu]');
			if (!toggle || !menu) return;

			toggle.addEventListener('click', (e) => {
				e.preventDefault();
				const isOpen = !menu.classList.contains('hidden');
				closeAllDropdowns();
				if (!isOpen) menu.classList.remove('hidden');
			});

			menu.addEventListener('mouseenter', () => menu.classList.remove('hidden'));
			menu.addEventListener('mouseleave', () => menu.classList.add('hidden'));
		});

		document.addEventListener('click', (e) => {
			if (![...dropdowns].some(wrapper => wrapper.contains(e.target))) {
				closeAllDropdowns();
			}
		});

		const tabs = document.querySelectorAll('.tab-btn');
		tabs.forEach(tab => {
			tab.addEventListener('click', () => {
					tabs.forEach(btn => btn.classList.remove('border-b-2', 'border-[#EC8123]', 'text-black'));
				tabs.forEach(btn => btn.classList.add('text-slate-600'));
					tab.classList.add('border-b-2', 'border-[#EC8123]', 'text-black');
				tab.classList.remove('text-slate-600');
			});
		});

		// Book dropdown hover with grace period (desktop only)
		const bookNav = document.getElementById('bookNav');
		const bookMenu = document.getElementById('bookMenu');
		const bookToggle = document.getElementById('bookToggle');
		let bookHideTimeout;

		function showBookMenu() {
			clearTimeout(bookHideTimeout);
			bookMenu.classList.remove('hidden');
		}

		function hideBookMenuDelayed() {
			bookHideTimeout = setTimeout(() => {
				bookMenu.classList.add('hidden');
			}, 200);
		}

		[bookNav, bookMenu, bookToggle].forEach(el => {
			if (!el) return;
			el.addEventListener('mouseenter', showBookMenu);
			el.addEventListener('mouseleave', hideBookMenuDelayed);
		});

		const form = document.getElementById('bookingForm');
		const toast = document.getElementById('toast');
		form.addEventListener('submit', (e) => {
			e.preventDefault();
			const data = new FormData(form);
			const pickup = data.get('pickup');
			const date = data.get('date');
			const time = data.get('time');

			const errors = {
				pickup: !pickup,
				date: !date,
				time: !time,
			};

			['pickup','date','time'].forEach(field => {
				const el = document.querySelector(`[data-error="${field}"]`);
				if (errors[field]) {
					el.classList.remove('hidden');
				} else {
					el.classList.add('hidden');
				}
			});

			if (errors.pickup || errors.date || errors.time) return;

			toast.classList.remove('hidden');
			toast.classList.add('opacity-100');
			setTimeout(() => {
				toast.classList.add('hidden');
			}, 2600);
			form.reset();
		});

		const testimonials = [
			{ quote: 'Immaculate vehicles and precise airport timing. My clients love them.', name: 'Dana K.', type: 'Airport Transfer – JFK' },
			{ quote: 'Driver arrived early, tracked my delayed flight, and still greeted me with a smile.', name: 'Michael R.', type: 'Business Travel – LGA' },
			{ quote: 'Seamless SUV service for our family from Newark to Manhattan.', name: 'Priya S.', type: 'Airport Transfer – EWR' },
			{ quote: 'Professional, discreet, and reliable for every board meeting.', name: 'Alex T.', type: 'Corporate Roadshow' }
		];

		function initPlaces() {
			if (!window.google || !google.maps || !google.maps.places) return;
			const fields = ['formatted_address', 'name', 'geometry'];
			const options = { fields, types: ['geocode'] };

			['pickupInput', 'dropoffInput'].forEach(id => {
				const input = document.getElementById(id);
				if (!input) return;
				const autocomplete = new google.maps.places.Autocomplete(input, options);
				autocomplete.addListener('place_changed', () => {
					const place = autocomplete.getPlace();
					const display = place?.formatted_address || place?.name;
					if (display) input.value = display;
				});
			});
		}

		window.initPlaces = initPlaces;

		let currentTestimonial = 0;
		const quoteEl = document.getElementById('testimonialQuote');
		const nameEl = document.getElementById('testimonialName');
		const typeEl = document.getElementById('testimonialType');
		const initialsEl = document.getElementById('testimonialInitials');
		const dotsEl = document.getElementById('testimonialDots');

		function initials(name) {
			return name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();
		}

		function renderDots() {
			dotsEl.innerHTML = '';
			testimonials.forEach((_, idx) => {
				const dot = document.createElement('button');
				dot.className = `w-2.5 h-2.5 rounded-full ${idx === currentTestimonial ? 'bg-[#EC8123]' : 'bg-slate-300'}`;
				dot.addEventListener('click', () => { currentTestimonial = idx; renderTestimonial(); });
				dotsEl.appendChild(dot);
			});
		}

		function renderTestimonial() {
			const t = testimonials[currentTestimonial];
			quoteEl.textContent = `“${t.quote}”`;
			nameEl.textContent = t.name;
			typeEl.textContent = t.type;
			initialsEl.textContent = initials(t.name);
			renderDots();
		}

		document.getElementById('prevTestimonial').addEventListener('click', () => {
			currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
			renderTestimonial();
		});
		document.getElementById('nextTestimonial').addEventListener('click', () => {
			currentTestimonial = (currentTestimonial + 1) % testimonials.length;
			renderTestimonial();
		});

		renderTestimonial();
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places&callback=initPlaces" async defer></script>

<?php include 'includes/footer.php'; ?>
