<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Village Information
    |--------------------------------------------------------------------------
    |
    | Konfigurasi informasi desa yang akan ditampilkan di website
    |
    */

    'village_name' => env('VILLAGE_NAME', 'Desa Kilwaru'),
    'village_description' => env('VILLAGE_DESCRIPTION', 'Membangun masa depan yang lebih baik melalui transparansi, inovasi, dan pelayanan yang berkualitas untuk seluruh warga desa.'),

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    |
    | Informasi kontak yang akan ditampilkan di website
    |
    */

    'contact' => [
        // 'address' => env('CONTACT_ADDRESS', 'Jl. Raya Desa No. 123<br>Kecamatan Sejahtera<br>Kabupaten Makmur<br>Provinsi Bahagia 12345'),
        // 'phone' => env('CONTACT_PHONE', 'Telepon: (0123) 456-7890<br>WhatsApp: +62 812-3456-7890'),
        // 'email' => env('CONTACT_EMAIL', 'Email: info@desasejahtera.id<br>Admin: admin@desasejahtera.id'),
        // 'coordinates' => env('CONTACT_COORDINATES', '-6.200000, 106.816666'),
        // 'admin_email' => env('ADMIN_EMAIL', 'admin@desasejahtera.id'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Office Hours
    |--------------------------------------------------------------------------
    |
    | Jam operasional kantor desa
    |
    */

    'office_hours' => [
        'weekdays' => env('OFFICE_HOURS_WEEKDAYS', '08:00 - 16:00'),
        'saturday' => env('OFFICE_HOURS_SATURDAY', '08:00 - 12:00'),
        'sunday' => env('OFFICE_HOURS_SUNDAY', 'Tutup'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    |
    | Link media sosial desa
    |
    */

    'social' => [
        // 'facebook' => env('SOCIAL_FACEBOOK', null),
        // 'instagram' => env('SOCIAL_INSTAGRAM', null),
        // 'twitter' => env('SOCIAL_TWITTER', null),
        // 'youtube' => env('SOCIAL_YOUTUBE', null),
        // 'whatsapp' => env('SOCIAL_WHATSAPP', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan SEO untuk website
    |
    */

    'seo' => [
        'meta_keywords' => env('SEO_KEYWORDS', 'desa kilwaru, pelayanan publik, administrasi desa, transparansi, inovasi'),
        'meta_author' => env('SEO_AUTHOR', 'Pemerintah Desa Kilwaru'),
        'google_analytics' => env('GOOGLE_ANALYTICS_ID', null),
        'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', null),
    ],

];
