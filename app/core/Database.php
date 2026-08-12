<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use InvalidArgumentException;

class Database
{
    private static ?PDO $connection = null;

    private const REQUIRED_KEYS = [
        'host',
        'dbname',
        'username',
        'password',
        'charset',
    ];

    public static function connect(array $config): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        foreach (self::REQUIRED_KEYS as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException(
                    "Missing database config: {$key}"
                );
            }

            if (
                $key !== 'password'
                && trim((string) $config[$key]) === ''
            ) {
                throw new InvalidArgumentException(
                    "Empty database config: {$key}"
                );
            }
        }

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['dbname'],
            $config['charset']
        );

        try {
            self::$connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException(
                'Database connection failed.',
                0,
                $e
            );
        }

        return self::$connection;
    }
}