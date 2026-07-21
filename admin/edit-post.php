<?php
require '../includes/db.php';
$id = (int)$_GET['id'];


$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location:index.php?post=posts");
    exit;
}
?>
<!--Tod: need a updated successfully message-->
<h1>Edit Post</h1>
<form method="post">

<input
type="text"
name="title"
value="<?= htmlspecialchars($post['title']) ?>"
required>

<br><br>

<textarea
name="content"
rows="12"
cols="80"><?= htmlspecialchars($post['content']) ?></textarea>

<br><br>

<button class="button" type="submit">Save Changes</button>

</form>