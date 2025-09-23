@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
    $homeUrl = app()->getCurrentConference()?->getHomeUrl() ?? url('/');
@endphp

@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="sticky-navbar top-0 z-50 w-full text-white transition-all duration-300">
        <div class="navbar-violence container mx-auto px-4 lg:px-8 py-3">
            <div class="flex justify-center">
                <div class="navbar-custom-violence rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-md px-4 lg:px-6 h-14 w-auto max-w-full flex items-center gap-x-4">
                    <!-- Mobile Menu & Logo -->
                    <div class="flex items-center gap-x-4">
                        <div class="lg:hidden">
                            <x-violence::navigation-menu-mobile />
                        </div>
                        <x-violence::logo
                            :headerLogo="$headerLogo"
                            :homeUrl="$homeUrl"
                            :headerLogoAltText="app()->getCurrentConference()?->name ?? config('app.name')"
                            class="font-bold h-8 w-auto"
                        />
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center gap-x-6">
                        <x-violence::navigation-menu
                            :items="$primaryNavigationItems"
                            class="flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200"
                        />
                        <x-violence::navigation-menu
                            :items="$userNavigationMenu"
                            class="flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
