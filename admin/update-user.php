<?php
require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';

$id       = (int)$_POST['id'];
$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$role_id  = (int)$_POST['role_id'];

$stmt = $conn->prepare("
UPDATE users
SET
username=?,
email=?,
role_id=?
WHERE id=?
");

$stmt->bind_param(
"ssii",
$username,
$email,
$role_id,
$id
);

$stmt->execute();
// Todo: go back to user and display a 'added successfully message
header("Location: index.php?page=users");
exit;