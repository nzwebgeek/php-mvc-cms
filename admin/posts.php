<?php
$statusFilter = "";
/*eg; ?page=posts

shows everything.

?page=posts&status=published

shows live posts.

?page=posts&stat

?page=posts&status=draft
*/
if (isset($_GET['status'])) {

    $status = $_GET['status'];

    if ($status === "published" || $status === "draft") {

        $statusFilter = "WHERE p.status = '$status'";

    }

}


$sql = "
SELECT
    p.id,
    p.title,
    p.status,
    p.created_at,
    u.username AS author,
    m.filename AS image

FROM posts p

LEFT JOIN users u
ON p.user_id = u.id

LEFT JOIN media m
ON p.featured_media_id = m.id

$statusFilter

ORDER BY p.created_at DESC
";

$result = $conn->query($sql);

?>

<h1>Posts</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="success">
        <?php
        if ($_GET['success'] === 'deleted') {
            echo "Post deleted successfully.";
        } elseif ($_GET['success'] === 'created') {
            echo "Post created successfully.";
        }
         elseif ($_GET['success'] === 'updated') {
            echo "✏️ Post updated successfully.";
        }
        ?>
    </div>
<?php endif; ?>

<a href="index.php?page=create-post" class="button">+ New Post</a>
<br><br>
<!--Add filter buttons-->
<a class="button" href="index.php?page=posts">
All Posts
</a>

<a class="button" href="index.php?page=posts&status=published">
Published
</a>

<a class="button" href="index.php?page=posts&status=draft">
Drafts
</a>

<br><br>
<!--active filter indicator-->
<?php if(isset($_GET['status'])): ?>

<p>
Showing:
<strong>
<?= htmlspecialchars($_GET['status']) ?>
</strong>
posts
</p>

<?php endif; ?>
<table>

<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Author</th>
    <th>Status</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

<?php while($post = $result->fetch_assoc()): ?>

<tr>
<td>

<?php if (!empty($post['image'])): ?>

<img 
src="../uploads/<?= htmlspecialchars($post['image']) ?>"
style="width:80px;height:60px;object-fit:cover;">

<?php else: ?>

No image

<?php endif; ?>

</td>

<td>
<?= htmlspecialchars($post['title']) ?>
</td>


<td>
<?= htmlspecialchars($post['author']) ?>
</td>


<td>

<?php if ($post['status'] === 'published'): ?>

<span style="color:green;">
Published
</span>

<?php else: ?>

<span style="color:orange;">
Draft
</span>

<?php endif; ?>

</td>

<td><?= htmlspecialchars($post['created_at']) ?></td>

<td>

<a class="button"
href="index.php?page=edit-post&id=<?= $post['id'] ?>">
Edit
</a>

<?php if ($post['status'] === 'published'): ?>

<a class="button"
href="../post.php?id=<?= $post['id'] ?>"
target="_blank">
View
</a>

<?php endif; ?>

<a class="delete-button"
href="index.php?page=delete-post&id=<?= $post['id'] ?>"
onclick="return confirm('Delete this post?')">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</table>