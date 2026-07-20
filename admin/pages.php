<?php
require 'includes/auth.php';
require __DIR__ . '/includes/db.php';


$result = $conn->query("SELECT * FROM pages ORDER BY slug");

?>

<main>

<h1>Edit Website Pages</h1>

<?php if (isset($_GET['updated'])): ?>
    <div class="success-message">
        ✅ Page updated successfully.
    </div>
<?php endif; ?>

<?php while($page = $result->fetch_assoc()): ?>

<div class="card">
<form action="save_page.php" method="POST" enctype="multipart/form-data">
<input 
    type="hidden" 
    name="id" 
    value="<?= $page['id'] ?>"
>
<input
    type="hidden"
    name="existing_image"
    value="<?= htmlspecialchars($page['hero_image']) ?>"
>

<h3>
<?= htmlspecialchars($page['slug']) ?>
</h3>


<label>Heading</label>
<input 
    type="text" 
    name="main_heading"
    value="<?= htmlspecialchars($page['main_heading']) ?>"
>


<label>Content</label>
<textarea 
    name="main_content"
    rows="8"
><?= htmlspecialchars($page['main_content']) ?></textarea>


<label>Hero Title</label>
<input 
    type="text" 
    name="hero_title"
    value="<?= htmlspecialchars($page['hero_title']) ?>"
>

<!--Fetch Images-->
<label>Current Image</label>
<br>
<!--Placeholder if empty-->
<?php if (!empty($page['hero_image'])): ?>

    <img
        src="<?= htmlspecialchars($page['hero_image']) ?>"
        alt="<?= htmlspecialchars($page['hero_image_alt']) ?>"
        style="max-width:300px;display:block;margin-bottom:15px;">


<?php else: ?>

    <p><em>No image uploaded.</em></p>

<?php endif; ?>
<label>Upload New Image</label>

<input type="file" name="hero_image">


<?php if (!empty($page['hero_image'])): ?>

<label>
    <input type="checkbox" name="remove_image" value="1">
    Remove current image
</label>

<?php endif; ?>


<label>Image Alt Text</label>

<input
    type="text"
    name="hero_image_alt"
    value="<?= htmlspecialchars($page['hero_image_alt']) ?>">

<label>Hero Subtitle</label>
<input 
    type="text" 
    name="hero_subtitle"
    value="<?= htmlspecialchars($page['hero_subtitle']) ?>"
>


<button class="button" type="submit">
Save Changes
</button>
</form>



<?php if (!empty($page['hero_image'])): ?>

<form 
    action="delete-image.php" 
    method="POST"
    onsubmit="return confirm('Delete this image?');"
>

    <input 
        type="hidden" 
        name="id" 
        value="<?= $page['id'] ?>"
    >

    <input 
        type="hidden" 
        name="image" 
        value="<?= htmlspecialchars($page['hero_image']) ?>"
    >

    <button 
        class="button"
        type="submit"
        style="background:red;color:white;"
    >
        Delete Image
    </button>

</form>

<?php endif; ?>

<form action="delete-page.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">

    <input 
        type="hidden" 
        name="id" 
        value="<?= $page['id'] ?>"
    >

    <button class="button" type="submit" style="background:red;color:white;">
        Delete Page
    </button>

</form>

</div>


<?php endwhile; ?>


</main>


