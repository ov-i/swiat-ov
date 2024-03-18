<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('user accounts can be deleted', function () {
    actingAs($user = User::factory()->dummy()->create());

    $component = Livewire::test(DeleteUserForm::class)
        ->set('password', 'password')
        ->call('deleteUser');

    $component->assertOk();
    $component->assertValid();

    expect($user->fresh()->trashed())->toBeTrue();
})->skip(function () {
    return !Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(DeleteUserForm::class)
        ->set('password', 'wrong-password')
        ->call('deleteUser')
        ->assertHasErrors(['password']);

    expect($user->fresh()->trashed())->not()->toBeTrue();
})->skip(function () {
    return !Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
