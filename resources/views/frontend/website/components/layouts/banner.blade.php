<section class="hero-banner banner-literacy">
    @php
        $images = $currentScheduledConference->getMedia('literacy-header');
        $bannerUrl = null;
        foreach ($images as $image) {
            // Get the largest available version for a crisp banner image
            $bannerUrl = $image->getAvailableUrl(['original', 'large', 'thumb-xl', 'thumb']);
            break;
        }
    @endphp

    @if($bannerUrl)
        <!-- Hero Banner Image -->
        <div class="banner-hero-wrapper relative w-full overflow-hidden">
            <!-- Main Banner Image -->
            <img src="{{ $bannerUrl }}" 
                 alt="Conference Banner" 
                 class="banner-image-hero w-full h-full object-cover" />
            
            <!-- Content Overlay -->
            <div class="absolute inset-0 flex flex-col justify-center items-start px-4 sm:px-6 lg:px-8 pt-16 md:pt-20">
                <div class="container mx-auto max-w-full">
                    <div class="section-line-1 relative mb-8 max-w-4xl">
                        <div class="mb-6">
                            <h1 class="font-bold text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl tracking-tight drop-shadow-lg leading-tight break-words color-latest">
                                {{ $currentScheduledConference->title }}
                            </h1>
                        </div>
                        @if($theme->getSetting('banner_buttons'))
                            <div class="banner-buttons-container">
                                <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                                    @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                                        <a 
                                            @style([
                                                'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                                'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                                            ])
                                            href="{{ data_get($button, 'url') }}" 
                                            class="button-banner button-banner-square text-sm sm:text-base"
                                            >
                                            {{ data_get($button, 'text') }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Info Card Overlay -->
            <div class="banner-info-card absolute bottom-4 sm:bottom-8 md:bottom-12 left-1/2 transform -translate-x-1/2 w-[95%] sm:w-[90%] md:w-full max-w-6xl bg-white rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 flex flex-col md:flex-row justify-center items-center gap-4 sm:gap-6 md:gap-8 lg:gap-32 border border-gray-100 min-h-[auto] md:h-[120px]">
                
                <!-- Location Component -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left w-full md:w-auto">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Location</p>
                    </div>
                    <p class="text-gray-800 font-semibold leading-tight text-xs sm:text-sm md:text-base">
                        {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'To be announced') }}
                    </p>
                </div>

                <!-- Start In Component -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Start In</p>
                    </div>
                    <p class="text-gray-800 font-semibold text-xs sm:text-sm md:text-base">
                        @if($currentScheduledConference->date_start)
                            {{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}
                        @else
                            <span class="text-gray-400">To be announced</span>
                        @endif
                    </p>
                </div>

                <!-- Stop In Component -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Stop In</p>
                    </div>
                    <p class="text-gray-800 font-semibold text-xs sm:text-sm md:text-base">
                        @if($currentScheduledConference->date_end)
                            {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}
                        @else
                            <span class="text-gray-400">To be announced</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Fallback when no banner image -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 md:pt-20 pb-8">
            <div class="max-w-4xl">
                <div class="section-line-1 relative mb-8">
                    <div class="mb-6">
                        <h1 class="font-bold text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl tracking-tight drop-shadow-lg leading-tight break-words color-latest">
                            {{ $currentScheduledConference->title }}
                        </h1>
                    </div>
                    @if($theme->getSetting('banner_buttons'))
                        <div class="banner-buttons-container">
                            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                                @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                                    <a 
                                        @style([
                                            'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                            'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                                        ])
                                        href="{{ data_get($button, 'url') }}" 
                                        class="button-banner button-banner-square text-sm sm:text-base"
                                        >
                                        {{ data_get($button, 'text') }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    <!-- Add margin bottom to account for the overlay card -->
    <div class="mb-16"></div>
</section>