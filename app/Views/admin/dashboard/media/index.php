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

<div class="admin-card">
    <h1>
    Media Library
</h1>


<a
    class="green-button"
    href="/admin/media/upload"
>
    + Upload Image
</a>


<?php if (empty($images)): ?>

    <p>
        No images have been uploaded yet.
    </p>

<?php else: ?>

    <div class="media-grid">

        <?php foreach ($images as $image): ?>

            <div class="media-card">

                <div class="media-image">

                    <img
                        src="<?= htmlspecialchars($image['filepath']) ?>"
                        alt="<?= htmlspecialchars($image['filename']) ?>"
                    >

                </div>


                <div class="media-info">

                    <strong>
                        <?= htmlspecialchars($image['filename']) ?>
                    </strong>


                    <small>
                        ID: <?= (int)$image['id'] ?>
                    </small>


                    <div class="media-actions">

                        <!-- View -->
                      <a
                        href="/admin/media/view?id=<?= (int) $image['id'] ?>"
                        class="blue-button"
                    >
                        View
                    </a>


                        <!-- Delete -->
                        <form
                            method="POST"
                            action="/admin/media/delete"
                            onsubmit="return confirm('Delete this image?');"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars(
                                $csrfToken ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            >


                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int)$image['id'] ?>"
                            >


                            <button
                                type="submit"
                                class="red-button"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>
</div>