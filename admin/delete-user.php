<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php?page=users");
    exit;
}
if ($id == $_SESSION['user_id']) {
    die("You cannot delete your own account.");
}

$stmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM blogg
WHERE user_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$count = $stmt->get_result()->fetch_assoc()['total'];

if ($count > 0) {
    die("This user owns $count blog posts. Reassign or delete the posts first.");
}

$stmt = $conn->prepare("
SELECT role_id
FROM users
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if ($user && $user['role_id'] == 1) {

    $result = $conn->query("
        SELECT COUNT(*) AS total
        FROM users
        WHERE role_id = 1
    ");

    $count = $result->fetch_assoc()['total'];

    if ($count <= 1) {
        die("You cannot delete the last Super Admin.");
    }
}

$stmt = $conn->prepare("
DELETE FROM users
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php?page=users");
exit;