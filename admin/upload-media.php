<?php

require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';


// Check logged in user
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in");
}

$uploaded_by = $_SESSION['user_id'];

$image = $_FILES['image'];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $image['tmp_name']);
finfo_close($finfo);

// Basic validation
if ($image['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed");
}


// Allowed file types
$allowed = [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif'
];

if (!in_array($image['type'], $allowed)) {
    die("Invalid file type");
}


// Create filename
$filename = uniqid() . "-" . basename($image['name']);


// Upload location
$uploadPath = "../uploads/" . $filename;


if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
    die("Could not upload file");
}


// Get form data
$alt_text = $_POST['alt_text'] ?? '';


// Example logged-in user


// Insert into database
$stmt = $conn->prepare("
INSERT INTO media
(filename, original_name, mime_type, file_size, alt_text, uploaded_by)
VALUES (?,?,?,?,?,?)
");


$stmt->bind_param(
    "sssssi",
    $filename,
    $image['name'],
    $mime,
    $image['size'],
    $alt_text,
    $uploaded_by
);


$stmt->execute();


echo "Image uploaded successfully";

?>