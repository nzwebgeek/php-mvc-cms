<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class PageRepository extends Repository
{
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                title,
                slug,
                hero_title,
                hero_subtitle,
                main_heading,
                main_content,
                status,
                hero_image,
                hero_image_alt,
                seo_title,
                seo_description,
                display_order
            FROM pages
            ORDER BY display_order ASC, id ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM pages
            WHERE slug = :slug
            LIMIT 1
        ");

        $stmt->execute([
            'slug' => $slug
        ]);

        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }
}