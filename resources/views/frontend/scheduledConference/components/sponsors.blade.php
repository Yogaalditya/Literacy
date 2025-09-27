@props(['sponsorLevels', 'sponsorsWithoutLevel'])

@php
// Collect all sponsors with logos for carousel
$allSponsors = collect();

// Add sponsors without level
if ($sponsorsWithoutLevel->isNotEmpty()) {
    foreach ($sponsorsWithoutLevel as $sponsor) {
        if ($sponsor->getFirstMedia('logo')) {
            $allSponsors->push([
                'sponsor' => $sponsor,
                'level' => null
            ]);
        }
    }
}

// Add sponsors with levels
foreach ($sponsorLevels as $sponsorLevel) {
    if ($sponsorLevel->stakeholders->isNotEmpty()) {
        foreach ($sponsorLevel->stakeholders as $sponsor) {
            if ($sponsor->getFirstMedia('logo')) {
                $allSponsors->push([
                    'sponsor' => $sponsor,
                    'level' => $sponsorLevel->name
                ]);
            }
        }
    }
}
@endphp

@if ($allSponsors->isNotEmpty())
<section id="sponsors" class="section-background py-20">
	<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<h2 class="text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-text);">Our Sponsors</h2>
			<p class="max-w-2xl mx-auto mt-4" style="color: var(--color-text-secondary);">Thank you to all our amazing sponsors who make our work possible</p>
		</div>

		<!-- Sponsor Carousel -->
		<div class="sponsor-carousel-container">
			<div class="sponsor-carousel-track" id="sponsorCarouselTrack">
				<!-- Duplicate last slide for smooth infinite loop (backward) -->
				@if ($allSponsors->count() > 1)
					@php 
						$lastItem = $allSponsors->last();
						$sponsor = $lastItem['sponsor'];
						$level = $lastItem['level'];
						$tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="sponsor-carousel-slide blur" data-slide="duplicate-last">
						<div class="text-center">
							@if($level)
								<h3 class="text-xl font-medium mb-6" style="color: var(--color-text);">{{ $level }}</h3>
							@endif
							<{{$tag}} 
								@if($sponsor->getMeta('url'))
								href="{{ $sponsor->getMeta('url') }}"
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
									src="{{ $sponsor->getFirstMediaUrl('logo') }}"
									alt="{{ $sponsor->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endif
				
				@foreach ($allSponsors as $index => $item)
					@php 
						$sponsor = $item['sponsor'];
						$level = $item['level'];
						$tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="sponsor-carousel-slide blur" data-slide="{{ $index }}">
						<div class="text-center">
							@if($level)
								<h3 class="text-xl font-medium mb-6" style="color: var(--color-text);">{{ $level }}</h3>
							@endif
							<{{$tag}} 
								@if($sponsor->getMeta('url'))
								href="{{ $sponsor->getMeta('url') }}"
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
									src="{{ $sponsor->getFirstMediaUrl('logo') }}"
									alt="{{ $sponsor->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endforeach
				
				<!-- Duplicate first slide for smooth infinite loop -->
				@if ($allSponsors->count() > 1)
					@php 
						$firstItem = $allSponsors->first();
						$sponsor = $firstItem['sponsor'];
						$level = $firstItem['level'];
						$tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
					@endphp
					<div class="sponsor-carousel-slide blur" data-slide="duplicate">
						<div class="text-center">
							@if($level)
								<h3 class="text-xl font-medium mb-6" style="color: var(--color-text);">{{ $level }}</h3>
							@endif
							<{{$tag}} 
								@if($sponsor->getMeta('url'))
								href="{{ $sponsor->getMeta('url') }}"
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
									src="{{ $sponsor->getFirstMediaUrl('logo') }}"
									alt="{{ $sponsor->name }}"
									loading="lazy"
								/>
							</{{$tag}}>
						</div>
					</div>
				@endif
			</div>

			<!-- Navigation Arrows (only show if more than 1 sponsor) -->
			@if ($allSponsors->count() > 1)
			<button class="sponsor-carousel-nav prev" id="sponsorPrevBtn">
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
				</svg>
			</button>
			<button class="sponsor-carousel-nav next" id="sponsorNextBtn">
				<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
			</button>
			@endif
		</div>

		<!-- Pagination (only show if more than 1 sponsor) -->
		@if ($allSponsors->count() > 1)
		<div class="sponsor-carousel-pagination">
			<div class="sponsor-carousel-counter">
				<span id="currentSlide">1</span> / <span id="totalSlides">{{ $allSponsors->count() }}</span>
			</div>
			<div class="sponsor-carousel-dots" id="sponsorDots">
				@for ($i = 0; $i < $allSponsors->count(); $i++)
					<div class="sponsor-carousel-dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></div>
				@endfor
			</div>
		</div>
		@endif
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const track = document.getElementById('sponsorCarouselTrack');
			const slides = document.querySelectorAll('.sponsor-carousel-slide');
			const prevBtn = document.getElementById('sponsorPrevBtn');
			const nextBtn = document.getElementById('sponsorNextBtn');
			const dots = document.querySelectorAll('.sponsor-carousel-dot');
			const currentSlideSpan = document.getElementById('currentSlide');
			const totalSlides = {{ $allSponsors->count() }};
			const hasMultipleSlides = totalSlides > 1;
			
			// Early return if only one slide - no carousel functionality needed
			if (!hasMultipleSlides) {
				// Just ensure the single slide is visible and not blurred
				slides.forEach(slide => {
					slide.classList.remove('blur');
					slide.classList.add('active');
				});
				return;
			}
			
			// Start at index 1 if we have duplicate slides (to account for duplicate-last at index 0)
			let currentIndex = hasMultipleSlides ? 1 : 0;
			let isTransitioning = false;

			// Initialize carousel position
			if (hasMultipleSlides) {
				track.style.transform = `translateX(-${currentIndex * 100}%)`;
			}

			function updateCarousel(instant = false) {
				if (instant) {
					track.style.transition = 'none';
				} else {
					track.style.transition = 'transform 0.5s ease-in-out';
				}
				
				// Update track position
				track.style.transform = `translateX(-${currentIndex * 100}%)`;
				
				// Update slide classes for blur effect
				slides.forEach((slide, index) => {
					slide.classList.remove('active', 'blur');
					if (index === currentIndex) {
						slide.classList.add('active');
					} else {
						slide.classList.add('blur');
					}
				});

				// Update dots and counter (only for real slides, not duplicates)
				let displayIndex;
				if (hasMultipleSlides) {
					if (currentIndex === 0) {
						displayIndex = totalSlides - 1; // duplicate-last shows last slide
					} else if (currentIndex > totalSlides) {
						displayIndex = 0; // duplicate-first shows first slide
					} else {
						displayIndex = currentIndex - 1; // adjust for duplicate-last at index 0
					}
				} else {
					displayIndex = currentIndex;
				}

				dots.forEach((dot, index) => {
					dot.classList.toggle('active', index === displayIndex);
				});

				// Update counter
				currentSlideSpan.textContent = (displayIndex) + 1;
			}

			function nextSlide() {
				if (isTransitioning) return;
				isTransitioning = true;
				
				currentIndex++;
				updateCarousel();
				
				// If we're at the duplicate slide (after last real slide)
				if (hasMultipleSlides && currentIndex > totalSlides) {
					setTimeout(() => {
						currentIndex = 1; // Jump back to first real slide (index 1)
						updateCarousel(true); // Instant transition
						isTransitioning = false;
					}, 500); // Wait for transition to complete
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
				
				// If we're at the duplicate slide (before first real slide)
				if (hasMultipleSlides && currentIndex < 1) {
					setTimeout(() => {
						currentIndex = totalSlides; // Jump to last real slide
						updateCarousel(true); // Instant transition
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
				
				// Adjust index for duplicate slide at beginning
				currentIndex = hasMultipleSlides ? index + 1 : index;
				updateCarousel();
				setTimeout(() => {
					isTransitioning = false;
				}, 500);
			}

			// Initialize display
			updateCarousel(true);

			// Event listeners (only add if buttons exist)
			if (prevBtn) prevBtn.addEventListener('click', prevSlide);
			if (nextBtn) nextBtn.addEventListener('click', nextSlide);

			if (dots.length > 0) {
				dots.forEach((dot, index) => {
					dot.addEventListener('click', () => goToSlide(index));
				});
			}

			// Keyboard navigation
			document.addEventListener('keydown', function(e) {
				if (e.key === 'ArrowLeft') {
					prevSlide();
				} else if (e.key === 'ArrowRight') {
					nextSlide();
				}
			});

			// Auto-play (optional - uncomment to enable)
			// if (hasMultipleSlides) {
			//     setInterval(nextSlide, 5000);
			// }
		});
	</script>
</section>
@endif