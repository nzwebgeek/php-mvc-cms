<?php

require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $file = $_FILES['image'];


    $filename = time() . "_" . basename($file['name']);

    $target = "../img/" . $filename;


    if (move_uploaded_file($file['tmp_name'], $target)) {


        $stmt = $conn->prepare("
            INSERT INTO blog_images (image)
            VALUES (?)
        ");


        $stmt->bind_param(
            "s",
            $filename
        );


        $stmt->execute();


        echo "Image uploaded";

    }

}

?>

<main>
  <h1>Upload Blog Image</h1>
<p>Feel free to upload an image here for the blog sectional.</p>
<form method="POST" enctype="multipart/form-data">

<input 
type="file" 
name="image"
required
>

<button class="button" type="submit">
Upload
</button>

</form>  
</main>
