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
		.splide__slide {
			transition: filter 0.3s ease;
			filter: blur(2px);
			opacity: 0.6;
		}
		
		.splide__slide.is-active {
			filter: blur(0px);
			opacity: 1;
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			new Splide('#partner-slider', {
				type: 'loop',
				focus: 'center',
				perPage: 3,
				autoplay: true,
				breakpoints: {
					768: {
						perPage: 1,
					},
				},
			}).mount();
		});
	</script>
</section>
@endif