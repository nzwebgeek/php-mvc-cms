<div class="admin-card">

    <h1>
        Upload Image
    </h1>

    <a class="blue-button" href="/admin/media">
        ← Back to Media
    </a>

</div>


<div class="admin-card">

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


        <div class="form-group">

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
            class="green-button"
            type="submit"
        >
            Upload Image
        </button>

    </form>

</div>