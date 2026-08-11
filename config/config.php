<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    */

    'app' => [
        'name' => getenv('APP_NAME') ?: 'Stage Three MVC CMS',
        'url'  => getenv('APP_URL') ?: 'http://stage-three-mvc.test',
        'env'  => getenv('APP_ENV') ?: 'development',
        'debug' => filter_var(
            getenv('APP_DEBUG') ?: 'false',
            FILTER_VALIDATE_BOOLEAN
        ),
    ],
    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    */

    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'dbname' => getenv('DB_NAME') ?: 'test4_db',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    */

    'mail' => [
        'from' => getenv('MAIL_FROM')
            ?: 'noreply@stage-three-mvc.test',
    ],

];