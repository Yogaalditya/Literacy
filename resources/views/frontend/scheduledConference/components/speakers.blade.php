@if ($currentScheduledConference?->speakers->isNotEmpty())
<section id="speakers">
	<div class="container mx-auto w-full px-4 max-w-7xl">
		<div class="space-y-24">
			@foreach ($currentScheduledConference->speakerRoles as $role)
				@if ($role->speakers->isNotEmpty())
					<div class="flex flex-col items-center">
						<h3 class="text-4xl font-bold text-gray-800 mb-16 text-center">{{ $role->name }}
						</h3>
						<div class="flex flex-wrap justify-center gap-12">
							@foreach ($role->speakers as $speaker)
								<div class="flex flex-col items-center text-center max-w-xs p-6">
									<!-- Speaker Image with rounded square design -->
									<img
										class="h-56 w-56 object-cover mx-auto border-4 border-gray-200 dark:border-gray-600 shadow-sm rounded-2xl"
										src="{{ $speaker->getFilamentAvatarUrl() }}"
										alt="{{ $speaker->fullName }}"
									/>

									<!-- Name Card below image -->
									<div class="bg-white dark:bg-gray-800 px-4 py-3 rounded-2xl shadow-md border border-gray-200 dark:border-gray-600 mt-4 w-56 text-center">
										<h4 class="text-xl font-bold color-latest break-words leading-tight">
											{{ $speaker->fullName }}
										</h4>
									</div>

									<!-- Affiliation and Academic Icons below name -->
									<div class="w-full mt-4">
										@if ($speaker->getMeta('affiliation'))
											<p class="text-lg text-gray-600 dark:text-gray-400">
												{{ $speaker->getMeta('affiliation') }}
											</p>
										@endif
										@if($speaker->getMeta('scopus_url') || $speaker->getMeta('google_scholar_url') || $speaker->getMeta('orcid_url'))
											<div class="cf-committee-scholar flex justify-center items-center gap-3 mt-2">
												@if($speaker->getMeta('orcid_url'))
													<a href="{{ $speaker->getMeta('orcid_url') }}" target="_blank">
														<x-academicon-orcid class="w-6 h-6 dark:text-[#A6CE39]" />
													</a>
												@endif
												@if($speaker->getMeta('google_scholar_url'))
													<a href="{{ $speaker->getMeta('google_scholar_url') }}" target="_blank">
														<x-academicon-google-scholar class="w-6 h-6 dark:text-[#4285F4]" />
													</a>
												@endif
												@if($speaker->getMeta('scopus_url'))
													<a href="{{ $speaker->getMeta('scopus_url') }}" target="_blank">
														<x-academicon-scopus class="w-6 h-6 dark:text-[#e9711c]" />
													</a>
												@endif
											</div>
										@endif
										@if ($speaker->getMeta('bio'))
											<p class="text-gray-600 dark:text-gray-400 text-base line-clamp-3 mt-4">
												{{ $speaker->getMeta('bio') }}
											</p>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endif
			@endforeach
		</div>
	</div>
</section>
@endif