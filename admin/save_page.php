<?php
require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';


$id = $_POST['id'];

$main_heading = $_POST['main_heading'];
$main_content = $_POST['main_content'];

$seo_title = $_POST['seo_title'] ?? '';
$seo_description = $_POST['seo_description'] ?? '';

$hero_title = $_POST['hero_title'];
$hero_subtitle = $_POST['hero_subtitle'];
$hero_media_id = !empty($_POST['hero_media_id'])
    ? (int)$_POST['hero_media_id']
    : null;/**Footer */
$column1_title = $_POST['column1_title'] ?? '';
$column1_content = $_POST['column1_content'] ?? '';

$column2_title = $_POST['column2_title'] ?? '';
$column2_content = $_POST['column2_content'] ?? '';

$column3_title = $_POST['column3_title'] ?? '';
$column3_content = $_POST['column3_content'] ?? '';

$column4_title = $_POST['column4_title'] ?? '';
$column4_content = $_POST['column4_content'] ?? '';
/*copyright_text*/
$column5_title = $_POST['column5_title'] ?? '';
$column5_content = $_POST['column5_content'] ?? '';

/*Check if errors */
$stmt = $conn->prepare("
UPDATE pages SET
    main_heading=?,
    main_content=?,
    seo_title=?,
    seo_description=?,
    hero_title=?,
    hero_subtitle=?,
    hero_media_id=?,

    column1_title=?,
    column1_content=?,

    column2_title=?,
    column2_content=?,

    column3_title=?,
    column3_content=?,

    column4_title=?,
    column4_content=?,

    column5_title=?,
    column5_content=?

WHERE id=?
");




$stmt->bind_param(
    "ssssissssssssssi",
    $main_heading,
    $main_content,
    $hero_title,
    $hero_subtitle,
    $hero_media_id,

    $column1_title,
    $column1_content,

    $column2_title,
    $column2_content,

    $column3_title,
    $column3_content,

    $column4_title,
    $column4_content,

    $column5_title,
    $column5_content,

    $id
);

/*Check if the UPDATE worked*/

if ($stmt->execute()) {
    header("Location: index.php?page=pages&updated=" . $id);
    exit;    
} else {
    die("Update failed: " . $stmt->error);
}

