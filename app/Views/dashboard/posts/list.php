<?php
/**
 * @var array $posts
 * @var string|null $status
 * @var string $title
 */
?>

<h1><?= htmlspecialchars($title) ?></h1>


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


<br>


<table>

<thead>

<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Status</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

</thead>


<tbody>

<?php foreach ($posts as $post): ?>

<tr>

<td>
<?= htmlspecialchars($post['title']) ?>
</td>


<td>
<?= htmlspecialchars($post['author']) ?>
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
style="display:inline"
>

<input 
type="hidden"
name="id"
value="<?= $post['id'] ?>"
>


<button 
type="submit"
onclick="return confirm('Delete this post?')"
>
Delete
</button>


</form>

</td>


</tr>


<?php endforeach; ?>


</tbody>

</table>