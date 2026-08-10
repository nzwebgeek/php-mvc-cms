<style>
:root {

    --theme-color:
    <?= htmlspecialchars($user['theme_color'] ?? '#007bff') ?>;

    --background-color:
    <?= htmlspecialchars($user['background_color'] ?? '#ffffff') ?>;

    --text-color:
    <?= htmlspecialchars($user['text_color'] ?? '#000000') ?>;

}

.dashboard-page {

    background-color: var(--background-color);
    color: var(--text-color);

}

.card h2 {

    color: var(--theme-color);

}

button {

    background-color: var(--theme-color);
    color: white;
    border: none;
    cursor: pointer;

}

.home-btn{
    background-color: var(--theme-color);
    color: white;
    border: none;
    cursor: pointer;
}
</style>

<main class="dashboard-page">

<?php if(isset($_SESSION['message'])): ?>

<div class="message">

    <?= htmlspecialchars($_SESSION['message']) ?>

</div>


<?php unset($_SESSION['message']); ?>

<!--Nothing Showing here-->
<?php endif; ?>

<header class="dashboard-header">

<div>

    <h1>
        Dashboard
    </h1>


    <p>
        Manage your account settings and profile
    </p>


</div>

<div>

    <a href="/" class="home-btn">
        View Website ↗
    </a>

</div>

<div class="welcome">

    <h2>
        Welcome,
        <?= htmlspecialchars($user['username']) ?>
        👋
    </h2>

    <p>
        <?= date('l, F j, Y') ?>
    </p>

</div>

</header>

<div class="dashboard-grid">

<?php include __DIR__ . '/../partials/dashboard-sidebar.php'; ?>

<section class="dashboard-content">

<?php if ($panel === 'theme'): ?>

<div class="card">

<h2>
    Theme Colours
</h2>

<p>
    Customize your dashboard colours.
</p>
<form
    action="/dashboard/save-theme"
    method="POST"
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

    <h3>
        Theme Colours
    </h3>

    <label for="theme_color">
        Theme Colour
    </label>

    <input
        type="color"
        id="theme_color"
        name="theme_color"
        value="<?= htmlspecialchars(
            $user['theme_color'] ?? '#007bff',
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <br><br>

    <label for="background_color">
        Background Colour
    </label>

    <input
        type="color"
        id="background_color"
        name="background_color"
        value="<?= htmlspecialchars(
            $user['background_color'] ?? '#ffffff',
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <br><br>

    <label for="text_color">
        Text Colour
    </label>

    <input
        type="color"
        id="text_color"
        name="text_color"
        value="<?= htmlspecialchars(
            $user['text_color'] ?? '#000000',
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <br><br>

    <button type="submit">
        Save Colours
    </button>

</form>

</div>

<?php elseif ($panel === 'upload'): ?>

<div class="card">

<h2>
Upload Profile Image
</h2>

<p>
Choose a new profile picture.
</p>

<form
    action="/dashboard/upload-image"
    method="POST"
    enctype="multipart/form-data"
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
        type="file"
        name="image"
        accept="image/*"
        required
    >

    <button type="submit">
        Upload Image
    </button>

</form>

</div>


<?php elseif ($panel === 'posts'): ?>
<!-- POSTS PANEL -->

<?php if ($action === 'create'): ?>

<h2>
    Create New Post
</h2>


<form
action="/dashboard/posts/store"
method="POST"
>

 <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
    >

<label>
Title
</label>

<br>

<input
type="text"
name="title"
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
>
<input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
>

<input
    type="text"
    name="title"
    required
>

<input
    type="text"
    name="slug"
>
<br><br>

<label>
Status
</label>
<br>

<select name="status">

<option value="draft">
Draft
</option>

<option value="published">
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
rows="10"
></textarea>


<br><br>


<button type="submit">
Create Post
</button>


<a href="/dashboard?panel=posts">
Cancel
</a>


</form>


<?php endif; ?>

<div class="card">


<div class="card-header">


<h2>
My Posts
</h2>


<a href="/dashboard?panel=posts&action=create" class="btn">
    + New Post
</a>

</div>

<?php if(empty($posts)): ?>

<p>
You haven't written any posts yet.
</p>

<?php else: ?>

<?php foreach($posts as $post): ?>

<article>

<h3>

<?= htmlspecialchars($post['title']) ?>

</h3>

<p>

Status:

<?= htmlspecialchars(ucfirst($post['status'])) ?>

</p>

<a href="/dashboard?panel=posts&edit=<?= $post['id'] ?>">

Edit

</a>

</article>

<hr>

<?php endforeach; ?>

<?php endif; ?>

<?php if ($editPost): ?>

<hr>

<h2>
    Edit Post
</h2>

<form
action="/dashboard/posts/update?id=<?= $editPost['id'] ?>"
method="POST"
>
 <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
    >
<label>
Title
</label>

<br>

<input
type="text"
name="title"
value="<?= htmlspecialchars($editPost['title']) ?>"
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
value="<?= htmlspecialchars($editPost['slug']) ?>"
>

<br><br>

<label>
Status
</label>

<br>

<select name="status">

<option value="draft"
<?= $editPost['status'] === 'draft' ? 'selected' : '' ?>
>
Draft
</option>




<option value="published"
<?= $editPost['status'] === 'published' ? 'selected' : '' ?>
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
><?= htmlspecialchars($editPost['content']) ?></textarea>



<br><br>




<button type="submit">

Save Changes

</button>
<a href="/dashboard?panel=posts">
Cancel
</a>


</form>



<?php endif; ?>



</div>

<?php elseif ($panel === 'password'): ?>


<div class="card">


<h2>
Change Password
</h2>


<form
action="/dashboard/change-password"
method="POST"
>
 <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
    >

<label>
Current Password
</label>

<br>

<input
type="password"
name="current_password"
required
>


<br><br>


<label>
New Password
</label>

<br>

<input
type="password"
name="new_password"
required
>


<br><br>


<label>
Confirm New Password
</label>

<br>

<input
type="password"
name="confirm_password"
required
>
<br><br>
<button type="submit">
Update Password
</button>


</form>
</div>
<?php else: ?>
<!-- DEFAULT DASHBOARD -->
<div class="card">

<h2>
Profile Overview
</h2>

<p>
This is your personal dashboard where you can:
</p>

<ul>

<li>
✔ Change your password
</li>

<li>
✔ Upload a profile picture
</li>

<li>
✔ Customise your colours
</li>

<li>
✔ Edit homepage posts
</li>
</ul>

</div>

<div class="card">

<div class="card-header">
<h2>
Recent Posts
</h2>
<a href="/dashboard?panel=posts" class="btn">
Manage Posts
</a>

</div>

<?php if(empty($posts)): ?>

<p>
You haven't written any posts yet.
</p>

<?php else: ?>

<table class="dashboard-table">

<thead>

<tr>

<th>
Title
</th>

<th>
Status
</th>

<th>
Created
</th>

<th>
Actions
</th>

</tr>

</thead>

<tbody>

<?php foreach($posts as $post): ?>

    <tr>

<td>

<?= htmlspecialchars($post['title']) ?>

</td>

<td>

<?= htmlspecialchars(ucfirst($post['status'])) ?>

</td>

<td>

<?= date('d M Y', strtotime($post['created_at'])) ?>

</td>

<td>

<a href="/dashboard?panel=posts&edit=<?= $post['id'] ?>">

Edit

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<?php endif; ?>

</div>

<?php endif; ?>

</section>

</div>

</main>