<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

use PDO;


class Page extends Model
{

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                title,
                slug,
                content,
                created_at,
                updated_at
            FROM pages
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                title,
                slug,
                content,
                created_at,
                updated_at
            FROM pages
            WHERE slug = :slug
        ");

        $stmt->execute([
            'slug' => $slug
        ]);


        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }
}