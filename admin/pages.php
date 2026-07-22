<?php
require 'includes/auth.php';
require '../includes/db.php';
// Load all media
$mediaResult = $conn->query("
    SELECT id, filename, original_name, alt_text
    FROM media
    ORDER BY original_name
");

$mediaItems = [];

while ($row = $mediaResult->fetch_assoc()) {
    $mediaItems[] = $row;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


$result = $conn->query("SELECT * FROM pages ORDER BY slug");
// Pagination

// Pagination settings
$perPage = 5;

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($currentPage < 1) {
    $currentPage = 1;
}

// Count total pages
$countResult = $conn->query("SELECT COUNT(*) AS total FROM pages");
$totalPages = $countResult->fetch_assoc()['total'];

// Calculate offset
$offset = ($currentPage - 1) * $perPage;


// Get pages for current page
$stmt = $conn->prepare("
    SELECT * 
    FROM pages 
    ORDER BY slug
    LIMIT ? OFFSET ?
");

$stmt->bind_param("ii", $perPage, $offset);

$stmt->execute();

$result = $stmt->get_result();

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
<form action="save_page.php" method="POST">
<input 
    type="hidden" 
    name="id" 
    value="<?= $page['id'] ?>">
<h3>
<?= htmlspecialchars((string)($page['slug'] ?? ''), ENT_QUOTES, 'UTF-8') ?>

</h3>


<label>Heading</label>
<input 
    type="text" 
    name="main_heading"
    value="<?= htmlspecialchars((string)($page['main_heading'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
>


<label>Content</label>
<textarea 
    name="main_content"
    rows="8"><?= htmlspecialchars((string)($page['main_content'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
</textarea>

<!--SEO Features Start-->
<hr>

<h3>SEO Settings</h3>

<label>SEO Title</label>
<input
    type="text"
    name="seo_title"
    value="<?= htmlspecialchars($page['seo_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
>


<label>SEO Description</label>

<textarea
    name="seo_description"
    rows="4"><?= htmlspecialchars($page['seo_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<?php if ($page['slug'] !== 'footer'): ?>
<label>Hero Title</label>
<input
    type="text"
    name="hero_title"
    value="<?= htmlspecialchars($page['hero_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
<label>Current Image</label>
<br>

<?php
// Find the selected media item for this page
$selectedImage = null;

foreach ($mediaItems as $image) {
    if ((int)$image['id'] === (int)($page['hero_media_id'] ?? 0)) {
        $selectedImage = $image;
        break;
    }
}
?>
<?php if ($selectedImage): ?>

<img
    src="../uploads/<?= htmlspecialchars($selectedImage['filename']) ?>"
    alt="<?= htmlspecialchars($selectedImage['alt_text']) ?>"
    style="max-width:300px;display:block;margin-bottom:15px;">

<?php else: ?>

<p><em>No image selected.</em></p>

<?php endif; ?>
<!--Image Picker-->
<label>Hero Image</label>

<select name="hero_media_id">

    <option value="">-- No Image --</option>

    <?php foreach ($mediaItems as $image): ?>

        <option
            value="<?= $image['id'] ?>"
<?= ((int)($page['hero_media_id'] ?? 0) === (int)$image['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($image['original_name']) ?>

        </option>

    <?php endforeach; ?>

</select>


<label>Image Alt Text</label>

<input
    type="text"
    value="<?= htmlspecialchars($selectedImage['alt_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    readonly>

<label>Hero Subtitle</label>
<input
    type="text"
    name="hero_subtitle"
    value="<?= htmlspecialchars($page['hero_subtitle'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
<?php if ($page['slug'] === 'footer'): ?>

<hr>

<h3>Footer Columns</h3>

<label>Column 1 Title</label>
<input
    type="text"
    name="column1_title"
    value="<?= htmlspecialchars($page['column1_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

<label>Column 1 Content</label>
<textarea
    name="column1_content"
    rows="4"><?= htmlspecialchars($page['column1_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<label>Column 2 Title</label>
<input
    type="text"
    name="column2_title"
    value="<?= htmlspecialchars($page['column2_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

<label>Column 2 Content</label>
<textarea
    name="column2_content"
    rows="4"><?= htmlspecialchars($page['column2_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<label>Column 3 Title</label>
<input
    type="text"
    name="column3_title"
    value="<?= htmlspecialchars($page['column3_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

<label>Column 3 Content</label>
<textarea
    name="column3_content"
    rows="4"><?= htmlspecialchars($page['column3_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<label>Column 4 Title</label>
<input
    type="text"
    name="column4_title"
    value="<?= htmlspecialchars($page['column4_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

<label>Column 4 Content</label>
<textarea
    name="column4_content"
    rows="4"><?= htmlspecialchars($page['column4_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<label>Column 5 Title</label>
<input
    type="text"
    name="column5_title"
    value="<?= htmlspecialchars($page['column5_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
<!--Copyright_text-->
<label>Column  Content</label>
<textarea
    name="column5_content"
    rows="4"><?= htmlspecialchars($page['column5_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

<?php endif; ?>

<button class="button" type="submit">
Save Changes
</button>
</form>




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
<!--Pagination-->
<div class="pagination">

<?php if ($currentPage > 1): ?>

<a href="?page=<?= $currentPage - 1 ?>" class="button">
Previous
</a>

<?php endif; ?>


<?php for ($i = 1; $i <= ceil($totalPages / $perPage); $i++): ?>

<a 
href="?page=<?= $i ?>" 
class="button <?= ($i == $currentPage) ? 'active-page' : '' ?>"
>
<?= $i ?>
</a>

<?php endfor; ?>


<?php if ($currentPage < ceil($totalPages / $perPage)): ?>

<a href="?page=<?= $currentPage + 1 ?>" class="button">
Next
</a>

<?php endif; ?>

</div>


</main>



