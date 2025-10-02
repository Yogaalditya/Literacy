@props([
    'breadcrumbs' => [],
])

@if(!empty($breadcrumbs))
<div {{ $attributes->class(['breadcrumbs text-sm breadcrumbs-container px-4 py-3 rounded-md']) }}>
    <ul class="flex items-center flex-wrap gap-2">
        @foreach ($breadcrumbs as $url => $label)
            <li class="flex items-center">
                @if(!is_int($url))
                    <x-literacy::link
                        :href="$url"
                        class="breadcrumbs-link transition-colors duration-200 font-medium"
                        style="color: var(--color-text-secondary);"
                    >
                        {{ $label }}
                    </x-literacy::link>
                @else
                    <span class="breadcrumbs-current" style="color: var(--color-text-secondary);">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endif
