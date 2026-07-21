<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = $_POST['id'];
$image = $_POST['image'];


// Delete physical file

$file = dirname(__DIR__) . $image;


if (file_exists($file)) {
    unlink($file);
}


// Remove image from database

$stmt = $conn->prepare("
    UPDATE pages 
    SET hero_image = NULL
    WHERE id = ?
");


$stmt->bind_param(
    "i",
    $id
);


if ($stmt->execute()) {

    header("Location: index.php?page=pages&updated=" . $id);
    exit;

} else {

    die("Could not delete image.");

}