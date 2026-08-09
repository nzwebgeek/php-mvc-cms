<div class="admin-card">
<h1>Create Post</h1>
<form method="POST" action="/admin/posts/store">


<div class="form-group">

<label>
Title
</label>

<input
type="text"
name="title"
required>

</div>



<div class="form-group">

<label>
Slug
</label>

<input
type="text"
name="slug"
required>

</div>



<div class="form-group">

<label>
Content
</label>

<textarea
name="content"
rows="10"
required></textarea>

</div>



<div class="form-group">

<label>
Author
</label>

<select name="user_id">


<?php foreach($users as $user): ?>

<option value="<?= $user['id']; ?>">

<?= htmlspecialchars($user['username']); ?>

</option>

<?php endforeach; ?>


</select>

</div>




<div class="form-group">

<label>
Featured Image
</label>


<select
name="featured_media_id">


<option value="">
-- Select Image --
</option>


<?php foreach($images as $image): ?>


<option value="<?= $image['id']; ?>">

<?= htmlspecialchars($image['filename']); ?>

</option>


<?php endforeach; ?>


</select>


</div>



<div class="form-group">

<label>
Status
</label>


<select name="status">


<option value="published">
Published
</option>


<option value="draft">
Draft
</option>


</select>


</div>




<button
class="green-button"
type="submit">

Create Post

</button>



<a
href="/admin/posts"
class="red-button">

Cancel

</a>



</form>

</div>