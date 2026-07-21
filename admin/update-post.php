<?php
require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';

$id = (int)$_POST['id'];

$title = trim($_POST['title']);
$content = trim($_POST['content']);

$stmt = $conn->prepare("
UPDATE posts
SET
title=?,
content=?
WHERE id=?
");

$stmt->bind_param(
"ssi",
$title,
$content,
$id
);

$stmt->execute();

header("Location: index.php?page=posts");
exit;