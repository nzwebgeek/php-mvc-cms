<?php

class Page extends Model
{
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM pages");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM pages WHERE slug = ?"
        );

        $stmt->execute([$slug]);

        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }
}