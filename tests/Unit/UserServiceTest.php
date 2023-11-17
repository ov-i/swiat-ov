<?php

use App\Enums\ItemsPerPageEnum;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

describe('Gets users with roles', function () {
    beforeEach(function () {
        $this->paginatorMock = mock(LengthAwarePaginator::class);
        $userRepository = mock(UserRepository::class);
        $user = mock(User::class);
        $this->userService = new UserService($userRepository);

        $userRepository->shouldReceive('getModel')
            ->once()
            ->andReturn($user);

        $user->shouldReceive('query')
            ->once()
            ->andReturnSelf();

        $user->shouldReceive('orderBy')
            ->once()
            ->andReturnSelf();

        $user->shouldReceive('with')
            ->once()
            ->with(['roles'])
            ->andReturnSelf();

        $user->shouldReceive('paginate')
            ->with(ItemsPerPageEnum::DEFAULT)
            ->andReturn($this->paginatorMock);
    });

    it('should return null if the are no users', function () {
        $this->paginatorMock->shouldReceive('isEmpty')->andReturn(true);

        $result = $this->userService->getUsersWithRoles();

        expect($result)->toBeNull();
        expect($result)->not()->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('should return paginated users with their roles', function () {
        $this->paginatorMock->shouldReceive('isEmpty')->andReturn(false);

        $result = $this->userService->getUsersWithRoles();

        expect($result)->not()->toBeNull();
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });
});
