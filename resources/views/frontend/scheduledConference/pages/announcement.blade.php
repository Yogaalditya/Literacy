<x-violence::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <x-violence::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
        </div>
      
            <div class="p-3 space-y-4">
                <header class="space-y-2">
                    <h1 class="text-3xl font-extrabold text-gray-800 ">{{ $announcement->title }}</h1>
                </header>
                
                @if ($announcement->hasMedia('featured_image'))
                    <div class="relative overflow-hidden rounded-lg w-full">
                        <img class="w-full h-auto object-cover "
                            src="{{ $announcement->getFirstMedia('featured_image')->getAvailableUrl(['thumb']) }}"
                            alt="{{ $announcement->title }}">
                    </div>
                @endif

                <div class="prose dark:prose-invert max-w-none hyphens-auto break-words">
                    {{ new Illuminate\Support\HtmlString($this->announcement->getMeta('content')) }}
                </div>
            </div>
       
    </div>
</x-violence::layouts.main>