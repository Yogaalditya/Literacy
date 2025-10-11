@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationItems = app()->getNavigationItems('user-navigation-menu');
    $homeUrl = app()->getCurrentConference()?->getHomeUrl() ?? url('/');
@endphp

<aside class="flex items-center lg:hidden" x-slide-over>
    <button @@click="toggleSlideOver" class="btn btn-square btn-sm btn-ghost">
        <x-heroicon-o-bars-3 class="h-6 w-6" x-show="!slideOverOpen" x-cloak />
        <x-heroicon-o-x-mark class="h-6 w-6" x-show="slideOverOpen" x-cloak />
    </button>
    <template x-teleport="body">
        <div x-show="slideOverOpen" @@keydown.window.escape="closeSlideOver" class="relative z-[70]">
    <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @@click="closeSlideOver"
                class="fixed inset-0 backdrop-blur-[2px]"></div>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 flex max-w-full pr-10">
                        <div x-show="slideOverOpen" @@click.away="closeSlideOver"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                            class="w-screen max-w-xs">
                            <div class="bg-white border-neutral-100/70 border-r shadow-lg h-svh overflow-y-scroll">
                                <div class="navigation-menu-mobile ps-4 py-2 text-primary-content flex justify-between items-center">
                                    <x-literacy::logo 
                                    :headerLogo="$headerLogo" 
                                    :homeUrl="$homeUrl" 
                                    :headerLogoAltText="app()->getCurrentConference()?->name ?? config('app.name')" 
                                    @class([
                                        'font-bold text-white',
                                        '-ml-6' => $headerLogo, // Image logo lebih ke kiri
                                    ]) />
                                    <div class="flex items-center gap-2">
                                        <!-- Dark/Light Mode Toggle Button -->
                                        @if(App\Facades\Plugin::getPlugin('Literacy')->getSetting('enable_theme'))
                                        <button 
                                            @@click="$store.darkMode.toggle()" 
                                            class="btn btn-sm btn-square btn-ghost rounded-full p-1.5 transition-colors hover:bg-white/20 focus:outline-none group"
                                        >
                                            <!-- Sun Icon (Light Mode) -->
                                            <svg x-cloak x-show="!$store.darkMode.isDark" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-75 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-75 translate-y-2" class="h-5 w-5 text-white transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <!-- Moon Icon (Dark Mode) -->
                                            <svg x-cloak x-show="$store.darkMode.isDark" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-75 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-75 -translate-y-2" class="h-5 w-5 text-white transition-transform duration-300 group-hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                            </svg>
                                        </button>
                                        @endif
                                        <button @@click="closeSlideOver" class="btn btn-sm btn-square btn-ghost">
                                            <x-heroicon-o-x-mark class="h-6 w-6" />
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between">
                                    @if($primaryNavigationItems->isNotEmpty())
                                        <div class="primary-navigations-menu-mobile">
                                            <ul role="list space-y-2">
                                                @foreach ($primaryNavigationItems as $item)
                                                    @if(!$item->isDisplayed())
                                                        @continue
                                                    @endif
                                                    @if ($item->children->isEmpty())
                                                        <li class="navigation-menu-item relative">
                                                            <x-website::link @class([
                                                                'hover:bg-base-content/10 items-center py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full flex',
                                                                'text-primary font-semibold' => request()->url() === $item->getUrl(),
                                                                'text-slate-900 font-medium' => request()->url() !== $item->getUrl(),
                                                            ]) :href="$item->getUrl()">
                                                                {{ $item->getLabel() }}
                                                            </x-website::link>
                                                        </li>
                                                    @else
                                                        <li x-data="{ open: false }" class="navigation-menu-item relative">
                                                            <button 
                                                                x-ref="button"
                                                                @@click="open = !open"
                                                                class="hover:bg-base-content/10 py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full flex items-center justify-between text-slate-900 font-medium"
                                                            >
                                                                <span>{{ $item->getLabel() }}</span>
                                                                <svg :class="{ '-rotate-180': open }"
                                                                    class="transition relative top-[1px] ms-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" aria-hidden="true">
                                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                                </svg>
                                                            </button>
                                                            <ul x-show="open" x-collapse class="mt-1">
                                                                @foreach ($item->children as $key => $childItem)
                                                                    <li class="navigation-menu-item relative">
                                                                        <x-website::link @class([
                                                                            'hover:bg-base-content/10 items-center py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full flex',
                                                                            'text-primary font-semibold' => request()->url() === $item->getUrl(),
                                                                            'text-slate-900 font-medium' => request()->url() !== $item->getUrl(),
                                                                        ]) :href="$item->getUrl()">
                                                                            {{ $childItem->getLabel() }}
                                                                        </x-website::link>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="user-navigations-menu-mobile">
                                        <ul role="list space-y-2">
                                           @foreach ($userNavigationItems as $item)
                                                @if(!$item->isDisplayed())
                                                    @continue
                                                @endif
                                                @if ($item->children->isEmpty())
                                                    <li class="navigation-menu-item relative">
                                                        <x-website::link @class([
                                                            'navigation-menu-mobile-item hover:bg-base-content/10 items-center py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full flex',
                                                            'text-primary font-semibold' => request()->url() === $item->getUrl(),
                                                            'font-medium' => request()->url() !== $item->getUrl(),
                                                        ]) :href="$item->getUrl()">
                                                            {{ $item->getLabel() }}
                                                        </x-website::link>
                                                    </li>
                                                @else
                                                    <li x-data="{ open: false }" class="navigation-menu-item relative">
                                                        <button 
                                                            x-ref="button"
                                                            @@click="open = !open"
                                                            class="navigation-menu-mobile-item-parent hover:bg-base-content/10 py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full flex items-center justify-between font-semibold"
                                                        >
                                                            <span>{{ $item->getLabel() }}</span>
                                                            <svg :class="{ '-rotate-180': open }"
                                                                class="transition relative top-[1px] ml-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" aria-hidden="true">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        <ul x-show="open" x-collapse class="mt-1">
                                                            @foreach ($item->children as $key => $childItem)
                                                                <li class="navigation-menu-item relative">
                                                                    <x-website::link @class([
                                                                        'navigation-menu-mobile-item hover:bg-base-content/10 items-center py-2 px-4 pr-6 pl-8 text-sm outline-none transition-colors gap-4 w-full flex text-gray-600',
                                                                    ]) :href="$childItem->getUrl()">
                                                                        {{ $childItem->getLabel() }}
                                                                    </x-website::link>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</aside>
