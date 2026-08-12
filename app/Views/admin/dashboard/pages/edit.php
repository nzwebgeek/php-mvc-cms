<div class="admin-card">
    <form method="POST" action="/admin/pages/update">

     <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
    >

    <input
        type="hidden"
        name="id"
        value="<?= $page['id']; ?>">


<h2>General</h2>


<div class="form-group">

<label>
    Title
</label>

<input
    type="text"
    name="title"
    value="<?= htmlspecialchars($page['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
    required>

</div>



<div class="form-group">

<label>
    Slug
</label>

<input
    type="text"
    name="slug"
    value="<?= htmlspecialchars($page['slug']?? '', ENT_QUOTES, 'UTF-8'); ?>">

</div>



<div class="form-group">

<label>
    Status
</label>

<select name="status">

<option
value="published"
<?= $page['status'] === 'published' ? 'selected' : ''; ?>>
Published
</option>

<option
value="draft"
<?= $page['status'] === 'draft' ? 'selected' : ''; ?>>
Draft
</option>

</select>

</div>


<hr>


<h2>Hero Section</h2>


<div class="form-group">

<label>
    Hero Title
</label>

<input
type="text"
name="hero_title"
value="<?= htmlspecialchars($page['hero_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

</div>



<div class="form-group">

<label>
    Hero Subtitle
</label>

<textarea
name="hero_subtitle"
rows="3"><?= htmlspecialchars($page['hero_subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

</div>




<div class="form-group">

<label>
    Hero Image
</label>


<select
name="hero_media_id"
onchange="previewHero(this)">


<option value="">
-- Select Hero Image --
</option>


<?php foreach ($images as $image): ?>

<option
value="<?= $image['id']; ?>"
data-image="/<?= htmlspecialchars($image['filepath']?? '', ENT_QUOTES, 'UTF-8'); ?>"
<?= ($page['hero_media_id'] ?? null) == $image['id']
? 'selected'
: ''; ?>>

<?= htmlspecialchars($image['filename']?? '', ENT_QUOTES, 'UTF-8'); ?>

</option>


<?php endforeach; ?>


</select>

</div>




<div class="form-group">

    <label>
        Current Hero Image
    </label>

    <br>

  <?php if (!empty($page['image_path'])): ?>

    <img
        src="/<?= htmlspecialchars($page['image_path']?? '', ENT_QUOTES, 'UTF-8'); ?>"
        alt="<?= htmlspecialchars($page['hero_image_alt'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
        style="max-width:250px;border:1px solid #ccc;padding:5px;">

<?php else: ?>

    <p>No hero image selected.</p>

<?php endif; ?>

</div>




<div class="form-group">

<label>
    New Image Preview
</label>

<br>

<img
id="hero-preview"
src=""
alt=""
style="display:none;max-width:250px;border:1px solid #ccc;padding:5px;">

</div>





<div class="form-group">

<label>
    Hero Image Alt Text
</label>


<input
type="text"
name="hero_image_alt"
value="<?= htmlspecialchars($page['hero_image_alt'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">


</div>



<hr>



<h2>Main Content</h2>


<div class="form-group">

<label>
Main Heading
</label>


<input
type="text"
name="main_heading"
value="<?= htmlspecialchars($page['main_heading']?? '', ENT_QUOTES, 'UTF-8'); ?>">


</div>



<div class="form-group">

<label>
Main Content
</label>


<textarea
name="main_content"
rows="8"><?= htmlspecialchars($page['main_content']?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>


</div>



<hr>


<?php for($i = 1; $i <= 5; $i++): ?>


<h2>
Content Section <?= $i ?>
</h2>



<div class="form-group">

<label>
Section <?= $i ?> Heading
</label>


<input
type="text"
name="column<?= $i ?>_title"
value="<?= htmlspecialchars($page['column'.$i.'_title']?? '', ENT_QUOTES, 'UTF-8'); ?>">


</div>




<div class="form-group">

<label>
Section <?= $i ?> Content
</label>


<textarea
name="column<?= $i ?>_content"
rows="5"><?= htmlspecialchars($page['column'.$i.'_content']?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>


</div>


<hr>


<?php endfor; ?>



<h2>
SEO
</h2>


<div class="form-group">

<label>
SEO Title
</label>


<input
type="text"
name="seo_title"
value="<?= htmlspecialchars($page['seo_title']?? '', ENT_QUOTES, 'UTF-8'); ?>">


</div>



<div class="form-group">

<label>
SEO Description
</label>


<textarea
name="seo_description"
rows="3"><?= htmlspecialchars($page['seo_description']?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>


</div>



<br>



<button
class="green-button"
type="submit">

Update Page

</button>



<a
href="/admin/pages"
class="red-button">

Cancel

</a>



</form>
</div>



<script>

function previewHero(select)
{

    let option = select.options[select.selectedIndex];

    let image = option.dataset.image;

    let preview = document.getElementById('hero-preview');


    if(image)
    {
        preview.src = image;
        preview.style.display = "block";
    }
    else
    {
        preview.style.display = "none";
    }

}

</script>