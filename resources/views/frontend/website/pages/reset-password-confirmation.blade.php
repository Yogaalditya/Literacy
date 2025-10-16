<x-literacy::layouts.main class="min-h-screen">
    <div class="max-w-lg mx-auto py-8">
        <div class="mb-6">
            <x-literacy::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
        </div>
        
        <div class="reset-password-card rounded-2xl shadow-lg backdrop-blur-sm p-6">
            <div class="flex items-center mb-6">
                <h1 class="text-xl font-semibold min-w-fit pr-4 reset-password-heading">{{ __('general.reset_password') }}</h1>
                <div class="flex-grow h-px reset-password-divider"></div>
            </div>

            @if(!$success)
                <form wire:submit='submit' class="space-y-4">
                    <p class="reset-password-text">
                        {{ __('general.enter_password_to_update') }}
                    </p>

                    <div>
                        <label class="reset-password-label">
                            {{ __('general.new_password') }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password"
                            name="password"
                            class="reset-password-input rounded-xl"
                            wire:model="password"
                            required
                        />
                        @error('password')
                            <div class="reset-password-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="reset-password-label">
                            {{ __('general.confirm_password') }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password"
                            name="password_confirmation"
                            class="reset-password-input rounded-xl"
                            wire:model="password_confirmation"
                            required
                        />
                        @error('password_confirmation')
                            <div class="reset-password-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button 
                            type="submit"
                            class="reset-password-button-primary rounded-xl text-sm font-medium"
                            wire:loading.attr="disabled"
                        >
                            <span class="loading loading-spinner loading-xs" wire:loading></span>
                            {{ __('general.submit') }}
                        </button>
                    </div>
                </form>
            @else
                <div class="space-y-4">
                    <p class="reset-password-success-text">
                        {{ __('general.reset_password_update_success') }}
                    </p>
                    <x-literacy::link 
                        class="reset-password-button-secondary rounded-xl text-sm font-medium inline-flex items-center"
                        :href="app()->getLoginUrl()"
                    >
                        {{ __('general.login') }}
                    </x-literacy::link>
                </div>
            @endif
        </div>
    </div>
</x-literacy::layouts.main>