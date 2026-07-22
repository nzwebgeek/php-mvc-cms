<?php

//session_start();
require 'includes/auth.php';
require '../includes/db.php';
// Get media files
$stmt = $conn->prepare("
    SELECT *
    FROM media
    ORDER BY id DESC
");

$stmt->execute();

$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html>
<head>

<title>Media Library</title>

<style>

.gallery {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:20px;
}

.card {
    border:1px solid #ddd;
    padding:15px;
    background:#fff;
    
}

.card img {
    width:100%;
    height:180px;
    object-fit:cover;
}

.filename {
    font-size:14px;
    margin-top:10px;
}
.button{
    display:inline-block;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:5px;
    text-decoration:none;
}


@media (max-width:1800px){
   .gallery {
  display: grid;
  /* The magic line: */
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 16px;
}



}
</style>

</head>


<body>


<h1>Media Library</h1>


<a class="button" href="media.php">
Upload New Image
</a>


<hr>


<div class="gallery">


<?php while($row = $result->fetch_assoc()): ?>


<div class="card">


<img src="../uploads/<?php echo htmlspecialchars($row['filename']); ?>">


<div class="filename">

<strong>
<?php echo htmlspecialchars($row['original_name']); ?>
</strong>

<br>

Alt:
<?php echo htmlspecialchars($row['alt_text']); ?>

<br>

Size:
<?php echo round($row['file_size']/1024,2); ?> KB

<br>

Type:
<?php echo htmlspecialchars($row['mime_type']); ?>


<br><br>

URL:

<input 
type="text"
value="../uploads/<?php echo htmlspecialchars($row['filename']); ?>"
readonly
style="width:100%;">
<br><br>

<a class="delete-button"
href="delete-media.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this image?');">


Delete


</a>
</div>


</div>


<?php endwhile; ?>


</div>


</body>
</html>