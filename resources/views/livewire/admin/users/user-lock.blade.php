<div class="info-card__actions flex flex-row space-x-2 items-center py-6 text-sm">
    <div class="action-button">
            <x-button>
                <x-iconed-link
                    link="{{ route('admin.users.edit', ['user' => $user]) }}"
                    icon='person'
                    icon_size='md'>
                    {{ __('Edit user') }}
                </x-iconed-link>
            </x-button>
        </div>
    <div class="action-button">
        @if (!$user->isAdmin() && !$user->isBlocked())
            <x-button 
                wire:click.throttle="lockUserConfirmation = true" 
                component="button-danger">
                <x-material-icon>
                    lock
                </x-material-icon>

                {{ __('Lock user') }}
            </x-button>
        @endif

        @if ($user->isBlocked())
            <x-button
                type="button"
                wire:click="unlockUser"
                component="button-info"
                wire:loading.remove
                wire:confirm="{{ __('Are you sure about unlocking this user?') }}">
                <x-material-icon>
                    lock_open
                </x-material-icon>

                {{ __('Unlock user') }}
            </x-button>

            <x-material-icon class="animate-spin" wire:loading wire:loading.target="unlockUser">
                sync
            </x-material-icon>
        @endif
        
        <x-confirmation-modal wire:model="lockUserConfirmation">
            <x-slot name="title">{{ __("User locking") }}</x-slot>
            <x-slot name="content">
                <h3>
                    {{ __("You're trying to lock a user with name") }}
                    <strong class="capitalize">
                        '{{ $user->name }}'
                    </strong>
                </h3>
                <p class="pb-4 border-b">{{ __('Please provide informations about reason and duration.') }}</p>
                <div class="informations mt-4 w-full">
                    <x-label for="lock-duration" :value="__('Lock duration')" required />
                    <x-select name="lock_duration" id="lock-duration" class="w-full mt-2 rounded-md form-control" wire:model.change="lockForm.lockDuration">
                        <option selected readonly>{{ __('Select duration') }}</option>
                        @foreach ($lockDurations as $lockDuration)
                            <option value="{{ $lockDuration->value }}">
                                {{ $lockDuration->label }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error for="lockForm.lockDuration" />
                </div>
                <div class="informations mt-4 w-full">
                    <x-label for="reason" :value="__('Reason')" required />
                    <div class="reason-container">
                        <x-select name="reason" id="reason" wire:model.live="lockForm.reason" inputClasses="w-full">
                            @foreach (\App\Enums\Auth\LockReasonEnum::cases() as $reason)
                                <option value="{{ $reason->value }}">{{ $reason->label }}</option>
                            @endforeach
                        </x-select>

                        <x-input-error for="lockForm.reason" />
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="lockUser" component="button-danger" class="mr-3">
                    <x-material-icon>
                        lock
                    </x-material-icon>

                    {{ __('Lock user') }}
                </x-button>
                <x-button type="button" component="button-danger-outlined" wire:click="lockUserConfirmation = false">
                    <x-material-icon>
                        close
                    </x-material-icon>

                    {{ __('Close') }}
                </x-button>
            </x-slot>
        </x-confirmation-modal>
    </div>
</div>