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
                "Environment file not found: {$file}"
            );
        }

        $lines = file(
            $file,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        foreach ($lines as $line) {

            $line = trim($line);

            // Ignore blank lines and comments
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            // Ignore malformed lines
            if (!str_contains($line, '=')) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            // Remove surrounding quotes
            if (
                strlen($value) >= 2 &&
                (
                    ($value[0] === '"' && $value[-1] === '"') ||
                    ($value[0] === "'" && $value[-1] === "'")
                )
            ) {
                $value = substr($value, 1, -1);
            }

            putenv("{$name}={$value}");
        }
    }
}