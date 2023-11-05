<?php

use App\Enums\Auth\RoleNamesEnum;
use App\Models\Auth\Role;
use App\Services\Users\UserService;
use App\Strategies\Auth\RoleHasPermissions\AdminHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\ModeratorHasPermissions;
use App\Strategies\Auth\RoleHasPermissions\UserHasPermissionsStrategy;
use Illuminate\Database\Eloquent\Collection;

test('should assign to a specific role permissions', function (string $role) {
    $userService = mock(UserService::class);
    $roleModelMock = mock(Role::class);
    $userHasPermissionsStrategy = mock(UserHasPermissionsStrategy::class);
    $adminHasPermissionsStrategy = mock(AdminHasPermissionsStrategy::class);
    $moderatorHasPermissionsStrategy = mock(ModeratorHasPermissions::class);
    $collectionMock = mock(Collection::class);

    $collectionMock->shouldReceive('count')
        ->atLeast()
        ->once();

    $userService->shouldReceive('giveRolePermissions')
        ->atLeast()
        ->once()
        ->andReturn($userService);

    $userService->shouldReceive('getRolePermissions')
        ->once();

    switch ($role) {
        case RoleNamesEnum::admin()->value:
            $userService->giveRolePermissions($roleModelMock, $adminHasPermissionsStrategy);
            break;
        case RoleNamesEnum::user()->value:
            $userService->giveRolePermissions($roleModelMock, $userHasPermissionsStrategy);
            break;
        case RoleNamesEnum::moderator()->value:
            $userService->giveRolePermissions($roleModelMock, $moderatorHasPermissionsStrategy);
            break;
    }

    $collectionMock->shouldHaveReceived('count');
    expect($userService->getRolePermissions($roleModelMock))->not->toBeEmpty();

})->with([
    RoleNamesEnum::admin()->value,
    RoleNamesEnum::user()->value,
    RoleNamesEnum::vipMember()->value
]);
