<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use PDO;

class RoleRepository extends Repository
{

    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                name,
                description
            FROM roles
            ORDER BY id ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function findById(int $id): ?array
    {

        $stmt = $this->db->prepare("
            SELECT *
            FROM roles
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id
        ]);


        $role = $stmt->fetch(PDO::FETCH_ASSOC);


        return $role ?: null;
    }



    public function create(
        string $name,
        string $description
    ): bool {

        $stmt = $this->db->prepare("
            INSERT INTO roles
            (
                name,
                description
            )

            VALUES
            (
                :name,
                :description
            )
        ");


        return $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);

    }



    public function update(
        int $id,
        string $name,
        string $description
    ): bool {


        $stmt = $this->db->prepare("
            UPDATE roles
            SET
                name = :name,
                description = :description

            WHERE id = :id
        ");


        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description
        ]);

    }



    public function delete(int $id): bool
    {

        $stmt = $this->db->prepare("
            DELETE FROM roles
            WHERE id = :id
        ");


        return $stmt->execute([
            'id' => $id
        ]);

    }



    public function usersUsingRole(int $id): int
    {

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE role_id = :id
        ");


        $stmt->execute([
            'id' => $id
        ]);


        return (int)$stmt->fetchColumn();

    }

    public function isSystemRole(int $id): bool{
    return in_array($id, [1,2,5]);
    }

    public function exists(string $name): bool{

    $stmt = $this->db->prepare("
        SELECT COUNT(*)
        FROM roles
        WHERE name = :name
    ");


    $stmt->execute([
        'name' => $name
    ]);


    return $stmt->fetchColumn() > 0;
    }

}