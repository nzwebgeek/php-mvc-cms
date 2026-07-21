<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php?page=posts");
    exit;
}



$stmt = $conn->prepare("
DELETE FROM posts
WHERE id=?
");

$stmt->bind_param("i",$id);

if ($stmt->execute()) {
    header("Location: index.php?page=posts&success=deleted");
    exit;
}

echo "Error deleting post.";
$stmt->execute();

header("Location: index.php?page=posts");
exit;

