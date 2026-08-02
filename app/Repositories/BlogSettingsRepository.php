<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class BlogSettingsRepository extends Repository
{

    public function get(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM blog_settings
            LIMIT 1
        ");

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

}