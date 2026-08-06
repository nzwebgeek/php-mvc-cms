<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;
/*repository's job is to give the application useful data.*/
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

        hero_image,
        hero_image_alt,

        column1_title,
        column1_content,
        column2_title,
        column2_content,
        column3_title,
        column3_content,
        column4_title,
        column4_content,
        column5_title,
        column5_content,

        status,
        seo_title,
        seo_description,
        display_order

    FROM pages

    ORDER BY display_order ASC, id ASC
");

    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($pages as $page) {
        $result[$page['slug']] = $page;
    }

    return $result;
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

    /*
    |--------------------------------------------------------------------------
    | Administration
    |--------------------------------------------------------------------------
    */
    public function countPages(): int
    {
    $stmt = $this->db->query("
        SELECT COUNT(*)
        FROM pages
    ");

    return (int)$stmt->fetchColumn();
    }

    public function create(array $data): bool
{
    $stmt = $this->db->prepare("
        INSERT INTO pages
        (
            title,
            slug,
            hero_title,
            hero_subtitle,
            main_heading,
            main_content,
            status,
            seo_title,
            seo_description
        )
        VALUES
        (
            :title,
            :slug,
            :hero_title,
            :hero_subtitle,
            :main_heading,
            :main_content,
            :status,
            :seo_title,
            :seo_description
        )
    ");


    return $stmt->execute([

        'title' => $data['title'],

        'slug' => $data['slug'],

        'hero_title' => $data['hero_title'],

        'hero_subtitle' => $data['hero_subtitle'],

        'main_heading' => $data['main_heading'],

        'main_content' => $data['main_content'],

        'status' => $data['status'],

        'seo_title' => $data['seo_title'],

        'seo_description' => $data['seo_description']

    ]);
}

    public function adminAll(): array{
    $stmt = $this->db->query("
        SELECT
            id,
            title,
            slug,
            status,
            seo_title,
            display_order

        FROM pages

        ORDER BY display_order ASC, id ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}