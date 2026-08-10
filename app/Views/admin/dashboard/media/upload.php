<h1>Upload Image</h1>

<?php if (!empty($_SESSION['error'])): ?>

    <div class="alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>


<form
    method="POST"
    action="/admin/media/upload"
    enctype="multipart/form-data"
>

    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken) ?>"
    >

    <div>
        <label for="image">
            Select Image
        </label>

        <input
            type="file"
            id="image"
            name="image"
            accept="image/*"
            required
        >
    </div>

    <br>

    <button
        type="submit"
        class="green-button"
    >
        Upload Image
    </button>

    <a href="/admin/media">
        Cancel
    </a>

</form>