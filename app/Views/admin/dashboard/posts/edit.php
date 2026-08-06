<?php
/**
 * @var array $post
 * @var array $users
 * @var array $images
 * @var string $title
 */
?>


<h1>
    <?= htmlspecialchars($title) ?>
</h1>

<a href="/admin/posts" class="btn btn-secondary">
    ← Back to Posts
</a>

<br>
<br>

<form method="POST" action="/admin/posts/update">


<input
    type="hidden"
    name="id"
    value="<?= $post['id']; ?>"
>



<label>
    Title
</label>

<br>

<input
    type="text"
    name="title"
    value="<?= htmlspecialchars($post['title']); ?>"
    required
>


<br>
<br>



<label>
    Slug
</label>

<br>

<input
    type="text"
    name="slug"
    value="<?= htmlspecialchars($post['slug']); ?>"
    required
>


<br>
<br>



<label>
    Content
</label>

<br>

<textarea
    name="content"
    rows="10"
    required><?= htmlspecialchars($post['content']); ?></textarea>


<br>
<br>



<label>
    Current Featured Image
</label>

<br>


<?php if(!empty($post['image_path'])): ?>


<img
    src="<?= htmlspecialchars($post['image_path']); ?>"
    width="150"
    style="object-fit:cover;"
>


<p>
<?= htmlspecialchars($post['image_filename']); ?>
</p>


<?php else: ?>


<p>
No image selected
</p>


<?php endif; ?>


<br>



<label>
    Change Featured Image
</label>

<br>


<select 
    name="featured_media_id"
    id="featured_media_id"
    onchange="previewImage(this)"
>


<option value="">
No Image
</option>



<?php foreach($images as $image): ?>


<option

value="<?= $image['id']; ?>"

data-image="<?= htmlspecialchars($image['filepath']); ?>"

<?= 
($image['id'] == $post['featured_media_id']) 
? 'selected' 
: ''; 
?>

>

<?= htmlspecialchars($image['filename']); ?>


</option>


<?php endforeach; ?>


</select>


<br>
<br>


<label>
    New Image Preview
</label>

<br>


<img
    id="image-preview"
    src=""
    width="150"
    style="
        object-fit:cover;
        display:none;
    "
>


<br>
<br>




<label>
    Author
</label>

<br>


<select name="user_id">


<?php foreach($users as $user): ?>


<option

value="<?= $user['id']; ?>"

<?= 
($user['id'] == $post['user_id']) 
? 'selected' 
: ''; 
?>

>

<?= htmlspecialchars($user['username']); ?>


</option>


<?php endforeach; ?>


</select>


<br>
<br>




<label>
    Status
</label>

<br>


<select name="status">


<option

value="draft"

<?= 
$post['status'] === 'draft'
? 'selected'
: '';
?>

>

Draft

</option>



<option

value="published"

<?= 
$post['status'] === 'published'
? 'selected'
: '';
?>

>

Published

</option>


</select>



<br>
<br>




<button type="submit">

Update Post

</button>



</form>



<script>

function previewImage(select)
{
    let option = select.options[select.selectedIndex];

    let image = option.getAttribute('data-image');

    let preview = document.getElementById('image-preview');


    if(image)
    {
        preview.src = image;
        preview.style.display = 'block';
    }
    else
    {
        preview.src = '';
        preview.style.display = 'none';
    }
}

</script>