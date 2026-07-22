<?php

require 'includes/auth.php';
require '../includes/db.php';


$id = (int)$_GET['id'];


$stmt = $conn->prepare("
DELETE FROM comments
WHERE id=?
");


$stmt->bind_param("i",$id);

$stmt->execute();


header("Location:index.php?page=comments&success=deleted");
exit;