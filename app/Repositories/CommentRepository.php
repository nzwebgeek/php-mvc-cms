<?php

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class CommentRepository extends Repository
{

    public function create(
        int $postId,
        int $userId,
        string $comment
    ): bool {

        $stmt = $this->db->prepare("
            INSERT INTO comments
            (
                post_id,
                user_id,
                comment,
                status,
                created_at
            )
            VALUES
            (
                :post_id,
                :user_id,
                :comment,
                'pending',
                NOW()
            )
        ");


        return $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId,
            'comment' => $comment
        ]);
    }


    public function update(
        int $id,
        int $userId,
        string $comment
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE comments
            SET comment = :comment
            WHERE id = :id
            AND user_id = :user_id
        ");


        return $stmt->execute([
            'comment' => $comment,
            'id' => $id,
            'user_id' => $userId
        ]);
    }


    public function delete(
        int $id,
        int $userId
    ): bool {

        $stmt = $this->db->prepare("
            DELETE FROM comments
            WHERE id = :id
            AND user_id = :user_id
        ");


        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);
    }


    public function findApprovedByPost(
        int $postId
    ): array {

        $stmt = $this->db->prepare("
            SELECT
                c.*,
                c.username
            FROM comments c
            JOIN users u
                ON c.user_id = u.id
            WHERE c.post_id = :post_id
            AND c.status = 'approved'
            ORDER BY created_at DESC
        ");


        $stmt->execute([
            'post_id' => $postId
        ]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}