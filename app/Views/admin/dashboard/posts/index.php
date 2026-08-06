<div class="admin-card">

<h1>Posts</h1>

<p>
Manage all blog posts.
</p>

<a href="/admin/posts/create" class="button">
+ New Post
</a>

</div>


<div class="admin-card">

<p>

<a href="/admin/posts">All</a> |

<a href="/admin/posts?status=published">
Published
</a> |

<a href="/admin/posts?status=draft">
Drafts
</a>

</p>

<table class="admin-table">

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

<?php foreach ($posts as $post): ?>

<tr>

<td>

<?php if (!empty($post['image_path'])): ?>

<img
src="<?= htmlspecialchars($post['image_path']) ?>"
style="width:80px;height:60px;object-fit:cover;"
>

<?php else: ?>

—

<?php endif; ?>

</td>

<td>

<?= htmlspecialchars($post['title']) ?>

</td>

<td>

<?= htmlspecialchars($post['author']) ?>

</td>

<td>

<?= htmlspecialchars(ucfirst($post['status'])) ?>

</td>

<td>

<?= date(
    'd M Y',
    strtotime($post['created_at'])
) ?>

</td>

<td>

<a href="/admin/posts/edit?id=<?= $post['id']; ?>">
Edit</a>

<form
    method="POST"
    action="/admin/posts/delete"
    style="display:inline;">

    <input
        type="hidden"
        name="id"
        value="<?= $post['id']; ?>">

    <button
        type="submit"
        onclick="return confirm('Delete this post?');">

        Delete

    </button>

</form>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>