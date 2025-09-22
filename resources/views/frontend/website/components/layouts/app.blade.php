@props([
    'title' => null,
])
<x-violence::layouts.base :title="$title">
    <div class="flex h-full min-h-screen flex-col">
        @hook('Frontend::Views::Header')

        {{-- Load Header Layout --}}
        <x-violence::layouts.header />


        <main class="py-3 ">
            {{-- Load Main Layout --}}
            {{ $slot }}
        </main>

        {{-- Load Footer Layout --}}
        <x-violence::layouts.footer />

        @hook('Frontend::Views::Footer')
    </div>
</x-violence::layouts.base>

