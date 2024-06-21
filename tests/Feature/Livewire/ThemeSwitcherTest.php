<?php

use App\Enums\AppTheme;
use App\Livewire\ThemeSwitcher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('app theme can be set to Light from Dark', function (User $user, AppTheme $theme) {
    actingAs($user);

    $component = Livewire::test(ThemeSwitcher::class)
        ->set('theme', $theme->value)
        ->call('toggleTheme');

    $component->assertOk();
    $component->assertDispatched('app.theme-change');

    if ($theme->value === AppTheme::Light) {
        expect($user->getTheme())->toBe(AppTheme::Dark->value);
    }

    if ($theme->value === AppTheme::Dark) {
        expect($user->getTheme())->toBe(AppTheme::Light->value);
    }
})->with('custom-user', [AppTheme::Light, AppTheme::Dark]);

test('unlogged user can toggle his theme', function () {
    $component = Livewire::test(ThemeSwitcher::class)
        ->set('theme', 'dark')
        ->call('toggleTheme');

    $component->assertDispatched('app.theme-change');
});
