<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'invalid_role_assignment' => "Role 'Vip Member' cannot be used for itself.",
    'blocked' => 'The user ":user" has been blocked until: :duration.',
    'block_header' => 'Your account have been locked.',
    'block_reason' => 'Dear user, you\'ve been locked for reason of: :reason.',
    'invalid_block_history_record' => 'The user\'s block history cannot be added without ban duration',
    'user_block_history_not_found' => 'Could not find a history record for a given user :user with ban duration of :duration'
];
