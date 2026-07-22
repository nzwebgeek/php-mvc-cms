<?php

require 'includes/auth.php';
require '../includes/db.php';


$sql = "
SELECT
    comments.id,
    comments.comment,
    comments.created_at,
    comments.status,
    posts.title,
    users.username

FROM comments

LEFT JOIN posts
ON comments.post_id = posts.id

LEFT JOIN users
ON comments.user_id = users.id

WHERE comments.status = 'pending'

ORDER BY comments.created_at DESC
";


$result = $conn->query($sql);

?>


<h1>Comment Moderation</h1>

<?php if (isset($_GET['success'])): ?>

<div class="success">

<?php

if ($_GET['success'] === 'approved') {

    echo "✅ Comment approved successfully.";

}

elseif ($_GET['success'] === 'deleted') {

    echo "🗑️ Comment deleted successfully.";

}

?>

</div>

<?php endif; ?>

<table>

<tr>
    <th>Post</th>
    <th>User</th>
    <th>Comment</th>
    <th>Date</th>
    <th>Actions</th>
</tr>


<?php while($comment = $result->fetch_assoc()): ?>


<tr>

<td>
<?= htmlspecialchars($comment['title']) ?>
</td>


<td>
<?= htmlspecialchars($comment['username']) ?>
</td>


<td>
<?= htmlspecialchars($comment['comment']) ?>
</td>


<td>
<?= htmlspecialchars($comment['created_at']) ?>
</td>


<td>

<a class="button"
href="index.php?page=approve-comment&id=<?= $comment['id'] ?>">
Approve
</a>


<a class="delete-button"
href="index.php?page=delete-comment&id=<?= $comment['id'] ?>"
onclick="return confirm('Delete this comment?')">
Delete
</a>


</td>


</tr>


<?php endwhile; ?>


</table>