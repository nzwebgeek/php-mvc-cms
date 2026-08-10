<div class="card">

<h2>Edit Post</h2>


<form action="/dashboard/posts/update?id=<?= $post['id'] ?>"method="POST">

<label>
    Title
</label>

<br>

<input
    type="text"
    name="title"
    value="<?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>"
    required
>

<br><br>

<label>
    Slug
</label>

<br>

<input
    type="text"
    name="slug"
    value="<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8') ?>"
>

<br><br>

<label>
    Status
</label>

<br>

<select name="status">

    <option
        value="draft"
        <?= $post['status'] === 'draft' ? 'selected' : '' ?>
    >
        Draft
    </option>

    <option
        value="published"
        <?= $post['status'] === 'published' ? 'selected' : '' ?>
    >
        Published
    </option>

</select>

<br><br>

<label>
    Content
</label>

<br>

<textarea
    name="content"
    rows="15"
><?= htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?></textarea>

<br><br>

<input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
>

<button type="submit">
    Save Changes
</button>



</form>

</div>