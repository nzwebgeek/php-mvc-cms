<?php
/**
 * @var array $post
 * @var array $users
 * @var array $images
 * @var string $title
 */
?>
<h1><?= htmlspecialchars($title) ?></h1>

<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">

<?php if($_GET['success'] === 'created'): ?>

Post created successfully.

<?php elseif($_GET['success'] === 'updated'): ?>

Post updated successfully.

<?php elseif($_GET['success'] === 'deleted'): ?>

Post deleted successfully.

<?php endif; ?>

</div>

<?php endif; ?>
<div class="admin-actions">

    <a href="/admin/posts/create" class="btn btn-primary">
        New Post
    </a>

</div>


<div class="post-filters">

    <a href="/admin/posts">
        All Posts
    </a>

    <a href="/admin/posts?status=published">
        Published
    </a>

    <a href="/admin/posts?status=draft">
        Drafts
    </a>

</div>



<table class="table">

<thead>

<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Author</th>
    <th>Status</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

</thead>


<tbody>


<?php if(empty($posts)): ?>

<tr>
    <td colspan="6">
        No posts found.
    </td>
</tr>


<?php else: ?>


<?php foreach($posts as $post): ?>


<tr>

<td>

<?php if(!empty($post['image_path'])): ?>

<img 
src="<?= htmlspecialchars($post['image_path']) ?>"
width="80"
>

<?php else: ?>

No Image

<?php endif; ?>

</td>



<td>
<?= htmlspecialchars($post['title']) ?>
</td>


<td>
<?= htmlspecialchars($post['author'] ?? 'Unknown') ?>
</td>


<td>
<?= htmlspecialchars($post['status']) ?>
</td>


<td>
<?= htmlspecialchars($post['created_at']) ?>
</td>



<td>

<a href="/admin/posts/edit?id=<?= $post['id'] ?>">
    Edit
</a>

<form
    method="POST"
    action="/admin/posts/delete"
    style="display:inline;">

    <input
        type="hidden"
        name="id"
        value="<?= $post['id'] ?>">

    <button
        type="submit"
        onclick="return confirm('Delete this post?')">

        Delete

    </button>

</form>


</td>


</tr>


<?php endforeach; ?>


<?php endif; ?>


</tbody>

</table>