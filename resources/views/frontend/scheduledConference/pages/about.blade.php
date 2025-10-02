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
                    {{ $this->getTitle() }}
                </h1>
            </div>

            @if ($about)
                <div class="prose max-w-none layout-section" style="--tw-prose-body:#000000">
                    {{ new Illuminate\Support\HtmlString($about) }}
                </div>
            @else
                <div class="about-no-info-card rounded-lg p-6 text-center" style="background-color: var(--color-card-bg); border: 1px solid var(--color-border);">
                    <p class="text-lg" style="color: var(--color-text-secondary);">
                        No information provided at this time.
                    </p>
                    <p class="mt-2 text-sm" style="color: var(--color-text-secondary); opacity: 0.7;">
                        Check back later for updates.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-literacy::layouts.main>