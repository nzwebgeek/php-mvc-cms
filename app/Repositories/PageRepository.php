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

    p.*,

    i.filename,
    i.filepath

    FROM pages p

    LEFT JOIN images i
        ON p.hero_media_id = i.id

    ORDER BY p.display_order ASC, p.id ASC
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
            SELECT
                p.*,
                i.filename AS image_filename,
                i.filepath AS image_path
                FROM pages p
                LEFT JOIN images i
                    ON p.hero_media_id = i.id
                WHERE p.slug = :slug
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

           hero_media_id,
            hero_title,
            hero_subtitle,
            hero_image_alt,

            main_heading,
            main_content,

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
            seo_description
        )

        VALUES
        (
            :title,
            :slug,
            
            :hero_media_id,
            :hero_title,
            :hero_subtitle,
            :hero_image_alt,

            :main_heading,
            :main_content,

            :column1_title,
            :column1_content,

            :column2_title,
            :column2_content,

            :column3_title,
            :column3_content,

            :column4_title,
            :column4_content,

            :column5_title,
            :column5_content,

            :status,
            :seo_title,
            :seo_description
        )
    ");


    return $stmt->execute($data);
}
    public function adminAll(): array{
    $stmt = $this->db->query("
     SELECT
        p.*,
        i.filename,
        i.filepath
    FROM pages p
    LEFT JOIN images i
        ON p.hero_media_id = i.id
    ORDER BY p.title
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array{
    $stmt = $this->db->prepare("
       SELECT
        p.*,
        i.filename AS image_filename,
        i.filepath AS image_path
    FROM pages p
    LEFT JOIN images i
        ON p.hero_media_id = i.id
    WHERE p.id = :id
    LIMIT 1
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $page = $stmt->fetch(PDO::FETCH_ASSOC);

    return $page ?: null;
    }

public function update(array $data): bool
{
    $stmt = $this->db->prepare("
        UPDATE pages
        SET
            title = :title,
            slug = :slug,

            hero_media_id = :hero_media_id,
            hero_title = :hero_title,
            hero_subtitle = :hero_subtitle,
            hero_image_alt = :hero_image_alt,

            main_heading = :main_heading,
            main_content = :main_content,

            column1_title = :column1_title,
            column1_content = :column1_content,

            column2_title = :column2_title,
            column2_content = :column2_content,

            column3_title = :column3_title,
            column3_content = :column3_content,

            column4_title = :column4_title,
            column4_content = :column4_content,

            column5_title = :column5_title,
            column5_content = :column5_content,

            status = :status,
            seo_title = :seo_title,
            seo_description = :seo_description

        WHERE id = :id
    ");


    return $stmt->execute([

        'id' => $data['id'],

        'title' => $data['title'],
        'slug' => $data['slug'],

        'hero_media_id' => $data['hero_media_id'],
        'hero_title' => $data['hero_title'],
        'hero_subtitle' => $data['hero_subtitle'],
        'hero_image_alt' => $data['hero_image_alt'],

        'main_heading' => $data['main_heading'],
        'main_content' => $data['main_content'],

        'column1_title' => $data['column1_title'],
        'column1_content' => $data['column1_content'],

        'column2_title' => $data['column2_title'],
        'column2_content' => $data['column2_content'],

        'column3_title' => $data['column3_title'],
        'column3_content' => $data['column3_content'],

        'column4_title' => $data['column4_title'],
        'column4_content' => $data['column4_content'],

        'column5_title' => $data['column5_title'],
        'column5_content' => $data['column5_content'],

        'status' => $data['status'],

        'seo_title' => $data['seo_title'],
        'seo_description' => $data['seo_description']

    ]);
}
    public function delete(int $id): bool{
    $stmt = $this->db->prepare("
        DELETE FROM pages
        WHERE id = :id
    ");

    return $stmt->execute([
        'id' => $id
    ]);
    }


}

