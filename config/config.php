<?php

declare(strict_types=1);

$appEnv = getenv('APP_ENV') ?: 'development';
$isProduction = $appEnv === 'production';

$required = static function (string $name): string {
    $value = getenv($name);

    if ($value === false || trim($value) === '') {
        throw new RuntimeException(
            "Required environment variable is missing: {$name}"
        );
    }

    return $value;
};

return [

    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    */

    'app' => [
        'name' => getenv('APP_NAME') ?: 'Stage Three MVC CMS',

        'url' => $isProduction
            ? $required('APP_URL')
            : (getenv('APP_URL') ?: 'http://stage-three-mvc-final.test'),

        'env' => $appEnv,

        'debug' => filter_var(
            getenv('APP_DEBUG') ?: ($isProduction ? 'false' : 'true'),
            FILTER_VALIDATE_BOOLEAN
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    */

    'database' => [
        'host' => $isProduction
            ? $required('DB_HOST')
            : (getenv('DB_HOST') ?: 'localhost'),

        'dbname' => $isProduction
            ? $required('DB_NAME')
            : (getenv('DB_NAME') ?: 'test4_db'),

        'username' => $isProduction
            ? $required('DB_USER')
            : (getenv('DB_USER') ?: 'root'),

        'password' => $isProduction
            ? $required('DB_PASSWORD')
            : (getenv('DB_PASSWORD') ?: ''),

        'charset' => 'utf8mb4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    */

    'mail' => [
        'from' => $isProduction
            ? $required('MAIL_FROM')
            : (getenv('MAIL_FROM')
                ?: 'noreply@stage-three-mvc.test'),
    ],

];