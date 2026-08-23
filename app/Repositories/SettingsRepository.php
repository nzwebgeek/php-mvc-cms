<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class SettingsRepository extends Repository
{
public function get(): ?array
{
    $stmt = $this->db->prepare("
        SELECT
            s.*,

            i1.filename AS featured_image_1_filename,
            i1.filepath AS featured_image_1_path,

            i2.filename AS featured_image_2_filename,
            i2.filepath AS featured_image_2_path

        FROM site_settings s

        LEFT JOIN images i1
            ON s.featured_image_1_id = i1.id

        LEFT JOIN images i2
            ON s.featured_image_2_id = i2.id

        WHERE s.id = 1

        LIMIT 1
    ");

    $stmt->execute();

    $settings = $stmt->fetch(\PDO::FETCH_ASSOC);

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
        string $seoDescription,
        ?int $featuredImage1Id,
        ?int $featuredImage2Id
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
                seo_description = :seo_description,

                featured_image_1_id = :featured_image_1_id,
                featured_image_2_id = :featured_image_2_id

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
            'seo_description' => $seoDescription,

            'featured_image_1_id' => $featuredImage1Id,
            'featured_image_2_id' => $featuredImage2Id
        ]);
    }
}