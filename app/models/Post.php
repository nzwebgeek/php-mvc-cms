<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Post extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                title
            FROM posts
            ORDER BY id DESC
        ");

        return $stmt->fetchAll();
    }


    public function getPublishedPosts(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM posts
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll();
    }


    public function getBlogImages(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM images
        ");

        return $stmt->fetchAll();
    }
}