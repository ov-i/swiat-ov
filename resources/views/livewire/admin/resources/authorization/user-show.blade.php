<section class="user-hero bg-white font-secondary rounded-md w-full xl:w-10/12 v-large:w-7/12 shadow">
    <article class="user-info flex flex-row space-x-10 p-3 items-start justify-around w-full lg:text-center">
        <figure class="user-info__avatar">
            <img src="{{ $this->user->profile_photo_url }}" alt="" class="w-80 rounded-md">
        </figure>
        <div class="user-info__details w-full lg:w-1/2 xl:w-2/3 2xl:w-1/2 pr-3 mx-auto">
            <h3 class="text-dark xl:text-2xl text-xl mt-2">{{ __('User details') }}</h3>
            <div class="details-wrapper flex flex-col space-y-3 mt-6 mx-auto">
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Nickname') }}</h4>
                    <p class="font-semibold text-gray-500">{{ $this->user->name }}</p>
                </div>
                <div class="detail flex flex-col lg:flex-row lg:space-x-5 justify-between w-full">
                    <h4 class="text-gray-700 text-md">{{ __('Email') }}</h4>
                    <p class="font-semibold text-gray-500">{{ $this->user->email }}</p>
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
            </div>
        </div>
    </article>
</section>
