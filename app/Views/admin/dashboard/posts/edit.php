<?php
/** @var array $post */
/** @var array $users */
/** @var array $images */
?>

<div class="admin-card">

    <a href="/admin/posts" class="blue-button">
        ← Back to Posts
    </a>

    <h1>Edit Post</h1>

    <form method="POST" action="/admin/posts/update">

        <input
            type="hidden"
            name="id"
            value="<?= $post['id']; ?>">

        <div class="form-group">

            <label>
                Title
            </label>

            <input
                type="text"
                name="title"
                value="<?= htmlspecialchars($post['title']); ?>"
                required>

        </div>

        <div class="form-group">

            <label>
                Slug
            </label>

            <input
                type="text"
                name="slug"
                value="<?= htmlspecialchars($post['slug']); ?>"
                required>

        </div>

        <div class="form-group">

            <label>
                Content
            </label>

            <textarea
                name="content"
                rows="10"
                required><?= htmlspecialchars($post['content']); ?></textarea>

        </div>

        <div class="form-group">

            <label>
                Author
            </label>

            <select name="user_id">

                <?php foreach ($users as $user): ?>

                    <option
                        value="<?= $user['id']; ?>"
                        <?= $user['id'] == $post['user_id'] ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($user['username']); ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-group">

            <label>
                Current Featured Image
            </label>

            <?php if (!empty($post['image_path'])): ?>

                <p>

                    <img
                        src="<?= htmlspecialchars($post['image_path']); ?>"
                        alt=""
                        width="180"
                        style="border-radius:6px;">

                </p>

                <p>
                    <?= htmlspecialchars($post['image_filename']); ?>
                </p>

            <?php else: ?>

                <p>No featured image selected.</p>

            <?php endif; ?>

        </div>

        <div class="form-group">

            <label>
                Select Featured Image
            </label>

            <select
                name="featured_media_id"
                id="featured_media_id"
                onchange="previewImage(this)">

                <option value="">
                    -- No Image --
                </option>

                <?php foreach ($images as $image): ?>

                    <option
                        value="<?= $image['id']; ?>"
                        data-image="<?= htmlspecialchars($image['filepath']); ?>"
                        <?= $image['id'] == $post['featured_media_id'] ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($image['filename']); ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-group">

            <label>
                New Image Preview
            </label>

            <img
                id="image-preview"
                src=""
                alt=""
                width="180"
                style="display:none;border-radius:6px;">

        </div>

        <div class="form-group">

            <label>
                Status
            </label>

            <select name="status">

                <option
                    value="draft"
                    <?= $post['status'] === 'draft' ? 'selected' : ''; ?>>

                    Draft

                </option>

                <option
                    value="published"
                    <?= $post['status'] === 'published' ? 'selected' : ''; ?>>

                    Published

                </option>

            </select>

        </div>

        <button
            class="green-button"
            type="submit">

            Update Post

        </button>

        <a
            href="/admin/posts"
            class="red-button">

            Cancel

        </a>

    </form>

</div>

<script>

function previewImage(select)
{
    const option = select.options[select.selectedIndex];

    const image = option.getAttribute('data-image');

    const preview = document.getElementById('image-preview');

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