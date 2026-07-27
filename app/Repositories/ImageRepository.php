<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;


class ImageRepository extends Repository
{


    public function upload(
        array $file
    ): int {


        $directory = 'images/uploads/';


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


        $path = $directory . $filename;


        move_uploaded_file(
            $file['tmp_name'],
            $path
        );


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
            'filename'=>$filename,
            'filepath'=>$path
        ]);


        return (int) $this->db->lastInsertId();
    }
}