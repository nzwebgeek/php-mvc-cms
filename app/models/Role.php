<?php
namespace App\Models;

use PDO;
class Role
{
    public function __construct(private PDO $db)
    {
    }

 public function getIdByName(string $name): ?int
{
    $stmt = $this->db->prepare("
        SELECT id
        FROM roles
        WHERE name = :name
    ");

    $stmt->execute([
        'name' => $name
    ]);

    $id = $stmt->fetchColumn();

    return $id !== false ? (int) $id : null;
}
}
?>