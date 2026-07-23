<?php
class User
{
    public function __construct(private PDO $db)
    {
    }

    public function findByToken(string $token): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, email_verified
            FROM users
            WHERE verification_token = ?
        ");

        $stmt->execute([$token]);

        return $stmt->fetch() ?: null;
    }

    public function verifyEmail(string $token): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET
                email_verified = 1,
                verification_token = NULL
            WHERE verification_token = ?
        ");

        $stmt->execute([$token]);

        return $stmt->rowCount() > 0;
    }
}
?>