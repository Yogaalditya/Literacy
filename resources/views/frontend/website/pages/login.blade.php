<x-literacy::layouts.main class="min-h-screen">
    <div class="max-w-md mx-auto px-4 py-8">
        <div class="mb-6">
            <x-literacy::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
        </div>
        
        <div class="login-card rounded-2xl shadow-lg backdrop-blur-sm p-6">
            <div class="flex items-center mb-6">
                <h1 class="text-xl font-semibold min-w-fit pr-4 login-heading">{{ __('general.login') }}</h1>
                <div class="flex-grow h-px login-divider"></div>
            </div>

            <form wire:submit='login' class="space-y-4">
                @error('throttle')
                    <div class="login-error-box">
                        {{ $message }}
                    </div>
                @enderror

                <div>
                    <label class="login-label">
                        {{ __('general.email') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        class="login-input" 
                        wire:model="email" 
                        required
                    />
                    @error('email')
                        <div class="login-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="login-label">
                        {{ __('general.password') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        class="login-input" 
                        wire:model="password" 
                        required 
                    />
                    @error('password')
                        <div class="login-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="login-checkbox-label">
                        <input 
                            type="checkbox" 
                            wire:model='remember' 
                            class="mr-2"
                        />
                        <span>{{ __('general.remember_me') }}</span>
                    </label>
                    <x-literacy::link :href="$resetPasswordUrl" class="login-link">
                        {{ __('general.forgot_password_question') }}
                    </x-literacy::link>
                </div>

                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit" 
                        class="login-button-primary" 
                        wire:loading.attr="disabled"
                    >
                        <span class="loading loading-spinner loading-xs" wire:loading></span>
                        {{ __('general.login') }}
                    </button>
                    @if($registerUrl)
                        <x-literacy::link 
                            class="login-button-secondary" 
                            :href="$registerUrl"
                        >
                            {{ __('general.register') }}
                        </x-literacy::link>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-literacy::layouts.main>