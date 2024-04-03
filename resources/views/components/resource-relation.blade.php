<section class="relation mt-5 pt-3">
    <x-flex-content class="mb-3" actionClasses="self-end">
        <x-slot name="header">
            <section>
                <h2 class="font-primary text-xl text-zinc-500 pb-2">{{ __(ucfirst($title)) }}</h2>

                <div class="relative">
                    <x-material-icon class="absolute left-2 top-1/2 -translate-y-1/2">
                        manage_search
                    </x-material-icon>
                    <x-input id="search-input" placeholder="Search for {{ $title }}" class="rounded-full pl-9" /> 
                </div>
            </section>
        </x-slot>
        <x-slot name="actions">
            {{ $actions ?? '' }}
        </x-slot>
    </x-flex-content>

    <x-admin-card title="">
        <x-resource-table class="text-left" >
          <x-slot name="tableHead">
            {{ $tableHead }}
          </x-slot>

          {{ $slot }}
        </x-resource-table>
    </x-admin-card>
</section>