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
foreach ($sponsorLevels as $index => $sponsorLevel) {
    if ($sponsorLevel->stakeholders->isNotEmpty()) {
        foreach ($sponsorLevel->stakeholders as $sponsor) {
            if ($sponsor->getFirstMedia('logo')) {
                $allSponsors->push([
                    'sponsor' => $sponsor,
                    'level' => $sponsorLevel->name,
                    'levelId' => $index + 1
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
							$levelId = $item['levelId'] ?? null;
							$tag = $sponsor->getMeta('url') ? 'a' : 'div';
							
							// Determine level class based on ID
							$levelClass = '';
							if ($levelId == 1) {
								$levelClass = 'sponsor-level-gold';
							} elseif ($levelId == 2) {
								$levelClass = 'sponsor-level-silver';
							} elseif ($levelId == 3) {
								$levelClass = 'sponsor-level-bronze';
							} else {
								$levelClass = 'sponsor-level-default';
							}
						@endphp
						<li class="splide__slide">
							<div class="text-center">
								@if($level)
									<h3 class="text-xl font-medium mb-6 {{ $levelClass }}">{{ $level }}</h3>
								@else
									<h3 class="text-xl font-medium mb-6" style="visibility: hidden;">Placeholder</h3>
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

		/* Sponsor Level Colors - Gemerlang */
		.sponsor-level-gold {
			background: linear-gradient(135deg, #FFD700 0%, #FFA500 25%, #FFD700 50%, #FFED4E 75%, #FFD700 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			background-size: 200% auto;
			animation: shimmer 3s linear infinite;
			font-weight: 700;
			filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.6)) drop-shadow(0 0 8px rgba(255, 215, 0, 0.4));
		}

		.sponsor-level-silver {
			background: linear-gradient(135deg, #C0C0C0 0%, #E8E8E8 25%, #C0C0C0 50%, #F5F5F5 75%, #C0C0C0 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			background-size: 200% auto;
			animation: shimmer 3s linear infinite;
			font-weight: 700;
			filter: drop-shadow(0 2px 4px rgba(128, 128, 128, 0.6)) drop-shadow(0 0 8px rgba(192, 192, 192, 0.4));
		}

		.sponsor-level-bronze {
			background: linear-gradient(135deg, #CD7F32 0%, #B87333 25%, #CD7F32 50%, #E59866 75%, #CD7F32 100%);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			background-size: 200% auto;
			animation: shimmer 3s linear infinite;
			font-weight: 700;
			filter: drop-shadow(0 2px 4px rgba(160, 82, 45, 0.6)) drop-shadow(0 0 8px rgba(205, 127, 50, 0.4));
		}

		.sponsor-level-default {
			color: var(--color-text);
		}

		@keyframes shimmer {
			0% {
				background-position: 0% 50%;
			}
			50% {
				background-position: 100% 50%;
			}
			100% {
				background-position: 0% 50%;
			}
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const totalSponsors = {{ $allSponsors->count() }};
			new Splide('#sponsor-slider', {
				type: totalSponsors > 1 ? 'loop' : 'slide',
				focus: 'center',
				perPage: 3,
				autoplay: totalSponsors > 1,
				pagination: false,
				arrows: totalSponsors > 1,
				drag: totalSponsors > 1,
				breakpoints: {
					768: {
						perPage: 1,
						pagination: totalSponsors > 1,
					},
				},
			}).mount();
		});
	</script>
</section>
@endif