<?php

declare(strict_types=1);

namespace App\Models;

class Comment
{
    public function __construct(
        public readonly int $id,
        public readonly int $postId,
        public readonly int $userId,
        public readonly string $comment,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly ?string $username = null
    ) {
    }
}