<?php
require 'includes/auth.php';
require '../includes/db.php';

// Load media library
$mediaResult = $conn->query("
    SELECT id, filename, original_name, alt_text
    FROM media
    ORDER BY original_name
");

$mediaItems = [];

while ($row = $mediaResult->fetch_assoc()) {
    $mediaItems[] = $row;
}


$id = (int)$_GET['id'];

$stmt = $conn->prepare("
SELECT 
    posts.*,
    media.filename AS image_filename,
    media.alt_text AS image_alt
FROM posts
LEFT JOIN media
ON posts.featured_media_id = media.id
WHERE posts.id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'] ?? 'draft';

    $featured_media_id = !empty($_POST['featured_media_id'])
    ? (int)$_POST['featured_media_id']
    : null;

    $stmt = $conn->prepare("
        UPDATE posts
        SET title=?, content=?, featured_media_id=?, status=?
        WHERE id=?
        ");

  $stmt->bind_param(
    "ssisi",
    $title,
    $content,
    $featured_media_id,
    $status,
    $id
);

    $stmt->execute();
   
    header("Location:index.php?page=edit-post&id=" . $id . "&success=updated");
    exit;
    /*Now after saving, you stay on the edit screen.*/
    
}
?>
<!--Tod: need a updated successfully message-->
<h1>Edit Post</h1>
<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>

<div class="success">
    ✅ Post updated successfully.
</div>

<?php endif; ?>
<form method="post">

<input
type="text"
name="title"
value="<?= htmlspecialchars($post['title']) ?>"
required>

<input
type="text"
name="title"
value="<?= htmlspecialchars($post['title']) ?>"
required>

<br><br>

<label>Status</label>

<select name="status">

<option value="draft"
<?= $post['status'] === 'draft' ? 'selected' : '' ?>>
Draft
</option>

<option value="published"
<?= $post['status'] === 'published' ? 'selected' : '' ?>>
Published
</option>

</select>

<br><br>

<h3>Featured Image</h3>

<?php if (!empty($post['image_filename'])): ?>

<img
src="../uploads/<?= htmlspecialchars($post['image_filename']) ?>"
alt="<?= htmlspecialchars($post['image_alt']) ?>"
style="max-width:300px;display:block;margin-bottom:15px;">

<?php else: ?>

<p>No image selected.</p>

<?php endif; ?>


<br>

<label>Change Featured Image</label>

<select name="featured_media_id">

    <option value="">
        -- No Image --
    </option>

    <?php foreach ($mediaItems as $image): ?>

        <option
            value="<?= $image['id'] ?>"
            <?= ((int)$post['featured_media_id'] === (int)$image['id']) ? 'selected' : '' ?>
        >

            <?= htmlspecialchars($image['original_name']) ?>

        </option>

    <?php endforeach; ?>

</select>

<br><br>

<textarea
name="content"
rows="12"
cols="80"><?= htmlspecialchars($post['content']) ?></textarea>



<button class="button" type="submit">Update Post</button>

</form>