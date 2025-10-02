<x-literacy::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"> 
        <!-- Breadcrumbs Section -->
        <div class="px-4 sm:px-6 lg:px-8 mb-6">
            <x-literacy::breadcrumbs 
                :breadcrumbs="$this->getBreadcrumbs()" 
                class="text-sm breadcrumbs-literacy" 
                style="color: var(--color-text-secondary);"
            />
        </div>

        <!-- Main Content Section -->
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Title Section -->
            <div class="flex flex-col sm:flex-row items-center  ml-2">
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-4 sm:mb-0 sm:mr-8 color-latest">
                    Announcements
                </h1>
            </div>

            <div class="overflow-y-auto space-y-4 layout-section">
                @forelse ($announcements as $announcement)
                    <div class="announcement-card rounded-lg p-4 shadow-sm" style="background-color: var(--color-card-bg); border: 1px solid var(--color-border);">
                        <x-scheduledConference::announcement-summary :announcement="$announcement" />
                    </div>
                @empty
                    <div class="announcement-no-info-card rounded-lg p-6 text-center" style="background-color: var(--color-card-bg); border: 1px solid var(--color-border);">
                        <p class="text-lg" style="color: var(--color-text-secondary);">
                            No Announcements created yet.
                        </p>
                        <p class="mt-2 text-sm" style="color: var(--color-text-secondary); opacity: 0.7;">
                            Check back later for updates.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-literacy::layouts.main>
