<?php

use App\Models\Auth\Role;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Gets users with roles', function () {
    beforeEach(function () {
        $this->userService = app(UserService::class);
    });

    it('should return null if the are no users', function () {
        $result = $this->userService->getUsersWithRoles();

        expect($result)->toBeNull();
        expect($result)->not()->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('should return paginated users with their roles', function () {
        User::factory()
            ->count(5)
            ->has(Role::factory())
            ->dummy()
            ->create();

        $result = $this->userService->getUsersWithRoles();

        expect($result)->not()->toBeNull();
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
        expect($result->count())->toBeGreaterThan(0);

        foreach ($result as $user) {
            expect($user)->toHaveKey('roles');
        }
    });
});
