<?php
/**
 * @var array $post
 * @var array $users
 * @var array $images
 * @var string $title
 */
?>

<div class="admin-card">
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

    <a class="post-create-btn"
    href="/admin/posts/create" >
        New Post
    </a>

</div>


<div class="post-filters">

    <a href="/admin/posts" class="post-create-btn">
        All Posts
    </a>

    <a href="/admin/posts?status=published" class="post-create-btn">
        Published
    </a>

    <a href="/admin/posts?status=draft" class="post-create-btn">
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

<a class="green-button"
href="/admin/posts/edit?id=<?= $post['id']; ?>">

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

 <button class="red-button"
type="submit"
onclick="return confirm('Delete this post?');">

Delete

</button>

</form>


</td>


</tr>


<?php endforeach; ?>


<?php endif; ?>


</tbody>

</table>
</div>