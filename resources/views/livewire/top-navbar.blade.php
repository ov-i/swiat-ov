<nav class="top-navbar" aria-label="top-navbar fixed top-0">
    <section class="top-navbar__search flex flex-rop justify-between items-center">
        <article class="search-input flex items-center space-x-2">
            <span class="material-symbols-outlined text-2xl">
                manage_search
            </span>

            <x-input placeholder="{{ __('admin.dashboard.search') }}" class="w-full" />
        </article>
        <article class="profile-info flex flex-row space-x-2 items-center">
            <div class="icons-wrapper flex flex-row space-x-2 items-center">
                <div class="icon">
                    <span class="material-symbols-outlined text-2xl">
                        translate
                    </span>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined text-2xl">
                        light_mode
                    </span>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined text-2xl">
                        dashboard_customize
                    </span>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined text-2xl">
                        notifications
                    </span>
                </div>
            </div>

            <div class="profile-avatar">
                <x-user-profile />
            </div>
        </article>
    </section>
</nav>