<?php
require 'includes/auth.php';
require __DIR__ . '/includes/db.php';


$id = $_POST['id'];

$main_heading = $_POST['main_heading'];
$main_content = $_POST['main_content'];

$hero_title = $_POST['hero_title'];
$hero_subtitle = $_POST['hero_subtitle'];
$hero_image_alt = $_POST['hero_image_alt'];

$existing_image = $_POST['existing_image'];
$imagePath = $existing_image;

$remove_image = isset($_POST['remove_image']);
/*Add the delete logic before the upload code*/
/* Remove image */
if ($remove_image && !empty($existing_image)) {

    $file = dirname(__DIR__) . $existing_image;

    if (file_exists($file)) {
        unlink($file);
    }

    $imagePath = NULL;
}


/* Upload new image */
if (!empty($_FILES['hero_image']['name'])) {

    $targetDir = __DIR__ . "/../images/";

    $filename = time() . "_" . basename($_FILES["hero_image"]["name"]);

    $targetFile = $targetDir . $filename;


    if (move_uploaded_file($_FILES["hero_image"]["tmp_name"], $targetFile)) {

        $imagePath = "/images/" . $filename;

    } else {

        die("Image upload failed.");

    }
}

/*Check if errors */
$stmt = $conn->prepare("
UPDATE pages SET
    main_heading=?,
    main_content=?,
    hero_title=?,
    hero_subtitle=?,
    hero_image=NULLIF(?, ''),
    hero_image_alt=?
WHERE id=?
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
"ssssssi",
$main_heading,
$main_content,
$hero_title,
$hero_subtitle,
$imagePath,
$hero_image_alt,
$id
);

/*Check if the UPDATE worked*/

if ($stmt->execute()) {
    header("Location: index.php?page=pages&updated=" . $id);
    exit;    
} else {
    die("Update failed: " . $stmt->error);
}

