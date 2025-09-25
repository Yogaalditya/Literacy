@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
    $homeUrl = app()->getCurrentConference()?->getHomeUrl() ?? url('/');
@endphp

@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="sticky-navbar top-0 z-50 w-full text-gray-800 transition-all duration-300 relative">
        <div class="absolute top-[22px] left-5 flex items-center gap-3">
            <div class="lg:hidden">
                <x-violence::navigation-menu-mobile />
            </div>
            <x-violence::logo
                :headerLogo="null"
                :homeUrl="$homeUrl"
                :headerLogoAltText="app()->getCurrentConference()?->name ?? config('app.name')"
                class="no-underline-hover text-2xl sm:text-2xl font-semibold text-gray-800"
            />
        </div>
        <div class="navbar-violence container mx-auto px-4 lg:px-8 py-3">
            <!-- Dark/Light Mode Toggle & User Card (Right) -->
            <div class="absolute top-3 right-4 hidden lg:block">
                <div class="flex items-center gap-3">
                    <!-- Dark/Light Mode Toggle Button -->
                    <div class="navbar-custom-violence rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-md px-3 h-14 w-14 flex items-center justify-center">
                        <button 
                            x-data="{ 
                                isDark: localStorage.getItem('darkMode') === 'true' || false,
                                init() {
                                    this.updateTheme();
                                    this.$watch('isDark', () => this.updateTheme());
                                },
                                updateTheme() {
                                    if (this.isDark) {
                                        document.documentElement.classList.add('dark');
                                        localStorage.setItem('darkMode', 'true');
                                    } else {
                                        document.documentElement.classList.remove('dark');
                                        localStorage.setItem('darkMode', 'false');
                                    }
                                }
                            }" 
                            @click="isDark = !isDark" 
                            class="btn btn-ghost btn-sm rounded-full p-2 transition-colors hover:bg-white/20 focus:outline-none group"
                        >
                            <!-- Sun Icon (Light Mode) -->
                            <svg x-cloak x-show="!isDark" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="h-5 w-5 text-gray-800 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <!-- Moon Icon (Dark Mode) -->
                            <svg x-cloak x-show="isDark" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="h-5 w-5 text-gray-800 transition-transform group-hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- User Card -->
                    <div x-data="{ open: false }" x-on:mouseleave="open = false" class="navbar-custom-violence relative rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-md px-3 lg:px-4 h-14 w-auto flex items-center z-40">
                    <button @@click="open = !open" x-on:mouseenter="open = true" class="btn btn-ghost btn-sm rounded-full inline-flex items-center justify-center px-4 transition-colors hover:text-primary-content focus:outline-none disabled:opacity-50 disabled:pointer-events-none group w-max gap-0 text-gray-800">
                        <x-heroicon-o-user class="h-6 w-6 text-gray-800" />
                        <svg :class="{ '-rotate-180': open }"
                            class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div x-cloak x-show="open" x-transition.origin.top.right x-on:mouseenter="open = true" @@click.away="open = false" class="navbar-dropdown-content text-gray-800 absolute right-0 top-full mt-2">
                        <div class="flex flex-col divide-y mt-1 min-w-[12rem] bg-white rounded-md shadow-md">
                            @foreach ($userNavigationMenu as $item)
                                @if(!$item->isDisplayed())
                                    @continue
                                @endif
                                @if ($item->children->isEmpty())
                                    <x-violence::link
                                        class="first:rounded-t-md last:rounded-b-md relative flex hover:bg-base-content/10 items-center py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full"
                                        :href="$item->getUrl()"
                                    >
                                        {{ $item->getLabel() }}
                                    </x-violence::link>
                                @else
                                    @foreach ($item->children as $childItem)
                                        <x-violence::link
                                            class="relative flex hover:bg-base-content/10 items-center py-2 px-4 pr-6 text-sm outline-none transition-colors gap-4 w-full"
                                            :href="$childItem->getUrl()"
                                        >
                                            {{ $childItem->getLabel() }}
                                        </x-violence::link>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="navbar-custom-violence rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-md px-4 lg:px-6 h-14 w-auto max-w-full flex items-center gap-x-4">
                    <!-- Desktop Navigation -->
                    <div class="flex items-center gap-x-6">
                        <x-violence::navigation-menu
                            :items="$primaryNavigationItems"
                            class="flex items-center gap-x-6 text-gray-800 hover:text-gray-600 transition-colors duration-200"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
