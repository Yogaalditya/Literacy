<x-literacy::layouts.main class="min-h-screen email-verification-container py-12 px-4">
    <div class="max-w-xl mx-auto">
        <div class="mb-6">
            <x-literacy::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" class="text-sm email-verification-breadcrumb transition-colors" />
        </div>

        <div class="email-verification-card rounded-xl shadow-lg p-8 border">
            <div class="flex items-center mb-5 space-x-4">
                <h1 class="text-2xl font-semibold email-verification-heading flex items-center gap-2">
                    <x-heroicon-s-envelope class="h-6 w-6 icon-banner" />
                    Verify Your Email
                </h1>
                <hr class="flex-grow h-px email-verification-divider border-0">
            </div>

            <div class="space-y-4 email-verification-text-secondary">
                @if (session('success'))
                    <div class="flex items-center email-verification-alert-success border p-4 rounded-lg">
                        <x-heroicon-s-check-circle class="h-5 w-5 mr-2 email-verification-alert-success-icon" />
                        <span>Email verification link sent successfully.</span>
                    </div>
                @endif

                @error('email')
                    <div class="flex items-center email-verification-alert-error border p-4 rounded-lg">
                        <x-heroicon-o-exclamation-circle class="h-5 w-5 mr-2 email-verification-alert-error-icon" />
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <p class="email-verification-text">
                    Almost there! We've sent a verification email to <b>{{ Str::maskEmail(auth()->user()->email) }}</b>.
                </p>
                <p>You need to verify your email address to log into Leconfe.</p>

                <div class="pt-4">
                    <button wire:click='sendEmailVerificationLink' class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-2.5 button-banner submit text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                        wire:loading.attr="disabled">
                        <span wire:loading class="animate-spin mr-2">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                        Resend Email
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-literacy::layouts.main>
