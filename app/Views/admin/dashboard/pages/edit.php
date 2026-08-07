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
                data-image="<?= htmlspecialchars($image['filepath']); ?>"
                <?= ($page['hero_media_id'] ?? null) == $image['id']
                    ? 'selected'
                    : ''; ?>>

                <?= htmlspecialchars($image['filename']); ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>

<?php if (!empty($page['image_path'])): ?>

<div class="form-group">

    <label>
        Current Hero Image
    </label>

    <br>

    <img
        src="<?= htmlspecialchars($page['image_path']); ?>"
        alt=""
        style="max-width:250px;">

</div>

<?php endif; ?>

<div class="form-group">

    <img
        id="hero-preview"
        src=""
        style="display:none;max-width:250px;">

</div>

<script>
function previewHero(select)
{
    const option = select.options[select.selectedIndex];
    const image = option.dataset.image;

    const preview = document.getElementById('hero-preview');

    if(image)
    {
        preview.src = image;
        preview.style.display = 'block';
    }
    else
    {
        preview.style.display = 'none';
    }
}
</script>