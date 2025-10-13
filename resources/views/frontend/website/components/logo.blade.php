@props([
    'homeUrl' => url('/'),
    'headerLogo' => null,
    'headerLogoAltText' => app()->getCurrentConference()?->name ?? config('app.name'),
])

@if ($headerLogo)
    <x-literacy::link
        {{ $attributes->merge(['class' => 'inline-flex items-center no-underline-hover']) }}
        :href="$homeUrl"
    >
        <div class="relative h-8 sm:h-10 lg:h-12 min-w-[80px] sm:min-w-[100px] max-w-[150px] sm:max-w-[200px]"> {{-- Responsive logo size --}}
            <img
                src="{{ $headerLogo }}"
                alt="{{ $headerLogoAltText }}"
                class="absolute inset-0 w-full h-full object-contain"
            />
        </div>
    </x-literacy::link>
@else
    <x-literacy::link
        :href="$homeUrl"
        {{ $attributes->merge([
            'class' => '
                no-underline-hover
            '
        ]) }}
    >
        <span class="logo-text-gradient font-bold">{{ $headerLogoAltText }}</span>
    </x-literacy::link>
@endif
