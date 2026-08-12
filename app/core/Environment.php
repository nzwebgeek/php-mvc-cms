<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class Environment
{
    public static function load(string $file): void
    {
        if (!is_readable($file)) {
            throw new RuntimeException(
                'Environment configuration is unavailable.'
            );
        }

        $lines = file(
            $file,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        if ($lines === false) {
            throw new RuntimeException(
                'Unable to read environment configuration.'
            );
        }

        foreach ($lines as $lineNumber => $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid environment configuration on line %d.',
                        $lineNumber + 1
                    )
                );
            }

            [$name, $value] = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            if (
                $name === ''
                || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name)
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid environment variable name on line %d.',
                        $lineNumber + 1
                    )
                );
            }

            if (
                strlen($value) >= 2
                && (
                    ($value[0] === '"' && $value[-1] === '"')
                    || ($value[0] === "'" && $value[-1] === "'")
                )
            ) {
                $value = substr($value, 1, -1);
            }

            putenv("{$name}={$value}");
        }
    }
}