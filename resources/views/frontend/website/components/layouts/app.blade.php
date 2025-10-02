@props([
    'title' => null,
])
<x-literacy::layouts.base :title="$title">
    <div class="flex h-full min-h-screen flex-col">
        @hook('Frontend::Views::Header')

        {{-- Load Header Layout --}}
        <x-literacy::layouts.header />


        <main class="py-3 ">
            {{-- Load Main Layout --}}
            {{ $slot }}
        </main>

        {{-- Load Footer Layout --}}
        <x-literacy::layouts.footer />

        @hook('Frontend::Views::Footer')
    </div>
</x-literacy::layouts.base>

