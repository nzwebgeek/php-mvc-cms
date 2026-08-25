<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
/*repository's job is to talk to the database*/

class PostRepository extends Repository
{

public function all(): array
{
    $stmt = $this->db->query("
        SELECT
            posts.*,
            users.username,
            images.filepath AS image_path

        FROM posts

        JOIN users
        ON posts.user_id = users.id

        LEFT JOIN images
        ON posts.featured_media_id = images.id

        WHERE posts.status = 'published'

        ORDER BY created_at DESC
    ");

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function findById(int $id): ?array
{
    $stmt = $this->db->prepare("
        SELECT
            posts.*,

            users.username,

            images.filename AS image_filename,
            images.filepath AS image_path

        FROM posts

        LEFT JOIN users
            ON posts.user_id = users.id

        LEFT JOIN images
            ON posts.featured_media_id = images.id

        WHERE posts.id = :id

        AND posts.status = 'published'

        LIMIT 1
    ");


    $stmt->execute([
        'id' => $id
    ]);


    return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
} 
public function getBlogImages(): array
    {
    $stmt = $this->db->query("
        SELECT *
        FROM images
        LIMIT 2
    ");

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getBlogFeaturedImages(): array
{
    $stmt = $this->db->query("
        SELECT *
        FROM images
        ORDER BY id DESC
        LIMIT 2
    ");

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


// Dashboard
public function findByUser(int $userId): array
{
    $stmt = $this->db->prepare("
        SELECT
            posts.*,
            images.filename AS image_filename,
            images.filepath AS image_path

        FROM posts

        LEFT JOIN images
        ON posts.featured_media_id = images.id

        WHERE posts.user_id = :user_id

        ORDER BY posts.created_at DESC
    ");

    $stmt->execute([
        'user_id' => $userId
    ]);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


public function findByIdAndUser(
    int $id,
    int $userId
): ?array {

    $stmt = $this->db->prepare("
        SELECT
            posts.*,
            images.filepath AS image_path

        FROM posts

        LEFT JOIN images
        ON posts.featured_media_id = images.id

        WHERE posts.id = :id

        AND posts.user_id = :user_id

        LIMIT 1
    ");


    $stmt->execute([
        'id' => $id,
        'user_id' => $userId
    ]);


    return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
}

public function create(
    int $userId,
    array $data
): bool {

    $stmt = $this->db->prepare("
        INSERT INTO posts (

            user_id,
            title,
            slug,
            content,
            status,
            created_at,
            updated_at

        ) VALUES (

            :user_id,
            :title,
            :slug,
            :content,
            :status,
            NOW(),
            NOW()

        )
    ");

    return $stmt->execute([

        'user_id' => $userId,
        'title'   => $data['title'],
        'slug'    => $data['slug'],
        'content' => $data['content'],
        'status'  => $data['status']

    ]);
}

public function update(
    int $id,
    int $userId,
    array $data
): bool {

    $stmt = $this->db->prepare("
        UPDATE posts
        SET
            title = :title,
            slug = :slug,
            status = :status,
            content = :content,
            updated_at = NOW()

        WHERE id = :id
        AND user_id = :user_id
    ");


    return $stmt->execute([

        'title' => $data['title'],
        'slug' => $data['slug'],
        'status' => $data['status'],
        'content' => $data['content'],
        'id' => $id,
        'user_id' => $userId

    ]);
}


public function delete(
    int $id,
    int $userId
): bool {

    $stmt = $this->db->prepare("
        DELETE FROM posts

        WHERE id = :id
        AND user_id = :user_id
    ");


    return $stmt->execute([
        'id' => $id,
        'user_id' => $userId
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | Administration
    |--------------------------------------------------------------------------
    */

public function countPosts(): int
{
    $stmt = $this->db->query("
        SELECT COUNT(*)
        FROM posts
    ");

    return (int)$stmt->fetchColumn();
}

public function adminAll(
    ?string $status = null): array {

    $sql = "
        SELECT
            p.id,
            p.title,
            p.status,
            p.created_at,
            u.username AS author,
            i.filepath AS image_path

        FROM posts p

        LEFT JOIN users u
            ON p.user_id = u.id

        LEFT JOIN images i
            ON p.featured_media_id = i.id
    ";

    $params = [];

    if ($status) {
        $sql .= "
            WHERE p.status = :status
        ";

        $params['status'] = $status;
    }

    $sql .= "
        ORDER BY p.created_at DESC
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute($params);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

public function adminCreate(array $data): bool
{
    $stmt = $this->db->prepare("
        INSERT INTO posts
        (
            user_id,
            title,
            slug,
            content,
            status,

            featured_media_id,

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

            seo_title,
            seo_description,

            created_at,
            updated_at
        )

        VALUES
        (
            :user_id,
            :title,
            :slug,
            :content,
            :status,

            :featured_media_id,

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

            :seo_title,
            :seo_description,

            NOW(),
            NOW()
        )
    ");

    return $stmt->execute([
        'user_id' => $data['user_id'],
        'title' => $data['title'],
        'slug' => $data['slug'],
        'content' => $data['content'],
        'status' => $data['status'] ?? 'draft',

        'featured_media_id' => $data['featured_media_id'] ?? null,

        'hero_title' => $data['hero_title'] ?? null,
        'hero_subtitle' => $data['hero_subtitle'] ?? null,
        'hero_image_alt' => $data['hero_image_alt'] ?? null,

        'main_heading' => $data['main_heading'] ?? null,
        'main_content' => $data['main_content'] ?? null,

        'column1_title' => $data['column1_title'] ?? null,
        'column1_content' => $data['column1_content'] ?? null,

        'column2_title' => $data['column2_title'] ?? null,
        'column2_content' => $data['column2_content'] ?? null,

        'column3_title' => $data['column3_title'] ?? null,
        'column3_content' => $data['column3_content'] ?? null,

        'column4_title' => $data['column4_title'] ?? null,
        'column4_content' => $data['column4_content'] ?? null,

        'column5_title' => $data['column5_title'] ?? null,
        'column5_content' => $data['column5_content'] ?? null,

        'seo_title' => $data['seo_title'] ?? null,
        'seo_description' => $data['seo_description'] ?? null,
    ]);
}
public function adminFindById(int $id): ?array
{
    $stmt = $this->db->prepare("
        SELECT
            posts.*,
            images.filename AS image_filename,
            images.filepath AS image_path

        FROM posts

        LEFT JOIN images
            ON posts.featured_media_id = images.id

        WHERE posts.id = :id

        LIMIT 1
    ");

    $stmt->execute([
        'id' => $id
    ]);

    return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
}
public function adminUpdate(array $data): bool
{
    $stmt = $this->db->prepare("
        UPDATE posts
        SET
            user_id = :user_id,
            title = :title,
            slug = :slug,
            content = :content,
            status = :status,

            featured_media_id = :featured_media_id,

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

            seo_title = :seo_title,
            seo_description = :seo_description,

            updated_at = NOW()

        WHERE id = :id
    ");

    return $stmt->execute([
        'id' => $data['id'],

        'user_id' => $data['user_id'],
        'title' => $data['title'],
        'slug' => $data['slug'],
        'content' => $data['content'],
        'status' => $data['status'],

        'featured_media_id' => $data['featured_media_id'] ?? null,

        'hero_title' => $data['hero_title'] ?? null,
        'hero_subtitle' => $data['hero_subtitle'] ?? null,
        'hero_image_alt' => $data['hero_image_alt'] ?? null,

        'main_heading' => $data['main_heading'] ?? null,
        'main_content' => $data['main_content'] ?? null,

        'column1_title' => $data['column1_title'] ?? null,
        'column1_content' => $data['column1_content'] ?? null,

        'column2_title' => $data['column2_title'] ?? null,
        'column2_content' => $data['column2_content'] ?? null,

        'column3_title' => $data['column3_title'] ?? null,
        'column3_content' => $data['column3_content'] ?? null,

        'column4_title' => $data['column4_title'] ?? null,
        'column4_content' => $data['column4_content'] ?? null,

        'column5_title' => $data['column5_title'] ?? null,
        'column5_content' => $data['column5_content'] ?? null,

        'seo_title' => $data['seo_title'] ?? null,
        'seo_description' => $data['seo_description'] ?? null,
    ]);
}
public function adminDelete(int $id): bool
{
    $stmt = $this->db->prepare("
        DELETE FROM posts
        WHERE id = :id
    ");


    return $stmt->execute([
        'id' => $id
    ]);
}
    
}
