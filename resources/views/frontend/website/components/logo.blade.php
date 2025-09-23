@props([
    'homeUrl' => url('/'),
    'headerLogo' => null,
    'headerLogoAltText' => app()->getCurrentConference()?->name ?? config('app.name'),
])

@if ($headerLogo)
    <x-violence::link
        {{ $attributes->merge(['class' => 'inline-flex items-center no-underline-hover']) }}
        :href="$homeUrl"
    >
        <div class="relative h-12 min-w-[100px] max-w-[200px]"> {{-- Sesuaikan ukuran --}}
            <img
                src="{{ $headerLogo }}"
                alt="{{ $headerLogoAltText }}"
                class="absolute inset-0 w-full h-full object-contain"
            />
        </div>
    </x-violence::link>
@else
    <x-violence::link
        :href="$homeUrl"
        {{ $attributes->merge([
            'class' => '
                no-underline-hover
                text-lg
                sm:text-xl
                font-semibold
            '
        ]) }}
    >
        {{ $headerLogoAltText }}
    </x-violence::link>
@endif
