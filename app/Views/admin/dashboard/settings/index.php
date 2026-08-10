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


                <div class="form-group">

                    <label for="site_name">
                        Site Name
                    </label>

                    <input
                        type="text"
                        id="site_name"
                        name="site_name"
                        value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="contact_email">
                        Contact Email
                    </label>

                    <input
                        type="email"
                        id="contact_email"
                        name="contact_email"
                        value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="contact_phone">
                        Contact Phone
                    </label>

                    <input
                        type="text"
                        id="contact_phone"
                        name="contact_phone"
                        value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="copyright_text">
                        Copyright Text
                    </label>

                    <input
                        type="text"
                        id="copyright_text"
                        name="copyright_text"
                        value="<?= htmlspecialchars($settings['copyright_text'] ?? '') ?>"
                    >

                </div>


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


                <div class="form-group">

                    <label for="admin_email">
                        Admin Email
                    </label>

                    <input
                        type="email"
                        id="admin_email"
                        name="admin_email"
                        value="<?= htmlspecialchars($settings['admin_email'] ?? '') ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="seo_title">
                        SEO Title
                    </label>

                    <input
                        type="text"
                        id="seo_title"
                        name="seo_title"
                        value="<?= htmlspecialchars($settings['seo_title'] ?? '') ?>"
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
                    ><?= htmlspecialchars($settings['seo_description'] ?? '') ?></textarea>

                </div>


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


                <button
                    type="submit"
                    class="green-button"
                >
                    Save Settings
                </button>

            </form>

        </div>


        <?php if ($blogSettings): ?>

            <div class="admin-card">

                <h2>Blog Settings</h2>


                <div class="blog-setting">

                    <strong>
                        Image One
                    </strong>

                    <span>
                        <?= htmlspecialchars($blogSettings['image_one'] ?? '') ?>
                    </span>

                </div>


                <div class="blog-setting">

                    <strong>
                        Image Two
                    </strong>

                    <span>
                        <?= htmlspecialchars($blogSettings['image_two'] ?? '') ?>
                    </span>

                </div>

            </div>

        <?php else: ?>

            <div class="admin-card">

                <p>
                    No blog settings found.
                </p>

            </div>

        <?php endif; ?>


    <?php else: ?>

        <div class="admin-card">

            <p>
                No site settings found.
            </p>

        </div>

    <?php endif; ?>

</main>