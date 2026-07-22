<?php

$sql = "
SELECT
    p.id,
    p.title,
    u.username AS author,
    p.created_at
FROM posts p
LEFT JOIN users u
ON p.user_id = u.id
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

<table>

<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

<?php while($post = $result->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($post['title']) ?></td>

<td><?= htmlspecialchars($post['author']) ?></td>

<td><?= htmlspecialchars($post['created_at']) ?></td>

<td>

<a class="button"
href="index.php?page=edit-post&id=<?= $post['id'] ?>">
Edit
</a>

<a class="button"
href="../post.php?id=<?= $post['id'] ?>"
target="_blank">
View
</a>

<a class="delete-button"
href="index.php?page=delete-post&id=<?= $post['id'] ?>"
onclick="return confirm('Delete this post?')">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</table>