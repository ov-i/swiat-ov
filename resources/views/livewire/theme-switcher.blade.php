<section title="Theme switcher">
  <button type="button" wire:click.throttle.1000ms="toggleTheme" class="flex items-start">
    @if ($this->theme() === \App\Enums\AppTheme::Light)
      <x-icon.moon class="dark:text-white" />
    @else
      <x-icon.light-bulb class="dark:text-yellow-600" />
    @endif
  </button>
</section>
