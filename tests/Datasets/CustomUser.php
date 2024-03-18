<?php

use App\Models\User;

dataset('custom-user', function () {
    return [fn () => User::factory()->dummy()->create()];
});
