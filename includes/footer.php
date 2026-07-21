<?php
require_once __DIR__ . '/db.php';
$stmt = $conn->prepare("SELECT * FROM pages WHERE slug = ?");
$slug = "footer";
$stmt->bind_param("s", $slug);
$stmt->execute();

$footer = $stmt->get_result()->fetch_assoc();
?>

<footer>

<div class="footer-container">

    <div class="footer-column">
        <h3><?= htmlspecialchars($footer['column1_title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
        <p><?= htmlspecialchars($footer['column1_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="footer-column">
        <h3><?= htmlspecialchars($footer['column2_title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
        <p><?= htmlspecialchars($footer['column2_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="footer-column">
        <h3><?= htmlspecialchars($footer['column3_title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
        <p><?= htmlspecialchars($footer['column3_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="footer-column">
        <h3><?= htmlspecialchars($footer['column4_title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
        <p><?= htmlspecialchars($footer['column4_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="footer-column">
        <h3><?= htmlspecialchars($footer['column5_title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
        <p><?= htmlspecialchars($footer['column5_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
    </div>

</div>
</footer>