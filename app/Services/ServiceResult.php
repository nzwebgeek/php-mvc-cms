<?php
declare(strict_types=1);
namespace App\Services;

class ServiceResult
{
    // Dealing with messages and settings
    public function __construct(
        public readonly bool $success,
        public readonly string $type,
        public readonly string $message,
        public readonly array $data = []
    ) {
    }

    public static function success(
        string $message = '',
        array $data = []
    ): self {
        return new self(
            true,
            'success',
            $message,
            $data
        );
    }

    public static function error(string $message): self
    {
        return new self(
            false,
            'error',
            $message
        );
    }

    public static function warning(string $message): self
    {
        return new self(
            false,
            'warning',
            $message
        );
    }
}