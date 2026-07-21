<?php

require 'includes/auth.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];


    $stmt = $conn->prepare(
        "DELETE FROM pages WHERE id = ?"
    );


    $stmt->bind_param(
        "i",
        $id
    );


    if ($stmt->execute()) {

        header("Location: index.php?page=pages");
        exit;

    } else {

        echo "Error deleting page: " . $stmt->error;

    }

}

?>