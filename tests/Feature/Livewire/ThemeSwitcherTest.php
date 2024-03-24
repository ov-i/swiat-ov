<?php

use App\Enums\AppThemeEnum;
use App\Livewire\ThemeSwitcher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('app theme can be set to Light from Dark', function (User $user, AppThemeEnum $theme) {
    actingAs($user);

    $component = Livewire::test(ThemeSwitcher::class)
        ->set('theme', $theme->value)
        ->call('toggleTheme');

    $component->assertOk();
    $component->assertDispatched('app.theme-change');

    if ($theme->value === AppThemeEnum::LIGHT) {
        expect($user->getTheme())->toBe(AppThemeEnum::DARK->value);
    }

    if ($theme->value === AppThemeEnum::DARK) {
        expect($user->getTheme())->toBe(AppThemeEnum::LIGHT->value);
    }
})->with('custom-user', [AppThemeEnum::LIGHT, AppThemeEnum::DARK]);

test('unlogged user can toggle his theme', function () {
    $component = Livewire::test(ThemeSwitcher::class)
        ->set('theme', 'dark')
        ->call('toggleTheme');

    $component->assertDispatched('app.theme-change');
});
