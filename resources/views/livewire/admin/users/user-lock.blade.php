<div class="info-card__actions flex flex-row space-x-2 items-center py-6 text-sm">
    <div class="action-button">
            <button class="bg-blue-600 text-white p-3 rounded-md mx-0">
                <x-iconed-link
                    link="{{ route('admin.users.edit', ['user' => $user]) }}"
                    icon='person'
                    content="{{ __('Edit user') }}" 
                    icon_size='md' />
            </button>
        </div>
        <div class="action-button">
            @if (false === $user->isAdmin() && false === $user->isBlocked())
                <button class="bg-red-600 text-white p-3 text-md rounded-md mx-0 flex flex-row items-center" wire:click="openLockingModal">
                    <span class="material-symbols-outlined mr-2">
                        lock
                    </span>

                    {{ __('Lock user') }}
                </button>
            @endif

            @if (true === $user->isBlocked())
                <button 
                    class="bg-red-600 text-white p-3 text-md rounded-md mx-0 flex flex-row items-center" wire:click="unlockUser"
                    wire:confirm="{{ __('Are you sure about unlocking this user?') }}">

                    <span class="material-symbols-outlined mr-2">
                        lock_open
                    </span>

                    {{ __('Unlock user') }}
                </button>
            @endif

            @if ($userLockModalOpened)
                <x-confirmation-modal wire:keydown.enter="closeLockingModal">
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
                            <label for="lock-duration" sr-only>{{ __('Lock duration') }}</label>
                            <select name="lock_duration" id="lock-duration" class="w-full mt-2 rounded-md form-control" wire:model.change="lockForm.lockDuration">
                                <option selected readonly>{{ __('Select duration') }}</option>
                                @foreach ($lockDurations as $lockDuration)
                                    <option value="{{ $lockDuration->value }}">
                                        {{ $lockDuration->label }}
                                    </option>
                                @endforeach
                            </select>
                            <p>@error('lockForm.lockDuration') {{ $message }} @enderror</p>
                        </div>
                        <div class="informations mt-4 w-full">
                            <label for="reason" sr-only>Reason</label>
                            <div class="reason-container">
                                <textarea 
                                    name="reason" 
                                    id="reason" 
                                    wire:model.live="lockForm.reason"
                                    class="w-full text-dark form-textarea border-gray-500 rounded-md" 
                                    placeholder="{{ __('Please provide reasonable context to this block') }}"></textarea>

                                <p>@error('lockForm.reason') {{ $message }} @enderror</p>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <button class="bg-red-600 text-white p-3 text-md rounded-md mx-2 last:mx-0 flex flex-row items-center" wire:click="lockUser">
                            <span class="material-symbols-outlined mr-2">
                                lock
                            </span>

                            {{ __('Lock user') }}
                        </button>
                        <button class="bg-red-600 text-white p-3 text-md rounded-md mx-2 last:mx-0 flex flex-row items-center" wire:click="closeLockingModal">
                            <span class="material-symbols-outlined mr-2">
                                close
                            </span>

                            {{ __('Close') }}
                        </button>
                    </x-slot>
                </x-confirmation-modal>
            @endif
        </div>
    </div>
</div>