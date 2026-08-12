<div class="admin-card">

    <h1>Create Post</h1>

    <form method="POST" action="/admin/posts/store">

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
        >

        <!-- Basic Post Information -->

        <h2>Post Information</h2>

        <div class="form-group">
            <label for="title">Title</label>

            <input
                type="text"
                id="title"
                name="title"
                required
            >
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>

            <input
                type="text"
                id="slug"
                name="slug"
                required
            >
        </div>

        <div class="form-group">
            <label for="content">Content</label>

            <textarea
                id="content"
                name="content"
                rows="10"
                required
            ></textarea>
        </div>

        <div class="form-group">
            <label for="user_id">Author</label>

            <select
                id="user_id"
                name="user_id"
                required
            >

                <option value="">
                    -- Select Author --
                </option>

                <?php foreach ($users as $user): ?>

                    <option value="<?= (int) $user['id'] ?>">
                        <?= htmlspecialchars(
                            $user['username'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">

            <label for="featured_media_id">
                Featured Image
            </label>

            <select
                id="featured_media_id"
                name="featured_media_id"
            >

                <option value="">
                    -- Select Image --
                </option>

                <?php foreach ($images as $image): ?>

                    <option value="<?= (int) $image['id'] ?>">
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

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option value="draft">
                    Draft
                </option>

                <option value="published">
                    Published
                </option>

            </select>

        </div>


        <!-- Hero Section -->

        <h2>Hero Section</h2>

        <div class="form-group">

            <label for="hero_title">
                Hero Title
            </label>

            <input
                type="text"
                id="hero_title"
                name="hero_title"
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
            >

        </div>


        <!-- Main Section -->

        <h2>Main Section</h2>

        <div class="form-group">

            <label for="main_heading">
                Main Heading
            </label>

            <input
                type="text"
                id="main_heading"
                name="main_heading"
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
            ></textarea>

        </div>


        <!-- Columns -->

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
                ></textarea>

            </div>

        <?php endfor; ?>


        <!-- SEO -->

        <h2>SEO</h2>

        <div class="form-group">

            <label for="seo_title">
                SEO Title
            </label>

            <input
                type="text"
                id="seo_title"
                name="seo_title"
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
            ></textarea>

        </div>


        <!-- Actions -->

        <button
            class="green-button"
            type="submit"
        >
            Create Post
        </button>

        <a
            href="/admin/posts"
            class="red-button"
        >
            Cancel
        </a>

    </form>

</div>