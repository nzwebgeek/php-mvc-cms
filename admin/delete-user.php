<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php?page=users");
    exit;
}

// Prevent deleting your own account
if ($id == $_SESSION['user_id']) {
    die("You cannot delete your own account.");
}


// Check user role before deleting
$stmt = $conn->prepare("
    SELECT role_id
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}


// Prevent deleting the last Super Admin
if ($user['role_id'] == 1) {

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


// Delete user's comments
$stmt = $conn->prepare("
    DELETE FROM comments
    WHERE user_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();


// Delete user's posts
$stmt = $conn->prepare("
    DELETE FROM posts
    WHERE user_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();


// Delete user
$stmt = $conn->prepare("
    DELETE FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php?page=users&success=deleted");
    exit;

} else {

    echo "Error deleting user.";

}