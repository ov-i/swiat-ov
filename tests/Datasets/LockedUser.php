<?php

use App\Models\User;

dataset('locked-user', function () {
    return [fn () => User::factory()->locked()->create()];
});
