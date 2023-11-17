<?php

use App\Models\User;

dataset('ticket_operators', function () {
    return [
        [
            fn () => User::factory()->create(),
            fn () => User::factory()->create(
                [
                    'name' => fake()->userName(),
                    'email' => fake()->safeEmail(),
                    'password' => bcrypt('password')
                ]
            ),
        ],
    ];
});
