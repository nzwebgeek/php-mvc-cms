<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class BlogSettingsRepository extends Repository
{
    /**
     * Get blog settings together with the selected images.
     */
    public function get(): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                bs.id,

                bs.image_one_id,
                bs.image_two_id,

                img1.filename AS image_one_filename,
                img1.filepath AS image_one_filepath,

                img2.filename AS image_two_filename,
                img2.filepath AS image_two_filepath

            FROM blog_settings bs

            LEFT JOIN images img1
                ON img1.id = bs.image_one_id

            LEFT JOIN images img2
                ON img2.id = bs.image_two_id

            WHERE bs.id = 1

            LIMIT 1
        ");

        $stmt->execute();

        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        return $settings ?: null;
    }
}