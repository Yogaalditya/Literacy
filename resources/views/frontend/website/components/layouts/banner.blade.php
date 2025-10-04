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

    @php
        // Determine the appropriate countdown target
        $now = now();
        $countdownTarget = null;
        
        if ($currentScheduledConference->date_start && $currentScheduledConference->date_end) {
            if ($now->lt($currentScheduledConference->date_start)) {
                $countdownTarget = $currentScheduledConference->date_start;
            }
            elseif ($now->gte($currentScheduledConference->date_start) && $now->lt($currentScheduledConference->date_end)) {
                $countdownTarget = $currentScheduledConference->date_end;
            }
            else {
                $countdownTarget = null;
            }
        } else {
            $countdownTarget = $currentScheduledConference->date_start ?? $currentScheduledConference->date_end;
        }
    @endphp

    @if($bannerUrl)
        <!-- Hero Banner Image -->
        <div class="banner-hero-wrapper relative w-full overflow-hidden">
            <!-- Main Banner Image -->
            <img src="{{ $bannerUrl }}" 
                 alt="Conference Banner" 
                 class="banner-image-hero w-full h-full object-cover" />
            
            <!-- Content Overlay with Vertical Layout -->
            <div class="absolute inset-0 flex flex-col justify-start px-4 sm:px-6 lg:px-8">
                <div class="container mx-auto max-w-full">
                    <div class="banner-content flex flex-col space-y-6 md:space-y-8 max-w-4xl">
                        <!-- Title Section -->
                        <div class="section-title mt-4 md:mt-0" style="max-width: 600px;">
                            <h1 class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl tracking-tight drop-shadow-lg leading-tight break-words color-latest">
                                {{ $currentScheduledConference->title }}
                            </h1>
                        </div>

                        <!-- Date and Location Section (Only shown when countdown is enabled) -->
                        @if($theme->getSetting('enable_countdown'))
                            <div class="space-y-3 md:space-y-4">
                                <!-- Date Section -->
                                <div class="flex items-start md:items-center">
                                    <div class="flex items-center banner-info-overlay px-3 py-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-gray-800 font-semibold text-sm md:text-base">
                                            @if($currentScheduledConference->date_start && $currentScheduledConference->date_end)
                                                {{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }} - {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}
                                            @else
                                                <span class="text-gray-400">Dates to be announced</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                
                                <!-- Location Section -->
                                 @if ($currentScheduledConference->getMeta('location'))
                                <div class="flex items-start md:items-center">
                                    <div class="flex items-center banner-info-overlay px-3 py-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-gray-800 font-semibold text-sm md:text-base">
                                            {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'Location to be announced') }}
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endif

                        <!-- Buttons Section -->
                        @if($theme->getSetting('banner_buttons'))
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-2 md:mt-4 w-fit">
                                @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                                    <a 
                                        @style([
                                            'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                            'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                                        ])
                                        href="{{ data_get($button, 'url') }}" 
                                        class="button-banner button-banner-square text-sm md:text-base w-full sm:w-fit"
                                        >
                                        {{ data_get($button, 'text') }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Info Card Overlay -->
            <div class="banner-info-card absolute bottom-4 sm:bottom-8 md:bottom-12 left-1/2 transform -translate-x-1/2 w-[95%] sm:w-[90%] md:w-full max-w-6xl bg-white/90 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 flex flex-col md:flex-row justify-center items-center gap-4 sm:gap-6 md:gap-8 lg:gap-32 border border-gray-100/20 min-h-[auto] md:h-[120px]">
                
                

                @if($theme->getSetting('enable_countdown') && $countdownTarget)
                    <!-- Countdown Timer Component (Only when countdown is enabled) -->
                    <div 
                        class="flex flex-col items-center text-center w-full sm:w-auto"
                        data-countdown-target="{{ $countdownTarget->format('c') }}"
                    >
                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 text-xs sm:text-sm font-medium">Time Remaining</p>
                        </div>
                        <div class="countdown-con flex flex-row flex-wrap gap-[32px] sm:gap-[48px] md:gap-[64px] lg:gap-[150px] items-center justify-center">
                            <div class="time-segment flex flex-col items-center">
                                <div id="days" class="text-gradient text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800">00</div>
                                <div class="uppercase text-sm sm:text-base md:text-lg text-gray-500 font-medium">Days</div>
                            </div>
                            <div class="time-segment flex flex-col items-center">
                                <div id="hours" class="text-gradient text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800">00</div>
                                <div class="uppercase text-sm sm:text-base md:text-lg text-gray-500 font-medium">Hours</div>
                            </div>
                            <div class="time-segment flex flex-col items-center">
                                <div id="minutes" class="text-gradient text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800">00</div>
                                <div class="uppercase text-sm sm:text-base md:text-lg text-gray-500 font-medium">Minutes</div>
                            </div>
                            <div class="time-segment flex flex-col items-center">
                                <div id="seconds" class="text-gradient text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800">00</div>
                                <div class="uppercase text-sm sm:text-base md:text-lg text-gray-500 font-medium">Seconds</div>
                            </div>
                        </div>
                    </div>
                @elseif($theme->getSetting('enable_countdown') && !$countdownTarget)
                    <!-- Conference has ended message -->
                    <div class="flex flex-col items-center text-center w-full">
                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500 text-xs sm:text-sm font-medium">Conference Status</p>
                        </div>
                        <div class="text-lg text-center text-gray-600 font-semibold">Conference has ended!</div>
                    </div>
                @else
                    <!-- Location and Date Components (Only when countdown is disabled) -->
                    
                    <!-- Location Component -->
                    @if ($currentScheduledConference->getMeta('location'))
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
                    @endif

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
                @endif
            </div>
        </div>
    @else
        <!-- Fallback when no banner image -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 md:pt-20 pb-8">
            <div class="max-w-4xl">
                <div class="section-line-1 relative mb-8">
                    <div class="mb-6" style="max-width: 600px;">
                        <h1 class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl tracking-tight drop-shadow-lg leading-tight break-words color-latest">
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

<style>
/* Countdown Timer Styles */
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fadeIn {
    animation: fadeIn 1s ease-out forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideUp {
    opacity: 0;
    animation: slideUp 0.6s ease-out forwards;
}

@keyframes popIn {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    80% {
        transform: scale(1.1);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-popIn {
    opacity: 0;
    animation: popIn 0.5s ease-out forwards;
}

.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }
.delay-500 { animation-delay: 0.5s; }
.delay-600 { animation-delay: 0.6s; }
.delay-700 { animation-delay: 0.7s; }
.delay-800 { animation-delay: 0.8s; }
.delay-900 { animation-delay: 0.9s; }

/* Countdown container styling */
.countdown-con {
    min-height: 60px;
}

@media (min-width: 768px) {
    .countdown-con {
        min-height: 80px;
    }
}

/* Text gradient effect for countdown numbers */
.text-gradient {
    background: linear-gradient(135deg, oklch(var(--p)), #667eea);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<script>
    function updateCountdown() {
        const endDate = new Date("{{ $currentScheduledConference->date_end ? $currentScheduledConference->date_end->toIso8601String() : ($currentScheduledConference->date_start ? $currentScheduledConference->date_start->toIso8601String() : '') }}").getTime();
        const now = Date.now();
        const timeLeft = endDate - now;

        if (!endDate) {
            return;
        }

        if (timeLeft >= 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
        } else {
            clearInterval(countdownTimer);
            document.querySelector('.countdown-section').innerHTML = '<div class="text-2xl text-center text-gray-600">Event has ended!</div>';
        }
    }

    const countdownTimer = setInterval(updateCountdown, 1000);
    updateCountdown();
    
</script>