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
<section id="sponsors" class="gvav-section">
	<div class="gvav-container">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<h2 class="text-3xl md:text-4xl font-bold mb-4 section-title-with-underline" style="color: var(--color-text);">Our Sponsors</h2>
			<p class="max-w-2xl mx-auto mt-4" style="color: var(--color-text-secondary);">Thank you to all our amazing sponsors who make our work possible</p>
		</div>

		<!-- Sponsor Carousel -->
		<div class="splide" id="sponsor-slider">
			<div class="splide__track">
				<ul class="splide__list">
					@foreach ($allSponsors as $index => $item)
						@php 
							$sponsor = $item['sponsor'];
							$level = $item['level'];
							$tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
						@endphp
						<li class="splide__slide">
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
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>

	<style>
		.splide__slide {
			transition: filter 0.3s ease;
			filter: blur(2px);
			opacity: 0.6;
		}
		
		.splide__slide.is-active {
			filter: blur(0px);
			opacity: 1;
		}

		/* Pagination styling (for now for mobile) */
		#sponsor-slider .splide__pagination {
			margin-top: 2rem;
			bottom: -3rem;
		}

		#sponsor-slider .splide__pagination__page {
			background: var(--color-text-secondary);
			opacity: 0.4;
			transition: all 0.3s ease;
		}

		#sponsor-slider .splide__pagination__page.is-active {
			background: var(--color-text);
			opacity: 1;
			transform: scale(1.2);
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			new Splide('#sponsor-slider', {
				type: 'loop',
				focus: 'center',
				perPage: 3,
				autoplay: true,
				pagination: false,
				breakpoints: {
					768: {
						perPage: 1,
						pagination: true,
					},
				},
			}).mount();
		});
	</script>
</section>
@endif