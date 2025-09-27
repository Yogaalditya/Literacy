@props(['partners'])

@php
// Collect all partners with logos for carousel
$allPartners = collect();

// Add partners with logos
foreach ($partners as $partner) {
    if ($partner->getFirstMedia('logo')) {
        $allPartners->push([
            'partner' => $partner
        ]);
    }
}
@endphp

@if ($allPartners->isNotEmpty())
<section id="partners" class="section-background py-20">
	<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-text);">Our Partners</h2>
			<p class="max-w-2xl mx-auto mt-4" style="color: var(--color-text-secondary);">Thank you to all our amazing partners who support our mission</p>
		</div>

		<!-- Partner Carousel -->
		<div class="partner-carousel-container">
			<div class="partner-carousel-track" id="partnerCarouselTrack">
				<!-- Duplicate last slide for smooth infinite loop (backward) -->
				@if ($allPartners->count() > 1)
					@php 
						$lastItem = $allPartners->last();
						$partner = $lastItem['partner'];
						$tag = $partner->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="partner-carousel-slide blur" data-slide="duplicate-last">
						<div class="text-center">
							<{{$tag}} 
								@if($partner->getMeta('url'))
								href="{{ $partner->getMeta('url') }}"
								target="_blank"
								@endif
								class="flex items-center justify-center transition duration-300 ease-in-out">
								<img
									style="
										image-rendering: auto;
										width: auto;
										height: auto;
										object-fit: contain;
										max-width: 300px;
										max-height: 200px;
									"
									src="{{ $partner->getFirstMediaUrl('logo') }}"
									alt="{{ $partner->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endif
				
				@foreach ($allPartners as $index => $item)
					@php 
						$partner = $item['partner'];
						$tag = $partner->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="partner-carousel-slide blur" data-slide="{{ $index }}">
						<div class="text-center">
							<{{$tag}} 
								@if($partner->getMeta('url'))
								href="{{ $partner->getMeta('url') }}"
								target="_blank"
								@endif
								class="flex items-center justify-center transition duration-300 ease-in-out">
								<img
									style="
										image-rendering: auto;
										width: auto;
										height: auto;
										object-fit: contain;
										max-width: 300px;
										max-height: 200px;
									"
									src="{{ $partner->getFirstMediaUrl('logo') }}"
									alt="{{ $partner->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endforeach
				
				<!-- Duplicate first slide for smooth infinite loop -->
				@if ($allPartners->count() > 1)
					@php 
						$firstItem = $allPartners->first();
						$partner = $firstItem['partner'];
						$tag = $partner->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="partner-carousel-slide blur" data-slide="duplicate">
						<div class="text-center">
							<{{$tag}} 
								@if($partner->getMeta('url'))
								href="{{ $partner->getMeta('url') }}"
								target="_blank"
								@endif
								class="flex items-center justify-center transition duration-300 ease-in-out">
								<img
									style="
										image-rendering: auto;
										width: auto;
										height: auto;
										object-fit: contain;
										max-width: 300px;
										max-height: 200px;
									"
									src="{{ $partner->getFirstMediaUrl('logo') }}"
									alt="{{ $partner->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endif
			</div>

			<!-- Navigation Arrows (only show if more than 1 partner) -->
			@if ($allPartners->count() > 1)
			<button class="partner-carousel-nav prev" id="partnerPrevBtn">
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
				</svg>
			</button>
			<button class="partner-carousel-nav next" id="partnerNextBtn">
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
			</button>
			@endif
		</div>

		<!-- Pagination (only show if more than 1 partner) -->
		@if ($allPartners->count() > 1)
		<div class="partner-carousel-pagination">
			<div class="partner-carousel-counter">
				<span id="currentPartnerSlide">1</span> / <span id="totalPartnerSlides">{{ $allPartners->count() }}</span>
			</div>
			<div class="partner-carousel-dots" id="partnerDots">
				@for ($i = 0; $i < $allPartners->count(); $i++)
					<div class="partner-carousel-dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></div>
				@endfor
			</div>
		</div>
		@endif
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const track = document.getElementById('partnerCarouselTrack');
			const slides = document.querySelectorAll('#partnerCarouselTrack .partner-carousel-slide');
			const prevBtn = document.getElementById('partnerPrevBtn');
			const nextBtn = document.getElementById('partnerNextBtn');
			const dots = document.querySelectorAll('#partnerDots .partner-carousel-dot');
			const currentSlideSpan = document.getElementById('currentPartnerSlide');
			const totalSlides = {{ $allPartners->count() }};
			const hasMultipleSlides = totalSlides > 1;
			
			
			if (!hasMultipleSlides) {
				
				slides.forEach(slide => {
					slide.classList.remove('blur');
					slide.classList.add('active');
				});
				return;
			}
			
			
			let currentIndex = hasMultipleSlides ? 1 : 0;
			let isTransitioning = false;

			
			if (hasMultipleSlides) {
				track.style.transform = `translateX(-${currentIndex * 100}%)`;
			}

			function updateCarousel(instant = false) {
				if (instant) {
					track.style.transition = 'none';
				} else {
					track.style.transition = 'transform 0.5s ease-in-out';
				}
				
				
				track.style.transform = `translateX(-${currentIndex * 100}%)`;
				
				
				slides.forEach((slide, index) => {
					slide.classList.remove('active', 'blur');
					if (index === currentIndex) {
						slide.classList.add('active');
					} else {
						slide.classList.add('blur');
					}
				});

				
				let displayIndex;
				if (hasMultipleSlides) {
					if (currentIndex === 0) {
						displayIndex = totalSlides - 1; 
					} else if (currentIndex > totalSlides) {
						displayIndex = 0; 
					} else {
						displayIndex = currentIndex - 1; 
					}
				} else {
					displayIndex = currentIndex;
				}

				dots.forEach((dot, index) => {
					dot.classList.toggle('active', index === displayIndex);
				});

				
				if (currentSlideSpan) {
					currentSlideSpan.textContent = (displayIndex) + 1;
				}
			}

			function nextSlide() {
				if (isTransitioning) return;
				isTransitioning = true;
				
				currentIndex++;
				updateCarousel();
				
				
				if (hasMultipleSlides && currentIndex > totalSlides) {
					setTimeout(() => {
						currentIndex = 1; 
						updateCarousel(true); 
						isTransitioning = false;
					}, 500); 
				} else {
					setTimeout(() => {
						isTransitioning = false;
					}, 500);
				}
			}

			function prevSlide() {
				if (isTransitioning) return;
				isTransitioning = true;
				
				currentIndex--;
				updateCarousel();
				
				
				if (hasMultipleSlides && currentIndex < 1) {
					setTimeout(() => {
						currentIndex = totalSlides; 
						updateCarousel(true); 
						isTransitioning = false;
					}, 500);
				} else {
					setTimeout(() => {
						isTransitioning = false;
					}, 500);
				}
			}

			function goToSlide(index) {
				if (isTransitioning) return;
				isTransitioning = true;
				
				
				currentIndex = hasMultipleSlides ? index + 1 : index;
				updateCarousel();
				setTimeout(() => {
					isTransitioning = false;
				}, 500);
			}

			
			updateCarousel(true);

			
			if (prevBtn) prevBtn.addEventListener('click', prevSlide);
			if (nextBtn) nextBtn.addEventListener('click', nextSlide);

			if (dots.length > 0) {
				dots.forEach((dot, index) => {
					dot.addEventListener('click', () => goToSlide(index));
				});
			}

			
			document.addEventListener('keydown', function(e) {
				if (e.key === 'ArrowLeft') {
					prevSlide();
				} else if (e.key === 'ArrowRight') {
					nextSlide();
				}
			});

			// Auto-play (optional)
			// if (hasMultipleSlides) {
			//     setInterval(nextSlide, 5000);
			// }
		});
	</script>
</section>
@endif