<?php
use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\ThumbnailAllowedMimeTypesEnum;

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

    /*
    |--------------------------------------------------------------------------
    | Swiat ov max file size upload
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the max upload file size.
    | Currently, it's set to 10MB. Remember, that this option relates
    | to the application layer. If changed, nginx config also.
    |
    */
    'max_file_size' => 10_000_000,

    /*
    |--------------------------------------------------------------------------
    | Swiat ov file hashing algo
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default file hashing
    | algo, that is used for creating attachment and upload files as
    | a whole.
    |
    */
    'file_hash_algo' => 'sha256',

    /*
    |--------------------------------------------------------------------------
    | Swiat ov recaptcha secret key
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default secret key
    | for google's recaptcha antibot / spam / fraud system.
    |
    */
    'google_recaptcha_secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Swiat ov recaptcha site key
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default site key
    | for google's recaptcha antibot / spam / fraud system.
    |
    */
    'google_recaptcha_site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY', ''),
];
