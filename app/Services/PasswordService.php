<?php

declare(strict_types=1);

namespace App\Services;

class PasswordService
{
    private const MIN_LENGTH = 8;

    public function validate(string $password): ?string
    {
        if (strlen($password) < self::MIN_LENGTH) {
            return 'Password must be at least 8 characters.';
        }

        return null;
    }

    public function hash(string $password): string
    {
        return password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }

    public function verify(
        string $password,
        string $hash
    ): bool {
        return password_verify(
            $password,
            $hash
        );
    }
}