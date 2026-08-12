<div class="admin-card">

    <h1>
        Media Details
    </h1>

    <p>
        <a href="/admin/media" class="blue-button">
            ← Back to Media Library
        </a>
    </p>

    <div class="media-detail-image">

        <img
            src="<?= htmlspecialchars(
                $image['filepath'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            alt="<?= htmlspecialchars(
                $image['filename'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            style="
                max-width: 700px;
                max-height: 500px;
                width: auto;
                height: auto;
                display: block;
            "
        >

    </div>

    <div class="media-detail-info">

        <h2>
            <?= htmlspecialchars(
                $image['filename'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </h2>

        <p>
            <strong>ID:</strong>
            <?= (int) $image['id'] ?>
        </p>

        <p>
            <strong>Filename:</strong>
            <?= htmlspecialchars(
                $image['filename'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

        <p>
            <strong>File path:</strong>
            <?= htmlspecialchars(
                $image['filepath'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

        <p>
            <strong>MIME type:</strong>
            <?= htmlspecialchars(
                $image['mime_type'] ?? 'Unknown',
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

        <p>
            <strong>Uploaded:</strong>
            <?= htmlspecialchars(
                $image['uploaded_at'] ?? 'Unknown',
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

        <div class="media-actions">

            <a
                href="<?= htmlspecialchars(
                    $image['filepath'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="green-button"
            >
                Open Image
            </a>

            <form
                method="POST"
                action="/admin/media/delete"
                style="display:inline;"
                onsubmit="return confirm('Delete this image?');"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(
                        $csrfToken,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $image['id'] ?>"
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