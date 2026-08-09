<div class="admin-card">
    <?php
/**
 * @var array $users
 * @var array $images
 * @var string $title
 */
?>
<div class="admin-card">
    <h1>Create Post</h1>


<form method="POST" action="/admin/posts/store">


<label>
Title
</label>

<input 
type="text"
name="title"
required
>


<br>


<label>
Slug
</label>

<input 
type="text"
name="slug"
required
>


<br>


<label>
Content
</label>

<textarea 
name="content"
rows="10"
required>
</textarea>


<br>


<label>
Author
</label>

<select name="user_id">

<?php foreach ($users as $user): ?>

<option value="<?= $user['id'] ?>">

<?= htmlspecialchars($user['username']) ?>

</option>

<?php endforeach; ?>

</select>


<br>

<label>
Featured Image
</label>

<select name="featured_media_id">

<option value="">
No Image
</option>

<?php foreach ($images as $image): ?>

<option value="<?= $image['id'] ?>">

<?= htmlspecialchars($image['filename']) ?>

</option>

<?php endforeach; ?>

</select>


<br>

<label>
Status
</label>

<select name="status">

<option value="draft">
Draft
</option>

<option value="published">
Published
</option>

</select>


<br>


<button type="submit">
Create Post
</button>


</form>

</div>
</div>