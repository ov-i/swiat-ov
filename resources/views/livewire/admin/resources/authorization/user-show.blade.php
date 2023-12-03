<section class="user-hero bg-white font-secondary rounded-md w-full xl:w-10/12 v-large:w-7/12 shadow">
    <!-- Info card -->
    <article class="info-card flex flex-row space-x-10 p-3 items-start justify-around w-full lg:text-center">
        <figure class="info-card__avatar">
            <img src="{{ $this->user->profile_photo_url }}" alt="" class="w-80 rounded-md">
        </figure>
        <div class="info-card__details w-full lg:w-1/2 xl:w-2/3 2xl:w-1/2 pr-3 mx-auto">
            <h3 class="text-dark xl:text-2xl text-xl mt-2">{{ __('User details') }}</h3>
            <div class="details-wrapper flex flex-col space-y-3 mt-6 mx-auto">
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Nickname') }}</h4>
                    <p class="font-semibold text-gray-500">{{ $this->user->name }}</p>
                </div>
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Email') }}</h4>
                    <a href="mailto: {{ $this->user->email }}" class="text-blue-400 hover:text-blue-500 transition duration-75">
                        <p class="font-semibold text-gray-500">
                            {{ $this->user->email }}
                        </a>
                    </p>
                </div>
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Registered at') }}</h4>
                    <p class="font-semibold text-gray-500">{{ $this->user->created_at }}</p>
                </div>
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Is Verified') }}</h4>

                    @if ($this->user->hasVerifiedEmail())
                        <p class="font-semibold">
                            <span class="material-symbols-outlined text-green-500">
                                check_circle
                            </span>
                        </p>
                    @else
                        <p class="font-semibold">
                            <span class="material-symbols-outlined text-red-500">
                                cancel
                            </span>
                        </p>
                    @endif
                    
                </div>
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Account status') }}</h4>

                    @if ($this->user->isBlocked())
                        <p class="font-semibold">
                            <span class="material-symbols-outlined text-red-500">
                                cancel
                            </span>
                        </p>
                    @else
                        <p class="font-semibold">
                            <span class="material-symbols-outlined text-green-500">
                                check_circle
                            </span>
                        </p>
                    @endif
                </div>

                @if ($this->user->isBlocked())
                    <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                        <h4 class="text-gray-700 text-md">{{ __('Lock duration') }}</h4>

                        <p class="font-semibold">{{ $this->user->ban_duration }}</p>
                    </div>        
                @endif
            </div>

            <div class="info-card__actions flex flex-row space-x-2 items-center py-6 text-sm">
                <div class="action-button">
                    <button class="bg-blue-600 text-white p-3 rounded-md mx-0">
                        <x-iconed-link
                            link="{{ route('admin.users.edit', ['user' => $this->user]) }}"
                            icon='person'
                            content="{{ __('Edit user') }}" 
                            icon_size='md' />
                    </button>
                </div>
                <div class="action-button">
                    @if (false === $this->user->isAdmin() && false === $this->user->isBlocked())
                        <button class="bg-red-600 text-white p-3 text-md rounded-md mx-0 flex flex-row items-center" wire:click="openLockingModal">
                            <span class="material-symbols-outlined mr-2">
                                lock
                            </span>

                            {{ __('Lock user') }}
                        </button>
                    @endif

                    @if ($this->userLockModalOpened)
                        <x-confirmation-modal wire:keydown.enter="closeLockingModal">
                            <x-slot name="title">{{ __("User locking") }}</x-slot>
                            <x-slot name="content">
                                <h3>{{ __("You're trying to lock a user with name [{$this->user->name}]") }}</h3>
                                <p class="pb-4 border-b">{{ __('Please provide informations about reason and duration.') }}</p>
                                
                                <div class="informations mt-4 w-full">
                                    <label for="lock-duration" sr-only>Lock duration</label>
                                    <select name="lock_duration" id="lock-duration" class="w-full mt-2 rounded-md form-control" wire:model.change="lockDuration">
                                        @foreach (\App\Enums\Auth\BanDurationEnum::cases() as $lockDuration)
                                            <option value="{{ $lockDuration->value }}">
                                                {{ $lockDuration->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p>@error('lockDuration') {{ $message }} @enderror</p>
                                </div>
                                <div class="informations mt-4 w-full">
                                    <label for="reason" sr-only>Reason</label>
                                    <div class="reason-container">
                                        <textarea 
                                            name="reason" 
                                            id="reason" 
                                            wire:model.live="reason"
                                            class="w-full text-dark form-textarea border-gray-500 rounded-md" 
                                            placeholder="{{ __('Please provide reasonable context to this block') }}"></textarea>

                                        <p>@error('lockDuration') {{ $message }} @enderror</p>
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="footer" class="flex flex-row space-x-2">
                                <button class="bg-red-600 text-white p-3 text-md rounded-md mx-0 flex flex-row items-center" wire:click="lockUser">
                                    <span class="material-symbols-outlined mr-2">
                                        lock
                                    </span>

                                    {{ __('Lock user') }}
                                </button>
                                <button wire:click="closeLockingModal">{{ __('Close') }}</button>
                            </x-slot>
                        </x-confirmation-modal>
                    @endif
                </div>
            </div>
        </div>
    </article> <!-- end info card -->

    <article class="user-relations">

    </article>
</section>
