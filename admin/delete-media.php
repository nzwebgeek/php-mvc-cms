<?php

session_start();

require '../includes/db.php';

// Check ID
if (!isset($_GET['id'])) {
    die("No media selected");
}

$id = intval($_GET['id']);


// Find file first
$stmt = $conn->prepare("
    SELECT filename 
    FROM media 
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$result = $stmt->get_result();

$media = $result->fetch_assoc();


if (!$media) {
    die("Media not found");
}


// Delete physical file

$file = "../uploads/" . $media['filename'];

if (file_exists($file)) {
    unlink($file);
}


// Delete database record

$stmt = $conn->prepare("
    DELETE FROM media 
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();


// Return to library

header("Location: media-library.php");
exit;

?>