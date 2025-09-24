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

            <div class="flex flex-col space-y-4 mb-8">
                @if($currentScheduledConference->date_start || $currentScheduledConference->date_end)
                    <div class="flex items-center">
                        <span class="icon-banner mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            @if($currentScheduledConference->date_start)
                                @if($currentScheduledConference->date_end && $currentScheduledConference->date_start->format(Setting::get('format_date')) !== $currentScheduledConference->date_end->format(Setting::get('format_date')))
                                    <span class="font-semibold color-latest">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                    <span class="font-semibold color-latest"> - {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}</span>
                                @else
                                    <span class="font-semibold color-latest">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                <div class="flex items-center">
                    <span class="icon-banner mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <div>
                        <span class="font-semibold color-latest">{{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'To be announced') }}</span>
                    </div>
                </div>
            </div>

            @if($bannerUrl)
                <div class="mt-4">
                    <img src="{{ $bannerUrl }}" alt="Conference Banner" class="banner-image w-full h-48 md:h-64 object-cover rounded-3xl shadow-md" />
                </div>
            @endif
        </div>
    </div>
</section>