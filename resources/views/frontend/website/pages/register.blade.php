<x-literacy::layouts.main>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6">
            <x-literacy::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
        </div>

        <div class="register-card rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-6">
                <h1 class="text-xl font-semibold register-heading min-w-fit pr-4">{{ $this->getTitle() }}</h1>
                <div class="flex-grow h-px register-divider"></div>
            </div>

            @if (!$registerComplete)
                @if ($allowRegistration)
                    <form wire:submit='register' class="space-y-6">
                        @error('throttle')
                            <div class="register-error-box">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="grid gap-6 sm:grid-cols-6">
                            <!-- Personal Information -->
                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.given_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="register-input" wire:model="given_name" required />
                                @error('given_name')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.family_name') }}
                                </label>
                                <input type="text" class="register-input" wire:model="family_name" />
                                @error('family_name')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-6">
                                <label class="register-label">
                                    {{ __('general.public_name') }}
                                </label>
                                <input type="text" class="register-input" wire:model="public_name" />
                                @error('public_name')
                                <div class="register-error">{{ $message }}</div>
                                @enderror
                                <p class="register-helper-text">{{ __('general.public_name_helper') }}</p>
                            </div>

                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.affiliation') }}
                                </label>
                                <input type="text" class="register-input" wire:model="affiliation" />
                                @error('affiliation')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.country') }}
                                </label>
                                <select class="register-input" wire:model='country'>
                                    <option value="none" selected disabled>{{ __('general.select_country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->flag . ' ' . $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-6">
                                <label class="register-label">
                                    {{ __('general.phone') }}
                                </label>
                                <input type="tel" class="register-input" wire:model="phone" />
                                @error('phone')
                                <div class="register-error">{{ $message }}</div>
                                @enderror
                                <p class="register-helper-text">{{ __('general.phone_format_international') }}</p>
                            </div>

                            <!-- Account Information -->
                            <div class="sm:col-span-6">
                                <label class="register-label">
                                    {{ __('general.email') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" class="register-input" wire:model="email" required />
                                @error('email')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.password') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" class="register-input" wire:model="password" required />
                                @error('password')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="register-label">
                                    {{ __('general.password_confirmation') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" class="register-input" wire:model="password_confirmation" required />
                                @error('password_confirmation')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Conference Roles -->
                            @if (isset($scheduledConference) && $scheduledConference && !empty($roles))
                            <div class="sm:col-span-6">
                                <label class="register-label mb-3">
                                    {{ __('general.register_as') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    @foreach ($roles as $role)
                                        <label class="register-checkbox-label gap-2">
                                            <input type="checkbox" wire:model='selfAssignRoles' value="{{ $role }}" />
                                            <span>{{ $role }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selfAssignRoles')
                                    <div class="register-error">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif


                            <!-- Multiple Conferences -->
                            @if (isset($scheduledConference) && !$scheduledConference)
                                <div class="sm:col-span-6 space-y-6">
                                    <p class="register-label">{{ __('general.which_conference_interested_for') }}</p>
                                    @foreach ($conferences as $conference)
                                        <div class="space-y-3 p-4 register-section-bg">
                                            <h3 class="font-medium register-heading">{{ $conference->name }}</h3>
                                            <div class="space-y-2">
                                                @foreach ($roles as $role)
                                                    <label class="register-checkbox-label gap-2">
                                                        <input type="checkbox"
                                                            wire:model='selfAssignRoles.{{ $conference->id }}.{{ $role }}'
                                                            value="{{ $role }}" />
                                                        <span>{{ $role }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Privacy Statement -->
                            <div class="sm:col-span-6">
                                <label class="register-privacy-label gap-2">
                                    <input type="checkbox" class="mt-1" wire:model="privacy_statement_agree" required />
                                    <span>
                                        {!! __('general.privacy_statement_agree', ['url' => $privacyStatementUrl]) !!}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="register-button-primary" wire:loading.attr="disabled">
                                <span class="loading loading-spinner loading-xs" wire:loading></span>
                                {{ __('general.register') }}
                            </button>
                            <x-literacy::link class="register-button-secondary" :href="$loginUrl">
                                {{ __('general.login') }}
                            </x-literacy::link>
                        </div>
                    </form>
                @else
                    <p class="register-label">{{ __('general.registration_closed') }}</p>
                @endif
            @else
                <div class="space-y-4">
                    <p class="register-label">{{ __('general.registration_complete_message') }}</p>
                    <ul class="space-y-2 list-disc list-inside register-label">
                        <li>
                            <x-literacy::link class="register-link" href="{{ route('filament.scheduledConference.pages.profile') }}">
                                {{ __('general.edit_my_profile') }}
                            </x-literacy::link>
                        </li>
                        <li>
                            <x-literacy::link class="register-link" href="{{ $homeUrl }}">
                                {{ __('general.continue_browsing') }}
                            </x-literacy::link>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-literacy::layouts.main>
