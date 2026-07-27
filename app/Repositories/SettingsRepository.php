<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;

class SettingsRepository extends Repository
{

    public function get(): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM site_settings
            WHERE id = 1
        ");

        $stmt->execute();

        $settings = $stmt->fetch();

        return $settings ?: null;
    }
}