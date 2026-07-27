<?php

namespace App\Repositories;

use App\Core\Repository;

class UserRepository extends Repository
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                u.id,
                u.username,
                u.password,
                u.email_verified,
                r.name AS role
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.id
            WHERE u.username = :username
        ");

        $stmt->execute([
            'username' => $username
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }
}