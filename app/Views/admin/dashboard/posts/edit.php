<?php
/**
 * @var array $post
 * @var array $users
 * @var array $images
 * @var string $csrfToken
*/
?>

<div class="admin-card">

    <a href="/admin/posts" class="blue-button">
        ← Back to Posts
    </a>

    <h1>Edit Post</h1>

    <form method="POST" action="/admin/posts/update">

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
        >

        <input
            type="hidden"
            name="id"
            value="<?= (int) $post['id'] ?>"
        >


        <!-- =========================================================
             Basic Post Information
        ========================================================== -->

        <h2>Post Information</h2>

        <div class="form-group">

            <label for="title">
                Title
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars(
                    $post['title'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                required
            >

        </div>


        <div class="form-group">

            <label for="slug">
                Slug
            </label>

            <input
                type="text"
                id="slug"
                name="slug"
                value="<?= htmlspecialchars(
                    $post['slug'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                required
            >

        </div>


        <div class="form-group">

            <label for="content">
                Content
            </label>

            <textarea
                id="content"
                name="content"
                rows="10"
                required
            ><?= htmlspecialchars(
                $post['content'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?></textarea>

        </div>


        <div class="form-group">

            <label for="user_id">
                Author
            </label>

            <select
                id="user_id"
                name="user_id"
                required
            >

                <?php foreach ($users as $user): ?>

                    <option
                        value="<?= (int) $user['id'] ?>"
                        <?= (int) $user['id'] === (int) ($post['user_id'] ?? 0)
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars(
                            $user['username'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- =========================================================
             Featured Image
        ========================================================== -->

        <h2>Featured Image</h2>

        <div class="form-group">

            <label>
                Current Featured Image
            </label>

            <?php if (!empty($post['image_path'])): ?>

                <p>

                    <img
                        src="<?= htmlspecialchars(
                            $post['image_path'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $post['hero_image_alt'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        width="180"
                        style="border-radius:6px;"
                    >

                </p>

                <?php if (!empty($post['image_filename'])): ?>

                    <p>
                        <?= htmlspecialchars(
                            $post['image_filename'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                <?php endif; ?>

            <?php else: ?>

                <p>No featured image selected.</p>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="featured_media_id">
                Select Featured Image
            </label>

            <select
                name="featured_media_id"
                id="featured_media_id"
                onchange="previewImage(this)"
            >

                <option value="">
                    -- No Image --
                </option>

                <?php foreach ($images as $image): ?>

                    <option
                        value="<?= (int) $image['id'] ?>"
                        data-image="<?= htmlspecialchars(
                            $image['filepath'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        <?= (int) $image['id'] === (int) ($post['featured_media_id'] ?? 0)
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars(
                            $image['filename'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
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
                style="display:none;border-radius:6px;"
            >

        </div>


        <!-- =========================================================
             Hero Section
        ========================================================== -->

        <h2>Hero Section</h2>

        <div class="form-group">

            <label for="hero_title">
                Hero Title
            </label>

            <input
                type="text"
                id="hero_title"
                name="hero_title"
                value="<?= htmlspecialchars(
                    $post['hero_title'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

        </div>


        <div class="form-group">

            <label for="hero_subtitle">
                Hero Subtitle
            </label>

            <input
                type="text"
                id="hero_subtitle"
                name="hero_subtitle"
                value="<?= htmlspecialchars(
                    $post['hero_subtitle'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

        </div>


        <div class="form-group">

            <label for="hero_image_alt">
                Hero Image Alt Text
            </label>

            <input
                type="text"
                id="hero_image_alt"
                name="hero_image_alt"
                value="<?= htmlspecialchars(
                    $post['hero_image_alt'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

        </div>


        <!-- =========================================================
             Main Section
        ========================================================== -->

        <h2>Main Section</h2>

        <div class="form-group">

            <label for="main_heading">
                Main Heading
            </label>

            <input
                type="text"
                id="main_heading"
                name="main_heading"
                value="<?= htmlspecialchars(
                    $post['main_heading'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

        </div>


        <div class="form-group">

            <label for="main_content">
                Main Content
            </label>

            <textarea
                id="main_content"
                name="main_content"
                rows="8"
            ><?= htmlspecialchars(
                $post['main_content'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?></textarea>

        </div>


        <!-- =========================================================
             Columns
        ========================================================== -->

        <h2>Columns</h2>

        <?php for ($i = 1; $i <= 5; $i++): ?>

            <div class="form-group">

                <label for="column<?= $i ?>_title">
                    Column <?= $i ?> Title
                </label>

                <input
                    type="text"
                    id="column<?= $i ?>_title"
                    name="column<?= $i ?>_title"
                    value="<?= htmlspecialchars(
                        $post["column{$i}_title"] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

            </div>


            <div class="form-group">

                <label for="column<?= $i ?>_content">
                    Column <?= $i ?> Content
                </label>

                <textarea
                    id="column<?= $i ?>_content"
                    name="column<?= $i ?>_content"
                    rows="6"
                ><?= htmlspecialchars(
                    $post["column{$i}_content"] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>

            </div>

        <?php endfor; ?>


        <!-- =========================================================
             SEO
        ========================================================== -->

        <h2>SEO</h2>

        <div class="form-group">

            <label for="seo_title">
                SEO Title
            </label>

            <input
                type="text"
                id="seo_title"
                name="seo_title"
                value="<?= htmlspecialchars(
                    $post['seo_title'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

        </div>


        <div class="form-group">

            <label for="seo_description">
                SEO Description
            </label>

            <textarea
                id="seo_description"
                name="seo_description"
                rows="4"
            ><?= htmlspecialchars(
                $post['seo_description'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?></textarea>

        </div>


        <!-- =========================================================
             Status
        ========================================================== -->

        <h2>Publishing</h2>

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="draft"
                    <?= ($post['status'] ?? '') === 'draft'
                        ? 'selected'
                        : '' ?>
                >
                    Draft
                </option>

                <option
                    value="published"
                    <?= ($post['status'] ?? '') === 'published'
                        ? 'selected'
                        : '' ?>
                >
                    Published
                </option>

            </select>

        </div>


        <!-- =========================================================
             Actions
        ========================================================== -->

        <button
            class="green-button"
            type="submit"
        >
            Update Post
        </button>

        <a
            href="/admin/posts"
            class="red-button"
        >
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

    if (image) {
        preview.src = image;
        preview.style.display = 'block';
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const select = document.getElementById('featured_media_id');

    if (select) {
        previewImage(select);
    }

});

</script>