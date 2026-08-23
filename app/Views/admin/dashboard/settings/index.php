<main>

    <?php if (!empty($_SESSION['success'])): ?>

        <div class="alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <?php if (!empty($_SESSION['error'])): ?>

        <div class="alert-error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <?php if ($settings): ?>

        <div class="admin-card">

            <h1>Site Settings</h1>


            <form
                method="POST"
                action="/admin/settings/update"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($csrfToken) ?>"
                >


                <!-- =====================================================
                     SITE NAME
                ====================================================== -->

                <div class="form-group">

                    <label for="site_name">
                        Site Name
                    </label>

                    <input
                        type="text"
                        id="site_name"
                        name="site_name"
                        value="<?= htmlspecialchars(
                            $settings['site_name'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     CONTACT EMAIL
                ====================================================== -->

                <div class="form-group">

                    <label for="contact_email">
                        Contact Email
                    </label>

                    <input
                        type="email"
                        id="contact_email"
                        name="contact_email"
                        value="<?= htmlspecialchars(
                            $settings['contact_email'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     CONTACT PHONE
                ====================================================== -->

                <div class="form-group">

                    <label for="contact_phone">
                        Contact Phone
                    </label>

                    <input
                        type="text"
                        id="contact_phone"
                        name="contact_phone"
                        value="<?= htmlspecialchars(
                            $settings['contact_phone'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     COPYRIGHT
                ====================================================== -->

                <div class="form-group">

                    <label for="copyright_text">
                        Copyright Text
                    </label>

                    <input
                        type="text"
                        id="copyright_text"
                        name="copyright_text"
                        value="<?= htmlspecialchars(
                            $settings['copyright_text'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     THEME
                ====================================================== -->

                <div class="form-group">

                    <label for="theme">
                        Theme
                    </label>

                    <select
                        id="theme"
                        name="theme"
                    >

                        <option
                            value="Light"
                            <?= ($settings['theme'] ?? '') === 'Light'
                                ? 'selected'
                                : '' ?>
                        >
                            Light
                        </option>

                        <option
                            value="Dark"
                            <?= ($settings['theme'] ?? '') === 'Dark'
                                ? 'selected'
                                : '' ?>
                        >
                            Dark
                        </option>

                    </select>

                </div>


                <!-- =====================================================
                     ADMIN EMAIL
                ====================================================== -->

                <div class="form-group">

                    <label for="admin_email">
                        Admin Email
                    </label>

                    <input
                        type="email"
                        id="admin_email"
                        name="admin_email"
                        value="<?= htmlspecialchars(
                            $settings['admin_email'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     SEO TITLE
                ====================================================== -->

                <div class="form-group">

                    <label for="seo_title">
                        SEO Title
                    </label>

                    <input
                        type="text"
                        id="seo_title"
                        name="seo_title"
                        value="<?= htmlspecialchars(
                            $settings['seo_title'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <!-- =====================================================
                     SEO DESCRIPTION
                ====================================================== -->

                <div class="form-group">

                    <label for="seo_description">
                        SEO Description
                    </label>

                    <textarea
                        id="seo_description"
                        name="seo_description"
                        rows="4"
                    ><?= htmlspecialchars(
                        $settings['seo_description'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?></textarea>

                </div>


                <!-- =====================================================
                     MAINTENANCE MODE
                ====================================================== -->

                <div class="settings-checkbox">

                    <label>

                        <input
                            type="checkbox"
                            name="maintenance_mode"
                            value="1"
                            <?= !empty($settings['maintenance_mode'])
                                ? 'checked'
                                : '' ?>
                        >

                        Maintenance Mode

                    </label>

                </div>


                <!-- =====================================================
                     BLOG FEATURED IMAGES
                ====================================================== -->

                <div class="settings-card">

                    <h2>Blog Featured Images</h2>

                    <p>
                        Select the two images that should appear at the
                        top of the public Blog page. These images are
                        independent of individual blog posts.
                    </p>


                    <!-- =================================================
                         FEATURED IMAGE 1
                    ================================================== -->

                    <div class="settings-field">

                        <label for="featured_image_1_id">
                            Featured Image 1
                        </label>

                        <select
                            name="featured_image_1_id"
                            id="featured_image_1_id"
                        >

                            <option value="">
                                -- No image selected --
                            </option>


                            <?php foreach ($images as $image): ?>

                                <option
                                    value="<?= (int) $image['id'] ?>"
                                    data-image="<?= htmlspecialchars(
                                        $image['filepath'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    <?= (
                                        (int)($settings['featured_image_1_id'] ?? 0)
                                        === (int)$image['id']
                                    )
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


                        <div class="blog-image-preview">

                            <img
                                id="featured-image-1-preview"
                                src="<?= htmlspecialchars(
                                    $settings['featured_image_1_path'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                alt="Featured Image 1 preview"
                                <?= empty($settings['featured_image_1_path'])
                                    ? 'style="display:none;"'
                                    : '' ?>
                            >

                        </div>

                    </div>


                    <!-- =================================================
                         FEATURED IMAGE 2
                    ================================================== -->

                    <div class="settings-field">

                        <label for="featured_image_2_id">
                            Featured Image 2
                        </label>

                        <select
                            name="featured_image_2_id"
                            id="featured_image_2_id"
                        >

                            <option value="">
                                -- No image selected --
                            </option>


                            <?php foreach ($images as $image): ?>

                                <option
                                    value="<?= (int) $image['id'] ?>"
                                    data-image="<?= htmlspecialchars(
                                        $image['filepath'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    <?= (
                                        (int)($settings['featured_image_2_id'] ?? 0)
                                        === (int)$image['id']
                                    )
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


                        <div class="blog-image-preview">

                            <img
                                id="featured-image-2-preview"
                                src="<?= htmlspecialchars(
                                    $settings['featured_image_2_path'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                alt="Featured Image 2 preview"
                                <?= empty($settings['featured_image_2_path'])
                                    ? 'style="display:none;"'
                                    : '' ?>
                            >

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     SAVE
                ====================================================== -->

                <button
                    type="submit"
                    class="green-button"
                >
                    Save Settings
                </button>

            </form>

        </div>


    <?php else: ?>

        <div class="admin-card">

            <p>
                No site settings found.
            </p>

        </div>

    <?php endif; ?>

</main>


<script>

function updateImagePreview(selectId, previewId)
{
    const select = document.getElementById(selectId);
    const preview = document.getElementById(previewId);

    if (!select || !preview) {
        return;
    }

    function update()
    {
        const option =
            select.options[select.selectedIndex];

        const imagePath =
            option.dataset.image || '';

        if (imagePath) {

            preview.src = imagePath;

            preview.style.display = 'block';

        } else {

            preview.removeAttribute('src');

            preview.style.display = 'none';
        }
    }

    select.addEventListener('change', update);

    update();
}


updateImagePreview(
    'featured_image_1_id',
    'featured-image-1-preview'
);


updateImagePreview(
    'featured_image_2_id',
    'featured-image-2-preview'
);

</script>