<aside class="bg-asideMenu h-screen flex flex-col fixed top-0 left-0">
    <!-- Top Icon -->
    <div class="p-4">
        <img src="{{ Vite::asset('resources/images/swiat-ov.svg') }}" alt="Icon" class="w-48">
    </div>

    <!-- Navigation Items -->
    <div class="flex flex-col items-center space-y-3">
        <div class="flex flex-row items-center">
            <span>Authorization</span>
        </div>
        <div class="flex flex-col items-center">
            <span class="material-icons">people</span>
            <span>Users</span>
        </div>
        <div class="flex flex-col items-center">
            <span class="material-icons">admin_panel_settings</span>
            <span>Roles</span>
        </div>
    </div>
</aside>
