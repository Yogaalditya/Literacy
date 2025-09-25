<section class="hero-banner banner-violence">
    @php
        $images = $currentScheduledConference->getMedia('violence-header');
        $bannerUrl = null;
        foreach ($images as $image) {
            // Get the largest available version for a crisp banner image
            $bannerUrl = $image->getAvailableUrl(['original', 'large', 'thumb-xl', 'thumb']);
            break;
        }
    @endphp

    <div class="container mx-auto px-4 pt-16 md:pt-20 pb-8">
        <div class="max-w-full">
            <div class="section-line-1 relative mb-8 xl:flex xl:items-start xl:gap-x-8">
                <div class="xl:w-3/5">
                    <h1 class="font-bold text-3xl lg:text-6xl tracking-tight drop-shadow-lg leading-tight break-words color-latest">
                        {{ $currentScheduledConference->title }}
                    </h1>
                </div>
                @if($theme->getSetting('description'))
                    <div class="xl:w-2/5">
                        <p class="mt-4 xl:mt-0 text-left text-base lg:text-lg leading-relaxed break-words"
                           style="overflow-wrap:anywhere; color: {{ $theme->getSetting('description_text_color') ?: '#ffffff' }};">
                            {!! nl2br(e($theme->getSetting('description'))) !!}
                        </p>
                        @if($theme->getSetting('banner_buttons'))
                        <div class="flex flex-col flex-wrap sm:flex-row gap-4 mt-4">
                            @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                                <a 
                                    @style([
                                        'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                        'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                                    ])
                                    href="{{ data_get($button, 'url') }}" 
                                    class="button-banner"
                                    >
                                    {{ data_get($button, 'text') }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                @endif
            </div>

            @if($bannerUrl)
                <div class="mt-4 relative">
                    <img src="{{ $bannerUrl }}" alt="Conference Banner" class="banner-image w-full h-48 md:h-64 object-cover rounded-3xl shadow-md" />
                    
                    <!-- Info Card Overlay -->
                    <div class="banner-info-card absolute -bottom-12 left-1/2 transform -translate-x-1/2 w-full max-w-6xl bg-white rounded-2xl shadow-xl p-6 flex flex-col md:flex-row justify-center items-center gap-8 md:gap-32 border border-gray-100 md:h-[120px]">
                        
                        <!-- Location Component -->
                        <div class="flex flex-col items-start text-left">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">Location</p>
                            </div>
                            <p class="text-gray-800 font-semibold text-left leading-tight">
                                {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'To be announced') }}
                            </p>
                        </div>

                        <!-- Start In Component -->
                        <div class="flex flex-col items-start text-left">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">Start In</p>
                            </div>
                            <p class="text-gray-800 font-semibold text-left">
                                @if($currentScheduledConference->date_start)
                                    {{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}
                                @else
                                    <span class="text-gray-400">To be announced</span>
                                @endif
                            </p>
                        </div>

                        <!-- Stop In Component -->
                        <div class="flex flex-col items-start text-left">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">Stop In</p>
                            </div>
                            <p class="text-gray-800 font-semibold text-left">
                                @if($currentScheduledConference->date_end)
                                    {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}
                                @else
                                    <span class="text-gray-400">To be announced</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Add margin bottom to account for the overlay card -->
    <div class="mb-16"></div>
</section>