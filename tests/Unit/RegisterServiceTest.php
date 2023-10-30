<?php

use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Support\Str;

it('should be able to create a User', function (array $requestData) {
    $authServiceMock = mock(RegisterService::class);
    $userMock = mock(User::class);

    $authServiceMock->shouldReceive('create')
        ->once()
        ->andReturn($userMock);

    expect($authServiceMock->create($requestData))->not->toBeEmpty();
})->with([[['name' => 'test1', 'email' => 'test1@example.com', 'password' => Str::random(10)]]]);
