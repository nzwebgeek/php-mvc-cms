<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class ImageRepository extends Repository
{
    public function upload(array $file): int
    {
        $directory = dirname(__DIR__, 2) . '/public/images/uploads/';

        if (!is_dir($directory)) {
            mkdir(
                $directory,
                0755,
                true
            );
        }

        $extension = strtolower(
            pathinfo(
                $file['name'],
                PATHINFO_EXTENSION
            )
        );

        $filename =
            uniqid('img_', true)
            . '.'
            . $extension;

        $fullPath = $directory . $filename;

        if (!move_uploaded_file(
            $file['tmp_name'],
            $fullPath
        )) {
            throw new \RuntimeException(
                'Failed to move uploaded file'
            );
        }

        $stmt = $this->db->prepare("
            INSERT INTO images
            (
                filename,
                filepath
            )
            VALUES
            (
                :filename,
                :filepath
            )
        ");

        $stmt->execute([
            'filename' => $filename,
            'filepath' => '/images/uploads/' . $filename
        ]);

        return (int)$this->db->lastInsertId();
    }


    public function getBlogFeaturedImages(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM images
            LIMIT 2
        ");

        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                filename,
                filepath,
                mime_type,
                uploaded_at
            FROM images
            ORDER BY id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                filename,
                filepath,
                mime_type,
                uploaded_at
            FROM images
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        return $image ?: null;
    }


    public function delete(int $id): void
    {
        $image = $this->findById($id);

        if (!$image) {
            return;
        }

        $file = dirname(__DIR__, 2)
            . '/public'
            . $image['filepath'];

        if (is_file($file)) {
            unlink($file);
        }

        $stmt = $this->db->prepare("
            DELETE FROM images
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id
        ]);
    }
}