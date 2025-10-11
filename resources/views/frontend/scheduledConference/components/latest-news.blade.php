@if ($currentScheduledConference)
<section class="latest-news gvav-section">
	<div class="gvav-container">
		<!-- Section Header -->
		<div class="flex justify-between items-center mb-16">
			<div class="text-start max-w-3xl">
				<h2 class="text-4xl md:text-5xl font-bold leading-tight" style="color: var(--color-text);">
					Latest News
				</h2>
			</div>
			@if ($currentScheduledConference->announcements()
			->where(function ($query) {
				$query->where('expires_at', '>', now()->startOfDay())
					  ->orWhereNull('expires_at');
			})->count() > 0)
			<!-- Load More Button -->
			<div>
				<a href="{{ route(App\Frontend\ScheduledConference\Pages\Announcements::getRouteName('scheduledConference')) }}"
					class="inline-flex items-center justify-center px-8 py-3 text-base font-semibold rounded-lg transition-all duration-300 hover:border-accent hover:text-accent whitespace-nowrap"
					style="background-color: var(--color-card-bg); color: var(--color-text); border: 2px solid var(--color-border);"
					onmouseover="this.style.borderColor='oklch(var(--p))'; this.style.color='oklch(var(--p))';"
					onmouseout="this.style.borderColor='var(--color-border)'; this.style.color='var(--color-text)';">
					Load More
				</a>
			</div>
			@endif
		</div>

		@if ($currentScheduledConference->announcements()
		->where(function ($query) {
			$query->where('expires_at', '>', now()->startOfDay())
				  ->orWhereNull('expires_at');
		})->count() > 0)

			<!-- Announcements Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				@foreach ($currentScheduledConference->announcements()
				->where(function ($query) {
					$query->where('expires_at', '>', now()->startOfDay())
						->orWhereNull('expires_at');
				})
				->orderBy('created_at', 'DESC')
				->get() as $announcement)
				
					@php
						$content = $announcement->getMeta('content');
						preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
						$imageUrl = $matches[1] ?? '';
					@endphp

					<article class="latest-news-card w-full" style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); box-shadow: 0 4px 6px var(--color-shadow);">
						<!-- Image Section -->
						<div class="p-2.5">
							<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}" class="block">
								<div class="relative w-full h-[270px] rounded-lg overflow-hidden">
									@if($imageUrl)
										<img src="{{ $imageUrl }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover" loading="lazy">
									@else
										<div class="w-full h-full flex items-center justify-center" style="background-color: var(--color-bg);">
											<span class="text-xl" style="color: var(--color-text-secondary);">No Image Available</span>
										</div>
									@endif
								</div>
							</a>
						</div>

						<!-- Content Section -->
						<div class="px-6 pb-6">
							<!-- Date -->
							<div class="mb-3">
								<span class="text-sm font-medium" style="color: var(--color-text-secondary);">
									{{ $announcement->created_at->format(Setting::get('format_date')) }}
								</span>
							</div>

							<!-- Title -->
							<div class="min-h-[3.5rem] mb-3">
								<h3 class="text-xl font-bold line-clamp-2">
									<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}" 
									   class="block" style="color: var(--color-text);">
										{{ $announcement->title }}
									</a>
								</h3>
							</div>

							<!-- Summary -->
							<p class="mb-4 line-clamp-3 leading-relaxed text-sm" style="color: var(--color-text-secondary);">
								{{ $announcement->getMeta('summary') }}
							</p>

							<!-- Read More Button -->
							<div class="mt-auto">
								<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}"
								   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
								   style="background-color: oklch(var(--p)); color: var(--color-text);">
									Read More
									<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
									</svg>
								</a>
							</div>
						</div>
					</article>
				@endforeach
			</div>
		@else
			<!-- Empty State -->
			<div class="text-center py-16 px-4">
				<div class="max-w-md mx-auto">
					<svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
						viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
							d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
					</svg>
					<h3 class="mt-4 text-xl font-semibold text-gray-900">No Announcements Yet</h3>
					<p class="mt-2 text-gray-600">Stay tuned! New announcements will be posted here as they
						become available.</p>
				</div>
			</div>
		@endif
	</div>
</section>
@endif