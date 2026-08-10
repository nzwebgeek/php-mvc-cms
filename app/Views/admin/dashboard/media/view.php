<h1>
    Media Details
</h1>

<p>
    <a href="/admin/media">
        ← Back to Media Library
    </a>
</p>


<div class="media-detail-image">

    <img
        src="<?= htmlspecialchars($image['filepath']) ?>"
        alt="<?= htmlspecialchars($image['filename']) ?>"
        style="max-width: 700px; max-height: 500px; width: auto; height: auto; display: block;"
    >

</div>


    <div class="media-detail-info">

        <h2>
            <?= htmlspecialchars($image['filename']) ?>
        </h2>


        <p>
            <strong>ID:</strong>
            <?= (int)$image['id'] ?>
        </p>


        <p>
            <strong>Filename:</strong>
            <?= htmlspecialchars($image['filename']) ?>
        </p>


        <p>
            <strong>File path:</strong>
            <?= htmlspecialchars($image['filepath']) ?>
        </p>


        <p>
            <strong>MIME type:</strong>
            <?= htmlspecialchars($image['mime_type'] ?? 'Unknown') ?>
        </p>


        <p>
            <strong>Uploaded:</strong>
            <?= htmlspecialchars($image['uploaded_at'] ?? 'Unknown') ?>
        </p>


        <div>

            <a
                href="<?= htmlspecialchars($image['filepath']) ?>"
                target="_blank"
                rel="noopener"
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
                    value="<?= htmlspecialchars($csrfToken) ?>"
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