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
        value="<?= htmlspecialchars($post['title']) ?>"
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
        value="<?= htmlspecialchars($post['slug']) ?>"
    >


    <br><br>


    <label>
        Status
    </label>

    <br>


    <select name="status">

        <option value="draft"
            <?= $post['status'] === 'draft' ? 'selected' : '' ?>>
            Draft
        </option>


        <option value="published"
            <?= $post['status'] === 'published' ? 'selected' : '' ?>>
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
    ><?= htmlspecialchars($post['content']) ?></textarea>


    <br><br>


    <button type="submit">
        Save Changes
    </button>


</form>

</div>