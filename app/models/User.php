<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $email,
        public readonly ?string $role = null,
        public readonly bool $emailVerified = false
    ) {
    }
}