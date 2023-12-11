<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Swiat ov admin app name
    |--------------------------------------------------------------------------
    |
    | The following configuration option contains swiat ov admin app name.
    | Here it's possible to change the admin panel name if needed.
    |
    */
    'name' => env('SWIAT_OV_ADMIN_APP_NAME', env('APP_NAME')),

    /*
    |--------------------------------------------------------------------------
    | Nova Domain Name
    |--------------------------------------------------------------------------
    |
    | This value is the "domain name" associated with your application. This
    | can be used to prevent swiatov admin's panel internal routes from being registered
    */
    'domain' => env('SWIAT_OV_ADMIN_DOMAIN', null),


    /*
    |--------------------------------------------------------------------------
    | Swiat ov Storage Disk
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default disk that
    | will be used to store files using the Image, File, and other file
    | related field types. You're welcome to use any configured disk.
    |
    */
    'storage_disk' => env('SWIAT_OV_ADMIN_STORAGE_DISK', 'public'),
];
