<section class="user-hero bg-white font-secondary rounded-md w-full xl:w-10/12 v-large:w-7/12 shadow p-3">
    <!-- error alerts -->
        @if (session()->has('userUnlocked'))
            <div class="bg-green-500 text-white p-3 rounded-md shadow w-11/12 mx-auto text-center">
                {{ session()->get('userUnlocked') }}
            </div>
        @endif

        @if (session()->has('userLocked'))
            <div class="bg-green-500 text-white p-3 rounded-md shadow w-11/12 mx-auto text-center">
                {{ session()->get('userLocked') }}
            </div>
        @endif

    <!-- Info card -->
    <article class="info-card flex flex-row space-x-10 p-3 items-start justify-around w-full lg:text-center">
        <figure class="info-card__avatar relative">
            <img src="{{ $this->user->profile_photo_url }}" alt="" class=" w-80 rounded-md hover:-z-10">

            <div class="delete-image w-full">
                <button class="w-full border border-gray-500 rounded p-2 mt-3 hover:bg-gray-500 hover:text-white dark:bg-gray-500 dark:hover:bg-gray-300 dark:hover:text-white transition-colors duration-75 active:bg-gray-700 active:text-white">{{ __('Delete image') }} </button>
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

    <article class="user-relations">
        <!-- @TODO: add section about locks history -->
    </article>
</section>
