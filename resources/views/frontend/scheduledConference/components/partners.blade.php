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
<section id="partners" class="gvav-section">
	<div class="gvav-container">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<h2 class="text-3xl md:text-4xl font-bold mb-4 section-title-with-underline" style="color: var(--color-text);">Our Partners</h2>
			<p class="max-w-2xl mx-auto mt-4" style="color: var(--color-text-secondary);">Thank you to all our amazing partners who support our mission</p>
		</div>

		<!-- Partner Carousel -->
		<div class="splide" id="partner-slider">
			<div class="splide__track">
				<ul class="splide__list">
					@foreach ($allPartners as $index => $item)
						@php 
							$partner = $item['partner'];
							$tag = $partner->getMeta('url') ? 'a' : 'div'; 
						@endphp
						<li class="splide__slide">
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
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>

	<style>

		/* Pagination styling (for now for mobile) */
		#partner-slider .splide__pagination {
			margin-top: 2rem;
			bottom: -3rem;
		}

		#partner-slider .splide__pagination__page {
			background: var(--color-text-secondary);
			opacity: 0.4;
			transition: all 0.3s ease;
		}

		#partner-slider .splide__pagination__page.is-active {
			background: var(--color-text);
			opacity: 1;
			transform: scale(1.2);
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const totalPartners = {{ $allPartners->count() }};
			new Splide('#partner-slider', {
				type: totalPartners > 1 ? 'loop' : 'slide',
				focus: 'center',
				perPage: 3,
				autoplay: totalPartners > 1,
				pagination: false,
				arrows: totalPartners > 1,
				drag: totalPartners > 1,
				breakpoints: {
					768: {
						perPage: 1,
						pagination: totalPartners > 1,
					},
				},
			}).mount();
		});
	</script>
</section>
@endif