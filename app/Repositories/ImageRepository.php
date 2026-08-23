<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class ImageRepository extends Repository
{
   public function upload(array $file): int
{
    $directory = dirname(__DIR__, 2)
        . '/public/images/uploads/';

    if (!is_dir($directory)) {
        if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new \RuntimeException(
                'Failed to create upload directory.'
            );
        }
    }

    // Check PHP upload status
    if (
        !isset($file['error'])
        || $file['error'] !== UPLOAD_ERR_OK
    ) {
        throw new \RuntimeException(
            'File upload failed.'
        );
    }

    // Maximum upload size: 5 MB
    $maxSize = 5 * 1024 * 1024;

    if (
        !isset($file['size'])
        || $file['size'] <= 0
        || $file['size'] > $maxSize
    ) {
        throw new \RuntimeException(
            'Image must be between 1 byte and 5 MB.'
        );
    }

    // Verify that the uploaded file is actually an image
    $imageInfo = getimagesize($file['tmp_name']);

    if ($imageInfo === false) {
        throw new \RuntimeException(
            'The uploaded file is not a valid image.'
        );
    }

    // Only allow specific image MIME types
    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    $mimeType = $imageInfo['mime'] ?? '';

    if (!isset($allowedMimeTypes[$mimeType])) {
        throw new \RuntimeException(
            'This image type is not supported.'
        );
    }

    // Generate our own filename
    $extension = $allowedMimeTypes[$mimeType];

    $filename = bin2hex(random_bytes(16))
        . '.'
        . $extension;

    $fullPath = $directory . $filename;

    // Move the validated uploaded file
    if (!move_uploaded_file(
        $file['tmp_name'],
        $fullPath
    )) {
        throw new \RuntimeException(
            'Failed to move uploaded file.'
        );
    }

    // Save image information
    $stmt = $this->db->prepare("
        INSERT INTO images
        (
            filename,
            filepath,
            mime_type
        )
        VALUES
        (
            :filename,
            :filepath,
            :mime_type
        )
    ");

    $stmt->execute([
        'filename' => $filename,
        'filepath' => '/images/uploads/' . $filename,
        'mime_type' => $mimeType,
    ]);

    return (int) $this->db->lastInsertId();
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
