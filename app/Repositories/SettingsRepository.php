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


    public function update(
        string $siteName,
        string $contactEmail,
        string $contactPhone,
        string $copyrightText,
        string $theme,
        int $maintenanceMode,
        string $adminEmail,
        string $seoTitle,
        string $seoDescription
    ): void {
        $stmt = $this->db->prepare("
            UPDATE site_settings
            SET
                site_name = :site_name,
                contact_email = :contact_email,
                contact_phone = :contact_phone,
                copyright_text = :copyright_text,
                theme = :theme,
                maintenance_mode = :maintenance_mode,
                admin_email = :admin_email,
                seo_title = :seo_title,
                seo_description = :seo_description
            WHERE id = 1
        ");

        $stmt->execute([
            'site_name' => $siteName,
            'contact_email' => $contactEmail,
            'contact_phone' => $contactPhone,
            'copyright_text' => $copyrightText,
            'theme' => $theme,
            'maintenance_mode' => $maintenanceMode,
            'admin_email' => $adminEmail,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription
        ]);
    }
}