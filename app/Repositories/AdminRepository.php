<?php

declare(strict_types=1);
/*Register it in bootstrap*/
namespace App\Repositories;

use App\Core\Repository;
use PDO;

class AdminRepository extends Repository
{

    public function countUsers(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM users
        ");

        return (int)$stmt->fetchColumn();
    }


    public function countPosts(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM posts
        ");

        return (int)$stmt->fetchColumn();
    }


    public function countPages(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM pages
        ");

        return (int)$stmt->fetchColumn();
    }


    public function countPendingComments(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*)
            FROM comments
            WHERE status = 'pending'
        ");

        return (int)$stmt->fetchColumn();
    }

  public function recentActivity(): array
{
    $stmt = $this->db->query("
        SELECT
            a.created_at,
            u.username,
            a.action

        FROM activity_logs a

        LEFT JOIN users u
        ON a.user_id = u.id

        ORDER BY a.created_at DESC

        LIMIT 10
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function allUsers(): array{
    $stmt = $this->db->query("
        SELECT
            u.id,
            u.username,
            u.email,
            u.email_verified,
            r.name AS role

        FROM users u

        LEFT JOIN roles r
        ON u.role_id = r.id

        ORDER BY u.id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser(
    int $id,
    string $username,
    string $email,
    int $roleId): bool {

    $stmt = $this->db->prepare("
        UPDATE users
        SET
            username = :username,
            email = :email,
            role_id = :role_id

        WHERE id = :id
    ");


    return $stmt->execute([
        'username' => $username,
        'email' => $email,
        'role_id' => $roleId,
        'id' => $id
    ]);
    }

    public function adminAll(?string $status = null): array{
    $sql = "
        SELECT
            p.id,
            p.title,
            p.status,
            p.created_at,
            u.username AS author,
            i.filepath AS image
        FROM posts p
        LEFT JOIN users u
            ON p.user_id = u.id
        LEFT JOIN images i
            ON p.featured_media_id = i.id
    ";

    $params = [];

    if ($status) {
        $sql .= " WHERE p.status = :status";
        $params['status'] = $status;
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}