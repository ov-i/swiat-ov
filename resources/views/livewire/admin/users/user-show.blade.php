<section>
    <x-back-button :to="route('admin.users')">
        {{ __('Back to users list') }}
    </x-back-button>

    <section class="show-wrapper">
        <!-- error alerts -->
        @if (session()->has('userUnlocked'))
            <div class="bg-green-500 flash-alert">
                {{ session()->get('userUnlocked') }}
            </div>
        @endif
    
        @if (session()->has('userLocked'))
            <div class="bg-green-500 flash-alert">
                {{ session()->get('userLocked') }}
            </div>
        @endif
    
        <!-- Info card -->
        <article class="show-card">
            <figure class="info-card__avatar relative">
                <img src="{{ $this->user->profile_photo_url }}" alt="" class="w-80 v-large:w-96 rounded-md hover:-z-10">
    
                <div class="delete-image w-full">
                    <x-button 
                        component="button-zinc-outlined" 
                        class="w-full block my-2"
                        wire:click="deleteImage">
                        {{ __('Delete image') }}
                    </x-button>
                </div>
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
    
                @livewire('admin.users.user-lock', ['user' => $this->user], key($this->user->id))
            </div>
        </article> <!-- end info card -->
    
        <article class="relations my-4">
            <!-- @TODO: add section about locks history -->
            <section class="show-card">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <label for="checkbox-all-search" class="sr-only">
                                    checkbox
                                </label>
                                <x-checkbox id="checkbox-all-search" />
                            </div>
                            </th>
    
                            <th scope="col" class="px-6 py-3">
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Ip') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Locked') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Action') }}
                            </th>
                        </tr>
                </thead>
                <tbody>
    
                </tbody>
            </section>
        </article>
    </section>
</section>
