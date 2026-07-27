<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;


class PostRepository extends Repository
{

    public function all(): array
    {

        $stmt = $this->db->query("
            SELECT
                id,
                title,
                content,
                created_at
            FROM posts
            ORDER BY id DESC
        ");


        return $stmt->fetchAll();
    }


    public function findById(
        int $id
    ): ?array {

        $stmt = $this->db->prepare("
            SELECT *
            FROM posts
            WHERE id = :id
        ");


        $stmt->execute([
            'id'=>$id
        ]);


        return $stmt->fetch() ?: null;
    }
}