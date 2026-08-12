<h1>Create New Page</h1>

<div class="admin-card">

<form method="POST" action="/admin/pages/store">
    
    <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
        >


    <h2>General</h2>

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
            placeholder="about">

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

    <hr>

    <h2>Hero Section</h2>

    <div class="form-group">

        <label>
            Hero Title
        </label>

        <input
            type="text"
            name="hero_title">

    </div>

    <div class="form-group">

        <label>
            Hero Subtitle
        </label>

        <textarea
            name="hero_subtitle"
            rows="3"></textarea>

    </div>
<div class="form-group">

    <label>Hero Image</label>

    <select name="hero_media_id" onchange="previewHero(this)">

        <option value="">
            -- Select Hero Image --
        </option>

        <?php foreach ($images as $image): ?>

            <option
                value="<?= (int)$image['id']; ?>"
                data-image="<?= htmlspecialchars($image['filepath'], ENT_QUOTES, 'UTF-8'); ?>"
            >
                <?= htmlspecialchars($image['filename'], ENT_QUOTES, 'UTF-8'); ?>
            </option>

        <?php endforeach; ?>

    </select>

</div>

<div class="form-group">

    <img
        id="hero-preview"
        src=""
        alt="Hero image preview"
        style="display:none; max-width:250px;"
    >

</div>
    <div class="form-group">

        <label>
            Hero Image Alt Text
        </label>

        <input
            type="text"
            name="hero_image_alt">

    </div>

    <hr>

    <h2>Main Content</h2>

    <div class="form-group">

        <label>
            Main Heading
        </label>

        <input
            type="text"
            name="main_heading">

    </div>

    <div class="form-group">

        <label>
            Main Content
        </label>

        <textarea
            name="main_content"
            rows="8"></textarea>

    </div>

    <hr>

    <h2>Content Section 1</h2>

    <div class="form-group">

        <label>
            Section 1 Heading
        </label>

        <input
            type="text"
            name="column1_title">

    </div>

    <div class="form-group">

        <label>
            Section 1 Content
        </label>

        <textarea
            name="column1_content"
            rows="5"></textarea>

    </div>

    <hr>

    <h2>Content Section 2</h2>

    <div class="form-group">

        <label>
            Section 2 Heading
        </label>

        <input
            type="text"
            name="column2_title">

    </div>

    <div class="form-group">

        <label>
            Section 2 Content
        </label>

        <textarea
            name="column2_content"
            rows="5"></textarea>

    </div>

    <hr>

    <h2>Content Section 3</h2>

    <div class="form-group">

        <label>
            Section 3 Heading
        </label>

        <input
            type="text"
            name="column3_title">

    </div>

    <div class="form-group">

        <label>
            Section 3 Content
        </label>

        <textarea
            name="column3_content"
            rows="5"></textarea>

    </div>

    <hr>

    <h2>Content Section 4</h2>

    <div class="form-group">

        <label>
            Section 4 Heading
        </label>

        <input
            type="text"
            name="column4_title">

    </div>

    <div class="form-group">

        <label>
            Section 4 Content
        </label>

        <textarea
            name="column4_content"
            rows="5"></textarea>

    </div>

    <hr>

    <h2>Content Section 5</h2>

    <div class="form-group">

        <label>
            Section 5 Heading
        </label>

        <input
            type="text"
            name="column5_title">

    </div>

    <div class="form-group">

        <label>
            Section 5 Content
        </label>

        <textarea
            name="column5_content"
            rows="5"></textarea>

    </div>

    <hr>

    <h2>SEO</h2>

    <div class="form-group">

        <label>
            SEO Title
        </label>

        <input
            type="text"
            name="seo_title">

    </div>

    <div class="form-group">

        <label>
            SEO Description
        </label>

        <textarea
            name="seo_description"
            rows="3"></textarea>

    </div>

    <button
        class="green-button"
        type="submit">

        Create Page

    </button>

    <a
        href="/admin/pages"
        class="red-button">

        Cancel

    </a>

</form>

</div>